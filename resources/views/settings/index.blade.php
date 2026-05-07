<x-app-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Settings</h1>
        <p class="text-sm text-gray-500 mt-1">Manage your organisation configuration</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach([
            ['route' => 'app.settings.profile', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4', 'title' => 'Organisation Profile', 'desc' => 'Name, logo, currency, industry'],
            ['route' => 'app.settings.users.index', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z', 'title' => 'Users', 'desc' => 'Invite and manage team members'],
            ['route' => 'app.settings.departments.index', 'icon' => 'M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z', 'title' => 'Departments', 'desc' => 'Manage departments and budgets'],
            ['route' => 'app.settings.workflows.index', 'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'title' => 'Approval Workflows', 'desc' => 'Configure PR approval chains'],
            ['route' => 'app.settings.plans', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2', 'title' => 'Plan & Billing', 'desc' => 'View current plan and limits'],
            ['route' => 'app.settings.integrations', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'title' => 'Integrations', 'desc' => 'ZPPA, ZIHRM, ZIPPS connectors'],
        ] as $item)
        <a href="{{ route($item['route']) }}" class="bg-white rounded-lg border border-gray-200 shadow-sm p-6 hover:border-blue-300 hover:shadow-md transition group">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:bg-blue-100">
                    <svg class="w-5 h-5 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"/></svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-900">{{ $item['title'] }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ $item['desc'] }}</p>
                </div>
            </div>
        </a>
        @endforeach
    </div>
</x-app-layout>
