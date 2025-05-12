<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function index(){
        return view('guru.index');
    }

    public function kehadiranguru(){
        return view('guru.kehadiran-guru');
    }

    public function kehadiransiswa(){
        return view('guru.kehadiran-siswa');
    }

    public function absensi(){
        return view('guru.absensi');
    }

    public function edit(){
        return view('guru.edit');
    }

    public function bantuan(){
        return view('guru.bantuan');
    }

}
