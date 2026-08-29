<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class EnsureLockscreenIsUnlocked
{    

    public function handle(Request $request, Closure $next): Response
    {        
        /*
         * Not authenticated.
         */
        if (! Auth::check() || $request->routeIs('lockscreen*')) {
            return $next($request);
        }

        
        // Initialize session state if missing
        if (! $request->session()->has('lockscreen')) {
            $request->session()->put('lockscreen', false);
        }

        
        // Allow access to lockscreen routes to avoid infinite redirect loops
        if ($request->routeIs('lockscreen') || $request->routeIs('lockscreen.unlock') || $request->routeIs('lockscreen.lock')) {
            return $next($request);
        }

        // If locked, restrict access to all protected application routes
        if ($request->session()->get('lockscreen') === true) {
            return redirect()->route('lockscreen');
        }


        return $next($request)->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
                        ->header('Pragma', 'no-cache')
                        ->header('Expires', 'Sun, 02 Jan 1990 00:00:00 GMT');

        
    }
}