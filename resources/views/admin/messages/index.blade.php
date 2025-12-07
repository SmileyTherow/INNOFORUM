@extends('layouts.admin.admin')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-primary">Pesan Masuk</h3>
            <div class="badge bg-primary rounded-pill px-3 py-2">
                Total: {{ $messages->total() }}
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="px-4">Pengirim</th>
                                <th class="px-4">Email</th>
                                <th class="px-4">Judul</th>
                                <th class="px-4">Tanggal</th>
                                <th class="px-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($messages as $m)
                                <tr class="@if (!$m->is_read) bg-light @endif"
                                    style="@if (!$m->is_read) border-left: 4px solid #0d6efd; @endif">
                                    <td class="px-4">
                                        <div class="d-flex align-items-center">
                                            @if (!$m->is_read)
                                                <span class="badge bg-primary me-2">Baru</span>
                                            @endif
                                            {{ $m->name }}
                                        </div>
                                    </td>
                                    <td class="px-4">{{ $m->email }}</td>
                                    <td class="px-4">
                                        <div class="text-truncate" style="max-width: 200px;" title="{{ $m->title }}">
                                            {{ $m->title }}
                                        </div>
                                    </td>
                                    <td class="px-4">
                                        <small class="text-muted">{{ $m->created_at->format('d M Y') }}</small>
                                        <br>
                                        <small class="text-muted">{{ $m->created_at->format('H:i') }}</small>
                                    </td>
                                    <td class="px-4">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('admin.messages.show', $m->id) }}"
                                                class="btn btn-sm btn-outline-primary rounded-pill px-3"
                                                title="Lihat Pesan">
                                                <i class="fas fa-eye me-1"></i> Lihat
                                            </a>

                                            <form action="{{ route('admin.messages.destroy', $m->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger rounded-pill px-3"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus pesan ini?')"
                                                    title="Hapus Pesan">
                                                    <i class="fas fa-trash me-1"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if ($messages->hasPages())
            <div class="d-flex justify-content-center mt-4">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        {{-- Previous Page Link --}}
                        @if ($messages->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">«</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $messages->previousPageUrl() }}" rel="prev">«</a>
                            </li>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach (range(1, $messages->lastPage()) as $i)
                            @if ($i == $messages->currentPage())
                                <li class="page-item active">
                                    <span class="page-link">{{ $i }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $messages->url($i) }}">{{ $i }}</a>
                                </li>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($messages->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $messages->nextPageUrl() }}" rel="next">»</a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link">»</span>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
        @endif
    </div>

    <style>
        .table th {
            border-top: none;
            font-weight: 600;
            color: #495057;
            padding-top: 1rem;
            padding-bottom: 1rem;
        }

        .table td {
            vertical-align: middle;
            padding-top: 1rem;
            padding-bottom: 1rem;
        }

        .card {
            border-radius: 12px;
        }

        .btn {
            font-size: 0.875rem;
        }

        .badge.rounded-pill {
            font-size: 0.75rem;
        }
    </style>
@endsection
