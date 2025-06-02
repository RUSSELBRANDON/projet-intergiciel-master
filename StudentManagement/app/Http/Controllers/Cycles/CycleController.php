<?php

namespace App\Http\Controllers\Cycles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cycle;
use App\Http\Requests\CreateCycleRequest;
use App\Http\Requests\UpdateCycleRequest;

class CycleController extends Controller
{
    public function index(){
        $cycles = Cycle::all();

        return response()->json($cycles);
    }


    public function store(CreateCycleRequest $request){

        $validatedData = $request->validated();

        $cycle= Cycle::create($validatedData);

        return response()->json($cycle);
    }

    public function show(Cycle $cycle){
        return response()->json($cycle);
    }

    public function update(UpdateCycleRequest $request, Cycle $cycle){

        $validatedData = $request->validated();

        $cycle->label = $validatedData['label'];
        $cycle->save();

        return response()->json($cycle);

    }

    public function destroy(Cycle $cycle){
        $cycle->delete();
        return response()->json(['message'=>'matiere supprimer']);
    }
}
