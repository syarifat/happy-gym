<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('member_paket_pts', function (Blueprint $table) {
            // Menambahkan kolom instruktur_id (Boleh kosong di awal saat baru beli)
            $table->unsignedBigInteger('instruktur_id')->nullable()->after('paket_id');
        });
    }

    public function down(): void
    {
        Schema::table('member_paket_pts', function (Blueprint $table) {
            $table->dropColumn('instruktur_id');
        });
    }
};
