<?php

namespace Webdev\Http\Middleware;
use Illuminate\Support\Facades\Gate;
use Closure;

class AuthAdminPanelOrCabinet
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
        //return $next($request);
         if(Gate::allows('IS_ADMIN')){
        //Go to the Administrator Page
            return redirect('/admin');
        }
        else{
        //Go to the User's Cabinet Page
            return $next($request);
        }
    }
}
