@extends('layouts.admin.admin')

@section('title', 'Admin Activity Log')

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center">
            <i class="fas fa-history me-3 fa-2x text-primary"></i>
            <div>
                <h1 class="h3 mb-0 text-gray-800">Admin Activities</h1>
                <p class="mb-0 text-muted">Semua jejak aktivitas admin tercatat dengan detail</p>
            </div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <i class="fas fa-filter me-2 text-primary"></i>
                <h6 class="m-0 font-weight-bold text-primary">Filter & Pencarian</h6>
            </div>
            <div class="text-muted small">
                <i class="fas fa-info-circle me-1 text-primary"></i>
                Total: <strong>{{ $activities->total() }}</strong> aktivitas
            </div>
        </div>
        <div class="card-body">
            @if ($activities->count())
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                        <thead class="bg-light">
                            <tr>
                                <th width="5%">#</th>
                                <th width="20%">Admin</th>
                                <th width="30%">Aktivitas</th>
                                <th width="15%">Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($activities as $activity)
                            <tr>
                                <td class="text-center fw-bold text-primary">
                                    {{ $loop->iteration + ($activities->currentPage() - 1) * $activities->perPage() }}
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @php
                                            $admin = optional($activity->admin);
                                            $avatar = $admin->avatar ?? '';
                                            $nama = $admin->name ?? ($activity->admin_name ?? '—');
                                        @endphp
                                        @if($avatar)
                                            <img src="{{ asset('storage/'.$avatar) }}"
                                                 alt="{{ $nama }}"
                                                 class="rounded-circle me-3"
                                                 width="40"
                                                 height="40">
                                        @else
                                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                                                 style="width: 40px; height: 40px;">
                                                {{ strtoupper(substr($nama, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <div class="fw-bold text-gray-800">{{ $nama }}</div>
                                            @if($admin->email)
                                                <div class="text-muted small">{{ $admin->email }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-bold text-gray-800">
                                        {{ $activity->description ?? ($activity->action ?? '—') }}
                                    </div>
                                    @if($activity->note ?? false)
                                        <div class="text-muted small mt-1 fst-italic">
                                            <i class="fas fa-sticky-note me-1 text-warning"></i>
                                            {{ $activity->note }}
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-bold text-gray-800">
                                        {{ $activity->created_at ? $activity->created_at->format('Y-m-d H:i:s') : '—' }}
                                    </div>
                                    <div class="text-muted small">
                                        <i class="fas fa-clock me-1 text-primary"></i>
                                        {{ $activity->created_at ? $activity->created_at->diffForHumans() : '' }}
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $activities->appends(request()->query())->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-5">
                    <i class="fas fa-history fa-4x text-muted mb-3"></i>
                    <h4 class="text-gray-800">Belum ada aktivitas admin</h4>
                    <p class="text-muted">Setiap aksi yang dilakukan admin akan tercatat di sini dengan detail lengkap.</p>
                    <div class="text-primary small">
                        <i class="fas fa-check-circle me-1"></i>
                        Sistem siap mencatat aktivitas
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
