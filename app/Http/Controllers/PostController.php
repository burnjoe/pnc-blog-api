<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    
    /**
     * Validation rules
     * 
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'slug' => 'required',
            'description' => 'required',
            'image' => '',
            'status' => 'required',
            'writer_id' => 'required',
            'category_id' => 'required',
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
            $user = Post::with('writer', 'category')
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
}
