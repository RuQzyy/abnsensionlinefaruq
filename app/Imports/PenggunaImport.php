<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Kelas;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PenggunaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Tentukan role berdasarkan kolom 'role' (guru/siswa)
        $role = strtolower(trim($row['role'] ?? ''));

        if ($role === 'guru') {
            // Cek apakah kelas sudah punya wali
            $kelasSudahAdaWali = User::where('role', 'guru')
                ->where('id_kelas', $row['id_kelas'])
                ->exists();

            if ($kelasSudahAdaWali) {
                return null; // skip jika kelas sudah ada wali
            }

            // Cek NIP sama
            $nipSama = User::where('role', 'guru')
                ->where('nip', $row['nip'])
                ->exists();

            if ($nipSama) {
                return null; // skip jika NIP sama
            }

            return new User([
                'name' => $row['name'],
                'email' => $row['email'],
                'nip' => $row['nip'],
                'id_kelas' => $row['id_kelas'],
                'password' => Hash::make($row['password'] ?? 'password'),
                'role' => 'guru',
            ]);
        } elseif ($role === 'siswa') {
            // Cek NISN sama
            $nisnSama = User::where('role', 'siswa')
                ->where('nisn', $row['nisn'])
                ->exists();

            if ($nisnSama) {
                return null; // skip jika NISN sama
            }

            return new User([
                'name' => $row['name'],
                'email' => $row['email'],
                'nisn' => $row['nisn'],
                'no_hp' => $row['no_hp'],
                'id_kelas' => $row['id_kelas'],
                'password' => Hash::make($row['password'] ?? 'password'),
                'role' => 'siswa',
            ]);
        }

        return null; // jika role tidak dikenali
    }
}
