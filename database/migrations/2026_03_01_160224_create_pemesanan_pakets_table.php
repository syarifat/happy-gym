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
        Schema::create('pemesanan_pakets', function (Blueprint $table) {
            $table->id('pemesanan_id');
            $table->unsignedBigInteger('member_id');
            $table->unsignedBigInteger('paket_id');
            $table->unsignedBigInteger('instruktur_id')->nullable();
            $table->enum('status_persetujuan', ['Pending', 'Disetujui', 'Ditolak'])->default('Pending');
            $table->date('tanggal_pesan');
            $table->timestamps();

            $table->foreign('member_id')->references('member_id')->on('members')->cascadeOnDelete();
            $table->foreign('paket_id')->references('paket_id')->on('pakets')->cascadeOnDelete();
            $table->foreign('instruktur_id')->references('instruktur_id')->on('instrukturs')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemesanan_pakets');
    }
};
