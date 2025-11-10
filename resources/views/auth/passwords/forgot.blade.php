<!doctype html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <title>Lupa Password</title>
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    </head>
    <body class="bg-gradient-to-br from-gray-900 to-gray-800 min-h-screen">
        <div class="min-h-screen flex items-center justify-center p-4">
            <div class="bg-gray-800 rounded-2xl shadow-xl w-full max-w-md overflow-hidden border border-gray-700">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 p-6 text-white">
                <div class="flex items-center justify-center w-16 h-16 bg-white/20 rounded-full mb-4">
                <i class="fas fa-key text-2xl"></i>
                </div>
                <h1 class="text-2xl font-bold">Lupa Password</h1>
                <p class="text-blue-100 mt-2">Masukkan email untuk mendapatkan kode reset</p>
            </div>

            <div class="p-6">
                @if(session('status'))
                <div class="mb-4 text-green-400 bg-green-900/30 p-3 rounded-lg border border-green-800 flex items-start">
                    <i class="fas fa-check-circle mt-1 mr-2"></i>
                    <span>{{ session('status') }}</span>
                </div>
                @endif

                <form method="POST" action="{{ route('password.forgot.send') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-300 mb-2 font-medium">Email</label>
                    <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-envelope text-gray-500"></i>
                    </div>
                    <input name="email" type="email" value="{{ old('email') }}" required
                            class="w-full pl-10 p-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition text-white placeholder-gray-400">
                    </div>
                    @error('email')
                    <div class="mt-2 text-red-400 text-sm flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white font-medium py-3 px-4 rounded-lg transition duration-300 transform hover:-translate-y-0.5 shadow-md">
                    Kirim Kode
                </button>
                </form>

                <div class="mt-6 p-4 bg-blue-900/30 rounded-lg border border-blue-800">
                    <div class="flex">
                        <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-blue-400 mt-1"></i>
                        </div>
                        <div class="ml-3">
                        <p class="text-sm text-blue-300">Jika email Anda terdaftar, kode verifikasi akan dikirimkan.</p>
                        </div>
                    </div>
                </div>

                <!-- Tambahan: Back to login link -->
                <div class="mt-4 text-center">
                    <a href="{{ route('login') }}" class="text-blue-400 hover:text-blue-300 text-sm font-medium transition">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali ke halaman login
                    </a>
                </div>
            </div>
            </div>
        </div>
    </body>
</html>
