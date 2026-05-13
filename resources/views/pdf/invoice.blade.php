<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; color: #1f2937; line-height: 1.4; }
        .page { padding: 40px; }
        .header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 32px; border-bottom: 2px solid #1d4ed8; padding-bottom: 16px; }
        .org-name { font-size: 18px; font-weight: 700; color: #1d4ed8; }
        .org-meta { font-size: 10px; color: #6b7280; margin-top: 2px; }
        .doc-title { text-align: right; }
        .doc-title h1 { font-size: 20px; font-weight: 700; color: #1f2937; }
        .doc-number { font-size: 13px; font-weight: 600; color: #1d4ed8; }
        .badge { display: inline-block; padding: 2px 8px; border-radius: 9999px; font-size: 10px; font-weight: 600; text-transform: uppercase; }
        .badge-approved { background: #dcfce7; color: #166534; }
        .badge-received { background: #dbeafe; color: #1e40af; }
        .badge-pending { background: #fef9c3; color: #854d0e; }
        .section { margin-bottom: 20px; }
        .section-title { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #6b7280; border-bottom: 1px solid #e5e7eb; padding-bottom: 6px; margin-bottom: 10px; }
        .two-col { display: flex; gap: 24px; }
        .two-col > div { flex: 1; }
        .field-label { font-size: 10px; color: #6b7280; margin-bottom: 2px; }
        .field-value { font-size: 11px; font-weight: 500; color: #1f2937; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
        table th { background: #f3f4f6; text-align: left; padding: 7px 10px; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.04em; color: #6b7280; border-bottom: 1px solid #d1d5db; }
        table td { padding: 7px 10px; border-bottom: 1px solid #f3f4f6; font-size: 11px; }
        .text-right { text-align: right; }
        .totals-table { margin-left: auto; width: 280px; }
        .totals-table td { padding: 5px 10px; }
        .totals-table .total-row td { font-weight: 700; font-size: 13px; border-top: 2px solid #1d4ed8; color: #1d4ed8; }
        .footer { margin-top: 40px; padding-top: 16px; border-top: 1px solid #e5e7eb; font-size: 10px; color: #9ca3af; text-align: center; }
        .signature-section { display: flex; gap: 40px; margin-top: 40px; }
        .sig-box { flex: 1; }
        .sig-line { border-top: 1px solid #9ca3af; margin-top: 40px; padding-top: 6px; font-size: 10px; color: #6b7280; }
    </style>
</head>
<body>
<div class="page">
    <div class="header">
        <div>
            <div class="org-name">{{ $org->name }}</div>
            <div class="org-meta">{{ $org->address ?? '' }}</div>
            <div class="org-meta">{{ $org->email ?? '' }}</div>
        </div>
        <div class="doc-title">
            <h1>INVOICE</h1>
            <div class="doc-number">{{ $invoice->internal_invoice_number }}</div>
            <div style="margin-top:6px;">
                <span class="badge badge-{{ $invoice->status === 'approved_for_payment' ? 'approved' : ($invoice->status === 'received' ? 'received' : 'pending') }}">
                    {{ ucwords(str_replace('_', ' ', $invoice->status)) }}
                </span>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="two-col">
            <div>
                <div class="section-title">Vendor Details</div>
                <div class="field-label">Vendor Name</div>
                <div class="field-value">{{ $invoice->vendor->name ?? 'N/A' }}</div>
                @if($invoice->vendor?->contact_email)
                    <div class="field-label" style="margin-top:6px;">Email</div>
                    <div class="field-value">{{ $invoice->vendor->contact_email }}</div>
                @endif
            </div>
            <div>
                <div class="section-title">Invoice Details</div>
                <div class="field-label">Vendor Invoice No.</div>
                <div class="field-value">{{ $invoice->invoice_number }}</div>
                <div class="field-label" style="margin-top:6px;">Invoice Date</div>
                <div class="field-value">{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d M Y') }}</div>
                <div class="field-label" style="margin-top:6px;">Due Date</div>
                <div class="field-value">{{ \Carbon\Carbon::parse($invoice->due_date)->format('d M Y') }}</div>
                @if($invoice->purchaseOrder)
                    <div class="field-label" style="margin-top:6px;">Related PO</div>
                    <div class="field-value">{{ $invoice->purchaseOrder->po_number }}</div>
                @endif
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Amount Summary</div>
        <table class="totals-table">
            <tr>
                <td class="field-label">Total Amount</td>
                <td class="text-right field-label">ZMW</td>
            </tr>
            <tr class="total-row">
                <td>Total</td>
                <td class="text-right">{{ number_format($invoice->total_amount, 2) }}</td>
            </tr>
        </table>
    </div>

    <div class="signature-section">
        <div class="sig-box">
            <div class="sig-line">Prepared By / Date</div>
        </div>
        <div class="sig-box">
            <div class="sig-line">Approved By / Date</div>
        </div>
        <div class="sig-box">
            <div class="sig-line">Finance Officer / Date</div>
        </div>
    </div>

    <div class="footer">
        Generated by FlowCheck &mdash; {{ now()->format('d M Y H:i') }} &mdash; ZPPA Compliant
    </div>
</div>
</body>
</html>
