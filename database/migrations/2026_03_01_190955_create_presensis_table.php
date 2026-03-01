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
        Schema::create('presensis', function (Blueprint $table) {
            $table->id('presensi_id'); // Primary Key
            // Foreign Key ke tabel members
            $table->unsignedBigInteger('member_id');
            // Foreign Key ke tabel instrukturs
            $table->unsignedBigInteger('instruktur_id');
            $table->timestamp('waktu_presensi');
            $table->timestamps();

            // Relasi agar data integritas terjaga
            $table->foreign('member_id')->references('member_id')->on('members')->onDelete('cascade');
            $table->foreign('instruktur_id')->references('instruktur_id')->on('instrukturs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presensis');
    }
};
