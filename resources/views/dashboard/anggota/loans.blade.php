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
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stat-card primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-white-50 mb-2">Sedang Dipinjam</h6>
                        <h2 class="mb-0">{{ $statistics['sedangDipinjam'] }}</h2>
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
                        <h2 class="mb-0">{{ $statistics['jatuhTempo'] }}</h2>
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
                        <h2 class="mb-0">{{ $statistics['dikembalikan'] }}</h2>
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
                        <h2 class="mb-0">{{ $statistics['terlambat'] }}</h2>
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
                @if($activeBorrowings->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Judul Buku</th>
                                    <th>Penulis</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Batas Kembali</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($activeBorrowings as $borrowing)
                                    <tr>
                                        <td>{{ $borrowing->book->judul_buku }}</td>
                                        <td>{{ $borrowing->book->penulis }}</td>
                                        <td>{{ \Carbon\Carbon::parse($borrowing->tanggal_pinjam)->format('d M Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($borrowing->batas_kembali)->format('d M Y') }}</td>
                                        <td>
                                            @if($borrowing->status === 'terlambat')
                                                <span class="badge bg-danger">Terlambat</span>
                                            @elseif(\Carbon\Carbon::parse($borrowing->batas_kembali)->diffInDays(\Carbon\Carbon::now(), false) >= 0)
                                                <span class="badge bg-warning">Jatuh Tempo</span>
                                            @else
                                                <span class="badge bg-primary">Dipinjam</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($borrowing->status !== 'terlambat')
                                                <button class="btn btn-sm btn-outline-success extend-loan"
                                                        data-id="{{ $borrowing->id_peminjaman }}">
                                                    <i class="bi bi-arrow-clockwise"></i> Perpanjang
                                                </button>
                                            @else
                                                <span class="text-muted">Tidak dapat diperpanjang</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-book text-muted" style="font-size: 3rem;"></i>
                        <h5 class="text-muted mt-3">Tidak ada buku yang sedang dipinjam</h5>
                        <p class="text-muted">Silakan kunjungi katalog untuk meminjam buku</p>
                        <a href="{{ route('anggota.catalog') }}" class="btn btn-primary">
                            <i class="bi bi-book me-2"></i>Lihat Katalog
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@if($activeBorrowings->count() > 0)
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle loan extension
    document.querySelectorAll('.extend-loan').forEach(button => {
        button.addEventListener('click', function() {
            const loanId = this.dataset.id;
            const button = this;

            if (confirm('Apakah Anda yakin ingin memperpanjang pinjaman ini selama 7 hari?')) {
                button.disabled = true;
                button.innerHTML = '<i class="bi bi-hourglass-split"></i> Memproses...';

                fetch('{{ route("anggota.loans.extend") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        id_peminjaman: loanId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert(data.message);
                        button.disabled = false;
                        button.innerHTML = '<i class="bi bi-arrow-clockwise"></i> Perpanjang';
                    }
                })
                .catch(error => {
                    alert('Terjadi kesalahan saat memproses permintaan');
                    button.disabled = false;
                    button.innerHTML = '<i class="bi bi-arrow-clockwise"></i> Perpanjang';
                });
            }
        });
    });
});
</script>
@endif
@endsection
