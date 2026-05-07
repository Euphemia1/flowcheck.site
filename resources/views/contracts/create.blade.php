<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">New Contract</h1>
        <a href="{{ route('app.contracts.index') }}" class="text-sm text-gray-500 hover:text-gray-700">← Back</a>
    </div>

    <form method="POST" action="{{ route('app.contracts.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6 space-y-4">
                    <h2 class="text-base font-semibold text-gray-900 pb-3 border-b border-gray-100">Contract Details</h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Vendor <span class="text-red-500">*</span></label>
                            <select name="vendor_id" required class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">— Select Vendor —</option>
                                @foreach($vendors as $vendor)
                                    <option value="{{ $vendor->id }}" {{ old('vendor_id') == $vendor->id ? 'selected' : '' }}>{{ $vendor->name }}</option>
                                @endforeach
                            </select>
                            @error('vendor_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Contract Type</label>
                            <select name="type" class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="fixed_price" {{ old('type','fixed_price') == 'fixed_price' ? 'selected' : '' }}>Fixed Price</option>
                                <option value="rate_contract" {{ old('type') == 'rate_contract' ? 'selected' : '' }}>Rate Contract</option>
                                <option value="framework" {{ old('type') == 'framework' ? 'selected' : '' }}>Framework</option>
                            </select>
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Title <span class="text-red-500">*</span></label>
                            <input type="text" name="title" value="{{ old('title') }}" required class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Start Date <span class="text-red-500">*</span></label>
                            <input type="date" name="start_date" value="{{ old('start_date') }}" required class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">End Date <span class="text-red-500">*</span></label>
                            <input type="date" name="end_date" value="{{ old('end_date') }}" required class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('end_date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Contract Value (ZMW)</label>
                            <input type="number" name="value" value="{{ old('value') }}" min="0" step="0.01" class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Signed Contract (PDF)</label>
                            <input type="file" name="document" accept=".pdf" class="text-sm text-gray-600 file:mr-3 file:px-3 file:py-1 file:border file:border-gray-300 file:rounded file:text-sm file:bg-white hover:file:bg-gray-50">
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <button type="submit" class="w-full px-4 py-2 bg-blue-700 text-white text-sm font-medium rounded-lg hover:bg-blue-800">Create Contract</button>
                <a href="{{ route('app.contracts.index') }}" class="block w-full px-4 py-2 text-center text-sm text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50">Cancel</a>
            </div>
        </div>
    </form>
</x-app-layout>
