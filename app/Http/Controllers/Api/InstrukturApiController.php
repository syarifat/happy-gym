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

// --- MODEL TAMBAHAN UNTUK FITUR PT ---
use App\Models\KetersediaanInstruktur;
use App\Models\BookingPt;
use Carbon\Carbon;

class InstrukturApiController extends Controller
{
    // ==========================================
    // BAGIAN 1: FITUR GYM UMUM (KODE LAMA ANDA)
    // ==========================================

    public function login(Request $request)
    {
        $instruktur = Instruktur::where('username', $request->username)->first();
        if (!$instruktur || !Hash::check($request->password, $instruktur->password)) {
            return response()->json(['status' => 'error', 'message' => 'Login Gagal'], 401);
        }
        return response()->json(['status' => 'success', 'data' => $instruktur], 200);
    }

    public function getJadwalSaya($instruktur_id)
    {
        $jadwal = JadwalLatihan::where('instruktur_id', $instruktur_id)->get();
        return response()->json(['status' => 'success', 'data' => $jadwal], 200);
    }

    public function getDaftarBooking($instruktur_id)
    {
        $booking = BookingAbsensi::with('member')
                    ->where('instruktur_id', $instruktur_id)
                    ->where('tanggal', now()->toDateString())
                    ->get();
        return response()->json(['status' => 'success', 'data' => $booking], 200);
    }

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


    // ==========================================
    // BAGIAN 2: FITUR PERSONAL TRAINER (BARU)
    // ==========================================

    // 1. Instruktur menentukan hari dan jam luang untuk PT
    public function setJadwalLuangPt(Request $request)
    {
        $request->validate([
            'instruktur_id' => 'required|exists:instrukturs,instruktur_id',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        $jadwal = KetersediaanInstruktur::create([
            'instruktur_id' => $request->instruktur_id,
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'is_booked' => false
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Jadwal luang PT berhasil ditambahkan!',
            'data' => $jadwal
        ]);
    }

    // 2. Instruktur melihat jadwal melatih PT (Siapa & Jam Berapa)
    public function getJadwalMelatihPt($instruktur_id)
    {
        // Tarik semua Klien (Member) yang memilih instruktur ini
        $klien = \App\Models\MemberPaketPt::with([
            'member', // Ambil data membernya
            'bookingPts' => function($query) {
                // Ambil HANYA jadwal booking yang statusnya Booked/Reschedule dan tanggalnya hari ini/ke depan
                $query->where('status', 'Booked')
                      ->whereHas('ketersediaan', function($q) {
                          $q->where('tanggal', '>=', \Carbon\Carbon::now()->toDateString());
                      })
                      ->with('ketersediaan'); // Ambil jam & tanggalnya
            }
        ])
        ->where('instruktur_id', $instruktur_id)
        ->where('status', 'Aktif')
        ->get();

        // Rapikan urutan jadwal per member berdasarkan tanggal dan jam terdekat
        $klien->each(function ($item) {
            $item->setRelation('bookingPts', $item->bookingPts->sortBy(function ($booking) {
                return $booking->ketersediaan->tanggal . ' ' . $booking->ketersediaan->jam_mulai;
            })->values());
        });

        return response()->json(['status' => 'success', 'data' => $klien], 200);
    }

    // 3. Scan QR Code Absensi PT (Mengurangi sisa sesi paket 12 -> 11)
    public function scanQrPt(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:booking_pts,booking_id'
        ]);

        $booking = BookingPt::with('memberPaket')->find($request->booking_id);

        if ($booking->status === 'Hadir') {
            return response()->json(['status' => 'error', 'message' => 'QR Code sudah digunakan (Sesi Selesai).'], 400);
        }

        $memberPaket = $booking->memberPaket;

        if ($memberPaket->sisa_sesi <= 0) {
            return response()->json(['status' => 'error', 'message' => 'Sisa sesi paket PT member sudah habis!'], 400);
        }

        // A. Ubah status booking jadi Hadir
        $booking->status = 'Hadir';
        $booking->waktu_scan_qr = Carbon::now();
        $booking->save();

        // B. Kurangi sisa sesi member (-1)
        $memberPaket->sisa_sesi = $memberPaket->sisa_sesi - 1;
        
        if ($memberPaket->sisa_sesi == 0) {
            $memberPaket->status = 'Habis';
        }
        $memberPaket->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Absensi PT berhasil! Sisa sesi member sekarang: ' . $memberPaket->sisa_sesi,
            'sisa_sesi' => $memberPaket->sisa_sesi
        ]);
    }

    // Menampilkan daftar jadwal luang (ketersediaan) milik instruktur
    public function getKetersediaanPt($instruktur_id)
    {
        $data = \App\Models\KetersediaanInstruktur::where('instruktur_id', $instruktur_id)
                ->orderBy('tanggal', 'desc') // Urutkan dari yang terbaru
                ->get();

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
}