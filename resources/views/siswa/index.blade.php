@extends('layouts.app')

@section('title', 'dashboard siswa')

@section('content')
  <h1 class="text-3xl font-extrabold mb-6">Good morning, Emma 👋</h1>

  <!-- Today's Check-in -->
  <section class="flex flex-col md:flex-row md:justify-between items-start md:items-center bg-white shadow-sm rounded-xl p-6 mb-12 gap-6">
    <div>
      <h2 class="text-lg font-semibold mb-1">Today's Check-in</h2>
      <p class="text-blue-600 hover:underline cursor-pointer font-medium">Classroom 101</p>
      <p class="text-sm font-medium">Check-in</p>
      <p class="text-xs text-gray-500 mt-1 max-w-sm">Check-in available at 9:00 AM. You may check in 15 minutes before or after class starts.</p>
    </div>
    <img src="https://storage.googleapis.com/a1aa/image/a03f49eb-397c-401b-fdfb-88957b97e56e.jpg" alt="Classroom" class="w-full max-w-xs rounded-lg shadow-md object-cover" />
  </section>

  <!-- Attendance History -->
  <section>
    <!-- Attendance History -->
    <section>
        <h2 class="text-lg font-semibold mb-6">Your Attendance History</h2>
        <ul class="space-y-4">
          <!-- Repeatable Item -->
          <li class="flex items-center gap-4 bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition">
            <div class="bg-blue-100 text-blue-700 w-10 h-10 flex items-center justify-center rounded-md">
              <i class="fas fa-calendar-alt"></i>
            </div>
            <div>
              <p class="text-sm font-semibold">Tuesday, Dec 7, 2021</p>
              <p class="text-xs text-blue-600 hover:underline cursor-pointer">Classroom 101</p>
            </div>
          </li>
          <li class="flex items-center gap-4 bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition">
            <div class="bg-blue-100 text-blue-700 w-10 h-10 flex items-center justify-center rounded-md">
              <i class="fas fa-calendar-alt"></i>
            </div>
            <div>
              <p class="text-sm font-semibold">Tuesday, Dec 7, 2021</p>
              <p class="text-xs text-blue-600 hover:underline cursor-pointer">Classroom 101</p>
            </div>
          </li>
          <li class="flex items-center gap-4 bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition">
            <div class="bg-blue-100 text-blue-700 w-10 h-10 flex items-center justify-center rounded-md">
              <i class="fas fa-calendar-alt"></i>
            </div>
            <div>
              <p class="text-sm font-semibold">Tuesday, Dec 7, 2021</p>
              <p class="text-xs text-blue-600 hover:underline cursor-pointer">Classroom 101</p>
            </div>
          </li>
          <li class="flex items-center gap-4 bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition">
            <div class="bg-blue-100 text-blue-700 w-10 h-10 flex items-center justify-center rounded-md">
              <i class="fas fa-calendar-alt"></i>
            </div>
            <div>
              <p class="text-sm font-semibold">Tuesday, Dec 7, 2021</p>
              <p class="text-xs text-blue-600 hover:underline cursor-pointer">Classroom 101</p>
            </div>
          </li>
          <!-- More items (copy & modify as needed) -->
        </ul>
      </section>
@endsection
