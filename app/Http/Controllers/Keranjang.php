<?php

namespace App\Http\Controllers;

use App\Models\KeranjangModel;
use Illuminate\Http\Request;

class Keranjang extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('keranjang/list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_produk' => 'required',
        ]);

        $id_produk = $request->get('id_produk');

        $cek_produk_di_keranjang = KeranjangModel::where('id_produk', $id_produk)->first();

        if($cek_produk_di_keranjang == null) {
            $keranjang = new KeranjangModel([
                'id_produk' => $id_produk,
                'jumlah_beli' => 1,
                'id_user' => 1,
            ]);
        } else {
            $keranjang = KeranjangModel::find($cek_produk_di_keranjang->id_keranjang);
            $keranjang->jumlah_beli = $cek_produk_di_keranjang->jumlah_beli+1;
        }

        $saved = $keranjang->save();

        if(!$saved){
            $data_json = [
                'pesan' => 'Gagal Menambah Data Ke Keranjang',
                'produk' => $keranjang,
            ];
        } else {
            $data_json = [
                'pesan' => 'Sukses Menambahkan Ke Keranjang',
                'produk' => $keranjang,
            ];
        }

        return json_encode($data_json);
    }

    /**
     * Display the specified resource.
     */
    public function show(KeranjangModel $keranjangModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KeranjangModel $keranjangModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KeranjangModel $keranjangModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KeranjangModel $keranjangModel)
    {
        //
    }

    public function getList(KeranjangModel $keranjangModel)
    {
        $data = $keranjangModel::leftJoin('produk', 'produk.id_produk', '=', 'keranjang.id_produk')
        ->select('keranjang.*', 'produk.nama_produk', 'produk.harga')
        ->get();

        return json_encode($data);
    }
}
