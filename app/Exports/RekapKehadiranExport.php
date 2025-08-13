<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Facades\Auth;

class RekapKehadiranExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    protected $bulan;

    public function __construct($bulan)
    {
        $this->bulan = $bulan;
    }

    public function collection()
    {
        $guru = Auth::user();

        // Pastikan hanya guru yang bisa mengunduh
        if ($guru->role !== 'guru') {
            abort(403, 'Anda tidak memiliki izin untuk mengunduh data ini.');
        }

        // Ambil ID kelas guru
        $idKelasGuru = $guru->id_kelas;

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
            ->where('users.role', 'siswa')
            ->where('users.id_kelas', $idKelasGuru)
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

    public function styles(Worksheet $sheet)
    {
        $rowCount = $sheet->getHighestRow();
        $colCount = $sheet->getHighestColumn();

        // Heading bold & background
        $sheet->getStyle('A1:' . $colCount . '1')->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'D9E1F2']
            ]
        ]);

        // Border semua cell
        $sheet->getStyle('A1:' . $colCount . $rowCount)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ]);

        return [];
    }
}
