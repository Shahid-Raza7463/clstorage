<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\NetworkSoftwareModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class NetworkSoftwaresController extends Controller
{

    // Permission to roles of users
    function __construct()
    {
        $this->middleware('permission:network-software-list|network-software-create|network-software-edit|network-software-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:network-software-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:network-software-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:network-software-delete', ['only' => ['destroy']]);
    }
    // listing network software
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Get all Network Software
            $data = NetworkSoftwareModel::all();
            // Get yajra dataTable
            return DataTables::of($data)
                ->addIndexColumn()
                // Get edit,delete btn
                ->addColumn('action', function ($row) {

                    $editUrl = 'networksoftware/' . $row['id'] . '/edit';
                    $deleteUrl = 'networksoftware/' . $row['id'];
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
        return view('Admin.networksoftware.index_networkSoftwares');
    }
    // function for create Network Software
    public function create(Request $request)
    {
        return view('Admin.networksoftware.create_networkSoftwares');
    }

    // function for store Network Software
    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' =>  "required|unique:network_softwares,name|max:255",
        ]);

        $networkSoftware  = $request->all();
        NetworkSoftwareModel::create($networkSoftware);
        return redirect('admin/networksoftware')->with('message', 'Your data successfully added');
    }
    // function for edit Network Software
    public function edit(string $id)
    {
        $data = [];
        $data['networkSoftware'] = NetworkSoftwareModel::find($id);
        $data['id'] = $id;

        return view('Admin.networksoftware.update_networkSoftwares', $data);
    }

    // function for update Network Software
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' =>  "required|unique:network_softwares,id," . $id . "|max:255",
        ]);

        $networkSoftware = NetworkSoftwareModel::find($id);
        // when data not found
        if (!$networkSoftware) {
            return ['success' => false, 'msg' => 'networkSoftware not Found !!!'];
        }
        // when data found
        $networkSoftware->name = $request->input('name');
        $networkSoftware->save();
        return redirect('admin/networksoftware')->with('message', 'Your data successfully updated');
    }

    // function for destroy network Software
    public function destroy(string $id)
    {
        $networkSoftware = NetworkSoftwareModel::find($id);
        // when data not found
        if (!$networkSoftware) {
            return ['success' => false, 'msg' => 'networkSoftware not Found !!!'];
        }
        // when data found
        $networkSoftware->delete();
        return redirect('admin/networksoftware')->with('message', 'Your data successfully deleted');
    }
    // Get network software bulk action
    public function bulkAction(Request $request)
    {
        $action = $request->input('action');
        $selectedItemsJSON = $request->input('selected_items', '[]');
        $selectedItems = json_decode($selectedItemsJSON);

        if ($action === 'delete') {
            if (!empty($selectedItems)) {
                NetworkSoftwareModel::whereIn('id', $selectedItems)->delete();
                return redirect()->back()->with('message', 'Selected items deleted successfully');
            } else {
                return redirect()->back()->with('message', 'No items selected for deletion');
            }
        }
        return redirect()->back()->with('message', 'Invalid bulk action');
    }
}
