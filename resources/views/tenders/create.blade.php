<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">New Tender</h1>
        <a href="{{ route('app.tenders.index') }}" class="text-sm text-gray-500 hover:text-gray-700">← Back</a>
    </div>

    <form method="POST" action="{{ route('app.tenders.store') }}">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6 space-y-4">
                    <h2 class="text-base font-semibold text-gray-900 pb-3 border-b border-gray-100">Tender Details</h2>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Title <span class="text-red-500">*</span></label>
                        <input type="text" name="title" value="{{ old('title') }}" required class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tender Type (ZPPA) <span class="text-red-500">*</span></label>
                        <select name="type" required class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">— Select Type —</option>
                            @foreach(['Open International','Open National','Restricted','Request for Quotations','Direct Bidding','Community Participation'] as $type)
                            <option value="{{ $type }}" {{ old('type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                        @error('type')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Publication Date <span class="text-red-500">*</span></label>
                            <input type="date" name="publication_date" value="{{ old('publication_date', now()->format('Y-m-d')) }}" required class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Closing Date <span class="text-red-500">*</span></label>
                            <input type="date" name="closing_date" value="{{ old('closing_date') }}" required class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('closing_date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Link to BOQ (optional)</label>
                        <select name="boq_id" class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">— None —</option>
                            @foreach($boqs as $boq)
                            <option value="{{ $boq->id }}" {{ old('boq_id', request('boq')) == $boq->id ? 'selected' : '' }}>{{ $boq->boq_number }} — {{ $boq->project_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-sm text-blue-700">
                    <p class="font-medium mb-1">ZPPA Tender Types</p>
                    <ul class="text-xs space-y-1 text-blue-600">
                        <li>• Open International: &gt; ZMW 5M</li>
                        <li>• Open National: ZMW 1M–5M</li>
                        <li>• Restricted: ZMW 500k–1M</li>
                        <li>• RFQ: ZMW 100k–500k</li>
                        <li>• Direct Bidding: &lt; ZMW 100k</li>
                    </ul>
                </div>
                <button type="submit" class="w-full px-4 py-2 bg-blue-700 text-white text-sm font-medium rounded-lg hover:bg-blue-800">Create Tender</button>
                <a href="{{ route('app.tenders.index') }}" class="block w-full px-4 py-2 text-center text-sm text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50">Cancel</a>
            </div>
        </div>
    </form>
</x-app-layout>
