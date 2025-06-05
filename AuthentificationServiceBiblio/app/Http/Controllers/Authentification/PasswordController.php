<?php

namespace App\Http\Controllers\Authentification;

use App\Http\Controllers\Controller;
use App\Models\PasswordResetToken;
use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PasswordController extends Controller
{
   public function sendVerificationCode(Request $request)
    {
        $validator = Validator::make($request->all(), ['email' => 'required|email|max:255']);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }
    
        $verification_code = Str::random(6);
        PasswordResetToken::updateOrInsert(
            ['email' => $request->email],
            [
                'token' => $verification_code,
                'created_at' => Carbon::now(),
            ]
        );
    
        $user = User::where('email', $request->email)->firstOrFail();
        $user->notify(new ResetPasswordNotification($verification_code));
    
        return response()->json(['message' => 'code de verification envoyé avec succès'], 200);
    }


    public function verifyCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'code' => 'required|max:6|min:6'
        ]);
    
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }
    
        $password_reset = PasswordResetToken::where('email', $request->email)
            ->where('token', $request->code)
            ->firstOrFail();
    
        if (!$password_reset || Carbon::parse($password_reset->created_at)->addMinutes(60)->isPast()) {
            return response()->json(['message' => 'code de verification invalide ou expire'], 422);
        }
    
        return response()->json(['message' => 'code de verification valide', 'token' => $password_reset->token], 200);    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'token' => 'required',
            'new_password' => 'required|min:4|string'
        ]);
    
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }
    
        $password_reset = PasswordResetToken::where('email', $request->email)
            ->where('token', $request->token)
            ->first();
    
        if (!$password_reset || Carbon::parse($password_reset->created_at)->addMinutes(60)->isPast()) {
            return response()->json(['message' => 'jeton de verification invalide ou expire'], 422);
        }
    
        $user = User::where('email', $request->email)->firstOrFail();
        $user->password = Hash::make($request->new_password);
        $user->save();
    
        PasswordResetToken::where('email', $request->email)->delete();
    
        return response()->json(['message' => 'mot de passe modifié avec succès'], 200);
    }
}
