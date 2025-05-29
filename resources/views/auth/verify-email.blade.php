<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Verifikasi Email - Sistem Sekolah</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-blue-100">
    <div class="bg-white shadow-2xl rounded-2xl flex w-[90%] max-w-4xl overflow-hidden">
        <!-- Sidebar Gambar -->
        <div class="hidden md:block w-1/2 bg-cover bg-center" style="background-image: url('{{ asset('img/ok.jpg') }}');"></div>

        <!-- Konten -->
        <div class="w-full md:w-1/2 p-8">
            <div class="text-center mb-6">
                <img src="{{ asset('img/logo.jpg') }}" alt="Logo" class="mx-auto w-20 mb-2" />
                <h1 class="text-3xl font-bold text-blue-700 mb-2">Verifikasi Email</h1>
                <p class="text-gray-600 text-sm">
                    Terima kasih telah mendaftar! Silakan verifikasi alamat email Anda dengan mengklik tautan yang kami kirimkan.
                    Jika belum menerima email, kami akan dengan senang hati mengirimkan tautan baru.
                </p>
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 font-medium text-sm text-green-600 bg-green-100 p-3 rounded">
                    Tautan verifikasi baru telah dikirim ke alamat email yang Anda daftarkan.
                </div>
            @endif

            <div class="mt-6 flex flex-col md:flex-row justify-between gap-4">
                <form method="POST" action="{{ route('verification.send') }}" class="w-full">
                    @csrf
                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-md transition duration-200">
                        Kirim Ulang Email Verifikasi
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit"
                        class="w-full text-blue-600 underline hover:text-blue-800 transition duration-200">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
