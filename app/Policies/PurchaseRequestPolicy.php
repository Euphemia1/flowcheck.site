<?php

namespace App\Policies;

use App\Models\PurchaseRequest;
use App\Models\User;

class PurchaseRequestPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->organisation_id !== null;
    }

    public function view(User $user, PurchaseRequest $purchaseRequest): bool
    {
        return $user->organisation_id === $purchaseRequest->organisation_id;
    }

    public function create(User $user): bool
    {
        return $user->can('create_purchase_requests') && $user->organisation_id !== null;
    }

    public function update(User $user, PurchaseRequest $purchaseRequest): bool
    {
        return $user->id === $purchaseRequest->requested_by && 
               $purchaseRequest->status === 'draft' &&
               $user->organisation_id === $purchaseRequest->organisation_id;
    }

    public function delete(User $user, PurchaseRequest $purchaseRequest): bool
    {
        return $user->id === $purchaseRequest->requested_by && 
               $purchaseRequest->status === 'draft' &&
               $user->organisation_id === $purchaseRequest->organisation_id;
    }

    public function approve(User $user, PurchaseRequest $purchaseRequest): bool
    {
        return $user->id === $purchaseRequest->current_approver_id &&
               in_array($purchaseRequest->status, ['submitted', 'under_review']) &&
               $user->organisation_id === $purchaseRequest->organisation_id;
    }

    public function reject(User $user, PurchaseRequest $purchaseRequest): bool
    {
        return $this->approve($user, $purchaseRequest);
    }
}
