<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\InstrukturController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\LokasiController;

Route::get('/', function () {
    return view('welcome');
});

// Ubah ['auth', 'verified'] menjadi ['auth:admin']
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth:admin'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('member', MemberController::class);
Route::resource('instruktur', InstrukturController::class);
Route::resource('paket', PaketController::class);
Route::resource('pengumuman', PengumumanController::class);
Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
Route::get('/transaksi/{id}', [TransaksiController::class, 'show'])->name('transaksi.show');
Route::resource('lokasi', LokasiController::class);
require __DIR__.'/auth.php';
