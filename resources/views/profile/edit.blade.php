@extends('layouts.app')

@section('content')
    <div class="bg-gray-900 min-h-screen py-10 px-2">
        <div class="container mx-auto">
            <div class="max-w-4xl mx-auto bg-gray-800 rounded-xl shadow-md overflow-hidden border border-gray-700">
                <div class="md:flex">
                    <!-- Bagian Kiri (Avatar & Info Singkat) -->
                    <div class="md:w-1/3 bg-gray-700 p-6 flex flex-col items-center border-r border-gray-600">
                        <div class="relative mb-6">
                            @if ($user->photo)
                                <img src="{{ asset('storage/photo/' . $user->photo) }}" alt="Foto Profil"
                                    class="w-32 h-32 rounded-full object-cover border-4 border-gray-800 shadow-lg">
                            @else
                                <div
                                    class="w-32 h-32 flex items-center justify-center rounded-full bg-blue-500/20 text-blue-300 text-4xl font-bold border-4 border-gray-800 shadow-lg">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                            @endif
                        </div>
                        <div class="text-center mb-6 w-full">
                            <h2 class="text-xl font-semibold text-white">{{ $user->name }}</h2>
                            <p class="text-gray-400 text-sm">Member since: {{ $user->created_at->translatedFormat('M Y') }}
                            </p>
                            @if ($user->role === 'mahasiswa')
                                <p class="text-xs text-gray-500 mt-1">NIM: {{ $user->nim ?? ($user->username ?? '-') }}</p>
                                <p class="text-xs text-gray-500">Prodi: {{ $user->prodi ?? ($user->profile->prodi ?? '-') }}
                                </p>
                            @elseif($user->role === 'dosen')
                                <p class="text-xs text-gray-500 mt-1">NIDN: {{ $user->nidm ?? ($user->username ?? '-') }}</p>
                                <p class="text-xs text-gray-500">Mata Kuliah:
                                    {{ $user->prodi ?? ($user->profile->prodi ?? '-') }}</p>
                            @endif
                        </div>
                        <div class="w-full bg-gray-600 rounded-lg p-4 mb-6 shadow-sm border border-gray-500">
                            <div class="grid grid-cols-3 gap-2 text-center">
                                <div>
                                    <p class="text-lg font-bold text-white">
                                        {{ $threadCount ?? ($user->questions_count ?? 0) }}</p>
                                    <p class="text-xs text-gray-400">Pertanyaan</p>
                                </div>
                                <div>
                                    <p class="text-lg font-bold text-white">
                                        {{ $commentCount ?? ($user->comments_count ?? 0) }}</p>
                                    <p class="text-xs text-gray-400">Komentar</p>
                                </div>
                                <div>
                                    <p class="text-lg font-bold text-white">{{ $likeCount ?? 0 }}</p>
                                    <p class="text-xs text-gray-400">Like</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bagian Kanan (Form Edit) -->
                    <div class="md:w-2/3 p-8">
                        @if ($errors->any())
                            <div class="mb-4 p-3 bg-red-500/20 border border-red-500/30 rounded text-sm text-red-300">
                                <ul class="list-disc pl-5">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('profile.update', $user->id) }}" method="POST"
                            enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="username" value="{{ $user->username }}">

                            <!-- FOTO PROFIL -->
                            <div>
                                <label for="photo" class="block text-sm font-medium text-gray-300 mb-1">Foto
                                    Profil</label>
                                <input type="file" name="photo" id="photo"
                                    class="w-full px-3 py-2 border border-gray-600 rounded-md bg-gray-700 text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-500/20 file:text-blue-300 hover:file:bg-blue-500/30">
                                @if ($user->photo)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/photo/' . $user->photo) }}" alt="Foto Profil"
                                            class="w-20 h-20 rounded-full border border-gray-600">
                                    </div>
                                @endif
                            </div>

                            <!-- Informasi Dasar -->
                            <div>
                                <h3 class="text-lg font-semibold text-white border-b border-gray-600 pb-2 mb-4">Informasi
                                    Dasar</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-300 mb-1">Nama Lengkap</label>
                                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                            class="w-full px-3 py-2 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-700 text-white placeholder-gray-400">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-300 mb-1">Email</label>
                                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                            class="w-full px-3 py-2 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-700 text-white placeholder-gray-400">
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-300 mb-1">Jenis Kelamin</label>
                                            <select name="gender" class="w-full px-3 py-2 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-700 text-white">
                                                <option value="">Pilih Jenis Kelamin</option>
                                                <option value="Laki-laki" {{ old('gender', $user->gender) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                                <option value="Perempuan" {{ old('gender', $user->gender) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                            </select>
                                        </div>
                                    </div>

                                    @if ($user->role === 'mahasiswa')
                                        <div>
                                            <label class="block text-sm font-medium text-gray-300 mb-1">Program
                                                Studi</label>
                                            <input type="text" name="prodi"
                                                value="{{ old('prodi', $user->prodi ?? ($user->profile->prodi ?? '')) }}"
                                                class="w-full px-3 py-2 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-700 text-white placeholder-gray-400">
                                        </div>
                                    @elseif($user->role === 'dosen')
                                        <div>
                                            <label class="block text-sm font-medium text-gray-300 mb-1">Mata Kuliah
                                                Diampu</label>
                                            <input type="text" name="prodi"
                                                value="{{ old('prodi', $user->prodi ?? ($user->profile->prodi ?? '')) }}"
                                                class="w-full px-3 py-2 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-700 text-white placeholder-gray-400"
                                                placeholder="Contoh: Pemrograman Web">
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Bio -->
                            <div>
                                <h3 class="text-lg font-semibold text-white border-b border-gray-600 pb-2 mb-4">Bio</h3>
                                <textarea rows="4" name="bio"
                                    class="w-full px-3 py-2 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-700 text-white placeholder-gray-400"
                                    maxlength="500" placeholder="Ceritakan sedikit tentang diri Anda...">{{ old('bio', $user->profile->bio ?? '') }}</textarea>
                                <p class="text-xs text-gray-500 mt-1">Maksimal 500 karakter</p>
                            </div>

                            <!-- Angkatan (mahasiswa) -->
                            @if ($user->role === 'mahasiswa')
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-1">Angkatan / Tahun
                                        Masuk</label>
                                    <input type="text" name="angkatan"
                                        value="{{ old('angkatan', $user->profile->angkatan ?? '') }}"
                                        class="w-full px-3 py-2 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-700 text-white placeholder-gray-400"
                                        placeholder="Contoh: 2022">
                                </div>
                            @endif

                            <!-- Social links fields (3 rows) -->
                            <div>
                                <h3 class="text-lg font-semibold text-white border-b border-gray-600 pb-2 mb-4">Media Sosial
                                    & Links</h3>

                                @php
                                    $existing = ($user->socialLinks ?? collect())->values();
                                    for ($i = 0; $i < 3; $i++) {
                                        $rows[$i] = $existing->get($i)
                                            ? $existing->get($i)->toArray()
                                            : ['url' => '', 'label' => '', 'order' => $i, 'visible' => true];
                                    }
                                @endphp

                                @for ($i = 0; $i < 3; $i++)
                                    @php $row = old("links.$i", $rows[$i]); @endphp
                                    <div class="flex gap-2 items-center mb-2">
                                        <input type="text" name="links[{{ $i }}][url]"
                                            value="{{ $row['url'] ?? '' }}"
                                            class="border border-gray-600 rounded px-2 py-1 flex-1 bg-gray-700 text-white placeholder-gray-400"
                                            placeholder="URL atau username (mis. github.com/username atau @username)" />
                                        <input type="text" name="links[{{ $i }}][label]"
                                            value="{{ $row['label'] ?? '' }}"
                                            class="border border-gray-600 rounded px-2 py-1 w-48 bg-gray-700 text-white placeholder-gray-400"
                                            placeholder="Label (opsional)" />
                                        <button type="button"
                                            onclick="this.closest('div').querySelector('input[name*=\'url\']').value=''; this.closest('div').querySelector('input[name*=\'label\']').value='';"
                                            class="text-sm text-red-400 hover:text-red-300">Clear</button>
                                    </div>
                                @endfor
                            </div>

                            <!-- Keamanan Akun -->
                            <div>
                                <h3 class="text-lg font-semibold text-white border-b border-gray-600 pb-2 mb-4">Keamanan
                                    Akun</h3>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-300 mb-1">Password Saat
                                            Ini</label>
                                        <input type="password" name="current_password"
                                            placeholder="Masukkan password saat ini"
                                            class="w-full px-3 py-2 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-700 text-white placeholder-gray-400">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-300 mb-1">Password Baru</label>
                                        <input type="password" name="password" placeholder="Masukkan password baru"
                                            class="w-full px-3 py-2 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-700 text-white placeholder-gray-400">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-300 mb-1">Konfirmasi Password
                                            Baru</label>
                                        <input type="password" name="password_confirmation"
                                            placeholder="Konfirmasi password baru"
                                            class="w-full px-3 py-2 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-700 text-white placeholder-gray-400">
                                    </div>
                                </div>
                            </div>

                            <!-- Tombol Aksi -->
                            <div class="flex justify-end space-x-4 pt-4">
                                <a href="{{ route('users.show', $user->id) }}"
                                    class="px-6 py-2 border border-gray-600 rounded-md text-gray-300 hover:bg-gray-700 transition">Batal</a>
                                <button type="submit"
                                    class="px-6 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded-md transition transform hover:scale-105">Simpan
                                    Perubahan</button>
                            </div>
                        </form>
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

        .bg-gray-600 {
            background-color: #4b5563 !important;
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

        .border-gray-500 {
            border-color: #6b7280 !important;
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

        /* File input styling */
        .file\:bg-blue-50 {
            background-color: rgba(59, 130, 246, 0.2) !important;
        }

        .file\:text-blue-700 {
            color: #93c5fd !important;
        }

        .hover\:file\:bg-blue-100:hover {
            background-color: rgba(59, 130, 246, 0.3) !important;
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

            /* Memastikan input tetap gelap */
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

        /* Focus states */
        .focus\:ring-blue-500:focus {
            --tw-ring-color: rgb(59 130 246 / 0.5) !important;
        }
    </style>
@endsection
