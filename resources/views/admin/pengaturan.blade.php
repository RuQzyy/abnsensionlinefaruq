@extends('layouts.admin')

@section('title', 'Pengaturan')

@section('content')
<main class="flex-1 p-6 sm:p-10 bg-gray-100 min-h-screen">
  <h2 class="text-3xl font-semibold text-gray-900 mb-8">Pengaturan Absensi</h2>

  <form method="POST" action="{{ route('admin.pengaturan.store') }}" class="space-y-8">
  @csrf
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
   <!-- Lokasi -->
<section class="bg-white border border-gray-200 rounded-xl p-6">
  <h3 class="text-lg font-medium text-gray-800 mb-4">Koordinat Lokasi Absensi</h3>
  <div class="space-y-4">
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Latitude</label>
      <input type="number" step="any" name="lath_lokasi"
        value="{{ old('lath_lokasi', $pengaturan->lath_lokasi ?? '') }}"
        placeholder="{{ $pengaturan->lath_lokasi }}"
        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Longitude</label>
      <input type="number" step="any" name="long_lokasi"
        value="{{ old('long_lokasi', $pengaturan->long_lokasi ?? '') }}"
        placeholder="{{ $pengaturan->long_lokasi  }}"
        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Radius Absensi (Meter)</label>
      <input type="number" step="any" name="radius_absen"
        value="{{ old('radius_absen', $pengaturan->radius_absen ?? '') }}"
        placeholder="{{ $pengaturan->radius_absen ?? 'Misal: 100' }}"
        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>
    <button type="button" onclick="getLocation()" class="text-sm text-blue-600 hover:underline">
      Ambil Lokasi Saya
    </button>
  </div>
</section>


    <!-- Waktu -->
    <section class="bg-white border border-gray-200 rounded-xl p-6">
      <h3 class="text-lg font-medium text-gray-800 mb-4">Waktu Absensi</h3>
      <div class="space-y-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Jam Masuk</label>
          <input type="time" name="absen_datang"
            value="{{ old('absen_datang', $pengaturan->absen_datang ?? '') }}"
            placeholder="{{ $pengaturan->absen_datang  }}"
            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Jam Keluar</label>
          <input type="time" name="absen_pulang"
            value="{{ old('absen_pulang', $pengaturan->absen_pulang ?? '') }}"
            placeholder="{{ $pengaturan->absen_pulang }}"
            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
      </div>
    </section>
  </div>

  <!-- Tombol Update -->
  <div class="text-center">
    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-5 py-2.5 rounded-md">
      Update Pengaturan Lokasi & Waktu
    </button>
  </div>
</form>


  <!-- Tambah Pengumuman -->
  <div class="mt-12 bg-white border border-gray-200 rounded-xl p-6">
    <h3 class="text-lg font-medium text-gray-800 mb-4">Tambah Pengumuman</h3>
    <form method="POST" action="{{ route('admin.pengumuman.store') }}" class="space-y-4">
      @csrf
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
        <input type="text" name="judul" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Isi</label>
        <textarea name="isi" rows="4" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
      </div>
      <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-5 py-2.5 rounded-md">
        Tambah Pengumuman
      </button>
    </form>
  </div>

  <!-- Daftar Pengumuman -->
  <div class="mt-12 bg-white border border-gray-200 rounded-xl p-6">
    <h3 class="text-lg font-medium text-gray-800 mb-6">Daftar Pengumuman</h3>

    @forelse ($pengumuman as $item)
    <div class="mb-6 p-4 border border-gray-200 rounded-md bg-gray-50">
      <form method="POST" action="{{ route('admin.pengumuman.update', $item->id_pengumuman) }}" class="space-y-3">
        @csrf
        @method('PUT')
        <input type="text" name="judul" value="{{ $item->judul }}"
          class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        <textarea name="isi" rows="3"
          class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $item->isi }}</textarea>
        <div class="flex items-center gap-3">
           <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-yellow-100 text-red-700 hover:bg-yellow-200 border border-yellow-300 rounded-lg text-sm font-medium transition">
                <i class="fas fa-trash-alt mr-2"></i> update
            </button>
      </form>
         <form method="POST" action="{{ route('admin.pengumuman.destroy', $item->id_pengumuman) }}"
            onsubmit="return confirm('Yakin ingin menghapus data ini?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 hover:bg-red-200 border border-red-300 rounded-lg text-sm font-medium transition">
                <i class="fas fa-trash-alt mr-2"></i> Hapus
            </button>
            </form>
        </div>
    </div>
    @empty
    <p class="text-gray-500 text-sm">Belum ada pengumuman.</p>
    @endforelse
  </div>
</main>

<script>
function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      document.querySelector('input[name="lath_lokasi"]').value = position.coords.latitude;
      document.querySelector('input[name="long_lokasi"]').value = position.coords.longitude;
    }, function(error) {
      alert("Gagal mengambil lokasi: " + error.message);
    });
  } else {
    alert("Geolocation tidak didukung oleh browser ini.");
  }
}
</script>
@endsection
