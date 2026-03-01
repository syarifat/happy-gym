<?php

use App\Http\Controllers\Api\MemberApiController;
use App\Http\Controllers\Api\InstrukturApiController;
use Illuminate\Support\Facades\Route;

// ENDPOINT MEMBER
Route::prefix('member')->group(function () {
    Route::post('/login', [MemberApiController::class, 'login']);
    Route::get('/profile/{id}', [MemberApiController::class, 'getProfile']);
    Route::get('/pakets', [MemberApiController::class, 'getPakets']);
    Route::get('/pengumumans', [MemberApiController::class, 'getPengumumans']);
    Route::get('/lokasis', [MemberApiController::class, 'getLokasis']);
    Route::post('/beli-paket', [MemberApiController::class, 'beliPaket']);
});

// ENDPOINT INSTRUKTUR
Route::prefix('instruktur')->group(function () {
    Route::post('/login', [InstrukturApiController::class, 'login']);
    Route::post('/scan-absensi', [InstrukturApiController::class, 'scanAbsensi']);
});