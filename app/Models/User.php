<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'nik';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'nik',
        'nama_lengkap',
        'no_hp',
        'email',
        'password',
        'status_validasi',
        'role_name',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(UtilityRole::class, 'role_name', 'role_name');
    }

    public function kendaraan(): HasMany
    {
        return $this->hasMany(Kendaraan::class, 'nik', 'nik');
    }

    public function sewaGarasi(): HasMany
    {
        return $this->hasMany(SewaGarasi::class, 'nik', 'nik');
    }

    public function perpanjanganDiproses(): HasMany
    {
        return $this->hasMany(PerpanjanganSewa::class, 'admin_nik', 'nik');
    }
}
