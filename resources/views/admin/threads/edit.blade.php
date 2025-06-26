@extends('layouts.admin.admin')

@section('content')
<div class="container mt-4">
    <h2>Edit Thread</h2>
    <form action="{{ route('admin.threads.update', $thread->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Judul</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $thread->title) }}" required>
        </div>
        <div class="form-group">
            <label>Kategori</label>
            <select name="category_id" class="form-control" required>
                <option value="" disabled>Pilih Kategori</option>
                @foreach(\App\Models\Category::all() as $cat)
                    <option value="{{ $cat->id }}" {{ $thread->category_id == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Isi Thread</label>
            <textarea name="body" class="form-control" rows="6" required>{{ old('body', $thread->body) }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('admin.threads.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection