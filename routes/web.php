<?php

use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\BookingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/schedules/{id}', [HomeController::class, 'detail'])->name('schedule.detail');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/my-bookings', [BookingController::class, 'index'])->name('my-bookings');
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');  // ← Tambah ini
    Route::delete('/booking/{id}', [BookingController::class, 'cancel'])->name('booking.cancel');
});