<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('app.reports.index') }}" class="text-sm text-gray-500 hover:text-gray-700">Reports</a>
            <span class="text-gray-300">/</span>
            <h1 class="text-2xl font-semibold text-gray-900">Purchase Request Status</h1>
        </div>
        <a href="{{ request()->fullUrlWithQuery(['export' => 1]) }}" class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 text-sm text-gray-700 rounded-lg hover:bg-gray-50">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Export Excel
        </a>
    </div>

    <form method="GET" class="bg-white rounded-lg border border-gray-200 shadow-sm p-4 mb-6 flex flex-wrap gap-3 items-end">
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">From</label>
            <input type="date" name="from" value="{{ $from }}" class="border border-gray-300 rounded px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">To</label>
            <input type="date" name="to" value="{{ $to }}" class="border border-gray-300 rounded px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <button type="submit" class="px-4 py-2 bg-blue-700 text-white text-sm rounded-lg hover:bg-blue-800">Filter</button>
    </form>

    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-6">
        @foreach(['draft'=>'gray','submitted'=>'amber','approved'=>'green','rejected'=>'red'] as $status => $color)
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-4 text-center">
            <p class="text-2xl font-bold text-gray-900">{{ $summary[$status] ?? 0 }}</p>
            <p class="text-xs text-gray-500 mt-1">{{ ucwords($status) }}</p>
        </div>
        @endforeach
    </div>

    <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">PR Number</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">Title</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">Department</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">Requester</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">Status</th>
                    <th class="text-right px-4 py-3 font-medium text-gray-600">Amount</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($rows as $pr)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 font-mono text-xs text-blue-700">
                        <a href="{{ route('app.purchase-requests.show', $pr) }}">{{ $pr->pr_number }}</a>
                    </td>
                    <td class="px-4 py-3 text-gray-900 max-w-xs truncate">{{ $pr->title }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ $pr->department?->name ?? '—' }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ $pr->requester?->name ?? '—' }}</td>
                    <td class="px-4 py-3"><x-status-badge :status="$pr->status"/></td>
                    <td class="px-4 py-3 text-right text-gray-900">{{ number_format($pr->total_amount, 2) }}</td>
                    <td class="px-4 py-3 text-gray-500 text-xs">{{ $pr->created_at->toDateString() }}</td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-4 py-10 text-center text-gray-500">No PRs found.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-4 py-3 border-t border-gray-100">{{ $rows->links() }}</div>
    </div>
</x-app-layout>
