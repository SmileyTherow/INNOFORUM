@extends('layouts.admin.admin')

@section('content')
<div class="container-fluid mt-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1 font-weight-bold text-dark">
                <i class="fas fa-comment-slash mr-2 text-danger"></i>Komentar Dilaporkan
            </h2>
            <p class="text-muted mb-0">Kelola laporan komentar dari pengguna</p>
        </div>
        <div class="text-right">
            <span class="badge badge-danger badge-pill px-3 py-2" style="font-size: 0.9rem;">
                <i class="fas fa-exclamation-triangle mr-1"></i>{{ $reportedComments->total() }} Laporan
            </span>
        </div>
    </div>

    <!-- Alert Info -->
    @if($reportedComments->count() > 0)
    <div class="alert alert-warning border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, #fff3cd 0%, #ffe69c 100%);">
        <div class="d-flex align-items-center">
            <i class="fas fa-info-circle fa-2x mr-3 text-warning"></i>
            <div>
                <h6 class="mb-1 font-weight-bold">Perhatian!</h6>
                <p class="mb-0 small">Terdapat {{ $reportedComments->total() }} komentar yang dilaporkan dan memerlukan tindakan Anda.</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Table Section -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 text-uppercase small font-weight-bold" width="25%">
                                <i class="fas fa-comment-dots mr-1 text-primary"></i>Isi Komentar
                            </th>
                            <th class="border-0 text-uppercase small font-weight-bold" width="12%">
                                <i class="fas fa-user mr-1 text-primary"></i>Pembuat
                            </th>
                            <th class="border-0 text-uppercase small font-weight-bold" width="18%">
                                <i class="fas fa-question-circle mr-1 text-primary"></i>Pertanyaan
                            </th>
                            <th class="border-0 text-uppercase small font-weight-bold" width="27%">
                                <i class="fas fa-list-ul mr-1 text-primary"></i>Daftar Laporan
                            </th>
                            <th class="border-0 text-uppercase small font-weight-bold text-center" width="18%">
                                <i class="fas fa-cog mr-1 text-primary"></i>Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reportedComments as $comment)
                        <tr class="border-bottom">
                            <td class="align-middle">
                                <div class="text-dark" style="font-size: 0.9rem;">
                                    {{ Str::limit($comment->content, 100) }}
                                </div>
                                <div class="text-muted small mt-1">
                                    <i class="far fa-clock mr-1"></i>{{ $comment->created_at->format('d M Y, H:i') }}
                                </div>
                            </td>
                            <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle bg-info text-white mr-2 d-flex align-items-center justify-content-center"
                                         style="width: 35px; height: 35px; border-radius: 50%; font-size: 0.85rem;">
                                        {{ strtoupper(substr($comment->user ? $comment->user->name : 'U', 0, 1)) }}
                                    </div>
                                    <span class="font-weight-medium small">{{ $comment->user ? $comment->user->name : '-' }}</span>
                                </div>
                            </td>
                            <td class="align-middle">
                                <a href="{{ route('questions.show', $comment->question->id) }}"
                                   target="_blank"
                                   class="text-decoration-none">
                                    <div class="font-weight-bold text-primary mb-1" style="font-size: 0.85rem;">
                                        <i class="fas fa-external-link-alt mr-1 small"></i>{{ Str::limit($comment->question->title ?? '-', 40) }}
                                    </div>
                                </a>
                                <div class="text-muted small">
                                    {{ Str::limit($comment->question->content ?? '-', 50) }}
                                </div>
                            </td>
                            <td class="align-middle">
                                <div class="accordion" id="reportsAccordion-{{ $comment->id }}">
                                    <div class="accordion-item border rounded">
                                        <h2 class="accordion-header" id="heading-{{ $comment->id }}">
                                            <button class="accordion-button collapsed bg-light" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapse-{{ $comment->id }}" aria-expanded="false"
                                                aria-controls="collapse-{{ $comment->id }}"
                                                style="font-size: 0.85rem; padding: 0.5rem 0.75rem;">
                                                <i class="fas fa-flag mr-2 text-danger"></i>
                                                <span class="font-weight-bold">Lihat Laporan</span>
                                                <span class="badge badge-danger ml-2">{{ $comment->reports->count() }}</span>
                                            </button>
                                        </h2>
                                        <div id="collapse-{{ $comment->id }}" class="accordion-collapse collapse"
                                            aria-labelledby="heading-{{ $comment->id }}" data-bs-parent="#reportsAccordion-{{ $comment->id }}">
                                            <div class="accordion-body p-0">
                                                <ul class="list-group list-group-flush">
                                                    @foreach($comment->reports as $report)
                                                    <li class="list-group-item small py-2">
                                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar-mini bg-secondary text-white mr-2 d-flex align-items-center justify-content-center"
                                                                     style="width: 24px; height: 24px; border-radius: 50%; font-size: 0.7rem;">
                                                                    {{ strtoupper(substr($report->reporter ? $report->reporter->name : 'A', 0, 1)) }}
                                                                </div>
                                                                <span class="font-weight-bold">{{ $report->reporter ? $report->reporter->name : 'Anonim' }}</span>
                                                            </div>
                                                            <span class="text-muted" style="font-size: 0.75rem;">
                                                                <i class="far fa-clock mr-1"></i>{{ $report->created_at->diffForHumans() }}
                                                            </span>
                                                        </div>
                                                        <div class="mb-2">
                                                            <span class="badge badge-warning text-dark">
                                                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $report->reason }}
                                                            </span>
                                                        </div>
                                                        <p class="mb-0 text-muted" style="font-size: 0.8rem;">
                                                            <i class="fas fa-quote-left mr-1"></i>
                                                            {{ $report->description ?? 'Tidak ada deskripsi tambahan' }}
                                                        </p>
                                                    </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle text-center">
                                <div class="d-flex flex-column align-items-center" style="gap: 8px;">
                                    <button class="btn btn-sm btn-warning text-white w-100"
                                        data-bs-toggle="modal"
                                        data-bs-target="#notifyModal-{{ $comment->id }}"
                                        style="min-width: 130px;">
                                        <i class="fas fa-envelope mr-1"></i>Kirim Pesan
                                    </button>
                                    <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="POST" class="w-100">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger w-100"
                                            onclick="return confirm('Yakin hapus komentar ini?')"
                                            style="min-width: 130px;">
                                            <i class="fas fa-trash mr-1"></i>Hapus Komentar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-check-circle fa-3x mb-3 d-block text-success" style="opacity: 0.3;"></i>
                                    <h5 class="font-weight-normal">Tidak ada komentar yang dilaporkan</h5>
                                    <p class="small mb-0">Semua komentar dalam kondisi baik</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($reportedComments->hasPages())
        <div class="card-footer bg-white border-top">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted small">
                    Menampilkan {{ $reportedComments->firstItem() }} - {{ $reportedComments->lastItem() }} dari {{ $reportedComments->total() }} laporan
                </div>
                <div>
                    {{ $reportedComments->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Modal Notifikasi -->
@foreach($reportedComments as $comment)
<div class="modal fade" id="notifyModal-{{ $comment->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header text-white border-0" style="background: linear-gradient(135deg, #f6ad55 0%, #ed8936 100%);">
                <h5 class="modal-title font-weight-bold">
                    <i class="fas fa-paper-plane mr-2"></i>Kirim Pesan ke {{ $comment->user ? $comment->user->name : 'User' }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.comments.notify') }}" method="POST">
                @csrf
                <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                <div class="modal-body p-4">
                    <!-- Comment Info -->
                    <div class="alert alert-light border mb-3">
                        <div class="small text-muted mb-1">Komentar:</div>
                        <div class="text-dark">{{ Str::limit($comment->content, 120) }}</div>
                    </div>

                    <!-- Question Info -->
                    <div class="alert alert-info border-0 mb-3" style="background-color: #e3f2fd;">
                        <div class="small text-muted mb-1">Pada Pertanyaan:</div>
                        <div class="font-weight-bold text-dark">{{ Str::limit($comment->question->title ?? '-', 80) }}</div>
                    </div>

                    <!-- Report Summary -->
                    <div class="alert alert-warning border-0 mb-3" style="background-color: #fff3cd;">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            <small>Komentar ini telah dilaporkan <strong>{{ $comment->reports->count() }} kali</strong></small>
                        </div>
                    </div>

                    <div class="form-group mb-0">
                        <label class="font-weight-bold text-dark mb-2">
                            <i class="fas fa-edit mr-1"></i>Isi Pesan
                        </label>
                        <textarea name="message" class="form-control border" rows="5" required
                            placeholder="Beritahu user tentang tindakan yang diambil...">Gunakan kalimat yang lebih sopan lagi.</textarea>
                        <small class="form-text text-muted">
                            <i class="fas fa-lightbulb mr-1"></i>Jelaskan alasan dan tindakan yang diambil dengan jelas
                        </small>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
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
@endforeach

<style>
.accordion-button:not(.collapsed) {
    background-color: #fff3cd !important;
    color: #856404;
}

.accordion-button:focus {
    box-shadow: none;
    border-color: rgba(0,0,0,.125);
}

.accordion-button::after {
    margin-left: auto;
}

.table tbody tr {
    transition: all 0.2s ease;
}

.table tbody tr:hover {
    background-color: #f8f9fa;
    transform: scale(1.001);
}

.avatar-circle, .avatar-mini {
    font-weight: 600;
    flex-shrink: 0;
}

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

.btn-danger {
    background: linear-gradient(135deg, #fc8181 0%, #f56565 100%);
    border: none;
    transition: all 0.3s ease;
}

.btn-danger:hover {
    background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(245, 101, 101, 0.4);
}

.badge-danger {
    background: linear-gradient(135deg, #fc8181 0%, #f56565 100%);
}

.modal-content {
    border-radius: 0.5rem;
    overflow: hidden;
}

.form-control:focus {
    border-color: #f6ad55;
    box-shadow: 0 0 0 0.2rem rgba(246, 173, 85, 0.25);
}

.accordion-item {
    transition: all 0.2s ease;
}

.list-group-item {
    transition: background-color 0.2s ease;
}

.list-group-item:hover {
    background-color: #f8f9fa;
}

.alert {
    border-radius: 0.5rem;
}

/* Custom Scrollbar for Accordion */
.accordion-body {
    max-height: 300px;
    overflow-y: auto;
}

.accordion-body::-webkit-scrollbar {
    width: 6px;
}

.accordion-body::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.accordion-body::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 10px;
}

.accordion-body::-webkit-scrollbar-thumb:hover {
    background: #555;
}
</style>

<script>
// Initialize Bootstrap tooltips if needed
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endsection
