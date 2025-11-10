@extends('layouts.app')

@section('content')
    <div class="bg-gray-900 min-h-screen py-10 px-2">
        <div class="container mx-auto">
            <div class="max-w-4xl mx-auto bg-gray-800 rounded-xl shadow-md overflow-hidden border border-gray-700">
                <!-- Header Profil -->
                <div class="bg-gradient-to-r from-blue-900 to-blue-700 px-8 pt-8 pb-6 rounded-t-xl text-center">
                    <h1 class="text-2xl md:text-3xl font-bold text-white">Profil Pengguna</h1>
                    <p class="opacity-90 text-blue-100 md:text-lg">Informasi akun forum kampus Anda</p>
                </div>
                <!-- Konten Profil -->
                <div class="md:flex px-8 py-8 gap-8">
                    <!-- Bagian Kiri -->
                    <div class="md:w-1/3 flex flex-col items-center">
                        <div class="relative -mt-20 mb-4">
                            @if ($user->photo)
                                <img src="{{ asset('storage/photo/' . $user->photo) }}" alt="Foto Profil"
                                    class="w-40 h-40 rounded-full object-cover border-4 border-gray-800 shadow-lg bg-gray-700">
                            @else
                                <div
                                    class="w-40 h-40 flex items-center justify-center rounded-full bg-blue-500/20 text-blue-300 text-5xl font-bold border-4 border-gray-800 shadow-lg">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                            @endif
                            <div
                                class="absolute bottom-2 right-2 bg-green-500 rounded-full p-2 border-2 border-gray-800 shadow">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <div class="text-center mb-4">
                            <h2 class="text-xl font-semibold text-white">{{ $user->name }}</h2>
                            <p class="text-gray-400 text-sm">Anggota sejak:
                                {{ $user->created_at ? $user->created_at->translatedFormat('d F Y') : '-' }}</p>
                        </div>

                        <!-- Badge Display -->
                        <div class="mb-6 text-center">
                            <h3 class="text-sm font-semibold text-gray-400 mb-2">Pencapaian</h3>
                            <div class="flex flex-wrap justify-center gap-2 mb-3">
                                @foreach ($user->badges as $badge)
                                    <div class="badge-item" title="{{ $badge->description }}">
                                        <div
                                            class="bg-yellow-500/20 text-yellow-300 rounded-full p-2 cursor-pointer hover:scale-110 transition-transform border border-yellow-500/30">
                                            @if ($badge->icon)
                                                <img src="{{ asset('storage/badges/' . $badge->icon) }}"
                                                    alt="{{ $badge->name }}" class="w-6 h-6 inline">
                                            @else
                                                <i class="fas fa-trophy text-sm"></i>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <p class="text-xs text-gray-500">Klik badge untuk detail</p>
                        </div>
                        <p class="text-white font-semibold">Total Poin: {{ $user->points ?? 0 }}</p>

                        <!-- Statistik -->
                        <div
                            class="w-full bg-gray-700 rounded-lg p-4 mb-4 flex justify-center gap-6 shadow border border-gray-600">
                            <div class="text-center">
                                <p class="text-xl font-bold text-white">{{ $threadCount ?? ($user->questions_count ?? 0) }}
                                </p>
                                <p class="text-xs text-gray-400">Pertanyaan</p>
                            </div>
                            <div class="text-center">
                                <p class="text-xl font-bold text-white">{{ $commentCount ?? ($user->comments_count ?? 0) }}
                                </p>
                                <p class="text-xs text-gray-400">Komentar</p>
                            </div>
                            <div class="text-center">
                                <p class="text-xl font-bold text-white">{{ $likeCount ?? 0 }}</p>
                                <p class="text-xs text-gray-400">Like</p>
                            </div>
                        </div>
                        <div class="w-full mb-6 mt-2">
                            <h4 class="text-sm font-semibold text-gray-300 mb-3 text-center">🌐 Media Sosial & Links</h4>

                            @php
                                $iconMap = [
                                    'instagram' => 'fab fa-instagram text-pink-400',
                                    'github' => 'fab fa-github text-gray-300',
                                    'facebook' => 'fab fa-facebook text-blue-400',
                                    'linkedin' => 'fab fa-linkedin text-blue-300',
                                    'website' => 'fas fa-globe text-blue-300',
                                    'twitter' => 'fab fa-twitter text-blue-200',
                                    'google' => 'fab fa-google text-red-400',
                                    'other' => 'fas fa-link text-gray-400',
                                ];
                            @endphp

                            @if ($user->socialLinks && $user->socialLinks->where('visible', true)->isNotEmpty())
                                <div class="space-y-2">
                                    @foreach ($user->socialLinks->where('visible', true) as $link)
                                        @php
                                            $iconClass = $iconMap[$link->type] ?? 'fas fa-link text-gray-400';
                                            $label =
                                                $link->label ?:
                                                parse_url($link->url, PHP_URL_HOST) .
                                                    (parse_url($link->url, PHP_URL_PATH)
                                                        ? parse_url($link->url, PHP_URL_PATH)
                                                        : '');
                                        @endphp
                                        <div
                                            class="flex items-center justify-between py-2 px-3 bg-gray-700 rounded-lg border border-gray-600 hover:border-blue-400 transition-colors">
                                            <div class="flex items-center space-x-3">
                                                <i class="{{ $iconClass }} text-lg"></i>
                                                <span class="text-gray-300 text-sm">{{ $label }}</span>
                                            </div>
                                            <a href="{{ $link->url }}" target="_blank" rel="noopener"
                                                class="text-blue-400 hover:text-blue-300">
                                                <i class="fas fa-external-link-alt text-sm"></i>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div
                                    class="w-full mb-4 text-center text-sm text-gray-500 border border-dashed border-gray-600 rounded-lg p-3">
                                    Belum ada media sosial. Edit profil untuk menambahkan.
                                </div>
                            @endif
                        </div>
                        @if (auth()->id() == $user->id)
                            <div class="w-full space-y-4 mt-6">
                                <!-- Tombol Edit Profile -->
                                <a href="{{ route('profile.edit', $user->id) }}"
                                    class="group inline-flex items-center justify-center w-full bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:from-blue-600 hover:via-blue-700 hover:to-blue-800 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 hover:-translate-y-1 shadow-lg hover:shadow-2xl border border-blue-400/30 relative overflow-hidden">
                                    <div
                                        class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -skew-x-12 transform translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000">
                                    </div>
                                    <svg class="w-5 h-5 mr-3 transition-transform duration-300 group-hover:scale-110"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    <span class="relative">Edit Profile</span>
                                </a>

                                <!-- Tombol Log Out -->
                                <form method="POST" action="{{ route('logout') }}" class="w-full">
                                    @csrf
                                    <button type="submit"
                                        class="group inline-flex items-center justify-center w-full bg-gradient-to-r from-red-500 via-red-600 to-red-700 hover:from-red-600 hover:via-red-700 hover:to-red-800 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 hover:-translate-y-1 shadow-lg hover:shadow-2xl border border-red-400/30 relative overflow-hidden">
                                        <div
                                            class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -skew-x-12 transform translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000">
                                        </div>
                                        <svg class="w-5 h-5 mr-3 transition-transform duration-300 group-hover:scale-110"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        <span class="relative">Log Out</span>
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                    <!-- Bagian Kanan -->
                    <div class="md:w-2/3 md:pl-8 mt-6 md:mt-0 flex flex-col gap-8">
                        <!-- Informasi Pribadi -->
                        <div>
                            <h3 class="text-lg font-semibold text-white border-b border-gray-600 pb-2 mb-4">Informasi
                                Pribadi</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-400">Nama Lengkap</p>
                                    <p class="font-medium text-white">{{ $user->name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-400">Jenis Kelamin</p>
                                    <p class="font-medium text-white">{{ $user->gender ?? '-' }}</p>
                                </div>
                                @if ($user->role === 'mahasiswa')
                                    <div>
                                        <p class="text-sm text-gray-400">NIM</p>
                                        <p class="font-medium text-white">{{ $user->nim ?? ($user->username ?? '-') }}</p>
                                    </div>
                                @elseif($user->role === 'dosen')
                                    <div>
                                        <p class="text-sm text-gray-400">NIDN</p>
                                        <p class="font-medium text-white">{{ $user->nidm ?? ($user->username ?? '-') }}</p>
                                    </div>
                                @endif

                                @if ($user->role === 'mahasiswa')
                                    <div>
                                        <p class="text-sm text-gray-400">Program Studi</p>
                                        <p class="font-medium text-white">
                                            {{ $user->prodi ?? '-' }}
                                        </p>
                                    </div>
                                @elseif($user->role === 'dosen')
                                    <div>
                                        <p class="text-sm text-gray-400">Mata Kuliah Diampu</p>
                                        <p class="font-medium text-white">
                                            {{ $user->prodi ?? '-' }}
                                        </p>
                                    </div>
                                @endif
                                @if ($user->role === 'mahasiswa')
                                    <div>
                                        <p class="text-sm text-gray-400">Angkatan</p>
                                        <p class="font-medium text-white">
                                            {{ $user->angkatan ?? ($user->profile->angkatan ?? '-') }}
                                        </p>
                                    </div>
                                @endif
                                <div>
                                    <p class="text-sm text-gray-400">Email</p>
                                    <p class="font-medium text-white">{{ $user->email }}</p>
                                </div>
                            </div>
                        </div>
                        <!-- Bio Singkat -->
                        <div>
                            <h3 class="text-lg font-semibold text-white border-b border-gray-600 pb-2 mb-4">Bio Singkat
                            </h3>
                            <div class="bg-gray-700 rounded-lg p-4 text-gray-300 shadow border border-gray-600">
                                {{ $user->bio ?? ($user->profile->bio ?? '-') }}
                            </div>
                        </div>
                        <!-- Pertanyaan oleh User -->
                        <div>
                            <h3 class="text-lg font-semibold text-white border-b border-gray-600 pb-2 mb-4">Pertanyaan oleh
                                {{ $user->name }}</h3>
                            <div class="bg-gray-700 rounded-lg p-6 text-center border border-gray-600">
                                @if (isset($threads) && count($threads))
                                    <ul class="divide-y divide-gray-600">
                                        @foreach ($threads as $thread)
                                            <li class="py-3">
                                                <a href="{{ route('questions.show', $thread->id) }}"
                                                    class="text-blue-400 font-medium hover:text-blue-300 hover:underline">
                                                    {{ $thread->title }}
                                                </a>
                                                <span
                                                    class="block text-xs text-gray-400">{{ $thread->created_at->diffForHumans() }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-500 mb-3"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="text-gray-400 font-medium">Belum ada Pertanyaan.</p>
                                    <p class="text-sm text-gray-500 mt-1">Pertanyaan yang dibuat akan muncul di sini</p>
                                @endif
                            </div>
                        </div>
                        <!-- Komentar oleh User -->
                        <div>
                            <h3 class="text-lg font-semibold text-white border-b border-gray-600 pb-2 mb-4">Komentar oleh
                                {{ $user->name }}</h3>
                            <div class="bg-gray-700 rounded-lg p-6 text-center border border-gray-600">
                                @if (isset($comments) && count($comments))
                                    <ul class="divide-y divide-gray-600">
                                        @foreach ($comments as $comment)
                                            <li class="py-3">
                                                <span
                                                    class="text-gray-300">{{ \Illuminate\Support\Str::limit($comment->content, 80) }}</span>
                                                <a href="{{ route('questions.show', $comment->question_id) }}#comment-{{ $comment->id }}"
                                                    class="ml-2 text-xs text-blue-400 hover:text-blue-300 hover:underline">Lihat</a>
                                                <span
                                                    class="block text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-500 mb-3"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                    <p class="text-gray-400 font-medium">Belum ada komentar.</p>
                                    <p class="text-sm text-gray-500 mt-1">Komentar yang diberikan akan muncul di sini</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* MEMASTIKAN BACKGROUND HALAMAN TETAP GELAP */
        body {
            background-color: #111827 !important;
            color: #e5e7eb !important;
        }

        /* Override untuk semua elemen container */
        .bg-white,
        .bg-gray-50,
        .bg-gray-100 {
            background-color: #1f2937 !important;
        }

        /* Untuk card/container spesifik */
        .bg-gray-800 {
            background-color: #1f2937 !important;
        }

        .bg-gray-700 {
            background-color: #374151 !important;
        }

        .bg-gray-900 {
            background-color: #111827 !important;
        }

        .border-gray-700 {
            border-color: #374151 !important;
        }

        .border-gray-600 {
            border-color: #4b5563 !important;
        }

        /* Text colors */
        .text-gray-800,
        .text-gray-700,
        .text-gray-600 {
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

        /* Shadow adjustments */
        .shadow-md {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3), 0 2px 4px -1px rgba(0, 0, 0, 0.2) !important;
        }

        .shadow-lg {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3), 0 4px 6px -2px rgba(0, 0, 0, 0.2) !important;
        }

        /* Hero section gradient */
        .bg-gradient-to-r.from-blue-900.to-blue-700 {
            background-image: linear-gradient(to right, #1e3a8a, #1d4ed8) !important;
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
        }

        /* Transisi smooth */
        .transition {
            transition: all 0.2s ease;
        }

        .transform {
            transition: transform 0.2s ease;
        }

        /* Hover effects */
        .hover\:scale-105:hover {
            transform: scale(1.05);
        }

        /* Divide colors */
        .divide-gray-200 {
            border-color: #374151 !important;
        }

        .divide-gray-600 {
            border-color: #4b5563 !important;
        }
    </style>
@endsection
