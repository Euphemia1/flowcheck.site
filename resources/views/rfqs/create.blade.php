<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">New Request for Quotation</h1>
        <a href="{{ route('app.rfqs.index') }}" class="text-sm text-gray-500 hover:text-gray-700">← Back</a>
    </div>

    <form method="POST" action="{{ route('app.rfqs.store') }}">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
                    <h2 class="text-base font-semibold text-gray-900 mb-4 pb-3 border-b border-gray-100">RFQ Details</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Title <span class="text-red-500">*</span></label>
                            <input type="text" name="title" value="{{ old('title') }}" required class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea name="description" rows="3" class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Response Deadline <span class="text-red-500">*</span></label>
                            <input type="datetime-local" name="deadline" value="{{ old('deadline') }}" required class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Linked Purchase Request (optional)</label>
                            <select name="purchase_request_id" class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">— None —</option>
                                @foreach($prs as $pr)
                                    <option value="{{ $pr->id }}" {{ old('purchase_request_id') == $pr->id ? 'selected' : '' }}>{{ $pr->pr_number }} — {{ $pr->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
                    <h2 class="text-base font-semibold text-gray-900 mb-4 pb-3 border-b border-gray-100">Invite Vendors <span class="text-red-500">*</span></h2>
                    <p class="text-sm text-gray-500 mb-3">Select approved vendors to receive this RFQ.</p>
                    <div class="space-y-2">
                        @foreach($vendors as $vendor)
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 cursor-pointer hover:bg-gray-50">
                            <input type="checkbox" name="vendor_ids[]" value="{{ $vendor->id }}" {{ in_array($vendor->id, old('vendor_ids', [])) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-700 focus:ring-blue-500">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $vendor->name }}</p>
                                <p class="text-xs text-gray-500">{{ $vendor->email }}</p>
                            </div>
                        </label>
                        @endforeach
                    </div>
                    @error('vendor_ids') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="space-y-4">
                <button type="submit" class="w-full px-4 py-2 bg-blue-700 text-white text-sm font-medium rounded-lg hover:bg-blue-800">Send RFQ</button>
                <a href="{{ route('app.rfqs.index') }}" class="block w-full px-4 py-2 text-center text-sm text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50">Cancel</a>
            </div>
        </div>
    </form>
</x-app-layout>
