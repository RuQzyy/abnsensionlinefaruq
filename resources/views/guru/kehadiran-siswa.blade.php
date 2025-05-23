@extends('layouts.guru')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Riwayat Kehadiran Siswa</h2>

    {{-- FILTER --}}
    <div class="bg-white shadow-md rounded-lg p-4 mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex items-center gap-2">
            <label for="tanggal" class="font-medium text-sm">Tanggal:</label>
            <input type="date" id="tanggal" name="tanggal" class="border-gray-300 rounded-md shadow-sm text-sm">
        </div>

        <select id="kelasFilter" class="border-gray-300 rounded-md shadow-sm text-sm">
            <option value="">Semua Kelas</option>
            @foreach ($class as $kelas)
                <option value="{{ strtolower($kelas->nama_kelas) }}">{{ $kelas->nama_kelas }}</option>
            @endforeach
        </select>

        <select id="statusFilter" class="border-gray-300 rounded-md shadow-sm text-sm">
            <option value="">Filter Status</option>
            <option value="hadir">Hadir</option>
            <option value="terlambat">Terlambat</option>
            <option value="alpha">Alpha</option>
            <option value="izin">Izin</option>
            <option value="pulang cepat">Pulang Cepat</option>
        </select>

        <button onclick="resetFilters()" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 text-sm font-semibold">Reset Filter</button>
    </div>

    {{-- TABLE --}}
    <div class="overflow-x-auto shadow-md rounded-lg">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg text-sm">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left font-semibold">Tanggal</th>
                    <th class="px-6 py-3 text-left font-semibold">Nama Siswa</th>
                    <th class="px-6 py-3 text-left font-semibold">Kelas</th>
                    <th class="px-6 py-3 text-left font-semibold">Waktu Datang</th>
                    <th class="px-6 py-3 text-left font-semibold">Status Datang</th>
                    <th class="px-6 py-3 text-left font-semibold">Waktu Pulang</th>
                    <th class="px-6 py-3 text-left font-semibold">Status Pulang</th>
                    <th class="px-6 py-3 text-center font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody id="dataKehadiran">
                @forelse ($riwayat as $item)
                    @php
                        $tanggal = \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y');
                        $warnaStatus = fn($status) => match(strtolower($status)) {
                            'hadir' => 'text-green-700 bg-green-100',
                            'terlambat' => 'text-yellow-700 bg-yellow-100',
                            'alpha' => 'text-red-700 bg-red-100',
                            'izin' => 'text-blue-700 bg-blue-100',
                            'pulang cepat' => 'text-orange-700 bg-orange-100',
                            default => 'text-gray-700 bg-gray-100',
                        };
                        $fotoPath = $item->foto ? asset('storage/' . $item->foto) : '';
                    @endphp
                    <tr class="hover:bg-gray-50 transition"
                        data-nama="{{ strtolower($item->nama_siswa) }}"
                        data-kelas="{{ strtolower($item->nama_kelas) }}"
                        data-tanggal="{{ strtolower($tanggal) }}"
                        data-tanggal-asli="{{ $item->tanggal }}"
                        data-status-datang="{{ strtolower($item->status_datang) }}"
                        data-status-pulang="{{ strtolower($item->status_pulang) }}"
                        data-waktu-datang="{{ $item->waktu_datang }}"
                        data-waktu-pulang="{{ $item->waktu_pulang }}"
                        data-foto="{{ $fotoPath }}">
                        <td class="px-6 py-4">{{ $tanggal }}</td>
                        <td class="px-6 py-4">{{ $item->nama_siswa }}</td>
                        <td class="px-6 py-4">{{ $item->nama_kelas }}</td>
                        <td class="px-6 py-4">{{ $item->waktu_datang ?? '-' }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-block px-3 py-1 rounded-full font-medium {{ $warnaStatus($item->status_datang) }}">
                                {{ ucfirst($item->status_datang) ?? '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">{{ $item->waktu_pulang ?? '-' }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-block px-3 py-1 rounded-full font-medium {{ $warnaStatus($item->status_pulang) }}">
                                {{ ucfirst($item->status_pulang) ?? '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <button onclick="showDetailModal(this)" class="text-blue-600 hover:underline font-semibold text-sm">Lihat Detail</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-gray-500">Tidak ada data kehadiran.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Modal --}}
<div id="detailModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-lg max-w-lg w-full mx-4 p-6 relative overflow-y-auto max-h-[90vh]">
        <button onclick="closeModal()" class="absolute top-3 right-3 text-gray-500 hover:text-gray-800 text-xl font-bold">&times;</button>
        <h2 class="text-xl font-bold mb-4 border-b pb-2">Detail Kehadiran</h2>

        <div class="grid grid-cols-2 gap-4 text-gray-700 text-sm">
            <div><p class="font-semibold">Nama</p><p id="modalNama" class="truncate"></p></div>
            <div><p class="font-semibold">Kelas</p><p id="modalKelas" class="truncate"></p></div>
            <div><p class="font-semibold">Tanggal</p><p id="modalTanggal"></p></div>
            <div><p class="font-semibold">Waktu Datang</p><p id="modalWaktuDatang"></p></div>
            <div><p class="font-semibold">Status Datang</p><p id="modalStatusDatang"></p></div>
            <div><p class="font-semibold">Waktu Pulang</p><p id="modalWaktuPulang"></p></div>
            <div><p class="font-semibold">Status Pulang</p><p id="modalStatusPulang"></p></div>
            <div class="col-span-2 mt-4">
                <p class="font-semibold mb-2">Foto Absen</p>
                <img id="modalFoto" src="" alt="Foto Absen" class="rounded-lg max-h-64 w-full object-contain border" />
            </div>
        </div>

        <button onclick="closeModal()" class="mt-6 bg-blue-600 text-white rounded-md px-5 py-2 hover:bg-blue-700 transition w-full">Tutup</button>
    </div>
</div>

<script>
    function showDetailModal(button) {
        const row = button.closest('tr');
        document.getElementById('modalNama').textContent = row.getAttribute('data-nama');
        document.getElementById('modalKelas').textContent = row.getAttribute('data-kelas');
        document.getElementById('modalTanggal').textContent = row.getAttribute('data-tanggal');
        document.getElementById('modalWaktuDatang').textContent = row.getAttribute('data-waktu-datang') || '-';
        document.getElementById('modalStatusDatang').innerHTML = formatStatus(row.getAttribute('data-status-datang'));
        document.getElementById('modalWaktuPulang').textContent = row.getAttribute('data-waktu-pulang') || '-';
        document.getElementById('modalStatusPulang').innerHTML = formatStatus(row.getAttribute('data-status-pulang'));
        document.getElementById('modalFoto').src = row.getAttribute('data-foto') || '';
        document.getElementById('detailModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        document.getElementById('detailModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    function formatStatus(status) {
        const cls = {
            'hadir': 'text-green-700 bg-green-100',
            'terlambat': 'text-yellow-700 bg-yellow-100',
            'alpha': 'text-red-700 bg-red-100',
            'izin': 'text-blue-700 bg-blue-100',
            'pulang cepat': 'text-orange-700 bg-orange-100',
        };
        const kelas = cls[status?.toLowerCase()] || 'text-gray-700 bg-gray-100';
        return `<span class="${kelas} px-3 py-1 rounded-full inline-block">${status}</span>`;
    }

    // Filter logic
    const kelasFilter = document.getElementById('kelasFilter');
    const statusFilter = document.getElementById('statusFilter');
    const tanggalFilter = document.getElementById('tanggal');
    const rows = document.querySelectorAll('#dataKehadiran tr');

    function applyFilters() {
        const selectedKelas = kelasFilter.value.toLowerCase();
        const selectedStatus = statusFilter.value.toLowerCase();
        const selectedTanggal = tanggalFilter.value;

        rows.forEach(row => {
            const kelas = row.getAttribute('data-kelas');
            const statusDatang = row.getAttribute('data-status-datang');
            const statusPulang = row.getAttribute('data-status-pulang');
            const tanggal = row.getAttribute('data-tanggal-asli');

            const matchKelas = !selectedKelas || kelas === selectedKelas;
            const matchStatus = !selectedStatus || statusDatang === selectedStatus || statusPulang === selectedStatus;
            const matchTanggal = !selectedTanggal || tanggal === selectedTanggal;

            row.style.display = (matchKelas && matchStatus && matchTanggal) ? '' : 'none';
        });
    }

    kelasFilter.addEventListener('change', applyFilters);
    statusFilter.addEventListener('change', applyFilters);
    tanggalFilter.addEventListener('change', applyFilters);

    function resetFilters() {
        kelasFilter.value = '';
        statusFilter.value = '';
        tanggalFilter.value = '';
        applyFilters();
    }
</script>
@endsection
