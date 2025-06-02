<?php

namespace App\Http\Controllers\SchoolYear;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Year;


class SchoolYearController extends Controller
{
    public function index(){
        $years = Year::all();
        return response()->json($years);
    }

    public function addYear(Request $request){
        $validator = Validator::make($request->all(),['school_year'=>'required|string|unique:years,school_year']);
        if($validator->fails()){  return response()->json(['message'=>$validator->errors()]);  }
        $year = Year::create(['school_year'=>$request->school_year]);
        return response()->json($year);
    }

    public function updateYear(Request $request, Year $year){
        $validator = Validator::make($request->all(),['school_year'=>'required|string']);
        if($validator->fails()){  return response()->json(['message'=>$validator->errors()]);  }
        $year->school_year = $request->school_year;
        $year->save();
        return response()->json($year);
    }

}
