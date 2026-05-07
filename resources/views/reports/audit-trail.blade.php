<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('app.reports.index') }}" class="text-sm text-gray-500 hover:text-gray-700">Reports</a>
            <span class="text-gray-300">/</span>
            <h1 class="text-2xl font-semibold text-gray-900">Audit Trail</h1>
        </div>
        <a href="{{ request()->fullUrlWithQuery(['export' => 1]) }}" class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 text-sm text-gray-700 rounded-lg hover:bg-gray-50">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Export Excel
        </a>
    </div>

    <form method="GET" class="bg-white rounded-lg border border-gray-200 shadow-sm p-4 mb-6 flex flex-wrap gap-3 items-end">
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">From</label>
            <input type="date" name="from" value="{{ $from }}" class="border border-gray-300 rounded px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">To</label>
            <input type="date" name="to" value="{{ $to }}" class="border border-gray-300 rounded px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Model Type</label>
            <select name="model" class="border border-gray-300 rounded px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">— All —</option>
                @foreach($modelTypes as $mt)
                <option value="{{ $mt }}" {{ $model === $mt ? 'selected' : '' }}>{{ $mt }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">User</label>
            <select name="user_id" class="border border-gray-300 rounded px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">— All Users —</option>
                @foreach($users as $u)
                <option value="{{ $u->id }}" {{ $userId === $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="px-4 py-2 bg-blue-700 text-white text-sm rounded-lg hover:bg-blue-800">Filter</button>
    </form>

    <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">Timestamp</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">User</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">Action</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">Model</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">Changes</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($logs as $log)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-xs text-gray-500 whitespace-nowrap">{{ $log->created_at->format('Y-m-d H:i') }}</td>
                    <td class="px-4 py-3 text-gray-700">{{ $log->user?->name ?? 'System' }}</td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                            {{ str_contains($log->action,'created') ? 'bg-green-50 text-green-700' :
                               (str_contains($log->action,'deleted') ? 'bg-red-50 text-red-700' :
                               (str_contains($log->action,'approved') ? 'bg-blue-50 text-blue-700' : 'bg-gray-100 text-gray-600')) }}">
                            {{ $log->action }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-xs text-gray-500">{{ $log->model_type }}</td>
                    <td class="px-4 py-3 text-xs text-gray-400 max-w-xs truncate">
                        @if($log->changes)
                            {{ json_encode($log->changes) }}
                        @else
                            —
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-4 py-10 text-center text-gray-500">No audit entries found.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-4 py-3 border-t border-gray-100">{{ $logs->links() }}</div>
    </div>
</x-app-layout>
