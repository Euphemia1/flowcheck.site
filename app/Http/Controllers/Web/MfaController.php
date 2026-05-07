<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FA\Google2FA;

class MfaController extends Controller
{
    private Google2FA $google2fa;

    public function __construct()
    {
        $this->google2fa = new Google2FA();
    }

    public function showVerify()
    {
        if (session('mfa_verified')) {
            return redirect()->route('app.dashboard');
        }
        return view('mfa.verify');
    }

    public function verify(Request $request)
    {
        $request->validate(['code' => 'required|digits:6']);

        $user  = Auth::user();
        $valid = $this->google2fa->verifyKey($user->mfa_secret, $request->code);

        if (!$valid) {
            return back()->withErrors(['code' => 'Invalid code. Please try again.']);
        }

        session(['mfa_verified' => true]);

        return redirect()->intended(route('app.dashboard'));
    }

    public function showSetup()
    {
        $user   = Auth::user();
        $secret = $this->google2fa->generateSecretKey();
        session(['mfa_setup_secret' => $secret]);

        $qrUrl = $this->google2fa->getQRCodeUrl(
            config('app.name'),
            $user->email,
            $secret
        );

        return view('mfa.setup', compact('qrUrl', 'secret'));
    }

    public function confirmSetup(Request $request)
    {
        $request->validate(['code' => 'required|digits:6']);

        $secret = session('mfa_setup_secret');
        if (!$secret) {
            return redirect()->route('mfa.setup')->withErrors(['code' => 'Session expired. Please start again.']);
        }

        $valid = $this->google2fa->verifyKey($secret, $request->code);
        if (!$valid) {
            return back()->withErrors(['code' => 'Invalid code. Please scan the QR code again.']);
        }

        Auth::user()->update(['mfa_secret' => $secret]);
        session()->forget('mfa_setup_secret');
        session(['mfa_verified' => true]);

        return redirect()->route('app.dashboard')->with('success', 'Two-factor authentication enabled.');
    }
}
