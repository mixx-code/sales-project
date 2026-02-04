<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ItemPenjualanResource;
use App\Models\ItemPenjualan;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Barang;
use App\Models\Pelanggan;

class ItemPenjualanController extends Controller
{
    public function index()
    {
        $itemPenjualan = ItemPenjualan::with(['penjualan', 'barang'])->paginate(10);
        return new ItemPenjualanResource(
            true,
            'List Data Item Penjualan',
            $itemPenjualan
        );
    }

    public function show($nota, $kode_barang)
    {
        $itemPenjualan = ItemPenjualan::with(['penjualan', 'barang'])
            ->where('nota', $nota)
            ->where('kode_barang', $kode_barang)
            ->first();
            
        if (!$itemPenjualan) {
            return response()->json([
                'success' => false,
                'message' => 'Data Item Penjualan Tidak Ditemukan!'
            ], 404);
        }
        
        return new ItemPenjualanResource(
            true,
            'Data Item Penjualan Ditemukan!',
            $itemPenjualan
        );
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nota'          => 'required|string|exists:penjualan,id_nota|max:12',
                'kode_barang'   => 'required|string|exists:barang,kode|max:12',
                'qty'           => 'required|integer|min:1',
            ]
        );
        
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        
        $itemPenjualan = ItemPenjualan::create($request->all());
        
        // Update subtotal otomatis
        $penjualan = Penjualan::find($request->nota);
        $penjualan->updateSubtotal();
        
        return new ItemPenjualanResource(
            true,
            'Data Item Penjualan Berhasil Ditambahkan!',
            $itemPenjualan->load(['penjualan', 'barang'])
        );
    }

    public function update(Request $request, $nota, $kode_barang)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'qty' => 'sometimes|required|integer|min:1',
            ]
        );
        
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        
        // Cari item dengan composite key menggunakan query manual
        $itemPenjualan = ItemPenjualan::where('nota', $nota)
            ->where('kode_barang', $kode_barang)
            ->first();
            
        if (!$itemPenjualan) {
            return response()->json([
                'success' => false,
                'message' => 'Data Item Penjualan Tidak Ditemukan!'
            ], 404);
        }
        
        // Update menggunakan query manual untuk menghindari issue composite key
        ItemPenjualan::where('nota', $nota)
            ->where('kode_barang', $kode_barang)
            ->update(['qty' => $request->qty]);
        
        // Update subtotal otomatis
        $penjualan = Penjualan::find($nota);
        $penjualan->updateSubtotal();
        
        // Ambil data yang sudah diupdate
        $updatedItem = ItemPenjualan::with(['penjualan', 'barang'])
            ->where('nota', $nota)
            ->where('kode_barang', $kode_barang)
            ->first();
        
        return new ItemPenjualanResource(
            true,
            'Data Item Penjualan Berhasil Diupdate!',
            $updatedItem
        );
    }

    public function destroy($nota, $kode_barang)
    {
        // Cari item dengan composite key menggunakan query manual
        $itemPenjualan = ItemPenjualan::where('nota', $nota)
            ->where('kode_barang', $kode_barang)
            ->first();
            
        if (!$itemPenjualan) {
            return response()->json([
                'success' => false,
                'message' => 'Data Item Penjualan Tidak Ditemukan!'
            ], 404);
        }
        
        // Hapus menggunakan query manual
        ItemPenjualan::where('nota', $nota)
            ->where('kode_barang', $kode_barang)
            ->delete();
        
        // Update subtotal otomatis
        $penjualan = Penjualan::find($nota);
        $penjualan->updateSubtotal();
        
        return new ItemPenjualanResource(
            true,
            'Data Item Penjualan Berhasil Dihapus!',
            null
        );
    }
}
