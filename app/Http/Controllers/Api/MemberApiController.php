<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Paket;
use App\Models\Pengumuman;
use App\Models\Lokasi;
use App\Models\PemesananPaket;
use App\Models\JadwalLatihan;
use App\Models\BookingAbsensi;
use App\Models\Presensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MemberApiController extends Controller
{
    // --- AUTH ---
    public function login(Request $request)
    {
        $member = Member::where('email', $request->email)->first();
        if (!$member || !Hash::check($request->password, $member->password)) {
            return response()->json(['status' => 'error', 'message' => 'Login Gagal'], 401);
        }
        return response()->json(['status' => 'success', 'data' => $member], 200);
    }

    public function getProfile($id)
    {
        $member = Member::findOrFail($id);
        return response()->json(['status' => 'success', 'data' => $member], 200);
    }

    // --- DATA MASTER ---
    public function getPakets() { return response()->json(Paket::all(), 200); }
    public function getPengumumans() { return response()->json(Pengumuman::orderBy('tanggal_post', 'desc')->get(), 200); }
    public function getLokasis() { return response()->json(Lokasi::all(), 200); }

    // --- FITUR JADWAL & BOOKING ---
    public function getJadwal()
    {
        // Mengambil jadwal beserta nama instrukturnya
        $jadwal = JadwalLatihan::with('instruktur')->get();
        return response()->json(['status' => 'success', 'data' => $jadwal], 200);
    }

    public function bookingJadwal(Request $request)
    {
        $request->validate([
            'member_id' => 'required',
            'jadwal_id' => 'required',
        ]);

        $jadwal = JadwalLatihan::findOrFail($request->jadwal_id);

        // Cek kuota
        $jumlahBooking = BookingAbsensi::where('jadwal_id', $request->jadwal_id)
                        ->where('status_booking', 'Booked')->count();
        
        if ($jumlahBooking >= $jadwal->kuota) {
            return response()->json(['status' => 'error', 'message' => 'Kuota jadwal sudah penuh'], 400);
        }

        $booking = BookingAbsensi::create([
            'member_id' => $request->member_id,
            'jadwal_id' => $request->jadwal_id,
            'instruktur_id' => $jadwal->instruktur_id,
            'tanggal' => now()->toDateString(),
            'status_booking' => 'Booked',
            'status_hadir' => 'Belum Absen'
        ]);

        return response()->json(['status' => 'success', 'data' => $booking], 201);
    }

    // --- PEMESANAN PAKET ---
    public function beliPaket(Request $request)
    {
        // Sesuai SQL: menggunakan kolom 'tanggal_pesan' dan 'status_persetujuan'
        $request->validate([
            'member_id' => 'required',
            'paket_id' => 'required',
        ]);

        $pemesanan = PemesananPaket::create([
            'member_id' => $request->member_id,
            'paket_id' => $request->paket_id,
            'instruktur_id' => $request->instruktur_id, // Opsional untuk PT
            'status_persetujuan' => 'Pending',
            'tanggal_pesan' => now()->toDateString(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Pemesanan berhasil dibuat, menunggu persetujuan admin',
            'data' => $pemesanan
        ], 201);
    }

    // --- RIWAYAT ---
    public function getRiwayatPresensi($member_id)
    {
        $riwayat = Presensi::where('member_id', $member_id)->orderBy('waktu_presensi', 'desc')->get();
        return response()->json(['status' => 'success', 'data' => $riwayat], 200);
    }
}