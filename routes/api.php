<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MemberApiController;
use App\Http\Controllers\Api\InstrukturApiController;

// ==========================================
// ROUTE API UNTUK MEMBER
// ==========================================

Route::post('/midtrans/callback', [MemberApiController::class, 'midtransCallback']);

Route::prefix('member')->group(function () {
    // 1. Auth & Profil (Poin 2, 3, 4, 11)
    Route::post('/register', [\App\Http\Controllers\Api\MemberApiController::class, 'register']);
    Route::get('/lokasis', [\App\Http\Controllers\Api\MemberApiController::class, 'getLokasis']);
    Route::post('/login', [\App\Http\Controllers\Api\MemberApiController::class, 'login']);
    Route::get('/profile/{id}', [\App\Http\Controllers\Api\MemberApiController::class, 'getProfile']);
    Route::put('/profile/{id}', [\App\Http\Controllers\Api\MemberApiController::class, 'updateProfile']);

    // 2. Transaksi & Master Data (Poin 5 & 6)
    Route::get('/pakets', [\App\Http\Controllers\Api\MemberApiController::class, 'getPakets']);
    Route::get('/daftar-instruktur', [\App\Http\Controllers\Api\MemberApiController::class, 'getDaftarInstruktur']);
    Route::post('/beli-paket', [\App\Http\Controllers\Api\MemberApiController::class, 'beliPaket']);

    // 3. Kelas Gym Umum
    Route::get('/jadwal-gym', [\App\Http\Controllers\Api\MemberApiController::class, 'getJadwalGymUmum']);
    Route::post('/booking-gym', [\App\Http\Controllers\Api\MemberApiController::class, 'bookingGymUmum']);

    // 4. Personal Trainer (PT) (Poin 7)
    Route::get('/pt/paket-aktif/{member_id}', [\App\Http\Controllers\Api\MemberApiController::class, 'getPaketPtAktif']);
    Route::get('/pt/instruktur/{member_id}', [\App\Http\Controllers\Api\MemberApiController::class, 'getInstrukturPtTersedia']);
    Route::post('/pt/booking', [\App\Http\Controllers\Api\MemberApiController::class, 'bookingPt']);
    Route::post('/pt/reschedule', [\App\Http\Controllers\Api\MemberApiController::class, 'reschedulePt']);

    // 5. Riwayat (Poin 10)
    Route::get('/riwayat-pembayaran/{member_id}', [\App\Http\Controllers\Api\MemberApiController::class, 'getRiwayatPembayaran']);
    Route::get('/riwayat-latihan/{member_id}', [\App\Http\Controllers\Api\MemberApiController::class, 'getRiwayatLatihan']);
    Route::get('/pt/riwayat-booking/{member_id}', [\App\Http\Controllers\Api\MemberApiController::class, 'getRiwayatBookingPt']);

    Route::get('/pt/coach-cabang/{member_id}', [\App\Http\Controllers\Api\MemberApiController::class, 'getCoachCabang']);
    Route::post('/pt/pilih-coach', [\App\Http\Controllers\Api\MemberApiController::class, 'pilihCoachPt']);

    // 6. Presensi Mandiri Gedung
    Route::get('/presensi/status/{member_id}', [\App\Http\Controllers\Api\MemberApiController::class, 'getStatusPresensi']);
    Route::post('/presensi/check-in', [\App\Http\Controllers\Api\MemberApiController::class, 'checkIn']);
    Route::post('/presensi/check-out', [\App\Http\Controllers\Api\MemberApiController::class, 'checkOut']);
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
    Route::get('/pt/ketersediaan/{instruktur_id}', [InstrukturApiController::class, 'getKetersediaanPt']);
});