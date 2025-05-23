<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Kehadiran;
use App\Models\Pengaturan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    public function store(Request $request)
    {
        $img = $request->input('image');
        $lokasi = $request->input('lokasi');

        if (!$img || !$lokasi) {
            return response()->json(['success' => false, 'message' => 'Data tidak lengkap.']);
        }

        // Proses simpan gambar
        [$type, $data] = explode(';', $img);
        [, $data] = explode(',', $data);
        $data = base64_decode($data);

        $fileName = 'absen_masuk_' . time() . '_' . Str::random(10) . '.png';
        Storage::disk('public')->put('foto-absen/' . $fileName, $data);

        $now = Carbon::now();
        $tanggal = $now->toDateString();
        $jamSekarang = $now->format('H:i:s');

        $pengaturan = Pengaturan::first();
        $statusDatang = $jamSekarang > $pengaturan->absen_datang ? 'terlambat' : 'hadir';

        // Simpan/update kehadiran
        Kehadiran::updateOrCreate(
            ['id_users' => Auth::id(), 'tanggal' => $tanggal],
            [
                'waktu_datang' => $jamSekarang,
                'foto' => 'foto-absen/' . $fileName,
                'lokasi' => $lokasi,
                'status_datang' => $statusDatang,
                'jenis' => 'datang'
            ]
        );

        return response()->json(['success' => true, 'status' => $statusDatang]);
    }

    public function Pulangstore(Request $request)
    {
        $img = $request->input('image');
        $lokasi = $request->input('lokasi');

        if (!$img || !$lokasi) {
            return response()->json(['success' => false, 'message' => 'Data tidak lengkap.']);
        }

        // Proses simpan gambar
        [$type, $data] = explode(';', $img);
        [, $data] = explode(',', $data);
        $data = base64_decode($data);

        $fileName = 'absen_pulang_' . time() . '_' . Str::random(10) . '.png';
        Storage::disk('public')->put('foto-absen/' . $fileName, $data);

        $now = Carbon::now();
        $tanggal = $now->toDateString();
        $jamSekarang = $now->format('H:i:s');

        $pengaturan = Pengaturan::first();

        $kehadiran = Kehadiran::where('id_users', Auth::id())->where('tanggal', $tanggal)->first();

        if (!$kehadiran || !$kehadiran->waktu_datang) {
            return response()->json(['success' => false, 'message' => 'Anda belum absen masuk.']);
        }

        // Jika pulang sebelum waktu pulang → bolos, kalau sesuai → tepat
        $statusPulang = $jamSekarang < $pengaturan->absen_pulang ? 'bolos' : 'tepat';

        $kehadiran->update([
            'waktu_pulang' => $jamSekarang,
            'status_pulang' => $statusPulang,
            'jenis' => 'pulang'
        ]);

        return response()->json(['success' => true, 'status' => $statusPulang]);
    }

    public function tandaiAlphaDanBolos()
    {
        $tanggal = Carbon::now()->toDateString();
        $userIds = \App\Models\User::pluck('id');

        foreach ($userIds as $id) {
            $kehadiran = Kehadiran::where('id_users', $id)->where('tanggal', $tanggal)->first();

            if (!$kehadiran) {
                // Tidak hadir sama sekali
                Kehadiran::create([
                    'id_users' => $id,
                    'tanggal' => $tanggal,
                    'status_datang' => 'alpha',
                    'status_pulang' => 'alpha',
                ]);
            } elseif ($kehadiran->waktu_datang && is_null($kehadiran->waktu_pulang)) {
                // Datang tapi tidak pulang/pulang awal
                $kehadiran->update(['status_pulang' => 'bolos']);
            } elseif (is_null($kehadiran->waktu_datang) && $kehadiran->waktu_pulang) {
                // Pulang tanpa datang → bolos
                $kehadiran->update(['status_datang' => 'bolos']);
            }
        }
    }
}
