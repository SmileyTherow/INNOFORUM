@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#F7F8FA] flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-xl border border-gray-200">
        <h2 class="text-xl font-bold mb-4 text-blue-700">Buat Pertanyaan</h2>
        <form action="{{ route('questions.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Judul Pertanyaan</label>
                <input type="text" name="title" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-blue-500" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Isi Pertanyaan</label>
                <textarea name="content" rows="4" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-blue-500" required></textarea>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Hashtag (bisa pilih banyak)</label>
                <select name="hashtags[]" multiple class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-blue-500">
                    @foreach($hashtags as $hashtag)
                        <option value="{{ $hashtag->id }}">{{ $hashtag->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Lampirkan Gambar (bisa lebih dari satu):</label>
                <input type="file" name="images[]" class="form-control" accept="image/*" multiple>
                @error('images.*') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="flex justify-end gap-4">
                <a href="{{ route('dashboard') }}" class="px-4 py-2 rounded bg-gray-200 text-gray-700 hover:bg-gray-300 font-semibold">Batal</a>
                <button type="submit" class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700 font-semibold shadow">Kirim</button>
            </div>
        </form>
    </div>
</div>
@endsection