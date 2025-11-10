@extends('layouts.admin.admin')

@section('content')
<div class="container-fluid px-4 py-5">
    <!-- Header Section -->
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.announcements.index') }}" class="text-decoration-none">
                        <i class="bi bi-megaphone me-1"></i>Pengumuman
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Edit Pengumuman</li>
            </ol>
        </nav>

        <div class="d-flex align-items-center">
            <div class="bg-warning bg-opacity-10 rounded-3 p-3 me-3">
                <i class="bi bi-pencil-square text-warning fs-2"></i>
            </div>
            <div>
                <h2 class="mb-1 fw-bold text-dark">Edit Pengumuman</h2>
                <p class="text-muted mb-0">Perbarui informasi pengumuman yang sudah ada</p>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-10">
            <!-- Main Form Card -->
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-gradient-warning text-dark border-0 py-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-white bg-opacity-50 rounded-3 p-2 me-3">
                            <i class="bi bi-pencil-fill fs-5"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold">Form Edit Pengumuman</h5>
                            <small class="opacity-75">Ubah detail pengumuman sesuai kebutuhan</small>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4 p-lg-5">
                    <form action="{{ route('admin.announcements.update', $announcement->id) }}" method="POST" enctype="multipart/form-data" id="editAnnouncementForm">
                        @csrf
                        @method('PUT')

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
                                    value="{{ old('title', $announcement->title) }}"
                                    placeholder="Contoh: Pemeliharaan Server - 15 Nov 2025"
                                    required
                                    autofocus>
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
                                    rows="6"
                                    placeholder="Tulis pengumuman Anda di sini. Jelaskan dengan detail agar pengguna memahami informasi yang disampaikan..."
                                    style="resize: vertical;"
                                    required>{{ old('content', $announcement->content) }}</textarea>
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

                        <!-- File/Gambar Upload -->
                        <div class="mb-4">
                            <label for="file" class="form-label text-dark fw-semibold mb-2">
                                File/Gambar Lampiran
                                <span class="text-muted fw-normal">(Opsional)</span>
                            </label>

                            <!-- Current File Display -->
                            @if($announcement->file)
                            <div class="card bg-light border-0 rounded-3 mb-3">
                                <div class="card-body p-3">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary bg-opacity-10 rounded-2 p-2 me-3">
                                                <i class="bi bi-file-earmark-check text-primary fs-4"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-semibold">File Saat Ini</h6>
                                                <small class="text-muted">File yang sudah diupload sebelumnya</small>
                                            </div>
                                        </div>
                                        <a href="{{ asset('storage/'.$announcement->file) }}"
                                           target="_blank"
                                           class="btn btn-sm btn-outline-primary rounded-3">
                                            <i class="bi bi-eye me-1"></i>Lihat File
                                        </a>
                                    </div>
                                    <div class="mt-2 pt-2 border-top">
                                        <small class="text-muted">
                                            <i class="bi bi-info-circle me-1"></i>
                                            Upload file baru untuk mengganti file saat ini
                                        </small>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- File Input -->
                            <div class="position-relative">
                                <input
                                    type="file"
                                    name="file"
                                    id="file"
                                    class="form-control rounded-3 @error('file') is-invalid @enderror"
                                    accept="image/*,.pdf,.doc,.docx,.xls,.xlsx"
                                    onchange="previewFile(this)">
                                @error('file')
                                    <div class="invalid-feedback d-block">
                                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- File Preview -->
                            <div id="filePreview" class="mt-3 d-none">
                                <div class="card border-2 border-primary rounded-3">
                                    <div class="card-body p-3">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-primary bg-opacity-10 rounded-2 p-2 me-3">
                                                    <i class="bi bi-file-earmark-plus text-primary fs-4" id="fileIcon"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 fw-semibold" id="fileName">File baru</h6>
                                                    <small class="text-muted" id="fileSize">0 KB</small>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-sm btn-outline-danger rounded-3" onclick="clearFile()">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <small class="text-muted d-block mt-2">
                                <i class="bi bi-info-circle me-1"></i>
                                Format yang didukung: Gambar (JPG, PNG, GIF), PDF, Word, Excel. Maksimal 5MB
                            </small>
                        </div>

                        <!-- Preview Card -->
                        <div class="card bg-light border-0 rounded-3 mb-4">
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
                                    <h6 class="fw-bold mb-2" id="previewTitle">{{ $announcement->title }}</h6>
                                    <p class="mb-0 text-muted" id="previewContent">{{ $announcement->content }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex flex-column flex-sm-row gap-3">
                            <a href="{{ route('admin.announcements.index') }}" class="btn btn-lg btn-light border rounded-3 px-4 order-2 order-sm-1">
                                <i class="bi bi-arrow-left me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-lg btn-warning rounded-3 px-5 flex-grow-1 order-1 order-sm-2 shadow-sm">
                                <i class="bi bi-check-circle me-2"></i>Update Pengumuman
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Info Card -->
            <div class="mt-4 p-4 bg-light bg-opacity-50 rounded-3 border border-warning border-opacity-25">
                <div class="d-flex align-items-start">
                    <div class="me-3">
                        <i class="bi bi-lightbulb text-warning fs-4"></i>
                    </div>
                    <div>
                        <h6 class="fw-semibold mb-2">Tips Edit Pengumuman</h6>
                        <ul class="text-muted small mb-0 ps-3">
                            <li>Pastikan informasi yang diubah sudah benar sebelum menyimpan</li>
                            <li>File lama akan diganti jika Anda mengupload file baru</li>
                            <li>Perubahan akan langsung terlihat oleh semua pengguna setelah disimpan</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Gradient Warning */
    .bg-gradient-warning {
        background: linear-gradient(135deg, #ffc107 0%, #ffb300 100%);
    }

    /* Form Styling */
    .form-control:focus {
        border-color: #ffc107;
        box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.15);
    }

    .input-group-text {
        background-color: transparent;
    }

    /* Button Styling */
    .btn {
        transition: all 0.2s ease;
        font-weight: 500;
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
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(255, 193, 7, 0.3);
    }

    .btn-light:hover {
        background-color: #f8f9fa;
        border-color: #dee2e6;
    }

    .btn-outline-primary:hover {
        transform: scale(1.05);
    }

    .btn-outline-danger:hover {
        transform: scale(1.1);
    }

    /* Card Animation */
    .card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    /* Breadcrumb Styling */
    .breadcrumb {
        background-color: transparent;
        padding: 0;
        margin-bottom: 1rem;
    }

    .breadcrumb-item + .breadcrumb-item::before {
        content: "›";
        color: #6c757d;
    }

    .breadcrumb-item a:hover {
        color: #0d6efd;
    }

    /* File Input Custom */
    input[type="file"]::-webkit-file-upload-button {
        background: #0d6efd;
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    input[type="file"]::-webkit-file-upload-button:hover {
        background: #0b5ed7;
        transform: translateY(-1px);
    }

    /* Responsive */
    @media (max-width: 576px) {
        .card-body {
            padding: 1.5rem !important;
        }

        h2 {
            font-size: 1.5rem;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Character Counter
    const contentTextarea = document.getElementById('content');
    const charCount = document.getElementById('charCount');

    function updateCharCount() {
        if (contentTextarea && charCount) {
            const count = contentTextarea.value.length;
            charCount.textContent = count + ' karakter';

            if (count < 10) {
                charCount.classList.remove('bg-light', 'text-muted');
                charCount.classList.add('bg-danger', 'text-white');
            } else {
                charCount.classList.remove('bg-danger', 'text-white');
                charCount.classList.add('bg-light', 'text-muted');
            }
        }
    }

    // Initial count
    updateCharCount();

    if (contentTextarea) {
        contentTextarea.addEventListener('input', updateCharCount);
    }

    // Live Preview
    const titleInput = document.getElementById('title');
    const contentInput = document.getElementById('content');
    const previewTitle = document.getElementById('previewTitle');
    const previewContent = document.getElementById('previewContent');

    function updatePreview() {
        if (titleInput && previewTitle) {
            previewTitle.textContent = titleInput.value || 'Judul akan muncul di sini';
        }
        if (contentInput && previewContent) {
            previewContent.textContent = contentInput.value || 'Isi pengumuman akan muncul di sini...';
        }
    }

    if (titleInput && contentInput) {
        titleInput.addEventListener('input', updatePreview);
        contentInput.addEventListener('input', updatePreview);
    }

    // Form Submission
    const editForm = document.getElementById('editAnnouncementForm');
    if (editForm) {
        editForm.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Memperbarui...';
            submitBtn.disabled = true;
        });
    }
});

// File Preview Function
function previewFile(input) {
    const filePreview = document.getElementById('filePreview');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');
    const fileIcon = document.getElementById('fileIcon');

    if (input.files && input.files[0]) {
        const file = input.files[0];
        const size = (file.size / 1024).toFixed(2); // Convert to KB

        // Update file info
        fileName.textContent = file.name;
        fileSize.textContent = size + ' KB';

        // Update icon based on file type
        if (file.type.startsWith('image/')) {
            fileIcon.className = 'bi bi-file-earmark-image text-primary fs-4';
        } else if (file.type === 'application/pdf') {
            fileIcon.className = 'bi bi-file-earmark-pdf text-danger fs-4';
        } else if (file.type.includes('word')) {
            fileIcon.className = 'bi bi-file-earmark-word text-primary fs-4';
        } else if (file.type.includes('excel') || file.type.includes('spreadsheet')) {
            fileIcon.className = 'bi bi-file-earmark-excel text-success fs-4';
        } else {
            fileIcon.className = 'bi bi-file-earmark text-secondary fs-4';
        }

        // Show preview
        filePreview.classList.remove('d-none');
    }
}

// Clear File Function
function clearFile() {
    const fileInput = document.getElementById('file');
    const filePreview = document.getElementById('filePreview');

    fileInput.value = '';
    filePreview.classList.add('d-none');
}
</script>
@endsection
