<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Russel\FileUpload\FileUploadService;
 use Russel\FileUpload\Facades\FileUpload;
 use Russel\FileUpload\Enums\FilePath;


class UserController extends Controller
{
    public function show()
    {
        $user= Auth::user();

        return response()->json([
            'name' => $user->name,
            'email' => $user->email,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
            'profile_image' => $user->profile_image ? $user->profile_image : null, 
        ], 200);
    }


    public function update(UpdateUserRequest $request)
    {
        $user= Auth::user();
    
        $validatedData = $request->validated();
    
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
    
        $user->save();
    
        return response()->json(['message' => 'Profil mis à jour avec succès.', 'user' => $user], 200);
    }
    
    public function updateProfileImage(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()]);
        }
    
        $user= Auth::user();

        if ($user->profile_image) {

             FileUpload::deleteFile($user->profile_image);
        }

        $path = FilePath::PROFILE_IMAGES;
        $user->profile_image = FileUpload::uploadFile ($request->file('image'), $path);    
        $user->save();
    
        return response()->json(['message' => 'Image de profil mise à jour avec succès!', 'image_path' => $user->profile_image], 200);
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'new_password' => 'required|string|min:4',
        ]);

        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()]);
        }
    
        $user= Auth::user();
        $user->password = $request->new_password;
        $user->save();
    
        return response()->json(['message' => 'Mot de passe mis à jour avec succès.'], 200);
    }
    
}
