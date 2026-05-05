<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, HasUuids;

    protected $fillable = [
        'organisation_id',
        'name',
        'email',
        'password',
        'phone',
        'avatar',
        'mfa_secret',
        'mfa_enabled',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'mfa_secret',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'mfa_enabled' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function organisation(): BelongsTo
    {
        return $this->belongsTo(Organisation::class);
    }

    public function departments()
    {
        return $this->hasMany(Department::class, 'manager_id');
    }

    public function purchaseRequests()
    {
        return $this->hasMany(PurchaseRequest::class, 'requested_by');
    }
}
