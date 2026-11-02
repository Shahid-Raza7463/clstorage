<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\PaymentMethodModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PaymentMethodsController extends Controller
{
    // listing Payment Method
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Get all Payment Method
            $data = PaymentMethodModel::all();
            // Get yajra dataTable
            return DataTables::of($data)
                ->addIndexColumn()
                // Get edit,delete btn
                ->addColumn('action', function ($row) {

                    $editUrl = 'paymentmethod/' . $row['id'] . '/edit';
                    $deleteUrl = 'paymentmethod/' . $row['id'];
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
        return view('Admin.paymentmethod.index_paymentMethods');
    }


    // function for create Payment Method
    public function create(Request $request)
    {
        return view('Admin.paymentmethod.create_paymentMethods');
    }
    // function for store Payment Method
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' =>  "required|unique:payment_lists,name|max:255",
        ]);

        $paymentMethod  = $request->all();
        PaymentMethodModel::create($paymentMethod);
        return redirect('admin/paymentmethod')->with('message', 'Your data successfully added');
    }

    // function for edit Payment Method
    public function edit(string $id)
    {
        $data = [];
        $data['paymentMethod'] = PaymentMethodModel::find($id);
        $data['id'] = $id;

        return view('Admin.paymentmethod.update_paymentMethods', $data);
    }

    // function for update Payment Method
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' =>  "required|unique:payment_lists,id," . $id . "|max:255",
        ]);

        $paymentMethod = PaymentMethodModel::find($id);
        // When data not found
        if (!$paymentMethod) {
            return ['success' => false, 'msg' => 'paymentMethod not Found !!!'];
        }
        // When data found
        $paymentMethod->name = $request->input('name');
        $paymentMethod->save();
        return redirect('admin/paymentmethod')->with('message', 'Your data successfully updated');
    }

    // function for destroy Payment Method
    public function destroy(string $id)
    {
        $paymentMethod = PaymentMethodModel::find($id);
        // When data not found
        if (!$paymentMethod) {
            return ['success' => false, 'msg' => 'paymentMethod not Found !!!'];
        }
        // When data found
        $paymentMethod->delete();
        return redirect('admin/paymentmethod')->with('message', 'Your data successfully deleted');
    }
    // Get payment method bulk action
    public function bulkAction(Request $request)
    {
        $action = $request->input('action');
        $selectedItemsJSON = $request->input('selected_items', '[]');
        $selectedItems = json_decode($selectedItemsJSON);

        if ($action === 'delete') {
            if (!empty($selectedItems)) {
                PaymentMethodModel::whereIn('id', $selectedItems)->delete();
                return redirect()->back()->with('message', 'Selected items deleted successfully');
            } else {
                return redirect()->back()->with('message', 'No items selected for deletion');
            }
        }
        return redirect()->back()->with('message', 'Invalid bulk action');
    }
}
