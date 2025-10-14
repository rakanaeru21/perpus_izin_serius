@extends('layouts.dashboard')

@section('title', 'Laporan - Admin')
@section('page-title', 'Laporan Sistem')
@section('user-name', 'Administrator')
@section('user-role', 'Admin')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-bar-chart text-primary me-2"></i>
                    Laporan Perpustakaan
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <div class="card border-0 bg-light">
                            <div class="card-body text-center">
                                <i class="bi bi-file-earmark-text text-primary mb-2" style="font-size: 2rem;"></i>
                                <h6>Laporan Harian</h6>
                                <input type="date" class="form-control form-control-sm mb-2" id="dailyDate" value="{{ date('Y-m-d') }}">
                                <button class="btn btn-outline-primary btn-sm me-1" onclick="generateReport('daily', 'view')">Preview</button>
                                <button class="btn btn-primary btn-sm" onclick="generateReport('daily', 'pdf')">
                                    <i class="bi bi-file-pdf"></i> PDF
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card border-0 bg-light">
                            <div class="card-body text-center">
                                <i class="bi bi-calendar-week text-success mb-2" style="font-size: 2rem;"></i>
                                <h6>Laporan Mingguan</h6>
                                <input type="week" class="form-control form-control-sm mb-2" id="weeklyDate" value="{{ date('Y-\WW') }}">
                                <button class="btn btn-outline-success btn-sm me-1" onclick="generateReport('weekly', 'view')">Preview</button>
                                <button class="btn btn-success btn-sm" onclick="generateReport('weekly', 'pdf')">
                                    <i class="bi bi-file-pdf"></i> PDF
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card border-0 bg-light">
                            <div class="card-body text-center">
                                <i class="bi bi-calendar-month text-warning mb-2" style="font-size: 2rem;"></i>
                                <h6>Laporan Bulanan</h6>
                                <input type="month" class="form-control form-control-sm mb-2" id="monthlyDate" value="{{ date('Y-m') }}">
                                <button class="btn btn-outline-warning btn-sm me-1" onclick="generateReport('monthly', 'view')">Preview</button>
                                <button class="btn btn-warning btn-sm" onclick="generateReport('monthly', 'pdf')">
                                    <i class="bi bi-file-pdf"></i> PDF
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card border-0 bg-light">
                            <div class="card-body text-center">
                                <i class="bi bi-calendar4 text-info mb-2" style="font-size: 2rem;"></i>
                                <h6>Laporan Tahunan</h6>
                                <select class="form-control form-control-sm mb-2" id="yearlyDate">
                                    @for($year = date('Y'); $year >= 2020; $year--)
                                        <option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>{{ $year }}</option>
                                    @endfor
                                </select>
                                <button class="btn btn-outline-info btn-sm me-1" onclick="generateReport('yearly', 'view')">Preview</button>
                                <button class="btn btn-info btn-sm" onclick="generateReport('yearly', 'pdf')">
                                    <i class="bi bi-file-pdf"></i> PDF
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Loading Modal -->
<div class="modal fade" id="loadingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center p-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2 mb-0">Generating laporan...</p>
            </div>
        </div>
    </div>
</div>

<!-- Report Preview Modal -->
<div class="modal fade" id="reportPreviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reportPreviewTitle">Preview Laporan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="reportPreviewContent">
                <!-- Content will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="downloadPdfBtn">
                    <i class="bi bi-file-pdf"></i> Download PDF
                </button>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h6 class="card-title mb-0">Statistik Peminjaman</h6>
                <div class="btn-group btn-group-sm" role="group">
                    <input type="radio" class="btn-check" name="borrowingPeriod" id="week" value="week" checked>
                    <label class="btn btn-outline-primary" for="week">Minggu</label>

                    <input type="radio" class="btn-check" name="borrowingPeriod" id="month" value="month">
                    <label class="btn btn-outline-primary" for="month">Bulan</label>

                    <input type="radio" class="btn-check" name="borrowingPeriod" id="year" value="year">
                    <label class="btn btn-outline-primary" for="year">Tahun</label>
                </div>
            </div>
            <div class="card-body">
                <canvas id="borrowingChart" height="200"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header bg-white">
                <h6 class="card-title mb-0">Kategori Buku Populer</h6>
            </div>
            <div class="card-body">
                <canvas id="categoryChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<style>
.btn-check:checked + .btn-outline-primary {
    background-color: #0d6efd;
    border-color: #0d6efd;
    color: white;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
let borrowingChart;
let categoryChart;
let currentReportType = '';
let currentReportFormat = '';

// Initialize charts on page load
document.addEventListener('DOMContentLoaded', function() {
    initializeBorrowingChart();
    initializeCategoryChart();

    // Add event listeners for period change
    document.querySelectorAll('input[name="borrowingPeriod"]').forEach(radio => {
        radio.addEventListener('change', function() {
            updateBorrowingChart(this.value);
        });
    });
});

function generateReport(type, format) {
    currentReportType = type;
    currentReportFormat = format;

    let params = new URLSearchParams();

    // Get the date/period based on type
    switch(type) {
        case 'daily':
            params.append('date', document.getElementById('dailyDate').value);
            break;
        case 'weekly':
            const weekValue = document.getElementById('weeklyDate').value;
            if (weekValue) {
                const [year, week] = weekValue.split('-W');
                const date = getDateOfWeek(week, year);
                params.append('week_start', date);
            }
            break;
        case 'monthly':
            params.append('month', document.getElementById('monthlyDate').value);
            break;
        case 'yearly':
            params.append('year', document.getElementById('yearlyDate').value);
            break;
    }

    if (format === 'pdf') {
        params.append('format', 'pdf');
        // For PDF, directly download
        window.open(`/dashboard/admin/reports/${type}?${params.toString()}`, '_blank');
    } else {
        // For preview, show loading modal and fetch data
        showLoadingModal();

        fetch(`/dashboard/admin/reports/${type}?${params.toString()}`)
            .then(response => response.json())
            .then(data => {
                hideLoadingModal();
                showReportPreview(type, data);
            })
            .catch(error => {
                hideLoadingModal();
                showAlert('Error', 'Gagal menggenerate laporan: ' + error.message, 'danger');
            });
    }
}

function showLoadingModal() {
    const modal = new bootstrap.Modal(document.getElementById('loadingModal'));
    modal.show();
}

function hideLoadingModal() {
    const modal = bootstrap.Modal.getInstance(document.getElementById('loadingModal'));
    if (modal) {
        modal.hide();
    }
}

function showReportPreview(type, data) {
    const modal = new bootstrap.Modal(document.getElementById('reportPreviewModal'));
    const title = document.getElementById('reportPreviewTitle');
    const content = document.getElementById('reportPreviewContent');

    title.textContent = `Preview Laporan ${type.charAt(0).toUpperCase() + type.slice(1)}`;

    // Generate preview content based on type
    let html = `
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="card bg-primary text-white">
                    <div class="card-body text-center">
                        <h4>${data.total_borrowings || 0}</h4>
                        <small>Total Peminjaman</small>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card bg-success text-white">
                    <div class="card-body text-center">
                        <h4>${data.total_returns || 0}</h4>
                        <small>Total Pengembalian</small>
                    </div>
                </div>
            </div>
        </div>
    `;

    if (type === 'monthly' && data.popular_books && data.popular_books.length > 0) {
        html += `
            <h6>Buku Paling Populer:</h6>
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Rank</th>
                            <th>Judul Buku</th>
                            <th>Total Dipinjam</th>
                        </tr>
                    </thead>
                    <tbody>
        `;

        data.popular_books.slice(0, 5).forEach((book, index) => {
            const emoji = index === 0 ? '🥇' : index === 1 ? '🥈' : index === 2 ? '🥉' : (index + 1);
            html += `
                <tr>
                    <td>${emoji}</td>
                    <td>${book.judul_buku || book.title}</td>
                    <td>${book.total_borrowed || book.count}</td>
                </tr>
            `;
        });

        html += `
                    </tbody>
                </table>
            </div>
        `;
    }

    content.innerHTML = html;

    // Update download button
    const downloadBtn = document.getElementById('downloadPdfBtn');
    downloadBtn.onclick = function() {
        generateReport(currentReportType, 'pdf');
    };

    modal.show();
}

function initializeBorrowingChart() {
    const ctx = document.getElementById('borrowingChart').getContext('2d');
    borrowingChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: 'Peminjaman',
                data: [],
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Load initial data
    updateBorrowingChart('week');
}

function initializeCategoryChart() {
    const ctx = document.getElementById('categoryChart').getContext('2d');

    // Load category data
    fetch('/dashboard/admin/reports/stats/category')
        .then(response => response.json())
        .then(data => {
            const labels = data.map(item => item.kategori);
            const values = data.map(item => item.total);

            categoryChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: values,
                        backgroundColor: [
                            '#FF6384',
                            '#36A2EB',
                            '#FFCE56',
                            '#4BC0C0',
                            '#9966FF',
                            '#FF9F40'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        })
        .catch(error => {
            console.error('Error loading category data:', error);
        });
}

function updateBorrowingChart(period) {
    fetch(`/dashboard/admin/reports/stats/borrowing?period=${period}`)
        .then(response => response.json())
        .then(data => {
            let labels, values;

            if (period === 'week') {
                labels = data.map(item => item.day);
                values = data.map(item => item.count);
            } else if (period === 'month') {
                labels = data.map(item => item.month);
                values = data.map(item => item.count);
            } else {
                labels = data.map(item => item.year.toString());
                values = data.map(item => item.count);
            }

            borrowingChart.data.labels = labels;
            borrowingChart.data.datasets[0].data = values;
            borrowingChart.update();
        })
        .catch(error => {
            console.error('Error updating borrowing chart:', error);
        });
}

function getDateOfWeek(week, year) {
    const simple = new Date(year, 0, 1 + (week - 1) * 7);
    const dow = simple.getDay();
    const ISOweekStart = simple;
    if (dow <= 4)
        ISOweekStart.setDate(simple.getDate() - simple.getDay() + 1);
    else
        ISOweekStart.setDate(simple.getDate() + 8 - simple.getDay());
    return ISOweekStart.toISOString().split('T')[0];
}

function showAlert(title, message, type) {
    // Simple alert implementation
    alert(`${title}: ${message}`);
}
</script>
@endsection
