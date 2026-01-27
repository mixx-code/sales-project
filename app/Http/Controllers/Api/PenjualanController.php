<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PenjualanResource;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PenjualanController extends Controller
{
    public function index()
    {
        $penjualan = Penjualan::paginate(10);
        return new PenjualanResource(
            true,
            'List Data Penjualan',
            $penjualan
        );
    }

    public function show($id_nota)
    {
        $penjualan = Penjualan::find($id_nota);
        return new PenjualanResource(
            true,
            'Data Penjualan Ditemukan!',
            $penjualan
        );
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'id_nota'        => 'required|string|unique:penjualan,id_nota|max:12',
                'tgl'           => 'required|date',
                'kode_pelanggan'=> 'required|string|max:12',
                'subtotal'      => 'required|integer',
            ]
        );

        if ($validator->fails()) {
            return new PenjualanResource(
                false,
                'Validation Error',
                $validator->errors()
            );
        }
        $penjualan = Penjualan::create($request->all());
        return new PenjualanResource(
            true,
            'Data Penjualan Berhasil Ditambahkan!',
            $penjualan
        );
    }

    public function update(Request $request, $id_nota)
    {
        $penjualan = Penjualan::find($id_nota);
        if (!$penjualan) {
            return new PenjualanResource(
                false,
                'Data Penjualan Tidak Ditemukan!',
                null
            );
        }
        $validator = Validator::make(
            $request->all(),
            [
                'tgl'           => 'sometimes|required|date',
                'kode_pelanggan'=> 'sometimes|required|string|max:12',
                'subtotal'      => 'sometimes|required|integer',
            ]
        );

        if ($validator->fails()) {
            return new PenjualanResource(
                false,
                'Validation Error',
                $validator->errors()
            );
        }
        $penjualan->update($request->all());
        return new PenjualanResource(
            true,
            'Data Penjualan Berhasil Diupdate!',
            $penjualan
        );
    }

    public function destroy($id_nota)
    {
        $penjualan = Penjualan::find($id_nota);
        if (!$penjualan) {
            return new PenjualanResource(
                false,
                'Data Penjualan Tidak Ditemukan!',
                null
            );
        }
        $penjualan->delete();
        return new PenjualanResource(
            true,
            'Data Penjualan Berhasil Dihapus!',
            null
        );
    }
}
