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
        Schema::create('members', function (Blueprint $table) {
            $table->id('member_id');
            $table->string('nama');
            $table->string('email')->unique(); // Login khusus Member
            $table->string('password');
            $table->string('no_hp')->nullable();
            $table->enum('status_membership', ['Aktif', 'Tidak Aktif'])->default('Tidak Aktif');
            $table->date('tanggal_mulai_member')->nullable();
            $table->date('tanggal_berakhir_member')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
