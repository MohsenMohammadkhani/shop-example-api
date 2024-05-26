<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TokenInHeaderMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            if (!$request->header('Authorization')) {
                return response()->json([
                    'message' => __('auth.authorization_is_not_exist_on_request_header'),
                ], 401);
            }

            if (!str_contains($request->header('Authorization'), 'Bearer ')) {
                return response()->json([
                    'message' => __('auth.authorization_token_is_invalid'),
                ], 401);
            }

            return $next($request);
        } catch (\Exception $error) {
            dd('333');
            return response()->json([
                'message' => $error->getMessage(),
            ], 500);
        }
    }
}
