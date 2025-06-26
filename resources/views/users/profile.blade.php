@extends('layouts.app')

@section('content')
<div class="bg-gray-100 min-h-screen py-10 px-2">
    <div class="container mx-auto">
        <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-md overflow-hidden">
            <!-- Header Profil -->
            <div class="bg-blue-600 px-8 pt-8 pb-6 rounded-t-xl text-center">
                <h1 class="text-2xl md:text-3xl font-bold text-white">Profil Pengguna</h1>
                <p class="opacity-90 text-white md:text-lg">Informasi akun forum kampus Anda</p>
            </div>
            <!-- Konten Profil -->
            <div class="md:flex px-8 py-8 gap-8">
                <!-- Bagian Kiri -->
                <div class="md:w-1/3 flex flex-col items-center">
                    <div class="relative -mt-20 mb-4">
                        @if($user->photo)
                            <img src="{{ asset('storage/photo/' . $user->photo) }}"
                                alt="Foto Profil"
                                class="w-40 h-40 rounded-full object-cover border-4 border-white shadow-lg bg-gray-200">
                        @else
                            <div class="w-40 h-40 flex items-center justify-center rounded-full bg-blue-200 text-blue-800 text-5xl font-bold border-4 border-white shadow-lg">
                                {{ strtoupper(substr($user->name, 0, 2)) }}
                            </div>
                        @endif
                        <div class="absolute bottom-2 right-2 bg-green-500 rounded-full p-2 border-2 border-white shadow">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    <div class="text-center mb-4">
                        <h2 class="text-xl font-semibold text-gray-800">{{ $user->name }}</h2>
                        <p class="text-gray-600 text-sm">Anggota sejak: {{ $user->created_at ? $user->created_at->translatedFormat('d F Y') : '-' }}</p>
                    </div>
                    <!-- Statistik -->
                    <div class="w-full bg-gray-50 rounded-lg p-4 mb-4 flex justify-center gap-6 shadow">
                        <div class="text-center">
                            <p class="text-xl font-bold">{{ $threadCount ?? $user->questions_count ?? 0 }}</p>
                            <p class="text-xs text-gray-500">Thread</p>
                        </div>
                        <div class="text-center">
                            <p class="text-xl font-bold">{{ $commentCount ?? $user->comments_count ?? 0 }}</p>
                            <p class="text-xs text-gray-500">Komentar</p>
                        </div>
                        <div class="text-center">
                            <p class="text-xl font-bold">{{ $likeCount ?? 0 }}</p>
                            <p class="text-xs text-gray-500">Like</p>
                        </div>
                    </div>
                    @if(auth()->id() == $user->id)
                    <a href="{{ route('profile.edit', $user->id) }}"
                        class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 rounded-full transition duration-200 mb-2">
                        Edit Profil
                    </a>
                    @endif
                </div>
                <!-- Bagian Kanan -->
                <div class="md:w-2/3 md:pl-8 mt-6 md:mt-0 flex flex-col gap-8">
                    <!-- Informasi Pribadi -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">Informasi Pribadi</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Nama Lengkap</p>
                                <p class="font-medium">{{ $user->name }}</p>
                            </div>
                            @if($user->role === 'mahasiswa')
                                <div>
                                    <p class="text-sm text-gray-500">NIM</p>
                                    <p class="font-medium">{{ $user->nim ?? $user->username ?? '-' }}</p>
                                </div>
                            @elseif($user->role === 'dosen')
                                <div>
                                    <p class="text-sm text-gray-500">NIDN</p>
                                    <p class="font-medium">{{ $user->nidm ?? $user->username ?? '-' }}</p>
                                </div>
                            @endif
                            <div>
                                <p class="text-sm text-gray-500">Email</p>
                                <p class="font-medium">{{ $user->email }}</p>
                            </div>
                            @if($user->role === 'mahasiswa')
                                <div>
                                    <p class="text-sm text-gray-500">Program Studi</p>
                                    <p class="font-medium">
                                        {{ $user->prodi ?? '-' }}
                                    </p>
                                </div>
                            @elseif($user->role === 'dosen')
                                <div>
                                    <p class="text-sm text-gray-500">Mata Kuliah Diampu</p>
                                    <p class="font-medium">
                                        {{ $user->prodi ?? '-' }}
                                    </p>
                                </div>
                            @endif
                            @if($user->role === 'mahasiswa')
                            <div>
                                <p class="text-sm text-gray-500">Angkatan</p>
                                <p class="font-medium">
                                    {{ $user->angkatan ?? ($user->profile->angkatan ?? '-') }}
                                </p>
                            </div>
                            @endif
                        </div>
                    </div>
                    <!-- Bio Singkat -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">Bio Singkat</h3>
                        <div class="bg-gray-50 rounded-lg p-4 text-gray-700 shadow">
                            {{ $user->bio ?? ($user->profile->bio ?? '-') }}
                        </div>
                    </div>
                    <!-- Thread oleh User -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">Thread oleh {{ $user->name }}</h3>
                        <div class="bg-gray-50 rounded-lg p-6 text-center">
                            @if(isset($threads) && count($threads))
                                <ul class="divide-y divide-gray-200">
                                    @foreach($threads as $thread)
                                    <li class="py-3">
                                        <a href="{{ route('questions.show', $thread->id) }}"
                                            class="text-blue-600 font-medium hover:underline">
                                            {{ $thread->title }}
                                        </a>
                                        <span class="block text-xs text-gray-500">{{ $thread->created_at->diffForHumans() }}</span>
                                    </li>
                                    @endforeach
                                </ul>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="text-gray-600 font-medium">Belum ada thread.</p>
                                <p class="text-sm text-gray-500 mt-1">Thread yang dibuat akan muncul di sini</p>
                            @endif
                        </div>
                    </div>
                    <!-- Komentar oleh User -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">Komentar oleh {{ $user->name }}</h3>
                        <div class="bg-gray-50 rounded-lg p-6 text-center">
                            @if(isset($comments) && count($comments))
                                <ul class="divide-y divide-gray-200">
                                    @foreach($comments as $comment)
                                    <li class="py-3">
                                        <span class="text-gray-700">{{ \Illuminate\Support\Str::limit($comment->content, 80) }}</span>
                                        <a href="{{ route('questions.show', $comment->question_id) }}#comment-{{ $comment->id }}"
                                            class="ml-2 text-xs text-blue-600 hover:underline">Lihat</a>
                                        <span class="block text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                    </li>
                                    @endforeach
                                </ul>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                <p class="text-gray-600 font-medium">Belum ada komentar.</p>
                                <p class="text-sm text-gray-500 mt-1">Komentar yang diberikan akan muncul di sini</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection