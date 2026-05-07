<x-app-layout>
    <h1 class="text-2xl font-semibold text-gray-900 mb-6">Reports & Analytics</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <a href="{{ route('app.reports.spend-by-department') }}" class="bg-white rounded-lg border border-gray-200 shadow-sm p-6 hover:border-blue-300 hover:shadow transition group">
            <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center mb-3 group-hover:bg-blue-100">
                <svg class="w-5 h-5 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            </div>
            <h3 class="text-sm font-semibold text-gray-900">Spend by Department</h3>
            <p class="text-xs text-gray-500 mt-1">Total procurement spend broken down by department</p>
        </a>

        <a href="{{ route('app.reports.pr-status') }}" class="bg-white rounded-lg border border-gray-200 shadow-sm p-6 hover:border-blue-300 hover:shadow transition group">
            <div class="w-10 h-10 bg-amber-50 rounded-lg flex items-center justify-center mb-3 group-hover:bg-amber-100">
                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <h3 class="text-sm font-semibold text-gray-900">Purchase Request Status</h3>
            <p class="text-xs text-gray-500 mt-1">Track all PRs and their current approval status</p>
        </a>

        <a href="{{ route('app.reports.invoice-aging') }}" class="bg-white rounded-lg border border-gray-200 shadow-sm p-6 hover:border-blue-300 hover:shadow transition group">
            <div class="w-10 h-10 bg-red-50 rounded-lg flex items-center justify-center mb-3 group-hover:bg-red-100">
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h3 class="text-sm font-semibold text-gray-900">Invoice Aging</h3>
            <p class="text-xs text-gray-500 mt-1">Outstanding invoices grouped by overdue period</p>
        </a>

        <a href="{{ route('app.reports.vendor-performance') }}" class="bg-white rounded-lg border border-gray-200 shadow-sm p-6 hover:border-blue-300 hover:shadow transition group">
            <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center mb-3 group-hover:bg-green-100">
                <svg class="w-5 h-5 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/></svg>
            </div>
            <h3 class="text-sm font-semibold text-gray-900">Vendor Performance</h3>
            <p class="text-xs text-gray-500 mt-1">Spend and order volume by vendor</p>
        </a>

        <a href="{{ route('app.reports.budget-utilisation') }}" class="bg-white rounded-lg border border-gray-200 shadow-sm p-6 hover:border-blue-300 hover:shadow transition group">
            <div class="w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center mb-3 group-hover:bg-purple-100">
                <svg class="w-5 h-5 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/></svg>
            </div>
            <h3 class="text-sm font-semibold text-gray-900">Budget Utilisation</h3>
            <p class="text-xs text-gray-500 mt-1">Budget vs actual spend per department</p>
        </a>

        <a href="{{ route('app.reports.audit-trail') }}" class="bg-white rounded-lg border border-gray-200 shadow-sm p-6 hover:border-blue-300 hover:shadow transition group">
            <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center mb-3 group-hover:bg-gray-200">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <h3 class="text-sm font-semibold text-gray-900">Audit Trail</h3>
            <p class="text-xs text-gray-500 mt-1">Full log of all system actions and changes</p>
        </a>
    </div>
</x-app-layout>
