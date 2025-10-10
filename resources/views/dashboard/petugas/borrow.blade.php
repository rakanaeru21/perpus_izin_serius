@extends('layouts.dashboard')

@section('title', 'Peminjaman Buku - Petugas')
@section('page-title', 'Peminjaman Buku')
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
        <a class="nav-link active" href="{{ route('petugas.borrow') }}">
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
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="bi bi-journal-text me-2"></i>
            Laporan Harian
        </a>
    </li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h6 class="card-title mb-0">
                    <i class="bi bi-plus-circle me-2"></i>Form Peminjaman Buku
                </h6>
            </div>
            <div class="card-body">
                <form id="borrowForm" action="{{ route('petugas.borrow.store') }}" method="POST">
                    @csrf

                    <!-- ID User atau Username -->
                    <div class="mb-3">
                        <label for="id_user" class="form-label">ID User atau Username <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="id_user" name="id_user" placeholder="Masukkan ID User atau Username" required>
                        <div class="invalid-feedback" id="userError"></div>
                        <small class="form-text text-muted">Contoh: 2 atau username</small>
                    </div>

                    <!-- ID Buku atau Kode Buku -->
                    <div class="mb-3">
                        <label for="id_buku" class="form-label">ID Buku atau Kode Buku <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="id_buku" name="id_buku" placeholder="Masukkan ID Buku atau Kode Buku" required>
                        <div class="invalid-feedback" id="bookError"></div>
                        <small class="form-text text-muted">Contoh: 1 atau BK001</small>
                    </div>

                    <!-- Tanggal Pinjam -->
                    <div class="mb-3">
                        <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
                        <input type="date" class="form-control" id="tanggal_pinjam" name="tanggal_pinjam" value="{{ date('Y-m-d') }}" readonly>
                    </div>

                    <!-- Batas Kembali -->
                    <div class="mb-3">
                        <label for="batas_kembali" class="form-label">Batas Kembali <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="batas_kembali" name="batas_kembali" required>
                    </div>

                    <!-- Status -->
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" readonly>
                            <option value="dipinjam" selected>Dipinjam</option>
                        </select>
                    </div>

                    <!-- Denda -->
                    <div class="mb-3">
                        <label for="denda" class="form-label">Denda</label>
                        <input type="number" class="form-control" id="denda" name="denda" value="0.00" step="0.01" readonly>
                    </div>

                    <!-- Keterangan -->
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="3" placeholder="Keterangan tambahan (opsional)"></textarea>
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <i class="bi bi-check-circle me-2"></i>Proses Peminjaman
                        </button>
                        <button type="button" class="btn btn-secondary" id="resetBtn">
                            <i class="bi bi-arrow-clockwise me-2"></i>Reset
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Today's Borrowings -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h6 class="card-title mb-0">
                    <i class="bi bi-list-ul me-2"></i>Peminjaman Hari Ini
                </h6>
                <span class="badge bg-primary">{{ $todayBorrowings->count() }} peminjaman</span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="todayBorrowingsTable">
                        <thead class="table-light">
                            <tr>
                                <th>ID Peminjaman</th>
                                <th>Nama Anggota</th>
                                <th>Judul Buku</th>
                                <th>Waktu</th>
                                <th>Batas Kembali</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($todayBorrowings as $borrowing)
                            <tr>
                                <td>
                                    <span class="fw-bold text-primary">
                                        PJM{{ str_pad($borrowing->id_peminjaman, 6, '0', STR_PAD_LEFT) }}
                                    </span>
                                </td>
                                <td>
                                    <div>
                                        <strong>{{ $borrowing->user->nama_lengkap }}</strong>
                                        <small class="text-muted d-block">{{ $borrowing->user->username }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <strong>{{ $borrowing->book->judul_buku }}</strong>
                                        <small class="text-muted d-block">{{ $borrowing->book->penulis }}</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-muted">
                                        {{ $borrowing->tanggal_pinjam->format('H:i') }}
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-semibold">
                                        {{ $borrowing->batas_kembali->format('d M Y') }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $borrowing->status_color }}">
                                        {{ $borrowing->formatted_status }}
                                    </span>
                                </td>
                                <td>
                                    <span class="text-muted">
                                        {{ $borrowing->keterangan ?? '-' }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                        <p class="mb-0">Belum ada peminjaman hari ini</p>
                                        <small>Peminjaman akan muncul di sini setelah diproses</small>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($todayBorrowings->count() > 0)
                <div class="mt-3">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <div class="border rounded p-2">
                                <h6 class="mb-1">Total Hari Ini</h6>
                                <span class="h4 text-primary">{{ $todayBorrowings->count() }}</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="border rounded p-2">
                                <h6 class="mb-1">Buku Dipinjam</h6>
                                <span class="h4 text-info">{{ $todayBorrowings->where('status', 'dipinjam')->count() }}</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="border rounded p-2">
                                <h6 class="mb-1">Peminjam Unik</h6>
                                <span class="h4 text-success">{{ $todayBorrowings->unique('id_user')->count() }}</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="border rounded p-2">
                                <h6 class="mb-1">Buku Berbeda</h6>
                                <span class="h4 text-warning">{{ $todayBorrowings->unique('id_buku')->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    console.log('Document ready - Form loaded successfully');

    // Set minimum return date to tomorrow
    const tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate() + 1);
    $('#batas_kembali').attr('min', tomorrow.toISOString().split('T')[0]);

    // Set default return date to 7 days from now
    const defaultReturnDate = new Date();
    defaultReturnDate.setDate(defaultReturnDate.getDate() + 7);
    $('#batas_kembali').val(defaultReturnDate.toISOString().split('T')[0]);

    // Form submission
    $('#borrowForm').on('submit', function(e) {
        e.preventDefault();
        processBorrowing();
    });

    // Reset form functionality
    $('#resetBtn').on('click', function() {
        resetForm();
    });

    function processBorrowing() {
        const userInput = $('#id_user').val().trim();
        const bookInput = $('#id_buku').val().trim();

        console.log('=== FORM SUBMISSION START ===');
        console.log('User input:', userInput);
        console.log('Book input:', bookInput);

        if (!userInput) {
            showError('userError', 'ID User atau Username harus diisi');
            $('#id_user').focus();
            return;
        }

        if (!bookInput) {
            showError('bookError', 'ID Buku atau Kode Buku harus diisi');
            $('#id_buku').focus();
            return;
        }

        const batasKembali = $('#batas_kembali').val();
        if (!batasKembali) {
            alert('Pilih batas tanggal kembali');
            $('#batas_kembali').focus();
            return;
        }

        // Validate return date is not in the past
        const today = new Date();
        const returnDate = new Date(batasKembali);
        if (returnDate <= today) {
            alert('Batas tanggal kembali harus setelah hari ini');
            $('#batas_kembali').focus();
            return;
        }

        // Clear previous errors
        clearError('userError');
        clearError('bookError');

        // Show loading state
        $('#submitBtn').prop('disabled', true).html('<i class="bi bi-hourglass-split me-2"></i>Memproses...');

        // Prepare form data
        const formData = {
            _token: $('meta[name="csrf-token"]').attr('content') || '{{ csrf_token() }}',
            id_user: userInput,
            id_buku: bookInput,
            tanggal_pinjam: $('#tanggal_pinjam').val(),
            batas_kembali: batasKembali,
            status: 'dipinjam',
            denda: 0.00,
            keterangan: $('#keterangan').val().trim() || null
        };

        console.log('=== FORM DATA ===');
        console.log('CSRF Token:', formData._token);
        console.log('Form data:', formData);
        console.log('Route URL:', '{{ route("petugas.borrow.store") }}');

        $.ajax({
            url: '{{ route("petugas.borrow.store") }}',
            method: 'POST',
            data: formData,
            dataType: 'json',
            beforeSend: function(xhr) {
                console.log('=== AJAX BEFORE SEND ===');
                console.log('Request headers:', xhr.getAllResponseHeaders());
            },
            success: function(response) {
                console.log('=== AJAX SUCCESS ===');
                console.log('Form submission response:', response);
                if (response.success) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Peminjaman berhasil diproses',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        resetForm();
                        // Refresh halaman untuk update tabel peminjaman
                        window.location.reload();
                    });
                } else {
                    console.log('=== SUCCESS BUT FAILED ===');
                    console.log('Response message:', response.message);
                    Swal.fire({
                        title: 'Gagal!',
                        text: response.message,
                        icon: 'error'
                    });
                }
            },
            error: function(xhr) {
                console.log('=== AJAX ERROR ===');
                console.error('Form submission error:', xhr);
                console.error('Status:', xhr.status);
                console.error('Status Text:', xhr.statusText);
                console.error('Response text:', xhr.responseText);
                console.error('Response JSON:', xhr.responseJSON);

                let errorMessage = 'Terjadi kesalahan saat memproses peminjaman';

                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    // Validation errors
                    console.log('=== VALIDATION ERRORS ===');
                    const errors = xhr.responseJSON.errors;
                    console.log('Validation errors:', errors);
                    if (errors.id_user) {
                        showError('userError', errors.id_user[0]);
                    }
                    if (errors.id_buku) {
                        showError('bookError', errors.id_buku[0]);
                    }
                    errorMessage = 'Data yang dimasukkan tidak valid';
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.status === 500) {
                    errorMessage = 'Terjadi kesalahan server. Silakan coba lagi.';
                } else if (xhr.status === 403) {
                    errorMessage = 'Akses ditolak. Silakan login ulang.';
                } else if (xhr.status === 401) {
                    errorMessage = 'Sesi login telah berakhir. Silakan login ulang.';
                } else if (xhr.status === 419) {
                    errorMessage = 'Token keamanan tidak valid. Silakan refresh halaman.';
                }

                Swal.fire({
                    title: 'Error!',
                    text: errorMessage,
                    icon: 'error'
                });
            },
            complete: function() {
                console.log('=== AJAX COMPLETE ===');
                $('#submitBtn').prop('disabled', false).html('<i class="bi bi-check-circle me-2"></i>Proses Peminjaman');
            }
        });
    }

    function resetForm() {
        $('#borrowForm')[0].reset();
        clearError('userError');
        clearError('bookError');

        // Reset dates
        $('#tanggal_pinjam').val('{{ date("Y-m-d") }}');
        const defaultReturnDate = new Date();
        defaultReturnDate.setDate(defaultReturnDate.getDate() + 7);
        $('#batas_kembali').val(defaultReturnDate.toISOString().split('T')[0]);

        // Reset status and denda
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

    // Initialize form
    resetForm();
});
</script>
@endpush
