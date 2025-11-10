@extends('layouts.admin.admin')

@section('content')
<div class="container-fluid px-4 py-5">
    <!-- Header Section -->
    <div class="mb-5">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div class="d-flex align-items-center">
                <div class="bg-primary bg-opacity-10 rounded-3 p-3 me-3">
                    <i class="bi bi-megaphone text-primary fs-2"></i>
                </div>
                <div>
                    <h2 class="mb-1 fw-bold text-dark">Manajemen Pengumuman</h2>
                    <p class="text-muted mb-0">Kelola dan kirim pengumuman ke seluruh pengguna</p>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">
                    <i class="bi bi-collection me-1"></i>
                    {{ $announcements->total() }} Total Pengumuman
                </span>
            </div>
        </div>
    </div>

    <!-- Success Alert -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm mb-4" role="alert">
        <div class="d-flex align-items-center">
            <div class="me-3">
                <i class="bi bi-check-circle-fill fs-4"></i>
            </div>
            <div class="flex-grow-1">
                <h6 class="alert-heading mb-0 fw-semibold">Berhasil!</h6>
                <p class="mb-0">{{ session('success') }}</p>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Form Kirim Pengumuman -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
        <div class="card-header bg-gradient-primary text-white border-0 py-4">
            <div class="d-flex align-items-center">
                <div class="bg-white bg-opacity-20 rounded-3 p-2 me-3">
                    <i class="bi bi-send fs-5"></i>
                </div>
                <div>
                    <h5 class="mb-0 fw-bold">Buat Pengumuman Baru</h5>
                    <small class="opacity-90">Pengumuman akan dikirim ke seluruh pengguna</small>
                </div>
            </div>
        </div>
        <div class="card-body p-4 p-lg-5">
            <form method="POST" action="{{ route('admin.announcements.store') }}" id="announcementForm">
                @csrf

                <!-- Judul Pengumuman -->
                <div class="mb-4">
                    <label for="title" class="form-label text-dark fw-semibold mb-2">
                        Judul Pengumuman
                        <span class="text-danger">*</span>
                    </label>
                    <div class="input-group input-group-lg">
                        <span class="input-group-text bg-light border-end-0 rounded-start-3">
                            <i class="bi bi-chat-square-text text-muted"></i>
                        </span>
                        <input
                            type="text"
                            name="title"
                            id="title"
                            class="form-control border-start-0 ps-0 rounded-end-3 @error('title') is-invalid @enderror"
                            placeholder="Contoh: Pemeliharaan Server - 15 Nov 2025"
                            value="{{ old('title') }}"
                            required>
                        @error('title')
                            <div class="invalid-feedback d-block">
                                <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>
                    <small class="text-muted d-block mt-2">
                        <i class="bi bi-lightbulb me-1"></i>Gunakan judul yang jelas dan menarik perhatian
                    </small>
                </div>

                <!-- Isi Pengumuman -->
                <div class="mb-4">
                    <label for="content" class="form-label text-dark fw-semibold mb-2">
                        Isi Pengumuman
                        <span class="text-danger">*</span>
                    </label>
                    <div class="position-relative">
                        <textarea
                            name="content"
                            id="content"
                            class="form-control rounded-3 @error('content') is-invalid @enderror"
                            rows="5"
                            placeholder="Tulis pengumuman Anda di sini. Jelaskan dengan detail agar pengguna memahami informasi yang disampaikan..."
                            style="resize: vertical;"
                            required>{{ old('content') }}</textarea>
                        <div class="position-absolute bottom-0 end-0 mb-3 me-3">
                            <span class="badge bg-light text-muted border" id="charCount">0 karakter</span>
                        </div>
                        @error('content')
                            <div class="invalid-feedback d-block">
                                <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>
                    <small class="text-muted d-block mt-2">
                        <i class="bi bi-info-circle me-1"></i>Minimum 10 karakter untuk isi pengumuman
                    </small>
                </div>

                <!-- Preview Card -->
                <div class="card bg-light border-0 rounded-3 mb-4 d-none" id="previewCard">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-start mb-3">
                            <div class="me-3">
                                <div class="bg-primary bg-opacity-10 rounded-2 p-2">
                                    <i class="bi bi-eye text-primary"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1 fw-semibold">Preview Pengumuman</h6>
                                <small class="text-muted">Begini tampilan pengumuman untuk pengguna</small>
                            </div>
                        </div>
                        <div class="bg-white rounded-3 p-3 border">
                            <h6 class="fw-bold mb-2" id="previewTitle">Judul akan muncul di sini</h6>
                            <p class="mb-0 text-muted" id="previewContent">Isi pengumuman akan muncul di sini...</p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex flex-column flex-sm-row gap-3">
                    <button type="reset" class="btn btn-lg btn-light border rounded-3 px-4 order-2 order-sm-1">
                        <i class="bi bi-arrow-counterclockwise me-2"></i>Reset Form
                    </button>
                    <button type="submit" class="btn btn-lg btn-primary rounded-3 px-5 flex-grow-1 order-1 order-sm-2 shadow-sm">
                        <i class="bi bi-send-fill me-2"></i>Kirim ke Semua User
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Daftar Pengumuman -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white border-bottom py-4">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div>
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="bi bi-list-ul text-primary me-2"></i>
                        Riwayat Pengumuman
                    </h5>
                    <small class="text-muted">Daftar semua pengumuman yang telah dikirim</small>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            @if($announcements->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3 fw-semibold text-muted text-uppercase small" width="5%">
                                <i class="bi bi-hash"></i>
                            </th>
                            <th class="px-4 py-3 fw-semibold text-muted text-uppercase small" width="25%">
                                <i class="bi bi-chat-square-text me-1"></i>Judul
                            </th>
                            <th class="px-4 py-3 fw-semibold text-muted text-uppercase small">
                                <i class="bi bi-file-text me-1"></i>Isi Pengumuman
                            </th>
                            <th class="px-4 py-3 fw-semibold text-muted text-uppercase small" width="12%">
                                <i class="bi bi-calendar3 me-1"></i>Tanggal
                            </th>
                            <th class="px-4 py-3 fw-semibold text-muted text-uppercase small text-center" width="180px">
                                <i class="bi bi-gear me-1"></i>Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($announcements as $index => $ann)
                        <tr class="announcement-row">
                            <td class="px-4">
                                <span class="badge bg-light text-dark border">
                                    {{ ($announcements->currentPage() - 1) * $announcements->perPage() + $index + 1 }}
                                </span>
                            </td>
                            <td class="px-4">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 rounded-2 p-2 me-3">
                                        <i class="bi bi-megaphone-fill text-primary"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-semibold">{{ $ann->title }}</h6>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4">
                                <p class="mb-0 text-muted">
                                    {{ Str::limit($ann->content, 80) }}
                                </p>
                            </td>
                            <td class="px-4">
                                <div class="d-flex flex-column">
                                    <span class="fw-semibold small">{{ $ann->created_at->format('d M Y') }}</span>
                                    <span class="text-muted small">{{ $ann->created_at->format('H:i') }}</span>
                                </div>
                            </td>
                            <td class="px-4">
                                <div class="d-flex gap-2 justify-content-center">
                                    <!-- Tombol Edit -->
                                    <a
                                        href="{{ route('admin.announcements.edit', $ann->id) }}"
                                        class="btn btn-sm btn-warning rounded-3 px-3"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        title="Edit Pengumuman">
                                        <i class="bi bi-pencil-square me-1"></i>
                                        <span class="d-none d-lg-inline">Edit</span>
                                    </a>

                                    <!-- Tombol Hapus -->
                                    <form
                                        action="{{ route('admin.announcements.destroy', $ann->id) }}"
                                        method="POST"
                                        class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-danger rounded-3 px-3 delete-btn"
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            title="Hapus Pengumuman">
                                            <i class="bi bi-trash3 me-1"></i>
                                            <span class="d-none d-lg-inline">Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="bi bi-inbox text-muted" style="font-size: 4rem;"></i>
                </div>
                <h5 class="text-muted mb-2">Belum Ada Pengumuman</h5>
                <p class="text-muted">Buat pengumuman pertama Anda menggunakan form di atas</p>
            </div>
            @endif
        </div>
        @if($announcements->hasPages())
        <div class="card-footer bg-white border-top py-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="text-muted small">
                    Menampilkan {{ $announcements->firstItem() }} - {{ $announcements->lastItem() }} dari {{ $announcements->total() }} pengumuman
                </div>
                <div>
                    {{ $announcements->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<style>
    /* Gradient Primary */
    .bg-gradient-primary {
        background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
    }

    /* Form Styling */
    .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
    }

    .input-group-text {
        background-color: transparent;
    }

    /* Table Row Hover */
    .announcement-row {
        transition: all 0.2s ease;
    }

    .announcement-row:hover {
        background-color: rgba(13, 110, 253, 0.03);
    }

    /* Button Styling - IMPROVED */
    .btn {
        transition: all 0.2s ease;
        font-weight: 500;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(13, 110, 253, 0.3);
    }

    .btn-warning {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #000;
    }

    .btn-warning:hover {
        background-color: #ffb300;
        border-color: #ffb300;
        color: #000;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(255, 193, 7, 0.4);
    }

    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .btn-danger:hover {
        background-color: #c82333;
        border-color: #bd2130;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.4);
    }

    /* Better spacing for action buttons */
    .btn-sm {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
        min-width: 70px;
    }

    /* Card Animations */
    .card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    /* Alert Styling */
    .alert {
        border-left: 4px solid;
    }

    .alert-success {
        border-left-color: #198754;
    }

    /* Badge Styling */
    .badge {
        font-weight: 500;
        letter-spacing: 0.3px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .table th, .table td {
            padding: 0.75rem 0.5rem !important;
        }

        h2 {
            font-size: 1.5rem;
        }

        .card-body {
            padding: 1.5rem !important;
        }

        /* Stack buttons on mobile */
        .d-flex.gap-2 {
            flex-direction: column !important;
        }

        .btn-sm {
            width: 100%;
        }
    }

    @media (min-width: 992px) {
        /* Show text on larger screens */
        .btn-sm span {
            display: inline !important;
        }
    }

    /* Custom Scrollbar */
    .table-responsive::-webkit-scrollbar {
        height: 8px;
    }

    .table-responsive::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .table-responsive::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
    }

    .table-responsive::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    /* Icon alignment in buttons */
    .btn i {
        vertical-align: middle;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Character Counter
    const contentTextarea = document.getElementById('content');
    const charCount = document.getElementById('charCount');

    if (contentTextarea && charCount) {
        contentTextarea.addEventListener('input', function() {
            const count = this.value.length;
            charCount.textContent = count + ' karakter';

            if (count < 10) {
                charCount.classList.remove('bg-light', 'text-muted');
                charCount.classList.add('bg-danger', 'text-white');
            } else {
                charCount.classList.remove('bg-danger', 'text-white');
                charCount.classList.add('bg-light', 'text-muted');
            }
        });
    }

    // Live Preview
    const titleInput = document.getElementById('title');
    const contentInput = document.getElementById('content');
    const previewCard = document.getElementById('previewCard');
    const previewTitle = document.getElementById('previewTitle');
    const previewContent = document.getElementById('previewContent');

    function updatePreview() {
        const title = titleInput.value.trim();
        const content = contentInput.value.trim();

        if (title || content) {
            previewCard.classList.remove('d-none');
            previewTitle.textContent = title || 'Judul akan muncul di sini';
            previewContent.textContent = content || 'Isi pengumuman akan muncul di sini...';
        } else {
            previewCard.classList.add('d-none');
        }
    }

    if (titleInput && contentInput) {
        titleInput.addEventListener('input', updatePreview);
        contentInput.addEventListener('input', updatePreview);
    }

    // Form Submission
    const announcementForm = document.getElementById('announcementForm');
    if (announcementForm) {
        announcementForm.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Mengirim...';
            submitBtn.disabled = true;
        });
    }

    // Delete Confirmation with Better UX
    const deleteBtns = document.querySelectorAll('.delete-btn');
    deleteBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('.delete-form');

            // Better confirmation dialog
            const confirmed = confirm(
                '⚠️ PERINGATAN!\n\n' +
                'Apakah Anda yakin ingin menghapus pengumuman ini?\n\n' +
                'Tindakan ini tidak dapat dibatalkan dan pengumuman akan hilang secara permanen!'
            );

            if (confirmed) {
                // Show loading state
                this.innerHTML = '<i class="bi bi-hourglass-split me-1"></i><span class="d-none d-lg-inline">Menghapus...</span>';
                this.disabled = true;
                form.submit();
            }
        });
    });

    // Initialize Bootstrap Tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
});
</script>
@endsection
