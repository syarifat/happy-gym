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
        Schema::table('members', function (Blueprint $table) {
            // Kita buat nullable() agar data member lama tidak error
            $table->unsignedBigInteger('lokasi_id')->nullable()->after('status_membership');
            
            // (Opsional) Jika tabel cabang Anda bernama 'lokasis' dan primary key-nya 'lokasi_id'
            // Silakan hapus tanda // di bawah ini untuk mengaktifkan Foreign Key
            // $table->foreign('lokasi_id')->references('lokasi_id')->on('lokasis')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            // $table->dropForeign(['lokasi_id']); // Buka komen jika foreign key diaktifkan
            $table->dropColumn('lokasi_id');
        });
    }
};