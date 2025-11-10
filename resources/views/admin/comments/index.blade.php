@extends('layouts.admin.admin')

@section('content')
    <div class="container-fluid mt-4">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-1 font-weight-bold text-dark">
                    <i class="fas fa-comments mr-2 text-primary"></i>Manajemen Komentar
                </h2>
                <p class="text-muted mb-0">Kelola semua komentar dari pengguna</p>
            </div>
            <div class="text-right">
                <span class="badge badge-primary badge-pill px-3 py-2" style="font-size: 0.9rem;">
                    Total: {{ $comments->total() }} Komentar
                </span>
            </div>
        </div>

        <!-- Search Section -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.comments.index') }}" class="row align-items-end">
                    <div class="col-md-10 mb-2 mb-md-0">
                        <label class="small text-muted mb-1">Cari Komentar</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white border-right-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                            </div>
                            <input type="text" name="q" class="form-control border-left-0"
                                placeholder="Cari berdasarkan isi komentar atau nama user..." value="{{ request('q') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-search mr-1"></i>Cari
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Table Section -->
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 text-uppercase small font-weight-bold" style="width: 30%;">
                                    <i class="fas fa-comment-dots mr-1 text-primary"></i>Isi Komentar
                                </th>
                                <th class="border-0 text-uppercase small font-weight-bold" style="width: 15%;">
                                    <i class="fas fa-user mr-1 text-primary"></i>User
                                </th>
                                <th class="border-0 text-uppercase small font-weight-bold" style="width: 25%;">
                                    <i class="fas fa-question-circle mr-1 text-primary"></i>Pertanyaan
                                </th>
                                <th class="border-0 text-uppercase small font-weight-bold" style="width: 15%;">
                                    <i class="fas fa-calendar mr-1 text-primary"></i>Tanggal
                                </th>
                                <th class="border-0 text-uppercase small font-weight-bold text-center" style="width: 15%;">
                                    <i class="fas fa-cog mr-1 text-primary"></i>Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($comments as $comment)
                                <tr class="border-bottom">
                                    <td class="align-middle">
                                        <div class="text-dark">{{ Str::limit($comment->content, 100) }}</div>
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle bg-primary text-white mr-2 d-flex align-items-center justify-content-center"
                                                style="width: 35px; height: 35px; border-radius: 50%; font-size: 0.85rem;">
                                                {{ strtoupper(substr($comment->user->name ?? 'U', 0, 1)) }}
                                            </div>
                                            <span class="font-weight-medium">{{ $comment->user->name ?? '-' }}</span>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <a href="{{ route('questions.show', $comment->question->id) }}" target="_blank"
                                            class="text-decoration-none">
                                            <div class="font-weight-bold text-primary mb-1" style="font-size: 0.9rem;">
                                                {{ Str::limit($comment->question->title ?? '-', 50) }}
                                            </div>
                                            <div class="text-muted small">
                                                {{ Str::limit($comment->question->content ?? '-', 60) }}
                                            </div>
                                        </a>
                                    </td>
                                    <td class="align-middle">
                                        <div class="text-muted small">
                                            <i class="far fa-clock mr-1"></i>{{ $comment->created_at->format('d M Y') }}
                                        </div>
                                        <div class="text-muted small">{{ $comment->created_at->format('H:i') }}</div>
                                    </td>
                                    <td class="align-middle text-center">
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-sm btn-outline-warning"
                                                onclick="showMessageModal('{{ $comment->id }}', '{{ $comment->user->name }}')"
                                                data-toggle="tooltip" title="Kirim Pesan">
                                                <i class="fas fa-envelope"></i>
                                            </button>
                                            <form action="{{ route('admin.comments.destroy', $comment->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button onclick="return confirm('Yakin hapus komentar ini?')"
                                                    class="btn btn-sm btn-outline-danger" data-toggle="tooltip"
                                                    title="Hapus Komentar">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fas fa-inbox fa-3x mb-3 d-block" style="opacity: 0.3;"></i>
                                            <h5 class="font-weight-normal">Tidak ada komentar ditemukan</h5>
                                            <p class="small mb-0">Coba ubah kata kunci pencarian Anda</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($comments->hasPages())
                <div class="card-footer bg-white border-top">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            Menampilkan {{ $comments->firstItem() }} - {{ $comments->lastItem() }} dari
                            {{ $comments->total() }} komentar
                        </div>
                        <div>
                            {{ $comments->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Kirim Pesan Notifikasi -->
    <div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <form id="messageForm" method="POST" action="{{ route('admin.comments.notify') }}">
                    @csrf
                    <input type="hidden" name="comment_id" id="modalCommentId" value="">
                    <div class="modal-header bg-gradient-primary text-white border-0">
                        <h5 class="modal-title font-weight-bold" id="messageModalLabel">
                            <i class="fas fa-paper-plane mr-2"></i>Kirim Pesan ke User
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="alert alert-info border-0 mb-3" style="background-color: #e3f2fd;">
                            <i class="fas fa-info-circle mr-2"></i>
                            <small>Pesan akan dikirim sebagai notifikasi kepada user terkait komentar mereka.</small>
                        </div>
                        <div class="form-group mb-0">
                            <label for="message" class="font-weight-bold text-dark mb-2">
                                <i class="fas fa-edit mr-1"></i>Isi Pesan
                            </label>
                            <textarea name="message" class="form-control border" rows="5" required
                                placeholder="Tulis pesan Anda di sini...">Gunakan kalimat yang lebih sopan lagi.</textarea>
                            <small class="form-text text-muted">
                                <i class="fas fa-lightbulb mr-1"></i>Berikan feedback yang konstruktif dan sopan
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer border-0 bg-light">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times mr-1"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane mr-1"></i>Kirim Pesan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .table tbody tr {
            transition: all 0.2s ease;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
            transform: scale(1.001);
        }

        .btn-group .btn {
            border-radius: 0.25rem;
            margin: 0 2px;
        }

        .avatar-circle {
            font-weight: 600;
        }

        .card {
            transition: all 0.3s ease;
        }

        .modal-content {
            border-radius: 0.5rem;
            overflow: hidden;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #5568d3 0%, #66428a 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(102, 126, 234, 0.3);
        }

        .input-group-text {
            border: 1px solid #ced4da;
        }

        .badge-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>

    <script>
        function showMessageModal(commentId, userName) {
            document.getElementById('modalCommentId').value = commentId;
            var modal = new bootstrap.Modal(document.getElementById('messageModal'));
            modal.show();
        }

        // Initialize tooltips
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endsection
