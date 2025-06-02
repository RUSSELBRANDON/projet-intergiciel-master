<?php

namespace App\Http\Controllers\Usecases\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequests\CreateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Russel\Communicationservice\Contracts\ServiceCommunicatorInterface;

class UserController extends Controller
{
    public function register(CreateUserRequest $request, ServiceCommunicatorInterface $communicator){

        $validatedData = $request->validated();
        DB::beginTransaction();

        try {

            $user = User::create($request->validated());
            $response = $communicator->call(
            service: 'AUTH-service',
            method: 'post',
            endpoint: '/api/auth/register',
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
}
