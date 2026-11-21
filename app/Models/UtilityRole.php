<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UtilityRole extends Model
{
    protected $table = 'utility_role';
    protected $primaryKey = 'role_name';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['role_name'];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'role_name', 'role_name');
    }
}