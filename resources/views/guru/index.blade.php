@extends('layouts.guru')

@section('title', 'dashboard guru')

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
  <h1 class="text-3xl font-extrabold mb-6 scroll-animate">
    Selamat datang, {{ auth()->user()->name }} 👋
  </h1>

  <!-- Absensi Hari Ini -->
  <section class="flex flex-col md:flex-row md:justify-between items-start md:items-center bg-white shadow-sm rounded-xl p-6 mb-8 gap-6 scroll-animate">
    <div>
      <h2 class="text-lg font-semibold mb-1">Absensi Hari Ini</h2>
      <p class="text-blue-600 hover:underline cursor-pointer font-medium">MAN Ambon</p>
      <p class="text-sm font-medium">Absensi</p>
      <p class="text-xs text-gray-500 mt-1 max-w-sm">
        Absensi tersedia pada pukul {{ $pengaturan->absen_datang }} - {{ $pengaturan->absen_pulang }}.
        Pastikan Anda melakukan absen sebelum waktu absensi berakhir.
      </p>
      <p class="text-sm text-gray-700 mt-4 font-semibold">
        Jam sekarang: <span id="clock" class="font-mono"></span>
      </p>
    </div>
    <img src="https://storage.googleapis.com/a1aa/image/a03f49eb-397c-401b-fdfb-88957b97e56e.jpg"
      alt="Classroom" class="w-full max-w-xs rounded-lg shadow-md object-cover" />
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
