<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogAktivitas;

class LogAktivitasController extends Controller
{
    public function index(Request $request)
{
    $tanggal = $request->tanggal ?? now()->toDateString(); // default hari ini

    $logs = LogAktivitas::with('user')
        ->whereDate('created_at', $tanggal)
        ->latest('created_at')
        ->paginate(20);

    return view('admin.log-aktivitas', compact('logs', 'tanggal'));
}

}
