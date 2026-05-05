<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vendor extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'organisation_id',
        'name',
        'contact_person',
        'email',
        'phone',
        'address',
        'tax_pin',
        'payment_terms',
        'bank_details',
        'is_approved',
        'performance_score',
    ];

    protected $casts = [
        'bank_details' => 'json',
        'is_approved' => 'boolean',
        'performance_score' => 'decimal:2',
    ];

    public function organisation(): BelongsTo
    {
        return $this->belongsTo(Organisation::class);
    }

    public function purchaseOrders(): HasMany
    {
        return $this->hasMany(PurchaseOrder::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class);
    }
}
