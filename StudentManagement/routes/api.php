<?php

use  App\Http\Controllers\Student\StudentController;
use  App\Http\Controllers\Notes\NoteController;
use  App\Http\Controllers\Subjects\SubjectController;
use  App\Http\Controllers\Exams\ExamController;
use  App\Http\Controllers\Cycles\CycleController;
use  App\Http\Controllers\Classrooms\ClassroomController;
use  App\Http\Controllers\Register\RegisterController;
use  App\Http\Controllers\SchoolYear\SchoolYearController;
use  App\Http\Controllers\Coef\CoefController;
use Illuminate\Support\Facades\Route;


    Route::prefix('student')->controller(StudentController::class)
    ->middleware('check_auth_and_role')
    ->group(function(){
        Route::get('index', 'index');
        Route::post('store', 'store');
        Route::get('show/{student}' ,  'show');
        Route::put('update/{student}', 'update');
        Route::delete('delete/{student}', 'destroy');
    });

    Route::prefix('subject')->controller(SubjectController::class)
    ->middleware('check_auth_and_role')
    ->group(function(){
        Route::get('index', 'index');
        Route::post('store', 'store')->middleware('check_auth_and_role:admin');
        Route::get('show/{subject}' ,  'show');
        Route::put('update/{subject}', 'update')->middleware('check_auth_and_role:admin');
        Route::delete('delete/{subject}', 'destroy')->middleware('check_auth_and_role:admin');
    });

    Route::prefix('exam')->controller(ExamController::class)
    ->middleware('check_auth_and_role')
    ->group(function(){
        Route::get('index', 'index');
        Route::post('store', 'store');
        Route::get('show/{exam}' ,  'show');
        Route::put('update/{exam}', 'update');
        Route::delete('delete/{exam}', 'destroy');
    });

    Route::prefix('cycle')->controller(CycleController::class)
    ->middleware('check_auth_and_role')
    ->group(function(){
        Route::get('index', 'index');
        Route::post('store', 'store');
        Route::get('show/{cycle}' ,  'show');
        Route::put('update/{cycle}', 'update');
        Route::delete('delete/{cycle}', 'destroy');
    });

    Route::prefix('classroom')->controller(ClassroomController::class)
    ->middleware('check_auth_and_role')
    ->group(function(){
        Route::get('index', 'index');
        Route::post('store', 'store');
        Route::get('show/{classroom}' ,  'show');
        Route::put('update/{classroom}', 'update');
        Route::delete('delete/{classroom}', 'destroy');
    });

    Route::prefix('year')->controller(SchoolYearController::class)
    ->middleware('check_auth_and_role')
    ->group(function(){
        Route::get('index', 'index');
        Route::post('addYear', 'addYear');
        Route::put('updateYear/year}', 'updateYear');
    });

    Route::prefix('student')->controller(NoteController::class)->group(function(){
        Route::post('createNote', 'createNote')->middleware('check_auth_and_role');
    });

    Route::prefix('student')->controller(RegisterController::class)
    ->middleware('check_auth_and_role')
    ->group(function(){
        Route::post('addRegisterStudent', 'addRegisterStudent');
        Route::delete('deleteRegisterStudent', 'deleteRegisterStudent');

    });

    Route::prefix('coef')->controller(CoefController::class)->group(function(){
       Route::post('addCoefToSubject', 'addCoefToSubject')->middleware('check_auth_and_role');

    });