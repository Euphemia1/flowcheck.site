<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Requests for Quotation</h1>
        @can('create_rfqs')
        <a href="{{ route('app.rfqs.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-700 text-white text-sm font-medium rounded-lg hover:bg-blue-800">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            New RFQ
        </a>
        @endcan
    </div>

    <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
        <table class="w-full text-left">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">RFQ Number</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Title</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Deadline</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Quotes</th>
                    <th class="px-6 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($rfqs as $rfq)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-medium text-blue-700">{{ $rfq->rfq_number }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $rfq->title }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $rfq->deadline->format('d M Y H:i') }}</td>
                    <td class="px-6 py-4">@include('components.status-badge', ['status' => $rfq->status])</td>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $rfq->quotes_count }}</td>
                    <td class="px-6 py-4"><a href="{{ route('app.rfqs.show', $rfq) }}" class="text-blue-700 hover:underline text-sm">View</a></td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-10 text-center text-sm text-gray-500">No RFQs yet.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4 border-t border-gray-100">{{ $rfqs->links() }}</div>
    </div>
</x-app-layout>
