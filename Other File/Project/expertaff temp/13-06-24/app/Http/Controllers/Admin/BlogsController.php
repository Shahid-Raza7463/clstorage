<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\NetworkWebController;
use App\Models\Admin\Blog;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BlogsController extends Controller
{
    // listing Blog
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Get all Blog
            $data = Blog::all();
            // Get yajra dataTable
            return DataTables::of($data)
                ->addIndexColumn()
                // Get edit,delete and views btn
                ->addColumn('action', function ($row) {

                    $deleteUrl = 'blog/' . $row['id'];
                    $editUrl = 'blog/' . $row['id'] . '/edit';
                    $viewUrl = 'blog/' . $row['id'];
                    // Get form to delete functionality
                    $form = '<div style="margin-left: 9px;"><form action="' . $deleteUrl . '" method="POST" class="form1">';
                    $form .= csrf_field();
                    $form .= method_field('DELETE');
                    $form .= '<button type="submit" class="delete btn btn-danger btn-sm" onclick="showConfirmation(event)">Delete</button>';
                    $form .= '</form></div>';

                    $btn = "<div><a href=" . $viewUrl . " class='edit btn btn-success btn-sm'></i>View</a></div><div><a href=" . $editUrl . " class='edit btn btn-primary btn-sm' style='margin-left: 9px;'></i>Edit</a></div>" . $form;

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('Admin.blogs.index');
    }

    // function for create Blog
    public function create(NetworkWebController $nwc)
    {
        // Get all networks
        $networks =  $nwc->get_premium_networks();
        // Get name of verticals in ascending order
        $network_categories = $nwc->get_verticals();
        return view('Admin.blogs.create', [
            'network_categories' => $network_categories,
            'networks' => $networks
        ]);
    }
    // function for store Blog
    public function store(Request $request)
    {
        $user = $request->user();
        $validated = $request->validate([
            'title' =>  "required",
            'description' =>  "required",
            'preview_image' =>  "required",
            'category' =>  "required",
            'network_id' =>  "required",
            'meta_title' =>  "required",
            'tags' =>  "required",
            'meta_description' =>  "required",
        ]);

        $blogs = new Blog();
        $blogs->title = $request['title'];
        $blogs->description = $request['description'];
        $blogs->category = $request['category'];
        $blogs->network_id = $request['network_id'];
        $blogs->add_user = $user->id;
        $blogs->meta_title = $request['meta_title'];
        $blogs->meta_description = $request['meta_description'];
        $blogs->tags = $request['tags'];
        $blogs->status = $request['status'];
        // Get title and insert slug in database
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
    // function for upload image
    public function upload(Request $request)
    {
        $path = $request->file('blogs')->store('images');
        Blog::insert($path);
    }

    // function for views Blog
    public function show(string $id)
    {
        $data = Blog::find($id);
        return view('Admin.blogs.show', ['data' => $data]);
    }

    // function for edit Blog
    public function edit(NetworkWebController $nwc, string $id)
    {
        $data = [];
        $data['blog'] = Blog::find($id);
        // Get id in url of blade file
        $data['id'] = $id;
        // Get all networks
        $networks =  $nwc->get_premium_networks();
        // Get name of verticals in ascending order
        $network_categories = $nwc->get_verticals();

        return view('Admin.blogs.update', $data)->with([
            'network_categories' => $network_categories,
            'networks' => $networks
        ]);
    }
    // function for update Blog
    public function update(Request $request, string $id)
    {
        $user = $request->user();
        $validated = $request->validate([
            'title' =>  "required",
            'description' =>  "required",
            'category' =>  "required",
            'network_id' =>  "required",
            'meta_title' =>  "required",
            'tags' =>  "required",
            'meta_description' =>  "required"
        ]);

        $blogs = Blog::find($id);

        $blogs->title = $request->input('title');
        $blogs->description = $request->input('description');
        $blogs->category = $request->input('category');
        $blogs->network_id = $request->input('network_id');
        $blogs->update_user = $user->id;
        $blogs->meta_title = $request->input('meta_title');
        $blogs->tags = $request->input('tags');
        $blogs->status = $request->input('status');
        $blogs->meta_description = $request->input('meta_description');
        // Get title and insert slug in database
        $slug = strtolower(str_replace(' ', '-', $request->input('title')));
        $blogs->slug = $slug;

        // save path of image in table
        if ($request->hasFile('preview_image')) {
            $path = $request->file('preview_image')->store('images');
            $blogs->preview_image = $path;
        }
        $blogs->save();
        return redirect('admin/blog')->with('message', 'Your data successfully updated');
    }

    // function for destroy Blog
    public function destroy(string $id)
    {
        $blog = Blog::find($id);
        $blog->delete();
        return redirect('admin/blog')->with('message', 'Your data successfully deleted');
    }
    // Get blogs bulk action
    public function bulkAction(Request $request)
    {
        $action = $request->input('action');
        $selectedItemsJSON = $request->input('selected_items', '[]');
        $selectedItems = json_decode($selectedItemsJSON);

        if ($action === 'delete') {
            if (!empty($selectedItems)) {
                Blog::whereIn('id', $selectedItems)->delete();
                return redirect()->back()->with('message', 'Selected items deleted successfully');
            } else {
                return redirect()->back()->with('message', 'No items selected for deletion');
            }
        }
        return redirect()->back()->with('message', 'Invalid bulk action');
    }
}
