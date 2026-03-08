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
use Midtrans\Config;
use Midtrans\Snap;

// --- MODEL TAMBAHAN UNTUK FITUR PT ---
use App\Models\MemberPaketPt;
use App\Models\KetersediaanInstruktur;
use App\Models\BookingPt;
use Carbon\Carbon;

class MemberApiController extends Controller
{
    // ==========================================
    // --- FITUR LAMA (GYM UMUM) ---
    // ==========================================

    // --- AUTH ---
    public function register(Request $request)
    {
        // Cek apakah data masuk atau tidak dengan log (opsional)
        // \Log::info($request->all()); 

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:members,email', // Pastikan nama tabel 'members'
            'no_hp' => 'required|string|max:15',
            'password' => 'required|string|min:6',
        ]);

        $member = \App\Models\Member::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'status_membership' => 'Tidak Aktif',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Registrasi berhasil!',
            'data' => $member
        ], 201);
    }

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

    // --- FITUR UPDATE DATA PRIBADI (Poin 11 Requirement) ---
    public function updateProfile(Request $request, $id)
    {
        $member = Member::find($id);
        if (!$member) {
            return response()->json(['status' => 'error', 'message' => 'Member tidak ditemukan'], 404);
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
            'email' => 'required|string|email|unique:members,email,'.$id.',member_id',
        ]);

        $member->nama = $request->nama;
        $member->email = $request->email;
        $member->no_hp = $request->no_hp;

        // Update password kalau diisi saja
        if ($request->filled('password')) {
            $member->password = Hash::make($request->password);
        }

        $member->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Profil berhasil diperbarui!',
            'data' => $member
        ], 200);
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
        $request->validate([
            'member_id' => 'required',
            'paket_id' => 'required',
        ]);

        $member = Member::find($request->member_id);
        $paket = Paket::find($request->paket_id);

        if (!$member || !$paket) {
            return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan'], 404);
        }

        // 1. Buat data pemesanan di database dengan status Pending
        $pemesanan = PemesananPaket::create([
            'member_id' => $member->member_id,
            'paket_id' => $paket->paket_id,
            'status_persetujuan' => 'Pending',
            'tanggal_pesan' => now()->toDateString(),
        ]);

        // Buat Order ID unik untuk Midtrans (Misal: GYM-123-170984920)
        $orderId = 'GYM-' . $pemesanan->id . '-' . time();

        // 2. Setup Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        // 3. Buat Parameter untuk dikirim ke Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $paket->harga, // Ambil harga dari tabel paket
            ],
            'customer_details' => [
                'first_name' => $member->nama,
                'email' => $member->email,
                'phone' => $member->no_hp ?? '0800000000',
            ]
        ];

        try {
            // 4. Dapatkan Snap Token dari Midtrans
            $snapToken = Snap::getSnapToken($params);

            // Simpan Order ID Midtrans ke tabel pemesanan jika diperlukan (Opsional tapi disarankan)
            // $pemesanan->update(['order_id_midtrans' => $orderId]);

            return response()->json([
                'status' => 'success',
                'message' => 'Token pembayaran berhasil dibuat',
                'snap_token' => $snapToken,
                'order_id' => $orderId,
                'data' => $pemesanan
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal membuat token Midtrans: ' . $e->getMessage()
            ], 500);
        }
    }

    // --- RIWAYAT ---
    public function getRiwayatPresensi($member_id)
    {
        $riwayat = Presensi::where('member_id', $member_id)->orderBy('waktu_presensi', 'desc')->get();
        return response()->json(['status' => 'success', 'data' => $riwayat], 200);
    }


    // ==========================================
    // --- FITUR BARU: PERSONAL TRAINER (PT) ---
    // ==========================================

    // 1. Cek Sisa Sesi Paket PT Member
    public function getPaketPtAktif($member_id)
    {
        $paket = MemberPaketPt::where('member_id', $member_id)
            ->where('status', 'Aktif')
            ->where('sisa_sesi', '>', 0)
            ->where('expired_date', '>=', Carbon::now()->toDateString())
            ->get();

        return response()->json([
            'status' => 'success', 
            'data' => $paket
        ], 200);
    }

    // 2. Tampilkan Slot Instruktur yang Masih Kosong
    public function getInstrukturPtTersedia()
    {
        // Hanya tampilkan jadwal hari ini ke depan, dan yang belum dibooking
        $tersedia = KetersediaanInstruktur::with('instruktur') // Ambil relasi nama instruktur
            ->where('tanggal', '>=', Carbon::now()->toDateString())
            ->where('is_booked', false)
            ->orderBy('tanggal', 'asc')
            ->orderBy('jam_mulai', 'asc')
            ->get();

        return response()->json([
            'status' => 'success', 
            'data' => $tersedia
        ], 200);
    }

    // 3. Member Melakukan Booking PT
    public function bookingPt(Request $request)
    {
        $request->validate([
            'member_paket_id' => 'required|exists:member_paket_pts,member_paket_id',
            'ketersediaan_id' => 'required|exists:ketersediaan_instrukturs,ketersediaan_id',
        ]);

        // Cek apakah slot masih kosong
        $slot = KetersediaanInstruktur::find($request->ketersediaan_id);
        if ($slot->is_booked) {
            return response()->json(['status' => 'error', 'message' => 'Maaf, slot jadwal ini baru saja dibooking orang lain.'], 400);
        }

        // Cek apakah paket member masih valid
        $paket = MemberPaketPt::find($request->member_paket_id);
        if ($paket->sisa_sesi <= 0 || $paket->status != 'Aktif') {
            return response()->json(['status' => 'error', 'message' => 'Paket PT tidak aktif atau sisa sesi habis.'], 400);
        }

        // Kunci slot instruktur agar tidak bisa dipilih orang lain
        $slot->is_booked = true;
        $slot->save();

        // Buat data booking
        $booking = BookingPt::create([
            'member_paket_id' => $request->member_paket_id,
            'ketersediaan_id' => $request->ketersediaan_id,
            'status' => 'Booked'
        ]);

        return response()->json([
            'status' => 'success', 
            'message' => 'Berhasil booking jadwal PT!', 
            'data' => $booking
        ], 200);
    }

    // 4. Fitur Reschedule (Ganti Jadwal)
    public function reschedulePt(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:booking_pts,booking_id',
            'ketersediaan_id_baru' => 'required|exists:ketersediaan_instrukturs,ketersediaan_id',
        ]);

        $bookingLama = BookingPt::with('ketersediaan')->find($request->booking_id);

        // ATURAN DOSEN: Validasi Reschedule Minimal 6 Jam Sebelum Latihan Dimulai
        $waktuJadwalLama = Carbon::parse($bookingLama->ketersediaan->tanggal . ' ' . $bookingLama->ketersediaan->jam_mulai);
        if (Carbon::now()->diffInHours($waktuJadwalLama, false) < 6) {
            return response()->json(['status' => 'error', 'message' => 'Reschedule ditolak. Maksimal ganti jadwal adalah 6 jam sebelum sesi dimulai.'], 400);
        }

        // Validasi slot baru
        $slotBaru = KetersediaanInstruktur::find($request->ketersediaan_id_baru);
        if ($slotBaru->is_booked) {
            return response()->json(['status' => 'error', 'message' => 'Slot jadwal baru sudah terisi, silakan pilih jam lain.'], 400);
        }

        // 1. Lepas slot jadwal lama (kembalikan jadi kosong)
        $slotLama = $bookingLama->ketersediaan;
        $slotLama->is_booked = false;
        $slotLama->save();

        // 2. Kunci slot jadwal baru
        $slotBaru->is_booked = true;
        $slotBaru->save();

        // 3. Ubah status booking lama menjadi 'Reschedule' (sebagai riwayat)
        $bookingLama->status = 'Reschedule';
        $bookingLama->save();

        // 4. Buat bookingan baru
        $bookingBaru = BookingPt::create([
            'member_paket_id' => $bookingLama->member_paket_id,
            'ketersediaan_id' => $slotBaru->ketersediaan_id,
            'status' => 'Booked'
        ]);

        return response()->json([
            'status' => 'success', 
            'message' => 'Jadwal berhasil di-reschedule!', 
            'data' => $bookingBaru
        ], 200);
    }

    public function midtransCallback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed == $request->signature_key) {
            if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                
                // Ekstrak ID Pemesanan dari order_id (Format kita: GYM-{ID}-time)
                $orderParts = explode('-', $request->order_id);
                $pemesananId = $orderParts[1];

                $pemesanan = PemesananPaket::find($pemesananId);
                
                if ($pemesanan) {
                    // 1. Ubah status pemesanan
                    $pemesanan->status_persetujuan = 'Disetujui';
                    $pemesanan->save();

                    // 2. Aktifkan Membership
                    $member = Member::find($pemesanan->member_id);
                    if ($member) {
                        $member->status_membership = 'Aktif';
                        $member->save();
                    }
                }
            }
        }
        return response()->json(['message' => 'Callback diterima']);
    }
}