<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name', 'FlowCheck') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">

<div class="flex h-screen overflow-hidden">

    {{-- Sidebar --}}
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 flex flex-col transform -translate-x-full lg:translate-x-0 transition-transform duration-200 ease-in-out">
        {{-- Logo --}}
        <div class="flex items-center h-16 px-6 border-b border-gray-200 flex-shrink-0">
            <a href="{{ route('app.dashboard') }}" class="flex items-center gap-2">
                <div class="w-8 h-8 bg-blue-700 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                </div>
                <span class="text-lg font-semibold text-gray-900">FlowCheck</span>
            </a>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 overflow-y-auto py-4 px-3">

            {{-- Dashboard --}}
            <a href="{{ route('app.dashboard') }}" @class(['flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium mb-1 transition-colors', 'bg-blue-50 text-blue-700 border-r-2 border-blue-700' => request()->routeIs('app.dashboard'), 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' => !request()->routeIs('app.dashboard')])>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>

            {{-- Procurement --}}
            <div class="mb-1">
                <p class="px-3 py-1 text-xs font-semibold text-gray-400 uppercase tracking-wider mt-3 mb-1">Procurement</p>
                @can('create_purchase_requests')
                <a href="{{ route('app.purchase-requests.index') }}" @class(['flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium mb-1 transition-colors', 'bg-blue-50 text-blue-700' => request()->routeIs('app.purchase-requests.*'), 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' => !request()->routeIs('app.purchase-requests.*')])>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    Purchase Requests
                </a>
                @endcan
                <a href="{{ route('app.rfqs.index') }}" @class(['flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium mb-1 transition-colors', 'bg-blue-50 text-blue-700' => request()->routeIs('app.rfqs.*'), 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' => !request()->routeIs('app.rfqs.*')])>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2m-4-1v8m0 0l-3-3m3 3l3-3"/></svg>
                    RFQs
                </a>
                <a href="{{ route('app.purchase-orders.index') }}" @class(['flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium mb-1 transition-colors', 'bg-blue-50 text-blue-700' => request()->routeIs('app.purchase-orders.*'), 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' => !request()->routeIs('app.purchase-orders.*')])>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    Purchase Orders
                </a>
            </div>

            {{-- Receiving --}}
            <div class="mb-1">
                <p class="px-3 py-1 text-xs font-semibold text-gray-400 uppercase tracking-wider mt-3 mb-1">Receiving</p>
                <a href="{{ route('app.grns.index') }}" @class(['flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium mb-1 transition-colors', 'bg-blue-50 text-blue-700' => request()->routeIs('app.grns.*'), 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' => !request()->routeIs('app.grns.*')])>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                    Goods Receipts
                </a>
            </div>

            {{-- Finance --}}
            <div class="mb-1">
                <p class="px-3 py-1 text-xs font-semibold text-gray-400 uppercase tracking-wider mt-3 mb-1">Finance</p>
                <a href="{{ route('app.invoices.index') }}" @class(['flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium mb-1 transition-colors', 'bg-blue-50 text-blue-700' => request()->routeIs('app.invoices.*'), 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' => !request()->routeIs('app.invoices.*')])>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/></svg>
                    Invoices
                </a>
                @can('manage_budgets')
                <a href="{{ route('app.budgets.index') }}" @class(['flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium mb-1 transition-colors', 'bg-blue-50 text-blue-700' => request()->routeIs('app.budgets.*'), 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' => !request()->routeIs('app.budgets.*')])>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Budgets
                </a>
                @endcan
            </div>

            {{-- Vendors & Contracts --}}
            <div class="mb-1">
                <p class="px-3 py-1 text-xs font-semibold text-gray-400 uppercase tracking-wider mt-3 mb-1">Vendors & Contracts</p>
                <a href="{{ route('app.vendors.index') }}" @class(['flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium mb-1 transition-colors', 'bg-blue-50 text-blue-700' => request()->routeIs('app.vendors.*'), 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' => !request()->routeIs('app.vendors.*')])>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    Vendors
                </a>
                <a href="{{ route('app.contracts.index') }}" @class(['flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium mb-1 transition-colors', 'bg-blue-50 text-blue-700' => request()->routeIs('app.contracts.*'), 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' => !request()->routeIs('app.contracts.*')])>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Contracts
                </a>
            </div>

            {{-- Tenders & BOQs --}}
            <div class="mb-1">
                <p class="px-3 py-1 text-xs font-semibond text-gray-400 uppercase tracking-wider mt-3 mb-1">Tenders & BOQs</p>
                <a href="{{ route('app.tenders.index') }}" @class(['flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium mb-1 transition-colors', 'bg-blue-50 text-blue-700' => request()->routeIs('app.tenders.*'), 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' => !request()->routeIs('app.tenders.*')])>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                    Tenders
                </a>
                <a href="{{ route('app.boqs.index') }}" @class(['flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium mb-1 transition-colors', 'bg-blue-50 text-blue-700' => request()->routeIs('app.boqs.*'), 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' => !request()->routeIs('app.boqs.*')])>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                    Bill of Quantities
                </a>
            </div>

            {{-- Reports --}}
            <div class="mb-1">
                <p class="px-3 py-1 text-xs font-semibold text-gray-400 uppercase tracking-wider mt-3 mb-1">Analytics</p>
                @can('view_reports')
                <a href="{{ route('app.reports.index') }}" @class(['flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium mb-1 transition-colors', 'bg-blue-50 text-blue-700' => request()->routeIs('app.reports.*'), 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' => !request()->routeIs('app.reports.*')])>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    Reports
                </a>
                @endcan
            </div>

            {{-- Settings --}}
            @canany(['manage_settings', 'manage_users'])
            <div class="mb-1">
                <p class="px-3 py-1 text-xs font-semibold text-gray-400 uppercase tracking-wider mt-3 mb-1">Admin</p>
                <a href="{{ route('app.settings.index') }}" @class(['flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium mb-1 transition-colors', 'bg-blue-50 text-blue-700' => request()->routeIs('app.settings.*'), 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' => !request()->routeIs('app.settings.*')])>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Settings
                </a>
            </div>
            @endcanany

        </nav>

        {{-- Sidebar footer - org name --}}
        <div class="px-4 py-3 border-t border-gray-200">
            <p class="text-xs text-gray-500 truncate">{{ Auth::user()->organisation->name ?? 'FlowCheck' }}</p>
        </div>
    </aside>

    {{-- Main content area --}}
    <div class="flex-1 flex flex-col min-w-0 lg:pl-64">

        {{-- Top bar --}}
        <header class="sticky top-0 z-40 bg-white border-b border-gray-200 h-16 flex items-center px-4 sm:px-6 gap-4">
            {{-- Mobile hamburger --}}
            <button id="sidebar-toggle" class="lg:hidden p-2 rounded-md text-gray-500 hover:bg-gray-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>

            <div class="flex-1"></div>

            {{-- Notification bell --}}
            <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                <button @click="open = !open" class="relative p-2 rounded-md text-gray-500 hover:bg-gray-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    @php $unreadCount = Auth::user()->unreadNotifications->count(); @endphp
                    @if($unreadCount > 0)
                        <span class="absolute top-1 right-1 w-4 h-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
                    @endif
                </button>
                <div x-show="open" x-cloak class="absolute right-0 mt-2 w-80 bg-white rounded-lg border border-gray-200 shadow-lg z-50">
                    <div class="px-4 py-3 border-b border-gray-100 flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-900">Notifications</span>
                        <a href="{{ route('app.notifications.read-all') }}" onclick="event.preventDefault(); document.getElementById('read-all-form').submit();" class="text-xs text-blue-700 hover:underline">Mark all read</a>
                    </div>
                    <div class="max-h-80 overflow-y-auto divide-y divide-gray-50">
                        @forelse(Auth::user()->unreadNotifications->take(8) as $notification)
                            <div class="px-4 py-3 hover:bg-gray-50">
                                <p class="text-sm text-gray-800">{{ $notification->data['message'] ?? 'New notification' }}</p>
                                <p class="text-xs text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                            </div>
                        @empty
                            <div class="px-4 py-6 text-center text-sm text-gray-500">No new notifications</div>
                        @endforelse
                    </div>
                    <div class="px-4 py-2 border-t border-gray-100">
                        <a href="{{ route('app.notifications.index') }}" class="text-xs text-blue-700 hover:underline">View all notifications</a>
                    </div>
                </div>
            </div>
            <form id="read-all-form" method="POST" action="{{ route('app.notifications.read-all') }}" class="hidden">@csrf</form>

            {{-- User menu --}}
            <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                <button @click="open = !open" class="flex items-center gap-2 p-2 rounded-md hover:bg-gray-100">
                    <div class="w-8 h-8 bg-blue-700 rounded-full flex items-center justify-center text-white text-sm font-medium">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <span class="hidden sm:block text-sm font-medium text-gray-700">{{ Auth::user()->name }}</span>
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="open" x-cloak class="absolute right-0 mt-2 w-48 bg-white rounded-lg border border-gray-200 shadow-lg z-50">
                    <div class="px-4 py-3 border-b border-gray-100">
                        <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Sign out</button>
                    </form>
                </div>
            </div>
        </header>

        {{-- Page content --}}
        <main class="flex-1 overflow-y-auto">
            <div class="p-6 max-w-7xl mx-auto">

                {{-- Flash messages --}}
                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm flex items-start gap-2">
                        <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('warning'))
                    <div class="mb-4 p-4 bg-amber-50 border border-amber-200 text-amber-700 rounded-lg text-sm flex items-start gap-2">
                        <svg class="w-5 h-5 text-amber-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        {{ session('warning') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm flex items-start gap-2">
                        <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ session('error') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                        <p class="font-medium mb-1">Please fix the following errors:</p>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{ $slot }}
            </div>
        </main>
    </div>
</div>

{{-- Mobile sidebar overlay --}}
<div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden lg:hidden"></div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggle = document.getElementById('sidebar-toggle');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    if (toggle) {
        toggle.addEventListener('click', function () {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        });
        overlay.addEventListener('click', function () {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });
    }
});
</script>

@stack('scripts')
</body>
</html>
