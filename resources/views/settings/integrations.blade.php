<x-app-layout>
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('app.settings.index') }}" class="text-sm text-gray-500 hover:text-gray-700">Settings</a>
        <span class="text-gray-300">/</span>
        <h1 class="text-2xl font-semibold text-gray-900">Integrations</h1>
    </div>

    <div class="space-y-4">
        {{-- ZPPA --}}
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
            <div class="flex items-start justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900">ZPPA e-GP Portal</h3>
                        <p class="text-xs text-gray-500 mt-0.5">Zambia Public Procurement Authority — vendor verification & tender submissions</p>
                    </div>
                </div>
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-500">Coming Soon</span>
            </div>
            <div class="mt-4 border-t border-gray-100 pt-4">
                <p class="text-xs text-gray-500">ZPPA API credentials will be configured here once the integration is live. Contact support to enable early access.</p>
            </div>
        </div>

        {{-- ZIHRM --}}
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
            <div class="flex items-start justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900">Zambia IHRM</h3>
                        <p class="text-xs text-gray-500 mt-0.5">Sync departments and employee records for approver assignment</p>
                    </div>
                </div>
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-500">Coming Soon</span>
            </div>
            <div class="mt-4 border-t border-gray-100 pt-4">
                <p class="text-xs text-gray-500">Connect your HR system to automatically sync departments and staff for approval routing.</p>
            </div>
        </div>

        {{-- ZIPPS --}}
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
            <div class="flex items-start justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900">ZIPPS Payment Portal</h3>
                        <p class="text-xs text-gray-500 mt-0.5">Post approved invoices directly to the Zambia Integrated Payment Portal</p>
                    </div>
                </div>
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-500">Coming Soon</span>
            </div>
            <div class="mt-4 border-t border-gray-100 pt-4">
                <p class="text-xs text-gray-500">Automatically submit approved invoices to ZIPPS for payment processing without manual re-entry.</p>
            </div>
        </div>
    </div>

    <p class="mt-6 text-xs text-gray-400 text-center">
        To enable or configure an integration, contact <a href="mailto:support@flowcheck.ai" class="text-blue-700 hover:underline">support@flowcheck.ai</a>
    </p>
</x-app-layout>
