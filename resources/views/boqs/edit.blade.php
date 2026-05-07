<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Edit BOQ — {{ $boq->boq_number }}</h1>
        <a href="{{ route('app.boqs.show', $boq) }}" class="text-sm text-gray-500 hover:text-gray-700">← Cancel</a>
    </div>

    <form method="POST" action="{{ route('app.boqs.update', $boq) }}" x-data="boqForm({{ json_encode($boq->items->map(fn($i) => ['category'=>$i->category,'description'=>$i->description,'unit_of_measure'=>$i->unit_of_measure,'quantity'=>$i->quantity,'unit_rate'=>$i->unit_rate,'amount'=>$i->total_amount])) }})">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
                    <h2 class="text-base font-semibold text-gray-900 mb-4 pb-3 border-b border-gray-100">BOQ Details</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Project Title <span class="text-red-500">*</span></label>
                            <input type="text" name="title" value="{{ old('title', $boq->project_name) }}" required class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea name="description" rows="2" class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $boq->description) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
                    <div class="flex justify-between items-center mb-4 pb-3 border-b border-gray-100">
                        <h2 class="text-base font-semibold text-gray-900">Line Items</h2>
                        <button type="button" @click="addItem" class="text-sm text-blue-700 hover:underline">+ Add Item</button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm min-w-[800px]">
                            <thead><tr class="text-xs font-medium text-gray-500 uppercase border-b border-gray-200">
                                <th class="pb-2 text-left pr-2 w-36">Category</th>
                                <th class="pb-2 text-left pr-2">Description</th>
                                <th class="pb-2 text-left pr-2 w-20">UoM</th>
                                <th class="pb-2 text-right pr-2 w-24">Qty</th>
                                <th class="pb-2 text-right pr-2 w-28">Unit Rate</th>
                                <th class="pb-2 text-right pr-2 w-32">Amount</th>
                                <th class="pb-2 w-8"></th>
                            </tr></thead>
                            <tbody>
                                <template x-for="(item, index) in items" :key="index">
                                    <tr class="border-t border-gray-100">
                                        <td class="py-2 pr-2">
                                            <select :name="`items[${index}][category]`" x-model="item.category" class="border border-gray-300 rounded px-2 py-1 text-xs w-full focus:ring-1 focus:ring-blue-500">
                                                @foreach(['Preliminaries','Excavation & Earthworks','Concrete Works','Masonry','Structural Steel','Roofing','Finishes','Plumbing','Electrical','External Works','Provisional Sums','Contingencies','General'] as $cat)
                                                <option value="{{ $cat }}">{{ $cat }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="py-2 pr-2"><input type="text" :name="`items[${index}][description]`" x-model="item.description" required class="border border-gray-300 rounded px-2 py-1 text-sm w-full focus:ring-1 focus:ring-blue-500"></td>
                                        <td class="py-2 pr-2"><input type="text" :name="`items[${index}][unit_of_measure]`" x-model="item.unit_of_measure" required class="border border-gray-300 rounded px-2 py-1 text-sm w-full focus:ring-1 focus:ring-blue-500"></td>
                                        <td class="py-2 pr-2"><input type="number" :name="`items[${index}][quantity]`" x-model.number="item.quantity" @input="calcTotal(item)" min="0.01" step="0.01" class="border border-gray-300 rounded px-2 py-1 text-sm w-full text-right focus:ring-1 focus:ring-blue-500"></td>
                                        <td class="py-2 pr-2"><input type="number" :name="`items[${index}][unit_rate]`" x-model.number="item.unit_rate" @input="calcTotal(item)" min="0" step="0.01" class="border border-gray-300 rounded px-2 py-1 text-sm w-full text-right focus:ring-1 focus:ring-blue-500"></td>
                                        <td class="py-2 pr-2 text-right font-medium text-gray-700" x-text="fmt(item.amount)"></td>
                                        <td class="py-2"><button type="button" @click="removeItem(index)" class="text-red-400 hover:text-red-600 text-lg" x-show="items.length > 1">×</button></td>
                                    </tr>
                                </template>
                            </tbody>
                            <tfoot class="border-t-2 border-gray-300">
                                <tr>
                                    <td colspan="5" class="pt-3 text-right font-semibold text-gray-700 pr-2">Grand Total (ZMW)</td>
                                    <td class="pt-3 text-right font-bold text-gray-900" x-text="fmt(grandTotal)"></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
                    <p class="text-sm text-gray-500 mb-1">Updated Total</p>
                    <p class="text-2xl font-bold text-gray-900" x-text="fmt(grandTotal)"></p>
                </div>
                <button type="submit" class="w-full px-4 py-2 bg-blue-700 text-white text-sm font-medium rounded-lg hover:bg-blue-800">Save Changes</button>
                <a href="{{ route('app.boqs.show', $boq) }}" class="block w-full px-4 py-2 text-center text-sm text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50">Cancel</a>
            </div>
        </div>
    </form>

    @push('scripts')
    <script>
    function boqForm(initialItems) {
        return {
            items: initialItems && initialItems.length ? initialItems : [{ category:'General', description:'', unit_of_measure:'', quantity:1, unit_rate:0, amount:0 }],
            get grandTotal() { return this.items.reduce((s,i)=>s+(i.amount||0),0); },
            addItem() { this.items.push({ category:'General', description:'', unit_of_measure:'', quantity:1, unit_rate:0, amount:0 }); },
            removeItem(i) { if(this.items.length>1) this.items.splice(i,1); },
            calcTotal(item) { item.amount=(parseFloat(item.quantity)||0)*(parseFloat(item.unit_rate)||0); },
            fmt(v) { return 'ZMW '+Number(v||0).toLocaleString('en-ZM',{minimumFractionDigits:2}); },
        };
    }
    </script>
    @endpush
</x-app-layout>
