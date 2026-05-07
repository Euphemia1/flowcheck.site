<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Up 2FA — FlowCheck</title>
    @vite(['resources/css/app.css'])
</head>
<body class="h-full flex items-center justify-center py-12">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-blue-700">FlowCheck</h1>
            <p class="text-sm text-gray-500 mt-1">Procurement Management</p>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-8">
            <h2 class="text-lg font-semibold text-gray-900 mb-1">Set Up Two-Factor Authentication</h2>
            <p class="text-sm text-gray-500 mb-6">Two-factor authentication is required for your role. Scan the QR code with Google Authenticator or Authy.</p>

            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 flex justify-center mb-4">
                {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(180)->generate($qrUrl) !!}
            </div>

            <div class="bg-gray-50 border border-gray-200 rounded-lg p-3 mb-6 text-center">
                <p class="text-xs text-gray-500 mb-1">Or enter this key manually:</p>
                <code class="font-mono text-sm font-semibold text-gray-900 tracking-widest">{{ $secret }}</code>
            </div>

            <form method="POST" action="{{ route('mfa.setup.confirm') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Verification Code</label>
                    <input type="text" name="code" inputmode="numeric" pattern="\d{6}" maxlength="6" autofocus
                           placeholder="Enter 6-digit code"
                           class="w-full text-center text-xl tracking-widest border {{ $errors->has('code') ? 'border-red-400' : 'border-gray-300' }} rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500"
                           value="{{ old('code') }}">
                    @error('code')<p class="text-red-500 text-xs mt-1 text-center">{{ $message }}</p>@enderror
                </div>
                <button type="submit" class="w-full py-2.5 bg-blue-700 text-white font-medium rounded-lg hover:bg-blue-800">
                    Enable 2FA
                </button>
            </form>
        </div>
    </div>
</body>
</html>
