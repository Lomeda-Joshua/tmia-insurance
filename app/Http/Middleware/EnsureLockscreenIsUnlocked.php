<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureLockscreenIsUnlocked
{    

    public function handle(Request $request, Closure $next): Response
    {        
            // 1. Allow unauthenticated users or specific exempt routes immediately
        $exemptRoutes = [
            'lockscreen*',
            'login*',
            'logout',
        ];


        if (! Auth::check() || $request->routeIs($exemptRoutes)) {   
            return $next($request);
        }

        
        // 2. Initialize lockscreen state if not set
        if (! $request->session()->has('lockscreen')) {   
            $request->session()->put('lockscreen', false);
        }

        // 3. Enforce lockscreen restriction on all protected routes
        if ($request->session()->get('lockscreen') === true) {
            return redirect()->route('lockscreen');            
        }

        // 4. Pass request through with no-cache headers for authenticated, unlocked state
        $response = $next($request);


        $response->headers->set('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', 'Sun, 02 Jan 1990 00:00:00 GMT');

        return $response;
    }

        
}
