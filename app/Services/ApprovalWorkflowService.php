<?php

namespace App\Services;

use App\Models\ApprovalWorkflow;
use App\Models\ApprovalLog;
use App\Models\PurchaseRequest;
use App\Models\User;

class ApprovalWorkflowService
{
    /**
     * Get the next approver for a PR based on workflow rules
     */
    public function getNextApprover(PurchaseRequest $pr): ?User
    {
        $workflow = $this->getApplicableWorkflow($pr);
        if (!$workflow) {
            return null;
        }

        $steps = $workflow->steps;
        $currentStep = $pr->approval_step;
        $nextStepIndex = $currentStep;

        if ($nextStepIndex >= count($steps)) {
            return null; // Approval complete
        }

        $nextStep = $steps[$nextStepIndex];
        
        if (isset($nextStep['user_id']) && $nextStep['user_id']) {
            return User::find($nextStep['user_id']);
        }

        // Find user by role
        if (isset($nextStep['role'])) {
            return User::where('organisation_id', $pr->organisation_id)
                ->role($nextStep['role'])
                ->first();
        }

        return null;
    }

    /**
     * Get applicable workflow for PR
     */
    public function getApplicableWorkflow(PurchaseRequest $pr): ?ApprovalWorkflow
    {
        $amount = $pr->total_estimated_amount;

        return ApprovalWorkflow::where('organisation_id', $pr->organisation_id)
            ->where(function ($query) use ($pr) {
                $query->whereNull('department_id')
                    ->orWhere('department_id', $pr->department_id);
            })
            ->where(function ($query) use ($amount) {
                $query->whereNull('min_amount')
                    ->orWhere('min_amount', '<=', $amount);
            })
            ->where(function ($query) use ($amount) {
                $query->whereNull('max_amount')
                    ->orWhere('max_amount', '>=', $amount);
            })
            ->first();
    }

    /**
     * Move PR to next approval step
     */
    public function moveToNextStep(PurchaseRequest $pr): void
    {
        $nextApprover = $this->getNextApprover($pr);
        
        if ($nextApprover) {
            $pr->increment('approval_step');
            $pr->update(['current_approver_id' => $nextApprover->id]);
        } else {
            // All approvals complete
            $pr->update(['status' => 'approved']);
        }
    }

    /**
     * Log an approval action
     */
    public function logApproval(PurchaseRequest $pr, User $approver, string $action, ?string $comments = null): ApprovalLog
    {
        return ApprovalLog::create([
            'purchase_request_id' => $pr->id,
            'step_number' => $pr->approval_step,
            'approver_id' => $approver->id,
            'action' => $action,
            'comments' => $comments,
        ]);
    }
}
