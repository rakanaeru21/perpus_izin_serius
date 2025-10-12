@extends('layouts.dashboard')

@section('title', 'Manajemen Anggota - Admin')
@section('page-title', 'Manajemen Anggota')
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
        <a class="nav-link" href="{{ route('admin.books') }}">
            <i class="bi bi-book me-2"></i>
            Manajemen Buku
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" href="{{ route('admin.members') }}">
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
                    <i class="bi bi-people text-primary me-2"></i>
                    Manajemen Anggota
                </h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <div>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMemberModal">
                            <i class="bi bi-person-plus me-1"></i>
                            Tambah Anggota Baru
                        </button>
                    </div>
                    <div class="d-flex gap-2">
                        <select class="form-select" id="statusFilter" style="width: auto;">
                            <option value="">Semua Status</option>
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Non-Aktif</option>
                        </select>
                        <input type="text" class="form-control" id="searchInput" placeholder="Cari anggota..." style="width: 250px;">
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID Anggota</th>
                                <th>Nama Lengkap</th>
                                <th>Email</th>
                                <th>No. Telepon</th>
                                <th>Tanggal Daftar</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="membersTableBody">
                            @if(isset($members) && $members->count() > 0)
                                @foreach($members as $member)
                                <tr>
                                    <td>{{ str_pad($member->id_user, 4, '0', STR_PAD_LEFT) }}</td>
                                    <td>{{ $member->nama_lengkap }}</td>
                                    <td>{{ $member->email ?? '-' }}</td>
                                    <td>{{ $member->no_hp ?? '-' }}</td>
                                    <td>{{ $member->tanggal_daftar ? date('d/m/Y', strtotime($member->tanggal_daftar)) : '-' }}</td>
                                    <td>
                                        <span class="badge {{ $member->status == 'aktif' ? 'bg-success' : 'bg-danger' }}">
                                            {{ ucfirst($member->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-outline-info" onclick="viewMember({{ $member->id_user }})" title="Lihat Detail">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-warning" onclick="editMember({{ $member->id_user }})" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-{{ $member->status == 'aktif' ? 'danger' : 'success' }}"
                                                    onclick="toggleMemberStatus({{ $member->id_user }}, '{{ $member->status == 'aktif' ? 'nonaktif' : 'aktif' }}')"
                                                    title="{{ $member->status == 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                <i class="bi bi-{{ $member->status == 'aktif' ? 'x-circle' : 'check-circle' }}"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteMember({{ $member->id_user }})" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        <i class="bi bi-inbox display-4 d-block mb-2"></i>
                                        Data anggota tidak ditemukan
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div id="paginationWrapper" class="mt-4">
                    @if(isset($members) && $members->hasPages())
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="pagination-info">
                            <small class="text-muted">
                                Menampilkan {{ $members->firstItem() }} sampai {{ $members->lastItem() }}
                                dari {{ $members->total() }} hasil
                            </small>
                        </div>
                        <div class="pagination-controls">
                            <nav aria-label="Navigasi halaman anggota">
                                <ul class="pagination pagination-sm mb-0">
                                    {{-- Previous Page Link --}}
                                    @if ($members->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link">
                                                <i class="bi bi-chevron-left"></i>
                                            </span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="javascript:void(0)" onclick="loadMembers({{ $members->currentPage() - 1 }})">
                                                <i class="bi bi-chevron-left"></i>
                                            </a>
                                        </li>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @foreach ($members->getUrlRange(1, $members->lastPage()) as $page => $url)
                                        @if ($page == $members->currentPage())
                                            <li class="page-item active">
                                                <span class="page-link">{{ $page }}</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="javascript:void(0)" onclick="loadMembers({{ $page }})">{{ $page }}</a>
                                            </li>
                                        @endif
                                    @endforeach

                                    {{-- Next Page Link --}}
                                    @if ($members->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="javascript:void(0)" onclick="loadMembers({{ $members->currentPage() + 1 }})">
                                                <i class="bi bi-chevron-right"></i>
                                            </a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <span class="page-link">
                                                <i class="bi bi-chevron-right"></i>
                                            </span>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                    </div>
                    @elseif(isset($members) && $members->count() > 0)
                    <div class="pagination-info">
                        <small class="text-muted">
                            Menampilkan {{ $members->count() }} hasil
                        </small>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Member Detail Modal -->
<div class="modal fade" id="memberDetailModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Anggota</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="memberDetailContent">
                <!-- Content will be loaded via AJAX -->
            </div>
        </div>
    </div>
</div>

<!-- Add Member Modal -->
<div class="modal fade" id="addMemberModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Anggota Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- Add member form would go here -->
                <p class="text-muted">Form tambah anggota akan diimplementasikan di sini.</p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<style>
/* Custom pagination styles */
.pagination-controls .pagination {
    border-radius: 0.375rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.pagination-controls .page-link {
    border: 1px solid #dee2e6;
    color: #6c757d;
    padding: 0.5rem 0.75rem;
    margin: 0 2px;
    border-radius: 0.25rem;
    transition: all 0.15s ease-in-out;
}

.pagination-controls .page-link:hover {
    background-color: #e9ecef;
    color: #495057;
    text-decoration: none;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.pagination-controls .page-item.active .page-link {
    background-color: #0d6efd;
    border-color: #0d6efd;
    color: white;
    font-weight: 600;
    box-shadow: 0 2px 4px rgba(13, 110, 253, 0.25);
}

.pagination-controls .page-item.disabled .page-link {
    background-color: #f8f9fa;
    border-color: #dee2e6;
    color: #6c757d;
    cursor: not-allowed;
    opacity: 0.6;
}

.pagination-info {
    font-size: 0.875rem;
    color: #6c757d;
    margin-bottom: 0;
}

/* Responsive pagination */
@media (max-width: 576px) {
    #paginationWrapper .d-flex {
        flex-direction: column;
        gap: 1rem;
        align-items: center !important;
    }

    .pagination-controls .page-link {
        padding: 0.375rem 0.5rem;
        font-size: 0.875rem;
    }

    .pagination-info {
        text-align: center;
    }
}

/* Loading state */
.pagination-loading {
    opacity: 0.6;
    pointer-events: none;
}

.pagination-loading .page-link {
    cursor: wait;
}
</style>

<script>
let searchTimeout;

$(document).ready(function() {
    // Search functionality
    $('#searchInput').on('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function() {
            loadMembers();
        }, 500);
    });

    // Status filter
    $('#statusFilter').on('change', function() {
        loadMembers();
    });
});

function loadMembers(page = 1) {
    const search = $('#searchInput').val();
    const status = $('#statusFilter').val();
    const paginationWrapper = $('#paginationWrapper');
    const tableBody = $('#membersTableBody');

    // Show loading state
    paginationWrapper.addClass('pagination-loading');
    tableBody.html(`
        <tr>
            <td colspan="7" class="text-center py-4">
                <div class="spinner-border spinner-border-sm me-2" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                Memuat data...
            </td>
        </tr>
    `);

    $.ajax({
        url: '{{ route("admin.members") }}',
        method: 'GET',
        data: {
            search: search,
            status: status,
            page: page
        },
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        success: function(response) {
            updateMembersTable(response.members);
            updatePagination(response.pagination);

            // Scroll to top of table if not first page
            if (page > 1) {
                $('html, body').animate({
                    scrollTop: $('.table-responsive').offset().top - 100
                }, 300);
            }
        },
        error: function(xhr) {
            console.error('Error loading members:', xhr);
            tableBody.html(`
                <tr>
                    <td colspan="7" class="text-center text-danger py-4">
                        <i class="bi bi-exclamation-triangle display-4 d-block mb-2"></i>
                        Terjadi kesalahan saat memuat data. Silakan coba lagi.
                        <br>
                        <button class="btn btn-sm btn-outline-primary mt-2" onclick="loadMembers(${page})">
                            <i class="bi bi-arrow-clockwise me-1"></i>
                            Coba Lagi
                        </button>
                    </td>
                </tr>
            `);
            updatePagination(null);
        },
        complete: function() {
            // Remove loading state
            paginationWrapper.removeClass('pagination-loading');
        }
    });
}

function updateMembersTable(members) {
    const tbody = $('#membersTableBody');
    tbody.empty();

    if (members.length === 0) {
        tbody.append(`
            <tr>
                <td colspan="7" class="text-center text-muted py-4">
                    <i class="bi bi-inbox display-4 d-block mb-2"></i>
                    Data anggota tidak ditemukan
                </td>
            </tr>
        `);
        return;
    }

    members.forEach(function(member) {
        const statusBadge = member.status === 'aktif' ? 'bg-success' : 'bg-danger';
        const toggleIcon = member.status === 'aktif' ? 'x-circle' : 'check-circle';
        const toggleClass = member.status === 'aktif' ? 'danger' : 'success';
        const toggleTitle = member.status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan';
        const newStatus = member.status === 'aktif' ? 'nonaktif' : 'aktif';

        const row = `
            <tr>
                <td>${String(member.id_user).padStart(4, '0')}</td>
                <td>${member.nama_lengkap}</td>
                <td>${member.email || '-'}</td>
                <td>${member.no_hp || '-'}</td>
                <td>${member.tanggal_daftar ? new Date(member.tanggal_daftar).toLocaleDateString('id-ID') : '-'}</td>
                <td>
                    <span class="badge ${statusBadge}">
                        ${member.status.charAt(0).toUpperCase() + member.status.slice(1)}
                    </span>
                </td>
                <td>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-sm btn-outline-info" onclick="viewMember(${member.id_user})" title="Lihat Detail">
                            <i class="bi bi-eye"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-warning" onclick="editMember(${member.id_user})" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-${toggleClass}"
                                onclick="toggleMemberStatus(${member.id_user}, '${newStatus}')"
                                title="${toggleTitle}">
                            <i class="bi bi-${toggleIcon}"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteMember(${member.id_user})" title="Hapus">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;
        tbody.append(row);
    });
}

function updatePagination(pagination) {
    const wrapper = $('#paginationWrapper');

    if (!pagination || pagination.last_page <= 1) {
        wrapper.html(`
            <div class="pagination-info">
                <small class="text-muted">
                    Menampilkan ${pagination ? pagination.total : 0} hasil
                </small>
            </div>
        `);
        return;
    }

    const currentPage = pagination.current_page;
    const lastPage = pagination.last_page;
    const total = pagination.total;
    const perPage = pagination.per_page;

    const firstItem = ((currentPage - 1) * perPage) + 1;
    const lastItem = Math.min(currentPage * perPage, total);

    let paginationHTML = `
        <div class="d-flex justify-content-between align-items-center">
            <div class="pagination-info">
                <small class="text-muted">
                    Menampilkan ${firstItem} sampai ${lastItem} dari ${total} hasil
                </small>
            </div>
            <div class="pagination-controls">
                <nav aria-label="Navigasi halaman anggota">
                    <ul class="pagination pagination-sm mb-0">
    `;

    // Previous button
    if (currentPage === 1) {
        paginationHTML += `
            <li class="page-item disabled">
                <span class="page-link">
                    <i class="bi bi-chevron-left"></i>
                </span>
            </li>
        `;
    } else {
        paginationHTML += `
            <li class="page-item">
                <a class="page-link" href="javascript:void(0)" onclick="loadMembers(${currentPage - 1})">
                    <i class="bi bi-chevron-left"></i>
                </a>
            </li>
        `;
    }

    // Page numbers
    let startPage = Math.max(1, currentPage - 2);
    let endPage = Math.min(lastPage, currentPage + 2);

    // Adjust if we're near the beginning or end
    if (endPage - startPage < 4) {
        if (startPage === 1) {
            endPage = Math.min(lastPage, startPage + 4);
        } else if (endPage === lastPage) {
            startPage = Math.max(1, endPage - 4);
        }
    }

    // First page and ellipsis
    if (startPage > 1) {
        paginationHTML += `
            <li class="page-item">
                <a class="page-link" href="javascript:void(0)" onclick="loadMembers(1)">1</a>
            </li>
        `;
        if (startPage > 2) {
            paginationHTML += `
                <li class="page-item disabled">
                    <span class="page-link">...</span>
                </li>
            `;
        }
    }

    // Page range
    for (let page = startPage; page <= endPage; page++) {
        if (page === currentPage) {
            paginationHTML += `
                <li class="page-item active">
                    <span class="page-link">${page}</span>
                </li>
            `;
        } else {
            paginationHTML += `
                <li class="page-item">
                    <a class="page-link" href="javascript:void(0)" onclick="loadMembers(${page})">${page}</a>
                </li>
            `;
        }
    }

    // Last page and ellipsis
    if (endPage < lastPage) {
        if (endPage < lastPage - 1) {
            paginationHTML += `
                <li class="page-item disabled">
                    <span class="page-link">...</span>
                </li>
            `;
        }
        paginationHTML += `
            <li class="page-item">
                <a class="page-link" href="javascript:void(0)" onclick="loadMembers(${lastPage})">${lastPage}</a>
            </li>
        `;
    }

    // Next button
    if (currentPage === lastPage) {
        paginationHTML += `
            <li class="page-item disabled">
                <span class="page-link">
                    <i class="bi bi-chevron-right"></i>
                </span>
            </li>
        `;
    } else {
        paginationHTML += `
            <li class="page-item">
                <a class="page-link" href="javascript:void(0)" onclick="loadMembers(${currentPage + 1})">
                    <i class="bi bi-chevron-right"></i>
                </a>
            </li>
        `;
    }

    paginationHTML += `
                    </ul>
                </nav>
            </div>
        </div>
    `;

    wrapper.html(paginationHTML);
}

function viewMember(id) {
    $.ajax({
        url: `/dashboard/admin/members/${id}`,
        method: 'GET',
        success: function(member) {
            const content = `
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>ID Anggota:</strong> ${String(member.id_user).padStart(4, '0')}</p>
                        <p><strong>Nama Lengkap:</strong> ${member.nama_lengkap}</p>
                        <p><strong>Username:</strong> ${member.username}</p>
                        <p><strong>Email:</strong> ${member.email || '-'}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>No. Telepon:</strong> ${member.no_hp || '-'}</p>
                        <p><strong>Alamat:</strong> ${member.alamat || '-'}</p>
                        <p><strong>Status:</strong> <span class="badge ${member.status === 'aktif' ? 'bg-success' : 'bg-danger'}">${member.status.charAt(0).toUpperCase() + member.status.slice(1)}</span></p>
                        <p><strong>Tanggal Daftar:</strong> ${member.tanggal_daftar ? new Date(member.tanggal_daftar).toLocaleDateString('id-ID') : '-'}</p>
                    </div>
                </div>
            `;
            $('#memberDetailContent').html(content);
            $('#memberDetailModal').modal('show');
        },
        error: function(xhr) {
            alert('Error loading member details');
        }
    });
}

function editMember(id) {
    // Implement edit functionality
    alert('Edit functionality will be implemented');
}

function toggleMemberStatus(id, newStatus) {
    if (confirm(`Apakah Anda yakin ingin ${newStatus === 'aktif' ? 'mengaktifkan' : 'menonaktifkan'} anggota ini?`)) {
        $.ajax({
            url: `/dashboard/admin/members/${id}/status`,
            method: 'PUT',
            data: {
                status: newStatus,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    loadMembers();
                    alert(response.message);
                }
            },
            error: function(xhr) {
                alert('Error updating member status');
            }
        });
    }
}

function deleteMember(id) {
    if (confirm('Apakah Anda yakin ingin menghapus anggota ini? Tindakan ini tidak dapat dibatalkan.')) {
        $.ajax({
            url: `/dashboard/admin/members/${id}`,
            method: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    loadMembers();
                    alert(response.message);
                }
            },
            error: function(xhr) {
                alert('Error deleting member');
            }
        });
    }
}
</script>
@endpush
@endsection
