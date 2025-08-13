@extends('layouts.siswa')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Riwayat Absensi</h2>

    {{-- FILTER --}}
    <div class="bg-white shadow-md rounded-lg p-4 mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex items-center gap-2">
            <label for="status" class="font-medium text-sm">Status:</label>
            <select id="status" name="status" class="border-gray-300 rounded-md shadow-sm text-sm">
                <option value="">Semua</option>
                <option value="hadir">Hadir</option>
                <option value="terlambat">Terlambat</option>
                <option value="alpha">Alpha</option>
                <option value="izin">Izin</option>
                <option value="cuti">Cuti</option>
                <option value="pulang cepat">Pulang Cepat</option>
            </select>
        </div>
        <div class="flex items-center gap-2">
            <label for="tanggal" class="font-medium text-sm">Tanggal:</label>
            <input type="date" id="tanggal" name="tanggal" class="border-gray-300 rounded-md shadow-sm text-sm">
        </div>
        <button onclick="filterTable()" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 text-sm font-semibold">
            Filter
        </button>
    </div>

    {{-- TABLE --}}
    <div class="overflow-x-auto shadow-md rounded-lg">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg">
            <thead class="bg-gray-100 text-sm text-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left font-semibold">Tanggal</th>
                    <th class="px-6 py-3 text-left font-semibold">Waktu Datang</th>
                    <th class="px-6 py-3 text-left font-semibold">Status Datang</th>
                    <th class="px-6 py-3 text-left font-semibold">Waktu Pulang</th>
                    <th class="px-6 py-3 text-left font-semibold">Status Pulang</th>
                    <th class="px-6 py-3 text-left font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody id="absensiTableBody">
                @forelse($riwayat as $absen)
                    @php
                        $tanggalFormatted = \Carbon\Carbon::parse($absen->tanggal)->translatedFormat('d F Y');
                        $tanggalValue = \Carbon\Carbon::parse($absen->tanggal)->format('Y-m-d');
                        $lokasi = $absen->lokasi ?? '-';
                        $foto = $absen->foto ? asset('storage/' . $absen->foto) : '';
                        $warnaStatus = function ($status) {
                            return match(strtolower($status)) {
                                'hadir' => 'text-green-700 bg-green-100',
                                'terlambat' => 'text-yellow-700 bg-yellow-100',
                                'alpha' => 'text-red-700 bg-red-100',
                                'cuti' => 'text-purple-700 bg-purple-100',
                                'izin' => 'text-blue-700 bg-blue-100',
                                'pulang cepat' => 'text-orange-700 bg-orange-100',
                                default => 'text-gray-700 bg-gray-100',
                            };
                        };
                    @endphp
                    <tr class="hover:bg-gray-50 cursor-pointer"
                        data-nama="{{ Auth::user()->name }}"
                        data-tanggal="{{ $tanggalFormatted }}"
                        data-tanggal-value="{{ $tanggalValue }}"
                        data-status="{{ strtolower($absen->status_datang) }}"
                        data-waktu-datang="{{ $absen->waktu_datang ?? '-' }}"
                        data-status-datang="{{ ucfirst($absen->status_datang) }}"
                        data-waktu-pulang="{{ $absen->waktu_pulang ?? '-' }}"
                        data-status-pulang="{{ ucfirst($absen->status_pulang) }}"
                        data-lokasi="{{ $lokasi }}"
                        data-foto="{{ $foto }}">
                        <td class="px-6 py-4">{{ $tanggalFormatted }}</td>
                        <td class="px-6 py-4">{{ $absen->waktu_datang ?? '-' }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-block px-3 py-1 rounded-full font-medium {{ $warnaStatus($absen->status_datang) }}">
                                {{ ucfirst($absen->status_datang) ?? '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">{{ $absen->waktu_pulang ?? '-' }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-block px-3 py-1 rounded-full font-medium {{ $warnaStatus($absen->status_pulang) }}">
                                {{ ucfirst($absen->status_pulang) ?? '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <button onclick="showDetailModal(this)" class="text-blue-600 hover:underline font-semibold text-sm">Lihat Detail</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-gray-500">Belum ada data kehadiran.</td>
                    </tr>
                @endforelse
                <tr id="noDataRow" style="display: none;">
    <td colspan="6" class="text-center py-4 text-gray-500">Data tidak ditemukan.</td>
</tr>

            </tbody>
        </table>
    </div>
</div>

{{-- MODAL --}}
<div id="detailModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center px-4">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-lg p-6 relative">
        <button onclick="closeModal()" class="absolute top-3 right-4 text-gray-400 hover:text-gray-600 text-2xl font-bold">&times;</button>
        <h3 class="text-2xl font-bold text-gray-800 mb-4 border-b pb-2">Detail Kehadiran</h3>
        <div class="space-y-3 text-gray-700 text-sm">
            <div class="flex justify-between"><span class="font-medium w-1/3">Nama:</span><span id="modalNama" class="w-2/3 text-right"></span></div>
            <div class="flex justify-between"><span class="font-medium w-1/3">Tanggal:</span><span id="modalTanggal" class="w-2/3 text-right"></span></div>
            <div class="flex justify-between"><span class="font-medium w-1/3">Waktu Datang:</span><span id="modalWaktuDatang" class="w-2/3 text-right"></span></div>
            <div class="flex justify-between"><span class="font-medium w-1/3">Status Datang:</span><span id="modalStatusDatang" class="w-2/3 text-right font-semibold text-yellow-600"></span></div>
            <div class="flex justify-between"><span class="font-medium w-1/3">Waktu Pulang:</span><span id="modalWaktuPulang" class="w-2/3 text-right"></span></div>
            <div class="flex justify-between"><span class="font-medium w-1/3">Status Pulang:</span><span id="modalStatusPulang" class="w-2/3 text-right font-semibold text-red-600"></span></div>
            <div class="flex justify-between"><span class="font-medium w-1/3">Lokasi:</span><span id="modalLokasi" class="w-2/3 text-right truncate" title=""></span></div>
        </div>
        <div class="mt-6">
            <p class="text-sm font-medium text-gray-700 mb-2">Foto Absen:</p>
            <div class="border rounded-lg overflow-hidden max-h-64">
                <img id="modalFoto" src="" alt="Foto Absen" class="w-full object-contain">
            </div>
        </div>
    </div>
</div>

{{-- SCRIPT --}}
<script>
    function showDetailModal(button) {
        const row = button.closest('tr');
        document.getElementById('modalNama').textContent = row.dataset.nama;
        document.getElementById('modalTanggal').textContent = row.dataset.tanggal;
        document.getElementById('modalWaktuDatang').textContent = row.dataset.waktuDatang;
        document.getElementById('modalStatusDatang').textContent = row.dataset.statusDatang;
        document.getElementById('modalWaktuPulang').textContent = row.dataset.waktuPulang;
        document.getElementById('modalStatusPulang').textContent = row.dataset.statusPulang;
        document.getElementById('modalLokasi').textContent = row.dataset.lokasi;
        document.getElementById('modalFoto').src = row.dataset.foto;
        document.getElementById('detailModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('detailModal').classList.add('hidden');
    }

  function filterTable() {
    const statusFilter = document.getElementById('status').value.toLowerCase();
    const tanggalFilter = document.getElementById('tanggal').value;
    const rows = document.querySelectorAll('#absensiTableBody tr');
    const noDataRow = document.getElementById('noDataRow');

    let visibleCount = 0;

    rows.forEach(row => {
        // Lewati baris 'noDataRow'
        if (row.id === 'noDataRow') return;

        const status = row.dataset.status;
        const tanggal = row.dataset.tanggalValue;

        const matchStatus = !statusFilter || status === statusFilter;
        const matchTanggal = !tanggalFilter || tanggal === tanggalFilter;

        const isVisible = matchStatus && matchTanggal;
        row.style.display = isVisible ? '' : 'none';

        if (isVisible) visibleCount++;
    });

    // Tampilkan atau sembunyikan baris "Data tidak ditemukan"
    noDataRow.style.display = visibleCount === 0 ? '' : 'none';
}

</script>
@endsection


