<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Tenders</h1>
        @can('create_tenders')
        <a href="{{ route('app.tenders.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-700 text-white text-sm font-medium rounded-lg hover:bg-blue-800">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            New Tender
        </a>
        @endcan
    </div>

    <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
        <table class="w-full text-left">
            <thead class="bg-gray-50"><tr>
                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Tender #</th>
                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Title</th>
                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Type</th>
                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Closing Date</th>
                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Bids</th>
                <th class="px-6 py-3"></th>
            </tr></thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($tenders as $tender)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-medium text-blue-700">{{ $tender->tender_number }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $tender->title }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $tender->type }}</td>
                    <td class="px-6 py-4 text-sm {{ $tender->closing_date->isPast() ? 'text-red-600' : 'text-gray-500' }}">{{ $tender->closing_date->format('d M Y') }}</td>
                    <td class="px-6 py-4">@include('components.status-badge', ['status' => $tender->status])</td>
                    <td class="px-6 py-4 text-sm text-right">{{ $tender->submissions_count }}</td>
                    <td class="px-6 py-4"><a href="{{ route('app.tenders.show', $tender) }}" class="text-sm text-blue-700 hover:underline">View</a></td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-6 py-10 text-center text-sm text-gray-500">No tenders yet.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4 border-t border-gray-100">{{ $tenders->links() }}</div>
    </div>
</x-app-layout>
