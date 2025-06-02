<?php

namespace App\Http\Controllers\Classrooms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Classroom;
use App\Http\Requests\CreateClassroomRequest;
use App\Http\Requests\UpdateClassroomRequest;

class ClassroomController extends Controller
{
    public function index(){
        $classrooms = Classroom::all();

        return response()->json($classrooms);
    }


    public function store(CreateClassroomRequest $request){

        $validatedData = $request->validated();

        $classroom= Classroom::create($validatedData);

        return response()->json($classroom);
    }

    public function show(Classroom $classroom){
        return response()->json($classroom);
    }

    public function update(UpdateClassroomRequest $request, Classroom $classroom){

        $validatedData = $request->validated();

        $classroom->label = $validatedData['label'];
        $classroom->capacity = $validatedData['capacity'];

        $classroom->save();

        return response()->json($classroom);

    }

    public function destroy(Classroom $classroom){
        $classroom->delete();
        return response()->json(['message'=>'salle supprimer']);
    }
}
