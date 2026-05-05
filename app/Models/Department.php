<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'organisation_id',
        'name',
        'budget_allocated',
        'budget_used',
        'manager_id',
    ];

    protected $casts = [
        'budget_allocated' => 'decimal:2',
        'budget_used' => 'decimal:2',
    ];

    public function organisation(): BelongsTo
    {
        return $this->belongsTo(Organisation::class);
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function purchaseRequests(): HasMany
    {
        return $this->hasMany(PurchaseRequest::class);
    }

    public function budgetLines(): HasMany
    {
        return $this->hasMany(BudgetLine::class);
    }
}
