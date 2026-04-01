<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kunjungan_gyms', function (Blueprint $table) {
            $table->id('kunjungan_id');
            $table->unsignedBigInteger('member_id');
            $table->unsignedBigInteger('lokasi_id');
            $table->date('tanggal');
            $table->time('waktu_masuk')->nullable();
            $table->time('waktu_keluar')->nullable();
            $table->string('status_kunjungan')->default('Masuk'); // 'Masuk' atau 'Selesai'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kunjungan_gyms');
    }
};
