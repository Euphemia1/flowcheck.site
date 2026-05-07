<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 10px; color: #1f2937; line-height: 1.4; }
        .page { padding: 36px; }
        .header { margin-bottom: 24px; border-bottom: 2px solid #1d4ed8; padding-bottom: 14px; }
        .org-row { display: flex; justify-content: space-between; align-items: flex-start; }
        .org-name { font-size: 16px; font-weight: 700; color: #1d4ed8; }
        .org-meta { font-size: 9px; color: #6b7280; margin-top: 2px; }
        .doc-title { text-align: right; }
        .doc-title h1 { font-size: 17px; font-weight: 700; }
        .doc-number { font-size: 12px; font-weight: 600; color: #1d4ed8; }
        .zppa-badge { display: inline-block; margin-top: 4px; padding: 2px 8px; background: #fef3c7; border: 1px solid #d97706; border-radius: 4px; font-size: 9px; font-weight: 600; color: #92400e; }
        .project-meta { background: #f8fafc; border: 1px solid #e5e7eb; border-radius: 6px; padding: 12px 16px; margin-bottom: 18px; }
        .project-meta table { width: 100%; margin: 0; }
        .project-meta td { padding: 3px 8px 3px 0; font-size: 10px; }
        .section-title { font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #6b7280; border-bottom: 1px solid #e5e7eb; padding-bottom: 5px; margin-bottom: 8px; }
        .category-header { background: #1d4ed8; color: white; font-weight: 700; font-size: 10px; padding: 6px 10px; margin: 12px 0 0 0; }
        table.items { width: 100%; border-collapse: collapse; }
        table.items th { background: #f3f4f6; text-align: left; padding: 6px 8px; font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.04em; color: #6b7280; border-bottom: 1px solid #d1d5db; }
        table.items td { padding: 5px 8px; border-bottom: 1px solid #f3f4f6; font-size: 10px; vertical-align: top; }
        .text-right { text-align: right; }
        .subtotal-row td { background: #f0f9ff; font-weight: 600; border-top: 1px solid #bfdbfe; color: #1e40af; }
        .total-section { margin-top: 16px; margin-left: auto; width: 300px; }
        .total-section table { width: 100%; border-collapse: collapse; }
        .total-section td { padding: 5px 10px; font-size: 10px; }
        .total-section .grand-total td { background: #1d4ed8; color: white; font-weight: 700; font-size: 13px; }
        .zppa-section { margin-top: 20px; border: 1px solid #fbbf24; border-radius: 6px; padding: 12px 16px; background: #fffbeb; }
        .zppa-section h3 { font-size: 10px; font-weight: 700; color: #92400e; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.05em; }
        .zppa-section table td { padding: 4px 8px; font-size: 10px; border-bottom: 1px solid #fde68a; }
        .footer { margin-top: 30px; padding-top: 12px; border-top: 1px solid #e5e7eb; font-size: 9px; color: #9ca3af; text-align: center; }
    </style>
</head>
<body>
<div class="page">
    <div class="header">
        <div class="org-row">
            <div>
                <div class="org-name">{{ $boq->organisation->name }}</div>
                <div class="org-meta">{{ $boq->organisation->address ?? '' }}</div>
                <div class="org-meta">{{ $boq->organisation->phone ?? '' }} · {{ $boq->organisation->email ?? '' }}</div>
            </div>
            <div class="doc-title">
                <h1>BILL OF QUANTITIES</h1>
                <div class="doc-number">{{ $boq->boq_number }}</div>
                <div class="zppa-badge">ZPPA: {{ strtoupper(str_replace('_',' ',$boq->procurement_method ?? 'open_tender')) }}</div>
            </div>
        </div>
    </div>

    <div class="project-meta">
        <table>
            <tr>
                <td style="color:#6b7280;">Project:</td>
                <td style="font-weight:600;">{{ $boq->project_name }}</td>
                <td style="color:#6b7280;">BOQ Date:</td>
                <td>{{ $boq->created_at->toDateString() }}</td>
            </tr>
            <tr>
                <td style="color:#6b7280;">Location:</td>
                <td>{{ $boq->project_location ?? '—' }}</td>
                <td style="color:#6b7280;">Client/Engineer:</td>
                <td>{{ $boq->client_engineer ?? '—' }}</td>
            </tr>
            @if($boq->contract)
            <tr>
                <td style="color:#6b7280;">Contract Ref:</td>
                <td>{{ $boq->contract->contract_number }}</td>
                <td></td><td></td>
            </tr>
            @endif
        </table>
    </div>

    @php
        $grouped = collect($boq->items)->groupBy('category');
        $grandTotal = 0;
    @endphp

    @foreach($grouped as $category => $items)
    @php $catTotal = $items->sum(fn($i) => ($i['quantity'] ?? 0) * ($i['unit_rate'] ?? 0)); $grandTotal += $catTotal; @endphp
    <div class="category-header">{{ strtoupper($category) }}</div>
    <table class="items">
        <thead>
            <tr>
                <th style="width:5%">Item</th>
                <th>Description</th>
                <th style="width:8%">Unit</th>
                <th class="text-right" style="width:10%">Qty</th>
                <th class="text-right" style="width:14%">Unit Rate (ZMW)</th>
                <th class="text-right" style="width:15%">Amount (ZMW)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $j => $item)
            @php $lineTotal = ($item['quantity'] ?? 0) * ($item['unit_rate'] ?? 0); @endphp
            <tr>
                <td>{{ $j + 1 }}</td>
                <td>{{ $item['description'] }}</td>
                <td>{{ $item['unit'] ?? '—' }}</td>
                <td class="text-right">{{ number_format($item['quantity'] ?? 0, 2) }}</td>
                <td class="text-right">{{ number_format($item['unit_rate'] ?? 0, 2) }}</td>
                <td class="text-right">{{ number_format($lineTotal, 2) }}</td>
            </tr>
            @endforeach
            <tr class="subtotal-row">
                <td colspan="5" class="text-right">Subtotal — {{ $category }}:</td>
                <td class="text-right">{{ number_format($catTotal, 2) }}</td>
            </tr>
        </tbody>
    </table>
    @endforeach

    <div class="total-section">
        <table>
            <tr>
                <td style="color:#6b7280;">Sub Total:</td>
                <td class="text-right">ZMW {{ number_format($grandTotal, 2) }}</td>
            </tr>
            @if($boq->contingency_pct ?? 0)
            @php $cont = $grandTotal * ($boq->contingency_pct / 100); @endphp
            <tr>
                <td style="color:#6b7280;">Contingency ({{ $boq->contingency_pct }}%):</td>
                <td class="text-right">ZMW {{ number_format($cont, 2) }}</td>
            </tr>
            @php $grandTotal += $cont; @endphp
            @endif
            <tr class="grand-total">
                <td>TOTAL (ZMW):</td>
                <td class="text-right">{{ number_format($grandTotal, 2) }}</td>
            </tr>
        </table>
    </div>

    <div class="zppa-section">
        <h3>ZPPA Compliance Declaration</h3>
        <table>
            <tr>
                <td style="color:#92400e;">Procurement Method:</td>
                <td style="font-weight:600;">{{ ucwords(str_replace('_',' ',$boq->procurement_method ?? 'open_tender')) }}</td>
            </tr>
            <tr>
                <td style="color:#92400e;">Threshold Basis:</td>
                <td>
                    @php $total = $boq->total_amount ?? $grandTotal; @endphp
                    @if($total < 100000) Direct Procurement (&lt; ZMW 100,000)
                    @elseif($total < 1000000) Request for Quotations (ZMW 100,000 – 1,000,000)
                    @else Open International/National Tender (&gt; ZMW 1,000,000)
                    @endif
                </td>
            </tr>
            <tr>
                <td style="color:#92400e;">Prepared By:</td>
                <td>{{ $boq->preparedBy?->name ?? '—' }}</td>
            </tr>
        </table>
    </div>

    <div style="display:flex; gap:32px; margin-top:30px;">
        <div style="flex:1;"><div style="border-top:1px solid #9ca3af; margin-top:40px; padding-top:5px; font-size:9px; color:#6b7280;">Quantity Surveyor / Preparer</div></div>
        <div style="flex:1;"><div style="border-top:1px solid #9ca3af; margin-top:40px; padding-top:5px; font-size:9px; color:#6b7280;">Project Manager</div></div>
        <div style="flex:1;"><div style="border-top:1px solid #9ca3af; margin-top:40px; padding-top:5px; font-size:9px; color:#6b7280;">Finance / Approver</div></div>
    </div>

    <div class="footer">
        This BOQ is prepared in accordance with ZPPA regulations. · Generated {{ now()->toDateTimeString() }} · FlowCheck Procurement System
    </div>
</div>
</body>
</html>
