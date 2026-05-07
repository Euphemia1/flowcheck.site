<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('app.settings.index') }}" class="text-sm text-gray-500 hover:text-gray-700">Settings</a>
            <span class="text-gray-300">/</span>
            <h1 class="text-2xl font-semibold text-gray-900">Users</h1>
        </div>
        <a href="{{ route('app.settings.users.invite') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-700 text-white text-sm font-medium rounded-lg hover:bg-blue-800">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
            Invite User
        </a>
    </div>

    <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
        <table class="w-full text-left">
            <thead class="bg-gray-50"><tr>
                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Name</th>
                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Email</th>
                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Role</th>
                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3"></th>
            </tr></thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($users as $user)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $user->name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $user->email }}</td>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $user->roles->pluck('name')->implode(', ') ?: '—' }}</td>
                    <td class="px-6 py-4">
                        @if($user->is_active)
                            <span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-medium bg-green-50 text-green-700">Active</span>
                        @else
                            <span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-medium bg-gray-100 text-gray-500">Inactive</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($user->id !== Auth::id())
                            @if($user->is_active)
                            <form method="POST" action="{{ route('app.settings.users.deactivate', $user) }}" class="inline">
                                @csrf
                                <button type="submit" class="text-xs text-red-600 hover:underline">Deactivate</button>
                            </form>
                            @else
                            <form method="POST" action="{{ route('app.settings.users.reactivate', $user) }}" class="inline">
                                @csrf
                                <button type="submit" class="text-xs text-blue-700 hover:underline">Reactivate</button>
                            </form>
                            @endif
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-6 py-4 border-t border-gray-100">{{ $users->links() }}</div>
    </div>
</x-app-layout>
