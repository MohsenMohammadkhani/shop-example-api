<?php

namespace App\Http\Middleware;

use App\Services\Auth\JWTToken;
use Closure;
use Illuminate\Http\Request;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, string $permissionName)
    {
        try {

            if (!$request->header('Authorization')) {
                return response()->json([
                    'message' => __('auth.authorization_is_not_exist_on_request_header'),
                ], 401);
            }

            $jwtToken = (str_replace("Bearer ", "", $request->header('Authorization')));
            $userPermissions = JWTToken::decode($jwtToken)->permissions;

            if (!in_array($permissionName, $userPermissions)) {
                return response()->json([
                    'message' => __('auth.you_do_not_have_require_permission'),
                ], 403);
            }
            return $next($request);
        } catch (\Exception $error) {
            return response()->json([
                'message' => $error->getMessage(),
            ], 500);
        }
    }
}
