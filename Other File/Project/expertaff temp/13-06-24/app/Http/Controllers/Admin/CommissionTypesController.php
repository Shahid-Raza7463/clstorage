<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\CommissionTypeModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CommissionTypesController extends Controller
{
    // listing Commission type
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Get all commission type
            $data = CommissionTypeModel::all();
            // Get yajra dataTable
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    // Get edit,delete btn
                    $editUrl = 'commissiontype/' . $row['id'] . '/edit';
                    $deleteUrl = 'commissiontype/' . $row['id'];
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
        return view('Admin.commissiontype.index_commissionTypes');
    }

    // function for create commission type
    public function create(Request $request)
    {
        return view('Admin.commissiontype.create_commissionTypes');
    }

    // function for store commission type
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' =>  "required|unique:commission_types,name|max:255",
        ]);

        $commissionType  = $request->all();
        CommissionTypeModel::create($commissionType);
        return redirect('admin/commissiontype')->with('message', 'Your data successfully added');
    }

    // function for edit commission type
    public function edit(string $id)
    {
        $data = [];
        $data['commissionType'] = CommissionTypeModel::find($id);
        // when data not found
        if (!$data) {
            return ['success' => false, 'msg' => 'commissiontype not Found !!!'];
        }
        $data['id'] = $id;

        return view('Admin.commissiontype.update_commissionTypes', $data);
    }

    // function for update commission type
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' =>  "required|unique:commission_types,id," . $id . "|max:255",
        ]);

        $commissionType = CommissionTypeModel::find($id);
        // when data not found
        if (!$commissionType) {
            return ['success' => false, 'msg' => 'commissiontype not Found !!!'];
        }
        // when data found
        $commissionType->name = $request->input('name');
        $commissionType->save();
        return redirect('admin/commissiontype')->with('message', 'Your data successfully updated');
    }

    // function for destroy commission type
    public function destroy(string $id)
    {
        $commissionType = CommissionTypeModel::find($id);
        // when data not found
        if (!$commissionType) {
            return ['success' => false, 'msg' => 'commissiontype not Found !!!'];
        }
        $commissionType->delete();
        return redirect('admin/commissiontype')->with('message', 'Your data successfully deleted');
    }
    // Get commission type bulk action
    public function bulkAction(Request $request)
    {
        $action = $request->input('action');
        $selectedItemsJSON = $request->input('selected_items', '[]');
        $selectedItems = json_decode($selectedItemsJSON);

        if ($action === 'delete') {
            if (!empty($selectedItems)) {
                CommissionTypeModel::whereIn('id', $selectedItems)->delete();
                return redirect()->back()->with('message', 'Selected items deleted successfully');
            } else {
                return redirect()->back()->with('message', 'No items selected for deletion');
            }
        }
        return redirect()->back()->with('message', 'Invalid bulk action');
    }
}
