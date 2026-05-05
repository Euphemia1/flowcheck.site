<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Rfq extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'rfqs';

    protected $fillable = [
        'organisation_id',
        'purchase_request_id',
        'rfq_number',
        'title',
        'description',
        'deadline',
        'status',
        'created_by',
    ];

    protected $casts = [
        'deadline' => 'datetime',
    ];

    public function organisation(): BelongsTo
    {
        return $this->belongsTo(Organisation::class);
    }

    public function purchaseRequest(): BelongsTo
    {
        return $this->belongsTo(PurchaseRequest::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function vendors(): BelongsToMany
    {
        return $this->belongsToMany(Vendor::class, 'rfq_vendors')
            ->withPivot('sent_at', 'responded_at', 'response_file_path')
            ->withTimestamps();
    }

    public function quotes(): HasMany
    {
        return $this->hasMany(VendorQuote::class);
    }
}
