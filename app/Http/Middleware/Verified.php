<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Verified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()->hasVerifiedEmail())
            return $next($request);
        else {
            // if user signed in, kill the session
            if (Auth::user()) {
                session()->flush();
                Auth::logout();
            }
            return redirect('invalid-access');
        }
    }
}
