<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('app.settings.index') }}" class="text-sm text-gray-500 hover:text-gray-700">Settings</a>
            <span class="text-gray-300">/</span>
            <h1 class="text-2xl font-semibold text-gray-900">Departments</h1>
        </div>
        @can('manage_settings')
        <a href="{{ route('app.settings.departments.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-700 text-white text-sm font-medium rounded-lg hover:bg-blue-800">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            New Department
        </a>
        @endcan
    </div>

    <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">Name</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">Code</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">Manager</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">Budget Lines</th>
                    <th class="text-right px-4 py-3 font-medium text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($departments as $dept)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 font-medium text-gray-900">{{ $dept->name }}</td>
                    <td class="px-4 py-3 text-gray-500 font-mono text-xs">{{ $dept->code ?? '—' }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $dept->manager?->name ?? '—' }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $dept->budget_lines_count ?? 0 }}</td>
                    <td class="px-4 py-3 text-right">
                        @can('manage_settings')
                        <div class="flex justify-end gap-3">
                            <a href="{{ route('app.settings.departments.edit', $dept) }}" class="text-blue-700 hover:underline text-xs">Edit</a>
                            <form method="POST" action="{{ route('app.settings.departments.destroy', $dept) }}" onsubmit="return confirm('Delete {{ $dept->name }}? This cannot be undone.')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline text-xs">Delete</button>
                            </form>
                        </div>
                        @endcan
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-10 text-center text-gray-500">No departments yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
