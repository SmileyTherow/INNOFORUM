@extends('layouts.admin.admin')

@section('content')
<div class="container-fluid mt-4">
    <h2 class="mb-4 font-weight-bold text-primary">Daftar Pengumuman</h2>

    {{-- Form Kirim Pengumuman --}}
    <div class="card bg-light mb-4 shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-3">Kirim Pengumuman ke Semua User</h5>
            <form method="POST" action="{{ route('admin.announcements.store') }}">
                @csrf
                <div class="form-group mb-2">
                    <input type="text" name="title" class="form-control" placeholder="Judul Pengumuman" required>
                </div>
                <div class="form-group mb-2">
                    <textarea name="content" class="form-control" placeholder="Isi Pengumuman" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Kirim ke Semua User</button>
            </form>
            @if(session('success'))
                <div class="alert alert-success mt-2">{{ session('success') }}</div>
            @endif
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th width="30%">Judul</th>
                            <th>Isi</th>
                            <th width="120">Tanggal</th>
                            <th width="170">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($announcements as $ann)
                        <tr>
                            <td>{{ $ann->title }}</td>
                            <td>{{ Str::limit($ann->content, 50) }}</td>
                            <td>{{ $ann->created_at->format('d-m-Y') }}</td>
                            <td>
                                <a href="{{ route('admin.announcements.edit', $ann->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('admin.announcements.destroy', $ann->id) }}" method="POST" style="display:inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $announcements->links() }}
        </div>
    </div>
</div>
@endsection