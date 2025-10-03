@extends('layouts.dashboard')

@section('title', 'Buku Favorit - Anggota')
@section('page-title', 'Buku Favorit')
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
        <a class="nav-link active" href="{{ route('anggota.favorites') }}">
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
        <a class="nav-link" href="{{ route('anggota.profile') }}">
            <i class="bi bi-person me-2"></i>
            Profil Saya
        </a>
    </li>
@endsection

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1">Koleksi Buku Favorit Anda</h5>
                        <p class="text-muted mb-0">Simpan buku-buku yang ingin Anda baca nanti</p>
                    </div>
                    <div>
                        <span class="badge bg-primary fs-6">5 Buku</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-start">
                    <div class="bg-primary text-white rounded me-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 80px;">
                        <i class="bi bi-book" style="font-size: 1.5rem;"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="card-title mb-2">Harry Potter dan Batu Bertuah</h6>
                        <p class="card-text small text-muted mb-2">J.K. Rowling</p>
                        <span class="badge bg-light text-dark mb-2">Fantasi</span>
                        <div class="d-flex gap-1">
                            <button class="btn btn-sm btn-primary flex-fill">
                                <i class="bi bi-plus-circle me-1"></i>
                                Pinjam
                            </button>
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-heart-fill"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-start">
                    <div class="bg-success text-white rounded me-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 80px;">
                        <i class="bi bi-book" style="font-size: 1.5rem;"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="card-title mb-2">Sapiens</h6>
                        <p class="card-text small text-muted mb-2">Yuval Noah Harari</p>
                        <span class="badge bg-light text-dark mb-2">Sejarah</span>
                        <div class="d-flex gap-1">
                            <button class="btn btn-sm btn-primary flex-fill">
                                <i class="bi bi-plus-circle me-1"></i>
                                Pinjam
                            </button>
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-heart-fill"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-start">
                    <div class="bg-warning text-white rounded me-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 80px;">
                        <i class="bi bi-book" style="font-size: 1.5rem;"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="card-title mb-2">The Psychology of Money</h6>
                        <p class="card-text small text-muted mb-2">Morgan Housel</p>
                        <span class="badge bg-light text-dark mb-2">Keuangan</span>
                        <div class="d-flex gap-1">
                            <button class="btn btn-sm btn-primary flex-fill">
                                <i class="bi bi-plus-circle me-1"></i>
                                Pinjam
                            </button>
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-heart-fill"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-start">
                    <div class="bg-info text-white rounded me-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 80px;">
                        <i class="bi bi-book" style="font-size: 1.5rem;"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="card-title mb-2">Clean Code</h6>
                        <p class="card-text small text-muted mb-2">Robert C. Martin</p>
                        <span class="badge bg-light text-dark mb-2">Programming</span>
                        <div class="d-flex gap-1">
                            <button class="btn btn-sm btn-outline-secondary flex-fill" disabled>
                                <i class="bi bi-x-circle me-1"></i>
                                Tidak Tersedia
                            </button>
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-heart-fill"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-start">
                    <div class="bg-secondary text-white rounded me-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 80px;">
                        <i class="bi bi-book" style="font-size: 1.5rem;"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="card-title mb-2">Atomic Habits</h6>
                        <p class="card-text small text-muted mb-2">James Clear</p>
                        <span class="badge bg-light text-dark mb-2">Self-Help</span>
                        <div class="d-flex gap-1">
                            <button class="btn btn-sm btn-primary flex-fill">
                                <i class="bi bi-plus-circle me-1"></i>
                                Pinjam
                            </button>
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-heart-fill"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body text-center">
                <i class="bi bi-heart text-muted mb-3" style="font-size: 3rem;"></i>
                <p class="text-muted">Jelajahi katalog untuk menambah buku favorit</p>
                <a href="#" class="btn btn-primary">
                    <i class="bi bi-search me-2"></i>
                    Jelajahi Katalog
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
