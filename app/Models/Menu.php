<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $table = 'menus';
    protected $primarykey = 'id_menu';
    protected $fillable = ['nama','jenis','foto','harga','jumlah_pesan','created_at','updated_at'];
}
