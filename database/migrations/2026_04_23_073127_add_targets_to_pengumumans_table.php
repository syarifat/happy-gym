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
        Schema::table('pengumumans', function (Blueprint $table) {
            $table->boolean('tampil_web')->default(true);
            $table->boolean('tampil_member')->default(true);
            $table->boolean('tampil_instruktur')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengumumans', function (Blueprint $table) {
            $table->dropColumn(['tampil_web', 'tampil_member', 'tampil_instruktur']);
        });
    }
};
