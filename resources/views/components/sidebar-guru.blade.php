<aside class="fixed top-0 left-0 w-64 h-screen overflow-y-auto bg-white border-r shadow-sm px-6 py-8 flex flex-col z-50">

  <!-- Logo Sekolah -->
  <div class="flex items-center justify-center mb-8">
  <img src="{{ asset('img/logo.jpg') }}" alt="Logo Sekolah" class="w-10 h-10">
  <h1 class="text-xl font-bold">MAN Ambon</h1>
  </div>

  <!-- Navigation -->
  <nav class="space-y-4" x-data="{ absensiOpen: false }">
    <a href="{{ route('guru.index') }}"
       class="flex items-center gap-3 px-4 py-2 font-semibold text-sm rounded-lg transition
       {{ request()->routeIs('guru.index') ? 'bg-blue-100 text-blue-800' : 'hover:bg-gray-100 text-gray-700' }}">
      <i class="fas fa-home text-base"></i> Home
    </a>

    <!-- Dropdown Absensi -->
    <button @click="absensiOpen = !absensiOpen"
            class="w-full flex items-center justify-between px-4 py-2 font-semibold text-sm rounded-lg transition
            hover:bg-gray-100 text-gray-700 focus:outline-none">
      <span class="flex items-center gap-3">
        <i class="fas fa-calendar-alt text-base"></i> Kehadiran
      </span>
      <i :class="absensiOpen ? 'fas fa-chevron-up' : 'fas fa-chevron-down'" class="text-xs"></i>
    </button>
    <div x-show="absensiOpen" x-cloak class="ml-8 space-y-2">
      <a href="{{ route('guru.kehadiran-guru') }}"
         class="block px-3 py-1 text-sm rounded hover:bg-gray-100
         {{ request()->routeIs('guru.kehadiran-guru') ? 'bg-blue-100 text-blue-800' : 'text-gray-700' }}">
        Kehadiran Guru
      </a>
      <a href="{{ route('guru.kehadiran-siswa') }}"
         class="block px-3 py-1 text-sm rounded hover:bg-gray-100
         {{ request()->routeIs('guru.kehadiran-siswa') ? 'bg-blue-100 text-blue-800' : 'text-gray-700' }}">
        Kehadiran Siswa
      </a>
    </div>

    <a href="{{ route('guru.absensi') }}"
       class="flex items-center gap-3 px-4 py-2 font-semibold text-sm rounded-lg transition
       {{ request()->routeIs('guru.absensi') ? 'bg-blue-100 text-blue-800' : 'hover:bg-gray-100 text-gray-700' }}">
       <i class="fas fa-camera text-base"></i> Absensi
    </a>
  </nav>

  <!-- Bottom Section -->
  <div class="mt-auto">
    <!-- Additional Links -->
    <nav class="space-y-3 mt-8 pt-6 border-t">
      <a href="#" class="flex items-center gap-3 text-sm text-gray-600 hover:text-blue-600 transition">
        <i class="fas fa-cog"></i> Settings
      </a>
      <a href="{{ route('guru.bantuan') }}" class="flex items-center gap-3 text-sm text-gray-600 hover:text-blue-600 transition">
        <i class="fas fa-question-circle"></i> Help & Feedback
      </a>
    </nav>

    <!-- User Info -->
    <div class="text-center mt-6">
      <img src="{{ asset('img/profil.jpg') }}"
           class="w-24 h-24 rounded-full mx-auto mb-3 object-cover"
           alt="User Profile" />
      <h3 class="font-semibold text-lg">{{ auth()->user()->name }}</h3>
      <p class="text-sm text-gray-500">NIP: 123456</p>
      <div class="flex justify-center gap-2 mt-4">
        <button class="bg-gray-100 text-sm font-medium px-4 py-1.5 rounded hover:bg-gray-200 transition">View</button>
        <a href="{{ route('guru.edit', 1) }}"
           class="bg-blue-100 text-sm font-medium px-4 py-1.5 rounded hover:bg-blue-200 transition">Edit</a>
      </div>
    </div>

    <!-- Logout Button -->
    <form method="POST" action="{{ route('logout') }}" class="mt-6">
      @csrf
      <button type="submit"
              class="w-full bg-red-600 hover:bg-red-700 text-white font-medium text-sm px-4 py-2 rounded transition">
        Logout
      </button>
    </form>
  </div>
</aside>
