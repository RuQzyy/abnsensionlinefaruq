<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\User;
use App\Models\Pengumuman;
use App\Models\Pengaturan;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;


class AdminController extends Controller
{
    public function index(){
        $pengumuman = Pengumuman::all();
        $totalSiswa = DB::table('users')->where('role', 'siswa')->count();
        $totalGuru = DB::table('users')->where('role', 'guru')->count();
        return view('admin.index',compact('pengumuman', 'totalSiswa', 'totalGuru'));
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
        ->join('kelas', 'users.id_kelas', '=', 'kelas.id_kelas')
        ->where('role', 'guru')
        ->select('users.*', 'kelas.nama_kelas') // opsional: supaya bisa tampil nama kelas
        ->get();
        $class = Kelas::all();
        $siswaList = DB::table('users')
        ->join('kelas', 'users.id_kelas', '=', 'kelas.id_kelas')
        ->where('role', 'siswa')
        ->select('users.*', 'kelas.nama_kelas') // opsional: supaya bisa tampil nama kelas
        ->get();
        return view('admin.pengguna',compact('guruList', 'siswaList', 'class'));
    }

    public function kehadiransiswa(){
        return view('admin.kehadiran-siswa');
    }

    public function kehadiranguru(){
        return view('admin.kehadiran-guru');
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
