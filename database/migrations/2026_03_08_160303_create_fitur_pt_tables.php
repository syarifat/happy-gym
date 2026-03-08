<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Modifikasi tabel pakets (Tambah jenis paket dan jumlah sesi)
        Schema::table('pakets', function (Blueprint $table) {
            // Membedakan ini paket Gym biasa atau Personal Trainer
            $table->enum('jenis_paket', ['Membership', 'Personal Trainer'])->default('Membership')->after('nama_paket');
            // Jumlah sesi untuk paket PT (misal: 8, 12, 16)
            $table->integer('jumlah_sesi')->nullable()->after('harga');
        });

        // 2. Buat tabel khusus untuk melacak Sisa Sesi PT milik Member
        Schema::create('member_paket_pts', function (Blueprint $table) {
            $table->id('member_paket_id');
            $table->unsignedBigInteger('member_id'); // Relasi ke tabel members
            $table->unsignedBigInteger('paket_id');  // Relasi ke tabel pakets
            $table->integer('sisa_sesi');            // Berkurang tiap scan QR
            $table->date('expired_date');            // Masa aktif paket PT
            $table->enum('status', ['Aktif', 'Habis', 'Expired'])->default('Aktif');
            $table->timestamps();

            // Opsional: Jika Anda sudah set foreign key constraint sebelumnya
            // $table->foreign('member_id')->references('member_id')->on('members')->onDelete('cascade');
            // $table->foreign('paket_id')->references('paket_id')->on('pakets')->onDelete('cascade');
        });

        // 3. Buat tabel Ketersediaan Instruktur (Jadwal Kosong yang diinput Instruktur)
        Schema::create('ketersediaan_instrukturs', function (Blueprint $table) {
            $table->id('ketersediaan_id');
            $table->unsignedBigInteger('instruktur_id'); // Relasi ke tabel instrukturs
            $table->date('tanggal');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->boolean('is_booked')->default(false); // Berubah true jika dibooking member
            $table->timestamps();
        });

        // 4. Buat tabel Booking Sesi (Saat member pilih jadwal instruktur)
        Schema::create('booking_pts', function (Blueprint $table) {
            $table->id('booking_id');
            $table->unsignedBigInteger('member_paket_id'); // Ngambil dari paket PT member
            $table->unsignedBigInteger('ketersediaan_id'); // Ngambil slot jam instruktur
            
            // Status Booking untuk mengakomodasi Reschedule dan Hadir
            $table->enum('status', ['Booked', 'Hadir', 'Batal', 'Reschedule'])->default('Booked');
            
            $table->dateTime('waktu_scan_qr')->nullable(); // Bukti waktu validasi QR
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_pts');
        Schema::dropIfExists('ketersediaan_instrukturs');
        Schema::dropIfExists('member_paket_pts');
        
        Schema::table('pakets', function (Blueprint $table) {
            $table->dropColumn(['jenis_paket', 'jumlah_sesi']);
        });
    }
};