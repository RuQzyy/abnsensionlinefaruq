<?php

use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;

if (!function_exists('logAktivitas')) {
    /**
     * Mencatat aktivitas pengguna ke tabel log_aktivitas.
     *
     * @param string $aksi Jenis aksi (create, update, delete, dll)
     * @param string $deskripsi Deskripsi aktivitas
     * @param string|null $model Nama model terkait (misal: 'Siswa', 'User')
     * @param int|null $model_id ID model terkait
     * @return void
     */
  function logAktivitas(string $aksi, string $deskripsi, ?string $model = null, ?int $model_id = null): void
    {
        try {
            if (Auth::check()) {
                LogAktivitas::create([
                    'user_id'    => Auth::id(),
                    'aksi'       => $aksi,
                    'deskripsi'  => $deskripsi,
                    'model'      => $model,
                    'model_id'   => $model_id,
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                    'created_at' => now(),
                ]);
            }
        } catch (\Throwable $e) {
            // Hindari error saat logging, jangan hentikan proses utama
            logger()->error('Gagal mencatat log aktivitas: ' . $e->getMessage());
        }
    }
}
