@extends('layouts.admin.admin')

@section('content')
<div class="container-fluid py-4">
    <h1 class="h2 mb-4">Statistik Forum</h1>

    <div class="row g-4">
        <!-- Line Chart Card -->
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3 fw-semibold">
                        <i class="fas fa-chart-line text-primary me-2"></i>
                        Pertumbuhan User, Thread, Komentar per Bulan
                    </h5>
                    <div class="chart-container" style="height: 400px">
                        <canvas id="growthChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bar Chart Card -->
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3 fw-semibold">
                        <i class="fas fa-chart-bar text-success me-2"></i>
                        Kategori Thread Teraktif
                    </h5>
                    <div class="chart-container" style="height: 400px">
                        <canvas id="topCategoriesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pie Chart Card -->
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3 fw-semibold">
                        <i class="fas fa-chart-pie text-warning me-2"></i>
                        Persentase Thread per Kategori
                    </h5>
                    <div class="chart-container d-flex justify-content-center" style="height: 500px">
                        <div style="width: 80%; height: 100%">
                            <canvas id="pieChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
<script>
    // Shared chart options
    const chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'top',
                labels: {
                    padding: 20,
                    font: {
                        size: 13
                    }
                }
            },
            tooltip: {
                backgroundColor: '#1f2937',
                titleFont: { size: 14 },
                bodyFont: { size: 13 },
                padding: 12,
                cornerRadius: 8
            }
        }
    };

    // Line Chart Data
    const months = @json($monthsLabel);
    const usersData = @json($usersPerMonth);
    const threadsData = @json($threadsPerMonth);
    const commentsData = @json($commentsPerMonth);

    new Chart(document.getElementById('growthChart'), {
        type: 'line',
        data: {
            labels: months,
            datasets: [
                { 
                    label: 'User Baru', 
                    data: usersData, 
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 3,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    tension: 0.3,
                    fill: true
                },
                { 
                    label: 'Thread Baru', 
                    data: threadsData, 
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    borderWidth: 3,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    tension: 0.3,
                    fill: true
                },
                { 
                    label: 'Komentar Baru', 
                    data: commentsData, 
                    borderColor: '#f59e0b',
                    backgroundColor: 'rgba(245, 158, 11, 0.1)',
                    borderWidth: 3,
                    pointRadius: 5,
                    pointHoverRadius: 7,
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

    // Bar Chart Data
    const catLabels = @json($topCategories->pluck('name'));
    const catData = @json($topCategories->pluck('questions_count'));

    new Chart(document.getElementById('topCategoriesChart'), {
        type: 'bar',
        data: {
            labels: catLabels,
            datasets: [{
                label: 'Thread per Kategori',
                data: catData,
                backgroundColor: 'rgba(59, 130, 246, 0.8)',
                borderColor: 'rgba(59, 130, 246, 1)',
                borderWidth: 1,
                borderRadius: 6,
                hoverBackgroundColor: 'rgba(59, 130, 246, 1)'
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

    // Pie Chart Data
    const pieLabels = @json($categoryNames);
    const pieData = @json($threadCounts);

    new Chart(document.getElementById('pieChart'), {
        type: 'doughnut',
        data: {
            labels: pieLabels,
            datasets: [{
                label: 'Persentase Thread',
                data: pieData,
                backgroundColor: [
                    '#3b82f6', '#10b981', '#f59e0b', '#8b5cf6', '#ef4444', '#06b6d4', '#f97316'
                ],
                borderWidth: 1,
                hoverOffset: 15
            }]
        },
        options: {
            ...chartOptions,
            plugins: {
                ...chartOptions.plugins,
                legend: {
                    position: 'right',
                    labels: {
                        ...chartOptions.plugins.legend.labels,
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
                            const percentage = Math.round((value / total) * 100);
                            return `${label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            },
            cutout: '60%'
        }
    });
</script>

<style>
    .card {
        border-radius: 12px;
        border: none;
    }
    .chart-container {
        position: relative;
    }
</style>
@endsection