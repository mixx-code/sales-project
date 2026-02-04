<?php

use App\Http\Controllers\Api\BarangController;
use App\Http\Controllers\Api\ItemPenjualanController;
use App\Http\Controllers\Api\PelangganController;
use App\Http\Controllers\Api\PenjualanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::apiResource('pelanggan', PelangganController::class);

Route::apiResource('barang', BarangController::class);

Route::apiResource('penjualan', PenjualanController::class);

// Custom routes for item_penjualan with composite key
Route::get('/item_penjualan', [ItemPenjualanController::class, 'index']);
Route::post('/item_penjualan', [ItemPenjualanController::class, 'store']);
Route::get('/item_penjualan/{nota}/{kode_barang}', [ItemPenjualanController::class, 'show']);
Route::put('/item_penjualan/{nota}/{kode_barang}', [ItemPenjualanController::class, 'update']);
Route::delete('/item_penjualan/{nota}/{kode_barang}', [ItemPenjualanController::class, 'destroy']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
