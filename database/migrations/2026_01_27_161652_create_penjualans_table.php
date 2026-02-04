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
        Schema::create('penjualan', function (Blueprint $table) {
            $table->string('id_nota', 12)->primary();
            $table->date('tgl');
            $table->string('kode_pelanggan', 12);
            $table->integer('subtotal');
            $table->foreign('kode_pelanggan')
              ->references('id_pelanggan')
              ->on('pelanggan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan');
    }
};
