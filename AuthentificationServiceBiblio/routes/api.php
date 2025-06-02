<?php

use App\Http\Controllers\Authentification\AuthController;
use App\Http\Controllers\Authentification\PasswordController;
use App\Http\Controllers\Authentification\VerifyTokenController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->middleware(['api'])->controller(AuthController::class)->group(function(){
        Route::post('register' ,  'register');
        Route::get('email/verify/{data}', 'verify')->name('verification.verify');
        Route::post('login' ,  'login');
    });

 Route::prefix('auth')->middleware(['auth:sanctum'])->controller(AuthController::class)->group(function(){
        Route::post('logout' ,  'logout');
    });

 Route::post('/verify-token', [VerifyTokenController::class, 'verifyToken'])->middleware('verify-secret');

Route::prefix('password')->middleware(['api'])->controller(PasswordController::class)->group(function(){
    Route::post('sendCode' , 'sendVerificationCode');
    Route::post('verificationCode' , 'verifyCode');
    Route::post('reset' , 'resetPassword');
});


