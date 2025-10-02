@extends('layouts.dashboard')

@section('title', 'Peminjaman Buku - Petugas')
@section('page-title', 'Peminjaman Buku')
@section('user-name', 'Petugas Perpustakaan')
@section('user-role', 'Petugas')

@section('content')
<div class="row mb-4">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header bg-white">
                <h6 class="card-title mb-0">Form Peminjaman Baru</h6>
            </div>
            <div class="card-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">ID Anggota</label>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Masukkan ID Anggota">
                            <button class="btn btn-outline-secondary" type="button">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Anggota</label>
                        <input type="text" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ID Buku</label>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Scan barcode atau masukkan ID">
                            <button class="btn btn-outline-secondary" type="button">
                                <i class="bi bi-upc-scan"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Judul Buku</label>
                        <input type="text" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Kembali</label>
                        <input type="date" class="form-control">
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-2"></i>
                            Proses Peminjaman
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header bg-white">
                <h6 class="card-title mb-0">Informasi Anggota</h6>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <i class="bi bi-person-circle text-muted" style="font-size: 4rem;"></i>
                </div>
                <div class="row">
                    <div class="col-6">
                        <small class="text-muted">Status Keanggotaan</small>
                        <p class="fw-bold">-</p>
                    </div>
                    <div class="col-6">
                        <small class="text-muted">Buku Dipinjam</small>
                        <p class="fw-bold">-</p>
                    </div>
                    <div class="col-6">
                        <small class="text-muted">Keterlambatan</small>
                        <p class="fw-bold">-</p>
                    </div>
                    <div class="col-6">
                        <small class="text-muted">Denda</small>
                        <p class="fw-bold">-</p>
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
                <h6 class="card-title mb-0">Peminjaman Hari Ini</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>ID Pinjaman</th>
                                <th>Nama Anggota</th>
                                <th>Judul Buku</th>
                                <th>Waktu Pinjam</th>
                                <th>Tanggal Kembali</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td><span class="badge bg-primary">#PJM001</span></td>
                                <td>Ahmad Fauzi</td>
                                <td>The Great Gatsby</td>
                                <td>09:15</td>
                                <td>09 Oct 2025</td>
                                <td><span class="badge bg-success">Berhasil</span></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td><span class="badge bg-primary">#PJM002</span></td>
                                <td>Siti Nurhaliza</td>
                                <td>To Kill a Mockingbird</td>
                                <td>10:30</td>
                                <td>09 Oct 2025</td>
                                <td><span class="badge bg-success">Berhasil</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection