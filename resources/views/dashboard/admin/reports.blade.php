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
                                <button class="btn btn-outline-primary btn-sm">Generate</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card border-0 bg-light">
                            <div class="card-body text-center">
                                <i class="bi bi-calendar-week text-success mb-2" style="font-size: 2rem;"></i>
                                <h6>Laporan Mingguan</h6>
                                <button class="btn btn-outline-success btn-sm">Generate</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card border-0 bg-light">
                            <div class="card-body text-center">
                                <i class="bi bi-calendar-month text-warning mb-2" style="font-size: 2rem;"></i>
                                <h6>Laporan Bulanan</h6>
                                <button class="btn btn-outline-warning btn-sm">Generate</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card border-0 bg-light">
                            <div class="card-body text-center">
                                <i class="bi bi-calendar4 text-info mb-2" style="font-size: 2rem;"></i>
                                <h6>Laporan Tahunan</h6>
                                <button class="btn btn-outline-info btn-sm">Generate</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header bg-white">
                <h6 class="card-title mb-0">Statistik Peminjaman</h6>
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
@endsection