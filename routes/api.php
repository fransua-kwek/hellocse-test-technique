<?php

use App\Http\Controllers\AuthController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Profiles\CreateProfile;
use App\Http\Controllers\Profiles\DeleteProfile;
use App\Http\Controllers\Profiles\UpdateProfile;
use App\Http\Controllers\Profiles\GetProfiles;

Route::get('/', function () {
    return response()->json(['message' => 'health check ok']);
});

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
});

Route::get('profiles', GetProfiles::class);

Route::middleware(JwtMiddleware::class)->group(function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('refresh', [AuthController::class, 'refresh']);
    });

    Route::group(['prefix' => 'profiles'], function () {
        Route::post('/', [CreateProfile::class]);
        Route::delete('/{id}', [DeleteProfile::class])->where('id', '[0-9]+');
        Route::post('/{id}', [UpdateProfile::class])->where('id', '[0-9]+');
    });
});
