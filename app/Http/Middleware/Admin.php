<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;

class Admin
{

    public function handle($request, Closure $next)
    {
        if (Sentinel::check() && Sentinel::getUser()->hasAnyAccess(['admin.*' , 'moderator.*'])){
            return $next($request);
        }
        return redirect()->back()->with('error' , 'insufficient permission');
    }
}
