<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class temprary extends Controller
{

    public function index() {}


     public function getFileUrl($fileName, $localPath = 'backEnd/image/teammember')
    {
        if (empty($fileName)) {
            return '#';
        }

        // agar temp path aa raha hai to usko ignore karo
        if (
            str_contains($fileName, 'xampp/tmp') ||
            str_contains($fileName, 'xampp\\tmp') ||
            str_contains($fileName, '.tmp')
        ) {
            return '#';
        }

        $fileName = str_replace('\\', '/', trim($fileName));

        $localFile = public_path($localPath . '/' . basename($fileName));

        if (file_exists($localFile)) {
            return asset($localPath . '/' . basename($fileName));
        }

        try {
            if (Storage::disk('s3')->exists($fileName)) {
                return Storage::disk('s3')->temporaryUrl($fileName, now()->addMinutes(30));
            }

            $s3Path = 'candidateonboarding/' . basename($fileName);

            if (Storage::disk('s3')->exists($s3Path)) {
                return Storage::disk('s3')->temporaryUrl($s3Path, now()->addMinutes(30));
            }
        } catch (\Exception $e) {
            \Log::error('MinIO file error: ' . $e->getMessage());
        }

        return '#';
    }
    
    // public function getFileUrl($fileName, $localPath = 'backEnd/image/teammember')
    // {
    //     if (empty($fileName)) {
    //         return '#';
    //     }

    //     $localFile = public_path($localPath . '/' . $fileName);

    //     if (file_exists($localFile)) {
    //         return asset($localPath . '/' . $fileName);
    //     }

    //     return Storage::disk('s3')->url('candidateonboarding/' . $fileName);
    // }

    // public function getFileUrl($fileName, $localPath = 'backEnd/image/teammember')
    // {
    //     if (empty($fileName)) {
    //         return '#';
    //     }

    //     // Local file path
    //     $localFile = public_path($localPath . '/' . $fileName);

    //     // Pehle local check karo
    //     if (file_exists($localFile)) {
    //         return asset($localPath . '/' . $fileName);
    //     }

    //     // Local nahi mila to S3 URL return karo
    //     return Storage::disk('s3')->url('candidateonboarding/' . $fileName);
    // }

  public function getFileUrl($fileName, $localPath = 'backEnd/image/teammember')
    {
        if (empty($fileName)) {
            return '#';
        }

        if (Storage::disk('s3')->exists('candidateonboarding/' . $fileName)) {
            return Storage::disk('s3')->url('candidateonboarding/' . $fileName);
        }

        return asset($localPath . '/' . $fileName);
    }
	
	
	
	            if ($request->hasFile('passport')) {
                $file = $request->file('passport');
                $name = time() . $file->getClientOriginalName();

                if ($useS3) {
                    $file->storeAs('candidateonboarding', $name, 's3');
                } else {
                    $destinationPath = 'backEnd/image/teammember';
                    $file->move($destinationPath, $name);
                }
                $data['passport'] = $name;
            }
			
			
			
			            if ($request->hasFile('passport')) {
                $file = $request->file('passport');
                $name = time() . $file->getClientOriginalName();

                if ($useS3) {
                    // $file->storeAs('candidateonboarding', $name, 's3');
                    $file->storeAs('', $name, 's3');
                } else {
                    $destinationPath = 'backEnd/image/teammember';
                    $file->move($destinationPath, $name);
                }
                $data['passport'] = $name;
            }
			
			
			
			 public function getFileUrl($fileName, $localPath = 'backEnd/image/teammember')
    {

        if (empty($fileName)) {
            return '#';
        }

        // Pehle local check karo
        $localFile = public_path($localPath . '/' . $fileName);

        if (file_exists($localFile)) {
            return asset($localPath . '/' . $fileName);
        }

        // Local nahi mila to S3/MinIO URL
        return Storage::disk('s3')->url($fileName);
    }
       public function store(Request $request)
    {
        $request->validate([
            'team_member' => "required",
            'role_id' => "required",
            'emailid' => 'required|unique:teammembers',
        ]);

        try {
            $data = $request->except(['_token']);

            $allowedRoleIds = [14, 16, 17, 18];
            if (in_array($request->role_id, $allowedRoleIds)) {
                $employeestatus = 'Employee';
            } elseif ($request->role_id == 19) {
                $employeestatus = 'Intern';
            } elseif ($request->role_id == 15) {
                $employeestatus = 'CA Article';
            } elseif ($request->role_id == 21) {
                $employeestatus = 'Support Staff';
            }

            if ($request->hasFile('aadharupload')) {
                $file = $request->file('aadharupload');
                $destinationPath = 'backEnd/image/teammember';
                $name = time() . $file->getClientOriginalName();
                $s = $file->move($destinationPath, $name);
                //  dd($s); die;
                $data['aadharupload'] = $name;
            }
            if ($request->hasFile('panupload')) {
                $file = $request->file('panupload');
                $destinationPath = 'backEnd/image/teammember';
                $name = time() . $file->getClientOriginalName();
                $s = $file->move($destinationPath, $name);
                //  dd($s); die;
                $data['panupload'] = $name;
            }
            if ($request->hasFile('passport')) {
                $file = $request->file('passport');
                $destinationPath = 'backEnd/image/teammember';
                $name = time() . $file->getClientOriginalName();
                $s = $file->move($destinationPath, $name);
                //  dd($s); die;
                $data['passport'] = $name;
            }
            if ($request->hasFile('voterid')) {
                $file = $request->file('voterid');
                $destinationPath = 'backEnd/image/teammember';
                $name = time() . $file->getClientOriginalName();
                $s = $file->move($destinationPath, $name);
                //  dd($s); die;
                $data['voterid'] = $name;
            }
            if ($request->hasFile('drivinglicense')) {
                $file = $request->file('drivinglicense');
                $destinationPath = 'backEnd/image/teammember';
                $name = time() . $file->getClientOriginalName();
                $s = $file->move($destinationPath, $name);
                //  dd($s); die;
                $data['drivinglicense'] = $name;
            }
            if ($request->hasFile('profilepic')) {
                $avatar = $request->file('profilepic');
                $filename = time() . rand(1, 100) . '.' . $avatar->getClientOriginalExtension();
                Image::make($avatar)->resize(800, 600)->save('backEnd/image/teammember/profilepic/' . $filename);
                $data['profilepic'] = $filename;
            }
            if ($request->hasFile('appointment_letter')) {
                $avatar = $request->file('appointment_letter');
                $filename = time() . rand(1, 100) . '.' . $avatar->getClientOriginalExtension();
                Image::make($avatar)->resize(800, 600)->save('backEnd/image/teammember/appointmentletter/' . $filename);
                $data['appointment_letter'] = $filename;
            }
            if ($request->hasFile('addressupload')) {
                $avatar = $request->file('addressupload');
                $filename = time() . rand(1, 100) . '.' . $avatar->getClientOriginalExtension();
                Image::make($avatar)->resize(800, 600)->save('backEnd/image/teammember/addressupload/' . $filename);
                $data['addressupload'] = $filename;
            }
            $data['employment_status'] = $employeestatus ?? '';
            $data['status'] = 0;
            $data['created_by'] = auth()->user()->id;
            Teammember::Create($data);
            $teamMemberName = $request->input('team_member');
            $teammember_id = Teammember::where('team_member', $teamMemberName)->value('id');
            $currentDateTime = now()->format('Y-m-d H:i:s');
            $actionName = class_basename($request->route()->getActionname());
            $pagename = substr($actionName, 0, strpos($actionName, "Controller"));
            $id = auth()->user()->teammember_id;
            DB::table('activitylogs')->insert([
                'user_id' => $id,
                'teammember_id' => $teammember_id,
                'ip_address' => $request->ip(),
                'activitytitle' => $pagename,
                'month_year' => now()->format('Y-m'), // assuming you want to log it for the current month
                'generate_date_time' => $currentDateTime,
                'description' => 'New Team Member Added' . ' ' . '( ' . $request->team_member . ' )',
                'created_at' => date('y-m-d'),
                'updated_at' => date('y-m-d')
            ]);

            $output = array('msg' => 'Create Successfully');
            return back()->with('success', $output);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }



       public function update(Request $request, $id)
    {
        $request->validate([
            //     'mobile_no' => "required|numeric",
            //     'pancardno' => "required|numeric",
            'team_member' => "required"
        ]);
        try {
            $data = $request->except(['_token']);

            $allowedRoleIds = [14, 16, 17, 18];
            if (in_array($request->role_id, $allowedRoleIds)) {
                $employeestatus = 'Employee';
            } elseif ($request->role_id == 19) {
                $employeestatus = 'Intern';
            } elseif ($request->role_id == 15) {
                $employeestatus = 'CA Article';
            } elseif ($request->role_id == 21) {
                $employeestatus = 'Support Staff';
            }

            if ($request->hasFile('aadharupload')) {
                $file = $request->file('aadharupload');
                $destinationPath = 'backEnd/image/teammember';
                $name = time() . $file->getClientOriginalName();
                $s = $file->move($destinationPath, $name);
                //  dd($s); die;
                $data['aadharupload'] = $name;
            }
            if ($request->hasFile('panupload')) {
                $file = $request->file('panupload');
                $destinationPath = 'backEnd/image/teammember';
                $name = time() . $file->getClientOriginalName();
                $s = $file->move($destinationPath, $name);
                //  dd($s); die;
                $data['panupload'] = $name;
            }
            if ($request->hasFile('passport')) {
                $file = $request->file('passport');
                $destinationPath = 'backEnd/image/teammember';
                $name = time() . $file->getClientOriginalName();
                $s = $file->move($destinationPath, $name);
                //  dd($s); die;
                $data['passport'] = $name;
            }
            if ($request->hasFile('voterid')) {
                $file = $request->file('voterid');
                $destinationPath = 'backEnd/image/teammember';
                $name = time() . $file->getClientOriginalName();
                $s = $file->move($destinationPath, $name);
                //  dd($s); die;
                $data['voterid'] = $name;
            }
            if ($request->hasFile('drivinglicense')) {
                $file = $request->file('drivinglicense');
                $destinationPath = 'backEnd/image/teammember';
                $name = time() . $file->getClientOriginalName();
                $s = $file->move($destinationPath, $name);
                //  dd($s); die;
                $data['drivinglicense'] = $name;
            }
            if ($request->hasFile('profilepic')) {
                $avatar = $request->file('profilepic');
                $filename = time() . rand(1, 100) . '.' . $avatar->getClientOriginalExtension();
                Image::make($avatar)->resize(800, 600)->save('backEnd/image/teammember/profilepic/' . $filename);
                $data['profilepic'] = $filename;
            }
            if ($request->hasFile('appointment_letter')) {
                $file = $request->file('appointment_letter');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('backEnd/image/teammember/appointmentletter/', $filename);
                $data['appointment_letter'] = $filename;
            }
            if ($request->hasFile('nda')) {
                $file = $request->file('nda');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('backEnd/image/teammember/nda/', $filename);
                $data['nda'] = $filename;
            }
            if ($request->hasFile('panupload')) {
                $avatar = $request->file('panupload');
                $filename = time() . rand(1, 100) . '.' . $avatar->getClientOriginalExtension();
                Image::make($avatar)->resize(800, 600)->save('backEnd/image/teammember/panupload/' . $filename);
                $data['panupload'] = $filename;
            }
            if ($request->hasFile('addressupload')) {
                $avatar = $request->file('addressupload');
                $filename = time() . rand(1, 100) . '.' . $avatar->getClientOriginalExtension();
                Image::make($avatar)->resize(800, 600)->save('backEnd/image/teammember/addressupload/' . $filename);
                $data['addressupload'] = $filename;
            }

            $data['employment_status'] = $employeestatus ?? '';
            $data['updated_by'] = auth()->user()->teammember_id;
            $oldteammembers = Teammember::find($id);
            Teammember::find($id)->update($data);
            DB::table('users')->where('teammember_id', $id)->update([
                'role_id'         =>  $request->role_id,
                'email'         =>  $request->emailid,
            ]);
            $actionName = class_basename($request->route()->getActionname());
            $pagename = substr($actionName, 0, strpos($actionName, "Controller"));

            // Retrieve the teammembers data
            $fieldsToUpdate = [];
            $fields = ['team_member', 'mobile_no', 'emergencycontactnumber', 'monthly_gross_salary', 'entity', 'emailid', 'personalemail', 'gender', 'profilepic', 'department', 'dateofbirth', 'adharcardnumber', 'address_proof', 'pancardno', 'teamlead', 'qualification', 'designation', 'permanentaddress', 'communicationaddress', 'mothername', 'mothernumber', 'fathername', 'fathernumber', 'nameasperbank', 'nameofbank', 'bankaccountnumber', 'ifsccode', 'joining_date', 'leavingdate', 'dateofresign', 'status', 'location', 'mentor_id', 'timesheet_applicable', 'pf_applicable'];

            foreach ($fields as $field) {
                $fieldsToUpdate[$field] = $request->input($field);
            }

            $newteammembers = Teammember::find($id);
            // Compare old and new values
            $changes = [];
            foreach ($fields as $field) {
                $oldValue = $oldteammembers->$field;
                $newValue = $newteammembers->$field;

                // Normalize and trim values before comparison
                $normalizedOldValue = is_string($oldValue) ? trim($oldValue) : $oldValue;
                $normalizedNewValue = is_string($newValue) ? trim($newValue) : $newValue;

                if ($normalizedOldValue !== $normalizedNewValue) {
                    if ($normalizedOldValue === null) {
                        $changes[$field] = "($field is changed from null to $newValue)";
                    } else {
                        $changes[$field] = "($field is changed from $oldValue to $newValue)";
                    }
                }
            }
            // Retrieve the role name
            $rolename = DB::table('teammembers')
                ->leftJoin('roles', 'teammembers.role_id', '=', 'roles.id')
                ->select('roles.rolename')
                ->where('teammembers.id', $id)
                ->first();

            // Prepare additional information
            $currentDateTime = now()->format('Y-m-d H:i:s');
            $id = auth()->user()->teammember_id;
            $employeename = $newteammembers->team_member;
            $teammember_id = $newteammembers->id;
            // Add role name to changes
            if ($rolename->rolename == $oldteammembers->role->rolename) {
                $changes['rolename'] = "";
            } else {
                $changes['rolename'] = "(rolename is changed from {$oldteammembers->role->rolename} to {$rolename->rolename})";
                //dd($changes['rolename']);
            }
            $description = "(Employee Name: $employeename, " . implode(', ', $changes) . ")";

            // Limit the description to a reasonable length
            $description = substr($description, 0, 65535); // 65535 is the maximum length for a longtext column
            // Insert an entry into the activitylogs table
            DB::table('activitylogs')->insert([
                'user_id' => $id,
                'teammember_id' => $teammember_id,
                'ip_address' => $request->ip(),
                'activitytitle' => $pagename,
                'month_year' => now()->format('Y-m'), // assuming you want to log it for the current month
                'generate_date_time' => $currentDateTime,
                'description' => $description,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $output = array('msg' => 'Updated Successfully');
            return redirect('teammember')->with('success', $output);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'team_member' => "required",
            'role_id' => "required",
            'emailid' => 'required|unique:teammembers',
        ]);

        try {
            $data = $request->except(['_token']);

            $allowedRoleIds = [14, 16, 17, 18];
            if (in_array($request->role_id, $allowedRoleIds)) {
                $employeestatus = 'Employee';
            } elseif ($request->role_id == 19) {
                $employeestatus = 'Intern';
            } elseif ($request->role_id == 15) {
                $employeestatus = 'CA Article';
            } elseif ($request->role_id == 21) {
                $employeestatus = 'Support Staff';
            }

            if ($request->hasFile('aadharupload')) {
                $file = $request->file('aadharupload');
                $destinationPath = 'backEnd/image/teammember';
                $name = time() . $file->getClientOriginalName();
                $s = $file->move($destinationPath, $name);
                //  dd($s); die;
                $data['aadharupload'] = $name;
            }
            if ($request->hasFile('panupload')) {
                $file = $request->file('panupload');
                $destinationPath = 'backEnd/image/teammember';
                $name = time() . $file->getClientOriginalName();
                $s = $file->move($destinationPath, $name);
                //  dd($s); die;
                $data['panupload'] = $name;
            }
            if ($request->hasFile('passport')) {
                $file = $request->file('passport');
                $destinationPath = 'backEnd/image/teammember';
                $name = time() . $file->getClientOriginalName();
                $s = $file->move($destinationPath, $name);
                //  dd($s); die;
                $data['passport'] = $name;
            }
            if ($request->hasFile('voterid')) {
                $file = $request->file('voterid');
                $destinationPath = 'backEnd/image/teammember';
                $name = time() . $file->getClientOriginalName();
                $s = $file->move($destinationPath, $name);
                //  dd($s); die;
                $data['voterid'] = $name;
            }
            if ($request->hasFile('drivinglicense')) {
                $file = $request->file('drivinglicense');
                $destinationPath = 'backEnd/image/teammember';
                $name = time() . $file->getClientOriginalName();
                $s = $file->move($destinationPath, $name);
                //  dd($s); die;
                $data['drivinglicense'] = $name;
            }
            if ($request->hasFile('profilepic')) {
                $avatar = $request->file('profilepic');
                $filename = time() . rand(1, 100) . '.' . $avatar->getClientOriginalExtension();
                Image::make($avatar)->resize(800, 600)->save('backEnd/image/teammember/profilepic/' . $filename);
                $data['profilepic'] = $filename;
            }
            if ($request->hasFile('appointment_letter')) {
                $avatar = $request->file('appointment_letter');
                $filename = time() . rand(1, 100) . '.' . $avatar->getClientOriginalExtension();
                Image::make($avatar)->resize(800, 600)->save('backEnd/image/teammember/appointmentletter/' . $filename);
                $data['appointment_letter'] = $filename;
            }
            if ($request->hasFile('addressupload')) {
                $avatar = $request->file('addressupload');
                $filename = time() . rand(1, 100) . '.' . $avatar->getClientOriginalExtension();
                Image::make($avatar)->resize(800, 600)->save('backEnd/image/teammember/addressupload/' . $filename);
                $data['addressupload'] = $filename;
            }
            $data['employment_status'] = $employeestatus ?? '';
            $data['status'] = 0;
            $data['created_by'] = auth()->user()->id;
            Teammember::Create($data);
            $teamMemberName = $request->input('team_member');
            $teammember_id = Teammember::where('team_member', $teamMemberName)->value('id');
            $currentDateTime = now()->format('Y-m-d H:i:s');
            $actionName = class_basename($request->route()->getActionname());
            $pagename = substr($actionName, 0, strpos($actionName, "Controller"));
            $id = auth()->user()->teammember_id;
            DB::table('activitylogs')->insert([
                'user_id' => $id,
                'teammember_id' => $teammember_id,
                'ip_address' => $request->ip(),
                'activitytitle' => $pagename,
                'month_year' => now()->format('Y-m'), // assuming you want to log it for the current month
                'generate_date_time' => $currentDateTime,
                'description' => 'New Team Member Added' . ' ' . '( ' . $request->team_member . ' )',
                'created_at' => date('y-m-d'),
                'updated_at' => date('y-m-d')
            ]);

            $output = array('msg' => 'Create Successfully');
            return back()->with('success', $output);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }

        public function store(Request $request)
    {
        $request->validate([
            'team_member' => "required",
            'role_id' => "required",
            'emailid' => 'required|unique:teammembers',
        ]);

        try {
            $data = $request->except(['_token']);

            // Set this to false for local storage, true for S3
            $useS3 = false;

            $allowedRoleIds = [14, 16, 17, 18];
            if (in_array($request->role_id, $allowedRoleIds)) {
                $employeestatus = 'Employee';
            } elseif ($request->role_id == 19) {
                $employeestatus = 'Intern';
            } elseif ($request->role_id == 15) {
                $employeestatus = 'CA Article';
            } elseif ($request->role_id == 21) {
                $employeestatus = 'Support Staff';
            }

            if ($request->hasFile('aadharupload')) {
                $file = $request->file('aadharupload');
                $name = time() . $file->getClientOriginalName();

                if ($useS3) {
                    $file->storeAs('candidateonboarding', $name, 's3');
                } else {
                    $destinationPath = 'backEnd/image/teammember';
                    $file->move($destinationPath, $name);
                }
                $data['aadharupload'] = $name;
            }

            if ($request->hasFile('panupload')) {
                $file = $request->file('panupload');
                $name = time() . $file->getClientOriginalName();

                if ($useS3) {
                    $file->storeAs('candidateonboarding', $name, 's3');
                } else {
                    $destinationPath = 'backEnd/image/teammember';
                    $file->move($destinationPath, $name);
                }
                $data['panupload'] = $name;
            }

            if ($request->hasFile('passport')) {
                $file = $request->file('passport');
                $name = time() . $file->getClientOriginalName();

                if ($useS3) {
                    $file->storeAs('candidateonboarding', $name, 's3');
                } else {
                    $destinationPath = 'backEnd/image/teammember';
                    $file->move($destinationPath, $name);
                }
                $data['passport'] = $name;
            }

            if ($request->hasFile('voterid')) {
                $file = $request->file('voterid');
                $name = time() . $file->getClientOriginalName();

                if ($useS3) {
                    $file->storeAs('candidateonboarding', $name, 's3');
                } else {
                    $destinationPath = 'backEnd/image/teammember';
                    $file->move($destinationPath, $name);
                }
                $data['voterid'] = $name;
            }

            if ($request->hasFile('drivinglicense')) {
                $file = $request->file('drivinglicense');
                $name = time() . $file->getClientOriginalName();

                if ($useS3) {
                    $file->storeAs('candidateonboarding', $name, 's3');
                } else {
                    $destinationPath = 'backEnd/image/teammember';
                    $file->move($destinationPath, $name);
                }
                $data['drivinglicense'] = $name;
            }

            if ($request->hasFile('profilepic')) {
                $avatar = $request->file('profilepic');
                $filename = time() . rand(1, 100) . '.' . $avatar->getClientOriginalExtension();

                if ($useS3) {
                    $image = Image::make($avatar)->resize(800, 600)->encode($avatar->getClientOriginalExtension());
                    Storage::disk('s3')->put('candidateonboarding/profilepic/' . $filename, (string) $image);
                } else {
                    Image::make($avatar)->resize(800, 600)->save('backEnd/image/teammember/profilepic/' . $filename);
                }
                $data['profilepic'] = $filename;
            }

            if ($request->hasFile('appointment_letter')) {
                $avatar = $request->file('appointment_letter');
                $filename = time() . rand(1, 100) . '.' . $avatar->getClientOriginalExtension();

                if ($useS3) {
                    $image = Image::make($avatar)->resize(800, 600)->encode($avatar->getClientOriginalExtension());
                    Storage::disk('s3')->put('candidateonboarding/appointmentletter/' . $filename, (string) $image);
                } else {
                    Image::make($avatar)->resize(800, 600)->save('backEnd/image/teammember/appointmentletter/' . $filename);
                }
                $data['appointment_letter'] = $filename;
            }

            if ($request->hasFile('addressupload')) {
                $avatar = $request->file('addressupload');
                $filename = time() . rand(1, 100) . '.' . $avatar->getClientOriginalExtension();

                if ($useS3) {
                    $image = Image::make($avatar)->resize(800, 600)->encode($avatar->getClientOriginalExtension());
                    Storage::disk('s3')->put('candidateonboarding/addressupload/' . $filename, (string) $image);
                } else {
                    Image::make($avatar)->resize(800, 600)->save('backEnd/image/teammember/addressupload/' . $filename);
                }
                $data['addressupload'] = $filename;
            }

            $data['employment_status'] = $employeestatus ?? '';
            $data['status'] = 0;
            $data['created_by'] = auth()->user()->id;

            Teammember::Create($data);

            $teamMemberName = $request->input('team_member');
            $teammember_id = Teammember::where('team_member', $teamMemberName)->value('id');

            $currentDateTime = now()->format('Y-m-d H:i:s');
            $actionName = class_basename($request->route()->getActionname());
            $pagename = substr($actionName, 0, strpos($actionName, "Controller"));
            $id = auth()->user()->teammember_id;

            DB::table('activitylogs')->insert([
                'user_id' => $id,
                'teammember_id' => $teammember_id,
                'ip_address' => $request->ip(),
                'activitytitle' => $pagename,
                'month_year' => now()->format('Y-m'),
                'generate_date_time' => $currentDateTime,
                'description' => 'New Team Member Added' . ' ' . '( ' . $request->team_member . ' )',
                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d')
            ]);

            $output = array('msg' => 'Create Successfully');
            return back()->with('success', $output);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }
    public function store(Request $request)
    {
        $request->validate([
            'team_member' => "required",
            'role_id' => "required",
            'emailid' => 'required|unique:teammembers',
        ]);

        try {
            $data = $request->except(['_token']);

            $allowedRoleIds = [14, 16, 17, 18];

            if (in_array($request->role_id, $allowedRoleIds)) {
                $employeestatus = 'Employee';
            } elseif ($request->role_id == 19) {
                $employeestatus = 'Intern';
            } elseif ($request->role_id == 15) {
                $employeestatus = 'CA Article';
            } elseif ($request->role_id == 21) {
                $employeestatus = 'Support Staff';
            }

            // Aadhar Upload
            if ($request->hasFile('aadharupload')) {
                $file = $request->file('aadharupload');
                $name = time() . $file->getClientOriginalName();
                $file->storeAs('candidateonboarding', $name, 's3');
                $data['aadharupload'] = $name;
            }

            // PAN Upload
            if ($request->hasFile('panupload')) {
                $file = $request->file('panupload');
                $name = time() . $file->getClientOriginalName();
                $file->storeAs('candidateonboarding', $name, 's3');
                $data['panupload'] = $name;
            }

            // Passport Upload
            if ($request->hasFile('passport')) {
                $file = $request->file('passport');
                $name = time() . $file->getClientOriginalName();
                $file->storeAs('candidateonboarding', $name, 's3');
                $data['passport'] = $name;
            }

            // Voter ID Upload
            if ($request->hasFile('voterid')) {
                $file = $request->file('voterid');
                $name = time() . $file->getClientOriginalName();
                $file->storeAs('candidateonboarding', $name, 's3');
                $data['voterid'] = $name;
            }

            // Driving License Upload
            if ($request->hasFile('drivinglicense')) {
                $file = $request->file('drivinglicense');
                $name = time() . $file->getClientOriginalName();
                $file->storeAs('candidateonboarding', $name, 's3');
                $data['drivinglicense'] = $name;
            }

            // Profile Pic Upload (Resize + S3)
            if ($request->hasFile('profilepic')) {
                $avatar = $request->file('profilepic');

                $filename = time() . rand(1, 100) . '.' . $avatar->getClientOriginalExtension();

                $image = Image::make($avatar)
                    ->resize(800, 600)
                    ->encode($avatar->getClientOriginalExtension());

                Storage::disk('s3')->put(
                    'candidateonboarding/' .  $filename,
                    (string) $image
                );
                $data['profilepic'] = $filename;
            }

            // Appointment Letter Upload (Resize + S3)
            if ($request->hasFile('appointment_letter')) {
                $file = $request->file('appointment_letter');
                $filename = time() . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                $extension = strtolower($file->getClientOriginalExtension());
                if (in_array($extension, ['jpg', 'jpeg', 'png', 'webp'])) {
                    $image = Image::make($file)
                        ->resize(800, 600)
                        ->encode($extension);

                    Storage::disk('s3')->put(
                        'candidateonboarding/' . $filename,
                        (string) $image
                    );
                } else {
                    Storage::disk('s3')->putFileAs(
                        'candidateonboarding',
                        $file,
                        $filename
                    );
                }
                $data['appointment_letter'] = $filename;
            }

            // Address Upload (Resize + S3)
            if ($request->hasFile('addressupload')) {
                $file = $request->file('addressupload');
                $filename = time() . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                $extension = strtolower($file->getClientOriginalExtension());
                if (in_array($extension, ['jpg', 'jpeg', 'png', 'webp'])) {
                    $image = Image::make($file)
                        ->resize(800, 600)
                        ->encode($extension);

                    Storage::disk('s3')->put(
                        'candidateonboarding/' . $filename,
                        (string) $image
                    );
                } else {
                    Storage::disk('s3')->putFileAs(
                        'candidateonboarding',
                        $file,
                        $filename
                    );
                }
                $data['addressupload'] = $filename;
            }

            $data['employment_status'] = $employeestatus ?? '';
            $data['status'] = 0;
            $data['created_by'] = auth()->user()->id;

            Teammember::create($data);

            $teamMemberName = $request->input('team_member');
            $teammember_id = Teammember::where('team_member', $teamMemberName)->value('id');

            $currentDateTime = now()->format('Y-m-d H:i:s');
            $actionName = class_basename($request->route()->getActionname());
            $pagename = substr($actionName, 0, strpos($actionName, "Controller"));

            $id = auth()->user()->teammember_id;

            DB::table('activitylogs')->insert([
                'user_id' => $id,
                'teammember_id' => $teammember_id,
                'ip_address' => $request->ip(),
                'activitytitle' => $pagename,
                'month_year' => now()->format('Y-m'),
                'generate_date_time' => $currentDateTime,
                'description' => 'New Team Member Added (' . $request->team_member . ')',
                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d')
            ]);

            $output = ['msg' => 'Create Successfully'];

            return back()->with('success', $output);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }

    public function timesheetfiltersection(Request $request)
  {
    $employeeId = (int) $request->employeeid;
    $month = (int) $request->month;
    $fromDate = $request->fromdate;
    $toDate = $request->todate;
    $hasAnyFilter = !empty($request->employeeid)
      || !empty($request->client_id)
      || !empty($request->assignment_id)
      || !empty($request->month)
      || !empty($request->yearly)
      || !empty($request->hour)
      || !empty($request->fromdate)
      || !empty($request->todate)
      || !empty($request->search)
      || !empty($request->sortColumn)
      || !empty($request->page);

    $perPage = $request->perPage ?? 25;
    if (!$hasAnyFilter) {
      $records = new LengthAwarePaginator([], 0, $perPage, 1, [
        'path' => url('timesheetfiltersection'),
        'query' => $request->query(),
      ]);
      $datatable = view('backEnd.timesheet.datatable', compact('records'))->render();

      return response()->json([
        'status' => 200,
        'msg' => 'Data loaded',
        'data' => $datatable,
        'paginationInfo' => getPaginationInfo($records)
      ]);
    }

    $query = DB::table('timesheets')
      ->leftJoin('timesheetusers', 'timesheetusers.timesheetid', '=', 'timesheets.id')
      ->leftJoin('teammembers', 'teammembers.id', '=', 'timesheets.created_by')
      ->leftJoin('roles', 'roles.id', '=', 'teammembers.role_id')
      ->leftJoin('clients', 'clients.id', '=', 'timesheetusers.client_id')
      ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'timesheetusers.assignmentgenerate_id')
      ->leftJoin('assignments', 'assignments.id', '=', 'assignmentbudgetings.assignment_id')
      ->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', '=', 'timesheetusers.assignmentgenerate_id')
      ->leftJoin('teammembers as teampartner', 'teampartner.id', '=', 'assignmentmappings.leadpartner')
      ->when($employeeId, function ($query) use ($employeeId) {
        return $query->where('timesheets.created_by', $employeeId);
      })
      ->when($request->client_id != 0, function ($query) use ($request) {
        return $query->where('timesheetusers.client_id', $request->client_id);
      })
      ->when($request->assignment_id != 0, function ($query) use ($request) {
        return $query->where('timesheetusers.assignmentgenerate_id', $request->assignment_id);
      })
      ->when($month, function ($query) use ($month) {
        return $query->whereMonth('timesheets.date', '=', $month);
      })
      ->when($request->yearly != 0, function ($query) use ($request) {
        return $query->whereYear('timesheets.date', $request->yearly);
      })
      ->when($request->hour != null, function ($query) use ($request) {
        $startTime = $request->hour;
        return $query->whereRaw("TIME(timesheetusers.hour) <= ?", [$startTime]);
      })
      ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
        $nextDay = date('Y-m-d', strtotime($toDate . ' +1 day'));
        return $query->whereBetween('timesheets.date', [$fromDate, $nextDay]);
      })
      ->select(
        'roles.rolename',
        'timesheetusers.date',
        'timesheets.month',
        'teammembers.team_member',
        'clients.client_name',
        'timesheetusers.hour',
        'timesheetusers.assignmentgenerate_id',
        'teammembers.emailid',
        'assignmentbudgetings.assignmentname',
        'assignments.assignment_name',
        'teampartner.team_member as teampartner',
        'timesheetusers.workitem',
        'timesheetusers.billable_status',
        'timesheetusers.id'
      );

    if (!empty($request->search)) {
      $search = $request->search;
      $query->where(function ($q) use ($search) {
        $q->where('teammembers.team_member', 'like', "%{$search}%")
          ->orWhere('teammembers.emailid', 'like', "%{$search}%")
          ->orWhere('roles.rolename', 'like', "%{$search}%")
          ->orWhere('timesheetusers.date', 'like', "%{$search}%")
          ->orWhere('timesheets.month', 'like', "%{$search}%")
          ->orWhere('clients.client_name', 'like', "%{$search}%")
          ->orWhere('assignments.assignment_name', 'like', "%{$search}%")
          ->orWhere('assignmentbudgetings.assignmentname', 'like', "%{$search}%")
          ->orWhere('timesheetusers.assignmentgenerate_id', 'like', "%{$search}%")
          ->orWhere('timesheetusers.workitem', 'like', "%{$search}%")
          ->orWhere('teampartner.team_member', 'like', "%{$search}%")
          ->orWhere('timesheetusers.hour', 'like', "%{$search}%")
          ->orWhere('timesheetusers.billable_status', 'like', "%{$search}%");
      });
    }

    $allowedSorts = ['team_member', 'emailid', 'rolename', 'date', 'month', 'client_name', 'assignment_name', 'assignmentgenerate_id', 'workitem', 'teampartner', 'hour', 'billable_status'];
    if (!empty($request->sortColumn) && in_array($request->sortColumn, $allowedSorts, true)) {
      $query->orderBy($request->sortColumn, $request->sortDirection ?? 'desc');
    } else {
      $query->orderBy('timesheetusers.id', 'DESC');
    }

    $records = $query->paginate($perPage);
    $datatable = view('backEnd.timesheet.datatable', compact('records'))->render();

    return response()->json([
      'status' => 200,
      'msg' => 'Data loaded',
      'data' => $datatable,
      'paginationInfo' => getPaginationInfo($records)
    ]);
  }
  
    public function payrollarticleneftss(Request $request)
    {

                    ->whereBetween(
                    DB::raw('STR_TO_DATE(checkins.date, "%d-%m-%Y")'),
                    ['2025-01-01', '2025-12-31']
                )


                 ->whereBetween(DB::raw('STR_TO_DATE(checkins.date, "%d-%m-%Y")'), ['2025-01-01', '2025-12-31'])


        if (auth()->user()->role_id == 11 or auth()->user()->role_id == 17 or auth()->user()->role_id == 18) {
            $months = $this->articlePayrollMonths();
            $years = $this->articlePayrollYears();

            $neftData = DB::table('nefts')
                ->leftjoin('teammembers', 'teammembers.id', 'nefts.teammember_id')
                ->where('nefts.employeestatus', '!=', 'CA Article')
                ->where('nefts.month', $request->month)
                ->where('nefts.year', $request->year)
                ->select('nefts.*', 'teammembers.team_member', 'teammembers.verify')->get();



            $neftData = DB::table('nefts')
                ->leftJoin('teammembers', 'teammembers.id', 'nefts.teammember_id')
                ->where('nefts.month', $request->month)
                ->where('nefts.year', $request->year)
                ->where('nefts.type', 'Salary')
                ->select('nefts.*', 'teammembers.team_member', 'teammembers.verify')->get();

            $request->flash();
            return view('backEnd.neft.payrollneftindex', compact('neftData', 'months', 'years'));
        }
        abort(403, ' you have no permission to access this page ');
    }

    public function payrollarticle_upload(Request $request)
    {
        $request->validate([
            'file' => 'required'
        ]);

        try {
            $file = $request->file;

            $data = $request->except(['_token']);
            $dataa = Excel::toArray(new Payrollarticleimport, $file);

            foreach ($dataa[0] as $key => $value) {
                //	dd($value);
                $validator = Validator::make($value, [
                    'entity' => 'string',
                    'category' => 'string',
                    'doj' => 'date',
                    // 'year' => ['required', new Year],
                    'location' => 'string',
                    'stipend' => 'required|numeric',
                    'totalnoofdays' => 'required|integer',
                    'noofdayspresent' => 'required|integer',
                    'leave' => 'integer',
                    'co' => 'integer',
                    'birthdayleave' => 'integer',
                    'totaldaystobepaid' => 'required|integer',
                    'totalstipend' => 'required|numeric',
                    'arrear' => 'numeric',
                    'amounttobepaid' => 'required|numeric',

                ]);



                if ($validator->fails()) {
                    // Collect validation errors for each row
                    $errors[$key + 1] = $validator->errors()->all();
                    // dd($errors);
                } else {
                    // Process each row if it passes validation
                    $teamid = Teammember::where('emailid', $value['emailid'])->pluck('id')->first();
                    // Further processing here...
                }
                if (!empty($errors)) {
                    // If there are validation errors, redirect back with errors
                    return redirect()->back()->withErrors($errors)->withInput();
                }

                if ($teamid) {
                    DB::table('articlepayrolls')->where('emailid', $teamid)->where('month', $request->month)
                        ->where('currentyear', $request->yearvalue)
                        ->update([
                            'entity'         =>     $value['entity'],
                            'category'         =>     $value['category'],
                            'doj'         =>     $value['doj'],
                            // 'year'         =>     $value['year'],
                            'location'         =>     $value['location'],
                            'stipend'         =>     $value['stipend'],
                            'totalnoofdays'         =>     $value['totalnoofdays'],
                            'noofdayspresent'         =>     $value['noofdayspresent'],
                            'leave'         =>     $value['leave'],
                            'co'         =>     $value['co'],
                            'birthdayleave'         =>     $value['birthdayleave'],
                            'totaldaystobepaid'         =>     $value['totaldaystobepaid'],
                            'totalstipend'         =>     $value['totalstipend'],
                            'arrear'         =>     $value['arrear'],
                            'amounttobepaid'         =>     $value['amounttobepaid'],
                            'updated_at' => date('y-m-d H:i:s')
                        ]);
                }
            }
            $output = array('msg' => 'Excel file upload Successfully');
            return back()->with('success', $output);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }

    public function emailUpload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
            'month' => 'required|string',
            'year' => 'required|integer',
        ]);

        try {
            $file = $request->file('file');
            $data = Excel::toArray(new EmailImport, $file);

            // Bug 3 & 6: Check if Excel file is empty (no data rows at all)
            if (empty($data) || empty($data[0]) || count($data[0]) === 0) {
                return back()->withErrors(['The uploaded Excel file is empty. Please upload a file with valid email data.']);
            }

            // Bug 6: Check if all rows have blank email values
            $allBlank = true;
            foreach ($data[0] as $row) {
                $emailValue = isset($row['email']) ? trim($row['email'] ?? '') : '';
                if (!empty($emailValue)) {
                    $allBlank = false;
                    break;
                }
            }

            if ($allBlank) {
                return back()->withErrors(['The uploaded Excel file contains no email data. All rows are blank. Please fill in email addresses and try again.']);
            }

            $errors = [];
            $validRecords = [];
            $seenEmails = [];

            foreach ($data[0] as $key => $row) {
                $rowNumber = $key + 2; // Excel row number (header is row 1)
                $email = isset($row['email']) ? trim($row['email'] ?? '') : '';

                // Bug 1 & 5: Check for blank/missing email with clear message
                if (empty($email)) {
                    $errors[] = "Row " . $rowNumber . ": Email is missing. Please provide a valid email address.";
                    continue;
                }

                // Bug 5: Check for invalid email format with specific message
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errors[] = "Row " . $rowNumber . ": Invalid email format '" . $email . "'. Please provide a valid email address.";
                    continue;
                }

                // Bug 4: Check for duplicate emails within the uploaded Excel file
                $emailLower = strtolower($email);
                if (in_array($emailLower, $seenEmails)) {
                    $errors[] = "Row " . $rowNumber . ": Duplicate email '" . $email . "'. This email is already present in the uploaded file.";
                    continue;
                }
                $seenEmails[] = $emailLower;

                // Check if email exists in teammembers
                $teamMember = Teammember::where('emailid', $email)->first();
                if (!$teamMember) {
                    $errors[] = "Row " . $rowNumber . ": Email '" . $email . "' not found in team members.";
                    continue;
                }

                // Bug 7: Check for duplicate entry in database (same email + month + year)
                $existingEntry = DB::table('articlepayrolls')
                    ->where('emailid', $teamMember->id)
                    ->where('month', $request->month)
                    ->where('currentyear', $request->year)
                    ->exists();

                if ($existingEntry) {
                    $errors[] = "Row " . $rowNumber . ": Email '" . $email . "' already exists for " . $request->month . " " . $request->year . ". Duplicate entry not allowed.";
                    continue;
                }

                // Collect valid records for bulk insertion (no partial inserts)
                $validRecords[] = [
                    'emailid' => $teamMember->id,
                    'entity' => $teamMember->entity,
                    'neftstatus' => 0,
                    'month' => $request->month,
                    'currentyear' => $request->year,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // If there are any errors, return ALL errors without inserting anything
            if (!empty($errors)) {
                return back()->withErrors($errors);
            }

            // Insert all valid records only when there are zero errors
            foreach ($validRecords as $record) {
                // DB::table('articlepayrolls')->insert($record);
            }

            // Bug 2: Redirect to filtered view with correct month/year so data is visible
            return redirect('/payrollarticless?month=' . urlencode($request->month) . '&year=' . $request->year)
                ->with('success', 'Email IDs uploaded successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }
}
