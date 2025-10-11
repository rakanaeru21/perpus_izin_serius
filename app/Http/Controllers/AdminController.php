<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display members management page
     */
    public function members(Request $request)
    {
        $query = User::where('role', 'anggota');

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'LIKE', '%' . $search . '%')
                  ->orWhere('email', 'LIKE', '%' . $search . '%')
                  ->orWhere('username', 'LIKE', '%' . $search . '%')
                  ->orWhere('no_hp', 'LIKE', '%' . $search . '%');
            });
        }

        // Status filter
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        $members = $query->orderBy('tanggal_daftar', 'desc')->paginate(10);

        // If this is an AJAX request, return JSON
        if ($request->ajax()) {
            return response()->json([
                'members' => $members->items(),
                'pagination' => [
                    'current_page' => $members->currentPage(),
                    'last_page' => $members->lastPage(),
                    'per_page' => $members->perPage(),
                    'total' => $members->total()
                ]
            ]);
        }

        return view('dashboard.admin.members', compact('members'));
    }

    /**
     * Show member details
     */
    public function showMember($id)
    {
        $member = User::where('role', 'anggota')
                     ->where('id_user', $id)
                     ->firstOrFail();

        return response()->json($member);
    }

    /**
     * Update member status
     */
    public function updateMemberStatus(Request $request, $id)
    {
        $member = User::where('role', 'anggota')
                     ->where('id_user', $id)
                     ->firstOrFail();

        $request->validate([
            'status' => 'required|in:aktif,nonaktif'
        ]);

        $member->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Status anggota berhasil diperbarui'
        ]);
    }

    /**
     * Delete member
     */
    public function deleteMember($id)
    {
        $member = User::where('role', 'anggota')
                     ->where('id_user', $id)
                     ->firstOrFail();

        $member->delete();

        return response()->json([
            'success' => true,
            'message' => 'Anggota berhasil dihapus'
        ]);
    }
}
