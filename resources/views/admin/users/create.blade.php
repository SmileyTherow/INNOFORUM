@extends('admin.layout')

@section('content')
<h1>Tambah User</h1>
<form method="POST" action="{{ route('admin.users.store') }}">
    @csrf
    <label>Username</label>
    <input type="text" name="username" required>
    <label>Role</label>
    <select name="role" required>
        <option value="mahasiswa">Mahasiswa</option>
        <option value="dosen">Dosen</option>
        <option value="admin">Admin</option>
    </select>
    <label>Nama</label>
    <input type="text" name="name" required>
    <label>Email</label>
    <input type="email" name="email">
    <label>Password</label>
    <input type="password" name="password" required>
    <label>Konfirmasi Password</label>
    <input type="password" name="password_confirmation" required>
    <button type="submit">Simpan</button>
</form>
@endsection