@extends('layouts.dashboard')

@section('title', 'Dashboard Anggota')
@section('page-title', 'Dashboard Anggota')
@section('user-name', 'Anggota Perpustakaan')
@section('user-role', 'Anggota')

@section('sidebar-menu')
    <li class="nav-item">
        <a class="nav-link active" href="{{ route('dashboard.anggota') }}">
            <i class="bi bi-speedometer2 me-2"></i>
            Dashboard
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('anggota.search') }}">
            <i class="bi bi-search me-2"></i>
            Cari Buku
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="bi bi-book me-2"></i>
            Katalog Buku
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('anggota.favorites') }}">
            <i class="bi bi-bookmark-heart me-2"></i>
            Buku Favorit
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('anggota.loans') }}">
            <i class="bi bi-arrow-repeat me-2"></i>
            Pinjaman Saya
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="bi bi-clock-history me-2"></i>
            Riwayat Pinjaman
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="bi bi-person me-2"></i>
            Profil Saya
        </a>
    </li>
@endsection

@section('content')
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <div class="card-body py-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="mb-2">Selamat Datang di Perpustakaan Digital!</h2>
                            <p class="mb-0 opacity-75">Jelajahi koleksi buku terlengkap dan nikmati kemudahan meminjam buku secara digital.</p>
                        </div>
                        <div class="col-md-4 text-center">
                            <i class="bi bi-book-half" style="font-size: 4rem; opacity: 0.7;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stat-card primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-white-50 mb-2">Sedang Dipinjam</h6>
                            <h2 class="mb-0">{{ number_format($bukuDipinjam) }}</h2>
                        </div>
                        <div class="text-white-50">
                            <i class="bi bi-book-fill" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stat-card success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-white-50 mb-2">Total Pinjaman</h6>
                            <h2 class="mb-0">{{ count($riwayatPinjaman) }}</h2>
                        </div>
                        <div class="text-white-50">
                            <i class="bi bi-journal-check" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stat-card warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-white-50 mb-2">Keterlambatan</h6>
                            <h2 class="mb-0">{{ number_format($keterlambatan) }}</h2>
                        </div>
                        <div class="text-white-50">
                            <i class="bi bi-exclamation-triangle-fill" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stat-card info">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-white-50 mb-2">Buku Favorit</h6>
                            <h2 class="mb-0">5</h2>
                        </div>
                        <div class="text-white-50">
                            <i class="bi bi-heart-fill" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Buku Sedang Dipinjam -->
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-book text-primary me-2"></i>
                        Buku Sedang Dipinjam
                    </h5>
                </div>
                <div class="card-body">
                    @if($bukuDipinjam > 0)
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="card border-0 bg-light">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-3">
                                                <div class="bg-primary text-white rounded d-flex align-items-center justify-content-center" style="height: 80px;">
                                                    <i class="bi bi-book" style="font-size: 2rem;"></i>
                                                </div>
                                            </div>
                                            <div class="col-9">
                                                <h6 class="card-title">The Great Gatsby</h6>
                                                <p class="card-text small text-muted">F. Scott Fitzgerald</p>
                                                <div class="d-flex justify-content-between">
                                                    <small class="text-muted">Dipinjam: 20 Sep 2025</small>
                                                    <small class="text-warning">Kembali: 27 Sep 2025</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card border-0 bg-light">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-3">
                                                <div class="bg-success text-white rounded d-flex align-items-center justify-content-center" style="height: 80px;">
                                                    <i class="bi bi-book" style="font-size: 2rem;"></i>
                                                </div>
                                            </div>
                                            <div class="col-9">
                                                <h6 class="card-title">To Kill a Mockingbird</h6>
                                                <p class="card-text small text-muted">Harper Lee</p>
                                                <div class="d-flex justify-content-between">
                                                    <small class="text-muted">Dipinjam: 25 Sep 2025</small>
                                                    <small class="text-success">Kembali: 02 Oct 2025</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-book text-muted mb-3" style="font-size: 3rem;"></i>
                            <p class="text-muted">Anda belum meminjam buku apapun.</p>
                            <a href="#" class="btn btn-primary">Jelajahi Katalog</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-lg-4 mb-4">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-lightning text-primary me-2"></i>
                        Aksi Cepat
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-3">
                        <a href="#" class="btn btn-primary d-flex align-items-center">
                            <i class="bi bi-search me-2"></i>
                            Cari Buku
                        </a>
                        <a href="#" class="btn btn-outline-primary d-flex align-items-center">
                            <i class="bi bi-book me-2"></i>
                            Lihat Katalog
                        </a>
                        <a href="#" class="btn btn-outline-success d-flex align-items-center">
                            <i class="bi bi-clock-history me-2"></i>
                            Riwayat Pinjaman
                        </a>
                        <a href="#" class="btn btn-outline-info d-flex align-items-center">
                            <i class="bi bi-bookmark-heart me-2"></i>
                            Buku Favorit
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rekomendasi Buku -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-stars text-primary me-2"></i>
                        Rekomendasi Buku Untuk Anda
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($rekomendasiBuku as $buku)
                        <div class="col-lg-4 col-md-6 mb-3">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-gradient text-white rounded me-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 80px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                            <i class="bi bi-book" style="font-size: 1.5rem;"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="card-title mb-2">{{ $buku['judul'] }}</h6>
                                            <p class="card-text small text-muted mb-2">{{ $buku['penulis'] }}</p>
                                            <span class="badge bg-light text-dark">{{ $buku['kategori'] }}</span>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <button class="btn btn-sm btn-primary w-100">
                                            <i class="bi bi-plus-circle me-1"></i>
                                            Pinjam Buku
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Riwayat Pinjaman Terbaru -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-clock-history text-primary me-2"></i>
                        Riwayat Pinjaman Terbaru
                    </h5>
                </div>
                <div class="card-body">
                    @if(count($riwayatPinjaman) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Judul Buku</th>
                                        <th>Tanggal Pinjam</th>
                                        <th>Tanggal Kembali</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($riwayatPinjaman as $pinjaman)
                                    <tr>
                                        <td>{{ $pinjaman['judul'] }}</td>
                                        <td>{{ date('d M Y', strtotime($pinjaman['tanggal_pinjam'])) }}</td>
                                        <td>
                                            @if($pinjaman['tanggal_kembali'])
                                                {{ date('d M Y', strtotime($pinjaman['tanggal_kembali'])) }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($pinjaman['status'] == 'Dikembalikan')
                                                <span class="badge bg-success">{{ $pinjaman['status'] }}</span>
                                            @else
                                                <span class="badge bg-warning">{{ $pinjaman['status'] }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center mt-3">
                            <a href="#" class="btn btn-outline-primary">Lihat Semua Riwayat</a>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-journal-x text-muted mb-3" style="font-size: 3rem;"></i>
                            <p class="text-muted">Belum ada riwayat peminjaman.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Notification untuk buku yang akan jatuh tempo
    document.addEventListener('DOMContentLoaded', function() {
        // Simulasi notifikasi reminder
        // setTimeout(function() {
        //     if (confirm('Anda memiliki buku yang akan jatuh tempo dalam 2 hari. Apakah Anda ingin memperpanjang?')) {
        //         // Redirect ke halaman perpanjangan
        //     }
        // }, 5000);
    });
</script>
@endpush