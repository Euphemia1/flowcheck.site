<x-app-layout>
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('app.settings.workflows.index') }}" class="text-sm text-gray-500 hover:text-gray-700">Workflows</a>
        <span class="text-gray-300">/</span>
        <h1 class="text-2xl font-semibold text-gray-900">New Approval Workflow</h1>
    </div>

    <form method="POST" action="{{ route('app.settings.workflows.store') }}" x-data="wfForm()">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6 space-y-4">
                    <h2 class="text-sm font-semibold text-gray-900 pb-3 border-b border-gray-100">Workflow Rules</h2>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Workflow Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Min Amount (ZMW)</label>
                            <input type="number" name="min_amount" value="{{ old('min_amount', 0) }}" min="0" step="0.01" class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Max Amount (ZMW, blank = unlimited)</label>
                            <input type="number" name="max_amount" value="{{ old('max_amount') }}" min="0" step="0.01" class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Department (blank = all departments)</label>
                        <select name="department_id" class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">— All Departments —</option>
                            @foreach($departments as $dept)
                            <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
                    <div class="flex justify-between items-center mb-4 pb-3 border-b border-gray-100">
                        <h2 class="text-sm font-semibold text-gray-900">Approval Steps</h2>
                        <button type="button" @click="addStep" class="text-sm text-blue-700 hover:underline">+ Add Step</button>
                    </div>
                    <div class="space-y-3">
                        <template x-for="(step, i) in steps" :key="i">
                            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg border border-gray-200">
                                <div class="w-6 h-6 rounded-full bg-blue-700 text-white text-xs flex items-center justify-center font-bold flex-shrink-0" x-text="i + 1"></div>
                                <input type="hidden" :name="`steps[${i}][step]`" :value="i + 1">
                                <select :name="`steps[${i}][approver_type]`" x-model="step.approver_type" class="border border-gray-300 rounded px-2 py-1 text-sm focus:ring-1 focus:ring-blue-500">
                                    <option value="role">By Role</option>
                                    <option value="user">Specific User</option>
                                </select>
                                <template x-if="step.approver_type === 'role'">
                                    <select :name="`steps[${i}][role]`" x-model="step.role" class="border border-gray-300 rounded px-2 py-1 text-sm flex-1 focus:ring-1 focus:ring-blue-500">
                                        @foreach($roles as $role)
                                        <option value="{{ $role }}">{{ ucwords(str_replace('_',' ',$role)) }}</option>
                                        @endforeach
                                    </select>
                                </template>
                                <template x-if="step.approver_type === 'user'">
                                    <select :name="`steps[${i}][user_id]`" x-model="step.user_id" class="border border-gray-300 rounded px-2 py-1 text-sm flex-1 focus:ring-1 focus:ring-blue-500">
                                        <option value="">— Select User —</option>
                                        @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                        @endforeach
                                    </select>
                                </template>
                                <button type="button" @click="removeStep(i)" x-show="steps.length > 1" class="text-red-400 hover:text-red-600 text-lg leading-none">×</button>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <button type="submit" class="w-full px-4 py-2 bg-blue-700 text-white text-sm font-medium rounded-lg hover:bg-blue-800">Save Workflow</button>
                <a href="{{ route('app.settings.workflows.index') }}" class="block w-full px-4 py-2 text-center text-sm text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50">Cancel</a>
            </div>
        </div>
    </form>

    @push('scripts')
    <script>
    function wfForm() {
        return {
            steps: [{ approver_type: 'role', role: 'department_head', user_id: '' }],
            addStep() { this.steps.push({ approver_type: 'role', role: 'procurement_manager', user_id: '' }); },
            removeStep(i) { if (this.steps.length > 1) this.steps.splice(i, 1); },
        };
    }
    </script>
    @endpush
</x-app-layout>
