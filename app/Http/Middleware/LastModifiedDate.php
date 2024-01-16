<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LastModifiedDate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        if ($request->todo) {
            $response->header('Last-Modified', $request->todo->updated_at->format('D, d M Y H:i:s') . ' GMT');
        }
        return $response;
    }
}
