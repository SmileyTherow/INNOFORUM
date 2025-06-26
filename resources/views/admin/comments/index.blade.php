@extends('layouts.admin.admin')

@section('content')
<div class="container-fluid mt-4">
    <h2 class="mb-4 font-weight-bold text-primary">Daftar Semua Komentar</h2>
    
    <form method="GET" action="{{ route('admin.comments.index') }}" class="mb-3 d-flex" style="gap: 10px;">
        <input type="text" name="q" class="form-control" placeholder="Cari komentar (isi/user)" value="{{ request('q') }}">
        <button type="submit" class="btn btn-primary">Cari</button>
    </form>
    
    <div class="card shadow mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Isi Komentar</th>
                            <th>User</th>
                            <th>Pertanyaan</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($comments as $comment)
                            <tr>
                                <td>{{ Str::limit($comment->content, 100) }}</td>
                                <td>{{ $comment->user->name ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('questions.show', $comment->question->id) }}" target="_blank" class="font-weight-bold text-primary">
                                        {{ $comment->question->title ?? '-' }}
                                    </a>
                                    <div class="text-muted small">
                                        {{ Str::limit($comment->question->content ?? '-', 60) }}
                                    </div>
                                </td>
                                <td>{{ $comment->created_at->format('d-m-Y H:i') }}</td>
                                <td class="d-flex" style="gap: 5px;">
                                    <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('Yakin hapus komentar ini?')" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                    <button class="btn btn-warning btn-sm" onclick="showMessageModal('{{ $comment->id }}', '{{ $comment->user->name }}')">Pesan</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">Tidak ada komentar ditemukan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $comments->appends(request()->query())->links() }}
        </div>
    </div>
</div>

<!-- Modal Kirim Pesan Notifikasi -->
<div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="messageForm" method="POST" action="{{ route('admin.comments.notify') }}">
                @csrf
                <input type="hidden" name="comment_id" id="modalCommentId" value="">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="messageModalLabel">Kirim Pesan ke User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="message" class="font-weight-bold">Pesan</label>
                        <textarea name="message" class="form-control" rows="5" required>Gunakan kalimat yang lebih sopan lagi.</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function showMessageModal(commentId, userName) {
    document.getElementById('modalCommentId').value = commentId;
    var modal = new bootstrap.Modal(document.getElementById('messageModal'));
    modal.show();
}
</script>
@endsection