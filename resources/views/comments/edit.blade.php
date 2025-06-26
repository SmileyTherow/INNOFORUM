@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-transparent">
    <div class="bg-white/90 rounded-xl shadow-lg w-full max-w-lg px-8 py-8">
        <h2 class="text-2xl font-bold mb-6 text-blue-700 text-center">Edit Komentar</h2>
        <form action="{{ route('comments.update', $comment->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-5">
                <textarea class="w-full border border-gray-300 focus:border-blue-500 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200 transition" name="content" rows="4" required>{{ old('content', $comment->content) }}</textarea>
                @error('content')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
            </div>
            <div class="flex gap-3 justify-center">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-8 rounded-lg shadow transition">Update</button>
                <a href="{{ route('questions.show', $comment->question_id) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-8 rounded-lg shadow transition">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection