<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if(Auth::check())
        {
            if($request->user()->position_id == 8 or $request->user()->position_id == 6)
            {
                return $next($request);
            }
            return redirect('/dashboard');
        }

        return redirect('/login');
    }


}
