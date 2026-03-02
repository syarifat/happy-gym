<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('instrukturs', function (Blueprint $table) {
            // Menambahkan kolom lokasi_id, boleh null jika ada instruktur pusat/freelance
            $table->unsignedBigInteger('lokasi_id')->nullable()->after('spesialisasi');
            
            // Membuat foreign key yang menyambung ke tabel lokasis
            $table->foreign('lokasi_id')->references('lokasi_id')->on('lokasis')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('instrukturs', function (Blueprint $table) {
            $table->dropForeign(['lokasi_id']);
            $table->dropColumn('lokasi_id');
        });
    }
};