<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>innoforum - Validasi NIM/NIDN</title>
    <!-- Hubungkan ke file CSS -->
    <link rel="stylesheet" href="/css/nim_or_nigm.css">
</head>
<body>
    <div id="logo">
        <h1><i>innoforum</i></h1>
        <p class="subtitle">Forum Diskusi Teknologi, Inspirasi Tiada Henti</p>
    </div> 
    
    <section class="tech-login"> 
        <form action="{{ route('validate.nim') }}" method="POST"> <!-- Route untuk validasi -->
            @csrf <!-- Tambahkan CSRF token -->
            <div id="fade-box">
                <p class="welcome-text">Selamat Datang</p>
                <input type="text" name="nim_or_nigm" id="nim_or_nigm" placeholder="NIM/NIDN" required class="@error('nim_or_nigm') invalid @enderror">
                @error('nim_or_nigm') <!-- Tampilkan error jika ada -->
                    <p class="error-text">{{ $message }}</p>
                @enderror
                <button>MASUK</button>
            </div>
        </form>
    </section>
    
    <div class="hexagons">
        <span>&#x2B22;</span><span>&#x2B22;</span><span>&#x2B22;</span><span>&#x2B22;</span><span>&#x2B22;</span>
        <span>&#x2B22;</span><span>&#x2B22;</span><span>&#x2B22;</span><span>&#x2B22;</span><span>&#x2B22;</span>
        <br><span>&#x2B22;</span><span>&#x2B22;</span><span>&#x2B22;</span><span>&#x2B22;</span><span>&#x2B22;</span>
        <span>&#x2B22;</span><span>&#x2B22;</span><span>&#x2B22;</span><span>&#x2B22;</span><span>&#x2B22;</span>
        <br><span>&#x2B22;</span><span>&#x2B22;</span><span>&#x2B22;</span><span>&#x2B22;</span><span>&#x2B22;</span>
        <span>&#x2B22;</span><span>&#x2B22;</span><span>&#x2B22;</span><span>&#x2B22;</span><span>&#x2B22;</span>
        <br><span>&#x2B22;</span><span>&#x2B22;</span><span>&#x2B22;</span><span>&#x2B22;</span><span>&#x2B22;</span>
        <span>&#x2B22;</span><span>&#x2B22;</span><span>&#x2B22;</span><span>&#x2B22;</span><span>&#x2B22;</span>
        <br><span>&#x2B22;</span><span>&#x2B22;</span><span>&#x2B22;</span><span>&#x2B22;</span><span>&#x2B22;</span>
        <span>&#x2B22;</span><span>&#x2B22;</span><span>&#x2B22;</span><span>&#x2B22;</span><span>&#x2B22;</span>
    </div>
    
    <div id="circle1">
        <div id="inner-cirlce1">
            <h2> </h2>
        </div>
    </div>
    <!-- Hubungkan ke file JS -->
    <script src="/js/nim_or_nigm.js"></script>
</body>
</html>