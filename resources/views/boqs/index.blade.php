<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Bills of Quantities</h1>
        @can('create_boqs')
        <a href="{{ route('app.boqs.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-700 text-white text-sm font-medium rounded-lg hover:bg-blue-800">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            New BOQ
        </a>
        @endcan
    </div>

    <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
        <table class="w-full text-left">
            <thead class="bg-gray-50"><tr>
                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">BOQ Number</th>
                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Project</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total (ZMW)</th>
                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Created</th>
                <th class="px-6 py-3"></th>
            </tr></thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($boqs as $boq)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-medium text-blue-700">{{ $boq->boq_number }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $boq->project_name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900 text-right">{{ number_format($boq->total_estimated_value, 2) }}</td>
                    <td class="px-6 py-4">@include('components.status-badge', ['status' => $boq->status])</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $boq->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-4 flex gap-2">
                        <a href="{{ route('app.boqs.show', $boq) }}" class="text-sm text-blue-700 hover:underline">View</a>
                        <a href="{{ route('app.boqs.pdf', $boq) }}" class="text-sm text-gray-500 hover:underline">PDF</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-10 text-center text-sm text-gray-500">No BOQs yet. Create one to get started.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4 border-t border-gray-100">{{ $boqs->links() }}</div>
    </div>
</x-app-layout>
