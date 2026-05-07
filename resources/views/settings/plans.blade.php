<x-app-layout>
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('app.settings.index') }}" class="text-sm text-gray-500 hover:text-gray-700">Settings</a>
        <span class="text-gray-300">/</span>
        <h1 class="text-2xl font-semibold text-gray-900">Plan & Billing</h1>
    </div>

    <div class="mb-6 bg-white rounded-lg border border-gray-200 shadow-sm p-6">
        <p class="text-sm text-gray-500 mb-1">Current Plan</p>
        <p class="text-2xl font-bold text-gray-900">{{ $plan->name }}</p>
        <p class="text-sm text-gray-500 mt-1">ZMW {{ number_format($plan->price_monthly, 2) }} / month</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        @foreach($all as $p)
        <div class="bg-white rounded-lg border {{ $p->id === $plan->id ? 'border-blue-500 ring-2 ring-blue-200' : 'border-gray-200' }} shadow-sm p-6">
            @if($p->id === $plan->id)
            <span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-medium bg-blue-50 text-blue-700 mb-3">Current Plan</span>
            @endif
            <h3 class="text-lg font-semibold text-gray-900">{{ $p->name }}</h3>
            <p class="text-2xl font-bold text-gray-900 mt-2">ZMW {{ number_format($p->price_monthly, 0) }}<span class="text-sm font-normal text-gray-500">/mo</span></p>
            <div class="mt-4 space-y-2 text-sm text-gray-600">
                <div class="flex justify-between"><span>Users</span><span class="font-medium">{{ $p->max_users ?? 'Unlimited' }}</span></div>
                <div class="flex justify-between"><span>Vendors</span><span class="font-medium">{{ $p->max_vendors ?? 'Unlimited' }}</span></div>
                @foreach($p->features ?? [] as $feature => $enabled)
                @if($enabled)
                <div class="flex items-center gap-2 text-green-700"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg><span>{{ ucwords(str_replace('_',' ',$feature)) }}</span></div>
                @endif
                @endforeach
            </div>
            @if($p->id !== $plan->id)
            <div class="mt-6">
                <p class="text-xs text-center text-gray-500">Contact sales to upgrade</p>
                <a href="mailto:sales@flowcheck.ai?subject=Upgrade to {{ $p->name }}" class="mt-2 block w-full px-4 py-2 text-center text-sm bg-blue-700 text-white font-medium rounded-lg hover:bg-blue-800">Upgrade to {{ $p->name }}</a>
            </div>
            @endif
        </div>
        @endforeach
    </div>
</x-app-layout>
