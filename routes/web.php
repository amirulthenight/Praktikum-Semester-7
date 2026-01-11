<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MasyarakatController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Rute untuk menampilkan halaman utama (welcome page)
Route::get('/', function () {
    return view('welcome');
});

Route::get('/registrasi', [MasyarakatController::class, 'index'])->name('masyarakat.index');
Route::post('/registrasi', [MasyarakatController::class, 'store'])->name('masyarakat.store');
