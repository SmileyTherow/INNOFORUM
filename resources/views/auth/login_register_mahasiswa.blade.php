<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Registrasi Mahasiswa</title>
    <link rel="stylesheet" href="/css/login_register_mahasiswa.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,600" rel="stylesheet" type="text/css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/paper.js/0.11.3/paper-full.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

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
        max-height: 85vh;
        overflow: hidden;
        display: flex;
        flex-direction: column;
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
        flex-shrink: 0;
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
        overflow-y: auto;
        max-height: calc(85vh - 150px);
        padding-right: 10px;
    }

    .help-content::-webkit-scrollbar {
        width: 6px;
    }

    .help-content::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .help-content::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }

    .help-content::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
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

    .form-select,
    .form-control {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 14px;
        margin-top: 5px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: 600;
        color: #fff;
    }
</style>

<body>
    <div id="back">
        <canvas id="canvas" class="canvas-back"></canvas>
        <div class="backRight"></div>
        <div class="backLeft"></div>
    </div>
    <div id="slideBox">
        <div class="topLayer">
            <div class="left">
                <div class="content">
                    <h2>Registrasi</h2>
                    <form id="form-signup" method="post" action="{{ route('register.process') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-element form-stack">
                            <label for="username-signup" class="form-label">Nama</label>
                            <input id="username-signup" type="text" name="name" required>
                        </div>
                        <div class="form-element form-stack">
                            <label for="email" class="form-label">Email</label>
                            <input id="email" type="email" name="email" required>
                        </div>
                        <div class="form-element form-stack">
                            <label for="gender" class="form-label">Jenis Kelamin</label>
                            <select id="gender" name="gender" class="form-select" required>
                                <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="form-element form-stack">
                            <label for="password-signup" class="form-label">Password</label>
                            <input id="password-signup" type="password" name="password" required>
                        </div>
                        <div class="form-element form-stack">
                            <label for="password-confirmation" class="form-label">Konfirmasi Password</label>
                            <input id="password-confirmation" type="password" name="password_confirmation" required>
                        </div>
                        <div class="form-element form-stack">
                            <label for="prodi" class="form-label">Program Studi</label>
                            <select id="prodi" name="prodi" class="form-select" required>
                                <option value="" disabled selected>Pilih Program Studi</option>
                                <option value="Informatika">Teknik Informatika</option>
                                <option value="Sistem Informasi">Sistem Informasi</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="photo">Foto Profil</label>
                            <input id="photo" type="file" class="form-control" name="photo">
                        </div>
                        <div class="form-element form-submit">
                            <button id="signUp" class="signup" type="submit">Registrasi</button>
                            <button id="goLeft" class="signup off" type="button">Log In</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="right">
                <div class="content">
                    <h2>Login</h2>
                    <form id="form-login" method="post" action="{{ route('login.process') }}">
                        @csrf
                        <div class="form-element form-stack">
                            <label for="username-login" class="form-label">Email</label>
                            <input id="username-login" type="email" name="email" required>
                        </div>
                        <div class="form-element form-stack">
                            <label for="password-login" class="form-label">Password</label>
                            <input id="password-login" type="password" name="password" required>
                            <div class="form-element form-stack" style="margin-top:6px;">
                                <a href="{{ route('password.forgot') }}" class="forgot-link"
                                    style="font-size:0.9rem; color:#2563eb; text-decoration:underline;">
                                    Lupa Password?
                                </a>
                            </div>
                        </div>
                        <div class="form-element form-submit">
                            <button id="logIn" class="login" type="submit">Log In</button>
                            <button id="goRight" class="login off" type="button">Registrasi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
                    Pusat Bantuan Login & Registrasi
                </h2>
                <button class="close-modal" onclick="closeHelpModal()">&times;</button>
            </div>
            <div class="help-content">
                <div class="help-section">
                    <h3><span>📝</span> Proses Registrasi</h3>
                    <p>Untuk mendaftar akun baru, pastikan:</p>
                    <ul class="help-list">
                        <li>Nama lengkap sesuai dengan data kampus</li>
                        <li>Gunakan email aktif yang valid</li>
                        <li>Password minimal 8 karakter dengan kombinasi huruf dan angka</li>
                        <li>Konfirmasi password harus sama dengan password</li>
                        <li>Pilih program studi yang sesuai</li>
                        <li>Foto profil opsional (format JPG/PNG, max 2MB)</li>
                    </ul>
                </div>

                <div class="help-section">
                    <h3><span>🔐</span> Proses Login</h3>
                    <p>Masuk dengan akun yang sudah terdaftar:</p>
                    <ul class="help-list">
                        <li>Gunakan email yang didaftarkan</li>
                        <li>Masukkan password dengan benar</li>
                        <li>Pastikan caps lock tidak aktif</li>
                        <li>Jika lupa password, tekan "tombol lupa password"</li>
                    </ul>
                </div>

                <div class="help-section">
                    <h3><span>⚠️</span> Troubleshooting</h3>
                    <ul class="help-list">
                        <li>Email sudah terdaftar? Gunakan email lain atau login</li>
                        <li>Password tidak match? Perhatikan huruf kapital</li>
                        <li>File foto terlalu besar? Kompres terlebih dahulu</li>
                        <li>Akun tidak bisa login? Verifikasi email dan password</li>
                    </ul>
                </div>

                @include('partials.guest_contact_modal')
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#goLeft").click(function() {
                $("#slideBox").animate({
                    marginLeft: "0"
                });
            });
            $("#goRight").click(function() {
                $("#slideBox").animate({
                    marginLeft: "50%"
                });
            });

            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Coba Lagi'
                });
            @endif

            @if ($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: '{{ $errors->first() }}',
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'OK'
                });
            @endif
        });
    </script>

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

    <script src="/js/login_register_mahasiswa.js"></script>
</body>

</html>
