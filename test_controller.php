<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Http\Request;
use App\Http\Controllers\BorrowController;

// Simulate a POST request to the borrowing store method
try {
    echo "Testing BorrowController store method directly:\n\n";

    $controller = new BorrowController();

    // Create a mock request with test data
    $request = new Request([
        'id_user' => '6', // rj user ID from previous test
        'id_buku' => '1', // Dilan 1990 book ID
        'batas_kembali' => date('Y-m-d', strtotime('+7 days')),
        'keterangan' => 'Test direct controller call'
    ]);

    echo "Request data:\n";
    echo "id_user: " . $request->id_user . "\n";
    echo "id_buku: " . $request->id_buku . "\n";
    echo "batas_kembali: " . $request->batas_kembali . "\n";
    echo "keterangan: " . $request->keterangan . "\n\n";

    // Call the store method directly
    $response = $controller->store($request);

    echo "Response:\n";
    echo $response->getContent() . "\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
