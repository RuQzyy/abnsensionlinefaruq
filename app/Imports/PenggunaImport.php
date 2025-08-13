<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Validators\Failure;

class PenggunaImport implements ToModel, WithHeadingRow, SkipsOnFailure
{
    use SkipsFailures;

    public function model(array $row)
    {
        $role = strtolower(trim($row['role'] ?? ''));

        if ($role === 'guru') {
            if (User::where('role', 'guru')->where('nip', $row['nip'])->exists()) {
                $this->failures[] = new Failure(
                    0,
                    'nip',
                    ['NIP sudah digunakan'],
                    $row
                );
                return null;
            }

            if (!empty($row['id_kelas'])) {
                $kelasSudahAdaWali = User::where('role', 'guru')
                    ->where('id_kelas', $row['id_kelas'])
                    ->exists();

                if ($kelasSudahAdaWali) {
                    $this->failures[] = new Failure(
                        0,
                        'id_kelas',
                        ['Kelas sudah memiliki wali'],
                        $row
                    );
                    return null;
                }
            }

            return new User([
                'name' => $row['name'],
                'email' => $row['email'],
                'nip' => $row['nip'],
                'id_kelas' => $row['id_kelas'] ?? null,
                'password' => Hash::make($row['password'] ?? 'password'),
                'role' => 'guru',
            ]);
        }

        if ($role === 'siswa') {
            if (empty($row['id_kelas'])) {
                $this->failures[] = new Failure(
                    0,
                    'id_kelas',
                    ['Siswa wajib mengisi kelas'],
                    $row
                );
                return null;
            }

            if (User::where('role', 'siswa')->where('nisn', $row['nisn'])->exists()) {
                $this->failures[] = new Failure(
                    0,
                    'nisn',
                    ['NISN sudah digunakan'],
                    $row
                );
                return null;
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

        $this->failures[] = new Failure(
            0,
            'role',
            ['Role tidak valid'],
            $row
        );

        return null;
    }
}
