@extends('layouts.admin')

@section('title', 'Manajemen Kelas')

@section('content')
<main class="flex-1 p-6 sm:p-10 bg-gray-100 min-h-screen">
  <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-10">Manajemen Kelas</h2>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
    <!-- Form Tambah Kelas -->
    <section class="bg-white rounded-xl shadow p-6 border-t-4 border-blue-500">
      <h3 class="text-2xl font-semibold text-gray-800 mb-6">Tambah Kelas Baru</h3>
      <form method="POST" action="{{ route('admin.kelas.store') }}">
        @csrf
        <div class="mb-5">
          <label class="block text-sm font-medium text-gray-600 mb-2">Nama Kelas</label>
          <input type="text" name="nama_kelas" class="w-full px-4 py-2 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="Contoh: IX A" required>
        </div>
        <button type="submit" class="w-full flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-xl shadow transition">
          <i class="fas fa-plus"></i> Tambah Kelas
        </button>
      </form>
    </section>

    <!-- Daftar Kelas -->
    <section class="bg-white rounded-xl shadow p-6 border-t-4 border-indigo-500">
      <h3 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center justify-between">
        Daftar Kelas
        <span class="ml-2 px-3 py-0.5 bg-indigo-100 text-indigo-700 rounded-full text-sm">{{ count($kelas) }} kelas</span>
      </h3>
      <ul class="space-y-3 max-h-64 overflow-y-auto pr-2 scrollbar-thin">
        @foreach($kelas as $item)
        <li class="flex justify-between items-center bg-gray-50 px-4 py-3 rounded-xl border hover:bg-gray-100 transition duration-150">
          <span class="font-medium text-gray-800">{{ $item->nama_kelas }}</span>
          <form method="POST" action="{{ route('admin.kelas.hapuskelas', $item->id_kelas) }}">
            @csrf
            @method('DELETE')
            <button onclick="return confirm('Yakin ingin menghapus kelas ini?')" class="flex items-center px-3 py-1.5 bg-red-100 text-red-600 hover:bg-red-200 border border-red-300 rounded-lg text-sm font-medium transition">
              <i class="fas fa-trash-alt mr-2"></i> Hapus
            </button>
          </form>
        </li>
        @endforeach
      </ul>
    </section>
  </div>

  <!-- Tabel Siswa -->
  <section>
    <h3 class="text-3xl font-semibold text-gray-800 mb-6">Daftar Siswa per Kelas</h3>

    <!-- Filter -->
    <div class="mb-5">
      <label for="filterKelas" class="block text-sm font-medium text-gray-700 mb-2">Pilih Kelas:</label>
      <select id="filterKelas" class="w-64 px-4 py-2 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500">
        <option value="all">Semua Kelas</option>
        @foreach($class as $item)
        <option value="{{ $item->id_kelas }}">{{ $item->nama_kelas }}</option>
        @endforeach
      </select>
    </div>

    <!-- Tabel -->
    <div class="overflow-x-auto bg-white rounded-xl shadow border border-gray-200">
      <table class="w-full text-sm text-left text-gray-700">
        <thead class="bg-gray-100 text-gray-600 uppercase text-sm tracking-wide">
          <tr>
            <th class="px-5 py-3">Nama Siswa</th>
            <th class="px-5 py-3">NISN</th>
            <th class="px-5 py-3">Kelas</th>
            <th class="px-5 py-3 text-center">Aksi</th>
          </tr>
        </thead>
        <tbody id="daftarSiswa">
          @foreach($siswaList as $siswa)
          <tr data-id="{{ $siswa->id }}" data-kelas="{{ $siswa->id_kelas }}" class="hover:bg-gray-50 transition">
            <td class="px-5 py-3">{{ $siswa->name }}</td>
            <td class="px-5 py-3">{{ $siswa->nisn }}</td>
            <td class="px-5 py-3 kelas">{{ $siswa->nama_kelas }}</td>
            <td class="px-5 py-3 text-center">
              <div class="flex justify-center gap-2">
                <button onclick="editKelas(this)" class="flex items-center px-3 py-1.5 bg-yellow-100 text-yellow-800 hover:bg-yellow-200 border border-yellow-300 rounded-lg text-sm font-medium transition">
                  <i class="fas fa-pen mr-2"></i> Ubah
                </button>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </section>

  <!-- Modal Edit Kelas -->
  <div id="modalKelas" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white rounded-xl p-6 w-full max-w-lg">
      <h2 class="text-xl font-bold mb-4">Edit Kelas Siswa</h2>
      <form id="formEditKelas" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" id="siswaId" name="id">
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700">Pilih Kelas Baru</label>
          <select name="id_kelas" id="kelasBaruInput" required class="w-full rounded-lg border-gray-300">
            <option value="">-- Pilih Kelas --</option>
            @foreach($class as $item)
            <option value="{{ $item->id_kelas }}">{{ $item->nama_kelas }}</option>
            @endforeach
          </select>
        </div>
        <div class="flex justify-end gap-3 mt-6">
          <button type="button" onclick="tutupModalKelas()" class="px-4 py-2 bg-gray-300 rounded-lg">Batal</button>
          <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</main>

<style>
  .scrollbar-thin::-webkit-scrollbar {
    width: 6px;
  }
  .scrollbar-thin::-webkit-scrollbar-thumb {
    background-color: rgba(107, 114, 128, 0.4);
    border-radius: 10px;
  }
  .scrollbar-thin::-webkit-scrollbar-track {
    background-color: transparent;
  }
</style>

<script>
  document.getElementById('filterKelas').addEventListener('change', function () {
    const selected = this.value;
    document.querySelectorAll('#daftarSiswa tr').forEach(row => {
      const kelas = row.getAttribute('data-kelas');
      row.style.display = (selected === 'all' || kelas === selected) ? '' : 'none';
    });
  });

  let barisDipilih = null;

  function editKelas(el) {
    barisDipilih = el.closest('tr');
    const siswaId = barisDipilih.getAttribute('data-id');
    const kelasLama = barisDipilih.getAttribute('data-kelas');

    document.getElementById('siswaId').value = siswaId;
    document.getElementById('kelasBaruInput').value = kelasLama;

    const form = document.getElementById('formEditKelas');
    form.action = `/admin/kelas/update/${siswaId}`;

    document.getElementById('modalKelas').classList.remove('hidden');
  }

  function tutupModalKelas() {
    document.getElementById('modalKelas').classList.add('hidden');
  }
</script>
@endsection
