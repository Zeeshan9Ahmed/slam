<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsVenueProfileCompleted
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
        if(auth()->check() && auth()->user()->profile_completed === 0)
        {
            // dd('dd');
            return  redirect()->route('venue_profile_setup');
            // return view('web.register.venue_profile');
        }
        // dd('tt');
        return $next($request);
    }
}
