<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guru</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            background-image: url('{{ asset('img/ok.jpg') }}');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-900 text-white">
    <div class="bg-gray-800 bg-opacity-80 p-8 rounded-lg shadow-lg text-center w-96">
        <h1 class="text-2xl font-bold text-white mb-6">Dashboard siswa</h1>
        <p class="text-gray-300 mb-4">Selamat datang di dashboard siswa</p>

        <div class="space-y-4">
            <button class="w-full bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition">
                <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
            </button>
            
            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full bg-red-500 text-white px-6 py-2 rounded-lg hover:bg-red-600 transition">
                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                    </button>
                </form>
        </div>
        @endauth
    </div>
</body>
</html>
