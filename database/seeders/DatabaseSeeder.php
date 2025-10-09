<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'nama_lengkap' => 'Admin Utama',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'role' => 'admin',
        ]);

        User::factory()->create([
            'nama_lengkap' => 'Petugas Perpustakaan',
            'username' => 'petugas',
            'email' => 'petugas@example.com',
            'role' => 'petugas',
        ]);

        User::factory()->create([
            'nama_lengkap' => 'Anggota Biasa',
            'username' => 'anggota',
            'email' => 'anggota@example.com',
            'role' => 'anggota',
        ]);
    }
}
