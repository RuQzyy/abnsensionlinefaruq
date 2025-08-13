@extends('layouts.guru')

@section('title', 'Edit Profil Guru')

@section('content')
  <div class="max-w-3xl mx-auto bg-white p-10 rounded-2xl shadow-lg mt-8">
    <div class="text-center mb-10">
      <img src="{{ asset('storage/' . $guru->foto_profil) }}" alt="Foto Profil" class="w-28 h-28 mx-auto rounded-full object-cover shadow-md border-4 border-white -mt-20 mb-3">
      <h1 class="text-3xl font-bold text-gray-800">Edit Profil Guru</h1>
      <p class="text-sm text-gray-500">Perbarui informasi pribadi dan kata sandi Anda</p>
    </div>

    @if(session('success'))
      <div class="mb-4 text-green-600 font-semibold">
        {{ session('success') }}
      </div>
    @endif

    <form action="{{ route('guru.update', $guru->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
      @csrf
      @method('PUT')
      <div>
        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
      <input type="text" id="name" name="name" value="{{ old('name', $guru->name) }}" class="w-full px-4 py-2 border rounded-lg bg-gray-100 text-gray-700 cursor-not-allowed" readonly>
        @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
      </div>
      <div>
        <label for="nip" class="block text-sm font-medium text-gray-700 mb-1">NIP</label>
       <input type="text" id="nip" name="nip" value="{{ old('nip', $guru->nip) }}" class="w-full px-4 py-2 border rounded-lg bg-gray-100 text-gray-700 cursor-not-allowed" readonly>
        @error('nip') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
      </div>
      <div>
        <label for="foto" class="block text-sm font-medium text-gray-700 mb-1">Foto Profil</label>
        <input type="file" id="foto" name="foto" class="block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-100 file:text-blue-700 hover:file:bg-blue-200">
        @error('foto') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
      </div>
      <hr class="my-8">
      <h2 class="text-lg font-semibold text-gray-800">Ubah Password (Opsional)</h2>

      <div class="grid md:grid-cols-2 gap-4">
        <div>
          <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
          <input type="password" id="password" name="password" class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500 transition">
          @error('password') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>
        <div>
          <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
          <input type="password" id="password_confirmation" name="password_confirmation" class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500 transition">
        </div>
      </div>
      <div class="text-center mt-6">
        <button type="submit" class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg shadow hover:bg-blue-700 transition">
          Simpan Perubahan
        </button>
      </div>
    </form>
  </div>
@endsection
