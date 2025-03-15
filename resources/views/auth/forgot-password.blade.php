<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body class="flex items-center justify-center min-h-screen bg-cover bg-center" style="background-image: url('{{ asset('img/ok.jpg') }}');">
    <div class="bg-gray-800 bg-opacity-75 p-8 rounded-lg shadow-lg text-center w-80">
        <h1 class="text-2xl text-white mb-6">Forgot Password</h1>
        <p class="text-white mb-4">Please enter your email address to receive a password reset link.</p>
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-4">
                <input type="email" name="email" placeholder="Email" class="w-full p-2 rounded-full border border-blue-400 bg-transparent text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-400" required autofocus>
            </div>
            <button type="submit" class="w-full p-2 rounded-full border border-blue-400 text-white hover:bg-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-400">Send Password Reset Link</button>
        </form>
        <div class="flex justify-between mt-4 text-sm text-white">
            <a href="{{ route('login') }}" class="hover:underline">Login</a>
            <a href="{{ route('register') }}" class="hover:underline">Register</a>
        </div>
    </div>
</body>
</html>
