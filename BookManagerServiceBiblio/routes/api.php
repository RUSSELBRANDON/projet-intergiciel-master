<?php

use App\Http\Controllers\Ressources\Book\BookController;
use App\Http\Controllers\Usecases\Borrow\BorrowController;
use App\Http\Controllers\Usecases\BorrowingRequest\BorrowingRequestController;
use App\Http\Controllers\Usecases\User\BookController as UserBookController;
use App\Http\Controllers\Usecases\User\UserController;
use Illuminate\Support\Facades\Route;


 Route::prefix('ressources')->group(function () {
    //toutes les routes des ressources

    Route::prefix('book')
    ->controller(BookController::class)
    ->middleware('check_auth')
    ->group(function(){
        Route::get('index', 'index');
        Route::post('store', 'store');
        Route::get('show/{book}', 'show');
        Route::put('update/{book}', 'update');
        Route::delete('delete/{book}', 'destroy');
    });
});

Route::prefix('usecases')->group(function () {
    //toutes les routes des usecases
    
    Route::prefix('user')->controller(UserController::class)->group(function(){
        Route::post('register', 'register');
    });
     
    Route::prefix('borrow')
    ->controller(BorrowController::class)
     ->middleware('check_auth')
    ->group(function(){
        Route::get('getborrows','getAllBorrows');
        Route::post('createloan/{borrower}/{book}', 'createLoan');
        Route::post('updateloan/{borrow}', 'updateLoan');
        Route::post('terminateloan/{borrow}', 'terminateALoan');
        Route::delete('deleteloan/{borrow}', 'deleteLoan');
     });
    
     Route::prefix('user')
    ->controller(UserBookController::class)
     ->middleware('check_auth')
    ->group(function(){
        Route::get('getbooks/{user}', 'getAllBooks');
     });
    
     Route::prefix('notification')
    ->controller(BorrowingRequestController::class)
     ->middleware('check_auth')
    ->group(function(){
        Route::post('loanrequest/{book}/{requester}', 'makeLoanRequest');
        Route::post('replyrequest/{owner}/{borrowingRequest}', 'replyForRequest');
    
     });
});


