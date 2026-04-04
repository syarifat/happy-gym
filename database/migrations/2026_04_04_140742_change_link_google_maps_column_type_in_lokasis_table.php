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
        Schema::table('lokasis', function (Blueprint $table) {
            // Mengubah tipe kolom menjadi TEXT
            $table->text('link_google_maps')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lokasis', function (Blueprint $table) {
            // Mengembalikan ke VARCHAR(255) jika migrasi di-rollback
            $table->string('link_google_maps', 255)->change();
        });
    }
};