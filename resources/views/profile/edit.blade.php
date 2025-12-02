@extends('layouts.app')

@section('content')
    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Profil</title>
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
                            'pulse-slow': 'pulse 3s infinite',
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
                        Edit Profil</h1>
                    <p class="text-gray-400 mt-2">Perbarui informasi akun forum kampus Anda</p>
                </div>

                <!-- Container utama -->
                <div class="bg-dark-800 rounded-2xl shadow-2xl overflow-hidden border border-dark-600 animate-slide-up">
                    <div class="md:flex">
                        <!-- Sidebar Profil -->
                        <div
                            class="md:w-1/3 bg-gradient-to-b from-dark-700 to-dark-800 p-8 flex flex-col items-center border-r border-dark-600">
                            <!-- Avatar dengan preview -->
                            <div class="relative mb-6 group">
                                <div id="avatarPreview" class="relative">
                                    @if ($user->photo)
                                        <img src="{{ asset('storage/photo/' . $user->photo) }}" alt="Foto Profil"
                                            class="w-32 h-32 rounded-full object-cover border-4 border-dark-600 shadow-xl group-hover:border-blue-500 transition-all duration-300">
                                    @else
                                        <div
                                            class="w-32 h-32 flex items-center justify-center rounded-full bg-gradient-to-br from-blue-500/30 to-purple-500/30 text-blue-300 text-4xl font-bold border-4 border-dark-600 shadow-xl group-hover:border-blue-500 transition-all duration-300">
                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                        </div>
                                    @endif
                                </div>
                                <div
                                    class="absolute -bottom-2 -right-2 bg-blue-500 rounded-full p-2 border-2 border-dark-800 shadow-lg">
                                    <i class="fas fa-camera text-white text-sm"></i>
                                </div>
                            </div>

                            <!-- Info Pengguna -->
                            <div class="text-center mb-6 w-full">
                                <h2 class="text-xl font-bold text-white">{{ $user->name }}</h2>
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
                                <p class="text-gray-400 text-sm mt-2">Anggota sejak:
                                    {{ $user->created_at->translatedFormat('M Y') }}</p>

                                @if ($user->role === 'mahasiswa')
                                    <div class="mt-3 space-y-1">
                                        <p class="text-xs text-gray-500"><i class="fas fa-id-card mr-1"></i> NIM:
                                            {{ $user->nim ?? ($user->username ?? '-') }}</p>
                                        <p class="text-xs text-gray-500"><i class="fas fa-graduation-cap mr-1"></i> Prodi:
                                            {{ $user->prodi ?? ($user->profile->prodi ?? '-') }}</p>
                                    </div>
                                @elseif($user->role === 'dosen')
                                    <div class="mt-3 space-y-1">
                                        <p class="text-xs text-gray-500"><i class="fas fa-id-card mr-1"></i> NIDN:
                                            {{ $user->nidm ?? ($user->username ?? '-') }}</p>
                                        <p class="text-xs text-gray-500"><i class="fas fa-book mr-1"></i> Mata Kuliah:
                                            {{ $user->prodi ?? ($user->profile->prodi ?? '-') }}</p>
                                    </div>
                                @endif
                            </div>

                            <!-- Statistik -->
                            <div
                                class="w-full bg-dark-700/50 backdrop-blur-sm rounded-xl p-4 mb-6 border border-dark-600 shadow-lg">
                                <h3 class="text-sm font-semibold text-gray-300 mb-3 text-center">📊 Statistik Anda</h3>
                                <div class="grid grid-cols-3 gap-4 text-center">
                                    <div>
                                        <div
                                            class="bg-blue-500/20 rounded-full w-10 h-10 flex items-center justify-center mx-auto mb-2">
                                            <i class="fas fa-question text-blue-400"></i>
                                        </div>
                                        <p class="text-lg font-bold text-white">
                                            {{ $threadCount ?? ($user->questions_count ?? 0) }}</p>
                                        <p class="text-xs text-gray-400">Pertanyaan</p>
                                    </div>
                                    <div>
                                        <div
                                            class="bg-green-500/20 rounded-full w-10 h-10 flex items-center justify-center mx-auto mb-2">
                                            <i class="fas fa-comment text-green-400"></i>
                                        </div>
                                        <p class="text-lg font-bold text-white">
                                            {{ $commentCount ?? ($user->comments_count ?? 0) }}</p>
                                        <p class="text-xs text-gray-400">Komentar</p>
                                    </div>
                                    <div>
                                        <div
                                            class="bg-red-500/20 rounded-full w-10 h-10 flex items-center justify-center mx-auto mb-2">
                                            <i class="fas fa-heart text-red-400"></i>
                                        </div>
                                        <p class="text-lg font-bold text-white">{{ $likeCount ?? 0 }}</p>
                                        <p class="text-xs text-gray-400">Like</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Tips -->
                            <div class="w-full bg-blue-500/10 border border-blue-500/20 rounded-xl p-4">
                                <h4 class="text-sm font-semibold text-blue-300 mb-2 flex items-center">
                                    <i class="fas fa-lightbulb mr-2"></i> Tips Profil
                                </h4>
                                <ul class="text-xs text-blue-200/80 space-y-1">
                                    <li>• Gunakan foto profil asli</li>
                                    <li>• Isi bio yang menarik</li>
                                    <li>• Tambahkan media sosial</li>
                                    <li>• Perbarui informasi secara berkala</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Form Edit -->
                        <div class="md:w-2/3 p-8">
                            @if ($errors->any())
                                <div
                                    class="mb-6 p-4 bg-red-500/20 border border-red-500/30 rounded-xl text-sm text-red-300 animate-pulse-slow">
                                    <div class="flex items-center mb-2">
                                        <i class="fas fa-exclamation-triangle mr-2"></i>
                                        <strong class="font-semibold">Perhatian!</strong>
                                    </div>
                                    <ul class="list-disc pl-5 space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if (session('success'))
                                <div
                                    class="mb-6 p-4 bg-green-500/20 border border-green-500/30 rounded-xl text-sm text-green-300">
                                    <div class="flex items-center">
                                        <i class="fas fa-check-circle mr-2"></i>
                                        <strong class="font-semibold">Sukses!</strong>
                                    </div>
                                    <p class="mt-1">{{ session('success') }}</p>
                                </div>
                            @endif

                            <form action="{{ route('profile.update', $user->id) }}" method="POST"
                                enctype="multipart/form-data" class="space-y-8">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="username" value="{{ $user->username }}">

                                <!-- Foto Profil -->
                                <div
                                    class="bg-dark-700/50 backdrop-blur-sm rounded-xl p-6 border border-dark-600 shadow-lg">
                                    <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                                        <i class="fas fa-camera text-blue-400 mr-2"></i>
                                        Foto Profil
                                    </h3>
                                    <div class="flex flex-col md:flex-row gap-6 items-start">
                                        <div class="flex-shrink-0">
                                            <div class="relative">
                                                <label for="photo" class="cursor-pointer group">
                                                    <div id="photoPreview"
                                                        class="w-24 h-24 rounded-full border-2 border-dashed border-dark-500 group-hover:border-blue-400 transition-colors duration-300 flex items-center justify-center bg-dark-600/50 overflow-hidden">
                                                        @if ($user->photo)
                                                            <img src="{{ asset('storage/photo/' . $user->photo) }}"
                                                                alt="Preview" class="w-full h-full object-cover">
                                                        @else
                                                            <i
                                                                class="fas fa-user-plus text-gray-400 text-2xl group-hover:text-blue-400 transition-colors"></i>
                                                        @endif
                                                    </div>
                                                    <input type="file" name="photo" id="photo" accept="image/*"
                                                        class="hidden">
                                                </label>
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm text-gray-400 mb-3">Unggah foto profil baru. Format yang
                                                didukung: JPG, PNG, GIF. Maksimal 2MB.</p>
                                            <div class="flex gap-2">
                                                <label for="photo"
                                                    class="cursor-pointer bg-blue-500/20 text-blue-300 hover:bg-blue-500/30 px-4 py-2 rounded-lg text-sm font-medium transition-colors border border-blue-500/30">
                                                    <i class="fas fa-upload mr-2"></i>Pilih Foto
                                                </label>
                                                @if ($user->photo)
                                                    <button type="button" onclick="removePhoto()"
                                                        class="bg-red-500/20 text-red-300 hover:bg-red-500/30 px-4 py-2 rounded-lg text-sm font-medium transition-colors border border-red-500/30">
                                                        <i class="fas fa-trash mr-2"></i>Hapus
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Informasi Dasar -->
                                <div
                                    class="bg-dark-700/50 backdrop-blur-sm rounded-xl p-6 border border-dark-600 shadow-lg">
                                    <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                                        <i class="fas fa-user-edit text-purple-400 mr-2"></i>
                                        Informasi Dasar
                                    </h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-300 mb-2 flex items-center">
                                                <i class="fas fa-user mr-2 text-blue-400"></i>Nama Lengkap
                                            </label>
                                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                                class="w-full px-4 py-3 border border-dark-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-dark-600 text-white placeholder-gray-400 transition-all duration-300 focus:border-blue-400">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-300 mb-2 flex items-center">
                                                <i class="fas fa-envelope mr-2 text-blue-400"></i>Email
                                            </label>
                                            <input type="email" name="email"
                                                value="{{ old('email', $user->email) }}"
                                                class="w-full px-4 py-3 border border-dark-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-dark-600 text-white placeholder-gray-400 transition-all duration-300 focus:border-blue-400">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-300 mb-2 flex items-center">
                                                <i class="fas fa-venus-mars mr-2 text-blue-400"></i>Jenis Kelamin
                                            </label>
                                            <select name="gender"
                                                class="w-full px-4 py-3 border border-dark-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-dark-600 text-white transition-all duration-300 focus:border-blue-400">
                                                <option value="">Pilih Jenis Kelamin</option>
                                                <option value="Laki-laki"
                                                    {{ old('gender', $user->gender) == 'Laki-laki' ? 'selected' : '' }}>
                                                    Laki-laki</option>
                                                <option value="Perempuan"
                                                    {{ old('gender', $user->gender) == 'Perempuan' ? 'selected' : '' }}>
                                                    Perempuan</option>
                                            </select>
                                        </div>

                                        @if ($user->role === 'mahasiswa')
                                            <div>
                                                <label
                                                    class="block text-sm font-medium text-gray-300 mb-2 flex items-center">
                                                    <i class="fas fa-graduation-cap mr-2 text-blue-400"></i>Program Studi
                                                </label>
                                                <input type="text" name="prodi"
                                                    value="{{ old('prodi', $user->prodi ?? ($user->profile->prodi ?? '')) }}"
                                                    class="w-full px-4 py-3 border border-dark-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-dark-600 text-white placeholder-gray-400 transition-all duration-300 focus:border-blue-400"
                                                    placeholder="Contoh: Teknik Informatika">
                                            </div>
                                        @elseif($user->role === 'dosen')
                                            <div>
                                                <label
                                                    class="block text-sm font-medium text-gray-300 mb-2 flex items-center">
                                                    <i class="fas fa-book mr-2 text-blue-400"></i>Mata Kuliah Diampu
                                                </label>
                                                <input type="text" name="prodi"
                                                    value="{{ old('prodi', $user->prodi ?? ($user->profile->prodi ?? '')) }}"
                                                    class="w-full px-4 py-3 border border-dark-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-dark-600 text-white placeholder-gray-400 transition-all duration-300 focus:border-blue-400"
                                                    placeholder="Contoh: Pemrograman Web">
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Bio -->
                                <div
                                    class="bg-dark-700/50 backdrop-blur-sm rounded-xl p-6 border border-dark-600 shadow-lg">
                                    <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                                        <i class="fas fa-id-card text-yellow-400 mr-2"></i>
                                        Bio Singkat
                                    </h3>
                                    <div class="relative">
                                        <textarea rows="4" name="bio"
                                            class="w-full px-4 py-3 border border-dark-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-dark-600 text-white placeholder-gray-400 transition-all duration-300 focus:border-blue-400 resize-none"
                                            maxlength="500" placeholder="Ceritakan sedikit tentang diri Anda...">{{ old('bio', $user->profile->bio ?? '') }}</textarea>
                                        <div
                                            class="absolute bottom-3 right-3 text-xs text-gray-500 bg-dark-700 px-2 py-1 rounded">
                                            <span id="charCount">0</span>/500 karakter
                                        </div>
                                    </div>
                                </div>

                                <!-- Angkatan (mahasiswa) -->
                                @if ($user->role === 'mahasiswa')
                                    <div
                                        class="bg-dark-700/50 backdrop-blur-sm rounded-xl p-6 border border-dark-600 shadow-lg">
                                        <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                                            <i class="fas fa-calendar-alt text-green-400 mr-2"></i>
                                            Informasi Akademik
                                        </h3>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-300 mb-2">Angkatan /
                                                    Tahun Masuk</label>
                                                <input type="text" name="angkatan"
                                                    value="{{ old('angkatan', $user->profile->angkatan ?? '') }}"
                                                    class="w-full px-4 py-3 border border-dark-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-dark-600 text-white placeholder-gray-400 transition-all duration-300 focus:border-blue-400"
                                                    placeholder="Contoh: 2022">
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Media Sosial -->
                                <div
                                    class="bg-dark-700/50 backdrop-blur-sm rounded-xl p-6 border border-dark-600 shadow-lg">
                                    <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                                        <i class="fas fa-share-alt text-pink-400 mr-2"></i>
                                        Media Sosial & Links
                                    </h3>
                                    <p class="text-sm text-gray-400 mb-4">Tambahkan tautan media sosial atau website Anda
                                        (maksimal 3)</p>

                                    @php
                                        $existing = ($user->socialLinks ?? collect())->values();
                                        for ($i = 0; $i < 3; $i++) {
                                            $rows[$i] = $existing->get($i)
                                                ? $existing->get($i)->toArray()
                                                : ['url' => '', 'label' => '', 'order' => $i, 'visible' => true];
                                        }
                                    @endphp

                                    <div class="space-y-4">
                                        @for ($i = 0; $i < 3; $i++)
                                            @php $row = old("links.$i", $rows[$i]); @endphp
                                            <div
                                                class="flex flex-col md:flex-row gap-3 items-start md:items-center p-4 bg-dark-600/30 rounded-lg border border-dark-500/50 hover:border-dark-400 transition-colors">
                                                <div class="flex-1 w-full">
                                                    <label class="block text-xs text-gray-400 mb-1">URL</label>
                                                    <input type="text" name="links[{{ $i }}][url]"
                                                        value="{{ $row['url'] ?? '' }}"
                                                        class="w-full px-3 py-2 border border-dark-500 rounded bg-dark-700 text-white placeholder-gray-400 text-sm"
                                                        placeholder="https://... atau @username" />
                                                </div>
                                                <div class="w-full md:w-48">
                                                    <label class="block text-xs text-gray-400 mb-1">Label
                                                        (opsional)</label>
                                                    <input type="text" name="links[{{ $i }}][label]"
                                                        value="{{ $row['label'] ?? '' }}"
                                                        class="w-full px-3 py-2 border border-dark-500 rounded bg-dark-700 text-white placeholder-gray-400 text-sm"
                                                        placeholder="Nama platform" />
                                                </div>
                                                <button type="button" onclick="clearLink({{ $i }})"
                                                    class="mt-2 md:mt-6 text-sm text-red-400 hover:text-red-300 bg-red-500/10 hover:bg-red-500/20 px-3 py-2 rounded transition-colors">
                                                    <i class="fas fa-times mr-1"></i>Hapus
                                                </button>
                                            </div>
                                        @endfor
                                    </div>
                                </div>

                                <!-- Keamanan Akun -->
                                <div
                                    class="bg-dark-700/50 backdrop-blur-sm rounded-xl p-6 border border-dark-600 shadow-lg">
                                    <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                                        <i class="fas fa-shield-alt text-orange-400 mr-2"></i>
                                        Keamanan Akun
                                    </h3>
                                    <p class="text-sm text-gray-400 mb-4">Kosongkan jika tidak ingin mengubah password</p>
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-300 mb-2 flex items-center">
                                                <i class="fas fa-lock mr-2 text-gray-400"></i>Password Saat Ini
                                            </label>
                                            <input type="password" name="current_password"
                                                placeholder="Masukkan password saat ini"
                                                class="w-full px-4 py-3 border border-dark-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-dark-600 text-white placeholder-gray-400 transition-all duration-300 focus:border-blue-400">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-300 mb-2 flex items-center">
                                                <i class="fas fa-key mr-2 text-gray-400"></i>Password Baru
                                            </label>
                                            <input type="password" name="password" placeholder="Masukkan password baru"
                                                class="w-full px-4 py-3 border border-dark-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-dark-600 text-white placeholder-gray-400 transition-all duration-300 focus:border-blue-400">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-300 mb-2 flex items-center">
                                                <i class="fas fa-key mr-2 text-gray-400"></i>Konfirmasi Password Baru
                                            </label>
                                            <input type="password" name="password_confirmation"
                                                placeholder="Konfirmasi password baru"
                                                class="w-full px-4 py-3 border border-dark-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-dark-600 text-white placeholder-gray-400 transition-all duration-300 focus:border-blue-400">
                                        </div>
                                    </div>
                                </div>

                                <!-- Tombol Aksi -->
                                <div
                                    class="flex flex-col md:flex-row justify-between items-center gap-4 pt-6 border-t border-dark-600">
                                    <a href="{{ route('users.show', $user->id) }}"
                                        class="flex items-center justify-center w-full md:w-auto px-6 py-3 border border-dark-500 rounded-lg text-gray-300 hover:bg-dark-700 transition-all duration-300 hover:border-dark-400 group">
                                        <i
                                            class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i>
                                        Kembali ke Profil
                                    </a>
                                    <div class="flex gap-3 w-full md:w-auto">
                                        <button type="reset"
                                            class="flex items-center justify-center w-full md:w-auto px-6 py-3 border border-dark-500 rounded-lg text-gray-300 hover:bg-dark-700 transition-all duration-300 hover:border-dark-400 group">
                                            <i class="fas fa-undo mr-2 group-hover:rotate-180 transition-transform"></i>
                                            Reset
                                        </button>
                                        <button type="submit"
                                            class="flex items-center justify-center w-full md:w-auto px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-blue-500/20 border border-blue-400/30 group">
                                            <i class="fas fa-save mr-2 group-hover:scale-110 transition-transform"></i>
                                            Simpan Perubahan
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.getElementById('photo').addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const preview = document.getElementById('photoPreview');
                        preview.innerHTML =
                            `<img src="${e.target.result}" alt="Preview" class="w-full h-full object-cover">`;

                        // Update avatar preview juga
                        const avatarPreview = document.getElementById('avatarPreview');
                        avatarPreview.innerHTML =
                            `<img src="${e.target.result}" alt="Foto Profil" class="w-32 h-32 rounded-full object-cover border-4 border-dark-600 shadow-xl">`;
                    }
                    reader.readAsDataURL(file);
                }
            });

            const bioTextarea = document.querySelector('textarea[name="bio"]');
            const charCount = document.getElementById('charCount');

            function updateCharCount() {
                charCount.textContent = bioTextarea.value.length;
            }

            bioTextarea.addEventListener('input', updateCharCount);
            updateCharCount();

            function clearLink(index) {
                document.querySelector(`input[name="links[${index}][url]"]`).value = '';
                document.querySelector(`input[name="links[${index}][label]"]`).value = '';
            }

            function removePhoto() {
                document.getElementById('photo').value = '';
                document.getElementById('photoPreview').innerHTML =
                    '<i class="fas fa-user-plus text-gray-400 text-2xl group-hover:text-blue-400 transition-colors"></i>';

                const avatarPreview = document.getElementById('avatarPreview');
                avatarPreview.innerHTML = `
                <div class="w-32 h-32 flex items-center justify-center rounded-full bg-gradient-to-br from-blue-500/30 to-purple-500/30 text-blue-300 text-4xl font-bold border-4 border-dark-600 shadow-xl">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                </div>
            `;
            }

            document.querySelector('form').addEventListener('submit', function() {
                const submitBtn = this.querySelector('button[type="submit"]');
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...';
                submitBtn.disabled = true;
            });
        </script>

        <style>
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

            input,
            textarea,
            select,
            button {
                transition: all 0.3s ease;
            }

            input:focus,
            textarea:focus,
            select:focus {
                box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            }

            input[type="file"] {
                cursor: pointer;
            }

            /* Glassmorphism effect */
            .glass {
                background: rgba(30, 41, 59, 0.7);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.1);
            }
        </style>
    </body>

    </html>
@endsection
