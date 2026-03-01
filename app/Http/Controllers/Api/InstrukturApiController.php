<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Instruktur;
use App\Models\Member;
use App\Models\Presensi;
use App\Models\JadwalLatihan;
use App\Models\BookingAbsensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class InstrukturApiController extends Controller
{
    public function login(Request $request)
    {
        $instruktur = Instruktur::where('username', $request->username)->first();
        if (!$instruktur || !Hash::check($request->password, $instruktur->password)) {
            return response()->json(['status' => 'error', 'message' => 'Login Gagal'], 401);
        }
        return response()->json(['status' => 'success', 'data' => $instruktur], 200);
    }

    // Melihat jadwal mengajar instruktur tersebut
    public function getJadwalSaya($instruktur_id)
    {
        $jadwal = JadwalLatihan::where('instruktur_id', $instruktur_id)->get();
        return response()->json(['status' => 'success', 'data' => $jadwal], 200);
    }

    // Melihat siapa saja yang booking di kelasnya hari ini
    public function getDaftarBooking($instruktur_id)
    {
        $booking = BookingAbsensi::with('member')
                    ->where('instruktur_id', $instruktur_id)
                    ->where('tanggal', now()->toDateString())
                    ->get();
        return response()->json(['status' => 'success', 'data' => $booking], 200);
    }

    // Fitur Scan QR Member (Absensi Gym Umum)
    public function scanAbsensi(Request $request)
    {
        $request->validate([
            'instruktur_id' => 'required',
            'member_id' => 'required',
        ]);

        $member = Member::find($request->member_id);

        if (!$member || $member->status_membership !== 'Aktif') {
            return response()->json(['status' => 'error', 'message' => 'Member tidak aktif/tidak ditemukan'], 400);
        }

        $presensi = Presensi::create([
            'member_id' => $request->member_id,
            'instruktur_id' => $request->instruktur_id,
            'waktu_presensi' => now(),
        ]);

        return response()->json(['status' => 'success', 'message' => 'Presensi berhasil'], 200);
    }
}