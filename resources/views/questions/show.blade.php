@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <!-- Header Pertanyaan -->
    <div class="bg-gray-800 rounded-lg shadow-lg p-6 mb-6 border border-gray-700">
        <h1 class="text-3xl font-bold text-white mb-2">{{ $question->title }}</h1>
        <div class="flex items-center text-sm text-gray-300 mb-4">
            <span>
                <span class="inline-block px-2 py-1 bg-blue-500/20 text-blue-300 rounded-full font-semibold text-xs border border-blue-500/30">
                    {{ $question->category->name ?? '-' }}
                </span>
            </span>
            <span class="mx-2">•</span>
            <span>
                Oleh:
                @include('components.user-mini-profile', ['user' => $question->user])
            </span>
            <span class="mx-2">•</span>
            <span>{{ $question->created_at->diffForHumans() }}</span>
        </div>

        <div class="prose max-w-none text-gray-300 mb-6">
            {{ $question->content }}
        </div>

        <!-- Tombol Aksi -->
        <div class="flex flex-wrap items-center gap-3 border-t border-gray-600 pt-4">
            <!-- Tombol Like -->
            <form action="{{ route('questions.like', $question->id) }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center px-4 py-2 bg-blue-500/20 text-blue-300 rounded-full text-sm hover:bg-blue-500/30 transition border border-blue-500/30"
                    {{ auth()->check() && $question->likes->contains(auth()->user()->id) ? 'disabled' : '' }}>
                    <span>👍</span>
                    <span class="ml-1">Like ({{ $question->likes->count() }})</span>
                </button>
            </form>

            @if(auth()->check() && $question->likes->contains(auth()->user()->id))
                <span class="text-sm text-green-400">✓ Kamu sudah like</span>
            @endif

            <!-- Tombol Laporkan -->
            @auth
            <button type="button"
                onclick="showReportModal('question', {{ $question->id }})"
                class="flex items-center px-4 py-2 bg-red-500/20 text-red-300 rounded-full text-sm hover:bg-red-500/30 transition border border-red-500/30">
                <span>⚠️</span>
                <span class="ml-1">Laporkan</span>
            </button>
            @endauth

            <!-- Edit/Hapus (Hanya Pemilik) -->
            @if(Auth::id() == $question->user_id)
            <div class="flex gap-2 ml-auto">
                <a href="{{ route('questions.edit', $question->id) }}" class="px-4 py-2 bg-yellow-500/20 text-yellow-300 rounded-full text-sm hover:bg-yellow-500/30 transition border border-yellow-500/30">✏️ Edit</a>
                <form action="{{ route('questions.destroy', $question->id) }}" method="POST" onsubmit="return confirm('Yakin hapus Pertanyaan ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-500/20 text-red-300 rounded-full text-sm hover:bg-red-500/30 transition border border-red-500/30">🗑️ Hapus</button>
                </form>
            </div>
            @endif
        </div>
    </div>

    <!-- Seksi Komentar -->
    <div class="bg-gray-800 rounded-lg shadow-lg p-6 border border-gray-700">
        <h3 class="text-2xl font-semibold text-white mb-4">💬 Komentar ({{ $question->comments->count() }})</h3>

        @foreach($question->comments as $comment)
        <div class="border-b border-gray-600 pb-4 mb-4 last:border-0">
            <div class="flex justify-between items-start mb-2">
                <div class="font-medium text-white">
                    @include('components.user-mini-profile', ['user' => $comment->user])
                <div class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</div>
            </div>

            <p class="text-gray-300 mb-3">{{ $comment->content }}</p>

            <!-- Aksi Komentar -->
            <div class="flex flex-wrap items-center gap-2 text-sm">
                <!-- Like Komentar -->
                <form action="{{ route('comments.like', $comment->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center text-blue-400 hover:text-blue-300"
                        {{ auth()->check() && $comment->likes->contains(auth()->user()->id) ? 'disabled' : '' }}>
                        <span>👍</span>
                        <span class="ml-1">({{ $comment->likes->count() }})</span>
                    </button>
                </form>

                @if(auth()->check() && $comment->likes->contains(auth()->user()->id))
                    <span class="text-green-400 text-xs">✓ Liked</span>
                @endif

                <!-- Laporkan Komentar -->
                @auth
                <button type="button"
                    onclick="showReportModal('comment', {{ $comment->id }})"
                    class="text-red-400 hover:text-red-300 flex items-center text-xs">
                    <span>⚠️ Laporkan</span>
                </button>
                @endauth

                <!-- Edit/Hapus (Hanya Pemilik) -->
                @if(Auth::id() == $comment->user_id)
                <div class="flex gap-2 ml-auto">
                    <a href="{{ route('comments.edit', $comment->id) }}" class="text-yellow-400 hover:text-yellow-300">✏️ Edit</a>
                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('Yakin hapus komentar?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-400 hover:text-red-300">🗑️ Hapus</button>
                    </form>
                </div>
                @endif
            </div>
        </div>
        @endforeach

        <!-- Form Komentar Baru -->
        <div class="mt-6">
            <h4 class="text-lg font-medium text-white mb-3">✍️ Tambah Komentar</h4>

            @auth
                @if(in_array(auth()->user()->role, ['mahasiswa', 'dosen']))
                <form action="{{ route('comments.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="question_id" value="{{ $question->id }}">

                    <div class="mb-4">
                        <textarea name="content" rows="3" class="w-full px-4 py-2 border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-gray-700 text-white placeholder-gray-400" placeholder="Tulis komentarmu..." required></textarea>
                        @error('content')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-300 mb-1">Upload Gambar (Opsional)</label>
                        <input type="file" name="image" class="block w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-500/20 file:text-blue-300 hover:file:bg-blue-500/30">
                        @error('image')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
                    </div>

                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-500 text-white font-bold py-3 px-4 rounded-lg transition duration-200 transform hover:scale-[1.02] shadow-lg">
                        Kirim Komentar
                    </button>
                </form>
                @else
                <div class="bg-yellow-500/20 border-l-4 border-yellow-400 p-4 mb-4">
                    <div class="flex">
                        <div class="text-yellow-300">⚠️ Hanya mahasiswa/dosen yang bisa berkomentar</div>
                    </div>
                </div>
                @endif
            @else
            <div class="bg-blue-500/20 border-l-4 border-blue-400 p-4">
                <div class="flex">
                    <div>
                        <p class="text-blue-300">🔒 Silakan <a href="{{ route('login') }}" class="font-medium underline hover:text-blue-200">login</a> untuk memberi komentar</p>
                    </div>
                </div>
            </div>
            @endauth
        </div>
    </div>
</div>

<!-- Modal Form Laporan -->
<div id="reportModal" style="display:none; position:fixed; left:0; top:0; width:100vw; height:100vh; background:rgba(0,0,0,0.5); z-index:999;">
    <div style="margin:10vh auto; background:#1f2937; max-width:400px; border-radius:8px; padding:24px; position:relative; border: 1px solid #374151;">
        <form method="POST" action="{{ route('report.store') }}">
            @csrf
            <input type="hidden" name="question_id" id="modal-question-id">
            <input type="hidden" name="comment_id" id="modal-comment-id">
            <div class="mb-4">
                <label class="font-semibold text-white">Alasan Laporan</label>
                <input type="text" name="reason" class="w-full border border-gray-600 px-3 py-2 rounded bg-gray-700 text-white mt-1" required>
            </div>
            <div class="mb-4">
                <label class="text-white">Deskripsi (Opsional)</label>
                <textarea name="description" class="w-full border border-gray-600 px-3 py-2 rounded bg-gray-700 text-white mt-1"></textarea>
            </div>
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" onclick="closeReportModal()" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-500 transition">Batal</button>
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-500 transition">Kirim</button>
            </div>
        </form>
    </div>
</div>

<script>
function showReportModal(type, id) {
    document.getElementById('modal-question-id').value = (type === 'question') ? id : '';
    document.getElementById('modal-comment-id').value = (type === 'comment') ? id : '';
    document.getElementById('reportModal').style.display = 'block';
}

function closeReportModal() {
    document.getElementById('reportModal').style.display = 'none';
}
</script>

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
.text-gray-900, .text-gray-800, .text-gray-700, .text-gray-600 {
    color: #e5e7eb !important;
}

.text-gray-300 {
    color: #d1d5db !important;
}

.text-gray-400 {
    color: #9ca3af !important;
}

/* Shadow adjustments */
.shadow-lg {
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3), 0 4px 6px -2px rgba(0, 0, 0, 0.2) !important;
}

/* Border colors untuk komentar */
.border-gray-200 {
    border-color: #374151 !important;
}

/* File input styling */
.file\:bg-blue-50 {
    background-color: rgba(59, 130, 246, 0.2) !important;
}

.file\:text-blue-700 {
    color: #93c5fd !important;
}

.hover\:file\:bg-blue-100:hover {
    background-color: rgba(59, 130, 246, 0.3) !important;
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

    .text-gray-900, .text-gray-800, .text-gray-700 {
        color: #e5e7eb !important;
    }

    /* Memastikan input tetap gelap */
    input, textarea {
        background-color: #374151 !important;
        color: #e5e7eb !important;
        border-color: #4b5563 !important;
    }

    input::placeholder, textarea::placeholder {
        color: #9ca3af !important;
    }
}

/* Prose styling untuk konten pertanyaan */
.prose {
    color: #d1d5db !important;
}

.prose p {
    margin-bottom: 1rem;
}

.prose p:last-child {
    margin-bottom: 0;
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
