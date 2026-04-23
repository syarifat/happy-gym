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
        Schema::table('data_fisik_members', function (Blueprint $table) {
            $table->dropColumn(['target_latihan', 'tanggal_pencatatan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_fisik_members', function (Blueprint $table) {
            $table->string('target_latihan')->nullable();
            $table->date('tanggal_pencatatan')->nullable();
        });
    }
};
