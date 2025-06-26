@extends('layouts.app')

@section('content')
<div class="bg-gray-100 min-h-screen py-10 px-2">
    <div class="container mx-auto">
        <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-md overflow-hidden">
            <div class="md:flex">
                <!-- Bagian Kiri (Avatar & Info Singkat) -->
                <div class="md:w-1/3 bg-blue-50 p-6 flex flex-col items-center">
                    <div class="relative mb-6">
                        @if($user->photo)
                            <img src="{{ asset('storage/photo/' . $user->photo) }}"
                                alt="Foto Profil"
                                class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-lg">
                        @else
                            <div class="w-32 h-32 flex items-center justify-center rounded-full bg-blue-200 text-blue-800 text-4xl font-bold border-4 border-white shadow-lg">
                                {{ strtoupper(substr($user->name, 0, 2)) }}
                            </div>
                        @endif
                    </div>
                    <div class="text-center mb-6 w-full">
                        <h2 class="text-xl font-semibold text-gray-800">{{ $user->name }}</h2>
                        <p class="text-gray-600 text-sm">Member since: {{ $user->created_at->translatedFormat('M Y') }}</p>
                        @if($user->role === 'mahasiswa')
                            <p class="text-xs text-gray-500 mt-1">
                                NIM: {{ $user->nim ?? $user->username ?? '-' }}
                            </p>
                        @elseif($user->role === 'dosen')
                            <p class="text-xs text-gray-500 mt-1">
                                NIDN: {{ $user->nidm ?? $user->username ?? '-' }}
                            </p>
                        @endif
                        @if($user->role === 'mahasiswa')
                            <p class="text-xs text-gray-500">
                                Prodi: {{ $user->prodi ?? ($user->profile->prodi ?? '-') }}
                            </p>
                        @elseif($user->role === 'dosen')
                            <p class="text-xs text-gray-500">
                                Mata Kuliah Diampu: {{ $user->prodi ?? ($user->profile->prodi ?? '-') }}
                            </p>
                        @endif
                    </div>
                    <div class="w-full bg-white rounded-lg p-4 mb-6 shadow-sm border border-gray-200">
                        <div class="grid grid-cols-3 gap-2 text-center">
                            <div>
                                <p class="text-lg font-bold">{{ $threadCount ?? $user->questions_count ?? 0 }}</p>
                                <p class="text-xs text-gray-500">Threads</p>
                            </div>
                            <div>
                                <p class="text-lg font-bold">{{ $commentCount ?? $user->comments_count ?? 0 }}</p>
                                <p class="text-xs text-gray-500">Comments</p>
                            </div>
                            <div>
                                <p class="text-lg font-bold">{{ $likeCount ?? 0 }}</p>
                                <p class="text-xs text-gray-500">Likes</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Bagian Kanan (Form Edit) -->
                <div class="md:w-2/3 p-8">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('profile.update', $user->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="username" value="{{ $user->username }}">
                        <!-- FOTO PROFIL -->
                        <div>
                            <label for="photo" class="block text-sm font-medium text-gray-700 mb-1">Foto Profil</label>
                            <input type="file" name="photo" id="photo" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            @if($user->photo)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/photo/' . $user->photo) }}" alt="Foto Profil" class="w-20 h-20 rounded-full">
                                </div>
                            @endif
                        </div>
                        <!-- Informasi Dasar -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">Informasi Dasar</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                @if($user->role === 'mahasiswa')
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Program Studi</label>
                                        <input type="text" name="prodi" value="{{ old('prodi', $user->prodi ?? ($user->profile->prodi ?? '')) }}"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                @elseif($user->role === 'dosen')
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Mata Kuliah Diampu</label>
                                        <input type="text" name="prodi" value="{{ old('prodi', $user->prodi ?? ($user->profile->prodi ?? '')) }}"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Contoh: Pemrograman Web, Basis Data">
                                    </div>
                                @endif
                            </div>
                        </div>
                        <!-- Bio -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">Bio</h3>
                            <textarea rows="4" name="bio"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                    maxlength="200" placeholder="Ceritakan sedikit tentang diri Anda...">{{ old('bio', $user->profile->bio ?? '') }}</textarea>
                            <p class="text-xs text-gray-500 mt-1">Maksimal 200 karakter</p>
                        </div>
                        <!-- Keamanan Akun -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">Keamanan Akun</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Password Saat Ini</label>
                                    <input type="password" name="current_password" placeholder="Masukkan password saat ini" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                                    <input type="password" name="password" placeholder="Masukkan password baru" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                                    <input type="password" name="password_confirmation" placeholder="Konfirmasi password baru" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                            </div>
                        </div>
                        <!-- Tombol Aksi -->
                        <div class="flex justify-end space-x-4 pt-4">
                            <a href="{{ route('users.show', $user->id) }}" class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition">
                                Batal
                            </a>
                            <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection