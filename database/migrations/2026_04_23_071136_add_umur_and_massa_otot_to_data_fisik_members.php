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
            $table->integer('umur')->nullable()->after('berat_badan');
            $table->decimal('massa_otot', 5, 2)->nullable()->after('umur'); // in kg for optional input
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_fisik_members', function (Blueprint $table) {
            $table->dropColumn(['umur', 'massa_otot']);
        });
    }
};
