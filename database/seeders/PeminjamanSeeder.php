<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pinjaman;
use App\Models\User;
use App\Models\Book;
use Carbon\Carbon;

class PeminjamanSeeder extends Seeder
{
    public function run()
    {
        // Get sample users and books
        $users = User::where('role', 'anggota')->take(3)->get();
        $books = Book::take(5)->get();

        if ($users->count() < 2 || $books->count() < 3) {
            $this->command->info('Need at least 2 users and 3 books. Please run UserSeeder and BookSeeder first');
            return;
        }

        // Create sample borrowings
        $borrowings = [
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

        // Add more borrowings if we have more users
        if ($users->count() >= 3 && $books->count() >= 4) {
            $borrowings[] = [
                'id_user' => $users[2]->id_user,
                'id_buku' => $books[2]->id_buku,
                'tanggal_pinjam' => Carbon::now()->subDays(1),
                'batas_kembali' => Carbon::now()->addDays(6),
                'status' => 'dipinjam'
            ];

            $borrowings[] = [
                'id_user' => $users[0]->id_user,
                'id_buku' => $books[3]->id_buku,
                'tanggal_pinjam' => Carbon::now()->subDays(8),
                'batas_kembali' => Carbon::now()->subDays(1), // Overdue
                'status' => 'terlambat'
            ];
        }

        foreach ($borrowings as $borrowing) {
            // Check if borrowing already exists
            $exists = Pinjaman::where('id_user', $borrowing['id_user'])
                            ->where('id_buku', $borrowing['id_buku'])
                            ->where('status', '!=', 'dikembalikan')
                            ->exists();

            if (!$exists) {
                // Update book availability
                $book = Book::find($borrowing['id_buku']);
                if ($book && $book->jumlah_tersedia > 0) {
                    $book->decrement('jumlah_tersedia');

                    Pinjaman::create($borrowing);
                    $this->command->info("Created borrowing for user {$borrowing['id_user']} - book {$borrowing['id_buku']}");
                }
            }
        }

        // Create some returned borrowings for history if we have enough books
        if ($books->count() >= 5) {
            $returnedBorrowings = [
                [
                    'id_user' => $users[1]->id_user,
                    'id_buku' => $books[4]->id_buku,
                    'tanggal_pinjam' => Carbon::now()->subDays(15),
                    'batas_kembali' => Carbon::now()->subDays(8),
                    'tanggal_kembali' => Carbon::now()->subDays(7),
                    'status' => 'dikembalikan',
                    'kondisi_buku' => 'baik',
                    'denda' => 0
                ]
            ];

            foreach ($returnedBorrowings as $borrowing) {
                $exists = Pinjaman::where('id_user', $borrowing['id_user'])
                                ->where('id_buku', $borrowing['id_buku'])
                                ->where('tanggal_kembali', $borrowing['tanggal_kembali'])
                                ->exists();

                if (!$exists) {
                    Pinjaman::create($borrowing);
                    $this->command->info("Created returned borrowing for user {$borrowing['id_user']}");
                }
            }
        }
    }
}
