<?php

use Illuminate\Support\Facades\Route;

Route::get('/test-peminjaman', function () {
    try {
        // Data test
        $userData = [
            'id_user' => '2', // atau 'rj'
            'id_buku' => '1', // atau 'BK001'
            'tanggal_pinjam' => date('Y-m-d'),
            'batas_kembali' => date('Y-m-d', strtotime('+7 days')),
            'status' => 'dipinjam',
            'denda' => 0.00,
            'keterangan' => 'Test peminjaman via script'
        ];

        // Cari user
        $user = App\Models\User::where(function($query) use ($userData) {
                    $query->where('id_user', $userData['id_user'])
                          ->orWhere('username', $userData['id_user']);
                })
                ->where('status', 'aktif')
                ->where('role', 'anggota')
                ->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan',
                'debug' => $userData
            ]);
        }

        // Cari buku
        $book = App\Models\Book::where(function($query) use ($userData) {
                    $query->where('id_buku', $userData['id_buku'])
                          ->orWhere('kode_buku', $userData['id_buku']);
                })->first();

        if (!$book || !$book->isAvailable()) {
            return response()->json([
                'success' => false,
                'message' => 'Buku tidak ditemukan atau tidak tersedia',
                'debug' => $userData
            ]);
        }

        // Buat record peminjaman
        $pinjaman = App\Models\Pinjaman::create([
            'id_user' => $user->id_user,
            'id_buku' => $book->id_buku,
            'tanggal_pinjam' => $userData['tanggal_pinjam'],
            'batas_kembali' => $userData['batas_kembali'],
            'status' => 'dipinjam',
            'denda' => 0.00,
            'keterangan' => $userData['keterangan']
        ]);

        // Update jumlah buku tersedia
        $book->decrement('jumlah_tersedia');

        return response()->json([
            'success' => true,
            'message' => 'Peminjaman berhasil dicatat',
            'data' => [
                'id_peminjaman' => $pinjaman->id_peminjaman,
                'user' => $user->nama_lengkap,
                'book' => $book->judul_buku,
                'tanggal_pinjam' => $pinjaman->tanggal_pinjam,
                'batas_kembali' => $pinjaman->batas_kembali,
                'status' => $pinjaman->status
            ]
        ]);

    } catch (Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage(),
            'debug' => $userData ?? null
        ]);
    }
});

// Route untuk verifikasi data peminjaman
Route::get('/verify-peminjaman', function () {
    $peminjaman = App\Models\Pinjaman::with(['user', 'book'])->orderBy('id_peminjaman', 'desc')->get();
    $todayCount = App\Models\Pinjaman::whereDate('tanggal_pinjam', today())->count();
    $bookAvailable = App\Models\Book::find(1)->jumlah_tersedia ?? 0;

    return view('verify_peminjaman', compact('peminjaman', 'todayCount', 'bookAvailable'));
});
