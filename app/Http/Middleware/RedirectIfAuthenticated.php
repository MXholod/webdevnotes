<?php

namespace Webdev\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
class RedirectIfAuthenticated
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
        if (Auth::guard($guard)->check()) {
             if(Gate::allows('IS_ADMIN')){
            //Go to the Administrator Page
                return redirect('/admin');
            }
            else{
            //Go to the User's Cabinet Page
                return $next('/cabinet');
            }
            //return redirect('/home');
        }

        return $next($request);
    }
}
