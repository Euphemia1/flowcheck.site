<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">New Purchase Order</h1>
        <a href="{{ route('app.purchase-orders.index') }}" class="text-sm text-gray-500 hover:text-gray-700">← Back to POs</a>
    </div>

    <form method="POST" action="{{ route('app.purchase-orders.store') }}" x-data="poForm()">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Left column --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- PO Details --}}
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
                    <h2 class="text-base font-semibold text-gray-900 mb-4 pb-3 border-b border-gray-100">Order Details</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Approved Purchase Request (optional)</label>
                            <select name="purchase_request_id" id="pr_select" class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-500" @change="loadPrItems($event)">
                                <option value="">— Select PR —</option>
                                @foreach($approvedPrs as $pr)
                                    <option value="{{ $pr->id }}" data-items="{{ json_encode($pr->items) }}" {{ old('purchase_request_id') == $pr->id ? 'selected' : '' }}>
                                        {{ $pr->pr_number }} — {{ $pr->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Vendor <span class="text-red-500">*</span></label>
                            <select name="vendor_id" required class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">— Select Vendor —</option>
                                @foreach($vendors as $vendor)
                                    <option value="{{ $vendor->id }}" {{ old('vendor_id') == $vendor->id ? 'selected' : '' }}>{{ $vendor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Expected Delivery Date <span class="text-red-500">*</span></label>
                            <input type="date" name="expected_delivery_date" value="{{ old('expected_delivery_date') }}" required class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Payment Terms</label>
                            <input type="text" name="payment_terms" value="{{ old('payment_terms', 'Net 30') }}" class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Delivery Address <span class="text-red-500">*</span></label>
                            <textarea name="delivery_address" rows="2" required class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('delivery_address') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Line Items --}}
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
                    <div class="flex justify-between items-center mb-4 pb-3 border-b border-gray-100">
                        <h2 class="text-base font-semibold text-gray-900">Line Items</h2>
                        <button type="button" @click="addItem" class="text-sm text-blue-700 hover:underline">+ Add Row</button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="text-xs font-medium text-gray-500 uppercase">
                                    <th class="pb-2 text-left pr-2">Description</th>
                                    <th class="pb-2 text-left pr-2 w-24">UoM</th>
                                    <th class="pb-2 text-right pr-2 w-24">Qty</th>
                                    <th class="pb-2 text-right pr-2 w-32">Unit Price</th>
                                    <th class="pb-2 text-right pr-2 w-32">Total</th>
                                    <th class="pb-2 w-8"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="(item, index) in items" :key="index">
                                    <tr class="border-t border-gray-100">
                                        <td class="py-2 pr-2">
                                            <input type="text" :name="`items[${index}][description]`" x-model="item.description" required class="border border-gray-300 rounded px-2 py-1 text-sm w-full focus:outline-none focus:ring-1 focus:ring-blue-500">
                                        </td>
                                        <td class="py-2 pr-2">
                                            <input type="text" :name="`items[${index}][unit_of_measure]`" x-model="item.unit_of_measure" required class="border border-gray-300 rounded px-2 py-1 text-sm w-full focus:outline-none focus:ring-1 focus:ring-blue-500">
                                        </td>
                                        <td class="py-2 pr-2">
                                            <input type="number" :name="`items[${index}][quantity]`" x-model.number="item.quantity" @input="calcTotal(item)" min="0.01" step="0.01" required class="border border-gray-300 rounded px-2 py-1 text-sm w-full text-right focus:outline-none focus:ring-1 focus:ring-blue-500">
                                        </td>
                                        <td class="py-2 pr-2">
                                            <input type="number" :name="`items[${index}][unit_price]`" x-model.number="item.unit_price" @input="calcTotal(item)" min="0" step="0.01" required class="border border-gray-300 rounded px-2 py-1 text-sm w-full text-right focus:outline-none focus:ring-1 focus:ring-blue-500">
                                        </td>
                                        <td class="py-2 pr-2 text-right text-gray-700" x-text="formatCurrency(item.total)"></td>
                                        <td class="py-2">
                                            <button type="button" @click="removeItem(index)" class="text-red-400 hover:text-red-600" x-show="items.length > 1">×</button>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                            <tfoot class="border-t-2 border-gray-200">
                                <tr>
                                    <td colspan="4" class="pt-2 text-right font-semibold text-gray-700 pr-2">Grand Total (ZMW)</td>
                                    <td class="pt-2 text-right font-bold text-gray-900" x-text="formatCurrency(grandTotal)"></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Right sidebar --}}
            <div class="space-y-4">
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
                    <h3 class="text-sm font-semibold text-gray-900 mb-3">Summary</h3>
                    <div class="text-2xl font-bold text-gray-900" x-text="formatCurrency(grandTotal)"></div>
                    <p class="text-xs text-gray-500 mt-1">Total Order Value</p>
                </div>
                <button type="submit" class="w-full px-4 py-2 bg-blue-700 text-white text-sm font-medium rounded-lg hover:bg-blue-800">
                    Create Purchase Order
                </button>
                <a href="{{ route('app.purchase-orders.index') }}" class="block w-full px-4 py-2 text-center text-sm text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50">Cancel</a>
            </div>
        </div>
    </form>

    @push('scripts')
    <script>
    function poForm() {
        return {
            items: [{ description: '', unit_of_measure: '', quantity: 1, unit_price: 0, total: 0 }],
            get grandTotal() { return this.items.reduce((s, i) => s + (i.total || 0), 0); },
            addItem() { this.items.push({ description: '', unit_of_measure: '', quantity: 1, unit_price: 0, total: 0 }); },
            removeItem(i) { if (this.items.length > 1) this.items.splice(i, 1); },
            calcTotal(item) { item.total = (parseFloat(item.quantity) || 0) * (parseFloat(item.unit_price) || 0); },
            formatCurrency(v) { return 'ZMW ' + Number(v || 0).toLocaleString('en-ZM', {minimumFractionDigits: 2}); },
            loadPrItems(event) {
                const opt = event.target.selectedOptions[0];
                if (!opt || !opt.dataset.items) return;
                const prItems = JSON.parse(opt.dataset.items);
                if (prItems.length) {
                    this.items = prItems.map(i => ({
                        description: i.description,
                        unit_of_measure: i.unit_of_measure,
                        quantity: i.quantity_requested,
                        unit_price: i.unit_price_estimated,
                        total: i.quantity_requested * i.unit_price_estimated
                    }));
                }
            }
        };
    }
    </script>
    @endpush
</x-app-layout>
