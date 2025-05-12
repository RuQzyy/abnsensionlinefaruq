@extends('layouts.guru')

@section('title', 'Riwayat Kehadiran')

@section('content')
<div class="max-w-6xl mx-auto bg-white rounded-xl shadow-lg p-6">
    <h1 class="text-2xl font-extrabold text-gray-800 mb-6">📅 Riwayat Kehadiran Siswa</h1>

    {{-- Filter Section --}}
    <form class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
        <input type="text" placeholder="Cari tanggal atau nama siswa..." 
               class="w-full md:w-1/3 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
        
        <select class="w-full md:w-1/4 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Pilih Kelas</option>
            <option value="10ipa1">Kelas 10 IPA 1</option>
            <option value="10ipa2">Kelas 10 IPA 2</option>
            <option value="11ips1">Kelas 11 IPS 1</option>
        </select>

        <select class="w-full md:w-1/4 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Filter Status</option>
            <option value="hadir">Hadir</option>
            <option value="terlambat">Terlambat</option>
            <option value="alpha">Alpha</option>
        </select>

        <button type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-sm">
            Filter
        </button>
    </form>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-blue-50">
                <tr>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600 uppercase">Tanggal</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600 uppercase">Nama Siswa</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600 uppercase">Kelas</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600 uppercase">Foto</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600 uppercase">Waktu</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600 uppercase">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                {{-- Hadir --}}
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">29 April 2025</td>
                    <td class="px-6 py-4">Ahmad Fauzan</td>
                    <td class="px-6 py-4">10 IPA 1</td>
                    <td class="px-6 py-4">
                        <img src="/storage/absensi/ahmad_fauzan_29.jpg" alt="Foto Absen" class="w-14 h-14 rounded-md object-cover border">
                    </td>
                    <td class="px-6 py-4">08:55</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-green-700 bg-green-100 font-medium">
                            <i class="fas fa-check-circle"></i> Hadir
                        </span>
                    </td>
                </tr>

                {{-- Terlambat --}}
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">28 April 2025</td>
                    <td class="px-6 py-4">Siti Nurhaliza</td>
                    <td class="px-6 py-4">10 IPA 1</td>
                    <td class="px-6 py-4">
                        <img src="/storage/absensi/siti_nurhaliza_28.jpg" alt="Foto Absen" class="w-14 h-14 rounded-md object-cover border">
                    </td>
                    <td class="px-6 py-4">09:12</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-yellow-700 bg-yellow-100 font-medium">
                            <i class="fas fa-clock"></i> Terlambat
                        </span>
                    </td>
                </tr>

                {{-- Alpha + opsi ubah --}}
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">27 April 2025</td>
                    <td class="px-6 py-4">Budi Santoso</td>
                    <td class="px-6 py-4">10 IPA 2</td>
                    <td class="px-6 py-4">
                        <div class="w-14 h-14 bg-gray-100 rounded-md flex items-center justify-center text-gray-400 border">—</div>
                    </td>
                    <td class="px-6 py-4">-</td>
                    <td class="px-6 py-4 space-y-2">
                        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-red-700 bg-red-100 font-medium">
                            <i class="fas fa-times-circle"></i> Alpha
                        </span>
                        <br>
                        <button onclick="openModal('Budi Santoso', '27 April 2025')" 
                                class="text-blue-600 text-sm hover:underline">
                            Ubah ke Izin
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

{{-- Modal --}}
<div id="izinModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg w-full max-w-md p-6">
        <h2 class="text-xl font-semibold mb-4">Ubah Alpha ke Izin</h2>
        <p id="modalInfo" class="text-sm text-gray-600 mb-4"></p>
        <form>
            <label class="block mb-2 text-sm font-medium text-gray-700">Alasan Izin</label>
            <textarea rows="4" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Tulis alasan siswa..."></textarea>
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" onclick="closeModal()" class="px-4 py-2 text-gray-600 hover:text-gray-800">Batal</button>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- Script --}}
<script>
    function openModal(nama, tanggal) {
        document.getElementById('modalInfo').innerText = `Siswa: ${nama} | Tanggal: ${tanggal}`;
        document.getElementById('izinModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('izinModal').classList.add('hidden');
    }
</script>
@endsection
