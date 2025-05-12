<aside
  aria-label="Sidebar Navigation"
  class="fixed top-0 left-0 h-screen w-full md:w-64 bg-white shadow-xl flex flex-col border-r z-50 overflow-y-auto"
  x-data="{ openKehadiran: false }"
>
  <!-- Logo -->
  <div class="flex items-center gap-3 h-20 px-6 border-b border-gray-200">
    <img src="{{ asset('img/logo.jpg') }}" alt="Logo Sekolah" class="w-10 h-10 rounded-full" />
    <h1 class="text-lg font-bold text-gray-800">MAN Ambon</h1>
  </div>

  <!-- Navigation Menu -->
  <nav class="flex flex-col gap-1 mt-6 px-4">
    <a href="{{ route('admin.index') }}"
       class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition
              {{ request()->routeIs('admin.index') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-700' }}">
      <i class="fas fa-chart-line w-5 text-blue-500"></i>
      Dashboard
    </a>

    <a href="{{ route('admin.pengguna') }}"
       class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition
              {{ request()->is('admin/pengguna*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-700' }}">
      <i class="fas fa-users w-5 text-green-500"></i>
      Pengguna
    </a>

      <a href="{{ route('admin.kelas') }}"
       class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition
              {{ request()->is('admin/kelas*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-700' }}">
      <i class="fas fa-chalkboard-teacher w-5 text-indigo-500"></i> 
      kelas
    </a>

    <!-- Kehadiran dengan dropdown -->
    <div>
      <button
        @click="openKehadiran = !openKehadiran"
        class="w-full flex items-center justify-between px-4 py-3 rounded-lg font-medium transition
               {{ request()->is('admin/kehadiran*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-700' }}">
        <div class="flex items-center gap-3">
          <i class="fas fa-calendar-check w-5 text-indigo-500"></i>
          Kehadiran
        </div>
        <i class="fas fa-chevron-down text-xs transition-transform duration-200" :class="{ 'rotate-180': openKehadiran }"></i>
      </button>

      <div x-show="openKehadiran" x-cloak class="ml-8 mt-1 space-y-1">
        <a href="{{ route('admin.kehadiran-guru') }}"
           class="block text-sm font-medium transition
                  {{ request()->is('admin/kehadiran/guru') ? 'text-blue-700' : 'text-gray-600 hover:text-blue-700' }}">
          Kehadiran Guru
        </a>
       <a href="{{ route('admin.kehadiran-siswa') }}"
           class="block text-sm font-medium transition
                  {{ request()->is('admin/kehadiran/siswa') ? 'text-blue-700' : 'text-gray-600 hover:text-blue-700' }}">
          Kehadiran Siswa
        </a>
      </div>
    </div>

    <a href="{{ route('admin.notifikasi') }}"
       class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition
              {{ request()->is('admin/notifikasi*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-700' }}">
      <i class="fas fa-bell w-5 text-yellow-500"></i>
      Notifikasi
    </a>

    <a href="{{ route('admin.pengaturan') }}"
       class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition
              {{ request()->routeIs('admin.pengaturan') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-700' }}">
      <i class="fas fa-cog w-5 text-gray-500"></i>
      Pengaturan
    </a>
  </nav>

  <!-- User Info & Logout -->
  <div class="mt-auto px-4 py-6 border-t border-gray-200 bg-gray-50">
    <div class="flex items-center gap-3">
      <i class="fas fa-user-circle text-3xl text-gray-400"></i>
      <div class="leading-tight">
        <p class="font-semibold text-gray-800">Admin Sekolah</p>
        <p class="text-sm text-gray-500">admin@smkn1.sch.id</p>
      </div>
    </div>

    <form method="POST" action="{{ route('logout') }}" class="mt-4">
      @csrf
      <button
        type="submit"
        class="w-full bg-red-500 hover:bg-red-600 text-white font-semibold text-sm px-4 py-2 rounded-lg transition">
        Logout
      </button>
    </form>
  </div>
</aside>
