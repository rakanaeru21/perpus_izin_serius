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
                <form id="returnForm">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">ID Pinjaman atau Kode Buku</label>
                        <div class="input-group">
                            <input type="text" id="searchInput" class="form-control" placeholder="Scan barcode atau masukkan ID" autocomplete="off">
                            <button class="btn btn-outline-secondary" type="button" id="searchBtn">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                        <div class="form-text">Masukkan ID peminjaman atau kode buku untuk mencari data peminjaman</div>
                    </div>

                    <div id="borrowingDetails" style="display: none;">
                        <input type="hidden" id="idPeminjaman" name="id_peminjaman">

                        <div class="mb-3">
                            <label class="form-label">Nama Peminjam</label>
                            <input type="text" id="memberName" class="form-control" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Judul Buku</label>
                            <input type="text" id="bookTitle" class="form-control" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Pinjam</label>
                            <input type="text" id="borrowDate" class="form-control" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Kembali Seharusnya</label>
                            <input type="text" id="dueDate" class="form-control" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kondisi Buku <span class="text-danger">*</span></label>
                            <select id="kondisiBuku" name="kondisi_buku" class="form-select" required>
                                <option value="baik">Baik</option>
                                <option value="rusak_ringan">Rusak Ringan</option>
                                <option value="rusak_berat">Rusak Berat</option>
                                <option value="hilang">Hilang</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Denda (jika ada)</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" id="fineAmount" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <textarea id="keterangan" name="keterangan" class="form-control" rows="3" placeholder="Keterangan tambahan (opsional)"></textarea>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check-circle me-2"></i>
                                Proses Pengembalian
                            </button>
                        </div>
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
                <div id="borrowingStatus">
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
        </div>

        <div class="card mt-3">
            <div class="card-header bg-white">
                <h6 class="card-title mb-0">Riwayat Peminjaman Anggota</h6>
            </div>
            <div class="card-body">
                <div id="memberHistory">
                    <div class="text-center text-muted">
                        <i class="bi bi-clock-history" style="font-size: 2rem;"></i>
                        <p class="mt-2">Pilih peminjaman untuk melihat riwayat</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h6 class="card-title mb-0">Pengembalian Hari Ini</h6>
                <button class="btn btn-sm btn-outline-secondary" id="refreshReturns">
                    <i class="bi bi-arrow-clockwise"></i> Refresh
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="todayReturnsTable">
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
                            <!-- Data will be loaded via AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Loading Modal -->
<div class="modal fade" id="loadingModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center p-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2 mb-0">Memproses pengembalian...</p>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    let currentBorrowing = null;

    // Load today's returns on page load
    loadTodayReturns();

    // Search functionality
    $('#searchBtn, #searchInput').on('click keypress', function(e) {
        if (e.type === 'click' || e.which === 13) {
            e.preventDefault();
            searchBorrowing();
        }
    });

    // Form submission
    $('#returnForm').on('submit', function(e) {
        e.preventDefault();
        processReturn();
    });

    // Refresh returns
    $('#refreshReturns').on('click', function() {
        loadTodayReturns();
    });

    function searchBorrowing() {
        const search = $('#searchInput').val().trim();

        if (!search) {
            showAlert('Harap masukkan ID peminjaman atau kode buku', 'warning');
            return;
        }

        $.ajax({
            url: '{{ route("petugas.return.search") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                search: search
            },
            beforeSend: function() {
                $('#searchBtn').prop('disabled', true);
                $('#searchBtn').html('<i class="bi bi-hourglass-split"></i>');
            },
            success: function(response) {
                if (response.success) {
                    currentBorrowing = response.data.borrowing;
                    populateBorrowingDetails(response.data);
                    updateBorrowingStatus(response.data);
                    updateMemberHistory(response.data.history);
                } else {
                    showAlert(response.message, 'danger');
                    resetForm();
                }
            },
            error: function() {
                showAlert('Terjadi kesalahan saat mencari data', 'danger');
                resetForm();
            },
            complete: function() {
                $('#searchBtn').prop('disabled', false);
                $('#searchBtn').html('<i class="bi bi-search"></i>');
            }
        });
    }

    function populateBorrowingDetails(data) {
        $('#idPeminjaman').val(data.borrowing.id_peminjaman);
        $('#memberName').val(data.member_name);
        $('#bookTitle').val(data.book_title);
        $('#borrowDate').val(data.borrow_date);
        $('#dueDate').val(data.due_date);
        $('#fineAmount').val(formatRupiah(data.fine));

        $('#borrowingDetails').show();
    }

    function updateBorrowingStatus(data) {
        const isOverdue = data.days_overdue > 0;
        const statusHtml = `
            <div class="alert ${isOverdue ? 'alert-warning' : 'alert-success'}" role="alert">
                <i class="bi bi-${isOverdue ? 'exclamation-triangle' : 'check-circle'} me-2"></i>
                ${isOverdue ? 'Peminjaman terlambat!' : 'Peminjaman dalam batas waktu'}
            </div>

            <div class="row">
                <div class="col-6">
                    <small class="text-muted">Hari Terlambat</small>
                    <p class="fw-bold ${isOverdue ? 'text-danger' : 'text-success'}">${data.days_overdue} hari</p>
                </div>
                <div class="col-6">
                    <small class="text-muted">Total Denda</small>
                    <p class="fw-bold ${data.fine > 0 ? 'text-danger' : 'text-success'}">Rp ${formatRupiah(data.fine)}</p>
                </div>
            </div>
        `;

        $('#borrowingStatus').html(statusHtml);
    }

    function updateMemberHistory(history) {
        if (history.length === 0) {
            $('#memberHistory').html(`
                <div class="text-center text-muted">
                    <i class="bi bi-journal-x" style="font-size: 2rem;"></i>
                    <p class="mt-2">Belum ada riwayat pengembalian</p>
                </div>
            `);
            return;
        }

        let historyHtml = '<div class="list-group list-group-flush">';
        history.forEach(function(item) {
            historyHtml += `
                <div class="list-group-item px-0">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">${item.book_title}</div>
                            <small class="text-muted">Dikembalikan: ${item.return_date}</small>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-secondary">${item.condition}</span>
                            ${item.fine > 0 ? `<br><small class="text-danger">Denda: Rp ${formatRupiah(item.fine)}</small>` : ''}
                        </div>
                    </div>
                </div>
            `;
        });
        historyHtml += '</div>';

        $('#memberHistory').html(historyHtml);
    }

    function processReturn() {
        if (!currentBorrowing) {
            showAlert('Harap cari peminjaman terlebih dahulu', 'warning');
            return;
        }

        const formData = {
            _token: '{{ csrf_token() }}',
            id_peminjaman: $('#idPeminjaman').val(),
            kondisi_buku: $('#kondisiBuku').val(),
            keterangan: $('#keterangan').val()
        };

        $('#loadingModal').modal('show');

        $.ajax({
            url: '{{ route("petugas.return.process") }}',
            method: 'POST',
            data: formData,
            success: function(response) {
                $('#loadingModal').modal('hide');

                if (response.success) {
                    showAlert(response.message, 'success');
                    resetForm();
                    loadTodayReturns();
                } else {
                    showAlert(response.message, 'danger');
                }
            },
            error: function() {
                $('#loadingModal').modal('hide');
                showAlert('Terjadi kesalahan saat memproses pengembalian', 'danger');
            }
        });
    }

    function loadTodayReturns() {
        $.ajax({
            url: '{{ route("petugas.return.today") }}',
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    updateTodayReturnsTable(response.data);
                }
            },
            error: function() {
                console.error('Failed to load today returns');
            }
        });
    }

    function updateTodayReturnsTable(data) {
        const tbody = $('#todayReturnsTable tbody');
        tbody.empty();

        if (data.length === 0) {
            tbody.append(`
                <tr>
                    <td colspan="8" class="text-center text-muted">
                        <i class="bi bi-inbox"></i> Belum ada pengembalian hari ini
                    </td>
                </tr>
            `);
            return;
        }

        data.forEach(function(item) {
            tbody.append(`
                <tr>
                    <td>${item.no}</td>
                    <td><span class="badge bg-secondary">${item.id_peminjaman}</span></td>
                    <td>${item.member_name}</td>
                    <td>${item.book_title}</td>
                    <td>${item.return_time}</td>
                    <td><span class="badge bg-${item.condition_color}">${item.condition}</span></td>
                    <td>${item.fine}</td>
                    <td><span class="badge bg-success">${item.status}</span></td>
                </tr>
            `);
        });
    }

    function resetForm() {
        currentBorrowing = null;
        $('#returnForm')[0].reset();
        $('#borrowingDetails').hide();
        $('#searchInput').val('');

        $('#borrowingStatus').html(`
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
        `);

        $('#memberHistory').html(`
            <div class="text-center text-muted">
                <i class="bi bi-clock-history" style="font-size: 2rem;"></i>
                <p class="mt-2">Pilih peminjaman untuk melihat riwayat</p>
            </div>
        `);
    }

    function formatRupiah(amount) {
        return new Intl.NumberFormat('id-ID').format(amount);
    }

    function showAlert(message, type) {
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;

        // Remove existing alerts
        $('.alert').remove();

        // Add new alert at the top of the content
        $('.row:first').before(alertHtml);

        // Auto dismiss after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut();
        }, 5000);
    }
});
</script>
@endpush
