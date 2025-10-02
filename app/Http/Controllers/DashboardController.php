<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            'recentActivities' => $this->getRecentActivities()
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
            'rekomendasiBuku' => $this->getRekomendasiBuku()
        ];

        return view('dashboard.anggota.index', $data);
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
                ->where('id_user', auth()->id())
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
                ->where('id_user', auth()->id())
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
}