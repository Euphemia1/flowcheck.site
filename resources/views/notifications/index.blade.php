<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Notifications</h1>
        <form method="POST" action="{{ route('app.notifications.read-all') }}">
            @csrf
            <button type="submit" class="text-sm text-blue-700 hover:underline">Mark all as read</button>
        </form>
    </div>

    <div class="bg-white rounded-lg border border-gray-200 shadow-sm divide-y divide-gray-100">
        @forelse($notifications as $notification)
        <div class="flex gap-4 p-4 {{ $notification->read_at ? 'opacity-60' : 'bg-blue-50/30' }}">
            <div class="flex-shrink-0 mt-0.5">
                <div class="w-2 h-2 rounded-full {{ $notification->read_at ? 'bg-gray-300' : 'bg-blue-500' }} mt-1.5"></div>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm text-gray-900">{{ $notification->data['message'] ?? 'Notification' }}</p>
                <p class="text-xs text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
            </div>
            <div class="flex-shrink-0 flex items-start gap-3">
                @if(!empty($notification->data['url']))
                <a href="{{ $notification->data['url'] }}" class="text-xs text-blue-700 hover:underline whitespace-nowrap">View</a>
                @endif
                @if(!$notification->read_at)
                <button
                    x-data
                    @click="fetch('{{ route('app.notifications.read', $notification->id) }}', {method:'POST', headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Accept':'application/json'}}).then(() => $el.closest('.flex').classList.add('opacity-60'))"
                    class="text-xs text-gray-400 hover:text-gray-600">
                    Dismiss
                </button>
                @endif
            </div>
        </div>
        @empty
        <div class="p-10 text-center text-sm text-gray-500">
            You're all caught up. No notifications.
        </div>
        @endforelse
    </div>

    @if($notifications->hasPages())
    <div class="mt-4">{{ $notifications->links() }}</div>
    @endif
</x-app-layout>
