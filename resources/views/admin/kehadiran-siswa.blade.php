@extends('layouts.admin')

@section('title', 'Kehadiran Siswa')

@section('content')
<div class="max-w-6xl mx-auto bg-white rounded-xl shadow-lg p-6">
    <h1 class="text-2xl font-extrabold text-gray-800 mb-6">📋 Kehadiran Siswa</h1>

    {{-- Filter Section --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <input type="text" id="searchInput" placeholder="Cari nama atau tanggal..."
               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />

        <select id="filterKelas" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Filter Kelas</option>
           @foreach (collect($riwayat)->pluck('nama_kelas')->unique()->sort() as $kelas)
            <option value="{{ strtolower($kelas) }}">{{ $kelas }}</option>
        @endforeach
        </select>

        <select id="filterStatus" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Filter Status</option>
            <option value="hadir">Hadir</option>
            <option value="terlambat">Terlambat</option>
            <option value="alpha">Alpha</option>
            <option value="alpha">Pulang Cepat</option>
        </select>

        <select id="filterJenis" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Filter Jenis</option>
            <option value="masuk">Masuk</option>
            <option value="pulang">Pulang</option>
        </select>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm" id="kehadiranTable">
            <thead class="bg-blue-50">
                <tr>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600 uppercase">Tanggal</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600 uppercase">Nama Siswa</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600 uppercase">Kelas</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600 uppercase">Waktu</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600 uppercase">Jenis</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600 uppercase">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse ($riwayat as $item)
                    <tr class="hover:bg-gray-50"
                        data-nama="{{ strtolower($item->nama_siswa) }}"
                        data-kelas="{{ strtolower($item->nama_kelas) }}"
                        data-tanggal="{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}"
                        data-status="{{ strtolower($item->status) }}"
                        data-jenis="{{ strtolower($item->jenis) }}">
                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                        <td class="px-6 py-4">{{ $item->nama_siswa }}</td>
                        <td class="px-6 py-4">{{ $item->nama_kelas }}</td>
                        <td class="px-6 py-4">{{ $item->waktu ?? '-' }}</td>
                        <td class="px-6 py-4">{{ ucfirst($item->jenis) }}</td>
                        <td class="px-6 py-4 space-y-1">
                            @php
                                $status = strtolower($item->status);
                                $statusClass = match($status) {
                                    'hadir'         => 'bg-green-100 text-green-700',
                                    'terlambat'     => 'bg-yellow-100 text-yellow-700',
                                    'alpha'         => 'bg-red-100 text-red-700',
                                    'cuti'          => 'bg-purple-100 text-purple-700',
                                    'izin'          => 'bg-blue-100 text-blue-700',
                                    'pulang_cepat'  => 'bg-orange-100 text-orange-700',
                                    default         => 'bg-gray-100 text-gray-700',
                                };
                            @endphp
                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full {{ $statusClass }} font-medium">
                                <i class="fas fa-circle"></i> {{ ucfirst($item->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-gray-500 py-6">Tidak ada data kehadiran siswa.</td>
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
    const filterJenis = document.getElementById('filterJenis');
    const filterKelas = document.getElementById('filterKelas');
    const rows = document.querySelectorAll('#kehadiranTable tbody tr');

    function applyFilters() {
        const searchValue = searchInput.value.toLowerCase();
        const selectedStatus = filterStatus.value.toLowerCase();
        const selectedJenis = filterJenis.value.toLowerCase();
        const selectedKelas = filterKelas.value.toLowerCase();

        rows.forEach(row => {
            const nama = row.dataset.nama;
            const tanggal = row.dataset.tanggal;
            const status = row.dataset.status;
            const jenis = row.dataset.jenis;
            const kelas = row.dataset.kelas;

            const matchesSearch = nama.includes(searchValue) || tanggal.includes(searchValue);
            const matchesStatus = !selectedStatus || status === selectedStatus;
            const matchesJenis = !selectedJenis || jenis === selectedJenis;
            const matchesKelas = !selectedKelas || kelas === selectedKelas;

            if (matchesSearch && matchesStatus && matchesJenis && matchesKelas) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    [searchInput, filterStatus, filterJenis, filterKelas].forEach(input =>
        input.addEventListener('input', applyFilters)
    );
</script>
@endsection
