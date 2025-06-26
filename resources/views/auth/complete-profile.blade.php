@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto mt-10 bg-white p-8 rounded shadow">
    <h2 class="text-2xl font-bold mb-4">Lengkapi Profil Anda</h2>
    <form method="POST" action="{{ route('profile.complete.submit', $user->id) }}">
        @csrf
        @if($user->role === 'mahasiswa')
            <div class="mb-4">
                <label>Angkatan/Tahun Masuk</label>
                <input type="text" name="angkatan" class="form-input w-full"
                    value="{{ old('angkatan', $user->profile->angkatan ?? '') }}" required placeholder="Contoh: 2022">
            </div>
        @endif
        <div class="mb-4">
            <label>Bio/Deskripsi Singkat</label>
            <textarea name="bio" class="form-textarea w-full" rows="3"
                placeholder="Ceritakan sedikit tentang dirimu...">{{ old('bio', $user->profile->bio ?? '') }}</textarea>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan Profil</button>
    </form>
</div>
@endsection