@extends('layouts.dashboard')

@section('title', 'Katalog Buku - Anggota')
@section('page-title', 'Katalog Buku')
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
        <a class="nav-link active" href="{{ route('anggota.catalog') }}">
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
<!-- Search Bar -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <input type="text" class="form-control form-control-lg" id="searchInput" placeholder="Cari judul buku, penulis, atau kategori...">
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-primary btn-lg w-100" id="searchBtn">
                            <i class="bi bi-search me-2"></i>
                            Cari Buku
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h6 class="card-title mb-0">
                    <i class="bi bi-funnel me-2"></i>
                    Filter & Pencarian
                </h6>
                <button class="btn btn-outline-secondary btn-sm" id="resetFilters">
                    <i class="bi bi-arrow-clockwise me-1"></i>
                    Reset
                </button>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <label class="form-label">Kategori</label>
                        <select class="form-select" id="categoryFilter">
                            <option value="">Semua Kategori</option>
                            <option value="fiksi">Fiksi</option>
                            <option value="non-fiksi">Non-Fiksi</option>
                            <option value="sains">Sains</option>
                            <option value="teknologi">Teknologi</option>
                            <option value="sejarah">Sejarah</option>
                            <option value="biografi">Biografi</option>
                            <option value="pendidikan">Pendidikan</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-2">
                        <label class="form-label">Tahun Terbit</label>
                        <select class="form-select" id="yearFilter">
                            <option value="">Semua Tahun</option>
                            <option value="2023">2023</option>
                            <option value="2022">2022</option>
                            <option value="2021">2021</option>
                            <option value="2020">2020</option>
                            <option value="2019">2019</option>
                            <option value="older">Sebelum 2019</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-2">
                        <label class="form-label">Status</label>
                        <select class="form-select" id="statusFilter">
                            <option value="">Semua Buku</option>
                            <option value="available">Tersedia</option>
                            <option value="borrowed">Dipinjam</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-2">
                        <label class="form-label">Urutkan</label>
                        <select class="form-select" id="sortFilter">
                            <option value="newest">Terbaru</option>
                            <option value="oldest">Terlama</option>
                            <option value="title">Judul A-Z</option>
                            <option value="title_desc">Judul Z-A</option>
                            <option value="author">Penulis A-Z</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Bar -->
<div class="row mb-4">
    <div class="col-12">
        <div class="alert alert-info d-flex justify-content-between align-items-center">
            <div>
                <i class="bi bi-info-circle me-2"></i>
                <span id="catalogStats">Menampilkan semua buku dalam katalog</span>
            </div>
            <div>
                <span class="badge bg-primary" id="totalBooks">0 Buku</span>
            </div>
        </div>
    </div>
</div>

<!-- Book Catalog -->
<div class="row" id="bookCatalog">
    <!-- Loading state -->
    <div class="col-12" id="loadingState">
        <div class="card">
            <div class="card-body text-center py-5">
                <div class="spinner-border text-primary mb-3" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="text-muted">Memuat katalog buku...</p>
            </div>
        </div>
    </div>

    <!-- Empty state -->
    <div class="col-12 d-none" id="emptyState">
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="bi bi-book text-muted mb-3" style="font-size: 3rem;"></i>
                <h5 class="text-muted">Tidak ada buku ditemukan</h5>
                <p class="text-muted">Coba ubah kata kunci pencarian atau filter Anda</p>
                <button class="btn btn-primary" id="resetSearch">
                    <i class="bi bi-arrow-clockwise me-2"></i>
                    Reset Pencarian
                </button>
            </div>
        </div>
    </div>

    <!-- Book results will be loaded here -->
</div>

<!-- Pagination -->
<div class="row mt-4">
    <div class="col-12">
        <nav aria-label="Catalog pagination">
            <ul class="pagination justify-content-center" id="catalogPagination">
                <!-- Pagination will be loaded here -->
            </ul>
        </nav>
    </div>
</div>
@endsection

@push('styles')
<style>
.book-cover-container {
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.book-cover-container:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.book-cover-img {
    transition: transform 0.2s ease;
}

.book-cover-img:hover {
    transform: scale(1.05);
}

.card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
}

.badge {
    font-size: 0.7rem;
}

.book-cover-container .bg-gradient {
    box-shadow: inset 0 0 20px rgba(0,0,0,0.1);
}

/* Rating Stars Styles */
.rating-stars {
    display: flex;
    gap: 2px;
}

.rating-stars .star {
    font-size: 1.2rem;
    cursor: pointer;
    transition: all 0.2s ease;
    color: #6c757d;
}

.rating-stars .star:hover {
    transform: scale(1.1);
}

.rating-stars .star.bi-star-fill {
    color: #ffc107 !important;
}

/* Comment Item Styles */
.comment-item {
    transition: background-color 0.2s ease;
}

.comment-item:hover {
    background-color: rgba(0,0,0,0.02);
    border-radius: 8px;
    padding-left: 15px !important;
    padding-right: 15px !important;
}

.comment-item:last-child {
    border-bottom: none !important;
}

/* Modal Enhancements */
.modal-dialog {
    max-width: 800px;
}

.modal-body {
    max-height: 70vh;
    overflow-y: auto;
}

/* Button hover effects */
.btn-outline-success:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 5px rgba(25, 135, 84, 0.2);
}

.btn-outline-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 5px rgba(13, 110, 253, 0.2);
}

.btn-outline-danger:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 5px rgba(220, 53, 69, 0.2);
}

.btn-danger:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
}

/* Favorite button animations */
.favorite-btn {
    transition: all 0.2s ease;
}

.favorite-btn:hover {
    transform: translateY(-1px) scale(1.05);
}

.favorite-btn.btn-danger {
    background: linear-gradient(45deg, #dc3545, #ff6b7d);
    border: none;
    color: white;
}

.favorite-btn.btn-danger:hover {
    background: linear-gradient(45deg, #c82333, #ff5a6b);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .modal-dialog {
        max-width: 95%;
        margin: 10px auto;
    }

    .rating-stars .star {
        font-size: 1rem;
    }

    .comment-item {
        padding-left: 10px !important;
        padding-right: 10px !important;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentBooks = [];
    let currentPage = 1;
    let totalPages = 1;
    let isLoading = false;
    const booksPerPage = 6;

    // Initialize catalog
    loadCatalog();

    // Search functionality
    document.getElementById('searchBtn').addEventListener('click', performSearch);
    document.getElementById('searchInput').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            performSearch();
        }
    });

    // Filter functionality
    document.getElementById('categoryFilter').addEventListener('change', applyFilters);
    document.getElementById('yearFilter').addEventListener('change', applyFilters);
    document.getElementById('statusFilter').addEventListener('change', applyFilters);
    document.getElementById('sortFilter').addEventListener('change', applyFilters);

    // Reset filters
    document.getElementById('resetFilters').addEventListener('click', resetFilters);
    document.getElementById('resetSearch').addEventListener('click', resetSearch);

    function loadCatalog() {
        fetchBooks();
    }

    function performSearch() {
        currentPage = 1;
        fetchBooks();
    }

    function applyFilters() {
        currentPage = 1;
        fetchBooks();
    }

    function fetchBooks() {
        if (isLoading) return;

        isLoading = true;
        showLoadingState();

        const searchTerm = document.getElementById('searchInput').value;
        const category = document.getElementById('categoryFilter').value;
        const year = document.getElementById('yearFilter').value;
        const status = document.getElementById('statusFilter').value;
        const sort = document.getElementById('sortFilter').value;

        // Build query parameters
        const params = new URLSearchParams({
            page: currentPage,
            per_page: booksPerPage,
            search: searchTerm,
            category: category,
            year: year,
            status: status,
            sort: sort
        });

        // Fetch data from API
        fetch(`{{ route('anggota.catalog.api') }}?${params.toString()}`)
            .then(response => response.json())
            .then(data => {
                isLoading = false;
                hideLoadingState();

                if (data.success) {
                    currentBooks = data.data.books;
                    totalPages = data.data.pagination.total_pages;

                    renderBooks(currentBooks);
                    renderPagination(data.data.pagination);
                    updateStats(data.data.pagination.total);
                } else {
                    console.error('Error fetching books:', data.message);
                    showEmptyState();
                    updateStats(0);
                }
            })
            .catch(error => {
                isLoading = false;
                hideLoadingState();
                console.error('Fetch error:', error);
                showEmptyState();
                updateStats(0);
            });
    }

    function showLoadingState() {
        document.getElementById('loadingState').classList.remove('d-none');
        document.getElementById('emptyState').classList.add('d-none');
        const catalog = document.getElementById('bookCatalog');
        const existingBooks = catalog.querySelectorAll('.col-lg-4');
        existingBooks.forEach(book => book.remove());
    }

    function hideLoadingState() {
        document.getElementById('loadingState').classList.add('d-none');
    }

    function showEmptyState() {
        const catalog = document.getElementById('bookCatalog');
        const emptyState = document.getElementById('emptyState');

        // Clear existing books
        const existingBooks = catalog.querySelectorAll('.col-lg-4');
        existingBooks.forEach(book => book.remove());

        // Show empty state
        if (!catalog.contains(emptyState)) {
            catalog.appendChild(emptyState);
        }
        emptyState.classList.remove('d-none');
    }

    function renderBooks(books) {
        const catalog = document.getElementById('bookCatalog');
        const emptyState = document.getElementById('emptyState');

        if (books.length === 0) {
            showEmptyState();
            return;
        }

        emptyState.classList.add('d-none');

        // Clear existing book cards but keep loading and empty states
        const existingBooks = catalog.querySelectorAll('.col-lg-4');
        existingBooks.forEach(book => book.remove());

        // Render new books
        books.forEach(book => {
            const bookCard = document.createElement('div');
            bookCard.className = 'col-lg-4 col-md-6 mb-4';

            // Determine cover image source
            const coverSrc = book.cover && book.cover !== 'default_cover.png'
                ? `/storage/covers/${book.cover}`
                : null;

            const coverHtml = coverSrc
                ? `<img src="${coverSrc}"
                        alt="Cover ${book.judul_buku}"
                        class="book-cover-img"
                        style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;"
                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                   <div class="bg-gradient text-white rounded d-flex align-items-center justify-content-center" style="display: none; height: 100%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                       <i class="bi bi-book" style="font-size: 2rem;"></i>
                   </div>`
                : `<div class="bg-gradient text-white rounded d-flex align-items-center justify-content-center" style="height: 100%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                       <i class="bi bi-book" style="font-size: 2rem;"></i>
                   </div>`;

            bookCard.innerHTML = `
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <div class="book-cover-container" style="height: 120px; position: relative; overflow: hidden; border-radius: 8px;">
                                    ${coverHtml}
                                </div>
                            </div>
                            <div class="col-8">
                                <h6 class="card-title mb-2" title="${book.judul_buku}">${book.judul_buku.length > 40 ? book.judul_buku.substring(0, 40) + '...' : book.judul_buku}</h6>
                                <p class="card-text small text-muted mb-1">
                                    <i class="bi bi-person me-1"></i>${book.penulis.length > 25 ? book.penulis.substring(0, 25) + '...' : book.penulis}
                                </p>
                                <p class="card-text small text-muted mb-1">
                                    <i class="bi bi-calendar me-1"></i>${book.tahun_terbit || 'N/A'}
                                </p>
                                <p class="card-text small text-muted mb-2">
                                    <i class="bi bi-tag me-1"></i>${book.kategori ? book.kategori.charAt(0).toUpperCase() + book.kategori.slice(1) : 'Tidak ada kategori'}
                                </p>
                                ${book.average_rating > 0 ? `
                                <p class="card-text small text-muted mb-2">
                                    <i class="bi bi-star-fill text-warning me-1"></i>${book.average_rating.toFixed(1)} (${book.comments_count} ulasan)
                                </p>
                                ` : ''}
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge ${book.jumlah_tersedia > 0 ? 'bg-success' : 'bg-danger'}">
                                        ${book.jumlah_tersedia > 0 ? 'Tersedia' : 'Tidak Tersedia'}
                                    </span>
                                    <small class="text-muted">${book.jumlah_tersedia}/${book.jumlah_total}</small>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <div class="row g-2">
                                <div class="col-6">
                                    <button class="btn btn-outline-primary btn-sm w-100"
                                            onclick="lihatDetailBuku(${book.id_buku})"
                                            title="Klik untuk melihat detail buku">
                                        <i class="bi bi-eye me-1"></i>
                                        Detail
                                    </button>
                                </div>
                                <div class="col-3">
                                    <button class="btn btn-outline-success btn-sm w-100"
                                            onclick="lihatKomentarBuku(${book.id_buku})"
                                            title="Klik untuk melihat dan memberikan komentar">
                                        <i class="bi bi-chat-dots"></i>
                                    </button>
                                </div>
                                <div class="col-3">
                                    <button class="btn btn-outline-danger btn-sm w-100 favorite-btn"
                                            data-book-id="${book.id_buku}"
                                            title="Tambah ke favorit">
                                        <i class="bi bi-heart"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            catalog.appendChild(bookCard);
        });

        // Initialize favorite buttons after rendering
        initializeFavoriteButtons();

        // Check favorite status for all books
        checkFavoriteStatus();
    }

    function renderPagination(pagination) {
        const paginationContainer = document.getElementById('catalogPagination');

        if (pagination.total_pages <= 1) {
            paginationContainer.innerHTML = '';
            return;
        }

        let paginationHTML = '';

        // Previous button
        paginationHTML += `
            <li class="page-item ${!pagination.has_prev ? 'disabled' : ''}">
                <a class="page-link" href="#" data-page="${pagination.current_page - 1}">Previous</a>
            </li>
        `;

        // Page numbers
        for (let i = 1; i <= pagination.total_pages; i++) {
            paginationHTML += `
                <li class="page-item ${i === pagination.current_page ? 'active' : ''}">
                    <a class="page-link" href="#" data-page="${i}">${i}</a>
                </li>
            `;
        }

        // Next button
        paginationHTML += `
            <li class="page-item ${!pagination.has_next ? 'disabled' : ''}">
                <a class="page-link" href="#" data-page="${pagination.current_page + 1}">Next</a>
            </li>
        `;

        paginationContainer.innerHTML = paginationHTML;

        // Add event listeners to pagination links
        paginationContainer.addEventListener('click', function(e) {
            e.preventDefault();
            if (e.target.classList.contains('page-link') && !e.target.parentElement.classList.contains('disabled')) {
                currentPage = parseInt(e.target.dataset.page);
                fetchBooks();
            }
        });
    }

    function updateStats(totalCount = 0) {
        document.getElementById('totalBooks').textContent = `${totalCount} Buku`;

        const searchTerm = document.getElementById('searchInput').value;
        const hasFilters = document.getElementById('categoryFilter').value ||
                          document.getElementById('yearFilter').value ||
                          document.getElementById('statusFilter').value ||
                          searchTerm;

        if (hasFilters) {
            document.getElementById('catalogStats').textContent = `Menampilkan ${totalCount} buku hasil pencarian/filter`;
        } else {
            document.getElementById('catalogStats').textContent = `Menampilkan semua buku dalam katalog`;
        }
    }

    function resetFilters() {
        document.getElementById('categoryFilter').value = '';
        document.getElementById('yearFilter').value = '';
        document.getElementById('statusFilter').value = '';
        document.getElementById('sortFilter').value = 'newest';
        currentPage = 1;
        fetchBooks();
    }

    function resetSearch() {
        document.getElementById('searchInput').value = '';
        resetFilters();
    }

    // Function to handle book detail viewing
    window.lihatDetailBuku = function(bookId) {
        // Find the book data
        const book = currentBooks.find(b => b.id_buku == bookId);

        if (book) {
            // Create and show modal with book details
            showBookDetailModal(book);
        } else {
            alert('Detail buku tidak ditemukan!');
        }
    };

    // Function to create and show book detail modal
    function showBookDetailModal(book) {
        // Remove existing modal if any
        const existingModal = document.getElementById('bookDetailModal');
        if (existingModal) {
            existingModal.remove();
        }

        // Create modal HTML
        const modalHtml = `
            <div class="modal fade" id="bookDetailModal" tabindex="-1" aria-labelledby="bookDetailModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="bookDetailModalLabel">Detail Buku</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="book-cover-container" style="height: 250px; position: relative; overflow: hidden; border-radius: 8px;">
                                        ${book.cover && book.cover !== 'default_cover.png'
                                            ? `<img src="/storage/covers/${book.cover}"
                                                    alt="Cover ${book.judul_buku}"
                                                    style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;"
                                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                               <div class="bg-gradient text-white rounded d-flex align-items-center justify-content-center" style="display: none; height: 100%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                                   <i class="bi bi-book" style="font-size: 3rem;"></i>
                                               </div>`
                                            : `<div class="bg-gradient text-white rounded d-flex align-items-center justify-content-center" style="height: 100%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                                   <i class="bi bi-book" style="font-size: 3rem;"></i>
                                               </div>`
                                        }
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h4 class="mb-3">${book.judul_buku}</h4>
                                    <div class="row mb-2">
                                        <div class="col-4"><strong>Kode Buku:</strong></div>
                                        <div class="col-8">${book.kode_buku}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-4"><strong>Penulis:</strong></div>
                                        <div class="col-8">${book.penulis}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-4"><strong>Penerbit:</strong></div>
                                        <div class="col-8">${book.penerbit || 'Tidak diketahui'}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-4"><strong>Tahun Terbit:</strong></div>
                                        <div class="col-8">${book.tahun_terbit || 'Tidak diketahui'}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-4"><strong>Kategori:</strong></div>
                                        <div class="col-8">
                                            <span class="badge bg-secondary">${book.kategori ? book.kategori.charAt(0).toUpperCase() + book.kategori.slice(1) : 'Tidak ada kategori'}</span>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-4"><strong>Rak:</strong></div>
                                        <div class="col-8">${book.rak || 'Tidak diketahui'}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-4"><strong>Status:</strong></div>
                                        <div class="col-8">
                                            <span class="badge ${book.jumlah_tersedia > 0 ? 'bg-success' : 'bg-danger'}">
                                                ${book.jumlah_tersedia > 0 ? 'Tersedia' : 'Tidak Tersedia'}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-4"><strong>Ketersediaan:</strong></div>
                                        <div class="col-8">${book.jumlah_tersedia} dari ${book.jumlah_total} buku</div>
                                    </div>
                                    ${book.deskripsi ? `
                                    <div class="mb-3">
                                        <strong>Deskripsi:</strong>
                                        <p class="mt-2 text-muted">${book.deskripsi}</p>
                                    </div>
                                    ` : ''}
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="button" class="btn btn-primary ${book.jumlah_tersedia === 0 ? 'disabled' : ''}"
                                    ${book.jumlah_tersedia === 0 ? 'disabled' : ''}
                                    onclick="pinjamBuku(${book.id_buku}); closeModal();">
                                <i class="bi bi-plus-circle me-1"></i>
                                ${book.jumlah_tersedia > 0 ? 'Pinjam Buku' : 'Tidak Tersedia'}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Add modal to body
        document.body.insertAdjacentHTML('beforeend', modalHtml);

        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('bookDetailModal'));
        modal.show();

        // Clean up when modal is closed
        document.getElementById('bookDetailModal').addEventListener('hidden.bs.modal', function() {
            this.remove();
        });
    }

    // Function to close modal
    function closeModal() {
        const modal = bootstrap.Modal.getInstance(document.getElementById('bookDetailModal'));
        if (modal) {
            modal.hide();
        }
    }

    // Function to handle book borrowing (placeholder)
    window.pinjamBuku = function(bookId) {
        // This would typically open a borrowing form or redirect to borrowing page
        alert(`Fitur peminjaman buku ID ${bookId} akan segera tersedia!`);
        console.log('Pinjam buku dengan ID:', bookId);
    };

    // Function to handle book comments
    window.lihatKomentarBuku = function(bookId) {
        // Find the book data
        const book = currentBooks.find(b => b.id_buku == bookId);

        if (book) {
            // Create and show comments modal
            showCommentsModal(book);
        } else {
            alert('Buku tidak ditemukan!');
        }
    };

    // Function to create and show comments modal
    function showCommentsModal(book) {
        // Remove existing modal if any
        const existingModal = document.getElementById('commentsModal');
        if (existingModal) {
            existingModal.remove();
        }

        // Create comments modal HTML
        const modalHtml = `
            <div class="modal fade" id="commentsModal" tabindex="-1" aria-labelledby="commentsModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="commentsModalLabel">
                                <i class="bi bi-chat-dots me-2"></i>
                                Komentar untuk "${book.judul_buku}"
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Add Comment Form -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">
                                        <i class="bi bi-plus-circle me-2"></i>
                                        Tambah Komentar
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <form id="addCommentForm" onsubmit="submitComment(event, ${book.id_buku})">
                                        <div class="mb-3">
                                            <label for="commentRating" class="form-label">Rating</label>
                                            <div class="d-flex align-items-center">
                                                <div class="rating-stars me-3" id="ratingStars">
                                                    <i class="bi bi-star star" data-rating="1"></i>
                                                    <i class="bi bi-star star" data-rating="2"></i>
                                                    <i class="bi bi-star star" data-rating="3"></i>
                                                    <i class="bi bi-star star" data-rating="4"></i>
                                                    <i class="bi bi-star star" data-rating="5"></i>
                                                </div>
                                                <span id="ratingText" class="text-muted">Pilih rating</span>
                                                <input type="hidden" id="selectedRating" name="rating" value="0">
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="commentText" class="form-label">Komentar</label>
                                            <textarea class="form-control" id="commentText" name="comment" rows="4"
                                                    placeholder="Bagikan pendapat Anda tentang buku ini..." required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-send me-1"></i>
                                            Kirim Komentar
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- Comments List -->
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">
                                        <i class="bi bi-chat-text me-2"></i>
                                        Komentar Pengguna
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div id="commentsList">
                                        <div class="text-center py-4">
                                            <div class="spinner-border text-primary mb-3" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                            <p class="text-muted">Memuat komentar...</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Add modal to body
        document.body.insertAdjacentHTML('beforeend', modalHtml);

        // Initialize rating functionality
        initializeRatingSystem();

        // Load existing comments
        loadComments(book.id_buku);

        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('commentsModal'));
        modal.show();

        // Clean up when modal is closed
        document.getElementById('commentsModal').addEventListener('hidden.bs.modal', function() {
            this.remove();
        });
    }

    // Function to initialize rating system
    function initializeRatingSystem() {
        const stars = document.querySelectorAll('.star');
        const ratingText = document.getElementById('ratingText');
        const selectedRating = document.getElementById('selectedRating');
        let currentRating = 0;

        stars.forEach(star => {
            star.addEventListener('click', function() {
                currentRating = parseInt(this.dataset.rating);
                selectedRating.value = currentRating;
                updateStars(currentRating);
                updateRatingText(currentRating);
            });

            star.addEventListener('mouseover', function() {
                const hoverRating = parseInt(this.dataset.rating);
                updateStars(hoverRating);
                updateRatingText(hoverRating);
            });
        });

        document.getElementById('ratingStars').addEventListener('mouseleave', function() {
            updateStars(currentRating);
            updateRatingText(currentRating);
        });

        function updateStars(rating) {
            stars.forEach((star, index) => {
                if (index < rating) {
                    star.classList.remove('bi-star');
                    star.classList.add('bi-star-fill');
                    star.style.color = '#ffc107';
                } else {
                    star.classList.remove('bi-star-fill');
                    star.classList.add('bi-star');
                    star.style.color = '#6c757d';
                }
            });
        }

        function updateRatingText(rating) {
            const texts = {
                0: 'Pilih rating',
                1: 'Sangat Buruk',
                2: 'Buruk',
                3: 'Cukup',
                4: 'Bagus',
                5: 'Sangat Bagus'
            };
            ratingText.textContent = texts[rating];
        }
    }

    // Function to submit comment
    window.submitComment = function(event, bookId) {
        event.preventDefault();

        const rating = document.getElementById('selectedRating').value;
        const commentText = document.getElementById('commentText').value;

        if (rating == 0) {
            alert('Silakan pilih rating terlebih dahulu!');
            return;
        }

        if (!commentText.trim()) {
            alert('Silakan isi komentar terlebih dahulu!');
            return;
        }

        // Show loading state
        const submitBtn = event.target.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i> Mengirim...';
        submitBtn.disabled = true;

        // Prepare form data
        const formData = new FormData();
        formData.append('id_buku', bookId);
        formData.append('rating', rating);
        formData.append('comment', commentText);

        // Get CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        // Send to API
        fetch('{{ route("anggota.books.comments.store") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Reset form
                document.getElementById('addCommentForm').reset();
                document.getElementById('selectedRating').value = 0;
                document.getElementById('ratingText').textContent = 'Pilih rating';
                document.querySelectorAll('.star').forEach(star => {
                    star.classList.remove('bi-star-fill');
                    star.classList.add('bi-star');
                    star.style.color = '#6c757d';
                });

                // Show success message
                alert(data.message);

                // Reload comments
                loadComments(bookId);
            } else {
                alert(data.message || 'Terjadi kesalahan saat mengirim komentar');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mengirim komentar');
        })
        .finally(() => {
            // Reset button
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        });
    };

    // Function to load comments
    function loadComments(bookId) {
        const commentsList = document.getElementById('commentsList');

        // Show loading state
        commentsList.innerHTML = `
            <div class="text-center py-4">
                <div class="spinner-border text-primary mb-3" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="text-muted">Memuat komentar...</p>
            </div>
        `;

        // Fetch comments from API
        fetch(`{{ url('dashboard/anggota/books') }}/${bookId}/comments`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const comments = data.data.comments;

                    if (comments.length === 0) {
                        commentsList.innerHTML = `
                            <div class="text-center py-4">
                                <i class="bi bi-chat-square-text text-muted mb-3" style="font-size: 3rem;"></i>
                                <h6 class="text-muted">Belum ada komentar</h6>
                                <p class="text-muted">Jadilah yang pertama memberikan komentar untuk buku ini!</p>
                            </div>
                        `;
                    } else {
                        let commentsHtml = '';
                        comments.forEach(comment => {
                            const stars = Array(5).fill(0).map((_, i) =>
                                i < comment.rating
                                    ? '<i class="bi bi-star-fill text-warning"></i>'
                                    : '<i class="bi bi-star text-muted"></i>'
                            ).join('');

                            const commentDate = new Date(comment.created_at).toLocaleDateString('id-ID', {
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit'
                            });

                            commentsHtml += `
                                <div class="comment-item border-bottom py-3">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h6 class="mb-1">${comment.user_name}</h6>
                                            <div class="d-flex align-items-center">
                                                <div class="me-2">${stars}</div>
                                                <small class="text-muted">(${comment.rating}/5)</small>
                                            </div>
                                        </div>
                                        <small class="text-muted">${commentDate}</small>
                                    </div>
                                    <p class="mb-0 text-dark">${comment.comment}</p>
                                </div>
                            `;
                        });
                        commentsList.innerHTML = commentsHtml;
                    }
                } else {
                    commentsList.innerHTML = `
                        <div class="text-center py-4">
                            <i class="bi bi-exclamation-circle text-warning mb-3" style="font-size: 3rem;"></i>
                            <h6 class="text-warning">Gagal memuat komentar</h6>
                            <p class="text-muted">${data.message || 'Terjadi kesalahan saat memuat komentar'}</p>
                        </div>
                    `;
                }
            })
            .catch(error => {
                console.error('Error fetching comments:', error);
                commentsList.innerHTML = `
                    <div class="text-center py-4">
                        <i class="bi bi-exclamation-circle text-danger mb-3" style="font-size: 3rem;"></i>
                        <h6 class="text-danger">Terjadi kesalahan</h6>
                        <p class="text-muted">Tidak dapat memuat komentar. Silakan coba lagi nanti.</p>
                    </div>
                `;
            });
    }

    // Check favorite status for all rendered books
    function checkFavoriteStatus() {
        const bookIds = currentBooks.map(book => book.id_buku);

        if (bookIds.length === 0) return;

        // Get CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        // Check favorite status for all books
        fetch('{{ route("anggota.favorites.check") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                book_ids: bookIds
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update favorite buttons based on status
                data.favorites.forEach(bookId => {
                    const button = document.querySelector(`[data-book-id="${bookId}"]`);
                    if (button) {
                        button.innerHTML = '<i class="bi bi-heart-fill"></i>';
                        button.classList.remove('btn-outline-danger');
                        button.classList.add('btn-danger');
                        button.title = 'Hapus dari favorit';
                    }
                });
            }
        })
        .catch(error => {
            console.error('Error checking favorite status:', error);
        });
    }

    // Initialize favorite buttons after books are rendered
    function initializeFavoriteButtons() {
        // Get CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        // Add event listeners to favorite buttons
        document.querySelectorAll('.favorite-btn').forEach(button => {
            button.addEventListener('click', function() {
                const bookId = this.dataset.bookId;
                toggleFavorite(bookId, this);
            });
        });

        function toggleFavorite(bookId, button) {
            // Show loading state
            const originalContent = button.innerHTML;
            button.innerHTML = '<i class="bi bi-hourglass-split"></i>';
            button.disabled = true;

            fetch('{{ route("anggota.favorites.toggle") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    book_id: bookId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update button appearance
                    if (data.is_favorite) {
                        button.innerHTML = '<i class="bi bi-heart-fill"></i>';
                        button.classList.remove('btn-outline-danger');
                        button.classList.add('btn-danger');
                        button.title = 'Hapus dari favorit';
                    } else {
                        button.innerHTML = '<i class="bi bi-heart"></i>';
                        button.classList.remove('btn-danger');
                        button.classList.add('btn-outline-danger');
                        button.title = 'Tambah ke favorit';
                    }

                    // Show success message
                    showNotification(data.message, 'success');
                } else {
                    // Show error message
                    showNotification(data.message || 'Terjadi kesalahan', 'error');
                    button.innerHTML = originalContent;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Terjadi kesalahan saat mengubah favorit', 'error');
                button.innerHTML = originalContent;
            })
            .finally(() => {
                button.disabled = false;
            });
        }

        function showNotification(message, type = 'info') {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed`;
            notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
            notification.innerHTML = `
                <i class="bi bi-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;

            // Add to page
            document.body.appendChild(notification);

            // Auto remove after 3 seconds
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.remove();
                }
            }, 3000);
        }
    }
});
</script>
@endpush
