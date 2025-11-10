@extends('layouts.admin.admin')

@section('content')
<div class="container-fluid mt-4">
    <!-- Header dengan tombol kembali -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0 font-weight-bold text-dark">
            <i class="fas fa-file-alt text-primary mr-2"></i>Detail Pertanyaan
        </h2>
        <a href="{{ route('admin.threads.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left mr-2"></i>Kembali
        </a>
    </div>

    <!-- Card Utama -->
    <div class="card shadow-sm border-0">
        <!-- Header Card dengan Judul -->
        <div class="card-header bg-white border-bottom py-4">
            <h3 class="mb-0 text-dark font-weight-bold">{{ $thread->title }}</h3>
        </div>

        <!-- Body Card -->
        <div class="card-body p-4">
            <!-- Info Row -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="info-box p-3 bg-light rounded">
                        <label class="text-muted small mb-2 d-block">
                            <i class="fas fa-user text-primary mr-1"></i>USER
                        </label>
                        <h6 class="mb-0 font-weight-bold">{{ $thread->user->name ?? '-' }}</h6>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box p-3 bg-light rounded">
                        <label class="text-muted small mb-2 d-block">
                            <i class="fas fa-folder text-primary mr-1"></i>KATEGORI
                        </label>
                        <h6 class="mb-0 font-weight-bold">{{ $thread->category->name ?? '-' }}</h6>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box p-3 bg-light rounded">
                        <label class="text-muted small mb-2 d-block">
                            <i class="fas fa-info-circle text-primary mr-1"></i>STATUS
                        </label>
                        <h6 class="mb-0 font-weight-bold">{{ ucfirst($thread->status) }}</h6>
                    </div>
                </div>
            </div>

            <!-- Divider -->
            <hr class="my-4">

            <!-- Isi Thread -->
            <div class="thread-content-section">
                <h5 class="mb-3 font-weight-bold text-dark">
                    <i class="fas fa-align-left text-primary mr-2"></i>Isi Thread:
                </h5>
                <div class="thread-body-content p-4 border rounded bg-white">
                    {{ $thread->body }}
                </div>
            </div>
        </div>

        <!-- Footer Card -->
        <div class="card-footer bg-light py-3">
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    <i class="far fa-clock mr-1"></i>
                    Dibuat: {{ $thread->created_at->format('d F Y, H:i') }} WIB
                </small>
                <a href="{{ route('admin.threads.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-1"></i>Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border-radius: 10px;
    overflow: hidden;
}

.info-box {
    transition: all 0.3s ease;
}

.info-box:hover {
    background-color: #e9ecef !important;
    transform: translateY(-2px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.info-box label {
    text-transform: uppercase;
    font-weight: 600;
    letter-spacing: 0.5px;
    font-size: 0.75rem;
}

.thread-body-content {
    line-height: 1.8;
    font-size: 1rem;
    min-height: 200px;
    white-space: pre-wrap;
    word-wrap: break-word;
    background-color: #f8f9fa !important;
}

.card-header {
    border-bottom: 3px solid #007bff;
}

.btn-outline-secondary:hover {
    transform: translateY(-2px);
    transition: all 0.3s ease;
}

.btn-secondary:hover {
    transform: translateY(-2px);
    transition: all 0.3s ease;
}

hr {
    border-top: 2px solid #e9ecef;
}
</style>
@endsection
