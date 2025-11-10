@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-br from-gray-900 via-blue-900 to-gray-800 min-h-screen py-8">
    <div class="container mx-auto px-4 max-w-4xl">
        <!-- Header -->
        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold text-blue-400 mb-2">INNOFORUM</h1>
            <div class="bg-gray-800 rounded-2xl shadow-lg p-6 mb-8 border border-gray-700">
                <h2 class="text-xl md:text-2xl font-semibold text-white mb-2">Leaderboard Pengguna INNOFORUM</h2>
                <p class="text-gray-300">Peringkat berdasarkan kontribusi dan aktivitas di forum</p>
                <!-- Filter -->
                <div class="flex justify-center mt-6 space-x-4">
                    <a href="{{ route('leaderboard', ['periode' => 'week']) }}"
                    class="px-4 py-2 rounded-lg font-medium transition-all duration-300 {{ $periode=='week' ? 'bg-blue-600 text-white' : 'bg-gray-700 text-gray-300 hover:bg-gray-600' }}">
                        <i class="fas fa-calendar-week mr-1"></i>Minggu Ini
                    </a>
                    <a href="{{ route('leaderboard', ['periode' => 'month']) }}"
                    class="px-4 py-2 rounded-lg font-medium transition-all duration-300 {{ $periode=='month' ? 'bg-blue-600 text-white' : 'bg-gray-700 text-gray-300 hover:bg-gray-600' }}">
                        <i class="fas fa-calendar-alt mr-1"></i>Bulan Ini
                    </a>
                    <a href="{{ route('leaderboard', ['periode' => 'all']) }}"
                    class="px-4 py-2 rounded-lg font-medium transition-all duration-300 {{ $periode=='all' ? 'bg-blue-600 text-white' : 'bg-gray-700 text-gray-300 hover:bg-gray-600' }}">
                        <i class="fas fa-infinity mr-1"></i>Sepanjang Waktu
                    </a>
                </div>
            </div>
        </div>

        <!-- Leaderboard List -->
        <div class="bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-700">
            @foreach($topUsers as $user)
            <div class="flex items-center gap-4 border-b border-gray-700 px-6 py-4 hover:bg-gray-750 transition-colors">
                <!-- Avatar -->
                @if($user->photo)
                    <img src="{{ asset('storage/photo/'.$user->photo) }}" class="w-12 h-12 rounded-full bg-blue-500/20 border border-gray-600 shadow" alt="avatar">
                @else
                    <div class="w-12 h-12 rounded-full bg-blue-500/20 flex items-center justify-center border border-gray-600">
                        <i class="fas fa-user text-blue-400 text-xl"></i>
                    </div>
                @endif

                <!-- User Info -->
                <div class="flex-1">
                    @include('components.user-mini-profile', ['user' => $user, 'class' => 'font-semibold text-blue-400 hover:text-blue-300 text-lg {{ $user->name }}'])

                    <div class="text-xs text-gray-400 mb-1">
                        Anggota sejak {{ $user->created_at->translatedFormat('M Y') }}
                    </div>
                    <div class="flex gap-2 text-xs">
                        <span class="bg-blue-500/20 text-blue-300 px-2 py-1 rounded border border-blue-500/30">Komentar: {{ $periode=='all' ? $user->comments->count() : $user->comments_in_period }}</span>
                        <span class="bg-green-500/20 text-green-300 px-2 py-1 rounded border border-green-500/30">Pertanyaan: {{ $periode=='all' ? $user->questions->count() : $user->questions_in_period }}</span>
                        <span class="bg-yellow-500/20 text-yellow-300 px-2 py-1 rounded border border-yellow-500/30">Like: {{ $periode=='all' ? $user->comments->sum(fn($c) => $c->likes->count()) : $user->like_count_in_period }}</span>
                    </div>
                </div>
                <!-- Points -->
                <span class="bg-yellow-500/20 text-yellow-300 px-5 py-2 rounded-full font-bold text-base border border-yellow-500/30">
                    {{ $periode=='all' ? $user->points : ($user->comments_in_period + $user->questions_in_period + $user->like_count_in_period) }} pts
                </span>
            </div>
            @endforeach
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center text-gray-400 text-sm">
            <p>© 2025 INNOFORUM. Semua hak dilindungi.</p>
        </div>
    </div>
</div>

<style>
/* MEMASTIKAN SELURUH HALAMAN TETAP GELAP MESKIPUN MODE LIGHT */
body {
    background-color: #111827 !important;
    color: #e5e7eb !important;
}

/* Background gradient untuk halaman leaderboard */
.bg-gradient-to-br.from-gray-900.via-blue-900.to-gray-800 {
    background-image: linear-gradient(to bottom right, #111827, #1e3a8a, #111827) !important;
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

/* Hover effect untuk list items */
.hover\:bg-gray-750:hover {
    background-color: #374151 !important;
}

/* Shadow override */
.shadow-lg {
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3), 0 4px 6px -2px rgba(0, 0, 0, 0.2) !important;
}

.shadow-xl {
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3), 0 10px 10px -5px rgba(0, 0, 0, 0.2) !important;
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
}

/* Rank styling untuk top 3 (jika ada) */
.rank-1 {
    background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%) !important;
    color: #000 !important;
}
.rank-2 {
    background: linear-gradient(135deg, #C0C0C0 0%, #A0A0A0 100%) !important;
    color: #000 !important;
}
.rank-3 {
    background: linear-gradient(135deg, #CD7F32 0%, #A0522D 100%) !important;
    color: #000 !important;
}

/* Transisi smooth */
.transition-colors {
    transition: background-color 0.2s ease, color 0.2s ease;
}
</style>
@endsection
