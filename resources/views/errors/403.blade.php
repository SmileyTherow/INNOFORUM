<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Forbidden</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Share+Tech+Mono&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Share Tech Mono', monospace;
            background: #0a0a0a;
            color: #00ff41;
            min-height: 100vh;
            overflow: hidden;
            position: relative;
        }

        .matrix-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            opacity: 0.3;
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

        .hacker-icon {
            font-size: 8rem;
            margin-bottom: 2rem;
            animation: glitch 2s infinite;
        }

        @keyframes glitch {
            0%, 100% {
                transform: translate(0);
                text-shadow: 0 0 20px #00ff41;
            }
            25% {
                transform: translate(-2px, 2px);
                text-shadow: -2px 0 #ff0080, 2px 0 #00ffff;
            }
            50% {
                transform: translate(2px, -2px);
                text-shadow: 2px 0 #ff0080, -2px 0 #00ffff;
            }
            75% {
                transform: translate(-2px, -2px);
                text-shadow: -2px 0 #ff0080, 2px 0 #00ffff;
            }
        }

        .error-code {
            font-size: 6rem;
            font-weight: bold;
            color: #ff0080;
            text-shadow: 0 0 30px #ff0080;
            margin-bottom: 1rem;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }

        .error-title {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: #00ffff;
        }

        .error-message {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            max-width: 500px;
            line-height: 1.6;
            color: #00ff41;
        }

        .access-denied {
            background: rgba(0, 255, 65, 0.1);
            border: 1px solid #00ff41;
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 2rem;
            font-size: 0.9rem;
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
            border-radius: 0;
            font-family: 'Share Tech Mono', monospace;
            font-weight: bold;
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
            font-size: 1rem;
            position: relative;
            overflow: hidden;
        }

        .btn-primary {
            background: transparent;
            color: #00ff41;
            border: 2px solid #00ff41;
        }

        .btn-secondary {
            background: transparent;
            color: #00ffff;
            border: 2px solid #00ffff;
        }

        .btn:hover {
            background: rgba(0, 255, 65, 0.1);
            box-shadow: 0 0 20px rgba(0, 255, 65, 0.5);
            transform: translateY(-2px);
        }

        .scan-line {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, transparent, #00ff41, transparent);
            animation: scan 3s linear infinite;
        }

        @keyframes scan {
            0% { top: 0%; }
            100% { top: 100%; }
        }
    </style>
</head>
<body>
    <div class="matrix-bg" id="matrixBg"></div>
    <div class="scan-line"></div>

    <div class="container">
        <div class="hacker-icon">💻</div>
        <div class="error-code">403</div>
        <h1 class="error-title">Akses Dilarang</h1>
        <p class="error-message">
            Anda tidak memiliki izin untuk mengakses halaman ini.
            Area terbatas untuk pengguna terotorisasi.
        </p>
        <div class="access-denied">
            [ ACCESS_DENIED :: FORBIDDEN_ZONE ]
        </div>
        <div class="btn-group">
            <a href="{{ url()->previous() }}" class="btn btn-primary">Kembali</a>
            <a href="{{ url('/') }}" class="btn btn-secondary">Home Base</a>
        </div>
    </div>

    <script>
        // Simple matrix background effect
        function createMatrix() {
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');
            const container = document.getElementById('matrixBg');

            canvas.width = container.clientWidth;
            canvas.height = container.clientHeight;
            container.appendChild(canvas);

            const chars = "01";
            const charSize = 14;
            const columns = canvas.width / charSize;
            const drops = Array(Math.floor(columns)).fill(1);

            function draw() {
                ctx.fillStyle = 'rgba(0, 0, 0, 0.05)';
                ctx.fillRect(0, 0, canvas.width, canvas.height);

                ctx.fillStyle = '#00ff41';
                ctx.font = `${charSize}px 'Share Tech Mono'`;

                drops.forEach((y, i) => {
                    const text = chars[Math.floor(Math.random() * chars.length)];
                    ctx.fillText(text, i * charSize, y * charSize);

                    if (y * charSize > canvas.height && Math.random() > 0.975) {
                        drops[i] = 0;
                    }
                    drops[i]++;
                });
            }

            setInterval(draw, 50);
        }

        createMatrix();
    </script>
</body>
</html>
