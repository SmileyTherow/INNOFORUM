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
        @endif
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
            <div class="text-xl font-bold text-blue-700">{{ $threadCount ?? 0 }}</div>
            <div class="text-xs text-gray-500">Pertanyaan</div>
        </div>
        <div class="text-center">
            <div class="text-xl font-bold text-blue-700">{{ $commentCount ?? 0 }}</div>
            <div class="text-xs text-gray-500">Komentar</div>
        </div>
        <div class="text-center">
            <div class="text-xl font-bold text-blue-700">{{ $likeCount ?? 0 }}</div>
            <div class="text-xs text-gray-500">Like</div>
        </div>
    </div>

    @if($user->socialLinks && $user->socialLinks->where('visible', true)->isNotEmpty())
        <div class="mb-6">
            <h2 class="font-bold mb-3 text-blue-700">🌐 Media Sosial & Links</h2>
            <div class="space-y-2">
                @foreach($user->socialLinks->where('visible', true) as $link)
                    @php
                        $iconMap = [
                            'instagram' => 'fab fa-instagram text-pink-500',
                            'github' => 'fab fa-github text-gray-700',
                            'facebook' => 'fab fa-facebook text-blue-600',
                            'linkedin' => 'fab fa-linkedin text-blue-700',
                            'website' => 'fas fa-globe text-green-500',
                            'twitter' => 'fab fa-twitter text-blue-400',
                            'youtube' => 'fab fa-youtube text-red-500',
                            'tiktok' => 'fab fa-tiktok text-black',
                            'whatsapp' => 'fab fa-whatsapp text-green-500',
                            'telegram' => 'fab fa-telegram text-blue-500',
                            'discord' => 'fab fa-discord text-indigo-500',
                            'other' => 'fas fa-link text-gray-500',
                        ];
                        $iconClass = $iconMap[$link->type] ?? 'fas fa-link text-gray-500';
                        $label = $link->label ?: (parse_url($link->url, PHP_URL_HOST) . (parse_url($link->url, PHP_URL_PATH) ? parse_url($link->url, PHP_URL_PATH) : ''));
                    @endphp
                    <div class="flex items-center justify-between py-2 px-3 bg-gray-100 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600 hover:border-blue-400 transition-colors">
                        <div class="flex items-center space-x-3">
                            <i class="{{ $iconClass }} text-lg"></i>
                            <span class="text-gray-700 dark:text-gray-300 text-sm">{{ $label }}</span>
                        </div>
                        <a href="{{ $link->url }}" target="_blank" rel="noopener" class="text-blue-500 hover:text-blue-400">
                            <i class="fas fa-external-link-alt text-sm"></i>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <div class="mb-8">
        <h2 class="font-bold mb-2 text-blue-700">Tentang Saya</h2>
        <div class="text-gray-700 dark:text-gray-200">
            {!! nl2br(e($user->bio ?? 'Belum ada deskripsi.')) !!}
        </div>
    </div>
</div>
@endsection
