@extends('layouts.dashboard')

@section('title', 'Data Anggota - Petugas')
@section('page-title', 'Data Anggota')
@section('user-name', 'Petugas Perpustakaan')
@section('user-role', 'Petugas')

@section('sidebar-menu')
    <li class="nav-item">
        <a class="nav-link " href="{{ route('dashboard.petugas') }}">
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
        <a class="nav-link active" href="{{ route('petugas.anggota') }}">
            <i class="bi bi-people me-2"></i>
            Data Anggota
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('petugas.extensions') }}">
            <i class="bi bi-arrow-clockwise me-2"></i>
            Perpanjang
        </a>
    </li>
@endsection

@section('content')
<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-primary bg-opacity-10 rounded-3 p-3">
                            <i class="bi bi-people fs-4 text-primary"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="card-title text-muted mb-1">Total Anggota</h6>
                        <h4 class="mb-0 text-dark">{{ $statistics['totalAnggota'] }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-success bg-opacity-10 rounded-3 p-3">
                            <i class="bi bi-person-check fs-4 text-success"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="card-title text-muted mb-1">Anggota Aktif</h6>
                        <h4 class="mb-0 text-dark">{{ $statistics['anggotaAktif'] }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-warning bg-opacity-10 rounded-3 p-3">
                            <i class="bi bi-person-x fs-4 text-warning"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="card-title text-muted mb-1">Anggota Nonaktif</h6>
                        <h4 class="mb-0 text-dark">{{ $statistics['anggotaNonAktif'] }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Search and Filter Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-start-0" id="searchAnggota" placeholder="Cari nama, username, atau email anggota...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" id="filterStatus">
                            <option value="">Semua Status</option>
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="btn btn-outline-secondary w-100" id="resetFilter">
                            <i class="bi bi-arrow-clockwise me-2"></i>Reset Filter
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Anggota Table -->
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="card-title mb-0">
                        <i class="bi bi-table me-2"></i>Daftar Anggota Perpustakaan
                    </h6>
                    <span class="badge bg-primary" id="totalCount">{{ $anggotaList->count() }} anggota</span>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="anggotaTable">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 text-center">#</th>
                                <th class="border-0">Foto</th>
                                <th class="border-0">Nama Lengkap</th>
                                <th class="border-0">Username</th>
                                <th class="border-0">Email</th>
                                <th class="border-0">No. HP</th>
                                <th class="border-0">Alamat</th>
                                <th class="border-0">Status</th>
                                <th class="border-0">Tanggal Daftar</th>
                                <th class="border-0 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($anggotaList as $index => $anggota)
                            <tr class="anggota-row" data-search="{{ strtolower($anggota->nama_lengkap . ' ' . $anggota->username . ' ' . ($anggota->email ?? '')) }}" data-status="{{ $anggota->status }}">
                                <td class="text-center align-middle">
                                    <span class="fw-semibold text-muted">{{ $index + 1 }}</span>
                                </td>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center">
                                        @if($anggota->foto_profil && $anggota->foto_profil !== 'default.png')
                                            <img src="{{ asset('storage/profiles/' . $anggota->foto_profil) }}"
                                                 alt="{{ $anggota->nama_lengkap }}"
                                                 class="rounded-circle object-fit-cover"
                                                 width="40" height="40">
                                        @else
                                            <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center"
                                                 style="width: 40px; height: 40px;">
                                                <i class="bi bi-person text-primary"></i>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <div>
                                        <h6 class="mb-0 fw-semibold">{{ $anggota->nama_lengkap }}</h6>
                                        <small class="text-muted">ID: {{ $anggota->id_user }}</small>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <span class="badge bg-light text-dark border">{{ $anggota->username }}</span>
                                </td>
                                <td class="align-middle">
                                    @if($anggota->email)
                                        <span class="text-muted">{{ $anggota->email }}</span>
                                    @else
                                        <span class="text-muted fst-italic">Tidak ada</span>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    @if($anggota->no_hp)
                                        <span class="text-muted">{{ $anggota->no_hp }}</span>
                                    @else
                                        <span class="text-muted fst-italic">Tidak ada</span>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    @if($anggota->alamat)
                                        <span class="text-muted" title="{{ $anggota->alamat }}">
                                            {{ Str::limit($anggota->alamat, 30) }}
                                        </span>
                                    @else
                                        <span class="text-muted fst-italic">Tidak ada</span>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    @if($anggota->status === 'aktif')
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success">
                                            <i class="bi bi-check-circle me-1"></i>Aktif
                                        </span>
                                    @else
                                        <span class="badge bg-warning bg-opacity-10 text-warning border border-warning">
                                            <i class="bi bi-x-circle me-1"></i>Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    <span class="text-muted">
                                        {{ \Carbon\Carbon::parse($anggota->tanggal_daftar)->format('d M Y') }}
                                    </span>
                                    <small class="d-block text-muted">
                                        {{ \Carbon\Carbon::parse($anggota->tanggal_daftar)->diffForHumans() }}
                                    </small>
                                </td>
                                <td class="text-center align-middle">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-outline-primary btn-sm"
                                                onclick="viewAnggotaDetail({{ $anggota->id_user }})"
                                                title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-info btn-sm"
                                                onclick="viewPeminjamanHistory({{ $anggota->id_user }})"
                                                title="Riwayat Peminjaman">
                                            <i class="bi bi-clock-history"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bi bi-inbox fs-1 d-block mb-3 text-muted opacity-50"></i>
                                        <h6 class="text-muted">Tidak ada data anggota</h6>
                                        <p class="text-muted mb-0">Belum ada anggota yang terdaftar di sistem</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($anggotaList->count() > 0)
            <div class="card-footer bg-white border-top">
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                        Menampilkan <span id="currentCount">{{ $anggotaList->count() }}</span> dari {{ $anggotaList->count() }} anggota
                    </small>
                    <small class="text-muted">
                        <i class="bi bi-info-circle me-1"></i>
                        Klik tombol mata untuk melihat detail anggota
                    </small>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Anggota Detail Modal -->
<div class="modal fade" id="anggotaDetailModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-person-lines-fill me-2"></i>Detail Anggota
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="anggotaDetailContent">
                <!-- Content will be loaded here -->
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Peminjaman History Modal -->
<div class="modal fade" id="peminjamanHistoryModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-clock-history me-2"></i>Riwayat Peminjaman
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="peminjamanHistoryContent">
                <!-- Content will be loaded here -->
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    console.log('Anggota page loaded');

    // Search functionality
    $('#searchAnggota').on('input', function() {
        filterTable();
    });

    // Status filter
    $('#filterStatus').on('change', function() {
        filterTable();
    });

    // Reset filter
    $('#resetFilter').on('click', function() {
        $('#searchAnggota').val('');
        $('#filterStatus').val('');
        filterTable();
    });

    function filterTable() {
        const searchTerm = $('#searchAnggota').val().toLowerCase();
        const statusFilter = $('#filterStatus').val();

        let visibleCount = 0;

        $('.anggota-row').each(function() {
            const row = $(this);
            const searchData = row.data('search');
            const statusData = row.data('status');

            let showRow = true;

            // Text search filter
            if (searchTerm && !searchData.includes(searchTerm)) {
                showRow = false;
            }

            // Status filter
            if (statusFilter && statusData !== statusFilter) {
                showRow = false;
            }

            if (showRow) {
                row.show();
                visibleCount++;
                // Update row number
                row.find('td:first span').text(visibleCount);
            } else {
                row.hide();
            }
        });

        // Update counts
        $('#currentCount').text(visibleCount);
        $('#totalCount').text(visibleCount + ' anggota');

        // Show/hide empty state
        if (visibleCount === 0 && $('.anggota-row').length > 0) {
            if ($('#noDataRow').length === 0) {
                $('#anggotaTable tbody').append(`
                    <tr id="noDataRow">
                        <td colspan="10" class="text-center py-5">
                            <div class="text-muted">
                                <i class="bi bi-search fs-1 d-block mb-3 text-muted opacity-50"></i>
                                <h6 class="text-muted">Tidak ada hasil</h6>
                                <p class="text-muted mb-0">Tidak ada anggota yang sesuai dengan filter</p>
                            </div>
                        </td>
                    </tr>
                `);
            }
        } else {
            $('#noDataRow').remove();
        }
    }
});

function viewAnggotaDetail(userId) {
    console.log('Viewing detail for user:', userId);

    $('#anggotaDetailModal').modal('show');
    $('#anggotaDetailContent').html(`
        <div class="text-center">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    `);

    // Simulate API call - replace with actual endpoint
    setTimeout(() => {
        $('#anggotaDetailContent').html(`
            <div class="row">
                <div class="col-md-4 text-center">
                    <div class="bg-primary bg-opacity-10 rounded-3 p-4 mb-3">
                        <i class="bi bi-person fs-1 text-primary"></i>
                    </div>
                    <h6 class="text-muted">Foto Profil</h6>
                </div>
                <div class="col-md-8">
                    <h6 class="text-primary mb-3">Informasi Anggota</h6>
                    <div class="row mb-2">
                        <div class="col-4"><strong>ID User:</strong></div>
                        <div class="col-8">${userId}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><strong>Status:</strong></div>
                        <div class="col-8"><span class="badge bg-success">Aktif</span></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><strong>Total Peminjaman:</strong></div>
                        <div class="col-8">15 buku</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><strong>Sedang Dipinjam:</strong></div>
                        <div class="col-8">3 buku</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><strong>Keterlambatan:</strong></div>
                        <div class="col-8">0 buku</div>
                    </div>
                </div>
            </div>
        `);
    }, 1000);
}

function viewPeminjamanHistory(userId) {
    console.log('Viewing peminjaman history for user:', userId);

    $('#peminjamanHistoryModal').modal('show');
    $('#peminjamanHistoryContent').html(`
        <div class="text-center">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    `);

    // Simulate API call - replace with actual endpoint
    setTimeout(() => {
        $('#peminjamanHistoryContent').html(`
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID Peminjaman</th>
                            <th>Judul Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Batas Kembali</th>
                            <th>Tanggal Kembali</th>
                            <th>Status</th>
                            <th>Denda</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>PJM000001</td>
                            <td>Pemrograman PHP</td>
                            <td>01 Oct 2025</td>
                            <td>08 Oct 2025</td>
                            <td>07 Oct 2025</td>
                            <td><span class="badge bg-success">Dikembalikan</span></td>
                            <td>Rp 0</td>
                        </tr>
                        <tr>
                            <td>PJM000002</td>
                            <td>Database MySQL</td>
                            <td>05 Oct 2025</td>
                            <td>12 Oct 2025</td>
                            <td>-</td>
                            <td><span class="badge bg-warning">Dipinjam</span></td>
                            <td>Rp 0</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        `);
    }, 1000);
}
</script>
@endpush
