<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\PenggunaController;
use Illuminate\Support\Facades\Route;

Route::post('/chatbot', [App\Http\Controllers\ChatbotController::class, 'chat']);
Route::get('/absensi/tandai-alpha-bolos', [AbsensiController::class, 'tandaiAlphaDanBolos']);

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
          Route::get('/siswa/absensiPulang', [SiswaController::class, 'absensiPulang'])->name('siswa.absensiPulang');
        Route::get('/siswa/edit', [SiswaController::class, 'edit'])->name('siswa.edit');
        Route::get('/siswa/bantuan', [SiswaController::class, 'bantuan'])->name('siswa.bantuan');
    });

    // Routes untuk Guru
    Route::middleware('guru')->group(function () {
        Route::get('/guru', [GuruController::class, 'index'])->name('guru.index');
        Route::get('/guru/absensi', [GuruController::class, 'absensi'])->name('guru.absensi');
        Route::get('/guru/absensiPulang', [GuruController::class, 'absensiPulang'])->name('guru.absensiPulang');
        Route::get('/guru/edit', [GuruController::class, 'edit'])->name('guru.edit');
        Route::get('/guru/kehadiran-guru', [GuruController::class, 'kehadiranguru'])->name('guru.kehadiran-guru');
        Route::get('/guru/kehadiran-siswa', [GuruController::class, 'kehadiransiswa'])->name('guru.kehadiran-siswa');
        Route::get('/guru/bantuan', [GuruController::class, 'bantuan'])->name('guru.bantuan');
    });
    Route::middleware('admin')->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
        Route::get('/admin/pengaturan', [AdminController::class, 'pengaturan'])->name('admin.pengaturan');
        Route::get('/admin/notifiksai', [AdminController::class, 'notifikasi'])->name('admin.notifikasi');
        Route::get('/admin/pengguna', [AdminController::class, 'pengguna'])->name('admin.pengguna');
        Route::get('/admin/kehadiran-siswa', [AdminController::class, 'kehadiransiswa'])->name('admin.kehadiran-siswa');
        Route::get('/admin/kehadiran-guru', [AdminController::class, 'kehadiranguru'])->name('admin.kehadiran-guru');
        Route::get('/admin/kelas', [AdminController::class, 'kelas'])->name('admin.kelas');
    });
      Route::middleware('admin')->group(function () {
        Route::post('/kelas', [KelasController::class, 'store'])->name('admin.kelas.store');
        Route::post('/', [KelasController::class, 'store'])->name('admin.kelas.store');
        Route::delete('/destroy{id}', [KelasController::class, 'destroy'])->name('admin.kelas.destroy');
         Route::delete('/hapuskelas{id}', [KelasController::class, 'hapuskelas'])->name('admin.kelas.hapuskelas');
    });

    Route::middleware('admin')->group(function () {
        Route::post('/', [PengumumanController::class, 'store'])->name('admin.pengumuman.store');
        Route::delete('/pengumuman/{id}', [PengumumanController::class, 'destroy'])->name('admin.pengumuman.destroy');
        Route::put('/{id}', [PengumumanController::class, 'update'])->name('admin.pengumuman.update');
    });

     Route::middleware('admin')->group(function () {
        Route::post('/pengaturan', [PengaturanController::class, 'store'])->name('admin.pengaturan.store');
    });

     Route::middleware('admin')->group(function () {
        Route::post('/pengguna/guru', [UserController::class, 'storeGuru'])->name('admin.pengguna.storeGuru');
        Route::post('/pengguna/siswa', [UserController::class, 'storeSiswa'])->name('admin.pengguna.storeSiswa');
        Route::post('/pengguna/import', [PenggunaController::class, 'import'])->name('admin.pengguna.import');
        Route::put('/admin/pengguna/{id}', [UserController::class, 'update']);
    });

    Route::middleware('siswa')->prefix('siswa')->group(function () {
         Route::post('/absensi', [AbsensiController::class, 'store'])->name('siswa.absensi.store');
         Route::post('/absensiPulang', [AbsensiController::class, 'Pulangstore'])->name('siswa.absensiPulang.store');
    });

    Route::middleware('guru')->prefix('guru')->group(function () {
        Route::post('/absensi', [AbsensiController::class, 'store'])->name('guru.absensi.store');
        Route::post('/absensiPulang', [AbsensiController::class, 'Pulangstore'])->name('guru.absensiPulang.store');
    });

    Route::middleware('guru')->prefix('guru')->group(function () {
    Route::put('/edit/{id}', [GuruController::class, 'update'])->name('guru.update');
    });


    Route::middleware('siswa')->group(function () {
       Route::put('/edit/{id}', [SiswaController::class, 'update'])->name('siswa.update');
    });

     Route::middleware('admin')->group(function () {
       Route::post('/ubah-status-kehadiran', [AdminController::class, 'ubahStatusKehadiran'])->name('ubah.status.kehadiran');
    });



});

require __DIR__.'/auth.php';
