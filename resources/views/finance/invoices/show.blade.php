<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ $invoice->internal_invoice_number }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Vendor: {{ $invoice->vendor->name }}</p>
            </div>
            <div class="flex gap-2">
                @if($invoice->status === 'matched')
                    <form method="POST" action="{{ route('app.invoices.approve', $invoice) }}">
                        @csrf
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 text-sm">
                            Approve for Payment
                        </button>
                    </form>
                @endif
                <a href="{{ route('app.invoices.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 text-sm">
                    Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">

        {{-- Status Bar --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-lg shadow p-4">
                <p class="text-xs text-gray-500 uppercase font-medium">Invoice Status</p>
                <span class="mt-1 inline-block px-2 py-1 rounded-full text-sm font-semibold
                    @if($invoice->status === 'paid') bg-green-100 text-green-800
                    @elseif($invoice->status === 'approved_for_payment') bg-blue-100 text-blue-800
                    @elseif($invoice->status === 'disputed') bg-red-100 text-red-800
                    @else bg-gray-100 text-gray-700
                    @endif">
                    {{ ucfirst(str_replace('_', ' ', $invoice->status)) }}
                </span>
            </div>
            <div class="bg-white rounded-lg shadow p-4">
                <p class="text-xs text-gray-500 uppercase font-medium">3-Way Match</p>
                <span class="mt-1 inline-block px-2 py-1 rounded-full text-sm font-semibold
                    @if($invoice->matching_status === 'matched') bg-green-100 text-green-800
                    @elseif($invoice->matching_status === 'failed') bg-red-100 text-red-800
                    @elseif($invoice->matching_status === 'partial') bg-yellow-100 text-yellow-800
                    @else bg-gray-100 text-gray-600
                    @endif">
                    {{ ucfirst($invoice->matching_status) }}
                </span>
            </div>
            <div class="bg-white rounded-lg shadow p-4">
                <p class="text-xs text-gray-500 uppercase font-medium">Total Amount</p>
                <p class="mt-1 text-lg font-bold text-gray-900">ZMW {{ number_format($invoice->total_amount, 2) }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-4">
                <p class="text-xs text-gray-500 uppercase font-medium">Due Date</p>
                <p class="mt-1 text-sm font-medium text-gray-900">
                    {{ $invoice->due_date ? $invoice->due_date->format('d M Y') : '-' }}
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- Invoice Details --}}
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Invoice Details</h3>
                <dl class="space-y-3">
                    <div class="flex justify-between">
                        <dt class="text-sm text-gray-500">Internal Reference</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $invoice->internal_invoice_number }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-sm text-gray-500">Vendor Invoice #</dt>
                        <dd class="text-sm text-gray-900">{{ $invoice->invoice_number ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-sm text-gray-500">Vendor</dt>
                        <dd class="text-sm text-gray-900">
                            <a href="{{ route('app.vendors.show', $invoice->vendor) }}" class="text-blue-600 hover:underline">
                                {{ $invoice->vendor->name }}
                            </a>
                        </dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-sm text-gray-500">Linked PO</dt>
                        <dd class="text-sm text-gray-900">{{ $invoice->purchaseOrder?->po_number ?? 'None' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-sm text-gray-500">Invoice Date</dt>
                        <dd class="text-sm text-gray-900">{{ $invoice->invoice_date ? $invoice->invoice_date->format('d M Y') : '-' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-sm text-gray-500">Due Date</dt>
                        <dd class="text-sm text-gray-900">{{ $invoice->due_date ? $invoice->due_date->format('d M Y') : '-' }}</dd>
                    </div>
                    <div class="flex justify-between border-t pt-3 mt-3">
                        <dt class="text-sm font-semibold text-gray-700">Total Amount</dt>
                        <dd class="text-sm font-bold text-gray-900">ZMW {{ number_format($invoice->total_amount, 2) }}</dd>
                    </div>
                </dl>

                @if($invoice->file_path)
                    <div class="mt-4 pt-4 border-t">
                        <a href="{{ Storage::url($invoice->file_path) }}" target="_blank"
                            class="inline-flex items-center gap-1 text-blue-600 hover:underline text-sm">
                            View Invoice Document &rarr;
                        </a>
                    </div>
                @endif
            </div>

            {{-- 3-Way Matching Results --}}
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">3-Way Matching Results (SI 68)</h3>
                @forelse($invoice->matchingResults as $result)
                    <div class="border border-gray-200 rounded-lg p-4 mb-3">
                        <div class="grid grid-cols-3 gap-2 text-xs mb-2">
                            <div class="text-center">
                                <p class="text-gray-400 uppercase font-medium mb-1">Invoiced</p>
                                <p class="font-semibold text-gray-800">{{ number_format($result->qty_invoiced, 2) }} units</p>
                                <p class="text-gray-600">ZMW {{ number_format($result->price_invoiced, 2) }}</p>
                            </div>
                            <div class="text-center border-x border-gray-100">
                                <p class="text-gray-400 uppercase font-medium mb-1">Ordered (PO)</p>
                                <p class="font-semibold text-gray-800">{{ number_format($result->qty_ordered ?? 0, 2) }} units</p>
                                <p class="text-gray-600">ZMW {{ number_format($result->price_po ?? 0, 2) }}</p>
                            </div>
                            <div class="text-center">
                                <p class="text-gray-400 uppercase font-medium mb-1">Received (GRN)</p>
                                <p class="font-semibold text-gray-800">{{ number_format($result->qty_received ?? 0, 2) }} units</p>
                            </div>
                        </div>
                        <div class="flex gap-3 mt-2">
                            <span class="flex items-center gap-1 text-xs
                                {{ $result->qty_match ? 'text-green-600' : 'text-red-600' }}">
                                {{ $result->qty_match ? '✓' : '✗' }} Qty Match
                            </span>
                            <span class="flex items-center gap-1 text-xs
                                {{ $result->price_match ? 'text-green-600' : 'text-red-600' }}">
                                {{ $result->price_match ? '✓' : '✗' }} Price Match
                            </span>
                        </div>
                        @if($result->notes)
                            <p class="text-xs text-gray-500 mt-2 italic">{{ $result->notes }}</p>
                        @endif
                    </div>
                @empty
                    @if($invoice->purchaseOrder)
                        <div class="text-center py-6 text-sm text-gray-400">
                            <p>Matching not yet performed.</p>
                        </div>
                    @else
                        <div class="text-center py-6 text-sm text-gray-400">
                            <p>No PO linked — 3-way matching not applicable.</p>
                            <p class="mt-1 text-xs">Link this invoice to a Purchase Order to enable SI 68 compliance matching.</p>
                        </div>
                    @endif
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
