<?php

namespace App\Traits;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait LogsToAudit
{
    protected function logAudit(string $action, Model $model, array $changes = []): void
    {
        AuditLog::create([
            'organisation_id' => Auth::user()->organisation_id,
            'user_id'         => Auth::id(),
            'model_type'      => class_basename($model),
            'model_id'        => $model->getKey(),
            'action'          => $action,
            'changes'         => $changes ?: null,
        ]);
    }
}
