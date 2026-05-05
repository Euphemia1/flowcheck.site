<?php

namespace App\Services;

use App\Models\GoodsReceiptNote;
use App\Models\Invoice;
use App\Models\InvoiceMatchingResult;
use App\Models\PurchaseOrder;
use Illuminate\Support\Facades\DB;

class ThreeWayMatchingService
{
    /**
     * Perform 3-way matching: Invoice vs PO vs GRN
     */
    public function matchInvoice(Invoice $invoice): array
    {
        $po = $invoice->purchaseOrder;
        if (!$po) {
            return ['matched' => false, 'reason' => 'No PO linked to invoice'];
        }

        $grn = $po->grns()->latest()->first();
        if (!$grn) {
            return ['matched' => false, 'reason' => 'No GRN found for PO'];
        }

        $results = [];
        $allMatched = true;

        // Match each invoice line item
        foreach ($po->items as $poItem) {
            $qtyInvoiced = 0;
            // In a real scenario, parse invoice items; for MVP assume quantity matches
            $qtyReceived = $grn->items->where('po_item_id', $poItem->id)->sum('quantity_received');
            
            $priceInvoiced = $invoice->total_amount;
            $pricePo = $po->total_amount;

            $qtyMatch = $qtyInvoiced >= ($qtyReceived ?? 0);
            $priceMatch = $priceInvoiced >= $pricePo * 0.95; // Allow 5% variance

            if (!$qtyMatch || !$priceMatch) {
                $allMatched = false;
            }

            $result = InvoiceMatchingResult::create([
                'invoice_id' => $invoice->id,
                'po_id' => $po->id,
                'grn_id' => $grn->id,
                'qty_invoiced' => $qtyInvoiced,
                'qty_ordered' => $poItem->quantity_ordered,
                'qty_received' => $qtyReceived,
                'price_invoiced' => $priceInvoiced,
                'price_po' => $pricePo,
                'qty_match' => $qtyMatch,
                'price_match' => $priceMatch,
            ]);

            $results[] = $result;
        }

        $newStatus = $allMatched ? 'matched' : 'discrepancy';
        $invoice->update([
            'matching_status' => $allMatched ? 'matched' : 'failed',
            'status' => $newStatus,
        ]);

        return [
            'matched' => $allMatched,
            'status' => $newStatus,
            'results' => $results,
        ];
    }

    /**
     * Check if invoice can be approved for payment (SI 68 compliance)
     */
    public function canApproveForPayment(Invoice $invoice): bool
    {
        if (config('app.SI68_COMPLIANCE_MODE', false)) {
            return $invoice->matching_status === 'matched';
        }
        return true;
    }
}
