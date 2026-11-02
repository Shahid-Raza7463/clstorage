<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Api\Friendslistapi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FriendslistapisController extends Controller
{
    // public function index()
    // {
    //     $data = Friendslistapi::all();
    //     return response()->json([
    //         'users' => $data
    //     ], 200);
    // }

     public function index()
    {
        // Retrieve all posts
        $posts = Friendslistapi::all();

        // Transform posts to match the desired structure
        $formattedPosts = $posts->map(function ($post) {
            return [
                'id' => $post->id,
                'name' => $post->name,
                'color' => $post->color,
                'image' => $post->image,
                'created_at' => $post->created_at,
                'updated_at' => $post->updated_at,
            ];
        });

        // Return the response in the required format
        return response()->json($formattedPosts, 200);
    }

    public function show(string $id)
    {
        $data['friends'] = Friendslistapi::select('id', 'name', 'color', 'image')
            ->where(['id' => $id])
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Your single friends.',
            'data' => $data
        ], 200);
    }

    public function store(Request $request)
    {
        $validateUser = Validator::make($request->all(), [
            'name' => 'required',
            'color' => 'required',
            // 'image' => 'required',
        ]);

        if ($validateUser->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error.',
                'errors' =>  $validateUser->errors()->all()
            ], 401);
        }

        $friends = Friendslistapi::create([
            'name' => $request->name,
            'color' => $request->color,
            // 'image' => $request->image,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'friends created successfull.',
            'data' => $friends
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $validateUser = Validator::make($request->all(), [
            'name' => 'required',
            'color' => 'required',
        ]);

        if ($validateUser->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error.',
                'errors' =>  $validateUser->errors()->all()
            ], 401);
        }

        $friends = Friendslistapi::where(['id' => $id])->update([
            'name' => $request->name,
            'color' => $request->color,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'friends updated successfull.',
            'data' => $friends
        ], 200);
    }

    public function destroy(string $id)
    {
        $friends = Friendslistapi::where(['id' => $id])->delete();
        return response()->json([
            'status' => true,
            'message' => 'Your friends Deleted.',
            'data' => $friends
        ], 200);
    }
}
