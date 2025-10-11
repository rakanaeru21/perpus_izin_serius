<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MembersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $members = [
            [
                'nama_lengkap' => 'Ahmad Rizki Pratama',
                'username' => 'ahmad.rizki',
                'password' => Hash::make('password123'),
                'email' => 'ahmad.rizki@email.com',
                'no_hp' => '081234567890',
                'alamat' => 'Jl. Merdeka No. 123, Jakarta',
                'role' => 'anggota',
                'status' => 'aktif',
                'tanggal_daftar' => now()->subDays(30),
            ],
            [
                'nama_lengkap' => 'Siti Nurhaliza',
                'username' => 'siti.nurhaliza',
                'password' => Hash::make('password123'),
                'email' => 'siti.nurhaliza@email.com',
                'no_hp' => '082345678901',
                'alamat' => 'Jl. Sudirman No. 456, Bandung',
                'role' => 'anggota',
                'status' => 'aktif',
                'tanggal_daftar' => now()->subDays(25),
            ],
            [
                'nama_lengkap' => 'Budi Santoso',
                'username' => 'budi.santoso',
                'password' => Hash::make('password123'),
                'email' => 'budi.santoso@email.com',
                'no_hp' => '083456789012',
                'alamat' => 'Jl. Thamrin No. 789, Surabaya',
                'role' => 'anggota',
                'status' => 'nonaktif',
                'tanggal_daftar' => now()->subDays(20),
            ],
            [
                'nama_lengkap' => 'Maya Sari',
                'username' => 'maya.sari',
                'password' => Hash::make('password123'),
                'email' => 'maya.sari@email.com',
                'no_hp' => '084567890123',
                'alamat' => 'Jl. Gatot Subroto No. 321, Yogyakarta',
                'role' => 'anggota',
                'status' => 'aktif',
                'tanggal_daftar' => now()->subDays(15),
            ],
            [
                'nama_lengkap' => 'Doni Setiawan',
                'username' => 'doni.setiawan',
                'password' => Hash::make('password123'),
                'email' => 'doni.setiawan@email.com',
                'no_hp' => '085678901234',
                'alamat' => 'Jl. Ahmad Yani No. 654, Medan',
                'role' => 'anggota',
                'status' => 'aktif',
                'tanggal_daftar' => now()->subDays(10),
            ],
            [
                'nama_lengkap' => 'Rina Anggraini',
                'username' => 'rina.anggraini',
                'password' => Hash::make('password123'),
                'email' => 'rina.anggraini@email.com',
                'no_hp' => '086789012345',
                'alamat' => 'Jl. Diponegoro No. 987, Semarang',
                'role' => 'anggota',
                'status' => 'aktif',
                'tanggal_daftar' => now()->subDays(5),
            ],
        ];

        foreach ($members as $member) {
            DB::table('user')->insert($member);
        }
    }
}
