<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',    // 2MB
            'status' => 'required|boolean',
            'writer_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
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
            // Assign authenticated user as the writer of the post
            $request->merge(['writer_id' => Auth::id()]);

            // Request validations
            $validated_data = $request->validate($this->rules());

            // Store image in storage/app/public/images if has input 'image'
            if ($request->hasFile('image')) {
                $validated_data['image'] = $request->file('image')->store('images', 'public');
            }

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


    /**
     * Update specific post
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

            // Assign authenticated user as the writer of the post
            $request->merge(['writer_id' => Auth::id()]);

            // Request validations
            $validated_data = $request->validate($this->rules());

            // Retrieve post
            $post = Post::find($id);

            // Validate if post is found
            if ($post === null) {
                return response()->json([
                    'success' => false,
                    'message' => "Post not found"
                ], 400);
            }

            // Store image in storage/app/public/images if has input 'image'
            if ($request->hasFile('image')) {
                // Delete current image if there is
                if ($post->image) {
                    Storage::disk('public')->delete($post->image);
                }

                // Store new image
                $validated_data['image'] = $request->file('image')->store('images', 'public');
            }

            // Update post
            $post->update($validated_data);
            $post = $post->fresh();

            return response()->json([
                'success' => true,
                'data' => $post,
                'message' => 'Post updated successfully'
            ]);
        } catch (ValidationException $e) {
            // Validation errors
            return response()->json([
                'success' => false,
                'message' => $e->validator->errors()->all()
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
     * Delete specific post
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

            // Retrieve post
            $post = Post::find($id);

            // Validate if post is found
            if ($post === null) {
                return response()->json([
                    'success' => false,
                    'message' => "Post not found"
                ], 400);
            }

            // Delete post image if there is
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }

            // Delete Post
            $post = $post->delete();

            return response()->json([
                'success' => true,
                'message' => 'Post deleted successfully'
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
