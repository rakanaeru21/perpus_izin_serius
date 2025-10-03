<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Book;
use App\Models\Pinjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BorrowController extends Controller
{
    /**
     * Show the borrowing page
     */
    public function index()
    {
        $todayBorrowings = Pinjaman::with(['user', 'book'])
            ->today()
            ->orderBy('id_peminjaman', 'desc')
            ->get();

        return view('dashboard.petugas.borrow', compact('todayBorrowings'));
    }

    /**
     * Search user by ID or name
     */
    public function searchUser(Request $request)
    {
        $query = $request->get('query');

        $user = User::where('id        _user', $query)
                   ->orWhere('nama_lengkap', 'LIKE', '%' . $query . '%')
                   ->orWhere('username', 'LIKE', '%' . $query . '%')
                   ->where('role', 'anggota')
                   ->where('status', 'aktif')
                   ->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Anggota tidak ditemukan atau tidak aktif'
            ]);
        }

        // Get user's borrowing statistics
        $activeBorrowings = Pinjaman::where('id_user', $user->id_user)
                                  ->where('status', 'dipinjam')
                                  ->count();

        $overdueBorrowings = Pinjaman::where('id_user', $user->id_user)
                                   ->where('status', 'terlambat')
                                   ->count();

        $totalFines = Pinjaman::where('id_user', $user->id_user)
                             ->whereIn('status', ['terlambat', 'dikembalikan'])
                             ->sum('denda');

        return response()->json([
            'success' => true,
            'data' => [
                'id_user' => $user->id_user,
                'nama_lengkap' => $user->nama_lengkap,
                'username' => $user->username,
                'email' => $user->email,
                'status' => $user->status,
                'active_borrowings' => $activeBorrowings,
                'overdue_borrowings' => $overdueBorrowings,
                'total_fines' => $totalFines
            ]
        ]);
    }

    /**
     * Search book by ID or title
     */
    public function searchBook(Request $request)
    {
        $query = $request->get('query');

        $book = Book::where('id_buku', $query)
                   ->orWhere('kod        e_buku', $query)
                   ->orWhere('judul_buku', 'LIKE', '%' . $query . '%')
                   ->first();

        if (!$book) {
            return response()->json([
                'success' => false,
                'message' => 'Buku tidak ditemukan'
            ]);
        }

        if (!$book->isAvailable()) {
            return response()->json([
                'success' => false,
                'message' => 'Buku tidak tersedia untuk dipinjam'
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id_buku' => $book->id_buku,
                'kode_buku' => $book->kode_buku,
                'judul_buku' => $book->judul_buku,
                'penulis' => $book->penulis,
                'penerbit' => $book->penerbit,
                'jumlah_tersedia' => $book->jumlah_tersedia,
                'rak' => $book->rak
            ]
        ]);
    }

    /**
     * Process the borrowing
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'required|exists:user,id_user',
            'id_buku' => 'required|exists:buku,id_buku',
            'batas_kembali' => 'required|date|after:today'
        ]);

        try {
            DB::beginTransaction();

            // Check if user exists and is active
            $user = User::where('id_user', $request->id_user)
                       ->where('status', 'aktif')
                       ->where('role', 'anggota')
                       ->first();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anggota tidak ditemukan atau tidak aktif'
                ]);
            }

            // Check if book exists and is available
            $book = Book::where('id_buku', $request->id_buku)->first();

            if (!$book || !$book->isAvailable()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Buku tidak tersedia untuk dipinjam'
                ]);
            }

            // Check if user has reached borrowing limit (max 3 books)
            $activeBorrowings = Pinjaman::where('id_user', $request->id_user)
                                      ->where('status', 'dipinjam')
                                      ->count();

            if ($activeBorrowings >= 3) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anggota telah mencapai batas maksimal peminjaman (3 buku)'
                ]);
            }

            // Check if user has overdue books
            $overdueBooks = Pinjaman::where('id_user', $request->id_user)
                                  ->where('status', 'dipinjam')
                                  ->where('batas_kembali', '<', Carbon::now())
                                  ->count();

            if ($overdueBooks > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anggota memiliki buku yang terlambat dikembalikan'
                ]);
            }

            // Create borrowing record
            $pinjaman = Pinjaman::create([
                'id_user' => $request->id_user,
                'id_buku' => $request->id_buku,
                'tanggal_pinjam' => Carbon::now()->toDateString(),
                'batas_kembali' => $request->batas_kembali,
                'status' => 'dipinjam',
                'denda' => 0.00,
                'keterangan' => $request->keterangan
            ]);

            // Update book availability
            $book->decrement('jumlah_tersedia');

            DB::commit();

            // Load relationships for response
            $pinjaman->load(['user', 'book']);

            return response()->json([
                'success' => true,
                'message' => 'Peminjaman berhasil diproses',
                'data' => [
                    'id_peminjaman' => $pinjaman->id_peminjaman,
                    'borrowing_id' => 'PJM' . str_pad($pinjaman->id_peminjaman, 6, '0', STR_PAD_LEFT),
                    'user_name' => $pinjaman->user->nama_lengkap,
                    'book_title' => $pinjaman->book->judul_buku,
                    'tanggal_pinjam' => $pinjaman->tanggal_pinjam->format('d/m/Y'),
                    'batas_kembali' => $pinjaman->batas_kembali->format('d/m/Y'),
                    'status' => $pinjaman->formatted_status
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses peminjaman: ' . $e->getMessage()
            ], 500);
        }
    }

                /**
     * Get today's borrowings
     */
    public function getTodayBorrowings()
    {
        $borrowings = Pinjaman::with(['user', 'book'])
            ->today()
            ->orderBy('id_peminjaman', 'desc')
            ->get()
            ->map(function ($pinjaman) {
                return [
                    'id_peminjaman' => $pinjaman->id_peminjaman,
                    'borrowing_id' => 'PJM' . str_pad($pinjaman->id_peminjaman, 6, '0', STR_PAD_LEFT),
                    'user_name' => $pinjaman->user->nama_lengkap,
                    'book_title' => $pinjaman->book->judul_buku,
                    'time' => $pinjaman->created_at ? $pinjaman->created_at->format('H:i') : 'N/A',
                    'batas_kembali' => $pinjaman->batas_kembali->format('d M Y'),
                    'status' => $pinjaman->formatted_status,
                    'status_color' => $pinjaman->status_color
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $borrowings
        ]);
    }
}
