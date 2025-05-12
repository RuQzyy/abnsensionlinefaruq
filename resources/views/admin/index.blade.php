@extends('layouts.admin')

@section('title', 'dashboard')

@section('content')
<main class="flex-1 p-6 sm:p-10 bg-gray-50 min-h-screen">
  <h2 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-10">Dashboard Admin</h2>

  <!-- Statistik Cards -->
<section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
  <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl shadow-lg hover:shadow-xl p-6 transition-all duration-300">
    <div class="flex items-center gap-4 mb-4">
      <div class="p-4 rounded-full bg-blue-600 text-white shadow-lg">
        <i class="fas fa-user-graduate text-xl"></i>
      </div>
      <p class="text-sm text-blue-800 font-semibold uppercase tracking-wide">Total Siswa </p>
    </div>
    <p class="text-4xl font-bold text-blue-700">{{ $totalSiswa }}</p>
  </div>

  <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-2xl shadow-lg hover:shadow-xl p-6 transition-all duration-300">
    <div class="flex items-center gap-4 mb-4">
      <div class="p-4 rounded-full bg-green-600 text-white shadow-lg">
        <i class="fas fa-chalkboard-teacher text-xl"></i>
      </div>
      <p class="text-sm text-green-800 font-semibold uppercase tracking-wide">Total Guru</p>
    </div>
    <p class="text-4xl font-bold text-green-700">{{ $totalGuru }}</p>
  </div>

  <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-2xl shadow-lg hover:shadow-xl p-6 transition-all duration-300">
    <div class="flex items-center gap-4 mb-4">
      <div class="p-4 rounded-full bg-yellow-500 text-white shadow-lg">
        <i class="fas fa-calendar-check text-xl"></i>
      </div>
      <p class="text-sm text-yellow-800 font-semibold uppercase tracking-wide">Hadir Hari Ini</p>
    </div>
    <p class="text-4xl font-bold text-yellow-700">478</p>
  </div>

  <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-2xl shadow-lg hover:shadow-xl p-6 transition-all duration-300">
    <div class="flex items-center gap-4 mb-4">
      <div class="p-4 rounded-full bg-red-600 text-white shadow-lg">
        <i class="fas fa-user-times text-xl"></i>
      </div>
      <p class="text-sm text-red-800 font-semibold uppercase tracking-wide">Alpha Hari Ini</p>
    </div>
    <p class="text-4xl font-bold text-red-700">17</p>
  </div>
</section>


  <!-- Grafik Kehadiran -->
  <section class="bg-white rounded-2xl shadow-md p-6 mb-12">
    <h3 class="text-2xl font-semibold text-gray-800 mb-6">Grafik Kehadiran Bulanan</h3>
    <canvas id="attendanceChart" class="w-full h-72"></canvas>
  </section>

  <!-- Pengumuman -->
  <section class="bg-white rounded-2xl shadow-md p-6">
    <h3 class="text-2xl font-semibold text-gray-800 mb-6">Pengumuman Terbaru</h3>
    <div class="space-y-4">
    @forelse($pengumuman as $item)
      <div class="bg-gray-50 p-4 rounded-xl border border-gray-200 shadow-sm hover:shadow transition duration-200">
        <div class="flex items-start justify-between">
          <div>
            <h4 class="text-lg font-semibold text-blue-600">{{ $item->judul }}</h4>
            <p class="text-gray-700 mt-1">{{ $item->isi }}</p>
          </div>
        </div>
      </div>
    @empty
      <p class="text-gray-500">Belum ada pengumuman.</p>
    @endforelse
  </div>
  </section>
</main>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx = document.getElementById("attendanceChart").getContext("2d");
  const attendanceChart = new Chart(ctx, {
    type: "bar",
    data: {
      labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
      datasets: [
        {
          label: "Hadir",
          data: [450, 470, 480, 460, 490, 500, 510, 520, 530, 540, 550, 560],
          backgroundColor: "#3b82f6",
          borderRadius: 6,
        },
        {
          label: "Terlambat",
          data: [20, 18, 15, 22, 17, 14, 12, 10, 9, 8, 7, 6],
          backgroundColor: "#facc15",
          borderRadius: 6,
        },
        {
          label: "Alpha",
          data: [10, 12, 14, 8, 6, 5, 4, 3, 2, 1, 1, 0],
          backgroundColor: "#ef4444",
          borderRadius: 6,
        },
      ],
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: "top",
          labels: {
            font: { size: 14, weight: "bold" },
          },
        },
      },
      scales: {
        x: {
          grid: { display: false },
          ticks: { color: "#6b7280" },
        },
        y: {
          beginAtZero: true,
          grid: {
            color: "#e5e7eb",
            borderDash: [5, 5],
          },
          ticks: {
            stepSize: 50,
            color: "#6b7280",
          },
        },
      },
    },
  });
</script>
@endpush
