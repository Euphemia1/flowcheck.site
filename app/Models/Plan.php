<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price_monthly',
        'max_users',
        'max_vendors',
        'features',
    ];

    protected $casts = [
        'features' => 'json',
    ];

    public function organisations(): HasMany
    {
        return $this->hasMany(Organisation::class);
    }
}
