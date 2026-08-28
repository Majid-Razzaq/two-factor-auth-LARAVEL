<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTwoFactorVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(
        Request $request,
        Closure $next
    ): Response {
        if (
            !$request->user() ||
            $request->session()->get('two_factor_verified') !== true
        ) {
            return redirect()
                ->route('two-factor.show')
                ->with(
                    'error',
                    'Please complete two-factor authentication first.'
                );
        }

        return $next($request);
    }
}
