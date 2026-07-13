<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTwoFactorAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user) {
            // If user hasn't set up 2FA yet
            if (empty($user->google2fa_secret)) {
                if (! $request->is('2fa/setup') && ! $request->is('2fa/verify-setup') && ! $request->is('logout')) {
                    return redirect()->route('2fa.setup');
                }
            } 
            // If user has 2FA set up but hasn't authenticated this session
            elseif (! $request->session()->has('2fa_authenticated')) {
                if (! $request->is('2fa/challenge') && ! $request->is('2fa/verify') && ! $request->is('logout')) {
                    return redirect()->route('2fa.challenge');
                }
            }
        }

        return $next($request);
    }
}
