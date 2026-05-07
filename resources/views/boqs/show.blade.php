<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <div>
            <a href="{{ route('app.boqs.index') }}" class="text-sm text-gray-500 hover:text-gray-700">← BOQs</a>
            <h1 class="text-2xl font-semibold text-gray-900 mt-1">{{ $boq->boq_number }}</h1>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('app.boqs.pdf', $boq) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-700 text-white text-sm font-medium rounded-lg hover:bg-blue-800">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Export PDF
            </a>
            @if($boq->status === 'draft')
                @can('update_boqs')
                <a href="{{ route('app.boqs.edit', $boq) }}" class="inline-flex items-center gap-2 px-3 py-2 border border-gray-300 text-sm text-gray-700 rounded-lg hover:bg-gray-50">Edit</a>
                @endcan
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            {{-- Header info --}}
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div><span class="text-gray-500">Project</span><p class="font-medium text-gray-900 mt-1">{{ $boq->project_name }}</p></div>
                    <div><span class="text-gray-500">Status</span><div class="mt-1">@include('components.status-badge', ['status' => $boq->status])</div></div>
                    <div><span class="text-gray-500">Created By</span><p class="font-medium text-gray-900 mt-1">{{ $boq->createdBy->name }}</p></div>
                    <div><span class="text-gray-500">Date</span><p class="font-medium text-gray-900 mt-1">{{ $boq->created_at->format('d M Y') }}</p></div>
                    @if($boq->description)
                    <div class="col-span-2"><span class="text-gray-500">Description</span><p class="mt-1 text-gray-900">{{ $boq->description }}</p></div>
                    @endif
                </div>
            </div>

            {{-- Items by category --}}
            @foreach($itemsByCategory as $category => $items)
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                    <h3 class="text-sm font-semibold text-gray-700">{{ $category }}</h3>
                </div>
                <table class="w-full text-sm">
                    <thead><tr class="text-xs font-medium text-gray-500 uppercase">
                        <th class="px-6 py-2 text-left">Description</th>
                        <th class="px-6 py-2 text-left w-20">UoM</th>
                        <th class="px-6 py-2 text-right w-24">Qty</th>
                        <th class="px-6 py-2 text-right w-28">Unit Rate</th>
                        <th class="px-6 py-2 text-right w-32">Amount</th>
                    </tr></thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($items as $item)
                        <tr>
                            <td class="px-6 py-2">{{ $item->description }}</td>
                            <td class="px-6 py-2 text-gray-500">{{ $item->unit_of_measure }}</td>
                            <td class="px-6 py-2 text-right">{{ number_format($item->quantity, 2) }}</td>
                            <td class="px-6 py-2 text-right">{{ number_format($item->unit_rate, 2) }}</td>
                            <td class="px-6 py-2 text-right font-medium">{{ number_format($item->total_amount, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="border-t border-gray-200 bg-gray-50">
                        <tr>
                            <td colspan="4" class="px-6 py-2 text-right text-xs font-medium text-gray-500 uppercase">Subtotal — {{ $category }}</td>
                            <td class="px-6 py-2 text-right font-semibold text-gray-900">{{ number_format($items->sum('total_amount'), 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            @endforeach
        </div>

        <div class="space-y-4">
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
                <p class="text-sm text-gray-500 mb-1">Grand Total</p>
                <p class="text-2xl font-bold text-gray-900">ZMW {{ number_format($boq->total_estimated_value, 2) }}</p>
                @php
                    $total = $boq->total_estimated_value;
                    $zppaMethod = $total < 100000 ? 'Direct Bidding' : ($total < 1000000 ? 'RFQ' : 'Open Tender');
                @endphp
                <div class="mt-3 p-3 bg-blue-50 rounded-lg">
                    <p class="text-xs font-medium text-blue-700">ZPPA Recommended Method</p>
                    <p class="text-sm font-bold text-blue-900 mt-1">{{ $zppaMethod }}</p>
                </div>
            </div>

            @if($boq->tenders->count())
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
                <p class="text-sm font-medium text-gray-700 mb-3">Linked Tenders</p>
                @foreach($boq->tenders as $tender)
                <a href="{{ route('app.tenders.show', $tender) }}" class="block text-sm text-blue-700 hover:underline">{{ $tender->tender_number }}</a>
                @endforeach
            </div>
            @endif

            @can('create_tenders')
            <a href="{{ route('app.tenders.create') }}?boq={{ $boq->id }}" class="block w-full px-4 py-2 text-center text-sm bg-blue-700 text-white font-medium rounded-lg hover:bg-blue-800">
                Create Tender from BOQ
            </a>
            @endcan
        </div>
    </div>
</x-app-layout>
