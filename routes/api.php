<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::name('greencycle.')
->group(function (): void {
    Route::post('register', [AuthController::class, 'register'])
        ->middleware('throttle:5,1')
        ->name('register');

    Route::post('login', [AuthController::class, 'login'])
        ->middleware('throttle:5,1')
        ->name('login');

    Route::middleware('auth:sanctum')->group(function (): void {
        Route::get('user', [AuthController::class, 'me'])
            ->name('user');

        Route::post('logout', [AuthController::class, 'logout'])
            ->name('logout');

    });
});
