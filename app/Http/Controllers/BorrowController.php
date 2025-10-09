<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\Pinjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
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
     * Search user by ID or username
     */
    public function searchUser(Request $request)
    {
        $query = $request->get('query');

        $user = User::where(function($q) use ($query) {
                        $q->where('id_user', $query)
                          ->orWhere('username', $query);
                    })
                   ->where('role', 'anggota')
                   ->where('status', 'aktif')
                   ->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User dengan ID/Username tersebut tidak ditemukan atau tidak aktif'
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id_user' => $user->id_user,
                'nama_lengkap' => $user->nama_lengkap,
                'username' => $user->username,
                'email' => $user->email,
                'status' => $user->status
            ]
        ]);
    }

    /**
     * Search book by ID or kode_buku
     */
    public function searchBook(Request $request)
    {
        $query = $request->get('query');

        $book = Book::where(function($q) use ($query) {
                        $q->where('id_buku', $query)
                          ->orWhere('kode_buku', $query);
                    })->first();

        if (!$book) {
            return response()->json([
                'success' => false,
                'message' => 'Buku dengan ID/Kode tersebut tidak ditemukan'
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
                'jumlah_tersedia' => $book->jumlah_tersedia
            ]
        ]);
    }

    /**
     * Process the borrowing
     */
    public function store(Request $request)
    {
        // Log every incoming request with timestamp
        Log::info('=== BORROWING REQUEST START ===');
        Log::info('Timestamp: ' . now());
        Log::info('Request method: ' . $request->method());
        Log::info('Request URL: ' . $request->fullUrl());
        Log::info('Request headers:', $request->headers->all());
        Log::info('All request data:', $request->all());
        Log::info('Raw input: ' . $request->getContent());
        Log::info('User authenticated: ' . (Auth::check() ? 'YES' : 'NO'));
        if (Auth::check()) {
            Log::info('Current user:', [
                'id' => Auth::user()->id_user,
                'username' => Auth::user()->username,
                'role' => Auth::user()->role
            ]);
        }

        $request->validate([
            'id_user' => 'required|string',
            'id_buku' => 'required|string',
            'batas_kembali' => 'required|date|after:today'
        ]);

        // Add debugging
        Log::info('Borrowing request received after validation:', $request->all());

        try {
            DB::beginTransaction();

            // Search user by ID or username
            $user = User::where(function($query) use ($request) {
                        $query->where('id_user', $request->id_user)
                              ->orWhere('username', $request->id_user);
                    })
                    ->where('status', 'aktif')
                    ->where('role', 'anggota')
                    ->first();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User dengan ID/Username tersebut tidak ditemukan atau tidak aktif'
                ]);
            }

            // Search book by ID or kode_buku
            $book = Book::where(function($query) use ($request) {
                        $query->where('id_buku', $request->id_buku)
                              ->orWhere('kode_buku', $request->id_buku);
                    })->first();

            if (!$book || !$book->isAvailable()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Buku dengan ID/Kode tersebut tidak ditemukan atau tidak tersedia'
                ]);
            }

            // Check if user has reached borrowing limit (max 3 books)
            $activeBorrowings = Pinjaman::where('id_user', $user->id_user)
                                      ->where('status', 'dipinjam')
                                      ->count();

            if ($activeBorrowings >= 3) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anggota telah mencapai batas maksimal peminjaman (3 buku)'
                ]);
            }

            // Check if user has overdue books
            $overdueBooks = Pinjaman::where('id_user', $user->id_user)
                                  ->where('status', 'dipinjam')
                                  ->where('batas_kembali', '<', Carbon::now())
                                  ->count();

            if ($overdueBooks > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anggota memiliki buku yang terlambat dikembalikan'
                ]);
            }

            // Log the data being inserted for debugging
            Log::info('Creating peminjaman with data:', [
                'id_user' => $user->id_user,
                'id_buku' => $book->id_buku,
                'tanggal_pinjam' => Carbon::now()->format('Y-m-d'),
                'batas_kembali' => $request->batas_kembali,
                'status' => 'dipinjam',
                'denda' => 0.00,
                'keterangan' => $request->keterangan
            ]);

            // Create borrowing record
            $pinjaman = Pinjaman::create([
                'id_user' => $user->id_user,
                'id_buku' => $book->id_buku,
                'tanggal_pinjam' => Carbon::now()->format('Y-m-d'),
                'batas_kembali' => $request->batas_kembali,
                'status' => 'dipinjam',
                'denda' => 0.00,
                'keterangan' => $request->keterangan
            ]);

            Log::info('Peminjaman created successfully:', ['id_peminjaman' => $pinjaman->id_peminjaman]);

            // Update book availability
            $book->decrement('jumlah_tersedia');

            DB::commit();

            // Load relationships for response
            $pinjaman->load(['user', 'book']);

            Log::info('=== BORROWING SUCCESS ===');
            Log::info('Created peminjaman ID: ' . $pinjaman->id_peminjaman);

            return response()->json([
                'success' => true,
                'message' => 'Peminjaman berhasil diproses',
                'data' => [
                    'id_peminjaman' => $pinjaman->id_peminjaman,
                    'borrowing_id' => 'PJM' . str_pad($pinjaman->id_peminjaman, 6, '0', STR_PAD_LEFT),
                    'user_name' => $pinjaman->user->nama_lengkap,
                    'book_title' => $pinjaman->book->judul_buku,
                    'tanggal_pinjam' => Carbon::parse($pinjaman->tanggal_pinjam)->format('d/m/Y'),
                    'batas_kembali' => Carbon::parse($pinjaman->batas_kembali)->format('d/m/Y'),
                    'status' => $pinjaman->formatted_status
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollback();

            Log::error('=== BORROWING ERROR ===');
            Log::error('Error creating peminjaman:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

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
                    'time' => Carbon::parse($pinjaman->tanggal_pinjam)->format('H:i'),
                    'batas_kembali' => Carbon::parse($pinjaman->batas_kembali)->format('d M Y'),
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
