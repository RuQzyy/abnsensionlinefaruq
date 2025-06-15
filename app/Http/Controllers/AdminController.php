<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\User;
use App\Models\Pengumuman;
use App\Models\Pengaturan;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;


class AdminController extends Controller
{
  public function index()
{
    $pengumuman = Pengumuman::all();
    $totalSiswa = DB::table('users')->where('role', 'siswa')->count();
    $totalGuru = DB::table('users')->where('role', 'guru')->count();
    $totalHadir = DB::table('kehadiran')
        ->where('status_datang', 'hadir')
        ->whereDate('tanggal', Carbon::today())
        ->count();
     $totalAlpha = DB::table('kehadiran')
        ->where('status_datang', 'alpha')
        ->whereDate('tanggal', Carbon::today())
        ->count();

    $monthlyData = DB::table('kehadiran')
        ->selectRaw('MONTH(tanggal) as month,
            SUM(CASE WHEN status_datang = "hadir" THEN 1 ELSE 0 END) as hadir,
            SUM(CASE WHEN status_datang = "terlambat" THEN 1 ELSE 0 END) as terlambat,
            SUM(CASE WHEN status_datang = "alpha" THEN 1 ELSE 0 END) as alpha')
        ->groupBy(DB::raw('MONTH(tanggal)'))
        ->orderBy('month')
        ->get();

    $chartData = array_fill(1, 12, ['hadir' => 0, 'terlambat' => 0, 'alpha' => 0]);

    foreach ($monthlyData as $data) {
        $chartData[$data->month] = [
            'hadir' => $data->hadir,
            'terlambat' => $data->terlambat,
            'alpha' => $data->alpha,
        ];
    }

    return view('admin.index', compact(
        'pengumuman', 'totalSiswa', 'totalGuru', 'totalHadir', 'chartData', 'totalAlpha'
    ));
}

    public function pengaturan(){
        $pengumuman = Pengumuman::all();
        $pengaturan = Pengaturan::first();
        return view('admin.pengaturan',compact('pengumuman','pengaturan'));
    }

    public function notifikasi(){
        return view('admin.notifikasi');
    }

    public function pengguna(){
       $guruList = DB::table('users')
        ->leftJoin('kelas', 'users.id_kelas', '=', 'kelas.id_kelas')
        ->where('role', 'guru')
        ->select('users.*', 'kelas.nama_kelas')
        ->get();
        $class = Kelas::all();
        $siswaList = DB::table('users')
        ->join('kelas', 'users.id_kelas', '=', 'kelas.id_kelas')
        ->where('role', 'siswa')
        ->select('users.*', 'kelas.nama_kelas')
        ->get();
        return view('admin.pengguna',compact('guruList', 'siswaList', 'class'));
    }

    public function kehadiransiswa(){
    $class = Kelas::all();
    $riwayat = DB::table('kehadiran')
        ->join('users', 'kehadiran.id_users', '=', 'users.id')
        ->join('kelas', 'users.id_kelas', '=', 'kelas.id_kelas')
        ->where('users.role', 'siswa')
        ->select(
             'kehadiran.id_users',
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

    return view('admin.kehadiran-siswa', compact('riwayat','class'));
}

   public function kehadiranguru(){
    $class = Kelas::all();
    $riwayat = DB::table('kehadiran')
        ->join('users', 'kehadiran.id_users', '=', 'users.id')
        ->join('kelas', 'users.id_kelas', '=', 'kelas.id_kelas')
        ->where('users.role', 'guru')
        ->select(
            'kehadiran.id_users',
            'kehadiran.tanggal',
            'users.name as nama_guru',
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

    return view('admin.kehadiran-guru', compact('riwayat','class'));
}


public function ubahStatusKehadiran(Request $request)
{
    DB::table('kehadiran')
        ->where('id_users', $request->id_users)
        ->whereDate('tanggal', $request->tanggal)
        ->update([
            'status_datang' => $request->status_datang,
            'status_pulang' => $request->status_pulang,
        ]);

    return redirect()->back()->with('success', 'Status berhasil diperbarui.');
}

public function ubahStatusKehadiransiswa(Request $request)
{
    DB::table('kehadiran')
        ->where('id_users', $request->id_users)
        ->whereDate('tanggal', $request->tanggal)
        ->update([
            'status_datang' => $request->status_datang,
            'status_pulang' => $request->status_pulang,
        ]);

    return redirect()->back()->with('success', 'Status berhasil diperbarui.');
}


      public function kelas(){
         $kelas = Kelas::all();
         $class = Kelas::all();
         $siswa = User::all();
        $siswaList = DB::table('users')
        ->join('kelas', 'users.id_kelas', 'kelas.id_kelas')
        ->where('role', 'siswa')
        ->get();

       return view('admin.kelas', compact('kelas', 'class', 'siswa', 'siswaList'));
    }


}
