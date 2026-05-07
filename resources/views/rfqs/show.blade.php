<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <div>
            <a href="{{ route('app.rfqs.index') }}" class="text-sm text-gray-500 hover:text-gray-700">← RFQs</a>
            <h1 class="text-2xl font-semibold text-gray-900 mt-1">{{ $rfq->rfq_number }}</h1>
        </div>
        <div class="flex gap-3">
            @if($rfq->status === 'sent')
                @can('close_rfqs')
                <form method="POST" action="{{ route('app.rfqs.close', $rfq) }}">
                    @csrf
                    <button type="submit" class="px-4 py-2 border border-gray-300 text-sm text-gray-700 rounded-lg hover:bg-gray-50">Close RFQ</button>
                </form>
                @endcan
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div><span class="text-gray-500">Status</span><div class="mt-1">@include('components.status-badge', ['status' => $rfq->status])</div></div>
                    <div><span class="text-gray-500">Deadline</span><p class="font-medium text-gray-900 mt-1">{{ $rfq->deadline->format('d M Y H:i') }}</p></div>
                    @if($rfq->purchaseRequest)
                    <div><span class="text-gray-500">Linked PR</span><a href="{{ route('app.purchase-requests.show', $rfq->purchaseRequest) }}" class="font-medium text-blue-700 mt-1 block hover:underline">{{ $rfq->purchaseRequest->pr_number }}</a></div>
                    @endif
                    <div><span class="text-gray-500">Created By</span><p class="font-medium text-gray-900 mt-1">{{ $rfq->createdBy->name }}</p></div>
                    @if($rfq->description)
                    <div class="col-span-2"><span class="text-gray-500">Description</span><p class="mt-1 text-gray-900">{{ $rfq->description }}</p></div>
                    @endif
                </div>
            </div>

            {{-- Vendor Quotes --}}
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                <div class="p-6 border-b border-gray-100"><h2 class="text-base font-semibold text-gray-900">Vendor Quotes</h2></div>
                <table class="w-full text-sm">
                    <thead class="bg-gray-50"><tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Vendor</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Amount (ZMW)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Valid Until</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3"></th>
                    </tr></thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($rfq->quotes as $quote)
                        <tr class="hover:bg-gray-50 {{ $quote->is_selected ? 'bg-green-50' : '' }}">
                            <td class="px-6 py-3 font-medium text-gray-900">{{ $quote->vendor->name }}</td>
                            <td class="px-6 py-3 text-right">{{ number_format($quote->total_amount, 2) }}</td>
                            <td class="px-6 py-3 text-gray-500">{{ $quote->valid_until?->format('d M Y') ?? '—' }}</td>
                            <td class="px-6 py-3">{{ $quote->is_selected ? '<span class="text-green-700 font-medium text-xs">Selected</span>' : '' }}</td>
                            <td class="px-6 py-3">
                                @if($rfq->status === 'closed' && !$rfq->quotes->where('is_selected', true)->count())
                                @can('create_purchase_orders')
                                <form method="POST" action="{{ route('app.rfqs.select-quote', [$rfq, $quote]) }}">
                                    @csrf
                                    <button type="submit" class="text-xs px-3 py-1 bg-blue-700 text-white rounded hover:bg-blue-800">Select & Create PO</button>
                                </form>
                                @endcan
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="px-6 py-6 text-center text-sm text-gray-500">No quotes submitted yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="space-y-4">
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
                <p class="text-sm font-medium text-gray-700 mb-3">Invited Vendors ({{ $rfq->vendors->count() }})</p>
                <div class="space-y-2">
                    @foreach($rfq->vendors as $vendor)
                    <div class="text-sm text-gray-900">{{ $vendor->name }}</div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
