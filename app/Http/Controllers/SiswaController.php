<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Pengaturan;
use Illuminate\Support\Facades\DB;
use App\Models\Kehadiran;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    public function index(){
        $pengaturan = DB::table('pengaturan')->first();
        return view('siswa.index', compact('pengaturan'));
    }

    public function kehadiran(){
        $riwayat = Kehadiran::where('id_users', Auth::id())
            ->orderBy('tanggal', 'desc')
            ->orderBy('waktu', 'desc')
            ->get();

        return view('siswa.kehadiran', compact('riwayat'));
    }

    public function absensi(){
        $pengaturan = DB::table('pengaturan')->first();
        return view('siswa.absensi', compact('pengaturan'));
    }

    public function edit(){
        return view('siswa.edit');
    }

    public function bantuan(){
        return view('siswa.bantuan');
    }

}
