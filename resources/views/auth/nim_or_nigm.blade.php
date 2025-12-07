<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>innoforum - Validasi NIM/NIDN</title>
    <!-- Hubungkan ke file CSS -->
    <link rel="stylesheet" href="/css/nim_or_nigm.css">
    <style>
        /* Tombol Bantuan */
        .help-button {
            position: fixed;
            bottom: 20px;
            left: 20px;
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 25px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            z-index: 1000;
        }

        .help-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.6);
            background: linear-gradient(135deg, #1d4ed8, #1e40af);
        }

        .help-button:active {
            transform: translateY(0);
        }

        /* Modal Bantuan */
        .help-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 2000;
            backdrop-filter: blur(5px);
        }

        .modal-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            max-width: 500px;
            width: 90%;
            animation: modalAppear 0.3s ease-out;
        }

        @keyframes modalAppear {
            from {
                opacity: 0;
                transform: translate(-50%, -40%);
            }

            to {
                opacity: 1;
                transform: translate(-50%, -50%);
            }
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e5e7eb;
        }

        .modal-title {
            font-size: 24px;
            font-weight: 700;
            color: #1f2937;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .close-modal {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #6b7280;
            transition: color 0.3s ease;
        }

        .close-modal:hover {
            color: #374151;
        }

        .help-content {
            color: #4b5563;
            line-height: 1.6;
        }

        .help-section {
            margin-bottom: 20px;
        }

        .help-section h3 {
            color: #3b82f6;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .help-section p {
            margin: 0;
            font-size: 14px;
        }

        .help-list {
            list-style: none;
            padding: 0;
            margin: 10px 0;
        }

        .help-list li {
            padding: 5px 0;
            display: flex;
            align-items: flex-start;
            gap: 8px;
        }

        .help-list li:before {
            content: "•";
            color: #3b82f6;
            font-weight: bold;
        }

        .contact-support {
            background: #f0f9ff;
            padding: 15px;
            border-radius: 10px;
            margin-top: 20px;
            border-left: 4px solid #3b82f6;
        }

        .contact-support a {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 600;
        }

        .contact-support a:hover {
            text-decoration: underline;
        }

        /* Form Controls */
        .form-control,
        .form-select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s ease;
            background-color: white;
            box-sizing: border-box;
        }

        .form-control:focus,
        .form-select:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .form-control::placeholder {
            color: #9ca3af;
        }

        .form-section {
            margin-bottom: 20px;
        }

        .form-section label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #374151;
            font-size: 14px;
        }

        /* Tombol Form */
        .btn-primary {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 10px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.6);
            background: linear-gradient(135deg, #1d4ed8, #1e40af);
        }

        .btn-secondary {
            background: #f3f4f6;
            color: #374151;
            border: 1px solid #d1d5db;
            padding: 12px 24px;
            border-radius: 10px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: #e5e7eb;
        }

        /* Layout tombol */
        .form-actions {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            margin-top: 20px;
        }

        /* Feedback messages */
        .alert-success {
            background: #ecfdf5;
            border-left: 4px solid #10b981;
            padding: 12px 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            color: #065f46;
        }

        .alert-error {
            background: #fff5f5;
            border-left: 4px solid #f43f5e;
            padding: 12px 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            color: #7f1d1d;
        }

        /* Textarea khusus */
        textarea.form-control {
            resize: vertical;
            min-height: 120px;
            font-family: inherit;
        }

        /* Select khusus */
        .form-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236b7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 16px;
            padding-right: 40px;
        }
    </style>
</head>

<body>
    {{-- Tampilkan popup jika admin sudah menonaktifkan akun --}}
    @if(session('account_disabled'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                alert('Akun Anda telah dinonaktifkan oleh admin.');
            });
        </script>
    @endif
    <div id="logo">
        <h1><i>innoforum</i></h1>
        <p class="subtitle">Forum Diskusi Teknologi, Inspirasi Tiada Henti</p>
    </div>

    <section class="tech-login">
        <form action="{{ route('validate.nim') }}" method="POST">
            @csrf
            <div id="fade-box">
                <p class="welcome-text">Selamat Datang</p>
                <input type="text" name="nim_or_nigm" id="nim_or_nigm" placeholder="NIM/NIDN" required
                    class="@error('nim_or_nigm') invalid @enderror">
                @error('nim_or_nigm')
                    <p class="error-text">{{ $message }}</p>
                @enderror
                <button>MASUK</button>
            </div>
        </form>
    </section>

    <!-- Tombol Bantuan -->
    <button class="help-button" onclick="openHelpModal()">
        <span>❓</span>
        Bantuan
    </button>

    <!-- Modal Bantuan -->
    <div id="helpModal" class="help-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">
                    <span>💁</span>
                    Pusat Bantuan
                </h2>
                <button class="close-modal" onclick="closeHelpModal()">&times;</button>
            </div>
            <div class="help-content">
                <div class="help-section">
                    <h3><span>🎓</span> Untuk Mahasiswa</h3>
                    <p>Masukkan <strong>NIM (Nomor Induk Mahasiswa)</strong> Anda yang terdaftar di kampus.</p>
                </div>

                <div class="help-section">
                    <h3><span>👨‍🏫</span> Untuk Dosen</h3>
                    <p>Masukkan <strong>NIDN (Nomor Induk Dosen Nasional)</strong> Anda yang valid.</p>
                </div>

                <div class="help-section">
                    <h3><span>🔐</span> Informasi Penting</h3>
                    <ul class="help-list">
                        <li>Pastikan NIM/NIDN yang dimasukkan sudah benar</li>
                        <li>Data akan diverifikasi dengan database kampus</li>
                        <li>Jika belum terdaftar, hubungi admin untuk pendaftaran</li>
                        <li>Untuk masalah teknis, hubungi support</li>
                    </ul>
                </div>

                @include('partials.guest_contact_modal')
            </div>
        </div>
    </div>

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

    <!-- JavaScript untuk Modal -->
    <script>
        function openHelpModal() {
            document.getElementById('helpModal').style.display = 'block';
        }

        function closeHelpModal() {
            document.getElementById('helpModal').style.display = 'none';
        }

        // Tutup modal ketika klik di luar konten
        window.onclick = function(event) {
            const modal = document.getElementById('helpModal');
            if (event.target === modal) {
                closeHelpModal();
            }
        }

        // Tutup modal dengan tombol ESC
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeHelpModal();
            }
        });
    </script>

    <!-- Hubungkan ke file JS -->
    <script src="/js/nim_or_nigm.js"></script>
</body>

</html>
