@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-[#111827] py-12 px-4">
    <div class="bg-gray-800 rounded-xl shadow-lg w-full max-w-lg px-8 py-8 border border-gray-700">
        <h2 class="text-3xl font-bold mb-6 text-blue-400 text-center">Edit Pertanyaan</h2>
        <form action="{{ route('questions.update', $question->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-5">
                <label class="block mb-2 font-semibold text-gray-300">Judul Pertanyaan</label>
                <input type="text" name="title"
                    class="w-full border border-gray-600 focus:border-blue-500 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500/30 transition bg-gray-700 text-white placeholder-gray-400"
                    value="{{ old('title', $question->title) }}" required placeholder="Masukkan judul pertanyaan">
                @error('title')
                    <small class="text-red-400">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-5">
                <label class="block mb-2 font-semibold text-gray-300">Kategori</label>
                <select name="category_id"
                    class="w-full border border-gray-600 focus:border-blue-500 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500/30 transition bg-gray-700 text-white"
                    required>
                    <option value="" disabled class="text-gray-400">Pilih Kategori</option>
                    @foreach(\App\Models\Category::all() as $cat)
                        <option value="{{ $cat->id }}" {{ $question->category_id == $cat->id ? 'selected' : '' }} class="text-white">
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <small class="text-red-400">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-5">
                <label class="block mb-2 font-semibold text-gray-300">Isi Pertanyaan</label>
                <textarea name="content"
                    class="w-full border border-gray-600 focus:border-blue-500 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500/30 transition bg-gray-700 text-white placeholder-gray-400"
                    rows="6" required placeholder="Tulis isi pertanyaan Anda...">{{ old('content', $question->content) }}</textarea>
                @error('content')
                    <small class="text-red-400">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-5">
                <label class="block mb-2 font-semibold text-gray-300">Hashtags</label>
                <select name="hashtags[]"
                    class="w-full border border-gray-600 focus:border-blue-500 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500/30 transition bg-gray-700 text-white"
                    multiple>
                    @foreach($hashtags as $tag)
                        <option value="{{ $tag->id }}" {{ in_array($tag->id, $selectedHashtags) ? 'selected' : '' }} class="text-white">
                            {{ $tag->name }}
                        </option>
                    @endforeach
                </select>
                @error('hashtags')
                    <small class="text-red-400">{{ $message }}</small>
                @enderror
            </div>

            @if($question->images && count($question->images))
                <div class="mb-5">
                    <label class="block mb-2 font-semibold text-gray-300">Gambar Tersimpan:</label>
                    <div class="flex flex-wrap gap-2">
                        @foreach($question->images as $img)
                            <div class="relative">
                                <img src="{{ asset('storage/question_images/'.$img) }}" alt="gambar" class="w-20 h-20 object-cover rounded shadow border border-gray-600">
                                <label class="block text-xs text-red-400 text-center mt-1">
                                    <input type="checkbox" name="delete_images[]" value="{{ $img }}" class="mr-1"> Hapus
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="mb-8">
                <label class="block mb-2 font-semibold text-gray-300">Tambah Gambar Baru</label>
                <input type="file" name="images[]" multiple
                    class="w-full border border-gray-600 rounded-lg px-4 py-2 bg-gray-700 text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-500/20 file:text-blue-300 hover:file:bg-blue-500/30">
                @error('images.*')
                    <small class="text-red-400">{{ $message }}</small>
                @enderror
            </div>

            <div class="flex gap-3 justify-center">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-500 text-white font-bold py-2 px-8 rounded-lg shadow transition transform hover:scale-105">
                    Update
                </button>
                <a href="{{ route('questions.show', $question->id) }}"
                    class="bg-gray-600 hover:bg-gray-500 text-white font-semibold py-2 px-8 rounded-lg shadow transition transform hover:scale-105">
                    Batal
                </a>
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
.text-gray-700, .text-gray-800 {
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

.shadow {
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.3), 0 1px 2px 0 rgba(0, 0, 0, 0.2) !important;
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

    /* Memastikan input tetap gelap */
    input, textarea, select {
        background-color: #374151 !important;
        color: #e5e7eb !important;
        border-color: #4b5563 !important;
    }

    input::placeholder, textarea::placeholder {
        color: #9ca3af !important;
    }

    select option {
        background-color: #374151 !important;
        color: #e5e7eb !important;
    }
}

/* Transisi smooth */
.transition {
    transition: all 0.2s ease;
}

.transform {
    transition: transform 0.2s ease;
}

/* Styling untuk multiple select */
select[multiple] {
    height: auto;
    min-height: 100px;
}

select[multiple] option {
    padding: 8px 12px;
    border-bottom: 1px solid #4b5563;
}

select[multiple] option:checked {
    background-color: #3b82f6;
    color: white;
}
</style>
@endsection
