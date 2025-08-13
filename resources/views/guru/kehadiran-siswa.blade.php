@extends('layouts.guru')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Riwayat Kehadiran Siswa</h2>

    {{-- Alert --}}
    @if (session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">{{ session('success') }}</div>
    @elseif (session('error'))
        <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">{{ session('error') }}</div>
    @endif

<div class="bg-white shadow-md rounded-lg p-4 mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 flex-wrap">

        {{-- Filter Tanggal --}}
        <div class="flex items-center gap-2">
            <label for="tanggal" class="text-sm font-medium whitespace-nowrap">Tanggal:</label>
            <input type="date" id="tanggal" name="tanggal" class="border-gray-300 rounded-md shadow-sm text-sm">
        </div>

        {{-- Filter Status --}}
        <div class="flex items-center gap-2">
            <label for="statusFilter" class="text-sm font-medium whitespace-nowrap">Status:</label>
            <select id="statusFilter" class="border-gray-300 rounded-md shadow-sm text-sm">
                <option value="">Semua Status</option>
                <option value="hadir">Hadir</option>
                <option value="terlambat">Terlambat</option>
                <option value="alpha">Alpha</option>
                <option value="izin">Izin</option>
                <option value="pulang cepat">Pulang Cepat</option>
            </select>
        </div>

        {{-- Input Bulan --}}
        <div class="flex items-center gap-2">
            <label for="bulan" class="text-sm font-medium whitespace-nowrap">Pilih Bulan:</label>
            <input type="month" id="bulan" name="bulan" class="border-gray-300 rounded-md shadow-sm text-sm">
        </div>

        {{-- Tombol Filter --}}
        <div class="flex items-center gap-2">
            <button onclick="filterTable()" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 text-sm font-semibold">
                Filter
            </button>

            {{-- Tombol Download --}}
           <form id="downloadForm" method="GET" action="{{ route('guru.downloadRekapKehadiran') }}">
                <input type="hidden" name="bulan" id="bulanHidden">
                <button type="button" onclick="handleDownload()" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 text-sm font-semibold">
                    Download
                </button>
            </form>
        </div>

    </div>
</div>

<script>
    // Sync bulan dari input ke hidden input form download
    document.getElementById('bulan').addEventListener('change', function () {
        document.getElementById('bulanHidden').value = this.value;
    });
</script>


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
                        data-nama="{{ $item->nama_siswa }}"
                        data-kelas="{{ strtolower($item->nama_kelas) }}"
                        data-tanggal="{{ $tanggal }}"
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
                        <td class="px-6 py-4"><span class="inline-block px-3 py-1 rounded-full font-medium {{ $warnaStatus($item->status_datang) }}">{{ ucfirst($item->status_datang) ?? '-' }}</span></td>
                        <td class="px-6 py-4">{{ $item->waktu_pulang ?? '-' }}</td>
                        <td class="px-6 py-4"><span class="inline-block px-3 py-1 rounded-full font-medium {{ $warnaStatus($item->status_pulang) }}">{{ ucfirst($item->status_pulang) ?? '-' }}</span></td>
                        <td class="px-6 py-4 text-center"><button onclick="showDetailModal(this)" class="text-blue-600 hover:underline font-semibold text-sm">Lihat Detail</button></td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center py-4 text-gray-500">Tidak ada data kehadiran.</td></tr>
                @endforelse
                    <tr id="noDataRow" style="display: none;">
    <td colspan="8" class="text-center py-4 text-gray-500">
        Data tidak ditemukan
    </td>
</tr>

            </tbody>
        </table>
    </div>
</div>

{{-- Modal --}}
<div id="detailModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-lg max-w-lg w-full mx-4 p-6 relative overflow-y-auto max-h-[90vh]">
        <button onclick="closeModal()" class="absolute top-3 right-3 text-gray-500 hover:text-gray-800 text-xl font-bold">&times;</button>
        <h2 class="text-xl font-bold mb-4 border-b pb-2">Detail Kehadiran</h2>

        <form method="POST" action="{{ route('guru.updateStatusKehadiran') }}">
            @csrf
            <input type="hidden" name="tanggal" id="formTanggal">
            <input type="hidden" name="nama" id="formNama">

            <div class="grid grid-cols-2 gap-4 text-gray-700 text-sm">
                <div><p class="font-semibold">Nama</p><p id="modalNama"></p></div>
                <div><p class="font-semibold">Kelas</p><p id="modalKelas"></p></div>
                <div><p class="font-semibold">Tanggal</p><p id="modalTanggal"></p></div>
                <div><p class="font-semibold">Waktu Datang</p><p id="modalWaktuDatang"></p></div>
                <div><p class="font-semibold">Waktu Pulang</p><p id="modalWaktuPulang"></p></div>
                <div class="col-span-2"><p class="font-semibold mb-2">Foto Absen</p><img id="modalFoto" src="" alt="Foto Absen" class="rounded-lg max-h-64 w-full object-contain border" /></div>
            </div>

            <div class="grid grid-cols-2 gap-4 mt-6">
                <div>
                    <label class="font-semibold text-sm block mb-1">Status Datang</label>
                    <select name="status_datang" id="selectStatusDatang" class="border rounded w-full text-sm">
                        <option value="hadir">Hadir</option>
                        <option value="terlambat">Terlambat</option>
                        <option value="alpha">Alpha</option>
                        <option value="izin">Izin</option>
                        <option value="cuti">cuti</option>
                    </select>
                </div>
                <div>
                    <label class="font-semibold text-sm block mb-1">Status Pulang</label>
                    <select name="status_pulang" id="selectStatusPulang" class="border rounded w-full text-sm">
                        <option value="tepat">tepat</option>
                        <option value="bolos">bolos</option>
                        <option value="alpha">Alpha</option>
                        <option value="izin">Izin</option>
                        <option value="cuti">cuti</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="mt-6 bg-green-600 text-white rounded-md px-5 py-2 hover:bg-green-700 transition w-full">Simpan Perubahan</button>
        </form>
    </div>
</div>

<script>
    function showDetailModal(button) {
        const row = button.closest('tr');
        document.getElementById('modalNama').textContent = row.getAttribute('data-nama');
        document.getElementById('modalKelas').textContent = row.getAttribute('data-kelas');
        document.getElementById('modalTanggal').textContent = row.getAttribute('data-tanggal');
        document.getElementById('modalWaktuDatang').textContent = row.getAttribute('data-waktu-datang') || '-';
        document.getElementById('modalWaktuPulang').textContent = row.getAttribute('data-waktu-pulang') || '-';
        document.getElementById('modalFoto').src = row.getAttribute('data-foto') || '';

        document.getElementById('formTanggal').value = row.getAttribute('data-tanggal-asli');
        document.getElementById('formNama').value = row.getAttribute('data-nama');
        document.getElementById('selectStatusDatang').value = row.getAttribute('data-status-datang');
        document.getElementById('selectStatusPulang').value = row.getAttribute('data-status-pulang');

        document.getElementById('detailModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        document.getElementById('detailModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    function filterTable() {
    const selectedTanggal = document.getElementById('tanggal').value;
    const selectedStatus = document.getElementById('statusFilter').value.toLowerCase();

    const rows = document.querySelectorAll('#dataKehadiran tr:not(#noDataRow)');
    const noDataRow = document.getElementById('noDataRow');

    let visibleCount = 0;

    rows.forEach(row => {
        const tanggal = row.getAttribute('data-tanggal-asli');
        const statusDatang = row.getAttribute('data-status-datang');
        const statusPulang = row.getAttribute('data-status-pulang');

        const matchTanggal = !selectedTanggal || selectedTanggal === tanggal;
        const matchStatus = !selectedStatus || statusDatang === selectedStatus || statusPulang === selectedStatus;

        if (matchTanggal && matchStatus) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });

    // Tampilkan atau sembunyikan baris "tidak ada data"
    noDataRow.style.display = visibleCount === 0 ? '' : 'none';
}

</script>
<script>
    function handleDownload() {
        const bulan = document.getElementById('bulan').value;

        if (!bulan) {
            Swal.fire({
                icon: 'warning',
                title: 'Harap Pilih Bulan',
                text: 'Silakan pilih bulan terlebih dahulu sebelum mengunduh rekap.',
                confirmButtonColor: '#3085d6'
            });
        } else {
            // Sync hidden input lalu submit form
            document.getElementById('bulanHidden').value = bulan;
            document.getElementById('downloadForm').submit();
        }
    }
</script>

@endsection
