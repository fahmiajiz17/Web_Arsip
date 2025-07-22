<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Klasifikasi extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "klasifikasi";
    protected $primaryKey = 'id_klasifikasi';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kode_klasifikasi',
        'jenis_dokumen',
        'klasifikasi_keamanan',
        'hak_akses',
        'akses_publik',
        'retensi_aktif',
        'retensi_inaktif',
        'retensi_keterangan',
        'unit_pengolah',
    ];

    public function arsip()
    {
        return $this->hasMany(Arsip::class, 'id_klasifikasi', 'klasifikasi');
    }
}
