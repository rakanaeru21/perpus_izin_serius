<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Book;
use App\Models\BookComment;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index()
    {
        // Menghitung statistik untuk dashboard
        $statistics = [
            'totalBuku' => $this->getTotalBuku(),
            'bukuDipinjam' => $this->getBukuDipinjam(),
            'totalAnggota' => $this->getTotalAnggota(),
            'keterlambatan' => $this->getKeterlambatan(),
        ];

        return view('dashboard', $statistics);
    }

    /**
     * Dashboard untuk Admin
     */
    public function admin()
    {
        $statistics = [
            'totalBuku' => $this->getTotalBuku(),
            'bukuDipinjam' => $this->getBukuDipinjam(),
            'totalAnggota' => $this->getTotalAnggota(),
            'keterlambatan' => $this->getKeterlambatan(),
            'totalPetugas' => $this->getTotalPetugas(),
            'totalAdmin' => $this->getTotalAdmin(),
            'bukuTersedia' => $this->getBukuTersedia(),
            'totalPeminjaman' => $this->getTotalPeminjaman(),
            'recentActivities' => $this->getRecentActivities()
        ];

        return view('dashboard.admin.index', $statistics);
    }

    /**
     * Dashboard untuk Petugas
     */
    public function petugas()
    {
        $statistics = [
            'totalBuku' => $this->getTotalBuku(),
            'bukuDipinjam' => $this->getBukuDipinjam(),
            'keterlambatan' => $this->getKeterlambatan(),
            'peminjamanHariIni' => $this->getPeminjamanHariIni(),
            'recentActivities' => $this->getRecentActivities(),
            'peminjamanTerbaru' => $this->getPeminjamanTerbaru()
        ];

        return view('dashboard.petugas.index', $statistics);
    }

    /**
     * Dashboard untuk Anggota
     */
    public function anggota()
    {
        $data = [
            'bukuDipinjam' => $this->getBukuDipinjamUser(),
            'riwayatPinjaman' => $this->getRiwayatPinjaman(),
            'keterlambatan' => $this->getKeterlambatanUser(),
            'rekomendasiBuku' => $this->getRekomendasiBuku(),
            'bukuTerpopuler' => $this->getBukuTerpopuler(),
            'bukuByKategori' => $this->getBukuByKategori(),
            'kategoriBuku' => $this->getKategoriBuku()
        ];

        return view('dashboard.anggota.index', $data);
    }

    /**
     * Profile page for Anggota
     */
    public function profile()
    {
        $data = [
            'totalPinjaman' => $this->getTotalPinjamanUser(),
            'sedangDipinjam' => $this->getBukuDipinjamUser(),
            'sudahDikembalikan' => $this->getBukuDikembalikanUser(),
            'terlambat' => $this->getKeterlambatanUser()
        ];

        return view('dashboard.anggota.profile', $data);
    }

    /**
     * Anggota data page for Petugas
     */
    public function petugasAnggota()
    {
        $anggotaList = User::where('role', 'anggota')
            ->orderBy('nama_lengkap', 'asc')
            ->get();

        $statistics = [
            'totalAnggota' => $anggotaList->count(),
            'anggotaAktif' => $anggotaList->where('status', 'aktif')->count(),
            'anggotaNonAktif' => $anggotaList->where('status', 'nonaktif')->count(),
        ];

        return view('dashboard.petugas.anggota', compact('anggotaList', 'statistics'));
    }

    /**
     * Get total number of books
     */
    private function getTotalBuku()
    {
        try {
            // Jika tabel buku sudah ada, gunakan query ini
            return DB::table('buku')->count();
        } catch (\Exception $e) {
            // Jika tabel belum ada, return data sample
            return 1247;
        }
    }

    /**
     * Get number of currently borrowed books
     */
    private function getBukuDipinjam()
    {
        try {
            // Menggunakan nama tabel yang benar berdasarkan migration
            return DB::table('peminjaman')
                ->where('status', 'dipinjam')
                ->count();
        } catch (\Exception $e) {
            // Jika tabel belum ada, return data sample
            return 324;
        }
    }

    /**
     * Get total number of members
     */
    private function getTotalAnggota()
    {
        try {
            // Menggunakan nama tabel yang benar berdasarkan migration
            return DB::table('user')
                ->where('role', 'anggota')
                ->where('status', 'aktif')
                ->count();
        } catch (\Exception $e) {
            // Jika tabel belum ada atau kolom role tidak ada, return data sample
            return 892;
        }
    }

    /**
     * Get number of overdue books
     */
    private function getKeterlambatan()
    {
        try {
            // Menggunakan nama tabel yang benar berdasarkan migration
            return DB::table('peminjaman')
                ->where('status', 'terlambat')
                ->orWhere(function($query) {
                    $query->where('status', 'dipinjam')
                          ->where('batas_kembali', '<', now()->toDateString());
                })
                ->count();
        } catch (\Exception $e) {
            // Jika tabel belum ada, return data sample
            return 23;
        }
    }

    /**
     * Get recent activities (sample data for now)
     */
    private function getRecentActivities()
    {
        // Data aktivitas yang sesuai dengan struktur database
        return [
            [
                'type' => 'return',
                'message' => 'Pengembalian Buku',
                'description' => 'Buku "Pemrograman PHP" dikembalikan oleh Ahmad Fauzi',
                'time' => '2 menit yang lalu'
            ],
            [
                'type' => 'borrow',
                'message' => 'Peminjaman Baru',
                'description' => 'Buku "Database MySQL" dipinjam oleh Siti Nurhaliza',
                'time' => '15 menit yang lalu'
            ],
            [
                'type' => 'member',
                'message' => 'Anggota Baru',
                'description' => 'Dian Sastro terdaftar sebagai anggota perpustakaan',
                'time' => '1 jam yang lalu'
            ],
            [
                'type' => 'overdue',
                'message' => 'Keterlambatan Terdeteksi',
                'description' => 'Buku "Algoritma dan Struktur Data" terlambat 3 hari - Budi Santoso',
                'time' => '2 jam yang lalu'
            ],
            [
                'type' => 'book',
                'message' => 'Buku Baru Ditambahkan',
                'description' => 'Buku "Laravel Framework" telah ditambahkan ke koleksi',
                'time' => '3 jam yang lalu'
            ]
        ];
    }

    /**
     * Get total number of petugas
     */
    private function getTotalPetugas()
    {
        try {
            return DB::table('user')
                ->where('role', 'petugas')
                ->where('status', 'aktif')
                ->count();
        } catch (\Exception $e) {
            return 5;
        }
    }

    /**
     * Get total number of admin
     */
    private function getTotalAdmin()
    {
        try {
            return DB::table('user')
                ->where('role', 'admin')
                ->where('status', 'aktif')
                ->count();
        } catch (\Exception $e) {
            return 2;
        }
    }

    /**
     * Get total available books
     */
    private function getBukuTersedia()
    {
        try {
            return DB::table('buku')
                ->sum('jumlah_tersedia');
        } catch (\Exception $e) {
            return 923;
        }
    }

    /**
     * Get total peminjaman records
     */
    private function getTotalPeminjaman()
    {
        try {
            return DB::table('peminjaman')->count();
        } catch (\Exception $e) {
            return 1567;
        }
    }

    /**
     * Get peminjaman hari ini
     */
    private function getPeminjamanHariIni()
    {
        try {
            return DB::table('peminjaman')
                ->whereDate('tanggal_pinjam', today())
                ->count();
        } catch (\Exception $e) {
            return 12;
        }
    }

    /**
     * Get buku dipinjam by current user
     */
    private function getBukuDipinjamUser()
    {
        try {
            return DB::table('peminjaman')
                ->where('id_user', Auth::id())
                ->where('status', 'dipinjam')
                ->count();
        } catch (\Exception $e) {
            return 3;
        }
    }

    /**
     * Get riwayat pinjaman user
     */
    private function getRiwayatPinjaman()
    {
        // Sample data untuk sekarang
        return [
            [
                'judul' => 'Harry Potter and the Sorcerer\'s Stone',
                'tanggal_pinjam' => '2025-09-15',
                'tanggal_kembali' => '2025-09-22',
                'status' => 'Dikembalikan'
            ],
            [
                'judul' => 'The Great Gatsby',
                'tanggal_pinjam' => '2025-09-20',
                'tanggal_kembali' => null,
                'status' => 'Dipinjam'
            ]
        ];
    }

    /**
     * Get keterlambatan for current user
     */
    private function getKeterlambatanUser()
    {
        try {
            return DB::table('peminjaman')
                ->where('id_user', Auth::id())
                ->where(function($query) {
                    $query->where('status', 'terlambat')
                          ->orWhere(function($subQuery) {
                              $subQuery->where('status', 'dipinjam')
                                      ->where('batas_kembali', '<', now()->toDateString());
                          });
                })
                ->count();
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * Get rekomendasi buku
     */
    private function getRekomendasiBuku()
    {
        // Sample data untuk sekarang
        return [
            [
                'judul' => 'To Kill a Mockingbird',
                'penulis' => 'Harper Lee',
                'kategori' => 'Klasik'
            ],
            [
                'judul' => 'The Catcher in the Rye',
                'penulis' => 'J.D. Salinger',
                'kategori' => 'Fiksi'
            ],
            [
                'judul' => 'Pride and Prejudice',
                'penulis' => 'Jane Austen',
                'kategori' => 'Romance'
            ]
        ];
    }

    /**
     * Get total pinjaman for current user
     */
    private function getTotalPinjamanUser()
    {
        try {
            return DB::table('peminjaman')
                ->where('id_user', Auth::id())
                ->count();
        } catch (\Exception $e) {
            return 5;
        }
    }

    /**
     * Get total dikembalikan for current user
     */
    private function getBukuDikembalikanUser()
    {
        try {
            return DB::table('peminjaman')
                ->where('id_user', Auth::id())
                ->where('status', 'dikembalikan')
                ->count();
        } catch (\Exception $e) {
            return 2;
        }
    }

    /**
     * Get peminjaman terbaru for petugas dashboard
     */
    private function getPeminjamanTerbaru()
    {
        try {
            return DB::table('peminjaman')
                ->join('user', 'peminjaman.id_user', '=', 'user.id_user')
                ->join('buku', 'peminjaman.id_buku', '=', 'buku.id_buku')
                ->select(
                    'peminjaman.id_peminjaman',
                    'user.nama_lengkap',
                    'buku.judul_buku',
                    'peminjaman.tanggal_pinjam',
                    'peminjaman.batas_kembali',
                    'peminjaman.tanggal_kembali',
                    'peminjaman.status'
                )
                ->orderBy('peminjaman.tanggal_pinjam', 'desc')
                ->limit(10)
                ->get()
                ->map(function($item) {
                    // Update status if overdue
                    if ($item->status === 'dipinjam' && $item->batas_kembali < now()->toDateString()) {
                        $item->status = 'terlambat';
                    }
                    return $item;
                });
        } catch (\Exception $e) {
            // Return sample data if database is not ready
            return collect([
                (object)[
                    'id_peminjaman' => 1,
                    'nama_lengkap' => 'Ahmad Fauzi',
                    'judul_buku' => 'Harry Potter and the Sorcerer\'s Stone',
                    'tanggal_pinjam' => '2025-10-01',
                    'batas_kembali' => '2025-10-08',
                    'tanggal_kembali' => null,
                    'status' => 'dipinjam'
                ],
                (object)[
                    'id_peminjaman' => 2,
                    'nama_lengkap' => 'Siti Nurhaliza',
                    'judul_buku' => 'The Great Gatsby',
                    'tanggal_pinjam' => '2025-10-02',
                    'batas_kembali' => '2025-10-09',
                    'tanggal_kembali' => null,
                    'status' => 'dipinjam'
                ],
                (object)[
                    'id_peminjaman' => 3,
                    'nama_lengkap' => 'Budi Santoso',
                    'judul_buku' => '1984',
                    'tanggal_pinjam' => '2025-09-28',
                    'batas_kembali' => '2025-10-05',
                    'tanggal_kembali' => null,
                    'status' => 'terlambat'
                ],
                (object)[
                    'id_peminjaman' => 4,
                    'nama_lengkap' => 'Dian Sastro',
                    'judul_buku' => 'To Kill a Mockingbird',
                    'tanggal_pinjam' => '2025-09-30',
                    'batas_kembali' => '2025-10-07',
                    'tanggal_kembali' => '2025-10-01',
                    'status' => 'dikembalikan'
                ]
            ]);
        }
    }

    /**
     * Get buku terpopuler berdasarkan rating tertinggi
     */
    private function getBukuTerpopuler($limit = 8)
    {
        try {
            return DB::table('buku')
                ->leftJoin('book_comments', 'buku.id_buku', '=', 'book_comments.id_buku')
                ->select(
                    'buku.id_buku',
                    'buku.judul_buku',
                    'buku.penulis',
                    'buku.kategori',
                    'buku.cover',
                    'buku.jumlah_tersedia',
                    'buku.tahun_terbit',
                    DB::raw('COALESCE(AVG(book_comments.rating), 0) as avg_rating'),
                    DB::raw('COUNT(book_comments.rating) as total_ratings')
                )
                ->groupBy(
                    'buku.id_buku',
                    'buku.judul_buku',
                    'buku.penulis',
                    'buku.kategori',
                    'buku.cover',
                    'buku.jumlah_tersedia',
                    'buku.tahun_terbit'
                )
                ->orderBy('avg_rating', 'desc')
                ->orderBy('total_ratings', 'desc')
                ->limit($limit)
                ->get()
                ->map(function($book) {
                    $book->avg_rating = round($book->avg_rating, 1);
                    $book->cover_url = $book->cover && $book->cover !== 'default_cover.png'
                        ? asset('storage/covers/' . $book->cover)
                        : asset('images/default_cover.png');
                    return $book;
                });
        } catch (\Exception $e) {
            // Return sample data if database is not ready
            return collect([
                (object)[
                    'id_buku' => 1,
                    'judul_buku' => 'Laravel: Up & Running',
                    'penulis' => 'Matt Stauffer',
                    'kategori' => 'Teknologi',
                    'cover' => 'default_cover.png',
                    'jumlah_tersedia' => 5,
                    'tahun_terbit' => 2021,
                    'avg_rating' => 4.8,
                    'total_ratings' => 15,
                    'cover_url' => asset('images/default_cover.png')
                ],
                (object)[
                    'id_buku' => 2,
                    'judul_buku' => 'Clean Code',
                    'penulis' => 'Robert C. Martin',
                    'kategori' => 'Teknologi',
                    'cover' => 'default_cover.png',
                    'jumlah_tersedia' => 3,
                    'tahun_terbit' => 2008,
                    'avg_rating' => 4.7,
                    'total_ratings' => 22,
                    'cover_url' => asset('images/default_cover.png')
                ],
                (object)[
                    'id_buku' => 3,
                    'judul_buku' => 'The Psychology of Computer Programming',
                    'penulis' => 'Gerald M. Weinberg',
                    'kategori' => 'Psikologi',
                    'cover' => 'default_cover.png',
                    'jumlah_tersedia' => 2,
                    'tahun_terbit' => 1998,
                    'avg_rating' => 4.6,
                    'total_ratings' => 8,
                    'cover_url' => asset('images/default_cover.png')
                ],
                (object)[
                    'id_buku' => 4,
                    'judul_buku' => 'Sapiens: A Brief History of Humankind',
                    'penulis' => 'Yuval Noah Harari',
                    'kategori' => 'Sejarah',
                    'cover' => 'default_cover.png',
                    'jumlah_tersedia' => 4,
                    'tahun_terbit' => 2011,
                    'avg_rating' => 4.5,
                    'total_ratings' => 30,
                    'cover_url' => asset('images/default_cover.png')
                ]
            ]);
        }
    }

    /**
     * Get buku berdasarkan kategori
     */
    private function getBukuByKategori()
    {
        try {
            $categories = $this->getKategoriBuku();
            $result = [];

            foreach ($categories as $category) {
                $books = DB::table('buku')
                    ->leftJoin('book_comments', 'buku.id_buku', '=', 'book_comments.id_buku')
                    ->select(
                        'buku.id_buku',
                        'buku.judul_buku',
                        'buku.penulis',
                        'buku.kategori',
                        'buku.cover',
                        'buku.jumlah_tersedia',
                        'buku.tahun_terbit',
                        DB::raw('COALESCE(AVG(book_comments.rating), 0) as avg_rating'),
                        DB::raw('COUNT(book_comments.rating) as total_ratings')
                    )
                    ->where('buku.kategori', $category->kategori)
                    ->groupBy(
                        'buku.id_buku',
                        'buku.judul_buku',
                        'buku.penulis',
                        'buku.kategori',
                        'buku.cover',
                        'buku.jumlah_tersedia',
                        'buku.tahun_terbit'
                    )
                    ->orderBy('avg_rating', 'desc')
                    ->limit(4)
                    ->get()
                    ->map(function($book) {
                        $book->avg_rating = round($book->avg_rating, 1);
                        $book->cover_url = $book->cover && $book->cover !== 'default_cover.png'
                            ? asset('storage/covers/' . $book->cover)
                            : asset('images/default_cover.png');
                        return $book;
                    });

                if ($books->count() > 0) {
                    $result[$category->kategori] = $books;
                }
            }

            return $result;
        } catch (\Exception $e) {
            // Return sample data if database is not ready
            return [
                'Teknologi' => collect([
                    (object)[
                        'id_buku' => 1,
                        'judul_buku' => 'Laravel Framework',
                        'penulis' => 'Taylor Otwell',
                        'kategori' => 'Teknologi',
                        'cover' => 'default_cover.png',
                        'jumlah_tersedia' => 3,
                        'tahun_terbit' => 2023,
                        'avg_rating' => 4.9,
                        'total_ratings' => 12,
                        'cover_url' => asset('images/default_cover.png')
                    ],
                    (object)[
                        'id_buku' => 2,
                        'judul_buku' => 'PHP: The Right Way',
                        'penulis' => 'Josh Lockhart',
                        'kategori' => 'Teknologi',
                        'cover' => 'default_cover.png',
                        'jumlah_tersedia' => 5,
                        'tahun_terbit' => 2022,
                        'avg_rating' => 4.7,
                        'total_ratings' => 18,
                        'cover_url' => asset('images/default_cover.png')
                    ]
                ]),
                'Fiksi' => collect([
                    (object)[
                        'id_buku' => 3,
                        'judul_buku' => 'The Great Gatsby',
                        'penulis' => 'F. Scott Fitzgerald',
                        'kategori' => 'Fiksi',
                        'cover' => 'default_cover.png',
                        'jumlah_tersedia' => 2,
                        'tahun_terbit' => 1925,
                        'avg_rating' => 4.3,
                        'total_ratings' => 25,
                        'cover_url' => asset('images/default_cover.png')
                    ],
                    (object)[
                        'id_buku' => 4,
                        'judul_buku' => '1984',
                        'penulis' => 'George Orwell',
                        'kategori' => 'Fiksi',
                        'cover' => 'default_cover.png',
                        'jumlah_tersedia' => 4,
                        'tahun_terbit' => 1949,
                        'avg_rating' => 4.6,
                        'total_ratings' => 32,
                        'cover_url' => asset('images/default_cover.png')
                    ]
                ])
            ];
        }
    }

    /**
     * Get semua kategori buku yang tersedia
     */
    private function getKategoriBuku()
    {
        try {
            return DB::table('buku')
                ->select('kategori', DB::raw('COUNT(*) as total_buku'))
                ->whereNotNull('kategori')
                ->where('kategori', '!=', '')
                ->groupBy('kategori')
                ->orderBy('total_buku', 'desc')
                ->get();
        } catch (\Exception $e) {
            // Return sample data if database is not ready
            return collect([
                (object)['kategori' => 'Teknologi', 'total_buku' => 25],
                (object)['kategori' => 'Fiksi', 'total_buku' => 18],
                (object)['kategori' => 'Sejarah', 'total_buku' => 15],
                (object)['kategori' => 'Sains', 'total_buku' => 12],
                (object)['kategori' => 'Psikologi', 'total_buku' => 8]
            ]);
        }
    }
}
