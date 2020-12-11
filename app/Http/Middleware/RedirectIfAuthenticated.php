<?php

namespace App\Http\Middleware;

use Sentinel;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{

    public function handle($request, Closure $next, $guard = null)
    {
        if (Sentinel::check() && Sentinel::hasAnyAccess(['admin.*' , 'moderator.*'])){
            return  redirect()->route('admin.dashboard')->with('success' , 'you are login in ');
        }elseif (Sentinel::check() && Sentinel::hasAccess('user.*')){
            return  redirect()->route('user.dashboard')->with('success' , 'you are login in ');
        }
        return $next($request);
    }
}
