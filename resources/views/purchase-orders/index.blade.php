<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Purchase Orders</h1>
        @can('create_purchase_orders')
        <a href="{{ route('app.purchase-orders.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-700 text-white text-sm font-medium rounded-lg hover:bg-blue-800">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            New Purchase Order
        </a>
        @endcan
    </div>

    
    <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
        <table class="w-full text-left">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">PO Number</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Vendor</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Amount (ZMW)</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($pos as $po)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-medium text-blue-700">{{ $po->po_number }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $po->vendor->name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ number_format($po->total_amount, 2) }}</td>
                    <td class="px-6 py-4">@include('components.status-badge', ['status' => $po->status])</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $po->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-4 text-sm">
                        <a href="{{ route('app.purchase-orders.show', $po) }}" class="text-blue-700 hover:underline">View</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-10 text-center text-sm text-gray-500">No purchase orders yet.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4 border-t border-gray-100">{{ $pos->links() }}</div>
    </div>
</x-app-layout>
