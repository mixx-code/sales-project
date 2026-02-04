<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemPenjualan extends Model
{
    protected $table = 'item_penjualan';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        'nota',
        'kode_barang',
        'qty',
    ];

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'nota', 'id_nota');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'kode_barang', 'kode');
    }
}
