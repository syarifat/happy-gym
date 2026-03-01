<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Paket;
use App\Models\Pengumuman;
use App\Models\Lokasi;
use App\Models\PemesananPaket; // Pastikan model ini ada
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MemberApiController extends Controller
{
    // --- AUTH & DATA DASAR ---
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

    public function getPakets() { return response()->json(Paket::all(), 200); }
    public function getPengumumans() { return response()->json(Pengumuman::orderBy('tanggal_post', 'desc')->get(), 200); }
    public function getLokasis() { return response()->json(Lokasi::all(), 200); }

    // --- PEMESANAN PAKET ---
    public function beliPaket(Request $request)
    {
        $request->validate([
            'member_id' => 'required',
            'paket_id' => 'required',
        ]);

        $paket = Paket::findOrFail($request->paket_id);

        // Buat data pemesanan
        $pemesanan = PemesananPaket::create([
            'member_id' => $request->member_id,
            'paket_id' => $request->paket_id,
            'tanggal_pemesanan' => now(),
            'total_harga' => $paket->harga,
            'status' => 'Pending'
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Pemesanan berhasil dibuat',
            'pemesanan_id' => $pemesanan->pemesanan_id,
            'total_harga' => $paket->harga
        ], 201);
    }
}