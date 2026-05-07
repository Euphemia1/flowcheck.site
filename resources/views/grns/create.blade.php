<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Record Goods Receipt</h1>
        <a href="{{ route('app.grns.index') }}" class="text-sm text-gray-500 hover:text-gray-700">← Back</a>
    </div>

    <form method="POST" action="{{ route('app.grns.store') }}" enctype="multipart/form-data" x-data="grnForm()">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
                    <h2 class="text-base font-semibold text-gray-900 mb-4 pb-3 border-b border-gray-100">Receipt Details</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Purchase Order <span class="text-red-500">*</span></label>
                            <select name="purchase_order_id" required @change="loadPoItems($event)" class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">— Select PO —</option>
                                @foreach($pos as $po)
                                    <option value="{{ $po->id }}" data-items="{{ json_encode($po->items) }}" {{ (old('purchase_order_id') == $po->id || ($selectedPo && $selectedPo->id == $po->id)) ? 'selected' : '' }}>
                                        {{ $po->po_number }} — {{ $po->vendor->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                            <textarea name="notes" rows="2" class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('notes') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Delivery Note (PDF/image)</label>
                            <input type="file" name="delivery_note" accept=".pdf,.jpg,.jpeg,.png" class="text-sm text-gray-600 file:mr-3 file:px-3 file:py-1 file:border file:border-gray-300 file:rounded file:text-sm file:bg-white hover:file:bg-gray-50">
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
                    <h2 class="text-base font-semibold text-gray-900 mb-4 pb-3 border-b border-gray-100">Items Received</h2>
                    <div x-show="items.length === 0" class="text-center text-sm text-gray-500 py-6">Select a Purchase Order above to load items.</div>
                    <div x-show="items.length > 0" class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead><tr class="text-xs font-medium text-gray-500 uppercase">
                                <th class="pb-2 text-left pr-2">Description</th>
                                <th class="pb-2 text-left pr-2 w-20">UoM</th>
                                <th class="pb-2 text-right pr-2 w-24">Ordered</th>
                                <th class="pb-2 text-right w-24">Received</th>
                            </tr></thead>
                            <tbody>
                                <template x-for="(item, index) in items" :key="index">
                                    <tr class="border-t border-gray-100">
                                        <td class="py-2 pr-2">
                                            <input type="hidden" :name="`items[${index}][purchase_order_item_id]`" :value="item.id">
                                            <input type="hidden" :name="`items[${index}][description]`" :value="item.description">
                                            <input type="hidden" :name="`items[${index}][quantity_ordered]`" :value="item.quantity_ordered">
                                            <input type="hidden" :name="`items[${index}][unit_of_measure]`" :value="item.unit_of_measure">
                                            <span x-text="item.description"></span>
                                        </td>
                                        <td class="py-2 pr-2 text-gray-500" x-text="item.unit_of_measure"></td>
                                        <td class="py-2 pr-2 text-right" x-text="item.quantity_ordered"></td>
                                        <td class="py-2">
                                            <input type="number" :name="`items[${index}][quantity_received]`" x-model.number="item.quantity_received" :max="item.quantity_ordered" min="0" step="0.01" required class="border border-gray-300 rounded px-2 py-1 text-sm w-24 text-right focus:outline-none focus:ring-1 focus:ring-blue-500">
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <button type="submit" x-show="items.length > 0" class="w-full px-4 py-2 bg-blue-700 text-white text-sm font-medium rounded-lg hover:bg-blue-800">Record Receipt</button>
                <a href="{{ route('app.grns.index') }}" class="block w-full px-4 py-2 text-center text-sm text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50">Cancel</a>
            </div>
        </div>
    </form>

    @push('scripts')
    <script>
    function grnForm() {
        return {
            items: [],
            loadPoItems(event) {
                const opt = event.target.selectedOptions[0];
                if (!opt || !opt.dataset.items) { this.items = []; return; }
                this.items = JSON.parse(opt.dataset.items).map(i => ({
                    id: i.id,
                    description: i.description,
                    unit_of_measure: i.unit_of_measure,
                    quantity_ordered: i.quantity_ordered,
                    quantity_received: i.quantity_ordered,
                }));
            }
        };
    }
    </script>
    @endpush
</x-app-layout>
