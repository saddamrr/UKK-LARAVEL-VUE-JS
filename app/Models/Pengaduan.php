<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    protected $fillable = [
        'id_pengaduan',
        'tgl_pengaduan',
        'id_user',
        'isi_laporan',
        'foto',
        'status'
    ];
    protected $hidden = ['created_at', 'updated_at'];
    protected $table = "pengaduan";
    protected $primaryKey = 'id_pengaduan';

    public function tanggapan() {
        return $this->belongsTo('App\Models\Tanggapan','id_pengaduan','id_pengaduan');
    }
}
