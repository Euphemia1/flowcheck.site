<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; color: #1f2937; line-height: 1.4; }
        .page { padding: 40px; }
        .header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 32px; border-bottom: 2px solid #059669; padding-bottom: 16px; }
        .org-name { font-size: 18px; font-weight: 700; color: #059669; }
        .org-meta { font-size: 10px; color: #6b7280; margin-top: 2px; }
        .doc-title { text-align: right; }
        .doc-title h1 { font-size: 20px; font-weight: 700; color: #1f2937; }
        .doc-number { font-size: 13px; font-weight: 600; color: #059669; }
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
        .variance-ok { color: #059669; }
        .variance-warn { color: #d97706; font-weight: 600; }
        .footer { margin-top: 40px; padding-top: 16px; border-top: 1px solid #e5e7eb; font-size: 10px; color: #9ca3af; text-align: center; }
    </style>
</head>
<body>
<div class="page">
    <div class="header">
        <div>
            <div class="org-name">{{ $grn->organisation->name }}</div>
            <div class="org-meta">{{ $grn->organisation->address ?? '' }}</div>
        </div>
        <div class="doc-title">
            <h1>GOODS RECEIVED NOTE</h1>
            <div class="doc-number">{{ $grn->grn_number }}</div>
            <div style="font-size:10px; color:#6b7280; margin-top:4px;">{{ $grn->received_at ? \Carbon\Carbon::parse($grn->received_at)->toDateString() : $grn->created_at->toDateString() }}</div>
        </div>
    </div>

    <div class="section">
        <div class="two-col">
            <div>
                <div class="section-title">Purchase Order</div>
                <div class="field-value">{{ $grn->purchaseOrder->po_number }}</div>
                <div class="field-label" style="margin-top:4px;">Vendor: {{ $grn->purchaseOrder->vendor->name }}</div>
            </div>
            <div>
                <div class="section-title">Receipt Details</div>
                <table style="margin:0;">
                    <tr><td class="field-label">GRN #:</td><td class="field-value">{{ $grn->grn_number }}</td></tr>
                    <tr><td class="field-label">Received By:</td><td class="field-value">{{ $grn->receivedBy?->name ?? '—' }}</td></tr>
                    <tr><td class="field-label">Delivery Note:</td><td class="field-value">{{ $grn->delivery_note_number ?? '—' }}</td></tr>
                    <tr><td class="field-label">Condition:</td><td class="field-value">{{ ucwords(str_replace('_',' ',$grn->condition ?? 'good')) }}</td></tr>
                </table>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Items Received</div>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Description</th>
                    <th class="text-right">Ordered Qty</th>
                    <th class="text-right">Received Qty</th>
                    <th class="text-right">Variance</th>
                    <th>Condition</th>
                </tr>
            </thead>
            <tbody>
                @foreach($grn->items as $i => $item)
                @php
                    $variance = $item->quantity_received - $item->quantity_ordered;
                    $varClass = abs($variance) > 0 ? 'variance-warn' : 'variance-ok';
                @endphp
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item->description }}</td>
                    <td class="text-right">{{ number_format($item->quantity_ordered, 2) }}</td>
                    <td class="text-right">{{ number_format($item->quantity_received, 2) }}</td>
                    <td class="text-right {{ $varClass }}">{{ $variance > 0 ? '+' : '' }}{{ number_format($variance, 2) }}</td>
                    <td>{{ ucwords(str_replace('_',' ',$item->condition ?? 'good')) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($grn->notes)
    <div class="section">
        <div class="section-title">Notes</div>
        <p style="font-size:11px; color:#4b5563;">{{ $grn->notes }}</p>
    </div>
    @endif

    <div style="display:flex; gap:40px; margin-top:40px;">
        <div style="flex:1;">
            <div style="border-top:1px solid #9ca3af; margin-top:40px; padding-top:6px; font-size:10px; color:#6b7280;">Received By / Signature</div>
        </div>
        <div style="flex:1;">
            <div style="border-top:1px solid #9ca3af; margin-top:40px; padding-top:6px; font-size:10px; color:#6b7280;">Store Keeper</div>
        </div>
        <div style="flex:1;">
            <div style="border-top:1px solid #9ca3af; margin-top:40px; padding-top:6px; font-size:10px; color:#6b7280;">Delivery Driver / Vendor Rep</div>
        </div>
    </div>

    <div class="footer">
        This is a computer-generated document. · Generated {{ now()->toDateTimeString() }} · FlowCheck Procurement System
    </div>
</div>
</body>
</html>
