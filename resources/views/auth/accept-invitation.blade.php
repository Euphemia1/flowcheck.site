<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accept Invitation — FlowCheck</title>
    @vite(['resources/css/app.css'])
</head>
<body class="h-full flex items-center justify-center py-12">
    <div class="w-full max-w-sm">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-blue-700">FlowCheck</h1>
            <p class="text-sm text-gray-500 mt-1">Procurement Management</p>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-8">
            <h2 class="text-lg font-semibold text-gray-900 mb-1">Set Up Your Account</h2>
            <p class="text-sm text-gray-500 mb-1">Welcome to <strong>{{ $user->organisation->name }}</strong></p>
            <p class="text-sm text-gray-500 mb-6">{{ $user->email }}</p>

            <form method="POST" action="{{ route('invitation.accept', $token) }}">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Full Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                               class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password" required minlength="8"
                               class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="At least 8 characters">
                        @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password_confirmation" required
                               class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <button type="submit" class="w-full py-2.5 bg-blue-700 text-white font-medium rounded-lg hover:bg-blue-800">
                        Create Account
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
