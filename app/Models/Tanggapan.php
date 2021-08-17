<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tanggapan extends Model
{
    protected $fillable = [
        'id_tanggapan',
        'id_pengaduan',
        'tgl_tanggapan',
        'tanggapan',
        'id_petugas'
    ];
    protected $hidden = ['created_at', 'updated_at'];
    protected $table = "tanggapan";
    protected $primaryKey = 'id_tanggapan';
}
