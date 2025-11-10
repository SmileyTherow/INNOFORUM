@extends('layouts.admin.admin')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold text-gradient text-primary mb-2">Reset Password</h1>
            <p class="text-muted mb-0">Perbarui kata sandi akun admin Anda untuk keamanan yang lebih baik</p>
        </div>
        <div class="text-end">
            <div class="badge bg-light text-dark px-3 py-2 rounded-pill">
                <i class="fas fa-shield-alt me-2"></i>Keamanan Akun
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent py-4 border-0">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-xl bg-warning bg-opacity-10 rounded-circle p-3 me-3">
                            <i class="fas fa-key text-warning fs-2"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold text-dark mb-1">Ganti Password</h4>
                            <p class="text-muted mb-0">Pastikan password baru Anda kuat dan aman</p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                            <i class="fas fa-check-circle me-2 fs-5"></i>
                            <div class="flex-grow-1">
                                <strong>Berhasil!</strong> {{ session('success') }}
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-triangle me-2 fs-5"></i>
                                <div>
                                    <strong>Terjadi Kesalahan!</strong>
                                    <ul class="mb-0 mt-1">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Password Strength Indicator -->
                    <div class="password-strength mb-4" style="display: none;">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <small class="text-muted">Kekuatan Password:</small>
                            <small class="strength-text">-</small>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                        </div>
                        <div class="password-requirements mt-3">
                            <small class="text-muted d-block mb-2">Password harus memenuhi:</small>
                            <div class="row">
                                <div class="col-md-6">
                                    <small class="requirement-item" data-requirement="length">
                                        <i class="fas fa-times text-danger me-1"></i> Minimal 8 karakter
                                    </small>
                                </div>
                                <div class="col-md-6">
                                    <small class="requirement-item" data-requirement="uppercase">
                                        <i class="fas fa-times text-danger me-1"></i> Huruf besar
                                    </small>
                                </div>
                                <div class="col-md-6">
                                    <small class="requirement-item" data-requirement="lowercase">
                                        <i class="fas fa-times text-danger me-1"></i> Huruf kecil
                                    </small>
                                </div>
                                <div class="col-md-6">
                                    <small class="requirement-item" data-requirement="number">
                                        <i class="fas fa-times text-danger me-1"></i> Angka
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('admin.reset-password.update') }}" id="passwordForm">
                        @csrf
                        @method('PUT')

                        <!-- Current Password -->
                        <div class="form-group mb-4">
                            <label class="form-label fw-semibold">Password Saat Ini <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                       name="current_password" id="current_password"
                                       placeholder="Masukkan password saat ini" required>
                                <button type="button" class="btn btn-outline-secondary toggle-password" data-target="current_password">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- New Password -->
                        <div class="form-group mb-4">
                            <label class="form-label fw-semibold">Password Baru <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" class="form-control @error('new_password') is-invalid @enderror"
                                       name="new_password" id="new_password"
                                       placeholder="Masukkan password baru" required>
                                <button type="button" class="btn btn-outline-secondary toggle-password" data-target="new_password">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @error('new_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Confirm New Password -->
                        <div class="form-group mb-4">
                            <label class="form-label fw-semibold">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" class="form-control @error('new_password_confirmation') is-invalid @enderror"
                                       name="new_password_confirmation" id="new_password_confirmation"
                                       placeholder="Konfirmasi password baru" required>
                                <button type="button" class="btn btn-outline-secondary toggle-password" data-target="new_password_confirmation">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @error('new_password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Pastikan password baru dan konfirmasinya sama
                            </div>
                        </div>

                        <!-- Security Tips -->
                        <div class="alert alert-info">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-lightbulb me-2 mt-1"></i>
                                <div>
                                    <strong>Tips Keamanan Password:</strong>
                                    <ul class="mb-0 mt-1 small">
                                        <li>Gunakan kombinasi huruf besar, kecil, angka, dan simbol</li>
                                        <li>Minimal 8 karakter</li>
                                        <li>Hindari menggunakan informasi pribadi yang mudah ditebak</li>
                                        <li>Jangan gunakan password yang sama untuk multiple akun</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="row mt-5 pt-4 border-top">
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="{{ route('admin.settings.show') }}" class="btn btn-outline-secondary px-4">
                                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Profil
                                    </a>
                                    <button type="submit" class="btn btn-primary px-4" id="submitBtn">
                                        <i class="fas fa-save me-2"></i>Ganti Password
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Security Info Card -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-lg bg-success bg-opacity-10 rounded-circle p-3 me-3">
                                    <i class="fas fa-history text-success"></i>
                                </div>
                                <div>
                                    <h6 class="fw-semibold mb-1">Terakhir Diubah</h6>
                                    <p class="text-muted mb-0">
                                        @if(auth()->user()->password_changed_at)
                                            {{ auth()->user()->password_changed_at->diffForHumans() }}
                                        @else
                                            Tidak tersedia
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-lg bg-info bg-opacity-10 rounded-circle p-3 me-3">
                                    <i class="fas fa-user-lock text-info"></i>
                                </div>
                                <div>
                                    <h6 class="fw-semibold mb-1">Status Keamanan</h6>
                                    <p class="text-muted mb-0">Aktif & Terlindungi</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle password visibility
        const toggleButtons = document.querySelectorAll('.toggle-password');
        toggleButtons.forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const passwordInput = document.getElementById(targetId);
                const icon = this.querySelector('i');

                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    icon.className = 'fas fa-eye-slash';
                } else {
                    passwordInput.type = 'password';
                    icon.className = 'fas fa-eye';
                }
            });
        });

        // Password strength checker
        const newPasswordInput = document.getElementById('new_password');
        const strengthIndicator = document.querySelector('.password-strength');
        const progressBar = document.querySelector('.progress-bar');
        const strengthText = document.querySelector('.strength-text');
        const requirementItems = document.querySelectorAll('.requirement-item');

        newPasswordInput.addEventListener('input', function() {
            const password = this.value;

            if (password.length > 0) {
                strengthIndicator.style.display = 'block';
                checkPasswordStrength(password);
            } else {
                strengthIndicator.style.display = 'none';
            }
        });

        function checkPasswordStrength(password) {
            let strength = 0;
            const requirements = {
                length: password.length >= 8,
                uppercase: /[A-Z]/.test(password),
                lowercase: /[a-z]/.test(password),
                number: /[0-9]/.test(password)
            };

            // Update requirement indicators
            requirementItems.forEach(item => {
                const requirement = item.getAttribute('data-requirement');
                const icon = item.querySelector('i');
                if (requirements[requirement]) {
                    icon.className = 'fas fa-check text-success me-1';
                } else {
                    icon.className = 'fas fa-times text-danger me-1';
                }
            });

            // Calculate strength score
            strength += requirements.length ? 25 : 0;
            strength += requirements.uppercase ? 25 : 0;
            strength += requirements.lowercase ? 25 : 0;
            strength += requirements.number ? 25 : 0;

            // Update progress bar and text
            progressBar.style.width = strength + '%';

            if (strength < 25) {
                progressBar.className = 'progress-bar bg-danger';
                strengthText.textContent = 'Sangat Lemah';
                strengthText.className = 'strength-text text-danger';
            } else if (strength < 50) {
                progressBar.className = 'progress-bar bg-warning';
                strengthText.textContent = 'Lemah';
                strengthText.className = 'strength-text text-warning';
            } else if (strength < 75) {
                progressBar.className = 'progress-bar bg-info';
                strengthText.textContent = 'Cukup';
                strengthText.className = 'strength-text text-info';
            } else {
                progressBar.className = 'progress-bar bg-success';
                strengthText.textContent = 'Kuat';
                strengthText.className = 'strength-text text-success';
            }
        }

        // Form submission handling
        document.getElementById('passwordForm').addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengganti Password...';
        });

        // Confirm password match
        const confirmPasswordInput = document.getElementById('new_password_confirmation');
        confirmPasswordInput.addEventListener('input', function() {
            const newPassword = newPasswordInput.value;
            const confirmPassword = this.value;

            if (confirmPassword && newPassword !== confirmPassword) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });
    });
</script>

<style>
    .card {
        border-radius: 16px;
    }

    .avatar {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .form-control {
        border-radius: 8px;
        border: 1px solid #dee2e6;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.1);
    }

    .btn {
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-1px);
    }

    .text-gradient {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .border-top {
        border-top: 1px solid #e9ecef !important;
    }

    .progress {
        border-radius: 10px;
        background-color: #e9ecef;
    }

    .progress-bar {
        border-radius: 10px;
        transition: width 0.3s ease;
    }

    .requirement-item {
        display: flex;
        align-items: center;
        margin-bottom: 0.25rem;
    }

    .input-group .btn {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }

    @media (max-width: 768px) {
        .d-flex.justify-content-between.align-items-center {
            flex-direction: column;
            gap: 1rem;
        }

        .btn {
            width: 100%;
        }
    }
</style>
@endsection
