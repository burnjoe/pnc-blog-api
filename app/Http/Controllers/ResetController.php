<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResetRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class ResetController extends Controller
{
    /**
     * Reset Password
     * 
     * @param ResetRequest $request
     * 
     * @return Illuminate\Http\JsonResponse
     */
    public function ResetPassword(ResetRequest $request)
    {
        $email = $request->email;
        $token = $request->token;
        $password = Hash::make($request->password);

        // Retrieve email and token
        $hasEmail = DB::table('password_reset_tokens')->where('email', $email)->exists();
        $hasToken = DB::table('password_reset_tokens')->where('token', $token)->exists();

        // Check if email and token exists
        if (!$hasEmail || !$hasToken) {
            return response([
                'success' => false,
                'message' => 'Invalid reset request'
            ], 401);
        }
        
        // Update user's password
        User::where('email', $email)->update(['password' => $password]);
        
        // Delete reset password request token
        DB::table('password_reset_tokens')->where('email', $email)->delete();
        
        return response([
            'success' => false,
            'message' => 'Reset password successfully'
        ]);
    }
}
