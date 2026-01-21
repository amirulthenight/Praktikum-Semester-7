<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MasyarakatController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\AdminController;
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

// Route Halaman Lapor sampah (Hanya bisa diakses setelah jika sudah login session)
// middelware disini
Route::middleware(['checkMasyarakatSession'])->group(function () {
    // halaman form laporan
    Route::get('/lapor-sampah', [LaporanController::class, 'index'])->name('lapor.index');

    // proses penyimpanan laporan
    Route::post('/lapor-sampah', [LaporanController::class, 'store'])->name('lapor.store');

    // halaman riwayat laporan
    Route::get('/riwayat-laporan', [LaporanController::class, 'history'])->name('lapor.history');

    // Route Admin Dashboard
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/peta-laporan', [AdminController::class, 'peta'])->name('admin.peta');
    Route::get('/admin/perhitungan-vikor', [AdminController::class, 'vikor'])->name('admin.vikor');

    // Route untuk mengambil data JSON laporan berdasarkan ID
    Route::get('/admin/laporan/{id}', [AdminController::class, 'detailLaporan'])->name('admin.detailLaporan');

    // Route untuk update status laporan (Perbaikan Error 404)
    Route::post('/admin/laporan/update-status/{id}', [AdminController::class, 'updateStatus'])->name('admin.updateStatus');

    // Route WP
    Route::get('/admin/perhitungan-wp', [AdminController::class, 'wp'])->name('admin.wp');

    // Route Perbandingan
    Route::get('/admin/perbandingan-metode', [AdminController::class, 'perbandingan'])->name('admin.perbandingan');



    //
    Route::get('/lapor-sampah', function () {
        return view('lapor_sampah'); // Ini file yang akan kita buat selanjutnya
    })->name('lapor.index');
});
