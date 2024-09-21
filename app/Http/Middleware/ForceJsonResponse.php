<?php

namespace App\Http\Middleware;

use Closure;
// use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ForceJsonResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Test Work
        // dd('test');


        if (app()->environment('local')) {
            $response = $next($request);
            if (!$response instanceof JsonResponse) {
                return response()->json($response->getContent(), $response->status(), $response->headers->all());
            }
        }

        return $next($request);
    }
}
