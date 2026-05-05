<?php

namespace App\Policies;

use App\Models\Invoice;
use App\Models\User;

class InvoicePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->organisation_id !== null;
    }

    public function view(User $user, Invoice $invoice): bool
    {
        return $user->organisation_id === $invoice->organisation_id;
    }

    public function create(User $user): bool
    {
        return $user->can('create_invoices') && $user->organisation_id !== null;
    }

    public function update(User $user, Invoice $invoice): bool
    {
        return $user->can('update_invoices') &&
               in_array($invoice->status, ['received', 'pending_matching', 'discrepancy']) &&
               $user->organisation_id === $invoice->organisation_id;
    }

    public function approve(User $user, Invoice $invoice): bool
    {
        return $user->hasRole('cfo') &&
               $invoice->matching_status === 'matched' &&
               $user->organisation_id === $invoice->organisation_id;
    }
}
