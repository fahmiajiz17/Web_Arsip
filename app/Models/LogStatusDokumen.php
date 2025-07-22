<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogStatusDokumen extends Model
{
    protected $table = 'log_status_dokumen';
    protected $primaryKey = 'id_log_status_dokumen';

    protected $fillable = [
        'nomor_dokumen',
        'verifikasi_arsip',
        'catatan',
        'diproses_oleh',
    ];

    public function arsip()
    {
        return $this->belongsTo(Arsip::class, 'nomor_dokumen', 'nomor_dokumen');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'diproses_oleh');
    }
}
