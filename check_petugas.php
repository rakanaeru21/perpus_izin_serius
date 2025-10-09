<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    // Check users with role petugas
    echo "Users with role 'petugas':\n";
    $petugas = DB::table('user')->where('role', 'petugas')->where('status', 'aktif')->get();
    foreach($petugas as $user) {
        echo "ID: {$user->id_user}, Username: {$user->username}, Name: {$user->nama_lengkap}, Email: {$user->email}\n";
    }

    if (count($petugas) == 0) {
        echo "\nNo active petugas found. Creating test petugas user...\n";

        $petugasData = [
            'username' => 'petugas_test',
            'nama_lengkap' => 'Petugas Test',
            'email' => 'petugas@test.com',
            'password' => password_hash('password', PASSWORD_DEFAULT),
            'role' => 'petugas',
            'status' => 'aktif',
            'created_at' => now(),
            'updated_at' => now()
        ];

        $result = DB::table('user')->insert($petugasData);

        if ($result) {
            echo "Test petugas user created successfully!\n";
            echo "Username: petugas_test\n";
            echo "Password: password\n";
        }
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
