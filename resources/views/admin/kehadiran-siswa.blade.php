@extends('layouts.admin')

@section('title', 'Kehadiran Siswa')

@section('content')
<div class="max-w-7xl mx-auto bg-white rounded-xl shadow-lg p-6">
    <h1 class="text-2xl font-extrabold text-gray-800 mb-6">📋 Kehadiran Siswa</h1>

    {{-- Filter Section --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <input type="text" id="searchInput" placeholder="Cari nama atau tanggal..."
               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />

        <select id="filterKelas" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Filter Kelas</option>
            @foreach (collect($riwayat)->pluck('nama_kelas')->unique()->sort() as $kelas)
                <option value="{{ strtolower($kelas) }}">{{ $kelas }}</option>
            @endforeach
        </select>

        <select id="filterStatus" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Filter Status Datang/Pulang</option>
            <option value="hadir">Hadir</option>
            <option value="terlambat">Terlambat</option>
            <option value="alpha">Alpha</option>
            <option value="izin">Izin</option>
            <option value="cuti">Cuti</option>
            <option value="pulang_cepat">Pulang Cepat</option>
        </select>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm" id="kehadiranTable">
            <thead class="bg-blue-50">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600 uppercase">Tanggal</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600 uppercase">Nama Siswa</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600 uppercase">Kelas</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600 uppercase">waktu Datang</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600 uppercase">Status Datang</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600 uppercase">waktu Pulang</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600 uppercase">Status Pulang</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse ($riwayat as $item)
                    @php
                        $statusDatang = strtolower($item->status_datang);
                        $statusPulang = strtolower($item->status_pulang);
                        $statusDatangClass = match($statusDatang) {
                            'hadir' => 'bg-green-100 text-green-700',
                            'terlambat' => 'bg-yellow-100 text-yellow-700',
                            'alpha' => 'bg-red-100 text-red-700',
                            'izin' => 'bg-blue-100 text-blue-700',
                            'cuti' => 'bg-purple-100 text-purple-700',
                            default => 'bg-gray-100 text-gray-700',
                        };
                        $statusPulangClass = match($statusPulang) {
                            'pulang_cepat' => 'bg-orange-100 text-orange-700',
                            'alpha' => 'bg-red-100 text-red-700',
                            'izin' => 'bg-blue-100 text-blue-700',
                            'cuti' => 'bg-purple-100 text-purple-700',
                            'hadir' => 'bg-green-100 text-green-700',
                            default => 'bg-gray-100 text-gray-700',
                        };
                    @endphp
                    <tr class="hover:bg-gray-50"
                        data-nama="{{ strtolower($item->nama_siswa) }}"
                        data-kelas="{{ strtolower($item->nama_kelas) }}"
                        data-tanggal="{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}"
                        data-status="{{ $statusDatang . ' ' . $statusPulang }}">
                        <td class="px-4 py-3">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                        <td class="px-4 py-3">{{ $item->nama_siswa }}</td>
                        <td class="px-4 py-3">{{ $item->nama_kelas }}</td>
                        <td class="px-4 py-3">{{ $item->waktu_datang ?? '-' }}</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full {{ $statusDatangClass }} font-medium">
                                <i class="fas fa-circle"></i> {{ ucfirst($statusDatang) }}
                            </span>
                        </td>
                        <td class="px-4 py-3">{{ $item->waktu_pulang ?? '-' }}</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full {{ $statusPulangClass }} font-medium">
                                <i class="fas fa-circle"></i> {{ ucfirst($statusPulang) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-gray-500 py-6">Tidak ada data kehadiran siswa.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Script --}}
<script>
    const searchInput = document.getElementById('searchInput');
    const filterStatus = document.getElementById('filterStatus');
    const filterKelas = document.getElementById('filterKelas');
    const rows = document.querySelectorAll('#kehadiranTable tbody tr');

    function applyFilters() {
        const searchValue = searchInput.value.toLowerCase();
        const selectedStatus = filterStatus.value.toLowerCase();
        const selectedKelas = filterKelas.value.toLowerCase();

        rows.forEach(row => {
            const nama = row.dataset.nama;
            const tanggal = row.dataset.tanggal;
            const status = row.dataset.status;
            const kelas = row.dataset.kelas;

            const matchesSearch = nama.includes(searchValue) || tanggal.includes(searchValue);
            const matchesStatus = !selectedStatus || status.includes(selectedStatus);
            const matchesKelas = !selectedKelas || kelas === selectedKelas;

            if (matchesSearch && matchesStatus && matchesKelas) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    [searchInput, filterStatus, filterKelas].forEach(input =>
        input.addEventListener('input', applyFilters)
    );
</script>
@endsection
