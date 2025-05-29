<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reset Password - Sistem Sekolah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="min-h-screen flex items-center justify-center bg-blue-100">
    <div class="bg-white shadow-2xl rounded-2xl flex w-[90%] max-w-4xl overflow-hidden">
        <!-- Sidebar Gambar -->
        <div class="hidden md:block w-1/2 bg-cover bg-center" style="background-image: url('{{ asset('img/fix.png') }}');"></div>

        <!-- Form -->
        <div class="w-full md:w-1/2 p-8">
            <div class="text-center mb-6">
                <img src="{{ asset('img/logo.jpg') }}" alt="Logo Sekolah" class="mx-auto w-20 mb-2">
                <h1 class="text-3xl font-bold text-blue-700">Reset Password</h1>
                <p class="text-gray-500 text-sm">
                    Silakan masukkan password baru Anda.
                </p>
            </div>

            <form method="POST" action="{{ route('password.store') }}">
                @csrf
                <!-- Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm text-gray-600 mb-1">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}"
                        required autofocus autocomplete="username"
                        class="w-full p-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400"
                        placeholder="nama@sekolah.sch.id">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="block text-sm text-gray-600 mb-1">Password Baru</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                        class="w-full p-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400"
                        placeholder="••••••••">
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Konfirmasi Password -->
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm text-gray-600 mb-1">Konfirmasi Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                        class="w-full p-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400"
                        placeholder="••••••••">
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 text-white py-3 rounded-md hover:bg-blue-700 transition duration-200">
                    Reset Password
                </button>
            </form>
        </div>
    </div>
</body>
</html>
