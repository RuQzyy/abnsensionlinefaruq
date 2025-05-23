@extends('layouts.guru')

@section('title', 'Absensi Masuk Guru')

@section('content')
  <div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold text-center text-gray-800 mb-8">Absensi Masuk Guru</h1>

    <section class="bg-white shadow-lg rounded-xl p-8 mb-12 max-w-3xl mx-auto">
      <h2 class="text-2xl font-semibold mb-6 text-center text-gray-700">Ambil Foto untuk Absensi Masuk</h2>

      <!-- Kamera -->
      <div class="flex justify-center items-center mb-6">
        <video id="video" class="rounded-lg shadow-md" width="100%" height="auto" autoplay playsinline></video>
      </div>

      <!-- Tombol -->
      <div class="flex justify-center gap-6 mb-4">
        <button id="capture-btn" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg shadow-lg transition duration-300 ease-in-out transform hover:scale-105">
          Ambil Foto
        </button>
        <button id="submit-btn" class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-lg shadow-lg transition duration-300 ease-in-out transform hover:scale-105" disabled>
          Kirim Absensi
        </button>
      </div>

      <!-- Preview Foto -->
      <div class="flex justify-center mt-6">
        <canvas id="canvas" class="hidden rounded shadow-lg"></canvas>
      </div>

      <!-- Info Lokasi -->
      <p id="lokasi-info" class="text-sm text-gray-500 text-center mt-2"></p>

      <p class="text-sm text-gray-600 mt-6 text-center">
        Pastikan Anda berada di area sekolah saat melakukan absensi. Foto dan lokasi akan dikirim sebagai bukti kehadiran.
      </p>
    </section>
  </div>
@endsection

@push('styles')
  <style>
    .unmirror-video {
      transform: scaleX(-1);
    }

    button:disabled {
      background-color: #e0e0e0;
      cursor: not-allowed;
    }

    canvas {
      max-width: 100%;
      border-radius: 8px;
    }

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
    const lokasiInfo = document.getElementById('lokasi-info');

    let stream;
    let latestPosition = null;

    const SCHOOL_LATITUDE = {{ $pengaturan->lath_lokasi }};
    const SCHOOL_LONGITUDE = {{ $pengaturan->long_lokasi }};
    const ALLOWED_DISTANCE_METERS = {{ $pengaturan->radius_absen }};

    function getDistanceFromLatLonInMeters(lat1, lon1, lat2, lon2) {
      const R = 6371e3;
      const φ1 = lat1 * Math.PI/180;
      const φ2 = lat2 * Math.PI/180;
      const Δφ = (lat2-lat1) * Math.PI/180;
      const Δλ = (lon2-lon1) * Math.PI/180;

      const a = Math.sin(Δφ/2) * Math.sin(Δφ/2) +
                Math.cos(φ1) * Math.cos(φ2) *
                Math.sin(Δλ/2) * Math.sin(Δλ/2);
      const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
      return R * c;
    }

    function stopCamera() {
      if (stream) {
        stream.getTracks().forEach(track => track.stop());
      }
      video.srcObject = null;
    }

    function updateLokasiInfo(distance, lat, lon) {
      lokasiInfo.textContent = `Lokasi Anda: ${lat.toFixed(5)}, ${lon.toFixed(5)} (Jarak: ${distance.toFixed(2)} meter dari sekolah)`;
    }

    function checkLocation() {
      if (latestPosition) {
        const lat = latestPosition.coords.latitude;
        const lon = latestPosition.coords.longitude;
        const distance = getDistanceFromLatLonInMeters(lat, lon, SCHOOL_LATITUDE, SCHOOL_LONGITUDE);

        updateLokasiInfo(distance, lat, lon);

        if (distance <= ALLOWED_DISTANCE_METERS) {
          submitBtn.disabled = false;
        } else {
          submitBtn.disabled = true;
          alert('Anda tidak berada di lokasi yang diperbolehkan untuk absensi.');
          stopCamera();
        }
        return;
      }

      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition((position) => {
          latestPosition = position;
          checkLocation();
        }, (error) => {
          console.error('Gagal mengambil lokasi:', error);
          alert('Gagal mengambil lokasi. Pastikan izin lokasi aktif.');
          stopCamera();
        }, {
          enableHighAccuracy: true,
          timeout: 10000,
          maximumAge: 0
        });
      } else {
        alert('Browser tidak mendukung Geolocation.');
        stopCamera();
      }
    }

    async function startCamera() {
      try {
        stream = await navigator.mediaDevices.getUserMedia({
          video: { facingMode: 'user' }
        });
        video.srcObject = stream;
      } catch (err) {
        console.error('Gagal mengakses kamera:', err);
      }
    }

    function prefetchLocation() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
          (position) => {
            latestPosition = position;
          },
          (error) => {
            console.warn("Prefetch lokasi gagal:", error);
          },
          {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 0
          }
        );
      }
    }

    function checkPermission() {
      if (navigator.permissions) {
        navigator.permissions.query({ name: 'geolocation' }).then(result => {
          if (result.state === 'denied') {
            alert('Izin lokasi diblokir. Silakan aktifkan melalui pengaturan browser.');
          }
        });
      }
    }

    captureBtn.addEventListener('click', () => {
      const context = canvas.getContext('2d');
      canvas.width = video.videoWidth;
      canvas.height = video.videoHeight;

      context.save();
      context.translate(canvas.width, 0);
      context.scale(-1, 1);
      context.drawImage(video, 0, 0, canvas.width, canvas.height);
      context.restore();

      canvas.classList.remove('hidden');
      checkLocation();
    });

    submitBtn.addEventListener('click', async () => {
      const dataUrl = canvas.toDataURL('image/png');

      if (!latestPosition) {
        alert("Lokasi belum tersedia. Coba lagi beberapa saat.");
        return;
      }

      const lokasi = `${latestPosition.coords.latitude},${latestPosition.coords.longitude}`;

      try {
        const response = await fetch("{{ route('guru.absensi.store') }}", {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          body: JSON.stringify({ image: dataUrl, lokasi: lokasi })
        });

        const result = await response.json();
        if (result.success) {
          alert('Absensi berhasil dikirim!');
          window.location.reload();
        } else {
          alert('Gagal mengirim absensi!');
        }
      } catch (error) {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat mengirim absensi.');
      }
    });

    window.onload = () => {
      startCamera();
      prefetchLocation();
      checkPermission();
    };
  </script>
@endpush
