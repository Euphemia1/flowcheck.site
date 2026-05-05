<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Purchase Request
        </h2>
    </x-slot>

    <form method="POST" action="{{ route('app.purchase-requests.store') }}" class="max-w-4xl">
        @csrf

        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Request Details</h3>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                    <input type="text" name="title" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                    <select name="department_id" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">Select a department</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Required By Date</label>
                    <input type="date" name="required_by_date" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Priority</label>
                    <select name="priority" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="low">Low</option>
                        <option value="normal" selected>Normal</option>
                        <option value="high">High</option>
                        <option value="urgent">Urgent</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"></textarea>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Line Items</h3>

            <div id="items-container" class="space-y-4 mb-4">
                <div class="item-row border border-gray-300 rounded-lg p-4">
                    <div class="grid grid-cols-2 gap-4 mb-3">
                        <input type="text" name="items[0][description]" placeholder="Description" required class="px-3 py-2 border border-gray-300 rounded">
                        <input type="text" name="items[0][category]" placeholder="Category" class="px-3 py-2 border border-gray-300 rounded">
                    </div>
                    <div class="grid grid-cols-4 gap-4">
                        <input type="text" name="items[0][unit_of_measure]" placeholder="Unit" required class="px-3 py-2 border border-gray-300 rounded">
                        <input type="number" name="items[0][quantity_requested]" placeholder="Qty" step="0.01" required class="px-3 py-2 border border-gray-300 rounded">
                        <input type="number" name="items[0][unit_price_estimated]" placeholder="Unit Price" step="0.01" required class="px-3 py-2 border border-gray-300 rounded">
                        <button type="button" onclick="removeItem(this)" class="text-red-600 hover:text-red-800">Remove</button>
                    </div>
                </div>
            </div>

            <button type="button" onclick="addItem()" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">
                + Add Line Item
            </button>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                Create PR
            </button>
            <a href="{{ route('app.purchase-requests.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400">
                Cancel
            </a>
        </div>
    </form>

    @push('scripts')
        <script>
            let itemCount = 1;

            function addItem() {
                const container = document.getElementById('items-container');
                const newItem = document.createElement('div');
                newItem.className = 'item-row border border-gray-300 rounded-lg p-4';
                newItem.innerHTML = `
                    <div class="grid grid-cols-2 gap-4 mb-3">
                        <input type="text" name="items[${itemCount}][description]" placeholder="Description" required class="px-3 py-2 border border-gray-300 rounded">
                        <input type="text" name="items[${itemCount}][category]" placeholder="Category" class="px-3 py-2 border border-gray-300 rounded">
                    </div>
                    <div class="grid grid-cols-4 gap-4">
                        <input type="text" name="items[${itemCount}][unit_of_measure]" placeholder="Unit" required class="px-3 py-2 border border-gray-300 rounded">
                        <input type="number" name="items[${itemCount}][quantity_requested]" placeholder="Qty" step="0.01" required class="px-3 py-2 border border-gray-300 rounded">
                        <input type="number" name="items[${itemCount}][unit_price_estimated]" placeholder="Unit Price" step="0.01" required class="px-3 py-2 border border-gray-300 rounded">
                        <button type="button" onclick="removeItem(this)" class="text-red-600 hover:text-red-800">Remove</button>
                    </div>
                `;
                container.appendChild(newItem);
                itemCount++;
            }

            function removeItem(btn) {
                btn.closest('.item-row').remove();
            }
        </script>
    @endpush
</x-app-layout>
