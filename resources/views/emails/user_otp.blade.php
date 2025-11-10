<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Verifikasi Email - INNOFORUM</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', Arial, sans-serif;
            line-height: 1.6;
            color: #374151;
            margin: 0;
            padding: 0;
            background-color: #f9fafb;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            padding: 40px 30px;
            text-align: center;
            color: white;
        }

        .logo {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .tagline {
            font-size: 16px;
            opacity: 0.9;
            font-weight: 300;
        }

        .content {
            padding: 40px 30px;
        }

        .welcome-section {
            text-align: center;
            margin-bottom: 30px;
        }

        .welcome-icon {
            font-size: 48px;
            margin-bottom: 15px;
        }

        .welcome-title {
            font-size: 28px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 10px;
        }

        .welcome-subtitle {
            font-size: 16px;
            color: #6b7280;
        }

        .otp-section {
            background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
            border-radius: 12px;
            padding: 30px;
            text-align: center;
            margin: 30px 0;
            border: 1px solid #bae6fd;
        }

        .otp-code {
            font-size: 48px;
            font-weight: 700;
            color: #0369a1;
            letter-spacing: 8px;
            margin: 20px 0;
            font-family: 'Courier New', monospace;
        }

        .otp-instruction {
            font-size: 14px;
            color: #475569;
            margin-bottom: 10px;
        }

        .otp-warning {
            font-size: 12px;
            color: #dc2626;
            font-weight: 500;
        }

        .info-section {
            background: #f8fafc;
            border-radius: 12px;
            padding: 25px;
            margin: 25px 0;
            border-left: 4px solid #3b82f6;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: #1e40af;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .mission-vision {
            display: grid;
            gap: 20px;
            margin-bottom: 25px;
        }

        .mission-item, .rule-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 8px;
        }

        .mission-icon, .rule-icon {
            color: #3b82f6;
            font-weight: 600;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .rules-grid {
            display: grid;
            gap: 15px;
        }

        .rule-item {
            background: #ffffff;
            padding: 12px 15px;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }

        .rule-item.warning {
            border-left: 3px solid #dc2626;
            background: #fef2f2;
        }

        .footer {
            background: #1f2937;
            color: #9ca3af;
            padding: 30px;
            text-align: center;
            font-size: 12px;
        }

        .social-links {
            margin: 20px 0;
        }

        .social-link {
            display: inline-block;
            margin: 0 10px;
            color: #9ca3af;
            text-decoration: none;
        }

        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
            padding: 12px 30px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <div class="logo">INNOFORUM</div>
            <div class="tagline">Ignite Innovation, Connect Minds, Shape the Future</div>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Welcome Section -->
            <div class="welcome-section">
                <div class="welcome-icon">🎉</div>
                <h1 class="welcome-title">Selamat Datang di INNOFORUM!</h1>
                <p class="welcome-subtitle">
                    Bergabunglah dengan komunitas akademik yang inovatif dan kolaboratif
                </p>
            </div>

            <!-- OTP Section -->
            <div class="otp-section">
                <h3 style="margin: 0 0 15px 0; color: #0369a1; font-weight: 600;">
                    Kode Verifikasi Email Anda
                </h3>
                <div class="otp-code">{{ $otpCode }}</div>
                <p class="otp-instruction">
                    Masukkan kode ini pada halaman verifikasi untuk mengaktifkan akun Anda
                </p>
                <p class="otp-warning">
                    ⚠️ Jangan bagikan kode ini ke siapa pun, termasuk admin INNOFORUM
                </p>
            </div>

            <!-- Quick Info -->
            <div class="info-section">
                <div class="section-title">
                    <span>📋</span>
                    Informasi Cepat
                </div>
                <p style="margin: 0; color: #475569;">
                    Kode OTP ini akan kedaluwarsa dalam <strong>15 menit</strong>.
                    Jika Anda tidak meminta kode ini, abaikan email ini.
                </p>
            </div>

            <!-- Vision & Mission -->
            <div class="mission-vision">
                <div>
                    <div class="section-title">
                        <span>🎯</span>
                        Visi & Misi INNOFORUM
                    </div>
                    <div style="background: #f0f9ff; padding: 20px; border-radius: 8px;">
                        <p style="margin: 0 0 15px 0; font-weight: 500; color: #1e40af;">
                            🎯 Visi: Menjadi pusat diskusi digital yang terbuka, cerdas, dan inspiratif bagi seluruh civitas akademika
                        </p>
                        <div style="font-size: 14px; color: #475569;">
                            <div class="mission-item">
                                <span class="mission-icon">•</span>
                                <span>Menyediakan ruang aman dan inklusif untuk berdiskusi secara bermartabat</span>
                            </div>
                            <div class="mission-item">
                                <span class="mission-icon">•</span>
                                <span>Mendorong lahirnya ide-ide segar melalui diskusi berbasis data</span>
                            </div>
                            <div class="mission-item">
                                <span class="mission-icon">•</span>
                                <span>Menumbuhkan budaya berpikir kritis dan toleransi</span>
                            </div>
                            <div class="mission-item">
                                <span class="mission-icon">•</span>
                                <span>Memfasilitasi kolaborasi lintas jurusan dan minat</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rules -->
            <div>
                <div class="section-title">
                    <span>📜</span>
                    Aturan Komunitas Singkat
                </div>
                <div class="rules-grid">
                    <div class="rule-item">
                        <span class="rule-icon">✓</span>
                        <span>Gunakan bahasa yang sopan dan santun dalam berdiskusi</span>
                    </div>
                    <div class="rule-item warning">
                        <span class="rule-icon">🚫</span>
                        <span>Dilarang menyebarkan hoaks, SARA, atau konten tidak pantas</span>
                    </div>
                    <div class="rule-item">
                        <span class="rule-icon">💬</span>
                        <span>Perdebatkan ide, bukan serang pribadi (no ad hominem)</span>
                    </div>
                    <div class="rule-item warning">
                        <span class="rule-icon">🚫</span>
                        <span>Tidak diperbolehkan promosi atau spam tanpa izin</span>
                    </div>
                    <div class="rule-item">
                        <span class="rule-icon">👤</span>
                        <span>Setiap pengguna bertanggung jawab atas kontennya</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div style="margin-bottom: 20px;">
                <strong>INNOFORUM - Platform Diskusi Akademik</strong>
            </div>
            <div style="color: #6b7280; margin-bottom: 15px;">
                Email ini dikirim secara otomatis. Mohon tidak membalas email ini.
            </div>
            <div style="font-size: 11px; color: #6b7280;">
                © 2024 INNOFORUM. All rights reserved.<br>
                STTI NIIT I-TECH | Teknik Informatika
            </div>
        </div>
    </div>
</body>
</html>
