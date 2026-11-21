<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PerpanjanganSewa extends Model
{
    protected $table = 'perpanjangan_sewa';
    protected $primaryKey = 'perpanjangan_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'perpanjangan_id',
        'sewa_id',
        'tanggal_selesai_lama',
        'tanggal_selesai_baru',
        'biaya_tambahan',
        'bukti_bayar',
        'admin_nik',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_selesai_lama' => 'datetime',
            'tanggal_selesai_baru' => 'datetime',
            'biaya_tambahan' => 'decimal:2',
        ];
    }

    public function sewaGarasi(): BelongsTo
    {
        return $this->belongsTo(SewaGarasi::class, 'sewa_id', 'sewa_id');
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_nik', 'nik');
    }
}
