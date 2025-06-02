<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request; 
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller; 

class VerifyTokenController extends controller
{
    public function verifyToken(request $request)
    {
        $token = $request->input('token');
        if (! $token) {
            throw ValidationException::withMessages(['token' => 'Token is required']);
        }
        
        $tokenModel = \Laravel\Sanctum\PersonalAccessToken::findToken($token);
        if (! $tokenModel || $tokenModel->expired()) {
            throw ValidationException::withMessages(['token' => 'Invalid token']);
        }
        
        $user = $tokenModel->tokenable;
        return new JsonResponse(['user' => $user->only(['id', 'name', 'email', 'role'])]);
    }
}