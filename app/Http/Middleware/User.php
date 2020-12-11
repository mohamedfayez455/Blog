<?php

namespace App\Http\Middleware;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Closure;

class User
{

    public function handle($request, Closure $next)
    {
        if (Sentinel::check()){
            return $next($request);
        }else{
            return redirect()->route('login')->with('info' , 'need to login first');
        }
    }
}
