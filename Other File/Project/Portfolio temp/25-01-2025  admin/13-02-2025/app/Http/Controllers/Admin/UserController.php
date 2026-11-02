<?php

namespace App\Http\Controllers\Admin;

use App\Events\Admin\UserCreatedAdmin;
use App\Events\UserCreated;
use App\Events\VerifyEmailEvent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    // listing Users
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Get all Users
            $data = User::with('roles')->orderBy('id', 'DESC')->get();
            // Get yajra dataTable
            return DataTables::of($data)
                ->addIndexColumn()
                // Get edit,delete and views btn
                ->addColumn('action', function ($row) {
                    $deleteUrl = 'users/' . $row['id'];
                    $editUrl = 'users/' . $row['id'] . '/edit';
                    $viewUrl = 'users/' . $row['id'];
                    // Get form to delete functionality
                    $form = '<span style="margin-left: 10px;"><form action="' . $deleteUrl . '" method="POST" style="display: inline;" class="form1">';
                    $form .= csrf_field();
                    $form .= method_field('DELETE');
                    $form .= '<button type="submit" class="delete btn btn-danger btn-sm" onclick="showConfirmation(event)">Delete</button>';
                    $form .= '</form></span>';

                    $btn = "<span><a href=" . $viewUrl . " class='edit btn btn-success btn-sm'>View</a></span><span style='margin-left: 10px;'><a href=" . $editUrl . " class='edit btn btn-primary btn-sm' '>Edit</a></span>" . $form;

                    return $btn;
                })
                ->editColumn('roles', function ($user) {
                    return $user->roles->implode('name', ', ');
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('Admin.users.index');
    }
    // function for create Users
    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('Admin.users.create', compact('roles'));
    }
    // function for store Users
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $newUser = User::create($input);
        $newUser->assignRole($request->input('roles'));

        // send Usercreated email to user when create new user (using event)
        event(new UserCreated($newUser));

        // send verify email address to user when usercreated it is default 
        // event(new Registered($newUser));
        // Auth::login($newUser);

        // send verify email address to user when usercreated it is costume file
        event(new VerifyEmailEvent($newUser));
        Auth::login($newUser);

        // send Usercreated email to admin when create new user (using event)
        $admins = User::role('admin')->get();
        event(new UserCreatedAdmin($admins, $newUser));


        return redirect()->route('users.index')
            ->with('success', 'User created successfully done');
    }

    // function for show Users data
    public function show($id)
    {
        $user = User::find($id);
        return view('Admin.users.show', compact('user'));
    }

    // function for edit Users
    public function edit($id)
    {
        $user = User::find($id);
        // Get roles of users
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();

        return view('Admin.users.edit', compact('user', 'roles', 'userRole'));
    }
    // function for update Users
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        // password encrypt using hash
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();

        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }
    // function for destroy Users
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }
    // Get users bulk action
    public function bulkAction(Request $request)
    {
        $action = $request->input('action');
        $selectedItemsJSON = $request->input('selected_items', '[]');
        $selectedItems = json_decode($selectedItemsJSON);

        if ($action === 'delete') {
            if (!empty($selectedItems)) {
                User::whereIn('id', $selectedItems)->delete();
                return redirect()->back()->with('message', 'Selected items deleted successfully');
            } else {
                return redirect()->back()->with('message', 'No items selected for deletion');
            }
        }
        return redirect()->back()->with('message', 'Invalid bulk action');
    }
}
