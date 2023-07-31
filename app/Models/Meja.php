<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meja extends Model
{
    use HasFactory;
    protected $table = 'mejas';
    protected $fillable = ['id_meja', 'nomor_meja', 'status', 'created_at', 'updated_at'];
    protected $primarykey = 'id_meja';
}
