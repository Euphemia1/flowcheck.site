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
        .badge-draft { background: #f3f4f6; color: #374151; }
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
            <div class="org-name">{{ $po->organisation->name }}</div>
            <div class="org-meta">{{ $po->organisation->address ?? '' }}</div>
            <div class="org-meta">{{ $po->organisation->phone ?? '' }} · {{ $po->organisation->email ?? '' }}</div>
        </div>
        <div class="doc-title">
            <h1>PURCHASE ORDER</h1>
            <div class="doc-number">{{ $po->po_number }}</div>
            <div style="margin-top: 6px;">
                <span class="badge badge-{{ $po->status === 'approved' ? 'approved' : 'draft' }}">{{ strtoupper($po->status) }}</span>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="two-col">
            <div>
                <div class="section-title">Vendor</div>
                <div class="field-value">{{ $po->vendor->name }}</div>
                <div class="field-label" style="margin-top:4px;">{{ $po->vendor->address ?? '' }}</div>
                <div class="field-label">{{ $po->vendor->email ?? '' }}</div>
                @if($po->vendor->zppa_reg_number)
                <div class="field-label" style="margin-top:4px;">ZPPA Reg: {{ $po->vendor->zppa_reg_number }}</div>
                @endif
            </div>
            <div>
                <div class="section-title">Order Details</div>
                <table style="margin:0;">
                    <tr><td class="field-label">PO Date:</td><td class="field-value">{{ $po->created_at->toDateString() }}</td></tr>
                    @if($po->delivery_date)
                    <tr><td class="field-label">Delivery Date:</td><td class="field-value">{{ \Carbon\Carbon::parse($po->delivery_date)->toDateString() }}</td></tr>
                    @endif
                    @if($po->delivery_address)
                    <tr><td class="field-label">Deliver To:</td><td class="field-value">{{ $po->delivery_address }}</td></tr>
                    @endif
                    @if($po->payment_terms)
                    <tr><td class="field-label">Payment Terms:</td><td class="field-value">{{ $po->payment_terms }}</td></tr>
                    @endif
                </table>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Line Items</div>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Description</th>
                    <th>Unit</th>
                    <th class="text-right">Qty</th>
                    <th class="text-right">Unit Price (ZMW)</th>
                    <th class="text-right">Total (ZMW)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($po->items as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item->description }}</td>
                    <td>{{ $item->unit_of_measure ?? '—' }}</td>
                    <td class="text-right">{{ number_format($item->quantity, 2) }}</td>
                    <td class="text-right">{{ number_format($item->unit_price, 2) }}</td>
                    <td class="text-right">{{ number_format($item->quantity * $item->unit_price, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <table class="totals-table">
            <tr>
                <td class="field-label">Subtotal:</td>
                <td class="text-right field-value">ZMW {{ number_format($po->total_amount, 2) }}</td>
            </tr>
            @if($po->vat_amount ?? 0)
            <tr>
                <td class="field-label">VAT (16%):</td>
                <td class="text-right field-value">ZMW {{ number_format($po->vat_amount, 2) }}</td>
            </tr>
            @endif
            <tr class="total-row">
                <td>TOTAL:</td>
                <td class="text-right">ZMW {{ number_format($po->total_amount + ($po->vat_amount ?? 0), 2) }}</td>
            </tr>
        </table>
    </div>

    @if($po->notes)
    <div class="section">
        <div class="section-title">Notes</div>
        <p style="font-size:11px; color:#4b5563;">{{ $po->notes }}</p>
    </div>
    @endif

    <div class="signature-section">
        <div class="sig-box">
            <div class="sig-line">Prepared By</div>
        </div>
        <div class="sig-box">
            <div class="sig-line">Approved By</div>
        </div>
        <div class="sig-box">
            <div class="sig-line">Vendor Acknowledgement</div>
        </div>
    </div>

    <div class="footer">
        This is a computer-generated document. · Generated {{ now()->toDateTimeString() }} · FlowCheck Procurement System
    </div>
</div>
</body>
</html>
