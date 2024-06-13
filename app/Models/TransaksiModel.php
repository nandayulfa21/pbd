<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiModel extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';
    public $timestamps = false;

    protected $fillable = [
    	'tgl_transaksi', 'total_bayar', 'nama', 'alamat_jalan', 'kecamatan', 'kota', 'provinsi', 'id_user'
    ];
}
