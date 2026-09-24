<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AspirasiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\UmpanBalikController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Landing Page
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Breeze Auth Routes
require __DIR__ . '/auth.php';

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

// Routes yang memerlukan autentikasi
Route::middleware('auth')->group(function () {
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Aspirasi Routes
    Route::resource('aspirasi', AspirasiController::class);
    Route::post('/aspirasi/{aspirasi}/upvote', [AspirasiController::class, 'upvote'])->name('aspirasi.upvote');
    Route::post('/aspirasi/{aspirasi}/comment', [AspirasiController::class, 'comment'])->name('aspirasi.comment');
    Route::post('/aspirasi/{aspirasi}/status', [AspirasiController::class, 'updateStatus'])->name('aspirasi.status');

    // Umpan Balik Manual (Hanya Admin)
    Route::middleware(['admin'])->group(function () {
        Route::post('/aspirasi/{aspirasi}/umpan-balik', [UmpanBalikController::class, 'store'])
            ->name('umpan-balik.store');
        Route::delete('/umpan-balik/{umpanBalik}', [UmpanBalikController::class, 'destroy'])
            ->name('umpan-balik.destroy');
    });

    // Admin Routes
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/all-aspirasi', [AdminController::class, 'allAspirasi'])->name('all-aspirasi');
        Route::post('/users/{user}/toggle-role', [AdminController::class, 'toggleUserRole'])->name('toggle-role');
        Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('delete-user');

        Route::resource('kategori', KategoriController::class)->except(['show']);
    });
});