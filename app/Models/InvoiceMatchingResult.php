<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceMatchingResult extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'invoice_id',
        'po_id',
        'grn_id',
        'qty_invoiced',
        'qty_ordered',
        'qty_received',
        'price_invoiced',
        'price_po',
        'qty_match',
        'price_match',
        'notes',
        'checked_at',
    ];

    protected $casts = [
        'qty_invoiced' => 'decimal:2',
        'qty_ordered' => 'decimal:2',
        'qty_received' => 'decimal:2',
        'price_invoiced' => 'decimal:2',
        'price_po' => 'decimal:2',
        'qty_match' => 'boolean',
        'price_match' => 'boolean',
        'checked_at' => 'datetime',
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function purchaseOrder(): BelongsTo
    {
        return $this->belongsTo(PurchaseOrder::class, 'po_id');
    }

    public function grn(): BelongsTo
    {
        return $this->belongsTo(GoodsReceiptNote::class, 'grn_id');
    }
}
