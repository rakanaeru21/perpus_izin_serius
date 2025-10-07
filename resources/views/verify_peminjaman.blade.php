@extends('layouts.dashboard')

@section('title', 'Verifikasi Data Peminjaman')
@section('page-title', 'Verifikasi Data Peminjaman')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-check-circle me-2"></i>Data Peminjaman Tersimpan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>ID Peminjaman</th>
                                    <th>Nama Anggota</th>
                                    <th>Username</th>
                                    <th>Judul Buku</th>
                                    <th>Kode Buku</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Batas Kembali</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($peminjaman as $item)
                                <tr>
                                    <td>{{ $item->id_peminjaman }}</td>
                                    <td>{{ $item->user->nama_lengkap }}</td>
                                    <td>{{ $item->user->username }}</td>
                                    <td>{{ $item->book->judul_buku }}</td>
                                    <td>{{ $item->book->kode_buku }}</td>
                                    <td>{{ $item->tanggal_pinjam->format('d/m/Y') }}</td>
                                    <td>{{ $item->batas_kembali->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $item->status_color }}">
                                            {{ $item->formatted_status }}
                                        </span>
                                    </td>
                                    <td>{{ $item->keterangan ?? '-' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center">Belum ada data peminjaman</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        <h6>Statistik:</h6>
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Total Peminjaman
                                <span class="badge bg-primary rounded-pill">{{ $peminjaman->count() }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Peminjaman Hari Ini
                                <span class="badge bg-info rounded-pill">{{ $todayCount }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Buku Tersedia (ID: 1)
                                <span class="badge bg-success rounded-pill">{{ $bookAvailable }}</span>
                            </li>
                        </ul>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('petugas.borrow') }}" class="btn btn-primary">
                            <i class="bi bi-arrow-left me-2"></i>Kembali ke Form Peminjaman
                        </a>
                        <a href="/test-peminjaman" class="btn btn-success ms-2" target="_blank">
                            <i class="bi bi-plus-circle me-2"></i>Test Peminjaman Lagi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
