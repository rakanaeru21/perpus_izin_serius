@extends('layouts.dashboard')

@section('title', 'Buku Favorit - Anggota')
@section('page-title', 'Buku Favorit')
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
        <a class="nav-link active" href="{{ route('anggota.favorites') }}">
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
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1">Koleksi Buku Favorit Anda</h5>
                        <p class="text-muted mb-0">Simpan buku-buku yang ingin Anda baca nanti</p>
                    </div>
                    <div>
                        <span class="badge bg-primary fs-6">{{ $favorites->count() }} Buku</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($favorites->count() > 0)
<div class="row">
    @foreach($favorites as $book)
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card h-100 shadow-sm book-card">
            <div class="position-relative">
                <img src="{{ $book->cover_url }}"
                     class="card-img-top book-cover"
                     alt="{{ $book->judul_buku }}"
                     style="height: 250px; object-fit: cover;">
                @if($book->avg_rating > 0)
                <div class="position-absolute top-0 end-0 m-2">
                    <span class="badge bg-warning text-dark">
                        <i class="bi bi-star-fill"></i> {{ $book->avg_rating }}
                    </span>
                </div>
                @endif
                @if($book->jumlah_tersedia == 0)
                <div class="position-absolute top-0 start-0 m-2">
                    <span class="badge bg-danger">Tidak Tersedia</span>
                </div>
                @endif
                <div class="position-absolute bottom-0 start-0 m-2">
                    <small class="badge bg-dark bg-opacity-75">
                        <i class="bi bi-heart-fill text-danger"></i> Favorit
                    </small>
                </div>
            </div>
            <div class="card-body d-flex flex-column">
                <h6 class="card-title" title="{{ $book->judul_buku }}">
                    {{ $book->judul_buku }}
                </h6>
                <p class="card-text text-muted small mb-1">
                    <i class="bi bi-person"></i> {{ $book->penulis }}
                </p>
                <p class="card-text text-muted small mb-1">
                    <i class="bi bi-tag"></i> {{ $book->kategori }} • {{ $book->tahun_terbit }}
                </p>
                <p class="card-text text-muted small mb-2">
                    <i class="bi bi-calendar-plus"></i> Ditambah ke favorit: {{ \Carbon\Carbon::parse($book->favorited_at)->diffForHumans() }}
                </p>
                @if($book->deskripsi)
                <p class="card-text small text-muted mb-3" style="max-height: 60px; overflow: hidden;">
                    {{ Str::limit($book->deskripsi, 100) }}
                </p>
                @endif
                <div class="d-flex justify-content-between align-items-center mt-auto mb-3">
                    <small class="text-muted">
                        <i class="bi bi-book"></i> {{ $book->jumlah_tersedia }} tersedia
                    </small>
                    @if($book->total_ratings > 0)
                    <small class="text-muted">
                        {{ $book->total_ratings }} rating
                    </small>
                    @endif
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-primary btn-sm flex-grow-1 {{ $book->jumlah_tersedia == 0 ? 'disabled' : '' }}"
                            onclick="pinjamBuku({{ $book->id_buku }})">
                        <i class="bi bi-book"></i> {{ $book->jumlah_tersedia > 0 ? 'Pinjam' : 'Tidak Tersedia' }}
                    </button>
                    <button class="btn btn-outline-info btn-sm"
                            onclick="lihatDetailBuku({{ $book->id_buku }})"
                            title="Lihat detail buku">
                        <i class="bi bi-eye"></i>
                    </button>
                    <button class="btn btn-danger btn-sm favorite-btn"
                            data-book-id="{{ $book->id_buku }}"
                            title="Hapus dari favorit">
                        <i class="bi bi-heart-fill"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Pagination jika diperlukan -->
@if($favorites->count() > 12)
<div class="row mt-4">
    <div class="col-12 text-center">
        <p class="text-muted">Menampilkan {{ $favorites->count() }} buku favorit</p>
    </div>
</div>
@endif

@else
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="bi bi-heart text-muted mb-3" style="font-size: 4rem; opacity: 0.5;"></i>
                <h5 class="text-muted mb-3">Belum Ada Buku Favorit</h5>
                <p class="text-muted mb-4">Anda belum menambahkan buku apapun ke daftar favorit.<br>Jelajahi katalog untuk menemukan buku yang menarik!</p>
                <a href="{{ route('anggota.catalog') }}" class="btn btn-primary">
                    <i class="bi bi-search me-2"></i>
                    Jelajahi Katalog
                </a>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('styles')
<style>
    .book-card {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        border: none;
        border-radius: 15px;
        overflow: hidden;
    }

    .book-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
    }

    .book-cover {
        border-radius: 0;
        transition: transform 0.3s ease;
    }

    .book-card:hover .book-cover {
        transform: scale(1.03);
    }

    .card-title {
        font-weight: 600;
        color: #2c3e50;
        line-height: 1.3;
    }

    .badge {
        font-size: 0.75rem;
        border-radius: 20px;
    }

    .btn {
        border-radius: 20px;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .btn:hover {
        transform: translateY(-1px);
    }

    .btn-primary:hover {
        box-shadow: 0 4px 12px rgba(0,123,255,0.3);
    }

    .btn-danger:hover {
        box-shadow: 0 4px 12px rgba(220,53,69,0.3);
    }

    .btn-outline-info:hover {
        box-shadow: 0 4px 12px rgba(23,162,184,0.3);
    }

    .text-truncate-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .favorite-indicator {
        background: linear-gradient(45deg, #dc3545, #ff6b7d);
        color: white !important;
    }

    .empty-state-icon {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    @media (max-width: 768px) {
        .book-card {
            margin-bottom: 1.5rem;
        }

        .card-title {
            font-size: 1rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize favorite buttons
    initializeFavoriteButtons();
});

function initializeFavoriteButtons() {
    // Get CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    // Add event listeners to favorite buttons
    document.querySelectorAll('.favorite-btn').forEach(button => {
        button.addEventListener('click', function() {
            const bookId = this.dataset.bookId;
            removeFavorite(bookId, this);
        });
    });

    function removeFavorite(bookId, button) {
        if (!confirm('Apakah Anda yakin ingin menghapus buku ini dari daftar favorit?')) {
            return;
        }

        // Show loading state
        const originalContent = button.innerHTML;
        button.innerHTML = '<i class="bi bi-hourglass-split"></i>';
        button.disabled = true;

        fetch('{{ route("anggota.favorites.remove") }}', {
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
                // Remove the card with animation
                const card = button.closest('.col-lg-4');
                card.style.transition = 'all 0.3s ease';
                card.style.transform = 'scale(0.8)';
                card.style.opacity = '0';

                setTimeout(() => {
                    card.remove();

                    // Update count
                    updateFavoritesCount();

                    // Check if no favorites left
                    checkEmptyState();
                }, 300);

                // Show success message
                showNotification(data.message, 'success');
            } else {
                // Show error message and restore button
                showNotification(data.message || 'Terjadi kesalahan', 'error');
                button.innerHTML = originalContent;
                button.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Terjadi kesalahan saat menghapus favorit', 'error');
            button.innerHTML = originalContent;
            button.disabled = false;
        });
    }

    function updateFavoritesCount() {
        const badge = document.querySelector('.badge.bg-primary');
        if (badge) {
            const currentCount = parseInt(badge.textContent) || 0;
            const newCount = Math.max(0, currentCount - 1);
            badge.textContent = newCount + ' Buku';
        }
    }

    function checkEmptyState() {
        const remainingCards = document.querySelectorAll('.col-lg-4').length;
        if (remainingCards === 0) {
            // Reload page to show empty state
            setTimeout(() => {
                window.location.reload();
            }, 500);
        }
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

// Function to handle book borrowing
function pinjamBuku(bookId) {
    alert(`Fitur peminjaman buku ID ${bookId} akan segera tersedia!`);
    console.log('Pinjam buku dengan ID:', bookId);
}

// Function to view book details
function lihatDetailBuku(bookId) {
    alert(`Fitur detail buku ID ${bookId} akan segera tersedia!`);
    console.log('Lihat detail buku dengan ID:', bookId);
}
</script>
@endpush
