<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
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
    Route::get('/books', function () { return view('dashboard.admin.books'); })->name('admin.books');
    Route::get('/members', function () { return view('dashboard.admin.members'); })->name('admin.members');
    Route::get('/reports', function () { return view('dashboard.admin.reports'); })->name('admin.reports');
});

// Anggota specific routes
Route::prefix('dashboard/anggota')->middleware(['auth', 'role:anggota'])->group(function () {
    Route::get('/search', function () { return view('dashboard.anggota.search'); })->name('anggota.search');
    Route::get('/loans', function () { return view('dashboard.anggota.loans'); })->name('anggota.loans');
    Route::get('/favorites', function () { return view('dashboard.anggota.favorites'); })->name('anggota.favorites');
});

// Petugas specific routes
Route::prefix('dashboard/petugas')->middleware(['auth', 'role:petugas'])->group(function () {
    Route::get('/borrow', function () { return view('dashboard.petugas.borrow'); })->name('petugas.borrow');
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
