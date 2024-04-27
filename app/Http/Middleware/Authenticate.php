<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // Aborts json response when user is unauthorized
        return $request->expectsJson() ? null : abort(response()->json([
            'success' => false,
            'message' => 'Unauthorized Access'
        ], 401));
    }
}
