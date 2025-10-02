<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Create a fake request to bootstrap Laravel
$request = Illuminate\Http\Request::create('/', 'GET');
$response = $kernel->handle($request);

// Now test the authentication
$user = \App\Models\User::first();

echo "User Details:\n";
echo "ID: " . $user->id_user . "\n";
echo "Username: " . $user->username . "\n";
echo "Email: " . $user->email . "\n";
echo "Role: " . $user->role . "\n";
echo "Password hash: " . $user->password . "\n";

// Test finding user by username and email
echo "\nTesting user lookup:\n";
$foundByUsername = \App\Models\User::where('username', 'rakanaeru')->first();
echo "Found by username: " . ($foundByUsername ? 'YES' : 'NO') . "\n";

$foundByEmail = \App\Models\User::where('email', 'rakanaeru@gmail.com')->first();
echo "Found by email: " . ($foundByEmail ? 'YES' : 'NO') . "\n";

// Test Laravel's Auth::attempt
echo "\nTesting Auth::attempt:\n";
$credentials = ['username' => 'rakanaeru', 'password' => 'password123'];
$result = Auth::attempt($credentials);
echo "Auth::attempt with username: " . ($result ? 'SUCCESS' : 'FAILED') . "\n";

$credentials = ['email' => 'rakanaeru@gmail.com', 'password' => 'password123'];
$result = Auth::attempt($credentials);
echo "Auth::attempt with email: " . ($result ? 'SUCCESS' : 'FAILED') . "\n";

echo "\nAuth identifier name: " . $user->getAuthIdentifierName() . "\n";
echo "Auth identifier: " . $user->getAuthIdentifier() . "\n";