@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-12 bg-white p-8 rounded-xl shadow">
    <h2 class="text-2xl font-bold mb-6">Lengkapi Profil Anda</h2>

    @if(session('success'))
        <div class="mb-4 text-green-700">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('profile.complete.submit', $user->id) }}">
        @csrf

        @if($user->role === 'mahasiswa')
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Angkatan / Tahun Masuk</label>
                <input type="text" name="angkatan" class="mt-1 block w-full border-gray-200 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    value="{{ old('angkatan', $user->profile->angkatan ?? '') }}" placeholder="Contoh: 2022">
                @error('angkatan') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
        @endif

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Bio Singkat (opsional)</label>
            <textarea name="bio" rows="4" class="mt-1 block w-full border-gray-200 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                placeholder="Ceritakan sedikit tentang dirimu...">{{ old('bio', $user->profile->bio ?? '') }}</textarea>
            @error('bio') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <hr class="my-6">

        <div class="mb-3">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Media Sosial & Links (opsional — maksimal 3)</h3>
            <p class="text-sm text-gray-500 mb-4">Pilih tipe dan masukkan URL atau username. Sistem akan menambahkan https:// jika tidak ada.</p>

            @php
                $types = [
                    'instagram' => 'Instagram',
                    'github' => 'GitHub',
                    'facebook' => 'Facebook',
                    'linkedin' => 'LinkedIn',
                    'website' => 'Website',
                    'twitter' => 'Twitter',
                    'stackoverflow' => 'StackOverflow',
                    'devto' => 'Dev.to',
                    'codepen' => 'CodePen',
                    'dribbble' => 'Dribbble',
                    'behance' => 'Behance',
                    'medium' => 'Medium',
                    'kaggle' => 'Kaggle',
                    'gitlab' => 'GitLab',
                    'bitbucket' => 'Bitbucket',
                    'youtube' => 'YouTube',
                    'tiktok' => 'TikTok',
                    'threads' => 'Threads',
                    'pinterest' => 'Pinterest',
                    'snapchat' => 'Snapchat',
                    'reddit' => 'Reddit',
                    'telegram' => 'Telegram',
                    'whatsapp' => 'WhatsApp',
                    'discord' => 'Discord',
                    'twitch' => 'Twitch',
                    'other' => 'Other',
                ];

                $existing = ($user->socialLinks ?? collect())->values();
                for ($i = 0; $i < 3; $i++) {
                    $rows[$i] = $existing->get($i) ? $existing->get($i)->toArray() : ['type' => '', 'url' => '', 'label' => '', 'order' => $i, 'visible' => true];
                }
            @endphp

            @for ($i = 0; $i < 3; $i++)
                @php $row = old("links.$i", $rows[$i]); @endphp

                <div class="grid grid-cols-12 gap-2 items-center mb-3">
                    <div class="col-span-3">
                        <select name="links[{{ $i }}][type]" class="block w-full border-gray-200 rounded-md">
                            <option value="">-- Tipe --</option>
                            @foreach($types as $key => $label)
                                <option value="{{ $key }}" @if(($row['type'] ?? '') === $key) selected @endif>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-span-6">
                        <input type="text" name="links[{{ $i }}][url]" value="{{ $row['url'] ?? '' }}"
                            class="block w-full border-gray-200 rounded-md"
                            placeholder="Contoh: github.com/username atau https://github.com/username">
                    </div>

                    <div class="col-span-3">
                        <input type="text" name="links[{{ $i }}][label]" value="{{ $row['label'] ?? '' }}"
                            class="block w-full border-gray-200 rounded-md"
                            placeholder="Label (opsional)">
                    </div>
                </div>
            @endfor

            @error('links') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center justify-between mt-6">
            <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:underline">Lewati dulu / Kembali ke Login</a>
            <button type="submit" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                Simpan Profil
            </button>
        </div>
    </form>
</div>
@endsection
