<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Dashboard')</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet" />
  <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

  <style>
    body {
      font-family: "Nunito", sans-serif;
      background: #f0f4f8;
    }
    aside::-webkit-scrollbar {
      width: 6px;
    }
    aside::-webkit-scrollbar-thumb {
      background-color: #2563eb;
      border-radius: 10px;
    }
  </style>
  <style>
  body {
    font-family: "Nunito", sans-serif;
    background: #f0f4f8;
    overflow: hidden; /* MENGHILANGKAN SCROLLING PADA SELURUH BODY */
  }

  * {
    scrollbar-width: none; /* Firefox */
  }

  *::-webkit-scrollbar {
    display: none; /* Chrome, Safari, Edge */
  }

  aside::-webkit-scrollbar {
    width: 6px;
  }

  aside::-webkit-scrollbar-thumb {
    background-color: #2563eb;
    border-radius: 10px;
  }
</style>

  @stack('styles')
</head>
<body>
  <div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <aside class="w-64 h-screen fixed top-0 left-0 bg-white shadow-lg border-r z-10 overflow-y-auto">
      @include('components.sidebar-admin')
    </aside>

    <!-- Konten utama -->
    <div class="flex-1 ml-64 overflow-y-auto">
      <main class="p-6 min-h-screen bg-gray-50">
        @yield('content')
      </main>
    </div>
  </div>

  @stack('scripts')
</body>
</html>
