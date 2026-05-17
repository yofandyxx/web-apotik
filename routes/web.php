<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    // Dashboard - semua role bisa akses
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Transaksi Routes - semua role bisa akses
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/{transaksi}', [TransaksiController::class, 'show'])->name('transaksi.show');
    Route::get('/transaksi/{transaksi}/print', [TransaksiController::class, 'print'])->name('transaksi.print');
    
    // Kasir Routes - semua role bisa akses
    Route::get('/kasir/transaksi', [TransaksiController::class, 'kasir'])->name('kasir.transaksi');
    Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
    
    // Admin Only Routes - gunakan check di controller
    Route::resource('kategori', KategoriController::class);
    Route::resource('obat', ObatController::class);
});