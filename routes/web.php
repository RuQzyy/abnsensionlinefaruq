<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login'); // Tambahkan route untuk halaman utama
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile routes
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // Routes untuk Siswa
    Route::middleware('siswa')->group(function () {
        Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa.index');
        Route::get('/siswa/kehadiran', [SiswaController::class, 'kehadiran'])->name('siswa.kehadiran');
        Route::get('/siswa/absensi', [SiswaController::class, 'absensi'])->name('siswa.absensi');
        Route::get('/siswa/edit', [SiswaController::class, 'edit'])->name('siswa.edit');
    });

    // Routes untuk Guru
    Route::middleware('guru')->group(function () {
        Route::get('/guru', [GuruController::class, 'index'])->name('guru.index');
    });
    Route::middleware('admin')->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    });

    
});

require __DIR__.'/auth.php';
