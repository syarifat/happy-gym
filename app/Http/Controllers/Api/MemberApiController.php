<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Midtrans\Config;
use Midtrans\Snap;

// --- SEMUA MODEL YANG DIBUTUHKAN ---
use App\Models\Member;
use App\Models\Paket;
use App\Models\Instruktur;
use App\Models\PemesananPaket;
use App\Models\Pembayaran;
use App\Models\JadwalLatihan;
use App\Models\BookingAbsensi;
use App\Models\Presensi;
use App\Models\MemberPaketPt;
use App\Models\KetersediaanInstruktur;
use App\Models\BookingPt;
use App\Models\Lokasi; // <--- Pastikan ini ada
use App\Models\KunjunganGym;

class MemberApiController extends Controller
{
    // =========================================================================
    // BAGIAN 1: AUTENTIKASI & PROFIL (POIN 2, 3, 4, 11, 12)
    // =========================================================================

    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:members,email',
            'no_hp' => 'required|string|max:15',
            'password' => 'required|string|min:6',
            'lokasi_id' => 'required' // <--- TAMBAHAN BARU
        ]);

        $member = Member::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'password' => Hash::make($request->password),
            'status_membership' => 'Tidak Aktif',
            'lokasi_id' => $request->lokasi_id // <--- TAMBAHAN BARU (Pastikan kolom ini ada di tabel members)
        ]);

        return response()->json(['status' => 'success', 'message' => 'Registrasi berhasil!', 'data' => $member], 201);
    }

    public function getLokasis()
    {
        $lokasis = Lokasi::all();
        
        // Terjemahkan nama kolom database (nama_cabang) ke format Android (nama_lokasi)
        $formattedLokasi = $lokasis->map(function ($cabang) {
            return [
                'lokasi_id' => $cabang->lokasi_id, 
                'nama_lokasi' => $cabang->nama_cabang // <--- INI KUNCINYA
            ];
        });
        
        return response()->json($formattedLokasi, 200);
    }

    public function login(Request $request)
    {
        $member = Member::where('email', $request->email)->first();
        if (!$member || !Hash::check($request->password, $member->password)) {
            return response()->json(['status' => 'error', 'message' => 'Email atau Password salah'], 401);
        }
        return response()->json(['status' => 'success', 'message' => 'Login berhasil', 'data' => $member], 200);
    }

    public function getProfile($id)
    {
        $member = Member::find($id);
        if (!$member) return response()->json(['status' => 'error', 'message' => 'Member tidak ditemukan'], 404);
        
        // Cari paket terakhir yang dibeli dan disetujui
        $latestPemesanan = \App\Models\PemesananPaket::where('member_id', $id)
                            ->where('status_persetujuan', 'Disetujui')
                            ->orderBy('tanggal_pesan', 'desc')
                            ->with('paket')
                            ->first();

        // Tambahkan properti baru secara dinamis untuk dikirim ke Android
        $member->nama_paket_aktif = $latestPemesanan && $latestPemesanan->paket ? $latestPemesanan->paket->nama_paket : null;

        return response()->json(['status' => 'success', 'data' => $member], 200);
    }

    public function updateProfile(Request $request, $id)
    {
        $member = Member::find($id);
        if (!$member) return response()->json(['status' => 'error', 'message' => 'Member tidak ditemukan'], 404);

        $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
            'email' => 'required|string|email|unique:members,email,'.$id.',member_id',
        ]);

        $member->nama = $request->nama;
        $member->email = $request->email;
        $member->no_hp = $request->no_hp;
        if ($request->filled('password')) {
            $member->password = Hash::make($request->password);
        }
        $member->save();

        return response()->json(['status' => 'success', 'message' => 'Profil diperbarui!', 'data' => $member], 200);
    }


    // =========================================================================
    // BAGIAN 2: MASTER DATA & TRANSAKSI (POIN 5 & 6)
    // =========================================================================

    public function getPakets()
    {
        $pakets = Paket::all();
        return response()->json(['status' => 'success', 'data' => $pakets], 200);
    }

    public function getDaftarInstruktur()
    {
        // Poin 6: Menampilkan foto, nama, spesialisasi
        $instruktur = Instruktur::all();
        return response()->json(['status' => 'success', 'data' => $instruktur], 200);
    }

    public function beliPaket(Request $request)
    {
        $request->validate(['member_id' => 'required', 'paket_id' => 'required']);
        $member = Member::find($request->member_id);
        $paket = Paket::find($request->paket_id);

        if (!$member || !$paket) return response()->json(['status' => 'error', 'message' => 'Data tidak valid'], 404);

        $pemesanan = PemesananPaket::create([
            'member_id' => $member->member_id,
            'paket_id' => $paket->paket_id,
            'status_persetujuan' => 'Pending',
            'tanggal_pesan' => now()->toDateString(),
        ]);

        $orderId = 'GYM-' . $pemesanan->getKey() . '-' . time();

        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        $params = [
            'transaction_details' => ['order_id' => $orderId, 'gross_amount' => $paket->harga],
            'customer_details' => ['first_name' => $member->nama, 'email' => $member->email, 'phone' => $member->no_hp]
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return response()->json(['status' => 'success', 'snap_token' => $snapToken, 'order_id' => $orderId], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function midtransCallback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed == $request->signature_key) {
            if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                
                $orderParts = explode('-', $request->order_id);
                $pemesananId = $orderParts[1];
                $pemesanan = PemesananPaket::with('paket')->find($pemesananId);
                
                if ($pemesanan && $pemesanan->status_persetujuan == 'Pending') {
                    
                    // 1. Ubah status pemesanan
                    $pemesanan->status_persetujuan = 'Disetujui';
                    $pemesanan->save();

                    // 2. Catat ke Riwayat Pembayaran (Poin 10)
                    Pembayaran::create([
                        'pemesanan_id' => $pemesanan->pemesanan_id,
                        'member_id' => $pemesanan->member_id,
                        'order_id' => $request->order_id,
                        'metode' => $request->payment_type,
                        'jumlah' => $request->gross_amount,
                        'status' => 'settlement',
                        'tanggal_bayar' => now(),
                    ]);

                    // 3. LOGIKA KUNCI: Bedakan Paket Gym Umum vs Personal Trainer
                    $paket = $pemesanan->paket;
                    $member = Member::find($pemesanan->member_id); // <--- Tarik data member di sini

                    if ($paket->jenis == 'Personal Training' || str_contains(strtolower($paket->nama_paket), 'pt')) {
                        // A. Jika beli PT -> Tambah kuota sesi di tabel khusus PT
                        MemberPaketPt::create([
                            'member_id' => $pemesanan->member_id,
                            'paket_id' => $paket->paket_id,
                            'sisa_sesi' => $paket->jumlah_sesi ?? 12, 
                            'expired_date' => Carbon::now()->addDays($paket->durasi ?? 30)->toDateString(),
                            'status' => 'Aktif'
                        ]);

                        // B. PERBAIKAN: Aktifkan juga status membership utamanya agar Dashboard Hijau!
                        $member->status_membership = 'Aktif';
                        
                        // Opsional: Set masa aktif member sesuai durasi paket PT
                        $member->tanggal_berakhir_member = Carbon::now()->addDays($paket->durasi ?? 30)->toDateString();
                        $member->save();

                    } else {
                        // Jika beli Gym Umum -> Aktifkan Member & Set Tanggal Habis
                        $member->status_membership = 'Aktif';
                        $member->tanggal_berakhir_member = Carbon::now()->addDays($paket->durasi ?? 30)->toDateString();
                        $member->save();
                    }
                }
            }
        }
        return response()->json(['message' => 'Callback diproses']);
    }


    // =========================================================================
    // BAGIAN 3: JADWAL & BOOKING GYM UMUM (KELAS)
    // =========================================================================

    public function getJadwalGymUmum()
    {
        $jadwal = JadwalLatihan::with('instruktur')->get();
        return response()->json(['status' => 'success', 'data' => $jadwal], 200);
    }

    public function bookingGymUmum(Request $request)
    {
        $request->validate(['member_id' => 'required', 'jadwal_id' => 'required']);
        $jadwal = JadwalLatihan::findOrFail($request->jadwal_id);

        $jumlahBooking = BookingAbsensi::where('jadwal_id', $request->jadwal_id)->where('status_booking', 'Booked')->count();
        if ($jumlahBooking >= $jadwal->kuota) {
            return response()->json(['status' => 'error', 'message' => 'Kuota penuh'], 400);
        }

        $booking = BookingAbsensi::create([
            'member_id' => $request->member_id,
            'jadwal_id' => $request->jadwal_id,
            'instruktur_id' => $jadwal->instruktur_id,
            'tanggal' => now()->toDateString(),
            'status_booking' => 'Booked',
            'status_hadir' => 'Belum Absen'
        ]);

        return response()->json(['status' => 'success', 'message' => 'Berhasil booking kelas', 'data' => $booking], 201);
    }


    // =========================================================================
    // BAGIAN 4: JADWAL & BOOKING PERSONAL TRAINER (POIN 7)
    // =========================================================================

    public function getPaketPtAktif($member_id)
    {
        // Tambahkan with('instruktur')
        $paket = MemberPaketPt::with('instruktur')
            ->where('member_id', $member_id)
            ->where('status', 'Aktif')->where('sisa_sesi', '>', 0)
            ->where('expired_date', '>=', Carbon::now()->toDateString())->get();
        return response()->json(['status' => 'success', 'data' => $paket], 200);
    }

    public function getCoachCabang($member_id)
    {
        $member = Member::find($member_id);
        // Ambil instruktur yang lokasinya sama dengan cabang member
        $coaches = Instruktur::where('lokasi_id', $member->lokasi_id)->get();
        return response()->json(['status' => 'success', 'data' => $coaches], 200);
    }

    public function pilihCoachPt(Request $request)
    {
        $request->validate([
            'member_paket_id' => 'required',
            'instruktur_id' => 'required'
        ]);

        $paket = MemberPaketPt::find($request->member_paket_id);
        $paket->instruktur_id = $request->instruktur_id;
        $paket->save();

        return response()->json(['status' => 'success', 'message' => 'Coach berhasil dipilih!'], 200);
    }

    public function getInstrukturPtTersedia($member_id) 
    {
        // 1. Cari paket PT aktif milik member ini
        $paketPt = MemberPaketPt::where('member_id', $member_id)
                    ->where('status', 'Aktif')
                    ->where('sisa_sesi', '>', 0)
                    ->first();

        // 2. Jika belum punya paket atau belum memilih coach, kembalikan kosong
        if (!$paketPt || !$paketPt->instruktur_id) {
            return response()->json(['status' => 'success', 'data' => []], 200);
        }

        // 3. Ambil jadwal HANYA untuk instruktur yang SUDAH DIPILIH di paket tersebut
        $tersedia = KetersediaanInstruktur::with('instruktur')
            ->where('instruktur_id', $paketPt->instruktur_id) // <--- FILTER KUNCI
            ->where('tanggal', '>=', Carbon::now()->toDateString())
            ->where('is_booked', 0)
            ->orderBy('tanggal', 'asc')->orderBy('jam_mulai', 'asc')->get();

        return response()->json(['status' => 'success', 'data' => $tersedia], 200);
    }

    public function bookingPt(Request $request)
    {
        $request->validate(['member_paket_id' => 'required', 'ketersediaan_id' => 'required']);

        $slot = KetersediaanInstruktur::find($request->ketersediaan_id);
        if ($slot->is_booked) return response()->json(['status' => 'error', 'message' => 'Slot sudah dibooking'], 400);

        $paket = MemberPaketPt::find($request->member_paket_id);
        if ($paket->sisa_sesi <= 0) return response()->json(['status' => 'error', 'message' => 'Sisa sesi habis'], 400);

        $slot->is_booked = true;
        $slot->save();

        $booking = BookingPt::create([
            'member_paket_id' => $request->member_paket_id,
            'ketersediaan_id' => $request->ketersediaan_id,
            'status' => 'Booked' // Poin 7: Status Booking = Booked
        ]);

        return response()->json(['status' => 'success', 'message' => 'Berhasil booking PT', 'data' => $booking], 200);
    }

    public function reschedulePt(Request $request)
    {
        // Fitur Pelengkap: Member bisa pindah jadwal jika tidak bisa datang
        $request->validate(['booking_id' => 'required', 'ketersediaan_id_baru' => 'required']);
        
        $bookingLama = BookingPt::with('ketersediaan')->find($request->booking_id);
        $waktuJadwalLama = Carbon::parse($bookingLama->ketersediaan->tanggal . ' ' . $bookingLama->ketersediaan->jam_mulai);
        
        if (Carbon::now()->diffInHours($waktuJadwalLama, false) < 6) {
            return response()->json(['status' => 'error', 'message' => 'Maksimal reschedule adalah H-6 jam'], 400);
        }

        $slotBaru = KetersediaanInstruktur::find($request->ketersediaan_id_baru);
        if ($slotBaru->is_booked) return response()->json(['status' => 'error', 'message' => 'Slot baru sudah terisi'], 400);

        // Lepas slot lama, kunci slot baru
        $bookingLama->ketersediaan->update(['is_booked' => false]);
        $slotBaru->update(['is_booked' => true]);

        $bookingLama->update(['status' => 'Reschedule']);
        $bookingBaru = BookingPt::create(['member_paket_id' => $bookingLama->member_paket_id, 'ketersediaan_id' => $slotBaru->ketersediaan_id, 'status' => 'Booked']);

        return response()->json(['status' => 'success', 'message' => 'Reschedule berhasil', 'data' => $bookingBaru], 200);
    }


    // =========================================================================
    // BAGIAN 5: PUSAT RIWAYAT MEMBER (POIN 10)
    // =========================================================================

    public function getRiwayatPembayaran($member_id)
    {
        $riwayat = Pembayaran::select('pembayarans.*', 'pakets.nama_paket')
            ->join('pemesanan_pakets', 'pembayarans.pemesanan_id', '=', 'pemesanan_pakets.pemesanan_id')
            ->join('pakets', 'pemesanan_pakets.paket_id', '=', 'pakets.paket_id')
            ->where('pembayarans.member_id', $member_id)
            ->orderBy('pembayarans.tanggal_bayar', 'desc')->get();
        return response()->json(['status' => 'success', 'data' => $riwayat], 200);
    }

    public function getRiwayatLatihan($member_id)
    {
        // Poin 10: Riwayat Kehadiran Latihan Biasa (Dari tabel Presensi)
        $riwayat = Presensi::with('instruktur')->where('member_id', $member_id)->orderBy('waktu_presensi', 'desc')->get();
        return response()->json(['status' => 'success', 'data' => $riwayat], 200);
    }

    public function getRiwayatBookingPt($member_id)
    {
        // Poin 10: Riwayat Booking Instruktur PT
        $riwayat = BookingPt::with(['ketersediaan.instruktur'])
            ->whereHas('memberPaket', function($query) use ($member_id) {
                $query->where('member_id', $member_id);
            })->orderBy('created_at', 'desc')->get();
        return response()->json(['status' => 'success', 'data' => $riwayat], 200);
    }

    // =========================================================================
    // BAGIAN 6: PRESENSI MANDIRI (CHECK-IN GEDUNG)
    // =========================================================================

    public function getStatusPresensi($member_id)
    {
        // Mengecek apakah hari ini member sudah check-in dan belum check-out
        $kunjungan = KunjunganGym::where('member_id', $member_id)
            ->where('tanggal', now()->toDateString())
            ->where('status_kunjungan', 'Masuk')
            ->first();

        return response()->json([
            'status' => 'success',
            'is_check_in' => $kunjungan ? true : false,
            'data' => $kunjungan
        ]);
    }

    public function checkIn(Request $request)
    {
        $request->validate(['member_id' => 'required', 'lokasi_id' => 'required']);

        // Mencegah double check-in di hari yang sama
        $cekSudahMasuk = KunjunganGym::where('member_id', $request->member_id)
                            ->where('tanggal', now()->toDateString())
                            ->where('status_kunjungan', 'Masuk')
                            ->first();

        if ($cekSudahMasuk) {
            return response()->json(['status' => 'error', 'message' => 'Anda sudah Check-in sebelumnya.'], 400);
        }

        $kunjungan = KunjunganGym::create([
            'member_id' => $request->member_id,
            'lokasi_id' => $request->lokasi_id,
            'tanggal' => now()->toDateString(),
            'waktu_masuk' => now()->toTimeString(),
            'status_kunjungan' => 'Masuk'
        ]);

        return response()->json(['status' => 'success', 'message' => 'Berhasil Check-in! Selamat berlatih.', 'data' => $kunjungan], 201);
    }

    public function checkOut(Request $request)
    {
        // Cari data check-in hari ini yang statusnya masih 'Masuk'
        $kunjungan = KunjunganGym::where('member_id', $request->member_id)
            ->where('tanggal', now()->toDateString())
            ->where('status_kunjungan', 'Masuk')
            ->first();

        if ($kunjungan) {
            $kunjungan->waktu_keluar = now()->toTimeString();
            $kunjungan->status_kunjungan = 'Selesai';
            $kunjungan->save();
            
            return response()->json(['status' => 'success', 'message' => 'Berhasil Check-out! Hati-hati di jalan.']);
        }

        return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan / Anda belum Check-in'], 404);
    }
}
