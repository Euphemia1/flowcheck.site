<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BoqItem extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'boq_items';

    protected $fillable = [
        'boq_id',
        'item_code',
        'description',
        'unit',
        'quantity',
        'unit_rate',
        'amount',
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'unit_rate' => 'decimal:2',
        'amount' => 'decimal:2',
    ];

    public function boq(): BelongsTo
    {
        return $this->belongsTo(Boq::class);
    }
}
