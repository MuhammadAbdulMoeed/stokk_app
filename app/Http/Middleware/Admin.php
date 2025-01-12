<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Admin
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


        if (Auth::check()) {
            if(Auth::user()->role->name == 'Admin')
            {
                return $next($request);
            }
            else{
                abort(401);
            }

        }
        else {
            return redirect()->route('loginPage')->with('error','You are not Authorize for making this Request');
        }
    }

}
