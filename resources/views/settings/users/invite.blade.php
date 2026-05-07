<x-app-layout>
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('app.settings.users.index') }}" class="text-sm text-gray-500 hover:text-gray-700">Users</a>
        <span class="text-gray-300">/</span>
        <h1 class="text-2xl font-semibold text-gray-900">Invite Team Member</h1>
    </div>

    <div class="max-w-lg">
        <form method="POST" action="{{ route('app.settings.users.send-invitation') }}">
            @csrf
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email Address <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Role <span class="text-red-500">*</span></label>
                    <select name="role" required class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">— Select Role —</option>
                        @foreach($roles as $role)
                        <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>{{ ucwords(str_replace('_',' ',$role->name)) }}</option>
                        @endforeach
                    </select>
                    @error('role')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <p class="text-xs text-gray-500">An invitation email with a secure link will be sent. The link expires in 7 days.</p>
                <div class="flex gap-3 pt-1">
                    <button type="submit" class="px-4 py-2 bg-blue-700 text-white text-sm font-medium rounded-lg hover:bg-blue-800">Send Invitation</button>
                    <a href="{{ route('app.settings.users.index') }}" class="px-4 py-2 text-sm text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
