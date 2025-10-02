@extends('layouts.dashboard')

@section('title', 'Manajemen Buku - Admin')
@section('page-title', 'Manajemen Buku')
@section('user-name', 'Administrator')
@section('user-role', 'Admin')

@section('sidebar-menu')
    <li class="nav-item">
        <a class="nav-link " href="{{ route('dashboard.admin') }}">
            <i class="bi bi-speedometer2 me-2"></i>
            Dashboard
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" href="{{ route('admin.books') }}">
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
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-book text-primary me-2"></i>
                    Manajemen Buku
                </h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <div>
                        <button class="btn btn-primary">
                            <i class="bi bi-plus-circle me-1"></i>
                            Tambah Buku Baru
                        </button>
                        <button class="btn btn-outline-success">
                            <i class="bi bi-download me-1"></i>
                            Import Buku
                        </button>
                    </div>
                    <div>
                        <input type="text" class="form-control" placeholder="Cari buku...">
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Judul</th>
                                <th>Penulis</th>
                                <th>Kategori</th>
                                <th>Stok</th>
                                <th>Tersedia</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data akan dimuat dari controller -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection