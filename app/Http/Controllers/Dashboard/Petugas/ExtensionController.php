<?php

namespace App\Http\Controllers\Dashboard\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Pinjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExtensionController extends Controller
{
    /**
     * Display extension requests
     */
    public function index()
    {
        $pendingRequests = Pinjaman::with(['user', 'book'])
            ->pendingExtensions()
            ->orderBy('extension_requested_at', 'desc')
            ->paginate(10);

        $approvedRequests = Pinjaman::with(['user', 'book', 'approver'])
            ->where('extension_status', 'approved')
            ->orderBy('extension_approved_at', 'desc')
            ->paginate(10);

        $rejectedRequests = Pinjaman::with(['user', 'book', 'approver'])
            ->where('extension_status', 'rejected')
            ->orderBy('extension_approved_at', 'desc')
            ->paginate(10);

        $statistics = [
            'pending' => Pinjaman::pendingExtensions()->count(),
            'approved_today' => Pinjaman::where('extension_status', 'approved')
                ->whereDate('extension_approved_at', today())->count(),
            'rejected_today' => Pinjaman::where('extension_status', 'rejected')
                ->whereDate('extension_approved_at', today())->count(),
            'total_approved' => Pinjaman::where('extension_status', 'approved')->count(),
        ];

        return view('dashboard.petugas.extensions.index', compact(
            'pendingRequests',
            'approvedRequests',
            'rejectedRequests',
            'statistics'
        ));
    }

    /**
     * Approve extension request
     */
    public function approve(Request $request, $id)
    {
        $request->validate([
            'extend_days' => 'nullable|integer|min:1|max:14'
        ]);

        $pinjaman = Pinjaman::with(['user', 'book'])->findOrFail($id);

        if ($pinjaman->extension_status !== 'requested') {
            return response()->json([
                'success' => false,
                'message' => 'Permintaan perpanjangan tidak valid'
            ]);
        }

        $extendDays = $request->extend_days ?? 7;

        if ($pinjaman->approveExtension(Auth::id(), $extendDays)) {
            return response()->json([
                'success' => true,
                'message' => "Permintaan perpanjangan untuk buku '{$pinjaman->book->judul_buku}' telah disetujui untuk {$extendDays} hari."
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyetujui permintaan perpanjangan'
            ]);
        }
    }

    /**
     * Reject extension request
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:500'
        ]);

        $pinjaman = Pinjaman::with(['user', 'book'])->findOrFail($id);

        if ($pinjaman->extension_status !== 'requested') {
            return response()->json([
                'success' => false,
                'message' => 'Permintaan perpanjangan tidak valid'
            ]);
        }

        if ($pinjaman->rejectExtension(Auth::id(), $request->reason)) {
            return response()->json([
                'success' => true,
                'message' => "Permintaan perpanjangan untuk buku '{$pinjaman->book->judul_buku}' telah ditolak."
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menolak permintaan perpanjangan'
            ]);
        }
    }

    /**
     * Get extension request details
     */
    public function show($id)
    {
        $pinjaman = Pinjaman::with(['user', 'book', 'approver'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => [
                'id_peminjaman' => $pinjaman->id_peminjaman,
                'user_name' => $pinjaman->user->nama,
                'book_title' => $pinjaman->book->judul_buku,
                'borrow_date' => $pinjaman->tanggal_pinjam->format('d M Y'),
                'due_date' => $pinjaman->batas_kembali->format('d M Y'),
                'extension_reason' => $pinjaman->extension_reason,
                'extension_requested_at' => $pinjaman->extension_requested_at->format('d M Y H:i'),
                'extension_status' => $pinjaman->extension_status,
                'can_approve' => $pinjaman->extension_status === 'requested'
            ]
        ]);
    }
}
