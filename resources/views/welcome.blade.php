<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Absensi Kita | MAN Ambon</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body, html {
      margin: 0;
      padding: 0;
      height: 100%;
    }
  </style>
</head>
<body>

  <!-- Background Image -->
  <div class="w-full h-screen bg-cover bg-center relative" style="background-image: url('{{ asset('img/page.png') }}');">

    <!-- Tombol Login & Registrasi -->
    <div class="absolute top-5 right-6 flex space-x-4 z-10">
     <form method="POST" action="{{ route('logout') }}">
  @csrf
  <button type="submit" class="bg-white text-green-700 font-semibold py-2 px-4 rounded hover:bg-green-100 shadow">
    Login
  </button>
</form>

    </div>

    <!-- Tombol Absen Sekarang (tepat di bawah tulisan siswa/i MAN Ambon) -->
   <div class="absolute top-[75%] z-10">
  <a href="{{ route('login') }}" class="bg-yellow-400 hover:bg-yellow-500 text-green-900 font-bold py-3 px-6 rounded shadow-lg text-lg">
    Absen Sekarang
  </a>
</div>


  </div>

</body>
</html>
