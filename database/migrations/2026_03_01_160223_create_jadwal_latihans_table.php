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
        Schema::create('jadwal_latihans', function (Blueprint $table) {
            $table->id('jadwal_id');
            $table->unsignedBigInteger('instruktur_id');
            $table->string('hari');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->string('jenis_latihan');
            $table->integer('kuota');
            $table->timestamps();

            $table->foreign('instruktur_id')->references('instruktur_id')->on('instrukturs')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_latihans');
    }
};
