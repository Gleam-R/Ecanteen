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
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('makanan_id')->constrained('makanan');
            $table->integer('jumlah');
            $table->decimal('total_harga', 10, 2);
            $table->enum('metode_pembayaran',['cod','qris'])->default('cod'); //defaultnya adalah COD (CALL OF DOODIES)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
