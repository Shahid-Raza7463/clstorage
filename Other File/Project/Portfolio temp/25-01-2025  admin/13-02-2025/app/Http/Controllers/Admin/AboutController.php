<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\About;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AboutController extends Controller
{
    // listing Commission type
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Get all commission type
            $data = About::all();
            // dd($data);
            // Get yajra dataTable
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    // Get edit,delete btn
                    $editUrl = 'about/' . $row['id'] . '/edit';
                    $deleteUrl = 'about/' . $row['id'];
                    // Get form to delete functionality
                    $form = '<div style="margin-left: 9px;"><form action="' . $deleteUrl . '" method="POST" class="form1">';
                    $form .= csrf_field();
                    $form .= method_field('DELETE');
                    $form .= '<button type="submit" class="delete btn btn-danger btn-sm" onclick="showConfirmation(event)">Delete</button>';
                    $form .= '</form></div>';

                    $btn = "<div><a href=" . $editUrl . " class='edit btn btn-success btn-sm'></i>Edit</a></div>" . $form;

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('Admin.about.aboutindex');
    }

    // function for create commission type
    public function create(Request $request)
    {
        return view('Admin.about.create_commissionTypes');
    }

    // function for store commission type
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' =>  "required|unique:commission_types,name|max:255",
        ]);

        $about  = $request->all();
        About::create($about);
        return redirect('admin/about')->with('message', 'Your data successfully added');
    }

    // function for edit commission type
    public function edit(string $id)
    {
        $data = [];
        $data['about'] = About::find($id);
        // when data not found
        if (!$data) {
            return ['success' => false, 'msg' => 'about not Found !!!'];
        }
        $data['id'] = $id;

        return view('Admin.about.update_commissionTypes', $data);
    }

    // function for update commission type
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' =>  "required|unique:commission_types,id," . $id . "|max:255",
        ]);

        $about = About::find($id);
        // when data not found
        if (!$about) {
            return ['success' => false, 'msg' => 'about not Found !!!'];
        }
        // when data found
        $about->name = $request->input('name');
        $about->save();
        return redirect('admin/about')->with('message', 'Your data successfully updated');
    }

    // function for destroy commission type
    public function destroy(string $id)
    {
        $about = About::find($id);
        // when data not found
        if (!$about) {
            return ['success' => false, 'msg' => 'about not Found !!!'];
        }
        $about->delete();
        return redirect('admin/about')->with('message', 'Your data successfully deleted');
    }
    // Get commission type bulk action
    public function bulkAction(Request $request)
    {
        $action = $request->input('action');
        $selectedItemsJSON = $request->input('selected_items', '[]');
        $selectedItems = json_decode($selectedItemsJSON);

        if ($action === 'delete') {
            if (!empty($selectedItems)) {
                About::whereIn('id', $selectedItems)->delete();
                return redirect()->back()->with('message', 'Selected items deleted successfully');
            } else {
                return redirect()->back()->with('message', 'No items selected for deletion');
            }
        }
        return redirect()->back()->with('message', 'Invalid bulk action');
    }
}
