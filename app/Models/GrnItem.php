<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GrnItem extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'grn_items';

    protected $fillable = [
        'grn_id',
        'po_item_id',
        'quantity_received',
        'condition',
        'notes',
    ];

    protected $casts = [
        'quantity_received' => 'decimal:2',
    ];

    public function grn(): BelongsTo
    {
        return $this->belongsTo(GoodsReceiptNote::class, 'grn_id');
    }

    public function poItem(): BelongsTo
    {
        return $this->belongsTo(PurchaseOrderItem::class, 'po_item_id');
    }
}
