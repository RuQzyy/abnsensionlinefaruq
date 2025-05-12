@extends('layouts.admin')

@section('title', 'Manajemen Kelas')

@section('content')
<main class="flex-1 p-6 sm:p-10 bg-gradient-to-br from-gray-50 to-white min-h-screen">

  <!-- Judul Halaman -->
  <h2 class="text-4xl font-bold text-gray-800 mb-10">Manajemen Kelas</h2>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

    <!-- Form Tambah Kelas -->
    <section class="bg-white rounded-2xl shadow-xl p-6 border border-gray-200 transition hover:shadow-2xl hover:scale-[1.01] duration-150">
      <h3 class="text-2xl font-semibold text-gray-900 mb-6">Tambah Kelas Baru</h3>
      <form method="POST" action="{{ route('admin.kelas.store') }}">
        @csrf
        <div class="mb-5">
          <label class="block text-sm font-medium text-gray-600 mb-2">Nama Kelas</label>
          <input type="text" name="nama_kelas" class="w-full px-4 py-2 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="Contoh: IX A" required>
        </div>
        <button type="submit" class="w-full inline-flex justify-center items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-xl shadow-md transition-all duration-200">
          <i class="fas fa-plus"></i> Tambah Kelas
        </button>
      </form>
    </section>

    <!-- Daftar Kelas -->
    <section class="bg-white rounded-2xl shadow-xl p-6 border border-gray-200 transition hover:shadow-2xl hover:scale-[1.01] duration-150">
      <h3 class="text-2xl font-semibold text-gray-900 mb-6 flex items-center justify-between">
        Daftar Kelas
        <span class="ml-2 px-3 py-0.5 bg-blue-100 text-blue-700 rounded-full text-sm">{{ count($kelas) }} kelas</span>
      </h3>
      <ul class="space-y-3 max-h-64 overflow-y-auto pr-2 scrollbar-thin">
        @foreach($kelas as $item)
        <li class="flex justify-between items-center bg-gray-50 px-4 py-3 rounded-xl border hover:bg-gray-100 transition hover:scale-[1.01] duration-150">
          <span class="font-medium text-gray-800">{{ $item->nama_kelas }}</span>
          <form method="POST" action="{{ route('admin.kelas.hapuskelas', $item->id_kelas) }}">
            @csrf
            @method('DELETE')
            <button onclick="return confirm('Yakin ingin menghapus kelas ini?')" class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-600 hover:bg-red-200 border border-red-300 rounded-lg text-sm font-medium transition">
              <i class="fas fa-trash-alt mr-2"></i> Hapus
            </button>
          </form>
        </li>
        @endforeach
      </ul>
    </section>

  </div>

  <!-- Tabel Siswa per Kelas -->
  <div class="mt-14">
    <h3 class="text-3xl font-semibold text-gray-800 mb-6">Daftar Kelas</h3>

    <!-- Filter Kelas -->
    <div class="mb-5">
      <label for="filterKelas" class="block text-sm font-medium text-gray-700 mb-2">Pilih Kelas:</label>
      <select id="filterKelas" class="w-64 px-4 py-2 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500">
        <option value="all">Semua Kelas</option>
        @foreach($class as $item)
        <option value="{{ $item->id_kelas }}">{{ $item->nama_kelas }}</option>
        @endforeach
      </select>
    </div>

    <!-- Tabel Data Siswa -->
    <div class="overflow-x-auto bg-white rounded-xl shadow-xl border border-gray-200">
      <table class="w-full text-sm text-left text-gray-700 table-fixed">
        <thead class="bg-gray-100 text-gray-600 text-sm uppercase tracking-wide">
          <tr>
           <th class="px-5 py-3 min-w-[150px]">NAMA SISWA</th>
            <th class="px-5 py-3 min-w-[120px]">NISN</th>
            <th class="px-5 py-3 min-w-[120px]">KELAS</th>
            <th class="px-5 py-3 min-w-[150px] text-center">AKSI</th>
          </tr>
        </thead>
        <tbody id="daftarSiswa">
          @foreach($siswaList as $siswa)
          <tr data-kelas="{{ $siswa->id_kelas }}" class="hover:bg-gray-50 transition">
            <td class="px-5 py-3">{{ $siswa->name }}</td>
            <td class="px-5 py-3">{{ $siswa->nisn }}</td>
            <td class="px-5 py-3 kelas">{{ $siswa->nama_kelas }}</td>
            <td class="px-5 py-3 text-center">
                <div class="flex justify-center items-center space-x-2">
                    <button
                    onclick="editKelas(this)"
                    class="inline-flex items-center px-3 py-1.5 bg-yellow-100 text-yellow-800 hover:bg-yellow-200 border border-yellow-300 rounded-lg text-sm font-medium transition"
                    >
                    <i class="fas fa-pen mr-2"></i> Ubah
                    </button>

                    <form
                    method="POST"
                    action="{{ route('admin.kelas.destroy', $siswa->id) }}"
                    onsubmit="return confirm('Yakin ingin menghapus data ini?');"
                    >
                    @csrf
                    @method('DELETE')
                    <button
                        type="submit"
                        class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 hover:bg-red-200 border border-red-300 rounded-lg text-sm font-medium transition"
                    >
                        <i class="fas fa-trash-alt mr-2"></i> Hapus
                    </button>
                    </form>
                </div>
                </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  <!-- Modal Ubah Kelas -->
  <div id="modalKelas" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center hidden z-50">
    <div class="bg-white p-6 rounded-2xl shadow-2xl w-[90%] max-w-md animate-fade-in">
      <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
        <i class="fas fa-edit mr-2 text-blue-600"></i> Ubah Kelas Siswa
      </h3>
      <select id="kelasBaruInput" class="w-full mb-4 px-4 py-2 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500">
        <option value="">Pilih Kelas Baru</option>
        @foreach($class as $item)
        <option value="{{ $item->id_kelas }}">{{ $item->nama_kelas }}</option>
        @endforeach
      </select>
      <div class="flex justify-end space-x-3">
        <button onclick="tutupModalKelas()" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition">Batal</button>
        <button onclick="simpanKelasBaru()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">Simpan</button>
      </div>
    </div>
  </div>

</main>

<!-- Custom Scrollbar -->
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

<!-- Script -->
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
    const kelasLama = barisDipilih.getAttribute('data-kelas');
    document.getElementById('kelasBaruInput').value = kelasLama;
    document.getElementById('modalKelas').classList.remove('hidden');
  }

  function tutupModalKelas() {
    document.getElementById('modalKelas').classList.add('hidden');
  }

  function simpanKelasBaru() {
    const kelasBaru = document.getElementById('kelasBaruInput').value;
    if (kelasBaru && barisDipilih) {
      const cell = barisDipilih.querySelector('.kelas');
      cell.innerText = document.querySelector(`#kelasBaruInput option[value="${kelasBaru}"]`).textContent;
      barisDipilih.setAttribute('data-kelas', kelasBaru);
    }
    tutupModalKelas();
  }
</script>
@endsection
