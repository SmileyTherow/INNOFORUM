@extends('layouts.admin.admin')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="font-weight-bold text-primary">Thread Dilaporkan</h2>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th width="15%">Judul Thread</th>
                            <th width="20%">Isi Thread</th>
                            <th width="10%">Pembuat</th>
                            <th width="35%">Daftar Laporan</th>
                            <th width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reportedThreads as $thread)
                        <tr>
                            <td>
                                {{-- Link ke halaman thread publik/frontend --}}
                                <a href="{{ route('questions.show', $thread->id) }}"
                                    target="_blank"
                                    class="font-weight-bold text-info">
                                    {{ Str::limit($thread->title, 50) }}
                                </a>
                            </td>
                            <td>{{ Str::limit($thread->body, 70) }}</td>
                            <td>{{ $thread->user ? $thread->user->name : '-' }}</td>
                            <td>
                                <div class="accordion" id="reportsAccordion-{{ $thread->id }}">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading-{{ $thread->id }}">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapse-{{ $thread->id }}" aria-expanded="false"
                                                aria-controls="collapse-{{ $thread->id }}">
                                                Lihat Laporan ({{ $thread->reports->count() }})
                                            </button>
                                        </h2>
                                        <div id="collapse-{{ $thread->id }}" class="accordion-collapse collapse"
                                            aria-labelledby="heading-{{ $thread->id }}" data-bs-parent="#reportsAccordion-{{ $thread->id }}">
                                            <div class="accordion-body p-0">
                                                <ul class="list-group list-group-flush">
                                                    @foreach($thread->reports as $report)
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
                                <form action="{{ route('admin.threads.destroy', $thread->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin hapus thread ini?')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                                <button class="btn btn-warning btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#notifyModal-{{ $thread->id }}">
                                    <i class="fas fa-envelope"></i> Pesan
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">Tidak ada thread yang dilaporkan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $reportedThreads->links() }}
        </div>
    </div>
</div>

<!-- Modal Notifikasi -->
@foreach($reportedThreads as $thread)
<div class="modal fade" id="notifyModal-{{ $thread->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title">Kirim Pesan ke {{ $thread->user ? $thread->user->name : 'User' }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.threads.notify') }}" method="POST">
                @csrf
                <input type="hidden" name="thread_id" value="{{ $thread->id }}">
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