<?php

namespace App\Policies;

use App\Models\Vendor;
use App\Models\User;

class VendorPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->organisation_id !== null;
    }

    public function view(User $user, Vendor $vendor): bool
    {
        return $user->organisation_id === $vendor->organisation_id;
    }

    public function create(User $user): bool
    {
        return $user->can('create_vendors') && $user->organisation_id !== null;
    }

    public function update(User $user, Vendor $vendor): bool
    {
        return $user->can('update_vendors') &&
               $user->organisation_id === $vendor->organisation_id;
    }

    public function approve(User $user, Vendor $vendor): bool
    {
        return $user->hasRole('org_admin') &&
               $user->organisation_id === $vendor->organisation_id;
    }
}
