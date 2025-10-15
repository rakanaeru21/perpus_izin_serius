<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $table = 'user';
    protected $primaryKey = 'id_user';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama_lengkap',
        'username',
        'email',
        'password',
        'no_hp',
        'alamat',
        'role',
        'status',
        'foto_profil',
        'tanggal_daftar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tanggal_daftar' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return $this->primaryKey; // Use the primary key for authentication
    }

    /**
     * Find user by username or email for authentication
     */
    public static function findForAuth($credential)
    {
        return static::where('username', $credential)
                    ->orWhere('email', $credential)
                    ->first();
    }

    /**
     * Get the user's favorite books.
     */
    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'user_id', 'id_user');
    }

    /**
     * Get the books that this user has favorited.
     */
    public function favoriteBooks()
    {
        return $this->belongsToMany(Book::class, 'favorites', 'user_id', 'id_buku', 'id_user', 'id_buku')
                    ->withTimestamps();
    }

    /**
     * Check if the user has favorited a specific book.
     */
    public function hasFavorited($bookId)
    {
        return $this->favorites()->where('id_buku', $bookId)->exists();
    }
}
