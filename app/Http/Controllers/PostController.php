<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

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
            'title' => 'required|string|min:2|max:255',
            'slug' => 'required|string',
            'description' => 'required',
            'image' => 'file|image|mimes:jpeg,png,jpg|max:2048',    // 2MB
            'status' => 'required|boolean',
            'writer_id' => 'required|exists',
            'category_id' => 'required',
        ];
    }


    /**
     * Get all posts
     * 
     * @return Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            // Retrieve All Posts
            $post = Post::with('writer', 'category')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $post
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Internal server error'
            ], 500);
        }
    }


    /**
     * Get specific post
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

            // Retrieve Post
            $post = Post::with('writer', 'category')
                ->where('id', $id)
                ->first();

            // Validate if post is found
            if ($post === null) {
                return response()->json([
                    'success' => false,
                    'message' => "Post not found"
                ], 400);
            }

            return response()->json([
                'success' => true,
                'data' => $post
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
     * Create new post
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

            // Create post
            $post = Post::create($validated_data);

            return response()->json([
                'success' => true,
                'data' => $post,
                'message' => 'Post added successfully'
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
}
