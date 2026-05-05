<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PurchaseRequest extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'organisation_id',
        'department_id',
        'requested_by',
        'pr_number',
        'title',
        'description',
        'justification',
        'status',
        'priority',
        'required_by_date',
        'total_estimated_amount',
        'current_approver_id',
        'approval_step',
        'attachments',
    ];

    protected $casts = [
        'attachments' => 'json',
        'status' => 'string',
        'priority' => 'string',
        'total_estimated_amount' => 'decimal:2',
        'required_by_date' => 'date',
    ];

    public function organisation(): BelongsTo
    {
        return $this->belongsTo(Organisation::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function currentApprover(): BelongsTo
    {
        return $this->belongsTo(User::class, 'current_approver_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(PurchaseRequestItem::class);
    }

    public function approvalLogs(): HasMany
    {
        return $this->hasMany(ApprovalLog::class);
    }

    public function purchaseOrders(): HasMany
    {
        return $this->hasMany(PurchaseOrder::class);
    }
}
