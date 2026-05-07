<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Contracts</h1>
        @can('create_contracts')
        <a href="{{ route('app.contracts.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-700 text-white text-sm font-medium rounded-lg hover:bg-blue-800">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            New Contract
        </a>
        @endcan
    </div>

    <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
        <table class="w-full text-left">
            <thead class="bg-gray-50"><tr>
                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Contract #</th>
                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Title</th>
                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Vendor</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Value (ZMW)</th>
                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">End Date</th>
                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3"></th>
            </tr></thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($contracts as $contract)
                @php $daysLeft = now()->diffInDays($contract->end_date, false); @endphp
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-medium text-blue-700">{{ $contract->contract_number }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $contract->title }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $contract->vendor->name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900 text-right">{{ $contract->value ? number_format($contract->value, 2) : '—' }}</td>
                    <td class="px-6 py-4 text-sm">
                        <span class="{{ $daysLeft >= 0 && $daysLeft <= 30 ? 'text-amber-600 font-medium' : ($daysLeft < 0 ? 'text-red-600' : 'text-gray-500') }}">
                            {{ $contract->end_date->format('d M Y') }}
                            @if($daysLeft >= 0 && $daysLeft <= 30) ({{ $daysLeft }}d) @endif
                        </span>
                    </td>
                    <td class="px-6 py-4">@include('components.status-badge', ['status' => $contract->status])</td>
                    <td class="px-6 py-4"><a href="{{ route('app.contracts.show', $contract) }}" class="text-sm text-blue-700 hover:underline">View</a></td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-6 py-10 text-center text-sm text-gray-500">No contracts yet.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4 border-t border-gray-100">{{ $contracts->links() }}</div>
    </div>
</x-app-layout>
