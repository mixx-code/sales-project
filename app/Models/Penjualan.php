<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Penjualan extends Model
{
    protected $table = 'penjualan';
    protected $primaryKey = 'id_nota';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        'id_nota',
        'tgl',
        'kode_pelanggan',
        'subtotal',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'kode_pelanggan', 'id_pelanggan');
    }

    public function itemPenjualan()
    {
        return $this->hasMany(ItemPenjualan::class, 'nota', 'id_nota');
    }

    public function updateSubtotal()
    {
        $subtotal = $this->itemPenjualan()
            ->join('barang', 'item_penjualan.kode_barang', '=', 'barang.kode')
            ->where('item_penjualan.nota', $this->id_nota)
            ->sum(DB::raw('barang.harga * item_penjualan.qty'));
            
        $this->update(['subtotal' => $subtotal]);
    }
}
