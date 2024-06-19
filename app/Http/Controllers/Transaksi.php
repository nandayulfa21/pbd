<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksiModel;
use App\Models\KeranjangModel;
use App\Models\TransaksiModel;
use Illuminate\Http\Request;

class Transaksi extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('transaksi/list');
    }

    public function checkout()
    {
        //
        return view('transaksi/checkout');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data = KeranjangModel::leftJoin('produk', 'produk.id_produk', '=', 'keranjang.id_produk')
            ->selectRaw('sum(produk.harga * keranjang.jumlah_beli) as total')
            ->first();

        $kecamatan = explode('||', $request->get('kecamatan'));
        $provinsi = explode('||', $request->get('provinsi'));
        $kota = explode('||', $request->get('kota'));

        $trans = new TransaksiModel([
            'tgl_transaksi' => date("Y-m-d H:i:s"),
            'total_bayar' => $data->total,
            'nama' => $request->get('nama'),
            'alamat_jalan' => $request->get('alamat_jalan'),
            'kecamatan' => $kecamatan[1],
            'kota' => $kota[1],
            'provinsi' => $provinsi[1],
            'id_user' => 1
        ]);

        $saved = $trans->save();

        $all_detail = KeranjangModel::leftJoin('produk', 'produk.id_produk', '=', 'keranjang.id_produk')
            ->select('keranjang.*', 'produk.nama_produk', 'produk.harga')
            ->get();

        foreach ($all_detail as $value) {
            $detail = new DetailTransaksiModel([
                'id_transaksi' => $trans->id_transaksi,
                'id_produk' => $value->id_produk,
                'harga' => $value->harga,
                'jumlah_beli' => $value->jumlah_beli
            ]);

            $save_detail = $detail->save();
        }

        $keranjang = KeranjangModel::where('id_user', 1)->delete();

        return redirect(url('transaksi'));
    }

    /**
     * Display the specified resource.
     */
    public function show(TransaksiModel $transaksiModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TransaksiModel $transaksiModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TransaksiModel $transaksiModel)
    {
        //
    }

    public function dataDatables(Request $request)
    {
        $search = $request->query('search');
        $order = $request->query('order');

        $tgl_awal = $request->query('tgl_awal');
        $tgl_akhir = $request->query('tgl_akhir');
        $prov = $request->query('prov');
        $min_total = $request->query('min_total');

        switch ($order[0]['column']) {
            case '0':
                $orderby = 'id_transaksi';
                break;

            case '1':
                $orderby = 'tgl_transaksi';
                break;

            case '2':
                $orderby = 'nama';
                break;

            case '3':
                $orderby = 'alamat_jalan';
                break;

            case '4':
                $orderby = 'total_bayar';
                break;

            default:
                $orderby = 'id_transaksi';
                break;
        }

        $data_db_total = TransaksiModel::all();
        $data_db_filtered = TransaksiModel::where('nama', 'like', '%' . $search['value'] . '%');

        if ($tgl_awal != '' && $tgl_awal != null) {
            $data_db_filtered = $data_db_filtered->whereRaw('DATE(tgl_transaksi) >= "' . $tgl_awal . '"');
        }

        if ($tgl_akhir != '' && $tgl_akhir != null) {
            $data_db_filtered = $data_db_filtered->whereRaw('DATE(tgl_transaksi) <= "' . $tgl_akhir . '"');
        }

        if ($prov != '' && $prov != null) {
            $data_db_filtered = $data_db_filtered->where('provinsi', 'like', '%' . $prov . '%');
        }

        if ($min_total != '' && $min_total != null) {
            $data_db_filtered = $data_db_filtered->where('total_bayar', '>=', $min_total);
        }

        $data_db_filtered = $data_db_filtered->get();

        $data_db = TransaksiModel::where('nama', 'like', '%' . $search['value'] . '%');

        if ($tgl_awal != '' && $tgl_awal != null) {
            $data_db = $data_db->whereRaw('DATE(tgl_transaksi) >= "' . $tgl_awal . '"');
        }

        if ($tgl_akhir != '' && $tgl_akhir != null) {
            $data_db = $data_db->whereRaw('DATE(tgl_transaksi) <= "' . $tgl_akhir . '"');
        }

        if ($prov != '' && $prov != null) {
            $data_db = $data_db->where('provinsi', 'like', '%' . $prov . '%');
        }

        if ($min_total != '' && $min_total != null) {
            $data_db = $data_db->where('total_bayar', '>=', $min_total);
        }

        $data_db = $data_db->offset($request->query('start'))
            ->limit($request->query('length'))
            ->orderByRaw($orderby . ' ' . $order[0]['dir'])
            ->get(['transaksi.*']);


        $data_formatted = [];

        foreach ($data_db as $key => $value) {

            $nominal = 'Rp ' . number_format($value->total_bayar);
            $alamat = $value->alamat_jalan . ' ' . $value->kecamatan . ' ' . $value->kota . ' ' . $value->provinsi;
            $tanggal = date("d-M-Y H:i:s", strtotime($value->tgl_transaksi));

            $row_data = [];
            $row_data[] = $key + 1;
            $row_data[] = $tanggal;
            $row_data[] = $value->nama;
            $row_data[] = $alamat;
            $row_data[] = $nominal;

            $data_formatted[] = $row_data;
        }

        $data_json = [
            'draw' => $request->query('draw'),
            'recordsTotal' => count($data_db_total),
            'recordsFiltered' => count($data_db_filtered),
            'data' => $data_formatted
        ];

        return json_encode($data_json);
    }

    public function laporan()
    {
        return view('transaksi/laporan');
    }

    public function laporan_api(Request $request)
    {
        //
        $label = [];
        $data = [];
        $data_1d = [];
        $total = 0;
        $tgl_request_awal = $request->get('tanggal_awal');
        $tgl_request_akhir = $request->get('tanggal_akhir');

        if ($tgl_request_awal == null || $tgl_request_awal == '') {
            $tgl_awal = date("Y-m-d", strtotime("-14 days"));
            $tgl_sekarang = $tgl_awal;
            $tgl_akhir = date("Y-m-d");
        } else {
            $tgl_awal = date("d-M-Y H:i:s", strtotime($tgl_request_awal));
            $tgl_akhir = date("Y-m-d", strtotime($tgl_awal . "+14 days"));
            $tgl_sekarang = $tgl_awal;
        }

        if ($tgl_request_akhir != null && $tgl_request_akhir != '') {
            $tgl_akhir = date("Y-m-d", strtotime($tgl_request_akhir));
        }

        while ($tgl_awal <= $tgl_akhir) {
            $data_db = TransaksiModel::selectRaw('SUM(total_bayar) as total')
                ->whereRaw('DATE(tgl_transaksi) = "' . $tgl_awal . '"')
                ->first();
            $data_1d[] = $data_db->total == null ? 0 : $data_db->total;
            $total += $data_db->total == null ? 0 : $data_db->total;
            $label[] = date("d-M-Y", strtotime($tgl_awal));
            if ($tgl_awal == $tgl_akhir) {
                $data_1d[] = $data_db->total == null ? 0 : $data_db->total;
            }
            $tgl_awal = date("Y-m-d", strtotime($tgl_awal . ' +1 day'));
        }
        $data[] = $data_1d;

        $label_tgl = date("d-M-Y", strtotime($tgl_sekarang)).' s/d '.date("d-M-Y", strtotime($tgl_akhir));
        $data_json = [
            "data" => $data,
            "label" => $label,
            "total" => number_format($total, 0, ',', '.'),
            "tgl_update" => $label_tgl
        ];
        return json_encode($data_json);
    }
}
