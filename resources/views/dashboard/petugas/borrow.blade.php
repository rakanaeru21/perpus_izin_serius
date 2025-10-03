@extends('layouts.dashboard')

@section('title', 'Peminjaman Buku - Petugas')
@section('page-title', 'Peminjaman Buku')
@section('user-name', 'Petugas Perpustakaan')
@section('user-role', 'Petugas')

@section('content')
<div class="row mb-4">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h6 class="card-title mb-0">
                    <i class="bi bi-plus-circle me-2"></i>Form Peminjaman Baru
                </h6>
            </div>
            <div class="card-body">
                <form id="borrowForm">
                    @csrf
                    <!-- ID User Section -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-person me-1"></i>ID Anggota
                            <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <input type="number"
                                   id="idUser"
                                   name="id_user"
                                   class="form-control"
                                   placeholder="Masukkan ID Anggota"
                                   required
                                   min="1">
                            <button class="btn btn-outline-primary" type="button" id="searchUserBtn">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                        <div class="invalid-feedback" id="userError"></div>
                        <small class="form-text text-muted">Masukkan ID anggota untuk mencari data</small>
                    </div>

                    <!-- Nama User (Read-only) -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Anggota</label>
                        <input type="text" id="userName" class="form-control" readonly>
                    </div>

                    <!-- ID Buku Section -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-book me-1"></i>ID Buku
                            <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <input type="number"
                                   id="idBuku"
                                   name="id_buku"
                                   class="form-control"
                                   placeholder="Scan barcode atau masukkan ID buku"
                                   required
                                   min="1">
                            <button class="btn btn-outline-primary" type="button" id="searchBookBtn">
                                <i class="bi bi-upc-scan"></i>
                            </button>
                        </div>
                        <div class="invalid-feedback" id="bookError"></div>
                        <small class="form-text text-muted">Scan barcode atau masukkan ID buku</small>
                    </div>

                    <!-- Judul Buku (Read-only) -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Judul Buku</label>
                        <input type="text" id="bookTitle" class="form-control" readonly>
                    </div>

                    <!-- Tanggal Pinjam (Auto-filled) -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-calendar-event me-1"></i>Tanggal Pinjam
                        </label>
                        <input type="date"
                               id="tanggalPinjam"
                               name="tanggal_pinjam"
                               class="form-control"
                               readonly
                               value="{{ date('Y-m-d') }}">
                        <small class="form-text text-muted">Tanggal peminjaman otomatis hari ini</small>
                    </div>

                    <!-- Batas Kembali -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-calendar-check me-1"></i>Batas Tanggal Kembali
                            <span class="text-danger">*</span>
                        </label>
                        <input type="date"
                               id="batasKembali"
                               name="batas_kembali"
                               class="form-control"
                               required>
                        <small class="form-text text-muted">Pilih batas waktu pengembalian buku</small>
                    </div>

                    <!-- Status (Auto-filled) -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status Peminjaman</label>
                        <select id="status" name="status" class="form-control" readonly>
                            <option value="dipinjam" selected>Dipinjam</option>
                        </select>
                        <small class="form-text text-muted">Status otomatis "Dipinjam"</small>
                    </div>

                    <!-- Denda (Hidden - Auto 0) -->
                    <input type="hidden" id="denda" name="denda" value="0.00">

                    <!-- Keterangan -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-chat-text me-1"></i>Keterangan
                        </label>
                        <textarea id="keterangan"
                                  name="keterangan"
                                  class="form-control"
                                  rows="3"
                                  placeholder="Masukkan keterangan tambahan (opsional)"></textarea>
                        <small class="form-text text-muted">Informasi tambahan tentang peminjaman ini</small>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                            <i class="bi bi-check-circle me-2"></i>
                            Proses Peminjaman
                        </button>
                        <button type="button" class="btn btn-outline-secondary" id="resetBtn">
                            <i class="bi bi-arrow-clockwise me-2"></i>
                            Reset Form
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h6 class="card-title mb-0">
                    <i class="bi bi-info-circle me-2"></i>Informasi Anggota
                </h6>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <i class="bi bi-person-circle text-muted" style="font-size: 4rem;"></i>
                    <h5 class="mt-2" id="userDisplayName">Pilih Anggota</h5>
                </div>

                <!-- User Info Cards -->
                <div class="row g-3">
                    <div class="col-6">
                        <div class="card bg-light">
                            <div class="card-body text-center p-3">
                                <i class="bi bi-shield-check text-primary fs-4"></i>
                                <div class="mt-2">
                                    <small class="text-muted d-block">Status Keanggotaan</small>
                                    <strong id="memberStatus" class="text-primary">-</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card bg-light">
                            <div class="card-body text-center p-3">
                                <i class="bi bi-book text-warning fs-4"></i>
                                <div class="mt-2">
                                    <small class="text-muted d-block">Buku Dipinjam</small>
                                    <strong id="activeBorrowings" class="text-warning">-</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card bg-light">
                            <div class="card-body text-center p-3">
                                <i class="bi bi-clock text-danger fs-4"></i>
                                <div class="mt-2">
                                    <small class="text-muted d-block">Keterlambatan</small>
                                    <strong id="overdueBorrowings" class="text-danger">-</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card bg-light">
                            <div class="card-body text-center p-3">
                                <i class="bi bi-currency-dollar text-success fs-4"></i>
                                <div class="mt-2">
                                    <small class="text-muted d-block">Total Denda</small>
                                    <strong id="totalFines" class="text-success">-</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Book Info Section -->
                <div class="mt-4" id="bookInfoSection" style="display: none;">
                    <hr>
                    <h6 class="text-muted mb-3">
                        <i class="bi bi-book me-2"></i>Informasi Buku
                    </h6>
                    <div class="card bg-light">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <small class="text-muted">Penulis</small>
                                    <p class="mb-2" id="bookAuthor">-</p>
                                </div>
                                <div class="col-4">
                                    <small class="text-muted">Tahun</small>
                                    <p class="mb-2" id="bookYear">-</p>
                                </div>
                                <div class="col-4">
                                    <small class="text-muted">Status</small>
                                    <p class="mb-2" id="bookStatus">-</p>
                                </div>
                            </div>
                        </div>
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
                        <tbody id="todayBorrowingsTable">
                            @if(isset($todayBorrowings) && $todayBorrowings->count() > 0)
                                @foreach($todayBorrowings as $index => $borrowing)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><span class="badge bg-primary">#PJM{{ str_pad($borrowing->id_peminjaman, 6, '0', STR_PAD_LEFT) }}</span></td>
                                    <td>{{ $borrowing->user->nama_lengkap }}</td>
                                    <td>{{ $borrowing->book->judul_buku }}</td>
                                    <td>{{ $borrowing->tanggal_pinjam->format('H:i') }}</td>
                                    <td>{{ $borrowing->batas_kembali->format('d M Y') }}</td>
                                    <td><span class="badge bg-{{ $borrowing->status_color }}">{{ $borrowing->formatted_status }}</span></td>
                                </tr>
                                @endforeach
                            @else
                                <tr id="noBorrowingsRow">
                                    <td colspan="7" class="text-center text-muted">Belum ada peminjaman hari ini</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    let selectedUser = null;
    let selectedBook = null;

    // Set minimum return date to tomorrow
    const tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate() + 1);
    $('#batasKembali').attr('min', tomorrow.toISOString().split('T')[0]);

    // Set default return date to 7 days from now
    const defaultReturnDate = new Date();
    defaultReturnDate.setDate(defaultReturnDate.getDate() + 7);
    $('#batasKembali').val(defaultReturnDate.toISOString().split('T')[0]);

    // Search user functionality
    $('#searchUserBtn, #idUser').on('click keypress', function(e) {
        if (e.type === 'click' || (e.type === 'keypress' && e.which === 13)) {
            e.preventDefault();
            searchUser();
        }
    });

    // Search book functionality
    $('#searchBookBtn, #idBuku').on('click keypress', function(e) {
        if (e.type === 'click' || (e.type === 'keypress' && e.which === 13)) {
            e.preventDefault();
            searchBook();
        }
    });

    // Form submission
    $('#borrowForm').on('submit', function(e) {
        e.preventDefault();
        processBorrowing();
    });

    // Reset form functionality
    $('#resetBtn').on('click', function() {
        resetForm();
    });

    function searchUser() {
        const userId = $('#idUser').val().trim();

        if (!userId) {
            showError('userError', 'Masukkan ID Anggota');
            return;
        }

        // Show loading state
        $('#searchUserBtn').prop('disabled', true).html('<i class="bi bi-hourglass-split"></i>');
        clearUserData();

        $.ajax({
            url: '{{ route("petugas.borrow.search-user") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                query: userId
            },
            success: function(response) {
                if (response.success) {
                    selectedUser = response.data;
                    populateUserData(response.data);
                    clearError('userError');
                } else {
                    showError('userError', response.message);
                    selectedUser = null;
                }
            },
            error: function(xhr) {
                showError('userError', 'Terjadi kesalahan saat mencari anggota');
                selectedUser = null;
            },
            complete: function() {
                $('#searchUserBtn').prop('disabled', false).html('<i class="bi bi-search"></i>');
            }
        });
    }

    function searchBook() {
        const bookId = $('#idBuku').val().trim();

        if (!bookId) {
            showError('bookError', 'Masukkan ID Buku');
            return;
        }

        // Show loading state
        $('#searchBookBtn').prop('disabled', true).html('<i class="bi bi-hourglass-split"></i>');
        clearBookData();

        $.ajax({
            url: '{{ route("petugas.borrow.search-book") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                query: bookId
            },
            success: function(response) {
                if (response.success) {
                    selectedBook = response.data;
                    populateBookData(response.data);
                    clearError('bookError');
                    $('#bookInfoSection').show();
                } else {
                    showError('bookError', response.message);
                    selectedBook = null;
                    $('#bookInfoSection').hide();
                }
            },
            error: function(xhr) {
                showError('bookError', 'Terjadi kesalahan saat mencari buku');
                selectedBook = null;
                $('#bookInfoSection').hide();
            },
            complete: function() {
                $('#searchBookBtn').prop('disabled', false).html('<i class="bi bi-upc-scan"></i>');
            }
        });
    }

    function processBorrowing() {
        if (!selectedUser) {
            showError('userError', 'Pilih anggota terlebih dahulu');
            $('#idUser').focus();
            return;
        }

        if (!selectedBook) {
            showError('bookError', 'Pilih buku terlebih dahulu');
            $('#idBuku').focus();
            return;
        }

        const batasKembali = $('#batasKembali').val();
        if (!batasKembali) {
            alert('Pilih batas tanggal kembali');
            $('#batasKembali').focus();
            return;
        }

        // Validate return date is not in the past
        const today = new Date();
        const returnDate = new Date(batasKembali);
        if (returnDate <= today) {
            alert('Batas tanggal kembali harus setelah hari ini');
            $('#batasKembali').focus();
            return;
        }

        // Show loading state
        $('#submitBtn').prop('disabled', true).html('<i class="bi bi-hourglass-split me-2"></i>Memproses...');

        // Prepare form data matching pinjaman table structure
        const formData = {
            _token: '{{ csrf_token() }}',
            id_user: selectedUser.id_user,
            id_buku: selectedBook.id_buku,
            tanggal_pinjam: $('#tanggalPinjam').val(),
            batas_kembali: batasKembali,
            status: 'dipinjam',
            denda: 0.00,
            keterangan: $('#keterangan').val().trim() || null
        };

        $.ajax({
            url: '{{ route("petugas.borrow.store") }}',
            method: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 2000
                    });

                    // Reset form
                    resetForm();

                    // Update today's borrowings table
                    updateTodayBorrowings();

                    // Generate receipt if needed
                    if (response.borrowing_id) {
                        showBorrowingReceipt(response.borrowing_id, selectedUser, selectedBook, batasKembali);
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: response.message
                    });
                }
            },
            error: function(xhr) {
                let errorMessage = 'Terjadi kesalahan saat memproses peminjaman';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                    // Handle validation errors
                    const errors = xhr.responseJSON.errors;
                    errorMessage = Object.values(errors).flat().join(', ');
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: errorMessage
                });
            },
            complete: function() {
                $('#submitBtn').prop('disabled', false).html('<i class="bi bi-check-circle me-2"></i>Proses Peminjaman');
            }
        });
    }

    function populateUserData(user) {
        $('#userName').val(user.nama_lengkap || user.name);
        $('#userDisplayName').text(user.nama_lengkap || user.name);
        $('#memberStatus').text(user.status === 'aktif' ? 'Aktif' : 'Tidak Aktif')
                           .removeClass('text-success text-danger')
                           .addClass(user.status === 'aktif' ? 'text-success' : 'text-danger');
        $('#activeBorrowings').text((user.active_borrowings || 0) + ' buku');
        $('#overdueBorrowings').text((user.overdue_borrowings || 0) + ' buku');
        $('#totalFines').text('Rp ' + new Intl.NumberFormat('id-ID').format(user.total_fines || 0));
    }

    function populateBookData(book) {
        $('#bookTitle').val(book.judul_buku || book.title);
        $('#bookAuthor').text(book.penulis || book.author || '-');
        $('#bookYear').text(book.tahun_terbit || book.year || '-');
        $('#bookStatus').text(book.status_buku || book.status || 'Tersedia')
                        .removeClass('text-success text-warning text-danger')
                        .addClass(getBookStatusClass(book.status_buku || book.status));
    }

    function getBookStatusClass(status) {
        switch(status) {
            case 'tersedia':
            case 'available':
                return 'text-success';
            case 'dipinjam':
            case 'borrowed':
                return 'text-warning';
            case 'hilang':
            case 'rusak':
            case 'lost':
            case 'damaged':
                return 'text-danger';
            default:
                return 'text-muted';
        }
    }

    function clearUserData() {
        $('#userName').val('');
        $('#userDisplayName').text('Pilih Anggota');
        $('#memberStatus').text('-').removeClass('text-success text-danger');
        $('#activeBorrowings').text('-');
        $('#overdueBorrowings').text('-');
        $('#totalFines').text('-');
    }

    function clearBookData() {
        $('#bookTitle').val('');
        $('#bookAuthor').text('-');
        $('#bookYear').text('-');
        $('#bookStatus').text('-').removeClass('text-success text-warning text-danger');
        $('#bookInfoSection').hide();
    }

    function resetForm() {
        $('#borrowForm')[0].reset();
        selectedUser = null;
        selectedBook = null;
        clearUserData();
        clearBookData();
        clearError('userError');
        clearError('bookError');

        // Reset dates
        $('#tanggalPinjam').val('{{ date("Y-m-d") }}');
        const defaultReturnDate = new Date();
        defaultReturnDate.setDate(defaultReturnDate.getDate() + 7);
        $('#batasKembali').val(defaultReturnDate.toISOString().split('T')[0]);

        // Reset status
        $('#status').val('dipinjam');
        $('#denda').val('0.00');
    }

    function showError(elementId, message) {
        $('#' + elementId).text(message).show();
        $('#' + elementId.replace('Error', '')).addClass('is-invalid');
    }

    function clearError(elementId) {
        $('#' + elementId).text('').hide();
        $('#' + elementId.replace('Error', '')).removeClass('is-invalid');
    }

    function showBorrowingReceipt(borrowingId, user, book, returnDate) {
        const receiptHtml = `
            <div class="text-center">
                <h5>Bukti Peminjaman</h5>
                <hr>
                <p><strong>ID Peminjaman:</strong> ${borrowingId}</p>
                <p><strong>Nama:</strong> ${user.nama_lengkap || user.name}</p>
                <p><strong>Buku:</strong> ${book.judul_buku || book.title}</p>
                <p><strong>Tanggal Pinjam:</strong> {{ date('d M Y') }}</p>
                <p><strong>Batas Kembali:</strong> ${new Date(returnDate).toLocaleDateString('id-ID')}</p>
                <hr>
                <small class="text-muted">Harap simpan bukti ini</small>
            </div>
        `;

        Swal.fire({
            title: 'Peminjaman Berhasil',
            html: receiptHtml,
            icon: 'success',
            showCancelButton: true,
            confirmButtonText: 'Print',
            cancelButtonText: 'Tutup'
        }).then((result) => {
            if (result.isConfirmed) {
                // Print functionality could be implemented here
                window.print();
            }
        });
    }

    function updateTodayBorrowings() {
        $.ajax({
            url: '{{ route("petugas.borrow.today") }}',
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    const tbody = $('#todayBorrowingsTable');
                    tbody.empty();

                    if (response.data.length > 0) {
                        response.data.forEach((borrowing, index) => {
                            const row = `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td><span class="badge bg-primary">#${borrowing.borrowing_id}</span></td>
                                    <td>${borrowing.user_name}</td>
                                    <td>${borrowing.book_title}</td>
                                    <td>${borrowing.time}</td>
                                    <td>${borrowing.batas_kembali}</td>
                                    <td><span class="badge bg-${borrowing.status_color}">${borrowing.status}</span></td>
                                </tr>
                            `;
                            tbody.append(row);
                        });
                    } else {
                        tbody.append('<tr><td colspan="7" class="text-center text-muted">Belum ada peminjaman hari ini</td></tr>');
                    }
                }
            },
            error: function(xhr) {
                console.error('Error updating today borrowings:', xhr);
            }
        });
    }

    // Auto-refresh today's borrowings every 30 seconds
    setInterval(updateTodayBorrowings, 30000);

    // Initialize form
    resetForm();
});
</script>
@endsection
