<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Two-Factor Authentication — FlowCheck</title>
    @vite(['resources/css/app.css'])
</head>
<body class="h-full flex items-center justify-center">
    <div class="w-full max-w-sm">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-blue-700">FlowCheck</h1>
            <p class="text-sm text-gray-500 mt-1">Procurement Management</p>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-8">
            <div class="flex justify-center mb-5">
                <div class="w-12 h-12 bg-blue-50 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
            </div>
            <h2 class="text-lg font-semibold text-gray-900 text-center mb-1">Verify Your Identity</h2>
            <p class="text-sm text-gray-500 text-center mb-6">Enter the 6-digit code from your authenticator app.</p>

            <form method="POST" action="{{ route('mfa.verify.post') }}">
                @csrf
                <div class="mb-4">
                    <input type="text" name="code" inputmode="numeric" pattern="\d{6}" maxlength="6" autofocus
                           placeholder="000000"
                           class="w-full text-center text-2xl tracking-widest border {{ $errors->has('code') ? 'border-red-400' : 'border-gray-300' }} rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                           value="{{ old('code') }}">
                    @error('code')<p class="text-red-500 text-xs mt-2 text-center">{{ $message }}</p>@enderror
                </div>
                <button type="submit" class="w-full py-2.5 bg-blue-700 text-white font-medium rounded-lg hover:bg-blue-800">
                    Verify
                </button>
            </form>

            <div class="mt-4 text-center">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-xs text-gray-500 hover:text-gray-700">Sign out</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
