<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('riwayat_penggunaan_pts', function (Blueprint $table) {
            $table->id('riwayat_id');
            $table->foreignId('member_paket_id')->constrained('member_paket_pts', 'member_paket_id')->onDelete('cascade');
            $table->foreignId('booking_id')->nullable()->constrained('booking_pts', 'booking_id')->onDelete('set null');
            $table->dateTime('waktu_penggunaan');
            $table->integer('urutan_sesi')->nullable();
            $table->string('keterangan')->nullable();
            $table->text('cabang_lokasi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_penggunaan_pts');
    }
};
