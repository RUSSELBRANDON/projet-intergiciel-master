<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CreateStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use Russel\Communicationservice\Contracts\ServiceCommunicatorInterface;
use App\Models\User;
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
    public function store(CreateStudentRequest $request)
    {
        $validatedData = $request->validated();
    
        $response = $this->communicator->call(
            service: 'AUTH-service',
            method: 'post',
            endpoint: '/api/admin/users',
            data: $validatedData,
            headers: ['Authorization' => 'Bearer ' . $request->bearerToken()]
        );

    
        if (!$response->successful()) {

            if (!Gate::allows('isAdmin', session('user'))) {
                return response()->json(['message' => 'Forbidden'], 403);
            }
            
            return response()->json([
                'message' => 'Échec de la création dans le service AUTH',
                'errors' => $response->json()
            ], $response->status());
        }
            $teacher = User::create($validatedData);
            
            return response()->json([
                'message' => 'ELeve créé avec succès',
                'teacher' => $teacher,
            ], 201);
    }

    /**
     * Display the specified resource.
     */
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
        return response()->json(['message'=>'enseignant mis a jour avec succes' ,'Student'=>$student],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $student)
    {
        $student->delete();
        return response()->json(['enseignant supprimer'],200);
    }
}
