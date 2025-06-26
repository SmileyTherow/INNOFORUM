@extends('layouts.admin.admin')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Reset Password Admin</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form method="POST" action="{{ route('admin.reset-password.update') }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Password Lama</label>
            <input type="password" class="form-control" name="current_password">
        </div>
        <div class="mb-3">
            <label>Password Baru</label>
            <input type="password" class="form-control" name="new_password">
        </div>
        <div class="mb-3">
            <label>Konfirmasi Password Baru</label>
            <input type="password" class="form-control" name="new_password_confirmation">
        </div>
        <button class="btn btn-primary" type="submit">Ganti Password</button>
        <a href="{{ route('admin.settings.show') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection