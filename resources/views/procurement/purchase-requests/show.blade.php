<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ $purchaseRequest->pr_number }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">{{ $purchaseRequest->title }}</p>
            </div>
            <div class="flex gap-2">
                @if($purchaseRequest->status === 'draft')
                    <form method="POST" action="{{ route('app.purchase-requests.submit', $purchaseRequest) }}">
                        @csrf
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm">
                            Submit for Approval
                        </button>
                    </form>
                @endif

                @if($purchaseRequest->status === 'under_review' && Auth::id() === $purchaseRequest->current_approver_id)
                    <form method="POST" action="{{ route('app.purchase-requests.approve', $purchaseRequest) }}">
                        @csrf
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 text-sm">
                            Approve
                        </button>
                    </form>
                    <form method="POST" action="{{ route('app.purchase-requests.reject', $purchaseRequest) }}">
                        @csrf
                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 text-sm"
                            onclick="return confirm('Reject this purchase request?')">
                            Reject
                        </button>
                    </form>
                @endif

                <a href="{{ route('app.purchase-requests.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 text-sm">
                    Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">

        {{-- Status Banner --}}
        <div class="rounded-lg px-4 py-3
            @if($purchaseRequest->status === 'approved') bg-green-50 border border-green-200
            @elseif($purchaseRequest->status === 'rejected') bg-red-50 border border-red-200
            @elseif($purchaseRequest->status === 'under_review') bg-yellow-50 border border-yellow-200
            @else bg-gray-50 border border-gray-200
            @endif">
            <div class="flex items-center justify-between">
                <span class="font-medium text-sm
                    @if($purchaseRequest->status === 'approved') text-green-800
                    @elseif($purchaseRequest->status === 'rejected') text-red-800
                    @elseif($purchaseRequest->status === 'under_review') text-yellow-800
                    @else text-gray-800
                    @endif">
                    Status: {{ ucfirst(str_replace('_', ' ', $purchaseRequest->status)) }}
                </span>
                @if($purchaseRequest->currentApprover)
                    <span class="text-sm text-gray-600">
                        Awaiting approval from: <strong>{{ $purchaseRequest->currentApprover->name }}</strong>
                    </span>
                @endif
            </div>
        </div>

        {{-- Details Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Main Info --}}
            <div class="lg:col-span-2 bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Request Details</h3>
                <dl class="grid grid-cols-2 gap-4">
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase">Requested By</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $purchaseRequest->requester->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase">Department</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $purchaseRequest->department?->name ?? 'N/A' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase">Priority</dt>
                        <dd class="mt-1">
                            <span class="px-2 py-1 rounded text-xs font-semibold
                                @if($purchaseRequest->priority === 'urgent') bg-red-100 text-red-800
                                @elseif($purchaseRequest->priority === 'high') bg-orange-100 text-orange-800
                                @elseif($purchaseRequest->priority === 'normal') bg-blue-100 text-blue-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($purchaseRequest->priority) }}
                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase">Required By</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $purchaseRequest->required_by_date?->format('d M Y') ?? 'Not specified' }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase">Created</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $purchaseRequest->created_at->format('d M Y H:i') }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase">Total Estimated</dt>
                        <dd class="mt-1 text-sm font-bold text-gray-900">ZMW {{ number_format($purchaseRequest->total_estimated_amount, 2) }}</dd>
                    </div>
                </dl>

                @if($purchaseRequest->description)
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <dt class="text-xs font-medium text-gray-500 uppercase mb-1">Description</dt>
                        <dd class="text-sm text-gray-700">{{ $purchaseRequest->description }}</dd>
                    </div>
                @endif

                @if($purchaseRequest->justification)
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <dt class="text-xs font-medium text-gray-500 uppercase mb-1">Justification</dt>
                        <dd class="text-sm text-gray-700">{{ $purchaseRequest->justification }}</dd>
                    </div>
                @endif
            </div>

            {{-- Approval Trail --}}
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Approval Trail</h3>
                @forelse($purchaseRequest->approvalLogs as $log)
                    <div class="flex gap-3 mb-4">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold
                            @if($log->action === 'approved') bg-green-100 text-green-700
                            @elseif($log->action === 'rejected') bg-red-100 text-red-700
                            @else bg-gray-100 text-gray-700
                            @endif">
                            {{ strtoupper(substr($log->approver->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $log->approver->name }}</p>
                            <p class="text-xs text-gray-500">
                                {{ ucfirst($log->action) }} &middot; {{ \Carbon\Carbon::parse($log->timestamp)->format('d M Y H:i') }}
                            </p>
                            @if($log->comments)
                                <p class="text-xs text-gray-600 mt-1 italic">"{{ $log->comments }}"</p>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-400 italic">No approvals yet.</p>
                @endforelse
            </div>
        </div>

        {{-- Line Items --}}
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Line Items</h3>
            </div>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Unit</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Qty</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Unit Price (ZMW)</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total (ZMW)</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($purchaseRequest->items as $i => $item)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $i + 1 }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $item->description }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $item->category ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $item->unit_of_measure }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900 text-right">{{ number_format($item->quantity_requested, 2) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900 text-right">{{ number_format($item->unit_price_estimated, 2) }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 text-right">{{ number_format($item->total_estimated, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50">
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-sm font-semibold text-gray-700 text-right">Total Estimated:</td>
                        <td class="px-6 py-4 text-sm font-bold text-gray-900 text-right">
                            ZMW {{ number_format($purchaseRequest->total_estimated_amount, 2) }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

    </div>
</x-app-layout>
