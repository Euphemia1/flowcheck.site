<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('app.settings.index') }}" class="text-sm text-gray-500 hover:text-gray-700">Settings</a>
            <span class="text-gray-300">/</span>
            <h1 class="text-2xl font-semibold text-gray-900">Approval Workflows</h1>
        </div>
        <a href="{{ route('app.settings.workflows.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-700 text-white text-sm font-medium rounded-lg hover:bg-blue-800">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            New Workflow
        </a>
    </div>

    <div class="space-y-4">
        @forelse($workflows as $wf)
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
            <div class="flex justify-between items-start">
                <div class="flex-1">
                    <h3 class="text-sm font-semibold text-gray-900">{{ $wf->name }}</h3>
                    <p class="text-xs text-gray-500 mt-1">
                        @if($wf->department) Department: {{ $wf->department->name }} · @endif
                        Amount: {{ $wf->min_amount ? 'ZMW ' . number_format($wf->min_amount, 2) : '0' }}
                        — {{ $wf->max_amount ? 'ZMW ' . number_format($wf->max_amount, 2) : 'unlimited' }}
                    </p>
                    <div class="flex items-center gap-2 mt-3 flex-wrap">
                        @foreach($wf->steps ?? [] as $step)
                        <div class="flex items-center gap-1">
                            @if(!$loop->first)
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            @endif
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                                Step {{ $step['step'] }}: {{ ucwords(str_replace('_',' ', $step['role'] ?? $step['approver_type'])) }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="flex gap-2 ml-4">
                    <a href="{{ route('app.settings.workflows.edit', $wf) }}" class="text-xs text-blue-700 hover:underline">Edit</a>
                    <form method="POST" action="{{ route('app.settings.workflows.destroy', $wf) }}" onsubmit="return confirm('Delete this workflow?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-xs text-red-600 hover:underline">Delete</button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-10 text-center text-sm text-gray-500">
            No approval workflows configured yet.
        </div>
        @endforelse
    </div>
</x-app-layout>
