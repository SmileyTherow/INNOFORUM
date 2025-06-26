@extends('admin.layout')

@section('content')
<h1>Edit User</h1>
<form method="POST" action="{{ route('admin.users.update', $user->id) }}">
    @csrf
    @method('PUT')
    <label>Username</label>
    <input type="text" name="username" value="{{ $user->username }}" required>
    <label>Role</label>
    <select name="role" required>
        <option value="mahasiswa" {{ $user->role == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
        <option value="dosen" {{ $user->role == 'dosen' ? 'selected' : '' }}>Dosen</option>
        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
    </select>
    <label>Nama</label>
    <input type="text" name="name" value="{{ $user->name }}" required>
    <label>Email</label>
    <input type="email" name="email" value="{{ $user->email }}">
    <label>Password (kosongkan jika tidak diubah)</label>
    <input type="password" name="password">
    <label>Konfirmasi Password</label>
    <input type="password" name="password_confirmation">
    <button type="submit">Update</button>
</form>
@endsection