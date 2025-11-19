<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JadwalRegulerController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\PeminjamanController;

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Manajemen User - Hanya Administrator
    Route::prefix('users')->name('users.')->middleware('role:administrator')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{user}', [UserController::class, 'show'])->name('show');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
    });
    
    // Ruangan
    Route::prefix('ruangan')->name('ruangan.')->middleware('role:administrator,petugas')->group(function () {
        Route::get('/', [RuanganController::class, 'index'])->name('index');
        
        
        Route::middleware('role:administrator')->group(function () {
            Route::get('/create', [RuanganController::class, 'create'])->name('create');
            Route::post('/', [RuanganController::class, 'store'])->name('store');
            Route::get('/{ruangan}/edit', [RuanganController::class, 'edit'])->name('edit');
            Route::put('/{ruangan}', [RuanganController::class, 'update'])->name('update');
            Route::delete('/{ruangan}', [RuanganController::class, 'destroy'])->name('destroy');
            Route::get('/{ruangan}', [RuanganController::class, 'show'])->name('show');
        });
    });
    
    // Peminjaman
    Route::prefix('peminjaman')->name('peminjaman.')->group(function () {

        Route::get('/', [PeminjamanController::class, 'index'])->name('index');

        Route::middleware('role:peminjam')->group(function () {
            Route::get('/create', [PeminjamanController::class, 'create'])->name('create');
            Route::post('/', [PeminjamanController::class, 'store'])->name('store');
        });

        Route::middleware('role:administrator,petugas')->group(function () {
            Route::get('/{peminjaman}/edit', [PeminjamanController::class, 'edit'])->name('edit');
            Route::put('/{peminjaman}', [PeminjamanController::class, 'update'])->name('update');
            Route::delete('/{peminjaman}', [PeminjamanController::class, 'destroy'])->name('destroy');

            Route::put('/{peminjaman}/approve', [PeminjamanController::class, 'approve'])->name('approve');
            Route::put('/{peminjaman}/reject',  [PeminjamanController::class, 'reject'])->name('reject');
        });

        Route::get('/{peminjaman}', [PeminjamanController::class, 'show'])->name('show');
    });

    // Jadwal Reguler (FIXED NAME)
    Route::prefix('jadwal/reguler')->name('jadwal_reguler.')->middleware('role:administrator,petugas')->group(function () {
        Route::get('/', [JadwalRegulerController::class, 'index'])->name('index');
        Route::get('/create', [JadwalRegulerController::class, 'create'])->name('create');
        Route::post('/', [JadwalRegulerController::class, 'store'])->name('store');
        Route::get('/{jadwalReguler}/edit', [JadwalRegulerController::class, 'edit'])->name('edit');
        Route::put('/{jadwalReguler}', [JadwalRegulerController::class, 'update'])->name('update');
        Route::delete('/{jadwalReguler}', [JadwalRegulerController::class, 'destroy'])->name('destroy');
    });

    // Jadwal Utama
    Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
    
    // API Cek Ketersediaan
    Route::get('/api/check-availability', [JadwalController::class, 'checkAvailability'])->name('api.check-availability');
    
    // Laporan
    Route::prefix('laporan')->name('laporan.')->middleware('role:administrator,petugas')->group(function () {
        Route::get('/', [LaporanController::class, 'index'])->name('index');
        Route::get('/export', [LaporanController::class, 'export'])->name('export');
        Route::get('/print', [LaporanController::class, 'print'])->name('print');
    });

});
