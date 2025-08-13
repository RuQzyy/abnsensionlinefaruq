@extends('layouts.siswa')

@section('title', 'dashboard siswa')

@push('styles')
<style>
  /* Animasi scroll */
  .scroll-animate {
    opacity: 0;
    transform: scale(0.95);
    transition: opacity 0.7s cubic-bezier(0.4, 0, 0.2, 1), transform 0.7s cubic-bezier(0.4, 0, 0.2, 1);
  }
  .scroll-animate.visible {
    opacity: 1;
    transform: scale(1);
  }
</style>
@endpush

@section('content')

 <!-- Absensi Hari Ini -->
<!-- Absensi Hari Ini -->
<section
  class="relative bg-white shadow-sm rounded-xl overflow-hidden p-6 mb-8 scroll-animate min-h-[360px] md:min-h-[400px]"
  style="background-image: url('{{ asset('img/asli.png') }}'); background-size: cover; background-position: center;">

  <!-- Konten Teks -->
  <div class="relative z-10 max-w-xl pt-40 pl-4 text-gray-900">
    <h2 class="text-xl md:text-2xl font-bold mb-1">Absensi Hari Ini</h2>
    <p class="text-green-800 font-semibold">MAN Ambon</p>
    <p class="text-sm font-medium">Absensi</p>
    <p class="text-sm mt-1 max-w-md">
      Absensi tersedia pada pukul {{ $pengaturan->absen_datang }} - {{ $pengaturan->absen_pulang }}.
      Pastikan Anda melakukan absen sebelum waktu absensi berakhir.
    </p>
    <p class="text-sm mt-4 font-semibold">
      Jam sekarang: <span id="clock" class="font-mono"></span>
    </p>
  </div>
</section>



  <!-- Riwayat Kehadiran -->
  <section class="bg-white shadow-sm rounded-xl p-6 mb-8 scroll-animate">
    <h2 class="text-lg font-semibold mb-4">Catatan Kehadiran Siswa</h2>
    <ul class="space-y-4">
      @foreach($riwayatKehadiran as $index => $item)
        <li class="flex items-center gap-4 bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition scroll-animate" style="transition-delay: {{ $index * 100 }}ms;">
          <div class="bg-blue-100 text-blue-700 w-10 h-10 flex items-center justify-center rounded-md">
            <i class="fas fa-calendar-alt"></i>
          </div>
          <div>
            <p class="text-sm font-semibold">
              {{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->translatedFormat('l, d F Y') }}
            </p>
            <p class="text-xs text-gray-500">
              Jam: {{ \Carbon\Carbon::parse($item->waktu_datang)->format('H:i') }}
            </p>
            <p class="text-xs text-blue-600 hover:underline cursor-pointer">{{ $item->nama_kelas }} - {{ $item->name }}</p>
          </div>
        </li>
      @endforeach
    </ul>
  </section>

  <!-- Pengumuman -->
  <section class="bg-white shadow-sm rounded-xl p-6 scroll-animate">
    <h2 class="text-lg font-semibold mb-4">Pengumuman</h2>
    <ul class="space-y-4">
      @foreach($pengumuman as $index => $item)
        <li class="flex items-start gap-4 scroll-animate" style="transition-delay: {{ $index * 100 }}ms;">
          <div class="bg-yellow-100 text-yellow-600 w-10 h-10 flex items-center justify-center rounded-full">
            <i class="fas fa-bullhorn"></i>
          </div>
          <div>
            <p class="text-sm font-semibold text-gray-800">{{ $item->judul }}</p>
            <p class="text-xs text-gray-500 mt-1">{{ $item->isi }}</p>
          </div>
        </li>
      @endforeach
    </ul>
  </section>
@endsection

@push('scripts')
<script>
  // Jam Realtime
  function updateClock() {
    const now = new Date();
    const jam = now.getHours().toString().padStart(2, '0');
    const menit = now.getMinutes().toString().padStart(2, '0');
    const detik = now.getSeconds().toString().padStart(2, '0');
    document.getElementById('clock').textContent = `${jam}:${menit}:${detik}`;
  }
  setInterval(updateClock, 1000);
  updateClock();

  // Animasi Scroll dengan IntersectionObserver
  document.addEventListener('DOMContentLoaded', () => {
    const observer = new IntersectionObserver((entries, obs) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          obs.unobserve(entry.target);
        }
      });
    }, {
      threshold: 0.15,
    });

    document.querySelectorAll('.scroll-animate').forEach(el => observer.observe(el));
  });
</script>
@endpush
