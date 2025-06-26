<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP Email</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom CSS untuk background */
        .bg-custom {
            background-image: url('https://i.pinimg.com/736x/a3/30/d4/a330d4fab5119b2649ca36f353ecd051.jpg');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body class="bg-custom flex items-center justify-center min-h-screen relative">
    <!-- Overlay gelap untuk meningkatkan readability -->
    <div class="absolute inset-0 bg-black bg-opacity-50"></div>

    <!-- Container OTP (diberi z-10 agar muncul di atas overlay) -->
    <div class="bg-white p-8 rounded-xl shadow-xl w-full max-w-md z-10 relative">
        <h2 class="text-2xl font-bold mb-4">Konfirmasi Kode OTP</h2>
        <p class="mb-4 text-gray-600 text-sm">Kami telah mengirim kode OTP ke email: <span class="font-semibold">{{ $email }}</span></p>
        @if(session('error'))
            <div class="mb-3 text-red-600 font-semibold">{{ session('error') }}</div>
        @endif
        <form method="POST" action="{{ route('user.otp.verify') }}">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            <input type="text" name="otp_code" maxlength="6" class="w-full p-3 border border-gray-300 rounded-lg mb-4 text-center text-xl" placeholder="Kode OTP" required>
            <button type="submit" class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition">Verifikasi</button>
        </form>

        <form method="POST" action="{{ route('user.otp.resend') }}" class="mt-4">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            <button type="submit" class="text-blue-600 hover:text-blue-800 text-sm">Kirim Ulang OTP</button>
        </form>
    </div>
</body>
</html>