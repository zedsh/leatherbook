<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::get('/test', [TestController::class, 'run']);
Route::post('/load', [TestController::class, 'load']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/books', [BookController::class, 'index']);
    Route::post('/books/{book}/reserve', [ReservationController::class, 'reserve']);

    Route::get('/reservations', [ReservationController::class, 'myReservations']);
});
