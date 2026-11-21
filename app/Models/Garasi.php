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
