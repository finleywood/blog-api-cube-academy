<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Info(title="Blog Post API", version="1.0")
 */
class PostController extends Controller
{
    /**
    * @OA\Get(
    *      path="/api/posts",
    *      summary="Get all posts",
    *      tags={"Posts"},
    *      @OA\Response(response=200, description="Success"),
    *      @OA\Response(response=500, description="Server Error"),
    *      @OA\PathItem()
    *      )
    */
    public function index(): JsonResponse
    {
        return response()->json(Post::all(), 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Get the user id from the authenticated user
        $request['user_id'] = Auth::user()->id;

        // Get User name as author
        $request['author'] = Auth::user()->name;

        $post = Post::create($request->all());
        return response()->json($post, 201);
    }

    public function show($id): JsonResponse
    {
        $post = Post::find($id);
        if (is_null($post)) {
            return response()->json(['message' => 'Post not found'], 404);
        }
        return response()->json($post, 200);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $post = Post::find($id);
        if (is_null($post)) {
            return response()->json(['message' => 'Post not found'], 404);
        }
        // Confirm the user is the owner of the post
        // If not, return an error message
        //

        if (Auth::user()->id != $post->user_id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $post->update($request->all());
        return response()->json($post, 200);
    }

    public function destroy($id): JsonResponse
    {
        $post = Post::find($id);
        if (is_null($post)) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        // Confirm the user is the owner of the post

        if (Auth::user()->id != $post->user_id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $post->delete();
        return response()->json(null, 204);
    }
}
