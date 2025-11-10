@extends('layouts.admin.admin')

@section('content')
    <div class="container-fluid mt-4">
        <h2 class="mb-4 font-weight-bold text-primary">Daftar Seluruh User</h2>

        {{-- FORM TAMBAH USERNAME BARU --}}
        <div class="row mb-4">
            <!-- Add Username Card -->
            <div class="col-lg-6 mb-3 mb-lg-0">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-gradient-success text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-user-plus mr-2"></i>Tambah Username Baru
                        </h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.users.addUsername') }}">
                            @csrf
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white">
                                        <i class="fas fa-id-card text-success"></i>
                                    </span>
                                </div>
                                <input type="text" name="username" class="form-control form-control-lg"
                                    placeholder="Masukkan NIM/NIDN" required>
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-success btn-lg px-4">
                                        <i class="fas fa-plus mr-1"></i>Tambah
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Search Card -->
            <div class="col-lg-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-gradient-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-search mr-2"></i>Cari User
                        </h5>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('admin.users.index') }}">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white">
                                        <i class="fas fa-search text-primary"></i>
                                    </span>
                                </div>
                                <input type="text" name="q" class="form-control form-control-lg"
                                    placeholder="Cari berdasarkan nama atau email" value="{{ request('q') }}">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary btn-lg px-4">
                                        <i class="fas fa-search mr-1"></i>Cari
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

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
                                        <a href="{{ route('admin.users.notify', $user->id) }}" class="btn btn-sm btn-info"
                                            data-toggle="tooltip" title="Kirim Pesan">
                                            <i class="fas fa-paper-plane"></i>
                                        </a>
                                        <form action="{{ route('admin.users.deleteFields', $user->id) }}" method="POST"
                                            style="display:inline"
                                            onsubmit="return confirm('Yakin ingin menghapus nama & email user ini?')">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-danger" data-toggle="tooltip"
                                                title="Hapus Data">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
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

    <style>
        .bg-gradient-success {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        }

        .bg-gradient-primary {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        }

        .avatar-circle {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 14px;
        }

        .table th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        .table td {
            vertical-align: middle;
            border-right: 1px solid #dee2e6;
        }

        .table td:last-child {
            border-right: none;
        }

        .table th {
            border-right: 1px solid #dee2e6;
        }

        .table th:last-child {
            border-right: none;
        }

        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
            transition: background-color 0.2s ease;
        }

        .btn-group .btn {
            margin: 0 2px;
        }

        .font-weight-medium {
            font-weight: 500;
        }

        .card {
            border-radius: 10px;
            overflow: hidden;
        }

        .card-header {
            border-bottom: 2px solid rgba(0, 0, 0, 0.05);
        }

        .form-control:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, .25);
        }

        .input-group-text {
            border: 1px solid #ced4da;
        }
    </style>

    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endsection
