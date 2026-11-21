<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Garasi extends Model
{
    protected $table = 'garasi';
    protected $primaryKey = 'garasi_id';
    public $incrementing = false;
    protected $keyType = 'string';

    public const TIPE_SEPEDA = 'sepeda';
    public const TIPE_MOBIL = 'mobil';
    public const TIPE_MOBIL_LISTRIK = 'mobil listrik';

    public const MAX_UNIT_PER_TIPE = 999;

    public const PREFIX_MAP = [
        self::TIPE_SEPEDA => 'S',
        self::TIPE_MOBIL => 'C',
        self::TIPE_MOBIL_LISTRIK => 'E',
    ];

    protected $fillable = [
        'garasi_id',
        'tipe_garasi',
        'harga_sewa',
        'harga_per_kwh',
        'status_sewa',
    ];

    protected function casts(): array
    {
        return [
            'harga_sewa' => 'decimal:2',
            'harga_per_kwh' => 'decimal:2',
            'status_sewa' => 'boolean',
        ];
    }

    public function sewaGarasi(): HasMany
    {
        return $this->hasMany(SewaGarasi::class, 'garasi_id', 'garasi_id');
    }
}
