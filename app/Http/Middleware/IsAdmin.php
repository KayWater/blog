<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //Determine whether the current user is administrator
        if (Auth::guest() || ! Auth::user()->is_admin) {
            return redirect("/");
        }
        
        return $next($request);
    }
}
