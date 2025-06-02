<?php

namespace App\Http\Controllers\Exams;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exam;
use App\Http\Requests\CreateExamRequest;
use App\Http\Requests\UpdateExamRequest;


class ExamController extends Controller
{
    public function index(){
        $exam = Exam::all();

        return response()->json($exam);
    }


    public function store(CreateExamRequest $request){

        $validatedData = $request->validated();

        $exam= Exam::create($validatedData);

        return response()->json($exam);
    }

    public function show(Exam $exam){
        return response()->json($exam);
    }

    public function update(UpdateExamRequest $request, Exam $exam){

        $validatedData = $request->validated();

        $exam->label = $validatedData['label'];
        $exam->save();

        return response()->json($exam);

    }

    public function destroy(Exam $exam){
        $exam->delete();
        return response()->json(['message'=>'matiere supprimer']);
    }
}
