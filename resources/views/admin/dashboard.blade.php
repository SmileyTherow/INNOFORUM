@extends('layouts.admin.admin')

@section('content')
<div class="container-fluid px-4">
    {{-- Hero Section --}}
    <div class="hero-section bg-gradient-primary-to-secondary text-white rounded-3 shadow-sm mb-4 overflow-hidden">
        <div class="container-fluid py-5">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-5 fw-bold mb-3">Admin Dashboard</h1>
                    <p class="lead mb-4 opacity-90">Selamat datang kembali, <strong>{{ Auth::user()->name }}</strong>! Berikut adalah informasi terbaru tentang INNOFORUM hari ini.</p>
                    <div class="d-flex align-items-center gap-3">
                        <span class="badge bg-light text-primary px-3 py-2 rounded-pill">
                            <i class="fas fa-clock me-2"></i> {{ now()->translatedFormat('l, j F Y') }}
                        </span>
                        <span class="badge bg-light text-primary px-3 py-2 rounded-pill">
                            <i class="fas fa-users me-2"></i> {{ $totalUsers ?? 0 }} Pengguna
                        </span>
                    </div>
                </div>
                <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                    <div class="hero-icon">
                        <i class="fas fa-chart-line fa-4x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Statistik Cards --}}
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <a href="{{ route('admin.users.index') }}" class="text-decoration-none">
                <div class="card card-hover border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="card-title text-muted text-uppercase small fw-semibold mb-2">Total User</h6>
                                <h2 class="fw-bold text-primary mb-0">{{ number_format($totalUsers ?? 0) }}</h2>
                                <small class="text-success">
                                    <i class="fas fa-arrow-up me-1"></i>
                                    {{ number_format($newUsersToday ?? 0) }} hari ini
                                </small>
                            </div>
                            <div class="avatar avatar-lg bg-primary bg-opacity-10 rounded-3 p-3">
                                <i class="fas fa-users text-primary fs-4"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 pt-0">
                        <small class="text-primary fw-semibold">
                            Lihat Detail <i class="fas fa-arrow-right ms-1"></i>
                        </small>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-xl-3 col-md-6">
            <a href="{{ route('admin.threads.index') }}" class="text-decoration-none">
                <div class="card card-hover border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="card-title text-muted text-uppercase small fw-semibold mb-2">Total Pertanyaan</h6>
                                <h2 class="fw-bold text-success mb-0">{{ number_format($totalThreads ?? 0) }}</h2>
                                <small class="text-success">
                                    <i class="fas fa-arrow-up me-1"></i>
                                    {{ number_format($newThreadsToday ?? 0) }} hari ini
                                </small>
                            </div>
                            <div class="avatar avatar-lg bg-success bg-opacity-10 rounded-3 p-3">
                                <i class="fas fa-comments text-success fs-4"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 pt-0">
                        <small class="text-success fw-semibold">
                            Lihat Detail <i class="fas fa-arrow-right ms-1"></i>
                        </small>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-xl-3 col-md-6">
            <a href="{{ route('admin.categories.index') }}" class="text-decoration-none">
                <div class="card card-hover border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="card-title text-muted text-uppercase small fw-semibold mb-2">Total Kategori</h6>
                                <h2 class="fw-bold text-warning mb-0">{{ number_format($totalCategories ?? 0) }}</h2>
                                <small class="text-muted">
                                    Top: {{ $topCategories->first()->name ?? 'N/A' }}
                                </small>
                            </div>
                            <div class="avatar avatar-lg bg-warning bg-opacity-10 rounded-3 p-3">
                                <i class="fas fa-list text-warning fs-4"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 pt-0">
                        <small class="text-warning fw-semibold">
                            Lihat Detail <i class="fas fa-arrow-right ms-1"></i>
                        </small>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-xl-3 col-md-6">
            <a href="{{ route('admin.comments.index') }}" class="text-decoration-none">
                <div class="card card-hover border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="card-title text-muted text-uppercase small fw-semibold mb-2">Total Komentar</h6>
                                <h2 class="fw-bold text-info mb-0">{{ number_format($totalComments ?? 0) }}</h2>
                                <small class="text-success">
                                    <i class="fas fa-arrow-up me-1"></i>
                                    {{ number_format($newCommentsToday ?? 0) }} hari ini
                                </small>
                            </div>
                            <div class="avatar avatar-lg bg-info bg-opacity-10 rounded-3 p-3">
                                <i class="fas fa-comment-dots text-info fs-4"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 pt-0">
                        <small class="text-info fw-semibold">
                            Lihat Detail <i class="fas fa-arrow-right ms-1"></i>
                        </small>
                    </div>
                </div>
            </a>
        </div>
    </div>

    {{-- Charts Section --}}
    <div class="row g-4 mb-4">
        {{-- Growth Chart --}}
        <div class="col-xl-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent py-3 border-0">
                    <h5 class="card-title mb-0 fw-semibold">
                        <i class="fas fa-chart-line text-primary me-2"></i>
                        Pertumbuhan Komunitas (6 Bulan Terakhir)
                    </h5>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="height: 300px">
                        <canvas id="growthChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Top Categories Chart --}}
        <div class="col-xl-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent py-3 border-0">
                    <h5 class="card-title mb-0 fw-semibold">
                        <i class="fas fa-chart-bar text-success me-2"></i>
                        Kategori Teraktif
                    </h5>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="height: 300px">
                        <canvas id="topCategoriesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Actions & Recent Activity --}}
    <div class="row g-4">
        {{-- Quick Actions --}}
        <div class="col-xl-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent py-3 border-0">
                    <h5 class="card-title mb-0 fw-semibold">
                        <i class="fas fa-bolt text-warning me-2"></i>
                        Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <a href="{{ route('admin.threads.reported') }}" class="btn btn-outline-primary w-100 h-100 py-3 d-flex flex-column align-items-center justify-content-center">
                                <i class="fas fa-plus-circle fa-2x mb-2"></i>
                                <span>Pertanyaan Dilaporkan</span>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('admin.comments.reported') }}" class="btn btn-outline-success w-100 h-100 py-3 d-flex flex-column align-items-center justify-content-center">
                                <i class="fas fa-folder-plus fa-2x mb-2"></i>
                                <span>Komentar Dilaporkan</span>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('admin.messages.index') }}" class="btn btn-outline-info w-100 h-100 py-3 d-flex flex-column align-items-center justify-content-center">
                                <i class="fas fa-envelope fa-2x mb-2"></i>
                                <span>Pesan Masuk</span>
                                @if(($unreadMessages ?? 0) > 0)
                                    <span class="badge bg-danger mt-1">{{ $unreadMessages ?? 0 }}</span>
                                @endif
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('admin.stats.index') }}" class="btn btn-outline-warning w-100 h-100 py-3 d-flex flex-column align-items-center justify-content-center">
                                <i class="fas fa-chart-pie fa-2x mb-2"></i>
                                <span>Detail Statistik</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Recent Activity --}}
        <div class="col-xl-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent py-3 border-0 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 fw-semibold">
                        <i class="fas fa-history text-info me-2"></i>
                        Aktivitas Terbaru
                    </h5>
                    <a href="{{ route('admin.threads.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>
                <div class="card-body">
                    <div class="activity-list">
                        <!-- Sample Recent Activities -->
                        <div class="activity-item d-flex align-items-center py-2 border-bottom">
                            <div class="activity-icon me-3">
                                <i class="fas fa-user-plus text-success"></i>
                            </div>
                            <div class="activity-content flex-grow-1">
                                <p class="mb-0 small">User baru bergabung: Susan</p>
                                <small class="text-muted">5 menit yang lalu</small>
                            </div>
                        </div>
                        <div class="activity-item d-flex align-items-center py-2 border-bottom">
                            <div class="activity-icon me-3">
                                <i class="fas fa-comment text-primary"></i>
                            </div>
                            <div class="activity-content flex-grow-1">
                                <p class="mb-0 small">Komentar baru pada thread: Laravel Tips</p>
                                <small class="text-muted">15 menit yang lalu</small>
                            </div>
                        </div>
                        <div class="activity-item d-flex align-items-center py-2 border-bottom">
                            <div class="activity-icon me-3">
                                <i class="fas fa-question-circle text-warning"></i>
                            </div>
                            <div class="activity-content flex-grow-1">
                                <p class="mb-0 small">Thread baru dibuat: Help with Vue.js</p>
                                <small class="text-muted">1 jam yang lalu</small>
                            </div>
                        </div>
                        <div class="activity-item d-flex align-items-center py-2">
                            <div class="activity-icon me-3">
                                <i class="fas fa-envelope text-info"></i>
                            </div>
                            <div class="activity-content flex-grow-1">
                                <p class="mb-0 small">Pesan baru dari: sarahpujiyanti@gmail.com</p>
                                <small class="text-muted">2 jam yang lalu</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Chart Options
    const chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'top',
                labels: {
                    padding: 15,
                    font: {
                        size: 12,
                        family: "'Inter', sans-serif"
                    },
                    usePointStyle: true
                }
            },
            tooltip: {
                backgroundColor: 'rgba(31, 41, 55, 0.95)',
                titleFont: { size: 13 },
                bodyFont: { size: 12 },
                padding: 10,
                cornerRadius: 6
            }
        }
    };

    // Growth Chart
    const months = @json($monthsLabel ?? []);
    const usersData = @json($usersPerMonth ?? []);
    const threadsData = @json($threadsPerMonth ?? []);
    const commentsData = @json($commentsPerMonth ?? []);

    if (document.getElementById('growthChart')) {
        new Chart(document.getElementById('growthChart'), {
            type: 'line',
            data: {
                labels: months,
                datasets: [
                    {
                        label: 'User Baru',
                        data: usersData,
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.05)',
                        borderWidth: 3,
                        pointBackgroundColor: '#3b82f6',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        tension: 0.3,
                        fill: true
                    },
                    {
                        label: 'Pertanyaan Baru',
                        data: threadsData,
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.05)',
                        borderWidth: 3,
                        pointBackgroundColor: '#10b981',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        tension: 0.3,
                        fill: true
                    },
                    {
                        label: 'Komentar Baru',
                        data: commentsData,
                        borderColor: '#f59e0b',
                        backgroundColor: 'rgba(245, 158, 11, 0.05)',
                        borderWidth: 3,
                        pointBackgroundColor: '#f59e0b',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        tension: 0.3,
                        fill: true
                    }
                ]
            },
            options: {
                ...chartOptions,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            drawBorder: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }

    // Top Categories Chart
    const catLabels = @json($topCategories->pluck('name') ?? []);
    const catData = @json($topCategories->pluck('questions_count') ?? []);

    if (document.getElementById('topCategoriesChart')) {
        new Chart(document.getElementById('topCategoriesChart'), {
            type: 'bar',
            data: {
                labels: catLabels,
                datasets: [{
                    label: 'Jumlah Pertanyaan',
                    data: catData,
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(245, 158, 11, 0.8)',
                        'rgba(139, 92, 246, 0.8)',
                        'rgba(239, 68, 68, 0.8)'
                    ],
                    borderColor: [
                        '#3b82f6',
                        '#10b981',
                        '#f59e0b',
                        '#8b5cf6',
                        '#ef4444'
                    ],
                    borderWidth: 1,
                    borderRadius: 6
                }]
            },
            options: {
                ...chartOptions,
                plugins: {
                    ...chartOptions.plugins,
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            drawBorder: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }
</script>

<style>
    .hero-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        position: relative;
        overflow: hidden;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        transform: translate(100px, -100px);
    }

    .hero-section::after {
        content: '';
        position: absolute;
        bottom: -100px;
        left: -100px;
        width: 400px;
        height: 400px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
    }

    .hero-icon {
        position: relative;
        z-index: 1;
    }

    .card {
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
    }

    .avatar {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .activity-list {
        max-height: 300px;
        overflow-y: auto;
    }

    .activity-item:last-child {
        border-bottom: none !important;
    }

    .activity-icon {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(0, 0, 0, 0.05);
        border-radius: 8px;
    }

    .chart-container {
        position: relative;
    }

    .btn {
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-2px);
    }

    @media (max-width: 768px) {
        .hero-section .display-5 {
            font-size: 2rem;
        }

        .hero-section .lead {
            font-size: 1rem;
        }
    }
</style>
@endsection
