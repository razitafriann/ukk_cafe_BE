<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $table = 'transaksis';
    protected $primarykey = 'id_transaksi';
    protected $fillable = ['id_pelayanan', 'id_user', 'id_menu', 'id_meja', 'nama_pelanggan', 'tanggal_pesan','total_pesanan','status','total_harga', 'created_at', 'updated_at'];
}
