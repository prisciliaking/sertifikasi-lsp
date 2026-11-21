<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use Notifiable;

    public const ROLE_ADMIN = 'admin';
    public const ROLE_PENYEWA = 'penyewa';

    public const STATUS_MENUNGGU = 'menunggu';
    public const STATUS_DITERIMA = 'diterima';
    public const STATUS_DITOLAK = 'ditolak';

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

    // TAMBAHAN 2: Helper method yang reusable untuk cek role & status
    public function isAdmin(): bool
    {
        return $this->role_name === self::ROLE_ADMIN;
    }

    public function isApproved(): bool
    {
        return $this->status_validasi === self::STATUS_DITERIMA;
    }
}