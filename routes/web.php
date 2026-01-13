<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MasyarakatController;
use App\Http\Controllers\LaporanController;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;


// Rute untuk menampilkan halaman utama (welcome page)
Route::get('/', function () {
    return view('welcome');
});

Route::get('/registrasi', [MasyarakatController::class, 'index'])->name('masyarakat.index');
Route::post('/registrasi', [MasyarakatController::class, 'store'])->name('masyarakat.store');

// Route Login
Route::get('/login', [MasyarakatController::class, 'showLogin'])->name('login');
Route::post('/login', [MasyarakatController::class, 'login'])->name('login.process');
Route::get('/logout', [MasyarakatController::class, 'logout'])->name('logout');

// Route Halamana Lapor sampah (Hanya bisa diakses setelah jika sudah login session)
Route::middleware(['checkMasyarakatSession'])->group(function () {
    // halaman form laporan
    Route::get('/lapor-sampah', [LaporanController::class, 'index'])->name('lapor.index');

    // proses penyimpanan laporan
    Route::post('/lapor-sampah', [LaporanController::class, 'store'])->name('lapor.store');

    // Route::get('/lapor-sampah', function () {
    //     return view('lapor_sampah'); // Ini file yang akan kita buat selanjutnya
    // })->name('lapor.index');
});
