<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; // tambahkan ini

class Role extends Model
{
    use HasFactory;

    protected $table = 'role';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'nama'
    ];

    public function user(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
