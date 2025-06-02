<?php

namespace App\Http\Controllers\Authentification;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class VerifyTokenController extends Controller
{
    public function verifyToken(request $request)
    {
        $token = $request->input('token');
        if (! $token) {
            throw ValidationException::withMessages(['token' => 'Token is required']);
        }
        
        $tokenModel = \Laravel\Sanctum\PersonalAccessToken::findToken($token);
        if (! $tokenModel) {
            throw ValidationException::withMessages(['token' => 'Invalid token']);
        }
        
        $user = $tokenModel->tokenable;
        return response()->json(['user' => $user->only(['id', 'username', 'email'])]);
    }
}
