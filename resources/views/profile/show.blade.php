@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 rounded-xl shadow-md p-8 mt-8 border border-gray-200 dark:border-gray-700">
    <div class="flex flex-col md:flex-row items-center gap-6 mb-8">
        @if($user->photo)
            <img src="{{ asset('storage/photo/' . $user->photo) }}" alt="Foto Profil"
                class="w-28 h-28 rounded-full object-cover border-4 border-white shadow-lg">
        @else
        <div class="w-28 h-28 rounded-full bg-blue-600 flex items-center justify-center text-white text-4xl font-extrabold">
            {{ strtoupper(substr($user->name,0,2)) }}
        </div>
        <div>
            <h1 class="text-2xl font-bold">{{ $user->name }}</h1>
            <p class="text-gray-500">@{{ $user->username }}</p>
            <p class="text-gray-400">Anggota sejak {{ $user->created_at->translatedFormat('F Y') }}</p>
            @if(auth()->id() == $user->id)
            <a href="{{ route('profile.edit', $user->id) }}" class="inline-block mt-3 px-4 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                <i class="fa-solid fa-edit mr-1"></i> Edit Profil
            </a>
            @endif
        </div>
    </div>
    <div class="flex gap-8 justify-center mb-8">
        <div class="text-center">
            <div class="text-xl font-bold text-blue-700">{{ $user->questions_count ?? 0 }}</div>
            <div class="text-xs text-gray-500">Pertanyaan</div>
        </div>
        <div class="text-center">
            <div class="text-xl font-bold text-blue-700">{{ $user->answers_count ?? 0 }}</div>
            <div class="text-xs text-gray-500">Jawaban</div>
        </div>
        <div class="text-center">
            <div class="text-xl font-bold text-blue-700">{{ $user->likes_count ?? 0 }}</div>
            <div class="text-xs text-gray-500">Like</div>
        </div>
    </div>
    <div class="mb-8">
        <h2 class="font-bold mb-2 text-blue-700">Tentang Saya</h2>
        <div class="text-gray-700 dark:text-gray-200">
            {!! nl2br(e($user->bio ?? 'Belum ada deskripsi.')) !!}
        </div>
    </div>
</div>
@endsection