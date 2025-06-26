@extends('layouts.admin.admin')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="font-weight-bold text-primary">Komentar Dilaporkan</h2>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th width="20%">Isi Komentar</th>
                            <th width="15%">User Pembuat</th>
                            <th width="15%">Thread</th>
                            <th width="30%">Daftar Laporan</th>
                            <th width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reportedComments as $comment)
                        <tr>
                            <td>{{ Str::limit($comment->content, 100) }}</td>
                            <td>
                                @if($comment->user)
                                    <a href="{{ route('admin.users.show', $comment->user->id) }}" class="text-primary">
                                        {{ $comment->user->name }}
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if($comment->question)
                                    {{-- Link ke halaman thread publik/frontend --}}
                                    <a href="{{ route('questions.show', $comment->question->id) }}"
                                        target="_blank"
                                        class="font-weight-bold text-info">
                                        {{ Str::limit($comment->question->title, 50) }}
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <div class="accordion" id="reportsAccordion-{{ $comment->id }}">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading-{{ $comment->id }}">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapse-{{ $comment->id }}" aria-expanded="false"
                                                aria-controls="collapse-{{ $comment->id }}">
                                                Lihat Laporan ({{ $comment->reports->count() }})
                                            </button>
                                        </h2>
                                        <div id="collapse-{{ $comment->id }}" class="accordion-collapse collapse"
                                            aria-labelledby="heading-{{ $comment->id }}" data-bs-parent="#reportsAccordion-{{ $comment->id }}">
                                            <div class="accordion-body p-0">
                                                <ul class="list-group list-group-flush">
                                                    @foreach($comment->reports as $report)
                                                    <li class="list-group-item small">
                                                        <div class="d-flex justify-content-between">
                                                            <span class="fw-bold">{{ $report->reporter ? $report->reporter->name : 'Anonim' }}</span>
                                                            <span class="text-muted">{{ $report->created_at->diffForHumans() }}</span>
                                                        </div>
                                                        <div class="mt-1">
                                                            <span class="badge bg-warning text-dark">{{ $report->reason }}</span>
                                                        </div>
                                                        <p class="mt-1 mb-0">{{ $report->description ?? 'Tidak ada deskripsi tambahan' }}</p>
                                                    </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="d-flex flex-wrap" style="gap: 5px;">
                                <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" 
                                        onclick="return confirm('Yakin hapus komentar ini?')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                                
                                <button class="btn btn-warning btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#notifyModal-{{ $comment->id }}">
                                    <i class="fas fa-envelope"></i> Pesan
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">Tidak ada komentar yang dilaporkan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $reportedComments->links() }}
        </div>
    </div>
</div>

<!-- Modal Notifikasi -->
@foreach($reportedComments as $comment)
<div class="modal fade" id="notifyModal-{{ $comment->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title">Kirim Pesan ke {{ $comment->user ? $comment->user->name : 'User' }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.comments.notify') }}" method="POST">
                @csrf
                <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Pesan</label>
                        <textarea name="message" class="form-control" rows="4" required
                            placeholder="Beritahu user tentang tindakan yang diambil..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning">Kirim Pesan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection