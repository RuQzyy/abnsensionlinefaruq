@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<main class="flex-1 p-6 sm:p-10 bg-gray-100 min-h-screen">
  <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-10">Dashboard Admin</h2>

  <!-- Statistik Cards -->
  <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
    @php
      $stats = [
        ['label' => 'Total Siswa', 'value' => $totalSiswa, 'icon' => 'fas fa-user-graduate', 'color' => 'blue'],
        ['label' => 'Total Guru', 'value' => $totalGuru, 'icon' => 'fas fa-chalkboard-teacher', 'color' => 'green'],
        ['label' => 'Hadir Hari Ini', 'value' => $totalHadir, 'icon' => 'fas fa-calendar-check', 'color' => 'yellow'],
        ['label' => 'Alpha Hari Ini', 'value' => $totalAlpha, 'icon' => 'fas fa-user-times', 'color' => 'red'],
      ];
    @endphp

    @foreach ($stats as $stat)
      <div class="bg-white rounded-xl shadow p-5 border-t-4 border-{{ $stat['color'] }}-500">
        <div class="flex items-center mb-4">
          <div class="p-3 rounded-full bg-{{ $stat['color'] }}-100 text-{{ $stat['color'] }}-600 mr-4">
            <i class="{{ $stat['icon'] }} text-xl"></i>
          </div>
          <p class="text-sm font-medium text-gray-600">{{ $stat['label'] }}</p>
        </div>
        <p class="text-3xl font-bold text-gray-900">{{ $stat['value'] }}</p>
      </div>
    @endforeach
  </section>

  <!-- Grafik Kehadiran -->
  <section class="bg-white rounded-xl shadow p-6 mb-12">
    <h3 class="text-2xl font-semibold text-gray-800 mb-6">Grafik Kehadiran Bulanan</h3>
    <canvas id="attendanceChart" class="w-full h-72"></canvas>
  </section>

  <!-- Pengumuman -->
  <section class="bg-white rounded-xl shadow p-6">
    <h3 class="text-2xl font-semibold text-gray-800 mb-6">Pengumuman Terbaru</h3>
    <div class="space-y-4">
      @forelse($pengumuman as $item)
        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
          <h4 class="text-lg font-semibold text-blue-700">{{ $item->judul }}</h4>
          <p class="text-gray-700 mt-1">{{ $item->isi }}</p>
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
          data: @json(array_values(array_map(fn($d) => $d['hadir'], $chartData))),
          backgroundColor: "#3b82f6",
          borderRadius: 6,
        },
        {
          label: "Terlambat",
          data: @json(array_values(array_map(fn($d) => $d['terlambat'], $chartData))),
          backgroundColor: "#facc15",
          borderRadius: 6,
        },
        {
          label: "Alpha",
          data: @json(array_values(array_map(fn($d) => $d['alpha'], $chartData))),
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
            stepSize: 10,
            color: "#6b7280",
          },
        },
      },
    },
  });
</script>
@endpush
