<?php

namespace App\Http\Controllers;

use App\Imports\PenggunaImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PenggunaController extends Controller
{
    public function import(Request $request)
    {
        // Validasi file
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls'
        ]);

        // Jalankan import
        $import = new PenggunaImport();
        Excel::import($import, $request->file('file'));

        // Cek apakah ada kegagalan
        if ($import->failures()->isNotEmpty()) {
            $pesan = $import->failures()->map(function ($failure) {
                return implode(', ', $failure->errors());
            })->implode(' | ');

            Alert::toast('Beberapa data gagal diimpor: ' . $pesan, 'error');
        } else {
            Alert::toast('Import pengguna berhasil!', 'success');
        }

        return back();
    }
}
