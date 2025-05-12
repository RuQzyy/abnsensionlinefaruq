<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'Dashboard')</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }
  </style>
</head>
<body class="bg-[#f3f7f7] text-[#0f172a] min-h-screen">

  <div x-data="{ sidebarOpen: false }" class="flex min-h-screen relative" x-cloak>

    {{-- Sidebar --}}
    <div
      :class="sidebarOpen ? 'block' : 'hidden'"
      class="fixed inset-0 bg-black bg-opacity-40 z-40 md:hidden"
      @click="sidebarOpen = false"
    ></div>

    <aside
      :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
      class="fixed top-0 left-0 w-64 bg-white shadow-md z-50 h-full transform transition-transform duration-200 ease-in-out md:translate-x-0 md:static md:block"
      style="position: fixed; top: 0; bottom: 0; left: 0;"
    >
      @include('components.sidebar-guru')
    </aside>

    {{-- Content Area --}}
    <div class="flex-1 flex flex-col w-full ml-0 md:ml-64">
      
      {{-- Top Bar for Mobile --}}
      <header class="bg-white shadow-md p-4 flex items-center justify-between md:hidden">
        <button @click="sidebarOpen = true">
          <i class="fas fa-bars text-xl text-gray-700"></i>
        </button>
        <h1 class="text-lg font-semibold">@yield('title', 'Dashboard')</h1>
      </header>

      {{-- Main Content --}}
      <main class="p-4 sm:p-6 md:p-8 bg-gray-50 overflow-y-auto flex-1">
        <div class="max-w-6xl mx-auto">
          @yield('content')
        </div>
      </main>
    </div>

  </div>

  {{-- AlpineJS for interactivity --}}
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  @stack('scripts')

</body>
</html>
