@extends('layouts.admin.admin')

@section('content')
<div class="container-fluid mt-4">
    <h2 class="mb-4 font-weight-bold text-primary">Daftar Semua Thread</h2>
    <form method="GET" action="{{ route('admin.threads.index') }}" class="mb-3 d-flex" style="gap: 10px;">
        <input type="text" name="q" class="form-control" placeholder="Cari thread (judul/user)" value="{{ request('q') }}">
        <button type="submit" class="btn btn-primary">Cari</button>
    </form>
    <div class="card shadow mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Judul & Isi</th>
                            <th>User</th>
                            <th>Status</th>
                            <th>Tanggal Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($threads as $thread)
                            <tr>
                                <td>
                                    <span class="font-weight-bold">{{ $thread->title }}</span>
                                    <div class="text-muted small">
                                        {{ Str::limit($thread->content ?? '-', 60) }}
                                    </div>
                                </td>
                                <td>{{ $thread->user->name ?? '-' }}</td>
                                <td>
                                    @if($thread->status === 'pending')
                                        <span class="badge badge-warning">Pending</span>
                                    @elseif($thread->status === 'approved')
                                        <span class="badge badge-success">Approved</span>
                                    @else
                                        <span class="badge badge-secondary">{{ ucfirst($thread->status) }}</span>
                                    @endif
                                </td>
                                <td>{{ $thread->created_at->format('d-m-Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.threads.show', $thread->id) }}" class="btn btn-info btn-sm">Detail</a>
                                    <a href="{{ route('admin.threads.edit', $thread->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                    <form action="{{ route('admin.threads.destroy', $thread->id) }}" method="POST" style="display:inline">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('Yakin hapus thread ini?')" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                    <button class="btn btn-warning btn-sm" onclick="showThreadMessageModal('{{ $thread->id }}', '{{ $thread->user->name }}')">Pesan</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">Tidak ada thread ditemukan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $threads->appends(request()->query())->links() }}
        </div>
    </div>
</div>

<!-- Modal Kirim Pesan ke User Thread -->
<div class="modal fade" id="threadMessageModal" tabindex="-1" aria-labelledby="threadMessageModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="threadMessageForm" method="POST" action="{{ route('admin.threads.notify') }}">
                @csrf
                <input type="hidden" name="thread_id" id="modalThreadId">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="threadMessageModalLabel">Kirim Pesan ke User Thread</h5>
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
function showThreadMessageModal(threadId, userName) {
    document.getElementById('modalThreadId').value = threadId;
    var modal = new bootstrap.Modal(document.getElementById('threadMessageModal'));
    modal.show();
}
</script>
@endsection