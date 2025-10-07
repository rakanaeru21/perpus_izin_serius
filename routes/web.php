<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

// Dashboard Routes by Role
Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin')->middleware(['auth', 'role:admin']);
Route::get('/dashboard/petugas', [DashboardController::class, 'petugas'])->name('dashboard.petugas')->middleware(['auth', 'role:petugas']);
Route::get('/dashboard/anggota', [DashboardController::class, 'anggota'])->name('dashboard.anggota')->middleware(['auth', 'role:anggota']);

// Admin specific routes
Route::prefix('dashboard/admin')->middleware(['auth', 'role:admin'])->group(function () {
    // Book Management Routes
    Route::get('/books', [BookController::class, 'index'])->name('admin.books');
    Route::get('/books/search', [BookController::class, 'search'])->name('admin.books.search');
    Route::get('/books/generate-code', [BookController::class, 'generateBookCode'])->name('admin.books.generate-code');
    Route::post('/books', [BookController::class, 'store'])->name('admin.books.store');
    Route::get('/books/{id}', [BookController::class, 'show'])->name('admin.books.show');
    Route::put('/books/{id}', [BookController::class, 'update'])->name('admin.books.update');
    Route::delete('/books/{id}', [BookController::class, 'destroy'])->name('admin.books.destroy');

    // Other Admin Routes
    Route::get('/members', function () { return view('dashboard.admin.members'); })->name('admin.members');
    Route::get('/reports', function () { return view('dashboard.admin.reports'); })->name('admin.reports');
});

// Anggota specific routes
Route::prefix('dashboard/anggota')->middleware(['auth', 'role:anggota'])->group(function () {
    Route::get('/catalog', function () { return view('dashboard.anggota.catalog'); })->name('anggota.catalog');
    Route::get('/catalog/api', [BookController::class, 'catalog'])->name('anggota.catalog.api');
    Route::get('/loans', function () { return view('dashboard.anggota.loans'); })->name('anggota.loans');
    Route::get('/favorites', function () { return view('dashboard.anggota.favorites'); })->name('anggota.favorites');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('anggota.profile');
});

// Petugas specific routes
Route::prefix('dashboard/petugas')->middleware(['auth', 'role:petugas'])->group(function () {
    Route::get('/borrow', [BorrowController::class, 'index'])->name('petugas.borrow');
    Route::post('/borrow/search-user', [BorrowController::class, 'searchUser'])->name('petugas.borrow.search-user');
    Route::post('/borrow/search-book', [BorrowController::class, 'searchBook'])->name('petugas.borrow.search-book');
    Route::post('/borrow', [BorrowController::class, 'store'])->name('petugas.borrow.store');
    Route::get('/borrow/today', [BorrowController::class, 'getTodayBorrowings'])->name('petugas.borrow.today');
    Route::get('/return', function () { return view('dashboard.petugas.return'); })->name('petugas.return');
});

// Authentication Routes
Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

// Login routes
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

// AJAX validation routes
Route::post('/check-username', [RegisterController::class, 'checkUsername'])->name('check.username');
Route::post('/check-email', [RegisterController::class, 'checkEmail'])->name('check.email');

// Test route for AJAX
Route::get('/test-ajax', function () {
    return view('test_ajax');
})->name('test.ajax');

// Include test peminjaman routes
require __DIR__ . '/test_peminjaman.php';

// Test route
Route::get('/test-register', function () {
    return view('test_register');
});
