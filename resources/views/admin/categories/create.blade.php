@extends('layouts.admin.admin')

@section('content')
<div class="container-fluid px-4 py-5">
    <div class="row justify-content-center">
        <div class="col-xl-7 col-lg-8 col-md-10">
            <!-- Header Section -->
            <div class="mb-4">
                <div class="d-flex align-items-center mb-2">
                    <div class="bg-primary bg-opacity-10 rounded-3 p-3 me-3">
                        <i class="bi bi-folder-plus text-primary fs-3"></i>
                    </div>
                    <div>
                        <h2 class="mb-1 fw-bold text-dark">Tambah Kategori Baru</h2>
                        <p class="text-muted mb-0">Buat kategori untuk mengorganisir konten diskusi</p>
                    </div>
                </div>
            </div>

            <!-- Form Card -->
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-4 p-lg-5">
                    <form action="{{ route('admin.categories.store') }}" method="POST" id="categoryForm">
                        @csrf

                        <!-- Nama Kategori -->
                        <div class="mb-4">
                            <label for="name" class="form-label text-dark fw-semibold mb-2">
                                Nama Kategori
                                <span class="text-danger">*</span>
                            </label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-light border-end-0 rounded-start-3">
                                    <i class="bi bi-tag text-muted"></i>
                                </span>
                                <input
                                    type="text"
                                    name="name"
                                    id="name"
                                    class="form-control border-start-0 ps-0 rounded-end-3 @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}"
                                    placeholder="Contoh: Teknologi, Olahraga, Kuliner"
                                    required
                                    autofocus>
                                @error('name')
                                    <div class="invalid-feedback d-block">
                                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <small class="text-muted d-block mt-2">
                                <i class="bi bi-info-circle me-1"></i>Gunakan nama yang jelas dan mudah dipahami
                            </small>
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-4">
                            <label for="description" class="form-label text-dark fw-semibold mb-2">
                                Deskripsi
                                <span class="text-muted fw-normal">(Opsional)</span>
                            </label>
                            <div class="position-relative">
                                <textarea
                                    name="description"
                                    id="description"
                                    class="form-control rounded-3 @error('description') is-invalid @enderror"
                                    placeholder="Jelaskan kategori ini untuk membantu pengguna memahami topik yang sesuai..."
                                    rows="4"
                                    style="resize: none;">{{ old('description') }}</textarea>
                                <div class="position-absolute top-0 end-0 mt-3 me-3">
                                    <i class="bi bi-textarea-t text-muted opacity-50"></i>
                                </div>
                                @error('description')
                                    <div class="invalid-feedback d-block">
                                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <small class="text-muted d-block mt-2">
                                <i class="bi bi-lightbulb me-1"></i>Tip: Deskripsi yang baik membantu pengguna memilih kategori yang tepat
                            </small>
                        </div>

                        <!-- Preview Card (Optional Enhancement) -->
                        <div class="card bg-light border-0 rounded-3 mb-4 d-none" id="previewCard">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-start">
                                    <div class="me-3">
                                        <div class="bg-primary bg-opacity-10 rounded-2 p-2">
                                            <i class="bi bi-eye text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1 fw-semibold">Preview Kategori</h6>
                                        <p class="mb-0 text-muted small" id="previewText">Preview akan muncul di sini...</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex flex-column flex-sm-row gap-3 pt-3">
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-lg btn-light border rounded-3 px-4 order-2 order-sm-1">
                                <i class="bi bi-arrow-left me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-lg btn-primary rounded-3 px-4 flex-grow-1 order-1 order-sm-2 shadow-sm">
                                <i class="bi bi-check-circle me-2"></i>Simpan Kategori
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Help Section -->
            <div class="mt-4 p-4 bg-light bg-opacity-50 rounded-3 border border-primary border-opacity-10">
                <div class="d-flex align-items-start">
                    <div class="me-3">
                        <i class="bi bi-question-circle text-primary fs-4"></i>
                    </div>
                    <div>
                        <h6 class="fw-semibold mb-2">Butuh bantuan?</h6>
                        <p class="text-muted small mb-0">
                            Kategori membantu mengorganisir konten diskusi. Pastikan nama kategori mencerminkan topik yang spesifik dan mudah dipahami pengguna.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom Styling untuk tampilan modern */
    .form-control:focus,
    .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
    }

    .input-group-text {
        background-color: transparent;
    }

    .card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .btn {
        transition: all 0.2s ease;
    }

    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
    }

    .btn-light:hover {
        background-color: #f8f9fa;
        border-color: #dee2e6;
    }

    /* Animation untuk form inputs */
    .form-control,
    .form-select {
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    /* Responsive improvements */
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
    // Optional: Live preview functionality
    document.addEventListener('DOMContentLoaded', function() {
        const nameInput = document.getElementById('name');
        const descInput = document.getElementById('description');
        const previewCard = document.getElementById('previewCard');
        const previewText = document.getElementById('previewText');

        function updatePreview() {
            const name = nameInput.value.trim();
            const desc = descInput.value.trim();

            if (name || desc) {
                previewCard.classList.remove('d-none');
                previewText.innerHTML = `
                    <strong>${name || 'Nama Kategori'}</strong><br>
                    <span class="text-muted">${desc || 'Deskripsi kategori'}</span>
                `;
            } else {
                previewCard.classList.add('d-none');
            }
        }

        nameInput.addEventListener('input', updatePreview);
        descInput.addEventListener('input', updatePreview);

        // Form validation feedback
        const form = document.getElementById('categoryForm');
        form.addEventListener('submit', function(e) {
            const submitBtn = form.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Menyimpan...';
            submitBtn.disabled = true;
        });
    });
</script>
@endsection
