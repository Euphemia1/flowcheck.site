<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <div>
            <a href="{{ route('app.tenders.index') }}" class="text-sm text-gray-500 hover:text-gray-700">← Tenders</a>
            <h1 class="text-2xl font-semibold text-gray-900 mt-1">{{ $tender->tender_number }}</h1>
        </div>
        <div class="flex gap-3">
            @if($tender->status === 'draft')
                @can('publish_tenders')
                <form method="POST" action="{{ route('app.tenders.publish', $tender) }}">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700">Publish</button>
                </form>
                @endcan
            @elseif($tender->status === 'published')
                @can('close_tenders')
                <form method="POST" action="{{ route('app.tenders.close', $tender) }}">
                    @csrf
                    <button type="submit" class="px-4 py-2 border border-gray-300 text-sm text-gray-700 rounded-lg hover:bg-gray-50">Close Tender</button>
                </form>
                @endcan
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div><span class="text-gray-500">Status</span><div class="mt-1">@include('components.status-badge', ['status' => $tender->status])</div></div>
                    <div><span class="text-gray-500">Type</span><p class="font-medium text-gray-900 mt-1">{{ $tender->type }}</p></div>
                    <div><span class="text-gray-500">Publication Date</span><p class="font-medium text-gray-900 mt-1">{{ $tender->publication_date->format('d M Y') }}</p></div>
                    <div><span class="text-gray-500">Closing Date</span><p class="font-medium {{ $tender->closing_date->isPast() ? 'text-red-600' : 'text-gray-900' }} mt-1">{{ $tender->closing_date->format('d M Y') }}</p></div>
                    @if($tender->boq)
                    <div class="col-span-2">
                        <span class="text-gray-500">Linked BOQ</span>
                        <div class="flex items-center gap-3 mt-1">
                            <a href="{{ route('app.boqs.show', $tender->boq) }}" class="font-medium text-blue-700 hover:underline">{{ $tender->boq->boq_number }} — {{ $tender->boq->project_name }}</a>
                            <a href="{{ route('app.boqs.pdf', $tender->boq) }}" class="text-xs text-gray-500 hover:underline">Download BOQ PDF</a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Submissions --}}
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h2 class="text-base font-semibold text-gray-900">Bid Submissions ({{ $tender->submissions->count() }})</h2>
                </div>
                <table class="w-full text-sm">
                    <thead class="bg-gray-50"><tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Vendor</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Bid Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Submitted</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3"></th>
                    </tr></thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($tender->submissions as $submission)
                        <tr class="hover:bg-gray-50 {{ $submission->status === 'awarded' ? 'bg-green-50' : '' }}">
                            <td class="px-6 py-3 font-medium text-gray-900">{{ $submission->vendor->name ?? 'Unknown Vendor' }}</td>
                            <td class="px-6 py-3 text-right">ZMW {{ number_format($submission->bid_amount, 2) }}</td>
                            <td class="px-6 py-3 text-gray-500">{{ $submission->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-3">@include('components.status-badge', ['status' => $submission->status ?? 'submitted'])</td>
                            <td class="px-6 py-3">
                                @if($tender->status === 'closed' && $submission->status !== 'awarded')
                                    @can('close_tenders')
                                    <form method="POST" action="{{ route('app.tenders.award', [$tender, $submission]) }}">
                                        @csrf
                                        <button type="submit" class="text-xs px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">Award</button>
                                    </form>
                                    @endcan
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="px-6 py-8 text-center text-sm text-gray-500">No bids submitted yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="space-y-4">
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6 text-sm space-y-2">
                <div class="flex justify-between"><span class="text-gray-500">Total Bids</span><span class="font-medium">{{ $tender->submissions->count() }}</span></div>
                @if($tender->submissions->count())
                <div class="flex justify-between"><span class="text-gray-500">Lowest Bid</span><span class="font-medium text-green-700">ZMW {{ number_format($tender->submissions->min('bid_amount'), 2) }}</span></div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
