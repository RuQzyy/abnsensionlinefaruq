<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lupa Password - Sistem Sekolah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="min-h-screen flex items-center justify-center bg-blue-100">
    <div class="bg-white shadow-2xl rounded-2xl flex w-[90%] max-w-4xl overflow-hidden">
        <!-- Sidebar Image -->
        <div class="hidden md:block w-1/2 bg-cover bg-center" style="background-image: url('{{ asset('img/fix.png') }}');"></div>

        <!-- Form -->
        <div class="w-full md:w-1/2 p-8">
            <div class="text-center mb-6">
                <img src="{{ asset('img/logo.jpg') }}" alt="Logo Sekolah" class="mx-auto w-20 mb-2">
                <h1 class="text-3xl font-bold text-blue-700">Lupa Password</h1>
                <p class="text-gray-500 text-sm">
                    Masukkan email Anda untuk menerima link reset password.
                </p>
            </div>

            @if (session('status'))
                <div class="mb-4 text-green-600 text-sm bg-green-100 p-3 rounded">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 text-red-600 text-sm bg-red-100 p-3 rounded">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="mb-4">
                    <label for="email" class="block text-sm text-gray-600 mb-1">Email</label>
                    <input id="email" type="email" name="email" required autofocus
                        placeholder="nama@sekolah.sch.id"
                        class="w-full p-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 text-white py-3 rounded-md hover:bg-blue-700 transition duration-200">
                    Kirim Link Reset
                </button>
            </form>

            <div class="flex justify-center mt-6 text-sm text-blue-600">
                <a href="{{ route('login') }}" class="hover:underline">Login</a>
            </div>
        </div>
    </div>
</body>
</html>
