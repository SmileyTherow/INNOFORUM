@extends('layouts.admin.admin')

@section('content')
<h2>Tambah Pengumuman</h2>
<form action="{{ route('admin.announcements.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-2">
        <label for="title">Judul Pengumuman</label>
        <input type="text" name="title" class="form-control" required>
    </div>
    <div class="mb-2">
        <label for="content">Isi Pengumuman</label>
        <textarea name="content" class="form-control" required></textarea>
    </div>
    <div class="mb-2">
        <label for="file">File/Gambar (opsional)</label>
        <input type="file" name="file" class="form-control">
    </div>
    <button class="btn btn-primary" type="submit">Simpan</button>
</form>
@endsection