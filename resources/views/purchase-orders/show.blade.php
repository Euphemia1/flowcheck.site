<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <div>
            <a href="{{ route('app.purchase-orders.index') }}" class="text-sm text-gray-500 hover:text-gray-700">← Purchase Orders</a>
            <h1 class="text-2xl font-semibold text-gray-900 mt-1">{{ $purchaseOrder->po_number }}</h1>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('app.purchase-orders.pdf', $purchaseOrder) }}" class="inline-flex items-center gap-2 px-3 py-2 border border-gray-300 text-sm text-gray-700 rounded-lg hover:bg-gray-50">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Download PDF
            </a>
            @if($purchaseOrder->status === 'draft')
                @can('approve_purchase_orders')
                <form method="POST" action="{{ route('app.purchase-orders.approve', $purchaseOrder) }}">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700">Approve & Send</button>
                </form>
                @endcan
                @can('cancel_purchase_orders')
                <form method="POST" action="{{ route('app.purchase-orders.cancel', $purchaseOrder) }}" onsubmit="return confirm('Cancel this PO?')">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700">Cancel</button>
                </form>
                @endcan
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            {{-- PO Header --}}
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
                <h2 class="text-base font-semibold text-gray-900 mb-4">Order Information</h2>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div><span class="text-gray-500">Status</span><div class="mt-1">@include('components.status-badge', ['status' => $purchaseOrder->status])</div></div>
                    <div><span class="text-gray-500">Vendor</span><p class="font-medium text-gray-900 mt-1">{{ $purchaseOrder->vendor->name }}</p></div>
                    <div><span class="text-gray-500">Payment Terms</span><p class="font-medium text-gray-900 mt-1">{{ $purchaseOrder->payment_terms ?? '—' }}</p></div>
                    <div><span class="text-gray-500">Expected Delivery</span><p class="font-medium text-gray-900 mt-1">{{ $purchaseOrder->expected_delivery_date?->format('d M Y') ?? '—' }}</p></div>
                    <div class="col-span-2"><span class="text-gray-500">Delivery Address</span><p class="font-medium text-gray-900 mt-1">{{ $purchaseOrder->delivery_address ?? '—' }}</p></div>
                    @if($purchaseOrder->purchaseRequest)
                    <div><span class="text-gray-500">From PR</span><a href="{{ route('app.purchase-requests.show', $purchaseOrder->purchaseRequest) }}" class="font-medium text-blue-700 hover:underline mt-1 block">{{ $purchaseOrder->purchaseRequest->pr_number }}</a></div>
                    @endif
                    @if($purchaseOrder->approvedBy)
                    <div><span class="text-gray-500">Approved By</span><p class="font-medium text-gray-900 mt-1">{{ $purchaseOrder->approvedBy->name }}</p></div>
                    @endif
                </div>
            </div>

            {{-- Line Items --}}
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                <div class="p-6 border-b border-gray-100"><h2 class="text-base font-semibold text-gray-900">Line Items</h2></div>
                <table class="w-full text-sm">
                    <thead class="bg-gray-50"><tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">UoM</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Qty</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Unit Price</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total</th>
                    </tr></thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($purchaseOrder->items as $item)
                        <tr>
                            <td class="px-6 py-3">{{ $item->description }}</td>
                            <td class="px-6 py-3 text-gray-500">{{ $item->unit_of_measure }}</td>
                            <td class="px-6 py-3 text-right">{{ number_format($item->quantity_ordered, 2) }}</td>
                            <td class="px-6 py-3 text-right">{{ number_format($item->unit_price, 2) }}</td>
                            <td class="px-6 py-3 text-right font-medium">{{ number_format($item->total_price, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="border-t-2 border-gray-200">
                        <tr><td colspan="4" class="px-6 py-3 text-right font-semibold text-gray-700">Grand Total (ZMW)</td>
                        <td class="px-6 py-3 text-right font-bold text-gray-900 text-base">{{ number_format($purchaseOrder->total_amount, 2) }}</td></tr>
                    </tfoot>
                </table>
            </div>

            {{-- Linked GRNs --}}
            @if($purchaseOrder->grns->count())
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                <div class="p-6 border-b border-gray-100"><h2 class="text-base font-semibold text-gray-900">Goods Receipts</h2></div>
                <table class="w-full text-sm">
                    <thead class="bg-gray-50"><tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">GRN Number</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Received At</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3"></th>
                    </tr></thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($purchaseOrder->grns as $grn)
                        <tr>
                            <td class="px-6 py-3 font-medium text-blue-700">{{ $grn->grn_number }}</td>
                            <td class="px-6 py-3 text-gray-500">{{ $grn->received_at?->format('d M Y H:i') }}</td>
                            <td class="px-6 py-3">@include('components.status-badge', ['status' => $grn->status])</td>
                            <td class="px-6 py-3"><a href="{{ route('app.grns.show', $grn) }}" class="text-blue-700 hover:underline text-xs">View</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>

        {{-- Right sidebar --}}
        <div class="space-y-4">
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
                <p class="text-sm text-gray-500 mb-1">Total Amount</p>
                <p class="text-2xl font-bold text-gray-900">ZMW {{ number_format($purchaseOrder->total_amount, 2) }}</p>
            </div>
            @can('create_grns')
            @if(in_array($purchaseOrder->status, ['sent','acknowledged','partially_received']))
            <a href="{{ route('app.grns.create') }}?po={{ $purchaseOrder->id }}" class="block w-full px-4 py-2 text-center bg-blue-700 text-white text-sm font-medium rounded-lg hover:bg-blue-800">
                Record Goods Receipt
            </a>
            @endif
            @endcan
        </div>
    </div>
</x-app-layout>
