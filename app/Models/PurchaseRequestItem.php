<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseRequestItem extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'purchase_request_id',
        'description',
        'unit_of_measure',
        'quantity_requested',
        'unit_price_estimated',
        'total_estimated',
        'category',
        'notes',
    ];

    protected $casts = [
        'quantity_requested' => 'decimal:2',
        'unit_price_estimated' => 'decimal:2',
        'total_estimated' => 'decimal:2',
    ];

    public function purchaseRequest(): BelongsTo
    {
        return $this->belongsTo(PurchaseRequest::class);
    }
}
