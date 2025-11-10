@extends('layouts.admin.admin')

@section('content')
<div class="container-fluid mt-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1 font-weight-bold text-dark">
                <i class="fas fa-tags mr-2 text-primary"></i>Manajemen Kategori Forum
            </h2>
            <p class="text-muted mb-0">Kelola semua kategori forum diskusi</p>
        </div>
        <div>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-lg shadow-sm">
                <i class="fas fa-plus-circle mr-2"></i>Tambah Kategori
            </a>
        </div>
    </div>

    <!-- Success Alert -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" style="background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle fa-2x mr-3 text-success"></i>
                <div class="flex-grow-1">
                    <strong>Berhasil!</strong>
                    <p class="mb-0">{{ session('success') }}</p>
                </div>
                <button type="button" class="close ml-3" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @endif

    <!-- Stats Card -->
    @if(!$categories->isEmpty())
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-primary text-white mr-3">
                            <i class="fas fa-tags fa-2x"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1 small">Total Kategori</h6>
                            <h3 class="mb-0 font-weight-bold">{{ $categories->total() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Empty State -->
    @if($categories->isEmpty())
        <div class="card shadow-sm border-0">
            <div class="card-body text-center py-5">
                <div class="empty-state">
                    <div class="empty-icon mb-4">
                        <i class="fas fa-tags fa-4x text-muted" style="opacity: 0.3;"></i>
                    </div>
                    <h4 class="font-weight-normal mb-2">Belum Ada Kategori Forum</h4>
                    <p class="text-muted mb-4">Mulai dengan membuat kategori pertama untuk forum diskusi Anda</p>
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus-circle mr-2"></i>Buat Kategori Pertama
                    </a>
                </div>
            </div>
        </div>
    @else
        <!-- Categories Table -->
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 text-uppercase small font-weight-bold" width="5%">
                                    <i class="fas fa-hashtag mr-1 text-primary"></i>No
                                </th>
                                <th class="border-0 text-uppercase small font-weight-bold" width="25%">
                                    <i class="fas fa-tag mr-1 text-primary"></i>Nama Kategori
                                </th>
                                <th class="border-0 text-uppercase small font-weight-bold" width="50%">
                                    <i class="fas fa-align-left mr-1 text-primary"></i>Deskripsi
                                </th>
                                <th class="border-0 text-uppercase small font-weight-bold text-center" width="20%">
                                    <i class="fas fa-cog mr-1 text-primary"></i>Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $index => $cat)
                            <tr class="border-bottom">
                                <td class="align-middle">
                                    <span class="badge badge-light badge-pill px-3 py-2">
                                        {{ $categories->firstItem() + $index }}
                                    </span>
                                </td>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center">
                                        <div class="category-icon bg-primary text-white mr-3">
                                            <i class="fas fa-folder"></i>
                                        </div>
                                        <div>
                                            <div class="font-weight-bold text-dark">{{ $cat->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <span class="text-muted">{{ $cat->description ?? 'Tidak ada deskripsi' }}</span>
                                </td>
                                <td class="align-middle text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.categories.edit', $cat->id) }}"
                                           class="btn btn-sm btn-outline-primary"
                                           data-toggle="tooltip"
                                           data-placement="top"
                                           title="Edit Kategori">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.categories.destroy', $cat->id) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Yakin hapus kategori ini? Semua pertanyaan dalam kategori ini akan terpengaruh.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-sm btn-outline-danger"
                                                    data-toggle="tooltip"
                                                    data-placement="top"
                                                    title="Hapus Kategori">
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
            @if($categories->hasPages())
            <div class="card-footer bg-white border-top">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted small">
                        Menampilkan {{ $categories->firstItem() }} - {{ $categories->lastItem() }} dari {{ $categories->total() }} kategori
                    </div>
                    <div>
                        {{ $categories->links() }}
                    </div>
                </div>
            </div>
            @endif
        </div>
    @endif
</div>

<style>
/* Icon Box Styling */
.icon-box {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

/* Category Icon */
.category-icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    font-size: 1rem;
}

/* Table Hover Effect */
.table tbody tr {
    transition: all 0.2s ease;
}

.table tbody tr:hover {
    background-color: #f8f9fa;
    transform: scale(1.001);
}

/* Button Styling */
.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #5568d3 0%, #66428a 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}

.btn-outline-primary {
    color: #667eea;
    border-color: #667eea;
    transition: all 0.3s ease;
}

.btn-outline-primary:hover {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-color: #667eea;
    color: white;
    transform: translateY(-1px);
}

.btn-outline-danger {
    color: #f56565;
    border-color: #f56565;
    transition: all 0.3s ease;
}

.btn-outline-danger:hover {
    background: linear-gradient(135deg, #fc8181 0%, #f56565 100%);
    border-color: #f56565;
    color: white;
    transform: translateY(-1px);
}

/* Badge Styling */
.badge-light {
    background-color: #e9ecef;
    color: #495057;
    font-weight: 600;
}

/* Empty State */
.empty-state {
    padding: 2rem 0;
}

.empty-icon {
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0%, 100% {
        transform: translateY(0px);
    }
    50% {
        transform: translateY(-10px);
    }
}

/* Card Hover */
.card {
    transition: all 0.3s ease;
}

.card:hover {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

/* Button Group */
.btn-group .btn {
    border-radius: 0.25rem;
    margin: 0 2px;
}

/* Alert Custom */
.alert {
    border-radius: 0.5rem;
}

/* Stats Card Animation */
@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.card {
    animation: slideInUp 0.4s ease-out;
}
</style>

@section('scripts')
<script>
$(document).ready(function() {
    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();

    // Add confirmation with better UX
    $('form[onsubmit]').on('submit', function(e) {
        const confirmed = confirm($(this).attr('onsubmit').replace('return ', '').replace(/'/g, ''));
        if (!confirmed) {
            e.preventDefault();
            return false;
        }
    });
});
</script>
@endsection
@endsection
