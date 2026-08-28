<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class EnsureLockscreenIsUnlocked
{
    private const IDLE_TIMEOUT = 3600;

    public function handle(Request $request, Closure $next): Response
    {
        /*
         * Not authenticated.
         */
        if (! Auth::check()) {
            return $next($request);
        }

        /*
         * Allow the actual lockscreen page.
         */
        if ($request->routeIs('lockscreen')) {
            return $next($request);
        }

        /*
         * IMPORTANT:
         *
         * Do not run the lockscreen redirect logic against
         * Livewire requests coming from the lockscreen itself.
         *
         * Otherwise typing/submitting the password can cause
         * Livewire to receive a redirect instead of its expected
         * Livewire response.
         */
        if ($request->hasHeader('X-Livewire') && Session::get('lockscreen_locked', false) === true) 
        {
            return $next($request);
        }


        /*
         * Check inactivity.
         */
        $now = now()->timestamp;

        $lastActivity = Session::get('last_activity_at');

        

        if ($lastActivity !== null) {

            $idleTime = $now - (int) $lastActivity;

            if ($idleTime >= self::IDLE_TIMEOUT) {

                Session::put(
                    'url.intended',
                    $request->fullUrl()
                );

                Session::put(
                    'lockscreen_locked',
                    true
                );                

                return redirect()->route('lockscreen');
            }
        }

        /*
         * Already locked.
         */
        if (Session::get('lockscreen_locked', false) === true) {

            Session::put(
                'url.intended',
                $request->fullUrl()
            );

            

            return redirect()->route('lockscreen');
        }

        /*
         * User is active.
         */
        Session::put(
            'last_activity_at',
            $now
        );

        return $next($request);
    }
}