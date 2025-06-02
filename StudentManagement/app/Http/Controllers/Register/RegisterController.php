<?php

namespace App\Http\Controllers\Register;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{
    public function addRegisterStudent(RegisterRequest $request){

        $validatedData = $request->validated();
        $result = Register::where('user_id', $validatedData['user_id'])
                          ->where('classroom_id',$validatedData['classroom_id'])
                          ->where('school-year_id', $validatedData['school-year_id'])
                          ->exists();
        if($result){
            return response()->json(['message'=>'etudiant deja enregistrer']);
        }

        $registerStudent = Register::create([$validatedData]);
        return response()->json($registerStudent);
    }

    public function deleteRegisterStudent(Register $register){
        $register->delete();
        return response()->json(['message'=>'enregistrement supprimer']);
    } 
}
