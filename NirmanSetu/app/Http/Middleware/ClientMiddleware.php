<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
       if (Auth::check() && (Auth::user()->role === 'client' || Auth::user()->role === 'customer')) {
    return $next($request);
}
abort(403, 'Unauthorized.');

    }
}
