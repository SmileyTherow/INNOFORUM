<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP</title>
</head>
<body>
    <div class="form-container">
        <h1>Verifikasi OTP</h1>
        @if (session('error'))
            <p style="color: red;">{{ session('error') }}</p>
        @endif
        <form action="{{ route('verify.otp.submit') }}" method="POST">
            @csrf
            <input
                type="text"
                name="otp"
                placeholder="Masukkan Kode OTP"
                required
            />
            @error('otp')
                <p style="color: red;">{{ $message }}</p>
            @enderror
            <button type="submit">Verifikasi</button>
        </form>
    </div>
</body>
</html>