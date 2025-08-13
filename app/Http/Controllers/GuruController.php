<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaturan;
use Illuminate\Support\Facades\DB;
use App\Models\Kehadiran;
use App\Models\Pengumuman;
use App\Models\kelas;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RekapKehadiranExport;
use Illuminate\Support\Facades\Storage;


class GuruController extends Controller
{
        public function index(){
        $pengumuman = Pengumuman::all();
        $pengaturan = DB::table('pengaturan')->first();
        $riwayatKehadiran = DB::table('kehadiran')
        ->join('users', 'kehadiran.id_users', '=', 'users.id')
        ->join('kelas', 'users.id_kelas', '=', 'kelas.id_kelas')
        ->where('users.role', 'siswa')
        ->select(
            'users.name',
            'kelas.nama_kelas',
            'kehadiran.tanggal',
            'kehadiran.waktu_datang',
            'kehadiran.waktu_pulang'
        )
        ->orderBy('kehadiran.waktu_datang', 'desc')
        ->orderBy('kehadiran.waktu_pulang', 'desc')
        ->take(4)
        ->get();

        return view('guru.index', compact('pengaturan', 'pengumuman', 'riwayatKehadiran'));
    }


    public function kehadiranguru(){
        $riwayat = Kehadiran::where('id_users', Auth::id())
            ->orderBy('tanggal', 'desc')
            ->orderBy('waktu_datang', 'desc')
            ->orderBy('waktu_pulang', 'desc')
            ->get();
       return view('guru.kehadiran-guru', compact('riwayat'));
    }

 public function kehadiransiswa()
{
    /** @var \App\Models\User $guru */
    $guru = Auth::user();// ambil guru yang sedang login
    $kelasGuru = $guru->id_kelas;

    $class = Kelas::where('id_kelas', $kelasGuru)->get(); // hanya kelas milik guru
    $riwayat = DB::table('kehadiran')
        ->join('users', 'kehadiran.id_users', '=', 'users.id')
        ->join('kelas', 'users.id_kelas', '=', 'kelas.id_kelas')
        ->where('users.role', 'siswa')
        ->where('kelas.id_kelas', $kelasGuru) // filter berdasarkan kelas milik guru
        ->select(
            'kehadiran.tanggal',
            'users.name as nama_siswa',
            'kelas.nama_kelas',
            'kehadiran.foto',
            'kehadiran.waktu_datang',
            'kehadiran.waktu_pulang',
            'kehadiran.status_datang',
            'kehadiran.status_pulang',
            'kehadiran.jenis',
        )
        ->orderBy('kehadiran.tanggal', 'desc')
        ->orderBy('kehadiran.waktu_datang', 'desc')
        ->orderBy('kehadiran.waktu_pulang', 'desc')
        ->get();

    return view('guru.kehadiran-siswa', compact('riwayat', 'class'));
}


    public function absensi(){
        $pengaturan = DB::table('pengaturan')->first();
        return view('guru.absensi', compact('pengaturan'));
    }

     public function absensiPulang(){
        $pengaturan = DB::table('pengaturan')->first();
        return view('guru.absensiPulang', compact('pengaturan'));
    }


    public function edit()
{
    /** @var \App\Models\User $guru */
    $guru = Auth::user(); // Ambil user yang sedang login
    return view('guru.edit', compact('guru'));
}

public function update(Request $request)
{
    /** @var \App\Models\User $guru */
    $guru = Auth::user();

    $request->validate([
        'name' => 'required|string|max:255',
        'nip' => 'nullable|string|max:20',
        'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'password' => 'nullable|string|min:6|confirmed',
    ]);

    $guru->name = $request->name;
    $guru->nip = $request->nip;

    if ($request->hasFile('foto')) {
        // Hapus foto lama jika ada
        if ($guru->foto_profil && Storage::disk('public')->exists($guru->foto_profil)) {
    Storage::disk('public')->delete($guru->foto_profil);
}


        // Simpan foto baru
        $path = $request->file('foto')->store('foto_guru', 'public');
        $guru->foto_profil = $path;
    }

    if ($request->filled('password')) {
        $guru->password = bcrypt($request->password);
    }

    $guru->save();

    return redirect()->route('guru.edit')->with('success', 'Profil berhasil diperbarui.');
}


    public function bantuan(){
        return view('guru.bantuan');
    }

   public function updateStatusKehadiran(Request $request)
{
    $request->validate([
        'tanggal' => 'required|date',
        'nama' => 'required|string',
        'status_datang' => 'nullable|string',
        'status_pulang' => 'nullable|string',
    ]);

    $user = User::where('name', $request->nama)->where('role', 'siswa')->first();

    if (!$user) {
        return back()->with('error', 'Siswa tidak ditemukan.');
    }

    $kehadiran = Kehadiran::where('id_users', $user->id)
        ->where('tanggal', $request->tanggal)
        ->first();

    if (!$kehadiran) {
        return back()->with('error', 'Data kehadiran tidak ditemukan.');
    }

    // Simpan data lama untuk log
    $lama_datang = $kehadiran->status_datang;
    $lama_pulang = $kehadiran->status_pulang;

    // Update status kehadiran
    $kehadiran->status_datang = $request->status_datang;
    $kehadiran->status_pulang = $request->status_pulang;
    $kehadiran->save();

    // Catat log aktivitas
    $deskripsi = "Guru mengubah status kehadiran siswa '{$user->name}' pada tanggal {$request->tanggal}: ";
    $deskripsi .= "Datang: {$lama_datang} → {$request->status_datang}, ";
    $deskripsi .= "Pulang: {$lama_pulang} → {$request->status_pulang}";

    logAktivitas(
        'Update',
        $deskripsi,
        'Kehadiran',
        $kehadiran->id_kehadiran
    );

    return back()->with('success', 'Status kehadiran berhasil diperbarui.');
}


public function downloadRekapKehadiran(Request $request)
{
    $request->validate([
        'bulan' => 'required|date_format:Y-m',
    ]);

    $bulan = $request->bulan; // contoh: "2025-06"

    return Excel::download(new RekapKehadiranExport($bulan), 'rekap_kehadiran_' . $bulan . '.xlsx');
}
}
