@extends('layouts.dashboard')

@section('title', 'Manajemen Anggota - Admin')
@section('page-title', 'Manajemen Anggota')
@section('user-name', 'Administrator')
@section('user-role', 'Admin')

@section('sidebar-menu')
    <li class="nav-item">
        <a class="nav-link active" href="{{ route('dashboard.admin') }}">
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
                        <button class="btn btn-outline-success">
                            <i class="bi bi-download me-1"></i>
                            Import Anggota
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
                @if(isset($members) && $members->hasPages())
                <div class="d-flex justify-content-center mt-3">
                    {{ $members->links() }}
                </div>
                @endif
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
        },
        error: function(xhr) {
            console.error('Error loading members:', xhr);
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
    // Update pagination if needed
    // This is a simplified version - you might want to implement a more complete pagination
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
