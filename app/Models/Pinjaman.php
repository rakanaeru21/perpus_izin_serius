<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Pinjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';
    protected $primaryKey = 'id_peminjaman';

    // Ubah ini untuk menggunakan timestamps Laravel
    public $timestamps = true;

    protected $fillable = [
        'id_user',
        'id_buku',
        'tanggal_pinjam',
        'batas_kembali',
        'tanggal_kembali',
        'status',
        'denda',
        'keterangan',
        'kondisi_buku',
        'extension_status',
        'extension_requested_at',
        'approved_by',
        'extension_approved_at',
        'extension_reason',
        'rejection_reason'
    ];

    protected $casts = [
        'tanggal_pinjam' => 'date',
        'batas_kembali' => 'date',
        'tanggal_kembali' => 'date',
        'extension_requested_at' => 'date',
        'extension_approved_at' => 'date',
        'denda' => 'decimal:2'
    ];

    // ...existing code... (sisanya tetap sama)

    /**
     * Relationship with User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    /**
     * Relationship with Book
     */
    public function book()
    {
        return $this->belongsTo(Book::class, 'id_buku', 'id_buku');
    }

    /**
     * Relationship with approver (petugas/admin)
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by', 'id_user');
    }

    /**
     * Check if borrowing is overdue
     */
    public function isOverdue()
    {
        if ($this->status === 'dikembalikan') {
            return false;
        }

        return Carbon::now()->greaterThan($this->batas_kembali);
    }

    /**
     * Get days overdue
     */
    public function getDaysOverdue()
    {
        if (!$this->isOverdue()) {
            return 0;
        }

        return Carbon::now()->diffInDays($this->batas_kembali);
    }

    /**
     * Calculate fine amount
     */
    public function calculateFine($finePerDay = 1000)
    {
        if (!$this->isOverdue()) {
            return 0;
        }

        return $this->getDaysOverdue() * $finePerDay;
    }

    /**
     * Get formatted status
     */
    public function getFormattedStatusAttribute()
    {
        return match($this->status) {
            'dipinjam' => 'Dipinjam',
            'dikembalikan' => 'Dikembalikan',
            'hilang' => 'Hilang',
            'terlambat' => 'Terlambat',
            default => ucfirst($this->status)
        };
    }

    /**
     * Get status color for UI
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'dipinjam' => 'primary',
            'dikembalikan' => 'success',
            'hilang' => 'danger',
            'terlambat' => 'warning',
            default => 'secondary'
        };
    }

    /**
     * Scope for active borrowings
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'dipinjam');
    }

    /**
     * Scope for overdue borrowings
     */
    public function scopeOverdue($query)
    {
        return $query->where('status', 'dipinjam')
                    ->where('batas_kembali', '<', Carbon::now());
    }

    /**
     * Scope for today's borrowings
     */
    public function scopeToday($query)
    {
        return $query->whereDate('tanggal_pinjam', Carbon::today());
    }

    /**
     * Scope for user's borrowings
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('id_user', $userId);
    }

    /**
     * Generate unique borrowing ID
     */
    public static function generateBorrowingId()
    {
        $today = Carbon::today()->format('Ymd');
        $count = self::whereDate('tanggal_pinjam', Carbon::today())->count() + 1;

        return 'PJM' . $today . str_pad($count, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Auto-update status to overdue
     */
    public static function updateOverdueStatus()
    {
        return self::where('status', 'dipinjam')
                ->where('batas_kembali', '<', Carbon::now())
                ->update(['status' => 'terlambat']);
    }

    /**
     * Process book return
     */
    public function processReturn($kondisiBuku = 'baik', $keterangan = null)
    {
        $this->tanggal_kembali = Carbon::now()->toDateString();
        $this->status = 'dikembalikan';
        $this->kondisi_buku = $kondisiBuku;

        // Calculate fine if overdue
        if ($this->isOverdue()) {
            $this->denda = (float) $this->calculateFine();
        }

        if ($keterangan) {
            $this->keterangan = $keterangan;
        }

        $result = $this->save();

        // Update book availability
        if ($result) {
            $this->book->increment('jumlah_tersedia');
        }

        return $result;
    }

    /**
     * Get formatted condition
     */
    public function getFormattedConditionAttribute()
    {
        return match($this->kondisi_buku) {
            'baik' => 'Baik',
            'rusak_ringan' => 'Rusak Ringan',
            'rusak_berat' => 'Rusak Berat',
            'hilang' => 'Hilang',
            default => ucfirst($this->kondisi_buku)
        };
    }

    /**
     * Get condition color for UI
     */
    public function getConditionColorAttribute()
    {
        return match($this->kondisi_buku) {
            'baik' => 'success',
            'rusak_ringan' => 'warning',
            'rusak_berat' => 'danger',
            'hilang' => 'dark',
            default => 'secondary'
        };
    }

    /**
     * Scope for returned borrowings today
     */
    public function scopeReturnedToday($query)
    {
        return $query->where('status', 'dikembalikan')
                    ->whereDate('tanggal_kembali', Carbon::today());
    }

    /**
     * Search by ID or book code
     */
    public static function findByIdOrBookCode($search)
    {
        return self::with(['user', 'book'])
                   ->where(function($query) use ($search) {
                       $query->where('id_peminjaman', $search)
                             ->orWhereHas('book', function($q) use ($search) {
                                 $q->where('kode_buku', $search);
                             });
                   })
                   ->where('status', '!=', 'dikembalikan')
                   ->first();
    }

    /**
     * Request extension for this loan
     */
    public function requestExtension($reason = null)
    {
        if ($this->status !== 'dipinjam' || $this->extension_status !== 'none') {
            return false;
        }

        $this->extension_status = 'requested';
        $this->extension_requested_at = Carbon::now();
        $this->extension_reason = $reason;

        return $this->save();
    }

    /**
     * Approve extension request
     */
    public function approveExtension($approverId, $extendDays = 7)
    {
        if ($this->extension_status !== 'requested') {
            return false;
        }

        $this->extension_status = 'approved';
        $this->approved_by = $approverId;
        $this->extension_approved_at = Carbon::now();
        $this->batas_kembali = Carbon::parse($this->batas_kembali)->addDays($extendDays);

        return $this->save();
    }

    /**
     * Reject extension request
     */
    public function rejectExtension($approverId, $reason = null)
    {
        if ($this->extension_status !== 'requested') {
            return false;
        }

        $this->extension_status = 'rejected';
        $this->approved_by = $approverId;
        $this->extension_approved_at = Carbon::now();
        $this->rejection_reason = $reason;

        return $this->save();
    }

    /**
     * Check if can request extension
     */
    public function canRequestExtension()
    {
        return $this->status === 'dipinjam' &&
               $this->extension_status === 'none' &&
               !$this->isOverdue();
    }

    /**
     * Get formatted extension status
     */
    public function getFormattedExtensionStatusAttribute()
    {
        return match($this->extension_status) {
            'none' => 'Tidak ada permintaan',
            'requested' => 'Menunggu persetujuan',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            default => ucfirst($this->extension_status)
        };
    }

    /**
     * Get extension status color for UI
     */
    public function getExtensionStatusColorAttribute()
    {
        return match($this->extension_status) {
            'none' => 'secondary',
            'requested' => 'warning',
            'approved' => 'success',
            'rejected' => 'danger',
            default => 'secondary'
        };
    }

    /**
     * Scope for pending extension requests
     */
    public function scopePendingExtensions($query)
    {
        return $query->where('extension_status', 'requested');
    }
}
