<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jenis extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'jenis';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = 
        ['nama',
        'kode_kategori'];

    /**
     * Relasi Arsip
     */

}
