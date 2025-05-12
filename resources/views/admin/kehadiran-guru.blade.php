@extends('layouts.admin')

@section('title', 'Kehadiran Guru')

@section('content')
<div class="max-w-6xl mx-auto bg-white rounded-xl shadow-lg p-6">
    <h1 class="text-2xl font-extrabold text-gray-800 mb-6">📋 Kehadiran Guru</h1>

    {{-- Filter Section --}}
    <form class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
        <input type="text" placeholder="Cari nama atau tanggal..." 
               class="w-full md:w-1/3 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
        
        <select class="w-full md:w-1/4 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Filter Status</option>
            <option value="hadir">Hadir</option>
            <option value="terlambat">Terlambat</option>
            <option value="alpha">Alpha</option>
            <option value="cuti">Cuti</option>
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
                    <th class="px-6 py-3 text-left font-semibold text-gray-600 uppercase">Nama Guru</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600 uppercase">Waktu</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600 uppercase">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                {{-- Hadir --}}
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">29 April 2025</td>
                    <td class="px-6 py-4">Ibu Sari</td>
                    <td class="px-6 py-4">07:58</td>
                    <td class="px-6 py-4 space-y-2">
                        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-green-700 bg-green-100 font-medium">
                            <i class="fas fa-check-circle"></i> Hadir
                        </span>
                        <br>
                        <button onclick="openEditModal('Ibu Sari', '29 April 2025', 'Hadir')" 
                            class="text-blue-600 text-sm hover:underline">Ubah Status</button>
                    </td>
                </tr>

                {{-- Alpha --}}
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">29 April 2025</td>
                    <td class="px-6 py-4">Pak Andi</td>
                    <td class="px-6 py-4">-</td>
                    <td class="px-6 py-4 space-y-2">
                        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-red-700 bg-red-100 font-medium">
                            <i class="fas fa-times-circle"></i> Alpha
                        </span>
                        <br>
                        <button onclick="openEditModal('Pak Andi', '29 April 2025', 'Alpha')" 
                            class="text-blue-600 text-sm hover:underline">Ubah Status</button>
                    </td>
                </tr>

                {{-- Cuti --}}
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">29 April 2025</td>
                    <td class="px-6 py-4">Bu Lina</td>
                    <td class="px-6 py-4">-</td>
                    <td class="px-6 py-4 space-y-2">
                        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-purple-700 bg-purple-100 font-medium">
                            <i class="fas fa-umbrella-beach"></i> Cuti
                        </span>
                        <br>
                        <button onclick="openEditModal('Bu Lina', '29 April 2025', 'Cuti')" 
                            class="text-blue-600 text-sm hover:underline">Ubah Status</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

{{-- Modal --}}
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg w-full max-w-md p-6">
        <h2 class="text-xl font-semibold mb-4">Ubah Status Kehadiran Guru</h2>
        <p id="modalInfo" class="text-sm text-gray-600 mb-4"></p>
        <form>
            <label class="block mb-2 text-sm font-medium text-gray-700">Pilih Status Baru</label>
            <select class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-4 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="Hadir">Hadir</option>
                <option value="Terlambat">Terlambat</option>
                <option value="Alpha">Alpha</option>
                <option value="Cuti">Cuti</option>
            </select>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 text-gray-600 hover:text-gray-800">Batal</button>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- Script --}}
<script>
    function openEditModal(nama, tanggal, status) {
        document.getElementById('modalInfo').innerText = `Guru: ${nama} | Tanggal: ${tanggal} | Status saat ini: ${status}`;
        document.getElementById('editModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }
</script>
@endsection
