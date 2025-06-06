<?php

use  App\Http\Controllers\Teacher\TeacherController;
use  App\Http\Controllers\Subjects\SubjectController;
use  App\Http\Controllers\Classroom\ClassroomController;
use  App\Http\Controllers\Courses\CourseController;
use  App\Http\Controllers\Coef\CoefController;
use Illuminate\Support\Facades\Route;


    Route::prefix('teacher')->controller(TeacherController::class)
    ->middleware('check_auth')
    ->group(function(){
        Route::get('index', 'index');
        Route::post('store', 'store');
        Route::get('show/{teacher}' ,  'show');
        Route::put('update/{teacher}', 'update');
        Route::delete('delete/{teacher}', 'destroy'); //->middleware('check_auth:admin');
    });

    Route::prefix('subject')->controller(SubjectController::class)
   // ->middleware('check_auth')
    ->group(function(){
        Route::get('index', 'index');
        Route::post('store', 'store');
        Route::get('show/{subject}' ,  'show');
        Route::put('update/{subject}', 'update');
        Route::delete('delete/{subject}', 'destroy');
    });

    Route::prefix('classroom')->controller(ClassroomController::class)
    //->middleware('check_auth')
    ->group(function(){
        Route::get('index', 'index');
        Route::post('store', 'store');
        Route::get('show/{classroom}' ,  'show');
        Route::put('update/{classroom}', 'update');
        Route::delete('delete/{classroom}', 'destroy');
    });

    Route::prefix('course')->controller(CourseController::class)
   // ->middleware('check_auth')
    ->group(function(){
        Route::get('index', 'index');
        Route::post('store', 'store');
        Route::put('update/{course}', 'update');
        Route::delete('delete/{course}', 'destroy');
    });

    Route::prefix('coef')->controller(CoefController::class)->middleware('check_auth')->group(function(){
        Route::post('addCoefToSubject', 'addCoefToSubject');
     });