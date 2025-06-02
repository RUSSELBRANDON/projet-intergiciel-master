<?php

namespace App\Http\Controllers\Subjects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subject;
use App\Http\Requests\CreateSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;

class SubjectController extends Controller
{
    public function index(){
        $subjects = Subject::all();

        return response()->json($subjects);
    }


    public function store(CreateSubjectRequest $request){

        $validatedData = $request->validated();

        $subject= Subject::create($validatedData);

        return response()->json($subject);
    }

    public function show(subject $subject){
        return response()->json($subject);
    }

    public function update(UpdateSubjectRequest $request, Subject $subject){

        $validatedData = $request->validated();

        $subject->label = $validatedData['label'];

        $subject->save();

        return response()->json($subject);

    }

    public function destroy(Subject $subject){
        $subject->delete();
        return response()->json(['message'=>'matiere supprimer']);
    }
}
