@extends('layouts.dashboard')

@section('title', 'Pengembalian Buku - Petugas')
@section('page-title', 'Pengembalian Buku')
@section('user-name', 'Petugas Perpustakaan')
@section('user-role', 'Petugas')

@section('content')
<div class="row mb-4">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header bg-white">
                <h6 class="card-title mb-0">Form Pengembalian</h6>
            </div>
            <div class="card-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">ID Pinjaman atau ID Buku</label>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Scan barcode atau masukkan ID">
                            <button class="btn btn-outline-secondary" type="button">
                                <i class="bi bi-upc-scan"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Peminjam</label>
                        <input type="text" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Judul Buku</label>
                        <input type="text" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Pinjam</label>
                        <input type="text" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Kembali Seharusnya</label>
                        <input type="text" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kondisi Buku</label>
                        <select class="form-select">
                            <option>Baik</option>
                            <option>Rusak Ringan</option>
                            <option>Rusak Berat</option>
                            <option>Hilang</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Denda (jika ada)</label>
                        <input type="number" class="form-control" placeholder="0" readonly>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle me-2"></i>
                            Proses Pengembalian
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header bg-white">
                <h6 class="card-title mb-0">Status Peminjaman</h6>
            </div>
            <div class="card-body">
                <div class="alert alert-info" role="alert">
                    <i class="bi bi-info-circle me-2"></i>
                    Scan barcode atau masukkan ID untuk melihat detail pinjaman
                </div>
                
                <div class="row">
                    <div class="col-6">
                        <small class="text-muted">Hari Terlambat</small>
                        <p class="fw-bold text-danger">-</p>
                    </div>
                    <div class="col-6">
                        <small class="text-muted">Total Denda</small>
                        <p class="fw-bold text-danger">-</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header bg-white">
                <h6 class="card-title mb-0">Riwayat Peminjaman Anggota</h6>
            </div>
            <div class="card-body">
                <div class="text-center text-muted">
                    <i class="bi bi-clock-history" style="font-size: 2rem;"></i>
                    <p class="mt-2">Pilih peminjaman untuk melihat riwayat</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white">
                <h6 class="card-title mb-0">Pengembalian Hari Ini</h6>
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
                                <th>Waktu Kembali</th>
                                <th>Kondisi</th>
                                <th>Denda</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td><span class="badge bg-secondary">#PJM003</span></td>
                                <td>Dian Sastro</td>
                                <td>1984</td>
                                <td>14:20</td>
                                <td><span class="badge bg-success">Baik</span></td>
                                <td>Rp 0</td>
                                <td><span class="badge bg-success">Selesai</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection