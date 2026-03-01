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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id('pembayaran_id');
            $table->unsignedBigInteger('pemesanan_id');
            $table->unsignedBigInteger('member_id');
            $table->string('order_id')->unique();
            $table->string('transaction_id')->nullable();
            $table->string('metode')->nullable();
            $table->decimal('jumlah', 12, 2);
            $table->enum('status', ['pending', 'settlement', 'expire', 'cancel'])->default('pending');
            $table->string('snap_token')->nullable();
            $table->dateTime('tanggal_bayar')->nullable();
            $table->timestamps();

            $table->foreign('pemesanan_id')->references('pemesanan_id')->on('pemesanan_pakets')->cascadeOnDelete();
            $table->foreign('member_id')->references('member_id')->on('members')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
