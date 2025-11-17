<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Internal Server Error</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@300;400;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'JetBrains Mono', monospace;
            background: #1a1a1a;
            color: #00d9ff;
            min-height: 100vh;
            overflow: hidden;
            position: relative;
        }

        .server-room {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background:
                linear-gradient(90deg, #1a1a1a 21px, transparent 1%) center,
                linear-gradient(#1a1a1a 21px, transparent 1%) center,
                #333;
            background-size: 22px 22px;
            z-index: -1;
            opacity: 0.3;
        }

        .server-rack {
            position: absolute;
            width: 200px;
            height: 300px;
            background: #2a2a2a;
            border: 2px solid #00d9ff;
            border-radius: 10px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: -1;
        }

        .server-light {
            position: absolute;
            width: 15px;
            height: 15px;
            background: #ff4444;
            border-radius: 50%;
            animation: serverBlink 1s infinite;
            box-shadow: 0 0 10px #ff4444;
        }

        @keyframes serverBlink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.3; }
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

        .server-icon {
            font-size: 8rem;
            margin-bottom: 2rem;
            animation: serverShake 0.5s ease-in-out infinite;
        }

        @keyframes serverShake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .error-code {
            font-size: 6rem;
            font-weight: 700;
            color: #ff4444;
            text-shadow: 0 0 30px #ff4444;
            margin-bottom: 1rem;
        }

        .error-title {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: #00d9ff;
        }

        .error-message {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            max-width: 500px;
            line-height: 1.6;
            color: #00d9ff;
        }

        .terminal {
            background: rgba(0, 0, 0, 0.8);
            border: 1px solid #00d9ff;
            border-radius: 5px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            width: 100%;
            max-width: 600px;
            text-align: left;
            font-family: 'JetBrains Mono', monospace;
        }

        .terminal-line {
            margin-bottom: 0.5rem;
            animation: typewriter 2s steps(40) 1s both;
            overflow: hidden;
            white-space: nowrap;
        }

        @keyframes typewriter {
            from { width: 0; }
            to { width: 100%; }
        }

        .prompt {
            color: #00ff00;
        }

        .error {
            color: #ff4444;
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
            border-radius: 5px;
            font-family: 'JetBrains Mono', monospace;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
            font-size: 1rem;
        }

        .btn-primary {
            background: #00d9ff;
            color: #1a1a1a;
        }

        .btn-secondary {
            background: transparent;
            color: #00d9ff;
            border: 2px solid #00d9ff;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 217, 255, 0.4);
        }
    </style>
</head>
<body>
    <div class="server-room"></div>
    <div class="server-rack" id="serverRack"></div>

    <div class="container">
        <div class="server-icon">🖥️</div>
        <div class="error-code">500</div>
        <h1 class="error-title">Internal Server Error</h1>

        <div class="terminal">
            <div class="terminal-line">
                <span class="prompt">server@forum:~$</span> status --check
            </div>
            <div class="terminal-line">
                <span class="error">❌ ERROR:</span> Internal server malfunction
            </div>
            <div class="terminal-line">
                <span class="prompt">server@forum:~$</span> diagnose --system
            </div>
            <div class="terminal-line">
                🔧 System: Unhandled exception detected
            </div>
            <div class="terminal-line">
                <span class="prompt">server@forum:~$</span> _
            </div>
        </div>

        <p class="error-message">
            Terjadi kesalahan internal pada server kami. Tim teknis telah diberitahu
            dan sedang memperbaiki masalah ini.
        </p>

        <div class="btn-group">
            <button onclick="window.location.reload()" class="btn btn-primary">
                🔄 Refresh Server
            </button>
            <a href="{{ url('/') }}" class="btn btn-secondary">🏠 Kembali ke Home</a>
        </div>
    </div>

    <script>
        // Create server lights
        function createServerLights() {
            const rack = document.getElementById('serverRack');
            const lightCount = 12;

            for (let i = 0; i < lightCount; i++) {
                const light = document.createElement('div');
                light.className = 'server-light';

                const row = Math.floor(i / 3);
                const col = i % 3;

                light.style.left = `${20 + col * 60}px`;
                light.style.top = `${20 + row * 40}px`;
                light.style.animationDelay = `${Math.random() * 2}s`;

                // Random color for some lights
                if (Math.random() > 0.7) {
                    light.style.background = '#00ff00';
                    light.style.boxShadow = '0 0 10px #00ff00';
                } else if (Math.random() > 0.5) {
                    light.style.background = '#ffa500';
                    light.style.boxShadow = '0 0 10px #ffa500';
                }

                rack.appendChild(light);
            }
        }

        createServerLights();
    </script>
</body>
</html>
