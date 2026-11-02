<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\OfferFetch;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OfferController extends Controller
{
    // listing Offers
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Get all Offers
            $data = OfferFetch::all();
            // Get yajra dataTable
            return DataTables::of($data)
                ->addIndexColumn()
                // Get edit,delete btn
                ->addColumn('action', function ($row) {

                    $editUrl = 'offers/' . $row['id'] . '/edit';
                    $deleteUrl = 'offers/' . $row['id'];
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
        return view('Admin.Offers.index');
    }

    // Get latest offers
    public function get_latest_offers(AdminController $ac)
    {
        // Get latest_offers
        $data = $ac->get_latest_offers();
        return view('Admin.offers.latest_offers', [
            'data' => $data
        ]);
    }
    // Get Top offers on offers page
    public function get_top_offers(AdminController $ac)
    {
        // Get Top offers on offers page
        $data = $ac->get_top_offers();
        return view('Admin.offers.top_offers', [
            'data' => $data
        ]);
    }
    // Get featured offers
    public function get_featured_offers(AdminController $ac)
    {
        // Get featured_offers
        $data = $ac->get_featured_offers();
        return view('Admin.offers.featured_offers', [
            'data' => $data
        ]);
    }
    // function for edit Offers
    public function edit(string $id)
    {
        $data = [];
        // pass offers in blade file
        $data['offers'] = OfferFetch::find($id);

        $data['id'] = $id;
        return view('Admin.offers.update', $data);
    }
    // function for upload image
    public function upload(Request $request)
    {
        $path = $request->file('offer_image')->store('images');
        OfferFetch::insert($path);
    }

    // function for update Offers
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'icon' =>  "required",
            'title' =>  "required",
            'offer_id' =>  "required",
            'payout' =>  "required",
            'countries' =>  "required",
            'status' =>  "required",
            'is_featured' =>  "required",
            // 'offer_image' =>  "required"
        ]);

        $offers = OfferFetch::find($id);

        $offers->icon = $request->input('icon');
        $offers->title = $request->input('title');
        $offers->offer_id = $request->input('offer_id');
        $offers->payout = $request->input('payout');
        $offers->countries = $request->input('countries');
        $offers->status = $request->input('status');
        $offers->is_featured = $request->input('is_featured');
        // insert path of image
        if ($request->hasFile('offer_image')) {
            $path = $request->file('offer_image')->store('images');
            $offers->offer_image = $path;
        }
        $offers->save();
        return redirect('admin/offers')->with('message', 'Your data successfully updated');
    }

    // function for destroy Offers
    public function destroy(string $id)
    {
        $offers = OfferFetch::find($id);
        $offers->delete();
        return redirect('admin/offers')->with('message', 'Your data successfully deleted');
    }
    // Get offers bulk action
    public function bulkAction(Request $request)
    {
        $action = $request->input('action');
        $selectedItemsJSON = $request->input('selected_items', '[]');
        $selectedItems = json_decode($selectedItemsJSON);

        if ($action === 'delete') {
            if (!empty($selectedItems)) {
                OfferFetch::whereIn('id', $selectedItems)->delete();
                return redirect()->back()->with('message', 'Selected items deleted successfully');
            } else {
                return redirect()->back()->with('message', 'No items selected for deletion');
            }
        }
        return redirect()->back()->with('message', 'Invalid bulk action');
    }
}
