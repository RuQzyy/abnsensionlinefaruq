<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RekapKehadiranExport implements FromCollection, WithHeadings
{
    protected $bulan;

    public function __construct($bulan)
    {
        $this->bulan = $bulan;
    }

    public function collection()
    {
        return DB::table('kehadiran')
            ->join('users', 'kehadiran.id_users', '=', 'users.id')
            ->leftJoin('kelas', 'users.id_kelas', '=', 'kelas.id_kelas')
            ->select(
                'kehadiran.tanggal',
                'users.name as nama_siswa',
                'kelas.nama_kelas',
                'kehadiran.waktu_datang',
                'kehadiran.status_datang',
                'kehadiran.waktu_pulang',
                'kehadiran.status_pulang'
            )
            ->where('kehadiran.tanggal', 'like', $this->bulan . '%')
            ->orderBy('kehadiran.tanggal')
            ->orderBy('kelas.nama_kelas')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Nama Siswa',
            'Kelas',
            'Waktu Datang',
            'Status Datang',
            'Waktu Pulang',
            'Status Pulang',
        ];
    }
}
