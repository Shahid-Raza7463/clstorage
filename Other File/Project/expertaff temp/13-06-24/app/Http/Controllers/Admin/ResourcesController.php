<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\ResourcesWebController;
use App\Models\Admin\ResourceModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ResourcesController extends Controller
{
    // listing Resource
    public function index(ResourcesWebController $rwc)
    {

        $resources = $rwc->get_resources(0);
        return view('Admin.resources.index_resources', ['resources' => $resources]);
    }
    // function for create Resource
    public function create()
    {
        $categoriesTitle = ResourceModel::where('parent_id', 0)->get();
        $subTitles = ResourceModel::where('parent_id', '<>', 0)->get();

        return view('Admin.resources.create_resources', [
            'categoriesTitle' => $categoriesTitle,
            'subTitle' => $subTitles,
        ]);
    }
    // function for store Resource
    public function store(Request $request)
    {
        $validated = $request->validate([
            'categories_title' =>  "required",
            'link' =>  "required"
        ]);

        $resourcelist  = $request->all();
        ResourceModel::create($resourcelist);
        return redirect('admin/resourcelist')->with('message', 'Your data successfully added');
    }
    // function for edit Resource
    public function edit(string $id)
    {

        $categoriesTitle = ResourceModel::where('parent_id', 0)->get();
        $subTitles = ResourceModel::where('parent_id', '<>', 0)->get();
        $data = [];
        $data['resourcelist'] = ResourceModel::find($id);

        $data['id'] = $id;

        return view('Admin.resources.update_resources', $data)->with([
            'categoriesTitle' => $categoriesTitle,
            'subTitle' => $subTitles,
        ]);
    }
    // function for update Resource
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'categories_title' =>  'required',
            // 'link' =>  'required',
            'status' =>  'required',
        ]);

        $resource = ResourceModel::find($id);
        $resource->categories_title = $request->input('categories_title');
        $resource->link = $request->input('link');
        $resource->status = $request->input('status');
        $resource->description = $request->input('description');

        $resource->save();
        return redirect('admin/resourcelist')->with('message', 'Your data successfully updated');
    }
    // function for destroy Resource
    public function destroy(string $id)
    {
        $resource = ResourceModel::find($id);
        $resource->delete();
        return redirect('admin/resourcelist')->with('message', 'Your data successfully deleted');
    }
    // Get resource bulk action
    public function bulkAction(Request $request)
    {
        $action = $request->input('action');
        $selectedItemsJSON = $request->input('selected_items', '[]');
        $selectedItems = json_decode($selectedItemsJSON);

        if ($action === 'delete') {
            if (!empty($selectedItems)) {
                ResourceModel::whereIn('id', $selectedItems)->delete();
                return redirect()->back()->with('message', 'Selected items deleted successfully');
            } else {
                return redirect()->back()->with('message', 'No items selected for deletion');
            }
        }
        return redirect()->back()->with('message', 'Invalid bulk action');
    }
}
