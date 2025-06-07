<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\CreateStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use Russel\Communicationservice\Contracts\ServiceCommunicatorInterface;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;


class StudentController extends Controller
{

    public function __construct(
        private ServiceCommunicatorInterface $communicator
    ) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $student = User::all();
        return response()->json($student);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateStudentRequest $request, ServiceCommunicatorInterface $communicator)
    {
        $validatedData = $request->validated();
        Log::info('Données validées pour créer un étudiant', ['data' => $validatedData]);

        DB::beginTransaction();

        try {
            Log::info('Tentative de création de l\'utilisateur dans studentManagement', ['data' => $validatedData]);
            $student = User::create($validatedData);
            Log::info('Utilisateur créé localement', ['student_id' => $student->id, 'student' => $student->toArray()]);

            $token = $request->bearerToken();
            if (!$token) {
                Log::error('Jeton d\'authentification manquant dans la requête');
                throw new \Exception('Jeton d\'authentification manquant dans la requête');
            }

            Log::info('Appel à AUTH-service pour créer un utilisateur', ['endpoint' => '/api/admin/users', 'data' => $validatedData]);
            $response = $communicator->call(
                service: 'AUTH-service',
                method: 'post',
                endpoint: '/api/admin/users',
                data: $validatedData,
                headers: [
                    'Authorization' => 'Bearer ' . $token
                ]
            );

            if (!$response->successful()) {
                Log::error('Échec de l\'appel à AUTH-service', [
                    'status' => $response->status(),
                    'response' => $response->body(),
                    'data_sent' => $validatedData
                ]);
                throw new \Exception("Échec AUTH-service: " . $response->status());
            }

            Log::info('Réponse AUTH-service', ['status' => $response->status(), 'body' => $response->body()]);

            DB::commit();
            Log::info('Transaction validée, étudiant créé avec succès', ['student_id' => $student->id]);

            $responseData = [
                'message' => 'Élève créé avec succès',
                'student' => $student->toArray()
            ];
            Log::info('Réponse envoyée au frontend', ['response' => $responseData]);

            return response()->json($responseData, 201);

        } catch (ValidationException $e) {
            DB::rollBack();
            Log::error('Erreur de validation', ['errors' => $e->errors()]);
            return response()->json([
                'message' => 'Erreur de validation',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur lors de la création de l\'étudiant', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'message' => 'Erreur lors de la création',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(User $student)
    {
        return response()->json($student);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStudentRequest $request, User $student)
    {
        $validatedData = $request->validated();
        $student->name = $validatedData['name'];
        $student->sex = $validatedData['sex'];
        $student->address = $validatedData['address'];
        $student->age = $validatedData['age'];
        $student->email = $validatedData['email'];
        $student->save();
        return response()->json(['message'=>'eleve mis a jour avec succes' ,'Student'=>$student],200);
    }

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(User $student, ServiceCommunicatorInterface $communicator)
    {
        DB::beginTransaction();
    
        try {    
            $token = request()->bearerToken();
            if (!$token) {
                throw new \Exception('Jeton d\'authentification manquant dans la requête');
            }
    
            $student->delete();
    
            $response = $communicator->call(
                service: 'AUTH-service',
                method: 'delete',
                endpoint: "/api/admin/users/{$student->id}",
                data: [],
                headers: [
                    'Authorization' => 'Bearer ' . $token
                ]
            );
    
            if (!$response->successful()) {
                throw new \Exception("Échec AUTH-service: " . $response->status());
            }
    
            DB::commit();
            return response()->json(['message' => 'Eleve supprimé'], 200);
    
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Erreur lors de la suppression',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
