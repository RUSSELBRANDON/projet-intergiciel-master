<?php

namespace App\Http\Controllers\Notes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\NoteRequest;
use App\Models\Note;

class NoteController extends Controller
{
    public function createNote(NoteRequest $request){
        $validatedData = $request->validated();

        $note = Note::create($validatedData);

        return response()->json($note);
    }

}
