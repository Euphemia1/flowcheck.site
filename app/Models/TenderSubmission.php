<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TenderSubmission extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'tender_id',
        'vendor_id',
        'submitted_at',
        'technical_score',
        'financial_score',
        'total_score',
        'document_paths',
        'is_awarded',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'technical_score' => 'decimal:2',
        'financial_score' => 'decimal:2',
        'total_score' => 'decimal:2',
        'document_paths' => 'json',
        'is_awarded' => 'boolean',
    ];

    public function tender(): BelongsTo
    {
        return $this->belongsTo(Tender::class);
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }
}
