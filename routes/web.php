<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BidController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

// Halaman Publik (M3: Daftar & Detail Proyek)
Route::get('/', [ProjectController::class, 'index'])->name('home');
Route::get('/projects/{id}', [ProjectController::class, 'show'])->whereNumber('id')->name('projects.show');

// Autentikasi (M2: Auth)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Khusus Klien (M3 & M4: Pasang Proyek & Pilih Pemenang)
Route::middleware(['role:klien'])->group(function () {
    Route::get('/post', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('/post', [ProjectController::class, 'store'])->name('projects.store');
    Route::post('/pick', [BidController::class, 'pickWinner'])->name('bids.pick');
});

// Khusus Developer (M4: Ajukan Penawaran / Bid)
Route::middleware(['role:developer'])->group(function () {
    Route::post('/bid', [BidController::class, 'store'])->name('bids.store');
});

// Dasbor Klien & Developer (M5: Dasbor)
Route::middleware(['role:klien,developer'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// Panel Admin (M6: Admin)
Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::patch('/users/{user}/role', [AdminController::class, 'updateRole'])->name('users.role');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
    Route::delete('/projects/{project}', [AdminController::class, 'destroyProject'])->name('projects.destroy');
});
