@extends('layouts.admin.admin')

@section('content')
    <div class="container-fluid mt-4">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-1 font-weight-bold text-dark">
                    <i class="fas fa-flag mr-2 text-danger"></i>Pertanyaan Dilaporkan
                </h2>
                <p class="text-muted mb-0">Kelola laporan pertanyaan dari pengguna</p>
            </div>
            <div class="text-right">
                <span class="badge badge-danger badge-pill px-3 py-2" style="font-size: 0.9rem;">
                    <i class="fas fa-exclamation-triangle mr-1"></i>{{ $reportedThreads->total() }} Laporan
                </span>
            </div>
        </div>

        <!-- Alert Info -->
        @if ($reportedThreads->count() > 0)
            <div class="alert alert-warning border-0 shadow-sm mb-4"
                style="background: linear-gradient(135deg, #fff3cd 0%, #ffe69c 100%);">
                <div class="d-flex align-items-center">
                    <i class="fas fa-info-circle fa-2x mr-3 text-warning"></i>
                    <div>
                        <h6 class="mb-1 font-weight-bold">Perhatian!</h6>
                        <p class="mb-0 small">Terdapat {{ $reportedThreads->total() }} pertanyaan yang dilaporkan dan
                            memerlukan tindakan Anda.</p>
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
                                <th class="border-0 text-uppercase small font-weight-bold" width="18%">
                                    <i class="fas fa-heading mr-1 text-primary"></i>Judul Pertanyaan
                                </th>
                                <th class="border-0 text-uppercase small font-weight-bold" width="22%">
                                    <i class="fas fa-align-left mr-1 text-primary"></i>Isi Pertanyaan
                                </th>
                                <th class="border-0 text-uppercase small font-weight-bold" width="12%">
                                    <i class="fas fa-user mr-1 text-primary"></i>Pembuat
                                </th>
                                <th class="border-0 text-uppercase small font-weight-bold" width="30%">
                                    <i class="fas fa-list-ul mr-1 text-primary"></i>Daftar Laporan
                                </th>
                                <th class="border-0 text-uppercase small font-weight-bold text-center" width="18%">
                                    <i class="fas fa-cog mr-1 text-primary"></i>Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reportedThreads as $thread)
                                <tr class="border-bottom">
                                    <td class="align-middle">
                                        <a href="{{ route('questions.show', $thread->id) }}" target="_blank"
                                            class="text-decoration-none">
                                            <div class="font-weight-bold text-primary mb-1" style="font-size: 0.9rem;">
                                                <i
                                                    class="fas fa-external-link-alt mr-1 small"></i>{{ Str::limit($thread->title, 50) }}
                                            </div>
                                        </a>
                                    </td>
                                    <td class="align-middle">
                                        <p class="mb-0 text-muted small">{{ Str::limit($thread->body, 70) }}</p>
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle bg-info text-white mr-2 d-flex align-items-center justify-content-center"
                                                style="width: 35px; height: 35px; border-radius: 50%; font-size: 0.85rem;">
                                                {{ strtoupper(substr($thread->user ? $thread->user->name : 'U', 0, 1)) }}
                                            </div>
                                            <span
                                                class="font-weight-medium small">{{ $thread->user ? $thread->user->name : '-' }}</span>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <div class="accordion" id="reportsAccordion-{{ $thread->id }}">
                                            <div class="accordion-item border rounded">
                                                <h2 class="accordion-header" id="heading-{{ $thread->id }}">
                                                    <button class="accordion-button collapsed bg-light" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#collapse-{{ $thread->id }}" aria-expanded="false"
                                                        aria-controls="collapse-{{ $thread->id }}"
                                                        style="font-size: 0.85rem; padding: 0.5rem 0.75rem;">
                                                        <i class="fas fa-flag mr-2 text-danger"></i>
                                                        <span class="font-weight-bold">Lihat Laporan</span>
                                                        <span
                                                            class="badge badge-danger ml-2">{{ $thread->reports->count() }}</span>
                                                    </button>
                                                </h2>
                                                <div id="collapse-{{ $thread->id }}" class="accordion-collapse collapse"
                                                    aria-labelledby="heading-{{ $thread->id }}"
                                                    data-bs-parent="#reportsAccordion-{{ $thread->id }}">
                                                    <div class="accordion-body p-0">
                                                        <ul class="list-group list-group-flush">
                                                            @foreach ($thread->reports as $report)
                                                                <li class="list-group-item small py-2">
                                                                    <div
                                                                        class="d-flex justify-content-between align-items-start mb-2">
                                                                        <div class="d-flex align-items-center">
                                                                            <div class="avatar-mini bg-secondary text-white mr-2 d-flex align-items-center justify-content-center"
                                                                                style="width: 24px; height: 24px; border-radius: 50%; font-size: 0.7rem;">
                                                                                {{ strtoupper(substr($report->reporter ? $report->reporter->name : 'A', 0, 1)) }}
                                                                            </div>
                                                                            <span
                                                                                class="font-weight-bold">{{ $report->reporter ? $report->reporter->name : 'Anonim' }}</span>
                                                                        </div>
                                                                        <span class="text-muted"
                                                                            style="font-size: 0.75rem;">
                                                                            <i
                                                                                class="far fa-clock mr-1"></i>{{ $report->created_at->diffForHumans() }}
                                                                        </span>
                                                                    </div>
                                                                    <div class="mb-2">
                                                                        <span class="badge badge-warning text-dark">
                                                                            <i
                                                                                class="fas fa-exclamation-circle mr-1"></i>{{ $report->reason }}
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
                                        <div class="btn-group-vertical" style="gap: 5px;">
                                            <button class="btn btn-sm btn-warning text-white" data-bs-toggle="modal"
                                                data-bs-target="#notifyModal-{{ $thread->id }}"
                                                style="min-width: 120px;">
                                                <i class="fas fa-envelope mr-1"></i>Kirim Pesan
                                            </button>
                                            <form action="{{ route('admin.threads.destroy', $thread->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Yakin hapus thread ini?')"
                                                    style="min-width: 120px;">
                                                    <i class="fas fa-trash mr-1"></i>Hapus Thread
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fas fa-check-circle fa-3x mb-3 d-block text-success"
                                                style="opacity: 0.3;"></i>
                                            <h5 class="font-weight-normal">Tidak ada pertanyaan yang dilaporkan</h5>
                                            <p class="small mb-0">Semua pertanyaan dalam kondisi baik</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($reportedThreads->hasPages())
                <div class="card-footer bg-white border-top">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            Menampilkan {{ $reportedThreads->firstItem() }} - {{ $reportedThreads->lastItem() }} dari
                            {{ $reportedThreads->total() }} laporan
                        </div>
                        <div>
                            {{ $reportedThreads->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Notifikasi -->
    @foreach ($reportedThreads as $thread)
        <div class="modal fade" id="notifyModal-{{ $thread->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header text-white border-0"
                        style="background: linear-gradient(135deg, #f6ad55 0%, #ed8936 100%);">
                        <h5 class="modal-title font-weight-bold">
                            <i class="fas fa-paper-plane mr-2"></i>Kirim Pesan ke
                            {{ $thread->user ? $thread->user->name : 'User' }}
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form action="{{ route('admin.threads.notify') }}" method="POST">
                        @csrf
                        <input type="hidden" name="thread_id" value="{{ $thread->id }}">
                        <div class="modal-body p-4">
                            <!-- Thread Info -->
                            <div class="alert alert-light border mb-3">
                                <div class="small text-muted mb-1">Pertanyaan:</div>
                                <div class="font-weight-bold text-dark">{{ Str::limit($thread->title, 80) }}</div>
                            </div>

                            <!-- Report Summary -->
                            <div class="alert alert-warning border-0 mb-3" style="background-color: #fff3cd;">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-exclamation-triangle mr-2"></i>
                                    <small>Pertanyaan ini telah dilaporkan <strong>{{ $thread->reports->count() }}
                                            kali</strong></small>
                                </div>
                            </div>

                            <div class="form-group mb-0">
                                <label class="font-weight-bold text-dark mb-2">
                                    <i class="fas fa-edit mr-1"></i>Isi Pesan
                                </label>
                                <textarea name="message" class="form-control border" rows="5" required
                                    placeholder="Beritahu user tentang tindakan yang diambil..."></textarea>
                                <small class="form-text text-muted">
                                    <i class="fas fa-lightbulb mr-1"></i>Jelaskan alasan dan tindakan yang diambil dengan
                                    jelas
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
            border-color: rgba(0, 0, 0, .125);
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

        .avatar-circle,
        .avatar-mini {
            font-weight: 600;
            flex-shrink: 0;
        }

        .btn-group-vertical .btn {
            border-radius: 0.25rem !important;
            margin-bottom: 5px;
        }

        .btn-warning {
            background: linear-gradient(135deg, #f6ad55 0%, #ed8936 100%);
            border: none;
        }

        .btn-warning:hover {
            background: linear-gradient(135deg, #ed8936 0%, #dd6b20 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(237, 137, 54, 0.3);
        }

        .btn-danger {
            background: linear-gradient(135deg, #fc8181 0%, #f56565 100%);
            border: none;
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(245, 101, 101, 0.3);
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
    </style>

    <script>
        // Initialize Bootstrap tooltips if needed
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
@endsection
