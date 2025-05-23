<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaturan;

class PengaturanController extends Controller
{

     public function store(Request $request)
    {
        $data = $request->validate([
            'lath_lokasi' => 'required|numeric',
            'long_lokasi' => 'required|numeric',
            'radius_absen'  => 'required|numeric',
            'toleransi_keterlambatan' => 'required',
            'absen_datang' => 'required',
            'absen_pulang' => 'required',
        ]);

        Pengaturan::updateOrCreate(['id_pengaturan' => 1], $data);

        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }

}
