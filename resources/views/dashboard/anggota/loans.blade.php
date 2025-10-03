@extends('layouts.dashboard')

@section('title', 'Pinjaman Saya - Anggota')
@section('page-title', 'Pinjaman Saya')
@section('user-name', 'Anggota Perpustakaan')
@section('user-role', 'Anggota')

@section('sidebar-menu')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('dashboard.anggota') }}">
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
        <a class="nav-link active" href="{{ route('anggota.loans') }}">
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
        <a class="nav-link" href="{{ route('anggota.profile') }}">
            <i class="bi bi-person me-2"></i>
            Profil Saya
        </a>
    </li>
@endsection

@section('content')
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stat-card primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-white-50 mb-2">Sedang Dipinjam</h6>
                        <h2 class="mb-0">3</h2>
                    </div>
                    <div class="text-white-50">
                        <i class="bi bi-book-fill" style="font-size: 2rem;"></i>
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
                        <h6 class="card-title text-white-50 mb-2">Jatuh Tempo</h6>
                        <h2 class="mb-0">1</h2>
                    </div>
                    <div class="text-white-50">
                        <i class="bi bi-clock-fill" style="font-size: 2rem;"></i>
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
                        <h6 class="card-title text-white-50 mb-2">Dikembalikan</h6>
                        <h2 class="mb-0">15</h2>
                    </div>
                    <div class="text-white-50">
                        <i class="bi bi-check-circle-fill" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-white-50 mb-2">Terlambat</h6>
                        <h2 class="mb-0">0</h2>
                    </div>
                    <div class="text-white-50">
                        <i class="bi bi-exclamation-triangle-fill" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-book text-primary me-2"></i>
                    Buku Sedang Dipinjam
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Judul Buku</th>
                                <th>Penulis</th>
                                <th>Tanggal Pinjam</th>
                                <th>Tanggal Kembali</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>The Great Gatsby</td>
                                <td>F. Scott Fitzgerald</td>
                                <td>20 Sep 2025</td>
                                <td>27 Sep 2025</td>
                                <td><span class="badge bg-warning">Jatuh Tempo</span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-success">
                                        <i class="bi bi-arrow-clockwise"></i> Perpanjang
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>To Kill a Mockingbird</td>
                                <td>Harper Lee</td>
                                <td>25 Sep 2025</td>
                                <td>02 Oct 2025</td>
                                <td><span class="badge bg-primary">Dipinjam</span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-success">
                                        <i class="bi bi-arrow-clockwise"></i> Perpanjang
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>1984</td>
                                <td>George Orwell</td>
                                <td>28 Sep 2025</td>
                                <td>05 Oct 2025</td>
                                <td><span class="badge bg-primary">Dipinjam</span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-success">
                                        <i class="bi bi-arrow-clockwise"></i> Perpanjang
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
