@extends('layouts.admin.admin')

@section('content')
<div class="container-fluid mt-4">
    <!-- Header Section -->
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent px-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.users.index') }}">
                        <i class="fas fa-users mr-1"></i>Manajemen User
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Kirim Pesan</li>
            </ol>
        </nav>

        <div class="d-flex align-items-center mb-3">
            <h2 class="mb-0 font-weight-bold text-dark">
                <i class="fas fa-paper-plane text-primary mr-2"></i>Kirim Pesan Notifikasi
            </h2>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- User Info Card -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-gradient-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-user mr-2"></i>Informasi Penerima
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar-circle-large bg-info text-white mr-3">
                            {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                        </div>
                        <div>
                            <h5 class="mb-1 font-weight-bold">{{ $user->name ?? '(Belum diisi)' }}</h5>
                            <p class="mb-1 text-muted">
                                <i class="fas fa-id-badge mr-1"></i>
                                Username: <span class="badge badge-dark px-2">{{ $user->username }}</span>
                            </p>
                            <p class="mb-0 text-muted">
                                <i class="fas fa-envelope mr-1"></i>
                                Email: {{ $user->email ?? '-' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Message Form Card -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">
                        <i class="fas fa-edit mr-2"></i>Tulis Pesan
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('admin.users.notify', $user->id) }}" id="notificationForm">
                        @csrf
                        <div class="form-group">
                            <label for="message" class="font-weight-semibold">
                                <i class="fas fa-comment-dots mr-1"></i>Pesan Notifikasi
                                <span class="text-danger">*</span>
                            </label>
                            <textarea
                                name="message"
                                id="message"
                                class="form-control form-control-lg"
                                rows="6"
                                placeholder="Ketik pesan notifikasi yang ingin dikirim..."
                                required
                                maxlength="500"></textarea>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle mr-1"></i>
                                Maksimal 500 karakter. Tersisa: <span id="charCount">500</span> karakter
                            </small>
                        </div>

                        <!-- Alert Info -->
                        <div class="alert alert-info border-0 shadow-sm">
                            <i class="fas fa-lightbulb mr-2"></i>
                            <strong>Tips:</strong> Pastikan pesan yang dikirim jelas dan mudah dipahami oleh penerima.
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-times mr-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg px-5">
                                <i class="fas fa-paper-plane mr-2"></i>Kirim Pesan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Success Message (if exists) -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm mt-4" role="alert">
                    <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.bg-gradient-info {
    background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
}

.avatar-circle-large {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 24px;
    flex-shrink: 0;
}

.card {
    border-radius: 10px;
    overflow: hidden;
}

.form-control:focus {
    border-color: #80bdff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
}

.form-control-lg {
    font-size: 1rem;
    border-radius: 8px;
}

.btn-lg {
    padding: 0.75rem 1.5rem;
    font-size: 1rem;
    border-radius: 8px;
}

.breadcrumb {
    background-color: transparent;
    padding: 0;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: "›";
    font-size: 1.2rem;
}

.breadcrumb-item a {
    color: #007bff;
    text-decoration: none;
}

.breadcrumb-item a:hover {
    color: #0056b3;
    text-decoration: underline;
}

.font-weight-semibold {
    font-weight: 600;
}

textarea {
    resize: vertical;
    min-height: 150px;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,123,255,0.3);
    transition: all 0.3s ease;
}

.btn-outline-secondary:hover {
    transform: translateY(-2px);
    transition: all 0.3s ease;
}

.alert {
    border-radius: 8px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const messageTextarea = document.getElementById('message');
    const charCount = document.getElementById('charCount');
    const maxLength = 500;

    // Character counter
    messageTextarea.addEventListener('input', function() {
        const remaining = maxLength - this.value.length;
        charCount.textContent = remaining;

        if (remaining < 50) {
            charCount.classList.add('text-warning');
            charCount.classList.remove('text-muted');
        } else {
            charCount.classList.remove('text-warning');
            charCount.classList.add('text-muted');
        }
    });

    // Form confirmation
    const form = document.getElementById('notificationForm');
    form.addEventListener('submit', function(e) {
        if (!confirm('Apakah Anda yakin ingin mengirim pesan ini ke ' + '{{ $user->name ?? "user ini" }}' + '?')) {
            e.preventDefault();
        }
    });
});
</script>
@endsection
