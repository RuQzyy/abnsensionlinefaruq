@extends('layouts.app')

@section('title', 'Absen Siswa')

@section('content')
  <h1 class="text-3xl font-extrabold mb-6">Absensi Siswa</h1>

  <!-- Facial Recognition Check-in -->
  <section class="bg-white shadow-sm rounded-xl p-6 mb-12">
    <h2 class="text-lg font-semibold mb-4 text-center">Absen dengan Pengenalan Wajah</h2>
    
    <div class="flex justify-center items-center mb-6">
      <video id="video" width="100%" height="auto" autoplay></video>
    </div>

    <div class="flex justify-center">
      <button id="checkin-btn" class="bg-blue-600 text-white px-6 py-2 rounded-lg shadow-md">Check-in</button>
    </div>
    
    <p class="text-xs text-gray-500 mt-2 max-w-sm text-center">Pastikan wajah Anda terlihat jelas untuk proses absensi.</p>
  </section>

@endsection

@push('scripts')
  <script>
    // Access the video element and button
    const video = document.getElementById('video');
    const checkinButton = document.getElementById('checkin-btn');
    let stream;

    // Initialize the camera
    async function startCamera() {
      try {
        stream = await navigator.mediaDevices.getUserMedia({ video: true });
        video.srcObject = stream;
      } catch (err) {
        console.error('Error accessing the camera: ', err);
      }
    }

    // Check-in button click handler
    checkinButton.addEventListener('click', () => {
      // Implement facial recognition logic here
      alert('Absensi berhasil!'); // Replace with actual facial recognition logic
    });

    // Start the camera on page load
    window.onload = startCamera;
  </script>
@endpush
