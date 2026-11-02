<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\NetworkWebController;
use App\Models\Admin\Projectimagefile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ProjectimagefileController extends Controller
{
    // listing Blog
    public function index(Request $request)
    {

        // "id" => 1
        // "projects_id" => 1
        // "image" => "img/portfolio/project-vsaedit.png"
        // "created_at" => null
        // "updated_at" => null
        if ($request->ajax()) {
            // Get all Blog
            $data = Projectimagefile::all();

            // dd($data);
            // Get yajra dataTable
            return DataTables::of($data)
                ->addIndexColumn()
                // Get edit,delete and views btn
                ->addColumn('action', function ($row) {

                    $deleteUrl = 'projectimagefile/' . $row['id'];
                    $editUrl = 'projectimagefile/' . $row['id'] . '/edit';
                    $viewUrl = 'projectimagefile/' . $row['id'];
                    // Get form to delete functionality
                    $form = '<div style="margin-left: 9px;"><form action="' . $deleteUrl . '" method="POST" class="form1">';
                    $form .= csrf_field();
                    $form .= method_field('DELETE');
                    $form .= '<button type="submit" class="delete btn btn-danger btn-sm" onclick="showConfirmation(event)">Delete</button>';
                    $form .= '</form></div>';

                    $btn = "<div><a href=" . $viewUrl . " class='edit btn btn-success btn-sm'></i>View</a></div><div><a href=" . $editUrl . " class='edit btn btn-primary btn-sm' style='margin-left: 9px;'></i>Edit</a></div>" . $form;

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('Admin.projectimagefile.index');
    }

    // function for create Blog
    public function create(NetworkWebController $nwc)
    {
        // Get all networks
        $networks =  $nwc->get_premium_networks();
        // Get name of verticals in ascending order
        $network_categories = $nwc->get_verticals();
        return view('Admin.projectimagefile.create', [
            'network_categories' => $network_categories,
            'networks' => $networks
        ]);
    }
    // function for store Blog
    public function store(Request $request)
    {


        // dd($user);
        // DB::table('projectimagefile')->insert([
        //     'projects_id' => $request->projects_id,
        //     'image' => $request->projects_id,
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);


        // $fileName =  $request->attachmentexist ?? null;
        // if ($request->hasFile('file')) {
        //   // public\backEnd\image\confirmationfile
        //   $destinationPath = public_path('backEnd/image/confirmationfile');
        //   // Delete the existing file if it exists
        //   if ($request->attachmentexist) {
        //     $existingFilePath = $destinationPath . '/' . $request->attachmentexist;
        //     if (file_exists($existingFilePath)) {
        //       unlink($existingFilePath);
        //     }
        //   }
        //   // Process the new file upload
        //   $file = $request->file('file');
        //   $fileName = $file->getClientOriginalName();
        //   $file->move($destinationPath, $fileName);
        // }


        $user = $request->user();
        // dd($user);
        $validated = $request->validate([
            'projects_id' =>  "required",
            'image' =>  "required",
        ]);

        $projectimagefile = new Projectimagefile();
        $projectimagefile->projects_id = $request['projects_id'];

        // Insert image path in table for image_url
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('img\portfolio');
            $projectimagefile->image = $path;
        }
        $projectimagefile->save();
        return redirect('admin/projectimagefile')->with('message', 'Your data successfully added');
    }
    // function for upload image
    public function upload(Request $request)
    {
        $path = $request->file('image')->store('img\portfolio');
        Projectimagefile::insert($path);
    }

    // function for views Blog
    public function show(string $id)
    {
        $data = Projectimagefile::find($id);
        return view('Admin.projectimagefile.show', ['data' => $data]);
    }

    // function for edit Blog
    public function edit(string $id)
    {
        $data = DB::table('projectimagefile')->where('id', $id)->first();
        return view('Admin.projectimagefile.update', compact('data'));
    }
    // function for update Blog
    public function update(Request $request, string $id)
    {

        $user = $request->user();
        $validated = $request->validate([
            'projects_id' =>  "required",
        ]);

        $projectimagefile = Projectimagefile::find($id);
        $projectimagefile->projects_id = $request->input('projects_id');

        // save path of image in table
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('img\portfolio');
            $projectimagefile->image = $path;
        }
        $projectimagefile->save();
        return redirect('admin/projectimagefile')->with('message', 'Your data successfully updated');
    }

    // function for destroy Blog
    public function destroy(string $id)
    {
        $projectimagefile = Projectimagefile::find($id);
        $projectimagefile->delete();
        return redirect('admin/projectimagefile')->with('message', 'Your data successfully deleted');
    }
    // Get blogs bulk action
    public function bulkAction(Request $request)
    {
        $action = $request->input('action');
        $selectedItemsJSON = $request->input('selected_items', '[]');
        $selectedItems = json_decode($selectedItemsJSON);

        if ($action === 'delete') {
            if (!empty($selectedItems)) {
                Projectimagefile::whereIn('id', $selectedItems)->delete();
                return redirect()->back()->with('message', 'Selected items deleted successfully');
            } else {
                return redirect()->back()->with('message', 'No items selected for deletion');
            }
        }
        return redirect()->back()->with('message', 'Invalid bulk action');
    }
}
