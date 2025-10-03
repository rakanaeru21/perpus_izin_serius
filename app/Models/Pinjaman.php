<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Pinjaman extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'peminjaman';

    /**
     * The primary key associated with the table.
     */
    protected $primaryKey = 'id_peminjaman';

    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id_user',
        'id_buku',
        'tanggal_pinjam',
        'batas_kembali',
        'tanggal_kembali',
        'status',
        'denda',
        'keterangan'
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'tanggal_pinjam' => 'date',
        'batas_kembali' => 'date',
        'tanggal_kembali' => 'date',
        'denda' => 'decimal:2'
    ];

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
}
