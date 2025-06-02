<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTeacherRequest;
use App\Http\Requests\UpdateTeacherRequest;
use Russel\Communicationservice\Contracts\ServiceCommunicatorInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;


use App\Models\User;

class TeacherController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teacher = User::all();
        return response()->json($teacher);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateTeacherRequest $request, ServiceCommunicatorInterface $communicator){

        $validatedData = $request->validated();
        DB::beginTransaction();

        try {

            $user = User::create($request->validated());
            $response = $communicator->call(
            service: 'AUTH-service',
            method: 'post',
            endpoint: '/api/admin/users',
            data: $validatedData,
            headers: []);
    
            if (!$response->successful()) {
                throw new \Exception("Échec AUTH-service: " . $response->status());
            }
    
            DB::commit();
            return response()->json(['user' => $user], 201);
    
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Erreur lors de la création',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTeacherRequest $request, User $teacher)
    {
        $validatedData = $request->validated();
        $teacher->name = $validatedData['name'];
        $teacher->email = $validatedData['email'];
        $teacher->save();
        return response()->json(['message'=>'enseignant mis a jour avec succes' ,'teacher'=>$teacher],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $teacher, ServiceCommunicatorInterface $communicator)
    {
        DB::beginTransaction();

        try {

            $teacher->delete();
            $response = $communicator->call(
            service: 'AUTH-service',
            method: 'post',
            endpoint: '/api/admin/users/{user}',
            data:[],
            headers: []);
    
            if (!$response->successful()) {
                throw new \Exception("Échec AUTH-service: " . $response->status());
            }
    
            DB::commit();
                    return response()->json(['enseignant supprimer'],200);
    
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Erreur lors de la suppression',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
