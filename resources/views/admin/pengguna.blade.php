@extends('layouts.admin')

@section('title', 'Pengguna')

@section('content')
<main class="flex-1 p-6 sm:p-10 bg-gradient-to-br from-gray-50 to-white min-h-screen">
  <h2 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-10">Manajemen Pengguna</h2>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

    <!-- Form Tambah Guru -->
    <section class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-shadow h-[600px] flex flex-col">
      <h3 class="text-xl font-semibold text-gray-900 mb-6 border-b pb-3">Tambah Akun Guru</h3>
      <form action="{{ route('admin.pengguna.storeGuru') }}" method="POST" class="flex flex-col justify-between flex-grow">
        @csrf
        <div class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Guru</label>
            <input type="text" name="name" required class="block w-full rounded-xl border-gray-300" placeholder="Masukkan nama guru">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" name="email" required class="block w-full rounded-xl border-gray-300" placeholder="Email guru">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input type="password" name="password" required class="block w-full rounded-xl border-gray-300" placeholder="Minimal 6 karakter">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">NIP</label>
            <input type="text" name="nip" required class="block w-full rounded-xl border-gray-300" placeholder="Masukkan NIP">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Wali Kelas</label>
            <select name="id_kelas" class="block w-full rounded-xl border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 transition">
              <option value="">-- Pilih Kelas --</option>
              @foreach($class as $item)
                <option value="{{ $item->id_kelas }}">{{ $item->nama_kelas }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-xl font-semibold mt-6">Tambah Guru</button>
      </form>
    </section>

    <!-- Form Tambah Siswa -->
    <section class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-shadow h-[600px] flex flex-col">
      <h3 class="text-xl font-semibold text-gray-900 mb-6 border-b pb-3">Tambah Akun Siswa</h3>
      <form action="{{ route('admin.pengguna.storeSiswa') }}" method="POST" class="flex flex-col justify-between flex-grow">
        @csrf
        <div class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Siswa</label>
            <input type="text" name="name" required class="block w-full rounded-xl border-gray-300" placeholder="Masukkan nama siswa">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" name="email" required class="block w-full rounded-xl border-gray-300" placeholder="Email siswa">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input type="password" name="password" required class="block w-full rounded-xl border-gray-300" placeholder="Minimal 6 karakter">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">NISN</label>
            <input type="text" name="nisn" required class="block w-full rounded-xl border-gray-300" placeholder="Masukkan NISN">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
            <select name="id_kelas" required class="block w-full rounded-xl border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 transition">
              <option value="">-- Pilih Kelas --</option>
              @foreach($class as $item)
                <option value="{{ $item->id_kelas }}">{{ $item->nama_kelas }}</option>
              @endforeach
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nomor HP</label>
            <input type="text" name="no_hp" required class="block w-full rounded-xl border-gray-300" placeholder="Contoh: 081234567890">
          </div>
        </div>
        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-xl font-semibold mt-6">Tambah Siswa</button>
      </form>
    </section>
  </div>

  <!-- Tabel Daftar Guru -->
  <div class="mt-14">
    <h3 class="text-3xl font-bold text-gray-800 mb-6 flex items-center gap-2">
      <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path d="M12 14l9-5-9-5-9 5 9 5z" />
        <path d="M12 14l6.16-3.422a12.083 12.083 0 01.587 6.744L12 21l-6.747-3.678a12.083 12.083 0 01.587-6.744L12 14z" />
      </svg>
      Daftar Guru
    </h3>
    <div class="overflow-x-auto bg-white rounded-2xl shadow-md border border-gray-200">
      <table class="w-full text-sm text-left text-gray-800">
        <thead class="bg-indigo-50 text-indigo-700 font-semibold uppercase text-xs">
          <tr>
            <th class="px-6 py-4">Nama</th>
            <th class="px-6 py-4">Email</th>
            <th class="px-6 py-4">NIP</th>
            <th class="px-6 py-4">Wali Kelas</th>
            <th class="px-6 py-4">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
          @foreach ($guruList as $guru)
          <tr class="hover:bg-indigo-50 transition">
            <td class="px-6 py-3">{{ $guru->name }}</td>
            <td class="px-6 py-3">{{ $guru->email }}</td>
            <td class="px-6 py-3">{{ $guru->nip }}</td>
            <td class="px-6 py-3">{{ $guru->nama_kelas }}</td>
             <td class="px-6 py-3">
                <button onclick='openEditGuruModal(@json($guru))'
                class="text-indigo-600 hover:text-indigo-900 font-semibold">
                Edit
            </button>
                </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  <!-- Tabel Daftar Siswa -->
  <div class="mt-16">
    <h3 class="text-3xl font-bold text-gray-800 mb-6 flex items-center gap-2">
      <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path d="M5.121 17.804A9.001 9.001 0 0112 3a9.001 9.001 0 016.879 14.804M12 7v6l4 2" />
      </svg>
      Daftar Siswa
    </h3>
    <div class="overflow-x-auto bg-white rounded-2xl shadow-md border border-gray-200">
      <table class="w-full text-sm text-left text-gray-800">
        <thead class="bg-green-50 text-green-700 font-semibold uppercase text-xs">
          <tr>
            <th class="px-6 py-4">Nama</th>
            <th class="px-6 py-4">Email</th>
            <th class="px-6 py-4">NISN</th>
            <th class="px-6 py-4">Kelas</th>
            <th class="px-6 py-4">No HP</th>
            <th class="px-6 py-4">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
          @foreach ($siswaList as $siswa)
          <tr class="hover:bg-green-50 transition">
            <td class="px-6 py-3">{{ $siswa->name }}</td>
            <td class="px-6 py-3">{{ $siswa->email }}</td>
            <td class="px-6 py-3">{{ $siswa->nisn }}</td>
            <td class="px-6 py-3">{{ $siswa->nama_kelas }}</td>
            <td class="px-6 py-3">{{ $siswa->no_hp }}</td>
             <td class="px-6 py-3">
            <button onclick='openEditSiswaModal(@json($siswa))'
                class="text-green-600 hover:text-green-900 font-semibold">
                Edit
            </button>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</main>
<!-- Modal Edit Guru -->
<div id="editGuruModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
  <div class="bg-white rounded-xl p-6 w-full max-w-lg">
    <h2 class="text-xl font-bold mb-4">Edit Data Guru</h2>
    <form id="editGuruForm" method="POST">
      @csrf
      @method('PUT')
      <input type="hidden" id="guruId" name="id">
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Nama</label>
        <input type="text" name="name" id="guruName" required class="w-full rounded-lg border-gray-300">
      </div>
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" name="email" id="guruEmail" required class="w-full rounded-lg border-gray-300">
      </div>
       <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Password</label>
        <input type="text" name="password" id="guruPassword" required class="w-full rounded-lg border-gray-300">
      </div>
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">NIP</label>
        <input type="text" name="nip" id="guruNip" required class="w-full rounded-lg border-gray-300">
      </div>
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Wali Kelas</label>
        <select name="id_kelas" id="guruKelas" class="w-full rounded-lg border-gray-300">
          <option value="">-- Pilih Kelas --</option>
          @foreach($class as $item)
            <option value="{{ $item->id_kelas }}">{{ $item->nama_kelas }}</option>
          @endforeach
        </select>
      </div>
      <div class="flex justify-end gap-3 mt-6">
        <button type="button" onclick="closeModal('editGuruModal')" class="px-4 py-2 bg-gray-300 rounded-lg">Batal</button>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Simpan</button>
      </div>
    </form>
  </div>
</div>


<!-- Modal Edit Siswa -->
<div id="editSiswaModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
  <div class="bg-white rounded-xl p-6 w-full max-w-lg">
    <h2 class="text-xl font-bold mb-4">Edit Data Siswa</h2>
    <form id="editSiswaForm" method="POST">
      @csrf
      @method('PUT')
      <input type="hidden" id="siswaId" name="id">
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Nama</label>
        <input type="text" name="name" id="siswaName" required class="w-full rounded-lg border-gray-300">
      </div>
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" name="email" id="siswaEmail" required class="w-full rounded-lg border-gray-300">
      </div>
       <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Password</label>
        <input type="text" name="password" id="siswaPassword" required class="w-full rounded-lg border-gray-300">
      </div>
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">NISN</label>
        <input type="text" name="nisn" id="siswaNisn" required class="w-full rounded-lg border-gray-300">
      </div>
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Kelas</label>
        <select name="id_kelas" id="siswaKelas" required class="w-full rounded-lg border-gray-300">
          <option value="">-- Pilih Kelas --</option>
          @foreach($class as $item)
            <option value="{{ $item->id_kelas }}">{{ $item->nama_kelas }}</option>
          @endforeach
        </select>
      </div>
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Nomor HP</label>
        <input type="text" name="no_hp" id="siswaNoHp" required class="w-full rounded-lg border-gray-300">
      </div>
      <div class="flex justify-end gap-3 mt-6">
        <button type="button" onclick="closeModal('editSiswaModal')" class="px-4 py-2 bg-gray-300 rounded-lg">Batal</button>
        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg">Simpan</button>
      </div>
    </form>
  </div>
</div>

<script>
 function openEditGuruModal(guru) {
  document.getElementById('guruId').value = guru.id;
  document.getElementById('guruName').value = guru.name;
  document.getElementById('guruEmail').value = guru.email;
  document.getElementById('guruPassword').value = guru.password;
  document.getElementById('guruNip').value = guru.nip;
  document.getElementById('guruKelas').value = guru.id_kelas;

  document.getElementById('editGuruForm').action = `/admin/pengguna/${guru.id}`;
  document.getElementById('editGuruModal').classList.remove('hidden');
}

function openEditSiswaModal(siswa) {
  document.getElementById('siswaId').value = siswa.id;
  document.getElementById('siswaName').value = siswa.name;
  document.getElementById('siswaEmail').value = siswa.email;
  document.getElementById('siswaPassword').value = siswa.password;
  document.getElementById('siswaNisn').value = siswa.nisn;
  document.getElementById('siswaKelas').value = siswa.id_kelas;
  document.getElementById('siswaNoHp').value = siswa.no_hp;

  document.getElementById('editSiswaForm').action = `/admin/pengguna/${siswa.id}`;
  document.getElementById('editSiswaModal').classList.remove('hidden');
}

function closeModal(modalId) {
  document.getElementById(modalId).classList.add('hidden');
}

</script>

@include('sweetalert::alert')
@endsection
