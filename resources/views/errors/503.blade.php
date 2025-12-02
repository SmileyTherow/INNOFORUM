<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>503 - Service Unavailable</title>
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

        .construction-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background:
                repeating-linear-gradient(
                    45deg,
                    transparent,
                    transparent 10px,
                    rgba(255, 255, 255, 0.1) 10px,
                    rgba(255, 255, 255, 0.1) 20px
                );
            z-index: -1;
        }

        .tools {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        .tool {
            position: absolute;
            font-size: 2rem;
            animation: floatTool 6s ease-in-out infinite;
        }

        @keyframes floatTool {
            0%, 100% {
                transform: translateY(0px) rotate(0deg);
            }
            50% {
                transform: translateY(-20px) rotate(10deg);
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

        .maintenance-icon {
            font-size: 8rem;
            margin-bottom: 2rem;
            animation: hammerHit 2s ease-in-out infinite;
        }

        @keyframes hammerHit {
            0%, 100% { transform: rotate(0deg); }
            25% { transform: rotate(-30deg); }
            50% { transform: rotate(0deg); }
            75% { transform: rotate(10deg); }
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

        .maintenance-notice {
            background: rgba(255, 255, 255, 0.2);
            padding: 1.5rem;
            border-radius: 10px;
            margin-bottom: 2rem;
            backdrop-filter: blur(10px);
            border-left: 4px solid #ffa726;
        }

        .progress-container {
            width: 100%;
            max-width: 400px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            padding: 3px;
            margin-bottom: 2rem;
        }

        .progress-bar {
            height: 20px;
            background: linear-gradient(90deg, #4facfe 0%, #00f2fe 100%);
            border-radius: 8px;
            width: 65%;
            animation: progressPulse 2s ease-in-out infinite;
            position: relative;
            overflow: hidden;
        }

        .progress-bar::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            animation: shimmer 2s infinite;
        }

        @keyframes progressPulse {
            0%, 100% { transform: scaleX(1); }
            50% { transform: scaleX(1.02); }
        }

        @keyframes shimmer {
            0% { left: -100%; }
            100% { left: 100%; }
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

        .status-update {
            font-size: 0.9rem;
            opacity: 0.8;
            margin-top: 1rem;
        }
    </style>
</head>
<body>
    <div class="construction-bg"></div>
    <div class="tools" id="tools"></div>

    <div class="container">
        <div class="maintenance-icon">🔧</div>
        <div class="error-code">503</div>
        <h1 class="error-title">Sedang Dalam Pemeliharaan</h1>

        <div class="maintenance-notice">
            <strong>📢 Pemberitahuan Pemeliharaan</strong>
            <p style="margin-top: 0.5rem;">
                Forum sedang dalam proses pemeliharaan untuk pengalaman yang lebih baik.
                Kami akan segera kembali!
            </p>
        </div>

        <div class="progress-container">
            <div class="progress-bar"></div>
        </div>

        <p class="error-message">
            Tim kami sedang bekerja keras untuk menyelesaikan pemeliharaan.
            Perkiraan waktu selesai: <strong>30 menit lagi</strong>
        </p>

        <div class="btn-group">
            <button onclick="window.location.reload()" class="btn btn-primary">
                🔄 Cek Status
            </button>
            <a href="{{ url('/') }}" class="btn btn-secondary">🏠 Halaman Utama</a>
        </div>

        <div class="status-update">
            🔨 Terakhir diperbarui: {{ now()->format('H:i') }}
        </div>
    </div>

    <script>
        // Create floating tools
        function createTools() {
            const toolsContainer = document.getElementById('tools');
            const tools = ['⚒️', '🛠️', '🔨', '⛏️', '🪚', '🔧', '🧰'];
            const toolCount = 8;

            for (let i = 0; i < toolCount; i++) {
                const tool = document.createElement('div');
                tool.className = 'tool';
                tool.innerHTML = tools[Math.floor(Math.random() * tools.length)];

                tool.style.left = `${Math.random() * 100}%`;
                tool.style.top = `${Math.random() * 100}%`;
                tool.style.animationDelay = `${Math.random() * 6}s`;
                tool.style.animationDuration = `${Math.random() * 3 + 4}s`;

                toolsContainer.appendChild(tool);
            }
        }

        createTools();

        // Simulate progress updates
        let progress = 65;
        const progressBar = document.querySelector('.progress-bar');

        setInterval(() => {
            progress += Math.random() * 2;
            if (progress > 95) progress = 65;
            progressBar.style.width = `${progress}%`;
        }, 5000);
    </script>
</body>
</html>
