@push('styles')
<style>
    .table-responsive {
        border-radius: 8px;
        overflow: hidden;
    }

    .table th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
        color: #495057;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table tbody tr {
        transition: all 0.2s ease;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
        transform: scale(1.01);
    }

    .badge {
        font-size: 0.75rem;
        padding: 0.375rem 0.75rem;
        border-radius: 6px;
    }

    .btn-sm {
        font-size: 0.75rem;
        padding: 0.25rem 0.75rem;
        border-radius: 6px;
        transition: all 0.2s ease;
    }

    .btn-sm:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }

    .empty-state {
        padding: 3rem 1rem;
        color: #6c757d;
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }
</style>
@endpush

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
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-list-ul text-primary me-2"></i>
                            Peminjaman Terbaru
                        </h5>
                        <button class="btn btn-outline-primary btn-sm" onclick="refreshTable()" title="Refresh Data">
                            <i class="bi bi-arrow-clockwise"></i>
                        </button>
                    </div>
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
                                @forelse($peminjamanTerbaru as $peminjaman)
                                <tr>
                                    <td><span class="badge bg-primary">#PJM{{ str_pad($peminjaman->id_peminjaman, 3, '0', STR_PAD_LEFT) }}</span></td>
                                    <td>{{ $peminjaman->nama_lengkap }}</td>
                                    <td>{{ $peminjaman->judul_buku }}</td>
                                    <td>{{ $peminjaman->tanggal_pinjam ? \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') : '-' }}</td>
                                    <td>{{ $peminjaman->batas_kembali ? \Carbon\Carbon::parse($peminjaman->batas_kembali)->format('d M Y') : '-' }}</td>
                                    <td>
                                        @if($peminjaman->status === 'dipinjam')
                                            <span class="badge bg-warning"
                                                  title="Buku sedang dipinjam, batas kembali: {{ $peminjaman->batas_kembali ? \Carbon\Carbon::parse($peminjaman->batas_kembali)->format('d M Y') : '-' }}">
                                                Dipinjam
                                            </span>
                                        @elseif($peminjaman->status === 'dikembalikan')
                                            <span class="badge bg-success"
                                                  title="Buku telah dikembalikan pada: {{ $peminjaman->tanggal_kembali ? \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d M Y') : '-' }}">
                                                Dikembalikan
                                            </span>
                                        @elseif($peminjaman->status === 'terlambat')
                                            @php
                                                $daysLate = $peminjaman->batas_kembali ? \Carbon\Carbon::parse($peminjaman->batas_kembali)->diffInDays(\Carbon\Carbon::now(), false) : 0;
                                            @endphp
                                            <span class="badge bg-danger"
                                                  title="Terlambat {{ $daysLate }} hari dari tanggal {{ $peminjaman->batas_kembali ? \Carbon\Carbon::parse($peminjaman->batas_kembali)->format('d M Y') : '-' }}">
                                                Terlambat
                                            </span>
                                        @elseif($peminjaman->status === 'hilang')
                                            <span class="badge bg-dark" title="Buku dilaporkan hilang">Hilang</span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst($peminjaman->status) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($peminjaman->status === 'dipinjam' || $peminjaman->status === 'terlambat')
                                            <button class="btn btn-sm btn-outline-success"
                                                    onclick="returnBook({{ $peminjaman->id_peminjaman }})"
                                                    title="Kembalikan Buku">
                                                <i class="bi bi-check2"></i> Kembalikan
                                            </button>
                                            @if($peminjaman->status === 'terlambat')
                                                <button class="btn btn-sm btn-outline-warning ms-1"
                                                        onclick="remindUser({{ $peminjaman->id_peminjaman }})"
                                                        title="Kirim Pengingat">
                                                    <i class="bi bi-envelope"></i> Ingatkan
                                                </button>
                                            @endif
                                        @elseif($peminjaman->status === 'dikembalikan')
                                            <button class="btn btn-sm btn-outline-info"
                                                    onclick="viewDetail({{ $peminjaman->id_peminjaman }})"
                                                    title="Lihat Detail">
                                                <i class="bi bi-eye"></i> Detail
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center empty-state">
                                        <div class="py-4">
                                            <i class="bi bi-inbox-fill d-block"></i>
                                            <h6 class="mb-2">Belum ada data peminjaman</h6>
                                            <p class="text-muted mb-0">Data peminjaman akan muncul di sini setelah ada transaksi peminjaman buku</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($peminjamanTerbaru->count() >= 10)
                <div class="card-footer bg-light">
                    <div class="text-center">
                        <a href="#" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-eye me-1"></i>
                            Lihat Semua Peminjaman
                        </a>
                    </div>
                </div>
                @endif
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

    // Function untuk mengembalikan buku
    function returnBook(peminjamanId) {
        if (confirm('Apakah Anda yakin ingin mengembalikan buku ini?')) {
            // Redirect ke halaman pengembalian dengan ID peminjaman
            window.location.href = "{{ route('petugas.return') }}?id=" + peminjamanId;
        }
    }

    // Function untuk mengirim pengingat
    function remindUser(peminjamanId) {
        if (confirm('Kirim pengingat ke peminjam?')) {
            // AJAX call untuk mengirim pengingat
            fetch(`/petugas/remind/${peminjamanId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Pengingat berhasil dikirim!');
                } else {
                    alert('Gagal mengirim pengingat. Silakan coba lagi.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
            });
        }
    }

    // Function untuk melihat detail
    function viewDetail(peminjamanId) {
        // Redirect ke halaman detail peminjaman
        window.location.href = `/petugas/peminjaman/detail/${peminjamanId}`;
    }

    // Function untuk refresh table
    function refreshTable() {
        location.reload();
    }

    // Format tanggal untuk display
    function formatDate(dateString) {
        const date = new Date(dateString);
        const options = {
            year: 'numeric',
            month: 'short',
            day: '2-digit'
        };
        return date.toLocaleDateString('id-ID', options);
    }

    // Update status badge berdasarkan kondisi
    function updateStatus() {
        const today = new Date();
        document.querySelectorAll('tbody tr').forEach(row => {
            const statusBadge = row.querySelector('.badge');
            const batasKembali = row.cells[4].textContent;

            if (statusBadge && statusBadge.textContent === 'Dipinjam') {
                const dueDate = new Date(batasKembali);
                if (today > dueDate) {
                    statusBadge.className = 'badge bg-danger';
                    statusBadge.textContent = 'Terlambat';
                }
            }
        });
    }

    // Jalankan update status saat halaman dimuat
    document.addEventListener('DOMContentLoaded', updateStatus);
</script>
@endpush
