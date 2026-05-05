<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GoodsReceiptNote extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'goods_receipt_notes';

    protected $fillable = [
        'organisation_id',
        'purchase_order_id',
        'grn_number',
        'received_by',
        'received_at',
        'status',
        'notes',
        'attachments',
    ];

    protected $casts = [
        'received_at' => 'datetime',
        'attachments' => 'json',
    ];

    public function organisation(): BelongsTo
    {
        return $this->belongsTo(Organisation::class);
    }

    public function purchaseOrder(): BelongsTo
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    public function receivedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'received_by');
    }

    public function items(): HasMany
    {
        return $this->hasMany(GrnItem::class);
    }

    public function invoiceMatching(): HasMany
    {
        return $this->hasMany(InvoiceMatchingResult::class);
    }
}
