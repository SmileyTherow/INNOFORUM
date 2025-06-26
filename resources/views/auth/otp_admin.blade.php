<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom CSS untuk background */
        .bg-custom {
            background-image: url('https://i.pinimg.com/736x/2c/45/47/2c4547051f1471974d5ebace1b41ffec.jpg');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body class="bg-custom flex items-center justify-center min-h-screen relative">
    <!-- Overlay gelap untuk meningkatkan readability -->
    <div class="absolute inset-0 bg-black bg-opacity-50"></div>

    <!-- Container OTP (diberi z-10 agar muncul di atas overlay) -->
    <div class="bg-white p-10 rounded-xl shadow-lg w-full max-w-md z-10 relative">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-2">OTP Verification</h1>
            <p class="text-gray-600 text-sm">We have sent a verification code to your email</p>
        </div>
        
        <!-- Error message (Laravel flash session) -->
        @if(session('error'))
            <div class="mb-4 text-center text-red-600 font-semibold">
                {{ session('error') }}
            </div>
        @endif

        <!-- OTP Input Form -->
        <form id="otpForm" method="POST" action="{{ route('otp.admin.verify') }}">
            @csrf
            <div class="flex justify-between mb-8">
                <input 
                    type="text" 
                    maxlength="1" 
                    class="otp-input w-16 h-16 text-2xl text-center border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition"
                    data-index="0"
                    autofocus
                >
                <input 
                    type="text" 
                    maxlength="1" 
                    class="otp-input w-16 h-16 text-2xl text-center border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition"
                    data-index="1"
                >
                <input 
                    type="text" 
                    maxlength="1" 
                    class="otp-input w-16 h-16 text-2xl text-center border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition"
                    data-index="2"
                >
                <input 
                    type="text" 
                    maxlength="1" 
                    class="otp-input w-16 h-16 text-2xl text-center border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition"
                    data-index="3"
                >
            </div>

            <!-- Hidden input untuk submit kode OTP gabungan -->
            <input type="hidden" name="otp_code" id="otp_code">

            <!-- Verify Button -->
            <button 
                type="submit"
                id="verifyBtn"
                class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition duration-300"
            >
                Verify
            </button>
        </form>

        <!-- Resend Link -->
        <div class="text-center mt-5 text-sm text-gray-600">
            Didn't receive code? <a href="#" class="text-blue-600 font-semibold hover:underline">Resend</a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const otpInputs = document.querySelectorAll('.otp-input');
            const otpForm = document.getElementById('otpForm');
            const otpCodeInput = document.getElementById('otp_code');

            // Auto-tab between inputs & handle backspace
            otpInputs.forEach(input => {
                input.addEventListener('input', (e) => {
                    const currentIndex = parseInt(e.target.getAttribute('data-index'));
                    if (e.target.value.length === 1 && currentIndex < otpInputs.length - 1) {
                        otpInputs[currentIndex + 1].focus();
                    }
                });

                input.addEventListener('keydown', (e) => {
                    const currentIndex = parseInt(e.target.getAttribute('data-index'));
                    if (e.key === 'Backspace' && e.target.value.length === 0 && currentIndex > 0) {
                        otpInputs[currentIndex - 1].focus();
                    }
                });
            });

            // On form submit, combine OTP and submit via hidden input
            otpForm.addEventListener('submit', function(e) {
                let otpCode = '';
                otpInputs.forEach(input => otpCode += input.value);
                if (otpCode.length !== otpInputs.length) {
                    e.preventDefault();
                    alert('Please enter the complete OTP code!');
                } else {
                    otpCodeInput.value = otpCode;
                }
            });
        });
    </script>
</body>
</html>