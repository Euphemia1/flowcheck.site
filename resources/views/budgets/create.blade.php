<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">New Budget Line</h1>
        <a href="{{ route('app.budgets.index') }}" class="text-sm text-gray-500 hover:text-gray-700">← Back</a>
    </div>
    <div class="max-w-xl">
        <form method="POST" action="{{ route('app.budgets.store') }}">
            @csrf
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Department <span class="text-red-500">*</span></label>
                    <select name="department_id" required class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">— Select Department —</option>
                        @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                        @endforeach
                    </select>
                    @error('department_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fiscal Year <span class="text-red-500">*</span></label>
                    <input type="number" name="fiscal_year" value="{{ old('fiscal_year', now()->year) }}" min="2000" max="2100" required class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                    <input type="text" name="category" value="{{ old('category', 'General') }}" class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Allocated Amount (ZMW) <span class="text-red-500">*</span></label>
                    <input type="number" name="allocated_amount" value="{{ old('allocated_amount') }}" min="0" step="0.01" required class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('allocated_amount')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="submit" class="px-4 py-2 bg-blue-700 text-white text-sm font-medium rounded-lg hover:bg-blue-800">Create Budget Line</button>
                    <a href="{{ route('app.budgets.index') }}" class="px-4 py-2 text-sm text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
