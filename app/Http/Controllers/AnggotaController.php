<?php

namespace App\Http\Controllers;

use App\Models\Pinjaman;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AnggotaController extends Controller
{
    /**
     * Display user's loan page
     */
    public function loans()
    {
        $userId = Auth::id();

        // Get statistics for the cards
        $sedangDipinjam = Pinjaman::where('id_user', $userId)
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->count();

        $jatuhTempo = Pinjaman::where('id_user', $userId)
            ->where('status', 'dipinjam')
            ->whereDate('batas_kembali', '<=', Carbon::today())
            ->count();

        $dikembalikan = Pinjaman::where('id_user', $userId)
            ->where('status', 'dikembalikan')
            ->count();

        $terlambat = Pinjaman::where('id_user', $userId)
            ->where('status', 'terlambat')
            ->count();

        // Get active borrowings with book details
        $activeBorrowings = Pinjaman::with(['book'])
            ->where('id_user', $userId)
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->orderBy('tanggal_pinjam', 'desc')
            ->get();

        // Update status for overdue books
        $this->updateOverdueStatus($userId);

        $statistics = [
            'sedangDipinjam' => $sedangDipinjam,
            'jatuhTempo' => $jatuhTempo,
            'dikembalikan' => $dikembalikan,
            'terlambat' => $terlambat
        ];

        return view('dashboard.anggota.loans', compact('statistics', 'activeBorrowings'));
    }

    /**
     * Extend loan period for a book
     */
    public function extendLoan(Request $request)
    {
        $request->validate([
            'id_peminjaman' => 'required|exists:peminjaman,id_peminjaman'
        ]);

        $userId = Auth::id();
        $pinjaman = Pinjaman::where('id_peminjaman', $request->id_peminjaman)
            ->where('id_user', $userId)
            ->where('status', 'dipinjam')
            ->first();

        if (!$pinjaman) {
            return response()->json([
                'success' => false,
                'message' => 'Pinjaman tidak ditemukan atau tidak dapat diperpanjang'
            ]);
        }

        // Check if book can be extended (e.g., not overdue, hasn't been extended multiple times)
        if ($pinjaman->isOverdue()) {
            return response()->json([
                'success' => false,
                'message' => 'Buku yang sudah terlambat tidak dapat diperpanjang'
            ]);
        }

        // Extend the due date by 7 days
        $newDueDate = Carbon::parse($pinjaman->batas_kembali)->addDays(7);
        $pinjaman->batas_kembali = $newDueDate;
        $pinjaman->save();

        return response()->json([
            'success' => true,
            'message' => 'Pinjaman berhasil diperpanjang hingga ' . $newDueDate->format('d M Y')
        ]);
    }

    /**
     * Update overdue status for user's loans
     */
    private function updateOverdueStatus($userId)
    {
        Pinjaman::where('id_user', $userId)
            ->where('status', 'dipinjam')
            ->where('batas_kembali', '<', Carbon::today())
            ->update(['status' => 'terlambat']);
    }

    /**
     * Get loan history for the user
     */
    public function loanHistory()
    {
        $userId = Auth::id();

        $loanHistory = Pinjaman::with(['book'])
            ->where('id_user', $userId)
            ->orderBy('tanggal_pinjam', 'desc')
            ->paginate(10);

        // Get statistics for all loans (not just paginated)
        $statistics = [
            'total' => Pinjaman::where('id_user', $userId)->count(),
            'dikembalikan' => Pinjaman::where('id_user', $userId)->where('status', 'dikembalikan')->count(),
            'terlambat' => Pinjaman::where('id_user', $userId)->where('status', 'terlambat')->count(),
            'sedang_dipinjam' => Pinjaman::where('id_user', $userId)->whereIn('status', ['dipinjam', 'terlambat'])->count()
        ];

        return view('dashboard.anggota.loan-history', compact('loanHistory', 'statistics'));
    }
}
