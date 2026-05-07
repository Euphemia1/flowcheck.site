<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <div>
            <a href="{{ route('app.budgets.index') }}" class="text-sm text-gray-500 hover:text-gray-700">← Budgets</a>
            <h1 class="text-2xl font-semibold text-gray-900 mt-1">{{ $budget->department->name }} — FY {{ $budget->fiscal_year }}</h1>
        </div>
    </div>

    @php
        $available = $budget->allocated_amount - $budget->spent_amount;
        $pct = $budget->allocated_amount > 0 ? ($budget->spent_amount / $budget->allocated_amount) * 100 : 0;
        $barColor = $pct < 50 ? 'bg-green-500' : ($pct < 80 ? 'bg-amber-500' : 'bg-red-500');
    @endphp

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-5">
            <p class="text-sm text-gray-500">Allocated</p>
            <p class="text-2xl font-bold text-gray-900 mt-1">ZMW {{ number_format($budget->allocated_amount, 2) }}</p>
        </div>
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-5">
            <p class="text-sm text-gray-500">Spent</p>
            <p class="text-2xl font-bold text-gray-900 mt-1">ZMW {{ number_format($budget->spent_amount, 2) }}</p>
        </div>
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-5">
            <p class="text-sm text-gray-500">Available</p>
            <p class="text-2xl font-bold {{ $available < 0 ? 'text-red-600' : 'text-green-700' }} mt-1">ZMW {{ number_format($available, 2) }}</p>
        </div>
    </div>

    <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
        <div class="flex justify-between items-center mb-2">
            <span class="text-sm font-medium text-gray-700">Budget Utilisation</span>
            <span class="text-sm font-bold text-gray-900">{{ number_format($pct, 1) }}%</span>
        </div>
        <div class="w-full bg-gray-100 rounded-full h-4">
            <div class="h-4 rounded-full {{ $barColor }} transition-all" style="width: {{ min(100, $pct) }}%"></div>
        </div>

        @can('manage_budgets')
        <form method="POST" action="{{ route('app.budgets.update', $budget) }}" class="mt-6 flex items-end gap-3">
            @csrf @method('PUT')
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">Revise Allocated Amount</label>
                <input type="number" name="allocated_amount" value="{{ $budget->allocated_amount }}" min="0" step="0.01" class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-700 text-white text-sm font-medium rounded-lg hover:bg-blue-800">Update</button>
        </form>
        @endcan
    </div>
</x-app-layout>
