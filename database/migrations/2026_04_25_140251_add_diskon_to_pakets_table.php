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
        Schema::table('pakets', function (Blueprint $table) {
            $table->decimal('harga_diskon', 12, 2)->nullable()->after('harga');
            $table->date('tanggal_akhir_diskon')->nullable()->after('harga_diskon');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pakets', function (Blueprint $table) {
            $table->dropColumn(['harga_diskon', 'tanggal_akhir_diskon']);
        });
    }
};
