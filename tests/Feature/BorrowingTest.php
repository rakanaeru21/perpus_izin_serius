<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BorrowingTest extends TestCase
{
    public function test_borrowing_form_submission()
    {
        // Create test user with petugas role
        $petugas = User::create([
            'username' => 'test_petugas',
            'nama_lengkap' => 'Test Petugas',
            'email' => 'test.petugas@example.com',
            'password' => bcrypt('password'),
            'role' => 'petugas',
            'status' => 'aktif'
        ]);

        // Create test anggota
        $anggota = User::create([
            'username' => 'test_anggota',
            'nama_lengkap' => 'Test Anggota',
            'email' => 'test.anggota@example.com',
            'password' => bcrypt('password'),
            'role' => 'anggota',
            'status' => 'aktif'
        ]);

        // Create test book
        $book = Book::create([
            'kode_buku' => 'TEST001',
            'judul_buku' => 'Test Book',
            'penulis' => 'Test Author',
            'penerbit' => 'Test Publisher',
            'tahun_terbit' => 2023,
            'jumlah_buku' => 5,
            'jumlah_tersedia' => 5
        ]);

        // Authenticate as petugas
        $this->actingAs($petugas);

        // Test POST to borrowing endpoint
        $response = $this->post('/dashboard/petugas/borrow', [
            'id_user' => $anggota->id_user,
            'id_buku' => $book->id_buku,
            'batas_kembali' => now()->addDays(7)->format('Y-m-d'),
            'keterangan' => 'Test borrowing'
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        // Check database
        $this->assertDatabaseHas('peminjaman', [
            'id_user' => $anggota->id_user,
            'id_buku' => $book->id_buku,
            'status' => 'dipinjam'
        ]);
    }
}
