@extends('layouts.admin.admin')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold text-gradient text-primary mb-2">Pengaturan Profil</h1>
            <p class="text-muted mb-0">Kelola informasi profil dan preferensi akun admin Anda</p>
        </div>
        <div class="text-end">
            <div class="badge bg-light text-dark px-3 py-2 rounded-pill">
                <i class="fas fa-user-shield me-2"></i>Admin
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-10">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent py-4 border-0">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-xl bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                            <i class="fas fa-cogs text-primary fs-2"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold text-dark mb-1">Pengaturan Profil Admin</h4>
                            <p class="text-muted mb-0">Perbarui informasi profil dan foto Anda</p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Terdapat kesalahan dalam pengisian form. Silakan periksa kembali.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" id="profileForm">
                        @csrf
                        @method('PUT')

                        <!-- Photo Upload Section -->
                        <div class="row mb-5">
                            <div class="col-md-8 mx-auto text-center">
                                <div class="position-relative d-inline-block">
                                    @if($admin->photo)
                                        <img src="{{ asset('storage/photo/' . $admin->photo) }}"
                                            class="img-thumbnail rounded-circle mb-3 profile-photo"
                                            style="width: 140px; height: 140px; object-fit: cover; border: 4px solid #e9ecef;"
                                            id="profileImage"
                                            alt="Profile Photo">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($admin->name) }}&size=140&background=4e73df&color=ffffff&bold=true"
                                            class="img-thumbnail rounded-circle mb-3 profile-photo"
                                            style="width: 140px; height: 140px; object-fit: cover; border: 4px solid #e9ecef;"
                                            id="profileImage"
                                            alt="Profile Photo">
                                    @endif
                                    <div class="position-absolute bottom-0 end-0">
                                        <label for="photoUpload" class="btn btn-primary btn-sm rounded-circle p-2 cursor-pointer" title="Ubah Foto">
                                            <i class="fas fa-camera"></i>
                                        </label>
                                        <input type="file" id="photoUpload" name="photo" accept="image/*" class="d-none" onchange="previewImage(this)">
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <small class="text-muted d-block">Format yang didukung: JPG, JPEG, PNG</small>
                                    <small class="text-muted">Ukuran maksimal: 2MB</small>
                                </div>
                                @error('photo')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Personal Information -->
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                           name="name" value="{{ old('name', $admin->name) }}"
                                           placeholder="Masukkan nama lengkap" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label fw-semibold">Alamat Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                           name="email" value="{{ old('email', $admin->email) }}"
                                           placeholder="Masukkan alamat email" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label fw-semibold">Bio / Deskripsi</label>
                                    <textarea class="form-control @error('bio') is-invalid @enderror"
                                              name="bio" rows="4"
                                              placeholder="Tuliskan deskripsi singkat tentang diri Anda...">{{ old('bio', $admin->bio) }}</textarea>
                                    <div class="form-text">Deskripsi singkat yang akan ditampilkan di profil Anda.</div>
                                    @error('bio')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="row mt-5 pt-4 border-top">
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Terakhir diperbarui: {{ $admin->updated_at->diffForHumans() }}
                                        </small>
                                    </div>
                                    <div class="d-flex gap-3">
                                        <a href="{{ route('admin.reset-password.show') }}" class="btn btn-outline-secondary px-4">
                                            <i class="fas fa-key me-2"></i>Reset Password
                                        </a>
                                        <button type="submit" class="btn btn-primary px-4" id="submitBtn">
                                            <i class="fas fa-save me-2"></i>Simpan Perubahan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Additional Info Card -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-lg bg-success bg-opacity-10 rounded-circle p-3 me-3">
                                    <i class="fas fa-user-clock text-success"></i>
                                </div>
                                <div>
                                    <h6 class="fw-semibold mb-1">Bergabung Sejak</h6>
                                    <p class="text-muted mb-0">{{ $admin->created_at->translatedFormat('d F Y') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-lg bg-info bg-opacity-10 rounded-circle p-3 me-3">
                                    <i class="fas fa-shield-alt text-info"></i>
                                </div>
                                <div>
                                    <h6 class="fw-semibold mb-1">Role Akun</h6>
                                    <p class="text-muted mb-0">Administrator</p>
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
    function previewImage(input) {
        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profileImage').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    }

    // Form submission handling
    document.getElementById('profileForm').addEventListener('submit', function(e) {
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
    });

    // File size validation
    document.getElementById('photoUpload').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const fileSize = file.size / 1024 / 1024; // MB
            if (fileSize > 2) {
                alert('Ukuran file melebihi 2MB. Silakan pilih file yang lebih kecil.');
                e.target.value = '';
                return false;
            }

            const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            if (!validTypes.includes(file.type)) {
                alert('Format file tidak didukung. Silakan pilih file JPG, JPEG, atau PNG.');
                e.target.value = '';
                return false;
            }
        }
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

    .profile-photo {
        transition: all 0.3s ease;
    }

    .profile-photo:hover {
        transform: scale(1.05);
    }

    .cursor-pointer {
        cursor: pointer;
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

    @media (max-width: 768px) {
        .d-flex.justify-content-between.align-items-center {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }

        .d-flex.gap-3 {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection
