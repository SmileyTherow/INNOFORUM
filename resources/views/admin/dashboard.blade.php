@extends('layouts.admin.admin')

@section('content')
<div class="container-fluid">
    {{-- Hero Section --}}
    <div class="hero-section bg-gradient-primary-to-secondary text-white py-5 mb-4">
        <div class="container py-3">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-4 font-weight-bold mb-3">Admin Dashboard</h1>
                    <p class="lead mb-4">selamat datang kembali, {{ Auth::user()->name }}! Berikut adalah informasi terbaru tentang forum Anda hari ini.</p>
                    <div class="d-flex">
                        <span class="badge badge-light mr-2">
                            <i class="fas fa-clock mr-1"></i> {{ now()->format('l, F j, Y') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="container-fluid mt-4">
        {{-- Statistik Cards --}}
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <a href="{{ route('admin.users.index') }}" style="text-decoration:none">
                    <div class="card bg-primary text-white shadow h-100 py-2">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">Total User</div>
                                    <div class="h5 mb-0 font-weight-bold">{{ $totalUsers }}</div>
                                </div>
                                <i class="fas fa-users fa-2x"></i>
                            </div>
                        </div>
                        <div class="card-footer text-white-50 small">Lihat Detail</div>
                    </div>
                </a>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <a href="{{ route('admin.threads.index') }}" style="text-decoration:none">
                    <div class="card bg-success text-white shadow h-100 py-2">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">Total Thread</div>
                                    <div class="h5 mb-0 font-weight-bold">{{ $totalThreads }}</div>
                                </div>
                                <i class="fas fa-comments fa-2x"></i>
                            </div>
                        </div>
                        <div class="card-footer text-white-50 small">Lihat Detail</div>
                    </div>
                </a>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <a href="{{ route('admin.categories.index') }}" style="text-decoration:none">
                    <div class="card bg-warning text-white shadow h-100 py-2">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">Total Kategori</div>
                                    <div class="h5 mb-0 font-weight-bold">{{ $totalCategories }}</div>
                                </div>
                                <i class="fas fa-list fa-2x"></i>
                            </div>
                        </div>
                        <div class="card-footer text-white-50 small">Lihat Detail</div>
                    </div>
                </a>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <a href="{{ route('admin.comments.index') }}" style="text-decoration:none">
                    <div class="card bg-info text-white shadow h-100 py-2">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">Total Komentar</div>
                                    <div class="h5 mb-0 font-weight-bold">{{ $totalComments }}</div>
                                </div>
                                <i class="fas fa-comment-dots fa-2x"></i>
                            </div>
                        </div>
                        <div class="card-footer text-white-50 small">Lihat Detail</div>
                    </div>
                </a>
            </div>
        </div>
        <!-- Statistik Grafik -->
        <div class="row mb-4">
            <div class="col-xl-8 col-md-12 mb-4">
                <div class="card shadow h-100 p-4">
                    <h5 class="font-weight-bold mb-3">Pertumbuhan User, Thread, Komentar per Bulan</h5>
                    <canvas id="growthChart"></canvas>
                </div>
            </div>
            <div class="col-xl-4 col-md-12 mb-4">
                <div class="card shadow h-100 p-4">
                    <h5 class="font-weight-bold mb-3">Kategori Thread Teraktif</h5>
                    <canvas id="topCategoriesChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Chart.js CDN -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
        const months = @json($monthsLabel);
        const usersData = @json($usersPerMonth);
        const threadsData = @json($threadsPerMonth);
        const commentsData = @json($commentsPerMonth);

        // Line Chart
        new Chart(document.getElementById('growthChart'), {
            type: 'line',
            data: {
                labels: months,
                datasets: [
                    { label: 'User Baru', data: usersData, borderColor: '#2563eb', backgroundColor:'rgba(37,99,235,0.1)', tension:0.3 },
                    { label: 'Thread Baru', data: threadsData, borderColor: '#22c55e', backgroundColor:'rgba(34,197,94,0.1)', tension:0.3 },
                    { label: 'Komentar Baru', data: commentsData, borderColor: '#f59e42', backgroundColor:'rgba(245,158,66,0.1)', tension:0.3 }
                ]
            },
            options: { responsive: true }
        });

        // Bar Chart Kategori Teraktif
        const catLabels = @json($topCategories->pluck('name'));
        const catData = @json($topCategories->pluck('questions_count'));
        new Chart(document.getElementById('topCategoriesChart'), {
            type: 'bar',
            data: {
                labels: catLabels,
                datasets: [{
                    label: 'Thread per Kategori',
                    data: catData,
                    backgroundColor: '#2563eb'
                }]
            },
            options: { responsive: true }
        });
        </script>
    </div>
</div>

<style>
    .hero-section {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        border-radius: 0 0 10px 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    .hero-section h1 {
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
    }
</style>
@endsection
