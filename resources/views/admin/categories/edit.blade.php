@extends('layouts.admin.admin')

@section('content')
<div class="container-fluid mt-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-transparent p-0">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}" class="text-decoration-none">
                    <i class="fas fa-home mr-1"></i>Dashboard
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.categories.index') }}" class="text-decoration-none">
                    <i class="fas fa-tags mr-1"></i>Kategori
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Edit Kategori</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <!-- Header Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle bg-warning mr-3">
                            <i class="fas fa-edit fa-2x text-white"></i>
                        </div>
                        <div>
                            <h3 class="mb-1 font-weight-bold text-dark">Edit Kategori</h3>
                            <p class="text-muted mb-0">Perbarui informasi kategori forum</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header text-white border-0" style="background: linear-gradient(135deg, #f6ad55 0%, #ed8936 100%);">
                    <h5 class="mb-0 font-weight-bold">
                        <i class="fas fa-folder-open mr-2"></i>Informasi Kategori
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" id="categoryForm">
                        @csrf
                        @method('PUT')

                        <!-- Current Category Info -->
                        <div class="alert alert-info border-0 mb-4" style="background-color: #e3f2fd;">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-info-circle fa-2x mr-3 text-info"></i>
                                <div>
                                    <strong>Kategori Saat Ini:</strong>
                                    <p class="mb-0">{{ $category->name }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Name Field -->
                        <div class="form-group mb-4">
                            <label for="name" class="form-label font-weight-bold text-dark">
                                <i class="fas fa-tag mr-1 text-primary"></i>Nama Kategori
                                <span class="text-danger">*</span>
                            </label>
                            <input
                                type="text"
                                name="name"
                                id="name"
                                class="form-control form-control-lg @error('name') is-invalid @enderror"
                                value="{{ old('name', $category->name) }}"
                                placeholder="Masukkan nama kategori..."
                                required
                                autofocus>
                            @error('name')
                                <div class="invalid-feedback d-flex align-items-center">
                                    <i class="fas fa-exclamation-circle mr-2"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                            <small class="form-text text-muted">
                                <i class="fas fa-lightbulb mr-1"></i>Gunakan nama yang jelas dan mudah dipahami
                            </small>
                        </div>

                        <!-- Description Field -->
                        <div class="form-group mb-4">
                            <label for="description" class="form-label font-weight-bold text-dark">
                                <i class="fas fa-align-left mr-1 text-primary"></i>Deskripsi
                            </label>
                            <textarea
                                name="description"
                                id="description"
                                class="form-control @error('description') is-invalid @enderror"
                                rows="5"
                                placeholder="Berikan deskripsi singkat tentang kategori ini...">{{ old('description', $category->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback d-flex align-items-center">
                                    <i class="fas fa-exclamation-circle mr-2"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                            <small class="form-text text-muted">
                                <i class="fas fa-lightbulb mr-1"></i>Deskripsi membantu pengguna memahami topik dalam kategori ini
                            </small>
                        </div>

                        <!-- Character Counter -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between text-muted small">
                                <span><i class="fas fa-keyboard mr-1"></i>Karakter Nama: <strong id="nameCount">{{ strlen($category->name) }}</strong>/100</span>
                                <span><i class="fas fa-keyboard mr-1"></i>Karakter Deskripsi: <strong id="descCount">{{ strlen($category->description ?? '') }}</strong>/500</span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-arrow-left mr-2"></i>Kembali
                            </a>
                            <div class="d-flex" style="gap: 10px;">
                                <button type="reset" class="btn btn-outline-danger btn-lg" onclick="return confirm('Yakin reset form?')">
                                    <i class="fas fa-undo mr-2"></i>Reset
                                </button>
                                <button type="submit" class="btn btn-warning text-white btn-lg">
                                    <i class="fas fa-save mr-2"></i>Update Kategori
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Help Card -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-body p-4">
                    <h6 class="font-weight-bold text-dark mb-3">
                        <i class="fas fa-question-circle mr-2 text-primary"></i>Tips Mengedit Kategori
                    </h6>
                    <ul class="text-muted mb-0" style="list-style: none; padding-left: 0;">
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success mr-2"></i>
                            Pastikan nama kategori tetap relevan dengan konten forum
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success mr-2"></i>
                            Perubahan akan mempengaruhi semua pertanyaan dalam kategori ini
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success mr-2"></i>
                            Deskripsi yang jelas membantu pengguna memilih kategori yang tepat
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Icon Circle */
.icon-circle {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: linear-gradient(135deg, #f6ad55 0%, #ed8936 100%);
}

/* Form Control Focus */
.form-control:focus {
    border-color: #f6ad55;
    box-shadow: 0 0 0 0.2rem rgba(246, 173, 85, 0.25);
}

.form-control-lg {
    padding: 0.75rem 1rem;
    font-size: 1.1rem;
}

/* Button Styling */
.btn-warning {
    background: linear-gradient(135deg, #f6ad55 0%, #ed8936 100%);
    border: none;
    transition: all 0.3s ease;
}

.btn-warning:hover {
    background: linear-gradient(135deg, #ed8936 0%, #dd6b20 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(237, 137, 54, 0.4);
}

.btn-outline-secondary {
    transition: all 0.3s ease;
}

.btn-outline-secondary:hover {
    transform: translateY(-2px);
}

.btn-outline-danger {
    transition: all 0.3s ease;
}

.btn-outline-danger:hover {
    transform: translateY(-2px);
}

/* Card Animation */
.card {
    animation: fadeInUp 0.4s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Breadcrumb */
.breadcrumb-item a {
    color: #667eea;
    transition: color 0.2s ease;
}

.breadcrumb-item a:hover {
    color: #764ba2;
}

.breadcrumb-item.active {
    color: #6c757d;
}

/* Alert Custom */
.alert {
    border-radius: 0.5rem;
}

/* Invalid Feedback */
.invalid-feedback {
    font-size: 0.9rem;
}

/* Character Counter */
#nameCount, #descCount {
    color: #667eea;
    font-size: 1rem;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Character Counter
    const nameInput = document.getElementById('name');
    const descInput = document.getElementById('description');
    const nameCount = document.getElementById('nameCount');
    const descCount = document.getElementById('descCount');

    if (nameInput && nameCount) {
        nameInput.addEventListener('input', function() {
            const count = this.value.length;
            nameCount.textContent = count;
            nameCount.style.color = count > 100 ? '#e53e3e' : '#667eea';
        });
    }

    if (descInput && descCount) {
        descInput.addEventListener('input', function() {
            const count = this.value.length;
            descCount.textContent = count;
            descCount.style.color = count > 500 ? '#e53e3e' : '#667eea';
        });
    }

    // Form Validation
    const form = document.getElementById('categoryForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            const nameValue = nameInput.value.trim();

            if (nameValue.length < 3) {
                e.preventDefault();
                alert('Nama kategori minimal 3 karakter!');
                nameInput.focus();
                return false;
            }

            if (nameValue.length > 100) {
                e.preventDefault();
                alert('Nama kategori maksimal 100 karakter!');
                nameInput.focus();
                return false;
            }
        });
    }
});
</script>
@endsection
