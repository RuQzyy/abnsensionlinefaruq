@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Log Aktivitas</h2>

    {{-- Filter Tanggal --}}
    <form method="GET" class="mb-4 flex items-center gap-2">
        <label for="tanggal" class="text-sm font-medium text-gray-700">Filter tanggal:</label>
        <input type="date" id="tanggal" name="tanggal" value="{{ $tanggal }}"
               class="border border-gray-300 rounded px-3 py-2 text-sm focus:ring focus:ring-blue-200 focus:border-blue-500">
        <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700 transition">
            Tampilkan
        </button>
    </form>

    {{-- Tabel Log --}}
    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-100 text-left font-semibold text-gray-600">
                <tr>
                    <th class="px-4 py-2">Waktu</th>
                    <th class="px-4 py-2">User</th>
                    <th class="px-4 py-2">Aksi</th>
                    <th class="px-4 py-2">Deskripsi</th>
                    <th class="px-4 py-2">Model</th>
                    <th class="px-4 py-2">Model ID</th>
                    <th class="px-4 py-2">IP</th>
                    <th class="px-4 py-2">Agent</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($logs as $log)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 font-medium text-gray-800">
                        {{ \Carbon\Carbon::parse($log->created_at)->format('Y-m-d H:i:s') }}
                    </td>
                    <td class="px-4 py-2">{{ $log->user->name ?? 'Tidak Diketahui' }}</td>
                    <td class="px-4 py-2">
                        <span class="inline-block px-2 py-1 rounded bg-blue-100 text-blue-800 text-xs font-semibold">
                            {{ $log->aksi }}
                        </span>
                    </td>
                    <td class="px-4 py-2">{{ $log->deskripsi }}</td>
                    <td class="px-4 py-2">{{ $log->model }}</td>
                    <td class="px-4 py-2">{{ $log->model_id }}</td>
                    <td class="px-4 py-2">{{ $log->ip_address }}</td>
                    <td class="px-4 py-2 whitespace-pre-wrap break-words max-w-3xl">
                        {{ $log->user_agent }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-gray-500 px-4 py-4">Tidak ada log aktivitas pada tanggal ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $logs->appends(['tanggal' => $tanggal])->links() }}
    </div>
</div>
@endsection
