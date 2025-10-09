<?php

namespace App\Http\Controllers\Dashboard\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Pinjaman;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReturnController extends Controller
{
    /**
     * Display the return form
     */
    public function index()
    {
        // Get today's returns
        $todayReturns = Pinjaman::with(['user', 'book'])
            ->returnedToday()
            ->orderBy('tanggal_kembali', 'desc')
            ->get();

        return view('dashboard.petugas.return', compact('todayReturns'));
    }

    /**
     * Search for borrowing by ID or book code
     */
    public function search(Request $request)
    {
        $request->validate([
            'search' => 'required|string'
        ]);

        $borrowing = Pinjaman::findByIdOrBookCode($request->search);

        if (!$borrowing) {
            return response()->json([
                'success' => false,
                'message' => 'Peminjaman tidak ditemukan atau sudah dikembalikan'
            ]);
        }

        // Get member's borrowing history
        $history = Pinjaman::with('book')
            ->where('id_user', $borrowing->id_user)
            ->where('status', 'dikembalikan')
            ->orderBy('tanggal_kembali', 'desc')
            ->limit(5)
            ->get();

        // Calculate fine
        $daysOverdue = $borrowing->getDaysOverdue();
        $fine = $borrowing->calculateFine();

        return response()->json([
            'success' => true,
            'data' => [
                'borrowing' => $borrowing,
                'member_name' => $borrowing->user->nama_lengkap,
                'book_title' => $borrowing->book->judul_buku,
                'borrow_date' => Carbon::parse($borrowing->tanggal_pinjam)->format('d/m/Y'),
                'due_date' => Carbon::parse($borrowing->batas_kembali)->format('d/m/Y'),
                'days_overdue' => $daysOverdue,
                'fine' => $fine,
                'history' => $history->map(function($item) {
                    return [
                        'book_title' => $item->book->judul_buku,
                        'return_date' => Carbon::parse($item->tanggal_kembali)->format('d/m/Y'),
                        'condition' => $item->formatted_condition,
                        'fine' => $item->denda
                    ];
                })
            ]
        ]);
    }

    /**
     * Process the book return
     */
    public function processReturn(Request $request)
    {
        $request->validate([
            'id_peminjaman' => 'required|exists:peminjaman,id_peminjaman',
            'kondisi_buku' => 'required|in:baik,rusak_ringan,rusak_berat,hilang',
            'keterangan' => 'nullable|string|max:500'
        ]);

        try {
            DB::beginTransaction();

            $borrowing = Pinjaman::with(['user', 'book'])->findOrFail($request->id_peminjaman);

            // Check if already returned
            if ($borrowing->status === 'dikembalikan') {
                return response()->json([
                    'success' => false,
                    'message' => 'Buku sudah dikembalikan sebelumnya'
                ]);
            }

            // Process return
            $result = $borrowing->processReturn(
                $request->kondisi_buku,
                $request->keterangan
            );

            if ($result) {
                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Pengembalian buku berhasil diproses',
                    'data' => [
                        'return_time' => $borrowing->tanggal_kembali,
                        'fine' => $borrowing->denda,
                        'condition' => $borrowing->formatted_condition
                    ]
                ]);
            } else {
                DB::rollback();
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memproses pengembalian'
                ]);
            }

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Get today's returns data
     */
    public function getTodayReturns()
    {
        $returns = Pinjaman::with(['user', 'book'])
            ->returnedToday()
            ->orderBy('tanggal_kembali', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $returns->map(function($return, $index) {
                return [
                    'no' => $index + 1,
                    'id_peminjaman' => 'PJM' . str_pad($return->id_peminjaman, 3, '0', STR_PAD_LEFT),
                    'member_name' => $return->user->nama_lengkap,
                    'book_title' => $return->book->judul_buku,
                    'return_time' => Carbon::parse($return->tanggal_kembali)->format('H:i'),
                    'condition' => $return->formatted_condition,
                    'condition_color' => $return->condition_color,
                    'fine' => 'Rp ' . number_format((float)$return->denda, 0, ',', '.'),
                    'status' => 'Selesai'
                ];
            })
        ]);
    }
}
