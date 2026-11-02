<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\NetworkWebController;
use App\Models\Admin\NetworkSoftwareModel;
use App\Models\Admin\OfferApi;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OffersApiController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = OfferApi::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $editUrl = 'offers-api/' . $row['id'] . '/edit';
                    $deleteUrl = 'offers-api/' . $row['id'];
                    //Get delete functionality
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
        return view('Admin.offersApi.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(NetworkWebController $nwc)
    {
        // get name of network_software_list in ascending order
        $software =  $nwc->get_network_software_list();
        return view('Admin.offersApi.create', [
            'software' => $software
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'api_url' =>  "required",
            'tracking_software' =>  "required",
            'frequency' =>  "required",
            'status' =>  "required"
        ]);

        $offers_api = new OfferApi();
        $offers_api->api_url = $request['api_url'];
        $offers_api->tracking_software = $request['tracking_software'];
        $offers_api->frequency = $request['frequency'];
        $offers_api->status = $request['status'];
        $offers_api->save();

        return redirect('admin/offers-api')->with('message', 'Your data successfully added');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NetworkWebController $nwc, string $id)
    {
        // Get name of network_software_list in ascending order
        $software['software'] =  $nwc->get_network_software_list();
        $data = [];
        // pass offers in blade file
        $data['offersApi'] = OfferApi::find($id);
        $data['id'] = $id;
        return view('Admin.offersApi.update', $data, $software);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'api_url' =>  "required",
            'tracking_software' =>  "required",
            'frequency' =>  "required",
            'status' =>  "required"
        ]);

        $offersApi = OfferApi::find($id);
        $offersApi->api_url = $request->input('api_url');
        $offersApi->tracking_software = $request->input('tracking_software');
        $offersApi->frequency = $request->input('frequency');
        $offersApi->status = $request->input('status');

        $offersApi->save();
        return redirect('admin/offers-api')->with('message', 'Your data successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $offersApi = OfferApi::find($id);
        $offersApi->delete();
        return redirect('admin/offers-api')->with('message', 'Your data successfully deleted');
    }
    // Get offers api bulk action
    public function bulkAction(Request $request)
    {
        $action = $request->input('action');
        $selectedItemsJSON = $request->input('selected_items', '[]');
        $selectedItems = json_decode($selectedItemsJSON);

        if ($action === 'delete') {
            if (!empty($selectedItems)) {
                OfferApi::whereIn('id', $selectedItems)->delete();
                return redirect()->back()->with('message', 'Selected items deleted successfully');
            } else {
                return redirect()->back()->with('message', 'No items selected for deletion');
            }
        }
        return redirect()->back()->with('message', 'Invalid bulk action');
    }
}
