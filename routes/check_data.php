<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Book;
use App\Models\Pinjaman;

Route::get('/check-data', function() {
    $users = User::where('role', 'anggota')->get();
    $books = Book::get();
    $borrowings = Pinjaman::with(['user', 'book'])->get();

    return [
        'users_count' => $users->count(),
        'users' => $users->map(function($u) {
            return ['id' => $u->id_user, 'name' => $u->nama_lengkap, 'role' => $u->role];
        }),
        'books_count' => $books->count(),
        'books' => $books->map(function($b) {
            return ['id' => $b->id_buku, 'title' => $b->judul_buku, 'available' => $b->jumlah_tersedia];
        }),
        'borrowings_count' => $borrowings->count(),
        'active_borrowings' => $borrowings->where('status', '!=', 'dikembalikan')->count()
    ];
});
