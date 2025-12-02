<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>429 - Too Many Requests</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #ff6b6b, #ffa726);
            color: white;
            min-height: 100vh;
            overflow: hidden;
            position: relative;
        }

        .traffic-container {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 150px;
            background: #2c3e50;
            overflow: hidden;
        }

        .road {
            position: absolute;
            top: 50%;
            left: 0;
            width: 100%;
            height: 4px;
            background: white;
            transform: translateY(-50%);
        }

        .road::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, #f1c40f, transparent);
            animation: roadLine 2s linear infinite;
        }

        @keyframes roadLine {
            0% { left: -100%; }
            100% { left: 100%; }
        }

        .car {
            position: absolute;
            font-size: 3rem;
            animation: drive 3s linear infinite;
        }

        @keyframes drive {
            0% { transform: translateX(-100px); }
            100% { transform: translateX(calc(100vw + 100px)); }
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: calc(100vh - 150px);
            text-align: center;
            padding: 2rem;
            position: relative;
            z-index: 2;
        }

        .traffic-light {
            width: 120px;
            height: 300px;
            background: #34495e;
            border-radius: 30px;
            margin-bottom: 2rem;
            position: relative;
            padding: 20px 0;
        }

        .light {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin: 10px auto;
            background: #2c3e50;
            position: relative;
        }

        .light.red {
            animation: redLight 3s infinite;
        }

        @keyframes redLight {
            0%, 100% { background: #e74c3c; box-shadow: 0 0 20px #e74c3c; }
            33%, 66% { background: #2c3e50; box-shadow: none; }
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

        .timer {
            background: rgba(255, 255, 255, 0.2);
            padding: 1rem 2rem;
            border-radius: 50px;
            margin-bottom: 2rem;
            font-size: 1.5rem;
            font-weight: bold;
            backdrop-filter: blur(10px);
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
            font-family: 'Roboto', sans-serif;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
            font-size: 1rem;
        }

        .btn-primary {
            background: white;
            color: #e74c3c;
        }

        .btn-secondary {
            background: transparent;
            color: white;
            border: 2px solid white;
        }

        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none !important;
        }

        .btn:hover:not(:disabled) {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="traffic-light">
            <div class="light red"></div>
            <div class="light"></div>
            <div class="light"></div>
        </div>

        <div class="error-code">429</div>
        <h1 class="error-title">Terlalu Banyak Request</h1>

        <p class="error-message">
            Anda telah mengirim terlalu banyak request ke server.
            Silakan tunggu beberapa saat sebelum mencoba lagi.
        </p>

        <div class="timer" id="timer">
            Coba lagi dalam: <span id="countdown">30</span> detik
        </div>

        <div class="btn-group">
            <button id="retryBtn" disabled class="btn btn-primary">
                ⏳ Tunggu...
            </button>
            <a href="{{ url('/') }}" class="btn btn-secondary">🏠 Ke Home</a>
        </div>
    </div>

    <div class="traffic-container">
        <div class="road"></div>
        <div class="car" style="top: 20px; animation-delay: 0s;">🚗</div>
        <div class="car" style="top: 60px; animation-delay: 1s;">🚙</div>
        <div class="car" style="top: 100px; animation-delay: 2s;">🚐</div>
    </div>

    <script>
        // Countdown timer
        let timeLeft = 30;
        const countdownElement = document.getElementById('countdown');
        const retryBtn = document.getElementById('retryBtn');

        const countdown = setInterval(() => {
            timeLeft--;
            countdownElement.textContent = timeLeft;

            if (timeLeft <= 0) {
                clearInterval(countdown);
                retryBtn.innerHTML = '🔄 Coba Lagi';
                retryBtn.disabled = false;
                retryBtn.onclick = () => window.location.reload();
            }
        }, 1000);

        // Create additional cars
        function createTraffic() {
            const container = document.querySelector('.traffic-container');
            for (let i = 0; i < 5; i++) {
                const car = document.createElement('div');
                car.className = 'car';
                car.innerHTML = '🚗';
                car.style.top = `${Math.random() * 100 + 20}px`;
                car.style.animationDelay = `${Math.random() * 5}s`;
                car.style.animationDuration = `${Math.random() * 2 + 2}s`;
                container.appendChild(car);
            }
        }

        createTraffic();
    </script>
</body>
</html>
