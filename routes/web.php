<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\RekapController;
use App\Http\Middleware\GuruAuth;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware(GuruAuth::class)->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/absensi/simpan', [AbsensiController::class, 'store'])->name('absensi.store');

    Route::prefix('rekap')->name('rekap.')->group(function () {
        Route::get('/', [RekapController::class, 'index'])->name('index');
        Route::get('/edit', [RekapController::class, 'edit'])->name('edit');
        Route::post('/update', [RekapController::class, 'update'])->name('update');
        Route::post('/hapus', [RekapController::class, 'destroy'])->name('destroy');
        Route::get('/pdf', [RekapController::class, 'cetakPdf'])->name('pdf');
    });
});
