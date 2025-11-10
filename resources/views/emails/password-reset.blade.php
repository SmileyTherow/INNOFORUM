<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            line-height: 1.6;
            color: #333;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }

        .header h1 {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .header p {
            opacity: 0.9;
            font-size: 14px;
        }

        .content {
            padding: 40px;
        }

        .greeting {
            font-size: 18px;
            color: #2d3748;
            margin-bottom: 20px;
        }

        .message {
            color: #4a5568;
            margin-bottom: 25px;
        }

        .code-container {
            text-align: center;
            margin: 30px 0;
        }

        .code-label {
            font-size: 14px;
            color: #718096;
            margin-bottom: 10px;
        }

        .code {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-size: 32px;
            font-weight: bold;
            padding: 20px 40px;
            border-radius: 10px;
            letter-spacing: 8px;
            margin: 10px 0;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .expiry {
            text-align: center;
            color: #e53e3e;
            font-weight: 500;
            margin: 15px 0;
            padding: 10px;
            background: #fed7d7;
            border-radius: 6px;
            border-left: 4px solid #e53e3e;
        }

        .warning {
            background: #fffaf0;
            border: 1px solid #feebc8;
            border-left: 4px solid #dd6b20;
            padding: 15px;
            border-radius: 6px;
            margin: 25px 0;
        }

        .warning strong {
            color: #dd6b20;
        }

        .footer {
            text-align: center;
            padding: 25px;
            background: #f7fafc;
            color: #718096;
            font-size: 12px;
            border-top: 1px solid #e2e8f0;
        }

        .app-name {
            font-size: 16px;
            font-weight: bold;
            color: #2d3748;
            margin-bottom: 5px;
        }

        .support {
            margin: 15px 0;
            padding: 12px;
            background: #ebf8ff;
            border-radius: 6px;
            border-left: 4px solid #3182ce;
        }

        @media (max-width: 600px) {
            .content {
                padding: 25px;
            }

            .code {
                font-size: 24px;
                padding: 15px 30px;
                letter-spacing: 6px;
            }

            .header h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>🔐 Reset Password</h1>
            <p>Keamanan Akun Anda</p>
        </div>

        <div class="content">
            <div class="greeting">
                <strong>Halo!</strong>
            </div>

            <div class="message">
                Anda menerima email ini karena kami menerima permintaan reset password untuk akun Anda.
            </div>

            <div class="code-container">
                <div class="code-label">Kode Reset Password Anda:</div>
                <div class="code">{{ $code }}</div>
            </div>

            <div class="expiry">
                ⏰ Kode ini berlaku selama <strong>{{ $ttlMinutes }} menit</strong>
            </div>

            <div class="warning">
                ⚠️ <strong>Penting:</strong> Jangan bagikan kode ini kepada siapapun.
                Tim support kami tidak akan pernah meminta kode ini.
            </div>

            <div class="support">
                💡 <strong>Tips Keamanan:</strong> Pastikan Anda mengakses website resmi kami
                dan selalu periksa alamat website di browser.
            </div>

            <div style="margin-top: 25px; color: #718096; font-size: 14px;">
                Jika Anda tidak meminta reset password, abaikan email ini.
                Password Anda tidak akan berubah.
            </div>
        </div>

        <div class="footer">
            <div class="app-name">{{ config('app.name', 'Aplikasi Kami') }}</div>
            <div>Email ini dikirim secara otomatis, mohon tidak membalas email ini.</div>
            <div style="margin-top: 10px;">
                &copy; {{ date('Y') }} {{ config('app.name', 'Aplikasi Kami') }}. All rights reserved.
            </div>
        </div>
    </div>
</body>
</html>
