<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use Illuminate\Support\Str;
use App\Notifications\NewAccountNotification;


class AdminController extends Controller
{
    public function createUser(CreateUserRequest $request)
    {
        $validatedData = $request->validated();
        $tempPassword = Str::random(8);
        $validatedData['password'] = $tempPassword;
        $user = User::create($validatedData);

        $user->notify(new NewAccountNotification($tempPassword));

        return response()->json([
            'message' => 'Utilisateur créé avec succès',
            'user' => $user
        ]);
    }

    // Suppression d'utilisateur
    public function deleteUser(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'Utilisateur supprimé avec succès']);
    }
}
