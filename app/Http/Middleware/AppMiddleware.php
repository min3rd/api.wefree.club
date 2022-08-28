<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AppMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if(!$request->header("Authorization")){
            return response("Unauthorized", 401);
        }
        $response = $next($request);
        // Perform action
        return $response;
    }
}
