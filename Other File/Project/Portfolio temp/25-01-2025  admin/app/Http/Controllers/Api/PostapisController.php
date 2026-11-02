<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Api\Postapi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostapisController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('auth:api');
    // }
    // public function __construct()
    // {
    //     $this->middleware('auth:sanctum');
    // }

    // public function index()
    // {
    //     $data['posts'] = Postapi::all();
    //     return response()->json([
    //         'status' => true,
    //         'message' => 'All posts data.',
    //         'data' => $data
    //     ], 200);
    // }

        public function index()
    {
        // Retrieve all posts
        $posts = Postapi::all();

        // Transform posts to match the desired structure
        $formattedPosts = $posts->map(function ($post) {
            return [
                'id' => $post->id,
                'title' => $post->title,
                'description' => $post->description,
                'created_at' => $post->created_at,
                'updated_at' => $post->updated_at,
            ];
        });

        // Return the response in the required format
        return response()->json($formattedPosts, 200);
    }

    public function show(string $id)
    {
        $data['posts'] = Postapi::select('id', 'title', 'description')
            ->where(['id' => $id])
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Your single post.',
            'data' => $data
        ], 200);
    }

    public function store(Request $request)
    {
        $validateUser = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
        ]);

        if ($validateUser->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error.',
                'errors' =>  $validateUser->errors()->all()
            ], 401);
        }

        $post = Postapi::create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Post created successfull.',
            'data' => $post
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $validateUser = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
        ]);

        if ($validateUser->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error.',
                'errors' =>  $validateUser->errors()->all()
            ], 401);
        }

        $post = Postapi::where(['id' => $id])->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Post updated successfull.',
            'data' => $post
        ], 200);
    }

    public function destroy(string $id)
    {
        $post = Postapi::where(['id' => $id])->delete();
        return response()->json([
            'status' => true,
            'message' => 'Your post Deleted.',
            'data' => $post
        ], 200);
    }
}
