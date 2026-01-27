<?php

use App\Http\Controllers\Api\BarangController;
use App\Http\Controllers\Api\PelangganController;
use App\Http\Controllers\Api\PenjualanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::apiResource('pelanggan', PelangganController::class);

Route::apiResource('barang', BarangController::class);

Route::apiResource('penjualan', PenjualanController::class);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
