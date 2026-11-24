<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

// Limiters "auth" and "api" are defined in AppServiceProvider and can be switched off at runtime.

// Strict limit on auth endpoints (brute-force protection)
Route::middleware('throttle:auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('throttle:api')->group(function () {
    // Rate limit switch state (public read)
    Route::get('/settings/rate-limit', [SettingsController::class, 'show']);

    // Public read access
    Route::get('/books', [BookController::class, 'index']);
    Route::get('/books/{book}', [BookController::class, 'show']);

    // Protected by Sanctum token middleware
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::put('/settings/rate-limit', [SettingsController::class, 'update']);
        Route::post('/books', [BookController::class, 'store']);
        Route::match(['put', 'patch'], '/books/{book}', [BookController::class, 'update']);
        Route::delete('/books/{book}', [BookController::class, 'destroy']);
    });
});
