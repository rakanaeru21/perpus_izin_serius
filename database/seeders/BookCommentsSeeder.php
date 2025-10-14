<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BookComment;
use App\Models\Book;
use App\Models\User;

class BookCommentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some sample books and users
        $books = Book::limit(5)->get();
        $users = User::where('role', 'anggota')->limit(3)->get();

        if ($books->isEmpty() || $users->isEmpty()) {
            $this->command->info('Tidak ada buku atau user anggota yang tersedia untuk membuat komentar contoh.');
            return;
        }

        $sampleComments = [
            [
                'rating' => 5,
                'comment' => 'Buku yang sangat bagus! Sangat informatif dan mudah dipahami. Penulis berhasil menjelaskan konsep-konsep yang kompleks dengan cara yang sederhana dan menarik.'
            ],
            [
                'rating' => 4,
                'comment' => 'Konten buku cukup menarik dan bermanfaat, tapi ada beberapa bagian yang bisa diperbaiki. Secara keseluruhan sangat direkomendasikan untuk dibaca.'
            ],
            [
                'rating' => 5,
                'comment' => 'Sangat direkomendasikan! Buku ini memberikan insight yang sangat berharga dan praktis. Setiap halaman penuh dengan informasi yang berguna.'
            ],
            [
                'rating' => 3,
                'comment' => 'Buku yang cukup baik untuk pemula, namun bagi yang sudah berpengalaman mungkin kurang mendalam. Tapi tetap layak untuk dibaca sebagai referensi.'
            ],
            [
                'rating' => 4,
                'comment' => 'Isi buku sangat relevan dengan kondisi saat ini. Bahasa yang digunakan mudah dipahami dan contoh-contoh yang diberikan sangat membantu.'
            ],
            [
                'rating' => 5,
                'comment' => 'Masterpiece! Buku ini benar-benar mengubah perspektif saya. Sangat inspiratif dan memberikan banyak wawasan baru yang aplikatif.'
            ],
            [
                'rating' => 2,
                'comment' => 'Buku ini kurang sesuai dengan ekspektasi saya. Beberapa bagian terasa membosankan dan kurang detail dalam penjelasannya.'
            ],
            [
                'rating' => 4,
                'comment' => 'Buku yang solid dengan pembahasan yang cukup komprehensif. Meskipun ada beberapa bagian yang repetitif, secara keseluruhan sangat bermanfaat.'
            ]
        ];

        $commentIndex = 0;

        foreach ($books as $book) {
            // Add 1-3 comments per book
            $commentsCount = rand(1, 3);

            for ($i = 0; $i < $commentsCount && $i < count($users); $i++) {
                $user = $users[$i];
                $comment = $sampleComments[$commentIndex % count($sampleComments)];

                // Check if comment already exists for this user and book
                $existingComment = BookComment::where('id_buku', $book->id_buku)
                    ->where('id_user', $user->id_user)
                    ->first();

                if (!$existingComment) {
                    BookComment::create([
                        'id_buku' => $book->id_buku,
                        'id_user' => $user->id_user,
                        'rating' => $comment['rating'],
                        'comment' => $comment['comment']
                    ]);

                    $this->command->info("Komentar ditambahkan untuk buku '{$book->judul_buku}' oleh '{$user->nama_lengkap}'");
                }

                $commentIndex++;
            }
        }

        $this->command->info('Seeder komentar buku selesai dijalankan.');
    }
}
