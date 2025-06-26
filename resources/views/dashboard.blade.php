@extends('layouts.app')

@section('content')

{{-- NAVBAR NOTIFIKASI --}}
<div class="flex justify-end mb-3">
    <div class="relative inline-block">
        <button id="notif-btn" class="relative focus:outline-none">
            <span class="material-icons text-3xl text-blue-accent align-middle">notifications</span>
            @if(isset($notifications) && collect($notifications)->where('read', 0)->count() > 0)
                <span class="absolute top-0 right-0 w-3 h-3 bg-red-500 rounded-full border-2 border-white"></span>
            @endif
        </button>
        {{-- Dropdown notifikasi --}}
        <div id="notif-dropdown" class="hidden absolute right-0 mt-2 w-80 max-w-xs bg-white rounded-lg shadow-lg border border-gray-200 z-50">
            <div class="p-4 font-bold text-blue-accent border-b border-gray-100">Notifikasi Terbaru</div>
            <ul class="max-h-80 overflow-y-auto">
                @if(isset($notifications) && (is_array($notifications) ? count($notifications) : $notifications->count()))
                    @foreach($notifications as $notif)
                        <li class="px-4 py-3 border-b border-gray-100 text-sm @if(!$notif->read) bg-blue-50 @endif">
                            @if($notif->type == 'answer')
                                <span class="material-icons text-base text-blue-600 align-middle mr-1">question_answer</span>
                                <b>{{ $notif->data['message'] ?? '' }}</b>
                                <a href="{{ route('questions.show', $notif->data['question_id'] ?? 0) }}" class="text-blue-500 hover:underline">Lihat</a>
                            @elseif($notif->type == 'like')
                                <span class="material-icons text-base text-pink-600 align-middle mr-1">thumb_up</span>
                                {{ $notif->data['message'] ?? '' }}
                            @elseif($notif->type == 'mention')
                                <span class="material-icons text-base text-yellow-600 align-middle mr-1">alternate_email</span>
                                {{ $notif->data['message'] ?? '' }}
                            @elseif($notif->type == 'comment_like')
                                <span class="material-icons text-base text-green-600 align-middle mr-1">favorite</span>
                                {{ $notif->data['message'] ?? '' }}
                            @else
                                {{ $notif->data['message'] ?? '' }}
                            @endif
                            <span class="block text-xs text-gray-400 mt-1">{{ \Illuminate\Support\Carbon::parse($notif->created_at)->diffForHumans() }}</span>
                        </li>
                    @endforeach
                @else
                    <li class="px-4 py-4 text-gray-400 text-center">Belum ada notifikasi</li>
                @endif
            </ul>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btn = document.getElementById('notif-btn');
        const dd = document.getElementById('notif-dropdown');
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            dd.classList.toggle('hidden');
        });
        document.addEventListener('click', function() {
            dd.classList.add('hidden');
        });
    });
</script>

{{-- HERO SECTION --}}
<div class="w-full bg-blue-accent rounded-xl shadow mb-10 pt-14 pb-12 px-6 md:px-16 flex flex-col items-center justify-center text-center relative"
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
        <a href="{{ route('dashboard', ['filter' => 'terbaru']) }}" class="{{ $tabClasses }} {{ $active == 'terbaru' ? 'bg-blue-accent text-white' : 'bg-gray-200 text-gray-700' }}">
            <span class="material-icons align-middle mr-1 text-base">new_releases</span> Terbaru
        </a>
        <a href="{{ route('dashboard', ['filter' => 'terbanyak']) }}" class="{{ $tabClasses }} {{ $active == 'terbanyak' ? 'bg-blue-accent text-white' : 'bg-gray-200 text-gray-700' }}">
            <span class="material-icons align-middle mr-1 text-base">thumb_up</span> Respon Terbanyak
        </a>
        <a href="{{ route('dashboard', ['filter' => 'baru-dijawab']) }}" class="{{ $tabClasses }} {{ $active == 'baru-dijawab' ? 'bg-blue-accent text-white' : 'bg-gray-200 text-gray-700' }}">
            <span class="material-icons align-middle mr-1 text-base">check_circle</span> Baru Dijawab
        </a>
        <a href="{{ route('dashboard', ['filter' => 'belum-dijawab']) }}" class="{{ $tabClasses }} {{ $active == 'belum-dijawab' ? 'bg-blue-accent text-white' : 'bg-gray-200 text-gray-700' }}">
            <span class="material-icons align-middle mr-1 text-base">help</span> Belum Dijawab
        </a>
    </div>
    <form method="GET" action="{{ route('dashboard') }}" class="flex-1 flex justify-end">
        <input type="text" name="search" placeholder="Cari pertanyaan atau #hashtag..." value="{{ request('search') }}"
            class="w-full md:w-64 px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-accent text-gray-800 placeholder-gray-400" />
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
        <div class="bg-white rounded-xl shadow p-6 border border-gray-200 mb-2">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 rounded-full bg-blue-accent flex items-center justify-center text-white font-bold">
                    {{ strtoupper(substr($q->user->name,0,2)) }}
                </div>
                <div class="font-semibold text-gray-700">{{ $q->user->name }}</div>
                <span class="text-xs text-gray-400 ml-2">{{ $q->created_at->diffForHumans() }}</span>
            </div>
            <a href="{{ route('questions.show', $q->id) }}" class="block text-lg md:text-xl font-bold text-blue-accent hover:underline mt-1">
                {{ $q->title }}
            </a>
            <div class="my-2 text-gray-700">
                {{ \Illuminate\Support\Str::limit($q->content, 180) }}
            </div>
            <div class="flex flex-wrap items-center gap-2 mt-3">
                {{-- Tag --}}
                @if(isset($q->hashtags) && count($q->hashtags))
                    @foreach($q->hashtags as $tag)
                        <span class="bg-blue-100 text-blue-accent px-2 py-0.5 rounded text-xs font-medium">#{{ is_object($tag) ? $tag->name : $tag }}</span>
                    @endforeach
                @endif
                <div class="flex items-center gap-3 ml-auto">
                    <span class="flex items-center gap-1 text-gray-500">
                        <span class="material-icons text-base">thumb_up</span> {{ $q->likes_count ?? 0 }}
                    </span>
                    <span class="flex items-center gap-1 text-gray-500">
                        <span class="material-icons text-base">comment</span> {{ $q->comments_count ?? 0 }}
                    </span>
                    @if(auth()->id() == $q->user->id)
                        <a href="{{ route('questions.edit', $q->id) }}" class="ml-2 text-xs text-yellow-600 hover:underline">
                            <span class="material-icons text-base">edit</span>
                        </a>
                        <form action="{{ route('questions.destroy', $q->id) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs text-red-600 hover:underline ml-2" onclick="return confirm('Hapus pertanyaan?')">
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
</div>

<!-- Floating button Tanya (mobile) -->
<a href="{{ route('questions.create') }}" class="md:hidden fixed bottom-6 right-6 bg-blue-accent hover:bg-blue-700 text-white rounded-full w-16 h-16 flex items-center justify-center text-3xl shadow-lg z-50">
    <span class="material-icons text-3xl">add</span>
</a>
@endsection