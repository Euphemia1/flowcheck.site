<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ApprovalWorkflow extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'organisation_id',
        'name',
        'department_id',
        'min_amount',
        'max_amount',
        'steps',
    ];

    protected $casts = [
        'steps' => 'json',
        'min_amount' => 'decimal:2',
        'max_amount' => 'decimal:2',
    ];

    public function organisation(): BelongsTo
    {
        return $this->belongsTo(Organisation::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
}
