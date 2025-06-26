@extends('admin.layout')

@section('content')
<h1>Detail User</h1>
<table class="table">
    <tr><th>ID</th><td>{{ $user->id }}</td></tr>
    <tr><th>Username</th><td>{{ $user->username }}</td></tr>
    <tr><th>Role</th><td>{{ $user->role }}</td></tr>
    <tr><th>Nama</th><td>{{ $user->name }}</td></tr>
    <tr><th>Email</th><td>{{ $user->email }}</td></tr>
    <tr><th>Prodi</th><td>{{ $user->prodi }}</td></tr>
    <tr><th>Avatar</th>
        <td>
            @if($user->avatar)
                <img src="{{ asset('storage/'.$user->avatar) }}" width="70">
            @endif
        </td>
    </tr>
    <tr><th>Dibuat</th><td>{{ $user->created_at }}</td></tr>
</table>
<a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Kembali</a>
@endsection