<?php

use App\Http\Controllers\Api\MemberApiController;
use App\Http\Controllers\Api\InstrukturApiController;

// MEMBER
Route::prefix('member')->group(function () {
    Route::post('/login', [MemberApiController::class, 'login']);
    Route::get('/profile/{id}', [MemberApiController::class, 'getProfile']);
    Route::get('/pakets', [MemberApiController::class, 'getPakets']);
    Route::get('/pengumumans', [MemberApiController::class, 'getPengumumans']);
    Route::get('/lokasis', [MemberApiController::class, 'getLokasis']);
    Route::get('/jadwal', [MemberApiController::class, 'getJadwal']);
    Route::post('/booking', [MemberApiController::class, 'bookingJadwal']);
    Route::post('/beli-paket', [MemberApiController::class, 'beliPaket']);
    Route::get('/riwayat-presensi/{member_id}', [MemberApiController::class, 'getRiwayatPresensi']);
});

// INSTRUKTUR
Route::prefix('instruktur')->group(function () {
    Route::post('/login', [InstrukturApiController::class, 'login']);
    Route::get('/jadwal-saya/{instruktur_id}', [InstrukturApiController::class, 'getJadwalSaya']);
    Route::get('/daftar-booking/{instruktur_id}', [InstrukturApiController::class, 'getDaftarBooking']);
    Route::post('/scan-absensi', [InstrukturApiController::class, 'scanAbsensi']);
});