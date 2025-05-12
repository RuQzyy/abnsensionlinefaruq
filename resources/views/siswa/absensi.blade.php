@extends('layouts.siswa')

@section('title', 'Absen Siswa')

@section('content')
  <div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold text-center text-gray-800 mb-8">Absensi Siswa</h1>

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

  function checkLocation() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition((position) => {
        const userLat = position.coords.latitude;
        const userLon = position.coords.longitude;

        const distance = getDistanceFromLatLonInMeters(userLat, userLon, SCHOOL_LATITUDE, SCHOOL_LONGITUDE);
        console.log(`Jarak dari sekolah: ${distance.toFixed(2)} meter`);

        if (distance <= ALLOWED_DISTANCE_METERS) {
          // Lokasi valid
          submitBtn.disabled = false;
        } else {
          // Lokasi tidak valid
          submitBtn.disabled = true;
          alert('Anda tidak berada di lokasi yang diperbolehkan untuk absensi.');
          stopCamera(); // Langsung matikan kamera
        }
      }, (error) => {
        console.error('Gagal mengambil lokasi:', error);
        alert('Gagal mengambil lokasi. Pastikan izin lokasi sudah aktif.');
        stopCamera(); // Jika error ambil lokasi, matikan kamera juga
      });
    } else {
      alert('Browser tidak mendukung Geolocation.');
      stopCamera();
    }
  }

  async function startCamera() {
    try {
      stream = await navigator.mediaDevices.getUserMedia({
        video: {
          facingMode: 'user'
        }
      });
      video.srcObject = stream;
    } catch (err) {
      console.error('Gagal mengakses kamera:', err);
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

  // Ambil lokasi pengguna
  navigator.geolocation.getCurrentPosition(async (position) => {
    const lokasi = position.coords.latitude + ',' + position.coords.longitude;

    try {
      const response = await fetch("{{ route('siswa.absensi.store') }}", {
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
  }, (error) => {
    console.error('Gagal ambil lokasi:', error);
    alert('Gagal ambil lokasi.');
  });
});



  window.onload = startCamera;
</script>
@endpush
