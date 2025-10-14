<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'buku';

    /**
     * The primary key associated with the table.
     */
    protected $primaryKey = 'id_buku';

    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'kode_buku',
        'judul_buku',
        'penulis',
        'penerbit',
        'tahun_terbit',
        'kategori',
        'rak',
        'jumlah_total',
        'jumlah_tersedia',
        'deskripsi',
        'cover',
        'tanggal_input'
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'tahun_terbit' => 'integer',
        'jumlah_total' => 'integer',
        'jumlah_tersedia' => 'integer',
        'tanggal_input' => 'datetime'
    ];

    /**
     * Get the cover image URL
     */
    public function getCoverUrlAttribute()
    {
        if ($this->cover && $this->cover !== 'default_cover.png') {
            return asset('storage/covers/' . $this->cover);
        }
        return asset('images/default_cover.png');
    }

    /**
     * Check if book is available for borrowing
     */
    public function isAvailable()
    {
        return $this->jumlah_tersedia > 0;
    }

    /**
     * Get borrowed count for this book
     */
    public function getBorrowedCountAttribute()
    {
        return $this->jumlah_total - $this->jumlah_tersedia;
    }

    /**
     * Relationship with peminjaman (borrowings)
     */
    public function peminjaman()
    {
        return $this->hasMany(Pinjaman::class, 'id_buku', 'id_buku');
    }

    /**
     * Get current active borrowings
     */
    public function activeBorrowings()
    {
        return $this->hasMany(Pinjaman::class, 'id_buku', 'id_buku')
            ->where('status', 'dipinjam');
    }

    /**
     * Scope to filter available books
     */
    public function scopeAvailable($query)
    {
        return $query->where('jumlah_tersedia', '>', 0);
    }

    /**
     * Scope to search books
     */
    public function scopeSearch($query, $term)
    {
        return $query->where(function($q) use ($term) {
            $q->where('judul_buku', 'LIKE', '%' . $term . '%')
              ->orWhere('penulis', 'LIKE', '%' . $term . '%')
              ->orWhere('kode_buku', 'LIKE', '%' . $term . '%')
              ->orWhere('kategori', 'LIKE', '%' . $term . '%');
        });
    }

    /**
     * Scope to filter by category
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('kategori', $category);
    }

    /**
     * Get formatted publication year
     */
    public function getFormattedYearAttribute()
    {
        return $this->tahun_terbit ? $this->tahun_terbit : 'Tidak diketahui';
    }

    /**
     * Get availability status text
     */
    public function getAvailabilityStatusAttribute()
    {
        if ($this->jumlah_tersedia > 0) {
            return 'Tersedia (' . $this->jumlah_tersedia . ')';
        }
        return 'Tidak tersedia';
    }

    /**
     * Get stock status color for UI
     */
    public function getStockStatusColorAttribute()
    {
        if ($this->jumlah_tersedia === 0) {
            return 'danger';
        } elseif ($this->jumlah_tersedia <= 2) {
            return 'warning';
        }
        return 'success';
    }

    /**
     * Relationship with book comments
     */
    public function comments()
    {
        return $this->hasMany(BookComment::class, 'id_buku', 'id_buku');
    }

    /**
     * Get average rating for this book
     */
    public function getAverageRatingAttribute()
    {
        return $this->comments()->avg('rating') ?? 0;
    }

    /**
     * Get total comments count for this book
     */
    public function getCommentsCountAttribute()
    {
        return $this->comments()->count();
    }

    /**
     * Get latest comments for this book
     */
    public function latestComments($limit = 5)
    {
        return $this->comments()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}
