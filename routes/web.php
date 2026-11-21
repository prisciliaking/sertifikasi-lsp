<?php

use App\Http\Controllers\Admin\UserValidationController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\GarasiController;
use App\Http\Controllers\Penyewa\SewaController;
use App\Http\Controllers\Admin\PerpanjanganController;
use App\Http\Controllers\Admin\LaporanController;

Route::get('/', fn() => redirect()->route('login'));

// Guest (Belum Login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Role Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [UserValidationController::class, 'index'])->name('users.index');
    Route::patch('/users/{user}/status', [UserValidationController::class, 'updateStatus'])->name('users.update-status');

    Route::get('/garasi', [GarasiController::class, 'index'])->name('garasi.index');
    Route::post('/garasi', [GarasiController::class, 'store'])->name('garasi.store');

    Route::get('/perpanjangan', [PerpanjanganController::class, 'index'])->name('perpanjangan.index');
    Route::get('/perpanjangan/{sewa}/edit', [PerpanjanganController::class, 'edit'])->name('perpanjangan.edit');
    Route::post('/perpanjangan/{sewa}', [PerpanjanganController::class, 'update'])->name('perpanjangan.update'); 
    
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
});

// Role Penyewa (placeholder dashboard, akan diisi fitur sewa di tahap berikutnya)
Route::middleware(['auth', 'role:penyewa'])->prefix('penyewa')->name('penyewa.')->group(function () {
    Route::get('/dashboard', [SewaController::class, 'index'])->name('dashboard');
    Route::get('/sewa/create', [SewaController::class, 'create'])->name('sewa.create');
    Route::post('/sewa', [SewaController::class, 'store'])->name('sewa.store');
    Route::get('/sewa/check-availability', [SewaController::class, 'checkAvailability'])->name('sewa.check');
});
