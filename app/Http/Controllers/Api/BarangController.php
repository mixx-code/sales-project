<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BarangResource;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    //
    public function index()
    {
        //
        $barang = Barang::paginate(10);
        return new BarangResource(
            true,
            'List Data Barang',
            $barang
        );
    }

    public function show($kode)
    {
        //
        $barang = Barang::find($kode);
        return new BarangResource(
            true,
            'Data Barang Ditemukan!',
            $barang
        );
    }

    public function store(Request $request)
    {
        
        $validator = Validator::make(
            $request->all(),
            [
                'kode'      => 'required|string|unique:barang,kode|max:12',
                'nama'      => 'required|string|max:25',
                'kategori'  => 'required|string|max:20',
                'harga'     => 'required|integer',
            ]
        );
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $barang = Barang::create($request->all());
        return new BarangResource(
            true,
            'Data Barang Berhasil Ditambahkan!',
            $barang
        );
    }

    // public function update(Request $request, $kode)
    // {
    //     //
    //     $validator = Validator::make(
    //         $request->all(),
    //         [
    //             'nama'      => 'sometimes|required|string|max:25',
    //             'kategori'  => 'sometimes|required|string|max:20',
    //             'harga'     => 'sometimes|required|integer',
    //         ]
    //     );
    //     if ($validator->fails()) {
    //         return response()->json($validator->errors(), 422);
    //     }
    //     $barang = Barang::where('kode', $kode)->firstOrFail();
    //     // var_dump($barang);
    //     $barang->update($request->only(['nama', 'kategori', 'harga']));
    //     return new BarangResource(
    //         true,
    //         'Data Barang Berhasil Diupdate!',
    //         $barang
    //     );
    // }

    public function update(Request $request, $barang) // Ganti $kode menjadi $barang
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama'      => 'sometimes|required|string|max:25',
                'kategori'  => 'sometimes|required|string|max:20',
                'harga'     => 'sometimes|required|integer',
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Cari barang dengan kode = $barang
        $barang = Barang::where('kode', $barang)->firstOrFail(); // Parameter $barang berisi kode barang
        
        $barang->update($request->only(['nama', 'kategori', 'harga']));

        return response()->json([
            'success' => true,
            'message' => 'Data Barang Berhasil Diupdate!',
            'data' => $barang
        ]);
    }

    public function destroy($kode)
    {
        //
        $barang = Barang::where('kode', $kode)->firstOrFail();
        // var_dump($barang);

        if (!$barang) {
            return new BarangResource(
                false,
                'Data Barang Tidak Ditemukan!',
                null
            );
        }
        $barang->delete();
        return new BarangResource(
            true,
            'Data Barang Berhasil Dihapus!',
            null
        );
    }
}
