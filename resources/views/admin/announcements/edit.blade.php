@extends('layouts.admin.admin')

@section('content')
<h2>Edit Pengumuman</h2>
<form action="{{ route('admin.announcements.update', $announcement->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-2">
        <label for="title">Judul Pengumuman</label>
        <input type="text" name="title" class="form-control" value="{{ $announcement->title }}" required>
    </div>
    <div class="mb-2">
        <label for="content">Isi Pengumuman</label>
        <textarea name="content" class="form-control" required>{{ $announcement->content }}</textarea>
    </div>
    <div class="mb-2">
        <label for="file">File/Gambar (opsional)</label>
        <input type="file" name="file" class="form-control">
        @if($announcement->file)
        <div class="mt-2">
            <a href="{{ asset('storage/'.$announcement->file) }}" target="_blank">File saat ini</a>
        </div>
        @endif
    </div>
    <button class="btn btn-primary" type="submit">Update</button>
</form>
@endsection