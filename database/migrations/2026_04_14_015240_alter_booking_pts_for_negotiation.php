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
        Schema::table('booking_pts', function (Blueprint $table) {
            // Drop foreign key atau hapus kolom lama
            $table->dropColumn('ketersediaan_id');
            
            // Tambah kolom baru untuk sistem request & negotiation
            $table->unsignedBigInteger('instruktur_id')->nullable()->after('member_paket_id');
            $table->date('tanggal_sesi')->nullable()->after('instruktur_id');
            $table->time('jam_sesi')->nullable()->after('tanggal_sesi');
            
            // Kolom untuk negosiasi
            $table->text('alasan_penolakan')->nullable()->after('status');
            $table->date('saran_tanggal')->nullable()->after('alasan_penolakan');
            $table->time('saran_jam')->nullable()->after('saran_tanggal');
        });

        // Karena enum sulit diubah via migrate di SQLite/MySQL secara langsung tanpa doctrine/dbal,
        // kita ubah strukturnya menjadi string atau biarkan.
        // Sebaiknya kita drop kolom status dan buat lagi sebagai string (untuk kemudahan enum).
        Schema::table('booking_pts', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        Schema::table('booking_pts', function (Blueprint $table) {
            $table->string('status', 50)->default('Pending')->after('jam_sesi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('booking_pts', function (Blueprint $table) {
            $table->unsignedBigInteger('ketersediaan_id')->nullable();
            
            $table->dropColumn('instruktur_id');
            $table->dropColumn('tanggal_sesi');
            $table->dropColumn('jam_sesi');
            $table->dropColumn('alasan_penolakan');
            $table->dropColumn('saran_tanggal');
            $table->dropColumn('saran_jam');
        });
    }
};
