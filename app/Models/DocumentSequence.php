<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentSequence extends Model
{
    use HasFactory;

    protected $table = 'document_sequences';
    protected $primaryKey = 'organisation_id';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [
        'organisation_id',
        'pr_sequence',
        'po_sequence',
        'rfq_sequence',
        'grn_sequence',
        'invoice_sequence',
        'boq_sequence',
        'tender_sequence',
        'contract_sequence',
    ];

    public function organisation(): BelongsTo
    {
        return $this->belongsTo(Organisation::class);
    }
}
