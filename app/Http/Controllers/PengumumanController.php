<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengumuman;

class PengumumanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(){
        $pengumuman = Pengumuman::all();
        return view('admin.pengaturan',compact('pengumuman'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255|unique:pengumuman,judul',
            'isi' => 'required|string|max:255|unique:pengumuman,isi',
        ]);

        $pengumuman = new Pengumuman();
        $pengumuman->isi = $request->isi;
        $pengumuman->judul = $request->judul;
        $pengumuman->save();

        return redirect()->route('admin.pengaturan')->with('success', 'pengumuman berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
        ]);

        Pengumuman::findOrFail($id)->update($data);
        return back()->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy($id_pengumuman)
    {
        $pengumuman = Pengumuman::findOrFail($id_pengumuman);
        $pengumuman->delete();
         return redirect()->route('admin.pengaturan')->with('success', 'Pengumuman berhasil dihapus.');
    }
}
