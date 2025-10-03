@extends('layouts.dashboard')

@section('title', 'Profil Saya - Anggota')
@section('page-title', 'Profil Saya')
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
        <a class="nav-link" href="#">
            <i class="bi bi-clock-history me-2"></i>
            Riwayat Pinjaman
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" href="{{ route('anggota.profile') }}">
            <i class="bi bi-person me-2"></i>
            Profil Saya
        </a>
    </li>
@endsection

@section('content')
<!-- Profile Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
            <div class="card-body py-4">
                <div class="row align-items-center">
                    <div class="col-md-2 text-center">
                        <div class="profile-avatar">
                            @if(auth()->user()->foto_profil && auth()->user()->foto_profil !== 'default.png')
                                <img src="{{ asset('storage/profiles/' . auth()->user()->foto_profil) }}"
                                     alt="Foto Profil"
                                     class="rounded-circle"
                                     style="width: 80px; height: 80px; object-fit: cover; border: 3px solid rgba(255,255,255,0.3);"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="bg-white bg-opacity-20 rounded-circle d-flex align-items-center justify-content-center"
                                     style="display: none; width: 80px; height: 80px; border: 3px solid rgba(255,255,255,0.3);">
                                    <i class="bi bi-person-fill" style="font-size: 2rem; color: white;"></i>
                                </div>
                            @else
                                <div class="bg-white bg-opacity-20 rounded-circle d-flex align-items-center justify-content-center"
                                     style="width: 80px; height: 80px; border: 3px solid rgba(255,255,255,0.3);">
                                    <i class="bi bi-person-fill" style="font-size: 2rem; color: white;"></i>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-10">
                        <h2 class="mb-2">{{ auth()->user()->nama_lengkap }}</h2>
                        <p class="mb-1 opacity-75">
                            <i class="bi bi-card-text me-2"></i>
                            ID User: <strong>{{ str_pad(auth()->user()->id_user, 6, '0', STR_PAD_LEFT) }}</strong>
                        </p>
                        <p class="mb-1 opacity-75">
                            <i class="bi bi-envelope me-2"></i>
                            {{ auth()->user()->email ?: 'Email tidak diatur' }}
                        </p>
                        <p class="mb-0 opacity-75">
                            <i class="bi bi-calendar me-2"></i>
                            Bergabung sejak {{ \Carbon\Carbon::parse(auth()->user()->tanggal_daftar)->format('d F Y') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Profile Information -->
<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-info-circle text-primary me-2"></i>
                    Informasi Pribadi
                </h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Nama Lengkap</label>
                    </div>
                    <div class="col-md-8">
                        <p class="form-control-plaintext">{{ auth()->user()->nama_lengkap }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Username</label>
                    </div>
                    <div class="col-md-8">
                        <p class="form-control-plaintext">{{ auth()->user()->username }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Email</label>
                    </div>
                    <div class="col-md-8">
                        <p class="form-control-plaintext">{{ auth()->user()->email ?: 'Belum diatur' }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Nomor HP</label>
                    </div>
                    <div class="col-md-8">
                        <p class="form-control-plaintext">{{ auth()->user()->no_hp ?: 'Belum diatur' }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Alamat</label>
                    </div>
                    <div class="col-md-8">
                        <p class="form-control-plaintext">{{ auth()->user()->alamat ?: 'Belum diatur' }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Status</label>
                    </div>
                    <div class="col-md-8">
                        <span class="badge {{ auth()->user()->status === 'aktif' ? 'bg-success' : 'bg-danger' }} fs-6">
                            {{ ucfirst(auth()->user()->status) }}
                        </span>
                    </div>
                </div>

                <div class="row mb-0">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Tanggal Daftar</label>
                    </div>
                    <div class="col-md-8">
                        <p class="form-control-plaintext">{{ \Carbon\Carbon::parse(auth()->user()->tanggal_daftar)->format('d F Y, H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-4">
        <!-- Member ID Card -->
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h6 class="card-title mb-0">
                    <i class="bi bi-credit-card text-primary me-2"></i>
                    Kartu User Digital
                </h6>
            </div>
            <div class="card-body text-center">
                <div class="member-card mx-auto mb-3" style="width: 250px; height: 150px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px; position: relative; color: white; padding: 20px; box-shadow: 0 8px 16px rgba(0,0,0,0.2);">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div style="font-size: 12px; opacity: 0.8;">PERPUSTAKAAN</div>
                        <i class="bi bi-book-fill" style="font-size: 1.5rem; opacity: 0.8;"></i>
                    </div>
                    <div class="text-start">
                        <div style="font-size: 10px; opacity: 0.7; margin-bottom: 5px;">ID USER</div>
                        <div style="font-size: 18px; font-weight: bold; letter-spacing: 2px; margin-bottom: 10px;">
                            {{ str_pad(auth()->user()->id_user, 6, '0', STR_PAD_LEFT) }}
                        </div>
                        <div style="font-size: 12px; opacity: 0.9;">
                            {{ auth()->user()->nama_lengkap }}
                        </div>
                    </div>
                    <div style="position: absolute; bottom: 10px; right: 15px; font-size: 8px; opacity: 0.6;">
                        {{ \Carbon\Carbon::parse(auth()->user()->tanggal_daftar)->format('m/y') }}
                    </div>
                </div>
                <p class="text-muted small">Tunjukkan ID ini saat meminjam buku</p>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header bg-white">
                <h6 class="card-title mb-0">
                    <i class="bi bi-lightning text-primary me-2"></i>
                    Aksi Cepat
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button class="btn btn-outline-primary btn-sm" onclick="editProfile()">
                        <i class="bi bi-pencil me-2"></i>
                        Edit Profil
                    </button>
                    <button class="btn btn-outline-secondary btn-sm" onclick="changePassword()">
                        <i class="bi bi-key me-2"></i>
                        Ubah Password
                    </button>
                    <a href="{{ route('anggota.loans') }}" class="btn btn-outline-success btn-sm">
                        <i class="bi bi-book me-2"></i>
                        Lihat Pinjaman
                    </a>
                    <a href="{{ route('anggota.catalog') }}" class="btn btn-outline-info btn-sm">
                        <i class="bi bi-search me-2"></i>
                        Cari Buku
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Activity Summary -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-activity text-primary me-2"></i>
                    Ringkasan Aktivitas
                </h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-3">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <i class="bi bi-book-fill text-primary mb-2" style="font-size: 2rem;"></i>
                                <h4 class="mb-1">{{ $totalPinjaman ?? 0 }}</h4>
                                <p class="text-muted small mb-0">Total Pinjaman</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <i class="bi bi-arrow-repeat text-warning mb-2" style="font-size: 2rem;"></i>
                                <h4 class="mb-1">{{ $sedangDipinjam ?? 0 }}</h4>
                                <p class="text-muted small mb-0">Sedang Dipinjam</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <i class="bi bi-check-circle text-success mb-2" style="font-size: 2rem;"></i>
                                <h4 class="mb-1">{{ $sudahDikembalikan ?? 0 }}</h4>
                                <p class="text-muted small mb-0">Sudah Dikembalikan</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <i class="bi bi-exclamation-triangle text-danger mb-2" style="font-size: 2rem;"></i>
                                <h4 class="mb-1">{{ $terlambat ?? 0 }}</h4>
                                <p class="text-muted small mb-0">Terlambat</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.member-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    box-shadow: 0 8px 16px rgba(0,0,0,0.2);
    transition: transform 0.2s ease;
}

.member-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 20px rgba(0,0,0,0.3);
}

.profile-avatar img, .profile-avatar div {
    transition: transform 0.2s ease;
}

.profile-avatar:hover img, .profile-avatar:hover div {
    transform: scale(1.05);
}

.card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.form-control-plaintext {
    padding-left: 0;
    margin-bottom: 0;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add any initialization code here
});

function editProfile() {
    alert('Fitur edit profil akan segera tersedia!');
    // This would typically open an edit profile modal or redirect to edit page
}

function changePassword() {
    alert('Fitur ubah password akan segera tersedia!');
    // This would typically open a change password modal
}

// Print member card function
function printMemberCard() {
    const memberCard = document.querySelector('.member-card').outerHTML;
    const printWindow = window.open('', '_blank');
    printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>Kartu User - {{ auth()->user()->nama_lengkap }}</title>
            <style>
                body { margin: 0; padding: 20px; font-family: Arial, sans-serif; }
                .member-card {
                    width: 250px;
                    height: 150px;
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                    border-radius: 15px;
                    position: relative;
                    color: white;
                    padding: 20px;
                    box-shadow: 0 8px 16px rgba(0,0,0,0.2);
                }
            </style>
        </head>
        <body>
            ${memberCard}
        </body>
        </html>
    `);
    printWindow.document.close();
    printWindow.print();
}
</script>
@endpush
