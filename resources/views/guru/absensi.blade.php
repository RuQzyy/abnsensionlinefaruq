@extends('layouts.guru')

@section('title', 'Absen Siswa')

@section('content')
  <div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold text-center text-gray-800 mb-8">Absensi Guru</h1>

    <!-- Absensi dengan Kamera -->
    <section class="bg-white shadow-lg rounded-xl p-8 mb-12 max-w-3xl mx-auto">
      <h2 class="text-2xl font-semibold mb-6 text-center text-gray-700">Ambil Foto untuk Absensi</h2>

      <div class="flex justify-center items-center mb-6">
        <video id="video" class="rounded-lg shadow-md" width="100%" height="auto" autoplay playsinline></video>
      </div>

      <div class="flex justify-center gap-6 mb-4">
        <button id="capture-btn" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg shadow-lg transition duration-300 ease-in-out transform hover:scale-105">
          Ambil Foto
        </button>
        <button id="submit-btn" class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-lg shadow-lg transition duration-300 ease-in-out transform hover:scale-105" disabled>
          Kirim Absensi
        </button>
      </div>

      <div class="flex justify-center mt-6">
        <canvas id="canvas" class="hidden rounded shadow-lg"></canvas>
      </div>

      <p class="text-sm text-gray-600 mt-6 text-center">
        Pastikan Anda berada di area sekolah saat melakukan absensi. Foto dan lokasi akan dikirim sebagai bukti kehadiran.
      </p>
    </section>
  </div>
@endsection

@push('styles')
  <style>
    /* Styling video dan canvas */
    .unmirror-video {
      transform: scaleX(-1);
    }

    /* Styling untuk tombol */
    button:disabled {
      background-color: #e0e0e0;
      cursor: not-allowed;
    }

    /* Canvas styling */
    canvas {
      max-width: 100%;
      border-radius: 8px;
    }

    /* Responsive styling */
    @media (max-width: 768px) {
      h1 {
        font-size: 3xl;
      }

      .max-w-3xl {
        max-width: 100%;
      }

      .gap-6 {
        gap: 4px;
      }
    }
  </style>
@endpush

@push('scripts')
  <script>
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const captureBtn = document.getElementById('capture-btn');
    const submitBtn = document.getElementById('submit-btn');
    let stream;

    // Mulai kamera
    async function startCamera() {
      try {
        stream = await navigator.mediaDevices.getUserMedia({
          video: {
            facingMode: 'user' // kamera depan
          }
        });
        video.srcObject = stream;
      } catch (err) {
        console.error('Gagal mengakses kamera:', err);
      }
    }

    // Tangkap gambar dan balik lagi agar sesuai tampilan
    captureBtn.addEventListener('click', () => {
      const context = canvas.getContext('2d');
      canvas.width = video.videoWidth;
      canvas.height = video.videoHeight;

      // Balik horizontal (mirror fix)
      context.save();
      context.translate(canvas.width, 0);
      context.scale(-1, 1);
      context.drawImage(video, 0, 0, canvas.width, canvas.height);
      context.restore();

      canvas.classList.remove('hidden');
      submitBtn.disabled = false;
    });

    submitBtn.addEventListener('click', () => {
      alert('Absensi berhasil dikirim (simulasi)');
    });

    window.onload = startCamera;
  </script>
@endpush
