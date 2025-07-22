<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PanduanPenggunaan extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'panduan_penggunaan';
    protected $primaryKey = 'id_panduan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_dokumen',
        'dokumen_panduan'
    ];
    protected $casts = [
    'dokumen_panduan' => 'array',
];
}
