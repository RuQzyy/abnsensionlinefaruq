@extends('layouts.app')

@section('title', 'Riwayat Kehadiran')

@section('content')
<div class="max-w-5xl mx-auto bg-white rounded-xl shadow-lg p-6">
    <h1 class="text-2xl font-extrabold text-gray-800 mb-6">📅 Riwayat Kehadiran</h1>

    {{-- Filter Section --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
        <input type="text" placeholder="Cari tanggal atau lokasi..." class="w-full md:w-1/3 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
        
        <select class="w-full md:w-1/4 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Filter Status</option>
            <option value="hadir">Hadir</option>
            <option value="terlambat">Terlambat</option>
            <option value="alpha">Alpha</option>
        </select>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-blue-50">
                <tr>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600 uppercase">Tanggal</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600 uppercase">Waktu</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600 uppercase">Lokasi</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600 uppercase">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">29 April 2025</td>
                    <td class="px-6 py-4">08:55</td>
                    <td class="px-6 py-4">Kelas 10 IPA 1</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-green-700 bg-green-100 font-medium">
                            <i class="fas fa-check-circle"></i> Hadir
                        </span>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">28 April 2025</td>
                    <td class="px-6 py-4">09:12</td>
                    <td class="px-6 py-4">Kelas 10 IPA 1</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-yellow-700 bg-yellow-100 font-medium">
                            <i class="fas fa-clock"></i> Terlambat
                        </span>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">27 April 2025</td>
                    <td class="px-6 py-4">-</td>
                    <td class="px-6 py-4">-</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-red-700 bg-red-100 font-medium">
                            <i class="fas fa-times-circle"></i> Alpha
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
