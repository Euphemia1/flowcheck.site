<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VendorQuote extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'rfq_id',
        'vendor_id',
        'total_amount',
        'line_items',
        'notes',
        'validity_date',
        'is_awarded',
        'awarded_by',
        'awarded_at',
    ];

    protected $casts = [
        'line_items' => 'json',
        'validity_date' => 'date',
        'is_awarded' => 'boolean',
        'awarded_at' => 'datetime',
        'total_amount' => 'decimal:2',
    ];

    public function rfq(): BelongsTo
    {
        return $this->belongsTo(Rfq::class);
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function awardedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'awarded_by');
    }
}
