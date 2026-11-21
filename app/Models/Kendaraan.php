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

    public const TIPE_SEPEDA = 'sepeda';
    public const TIPE_SEPEDA_MOTOR = 'sepeda motor';
    public const TIPE_MOBIL = 'mobil';
    public const TIPE_MOBIL_LISTRIK = 'mobil listrik';

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

    /**
     * Mengembalikan daftar tipe garasi yang diizinkan untuk suatu tipe kendaraan.
     */
    public static function allowedTipeGarasi(string $tipeKendaraan): array
    {
        return match ($tipeKendaraan) {
            self::TIPE_SEPEDA, self::TIPE_SEPEDA_MOTOR => [Garasi::TIPE_SEPEDA],
            self::TIPE_MOBIL => [Garasi::TIPE_MOBIL],
            self::TIPE_MOBIL_LISTRIK => [Garasi::TIPE_MOBIL, Garasi::TIPE_MOBIL_LISTRIK],
            default => [],
        };
    }
}
