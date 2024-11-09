<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckSessionExpiry
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated

        // if (Auth::check()) {
        // $lastActivity = $request->session()->get('last_activity');
        // $sessionLifetime = config('session.lifetime') * 60; // Convert minutes to seconds

        // // Check if the session has expired
        // if (time() - $lastActivity > $sessionLifetime) {
        //     // Session expired, perform actions such as logging out the user
        //     Auth::logout();
        //     return redirect()->url('login')->with('error', 'Your session has expired. Please log in again.');
        // }

        //     return $next($request);
        // } else {
        return redirect()->route('login')->with('error', 'Your session has expired. Please log in again.');
        // }
        // Update last activity time
        // $request->session()->put('last_activity', time());

        // return $next($request);
    }
}
