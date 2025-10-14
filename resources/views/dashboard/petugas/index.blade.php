@extends('layouts.dashboard')

@section('title', 'Dashboard Petugas')
@section('page-title', 'Dashboard Petugas')
@section('user-name', 'Petugas Perpustakaan')
@section('user-role', 'Petugas')

@section('sidebar-menu')
    <li class="nav-item">
        <a class="nav-link active" href="{{ route('dashboard.petugas') }}">
            <i class="bi bi-speedometer2 me-2"></i>
            Dashboard
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="bi bi-book me-2"></i>
            Katalog Buku
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('petugas.borrow') }}">
            <i class="bi bi-arrow-up-circle me-2"></i>
            Peminjaman Buku
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('petugas.return') }}">
            <i class="bi bi-arrow-down-circle me-2"></i>
            Pengembalian Buku
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('petugas.anggota') }}">
            <i class="bi bi-people me-2"></i>
            Data Anggota
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="bi bi-exclamation-triangle me-2"></i>
            Keterlambatan
        </a>
    </li>
@endsection

@section('content')
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card stat-card primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-white-50 mb-2">Total Buku</h6>
                            <h2 class="mb-0">{{ number_format($totalBuku) }}</h2>
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
                            <h6 class="card-title text-white-50 mb-2">Sedang Dipinjam</h6>
                            <h2 class="mb-0">{{ number_format($bukuDipinjam) }}</h2>
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
                            <h6 class="card-title text-white-50 mb-2">Pinjaman Hari Ini</h6>
                            <h2 class="mb-0">{{ number_format($peminjamanHariIni) }}</h2>
                        </div>
                        <div class="text-white-50">
                            <i class="bi bi-calendar-check-fill" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card stat-card">
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
    </div>


    <!-- Peminjaman Terbaru -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-list-ul text-primary me-2"></i>
                        Peminjaman Terbaru
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>ID Pinjaman</th>
                                    <th>Nama Peminjam</th>
                                    <th>Judul Buku</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Tanggal Kembali</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span class="badge bg-primary">#PJM001</span></td>
                                    <td>Ahmad Fauzi</td>
                                    <td>Harry Potter and the Sorcerer's Stone</td>
                                    <td>01 Oct 2025</td>
                                    <td>08 Oct 2025</td>
                                    <td><span class="badge bg-warning">Dipinjam</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-success">
                                            <i class="bi bi-check2"></i> Kembalikan
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><span class="badge bg-primary">#PJM002</span></td>
                                    <td>Siti Nurhaliza</td>
                                    <td>The Great Gatsby</td>
                                    <td>02 Oct 2025</td>
                                    <td>09 Oct 2025</td>
                                    <td><span class="badge bg-warning">Dipinjam</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-success">
                                            <i class="bi bi-check2"></i> Kembalikan
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><span class="badge bg-primary">#PJM003</span></td>
                                    <td>Budi Santoso</td>
                                    <td>1984</td>
                                    <td>28 Sep 2025</td>
                                    <td>05 Oct 2025</td>
                                    <td><span class="badge bg-danger">Terlambat</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-success">
                                            <i class="bi bi-check2"></i> Kembalikan
                                        </button>
                                        <button class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-envelope"></i> Ingatkan
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><span class="badge bg-secondary">#PJM004</span></td>
                                    <td>Dian Sastro</td>
                                    <td>To Kill a Mockingbird</td>
                                    <td>30 Sep 2025</td>
                                    <td>01 Oct 2025</td>
                                    <td><span class="badge bg-success">Dikembalikan</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-eye"></i> Detail
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

@push('scripts')
<script>
    // Auto refresh untuk update data real-time
    // setInterval(function() {
    //     location.reload();
    // }, 300000); // Refresh setiap 5 menit
</script>
@endpush
