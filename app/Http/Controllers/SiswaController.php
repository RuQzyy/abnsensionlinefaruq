<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index(){
        return view('siswa.index');
    }

    public function kehadiran(){
        return view('siswa.kehadiran');
    }

    public function absensi(){
        return view('siswa.absensi');
    }

    public function edit(){
        return view('siswa.edit');
    }

}
