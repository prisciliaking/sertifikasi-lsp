<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kendaraan extends Model
{
    protected $table = 'kendaraan';
    protected $primaryKey = 'kendaraan_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kendaraan_id',
        'tipe_kendaraan',
        'kapasitas_baterai',
        'plat_nomor',
        'merek_kendaraan',
        'model_merek',
        'nik',
    ];

    protected function casts(): array
    {
        return [
            'kapasitas_baterai' => 'decimal:2',
        ];
    }

    public function pemilik(): BelongsTo
    {
        return $this->belongsTo(User::class, 'nik', 'nik');
    }

    public function sewaGarasi(): HasMany
    {
        return $this->hasMany(SewaGarasi::class, 'kendaraan_id', 'kendaraan_id');
    }
}
