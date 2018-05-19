<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class JsonMiddleware {

    public function handle(Request $request, Closure $next)
    {
       $request->headers->set("Accept", "Application/json");
        return $next($request);
    }
}