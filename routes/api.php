<?php

use App\Http\Controllers\AuthController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json(['message' => 'health check ok']);
});

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
});

Route::middleware(JwtMiddleware::class)->group(function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('refresh', [AuthController::class, 'refresh']);
    });
});
