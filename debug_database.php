<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    // Check if tables exist
    $tables = DB::select('SHOW TABLES');
    echo "Tables in database:\n";
    foreach($tables as $table) {
        $tableName = array_values((array)$table)[0];
        echo "- $tableName\n";
    }

    // Check peminjaman table structure
    echo "\nPeminjaman table structure:\n";
    $columns = DB::select('DESCRIBE peminjaman');
    foreach($columns as $column) {
        echo "{$column->Field} | {$column->Type} | {$column->Key}\n";
    }

    // Check if there are any records in peminjaman
    echo "\nCount of records in peminjaman: ";
    $count = DB::table('peminjaman')->count();
    echo $count . "\n";

    // Check user and buku tables
    echo "\nCount of records in user: ";
    $userCount = DB::table('user')->count();
    echo $userCount . "\n";

    echo "Count of records in buku: ";
    $bukuCount = DB::table('buku')->count();
    echo $bukuCount . "\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
