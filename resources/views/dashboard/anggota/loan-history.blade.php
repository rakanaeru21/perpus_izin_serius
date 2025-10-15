@extends('layouts.dashboard')

@section('title', 'Riwayat Pinjaman')
@section('page-title', 'Riwayat Pinjaman')
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
        <a class="nav-link" href="{{ route('anggota.loans') }}">
            <i class="bi bi-arrow-repeat me-2"></i>
            Pinjaman Saya
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" href="{{ route('anggota.loan-history') }}">
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
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body py-3">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="mb-0">
                                <i class="bi bi-clock-history text-primary me-2"></i>
                                Riwayat Pinjaman
                            </h4>
                            <p class="text-muted mb-0">Lihat semua riwayat peminjaman buku Anda</p>
                        </div>
                        <div class="col-auto">
                            <div class="d-flex gap-2">
                                <select class="form-select form-select-sm" id="statusFilter">
                                    <option value="">Semua Status</option>
                                    <option value="dipinjam">Sedang Dipinjam</option>
                                    <option value="dikembalikan">Dikembalikan</option>
                                    <option value="terlambat">Terlambat</option>
                                    <option value="hilang">Hilang</option>
                                </select>
                                <button class="btn btn-outline-primary btn-sm" id="exportBtn">
                                    <i class="bi bi-download me-1"></i>
                                    Export
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Summary -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="text-primary mb-2">
                        <i class="bi bi-journal-check" style="font-size: 2rem;"></i>
                    </div>
                    <h4 class="mb-1">{{ $statistics['total'] }}</h4>
                    <small class="text-muted">Total Pinjaman</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="text-success mb-2">
                        <i class="bi bi-check-circle" style="font-size: 2rem;"></i>
                    </div>
                    <h4 class="mb-1">{{ $statistics['dikembalikan'] }}</h4>
                    <small class="text-muted">Dikembalikan</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="text-warning mb-2">
                        <i class="bi bi-clock" style="font-size: 2rem;"></i>
                    </div>
                    <h4 class="mb-1">{{ $statistics['terlambat'] }}</h4>
                    <small class="text-muted">Terlambat</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="text-info mb-2">
                        <i class="bi bi-book" style="font-size: 2rem;"></i>
                    </div>
                    <h4 class="mb-1">{{ $statistics['sedang_dipinjam'] }}</h4>
                    <small class="text-muted">Sedang Dipinjam</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Loan History Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="bi bi-list-ul me-2"></i>
                        Daftar Riwayat Pinjaman
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($loanHistory->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" id="loanHistoryTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Buku</th>
                                        <th>Tanggal Pinjam</th>
                                        <th>Batas Kembali</th>
                                        <th>Tanggal Kembali</th>
                                        <th>Status</th>
                                        <th>Denda</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($loanHistory as $index => $loan)
                                        <tr class="loan-row" data-status="{{ $loan->status }}">
                                            <td>{{ $loanHistory->firstItem() + $index }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-primary text-white rounded d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 50px;">
                                                        <i class="bi bi-book"></i>
                                                    </div>
                                                    <div>
                                                        @if($loan->book)
                                                            <h6 class="mb-0">{{ $loan->book->judul_buku }}</h6>
                                                            <small class="text-muted">{{ $loan->book->penulis ?? 'Penulis tidak diketahui' }}</small>
                                                        @else
                                                            <h6 class="mb-0 text-danger">Buku Tidak Ditemukan</h6>
                                                            <small class="text-muted">ID Buku: {{ $loan->id_buku }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-muted">
                                                    {{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->format('d M Y') }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="text-muted">
                                                    {{ \Carbon\Carbon::parse($loan->batas_kembali)->format('d M Y') }}
                                                </span>
                                                @if($loan->status == 'dipinjam' && \Carbon\Carbon::parse($loan->batas_kembali)->isPast())
                                                    <br><small class="text-danger">Lewat {{ \Carbon\Carbon::parse($loan->batas_kembali)->diffForHumans() }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                @if($loan->tanggal_kembali)
                                                    <span class="text-success">
                                                        {{ \Carbon\Carbon::parse($loan->tanggal_kembali)->format('d M Y') }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @switch($loan->status)
                                                    @case('dipinjam')
                                                        <span class="badge bg-primary">Sedang Dipinjam</span>
                                                        @break
                                                    @case('dikembalikan')
                                                        <span class="badge bg-success">Dikembalikan</span>
                                                        @break
                                                    @case('terlambat')
                                                        <span class="badge bg-warning">Terlambat</span>
                                                        @break
                                                    @case('hilang')
                                                        <span class="badge bg-danger">Hilang</span>
                                                        @break
                                                    @default
                                                        <span class="badge bg-secondary">{{ ucfirst($loan->status) }}</span>
                                                @endswitch
                                            </td>
                                            <td>
                                                @if($loan->denda > 0)
                                                    <span class="text-danger fw-bold">
                                                        Rp {{ number_format($loan->denda, 0, ',', '.') }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                        <i class="bi bi-three-dots"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <button class="dropdown-item" onclick="viewLoanDetail({{ $loan->id_peminjaman }})">
                                                                <i class="bi bi-eye me-2"></i>
                                                                Lihat Detail
                                                            </button>
                                                        </li>
                                                        @if($loan->status == 'dikembalikan')
                                                            
                                                        @endif
                                                        @if($loan->keterangan)
                                                            <li>
                                                                <button class="dropdown-item" onclick="showNotes('{{ $loan->keterangan }}')">
                                                                    <i class="bi bi-sticky me-2"></i>
                                                                    Lihat Catatan
                                                                </button>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="card-footer bg-white">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <small class="text-muted">
                                        Menampilkan {{ $loanHistory->firstItem() }} sampai {{ $loanHistory->lastItem() }}
                                        dari {{ $loanHistory->total() }} riwayat pinjaman
                                    </small>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-end">
                                        {{ $loanHistory->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-inbox text-muted mb-3" style="font-size: 4rem;"></i>
                            <h5 class="text-muted">Belum Ada Riwayat Pinjaman</h5>
                            <p class="text-muted">Anda belum pernah meminjam buku. Jelajahi katalog untuk mulai meminjam buku.</p>
                            <a href="{{ route('anggota.catalog') }}" class="btn btn-primary">
                                <i class="bi bi-book me-2"></i>
                                Jelajahi Katalog
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Pinjaman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="detailContent">
                    <!-- Content will be loaded via AJAX -->
                </div>
            </div>
        </div>
    </div>

    <!-- Notes Modal -->
    <div class="modal fade" id="notesModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Catatan Pinjaman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="notesContent">
                    <!-- Notes content -->
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .table th {
        border-top: none;
        font-weight: 600;
        color: #495057;
    }

    .loan-row {
        transition: all 0.2s ease;
    }

    .loan-row:hover {
        background-color: #f8f9fa;
    }

    .badge {
        font-size: 0.75rem;
        padding: 0.375rem 0.75rem;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Status filter functionality
        const statusFilter = document.getElementById('statusFilter');
        const loanRows = document.querySelectorAll('.loan-row');

        statusFilter.addEventListener('change', function() {
            const selectedStatus = this.value;

            loanRows.forEach(row => {
                const rowStatus = row.getAttribute('data-status');

                if (selectedStatus === '' || rowStatus === selectedStatus) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Export functionality
        document.getElementById('exportBtn').addEventListener('click', function() {
            // You can implement export functionality here
            alert('Fitur export akan segera tersedia');
        });
    });

    // View loan detail function
    function viewLoanDetail(loanId) {
        // Show loading
        document.getElementById('detailContent').innerHTML = '<div class="text-center"><div class="spinner-border" role="status"></div></div>';

        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('detailModal'));
        modal.show();

        // In a real implementation, you would fetch data via AJAX
        setTimeout(() => {
            document.getElementById('detailContent').innerHTML = `
                <div class="row">
                    <div class="col-12">
                        <p><strong>ID Pinjaman:</strong> ${loanId}</p>
                        <p class="text-muted">Detail lengkap pinjaman akan ditampilkan di sini.</p>
                    </div>
                </div>
            `;
        }, 1000);
    }

    // Print receipt function
    function printReceipt(loanId) {
        // In a real implementation, this would generate and print a receipt
        alert(`Mencetak kwitansi untuk pinjaman ID: ${loanId}`);
    }

    // Show notes function
    function showNotes(notes) {
        document.getElementById('notesContent').innerHTML = `<p>${notes}</p>`;
        const modal = new bootstrap.Modal(document.getElementById('notesModal'));
        modal.show();
    }
</script>
@endpush
