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

    .filter-btn {
        border-radius: 20px;
        transition: all 0.2s ease;
    }

    .filter-btn.active {
        background-color: var(--bs-primary);
        color: white;
        border-color: var(--bs-primary);
    }

    .filter-btn:hover:not(.active) {
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .input-group-text {
        background-color: #f8f9fa;
        border-color: #dee2e6;
    }

    #searchInput:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }

    .table tbody tr[style*="display: none"] {
        display: none !important;
    }

    mark.bg-warning {
        background-color: #fff3cd !important;
        color: #664d03;
        padding: 0 2px;
        border-radius: 2px;
    }

    .filter-section {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1rem;
    }

    .search-help {
        font-size: 0.75rem;
        color: #6c757d;
        margin-top: 0.25rem;
    }

    .keyboard-shortcut {
        background-color: #e9ecef;
        padding: 0.125rem 0.25rem;
        border-radius: 3px;
        font-family: monospace;
        font-size: 0.75rem;
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
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-list-ul text-primary me-2"></i>
                            Peminjaman Terbaru
                        </h5>
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-success btn-sm" onclick="exportData()" title="Export Data">
                                <i class="bi bi-download"></i>
                            </button>
                            <button class="btn btn-outline-primary btn-sm" onclick="refreshTable()" title="Refresh Data">
                                <i class="bi bi-arrow-clockwise"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Filter dan Search -->
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text"
                                       class="form-control"
                                       id="searchInput"
                                       placeholder="Cari nama peminjam, judul buku, atau ID pinjaman..."
                                       onkeyup="filterTable()">
                            </div>
                            <div class="search-help">
                                <span class="keyboard-shortcut">Ctrl+F</span> untuk fokus pencarian,
                                <span class="keyboard-shortcut">Esc</span> untuk reset filter
                            </div>
                        </div>
                        <div class="col-md-6">
                            <select class="form-select" id="statusFilter" onchange="filterTable()">
                                <option value="">Semua Status</option>
                                <option value="dipinjam">Dipinjam</option>
                                <option value="terlambat">Terlambat</option>
                                <option value="dikembalikan">Dikembalikan</option>
                                <option value="hilang">Hilang</option>
                            </select>
                        </div>
                    </div>

                    <!-- Status Filter Buttons -->
                    <div class="d-flex flex-wrap gap-2 mt-3">
                        <button class="btn btn-outline-secondary btn-sm filter-btn active" data-status="" onclick="quickFilter('')">
                            <i class="bi bi-list-ul me-1"></i>
                            Semua <span class="badge bg-secondary ms-1" id="count-all">{{ $peminjamanTerbaru->count() }}</span>
                        </button>
                        <button class="btn btn-outline-warning btn-sm filter-btn" data-status="dipinjam" onclick="quickFilter('dipinjam')">
                            <i class="bi bi-arrow-up-circle me-1"></i>
                            Dipinjam <span class="badge bg-warning ms-1" id="count-dipinjam">{{ $peminjamanTerbaru->where('status', 'dipinjam')->count() }}</span>
                        </button>
                        <button class="btn btn-outline-danger btn-sm filter-btn" data-status="terlambat" onclick="quickFilter('terlambat')">
                            <i class="bi bi-exclamation-triangle me-1"></i>
                            Terlambat <span class="badge bg-danger ms-1" id="count-terlambat">{{ $peminjamanTerbaru->where('status', 'terlambat')->count() }}</span>
                        </button>
                        <button class="btn btn-outline-success btn-sm filter-btn" data-status="dikembalikan" onclick="quickFilter('dikembalikan')">
                            <i class="bi bi-check-circle me-1"></i>
                            Dikembalikan <span class="badge bg-success ms-1" id="count-dikembalikan">{{ $peminjamanTerbaru->where('status', 'dikembalikan')->count() }}</span>
                        </button>
                        <button class="btn btn-outline-dark btn-sm filter-btn" data-status="hilang" onclick="quickFilter('hilang')">
                            <i class="bi bi-x-circle me-1"></i>
                            Hilang <span class="badge bg-dark ms-1" id="count-hilang">{{ $peminjamanTerbaru->where('status', 'hilang')->count() }}</span>
                        </button>
                    </div>

                    <!-- Results Info -->
                    <div class="d-flex justify-content-between align-items-center mt-3 mb-2">
                        <small class="text-muted" id="resultsInfo">
                            Menampilkan {{ $peminjamanTerbaru->count() }} dari {{ $peminjamanTerbaru->count() }} data
                        </small>
                        <small class="text-muted">
                            <i class="bi bi-info-circle me-1"></i>
                            Klik pada filter untuk memfilter data
                        </small>
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
                            <tbody id="tableBody">
                                @forelse($peminjamanTerbaru as $peminjaman)
                                <tr data-status="{{ $peminjaman->status }}"
                                    data-search="{{ strtolower($peminjaman->nama_lengkap . ' ' . $peminjaman->judul_buku . ' PJM' . str_pad($peminjaman->id_peminjaman, 3, '0', STR_PAD_LEFT)) }}">
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
                                <tr id="emptyState">
                                    <td colspan="7" class="text-center empty-state">
                                        <div class="py-4">
                                            <i class="bi bi-inbox-fill d-block"></i>
                                            <h6 class="mb-2">Belum ada data peminjaman</h6>
                                            <p class="text-muted mb-0">Data peminjaman akan muncul di sini setelah ada transaksi peminjaman buku</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse

                                <!-- No Results Found State -->
                                <tr id="noResultsState" style="display: none;">
                                    <td colspan="7" class="text-center empty-state">
                                        <div class="py-4">
                                            <i class="bi bi-search d-block"></i>
                                            <h6 class="mb-2">Tidak ada hasil yang ditemukan</h6>
                                            <p class="text-muted mb-0">Coba ubah kata kunci pencarian atau filter status</p>
                                            <button class="btn btn-outline-primary btn-sm mt-2" onclick="clearFilters()">
                                                <i class="bi bi-arrow-clockwise me-1"></i>
                                                Reset Filter
                                            </button>
                                        </div>
                                    </td>
                                </tr>
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

    // Function untuk export data (basic CSV export)
    function exportData() {
        const rows = document.querySelectorAll('#tableBody tr[data-status]');
        const visibleRows = Array.from(rows).filter(row => row.style.display !== 'none');

        if (visibleRows.length === 0) {
            alert('Tidak ada data untuk diekspor');
            return;
        }

        let csvContent = "data:text/csv;charset=utf-8,";
        csvContent += "ID Pinjaman,Nama Peminjam,Judul Buku,Tanggal Pinjam,Tanggal Kembali,Status\n";

        visibleRows.forEach(row => {
            const cells = row.querySelectorAll('td');
            const rowData = [
                cells[0].textContent.trim(),
                cells[1].textContent.trim(),
                cells[2].textContent.trim(),
                cells[3].textContent.trim(),
                cells[4].textContent.trim(),
                cells[5].textContent.trim()
            ];
            csvContent += rowData.map(field => `"${field}"`).join(',') + '\n';
        });

        const encodedUri = encodeURI(csvContent);
        const link = document.createElement('a');
        link.setAttribute('href', encodedUri);
        link.setAttribute('download', `peminjaman_${new Date().toISOString().split('T')[0]}.csv`);
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    // Function untuk filter table berdasarkan pencarian dan status
    function filterTable() {
        const searchInput = document.getElementById('searchInput');
        const statusFilter = document.getElementById('statusFilter');
        const tableBody = document.getElementById('tableBody');
        const rows = tableBody.querySelectorAll('tr[data-status]');
        const emptyState = document.getElementById('emptyState');
        const noResultsState = document.getElementById('noResultsState');

        const searchTerm = searchInput.value.toLowerCase();
        const statusValue = statusFilter.value;

        let visibleCount = 0;

        rows.forEach(row => {
            const searchData = row.getAttribute('data-search');
            const statusData = row.getAttribute('data-status');

            const matchesSearch = searchData.includes(searchTerm);
            const matchesStatus = statusValue === '' || statusData === statusValue;

            if (matchesSearch && matchesStatus) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        // Update filter button states
        updateFilterButtons(statusValue);

        // Show/hide empty states
        if (visibleCount === 0) {
            if (emptyState) emptyState.style.display = 'none';
            noResultsState.style.display = '';
        } else {
            if (emptyState) emptyState.style.display = 'none';
            noResultsState.style.display = 'none';
        }

        // Update counter badges
        updateCounters();
    }

    // Function untuk quick filter berdasarkan status
    function quickFilter(status) {
        const statusFilter = document.getElementById('statusFilter');
        statusFilter.value = status;
        filterTable();
    }

    // Function untuk clear semua filter
    function clearFilters() {
        const searchInput = document.getElementById('searchInput');
        const statusFilter = document.getElementById('statusFilter');

        searchInput.value = '';
        statusFilter.value = '';

        filterTable();
    }

    // Function untuk update filter button states
    function updateFilterButtons(activeStatus) {
        const filterButtons = document.querySelectorAll('.filter-btn');

        filterButtons.forEach(btn => {
            const btnStatus = btn.getAttribute('data-status');
            if (btnStatus === activeStatus) {
                btn.classList.add('active');
            } else {
                btn.classList.remove('active');
            }
        });
    }

    // Function untuk update counter badges
    function updateCounters() {
        const tableBody = document.getElementById('tableBody');
        const rows = tableBody.querySelectorAll('tr[data-status]');

        const counters = {
            all: 0,
            dipinjam: 0,
            terlambat: 0,
            dikembalikan: 0,
            hilang: 0
        };

        rows.forEach(row => {
            if (row.style.display !== 'none') {
                const status = row.getAttribute('data-status');
                counters.all++;
                if (counters[status] !== undefined) {
                    counters[status]++;
                }
            }
        });

        // Update badge text
        document.getElementById('count-all').textContent = counters.all;
        document.getElementById('count-dipinjam').textContent = counters.dipinjam;
        document.getElementById('count-terlambat').textContent = counters.terlambat;
        document.getElementById('count-dikembalikan').textContent = counters.dikembalikan;
        document.getElementById('count-hilang').textContent = counters.hilang;

        // Update results info
        const totalRows = rows.length;
        document.getElementById('resultsInfo').textContent =
            `Menampilkan ${counters.all} dari ${totalRows} data`;
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
    document.addEventListener('DOMContentLoaded', function() {
        updateStatus();
        updateCounters();

        // Add keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl/Cmd + F untuk focus ke search
            if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
                e.preventDefault();
                document.getElementById('searchInput').focus();
            }

            // Escape untuk clear filters
            if (e.key === 'Escape') {
                clearFilters();
            }
        });

        // Auto-focus search when typing
        document.addEventListener('keypress', function(e) {
            const searchInput = document.getElementById('searchInput');
            if (document.activeElement !== searchInput &&
                e.key.match(/[a-zA-Z0-9\s]/) &&
                !e.ctrlKey &&
                !e.metaKey) {
                searchInput.focus();
                searchInput.value = e.key;
                filterTable();
            }
        });

        // Highlight search terms
        highlightSearchTerms();
    });

    // Function untuk highlight search terms
    function highlightSearchTerms() {
        const searchInput = document.getElementById('searchInput');
        let originalData = new Map(); // Store original cell content

        // Store original content
        document.querySelectorAll('#tableBody tr[data-status] td').forEach(cell => {
            if (!cell.querySelector('.badge') && !cell.querySelector('button')) {
                originalData.set(cell, cell.textContent);
            }
        });

        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            const rows = document.querySelectorAll('#tableBody tr[data-status]');

            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                cells.forEach(cell => {
                    // Skip cells with badges or buttons
                    if (cell.querySelector('.badge') || cell.querySelector('button')) return;

                    const originalText = originalData.get(cell) || cell.textContent;

                    if (searchTerm && originalText.toLowerCase().includes(searchTerm)) {
                        const regex = new RegExp(`(${escapeRegExp(searchTerm)})`, 'gi');
                        cell.innerHTML = originalText.replace(regex, '<mark class="bg-warning">$1</mark>');
                    } else {
                        cell.textContent = originalText;
                    }
                });
            });

            filterTable();
        });
    }

    // Function untuk escape regex characters
    function escapeRegExp(string) {
        return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    }
</script>
@endpush
