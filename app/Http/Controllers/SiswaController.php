<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Pengaturan;
use Illuminate\Support\Facades\DB;
use App\Models\Kehadiran;
use App\Models\Pengumuman;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    public function index(){
        $pengumuman = Pengumuman::all();
        $pengaturan = DB::table('pengaturan')->first();
        $riwayatKehadiran = DB::table('kehadiran')
        ->join('users', 'kehadiran.id_users', '=', 'users.id')
        ->join('kelas', 'users.id_kelas', '=', 'kelas.id_kelas')
        ->where('role', 'siswa')
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

        return view('siswa.index', compact('pengaturan', 'pengumuman', 'riwayatKehadiran'));
    }

    public function kehadiran(){
        $riwayat = Kehadiran::where('kehadiran.id_users', Auth::id())
            ->join('users', 'kehadiran.id_users', '=', 'users.id')
            ->join('kelas', 'users.id_kelas', '=', 'kelas.id_kelas')
            ->select(
                'kehadiran.*',
                'users.name',
                'kelas.nama_kelas'
            )
            ->orderBy('kehadiran.tanggal', 'desc')
            ->orderBy('kehadiran.waktu_datang', 'desc')
            ->orderBy('kehadiran.waktu_pulang', 'desc')
            ->get();

        return view('siswa.kehadiran', compact('riwayat'));
    }


    public function absensi(){
        $pengaturan = DB::table('pengaturan')->first();
        return view('siswa.absensi', compact('pengaturan'));
    }

     public function absensiPulang(){
        $pengaturan = DB::table('pengaturan')->first();
        return view('siswa.absensiPulang', compact('pengaturan'));
    }

   public function edit()
{
    /** @var \App\Models\User $siswa */
    $siswa = Auth::user(); // Ambil user yang sedang login
    return view('siswa.edit', compact('siswa'));
}

public function update(Request $request)
{
    /** @var \App\Models\User $siswa */
    $siswa = Auth::user();

    $request->validate([
        'name' => 'required|string|max:255',
        'nisn' => 'nullable|string|max:20',
        'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'password' => 'nullable|string|min:6|confirmed',
    ]);

    $siswa->name = $request->name;
    $siswa->nisn = $request->nisn;

    if ($request->hasFile('foto')) {
        $path = $request->file('foto')->store('foto_siswa', 'public');
        $siswa->foto_profil = $path;
    }

    if ($request->filled('password')) {
        $siswa->password = bcrypt($request->password);
    }

    $siswa->save();

    return redirect()->route('siswa.edit')->with('success', 'Profil berhasil diperbarui.');
}

    public function bantuan(){
        return view('siswa.bantuan');
    }

}
