<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Konfirmasi Password - Sistem Sekolah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="min-h-screen flex items-center justify-center bg-blue-100">
    <div class="bg-white shadow-2xl rounded-2xl flex w-[90%] max-w-4xl overflow-hidden">
        <!-- Sidebar Image (optional) -->
        <div class="hidden md:block w-1/2 bg-cover bg-center" style="background-image: url('{{ asset('img/fix.png') }}');"></div>

        <!-- Form Konfirmasi -->
        <div class="w-full md:w-1/2 p-8">
            <div class="text-center mb-6">
                <img src="{{ asset('img/logo.jpg') }}" alt="Logo Sekolah" class="mx-auto w-20 mb-2">
                <h1 class="text-3xl font-bold text-blue-700">Konfirmasi Password</h1>
                <p class="text-gray-500 text-sm">
                    Ini adalah area aman. Silakan konfirmasi password Anda sebelum melanjutkan.
                </p>
            </div>

            @if ($errors->any())
                <div class="mb-4 text-red-600 text-sm bg-red-100 p-3 rounded">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf
                <div class="mb-6 relative">
                    <label for="password" class="block text-sm text-gray-600 mb-1">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        class="w-full p-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400"
                        placeholder="••••••••">
                    <span onclick="togglePassword()" class="absolute right-4 top-10 cursor-pointer text-gray-400">
                        <i id="eyeIcon" class="fas fa-eye"></i>
                    </span>
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 text-white py-3 rounded-md hover:bg-blue-700 transition duration-200">
                    Konfirmasi
                </button>
            </form>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
    <script>
        function togglePassword() {
            const passwordField = document.getElementById("password");
            const eyeIcon = document.getElementById("eyeIcon");
            if (passwordField.type === "password") {
                passwordField.type = "text";
                eyeIcon.classList.replace("fa-eye", "fa-eye-slash");
            } else {
                passwordField.type = "password";
                eyeIcon.classList.replace("fa-eye-slash", "fa-eye");
            }
        }
    </script>
</body>
</html>
