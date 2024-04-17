<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Rules\StrongPassword;

class UserController extends Controller
{
    // Rules
    public function rules()
    {
        return [
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'image' => 'file|image|mimes:jpeg,png,jpg|max:2048', // 2MB
            'password' => ['required', 'string', 'min:8', 'confirmed', new StrongPassword],
            'account_type' => 'required|string|in:Writer',
            'provider' => 'required|string|min:2|max:255'
        ];
    }


    /**
     * Get all users
     * 
     * @return Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            // Retrieve All Users
            $user = User::select('name', 'email', 'image', 'account_type', 'provider', 'email_verified_at', 'created_at', 'updated_at')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $user
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Internal error'
            ], 500);
        }
    }


    /**
     * Get specific user
     * 
     * @param int $id
     * @return Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            // Validate if id is numeric
            if (!is_numeric($id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid id type'
                ]);
            }
            
            // Retrieve User
            $user = User::select('name', 'email', 'image', 'account_type', 'provider', 'email_verified_at', 'created_at', 'updated_at')
                ->where('id', $id)
                ->first();

            // Validate if user is found
            if ($user === null) {
                return response()->json([
                    'success' => false,
                    'message' => "User not found"
                ]);            
            }

            return response()->json([
                'success' => true,
                'data' => $user
            ]);            
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Internal error'
            ], 500);
        }
    }
}
