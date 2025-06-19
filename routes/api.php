<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EventController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('events', EventController::class);

    Route::post('/events/{event}/register', [EventController::class, 'register']);
    Route::delete('/events/{event}/cancel', [EventController::class, 'cancelRegistration']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
