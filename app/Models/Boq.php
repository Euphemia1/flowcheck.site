<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Boq extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'boqs';

    protected $fillable = [
        'organisation_id',
        'project_name',
        'boq_number',
        'description',
        'total_estimated_value',
        'status',
        'created_by',
        'attachments',
    ];

    protected $casts = [
        'total_estimated_value' => 'decimal:2',
        'attachments' => 'json',
    ];

    public function organisation(): BelongsTo
    {
        return $this->belongsTo(Organisation::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function items(): HasMany
    {
        return $this->hasMany(BoqItem::class, 'boq_id');
    }

    public function tenders(): HasMany
    {
        return $this->hasMany(Tender::class);
    }
}
