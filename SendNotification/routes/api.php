<?php

use  App\Http\Controllers\NotificationController;

    Route::prefix('notification')->controller(NotificationController::class)->group(function(){
        Route::post('send', 'send');
    });