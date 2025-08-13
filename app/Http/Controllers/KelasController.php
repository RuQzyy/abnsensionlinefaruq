<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\User;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
     public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255|unique:kelas,nama_kelas',
        ]);

        $kelas = new Kelas();
        $kelas->nama_kelas = $request->nama_kelas;
        $kelas->save();

        return redirect()->route('admin.kelas')->with('success', 'Kelas berhasil ditambahkan.');
    }

  public function updateKelasSiswa(Request $request, $id)
{
    $request->validate([
        'id_kelas' => 'required|exists:kelas,id_kelas',
    ]);

    $siswa = User::findOrFail($id);
    $siswa->id_kelas = $request->id_kelas;
    $siswa->save();

    return redirect()->back()->with('success', 'Kelas siswa berhasil diperbarui.');
}


     public function hapuskelas($id_kelas)
    {

        $kelas = kelas::findOrFail($id_kelas);
        $kelas->delete();
        return redirect()->back()->with('success', 'Kelas berhasil dihapus.');
    }
}
