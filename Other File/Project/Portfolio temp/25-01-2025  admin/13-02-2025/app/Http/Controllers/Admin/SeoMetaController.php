<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\SeoMeta;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SeoMetaController extends Controller
{
    // listing Seo Meta
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Get all Seo Meta
            $data = SeoMeta::all();
            // Get yajra dataTable
            return DataTables::of($data)
                ->addIndexColumn()
                // Get edit,delete btn
                ->addColumn('action', function ($row) {

                    $editUrl = 'seo-meta/' . $row['id'] . '/edit';
                    $deleteUrl = 'seo-meta/' . $row['id'];
                    // Get form to delete functionality
                    $form = '<div style="margin-left: 9px;"><form action="' . $deleteUrl . '" method="POST" class="form1">';
                    $form .= csrf_field();
                    $form .= method_field('DELETE');
                    $form .= '<button type="submit" class="delete btn btn-danger btn-sm" onclick="showConfirmation(event)">Delete</button>';
                    $form .= '</form></div>';

                    $btn = "<div><a href=" . $editUrl . " class='edit btn btn-primary btn-sm'></i>Edit</a></div>" . $form;

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('Admin.seometa.index');
    }
    // function for edit Seo Meta
    public function edit(string $id)
    {
        $data = [];
        $data['seo_meta'] = SeoMeta::find($id);
        $data['id'] = $id;
        return view('admin.seometa.update', $data);
    }
    // function for update Seo Meta
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' =>  'required|string',
            // 'meta_title' =>  'required',
            'meta_description' =>  'required',
            'meta_keywords' =>  'required'
        ]);

        $seo = SeoMeta::find($id);
        $seo->name = $request->input('name');
        $seo->meta_title = $request->input('meta_title');
        $seo->meta_description = $request->input('meta_description');
        $seo->meta_keywords = $request->input('meta_keywords');

        $seo->save();
        return redirect('admin/seo-meta')->with('message', 'Your data successfully updated');
    }

    // function for destroy Seo Meta
    public function destroy(string $id)
    {
        $data = SeoMeta::find($id);
        $data->delete();
        return redirect('admin/seo-meta')->with('message', 'Your data successfully deleted');
    }
    // Get seo meta bulk action
    public function bulkAction(Request $request)
    {
        $action = $request->input('action');
        $selectedItemsJSON = $request->input('selected_items', '[]');
        $selectedItems = json_decode($selectedItemsJSON);

        if ($action === 'delete') {
            if (!empty($selectedItems)) {
                SeoMeta::whereIn('id', $selectedItems)->delete();
                return redirect()->back()->with('message', 'Selected items deleted successfully');
            } else {
                return redirect()->back()->with('message', 'No items selected for deletion');
            }
        }
        return redirect()->back()->with('message', 'Invalid bulk action');
    }
}
