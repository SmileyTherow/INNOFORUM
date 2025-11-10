@extends('layouts.admin.admin')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold text-gradient text-primary mb-2">Kebijakan Privasi</h1>
            <p class="text-muted mb-0">Administrator - Kelola dan tinjau kebijakan privasi platform</p>
        </div>
        <div class="text-end">
            <div class="badge bg-warning text-dark px-3 py-2 rounded-pill">
                <i class="fas fa-user-shield me-2"></i>Admin View
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
                                <span class="badge bg-success">Aktif</span>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <h6 class="fw-semibold text-muted mb-1">Dokumen</h6>
                            <p class="fw-bold text-info mb-0">Kebijakan Privasi</p>
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
                            <a href="{{ route('admin.terms.conditions') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-file-contract me-1"></i>Lihat T&C
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 p-lg-5">
                    <!-- Introduction -->
                    <div class="text-center mb-5">
                        <h2 class="h4 fw-bold text-primary mb-3">Kebijakan Privasi INNOFORUM</h2>
                        <p class="text-muted mb-0">Dokumen ini menjelaskan komitmen kami dalam melindungi privasi dan data pribadi pengguna platform INNOFORUM.</p>
                    </div>

                    <!-- Table of Contents -->
                    <div class="card bg-light border-0 mb-5">
                        <div class="card-body">
                            <h5 class="fw-semibold mb-3">
                                <i class="fas fa-list-ul me-2 text-primary"></i>Daftar Isi
                            </h5>
                            <div class="row">
                                @foreach($data['content'] as $index => $item)
                                <div class="col-md-6 mb-2">
                                    <a href="#section-{{ $index + 1 }}" class="text-decoration-none text-dark">
                                        <i class="fas fa-chevron-right text-primary me-2 small"></i>
                                        {{ $item['section'] }}
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
                                <div class="avatar avatar-sm bg-primary bg-opacity-10 rounded-circle p-2 me-3 mt-1">
                                    <span class="text-primary fw-bold">{{ $index + 1 }}</span>
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
                        <div class="border-bottom mb-5"></div>
                        @endif
                        @endforeach
                    </div>

                    <!-- Admin Notes -->
                    <div class="alert alert-warning mt-5">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-exclamation-circle me-3 mt-1 fs-5 text-warning"></i>
                            <div>
                                <h6 class="fw-semibold mb-2">Catatan Administrator</h6>
                                <p class="mb-2">Dokumen ini adalah versi aktif dari Kebijakan Privasi. Untuk mengubah konten, silakan hubungi tim pengembang atau edit langsung di controller.</p>
                                <p class="mb-0"><strong>Lokasi Controller:</strong> <code>app/Http/Controllers/LegalController.php</code></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Meta -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-body text-center p-4">
                    <div class="row align-items-center">
                        <div class="col-md-6 text-md-start mb-3 mb-md-0">
                            <h6 class="fw-semibold mb-1">Dibuat oleh</h6>
                            <p class="text-muted mb-0">{{ $data['footer']['authors'] }}</p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <h6 class="fw-semibold mb-1">Platform</h6>
                            <p class="text-muted mb-0">{{ $data['footer']['institution'] }}</p>
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
        border-left: 3px solid #e9ecef;
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
