@extends('layouts.admin.admin')

@section('content')
<div class="container mt-5">
    <h4>Kirim Pesan ke: {{ $user->name ?? '(user sudah dihapus)' }}</h4>
    <form method="POST" action="{{ route('admin.users.notify', $user->id) }}">
        @csrf
        <div class="form-group">
            <label for="message">Pesan Notifikasi</label>
            <textarea name="message" id="message" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Kirim</button>
    </form>
</div>
@endsection