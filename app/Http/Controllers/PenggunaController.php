<?php

namespace App\Http\Controllers;

use App\Imports\PenggunaImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class PenggunaController extends Controller
{

public function import(Request $request)
{
    $request->validate([
        'file' => 'required|file|mimes:xlsx,xls'
    ]);

    Excel::import(new PenggunaImport, $request->file('file'));

    return back()->with('success', 'Import berhasil!');
}
}
