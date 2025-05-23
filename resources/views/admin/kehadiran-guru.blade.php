@extends('layouts.admin')

@section('title', 'Kehadiran Guru')

@section('content')
<div class="max-w-6xl mx-auto bg-white rounded-xl shadow-lg p-6">
    <h1 class="text-2xl font-extrabold text-gray-800 mb-6">📋 Kehadiran Guru</h1>

    {{-- Filter Section --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
        <input type="text" id="searchInput" placeholder="Cari nama atau tanggal..."
            class="w-full md:w-1/3 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />

        <select id="filterStatus" class="w-full md:w-1/4 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Filter Status</option>
            <option value="hadir">Hadir</option>
            <option value="terlambat">Terlambat</option>
            <option value="alpha">Alpha</option>
            <option value="cuti">Cuti</option>
        </select>

        <select id="filterJenis" class="w-full md:w-1/4 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
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
                    <th class="w-32 px-4 py-3 text-left font-semibold text-gray-600 uppercase">Tanggal</th>
                    <th class="w-48 px-4 py-3 text-left font-semibold text-gray-600 uppercase">Nama Guru</th>
                    <th class="w-32 px-4 py-3 text-left font-semibold text-gray-600 uppercase">Waktu</th>
                    <th class="w-28 px-4 py-3 text-left font-semibold text-gray-600 uppercase">Jenis</th>
                    <th class="w-24 px-4 py-3 text-left font-semibold text-gray-600 uppercase">Status</th>
                    <th class="w-40 px-4 py-3 text-left font-semibold text-gray-600 uppercase">Aksi</th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-100">
                @forelse ($riwayat as $item)
                    @php
                        $status = strtolower($item->status);
                        $statusClass = match($status) {
                            'hadir' => 'bg-green-100 text-green-700',
                            'terlambat' => 'bg-yellow-100 text-yellow-700',
                            'alpha' => 'bg-red-100 text-red-700',
                            'cuti' => 'bg-purple-100 text-purple-700',
                            default => 'bg-gray-100 text-gray-700',
                        };
                    @endphp
                    <tr class="hover:bg-gray-50"
                        data-nama="{{ strtolower($item->nama_guru) }}"
                        data-tanggal="{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}"
                        data-status="{{ strtolower($item->status) }}"
                        data-jenis="{{ strtolower($item->jenis) }}">
                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                        <td class="px-6 py-4">{{ $item->nama_guru }}</td>
                        <td class="px-6 py-4">{{ $item->waktu ?? '-' }}</td>
                        <td class="px-6 py-4">{{ ucfirst($item->jenis) }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full {{ $statusClass }} font-medium">
                                    <i class="fas fa-circle"></i> {{ ucfirst($item->status) }}
                                </span>
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <button
                                onclick="openStatusModal('{{ $item->id_users }}', '{{ $item->tanggal }}', '{{ strtolower($item->status) }}')"
                                class="text-blue-600 hover:underline text-sm font-medium">
                                Ubah Status
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-gray-500 py-6">Tidak ada data kehadiran guru.</td>
                    </tr>
                @endforelse
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
            <label for="status" class="block font-medium mb-2">Status:</label>
            <select name="status" id="modalStatus" class="w-full border-gray-300 rounded-lg px-4 py-2 mb-4">
                <option value="hadir">Hadir</option>
                <option value="izin">izin</option>
                <option value="terlambat">Terlambat</option>
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
    function openStatusModal(idUsers, tanggal, currentStatus) {
        document.getElementById('modalIdUsers').value = idUsers;
        document.getElementById('modalTanggal').value = tanggal;
        document.getElementById('modalStatus').value = currentStatus;
        document.getElementById('statusModal').classList.remove('hidden');
        document.getElementById('statusModal').classList.add('flex');
    }

    function closeStatusModal() {
        document.getElementById('statusModal').classList.remove('flex');
        document.getElementById('statusModal').classList.add('hidden');
    }

    // FILTER JS
    const searchInput = document.getElementById('searchInput');
    const filterStatus = document.getElementById('filterStatus');
    const filterJenis = document.getElementById('filterJenis');
    const rows = document.querySelectorAll('#kehadiranTable tbody tr');

    function applyFilters() {
        const searchValue = searchInput.value.toLowerCase();
        const selectedStatus = filterStatus.value.toLowerCase();
        const selectedJenis = filterJenis.value.toLowerCase();

        rows.forEach(row => {
            const nama = row.dataset.nama;
            const tanggal = row.dataset.tanggal;
            const status = row.dataset.status;
            const jenis = row.dataset.jenis;

            const matchesSearch = nama.includes(searchValue) || tanggal.includes(searchValue);
            const matchesStatus = !selectedStatus || status === selectedStatus;
            const matchesJenis = !selectedJenis || jenis === selectedJenis;

            row.style.display = (matchesSearch && matchesStatus && matchesJenis) ? '' : 'none';
        });
    }

    searchInput.addEventListener('input', applyFilters);
    filterStatus.addEventListener('change', applyFilters);
    filterJenis.addEventListener('change', applyFilters);
</script>
@endsection
