<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Budget Lines</h1>
        <div class="flex items-center gap-3">
            <form method="GET" class="flex items-center gap-2">
                <select name="fiscal_year" onchange="this.form.submit()" class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @for($y = now()->year + 1; $y >= now()->year - 3; $y--)
                    <option value="{{ $y }}" {{ $fiscalYear == $y ? 'selected' : '' }}>FY {{ $y }}</option>
                    @endfor
                </select>
            </form>
            @can('manage_budgets')
            <a href="{{ route('app.budgets.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-700 text-white text-sm font-medium rounded-lg hover:bg-blue-800">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                New Budget Line
            </a>
            @endcan
        </div>
    </div>

    <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
        <table class="w-full text-left">
            <thead class="bg-gray-50"><tr>
                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Department</th>
                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Category</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Allocated (ZMW)</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Spent (ZMW)</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Available (ZMW)</th>
                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Utilisation</th>
                <th class="px-6 py-3"></th>
            </tr></thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($budgets as $budget)
                @php
                    $pct = $budget->allocated_amount > 0 ? ($budget->spent_amount / $budget->allocated_amount) * 100 : 0;
                    $available = $budget->allocated_amount - $budget->spent_amount;
                    $barColor = $pct < 50 ? 'bg-green-500' : ($pct < 80 ? 'bg-amber-500' : 'bg-red-500');
                    $textColor = $pct < 50 ? 'text-green-700' : ($pct < 80 ? 'text-amber-700' : 'text-red-700');
                @endphp
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $budget->department->name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $budget->category }}</td>
                    <td class="px-6 py-4 text-sm text-right text-gray-900">{{ number_format($budget->allocated_amount, 2) }}</td>
                    <td class="px-6 py-4 text-sm text-right text-gray-900">{{ number_format($budget->spent_amount, 2) }}</td>
                    <td class="px-6 py-4 text-sm text-right font-medium {{ $available < 0 ? 'text-red-600' : 'text-gray-900' }}">{{ number_format($available, 2) }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <div class="flex-1 bg-gray-100 rounded-full h-2">
                                <div class="h-2 rounded-full {{ $barColor }}" style="width: {{ min(100, $pct) }}%"></div>
                            </div>
                            <span class="text-xs font-medium {{ $textColor }} w-10 text-right">{{ number_format($pct, 1) }}%</span>
                        </div>
                    </td>
                    <td class="px-6 py-4"><a href="{{ route('app.budgets.show', $budget) }}" class="text-sm text-blue-700 hover:underline">View</a></td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-6 py-10 text-center text-sm text-gray-500">No budget lines for FY {{ $fiscalYear }}.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
