<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsVenueAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(auth()->check() && auth()->user()->role === "venue")
        {
            // if (auth()->user()->profile_completed === 0){
            //     return  redirect()->route('venue_profile_setup');
            // }
            return $next($request);
        }
        return  redirect()->route('venue_login');
        
    }
}
