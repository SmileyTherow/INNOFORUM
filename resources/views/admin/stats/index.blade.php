@extends('layouts.admin.admin')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 fw-bold text-gradient text-primary mb-2">Dashboard Statistik Forum</h1>
            <p class="text-muted mb-0">Analisis dan insight perkembangan komunitas forum</p>
        </div>
        <div class="text-end">
            <div class="badge bg-light text-dark px-3 py-2 rounded-pill">
                <i class="fas fa-calendar-alt me-2"></i>
                {{ now()->format('d M Y') }}
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card card-hover shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="card-title text-muted mb-2">Total Pengguna</h6>
                            <h3 class="fw-bold text-primary mb-0">{{ number_format($totalUsers ?? 0) }}</h3>
                            <small class="text-success">
                                <i class="fas fa-arrow-up me-1"></i>
                                {{ number_format(($usersPerMonth->last() ?? 0) - ($usersPerMonth->first() ?? 0)) }} bulan ini
                            </small>
                        </div>
                        <div class="avatar avatar-lg bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-users text-primary fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card card-hover shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="card-title text-muted mb-2">Total Pertanyaan</h6>
                            <h3 class="fw-bold text-success mb-0">{{ number_format($totalThreads ?? 0) }}</h3>
                            <small class="text-success">
                                <i class="fas fa-arrow-up me-1"></i>
                                {{ number_format(($threadsPerMonth->last() ?? 0) - ($threadsPerMonth->first() ?? 0)) }} bulan ini
                            </small>
                        </div>
                        <div class="avatar avatar-lg bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-question-circle text-success fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card card-hover shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="card-title text-muted mb-2">Total Komentar</h6>
                            <h3 class="fw-bold text-warning mb-0">{{ number_format($totalComments ?? 0) }}</h3>
                            <small class="text-success">
                                <i class="fas fa-arrow-up me-1"></i>
                                {{ number_format(($commentsPerMonth->last() ?? 0) - ($commentsPerMonth->first() ?? 0)) }} bulan ini
                            </small>
                        </div>
                        <div class="avatar avatar-lg bg-warning bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-comments text-warning fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card card-hover shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="card-title text-muted mb-2">Kategori Aktif</h6>
                            <h3 class="fw-bold text-info mb-0">{{ number_format($totalCategories ?? 0) }}</h3>
                            <small class="text-muted">Top: {{ $topCategories->first()->name ?? 'N/A' }}</small>
                        </div>
                        <div class="avatar avatar-lg bg-info bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-tags text-info fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row g-4">
        <!-- Growth Chart -->
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-transparent py-3">
                    <h5 class="card-title mb-0 fw-semibold">
                        <i class="fas fa-chart-line text-primary me-2"></i>
                        Pertumbuhan Komunitas (6 Bulan Terakhir)
                    </h5>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="height: 400px">
                        <canvas id="growthChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Categories Charts -->
        <div class="col-xl-8">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-transparent py-3">
                    <h5 class="card-title mb-0 fw-semibold">
                        <i class="fas fa-chart-bar text-success me-2"></i>
                        Kategori Pertanyaan Teraktif
                    </h5>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="height: 350px">
                        <canvas id="topCategoriesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-transparent py-3">
                    <h5 class="card-title mb-0 fw-semibold">
                        <i class="fas fa-chart-pie text-warning me-2"></i>
                        Distribusi Kategori
                    </h5>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="height: 350px">
                        <canvas id="pieChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-transparent py-3">
                    <h5 class="card-title mb-0 fw-semibold">
                        <i class="fas fa-history text-info me-2"></i>
                        Ringkasan Aktivitas
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3 mb-3">
                            <div class="border-end">
                                <h4 class="fw-bold text-primary">{{ number_format($avgThreadsPerDay ?? 0) }}</h4>
                                <small class="text-muted">Pertanyaan/Hari</small>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="border-end">
                                <h4 class="fw-bold text-success">{{ number_format($avgCommentsPerDay ?? 0) }}</h4>
                                <small class="text-muted">Komentar/Hari</small>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="border-end">
                                <h4 class="fw-bold text-warning">{{ number_format($avgUsersPerDay ?? 0) }}</h4>
                                <small class="text-muted">User Baru/Hari</small>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <h4 class="fw-bold text-info">{{ number_format($engagementRate ?? 0) }}%</h4>
                            <small class="text-muted">Tingkat Engagement</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Enhanced chart options
    const chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'top',
                labels: {
                    padding: 20,
                    font: {
                        size: 13,
                        family: "'Inter', sans-serif"
                    },
                    usePointStyle: true
                }
            },
            tooltip: {
                backgroundColor: 'rgba(31, 41, 55, 0.95)',
                titleFont: {
                    size: 14,
                    family: "'Inter', sans-serif"
                },
                bodyFont: {
                    size: 13,
                    family: "'Inter', sans-serif"
                },
                padding: 12,
                cornerRadius: 8,
                displayColors: true,
                callbacks: {
                    label: function(context) {
                        return `${context.dataset.label}: ${context.parsed.y?.toLocaleString() || 0}`;
                    }
                }
            }
        },
        interaction: {
            intersect: false,
            mode: 'index'
        },
        animations: {
            tension: {
                duration: 1000,
                easing: 'linear'
            }
        }
    };

    // Line Chart - Growth Analysis
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
                        pointRadius: 6,
                        pointHoverRadius: 8,
                        tension: 0.4,
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
                        pointRadius: 6,
                        pointHoverRadius: 8,
                        tension: 0.4,
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
                        pointRadius: 6,
                        pointHoverRadius: 8,
                        tension: 0.4,
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
                            drawBorder: false,
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString();
                            }
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

    // Bar Chart - Top Categories
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
                        'rgba(239, 68, 68, 0.8)',
                        'rgba(6, 182, 212, 0.8)',
                        'rgba(249, 115, 22, 0.8)'
                    ],
                    borderColor: [
                        '#3b82f6',
                        '#10b981',
                        '#f59e0b',
                        '#8b5cf6',
                        '#ef4444',
                        '#06b6d4',
                        '#f97316'
                    ],
                    borderWidth: 1,
                    borderRadius: 8,
                    hoverBackgroundColor: [
                        '#3b82f6',
                        '#10b981',
                        '#f59e0b',
                        '#8b5cf6',
                        '#ef4444',
                        '#06b6d4',
                        '#f97316'
                    ]
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
                            drawBorder: false,
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString();
                            }
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

    // Pie Chart - Category Distribution
    const pieLabels = @json($categoryNames ?? []);
    const pieData = @json($threadCounts ?? []);

    if (document.getElementById('pieChart')) {
        new Chart(document.getElementById('pieChart'), {
            type: 'doughnut',
            data: {
                labels: pieLabels,
                datasets: [{
                    label: 'Persentase Pertanyaan',
                    data: pieData,
                    backgroundColor: [
                        '#3b82f6', '#10b981', '#f59e0b', '#8b5cf6',
                        '#ef4444', '#06b6d4', '#f97316', '#84cc16',
                        '#f43f5e', '#8b5cf6', '#06b6d4', '#f97316'
                    ],
                    borderWidth: 2,
                    borderColor: '#ffffff',
                    hoverOffset: 20
                }]
            },
            options: {
                ...chartOptions,
                plugins: {
                    ...chartOptions.plugins,
                    legend: {
                        position: 'bottom',
                        labels: {
                            ...chartOptions.plugins.legend.labels,
                            padding: 15,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    },
                    tooltip: {
                        ...chartOptions.plugins.tooltip,
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = total > 0 ? Math.round((value / total) * 100) : 0;
                                return `${label}: ${value.toLocaleString()} (${percentage}%)`;
                            }
                        }
                    }
                },
                cutout: '65%'
            }
        });
    }
</script>

<style>
    .card {
        border-radius: 16px;
        border: none;
        transition: all 0.3s ease;
    }

    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1) !important;
    }

    .chart-container {
        position: relative;
    }

    .avatar {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .text-gradient {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .border-end {
        border-right: 1px solid #e2e8f0 !important;
    }

    @media (max-width: 768px) {
        .border-end {
            border-right: none !important;
            border-bottom: 1px solid #e2e8f0 !important;
            padding-bottom: 1rem;
            margin-bottom: 1rem;
        }
    }
</style>
@endsection
