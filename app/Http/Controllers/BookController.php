<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\Book;
use Carbon\Carbon;

class BookController extends Controller
{
    /**
     * Display a listing of books.
     */
    public function index()
    {
        try {
            $books = DB::table('buku')
                ->select([
                    'id_buku',
                    'kode_buku',
                    'judul_buku',
                    'penulis',
                    'penerbit',
                    'tahun_terbit',
                    'kategori',
                    'rak',
                    'jumlah_total',
                    'jumlah_tersedia',
                    'cover',
                    'tanggal_input'
                ])
                ->orderBy('tanggal_input', 'desc')
                ->get();

            return view('dashboard.admin.books', compact('books'));
        } catch (\Exception $e) {
            // Return empty collection if table doesn't exist yet
            $books = collect();
            return view('dashboard.admin.books', compact('books'));
        }
    }

    /**
     * Store a newly created book in storage.
     */
    public function store(Request $request)
    {
        // Debugging log
        Log::info('Book store request received');
        Log::info('Has file: ' . ($request->hasFile('cover') ? 'Yes' : 'No'));

        if ($request->hasFile('cover')) {
            Log::info('File name: ' . $request->file('cover')->getClientOriginalName());
            Log::info('File size: ' . $request->file('cover')->getSize());
            Log::info('File valid: ' . ($request->file('cover')->isValid() ? 'Yes' : 'No'));
        }

        // Validasi input
        $validated = $request->validate([
            'kode_buku' => 'required|string|max:20|unique:buku,kode_buku',
            'judul_buku' => 'required|string|max:200',
            'penulis' => 'required|string|max:100',
            'penerbit' => 'nullable|string|max:100',
            'tahun_terbit' => 'nullable|integer|min:1900|max:' . date('Y'),
            'kategori' => 'nullable|string|max:100',
            'rak' => 'nullable|string|max:50',
            'jumlah_total' => 'required|integer|min:1',
            'jumlah_tersedia' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            $coverName = 'default_cover.png'; // default

            // Upload cover jika ada
            if ($request->hasFile('cover')) {
                $cover = $request->file('cover');
                $coverName = time() . '_' . $cover->getClientOriginalName();

                // Simpan ke storage/app/public/covers menggunakan public disk
                $path = $cover->storeAs('covers', $coverName, 'public');

                Log::info('Cover uploaded to: ' . $path);
            }

            // Simpan ke database
            DB::table('buku')->insert([
                'kode_buku' => $validated['kode_buku'],
                'judul_buku' => $validated['judul_buku'],
                'penulis' => $validated['penulis'],
                'penerbit' => $validated['penerbit'],
                'tahun_terbit' => $validated['tahun_terbit'],
                'kategori' => $validated['kategori'],
                'rak' => $validated['rak'],
                'jumlah_total' => $validated['jumlah_total'],
                'jumlah_tersedia' => $validated['jumlah_tersedia'],
                'deskripsi' => $validated['deskripsi'],
                'cover' => $coverName,
                'tanggal_input' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Buku berhasil ditambahkan!'
            ]);

        } catch (\Exception $e) {
            Log::error('Book store error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan buku: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified book.
     */
    public function show($id)
    {
        try {
            $book = DB::table('buku')
                ->where('id_buku', $id)
                ->first();

            if (!$book) {
                return response()->json([
                    'success' => false,
                    'message' => 'Buku tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'book' => $book
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data buku: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified book in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'kode_buku' => 'required|string|max:20|unique:buku,kode_buku,' . $id . ',id_buku',
            'judul_buku' => 'required|string|max:200',
            'penulis' => 'required|string|max:100',
            'penerbit' => 'nullable|string|max:100',
            'tahun_terbit' => 'nullable|integer|min:1900|max:' . date('Y'),
            'kategori' => 'nullable|string|max:100',
            'rak' => 'nullable|string|max:50',
            'jumlah_total' => 'required|integer|min:1',
            'jumlah_tersedia' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            // Ambil data buku lama
            $currentBook = DB::table('buku')->where('id_buku', $id)->first();

            if (!$currentBook) {
                return response()->json([
                    'success' => false,
                    'message' => 'Buku tidak ditemukan'
                ], 404);
            }

            $coverName = $currentBook->cover;

            // Jika ada file cover baru
            if ($request->hasFile('cover')) {
                $cover = $request->file('cover');
                $coverName = time() . '_' . $cover->getClientOriginalName();

                // Hapus cover lama jika bukan default
                if ($currentBook->cover !== 'default_cover.png') {
                    Storage::disk('public')->delete('covers/' . $currentBook->cover);
                }

                // Simpan cover baru menggunakan public disk
                $path = $cover->storeAs('covers', $coverName, 'public');
                Log::info('Cover updated, saved to: ' . $path);
            }

            // Update data di database
            DB::table('buku')
                ->where('id_buku', $id)
                ->update([
                    'kode_buku' => $validated['kode_buku'],
                    'judul_buku' => $validated['judul_buku'],
                    'penulis' => $validated['penulis'],
                    'penerbit' => $validated['penerbit'],
                    'tahun_terbit' => $validated['tahun_terbit'],
                    'kategori' => $validated['kategori'],
                    'rak' => $validated['rak'],
                    'jumlah_total' => $validated['jumlah_total'],
                    'jumlah_tersedia' => $validated['jumlah_tersedia'],
                    'deskripsi' => $validated['deskripsi'],
                    'cover' => $coverName,
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Buku berhasil diperbarui!'
            ]);

        } catch (\Exception $e) {
            Log::error('Book update error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui buku: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified book from storage.
     */
    public function destroy($id)
    {
        try {
            // Get book data before deletion
            $book = DB::table('buku')->where('id_buku', $id)->first();

            if (!$book) {
                return response()->json([
                    'success' => false,
                    'message' => 'Buku tidak ditemukan'
                ], 404);
            }

            // Check if book is currently borrowed
            $isBorrowed = DB::table('peminjaman')
                ->where('id_buku', $id)
                ->where('status', 'dipinjam')
                ->exists();

            if ($isBorrowed) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak dapat menghapus buku yang sedang dipinjam'
                ], 400);
            }

            // Delete cover file if not default
            if ($book->cover !== 'default_cover.png') {
                Storage::disk('public')->delete('covers/' . $book->cover);
            }

            // Delete book from database
            DB::table('buku')->where('id_buku', $id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Buku berhasil dihapus!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus buku: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Search books based on query
     */
    public function search(Request $request)
    {
        $query = $request->get('q', '');

        try {
            $books = DB::table('buku')
                ->where(function($q) use ($query) {
                    $q->where('judul_buku', 'LIKE', '%' . $query . '%')
                      ->orWhere('penulis', 'LIKE', '%' . $query . '%')
                      ->orWhere('kode_buku', 'LIKE', '%' . $query . '%')
                      ->orWhere('kategori', 'LIKE', '%' . $query . '%');
                })
                ->orderBy('tanggal_input', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'books' => $books
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal melakukan pencarian: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate automatic book code
     */
    public function generateBookCode()
    {
        try {
            // Get latest book code
            $latestBook = DB::table('buku')
                ->orderBy('id_buku', 'desc')
                ->first();

            if (!$latestBook) {
                $newCode = 'BK001';
            } else {
                // Extract number from last code and increment
                $lastCode = $latestBook->kode_buku;
                $number = (int) substr($lastCode, 2) + 1;
                $newCode = 'BK' . str_pad($number, 3, '0', STR_PAD_LEFT);
            }

            return response()->json([
                'success' => true,
                'code' => $newCode
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal generate kode buku: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get books for catalog with filtering and pagination
     */
    public function catalog(Request $request)
    {
        try {
            $search = $request->get('search', '');
            $category = $request->get('category', '');
            $year = $request->get('year', '');
            $status = $request->get('status', '');
            $sort = $request->get('sort', 'newest');
            $page = (int) $request->get('page', 1);
            $perPage = (int) $request->get('per_page', 6);

            $query = DB::table('buku')
                ->select([
                    'id_buku',
                    'kode_buku',
                    'judul_buku',
                    'penulis',
                    'penerbit',
                    'tahun_terbit',
                    'kategori',
                    'rak',
                    'jumlah_total',
                    'jumlah_tersedia',
                    'cover',
                    'deskripsi',
                    'tanggal_input'
                ]);

            // Apply search filter
            if (!empty($search)) {
                $query->where(function($q) use ($search) {
                    $q->where('judul_buku', 'LIKE', '%' . $search . '%')
                      ->orWhere('penulis', 'LIKE', '%' . $search . '%')
                      ->orWhere('kategori', 'LIKE', '%' . $search . '%');
                });
            }

            // Apply category filter
            if (!empty($category)) {
                $query->where('kategori', 'LIKE', '%' . $category . '%');
            }

            // Apply year filter
            if (!empty($year)) {
                if ($year === 'older') {
                    $query->where('tahun_terbit', '<', 2019);
                } else {
                    $query->where('tahun_terbit', $year);
                }
            }

            // Apply status filter
            if (!empty($status)) {
                if ($status === 'available') {
                    $query->where('jumlah_tersedia', '>', 0);
                } elseif ($status === 'borrowed') {
                    $query->where('jumlah_tersedia', '=', 0);
                }
            }

            // Apply sorting
            switch ($sort) {
                case 'newest':
                    $query->orderBy('tahun_terbit', 'desc');
                    break;
                case 'oldest':
                    $query->orderBy('tahun_terbit', 'asc');
                    break;
                case 'title':
                    $query->orderBy('judul_buku', 'asc');
                    break;
                case 'title_desc':
                    $query->orderBy('judul_buku', 'desc');
                    break;
                case 'author':
                    $query->orderBy('penulis', 'asc');
                    break;
                default:
                    $query->orderBy('tanggal_input', 'desc');
            }

            // Get total count for pagination
            $total = $query->count();

            // Apply pagination
            $offset = ($page - 1) * $perPage;
            $books = $query->offset($offset)->limit($perPage)->get();

            // Calculate pagination info
            $totalPages = ceil($total / $perPage);

            return response()->json([
                'success' => true,
                'data' => [
                    'books' => $books,
                    'pagination' => [
                        'current_page' => $page,
                        'per_page' => $perPage,
                        'total' => $total,
                        'total_pages' => $totalPages,
                        'has_next' => $page < $totalPages,
                        'has_prev' => $page > 1
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data katalog: ' . $e->getMessage(),
                'data' => [
                    'books' => [],
                    'pagination' => [
                        'current_page' => 1,
                        'per_page' => 6,
                        'total' => 0,
                        'total_pages' => 0,
                        'has_next' => false,
                        'has_prev' => false
                    ]
                ]
            ], 500);
        }
    }
}
