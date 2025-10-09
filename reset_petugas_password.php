<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    // Reset password for petugas user
    $result = DB::table('user')
        ->where('username', 'petugas')
        ->update([
            'password' => password_hash('password123', PASSWORD_DEFAULT),
            'updated_at' => now()
        ]);

    if ($result) {
        echo "Password petugas berhasil direset!\n";
        echo "Username: petugas\n";
        echo "Password: password123\n";
    } else {
        echo "Gagal reset password atau user tidak ditemukan.\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
