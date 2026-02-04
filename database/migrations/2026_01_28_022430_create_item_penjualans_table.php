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
        Schema::create('item_penjualan', function (Blueprint $table) {
            $table->string('nota', 12);
            $table->string('kode_barang', 12);
            $table->integer('qty');
            $table->primary(['nota', 'kode_barang']);
            
            $table->foreign('nota')
                ->references('id_nota')
                ->on('penjualan');
                
            $table->foreign('kode_barang')
                ->references('kode')
                ->on('barang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_penjualan');
    }
};