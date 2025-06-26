@extends('layouts.admin.admin')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="font-weight-bold text-primary">
            <i class="fas fa-tags mr-2"></i>Daftar Kategori Forum
        </h2>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            <i class="fas fa-plus mr-2"></i>Tambah Kategori
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if($categories->isEmpty())
        <div class="card shadow-sm">
            <div class="card-body text-center py-5">
                <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Belum ada kategori forum</h5>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary mt-3">
                    <i class="fas fa-plus mr-2"></i>Buat Kategori Pertama
                </a>
            </div>
        </div>
    @else
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th class="w-25">Nama Kategori</th>
                                <th class="w-50">Deskripsi</th>
                                <th class="w-25 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $cat)
                            <tr>
                                <td>
                                    <span class="font-weight-bold">{{ $cat->name }}</span>
                                </td>
                                <td>
                                    <span class="text-muted">{{ $cat->description ?? 'Tidak ada deskripsi' }}</span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center" style="gap: 8px;">
                                        <a href="{{ route('admin.categories.edit', $cat->id) }}" 
                                           class="btn btn-sm btn-outline-primary"
                                           data-toggle="tooltip" title="Edit Kategori">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('Yakin hapus kategori ini?')"
                                                    data-toggle="tooltip" title="Hapus Kategori">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted small">
                        Menampilkan {{ $categories->firstItem() }} - {{ $categories->lastItem() }} dari {{ $categories->total() }} kategori
                    </div>
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    @endif
</div>

@section('scripts')
<script>
$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
@endsection
@endsection