<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <div>
            <a href="{{ route('app.grns.index') }}" class="text-sm text-gray-500 hover:text-gray-700">← GRNs</a>
            <h1 class="text-2xl font-semibold text-gray-900 mt-1">{{ $grn->grn_number }}</h1>
        </div>
        <a href="{{ route('app.grns.pdf', $grn) }}" class="inline-flex items-center gap-2 px-3 py-2 border border-gray-300 text-sm text-gray-700 rounded-lg hover:bg-gray-50">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Download PDF
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div><span class="text-gray-500">Status</span><div class="mt-1">@include('components.status-badge', ['status' => $grn->status])</div></div>
                    <div><span class="text-gray-500">Purchase Order</span><a href="{{ route('app.purchase-orders.show', $grn->purchaseOrder) }}" class="font-medium text-blue-700 mt-1 block hover:underline">{{ $grn->purchaseOrder->po_number }}</a></div>
                    <div><span class="text-gray-500">Vendor</span><p class="font-medium text-gray-900 mt-1">{{ $grn->purchaseOrder->vendor->name }}</p></div>
                    <div><span class="text-gray-500">Received By</span><p class="font-medium text-gray-900 mt-1">{{ $grn->receivedByUser->name }}</p></div>
                    <div><span class="text-gray-500">Received At</span><p class="font-medium text-gray-900 mt-1">{{ $grn->received_at?->format('d M Y H:i') }}</p></div>
                    @if($grn->notes)
                    <div class="col-span-2"><span class="text-gray-500">Notes</span><p class="mt-1 text-gray-900">{{ $grn->notes }}</p></div>
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                <div class="p-6 border-b border-gray-100"><h2 class="text-base font-semibold text-gray-900">Items</h2></div>
                <table class="w-full text-sm">
                    <thead class="bg-gray-50"><tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">UoM</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Ordered</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Received</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Variance</th>
                    </tr></thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($grn->items as $item)
                        @php $variance = $item->quantity_received - $item->quantity_ordered; @endphp
                        <tr>
                            <td class="px-6 py-3">{{ $item->description }}</td>
                            <td class="px-6 py-3 text-gray-500">{{ $item->unit_of_measure }}</td>
                            <td class="px-6 py-3 text-right">{{ number_format($item->quantity_ordered, 2) }}</td>
                            <td class="px-6 py-3 text-right {{ $item->quantity_received < $item->quantity_ordered ? 'text-amber-600' : 'text-green-600' }} font-medium">{{ number_format($item->quantity_received, 2) }}</td>
                            <td class="px-6 py-3 {{ $variance < 0 ? 'text-amber-600' : ($variance > 0 ? 'text-blue-600' : 'text-gray-500') }}">{{ $variance >= 0 ? '+' : '' }}{{ number_format($variance, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="space-y-4">
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6 text-sm space-y-2">
                <div class="flex justify-between"><span class="text-gray-500">GRN Status</span>@include('components.status-badge', ['status' => $grn->status])</div>
                <div class="flex justify-between"><span class="text-gray-500">PO Status</span>@include('components.status-badge', ['status' => $grn->purchaseOrder->status])</div>
            </div>
        </div>
    </div>
</x-app-layout>
