<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MemberApiController;
use App\Http\Controllers\Api\InstrukturApiController;

// ==========================================
// ROUTE API UNTUK MEMBER
// ==========================================

Route::post('/midtrans/callback', [MemberApiController::class, 'midtransCallback']);

Route::prefix('member')->group(function () {
    // --- FITUR LAMA ---
    Route::post('/login', [MemberApiController::class, 'login']);
    Route::post('/register', [MemberApiController::class, 'register']); // <--- TAMBAHKAN INI
    Route::get('/profile/{id}', [MemberApiController::class, 'getProfile']);
    Route::put('/profile/{id}', [MemberApiController::class, 'updateProfile']); // <--- TAMBAHKAN INI
    Route::get('/pakets', [MemberApiController::class, 'getPakets']);
    Route::get('/pengumumans', [MemberApiController::class, 'getPengumumans']);
    Route::get('/lokasis', [MemberApiController::class, 'getLokasis']);
    Route::get('/jadwal', [MemberApiController::class, 'getJadwal']);
    Route::post('/booking', [MemberApiController::class, 'bookingJadwal']);
    Route::post('/beli-paket', [MemberApiController::class, 'beliPaket']);
    Route::get('/riwayat-presensi/{member_id}', [MemberApiController::class, 'getRiwayatPresensi']);

    // --- FITUR BARU: PERSONAL TRAINER (PT) ---
    // 1. Cek paket PT yang dimiliki member (sisa berapa sesi)
    Route::get('/pt/paket-aktif/{member_id}', [MemberApiController::class, 'getPaketPtAktif']);
    // 2. Lihat daftar jadwal luang instruktur yang bisa di-booking
    Route::get('/pt/instruktur', [MemberApiController::class, 'getInstrukturPtTersedia']);
    // 3. Member melakukan booking jadwal instruktur
    Route::post('/pt/booking', [MemberApiController::class, 'bookingPt']);
    // 4. Member melakukan reschedule jadwal (H-1)
    Route::post('/pt/reschedule', [MemberApiController::class, 'reschedulePt']);
});

// ==========================================
// ROUTE API UNTUK INSTRUKTUR
// ==========================================
Route::prefix('instruktur')->group(function () {
    // --- FITUR LAMA ---
    Route::post('/login', [InstrukturApiController::class, 'login']);
    Route::get('/jadwal-saya/{instruktur_id}', [InstrukturApiController::class, 'getJadwalSaya']);
    Route::get('/daftar-booking/{instruktur_id}', [InstrukturApiController::class, 'getDaftarBooking']);
    Route::post('/scan-absensi', [InstrukturApiController::class, 'scanAbsensi']);

    // --- FITUR BARU: PERSONAL TRAINER (PT) ---
    // 1. Instruktur set jadwal kosong mereka
    Route::post('/pt/set-jadwal', [InstrukturApiController::class, 'setJadwalLuangPt']);
    // 2. Instruktur melihat siapa saja member PT yang harus dilatih
    Route::get('/pt/jadwal/{instruktur_id}', [InstrukturApiController::class, 'getJadwalMelatihPt']);
    // 3. Instruktur scan QR code booking PT milik member
    Route::post('/pt/scan-qr', [InstrukturApiController::class, 'scanQrPt']);
});