<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Produk;
use App\Http\Controllers\Keranjang;
use App\Http\Controllers\Transaksi;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/produk/all', [Produk::class, 'getListProduk']);
Route::get('/produk/kode/{kode}', [Produk::class, 'getByKode']);
Route::post('/produk/input', [Produk::class, 'store']);
Route::put('/produk/input', [Produk::class, 'update']);
Route::delete('/produk/hapus', [Produk::class, 'destroy']);

Route::get('/keranjang/all', [Keranjang::class, 'getList']);
Route::post('/keranjang', [Keranjang::class, 'store']);

Route::get('/produk/dataTable', [Produk::class, 'dataDatables']);
Route::get('/transaksi/dataTable', [Transaksi::class, 'dataDatables']);
