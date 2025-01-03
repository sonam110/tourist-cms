<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(!\Auth::check()){
            return redirect(route('admin/login'));
        }
        if(Auth::user()->userType == 'user'){
            return redirect(route('user.dashboard'));
        }
        return $next($request);
    }
}
