<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    // Check users with role anggota
    echo "Users with role 'anggota':\n";
    $users = DB::table('user')->where('role', 'anggota')->where('status', 'aktif')->get();
    foreach($users as $user) {
        echo "ID: {$user->id_user}, Username: {$user->username}, Name: {$user->nama_lengkap}\n";
    }

    // Check available books
    echo "\nAvailable books:\n";
    $books = DB::table('buku')->where('jumlah_tersedia', '>', 0)->get();
    foreach($books as $book) {
        echo "ID: {$book->id_buku}, Code: {$book->kode_buku}, Title: {$book->judul_buku}, Available: {$book->jumlah_tersedia}\n";
    }

    // Try to simulate a borrowing request
    if (count($users) > 0 && count($books) > 0) {
        $testUser = $users[0];
        $testBook = $books[0];

        echo "\nTesting borrowing creation:\n";
        echo "User: {$testUser->username} (ID: {$testUser->id_user})\n";
        echo "Book: {$testBook->judul_buku} (ID: {$testBook->id_buku})\n";

        $now = date('Y-m-d');
        $returnDate = date('Y-m-d', strtotime('+7 days'));

        $insertData = [
            'id_user' => $testUser->id_user,
            'id_buku' => $testBook->id_buku,
            'tanggal_pinjam' => $now,
            'batas_kembali' => $returnDate,
            'status' => 'dipinjam',
            'denda' => 0.00,
            'keterangan' => 'Test peminjaman',
            'created_at' => now(),
            'updated_at' => now()
        ];

        echo "Insert data: " . json_encode($insertData) . "\n";

        $result = DB::table('peminjaman')->insert($insertData);

        if ($result) {
            echo "SUCCESS: Test borrowing created!\n";

            // Check if the record was actually inserted
            $inserted = DB::table('peminjaman')->where('keterangan', 'Test peminjaman')->first();
            if ($inserted) {
                echo "Confirmed: Record found in database with ID: {$inserted->id_peminjaman}\n";

                // Clean up - delete the test record
                DB::table('peminjaman')->where('id_peminjaman', $inserted->id_peminjaman)->delete();
                echo "Test record cleaned up.\n";
            }
        } else {
            echo "FAILED: Could not create test borrowing\n";
        }
    } else {
        echo "\nNo valid users or books found for testing.\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
