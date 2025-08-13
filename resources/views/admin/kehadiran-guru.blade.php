@extends('layouts.admin')

@section('title', 'Kehadiran Guru')

@section('content')
<div class="max-w-6xl mx-auto bg-white rounded-xl shadow-lg p-6">
    <h1 class="text-2xl font-extrabold text-gray-800 mb-6">📋 Kehadiran Guru</h1>

    {{-- Filter Section --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4 flex-wrap">
        <input type="date" id="filterTanggal"
            class="w-full md:w-1/3 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm" />

        <select id="filterStatus"
            class="w-full md:w-1/4 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
            <option value="">Filter Status</option>
            <option value="hadir">Hadir</option>
            <option value="terlambat">Terlambat</option>
            <option value="alpha">Alpha</option>
            <option value="cuti">Cuti</option>
            <option value="izin">Izin</option>
            <option value="pulang_cepat">Pulang Cepat</option>
        </select>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm" id="kehadiranTable">
            <thead class="bg-blue-50">
                <tr>
                    <th class="w-32 px-4 py-3 text-left font-semibold text-gray-600 uppercase">Tanggal</th>
                    <th class="w-48 px-4 py-3 text-left font-semibold text-gray-600 uppercase">Nama Guru</th>
                    <th class="w-32 px-4 py-3 text-left font-semibold text-gray-600 uppercase">Waktu Datang</th>
                    <th class="w-32 px-4 py-3 text-left font-semibold text-gray-600 uppercase">Status Datang</th>
                    <th class="w-32 px-4 py-3 text-left font-semibold text-gray-600 uppercase">Waktu Pulang</th>
                    <th class="w-32 px-4 py-3 text-left font-semibold text-gray-600 uppercase">Status Pulang</th>
                    <th class="w-40 px-4 py-3 text-left font-semibold text-gray-600 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100" id="kehadiranBody">
    @forelse ($riwayat as $item)
        @php
            $statusDatang = strtolower($item->status_datang);
            $statusPulang = strtolower($item->status_pulang);
            $statusDatangClass = match($statusDatang) {
                'hadir' => 'bg-green-100 text-green-700',
                'terlambat' => 'bg-yellow-100 text-yellow-700',
                'alpha' => 'bg-red-100 text-red-700',
                'cuti' => 'bg-purple-100 text-purple-700',
                default => 'bg-gray-100 text-gray-700',
            };
            $statusPulangClass = match($statusPulang) {
                'pulang_cepat' => 'bg-orange-100 text-orange-700',
                'alpha' => 'bg-red-100 text-red-700',
                'cuti' => 'bg-purple-100 text-purple-700',
                'hadir' => 'bg-green-100 text-green-700',
                default => 'bg-gray-100 text-gray-700',
            };
        @endphp
        <tr class="hover:bg-gray-50"
            data-nama="{{ strtolower($item->nama_guru) }}"
            data-tanggal_raw="{{ \Carbon\Carbon::parse($item->tanggal)->format('Y-m-d') }}"
            data-status="{{ $statusDatang . ' ' . $statusPulang }}">
            <td class="px-4 py-3">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
            <td class="px-4 py-3">{{ $item->nama_guru }}</td>
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
                <button
                    onclick="openStatusModal('{{ $item->id_users }}', '{{ $item->tanggal }}')"
                    class="text-blue-600 hover:underline text-sm font-medium">
                    Ubah Status
                </button>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="7" class="text-center text-gray-500 py-6">Tidak ada data kehadiran guru.</td>
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
        <h2 class="text-xl font-bold mb-4">Ubah Status Kehadiran</h2>
        <form method="POST" action="{{ route('ubah.status.kehadiran') }}">
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

  const filterTanggal = document.getElementById('filterTanggal');
const filterStatus = document.getElementById('filterStatus');
const rows = document.querySelectorAll('#kehadiranTable tbody tr[data-tanggal_raw]');
const noDataRow = document.getElementById('noDataRow');

function applyFilters() {
    const selectedTanggal = filterTanggal.value;
    const selectedStatus = filterStatus.value.toLowerCase();
    let visibleCount = 0;

    rows.forEach(row => {
        const tanggalRow = row.dataset.tanggal_raw;
        const status = row.dataset.status;

        const matchTanggal = !selectedTanggal || tanggalRow === selectedTanggal;
        const matchStatus = !selectedStatus || status.includes(selectedStatus);

        if (matchTanggal && matchStatus) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });

    // Tampilkan pesan jika tidak ada data hasil filter
    noDataRow.style.display = visibleCount === 0 ? '' : 'none';
}

[filterTanggal, filterStatus].forEach(input =>
    input.addEventListener('input', applyFilters)
);

</script>
@endsection
