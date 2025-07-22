<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profil extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'profil';
    protected $primaryKey = 'id_profil';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_aplikasi',
        'kepanjangan_aplikasi',
        'nama_copyright',
        'logo_kerjasama',
        'logo_instansi',
    ];
}
