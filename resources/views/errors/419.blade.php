<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>419 - Page Expired</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            min-height: 100vh;
            overflow: hidden;
            position: relative;
        }

        .floating-elements {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        .floating-element {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px) rotate(0deg);
            }
            50% {
                transform: translateY(-20px) rotate(180deg);
            }
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            text-align: center;
            padding: 2rem;
            position: relative;
            z-index: 2;
        }

        .clock-container {
            position: relative;
            margin-bottom: 3rem;
        }

        .clock {
            width: 200px;
            height: 200px;
            border: 8px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            position: relative;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }

        .hour-hand, .minute-hand {
            position: absolute;
            background: white;
            transform-origin: bottom center;
            border-radius: 10px;
        }

        .hour-hand {
            width: 6px;
            height: 60px;
            top: 40px;
            left: 97px;
            animation: rotateHour 43200s linear infinite;
        }

        .minute-hand {
            width: 4px;
            height: 80px;
            top: 20px;
            left: 98px;
            animation: rotateMinute 3600s linear infinite;
        }

        @keyframes rotateHour {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        @keyframes rotateMinute {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .error-code {
            font-size: 6rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .error-title {
            font-size: 2rem;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .error-message {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            max-width: 500px;
            line-height: 1.6;
            opacity: 0.9;
        }

        .btn-group {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            justify-content: center;
        }

        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 25px;
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
            font-size: 1rem;
        }

        .btn-primary {
            background: white;
            color: #667eea;
        }

        .btn-secondary {
            background: transparent;
            color: white;
            border: 2px solid white;
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .expired-text {
            background: rgba(255, 255, 255, 0.2);
            padding: 1rem 2rem;
            border-radius: 10px;
            margin-bottom: 2rem;
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body>
    <div class="floating-elements" id="floatingElements"></div>

    <div class="container">
        <div class="clock-container">
            <div class="clock">
                <div class="hour-hand"></div>
                <div class="minute-hand"></div>
            </div>
        </div>

        <div class="expired-text">
            <div class="error-code">419</div>
            <h1 class="error-title">Sesi Telah Berakhir</h1>
        </div>

        <p class="error-message">
            Waktu sesi Anda telah habis. Silakan refresh halaman dan coba lagi.
            Ini biasanya terjadi ketika form tidak di-submit dalam waktu yang lama.
        </p>

        <div class="btn-group">
            <button onclick="window.location.reload()" class="btn btn-primary">
                🔄 Refresh Halaman
            </button>
            <a href="{{ url('/') }}" class="btn btn-secondary">🏠 Kembali ke Home</a>
        </div>
    </div>

    <script>
        // Create floating elements
        function createFloatingElements() {
            const container = document.getElementById('floatingElements');
            const elementCount = 15;

            for (let i = 0; i < elementCount; i++) {
                const element = document.createElement('div');
                element.className = 'floating-element';

                const size = Math.random() * 60 + 20;
                element.style.width = `${size}px`;
                element.style.height = `${size}px`;
                element.style.left = `${Math.random() * 100}%`;
                element.style.top = `${Math.random() * 100}%`;
                element.style.animationDelay = `${Math.random() * 6}s`;
                element.style.animationDuration = `${Math.random() * 3 + 4}s`;

                container.appendChild(element);
            }
        }

        createFloatingElements();
    </script>
</body>
</html>
