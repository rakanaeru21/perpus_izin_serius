@extends('layouts.dashboard')

@section('title', 'Manajemen Buku - Admin')
@section('page-title', 'Manajemen Buku')
@section('user-name', 'Administrator')
@section('user-role', 'Admin')

@section('sidebar-menu')
    <li class="nav-item">
        <a class="nav-link " href="{{ route('dashboard.admin') }}">
            <i class="bi bi-speedometer2 me-2"></i>
            Dashboard
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" href="{{ route('admin.books') }}">
            <i class="bi bi-book me-2"></i>
            Manajemen Buku
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.members') }}">
            <i class="bi bi-people me-2"></i>
            Manajemen Anggota
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="bi bi-person-badge me-2"></i>
            Manajemen Petugas
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="bi bi-arrow-left-right me-2"></i>
            Transaksi Pinjaman
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.reports') }}">
            <i class="bi bi-bar-chart me-2"></i>
            Laporan
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="bi bi-gear me-2"></i>
            Pengaturan Sistem
        </a>
    </li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-book text-primary me-2"></i>
                    Manajemen Buku
                </h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <div>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBookModal">
                            <i class="bi bi-plus-circle me-1"></i>
                            Tambah Buku Baru
                        </button>
                        <button class="btn btn-outline-success">
                            <i class="bi bi-download me-1"></i>
                            Import Buku
                        </button>
                        <button class="btn btn-outline-info" onclick="generateBookCode()">
                            <i class="bi bi-qr-code me-1"></i>
                            Generate Kode
                        </button>
                    </div>
                    <div class="d-flex gap-2">
                        <select class="form-select" id="categoryFilter" style="width: auto;">
                            <option value="">Semua Kategori</option>
                            <option value="Fiksi">Fiksi</option>
                            <option value="Non-Fiksi">Non-Fiksi</option>
                            <option value="Teknologi">Teknologi</option>
                            <option value="Sejarah">Sejarah</option>
                            <option value="Sains">Sains</option>
                            <option value="Ekonomi">Ekonomi</option>
                        </select>
                        <input type="text" class="form-control" id="searchBooks" placeholder="Cari buku..." style="width: 250px;">
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover" id="booksTable">
                        <thead class="table-light">
                            <tr>
                                <th>Cover</th>
                                <th>Kode Buku</th>
                                <th>Judul</th>
                                <th>Penulis</th>
                                <th>Kategori</th>
                                <th>Tahun</th>
                                <th>Rak</th>
                                <th>Total</th>
                                <th>Tersedia</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($books) && $books->count() > 0)
                                @foreach($books as $book)
                                <tr>
                                    <td>
                                        @if($book->cover && $book->cover !== 'default_cover.png')
                                            <img src="{{ asset('storage/covers/' . $book->cover) }}" 
                                                 alt="Cover" 
                                                 class="rounded" 
                                                 style="width: 40px; height: 50px; object-fit: cover;"
                                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                            <div class="bg-secondary rounded align-items-center justify-content-center text-white" 
                                                 style="width: 40px; height: 50px; font-size: 10px; display: none;">
                                                No Cover
                                            </div>
                                        @else
                                            <div class="bg-secondary rounded d-flex align-items-center justify-content-center text-white" 
                                                 style="width: 40px; height: 50px; font-size: 10px;">
                                                No Cover
                                            </div>
                                        @endif
                                    </td>
                                    <td><strong>{{ $book->kode_buku }}</strong></td>
                                    <td>
                                        <div class="fw-bold">{{ $book->judul_buku }}</div>
                                        @if($book->penerbit)
                                            <small class="text-muted">{{ $book->penerbit }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $book->penulis }}</td>
                                    <td>
                                        @if($book->kategori)
                                            <span class="badge bg-secondary">{{ $book->kategori }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $book->tahun_terbit ?: '-' }}</td>
                                    <td>{{ $book->rak ?: '-' }}</td>
                                    <td>{{ $book->jumlah_total }}</td>
                                    <td>{{ $book->jumlah_tersedia }}</td>
                                    <td>
                                        @if($book->jumlah_tersedia > 0)
                                            <span class="badge bg-success">Tersedia</span>
                                        @else
                                            <span class="badge bg-danger">Habis</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-outline-primary" 
                                                    onclick="viewBook({{ $book->id_buku }})" title="Lihat Detail">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-warning" 
                                                    onclick="editBook({{ $book->id_buku }})" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                                    onclick="deleteBook({{ $book->id_buku }})" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="11" class="text-center text-muted">
                                        <div class="py-4">
                                            <i class="bi bi-book" style="font-size: 3rem;"></i>
                                            <h5 class="mt-2">Belum ada data buku</h5>
                                            <p>Silakan tambahkan buku pertama Anda</p>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Book Modal -->
<div class="modal fade" id="addBookModal" tabindex="-1" aria-labelledby="addBookModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBookModalLabel">
                    <i class="bi bi-plus-circle text-primary me-2"></i>
                    Tambah Buku Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addBookForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="kode_buku" class="form-label">Kode Buku <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="kode_buku" name="kode_buku" required>
                                <button class="btn btn-outline-secondary" type="button" onclick="generateBookCode()">
                                    <i class="bi bi-arrow-clockwise"></i>
                                </button>
                            </div>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="kategori" class="form-label">Kategori</label>
                            <select class="form-select" id="kategori" name="kategori">
                                <option value="">Pilih Kategori</option>
                                <option value="Fiksi">Fiksi</option>
                                <option value="Non-Fiksi">Non-Fiksi</option>
                                <option value="Teknologi">Teknologi</option>
                                <option value="Sejarah">Sejarah</option>
                                <option value="Sains">Sains</option>
                                <option value="Ekonomi">Ekonomi</option>
                                <option value="Pendidikan">Pendidikan</option>
                                <option value="Agama">Agama</option>
                                <option value="Biografis">Biografis</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="judul_buku" class="form-label">Judul Buku <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="judul_buku" name="judul_buku" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="penulis" class="form-label">Penulis <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="penulis" name="penulis" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="penerbit" class="form-label">Penerbit</label>
                            <input type="text" class="form-control" id="penerbit" name="penerbit">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
                            <input type="number" class="form-control" id="tahun_terbit" name="tahun_terbit" 
                                   min="1900" max="{{ date('Y') }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="jumlah_total" class="form-label">Jumlah Total <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="jumlah_total" name="jumlah_total" 
                                   min="1" value="1" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="jumlah_tersedia" class="form-label">Jumlah Tersedia <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="jumlah_tersedia" name="jumlah_tersedia" 
                                   min="0" value="1" required>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="rak" class="form-label">Lokasi Rak</label>
                        <input type="text" class="form-control" id="rak" name="rak" placeholder="Contoh: A-01, B-15">
                    </div>
                    
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" 
                                  placeholder="Deskripsi singkat tentang buku..."></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="cover" class="form-label">Cover Buku</label>
                        <input type="file" class="form-control" id="cover" name="cover" 
                               accept="image/jpeg,image/png,image/jpg,image/gif">
                        <div class="form-text">Format: JPG, PNG, GIF. Maksimal 2MB.</div>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>
                        Simpan Buku
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Book Modal -->
<div class="modal fade" id="viewBookModal" tabindex="-1" aria-labelledby="viewBookModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewBookModalLabel">
                    <i class="bi bi-eye text-info me-2"></i>
                    Detail Buku
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="viewBookContent">
                <!-- Content will be loaded dynamically -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// CSRF Token setup for AJAX
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// Add Book Form Submission
$('#addBookForm').on('submit', function(e) {
    e.preventDefault();
    
    let formData = new FormData(this);
    let submitBtn = $(this).find('button[type="submit"]');
    let originalText = submitBtn.html();
    
    // Debug: Check if file is selected
    let fileInput = $('#cover')[0];
    if (fileInput.files.length > 0) {
        console.log('File selected:', fileInput.files[0].name);
        console.log('File size:', fileInput.files[0].size);
    } else {
        console.log('No file selected');
    }
    
    // Debug: Log form data
    for (let pair of formData.entries()) {
        console.log(pair[0] + ': ' + pair[1]);
    }
    
    // Show loading state
    submitBtn.html('<i class="bi bi-hourglass-split me-1"></i> Menyimpan...').prop('disabled', true);
    
    // Clear previous errors
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').empty();
    
    $.ajax({
        url: '{{ route("admin.books.store") }}',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.success) {
                $('#addBookModal').modal('hide');
                $('#addBookForm')[0].reset();
                
                // Show success message
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: response.message,
                    timer: 2000,
                    showConfirmButton: false
                });
                
                // Reload page to show new data
                setTimeout(function() {
                    location.reload();
                }, 2000);
            }
        },
        error: function(xhr) {
            if (xhr.status === 422) {
                // Validation errors
                let errors = xhr.responseJSON.errors;
                for (let field in errors) {
                    $(`#${field}`).addClass('is-invalid');
                    $(`#${field}`).siblings('.invalid-feedback').text(errors[field][0]);
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: xhr.responseJSON?.message || 'Terjadi kesalahan saat menyimpan data'
                });
            }
        },
        complete: function() {
            // Restore button state
            submitBtn.html(originalText).prop('disabled', false);
        }
    });
});

// Generate Book Code
function generateBookCode() {
    $.ajax({
        url: '/dashboard/admin/books/generate-code',
        type: 'GET',
        success: function(response) {
            if (response.success) {
                $('#kode_buku').val(response.code);
            }
        },
        error: function() {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Gagal generate kode buku'
            });
        }
    });
}

// View Book Details
function viewBook(id) {
    $.ajax({
        url: `/dashboard/admin/books/${id}`,
        type: 'GET',
        success: function(response) {
            if (response.success) {
                let book = response.book;
                let content = `
                    <div class="row">
                        <div class="col-md-4 text-center">
                            ${book.cover && book.cover !== 'default_cover.png' ? 
                                `<img src="/storage/covers/${book.cover}" 
                                     alt="Cover" class="img-fluid rounded shadow"
                                     style="max-height: 300px;"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                 <div class="bg-secondary rounded align-items-center justify-content-center text-white" 
                                      style="width: 200px; height: 300px; margin: 0 auto; display: none;">
                                     <div class="text-center">
                                         <i class="bi bi-book" style="font-size: 3rem;"></i><br>
                                         No Cover Available
                                     </div>
                                 </div>` :
                                `<div class="bg-secondary rounded d-flex align-items-center justify-content-center text-white" 
                                     style="width: 200px; height: 300px; margin: 0 auto;">
                                    <div class="text-center">
                                        <i class="bi bi-book" style="font-size: 3rem;"></i><br>
                                        No Cover Available
                                    </div>
                                </div>`
                            }
                        </div>
                        <div class="col-md-8">
                            <table class="table table-borderless">
                                <tr><td><strong>Kode Buku:</strong></td><td>${book.kode_buku}</td></tr>
                                <tr><td><strong>Judul:</strong></td><td>${book.judul_buku}</td></tr>
                                <tr><td><strong>Penulis:</strong></td><td>${book.penulis}</td></tr>
                                <tr><td><strong>Penerbit:</strong></td><td>${book.penerbit || '-'}</td></tr>
                                <tr><td><strong>Tahun Terbit:</strong></td><td>${book.tahun_terbit || '-'}</td></tr>
                                <tr><td><strong>Kategori:</strong></td><td>${book.kategori || '-'}</td></tr>
                                <tr><td><strong>Rak:</strong></td><td>${book.rak || '-'}</td></tr>
                                <tr><td><strong>Jumlah Total:</strong></td><td>${book.jumlah_total}</td></tr>
                                <tr><td><strong>Jumlah Tersedia:</strong></td><td>${book.jumlah_tersedia}</td></tr>
                                <tr><td><strong>Tanggal Input:</strong></td><td>${new Date(book.tanggal_input).toLocaleDateString('id-ID')}</td></tr>
                            </table>
                            ${book.deskripsi ? `<div class="mt-3"><strong>Deskripsi:</strong><br>${book.deskripsi}</div>` : ''}
                        </div>
                    </div>
                `;
                $('#viewBookContent').html(content);
                $('#viewBookModal').modal('show');
            }
        },
        error: function() {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Gagal mengambil data buku'
            });
        }
    });
}

// Edit Book (placeholder)
function editBook(id) {
    Swal.fire({
        icon: 'info',
        title: 'Coming Soon',
        text: 'Fitur edit akan segera tersedia'
    });
}

// Delete Book
function deleteBook(id) {
    Swal.fire({
        title: 'Hapus Buku?',
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/dashboard/admin/books/${id}`,
                type: 'DELETE',
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                        
                        // Remove row from table
                        $(`button[onclick="deleteBook(${id})"]`).closest('tr').fadeOut();
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: xhr.responseJSON?.message || 'Gagal menghapus buku'
                    });
                }
            });
        }
    });
}

// Search Books
$('#searchBooks').on('input', debounce(function() {
    let query = $(this).val();
    searchBooks(query);
}, 300));

// Category Filter
$('#categoryFilter').on('change', function() {
    let category = $(this).val();
    filterByCategory(category);
});

// Search function
function searchBooks(query) {
    if (query.length === 0) {
        location.reload();
        return;
    }
    
    $.ajax({
        url: '/dashboard/admin/books/search',
        type: 'GET',
        data: { q: query },
        success: function(response) {
            if (response.success) {
                updateBooksTable(response.books);
            }
        },
        error: function() {
            console.error('Search failed');
        }
    });
}

// Update table with new data
function updateBooksTable(books) {
    let tbody = $('#booksTable tbody');
    tbody.empty();
    
    if (books.length === 0) {
        tbody.append(`
            <tr>
                <td colspan="11" class="text-center text-muted">
                    <div class="py-4">
                        <i class="bi bi-search" style="font-size: 3rem;"></i>
                        <h5 class="mt-2">Tidak ada data ditemukan</h5>
                        <p>Coba gunakan kata kunci lain</p>
                    </div>
                </td>
            </tr>
        `);
        return;
    }
    
    books.forEach(function(book) {
        let statusBadge = book.jumlah_tersedia > 0 
            ? '<span class="badge bg-success">Tersedia</span>' 
            : '<span class="badge bg-danger">Habis</span>';
            
        let categoryBadge = book.kategori 
            ? `<span class="badge bg-secondary">${book.kategori}</span>` 
            : '<span class="text-muted">-</span>';
        
        tbody.append(`
            <tr>
                <td>
                    ${book.cover && book.cover !== 'default_cover.png' ? 
                        `<img src="/storage/covers/${book.cover}" 
                             alt="Cover" 
                             class="rounded" 
                             style="width: 40px; height: 50px; object-fit: cover;"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                         <div class="bg-secondary rounded align-items-center justify-content-center text-white" 
                              style="width: 40px; height: 50px; font-size: 10px; display: none;">
                             No Cover
                         </div>` :
                        `<div class="bg-secondary rounded d-flex align-items-center justify-content-center text-white" 
                             style="width: 40px; height: 50px; font-size: 10px;">
                            No Cover
                        </div>`
                    }
                </td>
                <td><strong>${book.kode_buku}</strong></td>
                <td>
                    <div class="fw-bold">${book.judul_buku}</div>
                    ${book.penerbit ? `<small class="text-muted">${book.penerbit}</small>` : ''}
                </td>
                <td>${book.penulis}</td>
                <td>${categoryBadge}</td>
                <td>${book.tahun_terbit || '-'}</td>
                <td>${book.rak || '-'}</td>
                <td>${book.jumlah_total}</td>
                <td>${book.jumlah_tersedia}</td>
                <td>${statusBadge}</td>
                <td>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-sm btn-outline-primary" 
                                onclick="viewBook(${book.id_buku})" title="Lihat Detail">
                            <i class="bi bi-eye"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-warning" 
                                onclick="editBook(${book.id_buku})" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger" 
                                onclick="deleteBook(${book.id_buku})" title="Hapus">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `);
    });
}

// Debounce function for search
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Auto-sync jumlah_tersedia with jumlah_total
$('#jumlah_total').on('input', function() {
    let total = parseInt($(this).val()) || 0;
    let tersedia = parseInt($('#jumlah_tersedia').val()) || 0;
    
    if (tersedia > total) {
        $('#jumlah_tersedia').val(total);
    }
});

// Initialize tooltips
$(document).ready(function() {
    $('[title]').tooltip();
    
    // Generate code on modal open if field is empty
    $('#addBookModal').on('shown.bs.modal', function() {
        if ($('#kode_buku').val() === '') {
            generateBookCode();
        }
    });
});
</script>

<!-- Include SweetAlert2 for better alerts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush