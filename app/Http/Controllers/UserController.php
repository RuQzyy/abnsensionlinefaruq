<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Kelas;
use RealRashid\SweetAlert\Facades\Alert;


class UserController extends Controller
{
   public function storeGuru(Request $request)
{
    $request->validate([
        'name' => 'required|string',
        'email' => 'required|email|unique:users',
        'nip' => 'required|string',
        'id_kelas' => 'nullable|exists:kelas,id_kelas',
        'password' => 'required|string|min:6',
    ]);

    // Cek apakah kelas sudah punya wali
    $kelasSudahAdaWali = User::where('role', 'guru')
        ->where('id_kelas', $request->id_kelas)
        ->exists();

    if ($kelasSudahAdaWali) {
        Alert::toast('gagal menambahkan guru, kelas sudah mempunyai wali', 'error');
        return back();
    }

     $nipSama = User::where('role', 'guru')
        ->where('nip', $request->nip)
        ->exists();

    if ($nipSama) {
        Alert::toast('gagal menambahkan guru, nip tidak boleh sama', 'error');
        return back();
    }

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'nip' => $request->nip,
        'id_kelas' => $request->id_kelas,
        'role' => 'guru',
    ]);
    Alert::toast('guru berhasil ditambahkan', 'success');
    return back();
}


public function storeSiswa(Request $request)
{
    // Validasi input dasar
    $request->validate([
        'name' => 'required|string',
        'email' => 'required|email|unique:users,email',
        'nisn' => 'required|string',
        'no_hp' => 'required|string',
        'id_kelas' => 'required|exists:kelas,id_kelas',
    ]);

    // Cek apakah ada siswa dengan NISN yang sama
    $nisnSama = User::where('role', 'siswa')
        ->where('nisn', $request->nisn)
        ->exists();

    if ($nisnSama) {
        Alert::toast('Gagal menambahkan siswa, NISN sudah digunakan', 'error');
        return back();
    }

    // Buat akun siswa
    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt('password'), // default password
        'nisn' => $request->nisn,
        'no_hp' => $request->no_hp,
        'id_kelas' => $request->id_kelas,
        'role' => 'siswa',
    ]);

    Alert::toast('Siswa berhasil ditambahkan', 'success');
    return back();
}


 public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $isGuru = $user->role === 'guru';
    $isSiswa = $user->role === 'siswa';

    if ($isGuru) {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'nip' => 'required|string|max:100',
            'password' => 'required|string|min:6',
            'id_kelas' => 'nullable|exists:kelas,id_kelas',
        ]);

        $kelasSudahAdaWali = User::where('role', 'guru')
            ->where('id_kelas', $request->id_kelas)
            ->where('id', '!=', $id)
            ->exists();

        if ($kelasSudahAdaWali) {
            Alert::toast('Gagal mengedit guru, kelas tersebut sudah mempunyai wali.', 'error');
            return back();
        }

        if ($user->nip !== $request->nip) {
            $nipSama = User::where('role', 'guru')
                ->where('nip', $request->nip)
                ->where('id', '!=', $id)
                ->exists();

            if ($nipSama) {
                Alert::toast('Gagal mengedit guru, NIP sudah digunakan.', 'error');
                return back();
            }
        }

    } elseif ($isSiswa) {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'nisn' => 'required|string|max:50',
            'id_kelas' => 'required|exists:kelas,id_kelas',
            'password' => 'required|string|min:6',
            'no_hp' => 'required|string|max:20',
        ]);

        if ($user->nisn !== $request->nisn) {
            $nisnSama = User::where('role', 'siswa')
            ->where('nisn', $request->nisn)
            ->where('id', '!=', $id)
            ->exists();

        if ($nisnSama) {
            Alert::toast('Gagal mengedit siswa, NISN sudah digunakan.', 'error');
            return back();
        }
    }


    } else {
        return back()->with('error', 'Data tidak valid.');
    }

    $user->update($data);

    return back()->with('success', 'Data pengguna berhasil diperbarui.');
}

 }

