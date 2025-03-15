<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body class="flex items-center justify-center min-h-screen bg-cover bg-center" style="background-image: url('{{ asset('img/ok.jpg') }}');">
    <div class="bg-gray-800 bg-opacity-75 p-8 rounded-lg shadow-lg text-center w-80">
        <h1 class="text-2xl text-white mb-6">REGISTER</h1>
        
        <!-- Tampilkan Error Jika Ada -->
        @if ($errors->any())
            <div class="mb-4 p-2 bg-red-500 text-white rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mb-4">
                <input type="text" name="name" placeholder="Name" value="{{ old('name') }}"
                    class="w-full p-2 rounded-full border border-blue-400 bg-transparent text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-400" required autofocus>
            </div>
            <div class="mb-4">
                <input type="email" name="email" placeholder="Email" value="{{ old('email') }}"
                    class="w-full p-2 rounded-full border border-blue-400 bg-transparent text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>
            <div class="mb-4">
                <select name="role" required
                    class="w-full p-2 rounded-full border border-blue-400 bg-transparent text-white focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="" disabled selected class="text-gray-800">Pilih Role</option>
                    <option value="admin" class="text-gray-800">Admin</option>
                    <option value="guru" class="text-gray-800">Guru</option>
                    <option value="siswa" class="text-gray-800">Siswa</option>
                </select>
            </div>
            <div class="mb-4">
                <input type="password" name="password" placeholder="Password"
                    class="w-full p-2 rounded-full border border-blue-400 bg-transparent text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>
            <div class="mb-6">
                <input type="password" name="password_confirmation" placeholder="Confirm Password"
                    class="w-full p-2 rounded-full border border-blue-400 bg-transparent text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>
            <button type="submit" class="w-full p-2 rounded-full border border-blue-400 text-white hover:bg-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-400">Register</button>
        </form>

        <div class="flex justify-between mt-4 text-sm text-white">
            <a href="{{ route('login') }}" class="hover:underline">Login</a>
            <a href="{{ route('password.request') }}" class="hover:underline">Forgot password?</a>
        </div>
    </div>
</body>
</html>
