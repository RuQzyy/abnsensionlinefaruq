@extends('layouts.admin')

@section('title', 'Kehadiran Siswa')

@section('content')
<div class="max-w-7xl mx-auto bg-white rounded-xl shadow-lg p-6">
    <h1 class="text-2xl font-extrabold text-gray-800 mb-6">📋 Kehadiran Siswa</h1>

    {{-- Filter Section --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <input type="date" id="filterTanggal"
               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm" />

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
                    <th class="px-4 py-3 text-left font-semibold text-gray-600 uppercase">Waktu Datang</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600 uppercase">Status Datang</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600 uppercase">Waktu Pulang</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600 uppercase">Status Pulang</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600 uppercase">Aksi</th>
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
                        data-tanggal_raw="{{ \Carbon\Carbon::parse($item->tanggal)->format('Y-m-d') }}"
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
                        <td class="px-4 py-3">
                            <button onclick="openStatusModal('{{ $item->id_users }}', '{{ $item->tanggal }}')" class="text-blue-600 hover:underline text-sm font-medium">
                                Ubah Status
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-gray-500 py-6">Tidak ada data kehadiran siswa.</td>
                    </tr>
                @endforelse
                  {{-- Pesan untuk hasil filter --}}
    <tr id="noDataRow" style="display: none;">
        <td colspan="7" class="text-center text-gray-500 py-6">Tidak ada absensi pada tanggal ini.</td>
    </tr>
            </tbody>
        </table>
    </div>
</div>

{{-- Modal --}}
<div id="statusModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden justify-center items-center">
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
        <h2 class="text-xl font-bold mb-4">Ubah Status Kehadiran Siswa</h2>
        <form method="POST" action="{{ route('ubah.status.kehadiran.siswa') }}">
            @csrf
            <input type="hidden" name="id_users" id="modalIdUsers">
            <input type="hidden" name="tanggal" id="modalTanggal">
            <label class="block font-medium mb-2">Status Datang:</label>
            <select name="status_datang" id="modalStatusDatang" class="w-full border-gray-300 rounded-lg px-4 py-2 mb-4">
                <option value="hadir">Hadir</option>
                <option value="terlambat">Terlambat</option>
                <option value="alpha">Alpha</option>
                <option value="cuti">Cuti</option>
                <option value="izin">Izin</option>
            </select>
            <label class="block font-medium mb-2">Status Pulang:</label>
            <select name="status_pulang" id="modalStatusPulang" class="w-full border-gray-300 rounded-lg px-4 py-2 mb-4">
                <option value="tepat">Tepat</option>
                <option value="bolos">Bolos</option>
                <option value="izin">Izin</option>
                <option value="alpha">Alpha</option>
                <option value="cuti">Cuti</option>
            </select>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeStatusModal()" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- Script --}}
<script>
    const filterTanggal = document.getElementById('filterTanggal');
    const filterStatus = document.getElementById('filterStatus');
    const filterKelas = document.getElementById('filterKelas');
    const rows = document.querySelectorAll('#kehadiranTable tbody tr');

  function applyFilters() {
    const selectedTanggal = filterTanggal.value;
    const selectedStatus = filterStatus.value.toLowerCase();
    const selectedKelas = filterKelas.value.toLowerCase();
    const noDataRow = document.getElementById('noDataRow');

    let visibleCount = 0;

    rows.forEach(row => {
        // Jangan filter baris pesan
        if (row.id === 'noDataRow' || row.cells.length === 1) return;

        const tanggalRow = row.dataset.tanggal_raw;
        const status = row.dataset.status;
        const kelas = row.dataset.kelas;

        const matchTanggal = !selectedTanggal || tanggalRow === selectedTanggal;
        const matchStatus = !selectedStatus || status.includes(selectedStatus);
        const matchKelas = !selectedKelas || kelas === selectedKelas;

        if (matchTanggal && matchStatus && matchKelas) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });

    // Tampilkan pesan jika tidak ada data hasil filter
    noDataRow.style.display = visibleCount === 0 ? '' : 'none';
}


    [filterTanggal, filterStatus, filterKelas].forEach(input =>
        input.addEventListener('input', applyFilters)
    );

    function openStatusModal(idUsers, tanggal) {
        document.getElementById('modalIdUsers').value = idUsers;
        document.getElementById('modalTanggal').value = tanggal;
        document.getElementById('statusModal').classList.remove('hidden');
        document.getElementById('statusModal').classList.add('flex');
    }

    function closeStatusModal() {
        document.getElementById('statusModal').classList.remove('flex');
        document.getElementById('statusModal').classList.add('hidden');
    }
</script>
@endsection
