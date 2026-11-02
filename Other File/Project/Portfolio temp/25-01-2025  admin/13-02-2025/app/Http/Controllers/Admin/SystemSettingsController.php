<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\SystemSettingModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SystemSettingsController extends Controller
{
    // listing Settings featured
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Get all Settings featured
            $data = SystemSettingModel::all();
            // Get yajra dataTable
            return DataTables::of($data)
                ->addIndexColumn()
                // Get edit,delete btn
                ->addColumn('action', function ($row) {

                    $editUrl = 'systemsettings/' . $row['id'] . '/edit';
                    $deleteUrl = 'systemsettings/' . $row['id'];
                    // Get form to delete functionality
                    $form = '<div style="margin-left: 9px;"><form action="' . $deleteUrl . '" method="POST" class="form1">';
                    $form .= csrf_field();
                    $form .= method_field('DELETE');
                    $form .= '<button type="submit" class="delete btn btn-danger btn-sm" onclick="showConfirmation(event)">Delete</button>';
                    $form .= '</form></div>';

                    $btn = '<div style="display: flex;
                    margin-left: 5px;">' . "<a href=" . $editUrl . " class='edit btn btn-primary btn-sm' style='height: 31px;'></i>Edit</a>" .
                        $form .
                        '</div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('Admin.system_settings.index');
    }
    // function for edit Settings featured
    public function edit(string $id)
    {
        $data = [];
        $data['systemsettings'] = SystemSettingModel::find($id);

        $data['id'] = $id;
        return view('Admin.system_settings.update', $data);
    }
    // function for update Settings featured
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'option_name' =>  'required',
            'option_value' =>  'required'
        ]);

        $system = SystemSettingModel::find($id);
        // When data not found
        if (!$system) {
            return ['success' => false, 'msg' => 'Data not Found !'];
        }
        // When data found
        $system->option_name = $request->input('option_name');
        $system->option_value = $request->input('option_value');
        $system->auto_load = $request->input('auto_load');

        $system->save();
        return redirect('admin/systemsettings')->with('message', 'Your data successfully updated');
    }
    // function for destroy Settings featured
    public function destroy(string $id)
    {
        $system = SystemSettingModel::find($id);
        $system->delete();
        return redirect('admin/systemsettings')->with('message', 'Your data successfully deleted');
    }
    // Get settings featured bulk action
    public function bulkAction(Request $request)
    {
        $action = $request->input('action');
        $selectedItemsJSON = $request->input('selected_items', '[]');
        $selectedItems = json_decode($selectedItemsJSON);

        if ($action === 'delete') {
            if (!empty($selectedItems)) {
                SystemSettingModel::whereIn('id', $selectedItems)->delete();
                return redirect()->back()->with('message', 'Selected items deleted successfully');
            } else {
                return redirect()->back()->with('message', 'No items selected for deletion');
            }
        }
        return redirect()->back()->with('message', 'Invalid bulk action');
    }
}
