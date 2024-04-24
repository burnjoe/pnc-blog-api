<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Login user account
     * 
     * @param Request $request
     * 
     * @return Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        try {
            if (Auth::attempt($request->only("email", "password"))) {
                $user = Auth::user();
                // Create token then retrieve it
                $token = $user->createToken("app")->accessToken;

                return response([
                    'success' => true,
                    'data' => $user,
                    'message' => "Login successfully",
                    'token' => $token,
                ], 200);
            }
        } catch (Exception $exception) {
            return response([
                'success' => false,
                'message' => $exception->getMessage(),
            ], 400);
        }

        // If email is non-existent or wrong password
        return response([
            'success' => false,
            'message' => 'Invalid email or password',
        ], 401);
    }
    

    /**
     * Register user account
     * 
     * @param RegisterRequest $request
     * 
     * @return Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        try {
            // Create user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'account_type' => $request->account_type,
                'provider' => $request->provider,
            ]);

            // Create token then retrieve it
            $token = $user->createToken('app')->accessToken;
            
            return response([
                'success' => true,
                'data' => $user,
                'message' => "Registered successfully",
                'token' => $token,
            ], 200);
        } catch (Exception $exception) {
            return response([
                'success' => false,
                'message' => $exception->getMessage(),
            ], 400);
        }
    }
}
