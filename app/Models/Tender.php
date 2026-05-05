<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tender extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'organisation_id',
        'boq_id',
        'tender_number',
        'title',
        'type',
        'publication_date',
        'closing_date',
        'status',
        'created_by',
    ];

    protected $casts = [
        'publication_date' => 'date',
        'closing_date' => 'date',
    ];

    public function organisation(): BelongsTo
    {
        return $this->belongsTo(Organisation::class);
    }

    public function boq(): BelongsTo
    {
        return $this->belongsTo(Boq::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(TenderSubmission::class);
    }
}
