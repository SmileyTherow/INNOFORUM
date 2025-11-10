@extends('layouts.admin.admin')

@section('content')
<div class="container-fluid mt-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1 font-weight-bold text-dark">
                <i class="fas fa-comments text-primary mr-2"></i>Manajemen Pertanyaan
            </h2>
            <p class="text-muted mb-0">Kelola semua pertanyaan dari pengguna</p>
        </div>
        <div class="badge badge-primary badge-pill px-3 py-2" style="font-size: 1rem;">
            <i class="fas fa-question-circle mr-1"></i>
            {{ $threads->total() }} Pertanyaan
        </div>
    </div>

    <!-- Search Card -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-gradient-primary text-white">
            <h5 class="mb-0">
                <i class="fas fa-search mr-2"></i>Cari Pertanyaan
            </h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.threads.index') }}">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-white">
                            <i class="fas fa-search text-primary"></i>
                        </span>
                    </div>
                    <input type="text"
                           name="q"
                           class="form-control form-control-lg"
                           placeholder="Cari berdasarkan judul atau nama user"
                           value="{{ request('q') }}">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary btn-lg px-4">
                            <i class="fas fa-search mr-1"></i>Cari
                        </button>
                        @if(request('q'))
                            <a href="{{ route('admin.threads.index') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Threads Table Card -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-bottom py-3">
            <h5 class="mb-0 text-dark">
                <i class="fas fa-list mr-2"></i>Daftar Pertanyaan
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th class="border-0" style="width: 40%;">
                                <i class="fas fa-file-alt mr-1"></i>Judul & Isi
                            </th>
                            <th class="border-0" style="width: 15%;">
                                <i class="fas fa-user mr-1"></i>Pengguna
                            </th>
                            <th class="border-0" style="width: 15%;">
                                <i class="fas fa-calendar mr-1"></i>Tanggal
                            </th>
                            <th class="border-0 text-center" style="width: 30%;">
                                <i class="fas fa-cog mr-1"></i>Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($threads as $thread)
                            <tr>
                                <td class="align-middle">
                                    <div>
                                        <h6 class="mb-2 font-weight-bold text-dark">
                                            {{ $thread->title }}
                                        </h6>
                                        <p class="mb-0 text-muted small" style="line-height: 1.5;">
                                            {{ Str::limit($thread->content ?? '-', 100) }}
                                        </p>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle bg-info text-white mr-2">
                                            {{ strtoupper(substr($thread->user->name ?? 'U', 0, 1)) }}
                                        </div>
                                        <span class="font-weight-medium">{{ $thread->user->name ?? '-' }}</span>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <small class="text-muted">
                                        <i class="far fa-clock mr-1"></i>
                                        {{ $thread->created_at->format('d M Y') }}
                                    </small>
                                </td>
                                <td class="align-middle text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('admin.threads.show', $thread->id) }}"
                                           class="btn btn-info"
                                           data-toggle="tooltip"
                                           title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.threads.edit', $thread->id) }}"
                                           class="btn btn-primary"
                                           data-toggle="tooltip"
                                           title="Edit Pertanyaan">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button class="btn btn-warning"
                                                onclick="showThreadMessageModal('{{ $thread->id }}', '{{ $thread->user->name }}')"
                                                data-toggle="tooltip"
                                                title="Kirim Pesan">
                                            <i class="fas fa-paper-plane"></i>
                                        </button>
                                        <form action="{{ route('admin.threads.destroy', $thread->id) }}"
                                              method="POST"
                                              style="display:inline"
                                              onsubmit="return confirm('Yakin ingin menghapus pertanyaan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-danger"
                                                    data-toggle="tooltip"
                                                    title="Hapus Pertanyaan">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <i class="fas fa-comments fa-3x text-muted mb-3 d-block"></i>
                                    <p class="text-muted mb-0">Tidak ada pertanyaan ditemukan</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($threads->hasPages())
            <div class="card-footer bg-white border-top py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted">
                        <small>
                            Menampilkan <strong>{{ $threads->firstItem() }}</strong> sampai <strong>{{ $threads->lastItem() }}</strong>
                            dari <strong>{{ $threads->total() }}</strong> pertanyaan
                        </small>
                    </div>
                    <div>
                        {{ $threads->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Modal Kirim Pesan ke User Pertanyaan -->
<div class="modal fade" id="threadMessageModal" tabindex="-1" aria-labelledby="threadMessageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form id="threadMessageForm" method="POST" action="{{ route('admin.threads.notify') }}">
                @csrf
                <input type="hidden" name="thread_id" id="modalThreadId">
                <div class="modal-header bg-gradient-warning text-white">
                    <h5 class="modal-title" id="threadMessageModalLabel">
                        <i class="fas fa-paper-plane mr-2"></i>Kirim Pesan ke User
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="alert alert-info border-0 mb-3">
                        <i class="fas fa-info-circle mr-2"></i>
                        <small>Pesan akan dikirim ke: <strong id="modalUserName"></strong></small>
                    </div>
                    <div class="form-group">
                        <label for="message" class="font-weight-semibold">
                            <i class="fas fa-comment-dots mr-1"></i>Pesan Notifikasi
                        </label>
                        <textarea name="message"
                                  class="form-control"
                                  rows="5"
                                  placeholder="Tulis pesan Anda di sini..."
                                  required>Gunakan kalimat yang lebih sopan lagi.</textarea>
                        <small class="form-text text-muted">
                            <i class="fas fa-lightbulb mr-1"></i>
                            Pastikan pesan disampaikan dengan jelas dan sopan
                        </small>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-warning text-white">
                        <i class="fas fa-paper-plane mr-1"></i>Kirim Pesan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
}

.bg-gradient-warning {
    background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
}

.avatar-circle {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 14px;
    flex-shrink: 0;
}

.table th {
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 0.5px;
}

.table td {
    vertical-align: middle;
    border-right: 1px solid #dee2e6;
}

.table td:last-child {
    border-right: none;
}

.table th {
    border-right: 1px solid #dee2e6;
}

.table th:last-child {
    border-right: none;
}

.table-hover tbody tr:hover {
    background-color: #f8f9fa;
    transition: background-color 0.2s ease;
}

.btn-group .btn {
    margin: 0 2px;
}

.font-weight-medium {
    font-weight: 500;
}

.font-weight-semibold {
    font-weight: 600;
}

.card {
    border-radius: 10px;
    overflow: hidden;
}

.modal-content {
    border-radius: 10px;
}

.form-control:focus {
    border-color: #80bdff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
}

.input-group-text {
    border: 1px solid #ced4da;
}

/* Pagination Styling */
.pagination {
    margin-bottom: 0;
}

.pagination .page-link {
    color: #007bff;
    border: 1px solid #dee2e6;
    padding: 0.5rem 0.75rem;
    margin: 0 2px;
    border-radius: 5px;
    transition: all 0.3s ease;
}

.pagination .page-link:hover {
    background-color: #007bff;
    color: white;
    border-color: #007bff;
    transform: translateY(-2px);
    box-shadow: 0 2px 5px rgba(0,123,255,0.3);
}

.pagination .page-item.active .page-link {
    background-color: #007bff;
    border-color: #007bff;
    color: white;
    font-weight: 600;
    box-shadow: 0 2px 5px rgba(0,123,255,0.4);
}

.pagination .page-item.disabled .page-link {
    color: #6c757d;
    background-color: #f8f9fa;
    border-color: #dee2e6;
    cursor: not-allowed;
}

.pagination .page-link:focus {
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
}
</style>

<script>
function showThreadMessageModal(threadId, userName) {
    document.getElementById('modalThreadId').value = threadId;
    document.getElementById('modalUserName').textContent = userName;
    var modal = new bootstrap.Modal(document.getElementById('threadMessageModal'));
    modal.show();
}

// Initialize tooltips
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
@endsection
