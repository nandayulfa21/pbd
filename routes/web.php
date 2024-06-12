<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Produk;
use App\Http\Controllers\Keranjang;
use App\Http\Controllers\Transaksi;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [Produk::class, 'index']);
Route::get('/produk', [Produk::class, 'index']);
Route::get('/produk/form', [Produk::class, 'create']);
Route::get('/produk/form/{id}', [Produk::class, 'edit']);
Route::get('/keranjang', [Keranjang::class, 'index']);

Route::get('/checkout', [Transaksi::class, 'checkout']);
Route::post('/checkout', [Transaksi::class, 'store']);

Route::get('/transaksi', [Transaksi::class, 'index']);
