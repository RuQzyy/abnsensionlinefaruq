@extends('layouts.app')

@section('title', 'Edit Profil Siswa')

@section('content')
  <div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl shadow-md">
    <!-- Header -->
    <div class="text-center mb-8">
      <img src="https://via.placeholder.com/120.png?text=Emma" alt="Foto Profil" class="w-28 h-28 mx-auto rounded-full object-cover shadow-md border-4 border-white -mt-20 mb-2">
      <h1 class="text-2xl font-bold text-gray-800">Edit Profil Siswa</h1>
      <p class="text-sm text-gray-500">Perbarui informasi pribadi dan Face ID Anda</p>
    </div>

    <!-- Form -->
    <form>
      <!-- Nama -->
      <div class="mb-5">
        <label for="nama" class="block mb-1 text-sm font-medium text-gray-700">Nama Lengkap</label>
        <input type="text" id="nama" name="nama" value="Emma Ananda" class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500 transition">
      </div>

      <!-- NISN -->
      <div class="mb-5">
        <label for="nisn" class="block mb-1 text-sm font-medium text-gray-700">NISN</label>
        <input type="text" id="nisn" name="nisn" value="1234567890" class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500 transition">
      </div>

      <!-- Foto Profil -->
      <div class="mb-6">
        <label for="foto" class="block mb-1 text-sm font-medium text-gray-700">Foto Profil</label>
        <input type="file" id="foto" name="foto" class="block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:bg-blue-100 file:text-blue-700 hover:file:bg-blue-200">
        <img src="https://via.placeholder.com/100x100.png?text=Profil" class="mt-3 w-20 h-20 rounded-full object-cover border shadow" alt="Preview Foto Profil">
      </div>

      <!-- Face ID -->
      <div class="mb-6">
        <label class="block mb-2 text-sm font-medium text-gray-700">Perbarui Face ID</label>
        <div class="flex flex-col items-center gap-4">
          <video id="video" width="320" height="240" autoplay class="rounded-lg border shadow-md"></video>
          <canvas id="canvas" width="320" height="240" class="hidden"></canvas>
          <input type="hidden" name="faceid_image" id="faceid_image">
          <button type="button" id="capture-btn" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg transition">Ambil Gambar Wajah</button>
          <div id="preview-container" class="mt-4 hidden text-center">
            <p class="text-sm text-gray-700 mb-1">Preview Face ID:</p>
            <img id="faceid-preview" src="" alt="Preview Face ID" class="w-40 h-auto border rounded-lg shadow">
          </div>
        </div>
      </div>

      <!-- Submit -->
      <div class="text-center">
        <button type="button" onclick="alert('Data berhasil disimpan! (simulasi)')" class="bg-green-600 hover:bg-green-700 text-white px-8 py-2 rounded-lg shadow transition">Simpan Perubahan</button>
      </div>
    </form>
  </div>
@endsection

@push('scripts')
<script>
  const video = document.getElementById('video');
  const canvas = document.getElementById('canvas');
  const captureBtn = document.getElementById('capture-btn');
  const faceidInput = document.getElementById('faceid_image');
  const previewContainer = document.getElementById('preview-container');
  const previewImage = document.getElementById('faceid-preview');

  async function startCamera() {
    try {
      const stream = await navigator.mediaDevices.getUserMedia({ video: true });
      video.srcObject = stream;
    } catch (err) {
      console.error('Gagal mengakses kamera:', err);
      alert('Tidak dapat mengakses kamera. Pastikan izin kamera sudah diberikan.');
    }
  }

  captureBtn.addEventListener('click', () => {
    const context = canvas.getContext('2d');
    context.drawImage(video, 0, 0, canvas.width, canvas.height);
    const imageData = canvas.toDataURL('image/png');
    faceidInput.value = imageData;
    previewImage.src = imageData;
    previewContainer.classList.remove('hidden');
  });

  window.onload = startCamera;
</script>
@endpush
