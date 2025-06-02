<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\loginRequest;
use App\Models\User;
use App\Models\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{


    public function login(loginRequest $request)
    {
        $validatedData = $request->validated();

        $user = User::where('email', $validatedData['email'])->first();

        if (!Hash::check($validatedData['password'], $user->password)) {
            return response()->json(['message' => 'Mot de passe incorrect'], 401);
        }
    
        $token = $user->createToken('authToken')->plainTextToken;

        Session::create([
            'user_id'=>$user->id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
            'payload' => base64_encode(serialize(session()->all())),
            'last_activity' => now()->timestamp,
        ]);


        return response()->json([
            'message' => 'Accès autorisé',
            'token' => $token,
            'type_token' => 'Bearer',
            'username' => $user->name
        ], 200);
    }

    public function loginHistory(User $user)
    {
        $sessions = $user->sessions;

         return response()->json($sessions);
    }

    public function logout()
    {
        $user = Auth::user();
    
        $user->tokens()->delete();
    
        return response()->json(['message' => 'Déconnexion réussie'], 200);
    }

    public function getToken()
    {
        $currentToken = auth()->user()->currentAccessToken();
    
        if (!$currentToken) {
            return response()->json([
                'message' => 'Aucun token actif trouvé pour cette session'
            ], 404);
        }
    
        return response()->json(['token' => $currentToken->token]);
    }

}
