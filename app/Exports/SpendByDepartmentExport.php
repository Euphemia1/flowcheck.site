<?php

namespace App\Exports;

use App\Models\PurchaseOrder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class SpendByDepartmentExport implements FromCollection, WithHeadings, WithTitle
{
    public function __construct(
        private string $orgId,
        private string $from,
        private string $to,
    ) {}

    public function collection()
    {
        return PurchaseOrder::where('organisation_id', $this->orgId)
            ->whereIn('status', ['approved', 'partially_received', 'received', 'closed'])
            ->whereBetween('created_at', [$this->from, $this->to])
            ->with('purchaseRequest.department')
            ->get()
            ->groupBy(fn($po) => $po->purchaseRequest?->department?->name ?? 'Unassigned')
            ->map(fn($pos, $dept) => [
                'Department'  => $dept,
                'PO Count'    => $pos->count(),
                'Total Spend' => $pos->sum('total_amount'),
            ])
            ->sortByDesc('Total Spend')
            ->values();
    }

    public function headings(): array
    {
        return ['Department', 'PO Count', 'Total Spend (ZMW)'];
    }

    public function title(): string
    {
        return 'Spend by Department';
    }
}
