@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-[#171e2b] py-12 px-4">
    <div class="bg-white/90 rounded-xl shadow-lg w-full max-w-lg px-8 py-8">
        <h2 class="text-3xl font-bold mb-6 text-blue-700 text-center">Edit Thread</h2>
        <form action="{{ route('questions.update', $question->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-5">
                <label class="block mb-2 font-semibold text-gray-700">Judul Thread</label>
                <input type="text" name="title"
                    class="w-full border border-gray-300 focus:border-blue-500 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200 transition"
                    value="{{ old('title', $question->title) }}" required>
                @error('title')
                    <small class="text-red-500">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-5">
                <label class="block mb-2 font-semibold text-gray-700">Kategori</label>
                <select name="category_id"
                    class="w-full border border-gray-300 focus:border-blue-500 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200 transition"
                    required>
                    <option value="" disabled>Pilih Kategori</option>
                    @foreach(\App\Models\Category::all() as $cat)
                        <option value="{{ $cat->id }}" {{ $question->category_id == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <small class="text-red-500">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-5">
                <label class="block mb-2 font-semibold text-gray-700">Isi Thread</label>
                <textarea name="content"
                    class="w-full border border-gray-300 focus:border-blue-500 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200 transition"
                    rows="6" required>{{ old('content', $question->content) }}</textarea>
                @error('content')
                    <small class="text-red-500">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-5">
                <label class="block mb-2 font-semibold text-gray-700">Hashtags</label>
                <select name="hashtags[]" class="w-full border border-gray-300 focus:border-blue-500 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200 transition" multiple>
                    @foreach($hashtags as $tag)
                        <option value="{{ $tag->id }}" {{ in_array($tag->id, $selectedHashtags) ? 'selected' : '' }}>
                            {{ $tag->name }}
                        </option>
                    @endforeach
                </select>
                @error('hashtags')
                    <small class="text-red-500">{{ $message }}</small>
                @enderror
            </div>

            @if($question->images && count($question->images))
                <div class="mb-5">
                    <label class="block mb-2 font-semibold text-gray-700">Gambar Tersimpan:</label>
                    <div class="flex flex-wrap gap-2">
                        @foreach($question->images as $img)
                            <div class="relative">
                                <img src="{{ asset('storage/question_images/'.$img) }}" alt="gambar" class="w-20 h-20 object-cover rounded shadow">
                                <label class="block text-xs text-red-500 text-center">
                                    <input type="checkbox" name="delete_images[]" value="{{ $img }}"> Hapus
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="mb-8">
                <label class="block mb-2 font-semibold text-gray-700">Tambah Gambar Baru</label>
                <input type="file" name="images[]" multiple class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white">
                @error('images.*')
                    <small class="text-red-500">{{ $message }}</small>
                @enderror
            </div>

            <div class="flex gap-3 justify-center">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-8 rounded-lg shadow transition">
                    Update
                </button>
                <a href="{{ route('questions.show', $question->id) }}"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-8 rounded-lg shadow transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection