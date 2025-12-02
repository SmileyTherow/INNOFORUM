@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $question->title }}</h1>
        <p>{{ $question->content }}</p>
        <small class="text-muted">Oleh {{ $question->user->name }} - {{ $question->created_at->diffForHumans() }}</small>
        <hr>
        @if ($question->images)
            <div class="mb-3 flex flex-wrap gap-3">
                @foreach ($question->images as $img)
                    <img src="{{ asset('storage/question_images/' . $img) }}" style="max-width:220px;max-height:160px;"
                        class="rounded shadow border">
                @endforeach
            </div>
        @endif

        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Kembali</a>

        @if ($question->hashtags->isNotEmpty())
            <p><strong>Hashtags:</strong>
                @foreach ($question->hashtags as $hashtag)
                    <span class="badge bg-primary">{{ $hashtag->name }}</span>
                @endforeach
            </p>
        @endif

        <h2>Komentar</h2>
        @foreach ($question->comments as $comment)
            <div id="comment-{{ $comment->id }}" class="comment-item">
                <div class="mb-3">
                    <strong>{{ $comment->user->name }}</strong>
                    <p>{{ $comment->content }}</p>
                    @if ($comment->image)
                        <img src="{{ asset('storage/comment_images/' . $comment->image) }}"
                            style="max-width:180px;max-height:120px;" class="rounded shadow border">
                    @endif
                    <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                </div>
            </div>
        @endforeach

        <form action="{{ route('comments.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="content" class="form-label">Tulis Komentar</label>
                <textarea name="content" class="form-control" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label>Lampirkan Gambar (opsional):</label>
                <input type="file" name="image" class="form-control" accept="image/*">
                @error('image')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <input type="hidden" name="question_id" value="{{ $question->id }}">
            <button type="submit" class="btn btn-primary">Kirim</button>
        </form>
    </div>
@endsection
