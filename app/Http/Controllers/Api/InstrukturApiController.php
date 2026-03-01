<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Instruktur;
use App\Models\Member;
use App\Models\Presensi; // Pastikan model ini ada
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

    // Fitur Scan QR Member (Absensi)
    public function scanAbsensi(Request $request)
    {
        $request->validate([
            'instruktur_id' => 'required',
            'member_id' => 'required', // ID ini didapat dari hasil scan QR di HP Member
        ]);

        $member = Member::find($request->member_id);

        if (!$member || $member->status_membership !== 'Aktif') {
            return response()->json(['status' => 'error', 'message' => 'Member tidak ditemukan atau tidak aktif'], 400);
        }

        // Catat di tabel presensi
        Presensi::create([
            'member_id' => $request->member_id,
            'instruktur_id' => $request->instruktur_id,
            'waktu_presensi' => now(),
        ]);

        return response()->json([
            'status' => 'success', 
            'message' => 'Presensi ' . $member->nama . ' berhasil!'
        ], 200);
    }
}