<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class FollowController extends Controller
{
    /**
     * Follow specific writer
     * 
     * @param Request $request
     * @param int $id
     * 
     * @return Illuminate\Http\JsonResponse
     */
    public function store(Request $request, $id) {
        try {
            // Validate required id parameter
            if (!isset($id) || empty($id)) {
                return response()->json([
                    'success' => false,
                    'message' => "Required 'id' parameter not filled"
                ], 400);
            }

            // Validate if id is numeric
            if (!is_numeric($id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid id type'
                ], 400);
            }

            // TODO: Replace 1 with $this->auth()
            // Validate equality of current user's id and request's id
            if ($id === 1) {
                return response()->json([
                    'success' => false,
                    'message' => "Invalid follow request"
                ], 400);
            }

            // Validate if id exists in users
            if (!User::where('id', $id)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 400);
            }
            
            // TODO: Replace 1 with $this->auth()
            // Validate if auth() still not follows user with $id
            if (Follow::where('writer_id', $id)->where('follower_id', 1)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are already following this user'
                ], 400);
            }
            
            // TODO: Replace follower_id value with $this->auth()
            // Create Follow / Follow User
            $follow = Follow::create([
                'writer_id' => $id,
                'follower_id' => 1
            ]);

            unset($follow['id']);

            return response()->json([
                'success' => true,
                'data' => $follow,
                'message' => 'User followed successfully'
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
     * Unfollow specific writer
     * 
     * @param int $id
     * 
     * @return Illuminate\Http\JsonResponse
     */
    public function destroy($id) {
        try {
            // Validate if id is numeric
            if (!is_numeric($id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid id type'
                ], 400);
            }

            // TODO: Replace 1 with $this->auth()
            // Validate equality of current user's id and request's id
            if ($id == 1) {
                return response()->json([
                    'success' => false,
                    'message' => "Invalid unfollow request"
                ], 400);
            }

            // TODO: Replace find() value with $this->auth()
            // Eager load user with followings
            $following = User::find(1)
                ->followings()
                ->where('writer_id', $id)
                ->take(1);

            // Validate if user's following is found
            if (!$following->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => "User not found"
                ], 400);
            }

            // Delete Follow / Unfollow User
            $following = $following->delete();

            return response()->json([
                'success' => true,
                'data' => $following,
                'message' => 'User unfollowed successfully'
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
