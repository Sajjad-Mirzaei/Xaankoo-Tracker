<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class isAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $user=auth()->user()->level;
        if ($user=='admin'){
            return $next($request);
        }

        return response()->json(['message'=>'Bad Request'],400);
    }
}
