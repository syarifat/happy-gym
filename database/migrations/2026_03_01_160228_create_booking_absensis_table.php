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
        Schema::create('booking_absensis', function (Blueprint $table) {
            $table->id('booking_id');
            $table->unsignedBigInteger('member_id');
            $table->unsignedBigInteger('jadwal_id');
            $table->unsignedBigInteger('instruktur_id');
            $table->date('tanggal');
            $table->enum('status_booking', ['Booked', 'Batal'])->default('Booked');
            $table->enum('status_hadir', ['Belum Absen', 'Hadir', 'Tidak Hadir'])->default('Belum Absen');
            $table->timestamps();

            $table->foreign('member_id')->references('member_id')->on('members')->cascadeOnDelete();
            $table->foreign('jadwal_id')->references('jadwal_id')->on('jadwal_latihans')->cascadeOnDelete();
            $table->foreign('instruktur_id')->references('instruktur_id')->on('instrukturs')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_absensis');
    }
};
