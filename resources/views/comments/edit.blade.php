@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-transparent">
    <div class="bg-gray-800 rounded-xl shadow-lg w-full max-w-lg px-8 py-8 border border-gray-700">
        <h2 class="text-2xl font-bold mb-6 text-blue-400 text-center">Edit Komentar</h2>
        <form action="{{ route('comments.update', $comment->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-5">
                <textarea class="w-full border border-gray-600 focus:border-blue-500 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500/30 transition bg-gray-700 text-white placeholder-gray-400" name="content" rows="4" required placeholder="Tulis komentar Anda...">{{ old('content', $comment->content) }}</textarea>
                @error('content')<div class="text-red-400 text-sm mt-1">{{ $message }}</div>@enderror
            </div>
            <div class="flex gap-3 justify-center">
                <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white font-bold py-2 px-8 rounded-lg shadow transition transform hover:scale-105">Update</button>
                <a href="{{ route('questions.show', $comment->question_id) }}" class="bg-gray-600 hover:bg-gray-500 text-white font-semibold py-2 px-8 rounded-lg shadow transition transform hover:scale-105">Batal</a>
            </div>
        </form>
    </div>
</div>

<style>
/* MEMASTIKAN BACKGROUND HALAMAN TETAP GELAP */
body {
    background-color: #111827 !important;
    color: #e5e7eb !important;
}

/* Override untuk semua elemen container */
.bg-white, .bg-gray-50, .bg-gray-100 {
    background-color: #1f2937 !important;
}

/* Untuk card/container spesifik */
.bg-gray-800 {
    background-color: #1f2937 !important;
}

.bg-gray-700 {
    background-color: #374151 !important;
}

.border-gray-700 {
    border-color: #374151 !important;
}

.border-gray-600 {
    border-color: #4b5563 !important;
}

/* Text colors */
.text-gray-800, .text-gray-700, .text-gray-600 {
    color: #e5e7eb !important;
}

/* Shadow adjustments */
.shadow-lg {
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3), 0 4px 6px -2px rgba(0, 0, 0, 0.2) !important;
}

/* Override khusus untuk mode light */
@media (prefers-color-scheme: light) {
    body {
        background-color: #111827 !important;
        color: #e5e7eb !important;
    }

    .bg-white {
        background-color: #1f2937 !important;
    }

    /* Memastikan input tetap gelap */
    textarea {
        background-color: #374151 !important;
        color: #e5e7eb !important;
        border-color: #4b5563 !important;
    }

    textarea::placeholder {
        color: #9ca3af !important;
    }
}

/* Transisi smooth */
.transition {
    transition: all 0.2s ease;
}

.transform {
    transition: transform 0.2s ease;
}
</style>
@endsection
