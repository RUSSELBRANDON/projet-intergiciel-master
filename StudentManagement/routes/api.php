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



    Route::prefix('student')->controller(StudentController::class)->group(function(){
        Route::get('index', 'index');
        Route::post('store', 'store');
        Route::get('show/{student}' ,  'show');
        Route::put('update/{student}', 'update');
        Route::delete('delete/{student}', 'destroy')->middleware('check_auth_and_role:admin');
    });

    Route::prefix('subject')->controller(SubjectController::class)->group(function(){
        Route::get('index', 'index');
        Route::post('store', 'store');
        Route::get('show/{subject}' ,  'show');
        Route::put('update/{subject}', 'update');
        Route::delete('delete/{subject}', 'destroy')->middleware('check_auth_and_role:admin');
    });

    Route::prefix('exam')->controller(ExamController::class)->group(function(){
        Route::get('index', 'index');
        Route::post('store', 'store');
        Route::get('show/{exam}' ,  'show');
        Route::put('update/{exam}', 'update');
        Route::delete('delete/{exam}', 'destroy')->middleware('check_auth_and_role:admin');
    });

    Route::prefix('cycle')->controller(CycleController::class)->group(function(){
        Route::get('index', 'index');
        Route::post('store', 'store');
        Route::get('show/{exam}' ,  'show');
        Route::put('update/{exam}', 'update');
        Route::delete('delete/{exam}', 'destroy')->middleware('check_auth_and_role:admin');
    });

    Route::prefix('classroom')->controller(ClassroomController::class)->group(function(){
        Route::get('index', 'index');
        Route::post('store', 'store');
        Route::get('show/{exam}' ,  'show');
        Route::put('update/{exam}', 'update');
        Route::delete('delete/{exam}', 'destroy')->middleware('check_auth_and_role:admin');
    });

    Route::prefix('year')->controller(SchoolYearController::class)->group(function(){
        Route::get('index', 'index');
        Route::post('addYear', 'addYear');
        Route::put('updateYear/{exam}', 'updateYear')->middleware('check_auth_and_role:admin');
    });

    Route::prefix('student')->controller(NoteController::class)->group(function(){
        Route::post('createNote', 'createNote')->middleware('check_auth_and_role:teacher');
    });

    Route::prefix('student')->controller(RegisterController::class)->group(function(){
        Route::post('addRegisterStudent', 'addRegisterStudent');
        Route::delete('deleteRegisterStudent', 'deleteRegisterStudent')->middleware('check_auth_and_role:admin');

    });

    Route::prefix('coef')->controller(CoefController::class)->group(function(){
       Route::post('addCoefToSubject', 'addCoefToSubject')->middleware('check_auth_and_role:admin');

    });