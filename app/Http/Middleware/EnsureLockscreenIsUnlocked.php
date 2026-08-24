<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class EnsureLockscreenIsUnlocked
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        // Redirect to lockscreen route if session flag is set
        if (Session::get('lockscreen_locked', false)) {
            if (! $request->routeIs('lockscreen')) {
                return redirect()->route('dashboard');
            }
        }

        return $next($request);
    }
}
