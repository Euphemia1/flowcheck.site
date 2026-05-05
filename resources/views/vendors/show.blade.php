<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $vendor->name }}</h2>
                <p class="text-sm text-gray-500 mt-1">
                    @if($vendor->is_approved)
                        <span class="px-2 py-0.5 rounded-full text-xs bg-green-100 text-green-800 font-semibold">Approved</span>
                    @else
                        <span class="px-2 py-0.5 rounded-full text-xs bg-yellow-100 text-yellow-800 font-semibold">Pending Approval</span>
                    @endif
                </p>
            </div>
            <div class="flex gap-2">
                @if(!$vendor->is_approved)
                    <form method="POST" action="{{ route('app.vendors.approve', $vendor) }}">
                        @csrf
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 text-sm">
                            Approve Vendor
                        </button>
                    </form>
                @endif
                <a href="{{ route('app.vendors.edit', $vendor) }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 text-sm">
                    Edit
                </a>
                <a href="{{ route('app.vendors.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 text-sm">
                    Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Vendor Details --}}
            <div class="lg:col-span-2 bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Vendor Details</h3>
                <dl class="grid grid-cols-2 gap-4">
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase">Contact Person</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $vendor->contact_person ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase">Email</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $vendor->email ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase">Phone</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $vendor->phone ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase">ZRA Tax PIN</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $vendor->tax_pin ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase">Payment Terms</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $vendor->payment_terms ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase">Performance Score</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $vendor->performance_score }}%</dd>
                    </div>
                    <div class="col-span-2">
                        <dt class="text-xs font-medium text-gray-500 uppercase">Address</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $vendor->address ?? '-' }}</dd>
                    </div>
                </dl>
            </div>

            {{-- Bank Details --}}
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Bank Details</h3>
                @if($vendor->bank_details)
                    <dl class="space-y-3">
                        @foreach($vendor->bank_details as $key => $value)
                            <div>
                                <dt class="text-xs font-medium text-gray-500 uppercase">{{ ucwords(str_replace('_', ' ', $key)) }}</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $value ?? '-' }}</dd>
                            </div>
                        @endforeach
                    </dl>
                @else
                    <p class="text-sm text-gray-400 italic">No bank details on file.</p>
                @endif
            </div>
        </div>

        {{-- Purchase Orders --}}
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-800">Purchase Orders</h3>
                <span class="text-sm text-gray-500">{{ $vendor->purchaseOrders->count() }} total</span>
            </div>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">PO Number</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount (ZMW)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($vendor->purchaseOrders as $po)
                        <tr>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $po->po_number }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ number_format($po->total_amount, 2) }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">
                                    {{ ucfirst(str_replace('_', ' ', $po->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $po->created_at->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-sm text-gray-400 italic">No purchase orders yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Invoices --}}
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-800">Invoices</h3>
                <span class="text-sm text-gray-500">{{ $vendor->invoices->count() }} total</span>
            </div>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Invoice #</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount (ZMW)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Due Date</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($vendor->invoices as $invoice)
                        <tr>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                <a href="{{ route('app.invoices.show', $invoice) }}" class="text-blue-600 hover:underline">
                                    {{ $invoice->internal_invoice_number }}
                                </a>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ number_format($invoice->total_amount, 2) }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold
                                    @if($invoice->status === 'paid') bg-green-100 text-green-800
                                    @elseif($invoice->status === 'disputed') bg-red-100 text-red-800
                                    @elseif(str_contains($invoice->status, 'approved')) bg-blue-100 text-blue-800
                                    @else bg-gray-100 text-gray-700
                                    @endif">
                                    {{ ucfirst(str_replace('_', ' ', $invoice->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $invoice->due_date ? $invoice->due_date->format('d M Y') : '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-sm text-gray-400 italic">No invoices yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>
