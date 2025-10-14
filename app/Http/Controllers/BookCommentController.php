<?php

namespace App\Http\Controllers;

use App\Models\BookComment;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BookCommentController extends Controller
{
    /**
     * Get comments for a specific book
     */
    public function getComments($bookId)
    {
        try {
            $book = Book::find($bookId);

            if (!$book) {
                return response()->json([
                    'success' => false,
                    'message' => 'Buku tidak ditemukan'
                ], 404);
            }

            $comments = BookComment::where('id_buku', $bookId)
                ->with('user:id_user,nama_lengkap')
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($comment) {
                    return [
                        'id' => $comment->id,
                        'user_name' => $comment->user->nama_lengkap ?? 'Anonymous',
                        'rating' => $comment->rating,
                        'comment' => $comment->comment,
                        'created_at' => $comment->created_at->format('Y-m-d H:i:s'),
                        'formatted_date' => $comment->created_at->format('d M Y, H:i')
                    ];
                });

            $averageRating = $book->average_rating;
            $totalComments = $book->comments_count;

            return response()->json([
                'success' => true,
                'data' => [
                    'comments' => $comments,
                    'statistics' => [
                        'total_comments' => $totalComments,
                        'average_rating' => round($averageRating, 1)
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil komentar'
            ], 500);
        }
    }

    /**
     * Store a new comment
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id_buku' => 'required|exists:buku,id_buku',
                'rating' => 'required|integer|min:1|max:5',
                'comment' => 'required|string|min:5|max:1000'
            ], [
                'id_buku.required' => 'ID buku harus diisi',
                'id_buku.exists' => 'Buku tidak ditemukan',
                'rating.required' => 'Rating harus diisi',
                'rating.integer' => 'Rating harus berupa angka',
                'rating.min' => 'Rating minimal 1',
                'rating.max' => 'Rating maksimal 5',
                'comment.required' => 'Komentar harus diisi',
                'comment.min' => 'Komentar minimal 5 karakter',
                'comment.max' => 'Komentar maksimal 1000 karakter'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak valid',
                    'errors' => $validator->errors()
                ], 422);
            }

            $userId = Auth::user()->getKey();

            if (!$userId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda harus login terlebih dahulu'
                ], 401);
            }

            // Check if user already commented on this book
            $existingComment = BookComment::where('id_buku', $request->id_buku)
                ->where('id_user', $userId)
                ->first();

            if ($existingComment) {
                // Update existing comment
                $existingComment->update([
                    'rating' => $request->rating,
                    'comment' => $request->comment
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Komentar berhasil diperbarui',
                    'data' => $existingComment
                ]);
            } else {
                // Create new comment
                $comment = BookComment::create([
                    'id_buku' => $request->id_buku,
                    'id_user' => $userId,
                    'rating' => $request->rating,
                    'comment' => $request->comment
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Komentar berhasil ditambahkan',
                    'data' => $comment
                ]);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan komentar'
            ], 500);
        }
    }

    /**
     * Update an existing comment
     */
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'rating' => 'required|integer|min:1|max:5',
                'comment' => 'required|string|min:5|max:1000'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak valid',
                    'errors' => $validator->errors()
                ], 422);
            }

            $comment = BookComment::find($id);

            if (!$comment) {
                return response()->json([
                    'success' => false,
                    'message' => 'Komentar tidak ditemukan'
                ], 404);
            }

            // Check if user owns this comment
            if ($comment->id_user !== Auth::user()->getKey()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki akses untuk mengubah komentar ini'
                ], 403);
            }

            $comment->update([
                'rating' => $request->rating,
                'comment' => $request->comment
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Komentar berhasil diperbarui',
                'data' => $comment
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui komentar'
            ], 500);
        }
    }

    /**
     * Delete a comment
     */
    public function destroy($id)
    {
        try {
            $comment = BookComment::find($id);

            if (!$comment) {
                return response()->json([
                    'success' => false,
                    'message' => 'Komentar tidak ditemukan'
                ], 404);
            }

            // Check if user owns this comment
            if ($comment->id_user !== Auth::user()->getKey()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki akses untuk menghapus komentar ini'
                ], 403);
            }

            $comment->delete();

            return response()->json([
                'success' => true,
                'message' => 'Komentar berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus komentar'
            ], 500);
        }
    }
}
