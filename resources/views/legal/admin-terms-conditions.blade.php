@extends('layouts.admin.admin')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold text-gradient text-primary mb-2">Syarat & Ketentuan</h1>
            <p class="text-muted mb-0">Administrator - Kelola syarat dan ketentuan platform</p>
        </div>
        <div class="text-end">
            <div class="badge bg-warning text-dark px-3 py-2 rounded-pill">
                <i class="fas fa-file-contract me-2"></i>Admin View
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Meta Information -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="row text-center">
                        <div class="col-md-3 mb-3">
                            <div class="border-end">
                                <h6 class="fw-semibold text-muted mb-1">Versi</h6>
                                <p class="fw-bold text-primary mb-0">{{ $data['footer']['version'] ?? '1.0' }}</p>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="border-end">
                                <h6 class="fw-semibold text-muted mb-1">Terakhir Diperbarui</h6>
                                <p class="fw-bold text-success mb-0">{{ $data['lastUpdated'] }}</p>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="border-end">
                                <h6 class="fw-semibold text-muted mb-1">Status</h6>
                                <span class="badge bg-success">Berlaku</span>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <h6 class="fw-semibold text-muted mb-1">Jenis Dokumen</h6>
                            <p class="fw-bold text-info mb-0">Syarat Layanan</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card border-0 shadow-sm mb-5">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fw-semibold mb-1">Administrator Actions</h6>
                            <p class="text-muted mb-0 small">Kelola dan perbarui dokumen legal</p>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-arrow-left me-1"></i>Kembali
                            </a>
                            <a href="{{ route('admin.privacy.policy') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-user-shield me-1"></i>Lihat Privacy Policy
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Important Notice -->
            <div class="alert alert-warning alert-dismissible fade show mb-5" role="alert">
                <div class="d-flex align-items-start">
                    <i class="fas fa-exclamation-triangle me-3 mt-1 fs-5"></i>
                    <div>
                        <h6 class="fw-semibold mb-2">Penting untuk Dibaca</h6>
                        <p class="mb-0">Dengan mengakses atau menggunakan platform INNOFORUM, pengguna menyetujui untuk terikat oleh syarat dan ketentuan yang diatur dalam dokumen ini.</p>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 p-lg-5">
                    <!-- Introduction -->
                    <div class="text-center mb-5">
                        <h2 class="h4 fw-bold text-primary mb-3">Syarat dan Ketentuan Penggunaan</h2>
                        <p class="text-muted mb-0">Aturan dan persyaratan yang mengatur penggunaan platform INNOFORUM</p>
                    </div>

                    <!-- Quick Navigation -->
                    <div class="card bg-light border-0 mb-5">
                        <div class="card-body">
                            <h5 class="fw-semibold mb-3">
                                <i class="fas fa-bookmark me-2 text-primary"></i>Navigasi Cepat
                            </h5>
                            <div class="row">
                                @foreach($data['content'] as $index => $item)
                                <div class="col-md-6 mb-2">
                                    <a href="#section-{{ $index + 1 }}" class="text-decoration-none text-dark d-flex align-items-center">
                                        <i class="fas fa-arrow-right text-primary me-2 small"></i>
                                        <span>{{ $item['section'] }}</span>
                                    </a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Legal Content -->
                    <div class="legal-content">
                        @foreach($data['content'] as $index => $item)
                        <div class="legal-section mb-5" id="section-{{ $index + 1 }}">
                            <div class="d-flex align-items-start mb-4">
                                <div class="avatar avatar-sm bg-warning bg-opacity-10 rounded-circle p-2 me-3 mt-1">
                                    <span class="text-warning fw-bold">{{ $index + 1 }}</span>
                                </div>
                                <div class="flex-grow-1">
                                    <h3 class="h5 fw-bold text-dark mb-3">{{ $item['section'] }}</h3>

                                    @if(isset($item['subsections']))
                                        @foreach($item['subsections'] as $subsection)
                                            <div class="subsection mb-4">
                                                <h5 class="fw-semibold text-dark mb-2">{{ $subsection['title'] }}</h5>
                                                <p class="text-muted mb-0" style="line-height: 1.7;">{{ $subsection['content'] }}</p>
                                            </div>
                                        @endforeach
                                    @else
                                        <p class="text-muted mb-0" style="line-height: 1.7;">{{ $item['content'] }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if(!$loop->last)
                        <div class="border-bottom mb-5 opacity-25"></div>
                        @endif
                        @endforeach
                    </div>

                    <!-- Acceptance Section -->
                    <div class="card border-warning mt-5">
                        <div class="card-header bg-warning bg-opacity-10 border-warning">
                            <h5 class="fw-semibold mb-0 text-warning">
                                <i class="fas fa-check-circle me-2"></i>Persetujuan Pengguna
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-3">Dengan melanjutkan penggunaan platform INNOFORUM, pengguna mengakui bahwa:</p>
                            <ul class="mb-0">
                                <li>Telah membaca dan memahami Syarat & Ketentuan ini</li>
                                <li>Setuju untuk terikat oleh semua ketentuan yang diatur</li>
                                <li>Memahami konsekuensi dari pelanggaran ketentuan</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Admin Notes -->
                    <div class="alert alert-info mt-4">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-info-circle me-3 mt-1 fs-5 text-info"></i>
                            <div>
                                <h6 class="fw-semibold mb-2">Informasi Administrator</h6>
                                <p class="mb-0">Dokumen ini mengikat secara hukum. Pastikan untuk memperbarui konten sesuai dengan perubahan kebijakan platform. Untuk modifikasi, edit di <code>LegalController.php</code>.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Meta -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-4 text-center mb-3 mb-md-0">
                            <h6 class="fw-semibold mb-1">Dokumen Resmi</h6>
                            <span class="badge bg-primary">Syarat & Ketentuan</span>
                        </div>
                        <div class="col-md-4 text-center mb-3 mb-md-0">
                            <h6 class="fw-semibold mb-1">Dibuat oleh</h6>
                            <p class="text-muted mb-0 small">{{ $data['footer']['authors'] }}</p>
                        </div>
                        <div class="col-md-4 text-center">
                            <h6 class="fw-semibold mb-1">Platform</h6>
                            <p class="text-muted mb-0 small">{{ $data['footer']['institution'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .legal-content {
        line-height: 1.8;
    }

    .legal-section {
        scroll-margin-top: 100px;
    }

    .subsection {
        padding-left: 1.5rem;
        border-left: 3px solid #fd7e14;
    }

    .avatar {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .card {
        border-radius: 12px;
    }

    @media (max-width: 768px) {
        .border-end {
            border-right: none !important;
            border-bottom: 1px solid #dee2e6 !important;
            padding-bottom: 1rem;
            margin-bottom: 1rem;
        }
    }
</style>
@endsection
