@extends('layouts.admin.admin')

@section('content')
<div class="container-fluid">
    <!-- Header dengan breadcrumb -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.messages.index') }}" class="text-decoration-none">Pesan Masuk</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail Pesan</li>
                </ol>
            </nav>
            <h2 class="h4 fw-bold text-dark mb-0">Detail Pesan</h2>
        </div>
    </div>

    <!-- Pesan Utama -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-light py-3">
            <div class="d-flex justify-content-between align-items-start">
                <div class="flex-grow-1">
                    <h4 class="fw-bold text-primary mb-1">{{ $message->title }}</h4>
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <span class="badge bg-primary rounded-pill">
                            <i class="fas fa-user me-1"></i>{{ $message->name }}
                        </span>
                        <span class="badge bg-secondary rounded-pill">
                            <i class="fas fa-envelope me-1"></i>{{ $message->email }}
                        </span>
                        <span class="badge bg-light text-dark rounded-pill">
                            <i class="fas fa-clock me-1"></i>{{ $message->created_at->format('d M Y, H:i') }}
                        </span>
                    </div>
                </div>
                <div class="ms-3">
                    @if($message->status == 'terbaca')
                        <span class="badge bg-success rounded-pill px-3 py-2">
                            <i class="fas fa-check-circle me-1"></i>Terbaca
                        </span>
                    @else
                        <span class="badge bg-warning rounded-pill px-3 py-2">
                            <i class="fas fa-envelope me-1"></i>Belum Dibaca
                        </span>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="message-content bg-light rounded p-4">
                <p class="mb-0" style="line-height: 1.6; white-space: pre-wrap;">{{ $message->body }}</p>
            </div>
        </div>
    </div>

    <!-- Riwayat Balasan -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-light py-3">
            <h5 class="fw-bold mb-0">
                <i class="fas fa-history me-2 text-primary"></i>
                Riwayat Balasan
                <span class="badge bg-primary ms-2">{{ $message->replies->count() }}</span>
            </h5>
        </div>
        <div class="card-body">
            @if($message->replies->count() > 0)
                <div class="timeline">
                    @foreach($message->replies as $reply)
                        <div class="timeline-item mb-4">
                            <div class="timeline-marker">
                                <i class="fas fa-reply text-primary"></i>
                            </div>
                            <div class="timeline-content card border-0 shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div>
                                                <h6 class="fw-bold mb-0">{{ $reply->author ? $reply->author->name : 'System/Admin' }}</h6>
                                                <small class="text-muted">{{ $reply->created_at->format('d M Y, H:i') }}</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="reply-content bg-light rounded p-3">
                                        <p class="mb-0" style="line-height: 1.6; white-space: pre-wrap;">{{ $reply->body }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <p class="text-muted mb-0">Belum ada balasan untuk pesan ini.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Form Balasan -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-light py-3">
            <h5 class="fw-bold mb-0">
                <i class="fas fa-reply me-2 text-primary"></i>
                Balas Pesan
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.messages.reply', $message->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="replyBody" class="form-label fw-semibold">Isi Balasan</label>
                    <textarea name="body" id="replyBody" rows="6" class="form-control"
                              placeholder="Ketik balasan Anda di sini..." required></textarea>
                    <div class="form-text">
                        Balasan akan dikirim via email dan notifikasi kepada pengirim pesan.
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        Pastikan balasan sudah sesuai sebelum mengirim
                    </small>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-paper-plane me-2"></i>
                        Kirim Balasan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .breadcrumb {
        background: transparent;
        padding: 0;
    }

    .breadcrumb-item a {
        color: #6c757d;
        transition: color 0.2s;
    }

    .breadcrumb-item a:hover {
        color: #0d6efd;
    }

    .message-content, .reply-content {
        background-color: #f8f9fa;
        border-left: 4px solid #0d6efd;
    }

    .timeline {
        position: relative;
        padding-left: 30px;
    }

    .timeline-item {
        position: relative;
    }

    .timeline-marker {
        position: absolute;
        left: -30px;
        top: 15px;
        width: 20px;
        height: 20px;
        background: #0d6efd;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.7rem;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: -21px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #dee2e6;
    }

    .avatar {
        font-size: 0.9rem;
    }

    .card {
        border-radius: 12px;
    }

    .form-control {
        border-radius: 8px;
        border: 1px solid #dee2e6;
        transition: all 0.2s;
    }

    .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.1);
    }

    .btn {
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.2s;
    }

    .badge.rounded-pill {
        font-size: 0.75rem;
    }
</style>
@endsection
