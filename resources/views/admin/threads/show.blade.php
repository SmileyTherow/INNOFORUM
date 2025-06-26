@extends('layouts.admin.admin')

@section('content')
<div class="container mt-4">
    <h2>{{ $thread->title }}</h2>
    <p><strong>User:</strong> {{ $thread->user->name ?? '-' }}</p>
    <p><strong>Kategori:</strong> {{ $thread->category->name ?? '-' }}</p>
    <p><strong>Status:</strong> {{ ucfirst($thread->status) }}</p>
    <p><strong>Isi Thread:</strong></p>
    <div>{{ $thread->body }}</div>
    <a href="{{ route('admin.threads.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection