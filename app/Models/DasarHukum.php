<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DasarHukum extends Model
{
    use HasFactory;

    protected $table = "dasar_hukum";
    protected $primaryKey = "id_dasar_hukum";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_dasar_hukum',
        'dokumen_dasar_hukum',
    ];

    public function arsip()
    {
        return $this->hasMany(Arsip::class, 'id_dasar_hukum', 'dasar_hukum');
    }
}
