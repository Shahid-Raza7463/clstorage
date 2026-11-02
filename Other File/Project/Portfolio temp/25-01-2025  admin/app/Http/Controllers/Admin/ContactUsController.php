<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Web\ContactUs;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ContactUsController extends Controller
{
    // listing Contact Us data
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Get all Contact Us data
            $data = ContactUs::all();
            // Get yajra dataTable
            return DataTables::of($data)
                ->addIndexColumn()
                // Get delete btn
                ->addColumn('action', function ($row) {

                    $deleteUrl = 'contact-us/' . $row['id'];
                    // Get form to delete functionality
                    $form = '<div style="margin-left: 9px;"><form action="' . $deleteUrl . '" method="POST" class="form1">';
                    $form .= csrf_field();
                    $form .= method_field('DELETE');
                    $form .= '<button type="submit" class="delete btn btn-danger btn-sm" onclick="showConfirmation(event)">Delete</button>';
                    $form .= '</form></div>';
                    $btn = $form;

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('Admin.contactus.index');
    }
    // function for destroy Contact Us data
    public function destroy(string $id)
    {
        $contact = ContactUs::find($id);
        $contact->delete();
        return redirect('admin/contact-us')->with('message', 'Your data successfully deleted');
    }
    // Get contact us bulk action
    public function bulkAction(Request $request)
    {
        $action = $request->input('action');
        $selectedItemsJSON = $request->input('selected_items', '[]');
        $selectedItems = json_decode($selectedItemsJSON);

        if ($action === 'delete') {
            if (!empty($selectedItems)) {
                ContactUs::whereIn('id', $selectedItems)->delete();
                return redirect()->back()->with('message', 'Selected items deleted successfully');
            } else {
                return redirect()->back()->with('message', 'No items selected for deletion');
            }
        }
        return redirect()->back()->with('message', 'Invalid bulk action');
    }
}
