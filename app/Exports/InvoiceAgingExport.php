<?php

namespace App\Exports;

use App\Models\Invoice;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class InvoiceAgingExport implements FromCollection, WithHeadings, WithTitle
{
    public function __construct(private string $orgId) {}

    public function collection()
    {
        return Invoice::where('organisation_id', $this->orgId)
            ->whereNotIn('status', ['paid', 'void'])
            ->with('vendor')
            ->get()
            ->map(function ($inv) {
                $due = $inv->due_date ? now()->diffInDays($inv->due_date, false) : null;
                $bucket = match (true) {
                    $due === null => 'No Due Date',
                    $due >= 0    => 'Current',
                    $due >= -30  => '1-30 Days',
                    $due >= -60  => '31-60 Days',
                    $due >= -90  => '61-90 Days',
                    default      => '90+ Days',
                };
                return [
                    'Invoice #'  => $inv->invoice_number,
                    'Vendor'     => $inv->vendor?->name,
                    'Amount'     => $inv->amount,
                    'Status'     => ucwords(str_replace('_', ' ', $inv->status)),
                    'Due Date'   => $inv->due_date?->toDateString(),
                    'Aging'      => $bucket,
                    'Days Over'  => $due !== null && $due < 0 ? abs($due) : 0,
                ];
            });
    }

    public function headings(): array
    {
        return ['Invoice #', 'Vendor', 'Amount (ZMW)', 'Status', 'Due Date', 'Aging Bucket', 'Days Overdue'];
    }

    public function title(): string
    {
        return 'Invoice Aging';
    }
}
