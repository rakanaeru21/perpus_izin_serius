@extends('layouts.dashboard')

@section('title', 'Laporan - Admin')
@section('page-title', 'Laporan Sistem')
@section('user-name', 'Administrator')
@section('user-role', 'Admin')

@section('sidebar-menu')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('dashboard.admin') }}">
            <i class="bi bi-speedometer2 me-2"></i>
            Dashboard
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.books') }}">
            <i class="bi bi-book me-2"></i>
            Manajemen Buku
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.members') }}">
            <i class="bi bi-people me-2"></i>
            Manajemen Anggota
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="bi bi-person-badge me-2"></i>
            Manajemen Petugas
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="bi bi-arrow-left-right me-2"></i>
            Transaksi Pinjaman
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" href="{{ route('admin.reports') }}">
            <i class="bi bi-bar-chart me-2"></i>
            Laporan
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="bi bi-gear me-2"></i>
            Pengaturan Sistem
        </a>
    </li>
@endsection

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

                <!-- Laporan Komprehensif -->
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card border-2 border-warning bg-gradient" style="background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);">
                            <div class="card-body text-center">
                                <i class="bi bi-file-earmark-bar-graph text-warning mb-2" style="font-size: 3rem;"></i>
                                <h5 class="text-warning fw-bold">Laporan Komprehensif</h5>
                                <p class="text-muted mb-3">Laporan lengkap yang menampilkan peminjam terbaru, buku yang dikembalikan, buku dengan rating bagus, buku populer, dan buku yang jarang dipinjam</p>
                                <div class="d-flex justify-content-center gap-2">
                                    <button class="btn btn-outline-warning" onclick="generateReport('comprehensive', 'view')">
                                        <i class="bi bi-eye"></i> Preview Laporan
                                    </button>
                                    <button class="btn btn-warning" onclick="generateReport('comprehensive', 'pdf')">
                                        <i class="bi bi-file-pdf"></i> Download PDF
                                    </button>
                                </div>
                                <small class="text-muted d-block mt-2">
                                    <i class="bi bi-info-circle"></i> Laporan ini mencakup data terkini dan analisis mendalam untuk pengambilan keputusan strategis
                                </small>
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
        case 'comprehensive':
            // No additional parameters needed for comprehensive report
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

    let html = '';

    if (type === 'comprehensive') {
        // Special handling for comprehensive report
        html = generateComprehensivePreview(data);
    } else {
        // Generate preview content for other reports
        html = `
            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="card bg-primary text-white">
                        <div class="card-body text-center">
                            <h4>${data.total_borrowings || 0}</h4>
                            <small>Total Peminjaman</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-success text-white">
                        <div class="card-body text-center">
                            <h4>${data.total_returns || 0}</h4>
                            <small>Total Pengembalian</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-warning text-white">
                        <div class="card-body text-center">
                            <h4>${data.total_overdue || 0}</h4>
                            <small>Keterlambatan</small>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Add period information
        if (data.period) {
            html += `
                <div class="alert alert-info">
                    <strong>Periode:</strong> ${data.period}
                </div>
            `;
        } else if (data.date) {
            html += `
                <div class="alert alert-info">
                    <strong>Tanggal:</strong> ${new Date(data.date).toLocaleDateString('id-ID')}
                </div>
            `;
        }

        // Show popular books for monthly reports
        if (type === 'monthly' && data.popular_books && data.popular_books.length > 0) {
            html += `
                <h6 class="mt-4">📚 Buku Paling Populer:</h6>
                <div class="table-responsive">
                    <table class="table table-sm table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>Rank</th>
                                <th>Judul Buku</th>
                                <th>Penulis</th>
                                <th>Kategori</th>
                                <th>Total Dipinjam</th>
                            </tr>
                        </thead>
                        <tbody>
            `;

            data.popular_books.slice(0, 5).forEach((book, index) => {
                const medals = ['🥇', '🥈', '🥉'];
                const rank = index < 3 ? medals[index] : `${index + 1}.`;
                html += `
                    <tr>
                        <td>${rank}</td>
                        <td><strong>${book.judul_buku || book.title || 'N/A'}</strong></td>
                        <td>${book.penulis || 'N/A'}</td>
                        <td><span class="badge bg-secondary">${book.kategori || 'N/A'}</span></td>
                        <td><span class="badge bg-primary">${book.total_borrowed || book.count || 0}</span></td>
                    </tr>
                `;
            });

            html += `
                        </tbody>
                    </table>
                </div>
            `;
        }

        // Show recent transactions for daily reports
        if (type === 'daily' && data.borrowings && data.borrowings.length > 0) {
            html += `
                <h6 class="mt-4">📋 Peminjaman Hari Ini (${data.borrowings.length} transaksi):</h6>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Peminjam</th>
                                <th>Judul Buku</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
            `;

            data.borrowings.slice(0, 5).forEach((borrowing, index) => {
                const statusColor = borrowing.status === 'dipinjam' ? 'primary' :
                                   borrowing.status === 'dikembalikan' ? 'success' : 'warning';
                html += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${borrowing.nama_peminjam || 'N/A'}</td>
                        <td>${borrowing.judul_buku || 'N/A'}</td>
                        <td><span class="badge bg-${statusColor}">${borrowing.status}</span></td>
                    </tr>
                `;
            });

            if (data.borrowings.length > 5) {
                html += `
                    <tr>
                        <td colspan="4" class="text-center text-muted">
                            ... dan ${data.borrowings.length - 5} transaksi lainnya
                        </td>
                    </tr>
                `;
            }

            html += `
                        </tbody>
                    </table>
                </div>
            `;
        }

        // Summary for the period
        if (type !== 'daily') {
            const efficiency = data.total_borrowings > 0 ?
                ((data.total_returns / data.total_borrowings) * 100).toFixed(1) : 0;

            html += `
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6>📊 Ringkasan Kinerja:</h6>
                                <ul class="mb-0">
                                    <li>Tingkat Pengembalian: <strong>${efficiency}%</strong></li>
                                    <li>Rata-rata Peminjaman per ${type === 'weekly' ? 'hari' : type === 'monthly' ? 'minggu' : 'bulan'}:
                                        <strong>${Math.round(data.total_borrowings / (type === 'weekly' ? 7 : type === 'monthly' ? 4 : 12))}</strong>
                                    </li>
                                    ${data.total_overdue > 0 ?
                                        `<li class="text-warning">⚠️ Perhatian: ${data.total_overdue} peminjaman terlambat</li>` :
                                        '<li class="text-success">✅ Tidak ada keterlambatan</li>'
                                    }
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }
    }

    content.innerHTML = html;

    // Update download button
    const downloadBtn = document.getElementById('downloadPdfBtn');
    downloadBtn.onclick = function() {
        generateReport(currentReportType, 'pdf');
    };

    modal.show();
}

function generateComprehensivePreview(data) {
    let html = `
        <div class="alert alert-info">
            <strong>📊 Laporan Komprehensif Perpustakaan</strong><br>
            <small>${data.period || 'Data terkini'} | Generated: ${data.generated_at || new Date().toLocaleDateString('id-ID')}</small>
        </div>

        <!-- Statistics Overview -->
        <div class="row mb-4">
            <div class="col-md-2">
                <div class="card bg-primary text-white text-center">
                    <div class="card-body p-2">
                        <h6>${data.statistics?.total_members || 0}</h6>
                        <small>Anggota</small>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card bg-success text-white text-center">
                    <div class="card-body p-2">
                        <h6>${data.statistics?.total_books || 0}</h6>
                        <small>Buku</small>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card bg-warning text-white text-center">
                    <div class="card-body p-2">
                        <h6>${data.statistics?.active_borrowings || 0}</h6>
                        <small>Dipinjam</small>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card bg-danger text-white text-center">
                    <div class="card-body p-2">
                        <h6>${data.statistics?.overdue_borrowings || 0}</h6>
                        <small>Terlambat</small>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card bg-info text-white text-center">
                    <div class="card-body p-2">
                        <h6>${data.statistics?.recent_borrowings || 0}</h6>
                        <small>Pinjam 7 Hari</small>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card bg-secondary text-white text-center">
                    <div class="card-body p-2">
                        <h6>${data.statistics?.recent_returns || 0}</h6>
                        <small>Kembali 7 Hari</small>
                    </div>
                </div>
            </div>
        </div>
    `;

    // Recent Borrowers
    if (data.recent_borrowers && data.recent_borrowers.length > 0) {
        html += `
            <h6>👥 Peminjam Terbaru (${data.recent_borrowers.length})</h6>
            <div class="table-responsive mb-4">
                <table class="table table-sm table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>Peminjam</th>
                            <th>Buku</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
        `;

        data.recent_borrowers.slice(0, 3).forEach(borrower => {
            html += `
                <tr>
                    <td><strong>${borrower.nama_peminjam}</strong><br><small class="text-muted">${borrower.username}</small></td>
                    <td>${borrower.judul_buku}<br><small class="text-muted">${borrower.penulis}</small></td>
                    <td>${new Date(borrower.tanggal_pinjam).toLocaleDateString('id-ID')}</td>
                </tr>
            `;
        });

        if (data.recent_borrowers.length > 3) {
            html += `<tr><td colspan="3" class="text-center text-muted">... dan ${data.recent_borrowers.length - 3} lainnya</td></tr>`;
        }

        html += `
                    </tbody>
                </table>
            </div>
        `;
    }

    // High Rated Books
    if (data.high_rated_books && data.high_rated_books.length > 0) {
        html += `
            <h6>⭐ Buku Rating Tinggi (${data.high_rated_books.length})</h6>
            <div class="table-responsive mb-4">
                <table class="table table-sm table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>Buku</th>
                            <th>Kategori</th>
                            <th>Rating</th>
                        </tr>
                    </thead>
                    <tbody>
        `;

        data.high_rated_books.slice(0, 3).forEach(book => {
            html += `
                <tr>
                    <td><strong>${book.judul_buku}</strong><br><small class="text-muted">${book.penulis}</small></td>
                    <td><span class="badge bg-secondary">${book.kategori}</span></td>
                    <td><span class="text-warning">★${book.avg_rating}</span> (${book.total_ratings})</td>
                </tr>
            `;
        });

        if (data.high_rated_books.length > 3) {
            html += `<tr><td colspan="3" class="text-center text-muted">... dan ${data.high_rated_books.length - 3} lainnya</td></tr>`;
        }

        html += `
                    </tbody>
                </table>
            </div>
        `;
    }

    // Popular Books
    if (data.popular_books && data.popular_books.length > 0) {
        html += `
            <h6>🔥 Buku Populer (${data.popular_books.length})</h6>
            <div class="table-responsive mb-4">
                <table class="table table-sm table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>Rank</th>
                            <th>Buku</th>
                            <th>Dipinjam</th>
                        </tr>
                    </thead>
                    <tbody>
        `;

        data.popular_books.slice(0, 3).forEach((book, index) => {
            const medals = ['🥇', '🥈', '🥉'];
            const rank = index < 3 ? medals[index] : `#${index + 1}`;
            html += `
                <tr>
                    <td>${rank}</td>
                    <td><strong>${book.judul_buku}</strong><br><small class="text-muted">${book.penulis}</small></td>
                    <td><span class="badge bg-primary">${book.total_borrowed}x</span></td>
                </tr>
            `;
        });

        if (data.popular_books.length > 3) {
            html += `<tr><td colspan="3" class="text-center text-muted">... dan ${data.popular_books.length - 3} lainnya</td></tr>`;
        }

        html += `
                    </tbody>
                </table>
            </div>
        `;
    }

    // Summary
    html += `
        <div class="alert alert-light">
            <h6>💡 Ringkasan:</h6>
            <ul class="mb-0">
                <li><strong>Aktivitas 7 Hari:</strong> ${data.statistics?.recent_borrowings || 0} peminjaman, ${data.statistics?.recent_returns || 0} pengembalian</li>
                <li><strong>Buku Berkualitas:</strong> ${data.high_rated_books?.length || 0} buku dengan rating tinggi</li>
                <li><strong>Koleksi Populer:</strong> ${data.popular_books?.length || 0} buku sering dipinjam</li>
                ${data.statistics?.overdue_borrowings > 0 ?
                    `<li class="text-warning"><strong>Perhatian:</strong> ${data.statistics.overdue_borrowings} peminjaman terlambat</li>` :
                    '<li class="text-success"><strong>Status:</strong> Tidak ada keterlambatan</li>'
                }
            </ul>
        </div>
    `;

    return html;
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
                tension: 0.1,
                fill: true,
                pointBackgroundColor: 'rgb(75, 192, 192)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    backgroundColor: 'rgba(0,0,0,0.8)',
                    titleColor: 'white',
                    bodyColor: 'white',
                    borderColor: 'rgb(75, 192, 192)',
                    borderWidth: 1
                }
            },
            interaction: {
                mode: 'nearest',
                axis: 'x',
                intersect: false
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
            if (!data || data.length === 0) {
                // Show message if no data
                ctx.fillStyle = '#666';
                ctx.font = '14px Arial';
                ctx.textAlign = 'center';
                ctx.fillText('Tidak ada data kategori', ctx.canvas.width / 2, ctx.canvas.height / 2);
                return;
            }

            const labels = data.map(item => item.kategori || 'Tidak Berkategori');
            const values = data.map(item => parseInt(item.total) || 0);

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
                            '#FF9F40',
                            '#FF6384',
                            '#36A2EB'
                        ],
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 15,
                                usePointStyle: true
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.parsed || 0;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = ((value / total) * 100).toFixed(1);
                                    return `${label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
        })
        .catch(error => {
            console.error('Error loading category data:', error);
            // Show error message
            ctx.fillStyle = '#dc3545';
            ctx.font = '14px Arial';
            ctx.textAlign = 'center';
            ctx.fillText('Error loading data', ctx.canvas.width / 2, ctx.canvas.height / 2);
        });
}

function updateBorrowingChart(period) {
    fetch(`/dashboard/admin/reports/stats/borrowing?period=${period}`)
        .then(response => response.json())
        .then(data => {
            if (!data || data.length === 0) {
                // Clear chart if no data
                borrowingChart.data.labels = [];
                borrowingChart.data.datasets[0].data = [];
                borrowingChart.update();
                return;
            }

            let labels, values;

            if (period === 'week') {
                labels = data.map(item => item.day || item.date);
                values = data.map(item => parseInt(item.count) || 0);
            } else if (period === 'month') {
                labels = data.map(item => item.month);
                values = data.map(item => parseInt(item.count) || 0);
            } else {
                labels = data.map(item => item.year ? item.year.toString() : item.year);
                values = data.map(item => parseInt(item.count) || 0);
            }

            // Update chart label based on period
            let chartLabel = 'Peminjaman';
            if (period === 'week') {
                chartLabel = 'Peminjaman (7 Hari Terakhir)';
            } else if (period === 'month') {
                chartLabel = 'Peminjaman (12 Bulan Terakhir)';
            } else if (period === 'year') {
                chartLabel = 'Peminjaman (5 Tahun Terakhir)';
            }

            borrowingChart.data.labels = labels;
            borrowingChart.data.datasets[0].data = values;
            borrowingChart.data.datasets[0].label = chartLabel;
            borrowingChart.update();
        })
        .catch(error => {
            console.error('Error updating borrowing chart:', error);
            // Show error in chart
            borrowingChart.data.labels = ['Error'];
            borrowingChart.data.datasets[0].data = [0];
            borrowingChart.update();
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
