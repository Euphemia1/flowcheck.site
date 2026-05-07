<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Dashboard</h1>
        <p class="text-sm text-gray-400">{{ now()->format('l, F j, Y') }}</p>
    </div>

    {{-- KPI Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-5">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Total Spend (YTD)</p>
                <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <p class="text-2xl font-bold text-gray-900">ZMW {{ number_format($totalSpend, 0) }}</p>
            <p class="text-xs text-gray-400 mt-1">Approved POs this year</p>
        </div>

        <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-5">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Pending Approvals</p>
                <div class="w-8 h-8 bg-amber-50 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <p class="text-2xl font-bold text-gray-900">{{ $pendingPrs }}</p>
            <p class="text-xs text-gray-400 mt-1">Purchase requests awaiting action</p>
        </div>

        <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-5">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Open POs</p>
                <div class="w-8 h-8 bg-green-50 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
            </div>
            <p class="text-2xl font-bold text-gray-900">{{ $openPos ?? 0 }}</p>
            <p class="text-xs text-gray-400 mt-1">Approved, awaiting receipt</p>
        </div>

        <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-5">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Pending Invoices</p>
                <div class="w-8 h-8 bg-red-50 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
            </div>
            <p class="text-2xl font-bold text-gray-900">{{ $pendingInvoices }}</p>
            <p class="text-xs text-gray-400 mt-1">Awaiting payment approval</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        {{-- PR Status Donut --}}
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-5">
            <h3 class="text-sm font-semibold text-gray-900 mb-4">PR Status Breakdown</h3>
            <canvas id="prStatusChart" height="200"></canvas>
        </div>

        {{-- Spend by Department Bar --}}
        <div class="lg:col-span-2 bg-white rounded-lg border border-gray-200 shadow-sm p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-semibold text-gray-900">Spend by Department (YTD)</h3>
                <a href="{{ route('app.reports.spend-by-department') }}" class="text-xs text-blue-700 hover:underline">Full report</a>
            </div>
            @if($totalSpend > 0)
            <div class="space-y-3">
                @foreach($spendByDepartment as $dept)
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-xs font-medium text-gray-700">{{ $dept['name'] }}</span>
                        <span class="text-xs font-medium text-gray-700">ZMW {{ number_format($dept['spend'], 0) }}</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $totalSpend > 0 ? min(($dept['spend'] / $totalSpend * 100), 100) : 0 }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-sm text-gray-400 py-8 text-center">No spend data yet this year.</p>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Quick Actions --}}
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-5">
            <h3 class="text-sm font-semibold text-gray-900 mb-4">Quick Actions</h3>
            <div class="space-y-2">
                @can('create_purchase_requests')
                <a href="{{ route('app.purchase-requests.create') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 group">
                    <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center group-hover:bg-blue-100">
                        <svg class="w-4 h-4 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    </div>
                    <span class="text-sm text-gray-700">New Purchase Request</span>
                </a>
                @endcan
                @can('create_purchase_orders')
                <a href="{{ route('app.purchase-orders.create') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 group">
                    <div class="w-8 h-8 bg-green-50 rounded-lg flex items-center justify-center group-hover:bg-green-100">
                        <svg class="w-4 h-4 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                    </div>
                    <span class="text-sm text-gray-700">Create Purchase Order</span>
                </a>
                @endcan
                @can('create_vendors')
                <a href="{{ route('app.vendors.create') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 group">
                    <div class="w-8 h-8 bg-purple-50 rounded-lg flex items-center justify-center group-hover:bg-purple-100">
                        <svg class="w-4 h-4 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <span class="text-sm text-gray-700">Add Vendor</span>
                </a>
                @endcan
                @can('view_reports')
                <a href="{{ route('app.reports.index') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 group">
                    <div class="w-8 h-8 bg-amber-50 rounded-lg flex items-center justify-center group-hover:bg-amber-100">
                        <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    </div>
                    <span class="text-sm text-gray-700">View Reports</span>
                </a>
                @endcan
            </div>
        </div>

        {{-- Expiring Contracts --}}
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-semibold text-gray-900">Expiring Contracts</h3>
                <a href="{{ route('app.contracts.index') }}" class="text-xs text-blue-700 hover:underline">All</a>
            </div>
            @forelse($expiringContracts ?? [] as $contract)
            @php $days = now()->diffInDays(\Carbon\Carbon::parse($contract->end_date), false); @endphp
            <div class="flex items-center justify-between py-2.5 border-b border-gray-100 last:border-0">
                <div>
                    <p class="text-xs font-medium text-gray-900">{{ $contract->contract_number }}</p>
                    <p class="text-xs text-gray-500">{{ $contract->vendor->name }}</p>
                </div>
                <span class="text-xs font-medium {{ $days <= 30 ? 'text-red-600' : 'text-amber-600' }}">
                    {{ $days }}d left
                </span>
            </div>
            @empty
            <p class="text-xs text-gray-400 py-4 text-center">No contracts expiring soon.</p>
            @endforelse
        </div>

        {{-- Recent Activity --}}
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-semibold text-gray-900">Recent Activity</h3>
                <a href="{{ route('app.reports.audit-trail') }}" class="text-xs text-blue-700 hover:underline">Full log</a>
            </div>
            <div class="space-y-3">
                @forelse($recentActivity ?? [] as $log)
                <div class="flex gap-2.5 text-xs">
                    <div class="w-1.5 h-1.5 rounded-full bg-blue-400 mt-1.5 flex-shrink-0"></div>
                    <div>
                        <p class="text-gray-700"><span class="font-medium">{{ $log->user?->name ?? 'System' }}</span> {{ $log->action }} {{ $log->model_type }}</p>
                        <p class="text-gray-400">{{ $log->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                @empty
                <p class="text-xs text-gray-400 py-4 text-center">No recent activity.</p>
                @endforelse
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>
    <script>
    const ctx = document.getElementById('prStatusChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: @json($prsByStatus->pluck('status')->map(fn($s) => ucwords(str_replace('_',' ',$s)))->toArray()),
                datasets: [{
                    data: @json($prsByStatus->pluck('count')->toArray()),
                    backgroundColor: ['#3b82f6','#10b981','#f59e0b','#ef4444','#6b7280','#8b5cf6'],
                    borderWidth: 2,
                    borderColor: '#ffffff',
                }]
            },
            options: {
                plugins: { legend: { position: 'bottom', labels: { font: { size: 11 } } } },
                cutout: '65%',
            }
        });
    }
    </script>
    @endpush
</x-app-layout>
