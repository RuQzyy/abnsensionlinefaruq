<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    public function chat(Request $request)
    {
        $message = strtolower($request->input('message'));
        $response = $this->getResponse($message);
        return response()->json(['reply' => $response]);
    }

    private function getResponse($message)
    {
        // Daftar aturan kata kunci dan respons
        $rules = [
            // Variasi pertanyaan seputar absen
            'cara absen' => 'Untuk melakukan absen, pilih halaman absensi, ketika kamera aktif tekan ambil foto, setelah foto diambil tekan kirim absensi, untuk absen pulang akan tersedia pada saat jam pulang, Pastikan Anda berada di area sekolah saat melakukan absensi. Foto dan lokasi akan dikirim sebagai bukti kehadiran.',
            'akun tidak bisa login' => 'Pastikan username dan password benar. Jika masih gagal, hubungi admin sekolah.',
            'jam absen' =>'Absensi bisa dilakukan mulai pukul 06:00 hingga 08:00 WIB untuk absen masuk, dan untuk absensi pulang mulai pukul 12:30- hingga 13:00.',
            'tidak dapat melakukan absensi' => 'Pastikan Anda berada didalam titik koordinat absensi.',
            'siapa pencipta sistem absensi ini' => 'Sistem absensi ini dibuat oleh Muhammad Al-Faruq.',
            'mengubah password' => 'anda dapat mengubah password anda pada halaman edit',
            
            // Kata kunci umum yang bisa dipelajari lebih lanjut
            'bantuan' => 'Silakan ajukan pertanyaan yang Anda butuhkan bantuan, seperti cara absen, lupa password, dsb.',
            'informasi' => 'Tanyakan tentang absen, jam absen, atau masalah login.',
        ];

        // Memperluas pencarian dengan variasi kata kunci
        $synonyms = [
            'cara absen' => ['bagaimana absen', 'cara melakukan absen', 'tutorial absen'],
            'mengubah password' => ['lupa kata sandi', 'ganti password', 'reset password', 'mengubah kata sandi', 'lupa password'],
            'akun tidak bisa login' => ['gagal login', 'tidak bisa masuk', 'akun bermasalah', 'tidak dapat login'],
            'jam absen' => ['waktu absen', 'waktu untuk absen', 'waktu melakukan absen', 'kapan melakukan absen', 'waktu untuk melakukan absen', 'kapan absen', 'kapan saya dapat melakukan absen'],
            'siapa pencipta sistem absensi ini' => ['pencipta sistem', 'siapa yang membuat absensi', 'pencipta website'],
            'tidak dapat melakukan absensi' => ['gagal absen', 'absensi saya gagal terus', 'mengapa absensi saya gagal', 'tidak dapat melakukan absen', 'mengapa saya tidak dapa absen', 'tidak dapat absen'],
        ];

        // Cek apakah pesan pengguna mengandung kata kunci
        foreach ($rules as $key => $reply) {
            if (str_contains($message, $key)) {
                return $reply;
            }

            // Memeriksa sinonim
            foreach ($synonyms[$key] ?? [] as $synonym) {
                if (str_contains($message, $synonym)) {
                    return $reply;
                }
            }
        }

        // Default response jika tidak ada kecocokan
        return "Maaf, saya belum mengerti pertanyaan Anda. Silakan hubungi admin untuk bantuan lebih lanjut.";
    }
}
