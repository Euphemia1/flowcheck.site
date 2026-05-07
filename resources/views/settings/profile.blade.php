<x-app-layout>
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('app.settings.index') }}" class="text-sm text-gray-500 hover:text-gray-700">Settings</a>
        <span class="text-gray-300">/</span>
        <h1 class="text-2xl font-semibold text-gray-900">Organisation Profile</h1>
    </div>

    <div class="max-w-2xl">
        <form method="POST" action="{{ route('app.settings.profile.update') }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Organisation Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $org->name) }}" required class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Currency</label>
                        <input type="text" name="currency" value="{{ old('currency', $org->currency) }}" maxlength="10" class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                        <input type="text" name="country" value="{{ old('country', $org->country) }}" maxlength="5" class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Industry</label>
                        <input type="text" name="industry" value="{{ old('industry', $org->industry) }}" class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Logo (JPG/PNG)</label>
                        <input type="file" name="logo" accept=".jpg,.jpeg,.png,.svg" class="text-sm text-gray-600 file:mr-3 file:px-3 file:py-1 file:border file:border-gray-300 file:rounded file:text-sm file:bg-white hover:file:bg-gray-50">
                    </div>
                </div>
                <button type="submit" class="px-4 py-2 bg-blue-700 text-white text-sm font-medium rounded-lg hover:bg-blue-800">Save Changes</button>
            </div>
        </form>
    </div>
</x-app-layout>
