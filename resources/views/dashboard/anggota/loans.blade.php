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

                                            @if($borrowing->extension_status !== 'none')
                                                <br><small class="badge bg-{{ $borrowing->extension_status_color }} mt-1">
                                                    {{ $borrowing->formatted_extension_status }}
                                                </small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($borrowing->canRequestExtension())
                                                <button class="btn btn-sm btn-outline-success extend-loan"
                                                        data-id="{{ $borrowing->id_peminjaman }}">
                                                    <i class="bi bi-arrow-clockwise"></i> Perpanjang
                                                </button>
                                            @elseif($borrowing->extension_status === 'requested')
                                                <span class="text-warning">
                                                    <i class="bi bi-clock"></i> Menunggu persetujuan
                                                </span>
                                            @elseif($borrowing->extension_status === 'approved')
                                                <span class="text-success">
                                                    <i class="bi bi-check-circle"></i> Diperpanjang
                                                </span>
                                            @elseif($borrowing->extension_status === 'rejected')
                                                <span class="text-danger">
                                                    <i class="bi bi-x-circle"></i> Ditolak
                                                </span>
                                                @if($borrowing->rejection_reason)
                                                    <br><small class="text-muted">{{ $borrowing->rejection_reason }}</small>
                                                @endif
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
<!-- Extension Request Modal -->
<div class="modal fade" id="extensionModal" tabindex="-1" aria-labelledby="extensionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="extensionModalLabel">Permintaan Perpanjangan Pinjaman</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="extensionForm">
                    <div class="mb-3">
                        <label for="extensionReason" class="form-label">Alasan Perpanjangan (Opsional)</label>
                        <textarea class="form-control" id="extensionReason" name="reason" rows="3"
                                  placeholder="Tuliskan alasan Anda ingin memperpanjang pinjaman buku ini..."></textarea>
                    </div>
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i>
                        Permintaan perpanjangan akan dikirim ke petugas untuk disetujui. Anda akan mendapat notifikasi setelah permintaan diproses.
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="submitExtension">Kirim Permintaan</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentLoanId = null;
    const modal = new bootstrap.Modal(document.getElementById('extensionModal'));

    // Handle loan extension
    document.querySelectorAll('.extend-loan').forEach(button => {
        button.addEventListener('click', function() {
            currentLoanId = this.dataset.id;
            modal.show();
        });
    });

    // Handle extension form submission
    document.getElementById('submitExtension').addEventListener('click', function() {
        if (!currentLoanId) return;

        const reason = document.getElementById('extensionReason').value;
        const submitButton = this;

        submitButton.disabled = true;
        submitButton.innerHTML = '<i class="bi bi-hourglass-split"></i> Mengirim...';

        fetch('{{ route("anggota.loans.extend") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                id_peminjaman: currentLoanId,
                reason: reason
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                modal.hide();
                location.reload();
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            alert('Terjadi kesalahan saat memproses permintaan');
        })
        .finally(() => {
            submitButton.disabled = false;
            submitButton.innerHTML = 'Kirim Permintaan';
        });
    });

    // Reset form when modal is hidden
    document.getElementById('extensionModal').addEventListener('hidden.bs.modal', function() {
        document.getElementById('extensionForm').reset();
        currentLoanId = null;
    });
});
</script>
@endif
@endsection
