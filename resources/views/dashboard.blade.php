@extends('layouts.app')

@section('content')

{{-- HERO SECTION --}}
<div class="w-full bg-gradient-to-r from-blue-900 to-blue-700 rounded-xl shadow mb-10 pt-14 pb-12 px-6 md:px-16 flex flex-col items-center justify-center text-center relative"
    style="min-height: 270px;">
    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white mb-4 drop-shadow-lg">Selamat datang di INNOFORUM</h1>
    <p class="text-white text-lg md:text-2xl font-medium max-w-3xl drop-shadow-lg">
        Forum tanya jawab, diskusi, dan berbagi pengetahuan teknologi untuk mahasiswa & profesional. Temukan solusi, posting pertanyaan, dapatkan insight dari komunitas!
    </p>
</div>

{{-- TAB FILTER & SEARCH --}}
<div class="flex flex-col md:flex-row items-stretch md:items-end gap-4 mb-6 mt-16">
    <div class="flex flex-wrap gap-2">
        @php
            $active = request('filter', 'terbaru');
            $tabClasses = 'px-4 py-2 rounded-t-lg font-semibold cursor-pointer transition mr-1';
        @endphp
        <a href="{{ route('dashboard', ['filter' => 'terbaru']) }}" class="{{ $tabClasses }} {{ $active == 'terbaru' ? 'bg-blue-600 text-white' : 'bg-gray-700 text-gray-300 hover:bg-gray-600' }}">
            <span class="material-icons align-middle mr-1 text-base">new_releases</span> Terbaru
        </a>
        <a href="{{ route('dashboard', ['filter' => 'terbanyak']) }}" class="{{ $tabClasses }} {{ $active == 'terbanyak' ? 'bg-blue-600 text-white' : 'bg-gray-700 text-gray-300 hover:bg-gray-600' }}">
            <span class="material-icons align-middle mr-1 text-base">thumb_up</span> Respon Terbanyak
        </a>
        <a href="{{ route('dashboard', ['filter' => 'baru-dijawab']) }}" class="{{ $tabClasses }} {{ $active == 'baru-dijawab' ? 'bg-blue-600 text-white' : 'bg-gray-700 text-gray-300 hover:bg-gray-600' }}">
            <span class="material-icons align-middle mr-1 text-base">check_circle</span> Baru Dijawab
        </a>
        <a href="{{ route('dashboard', ['filter' => 'belum-dijawab']) }}" class="{{ $tabClasses }} {{ $active == 'belum-dijawab' ? 'bg-blue-600 text-white' : 'bg-gray-700 text-gray-300 hover:bg-gray-600' }}">
            <span class="material-icons align-middle mr-1 text-base">help</span> Belum Dijawab
        </a>
    </div>
    <form method="GET" action="{{ route('dashboard') }}" class="flex-1 flex justify-end">
        <input type="text" name="search" placeholder="Cari pertanyaan atau #hashtag..." value="{{ request('search') }}"
            class="w-full md:w-64 px-4 py-2 rounded-lg border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-700 text-white placeholder-gray-400" />
    </form>
</div>

{{-- MAIN CONTENT --}}
<div class="grid md:grid-cols-3 gap-8 gap-y-10 p-2 md:p-0">
    {{-- List pertanyaan --}}
    <div class="md:col-span-2 space-y-8">
        @if($questions->count() == 0)
            <div class="text-center text-gray-400 py-12">Tidak ada pertanyaan ditemukan.</div>
        @endif

        @foreach($questions as $q)
        <div class="bg-gray-800 rounded-xl shadow p-6 border border-gray-700 mb-2">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold">
                    {{ strtoupper(substr($q->user->name,0,2)) }}
                </div>
                <div class="font-semibold text-gray-300">{{ $q->user->name }}</div>
                <span class="text-xs text-gray-400 ml-2">{{ $q->created_at->diffForHumans() }}</span>
            </div>
            <a href="{{ route('questions.show', $q->id) }}" class="block text-lg md:text-xl font-bold text-blue-400 hover:text-blue-300 hover:underline mt-1">
                {{ $q->title }}
            </a>
            <div class="my-2 text-gray-300">
                {{ \Illuminate\Support\Str::limit($q->content, 180) }}
            </div>
            <div class="flex flex-wrap items-center gap-2 mt-3">
                {{-- Tag --}}
                @if(isset($q->hashtags) && count($q->hashtags))
                    @foreach($q->hashtags as $tag)
                        <span class="bg-blue-500/20 text-blue-300 px-2 py-0.5 rounded text-xs font-medium border border-blue-500/30">#{{ is_object($tag) ? $tag->name : $tag }}</span>
                    @endforeach
                @endif
                <div class="flex items-center gap-3 ml-auto">
                    <span class="flex items-center gap-1 text-gray-400">
                        <span class="material-icons text-base">thumb_up</span> {{ $q->likes_count ?? 0 }}
                    </span>
                    <span class="flex items-center gap-1 text-gray-400">
                        <span class="material-icons text-base">comment</span> {{ $q->comments_count ?? 0 }}
                    </span>
                    @if(auth()->id() == $q->user->id)
                        <a href="{{ route('questions.edit', $q->id) }}" class="ml-2 text-xs text-yellow-400 hover:underline">
                            <span class="material-icons text-base">edit</span>
                        </a>
                        <form action="{{ route('questions.destroy', $q->id) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs text-red-400 hover:underline ml-2" onclick="return confirm('Hapus pertanyaan?')">
                                <span class="material-icons text-base">delete</span>
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        @endforeach

        <div class="mt-6">
            {{ $questions->appends(request()->query())->links() }}
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-8">
        {{-- Leaderboard Singkat --}}
        <div class="bg-gray-800 rounded-xl shadow p-4 border border-gray-700">
            <h3 class="text-lg font-bold mb-4 text-blue-400">Highest Points</h3>
            <ol>
                @foreach($topUsers as $user)
                    <li class="flex items-center mb-4">
                        {{-- Foto/avatar user --}}
                        @if($user->photo)
                            <img src="{{ asset('storage/photo/'.$user->photo) }}" class="w-10 h-10 rounded-full mr-3 border border-gray-600 shadow">
                        @else
                            <div class="w-10 h-10 rounded-full bg-blue-500/20 flex items-center justify-center text-blue-300 font-bold mr-3 border border-gray-600">
                                {{ strtoupper(substr($user->name, 0, 2)) }}
                            </div>
                        @endif
                        <div>
                            <div class="font-semibold text-white">{{ $user->name }}</div>
                            <div class="text-xs text-gray-400">{{ $user->points }} points</div>
                        </div>
                    </li>
                @endforeach
            </ol>
            <a href="{{ route('leaderboard') }}" class="block text-center text-xs text-blue-400 hover:text-blue-300 hover:underline mt-2">Lihat semua &raquo;</a>
        </div>

        {{-- Kategori Forum --}}
        @include('partials.forum_categories', [ 'topCategories' => $topCategories ?? collect(),'remainingCategories' => $remainingCategories ?? collect(),'selectedCategory' => $selectedCategory ?? null])

        {{-- Kalender sidebar --}}
        @include('partials.calendar-sidebar')
    </div>
</div>

<!-- Floating button Tanya (mobile) -->
<a href="{{ route('questions.create') }}" class="md:hidden fixed bottom-6 right-6 bg-blue-600 hover:bg-blue-500 text-white rounded-full w-16 h-16 flex items-center justify-center text-3xl shadow-lg z-50">
    <span class="material-icons text-3xl">add</span>
</a>

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

.text-gray-500 {
    color: #6b7280 !important;
}

/* Background untuk empty state */
.text-gray-400 {
    color: #9ca3af !important;
}

/* Shadow adjustments */
.shadow {
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.3), 0 1px 2px 0 rgba(0, 0, 0, 0.2) !important;
}

.shadow-lg {
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3), 0 4px 6px -2px rgba(0, 0, 0, 0.2) !important;
}

/* Hero section gradient */
.bg-gradient-to-r.from-blue-900.to-blue-700 {
    background-image: linear-gradient(to right, #1e3a8a, #1d4ed8) !important;
}

/* Hover effects */
.hover\:bg-gray-600:hover {
    background-color: #4b5563 !important;
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

    .border-gray-200 {
        border-color: #374151 !important;
    }

    /* Memastikan input tetap gelap */
    input {
        background-color: #374151 !important;
        color: #e5e7eb !important;
        border-color: #4b5563 !important;
    }

    input::placeholder {
        color: #9ca3af !important;
    }
}

/* Pagination styling (jika menggunakan Tailwind pagination) */
.pagination {
    display: flex;
    justify-content: center;
    margin-top: 2rem;
}

.pagination .page-item .page-link {
    background-color: #374151;
    border: 1px solid #4b5563;
    color: #d1d5db;
    padding: 0.5rem 1rem;
    margin: 0 0.25rem;
    border-radius: 0.375rem;
}

.pagination .page-item.active .page-link {
    background-color: #3b82f6;
    border-color: #3b82f6;
    color: white;
}

.pagination .page-item .page-link:hover {
    background-color: #4b5563;
    border-color: #6b7280;
}

/* Transisi smooth */
.transition {
    transition: all 0.2s ease;
}
</style>
@endsection
