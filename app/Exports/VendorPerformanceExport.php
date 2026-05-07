<?php

namespace App\Exports;

use App\Models\Vendor;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class VendorPerformanceExport implements FromCollection, WithHeadings, WithTitle
{
    public function __construct(
        private string $orgId,
        private string $from,
        private string $to,
    ) {}

    public function collection()
    {
        return Vendor::where('organisation_id', $this->orgId)
            ->withCount(['purchaseOrders as po_count' => function ($q) {
                $q->where('organisation_id', $this->orgId)->whereBetween('created_at', [$this->from, $this->to]);
            }])
            ->withSum(['purchaseOrders as total_spend' => function ($q) {
                $q->where('organisation_id', $this->orgId)
                  ->whereIn('status', ['approved','partially_received','received','closed'])
                  ->whereBetween('created_at', [$this->from, $this->to]);
            }], 'total_amount')
            ->orderByDesc('total_spend')
            ->get()
            ->map(fn($v) => [
                'Vendor'       => $v->name,
                'ZPPA Reg'     => $v->zppa_reg_number ?? '—',
                'PO Count'     => $v->po_count,
                'Total Spend'  => $v->total_spend ?? 0,
            ]);
    }

    public function headings(): array
    {
        return ['Vendor', 'ZPPA Reg No.', 'PO Count', 'Total Spend (ZMW)'];
    }

    public function title(): string
    {
        return 'Vendor Performance';
    }
}
