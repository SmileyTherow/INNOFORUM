@extends('layouts.app')

@section('content')
    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Profil Pengguna</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            dark: {
                                900: '#0f172a',
                                800: '#1e293b',
                                700: '#334155',
                                600: '#475569',
                                500: '#64748b',
                            }
                        },
                        animation: {
                            'fade-in': 'fadeIn 0.5s ease-in-out',
                            'slide-up': 'slideUp 0.5s ease-out',
                            'pulse-glow': 'pulseGlow 2s infinite',
                        },
                        keyframes: {
                            fadeIn: {
                                '0%': {
                                    opacity: '0'
                                },
                                '100%': {
                                    opacity: '1'
                                },
                            },
                            slideUp: {
                                '0%': {
                                    transform: 'translateY(20px)',
                                    opacity: '0'
                                },
                                '100%': {
                                    transform: 'translateY(0)',
                                    opacity: '1'
                                },
                            },
                            pulseGlow: {
                                '0%, 100%': {
                                    boxShadow: '0 0 5px rgba(59, 130, 246, 0.5)'
                                },
                                '50%': {
                                    boxShadow: '0 0 20px rgba(59, 130, 246, 0.8)'
                                },
                            }
                        }
                    }
                }
            }
        </script>
    </head>

    <body class="bg-dark-900 text-gray-100 min-h-screen">
        <div class="min-h-screen py-8 px-4">
            <div class="max-w-6xl mx-auto">
                <!-- Header dengan animasi -->
                <div class="text-center mb-10 animate-fade-in">
                    <h1
                        class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-blue-400 to-purple-500 bg-clip-text text-transparent">
                        Profil Pengguna</h1>
                    <p class="text-gray-400 mt-2">Kelola informasi akun forum kampus Anda</p>
                </div>

                <!-- Container utama -->
                <div class="bg-dark-800 rounded-2xl shadow-2xl overflow-hidden border border-dark-600 animate-slide-up">
                    <!-- Header dengan gradient dinamis -->
                    <div class="h-40 bg-gradient-to-r from-blue-900 via-purple-900 to-indigo-900 relative">
                        <div class="absolute inset-0 bg-black/20"></div>

                    </div>

                    <!-- Konten utama -->
                    <div class="md:flex px-6 py-8 gap-8 -mt-16 relative z-10">
                        <!-- Sidebar kiri -->
                        <div class="md:w-1/3 flex flex-col items-center mb-8 md:mb-0">
                            <!-- Foto profil dengan frame -->
                            <div class="relative mb-6 group">
                                @if ($user->photo)
                                    <div class="relative">
                                        <img src="{{ asset('storage/photo/' . $user->photo) }}" alt="Foto Profil"
                                            class="w-40 h-40 rounded-full object-cover border-4 border-dark-700 shadow-xl bg-dark-700 group-hover:border-blue-500 transition-all duration-300">
                                        <div
                                            class="absolute inset-0 rounded-full bg-blue-500/20 group-hover:bg-blue-500/10 transition-all duration-300">
                                        </div>
                                    </div>
                                @else
                                    <div
                                        class="w-40 h-40 flex items-center justify-center rounded-full bg-gradient-to-br from-blue-500/30 to-purple-500/30 text-blue-300 text-5xl font-bold border-4 border-dark-700 shadow-xl group-hover:border-blue-500 transition-all duration-300">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                @endif

                                <!-- Status online -->
                                <div
                                    class="absolute bottom-2 right-2 bg-green-500 rounded-full p-2 border-2 border-dark-800 shadow-lg animate-pulse-glow">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>

                            <!-- Nama dan role -->
                            <div class="text-center mb-6">
                                <h2 class="text-xl font-bold text-white">{{ $user->name }}</h2>
                                <p class="text-blue-200 text-sm">Anggota sejak:
                                    {{ $user->created_at ? $user->created_at->translatedFormat('d F Y') : '-' }}</p>
                                <div
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium mt-2
                                @if ($user->role === 'mahasiswa') bg-blue-500/20 text-blue-300
                                @elseif($user->role === 'dosen') bg-purple-500/20 text-purple-300
                                @else bg-gray-500/20 text-gray-300 @endif">
                                    <span
                                        class="w-2 h-2 rounded-full mr-2
                                    @if ($user->role === 'mahasiswa') bg-blue-400
                                    @elseif($user->role === 'dosen') bg-purple-400
                                    @else bg-gray-400 @endif"></span>
                                    {{ ucfirst($user->role) }}
                                </div>
                            </div>

                            <!-- Poin dan level -->
                            <div
                                class="w-full bg-dark-700/50 backdrop-blur-sm rounded-xl p-4 mb-6 border border-dark-600 shadow-lg">
                                <div class="flex justify-between items-center mb-3">
                                    <span class="text-gray-400 text-sm">Total Poin</span>
                                    <span class="text-yellow-400 font-bold">{{ $user->points ?? 0 }}</span>
                                </div>
                                <div class="w-full bg-dark-600 rounded-full h-2">
                                    <div class="bg-gradient-to-r from-yellow-500 to-yellow-300 h-2 rounded-full"
                                        style="width: {{ min(($user->points ?? 0) / 10, 100) }}%"></div>
                                </div>
                            </div>

                            <!-- Badge Display -->
                            <!-- BADGE DISPLAY -->
                            <div class="w-full mb-6">
                                <h3 class="text-sm font-semibold text-gray-300 mb-3 text-center">🏆 Pencapaian</h3>
                                <div class="flex flex-wrap justify-center gap-3 mb-3">
                                    @foreach ($user->badges as $badge)
                                        <div class="badge-item group relative cursor-pointer"
                                            data-badge-name="{{ $badge->name }}"
                                            data-badge-desc="{{ $badge->description }}"
                                            data-badge-icon="{{ $badge->icon }}"
                                            data-badge-date="{{ $badge->pivot->awarded_at ? date('d F Y', strtotime($badge->pivot->awarded_at)) : '' }}"
                                            title="Klik untuk detail">
                                            <div
                                                class="flex items-center justify-center cursor-pointer hover:scale-110 transition-all">
                                                @if (!empty($badge->icon))
                                                    <img src="{{ asset('images/badges/' . $badge->icon) }}"
                                                        alt="{{ $badge->name }}"
                                                        class="w-20 h-20 md:w-24 md:h-24 object-contain" />
                                                @else
                                                    <i class="fas fa-trophy text-3xl md:text-4xl"></i>
                                                @endif
                                            </div>
                                            <div
                                                class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-1 bg-dark-800 text-xs text-white rounded-lg opacity-0 pointer-events-none group-hover:opacity-100 transition-opacity duration-300 z-10 whitespace-nowrap border border-dark-600 shadow-lg">
                                                {{ $badge->name }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- MODAL BADGE BARU, PASANG DI LUAR LOOP BADGE -->
                                <div id="badgeModal"
                                    class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 hidden">
                                    <div
                                        class="bg-dark-800 rounded-2xl shadow-2xl w-full max-w-md mx-4 p-0 ring-1 ring-dark-700 border border-dark-600">
                                        <div class="flex justify-between items-center px-6 py-5 border-b border-dark-700">
                                            <h3 class="text-2xl font-bold text-white" id="badgeModalTitle">Detail Badge</h3>
                                            <button id="closeBadgeModal" class="text-gray-400 hover:text-gray-200">
                                                <i class="fas fa-times text-2xl"></i>
                                            </button>
                                        </div>
                                        <div class="py-8 px-8 flex flex-col items-center">
                                            <div class="flex items-center justify-center mb-4" style="min-height: 8rem;">
                                                <span id="badgeModalIcon" class="block"></span>
                                            </div>
                                            <h4 id="badgeModalName"
                                                class="text-xl font-semibold text-center text-white mb-3"></h4>
                                            <p id="badgeModalDescription" class="text-base text-gray-300 text-center mb-4">
                                            </p>
                                            <div class="bg-dark-700/70 rounded-xl p-3 w-full flex flex-col items-center">
                                                <span id="badgeModalDate" class="text-sm text-gray-400"></span>
                                            </div>
                                        </div>
                                        <div class="flex justify-end px-7 pb-7 border-t border-dark-700 pt-5">
                                            <button id="closeBadgeModalBtn"
                                                class="px-6 py-2 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition-all duration-200">
                                                Tutup
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- (Bagian badge tambahan & statistik lanjutkan di bawah ini...) -->
                                <div class="flex justify-center gap-6 mt-3">
                                    @if (!empty($responderFile))
                                        <div class="text-center">
                                            <img src="{{ asset('images/badges/' . $responderFile) }}" alt="Penjawab Badge"
                                                class="w-20 h-20 object-contain mx-auto">
                                            <div class="text-xs text-gray-400 mt-2">Menjawab Terbanyak</div>
                                        </div>
                                    @endif
                                    @if (!empty($likeFile))
                                        <div class="text-center">
                                            <img src="{{ asset('images/badges/' . $likeFile) }}" alt="Pencerah Badge"
                                                class="w-20 h-20 object-contain mx-auto">
                                            <div class="text-xs text-gray-400 mt-2">Like Terbanyak</div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Statistik -->
                            <div
                                class="w-full bg-dark-700/50 backdrop-blur-sm rounded-xl p-4 mb-6 border border-dark-600 shadow-lg">
                                <h3 class="text-sm font-semibold text-gray-300 mb-3 text-center">📊 Statistik Aktivitas</h3>
                                <div class="grid grid-cols-3 gap-4">
                                    <div class="text-center">
                                        <div
                                            class="bg-blue-500/20 rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-2">
                                            <i class="fas fa-question text-blue-400"></i>
                                        </div>
                                        <p class="text-xl font-bold text-white">
                                            {{ $threadCount ?? ($user->questions_count ?? 0) }}</p>
                                        <p class="text-xs text-gray-400">Pertanyaan</p>
                                    </div>
                                    <div class="text-center">
                                        <div
                                            class="bg-green-500/20 rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-2">
                                            <i class="fas fa-comment text-green-400"></i>
                                        </div>
                                        <p class="text-xl font-bold text-white">
                                            {{ $commentCount ?? ($user->comments_count ?? 0) }}</p>
                                        <p class="text-xs text-gray-400">Komentar</p>
                                    </div>
                                    <div class="text-center">
                                        <div
                                            class="bg-red-500/20 rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-2">
                                            <i class="fas fa-heart text-red-400"></i>
                                        </div>
                                        <p class="text-xl font-bold text-white">{{ $likeCount ?? 0 }}</p>
                                        <p class="text-xs text-gray-400">Like</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Media Sosial -->
                            <div class="w-full mb-6">
                                <h3 class="text-sm font-semibold text-gray-300 mb-3 text-center">🌐 Media Sosial</h3>

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
                                            <a href="{{ $link->url }}" target="_blank" rel="noopener"
                                                class="flex items-center justify-between py-2 px-3 bg-dark-700 rounded-lg border border-dark-600 hover:border-blue-400 transition-all duration-300 group">
                                                <div class="flex items-center space-x-3">
                                                    <i class="{{ $iconClass }} text-lg"></i>
                                                    <span
                                                        class="text-gray-300 text-sm group-hover:text-white">{{ $label }}</span>
                                                </div>
                                                <i
                                                    class="fas fa-external-link-alt text-sm text-blue-400 group-hover:text-blue-300"></i>
                                            </a>
                                        @endforeach
                                    </div>
                                @else
                                    <div
                                        class="text-center text-gray-500 text-sm py-4 border border-dashed border-dark-600 rounded-lg">
                                        <i class="fas fa-share-alt text-lg mb-2 block"></i>
                                        Belum ada media sosial
                                    </div>
                                @endif
                            </div>

                            <!-- Tombol Aksi -->
                            @if (auth()->id() == $user->id)
                                <div class="w-full space-y-3 mt-4">
                                    <!-- Tombol Edit Profile -->
                                    <a href="{{ route('profile.edit', $user->id) }}"
                                        class="group flex items-center justify-center w-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-medium py-3 px-4 rounded-xl transition-all duration-300 transform hover:scale-[1.02] shadow-lg hover:shadow-blue-500/20 border border-blue-400/30">
                                        <svg class="w-5 h-5 mr-2 transition-transform duration-300 group-hover:rotate-12"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        <span>Edit Profile</span>
                                    </a>

                                    <!-- Tombol Log Out -->
                                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                                        @csrf
                                        <button type="submit"
                                            class="group flex items-center justify-center w-full bg-gradient-to-r from-dark-600 to-dark-700 hover:from-dark-700 hover:to-dark-800 text-white font-medium py-3 px-4 rounded-xl transition-all duration-300 transform hover:scale-[1.02] shadow-lg border border-dark-500/30">
                                            <svg class="w-5 h-5 mr-2 transition-transform duration-300 group-hover:rotate-12"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                            </svg>
                                            <span>Log Out</span>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>

                        <!-- Konten kanan -->
                        <div class="md:w-2/3 md:pl-8 flex flex-col gap-8">
                            <!-- Informasi Pribadi -->
                            <div class="bg-dark-700/50 backdrop-blur-sm rounded-xl p-6 border border-dark-600 shadow-lg">
                                <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                                    <i class="fas fa-user-circle text-blue-400 mr-2"></i>
                                    Informasi Pribadi
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="bg-dark-800/50 rounded-lg p-3 border border-dark-600">
                                        <p class="text-sm text-gray-400">Nama Lengkap</p>
                                        <p class="font-medium text-white mt-1">{{ $user->name }}</p>
                                    </div>
                                    <div class="bg-dark-800/50 rounded-lg p-3 border border-dark-600">
                                        <p class="text-sm text-gray-400">Jenis Kelamin</p>
                                        <p class="font-medium text-white mt-1">{{ $user->gender ?? '-' }}</p>
                                    </div>
                                    @if ($user->role === 'mahasiswa')
                                        <div class="bg-dark-800/50 rounded-lg p-3 border border-dark-600">
                                            <p class="text-sm text-gray-400">NIM</p>
                                            <p class="font-medium text-white mt-1">
                                                {{ $user->nim ?? ($user->username ?? '-') }}</p>
                                        </div>
                                    @elseif($user->role === 'dosen')
                                        <div class="bg-dark-800/50 rounded-lg p-3 border border-dark-600">
                                            <p class="text-sm text-gray-400">NIDN</p>
                                            <p class="font-medium text-white mt-1">
                                                {{ $user->nidm ?? ($user->username ?? '-') }}</p>
                                        </div>
                                    @endif

                                    @if ($user->role === 'mahasiswa')
                                        <div class="bg-dark-800/50 rounded-lg p-3 border border-dark-600">
                                            <p class="text-sm text-gray-400">Program Studi</p>
                                            <p class="font-medium text-white mt-1">
                                                {{ $user->prodi ?? '-' }}
                                            </p>
                                        </div>
                                    @elseif($user->role === 'dosen')
                                        <div class="bg-dark-800/50 rounded-lg p-3 border border-dark-600">
                                            <p class="text-sm text-gray-400">Mata Kuliah Diampu</p>
                                            <p class="font-medium text-white mt-1">
                                                {{ $user->prodi ?? '-' }}
                                            </p>
                                        </div>
                                    @endif
                                    @if ($user->role === 'mahasiswa')
                                        <div class="bg-dark-800/50 rounded-lg p-3 border border-dark-600">
                                            <p class="text-sm text-gray-400">Angkatan</p>
                                            <p class="font-medium text-white mt-1">
                                                {{ $user->angkatan ?? ($user->profile->angkatan ?? '-') }}
                                            </p>
                                        </div>
                                    @endif
                                    <div class="bg-dark-800/50 rounded-lg p-3 border border-dark-600">
                                        <p class="text-sm text-gray-400">Email</p>
                                        <p class="font-medium text-white mt-1">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Bio Singkat -->
                            <div class="bg-dark-700/50 backdrop-blur-sm rounded-xl p-6 border border-dark-600 shadow-lg">
                                <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                                    <i class="fas fa-id-card text-purple-400 mr-2"></i>
                                    Bio Singkat
                                </h3>
                                <div
                                    class="bg-dark-800/50 rounded-lg p-4 text-gray-300 border border-dark-600 min-h-[100px]">
                                    @if ($user->bio ?? ($user->profile->bio ?? false))
                                        {{ $user->bio ?? ($user->profile->bio ?? '-') }}
                                    @else
                                        <div class="flex flex-col items-center justify-center h-full text-gray-500">
                                            <i class="fas fa-id-card text-2xl mb-2"></i>
                                            <p>Belum ada bio. Tambahkan bio untuk memperkenalkan diri.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Pertanyaan oleh User -->
                            <div class="bg-dark-700/50 backdrop-blur-sm rounded-xl p-6 border border-dark-600 shadow-lg">
                                <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                                    <i class="fas fa-question-circle text-green-400 mr-2"></i>
                                    Pertanyaan oleh {{ $user->name }}
                                </h3>
                                <div class="bg-dark-800/50 rounded-lg p-4 border border-dark-600">
                                    @if (isset($threads) && count($threads))
                                        <ul class="divide-y divide-dark-600">
                                            @foreach ($threads as $thread)
                                                <li
                                                    class="py-3 transition-all duration-300 hover:bg-dark-700/50 rounded-lg px-2">
                                                    <a href="{{ route('questions.show', $thread->id) }}"
                                                        class="text-blue-400 font-medium hover:text-blue-300 flex items-start">
                                                        <i class="fas fa-question text-xs mt-1 mr-2 text-gray-500"></i>
                                                        <span class="flex-1">{{ $thread->title }}</span>
                                                    </a>
                                                    <span
                                                        class="block text-xs text-gray-400 mt-1 ml-4">{{ $thread->created_at->diffForHumans() }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <div class="text-center py-8">
                                            <i class="fas fa-question-circle text-4xl text-gray-600 mb-3"></i>
                                            <p class="text-gray-400 font-medium">Belum ada Pertanyaan.</p>
                                            <p class="text-sm text-gray-500 mt-1">Pertanyaan yang dibuat akan muncul di
                                                sini</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Komentar oleh User -->
                            <div class="bg-dark-700/50 backdrop-blur-sm rounded-xl p-6 border border-dark-600 shadow-lg">
                                <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                                    <i class="fas fa-comments text-yellow-400 mr-2"></i>
                                    Komentar oleh {{ $user->name }}
                                </h3>
                                <div class="bg-dark-800/50 rounded-lg p-4 border border-dark-600">
                                    @if (isset($comments) && count($comments))
                                        <ul class="divide-y divide-dark-600">
                                            @foreach ($comments as $comment)
                                                <li
                                                    class="py-3 transition-all duration-300 hover:bg-dark-700/50 rounded-lg px-2">
                                                    <div class="flex">
                                                        <i class="fas fa-comment text-xs mt-1 mr-2 text-gray-500"></i>
                                                        <span
                                                            class="text-gray-300 flex-1">{{ \Illuminate\Support\Str::limit($comment->content, 80) }}</span>
                                                    </div>
                                                    <div class="flex justify-between items-center mt-1 ml-4">
                                                        <span
                                                            class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                                                        <a href="{{ route('questions.show', $comment->question_id) }}#comment-{{ $comment->id }}"
                                                            class="text-xs text-blue-400 hover:text-blue-300 hover:underline flex items-center">
                                                            Lihat <i class="fas fa-external-link-alt text-xs ml-1"></i>
                                                        </a>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <div class="text-center py-8">
                                            <i class="fas fa-comments text-4xl text-gray-600 mb-3"></i>
                                            <p class="text-gray-400 font-medium">Belum ada komentar.</p>
                                            <p class="text-sm text-gray-500 mt-1">Komentar yang diberikan akan muncul di
                                                sini</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <style>
            @keyframes float {

                0%,
                100% {
                    transform: translateY(0);
                }

                50% {
                    transform: translateY(-10px);
                }
            }

            @media (prefers-color-scheme: light) {
                body {
                    background-color: #111827 !important;
                    color: #e5e7eb !important;
                }

                .bg-white {
                    background-color: #1f2937 !important;
                }

                input,
                textarea,
                select {
                    background-color: #374151 !important;
                    color: #e5e7eb !important;
                    border-color: #4b5563 !important;
                }

                input::placeholder,
                textarea::placeholder {
                    color: #9ca3af !important;
                }
            }

            .animate-float {
                animation: float 3s ease-in-out infinite;
            }

            .glass {
                background: rgba(30, 41, 59, 0.7);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.1);
            }

            ::-webkit-scrollbar {
                width: 6px;
            }

            ::-webkit-scrollbar-track {
                background: #1e293b;
            }

            ::-webkit-scrollbar-thumb {
                background: #475569;
                border-radius: 3px;
            }

            ::-webkit-scrollbar-thumb:hover {
                background: #64748b;
            }
        </style>

        <script>
            // Modal logic
            const badgeModal = document.getElementById('badgeModal');
            const closeBadgeModal = document.getElementById('closeBadgeModal');
            const closeBadgeModalBtn = document.getElementById('closeBadgeModalBtn');

            document.querySelectorAll('.badge-item').forEach(item => {
                item.addEventListener('click', function() {
                    const name = this.getAttribute('data-badge-name') || '';
                    const desc = this.getAttribute('data-badge-desc') || '';
                    const icon = this.getAttribute('data-badge-icon') || '';
                    const date = this.getAttribute('data-badge-date') || '';

                    document.getElementById('badgeModalTitle').textContent = 'Detail Badge';
                    document.getElementById('badgeModalIcon').innerHTML =
                        `<img src='/images/badges/${icon}' alt='' class='w-32 h-32 mx-auto rounded-full object-contain'>`;
                    document.getElementById('badgeModalName').textContent = name;
                    document.getElementById('badgeModalDescription').textContent = desc;
                    document.getElementById('badgeModalDate').textContent = date ? `📅 Dicapai: ${date}` : '';

                    badgeModal.classList.remove('hidden');
                });
            });

            closeBadgeModal.addEventListener('click', function() {
                badgeModal.classList.add('hidden');
            });
            closeBadgeModalBtn.addEventListener('click', function() {
                badgeModal.classList.add('hidden');
            });
            badgeModal.addEventListener('click', function(e) {
                if (e.target === badgeModal) badgeModal.classList.add('hidden');
            });
        </script>

        <script>
            setTimeout(() => {
                if (document.getElementById('badgeModal')) {
                    console.log('badgeModal OK!');
                } else {
                    console.log('badgeModal NOT FOUND!');
                }
                console.log('Jmlh badge found:', document.querySelectorAll('.badge-item').length);
            }, 2000);
        </script>

        <script>
            const badgeModal = document.getElementById('badgeModal');
            const closeBadgeModal = document.getElementById('closeBadgeModal');
            const closeBadgeModalBtn = document.getElementById('closeBadgeModalBtn');

            document.querySelectorAll('.badge-item').forEach(item => {
                item.addEventListener('click', function() {
                    const name = this.getAttribute('data-badge-name') || '';
                    const desc = this.getAttribute('data-badge-desc') || '';
                    const icon = this.getAttribute('data-badge-icon') || '';
                    const date = this.getAttribute('data-badge-date') || '';

                    document.getElementById('badgeModalTitle').textContent = 'Detail Badge';
                    if (icon) {
                        document.getElementById('badgeModalIcon').innerHTML =
                            `<img src='/images/badges/${icon}' alt='' class='w-16 h-16 mx-auto rounded-full'>`;
                    } else {
                        document.getElementById('badgeModalIcon').innerHTML =
                            `<i class='fas fa-trophy text-5xl text-yellow-400'></i>`;
                    }
                    document.getElementById('badgeModalName').textContent = name;
                    document.getElementById('badgeModalDescription').textContent = desc;
                    document.getElementById('badgeModalDate').innerHTML = date ?
                        `<i class="fas fa-calendar-alt mr-1 text-gray-400"></i> Dicapai: ${date}` :
                        `<span class="text-red-400"><i class="fas fa-lock mr-1"></i> Belum dicapai</span>`;

                    badgeModal.classList.remove('hidden');
                });
            });

            closeBadgeModal.addEventListener('click', function() {
                badgeModal.classList.add('hidden');
            });
            closeBadgeModalBtn.addEventListener('click', function() {
                badgeModal.classList.add('hidden');
            });
            badgeModal.addEventListener('click', function(e) {
                if (e.target === badgeModal) badgeModal.classList.add('hidden');
            });
        </script>
    </body>

    </html>

@endsection
