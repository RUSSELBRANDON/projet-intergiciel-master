<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Note;
use App\Models\User;

class NoteController extends Controller
{
    public function addNote(Request $request, User $student){

        $validator = Validator::make($request->all(),['note'=>'required|integer|min:0|max:20']);
        if($validator->fails()){
            return response()->json(['message'=>$validator->errors()]);
        }
        $note= Note::create(['note'=>$request->note]);
        $student->note()->associate($note);

        return response()->json(['message'=>'note ajouter avec succes', 'user'=>$student]);
    }
}
