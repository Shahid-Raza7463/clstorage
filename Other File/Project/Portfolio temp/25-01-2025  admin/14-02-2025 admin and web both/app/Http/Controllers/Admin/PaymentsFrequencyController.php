<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\PaymentFrequencyModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PaymentsFrequencyController extends Controller
{
    // listing Payment Frequency
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Get all Payment Frequency
            $data = PaymentFrequencyModel::all();
            // Get yajra dataTable
            return DataTables::of($data)
                ->addIndexColumn()
                // Get edit,delete btn
                ->addColumn('action', function ($row) {

                    $editUrl = 'paymentfrequency/' . $row['id'] . '/edit';
                    $deleteUrl = 'paymentfrequency/' . $row['id'];
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
        return view('Admin.paymentfrequency.index_paymentFrequency');
    }
    // function for create Payment Frequency
    public function create(Request $request)
    {
        return view('Admin.paymentfrequency.create_paymentFrequency');
    }

    // function for store Payment Frequency
    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' =>  "required|unique:net_frequency_lists,name|max:255",
        ]);

        $paymentFrequency  = $request->all();
        PaymentFrequencyModel::create($paymentFrequency);
        return redirect('admin/paymentfrequency')->with('message', 'Your data successfully added');
    }

    // function for edit Payment Frequency
    public function edit(string $id)
    {
        $data = [];
        $data['paymentFrequency'] = PaymentFrequencyModel::find($id);
        $data['id'] = $id;

        return view('Admin.paymentfrequency.update_paymentFrequency', $data);
    }

    // function for update Payment Frequency
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' =>  "required|unique:net_frequency_lists,id," . $id . "|max:255",

        ]);

        $paymentFrequency = PaymentFrequencyModel::find($id);
        // when data not found
        if (!$paymentFrequency) {
            return ['success' => false, 'msg' => 'paymentFrequency not Found !!!'];
        }
        // when data found
        $paymentFrequency->name = $request->input('name');
        $paymentFrequency->save();
        return redirect('admin/paymentfrequency')->with('message', 'Your data successfully updated');
    }
    // function for destroy Payment Frequency
    public function destroy(string $id)
    {
        $paymentFrequency = PaymentFrequencyModel::find($id);
        // when data not found
        if (!$paymentFrequency) {
            return ['success' => false, 'msg' => 'paymentFrequency not Found !!!'];
        }
        // when data found
        $paymentFrequency->delete();
        return redirect('admin/paymentfrequency')->with('message', 'Your data successfully deleted');
    }
    // Get payment frequency bulk action
    public function bulkAction(Request $request)
    {
        $action = $request->input('action');
        $selectedItemsJSON = $request->input('selected_items', '[]');
        $selectedItems = json_decode($selectedItemsJSON);

        if ($action === 'delete') {
            if (!empty($selectedItems)) {
                PaymentFrequencyModel::whereIn('id', $selectedItems)->delete();
                return redirect()->back()->with('message', 'Selected items deleted successfully');
            } else {
                return redirect()->back()->with('message', 'No items selected for deletion');
            }
        }
        return redirect()->back()->with('message', 'Invalid bulk action');
    }
}
