<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\ScheduleController;
use Illuminate\Support\Facades\Route;

// ========== GUEST MODE (Tanpa Auth) ==========
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/schedules', [ScheduleController::class, 'index']);
Route::get('/schedules/{id}', [ScheduleController::class, 'show']);

// ========== AUTH MODE (Harus Login) ==========
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    Route::post('/bookings', [BookingController::class, 'store']);
    Route::get('/bookings/me', [BookingController::class, 'myBookings']);
    Route::delete('/bookings/{id}', [BookingController::class, 'cancel']);
});