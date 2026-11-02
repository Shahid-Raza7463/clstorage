<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Blog;
use Illuminate\Http\Request;

class BlogsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Blog::all();
        return view('Admin.blogs.index', ['data' => $data]);
    }

    public function create()
    {
        return view('Admin.blogs.create');
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $validated = $request->validate([
            'title' =>  "required",
            'description' =>  "required",
            'preview_image' =>  "required",
        ]);

        $blogs = new Blog();
        $blogs->title = $request['title'];
        $blogs->description = $request['description'];

        $slug = strtolower(str_replace(' ', '-', $request['title']));
        $blogs->slug = $slug;
        // Insert image path in table for image_url
        if ($request->hasFile('preview_image')) {
            $path = $request->file('preview_image')->store('images');
            $blogs->preview_image = $path;
        }
        $blogs->save();
        return redirect('admin/blog')->with('message', 'Your data successfully added');
    }

    public function upload(Request $request)
    {
        $path = $request->file('blogs')->store('images');
        Blog::insert($path);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Blog::find($id);
        return view('Admin.blogs.show', ['data' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = [];
        $data['blog'] = Blog::find($id);
        // Get id in url of blade file
        $data['id'] = $id;
        return view('Admin.blogs.update', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = $request->user();
        $validated = $request->validate([
            'title' =>  "required",
            'description' =>  "required",
        ]);
        $blogs = Blog::find($id);
        $blogs->title = $request->input('title');
        $blogs->description = $request->input('description');
        $slug = strtolower(str_replace(' ', '-', $request->input('title')));
        $blogs->slug = $slug;
        if ($request->hasFile('preview_image')) {
            $path = $request->file('preview_image')->store('images');
            $blogs->preview_image = $path;
        }
        $blogs->save();
        return redirect('admin/blog')->with('message', 'Your data successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $blog = Blog::find($id);
        $blog->delete();
        return redirect('admin/blog')->with('message', 'Your data successfully deleted');
    }
}
