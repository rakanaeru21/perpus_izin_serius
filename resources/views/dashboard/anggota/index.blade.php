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
        <a class="nav-link" href="{{ route('anggota.catalog') }}">
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
        <a class="nav-link" href="{{ route('anggota.loan-history') }}">
            <i class="bi bi-clock-history me-2"></i>
            Riwayat Pinjaman
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('anggota.profile') }}">
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
                            <h2 class="mb-2">Selamat Datang, {{ auth()->user()->nama_lengkap }}!</h2>
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
                            <h2 class="mb-0">0</h2>
                        </div>
                        <div class="text-white-50">
                            <i class="bi bi-heart-fill" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Buku Terpopuler -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-star-fill text-warning me-2"></i>
                        Buku Terpopuler
                    </h5>
                    <a href="{{ route('anggota.catalog') }}" class="btn btn-outline-primary btn-sm">
                        Lihat Semua
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($bukuTerpopuler as $buku)
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                            <div class="card h-100 shadow-sm book-card">
                                <div class="position-relative">
                                    <img src="{{ $buku->cover_url }}"
                                         class="card-img-top book-cover"
                                         alt="{{ $buku->judul_buku }}"
                                         style="height: 200px; object-fit: cover;">
                                    @if($buku->avg_rating > 0)
                                    <div class="position-absolute top-0 end-0 m-2">
                                        <span class="badge bg-warning text-dark">
                                            <i class="bi bi-star-fill"></i> {{ $buku->avg_rating }}
                                        </span>
                                    </div>
                                    @endif
                                    @if($buku->jumlah_tersedia == 0)
                                    <div class="position-absolute top-0 start-0 m-2">
                                        <span class="badge bg-danger">Tidak Tersedia</span>
                                    </div>
                                    @endif
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <h6 class="card-title text-truncate" title="{{ $buku->judul_buku }}">
                                        {{ $buku->judul_buku }}
                                    </h6>
                                    <p class="card-text text-muted small mb-1">
                                        <i class="bi bi-person"></i> {{ $buku->penulis }}
                                    </p>
                                    <p class="card-text text-muted small mb-2">
                                        <i class="bi bi-tag"></i> {{ $buku->kategori }} • {{ $buku->tahun_terbit }}
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center mt-auto">
                                        <small class="text-muted">
                                            <i class="bi bi-book"></i> {{ $buku->jumlah_tersedia }} tersedia
                                        </small>
                                        @if($buku->total_ratings > 0)
                                        <small class="text-muted">
                                            {{ $buku->total_ratings }} rating
                                        </small>
                                        @endif
                                    </div>
                                    <button class="btn btn-primary btn-sm mt-2 {{ $buku->jumlah_tersedia == 0 ? 'disabled' : '' }}">
                                        <i class="bi bi-book"></i> {{ $buku->jumlah_tersedia > 0 ? 'Pinjam' : 'Tidak Tersedia' }}
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Buku Berdasarkan Kategori -->
    @foreach($bukuByKategori as $kategori => $books)
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-bookmark me-2"></i>
                        Kategori: {{ $kategori }}
                    </h5>
                    <a href="{{ route('anggota.catalog') }}?kategori={{ urlencode($kategori) }}" class="btn btn-outline-primary btn-sm">
                        Lihat Semua
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($books as $buku)
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                            <div class="card h-100 shadow-sm book-card">
                                <div class="position-relative">
                                    <img src="{{ $buku->cover_url }}"
                                         class="card-img-top book-cover"
                                         alt="{{ $buku->judul_buku }}"
                                         style="height: 180px; object-fit: cover;">
                                    @if($buku->avg_rating > 0)
                                    <div class="position-absolute top-0 end-0 m-2">
                                        <span class="badge bg-warning text-dark">
                                            <i class="bi bi-star-fill"></i> {{ $buku->avg_rating }}
                                        </span>
                                    </div>
                                    @endif
                                    @if($buku->jumlah_tersedia == 0)
                                    <div class="position-absolute top-0 start-0 m-2">
                                        <span class="badge bg-danger">Tidak Tersedia</span>
                                    </div>
                                    @endif
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <h6 class="card-title text-truncate" title="{{ $buku->judul_buku }}">
                                        {{ $buku->judul_buku }}
                                    </h6>
                                    <p class="card-text text-muted small mb-1">
                                        <i class="bi bi-person"></i> {{ $buku->penulis }}
                                    </p>
                                    <p class="card-text text-muted small mb-2">
                                        <i class="bi bi-calendar"></i> {{ $buku->tahun_terbit }}
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center mt-auto">
                                        <small class="text-muted">
                                            <i class="bi bi-book"></i> {{ $buku->jumlah_tersedia }} tersedia
                                        </small>
                                        @if($buku->total_ratings > 0)
                                        <small class="text-muted">
                                            {{ $buku->total_ratings }} rating
                                        </small>
                                        @endif
                                    </div>
                                    <button class="btn btn-primary btn-sm mt-2 {{ $buku->jumlah_tersedia == 0 ? 'disabled' : '' }}">
                                        <i class="bi bi-book"></i> {{ $buku->jumlah_tersedia > 0 ? 'Pinjam' : 'Tidak Tersedia' }}
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach

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
                        <!-- Data akan ditampilkan dari database nanti -->
                        <div class="alert alert-info" role="alert">
                            <i class="bi bi-info-circle me-2"></i>
                            Anda memiliki {{ $bukuDipinjam }} buku yang sedang dipinjam.
                            <a href="{{ route('anggota.loans') }}" class="alert-link">Lihat detail pinjaman</a>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-book text-muted mb-3" style="font-size: 3rem;"></i>
                            <p class="text-muted">Anda belum meminjam buku apapun.</p>
                            <a href="{{ route('anggota.catalog') }}" class="btn btn-primary">Jelajahi Katalog</a>
                        </div>
                    @endif
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

@push('styles')
<style>
    .book-card {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        border: none;
        border-radius: 10px;
    }

    .book-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
    }

    .book-cover {
        border-radius: 10px 10px 0 0;
        transition: transform 0.3s ease;
    }

    .book-card:hover .book-cover {
        transform: scale(1.02);
    }

    .card-title {
        font-weight: 600;
        color: #2c3e50;
        line-height: 1.3;
    }

    .badge {
        font-size: 0.75rem;
        border-radius: 20px;
    }

    .btn-primary {
        border-radius: 20px;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0,123,255,0.3);
    }

    .stat-card.primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 15px;
    }

    .stat-card.success {
        background: linear-gradient(135deg, #56ab2f 0%, #a8e6cf 100%);
        color: white;
        border: none;
        border-radius: 15px;
    }

    .stat-card.warning {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
        border: none;
        border-radius: 15px;
    }

    .stat-card.info {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
        border: none;
        border-radius: 15px;
    }

    .card-header {
        border-bottom: 1px solid rgba(0,0,0,0.125);
        background: linear-gradient(90deg, #f8f9fa 0%, #ffffff 100%) !important;
    }

    .text-truncate {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    @media (max-width: 768px) {
        .book-card {
            margin-bottom: 1rem;
        }

        .col-sm-6 {
            margin-bottom: 1rem;
        }
    }
</style>
@endpush
