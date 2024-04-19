<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Rules\StrongPassword;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * Validation rules
     * 
     * @return array
     */
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
                'message' => 'Internal server error'
            ], 500);
        }
    }


    /**
     * Get specific user
     * 
     * @param int $id
     * 
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
                ], 400);
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
                ], 400);
            }

            return response()->json([
                'success' => true,
                'data' => $user
            ]);
        } catch (\Throwable $th) {
            // Server error
            return response()->json([
                'success' => false,
                'message' => 'Internal server error'
            ], 500);
        }
    }


    /**
     * Create new user
     * 
     * @param Request $request
     * 
     * @return Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            // Request validations
            $validated_data = $request->validate($this->rules());

            // Create user
            $user = User::create($validated_data);

            return response()->json([
                'success' => true,
                'data' => $user,
                'message' => 'User added successfully'
            ]);
        } catch (ValidationException $e) {
            // Validation errors
            return response()->json([
                'success' => false,
                'message' => $e->validator->errors()
            ], 422);
        } catch (\Throwable $th) {
            // Server error
            return response()->json([
                'success' => false,
                'message' => 'Internal server error'
            ], 500);
        }
    }


    /**
     * Update specific user
     * 
     * @param Request $request
     * @param int $id
     * 
     * @return Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            // Validate if id is numeric
            if (!is_numeric($id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid id type'
                ], 400);
            }

            // Retrieve user
            $user = User::find($id);

            // Modify email rules
            $rules = $this->rules();
            $rules['email'] = "required|string|email|max:255|unique:users,email,$user->id";

            // Request validations
            $validated_data = $request->validate($rules);

            // Validate if user is found
            if ($user === null) {
                return response()->json([
                    'success' => false,
                    'message' => "User not found"
                ], 400);
            }

            // Update user
            $user->update($validated_data);
            $user = $user->fresh();

            return response()->json([
                'success' => true,
                'data' => $user,
                'message' => 'User updated successfully'
            ]);
        } catch (ValidationException $e) {
            // Validation errors
            return response()->json([
                'success' => false,
                'message' => $e->validator->errors()
            ], 422);
        } catch (\Throwable $th) {
            // Server error
            return response()->json([
                'success' => false,
                'message' => 'Internal server error'
            ], 500);
        }
    }


    /**
     * Delete specific user
     * 
     * @param $id
     * 
     * @return Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            // Validate if id is numeric
            if (!is_numeric($id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid id type'
                ], 400);
            }

            // Retrieve User
            $user = User::find($id);

            // Validate if user is found
            if ($user === null) {
                return response()->json([
                    'success' => false,
                    'message' => "User not found"
                ], 400);
            }

            // Deletes User
            $user = $user->delete();

            return response()->json([
                'success' => true,
                'data' => $user,
                'message' => 'User deleted successfully'
            ]);
        } catch (\Throwable $th) {
            // Server error
            return response()->json([
                'success' => false,
                'message' => 'Internal server error'
            ], 500);
        }
    }
}
