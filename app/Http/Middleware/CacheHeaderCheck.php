<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CacheHeaderCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->hasHeader('X-Cdn-Header') && $request->header('X-Cdn-Header') === config('app.cdn_header_key')) {
            return $next($request);
        }
        throw new \Exception('Unauthorized');
    }
}
