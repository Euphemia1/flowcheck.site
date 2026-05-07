<?php

namespace App\Exports;

use App\Models\PurchaseRequest;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class PurchaseRequestStatusExport implements FromQuery, WithHeadings, WithMapping, WithTitle
{
    public function __construct(
        private string $orgId,
        private string $from,
        private string $to,
    ) {}

    public function query()
    {
        return PurchaseRequest::where('organisation_id', $this->orgId)
            ->whereBetween('created_at', [$this->from, $this->to])
            ->with(['department', 'requester'])
            ->orderByDesc('created_at');
    }

    public function map($pr): array
    {
        return [
            $pr->pr_number,
            $pr->title,
            $pr->requester?->name,
            $pr->department?->name,
            ucwords(str_replace('_', ' ', $pr->status)),
            number_format($pr->total_amount, 2),
            $pr->created_at->toDateString(),
        ];
    }

    public function headings(): array
    {
        return ['PR Number', 'Title', 'Requester', 'Department', 'Status', 'Amount (ZMW)', 'Date'];
    }

    public function title(): string
    {
        return 'PR Status';
    }
}
