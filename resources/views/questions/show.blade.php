@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <!-- Header Thread -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $question->title }}</h1>
        <div class="flex items-center text-sm text-gray-500 mb-4">
            <span>
                <span class="inline-block px-2 py-1 bg-blue-100 text-blue-700 rounded-full font-semibold text-xs">
                    {{ $question->category->name ?? '-' }}
                </span>
            </span>
            <span class="mx-2">•</span>
            <span>
                Oleh:
                <a href="{{ route('users.show', $question->user->id) }}" class="text-blue-600 hover:underline">
                    {{ $question->user->name ?? 'Anonim' }}
                </a>
            <span class="mx-2">•</span>
            <span>{{ $question->created_at->diffForHumans() }}</span>
        </div>
        
        <div class="prose max-w-none text-gray-700 mb-6">
            {{ $question->content }}
        </div>

        <!-- Tombol Aksi -->
        <div class="flex flex-wrap items-center gap-3 border-t pt-4">
            <!-- Tombol Like -->
            <form action="{{ route('questions.like', $question->id) }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center px-4 py-2 bg-blue-100 text-blue-600 rounded-full text-sm hover:bg-blue-200 transition"
                    {{ auth()->check() && $question->likes->contains(auth()->user()->id) ? 'disabled' : '' }}>
                    <span>👍</span>
                    <span class="ml-1">Like ({{ $question->likes->count() }})</span>
                </button>
            </form>

            @if(auth()->check() && $question->likes->contains(auth()->user()->id))
                <span class="text-sm text-green-600">✓ Kamu sudah like</span>
            @endif

            <!-- Tombol Laporkan -->
            @auth
            <button type="button"
                onclick="showReportModal('question', {{ $question->id }})"
                class="flex items-center px-4 py-2 bg-red-100 text-red-600 rounded-full text-sm hover:bg-red-200 transition">
                <span>⚠️</span>
                <span class="ml-1">Laporkan</span>
            </button>
            @endauth

            <!-- Edit/Hapus (Hanya Pemilik) -->
            @if(Auth::id() == $question->user_id)
            <div class="flex gap-2 ml-auto">
                <a href="{{ route('questions.edit', $question->id) }}" class="px-4 py-2 bg-yellow-100 text-yellow-600 rounded-full text-sm hover:bg-yellow-200 transition">✏️ Edit</a>
                <form action="{{ route('questions.destroy', $question->id) }}" method="POST" onsubmit="return confirm('Yakin hapus thread ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-100 text-red-600 rounded-full text-sm hover:bg-red-200 transition">🗑️ Hapus</button>
                </form>
            </div>
            @endif
        </div>
    </div>

    <!-- Seksi Komentar -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h3 class="text-2xl font-semibold text-gray-800 mb-4">💬 Komentar ({{ $question->comments->count() }})</h3>

        @foreach($question->comments as $comment)
        <div class="border-b border-gray-200 pb-4 mb-4 last:border-0">
            <div class="flex justify-between items-start mb-2">
                <div class="font-medium text-gray-800">
                    <a href="{{ route('users.show', $comment->user->id) }}" class="text-blue-600 hover:underline">
                        {{ $comment->user->name ?? 'Anonim' }}
                    </a>
                <div class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</div>
            </div>
            
            <p class="text-gray-700 mb-3">{{ $comment->content }}</p>
            
            <!-- Aksi Komentar -->
            <div class="flex flex-wrap items-center gap-2 text-sm">
                <!-- Like Komentar -->
                <form action="{{ route('comments.like', $comment->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center text-blue-600 hover:text-blue-800"
                        {{ auth()->check() && $comment->likes->contains(auth()->user()->id) ? 'disabled' : '' }}>
                        <span>👍</span>
                        <span class="ml-1">({{ $comment->likes->count() }})</span>
                    </button>
                </form>

                @if(auth()->check() && $comment->likes->contains(auth()->user()->id))
                    <span class="text-green-600 text-xs">✓ Liked</span>
                @endif

                <!-- Laporkan Komentar -->
                @auth
                <button type="button"
                    onclick="showReportModal('comment', {{ $comment->id }})"
                    class="text-red-600 hover:text-red-800 flex items-center text-xs">
                    <span>⚠️ Laporkan</span>
                </button>
                @endauth

                <!-- Edit/Hapus (Hanya Pemilik) -->
                @if(Auth::id() == $comment->user_id)
                <div class="flex gap-2 ml-auto">
                    <a href="{{ route('comments.edit', $comment->id) }}" class="text-yellow-600 hover:text-yellow-800">✏️ Edit</a>
                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('Yakin hapus komentar?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800">🗑️ Hapus</button>
                    </form>
                </div>
                @endif
            </div>
        </div>
        @endforeach

        <!-- Form Komentar Baru -->
        <div class="mt-6">
            <h4 class="text-lg font-medium text-gray-800 mb-3">✍️ Tambah Komentar</h4>
            
            @auth
                @if(in_array(auth()->user()->role, ['mahasiswa', 'dosen']))
                <form action="{{ route('comments.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="question_id" value="{{ $question->id }}">
                    
                    <div class="mb-4">
                        <textarea name="content" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Tulis komentarmu..." required></textarea>
                        @error('content')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Upload Gambar (Opsional)</label>
                        <input type="file" name="image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        @error('image')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    
                    <button type="submit"
                        style="background: #111; color: #fff; font-weight: bold; font-size: 1.15rem; border-radius: 0.5rem; padding: 0.75rem 2rem; box-shadow: 0 1px 6px 0 rgba(0,0,0,0.12);"
                        class="block mt-2 hover:bg-blue-700 transition">
                        Kirim Komentar
                    </button>
                </form>
                @else
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">
                    <div class="flex">
                        <div class="text-yellow-700">⚠️ Hanya mahasiswa/dosen yang bisa berkomentar</div>
                    </div>
                </div>
                @endif
            @else
            <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
                <div class="flex">
                    <div>
                        <p class="text-blue-700">🔒 Silakan <a href="{{ route('login') }}" class="font-medium underline">login</a> untuk memberi komentar</p>
                    </div>
                </div>
            </div>
            @endauth
        </div>
    </div>
</div>
<!-- Modal Form Laporan -->
<div id="reportModal" style="display:none; position:fixed; left:0; top:0; width:100vw; height:100vh; background:rgba(0,0,0,0.3); z-index:999;">
    <div style="margin:10vh auto; background:#fff; max-width:400px; border-radius:8px; padding:24px; position:relative;">
        <form method="POST" action="{{ route('report.store') }}">
            @csrf
            <input type="hidden" name="question_id" id="modal-question-id">
            <input type="hidden" name="comment_id" id="modal-comment-id">
            <div class="mb-2">
                <label class="font-semibold">Alasan Laporan</label>
                <input type="text" name="reason" class="form-control w-full border px-2 py-1 rounded" required>
            </div>
            <div class="mb-2">
                <label>Deskripsi (Opsional)</label>
                <textarea name="description" class="form-control w-full border px-2 py-1 rounded"></textarea>
            </div>
            <div class="flex justify-end gap-2 mt-2">
                <button type="button" onclick="closeReportModal()" class="bg-gray-200 px-4 py-2 rounded">Batal</button>
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded">Kirim</button>
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
@endsection