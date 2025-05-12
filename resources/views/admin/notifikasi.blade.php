@extends('layouts.admin')

@section('title', 'Notifikasi')

@section('content')
<main class="flex-1 p-6 sm:p-10 bg-gray-50 min-h-screen">
  <h2 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-10">Notifikasi Pengiriman WA Gagal</h2>

  <!-- SECTION: Tabel Gagal Kirim -->
  <div class="bg-white shadow rounded-2xl p-6 mb-12">
    <div class="flex items-center justify-between mb-4">
      <h3 class="text-xl font-semibold text-gray-700">Riwayat Gagal Kirim Pesan</h3>
      <span class="text-sm text-gray-500">Total: 2 pesan gagal</span>
    </div>
    <div class="overflow-x-auto">
      <table class="min-w-full text-sm text-left">
        <thead class="bg-gray-100 text-gray-600 uppercase text-xs tracking-wider">
          <tr>
            <th class="px-4 py-3">Siswa</th>
            <th class="px-4 py-3">No. HP Orang Tua</th>
            <th class="px-4 py-3">Pesan</th>
            <th class="px-4 py-3">Waktu</th>
            <th class="px-4 py-3">Aksi</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <!-- Data Dummy -->
          <tr>
            <td class="px-4 py-3 font-medium text-gray-900">Ahmad Fauzi</td>
            <td class="px-4 py-3 text-blue-700">+62 812-3456-7890</td>
            <td class="px-4 py-3">Anak Anda tidak hadir hari ini.</td>
            <td class="px-4 py-3">05 Mei 2025 08:45</td>
            <td class="px-4 py-3">
              <button onclick="isiForm('6281234567890', 'Anak Anda tidak hadir hari ini.')" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-lg shadow">
                <i class="fa-solid fa-paper-plane mr-1"></i> Kirim Ulang
              </button>
            </td>
          </tr>
          <tr>
            <td class="px-4 py-3 font-medium text-gray-900">Siti Nurhaliza</td>
            <td class="px-4 py-3 text-blue-700">+62 898-7654-3210</td>
            <td class="px-4 py-3">Anak Anda terlambat masuk.</td>
            <td class="px-4 py-3">05 Mei 2025 07:55</td>
            <td class="px-4 py-3">
              <button onclick="isiForm('6289876543210', 'Anak Anda terlambat masuk.')" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-lg shadow">
                <i class="fa-solid fa-paper-plane mr-1"></i> Kirim Ulang
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <!-- SECTION: Kirim Manual -->
  <div class="bg-white shadow rounded-2xl p-6">
    <h3 class="text-xl font-semibold text-gray-700 mb-4">Kirim Pesan Manual</h3>
    <form onsubmit="event.preventDefault(); alert('Pesan berhasil dikirim (simulasi).');" class="space-y-4">
      <div>
        <label class="block text-sm font-medium text-gray-600 mb-1">Nomor HP Orang Tua</label>
        <input id="inputHp" type="text" placeholder="Contoh: 6281234567890" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-600 mb-1">Isi Pesan</label>
        <textarea id="inputPesan" rows="4" placeholder="Masukkan isi pesan..." class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"></textarea>
      </div>
      <div>
        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded-lg shadow transition">
          <i class="fa-solid fa-paper-plane mr-2"></i> Kirim Pesan
        </button>
      </div>
    </form>
  </div>
</main>

<script>
  function isiForm(hp, pesan) {
    document.getElementById('inputHp').value = hp;
    document.getElementById('inputPesan').value = pesan;
    window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' });
  }
</script>
@endsection
