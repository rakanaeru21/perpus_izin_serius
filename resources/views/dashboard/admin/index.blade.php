@extends('layouts.dashboard')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin')
@section('user-name', 'Administrator')
@section('user-role', 'Admin')

@section('sidebar-menu')
    <li class="nav-item">
        <a class="nav-link active" href="{{ route('dashboard.admin') }}">
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
        <a class="nav-link" href="{{ route('admin.reports') }}">
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
    <!-- Database Information Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card stat-card primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-white-50 mb-2">Total Buku</h6>
                            <h2 class="mb-0">{{ number_format($totalBuku ?? 0) }}</h2>
                            <small class="text-white-50">Dari tabel: buku</small>
                        </div>
                        <div class="text-white-50">
                            <i class="bi bi-book-fill" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card stat-card warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-white-50 mb-2">Buku Dipinjam</h6>
                            <h2 class="mb-0">{{ number_format($bukuDipinjam ?? 0) }}</h2>
                            <small class="text-white-50">Status: dipinjam</small>
                        </div>
                        <div class="text-white-50">
                            <i class="bi bi-arrow-up-circle-fill" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card stat-card success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-white-50 mb-2">Total Anggota</h6>
                            <h2 class="mb-0">{{ number_format($totalAnggota ?? 0) }}</h2>
                            <small class="text-white-50">Role: anggota</small>
                        </div>
                        <div class="text-white-50">
                            <i class="bi bi-people-fill" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card stat-card danger">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-white-50 mb-2">Keterlambatan</h6>
                            <h2 class="mb-0">{{ number_format($keterlambatan ?? 0) }}</h2>
                            <small class="text-white-50">Lewat batas kembali</small>
                        </div>
                        <div class="text-white-50">
                            <i class="bi bi-exclamation-triangle-fill" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Database Statistics -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card stat-card info">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-white-50 mb-2">Total Petugas</h6>
                            <h2 class="mb-0">{{ number_format($totalPetugas ?? 0) }}</h2>
                            <small class="text-white-50">Role: petugas</small>
                        </div>
                        <div class="text-white-50">
                            <i class="bi bi-person-badge-fill" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card stat-card secondary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-white-50 mb-2">Total Admin</h6>
                            <h2 class="mb-0">{{ number_format($totalAdmin ?? 0) }}</h2>
                            <small class="text-white-50">Role: admin</small>
                        </div>
                        <div class="text-white-50">
                            <i class="bi bi-shield-fill" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card stat-card dark">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-white-50 mb-2">Buku Tersedia</h6>
                            <h2 class="mb-0">{{ number_format($bukuTersedia ?? 0) }}</h2>
                            <small class="text-white-50">Jumlah tersedia</small>
                        </div>
                        <div class="text-white-50">
                            <i class="bi bi-check-circle-fill" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card stat-card light">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-dark mb-2">Total Peminjaman</h6>
                            <h2 class="mb-0 text-dark">{{ number_format($totalPeminjaman ?? 0) }}</h2>
                            <small class="text-muted">Dari tabel: peminjaman</small>
                        </div>
                        <div class="text-muted">
                            <i class="bi bi-journal-text" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Database Structure Information -->
        <div class="col-lg-4 mb-4">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-database text-primary me-2"></i>
                        Struktur Database
                    </h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                            <div>
                                <i class="bi bi-table text-info me-2"></i>
                                <strong>user</strong>
                                <br><small class="text-muted">Tabel pengguna (admin, petugas, anggota)</small>
                            </div>
                            <span class="badge bg-info rounded-pill">ID: id_user</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                            <div>
                                <i class="bi bi-table text-success me-2"></i>
                                <strong>buku</strong>
                                <br><small class="text-muted">Koleksi buku perpustakaan</small>
                            </div>
                            <span class="badge bg-success rounded-pill">ID: id_buku</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                            <div>
                                <i class="bi bi-table text-warning me-2"></i>
                                <strong>peminjaman</strong>
                                <br><small class="text-muted">Transaksi pinjam-kembali</small>
                            </div>
                            <span class="badge bg-warning rounded-pill">ID: id_peminjaman</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-graph-up text-primary me-2"></i>
                        Statistik Peminjaman Bulanan
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="monthlyChart" height="100"></canvas>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="col-lg-4 mb-4">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-clock-history text-primary me-2"></i>
                        Aktivitas Terbaru
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @foreach($recentActivities as $activity)
                        <div class="list-group-item border-0">
                            <div class="d-flex align-items-start">
                                <div class="me-3">
                                    @if($activity['type'] == 'return')
                                        <div class="rounded-circle bg-success d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                            <i class="bi bi-arrow-down text-white small"></i>
                                        </div>
                                    @elseif($activity['type'] == 'borrow')
                                        <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                            <i class="bi bi-arrow-up text-white small"></i>
                                        </div>
                                    @elseif($activity['type'] == 'member')
                                        <div class="rounded-circle bg-info d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                            <i class="bi bi-person-plus text-white small"></i>
                                        </div>
                                    @elseif($activity['type'] == 'book')
                                        <div class="rounded-circle bg-success d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                            <i class="bi bi-book-fill text-white small"></i>
                                        </div>
                                    @else
                                        <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                            <i class="bi bi-exclamation text-white small"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 small">{{ $activity['message'] }}</h6>
                                    <p class="mb-1 text-muted small">{{ $activity['description'] }}</p>
                                    <small class="text-muted">{{ $activity['time'] }}</small>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-lightning text-primary me-2"></i>
                        Aksi Cepat
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="#" class="btn btn-outline-primary d-block py-3">
                                <i class="bi bi-plus-circle-fill mb-2" style="font-size: 1.5rem;"></i><br>
                                Tambah Buku Baru
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="#" class="btn btn-outline-success d-block py-3">
                                <i class="bi bi-person-plus-fill mb-2" style="font-size: 1.5rem;"></i><br>
                                Daftar Anggota Baru
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="#" class="btn btn-outline-info d-block py-3">
                                <i class="bi bi-arrow-left-right mb-2" style="font-size: 1.5rem;"></i><br>
                                Proses Pinjaman
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="#" class="btn btn-outline-warning d-block py-3">
                                <i class="bi bi-file-earmark-text-fill mb-2" style="font-size: 1.5rem;"></i><br>
                                Lihat Laporan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Monthly Chart
    const ctx = document.getElementById('monthlyChart').getContext('2d');
    const monthlyChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Peminjaman',
                data: [65, 59, 80, 81, 56, 55, 70, 85, 90, 75, 82, 88],
                borderColor: '#667eea',
                backgroundColor: 'rgba(102, 126, 234, 0.1)',
                tension: 0.4,
                fill: true
            }, {
                label: 'Pengembalian',
                data: [60, 55, 75, 79, 52, 50, 65, 80, 85, 70, 78, 85],
                borderColor: '#56ab2f',
                backgroundColor: 'rgba(86, 171, 47, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endpush