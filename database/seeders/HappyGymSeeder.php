<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class HappyGymSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Admins
        $adminId = DB::table('admins')->insertGetId([
            'nama' => 'Super Admin',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. Seed Instrukturs
        $instrukturId = DB::table('instrukturs')->insertGetId([
            'nama' => 'Coach Arnold',
            'username' => 'arnold',
            'password' => Hash::make('coach123'),
            'spesialisasi' => 'Bodybuilding & Fitness',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 3. Seed Members
        $memberId = DB::table('members')->insertGetId([
            'nama' => 'Andi Setiawan',
            'email' => 'andi@example.com',
            'password' => Hash::make('member123'),
            'no_hp' => '081234567890',
            'status_membership' => 'Aktif',
            'tanggal_mulai_member' => Carbon::now()->toDateString(),
            'tanggal_berakhir_member' => Carbon::now()->addMonth()->toDateString(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 4. Seed Pakets
        $paketId = DB::table('pakets')->insertGetId([
            'nama_paket' => 'Membership Gold 1 Bulan',
            'jenis' => 'Membership Bulanan',
            'harga' => 250000.00,
            'durasi' => 30,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 5. Seed Lokasis
        DB::table('lokasis')->insert([
            'nama_cabang' => 'Happy Gym - Tulungagung Pusat',
            'alamat' => 'Jl. Pahlawan No. 123, Tulungagung',
            'link_google_maps' => 'https://maps.google.com/?q=Tulungagung',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 6. Seed Pengumumans (Relasi ke Admin)
        DB::table('pengumumans')->insert([
            'admin_id' => $adminId,
            'judul' => 'Promo Ramadhan Ceria!',
            'deskripsi' => 'Diskon 20% untuk paket membership baru selama bulan Ramadhan.',
            'foto' => null,
            'tanggal_post' => Carbon::now()->toDateString(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 7. Seed Jadwal Latihans (Relasi ke Instruktur)
        $jadwalId = DB::table('jadwal_latihans')->insertGetId([
            'instruktur_id' => $instrukturId,
            'hari' => 'Senin',
            'jam_mulai' => '08:00:00',
            'jam_selesai' => '10:00:00',
            'jenis_latihan' => 'Zumba Class',
            'kuota' => 20,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 8. Seed Pemesanan Pakets (Relasi ke Member, Paket, Instruktur)
        $pemesananId = DB::table('pemesanan_pakets')->insertGetId([
            'member_id' => $memberId,
            'paket_id' => $paketId,
            'instruktur_id' => $instrukturId,
            'status_persetujuan' => 'Disetujui',
            'tanggal_pesan' => Carbon::now()->toDateString(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 9. Seed Pembayarans (Relasi ke Pemesanan & Member)
        DB::table('pembayarans')->insert([
            'pemesanan_id' => $pemesananId,
            'member_id' => $memberId,
            'order_id' => 'ORD-' . time(),
            'transaction_id' => 'MID-' . rand(1000, 9999),
            'metode' => 'GoPay',
            'jumlah' => 250000.00,
            'status' => 'settlement',
            'snap_token' => 'sample-snap-token',
            'tanggal_bayar' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 10. Seed Presensis (Relasi ke Member & Instruktur)
        DB::table('presensis')->insert([
            'member_id' => $memberId,
            'instruktur_id' => $instrukturId,
            'waktu_presensi' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 11. Seed Booking Absensis (Relasi ke Member, Jadwal, Instruktur)
        DB::table('booking_absensis')->insert([
            'member_id' => $memberId,
            'jadwal_id' => $jadwalId,
            'instruktur_id' => $instrukturId,
            'tanggal' => Carbon::now()->toDateString(),
            'status_booking' => 'Booked',
            'status_hadir' => 'Hadir',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}