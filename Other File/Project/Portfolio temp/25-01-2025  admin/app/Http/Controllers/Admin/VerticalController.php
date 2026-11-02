<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\PaymentFrequencyModel;
use App\Models\Admin\VerticalModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;


class VerticalController extends Controller
{
    // listing Vertical
    public function index(Request $request)
    {

        if ($request->ajax()) {
            // Get all Vertical
            $data = VerticalModel::all();
            // Get yajra dataTable
            return DataTables::of($data)
                ->addIndexColumn()
                // Get edit,delete btn
                ->addColumn('action', function ($row) {
                    $editUrl = 'verticals/' . $row['id'] . '/edit';
                    $deleteUrl = 'verticals/' . $row['id'];
                    // Get form to delete functionality
                    $form = '<div style="margin-left: 9px;"><form action="' . $deleteUrl . '" method="POST" class="form1">';
                    $form .= csrf_field();
                    $form .= method_field('DELETE');
                    $form .= '<button type="submit" class="delete btn btn-danger btn-sm" onclick="showConfirmation(event)">Delete</button>';
                    $form .= '</form></div>';

                    $btn = "<div><a href=" . $editUrl . " class='edit btn btn-success btn-sm'>Edit</a></div>" . $form;

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('Admin.vertical.index_vertical');
    }


    // function for create Vertical
    public function create(Request $request)
    {
        return view('Admin.vertical.create_vertical');
    }

    // function for store Vertical
    public function store(Request $request)
    {
        $validated = $request->validate([
            // 'title' =>  "required|unique:verticals,title|max:255",
            'title' =>  'required',
            'status' => 'required',
            'network_count' => 'required'
        ]);

        $verticals = $request->all();
        VerticalModel::create($verticals);
        return redirect('admin/verticals')->with('message', 'Your data successfully added');
    }

    // function for edit Vertical
    public function edit(string $id)
    {
        $vertical = VerticalModel::find($id);
        if ($vertical) {
            return view('Admin.vertical.update_vertical', $vertical);
        }
        return ['success' => false, 'msg' => 'VerticalModel Not Found !!!'];
    }
    // function for update Vertical
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'title' =>  "required|unique:verticals,id," . $id . "|max:255",
            'status' => 'required',
            'network_count' => 'required',
        ]);

        $verticals = VerticalModel::find($id);
        // When data not found
        if (!$verticals) {
            return ['success' => false, 'msg' => 'VerticalModel Not Found !!!'];
        }
        // When data found
        $verticals->title = $request->input('title');
        $verticals->status = $request->input('status');
        $verticals->icon = $request->input('icon');
        $verticals->network_count = $request->input('network_count');
        $verticals->save();
        return redirect('admin/verticals')->with('message', 'Your data successfully updated');
    }
    // function for destroy Vertical
    public function destroy(string $id)
    {
        $verticals = VerticalModel::find($id);
        // When data not found
        if (!$verticals) {
            return ['success' => false, 'msg' => 'VerticalModel Not Found !!!'];
        }
        // When data found
        $verticals->delete();
        return redirect('admin/verticals')->with('message', 'Your data successfully deleted');
    }
    // Get verticals bulk action
    public function bulkAction(Request $request)
    {
        $action = $request->input('action');
        $selectedItemsJSON = $request->input('selected_items', '[]');
        $selectedItems = json_decode($selectedItemsJSON);

        if ($action === 'delete') {
            if (!empty($selectedItems)) {
                VerticalModel::whereIn('id', $selectedItems)->delete();
                return redirect()->back()->with('message', 'Selected items deleted successfully');
            } else {
                return redirect()->back()->with('message', 'No items selected for deletion');
            }
        }
        return redirect()->back()->with('message', 'Invalid bulk action');
    }
}
