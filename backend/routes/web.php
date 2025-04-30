<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\AuthController;

Route::middleware('web')->group(function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/forgotPassword', [AuthController::class, 'forgotPassword']);
        
        Route::middleware('auth:sanctum')->group(function () {
            Route::get('/logout', [AuthController::class, 'logout']);
        });
    });
});

