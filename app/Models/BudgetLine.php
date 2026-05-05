<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BudgetLine extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'organisation_id',
        'department_id',
        'fiscal_year',
        'category',
        'allocated_amount',
        'committed_amount',
        'spent_amount',
    ];

    protected $casts = [
        'allocated_amount' => 'decimal:2',
        'committed_amount' => 'decimal:2',
        'spent_amount' => 'decimal:2',
    ];

    public function organisation(): BelongsTo
    {
        return $this->belongsTo(Organisation::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function getRemainingAmountAttribute()
    {
        return $this->allocated_amount - $this->spent_amount;
    }
}
