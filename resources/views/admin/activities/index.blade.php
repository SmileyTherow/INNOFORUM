@extends('layouts.admin.admin')

@section('content')
<div class="container-fluid px-4">
    <h1 class="h3 mb-3">Aktivitas Admin</h1>

    <form method="GET" class="row g-2 mb-3">
        <div class="col-auto">
            <select name="admin_id" class="form-select">
                <option value="">Semua Admin</option>
                @foreach($admins as $a)
                    <option value="{{ $a->id }}" @selected(request('admin_id') == $a->id)>{{ $a->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-auto">
            <select name="action" class="form-select">
                <option value="">Semua Aksi</option>
                @foreach($actions as $act)
                    <option value="{{ $act }}" @selected(request('action') == $act)>{{ $act }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-auto">
            <input type="text" name="q" class="form-control" placeholder="Cari..." value="{{ request('q') }}">
        </div>
        <div class="col-auto">
            <button class="btn btn-primary">Filter</button>
        </div>
    </form>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Waktu</th>
                            <th>Admin</th>
                            <th>Aksi</th>
                            <th>Target</th>
                            <th>Deskripsi</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($activities as $act)
                        <tr>
                            <td>{{ $act->created_at->format('Y-m-d H:i') }}</td>
                            <td>{{ $act->admin_name }}</td>
                            <td>{{ $act->action }}</td>
                            <td>
                                @if($act->subject_type && $act->subject_id)
                                    {{-- coba buat link ke resource bila mungkin --}}
                                    @php
                                        $link = null;
                                        if ($act->subject_type === 'Comment') $link = route('questions.show', $act->subject_id ?? 0) . '#comment-' . $act->subject_id;
                                        if ($act->subject_type === 'Question') $link = route('questions.show', $act->subject_id);
                                        if ($act->subject_type === 'Conversation') $link = route('pesan.index') . '?conv=' . $act->subject_id;
                                        if ($act->subject_type === 'Announcement') $link = route('admin.announcements.index');
                                    @endphp
                                    @if($link)
                                        <a href="{{ $link }}" target="_blank">{{ $act->subject_type }} #{{ $act->subject_id }}</a>
                                    @else
                                        {{ $act->subject_type }} #{{ $act->subject_id }}
                                    @endif
                                @endif
                            </td>
                            <td style="max-width:40ch; overflow:hidden; text-overflow:ellipsis;">
                                {{ $act->description }}
                            </td>
                            <td>
                                <a class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" href="#actModal{{ $act->id }}">Detail</a>

                                <!-- Modal -->
                                <div class="modal fade" id="actModal{{ $act->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                        <div class="modal-content bg-dark text-white">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Detail Aktivitas #{{ $act->id }}</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Waktu:</strong> {{ $act->created_at }}</p>
                                                <p><strong>Admin:</strong> {{ $act->admin_name }}</p>
                                                <p><strong>Aksi:</strong> {{ $act->action }}</p>
                                                <p><strong>Deskripsi:</strong> {{ $act->description }}</p>
                                                <p><strong>Metadata:</strong></p>
                                                <pre class="small bg-black p-2 rounded">{{ json_encode($act->metadata, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) }}</pre>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada aktivitas</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-3">
                {{ $activities->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
