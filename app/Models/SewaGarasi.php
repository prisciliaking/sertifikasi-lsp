<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SewaGarasi extends Model
{
    protected $table = 'sewa_garasi';
    protected $primaryKey = 'sewa_id';
    public $incrementing = false;
    protected $keyType = 'string';

    public const TIPE_HARIAN = 'harian';
    public const TIPE_BULANAN = 'bulanan';
    public const MULTIPLIER_BULANAN = 25;

    protected $fillable = [
        'sewa_id',
        'nik',
        'kendaraan_id',
        'garasi_id',
        'tipe_sewa',
        'tanggal_mulai',
        'tanggal_selesai',
        'sisa_baterai_awal',
        'biaya_sewa',
        'biaya_listrik',
        'total_biaya',
        'bukti_bayar',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_mulai' => 'datetime',
            'tanggal_selesai' => 'datetime',
            'sisa_baterai_awal' => 'decimal:2',
            'biaya_sewa' => 'decimal:2',
            'biaya_listrik' => 'decimal:2',
            'total_biaya' => 'decimal:2',
        ];
    }

    public function penyewa(): BelongsTo
    {
        return $this->belongsTo(User::class, 'nik', 'nik');
    }

    public function kendaraan(): BelongsTo
    {
        return $this->belongsTo(Kendaraan::class, 'kendaraan_id', 'kendaraan_id');
    }

    public function garasi(): BelongsTo
    {
        return $this->belongsTo(Garasi::class, 'garasi_id', 'garasi_id');
    }

    public function perpanjangan(): HasMany
    {
        return $this->hasMany(PerpanjanganSewa::class, 'sewa_id', 'sewa_id');
    }
}
