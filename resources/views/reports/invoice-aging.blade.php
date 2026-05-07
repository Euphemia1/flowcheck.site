<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('app.reports.index') }}" class="text-sm text-gray-500 hover:text-gray-700">Reports</a>
            <span class="text-gray-300">/</span>
            <h1 class="text-2xl font-semibold text-gray-900">Invoice Aging</h1>
        </div>
        <a href="{{ request()->fullUrlWithQuery(['export' => 1]) }}" class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 text-sm text-gray-700 rounded-lg hover:bg-gray-50">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Export Excel
        </a>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 mb-6">
        @foreach(['Current','1-30 Days','31-60 Days','61-90 Days','90+ Days','No Due Date'] as $bucket)
        @php $b = $buckets[$bucket] ?? ['count'=>0,'total'=>0]; @endphp
        <div class="bg-white rounded-lg border {{ in_array($bucket,['90+ Days','61-90 Days']) ? 'border-red-200' : (in_array($bucket,['31-60 Days']) ? 'border-amber-200' : 'border-gray-200') }} shadow-sm p-4 text-center">
            <p class="text-lg font-bold text-gray-900">{{ $b['count'] }}</p>
            <p class="text-xs font-medium text-gray-600">{{ $bucket }}</p>
            <p class="text-xs text-gray-500 mt-1">ZMW {{ number_format($b['total'], 0) }}</p>
        </div>
        @endforeach
    </div>

    <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">Invoice #</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">Vendor</th>
                    <th class="text-right px-4 py-3 font-medium text-gray-600">Amount</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">Status</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">Due Date</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">Aging</th>
                    <th class="text-right px-4 py-3 font-medium text-gray-600">Days Over</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($invoices as $inv)
                <tr class="hover:bg-gray-50 {{ $inv->days_overdue > 60 ? 'bg-red-50' : ($inv->days_overdue > 30 ? 'bg-amber-50' : '') }}">
                    <td class="px-4 py-3 font-mono text-xs">{{ $inv->invoice_number }}</td>
                    <td class="px-4 py-3 text-gray-900">{{ $inv->vendor?->name }}</td>
                    <td class="px-4 py-3 text-right font-medium text-gray-900">{{ number_format($inv->amount, 2) }}</td>
                    <td class="px-4 py-3"><x-status-badge :status="$inv->status"/></td>
                    <td class="px-4 py-3 text-gray-500 text-xs">{{ $inv->due_date?->toDateString() ?? '—' }}</td>
                    <td class="px-4 py-3">
                        <span class="text-xs px-2 py-0.5 rounded-full {{ $inv->aging_bucket === 'Current' ? 'bg-green-50 text-green-700' : ($inv->days_overdue > 60 ? 'bg-red-50 text-red-700' : 'bg-amber-50 text-amber-700') }}">
                            {{ $inv->aging_bucket }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-right {{ $inv->days_overdue > 0 ? 'text-red-600 font-medium' : 'text-gray-500' }}">{{ $inv->days_overdue ?: '—' }}</td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-4 py-10 text-center text-gray-500">No outstanding invoices.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
