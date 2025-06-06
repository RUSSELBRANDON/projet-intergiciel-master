<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Users\UserController;
use App\Http\Controllers\Auth\VerifyTokenController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['auth:sanctum']] , function(){
    Route::prefix('auth')->controller(AuthController::class)->group(function(){
        Route::post('logout' ,  'logout');
        Route::get('loginHistory/{user}', 'loginHistory');
        Route::post('getToken' ,  'getToken');
    });

});

// Route::middleware('auth:sanctum')->get('/validate-token', function (Request $request) {
//     return response()->json([
//         'user' => $request->user()->only('id', 'email', 'role')
//     ]);
// });

 Route::post('/verify-token', [VerifyTokenController::class, 'verifyToken'])->middleware('verify-secret');

Route::group(['middleware' => ['auth:sanctum']] , function(){
    Route::prefix('user')->controller(UserController::class)->group(function(){
        Route::get('profile' ,  'show');
        Route::put('profile/update', 'update');
        Route::post('profile/update/image', 'updateProfileImage');
        Route::put('profile/update/password', 'changePassword');
    });

});

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::post('/admin/users', [AdminController::class, 'createUser']);
    Route::delete('/admin/users/{user}', [AdminController::class, 'deleteUser']);
});

Route::prefix('auth')->controller(AuthController::class)->group(function(){
    Route::post('login' ,  'login');
});



Route::prefix('auth')->middleware(['api'])->controller(PasswordController::class)->group(function(){
    Route::post('/password/sendCode' , 'sendVerificationCode');
    Route::post('/password/verificationCode' , 'verifyCode');
    Route::post('/password/reset' , 'resetPassword');
});


