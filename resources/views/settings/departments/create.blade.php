<x-app-layout>
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('app.settings.departments.index') }}" class="text-sm text-gray-500 hover:text-gray-700">Departments</a>
        <span class="text-gray-300">/</span>
        <h1 class="text-2xl font-semibold text-gray-900">New Department</h1>
    </div>

    <div class="max-w-lg">
        <form method="POST" action="{{ route('app.settings.departments.store') }}">
            @csrf
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Department Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Code <span class="text-gray-400 font-normal">(optional, e.g. ENG)</span></label>
                    <input type="text" name="code" value="{{ old('code') }}" maxlength="10"
                           class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('code')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Department Manager</label>
                    <select name="manager_id" class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">— None —</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('manager_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('manager_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="flex gap-3 pt-1">
                    <button type="submit" class="px-4 py-2 bg-blue-700 text-white text-sm font-medium rounded-lg hover:bg-blue-800">Create Department</button>
                    <a href="{{ route('app.settings.departments.index') }}" class="px-4 py-2 text-sm text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
