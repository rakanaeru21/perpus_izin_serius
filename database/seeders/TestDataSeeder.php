<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Book;
use App\Models\Pinjaman;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class TestDataSeeder extends Seeder
{
    public function run()
    {
        // Create test users if they don't exist
        $testUsers = [
            [
                'username' => 'anggota1',
                'email' => 'anggota1@test.com',
                'nama_lengkap' => 'Test Anggota 1',
                'role' => 'anggota',
                'no_hp' => '08123456789',
                'password' => Hash::make('password')
            ],
            [
                'username' => 'anggota2',
                'email' => 'anggota2@test.com',
                'nama_lengkap' => 'Test Anggota 2',
                'role' => 'anggota',
                'no_hp' => '08123456790',
                'password' => Hash::make('password')
            ]
        ];

        foreach ($testUsers as $userData) {
            $user = User::where('username', $userData['username'])->first();
            if (!$user) {
                User::create($userData);
                $this->command->info("Created user: {$userData['username']}");
            }
        }

        // Create test books if they don't exist
        $testBooks = [
            [
                'kode_buku' => 'TST001',
                'judul_buku' => 'Test Book 1',
                'penulis' => 'Test Author 1',
                'penerbit' => 'Test Publisher',
                'tahun_terbit' => 2023,
                'kategori' => 'Test',
                'rak' => 'A1',
                'jumlah_total' => 5,
                'jumlah_tersedia' => 3
            ],
            [
                'kode_buku' => 'TST002',
                'judul_buku' => 'Test Book 2',
                'penulis' => 'Test Author 2',
                'penerbit' => 'Test Publisher',
                'tahun_terbit' => 2023,
                'kategori' => 'Test',
                'rak' => 'A2',
                'jumlah_total' => 3,
                'jumlah_tersedia' => 1
            ]
        ];

        foreach ($testBooks as $bookData) {
            $book = Book::where('kode_buku', $bookData['kode_buku'])->first();
            if (!$book) {
                Book::create($bookData);
                $this->command->info("Created book: {$bookData['judul_buku']}");
            }
        }

        // Create test borrowings
        $users = User::where('role', 'anggota')->get();
        $books = Book::get();

        if ($users->count() >= 2 && $books->count() >= 2) {
            $testBorrowings = [
                [
                    'id_user' => $users[0]->id_user,
                    'id_buku' => $books[0]->id_buku,
                    'tanggal_pinjam' => Carbon::now()->subDays(5),
                    'batas_kembali' => Carbon::now()->addDays(2),
                    'status' => 'dipinjam'
                ],
                [
                    'id_user' => $users[1]->id_user,
                    'id_buku' => $books[1]->id_buku,
                    'tanggal_pinjam' => Carbon::now()->subDays(10),
                    'batas_kembali' => Carbon::now()->subDays(3), // Overdue
                    'status' => 'terlambat'
                ]
            ];

            foreach ($testBorrowings as $borrowing) {
                $exists = Pinjaman::where('id_user', $borrowing['id_user'])
                                ->where('id_buku', $borrowing['id_buku'])
                                ->where('status', '!=', 'dikembalikan')
                                ->exists();

                if (!$exists) {
                    Pinjaman::create($borrowing);
                    $this->command->info("Created test borrowing for user {$borrowing['id_user']}");
                }
            }
        }
    }
}
