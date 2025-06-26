<!DOCTYPE html>
<html>
<head>
    <title>Verifikasi OTP</title>
</head>
<body>
    <h1>Verifikasi OTP</h1>
    @if(session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <form method="POST" action="{{ route('verify.otp.submit') }}">
        @csrf
        <input type="text" name="otp_code" placeholder="Masukkan OTP" required />
        @error('otp_code') <p style="color:red">{{ $message }}</p> @enderror
        <button type="submit">Verifikasi</button>
    </form>
</body>
</html>
