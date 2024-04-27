<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PermissionWriter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // If user is not authorized
        if (!Auth::check()) {
            return abort(response()->json([
                'success' => false,
                'message' => 'Unauthorized Access'
            ], 401));
        }

        // If authenticated user is not a writer
        if (Auth::user()->account_type !== "Writer") {
            return abort(response()->json([
                'success' => false,
                'message' => 'Forbidden'
            ], 403));
        }
        
        return $next($request);
    }
}
