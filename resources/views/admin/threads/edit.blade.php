@extends('layouts.admin.admin')

@section('content')
<div class="container-fluid mt-4">
    <!-- Header dengan tombol kembali -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0 font-weight-bold text-dark">
            <i class="fas fa-edit text-primary mr-2"></i>Edit Pertanyaan
        </h2>
        <a href="{{ route('admin.threads.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left mr-2"></i>Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <!-- Card Form -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-0 font-weight-bold text-dark">
                        <i class="fas fa-file-alt text-primary mr-2"></i>Form Edit Pertanyaan
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.threads.update', $thread->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Judul -->
                        <div class="form-group mb-4">
                            <label for="title" class="font-weight-semibold">
                                <i class="fas fa-heading text-primary mr-1"></i>Judul
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   name="title"
                                   id="title"
                                   class="form-control form-control-lg"
                                   value="{{ old('title', $thread->title) }}"
                                   placeholder="Masukkan judul pertanyaan"
                                   required>
                            @error('title')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Kategori -->
                        <div class="form-group mb-4">
                            <label for="category_id" class="font-weight-semibold">
                                <i class="fas fa-folder text-primary mr-1"></i>Kategori
                                <span class="text-danger">*</span>
                            </label>
                            <select name="category_id"
                                    id="category_id"
                                    class="form-control form-control-lg"
                                    required>
                                <option value="" disabled>Pilih Kategori</option>
                                @foreach(\App\Models\Category::all() as $cat)
                                    <option value="{{ $cat->id }}" {{ $thread->category_id == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Isi Pertanyaan -->
                        <div class="form-group mb-4">
                            <label for="body" class="font-weight-semibold">
                                <i class="fas fa-align-left text-primary mr-1"></i>Isi Pertanyaan
                                <span class="text-danger">*</span>
                            </label>
                            <textarea name="body"
                                      id="body"
                                      class="form-control form-control-lg"
                                      rows="6"
                                      placeholder="Tulis isi pertanyaan di sini..."
                                      required>{{ old('body', $thread->body) }}</textarea>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle mr-1"></i>
                                Jelaskan pertanyaan dengan detail dan jelas
                            </small>
                            @error('body')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Divider -->
                        <hr class="my-4">

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-end align-items-center">
                            <a href="{{ route('admin.threads.index') }}" class="btn btn-secondary btn-lg mr-2">
                                <i class="fas fa-times mr-1"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg px-4">
                                <i class="fas fa-save mr-1"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Info Card -->
            <div class="card shadow-sm border-0 mt-4">
                <div class="card-body p-3 bg-light">
                    <div class="row text-center">
                        <div class="col-md-4">
                            <small class="text-muted d-block mb-1">
                                <i class="fas fa-user mr-1"></i>Dibuat oleh
                            </small>
                            <strong>{{ $thread->user->name ?? '-' }}</strong>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted d-block mb-1">
                                <i class="far fa-calendar-alt mr-1"></i>Tanggal Dibuat
                            </small>
                            <strong>{{ $thread->created_at->format('d M Y') }}</strong>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted d-block mb-1">
                                <i class="fas fa-clock mr-1"></i>Terakhir Update
                            </small>
                            <strong>{{ $thread->updated_at->format('d M Y') }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border-radius: 10px;
    overflow: hidden;
}

.form-control-lg {
    font-size: 1rem;
    border-radius: 8px;
    border: 1px solid #ced4da;
}

.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.15);
}

.font-weight-semibold {
    font-weight: 600;
}

.btn-lg {
    padding: 0.75rem 1.5rem;
    font-size: 1rem;
    border-radius: 8px;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,123,255,0.3);
    transition: all 0.3s ease;
}

.btn-secondary:hover {
    transform: translateY(-2px);
    transition: all 0.3s ease;
}

.btn-outline-secondary:hover {
    transform: translateY(-2px);
    transition: all 0.3s ease;
}

textarea {
    resize: vertical;
    min-height: 150px;
}

label {
    font-size: 0.95rem;
}

hr {
    border-top: 2px solid #e9ecef;
}

.card-header {
    border-bottom: 3px solid #007bff;
}
</style>
@endsection
