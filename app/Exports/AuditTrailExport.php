<?php

namespace App\Exports;

use App\Models\AuditLog;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class AuditTrailExport implements FromQuery, WithHeadings, WithMapping, WithTitle
{
    public function __construct(
        private string $orgId,
        private string $from,
        private string $to,
        private ?string $model = null,
        private ?string $userId = null,
    ) {}

    public function query()
    {
        $q = AuditLog::where('organisation_id', $this->orgId)
            ->whereBetween('created_at', [$this->from, $this->to])
            ->with('user')
            ->orderByDesc('created_at');

        if ($this->model) $q->where('model_type', $this->model);
        if ($this->userId) $q->where('user_id', $this->userId);

        return $q;
    }

    public function map($log): array
    {
        return [
            $log->created_at->toDateTimeString(),
            $log->user?->name,
            $log->action,
            $log->model_type,
            $log->model_id,
            $log->changes ? json_encode($log->changes) : '',
        ];
    }

    public function headings(): array
    {
        return ['Timestamp', 'User', 'Action', 'Model', 'Record ID', 'Changes'];
    }

    public function title(): string
    {
        return 'Audit Trail';
    }
}
