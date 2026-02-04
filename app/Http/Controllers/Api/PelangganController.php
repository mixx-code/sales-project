<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PelangganResource;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PelangganController extends Controller
{
    //
    public function index()
    {
        //get all pelanggan
        $pelanggan = Pelanggan::paginate(10);

        return new PelangganResource(
            true,
            'List Data Pelanggan',
            $pelanggan
        );
    }

    public function show($id_pelanggan)
    {
        //find pelanggan by ID
        $pelanggan = Pelanggan::find($id_pelanggan);

        //return single pelanggan as a resource
        return new PelangganResource(
            true,
            'Data Pelanggan Ditemukan!',
            $pelanggan
        );
    }

    public function store(Request $request)
    {
        //validate incoming request
        $validator = Validator::make(
            $request->all(),
            [
                'id_pelanggan'  => 'required|string|unique:pelanggan,id_pelanggan|max:12',
                'nama'          => 'required|string|max:35',
                'domisili'      => 'required|string|max:25',
                'jenis_kelamin' => 'required|string|max:10',
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create pelanggan
        $pelanggan = Pelanggan::create($request->all());

        //return response
        return new PelangganResource(
            true,
            'Data Pelanggan Berhasil Ditambahkan!',
            $pelanggan
        );
    }

    public function update(Request $request, $id_pelanggan)
    {
        //find pelanggan
        $pelanggan = Pelanggan::where('id_pelanggan', $id_pelanggan)->firstOrFail();

        //validate incoming request
        $validator = Validator::make(
            $request->all(),
            [
                'nama'          => 'sometimes|required|string|max:35',
                'domisili'      => 'sometimes|required|string|max:25',
                'jenis_kelamin' => 'sometimes|required|string|max:10',
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //update pelanggan
        $pelanggan->update($request->only(['nama', 'domisili', 'jenis_kelamin']));

        //return response
        return new PelangganResource(
            true,
            'Data Pelanggan Berhasil Diupdate!',
            $pelanggan
        );
    }

    public function destroy($id_pelanggan)
    {
        //find pelanggan by ID
        $pelanggan = Pelanggan::where('id_pelanggan', $id_pelanggan)->firstOrFail();

        //check if pelanggan not found
        if (!$pelanggan) {
            return new PelangganResource(
                false,
                'Data Pelanggan Tidak Ditemukan!',
                null
            );
        }

        //delete pelanggan
        $pelanggan->delete();

        //return response
        return new PelangganResource(
            true,
            'Data Pelanggan Berhasil Dihapus!',
            null
        );
    }
}
