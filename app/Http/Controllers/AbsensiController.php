<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Kehadiran;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    public function store(Request $request)
    {
        $img = $request->input('image');
        $lokasi = $request->input('lokasi'); // lokasi dikirim dari client (latitude,longitude)

        if (!$img || !$lokasi) {
            return response()->json(['success' => false, 'message' => 'Data tidak lengkap.']);
        }

        // Pisahkan base64
        [$type, $data] = explode(';', $img);
        [, $data] = explode(',', $data);

        // Decode gambar
        $data = base64_decode($data);

        // Nama file unik
        $fileName = 'absen_' . time() . '_' . Str::random(10) . '.png';

        // Simpan ke storage/public/foto-absen
        Storage::disk('public')->put('foto-absen/' . $fileName, $data);

        // Simpan ke database
        Kehadiran::create([
            'id_users' => Auth::id(), // otomatis ambil user login
            'tanggal' => Carbon::now()->toDateString(),
            'waktu' => Carbon::now()->toTimeString(),
            'foto' => 'foto-absen/' . $fileName,
            'lokasi' => $lokasi,
            'status' => 'hadir'
        ]);

        return response()->json(['success' => true]);
    }
}
