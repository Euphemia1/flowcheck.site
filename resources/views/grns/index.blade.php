<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Goods Receipt Notes</h1>
        @can('create_grns')
        <a href="{{ route('app.grns.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-700 text-white text-sm font-medium rounded-lg hover:bg-blue-800">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Record Receipt
        </a>
        @endcan
    </div>

    <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
        <table class="w-full text-left">
            <thead class="bg-gray-50"><tr>
                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">GRN Number</th>
                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">PO Number</th>
                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Vendor</th>
                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Received</th>
                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3"></th>
            </tr></thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($grns as $grn)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-medium text-blue-700">{{ $grn->grn_number }}</td>
                    <td class="px-6 py-4 text-sm"><a href="{{ route('app.purchase-orders.show', $grn->purchaseOrder) }}" class="text-blue-700 hover:underline">{{ $grn->purchaseOrder->po_number }}</a></td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $grn->purchaseOrder->vendor->name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $grn->received_at?->format('d M Y') }}</td>
                    <td class="px-6 py-4">@include('components.status-badge', ['status' => $grn->status])</td>
                    <td class="px-6 py-4"><a href="{{ route('app.grns.show', $grn) }}" class="text-sm text-blue-700 hover:underline">View</a></td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-10 text-center text-sm text-gray-500">No goods receipts yet.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4 border-t border-gray-100">{{ $grns->links() }}</div>
    </div>
</x-app-layout>
