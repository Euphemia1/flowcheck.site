<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <div>
            <a href="{{ route('app.contracts.index') }}" class="text-sm text-gray-500 hover:text-gray-700">← Contracts</a>
            <h1 class="text-2xl font-semibold text-gray-900 mt-1">{{ $contract->contract_number }}</h1>
        </div>
        <div class="flex gap-3">
            @if($contract->document_path)
            <a href="{{ route('app.contracts.show', $contract) }}?download=1" class="inline-flex items-center gap-2 px-3 py-2 border border-gray-300 text-sm text-gray-700 rounded-lg hover:bg-gray-50">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Download Contract
            </a>
            @endif
            @if(in_array($contract->status, ['draft','active','expiring_soon']))
                @can('close_contracts')
                <form method="POST" action="{{ route('app.contracts.close', $contract) }}" onsubmit="return confirm('Close this contract?')">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700">Close Contract</button>
                </form>
                @endcan
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
                <h2 class="text-base font-semibold text-gray-900 mb-4">Contract Information</h2>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div><span class="text-gray-500">Status</span><div class="mt-1">@include('components.status-badge', ['status' => $contract->status])</div></div>
                    <div><span class="text-gray-500">Type</span><p class="font-medium text-gray-900 mt-1 capitalize">{{ str_replace('_',' ',$contract->type) }}</p></div>
                    <div><span class="text-gray-500">Vendor</span><a href="{{ route('app.vendors.show', $contract->vendor) }}" class="font-medium text-blue-700 mt-1 block hover:underline">{{ $contract->vendor->name }}</a></div>
                    <div><span class="text-gray-500">Value</span><p class="font-medium text-gray-900 mt-1">{{ $contract->value ? 'ZMW ' . number_format($contract->value, 2) : '—' }}</p></div>
                    <div><span class="text-gray-500">Start Date</span><p class="font-medium text-gray-900 mt-1">{{ $contract->start_date->format('d M Y') }}</p></div>
                    <div><span class="text-gray-500">End Date</span>
                        @php $daysLeft = now()->diffInDays($contract->end_date, false); @endphp
                        <p class="font-medium mt-1 {{ $daysLeft >= 0 && $daysLeft <= 30 ? 'text-amber-600' : ($daysLeft < 0 ? 'text-red-600' : 'text-gray-900') }}">
                            {{ $contract->end_date->format('d M Y') }}
                            @if($daysLeft >= 0 && $daysLeft <= 30) <span class="text-xs">({{ $daysLeft }} days left)</span> @endif
                            @if($daysLeft < 0) <span class="text-xs">(expired)</span> @endif
                        </p>
                    </div>
                    <div><span class="text-gray-500">Created By</span><p class="font-medium text-gray-900 mt-1">{{ $contract->createdBy->name }}</p></div>
                    <div><span class="text-gray-500">Created On</span><p class="font-medium text-gray-900 mt-1">{{ $contract->created_at->format('d M Y') }}</p></div>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            @php $daysLeft = now()->diffInDays($contract->end_date, false); @endphp
            @if($daysLeft >= 0 && $daysLeft <= 30)
            <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 text-sm text-amber-700">
                <p class="font-medium">Expiring Soon</p>
                <p class="mt-1">This contract expires in {{ $daysLeft }} days.</p>
            </div>
            @elseif($daysLeft < 0)
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-sm text-red-700">
                <p class="font-medium">Expired</p>
                <p class="mt-1">This contract expired {{ abs($daysLeft) }} days ago.</p>
            </div>
            @endif
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6 text-sm space-y-3">
                <div class="flex justify-between"><span class="text-gray-500">Status</span>@include('components.status-badge', ['status' => $contract->status])</div>
                @if($contract->value)
                <div class="flex justify-between"><span class="text-gray-500">Value</span><span class="font-medium text-gray-900">ZMW {{ number_format($contract->value, 2) }}</span></div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
