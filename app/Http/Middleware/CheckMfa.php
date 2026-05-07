<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckMfa
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user) {
            return $next($request);
        }

        $requiresMfa = $user->hasAnyRole(['org_admin', 'cfo']) && $user->mfa_secret;

        if ($requiresMfa && !session('mfa_verified')) {
            if (!$request->routeIs('mfa.*')) {
                return redirect()->route('mfa.verify');
            }
        }

        return $next($request);
    }
}
