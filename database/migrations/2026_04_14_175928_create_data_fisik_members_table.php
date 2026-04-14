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
        Schema::create('data_fisik_members', function (Blueprint $table) {
            $table->id('data_fisik_id');
            $table->unsignedInteger('member_id');
            $table->float('tinggi_badan')->nullable()->comment('Dalam cm');
            $table->float('berat_badan')->nullable()->comment('Dalam kg');
            $table->string('target_latihan')->nullable(); // misal: Pembentukan Otot, Penurunan Berat Badan, dll
            $table->date('tanggal_pencatatan')->nullable();
            $table->timestamps();

            // Asumsikan member_id di tabel members tipenya foreign key, bisa pakai contraint jika diperlukan
            // $table->foreign('member_id')->references('member_id')->on('members')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_fisik_members');
    }
};
