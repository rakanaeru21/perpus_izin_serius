@extends('layouts.dashboard')

@section('title', 'Cari Buku - Anggota')
@section('page-title', 'Pencarian Buku')
@section('user-name', 'Anggota Perpustakaan')
@section('user-role', 'Anggota')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <input type="text" class="form-control form-control-lg" placeholder="Cari judul buku, penulis, atau kategori...">
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-primary btn-lg w-100">
                            <i class="bi bi-search me-2"></i>
                            Cari Buku
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white">
                <h6 class="card-title mb-0">Filter Pencarian</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <select class="form-select">
                            <option>Semua Kategori</option>
                            <option>Fiksi</option>
                            <option>Non-Fiksi</option>
                            <option>Sains</option>
                            <option>Teknologi</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select">
                            <option>Semua Penulis</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select">
                            <option>Tahun Terbit</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select">
                            <option>Tersedia</option>
                            <option>Semua Buku</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row" id="searchResults">
    <!-- Hasil pencarian akan muncul di sini -->
    <div class="col-12">
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="bi bi-search text-muted mb-3" style="font-size: 3rem;"></i>
                <p class="text-muted">Masukkan kata kunci untuk mencari buku</p>
            </div>
        </div>
    </div>
</div>
@endsection