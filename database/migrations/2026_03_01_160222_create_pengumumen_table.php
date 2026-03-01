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
        Schema::create('pengumumans', function (Blueprint $table) {
            $table->id('pengumuman_id');
            $table->unsignedBigInteger('admin_id');
            $table->string('judul');
            $table->text('deskripsi');
            $table->string('foto')->nullable();
            $table->date('tanggal_post');
            $table->timestamps();

            $table->foreign('admin_id')->references('admin_id')->on('admins')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengumumen');
    }
};
