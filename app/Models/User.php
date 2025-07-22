<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Tambahkan ini
use App\Models\Role; // Tambahkan ini jika belum ada

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_user',
        'username',
        'password',
        'role',
        'foto',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function roles()
    {
        return $this->belongsTo(Role::class, 'role');
    }

    public function arsipDibuat()
    {
        return $this->hasMany(Arsip::class, 'dibuat_oleh');
    }
}
