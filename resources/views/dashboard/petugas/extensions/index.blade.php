@extends('layouts.dashboard')

@section('title', 'Kelola Perpanjangan - Petugas')
@section('page-title', 'Kelola Perpanjangan Pinjaman')
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
        <a class="nav-link active" href="{{ route('petugas.extensions') }}">
            <i class="bi bi-arrow-clockwise me-2"></i>
            Perpanjang
        </a>
    </li>
@endsection

@section('content')
<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stat-card warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-white-50 mb-2">Menunggu Persetujuan</h6>
                        <h2 class="mb-0">{{ $statistics['pending'] }}</h2>
                    </div>
                    <div class="text-white-50">
                        <i class="bi bi-clock-fill" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stat-card success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-white-50 mb-2">Disetujui Hari Ini</h6>
                        <h2 class="mb-0">{{ $statistics['approved_today'] }}</h2>
                    </div>
                    <div class="text-white-50">
                        <i class="bi bi-check-circle-fill" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stat-card danger">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-white-50 mb-2">Ditolak Hari Ini</h6>
                        <h2 class="mb-0">{{ $statistics['rejected_today'] }}</h2>
                    </div>
                    <div class="text-white-50">
                        <i class="bi bi-x-circle-fill" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stat-card primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-white-50 mb-2">Total Disetujui</h6>
                        <h2 class="mb-0">{{ $statistics['total_approved'] }}</h2>
                    </div>
                    <div class="text-white-50">
                        <i class="bi bi-arrow-clockwise" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tabs -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-arrow-clockwise text-primary me-2"></i>
                    Kelola Perpanjangan Pinjaman
                </h5>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs" id="extensionTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab">
                            <i class="bi bi-clock me-2"></i>Menunggu Persetujuan ({{ $statistics['pending'] }})
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="approved-tab" data-bs-toggle="tab" data-bs-target="#approved" type="button" role="tab">
                            <i class="bi bi-check-circle me-2"></i>Disetujui
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="rejected-tab" data-bs-toggle="tab" data-bs-target="#rejected" type="button" role="tab">
                            <i class="bi bi-x-circle me-2"></i>Ditolak
                        </button>
                    </li>
                </ul>

                <div class="tab-content mt-4" id="extensionTabsContent">
                    <!-- Pending Requests -->
                    <div class="tab-pane fade show active" id="pending" role="tabpanel">
                        @if($pendingRequests->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Peminjam</th>
                                            <th>Judul Buku</th>
                                            <th>Tanggal Pinjam</th>
                                            <th>Batas Kembali</th>
                                            <th>Tanggal Request</th>
                                            <th>Alasan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pendingRequests as $request)
                                            <tr>
                                                <td>{{ $request->user->nama }}</td>
                                                <td>{{ $request->book->judul_buku }}</td>
                                                <td>{{ $request->tanggal_pinjam->format('d M Y') }}</td>
                                                <td>{{ $request->batas_kembali->format('d M Y') }}</td>
                                                <td>{{ $request->extension_requested_at->format('d M Y H:i') }}</td>
                                                <td>
                                                    @if($request->extension_reason)
                                                        {{ Str::limit($request->extension_reason, 50) }}
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-success approve-extension"
                                                            data-id="{{ $request->id_peminjaman }}"
                                                            data-user="{{ $request->user->nama }}"
                                                            data-book="{{ $request->book->judul_buku }}">
                                                        <i class="bi bi-check-lg"></i> Setujui
                                                    </button>
                                                    <button class="btn btn-sm btn-danger reject-extension"
                                                            data-id="{{ $request->id_peminjaman }}"
                                                            data-user="{{ $request->user->nama }}"
                                                            data-book="{{ $request->book->judul_buku }}">
                                                        <i class="bi bi-x-lg"></i> Tolak
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $pendingRequests->links() }}
                        @else
                            <div class="text-center py-4">
                                <i class="bi bi-clock text-muted" style="font-size: 3rem;"></i>
                                <h5 class="text-muted mt-3">Tidak ada permintaan perpanjangan yang menunggu</h5>
                                <p class="text-muted">Semua permintaan telah diproses</p>
                            </div>
                        @endif
                    </div>

                    <!-- Approved Requests -->
                    <div class="tab-pane fade" id="approved" role="tabpanel">
                        @if($approvedRequests->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Peminjam</th>
                                            <th>Judul Buku</th>
                                            <th>Batas Kembali Baru</th>
                                            <th>Disetujui Oleh</th>
                                            <th>Tanggal Persetujuan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($approvedRequests as $request)
                                            <tr>
                                                <td>{{ $request->user->nama }}</td>
                                                <td>{{ $request->book->judul_buku }}</td>
                                                <td>
                                                    <span class="badge bg-success">
                                                        {{ $request->batas_kembali->format('d M Y') }}
                                                    </span>
                                                </td>
                                                <td>{{ $request->approver->nama }}</td>
                                                <td>{{ $request->extension_approved_at->format('d M Y H:i') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $approvedRequests->links() }}
                        @else
                            <div class="text-center py-4">
                                <i class="bi bi-check-circle text-muted" style="font-size: 3rem;"></i>
                                <h5 class="text-muted mt-3">Belum ada perpanjangan yang disetujui</h5>
                            </div>
                        @endif
                    </div>

                    <!-- Rejected Requests -->
                    <div class="tab-pane fade" id="rejected" role="tabpanel">
                        @if($rejectedRequests->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Peminjam</th>
                                            <th>Judul Buku</th>
                                            <th>Alasan Penolakan</th>
                                            <th>Ditolak Oleh</th>
                                            <th>Tanggal Penolakan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($rejectedRequests as $request)
                                            <tr>
                                                <td>{{ $request->user->nama }}</td>
                                                <td>{{ $request->book->judul_buku }}</td>
                                                <td>{{ $request->rejection_reason }}</td>
                                                <td>{{ $request->approver->nama }}</td>
                                                <td>{{ $request->extension_approved_at->format('d M Y H:i') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $rejectedRequests->links() }}
                        @else
                            <div class="text-center py-4">
                                <i class="bi bi-x-circle text-muted" style="font-size: 3rem;"></i>
                                <h5 class="text-muted mt-3">Belum ada perpanjangan yang ditolak</h5>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Approve Modal -->
<div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="approveModalLabel">Setujui Perpanjangan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="approveForm">
                    <div class="mb-3">
                        <p><strong>Peminjam:</strong> <span id="approveUserName"></span></p>
                        <p><strong>Buku:</strong> <span id="approveBookTitle"></span></p>
                    </div>
                    <div class="mb-3">
                        <label for="extendDays" class="form-label">Perpanjang untuk berapa hari?</label>
                        <select class="form-select" id="extendDays" name="extend_days">
                            <option value="7">7 hari</option>
                            <option value="14">14 hari</option>
                            <option value="3">3 hari</option>
                            <option value="5">5 hari</option>
                            <option value="10">10 hari</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success" id="confirmApprove">Setujui</button>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalLabel">Tolak Perpanjangan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="rejectForm">
                    <div class="mb-3">
                        <p><strong>Peminjam:</strong> <span id="rejectUserName"></span></p>
                        <p><strong>Buku:</strong> <span id="rejectBookTitle"></span></p>
                    </div>
                    <div class="mb-3">
                        <label for="rejectReason" class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="rejectReason" name="reason" rows="3" required
                                  placeholder="Jelaskan alasan penolakan perpanjangan..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="confirmReject">Tolak</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentRequestId = null;
    const approveModal = new bootstrap.Modal(document.getElementById('approveModal'));
    const rejectModal = new bootstrap.Modal(document.getElementById('rejectModal'));

    // Handle approve button click
    document.querySelectorAll('.approve-extension').forEach(button => {
        button.addEventListener('click', function() {
            currentRequestId = this.dataset.id;
            document.getElementById('approveUserName').textContent = this.dataset.user;
            document.getElementById('approveBookTitle').textContent = this.dataset.book;
            approveModal.show();
        });
    });

    // Handle reject button click
    document.querySelectorAll('.reject-extension').forEach(button => {
        button.addEventListener('click', function() {
            currentRequestId = this.dataset.id;
            document.getElementById('rejectUserName').textContent = this.dataset.user;
            document.getElementById('rejectBookTitle').textContent = this.dataset.book;
            rejectModal.show();
        });
    });

    // Handle approve confirmation
    document.getElementById('confirmApprove').addEventListener('click', function() {
        if (!currentRequestId) return;

        const extendDays = document.getElementById('extendDays').value;
        const submitButton = this;

        submitButton.disabled = true;
        submitButton.innerHTML = '<i class="bi bi-hourglass-split"></i> Memproses...';

        fetch(`/dashboard/petugas/extensions/${currentRequestId}/approve`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                extend_days: parseInt(extendDays)
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                approveModal.hide();
                location.reload();
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            alert('Terjadi kesalahan saat memproses permintaan');
        })
        .finally(() => {
            submitButton.disabled = false;
            submitButton.innerHTML = 'Setujui';
        });
    });

    // Handle reject confirmation
    document.getElementById('confirmReject').addEventListener('click', function() {
        if (!currentRequestId) return;

        const reason = document.getElementById('rejectReason').value;
        if (!reason.trim()) {
            alert('Alasan penolakan harus diisi');
            return;
        }

        const submitButton = this;

        submitButton.disabled = true;
        submitButton.innerHTML = '<i class="bi bi-hourglass-split"></i> Memproses...';

        fetch(`/dashboard/petugas/extensions/${currentRequestId}/reject`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                reason: reason
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                rejectModal.hide();
                location.reload();
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            alert('Terjadi kesalahan saat memproses permintaan');
        })
        .finally(() => {
            submitButton.disabled = false;
            submitButton.innerHTML = 'Tolak';
        });
    });

    // Reset forms when modals are hidden
    document.getElementById('approveModal').addEventListener('hidden.bs.modal', function() {
        document.getElementById('approveForm').reset();
        currentRequestId = null;
    });

    document.getElementById('rejectModal').addEventListener('hidden.bs.modal', function() {
        document.getElementById('rejectForm').reset();
        currentRequestId = null;
    });
});
</script>
@endsection
