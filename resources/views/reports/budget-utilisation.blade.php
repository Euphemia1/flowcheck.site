<x-app-layout>
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('app.reports.index') }}" class="text-sm text-gray-500 hover:text-gray-700">Reports</a>
        <span class="text-gray-300">/</span>
        <h1 class="text-2xl font-semibold text-gray-900">Budget Utilisation</h1>
    </div>

    <form method="GET" class="bg-white rounded-lg border border-gray-200 shadow-sm p-4 mb-6 flex gap-3 items-end">
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Fiscal Year</label>
            <select name="fiscal_year" class="border border-gray-300 rounded px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                @foreach($years as $yr)
                <option value="{{ $yr }}" {{ $yr == $fiscalYear ? 'selected' : '' }}>{{ $yr }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="px-4 py-2 bg-blue-700 text-white text-sm rounded-lg hover:bg-blue-800">Filter</button>
    </form>

    <div class="space-y-3">
        @forelse($budgets as $budget)
        @php
            $pct = $budget->utilisation_pct;
            $barColor = $pct >= 80 ? 'bg-red-500' : ($pct >= 50 ? 'bg-amber-500' : 'bg-green-500');
        @endphp
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-5">
            <div class="flex justify-between items-start mb-3">
                <div>
                    <h3 class="text-sm font-semibold text-gray-900">{{ $budget->department?->name ?? 'Unknown' }}</h3>
                    <p class="text-xs text-gray-500 mt-0.5">FY {{ $budget->fiscal_year }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm font-semibold text-gray-900">ZMW {{ number_format($budget->spent_amount, 2) }}</p>
                    <p class="text-xs text-gray-500">of ZMW {{ number_format($budget->total_amount, 2) }}</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="flex-1 bg-gray-200 rounded-full h-2">
                    <div class="{{ $barColor }} h-2 rounded-full transition-all" style="width: {{ min($pct, 100) }}%"></div>
                </div>
                <span class="text-xs font-medium {{ $pct >= 80 ? 'text-red-600' : ($pct >= 50 ? 'text-amber-600' : 'text-green-600') }} w-12 text-right">{{ $pct }}%</span>
            </div>
            <div class="flex justify-between text-xs text-gray-500 mt-2">
                <span>Remaining: ZMW {{ number_format($budget->total_amount - $budget->spent_amount, 2) }}</span>
                <a href="{{ route('app.budgets.show', $budget) }}" class="text-blue-700 hover:underline">View</a>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-10 text-center text-sm text-gray-500">
            No budgets for fiscal year {{ $fiscalYear }}.
        </div>
        @endforelse
    </div>
</x-app-layout>
