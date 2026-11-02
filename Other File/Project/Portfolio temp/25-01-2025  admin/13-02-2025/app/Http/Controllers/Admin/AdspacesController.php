<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\NetworkWebController;
use App\Models\Admin\Adspace;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AdspacesController extends Controller
{
    // listing ads image
    public function index(Request $request, AdminController $ac)
    {
        if ($request->ajax()) {
            // Get all ads image
            $data = $ac->get_all_adspaces();
            // Get yajra dataTable
            return DataTables::of($data)
                ->addIndexColumn()
                // Get edit,delete btn
                ->addColumn('action', function ($row) {
                    $editUrl = 'adspaces/' . $row->id . '/edit';
                    $deleteUrl = 'adspaces/' .  $row->id;
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
        return view('Admin.adspaces.index');
    }

    // function for create ads image
    public function create(NetworkWebController $nwc)
    {
        // Get all networks
        $networks =  $nwc->get_premium_networks();
        return view('Admin.adspaces.create', [
            'networks' => $networks
        ]);
    }
    // function for store ads image
    public function store(Request $request)
    {
        $user = $request->user();
        $validated = $request->validate([
            'position' =>  "required",
            'image_url' =>  "required",
            'link' =>  "required",
            'expired_at' =>  "required"
            // 'image_url' =>  "required|image|mimes:jpeg,png,jpg,gif",
        ]);

        $adspaces = new Adspace();
        $adspaces->position = $request['position'];
        $adspaces->link = $request['link'];
        $adspaces->network_id = $request['network_id'];
        $adspaces->expired_at = $request['expired_at'];
        $adspaces->status = $request['status'];
        $adspaces->add_user = $user->id;

        // Insert image path in table for image_url
        if ($request->hasFile('image_url')) {
            $path = $request->file('image_url')->store('images');
            $adspaces->image_url = $path;
        }
        $adspaces->save();
        // get redirect route according ads image
        switch ($adspaces->position) {
            case 'top_left':
                return redirect('admin/network-ads')->with('message', 'Your data successfully added');
                break;
            case 'top_right':
                return redirect('admin/carousel-ads')->with('message', 'Your data successfully added');
                break;
            case 'top_middle_1':
                return redirect('admin/inpage-ads')->with('message', 'Your data successfully added');
                break;
            case 'right_side_1':
                return redirect('admin/sponsored-ads')->with('message', 'Your data successfully added');
                break;
            case 'right_side_2':
                return redirect('admin/sponsored-small')->with('message', 'Your data successfully added');
                break;
            case 'right_side_4':
                return redirect('admin/featured-ads')->with('message', 'Your data successfully added');
                break;
            default:
                return redirect('admin/adspaces')->with('message', 'Your data successfully added');
                break;
        }
    }
    // function for upload image
    public function upload(Request $request)
    {
        $path = $request->file('adspaces')->store('images');
        Adspace::insert($path);
    }
    // function for edit ads image
    public function edit(NetworkWebController $nwc, string $id)
    {
        $data = [];
        $data['adspaces'] = Adspace::find($id);
        $data['id'] = $id;
        // Get all networks
        $networks =  $nwc->get_premium_networks();
        return view('Admin.adspaces.update', $data)->with([
            'networks' => $networks
        ]);
    }
    // function for update ads image
    public function update(Request $request, string $id)
    {
        // Get login user details
        $user = $request->user();
        $validated = $request->validate([
            'position' =>  "required",
            'link' =>  "required",
            'expired_at' =>  "required"
            // 'image_url' =>  "required|image|mimes:jpeg,png,jpg,gif",
        ]);

        $adspaces = Adspace::find($id);

        $adspaces->position = $request->input('position');
        $adspaces->link = $request->input('link');
        $adspaces->network_id = $request->input('network_id');
        $adspaces->expired_at = $request->input('expired_at');
        $adspaces->status = $request->input('status');
        $adspaces->mod_user = $user->id;
        // insert path of image in table
        if ($request->hasFile('image_url')) {
            $path = $request->file('image_url')->store('images');
            $adspaces->image_url = $path;
        }
        $adspaces->save();
        // get redirect route according ads image
        switch ($adspaces->position) {
            case 'top_left':
                return redirect('admin/network-ads')->with('message', 'Your data successfully added');
                break;
            case 'top_right':
                return redirect('admin/carousel-ads')->with('message', 'Your data successfully added');
                break;
            case 'top_middle_1':
                return redirect('admin/inpage-ads')->with('message', 'Your data successfully added');
                break;
            case 'right_side_1':
                return redirect('admin/sponsored-ads')->with('message', 'Your data successfully added');
                break;
            case 'right_side_2':
                return redirect('admin/sponsored-small')->with('message', 'Your data successfully added');
                break;
            case 'right_side_4':
                return redirect('admin/featured-ads')->with('message', 'Your data successfully added');
                break;
            default:
                return redirect('admin/adspaces')->with('message', 'Your data successfully added');
                break;
        }
    }

    // function for destroy ads image
    public function destroy(string $id)
    {
        $adspaces = Adspace::find($id);
        // When data not found
        if (!$adspaces) {
            return ['success' => false, 'msg' => '$adspaces not Found !'];
        }
        // When data found
        $adspaces->delete();
        return redirect('admin/adspaces')->with('message', 'Your data successfully deleted');
    }

    // Get network of the months ads image
    public function get_networkofthemonths_ads(AdminController $ac)
    {
        // Get network of the months ads image
        $data = $ac->get_networkofthemonths_ads();
        return view('Admin.adspaces.network_of_the_months', [
            'data' => $data
        ]);
    }
    // Get home page carousel ads image
    public function home_page_carousel_ads(AdminController $ac)
    {
        // Get home page carousel ads image
        $data = $ac->home_page_carousel_ads();
        return view('Admin.adspaces.home_page_carousel', [
            'data' => $data
        ]);
    }
    // Get in page ads image
    public function in_page_ads(AdminController $ac)
    {
        $data = $ac->in_page_ads();
        return view('Admin.adspaces.in_page_ads', [
            'data' => $data
        ]);
    }
    // Get sponsored ads image
    public function sponsored_ads(AdminController $ac)
    {
        // Get sponsored ads image
        $data = $ac->sponsored_ads();
        return view('Admin.adspaces.sponsored_ads', [
            'data' => $data
        ]);
    }
    // Get sponsored small ads image
    public function sponsored_small(AdminController $ac)
    {
        // Get sponsored small ads image
        $data = $ac->sponsored_small();
        return view('Admin.adspaces.sponsored_small', [
            'data' => $data
        ]);
    }
    // Get featured ads image
    public function featured_ads(AdminController $ac)
    {
        // Get featured ads image
        $data = $ac->featured_ads();
        return view('Admin.adspaces.featured_net', [
            'data' => $data
        ]);
    }
    // Get ads image bulk action
    public function bulkAction(Request $request)
    {
        $action = $request->input('action');
        $selectedItemsJSON = $request->input('selected_items', '[]');
        $selectedItems = json_decode($selectedItemsJSON);

        if ($action === 'delete') {
            if (!empty($selectedItems)) {
                Adspace::whereIn('id', $selectedItems)->delete();
                return redirect()->back()->with('message', 'Selected items deleted successfully');
            } else {
                return redirect()->back()->with('message', 'No items selected for deletion');
            }
        }
        return redirect()->back()->with('message', 'Invalid bulk action');
    }
}
