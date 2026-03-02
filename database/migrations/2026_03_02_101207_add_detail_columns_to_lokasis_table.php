<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lokasis', function (Blueprint $table) {
            $table->string('kota')->after('nama_cabang')->nullable();
            $table->string('foto')->after('alamat')->nullable();
            $table->text('deskripsi')->after('foto')->nullable();
            $table->text('jam_buka')->after('deskripsi')->nullable();
            $table->text('fasilitas_klub')->after('jam_buka')->nullable();
            $table->text('alat_gym')->after('fasilitas_klub')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('lokasis', function (Blueprint $table) {
            $table->dropColumn(['kota', 'foto', 'deskripsi', 'jam_buka', 'fasilitas_klub', 'alat_gym']);
        });
    }
};