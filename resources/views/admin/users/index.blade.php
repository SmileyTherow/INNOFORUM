@extends('layouts.admin.admin')

@section('content')
<div class="container-fluid mt-4">
    <h2 class="mb-4 font-weight-bold text-primary">Daftar Seluruh User</h2>

    {{-- FORM TAMBAH USERNAME BARU --}}
    <form method="POST" action="{{ route('admin.users.addUsername') }}" class="mb-3 d-flex" style="gap: 10px;">
        @csrf
        <input type="text" name="username" class="form-control" placeholder="Tambah NIM/NIDN (username baru)" required>
        <button type="submit" class="btn btn-success">Tambah Username</button>
    </form>
    @if ($errors->has('username'))
        <div class="alert alert-danger mb-2">{{ $errors->first('username') }}</div>
    @endif
    @if (session('success'))
        <div class="alert alert-success mb-2">{{ session('success') }}</div>
    @endif
    
    {{-- FORM CARI USER --}}
    <form method="GET" action="{{ route('admin.users.index') }}" class="mb-3 d-flex" style="gap: 10px;">
        <input type="text" name="q" class="form-control" placeholder="Cari user (nama/email)" value="{{ request('q') }}">
        <button type="submit" class="btn btn-primary">Cari</button>
    </form>
    <div class="card shadow mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Tanggal Daftar</th>
                            <th>Operation</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at->format('d-m-Y') }}</td>
                                <td>
                                    <!-- Tombol Hapus Data User -->
                                    <form action="{{ route('admin.users.deleteFields', $user->id) }}" method="POST" style="display:inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus nama & email user ini?')">Hapus Data</button>
                                    </form>
                                    <!-- Tombol Kirim Notifikasi -->
                                    <a href="{{ route('admin.users.notify', $user->id) }}" class="btn btn-info btn-sm">Kirim Pesan</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-4">Tidak ada user ditemukan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $users->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection