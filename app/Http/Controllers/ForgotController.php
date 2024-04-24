<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgetRequest;
use App\Mail\ForgetMail;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ForgotController extends Controller
{
    /**
     * Request Forgot Password Token
     * 
     * @param ForgetRequest $request
     * 
     * @return Illuminate\Http\JsonResponse
     */
    public function forgotPassword(ForgetRequest $request)
    {
        $email = $request->email;

        if (User::where('email', $email)->doesntExist()) {
            return response([
                'success' => false,
                'message' => 'Invalid email'
            ], 401);
        }

        // If email exists generate new password reset token
        $token = rand(10, 100000);

        try {
            // Create password reset token
            DB::table('password_reset_tokens')->insert([
                'email' => $email,
                'token' => $token
            ]);

            // Mail the message
            Mail::to($email)->send(new ForgetMail($token));

            return response([
                'success' => true,
                'message' => 'Password reset token sent to email'
            ]);
        } catch (Exception $exception) {
            return response([
                'success' => false,
                'message' => $exception->getMessage(),
            ], 400);
        }
    }
}
