<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Verify
{
    public function handle(Request $request, Closure $next)
    {
        $user=auth()->user()->email_verified_at;
        if ($user==null){
            return response()->json(['message'=>'User Didnt Verify'],400);
        }

        return $next($request);
    }
}
