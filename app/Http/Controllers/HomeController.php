<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Display the homepage.
     */
    public function index()
    {
        // Menghitung statistik untuk homepage
        $statistics = [
            'totalBooks' => $this->getTotalBooks(),
            'activeMembers' => $this->getActiveMembers(),
            'ebooks' => $this->getEbooks(),
            'journals' => $this->getJournals(),
        ];

        return view('home', $statistics);
    }

    /**
     * Get total number of books
     */
    private function getTotalBooks()
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
     * Get number of active members
     */
    private function getActiveMembers()
    {
        try {
            // Menghitung total users yang aktif
            return DB::table('users')
                ->where('created_at', '>=', now()->subMonths(6))
                ->count();
        } catch (\Exception $e) {
            // Jika tabel belum ada, return data sample
            return 892;
        }
    }

    /**
     * Get number of e-books (sample data)
     */
    private function getEbooks()
    {
        // Data sample untuk e-books
        return 324;
    }

    /**
     * Get number of journals (sample data)
     */
    private function getJournals()
    {
        // Data sample untuk jurnal
        return 156;
    }

    /**
     * Get popular books (sample data for now)
     */
    private function getPopularBooks()
    {
        return [
            [
                'title' => 'Laskar Pelangi',
                'author' => 'Andrea Hirata',
                'rating' => 5,
                'borrows' => 47
            ],
            [
                'title' => 'Bumi Manusia',
                'author' => 'Pramoedya Ananta Toer',
                'rating' => 5,
                'borrows' => 42
            ],
            [
                'title' => 'Dilan 1990',
                'author' => 'Pidi Baiq',
                'rating' => 5,
                'borrows' => 38
            ],
            [
                'title' => 'Ayat-Ayat Cinta',
                'author' => 'Habiburrahman El Shirazy',
                'rating' => 5,
                'borrows' => 35
            ]
        ];
    }
}