<?php

namespace App\Http\Controllers\Coef;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CoefRequest;
use App\Models\ClassroomSubject;

class CoefController extends Controller
{
    public function addCoefToSubject(CoefRequest $request){

        $validatedData = $request->validated();
        $result = ClassroomSubject::where('subject_id', $validatedData['subject_id'])
                          ->where('classroom_id',$validatedData['classroom_id'])
                          ->exists();
        if($result){
            return response()->json(['message'=>'cette matiere a deja un coeficient']);
        }

        $coef = ClassroomSubject::create($validatedData);
        return response()->json($coef);
        

    }
}
