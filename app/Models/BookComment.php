<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookComment extends Model
{
    use HasFactory;

    protected $table = 'book_comments';

    protected $fillable = [
        'id_buku',
        'id_user',
        'rating',
        'comment'
    ];

    protected $casts = [
        'rating' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the book that this comment belongs to
     */
    public function book()
    {
        return $this->belongsTo(Book::class, 'id_buku', 'id_buku');
    }

    /**
     * Get the user who made this comment
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    /**
     * Scope to get comments for a specific book
     */
    public function scopeForBook($query, $bookId)
    {
        return $query->where('id_buku', $bookId);
    }

    /**
     * Scope to get comments by a specific user
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('id_user', $userId);
    }

    /**
     * Scope to order by newest first
     */
    public function scopeNewest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Get average rating for a book
     */
    public static function averageRatingForBook($bookId)
    {
        return self::where('id_buku', $bookId)->avg('rating');
    }

    /**
     * Get total comments count for a book
     */
    public static function countForBook($bookId)
    {
        return self::where('id_buku', $bookId)->count();
    }
}
