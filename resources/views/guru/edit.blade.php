@extends('layouts.guru')

@section('title', 'Edit Profil Guru')

@section('content')
  <div class="max-w-3xl mx-auto bg-white p-10 rounded-2xl shadow-lg mt-8">
    <!-- Header -->
    <div class="text-center mb-10">
      <img src="{{ asset('img/profil.jpg') }}" alt="Foto Profil" class="w-28 h-28 mx-auto rounded-full object-cover shadow-md border-4 border-white -mt-20 mb-3">
      <h1 class="text-3xl font-bold text-gray-800">Edit Profile Guru</h1>
      <p class="text-sm text-gray-500">Perbarui informasi pribadi dan kata sandi Anda</p>
    </div>

    <!-- Form -->
    <form enctype="multipart/form-data" class="space-y-6">
      <!-- Nama -->
      <div>
        <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
        <input type="text" id="nama" name="nama" value="Muhammad Al-Faruq" class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500 transition">
      </div>

      <!-- NISN -->
      <div>
        <label for="nip" class="block text-sm font-medium text-gray-700 mb-1">NIP</label>
        <input type="text" id="nip" name="nip" value="1234567890" class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500 transition">
      </div>

      <!-- Foto Profil -->
      <div>
        <label for="foto" class="block text-sm font-medium text-gray-700 mb-1">Foto Profile</label>
        <input type="file" id="foto" name="foto" class="block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-100 file:text-blue-700 hover:file:bg-blue-200">
      </div>

      <!-- Section Password -->
      <hr class="my-8">
      <h2 class="text-lg font-semibold text-gray-800">Ubah Password</h2>

      <div class="grid md:grid-cols-2 gap-4">
        <div>
          <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
          <input type="password" id="password" name="password" class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500 transition">
        </div>
        <div>
          <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
          <input type="password" id="password_confirmation" name="password_confirmation" class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500 transition">
        </div>
      </div>

      <!-- Submit Button -->
      <div class="text-center mt-6">
        <button type="button" class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg shadow hover:bg-blue-700 transition">
          Simpan Perubahan
        </button>
      </div>
    </form>
  </div>
@endsection
