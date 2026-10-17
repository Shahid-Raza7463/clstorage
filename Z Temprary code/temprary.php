<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel; // Import Excel facade
use App\Exports\TeammemberExport;

class TimesheetnotfillReminder extends Command
{

        //* regarding 
        
        //* regarding 
        //* regarding 
        //* regarding 
        //* regarding 
        //* regarding 
        //* regarding 
        //* regarding 
        //* regarding 
        //* regarding 
        //* regarding 
        //* regarding 
      //* regarding
        //* regarding 
        //* regarding 
        //* regarding 
        //* regarding 
        //* regarding 
        //* regarding 
        //* regarding 
        //* regarding 
        //* regarding 
        //* regarding 
        //* regarding 
        //* regarding 
        //* regarding 
        //* regarding 
        //* regarding 
        //* regarding 
        //* regarding 
        //* regarding 
        //* regarding 
        //* regarding 
        //* regarding 
        //* regarding 
        //* regarding 
        //* regarding 
        //* regarding 
        //* regarding 
        array:10 [▼
  "_method" => "PATCH"
  "client_name" => "Manojsan"
  "c_address" => "Delhi gate"
  "legalstatus" => "3"
  "panno" => "ABCDE1234F"
  "tanno" => "PDES03030H"
  "gstno" => "07AACCW8609C1ZD"
  "status" => "1"
  "classification" => "4"
  "otherclassification" => null
]
        //* regarding 
            public function assignmentlist(Request $request)
    {
        $staff = Teammember::whereIn('role_id', ['14', '15'])
            ->where('status', 1)
            ->with('role')
            ->get();

        $client = Client::where('status', 1)->get();
        $partners = Teammember::where('role_id', 14)->where('status', 1)->get();

        if ($request->ajax()) {
            $query = Assignmentmapping::with([
                'assignmentBudgeting.client:id,client_name',
                'assignmentBudgeting.assignment:id,assignment_name',
                'leadPartner:id,team_member',
                'otherPartner:id,team_member',
                'reviewerPartner:id,team_member',
                'assignmentTeamMappings.teamMember:id,team_member',
            ]);

            $query->withSum(['timsheetusers as total_hours' => function ($q) {
                $q->whereHas('createdBy', function ($sub) {
                    $sub->where('role_id', 14);
                });
            }], 'hour');

            // Apply filters
            if ($request->filled('clientId')) {
                $query->whereHas('assignmentBudgeting', function ($q) use ($request) {
                    $q->whereIn('client_id', $request->clientId);
                });
            }

            if ($request->filled('assignment')) {
                $query->whereHas('assignmentBudgeting', function ($q) use ($request) {
                    $q->whereIn('assignmentgenerate_id', $request->assignment);
                });
            }
            if ($request->filled('partnerId')) {
                $query->where('leadpartner', $request->partnerId);
            }
            if ($request->filled('teammemberId')) {
                $query->whereHas('assignmentTeamMappings', function ($q) use ($request) {
                    $q->whereIn('teammember_id', $request->teammemberId);
                });
            }

            // Apply date filters
            if ($request->filled('startdate')) {
                $query->whereDate('created_at', '>=', $request->startdate);
            }
            if ($request->filled('enddate')) {
                $query->whereDate('created_at', '<=', $request->enddate);
            }

            // Handle Export
            if ($request->has('export_type')) {
                $assignments = $query->get();

                if ($request->export_type === 'copy') {
                    return response()->json(['data' => $assignments]);
                }

                if ($request->export_type === 'excel') {
                    $visibleColumns = $request->get('visible_columns', []);

                    // Return the Excel download directly without JSON wrapper
                    return Excel::download(new AssignmentsExport($assignments, $visibleColumns), 'assignments.xlsx');
                }
            }

            return DataTables::of($query)
                ->addColumn('client_name', function ($row) {
                    return optional($row->assignmentBudgeting->client)->client_name ?? 'N/A';
                })
                ->addColumn('assignment_name', function ($row) {
                    return optional($row->assignmentBudgeting->assignment)->assignment_name ?? 'N/A';
                })
                ->addColumn('assignmentname', function ($row) {
                    return optional($row->assignmentBudgeting)->assignmentname ?? 'N/A';
                })
                ->addColumn('lead_partner', function ($row) {
                    return optional($row->leadPartner)->team_member ?? 'N/A';
                })
                ->addColumn('other_partner', function ($row) {
                    return optional($row->otherPartner)->team_member ?? 'N/A';
                })
                ->addColumn('reviewer_partner', function ($row) {
                    return optional($row->reviewerPartner)->team_member ?? 'N/A';
                })
                ->addColumn('assignment_team_mappings', function ($row) {
                    return $row->assignmentTeamMappings->map(function ($mapping) {
                        return [
                            'team_member' => optional($mapping->teamMember)->team_member,
                            'title' => optional($mapping->teamMember)->title,
                            'type' => $mapping->type,
                        ];
                    })->toArray();
                })
                ->addColumn('total_hours', function ($row) {
                    return $row->total_hours ?? '0';
                })
                ->addColumn('assignmentgenerate_id', function ($row) {
                    return $row->assignmentgenerate_id ?? 'N/A';
                })
                ->addColumn('location', function ($row) {
                    return $row->location ?? 'N/A';
                })
                ->addColumn('auditassignment', function ($row) {
                    return $row->auditassignment ?? 'N/A';
                })
                ->addColumn('natureofassignment', function ($row) {
                    return $row->natureofassignment ?? 'N/A';
                })
                ->addColumn('audittypecag', function ($row) {
                    return $row->audittypecag ?? 'N/A';
                })
                ->addColumn('eqcrapplicability', function ($row) {
                    return $row->eqcrapplicability ?? 'N/A';
                })
                ->addColumn('eqcresthour', function ($row) {
                    return $row->eqcresthour ?? 'N/A';
                })
                ->addColumn('eqcrestcost', function ($row) {
                    return $row->eqcrestcost ?? 'N/A';
                })
                ->addColumn('engagementfee', function ($row) {
                    return $row->engagementfee ?? 'N/A';
                })
                ->addColumn('revenuefy', function ($row) {
                    return $row->revenuefy ?? 'N/A';
                })
                ->addColumn('revenuefromoperations', function ($row) {
                    return $row->revenuefromoperations ?? 'N/A';
                })
                ->addColumn('otherrevenue', function ($row) {
                    return $row->otherrevenue ?? 'N/A';
                })
                ->addColumn('totalturnover', function ($row) {
                    return $row->totalturnover ?? 'N/A';
                })
                ->addColumn('networthfy', function ($row) {
                    return $row->networthfy ?? 'N/A';
                })
                ->addColumn('networth', function ($row) {
                    return $row->networth ?? 'N/A';
                })
                ->addColumn('borrowingsfy', function ($row) {
                    return $row->borrowingsfy ?? 'N/A';
                })
                ->addColumn('borrowingsamt', function ($row) {
                    return $row->borrowingsamt ?? 'N/A';
                })
                ->addColumn('borrowingsotherfy', function ($row) {
                    return $row->borrowingsotherfy ?? 'N/A';
                })
                ->addColumn('borrowingsother', function ($row) {
                    return $row->borrowingsother ?? 'N/A';
                })
                ->addColumn('paidupfy', function ($row) {
                    return $row->paidupfy ?? 'N/A';
                })
                ->addColumn('paidupcapitall', function ($row) {
                    return $row->paidupcapitall ?? 'N/A';
                })
                ->addColumn('cmpnystatusname', function ($row) {
                    return $row->cmpnystatusname ?? 'N/A';
                })
                ->addColumn('cmpnystatuschange', function ($row) {
                    return $row->cmpnystatuschange ?? 'N/A';
                })
                ->addColumn('sectorcompany', function ($row) {
                    return $row->sectorcompany ?? 'N/A';
                })
                ->addColumn('roleassignment', function ($row) {
                    return $row->roleassignment ?? 'N/A';
                })
                ->addColumn('esthours', function ($row) {
                    return $row->esthours ?? 'N/A';
                })
                ->addColumn('teamestcost', function ($row) {
                    return $row->teamestcost ?? 'N/A';
                })
                ->addColumn('pocketexpenses', function ($row) {
                    return $row->pocketexpenses ?? 'N/A';
                })
                ->addColumn('profit', function ($row) {
                    return $row->profit ?? 'N/A';
                })
                ->addColumn('partneresthour', function ($row) {
                    return $row->partneresthour ?? 'N/A';
                })
                ->addColumn('partnerestcost', function ($row) {
                    return $row->partnerestcost ?? 'N/A';
                })
                ->addColumn('otherpartneresthour', function ($row) {
                    return $row->otherpartneresthour ?? 'N/A';
                })
                ->addColumn('otherpartnerestcost', function ($row) {
                    return $row->otherpartnerestcost ?? 'N/A';
                })
                ->addColumn('totalstaffcount', function ($row) {
                    return $row->totalstaffcount ?? 'N/A';
                })
                ->addColumn('reasonforstaffcount', function ($row) {
                    return $row->reasonforstaffcount ?? 'N/A';
                })
                ->addColumn('teamesthour', function ($row) {
                    return $row->teamesthour ?? 'N/A';
                })
                ->addColumn('teamestcost', function ($row) {
                    return $row->teamestcost ?? 'N/A';
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at ?? 'N/A';
                })

                // Search handling for columns
                ->filterColumn('client_name', function ($query, $keyword) {
                    $keyword = strtolower(trim($keyword));
                    $query->whereHas('assignmentBudgeting.client', function ($q) use ($keyword) {
                        $q->whereRaw('LOWER(client_name) LIKE ?', ["%{$keyword}%"]);
                    });
                })
                ->filterColumn('assignment_name', function ($query, $keyword) {
                    $keyword = strtolower(trim($keyword));
                    $query->whereHas('assignmentBudgeting.assignment', function ($q) use ($keyword) {
                        $q->whereRaw('LOWER(assignment_name) LIKE ?', ["%{$keyword}%"]);
                    });
                })
                ->filterColumn('assignmentname', function ($query, $keyword) {
                    $keyword = strtolower(trim($keyword));
                    $query->whereHas('assignmentBudgeting', function ($q) use ($keyword) {
                        $q->whereRaw('LOWER(assignmentname) LIKE ?', ["%{$keyword}%"]);
                    });
                })
                ->filterColumn('lead_partner', function ($query, $keyword) {
                    $keyword = strtolower(trim($keyword));
                    $query->whereHas('leadPartner', function ($q) use ($keyword) {
                        $q->whereRaw('LOWER(team_member) LIKE ?', ["%{$keyword}%"]);
                    });
                })
                ->filterColumn('other_partner', function ($query, $keyword) {
                    $keyword = strtolower(trim($keyword));
                    $query->whereHas('otherPartner', function ($q) use ($keyword) {
                        $q->whereRaw('LOWER(team_member) LIKE ?', ["%{$keyword}%"]);
                    });
                })
                ->filterColumn('reviewer_partner', function ($query, $keyword) {
                    $keyword = strtolower(trim($keyword));
                    $query->whereHas('reviewerPartner', function ($q) use ($keyword) {
                        $q->whereRaw('LOWER(team_member) LIKE ?', ["%{$keyword}%"]);
                    });
                })
                ->filterColumn('assignment_team_mappings', function ($query, $keyword) {
                    $keyword = strtolower(trim($keyword));
                    $query->whereHas('assignmentTeamMappings.teamMember', function ($q) use ($keyword) {
                        $q->whereRaw('LOWER(team_member) LIKE ?', ["%{$keyword}%"]);
                    });
                })

                ->make(true);
        }

        return view('backEnd.assignment.assignmentlist', compact('client', 'staff', 'partners'));
    }
        //* regarding 
            public function permotionandrejoinstore(Request $request)
    {
        // vishal agerwal promotion date 8-07-2024
        $checkrole = DB::table('teammembers')
            ->where('id', $request->employeeid)
            ->select('id', 'role_id', 'staffcode', 'staffcodenumber', 'joining_date')
            ->first();

        $promotioncheck = DB::table('teamrolehistory')
            ->where('teammember_id', $request->employeeid)
            ->orderByDesc('id')
            ->first();


        $oldData = [
            'teammember_id' => $checkrole->id,
            'role_id' => $checkrole->role_id,
            'staffcode' => $checkrole->staffcode,
            'staffcodenumber' => $checkrole->staffcodenumber,
        ];

        $role = '';
        if ($request->designationtype == 11) {
            $role = "super admin";
        } elseif ($request->designationtype == 12) {
            $role = "admin";
        } elseif ($request->designationtype == 13) {
            $role = "partner";
        } elseif ($request->designationtype == 14) {
            $role = "manager";
        } elseif ($request->designationtype == 15) {
            $role = "staff";
        }

        if ($checkrole->role_id == $request->designationtype) {
            $output = array('msg' => "You are already on the '" . $role . "' post.");
            return back()->with('statuss', $output);
        }

        if ($checkrole->role_id == 15 && $request->designationtype == 13) {
            $output = array('msg' => "You can not promote this user to '" . $role . "' post.");
            return back()->with('statuss', $output);
        }

        if ($request->designationtype == 11 || $request->designationtype == 12) {
            $output = array('msg' => "You can not promote on the '" . $role . "' post.");
            return back()->with('statuss', $output);
        }

        if ($checkrole->role_id < $request->designationtype) {
            $output = array('msg' => 'You can not promote on this post "' . $role . '".');
            return back()->with('statuss', $output);
        }

        $maxStaffcodeTeammembers = DB::table('teammembers')
            ->where('role_id', $request->designationtype)
            ->max('staffcodenumber');

        $maxStaffcodeTeamRoleHistory = DB::table('teamrolehistory')
            ->where('roleid_new', $request->designationtype)
            ->max('new_staffcodenumber');

        $getlateststaffcode = max($maxStaffcodeTeammembers, $maxStaffcodeTeamRoleHistory);


        if ($request->designationtype == 13) {
            if ($getlateststaffcode == null) {
                $newstaffcode = '10001';
            } else {
                $newstaffcode = $getlateststaffcode + 1;
            }
            $newstaffcoderesult = 'P' . $newstaffcode;
            $staffcode = $newstaffcode;
        }
        if ($request->designationtype == 14) {
            if ($getlateststaffcode == null) {
                $newstaffcode = '20001';
            } else {
                $newstaffcode = $getlateststaffcode + 1;
            }
            $newstaffcoderesult = 'M' . $newstaffcode;
            $staffcode = $newstaffcode;
        }
        // dd($checkrole->role_id);
        DB::table('teammembers')
            ->where('id', $request->employeeid)
            ->update([
                'role_id' => $request->designationtype,
                'staffcodenumber' => $staffcode,
            ]);

        DB::table('users')
            ->where('teammember_id', $request->employeeid)
            ->update([
                'role_id' => $request->designationtype,
            ]);

        if ($promotioncheck) {
            $oldstaffcode = $promotioncheck->newstaff_code;
        } else {
            $oldstaffcode = $checkrole->staffcode;
        }

        DB::table('teamrolehistory')->insert([
            'teammember_id' => $request->employeeid,
            'roleid_old' => $checkrole->role_id,
            'roleid_new' => $request->designationtype,
            'oldstaff_code' =>  $oldstaffcode,
            'newstaff_code' => $newstaffcoderesult,
            'old_staffcodenumber' => $checkrole->staffcodenumber,
            'new_staffcodenumber' => $staffcode,
            //hare goes to pormotion date from form
            'promotion_date' => date('Y-m-d', strtotime($request->promotion_date)),
            //hare goes to created date 
            'promotioncreated' => now(),
            'change_type' => 'promotion',
            //hare goes to pormotion date from form becouse all condition apply on create column it is common column for pormotion and rejoining
            'created_at' => Carbon::createFromFormat('Y-m-d', $request->promotion_date)->toDateTimeString(),
            'updated_at' => now(),
        ]);
        $this->updateOrInsertAttendance($request->employeeid, $request->promotion_date, $checkrole->joining_date);

        $newData = [
            'teammember_id' => $request->employeeid,
            'role_id' => $request->designationtype,
            'staffcode' => $newstaffcoderesult,
            'staffcodenumber' => $staffcode,
        ];


        HelperFunctions::activityLogsDetails(
            'teammember_promotion',
            'updated',
            $request->employeeid,
            $oldData,
            $newData
        );

        $output = array('msg' => 'Pormotion Successfully Done');
        return back()->with('success', $output);
    }

        //* regarding 
        //* regarding 
        //* regarding 
        //* regarding 
        //* regarding 
        
        //* regarding 

          public function update(Request $request, $id)
    {
        try {

            $oldData = Assignmentmapping::find($id);
            $oldDataArray = $oldData ? $oldData->toArray() : [];

            $data = $request->except(['_token']);
            Assignmentmapping::find($id)->update($data);

            $updatedData = Assignmentmapping::find($id);
            $newDataArray = $updatedData ? $updatedData->toArray() : [];

            HelperFunctions::activityLogsDetails(
                'assignment',
                'updated',
                $id,
                $oldDataArray,
                $newDataArray
            );

            $output = array('msg' => 'Updated Successfully');
            return redirect('assignmentmapping')->with('success', $output);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }

                    // logs details
            $newData = $teammember->toArray();
            HelperFunctions::activityLogsDetails('teammember', 'created', $teammemberid, null, $newData);
            // logs details end hare 


               // logs details

                  // assignmentbudgetings
            $assignmentBudgeting = DB::table('assignmentbudgetings')
                ->where('assignmentgenerate_id', $assignmentgenerate)
                ->first();

            // assignmentmappings
            $assignmentMapping = DB::table('assignmentmappings')
                ->where('id', $id)
                ->first();

            $newData = [
                'assignment_budgeting' => (array) $assignmentBudgeting,
                'assignment_mapping'   => (array) $assignmentMapping,
                'teammembers'          => $request->teammember_id ?? [],
            ];
            HelperFunctions::activityLogsDetails(
                'assignment',
                'created',
                $id,
                null,
                $newData
            );
            // logs details end hare 


               // logs details

                  // assignmentbudgetings
            $assignmentBudgeting = DB::table('assignmentbudgetings')
                ->where('assignmentgenerate_id', $assignmentgenerate)
                ->first();

            // assignmentmappings
            $assignmentMapping = DB::table('assignmentmappings')
                ->where('id', $id)
                ->first();

            $newData = [
                'assignment_budgeting' => (array) $assignmentBudgeting,
                'assignment_mapping'   => (array) $assignmentMapping,
                'teammembers'          => $request->teammember_id ?? [],
            ];
            HelperFunctions::activityLogsDetails(
                'assignment',
                'created',
                $id,
                null,
                $newData
            );
            // logs details end hare 


      $oldData = DB::table('applyleaves')
        ->where('id', $id)
        ->select('id', 'leavetype', 'createdby', 'reasonleave', 'status', 'updatedby', 'updated_at')
        ->first();

      $oldDataArray = $oldData ? (array) $oldData : [];




      
      $newData = DB::table('applyleaves')
        ->where('id', $id)
        ->select('id', 'leavetype', 'createdby', 'reasonleave', 'status', 'updatedby', 'updated_at')
        ->first();

      $newDataArray = $newData ? (array) $newData : [];


      HelperFunctions::activityLogsDetails(
        'leave', // better module name
        $request->status == 1 ? 'Approved' : ($request->status == 2 ? 'Rejected' : 'Updated'),
        $id,
        $oldDataArray,
        $newDataArray
      );

    }
        //* regarding 

         public function  timesheetreject($id)
  {

    try {
      $timesheetdata = DB::table('timesheetusers')->where('id', $id)->first();

      $finalJoiningDate = HelperFunctions::getFinalJoiningDate($timesheetdata->createdby);
      if ($timesheetdata->date < $finalJoiningDate) {
        $output = array('msg' => 'You cannot reject a timesheet dated before the rejoining date');
        return back()->with('statuss', $output);
      }

      DB::table('timesheets')->where('id', $timesheetdata->timesheetid)->update([
        'status'   => 2,
      ]);
      DB::table('timesheetusers')->where('id', $id)->update([
        'status'   => 2,
        'rejectedby'   =>   auth()->user()->teammember_id,

      ]);
      // timesheet rejected mail
      $data = DB::table('teammembers')
        ->leftjoin('timesheetusers', 'timesheetusers.createdby', 'teammembers.id')
        ->where('timesheetusers.id', $id)
        ->first();

      $emailData = [
        'emailid' => $data->emailid,
        'teammember_name' => $data->team_member,
      ];

      Mail::send('emails.timesheetrejected', $emailData, function ($msg) use ($emailData) {
        $msg->to([$emailData['emailid']]);
        $msg->subject('Timesheet rejected');
      });
      // timesheet rejected mail end hare

      // Attendance code start hare 
      $hdatess = Carbon::parse($timesheetdata->date)->format('Y-m-d');
      $day = Carbon::parse($hdatess)->format('d');
      $month = Carbon::parse($hdatess)->format('F');
      $yeardata = Carbon::parse($hdatess)->format('Y');

      $dates = [
        '01' => 'one',
        '02' => 'two',
        '03' => 'three',
        '04' => 'four',
        '05' => 'five',
        '06' => 'six',
        '07' => 'seven',
        '08' => 'eight',
        '09' => 'nine',
        '10' => 'ten',
        '11' => 'eleven',
        '12' => 'twelve',
        '13' => 'thirteen',
        '14' => 'fourteen',
        '15' => 'fifteen',
        '16' => 'sixteen',
        '17' => 'seventeen',
        '18' => 'eighteen',
        '19' => 'ninghteen',
        '20' => 'twenty',
        '21' => 'twentyone',
        '22' => 'twentytwo',
        '23' => 'twentythree',
        '24' => 'twentyfour',
        '25' => 'twentyfive',
        '26' => 'twentysix',
        '27' => 'twentyseven',
        '28' => 'twentyeight',
        '29' => 'twentynine',
        '30' => 'thirty',
        '31' => 'thirtyone',
      ];
      $column = $dates[$day];

      // check attendenace record exist or not 
      $attendances = DB::table('attendances')
        ->where('employee_name', $timesheetdata->createdby)
        ->where('month', $month)
        ->first();

      if ($attendances != null) {
        if (property_exists($attendances, $column)) {
          $checkwording = DB::table('attendances')
            ->where('id', $attendances->id)
            ->value($column);

          $updatewording = 'R';

          // Get which column want to update 
          $totalCountmapping = [
            'P' => 'no_of_days_present',
            'CL' => 'casual_leave',
            'EL' => 'exam_leave',
            'T' => 'travel',
            'OH' => 'offholidays',
            'W' => 'sundaycount',
            'H' => 'holidays'
          ];

          if (isset($totalCountmapping[$checkwording])) {
            // Get Total count column name 
            $totalcountColumn = $totalCountmapping[$checkwording];
            // Get value and - 1 valve
            $totalcountupdate = $attendances->$totalcountColumn - 1;
            // Update the attendance record
            DB::table('attendances')
              ->where('id', $attendances->id)
              ->update([
                $column => $updatewording,
                $totalcountColumn => $totalcountupdate,
              ]);
          }
        }
      }
      // Attendance code end hare 
      $output = array('msg' => 'Rejected Successfully');
      return back()->with('success', $output);
    } catch (Exception $e) {
      DB::rollBack();
      Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
      report($e);
      $output = array('msg' => $e->getMessage());
      return back()->withErrors($output)->withInput();
    }
  }
         #attributes: array:29 [▼
        "id" => 5
        "uuid" => "56b7adab-b048-4a00-b556-cc151e297f81"
        "observation_id" => "001"
        "engagement_id" => 16
        "mega_process_id" => null
        "process_id" => null
        "observation_owner_id" => 1
        "observable_type" => null
        "observable_id" => null
        "name" => "shahid obser"
        "description" => "<p>sklqj;l aklsas;l</p>"
        "financial_impact" => "10"
        "root_cause" => "<p>wlsdl wljslqw</p>"
        "recommendation" => "<p>mqlks  qksnql qwms</p>"
        "management_comment" => "<p>qwklkwl lmws</p>"
        "management_comment_log" => null
        "risk_implication" => "<p>mw;wl lw</p>"
        "risk_grading" => "Critical"
        "due_date" => "2026-03-26"
        "previous_status" => "query"
        "status" => "dropped"
        "is_active" => 1
        "is_approved" => 1
        "data" => null
        "organization_id" => 2
        "created_by_id" => 1
        "updated_by_id" => 1
        "created_at" => "2026-03-26 15:36:51"
        "updated_at" => "2026-03-26 15:43:34"
      ]
        //* regarding 
        //* regarding filter
              $engagement = Engagement::uuid($uuid)->with([
            'creator:id,name,uuid,avatar',
            'auditplan:id,name,uuid',
            'auditfirm:id,name,uuid',
            'attachments',
            'members',
            'members.user'
        ])->first();

          public function auditengagement($request)
    {

        $actionableList = $this->actionableStatus($request);

        $filters = $this->getFilters();
        $counts = $this->getCounts($request);
        $charts = $this->getCharts($request);
        $observationbyStatuslist = $this->observationbyStatus($request);
        $overdueObservations = $this->observationbyStatus($request);
        $drlstatusdata = $this->drlstatusdata($request);
        $auditProcedureStatus = $this->auditProcedureStatus($request);
        $drlOverduedata = $this->drlstatusdata($request);

        return view('auditengagement', compact(
            'counts',
            'charts',
            'actionableList',
            'observationbyStatuslist',
            'auditProcedureStatus',
            'overdueObservations',
            'drlstatusdata',
            'drlOverduedata',
            'filters',
        ));
    }


        private function actionableStatus($request = null)
    {
        $query = Engagement::query();
        if ($request) {
            $query = $this->actionableListfilter($request, $query);
        }

        $actionablesStatus = $query->get();

        return $actionablesStatus;
    }

     protected function actionableListfilter($request, $query)
    {
        if (!empty($request->teammembername)) {
            $query->whereIn('status', $request->teammembername);
        }
        if (!empty($request->createdby)) {
            $query->whereIn('quarter', $request->createdby);
        }
        if (!empty($request->modulename)) {
            $query->whereIn('company_id', $request->modulename);
        }
        if (!empty($request->actionname)) {
            $query->whereIn('department', $request->actionname);
        }
        if (!empty($request->risk_rating)) {
            $query->whereIn('risk_rating', $request->risk_rating);
        }
        if (!empty($request->observation_status)) {
            $query->whereIn('current_transition_id', $request->observation_status);
        }

        return $query;
    }
        //* regarding 
        //* regarding 
        //* regarding
          public function index($request)
    {

        $auditPlanId = $request->auditPlanId ?? null;
        $auditPlan = AuditPlan::uuid($auditPlanId)->first();
        $user = authUser();
        if ($this->canAccessPage('engagement') || $user->can('engagement.list')) {
            try {

                $perPage = $request->perPage ?? 15;
                $records = Engagement::query()->with('creator:id,name,avatar,uuid')
                    ->when($auditPlan, function ($query) use ($auditPlan) {
                        $query->where('audit_plan_id', $auditPlan->id);
                    })->organization();

                $this->search($request, $records);
                $this->sort($request, $records);
                $this->applyFilters($request, $records);
                $records = $records->paginate($perPage);

                if ($request->ajax()) {

                    try {
                        $datatable = view('engagement.datatable', compact('records'))->render();
                        return response()->json([
                            'status' => '200',
                            'msg' => 'Data loaded',
                            'data' => $datatable,
                            'paginationInfo' => getPaginationInfo($records)
                        ], 200);
                    } catch (Throwable $th) {
                        return throwException($th);
                    }
                }


                $financialYears = null;
                if (empty($auditPlanId)) {
                    $financialYears = AuditPlan::organization()->distinct('financial_year')->pluck('financial_year')->toArray();
                    // $financialYears = getFinancialYears();
                }
                return view('engagement.index', compact('auditPlanId', 'financialYears'));
            } catch (Throwable $th) {
                return response()->json([
                    'status' => '500',
                    'msg' => 'An exception occurred',
                    'exception' => $th->getMessage(),
                    'trace' => $th->getTrace()
                ], 500);
            }
        }
        abort(403, 'Access Denied');
    }
    
    
       private function actionableStatus($request = null)
    {
        $query = Engagement::query();
        if ($request) {
            $query = $this->actionableListfilter($request, $query);
        }

        $actionablesStatus = $query->get();

        return $actionablesStatus;
    }

    
    protected function ActionableApplyFilters($request, $query)
    {

        if (!empty($request->financial_year)) {

            $observationIds = Observation::query()
                ->ByOrganization()
                ->where('financial_year', $request->financial_year)
                ->pluck('id') // Fetch the 'id' column
                ->toArray(); // Convert to a plain array

            $query->whereIn('observation_id', $observationIds);
        }
        if (!empty($request->quarter)) {

            $observationIds = Observation::query()
                ->ByOrganization()
                ->where('quarter', $request->quarter)
                ->pluck('id') // Fetch the 'id' column
                ->toArray(); // Convert to a plain array

            $query->whereIn('observation_id', $observationIds);
        }
        if (!empty($request->company)) {
            $query->whereIn('company_id', $request->company);
        }
        if (!empty($request->department)) {
            $query->whereIn('department_id', $request->department);
        }
        if (!empty($request->risk_rating)) {
            $query->whereIn('priority', $request->risk_rating);
        }
        if (!empty($request->location)) {
            $query->whereIn('location_id', $request->location);
        }



        return $query;
    }
        //* regarding 
        //* regarding 
        @php
                                        $status = strtolower(trim($observationdata->status ?? ''));
                                        $risk = strtolower(trim($observationdata->risk_grading ?? ''));

                                        $statusStyle =
                                            $statusStyles[$status] ?? 'background-color:#F1F5F9; color:#475569;';
                                        $riskStyle = $riskStyles[$risk] ?? 'background-color:#F1F5F9; color:#475569;';
                                    @endphp

                                          <td>
                                            <span class="badge-pill" style="{{ $statusStyle }}">
                                                {{ ucfirst($observationdata->status) }}
                                            </span>
                                        </td>
        //* regarding 
        
        Illuminate\Http\Request {#45 // app\Http\Controllers\Admin\InternalAudit\AuditProcedure\AuditProcedureRepository.php:32
  +attributes: 
Symfony\Component\HttpFoundation
\
ParameterBag
 {#47
    #parameters: []
  }
  +request: 
Symfony\Component\HttpFoundation
\
InputBag
 {#46
    #parameters: []
  }
  +query: 
Symfony\Component\HttpFoundation
\
InputBag
 {#53
    #parameters: array:1 [
      "engagementId" => "15"
    ]
  }



        //* regarding 
        
        //* regarding 
          protected function auditStatusChart($request = null)
    {
        $labels = [
            'planned',
            'in progress',
            'completed'
        ];
        $audits = Assignment::query()->ByOrganization();

        if ($request) {
            $audits = $this->AssignmentOverviewFilters($request, $audits);
        }

        $audits = $audits->get()
            ->groupBy('status')
            ->map(function ($group) {
                return $group->count();
            });


        $chartData = [];
        foreach ($labels as $key => $value) {
            $chartData[$value] = $audits->get($value, 0);
        }
        //  dd($chartData);
        return $chartData;
    }
        //* regarding 
            public function import($file)
    {

        function normalizeYesNo($value)
        {
            $value = strtolower(trim($value));
            if (in_array($value, ['y', 'yes'])) {
                return 'Yes';
            } elseif (in_array($value, ['n', 'no'])) {
                return 'No';
            }
            return null; // Or keep original if needed
        }
        function normalizeYesNoV2($value)
        {
            $value = strtolower(trim($value));
            if (in_array($value, ['y', 'yes'])) {
                return 'yes';
            } elseif (in_array($value, ['n', 'no'])) {
                return 'no';
            }
            return null; // Or keep original if needed
        }
        function handleFrequency($value)
        {
            $value = strtolower(trim($value));


            // Remove unwanted characters and normalize spacing
            $value = preg_replace('/[^a-z]/', '', $value); // only alphabets

            $map = [
                'daily' => 'daily',
                'weekly' => 'weekly',
                'fortnightly' => 'fortnightly',
                'monthly' => 'monthly',
                'quarterly' => 'quarterly',
                'halfyearly' => 'half-yearly',
                'halfyear' => 'half-yearly',
                'halfyearly' => 'half-yearly',
                'halyearly' => 'half-yearly',
                'yearly' => 'yearly',
                'annual' => 'yearly',
                'event' => 'event',
                'eventasandwhen' => 'event',
                'eventasanwhen' => 'event', // typo handled
                'asandwhen' => 'event',
                'asanwhen' => 'event',
            ];

            return $map[$value] ?? null;
        }

        // Preload reference data
        $companies = Company::ByOrganization()->pluck('id', 'name')->mapWithKeys(fn($id, $name) => [strtolower($name) => $id])->toArray();
        $locations = Location::ByOrganization()->pluck('id', 'name')->mapWithKeys(fn($id, $name) => [strtolower($name) => $id])->toArray();
        $users = User::ByOrganization()->pluck('id', 'name')->mapWithKeys(fn($id, $name) => [strtolower($name) => $id])->toArray();

        // Fetch dropdown data for the organization
        $dropdownData = Dropdown::ByOrganization()->get(['key', 'option_value']);

        $dropdowns = [
            'risk_rating' => [],
            'risk_category' => [],
            'fraud_risk' => [],
            // control_type
            'key_control' => [],
            'manual_automated' => [],
            'preventive_detective' => [],
            'elc_plc' => [],
        ];

        foreach ($dropdownData as $dropdown) {
            $key = $dropdown->key;
            $optionValue = $dropdown->option_value;
            //dd($key, $optionValue);
            if (in_array($key, array_keys($dropdowns))) {
                $dropdowns[$key][strtolower($optionValue)] = $optionValue;
            }
        }

        $successCount = ['processes' => 0, 'subprocesses' => 0, 'risks' => 0, 'controls' => 0];
        $errors = []; // Track all errors across rows
        $failedRows = 0; // Track rows not inserted due to errors

        $rows = $this->readRows($file);
        $headers = $this->getHeaders($rows);
        array_shift($rows);
        $headers = array_map('str_replace', array_fill(0, count($headers), ' '), array_fill(0, count($headers), ''), $headers);
        $headers = array_map('strtolower', $headers);
        $totalBatches = $this->createBatches($rows);
        $rowErrors = [];
        for ($batch = 0; $batch < $totalBatches; $batch++) {
            $batchRows = array_slice($rows, $batch * $this->batchSize, $this->batchSize);

            foreach ($batchRows as $rowIndex => $row) {
                // Map row data to column names
                // $rowData = array_combine($headers, array_pad($row, count($headers), null));
                $rowData = array_combine(
                    $headers,
                    array_slice($row, 0, count($headers)) // sirf 57 values lega
                );

                // Errors for this specific row

                // Company IDs
                $companyNames = array_filter(array_map('trim', explode(',', trim($rowData['company'] ?? ''))));
                $companyIds = [];
                $invalidCompanies = [];
                foreach ($companyNames as $name) {
                    $nameLower = strtolower($name);
                    if (isset($companies[$nameLower])) {
                        $companyIds[] = $companies[$nameLower];
                    } else if ($name) {
                        $rowErrors[] = "Company not found: $name (row " . ($rowIndex + 2) . ")";
                        $invalidCompanies[] = $name;
                    }
                }

                // Required Fields Validation
                $companyName = trim($rowData['company'] ?? '');
                $processName = trim($rowData['process'] ?? '');
                $subProcessName = trim($rowData['subprocess'] ?? '');
                $riskTitle = trim($rowData['risktitle'] ?? '');
                $controlObjective = trim($rowData['controlobjective'] ?? '');


                if (!$companyName) {
                    $rowErrors[] = "Missing required field: Company (row " . ($rowIndex + 2) . ")";
                }

                if (!$processName) {
                    $rowErrors[] = "Missing required field: Process (row " . ($rowIndex + 2) . ")";
                }
                if (!$subProcessName) {
                    $rowErrors[] = "Missing required field: Sub Process (row " . ($rowIndex + 2) . ")";
                }
                if (!$riskTitle) {
                    $rowErrors[] = "Missing required field: Risk Title (row " . ($rowIndex + 2) . ")";
                }

                if (!$controlObjective) {
                    $rowErrors[] = "Missing required field: Control Objective (row " . ($rowIndex + 2) . ")";
                }


                // Skip row if any validation fails (invalid companies or missing required fields)
                if (!empty($invalidCompanies) || !$companyName || !$processName || !$subProcessName || !$riskTitle || !$controlObjective) {
                    $errors = array_merge($errors, $rowErrors);
                    $failedRows++; // Increment failed rows counter
                    continue; // Skip to next row
                }

                // Location IDs
                $locationNames = array_filter(array_map('trim', explode(',', trim($rowData['location'] ?? ''))));
                $locationIds = [];
                foreach ($locationNames as $name) {
                    $nameLower = strtolower($name);
                    if (isset($locations[$nameLower])) {
                        $locationIds[] = $locations[$nameLower];
                    }
                }

                // Process
                $processData =
                    [
                        'uuid' => (string) Uuid::uuid4(),
                        'name' => $processName,
                        'process_id' => $this->generateProcessId(),
                        'company_id' => implode(',', $companyIds) ?: null,
                        'description' => $rowData['processdescription'] ?? null,
                        'last_reviewed_date' => $this->formatDate($rowData['lastreviewdate'] ?? null),
                        'next_reviewed_date' => $this->formatDate($rowData['nextreviewdate'] ?? null),
                        'owner_id' => $users[strtolower(trim($rowData['processowner'] ?? ''))] ?? null,
                    ];

                $process = Process::firstOrCreate(
                    ['name' => $processName, 'organization_id' => organizationId()],
                    $processData
                );
                if ($process->wasRecentlyCreated) {
                    $successCount['processes']++;
                }


                $subprocessData =
                    [
                        'name' => $subProcessName,
                        'uuid' => (string) Uuid::uuid4(),
                        'subprocess_id' => $this->generateSubprocessId(),
                        'company_id' => implode(',', $companyIds) ?: null,
                        'location_id' => implode(',', $locationIds) ?: null,
                        'last_reviewed_date' => $this->formatDate($rowData['subprocesslastreviewdate'] ?? null),
                        'next_reviewed_date' => $this->formatDate($rowData['subprocessnextreviewdate'] ?? null),
                    ];

                // Subprocess
                $subprocess = Subprocess::firstOrCreate(
                    ['name' => $subProcessName, 'organization_id' => organizationId(), 'process_id' => $process->id ?? 'null'],
                    $subprocessData
                );
                if ($process->wasRecentlyCreated) {
                    $successCount['subprocesses']++;
                }


                // Risk
                $likelihood = strtolower(trim($rowData['likelihood'] ?? ''));
                $impact = strtolower(trim($rowData['impact'] ?? ''));

                // Build lowercase keys for matching
                foreach ($dropdownData as $dropdown) {
                    $key = $dropdown->key;
                    $optionValue = $dropdown->option_value;
                    if (array_key_exists($key, $dropdowns)) {
                        $dropdowns[$key][strtolower($optionValue)] = $optionValue;
                    }
                }

                // Step 2: Mapping row values to dropdown options
                $mappedRow = [];
                //  dd($dropdownData);
                foreach ($dropdowns as $key => $options) {
                    // Convert dropdown key to appropriate rowData column name (adjust as needed)
                    $columnMap = [
                        'risk_rating' => 'riskrating',
                        'risk_category' => 'riskcategory',
                        'key_control' => 'Keycontrol',
                        'preventive_detective' => 'controltype',
                        'manual_automated' => 'controlnature',
                        'elc_plc' => 'elc'
                    ];

                    $columnName = $columnMap[$key] ?? null;
                    $value = trim($rowData[$columnName] ?? '');

                    if ($value !== '') {
                        $lowerValue = strtolower($value);

                        if (array_key_exists($lowerValue, $options)) {
                            $mappedRow[$key] = $options[$lowerValue]; // e.g., "High"
                        } else {
                            $mappedRow[$key] = null;
                            $rowErrors[] = "Invalid $key: '{$value}'";
                        }
                    } else {
                        $mappedRow[$key] = null;
                    }
                }

                $riskData =  [
                    'name' => $riskTitle,
                    'uuid' => (string) Uuid::uuid4(),
                    'risk_id' => $this->generateRiskId(),
                    'description' => $rowData['riskdescription'] ?? null,
                    'company_id' => implode(',', $companyIds) ?: null,
                    'location_id' => implode(',', $locationIds) ?: null,
                    'rating' => $mappedRow['risk_rating'] ?? null,
                    'fraud_risk' => isset($rowData['fraudrisk']) ? normalizeYesNo($rowData['fraudrisk']) : null,
                    'likelihood' => $likelihood ?: null,
                    'impact' => $impact ?: null,
                    'residual_risk_rating' => $rowData['residualriskscore'] ?? null,
                    'inherent_risk_score' => $rowData['inherentriskscore'] ?? null,
                    'process_id' => $process->id ?? null,
                    'subprocess_id' => $subprocess->id ?? null,
                    'risk_category' => $mappedRow['risk_category'] ?? null,
                    'last_reviewed_date' => $this->formatDate($rowData['risklastreviewdate'] ?? null),
                    'owner_id' => $users[strtolower(trim($rowData['riskowner'] ?? ''))] ?? null,
                ];

                $risk = Risk::firstOrCreate(
                    ['name' => $riskTitle, 'organization_id' => organizationId()],
                    $riskData
                );
                if ($risk->wasRecentlyCreated) {
                    $successCount['risks']++;
                }

                // Control
                $controlData = [
                    'uuid' => (string) Uuid::uuid4(),
                    'organization_id' => organizationId(),
                    'control_id' => $this->generateControlId($process->id ?? ''),
                    'title' => $rowData['controlobjective'] ?? null,
                    'reference_no' => $controlRefNo,
                    'description' => $rowData['description'] ?? null,
                    'company_id' => implode(',', $companyIds) ?: null,
                    'elc_plc' => json_encode([$mappedRow['elc_plc']] ?? []) ?? null,
                    'process_id' => $process->id ?? null,
                    'subprocess_id' => $subprocess->id ?? null,
                    'risk_id' => $risk->id ?? null,
                    'key_control' => isset($rowData['keycontrol']) ? normalizeYesNo($rowData['keycontrol']) : null,
                    'frequency' => handleFrequency($rowData['frequency']) ?? null,
                    'preventive_detective' => $mappedRow['preventive_detective'] ?? null,
                    'manual_automated' => strtolower($rowData['controlnature'] ?? null) ?? null,
                    'icfor' => isset($rowData['icfor']) ? normalizeYesNo($rowData['icfor']) : null,
                    'owner_id' => $users[strtolower(trim($rowData['controlperformer'] ?? ''))] ?? null,
                    'performer_id' => $users[strtolower(trim($rowData['controlperformer'] ?? ''))] ?? null,
                    'reviewer_id' => $users[strtolower(trim($rowData['controlreviewer'] ?? ''))] ?? null,
                    'last_reviewed_date' => $this->formatDate($rowData['controlreviewdate'] ?? null),

                    'assertion_completeness' => normalizeYesNoV2($rowData['assertioncompleteness'] ?? ''),
                    'assertion_existence' => normalizeYesNoV2($rowData['assertionexistence'] ?? ''),
                    'assertion_accuracy' => normalizeYesNoV2($rowData['assertionaccuracy'] ?? ''),
                    'assertion_valuation' => normalizeYesNoV2($rowData['assertionvaluation'] ?? ''),
                    'assertion_rigths_obligations' => normalizeYesNoV2($rowData['assertionrigthsobligations'] ?? ''),
                    'assertion_presentation_disclosure' => normalizeYesNoV2($rowData['assertionpresentationdisclosure'] ?? ''),

                    // COSO
                    'cosocontrol_environment_p1' => normalizeYesNoV2($rowData['cosocontrolenvironmentp1'] ?? ''),
                    'cosocontrol_environment_p2' => normalizeYesNoV2($rowData['cosocontrolenvironmentp2'] ?? ''),
                    'cosocontrol_environment_p3' => normalizeYesNoV2($rowData['cosocontrolenvironmentp3'] ?? ''),
                    'cosocontrol_environment_p4' => normalizeYesNoV2($rowData['cosocontrolenvironmentp4'] ?? ''),
                    'cosocontrol_environment_p5' => normalizeYesNoV2($rowData['cosocontrolenvironmentp5'] ?? ''),

                    'coso_risk_assessment_p6' => normalizeYesNoV2($rowData['cosoriskassessmentp6'] ?? ''),
                    'coso_risk_assessment_p7' => normalizeYesNoV2($rowData['cosoriskassessmentp7'] ?? ''),
                    'coso_risk_assessment_p8' => normalizeYesNoV2($rowData['cosoriskassessmentp8'] ?? ''),
                    'coso_risk_assessment_p9' => normalizeYesNoV2($rowData['cosoriskassessmentp9'] ?? ''),

                    'coso_control_activities_p10' => normalizeYesNoV2($rowData['cosocontrolactivitiesp10'] ?? ''),
                    'coso_control_activities_p11' => normalizeYesNoV2($rowData['cosocontrolactivitiesp11'] ?? ''),
                    'coso_control_activities_p12' => normalizeYesNoV2($rowData['cosocontrolactivitiesp12'] ?? ''),

                    'coso_info_and_communication_p13' => normalizeYesNoV2($rowData['cosoinfoandcommunicationp13'] ?? ''),
                    'coso_info_and_communication_p14' => normalizeYesNoV2($rowData['cosoinfoandcommunicationp14'] ?? ''),
                    'coso_info_and_communication_p15' => normalizeYesNoV2($rowData['cosoinfoandcommunicationp15'] ?? ''),

                    'coso_monitoring_p16' => normalizeYesNoV2($rowData['cosomonitoringp16'] ?? ''),
                    'coso_monitoring_p17' => normalizeYesNoV2($rowData['cosomonitoringp17'] ?? ''),

                ];
                // return $controlData;
                $control = Control::firstOrCreate(
                    ['title' => $controlData['title'], 'organization_id' => organizationId()],
                    $controlData
                );
                if ($control->wasRecentlyCreated) {
                    $successCount['controls']++;
                    // Sync Locations for Control
                    if (!empty($rowData['location'])) {
                        $locationNames = array_filter(array_map('trim', explode(',', trim($rowData['location']))));
                        $performerNames = array_filter(array_map('trim', explode(',', trim($rowData['controlperformer'] ?? ''))));
                        $reviewerNames = array_filter(array_map('trim', explode(',', trim($rowData['controlreviewer'] ?? ''))));

                        $locationIds = [];
                        $ownerIds = [];
                        $approverIds = [];

                        foreach ($locationNames as $index => $locName) {
                            $locNameLower = strtolower($locName);
                            $performerName = strtolower(trim($performerNames[$index] ?? ''));
                            $reviewerName = strtolower(trim($reviewerNames[$index] ?? ''));

                            if (isset($locations[$locNameLower])) {
                                $locationIds[] = $locations[$locNameLower];
                                $ownerIds[] = $users[$performerName] ?? null;
                                $approverIds[] = $users[$reviewerName] ?? null;
                            }
                        }

                        if (!empty($locationIds)) {
                            $this->syncLocations($locationIds, $control, $ownerIds, $approverIds);
                        }
                    }
                }
            }
        }

        return ['successCount' => $successCount, 'rowErrors' => $rowErrors, 'failedRows' => $failedRows];
    }
        //* regarding 
         public function create($request)
    {
        $this->check('irl.create');
        $module = $request->module ?? '';
        $moduleId = $request->moduleId ?? '';
        $invitedUsers = getInvitedUsers();
        $users = User::ByOrganization()->active()->select('id', 'name', 'organization_id')
            ->where('id', '!=', authUser()->id)
            ->get();
        $users = $users->merge($invitedUsers);
        $assignmentId = $request->assignmentId ?? null;
        if (!empty($request->assignmentId)) {
            $assignment = Assignment::with('team')->find($request->assignmentId);
            $users = User::active()->select('id', 'name', 'organization_id')
                ->whereNotIn('id', $assignment->team->pluck('user_id')->toArray())
                ->get();
        }
        // $users
        return view('irl.create', compact('users', 'module', 'moduleId', 'assignmentId'));
    }
        //* regarding
         "attachment" => array:1 [
        0 => 
Symfony\Component\HttpFoundation\File
\
UploadedFile
 {#37
          -test: false
          -originalName: "mb1.pptx"
          -mimeType: "application/vnd.openxmlformats-officedocument.presentationml.presentation"
          -error: 0
          path: "C:\xampp\tmp"
          filename: "phpE174.tmp"
          basename: "phpE174.tmp"
          pathname: "C:\xampp\tmp\phpE174.tmp"
          extension: "tmp"
          realPath: "
C:\xampp
\
tmp\phpE174.tmp
"
          aTime: 2026-03-16 13:49:07
          mTime: 2026-03-16 13:49:07
          cTime: 2026-03-16 13:49:07
          inode: 109212290963818635
          size: 1861903
          perms: 0100666
          owner: 0
          group: 0
          type: "file"
          writable: true
          readable: true
          executable: false
          file: true
          dir: false
          link: false
          linkTarget: "C:\xampp\tmp\phpE174.tmp"
        }
      ]
    ]
  } 
        //* regarding 

           $columnMap = [
                        'risk_rating' => 'riskrating',
                        'risk_category' => 'riskcategory',
                        'key_control' => 'Keycontrol',
                        // 'preventive_detective' => 'controltype',
                        // 'manual_automated' => 'controlnature',
                        // 'elc_plc' => 'elc'
                    ];


                          if (array_key_exists($lowerValue, $options)) {
                            $mappedRow[$key] = $options[$lowerValue]; // e.g., "High"
                            dd($columnMap, $columnName, $value, $lowerValue, $options, 1);
                        } else {
                            dd($columnMap, $columnName, $value, $lowerValue, $options);
                            $mappedRow[$key] = null;
                            $rowErrors[] = "Invalid $key: '{$value}'";
                        }
            public function import($file)
    {

        function normalizeYesNo($value)
        {
            $value = strtolower(trim($value));
            if (in_array($value, ['y', 'yes'])) {
                return 'Yes';
            } elseif (in_array($value, ['n', 'no'])) {
                return 'No';
            }
            return null; // Or keep original if needed
        }
        function normalizeYesNoV2($value)
        {
            $value = strtolower(trim($value));
            if (in_array($value, ['y', 'yes'])) {
                return 'yes';
            } elseif (in_array($value, ['n', 'no'])) {
                return 'no';
            }
            return null; // Or keep original if needed
        }
        function handleFrequency($value)
        {
            $value = strtolower(trim($value));


            // Remove unwanted characters and normalize spacing
            $value = preg_replace('/[^a-z]/', '', $value); // only alphabets

            $map = [
                'daily' => 'daily',
                'weekly' => 'weekly',
                'fortnightly' => 'fortnightly',
                'monthly' => 'monthly',
                'quarterly' => 'quarterly',
                'halfyearly' => 'half-yearly',
                'halfyear' => 'half-yearly',
                'halfyearly' => 'half-yearly',
                'halyearly' => 'half-yearly',
                'yearly' => 'yearly',
                'annual' => 'yearly',
                'event' => 'event',
                'eventasandwhen' => 'event',
                'eventasanwhen' => 'event', // typo handled
                'asandwhen' => 'event',
                'asanwhen' => 'event',
            ];

            return $map[$value] ?? null;
        }

        // Preload reference data
        $companies = Company::ByOrganization()->pluck('id', 'name')->mapWithKeys(fn($id, $name) => [strtolower($name) => $id])->toArray();
        $locations = Location::ByOrganization()->pluck('id', 'name')->mapWithKeys(fn($id, $name) => [strtolower($name) => $id])->toArray();
        $users = User::ByOrganization()->pluck('id', 'name')->mapWithKeys(fn($id, $name) => [strtolower($name) => $id])->toArray();

        // Fetch dropdown data for the organization
        $dropdownData = Dropdown::ByOrganization()->get(['key', 'option_value']);

        $dropdowns = [
            'risk_rating' => [],
            // 'risk_category' => [],
            'fraud_risk' => [],
            // control_type
            'key_control' => [],
            // 'preventive_detective' => [],
            // 'manual_automated' => [],
            // 'preventive_detective' => [],


            // 'elc_plc' => [],
        ];

        foreach ($dropdownData as $dropdown) {
            $key = $dropdown->key;
            $optionValue = $dropdown->option_value;
            //dd($key, $optionValue);
            if (in_array($key, array_keys($dropdowns))) {
                $dropdowns[$key][strtolower($optionValue)] = $optionValue;
            }
        }

        $successCount = ['processes' => 0, 'subprocesses' => 0, 'risks' => 0, 'controls' => 0];
        $errors = []; // Track all errors across rows
        $failedRows = 0; // Track rows not inserted due to errors

        $rows = $this->readRows($file);
        $headers = $this->getHeaders($rows);

        array_shift($rows);
        $headers = array_map('str_replace', array_fill(0, count($headers), ' '), array_fill(0, count($headers), ''), $headers);
        $headers = array_map('strtolower', $headers);
        $totalBatches = $this->createBatches($rows);
        $rowErrors = [];
        for ($batch = 0; $batch < $totalBatches; $batch++) {
            $batchRows = array_slice($rows, $batch * $this->batchSize, $this->batchSize);

            foreach ($batchRows as $rowIndex => $row) {
                // Map row data to column names
                // $rowData = array_combine($headers, array_pad($row, count($headers), null));
                $rowData = array_combine(
                    $headers,
                    array_slice($row, 0, count($headers)) // sirf 57 values lega
                );

                // Errors for this specific row

                // Company IDs
                $companyNames = array_filter(array_map('trim', explode(',', trim($rowData['company'] ?? ''))));
                $companyIds = [];
                $invalidCompanies = [];
                foreach ($companyNames as $name) {
                    $nameLower = strtolower($name);
                    if (isset($companies[$nameLower])) {
                        $companyIds[] = $companies[$nameLower];
                    } else if ($name) {
                        $rowErrors[] = "Company not found: $name (row " . ($rowIndex + 2) . ")";
                        $invalidCompanies[] = $name;
                    }
                }

                // Required Fields Validation
                $processName = trim($rowData['process'] ?? '');
                $subProcessName = trim($rowData['subprocess'] ?? '');
                $riskTitle = trim($rowData['risktitle'] ?? '');
                $controlRefNo = trim($rowData['referenceno'] ?? '');

                if (!$processName) {
                    $rowErrors[] = "Missing required field: Process (row " . ($rowIndex + 2) . ")";
                }
                if (!$subProcessName) {
                    $rowErrors[] = "Missing required field: Sub Process (row " . ($rowIndex + 2) . ")";
                }
                if (!$riskTitle) {
                    $rowErrors[] = "Missing required field: Risk Title (row " . ($rowIndex + 2) . ")";
                }
                // if (!$controlRefNo) {
                //     $rowErrors[] = "Missing required field: Reference No (row " . ($rowIndex + 2) . ")";
                // }

                // Skip row if any validation fails (invalid companies or missing required fields)
                if (!empty($invalidCompanies) || !$processName || !$subProcessName || !$riskTitle || !$controlRefNo) {
                    $errors = array_merge($errors, $rowErrors);
                    $failedRows++; // Increment failed rows counter
                    continue; // Skip to next row
                }

                // Location IDs
                $locationNames = array_filter(array_map('trim', explode(',', trim($rowData['location'] ?? ''))));
                $locationIds = [];
                foreach ($locationNames as $name) {
                    $nameLower = strtolower($name);
                    if (isset($locations[$nameLower])) {
                        $locationIds[] = $locations[$nameLower];
                    }
                }

                // Process
                $processData =
                    [
                        'uuid' => (string) Uuid::uuid4(),
                        'name' => $processName,
                        'process_id' => $this->generateProcessId(),
                        'company_id' => implode(',', $companyIds) ?: null,
                        'description' => $rowData['processdescription'] ?? null,
                        'last_reviewed_date' => $this->formatDate($rowData['lastreviewdate'] ?? null),
                        'next_reviewed_date' => $this->formatDate($rowData['nextreviewdate'] ?? null),
                        'owner_id' => $users[strtolower(trim($rowData['processowner'] ?? ''))] ?? null,
                    ];

                $process = Process::firstOrCreate(
                    ['name' => $processName, 'organization_id' => organizationId()],
                    $processData
                );
                if ($process->wasRecentlyCreated) {
                    $successCount['processes']++;
                }


                $subprocessData =
                    [
                        'name' => $subProcessName,
                        'uuid' => (string) Uuid::uuid4(),
                        'subprocess_id' => $this->generateSubprocessId(),
                        'company_id' => implode(',', $companyIds) ?: null,
                        'location_id' => implode(',', $locationIds) ?: null,
                        'last_reviewed_date' => $this->formatDate($rowData['subprocesslastreviewdate'] ?? null),
                        'next_reviewed_date' => $this->formatDate($rowData['subprocessnextreviewdate'] ?? null),
                    ];

                // Subprocess
                $subprocess = Subprocess::firstOrCreate(
                    ['name' => $subProcessName, 'organization_id' => organizationId(), 'process_id' => $process->id ?? 'null'],
                    $subprocessData
                );
                if ($process->wasRecentlyCreated) {
                    $successCount['subprocesses']++;
                }


                // Risk
                $likelihood = strtolower(trim($rowData['likelihood'] ?? ''));
                $impact = strtolower(trim($rowData['impact'] ?? ''));

                // Build lowercase keys for matching
                foreach ($dropdownData as $dropdown) {
                    $key = $dropdown->key;
                    $optionValue = $dropdown->option_value;
                    if (array_key_exists($key, $dropdowns)) {
                        $dropdowns[$key][strtolower($optionValue)] = $optionValue;
                    }
                }

                // Step 2: Mapping row values to dropdown options
                $mappedRow = [];
                //  dd($dropdownData);
                foreach ($dropdowns as $key => $options) {
                    // Convert dropdown key to appropriate rowData column name (adjust as needed)
                    $columnMap = [
                        'risk_rating' => 'riskrating',
                        // 'risk_category' => 'riskcategory',
                        'key_control' => 'Keycontrol',
                        // 'preventive_detective' => 'controltype',
                        // 'manual_automated' => 'controlnature',
                        // 'elc_plc' => 'elc'
                    ];

                    $columnName = $columnMap[$key] ?? null;
                    $value = trim($rowData[$columnName] ?? '');

                    if ($value !== '') {
                        $lowerValue = strtolower($value);

                        if (array_key_exists($lowerValue, $options)) {
                            $mappedRow[$key] = $options[$lowerValue]; // e.g., "High"
                        } else {
                            $mappedRow[$key] = null;
                            $rowErrors[] = "Invalid $key: '{$value}'";
                        }
                    } else {
                        $mappedRow[$key] = null;
                    }
                }

                $riskData =  [
                    'name' => $riskTitle,
                    'uuid' => (string) Uuid::uuid4(),
                    'risk_id' => $this->generateRiskId(),
                    'description' => $rowData['riskdescription'] ?? null,
                    'company_id' => implode(',', $companyIds) ?: null,
                    'location_id' => implode(',', $locationIds) ?: null,
                    'rating' => $mappedRow['risk_rating'] ?? null,
                    'fraud_risk' => isset($rowData['fraudrisk']) ? normalizeYesNo($rowData['fraudrisk']) : null,
                    'likelihood' => $likelihood ?: null,
                    'impact' => $impact ?: null,
                    'residual_risk_rating' => $rowData['residualriskscore'] ?? null,
                    'inherent_risk_score' => $rowData['inherentriskscore'] ?? null,
                    'process_id' => $process->id ?? null,
                    'subprocess_id' => $subprocess->id ?? null,
                    // 'risk_category' => $mappedRow['risk_category'] ?? null,
                    'last_reviewed_date' => $this->formatDate($rowData['risklastreviewdate'] ?? null),
                    'owner_id' => $users[strtolower(trim($rowData['riskowner'] ?? ''))] ?? null,
                ];

                $risk = Risk::firstOrCreate(
                    ['name' => $riskTitle, 'organization_id' => organizationId()],
                    $riskData
                );
                if ($risk->wasRecentlyCreated) {
                    $successCount['risks']++;
                }

                // Control
                $controlData = [
                    'uuid' => (string) Uuid::uuid4(),
                    'organization_id' => organizationId(),
                    'control_id' => $this->generateControlId($process->id ?? ''),
                    'title' => $rowData['controlobjective'] ?? null,
                    'reference_no' => $controlRefNo,
                    'description' => $rowData['description'] ?? null,
                    'company_id' => implode(',', $companyIds) ?: null,
                    // 'elc_plc' => json_encode([$mappedRow['elc_plc']] ?? []) ?? null,
                    'process_id' => $process->id ?? null,
                    'subprocess_id' => $subprocess->id ?? null,
                    'risk_id' => $risk->id ?? null,
                    'key_control' => isset($rowData['keycontrol']) ? normalizeYesNo($rowData['keycontrol']) : null,
                    'frequency' => handleFrequency($rowData['frequency']) ?? null,
                    // 'preventive_detective' => $mappedRow['preventive_detective'] ?? null,
                    // 'manual_automated' => strtolower($rowData['controlnature'] ?? null) ?? null,
                    'icfor' => isset($rowData['icfor']) ? normalizeYesNo($rowData['icfor']) : null,
                    'owner_id' => $users[strtolower(trim($rowData['controlperformer'] ?? ''))] ?? null,
                    'performer_id' => $users[strtolower(trim($rowData['controlperformer'] ?? ''))] ?? null,
                    'reviewer_id' => $users[strtolower(trim($rowData['controlreviewer'] ?? ''))] ?? null,
                    'last_reviewed_date' => $this->formatDate($rowData['controlreviewdate'] ?? null),

                    'assertion_completeness' => normalizeYesNoV2($rowData['assertioncompleteness'] ?? ''),
                    'assertion_existence' => normalizeYesNoV2($rowData['assertionexistence'] ?? ''),
                    'assertion_accuracy' => normalizeYesNoV2($rowData['assertionaccuracy'] ?? ''),
                    'assertion_valuation' => normalizeYesNoV2($rowData['assertionvaluation'] ?? ''),
                    'assertion_rigths_obligations' => normalizeYesNoV2($rowData['assertionrigthsobligations'] ?? ''),
                    'assertion_presentation_disclosure' => normalizeYesNoV2($rowData['assertionpresentationdisclosure'] ?? ''),

                    // COSO
                    'cosocontrol_environment_p1' => normalizeYesNoV2($rowData['cosocontrolenvironmentp1'] ?? ''),
                    'cosocontrol_environment_p2' => normalizeYesNoV2($rowData['cosocontrolenvironmentp2'] ?? ''),
                    'cosocontrol_environment_p3' => normalizeYesNoV2($rowData['cosocontrolenvironmentp3'] ?? ''),
                    'cosocontrol_environment_p4' => normalizeYesNoV2($rowData['cosocontrolenvironmentp4'] ?? ''),
                    'cosocontrol_environment_p5' => normalizeYesNoV2($rowData['cosocontrolenvironmentp5'] ?? ''),

                    'coso_risk_assessment_p6' => normalizeYesNoV2($rowData['cosoriskassessmentp6'] ?? ''),
                    'coso_risk_assessment_p7' => normalizeYesNoV2($rowData['cosoriskassessmentp7'] ?? ''),
                    'coso_risk_assessment_p8' => normalizeYesNoV2($rowData['cosoriskassessmentp8'] ?? ''),
                    'coso_risk_assessment_p9' => normalizeYesNoV2($rowData['cosoriskassessmentp9'] ?? ''),

                    'coso_control_activities_p10' => normalizeYesNoV2($rowData['cosocontrolactivitiesp10'] ?? ''),
                    'coso_control_activities_p11' => normalizeYesNoV2($rowData['cosocontrolactivitiesp11'] ?? ''),
                    'coso_control_activities_p12' => normalizeYesNoV2($rowData['cosocontrolactivitiesp12'] ?? ''),

                    'coso_info_and_communication_p13' => normalizeYesNoV2($rowData['cosoinfoandcommunicationp13'] ?? ''),
                    'coso_info_and_communication_p14' => normalizeYesNoV2($rowData['cosoinfoandcommunicationp14'] ?? ''),
                    'coso_info_and_communication_p15' => normalizeYesNoV2($rowData['cosoinfoandcommunicationp15'] ?? ''),

                    'coso_monitoring_p16' => normalizeYesNoV2($rowData['cosomonitoringp16'] ?? ''),
                    'coso_monitoring_p17' => normalizeYesNoV2($rowData['cosomonitoringp17'] ?? ''),

                ];
                // return $controlData;
                $control = Control::firstOrCreate(
                    ['title' => $controlData['title'], 'organization_id' => organizationId()],
                    $controlData
                );
                if ($control->wasRecentlyCreated) {
                    $successCount['controls']++;
                    // Sync Locations for Control
                    if (!empty($rowData['location'])) {
                        $locationNames = array_filter(array_map('trim', explode(',', trim($rowData['location']))));
                        $performerNames = array_filter(array_map('trim', explode(',', trim($rowData['controlperformer'] ?? ''))));
                        $reviewerNames = array_filter(array_map('trim', explode(',', trim($rowData['controlreviewer'] ?? ''))));

                        $locationIds = [];
                        $ownerIds = [];
                        $approverIds = [];

                        foreach ($locationNames as $index => $locName) {
                            $locNameLower = strtolower($locName);
                            $performerName = strtolower(trim($performerNames[$index] ?? ''));
                            $reviewerName = strtolower(trim($reviewerNames[$index] ?? ''));

                            if (isset($locations[$locNameLower])) {
                                $locationIds[] = $locations[$locNameLower];
                                $ownerIds[] = $users[$performerName] ?? null;
                                $approverIds[] = $users[$reviewerName] ?? null;
                            }
                        }

                        if (!empty($locationIds)) {
                            $this->syncLocations($locationIds, $control, $ownerIds, $approverIds);
                        }
                    }
                }
            }
        }

        return ['successCount' => $successCount, 'rowErrors' => $rowErrors, 'failedRows' => $failedRows];
    }
        //* regarding 
         // if ($request->hasFile('attachment')) {
            //     $storageDisk = getStorageDisk();
            //     $driver = $storageDisk == "local" ? 'local' : 's3';
            //     $file = $request->file('attachment');
            //     $filename = uniqid() . '.' . $file->getClientOriginalExtension();

            //     if ($driver == 'local') {
            //         $path = asset(uploadFile($file, 'uploads/attachment/'));
            //     } else {
            //         $path = uploadToS3($file, 'uploads/attachment/', $filename);
            //     }

            //     $data['attachment'] = $path;
            // }

            if ($request->hasFile('attachment')) {
                $paths = [];
                foreach ($request->file('attachment') as $file) {
                    $filename = uniqid() . '.' . $file->getClientOriginalExtension();
                    // public folder report_name
                    $destinationPath = public_path('admin/testfolder');
                    $file->move($destinationPath, $filename);
                    $paths[] = asset('admin/testfolder/' . $filename);
                }

                if (!empty($paths)) {
                    $data['attachment'] = $paths[0];
                    $data['attachment_json'] = json_encode($paths);
                    $data['attachmentjson_count'] = count($paths);
                }
            }

            $created = ProjectReport::create($data);
            // Create a log or backup of the upload (for version history)
            if ($created && isset($data['attachment'])) {
                DB::table('project_report_logs')->insert([
                    'project_report_id' => $created->id,
                    'version' => $created->report_type,
                    'attachment' => $data['attachment'],
                    'attachment_json' => $data['attachment_json'],
                    'uploaded_by' => authUser()->id,
                    'created_at' => now()
                ]);
            }
        //* regarding 
          public function manageTeam($request)
    {
        $assignmentId = $request->assignmentId;
        $assignment = Assignment::with('team')->find($assignmentId);

        // Handling User-------------
        $invitedUsers = getInvitedUsers();
        $users = User::ByOrganization()->active()->get();
        $users = $users->merge($invitedUsers);

        $teamMemberIds = collect($assignment->team)->pluck('user_id');
        $teamMemberIds = $teamMemberIds->unique()->values()->toArray();

        if (!empty($teamMemberIds)) {
            $users = $users->whereNotIn('id', $teamMemberIds); // $users should be a Collection
        }

        $users = collect($users);

        if ($request->isMethod('get')) {
            return view('assignment._partials.add-team', compact('users', 'assignment'));
        }
        if ($request->isMethod('post')) {

            $userIds = $request->user_ids;
            $notifiables = User::whereIn('id', $userIds)->get();
            //  dd($notifiables);
            $pushNotification = [
                'title' => 'New Audit Plan Assigned ',
                'body' => 'You have been assigned as a team member in an audit plan. Login to your account to see'
            ];
            // foreach ($notifiables as $notifiable) {
            //     $userId = $notifiable->id;

            //     if (isset($data[$userId])) {
            //         $notifiable->notify(new InAppNotification($pushNotification));
            //         sendTemplateNotification(
            //             $notifiable,
            //             'audit_plan_assigned',
            //             NewAuditPlanNotification::class,
            //             $data[$userId] // send only that user's data
            //         );
            //     }
            // }
            foreach ($userIds as $userId) {
                $assignment->team()->create([
                    'user_id' => $userId,
                    'role' =>  $request->users[$userId]['role'],
                    'expected_daily_hour' => $request->users[$userId]['daily_hours'],
                    'status' => 'active'
                ]);
                $user = User::find($userId);
                if ($user) {
                    $notificationData = [
                        'userName' => $user->name,
                        'dailyHours' => $request->users[$userId]['daily_hours'] ?? '',
                        'userId' => $userId,
                        'role' => $request->users[$userId]['role'] ?? ''
                    ];
                    $notifiable = $user;
                    $notifiable->notify(new InAppNotification($pushNotification));
                    sendTemplateNotification($user, 'audit_plan_assigned', NewAuditPlanNotification::class, $notificationData);
                }
            }
            $assignment = Assignment::find($request->assignmentId);
            $assignment->synchronizeLog([
                'event' => 'Internal Audit Team',
                'comment' => "Internal Audit Team Created",
                'logged_by' => authUser()->id,
            ]);
            return response()->json([
                'status' => '200',
                'msg' => 'Added Successfully',
                'jsFunction' => 'reloadTable'
            ], 200);
        }
    }

            public function manageTeam(Request $request)
    {
        return $this->repository->manageTeam($request);
    }
         Route::match(['get', 'post'], 'assignment/team/manage', [AssignmentController::class, 'manageTeam'])->name('assignment.manageTeam');
                     @if (isSuperAdmin())
                 <button class="btn btn-sm btn-primary actionHandler"
                     data-url="{{ route('admin.assignment.manageTeam', ['assignmentId' => $cycle->id]) }}">Add
                     Team</button>
             @endif
        //* regarding 
          public function reportedit(Request $request, $uuid)
    {
        // Handle GET request (show form)
        if ($request->isMethod('get')) {
            $report = ProjectReport::uuid($uuid)->first();

            if (!$report) {
                abort(404, 'Report not found');
            }

            return view('assignment._partials.report_form', compact('report'));
        }

        // Handle POST request (update report)
        if ($request->isMethod('post')) {
            $report = ProjectReport::uuid($uuid)->first();

            if (!$report) {
                return response()->json([
                    'status' => '404',
                    'msg' => 'Report not found',
                ], 404);
            }

            // Check for duplicate report name in same project & organization
            $duplicate = ProjectReport::where('report_name', $request->report_name)
                ->where('project_id', $report->project_id)
                ->where('organization_id', $report->organization_id)
                ->where('id', '!=', $report->id)
                ->exists();

            if ($duplicate) {
                return response()->json([
                    'status' => '500',
                    'msg' => 'Another report with the same name already exists.',
                ], 500);
            }

            // Track old data
            $oldData = $report->replicate();
            $oldAttachment = $report->attachment;

            // Update data array
            $data = [
                'report_name' => $request->report_name,
                'report_type' => $request->report_type,
                'updated_by' => auth()->id(),
            ];

            // Check for file upload
            if ($request->hasFile('attachment')) {
                $storageDisk = getStorageDisk();
                $driver = $storageDisk == "local" ? 'local' : 's3';
                $file = $request->file('attachment');
                $filename = uniqid() . '.' . $file->getClientOriginalExtension();

                if ($driver == 'local') {
                    $newAttachmentPath = asset(uploadFile($file, 'uploads/attachment/'));
                } else {
                    $newAttachmentPath = uploadToS3($file, 'uploads/attachment/', $filename);
                }

                $data['attachment'] = $newAttachmentPath;

                // Log the uploaded file
                DB::table('project_report_logs')->insert([
                    'project_report_id' => $report->id,
                    'version' => $request->report_type,
                    'attachment' => $newAttachmentPath,
                    'uploaded_by' => auth()->id(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Apply changes
            $report->fill($data);
            $saved = $report->save();

            if (!$saved) {
                return response()->json([
                    'status' => '500',
                    'msg' => 'Something went wrong while saving the report.',
                ], 500);
            }

            // Generate comment and log
            $commentText = $this->generateAuditChangeComment($oldData, $data);
            // dd($commentText);
            $report->synchronizeLog([
                'event' => 'Report',
                'comment' => "Report updated to: (" . $commentText . ")",
                'logged_by' => authUser()->id,
            ]);

            return response()->json([
                'status' => '200',
                'msg' => 'Updated Successfully',
                'jsFunction' => 'reloadTable',
                'oldAttachment' => $oldAttachment,
                'newAttachment' => $report->attachment,
            ], 200);
        }
    }
           12 => 
App\Models
\
ProjectReport
 {#3112 ▼
      #connection: "mysql"
      #table: "project_reports"
      #primaryKey: "id"
      #keyType: "int"
      +incrementing: true
      #with: []
      #withCount: []
      +preventsLazyLoading: false
      #perPage: 15
      +exists: true
      +wasRecentlyCreated: false
      #escapeWhenCastingToString: false
      #attributes: array:13 [▼
        "id" => 87
        "uuid" => "ada7b386-6414-42d0-9dd5-dba270a82574"
        "report_name" => "ahahha"
        "report_type" => "Final"
        "attachment" => "http://127.0.0.1:8000/admin/testfolder/69afb9d1f338b.pptx"
        "attachment_json" => "["http:\/\/127.0.0.1:8000\/admin\/testfolder\/69afb9d1f338b.pptx"]"
        "attachmentjson_count" => 1
        "project_id" => 205
        "created_by" => 154
        "organization_id" => 23
        "updated_by" => null
        "created_at" => "2026-03-10 11:57:29"
        "updated_at" => "2026-03-10 11:57:29"
      ]
      #original: array:13 [▶]
      #changes: []
      #casts: []
      #classCastCache: []
      #attributeCastCache: []
      #dates: []
      #dateFormat: null
      #appends: []
      #dispatchesEvents: []
      #observables: []
      #relations: array:1 [▶]
      #touches: []
      +timestamps: true
      #hidden: []
      #visible: []
      #fillable: []
      #guarded: array:1 [▶]
    }
    13 => 
App\Models
\
ProjectReport
 {#3113 ▼
      #connection: "mysql"
      #table: "project_reports"
      #primaryKey: "id"
      #keyType: "int"
      +incrementing: true
      #with: []
      #withCount: []
      +preventsLazyLoading: false
      #perPage: 15
      +exists: true
      +wasRecentlyCreated: false
      #escapeWhenCastingToString: false
      #attributes: array:13 [▼
        "id" => 88
        "uuid" => "411ed21c-16d8-4db0-96b8-6e7ff1c9b651"
        "report_name" => "hhhh"
        "report_type" => "Final"
        "attachment" => "http://127.0.0.1:8000/admin/testfolder/69afba427c913.pptx"
        "attachment_json" => "["http:\/\/127.0.0.1:8000\/admin\/testfolder\/69afba427c913.pptx","http:\/\/127.0.0.1:8000\/admin\/testfolder\/69afba427e59b.pptx"]"
        "attachmentjson_count" => 2
        "project_id" => 205
        "created_by" => 154
        "organization_id" => 23
        "updated_by" => null
        "created_at" => "2026-03-10 11:59:22"
        "updated_at" => "2026-03-10 11:59:22"
      ]
      #original: array:13 [▶]
      #changes: []
      #casts: []
      #classCastCache: []
      #attributeCastCache: []
      #dates: []
      #dateFormat: null
      #appends: []
      #dispatchesEvents: []
      #observables: []
      #relations: array:1 [▶]
      #touches: []
      +timestamps: true
      #hidden: []
      #visible: []
      #fillable: []
      #guarded: array:1 [▶]
    }
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = html_entity_decode($value, ENT_QUOTES, 'UTF-8');
    }

    public function setReportNameAttribute($value)
    {
        $this->attributes['report_name'] = html_entity_decode($value, ENT_QUOTES, 'UTF-8');
    }
        //* regarding 
        
        //* regarding 
         public function reportstore($request)
    {
        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'attachment' => 'required|array',
                    'attachment.*' => [
                        'file',
                        'max:102400',
                        new FileTypeRule([
                            'application/pdf',
                            'application/msword',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                            'application/vnd.ms-excel',
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            'application/vnd.ms-powerpoint',
                            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                            'application/zip',
                        ])
                    ],
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'status' => '400',
                    'errors' => $validator->errors(),
                ], 400);
            }
            $reportExists = ProjectReport::where([
                'report_name' => $request->report_name,
                'project_id' => $request->project_id,
                'organization_id' => organizationId(),
            ])->exists();

            if ($reportExists) {
                return response()->json([
                    'status' => '500',
                    'msg' => 'Report name already exists.',
                ], 500);
            }
            $data = [
                'uuid' => (string) Uuid::uuid4(),
                'report_name' => $request->report_name,
                'project_id' => $request->project_id,
                'report_type' => $request->report_type,
                'organization_id' => organizationId(),
                'created_by' => authUser()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];


            // if ($request->hasFile('attachment')) {

            //     $storageDisk = getStorageDisk();
            //     $driver = $storageDisk == "local" ? 'local' : 's3';

            //     $paths = [];

            //     foreach ($request->file('attachment') as $file) {

            //         $filename = uniqid() . '.' . $file->getClientOriginalExtension();

            //         if ($driver == 'local') {
            //             $path = asset(uploadFile($file, 'uploads/attachment/'));
            //         } else {
            //             $path = uploadToS3($file, 'uploads/attachment/', $filename);
            //         }

            //         $paths[] = $path;
            //     }

            //     $data['attachment'] = $paths[0] ?? null; // first file
            //     $data['attachment_json'] = json_encode($paths); // all files
            // }

            if ($request->hasFile('attachment')) {
                $paths = [];
                foreach ($request->file('attachment') as $file) {
                    $filename = uniqid() . '.' . $file->getClientOriginalExtension();
                    // public folder
                    $destinationPath = public_path('admin/testfolder');
                    $file->move($destinationPath, $filename);
                    $paths[] = asset('admin/testfolder/' . $filename);
                }

                if (!empty($paths)) {
                    $data['attachment'] = $paths[0];
                    $data['attachment_json'] = json_encode($paths);
                }
            }

            // dd($paths);

            $created = ProjectReport::create($data);
            // Create a log or backup of the upload (for version history)
            if ($created && isset($data['attachment'])) {
                DB::table('project_report_logs')->insert([
                    'project_report_id' => $created->id,
                    'version' => $created->report_type,
                    // 'attachment' => $data['attachment'],
                    'attachment' => 'hi shahid',
                    'attachment_json' => $data['attachment_json'],
                    'uploaded_by' => authUser()->id,
                    'created_at' => now()
                ]);
            }

            dd('done');

            if ($created) {
                $created->synchronizeLog([
                    'event' => 'Report',
                    'comment' => "Report Created",
                    'logged_by' => authUser()->id,
                ]);
                return response()->json([
                    'status' => '200',
                    'msg' => 'Created Successfully',
                    'redirect' => url()->previous(),
                ], 200);
            } else {
                return response()->json([
                    'status' => '500',
                    'msg' => 'Failed to create report'
                ], 500);
            }
        } catch (Throwable $th) {
            return response()->json([
                'status' => '500',
                'msg' => 'Something went wrong',
                'exception' => $th->getMessage(),
                'trace' => $th->getTrace(),
            ], 500);
        }
    }
        //* regarding 
        array:9 [ // app\Http\Controllers\Admin\Assignment\AssignmentRepository.php:1741
  "uuid" => "1c9da2a8-13ac-4d05-9c67-af526ba54e5a"
  "report_name" => "shahid"
  "project_id" => "205"
  "report_type" => "Final"
  "organization_id" => 23
  "created_by" => 154
  "created_at" => 
Illuminate\Support
\
Carbon @1773121726
 {#2466
    #endOfTime: false
    #startOfTime: false
    #constructedObjectId: "00000000000009a20000000000000000"
    #localMonthsOverflow: null
    #localYearsOverflow: null
    #localStrictModeEnabled: null
    #localHumanDiffOptions: null
    #localToStringFormat: null
    #localSerializer: null
    #localMacros: null
    #localGenericMacros: null
    #localFormatFunction: null
    #localTranslator: null
    #dumpProperties: array:3 [
      0 => "date"
      1 => "timezone_type"
      2 => "timezone"
    ]
    #dumpLocale: null
    #dumpDateProperties: null
    date: 2026-03-10 11:18:46.448947 Asia/Kolkata (+05:30)
  }
  "updated_at" => 
Illuminate\Support
\
Carbon @1773121726
 {#2510
    #endOfTime: false
    #startOfTime: false
    #constructedObjectId: "00000000000009ce0000000000000000"
    #localMonthsOverflow: null
    #localYearsOverflow: null
    #localStrictModeEnabled: null
    #localHumanDiffOptions: null
    #localToStringFormat: null
    #localSerializer: null
    #localMacros: null
    #localGenericMacros: null
    #localFormatFunction: null
    #localTranslator: null
    #dumpProperties: array:3 [
      0 => "date"
      1 => "timezone_type"
      2 => "timezone"
    ]
    #dumpLocale: null
    #dumpDateProperties: null
    date: 2026-03-10 11:18:46.448959 Asia/Kolkata (+05:30)
  }
  "attachment" => "[false,false]"
]
        //* regarding 
         'title' => html_entity_decode($validatedData['assignment_name']),
         
         'name' => html_entity_decode($control->title),

         'name' => html_entity_decode($control->title),
         'name' => html_entity_decode($request->task_name[$index]),

           'name' => html_entity_decode($request->task_name[$index]),

           $title = html_entity_decode($title);
               public function setTitleAttribute($value)
    {
        $this->attributes['title'] = html_entity_decode($value, ENT_QUOTES, 'UTF-8');
    }
        //* regarding 
              $request->validate([
        'reason' => 'required',
        'file' => 'nullable|mimes:png,pdf,jpeg,jpg|max:5120',
      ], [
        'file.max' => 'The file may not be greater than 5 MB.',
      ]);
        //* regarding 
        [140]
          ->editColumn('user_responsible_id', function ($row) {
                                $userResponsible = $row->user_responsible->name ?? '';
                                $avatar = asset($row->user_responsible->avatar ?? 'admin/assets/images/user.jpg');
                                $url = route('admin.observation.bulkupdate', [
                                    'type' => 'individual',
                                    'userType' => 'responsible',
                                    'data-record-id' => $row->id,
                                ]);

                                return ' <div class="d-flex align-items-center"> <div class="avatar-xxs actionHandler me-1"
                                data-url="' . $url . '" data-handler="bulkUpdate" data-record-id="' . $row->id . '">
                                <img class="border-primary rounded-circle img-fluid border" style="width: 22px; height: 22px;"
                                src="' . $avatar . '" title="" alt=""></div>
                                <span class="me-2">' . $userResponsible . '</span></div>';
                            })



                            <div class="col-3 mb-2 px-1">
                                <div class="vikalp-x" data-multiple="true" data-placeholder="--Select User Resposnible--">
                                    <select name="user_id[]" id="user_id" multiple data-filter="user_id"
                                        class="datatable-filter"></select>
                                    <button class="btn btn-light dropdown-toggle vikalp-input" type="button"
                                        data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                        --Select user Responsible--
                                    </button>
                                    <ul class="dropdown-menu w-100">
                                        <li class="p-2">
                                            <input type="text" class="form-control vikalp-search" placeholder="Search...">
                                        </li>
                                        @foreach ($users as $user)
                                            <li class="vikalp-option"><input type="checkbox" class="vikalp-checkbox"
                                                    id=""><a class="dropdown-item" href="#"
                                                    data-value="{{ $user->id }}">{{ $user->name }}</a>
                                            </li>
                                        @endforeach

                                    </ul>
                                </div>

                            </div>

                            resources\views\observation\bulkupdate.blade.php


                              public function bulkUpdate($request)
    {
        $type = $request->input('type');
        $userType = $request->input('userType');
        $byPassPermission = $request->boolean('byPassPermission'); // ret
        if (!$byPassPermission && !hasModuleAccess(['ATR', 'Observations'])) {
            abort(403, 'Access Denied');
        }
        if ($request->isMethod('GET')) {
            // Fetch active users by organization who are not admins
            $invitedUsers = getInvitedUsers();
            $users = User::ByOrganization()->active()->get();
            $users = $users->merge($invitedUsers);
            $reviewer = $users;
            return view('observation.bulkupdate', compact('users', 'reviewer', 'type', 'userType', 'byPassPermission'));
        }

        if ($request->isMethod('POST')) {
            $userResponsible = $request->input('user_responsible');
            $userReviewer = $request->input('user_reviewer');
            $status = $request->input('status');
            $dataIds = $request->input('data_ids', []);
            // dd($dataIds);
            // Validate input
            if (empty($dataIds)) {
                return response()->json(['status' => '200', 'msg' => 'No IDs selected'], 200);
            }

            // Fetch existing records to compare
            $observations = DB::table('observations')->whereIn('id', $dataIds)->get();

            if ($observations->isEmpty()) {
                return response()->json(['status' => '400', 'msg' => 'No records found'], 400);
            }

            foreach ($observations as $observation) {
                $oldResponsible = $observation->user_responsible_id;
                $oldReviewer = $observation->reviewer_responsible_id;

                // Prepare the update data array
                $updateData = [];
                if (!is_null($userResponsible)) {
                    $updateData['user_responsible_id'] = $userResponsible;
                }
                if (!is_null($userReviewer)) {
                    $updateData['reviewer_responsible_id'] = $userReviewer;
                }

                if (!empty($status)) {
                    $updateData['status'] = $status;
                }
                // Perform the update if there are fields to update
                if (!empty($updateData)) {
                    $updated = DB::table('observations')
                        ->where('id', $observation->id)
                        ->update($updateData);

                    if ($updated) {
                        // Initialize log details array
                        $logDetails = [];

                        // Handle user_responsible_id change
                        if (isset($updateData['user_responsible_id']) && $updateData['user_responsible_id'] != $oldResponsible) {
                            $oldResponsibleName = $oldResponsible ? User::find($oldResponsible)->name : 'N/A';
                            $newResponsibleName = User::find($updateData['user_responsible_id'])->name ?? 'N/A';
                            $logDetails[] = 'User Responsible changed from ' . $oldResponsibleName . ' to ' . $newResponsibleName;
                        }

                        // Handle reviewer_responsible_id change
                        if (isset($updateData['reviewer_responsible_id']) && $updateData['reviewer_responsible_id'] != $oldReviewer) {
                            $oldReviewerName = $oldReviewer ? User::find($oldReviewer)->name : 'N/A';
                            $newReviewerName = User::find($updateData['reviewer_responsible_id'])->name ?? 'N/A';
                            $logDetails[] = 'Reviewer Responsible changed from ' . $oldReviewerName . ' to ' . $newReviewerName;
                        }

                        // Handle status change
                        if (isset($updateData['status']) && $updateData['status'] != $observation->status) {
                            $logDetails[] = 'Status changed from ' . $this->statusColorMap[$observation->status]['text'] . ' to ' . $this->statusColorMap[$updateData['status']]['text'];
                        }

                        // Log the changes
                        if (!empty($logDetails)) {
                            DB::table('observation_logs')->insert([
                                'observation_id' => $observation->id,
                                'event' => 'Bulk Update',
                                'comment' => implode('; ', $logDetails),
                                'logged_by' => auth()->user()->id,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                        }
                    }
                }
            }

            return response()->json([
                'status' => '200',
                'msg' => 'Updated Successfully',
                'jsFunction' => 'resetSelection'
            ], 200);
        }
    }

        "" // app\Http\Controllers\Admin\Observation\ObservationRepository.php:328
"http://127.0.0.1:8000/admin/get/observation/bulkupdate?type=individual&userType=responsible&data-record-id=1011" // app\Http\Controllers\Admin\Observation\ObservationRepository.php:328
1011 // app\Http\Controllers\Admin\Observation\ObservationRepository.php:328
"http://127.0.0.1:8000/admin/assets/images/user.jpg" // app\Http\Controllers\Admin\Observation\ObservationRepository.php:328
44 // app\Http\Controllers\Admin\Observation\ObservationRepository.php:328


            if (auth()->user()->role_id == 13) {

      $selectedDate = Carbon::createFromFormat('d-m-Y', $request->selected_date)->format('Y-m-d');

      $clientdata = DB::table('clients')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.client_id', '=', 'clients.id')
        ->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', '=', 'assignmentbudgetings.assignmentgenerate_id')
        ->leftJoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
        ->where('assignmentbudgetings.status', 1)
        ->where(function ($query) {
          $query->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
            ->orWhere('assignmentmappings.otherpartner', auth()->user()->teammember_id)
            ->orWhere('assignmentteammappings.teammember_id', auth()->user()->teammember_id);
        })
        ->where(function ($query) use ($selectedDate) {
          $query->whereNull('assignmentbudgetings.otpverifydate')
            // ->orWhere('assignmentbudgetings.otpverifydate', '>=', $selectedDate->modify('-1 day'));
            ->orWhereDate('assignmentbudgetings.otpverifydate', '>=', $selectedDate);
        })
        ->select('clients.client_name', 'clients.id', 'clients.client_code')
        ->distinct()
        ->orderBy('clients.client_name', 'ASC')
        ->get();

      $clientIds = [29, 32, 33, 34];

      $clients = DB::table('clients')
        ->whereIn('id', $clientIds)
        ->select('clients.client_name', 'clients.id', 'clients.client_code')
        ->orderBy('client_name', 'ASC')
        ->distinct()
        ->get();

      $clientss = $clientdata->merge($clients);

      return response()->json($clientss);
    }

    return response()->json([]);

         $selectedDate = \DateTime::createFromFormat('d-m-Y', $request->datepickers);
            $test = DB::table('assignmentbudgetings')
              ->select(
                'assignmentbudgetings.assignmentgenerate_id',
                'assignments.assignment_name',
                'assignmentbudgetings.assignmentname'
              )
              ->where('assignmentbudgetings.client_id', $request->cid)
              ->leftJoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
              ->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
              ->leftJoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
              ->where(function ($query) {
                $query->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
                  ->orWhere('assignmentmappings.otherpartner', auth()->user()->teammember_id)
                  ->orWhere('assignmentteammappings.teammember_id', auth()->user()->teammember_id);
              })
              ->where(function ($query) use ($selectedDate) {
                $query->whereNull('otpverifydate')
                  ->orWhere('otpverifydate', '>=', $selectedDate->modify('-1 day'));
              })
              ->orderBy('assignment_name')
              ->distinct() // Ensure unique rows
              ->get();

            dd($selectedDate, $test);


            Select Assignment
            
DateTime @1768215924 {#3792
  date: 2026-01-12 16:35:24.0 Asia/Kolkata (+05:30)
}
Illuminate\Support\Collection {#3828
  #items: array:7 [
    0 => {#3817
      +"assignmentgenerate_id": "BAN101037"
      +"assignment_name": "AS  ( Statutory Audit )"
      +"assignmentname": "Finalisation F.Y.2024-25"
    }
    1 => {#3821
      +"assignmentgenerate_id": "BAN100901"
      +"assignment_name": "Limited Review"
      +"assignmentname": """
        Q3  
         F.Y.2024-25
        """
    }
    2 => {#3822
      +"assignmentgenerate_id": "BAN101340"
      +"assignment_name": "Limited Review"
      +"assignmentname": "LR Q3,F.Y.2025-26"
    }
    3 => {#3824
      +"assignmentgenerate_id": "BAN101159"
      +"assignment_name": "Limited Review"
      +"assignmentname": "Bandhan Bank LR Q1 25-26"
    }
    4 => {#3823
      +"assignmentgenerate_id": "BAN100842"
      +"assignment_name": "Limited Review"
      +"assignmentname": "Limited Review Q2 24-25"
    }
    5 => {#3818
      +"assignmentgenerate_id": "BAN101276"
      +"assignment_name": "Limited Review"
      +"assignmentname": "LR Q2,F.Y.2025-26"
    }
    6 => {#3820
      +"assignmentgenerate_id": "BAN100915"
      +"assignment_name": "Special Assignment"
      +"assignmentname": "Branch Visit 2024-25"
    }
  ]
  #escapeWhenCastingToString: false
}

array:2 [▼
  0 => {#3629 ▼
    +"id": 96158
    +"teammember_id": 187
    +"checkin_from": "Client Place"
    +"month": null
    +"typeval": null
    +"client_id": 395
    +"assignment_id": 804974128414
    +"company_name": null
    +"partner": null
    +"place": null
    +"date": "03-01-2026"
    +"time": "11:56:13"
    +"checkout_time": null
    +"checkin_status": null
    +"latitude": 28.6062
    +"longitude": 77.3663
    +"device_id": "vineetjain@kgsomani.com"
    +"created_at": "2026-02-11 12:25:11"
    +"updated_at": "2026-01-03 11:19:40"
    +"client_name": "Dharampal Premchand Limited-Noida"
    +"assignment_name": "GST AUDIT CHECKLIST"
    +"team_member": "Lalit Mohar"
    +"leadpartner": 13
  }
  1 => {#3625 ▼
    +"id": 96159
    +"teammember_id": 187
    +"checkin_from": "Client Place"
    +"month": null
    +"typeval": null
    +"client_id": 395
    +"assignment_id": 804974128414
    +"company_name": null
    +"partner": null
    +"place": null
    +"date": "02-02-2026"
    +"time": "11:56:13"
    +"checkout_time": null
    +"checkin_status": null
    +"latitude": 28.6062
    +"longitude": 77.3663
    +"device_id": "vineetjain@kgsomani.com"
    +"created_at": "2026-02-11 12:25:11"
    +"updated_at": "2026-02-02 11:19:40"
    +"client_name": "Dharampal Premchand Limited-Noida"
    +"assignment_name": "GST AUDIT CHECKLIST"
    +"team_member": "Lalit Mohar"
    +"leadpartner": 13
  }
]
        //* regarding 
        Illuminate\Http\Request {#44 ▼
  +attributes: Symfony\Component\HttpFoundation\ParameterBag {#46 ▶}
  +request: Symfony\Component\HttpFoundation\InputBag {#45 ▼
    #parameters: array:4 [▼
      "_token" => "qr8VWJ18aDO8yn9i9FEcnqSAwC6OHaLrgPn5fixm"
      "yearly" => "2025-2026"
      "months" => "2"
      "partner" => "13"
    ]
  }
        

         $timesheetData = $this->promotionOrRejoined($timesheetData);

           private function promotionOrRejoined($timesheetData)
  {
    $targetClients = [29, 34, 32, 33, 134];
    return $timesheetData->map(function ($row) use ($targetClients) {

      if (in_array($row->client_id, $targetClients)) {
        $timesheetDate = $row->date
          ? Carbon::parse($row->date)->endOfDay()
          : null;
        $row->final_teamstaffcode = $this->getStaffCodeAt($row->createdby, $timesheetDate);
        $row->final_partnerstaffcode = $this->getStaffCodeAt($row->partner, $timesheetDate);
      } else {
        // $row->final_teamstaffcode = $this->getStaffCodeAt($row->createdby, $row->assignmentcreated);
        // $row->final_partnerstaffcode = $this->getStaffCodeAt($row->partner, $row->assignmentcreated);

        $dateCheck = $row->assignmentcreated
          ? $row->assignmentcreated
          : Carbon::parse($row->date)->endOfDay();

        $row->final_teamstaffcode = $this->getStaffCodeAt($row->createdby, $dateCheck);
        $row->final_partnerstaffcode = $this->getStaffCodeAt($row->partner, $dateCheck);
      }

      return $row;
    });
  }
        
        //* regarding
        
        
                                <a href="{{ url('totalworkingdays', auth()->user()->teammember_id) }}">
                            <div style="color:white;"
                                class="opacity-50 header-pretitle fs-11 font-weight-bold text-uppercase">Total Working Days
                            </div>
                            <div style="color:white;" class="fs-32 text-monospace">{{ $totalworkingdays ?? '0' }}
                            </div>
                            <small style="color:white;">Days ( January to {{ $currentMonth }} )</small>
                        </a>
         <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">

            <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
                <li class="breadcrumb-item">
                    <div class="btn-group mb-2 mr-1">
                        @php
                            $selectedYear = Request::query('year');
                            if ($selectedYear == null) {
                                $selectedYear = $currentYear;
                            } else {
                                $selectedYear = Request::query('year');
                            }
                        @endphp
                        <button type="button" class="btn btn-info-soft btn-sm dropdown-toggle" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            @if (in_array($selectedYear, $years))
                                {{ $selectedYear }}
                            @else
                                Choose Year
                            @endif
                        </button>
                        <div class="dropdown-menu">
                            @foreach ($years as $year)
                                <a style="color: #37A000" class="dropdown-item"
                                    href="{{ url('/holidays?year=' . $year) }}">{{ $year }}</a>
                            @endforeach
                        </div>
                    </div>
                </li>
                @if (Auth::user()->role_id == 18)
                    <li class="breadcrumb-item"><a href="{{ url('holiday/create') }}">Add Holidays</a></li>
                    <li class="breadcrumb-item active">+</li>
                @endif
            </ol>

        </nav>
            
           $currentDate = Carbon::now();
        $tillyearend = $currentDate->year;
        $oldyearstart = 2023;
        $years = range($tillyearend, $oldyearstart);

        dd($years,  $tillyearend,  $oldyearstart);
          // All teammember data 
        $mainQuery = DB::table('assignmentmappings')
            ->join('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
            ->join('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
            ->join('teammembers', 'teammembers.id', '=', 'assignmentteammappings.teammember_id')
            ->join('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
            ->join('clients', 'clients.id', 'assignmentbudgetings.client_id')
            ->whereIn('assignmentmappings.assignmentgenerate_id', $assignmentgenerateid)
            ->select(
                'teammembers.id as teammember_id',
                'teammembers.staffcode',
                'teammembers.team_member',
                'assignmentmappings.assignmentgenerate_id',
                'assignmentmappings.created_at',
                'clients.client_name',
                'clients.client_code',
                'assignments.assignment_name',
                'assignmentbudgetings.assignmentname',
            );

        // Lead partner data  
        $leadPartnerQuery = DB::table('assignmentmappings')
            ->join('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
            ->join('teammembers', 'teammembers.id', '=', 'assignmentmappings.leadpartner')
            ->join('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
            ->join('clients', 'clients.id', 'assignmentbudgetings.client_id')
            ->whereIn('assignmentmappings.assignmentgenerate_id', $assignmentgenerateid)
            ->select(
                'teammembers.id as teammember_id',
                'teammembers.id as teammember_id',
                'teammembers.staffcode',
                'teammembers.team_member',
                'assignmentmappings.assignmentgenerate_id',
                'assignmentmappings.created_at',
                'clients.client_name',
                'clients.client_code',
                'assignments.assignment_name',
                'assignmentbudgetings.assignmentname',
            );

        // other partner data 
        $otherPartnerQuery = DB::table('assignmentmappings')
            ->join('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
            ->join('teammembers', 'teammembers.id', '=', 'assignmentmappings.otherpartner')
            ->join('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
            ->join('clients', 'clients.id', 'assignmentbudgetings.client_id')
            ->whereIn('assignmentmappings.assignmentgenerate_id', $assignmentgenerateid)
            ->select(
                'teammembers.id as teammember_id',
                'teammembers.staffcode',
                'teammembers.team_member',
                'assignmentmappings.assignmentgenerate_id',
                'assignmentmappings.created_at',
                'clients.client_name',
                'clients.client_code',
                'assignments.assignment_name',
                'assignmentbudgetings.assignmentname',
            );

        // Merging hare all data 
        $independence = $mainQuery
            ->union($leadPartnerQuery)
            ->union($otherPartnerQuery)
            ->limit(10)
            ->get();
        //* regarding 
Illuminate\Support\Collection {#3726 ▼
  #items: array:2212 [▶]
  #escapeWhenCastingToString: false
}


Illuminate\Support\Collection {#3730 ▼
  #items: array:1509 [▶]
  #escapeWhenCastingToString: false
}
Illuminate\Support\Collection {#5251 ▼
  #items: array:468 [▶]
  #escapeWhenCastingToString: false
}
Illuminate\Support\Collection {#5724 ▼
  #items: array:235 [▶]
  #escapeWhenCastingToString: false
}
        //* regarding 
         // if ($request->leavetype == 9) {
          //   DB::table('timesheetusers')->where('id', $rejectedtimesheet->id)->update([
          //     'status'   => 3,
          //     'client_id'     =>    134,
          //     'workitem'     =>     $request->reasonleave,
          //     'assignmentgenerate_id' => null,
          //     'location'     =>     'NA',
          //     'hour'     =>     0,
          //     'totalhour' =>      0,
          //     'assignment_id'     =>     215,
          //     'partner'     =>   $request->approver,
          //   ]);
          // } elseif ($request->leavetype == 15) {
          //   DB::table('timesheetusers')->where('id', $rejectedtimesheet->id)->update([
          //     'status'   => 3,
          //     'client_id'     =>    134,
          //     'workitem'     =>     $request->reasonleave,
          //     'assignmentgenerate_id' => null,
          //     'location'     =>     'NA',
          //     'hour'     =>     0,
          //     'totalhour' =>      0,
          //     'assignment_id'     =>     222,
          //     'partner'     =>   $request->approver,
          //   ]);
          // } else {
          //   DB::table('timesheetusers')->where('id', $rejectedtimesheet->id)->update([
          //     'status'   => 3,
          //     'client_id'     =>    134,
          //     'assignmentgenerate_id' => null,
          //     'workitem'     =>     $request->reasonleave,
          //     'location'     =>     'NA',
          //     'hour'     =>     0,
          //     'totalhour' =>      0,
          //     'assignment_id'     =>     214,
          //     'partner'     =>    $request->approver,
          //   ]);
          // }
        //* regarding
        
           $teamleader = DB::table('assignmentteammappings')
                    ->where('assignmentmapping_id', $id)
                    ->leftJoin('teammembers', 'teammembers.id', '=', 'assignmentteammappings.teammember_id')
                    ->leftJoinSub($latestHistory, 'latestrecord', function ($join) {
                        $join->on('latestrecord.teammember_id', '=', 'teammembers.id');
                    })
                    ->select('teammembers.team_member', 'teammembers.staffcode', 'latestrecord.newstaff_code')
                    ->get();

         $latestHistory = DB::table('teamrolehistory as teamrolehistorydata')
        ->select('teamrolehistorydata.teammember_id', 'teamrolehistorydata.newstaff_code')
        ->whereRaw('teamrolehistorydata.id = (SELECT MAX(teamrolehistorylatest.id) FROM teamrolehistory as teamrolehistorylatest WHERE teamrolehistorylatest.teammember_id = teamrolehistorydata.teammember_id)');

      $teammembername = DB::table('teammembers')
        ->leftJoinSub($latestHistory, 'latestrecord', function ($join) {
          $join->on('latestrecord.teammember_id', '=', 'teammembers.id');
        })
        ->where('teammembers.id', auth()->user()->teammember_id)
        ->select('teammembers.*', 'latestrecord.newstaff_code')
        ->first();
       
         public function adminteammembers()
    {
        if (auth()->user()->role_id == 11) {
            $latestHistory = DB::table('teamrolehistory as teamrolehistorydata')
                ->select('teamrolehistorydata.teammember_id', 'teamrolehistorydata.newstaff_code')
                ->whereRaw('teamrolehistorydata.id = (SELECT MAX(teamrolehistorylatest.id) FROM teamrolehistory as teamrolehistorylatest WHERE teamrolehistorylatest.teammember_id = teamrolehistorydata.teammember_id)');

            $teammemberDatas = Teammember::with(['title', 'role'])
                ->leftJoinSub($latestHistory, 'latestrecord', function ($join) {
                    $join->on('latestrecord.teammember_id', '=', 'teammembers.id');
                })
                ->where('teammembers.role_id', '!=', 11)
                ->where('teammembers.status', 1)
                ->select('teammembers.*', 'latestrecord.newstaff_code')
                ->get();

            return view('backEnd.teammember.allindex', compact('teammemberDatas'));
        }
    }
    $teamemailpartner = DB::table('teammembers')
                    ->leftJoinSub($latestHistory, 'latestrecord', function ($join) {
                        $join->on('latestrecord.teammember_id', '=', 'teammembers.id');
                    })
                    ->where('teammembers.id', $request->leadpartner)
                    ->select('teammembers.emailid', 'teammembers.team_member', 'teammembers.staffcode', 'latestrecord.newstaff_code')
                    ->first();
    
        //* regarding
        {#3698
  +"assignmentgenerate_id": 816577899434
  +"mapping_id": 21
  +"assignmentname": null
  +"assignment_name": "Division 1 Balance sheet"
  +"client_name": "TRIFED"
  +"periodstartdate": null
  +"periodenddate": null
  +"leadpartner_name": "Ashish Kumar Batta"
  +"otherpartner_name": null
  +"assignment_status": "OPEN"
  +"eqcrapplicability": null
} 



{#3696
  +"id": 21
  +"assignmentgenerate_id": 816577899434
  +"assignment_id": 38
  +"independenceform": null
  +"leadpartner": 45
  +"otherpartner": null
  +"created_at": "2021-04-12 05:30:00"
  +"updated_at": "2021-04-12 05:30:00"
  +"periodend": null
  +"periodstart": null
  +"year": "2020"
  +"location": null
  +"fees": null
  +"gst": null
  +"gstcost": null
  +"roleassignment": 1
  +"esthours": "1000"
  +"stdcost": "22500"
  +"estcost": null
  +"teamestcost": null
  +"pocketexpenses": null
  +"filecreationdate": null
  +"modifieddate": null
  +"auditcompletiondate": null
  +"documentationdate": null
  +"profit": null
  +"audittypecag": null
  +"partneresthour": null
  +"partnerestcost": null
  +"otherpartneresthour": null
  +"otherpartnerestcost": null
  +"totalstaffcount": null
  +"reasonforstaffcount": null
  +"auditassignment": null
  +"natureofassignment": null
  +"eqcrapplicability": null
  +"eqcrpartner": null
  +"currency": null
  +"amount": null
  +"engagementfee": null
  +"revenuefy": null
  +"revenuefromoperations": null
  +"otherrevenue": null
  +"totalturnover": null
  +"networthfy": null
  +"networth": null
  +"borrowingsfy": null
  +"borrowingsamt": null
  +"borrowingsotherfy": null
  +"borrowingsother": null
  +"paidupfy": null
  +"paidupcapitall": null
  +"cmpnystatus": null
  +"cmpnystatusname": null
  +"cmpnystatuschange": null
  +"sectorcompany": null
  +"eqcresthour": null
  +"eqcrestcost": null
  +"duedate": "2020-02-29"
  +"draftreportdate": "2020-01-15"
  +"assignmentbudgetingsstatus": 1
  +"finalreportdate": "2020-01-20"
  +"moneyreceiveddate": "2021-02-28"
  +"assignmentname": null
  +"assignment_name": "Division 1 Balance sheet"
  +"client_name": "TRIFED"
  +"leadpartner_name": "Ashish Kumar Batta"
  +"otherpartner_name": null
  +"eqcr_type_name": ""
  +"documentation_percentage": 0.0
  +"status_counts": array:6 [
    "NOT-APPLICABLE" => 0
    "SUBMITTED" => 0
    "OPEN" => 370
    "CLOSE" => 0
    "REVIEW-TL" => 0
    "TOTAL" => 459
  ]
  +"reviewer_status_counts": array:5 [
    "SUBMITTED" => 0
    "OPEN" => 0
    "CLOSE" => 0
    "REVIEW-TL" => 0
    "TOTAL" => 0
  ]
  +"reviewer_documentation_percentage": 0
  +"invoicedate": null
  +"sub_team_members": "Harpreet Singh (Staff)"
  +"reviewer_status": "N/A"
}
eqcrapplicability

        {#3736
  +"id": 21
  +"assignmentgenerate_id": 816577899434
  +"assignment_id": 38
  +"independenceform": null
  +"leadpartner": 45
  +"otherpartner": null
  +"created_at": "2021-04-12 05:30:00"
  +"updated_at": "2021-04-12 05:30:00"
  +"periodend": null
  +"periodstart": null
  +"year": "2020"
  +"location": null
  +"fees": null
  +"gst": null
  +"gstcost": null
  +"roleassignment": 1
  +"esthours": "1000"
  +"stdcost": "22500"
  +"estcost": null
  +"teamestcost": null
  +"pocketexpenses": null
  +"filecreationdate": null
  +"modifieddate": null
  +"auditcompletiondate": null
  +"documentationdate": null
  +"profit": null
  +"audittypecag": null
  +"partneresthour": null
  +"partnerestcost": null
  +"otherpartneresthour": null
  +"otherpartnerestcost": null
  +"totalstaffcount": null
  +"reasonforstaffcount": null
  +"auditassignment": null
  +"natureofassignment": null
  +"eqcrapplicability": null
  +"eqcrpartner": null
  +"currency": null
  +"amount": null
  +"engagementfee": null
  +"revenuefy": null
  +"revenuefromoperations": null
  +"otherrevenue": null
  +"totalturnover": null
  +"networthfy": null
  +"networth": null
  +"borrowingsfy": null
  +"borrowingsamt": null
  +"borrowingsotherfy": null
  +"borrowingsother": null
  +"paidupfy": null
  +"paidupcapitall": null
  +"cmpnystatus": null
  +"cmpnystatusname": null
  +"cmpnystatuschange": null
  +"sectorcompany": null
  +"eqcresthour": null
  +"eqcrestcost": null
  +"duedate": "2020-02-29"
  +"draftreportdate": "2020-01-15"
  +"assignmentbudgetingsstatus": 1
  +"finalreportdate": "2020-01-20"
  +"moneyreceiveddate": "2021-02-28"
  +"assignmentname": null
  +"assignment_name": "Division 1 Balance sheet"
  +"client_name": "TRIFED"
  +"leadpartner_name": "Ashish Kumar Batta"
  +"otherpartner_name": null
  +"eqcr_type_name": ""
  +"documentation_percentage": 0.0
  +"status_counts": array:6 [
    "NOT-APPLICABLE" => 0
    "SUBMITTED" => 0
    "OPEN" => 370
    "CLOSE" => 0
    "REVIEW-TL" => 0
    "TOTAL" => 459
  ]
  +"reviewer_status_counts": array:5 [
    "SUBMITTED" => 0
    "OPEN" => 0
    "CLOSE" => 0
    "REVIEW-TL" => 0
    "TOTAL" => 0
  ]
  +"reviewer_documentation_percentage": 0
  +"invoicedate": null
  +"sub_team_members": "Harpreet Singh (Staff)"
  +"reviewer_status": "N/A"
}
        //* regarding 
         public function index()
  {
    $mentor_id = DB::table('teammembers')
      ->join('users', 'users.teammember_id', 'teammembers.id')
      ->where('users.teammember_id', auth()->user()->teammember_id)
      ->where('teammembers.status', '!=', 0)

      ->pluck('mentor_id')
      ->first();

    $mentee_id = DB::table('teammembers')
      ->join('users', 'users.teammember_id', 'teammembers.id')
      ->where('teammembers.mentor_id', auth()->user()->teammember_id)
      //->pluck('teammembers.id')
      ->where('teammembers.status', '!=', 0)

      ->get();

    //dd($mentee_id);
    $mentor = null;
    $mentees = null;

    if ($mentor_id != null) {
      $mentor = DB::table('teammembers')->where('id', $mentor_id)->where('status', '!=', 0)
        ->first();
    }

    if (count($mentee_id) != 0) {
      $mentees = $mentee_id;
    }

    // Set $mentees to null (if needed)
    if ($mentees == null) {
      $mentees = null;
    }

    $todayBirthdays = Teammember::whereNotNull('dateofbirth')
      ->where('status', '1')
      ->get()
      ->filter(function ($birthday) {
        $dateofbirth = Carbon::parse($birthday->dateofbirth);
        $currentDate = Carbon::now();

        // Compare the month and day without considering the current year
        return $dateofbirth->month == $currentDate->month && $dateofbirth->day == $currentDate->day;
      })
      ->sortBy('dateofbirth');

    $upcomingBirthdays = Teammember::where('status', '1')
      ->whereRaw('DATE_FORMAT(dateofbirth, "%m-%d") > DATE_FORMAT(NOW(), "%m-%d")')
      ->orderByRaw('DATE_FORMAT(dateofbirth, "%m-%d")')
      ->limit(7)
      ->get();



    $workAnniversaries = Teammember::whereNotNull('joining_date')
      ->where('status', '1')
      ->get()
      ->filter(function ($teammember) {
        $joiningDate = Carbon::parse($teammember->joining_date);
        $currentDate = Carbon::now();

        // Compare the month and day without considering the current year
        $isAnniversaryToday = $joiningDate->month == $currentDate->month && $joiningDate->day == $currentDate->day;

        // Exclude work anniversaries with a duration of 0 years
        $isNonZeroAnniversary = $joiningDate->diffInYears($currentDate) > 0;

        return $isAnniversaryToday && $isNonZeroAnniversary;
      })
      ->sortBy('joining_date')
      ->take(2);

    $upcomingHolidays = Holiday::where('startdate', '>', now()->format('Y-m-d'))
      ->where('status', 1)
      ->orderBy('startdate', 'asc')
      ->take(2)
      ->get();

    if (auth()->user()->role_id == 11 || auth()->user()->role_id == 12) {
      $authidd = Assignmentteammapping::where('teammember_id', auth()->user()->teammember_id)->select('assignmentmapping_id')->pluck('assignmentmapping_id')->first();
      $authid = auth()->user()->teammember_id;
      $notificationDatas =  DB::table('notifications')
        ->join('teammembers', 'teammembers.id', 'notifications.created_by')
        ->select(
          'notifications.*',
          'teammembers.profilepic',
          'teammembers.team_member'
        )->orderBy('created_at', 'desc')->paginate('2');
      // dd($notificationDatas);
      $client = Client::count();
      $teammember = Teammember::where('status', '1')->where('role_id', '!=', '11')->count();
      $userid = auth()->user()->role_id;
      $pageid = Permission::where('role_id', $userid)->select('page_id')->pluck('page_id')->first();
      $assetticket = DB::table('assettickets')
        ->leftjoin('teammembers', 'teammembers.id', 'assettickets.created_by')
        ->select('assettickets.*', 'teammembers.team_member')->orderBy('created_at', 'desc')->paginate(2);
      $assignment =  DB::table('assignmentbudgetings')
        ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->select(
          'assignmentbudgetings.*',
          'clients.client_name',
          'assignments.assignment_name'
        )->orderBy('assignmentbudgetings.created_at', 'desc')->take(3)->get();
      $assignmentcount = Assignmentmapping::count();
      $notification = Notification::count();
      return view('backEnd.index', compact('mentor', 'mentees', 'notification', 'assignmentcount', 'assignment', 'pageid', 'assetticket', 'client', 'teammember', 'notificationDatas', 'upcomingBirthdays', 'workAnniversaries', 'upcomingHolidays', 'todayBirthdays'));
    } elseif (auth()->user()->role_id == 13) {
      $authidd = Assignmentteammapping::where('teammember_id', auth()->user()->teammember_id)->select('assignmentmapping_id')->pluck('assignmentmapping_id')->first();
      $authid = auth()->user()->teammember_id;
      $notificationDatas =    $notificationDatas = DB::table('notifications')
        ->leftjoin('teammembers', 'teammembers.id', 'notifications.created_by')
        ->Where('targettype', '3')->orWhere('targettype', '2')
        ->select(
          'notifications.*',
          'teammembers.profilepic',
          'teammembers.team_member'
        )->orderBy('created_at', 'desc')->paginate(2);
      //  dd($notificationDatas);
      $notification = Notification::count();
      $client = Client::count();
      $tender = Tender::where('teammember_id', auth()->user()->teammember_id)->count();
      $teammember = Teammember::where('status', '1')->count();
      $userid = auth()->user()->role_id;
      $pageid = Permission::where('role_id', $userid)->select('page_id')->pluck('page_id')->first();
      $assetticket = DB::table('assettickets')
        ->leftjoin('teammembers', 'teammembers.id', 'assettickets.created_by')->where('assettickets.created_by', auth()->user()->teammember_id)
        ->select('assettickets.*', 'teammembers.team_member')->orderBy('created_at', 'desc')->get();
      $assignment =  DB::table('assignmentmappings')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
        ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')

        ->select(
          'assignmentbudgetings.client_id',
          'assignmentbudgetings.assignmentgenerate_id',
          'clients.client_name',
          'assignments.assignment_name'
        )
        ->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)->distinct()->take(3)->get();
      $assignmentcount = count($assignment);
      return view('backEnd.index', compact('tender', 'mentor', 'mentees', 'notification', 'assignmentcount', 'assignment', 'pageid', 'assetticket', 'client', 'teammember', 'notificationDatas', 'upcomingBirthdays', 'workAnniversaries', 'upcomingHolidays', 'todayBirthdays'));
    } elseif (auth()->user()->role_id == 16) {
      $authidd = Assignmentteammapping::where('teammember_id', auth()->user()->teammember_id)->select('assignmentmapping_id')->pluck('assignmentmapping_id')->first();
      $authid = auth()->user()->teammember_id;
      $notificationDatas =    $notificationDatas = DB::table('notifications')
        //    ->leftjoin('users','users.id','notifications.created_by')
        ->leftjoin('teammembers', 'teammembers.id', 'notifications.created_by')
        ->Where('targettype', '3')->orWhere('targettype', '2')->select(
          'notifications.*',
          'teammembers.profilepic',
          'teammembers.team_member'
        )->orderBy('created_at', 'desc')->paginate(2);
      //  dd($notificationDatas);
      $notification = Notification::count();
      $client = Client::count();
      $tender = Tender::where('teammember_id', auth()->user()->teammember_id)->count();
      $teammember = Teammember::where('status', '1')->count();
      $userid = auth()->user()->role_id;
      $pageid = Permission::where('role_id', $userid)->select('page_id')->pluck('page_id')->first();
      $assetticket = DB::table('assettickets')
        ->leftjoin('teammembers', 'teammembers.id', 'assettickets.created_by')
        ->select('assettickets.*', 'teammembers.team_member')->orderBy('created_at', 'desc')->get();
      $assignment =  DB::table('assignmentmappings')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
        ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')

        ->select(
          'assignmentbudgetings.client_id',
          'assignmentbudgetings.assignmentgenerate_id',
          'clients.client_name',
          'assignments.assignment_name'
        )
        ->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)->distinct()->get();
      $assignmentcount = count($assignment);
      return view('backEnd.index', compact('tender', 'mentor', 'mentees', 'notification', 'assignmentcount', 'assignment', 'pageid', 'assetticket', 'client', 'teammember', 'notificationDatas', 'upcomingBirthdays', 'workAnniversaries', 'upcomingHolidays', 'todayBirthdays'));
    } else {


      $status = DB::table('staffappointmentletters')->where('teammember_id', auth()->user()->teammember_id)->orderBy('id', 'DESC')->first();
      // dd($status);
      // dd($status);
      $teammember = DB::table('staffappointmentletters')
        ->leftjoin('teammembers', 'teammembers.id', 'staffappointmentletters.teammember_id')
        ->where('teammember_id', auth()->user()->teammember_id)
        ->select('staffappointmentletters.*', 'teammembers.team_member', 'teammembers.permanentaddress', 'teammembers.communicationaddress', 'teammembers.pancardno', 'teammembers.fathername', 'teammembers.joining_date')->orderBy('staffappointmentletters.id', 'DESC')->first();

      if ($status && $status->e_verify == 0 && in_array(auth()->user()->role_id, [14, 16, 17, 18])) {
        return view('backEnd.noappointmentletter');
      } elseif ($status && $status->e_verify == 1  && $status->otp == null && in_array(auth()->user()->role_id, [14, 16, 17, 18])) {
        return view('backEnd.appointmentletter', compact('teammember'));
      } else {


        $authidd = Assignmentteammapping::where('teammember_id', auth()->user()->teammember_id)->select('assignmentmapping_id')->pluck('assignmentmapping_id')->first();
        $authid = auth()->user()->teammember_id;
        $notificationDatas =   DB::table('notifications')
          //  ->leftjoin('users','users.id','notifications.created_by')
          ->leftjoin('teammembers', 'teammembers.id', 'notifications.created_by')
          ->where('notifications.targettype', '2')
          ->select('notifications.*', 'teammembers.team_member', 'teammembers.profilepic')->orWhere('targettype', '2')->orderBy('notifications.id', 'desc')->paginate(2);

        //  dd($notificationDatas);
        $notification = Notification::count();
        $client = Client::count();
        $teammember = Teammember::where('status', '1')->count();
        $userid = auth()->user()->role_id;
        $pageid = Permission::where('role_id', $userid)->select('page_id')->pluck('page_id')->first();
        $assetticket = DB::table('assettickets')
          ->leftjoin('users', 'users.id', 'assettickets.created_by')
          ->leftjoin('teammembers', 'teammembers.id', 'users.teammember_id')->where('assettickets.created_by', auth()->user()->teammember_id)
          ->select('assettickets.*', 'teammembers.team_member')->orderBy('created_at', 'desc')->get();
        $assignment =  DB::table('assignmentmappings')
          ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
          ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
          ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
          ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
          ->select(
            'assignmentmappings.*',
            'clients.client_name',
            'assignments.assignment_name'
          )->where('assignmentteammappings.teammember_id', $authid)->get();
        $assignmentcount = count($assignment);
        return view('backEnd.index', compact('notification', 'mentor', 'mentees', 'assignmentcount', 'assignment', 'pageid', 'assetticket', 'client', 'teammember', 'notificationDatas', 'upcomingBirthdays', 'workAnniversaries', 'upcomingHolidays', 'todayBirthdays'));
      }
    }
  }
          public function index()
  {
    $mentor_id = DB::table('teammembers')
      ->join('users', 'users.teammember_id', 'teammembers.id')
      ->where('users.teammember_id', auth()->user()->teammember_id)
      ->where('teammembers.status', '!=', 0)

      ->pluck('mentor_id')
      ->first();

    $mentee_id = DB::table('teammembers')
      ->join('users', 'users.teammember_id', 'teammembers.id')
      ->where('teammembers.mentor_id', auth()->user()->teammember_id)
      //->pluck('teammembers.id')
      ->where('teammembers.status', '!=', 0)

      ->get();

    //dd($mentee_id);
    $mentor = null;
    $mentees = null;

    if ($mentor_id != null) {
      $mentor = DB::table('teammembers')->where('id', $mentor_id)->where('status', '!=', 0)
        ->first();
    }

    if (count($mentee_id) != 0) {
      $mentees = $mentee_id;
    }

    // Set $mentees to null (if needed)
    if ($mentees == null) {
      $mentees = null;
    }

    $todayBirthdays = Teammember::whereNotNull('dateofbirth')
      ->where('status', '1')
      ->get()
      ->filter(function ($birthday) {
        $dateofbirth = Carbon::parse($birthday->dateofbirth);
        $currentDate = Carbon::now();

        // Compare the month and day without considering the current year
        return $dateofbirth->month == $currentDate->month && $dateofbirth->day == $currentDate->day;
      })
      ->sortBy('dateofbirth');

    $upcomingBirthdays = Teammember::where('status', '1')
      ->whereRaw('DATE_FORMAT(dateofbirth, "%m-%d") > DATE_FORMAT(NOW(), "%m-%d")')
      ->orderByRaw('DATE_FORMAT(dateofbirth, "%m-%d")')
      ->limit(7)
      ->get();



    $workAnniversaries = Teammember::whereNotNull('joining_date')
      ->where('status', '1')
      ->get()
      ->filter(function ($teammember) {
        $joiningDate = Carbon::parse($teammember->joining_date);
        $currentDate = Carbon::now();

        // Compare the month and day without considering the current year
        $isAnniversaryToday = $joiningDate->month == $currentDate->month && $joiningDate->day == $currentDate->day;

        // Exclude work anniversaries with a duration of 0 years
        $isNonZeroAnniversary = $joiningDate->diffInYears($currentDate) > 0;

        return $isAnniversaryToday && $isNonZeroAnniversary;
      })
      ->sortBy('joining_date')
      ->take(2);

    $upcomingHolidays = Holiday::where('startdate', '>', now()->format('Y-m-d'))
      ->where('status', 1)
      ->orderBy('startdate', 'asc')
      ->take(2)
      ->get();

    if (auth()->user()->role_id == 11 || auth()->user()->role_id == 12) {
      $authidd = Assignmentteammapping::where('teammember_id', auth()->user()->teammember_id)->select('assignmentmapping_id')->pluck('assignmentmapping_id')->first();
      $authid = auth()->user()->teammember_id;
      $notificationDatas =  DB::table('notifications')
        ->join('teammembers', 'teammembers.id', 'notifications.created_by')
        ->select(
          'notifications.*',
          'teammembers.profilepic',
          'teammembers.team_member'
        )->orderBy('created_at', 'desc')->paginate('2');
      // dd($notificationDatas);
      $client = Client::count();
      $teammember = Teammember::where('status', '1')->where('role_id', '!=', '11')->count();
      $userid = auth()->user()->role_id;
      $pageid = Permission::where('role_id', $userid)->select('page_id')->pluck('page_id')->first();
      $assetticket = DB::table('assettickets')
        ->leftjoin('teammembers', 'teammembers.id', 'assettickets.created_by')
        ->select('assettickets.*', 'teammembers.team_member')->orderBy('created_at', 'desc')->paginate(2);
      $assignment =  DB::table('assignmentbudgetings')
        ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->select(
          'assignmentbudgetings.*',
          'clients.client_name',
          'assignments.assignment_name'
        )->orderBy('assignmentbudgetings.created_at', 'desc')->take(3)->get();
      $assignmentcount = Assignmentmapping::count();
      $notification = Notification::count();
      return view('backEnd.index', compact('mentor', 'mentees', 'notification', 'assignmentcount', 'assignment', 'pageid', 'assetticket', 'client', 'teammember', 'notificationDatas', 'upcomingBirthdays', 'workAnniversaries', 'upcomingHolidays', 'todayBirthdays'));
    } elseif (auth()->user()->role_id == 13) {
      $authidd = Assignmentteammapping::where('teammember_id', auth()->user()->teammember_id)->select('assignmentmapping_id')->pluck('assignmentmapping_id')->first();
      $authid = auth()->user()->teammember_id;
      $notificationDatas =    $notificationDatas = DB::table('notifications')
        ->leftjoin('teammembers', 'teammembers.id', 'notifications.created_by')
        ->Where('targettype', '3')->orWhere('targettype', '2')
        ->select(
          'notifications.*',
          'teammembers.profilepic',
          'teammembers.team_member'
        )->orderBy('created_at', 'desc')->paginate(2);
      //  dd($notificationDatas);
      $notification = Notification::count();
      $client = Client::count();
      $tender = Tender::where('teammember_id', auth()->user()->teammember_id)->count();
      $teammember = Teammember::where('status', '1')->count();
      $userid = auth()->user()->role_id;
      $pageid = Permission::where('role_id', $userid)->select('page_id')->pluck('page_id')->first();
      $assetticket = DB::table('assettickets')
        ->leftjoin('teammembers', 'teammembers.id', 'assettickets.created_by')->where('assettickets.created_by', auth()->user()->teammember_id)
        ->select('assettickets.*', 'teammembers.team_member')->orderBy('created_at', 'desc')->get();
      $assignment =  DB::table('assignmentmappings')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
        ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')

        ->select(
          'assignmentbudgetings.client_id',
          'assignmentbudgetings.assignmentgenerate_id',
          'clients.client_name',
          'assignments.assignment_name'
        )
        ->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)->distinct()->take(3)->get();
      $assignmentcount = count($assignment);
      return view('backEnd.index', compact('tender', 'mentor', 'mentees', 'notification', 'assignmentcount', 'assignment', 'pageid', 'assetticket', 'client', 'teammember', 'notificationDatas', 'upcomingBirthdays', 'workAnniversaries', 'upcomingHolidays', 'todayBirthdays'));
    } elseif (auth()->user()->role_id == 16) {
      $authidd = Assignmentteammapping::where('teammember_id', auth()->user()->teammember_id)->select('assignmentmapping_id')->pluck('assignmentmapping_id')->first();
      $authid = auth()->user()->teammember_id;
      $notificationDatas =    $notificationDatas = DB::table('notifications')
        //    ->leftjoin('users','users.id','notifications.created_by')
        ->leftjoin('teammembers', 'teammembers.id', 'notifications.created_by')
        ->Where('targettype', '3')->orWhere('targettype', '2')->select(
          'notifications.*',
          'teammembers.profilepic',
          'teammembers.team_member'
        )->orderBy('created_at', 'desc')->paginate(2);
      //  dd($notificationDatas);
      $notification = Notification::count();
      $client = Client::count();
      $tender = Tender::where('teammember_id', auth()->user()->teammember_id)->count();
      $teammember = Teammember::where('status', '1')->count();
      $userid = auth()->user()->role_id;
      $pageid = Permission::where('role_id', $userid)->select('page_id')->pluck('page_id')->first();
      $assetticket = DB::table('assettickets')
        ->leftjoin('teammembers', 'teammembers.id', 'assettickets.created_by')
        ->select('assettickets.*', 'teammembers.team_member')->orderBy('created_at', 'desc')->get();
      $assignment =  DB::table('assignmentmappings')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
        ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')

        ->select(
          'assignmentbudgetings.client_id',
          'assignmentbudgetings.assignmentgenerate_id',
          'clients.client_name',
          'assignments.assignment_name'
        )
        ->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)->distinct()->get();
      $assignmentcount = count($assignment);
      return view('backEnd.index', compact('tender', 'mentor', 'mentees', 'notification', 'assignmentcount', 'assignment', 'pageid', 'assetticket', 'client', 'teammember', 'notificationDatas', 'upcomingBirthdays', 'workAnniversaries', 'upcomingHolidays', 'todayBirthdays'));
    } else {


      $status = DB::table('staffappointmentletters')->where('teammember_id', auth()->user()->teammember_id)->orderBy('id', 'DESC')->first();
      // dd($status);
      // dd($status);
      $teammember = DB::table('staffappointmentletters')
        ->leftjoin('teammembers', 'teammembers.id', 'staffappointmentletters.teammember_id')
        ->where('teammember_id', auth()->user()->teammember_id)
        ->select('staffappointmentletters.*', 'teammembers.team_member', 'teammembers.permanentaddress', 'teammembers.communicationaddress', 'teammembers.pancardno', 'teammembers.fathername', 'teammembers.joining_date')->orderBy('staffappointmentletters.id', 'DESC')->first();

      if ($status && $status->e_verify == 0 && in_array(auth()->user()->role_id, [14, 16, 17, 18])) {
        return view('backEnd.noappointmentletter');
      } elseif ($status && $status->e_verify == 1  && $status->otp == null && in_array(auth()->user()->role_id, [14, 16, 17, 18])) {
        return view('backEnd.appointmentletter', compact('teammember'));
      } else {


        $authidd = Assignmentteammapping::where('teammember_id', auth()->user()->teammember_id)->select('assignmentmapping_id')->pluck('assignmentmapping_id')->first();
        $authid = auth()->user()->teammember_id;
        $notificationDatas =   DB::table('notifications')
          //  ->leftjoin('users','users.id','notifications.created_by')
          ->leftjoin('teammembers', 'teammembers.id', 'notifications.created_by')
          ->where('notifications.targettype', '2')
          ->select('notifications.*', 'teammembers.team_member', 'teammembers.profilepic')->orWhere('targettype', '2')->orderBy('notifications.id', 'desc')->paginate(2);

        //  dd($notificationDatas);
        $notification = Notification::count();
        $client = Client::count();
        $teammember = Teammember::where('status', '1')->count();
        $userid = auth()->user()->role_id;
        $pageid = Permission::where('role_id', $userid)->select('page_id')->pluck('page_id')->first();
        $assetticket = DB::table('assettickets')
          ->leftjoin('users', 'users.id', 'assettickets.created_by')
          ->leftjoin('teammembers', 'teammembers.id', 'users.teammember_id')->where('assettickets.created_by', auth()->user()->teammember_id)
          ->select('assettickets.*', 'teammembers.team_member')->orderBy('created_at', 'desc')->get();
        $assignment =  DB::table('assignmentmappings')
          ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
          ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
          ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
          ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
          ->select(
            'assignmentmappings.*',
            'clients.client_name',
            'assignments.assignment_name'
          )->where('assignmentteammappings.teammember_id', $authid)->get();
        $assignmentcount = count($assignment);
        return view('backEnd.index', compact('notification', 'mentor', 'mentees', 'assignmentcount', 'assignment', 'pageid', 'assetticket', 'client', 'teammember', 'notificationDatas', 'upcomingBirthdays', 'workAnniversaries', 'upcomingHolidays', 'todayBirthdays'));
      }
    }
  }
        //* regarding 
        $authname = Teammember::where('id', auth()->user()->teammember_id)->first();
            $partnername = Teammember::where('id', $request->partner_id)->first();
            $clientdata = DB::table('clients')
                ->where('id', $request->client_id)
                ->select('client_name')
                ->first();

            $clientName = $clientdata ? $clientdata->client_name : '';

            $data = array(
                'authnames' =>  $authname->team_member,
                'taskname' =>  $request->taskname,
                'assignmentgenerateid' =>  $request->assignmentgenerateid,
                'description' =>  $request->description,
                'clientname' => $clientName,
                'partnername' =>  $partnername->team_member,
                'ccmail' =>  $partnername->emailid,
            );

            Mail::send('emails.omsassign', $data, function ($msg) use ($data, $request) {
                $msg->to('simmi@capitall.io');
                if ($request->partner_id && $request->inform_partner == 1 && !empty($data['ccmail'])) {
                    $msg->cc($data['ccmail']);
                }
                $msg->subject('OMS Query Raised');
            });
           public function adminticketUpdate(Request $request)
    {
        $request->validate([
            'file.*' => 'nullable|file|max:3145728|mimes:jpeg,png,jpg,pdf,doc,docx,xlsx,xls,csv,pptx,zip,rar',
        ]);

        try {
            $id =  DB::table('tasktrails')->insertGetId([
                'task_id' => $request->task_id,
                'remark' => $request->remark,
                'status' => $request->status,
                'createdby' =>  auth()->user()->teammember_id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            if ($request->has('file')) {
                foreach ($request->file as $files) {
                    $file = $files;
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . '.' . $extension;
                    $file->move('backEnd/image/secretarialtask/', $filename);
                    $data['file'] = $filename;

                    DB::table('task_attachments')->insert([
                        'tasktrailsid' => $id,
                        'file' =>   $data['file'] ?? '',
                        'created_at'                =>       date('y-m-d'),
                        'updated_at'              =>    date('y-m-d'),
                    ]);
                }
            }

            DB::table('tasks')->where('id', $request->task_id)->update([
                'status' => $request->status
            ]);

            $tasks =  DB::table('tasks')->where('id', $request->task_id)->first();
            $assignby = DB::table('teammembers')->where('id', $tasks->createdby)->first();

            if (auth()->user()->role_id == 11 || auth()->user()->role_id == 12) {
                if ($request->status == 1) {
                    $data = array(
                        'taskname' =>  $tasks->taskname,
                        'description' =>  $request->remark,
                        'assignby'  => $assignby->emailid,
                        'assignbyname'  => $assignby->team_member,
                        'inform_partner'  => $tasks->inform_partner,
                        'partner_id'  => $tasks->partner_id,
                    );
                    $data['ccmail'] = Teammember::where('id', $tasks->partner_id)->first()->emailid;

                    Mail::send('emails.admintaskdone', $data, function ($msg) use ($data) {
                        $msg->to($data['assignby']);
                        if ($data['partner_id'] && $data['inform_partner'] == 1) {
                            $msg->cc($data['ccmail']);
                        }
                        $msg->subject('kgs Admin Ticket Closed');
                    });
                } else {
                    $data = array(
                        'taskname' =>  $tasks->taskname,
                        'description' =>  $request->remark,
                        'assignby'  => $assignby->emailid,
                        'assignbyname'  => $assignby->team_member,
                        'inform_partner'  => $tasks->inform_partner,
                        'partner_id'  => $tasks->partner_id,
                    );
                    $data['ccmail'] = Teammember::where('id', $tasks->partner_id)->first()->emailid;

                    Mail::send('emails.admintaskinstruction', $data, function ($msg) use ($data) {
                        $msg->to($data['assignby']);
                        if ($data['partner_id'] && $data['inform_partner'] == 1) {
                            $msg->cc($data['ccmail']);
                        }
                        $msg->subject('kgs Admin Ticket New Instruction');
                    });
                }
            } elseif (auth()->user()->role_id == 13) {
                if ($request->status == 1) {
                    $data = array(
                        'taskname' =>  $tasks->taskname,
                        'description' =>  $request->remark,
                        'assignby'  => $assignby->emailid,
                        'assignbyname'  => $assignby->team_member,
                        'inform_partner'  => $tasks->inform_partner,
                        'partner_id'  => $tasks->partner_id,
                    );

                    Mail::send('emails.admintaskdone', $data, function ($msg) use ($data) {
                        $msg->to('poojakumari@capitall.io');
                        $msg->cc($data['assignby']);
                        $msg->subject('kgs Admin Ticket Closed');
                    });
                } else {
                    $data = array(
                        'taskname' =>  $tasks->taskname,
                        'description' =>  $request->remark,
                        'assignby'  => $assignby->emailid,
                        'assignbyname'  => $assignby->team_member,
                        'inform_partner'  => $tasks->inform_partner,
                        'partner_id'  => $tasks->partner_id,
                    );

                    Mail::send('emails.admintaskinstruction', $data, function ($msg) use ($data) {
                        $msg->to('poojakumari@capitall.io');
                        $msg->cc($data['assignby']);
                        $msg->subject('kgs Admin Ticket New Instruction');
                    });
                }
            } else {
                if ($request->status == 1) {
                    $data = array(
                        'taskname' =>  $tasks->taskname,
                        'description' =>  $request->remark,
                        'assignby'  => $assignby->emailid,
                        'assignbyname'  => $assignby->team_member,
                        'inform_partner'  => $tasks->inform_partner,
                        'partner_id'  => $tasks->partner_id,
                    );
                    $data['ccmail'] = Teammember::where('id', $tasks->partner_id)->first()->emailid;

                    Mail::send('emails.admintaskdone', $data, function ($msg) use ($data) {
                        $msg->to('poojakumari@capitall.io');
                        if ($data['partner_id'] && $data['inform_partner'] == 1) {
                            $msg->cc($data['ccmail']);
                        }
                        $msg->subject('kgs Admin Ticket Closed');
                    });
                } else {
                    $data = array(
                        'taskname' =>  $tasks->taskname,
                        'description' =>  $request->remark,
                        'assignby'  => $assignby->emailid,
                        'assignbyname'  => $assignby->team_member,
                        'inform_partner'  => $tasks->inform_partner,
                        'partner_id'  => $tasks->partner_id,
                    );
                    $data['ccmail'] = Teammember::where('id', $tasks->partner_id)->first()->emailid;

                    Mail::send('emails.admintaskinstruction', $data, function ($msg) use ($data) {
                        $msg->to('poojakumari@capitall.io');
                        if ($data['partner_id'] && $data['inform_partner'] == 1) {
                            $msg->cc($data['ccmail']);
                        }
                        $msg->subject('kgs Admin Ticket New Instruction');
                    });
                }
            }
            $output = array('msg' => 'Submit Successfully');
            return back()->with('success', $output);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }

        //* regarding 
        
<script>
    // Function to show SweetAlert2 confirmation dialog
    function showConfirmation() {

        // const description = document.getElementById('editor').value.trim();
        // var isEmpty = !description ||
        //     description === '' ||
        //     description === '<p><br></p>' ||
        //     description === '<p></p>' ||
        //     description.trim() === '' ||
        //     $(description).text().trim() === '';

        // console.log("description:", description);
        // console.log("isEmpty:", isEmpty);

        // if (isEmpty) {
        //     alert('Please enter description');
        //     return false;
        // }

        const description = document.getElementById('editor').value || '';

        // 🔥 Proper empty check for HTML editors
        const isEmpty = description
            .replace(/<[^>]*>/g, '') // remove HTML tags
            .replace(/&nbsp;/g, '')
            .trim() === '';

        console.log("description:", description);
        console.log("isEmpty:", isEmpty);

        if (isEmpty) {
            alert('Please enter description');
            return false;
        }

        Swal.fire({
            title: 'Inform Partner?',
            text: "Do You want to inform partner about the ticket?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Yes, submit it!',
            cancelButtonColor: '#f39c12', // Use the color for 'Cancel' button
            cancelButtonText: 'Cancel',
            showDenyButton: true,
            denyButtonColor: '#d33', // Use the color for 'No, submit it!' button
            denyButtonText: 'No, submit it!',
            allowOutsideClick: false,
            buttons: ['cancel', 'deny', 'confirm'] // Specify the order of buttons
        }).then((result) => {
            if (result.isConfirmed) {
                // If the user clicks 'Yes', set inform_partner to 1 and manually submit the form
                document.getElementById("informPartnerInput").value = "1";
                document.getElementById("ticketForm").submit();
            } else if (result.isDismissed && result.dismiss === Swal.DismissReason.cancel) {
                // Handle 'Cancel' button click (do nothing or provide specific action)
                Swal.update({
                    showDenyButton: true,
                    denyButtonText: 'Cancel',
                });
            } else {
                // If the user clicks 'No', set inform_partner to 0 and manually submit the form
                document.getElementById("informPartnerInput").value = "0";
                document.getElementById("ticketForm").submit();
            }
        });

        return false;
    }
</script>
        <script>
    $(document).ready(function() {
        // Add required validation
        $('ticketForm').on('submit', function(e) {
            var summernoteContent = $('#summernote').summernote('isEmpty');
            if (summernoteContent) {
                alert('Announcement Content is required.');
                e.preventDefault(); // Prevent form submission
                return false;
            }
        });
    });
</script>

<div class="row row-sm">
    <div class="col-12">
        <div class="form-group">
            <label class="font-weight-600">Description of Query <span class="text-danger">*</span></label>
            <textarea rows="14" name="description" value="" class="centered form-control" id="summernote" id="editor"
                placeholder="Enter Description">{!! $task->description ?? '' !!}</textarea>
        </div>
    </div>
</div>

  <form method="post" id="ticketForm" action="{{ route('adminticket.store') }}"
                             enctype="multipart/form-data">
                             @csrf
                             @component('backEnd.components.alert')
                             @endcomponent
                             @include('backEnd.adminticket.form')
                         </form>
        //* regarding
                $leaves = DB::table('applyleaves')
            ->leftJoin('leavetypes', 'leavetypes.id', '=', 'applyleaves.leavetype')
            // ->where('createdby', $request->teammember_id)
            // ->whereIn('status', [1, 0])
            ->whereDate('applyleaves.from', '<=', $endDate)
            ->whereDate('applyleaves.to', '>=', $startDate)
            ->select('applyleaves.*', 'leavetypes.code')
            ->get(); 
        //* regarding 
                    dd($employeename, $currentMonth, $startDate, $endDate, $daysInMonth, $currentMonthName, $datesArray, $currentDate);

        Illuminate\Support\Collection {#3514 ▼
  #items: array:238 [▶]
  #escapeWhenCastingToString: false
}
"12"
Illuminate\Support\Carbon @1764095400 {#3502 ▼
  #endOfTime: false
  #startOfTime: false
  #constructedObjectId: "0000000000000dae0000000000000000"
  #localMonthsOverflow: null
  #localYearsOverflow: null
  #localStrictModeEnabled: null
  #localHumanDiffOptions: null
  #localToStringFormat: null
  #localSerializer: null
  #localMacros: null
  #localGenericMacros: null
  #localFormatFunction: null
  #localTranslator: null
  #dumpProperties: array:3 [▶]
  #dumpLocale: null
  #dumpDateProperties: null
  date: 2025-11-26 00:00:00.0 Asia/Kolkata (+05:30)
}
Illuminate\Support\Carbon @1766601000 {#3474 ▼
  #endOfTime: false
  #startOfTime: false
  #constructedObjectId: "0000000000000d920000000000000000"
  #localMonthsOverflow: null
  #localYearsOverflow: null
  #localStrictModeEnabled: null
  #localHumanDiffOptions: null
  #localToStringFormat: null
  #localSerializer: null
  #localMacros: null
  #localGenericMacros: null
  #localFormatFunction: null
  #localTranslator: null
  #dumpProperties: array:3 [▶]
  #dumpLocale: null
  #dumpDateProperties: null
  date: 2025-12-25 00:00:00.0 Asia/Kolkata (+05:30)
}
30
"December"
array:30 [▼
  0 => "26"
  1 => "27"
  2 => "28"
  3 => "29"
  4 => "30"
  5 => "01"
  6 => "02"
  7 => "03"
  8 => "04"
  9 => "05"
  10 => "06"
  11 => "07"
  12 => "08"
  13 => "09"
  14 => "10"
  15 => "11"
  16 => "12"
  17 => "13"
  18 => "14"
  19 => "15"
  20 => "16"
  21 => "17"
  22 => "18"
  23 => "19"
  24 => "20"
  25 => "21"
  26 => "22"
  27 => "23"
  28 => "24"
  29 => "25"
]
Illuminate\Support\Carbon @1766687400 {#3473 ▼
  #endOfTime: false
  #startOfTime: false
  #constructedObjectId: "0000000000000d910000000000000000"
  #localMonthsOverflow: null
  #localYearsOverflow: null
  #localStrictModeEnabled: null
  #localHumanDiffOptions: null
  #localToStringFormat: null
  #localSerializer: null
  #localMacros: null
  #localGenericMacros: null
  #localFormatFunction: null
  #localTranslator: null
  #dumpProperties: array:3 [▶]
  #dumpLocale: null
  #dumpDateProperties: null
  date: 2025-12-26 00:00:00.0 Asia/Kolkata (+05:30)
}
        
=COUNTIF(H3:AK3,"Not Checkin")


    public function checkinlist()
    {
        //On_Time_Before_10_30

        if (auth()->user()->role_id == 11 || auth()->user()->role_id == 18 || auth()->user()->teammember_id == 170) {
            $employeename = DB::table('teammembers')
                ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
                ->leftjoin('titles', 'titles.id', 'teammembers.title_id')
                ->where('role_id', '!=', 11)->where('role_id', '!=', 13)->where('role_id', '!=', 12)->where('status', 1)
                ->select('teammembers.*', 'roles.rolename', 'titles.title')
                ->get();

            $currentMonth = date('m');
            $startDate = now()->subMonthsNoOverflow(1)->startOfMonth()->addDays(25)->setMonth($currentMonth - 1);
            $endDate = now()->startOfMonth()->addDays(24);

            $daysInMonth = $startDate->diffInDays($endDate) + 1;
            $currentMonthName = date('F', mktime(0, 0, 0, $currentMonth, 1));

            $datesArray = [];
            $currentDate = $startDate->copy();
            while ($currentDate <= $endDate) {
                $datesArray[] = $currentDate->format('d');
                $currentDate->addDay();
            }

            $report = DB::table('teammembers')
                ->leftJoin('checkins', 'teammembers.id', '=', 'checkins.teammember_id')
                ->leftJoin('roles', 'teammembers.role_id', '=', 'roles.id')
                ->leftJoin('clients', 'checkins.client_id', '=', 'clients.id')
                ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'checkins.assignment_id')
                ->leftJoin('assignments', 'assignments.id', '=', 'assignmentbudgetings.assignment_id')
                ->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', '=', 'checkins.assignment_id')
                ->leftJoin('teammembers as teampartner', 'teampartner.id', '=', 'assignmentmappings.leadpartner')
                ->leftJoin('holidays', function ($join) {
                    $join->on(DB::raw('STR_TO_DATE(checkins.date, "%d-%m-%Y")'), '=', 'holidays.startdate');
                })
                ->whereBetween(
                    DB::raw('STR_TO_DATE(checkins.date, "%d-%m-%Y")'),
                    [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')]
                )
                // ->where('teammembers.id', 973)
                ->select(
                    'teammembers.id',
                    'teammembers.joining_date',
                    'teammembers.team_member',
                    'roles.rolename',

                    DB::raw('GROUP_CONCAT(DISTINCT clients.client_name) as client_Namess'),
                    DB::raw('GROUP_CONCAT(DISTINCT checkins.assignment_id) as assignmentid'),
                    DB::raw('GROUP_CONCAT(DISTINCT assignments.assignment_name) as assignmentname'),
                    DB::raw('GROUP_CONCAT(DISTINCT teampartner.team_member) as teampartner'),

                    DB::raw('COUNT(*) as Total_Checkin'),
                    DB::raw('SUM(CASE WHEN checkins.checkin_from = "Office" THEN 1 ELSE 0 END) as Office'),
                    DB::raw('SUM(CASE WHEN checkins.checkin_from = "Work From Home" THEN 1 ELSE 0 END) as WFM'),
                    DB::raw('SUM(CASE WHEN checkins.checkin_from = "Client Place" THEN 1 ELSE 0 END) as Client_Place'),
                    DB::raw('SUM(CASE WHEN checkins.checkin_from = "Business Development" THEN 1 ELSE 0 END) as Business_Development'),
                    DB::raw('SUM(CASE WHEN checkins.time < "10:30:00" THEN 1 ELSE 0 END) as On_Time_Before_10_30'),
                    DB::raw('SUM(CASE WHEN checkins.time >= "10:30:00" AND checkins.time < "12:00:00" THEN 1 ELSE 0 END) as chgg'),
                    DB::raw('SUM(CASE WHEN checkins.time > "12:01:00" THEN 1 ELSE 0 END) as After_12_PM'),
                    DB::raw('SUM(CASE WHEN checkins.typeval IS NULL THEN 1 ELSE 0 END) as Unallocated'),

                    DB::raw('GROUP_CONCAT(DISTINCT CONCAT(STR_TO_DATE(checkins.date, "%d-%m-%Y"), " ", TIME_FORMAT(checkins.time, "%H:%i:%s"))) as checkin_datetime'),

                    //-- Leave Count
                    DB::raw('(SELECT COUNT(*) FROM applyleaves 
                      WHERE applyleaves.createdby = teammembers.id 
                      AND applyleaves.from BETWEEN "' . $startDate->format('Y-m-d') . '" 
                      AND "' . $endDate->format('Y-m-d') . '") as Leave_Count'),

                    //-- Leave Days
                    DB::raw('(SELECT SUM(DATEDIFF(
                CASE WHEN `to` > "' . $endDate->format('Y-m-d') . '" THEN "' . $endDate->format('Y-m-d') . '" ELSE `to` END,
                CASE WHEN `from` < "' . $startDate->format('Y-m-d') . '" THEN "' . $startDate->format('Y-m-d') . '" ELSE `from` END
            ) + 1)
            FROM applyleaves 
            WHERE applyleaves.createdby = teammembers.id 
              AND (`from` BETWEEN "' . $startDate->format('Y-m-d') . '" AND "' . $endDate->format('Y-m-d') . '"
              OR `to` BETWEEN "' . $startDate->format('Y-m-d') . '" AND "' . $endDate->format('Y-m-d') . '"
              OR (`from` < "' . $startDate->format('Y-m-d') . '" AND `to` > "' . $endDate->format('Y-m-d') . '")
            )) as Leave_Days'),

                    DB::raw('(SELECT COUNT(*) FROM holidays WHERE holidays.startdate BETWEEN "' . $startDate->format('Y-m-d') . '" AND "' . $endDate->format('Y-m-d') . '" AND holidays.status = 3) as weekends_Count'),
                    DB::raw('(SELECT COUNT(*) FROM holidays WHERE holidays.startdate BETWEEN "' . $startDate->format('Y-m-d') . '" AND "' . $endDate->format('Y-m-d') . '" AND holidays.status = 1) as holidaymonth_Count'),
                    DB::raw('(SELECT COUNT(*) FROM holidays WHERE holidays.startdate BETWEEN "' . $startDate->format('Y-m-d') . '" AND "' . $endDate->format('Y-m-d') . '") as Holiday_Count'),

                    DB::raw('(' . $daysInMonth . ' - (SELECT COUNT(*) FROM holidays WHERE holidays.startdate BETWEEN "' . $startDate->format('Y-m-d') . '" AND "' . $endDate->format('Y-m-d') . '")) as totalcheckin_count'),
                    DB::raw('COUNT(DISTINCT holidays.startdate) as holiday_working_count'),
                    DB::raw('COUNT(*) - COUNT(DISTINCT holidays.startdate) as Total_Checkin_minus_holiday_count'),

                    // DB::raw('(' . $daysInMonth . ' - (SELECT COUNT(*) FROM holidays WHERE holidays.startdate BETWEEN "' . $startDate->format('Y-m-d') . '" AND "' . $endDate->format('Y-m-d') . '")) - COUNT(*) + COUNT(DISTINCT holidays.startdate) as not_checkin'),

                    //----------------------------------------------------
                    // ⭐ ADDED: TOTAL TIMESHEET FILLED COUNTER
                    //----------------------------------------------------
                    DB::raw('(SELECT COUNT(*) FROM timesheetusers
                      WHERE timesheetusers.createdby = teammembers.id
                      AND STR_TO_DATE(timesheetusers.date, "%d-%m-%Y")
                      BETWEEN "' . $startDate->format('Y-m-d') . '" 
                      AND "' . $endDate->format('Y-m-d') . '"
                     ) AS Timesheet_Filled_Count')
                )
                ->groupBy('teammembers.id', 'teammembers.joining_date', 'teammembers.team_member', 'roles.rolename')
                // ->orderBy('teammembers.id', 'asc')   // ⭐ Required before skip/take
                // ->offset(5)   // same as skip(31)
                // ->limit(1)    // same as take(10)
                ->get();


            // dd($report);
            // $report->dump();




            // Keep your remaining code untouched…
            $holidays = \App\Models\Holiday::whereBetween('startdate', [
                $startDate->format('Y-m-d'),
                $endDate->format('Y-m-d')
            ])
                ->get()
                ->keyBy(function ($item) {
                    return date('Y-m-d', strtotime($item->startdate));
                });

            $leaves = \App\Models\Applyleave::where(function ($query) use ($startDate, $endDate) {
                $query->where('from', '<=', $endDate)
                    ->where('to', '>=', $startDate);
            })->leftJoin('leavetypes', 'leavetypes.id', '=', 'applyleaves.leavetype')
                ->select('applyleaves.*', 'leavetypes.code')
                ->get();



            foreach ($report as $entry) {

                $entry->daysInMonth = $daysInMonth;
                $entry->currentMonthName = $currentMonthName;
                $entry->formatted_joining_date = \Carbon\Carbon::parse($entry->joining_date)->isoFormat('MMMM DD, YYYY');

                $datetime_pairs = explode(',', $entry->checkin_datetime);
                $temp_array = [];

                $currentDate = $startDate;
                while ($currentDate <= $endDate) {

                    $date = date('Y-m-d', strtotime($currentDate));
                    $holiday = $holidays[$date] ?? null;

                    $leavesForDate = $leaves->where('from', '<=', $date)
                        ->where('to', '>=', $date)
                        ->where('createdby', $entry->id)
                        ->pluck('code')
                        ->implode(', ');

                    $found = false;
                    foreach ($datetime_pairs as $datetime_pair) {
                        $datetime_parts = explode(' ', trim($datetime_pair));
                        $entry_date = $datetime_parts[0];
                        if ($date === $entry_date) {
                            $time = date('H:i', strtotime($datetime_parts[1]));
                            $temp_array[] = ['date' => $date, 'time' => $time];
                            $found = true;
                            break;
                        }
                    }

                    if (!$found) {
                        $temp_array[] = [
                            'date' => $date,
                            'time' => ($holiday)
                                ? ($holiday->status == 3 ? 'W' : 'H')
                                : ($leavesForDate ? $leavesForDate : 'Not Checkin')
                        ];
                    }

                    $currentDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
                }

                $entry->checkin_datetime = $temp_array;

                $notCheckinCount = 0;

                foreach ($entry->checkin_datetime as $day) {
                    if ($day['time'] === 'Not Checkin') {
                        $notCheckinCount++;
                    }
                }

                $entry->not_checkin = $notCheckinCount;
            }
            return view(
                'backEnd.check-In.checkinlist',
                compact('employeename', 'report', 'datesArray')
            );
        } else {
            abort(403, 'You do not have permission.');
        }
    }
    public function checkinlistfiltersection(Request $request)
    {
        // dd($not_checkin);

        $employeename = DB::table('teammembers')
            ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
            ->leftjoin('titles', 'titles.id', 'teammembers.title_id')
            ->where('role_id', '!=', 11)->where('role_id', '!=', 13)->where('role_id', '!=', 12)->where('status', 1)
            ->select('teammembers.*', 'roles.rolename', 'titles.title')
            ->get();
        $month =  $request->month;
        $month = date('m', strtotime($month));
        //dd($month);
        $currentYear = now()->year;

        // Set start date to the 25th of the month
        $startDate = now()->subMonthsNoOverflow(1)->startOfMonth()->addDays(25)->setMonth($month - 1);
        // Set end date to the 25th of the selected month
        $endDate = now()->startOfMonth()->setMonth($month)->addDays(24);
        $daysInMonth = $startDate->diffInDays($endDate) + 1;
        $currentMonthName = date('F', mktime(0, 0, 0, $month, 1));
        //dd($currentMonthName);
        $datesArray = [];

        // Generate dates for the current month
        $currentDate = $startDate->copy();
        while ($currentDate <= $endDate) {
            $datesArray[] = $currentDate->format('d');
            $currentDate->addDay();
        }

        $report = DB::table('teammembers')
            ->leftJoin('checkins', 'teammembers.id', '=', 'checkins.teammember_id')
            ->leftJoin('roles', 'teammembers.role_id', '=', 'roles.id')
            ->leftJoin('clients', 'checkins.client_id', '=', 'clients.id')
            ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'checkins.assignment_id')
            ->leftJoin('assignments', 'assignments.id', '=', 'assignmentbudgetings.assignment_id')
            ->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', '=', 'checkins.assignment_id')
            ->leftJoin('teammembers as teampartner', 'teampartner.id', '=', 'assignmentmappings.leadpartner')
            ->leftJoin('holidays', function ($join) {
                $join->on(DB::raw('STR_TO_DATE(checkins.date, "%d-%m-%Y")'), '=', 'holidays.startdate');
            })
            ->whereBetween(DB::raw('STR_TO_DATE(checkins.date, "%d-%m-%Y")'), [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->select(
                'teammembers.id',
                'teammembers.joining_date',
                'teammembers.team_member',
                'roles.rolename',

                DB::raw('GROUP_CONCAT(DISTINCT clients.client_name) as client_Namess'),
                DB::raw('GROUP_CONCAT(DISTINCT checkins.assignment_id) as assignmentid'),
                DB::raw('GROUP_CONCAT(DISTINCT assignments.assignment_name) as assignmentname'),
                DB::raw('GROUP_CONCAT(DISTINCT teampartner.team_member) as teampartner'),

                DB::raw('COUNT(*) as Total_Checkin'),
                DB::raw('SUM(CASE WHEN checkins.checkin_from = "Office" THEN 1 ELSE 0 END) as Office'),
                DB::raw('SUM(CASE WHEN checkins.checkin_from = "Work From Home" THEN 1 ELSE 0 END) as WFM'),
                DB::raw('SUM(CASE WHEN checkins.checkin_from = "Client Place" THEN 1 ELSE 0 END) as Client_Place'),
                DB::raw('SUM(CASE WHEN checkins.checkin_from = "Business Development" THEN 1 ELSE 0 END) as Business_Development'),
                DB::raw('SUM(CASE WHEN checkins.time < "10:30:00" THEN 1 ELSE 0 END) as On_Time_Before_10_30'),
                DB::raw('SUM(CASE WHEN checkins.time >= "10:30:00" AND checkins.time < "12:00:00" THEN 1 ELSE 0 END) as chgg'),
                DB::raw('SUM(CASE WHEN checkins.time > "12:01:00" THEN 1 ELSE 0 END) as After_12_PM'),
                DB::raw('SUM(CASE WHEN checkins.typeval IS NULL THEN 1 ELSE 0 END) as Unallocated'),

                DB::raw('GROUP_CONCAT(DISTINCT CONCAT(STR_TO_DATE(checkins.date, "%d-%m-%Y"), " ", TIME_FORMAT(checkins.time, "%H:%i:%s"))) as checkin_datetime'),

                //-- Leave Count
                DB::raw('(SELECT COUNT(*) FROM applyleaves 
                      WHERE applyleaves.createdby = teammembers.id 
                      AND applyleaves.from BETWEEN "' . $startDate->format('Y-m-d') . '" 
                      AND "' . $endDate->format('Y-m-d') . '") as Leave_Count'),

                //-- Leave Days
                DB::raw('(SELECT SUM(DATEDIFF(
                CASE WHEN `to` > "' . $endDate->format('Y-m-d') . '" THEN "' . $endDate->format('Y-m-d') . '" ELSE `to` END,
                CASE WHEN `from` < "' . $startDate->format('Y-m-d') . '" THEN "' . $startDate->format('Y-m-d') . '" ELSE `from` END
            ) + 1)
            FROM applyleaves 
            WHERE applyleaves.createdby = teammembers.id 
              AND (`from` BETWEEN "' . $startDate->format('Y-m-d') . '" AND "' . $endDate->format('Y-m-d') . '"
              OR `to` BETWEEN "' . $startDate->format('Y-m-d') . '" AND "' . $endDate->format('Y-m-d') . '"
              OR (`from` < "' . $startDate->format('Y-m-d') . '" AND `to` > "' . $endDate->format('Y-m-d') . '")
            )) as Leave_Days'),

                DB::raw('(SELECT COUNT(*) FROM holidays WHERE holidays.startdate BETWEEN "' . $startDate->format('Y-m-d') . '" AND "' . $endDate->format('Y-m-d') . '" AND holidays.status = 3) as weekends_Count'),
                DB::raw('(SELECT COUNT(*) FROM holidays WHERE holidays.startdate BETWEEN "' . $startDate->format('Y-m-d') . '" AND "' . $endDate->format('Y-m-d') . '" AND holidays.status = 1) as holidaymonth_Count'),
                DB::raw('(SELECT COUNT(*) FROM holidays WHERE holidays.startdate BETWEEN "' . $startDate->format('Y-m-d') . '" AND "' . $endDate->format('Y-m-d') . '") as Holiday_Count'),

                DB::raw('(' . $daysInMonth . ' - (SELECT COUNT(*) FROM holidays WHERE holidays.startdate BETWEEN "' . $startDate->format('Y-m-d') . '" AND "' . $endDate->format('Y-m-d') . '")) as totalcheckin_count'),
                DB::raw('COUNT(DISTINCT holidays.startdate) as holiday_working_count'),
                DB::raw('COUNT(*) - COUNT(DISTINCT holidays.startdate) as Total_Checkin_minus_holiday_count'),

                // DB::raw('(' . $daysInMonth . ' - (SELECT COUNT(*) FROM holidays WHERE holidays.startdate BETWEEN "' . $startDate->format('Y-m-d') . '" AND "' . $endDate->format('Y-m-d') . '")) - COUNT(*) + COUNT(DISTINCT holidays.startdate) as not_checkin'),

                //----------------------------------------------------
                // ⭐ ADDED: TOTAL TIMESHEET FILLED COUNTER
                //----------------------------------------------------
                DB::raw('(SELECT COUNT(*) FROM timesheetusers
                      WHERE timesheetusers.createdby = teammembers.id
                      AND STR_TO_DATE(timesheetusers.date, "%d-%m-%Y")
                      BETWEEN "' . $startDate->format('Y-m-d') . '" 
                      AND "' . $endDate->format('Y-m-d') . '"
                     ) AS Timesheet_Filled_Count')
            )

            ->groupBy('teammembers.id', 'teammembers.joining_date', 'teammembers.team_member', 'roles.rolename')
            ->get();


        //dd($report);
        $holidays = \App\Models\Holiday::whereBetween('startdate', [
            $startDate->format('Y-m-d'),
            $endDate->format('Y-m-d')
        ])
            ->get()
            ->keyBy(function ($item) {
                return date('Y-m-d', strtotime($item->startdate));
            });

        $leaves = \App\Models\Applyleave::where(function ($query) use ($startDate, $endDate) {
            $query->where('from', '<=', $endDate)
                ->where('to', '>=', $startDate);
        })->leftJoin('leavetypes', 'leavetypes.id', '=', 'applyleaves.leavetype')
            ->select('applyleaves.*', 'leavetypes.code')
            ->get();
        foreach ($report as $entry) {
            // Explode each entry by the comma to separate date-time pairs
            $entry->daysInMonth = $daysInMonth;
            $entry->currentMonthName = $currentMonthName;
            $entry->formatted_joining_date = \Carbon\Carbon::parse($entry->joining_date)->isoFormat('MMMM DD, YYYY');
            $datetime_pairs = explode(',', $entry->checkin_datetime);

            // Create a temporary array to hold the separated date-time components
            $temp_array = [];

            // Loop through each date between $startDate and $endDate
            $currentDate = $startDate;
            while ($currentDate <= $endDate) {
                $date = date('Y-m-d', strtotime($currentDate));
                $holiday = $holidays[$date] ?? null;

                // Filter leaves for the current date and team member
                $leavesForDate = $leaves->where('from', '<=', $date)
                    ->where('to', '>=', $date)
                    ->where('createdby', $entry->id)
                    ->pluck('code')
                    ->implode(', ');

                // Check if the current date exists in the entry's checkin_datetime
                $found = false;
                foreach ($datetime_pairs as $datetime_pair) {
                    $datetime_parts = explode(' ', trim($datetime_pair));
                    $entry_date = $datetime_parts[0]; // Extract date from datetime pair
                    if ($date === $entry_date) {
                        $time = $datetime_parts[1]; // Extract time from datetime pair
                        $time = date('H:i', strtotime($time));
                        $temp_array[] = [
                            'date' => $date,
                            'time' => $time
                        ];
                        $found = true;
                        break; // No need to check further once found
                    }
                }

                // If the current date was not found, set time to null
                if (!$found) {
                    $temp_array[] = [
                        'date' => $date,
                        'time' => ($holiday) ? ($holiday->status == 3 ? 'W' : 'H') : (($leavesForDate) ? $leavesForDate : 'Not Checkin')
                    ];
                }

                // Move to the next date
                $currentDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
            }


            // Replace the checkin_datetime with the separated date-time components
            $entry->checkin_datetime = $temp_array;

            $notCheckinCount = 0;

            foreach ($entry->checkin_datetime as $day) {
                if ($day['time'] === 'Not Checkin') {
                    $notCheckinCount++;
                }
            }

            $entry->not_checkin = $notCheckinCount;
        }

        //dd($report);

        return view('backEnd.check-In.checkinlist', compact('employeename', 'report', 'datesArray'));
    }

        
  private function promotionOrRejoined($timesheetData)
  {
    $targetClients = [29, 34, 32, 33, 134];
    return $timesheetData->map(function ($row) use ($targetClients) {

      if (in_array($row->client_id, $targetClients)) {
        $timesheetDate = $row->date
          ? Carbon::parse($row->date)->endOfDay()
          : null;
        $row->final_teamstaffcode = $this->getStaffCodeAt($row->createdby, $timesheetDate);
        $row->final_partnerstaffcode = $this->getStaffCodeAt($row->partner, $timesheetDate);
      } else {
        // $row->final_teamstaffcode = $this->getStaffCodeAt($row->createdby, $row->assignmentcreated);
        // $row->final_partnerstaffcode = $this->getStaffCodeAt($row->partner, $row->assignmentcreated);

        $dateCheck = $row->assignmentcreated
          ? $row->assignmentcreated
          : Carbon::parse($row->date)->endOfDay();

        $row->final_teamstaffcode = $this->getStaffCodeAt($row->createdby, $dateCheck);
        $row->final_partnerstaffcode = $this->getStaffCodeAt($row->partner, $dateCheck);
      }
      return $row;
    });
  }

         // $row->final_teamstaffcode = $this->getStaffCodeAt($row->createdby, $row->assignmentcreated);
        // $row->final_partnerstaffcode = $this->getStaffCodeAt($row->partner, $row->assignmentcreated);

        $dateCheck = $row->assignmentcreated
          ? $row->assignmentcreated
          : Carbon::parse($row->date)->endOfDay();

        $row->final_teamstaffcode = $this->getStaffCodeAt($row->createdby, $dateCheck);
        $row->final_partnerstaffcode = $this->getStaffCodeAt($row->partner, $dateCheck);

         $latestHistory = DB::table('teamrolehistory as teamrolehistorydata')
                ->select('teamrolehistorydata.teammember_id', 'teamrolehistorydata.newstaff_code')
                ->whereRaw('teamrolehistorydata.id = (SELECT MAX(teamrolehistorylatest.id) FROM teamrolehistory as teamrolehistorylatest WHERE teamrolehistorylatest.teammember_id = teamrolehistorydata.teammember_id)');

            $teammemberDatas = Teammember::with(['title', 'role'])
                ->leftJoinSub($latestHistory, 'latestrecord', function ($join) {
                    $join->on('latestrecord.teammember_id', '=', 'teammembers.id');
                })
                ->where('teammembers.role_id', '!=', 11)
                ->where('teammembers.status', 1)
                ->select('teammembers.*', 'latestrecord.newstaff_code')
                ->get();
          public function getStaffCodewithrolename($teammember_id, $date)
    {

        $latest = DB::table('teamrolehistory')
            ->where('teammember_id', $teammember_id)
            ->where('created_at', '<=', $date)
            ->orderByDesc('created_at')
            ->first(['newstaff_code', 'roleid_new']);

        if ($latest) {
            $roleName = DB::table('roles')->where('id', $latest->roleid_new)->value('rolename');
            return [
                'staffcode' => $latest->newstaff_code,
                'rolename' => $roleName
            ];
        }

        $old = DB::table('teamrolehistory')
            ->where('teammember_id', $teammember_id)
            ->where('created_at', '>', $date)
            ->orderBy('created_at')
            ->first(['oldstaff_code', 'roleid_old']);

        if ($old) {
            $roleName = DB::table('roles')->where('id', $old->roleid_old)->value('rolename');
            return [
                'staffcode' => $old->oldstaff_code,
                'rolename' => $roleName
            ];
        }

        $team = DB::table('teammembers')
            ->where('id', $teammember_id)
            ->first(['staffcode', 'role_id']);

        if ($team) {
            $roleName = DB::table('roles')->where('id', $team->role_id)->value('rolename');
            return [
                'staffcode' => $team->staffcode,
                'rolename' => $roleName
            ];
        }

        return [
            'staffcode' => null,
            'rolename' => null
        ];
    }
        //* regarding 
        good code 
      // Fetch IT and Finance Tickets or Unresolved Tickets - HR, IT & Admin
      $ticketDatas = Assetticket::with(['financerequest', 'createdBy', 'partner'])
        ->whereIn('type', [0, 1])
        ->whereBetween('created_at', [$financialStartDate, $financialEndDate])
        ->orderByDesc('id')
        // ->limit(4)
        ->get()
        ->map(function ($item) {
          return [
            'ticket_id' => $item->generateticket_id,
            'department' => $item->type == 0 ? 'IT' : 'Finance',
            'created_by' => $item->createdBy->team_member ?? '',
            'subject' => $item->subject,
            'assigned_to' => $item->partner->team_member ?? '',
            'created_at' => $item->created_at,
            'status' => $item->status,
            'source' => 'ticket',
          ];
        })->toArray();



      // Fetch HR Tasks
      $hrTickets = DB::table('tasks')
        ->select(
          'tasks.*',
          'patnerid.team_member as partnername',
          'createdby.team_member as createdbyname',
          'hrfunctions.hrfunction'
        )
        ->where('tasks.task_type', 4)
        ->whereBetween('tasks.created_at', [$financialStartDate, $financialEndDate])
        ->leftJoin('teammembers as patnerid', 'patnerid.id', '=', 'tasks.partner_id')
        ->leftJoin('teammembers as createdby', 'createdby.id', '=', 'tasks.createdby')
        ->leftJoin('hrfunctions', 'hrfunctions.id', '=', 'tasks.hrfunction')
        ->orderByDesc('tasks.id')
        // ->limit(4)
        ->get()
        ->map(function ($item) {
          return [
            'ticket_id' => $item->generateticket_id ?? 'NA',
            'department' => 'HR',
            'created_by' => $item->createdbyname ?? '',
            'subject' => $item->taskname ?? '',
            'assigned_to' => $item->partnername ?? '',
            'created_at' => $item->created_at,
            'status' => $item->status,
            'source' => 'hr',
          ];
        })->toArray();

      $allTickets = collect(array_merge($ticketDatas, $hrTickets));
        //* regarding 

          $billspending15Daysdata = DB::table('assignmentmappings')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->leftJoin('invoices', 'invoices.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->leftJoin('outstandings', 'outstandings.BILL_NO', '=', 'invoices.invoice_id')
        // ->whereBetween(DB::raw('COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate)'), [$startDateFormatted, $endDateFormatted])
        ->whereBetween('invoices.created_at', [$startDateFormatted, $endDateFormatted])
        ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
          $query->whereMonth('invoices.created_at', $monthsdigit);
        })
        ->when(!empty($partnerId), function ($query) use ($partnerId) {
          $query->where('invoices.partner', $partnerId);
        })
        ->whereNotNull('invoices.id')
        ->where('assignmentbudgetings.status', 0)
        // ->whereIn('invoices.currency', [1, 3])
        ->where(function ($q) {
          $q->whereIn('invoices.currency', [1, 3])
            ->orWhereNull('invoices.currency');
        })
        ->whereBetween('invoices.created_at', [
          Carbon::today()->subDays(15)->startOfDay(),
          Carbon::today()->endOfDay()
          //  Carbon::yesterday()->endOfDay()
        ])
        ->select(
          'invoices.currency',
          // 'assignmentmappings.assignmentgenerate_id',
          DB::raw("DATE_FORMAT(outstandings.created_at, '%Y-%m-%d') as bill_date"),
          DB::raw('SUM(outstandings.AMT) as total_amount')
        )
        ->groupBy('invoices.currency', 'bill_date')
        ->get();


      $billspending15Days = $this->convertusdtoinr($billspending15Daysdata);

          // filter KPI Collection's Outstanding
      $outstandingBills = DB::table('assignmentmappings')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->leftJoin('invoices', 'invoices.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->leftJoin('outstandings', 'outstandings.BILL_NO', '=', 'invoices.invoice_id')
        ->whereBetween(DB::raw('COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate)'), [$startDateFormatted, $endDateFormatted])
        ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
          $query->whereMonth(DB::raw('COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate)'), $monthsdigit);
        })
        ->when(!empty($partnerId), function ($query) use ($partnerId) {
          $query->where('invoices.partner', $partnerId);
        })
        ->whereNotNull('invoices.id')
        ->where('assignmentbudgetings.status', 0)
        // ->whereIn('invoices.currency', [1, 3])
        ->where(function ($q) {
          $q->whereIn('invoices.currency', [1, 3])
            ->orWhereNull('invoices.currency');
        })
        ->select(
          'invoices.currency',
          // 'assignmentmappings.assignmentgenerate_id',
          DB::raw("DATE_FORMAT(outstandings.created_at, '%Y-%m-%d') as bill_date"),
          DB::raw('SUM(outstandings.AMT) as total_amount')
        )
        ->groupBy('invoices.currency', 'bill_date')
        ->get();


      $billspendingforcollection = $this->convertusdtoinr($outstandingBills);



       // Collection's Outstanding
      $outstandingBills = DB::table('assignmentmappings')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->leftJoin('invoices', 'invoices.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->leftJoin('outstandings', 'outstandings.BILL_NO', '=', 'invoices.invoice_id')
        ->whereNotNull('invoices.id')
        ->where('assignmentbudgetings.status', 0)
        // ->whereIn('invoices.currency', [1, 3])
        ->where(function ($q) {
          $q->whereIn('invoices.currency', [1, 3])
            ->orWhereNull('invoices.currency');
        })
        ->select(
          'invoices.currency',
          // 'assignmentmappings.assignmentgenerate_id',
          DB::raw("DATE_FORMAT(outstandings.created_at, '%Y-%m-%d') as bill_date"),
          DB::raw('SUM(outstandings.AMT) as total_amount')
        )
        ->groupBy('invoices.currency', 'bill_date')
        ->get();


      $billspendingforcollection = $this->convertusdtoinr($outstandingBills);


        $billspending15Daysdata = DB::table('assignmentmappings')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->leftJoin('invoices', 'invoices.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->leftJoin('outstandings', 'outstandings.BILL_NO', '=', 'invoices.invoice_id')
        ->whereNotNull('invoices.id')
        ->where('assignmentbudgetings.status', 0)
        ->where(function ($q) {
          $q->whereIn('invoices.currency', [1, 3])
            ->orWhereNull('invoices.currency');
        })
        ->whereBetween('invoices.created_at', [
          Carbon::today()->subDays(15)->startOfDay(),
          Carbon::today()->endOfDay()
          //  Carbon::yesterday()->endOfDay()
        ])
        ->select(
          'invoices.currency',
          // 'assignmentmappings.assignmentgenerate_id',
          DB::raw("DATE_FORMAT(outstandings.created_at, '%Y-%m-%d') as bill_date"),
          DB::raw('SUM(outstandings.AMT) as total_amount')
        )
        ->groupBy('invoices.currency', 'bill_date')
        ->get();

      $billspending15Days = $this->convertusdtoinr($billspending15Daysdata);
          public function exceptionalexpenses(Request $request)
    {
        $filtersdata = $this->filtersRequest($request);

        $yearly = $filtersdata['yearly'];
        $monthsdigit = $filtersdata['monthsdigit'];
        $partnerId = $filtersdata['partnerId'];
        $startDateFormatted = $filtersdata['startDateFormatted'];
        $endDateFormatted = $filtersdata['endDateFormatted'];
        $months = $filtersdata['months'];

        // filter total amount of convence, how many amount approved for convence or Other Expenses
        $outstationData = DB::table('outstationconveyances')
            ->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', '=', 'outstationconveyances.assignmentgenerate_id')
            ->leftjoin('assignments', 'assignments.id', 'outstationconveyances.assignment_id')
            ->leftjoin('clients', 'clients.id', 'outstationconveyances.client_id')
            ->where('outstationconveyances.createdby', '!=', 336)
            // ->where('outstationconveyances.conveyance', 'Local Conveyance')
            ->whereIn('outstationconveyances.conveyance', ['Local Conveyance', 'Outstation Conveyance'])
            ->where('outstationconveyances.status', 6)
            // ->when(empty($yearly) && empty($monthsdigit) && empty($partnerId), function ($query) {
            //     $query->whereMonth('outstationconveyances.paiddate', Carbon::now()->month)
            //         ->whereYear('outstationconveyances.paiddate', Carbon::now()->year);
            // })
            ->when(!empty($yearly), function ($query) use ($startDateFormatted, $endDateFormatted) {
                $query->whereBetween('outstationconveyances.paiddate', [$startDateFormatted, $endDateFormatted]);
            })
            ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
                $query->whereMonth('outstationconveyances.paiddate', $monthsdigit);
            })
            ->when(!empty($partnerId), function ($query) use ($partnerId) {
                $query->where('assignmentmappings.leadpartner', $partnerId);
            })
            ->select('outstationconveyances.*', 'assignmentmappings.leadpartner', 'clients.client_name', 'assignments.assignment_name  as assignmentsname')
            ->get();

        $total1 = $outstationData->sum('finalamount') ?? 0;

        // $outstationDatas = DB::table('outstationconveyances')
        //     ->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', '=', 'outstationconveyances.assignmentgenerate_id')
        //     ->leftjoin('assignments', 'assignments.id', 'outstationconveyances.assignment_id')
        //     ->leftjoin('clients', 'clients.id', 'outstationconveyances.client_id')
        //     ->where('outstationconveyances.conveyance', 'Outstation Conveyance')
        //     ->where('outstationconveyances.createdby', '!=', 336)
        //     ->where('outstationconveyances.status', 6)
        //     // ->when(empty($yearly) && empty($monthsdigit) && empty($partnerId), function ($query) {
        //     //     $query->whereMonth('outstationconveyances.paiddate', Carbon::now()->month)
        //     //         ->whereYear('outstationconveyances.paiddate', Carbon::now()->year);
        //     // })
        //     ->when(!empty($yearly), function ($query) use ($startDateFormatted, $endDateFormatted) {
        //         $query->whereBetween('outstationconveyances.paiddate', [$startDateFormatted, $endDateFormatted]);
        //     })
        //     ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
        //         $query->whereMonth('outstationconveyances.paiddate', $monthsdigit);
        //     })
        //     ->when(!empty($partnerId), function ($query) use ($partnerId) {
        //         $query->where('assignmentmappings.leadpartner', $partnerId);
        //     })
        //     ->select('outstationconveyances.*', 'assignmentmappings.leadpartner', 'clients.client_name', 'assignments.assignment_name  as assignmentsname')
        //     ->get();

        // $total2 = $outstationDatas->sum('finalamount') ?? 0;

        $vendorlist = DB::table('vendorlist')
            ->leftJoin('vendors', 'vendors.id', '=', 'vendorlist.vendor_id')
            // ->leftJoin('vendorlist', 'vendorlist.vendor_id', '=', 'vendors.id')
            ->leftJoin('teammembers', 'teammembers.id', '=', 'vendorlist.approver')
            ->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', '=', 'vendorlist.assignmentgenerate_id')
            ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'vendorlist.assignmentgenerate_id')
            ->leftJoin('assignments', 'assignments.id', '=', 'assignmentbudgetings.assignment_id')
            ->leftJoin('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
            // approved data 
            ->where('vendorlist.status', 1)
            ->when(!empty($yearly), function ($query) use ($startDateFormatted, $endDateFormatted) {
                $query->whereBetween('vendorlist.created_at', [$startDateFormatted, $endDateFormatted]);
            })
            ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
                $query->whereMonth('vendorlist.created_at', $monthsdigit);
            })
            ->when(!empty($partnerId), function ($query) use ($partnerId) {
                $query->where('assignmentmappings.leadpartner', $partnerId);
            })
            ->select(
                'vendorlist.*',
                'vendors.vendorname',
                'teammembers.team_member as approver',
                'assignmentbudgetings.assignmentgenerate_id',
                'assignmentbudgetings.assignmentname',
                'assignmentmappings.leadpartner',
                'assignments.assignment_name',
                'clients.client_name as clientname'
            )
            ->get();

        $total3 = $vendorlist->sum('amount') ?? 0;


        $totalspend = ($total1 ?? 0) + ($total3 ?? 0);

        return view('backEnd.dashboardreport.otherspend', compact('totalspend', 'outstationData', 'vendorlist', 'yearly', 'monthsdigit', 'partnerId', 'startDateFormatted', 'endDateFormatted', 'months'));
    }
        
      foreach ($documentCompletions as $mapping) {
        $assignmentId = $mapping->assignmentgenerate_id;
        $progressData = $this->calculateDocumentationProgress($assignmentId);

        $mapping->eqcr_type_name = $progressData['eqcr_type_name'];
        $mapping->documentation_percentage = $progressData['documentation_percentage'];
      }

       public function calculateDocumentationProgress($assignmentId)
  {
    // Get assignment_id and eqcrapplicability
    $assignmentMapping = DB::table('assignmentmappings')
      ->where('assignmentgenerate_id', $assignmentId)
      ->select('assignment_id', 'eqcrapplicability')
      ->first();

    if (!$assignmentMapping) {
      return [
        'eqcr_type_name' => null,
        'documentation_percentage' => 0,
      ];
    }

    // Determine EQCR type name
    $eqcrTypeName = '';
    $eqcrAssignmentId = null;
    if (isset($assignmentMapping->eqcrapplicability)) {
      switch ($assignmentMapping->eqcrapplicability) {
        case 1:
          $eqcrTypeName = 'NFRA';
          break;
        case 2:
          $eqcrTypeName = 'Quality Review';
          break;
        case 3:
          $eqcrTypeName = 'Peer Review';
          break;
        case 4:
          $eqcrTypeName = 'Others';
          break;
        case 5:
          $eqcrTypeName = 'PCAOB';
          break;
      }
      // Get the assignment_id for the EQCR type
      $specialAssignment = DB::table('assignments')
        ->where('assignment_name', $eqcrTypeName)
        ->first();

      if ($specialAssignment) {
        $eqcrAssignmentId = $specialAssignment->id;
      }
    }

    // Regular Checklist Calculations (Exclude EQCR assignment_id)
    $classificationIds = DB::table('financialstatementclassifications')
      ->where('assignment_id', $assignmentMapping->assignment_id)
      ->where(function ($q) use ($assignmentId) {
        $q->whereNull('assignmentgenerate_id')->orWhere('assignmentgenerate_id', $assignmentId);
      })
      ->when($eqcrAssignmentId, function ($query) use ($eqcrAssignmentId) {
        $query->where('assignment_id', '!=', $eqcrAssignmentId);
      })
      ->pluck('id');

    $subClassIds = DB::table('subfinancialclassfications')
      ->whereIn('financialstatemantclassfication_id', $classificationIds)
      ->pluck('id');

    $totalQuestions = DB::table('auditquestions')
      ->whereIn('financialstatemantclassfication_id', $classificationIds)
      ->whereIn('subclassfied_id', $subClassIds)
      ->count();

    $statusCounts = DB::table('checklistanswers')
      ->join('statuses', 'checklistanswers.status', '=', 'statuses.id')
      ->where('checklistanswers.assignment_id', $assignmentId)
      ->whereIn('checklistanswers.financialstatemantclassfication_id', $classificationIds)
      ->whereIn('checklistanswers.subclassfied_id', $subClassIds)
      ->select(
        'statuses.name as status_name',
        DB::raw('COUNT(*) as count')
      )
      ->groupBy('statuses.name')
      ->pluck('count', 'status_name');



    $closedQuestions = $statusCounts['CLOSE'] ?? 0;

    $documentationPercentage = $totalQuestions > 0
      ? round(($closedQuestions / $totalQuestions) * 100, 2)
      : 0;

    return [
      'eqcr_type_name' => $eqcrTypeName,
      'documentation_percentage' => $documentationPercentage,
    ];
  }

        Illuminate\Support\Collection {#3603 ▼
  #items: array:3 [▼
    0 => {#3635 ▼
      +"id": 571
      +"timesheetid": 571
      +"client_id": 137
      +"assignmentgenerate_id": "CAP100005"
      +"partner": 935
      +"totalhour": "8"
      +"assignment_id": 200
      +"project_id": null
      +"date": "2025-01-02"
      +"job_id": null
      +"workitem": "test"
      +"location": "delhi"
      +"billable_status": null
      +"description": null
      +"status": 2
      +"hour": "8"
      +"createdby": 937
      +"rejectedby": 447
      +"updatedby": null
      +"created_at": "2025-11-07 13:26:19"
      +"updated_at": "2025-11-07 13:26:29"
      +"team_member": "Guneet"
      +"assignmentname": "Assigned Partner Role"
      +"assignmentcreated": "2024-12-15 10:29:52"
      +"final_teamstaffcode": "S1002"
      +"final_partnerstaffcode": "P1078"
    }
    1 => {#3637 ▼
      +"id": 601
      +"timesheetid": 601
      +"client_id": 137
      +"assignmentgenerate_id": "CAP100006"
      +"partner": 951
      +"totalhour": "8"
      +"assignment_id": 201
      +"project_id": null
      +"date": "2025-02-12"
      +"job_id": null
      +"workitem": "test"
      +"location": "delhi"
      +"billable_status": null
      +"description": null
      +"status": 2
      +"hour": "8"
      +"createdby": 937
      +"rejectedby": 447
      +"updatedby": null
      +"created_at": "2025-11-07 14:30:24"
      +"updated_at": "2025-11-07 14:30:58"
      +"team_member": "Guneet"
      +"assignmentname": "Assignment on 11th Feb 25"
      +"assignmentcreated": "2025-02-11 10:29:52"
      +"final_teamstaffcode": "M1086"
      +"final_partnerstaffcode": "P1077"
    }
    2 => {#3640 ▼
      +"id": 602
      +"timesheetid": 602
      +"client_id": 137
      +"assignmentgenerate_id": "CAP100005"
      +"partner": 935
      +"totalhour": "8"
      +"assignment_id": 200
      +"project_id": null
      +"date": "2025-02-13"
      +"job_id": null
      +"workitem": "test"
      +"location": "delhi"
      +"billable_status": null
      +"description": null
      +"status": 2
      +"hour": "8"
      +"createdby": 937
      +"rejectedby": 447
      +"updatedby": null
      +"created_at": "2025-11-07 14:30:24"
      +"updated_at": "2025-11-07 14:30:58"
      +"team_member": "Guneet"
      +"assignmentname": "Assigned Partner Role"
      +"assignmentcreated": "2024-12-15 10:29:52"
      +"final_teamstaffcode": "S1002"
      +"final_partnerstaffcode": "P1078"
    }
  ]
  #escapeWhenCastingToString: false
}
          $attendanceData = [
                'total_no_of_days' => $totalDays,
                'no_of_days_present' => $dayspresentcount,
                'casual_leave' => $casualLeave,
                'exam_leave' => $examLeave,
                'travel' => $travel,
                'offholidays' => $offholidays,
                'sundaycount' => $sunday,
                'holidays' => $holidays,
            ];

            DB::table('attendances')->where('employee_name', $team->employee_name)
                ->where('month', $currentMonth)
                ->where('year', $currentYear)
                ->update($attendanceData);

                
          // Choose the greater date
                    $finalRejoiningDate = $existingDate->greaterThan($newDate) ? $existingDate : $newDate;

                    $finalRejoiningDateWithTime = $finalRejoiningDate->setTimeFrom(Carbon::now());

                    DB::table('rejoiningsamepost')
                        ->where('id', $rejoiningleavedate->id)
                        ->update([
                            'rejoiniedexitdate' => $request->leavingdate,
                            'rejoiningdate' => $finalRejoiningDate->format('Y-m-d'),
                            'created_at' => $finalRejoiningDateWithTime->toDateTimeString(),
                        ]);
        // Start Hare
         // $authteamid = 934;
    // $startdate = '2025-09-29';
    // $enddate = '2025-11-01';

    // $nextweektimesheet1 = DB::table('timesheetusers')
    //   ->where('createdby', $authteamid)
    //   ->whereBetween('date', [$startdate,  $enddate])
    //   ->update(['status' => 0]);
    // // ->get();
    // // ->update(['createdby' => 8471]);
    // // ->delete();

    // $nextweektimesheet2 = DB::table('timesheets')
    //   ->where('created_by', $authteamid)
    //   ->whereBetween('date', [$startdate,  $enddate])
    //   ->update(['status' => 0]);
    // // ->get();
    // // ->update(['created_by' => 8471]);
    // // ->delete();

    // $nextweektimesheet3 = DB::table('timesheetreport')
    //   ->where('teamid', $authteamid)
    //   ->whereBetween('startdate', [$startdate, $enddate])
    //   ->delete();
    // // ->get();
    // // ->update(['teamid' => 8471]);

    // $attendanceexist = DB::table('attendances')
    //   ->where('employee_name', $authteamid)
    //   ->where('month', 'October')
    //   // ->delete();
    //   ->update(['employee_name' => 9341]);

    // dd('successfully done');

    // $tables = [
    //   //* timesheets
    //   'timesheetreport',
    //   'timesheetrequests',
    //   'timesheets',
    //   'timesheetusers',

    //   //* applyleaves
    //   'applyleaves',
    //   'leaveapprove',
    //   'leaverequest',

    //   //* attendances
    //   'attendances',

    //   //* assignments
    //   // 'assignmentbudgetings',
    //   // 'assignmentmappings',
    //   // 'assignmentteammappings',
    //   // 'assignments',

    //   //* another tables
    //   // 'Users',
    //   // 'teammembers',
    //   // 'teamrolehistory',
    //   // 'rejoiningsamepost',
    //   // 'Clients',
    //   // 'independences',
    // ];


    // foreach ($tables as $table) {
    //   if (Schema::hasTable($table)) {
    //     Schema::drop($table);
    //     echo "'{$table}'.<br>";
    //   } else {
    //     echo "'{$table}'.<br>";
    //   }
    // }

    // return response('Tables deleted successfully!', 200);


      public function update(Request $request, $id)
    {
        $request->validate([
            'team_member' => "required"
        ]);

        try {
            DB::beginTransaction();
            $checkuserleavingdate = DB::table('teammembers')
                ->where('id', $id)
                ->first();

            $existingLeavingDate = $checkuserleavingdate->leavingdate ? Carbon::parse($checkuserleavingdate->leavingdate)->format('Y-m-d') : null;
            $inputLeavingDate = $request->leavingdate ? Carbon::parse($request->leavingdate)->format('Y-m-d') : null;

            if ($request->leavingdate != null) {
                // this code will be run in 2 cases like 1. first time exit and second is after rejoin user will exit
                if (is_null($existingLeavingDate) || (!is_null($existingLeavingDate) && !is_null($inputLeavingDate) && $existingLeavingDate !== $inputLeavingDate)) {
                    // update cross sign after exit date of users 
                    $checksavetimesheet = DB::table('timesheetusers')
                        ->where('createdby', $id)
                        ->where('date', '>', $request->leavingdate)
                        ->where('status', 0)
                        // ->delete();
                        ->first();

                    if ($checksavetimesheet) {
                        $output = array('msg' => 'Please delete save timesheet after leaving date');
                        return back()->with('statuss', $output);
                    }

                    // update rejoined exit date
                    if (!is_null($existingLeavingDate) && !is_null($inputLeavingDate) && $existingLeavingDate !== $inputLeavingDate) {
                        // $rejoiningleavedate = DB::table('teamrolehistory')
                        //     ->where('teammember_id', $id)
                        //     ->whereNotNull('rejoiningdate')
                        //     ->first();

                        // if ($rejoiningleavedate) {
                        //     DB::table('teamrolehistory')
                        //         ->where('id', $rejoiningleavedate->id)
                        //         ->update([
                        //             'rejoiniedexitdate' => $request->leavingdate,
                        //             'rejoiningdate' => $request->joining_date,
                        //         ]);
                        // } else {
                        //     DB::table('rejoiningsamepost')
                        //         ->where('teammember_id',  $id)
                        //         ->update([
                        //             'rejoiniedexitdate' => $request->leavingdate,
                        //             'rejoiningdate' => $request->joining_date,
                        //         ]);
                        // }


                        $rejoiningleavedate = DB::table('teamrolehistory')
                            ->where('id', $request->rejoinedId)
                            ->where('teammember_id', $id)
                            ->where('change_type', $request->change_type)
                            ->orderByDesc('id')
                            ->first();

                        if ($rejoiningleavedate) {
                            $existingDate = Carbon::parse($rejoiningleavedate->rejoiningdate);
                            $newDate = Carbon::parse($request->joining_date);

                            // Choose the greater date
                            $finalRejoiningDate = $existingDate->greaterThan($newDate) ? $existingDate : $newDate;

                            DB::table('teamrolehistory')
                                ->where('id', $rejoiningleavedate->id)
                                ->update([
                                    'rejoiniedexitdate' => $request->leavingdate,
                                    'rejoiningdate' => $finalRejoiningDate->format('Y-m-d'),
                                ]);
                        } else {
                            $rejoiningleavedate = DB::table('rejoiningsamepost')
                                ->where('id', $request->rejoinedId)
                                ->where('teammember_id', $id)
                                ->where('change_type', $request->change_type)
                                ->orderByDesc('id')
                                ->first();

                            $existingDate = Carbon::parse($rejoiningleavedate->rejoiningdate);
                            $newDate = Carbon::parse($request->joining_date);

                            // Choose the greater date
                            $finalRejoiningDate = $existingDate->greaterThan($newDate) ? $existingDate : $newDate;

                            DB::table('rejoiningsamepost')
                                ->where('id', $rejoiningleavedate->id)
                                ->update([
                                    'rejoiniedexitdate' => $request->leavingdate,
                                    'rejoiningdate' => $finalRejoiningDate->format('Y-m-d'),
                                ]);
                        }
                    }

                    $exitDate = Carbon::parse($request->leavingdate);
                    $exitMonth = $exitDate->format('F');
                    $exitYear = $exitDate->year;
                    $dayOfExit = $exitDate->day;
                    $totalDaysInExitMonth = $exitDate->daysInMonth;

                    // Attendance delete after leaving date 
                    // $attendencedelete = DB::table('attendances')
                    //     ->where('employee_name', $id)
                    //     ->whereDate('created_at', '>', $request->leavingdate)
                    //     ->delete();

                    // Define month order array
                    $months = [
                        'January',
                        'February',
                        'March',
                        'April',
                        'May',
                        'June',
                        'July',
                        'August',
                        'September',
                        'October',
                        'November',
                        'December'
                    ];

                    // Get the index of the exit month
                    $exitMonthIndex = array_search($exitMonth, $months);

                    // Get months after the exit month
                    $monthsAfterExitMonth = array_slice($months, $exitMonthIndex + 1);
                    // Filter attendance records where the month is after the exit month in the exit year
                    $attendencedelete = DB::table('attendances')
                        ->where('employee_name', $id)
                        ->where('year', $exitYear)
                        ->whereIn('month', $monthsAfterExitMonth)
                        // ->get();
                        ->delete();

                    // Check if the attendance record exists for the exit month
                    $exitmonthattendances = DB::table('attendances')
                        ->where('employee_name', $id)
                        ->where('month', $exitMonth)
                        ->where('year', $exitYear)
                        ->first();

                    // If not, insert a new record
                    if (!$exitmonthattendances) {
                        DB::table('attendances')->insert([
                            'employee_name' => $id,
                            'month' => $exitMonth,
                            'year' => $exitYear,
                            'fulldate' => $exitDate->format('Y-m-d'),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);

                        // Fetch the newly inserted attendance record
                        $exitmonthattendances = DB::table('attendances')
                            ->where('employee_name', $id)
                            ->where('month', $exitMonth)
                            ->where('year', $exitYear)
                            ->first();
                    }

                    // Map day numbers to column names
                    $daysToColumns = [
                        1 => 'one',
                        2 => 'two',
                        3 => 'three',
                        4 => 'four',
                        5 => 'five',
                        6 => 'six',
                        7 => 'seven',
                        8 => 'eight',
                        9 => 'nine',
                        10 => 'ten',
                        11 => 'eleven',
                        12 => 'twelve',
                        13 => 'thirteen',
                        14 => 'fourteen',
                        15 => 'fifteen',
                        16 => 'sixteen',
                        17 => 'seventeen',
                        18 => 'eighteen',
                        19 => 'ninghteen',
                        20 => 'twenty',
                        21 => 'twentyone',
                        22 => 'twentytwo',
                        23 => 'twentythree',
                        24 => 'twentyfour',
                        25 => 'twentyfive',
                        26 => 'twentysix',
                        27 => 'twentyseven',
                        28 => 'twentyeight',
                        29 => 'twentynine',
                        30 => 'thirty',
                        31 => 'thirtyone'
                    ];

                    // Prepare the update data
                    $updateData = [];
                    foreach ($daysToColumns as $day => $column) {
                        if ($day > $dayOfExit && $day <= $totalDaysInExitMonth) {
                            $updateData[$column] = 'X';
                            // $updateData[$column] = null;
                        }
                    }

                    // Update the attendance record
                    if (!empty($updateData)) {
                        DB::table('attendances')
                            ->where('id', $exitmonthattendances->id)
                            ->update($updateData);
                    }
                    // update cross sign after exit date of users end hare 
                    $timesheetsave = DB::table('timesheetusers')
                        ->where('createdby', $id)
                        ->where('status', 0)
                        ->orderBy('date', 'ASC')
                        ->get();


                    // Chunk the $timesheetsave data for one week
                    $weeksData = $timesheetsave->chunk(6);
                    foreach ($weeksData as $weekData) {

                        foreach ($weekData as $timesheet) {
                            $startdate = Carbon::parse($timesheet->date);
                            $nextSaturday = $startdate->copy()->next(Carbon::SATURDAY);

                            $startdateformat = $startdate->format('Y-m-d');
                            $nextSaturdayformat = $nextSaturday->format('Y-m-d');

                            DB::table('timesheetusers')
                                ->where('timesheetid', $timesheet->timesheetid)
                                ->update([
                                    'status' => 1,
                                    'updated_at' => now(),
                                ]);

                            DB::table('timesheets')
                                ->where('id', $timesheet->timesheetid)
                                ->update([
                                    'status' => 1,
                                    'updated_at' => now(),
                                ]);

                            // Attendance code start hare 
                            $hdatess = Carbon::parse($timesheet->date)->format('Y-m-d');
                            $day = Carbon::parse($hdatess)->format('d');
                            $month = Carbon::parse($hdatess)->format('F');
                            $yeardata = Carbon::parse($hdatess)->format('Y');

                            $dates = [
                                '01' => 'one',
                                '02' => 'two',
                                '03' => 'three',
                                '04' => 'four',
                                '05' => 'five',
                                '06' => 'six',
                                '07' => 'seven',
                                '08' => 'eight',
                                '09' => 'nine',
                                '10' => 'ten',
                                '11' => 'eleven',
                                '12' => 'twelve',
                                '13' => 'thirteen',
                                '14' => 'fourteen',
                                '15' => 'fifteen',
                                '16' => 'sixteen',
                                '17' => 'seventeen',
                                '18' => 'eighteen',
                                '19' => 'ninghteen',
                                '20' => 'twenty',
                                '21' => 'twentyone',
                                '22' => 'twentytwo',
                                '23' => 'twentythree',
                                '24' => 'twentyfour',
                                '25' => 'twentyfive',
                                '26' => 'twentysix',
                                '27' => 'twentyseven',
                                '28' => 'twentyeight',
                                '29' => 'twentynine',
                                '30' => 'thirty',
                                '31' => 'thirtyone',
                            ];

                            $column = $dates[$day];

                            // check attendenace record exist or not 
                            $attendances = DB::table('attendances')
                                ->where('employee_name', $timesheet->createdby)
                                ->where('month', $month)
                                ->where('year', $yeardata)
                                ->first();

                            if ($attendances == null) {
                                DB::table('attendances')->insert([
                                    'employee_name' => $timesheet->createdby,
                                    'month' => $month,
                                    'year' => $yeardata,
                                    'fulldate' => $hdatess,
                                    'created_at' => date('Y-m-d H:i:s'),
                                    'updated_at' => date('Y-m-d H:i:s'),
                                ]);
                            }


                            $attendances = DB::table('attendances')
                                ->where('employee_name', $timesheet->createdby)
                                ->where('month', $month)
                                ->where('year', $yeardata)
                                ->first();

                            if ($attendances && property_exists($attendances, $column)) {

                                $client = $timesheet->client_id;
                                $assignmentid = $timesheet->assignment_id;

                                if ($client == 32) {
                                    $updatewording = 'T'; // Travel
                                } elseif ($client == 33 && str_replace(['1st ', '2nd ', '3rd ', '4th ', '5th '], '', $timesheet->workitem) == 'Saturday') {
                                    $updatewording = 'OH'; // Off holidays
                                } elseif ($client == 33) {
                                    $updatewording = 'H'; // Other holidays from calendar
                                } elseif ($assignmentid == 213 && $timesheet->workitem == 'NA') {
                                    $updatewording = null;  //beforjoining data
                                } elseif ($client == 134 && $assignmentid == 215) {
                                    $updatewording = 'CL'; // Casual leave
                                } elseif ($client == 134 && $assignmentid == 214) {
                                    $updatewording = 'EL'; // Exam leave
                                } else {
                                    $updatewording = 'P'; // Default presence
                                }
                            }

                            $totalCountMapping = [
                                'P' => 'no_of_days_present',
                                'CL' => 'casual_leave',
                                'EL' => 'exam_leave',
                                'T' => 'travel',
                                'OH' => 'offholidays',
                                'W' => 'sundaycount',
                                'H' => 'holidays',
                                null => 'beforejoiningcount'
                            ];

                            // Update the total count and attendance record if applicable
                            // if (isset($totalCountMapping[$updatewording])) {
                            //     $totalcountColumn = $totalCountMapping[$updatewording];
                            //     $totalcountupdate = $attendances->$totalcountColumn + 1;

                            //     DB::table('attendances')
                            //         ->where('id', $attendances->id)
                            //         ->update([
                            //             $column => $updatewording,
                            //             $totalcountColumn => $totalcountupdate,
                            //         ]);
                            // }

                            if (isset($totalCountMapping[$updatewording])) {
                                $totalcountColumn = $totalCountMapping[$updatewording];
                                $totalcountupdate = $attendances->$totalcountColumn + 1;

                                if ($totalcountColumn != "exam_leave") {

                                    $iftwotimesheetinday = DB::table('attendances')
                                        ->where('id', $attendances->id)
                                        ->value($column);

                                    if ($iftwotimesheetinday == "P") {
                                        $updatewording = "P";
                                        $totalcountupdate = $attendances->$totalcountColumn + 0;
                                    } elseif ($iftwotimesheetinday == 'T') {
                                        $totalcountupdatetravel = max(0, $attendances->travel - 1); // Subtract 1 but ensure it doesn't go below 0
                                        DB::table('attendances')
                                            ->where('id', $attendances->id)
                                            ->update([
                                                'travel' => $totalcountupdatetravel,
                                            ]);
                                        $updatewording = "P";
                                        $totalcountupdate = $attendances->$totalcountColumn + 1;
                                    }

                                    DB::table('attendances')
                                        ->where('id', $attendances->id)
                                        ->update([
                                            $column => $updatewording,
                                            $totalcountColumn => $totalcountupdate,
                                        ]);
                                }
                            }
                            // Attendance code end hare 
                        }

                        // update sunday data in attendance
                        $prevSunday = $startdate->copy()->previous(Carbon::SUNDAY);
                        $day1 = Carbon::parse($prevSunday)->format('d');
                        $month1 = $prevSunday->format('F');
                        $yeardata = $prevSunday->format('Y');
                        $fulldate = $prevSunday->format('Y-m-d');

                        $numberWords = [
                            '1' => 'one',
                            '2' => 'two',
                            '3' => 'three',
                            '4' => 'four',
                            '5' => 'five',
                            '6' => 'six',
                            '7' => 'seven',
                            '8' => 'eight',
                            '9' => 'nine',
                            '10' => 'ten',
                            '11' => 'eleven',
                            '12' => 'twelve',
                            '13' => 'thirteen',
                            '14' => 'fourteen',
                            '15' => 'fifteen',
                            '16' => 'sixteen',
                            '17' => 'seventeen',
                            '18' => 'eighteen',
                            '19' => 'ninghteen',
                            '20' => 'twenty',
                            '21' => 'twentyone',
                            '22' => 'twentytwo',
                            '23' => 'twentythree',
                            '24' => 'twentyfour',
                            '25' => 'twentyfive',
                            '26' => 'twentysix',
                            '27' => 'twentyseven',
                            '28' => 'twentyeight',
                            '29' => 'twentynine',
                            '30' => 'thirty',
                            '31' => 'thirtyone'
                        ];

                        $dayWord = $numberWords[(int)$day1];

                        $getdateformated = $prevSunday->format('Y-m-d');

                        $getholidaysss = DB::table('holidays')
                            ->where('startdate', '=', $getdateformated)
                            ->orWhere('enddate', '=', $getdateformated)
                            ->first();

                        if ($getholidaysss != null) {
                            $updateddata = 'H';
                        } else {
                            $updateddata = 'W';
                        }

                        $attendances = DB::table('attendances')
                            ->where('employee_name', $timesheet->createdby)
                            ->where('month', $month1)
                            ->where('year', $yeardata)
                            ->first();

                        if ($attendances == null) {
                            DB::table('attendances')->insert([
                                'employee_name' => $timesheet->createdby,
                                'month' => $month1,
                                'year' => $yeardata,
                                'fulldate' => $fulldate,
                                'created_at' => date('Y-m-d H:i:s'),
                                'updated_at' => date('Y-m-d H:i:s'),
                            ]);
                        }

                        $attendances = DB::table('attendances')
                            ->where('employee_name', $timesheet->createdby)
                            ->where('month', $month1)
                            ->where('year', $yeardata)
                            ->first();

                        $totalCountMapping = [
                            'P' => 'no_of_days_present',
                            'CL' => 'casual_leave',
                            'EL' => 'exam_leave',
                            'T' => 'travel',
                            'OH' => 'offholidays',
                            'W' => 'sundaycount',
                            'H' => 'holidays'
                        ];

                        $prevcheck = DB::table('attendances')
                            ->where('employee_name', $timesheet->createdby)
                            ->where('month', $month1)
                            ->where('year', $yeardata)
                            ->whereNotNull($dayWord)
                            ->first();


                        if ($prevcheck == null && isset($totalCountMapping[$updateddata])) {
                            $totalcountColumn = $totalCountMapping[$updateddata];
                            $sundaycountget = DB::table('attendances')
                                ->where('employee_name', $timesheet->createdby)
                                ->where('month', $month1)
                                ->where('year', $yeardata)
                                ->first();

                            if ($sundaycountget) {
                                $totalcountupdate = $sundaycountget->$totalcountColumn + 1;
                                DB::table('attendances')
                                    ->where('id', $sundaycountget->id)
                                    ->update([
                                        $dayWord => $updateddata,
                                        $totalcountColumn => $totalcountupdate,
                                    ]);
                                // $updateddata = $getholidaysss ? 'H' : 'W';
                            }
                        }
                        // update sunday data in attendance end hare

                        // Insert data into the timesheetreport table for the current week
                        $startdate = Carbon::parse($weekData->first()->date);
                        $nextSaturday = $startdate->copy()->next(Carbon::SATURDAY);

                        $startdateformat = $startdate->format('Y-m-d');
                        $nextSaturdayformat = $nextSaturday->format('Y-m-d');

                        $week = date('d-m-Y', strtotime($startdateformat)) . ' to ' . date('d-m-Y', strtotime($nextSaturdayformat));

                        $co = DB::table('timesheetusers')
                            ->where('createdby', $id)
                            ->whereBetween('date', [$startdateformat, $nextSaturdayformat])
                            ->select('partner', DB::raw('SUM(hour) as total_hours'), DB::raw('COUNT(DISTINCT timesheetid) as row_count'))
                            ->groupBy('partner')
                            ->get();
                        // dd($co);

                        foreach ($co as $codata) {
                            DB::table('timesheetreport')->insert([
                                'teamid'       =>     $id,
                                'week'       =>     $week,
                                'totaldays'       =>     $codata->row_count,
                                'totaltime' =>  $codata->total_hours,
                                'partnerid'  => $codata->partner,
                                'startdate'  => $startdateformat,
                                'enddate'  => $nextSaturdayformat,
                                'created_at'                =>      date('y-m-d H:i:s'),
                            ]);
                        }
                    }
                }
            }

            $rejoinExists = DB::table('teamrolehistory')
                ->where('id', $request->rejoinedId)
                ->where('teammember_id', $id)
                // ->whereNotNull('rejoiningdate')
                ->orderByDesc('id')
                ->exists();

            $rejoinSamePostExists = DB::table('rejoiningsamepost')
                ->where('id', $request->rejoinedId)
                ->where('teammember_id', $id)
                // ->whereNotNull('rejoiningdate')
                ->orderByDesc('id')
                ->exists();

            if ($rejoinExists || $rejoinSamePostExists) {
                $data = $request->except(['_token', 'qualification', 'document_file', 'joining_date', 'leavingdate', 'rejoinedId']);
            } else {
                $data = $request->except(['_token', 'qualification', 'document_file', 'rejoinedId']);
            }
            if ($request->hasFile('cancelcheque')) {
                $file = $request->file('cancelcheque');
                $destinationPath = 'backEnd/image/teammember/cancelcheque';
                $name = time() . $file->getClientOriginalName();
                $s = $file->move($destinationPath, $name);
                //  dd($s); die;
                $data['cancelcheque'] = $name;
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
                $file = $request->file('panupload');
                $destinationPath = 'backEnd/image/teammember/panupload';
                $name = time() . $file->getClientOriginalName();
                $s = $file->move($destinationPath, $name);
                //  dd($s); die;
                $data['panupload'] = $name;
            }
            if ($request->hasFile('addressupload')) {
                $file = $request->file('addressupload');
                $destinationPath = 'backEnd/image/teammember/addressupload';
                $name = time() . $file->getClientOriginalName();
                $s = $file->move($destinationPath, $name);
                //  dd($s); die;
                $data['addressupload'] = $name;
            }
            if ($request->hasFile('aadharupload')) {
                $file = $request->file('aadharupload');
                $destinationPath = 'backEnd/image/teammember/aadharupload';
                $name = time() . $file->getClientOriginalName();
                $s = $file->move($destinationPath, $name);
                //  dd($s); die;
                $data['aadharupload'] = $name;
            }

            // Teammember::find($id)->update($data);
            if ($request->leavingdate != null && $request->status == 1) {
                $oldstatusvalue = Teammember::find($id);
                if ($oldstatusvalue->status == 1 && $oldstatusvalue->rejoining_date == null) {
                    $rejoinExists = DB::table('teamrolehistory')
                        ->where('id', $request->rejoinedId)
                        ->where('teammember_id', $id)
                        // ->whereNotNull('rejoiningdate')
                        ->orderByDesc('id')
                        ->exists();

                    $rejoinSamePostExists = DB::table('rejoiningsamepost')
                        ->where('id', $request->rejoinedId)
                        ->where('teammember_id', $id)
                        // ->whereNotNull('rejoiningdate')
                        ->orderByDesc('id')
                        ->exists();

                    if ($rejoinExists || $rejoinSamePostExists) {
                        $data = $request->except(['_token', 'qualification', 'document_file', 'joining_date', 'leavingdate', 'rejoinedId']);
                    } else {
                        $data = $request->except(['_token', 'qualification', 'document_file', 'rejoinedId']);
                    }
                    // $data = $request->except(['_token', 'qualification', 'document_file', 'rejoinedId']);
                    $emilid = $data['emailid'];
                    if (is_null($existingLeavingDate) || (!is_null($existingLeavingDate) && !is_null($inputLeavingDate) && $existingLeavingDate !== $inputLeavingDate)) {
                        if (!is_null($existingLeavingDate) && !is_null($inputLeavingDate) && $existingLeavingDate !== $inputLeavingDate) {

                            $rejoinExists = DB::table('teamrolehistory')
                                ->where('id', $request->rejoinedId)
                                ->where('teammember_id', $id)
                                ->where('change_type', $request->change_type)
                                // ->whereNotNull('rejoiningdate')
                                ->orderByDesc('id')
                                ->exists();

                            $rejoinSamePostExists = DB::table('rejoiningsamepost')
                                ->where('id', $request->rejoinedId)
                                ->where('teammember_id', $id)
                                ->where('change_type', $request->change_type)
                                // ->whereNotNull('rejoiningdate')
                                ->orderByDesc('id')
                                ->exists();

                            if ($rejoinExists || $rejoinSamePostExists) {
                                $data = $request->except(['_token', 'qualification', 'document_file', 'joining_date', 'leavingdate', 'rejoinedId']);
                            } else {

                                $data = $request->except(['_token', 'qualification', 'document_file', 'status', 'leavingdate', 'rejoinedId']);
                            }
                        } else {
                            $data = $request->except(['_token', 'qualification', 'document_file', 'status', 'rejoinedId']);
                        }
                        $data['status'] = '0';
                        DB::table('users')->where('email', $emilid)->update([
                            'status'         =>  0,
                            'remember_token' => null
                        ]);
                    }
                    Teammember::find($id)->update($data);
                } else {
                    $rejoinExists = DB::table('teamrolehistory')
                        ->where('id', $request->rejoinedId)
                        ->where('teammember_id', $id)
                        // ->whereNotNull('rejoiningdate')
                        ->orderByDesc('id')
                        ->exists();

                    $rejoinSamePostExists = DB::table('rejoiningsamepost')
                        ->where('id', $request->rejoinedId)
                        ->where('teammember_id', $id)
                        // ->whereNotNull('rejoiningdate')
                        ->orderByDesc('id')
                        ->exists();

                    if ($rejoinExists || $rejoinSamePostExists) {
                        $data = $request->except(['_token', 'qualification', 'document_file', 'joining_date', 'leavingdate', 'rejoinedId']);
                    }
                    // $data = $request->except(['_token', 'qualification', 'document_file', 'rejoinedId']);
                    $emilid = $data['emailid'];
                    Teammember::find($id)->update($data);
                    $oldstatususer = User::where('email', $emilid)->first();
                    if ($oldstatususer->status == 0) {
                        DB::table('users')->where('email', $emilid)->update([
                            'status'         =>  1,
                        ]);
                    }
                }
            } else {
                Teammember::find($id)->update($data);
            }

            if ($request->document_file != null) {
                $qualifications = $request->qualification;
                $documentFiles = $request->document_file;

                for ($i = 0; $i < count($qualifications); $i++) {
                    // Process each qualification and document file entry
                    $documentFile = $documentFiles[$i];
                    if ($documentFile) {
                        $original_file = $documentFile->getClientOriginalName();
                        $documentFileName = time() . $documentFile->getClientOriginalName();
                        $documentFilePath = 'backEnd/image/teammember/document_file';
                        $documentFile->move($documentFilePath, $documentFileName);

                        DB::table('teammember_document_files')->insert([
                            'teamember_id' => $id,
                            'qualification' => $qualifications[$i],
                            'document_file' => $documentFileName,
                            'original_file' => $original_file,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }

            DB::table('users')->where('teammember_id', $id)->update([
                'role_id'         =>  $request->role_id,
                'email'         =>  $request->emailid,
            ]);
            $actionName = class_basename($request->route()->getActionname());
            $pagename = substr($actionName, 0, strpos($actionName, "Controller"));
            $id = auth()->user()->teammember_id;
            DB::table('activitylogs')->insert([
                'user_id' => $id,
                'ip_address' => $request->ip(),
                'activitytitle' => $pagename,
                'description' => ' Team Member Data Edit' . ' ' . '( ' . $request->team_member . ' )',
                'created_at' => date('y-m-d'),
                'updated_at' => date('y-m-d')
            ]);

            DB::commit();
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

  $rejoiningleavedate = DB::table('teamrolehistory')
                            ->where('id', $request->rejoinedId)
                            ->where('teammember_id', $id)
                            ->where('change_type', $request->change_type)
                            ->orderByDesc('id')
                            ->first();

                        if ($rejoiningleavedate) {
                            $existingDate = Carbon::parse($rejoiningleavedate->rejoiningdate);
                            $newDate = Carbon::parse($request->joining_date);

                            // Choose the greater date
                            $finalRejoiningDate = $existingDate->greaterThan($newDate) ? $existingDate : $newDate;

                            DB::table('teamrolehistory')
                                ->where('id', $rejoiningleavedate->id)
                                ->update([
                                    'rejoiniedexitdate' => $request->leavingdate,
                                    'rejoiningdate' => $finalRejoiningDate->format('Y-m-d'),
                                ]);
                        } else {
                            $rejoiningleavedate = DB::table('rejoiningsamepost')
                                ->where('id', $request->rejoinedId)
                                ->where('teammember_id', $id)
                                ->where('change_type', $request->change_type)
                                ->orderByDesc('id')
                                ->first();

                            $existingDate = Carbon::parse($rejoiningleavedate->rejoiningdate);
                            $newDate = Carbon::parse($request->joining_date);

                            // Choose the greater date
                            $finalRejoiningDate = $existingDate->greaterThan($newDate) ? $existingDate : $newDate;

                            DB::table('rejoiningsamepost')
                                ->where('id', $rejoiningleavedate->id)
                                ->update([
                                    'rejoiniedexitdate' => $request->leavingdate,
                                    'rejoiningdate' => $finalRejoiningDate->format('Y-m-d'),
                                ]);
                        }
     @php
                    // dd($teammember->id);
                    $rejoineduser1 = DB::table('teamrolehistory')
                        ->where('teammember_id', $teammember->id)
                        ->whereIn('change_type', ['rejoining_other_post', 'rejoining_same_post', 'promotion'])
                        ->orderByDesc('id')
                        ->select(
                            'id',
                            'teammember_id',
                            'created_at as rejoiningdate',
                            'rejoiniedexitdate',
                            'change_type',
                        )
                        ->first();

                    if (!$rejoineduser1) {
                        $rejoineduser2 = DB::table('rejoiningsamepost')
                            ->where('teammember_id', $teammember->id)
                            ->where('change_type', 'rejoining_same_post')
                            ->orderByDesc('id')
                            ->select('id', 'teammember_id', 'rejoiningdate', 'rejoiniedexitdate', 'change_type')
                            ->first();
                    }

                    if (!$rejoineduser1 && !$rejoineduser2) {
                        $normaluser = DB::table('teammembers')
                            ->where('id', $teammember->id)
                            ->select('joining_date as rejoiningdate', 'leavingdate as rejoiniedexitdate', 'change_type')
                            ->first();
                    }

                    $latestteamrolehistory = DB::table('teamrolehistory as teamrolehistorydata')
                        ->select(
                            'teamrolehistorydata.id',
                            'teamrolehistorydata.teammember_id',
                            'teamrolehistorydata.created_at as rejoiningdate',
                            'teamrolehistorydata.rejoiniedexitdate',
                            'teamrolehistorydata.change_type',
                        )
                        ->whereRaw(
                            'teamrolehistorydata.id = (SELECT MAX(teamrolehistorylatest.id) FROM teamrolehistory as teamrolehistorylatest WHERE teamrolehistorylatest.teammember_id = teamrolehistorydata.teammember_id)',
                        );

                    $latestrejoiningsamepost = DB::table('rejoiningsamepost as rejoiningsamepostdata')
                        ->select(
                            'rejoiningsamepostdata.id',
                            'rejoiningsamepostdata.teammember_id',
                            'rejoiningsamepostdata.rejoiningdate',
                            'rejoiningsamepostdata.rejoiniedexitdate',
                            'rejoiningsamepostdata.change_type',
                        )
                        ->whereRaw(
                            'rejoiningsamepostdata.id = (SELECT MAX(rejoiningsamepostlatest.id) FROM rejoiningsamepost as rejoiningsamepostlatest WHERE rejoiningsamepostlatest.teammember_id = rejoiningsamepostdata.teammember_id)',
                        );

                    $rejoiningUser = DB::table('teammembers')
                        ->where('teammembers.id', $teammember->id)
                        ->leftJoinSub($latestteamrolehistory, 'latestrecord', function ($join) {
                            $join->on('latestrecord.teammember_id', '=', 'teammembers.id');
                        })
                        ->leftJoinSub($latestrejoiningsamepost, 'latestrecord2', function ($join) {
                            $join->on('latestrecord2.teammember_id', '=', 'teammembers.id');
                        })
                        ->select([
                            'teammembers.*',
                            DB::raw(
                                'COALESCE(latestrecord.rejoiniedexitdate, latestrecord2.rejoiniedexitdate, teammembers.leavingdate) AS final_leavingdate',
                            ),
                            DB::raw(
                                'COALESCE(latestrecord.rejoiningdate, latestrecord2.rejoiningdate, teammembers.joining_date) AS final_joiningdate',
                            ),
                        ])
                        ->first();
                @endphp

  public function mytimesheetlist(Request $request, $teamid)
  {

    if (auth()->user()->role_id == 13) {
      $timesheetData = DB::table('timesheetusers')
        ->leftJoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'timesheetusers.assignmentgenerate_id')
        ->leftJoin('clients', 'clients.id', 'timesheetusers.client_id')
        ->leftJoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
        ->leftJoin('teammembers as patnerid', 'patnerid.id', 'timesheetusers.partner')
        ->where('timesheetusers.createdby', $teamid)
        ->whereIn('timesheetusers.status', [1, 2, 3])
        ->whereNotNull('timesheetusers.date')
        ->select(
          'timesheetusers.*',
          'assignments.assignment_name',
          'clients.client_name',
          'clients.client_code',
          'teammembers.team_member',
          'teammembers.staffcode',
          'patnerid.team_member as patnername',
          'patnerid.staffcode as patnerstaffcodee',
          'assignmentbudgetings.assignmentname',
          'assignmentbudgetings.created_at as assignmentcreated'
        )
        ->orderBy('timesheetusers.date', 'DESC')
        ->limit(7)
        ->get();

      $timesheetData = $this->promotionOrRejoined($timesheetData);
    } else {
      $timesheetData = DB::table('timesheetusers')
        ->leftJoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'timesheetusers.assignmentgenerate_id')
        ->leftJoin('clients', 'clients.id', 'timesheetusers.client_id')
        ->leftJoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
        ->leftJoin('teammembers as patnerid', 'patnerid.id', 'timesheetusers.partner')
        ->where('timesheetusers.createdby', $teamid)
        ->whereIn('timesheetusers.status', [1, 2, 3])
        ->whereNotNull('timesheetusers.date')
        ->select(
          'timesheetusers.*',
          'assignments.assignment_name',
          'clients.client_name',
          'clients.client_code',
          'teammembers.team_member',
          'teammembers.staffcode',
          'patnerid.team_member as patnername',
          'patnerid.staffcode as patnerstaffcodee',
          'assignmentbudgetings.assignmentname',
          'assignmentbudgetings.created_at as assignmentcreated'
        )
        ->orderBy('timesheetusers.date', 'DESC')
        ->limit(7)
        ->get();

      $timesheetData = $this->promotionOrRejoined($timesheetData);
    }
    session()->forget('_old_input');
    return view('backEnd.timesheet.timesheetdownload', compact('timesheetData'));
  }

          public function index()
    {

        if (auth()->user()->role_id == 11 || auth()->user()->role_id == 18) {
            $timesheetrequestsDatas = DB::table('timesheetrequests')
                ->leftjoin('clients', 'clients.id', 'timesheetrequests.client_id')
                ->leftjoin('assignments', 'assignments.id', 'timesheetrequests.assignment_id')
                ->leftjoin('teammembers', 'teammembers.id', 'timesheetrequests.partner')
                ->leftjoin('teammembers as createdby', 'createdby.id', 'timesheetrequests.createdby')
                ->select(
                    'timesheetrequests.*',
                    'clients.client_name',
                    'clients.client_code',
                    'assignments.assignment_name',
                    'teammembers.team_member',
                    // 'teammembers.staffcode',
                    'createdby.team_member as createdbyauth',
                    // 'createdby.staffcode as staffcodeid',
                )->get();

            $timesheetrequestsDatas = $timesheetrequestsDatas->map(function ($item) {
                $item->teamstaffcode = $this->getStaffCodeAt($item->createdby, $item->created_at);
                $item->partnerstaffcode = $this->getStaffCodeAt($item->partner, $item->created_at);
                return $item;
            });


            //  dd($timesheetrequestsDatas);
            return view('backEnd.timesheetrequest.index', compact('timesheetrequestsDatas'));
        } elseif (auth()->user()->role_id == 13) {
            // die;
            $mytimesheetrequest = DB::table('timesheetrequests')
                ->leftjoin('clients', 'clients.id', 'timesheetrequests.client_id')
                ->leftjoin('assignments', 'assignments.id', 'timesheetrequests.assignment_id')
                ->leftjoin('teammembers', 'teammembers.id', 'timesheetrequests.partner')
                ->leftjoin('teammembers as createdby', 'createdby.id', 'timesheetrequests.createdby')
                ->where('timesheetrequests.createdby', auth()->user()->teammember_id)
                ->select(
                    'timesheetrequests.*',
                    'clients.client_name',
                    'clients.client_code',
                    'assignments.assignment_name',
                    'teammembers.team_member',
                    'createdby.team_member as createdbyauth',
                )
                ->orderBy('timesheetrequests.created_at', 'DESC')
                ->get();

            $mytimesheetrequest = $mytimesheetrequest->map(function ($item) {
                $item->teamstaffcode = $this->getStaffCodeAt($item->createdby, $item->created_at);
                $item->partnerstaffcode = $this->getStaffCodeAt($item->partner, $item->created_at);
                return $item;
            });

            $hasopenRequests = $mytimesheetrequest->contains('status', 0);

            $teamtimesheetrequest = DB::table('timesheetrequests')
                ->leftjoin('clients', 'clients.id', 'timesheetrequests.client_id')
                ->leftjoin('assignments', 'assignments.id', 'timesheetrequests.assignment_id')
                ->leftjoin('teammembers', 'teammembers.id', 'timesheetrequests.partner')
                ->leftjoin('teammembers as createdby', 'createdby.id', 'timesheetrequests.createdby')
                ->where('timesheetrequests.partner', auth()->user()->teammember_id)
                // ->orwhere('timesheetrequests.createdby', auth()->user()->teammember_id)
                ->select(
                    'timesheetrequests.*',
                    'clients.client_name',
                    'clients.client_code',
                    'assignments.assignment_name',
                    'teammembers.team_member',
                    'createdby.team_member as createdbyauth',
                )
                ->orderBy('timesheetrequests.created_at', 'DESC')
                ->get();

            $teamtimesheetrequest = $teamtimesheetrequest->map(function ($item) {
                $item->teamstaffcode = $this->getStaffCodeAt($item->createdby, $item->created_at);
                $item->partnerstaffcode = $this->getStaffCodeAt($item->partner, $item->created_at);
                return $item;
            });

            return view('backEnd.timesheetrequest.teamtimesheetrequest', compact('teamtimesheetrequest', 'mytimesheetrequest', 'hasopenRequests'));
        } else {
            $mytimesheetrequest = DB::table('timesheetrequests')
                ->leftjoin('clients', 'clients.id', 'timesheetrequests.client_id')
                ->leftjoin('assignments', 'assignments.id', 'timesheetrequests.assignment_id')
                ->leftjoin('teammembers', 'teammembers.id', 'timesheetrequests.partner')
                ->leftjoin('teammembers as createdby', 'createdby.id', 'timesheetrequests.createdby')
                ->where('timesheetrequests.createdby', auth()->user()->teammember_id)
                ->select(
                    'timesheetrequests.*',
                    'clients.client_name',
                    'clients.client_code',
                    'assignments.assignment_name',
                    'teammembers.team_member',
                    'createdby.team_member as createdbyauth',
                )
                ->orderBy('timesheetrequests.created_at', 'DESC')
                ->get();

            $mytimesheetrequest = $mytimesheetrequest->map(function ($item) {
                $item->teamstaffcode = $this->getStaffCodeAt($item->createdby, $item->created_at);
                $item->partnerstaffcode = $this->getStaffCodeAt($item->partner, $item->created_at);
                return $item;
            });

            $hasopenRequests = $mytimesheetrequest->contains('status', 0);

            $teamtimesheetrequest = DB::table('timesheetrequests')
                ->leftjoin('clients', 'clients.id', 'timesheetrequests.client_id')
                ->leftjoin('assignments', 'assignments.id', 'timesheetrequests.assignment_id')
                ->leftjoin('teammembers', 'teammembers.id', 'timesheetrequests.partner')
                ->leftjoin('teammembers as createdby', 'createdby.id', 'timesheetrequests.createdby')
                ->where('timesheetrequests.partner', auth()->user()->teammember_id)
                // ->orwhere('timesheetrequests.createdby', auth()->user()->teammember_id)
                ->select(
                    'timesheetrequests.*',
                    'clients.client_name',
                    'assignments.assignment_name',
                    'teammembers.team_member',
                    'createdby.team_member as createdbyauth',
                )
                ->orderBy('timesheetrequests.created_at', 'DESC')
                ->get();

            $teamtimesheetrequest = $teamtimesheetrequest->map(function ($item) {
                $item->teamstaffcode = $this->getStaffCodeAt($item->createdby, $item->created_at);
                $item->partnerstaffcode = $this->getStaffCodeAt($item->partner, $item->created_at);
                return $item;
            });

            return view('backEnd.timesheetrequest.teamtimesheetrequest', compact('mytimesheetrequest', 'teamtimesheetrequest', 'hasopenRequests'));
        }
    }
         public function index()
  {
    $permotioncheck = DB::table('teamrolehistory')
      ->where('teammember_id', auth()->user()->teammember_id)
      ->orderByDesc('id')
      ->first();
    // dd($permotioncheck);
    $currentdate = date('Y-m-d');
    $currentYear = date('Y');
    $financialYearStart = $currentYear . '-04-01';
    $financialYearEnd = ($currentYear + 1) . '-03-31';

    $casualteam = DB::table('teammembers')->where('id', auth()->user()->teammember_id)->first();

    $birthday = DB::table('leavetypes')
      ->where('year', $currentYear)->where('name', 'Birthday/Religious Festival')->first();
    $Casual = DB::table('leavetypes')->where('year', $currentYear)->where('name', 'Casual Leave')->first();
    $Sick = DB::table('leavetypes')->where('year', $currentYear)->where('name', 'Sick Leave')->first();
    //  dd($casualteam);
    if ($casualteam->joining_date < $Casual->startdate) {

      $to = \Carbon\Carbon::createFromFormat('Y-m-d', $Casual->startdate);
    } else {
      $to = \Carbon\Carbon::createFromFormat('Y-m-d', $casualteam->joining_date);
    }

    $diff_in_months = $to->diffInMonths($currentdate) + 1;
    if (\Carbon\Carbon::createFromFormat('Y-m-d', $casualteam->joining_date)->diffInDays($currentdate) < 90) {
      $diff_in_months = 0;
    }
    //dd($diff_in_months);
    $teamdate = \Carbon\Carbon::createFromFormat('Y-m-d', $casualteam->joining_date);
    //   $currentdate = date('Y-m-d');
    $teammonthcount = $teamdate->diffInMonths($currentdate) + 1;
    if ($teamdate->diffInDays($currentdate) < 90) {
      $teammonthcount = 0;
    }

    if (auth()->user()->teammember_id == 434 || auth()->user()->teammember_id == 429) {
      $teammember = Teammember::with('role:id,rolename')
        ->whereNotNull('joining_date')
        ->get();




      $appliedSick = DB::table('applyleaves')
        ->where('status', '!=', '2')
        ->where('leavetype', $Sick->id)
        ->where('createdby', auth()->user()->teammember_id)
        ->whereBetween('created_at', [$financialYearStart, $financialYearEnd])
        ->get();

      $countSick = 0;

      foreach ($appliedSick as $sickLeave) {
        $fromDate = \Carbon\Carbon::createFromFormat('Y-m-d', $sickLeave->from);
        $toDate = \Carbon\Carbon::createFromFormat('Y-m-d', $sickLeave->to);
        $period = CarbonPeriod::create($fromDate, $toDate);

        $datess = [];
        foreach ($period as $date) {
          $datess[] = $date->format('Y-m-d');
        }

        $getholidays = DB::table('holidays')->where('startdate', '>=', $toDate)
          ->where('enddate', '<=', $toDate)->select('startdate')->get();

        $hdatess = [];
        foreach ($getholidays as $date) {
          $hdatess[] = date('Y-m-d', strtotime($date->startdate));
        }

        $countSick = array_diff($datess, $hdatess);
      }

      $countSick = DB::table('leaveapprove')
        ->where('year', $currentYear)->where('leavetype', $Sick->id)
        ->where('teammemberid', auth()->user()->teammember_id)->sum('totaldays');
      //  dd($countSick);
      $countCasual = DB::table('leaveapprove')
        ->where('year', $currentYear)->where('leavetype', $Casual->id)
        ->where('teammemberid', auth()->user()->teammember_id)->sum('totaldays');

      $countCasualafmnth = DB::table('leaveapprove')
        ->where('year', $currentYear)
        ->where('leavetype', $Casual->id)
        ->where('teammemberid', auth()->user()->teammember_id)
        ->where('created_at', '>', Carbon::createFromFormat('Y-m-d', $casualteam->joining_date)->addMonths(3))->sum('totaldays');

      $countbirthday = DB::table('leaveapprove')
        ->where('year', $currentYear)->where('leavetype', $birthday->id)
        ->where('teammemberid', auth()->user()->teammember_id)->sum('totaldays');

      //dd($countSick);
      $totalcountCasual = $Casual->noofdays * $diff_in_months;
      // dd($totalcountCasual);
      //  dd($countCasualafmnth);
      $teamapplyleaveDatas  = DB::table('applyleaves')
        ->leftjoin('leavetypes', 'leavetypes.id', 'applyleaves.leavetype')
        ->leftjoin('teammembers', 'teammembers.id', 'applyleaves.createdby')
        ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
        ->select('applyleaves.*', 'teammembers.team_member', 'roles.rolename', 'leavetypes.name')->get();
      // dd($applyleaveDatas);
      return view('backEnd.applyleave.teamapplication', compact(
        'teammember',
        'countCasualafmnth',
        'teammonthcount',
        'totalcountCasual',
        'teamapplyleaveDatas',
        'birthday',
        'countbirthday',
        'Casual',
        'Sick',
        'countSick',
        'countCasual'
      ));
    } elseif (auth()->user()->role_id == 11) {
      session()->forget('_old_input');
      $teammember = Teammember::with('role:id,rolename')
        ->whereNotNull('joining_date')
        ->get();

      $appliedSick = DB::table('applyleaves')
        ->where('status', '!=', '2')
        ->where('leavetype', $Sick->id)
        ->where('createdby', auth()->user()->teammember_id)
        ->whereBetween('created_at', [$financialYearStart, $financialYearEnd])
        ->get();

      $countSick = 0;
      $datess = [];
      $hdatess = [];
      foreach ($appliedSick as $sickLeave) {
        $fromDate = \Carbon\Carbon::createFromFormat('Y-m-d', $sickLeave->from);
        $toDate = \Carbon\Carbon::createFromFormat('Y-m-d', $sickLeave->to);
        $period = CarbonPeriod::create($fromDate, $toDate);


        foreach ($period as $date) {
          $datess[] = $date->format('Y-m-d');
        }

        $getholidays = DB::table('holidays')->get();


        foreach ($getholidays as $date) {
          $hdatess[] = date('Y-m-d', strtotime($date->startdate));
        }
        $datess = array_unique($datess);
      }
      $countSick = count(array_diff($datess, $hdatess));


      $appliedCasual = DB::table('applyleaves')
        ->where('status', '!=', '2')
        ->where('leavetype', $Casual->id)
        ->where('createdby', auth()->user()->teammember_id)
        ->whereBetween('created_at', [$financialYearStart, $financialYearEnd])
        ->get();

      $countCasual = 0;
      $casualDates = [];
      foreach ($appliedCasual as $CasualLeave) {

        $fromDate = \Carbon\Carbon::createFromFormat('Y-m-d', $CasualLeave->from);
        $toDate = \Carbon\Carbon::createFromFormat('Y-m-d', $CasualLeave->to);
        $period = CarbonPeriod::create($fromDate, $toDate);


        foreach ($period as $date) {
          $casualDates[] = $date->format('Y-m-d');
        }

        $getholidays = DB::table('holidays')->get();

        $hdatess = [];
        foreach ($getholidays as $date) {
          $hdatess[] = date('Y-m-d', strtotime($date->startdate));
        }
        $casualDates = array_unique($casualDates);
      }
      $countCasual = count(array_diff($casualDates, $hdatess));

      $appliedCasualafmnth = DB::table('applyleaves')
        ->where('status', '!=', '2')
        ->where('leavetype', $Casual->id)
        ->where('createdby', auth()->user()->teammember_id)
        ->whereBetween('created_at', [$financialYearStart, $financialYearEnd])
        ->where('created_at', '>', Carbon::createFromFormat('Y-m-d', $casualteam->joining_date)->addDays(90))
        ->get();

      $countCasualafmnth = 0;
      $CasualafmnthDates = [];
      foreach ($appliedCasualafmnth as $CasualafmnthLeave) {

        $fromDate = \Carbon\Carbon::createFromFormat('Y-m-d', $CasualafmnthLeave->from);
        $toDate = \Carbon\Carbon::createFromFormat('Y-m-d', $CasualafmnthLeave->to);
        $period = CarbonPeriod::create($fromDate, $toDate);


        foreach ($period as $date) {
          $CasualafmnthDates[] = $date->format('Y-m-d');
        }

        $getholidays = DB::table('holidays')->get();

        $hdatess = [];
        foreach ($getholidays as $date) {
          $hdatess[] = date('Y-m-d', strtotime($date->startdate));
        }
        $CasualafmnthDates = array_unique($CasualafmnthDates);
      }
      $countCasualafmnth = count(array_diff($CasualafmnthDates, $hdatess));





      $appliedbirthday = DB::table('applyleaves')
        ->where('status', '!=', '2')
        ->where('leavetype', $birthday->id)
        ->where('createdby', auth()->user()->teammember_id)
        ->whereBetween('created_at', [$financialYearStart, $financialYearEnd])
        ->get();
      $countbirthday = 0;
      $birthdayDates = [];
      foreach ($appliedbirthday as $birthdayLeave) {

        $fromDate = \Carbon\Carbon::createFromFormat('Y-m-d', $birthdayLeave->from);
        $toDate = \Carbon\Carbon::createFromFormat('Y-m-d', $birthdayLeave->to);
        $period = CarbonPeriod::create($fromDate, $toDate);


        foreach ($period as $date) {
          $birthdayDates[] = $date->format('Y-m-d');
        }

        $getholidays = DB::table('holidays')->get();

        $hdatess = [];
        foreach ($getholidays as $date) {
          $hdatess[] = date('Y-m-d', strtotime($date->startdate));
        }
        $birthdayDates = array_unique($birthdayDates);
      }
      $countbirthday = count(array_diff($birthdayDates, $hdatess));

      //dd($diff_in_months);
      $totalcountCasual = $Casual->noofdays * $diff_in_months;
      //  dd($diff_in_months);

      //  dd($countCasualafmnth);
      $leavetaken = DB::table('leaveapprove')
        ->where('year', '2023')->where('teammemberid', auth()->user()->teammember_id)->sum('totaldays');

      $myapplyleaveDatas = DB::table('applyleaves')
        ->leftjoin('leavetypes', 'leavetypes.id', 'applyleaves.leavetype')
        ->leftjoin('teammembers', 'teammembers.id', 'applyleaves.createdby')
        ->leftjoin('teammembers as partner', 'partner.id', 'applyleaves.approver')
        ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
        ->where('applyleaves.createdby', auth()->user()->teammember_id)
        ->select('applyleaves.*', 'teammembers.team_member', 'roles.rolename', 'leavetypes.name', 'partner.team_member as partnername')
        ->latest()
        ->get();

      $myapplyleaveDatas = $myapplyleaveDatas->map(function ($item) {
        $item->teamstaffcode = $this->getStaffCodeAt($item->createdby, $item->created_at);
        $item->partnerstaffcode = $this->getStaffCodeAt($item->approver, $item->created_at);
        return $item;
      });



      $columns = ['one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'ninghteen', 'twenty', 'twentyone', 'twentytwo', 'twentythree', 'twentyfour', 'twentyfive', 'twentysix', 'twentyseven', 'twentyeight', 'twentynine', 'thirty', 'thirtyone'];
      $attendance = DB::table('attendances')
        ->where('employee_name', auth()->user()->teammember_id)
        ->whereBetween('created_at', [$financialYearStart, $financialYearEnd])
        ->get();

      $clInAttendance = 0;
      $slInAttendance = 0;
      //dd($attendance);
      foreach ($attendance as $item) {
        foreach ($columns as $column) {
          if ($item->$column === 'CL/C' || $item->$column === 'CL/A') {
            $clInAttendance++;
          }
          if ($item->$column === 'SL/C' || $item->$column === 'SL/A') {
            $slInAttendance++;
          }
        }
      }

      $role_id = auth()->user()->teammember_id;

      // $teamapplyleaveDatas  = DB::table('applyleaves')
      //   ->leftjoin('leavetypes', 'leavetypes.id', 'applyleaves.leavetype')
      //   ->leftjoin('teammembers', 'teammembers.id', 'applyleaves.createdby')
      //   ->leftJoin('teamrolehistory as teamrolehistoryteam', function ($join) {
      //     $join->on('teamrolehistoryteam.teammember_id', '=', 'applyleaves.createdby')
      //       ->on('teamrolehistoryteam.created_at', '<', 'applyleaves.created_at');
      //   })
      //   ->leftJoin('teammembers as approvername', 'approvername.id', '=', 'applyleaves.approver')
      //   ->leftJoin('teamrolehistory', function ($join) {
      //     $join->on('teamrolehistory.teammember_id', '=', 'approvername.id')
      //       ->on('teamrolehistory.created_at', '<', 'applyleaves.created_at');
      //   })
      //   ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
      //   // ->where('applyleaves.status', 0)
      //   // ->where('teammembers.id', 835)
      //   ->select('applyleaves.*', 'teammembers.team_member', 'teammembers.staffcode', 'teammembers.emailid', 'roles.rolename', 'leavetypes.name', 'approvername.team_member as approvernames', 'approvername.staffcode as approverstaffcode', 'teamrolehistory.newstaff_code', 'teamrolehistoryteam.newstaff_code as teamnewstaffcode')
      //   // ->take(7)
      //   ->get(); //apppp


      $teamapplyleaveDatas  = DB::table('applyleaves')
        ->leftjoin('leavetypes', 'leavetypes.id', 'applyleaves.leavetype')
        ->leftjoin('teammembers', 'teammembers.id', 'applyleaves.createdby')
        ->leftjoin('teammembers as partner', 'partner.id', 'applyleaves.approver')
        ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
        ->select('applyleaves.*', 'teammembers.team_member', 'teammembers.emailid', 'roles.rolename', 'leavetypes.name', 'partner.team_member as partnername')
        ->latest()
        ->get();

      $teamapplyleaveDatas = $teamapplyleaveDatas->map(function ($item) {
        $item->teamstaffcode = $this->getStaffCodeAt($item->createdby, $item->created_at);
        $item->partnerstaffcode = $this->getStaffCodeAt($item->approver, $item->created_at);
        return $item;
      });

      $teamapplyleaveDatasfilter  = DB::table('applyleaves')
        ->leftjoin('leavetypes', 'leavetypes.id', 'applyleaves.leavetype')
        ->leftjoin('teammembers', 'teammembers.id', 'applyleaves.createdby')
        ->leftJoin('roles', 'roles.id', '=', 'teammembers.role_id')
        ->leftJoin(DB::raw('
          (SELECT teammember_id, newstaff_code 
           FROM teamrolehistory 
           WHERE created_at = (SELECT MAX(created_at) 
                               FROM teamrolehistory th2 
                               WHERE th2.teammember_id = teamrolehistory.teammember_id)
          ) AS teamrolehistory
      '), function ($join) {
          $join->on('teamrolehistory.teammember_id', '=', 'teammembers.id');
        })
        // ->where('applyleaves.status', 0)
        ->select('applyleaves.*', 'teammembers.team_member', 'teammembers.staffcode', 'teammembers.emailid', 'roles.rolename', 'leavetypes.name', 'teamrolehistory.newstaff_code')
        ->distinct()
        ->get();

      $hasPendingRequests = $teamapplyleaveDatas->contains('status', 0);
      // dd($applyleaveDatas);
      return view('backEnd.applyleave.teamapplication', compact(
        'teammember',
        'countCasualafmnth',
        'teammonthcount',
        'totalcountCasual',
        'teamapplyleaveDatas',
        'birthday',
        'countbirthday',
        'Casual',
        'Sick',
        'countSick',
        'countCasual',
        'role_id',
        'clInAttendance',
        'slInAttendance',
        'hasPendingRequests',
        'teamapplyleaveDatasfilter',
      ));
    } elseif (auth()->user()->role_id == 18) {

      $role_id = auth()->user()->teammember_id;

      $teammember = Teammember::with('role:id,rolename')
        ->whereNotNull('joining_date')
        ->get();

      $appliedSick = DB::table('applyleaves')
        ->where('status', '!=', '2')
        ->where('leavetype', $Sick->id)
        ->where('createdby', auth()->user()->teammember_id)
        ->whereBetween('created_at', [$financialYearStart, $financialYearEnd])
        ->get();

      $countSick = 0;
      $datess = [];
      $hdatess = [];
      foreach ($appliedSick as $sickLeave) {
        $fromDate = \Carbon\Carbon::createFromFormat('Y-m-d', $sickLeave->from);
        $toDate = \Carbon\Carbon::createFromFormat('Y-m-d', $sickLeave->to);
        $period = CarbonPeriod::create($fromDate, $toDate);


        foreach ($period as $date) {
          $datess[] = $date->format('Y-m-d');
        }

        $getholidays = DB::table('holidays')->get();


        foreach ($getholidays as $date) {
          $hdatess[] = date('Y-m-d', strtotime($date->startdate));
        }
        $datess = array_unique($datess);
      }
      $countSick = count(array_diff($datess, $hdatess));


      $appliedCasual = DB::table('applyleaves')
        ->where('status', '!=', '2')
        ->where('leavetype', $Casual->id)
        ->where('createdby', auth()->user()->teammember_id)
        ->whereBetween('created_at', [$financialYearStart, $financialYearEnd])
        ->get();

      $countCasual = 0;
      $casualDates = [];
      foreach ($appliedCasual as $CasualLeave) {

        $fromDate = \Carbon\Carbon::createFromFormat('Y-m-d', $CasualLeave->from);
        $toDate = \Carbon\Carbon::createFromFormat('Y-m-d', $CasualLeave->to);
        $period = CarbonPeriod::create($fromDate, $toDate);


        foreach ($period as $date) {
          $casualDates[] = $date->format('Y-m-d');
        }

        $getholidays = DB::table('holidays')->get();

        $hdatess = [];
        foreach ($getholidays as $date) {
          $hdatess[] = date('Y-m-d', strtotime($date->startdate));
        }
        $casualDates = array_unique($casualDates);
      }
      $countCasual = count(array_diff($casualDates, $hdatess));

      $appliedCasualafmnth = DB::table('applyleaves')
        ->where('status', '!=', '2')
        ->where('leavetype', $Casual->id)
        ->where('createdby', auth()->user()->teammember_id)
        ->whereBetween('created_at', [$financialYearStart, $financialYearEnd])
        ->where('created_at', '>', Carbon::createFromFormat('Y-m-d', $casualteam->joining_date)->addDays(90))
        ->get();

      $countCasualafmnth = 0;
      $CasualafmnthDates = [];
      foreach ($appliedCasualafmnth as $CasualafmnthLeave) {

        $fromDate = \Carbon\Carbon::createFromFormat('Y-m-d', $CasualafmnthLeave->from);
        $toDate = \Carbon\Carbon::createFromFormat('Y-m-d', $CasualafmnthLeave->to);
        $period = CarbonPeriod::create($fromDate, $toDate);


        foreach ($period as $date) {
          $CasualafmnthDates[] = $date->format('Y-m-d');
        }

        $getholidays = DB::table('holidays')->get();

        $hdatess = [];
        foreach ($getholidays as $date) {
          $hdatess[] = date('Y-m-d', strtotime($date->startdate));
        }
        $CasualafmnthDates = array_unique($CasualafmnthDates);
      }
      $countCasualafmnth = count(array_diff($CasualafmnthDates, $hdatess));





      $appliedbirthday = DB::table('applyleaves')
        ->where('status', '!=', '2')
        ->where('leavetype', $birthday->id)
        ->where('createdby', auth()->user()->teammember_id)
        ->whereBetween('created_at', [$financialYearStart, $financialYearEnd])
        ->get();
      $countbirthday = 0;
      $birthdayDates = [];
      foreach ($appliedbirthday as $birthdayLeave) {

        $fromDate = \Carbon\Carbon::createFromFormat('Y-m-d', $birthdayLeave->from);
        $toDate = \Carbon\Carbon::createFromFormat('Y-m-d', $birthdayLeave->to);
        $period = CarbonPeriod::create($fromDate, $toDate);


        foreach ($period as $date) {
          $birthdayDates[] = $date->format('Y-m-d');
        }

        $getholidays = DB::table('holidays')->get();

        $hdatess = [];
        foreach ($getholidays as $date) {
          $hdatess[] = date('Y-m-d', strtotime($date->startdate));
        }
        $birthdayDates = array_unique($birthdayDates);
      }
      $countbirthday = count(array_diff($birthdayDates, $hdatess));

      //dd($diff_in_months);
      $totalcountCasual = $Casual->noofdays * $diff_in_months;
      //  dd($diff_in_months);

      //  dd($countCasualafmnth);
      $leavetaken = DB::table('leaveapprove')
        ->where('year', '2023')->where('teammemberid', auth()->user()->teammember_id)->sum('totaldays');

      $columns = ['one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'ninghteen', 'twenty', 'twentyone', 'twentytwo', 'twentythree', 'twentyfour', 'twentyfive', 'twentysix', 'twentyseven', 'twentyeight', 'twentynine', 'thirty', 'thirtyone'];
      $attendance = DB::table('attendances')
        ->where('employee_name', auth()->user()->teammember_id)
        ->whereBetween('created_at', [$financialYearStart, $financialYearEnd])
        ->get();

      $clInAttendance = 0;
      $slInAttendance = 0;
      //dd($attendance);
      foreach ($attendance as $item) {
        foreach ($columns as $column) {
          if ($item->$column === 'CL/C' || $item->$column === 'CL/A') {
            $clInAttendance++;
          }
          if ($item->$column === 'SL/C' || $item->$column === 'SL/A') {
            $slInAttendance++;
          }
        }
      }
      $teamapplyleaveDatas  = DB::table('applyleaves')
        ->leftjoin('leavetypes', 'leavetypes.id', 'applyleaves.leavetype')
        ->leftjoin('teammembers', 'teammembers.id', 'applyleaves.createdby')
        ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
        ->select('applyleaves.*', 'teammembers.team_member', 'roles.rolename', 'leavetypes.name')->latest()->get();

      return view('backEnd.applyleave.teamapplication', compact(
        'teammember',
        'countCasualafmnth',
        'teammonthcount',
        'totalcountCasual',
        'teamapplyleaveDatas',
        'birthday',
        'countbirthday',
        'Casual',
        'Sick',
        'countSick',
        'countCasual',
        'role_id',
        'clInAttendance',
        'slInAttendance',
      ));
    } elseif ($permotioncheck && auth()->user()->role_id == 13) {
      $appliedSick = DB::table('applyleaves')
        ->where('status', '!=', '2')
        ->where('leavetype', $Sick->id)
        ->where('createdby', auth()->user()->teammember_id)
        ->whereBetween('created_at', [$financialYearStart, $financialYearEnd])
        ->get();

      $countSick = 0;
      $datess = [];
      $hdatess = [];
      foreach ($appliedSick as $sickLeave) {
        $fromDate = \Carbon\Carbon::createFromFormat('Y-m-d', $sickLeave->from);
        $toDate = \Carbon\Carbon::createFromFormat('Y-m-d', $sickLeave->to);
        $period = CarbonPeriod::create($fromDate, $toDate);


        foreach ($period as $date) {
          $datess[] = $date->format('Y-m-d');
        }

        $getholidays = DB::table('holidays')->get();


        foreach ($getholidays as $date) {
          $hdatess[] = date('Y-m-d', strtotime($date->startdate));
        }
        $datess = array_unique($datess);
      }
      $countSick = count(array_diff($datess, $hdatess));


      $appliedCasual = DB::table('applyleaves')
        ->where('status', '!=', '2')
        ->where('leavetype', $Casual->id)
        ->where('createdby', auth()->user()->teammember_id)
        ->whereBetween('created_at', [$financialYearStart, $financialYearEnd])
        ->get();

      $countCasual = 0;
      $casualDates = [];
      foreach ($appliedCasual as $CasualLeave) {

        $fromDate = \Carbon\Carbon::createFromFormat('Y-m-d', $CasualLeave->from);
        $toDate = \Carbon\Carbon::createFromFormat('Y-m-d', $CasualLeave->to);
        $period = CarbonPeriod::create($fromDate, $toDate);


        foreach ($period as $date) {
          $casualDates[] = $date->format('Y-m-d');
        }

        $getholidays = DB::table('holidays')->get();

        $hdatess = [];
        foreach ($getholidays as $date) {
          $hdatess[] = date('Y-m-d', strtotime($date->startdate));
        }
        $casualDates = array_unique($casualDates);
      }
      $countCasual = count(array_diff($casualDates, $hdatess));

      $appliedCasualafmnth = DB::table('applyleaves')
        ->where('status', '!=', '2')
        ->where('leavetype', $Casual->id)
        ->where('createdby', auth()->user()->teammember_id)
        ->whereBetween('created_at', [$financialYearStart, $financialYearEnd])
        ->where('created_at', '>', Carbon::createFromFormat('Y-m-d', $casualteam->joining_date)->addDays(90))
        ->get();

      $countCasualafmnth = 0;
      $CasualafmnthDates = [];
      foreach ($appliedCasualafmnth as $CasualafmnthLeave) {

        $fromDate = \Carbon\Carbon::createFromFormat('Y-m-d', $CasualafmnthLeave->from);
        $toDate = \Carbon\Carbon::createFromFormat('Y-m-d', $CasualafmnthLeave->to);
        $period = CarbonPeriod::create($fromDate, $toDate);


        foreach ($period as $date) {
          $CasualafmnthDates[] = $date->format('Y-m-d');
        }

        $getholidays = DB::table('holidays')->get();

        $hdatess = [];
        foreach ($getholidays as $date) {
          $hdatess[] = date('Y-m-d', strtotime($date->startdate));
        }
        $CasualafmnthDates = array_unique($CasualafmnthDates);
      }
      $countCasualafmnth = count(array_diff($CasualafmnthDates, $hdatess));

      $appliedbirthday = DB::table('applyleaves')
        ->where('status', '!=', '2')
        ->where('leavetype', $birthday->id)
        ->where('createdby', auth()->user()->teammember_id)
        ->whereBetween('created_at', [$financialYearStart, $financialYearEnd])
        ->get();
      $countbirthday = 0;
      $birthdayDates = [];
      foreach ($appliedbirthday as $birthdayLeave) {

        $fromDate = \Carbon\Carbon::createFromFormat('Y-m-d', $birthdayLeave->from);
        $toDate = \Carbon\Carbon::createFromFormat('Y-m-d', $birthdayLeave->to);
        $period = CarbonPeriod::create($fromDate, $toDate);


        foreach ($period as $date) {
          $birthdayDates[] = $date->format('Y-m-d');
        }

        $getholidays = DB::table('holidays')->get();

        $hdatess = [];
        foreach ($getholidays as $date) {
          $hdatess[] = date('Y-m-d', strtotime($date->startdate));
        }
        $birthdayDates = array_unique($birthdayDates);
      }
      $countbirthday = count(array_diff($birthdayDates, $hdatess));

      //dd($diff_in_months);
      $totalcountCasual = $Casual->noofdays * $diff_in_months;
      //  dd($diff_in_months);

      //  dd($countCasualafmnth);
      $leavetaken = DB::table('leaveapprove')
        ->where('year', '2023')->where('teammemberid', auth()->user()->teammember_id)->sum('totaldays');
      // $myapplyleaveDatas  = DB::table('applyleaves')
      //   ->leftjoin('leavetypes', 'leavetypes.id', 'applyleaves.leavetype')
      //   ->leftjoin('teammembers', 'teammembers.id', 'applyleaves.createdby')
      //   ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
      //   ->where('applyleaves.createdby', auth()->user()->teammember_id)
      //   ->select('applyleaves.*', 'teammembers.team_member', 'teammembers.staffcode', 'roles.rolename', 'leavetypes.name')->latest()->get();



      // $commonQuery = DB::table('applyleaves')
      //   ->leftjoin('leavetypes', 'leavetypes.id', 'applyleaves.leavetype')
      //   ->leftjoin('teammembers', 'teammembers.id', 'applyleaves.createdby')
      //   ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
      //   ->where('applyleaves.createdby', auth()->user()->teammember_id)
      //   ->select('applyleaves.*', 'teammembers.team_member', 'roles.rolename', 'leavetypes.name');

      // $myapplyleaveDatasbefore = (clone $commonQuery)
      //   ->whereDate('applyleaves.created_at', '<', $permotioncheck->created_at)
      //   ->addSelect('teammembers.staffcode')
      //   ->get();

      // $myapplyleaveDatasafter = (clone $commonQuery)
      //   ->leftJoin('teamrolehistory as createdby_history', 'createdby_history.teammember_id', '=', 'teammembers.id')
      //   ->whereDate('applyleaves.created_at', '>', $permotioncheck->created_at)
      //   ->addSelect('createdby_history.newstaff_code')
      //   ->get();

      // $myapplyleaveDatas = $myapplyleaveDatasafter->merge($myapplyleaveDatasbefore);

      $myapplyleaveDatas  = DB::table('applyleaves')
        ->leftjoin('leavetypes', 'leavetypes.id', 'applyleaves.leavetype')
        ->leftjoin('teammembers', 'teammembers.id', 'applyleaves.createdby')
        ->leftjoin('teammembers as partner', 'partner.id', 'applyleaves.approver')
        ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
        ->where('applyleaves.createdby', auth()->user()->teammember_id)
        ->select('applyleaves.*', 'teammembers.team_member', 'roles.rolename', 'leavetypes.name', 'partner.team_member as partnername')
        ->latest()
        ->get();

      $myapplyleaveDatas = $myapplyleaveDatas->map(function ($item) {
        $item->teamstaffcode = $this->getStaffCodeAt($item->createdby, $item->created_at);
        $item->partnerstaffcode = $this->getStaffCodeAt($item->approver, $item->created_at);
        return $item;
      });

      $teamapplyleaveDatas  = DB::table('applyleaves')
        ->leftjoin('leavetypes', 'leavetypes.id', 'applyleaves.leavetype')
        ->leftjoin('teammembers', 'teammembers.id', 'applyleaves.createdby')
        ->leftjoin('teammembers as partner', 'partner.id', 'applyleaves.approver')
        ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
        ->where('applyleaves.approver', auth()->user()->teammember_id)
        ->select('applyleaves.*', 'teammembers.team_member', 'roles.rolename', 'leavetypes.name', 'partner.team_member as partnername')
        ->latest()
        ->get();

      $teamapplyleaveDatas = $teamapplyleaveDatas->map(function ($item) {
        $item->teamstaffcode = $this->getStaffCodeAt($item->createdby, $item->created_at);
        $item->partnerstaffcode = $this->getStaffCodeAt($item->approver, $item->created_at);
        return $item;
      });

      $hasPendingRequests = $teamapplyleaveDatas->contains('status', 0);


      $columns = ['one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'ninghteen', 'twenty', 'twentyone', 'twentytwo', 'twentythree', 'twentyfour', 'twentyfive', 'twentysix', 'twentyseven', 'twentyeight', 'twentynine', 'thirty', 'thirtyone'];
      $attendance = DB::table('attendances')
        ->where('employee_name', auth()->user()->teammember_id)
        ->whereBetween('created_at', [$financialYearStart, $financialYearEnd])
        ->get();

      $clInAttendance = 0;
      $slInAttendance = 0;
      //dd($attendance);
      foreach ($attendance as $item) {
        foreach ($columns as $column) {
          if ($item->$column === 'CL/C' || $item->$column === 'CL/A') {
            $clInAttendance++;
          }
          if ($item->$column === 'SL/C' || $item->$column === 'SL/A') {
            $slInAttendance++;
          }
        }
      }

      //Aproved leave jan to dec 
      // $currentYear = date('Y');
      // $approvedleavesvalue = DB::table('applyleaves')
      //   ->where('createdby', auth()->user()->teammember_id)
      //   ->where('status', 1)
      //   ->whereYear('from',  $currentYear)
      //   ->get();

      // $leaveDurations = [];
      // foreach ($approvedleavesvalue as $approvedleavesvalues) {
      //   $to = Carbon::createFromFormat('Y-m-d', $approvedleavesvalues->to ?? '');
      //   $from = Carbon::createFromFormat('Y-m-d', $approvedleavesvalues->from);

      //   $diff_in_days = $to->diffInDays($from) + 1;

      //   $holidaycount = DB::table('holidays')
      //     ->where('startdate', '>=', $approvedleavesvalues->from)
      //     ->where('enddate', '<=', $approvedleavesvalues->to)
      //     ->count();

      //   $leaveDurationcount = $diff_in_days - $holidaycount;
      //   $leaveDurations[] = $leaveDurationcount;
      // }

      // $approvedleavesvaluecount = array_sum($leaveDurations);

      // total working days start from january to december
      $currentDate = Carbon::now();
      $currentMonth = $currentDate->format('F');
      $startDate = Carbon::create($currentDate->year, 1, 1);
      $endDate = Carbon::create($currentDate->year, 12, 31);

      $attendancerecordData = DB::table('attendances')
        ->where('employee_name', auth()->user()->teammember_id)
        ->whereBetween('fulldate', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
        ->select(
          DB::raw('SUM(casual_leave) as total_casual_leave'),
          DB::raw('SUM(exam_leave) as total_exam_leave')
        )
        ->first();

      $totalCasualLeave = $attendancerecordData->total_casual_leave ?? 0;
      $totalExamLeave = $attendancerecordData->total_exam_leave ?? 0;
      $approvedleavesvaluecount = $totalCasualLeave + $totalExamLeave;
      //Aproved leave jan to dec end hare 

      $teamapplyleaveDatasfilter  = DB::table('applyleaves')
        ->leftjoin('leavetypes', 'leavetypes.id', 'applyleaves.leavetype')
        ->leftjoin('teammembers', 'teammembers.id', 'applyleaves.createdby')
        ->leftJoin('roles', 'roles.id', '=', 'teammembers.role_id')
        ->leftJoin(DB::raw('
          (SELECT teammember_id, newstaff_code 
           FROM teamrolehistory 
           WHERE created_at = (SELECT MAX(created_at) 
                               FROM teamrolehistory th2 
                               WHERE th2.teammember_id = teamrolehistory.teammember_id)
          ) AS teamrolehistory
      '), function ($join) {
          $join->on('teamrolehistory.teammember_id', '=', 'teammembers.id');
        })
        ->where('applyleaves.approver', auth()->user()->teammember_id)
        ->select('applyleaves.*', 'teammembers.team_member', 'teammembers.staffcode', 'teammembers.emailid', 'roles.rolename', 'leavetypes.name', 'teamrolehistory.newstaff_code')
        ->distinct()
        ->get();

      // dd($applyleaveDatas);
      return view('backEnd.applyleave.index', compact('countCasualafmnth', 'leavetaken', 'teammonthcount', 'totalcountCasual', 'myapplyleaveDatas', 'teamapplyleaveDatas', 'birthday', 'countbirthday', 'Casual', 'Sick', 'countSick', 'countCasual', 'clInAttendance', 'slInAttendance', 'approvedleavesvaluecount', 'hasPendingRequests', 'teamapplyleaveDatasfilter'));
    } else {

      $appliedSick = DB::table('applyleaves')
        ->where('status', '!=', '2')
        ->where('leavetype', $Sick->id)
        ->where('createdby', auth()->user()->teammember_id)
        ->whereBetween('created_at', [$financialYearStart, $financialYearEnd])
        ->get();

      $countSick = 0;
      $datess = [];
      $hdatess = [];
      foreach ($appliedSick as $sickLeave) {
        $fromDate = \Carbon\Carbon::createFromFormat('Y-m-d', $sickLeave->from);
        $toDate = \Carbon\Carbon::createFromFormat('Y-m-d', $sickLeave->to);
        $period = CarbonPeriod::create($fromDate, $toDate);


        foreach ($period as $date) {
          $datess[] = $date->format('Y-m-d');
        }

        $getholidays = DB::table('holidays')->get();


        foreach ($getholidays as $date) {
          $hdatess[] = date('Y-m-d', strtotime($date->startdate));
        }
        $datess = array_unique($datess);
      }
      $countSick = count(array_diff($datess, $hdatess));


      $appliedCasual = DB::table('applyleaves')
        ->where('status', '!=', '2')
        ->where('leavetype', $Casual->id)
        ->where('createdby', auth()->user()->teammember_id)
        ->whereBetween('created_at', [$financialYearStart, $financialYearEnd])
        ->get();

      $countCasual = 0;
      $casualDates = [];
      foreach ($appliedCasual as $CasualLeave) {

        $fromDate = \Carbon\Carbon::createFromFormat('Y-m-d', $CasualLeave->from);
        $toDate = \Carbon\Carbon::createFromFormat('Y-m-d', $CasualLeave->to);
        $period = CarbonPeriod::create($fromDate, $toDate);


        foreach ($period as $date) {
          $casualDates[] = $date->format('Y-m-d');
        }

        $getholidays = DB::table('holidays')->get();

        $hdatess = [];
        foreach ($getholidays as $date) {
          $hdatess[] = date('Y-m-d', strtotime($date->startdate));
        }
        $casualDates = array_unique($casualDates);
      }
      $countCasual = count(array_diff($casualDates, $hdatess));

      $appliedCasualafmnth = DB::table('applyleaves')
        ->where('status', '!=', '2')
        ->where('leavetype', $Casual->id)
        ->where('createdby', auth()->user()->teammember_id)
        ->whereBetween('created_at', [$financialYearStart, $financialYearEnd])
        ->where('created_at', '>', Carbon::createFromFormat('Y-m-d', $casualteam->joining_date)->addDays(90))
        ->get();

      $countCasualafmnth = 0;
      $CasualafmnthDates = [];
      foreach ($appliedCasualafmnth as $CasualafmnthLeave) {

        $fromDate = \Carbon\Carbon::createFromFormat('Y-m-d', $CasualafmnthLeave->from);
        $toDate = \Carbon\Carbon::createFromFormat('Y-m-d', $CasualafmnthLeave->to);
        $period = CarbonPeriod::create($fromDate, $toDate);


        foreach ($period as $date) {
          $CasualafmnthDates[] = $date->format('Y-m-d');
        }

        $getholidays = DB::table('holidays')->get();

        $hdatess = [];
        foreach ($getholidays as $date) {
          $hdatess[] = date('Y-m-d', strtotime($date->startdate));
        }
        $CasualafmnthDates = array_unique($CasualafmnthDates);
      }
      $countCasualafmnth = count(array_diff($CasualafmnthDates, $hdatess));

      $appliedbirthday = DB::table('applyleaves')
        ->where('status', '!=', '2')
        ->where('leavetype', $birthday->id)
        ->where('createdby', auth()->user()->teammember_id)
        ->whereBetween('created_at', [$financialYearStart, $financialYearEnd])
        ->get();
      $countbirthday = 0;
      $birthdayDates = [];
      foreach ($appliedbirthday as $birthdayLeave) {

        $fromDate = \Carbon\Carbon::createFromFormat('Y-m-d', $birthdayLeave->from);
        $toDate = \Carbon\Carbon::createFromFormat('Y-m-d', $birthdayLeave->to);
        $period = CarbonPeriod::create($fromDate, $toDate);


        foreach ($period as $date) {
          $birthdayDates[] = $date->format('Y-m-d');
        }

        $getholidays = DB::table('holidays')->get();

        $hdatess = [];
        foreach ($getholidays as $date) {
          $hdatess[] = date('Y-m-d', strtotime($date->startdate));
        }
        $birthdayDates = array_unique($birthdayDates);
      }
      $countbirthday = count(array_diff($birthdayDates, $hdatess));

      //dd($diff_in_months);
      $totalcountCasual = $Casual->noofdays * $diff_in_months;
      //  dd($diff_in_months);

      //  dd($countCasualafmnth);
      $leavetaken = DB::table('leaveapprove')
        ->where('year', '2023')->where('teammemberid', auth()->user()->teammember_id)->sum('totaldays');

      // $myapplyleaveDatas  = DB::table('applyleaves')
      //   ->leftjoin('leavetypes', 'leavetypes.id', 'applyleaves.leavetype')
      //   ->leftjoin('teammembers', 'teammembers.id', 'applyleaves.createdby')
      //   ->leftJoin('teamrolehistory', function ($join) {
      //     $join->on('teamrolehistory.teammember_id', '=', 'teammembers.id')
      //       ->on('teamrolehistory.created_at', '<', 'applyleaves.created_at');
      //   })
      //   ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
      //   ->where('applyleaves.createdby', auth()->user()->teammember_id)
      //   ->select('applyleaves.*', 'teamrolehistory.newstaff_code', 'teammembers.team_member', 'teammembers.staffcode', 'roles.rolename', 'leavetypes.name')->latest()->get();


      // $teamapplyleaveDatas  = DB::table('applyleaves')
      //   ->leftjoin('leavetypes', 'leavetypes.id', 'applyleaves.leavetype')
      //   ->leftjoin('teammembers', 'teammembers.id', 'applyleaves.createdby')
      //   ->leftJoin('teamrolehistory as teamrolehistoryteam', function ($join) {
      //     $join->on('teamrolehistoryteam.teammember_id', '=', 'applyleaves.createdby')
      //       ->on('teamrolehistoryteam.created_at', '<', 'applyleaves.created_at');
      //   })
      //   ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
      //   ->where('applyleaves.approver', auth()->user()->teammember_id)
      //   ->select('applyleaves.*', 'teammembers.team_member', 'teammembers.staffcode', 'roles.rolename', 'leavetypes.name', 'teamrolehistoryteam.newstaff_code')->get();


      $myapplyleaveDatas = DB::table('applyleaves')
        ->leftjoin('leavetypes', 'leavetypes.id', 'applyleaves.leavetype')
        ->leftjoin('teammembers', 'teammembers.id', 'applyleaves.createdby')
        ->leftjoin('teammembers as partner', 'partner.id', 'applyleaves.approver')
        ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
        ->where('applyleaves.createdby', auth()->user()->teammember_id)
        ->select('applyleaves.*', 'teammembers.team_member', 'roles.rolename', 'leavetypes.name', 'partner.team_member as partnername')
        ->latest()
        ->get();

      $myapplyleaveDatas = $myapplyleaveDatas->map(function ($item) {
        $item->teamstaffcode = $this->getStaffCodeAt($item->createdby, $item->created_at);
        $item->partnerstaffcode = $this->getStaffCodeAt($item->approver, $item->created_at);
        return $item;
      });

      $teamapplyleaveDatas  = DB::table('applyleaves')
        ->leftjoin('leavetypes', 'leavetypes.id', 'applyleaves.leavetype')
        ->leftjoin('teammembers', 'teammembers.id', 'applyleaves.createdby')
        ->leftjoin('teammembers as partner', 'partner.id', 'applyleaves.approver')
        ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
        ->where('applyleaves.approver', auth()->user()->teammember_id)
        ->select('applyleaves.*', 'teammembers.team_member', 'roles.rolename', 'leavetypes.name', 'partner.team_member as partnername')
        ->latest()
        ->get();

      $teamapplyleaveDatas = $teamapplyleaveDatas->map(function ($item) {
        $item->teamstaffcode = $this->getStaffCodeAt($item->createdby, $item->created_at);
        $item->partnerstaffcode = $this->getStaffCodeAt($item->approver, $item->created_at);
        return $item;
      });


      $hasPendingRequests = $teamapplyleaveDatas->contains('status', 0);


      $columns = ['one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'ninghteen', 'twenty', 'twentyone', 'twentytwo', 'twentythree', 'twentyfour', 'twentyfive', 'twentysix', 'twentyseven', 'twentyeight', 'twentynine', 'thirty', 'thirtyone'];
      $attendance = DB::table('attendances')
        ->where('employee_name', auth()->user()->teammember_id)
        ->whereBetween('created_at', [$financialYearStart, $financialYearEnd])
        ->get();

      $clInAttendance = 0;
      $slInAttendance = 0;
      //dd($attendance);
      foreach ($attendance as $item) {
        foreach ($columns as $column) {
          if ($item->$column === 'CL/C' || $item->$column === 'CL/A') {
            $clInAttendance++;
          }
          if ($item->$column === 'SL/C' || $item->$column === 'SL/A') {
            $slInAttendance++;
          }
        }
      }

      //Aproved leave jan to dec 

      // $currentYear = date('Y');
      // $approvedleavesvalue = DB::table('applyleaves')
      //   ->where('createdby', auth()->user()->teammember_id)
      //   ->where('status', 1)
      //   ->whereYear('from',  $currentYear)
      //   ->get();



      // $leaveDurations = [];
      // foreach ($approvedleavesvalue as $approvedleavesvalues) {
      //   $to = Carbon::createFromFormat('Y-m-d', $approvedleavesvalues->to ?? '');
      //   $from = Carbon::createFromFormat('Y-m-d', $approvedleavesvalues->from);

      //   $diff_in_days = $to->diffInDays($from) + 1;

      //   $holidaycount = DB::table('holidays')
      //     ->where('startdate', '>=', $approvedleavesvalues->from)
      //     ->where('enddate', '<=', $approvedleavesvalues->to)
      //     ->count();

      //   $leaveDurationcount = $diff_in_days - $holidaycount;
      //   $leaveDurations[] = $leaveDurationcount;
      // }

      // $approvedleavesvaluecount = array_sum($leaveDurations);

      // total working days start from january to december
      $currentDate = Carbon::now();
      $currentMonth = $currentDate->format('F');
      $startDate = Carbon::create($currentDate->year, 1, 1);
      $endDate = Carbon::create($currentDate->year, 12, 31);

      $attendancerecordData = DB::table('attendances')
        ->where('employee_name', auth()->user()->teammember_id)
        ->whereBetween('fulldate', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
        ->select(
          DB::raw('SUM(casual_leave) as total_casual_leave'),
          DB::raw('SUM(exam_leave) as total_exam_leave')
        )
        ->first();

      $totalCasualLeave = $attendancerecordData->total_casual_leave ?? 0;
      $totalExamLeave = $attendancerecordData->total_exam_leave ?? 0;
      $approvedleavesvaluecount = $totalCasualLeave + $totalExamLeave;
      //Aproved leave jan to dec end hare 

      $teamapplyleaveDatasfilter  = DB::table('applyleaves')
        ->leftjoin('leavetypes', 'leavetypes.id', 'applyleaves.leavetype')
        ->leftjoin('teammembers', 'teammembers.id', 'applyleaves.createdby')
        ->leftJoin('roles', 'roles.id', '=', 'teammembers.role_id')
        ->leftJoin(DB::raw('
          (SELECT teammember_id, newstaff_code 
           FROM teamrolehistory 
           WHERE created_at = (SELECT MAX(created_at) 
                               FROM teamrolehistory th2 
                               WHERE th2.teammember_id = teamrolehistory.teammember_id)
          ) AS teamrolehistory
      '), function ($join) {
          $join->on('teamrolehistory.teammember_id', '=', 'teammembers.id');
        })
        ->where('applyleaves.approver', auth()->user()->teammember_id)
        ->select('applyleaves.*', 'teammembers.team_member', 'teammembers.staffcode', 'teammembers.emailid', 'roles.rolename', 'leavetypes.name', 'teamrolehistory.newstaff_code')
        ->distinct()
        ->get();

      return view('backEnd.applyleave.index', compact('countCasualafmnth', 'leavetaken', 'teammonthcount', 'totalcountCasual', 'myapplyleaveDatas', 'teamapplyleaveDatas', 'birthday', 'countbirthday', 'Casual', 'Sick', 'countSick', 'countCasual', 'clInAttendance', 'slInAttendance', 'approvedleavesvaluecount', 'hasPendingRequests', 'teamapplyleaveDatasfilter'));
    }
  }
        
        //* regarding 
        // Start Hare
        //* regarding 
        // Start Hare
        //* regarding 
        // Start Hare
        //* regarding 
        // Start Hare
        //* regarding 
        // Start Hare
        //* regarding 
        // Start Hare
        //* regarding 
        // Start Hare
        //* regarding 
        // Start Hare
        //* regarding 
        // Start Hare
        //* regarding 
        // Start Hare
        //* regarding 
        // Start Hare

         $roleHistories = DB::table('teamrolehistory')
      ->whereIn('id', function ($query) use ($teamIds) {
        $query->selectRaw('MAX(id)')
          ->from('teamrolehistory')
          ->whereIn('teammember_id', $teamIds)
          ->groupBy('teammember_id');
      })
      ->get()
      ->keyBy('teammember_id');

          $teamRoleHistories = DB::table('teamrolehistory')
            ->whereIn('id', function ($query) {
                $query->selectRaw('MAX(id)')
                    ->from('teamrolehistory')
                    ->groupBy('teammember_id');
            })
            ->get()
            ->keyBy('teammember_id');
        
                                                <td>
                                                    {{ $assignmentmappingDatas->leadpartnername ?? '' }}
                                                </td>
                                                <td>
                                                    @if ($assignmentmappingDatas->leadpartnername)
                                                        {{ $assignmentmappingDatas->leadpartnercode ?? '' }}
                                                    @endif
                                                </td>

                                                <td>
                                                    {{ $assignmentmappingDatas->otherpartnername ?? '' }}
                                                </td>
                                                <td>
                                                    @if ($assignmentmappingDatas->otherpartnername)
                                                        {{ $assignmentmappingDatas->otherpartnercode ?? '' }}
                                                    @endif
                                                </td>
         $assignmentmappingOpenotherpartner =  DB::table('assignmentmappings')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('teammembers as leadpartner', 'leadpartner.id', 'assignmentmappings.leadpartner')
        ->leftjoin('teammembers as otherpartner', 'otherpartner.id', 'assignmentmappings.otherpartner')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
        ->where('assignmentmappings.otherpartner', auth()->user()->teammember_id)
        ->where('assignmentbudgetings.status', '1')
        //------------------- Shahid's code start---------------------
        ->whereNotIn('assignmentbudgetings.assignmentname', ['Unallocated', 'Official Travel', 'Off/Holiday', 'Seminar/Conference/Post Qualification Course'])
        ->select(
          'assignmentmappings.*',
          'assignmentbudgetings.duedate',
          'assignmentbudgetings.assignmentname',
          'assignmentbudgetings.status',
          'assignments.assignment_name',
          'clients.client_name',
          'clients.client_code',
          'leadpartner.team_member as leadpartnername',
          'otherpartner.team_member as otherpartnername',
        )
        ->get();

      $assignmentmappingData = $assignmentmappingOpenotherpartner->merge($assignmentmappingOpenleadpartner)->merge($assignmentmappingDatabefore);

      $assignmentmappingData = $assignmentmappingData->map(function ($item) {
        $item->leadpartnercode = $this->getStaffCodeAt($item->leadpartner, $item->created_at);
        $item->otherpartnercode = $this->getStaffCodeAt($item->otherpartner, $item->created_at);
        return $item;
      });
        //* regarding


          $latestHistory = DB::table('teamrolehistory as teamrolehistorydata')
            ->select('teamrolehistorydata.teammember_id', 'teamrolehistorydata.newstaff_code')
            ->whereRaw('teamrolehistorydata.id = (SELECT MAX(teamrolehistorylatest.id) FROM teamrolehistory as teamrolehistorylatest WHERE teamrolehistorylatest.teammember_id = teamrolehistorydata.teammember_id)');


        $partner = Teammember::where('role_id', '=', 13)
            ->where('status', '=', 1)
            ->leftJoinSub($latestHistory, 'latestrecord', function ($join) {
                $join->on('latestrecord.teammember_id', '=', 'teammembers.id');
            })
            ->with('title')
            ->orderBy('team_member', 'asc')
            ->select('teammembers.*', 'latestrecord.newstaff_code')
            ->get();

        $teammember = DB::table('teammembers')
            ->leftJoinSub($latestHistory, 'latestrecord', function ($join) {
                $join->on('latestrecord.teammember_id', '=', 'teammembers.id');
            })
            ->leftjoin('titles', 'titles.id', 'teammembers.title_id')
            ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
            ->whereIn('teammembers.role_id', [15, 14])
            ->where('teammembers.status', 1)
            ->select('teammembers.*', 'titles.title', 'roles.rolename', 'latestrecord.newstaff_code')
            ->orderBy('team_member', 'ASC')
            // ->take(7)
            ->get();


            
    $latestteamrolehistory = DB::table('teamrolehistory as teamrolehistorydata')
      ->select(
        'teamrolehistorydata.teammember_id',
        'teamrolehistorydata.newstaff_code',
        'teamrolehistorydata.rejoiningdate',
        'teamrolehistorydata.rejoiniedexitdate'
      )
      ->whereRaw('teamrolehistorydata.id = (SELECT MAX(teamrolehistorylatest.id) FROM teamrolehistory as teamrolehistorylatest WHERE teamrolehistorylatest.teammember_id = teamrolehistorydata.teammember_id)');


    $latestrejoiningsamepost = DB::table('rejoiningsamepost as rejoiningsamepostdata')
      ->select(
        'rejoiningsamepostdata.teammember_id',
        'rejoiningsamepostdata.rejoiningdate',
        'rejoiningsamepostdata.rejoiniedexitdate'
      )
      ->whereRaw('rejoiningsamepostdata.id = (SELECT MAX(rejoiningsamepostlatest.id) FROM rejoiningsamepost as rejoiningsamepostlatest WHERE rejoiningsamepostlatest.teammember_id = rejoiningsamepostdata.teammember_id)');


    $userInfo = Teammember::where('teammembers.id', auth()->user()->teammember_id)
      ->leftJoinSub($latestteamrolehistory, 'latestrecord', function ($join) {
        $join->on('latestrecord.teammember_id', '=', 'teammembers.id');
      })
      ->leftJoinSub($latestrejoiningsamepost, 'latestrecord2', function ($join) {
        $join->on('latestrecord2.teammember_id', '=', 'teammembers.id');
      })
      ->select([
        'teammembers.*',
        'latestrecord.newstaff_code',
        DB::raw('COALESCE(latestrecord.rejoiningdate, latestrecord2.rejoiningdate, teammembers.joining_date) AS final_joiningdate'),
      ])
      // ->groupBy('teammembers.id')
      ->first();


          $latestteamrolehistory = DB::table('teamrolehistory as teamrolehistorydata')
                ->select(
                    'teamrolehistorydata.teammember_id',
                    'teamrolehistorydata.newstaff_code',
                    'teamrolehistorydata.rejoiningdate',
                    'teamrolehistorydata.rejoiniedexitdate'
                )
                ->whereRaw('teamrolehistorydata.id = (SELECT MAX(teamrolehistorylatest.id) FROM teamrolehistory as teamrolehistorylatest WHERE teamrolehistorylatest.teammember_id = teamrolehistorydata.teammember_id)');


            $latestrejoiningsamepost = DB::table('rejoiningsamepost as rejoiningsamepostdata')
                ->select(
                    'rejoiningsamepostdata.teammember_id',
                    'rejoiningsamepostdata.rejoiningdate',
                    'rejoiningsamepostdata.rejoiniedexitdate'
                )
                ->whereRaw('rejoiningsamepostdata.id = (SELECT MAX(rejoiningsamepostlatest.id) FROM rejoiningsamepost as rejoiningsamepostlatest WHERE rejoiningsamepostlatest.teammember_id = rejoiningsamepostdata.teammember_id)');


            $teammemberDatas = Teammember::with(['title', 'role'])
                ->leftJoinSub($latestteamrolehistory, 'latestrecord', function ($join) {
                    $join->on('latestrecord.teammember_id', '=', 'teammembers.id');
                })
                ->leftJoinSub($latestrejoiningsamepost, 'latestrecord2', function ($join) {
                    $join->on('latestrecord2.teammember_id', '=', 'teammembers.id');
                })
                ->whereNotIn('teammembers.id', [793, 878, 447])
                ->select([
                    'teammembers.*',
                    'latestrecord.newstaff_code',
                    // Combine leavingdate and joiningdate
                    DB::raw('COALESCE(latestrecord.rejoiniedexitdate, latestrecord2.rejoiniedexitdate, teammembers.leavingdate) AS final_leavingdate'),
                    DB::raw('COALESCE(latestrecord.rejoiningdate, latestrecord2.rejoiningdate, teammembers.joining_date) AS final_joiningdate'),
                ])
                // ->groupBy('teammembers.id')
                ->get();



         $latestHistory = DB::table('teamrolehistory as teamrolehistorydata')
      ->select('teamrolehistorydata.teammember_id', 'teamrolehistorydata.newstaff_code')
      ->whereRaw('teamrolehistorydata.id = (SELECT MAX(teamrolehistorylatest.id) FROM teamrolehistory as teamrolehistorylatest WHERE teamrolehistorylatest.teammember_id = teamrolehistorydata.teammember_id)');


    $teammembers = DB::table('teammembers')
      ->leftJoinSub($latestHistory, 'latestrecord', function ($join) {
        $join->on('latestrecord.teammember_id', '=', 'teammembers.id');
      })
      // ->where('teammembers.status', 1)
      ->whereIn('teammembers.role_id', [14, 15, 13, 11])
      ->select('teammembers.team_member', 'latestrecord.newstaff_code', 'teammembers.id', 'teammembers.staffcode')
      ->orderBy('team_member', 'ASC')
      ->get();

            $permotioncheck = DB::table('teamrolehistory')
      ->where('teammember_id', auth()->user()->teammember_id)
      ->orderByDesc('id')
      ->first();
         

         public function adminteammembers()
    {
        if (auth()->user()->role_id == 11) {

            $latestHistory = DB::table('teamrolehistory as teamrolehistorydata')
                ->select('teamrolehistorydata.teammember_id', 'teamrolehistorydata.newstaff_code')
                ->whereRaw('teamrolehistorydata.id = (SELECT MAX(teamrolehistorylatest.id) FROM teamrolehistory as teamrolehistorylatest WHERE teamrolehistorylatest.teammember_id = teamrolehistorydata.teammember_id)');

            $teammemberDatas = DB::table('teammembers')
                ->leftJoinSub($latestHistory, 'latestrecord', function ($join) {
                    $join->on('latestrecord.teammember_id', '=', 'teammembers.id');
                })
                ->leftJoin('roles', 'roles.id', '=', 'teammembers.role_id')
                ->where('teammembers.role_id', '!=', 11)
                ->where('teammembers.status', 1)
                ->select(
                    'teammembers.*',
                    'roles.rolename',
                    'latestrecord.newstaff_code'
                )
                ->get();

            return view('backEnd.teammember.allindex', compact('teammemberDatas'));
        }
    }
        
  public function partnersubmitted()
  {
    
    $get_datess = DB::table('timesheetreport')
      ->leftJoin('teammembers', 'teammembers.id', '=', 'timesheetreport.teamid')
      ->leftJoin('teammembers as partners', 'partners.id', '=', 'timesheetreport.partnerid')
      ->where('timesheetreport.teamid', auth()->user()->teammember_id)
      ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername')
      ->orderByDesc('timesheetreport.created_at')
      ->get();


    $get_datess = $get_datess->map(function ($item) {
      $item->staffcode = $this->getStaffCodeAt($item->teamid, $item->created_at);
      return $item;
    });

    $permissiontimesheet = DB::table('timesheetreport')
      ->where('timesheetreport.teamid', auth()->user()->teammember_id)
      ->first();

    $groupedData = $get_datess->groupBy('week')->map(function ($group) {
      $firstItem = $group->first();

      return (object) [
        'id' => $firstItem->id,
        'teamid' => $firstItem->teamid,
        'week' => $firstItem->week,
        'totaldays' => $group->sum('totaldays'),
        'totaltime' => $group->sum('totaltime'),
        'startdate' => $firstItem->startdate,
        'enddate' => $firstItem->enddate,
        'partnername' => $firstItem->partnername,
        'created_at' => $firstItem->created_at,
        'team_member' => $firstItem->team_member,
        'partnerid' => $firstItem->partnerid,
        'staffcode' => $firstItem->staffcode,
      ];
    });

    $get_date = collect($groupedData->values());

    return view('backEnd.timesheet.myteamindex', compact('get_date', 'permissiontimesheet'));
  }
        // Start Hare
          public function rejoinstore(Request $request)
    {
        $checkrole = DB::table('teammembers')
            ->where('id', $request->employeeid)
            ->select('id', 'role_id', 'staffcode', 'staffcodenumber', 'joining_date')
            ->first();

        $rejoiningcheckanotherpost = DB::table('teamrolehistory')
            ->where('teammember_id', $request->employeeid)
            ->orderByDesc('id')
            ->first();

        // if user designation change then
        if ($checkrole && $request->employeeid && $request->rejoining_date && $request->designationtype) {
            // staff can not rejoined on partner role
            if ($checkrole->role_id == 15 && $request->designationtype == 13) {
                $output = array('msg' => 'You can not rejoining this user to partner');
                return back()->with('statuss', $output);
            }

            if ($checkrole->role_id < $request->designationtype) {
                $role = '';
                if ($request->designationtype == 11) {
                    $role = "super admin";
                } elseif ($request->designationtype == 12) {
                    $role = "admin";
                } elseif ($request->designationtype == 13) {
                    $role = "partner";
                } elseif ($request->designationtype == 14) {
                    $role = "manager";
                } elseif ($request->designationtype == 15) {
                    $role = "staff";
                }
                $output = array('msg' => 'You can not rejoin on this post "' . $role . '".');
                return back()->with('statuss', $output);
            }

            // if ($checkrole->role_id != $request->designationtype) {
            $maxStaffcodeTeammembers = DB::table('teammembers')
                ->where('role_id', $request->designationtype)
                ->max('staffcodenumber');

            $maxStaffcodeTeamRoleHistory = DB::table('teamrolehistory')
                ->where('roleid_new', $request->designationtype)
                ->max('new_staffcodenumber');

            $getlateststaffcode = max($maxStaffcodeTeammembers, $maxStaffcodeTeamRoleHistory);

            if ($request->designationtype == 13) {
                if ($getlateststaffcode == null) {
                    $newstaffcode = '10001';
                } else {
                    $newstaffcode = $getlateststaffcode + 1;
                }
                $newstaffcoderesult = 'P' . $newstaffcode;
                $staffcode = $newstaffcode;
            }
            if ($request->designationtype == 14) {
                if ($getlateststaffcode == null) {
                    $newstaffcode = '20001';
                } else {
                    $newstaffcode = $getlateststaffcode + 1;
                }
                $newstaffcoderesult = 'M' . $newstaffcode;
                $staffcode = $newstaffcode;
            }

            DB::table('teammembers')
                ->where('id', $request->employeeid)
                ->update([
                    'role_id' => $request->designationtype,
                    'staffcodenumber' => $staffcode,
                    'status' => 1,
                ]);

            DB::table('users')
                ->where('teammember_id', $request->employeeid)
                ->update([
                    'role_id' => $request->designationtype,
                    'status' => 1,
                ]);


            if ($rejoiningcheckanotherpost) {
                $oldstaffcode = $rejoiningcheckanotherpost->newstaff_code;
            } else {
                $oldstaffcode = $checkrole->staffcode;
            }

            DB::table('teamrolehistory')->insert([
                'teammember_id' => $request->employeeid,
                'roleid_old' => $checkrole->role_id,
                'roleid_new' => $request->designationtype,
                // 'oldstaff_code' =>  $checkrole->staffcode,
                'oldstaff_code' =>  $oldstaffcode,
                'newstaff_code' => $newstaffcoderesult,
                'old_staffcodenumber' => $checkrole->staffcodenumber,
                'new_staffcodenumber' => $staffcode,
                'rejoiningdate' => date('Y-m-d', strtotime($request->rejoining_date)),
                //hare goes to created date 
                'rejoiningcreated' => now(),
                'rejointimesheetstatus' => 1,
                'change_type' => 'rejoining_other_post',
                //hare goes to rejoining date from form becouse all condition apply on create column it is common column for pormotion and rejoining
                'created_at' => Carbon::createFromFormat('Y-m-d', $request->rejoining_date)->toDateTimeString(),
                'updated_at' => now(),
            ]);

            $this->updateOrInsertAttendance($request->employeeid, $request->rejoining_date, $checkrole->joining_date);
        }
        // if user designation not chnge
        else {
            DB::table('teammembers')
                ->where('id', $request->employeeid)
                ->update([
                    'status' => 1,
                ]);

            DB::table('users')
                ->where('teammember_id', $request->employeeid)
                ->update([
                    'status' => 1,
                ]);

            if ($rejoiningcheckanotherpost) {
                DB::table('teamrolehistory')->insert([
                    'teammember_id' => $request->employeeid,
                    'roleid_old' => $rejoiningcheckanotherpost->roleid_new,
                    'roleid_new' => $rejoiningcheckanotherpost->roleid_new,
                    'oldstaff_code' => $rejoiningcheckanotherpost->newstaff_code,
                    'newstaff_code' => $rejoiningcheckanotherpost->newstaff_code,
                    'old_staffcodenumber' =>  $rejoiningcheckanotherpost->new_staffcodenumber,
                    'new_staffcodenumber' =>  $rejoiningcheckanotherpost->new_staffcodenumber,
                    'rejoiningdate' => date('Y-m-d', strtotime($request->rejoining_date)),
                    //hare goes to created date 
                    'rejoiningcreated' => now(),
                    'rejointimesheetstatus' => 1,
                    'change_type' => 'rejoining_same_post',
                    //hare goes to rejoining date from form becouse all condition apply on create column it is common column for pormotion and rejoining
                    'created_at' => Carbon::createFromFormat('Y-m-d', $request->rejoining_date)->toDateTimeString(),
                    'updated_at' => now(),
                ]);
            } else {
                DB::table('rejoiningsamepost')->insert([
                    'teammember_id' => $request->employeeid,
                    'rejoiningdate' => date('Y-m-d', strtotime($request->rejoining_date)),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            $this->updateOrInsertAttendance($request->employeeid, $request->rejoining_date, $checkrole->joining_date);
        }

        $output = array('msg' => 'Rejoining Successfully Done');
        return back()->with('success', $output);
    }
  public function weeklylist(Request $request)
  {
    if (auth()->user()->role_id == 13) {
      $date = DB::table('timesheetreport')->where('id', $request->id)->first();

      $timesheetData = DB::table('timesheetusers')
        ->leftJoin('teammembers', 'teammembers.id', '=', 'timesheetusers.createdby')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'timesheetusers.assignmentgenerate_id')
        ->leftJoin('clients', 'clients.id', '=', 'timesheetusers.client_id')
        ->leftJoin('assignments', 'assignments.id', '=', 'timesheetusers.assignment_id')
        ->leftJoin('teammembers as partnerid', 'partnerid.id', '=', 'timesheetusers.partner')
        ->where('timesheetusers.createdby', $request->teamid)
        ->whereIn('timesheetusers.status', [1, 2, 3])
        ->whereNotNull('timesheetusers.date')
        ->whereBetween('timesheetusers.date', [$date->startdate, $date->enddate])
        ->select(
          'timesheetusers.*',
          'assignments.assignment_name',
          'clients.client_name',
          'clients.client_code',
          'teammembers.team_member',
          'teammembers.staffcode',
          'partnerid.team_member as partnername',
          'partnerid.staffcode as partnerstaffcode',
          'assignmentbudgetings.assignmentname',
          'assignmentbudgetings.created_at as assignmentcreated',
        )
        ->orderByDesc('timesheetusers.date')
        ->get();

      // 🔹 Apply dynamic staff code (promotion/rejoin aware)
      $timesheetData = $this->promotionOrRejoined($timesheetData);
    }

    return view('backEnd.timesheet.weeklylist', compact('timesheetData'));
  }
        
  private function promotionOrRejoined($timesheetData)
  {
    $targetClients = [29, 34, 32, 33, 134];

    return $timesheetData->map(function ($row) use ($targetClients) {

      // 🔹 Optional: client-based logic (if you still want to restrict)
      if (in_array($row->client_id, $targetClients)) {
        // 🔹 Team member staffcode (auto handles rejoin/promotion)
        $row->final_teamstaffcode = $this->getStaffCodeAt($row->createdby, $row->date);
        // 🔹 Partner staffcode (auto handles rejoin/promotion)
        $row->final_partnerstaffcode = $this->getStaffCodeAt($row->partner, $row->date);
      } else {
        // 🔹 Team member staffcode (auto handles rejoin/promotion)
        $row->final_teamstaffcode = $this->getStaffCodeAt($row->createdby, $row->assignmentcreated);
        // 🔹 Partner staffcode (auto handles rejoin/promotion)
        $row->final_partnerstaffcode = $this->getStaffCodeAt($row->partner, $row->assignmentcreated);
      }

      return $row;
    });
  }
        //* regarding 

          $teamapplyleaveDatas  = DB::table('applyleaves')
        ->leftjoin('leavetypes', 'leavetypes.id', 'applyleaves.leavetype')
        ->leftjoin('teammembers', 'teammembers.id', 'applyleaves.createdby')
        ->leftjoin('teammembers as partner', 'partner.id', 'applyleaves.approver')
        ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
        ->select('applyleaves.*', 'teammembers.team_member', 'teammembers.emailid', 'roles.rolename', 'leavetypes.name', 'partner.team_member as partnername')
        ->latest()
        ->get();

      $teamapplyleaveDatas = $teamapplyleaveDatas->map(function ($item) {
        $item->teamstaffcode = $this->getStaffCodeAt($item->createdby, $item->created_at);
        $item->partnerstaffcode = $this->getStaffCodeAt($item->approver, $item->created_at);
        return $item;
      });
        
      $myapplyleaveDatas  = DB::table('applyleaves')
        ->leftjoin('leavetypes', 'leavetypes.id', 'applyleaves.leavetype')
        ->leftjoin('teammembers', 'teammembers.id', 'applyleaves.createdby')
        ->leftjoin('teammembers as partner', 'partner.id', 'applyleaves.approver')
        ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
        ->where('applyleaves.createdby', auth()->user()->teammember_id)
        ->select('applyleaves.*', 'teammembers.team_member', 'roles.rolename', 'leavetypes.name', 'partner.team_member as partnername')
        ->latest()
        ->get();

      $myapplyleaveDatas = $myapplyleaveDatas->map(function ($item) {
        $item->teamstaffcode = $this->getStaffCodeAt($item->createdby, $item->created_at);
        $item->partnerstaffcode = $this->getStaffCodeAt($item->approver, $item->created_at);
        return $item;
      });
        // Start Hare

        public function partnersubmitted()
  {
    $get_datess = DB::table('timesheetreport')
      ->leftJoin('teammembers', 'teammembers.id', '=', 'timesheetreport.teamid')
      ->leftJoin('teammembers as partners', 'partners.id', '=', 'timesheetreport.partnerid')
      ->where('timesheetreport.teamid', auth()->user()->teammember_id)
      ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername')
      ->orderByDesc('timesheetreport.created_at')
      ->get();


    $get_datess = $get_datess->map(function ($item) {
      $item->staffcode = $this->getStaffCodeAt($item->teamid, $item->created_at);
      return $item;
    });

    $permissiontimesheet = DB::table('timesheetreport')
      ->where('timesheetreport.teamid', auth()->user()->teammember_id)
      ->first();

    $groupedData = $get_datess->groupBy('week')->map(function ($group) {
      $firstItem = $group->first();

      return (object) [
        'id' => $firstItem->id,
        'teamid' => $firstItem->teamid,
        'week' => $firstItem->week,
        'totaldays' => $group->sum('totaldays'),
        'totaltime' => $group->sum('totaltime'),
        'startdate' => $firstItem->startdate,
        'enddate' => $firstItem->enddate,
        'partnername' => $firstItem->partnername,
        'created_at' => $firstItem->created_at,
        'team_member' => $firstItem->team_member,
        'partnerid' => $firstItem->partnerid,
        'staffcode' => $firstItem->staffcode,
      ];
    });

    $get_date = collect($groupedData->values());

    return view('backEnd.timesheet.myteamindex', compact('get_date', 'permissiontimesheet'));
  }
        public function partnersubmitted()
  {
    // Fetch timesheet data with necessary joins
    $get_datess = DB::table('timesheetreport')
      ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
      ->leftJoin('teamrolehistory', function ($join) {
        $join->on('teamrolehistory.teammember_id', '=', 'teammembers.id')
          ->on('teamrolehistory.created_at', '<', 'timesheetreport.created_at');
      })
      ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
      ->where('timesheetreport.teamid', auth()->user()->teammember_id)
      ->select('timesheetreport.*', 'teamrolehistory.newstaff_code', 'teammembers.team_member', 'partners.team_member as partnername', 'teammembers.staffcode')
      ->latest()
      ->get();

    // Fetch the first permission timesheet record for the authenticated user
    $permissiontimesheet = DB::table('timesheetreport')
      ->where('timesheetreport.teamid', auth()->user()->teammember_id)
      ->first();

    // Group data by week and map the necessary attributes
    $groupedData = $get_datess->groupBy('week')->map(function ($group) {
      $firstItem = $group->first();

      return (object)[
        'id' => $firstItem->id,
        'teamid' => $firstItem->teamid,
        'week' => $firstItem->week,
        'totaldays' => $group->sum('totaldays'),
        'totaltime' => $group->sum('totaltime'),
        'startdate' => $firstItem->startdate,
        'enddate' => $firstItem->enddate,
        'partnername' => $firstItem->partnername,
        'created_at' => $firstItem->created_at,
        'team_member' => $firstItem->team_member,
        'partnerid' => $firstItem->partnerid,
        'staffcode' => $firstItem->newstaff_code ?? $firstItem->staffcode,
      ];
    });

    // Convert the grouped data to a collection
    $get_date = collect($groupedData->values());

    // Return the view with the grouped data and permission timesheet
    return view('backEnd.timesheet.myteamindex', compact('get_date', 'permissiontimesheet'));
  }
        
  public function partnersubmitted()
  {
    $get_datess = DB::table('timesheetreport')
      ->leftJoin('teammembers', 'teammembers.id', '=', 'timesheetreport.teamid')
      ->leftJoin('teammembers as partners', 'partners.id', '=', 'timesheetreport.partnerid')
      ->where('timesheetreport.teamid', auth()->user()->teammember_id)
      ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername')
      ->orderByDesc('timesheetreport.created_at')
      ->get();


    $get_datess = $get_datess->map(function ($item) {
      $item->staffcode = $this->getStaffCodeAt($item->teamid, $item->created_at);
      return $item;
    });

    $permissiontimesheet = DB::table('timesheetreport')
      ->where('timesheetreport.teamid', auth()->user()->teammember_id)
      ->first();

    $groupedData = $get_datess->groupBy('week')->map(function ($group) {
      $firstItem = $group->first();

      return (object) [
        'id' => $firstItem->id,
        'teamid' => $firstItem->teamid,
        'week' => $firstItem->week,
        'totaldays' => $group->sum('totaldays'),
        'totaltime' => $group->sum('totaltime'),
        'startdate' => $firstItem->startdate,
        'enddate' => $firstItem->enddate,
        'partnername' => $firstItem->partnername,
        'created_at' => $firstItem->created_at,
        'team_member' => $firstItem->team_member,
        'partnerid' => $firstItem->partnerid,
        'staffcode' => $firstItem->staffcode,
      ];
    });

    $get_date = collect($groupedData->values());

    return view('backEnd.timesheet.myteamindex', compact('get_date', 'permissiontimesheet'));
  }


  public function getStaffCodeAt($teammember_id, $date)
  {
    // Get the latest newstaff_code before or equal to the given date
    $newCode = DB::table('teamrolehistory')
      ->where('teammember_id', $teammember_id)
      ->where('created_at', '<=', $date)
      ->orderByDesc('created_at')
      ->value('newstaff_code');

    if ($newCode) {
      return $newCode;
    }

    // If not found, get the next oldstaff_code after the date
    $oldCode = DB::table('teamrolehistory')
      ->where('teammember_id', $teammember_id)
      ->where('created_at', '>', $date)
      ->orderBy('created_at')
      ->value('oldstaff_code');

    if ($oldCode) {
      return $oldCode;
    }

    //if user not rejoined and promoted teammembers.staffcode
    return DB::table('teammembers')
      ->where('id', $teammember_id)
      ->value('staffcode');
  }
        //* regarding 
         // ->whereHas('invoices', function ($q) {
            //     $q->where('status', 2);
            // })

            {#4275 ▼
  +"currency": 3
  +"bill_date": "2025-09-17"
  +"total_amount": 75000
}
        When we Will click on the amount then we are able to see the detail breakdown in table format of Loss making Assignments.

Below are the headings of Table

Assignment Code no., Client Name,Assignment Name, Partner Name,
Manager Name,Actual Billing Amount (Exc GST),Budgeted billing Amount (Exc GST), budgeted Cost, Actual Cost,
 Budgeted Profit/loss, Actual profit/loss.
We should also have Filter on each Column.


Actual Cost = Employee Cost (Total hour*Hourly Rate)+ Reimbursements which are not reimbursed from the client+ 30 % of revenue 




        // Start Hare
        //* regarding 
        $assignments = $assignments->map(function ($assignment) {
    $totalHours = $assignment->timsheetusers
        ->filter(function($timesheet) {
            return $timesheet->createdBy && $timesheet->createdBy->role_id == 14;
        })
        ->sum(function($timesheet) {
            $hour = $timesheet->hour;
            if (is_numeric($hour)) {
                return (float) $hour;
            }
            // Convert 'HH:MM' to decimal hours
            if (preg_match('/^(\d{1,2}):(\d{2})$/', $hour, $matches)) {
                $h = intval($matches[1]);
                $m = intval($matches[2]);
                return $h + ($m / 60);
            }
            return 0; // fallback if format is unknown
        });

    $assignment->total_hours = $totalHours;
    return $assignment;
});

        // Start Hare
        
          public function billspendingforcollection(Request $request)
    {
        $yearly = $request->query('yearly');
        $monthsdigit =  $request->query('monthsdigit');
        $partnerId = $request->query('partnerId');

        $startDateFormatted = null;
        $endDateFormatted = null;

        if (!empty($yearly)) {
            [$startYear, $endYear] = explode('-', $yearly);

            $startDate = Carbon::createFromFormat('Y-m-d', $startYear . '-04-01');
            $endDate   = Carbon::createFromFormat('Y-m-d', $endYear . '-03-31');
            $startDateFormatted = $startDate->format('Y-m-d');
            $endDateFormatted = $endDate->format('Y-m-d');
        }

        $monthNames = [
            1  => 'January',
            2  => 'February',
            3  => 'March',
            4  => 'April',
            5  => 'May',
            6  => 'June',
            7  => 'July',
            8  => 'August',
            9  => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December',
        ];

        $months = !empty($monthsdigit) ? ($monthNames[$monthsdigit] ?? null) : null;

        $teammember = Teammember::where('role_id', '!=', 11)
            ->where('role_id', '!=', 12)
            ->with('title', 'role')
            ->get();

        //ffaa Bills Pending For Collection
        $outstandingDatas = DB::table('assignmentmappings')
            ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
            ->leftJoin('invoices', 'invoices.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
            ->leftJoin('outstandings', 'outstandings.BILL_NO', '=', 'invoices.invoice_id')
            ->leftJoin('teammembers', 'teammembers.id', '=', 'outstandings.Partner')
            ->whereNotNull('invoices.id')
            ->where('assignmentbudgetings.status', 0)
            ->when(!empty($yearly), function ($query) use ($startDateFormatted, $endDateFormatted) {
                $query->whereBetween(DB::raw('COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate)'), [$startDateFormatted, $endDateFormatted]);
            })
            ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
                $query->whereMonth(DB::raw('COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate)'), $monthsdigit);
            })
            ->when(!empty($partnerId), function ($query) use ($partnerId) {
                $query->where('invoices.partner', $partnerId);
            })
            ->where(function ($q) {
                $q->whereIn('invoices.currency', [1, 3])
                    ->orWhereNull('invoices.currency');
            })
            ->select(
                'outstandings.*',
                'invoices.currency',
                DB::raw("DATE_FORMAT(outstandings.created_at, '%Y-%m-%d') as bill_date"),
                'teammembers.team_member'
            )
            ->get();


        // dd($outstandingDatas);

        $billspendingforcollection = $this->convertusdtoinr(
            $outstandingDatas->map(function ($item) {
                return (object)[
                    'currency'      => $item->currency,
                    'bill_date'     => $item->bill_date,
                    'total_amount'  => $item->AMT
                ];
            })
        );

        $total = $billspendingforcollection;
        return view('backEnd.outstanding.index', compact('outstandingDatas', 'total', 'teammember'));
    }

    public function assignmentscompleted(Request $request)
    {
        $yearly = $request->query('yearly');
        $monthsdigit =  $request->query('monthsdigit');
        $partnerId = $request->query('partnerId');

        $startDateFormatted = null;
        $endDateFormatted = null;

        if (!empty($yearly)) {
            [$startYear, $endYear] = explode('-', $yearly);

            $startDate = Carbon::createFromFormat('Y-m-d', $startYear . '-04-01');
            $endDate   = Carbon::createFromFormat('Y-m-d', $endYear . '-03-31');
            $startDateFormatted = $startDate->format('Y-m-d');
            $endDateFormatted = $endDate->format('Y-m-d');
        }

        $monthNames = [
            1  => 'January',
            2  => 'February',
            3  => 'March',
            4  => 'April',
            5  => 'May',
            6  => 'June',
            7  => 'July',
            8  => 'August',
            9  => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December',
        ];

        $months = !empty($monthsdigit) ? ($monthNames[$monthsdigit] ?? null) : null;

        //ffaa How many Assignments Completed in this months
        $assignments = Assignmentmapping::with([
            'assignmentBudgeting.client:id,client_name',
            'assignmentBudgeting.assignment:id,assignment_name',
            'leadPartner:id,team_member',
            'otherPartner:id,team_member',
            'reviewerPartner:id,team_member',
            'assignmentTeamMappings.teamMember:id,team_member',
            'timsheetusers.createdBy:id,role_id'
        ])
            ->when(!empty($yearly), function ($query) use ($startDateFormatted, $endDateFormatted) {
                $query->whereHas('assignmentBudgeting', function ($q) use ($startDateFormatted, $endDateFormatted) {
                    $q->whereBetween('otpverifydate', [$startDateFormatted, $endDateFormatted]);
                });
            })
            ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
                $query->whereHas('assignmentBudgeting', function ($q) use ($monthsdigit) {
                    $q->whereMonth('otpverifydate', $monthsdigit);
                });
            })
            ->when(!empty($partnerId), function ($query) use ($partnerId) {
                $query->where('leadpartner', $partnerId);
            })
            ->get();

        $assignments = $assignments->map(function ($assignment) {
            $totalHours = $assignment->timsheetusers
                ->where('createdBy.role_id', 14)
                ->sum('hour');

            $assignment->total_hours = $totalHours;
            return $assignment;
        });

        return view('backEnd.dashboardreport.billspendingassignment', compact('assignments'));
    }

    public function delayedassignments(Request $request)
    {
        $yearly = $request->query('yearly');
        $monthsdigit =  $request->query('monthsdigit');
        $partnerId = $request->query('partnerId');

        $startDateFormatted = null;
        $endDateFormatted = null;

        if (!empty($yearly)) {
            [$startYear, $endYear] = explode('-', $yearly);

            $startDate = Carbon::createFromFormat('Y-m-d', $startYear . '-04-01');
            $endDate   = Carbon::createFromFormat('Y-m-d', $endYear . '-03-31');
            $startDateFormatted = $startDate->format('Y-m-d');
            $endDateFormatted = $endDate->format('Y-m-d');
        }

        $monthNames = [
            1  => 'January',
            2  => 'February',
            3  => 'March',
            4  => 'April',
            5  => 'May',
            6  => 'June',
            7  => 'July',
            8  => 'August',
            9  => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December',
        ];

        $months = !empty($monthsdigit) ? ($monthNames[$monthsdigit] ?? null) : null;

        //ffaa How many Delayed Assignments
        $assignments = Assignmentmapping::with([
            'assignmentBudgeting.client:id,client_name',
            'assignmentBudgeting.assignment:id,assignment_name',
            'leadPartner:id,team_member',
            'otherPartner:id,team_member',
            'reviewerPartner:id,team_member',
            'assignmentTeamMappings.teamMember:id,team_member',
            'timsheetusers.createdBy:id,role_id'
        ])
            ->whereHas('assignmentBudgeting', function ($q) {
                $q->where('status', 1);
            })
            ->whereHas('assignmentBudgeting', function ($q) {
                $q->whereRaw('COALESCE(DATE(actualenddate), DATE(tentativeenddate)) < ?', [Carbon::today()->toDateString()]);
            })
            ->when(!empty($yearly), function ($query) use ($startDateFormatted, $endDateFormatted) {
                $query->whereHas('assignmentBudgeting', function ($q) use ($startDateFormatted, $endDateFormatted) {
                    $q->whereBetween(DB::raw('COALESCE(DATE(actualenddate), DATE(tentativeenddate))'), [$startDateFormatted, $endDateFormatted]);
                });
            })
            ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
                $query->whereHas('assignmentBudgeting', function ($q) use ($monthsdigit) {
                    $q->whereMonth(DB::raw('COALESCE(DATE(actualenddate), DATE(tentativeenddate))'), $monthsdigit);
                });
            })
            ->when(!empty($partnerId), function ($query) use ($partnerId) {
                $query->where('leadpartner', $partnerId);
            })
            ->get();


        $assignments = $assignments->map(function ($assignment) {
            $totalHours = $assignment->timsheetusers
                ->where('createdBy.role_id', 14)
                ->sum('hour');

            $assignment->total_hours = $totalHours;
            return $assignment;
        });

        return view('backEnd.dashboardreport.billspendingassignment', compact('assignments'));
    }
        public function billspending(Request $request)
{
    $partnerId = $request->query('partnerId');
    $yearly = $request->query('yearly');
    $monthsdigit = $request->query('monthsdigit');

    // Validate yearly format
    if (!preg_match('/^\d{4}-\d{4}$/', $yearly)) {
        abort(400, 'Invalid yearly format');
    }

    [$startYear, $endYear] = explode('-', $yearly);
    
    // Financial year date range
    $startDate = Carbon::createFromFormat('Y-m-d', $startYear . '-04-01');
    $endDate = Carbon::createFromFormat('Y-m-d', $endYear . '-03-31');
    $startDateFormatted = $startDate->format('Y-m-d');
    $endDateFormatted = $endDate->format('Y-m-d');

    $assignments = Assignmentmapping::with([
        'assignmentBudgeting.client:id,client_name',
        'assignmentBudgeting.assignment:id,assignment_name',
        'leadPartner:id,team_member',
        'otherPartner:id,team_member',
        'reviewerPartner:id,team_member',
        'assignmentTeamMappings.teamMember:id,team_member',
        'timesheetUsers.createdBy:id,role_id' // Fixed relationship name
    ])
    ->whereHas('assignmentBudgeting', function ($q) {
        $q->where('status', 0);
    })
    ->where(function($query) use ($startDateFormatted, $endDateFormatted) {
        $query->whereHas('assignmentBudgeting', function($q) use ($startDateFormatted, $endDateFormatted) {
            $q->whereBetween('actualenddate', [$startDateFormatted, $endDateFormatted])
              ->orWhereBetween('tentativeenddate', [$startDateFormatted, $endDateFormatted]);
        });
    })
    ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
        $query->whereHas('assignmentBudgeting', function($q) use ($monthsdigit) {
            $q->where(function($q2) use ($monthsdigit) {
                $q2->whereMonth('actualenddate', $monthsdigit)
                   ->orWhereMonth('tentativeenddate', $monthsdigit);
            });
        });
    })
    ->when(!empty($partnerId), function ($query) use ($partnerId) {
        $query->where('leadpartner', $partnerId);
    })
    ->whereDoesntHave('invoices')
    ->get();

    // Calculate total hours
    $assignments->each(function ($assignment) {
        $assignment->total_hours = $assignment->timesheetUsers
            ->where('createdBy.role_id', 14)
            ->sum('hour');
    });

    return view('backEnd.dashboardreport.billspendingassignment', compact('assignments'));
}
          public function billspendingforcollection(Request $request)
    {
        $partnerId = $request->query('partnerId');
        $yearly = $request->query('yearly');
        $monthsdigit = $request->query('monthsdigit');

        // dd($partnerId,  $yearly, $monthsdigit);

        $teammember = Teammember::where('role_id', '!=', 11)
            ->where('role_id', '!=', 12)
            ->with('title', 'role')
            ->get();

        $outstandingDatas = DB::table('assignmentmappings')
            ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
            ->leftJoin('invoices', 'invoices.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
            ->leftJoin('outstandings', 'outstandings.BILL_NO', '=', 'invoices.invoice_id')
            ->leftJoin('teammembers', 'teammembers.id', '=', 'outstandings.Partner')
            ->whereNotNull('invoices.id')
            ->where('assignmentbudgetings.status', 0)
            ->where(function ($q) {
                $q->whereIn('invoices.currency', [1, 3])
                    ->orWhereNull('invoices.currency');
            })
            ->select(
                'outstandings.*',
                'invoices.currency',
                DB::raw("DATE_FORMAT(outstandings.created_at, '%Y-%m-%d') as bill_date"),
                'teammembers.team_member'
            )
            ->get();

        // dd($outstandingDatas);

        $billspendingforcollection = $this->convertusdtoinr(
            $outstandingDatas->map(function ($item) {
                return (object)[
                    'currency'      => $item->currency,
                    'bill_date'     => $item->bill_date,
                    'total_amount'  => $item->AMT
                ];
            })
        );

        $total = $billspendingforcollection;
        return view('backEnd.outstanding.index', compact('outstandingDatas', 'total', 'teammember'));
    }
         if (!empty($partnerId)) {
        $query->where('assignmentmappings.leadpartner', $partnerId);
      }

	  
	  
      ->when(!empty($partnerId), function ($query) use ($partnerId) {
          $query->where('assignmentmappings.leadpartner', $partnerId);
        })
        //* regarding 
          public function filterdashboardreport(Request $request)
  {

    $yearly = $request->input('yearly');
    $monthsdigit = $request->input('months');
    [$startYear, $endYear] = explode('-', $yearly);
    // if (!empty($monthsdigit)) {
    //   $monthNames = [
    //     1  => 'January',
    //     2  => 'February',
    //     3  => 'March',
    //     4  => 'April',
    //     5  => 'May',
    //     6  => 'June',
    //     7  => 'July',
    //     8  => 'August',
    //     9  => 'September',
    //     10 => 'October',
    //     11 => 'November',
    //     12 => 'December',
    //   ];
    //   $months = $monthNames[$monthsdigit];
    // }

    $monthNames = [
      1  => 'January',
      2  => 'February',
      3  => 'March',
      4  => 'April',
      5  => 'May',
      6  => 'June',
      7  => 'July',
      8  => 'August',
      9  => 'September',
      10 => 'October',
      11 => 'November',
      12 => 'December',
    ];

    $months = !empty($monthsdigit) ? ($monthNames[$monthsdigit] ?? null) : null;

    // financial year date range using input years
    $startDate = Carbon::createFromFormat('Y-m-d', $startYear . '-04-01');
    $endDate   = Carbon::createFromFormat('Y-m-d', $endYear . '-03-31');
    $startDateFormatted = $startDate->format('Y-m-d');
    $endDateFormatted = $endDate->format('Y-m-d');

    if (auth()->user()->role_id == 11) {

      // KPI filter start from hare 
      //ff How many amounts pending for invoice genrated
      $billspendingQuery = DB::table('assignmentmappings')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->leftJoin('invoices', 'invoices.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->whereBetween(DB::raw('COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate)'), [$startDateFormatted, $endDateFormatted])
        ->where(function ($query) use ($startDateFormatted, $endDateFormatted) {
          $query->whereNull('invoices.created_at')
            ->orWhereNotBetween('invoices.created_at', [$startDateFormatted, $endDateFormatted]);
        })
        ->where('assignmentbudgetings.status', 0);

      if (!empty($monthsdigit)) {
        $billspendingQuery->whereMonth(DB::raw('COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate)'), $monthsdigit);
      }

      $billspending = $billspendingQuery->sum('assignmentmappings.engagementfee');


      //ff Bills Pending For Collection
      $billspendingforcollectionQuery = DB::table('assignmentmappings')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->leftJoin('invoices', 'invoices.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->leftJoin('outstandings', 'outstandings.BILL_NO', '=', 'invoices.invoice_id')
        ->where('assignmentbudgetings.status', 0)
        // ensures invoice is created
        ->whereNotNull('invoices.id')
        ->whereBetween(DB::raw('COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate)'), [$startDateFormatted, $endDateFormatted])
        ->whereBetween('invoices.created_at', [$startDateFormatted, $endDateFormatted]);

      if (!empty($monthsdigit)) {
        $billspendingforcollectionQuery->whereMonth('invoices.created_at', $monthsdigit);
      }
      $billspendingforcollection = $billspendingforcollectionQuery->sum('outstandings.AMT');


      //ff How many amounts pending for collection within 15 days or Payments Not Recieved
      $billspending15Days = DB::table('assignmentmappings')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->leftJoin('invoices', 'invoices.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->leftJoin('payments', 'payments.invoiceid', '=', 'invoices.invoice_id')
        ->where('assignmentbudgetings.status', 0)
        ->whereNotNull('invoices.id') // Invoice is created
        ->whereNull('payments.invoiceid') // Payment not yet received
        ->whereBetween('invoices.created_at', [$startDateFormatted, $endDateFormatted])
        ->when(!empty($monthsdigit), function ($query) use ($monthsdigit, $startYear, $endYear) {
          $yearForMonth = $monthsdigit >= 4 ? $startYear : $endYear;
          $monthEnd = Carbon::create($yearForMonth, $monthsdigit, 1)->endOfMonth();
          // $monthStart = $monthEnd->copy()->subDays(28);
          $monthStart = $monthEnd->copy()->subDays(15);
          return $query->whereYear('invoices.created_at', $yearForMonth)
            ->whereMonth('invoices.created_at', $monthsdigit)
            ->whereBetween('invoices.created_at', [$monthStart, $monthEnd]);
        })
        ->when(empty($monthsdigit), function ($query) use ($endDateFormatted) {
          return $query->whereDate('invoices.created_at', '>=', Carbon::parse($endDateFormatted)->subDays(15));
        })
        ->sum('invoices.total');


      //ffaa How many Assignments Completed in this months
      $query = DB::table('assignmentmappings')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id');
      $query->whereBetween('assignmentbudgetings.otpverifydate', [$startDateFormatted, $endDateFormatted]);
      if (!empty($monthsdigit)) {
        $query->whereMonth('assignmentbudgetings.otpverifydate', $monthsdigit);
      }
      $assignmentcompleted = $query->count();

      //ffaa How many Delayed Assignments
      $delayedQuery = DB::table('assignmentmappings')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->whereRaw('COALESCE(DATE(assignmentbudgetings.actualenddate), DATE(assignmentbudgetings.tentativeenddate)) < ?', [Carbon::today()->toDateString()])
        ->whereBetween(DB::raw('COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate)'), [$startDateFormatted, $endDateFormatted]);
      if (!empty($monthsdigit)) {
        $delayedQuery->whereMonth(DB::raw('COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate)'), $monthsdigit);
      }
      $delayedAssignments = $delayedQuery->count();


      //ffaa total amount of convence, how many amount approved for convence in this months or Exceptional Expenses 
      $exceptionalQuery = DB::table('outstationconveyances')
        ->where('status', 6)
        ->whereBetween('approveddate', [$startDateFormatted, $endDateFormatted]);
      if (!empty($monthsdigit)) {
        $exceptionalQuery->whereMonth('approveddate', $monthsdigit);
      }
      $exceptionalExpenses = $exceptionalQuery->sum('finalamount');


      //ffaa How many New Tenders Submitted this months
      $tendersQuery = DB::table('tenders')
        ->where('tendersubmitstatus', 1)
        ->whereBetween('date', [$startDateFormatted, $endDateFormatted]);
      if (!empty($monthsdigit)) {
        $tendersQuery->whereMonth('date', $monthsdigit);
      }
      $tendersSubmittedCount = $tendersQuery->count();


      //ffaa how many users not accepted Audit Acceptance Pending mail till now
      $totalNotFilled = DB::table('assignmentmappings')
        ->select(DB::raw('COUNT(*) as total_not_filled'))
        ->leftJoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->leftJoin('teammembers', 'teammembers.id', '=', 'assignmentteammappings.teammember_id')
        ->leftJoin('annual_independence_declarations', function ($join) {
          $join->on('annual_independence_declarations.assignmentgenerateid', '=', 'assignmentmappings.assignmentgenerate_id')
            ->on('annual_independence_declarations.createdby', '=', 'teammembers.id')
            ->where('annual_independence_declarations.type', 2);
        })
        ->whereNull('annual_independence_declarations.id') // Members without declarations
        ->whereBetween(DB::raw('COALESCE(assignmentbudgetings.actualstartdate, assignmentbudgetings.tentativestartdate)'), [$startDateFormatted, $endDateFormatted])
        ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
          $query->whereMonth(DB::raw('COALESCE(assignmentbudgetings.actualstartdate, assignmentbudgetings.tentativestartdate)'), $monthsdigit);
        })
        ->groupBy('assignmentmappings.assignmentgenerate_id')
        ->get()
        ->sum('total_not_filled');


      //ffaa How many NAFRA are running
      $auditsDueQuery = DB::table('assignmentmappings')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->where('assignmentbudgetings.status', 1)
        ->where('assignmentmappings.eqcrapplicability', 1)
        ->whereBetween(DB::raw('COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate)'), [$startDateFormatted, $endDateFormatted]);
      if (!empty($monthsdigit)) {
        $auditsDueQuery->whereMonth(DB::raw('COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate)'), $monthsdigit);
      }
      $auditsDue = $auditsDueQuery->count();

      //ffaa Upcoming Assignments
      $upcomingQuery = DB::table('assignmentplannings')
        ->whereDate('assignmentstartdate', '>=', Carbon::today())
        ->whereBetween('assignmentstartdate', [$startDateFormatted, $endDateFormatted]);
      if (!empty($monthsdigit)) {
        $upcomingQuery->whereMonth('assignmentstartdate', $monthsdigit);
      }
      $upcomingFromPlannings = $upcomingQuery->count();


      $upcomingFromBudgetingsQuery = DB::table('assignmentbudgetings')
        ->whereRaw('COALESCE(actualstartdate, tentativestartdate) > ?', [Carbon::today()->toDateString()])
        ->whereBetween(DB::raw('COALESCE(actualstartdate, tentativestartdate)'), [$startDateFormatted, $endDateFormatted]);
      if (!empty($monthsdigit)) {
        $upcomingFromBudgetingsQuery->whereMonth(DB::raw('COALESCE(actualstartdate, tentativestartdate)'), $monthsdigit);
      }
      $upcomingFromBudgetings = $upcomingFromBudgetingsQuery->count();
      $totalUpcomingAssignments = $upcomingFromPlannings + $upcomingFromBudgetings;


      //ffaa Timesheet Filled On Closed Assignment
      $timesheetOnClosedAssignment = DB::table('assignmentmappings')
        ->join('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->join('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
        ->whereExists(function ($query) {
          $query->select(DB::raw(1))
            ->from('timesheetusers')
            ->whereRaw('timesheetusers.assignmentgenerate_id = assignmentmappings.assignmentgenerate_id')
            ->whereRaw("DATE(timesheetusers.created_at) > DATE(COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate))");
        })
        ->whereBetween(DB::raw('COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate)'), [$startDateFormatted, $endDateFormatted])
        ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
          $query->whereMonth(DB::raw('COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate)'), $monthsdigit);
        })
        ->select('assignmentmappings.assignmentgenerate_id')
        ->distinct()
        ->count();

      //ffaa Work From Home 
      $workFromHomeQuery = DB::table('checkins')
        ->where('checkin_from', 'Work From Home')
        ->whereBetween('created_at', [$startDateFormatted, $endDateFormatted]);
      if (!empty($monthsdigit)) {
        $workFromHomeQuery->whereMonth('created_at', $monthsdigit);
      }
      $workFromHome = $workFromHomeQuery->count();

      // KPI filter end from hare 

      //ffbb Assignment Status Overview
      $assignmentOverviews = DB::table('assignmentmappings')
        ->whereBetween('assignmentmappings.created_at', [$startDateFormatted, $endDateFormatted])
        ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
          $query->whereMonth('assignmentmappings.created_at', $monthsdigit);
        })
        ->select(
          'assignmentmappings.*',
          'assignmentbudgetings.assignmentname',
          'assignmentbudgetings.status',
          DB::raw('COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate) as finalassignmentenddate'),
          'clients.client_name',
          DB::raw('(SELECT SUM(totalhour) FROM timesheetusers WHERE timesheetusers.assignmentgenerate_id = assignmentmappings.assignmentgenerate_id) as workedHours')
        )
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->leftJoin('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
        ->orderByDesc('assignmentbudgetings.id')
        ->get()
        ->map(function ($assignmentOverview) {
          $totalHours = $assignmentOverview->esthours ?? 0;
          $workedHours = $assignmentOverview->workedHours ?? 0;
          $completionPercentage = $totalHours > 0 ? round(($workedHours / $totalHours) * 100, 2) : 0;
          $assignmentOverview->completionPercentage = $completionPercentage;
          return $assignmentOverview;
        });


      //ffbb Document Completion Progress
      $documentCompletions = DB::table('assignmentmappings')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->leftJoin('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
        // ->where('assignmentbudgetings.status', 1)
        ->whereBetween('assignmentmappings.created_at', [$startDateFormatted, $endDateFormatted])
        ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
          $query->whereMonth('assignmentmappings.created_at', $monthsdigit);
        })
        ->orderByDesc('assignmentbudgetings.id')
        ->select(
          'assignmentmappings.*',
          'assignmentbudgetings.assignmentname',
          'clients.client_name'
        )
        ->get();


      foreach ($documentCompletions as $mapping) {
        $assignmentId = $mapping->assignmentgenerate_id;

        // Get assignment_id and eqcrapplicability
        $assignmentMapping = DB::table('assignmentmappings')
          ->where('assignmentgenerate_id', $assignmentId)
          ->select('assignment_id', 'eqcrapplicability')
          ->first();

        // Determine EQCR type name
        $eqcrTypeName = '';
        $eqcrAssignmentId = null;
        if (isset($assignmentMapping->eqcrapplicability)) {
          switch ($assignmentMapping->eqcrapplicability) {
            case 1:
              $eqcrTypeName = 'NFRA';
              break;
            case 2:
              $eqcrTypeName = 'Quality Review';
              break;
            case 3:
              $eqcrTypeName = 'Peer Review';
              break;
            case 4:
              $eqcrTypeName = 'Others';
              break;
            case 5:
              $eqcrTypeName = 'PCAOB';
              break;
          }
          // Get the assignment_id for the EQCR type
          $specialAssignment = DB::table('assignments')
            ->where('assignment_name', $eqcrTypeName)
            ->first();
          if ($specialAssignment) {
            $eqcrAssignmentId = $specialAssignment->id;
          }
        }
        $mapping->eqcr_type_name = $eqcrTypeName;

        // Regular Checklist Calculations (Exclude EQCR assignment_id)
        $classificationIds = DB::table('financialstatementclassifications')
          ->where('assignment_id', $assignmentMapping->assignment_id)
          ->where(function ($q) use ($assignmentId) {
            $q->whereNull('assignmentgenerate_id')->orWhere('assignmentgenerate_id', $assignmentId);
          })
          ->when($eqcrAssignmentId, function ($query) use ($eqcrAssignmentId) {
            $query->where('assignment_id', '!=', $eqcrAssignmentId);
          })
          ->pluck('id');



        $subClassIds = DB::table('subfinancialclassfications')
          ->whereIn('financialstatemantclassfication_id', $classificationIds)
          ->pluck('id');



        $totalQuestions = DB::table('auditquestions')
          ->whereIn('financialstatemantclassfication_id', $classificationIds)
          ->whereIn('subclassfied_id', $subClassIds)
          ->count();


        $statusCounts = DB::table('checklistanswers')
          ->join('statuses', 'checklistanswers.status', '=', 'statuses.id')
          ->where('checklistanswers.assignment_id', $assignmentId)
          ->whereIn('checklistanswers.financialstatemantclassfication_id', $classificationIds)
          ->whereIn('checklistanswers.subclassfied_id', $subClassIds)
          ->select(
            'statuses.name as status_name',
            DB::raw('COUNT(*) as count')
          )
          ->groupBy('statuses.name')
          ->pluck('count', 'status_name');



        $closedQuestions = $statusCounts['CLOSE'] ?? 0;

        $mapping->documentation_percentage = $totalQuestions > 0
          ? round(($closedQuestions / $totalQuestions) * 100, 2)
          : 0;
      }
      // Document Completion Progress end hare 

      //ffbb NFRA Audits, Quality Reviews & Peer Review
      $ecqrAudits = DB::table('assignmentmappings')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.eqcrpartner')
        ->leftJoin('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
        // ->where('assignmentbudgetings.status', 1)
        ->whereBetween('assignmentmappings.created_at', [$startDateFormatted, $endDateFormatted])
        ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
          $query->whereMonth('assignmentmappings.created_at', $monthsdigit);
        })
        ->whereIn('assignmentmappings.eqcrapplicability', [1, 2, 3])
        ->select(
          'assignmentmappings.*',
          'teammembers.team_member',
          'assignmentbudgetings.assignmentname',
          'assignmentbudgetings.status',
          DB::raw('COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate) as finalassignmentenddate'),
          'clients.client_name'
        )
        // ->limit(3)
        ->get();

      foreach ($ecqrAudits as $audit) {
        $assignmentId = $audit->assignmentgenerate_id;

        // get reviewer assignment id (based on eqcrapplicability)
        $eqcrTypeName = '';
        $eqcrAssignmentId = null;
        switch ($audit->eqcrapplicability) {
          case 1:
            $eqcrTypeName = 'NFRA';
            break;
          case 2:
            $eqcrTypeName = 'Quality Review';
            break;
          case 3:
            $eqcrTypeName = 'Peer Review';
            break;
          case 4:
            $eqcrTypeName = 'Others';
            break;
          case 5:
            $eqcrTypeName = 'PCAOB';
            break;
        }
        if ($eqcrTypeName) {
          $specialAssignment = DB::table('assignments')
            ->where('assignment_name', $eqcrTypeName)
            ->first();
          if ($specialAssignment) {
            $eqcrAssignmentId = $specialAssignment->id;
          }
        }

        $audit->reviewer_documentation_percentage = 0;

        if ($eqcrAssignmentId) {
          $reviewerClassificationIds = DB::table('financialstatementclassifications')
            ->where('assignment_id', $eqcrAssignmentId)
            ->where(function ($q) use ($assignmentId) {
              $q->whereNull('assignmentgenerate_id')->orWhere('assignmentgenerate_id', $assignmentId);
            })
            ->pluck('id');

          $reviewerSubClassIds = DB::table('subfinancialclassfications')
            ->whereIn('financialstatemantclassfication_id', $reviewerClassificationIds)
            ->pluck('id');

          $reviewerTotalQuestions = DB::table('auditquestions')
            ->whereIn('financialstatemantclassfication_id', $reviewerClassificationIds)
            ->whereIn('subclassfied_id', $reviewerSubClassIds)
            ->count();

          $reviewerStatusCounts = DB::table('checklistanswers')
            ->join('statuses', 'checklistanswers.status', '=', 'statuses.id')
            ->where('checklistanswers.assignment_id', $assignmentId)
            ->whereIn('checklistanswers.financialstatemantclassfication_id', $reviewerClassificationIds)
            ->whereIn('checklistanswers.subclassfied_id', $reviewerSubClassIds)
            ->select('statuses.name as status_name', DB::raw('COUNT(*) as count'))
            ->groupBy('statuses.name')
            ->pluck('count', 'status_name');

          $reviewerClosed =  ($reviewerStatusCounts['CLOSE'] ?? 0) +
            ($reviewerStatusCounts['NOT-APPLICABLE'] ?? 0);

          $audit->reviewer_documentation_percentage = $reviewerTotalQuestions > 0
            ? round(($reviewerClosed / $reviewerTotalQuestions) * 100, 2)
            : 0;
        }
      }

      //ffbb Partner-wise P&L Statement
      $assignmentGenerateIds = DB::table('assignmentbudgetings')
        ->whereBetween('periodstartdate', [$startDateFormatted, $endDateFormatted])
        ->whereBetween('periodenddate', [$startDateFormatted, $endDateFormatted])
        ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
          $query->whereMonth('periodstartdate', $monthsdigit)
            ->whereMonth('periodenddate', $monthsdigit);
        })
        ->pluck('assignmentgenerate_id');

      $invoices = DB::table('invoices')
        ->select(
          'invoices.assignmentgenerate_id',
          'teammembers.team_member',
          DB::raw('SUM(invoices.total) as total')
        )
        ->join('teammembers', 'teammembers.id', '=', 'invoices.partner')
        ->whereIn('invoices.assignmentgenerate_id', $assignmentGenerateIds)
        ->groupBy('invoices.assignmentgenerate_id', 'teammembers.team_member')
        ->get();

      $timesheetData = DB::table('timesheetusers')
        ->select('assignmentgenerate_id', 'createdby', DB::raw('SUM(totalhour) as total_hour'))
        ->whereIn('assignmentgenerate_id', $assignmentGenerateIds)
        ->groupBy('assignmentgenerate_id', 'createdby')
        ->get();

      $teamMemberCosts = DB::table('teammembers')
        ->whereIn('id', $timesheetData->pluck('createdby')->unique())
        ->pluck('cost_hour', 'id');

      $groupedCosts = $timesheetData->groupBy('assignmentgenerate_id')->map(function ($rows) use ($teamMemberCosts) {
        return $rows->sum(function ($row) use ($teamMemberCosts) {
          return $row->total_hour * ($teamMemberCosts[$row->createdby] ?? 0);
        });
      });

      $finalData = $invoices->map(function ($row) use ($groupedCosts) {
        $row->cost = $groupedCosts[$row->assignmentgenerate_id] ?? 0;
        $row->profit_loss = $row->total - $row->cost;
        return $row;
      });

      $partnerWiseProfit = $finalData
        ->groupBy('team_member')
        ->map(function ($items, $teamMember) {
          return (object)[
            'team_member' => $teamMember,
            'total' => $items->sum(fn($item) => (float) $item->total),
            'cost' => $items->sum('cost'),
            'profit_loss' => $items->sum('profit_loss'),
          ];
        })
        // Reset index if needed
        ->values();

      // Partner-wise P&L Statement end hare

      //ffbb Assignment-wise P&L Analysis and Loss Making Assignments
      $assignmentprofitandlosses = DB::table('assignmentmappings')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->leftJoin('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
        ->whereBetween('assignmentmappings.created_at', [$startDateFormatted, $endDateFormatted])
        ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
          $query->whereMonth('assignmentmappings.created_at', $monthsdigit);
        })
        ->orderByDesc('assignmentbudgetings.id')
        ->select(
          'assignmentmappings.*',
          'assignmentbudgetings.assignmentname',
          'assignmentbudgetings.status',
          DB::raw('COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate) as finalassignmentenddate'),
          'clients.client_name'
        )
        // ->limit(6)
        ->get();

      $assignmentCosts = DB::table('timesheetusers')
        ->leftJoin('teammembers', 'teammembers.id', '=', 'timesheetusers.createdby')
        // ->where('timesheetusers.assignmentgenerate_id', 254418551033)
        // ->whereBetween(DB::raw("STR_TO_DATE(timesheetusers.date, '%d-%m-%Y')"), [
        //   $financialStartDate->format('Y-m-d'),
        //   $financialEndDate->format('Y-m-d')
        // ])
        ->select('timesheetusers.assignmentgenerate_id', DB::raw('SUM(timesheetusers.totalhour * teammembers.cost_hour) as total_cost'))
        ->groupBy('timesheetusers.assignmentgenerate_id')
        ->pluck('total_cost', 'assignmentgenerate_id');

      // dd($assignmentprofitandlosses);

      $lossMakingCount = 0;
      foreach ($assignmentprofitandlosses as $assignment) {
        $assignment->total_cost = $assignmentCosts[$assignment->assignmentgenerate_id] ?? 0;

        // Loss Making Assignments
        $revenue = $assignment->engagementfee ?? 0;
        $cost = $assignment->total_cost ?? 0;
        $profit = $revenue - $cost;

        if ($profit < 0) {
          $lossMakingCount++;
        }
      }

      //ffbb Monthly Expense Analysis 
      $teamsSalaries = DB::table('employeepayrolls')
        ->select(
          'month',
          'year',
          DB::raw('SUM(total_amount_to_paid) as total_amount')
        )
        ->where(function ($query) use ($endYear, $startYear) {
          // Jan to Mar from next year
          $query->where(function ($q) use ($endYear) {
            $q->where('year', $endYear);
            // ->whereIn('month', ['January', 'February', 'March']);
          })
            // Apr to Jun from current year
            ->orWhere(function ($q) use ($startYear) {
              $q->where('year', $startYear);
              // ->whereIn('month', ['April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']);
            });
        })
        ->where('send_to_bank', 1)
        ->when(!empty($months), function ($query) use ($months) {
          $query->where('month', $months);
        })
        ->groupBy('year', 'month')
        ->orderByRaw("FIELD(month, 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December', 'January', 'February', 'March')")
        ->get();


      $teamexceptionalExpenses = DB::table('outstationconveyances')
        ->selectRaw('MONTH(approveddate) as month, YEAR(approveddate) as year, SUM(finalamount) as total_amount')
        ->where('status', 6)
        ->whereBetween('approveddate', [
          $startDateFormatted,
          $endDateFormatted
        ])
        ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
          $query->whereMonth('approveddate', $monthsdigit);
        })
        ->groupByRaw('MONTH(approveddate), YEAR(approveddate)')
        ->orderByRaw('FIELD(MONTH(approveddate),  4,5,6,7,8,9,10,11,12,1,2,3)')
        ->get()
        ->map(function ($item) use ($monthNames) {
          $item->month = $monthNames[$item->month] ?? $item->month;
          return $item;
        });


      //ffbb Cash Flow Analysis
      $cashFlowRecieved = DB::table('payments')
        ->selectRaw('MONTH(paymentdate) as month, YEAR(paymentdate) as year, SUM(amountreceived) as amountreceived')
        ->whereBetween('paymentdate', [
          $startDateFormatted,
          $endDateFormatted
        ])
        ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
          $query->whereMonth('paymentdate', $monthsdigit);
        })
        ->groupByRaw('MONTH(paymentdate), YEAR(paymentdate)')
        ->orderByRaw('FIELD(MONTH(paymentdate), 4,5,6,7,8,9,10,11,12,1,2,3)')
        ->get()
        ->map(function ($item) use ($monthNames) {
          $item->month = $monthNames[$item->month] ?? $item->month;
          return $item;
        });

      $cashFlowSpendvender = DB::table('vendorlist')
        ->selectRaw('MONTH(approvedate) as month, YEAR(approvedate) as year, SUM(amount) as total_amounts')
        ->where('status', 4)
        ->whereBetween('approvedate', [
          $startDateFormatted,
          $endDateFormatted
        ])
        ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
          $query->whereMonth('approvedate', $monthsdigit);
        })
        ->groupByRaw('MONTH(approvedate), YEAR(approvedate)')
        ->orderByRaw('FIELD(MONTH(approvedate), 4,5,6,7,8,9,10,11,12,1,2,3)')
        ->get()
        ->map(function ($item) use ($monthNames) {
          $item->month = $monthNames[$item->month] ?? $item->month;
          return $item;
        });

      $cashFlowSpendemployee = DB::table('employeepayrolls')
        ->select('month', 'year', DB::raw('SUM(total_amount_to_paid) as total_amounts'))
        ->where(function ($query) use ($endYear, $startYear) {
          // Jan to Mar from next year
          $query->where(function ($q) use ($endYear) {
            $q->where('year', $endYear);
            // ->whereIn('month', ['January', 'February', 'March']);
          })
            // Apr to Jun from current year
            ->orWhere(function ($q) use ($startYear) {
              $q->where('year', $startYear);
              // ->whereIn('month', ['April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']);
            });
        })
        ->where('send_to_bank', 1)
        ->when(!empty($months), function ($query) use ($months) {
          $query->where('month', $months);
        })
        ->groupBy('year', 'month')
        ->orderByRaw("FIELD(month, 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December', 'January', 'February', 'March')")
        ->get();

      $mergedSpenddata = $cashFlowSpendvender->merge($cashFlowSpendemployee);

      $cashFlowtotalspendData = $mergedSpenddata->groupBy(function ($item) {
        return $item->month . '-' . $item->year;
      })->map(function ($group) {
        return (object) [
          'month' => $group->first()->month,
          'year' => $group->first()->year,
          'total_amounts' => $group->sum('total_amounts'),
        ];
      })->sortBy(function ($item) {
        $order = ['April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December', 'January', 'February', 'March'];
        return array_search($item->month, $order);
      })->values();

      //ffbb Budget vs Actual Cash Flow

      // 1.budget table se budgetinflow
      // 2.cash recieved in paymnets table 
      // 2.budget table se budgetoutflow
      // 4.cash spend on employee and vender employeepayrolls and vendorlist tables 

      $budgetactualcash = DB::table('budget')
        ->select('month', 'year', DB::raw('SUM(budgetinflow) as budgetinflow'), DB::raw('SUM(budgetoutflow) as budgetoutflow'))
        ->where(function ($query) use ($endYear, $startYear) {
          // Jan to Mar from next year
          $query->where(function ($q) use ($endYear) {
            $q->where('year', $endYear);
            // ->whereIn('month', ['January', 'February', 'March']);
          })
            // Apr to Jun from current year
            ->orWhere(function ($q) use ($startYear) {
              $q->where('year', $startYear);
              // ->whereIn('month', ['April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']);
            });
        })
        ->when(!empty($months), function ($query) use ($months) {
          $query->where('month', $months);
        })
        ->groupBy('year', 'month')
        ->orderByRaw("FIELD(month, 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December', 'January', 'February', 'March')")
        ->get();

      //  Budget vs Actual Cash Flow end hare 


      //ffbb Budget vs Actual P&L
      $budgetRevenueandbudgetExpences = DB::table('assignmentmappings')
        ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, SUM(engagementfee) as engagementfee, SUM(teamestcost) as total_teamestcost')
        ->whereBetween('created_at', [$startDateFormatted, $endDateFormatted])
        ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
          $query->whereMonth('created_at', $monthsdigit);
        })
        ->groupByRaw('MONTH(created_at), YEAR(created_at)')
        ->orderByRaw('FIELD(MONTH(created_at), 4,5,6,7,8,9,10,11,12,1,2,3)')
        ->get()
        ->map(function ($item) use ($monthNames) {
          $item->month = $monthNames[$item->month] ?? $item->month;
          return $item;
        });

      $budgetActualRevenuedata = DB::table('invoices')
        ->selectRaw("MONTH(created_at) as month, YEAR(created_at) as year, invoices.currency, DATE_FORMAT(invoices.created_at, '%Y-%m-%d') as bill_date, SUM(total) as total_amount")
        ->whereBetween('created_at', [$startDateFormatted, $endDateFormatted])
        ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
          $query->whereMonth('created_at', $monthsdigit);
        })
        ->groupByRaw("MONTH(created_at), YEAR(created_at), invoices.currency, DATE_FORMAT(invoices.created_at, '%Y-%m-%d')")
        ->orderByRaw('FIELD(MONTH(created_at), 4,5,6,7,8,9,10,11,12,1,2,3)')
        ->get()
        ->map(function ($item) use ($monthNames) {
          $item->month = $monthNames[$item->month] ?? $item->month;
          return $item;
        });

      $budgetActualRevenuedata = $this->convertusdtoinr1($budgetActualRevenuedata);

      $budgetActualRevenue = $budgetActualRevenuedata
        ->groupBy('month')
        ->map(function ($items, $month) {
          return (object)[
            'month' => $month,
            'year' => $items->first()->year,
            'total_amount' => $items->sum('total_amount'),
          ];
        })
        ->values();

      $budgetActualExpences = DB::table('timesheets')
        ->leftJoin('timesheetusers', 'timesheetusers.timesheetid', '=', 'timesheets.id')
        ->leftJoin('teammembers', 'teammembers.id', '=', 'timesheetusers.createdby')
        // ->whereIn('timesheets.created_by', [815, 818])
        ->selectRaw('MONTH(timesheets.date) as month, YEAR(timesheets.date) as year, SUM(timesheetusers.totalhour * teammembers.cost_hour) as total_cost')
        ->whereBetween('timesheets.date', [$startDateFormatted, $endDateFormatted])
        ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
          $query->whereMonth('timesheets.date', $monthsdigit);
        })
        ->groupByRaw('MONTH(timesheets.date), YEAR(timesheets.date)')
        ->get()
        ->map(function ($item) use ($monthNames) {
          $item->month = $monthNames[$item->month] ?? $item->month;
          return $item;
        });

      // Budget vs Actual P&L end hare 


      //ffbb Lap Days Analysis (Assignment to Invoice)
      $assignmentsWithInvoices = DB::table('assignmentmappings')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        // get only those assignments for which an invoice has been created
        ->join('invoices', 'invoices.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->selectRaw('MONTH(assignmentbudgetings.otpverifydate) as month, YEAR(assignmentbudgetings.otpverifydate) as year, assignmentbudgetings.otpverifydate, invoices.created_at as invoice_created_at, invoices.id as invoice_id')
        ->whereBetween('assignmentbudgetings.otpverifydate', [$startDateFormatted, $endDateFormatted])
        ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
          $query->whereMonth('assignmentbudgetings.otpverifydate', $monthsdigit);
        })
        ->orderByRaw('FIELD(MONTH(assignmentbudgetings.otpverifydate), 1,2,3,4,5,6,7,8,9,10,11,12)')
        ->get()
        ->map(function ($item) use ($monthNames) {
          $assignmentclosedDate = Carbon::parse($item->otpverifydate);
          $invoicecreatedDate = Carbon::parse($item->invoice_created_at);
          $item->differenceDays = $assignmentclosedDate->diffInDays($invoicecreatedDate);
          $item->targetDays = 7;
          $item->month = $monthNames[$item->month] ?? $item->month;
          return $item;
        })
        ->groupBy(fn($item) => $item->month . '-' . $item->year)
        ->map(function ($group) {
          $first = $group->first();
          return (object) [
            'month' => $first->month,
            'year' => $first->year,
            'otpverifydate' => $first->otpverifydate,
            'invoice_id' => $first->invoice_id,
            'invoice_created_at' => $first->invoice_created_at,
            'targetDays' => $first->targetDays,
            'differenceDays' => $group->sum('differenceDays'),
            'countitem' => $group->count(),
            // Average Difference Days = (sum of all differenceDays) / number of records
            'averageDifferenceDays' => round($group->avg('differenceDays'), 1),
          ];
        })
        ->sortBy(fn($item) => array_search($item->month, array_values($monthNames)))
        ->values();

      //ffbb Invoice Due vs Assignment Billing vs Cash Recovery
      $assignmentBillingdata = DB::table('invoices')
        ->selectRaw("MONTH(created_at) as month, YEAR(created_at) as year, invoices.currency, DATE_FORMAT(invoices.created_at, '%Y-%m-%d') as bill_date, SUM(total) as total_amount")
        ->whereBetween('created_at', [$startDateFormatted, $endDateFormatted])
        ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
          $query->whereMonth('created_at', $monthsdigit);
        })
        ->groupByRaw("MONTH(created_at), YEAR(created_at), invoices.currency, DATE_FORMAT(invoices.created_at, '%Y-%m-%d')")
        ->orderByRaw('FIELD(MONTH(created_at),  4,5,6,7,8,9,10,11,12,1,2,3)')
        ->get()
        ->map(function ($item) use ($monthNames) {
          $item->month = $monthNames[$item->month] ?? $item->month;
          return $item;
        });

      $assignmentBillingdata = $this->convertusdtoinr1($assignmentBillingdata);

      $assignmentBilling = $assignmentBillingdata
        ->groupBy('month')
        ->map(function ($items, $month) {
          return (object)[
            'month' => $month,
            'year' => $items->first()->year,
            'total_amount' => $items->sum('total_amount'),
          ];
        })
        ->values();

      $assignmentOutstanding = DB::table('outstandings')
        ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, SUM(AMT) as outstanding_amount')
        ->whereBetween('created_at', [$startDateFormatted, $endDateFormatted])
        ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
          $query->whereMonth('created_at', $monthsdigit);
        })
        ->groupByRaw('MONTH(created_at), YEAR(created_at)')
        ->orderByRaw('FIELD(MONTH(created_at),  4,5,6,7,8,9,10,11,12,1,2,3)')
        ->get()
        ->map(function ($item) use ($monthNames) {
          $item->month = $monthNames[$item->month] ?? $item->month;
          return $item;
        });

      $cashRecovery = DB::table('payments')
        ->selectRaw('MONTH(paymentdate) as month, YEAR(paymentdate) as year, SUM(amountreceived) as amountreceived')
        ->whereBetween('paymentdate', [$startDateFormatted, $endDateFormatted])
        ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
          $query->whereMonth('paymentdate', $monthsdigit);
        })
        ->groupByRaw('MONTH(paymentdate), YEAR(paymentdate)')
        ->orderByRaw('FIELD(MONTH(paymentdate), 4,5,6,7,8,9,10,11,12,1,2,3)')
        ->get()
        ->map(function ($item) use ($monthNames) {
          $item->month = $monthNames[$item->month] ?? $item->month;
          return $item;
        });

      //ffbb  Staff Allocation vs Actual Timesheet Analysis
      $teamAllocatedHours = DB::table('timesheetusers')
        ->join('teammembers', 'teammembers.id', '=', 'timesheetusers.createdby')
        // ->whereIn('teammembers.id', [14, 23, 187, 305, 659, 815])
        // ->whereNotIn('teammembers.role_id', [13])
        ->whereBetween('timesheetusers.created_at', [$startDateFormatted, $endDateFormatted])
        ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
          $query->whereMonth('timesheetusers.created_at', $monthsdigit);
        })
        ->select(
          'teammembers.id as teammember_id',
          'teammembers.team_member',
          'teammembers.role_id',
          DB::raw('SUM(timesheetusers.totalhour) as actualhours')
        )
        ->groupBy('teammembers.id', 'teammembers.team_member', 'teammembers.role_id')
        // ->limit(6)
        ->get();


      foreach ($teamAllocatedHours as $teamAllocatedHour) {
        if ($teamAllocatedHour->role_id == 13) {
          $allocatedHours1 = DB::table('assignmentmappings')
            ->where('assignmentmappings.eqcrpartner', $teamAllocatedHour->teammember_id)
            ->whereBetween('assignmentmappings.created_at', [$startDateFormatted, $endDateFormatted])
            ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
              $query->whereMonth('assignmentmappings.created_at', $monthsdigit);
            })
            ->sum('assignmentmappings.eqcresthour');

          $allocatedHours2 = DB::table('assignmentmappings')
            ->where('assignmentmappings.leadpartner', $teamAllocatedHour->teammember_id)
            ->whereBetween('assignmentmappings.created_at', [$startDateFormatted, $endDateFormatted])
            ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
              $query->whereMonth('assignmentmappings.created_at', $monthsdigit);
            })
            ->sum('assignmentmappings.partneresthour');

          $allocatedHours3 = DB::table('assignmentmappings')
            ->where('assignmentmappings.otherpartner', $teamAllocatedHour->teammember_id)
            ->whereBetween('assignmentmappings.created_at', [$startDateFormatted, $endDateFormatted])
            ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
              $query->whereMonth('assignmentmappings.created_at', $monthsdigit);
            })
            ->sum('assignmentmappings.otherpartneresthour');

          $allocatedHours = $allocatedHours1 + $allocatedHours2 + $allocatedHours3;
        } else {
          $allocatedHours = DB::table('assignmentteammappings')
            ->where('assignmentteammappings.teammember_id', $teamAllocatedHour->teammember_id)
            ->whereBetween('assignmentmappings.created_at', [$startDateFormatted, $endDateFormatted])
            ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
              $query->whereMonth('assignmentmappings.created_at', $monthsdigit);
            })
            ->sum('assignmentteammappings.teamesthour');
        }

        if (is_null($allocatedHours)) {
          $allocatedHours = 0;
        }
        $teamAllocatedHour->teamallocatedhours = $allocatedHours;
        $teamAllocatedHour->discrepancy = $teamAllocatedHour->actualhours - (float) $allocatedHours;
      }


      //ffbb Fetch IT and Finance Tickets or Unresolved Tickets - HR, IT & Admin
      $ticketDatas = Assetticket::with(['financerequest', 'createdBy', 'partner'])
        ->whereIn('type', [0, 1])
        ->whereBetween('created_at', [$startDateFormatted, $endDateFormatted])
        ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
          $query->whereMonth('created_at', $monthsdigit);
        })
        ->orderByDesc('id')
        // ->limit(4)
        ->get()
        ->map(function ($item) {
          return [
            'ticket_id' => $item->generateticket_id,
            'department' => $item->type == 0 ? 'IT' : 'Finance',
            'created_by' => $item->createdBy->team_member ?? '',
            'subject' => $item->subject,
            'assigned_to' => $item->partner->team_member ?? '',
            'created_at' => $item->created_at,
            'status' => $item->status,
            'source' => 'ticket',
          ];
        });


      // Fetch HR Tasks
      $hrTickets = DB::table('tasks')
        ->select(
          'tasks.*',
          'patnerid.team_member as partnername',
          'createdby.team_member as createdbyname',
          'hrfunctions.hrfunction'
        )
        ->where('tasks.task_type', 4)
        ->whereBetween('tasks.created_at', [$startDateFormatted, $endDateFormatted])
        ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
          $query->whereMonth('tasks.created_at', $monthsdigit);
        })
        ->leftJoin('teammembers as patnerid', 'patnerid.id', '=', 'tasks.partner_id')
        ->leftJoin('teammembers as createdby', 'createdby.id', '=', 'tasks.createdby')
        ->leftJoin('hrfunctions', 'hrfunctions.id', '=', 'tasks.hrfunction')
        ->orderByDesc('tasks.id')
        // ->limit(4)
        ->get()
        ->map(function ($item) {
          return [
            'ticket_id' => 'N/A',
            'department' => 'HR',
            'created_by' => $item->createdbyname ?? '',
            'subject' => $item->taskname ?? '',
            'assigned_to' => $item->partnername ?? '',
            'created_at' => $item->created_at,
            'status' => $item->status,
            'source' => 'hr',
          ];
        });

      $allTickets = $ticketDatas->merge($hrTickets);

      // High Priority Tasks Pending
      $highpriorityAssignments  = DB::table('assignmentmappings')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftJoin('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
        ->select(
          'assignmentmappings.*',
          'assignmentbudgetings.assignmentname',
          DB::raw('COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate) as finalassignmentenddate'),
          'clients.client_name'
        )
        ->limit(6)
        ->get();

      // filter data 
      $startYearforfilter = 2022;
      $currentDatetoday = Carbon::now();
      $currentYearforfilter = $currentDatetoday->year;
      $currentMonthforfilter = $currentDatetoday->month;
      $currentFinancialYear = $currentMonthforfilter >= 4 ? $currentYearforfilter : $currentYearforfilter - 1;

      $financialYears = [];
      for ($year = $startYearforfilter; $year <= $currentFinancialYear; $year++) {
        $financialYears[] = [
          'value' => $year . '-' . ($year + 1),
        ];
      }

      $request->flash();

      // filter data end hare 
      return view('backEnd.kgsdashboardreport', compact('budgetactualcash', 'financialYears', 'workFromHome', 'budgetRevenueandbudgetExpences', 'budgetActualRevenue', 'budgetActualExpences', 'assignmentsWithInvoices', 'assignmentBilling', 'assignmentOutstanding', 'cashRecovery', 'cashFlowtotalspendData', 'cashFlowRecieved', 'teamexceptionalExpenses', 'teamsSalaries', 'teamAllocatedHours', 'timesheetOnClosedAssignment', 'totalNotFilled', 'partnerWiseProfit', 'lossMakingCount', 'billspending15Days', 'totalUpcomingAssignments', 'assignmentprofitandlosses', 'allTickets', 'hrTickets', 'ticketDatas', 'highpriorityAssignments', 'ecqrAudits', 'documentCompletions', 'assignmentOverviews',  'exceptionalExpenses', 'auditsDue', 'tendersSubmittedCount', 'delayedAssignments', 'assignmentcompleted', 'billspendingforcollection', 'billspending'));
    }
  }
           // Budget vs Actual P&L
      $budgetRevenueandbudgetExpences = DB::table('assignmentmappings')
        ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, SUM(engagementfee) as engagementfee, SUM(teamestcost) as total_teamestcost')
        ->whereBetween('created_at', [
          $financialStartDate,
          $financialEndDate
        ])
        ->groupByRaw('MONTH(created_at), YEAR(created_at)')
        ->orderByRaw('FIELD(MONTH(created_at), 4,5,6,7,8,9,10,11,12,1,2,3)')
        ->get()
        ->map(function ($item) use ($monthNames) {
          $item->month = $monthNames[$item->month] ?? $item->month;
          return $item;
        });

      // $budgetActualRevenue = DB::table('invoices')
      //   ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, SUM(total) as invoices_amount')
      //   ->whereBetween('created_at', [
      //     $financialStartDate,
      //     $financialEndDate
      //   ])
      //   ->groupByRaw('MONTH(created_at), YEAR(created_at)')
      //   ->orderByRaw('FIELD(MONTH(created_at), 4,5,6,7,8,9,10,11,12,1,2,3)')
      //   ->get()
      //   ->map(function ($item) use ($monthNames) {
      //     $item->month = $monthNames[$item->month] ?? $item->month;
      //     return $item;
      //   });

      $budgetActualRevenuedata = DB::table('invoices')
        ->selectRaw("MONTH(created_at) as month, YEAR(created_at) as year, invoices.currency, DATE_FORMAT(invoices.created_at, '%Y-%m-%d') as bill_date, SUM(total) as total_amount")
        ->whereBetween('created_at', [
          $financialStartDate,
          $financialEndDate
        ])
        ->groupByRaw("MONTH(created_at), YEAR(created_at), invoices.currency, DATE_FORMAT(invoices.created_at, '%Y-%m-%d')")
        ->orderByRaw('FIELD(MONTH(created_at), 4,5,6,7,8,9,10,11,12,1,2,3)')
        ->get()
        ->map(function ($item) use ($monthNames) {
          $item->month = $monthNames[$item->month] ?? $item->month;
          return $item;
        });

      $budgetActualRevenuedata = $this->convertusdtoinr1($budgetActualRevenuedata);

      $budgetActualRevenue = $budgetActualRevenuedata
        ->groupBy('month')
        ->map(function ($items, $month) {
          return (object)[
            'month' => $month,
            'year' => $items->first()->year,
            'total_amount' => $items->sum('total_amount'),
          ];
        })
        ->values();

      $budgetActualExpences = DB::table('timesheets')
        ->leftJoin('timesheetusers', 'timesheetusers.timesheetid', '=', 'timesheets.id')
        ->leftJoin('teammembers', 'teammembers.id', '=', 'timesheetusers.createdby')
        // ->whereIn('timesheets.created_by', [815, 818])
        ->selectRaw('MONTH(timesheets.date) as month, YEAR(timesheets.date) as year, SUM(timesheetusers.totalhour * teammembers.cost_hour) as total_cost')
        ->whereBetween('timesheets.date', [
          $financialStartDate->format('Y-m-d'),
          $financialEndDate->format('Y-m-d')
        ])
        ->groupByRaw('MONTH(timesheets.date), YEAR(timesheets.date)')
        ->get()
        ->map(function ($item) use ($monthNames) {
          $item->month = $monthNames[$item->month] ?? $item->month;
          return $item;
        });

      // Budget vs Actual P&L end hare 
        // Start Hare
          Route::match(['get', 'post'], 'assignmentlist', [AssignmentController::class, 'assignmentlist'])
    ->name('assignment.list');

        public function assignmentlist(Request $request)
    {
        $staff = Teammember::whereIn('role_id', ['13', '14', '15'])
            ->where('status', 1)
            ->with('role')
            ->get();

        $client = AssignmentMapping::getClientNames();

        if ($request->ajax()) {
            $query = Assignmentmapping::with([
                'assignmentBudgeting.client:id,client_name',
                'assignmentBudgeting.assignment:id,assignment_name',
                'leadPartner:id,team_member',
                'otherPartner:id,team_member',
                'reviewerPartner:id,team_member',
                'assignmentTeamMappings.teamMember:id,team_member',
            ]);

            $query->withSum(['timsheetusers as total_hours' => function ($q) {
                $q->whereHas('createdBy', function ($sub) {
                    $sub->where('role_id', 14);
                });
            }], 'hour');

            // 🔹 Apply filters
            if ($request->filled('clientId')) {
                $query->whereHas('assignmentBudgeting', function ($q) use ($request) {
                    $q->where('client_id', $request->clientId);
                });
            }

            if ($request->filled('assignment')) {
                $query->whereHas('assignmentBudgeting', function ($q) use ($request) {
                    $q->where('assignmentgenerate_id', $request->assignment);
                });
            }

            if ($request->filled('teammemberId')) {
                $query->whereHas('assignmentTeamMappings', function ($q) use ($request) {
                    $q->where('teammember_id', $request->teammemberId)
                        ->orWhere('assignmentmappings.leadpartner', $request->teammemberId)
                        ->orWhere('assignmentmappings.otherpartner', $request->teammemberId)
                        ->orWhere('assignmentmappings.eqcrpartner', $request->teammemberId);
                });
            }

            // Apply date filters
            if ($request->filled('startdate')) {
                $query->whereDate('assignmentmappings.created_at', '>=', $request->startdate);
            }
            if ($request->filled('enddate')) {
                $query->whereDate('assignmentmappings.created_at', '<=', $request->enddate);
            }

            return DataTables::of($query)
                ->addColumn('client_name', function ($row) {
                    return optional($row->assignmentBudgeting->client)->client_name ?? 'N/A';
                })
                ->addColumn('assignment_name', function ($row) {
                    return optional($row->assignmentBudgeting->assignment)->assignment_name ?? 'N/A';
                })
                ->addColumn('assignmentname', function ($row) {
                    return optional($row->assignmentBudgeting)->assignmentname ?? 'N/A';
                })
                ->addColumn('lead_partner', function ($row) {
                    return optional($row->leadPartner)->team_member ?? 'N/A';
                })
                ->addColumn('other_partner', function ($row) {
                    return optional($row->otherPartner)->team_member ?? 'N/A';
                })
                ->addColumn('reviewer_partner', function ($row) {
                    return optional($row->reviewerPartner)->team_member ?? 'N/A';
                })
                ->addColumn('assignment_team_mappings', function ($row) {
                    return $row->assignmentTeamMappings->map(function ($mapping) {
                        return [
                            'team_member' => optional($mapping->teamMember)->team_member,
                            'title' => optional($mapping->teamMember)->title,
                            'type' => $mapping->type,
                        ];
                    })->toArray();
                })

                // 🔹 Search handling for columns
                ->filterColumn('client_name', function ($query, $keyword) {
                    $keyword = strtolower(trim($keyword));
                    $query->whereHas('assignmentBudgeting.client', function ($q) use ($keyword) {
                        $q->whereRaw('LOWER(client_name) LIKE ?', ["%{$keyword}%"]);
                    });
                })
                ->filterColumn('assignment_name', function ($query, $keyword) {
                    $keyword = strtolower(trim($keyword));
                    $query->whereHas('assignmentBudgeting.assignment', function ($q) use ($keyword) {
                        $q->whereRaw('LOWER(assignment_name) LIKE ?', ["%{$keyword}%"]);
                    });
                })
                ->filterColumn('assignmentname', function ($query, $keyword) {
                    $keyword = strtolower(trim($keyword));
                    $query->whereHas('assignmentBudgeting', function ($q) use ($keyword) {
                        $q->whereRaw('LOWER(assignmentname) LIKE ?', ["%{$keyword}%"]);
                    });
                })
                ->filterColumn('lead_partner', function ($query, $keyword) {
                    $keyword = strtolower(trim($keyword));
                    $query->whereHas('leadPartner', function ($q) use ($keyword) {
                        $q->whereRaw('LOWER(team_member) LIKE ?', ["%{$keyword}%"]);
                    });
                })
                ->filterColumn('other_partner', function ($query, $keyword) {
                    $keyword = strtolower(trim($keyword));
                    $query->whereHas('otherPartner', function ($q) use ($keyword) {
                        $q->whereRaw('LOWER(team_member) LIKE ?', ["%{$keyword}%"]);
                    });
                })
                ->filterColumn('assignment_team_mappings', function ($query, $keyword) {
                    $keyword = strtolower(trim($keyword));
                    $query->whereHas('assignmentTeamMappings.teamMember', function ($q) use ($keyword) {
                        $q->whereRaw('LOWER(team_member) LIKE ?', ["%{$keyword}%"]);
                    });
                })

                ->make(true);
        }

        return view('backEnd.assignment.assignmentlist', compact('client', 'staff'));
    }

              $billspending = DB::table('assignmentmappings')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftJoin('invoices', 'invoices.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->whereNull('invoices.assignmentgenerate_id')
        ->where('assignmentbudgetings.status', 0)
        ->sum('assignmentmappings.engagementfee');

    $assignmentBillingdata = DB::table('invoices')
        // ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, SUM(total) as total_amount')
        ->selectRaw("MONTH(created_at) as month, YEAR(created_at) as year, invoices.currency, DATE_FORMAT(invoices.created_at, '%Y-%m-%d') as bill_date, SUM(total) as total_amount")
        ->whereBetween('created_at', [
          $financialStartDate,
          $financialEndDate
        ])
        // ->groupByRaw('MONTH(created_at), YEAR(created_at)')
        ->groupByRaw("MONTH(created_at), YEAR(created_at), invoices.currency, DATE_FORMAT(invoices.created_at, '%Y-%m-%d')")
        ->orderByRaw('FIELD(MONTH(created_at),  4,5,6,7,8,9,10,11,12,1,2,3)')
        ->get()
        ->map(function ($item) use ($monthNames) {
          $item->month = $monthNames[$item->month] ?? $item->month;
          return $item;
        });

      // $assignmentBillingdata = $this->convertusdtoinr1($assignmentBillingdata);

      $assignmentBilling = $assignmentBillingdata
        ->groupBy('month')
        ->map(function ($items, $month) {
          return (object)[
            'month' => $month,
            'year' => $items->first()->year,
            'total_amount' => $items->sum('total_amount'),
          ];
        })
        ->values();

   $billspending15Daysdata = DB::table('assignmentmappings')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->leftJoin('invoices', 'invoices.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->leftJoin('payments', 'payments.invoiceid', '=', 'invoices.invoice_id')
        ->where('assignmentbudgetings.status', 0)
        // ->where('invoices.invoicescategory', 2)
        ->whereNotNull('invoices.id') // Invoice is created
        ->whereNull('payments.invoiceid')  // Payment not yet received
        // Only within last 15 days
        ->whereBetween('invoices.created_at', [
          Carbon::today()->subDays(15)->startOfDay(),
          Carbon::today()->endOfDay()
        ])
        ->select(
          'invoices.currency',
          DB::raw("DATE_FORMAT(invoices.created_at, '%Y-%m-%d') as bill_date"),
          DB::raw('SUM(invoices.total) as total_amount')
        )
        ->groupBy('invoices.currency', 'bill_date')
        ->get();

      $billspending15Days = $this->convertusdtoinr($billspending15Daysdata);


  Illuminate\Support\Collection {#3693 ▼
  #items: array:4 [▼
    0 => {#4285 ▼
      +"assignmentgenerate_id": "209117424956"
      +"team_member": "Kunal Jain"
      +"total": "47000"
    }
    1 => {#4264 ▼
      +"assignmentgenerate_id": "663784755601"
      +"team_member": "Kunal Jain"
      +"total": "236380"
    }
    2 => {#4275 ▼
      +"assignmentgenerate_id": "784538708139"
      +"team_member": "Saurabh Jain"
      +"total": "5070003"
    }
    3 => {#4279 ▼
      +"assignmentgenerate_id": "929311105327"
      +"team_member": "Kunal Jain"
      +"total": "202450"
    }
  ]
  #escapeWhenCastingToString: false
}

   $budgetActualRevenue = DB::table('invoices')
        ->selectRaw("MONTH(created_at) as month, YEAR(created_at) as year, invoices.currency, DATE_FORMAT(invoices.created_at, '%Y-%m-%d') as bill_date, SUM(total) as total_amount")
        ->whereBetween('created_at', [
          $financialStartDate,
          $financialEndDate
        ])
        ->groupByRaw("MONTH(created_at), YEAR(created_at), invoices.currency, DATE_FORMAT(invoices.created_at, '%Y-%m-%d')")
        ->orderByRaw('FIELD(MONTH(created_at), 4,5,6,7,8,9,10,11,12,1,2,3)')
        ->get()
        ->map(function ($item) use ($monthNames) {
          $item->month = $monthNames[$item->month] ?? $item->month;
          return $item;
        });

      $budgetActualRevenue = $this->convertusdtoinr($budgetActualRevenue);

      $groupedRevenue = $budgetActualRevenue
        ->groupBy('month')
        ->map(function ($items, $month) {
          return (object)[
            'month' => $month,
            'year' => $items->first()->year,
            'total_amount' => $items->sum('total_amount'),
          ];
        })
        ->values();

      dd($groupedRevenue);

        public function convertusdtoinr($usdAmountconvert)
  {
    return $usdAmountconvert->map(function ($bill) {
      if ($bill->currency == 3 || is_null($bill->currency)) {
        // INR (ya null) to same rakho
        $bill->total_amount = round($bill->total_amount, 2);
      } elseif ($bill->currency == 1) {
        // USD to INR convert karo
        $response = Http::get("https://api.frankfurter.app/{$bill->bill_date}", [
          'from' => 'USD',
          'to' => 'INR'
        ]);

        $rate = $response->successful()
          ? ($response->json()['rates']['INR'] ?? 0)
          : 0;

        $bill->total_amount = round($bill->total_amount * $rate, 2);
      }

      // row ko modify karke return karo
      return $bill;
    });
  }
 $billspending15Daysdata = DB::table('assignmentmappings')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->leftJoin('invoices', 'invoices.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->leftJoin('payments', 'payments.invoiceid', '=', 'invoices.invoice_id')
        ->where('assignmentbudgetings.status', 0)
        // ->where('invoices.invoicescategory', 2)
        ->whereNotNull('invoices.id') // Invoice is created
        ->whereNull('payments.invoiceid')  // Payment not yet received
        // Only within last 15 days
        ->whereBetween('invoices.created_at', [
          Carbon::today()->subDays(15)->startOfDay(),
          Carbon::today()->endOfDay()
        ])
        ->select(
          'invoices.currency',
          DB::raw("DATE_FORMAT(invoices.created_at, '%Y-%m-%d') as bill_date"),
          DB::raw('SUM(invoices.total) as total_amount')
        )
        ->groupBy('invoices.currency', 'bill_date')
        ->get();

lluminate\Support\Collection {#4467 ▼
  #items: array:1 [▼
    0 => {#4365 ▼
      +"month": "August"
      +"year": 2025
      +"invoices_amount": "1302830"
    }
  ]
  #escapeWhenCastingToString: false

// Staff Allocation vs Actual Timesheet Analysis 
  $teamAllocatedHours = DB::table('timesheetusers')
    ->join('teammembers', 'teammembers.id', '=', 'timesheetusers.createdby')
    ->whereBetween('timesheetusers.created_at', [
        $financialStartDate,
        $financialEndDate
    ])
    ->select(
        'teammembers.id as teammember_id',
        'teammembers.team_member',
        DB::raw('SUM(timesheetusers.totalhour) as actualhours')
    )
    ->groupBy('teammembers.id', 'teammembers.team_member')
    ->get();

// Add allocated hours + discrepancy
foreach ($teamAllocatedHours as $teamAllocatedHour) {
    $allocatedHours = DB::table('assignmentteammappings')
        ->where('assignmentteammappings.teammember_id', $teamAllocatedHour->teammember_id)
        ->whereBetween('assignmentteammappings.created_at', [
            $financialStartDate,
            $financialEndDate
        ])
        ->sum('assignmentteammappings.teamesthour');

    $allocatedHours = $allocatedHours ?? 0;

    $teamAllocatedHour->teamallocatedhours = $allocatedHours;
    $teamAllocatedHour->discrepancy = $teamAllocatedHour->actualhours - (float) $allocatedHours;
}

// Ensure at least 6 data points
if ($teamAllocatedHours->count() < 6) {
    $needed = 6 - $teamAllocatedHours->count();
    for ($i = 1; $i <= $needed; $i++) {
        $teamAllocatedHours->push((object)[
            'teammember_id' => null,
            'team_member' => "N/A $i",
            'actualhours' => 0,
            'teamallocatedhours' => 0,
            'discrepancy' => 0,
        ]);
    }
}



// const teamAllocatedHours = @json($teamAllocatedHours);

// const allocatedHours = teamAllocatedHours.map(item => parseInt(item.teamallocatedhours));
// const actualHours = teamAllocatedHours.map(item => item.actualhours);
// const discrepancy = teamAllocatedHours.map(item => item.discrepancy);
// const teamMembers = teamAllocatedHours.map(item => item.team_member);

// const chartWidth = teamMembers.length * 140;
// document.getElementById('expenseChart2').width = chartWidth;


// end hare 


      function sendNotificationbulkupload($selectedTeams)
    {
        foreach ($selectedTeams as $teamid) {
            // user notifications start hare 
            $teammember  = DB::table('teammembers')
                ->where('id', $teamid)
                ->where('status', 1)
                ->first();

            if ($teammember && !empty($teammember->emailid)) {
                $mailData = [
                    'teammembers' => $teammember,
                    'created_at' => now()->format('d-m-Y H:i:s'),
                ];
                Mail::send('emails.krasupdateteamnotification', $mailData, function ($msg) use ($teammember) {
                    $msg->to($teammember->emailid)->subject('Notification: Your KRAs Have Been Updloded');
                });
            }
            // user notifications end  hare 

            // reporting manager notification start hare 
            if ($teammember && $teammember->reportinghead) {
                $reportinghead = DB::table('teammembers')
                    ->where('id', $teammember->reportinghead)
                    ->where('status', 1)
                    ->first();

                if ($reportinghead && !empty($reportinghead->emailid)) {
                    $mailData = [
                        'teammembers'    => $teammember,
                        'reportinghead'  => $reportinghead,
                        'created_at'     => now()->format('d-m-Y H:i:s'),
                    ];

                    Mail::send('emails.krapartnernotification', $mailData, function ($msg) use ($reportinghead) {
                        $msg->to($reportinghead->emailid)->subject('Notification: Your KRAs Have Been Updloded');
                    });
                }
            }
            //reporting manager notification end hare

            // // partner or target teammember notifications start hare 
            // $partnerIds = DB::table('krasnotifications')
            //     ->where('designation_id', $teammember->designation)
            //     ->whereNotNull('typetarget')
            //     ->pluck('typetarget');

            // $individualNotificationIds = DB::table('krasnotifications')
            //     ->where('designation_id', $teammember->designation)
            //     ->whereNull('typetarget')
            //     ->pluck('id');

            // $individualIds = [];

            // if ($individualNotificationIds->isNotEmpty()) {
            //     $individualIds = DB::table('krastargetnotification')
            //         ->whereIn('krasnotifications_id', $individualNotificationIds)
            //         ->pluck('teammember_id');
            // }

            // $partners = collect();
            // if ($partnerIds->isNotEmpty() || !empty($individualIds)) {
            //     $partners = DB::table('teammembers')
            //         ->where(function ($query) use ($partnerIds, $individualIds) {
            //             if ($partnerIds->isNotEmpty()) {
            //                 $query->orWhereIn('designation', $partnerIds);
            //             }
            //             if (!empty($individualIds)) {
            //                 $query->orWhereIn('id', $individualIds);
            //             }
            //         })
            //         ->where('status', 1)
            //         ->get();
            // }
            // foreach ($partners as $partner) {
            //     if (!empty($partner->emailid)) {
            //         $partnerMailData = [
            //             'partner' => $partner,
            //             'created_at' => now()->format('d-m-Y H:i:s'),
            //         ];

            //         Mail::send('emails.krapartnernotification', $partnerMailData, function ($msg) use ($partner) {
            //             $msg->to($partner->emailid)->subject('KRAs Updated');
            //         });
            //     }
            // }
            // // partner or target teammember notifications end hare 
        }
    }

     dd($ecqrAudits);
        ->whereBetween('created_at', [$financialStartDate, $financialEndDate])

        $teamAllocatedHours = DB::table('timesheetusers')
        ->join('teammembers', 'teammembers.id', '=', 'timesheetusers.createdby')
        // ->whereIn('teammembers.id', [14, 23, 187, 305, 659, 815])
        ->whereBetween('assignmentmappings.created_at', [$financialStartDate, $financialEndDate])
        ->select(
          'teammembers.id as teammember_id',
          'teammembers.team_member',
          DB::raw('SUM(timesheetusers.totalhour) as actualhours')
        )
        ->groupBy('teammembers.id', 'teammembers.team_member')
        // ->limit(6)
        ->get();

    $cashFlowSpendemployee = DB::table('employeepayrolls')
        ->select('month', 'year', DB::raw('SUM(total_amount_to_paid) as total_amounts'))
        ->where(function ($query) use ($financialEndYear, $financialStartYear) {
          $query->where(function ($q) use ($financialEndYear) {
            $q->where('year', $financialEndYear)
              ->whereIn('month', ['January', 'February', 'March']);
          })->orWhere(function ($q) use ($financialStartYear) {
            $q->where('year', $financialStartYear)
              ->whereIn('month', ['April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']);
          });
        })
        ->where('send_to_bank', 1)
        ->groupBy('year', 'month')
        ->orderByRaw("FIELD(month, 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December', 'January', 'February', 'March')")
        ->get();

           $cashFlowSpendvender = DB::table('vendorlist')
        ->selectRaw('MONTH(approvedate) as month, YEAR(approvedate) as year, SUM(amount) as total_amounts')
        ->where('status', 4)
        ->whereBetween('approvedate', [
          $financialStartDate->format('Y-m-d'),
          $financialEndDate->format('Y-m-d')
        ])
        ->groupByRaw('MONTH(approvedate), YEAR(approvedate)')
        ->orderByRaw('FIELD(MONTH(approvedate), 4,5,6,7,8,9,10,11,12,1,2,3)')
        ->get()
        ->map(function ($item) use ($monthNames) {
          $item->month = $monthNames[$item->month] ?? $item->month;
          return $item;
        });

  const lapDaysChartmonths = [
    'April', 'May', 'June', 'July', 'August', 'September',
    'October', 'November', 'December', 'January', 'February', 'March'
];

const lapDaysMonths = ['Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan', 'Feb', 'Mar'];


    $assignmentsWithInvoices = DB::table('assignmentmappings')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        // get only those assignments for which an invoice has been created
        ->join('invoices', 'invoices.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->selectRaw('MONTH(assignmentbudgetings.otpverifydate) as month, YEAR(assignmentbudgetings.otpverifydate) as year, assignmentbudgetings.otpverifydate, invoices.created_at as invoice_created_at, invoices.id as invoice_id')
        ->whereBetween('assignmentbudgetings.otpverifydate', [
          $financialStartDate->format('Y-m-d'),
          $financialEndDate->format('Y-m-d')
        ])
        ->orderByRaw('FIELD(MONTH(assignmentbudgetings.otpverifydate), 1,2,3,4,5,6,7,8,9,10,11,12)')
        ->get()
        ->map(function ($item) use ($monthNames) {
          $assignmentclosedDate = Carbon::parse($item->otpverifydate);
          $invoicecreatedDate = Carbon::parse($item->invoice_created_at);
          $item->differenceDays = $assignmentclosedDate->diffInDays($invoicecreatedDate);
          $item->targetDays = 7;
          $item->month = $monthNames[$item->month] ?? $item->month;
          return $item;
        })
        ->groupBy(fn($item) => $item->month . '-' . $item->year)
        ->map(function ($group) {
          $first = $group->first();
          return (object) [
            'month' => $first->month,
            'year' => $first->year,
            'otpverifydate' => $first->otpverifydate,
            'invoice_id' => $first->invoice_id,
            'invoice_created_at' => $first->invoice_created_at,
            'targetDays' => $first->targetDays,
            'differenceDays' => $group->sum('differenceDays'),
            'countitem' => $group->count(),
            // Average Difference Days = (sum of all differenceDays) / number of records
            'averageDifferenceDays' => round($group->avg('differenceDays'), 1),
          ];
        })
        ->sortBy(fn($item) => array_search($item->month, array_values($monthNames)))
        ->values();

    $cashFlowRecieved = DB::table('payments')
        ->selectRaw('MONTH(paymentdate) as month, YEAR(paymentdate) as year, SUM(amountreceived) as amountreceived')
        ->where(function ($query) use ($financialEndYear, $financialStartYear) {
          // Jan to Mar from next year
          $query->where(function ($q) use ($financialEndYear) {
            $q->whereYear('paymentdate', $financialEndYear)
              ->whereIn(DB::raw('MONTH(paymentdate)'), [1, 2, 3]);
          })
            // Apr to Jun from current year
            ->orWhere(function ($q) use ($financialStartYear) {
              $q->whereYear('paymentdate', $financialStartYear)
                ->whereIn(DB::raw('MONTH(paymentdate)'), [4, 5, 6]);
            });
        })
        ->groupByRaw('MONTH(paymentdate), YEAR(paymentdate)')
        ->orderByRaw('FIELD(MONTH(paymentdate), 1, 2, 3, 4, 5, 6)')
        ->get()
        ->map(function ($item) use ($monthNames) {
          $item->month = $monthNames[$item->month] ?? $item->month;
          return $item;
        });

      $cashFlowSpendvender = DB::table('vendorlist')
        ->selectRaw('MONTH(approvedate) as month, YEAR(approvedate) as year, SUM(amount) as total_amounts')
        ->where('status', 4)
        ->where(function ($query) use ($financialEndYear, $financialStartYear) {
          $query->where(function ($q) use ($financialEndYear) {
            $q->whereYear('approvedate', $financialEndYear)
              ->whereIn(DB::raw('MONTH(approvedate)'), [1, 2, 3]);
          })->orWhere(function ($q) use ($financialStartYear) {
            $q->whereYear('approvedate', $financialStartYear)
              ->whereIn(DB::raw('MONTH(approvedate)'), [4, 5, 6]);
          });
        })
        ->groupByRaw('MONTH(approvedate), YEAR(approvedate)')
        ->orderByRaw('FIELD(MONTH(approvedate), 1,2,3,4,5,6)')
        ->get()
        ->map(function ($item) use ($monthNames) {
          $item->month = $monthNames[$item->month] ?? $item->month;
          return $item;
        });

      $cashFlowSpendemployee = DB::table('employeepayrolls')
        ->select('month', 'year', DB::raw('SUM(total_amount_to_paid) as total_amounts'))
        ->where(function ($query) use ($financialEndYear, $financialStartYear) {
          $query->where(function ($q) use ($financialEndYear) {
            $q->where('year', $financialEndYear)
              ->whereIn('month', ['January', 'February', 'March']);
          })->orWhere(function ($q) use ($financialStartYear) {
            $q->where('year', $financialStartYear)
              ->whereIn('month', ['April', 'May', 'June']);
          });
        })
        ->where('send_to_bank', 1)
        ->groupBy('year', 'month')
        ->orderByRaw("FIELD(month, 'January', 'February', 'March', 'April', 'May', 'June')")
        ->get();

      dd($cashFlowRecieved, $cashFlowSpendvender, $cashFlowSpendemployee);


      $mergedSpenddata = $cashFlowSpendvender->merge($cashFlowSpendemployee);

      $cashFlowtotalspendData = $mergedSpenddata->groupBy(function ($item) {
        return $item->month . '-' . $item->year;
      })->map(function ($group) {
        return (object) [
          'month' => $group->first()->month,
          'year' => $group->first()->year,
          'total_amounts' => $group->sum('total_amounts'),
        ];
      })->sortBy(function ($item) {
        $order = ['January', 'February', 'March', 'April', 'May', 'June'];
        return array_search($item->month, $order);
      })->values();

      // Cash Flow Analysis end hare
  // Lap Days Analysis (Assignment to Invoice)
      $assignmentsWithInvoices = DB::table('assignmentmappings')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        // get only those assignments for which an invoice has been created
        ->join('invoices', 'invoices.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->selectRaw('MONTH(assignmentbudgetings.otpverifydate) as month, YEAR(assignmentbudgetings.otpverifydate) as year, assignmentbudgetings.otpverifydate, invoices.created_at as invoice_created_at, invoices.id as invoice_id')
        ->whereBetween('assignmentbudgetings.otpverifydate', [
          $financialStartDate->format('Y-m-d'),
          $financialEndDate->format('Y-m-d')
        ])
        ->orderByRaw('FIELD(MONTH(assignmentbudgetings.otpverifydate), 1,2,3,4,5,6,7,8,9,10,11,12)')
        ->get()
        ->map(function ($item) use ($monthNames) {
          $assignmentclosedDate = Carbon::parse($item->otpverifydate);
          $invoicecreatedDate = Carbon::parse($item->invoice_created_at);
          $item->differenceDays = $assignmentclosedDate->diffInDays($invoicecreatedDate);
          $item->targetDays = 7;
          $item->month = $monthNames[$item->month] ?? $item->month;
          return $item;
        })
        ->groupBy(fn($item) => $item->month . '-' . $item->year)
        ->map(function ($group) {
          $first = $group->first();
          return (object) [
            'month' => $first->month,
            'year' => $first->year,
            'otpverifydate' => $first->otpverifydate,
            'invoice_id' => $first->invoice_id,
            'invoice_created_at' => $first->invoice_created_at,
            'targetDays' => $first->targetDays,
            'differenceDays' => $group->sum('differenceDays'),
            'countitem' => $group->count(),
            // Average Difference Days = (sum of all differenceDays) / number of records
            'averageDifferenceDays' => round($group->avg('differenceDays'), 1),
          ];
        })
        ->sortBy(fn($item) => array_search($item->month, array_values($monthNames)))
        ->values();


    public function filterdashboardreport(Request $request)
  {
    $yearly = $request->input('yearly');
    $monthsdigit = $request->input('months');
    [$startYear, $endYear] = explode('-', $yearly);
    if (!empty($monthsdigit)) {
      $monthNames = [
        1  => 'January',
        2  => 'February',
        3  => 'March',
        4  => 'April',
        5  => 'May',
        6  => 'June',
        7  => 'July',
        8  => 'August',
        9  => 'September',
        10 => 'October',
        11 => 'November',
        12 => 'December',
      ];
      $months = $monthNames[$monthsdigit];
    }

    // financial year date range using input years
    $startDate = Carbon::createFromFormat('Y-m-d', $startYear . '-04-01');
    $endDate   = Carbon::createFromFormat('Y-m-d', $endYear . '-03-31');
    $startDateFormatted = $startDate->format('Y-m-d');
    $endDateFormatted = $endDate->format('Y-m-d');

    if (auth()->user()->role_id == 11) {
      //ff How many amounts pending for invoice genrated
      $billspendingQuery = DB::table('assignmentmappings')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->leftJoin('invoices', 'invoices.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->whereBetween(DB::raw('COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate)'), [$startDateFormatted, $endDateFormatted])
        ->where(function ($query) use ($startDateFormatted, $endDateFormatted) {
          $query->whereNull('invoices.created_at')
            ->orWhereNotBetween('invoices.created_at', [$startDateFormatted, $endDateFormatted]);
        })
        ->where('assignmentbudgetings.status', 0);

      if (!empty($monthsdigit)) {
        $billspendingQuery->whereMonth(DB::raw('COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate)'), $monthsdigit);
      }

      $billspending = $billspendingQuery->sum('assignmentmappings.engagementfee');


      //ff Bills Pending For Collection
      $billspendingforcollectionQuery = DB::table('assignmentmappings')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->leftJoin('invoices', 'invoices.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->leftJoin('outstandings', 'outstandings.BILL_NO', '=', 'invoices.invoice_id')
        ->where('assignmentbudgetings.status', 0)
        // ensures invoice is created
        ->whereNotNull('invoices.id')
        ->whereBetween(DB::raw('COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate)'), [$startDateFormatted, $endDateFormatted])
        ->whereBetween('invoices.created_at', [$startDateFormatted, $endDateFormatted]);

      if (!empty($monthsdigit)) {
        $billspendingforcollectionQuery->whereMonth('invoices.created_at', $monthsdigit);
      }
      $billspendingforcollection = $billspendingforcollectionQuery->sum('outstandings.AMT');


      //ff How many Assignments Completed in this months
      $query = DB::table('assignmentmappings')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id');
      $query->whereBetween('assignmentbudgetings.otpverifydate', [$startDateFormatted, $endDateFormatted]);
      if (!empty($monthsdigit)) {
        $query->whereMonth('assignmentbudgetings.otpverifydate', $monthsdigit);
      }
      $assignmentcompleted = $query->count();


      //ff How many Delayed Assignments
      $delayedQuery = DB::table('assignmentmappings')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->whereBetween(DB::raw('COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate)'), [$startDateFormatted, $endDateFormatted]);
      if (!empty($monthsdigit)) {
        $delayedQuery->whereMonth(DB::raw('COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate)'), $monthsdigit);
      }
      $delayedAssignments = $delayedQuery->count();


      //ff total amount of convence, how many amount approved for convence in this months or Exceptional Expenses 
      $exceptionalQuery = DB::table('outstationconveyances')
        ->where('status', 6)
        ->whereBetween('approveddate', [$startDateFormatted, $endDateFormatted]);
      if (!empty($monthsdigit)) {
        $exceptionalQuery->whereMonth('approveddate', $monthsdigit);
      }
      $exceptionalExpenses = $exceptionalQuery->sum('finalamount');


      //ff How many New Tenders Submitted this months
      $tendersQuery = DB::table('tenders')
        ->where('tendersubmitstatus', 1)
        ->whereBetween('date', [$startDateFormatted, $endDateFormatted]);
      if (!empty($monthsdigit)) {
        $tendersQuery->whereMonth('date', $monthsdigit);
      }
      $tendersSubmittedCount = $tendersQuery->count();

      //ff how many users not accepted Audit Acceptance Pending mail till now
      $totalNotFilled = DB::table('assignmentmappings')
        ->select(DB::raw('COUNT(*) as total_not_filled'))
        ->leftJoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->leftJoin('teammembers', 'teammembers.id', '=', 'assignmentteammappings.teammember_id')
        ->leftJoin('annual_independence_declarations', function ($join) {
          $join->on('annual_independence_declarations.assignmentgenerateid', '=', 'assignmentmappings.assignmentgenerate_id')
            ->on('annual_independence_declarations.createdby', '=', 'teammembers.id')
            ->where('annual_independence_declarations.type', 2);
        })
        ->whereNull('annual_independence_declarations.id') // Members without declarations
        ->whereBetween(DB::raw('COALESCE(assignmentbudgetings.actualstartdate, assignmentbudgetings.tentativestartdate)'), [$startDateFormatted, $endDateFormatted])
        ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
          $query->whereMonth(DB::raw('COALESCE(assignmentbudgetings.actualstartdate, assignmentbudgetings.tentativestartdate)'), $monthsdigit);
        })
        ->groupBy('assignmentmappings.assignmentgenerate_id')
        ->get()
        ->sum('total_not_filled');


      //ff How many NAFRA are running
      $auditsDueQuery = DB::table('assignmentmappings')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->where('assignmentbudgetings.status', 1)
        ->where('assignmentmappings.eqcrapplicability', 1)
        ->whereBetween(DB::raw('COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate)'), [$startDateFormatted, $endDateFormatted]);
      if (!empty($monthsdigit)) {
        $auditsDueQuery->whereMonth(DB::raw('COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate)'), $monthsdigit);
      }
      $auditsDue = $auditsDueQuery->count();

      //ff Upcoming Assignments
      $upcomingQuery = DB::table('assignmentplannings')
        ->whereDate('assignmentstartdate', '>', Carbon::today())
        ->whereBetween('assignmentstartdate', [$startDateFormatted, $endDateFormatted]);
      if (!empty($monthsdigit)) {
        $upcomingQuery->whereMonth('assignmentstartdate', $monthsdigit);
      }
      $upcomingFromPlannings = $upcomingQuery->count();


      $upcomingFromBudgetingsQuery = DB::table('assignmentbudgetings')
        ->whereRaw('COALESCE(actualstartdate, tentativestartdate) > ?', [Carbon::today()->toDateString()])
        ->whereBetween(DB::raw('COALESCE(actualstartdate, tentativestartdate)'), [$startDateFormatted, $endDateFormatted]);
      if (!empty($monthsdigit)) {
        $upcomingFromBudgetingsQuery->whereMonth(DB::raw('COALESCE(actualstartdate, tentativestartdate)'), $monthsdigit);
      }
      $upcomingFromBudgetings = $upcomingFromBudgetingsQuery->count();
      $totalUpcomingAssignments = $upcomingFromPlannings + $upcomingFromBudgetings;


      //ff How many amounts pending for collection within 15 days or Payments Not Recieved
      $billspending15Days = DB::table('assignmentmappings')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->leftJoin('invoices', 'invoices.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->leftJoin('payments', 'payments.invoiceid', '=', 'invoices.invoice_id')
        ->where('assignmentbudgetings.status', 0)
        ->whereNotNull('invoices.id') // Invoice is created
        ->whereNull('payments.invoiceid') // Payment not yet received
        ->whereBetween('invoices.created_at', [$startDateFormatted, $endDateFormatted])
        ->when(!empty($monthsdigit), function ($query) use ($monthsdigit, $startYear, $endYear) {
          $yearForMonth = $monthsdigit >= 4 ? $startYear : $endYear;
          $monthEnd = Carbon::create($yearForMonth, $monthsdigit, 1)->endOfMonth();
          // $monthStart = $monthEnd->copy()->subDays(28);
          $monthStart = $monthEnd->copy()->subDays(15);
          return $query->whereYear('invoices.created_at', $yearForMonth)
            ->whereMonth('invoices.created_at', $monthsdigit)
            ->whereBetween('invoices.created_at', [$monthStart, $monthEnd]);
        })
        ->when(empty($monthsdigit), function ($query) use ($endDateFormatted) {
          return $query->whereDate('invoices.created_at', '>=', Carbon::parse($endDateFormatted)->subDays(15));
        })
        ->sum('invoices.total');

      //ff Timesheet Filled On Closed Assignment
      $timesheetOnClosedAssignment = DB::table('assignmentmappings')
        ->join('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->join('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
        ->whereExists(function ($query) {
          $query->select(DB::raw(1))
            ->from('timesheetusers')
            ->whereRaw('timesheetusers.assignmentgenerate_id = assignmentmappings.assignmentgenerate_id')
            ->whereRaw("DATE(timesheetusers.created_at) > DATE(COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate))");
        })
        ->whereBetween(DB::raw('COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate)'), [$startDateFormatted, $endDateFormatted])
        ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
          $query->whereMonth(DB::raw('COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate)'), $monthsdigit);
        })
        ->select('assignmentmappings.assignmentgenerate_id')
        ->distinct()
        ->count();

      //ff Work From Home 
      $workFromHomeQuery = DB::table('checkins')
        ->where('checkin_from', 'Work From Home')
        ->whereBetween('created_at', [$startDateFormatted, $endDateFormatted]);
      if (!empty($monthsdigit)) {
        $workFromHomeQuery->whereMonth('created_at', $monthsdigit);
      }
      $workFromHome = $workFromHomeQuery->count();


      // Assignment Status Overview
      $assignmentOverviews = DB::table('assignmentmappings')
        ->select(
          'assignmentmappings.*',
          'assignmentbudgetings.assignmentname',
          'assignmentbudgetings.status',
          DB::raw('COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate) as finalassignmentenddate'),
          'clients.client_name',
          DB::raw('(SELECT SUM(totalhour) FROM timesheetusers WHERE timesheetusers.assignmentgenerate_id = assignmentmappings.assignmentgenerate_id) as workedHours')
        )
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->leftJoin('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
        ->orderByDesc('assignmentbudgetings.id')
        ->limit(3)
        ->get()
        ->map(function ($assignmentOverview) {
          $totalHours = $assignmentOverview->esthours ?? 0;
          $workedHours = $assignmentOverview->workedHours ?? 0;
          $completionPercentage = $totalHours > 0 ? round(($workedHours / $totalHours) * 100, 2) : 0;
          $assignmentOverview->completionPercentage = $completionPercentage;
          return $assignmentOverview;
        });


      // Document Completion Progress
      $documentCompletions = DB::table('assignmentmappings')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->leftJoin('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
        // ->where('assignmentbudgetings.status', 1)
        ->orderByDesc('assignmentbudgetings.id')
        ->select(
          'assignmentmappings.*',
          'assignmentbudgetings.assignmentname',
          'clients.client_name'
        )
        ->limit(6)
        ->get();

      foreach ($documentCompletions as $mapping) {
        $assignmentId = $mapping->assignmentgenerate_id;

        // Get assignment_id and eqcrapplicability
        $assignmentMapping = DB::table('assignmentmappings')
          ->where('assignmentgenerate_id', $assignmentId)
          ->select('assignment_id', 'eqcrapplicability')
          ->first();

        // Determine EQCR type name
        $eqcrTypeName = '';
        $eqcrAssignmentId = null;
        if (isset($assignmentMapping->eqcrapplicability)) {
          switch ($assignmentMapping->eqcrapplicability) {
            case 1:
              $eqcrTypeName = 'NFRA';
              break;
            case 2:
              $eqcrTypeName = 'Quality Review';
              break;
            case 3:
              $eqcrTypeName = 'Peer Review';
              break;
            case 4:
              $eqcrTypeName = 'Others';
              break;
            case 5:
              $eqcrTypeName = 'PCAOB';
              break;
          }
          // Get the assignment_id for the EQCR type
          $specialAssignment = DB::table('assignments')
            ->where('assignment_name', $eqcrTypeName)
            ->first();
          if ($specialAssignment) {
            $eqcrAssignmentId = $specialAssignment->id;
          }
        }
        $mapping->eqcr_type_name = $eqcrTypeName;

        // Regular Checklist Calculations (Exclude EQCR assignment_id)
        $classificationIds = DB::table('financialstatementclassifications')
          ->where('assignment_id', $assignmentMapping->assignment_id)
          ->where(function ($q) use ($assignmentId) {
            $q->whereNull('assignmentgenerate_id')->orWhere('assignmentgenerate_id', $assignmentId);
          })
          ->when($eqcrAssignmentId, function ($query) use ($eqcrAssignmentId) {
            $query->where('assignment_id', '!=', $eqcrAssignmentId);
          })
          ->pluck('id');



        $subClassIds = DB::table('subfinancialclassfications')
          ->whereIn('financialstatemantclassfication_id', $classificationIds)
          ->pluck('id');



        $totalQuestions = DB::table('auditquestions')
          ->whereIn('financialstatemantclassfication_id', $classificationIds)
          ->whereIn('subclassfied_id', $subClassIds)
          ->count();


        $statusCounts = DB::table('checklistanswers')
          ->join('statuses', 'checklistanswers.status', '=', 'statuses.id')
          ->where('checklistanswers.assignment_id', $assignmentId)
          ->whereIn('checklistanswers.financialstatemantclassfication_id', $classificationIds)
          ->whereIn('checklistanswers.subclassfied_id', $subClassIds)
          ->select(
            'statuses.name as status_name',
            DB::raw('COUNT(*) as count')
          )
          ->groupBy('statuses.name')
          ->pluck('count', 'status_name');



        $closedQuestions = $statusCounts['CLOSE'] ?? 0;

        $mapping->documentation_percentage = $totalQuestions > 0
          ? round(($closedQuestions / $totalQuestions) * 100, 2)
          : 0;
      }
      // Document Completion Progress end hare 


      // ECQR Audits & Quality Reviews
      $ecqrAudits = DB::table('assignmentmappings')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.eqcrpartner')
        ->leftJoin('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
        // ->where('assignmentbudgetings.status', 1)
        ->whereIn('assignmentmappings.eqcrapplicability', [1, 2])
        ->select(
          'assignmentmappings.*',
          'teammembers.team_member',
          'assignmentbudgetings.assignmentname',
          'assignmentbudgetings.status',
          DB::raw('COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate) as finalassignmentenddate'),
          'clients.client_name'
        )
        ->limit(3)
        ->get();


      // High Priority Tasks Pending
      $highpriorityAssignments  = DB::table('assignmentmappings')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftJoin('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
        ->select(
          'assignmentmappings.*',
          'assignmentbudgetings.assignmentname',
          DB::raw('COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate) as finalassignmentenddate'),
          'clients.client_name'
        )
        ->limit(6)
        ->get();


      // Fetch IT and Finance Tickets
      $ticketDatas = Assetticket::with(['financerequest', 'createdBy', 'partner'])
        ->whereIn('type', [0, 1])
        ->orderByDesc('id')
        ->limit(4)
        ->get()
        ->map(function ($item) {
          return [
            'ticket_id' => $item->generateticket_id,
            'department' => $item->type == 0 ? 'IT' : 'Finance',
            'created_by' => $item->createdBy->team_member ?? '',
            'subject' => $item->subject,
            'assigned_to' => $item->partner->team_member ?? '',
            'created_at' => $item->created_at,
            'status' => $item->status,
            'source' => 'ticket',
          ];
        });

      // Fetch HR Tasks
      $hrTickets = DB::table('tasks')
        ->select(
          'tasks.*',
          'patnerid.team_member as partnername',
          'createdby.team_member as createdbyname',
          'hrfunctions.hrfunction'
        )
        ->where('tasks.task_type', 4)
        ->leftJoin('teammembers as patnerid', 'patnerid.id', '=', 'tasks.partner_id')
        ->leftJoin('teammembers as createdby', 'createdby.id', '=', 'tasks.createdby')
        ->leftJoin('hrfunctions', 'hrfunctions.id', '=', 'tasks.hrfunction')
        ->orderByDesc('tasks.id')
        ->limit(4)
        ->get()
        ->map(function ($item) {
          return [
            'ticket_id' => 'N/A',
            'department' => 'HR',
            'created_by' => $item->createdbyname ?? '',
            'subject' => $item->taskname ?? '',
            'assigned_to' => $item->partnername ?? '',
            'created_at' => $item->created_at,
            'status' => $item->status,
            'source' => 'hr',
          ];
        });

      $allTickets = $ticketDatas->merge($hrTickets);

      // Assignment-wise P&L Analysis and Loss Making Assignments
      $assignmentCosts = DB::table('timesheetusers')
        ->leftJoin('teammembers', 'teammembers.id', '=', 'timesheetusers.createdby')
        // ->where('timesheetusers.assignmentgenerate_id', 254418551033)
        ->select('timesheetusers.assignmentgenerate_id', DB::raw('SUM(timesheetusers.totalhour * teammembers.cost_hour) as total_cost'))
        ->groupBy('timesheetusers.assignmentgenerate_id')
        ->pluck('total_cost', 'assignmentgenerate_id');

      $assignmentprofitandlosses = DB::table('assignmentmappings')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->leftJoin('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
        ->orderByDesc('assignmentbudgetings.id')
        ->select(
          'assignmentmappings.*',
          'assignmentbudgetings.assignmentname',
          'assignmentbudgetings.status',
          DB::raw('COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate) as finalassignmentenddate'),
          'clients.client_name'
        )
        ->limit(6)
        ->get();

      $lossMakingCount = 0;
      foreach ($assignmentprofitandlosses as $assignment) {
        $assignment->total_cost = $assignmentCosts[$assignment->assignmentgenerate_id] ?? 0;

        // Loss Making Assignments
        $revenue = $assignment->engagementfee ?? 0;
        $cost = $assignment->total_cost ?? 0;
        $profit = $revenue - $cost;

        if ($profit < 0) {
          $lossMakingCount++;
        }
      }


      // Partner-wise P&L Statement
      // $currentDate = Carbon::now();
      $todayDate = Carbon::parse('2024-07-01');
      $financialStartdate = $todayDate->month >= 4 ? Carbon::create($todayDate->year, 4, 1) : Carbon::create($todayDate->year - 1, 4, 1);
      $financialEnddate = $financialStartdate->copy()->addYear()->subDay();

      $assignmentGenerateIds = DB::table('assignmentbudgetings')
        ->whereBetween('periodstartdate', [$financialStartdate, $financialEnddate])
        ->whereBetween('periodenddate', [$financialStartdate, $financialEnddate])
        ->pluck('assignmentgenerate_id');

      $invoices = DB::table('invoices')
        ->select(
          'invoices.assignmentgenerate_id',
          'teammembers.team_member',
          DB::raw('SUM(invoices.total) as total')
        )
        ->join('teammembers', 'teammembers.id', '=', 'invoices.partner')
        ->whereIn('invoices.assignmentgenerate_id', $assignmentGenerateIds)
        ->groupBy('invoices.assignmentgenerate_id', 'teammembers.team_member')
        ->get();

      $timesheetData = DB::table('timesheetusers')
        ->select('assignmentgenerate_id', 'createdby', DB::raw('SUM(totalhour) as total_hour'))
        ->whereIn('assignmentgenerate_id', $assignmentGenerateIds)
        ->groupBy('assignmentgenerate_id', 'createdby')
        ->get();

      $teamMemberCosts = DB::table('teammembers')
        ->whereIn('id', $timesheetData->pluck('createdby')->unique())
        ->pluck('cost_hour', 'id');

      $groupedCosts = $timesheetData->groupBy('assignmentgenerate_id')->map(function ($rows) use ($teamMemberCosts) {
        return $rows->sum(function ($row) use ($teamMemberCosts) {
          return $row->total_hour * ($teamMemberCosts[$row->createdby] ?? 0);
        });
      });

      $finalData = $invoices->map(function ($row) use ($groupedCosts) {
        $row->cost = $groupedCosts[$row->assignmentgenerate_id] ?? 0;
        $row->profit_loss = $row->total - $row->cost;
        return $row;
      });

      $partnerWiseProfit = $finalData
        ->groupBy('team_member')
        ->map(function ($items, $teamMember) {
          return (object)[
            'team_member' => $teamMember,
            'total' => $items->sum(fn($item) => (float) $item->total),
            'cost' => $items->sum('cost'),
            'profit_loss' => $items->sum('profit_loss'),
          ];
        })
        // Reset index if needed
        ->values();
      // Partner-wise P&L Statement end hare


      // Staff Allocation vs Actual Timesheet Analysis
      $teamAllocatedHours = DB::table('assignmentteammappings')
        ->join('teammembers', 'teammembers.id', '=', 'assignmentteammappings.teammember_id')
        // ->where('assignmentteammappings.teammember_id', 815)
        ->select(
          'assignmentteammappings.teammember_id',
          'teammembers.team_member',
          DB::raw('SUM(assignmentteammappings.teamesthour) as teamallocatedhours')
        )
        ->groupBy('assignmentteammappings.teammember_id', 'teammembers.team_member')
        ->limit(6)
        ->get();

      foreach ($teamAllocatedHours as $teamAllocatedHour) {

        $actualHours = DB::table('timesheetusers')
          ->where('createdby', $teamAllocatedHour->teammember_id)
          ->sum('totalhour');

        if (is_null($teamAllocatedHour->teamallocatedhours)) {
          $teamAllocatedHour->teamallocatedhours = 0;
        }
        $teamAllocatedHour->actualhours = $actualHours;
        // $discrepancy = (float) $teamAllocatedHour->teamallocatedhours - $actualHours;
        $discrepancy = $actualHours - (float) $teamAllocatedHour->teamallocatedhours;
        $teamAllocatedHour->discrepancy = $discrepancy;
      }

      // Monthly Expense Analysis
      // financial year
      $financialStartYear = now()->month >= 4 ? now()->year : now()->year - 1;
      $financialEndYear = $financialStartYear + 1;
      $monthNames = [1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June'];


      $teamsSalaries = DB::table('employeepayrolls')
        ->select(
          'month',
          'year',
          DB::raw('SUM(total_amount_to_paid) as total_amount')
        )
        ->where(function ($query) use ($financialEndYear, $financialStartYear) {
          // Jan to Mar from next year
          $query->where(function ($q) use ($financialEndYear) {
            $q->where('year', $financialEndYear)
              ->whereIn('month', ['January', 'February', 'March']);
          })
            // Apr to Jun from current year
            ->orWhere(function ($q) use ($financialStartYear) {
              $q->where('year', $financialStartYear)
                ->whereIn('month', ['April', 'May', 'June']);
            });
        })
        ->where('send_to_bank', 1)
        ->groupBy('year', 'month')
        ->orderByRaw("FIELD(month, 'January', 'February', 'March', 'April', 'May', 'June')")
        ->get();




      $teamexceptionalExpenses = DB::table('outstationconveyances')
        ->selectRaw('MONTH(approveddate) as month, YEAR(approveddate) as year, SUM(finalamount) as total_amount')
        ->where('status', 6)
        ->where(function ($query) use ($financialEndYear, $financialStartYear) {
          // Jan to Mar from next year
          $query->where(function ($q) use ($financialEndYear) {
            $q->whereYear('approveddate', $financialEndYear)
              ->whereIn(DB::raw('MONTH(approveddate)'), [1, 2, 3]);
          })
            // Apr to Jun from current year
            ->orWhere(function ($q) use ($financialStartYear) {
              $q->whereYear('approveddate', $financialStartYear)
                ->whereIn(DB::raw('MONTH(approveddate)'), [4, 5, 6]);
            });
        })
        ->groupByRaw('MONTH(approveddate), YEAR(approveddate)')
        ->orderByRaw('FIELD(MONTH(approveddate), 1, 2, 3, 4, 5, 6)')
        ->get()
        ->map(function ($item) use ($monthNames) {
          $item->month = $monthNames[$item->month] ?? $item->month;
          return $item;
        });


      // Cash Flow Analysis
      $cashFlowRecieved = DB::table('payments')
        ->selectRaw('MONTH(paymentdate) as month, YEAR(paymentdate) as year, SUM(amountreceived) as amountreceived')
        ->where(function ($query) use ($financialEndYear, $financialStartYear) {
          // Jan to Mar from next year
          $query->where(function ($q) use ($financialEndYear) {
            $q->whereYear('paymentdate', $financialEndYear)
              ->whereIn(DB::raw('MONTH(paymentdate)'), [1, 2, 3]);
          })
            // Apr to Jun from current year
            ->orWhere(function ($q) use ($financialStartYear) {
              $q->whereYear('paymentdate', $financialStartYear)
                ->whereIn(DB::raw('MONTH(paymentdate)'), [4, 5, 6]);
            });
        })
        ->groupByRaw('MONTH(paymentdate), YEAR(paymentdate)')
        ->orderByRaw('FIELD(MONTH(paymentdate), 1, 2, 3, 4, 5, 6)')
        ->get()
        ->map(function ($item) use ($monthNames) {
          $item->month = $monthNames[$item->month] ?? $item->month;
          return $item;
        });

      $cashFlowSpendvender = DB::table('vendorlist')
        ->selectRaw('MONTH(approvedate) as month, YEAR(approvedate) as year, SUM(amount) as total_amounts')
        ->where('status', 4)
        ->where(function ($query) use ($financialEndYear, $financialStartYear) {
          $query->where(function ($q) use ($financialEndYear) {
            $q->whereYear('approvedate', $financialEndYear)
              ->whereIn(DB::raw('MONTH(approvedate)'), [1, 2, 3]);
          })->orWhere(function ($q) use ($financialStartYear) {
            $q->whereYear('approvedate', $financialStartYear)
              ->whereIn(DB::raw('MONTH(approvedate)'), [4, 5, 6]);
          });
        })
        ->groupByRaw('MONTH(approvedate), YEAR(approvedate)')
        ->orderByRaw('FIELD(MONTH(approvedate), 1,2,3,4,5,6)')
        ->get()
        ->map(function ($item) use ($monthNames) {
          $item->month = $monthNames[$item->month] ?? $item->month;
          return $item;
        });

      $cashFlowSpendemployee = DB::table('employeepayrolls')
        ->select('month', 'year', DB::raw('SUM(total_amount_to_paid) as total_amounts'))
        ->where(function ($query) use ($financialEndYear, $financialStartYear) {
          $query->where(function ($q) use ($financialEndYear) {
            $q->where('year', $financialEndYear)
              ->whereIn('month', ['January', 'February', 'March']);
          })->orWhere(function ($q) use ($financialStartYear) {
            $q->where('year', $financialStartYear)
              ->whereIn('month', ['April', 'May', 'June']);
          });
        })
        ->where('send_to_bank', 1)
        ->groupBy('year', 'month')
        ->orderByRaw("FIELD(month, 'January', 'February', 'March', 'April', 'May', 'June')")
        ->get();


      $mergedSpenddata = $cashFlowSpendvender->merge($cashFlowSpendemployee);

      $cashFlowtotalspendData = $mergedSpenddata->groupBy(function ($item) {
        return $item->month . '-' . $item->year;
      })->map(function ($group) {
        return (object) [
          'month' => $group->first()->month,
          'year' => $group->first()->year,
          'total_amounts' => $group->sum('total_amounts'),
        ];
      })->sortBy(function ($item) {
        $order = ['January', 'February', 'March', 'April', 'May', 'June'];
        return array_search($item->month, $order);
      })->values();

      // Cash Flow Analysis end hare

      // Invoice Due vs Assignment Billing vs Cash Recovery
      $assignmentBilling = DB::table('invoices')
        ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, SUM(total) as invoices_amount')
        ->where(function ($query) use ($financialEndYear, $financialStartYear) {
          // Jan to Mar from next year
          $query->where(function ($q) use ($financialEndYear) {
            $q->whereYear('created_at', $financialEndYear)
              ->whereIn(DB::raw('MONTH(created_at)'), [1, 2, 3]);
          })
            // Apr to Jun from current year
            ->orWhere(function ($q) use ($financialStartYear) {
              $q->whereYear('created_at', $financialStartYear)
                ->whereIn(DB::raw('MONTH(created_at)'), [4, 5, 6]);
            });
        })
        ->groupByRaw('MONTH(created_at), YEAR(created_at)')
        ->orderByRaw('FIELD(MONTH(created_at), 1, 2, 3, 4, 5, 6)')
        ->get()
        ->map(function ($item) use ($monthNames) {
          $item->month = $monthNames[$item->month] ?? $item->month;
          return $item;
        });

      $assignmentOutstanding = DB::table('outstandings')
        ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, SUM(AMT) as outstanding_amount')
        ->where(function ($query) use ($financialEndYear, $financialStartYear) {
          // Jan to Mar from next year
          $query->where(function ($q) use ($financialEndYear) {
            $q->whereYear('created_at', $financialEndYear)
              ->whereIn(DB::raw('MONTH(created_at)'), [1, 2, 3]);
          })
            // Apr to Jun from current year
            ->orWhere(function ($q) use ($financialStartYear) {
              $q->whereYear('created_at', $financialStartYear)
                ->whereIn(DB::raw('MONTH(created_at)'), [4, 5, 6]);
            });
        })
        ->groupByRaw('MONTH(created_at), YEAR(created_at)')
        ->orderByRaw('FIELD(MONTH(created_at), 1, 2, 3, 4, 5, 6)')
        ->get()
        ->map(function ($item) use ($monthNames) {
          $item->month = $monthNames[$item->month] ?? $item->month;
          return $item;
        });

      $cashRecovery = DB::table('payments')
        ->selectRaw('MONTH(paymentdate) as month, YEAR(paymentdate) as year, SUM(amountreceived) as amountreceived')
        ->where(function ($query) use ($financialEndYear, $financialStartYear) {
          // Jan to Mar from next year
          $query->where(function ($q) use ($financialEndYear) {
            $q->whereYear('paymentdate', $financialEndYear)
              ->whereIn(DB::raw('MONTH(paymentdate)'), [1, 2, 3]);
          })
            // Apr to Jun from current year
            ->orWhere(function ($q) use ($financialStartYear) {
              $q->whereYear('paymentdate', $financialStartYear)
                ->whereIn(DB::raw('MONTH(paymentdate)'), [4, 5, 6]);
            });
        })
        ->groupByRaw('MONTH(paymentdate), YEAR(paymentdate)')
        ->orderByRaw('FIELD(MONTH(paymentdate), 1, 2, 3, 4, 5, 6)')
        ->get()
        ->map(function ($item) use ($monthNames) {
          $item->month = $monthNames[$item->month] ?? $item->month;
          return $item;
        });

      // Lap Days Analysis (Assignment to Invoice)
      $assignmentsWithInvoices = DB::table('assignmentmappings')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        // get only those assignments for which an invoice has been created
        ->join('invoices', 'invoices.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->selectRaw('MONTH(assignmentbudgetings.otpverifydate) as month, YEAR(assignmentbudgetings.otpverifydate) as year, assignmentbudgetings.otpverifydate, invoices.created_at as invoice_created_at, invoices.id as invoice_id')
        ->where(function ($query) use ($financialStartYear, $financialEndYear) {
          // Jan to Mar from next year
          $query->where(function ($q) use ($financialEndYear) {
            $q->whereYear('assignmentbudgetings.otpverifydate', $financialEndYear)
              ->whereIn(DB::raw('MONTH(assignmentbudgetings.otpverifydate)'), [1, 2, 3]);
          })->orWhere(function ($q) use ($financialStartYear) {
            // Apr to Jun from current year
            $q->whereYear('assignmentbudgetings.otpverifydate', $financialStartYear)
              ->whereIn(DB::raw('MONTH(assignmentbudgetings.otpverifydate)'), [4, 5, 6]);
          });
        })
        ->orderByRaw('FIELD(MONTH(assignmentbudgetings.otpverifydate), 1,2,3,4,5,6)')
        ->get()
        ->map(function ($item) use ($monthNames) {
          $assignmentclosedDate = Carbon::parse($item->otpverifydate);
          $invoicecreatedDate = Carbon::parse($item->invoice_created_at);
          $item->differenceDays = $assignmentclosedDate->diffInDays($invoicecreatedDate);
          $item->targetDays = 7;
          $item->month = $monthNames[$item->month] ?? $item->month;
          return $item;
        })
        ->groupBy(fn($item) => $item->month . '-' . $item->year)
        ->map(function ($group) {
          $first = $group->first();
          return (object) [
            'month' => $first->month,
            'year' => $first->year,
            'otpverifydate' => $first->otpverifydate,
            'invoice_id' => $first->invoice_id,
            'invoice_created_at' => $first->invoice_created_at,
            'targetDays' => $first->targetDays,
            'differenceDays' => $group->sum('differenceDays'),
            'countitem' => $group->count(),
            // Average Difference Days = (sum of all differenceDays) / number of records
            'averageDifferenceDays' => round($group->avg('differenceDays'), 1),
          ];
        })
        ->sortBy(fn($item) => array_search($item->month, array_values($monthNames)))
        ->values();

      // Budget vs Actual P&L
      $budgetRevenueandbudgetExpences = DB::table('assignmentmappings')
        ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, SUM(engagementfee) as engagementfee, SUM(teamestcost) as total_teamestcost')
        ->where(function ($query) use ($financialEndYear, $financialStartYear) {
          // Jan to Mar from next year
          $query->where(function ($q) use ($financialEndYear) {
            $q->whereYear('created_at', $financialEndYear)
              ->whereIn(DB::raw('MONTH(created_at)'), [1, 2, 3]);
          })
            // Apr to Jun from current year
            ->orWhere(function ($q) use ($financialStartYear) {
              $q->whereYear('created_at', $financialStartYear)
                ->whereIn(DB::raw('MONTH(created_at)'), [4, 5, 6]);
            });
        })
        ->groupByRaw('MONTH(created_at), YEAR(created_at)')
        ->orderByRaw('FIELD(MONTH(created_at), 1, 2, 3, 4, 5, 6)')
        ->get()
        ->map(function ($item) use ($monthNames) {
          $item->month = $monthNames[$item->month] ?? $item->month;
          return $item;
        });

      $budgetActualRevenue = DB::table('invoices')
        ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, SUM(total) as invoices_amount')
        ->where(function ($query) use ($financialEndYear, $financialStartYear) {
          // Jan to Mar from next year
          $query->where(function ($q) use ($financialEndYear) {
            $q->whereYear('created_at', $financialEndYear)
              ->whereIn(DB::raw('MONTH(created_at)'), [1, 2, 3]);
          })
            // Apr to Jun from current year
            ->orWhere(function ($q) use ($financialStartYear) {
              $q->whereYear('created_at', $financialStartYear)
                ->whereIn(DB::raw('MONTH(created_at)'), [4, 5, 6]);
            });
        })
        ->groupByRaw('MONTH(created_at), YEAR(created_at)')
        ->orderByRaw('FIELD(MONTH(created_at), 1, 2, 3, 4, 5, 6)')
        ->get()
        ->map(function ($item) use ($monthNames) {
          $item->month = $monthNames[$item->month] ?? $item->month;
          return $item;
        });



      $budgetActualExpences = DB::table('timesheets')
        ->leftJoin('timesheetusers', 'timesheetusers.timesheetid', '=', 'timesheets.id')
        ->leftJoin('teammembers', 'teammembers.id', '=', 'timesheetusers.createdby')
        ->whereIn('timesheets.created_by', [815, 818])
        ->selectRaw('MONTH(timesheets.date) as month, YEAR(timesheets.date) as year, SUM(timesheetusers.totalhour * teammembers.cost_hour) as total_cost')
        ->where(function ($query) use ($financialStartYear, $financialEndYear) {
          $query->where(function ($q) use ($financialEndYear) {
            $q->whereYear('timesheets.date', $financialEndYear)
              ->whereIn(DB::raw('MONTH(timesheets.date)'), [1, 2, 3]); // Jan-Mar
          })->orWhere(function ($q) use ($financialStartYear) {
            $q->whereYear('timesheets.date', $financialStartYear)
              ->whereIn(DB::raw('MONTH(timesheets.date)'), [4, 5, 6]); // Apr-Jun
          });
        })
        ->groupByRaw('MONTH(timesheets.date), YEAR(timesheets.date)')
        ->get()
        ->map(function ($item) use ($monthNames) {
          $item->month = $monthNames[$item->month] ?? $item->month;
          return $item;
        });

      // Budget vs Actual P&L

      // filter data 
      $startYearforfilter = 2022;
      $currentDatetoday = Carbon::now();
      $currentYearforfilter = $currentDatetoday->year;
      $currentMonthforfilter = $currentDatetoday->month;
      $currentFinancialYear = $currentMonthforfilter >= 4 ? $currentYearforfilter : $currentYearforfilter - 1;

      $financialYears = [];
      for ($year = $startYearforfilter; $year <= $currentFinancialYear; $year++) {
        $financialYears[] = [
          'value' => $year . '-' . ($year + 1),
        ];
      }

      $request->flash();
      return view('backEnd.kgsdashboardreport', compact('financialYears', 'workFromHome', 'budgetRevenueandbudgetExpences', 'budgetActualRevenue', 'budgetActualExpences', 'assignmentsWithInvoices', 'assignmentBilling', 'assignmentOutstanding', 'cashRecovery', 'cashFlowtotalspendData', 'cashFlowRecieved', 'teamexceptionalExpenses', 'teamsSalaries', 'teamAllocatedHours', 'timesheetOnClosedAssignment', 'totalNotFilled', 'partnerWiseProfit', 'lossMakingCount', 'billspending15Days', 'totalUpcomingAssignments', 'assignmentprofitandlosses', 'allTickets', 'hrTickets', 'ticketDatas', 'highpriorityAssignments', 'ecqrAudits', 'documentCompletions', 'assignmentOverviews',  'exceptionalExpenses', 'auditsDue', 'tendersSubmittedCount', 'delayedAssignments', 'assignmentcompleted', 'billspendingforcollection', 'billspending'));
    }
  }
   // public function index()
  // {


  //   $mentor_id = DB::table('teammembers')
  //     ->join('users', 'users.teammember_id', 'teammembers.id')
  //     ->where('users.teammember_id', auth()->user()->teammember_id)
  //     ->where('teammembers.status', '!=', 0)
  //     ->pluck('mentor_id')
  //     ->first();

  //   $mentee_id = DB::table('teammembers')
  //     ->join('users', 'users.teammember_id', 'teammembers.id')
  //     ->where('teammembers.mentor_id', auth()->user()->teammember_id)
  //     //->pluck('teammembers.id')
  //     ->where('teammembers.status', '!=', 0)
  //     ->get();

  //   //dd($mentee_id);
  //   $mentor = null;
  //   $mentees = null;

  //   if ($mentor_id != null) {
  //     $mentor = DB::table('teammembers')->where('id', $mentor_id)->where('status', '!=', 0)->first();
  //   }

  //   if (count($mentee_id) != 0) {
  //     $mentees = $mentee_id;
  //   }

  //   // Set $mentees to null (if needed)
  //   if ($mentees == null) {
  //     $mentees = null;
  //   }

  //   $todayBirthdays = Teammember::whereNotNull('dateofbirth')
  //     ->where('status', '1')
  //     ->get()
  //     ->filter(function ($birthday) {
  //       $dateofbirth = Carbon::parse($birthday->dateofbirth);
  //       $currentDate = Carbon::now();

  //       // Compare the month and day without considering the current year
  //       return $dateofbirth->month == $currentDate->month && $dateofbirth->day == $currentDate->day;
  //     })
  //     ->sortBy('dateofbirth');

  //   $upcomingBirthdays = Teammember::where('status', '1')
  //     ->whereRaw('DATE_FORMAT(dateofbirth, "%m-%d") > DATE_FORMAT(NOW(), "%m-%d")')
  //     ->orderByRaw('DATE_FORMAT(dateofbirth, "%m-%d")')
  //     ->limit(7)
  //     ->get();



  //   $workAnniversaries = Teammember::whereNotNull('joining_date')
  //     ->where('status', '1')
  //     ->get()
  //     ->filter(function ($teammember) {
  //       $joiningDate = Carbon::parse($teammember->joining_date);
  //       $currentDate = Carbon::now();

  //       // Compare the month and day without considering the current year
  //       $isAnniversaryToday = $joiningDate->month == $currentDate->month && $joiningDate->day == $currentDate->day;

  //       // Exclude work anniversaries with a duration of 0 years
  //       $isNonZeroAnniversary = $joiningDate->diffInYears($currentDate) > 0;

  //       return $isAnniversaryToday && $isNonZeroAnniversary;
  //     })
  //     ->sortBy('joining_date')
  //     ->take(2);

  //   $upcomingHolidays = Holiday::where('startdate', '>', now()->format('Y-m-d'))
  //     ->where('status', 1)
  //     ->orderBy('startdate', 'asc')
  //     ->take(2)
  //     ->get();

  //   if (auth()->user()->role_id == 11 || auth()->user()->role_id == 12) {
  //     $authidd = Assignmentteammapping::where('teammember_id', auth()->user()->teammember_id)->select('assignmentmapping_id')->pluck('assignmentmapping_id')->first();
  //     $authid = auth()->user()->teammember_id;
  //     $notificationDatas =  DB::table('notifications')
  //       ->join('teammembers', 'teammembers.id', 'notifications.created_by')
  //       ->select(
  //         'notifications.*',
  //         'teammembers.profilepic',
  //         'teammembers.team_member'
  //       )->orderBy('created_at', 'desc')->paginate('2');
  //     // dd($notificationDatas);
  //     $client = Client::count();
  //     $teammember = Teammember::where('status', '1')->where('role_id', '!=', '11')->count();
  //     $userid = auth()->user()->role_id;
  //     $pageid = Permission::where('role_id', $userid)->select('page_id')->pluck('page_id')->first();
  //     $assetticket = DB::table('assettickets')
  //       ->leftjoin('teammembers', 'teammembers.id', 'assettickets.created_by')
  //       ->select('assettickets.*', 'teammembers.team_member')->orderBy('created_at', 'desc')->paginate(2);
  //     $assignment =  DB::table('assignmentbudgetings')
  //       ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
  //       ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
  //       ->select(
  //         'assignmentbudgetings.*',
  //         'clients.client_name',
  //         'assignments.assignment_name'
  //       )->orderBy('assignmentbudgetings.created_at', 'desc')->take(3)->get();
  //     $assignmentcount = Assignmentmapping::count();
  //     $notification = Notification::count();
  //     return view('backEnd.index', compact('mentor', 'mentees', 'notification', 'assignmentcount', 'assignment', 'pageid', 'assetticket', 'client', 'teammember', 'notificationDatas', 'upcomingBirthdays', 'workAnniversaries', 'upcomingHolidays', 'todayBirthdays'));
  //   } elseif (auth()->user()->role_id == 13) {
  //     $authidd = Assignmentteammapping::where('teammember_id', auth()->user()->teammember_id)->select('assignmentmapping_id')->pluck('assignmentmapping_id')->first();
  //     $authid = auth()->user()->teammember_id;
  //     $notificationDatas =    $notificationDatas = DB::table('notifications')
  //       ->leftjoin('teammembers', 'teammembers.id', 'notifications.created_by')
  //       ->Where('targettype', '3')->orWhere('targettype', '2')->orderBy('notifications.id', 'desc')->paginate(2);
  //     //  dd($notificationDatas);
  //     $notification = Notification::count();
  //     $client = Client::count();
  //     $tender = Tender::where('teammember_id', auth()->user()->teammember_id)->count();
  //     $teammember = Teammember::where('status', '1')->count();
  //     $userid = auth()->user()->role_id;
  //     $pageid = Permission::where('role_id', $userid)->select('page_id')->pluck('page_id')->first();
  //     $assetticket = DB::table('assettickets')
  //       ->leftjoin('teammembers', 'teammembers.id', 'assettickets.created_by')->where('assettickets.created_by', auth()->user()->teammember_id)
  //       ->select('assettickets.*', 'teammembers.team_member')->orderBy('created_at', 'desc')->get();
  //     $assignment =  DB::table('assignmentmappings')
  //       ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
  //       ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
  //       ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
  //       ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')

  //       ->select(
  //         'assignmentbudgetings.client_id',
  //         'assignmentbudgetings.assignmentgenerate_id',
  //         'clients.client_name',
  //         'assignments.assignment_name'
  //       )
  //       ->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)->distinct()->take(3)->get();
  //     $assignmentcount = count($assignment);
  //     return view('backEnd.index', compact('tender', 'mentor', 'mentees', 'notification', 'assignmentcount', 'assignment', 'pageid', 'assetticket', 'client', 'teammember', 'notificationDatas', 'upcomingBirthdays', 'workAnniversaries', 'upcomingHolidays', 'todayBirthdays'));
  //   } elseif (auth()->user()->role_id == 16) {
  //     $authidd = Assignmentteammapping::where('teammember_id', auth()->user()->teammember_id)->select('assignmentmapping_id')->pluck('assignmentmapping_id')->first();
  //     $authid = auth()->user()->teammember_id;
  //     $notificationDatas =    $notificationDatas = DB::table('notifications')
  //       //    ->leftjoin('users','users.id','notifications.created_by')
  //       ->leftjoin('teammembers', 'teammembers.id', 'notifications.created_by')
  //       ->Where('targettype', '3')->orWhere('targettype', '2')->orderBy('notifications.id', 'desc')->paginate(2);
  //     //  dd($notificationDatas);
  //     $notification = Notification::count();
  //     $client = Client::count();
  //     $tender = Tender::where('teammember_id', auth()->user()->teammember_id)->count();
  //     $teammember = Teammember::where('status', '1')->count();
  //     $userid = auth()->user()->role_id;
  //     $pageid = Permission::where('role_id', $userid)->select('page_id')->pluck('page_id')->first();
  //     $assetticket = DB::table('assettickets')
  //       ->leftjoin('teammembers', 'teammembers.id', 'assettickets.created_by')
  //       ->select('assettickets.*', 'teammembers.team_member')->orderBy('created_at', 'desc')->get();
  //     $assignment =  DB::table('assignmentmappings')
  //       ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
  //       ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
  //       ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
  //       ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')

  //       ->select(
  //         'assignmentbudgetings.client_id',
  //         'assignmentbudgetings.assignmentgenerate_id',
  //         'clients.client_name',
  //         'assignments.assignment_name'
  //       )
  //       ->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)->distinct()->get();
  //     $assignmentcount = count($assignment);
  //     return view('backEnd.index', compact('tender', 'mentor', 'mentees', 'notification', 'assignmentcount', 'assignment', 'pageid', 'assetticket', 'client', 'teammember', 'notificationDatas', 'upcomingBirthdays', 'workAnniversaries', 'upcomingHolidays', 'todayBirthdays'));
  //   } else {


  //     $status = DB::table('staffappointmentletters')->where('teammember_id', auth()->user()->teammember_id)->orderBy('id', 'DESC')->first();
  //     // dd($status);
  //     // dd($status);
  //     $teammember = DB::table('staffappointmentletters')
  //       ->leftjoin('teammembers', 'teammembers.id', 'staffappointmentletters.teammember_id')
  //       ->where('teammember_id', auth()->user()->teammember_id)
  //       ->select('staffappointmentletters.*', 'teammembers.team_member', 'teammembers.permanentaddress', 'teammembers.communicationaddress', 'teammembers.pancardno', 'teammembers.fathername', 'teammembers.joining_date')->orderBy('staffappointmentletters.id', 'DESC')->first();

  //     /*if($status && $status->e_verify==0 && in_array(auth()->user()->role_id, [16, 17]))
  // 	   {
  // 		//  dd('hi');
  //     return view('backEnd.noappointmentletter');


  //    }
  // 	  elseif($status && $status->e_verify ==1  && $status->otp ==null && in_array(auth()->user()->role_id, [ 16, 17, 18]))
  // 	   { 
  // 		    return view('backEnd.appointmentletter',compact('teammember'));
  // 	  }

  //        else{
  //        */

  //     $authidd = Assignmentteammapping::where('teammember_id', auth()->user()->teammember_id)->select('assignmentmapping_id')->pluck('assignmentmapping_id')->first();
  //     $authid = auth()->user()->teammember_id;
  //     $notificationDatas =   DB::table('notifications')
  //       //  ->leftjoin('users','users.id','notifications.created_by')
  //       ->leftjoin('teammembers', 'teammembers.id', 'notifications.created_by')
  //       ->where('notifications.targettype', '1')
  //       ->select('notifications.*', 'teammembers.team_member', 'teammembers.profilepic')->orWhere('targettype', '2')->orderBy('notifications.id', 'desc')->paginate(2);

  //     //  dd($notificationDatas);
  //     $notification = Notification::count();
  //     $client = Client::count();
  //     $teammember = Teammember::where('status', '1')->count();
  //     $userid = auth()->user()->role_id;
  //     $pageid = Permission::where('role_id', $userid)->select('page_id')->pluck('page_id')->first();
  //     $assetticket = DB::table('assettickets')
  //       ->leftjoin('users', 'users.id', 'assettickets.created_by')
  //       ->leftjoin('teammembers', 'teammembers.id', 'users.teammember_id')->where('assettickets.created_by', auth()->user()->teammember_id)
  //       ->select('assettickets.*', 'teammembers.team_member')->orderBy('created_at', 'desc')->get();
  //     $assignment =  DB::table('assignmentmappings')
  //       ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
  //       ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
  //       ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
  //       ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
  //       ->select(
  //         'assignmentmappings.*',
  //         'clients.client_name',
  //         'assignments.assignment_name'
  //       )->where('assignmentteammappings.teammember_id', $authid)->get();
  //     $assignmentcount = count($assignment);
  //     return view('backEnd.index', compact('notification', 'mentor', 'mentees', 'assignmentcount', 'assignment', 'pageid', 'assetticket', 'client', 'teammember', 'notificationDatas', 'upcomingBirthdays', 'workAnniversaries', 'upcomingHolidays', 'todayBirthdays'));
  //     //  }
  //   }
  // }


  // public function index()
  // {
  //   if (auth()->user()->role_id == 11) {
  //     // How many amounts pending for invoice genrated
  //     $billspending = DB::table('assignmentmappings')
  //       ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
  //       ->leftJoin('invoices', 'invoices.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
  //       ->whereNull('invoices.assignmentgenerate_id')
  //       ->where('assignmentbudgetings.status', 0)
  //       ->sum('assignmentmappings.engagementfee');


  //     $billspendingforcollection = DB::table('assignmentmappings')
  //       ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
  //       ->leftJoin('invoices', 'invoices.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
  //       ->leftJoin('outstandings', 'outstandings.BILL_NO', '=', 'invoices.invoice_id')
  //       // ensures invoice is created
  //       ->whereNotNull('invoices.id')
  //       ->where('assignmentbudgetings.status', 0)
  //       ->sum('outstandings.AMT');
  //     // ->get();

  //     // dd($billspendingforcollection);

  //     // How many assignments completed in this months
  //     $assignmentcompleted = DB::table('assignmentmappings')
  //       ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
  //       // ->where('assignmentbudgetings.status', 0)
  //       ->whereMonth('assignmentbudgetings.otpverifydate', Carbon::now()->month)
  //       ->whereYear('assignmentbudgetings.otpverifydate', Carbon::now()->year)
  //       ->count();

  //     // How many delayed Assignments
  //     $delayedAssignments = DB::table('assignmentmappings')
  //       ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
  //       // ->where('assignmentbudgetings.status', 1)
  //       ->whereRaw('COALESCE(DATE(assignmentbudgetings.actualenddate), DATE(assignmentbudgetings.tentativeenddate)) < ?', [Carbon::today()->toDateString()])
  //       ->count();

  //     // How many tender submitted this months
  //     $tendersSubmittedCount = DB::table('tenders')
  //       ->where('tendersubmitstatus', 1)
  //       ->whereMonth('date', Carbon::now()->month)
  //       ->whereYear('date', Carbon::now()->year)
  //       ->count();

  //     // How many NAFRA are running
  //     $auditsDue = DB::table('assignmentmappings')
  //       ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
  //       ->where('assignmentbudgetings.status', 1)
  //       ->where('assignmentmappings.eqcrapplicability', 1)
  //       ->count();

  //     // total amount of convence, how many amount approved for convence in this months or Exceptional Expenses 
  //     $exceptionalExpenses = DB::table('outstationconveyances')
  //       ->where('status', 6)
  //       ->whereMonth('approveddate', Carbon::now()->month)
  //       ->whereYear('approveddate', Carbon::now()->year)
  //       ->sum('finalamount');

  //     // how many users not accepted independance mail till now
  //     $totalNotFilled = DB::table('assignmentmappings')
  //       ->select(DB::raw('COUNT(*) as total_not_filled'))
  //       ->leftJoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
  //       ->leftJoin('teammembers', 'teammembers.id', '=', 'assignmentteammappings.teammember_id')
  //       ->leftJoin('annual_independence_declarations', function ($join) {
  //         $join->on('annual_independence_declarations.assignmentgenerateid', '=', 'assignmentmappings.assignmentgenerate_id')
  //           ->on('annual_independence_declarations.createdby', '=', 'teammembers.id')
  //           ->where('annual_independence_declarations.type', 2);
  //       })
  //       ->whereNull('annual_independence_declarations.id') // Members without declarations
  //       ->groupBy('assignmentmappings.assignmentgenerate_id')
  //       ->get()
  //       ->sum('total_not_filled');

  //     // Assignment Status Overview
  //     $assignmentOverviews = DB::table('assignmentmappings')
  //       ->select(
  //         'assignmentmappings.*',
  //         'assignmentbudgetings.assignmentname',
  //         'assignmentbudgetings.status',
  //         DB::raw('COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate) as finalassignmentenddate'),
  //         'clients.client_name',
  //         DB::raw('(SELECT SUM(totalhour) FROM timesheetusers WHERE timesheetusers.assignmentgenerate_id = assignmentmappings.assignmentgenerate_id) as workedHours')
  //       )
  //       ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
  //       ->leftJoin('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
  //       ->orderByDesc('assignmentbudgetings.id')
  //       ->limit(3)
  //       ->get()
  //       ->map(function ($assignmentOverview) {
  //         $totalHours = $assignmentOverview->esthours ?? 0;
  //         $workedHours = $assignmentOverview->workedHours ?? 0;
  //         $completionPercentage = $totalHours > 0 ? round(($workedHours / $totalHours) * 100, 2) : 0;
  //         $assignmentOverview->completionPercentage = $completionPercentage;
  //         return $assignmentOverview;
  //       });


  //     // Document Completion Progress
  //     $documentCompletions = DB::table('assignmentmappings')
  //       ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
  //       ->leftJoin('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
  //       // ->where('assignmentbudgetings.status', 1)
  //       ->orderByDesc('assignmentbudgetings.id')
  //       ->select(
  //         'assignmentmappings.*',
  //         'assignmentbudgetings.assignmentname',
  //         'clients.client_name'
  //       )
  //       ->limit(6)
  //       ->get();

  //     foreach ($documentCompletions as $mapping) {
  //       $assignmentId = $mapping->assignmentgenerate_id;

  //       // Get assignment_id and eqcrapplicability
  //       $assignmentMapping = DB::table('assignmentmappings')
  //         ->where('assignmentgenerate_id', $assignmentId)
  //         ->select('assignment_id', 'eqcrapplicability')
  //         ->first();

  //       // Determine EQCR type name
  //       $eqcrTypeName = '';
  //       $eqcrAssignmentId = null;
  //       if (isset($assignmentMapping->eqcrapplicability)) {
  //         switch ($assignmentMapping->eqcrapplicability) {
  //           case 1:
  //             $eqcrTypeName = 'NFRA';
  //             break;
  //           case 2:
  //             $eqcrTypeName = 'Quality Review';
  //             break;
  //           case 3:
  //             $eqcrTypeName = 'Peer Review';
  //             break;
  //           case 4:
  //             $eqcrTypeName = 'Others';
  //             break;
  //           case 5:
  //             $eqcrTypeName = 'PCAOB';
  //             break;
  //         }
  //         // Get the assignment_id for the EQCR type
  //         $specialAssignment = DB::table('assignments')
  //           ->where('assignment_name', $eqcrTypeName)
  //           ->first();
  //         if ($specialAssignment) {
  //           $eqcrAssignmentId = $specialAssignment->id;
  //         }
  //       }
  //       $mapping->eqcr_type_name = $eqcrTypeName;

  //       // Regular Checklist Calculations (Exclude EQCR assignment_id)
  //       $classificationIds = DB::table('financialstatementclassifications')
  //         ->where('assignment_id', $assignmentMapping->assignment_id)
  //         ->where(function ($q) use ($assignmentId) {
  //           $q->whereNull('assignmentgenerate_id')->orWhere('assignmentgenerate_id', $assignmentId);
  //         })
  //         ->when($eqcrAssignmentId, function ($query) use ($eqcrAssignmentId) {
  //           $query->where('assignment_id', '!=', $eqcrAssignmentId);
  //         })
  //         ->pluck('id');



  //       $subClassIds = DB::table('subfinancialclassfications')
  //         ->whereIn('financialstatemantclassfication_id', $classificationIds)
  //         ->pluck('id');



  //       $totalQuestions = DB::table('auditquestions')
  //         ->whereIn('financialstatemantclassfication_id', $classificationIds)
  //         ->whereIn('subclassfied_id', $subClassIds)
  //         ->count();


  //       $statusCounts = DB::table('checklistanswers')
  //         ->join('statuses', 'checklistanswers.status', '=', 'statuses.id')
  //         ->where('checklistanswers.assignment_id', $assignmentId)
  //         ->whereIn('checklistanswers.financialstatemantclassfication_id', $classificationIds)
  //         ->whereIn('checklistanswers.subclassfied_id', $subClassIds)
  //         ->select(
  //           'statuses.name as status_name',
  //           DB::raw('COUNT(*) as count')
  //         )
  //         ->groupBy('statuses.name')
  //         ->pluck('count', 'status_name');



  //       $closedQuestions = $statusCounts['CLOSE'] ?? 0;

  //       $mapping->documentation_percentage = $totalQuestions > 0
  //         ? round(($closedQuestions / $totalQuestions) * 100, 2)
  //         : 0;
  //     }
  //     // Document Completion Progress end hare 


  //     // ECQR Audits & Quality Reviews
  //     $ecqrAudits = DB::table('assignmentmappings')
  //       ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
  //       ->leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.eqcrpartner')
  //       ->leftJoin('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
  //       // ->where('assignmentbudgetings.status', 1)
  //       ->whereIn('assignmentmappings.eqcrapplicability', [1, 2])
  //       ->select(
  //         'assignmentmappings.*',
  //         'teammembers.team_member',
  //         'assignmentbudgetings.assignmentname',
  //         'assignmentbudgetings.status',
  //         DB::raw('COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate) as finalassignmentenddate'),
  //         'clients.client_name'
  //       )
  //       ->limit(3)
  //       ->get();


  //     // High Priority Tasks Pending
  //     $highpriorityAssignments  = DB::table('assignmentmappings')
  //       ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
  //       ->leftJoin('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
  //       ->select(
  //         'assignmentmappings.*',
  //         'assignmentbudgetings.assignmentname',
  //         DB::raw('COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate) as finalassignmentenddate'),
  //         'clients.client_name'
  //       )
  //       ->limit(6)
  //       ->get();


  //     // Fetch IT and Finance Tickets
  //     $ticketDatas = Assetticket::with(['financerequest', 'createdBy', 'partner'])
  //       ->whereIn('type', [0, 1])
  //       ->orderByDesc('id')
  //       ->limit(4)
  //       ->get()
  //       ->map(function ($item) {
  //         return [
  //           'ticket_id' => $item->generateticket_id,
  //           'department' => $item->type == 0 ? 'IT' : 'Finance',
  //           'created_by' => $item->createdBy->team_member ?? '',
  //           'subject' => $item->subject,
  //           'assigned_to' => $item->partner->team_member ?? '',
  //           'created_at' => $item->created_at,
  //           'status' => $item->status,
  //           'source' => 'ticket',
  //         ];
  //       });

  //     // Fetch HR Tasks
  //     $hrTickets = DB::table('tasks')
  //       ->select(
  //         'tasks.*',
  //         'patnerid.team_member as partnername',
  //         'createdby.team_member as createdbyname',
  //         'hrfunctions.hrfunction'
  //       )
  //       ->where('tasks.task_type', 4)
  //       ->leftJoin('teammembers as patnerid', 'patnerid.id', '=', 'tasks.partner_id')
  //       ->leftJoin('teammembers as createdby', 'createdby.id', '=', 'tasks.createdby')
  //       ->leftJoin('hrfunctions', 'hrfunctions.id', '=', 'tasks.hrfunction')
  //       ->orderByDesc('tasks.id')
  //       ->limit(4)
  //       ->get()
  //       ->map(function ($item) {
  //         return [
  //           'ticket_id' => 'N/A',
  //           'department' => 'HR',
  //           'created_by' => $item->createdbyname ?? '',
  //           'subject' => $item->taskname ?? '',
  //           'assigned_to' => $item->partnername ?? '',
  //           'created_at' => $item->created_at,
  //           'status' => $item->status,
  //           'source' => 'hr',
  //         ];
  //       });

  //     $allTickets = $ticketDatas->merge($hrTickets);

  //     // Assignment-wise P&L Analysis and Loss Making Assignments
  //     $assignmentCosts = DB::table('timesheetusers')
  //       ->leftJoin('teammembers', 'teammembers.id', '=', 'timesheetusers.createdby')
  //       // ->where('timesheetusers.assignmentgenerate_id', 254418551033)
  //       ->select('timesheetusers.assignmentgenerate_id', DB::raw('SUM(timesheetusers.totalhour * teammembers.cost_hour) as total_cost'))
  //       ->groupBy('timesheetusers.assignmentgenerate_id')
  //       ->pluck('total_cost', 'assignmentgenerate_id');

  //     $assignmentprofitandlosses = DB::table('assignmentmappings')
  //       ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
  //       ->leftJoin('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
  //       ->orderByDesc('assignmentbudgetings.id')
  //       ->select(
  //         'assignmentmappings.*',
  //         'assignmentbudgetings.assignmentname',
  //         'assignmentbudgetings.status',
  //         DB::raw('COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate) as finalassignmentenddate'),
  //         'clients.client_name'
  //       )
  //       ->limit(6)
  //       ->get();

  //     $lossMakingCount = 0;
  //     foreach ($assignmentprofitandlosses as $assignment) {
  //       $assignment->total_cost = $assignmentCosts[$assignment->assignmentgenerate_id] ?? 0;

  //       // Loss Making Assignments
  //       $revenue = $assignment->engagementfee ?? 0;
  //       $cost = $assignment->total_cost ?? 0;
  //       $profit = $revenue - $cost;

  //       if ($profit < 0) {
  //         $lossMakingCount++;
  //       }
  //     }

  //     // Upcoming Assignments
  //     $upcomingFromPlannings  = DB::table('assignmentplannings')
  //       ->whereDate('assignmentstartdate', '>', Carbon::today())
  //       ->count();

  //     $upcomingFromBudgetings = DB::table('assignmentbudgetings')
  //       ->whereRaw('COALESCE(actualstartdate, tentativestartdate) > ?', [Carbon::today()->toDateString()])
  //       ->count();

  //     $totalUpcomingAssignments = $upcomingFromPlannings + $upcomingFromBudgetings;


  //     // How many amounts pending for collection within 15 days
  //     $billspending15Days = DB::table('assignmentmappings')
  //       ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
  //       ->leftJoin('invoices', 'invoices.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
  //       ->leftJoin('payments', 'payments.invoiceid', '=', 'invoices.invoice_id')
  //       ->whereNotNull('invoices.id') // Invoice is created
  //       ->whereNull('payments.invoiceid') // Payment not yet received
  //       ->whereDate('invoices.created_at', '>=', Carbon::today()->subDays(15)) // Only within last 15 days
  //       ->sum('invoices.total');
  //     // ->select(
  //     //   'assignmentmappings.*',
  //     // )
  //     // ->get();

  //     // Timesheet Filled On Closed Assignment
  //     $timesheetOnClosedAssignment = DB::table('assignmentmappings')
  //       ->join('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
  //       ->join('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
  //       ->whereExists(function ($query) {
  //         $query->select(DB::raw(1))
  //           ->from('timesheetusers')
  //           ->whereRaw('timesheetusers.assignmentgenerate_id = assignmentmappings.assignmentgenerate_id')
  //           ->whereRaw("DATE(timesheetusers.created_at) > DATE(COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate))");
  //       })
  //       ->select('assignmentmappings.assignmentgenerate_id')
  //       ->distinct()
  //       ->count();


  //     // Partner-wise P&L Statement
  //     // $currentDate = Carbon::now();
  //     $todayDate = Carbon::parse('2024-07-01');
  //     $financialStartdate = $todayDate->month >= 4 ? Carbon::create($todayDate->year, 4, 1) : Carbon::create($todayDate->year - 1, 4, 1);
  //     $financialEnddate = $financialStartdate->copy()->addYear()->subDay();

  //     $assignmentGenerateIds = DB::table('assignmentbudgetings')
  //       ->whereBetween('periodstartdate', [$financialStartdate, $financialEnddate])
  //       ->whereBetween('periodenddate', [$financialStartdate, $financialEnddate])
  //       ->pluck('assignmentgenerate_id');

  //     $invoices = DB::table('invoices')
  //       ->select(
  //         'invoices.assignmentgenerate_id',
  //         'teammembers.team_member',
  //         DB::raw('SUM(invoices.total) as total')
  //       )
  //       ->join('teammembers', 'teammembers.id', '=', 'invoices.partner')
  //       ->whereIn('invoices.assignmentgenerate_id', $assignmentGenerateIds)
  //       ->groupBy('invoices.assignmentgenerate_id', 'teammembers.team_member')
  //       ->get();

  //     $timesheetData = DB::table('timesheetusers')
  //       ->select('assignmentgenerate_id', 'createdby', DB::raw('SUM(totalhour) as total_hour'))
  //       ->whereIn('assignmentgenerate_id', $assignmentGenerateIds)
  //       ->groupBy('assignmentgenerate_id', 'createdby')
  //       ->get();

  //     $teamMemberCosts = DB::table('teammembers')
  //       ->whereIn('id', $timesheetData->pluck('createdby')->unique())
  //       ->pluck('cost_hour', 'id');

  //     $groupedCosts = $timesheetData->groupBy('assignmentgenerate_id')->map(function ($rows) use ($teamMemberCosts) {
  //       return $rows->sum(function ($row) use ($teamMemberCosts) {
  //         return $row->total_hour * ($teamMemberCosts[$row->createdby] ?? 0);
  //       });
  //     });

  //     $finalData = $invoices->map(function ($row) use ($groupedCosts) {
  //       $row->cost = $groupedCosts[$row->assignmentgenerate_id] ?? 0;
  //       $row->profit_loss = $row->total - $row->cost;
  //       return $row;
  //     });

  //     $partnerWiseProfit = $finalData
  //       ->groupBy('team_member')
  //       ->map(function ($items, $teamMember) {
  //         return (object)[
  //           'team_member' => $teamMember,
  //           'total' => $items->sum(fn($item) => (float) $item->total),
  //           'cost' => $items->sum('cost'),
  //           'profit_loss' => $items->sum('profit_loss'),
  //         ];
  //       })
  //       // Reset index if needed
  //       ->values();
  //     // Partner-wise P&L Statement end hare


  //     // Staff Allocation vs Actual Timesheet Analysis
  //     $teamAllocatedHours = DB::table('assignmentteammappings')
  //       ->join('teammembers', 'teammembers.id', '=', 'assignmentteammappings.teammember_id')
  //       // ->where('assignmentteammappings.teammember_id', 815)
  //       ->select(
  //         'assignmentteammappings.teammember_id',
  //         'teammembers.team_member',
  //         DB::raw('SUM(assignmentteammappings.teamesthour) as teamallocatedhours')
  //       )
  //       ->groupBy('assignmentteammappings.teammember_id', 'teammembers.team_member')
  //       ->limit(6)
  //       ->get();

  //     foreach ($teamAllocatedHours as $teamAllocatedHour) {

  //       $actualHours = DB::table('timesheetusers')
  //         ->where('createdby', $teamAllocatedHour->teammember_id)
  //         ->sum('totalhour');

  //       if (is_null($teamAllocatedHour->teamallocatedhours)) {
  //         $teamAllocatedHour->teamallocatedhours = 0;
  //       }
  //       $teamAllocatedHour->actualhours = $actualHours;
  //       // $discrepancy = (float) $teamAllocatedHour->teamallocatedhours - $actualHours;
  //       $discrepancy = $actualHours - (float) $teamAllocatedHour->teamallocatedhours;
  //       $teamAllocatedHour->discrepancy = $discrepancy;
  //     }

  //     // Monthly Expense Analysis
  //     // financial year
  //     $financialStartYear = now()->month >= 4 ? now()->year : now()->year - 1;
  //     $financialEndYear = $financialStartYear + 1;
  //     $monthNames = [1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June'];


  //     $teamsSalaries = DB::table('employeepayrolls')
  //       ->select(
  //         'month',
  //         'year',
  //         DB::raw('SUM(total_amount_to_paid) as total_amount')
  //       )
  //       ->where(function ($query) use ($financialEndYear, $financialStartYear) {
  //         // Jan to Mar from next year
  //         $query->where(function ($q) use ($financialEndYear) {
  //           $q->where('year', $financialEndYear)
  //             ->whereIn('month', ['January', 'February', 'March']);
  //         })
  //           // Apr to Jun from current year
  //           ->orWhere(function ($q) use ($financialStartYear) {
  //             $q->where('year', $financialStartYear)
  //               ->whereIn('month', ['April', 'May', 'June']);
  //           });
  //       })
  //       ->where('send_to_bank', 1)
  //       ->groupBy('year', 'month')
  //       ->orderByRaw("FIELD(month, 'January', 'February', 'March', 'April', 'May', 'June')")
  //       ->get();




  //     $teamexceptionalExpenses = DB::table('outstationconveyances')
  //       ->selectRaw('MONTH(approveddate) as month, YEAR(approveddate) as year, SUM(finalamount) as total_amount')
  //       ->where('status', 6)
  //       ->where(function ($query) use ($financialEndYear, $financialStartYear) {
  //         // Jan to Mar from next year
  //         $query->where(function ($q) use ($financialEndYear) {
  //           $q->whereYear('approveddate', $financialEndYear)
  //             ->whereIn(DB::raw('MONTH(approveddate)'), [1, 2, 3]);
  //         })
  //           // Apr to Jun from current year
  //           ->orWhere(function ($q) use ($financialStartYear) {
  //             $q->whereYear('approveddate', $financialStartYear)
  //               ->whereIn(DB::raw('MONTH(approveddate)'), [4, 5, 6]);
  //           });
  //       })
  //       ->groupByRaw('MONTH(approveddate), YEAR(approveddate)')
  //       ->orderByRaw('FIELD(MONTH(approveddate), 1, 2, 3, 4, 5, 6)')
  //       ->get()
  //       ->map(function ($item) use ($monthNames) {
  //         $item->month = $monthNames[$item->month] ?? $item->month;
  //         return $item;
  //       });


  //     // Cash Flow Analysis
  //     $cashFlowRecieved = DB::table('payments')
  //       ->selectRaw('MONTH(paymentdate) as month, YEAR(paymentdate) as year, SUM(amountreceived) as amountreceived')
  //       ->where(function ($query) use ($financialEndYear, $financialStartYear) {
  //         // Jan to Mar from next year
  //         $query->where(function ($q) use ($financialEndYear) {
  //           $q->whereYear('paymentdate', $financialEndYear)
  //             ->whereIn(DB::raw('MONTH(paymentdate)'), [1, 2, 3]);
  //         })
  //           // Apr to Jun from current year
  //           ->orWhere(function ($q) use ($financialStartYear) {
  //             $q->whereYear('paymentdate', $financialStartYear)
  //               ->whereIn(DB::raw('MONTH(paymentdate)'), [4, 5, 6]);
  //           });
  //       })
  //       ->groupByRaw('MONTH(paymentdate), YEAR(paymentdate)')
  //       ->orderByRaw('FIELD(MONTH(paymentdate), 1, 2, 3, 4, 5, 6)')
  //       ->get()
  //       ->map(function ($item) use ($monthNames) {
  //         $item->month = $monthNames[$item->month] ?? $item->month;
  //         return $item;
  //       });

  //     $cashFlowSpendvender = DB::table('vendorlist')
  //       ->selectRaw('MONTH(approvedate) as month, YEAR(approvedate) as year, SUM(amount) as total_amounts')
  //       ->where('status', 4)
  //       ->where(function ($query) use ($financialEndYear, $financialStartYear) {
  //         $query->where(function ($q) use ($financialEndYear) {
  //           $q->whereYear('approvedate', $financialEndYear)
  //             ->whereIn(DB::raw('MONTH(approvedate)'), [1, 2, 3]);
  //         })->orWhere(function ($q) use ($financialStartYear) {
  //           $q->whereYear('approvedate', $financialStartYear)
  //             ->whereIn(DB::raw('MONTH(approvedate)'), [4, 5, 6]);
  //         });
  //       })
  //       ->groupByRaw('MONTH(approvedate), YEAR(approvedate)')
  //       ->orderByRaw('FIELD(MONTH(approvedate), 1,2,3,4,5,6)')
  //       ->get()
  //       ->map(function ($item) use ($monthNames) {
  //         $item->month = $monthNames[$item->month] ?? $item->month;
  //         return $item;
  //       });

  //     $cashFlowSpendemployee = DB::table('employeepayrolls')
  //       ->select('month', 'year', DB::raw('SUM(total_amount_to_paid) as total_amounts'))
  //       ->where(function ($query) use ($financialEndYear, $financialStartYear) {
  //         $query->where(function ($q) use ($financialEndYear) {
  //           $q->where('year', $financialEndYear)
  //             ->whereIn('month', ['January', 'February', 'March']);
  //         })->orWhere(function ($q) use ($financialStartYear) {
  //           $q->where('year', $financialStartYear)
  //             ->whereIn('month', ['April', 'May', 'June']);
  //         });
  //       })
  //       ->where('send_to_bank', 1)
  //       ->groupBy('year', 'month')
  //       ->orderByRaw("FIELD(month, 'January', 'February', 'March', 'April', 'May', 'June')")
  //       ->get();


  //     $mergedSpenddata = $cashFlowSpendvender->merge($cashFlowSpendemployee);

  //     $cashFlowtotalspendData = $mergedSpenddata->groupBy(function ($item) {
  //       return $item->month . '-' . $item->year;
  //     })->map(function ($group) {
  //       return (object) [
  //         'month' => $group->first()->month,
  //         'year' => $group->first()->year,
  //         'total_amounts' => $group->sum('total_amounts'),
  //       ];
  //     })->sortBy(function ($item) {
  //       $order = ['January', 'February', 'March', 'April', 'May', 'June'];
  //       return array_search($item->month, $order);
  //     })->values();

  //     // Cash Flow Analysis end hare
  //     $assignmentBilling = DB::table('invoices')
  //       ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, SUM(total) as invoices_amount')
  //       ->where(function ($query) use ($financialEndYear, $financialStartYear) {
  //         // Jan to Mar from next year
  //         $query->where(function ($q) use ($financialEndYear) {
  //           $q->whereYear('created_at', $financialEndYear)
  //             ->whereIn(DB::raw('MONTH(created_at)'), [1, 2, 3]);
  //         })
  //           // Apr to Jun from current year
  //           ->orWhere(function ($q) use ($financialStartYear) {
  //             $q->whereYear('created_at', $financialStartYear)
  //               ->whereIn(DB::raw('MONTH(created_at)'), [4, 5, 6]);
  //           });
  //       })
  //       ->groupByRaw('MONTH(created_at), YEAR(created_at)')
  //       ->orderByRaw('FIELD(MONTH(created_at), 1, 2, 3, 4, 5, 6)')
  //       ->get()
  //       ->map(function ($item) use ($monthNames) {
  //         $item->month = $monthNames[$item->month] ?? $item->month;
  //         return $item;
  //       });

  //     $assignmentOutstanding = DB::table('outstandings')
  //       ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, SUM(AMT) as outstanding_amount')
  //       ->where(function ($query) use ($financialEndYear, $financialStartYear) {
  //         // Jan to Mar from next year
  //         $query->where(function ($q) use ($financialEndYear) {
  //           $q->whereYear('created_at', $financialEndYear)
  //             ->whereIn(DB::raw('MONTH(created_at)'), [1, 2, 3]);
  //         })
  //           // Apr to Jun from current year
  //           ->orWhere(function ($q) use ($financialStartYear) {
  //             $q->whereYear('created_at', $financialStartYear)
  //               ->whereIn(DB::raw('MONTH(created_at)'), [4, 5, 6]);
  //           });
  //       })
  //       ->groupByRaw('MONTH(created_at), YEAR(created_at)')
  //       ->orderByRaw('FIELD(MONTH(created_at), 1, 2, 3, 4, 5, 6)')
  //       ->get()
  //       ->map(function ($item) use ($monthNames) {
  //         $item->month = $monthNames[$item->month] ?? $item->month;
  //         return $item;
  //       });

  //     $cashRecovery = DB::table('payments')
  //       ->selectRaw('MONTH(paymentdate) as month, YEAR(paymentdate) as year, SUM(amountreceived) as amountreceived')
  //       ->where(function ($query) use ($financialEndYear, $financialStartYear) {
  //         // Jan to Mar from next year
  //         $query->where(function ($q) use ($financialEndYear) {
  //           $q->whereYear('paymentdate', $financialEndYear)
  //             ->whereIn(DB::raw('MONTH(paymentdate)'), [1, 2, 3]);
  //         })
  //           // Apr to Jun from current year
  //           ->orWhere(function ($q) use ($financialStartYear) {
  //             $q->whereYear('paymentdate', $financialStartYear)
  //               ->whereIn(DB::raw('MONTH(paymentdate)'), [4, 5, 6]);
  //           });
  //       })
  //       ->groupByRaw('MONTH(paymentdate), YEAR(paymentdate)')
  //       ->orderByRaw('FIELD(MONTH(paymentdate), 1, 2, 3, 4, 5, 6)')
  //       ->get()
  //       ->map(function ($item) use ($monthNames) {
  //         $item->month = $monthNames[$item->month] ?? $item->month;
  //         return $item;
  //       });

  //     // Lap Days Analysis (Assignment to Invoice)
  //     $assignmentsWithInvoices = DB::table('assignmentmappings')
  //       ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
  //       // get only those assignments for which an invoice has been created
  //       ->join('invoices', 'invoices.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
  //       ->selectRaw('MONTH(assignmentbudgetings.otpverifydate) as month, YEAR(assignmentbudgetings.otpverifydate) as year, assignmentbudgetings.otpverifydate, invoices.created_at as invoice_created_at, invoices.id as invoice_id')
  //       ->where(function ($query) use ($financialStartYear, $financialEndYear) {
  //         // Jan to Mar from next year
  //         $query->where(function ($q) use ($financialEndYear) {
  //           $q->whereYear('assignmentbudgetings.otpverifydate', $financialEndYear)
  //             ->whereIn(DB::raw('MONTH(assignmentbudgetings.otpverifydate)'), [1, 2, 3]);
  //         })->orWhere(function ($q) use ($financialStartYear) {
  //           // Apr to Jun from current year
  //           $q->whereYear('assignmentbudgetings.otpverifydate', $financialStartYear)
  //             ->whereIn(DB::raw('MONTH(assignmentbudgetings.otpverifydate)'), [4, 5, 6]);
  //         });
  //       })
  //       ->orderByRaw('FIELD(MONTH(assignmentbudgetings.otpverifydate), 1,2,3,4,5,6)')
  //       ->get()
  //       ->map(function ($item) use ($monthNames) {
  //         $assignmentclosedDate = Carbon::parse($item->otpverifydate);
  //         $invoicecreatedDate = Carbon::parse($item->invoice_created_at);
  //         $item->differenceDays = $assignmentclosedDate->diffInDays($invoicecreatedDate);
  //         $item->targetDays = 7;
  //         $item->month = $monthNames[$item->month] ?? $item->month;
  //         return $item;
  //       })
  //       ->groupBy(fn($item) => $item->month . '-' . $item->year)
  //       ->map(function ($group) {
  //         $first = $group->first();
  //         return (object) [
  //           'month' => $first->month,
  //           'year' => $first->year,
  //           'otpverifydate' => $first->otpverifydate,
  //           'invoice_id' => $first->invoice_id,
  //           'invoice_created_at' => $first->invoice_created_at,
  //           'targetDays' => $first->targetDays,
  //           'differenceDays' => $group->sum('differenceDays'),
  //           'countitem' => $group->count(),
  //           // Average Difference Days = (sum of all differenceDays) / number of records
  //           'averageDifferenceDays' => round($group->avg('differenceDays'), 1),
  //         ];
  //       })
  //       ->sortBy(fn($item) => array_search($item->month, array_values($monthNames)))
  //       ->values();

  //     // Budget vs Actual P&L
  //     $budgetRevenueandbudgetExpences = DB::table('assignmentmappings')
  //       ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, SUM(engagementfee) as engagementfee, SUM(teamestcost) as total_teamestcost')
  //       ->where(function ($query) use ($financialEndYear, $financialStartYear) {
  //         // Jan to Mar from next year
  //         $query->where(function ($q) use ($financialEndYear) {
  //           $q->whereYear('created_at', $financialEndYear)
  //             ->whereIn(DB::raw('MONTH(created_at)'), [1, 2, 3]);
  //         })
  //           // Apr to Jun from current year
  //           ->orWhere(function ($q) use ($financialStartYear) {
  //             $q->whereYear('created_at', $financialStartYear)
  //               ->whereIn(DB::raw('MONTH(created_at)'), [4, 5, 6]);
  //           });
  //       })
  //       ->groupByRaw('MONTH(created_at), YEAR(created_at)')
  //       ->orderByRaw('FIELD(MONTH(created_at), 1, 2, 3, 4, 5, 6)')
  //       ->get()
  //       ->map(function ($item) use ($monthNames) {
  //         $item->month = $monthNames[$item->month] ?? $item->month;
  //         return $item;
  //       });

  //     $budgetActualRevenue = DB::table('invoices')
  //       ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, SUM(total) as invoices_amount')
  //       ->where(function ($query) use ($financialEndYear, $financialStartYear) {
  //         // Jan to Mar from next year
  //         $query->where(function ($q) use ($financialEndYear) {
  //           $q->whereYear('created_at', $financialEndYear)
  //             ->whereIn(DB::raw('MONTH(created_at)'), [1, 2, 3]);
  //         })
  //           // Apr to Jun from current year
  //           ->orWhere(function ($q) use ($financialStartYear) {
  //             $q->whereYear('created_at', $financialStartYear)
  //               ->whereIn(DB::raw('MONTH(created_at)'), [4, 5, 6]);
  //           });
  //       })
  //       ->groupByRaw('MONTH(created_at), YEAR(created_at)')
  //       ->orderByRaw('FIELD(MONTH(created_at), 1, 2, 3, 4, 5, 6)')
  //       ->get()
  //       ->map(function ($item) use ($monthNames) {
  //         $item->month = $monthNames[$item->month] ?? $item->month;
  //         return $item;
  //       });



  //     $budgetActualExpences = DB::table('timesheets')
  //       ->leftJoin('timesheetusers', 'timesheetusers.timesheetid', '=', 'timesheets.id')
  //       ->leftJoin('teammembers', 'teammembers.id', '=', 'timesheetusers.createdby')
  //       ->whereIn('timesheets.created_by', [815, 818])
  //       ->selectRaw('MONTH(timesheets.date) as month, YEAR(timesheets.date) as year, SUM(timesheetusers.totalhour * teammembers.cost_hour) as total_cost')
  //       ->where(function ($query) use ($financialStartYear, $financialEndYear) {
  //         $query->where(function ($q) use ($financialEndYear) {
  //           $q->whereYear('timesheets.date', $financialEndYear)
  //             ->whereIn(DB::raw('MONTH(timesheets.date)'), [1, 2, 3]); // Jan-Mar
  //         })->orWhere(function ($q) use ($financialStartYear) {
  //           $q->whereYear('timesheets.date', $financialStartYear)
  //             ->whereIn(DB::raw('MONTH(timesheets.date)'), [4, 5, 6]); // Apr-Jun
  //         });
  //       })
  //       ->groupByRaw('MONTH(timesheets.date), YEAR(timesheets.date)')
  //       ->get()
  //       ->map(function ($item) use ($monthNames) {
  //         $item->month = $monthNames[$item->month] ?? $item->month;
  //         return $item;
  //       });

  //     // dd([
  //     //   'budgetRevenueandbudgetExpences' => $budgetRevenueandbudgetExpences,
  //     //   'budgetActualRevenue' => $budgetActualRevenue,
  //     //   'budgetActualExpences' => $budgetActualExpences,
  //     // ]);

  //     // Budget vs Actual P&L


  //     // 'totalNotFilled',
  //     return view('backEnd.kgsdashboardreport', compact('budgetRevenueandbudgetExpences', 'budgetActualRevenue', 'budgetActualExpences', 'assignmentsWithInvoices', 'assignmentBilling', 'assignmentOutstanding', 'cashRecovery', 'cashFlowtotalspendData', 'cashFlowRecieved', 'teamexceptionalExpenses', 'teamsSalaries', 'teamAllocatedHours', 'timesheetOnClosedAssignment', 'totalNotFilled', 'partnerWiseProfit', 'lossMakingCount', 'billspending15Days', 'totalUpcomingAssignments', 'assignmentprofitandlosses', 'allTickets', 'hrTickets', 'ticketDatas', 'highpriorityAssignments', 'ecqrAudits', 'documentCompletions', 'assignmentOverviews',  'exceptionalExpenses', 'auditsDue', 'tendersSubmittedCount', 'delayedAssignments', 'assignmentcompleted', 'billspendingforcollection', 'billspending'));
  //   }
  // }




    $outstandingBills = DB::table('assignmentmappings')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->leftJoin('invoices', 'invoices.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->leftJoin('outstandings', 'outstandings.BILL_NO', '=', 'invoices.invoice_id')
        ->whereNotNull('invoices.id')
        ->where('assignmentbudgetings.status', 0)
        ->whereIn('invoices.currency', [1, 3])
        ->select(
          'invoices.currency',
          DB::raw("DATE_FORMAT(outstandings.created_at, '%Y-%m-%d') as outstandings_date"),
          DB::raw('SUM(outstandings.AMT) as total_amount')
        )
        ->groupBy('invoices.currency', 'outstandings_date')
        ->get();


      $totalamountInr = 0;
      $totalUsdamount = 0;

      // dd($outstandingBills);
      foreach ($outstandingBills as $bill) {

        if ($bill->currency == 3) {
          // INR amount added
          $totalamountInr += $bill->total_amount;
        } elseif ($bill->currency == 1) {
          // Get USD rate for that bill date
          $response = Http::get("https://api.frankfurter.app/{$bill->outstandings_date}", [
            'from' => 'USD',
            'to' => 'INR'
          ]);

          $rate = $response->successful()
            ? ($response->json()['rates']['INR'] ?? 0)
            : 0;
          // dd($rate);
          $totalUsdamount += $bill->total_amount * $rate;
        }
      }

      $billspendingforcollection = round($totalamountInr + $totalUsdamount, 2);
      // Bills Pending For Collection end hare

    $outstandingBills = DB::table('assignmentmappings')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->leftJoin('invoices', 'invoices.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->leftJoin('outstandings', 'outstandings.BILL_NO', '=', 'invoices.invoice_id')
        ->whereNotNull('invoices.id')
        ->where('assignmentbudgetings.status', 0)
        ->whereIn('invoices.currency', [1, 3])
        ->select(
          'invoices.currency',
          DB::raw("DATE_FORMAT(outstandings.created_at, '%Y-%m-%d') as outstandings_date"),
          DB::raw('SUM(outstandings.AMT) as total_amount')
        )
        ->groupBy('invoices.currency', 'outstandings_date')
        ->get();


      $totalamountInr = 0;
      $totalUsdamount = 0;

      // dd($outstandingBills);
      foreach ($outstandingBills as $bill) {

        if ($bill->currency == 3) {
          // INR amount added
          $totalamountInr += $bill->total_amount;
        } elseif ($bill->currency == 1) {
          // Get USD rate for that bill date
          $response = Http::get("https://api.frankfurter.app/{$bill->outstandings_date}", [
            'from' => 'USD',
            'to' => 'INR'
          ]);

          $rate = $response->successful()
            ? ($response->json()['rates']['INR'] ?? 0)
            : 0;
          // dd($rate);
          $totalUsdamount += $bill->total_amount * $rate;
        }
      }

      $billspendingforcollection = round($totalamountInr + $totalUsdamount, 2);
      // Bills Pending For Collection end hare
array:2 [
  "response" => GuzzleHttp\Psr7\Response {#3423
    -reasonPhrase: "OK"
    -statusCode: 200
    -headers: array:14 [
      "Date" => array:1 [
        0 => "Mon, 11 Aug 2025 09:34:28 GMT"
      ]
      "Content-Type" => array:1 [
        0 => "application/json; charset=utf-8"
      ]
      "Content-Length" => array:1 [
        0 => "69"
      ]
      "Connection" => array:1 [
        0 => "keep-alive"
      ]
      "Nel" => array:1 [
        0 => "{"report_to":"cf-nel","success_fraction":0.0,"max_age":604800}"
      ]
      "Cache-Control" => array:1 [
        0 => "public, max-age=900"
      ]
      "Etag" => array:1 [
        0 => ""cfd334780eb9ff20a7aecb16d0119d29""
      ]
      "Vary" => array:1 [
        0 => "Origin, accept-encoding"
      ]
      "Age" => array:1 [
        0 => "72"
      ]
      "Cf-Cache-Status" => array:1 [
        0 => "HIT"
      ]
      "Report-To" => array:1 [
        0 => "{"group":"cf-nel","max_age":604800,"endpoints":[{"url":"https://a.nel.cloudflare.com/report/v4?s=%2FcECfnEu1q%2B53uz2TQlbjQ%2BiIoGRLgYD1ClB53ektAsaoYzkZ3834Dfek7IFmIBpjJA9PYpakv9UmveqtvjSIz9rNq%2F%2B4dx2VD%2BxyYcPKFiqDw8%3D"}]}"
      ]
      "Server" => array:1 [
        0 => "cloudflare"
      ]
      "CF-RAY" => array:1 [
        0 => "96d6bcc6496f5963-DEL"
      ]
      "alt-svc" => array:1 [
        0 => "h3=":443"; ma=86400"
      ]
    ]
    -headerNames: array:14 [
      "date" => "Date"
      "content-type" => "Content-Type"
      "content-length" => "Content-Length"
      "connection" => "Connection"
      "nel" => "Nel"
      "cache-control" => "Cache-Control"
      "etag" => "Etag"
      "vary" => "Vary"
      "age" => "Age"
      "cf-cache-status" => "Cf-Cache-Status"
      "report-to" => "Report-To"
      "server" => "Server"
      "cf-ray" => "CF-RAY"
      "alt-svc" => "alt-svc"
    ]
    -protocol: "1.1"
    -stream: GuzzleHttp\Psr7\Stream {#3427
      -stream: stream resource @720
        wrapper_type: "PHP"
        stream_type: "TEMP"
        mode: "w+b"
        unread_bytes: 0
        seekable: true
        uri: "php://temp"
        options: []
      }
      -size: null
      -seekable: true
      -readable: true
      -writable: true
      -uri: "php://temp"
      -customMetadata: []
    }
  }
  "data" => array:4 [
    "amount" => 1.0
    "base" => "USD"
    "date" => "2025-08-08"
    "rates" => array:1 [
      "INR" => 87.62
    ]
  ]
]
   public function index()
  {
http://127.0.0.1:8000/assignmentplanning/create

  +request: Symfony\Component\HttpFoundation\InputBag {#45 ▼
    #parameters: array:32 [▼
      "_token" => "afjHwcoU61Bn9WQ7E68kvdOfAiRVb90KMAPBmIiY"
      "client_id" => "710"
      "natureofassignment" => "2"
      "othernatureofassignment" => null
      "billingfrequency" => "4"
      "assignment" => "ssss"
      "month" => null
      "yearly_nam" => null
      "monthremarks" => null
      "quarterly_names" => null
      "yearly_namequarter" => null
      "remarksquarter" => null
      "half_yearly_name" => null
      "yearly_namehf" => null
      "remarkshf" => null
      "yearly_name" => null
      "remarksyn" => null
      "period_start" => "2025-08-12"
      "period_end" => "2025-08-13"
      "assignmentstartdate" => "2025-08-14"
      "assignmentenddate" => "2025-08-15"
      "Currency" => "USD"
      "amount" => "100"
      "engagementfee" => "8762"
      "exchangerate" => "87.62"
      "eqcrapplicable" => "1"
      "eqcrpart" => "17"
      "eqcrpartnerteams" => array:1 [▶]
      "partner" => "19"
      "otherpartner" => "22"
      "manager" => array:1 [▶]
      "teammember" => array:1 [▶]
    ]
  }

     // Partner-wise P&L Statement
      // // $currentDate = Carbon::now();
      // $currentDate = Carbon::parse('2024-07-01 13:30:00');
      // $currentMonth = $currentDate->format('F');
      // if ($currentDate->month >= 4) {
      //   // Current year financial year
      //   $startDate = Carbon::create($currentDate->year, 4, 1);
      //   $endDate = Carbon::create($currentDate->year + 1, 3, 31);
      // } else {
      //   // Previous year financial year
      //   $startDate = Carbon::create($currentDate->year - 1, 4, 1);
      //   $endDate = Carbon::create($currentDate->year, 3, 31);
      // }

      // $invoiceData = DB::table('assignmentbudgetings')
      //   ->select(
      //     'assignmentbudgetings.assignmentgenerate_id',
      //     'clients.client_name',
      //     'teammembers.team_member',
      //     'assignments.assignment_name'
      //   )
      //   ->join('invoices', 'invoices.assignmentgenerate_id', '=', 'assignmentbudgetings.assignmentgenerate_id')
      //   ->Join('teammembers', 'teammembers.id', '=', 'invoices.partner')
      //   ->Join('assignments', 'assignments.id', '=', 'invoices.assignment_id')
      //   ->Join('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
      //   ->whereBetween('assignmentbudgetings.periodstartdate', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
      //   ->whereBetween('assignmentbudgetings.periodenddate', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
      //   ->groupBy('assignmentbudgetings.assignmentgenerate_id', 'clients.client_name', 'teammembers.team_member', 'assignments.assignment_name')
      //   ->limit(20)
      //   ->get();

      // // Fetch all invoice totals in bulk
      // $invoiceTotals = DB::table('invoices')
      //   ->select('assignmentgenerate_id', DB::raw('SUM(total) as total'))
      //   ->whereIn('assignmentgenerate_id', $invoiceData->pluck('assignmentgenerate_id'))
      //   ->groupBy('assignmentgenerate_id')
      //   ->pluck('total', 'assignmentgenerate_id');

      // // Fetch all timesheet data in bulk
      // $timesheetData = DB::table('timesheetusers')
      //   ->select('assignmentgenerate_id', 'createdby', DB::raw('SUM(totalhour) as total_hour'))
      //   ->whereIn('assignmentgenerate_id', $invoiceData->pluck('assignmentgenerate_id'))
      //   ->groupBy('assignmentgenerate_id', 'createdby')
      //   ->get();

      // // Fetch all team member costs in bulk
      // $teamMemberCosts = DB::table('teammembers')
      //   ->select('id', 'cost_hour')
      //   ->whereIn('id', $timesheetData->pluck('createdby')->unique())
      //   ->pluck('cost_hour', 'id');

      // $invoiceData1 = $invoiceData->map(function ($invoice) use ($invoiceTotals, $timesheetData, $teamMemberCosts) {
      //   $invoice->total = $invoiceTotals[$invoice->assignmentgenerate_id] ?? 0;

      //   $sum = 0;
      //   foreach ($timesheetData->where('assignmentgenerate_id', $invoice->assignmentgenerate_id) as $costingData) {
      //     $avgcost = $teamMemberCosts[$costingData->createdby] ?? 0;
      //     $sum += $costingData->total_hour * $avgcost;
      //   }

      //   $invoice->cost = $sum;
      //   $invoice->profit_loss = $invoice->total - $sum;

      //   return $invoice;
      // });

      // $invoiceData = $invoiceData1
      //   ->groupBy('team_member')
      //   ->map(function ($group) {
      //     return (object)[
      //       'team_member'    => $group->first()->team_member,
      //       'total'          => $group->sum('total'),
      //       'cost'           => $group->sum('cost'),
      //       'profit_loss'    => $group->sum('profit_loss'),
      //     ];
      //   })
      //   ->values();

      // $currentDate = Carbon::now();
      $todayDate = Carbon::parse('2024-07-01');
      $financialStartdate = $todayDate->month >= 4 ? Carbon::create($todayDate->year, 4, 1) : Carbon::create($todayDate->year - 1, 4, 1);
      $financialEnddate = $financialStartdate->copy()->addYear()->subDay();

      $assignmentGenerateIds = DB::table('assignmentbudgetings')
        ->whereBetween('periodstartdate', [$financialStartdate, $financialEnddate])
        ->whereBetween('periodenddate', [$financialStartdate, $financialEnddate])
        ->pluck('assignmentgenerate_id');

      $invoices = DB::table('invoices')
        ->select(
          'invoices.assignmentgenerate_id',
          'teammembers.team_member',
          DB::raw('SUM(invoices.total) as total')
        )
        ->join('teammembers', 'teammembers.id', '=', 'invoices.partner')
        ->whereIn('invoices.assignmentgenerate_id', $assignmentGenerateIds)
        ->groupBy('invoices.assignmentgenerate_id', 'teammembers.team_member')
        ->get();

      $timesheetData = DB::table('timesheetusers')
        ->select('assignmentgenerate_id', 'createdby', DB::raw('SUM(totalhour) as total_hour'))
        ->whereIn('assignmentgenerate_id', $assignmentGenerateIds)
        ->groupBy('assignmentgenerate_id', 'createdby')
        ->get();

      $teamMemberCosts = DB::table('teammembers')
        ->whereIn('id', $timesheetData->pluck('createdby')->unique())
        ->pluck('cost_hour', 'id');

      $groupedCosts = $timesheetData->groupBy('assignmentgenerate_id')->map(function ($rows) use ($teamMemberCosts) {
        return $rows->sum(function ($row) use ($teamMemberCosts) {
          return $row->total_hour * ($teamMemberCosts[$row->createdby] ?? 0);
        });
      });

      $finalData = $invoices->map(function ($row) use ($groupedCosts) {
        $row->cost = $groupedCosts[$row->assignmentgenerate_id] ?? 0;
        $row->profit_loss = $row->total - $row->cost;
        return $row;
      });

      $partnerWiseProfit = $finalData
        ->groupBy('team_member')
        ->map(function ($items, $teamMember) {
          return (object)[
            'team_member' => $teamMember,
            'total' => $items->sum(fn($item) => (float) $item->total),
            'cost' => $items->sum('cost'),
            'profit_loss' => $items->sum('profit_loss'),
          ];
        })
        // Reset index if needed
        ->values();

      dd($partnerWiseProfit);

      // Partner-wise P&L Statement end hare
    if (auth()->user()->role_id == 11) {

      // Partner-wise P&L Statement
      // $currentDate = Carbon::now();
      // $currentDate = Carbon::parse('2024-07-01 13:30:00');
      // $currentMonth = $currentDate->format('F');
      // if ($currentDate->month >= 4) {
      //   // Current year financial year
      //   $startDate = Carbon::create($currentDate->year, 4, 1);
      //   $endDate = Carbon::create($currentDate->year + 1, 3, 31);
      // } else {
      //   // Previous year financial year
      //   $startDate = Carbon::create($currentDate->year - 1, 4, 1);
      //   $endDate = Carbon::create($currentDate->year, 3, 31);
      // }

      // $invoiceData = DB::table('assignmentbudgetings')
      //   ->select(
      //     'assignmentbudgetings.assignmentgenerate_id',
      //     'clients.client_name',
      //     'teammembers.team_member',
      //     'assignments.assignment_name'
      //   )
      //   ->join('invoices', 'invoices.assignmentgenerate_id', '=', 'assignmentbudgetings.assignmentgenerate_id')
      //   ->Join('teammembers', 'teammembers.id', '=', 'invoices.partner')
      //   ->Join('assignments', 'assignments.id', '=', 'invoices.assignment_id')
      //   ->Join('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
      //   ->whereBetween('assignmentbudgetings.periodstartdate', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
      //   ->whereBetween('assignmentbudgetings.periodenddate', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
      //   ->groupBy('assignmentbudgetings.assignmentgenerate_id', 'clients.client_name', 'teammembers.team_member', 'assignments.assignment_name')
      //   // ->limit(20)
      //   ->get();

      // // Fetch all invoice totals in bulk
      // $invoiceTotals = DB::table('invoices')
      //   ->select('assignmentgenerate_id', DB::raw('SUM(total) as total'))
      //   ->whereIn('assignmentgenerate_id', $invoiceData->pluck('assignmentgenerate_id'))
      //   ->groupBy('assignmentgenerate_id')
      //   ->pluck('total', 'assignmentgenerate_id');

      // // Fetch all timesheet data in bulk
      // $timesheetData = DB::table('timesheetusers')
      //   ->select('assignmentgenerate_id', 'createdby', DB::raw('SUM(totalhour) as total_hour'))
      //   ->whereIn('assignmentgenerate_id', $invoiceData->pluck('assignmentgenerate_id'))
      //   ->groupBy('assignmentgenerate_id', 'createdby')
      //   ->get();

      // // Fetch all team member costs in bulk
      // $teamMemberCosts = DB::table('teammembers')
      //   ->select('id', 'cost_hour')
      //   ->whereIn('id', $timesheetData->pluck('createdby')->unique())
      //   ->pluck('cost_hour', 'id');

      // $invoiceData1 = $invoiceData->map(function ($invoice) use ($invoiceTotals, $timesheetData, $teamMemberCosts) {
      //   $invoice->total = $invoiceTotals[$invoice->assignmentgenerate_id] ?? 0;

      //   $sum = 0;
      //   foreach ($timesheetData->where('assignmentgenerate_id', $invoice->assignmentgenerate_id) as $costingData) {
      //     $avgcost = $teamMemberCosts[$costingData->createdby] ?? 0;
      //     $sum += $costingData->total_hour * $avgcost;
      //   }

      //   $invoice->cost = $sum;
      //   $invoice->profit_loss = $invoice->total - $sum;

      //   return $invoice;
      // });

      // dd($invoiceData1);





      // $invoiceData = $invoiceData1
      //   ->groupBy('team_member')
      //   ->map(function ($group) {
      //     return (object)[
      //       'team_member'    => $group->first()->team_member,
      //       'total'          => $group->sum('total'),
      //       'cost'           => $group->sum('cost'),
      //       'profit_loss'    => $group->sum('profit_loss'),
      //     ];
      //   })
      //   ->values();

      // Partner-wise P&L Statement end hare



      // $currentDate = Carbon::now();
      $currentDate = Carbon::parse('2024-07-01');
      $fyStart = $currentDate->month >= 4 ? Carbon::create($currentDate->year, 4, 1) : Carbon::create($currentDate->year - 1, 4, 1);
      $fyEnd = $fyStart->copy()->addYear()->subDay();

      $assignmentGenerateIds = DB::table('assignmentbudgetings')
        ->whereBetween('periodstartdate', [$fyStart, $fyEnd])
        ->whereBetween('periodenddate', [$fyStart, $fyEnd])
        ->pluck('assignmentgenerate_id');

      $invoices = DB::table('invoices')
        ->select(
          'invoices.assignmentgenerate_id',
          'teammembers.team_member',
          DB::raw('SUM(invoices.total) as total')
        )
        ->join('teammembers', 'teammembers.id', '=', 'invoices.partner')
        ->whereIn('invoices.assignmentgenerate_id', $assignmentGenerateIds)
        ->groupBy('invoices.assignmentgenerate_id', 'teammembers.team_member')
        ->get();




      $timesheetData = DB::table('timesheetusers')
        ->select('assignmentgenerate_id', 'createdby', DB::raw('SUM(totalhour) as total_hour'))
        ->whereIn('assignmentgenerate_id', $assignmentGenerateIds)
        ->groupBy('assignmentgenerate_id', 'createdby')
        ->get();

      $teamMemberCosts = DB::table('teammembers')
        ->whereIn('id', $timesheetData->pluck('createdby')->unique())
        ->pluck('cost_hour', 'id');



      $groupedCosts = $timesheetData->groupBy('assignmentgenerate_id')->map(function ($rows) use ($teamMemberCosts) {
        return $rows->sum(function ($row) use ($teamMemberCosts) {
          return $row->total_hour * ($teamMemberCosts[$row->createdby] ?? 0);
        });
      });



      $finalData = $invoices->map(function ($row) use ($groupedCosts) {
        $row->cost = $groupedCosts[$row->assignmentgenerate_id] ?? 0;
        $row->profit_loss = $row->total - $row->cost;
        return $row;
      });

      $groupedData = $finalData
        ->groupBy('team_member')
        ->map(function ($items, $teamMember) {
          return (object)[
            'team_member' => $teamMember,
            'total' => $items->sum(fn($item) => (float) $item->total),
            'cost' => $items->sum('cost'),
            'profit_loss' => $items->sum('profit_loss'),
          ];
        })
        // Reset index if needed
        ->values();


      // dd($groupedData, 111);


      // return view('your-blade-file', ['invoiceData' => $finalData]);

      return view('backEnd.kgsdashboardreport', ['invoiceData' => $groupedData]);
    }
  }

Illuminate\Support\Collection {#4412 ▼
  #items: array:179 [▼
    0 => {#3242 ▼
      +"assignmentgenerate_id": 110310732433
      +"client_name": "TPL-SSGIPL Joint Venture"
      +"team_member": "Amber Jaiswal"
      +"assignment_name": "IND AS ( Statutory Audit )"
      +"total": "118000"
      +"cost": 0.0
      +"profit_loss": 118000.0
    }
    1 => {#3250 ▼
      +"assignmentgenerate_id": 114613099966
      +"client_name": "GULERMAK-TPL Joint Venture"
      +"team_member": "Amber Jaiswal"
      +"assignment_name": "IND AS ( Statutory Audit )"
      +"total": "118000"
      +"cost": 0.0
      +"profit_loss": 118000.0
    }
    2 => {#3247 ▼
      +"assignmentgenerate_id": 120712623326
      +"client_name": "Bank Of India"
      +"team_member": "Saurabh Jain"
      +"assignment_name": "ASM"
      +"total": "147500"
      +"cost": 58414.0
      +"profit_loss": 89086.0
    }
    3 => {#3244 ▼
      +"assignmentgenerate_id": 133965434429
      +"client_name": "Jindal Industries Private Limited"
      +"team_member": "Saurabh Jain"
      +"assignment_name": "ASM"
      +"total": "147500"
      +"cost": 15583.0
      +"profit_loss": 131917.0
    }
    4 => {#3241 ▼
      +"assignmentgenerate_id": 137718201324
      +"client_name": "LIFE INSURANCE CORPORATION OF INDIA"
      +"team_member": "Bhuvnesh Maheshwari"
      +"assignment_name": "LIC"
      +"total": "637790"
      +"cost": 118028.0
      +"profit_loss": 519762.0
    }
    5 => {#3245 ▼
      +"assignmentgenerate_id": 152763376085
      +"client_name": "TPL-CAI JV"
      +"team_member": "Amber Jaiswal"
      +"assignment_name": "IND AS ( Statutory Audit )"
      +"total": "118000"
      +"cost": 496.0
      +"profit_loss": 117504.0
    }
    6 => {#3249 ▼
      +"assignmentgenerate_id": 155639658333
      +"client_name": "Ebix Money Express Private Limited"
      +"team_member": "Saurabh Jain"
      +"assignment_name": "IND AS ( Statutory Audit )"
      +"total": "937092"
      +"cost": 84392.0
      +"profit_loss": 852700.0
    }
    7 => {#3240 ▼
      +"assignmentgenerate_id": 162709017994
      +"client_name": "Jindal Steel Odisha Limited"
      +"team_member": "Arihant Jain"
      +"assignment_name": "ASM"
      +"total": "235101"
      +"cost": 0.0
      +"profit_loss": 235101.0
    }
    8 => {#3239 ▼
      +"assignmentgenerate_id": 164195725014
      +"client_name": "DBL-Sairmal Coal Mines Pvt. Ltd."
      +"team_member": "Saurabh Jain"
      +"assignment_name": "ASM"
      +"total": "339250"
      +"cost": 37008.0
      +"profit_loss": 302242.0
    }
    9 => {#3238 ▼
      +"assignmentgenerate_id": 200767069230
      +"client_name": "Auro Infra Private Limited"
      +"team_member": "Saurabh Jain"
      +"assignment_name": "ASM"
      +"total": "218694"
      +"cost": 101772.0
      +"profit_loss": 116922.0
    }
    10 => {#3237 ▼
      +"assignmentgenerate_id": 207548498191
      +"client_name": "Oriental Nagpur Betul Highway Limited"
      +"team_member": "Arihant Jain"
      +"assignment_name": "IND AS ( Statutory Audit )"
      +"total": "155760"
      +"cost": 0.0
      +"profit_loss": 155760.0
    }
    11 => {#3236 ▼
      +"assignmentgenerate_id": 209929375017
      +"client_name": "Asset Reconstruction Company (India) Limited"
      +"team_member": "Karan Chadha"
      +"assignment_name": "29A Due Diligence of Individual"
      +"total": "885"
      +"cost": 0
      +"profit_loss": 885
    }
    12 => {#3265 ▼
      +"assignmentgenerate_id": 210533227183
      +"client_name": "The Office of the Insurance Ombudsman, Delhi"
      +"team_member": "Bhuvnesh Maheshwari"
      +"assignment_name": "AS Balance sheet and P&L"
      +"total": "25960"
      +"cost": 0
      +"profit_loss": 25960
    }
    13 => {#3266 ▼
      +"assignmentgenerate_id": 217392503201
      +"client_name": "Hero Fincorp Limited"
      +"team_member": "Saurabh Jain"
      +"assignment_name": "ASM"
      +"total": "147500"
      +"cost": 18572.0
      +"profit_loss": 128928.0
    }
    14 => {#3267 ▼
      +"assignmentgenerate_id": 220486756205
      +"client_name": "Hero Housing Finance Limited"
      +"team_member": "Saurabh Jain"
      +"assignment_name": "ASM"
      +"total": "278775"
      +"cost": 0.0
      +"profit_loss": 278775.0
    }
    15 => {#3268 ▼
      +"assignmentgenerate_id": 221345665001
      +"client_name": "Gold Plus Float Glass Private Limited"
      +"team_member": "Saurabh Jain"
      +"assignment_name": "ASM"
      +"total": "236000"
      +"cost": 20802.0
      +"profit_loss": 215198.0
    }
    16 => {#3269 ▼
      +"assignmentgenerate_id": 226079280355
      +"client_name": "Lotus Home Textiles Limited"
      +"team_member": "Arihant Jain"
      +"assignment_name": "Physical Verification of Fixed Assets"
      +"total": "243525"
      +"cost": 4154.0
      +"profit_loss": 239371.0
    }
    17 => {#3270 ▼
      +"assignmentgenerate_id": 230614202550
      +"client_name": "EBIX INC."
      +"team_member": "Saurabh Jain"
      +"assignment_name": "Quarterly review (US GAAP) â€“ Ebix Inc."
      +"total": "283392"
      +"cost": 289212.0
      +"profit_loss": -5820.0
    }
    18 => {#3271 ▼
      +"assignmentgenerate_id": 239456957268
      +"client_name": "EBIX INC."
      +"team_member": "Saurabh Jain"
      +"assignment_name": "U S GaaP"
      +"total": "157662"
      +"cost": 138298.0
      +"profit_loss": 19364.0
    }
    19 => {#3272 ▼
      +"assignmentgenerate_id": 242991117286
      +"client_name": "Asset Reconstruction Company (India) Limited"
      +"team_member": "Karan Chadha"
      +"assignment_name": "29A Due Diligence of Individual"
      +"total": "885"
      +"cost": 0
      +"profit_loss": 885
    }
    20 => {#3273 ▼
      +"assignmentgenerate_id": 244941109527
      +"client_name": "KSK Mahanadi Power Company Limited"
      +"team_member": "Saurabh Jain"
      +"assignment_name": "29A Due Diligence of Individual"
      +"total": "9279992"
      +"cost": 191486.0
      +"profit_loss": 9088506.0
    }
    21 => {#3274 ▶}
    22 => {#3275 ▶}
    23 => {#3276 ▶}
    24 => {#3277 ▶}
    25 => {#3278 ▶}
    26 => {#3279 ▶}
    27 => {#3280 ▶}
    28 => {#3281 ▶}
    29 => {#3282 ▶}
    30 => {#3283 ▶}
    31 => {#3284 ▶}
    32 => {#3285 ▶}
    33 => {#3286 ▶}
    34 => {#3287 ▶}
    35 => {#3288 ▶}
    36 => {#3289 ▶}
    37 => {#3290 ▶}
    38 => {#3291 ▶}
    39 => {#3292 ▶}
    40 => {#3293 ▶}
    41 => {#3294 ▶}
    42 => {#3295 ▶}
    43 => {#3296 ▶}
    44 => {#3297 ▶}
    45 => {#3298 ▶}
    46 => {#3299 ▶}
    47 => {#3300 ▶}
    48 => {#3301 ▶}
    49 => {#3302 ▶}
    50 => {#3303 ▶}
    51 => {#3304 ▶}
    52 => {#3305 ▶}
    53 => {#3306 ▶}
    54 => {#3307 ▶}
    55 => {#3308 ▶}
    56 => {#3309 ▶}
    57 => {#3310 ▶}
    58 => {#3311 ▶}
    59 => {#3312 ▶}
    60 => {#3313 ▶}
    61 => {#3314 ▶}
    62 => {#3315 ▶}
    63 => {#3316 ▶}
    64 => {#3317 ▶}
    65 => {#3318 ▶}
    66 => {#3319 ▶}
    67 => {#3320 ▶}
    68 => {#3321 ▶}
    69 => {#3322 ▶}
    70 => {#3323 ▶}
    71 => {#3324 ▶}
    72 => {#3325 ▶}
    73 => {#3326 ▶}
    74 => {#3327 ▶}
    75 => {#3328 ▶}
    76 => {#3329 ▶}
    77 => {#3330 ▶}
    78 => {#3331 ▶}
    79 => {#3332 ▶}
    80 => {#3333 ▶}
    81 => {#3334 ▶}
    82 => {#3335 ▶}
    83 => {#3336 ▶}
    84 => {#3337 ▶}
    85 => {#3338 ▶}
    86 => {#3339 ▶}
    87 => {#3340 ▶}
    88 => {#3341 ▶}
    89 => {#3342 ▶}
    90 => {#3343 ▶}
    91 => {#3344 ▶}
    92 => {#3345 ▶}
    93 => {#3346 ▶}
    94 => {#3347 ▶}
    95 => {#3348 ▶}
    96 => {#3349 ▶}
    97 => {#3350 ▶}
    98 => {#3351 ▶}
    99 => {#3352 ▶}
    100 => {#3353 ▶}
    101 => {#3354 ▶}
    102 => {#3355 ▶}
    103 => {#3356 ▶}
    104 => {#3357 ▶}
    105 => {#3358 ▶}
    106 => {#3359 ▶}
    107 => {#3360 ▶}
    108 => {#3361 ▶}
    109 => {#3362 ▶}
    110 => {#3363 ▶}
    111 => {#3364 ▶}
    112 => {#3365 ▶}
    113 => {#3366 ▶}
    114 => {#3367 ▶}
    115 => {#3368 ▶}
    116 => {#3369 ▶}
    117 => {#3370 ▶}
    118 => {#3371 ▶}
    119 => {#3372 ▶}
    120 => {#3373 ▶}
    121 => {#3374 ▶}
    122 => {#3375 ▶}
    123 => {#3376 ▶}
    124 => {#3377 ▶}
    125 => {#3378 ▶}
    126 => {#3379 ▶}
    127 => {#3380 ▶}
    128 => {#3381 ▶}
    129 => {#3382 ▶}
    130 => {#3383 ▶}
    131 => {#3384 ▶}
    132 => {#3385 ▶}
    133 => {#3386 ▶}
    134 => {#3387 ▶}
    135 => {#3388 ▶}
    136 => {#3389 ▶}
    137 => {#3390 ▶}
    138 => {#3391 ▶}
    139 => {#3392 ▶}
    140 => {#3393 ▶}
    141 => {#3394 ▶}
    142 => {#3395 ▶}
    143 => {#3396 ▶}
    144 => {#3397 ▶}
    145 => {#3398 ▶}
    146 => {#3399 ▶}
    147 => {#3400 ▶}
    148 => {#3401 ▶}
    149 => {#3402 ▶}
    150 => {#3403 ▶}
    151 => {#3404 ▶}
    152 => {#3405 ▶}
    153 => {#3406 ▶}
    154 => {#3407 ▶}
    155 => {#3408 ▶}
    156 => {#3409 ▶}
    157 => {#3410 ▶}
    158 => {#3411 ▶}
    159 => {#3412 ▶}
    160 => {#3413 ▶}
    161 => {#3414 ▶}
    162 => {#3415 ▶}
    163 => {#3416 ▶}
    164 => {#3417 ▶}
    165 => {#3418 ▶}
    166 => {#3419 ▶}
    167 => {#3420 ▶}
    168 => {#3421 ▶}
    169 => {#3422 ▶}
    170 => {#3423 ▶}
    171 => {#3424 ▶}
    172 => {#3425 ▶}
    173 => {#3426 ▶}
    174 => {#3427 ▶}
    175 => {#3428 ▶}
    176 => {#3429 ▶}
    177 => {#3430 ▶}
    178 => {#3431 ▶}
  ]
  #escapeWhenCastingToString: false
}
     // How many amounts pending for invoice genrated
      $billspending = DB::table('assignmentmappings')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftJoin('invoices', 'invoices.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->whereNull('invoices.assignmentgenerate_id')
        ->where('assignmentbudgetings.status', 0)
        ->sum('assignmentmappings.engagementfee');

      // How many amounts pending for collection
      // $billspendingforcollection = DB::table('assignmentmappings')
      //   ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
      //   ->leftJoin('invoices', 'invoices.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
      //   ->leftJoin('payments', 'payments.invoiceid', '=', 'invoices.invoice_id')
      //   // ensures invoice is created
      //   ->whereNotNull('invoices.id')
      //   // Payment not yet received
      //   ->whereNull('payments.invoiceid')
      //   ->where('assignmentbudgetings.status', 0)
      //   ->sum('invoices.total');

      $billspendingforcollection = DB::table('assignmentmappings')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->leftJoin('invoices', 'invoices.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->leftJoin('outstandings', 'outstandings.BILL_NO', '=', 'invoices.invoice_id')
        // ensures invoice is created
        ->whereNotNull('invoices.id')
        ->where('assignmentbudgetings.status', 0)
        ->sum('outstandings.AMT');
      // ->get();

      // dd($billspendingforcollection);

    // How many amounts pending for collection
    // $billspendingforcollection = DB::table('assignmentmappings')
    //   ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
    //   ->leftJoin('invoices', 'invoices.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
    //   ->leftJoin('payments', 'payments.invoiceid', '=', 'invoices.invoice_id')
    //   // ensures invoice is created
    //   ->whereNotNull('invoices.id')
    //   // Payment not yet received
    //   ->whereNull('payments.invoiceid')
    //   ->where('assignmentbudgetings.status', 0)
    //   ->sum('invoices.total');

    $billspendingforcollection = DB::table('assignmentmappings')
      ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
      ->leftJoin('invoices', 'invoices.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
      ->leftJoin('outstandings', 'outstandings.BILL_NO', '=', 'invoices.invoice_id')
      // ensures invoice is created
      ->whereNotNull('invoices.id')
      // Payment not yet received
      // ->whereNull('outstandings.BILL_NO')
      ->where('assignmentbudgetings.status', 0)
      ->sum('outstandings.AMT');
    // ->get();

  
    // Budget vs Actual P&L
    $budgetRevenueandbudgetExpences = DB::table('assignmentmappings')
      ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, SUM(engagementfee) as engagementfee, SUM(teamestcost) as total_teamestcost')
      ->where(function ($query) use ($financialEndYear, $financialStartYear) {
        // Jan to Mar from next year
        $query->where(function ($q) use ($financialEndYear) {
          $q->whereYear('created_at', $financialEndYear)
            ->whereIn(DB::raw('MONTH(created_at)'), [1, 2, 3]);
        })
          // Apr to Jun from current year
          ->orWhere(function ($q) use ($financialStartYear) {
            $q->whereYear('created_at', $financialStartYear)
              ->whereIn(DB::raw('MONTH(created_at)'), [4, 5, 6]);
          });
      })
      ->groupByRaw('MONTH(created_at), YEAR(created_at)')
      ->orderByRaw('FIELD(MONTH(created_at), 1, 2, 3, 4, 5, 6)')
      ->get()
      ->map(function ($item) use ($monthNames) {
        $item->month = $monthNames[$item->month] ?? $item->month;
        return $item;
      });

    $budgetActualRevenue = DB::table('invoices')
      ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, SUM(total) as invoices_amount')
      ->where(function ($query) use ($financialEndYear, $financialStartYear) {
        // Jan to Mar from next year
        $query->where(function ($q) use ($financialEndYear) {
          $q->whereYear('created_at', $financialEndYear)
            ->whereIn(DB::raw('MONTH(created_at)'), [1, 2, 3]);
        })
          // Apr to Jun from current year
          ->orWhere(function ($q) use ($financialStartYear) {
            $q->whereYear('created_at', $financialStartYear)
              ->whereIn(DB::raw('MONTH(created_at)'), [4, 5, 6]);
          });
      })
      ->groupByRaw('MONTH(created_at), YEAR(created_at)')
      ->orderByRaw('FIELD(MONTH(created_at), 1, 2, 3, 4, 5, 6)')
      ->get()
      ->map(function ($item) use ($monthNames) {
        $item->month = $monthNames[$item->month] ?? $item->month;
        return $item;
      });



    $timesheetUserRecord = DB::table('timesheets')
      ->leftJoin('timesheetusers', 'timesheetusers.timesheetid', '=', 'timesheets.id')
      ->leftJoin('teammembers', 'teammembers.id', '=', 'timesheetusers.createdby')
      ->where('timesheets.created_by', 815)
      ->selectRaw('MONTH(timesheets.date) as month, YEAR(timesheets.date) as year, SUM(timesheetusers.totalhour * teammembers.cost_hour) as total_cost')
      ->where(function ($query) use ($financialStartYear, $financialEndYear) {
        $query->where(function ($q) use ($financialEndYear) {
          $q->whereYear('timesheets.date', $financialEndYear)
            ->whereIn(DB::raw('MONTH(timesheets.date)'), [1, 2, 3]); // Jan-Mar
        })->orWhere(function ($q) use ($financialStartYear) {
          $q->whereYear('timesheets.date', $financialStartYear)
            ->whereIn(DB::raw('MONTH(timesheets.date)'), [4, 5, 6]); // Apr-Jun
        });
      })
      ->groupByRaw('MONTH(timesheets.date), YEAR(timesheets.date)')
      ->get()
      ->map(function ($item) use ($monthNames) {
        $item->month = $monthNames[$item->month] ?? $item->month;
        return $item;
      });

    // check 2 days timesheet one days 


    dd($timesheetUserRecord);

    // $monthlyCosts = DB::table('timesheetusers')
    //   ->leftJoin('teammembers', 'teammembers.id', '=', 'timesheetusers.createdby')
    //   // ->whereIn(DB::raw('MONTH(timesheetusers.created_at)'), [1, 2, 3])
    //   ->where('timesheetusers.createdby', 815)
    //   ->selectRaw('
    //     MONTH(timesheetusers.created_at) as month,
    //     YEAR(timesheetusers.created_at) as year,
    //     SUM(timesheetusers.totalhour * teammembers.cost_hour) as total_cost
    // ')
    //   ->groupBy(DB::raw('MONTH(timesheetusers.created_at)'), DB::raw('YEAR(timesheetusers.created_at)'))
    //   ->orderByRaw('YEAR(timesheetusers.created_at), MONTH(timesheetusers.created_at)')
    //   ->get()
    //   ->map(function ($item) {
    //     $monthNames = [1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June'];
    //     $item->month = $monthNames[$item->month] ?? $item->month;
    //     return $item;
    //   });


    $budgetActualExpences = DB::table('timesheetusers')
      ->leftJoin('teammembers', 'teammembers.id', '=', 'timesheetusers.createdby')
      ->where(function ($query) use ($financialEndYear, $financialStartYear) {
        // Jan to Mar from next year
        $query->where(function ($q) use ($financialEndYear) {
          $q->whereYear('timesheetusers.created_at', $financialEndYear)
            ->whereIn(DB::raw('MONTH(timesheetusers.created_at)'), [1, 2, 3]);
        })
          // Apr to Jun from current year
          ->orWhere(function ($q) use ($financialStartYear) {
            $q->whereYear('timesheetusers.created_at', $financialStartYear)
              ->whereIn(DB::raw('MONTH(timesheetusers.created_at)'), [4, 5, 6]);
          });
      })
      ->where('timesheetusers.createdby', 815)
      ->selectRaw('
        MONTH(timesheetusers.created_at) as month,
        YEAR(timesheetusers.created_at) as year,
        SUM(timesheetusers.totalhour * teammembers.cost_hour) as total_cost
    ')
      ->groupByRaw('MONTH(timesheetusers.created_at), YEAR(timesheetusers.created_at)')
      ->orderByRaw('FIELD(MONTH(timesheetusers.created_at), 1, 2, 3, 4, 5, 6)')
      ->get()
      ->map(function ($item) use ($monthNames) {
        $item->month = $monthNames[$item->month] ?? $item->month;
        return $item;
      });

    $budgetActualExpences = DB::table('timesheetusers')
      ->leftJoin('teammembers', 'teammembers.id', '=', 'timesheetusers.createdby')
      ->where(function ($query) use ($financialEndYear, $financialStartYear) {
        // Jan to Mar from next year
        $query->where(function ($q) use ($financialEndYear) {
          $q->whereYear('timesheetusers.date', $financialEndYear)
            ->whereIn(DB::raw('MONTH(timesheetusers.date)'), [1, 2, 3]);
        })
          // Apr to Jun from current year
          ->orWhere(function ($q) use ($financialStartYear) {
            $q->whereYear('timesheetusers.date', $financialStartYear)
              ->whereIn(DB::raw('MONTH(timesheetusers.date)'), [4, 5, 6]);
          });
      })
      ->where('timesheetusers.createdby', 815)
      ->selectRaw('
        MONTH(timesheetusers.date) as month,
        YEAR(timesheetusers.date) as year,
        SUM(timesheetusers.totalhour * teammembers.cost_hour) as total_cost
    ')
      ->groupByRaw('MONTH(timesheetusers.date), YEAR(timesheetusers.date)')
      ->orderByRaw('FIELD(MONTH(timesheetusers.date), 1, 2, 3, 4, 5, 6)')
      ->get()
      ->map(function ($item) use ($monthNames) {
        $item->month = $monthNames[$item->month] ?? $item->month;
        return $item;
      });


    dd($budgetActualExpences);

    //     $budgetActualExpences = DB::table('timesheetusers')
    //     ->leftJoin('teammembers', 'teammembers.id', '=', 'timesheetusers.createdby')
    //     ->where(function ($query) use ($financialEndYear, $financialStartYear) {
    //         // Jan to Mar from next year
    //         $query->where(function ($q) use ($financialEndYear) {
    //             $q->whereYear('timesheetusers.date', $financialEndYear)
    //               ->whereIn(DB::raw('MONTH(timesheetusers.date)'), [1, 2, 3]);
    //         })
    //         // Apr to Jun from current year
    //         ->orWhere(function ($q) use ($financialStartYear) {
    //             $q->whereYear('timesheetusers.date', $financialStartYear)
    //               ->whereIn(DB::raw('MONTH(timesheetusers.date)'), [4, 5, 6]);
    //         });
    //     })
    //     ->where('timesheetusers.createdby', 815)
    //     ->selectRaw('
    //         MONTH(timesheetusers.date) as month,
    //         YEAR(timesheetusers.date) as year,
    //         SUM(timesheetusers.totalhour * teammembers.cost_hour) as total_cost
    //     ')
    //     ->groupByRaw('MONTH(timesheetusers.date), YEAR(timesheetusers.date)')
    //     ->orderByRaw('FIELD(MONTH(timesheetusers.date), 1, 2, 3, 4, 5, 6)')
    //     ->get()
    //     ->map(function ($item) use ($monthNames) {
    //         $item->month = $monthNames[$item->month] ?? $item->month;
    //         return $item;
    //     });

    // dd($budgetActualExpences);


    //     $budgetActualExpences = DB::table(DB::raw('(
    //     SELECT 
    //         STR_TO_DATE(timesheetusers.date, \'%d-%m-%Y\') as parsed_date,
    //         timesheetusers.totalhour,
    //         timesheetusers.createdby,
    //         teammembers.cost_hour
    //     FROM timesheetusers
    //     LEFT JOIN teammembers ON teammembers.id = timesheetusers.createdby
    //     WHERE timesheetusers.createdby = 815
    // ) as sub'))
    //       ->selectRaw("
    //         CASE MONTH(parsed_date)
    //             WHEN 1 THEN 'January'
    //             WHEN 2 THEN 'February'
    //             WHEN 3 THEN 'March'
    //             WHEN 4 THEN 'April'
    //             WHEN 5 THEN 'May'
    //             WHEN 6 THEN 'June'
    //             ELSE MONTH(parsed_date)
    //         END as month,
    //         YEAR(parsed_date) as year,
    //         SUM(totalhour * cost_hour) as total_cost
    //     ")
    //       ->where(function ($query) use ($financialEndYear, $financialStartYear) {
    //         $query->where(function ($q) use ($financialEndYear) {
    //           $q->whereYear('parsed_date', $financialEndYear)
    //             ->whereIn(DB::raw('MONTH(parsed_date)'), [1, 2, 3]);
    //         })->orWhere(function ($q) use ($financialStartYear) {
    //           $q->whereYear('parsed_date', $financialStartYear)
    //             ->whereIn(DB::raw('MONTH(parsed_date)'), [4, 5, 6]);
    //         });
    //       })
    //       ->groupBy(DB::raw('MONTH(parsed_date), YEAR(parsed_date)'))
    //       ->orderByRaw('FIELD(MONTH(parsed_date), 1, 2, 3, 4, 5, 6)')
    //       ->get();

    //     dd($budgetActualExpences);





          DB::table('timesheetusers')
              ->where('createdby', auth()->user()->teammember_id)
              ->where('date', \Carbon\Carbon::parse($date)->format('d-m-Y'))
              ->delete();


                      $timesheetUserRecord = DB::table('timesheetusers')
            ->where('createdby', auth()->user()->teammember_id)
            ->where('date', $date->format('d-m-Y'))
            ->first();


 $cashFlowRecieved = DB::table('payments')
      ->selectRaw('MONTH(paymentdate) as month, YEAR(paymentdate) as year, SUM(amountreceived) as total_amounts')
      ->where(function ($query) use ($financialEndYear, $financialStartYear) {
        // Jan to Mar from next year
        $query->where(function ($q) use ($financialEndYear) {
          $q->whereYear('paymentdate', $financialEndYear)
            ->whereIn(DB::raw('MONTH(paymentdate)'), [1, 2, 3]);
        })
          // Apr to Jun from current year
          ->orWhere(function ($q) use ($financialStartYear) {
            $q->whereYear('paymentdate', $financialStartYear)
              ->whereIn(DB::raw('MONTH(paymentdate)'), [4, 5, 6]);
          });
      })
      ->groupByRaw('MONTH(paymentdate), YEAR(paymentdate)')
      ->orderByRaw('FIELD(MONTH(paymentdate), 1, 2, 3, 4, 5, 6)')
      ->get()
      ->map(function ($item) {
        $monthNames = [
          1 => 'January',
          2 => 'February',
          3 => 'March',
          4 => 'April',
          5 => 'May',
          6 => 'June',
        ];

        $item->month = $monthNames[$item->month] ?? $item->month;
        return $item;
      });

    $cashFlowSpendvender = DB::table('vendorlist')
      ->selectRaw('MONTH(approvedate) as month, YEAR(approvedate) as year, SUM(amount) as total_amounts')
      ->where('status', 1)
      ->where(function ($query) use ($financialEndYear, $financialStartYear) {
        $query->where(function ($q) use ($financialEndYear) {
          $q->whereYear('approvedate', $financialEndYear)
            ->whereIn(DB::raw('MONTH(approvedate)'), [1, 2, 3]);
        })->orWhere(function ($q) use ($financialStartYear) {
          $q->whereYear('approvedate', $financialStartYear)
            ->whereIn(DB::raw('MONTH(approvedate)'), [4, 5, 6]);
        });
      })
      ->groupByRaw('MONTH(approvedate), YEAR(approvedate)')
      ->orderByRaw('FIELD(MONTH(approvedate), 1,2,3,4,5,6)')
      ->get()
      ->map(function ($item) {
        $monthNames = [
          1 => 'January',
          2 => 'February',
          3 => 'March',
          4 => 'April',
          5 => 'May',
          6 => 'June',
        ];
        $item->month = $monthNames[$item->month] ?? $item->month;
        return $item;
      });

    $cashFlowSpendemployee = DB::table('employeepayrolls')
      ->select('month', 'year', DB::raw('SUM(total_amount_to_paid) as total_amounts'))
      ->where(function ($query) use ($financialEndYear, $financialStartYear) {
        $query->where(function ($q) use ($financialEndYear) {
          $q->where('year', $financialEndYear)
            ->whereIn('month', ['January', 'February', 'March']);
        })->orWhere(function ($q) use ($financialStartYear) {
          $q->where('year', $financialStartYear)
            ->whereIn('month', ['April', 'May', 'June']);
        });
      })
      ->where('send_to_bank', 1)
      ->groupBy('year', 'month')
      ->orderByRaw("FIELD(month, 'January', 'February', 'March', 'April', 'May', 'June')")
      ->get();


    $mergedSpenddata = $cashFlowSpendvender->merge($cashFlowSpendemployee);

    $totalspendData = $mergedSpenddata->groupBy(function ($item) {
      return $item->month . '-' . $item->year;
    })->map(function ($group) {
      return (object) [
        'month' => $group->first()->month,
        'year' => $group->first()->year,
        'total_amounts' => $group->sum('total_amounts'),
      ];
    })->sortBy(function ($item) {
      $order = ['January', 'February', 'March', 'April', 'May', 'June'];
      return array_search($item->month, $order);
    })->values();

    $mergedspendandrecieveddata = $totalspendData->merge($cashFlowRecieved);

    $subtracttotalamount = $mergedspendandrecieveddata->groupBy(function ($item) {
      return $item->month . '-' . $item->year;
    })->map(function ($group) {
      return (object) [
        'month' => $group->first()->month,
        'year' => $group->first()->year,
        'total_amounts' => $group->sub('total_amounts'),
      ];
    })->sortBy(function ($item) {
      $order = ['January', 'February', 'March', 'April', 'May', 'June'];
      return array_search($item->month, $order);
    })->values();

    dd([
      'cashFlowRecieved' => $cashFlowRecieved,
      'totalspendData' => $totalspendData,
      'mergedspendandrecieveddata' => $mergedspendandrecieveddata,
      'subtracttotalamount' => $subtracttotalamount,
    ]);



            var cashInflowrawData = @json($cashFlowRecieved);
            var cashOutflowrawData = @json($cashFlowtotalspendData);
            const cashInflowrawmonths = ['January', 'February', 'March', 'April', 'May', 'June'];








  // Cash Flow Analysis
    $cashFlowRecieved = DB::table('payments')
      ->selectRaw('MONTH(paymentdate) as month, YEAR(paymentdate) as year, SUM(amountreceived) as amountreceived')
      ->where(function ($query) use ($financialEndYear, $financialStartYear) {
        // Jan to Mar from next year
        $query->where(function ($q) use ($financialEndYear) {
          $q->whereYear('paymentdate', $financialEndYear)
            ->whereIn(DB::raw('MONTH(paymentdate)'), [1, 2, 3]);
        })
          // Apr to Jun from current year
          ->orWhere(function ($q) use ($financialStartYear) {
            $q->whereYear('paymentdate', $financialStartYear)
              ->whereIn(DB::raw('MONTH(paymentdate)'), [4, 5, 6]);
          });
      })
      ->groupByRaw('MONTH(paymentdate), YEAR(paymentdate)')
      ->orderByRaw('FIELD(MONTH(paymentdate), 1, 2, 3, 4, 5, 6)')
      ->get()
      ->map(function ($item) {
        $monthNames = [
          1 => 'January',
          2 => 'February',
          3 => 'March',
          4 => 'April',
          5 => 'May',
          6 => 'June',
        ];

        $item->month = $monthNames[$item->month] ?? $item->month;
        return $item;
      });


    // $cashFlowSpendvender = DB::table('vendorlist')
    //   ->selectRaw('MONTH(approvedate) as month, YEAR(approvedate) as year, SUM(amount) as total_amounts')
    //   ->where('status', 1)
    //   ->where(function ($query) use ($financialEndYear, $financialStartYear) {
    //     // Jan to Mar from next year
    //     $query->where(function ($q) use ($financialEndYear) {
    //       $q->whereYear('approvedate', $financialEndYear)
    //         ->whereIn(DB::raw('MONTH(approvedate)'), [1, 2, 3]);
    //     })
    //       // Apr to Jun from current year
    //       ->orWhere(function ($q) use ($financialStartYear) {
    //         $q->whereYear('approvedate', $financialStartYear)
    //           ->whereIn(DB::raw('MONTH(approvedate)'), [4, 5, 6]);
    //       });
    //   })
    //   ->groupByRaw('MONTH(approvedate), YEAR(approvedate)')
    //   ->orderByRaw('FIELD(MONTH(approvedate), 1, 2, 3, 4, 5, 6)')
    //   ->get()
    //   ->map(function ($item) {
    //     $monthNames = [
    //       1 => 'January',
    //       2 => 'February',
    //       3 => 'March',
    //       4 => 'April',
    //       5 => 'May',
    //       6 => 'June',
    //     ];
    //     $item->month = $monthNames[$item->month] ?? $item->month;
    //     return $item;
    //   });

    
    // $cashFlowSpendemployee = DB::table('employeepayrolls')
    //   ->select(
    //     'month',
    //     'year',
    //     DB::raw('SUM(total_amount_to_paid) as total_amount')
    //   )
    //   ->where(function ($query) use ($financialEndYear, $financialStartYear) {
    //     // Jan to Mar from next year
    //     $query->where(function ($q) use ($financialEndYear) {
    //       $q->where('year', $financialEndYear)
    //         ->whereIn('month', ['January', 'February', 'March']);
    //     })
    //       // Apr to Jun from current year
    //       ->orWhere(function ($q) use ($financialStartYear) {
    //         $q->where('year', $financialStartYear)
    //           ->whereIn('month', ['April', 'May', 'June']);
    //       });
    //   })
    //   ->where('send_to_bank', 1)
    //   ->groupBy('year', 'month')
    //   ->orderByRaw("FIELD(month, 'January', 'February', 'March', 'April', 'May', 'June')")
    //   ->get();


    $cashFlowSpendvender = DB::table('vendorlist')
      ->selectRaw('MONTH(approvedate) as month, YEAR(approvedate) as year, SUM(amount) as total_amounts')
      ->where('status', 1)
      ->where(function ($query) use ($financialEndYear, $financialStartYear) {
        $query->where(function ($q) use ($financialEndYear) {
          $q->whereYear('approvedate', $financialEndYear)
            ->whereIn(DB::raw('MONTH(approvedate)'), [1, 2, 3]);
        })->orWhere(function ($q) use ($financialStartYear) {
          $q->whereYear('approvedate', $financialStartYear)
            ->whereIn(DB::raw('MONTH(approvedate)'), [4, 5, 6]);
        });
      })
      ->groupByRaw('MONTH(approvedate), YEAR(approvedate)')
      ->orderByRaw('FIELD(MONTH(approvedate), 1,2,3,4,5,6)')
      ->get()
      ->map(function ($item) {
        $monthNames = [
          1 => 'January',
          2 => 'February',
          3 => 'March',
          4 => 'April',
          5 => 'May',
          6 => 'June',
        ];
        $item->month = $monthNames[$item->month] ?? $item->month;
        return $item;
      });

    $cashFlowSpendemployee = DB::table('employeepayrolls')
      ->select('month', 'year', DB::raw('SUM(total_amount_to_paid) as total_amounts'))
      ->where(function ($query) use ($financialEndYear, $financialStartYear) {
        $query->where(function ($q) use ($financialEndYear) {
          $q->where('year', $financialEndYear)
            ->whereIn('month', ['January', 'February', 'March']);
        })->orWhere(function ($q) use ($financialStartYear) {
          $q->where('year', $financialStartYear)
            ->whereIn('month', ['April', 'May', 'June']);
        });
      })
      ->where('send_to_bank', 1)
      ->groupBy('year', 'month')
      ->orderByRaw("FIELD(month, 'January', 'February', 'March', 'April', 'May', 'June')")
      ->get();


    $merged = $cashFlowSpendvender->merge($cashFlowSpendemployee);

    $newmergedata = $merged->groupBy(function ($item) {
      return $item->month . '-' . $item->year;
    })->map(function ($group) {
      return (object) [
        'month' => $group->first()->month,
        'year' => $group->first()->year,
        'total_amounts' => $group->sum('total_amounts'),
      ];
    })->sortBy(function ($item) {
      $order = ['January', 'February', 'March', 'April', 'May', 'June'];
      return array_search($item->month, $order);
    })->values();


    dd($newmergedata);



$teamsSalaries = DB::table('employeepayrolls')
    ->select(
        'month',
        'year',
        DB::raw('SUM(total_amount_to_paid) as total_amount')
    )
    ->where(function ($query) use ($janToMarYear, $fyStartYear) {
        // Jan-Mar from next year
        $query->where(function ($q) use ($janToMarYear) {
            $q->where('year', $janToMarYear)
              ->whereIn('month', ['January', 'February', 'March']);
        })
        // Apr-Jun from current FY year
        ->orWhere(function ($q) use ($fyStartYear) {
            $q->where('year', $fyStartYear)
              ->whereIn('month', ['April', 'May', 'June']);
        });
    })
    ->where('send_to_bank', 0)
    ->groupBy('year', 'month') // group by both year and month
    ->orderByRaw("FIELD(month, 'January', 'February', 'March', 'April', 'May', 'June')")
    ->get();



$fyStartYear = now()->month >= 4 ? now()->year : now()->year - 1;
$janToMarYear = $fyStartYear + 1;

// Single query for salary data (Jan-Jun)
$teamsSalaries = DB::table('employeepayrolls')
    ->select(
        'month',
        DB::raw('SUM(total_amount_to_paid) as total_amount'),
        DB::raw('CASE 
            WHEN month IN ("January", "February", "March") THEN '.$janToMarYear.' 
            ELSE '.$fyStartYear.' 
        END as year')
    )
    ->where(function($query) use ($fyStartYear, $janToMarYear) {
        $query->where('year', $fyStartYear)
              ->whereIn('month', ['April', 'May', 'June']);
    })
    ->orWhere(function($query) use ($fyStartYear, $janToMarYear) {
        $query->where('year', $janToMarYear)
              ->whereIn('month', ['January', 'February', 'March']);
    })
    ->where('send_to_bank', 0)
    ->groupBy('month', 'year')
    ->orderByRaw("FIELD(month, 'January', 'February', 'March', 'April', 'May', 'June')")
    ->get();

// Single query for exceptional expenses
$teamexceptionalExpenses = DB::table('outstationconveyances')
    ->select(
        DB::raw('MONTHNAME(approveddate) as month'),
        DB::raw('SUM(finalamount) as total_amount'),
        DB::raw('YEAR(approveddate) as year')
    )
    ->where('status', 1)
    ->where(function($query) use ($fyStartYear, $janToMarYear) {
        $query->whereYear('approveddate', $fyStartYear)
              ->whereMonth('approveddate', '>=', 4)
              ->whereMonth('approveddate', '<=', 6);
    })
    ->orWhere(function($query) use ($fyStartYear, $janToMarYear) {
        $query->whereYear('approveddate', $janToMarYear)
              ->whereMonth('approveddate', '>=', 1)
              ->whereMonth('approveddate', '<=', 3);
    })
    ->groupBy(DB::raw('MONTH(approveddate)'), DB::raw('YEAR(approveddate)'))
    ->orderByRaw("FIELD(MONTH(approveddate), 1, 2, 3, 4, 5, 6)")
    ->get();



    111111

    $fyStartYear = now()->month >= 4 ? now()->year : now()->year - 1;
$janToMarYear = $fyStartYear + 1;

// Single query for salary data (Jan-Jun)
$teamsSalaries = DB::table('employeepayrolls')
    ->select(
        'month',
        DB::raw('SUM(total_amount_to_paid) as total_amount')
    )
    ->where(function($query) use ($janToMarYear, $fyStartYear) {
        // Jan-Mar from next year
        $query->where('year', $janToMarYear)
              ->whereIn('month', ['January', 'February', 'March']);
        
        // Apr-Jun from current FY year
        $query->orWhere('year', $fyStartYear)
              ->whereIn('month', ['April', 'May', 'June']);
    })
    ->where('send_to_bank', 0)
    ->groupBy('month')
    ->orderByRaw("FIELD(month, 'January', 'February', 'March', 'April', 'May', 'June')")
    ->get();

// Single query for exceptional expenses
$teamexceptionalExpenses = DB::table('outstationconveyances')
    ->select(
        DB::raw("CASE 
            WHEN MONTH(approveddate) = 1 THEN 'January'
            WHEN MONTH(approveddate) = 2 THEN 'February'
            WHEN MONTH(approveddate) = 3 THEN 'March'
            WHEN MONTH(approveddate) = 4 THEN 'April'
            WHEN MONTH(approveddate) = 5 THEN 'May'
            WHEN MONTH(approveddate) = 6 THEN 'June'
        END as month"),
        DB::raw('SUM(finalamount) as total_amount')
    )
    ->where('status', 1)
    ->where(function($query) use ($janToMarYear, $fyStartYear) {
        $query->whereYear('approveddate', $janToMarYear)
              ->whereBetween(DB::raw('MONTH(approveddate)'), [1, 3]);
        
        $query->orWhereYear('approveddate', $fyStartYear)
              ->whereBetween(DB::raw('MONTH(approveddate)'), [4, 6]);
    })
    ->groupBy('month')
    ->orderByRaw("FIELD(month, 'January', 'February', 'March', 'April', 'May', 'June')")
    ->get();







     $fyStartYear = now()->month >= 4 ? now()->year : now()->year - 1;

    $janToMarYear = $fyStartYear + 1;
    $aprToJunYear = $fyStartYear;

    // --- Salary (Payroll) Data: Jan–Mar from next year, Apr–Jun from current FY year
    $janToMar = DB::table('employeepayrolls')
      ->select('month', DB::raw('SUM(total_amount_to_paid) as total_amount'))
      ->where('year', $janToMarYear)
      ->whereIn('month', ['January', 'February', 'March'])
      ->where('send_to_bank', 0)
      ->groupBy('month');

    $aprToJun = DB::table('employeepayrolls')
      ->select('month', DB::raw('SUM(total_amount_to_paid) as total_amount'))
      ->where('year', $aprToJunYear)
      ->whereIn('month', ['April', 'May', 'June'])
      ->where('send_to_bank', 0)
      ->groupBy('month');

    // Merge salary results manually
    $teamsSalaries = $janToMar
      ->unionAll($aprToJun)
      ->orderByRaw("FIELD(month, 'January', 'February', 'March', 'April', 'May', 'June')")
      ->get();

    // --- Exceptional Expenses Data
    $teamexceptionalExpenses1 = DB::table('outstationconveyances')
      ->selectRaw('MONTH(approveddate) as month, SUM(finalamount) as total_amount')
      ->where('status', 1)
      ->whereYear('approveddate', $janToMarYear)
      ->whereIn(DB::raw('MONTH(approveddate)'), [1, 2, 3])
      ->groupBy(DB::raw('MONTH(approveddate)'))
      ->get()
      ->map(function ($item) {
        $monthNames = [1 => 'January', 2 => 'February', 3 => 'March'];
        $item->month = $monthNames[$item->month] ?? $item->month;
        return $item;
      });

    $teamexceptionalExpenses2 = DB::table('outstationconveyances')
      ->selectRaw('MONTH(approveddate) as month, SUM(finalamount) as total_amount')
      ->where('status', 1)
      ->whereYear('approveddate', $aprToJunYear)
      ->whereIn(DB::raw('MONTH(approveddate)'), [4, 5, 6])
      ->groupBy(DB::raw('MONTH(approveddate)'))
      ->get()
      ->map(function ($item) {
        $monthNames = [4 => 'April', 5 => 'May', 6 => 'June'];
        $item->month = $monthNames[$item->month] ?? $item->month;
        return $item;
      });

    $teamexceptionalExpenses = $teamexceptionalExpenses1
      ->merge($teamexceptionalExpenses2)
      ->sortBy(function ($item) {
        $order = ['January', 'February', 'March', 'April', 'May', 'June'];
        return array_search($item->month, $order);
      })
      ->values();



  $timesheetOnClosedAssignment = DB::table('assignmentmappings')
    ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
    ->leftJoin('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
    ->leftJoin('timesheetusers', 'timesheetusers.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
    ->where('assignmentbudgetings.status', 1) // Closed assignments only
    ->whereRaw("DATE(timesheetusers.created) > DATE(COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate))")
    ->orderByDesc('assignmentbudgetings.id')
    ->select(
        'assignmentmappings.assignmentgenerate_id',
        'assignmentbudgetings.assignmentname',
        'assignmentbudgetings.status',
        DB::raw('COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate) as finalassignmentenddate'),
        'timesheetusers.created as timesheet_created',
        'clients.client_name'
    )
    ->get();
chat


$timesheetOnClosedAssignment = DB::table('assignmentmappings')
    ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
    ->leftJoin('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
    ->leftJoin('timesheetusers', 'timesheetusers.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
    ->select(
        'assignmentmappings.*',
        'assignmentbudgetings.assignmentname',
        'assignmentbudgetings.status',
        DB::raw('COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate) as finalassignmentenddate'),
        'clients.client_name',
        DB::raw('COUNT(timesheetusers.id) as late_timesheets_count')
    )
    ->whereNotNull('assignmentbudgetings.actualenddate') // Assignment is closed
    ->whereColumn('timesheetusers.created_at', '>', DB::raw('COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate)'))
    ->groupBy(
        'assignmentmappings.id',
        'assignmentbudgetings.assignmentname',
        'assignmentbudgetings.status',
        'finalassignmentenddate',
        'clients.client_name'
    )
    ->having('late_timesheets_count', '>', 0)
    ->get(); dip 


    $timesheetOnClosedAssignment = DB::table('assignmentmappings')
    ->select(
        'assignmentmappings.*',
        'assignmentbudgetings.assignmentname',
        'assignmentbudgetings.status',
        DB::raw('COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate) as finalassignmentenddate'),
        'clients.client_name'
    )
    ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
    ->leftJoin('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
    ->leftJoin('timesheetusers', 'timesheetusers.assignmentgenerate_id', '=', 'assignmentbudgetings.assignmentgenerate_id')
    ->where(function ($query) {
        $query->where('assignmentbudgetings.status', 1)
              ->orWhere(DB::raw('COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate)'), '<', Carbon::today()->toDateString());
    })
    ->havingRaw('MAX(timesheetusers.created_at) > COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate)')
    ->groupBy(
        'assignmentmappings.id',
        'assignmentbudgetings.assignmentname',
        'assignmentbudgetings.status',
        'clients.client_name',
        'assignmentmappings.assignmentgenerate_id'
    )
    ->orderByDesc('assignmentbudgetings.id')
    ->limit(10) // Adjust limit as needed
    ->get(); gr


   $id = '24-25';

    $financialYears = [
      '24-25' => ['start' => '2024-04-01', 'end' => '2025-03-31'],
      '23-24' => ['start' => '2023-04-01', 'end' => '2024-03-31'],
      '22-23' => ['start' => '2022-04-01', 'end' => '2023-03-31'],
    ];

    if (isset($financialYears[$id])) {
      $fyStartDate = $financialYears[$id]['start'];
      $fyEndDate = $financialYears[$id]['end'];
    }

    // Single query to fetch all required data with joins and aggregations
    $invoiceData = DB::table('assignmentbudgetings')
      ->select(
        'assignmentbudgetings.assignmentgenerate_id',
        'clients.client_name',
        'teammembers.team_member',
        'assignments.assignment_name',
        DB::raw('SUM(invoices.total) as total'),
        DB::raw('SUM(timesheetusers.totalhour * teammembers.cost_hour) as cost')
      )
      ->join('invoices', 'invoices.assignmentgenerate_id', '=', 'assignmentbudgetings.assignmentgenerate_id')
      ->join('teammembers', 'teammembers.id', '=', 'invoices.partner')
      ->join('assignments', 'assignments.id', '=', 'invoices.assignment_id')
      ->join('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
      ->leftJoin('timesheetusers', 'timesheetusers.assignmentgenerate_id', '=', 'assignmentbudgetings.assignmentgenerate_id')
      ->whereBetween('assignmentbudgetings.periodstartdate', [$fyStartDate, $fyEndDate])
      ->whereBetween('assignmentbudgetings.periodenddate', [$fyStartDate, $fyEndDate])
      ->groupBy(
        'assignmentbudgetings.assignmentgenerate_id',
        'clients.client_name',
        'teammembers.team_member',
        'assignments.assignment_name'
      )
      // ->limit(50)
      ->get();

    // Calculate profit/loss directly in the collection
    $invoiceData = $invoiceData->map(function ($invoice) {
      $invoice->profit_loss = ($invoice->total ?? 0) - ($invoice->cost ?? 0);
      return $invoice;
    });


    dd($invoiceData);


  $id = '24-25';

    // Define financial year range
    $financialYears = [
      '24-25' => ['start' => '2024-04-01', 'end' => '2025-03-31'],
      '23-24' => ['start' => '2023-04-01', 'end' => '2024-03-31'],
      '22-23' => ['start' => '2022-04-01', 'end' => '2023-03-31'],
    ];

    $fyStartDate = $financialYears[$id]['start'] ?? now()->startOfYear();
    $fyEndDate = $financialYears[$id]['end'] ?? now()->endOfYear();

    // STEP 1: Get invoice/assignment basic info
    $invoiceData = DB::table('assignmentbudgetings')
      ->join('invoices', 'invoices.assignmentgenerate_id', '=', 'assignmentbudgetings.assignmentgenerate_id')
      ->join('teammembers', 'teammembers.id', '=', 'invoices.partner')
      ->join('assignments', 'assignments.id', '=', 'invoices.assignment_id')
      ->join('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
      ->whereBetween('assignmentbudgetings.periodstartdate', [$fyStartDate, $fyEndDate])
      ->whereBetween('assignmentbudgetings.periodenddate', [$fyStartDate, $fyEndDate])
      ->select(
        'assignmentbudgetings.assignmentgenerate_id',
        'clients.client_name',
        'teammembers.id as partner_id',
        'teammembers.team_member',
        'assignments.assignment_name'
      )
      ->groupBy(
        'assignmentbudgetings.assignmentgenerate_id',
        'clients.client_name',
        'teammembers.id',
        'teammembers.team_member',
        'assignments.assignment_name'
      )
      // ->limit(50)
      ->get();

    $assignmentIds = $invoiceData->pluck('assignmentgenerate_id')->all();

    // STEP 2: Revenue (invoice totals)
    $invoiceTotals = DB::table('invoices')
      ->whereIn('assignmentgenerate_id', $assignmentIds)
      ->groupBy('assignmentgenerate_id')
      ->select('assignmentgenerate_id', DB::raw('SUM(total) as total'))
      ->pluck('total', 'assignmentgenerate_id'); // [assignment_id => total]

    // STEP 3: Timesheet hours grouped by assignment and user
    $timesheetData = DB::table('timesheetusers')
      ->whereIn('assignmentgenerate_id', $assignmentIds)
      ->groupBy('assignmentgenerate_id', 'createdby')
      ->select('assignmentgenerate_id', 'createdby', DB::raw('SUM(totalhour) as total_hour'))
      ->get();

    // STEP 4: Cost/hour for relevant teammembers
    $teamMemberCosts = DB::table('teammembers')
      ->whereIn('id', $timesheetData->pluck('createdby')->unique())
      ->pluck('cost_hour', 'id'); // [user_id => cost_hour]

    // STEP 5: Calculate cost and margin
    $groupedTime = $timesheetData->groupBy('assignmentgenerate_id');
    foreach ($invoiceData as $invoice) {
      $assignmentId = $invoice->assignmentgenerate_id;

      // Revenue
      $totalRevenue = $invoiceTotals[$assignmentId] ?? 0;
      $invoice->total = $totalRevenue;

      // Cost
      $totalCost = 0;
      if (isset($groupedTime[$assignmentId])) {
        foreach ($groupedTime[$assignmentId] as $row) {
          $rate = $teamMemberCosts[$row->createdby] ?? 0;
          $totalCost += $row->total_hour * $rate;
        }
      }

      $invoice->cost = $totalCost;
      $invoice->profit_loss = $totalRevenue - $totalCost;
    }


    
                                        <td style="padding: 17px;" class="text-success">
                                            @php
                                                $margin =
                                                    $invoiceDatas->total != 0
                                                        ? (($invoiceDatas->total - $invoiceDatas->cost) /
                                                                $invoiceDatas->total) *
                                                            100
                                                        : 0;
                                            @endphp
                                            {{ number_format($margin, 1) }}%
                                        </td>



















  // Partner-wise P&L Statement
        $invoiceData = DB::table('assignmentmappings')
            ->leftJoin('assignmentteammappings', 'assignmentmappings.id', '=', 'assignmentteammappings.assignmentmapping_id')
            ->leftJoin('teammembers', 'assignmentteammappings.teammember_id', '=', 'teammembers.id')
            ->leftJoin('clients', 'assignmentmappings.client_id', '=', 'clients.id')
            ->leftJoin('assignments', 'assignmentmappings.assignment_id', '=', 'assignments.id')
            ->select(
                'assignmentmappings.assignmentgenerate_id',
                'assignments.name as assignmentname',
                'clients.client_name',
                'assignmentmappings.engagementfee as total',
                'assignmentmappings.total_cost as cost',
                'teammembers.name as team_member'
            )
            ->get();

        $partnerProfitLoss = $invoiceData
            ->groupBy('team_member')
            ->map(function ($items, $partner) {
                $revenue = $items->sum('total');
                $cost = $items->sum('cost');
                $profit = $revenue - $cost;
                $margin = $revenue != 0 ? ($profit / $revenue) * 100 : 0;

                return [
                    'partner' => $partner,
                    'revenue' => $revenue,
                    'cost' => $cost,
                    'profit' => $profit,
                    'margin' => $margin,
                ];
            })->values();

        dd($partnerProfitLoss);

        $assignmentId = 473014864679;
        $totalAssignmentCost = DB::table('timesheetusers')
            ->leftJoin('teammembers', 'teammembers.id', '=', 'timesheetusers.createdby')
            ->where('timesheetusers.assignmentgenerate_id', $assignmentId)
            ->select(DB::raw('SUM(timesheetusers.totalhour * teammembers.cost_hour) as total_cost'))
            ->value('total_cost');
        dd($totalAssignmentCost);



        // Step 1: Fetch assignment cost data
$assignmentCosts = DB::table('timesheetusers')
    ->leftJoin('teammembers', 'teammembers.id', '=', 'timesheetusers.createdby')
    ->select('timesheetusers.assignmentgenerate_id', DB::raw('SUM(timesheetusers.totalhour * teammembers.cost_hour) as total_cost'))
    ->groupBy('timesheetusers.assignmentgenerate_id')
    ->pluck('total_cost', 'assignmentgenerate_id'); 


    // Step 2: Main assignment query
$assignmentprofitandlosses = DB::table('assignmentmappings')
    ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
    ->leftJoin('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
    ->orderByDesc('assignmentbudgetings.id')
    ->select(
        'assignmentmappings.*',
        'assignmentbudgetings.assignmentname',
        'assignmentbudgetings.status',
        'assignmentbudgetings.engagementfee',
        DB::raw('COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate) as finalassignmentenddate'),
        'clients.client_name'
    )
    ->get();

// Step 3: Attach cost to each assignment
foreach ($assignmentprofitandlosses as $assignment) {
    $assignment->total_cost = $assignmentCosts[$assignment->assignmentgenerate_id] ?? 0;
}


<td style="padding: 17px;">₹{{ number_format($assignmentprofitandloss->total_cost ?? 0) }}</td>
















    $ticketDatas = Assetticket::with(['financerequest', 'createdBy', 'partner'])
      ->whereIn('type', [0, 1])
      ->limit(4)
      ->get();


    $hrTickets = DB::table('tasks')
      ->select(
        'tasks.*',
        'patnerid.team_member as partnername',
        'createdby.team_member as createdbyname',
        'hrfunctions.hrfunction'
      )
      ->where('tasks.task_type', 4)
      ->leftJoin('teammembers as patnerid', 'patnerid.id', '=', 'tasks.partner_id')
      ->leftJoin('teammembers as createdby', 'createdby.id', '=', 'tasks.createdby')
      ->leftJoin('hrfunctions', 'hrfunctions.id', '=', 'tasks.hrfunction')
      ->orderByDesc('tasks.id')
      ->limit(4)
      ->get();

  
        $taskDatas = DB::table('tasks')
                    ->select('tasks.*', 'tm.team_member as partner', 'hrfunctions.hrfunction')
                    // hr
                    ->where('task_type', 4)
                    ->leftJoin('teammembers as tm', 'tm.id', 'tasks.partner_id')
                    ->leftJoin('teammembers as creater', 'creater.id', 'tasks.createdby')
                    ->leftJoin('roles', 'roles.id', 'creater.role_id')
                    ->leftJoin('hrfunctions', 'hrfunctions.id', 'tasks.hrfunction')
                    ->latest()
                    ->get();

                       $ticketDatas = Assetticket::with(['financerequest', 'createdBy', 'partner'])
                ->when($requestUrl === '/it-support', function ($query) {
                  it
                    return $query->where('type', '0');
                }, function ($query) {
                  finance
                    return $query->where('type', '1');
                })
                ->get();


                    dd('hh');

                    // for audt query 
            $taskDatas = DB::table('tasks')
                ->select('tasks.*', 'tm.team_member as partner')
                ->where('task_type', 5)
                ->leftJoin('teammembers as tm', 'tm.id', 'tasks.partner_id')
                ->latest()
                ->get();


                  // for data Analytics Query List

                   $taskDatas = DB::table('tasks')
                ->select('tasks.*', 'tm.team_member as partner')
                ->where('task_type', 6)
                ->leftJoin('teammembers as tm', 'tm.id', 'tasks.partner_id')
                ->latest()
                ->get();

                    $ticketDatas = Assetticket::with(['financerequest', 'createdBy', 'partner'])
      ->when($requestUrl === '/it-support', function ($query) {
        // it
        return $query->where('type', '0');
      }, function ($query) {
        // finance
        return $query->where('type', '1');
      })
      ->get();
  
    // $teammemberId = DB::table('teammembers')
    //   ->whereIn('staffcode', ['M1038', 'M1096', 'M1029', 'M1019', 'M1098', 'M1068', 'M1066', 'M1089', 'M1049', 'P1009', 'M1059'])
    //   ->pluck('id');

    // $timesheetdata = DB::table('timesheetusers')
    //   ->whereIn('createdby', $teammemberId)
    //   ->where('date', '2025-05-31')
    //   ->update([
    //     'client_id' => 33,
    //     'assignmentgenerate_id' => 'OFF100004',
    //     'partner' => 887,
    //     'totalhour' => 0,
    //     'assignment_id' => 213,
    //     'workitem' => '14th Saturday',
    //     'location' => 'N/A',
    //     'hour' => 0,
    //   ]);

    // $attendancesdata = DB::table('attendances')
    //   ->whereIn('employee_name', $teammemberId)
    //   ->where('month', 'May')
    //   ->where('year', '2025')
    //   ->get();

    // foreach ($attendancesdata as $attendances) {
    //   $updateddata = DB::table('attendances')
    //     ->where('id', $attendances->id)
    //     ->update([
    //       'thirtyone' => 'OH',
    //       'offholidays' => $attendances->offholidays + 1,
    //       'no_of_days_present' => $attendances->no_of_days_present - 1,

    //     ]);
    // }


    $staffCodes = ['M1038', 'M1096', 'M1029', 'M1019', 'M1098', 'M1068', 'M1066', 'M1089', 'M1049', 'P1009', 'M1059'];

    $teammemberIds = DB::table('teammembers')
      ->whereIn('staffcode', $staffCodes)
      ->pluck('id')
      ->toArray();

    if (!empty($teammemberIds)) {
      DB::table('timesheetusers')
        ->whereIn('createdby', $teammemberIds)
        ->where('date', '2025-05-31')
        ->update([
          'client_id' => 33,
          'assignmentgenerate_id' => 'OFF100004',
          'partner' => 887,
          'totalhour' => 0,
          'assignment_id' => 213,
          'workitem' => '14th Saturday',
          'location' => 'N/A',
          'hour' => 0,
        ]);

      $attendances = DB::table('attendances')
        ->whereIn('employee_name', $teammemberIds)
        ->where('month', 'May')
        ->where('year', '2025')
        ->get();

      foreach ($attendances as $record) {
        $newDaysPresent = max(0, $record->no_of_days_present - 1);

        DB::table('attendances')
          ->where('id', $record->id)
          ->update([
            'thirtyone' => 'OH',
            'offholidays' => $record->offholidays + 1,
            'no_of_days_present' => $newDaysPresent,
          ]);
      }
    } else {
      dd('No record find');
    }


  // $auditAcceptancePending = DB::table('independences')
    //   ->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', '=', 'independences.assignmentgenerate_id')
    //   ->where('independences.assignmentgenerate_id', '511958337401')
    //   ->get();

    // $clientspecificindependencedeclaration = DB::table('assignmentmappings')
    //   ->leftJoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
    //   ->leftJoin('teammembers', 'teammembers.id', 'assignmentteammappings.teammember_id')
    //   ->where('assignmentmappings.assignmentgenerate_id', '511958337401')
    //   ->select('teammembers.id', 'teammembers.team_member', 'assignmentmappings.assignmentgenerate_id')
    //   ->get();

    // $notFilledCount = 0;

    // foreach ($clientspecificindependencedeclaration as $independenceData) {
    //   $independence = DB::table('annual_independence_declarations')
    //     ->where('assignmentgenerateid', $independenceData->assignmentgenerate_id)
    //     ->where('createdby', $independenceData->id)
    //     ->where('type', 2)
    //     ->first();

    //   if ($independence) {
    //     $independenceArray = (array) $independence;
    //     if (in_array(1, $independenceArray)) {
    //       // Need Review
    //     } else {
    //       // Independent
    //     }
    //   } else {
    //     // Not Filled
    //     $notFilledCount++;
    //   }
    // }

    // dd($notFilledCount);

    $assignments = DB::table('assignmentmappings')
      ->leftJoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
      ->leftJoin('teammembers', 'teammembers.id', 'assignmentteammappings.teammember_id')
      ->select('assignmentmappings.assignmentgenerate_id', 'teammembers.id as teammember_id', 'teammembers.team_member')
      ->get();

    $groupedAssignments = $assignments->groupBy('assignmentgenerate_id');

    $notFilledCounts = [];

    foreach ($groupedAssignments as $assignmentId => $teamMembers) {
      $notFilled = 0;

      foreach ($teamMembers as $member) {
        $independence = DB::table('annual_independence_declarations')
          ->where('assignmentgenerateid', $assignmentId)
          ->where('createdby', $member->teammember_id)
          ->where('type', 2)
          ->first();

        if (!$independence) {
          $notFilled++;
        }
      }

      $notFilledCounts[$assignmentId] = $notFilled;
    }

    $totalNotFilled = array_sum($notFilledCounts);

    dd([
      'notFilledCounts' => $notFilledCounts,
      'totalNotFilled' => $totalNotFilled,
    ]);

      $conveyancecosting = DB::table('outstationconveyances')
            ->leftJoin('teammembers', 'teammembers.id', '=', 'outstationconveyances.createdby')
            ->where('outstationconveyances.assignmentgenerate_id', $id)
            ->wherein('outstationconveyances.Status', [1, 6])->get();


              $assignmentData = DB::table('assignmentbudgetings')
                ->join('clients', 'clients.id', 'assignmentbudgetings.client_id')
                ->join('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
                ->join('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
                ->join('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
                ->where('assignmentbudgetings.assignmentgenerate_id', $assignmentgenerate)
                ->select(
                    'assignmentbudgetings.*',
                    'assignmentmappings.*',
                    'clients.client_name',
                    'assignments.assignment_name',
                    'teammembers.team_member as partnername'
                )
                ->first();

    $assignmentMapping = DB::table('assignmentmappings')
                ->where('assignmentgenerate_id', $assignmentId)
                ->select('assignment_id', 'eqcrapplicability')
                ->first();

            // Determine EQCR type name
            $eqcrTypeName = '';
            $eqcrAssignmentId = null;
            if (isset($assignmentMapping->eqcrapplicability)) {
                switch ($assignmentMapping->eqcrapplicability) {
                    case 1:
                        $eqcrTypeName = 'NFRA';
                        break;
                    case 2:
                        $eqcrTypeName = 'Quality Review';
                        break;
                    case 3:
                        $eqcrTypeName = 'Peer Review';
                        break;
                    case 4:
                        $eqcrTypeName = 'Others';
                        break;
                    case 5:
                        $eqcrTypeName = 'PCAOB';
                        break;
                }
                // Get the assignment_id for the EQCR type
                $specialAssignment = DB::table('assignments')
                    ->where('assignment_name', $eqcrTypeName)
                    ->first();
                if ($specialAssignment) {
                    $eqcrAssignmentId = $specialAssignment->id;
                }
            }

      $assignmentMapping = DB::table('assignmentmappings')
        ->where('assignmentgenerate_id', $assignmentId)
        ->select('assignment_id', 'eqcrapplicability')
        ->first();


   public function assignmentpandl(Request $request)
    {
        //dd($id);
        $invoiceData =
            DB::table('assignmentbudgetings')
            ->select(
                'assignmentbudgetings.assignmentgenerate_id',
                'clients.client_name',
                'teammembers.team_member',
                'assignments.assignment_name'
            )
            ->join('invoices', 'invoices.assignmentgenerate_id', '=', 'assignmentbudgetings.assignmentgenerate_id')
            ->leftJoin('teammembers', 'teammembers.id', '=', 'invoices.partner')
            ->leftJoin('assignments', 'assignments.id', '=', 'invoices.assignment_id')
            ->leftJoin('clients', 'clients.id', '=', 'invoices.client_id')

            ->where('invoices.financialyear', $request->fy)
            ->where('invoices.assignment_id', $request->assignment_id)
            ->groupBy(
                'assignmentbudgetings.assignmentgenerate_id',
                'clients.client_name',
                'teammembers.team_member',
                'assignments.assignment_name'
            )
            ->get();


        $partner = DB::table('invoices')
            ->leftjoin('teammembers', 'teammembers.id', 'invoices.partner')
            ->select('teammembers.team_member', 'teammembers.id')
            ->where('invoices.financialyear', $request->fy)->distinct('teammembers.team_member')->get();

        $assignments = DB::table('invoices')
            ->join('assignments', 'assignments.id', 'invoices.assignment_id')
            ->select('assignments.id', 'assignments.assignment_name')
            ->where('invoices.financialyear', $request->fy)->distinct('assignments.assignment_name')->get();
        $id = $request->fy;
        return view('backEnd.assignment.assignmentfinalreport', compact('invoiceData', 'partner', 'id', 'assignments'));
    }

   public function create(Request $request)
  {

    $teammember = Teammember::where('role_id', 13)->with('title', 'role')->where('status', 1)->get();
    $staffData = Teammember::where('role_id', '!=', 11)->where('role_id', '!=', 12)->with('title', 'role')->where('status', 1)->get();
    //  dd($staffData);
    if (auth()->user()->role_id == 15) {
      $teammemberpartner = Teammember::where('role_id', '=', 13)->orwhere('role_id', '=', 14)->orwhere('role_id', '=', 18)->where('status', 1)->with('title', 'role')->get();
    } elseif (auth()->user()->role_id == 13) {
      $teammemberpartner = Teammember::where('role_id', '=', 13)->orwhere('role_id', '=', 14)->where('status', 1)->with('title', 'role')->get();
    } else {
      $teammemberpartner = Teammember::where('role_id', '=', 13)->orwhere('role_id', '=', 14)->where('status', 1)->with('title', 'role')->get();
    }
    $clientData = DB::table('clients')->select('id', 'client_name')->get();
    $assignment = Assignment::select('id', 'assignment_name')->get();

    if ($request->ajax()) {
      //  dd($request);
      if (isset($request->cid)) {
        echo "<option>Select Assignment</option>";
        foreach (
          DB::table('assignmentbudgetings')
            ->leftjoin('invoices', 'invoices.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
            ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
            ->where('invoices.client_id', $request->cid)
            ->where('invoices.year', '=', '2023')
            ->select('assignmentbudgetings.assignmentgenerate_id', 'assignments.assignment_name')
            ->orderBy('assignment_name')->get() as $sub
        ) {
          echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . "(" . $sub->assignmentgenerate_id . ")" .
            "</option>";
        }
      }
      if (isset($request->assignment)) {
        echo "<option>Select Partner</option>";
        foreach (
          DB::table('assignmentmappings')
            ->leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
            ->where('assignmentgenerate_id', $request->assignment)->select('teammembers.id', 'teammembers.team_member')->get() as $sub
        ) {

          echo "<option value='" . $sub->id . "'>" . $sub->team_member . "</option>";
        }
      }
    } else {
      return view('backEnd.assignmentevaluation.create', compact('teammember', 'clientData', 'assignment', 'teammemberpartner', 'staffData'));
    }
  }

    public function paymentSearch(Request $request)
    {
        // dd($request);
        // $ds = date('Y-m-d', strtotime(date('Y-m-d', strtotime($request->enddate . ' + 1 day' . ' + 1 day'))));
        // dd($ds );
        $paymentDatas  =  DB::table('payments')
            ->join('invoices', 'invoices.invoice_id', 'payments.invoiceid')
            ->leftjoin('clients', 'clients.id', 'invoices.client_id')
            ->where('payments.paymentdate', '>=', date('Y-m-d', strtotime($request->startdate)))->where('paymentdate', '<', date('Y-m-d', strtotime($request->enddate . ' + 1 day')))
            ->select('payments.*', 'clients.client_name', 'invoices.total', 'invoices.invoicedate')->get();
        //   dd($paymentDatas);
        $amountcheck = DB::table('payments')->where('paymentdate', '>=', date('Y-m-d', strtotime($request->startdate)))->where('paymentdate', '<', date('Y-m-d', strtotime($request->enddate . ' + 1 day')))->sum('amountreceived');
        $amounttds = DB::table('payments')->where('paymentdate', '>=', date('Y-m-d', strtotime($request->startdate)))->where('paymentdate', '<', date('Y-m-d', strtotime($request->enddate . ' + 1 day')))->sum('tds');
        $roundoff = DB::table('payments')->where('paymentdate', '>=', date('Y-m-d', strtotime($request->startdate)))->where('paymentdate', '<', date('Y-m-d', strtotime($request->enddate . ' + 1 day')))->sum('roundoff');
        $tdscgst = DB::table('payments')->where('paymentdate', '>=', date('Y-m-d', strtotime($request->startdate)))->where('paymentdate', '<', date('Y-m-d', strtotime($request->enddate . ' + 1 day')))->sum('tdscgst');
        $tdsigst = DB::table('payments')->where('paymentdate', '>=', date('Y-m-d', strtotime($request->startdate)))->where('paymentdate', '<', date('Y-m-d', strtotime($request->enddate . ' + 1 day')))->sum('tdsigst');
        $tdssgst = DB::table('payments')->where('paymentdate', '>=', date('Y-m-d', strtotime($request->startdate)))->where('paymentdate', '<', date('Y-m-d', strtotime($request->enddate . ' + 1 day')))->sum('tdssgst');
        $totalreceived = $amountcheck +  $amounttds + $roundoff + $tdscgst + $tdsigst +
            $tdssgst;
        //$totalreceived = DB::table('payments')
        //     ->sum(\DB::raw('amountreceived + tds'));
        //dd($paymentDatas); die;
        return view('backEnd.payment.index', compact('paymentDatas', 'totalreceived'));
    }

   public function assignment_costing($id)
    {
        $assignmentbudgetingDatas = DB::table('assignmentbudgetings')
            ->join('clients', 'clients.id', 'assignmentbudgetings.client_id')
            ->join('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
            ->join('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
            ->where('assignmentbudgetings.assignmentgenerate_id', $id)
            ->select(
                'assignmentbudgetings.*',
                'assignmentmappings.*',
                'clients.client_name',
                'assignments.assignment_name'
            )->first();

        $conveyancecosting = DB::table('outstationconveyances')
            ->leftJoin('teammembers', 'teammembers.id', '=', 'outstationconveyances.createdby')
            ->where('outstationconveyances.assignmentgenerate_id', $id)
            ->wherein('outstationconveyances.Status', [1, 6])->get();

        //  dd($assignmentbudgetingDatas);
        $invoicecosting = DB::table('invoices')->where('assignmentgenerate_id', $id)->get();
        $invoicecostingtotal = DB::table('invoices')->where('assignmentgenerate_id', $id)->sum('total');
        $assignmentbudgetings = DB::table('assignmentmappings')
            ->where('assignmentgenerate_id', $id)->first();

        //  dd($assignmentbudgetings);
        $costing = DB::table('timesheetusers')
            ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
            ->select('timesheetusers.createdby', DB::raw('SUM(totalhour) as total_hour'))
            ->where('timesheetusers.assignmentgenerate_id', $id)
            ->groupBy('timesheetusers.createdby')
            ->get();
        // dd($costing);
        //  DB::table('assignmentmappings')
        //       ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
        //     ->leftjoin('teammembers','teammembers.id', 'assignmentteammappings.teammember_id')
        //    ->leftjoin('timesheetusers','timesheetusers.createdby', 'teammembers.id')

        //  ->select('teammembers.team_member', DB::raw('SUM(timesheetusers.hour) as total_hours'))

        // ->groupBy('teammembers.team_member')
        //	    ->where('assignmentteammappings.assignmentmapping_id',$assignmentbudgetings->id)
        //   ->where('assignmentmappings.assignmentgenerate_id',$id)
        //  ->get();

        return view('backEnd.assignmentmapping.assignmentcosting', compact('conveyancecosting', 'invoicecosting', 'costing', 'invoicecostingtotal', 'assignmentbudgetingDatas', 'id'));
    }


    public function modifyColumn(Request $request)
    {
        $oldKey = Str::snake(trim($request->input('oldcolumnName')));
        $newKey = Str::snake(trim($request->input('newcolumnName')));
        $teamId = $request->input('teamId');
        $kraId = $request->input('kraId1');

        $originalRecord = DB::table('krasdata')->where('id', $kraId)->first();

        $draftRecord = DB::table('krasdata')
            ->where('teamid', $teamId)
            ->where('designation_id', $originalRecord->designation_id)
            ->where('is_draft', 1)
            ->first();

        if (!$draftRecord) {
            $draftRecordId = DB::table('krasdata')->insertGetId([
                'createdby' => auth()->user()->teammember_id,
                'data' => $originalRecord->data,
                'designation_id' => $originalRecord->designation_id,
                'teamid' => $teamId,
                'year' => now()->year,
                'is_draft' => 1,
                'is_active' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $draftRecord = DB::table('krasdata')->where('id', $draftRecordId)->first();
        }

        $data = json_decode($draftRecord->data, true);

        foreach ($data as &$item) {
            if (array_key_exists($oldKey, $item)) {
                $newItem = [];

                foreach ($item as $key => $value) {
                    if ($key === $oldKey) {
                        $newItem[$newKey] = $value;
                    } else {
                        $newItem[$key] = $value;
                    }
                }
                $item = $newItem;
            }
        }


        DB::table('krasdata')
            ->where('id', $draftRecord->id)
            ->update([
                'data' => json_encode($data),
                'updated_at' => now()
            ]);

        //     $checkRecord = DB::table('krasdata')
        //         ->where('designation_id', $record->designation_id)
        //         ->where('teamid', $teamId)
        //         ->first();;


        //     if ($checkRecord) {
        //         DB::table('krasdata')
        //             ->where('id', $id)
        //             ->update([
        //                 'data' => json_encode($data),
        //                 'updated_at' => now()
        //             ]);
        //     } else {
        //         $krasdata_id = DB::table('krasdata')->insertGetId([
        //             'createdby' => auth()->user()->teammember_id,
        //             'data' => json_encode($data),
        //             'designation_id' => $record->designation_id,
        //             'teamid' => $teamId,
        //             'year' => now()->year,
        //             'created_at' => $record->created_at,
        //             'updated_at' => now()
        //         ]);

        //         DB::table('krasteam')->where('teamid', $teamId)->update([
        //             'krasdata_id' => $krasdata_id,
        //             'updated_at' => now()
        //         ]);
        //     }

        return redirect()->route('kras.show', ['id' => $teamId, 'designation' => $originalRecord->designation_id])->with('success', 'Column renamed in draft successfully.');
    }

 public function allteamsubmitted()
  {
    // Fetch all necessary data in a single query
    $get_datess = DB::table('timesheetreport')
      ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
      ->leftJoin('teamrolehistory', function ($join) {
        $join->on('teamrolehistory.teammember_id', '=', 'teammembers.id')
          ->on('teamrolehistory.created_at', '<', 'timesheetreport.created_at');
      })
      ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
      // ->where('timesheetreport.teamid', 888)
      ->select(
        'timesheetreport.*',
        'teamrolehistory.newstaff_code',
        'teammembers.team_member',
        'teammembers.staffcode',
        'partners.team_member as partnername',
        'teammembers.emailid'
      )
      ->latest()
      // ->limit(10)
      ->get();
    // dd($get_datess);

    $permissiontimesheet = DB::table('timesheetreport')->first();

    // Map and group data
    $groupedData = $get_datess->groupBy(function ($item) {
      return $item->team_member . '|' . $item->week;
    })->map(function ($group) {
      $firstItem = $group->first();

      return (object)[
        'id' => $firstItem->id,
        'teamid' => $firstItem->teamid,
        'week' => $firstItem->week,
        'totaldays' => $group->sum('totaldays'),
        'totaltime' => $group->sum('totaltime'),
        'dayscount' => $group->sum('dayscount'),
        'startdate' => $firstItem->startdate,
        'enddate' => $firstItem->enddate,
        'partnername' => $firstItem->partnername,
        'created_at' => $firstItem->created_at,
        'team_member' => $firstItem->team_member,
        // Use newstaff_code if available, otherwise staffcode
        'staffcode' => $firstItem->newstaff_code ?? $firstItem->staffcode,
        'partnerid' => $firstItem->partnerid,
      ];
    });

    $get_date = collect($groupedData->values());

    return view('backEnd.timesheet.myteamindex', compact('get_date', 'permissiontimesheet'));
  }
  public function adminsearchtimesheet(Request $request)
  {
    if ($request->ajax()) {
      echo "<option value='null'>Select Assignment</option>";
      $assignments = DB::table('assignmentbudgetings')
        ->where('assignmentbudgetings.client_id', $request->cid)
        ->leftJoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
        ->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
        ->orderBy('assignment_name')
        ->get();

      foreach ($assignments as $sub) {
        echo "<option value='{$sub->assignmentgenerate_id}'>{$sub->assignment_name} ({$sub->assignmentname}) ({$sub->assignmentgenerate_id})</option>";
      }
      return;
    }

    $startDate = $request->input('startdate');
    $endDate = $request->input('enddate');
    $teamId = $request->input('teamid');
    $teammemberId = $request->input('teammemberId');
    $clientId = $request->input('clientId');
    $assignmentId = $request->input('assignmentId') !== 'null' ? $request->input('assignmentId') : null;

    $targetClients = [29, 34, 32, 33, 134];

    $teammembers = DB::table('teammembers')
      ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
      ->where('teammembers.status', 1)
      ->whereIn('teammembers.role_id', [14, 15, 13, 11])
      ->select('teammembers.team_member', 'teamrolehistory.newstaff_code', 'teammembers.id', 'teammembers.staffcode')
      ->orderBy('team_member', 'ASC')
      ->get();

    $clientsname = DB::table('clients')
      ->whereIn('status', [0, 1])
      ->select('id', 'client_name', 'client_code')
      ->orderBy('client_name', 'ASC')
      ->get();

    $assignmentsname = DB::table('timesheetusers')
      ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'timesheetusers.assignmentgenerate_id')
      ->whereIn('timesheetusers.status', [1, 2, 3])
      ->whereNotNull('assignmentbudgetings.assignmentname')
      ->select('timesheetusers.assignmentgenerate_id', 'assignmentbudgetings.assignmentname')
      ->distinct()
      ->orderBy('assignmentname', 'ASC')
      ->get();

    if (!in_array(auth()->user()->role_id, [11, 13])) {
      $output = array('msg' => 'Unauthorized access');
      return back()->with('statuss', $output);
    }

    // Base query
    $query = DB::table('timesheetusers')
      ->leftJoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
      ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'timesheetusers.assignmentgenerate_id')
      ->leftJoin('teamrolehistory as teamrolehistoryteam', function ($join) {
        $join->on('teamrolehistoryteam.teammember_id', '=', 'teammembers.id')
          ->whereRaw('teamrolehistoryteam.created_at < assignmentbudgetings.created_at');
      })
      ->leftJoin('clients', 'clients.id', 'timesheetusers.client_id')
      ->leftJoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
      ->leftJoin('teammembers as patnerid', 'patnerid.id', 'timesheetusers.partner')
      ->leftJoin('teamrolehistory', function ($join) {
        $join->on('teamrolehistory.teammember_id', '=', 'patnerid.id')
          ->whereRaw('teamrolehistory.created_at < assignmentbudgetings.created_at');
      })
      ->whereIn('timesheetusers.status', [1, 2, 3])
      ->select(
        'timesheetusers.*',
        'assignments.assignment_name',
        'clients.client_name',
        'clients.client_code',
        'teammembers.team_member',
        'teammembers.staffcode',
        'patnerid.team_member as patnername',
        'patnerid.staffcode as patnerstaffcodee',
        'assignmentbudgetings.assignmentname',
        'teamrolehistory.newstaff_code as ptnrstaffcode',
        'teamrolehistoryteam.newstaff_code as teamnewstaffcode',
        'assignmentbudgetings.created_at as assignmentcreated'
      )
      ->orderBy('date', 'DESC');

    // if ($startDate && $endDate) {
    //   $query->whereBetween('timesheetusers.date', [$startDate, $endDate]);

    //   if ($teammemberId) {
    //     $query->where('timesheetusers.createdby', $teammemberId);
    //   } elseif ($clientId) {
    //     $query->where('timesheetusers.client_id', $clientId);
    //   } elseif ($assignmentId) {
    //     $query->where('timesheetusers.assignmentgenerate_id', $assignmentId);
    //   }
    // }

    if ($startDate && $endDate) {
      $query->whereBetween('timesheetusers.date', [$startDate, $endDate]);
      if ($teammemberId) {
        $query->where('timesheetusers.createdby', $teammemberId);
      }
      if ($clientId) {
        $query->where('timesheetusers.client_id', $clientId);
      }
      if ($assignmentId) {
        $query->where('timesheetusers.assignmentgenerate_id', $assignmentId);
      }
    }

    $timesheetData = $query->get();

    $createdbyIds = $timesheetData->pluck('createdby')->unique()->toArray();

    $promotionData = DB::table('teamrolehistory')
      ->whereIn('teammember_id', $createdbyIds)
      ->select('teammember_id', 'newstaff_code', 'created_at')
      ->get()
      ->keyBy('teammember_id');

    $partnerIds = $timesheetData->pluck('partner')->unique()->filter()->values();

    $promotionChecksPartner = DB::table('teamrolehistory')
      ->whereIn('teammember_id', $partnerIds)
      ->select('teammember_id', 'newstaff_code', 'created_at')
      ->get()
      ->keyBy('teammember_id')
      ->map(fn($row) => [
        'newstaff_code' => $row->newstaff_code,
        'promotion_date' => Carbon::parse($row->created_at)->startOfDay(),
      ]);

    $timesheetData = $timesheetData->map(function ($row) use ($targetClients, $promotionData, $promotionChecksPartner) {
      $row->final_staffcode = $row->teamnewstaffcode ?? $row->staffcode ?? '';

      if (in_array($row->client_id, $targetClients) && $row->date) {
        $dataDate = Carbon::parse($row->date)->startOfDay();
        $promotion = $promotionData[$row->createdby] ?? null;

        if ($promotion && $dataDate->greaterThanOrEqualTo(Carbon::parse($promotion->created_at)->startOfDay())) {
          $row->final_staffcode = $promotion->newstaff_code;
        } else {
          $row->final_staffcode = $row->staffcode ?? '';
        }
      }

      $row->final_partnerstaffcode = $row->ptnrstaffcode ?? $row->patnerstaffcodee ?? '';
      if (in_array($row->client_id, $targetClients) && $row->date) {
        $dataDate = Carbon::parse($row->date)->startOfDay();
        $promotionPartner = $promotionChecksPartner->get($row->partner);
        if ($promotionPartner && $dataDate->greaterThanOrEqualTo($promotionPartner['promotion_date'])) {
          $row->final_partnerstaffcode = $promotionPartner['newstaff_code'];
        } else {
          $row->final_partnerstaffcode = $row->ptnrstaffcode ?? $row->patnerstaffcodee ?? '';
        }
      }
      return $row;
    });

    $request->flash();
    return view('backEnd.timesheet.timesheetdownload', compact('timesheetData', 'teammembers', 'clientsname', 'assignmentsname', 'assignmentId'));
  }

  public function totalworkingdays(Request $request, $teamid)
  {

    // total working days startfrom january to december 
    $currentDate = Carbon::now();
    $currentMonth = $currentDate->format('F');
    $startDate = Carbon::create($currentDate->year, 1, 1);
    $endDate = Carbon::create($currentDate->year, 12, 31);

    // $startDate = Carbon::create('01-04-2024');
    // $endDate = Carbon::create('30-09-2024');

    // $home = DB::table('timesheetusers')
    //   ->where('createdby', 847)
    //   ->whereIn('status', [1, 2, 3])
    //   ->whereNotIn('assignmentgenerate_id', ['OFF100004', 'OFF100003'])
    //   ->whereNotIn('client_id', [134])
    //   ->whereBetween('timesheetusers.date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
    //   ->select('date') // Select only the date column
    //   ->distinct() // Apply distinct on the selected columns
    //   ->get();

    // dd($home);

    

    // this is for promotion and rejoined user
    $targetClients = [29, 34, 32, 33, 134];
    $promotionCheck = DB::table('teamrolehistory')
      ->where('teammember_id', $teamid)
      ->select('newstaff_code', 'created_at')
      ->first();

    $promotionorRejoinDate = $promotionCheck
      ? Carbon::parse($promotionCheck->created_at)->startOfDay()
      : null;

    // dd($attendancesstartDate);
    $query = DB::table('timesheetusers')
      ->leftJoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
      ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'timesheetusers.assignmentgenerate_id')
      ->leftJoin('teamrolehistory as teamrolehistoryteam', function ($join) {
        $join->on('teamrolehistoryteam.teammember_id', '=', 'teammembers.id')
          ->whereRaw('teamrolehistoryteam.created_at < assignmentbudgetings.created_at');
      })
      ->leftJoin('clients', 'clients.id', 'timesheetusers.client_id')
      ->leftJoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
      ->leftJoin('teammembers as patnerid', 'patnerid.id', 'timesheetusers.partner')
      ->leftJoin('teamrolehistory', function ($join) {
        $join->on('teamrolehistory.teammember_id', '=', 'patnerid.id')
          ->whereRaw('teamrolehistory.created_at < assignmentbudgetings.created_at');
      })
      ->where('timesheetusers.createdby', $teamid)
      ->whereIn('timesheetusers.status', [1, 2, 3])
      ->whereBetween('timesheetusers.date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
      // hide offholidays and travel timesheet
      ->whereNotIn('timesheetusers.assignmentgenerate_id', ['OFF100004', 'OFF100003'])
      // hide  casual leave and exam leave timesheet
      ->whereNotIn('timesheetusers.client_id', [134])
      ->select(
        'timesheetusers.*',
        'assignments.assignment_name',
        'clients.client_name',
        'clients.client_code',
        'teammembers.team_member',
        'teammembers.staffcode',
        'patnerid.team_member as patnername',
        'patnerid.staffcode as patnerstaffcodee',
        'assignmentbudgetings.assignmentname',
        'teamrolehistory.newstaff_code as ptnrstaffcode',
        'teamrolehistoryteam.newstaff_code as teamnewstaffcode',
        // 'assignmentbudgetings.created_at as assignmentcreateddate'
        'assignmentbudgetings.created_at as assignmentcreated'
      )
      ->orderBy('timesheetusers.date', 'DESC');

    // Apply filters for partner 
    if (auth()->user()->role_id == 13) {
    }

    $timesheetData = $query->get();

    $partnerIds = $timesheetData->pluck('partner')->unique()->filter()->values();

    $promotionChecksPartner = DB::table('teamrolehistory')
      ->whereIn('teammember_id', $partnerIds)
      ->select('teammember_id', 'newstaff_code', 'created_at')
      ->get()
      ->keyBy('teammember_id')
      ->map(fn($row) => [
        'newstaff_code' => $row->newstaff_code,
        'promotion_date' => Carbon::parse($row->created_at)->startOfDay(),
      ]);

    // this is for promotion and rejoined user (off/holidays,official travel etc )
    $timesheetData = $timesheetData->map(function ($row) use ($targetClients, $promotionCheck, $promotionorRejoinDate, $promotionChecksPartner) {
      $row->final_teamstaffcode = $row->teamnewstaffcode ?? $row->staffcode ?? '';
      if (in_array($row->client_id, $targetClients) && $row->date) {
        $dataDate = Carbon::parse($row->date)->startOfDay();
        if ($promotionCheck && $dataDate->greaterThanOrEqualTo($promotionorRejoinDate)) {
          $row->final_teamstaffcode = $promotionCheck->newstaff_code;
        } else {
          $row->final_teamstaffcode = $row->staffcode ?? '';
        }
      }

      $row->final_partnerstaffcode = $row->ptnrstaffcode ?? $row->patnerstaffcodee ?? '';
      if (in_array($row->client_id, $targetClients) && $row->date) {
        $dataDate = Carbon::parse($row->date)->startOfDay();
        $promotionPartner = $promotionChecksPartner->get($row->partner);
        if ($promotionPartner && $dataDate->greaterThanOrEqualTo($promotionPartner['promotion_date'])) {
          $row->final_partnerstaffcode = $promotionPartner['newstaff_code'];
        } else {
          $row->final_partnerstaffcode = $row->ptnrstaffcode ?? $row->patnerstaffcodee ?? '';
        }
      }

      return $row;
    });

    return view('backEnd.timesheet.totalworkingdays', compact('timesheetData'));
  }

   public function weeklylist(Request $request)
  {
    // dd($request);
    if (auth()->user()->role_id == 13) {
      $date = DB::table('timesheetreport')->where('id', $request->id)->first();
      $targetClients = [29, 34, 32, 33, 134];
      $promotionCheck = DB::table('teamrolehistory')
        ->where('teammember_id', $request->teamid)
        ->select('newstaff_code', 'created_at')
        ->first();

      $promotionorRejoinDate = $promotionCheck
        ? Carbon::parse($promotionCheck->created_at)->startOfDay()
        : null;

      $timesheetData = DB::table('timesheetusers')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'timesheetusers.assignmentgenerate_id')
        ->leftJoin('teamrolehistory as teamrolehistoryteam', function ($join) {
          $join->on('teamrolehistoryteam.teammember_id', '=', 'teammembers.id')
            ->whereRaw('teamrolehistoryteam.created_at < assignmentbudgetings.created_at');
        })
        ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
        ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
        ->leftjoin('teammembers as patnerid', 'patnerid.id', 'timesheetusers.partner')
        ->leftJoin('teamrolehistory', function ($join) {
          $join->on('teamrolehistory.teammember_id', '=', 'patnerid.id')
            ->whereRaw('teamrolehistory.created_at < assignmentbudgetings.created_at');
        })
        ->where('timesheetusers.createdby', $request->teamid)
        ->whereIn('timesheetusers.status', [1, 2, 3])
        ->whereNotNull('timesheetusers.date')
        ->where('timesheetusers.date', '>=', $date->startdate)
        ->where('timesheetusers.date', '<=', $date->enddate)
        ->select(
          'timesheetusers.*',
          'assignments.assignment_name',
          'clients.client_name',
          'clients.client_code',
          'teammembers.team_member',
          'teammembers.staffcode',
          'patnerid.team_member as patnername',
          'patnerid.staffcode as patnerstaffcodee',
          'assignmentbudgetings.assignmentname',
          'teamrolehistory.newstaff_code as ptnrstaffcode',
          'teamrolehistoryteam.newstaff_code as teamnewstaffcode',
          'assignmentbudgetings.created_at as assignmentcreated'
        )
        // ->orderBy('timesheetusers.id', 'ASC')
        ->orderBy('timesheetusers.date', 'DESC')
        ->get();

      $partnerIds = $timesheetData->pluck('partner')->unique()->filter()->values();

      $promotionChecksPartner = DB::table('teamrolehistory')
        ->whereIn('teammember_id', $partnerIds)
        ->select('teammember_id', 'newstaff_code', 'created_at')
        ->get()
        ->keyBy('teammember_id')
        ->map(fn($row) => [
          'newstaff_code' => $row->newstaff_code,
          'promotion_date' => Carbon::parse($row->created_at)->startOfDay(),
        ]);

      // this is for promotion and rejoined user (off/holidays,official travel etc )
      $timesheetData = $timesheetData->map(function ($row) use ($targetClients, $promotionCheck, $promotionorRejoinDate, $promotionChecksPartner) {
        $row->final_teamstaffcode = $row->teamnewstaffcode ?? $row->staffcode ?? '';
        if (in_array($row->client_id, $targetClients) && $row->date) {
          $dataDate = Carbon::parse($row->date)->startOfDay();
          if ($promotionCheck && $dataDate->greaterThanOrEqualTo($promotionorRejoinDate)) {
            $row->final_teamstaffcode = $promotionCheck->newstaff_code;
          } else {
            $row->final_teamstaffcode = $row->staffcode ?? '';
          }
        }

        $row->final_partnerstaffcode = $row->ptnrstaffcode ?? $row->patnerstaffcodee ?? '';
        if (in_array($row->client_id, $targetClients) && $row->date) {
          $dataDate = Carbon::parse($row->date)->startOfDay();
          $promotionPartner = $promotionChecksPartner->get($row->partner);
          if ($promotionPartner && $dataDate->greaterThanOrEqualTo($promotionPartner['promotion_date'])) {
            $row->final_partnerstaffcode = $promotionPartner['newstaff_code'];
          } else {
            $row->final_partnerstaffcode = $row->ptnrstaffcode ?? $row->patnerstaffcodee ?? '';
          }
        }

        return $row;
      });
    } else {
      $date = DB::table('timesheetreport')->where('id', $request->id)->first();
      // this is for promotion and rejoined user
      $targetClients = [29, 34, 32, 33, 134];
      $promotionCheck = DB::table('teamrolehistory')
        ->where('teammember_id', $request->teamid)
        ->select('newstaff_code', 'created_at')
        ->first();

      $promotionorRejoinDate = $promotionCheck
        ? Carbon::parse($promotionCheck->created_at)->startOfDay()
        : null;

      $timesheetData = DB::table('timesheetusers')
        ->leftJoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'timesheetusers.assignmentgenerate_id')
        ->leftJoin('teamrolehistory as teamrolehistoryteam', function ($join) {
          $join->on('teamrolehistoryteam.teammember_id', '=', 'teammembers.id')
            ->whereRaw('teamrolehistoryteam.created_at < assignmentbudgetings.created_at');
        })
        ->leftJoin('clients', 'clients.id', 'timesheetusers.client_id')
        ->leftJoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
        ->leftJoin('teammembers as patnerid', 'patnerid.id', 'timesheetusers.partner')
        ->leftJoin('teamrolehistory', function ($join) {
          $join->on('teamrolehistory.teammember_id', '=', 'patnerid.id')
            ->whereRaw('teamrolehistory.created_at < assignmentbudgetings.created_at');
        })
        ->where('timesheetusers.createdby', $request->teamid)
        ->whereIn('timesheetusers.status', [1, 2, 3])
        ->whereNotNull('timesheetusers.date')
        ->whereBetween('timesheetusers.date', [$date->startdate, $date->enddate])
        ->select(
          'timesheetusers.*',
          'assignments.assignment_name',
          'clients.client_name',
          'clients.client_code',
          'teammembers.team_member',
          'teammembers.staffcode',
          'patnerid.team_member as patnername',
          'patnerid.staffcode as patnerstaffcodee',
          'assignmentbudgetings.assignmentname',
          'teamrolehistory.newstaff_code as ptnrstaffcode',
          'teamrolehistoryteam.newstaff_code as teamnewstaffcode',
          'assignmentbudgetings.created_at as assignmentcreated'
        )
        // ->orderBy('timesheetusers.id', 'ASC')
        ->orderBy('timesheetusers.date', 'DESC')
        ->get();

      $partnerIds = $timesheetData->pluck('partner')->unique()->filter()->values();

      $promotionChecksPartner = DB::table('teamrolehistory')
        ->whereIn('teammember_id', $partnerIds)
        ->select('teammember_id', 'newstaff_code', 'created_at')
        ->get()
        ->keyBy('teammember_id')
        ->map(fn($row) => [
          'newstaff_code' => $row->newstaff_code,
          'promotion_date' => Carbon::parse($row->created_at)->startOfDay(),
        ]);

      // this is for promotion and rejoined user (off/holidays,official travel etc )
      $timesheetData = $timesheetData->map(function ($row) use ($targetClients, $promotionCheck, $promotionorRejoinDate, $promotionChecksPartner) {
        $row->final_teamstaffcode = $row->teamnewstaffcode ?? $row->staffcode ?? '';
        if (in_array($row->client_id, $targetClients) && $row->date) {
          $dataDate = Carbon::parse($row->date)->startOfDay();
          if ($promotionCheck && $dataDate->greaterThanOrEqualTo($promotionorRejoinDate)) {
            $row->final_teamstaffcode = $promotionCheck->newstaff_code;
          } else {
            $row->final_teamstaffcode = $row->staffcode ?? '';
          }
        }

        $row->final_partnerstaffcode = $row->ptnrstaffcode ?? $row->patnerstaffcodee ?? '';
        if (in_array($row->client_id, $targetClients) && $row->date) {
          $dataDate = Carbon::parse($row->date)->startOfDay();
          $promotionPartner = $promotionChecksPartner->get($row->partner);
          if ($promotionPartner && $dataDate->greaterThanOrEqualTo($promotionPartner['promotion_date'])) {
            $row->final_partnerstaffcode = $promotionPartner['newstaff_code'];
          } else {
            $row->final_partnerstaffcode = $row->ptnrstaffcode ?? $row->patnerstaffcodee ?? '';
          }
        }

        return $row;
      });
    }
    return view('backEnd.timesheet.weeklylist', compact('timesheetData'));
  }
public function searchingtimesheet(Request $request)
  {
    // Get all input from form
    $startDate = $request->input('startdate', null);
    $endDate = $request->input('enddate', null);
    $teamId = $request->input('teamid', null);
    $teammemberId = $request->input('teammemberId', null);
    // $year = $request->input('year', null);

    $teammembers = DB::table('teammembers')
      ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
      ->where('teammembers.status', 1)
      ->whereIn('teammembers.role_id', [14, 15, 13, 11])
      ->select('teammembers.team_member', 'teamrolehistory.newstaff_code', 'teammembers.id', 'teammembers.staffcode')
      ->orderBy('team_member', 'ASC')
      ->get();

    $targetClients = [29, 34, 32, 33, 134];

    $promotionCheck = DB::table('teamrolehistory')
      ->where('teammember_id', $teamId)
      ->select('newstaff_code', 'created_at')
      ->first();

    $promotionOrRejoinDate = $promotionCheck
      ? Carbon::parse($promotionCheck->created_at)->startOfDay()
      : null;

    // For patner
    if (auth()->user()->role_id == 13) {
      $query = DB::table('timesheetusers')
        ->leftJoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'timesheetusers.assignmentgenerate_id')
        ->leftJoin('teamrolehistory as teamrolehistoryteam', function ($join) {
          $join->on('teamrolehistoryteam.teammember_id', '=', 'teammembers.id')
            ->whereRaw('teamrolehistoryteam.created_at < assignmentbudgetings.created_at');
        })
        ->leftJoin('clients', 'clients.id', 'timesheetusers.client_id')
        ->leftJoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
        ->leftJoin('teammembers as patnerid', 'patnerid.id', 'timesheetusers.partner')
        ->leftJoin('teamrolehistory', function ($join) {
          $join->on('teamrolehistory.teammember_id', '=', 'patnerid.id')
            ->whereRaw('teamrolehistory.created_at < assignmentbudgetings.created_at');
        })
        ->where('timesheetusers.createdby', $teamId)
        ->whereIn('timesheetusers.status', [1, 2, 3])
        ->whereNotNull('timesheetusers.date')
        ->whereBetween('timesheetusers.date', [$startDate, $endDate])
        ->select(
          'timesheetusers.*',
          'assignments.assignment_name',
          'clients.client_name',
          'clients.client_code',
          'teammembers.team_member',
          'teammembers.staffcode',
          'patnerid.team_member as patnername',
          'patnerid.staffcode as patnerstaffcodee',
          'assignmentbudgetings.assignmentname',
          'teamrolehistory.newstaff_code as ptnrstaffcode',
          'teamrolehistoryteam.newstaff_code as teamnewstaffcode',
          'assignmentbudgetings.created_at as assignmentcreated'
        )
        ->orderBy('timesheetusers.date', 'DESC');

      $timesheetData = $query->get()->map(function ($row) use ($targetClients, $promotionCheck, $promotionOrRejoinDate) {
        $row->final_staffcode = $row->teamnewstaffcode ?? $row->staffcode ?? '';

        if (in_array($row->client_id, $targetClients) && $row->date) {
          $dataDate = Carbon::parse($row->date)->startOfDay();
          if ($promotionCheck && $dataDate->greaterThanOrEqualTo($promotionOrRejoinDate)) {
            $row->final_staffcode = $promotionCheck->newstaff_code;
          } else {
            $row->final_staffcode = $row->staffcode ?? '';
          }
        }

        return $row;
      });

      // dd($timesheetData);
      $request->flash();
      return view('backEnd.timesheet.timesheetdownload', compact('timesheetData'));
    }
    // For staff and manager
    else {
      $query = DB::table('timesheetusers')
        ->leftJoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'timesheetusers.assignmentgenerate_id')
        ->leftJoin('teamrolehistory as teamrolehistoryteam', function ($join) {
          $join->on('teamrolehistoryteam.teammember_id', '=', 'teammembers.id')
            ->whereRaw('teamrolehistoryteam.created_at < assignmentbudgetings.created_at');
        })
        ->leftJoin('clients', 'clients.id', 'timesheetusers.client_id')
        ->leftJoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
        ->leftJoin('teammembers as patnerid', 'patnerid.id', 'timesheetusers.partner')
        ->leftJoin('teamrolehistory', function ($join) {
          $join->on('teamrolehistory.teammember_id', '=', 'patnerid.id')
            ->whereRaw('teamrolehistory.created_at < assignmentbudgetings.created_at');
        })
        ->where('timesheetusers.createdby', $teamId)
        ->whereIn('timesheetusers.status', [1, 2, 3])
        ->whereNotNull('timesheetusers.date')
        ->whereBetween('timesheetusers.date', [$startDate, $endDate])
        ->select(
          'timesheetusers.*',
          'assignments.assignment_name',
          'clients.client_name',
          'clients.client_code',
          'teammembers.team_member',
          'teammembers.staffcode',
          'patnerid.team_member as patnername',
          'patnerid.staffcode as patnerstaffcodee',
          'assignmentbudgetings.assignmentname',
          'teamrolehistory.newstaff_code as ptnrstaffcode',
          'teamrolehistoryteam.newstaff_code as teamnewstaffcode',
          'assignmentbudgetings.created_at as assignmentcreated'
        )
        ->orderBy('timesheetusers.date', 'DESC');

      $timesheetData = $query->get()->map(function ($row) use ($targetClients, $promotionCheck, $promotionOrRejoinDate) {
        $row->final_staffcode = $row->teamnewstaffcode ?? $row->staffcode ?? '';

        if (in_array($row->client_id, $targetClients) && $row->date) {
          $dataDate = Carbon::parse($row->date)->startOfDay();
          if ($promotionCheck && $dataDate->greaterThanOrEqualTo($promotionOrRejoinDate)) {
            $row->final_staffcode = $promotionCheck->newstaff_code;
          } else {
            $row->final_staffcode = $row->staffcode ?? '';
          }
        }

        return $row;
      });
      // dd($timesheetData);
      $request->flash();
      return view('backEnd.timesheet.timesheetdownload', compact('timesheetData'));
    }
  }



public function mytimesheetlist(Request $request, $teamid)
  {

    if (auth()->user()->role_id == 13) {
      // this is for promotion and rejoined user
      $targetClients = [29, 34, 32, 33, 134];
      $promotionCheck = DB::table('teamrolehistory')
        ->where('teammember_id', $teamid)
        ->select('newstaff_code', 'created_at')
        ->first();

      $promotionorRejoinDate = $promotionCheck
        ? Carbon::parse($promotionCheck->created_at)->startOfDay()
        : null;

      $timesheetData = DB::table('timesheetusers')
        ->leftJoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'timesheetusers.assignmentgenerate_id')
        ->leftJoin('teamrolehistory as teamrolehistoryteam', function ($join) {
          $join->on('teamrolehistoryteam.teammember_id', '=', 'teammembers.id')
            ->whereRaw('teamrolehistoryteam.created_at < assignmentbudgetings.created_at');
        })
        ->leftJoin('clients', 'clients.id', 'timesheetusers.client_id')
        ->leftJoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
        ->leftJoin('teammembers as patnerid', 'patnerid.id', 'timesheetusers.partner')
        ->leftJoin('teamrolehistory', function ($join) {
          $join->on('teamrolehistory.teammember_id', '=', 'patnerid.id')
            ->whereRaw('teamrolehistory.created_at < assignmentbudgetings.created_at');
        })
        ->where('timesheetusers.createdby', $teamid)
        ->whereIn('timesheetusers.status', [1, 2, 3])
        ->whereNotNull('timesheetusers.date')
        ->select(
          'timesheetusers.*',
          'assignments.assignment_name',
          'clients.client_name',
          'clients.client_code',
          'teammembers.team_member',
          'teammembers.staffcode',
          'patnerid.team_member as patnername',
          'patnerid.staffcode as patnerstaffcodee',
          'assignmentbudgetings.assignmentname',
          'teamrolehistory.newstaff_code as ptnrstaffcode',
          'teamrolehistoryteam.newstaff_code as teamnewstaffcode',
          'assignmentbudgetings.created_at as assignmentcreated'
        )
        ->orderBy('timesheetusers.date', 'DESC')
        ->limit(7)
        ->get()
        ->map(function ($row) use ($targetClients, $promotionCheck, $promotionorRejoinDate) {
          // this is for promotion and rejoined user
          $row->final_staffcode = $row->teamnewstaffcode ?? $row->staffcode ?? '';
          if (in_array($row->client_id, $targetClients) && $row->date) {
            $dataDate = Carbon::parse($row->date)->startOfDay();
            if ($promotionCheck && $dataDate->greaterThanOrEqualTo($promotionorRejoinDate)) {
              $row->final_staffcode = $promotionCheck->newstaff_code;
            } else {
              $row->final_staffcode = $row->staffcode ?? '';
            }
          }
          return $row;
        });
    } else {
      // this is for promotion and rejoined user
      $targetClients = [29, 34, 32, 33, 134];
      $promotionCheck = DB::table('teamrolehistory')
        ->where('teammember_id', $teamid)
        ->select('newstaff_code', 'created_at')
        ->first();

      $promotionorRejoinDate = $promotionCheck
        ? Carbon::parse($promotionCheck->created_at)->startOfDay()
        : null;

      $timesheetData = DB::table('timesheetusers')
        ->leftJoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'timesheetusers.assignmentgenerate_id')
        ->leftJoin('teamrolehistory as teamrolehistoryteam', function ($join) {
          $join->on('teamrolehistoryteam.teammember_id', '=', 'teammembers.id')
            ->whereRaw('teamrolehistoryteam.created_at < assignmentbudgetings.created_at');
        })
        ->leftJoin('clients', 'clients.id', 'timesheetusers.client_id')
        ->leftJoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
        ->leftJoin('teammembers as patnerid', 'patnerid.id', 'timesheetusers.partner')
        ->leftJoin('teamrolehistory', function ($join) {
          $join->on('teamrolehistory.teammember_id', '=', 'patnerid.id')
            ->whereRaw('teamrolehistory.created_at < assignmentbudgetings.created_at');
        })
        ->where('timesheetusers.createdby', $teamid)
        ->whereIn('timesheetusers.status', [1, 2, 3])
        ->whereNotNull('timesheetusers.date')
        ->select(
          'timesheetusers.*',
          'assignments.assignment_name',
          'clients.client_name',
          'clients.client_code',
          'teammembers.team_member',
          'teammembers.staffcode',
          'patnerid.team_member as patnername',
          'patnerid.staffcode as patnerstaffcodee',
          'assignmentbudgetings.assignmentname',
          'teamrolehistory.newstaff_code as ptnrstaffcode',
          'teamrolehistoryteam.newstaff_code as teamnewstaffcode',
          'assignmentbudgetings.created_at as assignmentcreated'
        )
        ->orderBy('timesheetusers.date', 'DESC')
        ->limit(7)
        ->get()
        ->map(function ($row) use ($targetClients, $promotionCheck, $promotionorRejoinDate) {
          $row->final_staffcode = $row->teamnewstaffcode ?? $row->staffcode ?? '';

          if (in_array($row->client_id, $targetClients) && $row->date) {
            $dataDate = Carbon::parse($row->date)->startOfDay();
            if ($promotionCheck && $dataDate->greaterThanOrEqualTo($promotionorRejoinDate)) {
              $row->final_staffcode = $promotionCheck->newstaff_code;
            } else {
              $row->final_staffcode = $row->staffcode ?? '';
            }
          }
          return $row;
        });
    }
    session()->forget('_old_input');
    return view('backEnd.timesheet.timesheetdownload', compact('timesheetData'));
  }


    public function mytimesheetlist(Request $request, $teamid)
  {
    $date = DB::table('timesheetreport')->where('id', $request->id)->first();

    $query = DB::table('timesheetusers')
      ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
      ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'timesheetusers.assignmentgenerate_id')
      ->leftJoin('teamrolehistory as teamrolehistoryteam', function ($join) {
        $join->on('teamrolehistoryteam.teammember_id', '=', 'teammembers.id')
          ->whereRaw('teamrolehistoryteam.created_at < assignmentbudgetings.created_at');
      })
      ->where('timesheetusers.createdby', $teamid)
      ->whereIn('timesheetusers.status', [1, 2, 3])
      ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
      ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
      ->leftjoin('teammembers as patnerid', 'patnerid.id', 'timesheetusers.partner')
      ->leftJoin('teamrolehistory', function ($join) {
        $join->on('teamrolehistory.teammember_id', '=', 'patnerid.id')
          ->whereRaw('teamrolehistory.created_at < assignmentbudgetings.created_at');
      })
      ->select(
        'timesheetusers.*',
        'assignments.assignment_name',
        'clients.client_name',
        'clients.client_code',
        'teammembers.team_member',
        'teammembers.staffcode',
        'patnerid.team_member as patnername',
        'patnerid.staffcode as patnerstaffcodee',
        'assignmentbudgetings.assignmentname',
        'teamrolehistory.newstaff_code as ptnrstaffcode',
        'teamrolehistoryteam.newstaff_code as teamnewstaffcode',
        'assignmentbudgetings.created_at as assignmentcreated'
      )
      ->orderBy('date', 'DESC')
      ->take(7);

    $timesheetData = $query->get();

    // Custom logic for each row (add final_staffcode based on conditions)
    $targetClients = [29, 34, 32, 33, 134];

    foreach ($timesheetData as $row) {
      $datadate = $row->date
        ? \Carbon\Carbon::createFromFormat('Y-m-d', $row->date)->startOfDay()
        : null;

      $permotioncheck = null;
      $permotiondate = null;

      if (in_array($row->client_id, $targetClients)) {
        $permotioncheck = DB::table('teamrolehistory')
          ->where('teammember_id', $row->createdby)
          ->first();

        if ($permotioncheck) {
          $permotiondate = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $permotioncheck->created_at)->startOfDay();
        }

        if ($permotioncheck && $datadate && $datadate->greaterThanOrEqualTo($permotiondate)) {
          $row->final_staffcode = $permotioncheck->newstaff_code;
        } else {
          $row->final_staffcode = $row->staffcode;
        }
      } else {
        $row->final_staffcode = $row->teamnewstaffcode ?? $row->staffcode;
      }
    }

    session()->forget('_old_input');
    return view('backEnd.timesheet.timesheetdownload', compact('timesheetData'));
  }




























  
    if ($templatename114 && !$kratemplatesId114) {
                $krasdata_id = DB::table('krasdata')->insertGetId([
                    'createdby' => auth()->user()->teammember_id,
                    'data' => json_encode($data),
                    'designation_id' => $designationids,
                    'template_name' => $templatename114,
                    'year' => now()->year,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                foreach ($selectedTeams as $selectedTeam) {
                    DB::table('krasteam')->insert([
                        'teamid' => $selectedTeam,
                        'krastemplate_id' => $krasdata_id,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            } elseif (!$templatename114 && !$kratemplatesId114) {
                foreach ($selectedTeams as $selectedTeam) {
                    $krasdata_id = DB::table('krasdata')->insertGetId([
                        'createdby' => auth()->user()->teammember_id,
                        'data' => json_encode($data),
                        'designation_id' => $designationids,
                        'teamid' => $selectedTeam,
                        'year' => now()->year,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);

                    DB::table('krasteam')->insert([
                        'teamid' => $selectedTeam,
                        'krastemplate_id' => $krasdata_id,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            } elseif (!$templatename114 && $kratemplatesId114) {
                foreach ($selectedTeams as $selectedTeam) {
                    DB::table('krasteam')->insert([
                        'teamid' => $selectedTeam,
                        'krastemplate_id' => $kratemplatesId114,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }

22222222222222222222
    public function krasExceluploadteamwise(Request $request)
    {
        DB::beginTransaction();

        try {
            // dd($request);
            $kratemplatesId = $request->kratemplatesId;
            $teamids = $request->teamids;
            $designationids = $request->designationids;
            $templatename1 = $request->input('templatename1', null);
            $data = [];

            if ($request->hasFile('file')) {
                $import = new Krasimport();
                Excel::import($import, $request->file('file'));
                $data = $import->rows->toArray();
            }

            $krasdata_id = null;

            if ($templatename1 && !$kratemplatesId) {
                $krasdata_id = DB::table('krasdata')->insertGetId([
                    'createdby'      => auth()->user()->teammember_id,
                    'data'           => json_encode($data),
                    'designation_id' => $designationids,
                    'template_name'  => $templatename1,
                    'year'           => now()->year,
                    'created_at'     => now(),
                    'updated_at'     => now()
                ]);
            } elseif (!$templatename1 && !$kratemplatesId) {
                $krasdata_id = DB::table('krasdata')->insertGetId([
                    'createdby'      => auth()->user()->teammember_id,
                    'data'           => json_encode($data),
                    'designation_id' => $designationids,
                    'teamid'         => $teamids,
                    'year'           => now()->year,
                    'created_at'     => now(),
                    'updated_at'     => now()
                ]);
            } else {
                $krasdata_id = $kratemplatesId;
            }

            if ($krasdata_id) {
                DB::table('krasteam')->insert([
                    'teamid'           => $teamids,
                    'krastemplate_id'  => $krasdata_id,
                    'created_at'       => now(),
                    'updated_at'       => now()
                ]);
            }

            DB::commit();
            return back()->with('statusss', ['msg' => 'Created successfully!']);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File: {$e->getFile()} Line: {$e->getLine()} Message: {$e->getMessage()}");
            report($e);
            return back()->withErrors(['msg' => 'Something went wrong: ' . $e->getMessage()])->withInput();
        }
    }







        $record = DB::table('krasdata')
            ->where('designation_id', $designation->id)
            ->where('teamid', $id)
            ->first();

        dd($id, $record);

        if (!$record) {
            $record = DB::table('krasdata')
                ->join('krasteam', function ($join) use ($designation, $id) {
                    $join->on('krasdata.designation_id', '=', 'krasteam.krastemplate_id')
                        ->whereNull('krasdata.teamid');
                })
                ->where('krasteam.krastemplate_id', $designation->id)
                ->where('krasteam.teamid', $id)
                ->select('krasdata.*')
                ->first();
        }

        // dd($record);
        $decoded = $record && $record->data ? json_decode($record->data, true) : [];
        $headings = (!empty($decoded) && is_array($decoded)) ? array_keys($decoded[0]) : [];
        $key = ucwords(str_replace(' ', '_', $designation->name));

  public function mytimesheetlist(Request $request, $teamid)
  {
    // dd($teamid);
    if (auth()->user()->role_id == 13) {
      $date = DB::table('timesheetreport')->where('id', $request->id)->first();
      $timesheetData = DB::table('timesheetusers')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'timesheetusers.assignmentgenerate_id')
        ->leftJoin('teamrolehistory as teamrolehistoryteam', function ($join) {
          $join->on('teamrolehistoryteam.teammember_id', '=', 'teammembers.id')
            ->whereRaw('teamrolehistoryteam.created_at < assignmentbudgetings.created_at');
        })
        ->where('timesheetusers.createdby', $teamid)
        ->whereIn('timesheetusers.status', [1, 2, 3])
        ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
        ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
        ->leftjoin('teammembers as patnerid', 'patnerid.id', 'timesheetusers.partner')
        ->leftJoin('teamrolehistory', function ($join) {
          $join->on('teamrolehistory.teammember_id', '=', 'patnerid.id')
            ->whereRaw('teamrolehistory.created_at < assignmentbudgetings.created_at');
        })
        ->select(
          'timesheetusers.*',
          'assignments.assignment_name',
          'clients.client_name',
          'clients.client_code',
          'teammembers.team_member',
          'teammembers.staffcode',
          'patnerid.team_member as patnername',
          'patnerid.staffcode as patnerstaffcodee',
          'assignmentbudgetings.assignmentname',
          'teamrolehistory.newstaff_code as ptnrstaffcode',
          'teamrolehistoryteam.newstaff_code as teamnewstaffcode',
          'assignmentbudgetings.created_at as assignmentcreated'
        )
        ->orderBy('date', 'DESC')
        ->take(7)
        ->get();


      // dd($timesheetData);
    } else {
      $date = DB::table('timesheetreport')->where('id', $request->id)->first();
      $timesheetData = DB::table('timesheetusers')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'timesheetusers.assignmentgenerate_id')
        ->leftJoin('teamrolehistory as teamrolehistoryteam', function ($join) {
          $join->on('teamrolehistoryteam.teammember_id', '=', 'teammembers.id')
            ->whereRaw('teamrolehistoryteam.created_at < assignmentbudgetings.created_at');
        })
        ->where('timesheetusers.createdby', $teamid)
        ->whereIn('timesheetusers.status', [1, 2, 3])
        ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
        ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
        ->leftjoin('teammembers as patnerid', 'patnerid.id', 'timesheetusers.partner')
        ->leftJoin('teamrolehistory', function ($join) {
          $join->on('teamrolehistory.teammember_id', '=', 'patnerid.id')
            ->whereRaw('teamrolehistory.created_at < assignmentbudgetings.created_at');
        })
        ->select(
          'timesheetusers.*',
          'assignments.assignment_name',
          'clients.client_name',
          'clients.client_code',
          'teammembers.team_member',
          'teammembers.staffcode',
          'patnerid.team_member as patnername',
          'patnerid.staffcode as patnerstaffcodee',
          'assignmentbudgetings.assignmentname',
          'teamrolehistory.newstaff_code as ptnrstaffcode',
          'teamrolehistoryteam.newstaff_code as teamnewstaffcode',
          'assignmentbudgetings.created_at as assignmentcreated'
        )
        ->orderBy('date', 'DESC')
        ->take(7)
        ->get();
    }
    session()->forget('_old_input');
    return view('backEnd.timesheet.timesheetdownload', compact('timesheetData'));
  }
// final code
// final code
// final code
// final code
// final code
// final code
// final code
// final code
  public function weeklylist(Request $request)
  {
    // dd($request);
    if (auth()->user()->role_id == 13) {

      $date = DB::table('timesheetreport')->where('id', $request->id)->first();
      // $timesheetData = DB::table('timesheetusers')
      //   ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
      //   ->where('timesheetusers.createdby', $request->teamid)
      //   ->whereIn('timesheetusers.status', [1, 2, 3])
      //   ->where('timesheetusers.date', '>=', $date->startdate)
      //   ->where('timesheetusers.date', '<=', $date->enddate)
      //   ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
      //   ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
      //   ->leftjoin('teammembers as patnerid', 'patnerid.id', 'timesheetusers.partner')
      //   ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'patnerid.id')
      //   ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'timesheetusers.assignmentgenerate_id')
      //   // ->select('timesheetusers.*', 'assignments.assignment_name', 'clients.client_name', 'teammembers.team_member', 'teammembers.staffcode', 'patnerid.team_member as patnername', 'assignmentbudgetings.assignmentname')
      //   ->select('timesheetusers.*', 'assignments.assignment_name', 'clients.client_name', 'clients.client_code', 'teammembers.team_member', 'teammembers.staffcode', 'patnerid.team_member as patnername', 'patnerid.staffcode as patnerstaffcodee', 'assignmentbudgetings.assignmentname', 'teamrolehistory.newstaff_code', 'assignmentbudgetings.created_at as assignmentcreated')
      //   ->orderBy('id', 'ASC')
      //   //   ->orderBy('date', 'DESC')
      //   ->get();

      $timesheetData = DB::table('timesheetusers')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'timesheetusers.assignmentgenerate_id')
        ->leftJoin('teamrolehistory as teamrolehistoryteam', function ($join) {
          $join->on('teamrolehistoryteam.teammember_id', '=', 'teammembers.id')
            ->whereRaw('teamrolehistoryteam.created_at < assignmentbudgetings.created_at');
        })
        ->where('timesheetusers.createdby', $request->teamid)
        ->whereIn('timesheetusers.status', [1, 2, 3])
        ->where('timesheetusers.date', '>=', $date->startdate)
        ->where('timesheetusers.date', '<=', $date->enddate)
        ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
        ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
        ->leftjoin('teammembers as patnerid', 'patnerid.id', 'timesheetusers.partner')
        ->leftJoin('teamrolehistory', function ($join) {
          $join->on('teamrolehistory.teammember_id', '=', 'patnerid.id')
            ->whereRaw('teamrolehistory.created_at < assignmentbudgetings.created_at');
        })
        ->select(
          'timesheetusers.*',
          'assignments.assignment_name',
          'clients.client_name',
          'clients.client_code',
          'teammembers.team_member',
          'teammembers.staffcode',
          'patnerid.team_member as patnername',
          'patnerid.staffcode as patnerstaffcodee',
          'assignmentbudgetings.assignmentname',
          'teamrolehistory.newstaff_code as ptnrstaffcode',
          'teamrolehistoryteam.newstaff_code as teamnewstaffcode',
          'assignmentbudgetings.created_at as assignmentcreated'
        )
        ->orderBy('timesheetusers.id', 'ASC')
        ->get();
    } else {
      $date = DB::table('timesheetreport')->where('id', $request->id)->first();
      // $timesheetData = DB::table('timesheetusers')
      //   ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
      //   ->where('timesheetusers.createdby', $request->teamid)
      //   ->whereIn('timesheetusers.status', [1, 2, 3])
      //   ->where('timesheetusers.date', '>=', $date->startdate)
      //   ->where('timesheetusers.date', '<=', $date->enddate)
      //   ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
      //   ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
      //   ->leftjoin('teammembers as patnerid', 'patnerid.id', 'timesheetusers.partner')
      //   ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'patnerid.id')
      //   ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'timesheetusers.assignmentgenerate_id')
      //   ->select('timesheetusers.*', 'assignments.assignment_name', 'clients.client_name', 'clients.client_code', 'teammembers.team_member', 'teammembers.staffcode', 'patnerid.team_member as patnername', 'patnerid.staffcode as patnerstaffcodee', 'assignmentbudgetings.assignmentname', 'teamrolehistory.newstaff_code', 'assignmentbudgetings.created_at as assignmentcreated')
      //   ->orderBy('id', 'ASC')
      //   ->get();
      $timesheetData = DB::table('timesheetusers')
        ->leftJoin('teammembers', 'teammembers.id', '=', 'timesheetusers.createdby')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'timesheetusers.assignmentgenerate_id') // Move this join up
        ->leftJoin('teamrolehistory as teamrolehistoryteam', function ($join) {
          $join->on('teamrolehistoryteam.teammember_id', '=', 'teammembers.id')
            ->whereRaw('teamrolehistoryteam.created_at < assignmentbudgetings.created_at');
        })
        ->where('timesheetusers.createdby', $request->teamid)
        ->whereIn('timesheetusers.status', [1, 2, 3])
        ->whereBetween('timesheetusers.date', [$date->startdate, $date->enddate])
        ->leftJoin('clients', 'clients.id', '=', 'timesheetusers.client_id')
        ->leftJoin('assignments', 'assignments.id', '=', 'timesheetusers.assignment_id')
        ->leftJoin('teammembers as patnerid', 'patnerid.id', '=', 'timesheetusers.partner')
        ->leftJoin('teamrolehistory', function ($join) {
          $join->on('teamrolehistory.teammember_id', '=', 'patnerid.id')
            ->whereRaw('teamrolehistory.created_at < assignmentbudgetings.created_at');
        })
        ->select(
          'timesheetusers.*',
          'assignments.assignment_name',
          'clients.client_name',
          'clients.client_code',
          'teammembers.team_member',
          'teammembers.staffcode',
          'patnerid.team_member as patnername',
          'patnerid.staffcode as patnerstaffcodee',
          'assignmentbudgetings.assignmentname',
          'teamrolehistory.newstaff_code as ptnrstaffcode',
          'teamrolehistoryteam.newstaff_code as teamnewstaffcode',
          'assignmentbudgetings.created_at as assignmentcreated'
        )
        ->orderBy('timesheetusers.id', 'ASC')
        ->get();
    }
    return view('backEnd.timesheet.weeklylist', compact('timesheetData'));
  }
// final code
  // 04-02-2025
  public function create(Request $request)
  {
    $permotioncheck = DB::table('teamrolehistory')
      ->where('teammember_id', auth()->user()->teammember_id)->first();
    $partner = Teammember::where('role_id', '=', 13)->where('status', '=', 1)->with('title')->get();
    $teammember = Teammember::where('role_id', '!=', 11)->with('title', 'role')->get();
    if (auth()->user()->role_id == 11) {
      $client = Client::where('status', 1)->select('id', 'client_name', 'client_code')->orderBy('client_name', 'ASC')->get();
      $timesheetrejectData = DB::table('timesheetusers')
        ->where('createdby', auth()->user()->teammember_id)
        ->where('status', 2)
        ->first();
    } elseif ($permotioncheck && auth()->user()->role_id == 13) {
      $timesheetrejectData = DB::table('timesheetusers')
        ->where('createdby', auth()->user()->teammember_id)
        ->where('status', 2)
        ->first();

      $clientssbefore = DB::table('assignmentteammappings')
        ->leftjoin('assignmentmappings', 'assignmentmappings.id', 'assignmentteammappings.assignmentmapping_id')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->orwhere('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
        // i have add this line becouse manager contain it but staff not contain it so basically after add this code no contain staff and manager 
        ->whereNotIn('assignmentbudgetings.assignmentname', ['Unallocated', 'Official Travel', 'Off/Holiday', 'Seminar/Conference/Post Qualification Course'])
        ->where('assignmentbudgetings.status', 1)
        ->select('clients.client_name', 'clients.id', 'clients.client_code')
        ->orderBy('client_name', 'ASC')
        ->distinct()->get();

      $clientssafter = DB::table('assignmentmappings')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->where(function ($query) {
          $query->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
            ->orWhere('assignmentmappings.otherpartner', auth()->user()->teammember_id);
        })
        ->where('assignmentbudgetings.status', 1)
        ->select('clients.client_name', 'clients.id', 'clients.client_code')
        ->orderBy('client_name', 'ASC')
        ->distinct()->get();

      // // done default $clients in ajax if need then $clientss add in ajax target $request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34
      // $clients = DB::table('clients')
      //   ->whereIn('id', [29, 32, 33, 34])
      //   ->select('clients.client_name', 'clients.id', 'clients.client_code')
      //   ->orderBy('client_name', 'ASC')
      //   ->distinct()->get();
      // $client = $clientss->merge($clients);

      $selectedDate1 = new \DateTime();
      $formattedDate = $selectedDate1->format('Y-m-d');
      $holidaydatecheck = DB::table('holidays')->where('startdate', $formattedDate)->select('holidayname')->first();

      if ($holidaydatecheck) {
        $clientIds = [29, 32, 33, 34];
      } else {
        // if not holidays then go hare
        $dayOfWeek = $selectedDate1->format('w');
        if ($selectedDate1->format('l') == 'Saturday') {
          $dayOfMonth = $selectedDate1->format('j');
          // Calculate which Saturday of the month it is
          $saturdayNumber = ceil($dayOfMonth / 7);
          // offholiday client name will be show on 2nd and 4rth sturday
          if ($saturdayNumber == 2.0 || $saturdayNumber == 4.0) {
            $clientIds = [29, 32, 33, 34];
          } else {
            $clientIds = [29, 32, 34];
          }
        } else {
          $clientIds = [29, 32, 34];
        }
      }

      $clients = DB::table('clients')
        ->whereIn('id', $clientIds)
        ->select('clients.client_name', 'clients.id', 'clients.client_code')
        ->orderBy('client_name', 'ASC')
        ->distinct()
        ->get();

      $client = $clientssafter->merge($clientssbefore)->merge($clients);
    } elseif (auth()->user()->role_id == 13) {
      $timesheetrejectData = DB::table('timesheetusers')
        ->where('createdby', auth()->user()->teammember_id)
        ->where('status', 2)
        ->first();

      $clientss = DB::table('clients')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.client_id', '=', 'clients.id')
        ->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', '=', 'assignmentbudgetings.assignmentgenerate_id')
        ->leftJoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
        ->where('assignmentbudgetings.status', 1)
        ->where(function ($query) {
          $query->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
            ->orWhere('assignmentmappings.otherpartner', auth()->user()->teammember_id)
            ->orWhere('assignmentteammappings.teammember_id', auth()->user()->teammember_id);
        })
        ->select('clients.client_name', 'clients.id', 'clients.client_code')
        ->distinct()
        ->orderBy('clients.client_name', 'ASC')
        ->get();

      $selectedDate1 = new \DateTime();
      $formattedDate = $selectedDate1->format('Y-m-d');
      $holidaydatecheck = DB::table('holidays')->where('startdate', $formattedDate)->select('holidayname')->first();

      if ($holidaydatecheck) {
        $clientIds = [29, 32, 33, 34];
      } else {
        // if not holidays then go hare
        $dayOfWeek = $selectedDate1->format('w');
        if ($selectedDate1->format('l') == 'Saturday') {
          $dayOfMonth = $selectedDate1->format('j');
          // Calculate which Saturday of the month it is
          $saturdayNumber = ceil($dayOfMonth / 7);
          // offholiday client name will be show on 2nd and 4rth sturday
          if ($saturdayNumber == 2.0 || $saturdayNumber == 4.0) {
            $clientIds = [29, 32, 33, 34];
          } else {
            $clientIds = [29, 32, 34];
          }
        } else {
          $clientIds = [29, 32, 34];
        }
      }


      $clients = DB::table('clients')
        ->whereIn('id', $clientIds)
        ->select('clients.client_name', 'clients.id', 'clients.client_code')
        ->orderBy('client_name', 'ASC')
        ->distinct()
        ->get();

      $client = $clientss->merge($clients);
    } else {
      $timesheetrejectData = DB::table('timesheetusers')
        ->where('createdby', auth()->user()->teammember_id)
        ->where('status', 2)
        ->first();

      $clientss = DB::table('assignmentteammappings')
        ->leftjoin('assignmentmappings', 'assignmentmappings.id', 'assignmentteammappings.assignmentmapping_id')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->orwhere('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
        // i have add this line becouse manager contain it but staff not contain it so basically after add this code no contain staff and manager 
        ->whereNotIn('assignmentbudgetings.assignmentname', ['Unallocated', 'Official Travel', 'Off/Holiday', 'Seminar/Conference/Post Qualification Course'])
        ->where('assignmentbudgetings.status', 1)
        ->select('clients.client_name', 'clients.id', 'clients.client_code')
        ->orderBy('client_name', 'ASC')
        ->distinct()->get();

      // done default $clients in ajax if need then $clientss add in ajax target $request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34
      // $clients = DB::table('clients')
      //   ->whereIn('id', [29, 32, 33, 34])
      //   ->select('clients.client_name', 'clients.id', 'clients.client_code')
      //   ->orderBy('client_name', 'ASC')
      //   ->distinct()->get();

      // $client = $clientss->merge($clients);

      $selectedDate1 = new \DateTime();
      $formattedDate = $selectedDate1->format('Y-m-d');
      $holidaydatecheck = DB::table('holidays')->where('startdate', $formattedDate)->select('holidayname')->first();

      if ($holidaydatecheck) {
        $clientIds = [29, 32, 33, 34];
      } else {
        // if not holidays then go hare
        $dayOfWeek = $selectedDate1->format('w');
        if ($selectedDate1->format('l') == 'Saturday') {
          $dayOfMonth = $selectedDate1->format('j');
          // Calculate which Saturday of the month it is
          $saturdayNumber = ceil($dayOfMonth / 7);
          // offholiday client name will be show on 2nd and 4rth sturday
          if (auth()->user()->role_id == 14) {
            if ($saturdayNumber == 2.0 || $saturdayNumber == 4.0) {
              $clientIds = [29, 32, 33, 34];
            } else {
              $clientIds = [29, 32, 34];
            }
          } else {
            if ($saturdayNumber == 1.0 || $saturdayNumber == 2.0 || $saturdayNumber == 3.0 || $saturdayNumber == 4.0 || $saturdayNumber == 5.0) {
              $clientIds = [29, 32, 33, 34];
            }
          }
        } else {
          $clientIds = [29, 32, 34];
        }
      }
      $clients = DB::table('clients')
        ->whereIn('id', $clientIds)
        ->select('clients.client_name', 'clients.id', 'clients.client_code')
        ->orderBy('client_name', 'ASC')
        ->distinct()
        ->get();

      $client = $clientss->merge($clients);
    }
    $assignment = Assignment::select('id', 'assignment_name')->get();
    if ($request->ajax()) {
      // dd($request);
      if (isset($request->timesheetdate)) {
        if ($permotioncheck && auth()->user()->role_id == 13) {
          echo "<option>Select Client</option>";

          $selectedDate = \DateTime::createFromFormat('d-m-Y', $request->timesheetdate);
          $selectedDate1 = \DateTime::createFromFormat('d-m-Y', $request->timesheetdate);


          $clientssbefore = DB::table('assignmentteammappings')
            ->leftjoin('assignmentmappings', 'assignmentmappings.id', 'assignmentteammappings.assignmentmapping_id')
            ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
            ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
            ->orwhere('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
            ->whereNotIn('assignmentbudgetings.assignmentname', ['Unallocated', 'Official Travel', 'Off/Holiday', 'Seminar/Conference/Post Qualification Course'])
            ->where(function ($query) use ($selectedDate) {
              $query->whereNull('otpverifydate')
                ->orWhere('otpverifydate', '>=', $selectedDate->modify('-1 day'));
            })
            ->select('clients.client_name', 'clients.id', 'clients.client_code')
            ->orderBy('client_name', 'ASC')
            ->distinct()->get();

          $clientssafter = DB::table('assignmentmappings')
            ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
            ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
            ->where(function ($query) {
              $query->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
                ->orWhere('assignmentmappings.otherpartner', auth()->user()->teammember_id);
            })
            ->where(function ($query) use ($selectedDate) {
              $query->whereNull('otpverifydate')
                ->orWhere('otpverifydate', '>=', $selectedDate->modify('-1 day'));
            })
            // ->whereNotNull('clients.client_name')
            ->select('clients.client_name', 'clients.id', 'clients.client_code')
            ->orderBy('client_name', 'ASC')
            ->distinct()->get();

          // // done default $clients in ajax if need then $clientss add in ajax target $request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34
          // $clients = DB::table('clients')
          //   ->whereIn('id', [29, 32, 33, 34])
          //   ->select('clients.client_name', 'clients.id', 'clients.client_code')
          //   ->orderBy('client_name', 'ASC')
          //   ->distinct()->get();

          // if you selected sturday date then offholydays client will be show otherwise not

          $formattedDate = $selectedDate1->format('Y-m-d');
          $holidaydatecheck = DB::table('holidays')->where('startdate', $formattedDate)->select('holidayname')->first();

          if ($holidaydatecheck) {
            $clientIds = [29, 32, 33, 34];
          } else {
            // if not holidays then go hare
            $dayOfWeek = $selectedDate1->format('w');
            if ($selectedDate1->format('l') == 'Saturday') {
              $dayOfMonth = $selectedDate1->format('j');
              // Calculate which Saturday of the month it is
              $saturdayNumber = ceil($dayOfMonth / 7);
              // offholiday client name will be show on 2nd and 4rth sturday
              if ($saturdayNumber == 2.0 || $saturdayNumber == 4.0) {
                $clientIds = [29, 32, 33, 34];
              } else {
                $clientIds = [29, 32, 34];
              }
            } else {
              $clientIds = [29, 32, 34];
            }
          }
          $clients = DB::table('clients')
            ->whereIn('id', $clientIds)
            ->select('clients.client_name', 'clients.id', 'clients.client_code')
            ->orderBy('client_name', 'ASC')
            ->distinct()
            ->get();

          // $client = $clientss->merge($clients);
          $client = $clientssafter->merge($clientssbefore)->merge($clients);
          foreach ($client as $clients) {
            echo "<option value='" . $clients->id . "'>" . $clients->client_name . '( ' . $clients->client_code . ' )' . "</option>";
          }
        } elseif (auth()->user()->role_id == 13) {
          echo "<option>Select Client</option>";

          $selectedDate = \DateTime::createFromFormat('d-m-Y', $request->timesheetdate);
          $selectedDate1 = \DateTime::createFromFormat('d-m-Y', $request->timesheetdate);

          $clientss = DB::table('assignmentmappings')
            ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
            ->leftJoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
            ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
            ->where(function ($query) {
              $query->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
                ->orWhere('assignmentmappings.otherpartner', auth()->user()->teammember_id)
                ->orWhere('assignmentteammappings.teammember_id', auth()->user()->teammember_id);
            })
            ->where(function ($query) use ($selectedDate) {
              $query->whereNull('otpverifydate')
                ->orWhere('otpverifydate', '>=', $selectedDate->modify('-1 day'));
            })
            // ->whereNotNull('clients.client_name')
            ->select('clients.client_name', 'clients.id', 'clients.client_code')
            ->orderBy('client_name', 'ASC')
            ->distinct()->get();

          // // done default $clients in ajax if need then $clientss add in ajax target $request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34
          // $clients = DB::table('clients')
          //   ->whereIn('id', [29, 32, 33, 34])
          //   ->select('clients.client_name', 'clients.id', 'clients.client_code')
          //   ->orderBy('client_name', 'ASC')
          //   ->distinct()->get();

          // if you selected sturday date then offholydays client will be show otherwise not

          $formattedDate = $selectedDate1->format('Y-m-d');
          $holidaydatecheck = DB::table('holidays')->where('startdate', $formattedDate)->select('holidayname')->first();

          if ($holidaydatecheck) {
            $clientIds = [29, 32, 33, 34];
          } else {
            // if not holidays then go hare
            $dayOfWeek = $selectedDate1->format('w');
            if ($selectedDate1->format('l') == 'Saturday') {
              $dayOfMonth = $selectedDate1->format('j');
              // Calculate which Saturday of the month it is
              $saturdayNumber = ceil($dayOfMonth / 7);
              // offholiday client name will be show on 2nd and 4rth sturday
              if ($saturdayNumber == 2.0 || $saturdayNumber == 4.0) {
                $clientIds = [29, 32, 33, 34];
              } else {
                $clientIds = [29, 32, 34];
              }
            } else {
              $clientIds = [29, 32, 34];
            }
          }
          $clients = DB::table('clients')
            ->whereIn('id', $clientIds)
            ->select('clients.client_name', 'clients.id', 'clients.client_code')
            ->orderBy('client_name', 'ASC')
            ->distinct()
            ->get();

          $client = $clientss->merge($clients);

          // foreach ($client as $clients) {
          //   if ($clients->client_name !== 'Official Travel') {
          //     echo "<option value='" . $clients->id . "'>" . $clients->client_name . ' ( ' . $clients->client_code . ' )' . "</option>";
          //   }
          // }

          foreach ($client as $clients) {
            echo "<option value='" . $clients->id . "'>" . $clients->client_name . '( ' . $clients->client_code . ' )' . "</option>";
          }
        } else {

          echo "<option>Select Client</option>";

          $selectedDate = \DateTime::createFromFormat('d-m-Y', $request->timesheetdate);
          $selectedDate1 = \DateTime::createFromFormat('d-m-Y', $request->timesheetdate);
          $clientss = DB::table('assignmentteammappings')
            ->leftjoin('assignmentmappings', 'assignmentmappings.id', 'assignmentteammappings.assignmentmapping_id')
            ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
            ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
            ->orwhere('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
            ->whereNotIn('assignmentbudgetings.assignmentname', ['Unallocated', 'Official Travel', 'Off/Holiday', 'Seminar/Conference/Post Qualification Course'])
            ->where(function ($query) use ($selectedDate) {
              $query->whereNull('otpverifydate')
                ->orWhere('otpverifydate', '>=', $selectedDate->modify('-1 day'));
            })
            ->select('clients.client_name', 'clients.id', 'clients.client_code')
            ->orderBy('client_name', 'ASC')
            ->distinct()->get();
          // ->get();

          // done default $clients in ajax if need then $clientss add in ajax target $request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34
          // $clients = DB::table('clients')
          //   ->whereIn('id', [29, 32, 33, 34])
          //   ->select('clients.client_name', 'clients.id', 'clients.client_code')
          //   ->orderBy('client_name', 'ASC')
          //   ->distinct()->get();

          // $client = $clientss->merge($clients);



          $formattedDate = $selectedDate1->format('Y-m-d');
          $holidaydatecheck = DB::table('holidays')->where('startdate', $formattedDate)->select('holidayname')->first();

          if ($holidaydatecheck) {
            $clientIds = [29, 32, 33, 34];
          } else {
            // if not holidays then go hare
            $dayOfWeek = $selectedDate1->format('w');
            if ($selectedDate1->format('l') == 'Saturday') {
              $dayOfMonth = $selectedDate1->format('j');
              // Calculate which Saturday of the month it is
              $saturdayNumber = ceil($dayOfMonth / 7);
              // offholiday client name will be show on 2nd and 4rth sturday
              if (auth()->user()->role_id == 14) {
                if ($saturdayNumber == 2.0 || $saturdayNumber == 4.0) {
                  $clientIds = [29, 32, 33, 34];
                } else {
                  $clientIds = [29, 32, 34];
                }
              } else {
                if ($saturdayNumber == 1.0 || $saturdayNumber == 2.0 || $saturdayNumber == 3.0 || $saturdayNumber == 4.0 || $saturdayNumber == 5.0) {
                  $clientIds = [29, 32, 33, 34];
                }
              }
            } else {
              $clientIds = [29, 32, 34];
            }
          }
          $clients = DB::table('clients')
            ->whereIn('id', $clientIds)
            ->select('clients.client_name', 'clients.id', 'clients.client_code')
            ->orderBy('client_name', 'ASC')
            ->distinct()
            ->get();

          $client = $clientss->merge($clients);

          foreach ($client as $clients) {
            echo "<option value='" . $clients->id . "'>" . $clients->client_name . '( ' . $clients->client_code . ' )' . "</option>";
          }
        }
      }

      if (isset($request->cid)) {
        if ($permotioncheck && auth()->user()->role_id == 13) {
          echo "<option>Select Assignment</option>";

          if ($request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34) {
            $clients = DB::table('clients')
              ->where('id', $request->cid)
              ->select('clients.client_name', 'clients.id', 'clients.client_code')
              ->orderBy('client_name', 'ASC')
              ->distinct()->get();

            $id = $clients[0]->id;
            $assignments = DB::table('assignmentbudgetings')->where('client_id', $id)
              ->leftJoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
              ->select('assignmentbudgetings.assignmentgenerate_id', 'assignments.assignment_name', 'assignments.assignmentname')
              ->orderBy('assignment_name');
          } else {
            $selectedDate = \DateTime::createFromFormat('d-m-Y', $request->datepickers);

            $assignments = DB::table('assignmentbudgetings')
              ->where('assignmentbudgetings.client_id', $request->cid)
              ->leftJoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
              ->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
              ->where(function ($query) {
                $query->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
                  ->orWhere('assignmentmappings.otherpartner', auth()->user()->teammember_id);
              })
              ->where(function ($query) use ($selectedDate) {
                $query->whereNull('otpverifydate')
                  ->orWhere('otpverifydate', '>=', $selectedDate->modify('-1 day'));
              })
              ->select('assignmentbudgetings.assignmentgenerate_id', 'assignments.assignment_name', 'assignmentbudgetings.assignmentname');

            $additionalAssignments = DB::table('assignmentbudgetings')
              ->join('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
              ->leftJoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
              ->leftJoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
              ->where('assignmentbudgetings.client_id', $request->cid)
              ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
              ->where(function ($query) {
                $query->whereNull('assignmentteammappings.status')
                  ->orWhere('assignmentteammappings.status', '=', 1);
              })
              ->where(function ($query) use ($selectedDate) {
                $query->whereNull('otpverifydate')
                  ->orWhere('otpverifydate', '>=', $selectedDate->modify('-1 day'));
              })
              ->select('assignmentbudgetings.assignmentgenerate_id', 'assignments.assignment_name', 'assignmentbudgetings.assignmentname');

            $assignments = $assignments->union($additionalAssignments)->orderBy('assignment_name')->get();
            // dd($assignments);
          }

          foreach ($assignments as $sub) {
            echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentname . '/' . $sub->assignmentgenerate_id . ' )' . "</option>";
          }
        }

        // 22222222
        elseif (auth()->user()->role_id == 13) {

          echo "<option>Select Assignment</option>";
          if ($request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34) {
            $clients = DB::table('clients')
              // ->whereIn('id', [29, 32, 33, 34])
              ->where('id', $request->cid)
              ->select('clients.client_name', 'clients.id', 'clients.client_code')
              ->orderBy('client_name', 'ASC')
              ->distinct()->get();
            // dd($clients);
            $id = $clients[0]->id;
            foreach (
              DB::table('assignmentbudgetings')->where('client_id', $id)
                ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
                ->orderBy('assignment_name')->get() as $sub
            ) {
              echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentname . '/' . $sub->assignmentgenerate_id . ' )' . "</option>";
            }
          } else {
            // dd('hi 3');

            $selectedDate = \DateTime::createFromFormat('d-m-Y', $request->datepickers);

            foreach (
              DB::table('assignmentbudgetings')
                ->where('assignmentbudgetings.client_id', $request->cid)
                ->leftJoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
                ->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
                ->leftJoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
                ->where(function ($query) {
                  $query->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
                    ->orWhere('assignmentmappings.otherpartner', auth()->user()->teammember_id)
                    ->orWhere('assignmentteammappings.teammember_id', auth()->user()->teammember_id);
                })
                ->where(function ($query) use ($selectedDate) {
                  $query->whereNull('otpverifydate')
                    ->orWhere('otpverifydate', '>=', $selectedDate->modify('-1 day'));
                })
                ->orderBy('assignment_name')->get() as $sub
            ) {
              echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentname . '/' . $sub->assignmentgenerate_id . ' )' . "</option>";
            }
          }
        } else {

          echo "<option>Select Assignment</option>";

          if ($request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34) {
            $clients = DB::table('clients')
              // ->whereIn('id', [29, 32, 33, 34])
              ->where('id', $request->cid)
              ->select('clients.client_name', 'clients.id', 'clients.client_code')
              ->orderBy('client_name', 'ASC')
              ->distinct()->get();
            // dd($clients);
            $id = $clients[0]->id;
            foreach (
              DB::table('assignmentbudgetings')->where('client_id', $id)
                ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
                ->orderBy('assignment_name')->get() as $sub
            ) {
              echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentname . '/' . $sub->assignmentgenerate_id . ' )' . "</option>";
            }
          } else {
            //  i have add this code after kartic bindal problem 
            $selectedDate = \DateTime::createFromFormat('d-m-Y', $request->datepickers);

            foreach (
              DB::table('assignmentbudgetings')
                ->join('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
                ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
                ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
                ->where('assignmentbudgetings.client_id', $request->cid)
                ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
                //  ->where('assignmentteammappings.status', '!=', 0)
                // ->whereNull('assignmentteammappings.status')
                ->where(function ($query) {
                  $query->whereNull('assignmentteammappings.status')
                    ->orWhere('assignmentteammappings.status', '=', 1);
                })
                ->where(function ($query) use ($selectedDate) {
                  $query->whereNull('otpverifydate')
                    //   ->orWhere('otpverifydate', '>=', $selectedDate);
                    // // ->orWhere('otpverifydate', '>=', $selectedDate);
                    ->orWhere('otpverifydate', '>=', $selectedDate->modify('-1 day'));
                })
                ->orderBy('assignment_name')->get() as $sub
            ) {
              echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentname . '/' . $sub->assignmentgenerate_id . ' )' . "</option>";
            }
          }
        }
      }

      if (isset($request->assignment)) {
        // dd($request->assignment);
        if (auth()->user()->role_id == 11) {
          echo "<option value=''>Select Partner</option>";
          foreach (
            DB::table('assignmentmappings')

              ->leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
              ->leftjoin('teammembers as team', 'team.id', 'assignmentmappings.otherpartner')
              ->where('assignmentmappings.assignmentgenerate_id', $request->assignment)
              ->select('team.team_member as team_member', 'team.id', 'teammembers.id', 'teammembers.team_member')
              ->get() as $subs
          ) {
            echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
          }
        } elseif ($permotioncheck && auth()->user()->role_id == 13) {
          echo "<option value=''>Select Partner</option>";
          // dd($request->assignment);
          $partnerbefore = DB::table('assignmentmappings')
            ->leftJoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
            ->leftJoin('teammembers as team', 'team.id', 'assignmentmappings.otherpartner')
            ->where('assignmentmappings.assignmentgenerate_id', $request->assignment)
            ->select('teammembers.id', 'teammembers.team_member');

          // $partnerafter = DB::table('assignmentmappings')
          //   ->leftJoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
          //   ->where('assignmentmappings.assignmentgenerate_id', $request->assignment)
          //   ->select('teammembers.id', 'teammembers.team_member');

          $partnerafter = DB::table('assignmentmappings')
            ->leftJoin('teammembers as leadpartner', 'leadpartner.id', '=', 'assignmentmappings.leadpartner')
            ->leftJoin('teammembers as otherpartner', 'otherpartner.id', '=', 'assignmentmappings.otherpartner')
            ->where('assignmentmappings.assignmentgenerate_id', $request->assignment)
            ->where(function ($query) {
              $query->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
                ->orWhere('assignmentmappings.otherpartner', auth()->user()->teammember_id);
            })
            ->select(DB::raw("
          CASE
              WHEN assignmentmappings.leadpartner = " . auth()->user()->teammember_id . " THEN leadpartner.id
              WHEN assignmentmappings.otherpartner = " . auth()->user()->teammember_id . " THEN otherpartner.id
          END as id,
          CASE
              WHEN assignmentmappings.leadpartner = " . auth()->user()->teammember_id . " THEN leadpartner.team_member
              WHEN assignmentmappings.otherpartner = " . auth()->user()->teammember_id . " THEN otherpartner.team_member
          END as team_member
      "));

          $partnerresult = $partnerafter->union($partnerbefore)->get();
          foreach ($partnerresult as $subs) {
            echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
          }
        } elseif (auth()->user()->role_id == 13) {
          echo "<option value=''>Select Partner</option>";
          foreach (
            DB::table('teammembers')
              ->where('id', auth()->user()->teammember_id)
              ->select('teammembers.id', 'teammembers.team_member')
              ->get() as $subs
          ) {
            echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
          }
        } else {

          echo "<option value=''>Select Partner</option>";
          foreach (
            DB::table('assignmentmappings')

              ->leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
              ->leftjoin('teammembers as team', 'team.id', 'assignmentmappings.otherpartner')
              ->where('assignmentmappings.assignmentgenerate_id', $request->assignment)
              ->select('team.team_member as team_member', 'team.id', 'teammembers.id', 'teammembers.team_member')
              ->get() as $subs
          ) {
            echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
          }
        }
      }
    } else {

      $authUserId = auth()->user()->teammember_id;

      // Fetch common data
      $lasttimesheetsubmiteddata = DB::table('timesheetreport')
        ->where('teamid', $authUserId)
        ->latest()
        ->first();

      $timesheetmaxDateRecord = DB::table('timesheetusers')
        ->where('status', '0')
        ->where('createdby', $authUserId)
        ->whereNotIn('client_id', ['134'])
        ->orderBy('date', 'desc')
        ->first();

      $leaveDates = DB::table('timesheetusers')
        ->where('status', '0')
        ->where('createdby', $authUserId)
        ->whereIn('client_id', ['134'])
        ->orderBy('date')
        ->pluck('date'); // Fetch all leave dates as a collection

      $leavedataforcalander = $leaveDates->first();
      $leavedataforcalander1 = $leaveDates->last();

      $leavebreakdateassign = null;
      // dd($leaveDates);
      foreach ($leaveDates as $leaveDate) {
        $increamentonedays = Carbon::parse($leaveDate)->addDay()->format('Y-m-d');

        $timesheetRecord = DB::table('timesheetusers')
          ->where('status', '0')
          ->where('createdby', $authUserId)
          ->where('date', $increamentonedays)
          ->exists();

        if (!$timesheetRecord) {
          $leavebreakdateassign = $leaveDate;
          break; // Terminate loop when first available date is found
        }
      }

      // Fetch rejoining data
      $rejoiningdate = $this->getRejoiningDate($authUserId, $lasttimesheetsubmiteddata);
      // Calculate difference in days
      $differenceInDays = $this->calculateDateDifference(
        $lasttimesheetsubmiteddata,
        $timesheetmaxDateRecord,
        $leavedataforcalander,
        $rejoiningdate
      );

      $newteammember = null;
      if (!$lasttimesheetsubmiteddata) {
        // Fetch new team member joining date
        $newteammember = DB::table('teammembers')
          ->where('id', $authUserId)
          ->value('joining_date');
      }
      // dd($timesheetmaxDateRecord);
      return view('backEnd.timesheet.create', compact('client', 'teammember', 'assignment', 'partner', 'timesheetrejectData', 'lasttimesheetsubmiteddata', 'timesheetmaxDateRecord', 'leavedataforcalander1', 'differenceInDays', 'newteammember', 'rejoiningdate', 'leavebreakdateassign'));
    }
  }
// final code
if (isset($request->timesheetdate)) {
and } elseif (auth()->user()->role_id == 13) {


  $clientss = DB::table('assignmentmappings')
  ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
  ->leftJoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
  ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
  ->where(function ($query) {
    $query->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
      ->orWhere('assignmentmappings.otherpartner', auth()->user()->teammember_id)
      ->orWhere('assignmentteammappings.teammember_id', auth()->user()->teammember_id);
  })
  ->where(function ($query) use ($selectedDate) {
    $query->whereNull('otpverifydate')
      ->orWhere('otpverifydate', '>=', $selectedDate->modify('-1 day'));
  })
  // ->whereNotNull('clients.client_name')
  ->select('clients.client_name', 'clients.id', 'clients.client_code')
  ->orderBy('client_name', 'ASC')
  ->distinct()->get();


// create function 
// auth 13
$clientss = DB::table('clients')
->leftJoin('assignmentbudgetings', 'assignmentbudgetings.client_id', '=', 'clients.id')
->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', '=', 'assignmentbudgetings.assignmentgenerate_id')
->leftJoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
->where('assignmentbudgetings.status', 1)
->where(function ($query) {
  $query->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
    ->orWhere('assignmentmappings.otherpartner', auth()->user()->teammember_id)
    ->orWhere('assignmentteammappings.teammember_id', auth()->user()->teammember_id);
})
->select('clients.client_name', 'clients.id', 'clients.client_code')
->distinct()
->orderBy('clients.client_name', 'ASC')
->get();



if (isset($request->cid)) {
  
DB::table('assignmentbudgetings')
                ->where('assignmentbudgetings.client_id', $request->cid)
                ->leftJoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
                ->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
                ->leftJoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
                ->where(function ($query) {
                  $query->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
                    ->orWhere('assignmentmappings.otherpartner', auth()->user()->teammember_id)
                    ->orWhere('assignmentteammappings.teammember_id', auth()->user()->teammember_id);
                })
                ->where(function ($query) use ($selectedDate) {
                  $query->whereNull('otpverifydate')
                    ->orWhere('otpverifydate', '>=', $selectedDate->modify('-1 day'));
                })
                ->orderBy('assignment_name')->get()

// final code end 







  $clientssxx = DB::table('assignmentteammappings')
  ->leftjoin('assignmentmappings', 'assignmentmappings.id', 'assignmentteammappings.assignmentmapping_id')
  ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
  ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
  ->orwhere('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
  // i have add this line becouse manager contain it but staff not contain it so basically after add this code no contain staff and manager 
  // ->whereNotIn('assignmentbudgetings.assignmentname', ['Unallocated', 'Official Travel', 'Off/Holiday', 'Seminar/Conference/Post Qualification Course'])
  ->where('assignmentbudgetings.status', 1)
  ->select('clients.client_name', 'clients.id', 'clients.client_code')
  ->orderBy('client_name', 'ASC')
  ->distinct()->get();




  $clientss = DB::table('assignmentmappings')
  ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
  ->leftJoin('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
  ->leftJoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
  ->where('assignmentbudgetings.status', 1)
  ->where(function ($query) {
    $query->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
      ->orWhere('assignmentmappings.otherpartner', auth()->user()->teammember_id)
      ->orWhere('assignmentteammappings.teammember_id', auth()->user()->teammember_id);
  })
  ->select('clients.client_name', 'clients.id', 'clients.client_code')
  ->orderBy('clients.client_name', 'ASC')
  ->distinct()
  ->get();

dd($clientss);





   // Start Hare 
   $rejoiningusersonanotherpost = DB::table('teamrolehistory')
   ->select('id', 'teammember_id')
   ->distinct('teammember_id')
   ->get();

$rejoiningusersonsamepost = DB::table('rejoiningsamepost')
   ->select('id', 'teammember_id')
   ->distinct('teammember_id')
   ->get();

$teammember = $rejoiningusersonanotherpost->merge($rejoiningusersonsamepost);

foreach ($teammember as $user) {

   $lastSubmissionDate = DB::table('timesheetusers')
       ->where('createdby', $user->teammember_id)
       ->where('date', '<=', now()->subWeeks(1)->endOfWeek())
       ->where('status', '!=', 0)
       ->where(function ($query) {
           $query->whereRaw('DAYOFWEEK(date) = 1') // Sunday
               ->orWhereRaw('DAYOFWEEK(date) = 7'); // Saturday
       })
       ->max('date');


   $user->last_submission_date  = $lastSubmissionDate ? Carbon::parse($lastSubmissionDate)->format('d-m-Y') : '';
   // Check for rejoining users
   // dd($user->last_submission_date);
   $rejoiningDataall = DB::table('teammembers')
       ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
       ->leftJoin('rejoiningsamepost', 'rejoiningsamepost.teammember_id', '=', 'teammembers.id')
       ->where('teammembers.id', $user->teammember_id)
       ->select(
           'teamrolehistory.rejoiningdate',
           'rejoiningsamepost.rejoiningdate as samepostrejoiningdate'
       )
       ->first();

   if ($rejoiningDataall) {
       $rejoiningDatestore = $rejoiningDataall->samepostrejoiningdate ?? $rejoiningDataall->rejoiningdate;

       if ($rejoiningDatestore) {
           $rejoiningDateCarbon = Carbon::parse($rejoiningDatestore);

           if ($lastSubmissionDate) {
               $lastSubmissionCarbon = Carbon::parse($lastSubmissionDate);

               if (!$lastSubmissionCarbon->greaterThan($rejoiningDateCarbon)) {
                   $user->last_submission_date = ''; // Skip user
               }
           } else {
               $user->last_submission_date = ''; // Skip user
           }
       }
   }
   // Check for rejoining users  end hare
}
   // Start Hare 
    //*
    <select required class="form-control basic-multiple" multiple="multiple" id="exampleFormControlSelect1"
    name="targettype[]">
    <option value="" disabled> Please Select One</option>
    <option value="1">Individual</option>
    <option value="2">All Member</option>
    <option value="3">Partner</option>
    <option value="4">Manager</option>
    <option value="5">Staff</option>
    <option value="6">IT Department</option>
    <option value="7">Accountant</option>
</select>
    @if ($teammemberData->status == 0)
    <a href="{{ url('/changeteamStatus/' . $teammemberData->status . '/1/' . $teammemberData->id) }}"
        onclick="return confirm('Are you sure you want to Active this teammember?');">
        <button class="btn btn-danger" data-toggle="modal"
            style="height: 16px; width: auto; border-radius: 7px; display: flex; align-items: center; justify-content: center;font-size: 11px;"
            data-target="#requestModal">Inactive1</button>
    </a>
@else
    <a href="{{ url('/changeteamStatus/' . $teammemberData->status . '/0/' . $teammemberData->id) }}"
        onclick="return confirm('Are you sure you want to Inactive this teammember?');">
        <button class="btn btn-primary" data-toggle="modal"
            style="height: 16px; width: auto; border-radius: 7px; display: flex; align-items: center; justify-content: center;font-size: 11px;"
            data-target="#requestModal">Active1</button>
    </a>
@endif

public function changeteamStatus($status, $teamid)
{
    try {

        dd($teamid);
        if ($status == 1) {
            DB::table('teammembers')->where('id', $teamid)->update([
                'timesheet_access'         =>  1,
            ]);
        } else {
            DB::table('teammembers')->where('id', $teamid)->update([
                'timesheet_access'         =>  0,
            ]);
        }
        $output = array('msg' => 'Update Successfully');
        return back()->with('success', $output);
    } catch (Exception $e) {
        DB::rollBack();
        Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
        report($e);
        $output = array('msg' => $e->getMessage());
        return back()->withErrors($output)->withInput();
    }
}
    // Start Hare 
    //*
    // Start Hare 
    //*
    // Start Hare 
    //*
    // Start Hare 
    //*
    // Start Hare 
    //*
    // Start Hare 
    //*
    // Start Hare 
    //*
    // Start Hare 
    //*
    // Start Hare 
    //*
    // Start Hare 
    //*
    // Start Hare 
    //*
    public function adminattendancereport(Request $request)
    {
        $teamnid = $request->input('teammemberId');
        $startdate = Carbon::parse($request->input('startdate'));
        $enddate = Carbon::parse($request->input('enddate'));

        // Convert start and end dates to their respective month numbers like Month number (1-12)
        $startMonth = $startdate->format('n');
        $startYear = $startdate->format('Y');

        $endMonth = $enddate->format('n');
        $endYear = $enddate->format('Y');

        // Retrieve all team members
        if (auth()->user()->role_id == 11 || auth()->user()->role_id == 13) {
            $teammembers = DB::table('teammembers')
                ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
                ->whereIn('teammembers.role_id', [14, 15, 13, 11])
                ->select('teammembers.team_member', 'teamrolehistory.newstaff_code', 'teammembers.id', 'teammembers.staffcode')
                ->orderBy('team_member', 'ASC')
                ->get();
        } else {
            $teammembers = DB::table('teammembers')
                ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
                ->where('teammembers.id', auth()->user()->teammember_id)
                ->select('teammembers.team_member', 'teamrolehistory.newstaff_code', 'teammembers.id', 'teammembers.staffcode')
                ->orderBy('team_member', 'ASC')
                ->get();
        }

        // Fetch single user data
        $singleusersearched = DB::table('teammembers')
            ->where('id', $teamnid)
            ->select('team_member', 'staffcode', 'id', 'leavingdate', 'joining_date')
            ->first();

        // Check leaving date validation
        if ($singleusersearched && $singleusersearched->leavingdate) {
            $leavingdate = Carbon::parse($singleusersearched->leavingdate);
            if ($startdate->gt($leavingdate)) {
                $output = ['msg' => 'User left on ' . $leavingdate->format('d-m-Y') . ', cannot select beyond this date.'];
                $request->flash();
                return redirect()->to('attendance')->with('statuss', $output);
            }
        }

        // Check joining date validation
        if ($singleusersearched && $singleusersearched->joining_date) {
            $joiningdate = Carbon::parse($singleusersearched->joining_date);
            if ($joiningdate->gt($enddate)) {
                $output = ['msg' => 'User joined on ' . $joiningdate->format('d-m-Y') . ', cannot select before this date.'];
                $request->flash();
                return redirect()->to('attendance')->with('statuss', $output);
            }
        }

        // Build attendance query filtered by month
        $query = DB::table('attendances')
            ->leftJoin('teammembers', 'teammembers.id', 'attendances.employee_name')
            ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
            ->leftJoin('rejoiningsamepost', 'rejoiningsamepost.teammember_id', '=', 'teammembers.id')
            ->leftJoin('roles', 'roles.id', 'teammembers.role_id')

            ->select(
                'attendances.*',
                'teammembers.team_member',
                'teammembers.staffcode',
                'teamrolehistory.newstaff_code',
                'teammembers.employment_status',
                'roles.rolename',
                'teamrolehistory.rejoiningdate',
                'teamrolehistory.promotion_date',
                'rejoiningsamepost.rejoiningdate as samepostrejoiningdate',
                'teammembers.joining_date'
            )
            get();

        if ($teamnid) {
            $query->where('attendances.employee_name', $teamnid);
        }

        // // Filter where the attendance month falls between the start and end month
        // if ($startMonth && $endMonth) {
        //     $query->whereBetween(DB::raw('MONTH(STR_TO_DATE(CONCAT(attendances.month, " 1, 2000"), "%M %d, %Y"))'), [$startMonth, $endMonth]);
        // }

        // Filter attendance records by month and year
        if ($startMonth && $endMonth && $startYear && $endYear) {
            $query->whereBetween(DB::raw('MONTH(STR_TO_DATE(CONCAT(attendances.month, " 1, 2000"), "%M %d, %Y"))'), [$startMonth, $endMonth])
                ->whereBetween('attendances.year', [$startYear, $endYear]);
        }

        // ordering using month name like Dec,Nov,Oct etc
        $query->orderBy('attendances.year', 'desc')
            ->orderBy(DB::raw('MONTH(STR_TO_DATE(CONCAT(attendances.month, " 1, 2000"), "%M %d, %Y"))'), 'desc');

        $attendanceDatas = $query->get();
        $request->flash();
        dd($attendanceDatas);

        if (auth()->user()->role_id == 11 || auth()->user()->role_id == 13) {
            return view('backEnd.attendance.adminattendance', compact('attendanceDatas', 'teammembers'));
        } else {
            return view('backEnd.attendance.teamattendance', compact('attendanceDatas', 'teammembers'));
        }
    }
  22222222222222222222222222222222222222222222222222222222222222
  
  Illuminate\Support\Collection {#3002 ▼
    #items: array:27 [▼
      0 => {#2967 ▼
        +"id": 770
        +"team_member": "Amit"
        OCT - DECEMBER
      }
      2 => {#2687 ▼
        +"id": 772
        +"team_member": "Ankit Kumar"
        OCT - DECEMBER
      }
      3 => {#3001 ▼
        +"id": 806
        +"team_member": "Sachin Kumar"
        OCT - DECEMBER
      }
      4 => {#3003 ▼
        +"id": 794
        +"team_member": "Tannu Sharma"
         JULY - DECEMBER
      }
      5 => {#2999 ▼
        +"id": 913
        +"team_member": "Ananya Singh"
         JULY - DECEMBER
      }
  
      6 => {#2998 ▼
        +"id": 943
        +"team_member": "Nitin"
         OCT - DECEMBER
      }
      7 => {#2995 ▼
        +"id": 835
        +"team_member": "Vishal Singh"  2 peaople
        staffcode M1001
         oct - DECEMBER and may
      }

      9 => {#2993 ▼
        +"id": 940
        +"team_member": "Subhash Kumar Mishra"
         oct - DECEMBER
      }
      10 => {#2992 ▼
        +"id": 944
        +"team_member": "Vishal Kumar Thakur"  why
         april - DECEMBER
      }
  
      11 => {#2991 ▼
        +"id": 938
        +"team_member": "Sandeep Singh"
         oct - DECEMBER
      }
      12 => {#2990 ▼
        +"id": 916
        +"team_member": "Punit Kumar"
         oct - DECEMBER
      }
      13 => {#2989 ▼
        +"id": 947
        +"team_member": "Sarthak Kejriwal"
        oct - DECEMBER
      }
      14 => {#2988 ▼
        +"id": 891
        +"team_member": "Sudheer Rawat"
         JULY - DECEMBER
      }
      15 => {#2987 ▼
        +"id": 805
        +"team_member": "Ravi Kumar"
         nov - DECEMBER
      }

      13 => {#2989 ▼
        +"id": 944
        +"team_member": "Vishal Kumar Thakur"
        +"staffcode": "M1077"
        september - DECEMBER
      }

      1 => {#2996 ▼
        +"id": 777
        +"team_member": "Ghanhsyam Kumar Singh"
         JULY - DECEMBER

      }
      
      8 => {#2994 ▼
        +"id": 832
        +"team_member": "Vaibhav Arora"
         september - DECEMBER
      }

      16 => {#2986 ▼
        +"id": 791
        +"team_member": "Riddima Aggarwal"
         JULY - DECEMBER
      }
      17 => {#2985 ▼
        +"id": 889
        +"team_member": "Mohit Kumar"
         JULY - DECEMBER
      }
      18 => {#2984 ▼
        +"id": 782
        +"team_member": "Antima Jhajhra"
         JULY - DECEMBER
      }
      19 => {#2983 ▼
        +"id": 828
        +"team_member": "Sahil Kumar"
         JULY - DECEMBER
      }
      20 => {#2982 ▼
        +"id": 881
        +"team_member": "Rohit kumar"
         JULY - DECEMBER
      }
      21 => {#2981 ▼
        +"id": 817
        +"team_member": "Hemant Kumar"
         JULY - DECEMBER
      }
      22 => {#2980 ▼
        +"id": 811
        +"team_member": "Tushar Garg"
         JULY - DECEMBER
      }
      23 => {#2979 ▼
        +"id": 785
        +"team_member": "Kanika Singhal"
         JULY - DECEMBER
      }
      24 => {#2978 ▼
        +"id": 830
        +"team_member": "Sohan Jha"
         JULY - DECEMBER
      }
      25 => {#2977 ▼
        +"id": 879
        +"team_member": "Jassi Gupta"
         JULY - DECEMBER
      }
      26 => {#3006 ▼
        +"id": 812
        +"team_member": "Yog Madhu"
         JULY - DECEMBER
      }
    ]
    #escapeWhenCastingToString: false
  }

  #items: array:32 [▼
    11 => {#2991 ▼
      +"id": 832
      +"team_member": "Vaibhav Arora"
      +"staffcode": "M1021"
    }
    12 => {#2990 ▼
      +"id": 940
      +"team_member": "Subhash Kumar Mishra"
      +"staffcode": "M1073"
    }
    13 => {#2989 ▼
      +"id": 944
      +"team_member": "Vishal Kumar Thakur"
      +"staffcode": "M1077"
    }
    14 => {#2988 ▼
      +"id": 938
      +"team_member": "Sandeep Singh"
      +"staffcode": "M1071"
    }
    15 => {#2987 ▼
      +"id": 916
      +"team_member": "Punit Kumar"
      +"staffcode": "M1057"
    }
    16 => {#2986 ▼
      +"id": 947
      +"team_member": "Sarthak Kejriwal"
      +"staffcode": "M1080"
    }
    17 => {#2985 ▼
      +"id": 891
      +"team_member": "Sudheer Rawat"
      +"staffcode": "S1055"
    }
    18 => {#2984 ▼
      +"id": 805
      +"team_member": "Ravi Kumar"
      +"staffcode": "S1039"
    }

    ->whereIn('id', [891])
    ->whereIn('attendances.month', ['November'])
    21 => {#2981 ▼
      +"id": 791
      +"team_member": "Riddima Aggarwal"
      +"staffcode": "S1025"
    }
    22 => {#2980 ▼
      +"id": 889
      +"team_member": "Mohit Kumar"
      +"staffcode": "S1053"
    }
    23 => {#2979 ▼
      +"id": 782
      +"team_member": "Antima Jhajhra"
      +"staffcode": "S1016"
    }
    24 => {#2978 ▼
      +"id": 828
      +"team_member": "Sahil Kumar"
      +"staffcode": "M1017"
    }
    25 => {#2977 ▼
      +"id": 881
      +"team_member": "Rohit kumar"
      +"staffcode": "S1050"
    }
    26 => {#3006 ▼
      +"id": 817
      +"team_member": "Hemant Kumar"
      +"staffcode": "M1006"
    }
    27 => {#3007 ▼
      +"id": 811
      +"team_member": "Tushar Garg"
      +"staffcode": "S1045"
    }
    28 => {#3008 ▼
      +"id": 785
      +"team_member": "Kanika Singhal"
      +"staffcode": "S1019"
    }
    29 => {#3009 ▼
      +"id": 830
      +"team_member": "Sohan Jha"
      +"staffcode": "M1019"
    }
    30 => {#3010 ▼
      +"id": 879
      +"team_member": "Jassi Gupta"
      +"staffcode": "S1048"
    }
    31 => {#3011 ▼
      +"id": 812
      +"team_member": "Yog Madhu"
      +"staffcode": "S1046"
    }
  ]


  22222222222222222222222222222222222222222222222222222222222222
  950 Ayush Garg 07   02-08-2024	July
  Architta Kataria 07   	02-08-2024	July
  Akansha Prakash 07  oct nov extra 
  Taniya Aggarwal 07  extra 

  Nalin Kumar  08  extra


  Vijay Kumar 09  extra

  Brij Mohan 09
  Sandeep Singh 09

  Nitin Patel  10
  Puneet Kumar Khandelwal	 10
  Akansha Prakash 10
  K V S R Krishna 10
  Ajay Gupta 10
  Rachit Khanna 10
  Deepanshu Guglani 10
  R. Raghuraman 10
  Taniya Aggarwal 10
  Karthik Srinivasan 10
  Aman Goel 10
  N.S Padmanabhan 10
  Vijay Kumar 10 
  Nalin Kumar 10
  Brij Mohan 10
  M.S. Balachandran 10
  Surya Kant Verma 10
  Shobhit Garg 10
  Deepak Gupta 10
  Vishal Agarwal 10
  Tarun Sethi 10

  Deepak Gupta 11
  Brij Mohan 11
  Nalin Kumar 11 
  Deepanshu Guglani 11
  Shobhit Garg
  Puneet Kumar Khandelwal
  Rachit Khanna
  Taniya Aggarwal
  Tarun Sethi
  Nitin Patel
  K V S R Krishna

  Ajay Gupta
  R. Raghuraman
  Harsh Bindal
  Karthik Srinivasan
  Akansha Prakash
  Aman Goel
  Vijay Kumar
  Vishal Agarwal
  N.S Padmanabhan
  Aman Yadav
  M.S. Balachandran



  22222222222222222222222222222222222222222222222
      // public function handle()
    // {
    //     $teammembers = DB::table('teammembers')
    //         // ->where('status', 1)
    //         ->whereIn('id', [770, 777, 772, 806, 943, 835, 832, 940, 938, 916, 947, 805])
    //         ->pluck('id')
    //         ->toArray();



    //     foreach ($teammembers as $teammemberid) {

    //         $allattendanceDatas = Attendance::join('teammembers', 'teammembers.id', 'attendances.employee_name')
    //             ->where('attendances.employee_name', $teammemberid)
    //             ->whereIn('attendances.month', ['October', 'November', 'December'])
    //             ->select(
    //                 'attendances.*',
    //                 'teammembers.team_member',
    //             )
    //             ->get();



    //         foreach ($allattendanceDatas as $allattendanceData) {
    //             $monthcase = strtolower($allattendanceData->month);
    //             // dd($monthcase);
    //             // if ($monthcase != 'october' && $monthcase != 'november') {
    //             if ($monthcase == 'april') {
    //                 $monthdate = date('Y-m-d', strtotime('2024-04-02 11:00:11'));
    //             } elseif ($monthcase == 'may') {
    //                 $monthdate = date('Y-m-d', strtotime('2024-05-02 11:00:11'));
    //             } elseif ($monthcase == 'june') {
    //                 $monthdate = date('Y-m-d', strtotime('2024-06-02 11:00:11'));
    //             } elseif ($monthcase == 'july') {
    //                 $monthdate = date('Y-m-d', strtotime('2024-07-02 11:00:11'));
    //             } elseif ($monthcase == 'august') {
    //                 $monthdate = date('Y-m-d', strtotime('2024-08-02 11:00:11'));
    //             } elseif ($monthcase == 'september') {
    //                 $monthdate = date('Y-m-d H:i:s', strtotime('2024-09-02 11:00:11'));
    //             } elseif ($monthcase == 'october') {
    //                 $monthdate = date('Y-m-d H:i:s', strtotime('2024-10-02 11:00:11'));
    //             } elseif ($monthcase == 'november') {
    //                 $monthdate = date('Y-m-d H:i:s', strtotime('2024-11-02 11:00:11'));
    //             } elseif ($monthcase == 'december') {
    //                 $monthdate = date('Y-m-d H:i:s', strtotime('2024-12-02 11:00:11'));
    //             }

    //             $gettotaldays = Carbon::parse($monthdate);
    //             $totalDaysInMonth = $gettotaldays->daysInMonth;
    //             // dd($allattendanceDatas, 11);

    //             $keysToFilter = [
    //                 'twentysix',
    //                 'twentyseven',
    //                 'twentyeight',
    //                 'twentynine',
    //                 'thirty',
    //                 'thirtyone',
    //                 'one',
    //                 'two',
    //                 'three',
    //                 'four',
    //                 'five',
    //                 'six',
    //                 'seven',
    //                 'eight',
    //                 'nine',
    //                 'ten',
    //                 'eleven',
    //                 'twelve',
    //                 'thirteen',
    //                 'fourteen',
    //                 'fifteen',
    //                 'sixteen',
    //                 'seventeen',
    //                 'eighteen',
    //                 'ninghteen',
    //                 'twenty',
    //                 'twentyone',
    //                 'twentytwo',
    //                 'twentythree',
    //                 'twentyfour',
    //                 'twentyfive'
    //             ];

    //             // dd($allattendanceData);
    //             $days = array_intersect_key($allattendanceData->toArray(), array_flip($keysToFilter));
    //             $dayspresent = 0;
    //             $casualLeaveCount = 0;
    //             $examLeaveCount = 0;
    //             $travelCount = 0;
    //             $offholidaysCount = 0;
    //             $sundayCount = 0;
    //             $holidaysCount = 0;
    //             // $beforejoinigCount = 0;

    //             foreach ($days as $key => $value) {
    //                 if ($value == 'P') {
    //                     $dayspresent++;
    //                 } else if ($value == 'CL') {
    //                     $casualLeaveCount++;
    //                 } else if ($value == 'EL') {
    //                     $examLeaveCount++;
    //                 } else if ($value == 'T') {
    //                     $travelCount++;
    //                 } else if ($value == 'OH') {
    //                     $offholidaysCount++;
    //                 } else if ($value == 'W') {
    //                     $sundayCount++;
    //                 } else if ($value == 'H') {
    //                     $holidaysCount++;
    //                 }
    //                 //  else if ($value == null) {
    //                 //     $beforejoinigCount++;
    //                 // }
    //             }

    //             $dayspresentcount = $dayspresent;
    //             $casualLeave = $casualLeaveCount;
    //             $examLeave =  $examLeaveCount;
    //             $travel =  $travelCount;
    //             $offholidays =  $offholidaysCount;
    //             $sunday =  $sundayCount;
    //             $holidays =  $holidaysCount;
    //             // $sunday =  $beforejoinigCount;

    //             $attendanceData = [
    //                 'total_no_of_days' => $totalDaysInMonth,
    //                 'no_of_days_present' => $dayspresentcount,
    //                 'casual_leave' => $casualLeave,
    //                 'exam_leave' => $examLeave,
    //                 'holidays' => $holidays,
    //                 'travel' => $travel,
    //                 'offholidays' => $offholidays,
    //                 'sundaycount' => $sunday,
    //                 // 'beforejoiningcount' => $beforejoinigCount,
    //             ];
    //             // dd($attendanceData);
    //             DB::table('attendances')->where('id', $allattendanceData->id)
    //                 ->update($attendanceData);
    //             // }
    //         }
    //     }

    //     dd('Count updated success 1');
    // }
  22222222222222222222222222222222222222222222222
  $teamcount = DB::table('teammembers')
      ->join('leaveapprove', 'teammembers.id', '=', 'leaveapprove.teammemberid')
      ->where('teammembers.status', 1)
      ->whereBetween('leaveapprove.created_at', ['2024-08-01 00:00:00', '2024-12-05 23:59:59'])
      ->where('leaveapprove.totaldays', '>', 15)
      // ->pluck('teammembers.id')
      ->select(
        'teammembers.id',
        'teammembers.team_member',
        'teammembers.staffcode',
      )
      ->get();

    dd($teamcount);


  Illuminate\Support\Collection {#3002 ▼
    #items: array:27 [▼
      0 => {#2967 ▼
        +"id": 770
        +"team_member": "Amit"
        OCT - DECEMBER
      }
      2 => {#2687 ▼
        +"id": 772
        +"team_member": "Ankit Kumar"
        OCT - DECEMBER
      }
      3 => {#3001 ▼
        +"id": 806
        +"team_member": "Sachin Kumar"
        OCT - DECEMBER
      }
      // 4 => {#3003 ▼
      //   +"id": 794
      //   +"team_member": "Tannu Sharma"
      //    JULY - DECEMBER
      // }
      // 5 => {#2999 ▼
      //   +"id": 913
      //   +"team_member": "Ananya Singh"
      //    JULY - DECEMBER
      // }
  
      6 => {#2998 ▼
        +"id": 943
        +"team_member": "Nitin"
         OCT - DECEMBER
      }
      7 => {#2995 ▼
        +"id": 835
        +"team_member": "Vishal Singh"  2 peaople
        staffcode M1001
         oct - DECEMBER and may
      }

      9 => {#2993 ▼
        +"id": 940
        +"team_member": "Subhash Kumar Mishra"
         oct - DECEMBER
      }
      // 10 => {#2992 ▼
      //   +"id": 944
      //   +"team_member": "Vishal Kumar Thakur"  why
      //    april - DECEMBER
      // }
  
      11 => {#2991 ▼
        +"id": 938
        +"team_member": "Sandeep Singh"
         oct - DECEMBER
      }
      12 => {#2990 ▼
        +"id": 916
        +"team_member": "Punit Kumar"
         oct - DECEMBER
      }
      13 => {#2989 ▼
        +"id": 947
        +"team_member": "Sarthak Kejriwal"
        oct - DECEMBER
      }
      // 14 => {#2988 ▼
      //   +"id": 891
      //   +"team_member": "Sudheer Rawat"
      //    JULY - DECEMBER
      // }
      15 => {#2987 ▼
        +"id": 805
        +"team_member": "Ravi Kumar"
         nov - DECEMBER
      }

      13 => {#2989 ▼
        +"id": 944
        +"team_member": "Vishal Kumar Thakur"
        +"staffcode": "M1077"
        september - DECEMBER
      }

      1 => {#2996 ▼
        +"id": 777
        +"team_member": "Ghanhsyam Kumar Singh"
         JULY - DECEMBER

      }
      
      8 => {#2994 ▼
        +"id": 832
        +"team_member": "Vaibhav Arora"
         september - DECEMBER
      }

      oct - november
      september - november  832
      JULY - november  777
      // 16 => {#2986 ▼
      //   +"id": 791
      //   +"team_member": "Riddima Aggarwal"
      //    JULY - DECEMBER
      // }
      // 17 => {#2985 ▼
      //   +"id": 889
      //   +"team_member": "Mohit Kumar"
      //    JULY - DECEMBER
      // }
      // 18 => {#2984 ▼
      //   +"id": 782
      //   +"team_member": "Antima Jhajhra"
      //    JULY - DECEMBER
      // }
      // 19 => {#2983 ▼
      //   +"id": 828
      //   +"team_member": "Sahil Kumar"
      //    JULY - DECEMBER
      // }
      // 20 => {#2982 ▼
      //   +"id": 881
      //   +"team_member": "Rohit kumar"
      //    JULY - DECEMBER
      // }
      // 21 => {#2981 ▼
      //   +"id": 817
      //   +"team_member": "Hemant Kumar"
      //    JULY - DECEMBER
      // }
      // 22 => {#2980 ▼
      //   +"id": 811
      //   +"team_member": "Tushar Garg"
      //    JULY - DECEMBER
      // }
      // 23 => {#2979 ▼
      //   +"id": 785
      //   +"team_member": "Kanika Singhal"
      //    JULY - DECEMBER
      // }
      // 24 => {#2978 ▼
      //   +"id": 830
      //   +"team_member": "Sohan Jha"
      //    JULY - DECEMBER
      // }
      // 25 => {#2977 ▼
      //   +"id": 879
      //   +"team_member": "Jassi Gupta"
      //    JULY - DECEMBER
      // }
      // 26 => {#3006 ▼
      //   +"id": 812
      //   +"team_member": "Yog Madhu"
      //    JULY - DECEMBER
      // }
    ]
    #escapeWhenCastingToString: false
  }



2222222222222222222222222222222222222222222
 809, 798, 799, 789, 816
Illuminate\Support\Collection {#3002 ▼
  #items: array:32 [▼
  // 20 => {#2982 ▼
  //   +"id": 816
  //   +"team_member": "Guruvesh Vishwakarma"
  //   +"staffcode": "M1005"
  // }
  // 19 => {#2983 ▼
  //   +"id": 789
  //   +"team_member": "Prerna kandari"
  //   +"staffcode": "S1023"
  // }
  // 9 => {#2993 ▼
  //   +"id": 799
  //   +"team_member": "Parth Agarwal"
  //   +"staffcode": "S1033"
  // }
  // 7 => {#2995 ▼
  //   +"id": 798
  //   +"team_member": "Nitish Kumar Jha"
  //   +"staffcode": "S1032"
  // }
  // 4 => {#3001 ▼
  //   +"id": 809
  //   +"team_member": "Surya Kant Verma"
  //   +"staffcode": "S1043"
  // }




    0 => {#3000 ▼
      +"id": 770
      +"team_member": "Amit"
      +"staffcode": "S1004"
    }
    1 => {#2967 ▼
      +"id": 777
      +"team_member": "Ghanhsyam Kumar Singh"
      +"staffcode": "S1011"
    }
    2 => {#3003 ▼
      +"id": 772
      +"team_member": "Ankit Kumar"
      +"staffcode": "S1006"
    }
    3 => {#2687 ▼
      +"id": 806
      +"team_member": "Sachin Kumar"
      +"staffcode": "S1040"
    }

    5 => {#2999 ▼
      +"id": 794
      +"team_member": "Tannu Sharma"
      +"staffcode": "S1028"
    }
    6 => {#2998 ▼
      +"id": 913
      +"team_member": "Ananya Singh"
      +"staffcode": "S1067"
    }

    8 => {#2994 ▼
      +"id": 943
      +"team_member": "Nitin"
      +"staffcode": "M1076"
    }

    10 => {#2992 ▼
      +"id": 835
      +"team_member": "Vishal Singh"
      +"staffcode": "M1001"
    }
    11 => {#2991 ▼
      +"id": 832
      +"team_member": "Vaibhav Arora"
      +"staffcode": "M1021"
    }
    12 => {#2990 ▼
      +"id": 940
      +"team_member": "Subhash Kumar Mishra"
      +"staffcode": "M1073"
    }
    13 => {#2989 ▼
      +"id": 944
      +"team_member": "Vishal Kumar Thakur"
      +"staffcode": "M1077"
    }
    14 => {#2988 ▼
      +"id": 938
      +"team_member": "Sandeep Singh"
      +"staffcode": "M1071"
    }
    15 => {#2987 ▼
      +"id": 916
      +"team_member": "Punit Kumar"
      +"staffcode": "M1057"
    }
    16 => {#2986 ▼
      +"id": 947
      +"team_member": "Sarthak Kejriwal"
      +"staffcode": "M1080"
    }
    17 => {#2985 ▼
      +"id": 891
      +"team_member": "Sudheer Rawat"
      +"staffcode": "S1055"
    }
    18 => {#2984 ▼
      +"id": 805
      +"team_member": "Ravi Kumar"
      +"staffcode": "S1039"
    }


    21 => {#2981 ▼
      +"id": 791
      +"team_member": "Riddima Aggarwal"
      +"staffcode": "S1025"
    }
    22 => {#2980 ▼
      +"id": 889
      +"team_member": "Mohit Kumar"
      +"staffcode": "S1053"
    }
    23 => {#2979 ▼
      +"id": 782
      +"team_member": "Antima Jhajhra"
      +"staffcode": "S1016"
    }
    24 => {#2978 ▼
      +"id": 828
      +"team_member": "Sahil Kumar"
      +"staffcode": "M1017"
    }
    25 => {#2977 ▼
      +"id": 881
      +"team_member": "Rohit kumar"
      +"staffcode": "S1050"
    }
    26 => {#3006 ▼
      +"id": 817
      +"team_member": "Hemant Kumar"
      +"staffcode": "M1006"
    }
    27 => {#3007 ▼
      +"id": 811
      +"team_member": "Tushar Garg"
      +"staffcode": "S1045"
    }
    28 => {#3008 ▼
      +"id": 785
      +"team_member": "Kanika Singhal"
      +"staffcode": "S1019"
    }
    29 => {#3009 ▼
      +"id": 830
      +"team_member": "Sohan Jha"
      +"staffcode": "M1019"
    }
    30 => {#3010 ▼
      +"id": 879
      +"team_member": "Jassi Gupta"
      +"staffcode": "S1048"
    }
    31 => {#3011 ▼
      +"id": 812
      +"team_member": "Yog Madhu"
      +"staffcode": "S1046"
    }
  ]
  #escapeWhenCastingToString: false
}

  Illuminate\Support\Collection {#3003 ▼
    #items: array:4 [▼
      0 => {#2967 ▼
        +"month": "October"
        +"total_no_of_days": null
      }
      1 => {#3001 ▼
        +"month": "September"
        +"total_no_of_days": null
      }
      2 => {#2687 ▼
        +"month": "August"
        +"total_no_of_days": null
      }
      3 => {#3000 ▼
        +"month": "December"
        +"total_no_of_days": null
      }
    ]
    #escapeWhenCastingToString: false
  }
   

  $teammembers = DB::table('teammembers')
            ->whereBetween('leavingdate', [$startdateleav, $enddateleave])
            // ->where('id', 847)
            ->where('status', 0)
            ->select('id', 'team_member')
            ->get();


  @if (Auth::user()->role_id == 13 || Auth::user()->role_id == 14 || Auth::user()->role_id == 15)
  <td>
      {{-- @if ($client_id->status == 2) --}}
      <a href="{{ url('/timesheetreject/edit/') }}"
          class="btn btn-info-soft btn-sm"><i class="far fa-edit"></i></a>
      {{-- @endif --}}
      {{-- . $client_id->id --}}

  </td>
@endif
    Azaz7463086672
    //*250,182
    2024-09-01
    $createdbyList = DB::table('timesheetusers')
    ->where('createdby', 933)
    ->distinct()
    ->pluck('createdby')
    ->toArray();

// $todaydate = Carbon::parse('2024-08-14 13:30:00');
$todaydate = Carbon::parse('2024-08-21 13:30:00');
         //current date
         $currentDate = now();
         // $currentDate = Carbon::parse('2024-11-01 13:30:00');
    // Start Hare 
    816
    2024-06-11
    //*
    app\Http\Controllers\TimesheetController.php
    $timesheetedit =
    ->where('timesheetusers.id', $id)
    // Start Hare 
    resources\views\backEnd\timesheet\rejectedlist.blade.php
    <a href="{{ url('/timesheetreject/edit/' . $item->id) }}"
    class="btn btn-info-soft btn-sm"><i class="far fa-edit"></i></a>
    // Start Hare 
   
    //*
    // Start Hare 
    //*
    // Start Hare 
    //*
    // Start Hare 
    //*

    if (!empty($column)) {
      $getholidaysss = DB::table('holidays')
        ->where('startdate', '=', $cl_leave)
        ->orWhere('enddate', '=', $cl_leave)
        ->first();
        
      if ($getholidaysss != null) {
        $updateddata = 'H';
        $holidaysColumn = 'holidays';
        // $examleavecountupdate = $attendances->exam_leave += 1;
        $totalcountupdate = $attendances->$holidaysColumn + 1;
        DB::table('attendances')
          ->where('employee_name', $team->createdby)
          ->where('month', $cl_leave_month)
          ->where('year', $cl_leave_year)
          ->update([
            $column => $updateddata,
            'holidays'  => $totalcountupdate,
          ]);
      } else {
        // Update exam leave (El) wording 
        DB::table('attendances')
          ->where('employee_name', $team->createdby)
          ->where('month', $cl_leave_month)
          ->where('year', $cl_leave_year)
          // ->whereRaw("NOT ({$column} REGEXP '^-?[0-9]+$')")
          // ->whereRaw("{$column} != 'LWP'")
          // ->get();
          ->update([
            $column => $lstatus,
            'exam_leave' => $examleavecountupdate,
          ]);
      }
    }
    // Start Hare 
    //*
    // Start Hare 
    //*
    // Start Hare 
    //*
    // Start Hare 
    //*
    // Start Hare 
    //*
    // Start Hare 
    //*
    // Start Hare 
    //*
    // Start Hare 
    //*
    // Start Hare 
    //*
    // Start Hare 
    //*
    // Start Hare 
    //*
    // Start Hare 
    //*
    public function adminattendancereport(Request $request)
    {
        $teamnid = $request->input('teammemberId');
        $startdate = Carbon::parse($request->input('startdate'));
        $enddate = Carbon::parse($request->input('enddate'));

        // Convert start and end dates to their respective month numbers like Month number (1-12)
        $startMonth = $startdate->format('n');
        $startYear = $startdate->format('Y');

        $endMonth = $enddate->format('n');
        $endYear = $enddate->format('Y');

        // Retrieve all team members
        if (auth()->user()->role_id == 11 || auth()->user()->role_id == 13) {
            $teammembers = DB::table('teammembers')
                ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
                ->whereIn('teammembers.role_id', [14, 15, 13, 11])
                ->select('teammembers.team_member', 'teamrolehistory.newstaff_code', 'teammembers.id', 'teammembers.staffcode')
                ->orderBy('team_member', 'ASC')
                ->get();
        } else {
            $teammembers = DB::table('teammembers')
                ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
                ->where('teammembers.id', auth()->user()->teammember_id)
                ->select('teammembers.team_member', 'teamrolehistory.newstaff_code', 'teammembers.id', 'teammembers.staffcode')
                ->orderBy('team_member', 'ASC')
                ->get();
        }

        // Fetch single user data
        $singleusersearched = DB::table('teammembers')
            ->where('id', $teamnid)
            ->select('team_member', 'staffcode', 'id', 'leavingdate', 'joining_date')
            ->first();

        // Check leaving date validation
        if ($singleusersearched && $singleusersearched->leavingdate) {
            $leavingdate = Carbon::parse($singleusersearched->leavingdate);
            if ($startdate->gt($leavingdate)) {
                $output = ['msg' => 'User left on ' . $leavingdate->format('d-m-Y') . ', cannot select beyond this date.'];
                $request->flash();
                return redirect()->to('attendance')->with('statuss', $output);
            }
        }

        // Check joining date validation
        if ($singleusersearched && $singleusersearched->joining_date) {
            $joiningdate = Carbon::parse($singleusersearched->joining_date);
            if ($joiningdate->gt($enddate)) {
                $output = ['msg' => 'User joined on ' . $joiningdate->format('d-m-Y') . ', cannot select before this date.'];
                $request->flash();
                return redirect()->to('attendance')->with('statuss', $output);
            }
        }

        // Build attendance query filtered by month
        $query = DB::table('attendances')
            ->leftJoin('teammembers', 'teammembers.id', 'attendances.employee_name')
            ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
            ->leftJoin('rejoiningsamepost', 'rejoiningsamepost.teammember_id', '=', 'teammembers.id')
            ->leftJoin('roles', 'roles.id', 'teammembers.role_id')

            ->select(
                'attendances.*',
                'teammembers.team_member',
                'teammembers.staffcode',
                'teamrolehistory.newstaff_code',
                'teammembers.employment_status',
                'roles.rolename',
                'teamrolehistory.rejoiningdate',
                'teamrolehistory.promotion_date',
                'rejoiningsamepost.rejoiningdate as samepostrejoiningdate',
                'teammembers.joining_date'
            )
            get();

        if ($teamnid) {
            $query->where('attendances.employee_name', $teamnid);
        }

        // // Filter where the attendance month falls between the start and end month
        // if ($startMonth && $endMonth) {
        //     $query->whereBetween(DB::raw('MONTH(STR_TO_DATE(CONCAT(attendances.month, " 1, 2000"), "%M %d, %Y"))'), [$startMonth, $endMonth]);
        // }

        // Filter attendance records by month and year
        if ($startMonth && $endMonth && $startYear && $endYear) {
            $query->whereBetween(DB::raw('MONTH(STR_TO_DATE(CONCAT(attendances.month, " 1, 2000"), "%M %d, %Y"))'), [$startMonth, $endMonth])
                ->whereBetween('attendances.year', [$startYear, $endYear]);
        }

        // ordering using month name like Dec,Nov,Oct etc
        $query->orderBy('attendances.year', 'desc')
            ->orderBy(DB::raw('MONTH(STR_TO_DATE(CONCAT(attendances.month, " 1, 2000"), "%M %d, %Y"))'), 'desc');

        $attendanceDatas = $query->get();
        $request->flash();
        dd($attendanceDatas);

        if (auth()->user()->role_id == 11 || auth()->user()->role_id == 13) {
            return view('backEnd.attendance.adminattendance', compact('attendanceDatas', 'teammembers'));
        } else {
            return view('backEnd.attendance.teamattendance', compact('attendanceDatas', 'teammembers'));
        }
    }
    // Start Hare 
    //*
    // $timesheet = '2024-09-24';
    // $hdatess = Carbon::parse($timesheet)->format('Y-m-d');
    // $day = Carbon::parse($hdatess)->format('d');
    // $month = Carbon::parse($hdatess)->format('F');
    // $yeardata = Carbon::parse($hdatess)->format('Y');

    // $prevcheck = DB::table('attendances')
    //   ->where('employee_name', 816)
    //   ->where('month', $month)
    //   ->orderBy('id', 'desc')
    //   // ->orderBy('id', 'asc')
    //   ->first();

    // dd($prevcheck);

    // $nextweektimesheet1 = DB::table('timesheetusers')
    //   ->where('createdby', 940)
    //   ->whereBetween('date', ['2024-09-30', '2024-10-13'])
    //   // ->get();
    //   ->update(['status' => 0]);


    // $nextweektimesheet2 = DB::table('timesheets')
    //   ->where('created_by', 940)
    //   ->whereBetween('date', ['2024-09-30', '2024-10-13'])
    //   // ->get();
    //   ->update(['status' => 0]);

    // // more than one week delete 
    // $result = ['2024-09-30', '2024-10-07'];
    // foreach ($result as $date) {
    //   $nextweektimesheet3 = DB::table('timesheetreport')
    //     ->where('teamid', 940)
    //     ->where('startdate', $date)
    //     // ->get();
    //     ->delete();
    // }
    // dd('hi 1');
    // Start Hare 
    //*
    public function handle()
    {
        if ('Wednesday' == date('l', time())) {
            // All employee temmeber id 
            $createdbyList = DB::table('timesheetusers')->distinct()->pluck('createdby')->toArray();

            // Implementation for all employee
            foreach ($createdbyList as $createdby) {
                // Exam leave data get hare
                $usertimesheetfirstdate =  DB::table('timesheetusers')
                    ->where('status', '0')
                    ->where('assignment_id', 214)
                    ->where('createdby', $createdby)
                    ->orderBy('date', 'ASC')->first();
                // Exam leave data should not be empty
                if ($usertimesheetfirstdate && !empty($usertimesheetfirstdate->date)) {

                    $date = Carbon::createFromFormat('Y-m-d', $usertimesheetfirstdate->date);
                    // Automatic submit will be on this date 
                    // find days name Wednesday 
                    $autosubmitdate = $date->copy()->next(Carbon::SUNDAY)->addDays(3);
                    // $autosubmitdate = $date->copy()->next(Carbon::SUNDAY)->addDays(5);
                    $todaydate = Carbon::now('Asia/Kolkata');

                    //autosubmitdate and todaydate should be same 
                    if ($autosubmitdate->isSameDay($todaydate)) {
                        $lastdate = Carbon::createFromFormat('Y-m-d', $usertimesheetfirstdate->date)->addDays(6);

                        $firstDate = new DateTime($usertimesheetfirstdate->date);
                        $dayOfWeek = $firstDate->format('w');

                        $daysToAdd = 0;

                        if ($dayOfWeek !== '0') {
                            $daysToAdd = 7 - $dayOfWeek;
                        }

                        if ($dayOfWeek > 0) {
                            $daysToSubtract = $dayOfWeek - 1;
                        } else {
                            $daysToSubtract = $dayOfWeek;
                        }
                        $upcomingSunday = (new DateTime($firstDate->format('Y-m-d')))->modify("+$daysToAdd days")->format('Y-m-d');
                        $presentWeekMonday = (new DateTime($firstDate->format('Y-m-d')))->modify("-$daysToSubtract days")->format('Y-m-d');

                        // Get six data of exam leave 
                        $get_six_Data = DB::table('timesheetusers')
                            ->where('status', '0')
                            ->where('assignment_id', 214)
                            ->where('createdby', $createdby)
                            ->whereBetween('date', [$firstDate->format('Y-m-d'), $upcomingSunday])
                            ->orderBy('date', 'ASC')
                            ->get();

                        $lastdate = $get_six_Data->max('date');

                        // get date only of retrived data 
                        $retrievedDates = [];
                        foreach ($get_six_Data as $entry) {
                            $date = new DateTime($entry->date);
                            $retrievedDates[] = $date->format('Y-m-d');
                        }

                        $firstDate = new DateTime($presentWeekMonday);
                        $upcomingSundayDate = new DateTime($upcomingSunday);
                        $currentDate = clone $firstDate;

                        $expectedDates = [];
                        while ($currentDate->format('Y-m-d') < $upcomingSundayDate->format('Y-m-d')) {
                            //excluding sunday
                            $expectedDates[] = $currentDate->format('Y-m-d');
                            $currentDate->modify("+1 day");
                        }

                        $missingDates = array_diff($expectedDates, $retrievedDates);
                        // missing date should be empty 
                        if (empty($missingDates)) {
                            foreach ($get_six_Data as $getsixdata) {
                                $requestedDate = Carbon::createFromFormat('Y-m-d', $getsixdata->date);

                                if (date('l', strtotime(date('d-m-Y', strtotime($getsixdata->date)))) == 'Monday') {
                                    $previousMonday = $requestedDate->copy()->previous(Carbon::MONDAY);
                                    // Find the nearest next Saturday to the requested date
                                    $nextSaturday = $requestedDate->copy()->next(Carbon::SATURDAY);
                                    $previousMondayFormatted = $getsixdata->date;
                                    $nextSaturdayFormatted = $nextSaturday->format('Y-m-d');
                                    $nextSaturdayFormatted = $lastdate;

                                    $week =  date('d-m-Y', strtotime($previousMondayFormatted))  . ' to ' . date('d-m-Y', strtotime($nextSaturdayFormatted));

                                    $co = DB::table('timesheetusers')
                                        ->where('status', '0')
                                        ->where('assignment_id', 214)
                                        ->where('createdby', $createdby)
                                        ->whereBetween('date', [$previousMondayFormatted, $nextSaturdayFormatted])
                                        ->select(DB::raw('SUM(hour) as total_hours'), DB::raw('COUNT(DISTINCT timesheetid) as row_count'))
                                        ->get();

                                    foreach ($co as $codata) {
                                        DB::table('timesheetreport')->insert([
                                            'teamid'       =>     $createdby,
                                            'week'       =>     $week,
                                            'totaldays'       =>     $codata->row_count,
                                            'totaltime' =>  $codata->total_hours,
                                            'startdate'  => $previousMondayFormatted,
                                            'enddate'  => $nextSaturdayFormatted,
                                            'created_at'                =>      date('y-m-d H:i:s'),
                                        ]);
                                    }
                                }

                                DB::table('timesheetusers')->where('id', $getsixdata->id)->update([
                                    'status'         =>     1,
                                    'updated_at'              =>     date('y-m-d H:i:s'),
                                ]);

                                DB::table('timesheets')->where('id', $getsixdata->timesheetid)->update([
                                    'status'         =>     1,
                                    'updated_at'              =>     date('y-m-d H:i:s'),
                                ]);
                            }
                        }

                        //   return 'message'
                    }
                }
            }
        }
    }

    // public function handle()
    // {
    //     if ('Wednesday' == date('l', time())) {
    //         // All employee temmeber id 
    //         $createdbyList = DB::table('timesheetusers')->distinct()->pluck('createdby')->toArray();

    //         // Implementation for all employee
    //         foreach ($createdbyList as $createdby) {
    //             // Exam leave data get hare
    //             $usertimesheetfirstdate =  DB::table('timesheetusers')
    //                 ->where('status', '0')
    //                 ->where('assignment_id', 214)
    //                 ->where('createdby', $createdby)
    //                 ->orderBy('date', 'ASC')->first();
    //             // Exam leave data should not be empty
    //             if ($usertimesheetfirstdate && !empty($usertimesheetfirstdate->date)) {

    //                 $date = Carbon::createFromFormat('Y-m-d', $usertimesheetfirstdate->date);
    //                 // Automatic submit will be on this date 
    //                 // find days name Wednesday 
    //                 $autosubmitdate = $date->copy()->next(Carbon::SUNDAY)->addDays(3);
    //                 // $autosubmitdate = $date->copy()->next(Carbon::SUNDAY)->addDays(5);
    //                 $todaydate = Carbon::now('Asia/Kolkata');

    //                 //autosubmitdate and todaydate should be same 
    //                 if ($autosubmitdate->isSameDay($todaydate)) {
    //                     $lastdate = Carbon::createFromFormat('Y-m-d', $usertimesheetfirstdate->date)->addDays(6);

    //                     $firstDate = new DateTime($usertimesheetfirstdate->date);
    //                     $dayOfWeek = $firstDate->format('w');

    //                     $daysToAdd = 0;

    //                     if ($dayOfWeek !== '0') {
    //                         $daysToAdd = 7 - $dayOfWeek;
    //                     }

    //                     if ($dayOfWeek > 0) {
    //                         $daysToSubtract = $dayOfWeek - 1;
    //                     } else {
    //                         $daysToSubtract = $dayOfWeek;
    //                     }
    //                     $upcomingSunday = (new DateTime($firstDate->format('Y-m-d')))->modify("+$daysToAdd days")->format('Y-m-d');
    //                     $presentWeekMonday = (new DateTime($firstDate->format('Y-m-d')))->modify("-$daysToSubtract days")->format('Y-m-d');

    //                     // Get six data of exam leave 
    //                     $get_six_Data = DB::table('timesheetusers')
    //                         ->where('status', '0')
    //                         ->where('assignment_id', 214)
    //                         ->where('createdby', $createdby)
    //                         ->whereBetween('date', [$firstDate->format('Y-m-d'), $upcomingSunday])
    //                         ->orderBy('date', 'ASC')
    //                         ->get();

    //                     $lastdate = $get_six_Data->max('date');

    //                     // get date only of retrived data 
    //                     $retrievedDates = [];
    //                     foreach ($get_six_Data as $entry) {
    //                         $date = new DateTime($entry->date);
    //                         $retrievedDates[] = $date->format('Y-m-d');
    //                     }

    //                     $firstDate = new DateTime($presentWeekMonday);
    //                     $upcomingSundayDate = new DateTime($upcomingSunday);
    //                     $currentDate = clone $firstDate;

    //                     $expectedDates = [];
    //                     while ($currentDate->format('Y-m-d') < $upcomingSundayDate->format('Y-m-d')) {
    //                         //excluding sunday
    //                         $expectedDates[] = $currentDate->format('Y-m-d');
    //                         $currentDate->modify("+1 day");
    //                     }

    //                     $missingDates = array_diff($expectedDates, $retrievedDates);
    //                     // missing date should be empty 
    //                     if (empty($missingDates)) {
    //                         foreach ($get_six_Data as $getsixdata) {
    //                             $requestedDate = Carbon::createFromFormat('Y-m-d', $getsixdata->date);

    //                             if (date('l', strtotime(date('d-m-Y', strtotime($getsixdata->date)))) == 'Monday') {
    //                                 $previousMonday = $requestedDate->copy()->previous(Carbon::MONDAY);
    //                                 // Find the nearest next Saturday to the requested date
    //                                 $nextSaturday = $requestedDate->copy()->next(Carbon::SATURDAY);
    //                                 $previousMondayFormatted = $getsixdata->date;
    //                                 $nextSaturdayFormatted = $nextSaturday->format('Y-m-d');
    //                                 $nextSaturdayFormatted = $lastdate;

    //                                 $week =  date('d-m-Y', strtotime($previousMondayFormatted))  . ' to ' . date('d-m-Y', strtotime($nextSaturdayFormatted));

    //                                 $co = DB::table('timesheetusers')
    //                                     ->where('status', '0')
    //                                     ->where('assignment_id', 214)
    //                                     ->where('createdby', $createdby)
    //                                     ->whereBetween('date', [$previousMondayFormatted, $nextSaturdayFormatted])
    //                                     ->select(DB::raw('SUM(hour) as total_hours'), DB::raw('COUNT(DISTINCT timesheetid) as row_count'))
    //                                     ->get();

    //                                 foreach ($co as $codata) {
    //                                     DB::table('timesheetreport')->insert([
    //                                         'teamid'       =>     $createdby,
    //                                         'week'       =>     $week,
    //                                         'totaldays'       =>     $codata->row_count,
    //                                         'totaltime' =>  $codata->total_hours,
    //                                         'startdate'  => $previousMondayFormatted,
    //                                         'enddate'  => $nextSaturdayFormatted,
    //                                         'created_at'                =>      date('y-m-d H:i:s'),
    //                                     ]);
    //                                 }
    //                             }

    //                             DB::table('timesheetusers')->where('id', $getsixdata->id)->update([
    //                                 'status'         =>     1,
    //                                 'updated_at'              =>     date('y-m-d H:i:s'),
    //                             ]);

    //                             DB::table('timesheets')->where('id', $getsixdata->timesheetid)->update([
    //                                 'status'         =>     1,
    //                                 'updated_at'              =>     date('y-m-d H:i:s'),
    //                             ]);

    //                             // Attendance code start hare 
    //                             $hdatess = Carbon::parse($getsixdata->date)->format('Y-m-d');
    //                             $day = Carbon::parse($hdatess)->format('d');
    //                             $month = Carbon::parse($hdatess)->format('F');
    //                             $yeardata = Carbon::parse($hdatess)->format('Y');

    //                             $dates = [
    //                                 '26' => 'twentysix',
    //                                 '27' => 'twentyseven',
    //                                 '28' => 'twentyeight',
    //                                 '29' => 'twentynine',
    //                                 '30' => 'thirty',
    //                                 '31' => 'thirtyone',
    //                                 '01' => 'one',
    //                                 '02' => 'two',
    //                                 '03' => 'three',
    //                                 '04' => 'four',
    //                                 '05' => 'five',
    //                                 '06' => 'six',
    //                                 '07' => 'seven',
    //                                 '08' => 'eight',
    //                                 '09' => 'nine',
    //                                 '10' => 'ten',
    //                                 '11' => 'eleven',
    //                                 '12' => 'twelve',
    //                                 '13' => 'thirteen',
    //                                 '14' => 'fourteen',
    //                                 '15' => 'fifteen',
    //                                 '16' => 'sixteen',
    //                                 '17' => 'seventeen',
    //                                 '18' => 'eighteen',
    //                                 '19' => 'ninghteen',
    //                                 '20' => 'twenty',
    //                                 '21' => 'twentyone',
    //                                 '22' => 'twentytwo',
    //                                 '23' => 'twentythree',
    //                                 '24' => 'twentyfour',
    //                                 '25' => 'twentyfive',
    //                             ];

    //                             $column = $dates[$day];
    //                             // check attendenace record exist or not 
    //                             $attendances = DB::table('attendances')
    //                                 ->where('employee_name', auth()->user()->teammember_id)
    //                                 ->where('month', $month)
    //                                 ->first();

    //                             if ($attendances == null) {
    //                                 $teammember = DB::table('teammembers')->where('id', auth()->user()->teammember_id)->first();
    //                                 DB::table('attendances')->insert([
    //                                     'employee_name' => $teammember->id,
    //                                     'month' => $month,
    //                                     'year' => $yeardata,
    //                                     'dateofjoining' => $teammember->joining_date,
    //                                     'fulldate' => date('Y-m-d'),
    //                                     'created_at' => date('Y-m-d H:i:s'),
    //                                     'updated_at' => date('Y-m-d H:i:s'),
    //                                 ]);
    //                             }

    //                             $attendances = DB::table('attendances')
    //                                 ->where('employee_name', auth()->user()->teammember_id)
    //                                 ->where('month', $month)
    //                                 ->first();

    //                             if ($attendances != null && property_exists($attendances, $column)) {

    //                                 $client = $getsixdata->client_id;
    //                                 $assignmentid = $getsixdata->assignment_id;

    //                                 // $updatewording = match (true) {
    //                                 //     // Travel
    //                                 //     $client == 32 => 'T',
    //                                 //     // Off holidays
    //                                 //     $client == 33 && str_replace(['1st ', '2nd ', '3rd ', '4th ', '5th '], '', $getsixdata->workitem) == 'Saturday' => 'OH',
    //                                 //     // Other holidays from calendar
    //                                 //     $client == 33 => 'H',
    //                                 //     // when submit timesheet before joining date
    //                                 //     $assignmentid == 213 && $getsixdata->workitem == 'NA' => null,
    //                                 //     // Casual leave
    //                                 //     $client == 134 && $assignmentid == 215 => 'CL',
    //                                 //     // Exam leave
    //                                 //     $client == 134 && $assignmentid == 214 => 'EL',
    //                                 //         // Default presence
    //                                 //     default => 'P',
    //                                 // };

    //                                 if ($client == 32) {
    //                                     $updatewording = 'T'; // Travel
    //                                 } elseif ($client == 33 && str_replace(['1st ', '2nd ', '3rd ', '4th ', '5th '], '', $getsixdata->workitem) == 'Saturday') {
    //                                     $updatewording = 'OH'; // Off holidays
    //                                 } elseif ($client == 33) {
    //                                     $updatewording = 'H'; // Other holidays from calendar
    //                                 } elseif ($assignmentid == 213 && $getsixdata->workitem == 'NA') {
    //                                     $updatewording = null; // Casual leave
    //                                 } elseif ($client == 134 && $assignmentid == 215) {
    //                                     $updatewording = 'CL'; // Casual leave
    //                                 } elseif ($client == 134 && $assignmentid == 214) {
    //                                     $updatewording = 'EL'; // Exam leave
    //                                 } else {
    //                                     $updatewording = 'P'; // Default presence
    //                                 }
    //                             }

    //                             $totalCountMapping = [
    //                                 'P' => 'no_of_days_present',
    //                                 'CL' => 'casual_leave',
    //                                 'EL' => 'exam_leave',
    //                                 'T' => 'travel',
    //                                 'OH' => 'offholidays',
    //                                 'W' => 'sundaycount',
    //                                 'H' => 'holidays',
    //                                 null => 'beforejoiningcount'
    //                             ];

    //                             // Update the total count and attendance record if applicable
    //                             if (isset($totalCountMapping[$updatewording])) {
    //                                 $totalcountColumn = $totalCountMapping[$updatewording];
    //                                 $totalcountupdate = $attendances->$totalcountColumn + 1;

    //                                 // DB::table('attendances')
    //                                 //     ->where('id', $attendances->id)
    //                                 //     ->update([
    //                                 //         $column => $updatewording,
    //                                 //         $totalcountColumn => $totalcountupdate,
    //                                 //     ]);

    //                                 // $totalcountupdate = $attendances->$totalcountColumn ? $attendances->$totalcountColumn + 1 : 1;



    //                                 if ($totalcountColumn != "exam_leave") {

    //                                     $iftwotimesheetinday = DB::table('attendances')
    //                                         ->where('id', $attendances->id)
    //                                         ->value($column);

    //                                     if ($iftwotimesheetinday == "P") {
    //                                         $updatewording = "P";
    //                                         $totalcountupdate = $attendances->$totalcountColumn + 0;
    //                                     } elseif ($iftwotimesheetinday == 'T') {
    //                                         $updatewording = "P";
    //                                         $totalcountupdate = $attendances->$totalcountColumn + 0;
    //                                     }

    //                                     DB::table('attendances')
    //                                         ->where('id', $attendances->id)
    //                                         ->update([
    //                                             $column => $updatewording,
    //                                             $totalcountColumn => $totalcountupdate,
    //                                         ]);
    //                                 }
    //                             }
    //                             // Attendance code end hare  
    //                         }

    //                         // update sunday data in attendance
    //                         $lastdateFormate = Carbon::createFromFormat('Y-m-d', $lastdate);
    //                         $prevSunday = $lastdateFormate->copy()->previous(Carbon::SUNDAY);
    //                         $day1 = Carbon::parse($prevSunday)->format('d');
    //                         $month1 = $prevSunday->format('F');

    //                         $numberWords = [
    //                             '1' => 'one',
    //                             '2' => 'two',
    //                             '3' => 'three',
    //                             '4' => 'four',
    //                             '5' => 'five',
    //                             '6' => 'six',
    //                             '7' => 'seven',
    //                             '8' => 'eight',
    //                             '9' => 'nine',
    //                             '10' => 'ten',
    //                             '11' => 'eleven',
    //                             '12' => 'twelve',
    //                             '13' => 'thirteen',
    //                             '14' => 'fourteen',
    //                             '15' => 'fifteen',
    //                             '16' => 'sixteen',
    //                             '17' => 'seventeen',
    //                             '18' => 'eighteen',
    //                             '19' => 'nineteen',
    //                             '20' => 'twenty',
    //                             '21' => 'twentyone',
    //                             '22' => 'twentytwo',
    //                             '23' => 'twentythree',
    //                             '24' => 'twentyfour',
    //                             '25' => 'twentyfive',
    //                             '26' => 'twentysix',
    //                             '27' => 'twentyseven',
    //                             '28' => 'twentyeight',
    //                             '29' => 'twentynine',
    //                             '30' => 'thirty',
    //                             '31' => 'thirtyone'
    //                         ];

    //                         $dayWord = $numberWords[(int)$day1];
    //                         if (!in_array($prevSunday, $retrievedDates)) {
    //                             $getdateformated = $prevSunday->format('Y-m-d');
    //                             $getholidaysss = DB::table('holidays')
    //                                 ->where('startdate', '=', $getdateformated)
    //                                 ->orWhere('enddate', '=', $getdateformated)
    //                                 ->first();

    //                             if ($getholidaysss != null) {
    //                                 $updateddata = 'H';
    //                             } else {
    //                                 $updateddata = 'W';
    //                             }

    //                             $totalCountMapping = [
    //                                 'P' => 'no_of_days_present',
    //                                 'CL' => 'casual_leave',
    //                                 'EL' => 'exam_leave',
    //                                 'T' => 'travel',
    //                                 'OH' => 'offholidays',
    //                                 'W' => 'sundaycount',
    //                                 'H' => 'holidays'
    //                             ];

    //                             $prevcheck = DB::table('attendances')
    //                                 ->where('employee_name', auth()->user()->teammember_id)
    //                                 ->where('month', $month1)
    //                                 ->whereNotNull($dayWord)
    //                                 ->first();

    //                             if ($prevcheck == null && isset($totalCountMapping[$updateddata])) {
    //                                 $totalcountColumn = $totalCountMapping[$updateddata];
    //                                 $sundaycountget = DB::table('attendances')
    //                                     ->where('employee_name', auth()->user()->teammember_id)
    //                                     ->where('month', $month1)
    //                                     ->first();

    //                                 if ($sundaycountget) {
    //                                     $totalcountupdate = $sundaycountget->$totalcountColumn + 1;
    //                                     DB::table('attendances')
    //                                         ->where('id', $sundaycountget->id)
    //                                         ->update([
    //                                             $dayWord => $updateddata,
    //                                             $totalcountColumn => $totalcountupdate,
    //                                         ]);
    //                                     // $updateddata = $getholidaysss ? 'H' : 'W';
    //                                 }
    //                             }
    //                         }
    //                         // update sunday data in attendance end hare
    //                     }

    //                     //   return 'message'
    //                 }
    //             }
    //         }
    //     }
    // }
    // Start Hare 
    //*
    $timesheet = '2024-09-24';
    $hdatess = Carbon::parse($timesheet)->format('Y-m-d');
    $day = Carbon::parse($hdatess)->format('d');
    $month = Carbon::parse($hdatess)->format('F');
    $yeardata = Carbon::parse($hdatess)->format('Y');

    $prevcheck = DB::table('attendances')
      ->where('employee_name', 816)
      ->where('month', $month)
      ->orderBy('id', 'desc')
      // ->orderBy('id', 'asc')
      ->first();

    dd($prevcheck);
    //*

    $joining_date = Carbon::parse($request->joining_date)->format('Y-m-d');
    $day = Carbon::parse($joining_date)->format('d');
    $month = Carbon::parse($joining_date)->format('F');
    $yeardata = Carbon::parse($joining_date)->format('Y');

    'dateofjoining' => $joining_date,
    'fulldate' => $joining_date,
    'created_at' => now(),
    'updated_at' => now(),
    // Start Hare 
         $prevSunday = $startdate->copy()->previous(Carbon::SUNDAY);
                        $day1 = Carbon::parse($prevSunday)->format('d');
                        $month1 = $prevSunday->format('F');
                        $yeardata = $prevSunday->format('Y');
                        $fulldate = $prevSunday->format('Y-m-d');

                        'month' => $month1,
                        //                             'year' => $yeardata,
                        //                             // 'dateofjoining' => $teammember->joining_date,
                        //                             'fulldate' => $fulldate,
                        //                             'created_at' => date('Y-m-d H:i:s'),
                        //                             'updated_at' => date('Y-m-d H:i:s'),
    // Start Hare 
    // Start Hare 
    DB::table('attendances')->insert([
      'employee_name' => $id,
      'month' => $exitMonth,
      'year' => $exitYear,
      'fulldate' => $exitDate->format('Y-m-d'),
      'created_at' => now(),
      'updated_at' => now(),
  ]);

  $exitDate = Carbon::parse($request->leavingdate);
  $exitMonth = $exitDate->format('F');
  $exitYear = $exitDate->year;
  $dayOfExit = $exitDate->day;
  $totalDaysInExitMonth = $exitDate->daysInMonth;
    //*
    if (!$exitmonthattendances) {
      DB::table('attendances')->insert([
          'employee_name' => $id,
          'month' => $exitMonth,
          'year' => $exitYear,
          'fulldate' => $exitDate->format('Y-m-d'),
          'created_at' => now(),
          'updated_at' => now(),
      ]);

      // Fetch the newly inserted attendance record
      $exitmonthattendances = DB::table('attendances')
          ->where('employee_name', $id)
          ->where('month', $exitMonth)
          ->first();
  }
    // Start Hare 
    //*
    22222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222
    app\Http\Controllers\TimesheetController.php

    public function rejectedlist(Request $request)
    {
  
      if (auth()->user()->role_id == 13) {
        $timesheetData = DB::table('timesheetusers')
          ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
          ->where('timesheetusers.createdby', auth()->user()->teammember_id)
          // ->where('timesheetusers.status', 2)
          ->whereIn('timesheetusers.status', [2, 3])
          ->select('timesheetusers.*', 'teammembers.team_member', 'teammembers.staffcode')->orderBy('id', 'ASC')->paginate(10);
        // dd($timesheetData);
      } else if (auth()->user()->role_id == 11) {
        $timesheetData = DB::table('timesheetusers')
          ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
          ->whereIn('timesheetusers.status', [2, 3])
          ->where('timesheetusers.rejectedby', auth()->user()->teammember_id)
          ->select('timesheetusers.*', 'teammembers.team_member', 'teammembers.staffcode')->orderBy('id', 'ASC')->get();
      } else {
        $timesheetData = DB::table('timesheetusers')
          ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
          ->where('timesheetusers.createdby', auth()->user()->teammember_id)
          ->whereIn('timesheetusers.status', [2, 3])
          ->select('timesheetusers.*', 'teammembers.team_member', 'teammembers.staffcode')->orderBy('id', 'ASC')->paginate(10);
        // dd($timesheetData);
      }
      // dd($timesheetData);
      return view('backEnd.timesheet.rejectedlist', compact('timesheetData'));
    }

    // Start Hare 
    app\Http\Controllers\TimesheetController.php

    public function timesheetEdit(Request $request, $id)
    {
      $timesheetedit = DB::table('timesheetusers')
        ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
        ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        ->where('timesheetusers.timesheetid', $id)
        ->select('timesheetusers.*', 'clients.client_name', 'assignments.assignment_name', 'teammembers.team_member')
        ->first();
  
      // $timesheetedit = DB::table('assignmentbudgetings')->where('client_id', $id)
      //   ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
      //   ->orderBy('assignment_name')->get();
      // dd($timesheetedit);
  
      // client of particular partner
      $partner = Teammember::where('role_id', '=', 13)->where('status', '=', 1)->with('title')->get();
      $teammember = Teammember::where('role_id', '!=', 11)->with('title', 'role')->get();
      if (auth()->user()->role_id == 11) {
        $client = Client::where('status', 1)->select('id', 'client_name')->orderBy('client_name', 'ASC')->get();
      } elseif (auth()->user()->role_id == 13) {
        $selectedDate = \DateTime::createFromFormat('Y-m-d', $timesheetedit->date);
        $selectedDate1 = \DateTime::createFromFormat('Y-m-d', $timesheetedit->date);
  
        $clientss = DB::table('assignmentmappings')
          ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
          ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
          ->where(function ($query) {
            $query->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
              ->orWhere('assignmentmappings.otherpartner', auth()->user()->teammember_id);
          })
          ->where(function ($query) use ($selectedDate) {
            $query->whereNull('otpverifydate')
              ->orWhere('otpverifydate', '>=', $selectedDate->modify('-1 day'));
          })
          // ->whereNotNull('clients.client_name')
          ->select('clients.client_name', 'clients.id', 'clients.client_code')
          ->orderBy('client_name', 'ASC')
          ->distinct()->get();
  
        // // done default $clients in ajax if need then $clientss add in ajax target $request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34
        // $clients = DB::table('clients')
        //   ->whereIn('id', [29, 32, 33, 34])
        //   ->select('clients.client_name', 'clients.id', 'clients.client_code')
        //   ->orderBy('client_name', 'ASC')
        //   ->distinct()->get();
  
        // if you selected sturday date then offholydays client will be show otherwise not
  
        $formattedDate = $selectedDate1->format('Y-m-d');
        $holidaydatecheck = DB::table('holidays')->where('startdate', $formattedDate)->select('holidayname')->first();
  
        if ($holidaydatecheck) {
          $clientIds = [29, 32, 33, 34];
        } else {
          // if not holidays then go hare
          $dayOfWeek = $selectedDate1->format('w');
          if ($selectedDate1->format('l') == 'Saturday') {
            $dayOfMonth = $selectedDate1->format('j');
            // Calculate which Saturday of the month it is
            $saturdayNumber = ceil($dayOfMonth / 7);
            // offholiday client name will be show on 2nd and 4rth sturday
            if ($saturdayNumber == 2.0 || $saturdayNumber == 4.0) {
              $clientIds = [29, 32, 33, 34];
            } else {
              $clientIds = [29, 32, 34];
            }
          } else {
            $clientIds = [29, 32, 34];
          }
        }
        $clients = DB::table('clients')
          ->whereIn('id', $clientIds)
          ->select('clients.client_name', 'clients.id', 'clients.client_code')
          ->orderBy('client_name', 'ASC')
          ->distinct()
          ->get();
  
        $client = $clientss->merge($clients);
      } else {
  
        $selectedDate = \DateTime::createFromFormat('Y-m-d', $timesheetedit->date);
        $selectedDate1 = \DateTime::createFromFormat('Y-m-d', $timesheetedit->date);
  
        $clientss = DB::table('assignmentteammappings')
          ->leftjoin('assignmentmappings', 'assignmentmappings.id', 'assignmentteammappings.assignmentmapping_id')
          ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
          ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
          ->orwhere('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
          ->whereNotIn('assignmentbudgetings.assignmentname', ['Unallocated', 'Official Travel', 'Off/Holiday', 'Seminar/Conference/Post Qualification Course'])
          ->where(function ($query) use ($selectedDate) {
            $query->whereNull('otpverifydate')
              ->orWhere('otpverifydate', '>=', $selectedDate->modify('-1 day'));
          })
          ->select('clients.client_name', 'clients.id', 'clients.client_code')
          ->orderBy('client_name', 'ASC')
          ->distinct()->get();
  
        $formattedDate = $selectedDate1->format('Y-m-d');
        $holidaydatecheck = DB::table('holidays')->where('startdate', $formattedDate)->select('holidayname')->first();
  
        if ($holidaydatecheck) {
          $clientIds = [29, 32, 33, 34];
        } else {
          // if not holidays then go hare
          $dayOfWeek = $selectedDate1->format('w');
          if ($selectedDate1->format('l') == 'Saturday') {
            $dayOfMonth = $selectedDate1->format('j');
            // Calculate which Saturday of the month it is
            $saturdayNumber = ceil($dayOfMonth / 7);
            // offholiday client name will be show on 2nd and 4rth sturday
            if (auth()->user()->role_id == 14) {
              if ($saturdayNumber == 2.0 || $saturdayNumber == 4.0) {
                $clientIds = [29, 32, 33, 34];
              } else {
                $clientIds = [29, 32, 34];
              }
            } else {
              if ($saturdayNumber == 1.0 || $saturdayNumber == 2.0 || $saturdayNumber == 3.0 || $saturdayNumber == 4.0 || $saturdayNumber == 5.0) {
                $clientIds = [29, 32, 33, 34];
              }
            }
          } else {
            $clientIds = [29, 32, 34];
          }
        }
        $clients = DB::table('clients')
          ->whereIn('id', $clientIds)
          ->select('clients.client_name', 'clients.id', 'clients.client_code')
          ->orderBy('client_name', 'ASC')
          ->distinct()
          ->get();
  
        $client = $clientss->merge($clients);
      }
      $assignment = Assignment::select('id', 'assignment_name')->get();
      return view('backEnd.timesheet.correction', compact('client', 'teammember', 'assignment', 'partner', 'timesheetedit'));
    }
    // Start Hare 

    app\Http\Controllers\TimesheetController.php
    public function timesheeteditstore(Request $request)
    {
  
      dd($request);
      $oldtimesheetsubmiteddata = DB::table('timesheetusers')
        ->where('timesheetid', $request->timesheetid)
        ->where('createdby', $request->createdby) // Assuming you are storing user ID
        ->get();
  
      // Calculate the total hours from previously submitted timesheets (status = 1)
      $SubmittedTimesheetHours = $oldtimesheetsubmiteddata->whereIn('status', [1, 3])->sum('hour');
  
      // Get the new rejected hours from the request
      $RejectedTimesheetHours = $request->input('hour');
  
      // Cast rejected hours to integer to ensure it's a numeric value
      $RejectedTimesheetHours = (int)$RejectedTimesheetHours;
  
      // Calculate the total hours by adding both submitted and rejected hours
      $totalHours = $SubmittedTimesheetHours + $RejectedTimesheetHours;
      // dd($totalHours);
  
  
      // Check if the total hours exceed the limit of 12
      if (!is_numeric($totalHours) || $totalHours > 12) {
  
        $output = ['msg' => 'The total hours cannot be greater than 12'];
        return redirect('timesheetreject/edit/' . $request->timesheetid)->with('statuss', $output);
      }
  
  
      if (!is_numeric($request->assignment_id)) {
        $assignment = Assignmentmapping::where('assignmentgenerate_id', $request->assignment_id)
          ->select('assignment_id')
          ->first();
        // ->toArray();
        // $assignment_id = $assignment[0]['assignment_id'];
        $assignment_id = $assignment->assignment_id;
        $assignmentgenerateId = $request->assignment_id;
        $oldtimesheetdata = DB::table('timesheetusers')->where('id', $request->timesheetusersid)->first();
        // update total hour 
  
        if (auth()->user()->role_id == 14 || auth()->user()->role_id == 15) {
  
          $gettotalteamhour = DB::table('assignmentmappings')
            ->leftJoin(
              'assignmentteammappings',
              'assignmentteammappings.assignmentmapping_id',
              'assignmentmappings.id',
            )
            ->where(
              'assignmentmappings.assignmentgenerate_id',
              $oldtimesheetdata->assignmentgenerate_id
            )
            ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
            ->select('assignmentteammappings.*')
            ->first();
  
  
  
          $gettotalteamhournew = DB::table('assignmentmappings')
            ->leftJoin(
              'assignmentteammappings',
              'assignmentteammappings.assignmentmapping_id',
              'assignmentmappings.id',
            )
            ->where(
              'assignmentmappings.assignmentgenerate_id',
              $request->assignment_id
            )
            ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
            ->select('assignmentteammappings.*')
            ->first();
  
  
  
  
          if ($gettotalteamhour) {
            if ($gettotalteamhour->teamhour == null) {
              $gettotalteamhour->teamhour = 0;
            }
            $finalresult =  $gettotalteamhour->teamhour - $request->hour;
            $totalteamhourupdate = DB::table('assignmentteammappings')
              ->where('id', $gettotalteamhour->id)
              // ->get();
              ->update(['teamhour' =>  $finalresult]);
          }
          if ($gettotalteamhournew) {
            if ($gettotalteamhournew->teamhour == null) {
              $gettotalteamhournew->teamhour = 0;
            }
            $finalresult =  $gettotalteamhournew->teamhour + $request->hour;
            $totalteamhourupdate = DB::table('assignmentteammappings')
              ->where('id', $gettotalteamhournew->id)
              // ->get();
              ->update(['teamhour' =>  $finalresult]);
          }
        }
  
        if (auth()->user()->role_id == 13) {
          $assignmentdata = DB::table('assignmentmappings')
            ->where('assignmentgenerate_id', $assignmentgenerateId)
            ->first();
          $assignmentdataold = DB::table('assignmentmappings')
            ->where('assignmentgenerate_id', $oldtimesheetdata->assignmentgenerate_id)
            ->first();
  
          // old assignment hour subtract 
          if ($assignmentdataold->leadpartner == auth()->user()->teammember_id) {
            if ($assignmentdataold->leadpartnerhour == null) {
              $assignmentdataold->leadpartnerhour = 0;
            }
            $finalresultleadpatner =  $assignmentdataold->leadpartnerhour + $oldtimesheetdata->hour;
            $totalteamhourupdate = DB::table('assignmentmappings')
              ->where('id', $assignmentdataold->id)
              // ->get();
              ->update(['leadpartnerhour' => $finalresultleadpatner]);
          }
          if ($assignmentdataold->otherpartner == auth()->user()->teammember_id) {
            if ($assignmentdataold->otherpartnerhour == null) {
              $assignmentdataold->otherpartnerhour = 0;
            }
            $finalresultotherpatner =  $assignmentdataold->otherpartnerhour - $oldtimesheetdata->hour;
            $totalteamhourupdate = DB::table('assignmentmappings')
              ->where('id', $assignmentdataold->id)
              // ->get();
              ->update(['otherpartnerhour' => $finalresultotherpatner]);
          }
  
          // new assignment hour add
          if ($assignmentdata->leadpartner == auth()->user()->teammember_id) {
            if ($assignmentdata->leadpartnerhour == null) {
              $assignmentdata->leadpartnerhour = 0;
            }
            $finalresultleadpatner =  $assignmentdata->leadpartnerhour + $request->hour;
            $totalteamhourupdate = DB::table('assignmentmappings')
              ->where('id', $assignmentdata->id)
              // ->get();
              ->update(['leadpartnerhour' => $finalresultleadpatner]);
          }
          if ($assignmentdata->otherpartner == auth()->user()->teammember_id) {
            if ($assignmentdata->otherpartnerhour == null) {
              $assignmentdata->otherpartnerhour = 0;
            }
            $finalresultotherpatner =  $assignmentdata->otherpartnerhour + $request->hour;
            $totalteamhourupdate = DB::table('assignmentmappings')
              ->where('id', $assignmentdata->id)
              // ->get();
              ->update(['otherpartnerhour' => $finalresultotherpatner]);
          }
        }
      }
  
      if (is_numeric($request->assignment_id)) {
        $assignment_id = $request->assignment_id;
        $getassignmentgenerateId = DB::table('timesheetusers')->where('id', $request->timesheetusersid)->first();
        $assignmentgenerateId = $getassignmentgenerateId->assignmentgenerate_id;
  
        $oldtimesheetdata = DB::table('timesheetusers')->where('id', $request->timesheetusersid)->first();
        // update total hour 
        if ($oldtimesheetdata->hour != $request->hour) {
          if (auth()->user()->role_id == 14 || auth()->user()->role_id == 15) {
            $gettotalteamhour = DB::table('assignmentmappings')
              ->leftJoin(
                'assignmentteammappings',
                'assignmentteammappings.assignmentmapping_id',
                'assignmentmappings.id',
              )
              ->where(
                'assignmentmappings.assignmentgenerate_id',
                $oldtimesheetdata->assignmentgenerate_id
              )
              ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
              ->select('assignmentteammappings.*')
              ->first();
            if ($gettotalteamhour) {
              $totalteamhour = $gettotalteamhour->teamhour;
              $subtractoldhour =  $totalteamhour - $oldtimesheetdata->hour;
              $finalresult =  $subtractoldhour + $request->hour;
  
              $totalteamhourupdate = DB::table('assignmentteammappings')
                ->where('id', $gettotalteamhour->id)
                // ->get();
                ->update(['teamhour' =>  $finalresult]);
            }
          }
          if (auth()->user()->role_id == 13) {
            $assignmentdata = DB::table('assignmentmappings')
              ->where('assignmentgenerate_id', $oldtimesheetdata->assignmentgenerate_id)
              ->first();
  
            if ($assignmentdata->leadpartner == auth()->user()->teammember_id) {
              $subtractoldhour =  $assignmentdata->leadpartnerhour - $oldtimesheetdata->hour;
              $finalresultleadpatner =  $subtractoldhour + $request->hour;
              $totalteamhourupdate = DB::table('assignmentmappings')
                ->where('id', $assignmentdata->id)
                // ->get();
                ->update(['leadpartnerhour' => $finalresultleadpatner]);
            }
            if ($assignmentdata->otherpartner == auth()->user()->teammember_id) {
              $subtractoldhour =  $assignmentdata->otherpartnerhour - $oldtimesheetdata->hour;
              $finalresultotherpatner =  $subtractoldhour + $request->hour;
  
              $totalteamhourupdate = DB::table('assignmentmappings')
                ->where('id', $assignmentdata->id)
                // ->get();
                ->update(['otherpartnerhour' => $finalresultotherpatner]);
            }
          }
        }
      }
  
      try {
        $timesheetdataupdate = DB::table('timesheetusers')->where('id', $request->timesheetusersid)->first();
  
        // dd($assignmentgenerateId);
        DB::table('timesheets')->where('id', $timesheetdataupdate->timesheetid)->update([
          'status'   =>   3,
        ]);
  
        DB::table('timesheetusers')->where('id', $request->timesheetusersid)->update([
          'status'   =>   3,
          'client_id'   =>  $request->client_id,
          'assignmentgenerate_id'   =>  $assignmentgenerateId,
          'assignment_id'   =>   $assignment_id,
          'partner'   =>  $request->partner,
          'workitem'   =>   $request->workitem,
          'createdby'   =>   $request->createdby,
          'location'   =>   $request->location,
          'hour'   =>   $request->hour,
        ]);
  
        // Attendance code start hare 
        $hdatess = Carbon::parse($request->date)->format('Y-m-d');
        $day = Carbon::parse($hdatess)->format('d');
        $month = Carbon::parse($hdatess)->format('F');
        $yeardata = Carbon::parse($hdatess)->format('Y');
  
        $dates = [
          '01' => 'one',
          '02' => 'two',
          '03' => 'three',
          '04' => 'four',
          '05' => 'five',
          '06' => 'six',
          '07' => 'seven',
          '08' => 'eight',
          '09' => 'nine',
          '10' => 'ten',
          '11' => 'eleven',
          '12' => 'twelve',
          '13' => 'thirteen',
          '14' => 'fourteen',
          '15' => 'fifteen',
          '16' => 'sixteen',
          '17' => 'seventeen',
          '18' => 'eighteen',
          '19' => 'ninghteen',
          '20' => 'twenty',
          '21' => 'twentyone',
          '22' => 'twentytwo',
          '23' => 'twentythree',
          '24' => 'twentyfour',
          '25' => 'twentyfive',
          '26' => 'twentysix',
          '27' => 'twentyseven',
          '28' => 'twentyeight',
          '29' => 'twentynine',
          '30' => 'thirty',
          '31' => 'thirtyone',
        ];
  
        $column = $dates[$day];
  
        // check attendenace record exist or not 
        $attendances = DB::table('attendances')
          ->where('employee_name', $request->createdby)
          ->where('month', $month)
          ->first();
  
  
        if ($attendances && property_exists($attendances, $column)) {
          $checkwording = DB::table('attendances')
            ->where('id', $attendances->id)
            ->value($column);
  
          if ($checkwording == 'R') {
            $client = $request->client_id;
            // $assignmentid = $request->assignment_id;
            if (is_numeric($request->assignment_id)) {
              $assignmentid = $request->assignment_id;
            } else {
              $assignmentid = $assignment_id;
            }
  
            // Determine update wording based on client and assignment conditions
            // $updatewording = match (true) {
            //   // Travel
            //   $client == 32 => 'T',
            //   // Off holidays
            //   $client == 33 && str_replace(['1st ', '2nd ', '3rd ', '4th ', '5th '], '', $request->workitem) == 'Saturday' => 'OH',
            //   // Other holidays from calendar
            //   $client == 33 => 'H',
            //   // Casual leave
            //   $client == 134 && $assignmentid == 215 => 'CL',
            //   // Exam leave
            //   $client == 134 && $assignmentid == 214 => 'EL',
            //     // Default presence
            //   default => 'P',
            // };
  
  
            if ($client == 32) {
              $updatewording = 'T'; // Travel
            } elseif ($client == 33 && str_replace(['1st ', '2nd ', '3rd ', '4th ', '5th '], '', $request->workitem) == 'Saturday') {
              $updatewording = 'OH'; // Off holidays
            } elseif ($client == 33) {
              $updatewording = 'H'; // Other holidays from calendar
            } elseif ($client == 134 && $assignmentid == 215) {
              $updatewording = 'CL'; // Casual leave
            } elseif ($client == 134 && $assignmentid == 214) {
              $updatewording = 'EL'; // Exam leave
            } else {
              $updatewording = 'P'; // Default presence
            }
  
            // Mapping for total count columns
            $totalCountMapping = [
              'P' => 'no_of_days_present',
              'CL' => 'casual_leave',
              'EL' => 'exam_leave',
              'T' => 'travel',
              'OH' => 'offholidays',
              'W' => 'sundaycount',
              'H' => 'holidays'
            ];
  
            // Update the total count and attendance record if applicable
            if (isset($totalCountMapping[$updatewording])) {
              $totalcountColumn = $totalCountMapping[$updatewording];
              $totalcountupdate = $attendances->$totalcountColumn + 1;
              DB::table('attendances')
                ->where('id', $attendances->id)
                ->update([
                  $column => $updatewording,
                  $totalcountColumn => $totalcountupdate,
                ]);
            }
          }
        }
  
        // dd('updated', 1);
        // Attendance code end hare 
  
        if ($request->status == 2) {
          DB::table('timesheetupdatelogs')->insert([
            'timesheetusers_id'   =>  $request->timesheetusersid,
            'status'   =>   3,
            'created_at' => now(),
            'updated_at' => now(),
          ]);
        }
        $output = array('msg' => 'Updated Successfully');
        // return back()->with('statuss', $output);
        return redirect()->to('rejectedlist')->with('statuss', $output);
      } catch (Exception $e) {
        DB::rollBack();
        Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
        report($e);
        $output = array('msg' => $e->getMessage());
        return back()->withErrors($output)->withInput();
      }
    }

    333333333333333333333333333333333333333333333333333333333
    //*
    //*
    //*
    $checksavetimesheet = DB::table('timesheetusers')
    ->where('createdby', $id)
    ->where('date', '>', $request->leavingdate)
    ->where('status', 0)
    // ->delete();
    ->first();
    // Start Hare 





    $id =

    809 varma g 

      $timesheetdelete = DB::table('timesheetusers')->where('timesheetid', $id)->first();
    // dd($timesheetdelete);
    if (auth()->user()->role_id == 14 || auth()->user()->role_id == 15) {
      // dd('check');

      $gettotalteamhour = DB::table('assignmentmappings')
        ->leftJoin(
          'assignmentteammappings',
          'assignmentteammappings.assignmentmapping_id',
          'assignmentmappings.id',
        )
        ->where(
          'assignmentmappings.assignmentgenerate_id',
          $timesheetdelete->assignmentgenerate_id
        )
        ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
        ->first();
      //  dd($gettotalteamhour->teamhour);
      if ($gettotalteamhour) {
        //akshay kumar
        $timesheetHour = $timesheetdelete->hour;
        if (strpos($timesheetHour, ':') !== false) {

          // If the value contains a colon, split it into hours and minutes
          list($hours, $minutes) = explode(':', $timesheetHour);
        } else {

          // If there's no colon, treat the entire value as hours, and set minutes to 0
          $hours = $timesheetHour;
          $minutes = 0;
        }

        // Convert the time to decimal hours

        $timesheetDecimalHour = $hours + ($minutes / 60);
        $roundedHour = floor($timesheetDecimalHour);
        $roundedHour = (int)$roundedHour;

        $gettotalteamhour = $gettotalteamhour->teamhour;

        $finalresult =  $gettotalteamhour - $roundedHour;

        //end akshay kumar

        $totalteamhourupdate = DB::table('assignmentmappings')
          ->leftJoin(
            'assignmentteammappings',
            'assignmentteammappings.assignmentmapping_id',
            'assignmentmappings.id',
          )
          ->where(
            'assignmentmappings.assignmentgenerate_id',
            $timesheetdelete->assignmentgenerate_id
          )
          ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
          // ->get();
          ->update(['teamhour' =>  $finalresult]);
      }
    }

    // dd($timesheetdelete);
    if (auth()->user()->role_id == 13) {
      // dd('cech');
      $assignmentdata = DB::table('assignmentmappings')
        ->where('assignmentgenerate_id', $timesheetdelete->assignmentgenerate_id)
        ->first();

      //akhsay code

      $leadPartnerHour = $assignmentdata->leadpartnerhour; // Numeric value

      $timesheetHour = $timesheetdelete->hour; // Time string in "HH:MM" format

      // Split the timesheet hour (e.g., "08:00") into hours and minutes
      if (strpos($timesheetHour, ':') !== false) {


        // If the value contains a colon, split it into hours and minutes
        list($hours, $minutes) = explode(':', $timesheetHour);

        // Convert the time to decimal hours
        $timesheetDecimalHour = $hours + ($minutes / 60);
        $roundedHour = floor($timesheetDecimalHour);
        $roundedHour = (int)$roundedHour;
        // Perform the subtractiond
        // dd($leadPartnerHour);
        $finalresultleadpatner = $leadPartnerHour - $roundedHour;
        // dd($finalresultleadpatner);
        $finalresultotherpatner =  $assignmentdata->otherpartnerhour - $roundedHour;
        // dd($finalresultotherpatner);

      } else {
        // dd('out');
        $finalresultleadpatner =  $assignmentdata->leadpartnerhour - $timesheetdelete->hour;
        $finalresultotherpatner =  $assignmentdata->otherpartnerhour - $timesheetdelete->hour;
      }




      ///end aksshay code
      if ($assignmentdata->leadpartner == auth()->user()->teammember_id) {

        $update2 = DB::table('assignmentmappings')
          ->where('assignmentgenerate_id', $timesheetdelete->assignmentgenerate_id)
          ->where('leadpartner', auth()->user()->teammember_id)
          ->update(['leadpartnerhour' => $finalresultleadpatner]);
      }
      if ($assignmentdata->otherpartner == auth()->user()->teammember_id) {

        $update2 = DB::table('assignmentmappings')
          ->where('assignmentgenerate_id', $timesheetdelete->assignmentgenerate_id)
          ->where('otherpartner', auth()->user()->teammember_id)
          ->update(['otherpartnerhour' => $finalresultotherpatner]);
      }
    }
    // dd('out');
    DB::table('timesheets')->where('id', $id)->delete();
    DB::table('timesheetusers')->where('timesheetid', $id)->delete();
   

    public function handle()
    {

        $currentDate = now()->subDay(); // Get the previous day from the current date
        $currentMonth = $currentDate->format('F');
        $currentYear = $currentDate->format('Y');
        // Define the start of the current month (1st day of the month)
        $attendanceStartDate = Carbon::create($currentYear, $currentDate->format('m'), 1);
        // Define the end of the current month (last day of the month)
        $attendanceEndDate = Carbon::create($currentYear, $currentDate->format('m'))->endOfMonth();
        // Calculate total days in the period (from 26th of prev month to 25th of current month)
        $totalDays = $attendanceStartDate->diffInDays($attendanceEndDate) + 1;

        // $teammembers = Attendance::join('teammembers', 'teammembers.id', 'attendances.employee_name')
        //     ->where('attendances.month', $currentMonth)
        //     ->whereYear('attendances.created_at', $currentYear)
        //     // ->whereNotNull('teammembers.joining_date')
        //     ->get();

        $teammembers = Attendance::join('teammembers', 'teammembers.id', 'attendances.employee_name')
            ->where('attendances.employee_name', 915)
            // ->whereYear('attendances.created_at', $currentYear)
            // ->whereNotNull('teammembers.joining_date')
            ->get();
        // dd($teammembers);
        foreach ($teammembers as $team) {
            $keysToFilter = [
                'twentysix',
                'twentyseven',
                'twentyeight',
                'twentynine',
                'thirty',
                'thirtyone',
                'one',
                'two',
                'three',
                'four',
                'five',
                'six',
                'seven',
                'eight',
                'nine',
                'ten',
                'eleven',
                'twelve',
                'thirteen',
                'fourteen',
                'fifteen',
                'sixteen',
                'seventeen',
                'eighteen',
                'ninghteen',
                'twenty',
                'twentyone',
                'twentytwo',
                'twentythree',
                'twentyfour',
                'twentyfive'
            ];

            $days = array_intersect_key($team->toArray(), array_flip($keysToFilter));

            $dayspresent = 0;
            $casualLeaveCount = 0;
            $examLeaveCount = 0;
            $travelCount = 0;
            $offholidaysCount = 0;
            $sundayCount = 0;
            $holidaysCount = 0;

            foreach ($days as $key => $value) {
                if ($value == 'P') {
                    $dayspresent++;
                } else if ($value == 'CL') {
                    $casualLeaveCount++;
                } else if ($value == 'EL') {
                    $examLeaveCount++;
                } else if ($value == 'T') {
                    $travelCount++;
                } else if ($value == 'OH') {
                    $offholidaysCount++;
                } else if ($value == 'W') {
                    $sundayCount++;
                } else if ($value == 'H') {
                    $holidaysCount++;
                }
            }

            $dayspresentcount = $dayspresent;
            $casualLeave = $casualLeaveCount;
            $examLeave =  $examLeaveCount;
            $travel =  $travelCount;
            $offholidays =  $offholidaysCount;
            $sunday =  $sundayCount;
            $holidays =  $holidaysCount;

            $attendanceData = [
                'total_no_of_days' => $totalDays,
                'no_of_days_present' => $dayspresentcount,
                'casual_leave' => $casualLeave,
                'exam_leave' => $examLeave,
                'travel' => $travel,
                'offholidays' => $offholidays,
                'sundaycount' => $sunday,
                'holidays' => $holidays,
            ];

            $ggg = DB::table('attendances')->where('employee_name', $team->employee_name)
                ->where('month', $currentMonth)
                ->where('year', $currentYear)
                ->get();
            // ->update($attendanceData);

            dd($ggg);
        }

        // return "Attendance updated";
        dd('Count updated successfull');
    }
    // Start Hare 
    //*
    elseif ($monthcase == 'october') {
        $monthdate = date('Y-m-d H:i:s', strtotime('2024-10-02 11:00:11'));
    }
    // Start Hare 
    ->where('id', 915)
    947
    //*
    $startdate = "2024-09-01";
    $enddate = "2024-09-30";

    // Parse start and end dates with Carbon
    $startDateCarbon = Carbon::parse($startdate);
    $endDateCarbon = Carbon::parse($enddate);

    // Define an array to map day numbers to words for columns in attendance table
    $numberWords = [
        '1' => 'one',
        '2' => 'two',
        '3' => 'three',
        '4' => 'four',
        '5' => 'five',
        '6' => 'six',
        '7' => 'seven',
        '8' => 'eight',
        '9' => 'nine',
        '10' => 'ten',
        '11' => 'eleven',
        '12' => 'twelve',
        '13' => 'thirteen',
        '14' => 'fourteen',
        '15' => 'fifteen',
        '16' => 'sixteen',
        '17' => 'seventeen',
        '18' => 'eighteen',
        '19' => 'nineteen',
        '20' => 'twenty',
        '21' => 'twentyone',
        '22' => 'twentytwo',
        '23' => 'twentythree',
        '24' => 'twentyfour',
        '25' => 'twentyfive',
        '26' => 'twentysix',
        '27' => 'twentyseven',
        '28' => 'twentyeight',
        '29' => 'twentynine',
        '30' => 'thirty',
        '31' => 'thirtyone'
    ];

    // Loop through each Sunday in the date range
    for ($date = $startDateCarbon->copy()->next(Carbon::SUNDAY); $date->lte($endDateCarbon); $date->addWeek()) {
        $day = $date->day; // Get the day number
        $month = $date->format('F'); // Get the month name
        $dayWord = $numberWords[$day]; // Convert day number to word

        // Format the date for checking holiday
        $formattedDate = $date->format('Y-m-d');

        // Check if the date is a holiday
        $holidayCheck = DB::table('holidays')
            ->where('startdate', '=', $formattedDate)
            ->orWhere('enddate', '=', $formattedDate)
            ->first();

        // Determine whether to mark as 'H' (holiday) or 'W' (workday)
        $attendanceStatus = $holidayCheck ? 'H' : 'W';

        // Define mapping for columns to update
        $totalCountMapping = [
            'P' => 'no_of_days_present',
            'CL' => 'casual_leave',
            'EL' => 'exam_leave',
            'T' => 'travel',
            'OH' => 'offholidays',
            'W' => 'sundaycount',
            'H' => 'holidays'
        ];

        // Check attendance record for this user, month, and day
        $attendanceRecord = DB::table('attendances')
            ->where('employee_name', auth()->user()->teammember_id)
            ->where('month', $month)
            ->whereNull($dayWord) // Make sure the day is not already set
            ->first();

        if ($attendanceRecord && isset($totalCountMapping[$attendanceStatus])) {
            $totalcountColumn = $totalCountMapping[$attendanceStatus];
            $newTotalCount = $attendanceRecord->$totalcountColumn + 1;

            // Update attendance table with holiday or workday for the current Sunday
            DB::table('attendances')
                ->where('id', $attendanceRecord->id)
                ->update([
                    $dayWord => $attendanceStatus,
                    $totalcountColumn => $newTotalCount,
                ]);
        }
    }
    // Start Hare 
    //*
    if ($attendances != null && property_exists($attendances, $column)) {

        $client = $getsixdata->client_id;
        $assignmentid = $getsixdata->assignment_id;

        // $updatewording = match (true) {
        //     // Travel
        //     $client == 32 => 'T',
        //     // Off holidays
        //     $client == 33 && str_replace(['1st ', '2nd ', '3rd ', '4th ', '5th '], '', $getsixdata->workitem) == 'Saturday' => 'OH',
        //     // Other holidays from calendar
        //     $client == 33 => 'H',
        //     // when submit timesheet before joining date
        //     $assignmentid == 213 && $getsixdata->workitem == 'NA' => null,
        //     // Casual leave
        //     $client == 134 && $assignmentid == 215 => 'CL',
        //     // Exam leave
        //     $client == 134 && $assignmentid == 214 => 'EL',
        //         // Default presence
        //     default => 'P',
        // };

        if ($client == 32) {
            $updatewording = 'T'; // Travel
        } elseif ($client == 33 && str_replace(['1st ', '2nd ', '3rd ', '4th ', '5th '], '', $getsixdata->workitem) == 'Saturday') {
            $updatewording = 'OH'; // Off holidays
        } elseif ($client == 33) {
            $updatewording = 'H'; // Other holidays from calendar
        } elseif ($assignmentid == 213 && $getsixdata->workitem == 'NA') {
            $updatewording = null; // Casual leave
        } elseif ($client == 134 && $assignmentid == 215) {
            $updatewording = 'CL'; // Casual leave
        } elseif ($client == 134 && $assignmentid == 214) {
            $updatewording = 'EL'; // Exam leave
        } else {
            $updatewording = 'P'; // Default presence
        }
    }

    $totalCountMapping = [
        'P' => 'no_of_days_present',
        'CL' => 'casual_leave',
        'EL' => 'exam_leave',
        'T' => 'travel',
        'OH' => 'offholidays',
        'W' => 'sundaycount',
        'H' => 'holidays',
        null => 'beforejoiningcount'
    ];

    // Update the total count and attendance record if applicable
    if (isset($totalCountMapping[$updatewording])) {
        $totalcountColumn = $totalCountMapping[$updatewording];
        $totalcountupdate = $attendances->$totalcountColumn + 1;

        // DB::table('attendances')
        //     ->where('id', $attendances->id)
        //     ->update([
        //         $column => $updatewording,
        //         $totalcountColumn => $totalcountupdate,
        //     ]);

        // $totalcountupdate = $attendances->$totalcountColumn ? $attendances->$totalcountColumn + 1 : 1;



        if ($totalcountColumn != "exam_leave") {

            $iftwotimesheetinday = DB::table('attendances')
                ->where('id', $attendances->id)
                ->value($column);

            if ($iftwotimesheetinday == "P") {
                $updatewording = "P";
                $totalcountupdate = $attendances->$totalcountColumn + 0;
            } elseif ($iftwotimesheetinday == 'T') {
                $updatewording = "P";
                $totalcountupdate = $attendances->$totalcountColumn + 0;
            }

            DB::table('attendances')
                ->where('id', $attendances->id)
                ->update([
                    $column => $updatewording,
                    $totalcountColumn => $totalcountupdate,
                ]);
        }
    }
    // Attendance code end hare  
    // Start Hare 
    //*
       // Function to handle change event for client select
          // 21-10-24
          // function handleClientChange(clientId) {
          //     $('#' + clientId).on('change', function() {
          //         var cid = $(this).val();
          //         var datepickers = $('#datepickers').val();
          //         var clientNumber = parseInt(clientId.replace('client', ''));

          //         if (cid == 33) {
          //             $.ajax({
          //                 type: "get",
          //                 url: "{{ url('holidaysselect') }}",
          //                 data: {
          //                     cid: cid,
          //                     datepickers: datepickers
          //                 },
          //                 success: function(response) {
          //                     var location = 'N/A';
          //                     var time = 0;
          //                     var holidayName = response.holidayName;
          //                     var saturday = response.saturday;
          //                     if (holidayName == 'null') {
          //                         var workitem = saturday;
          //                     } else if (saturday == 'null') {
          //                         var workitem = holidayName;
          //                     } else {
          //                         var workitem = holidayName;
          //                     }

          //                     if (!isNaN(clientNumber)) {
          //                         var assignmentSelect = $('.assignmentvalue' + clientNumber);
          //                         assignmentSelect.empty();
          //                         assignmentSelect.append($('<option>', {
          //                             value: response.assignmentgenerate_id,
          //                             text: response.assignment_name + ' (' +
          //                                 response
          //                                 .assignmentname + '/' + response
          //                                 .assignmentgenerate_id + ')'
          //                         }));

          //                         var assignmentSelect = $('.partnervalue' + clientNumber);
          //                         assignmentSelect.empty();
          //                         assignmentSelect.append($('<option>', {
          //                             value: response.team_memberid,
          //                             text: response.team_member
          //                         }));

          //                         $('.workitemnvalue' + clientNumber).val(workitem).prop(
          //                             'readonly', true);
          //                         $('.locationvalue' + clientNumber).val(location).prop(
          //                             'readonly', true);
          //                         $('#totalhours').val(time);
          //                         $('#hour' + (clientNumber + 1)).prop('readonly', true);
          //                     } else {

          //                         var assignmentSelect = $('.assignmentvalue');
          //                         assignmentSelect.empty();
          //                         assignmentSelect.append($('<option>', {
          //                             value: response.assignmentgenerate_id,
          //                             text: response.assignment_name + ' (' +
          //                                 response
          //                                 .assignmentname + '/' + response
          //                                 .assignmentgenerate_id + ')'
          //                         }));

          //                         var assignmentSelect = $('.partnervalue');
          //                         assignmentSelect.empty();
          //                         assignmentSelect.append($('<option>', {
          //                             value: response.team_memberid,
          //                             text: response.team_member
          //                         }));


          //                         $('.workitemnvalue').val(workitem).prop('readonly', true);
          //                         $('.locationvalue').val(location).prop('readonly', true);
          //                         $('#totalhours').val(time);
          //                         $("#hour1").prop("readonly", true);
          //                     }
          //                 },
          //                 error: function() {
          //                     // Handle error if AJAX request fails
          //                 }
          //             });
          //         } else {
          //             $.ajax({
          //                 type: "get",
          //                 url: "{{ url('timesheet/create') }}",
          //                 data: {
          //                     cid: cid,
          //                     datepickers: datepickers
          //                 },
          //                 success: function(res) {
          //                     // clear previous data 
          //                     if (!isNaN(clientNumber)) {
          //                         $('.assignmentvalue' + clientNumber).empty();
          //                         $('.partnervalue' + clientNumber).empty();
          //                         $('.workitemnvalue' + clientNumber).val('').prop('readonly',
          //                             false);
          //                         $('.locationvalue' + clientNumber).val('').prop('readonly',
          //                             false);
          //                         $("#hour" + (clientNumber + 1)).prop("readonly", false);

          //                     } else {
          //                         $('.assignmentvalue').empty();
          //                         $('.partnervalue').empty();
          //                         $('.workitemnvalue').val('').prop('readonly', false);
          //                         $('.locationvalue').val('').prop('readonly', false);
          //                         $("#hour1").prop("readonly", false);
          //                     }

          //                     $('#' + clientId.replace('client', 'assignment')).html(res);

          //                 },
          //                 error: function() {
          //                     // Handle error if AJAX request fails
          //                 },
          //             });
          //         }
          //     });
          // }

          //   21-10-24
          //   function handleClientChange(clientId) {
          //       $('#' + clientId).on('change', function() {
          //           var cid = $(this).val();
          //           var datepickers = $('#datepickers').val();
          //           var clientNumber = parseInt(clientId.replace('client', ''));

          //           if (cid == 33) {
          //               $.ajax({
          //                   type: "get",
          //                   url: "{{ url('holidaysselect') }}",
          //                   data: {
          //                       cid: cid,
          //                       datepickers: datepickers
          //                   },
          //                   success: function(response) {
          //                       $('.row.row-sm.showdiv').addClass('d-none');
          //                       var location = 'N/A';
          //                       var time = 0;
          //                       var holidayName = response.holidayName;
          //                       var saturday = response.saturday;
          //                       if (holidayName == 'null') {
          //                           var workitem = saturday;
          //                       } else if (saturday == 'null') {
          //                           var workitem = holidayName;
          //                       } else {
          //                           var workitem = holidayName;
          //                       }

          //                       if (!isNaN(clientNumber)) {
          //                           var assignmentSelect = $('.assignmentvalue' + clientNumber);
          //                           assignmentSelect.empty();
          //                           assignmentSelect.append($('<option>', {
          //                               value: response.assignmentgenerate_id,
          //                               text: response.assignment_name + ' (' +
          //                                   response
          //                                   .assignmentname + '/' + response
          //                                   .assignmentgenerate_id + ')'
          //                           }));

          //                           var assignmentSelect = $('.partnervalue' + clientNumber);
          //                           assignmentSelect.empty();
          //                           assignmentSelect.append($('<option>', {
          //                               value: response.team_memberid,
          //                               text: response.team_member
          //                           }));

          //                           $('.workitemnvalue' + clientNumber).val(workitem).prop(
          //                               'readonly', true);
          //                           $('.locationvalue' + clientNumber).val(location).prop(
          //                               'readonly', true);
          //                           $('#totalhours').val(time);
          //                           $('#hour' + (clientNumber + 1)).prop('readonly', true);
          //                       } else {

          //                           var assignmentSelect = $('.assignmentvalue');
          //                           assignmentSelect.empty();
          //                           assignmentSelect.append($('<option>', {
          //                               value: response.assignmentgenerate_id,
          //                               text: response.assignment_name + ' (' +
          //                                   response
          //                                   .assignmentname + '/' + response
          //                                   .assignmentgenerate_id + ')'
          //                           }));

          //                           var assignmentSelect = $('.partnervalue');
          //                           assignmentSelect.empty();
          //                           assignmentSelect.append($('<option>', {
          //                               value: response.team_memberid,
          //                               text: response.team_member
          //                           }));


          //                           $('.workitemnvalue').val(workitem).prop('readonly', true);
          //                           $('.locationvalue').val(location).prop('readonly', true);
          //                           $('#totalhours').val(time);
          //                           $("#hour1").prop("readonly", true);
          //                       }

          //                   },
          //                   error: function() {
          //                       // Handle error if AJAX request fails
          //                   }
          //               });
          //           } else {
          //               $.ajax({
          //                   type: "get",
          //                   url: "{{ url('timesheet/create') }}",
          //                   data: {
          //                       cid: cid,
          //                       datepickers: datepickers
          //                   },
          //                   success: function(res) {
          //                       //   $('.row.row-sm.d-none').removeClass('d-none');
          //                       $('.row.row-sm.showdiv').removeClass('d-none');
          //                       // clear previous data 
          //                       if (!isNaN(clientNumber)) {
          //                           $('.assignmentvalue' + clientNumber).empty();
          //                           $('.partnervalue' + clientNumber).empty();
          //                           $('.workitemnvalue' + clientNumber).val('').prop('readonly',
          //                               false);
          //                           $('.locationvalue' + clientNumber).val('').prop('readonly',
          //                               false);
          //                           $("#hour" + (clientNumber + 1)).prop("readonly", false);

          //                       } else {
          //                           $('.assignmentvalue').empty();
          //                           $('.partnervalue').empty();
          //                           $('.workitemnvalue').val('').prop('readonly', false);
          //                           $('.locationvalue').val('').prop('readonly', false);
          //                           $("#hour1").prop("readonly", false);
          //                       }

          //                       $('#' + clientId.replace('client', 'assignment')).html(res);

          //                   },
          //                   error: function() {
          //                       // Handle error if AJAX request fails
          //                   },
          //               });
          //           }
          //       });
          //   }

          // working good 
          //   function handleClientChange(clientId) {
          //       $('#' + clientId).on('change', function() {
          //           var cid = $(this).val();
          //           var datepickers = $('#datepickers').val();
          //           var clientNumber = parseInt(clientId.replace('client', ''));

          //           if (cid == 33) {
          //               $.ajax({
          //                   type: "get",
          //                   url: "{{ url('holidaysselect') }}",
          //                   data: {
          //                       cid: cid,
          //                       datepickers: datepickers
          //                   },
          //                   success: function(response) {

          //                       $('.row.row-sm.showdiv').addClass('d-none').find(
          //                           'input,textarea').val('').prop(
          //                           'readonly', false);
          //                       $('#assignment1, #partner1').empty();

          //                       var location = 'N/A';
          //                       var time = 0;
          //                       var holidayName = response.holidayName;
          //                       var saturday = response.saturday;
          //                       if (holidayName == 'null') {
          //                           var workitem = saturday;
          //                       } else if (saturday == 'null') {
          //                           var workitem = holidayName;
          //                       } else {
          //                           var workitem = holidayName;
          //                       }

          //                       if (!isNaN(clientNumber)) {
          //                           var assignmentSelect = $('.assignmentvalue' + clientNumber);
          //                           assignmentSelect.empty();
          //                           assignmentSelect.append($('<option>', {
          //                               value: response.assignmentgenerate_id,
          //                               text: response.assignment_name + ' (' +
          //                                   response
          //                                   .assignmentname + '/' + response
          //                                   .assignmentgenerate_id + ')'
          //                           }));

          //                           var assignmentSelect = $('.partnervalue' + clientNumber);
          //                           assignmentSelect.empty();
          //                           assignmentSelect.append($('<option>', {
          //                               value: response.team_memberid,
          //                               text: response.team_member
          //                           }));

          //                           $('.workitemnvalue' + clientNumber).val(workitem).prop(
          //                               'readonly', true);
          //                           $('.locationvalue' + clientNumber).val(location).prop(
          //                               'readonly', true);
          //                           $('#totalhours').val(time);
          //                           $('#hour' + (clientNumber + 1)).prop('readonly', true);
          //                       } else {

          //                           var assignmentSelect = $('.assignmentvalue');
          //                           assignmentSelect.empty();
          //                           assignmentSelect.append($('<option>', {
          //                               value: response.assignmentgenerate_id,
          //                               text: response.assignment_name + ' (' +
          //                                   response
          //                                   .assignmentname + '/' + response
          //                                   .assignmentgenerate_id + ')'
          //                           }));

          //                           var assignmentSelect = $('.partnervalue');
          //                           assignmentSelect.empty();
          //                           assignmentSelect.append($('<option>', {
          //                               value: response.team_memberid,
          //                               text: response.team_member
          //                           }));


          //                           $('.workitemnvalue').val(workitem).prop('readonly', true);
          //                           $('.locationvalue').val(location).prop('readonly', true);
          //                           $('#totalhours').val(time);
          //                           $("#hour1").prop("readonly", true);
          //                       }

          //                   },
          //                   error: function() {
          //                       // Handle error if AJAX request fails
          //                   }
          //               });
          //           } else {
          //               $.ajax({
          //                   type: "get",
          //                   url: "{{ url('timesheet/create') }}",
          //                   data: {
          //                       cid: cid,
          //                       datepickers: datepickers
          //                   },
          //                   success: function(res) {
          //                       //   $('.row.row-sm.d-none').removeClass('d-none');
          //                       $('.row.row-sm.showdiv').removeClass('d-none').find(
          //                           'input,textarea').val('').prop(
          //                           'readonly', false);
          //                       $('#assignment1, #partner1').empty();
          //                       // clear previous data 
          //                       if (!isNaN(clientNumber)) {
          //                           $('.assignmentvalue' + clientNumber).empty();
          //                           $('.partnervalue' + clientNumber).empty();
          //                           $('.workitemnvalue' + clientNumber).val('').prop('readonly',
          //                               false);
          //                           $('.locationvalue' + clientNumber).val('').prop('readonly',
          //                               false);
          //                           $("#hour" + (clientNumber + 1)).prop("readonly", false);

          //                       } else {
          //                           $('.assignmentvalue').empty();
          //                           $('.partnervalue').empty();
          //                           $('.workitemnvalue').val('').prop('readonly', false);
          //                           $('.locationvalue').val('').prop('readonly', false);
          //                           $("#hour1").prop("readonly", false);
          //                       }

          //                       $('#' + clientId.replace('client', 'assignment')).html(res);

          //                   },
          //                   error: function() {
          //                       // Handle error if AJAX request fails
          //                   },
          //               });
          //           }
          //       });
          //   }

          //   function handleClientChange(clientId) {
          //       $('#' + clientId).on('change', function() {
          //           var cid = $(this).val();
          //           var datepickers = $('#datepickers').val();
          //           var clientNumber = parseInt(clientId.replace('client', ''));

          //           if (cid == 33) {
          //               $.ajax({
          //                   type: "get",
          //                   url: "{{ url('holidaysselect') }}",
          //                   data: {
          //                       cid: cid,
          //                       datepickers: datepickers
          //                   },
          //                   success: function(response) {
          //                       // Hide div and clear all form fields
          //                       //   $('.row.row-sm.showdiv').addClass('d-none').find(
          //                       //       'input, textarea, select').empty('').prop('readonly',
          //                       //       false);


          //                       $('.row.row-sm.showdiv').addClass('d-none').find(
          //                           'input, textarea').val('').prop('readonly', false);

          //                       // Clear only the select boxes with specific IDs
          //                       $('#assignment1, #partner1').empty();
          //                       //   $('#client1').html('<option value="">Select Client</option>');
          //                       $('#client1,assignment1').html(res);

          //                       var location = 'N/A';
          //                       var time = 0;
          //                       var holidayName = response.holidayName;
          //                       var saturday = response.saturday;
          //                       var workitem = holidayName === 'null' ? saturday : holidayName;

          //                       if (!isNaN(clientNumber)) {
          //                           var assignmentSelect = $('.assignmentvalue' + clientNumber);
          //                           assignmentSelect.empty();
          //                           assignmentSelect.append($('<option>', {
          //                               value: response.assignmentgenerate_id,
          //                               text: response.assignment_name + ' (' +
          //                                   response.assignmentname + '/' + response
          //                                   .assignmentgenerate_id + ')'
          //                           }));

          //                           var partnerSelect = $('.partnervalue' + clientNumber);
          //                           partnerSelect.empty();
          //                           partnerSelect.append($('<option>', {
          //                               value: response.team_memberid,
          //                               text: response.team_member
          //                           }));

          //                           $('.workitemnvalue' + clientNumber).val(workitem).prop(
          //                               'readonly', true);
          //                           $('.locationvalue' + clientNumber).val(location).prop(
          //                               'readonly', true);
          //                           $('#totalhours').val(time);
          //                           $('#hour' + (clientNumber + 1)).prop('readonly', true);
          //                       } else {
          //                           var assignmentSelect = $('.assignmentvalue');
          //                           assignmentSelect.empty();
          //                           assignmentSelect.append($('<option>', {
          //                               value: response.assignmentgenerate_id,
          //                               text: response.assignment_name + ' (' +
          //                                   response.assignmentname + '/' + response
          //                                   .assignmentgenerate_id + ')'
          //                           }));

          //                           var partnerSelect = $('.partnervalue');
          //                           partnerSelect.empty();
          //                           partnerSelect.append($('<option>', {
          //                               value: response.team_memberid,
          //                               text: response.team_member
          //                           }));

          //                           $('.workitemnvalue').val(workitem).prop('readonly', true);
          //                           $('.locationvalue').val(location).prop('readonly', true);
          //                           $('#totalhours').val(time);
          //                           $("#hour1").prop('readonly', true);
          //                       }
          //                   },
          //                   error: function() {
          //                       // Handle error if AJAX request fails
          //                   }
          //               });
          //           } else {
          //               $.ajax({
          //                   type: "get",
          //                   url: "{{ url('timesheet/create') }}",
          //                   data: {
          //                       cid: cid,
          //                       datepickers: datepickers
          //                   },
          //                   success: function(res) {
          //                       // Show div and clear all form fields
          //                       //   $('.row.row-sm.d-none').removeClass('d-none').find(
          //                       //       'input, textarea, select').val('').prop('readonly',
          //                       //       false);

          //                       $('.row.row-sm.showdiv').removeClass('d-none').find(
          //                           'input, textarea').val('').prop('readonly', false);

          //                       // Clear only the select boxes with specific IDs
          //                       $('#assignment1, #partner1').empty().prop('readonly', false);

          //                       // Set the default option for the client dropdown
          //                       //   $('#client1').html('<option value="">Select Client</option>');
          //                       $('#client1,assignment1').html(res);

          //                       if (!isNaN(clientNumber)) {
          //                           $('.assignmentvalue' + clientNumber).empty();
          //                           $('.partnervalue' + clientNumber).empty();
          //                           $('.workitemnvalue' + clientNumber).val('').prop('readonly',
          //                               false);
          //                           $('.locationvalue' + clientNumber).val('').prop('readonly',
          //                               false);
          //                           $("#hour" + (clientNumber + 1)).prop('readonly', false);
          //                       } else {
          //                           $('.assignmentvalue').empty();
          //                           $('.partnervalue').empty();
          //                           $('.workitemnvalue').val('').prop('readonly', false);
          //                           $('.locationvalue').val('').prop('readonly', false);
          //                           $("#hour1").prop('readonly', false);
          //                       }

          //                       $('#' + clientId.replace('client', 'assignment')).html(res);
          //                   },
          //                   error: function() {
          //                       // Handle error if AJAX request fails
          //                   }
          //               });
          //           }
          //       });
          //   }

          //   working good
          function handleClientChange(clientId) {
            $('#' + clientId).on('change', function() {
                var cid = $(this).val();
                var datepickers = $('#datepickers').val();
                var clientNumber = parseInt(clientId.replace('client', ''));

                if (cid == 33) {
                    $.ajax({
                        type: "get",
                        url: "{{ url('holidaysselect') }}",
                        data: {
                            cid: cid,
                            datepickers: datepickers
                        },
                        success: function(response) {

                            $('.row.row-sm.showdiv').addClass('d-none').find(
                                'input,textarea').val('').prop(
                                'readonly', false);
                            $('#assignment1, #partner1').empty();
                            //   $('#client1').val('');
                            $('#client1').val('Select Client');

                            var location = 'N/A';
                            var time = 0;
                            var holidayName = response.holidayName;
                            var saturday = response.saturday;
                            if (holidayName == 'null') {
                                var workitem = saturday;
                            } else if (saturday == 'null') {
                                var workitem = holidayName;
                            } else {
                                var workitem = holidayName;
                            }

                            if (!isNaN(clientNumber)) {
                                var assignmentSelect = $('.assignmentvalue' + clientNumber);
                                assignmentSelect.empty();
                                assignmentSelect.append($('<option>', {
                                    value: response.assignmentgenerate_id,
                                    text: response.assignment_name + ' (' +
                                        response
                                        .assignmentname + '/' + response
                                        .assignmentgenerate_id + ')'
                                }));

                                var assignmentSelect = $('.partnervalue' + clientNumber);
                                assignmentSelect.empty();
                                assignmentSelect.append($('<option>', {
                                    value: response.team_memberid,
                                    text: response.team_member
                                }));

                                $('.workitemnvalue' + clientNumber).val(workitem).prop(
                                    'readonly', true);
                                $('.locationvalue' + clientNumber).val(location).prop(
                                    'readonly', true);
                                $('#totalhours').val(time);
                                $('#hour' + (clientNumber + 1)).prop('readonly', true);
                            } else {

                                var assignmentSelect = $('.assignmentvalue');
                                assignmentSelect.empty();
                                assignmentSelect.append($('<option>', {
                                    value: response.assignmentgenerate_id,
                                    text: response.assignment_name + ' (' +
                                        response
                                        .assignmentname + '/' + response
                                        .assignmentgenerate_id + ')'
                                }));

                                var assignmentSelect = $('.partnervalue');
                                assignmentSelect.empty();
                                assignmentSelect.append($('<option>', {
                                    value: response.team_memberid,
                                    text: response.team_member
                                }));


                                $('.workitemnvalue').val(workitem).prop('readonly', true);
                                $('.locationvalue').val(location).prop('readonly', true);
                                $('#totalhours').val(time);
                                $("#hour1").prop("readonly", true);
                            }

                        },
                        error: function() {
                            // Handle error if AJAX request fails
                        }
                    });
                } else {
                    $.ajax({
                        type: "get",
                        url: "{{ url('timesheet/create') }}",
                        data: {
                            cid: cid,
                            datepickers: datepickers
                        },
                        success: function(res) {
                            //   $('.row.row-sm.d-none').removeClass('d-none');
                            $('.row.row-sm.showdiv').removeClass('d-none').find(
                                'input,textarea').val('').prop(
                                'readonly', false);
                            $('#assignment1, #partner1').empty();
                            //   $('#client1').val('');

                            // clear previous data 
                            if (!isNaN(clientNumber)) {
                                $('.assignmentvalue' + clientNumber).empty();
                                $('.partnervalue' + clientNumber).empty();
                                $('.workitemnvalue' + clientNumber).val('').prop('readonly',
                                    false);
                                $('.locationvalue' + clientNumber).val('').prop('readonly',
                                    false);
                                $("#hour" + (clientNumber + 1)).prop("readonly", false);

                            } else {
                                $('.assignmentvalue').empty();
                                $('.partnervalue').empty();
                                $('.workitemnvalue').val('').prop('readonly', false);
                                $('.locationvalue').val('').prop('readonly', false);
                                $("#hour1").prop("readonly", false);
                            }

                            $('#' + clientId.replace('client', 'assignment')).html(res);

                        },
                        error: function() {
                            // Handle error if AJAX request fails
                        },
                    });
                }
            });
        }

        //   function handleClientChange(clientId) {
        //       $('#' + clientId).on('change', function() {
        //           var cid = $(this).val();
        //           var datepickers = $('#datepickers').val();
        //           var valueofIdattribute = $(this).attr('id');
        //           var clientNumber = parseInt(clientId.replace('client', ''));

        //           if (cid == 33) {

        //               if (valueofIdattribute == 'client' || valueofIdattribute == 'client1') {
        //                   $('.row.row-sm.showdiv').addClass('d-none').find(
        //                       'input,textarea').val('').prop(
        //                       'readonly', false);
        //                   $('#assignment1, #partner1').empty();
        //                   //   $('#client1').val('');
        //                   $('#client1').val('Select Client');
        //               }
        //               $.ajax({
        //                   type: "get",
        //                   url: "{{ url('holidaysselect') }}",
        //                   data: {
        //                       cid: cid,
        //                       datepickers: datepickers
        //                   },
        //                   success: function(response) {
        //                       var location = 'N/A';
        //                       var time = 0;
        //                       var holidayName = response.holidayName;
        //                       var saturday = response.saturday;
        //                       if (holidayName == 'null') {
        //                           var workitem = saturday;
        //                       } else if (saturday == 'null') {
        //                           var workitem = holidayName;
        //                       } else {
        //                           var workitem = holidayName;
        //                       }

        //                       if (!isNaN(clientNumber)) {
        //                           var assignmentSelect = $('.assignmentvalue' + clientNumber);
        //                           assignmentSelect.empty();
        //                           assignmentSelect.append($('<option>', {
        //                               value: response.assignmentgenerate_id,
        //                               text: response.assignment_name + ' (' +
        //                                   response
        //                                   .assignmentname + '/' + response
        //                                   .assignmentgenerate_id + ')'
        //                           }));

        //                           var assignmentSelect = $('.partnervalue' + clientNumber);
        //                           assignmentSelect.empty();
        //                           assignmentSelect.append($('<option>', {
        //                               value: response.team_memberid,
        //                               text: response.team_member
        //                           }));

        //                           $('.workitemnvalue' + clientNumber).val(workitem).prop(
        //                               'readonly', true);
        //                           $('.locationvalue' + clientNumber).val(location).prop(
        //                               'readonly', true);
        //                           $('#totalhours').val(time);
        //                           $('#hour' + (clientNumber + 1)).prop('readonly', true);
        //                       } else {

        //                           var assignmentSelect = $('.assignmentvalue');
        //                           assignmentSelect.empty();
        //                           assignmentSelect.append($('<option>', {
        //                               value: response.assignmentgenerate_id,
        //                               text: response.assignment_name + ' (' +
        //                                   response
        //                                   .assignmentname + '/' + response
        //                                   .assignmentgenerate_id + ')'
        //                           }));

        //                           var assignmentSelect = $('.partnervalue');
        //                           assignmentSelect.empty();
        //                           assignmentSelect.append($('<option>', {
        //                               value: response.team_memberid,
        //                               text: response.team_member
        //                           }));


        //                           $('.workitemnvalue').val(workitem).prop('readonly', true);
        //                           $('.locationvalue').val(location).prop('readonly', true);
        //                           $('#totalhours').val(time);
        //                           $("#hour1").prop("readonly", true);
        //                       }

        //                   },
        //                   error: function() {
        //                       // Handle error if AJAX request fails
        //                   }
        //               });
        //           } else {
        //               if (valueofIdattribute == 'client' || valueofIdattribute == 'client1') {
        //                   //   $('.row.row-sm.d-none').removeClass('d-none');
        //                   $('.row.row-sm.showdiv').removeClass('d-none').find(
        //                       'input,textarea').val('').prop(
        //                       'readonly', false);
        //                   $('#assignment1, #partner1').empty();
        //                   //   $('#client1').val('');
        //               }
        //               $.ajax({
        //                   type: "get",
        //                   url: "{{ url('timesheet/create') }}",
        //                   data: {
        //                       cid: cid,
        //                       datepickers: datepickers
        //                   },
        //                   success: function(res) {
        //                       // clear previous data 
        //                       if (!isNaN(clientNumber)) {
        //                           $('.assignmentvalue' + clientNumber).empty();
        //                           $('.partnervalue' + clientNumber).empty();
        //                           $('.workitemnvalue' + clientNumber).val('').prop('readonly',
        //                               false);
        //                           $('.locationvalue' + clientNumber).val('').prop('readonly',
        //                               false);
        //                           $("#hour" + (clientNumber + 1)).prop("readonly", false);

        //                       } else {
        //                           $('.assignmentvalue').empty();
        //                           $('.partnervalue').empty();
        //                           $('.workitemnvalue').val('').prop('readonly', false);
        //                           $('.locationvalue').val('').prop('readonly', false);
        //                           $("#hour1").prop("readonly", false);
        //                       }

        //                       $('#' + clientId.replace('client', 'assignment')).html(res);

        //                   },
        //                   error: function() {
        //                       // Handle error if AJAX request fails
        //                   },
        //               });
        //           }
        //       });
        //   }
    // Start Hare 
    //*
    // Start Hare 
    public function adminattendancereport(Request $request)
    {
        $teamnid = $request->input('teammemberId');
        // $startdate = Carbon::parse($request->input('startdate'));
        // $enddate = Carbon::parse($request->input('enddate'));

        // // Convert start and end dates to their respective month numbers
        // $startMonth = $startdate->format('n'); // Month number (1-12)
        // $endMonth = $enddate->format('n');     // Month number (1-12)

        // $query1 = DB::table('attendances')
        //     ->leftJoin('teammembers', 'teammembers.id', '=', 'attendances.employee_name')
        //     ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
        //     ->leftJoin('roles', 'roles.id', '=', 'teammembers.role_id')
        //     // Filter where the attendance month falls between the start and end month
        //     ->whereBetween(DB::raw('MONTH(STR_TO_DATE(attendances.month, "%M"))'), [$startMonth, $endMonth])
        //     ->select(
        //         'attendances.*',
        //         'teammembers.team_member',
        //         'teammembers.staffcode',
        //         'teamrolehistory.newstaff_code',
        //         'teammembers.employment_status',
        //         'roles.rolename',
        //         'teammembers.joining_date'
        //     )
        //     ->get();

        // dd($query1);22

        // 222222222222222222222222222222222222222222
        $startdate = Carbon::parse($request->input('startdate'));
        $enddate = Carbon::parse($request->input('enddate'));

        // Convert start and end dates to their respective month numbers
        $startMonth = $startdate->format('n'); // Month number (1-12)
        $endMonth = $enddate->format('n');     // Month number (1-12)

        $query1 = DB::table('attendances')
            ->leftJoin('teammembers', 'teammembers.id', '=', 'attendances.employee_name')
            ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
            ->leftJoin('roles', 'roles.id', '=', 'teammembers.role_id')
            // Filter where the attendance month falls between the start and end month
            ->whereBetween(DB::raw('MONTH(STR_TO_DATE(CONCAT(attendances.month, " 1, 2000"), "%M %d, %Y"))'), [$startMonth, $endMonth])
            ->select(
                'attendances.*',
                'teammembers.team_member',
                'teammembers.staffcode',
                'teamrolehistory.newstaff_code',
                'teammembers.employment_status',
                'roles.rolename',
                'teammembers.joining_date'
            )
            ->get();

        dd($query1);

        // 222222222222222222222222222222222222222222
        // $startdate = Carbon::parse($request->input('startdate'));
        // $enddate = Carbon::parse($request->input('enddate'));

        // // Extract the month names
        // $startMonth = $startdate->format('F'); // e.g., 'January'
        // $endMonth = $enddate->format('F');     // e.g., 'December'

        // // Define an array of all months to ensure the correct order
        // $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        // // Get the slice of months between the start and end month (inclusive)
        // $filteredMonths = array_slice($months, array_search($startMonth, $months), array_search($endMonth, $months) - array_search($startMonth, $months) + 1);
        // dd($filteredMonths);
        // // Perform the query
        // $query1  = DB::table('attendances')
        //     ->leftJoin('teammembers', 'teammembers.id', '=', 'attendances.employee_name')
        //     ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
        //     ->leftJoin('roles', 'roles.id', '=', 'teammembers.role_id')
        //     ->whereIn('attendances.month', $filteredMonths)
        //     ->select('attendances.*', 'teammembers.team_member', 'teammembers.staffcode', 'teamrolehistory.newstaff_code', 'teammembers.employment_status', 'roles.rolename', 'teammembers.joining_date')
        //     ->get();

        // // Dump the results
        // dd($query1);

        // Retrieve all team members
        $teammembers = DB::table('teammembers')
            ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
            ->whereIn('teammembers.role_id', [14, 15, 13, 11])
            ->select('teammembers.team_member', 'teamrolehistory.newstaff_code', 'teammembers.id', 'teammembers.staffcode')
            ->orderBy('team_member', 'ASC')
            ->get();

        // Fetch single user data
        $singleusersearched = DB::table('teammembers')
            ->where('id', $teamnid)
            ->select('team_member', 'staffcode', 'id', 'leavingdate', 'joining_date')
            ->first();

        // Check leaving date validation
        if ($singleusersearched && $singleusersearched->leavingdate) {
            $leavingdate = Carbon::parse($singleusersearched->leavingdate);
            if ($startdate->gt($leavingdate)) {
                $output = ['msg' => 'User left on ' . $leavingdate->format('d-m-Y') . ', cannot select beyond this date.'];
                $request->flash();
                return redirect()->to('attendance')->with('statuss', $output);
            }
        }

        // Check joining date validation
        if ($singleusersearched && $singleusersearched->joining_date) {
            $joiningdate = Carbon::parse($singleusersearched->joining_date);
            if ($joiningdate->gt($enddate)) {
                $output = ['msg' => 'User joined on ' . $joiningdate->format('d-m-Y') . ', cannot select before this date.'];
                $request->flash();
                return redirect()->to('attendance')->with('statuss', $output);
            }
        }

        // Build attendance query filtered by month
        $query = DB::table('attendances')
            ->leftJoin('teammembers', 'teammembers.id', 'attendances.employee_name')
            ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
            ->leftJoin('roles', 'roles.id', 'teammembers.role_id')
            ->select(
                'attendances.*',
                'teammembers.team_member',
                'teammembers.staffcode',
                'teamrolehistory.newstaff_code',
                'teammembers.employment_status',
                'roles.rolename',
                'teammembers.joining_date'
            );

        if ($teamnid) {
            $query->where('attendances.employee_name', $teamnid);
        }

        if ($startMonth && $endMonth) {
            $query->whereBetween(DB::raw("FIELD(attendances.month, 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December')"), [$startMonth, $endMonth]);
        }

        $attendanceDatas = $query->get();
        $request->flash();

        return view('backEnd.attendance.adminattendance', compact('attendanceDatas', 'teammembers'));
    }
    //*

    public function adminattendancereport(Request $request)
    {
        $teamnid = $request->input('teammemberId');
        $startdate = \Carbon\Carbon::parse($request->input('startdate'));
        $enddate = \Carbon\Carbon::parse($request->input('enddate'));

        // All team members with the specified roles
        $teammembers = DB::table('teammembers')
            ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
            ->whereIn('teammembers.role_id', [14, 15, 13, 11])
            ->select('teammembers.team_member', 'teamrolehistory.newstaff_code', 'teammembers.id', 'teammembers.staffcode')
            ->orderBy('team_member', 'ASC')
            ->get();

        // Fetch the selected team member
        $singleusersearched = DB::table('teammembers')
            ->where('id', $teamnid)
            ->select('team_member', 'staffcode', 'id', 'leavingdate', 'joining_date')
            ->first();

        // Validate leaving date
        if ($singleusersearched && $singleusersearched->leavingdate) {
            $leavingdate = \Carbon\Carbon::parse($singleusersearched->leavingdate);
            if ($startdate->gt($leavingdate)) {
                $output = ['msg' => 'You cannot select this user as their leaving date (' . $leavingdate->format('d-m-Y') . ') is before the start date.'];
                $request->flash();
                return redirect()->to('attendance')->with('statuss', $output);
            }
        }

        // Validate joining date
        if ($singleusersearched && $singleusersearched->joining_date) {
            $joiningdate = \Carbon\Carbon::parse($singleusersearched->joining_date);
            if ($joiningdate->gt($enddate)) {
                $output = ['msg' => 'You cannot select this user as their joining date (' . $joiningdate->format('d-m-Y') . ') is after the end date.'];
                $request->flash();
                return redirect()->to('attendance')->with('statuss', $output);
            }
        }

        // Build the attendance query
        $query = DB::table('attendances')
            ->leftJoin('teammembers', 'teammembers.id', 'attendances.employee_name')
            ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
            ->leftJoin('roles', 'roles.id', 'teammembers.role_id')
            ->select('attendances.*', 'teammembers.team_member', 'teammembers.staffcode', 'teamrolehistory.newstaff_code', 'teammembers.employment_status', 'roles.rolename', 'teammembers.joining_date');

        if ($teamnid) {
            $query->where('attendances.employee_name', $teamnid);
        }

        // Optimize date filtering
        if ($startdate && $enddate) {
            $query->whereBetween('attendances.fulldate', [$startdate, $enddate]);
        }

        $attendanceDatas = $query->get();
        $request->flash();

        return view('backEnd.attendance.adminattendance', compact('attendanceDatas', 'teammembers'));
    }
    // Start Hare 
    public function timesheet_mylist()
    {
      if (auth()->user()->role_id == 13) {
        // die;
        $client = Client::select('id', 'client_name')->get();
        // $getauth =  DB::table('timesheetusers')
        //   ->where('createdby', auth()->user()->teammember_id)
        //   ->where('status', '0')
        //   ->orderby('id', 'desc')->first();
  
        // this gatauth goes to backEnd.timesheet.index file
        $getauth =  DB::table('timesheetusers')
          ->where('createdby', auth()->user()->teammember_id)
          ->where('status', '1')
          ->orderBy('date', 'desc')
          ->first();
  
        $dropdownYears = DB::table('timesheets')
          ->where('created_by', auth()->user()->teammember_id)
          ->select(DB::raw('YEAR(date) as year'))
          ->distinct()->orderBy('year', 'DESC')->pluck('year');
  
        $dropdownYears = DB::table('timesheets')
          ->where('created_by', auth()->user()->teammember_id)
          ->select(DB::raw('YEAR(date) as year'))
          ->distinct()->orderBy('year', 'DESC')->pluck('year');
  
  
        $dropdownMonths = DB::table('timesheets')
          ->where('created_by', auth()->user()->teammember_id)
          ->distinct()
          ->pluck('month');
  
        $partner = Teammember::where('role_id', '=', 11)->whereNotIn('id', [447])->where('status', '=', 1)->where('team_member', '!=', 'Partner')->with('title')->get();
        // $partner = Teammember::where('role_id', '=', 11)->where('status', '=', 1)->where('team_member', '!=', 'Partner')->with('title')->get();
  
        $currentDate = now();
  
  
        $month = $currentDate->format('F');
        $year = $currentDate->format('Y');
  
        //	  $time =  DB::table('timesheets')->get();
        // foreach ($time as $value) {
        //dd(date('F', strtotime($value->date)));
        //      DB::table('timesheets')->where('id',$value->id)->update([	
        //          'month'         =>     date('F', strtotime($value->date)),
        //           ]);
        // }
        $teammember = DB::table('timesheets')
          ->leftjoin('timesheetusers', 'timesheetusers.timesheetid', 'timesheets.id')
          ->leftjoin('teammembers', 'teammembers.id', 'timesheets.created_by')
          ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
          ->where('timesheetusers.partner', auth()->user()->teammember_id)
          ->select('teammembers.id', 'teammembers.team_member', 'roles.rolename')->distinct()->get();
        //  dd($teammember);
        $month = DB::table('timesheets')
          ->select('timesheets.month')->distinct()->get();
  
        $result = DB::table('timesheetusers')->select(DB::raw('YEAR(date) as year'))
          ->distinct()->orderBy('year', 'DESC')->limit(5)->get();
  
        $years = $result->pluck('year');
  
        $timesheetData = DB::table('timesheetusers')
          ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
          ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'timesheetusers.assignmentgenerate_id')
          ->where('timesheetusers.createdby', auth()->user()->teammember_id)
          ->where('timesheetusers.status', 0)
          ->select('timesheetusers.*', 'teammembers.team_member', 'assignmentbudgetings.assignmentname', 'assignmentbudgetings.created_at as assignmentcreated')->orderBy('date', 'ASC')
          ->paginate(14);
        // dd($timesheetData);
        $getauthh =  DB::table('timesheetusers')
          ->where('createdby', auth()->user()->teammember_id)
          ->orderby('id', 'desc')->first();
  
        $timesheetrequest = DB::table('timesheetrequests')->where('createdby', auth()->user()->teammember_id)->orderBy('id', 'DESC')->first();
        // dd($timesheetrequest, 2);
        if ($getauthh  == null) {
          return view('backEnd.timesheet.firstindex', compact('timesheetData', 'getauth', 'client', 'partner'));
        } else {
          return view('backEnd.timesheet.index', compact('timesheetrequest', 'partner', 'client', 'getauth', 'dropdownMonths', 'timesheetData', 'year', 'dropdownYears', 'month', 'teammember', 'month', 'years'));
        }
      } else {
  
        // Get year like 2023.2024,2025
        $dropdownYears = DB::table('timesheets')
          ->where('created_by', auth()->user()->teammember_id)
          ->select(DB::raw('YEAR(date) as year'))
          ->distinct()->orderBy('year', 'DESC')->pluck('year');
  
        // Get months like january to december
        $dropdownMonths = DB::table('timesheets')
          ->where('created_by', auth()->user()->teammember_id)
          ->distinct()
          ->pluck('month');
  
        $currentDate = now();
        $month = $currentDate->format('F');
        $year = $currentDate->format('Y');
  
        $getauths =  DB::table('timesheetusers')
          ->where('createdby', auth()->user()->teammember_id)
          ->where('status', '1')
          ->orderby('id', 'desc')->first();
  
  
        if ($getauths != null) {
          $currentDate = now();
          $currentDateformate = $currentDate->format('Y-m-d');
          // this gatauth goes to backEnd.timesheet.index file
          // $getauth =  DB::table('timesheetusers')
          //   ->where('createdby', auth()->user()->teammember_id)
          //   ->where('date', '<=', $currentDateformate)
          //   ->where('status', '1')
          //   ->orderby('id', 'desc')->first();
  
          // this gatauth goes to backEnd.timesheet.index file
          $getauth = DB::table('timesheetusers')
            ->where('createdby', auth()->user()->teammember_id)
            ->where('date', '<=', $currentDateformate)
            ->where('status', '1')
            // Sort by date in descending order to get the most recent date
            ->orderBy('date', 'desc')
            ->first();
        } else {
          // this gatauth goes to backEnd.timesheet.index file
          $getauth =  DB::table('timesheetusers')
            ->where('createdby', auth()->user()->teammember_id)
            ->where('status', '0')
            ->orderBy('date', 'desc')
            ->first();
          //dd($getauth);
        }
  
        $getauthh =  DB::table('timesheetusers')
          ->where('createdby', auth()->user()->teammember_id)
          ->orderBy('date', 'desc')
          ->first();
  
        $client = Client::select('id', 'client_name')->get();
        $timesheetData = DB::table('timesheetusers')
          ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
          ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'timesheetusers.assignmentgenerate_id')
          ->where('timesheetusers.createdby', auth()->user()->teammember_id)
          ->where('timesheetusers.status', 0)
          //   ->where('timesheets.month', $month)
          //  ->whereRaw('YEAR(timesheetusers.date) = ?', [$year])
          ->select('timesheetusers.*', 'teammembers.team_member', 'assignmentbudgetings.assignmentname', 'assignmentbudgetings.created_at as assignmentcreated')->orderBy('date', 'ASC')
          ->paginate(14);
  
        $partner = Teammember::whereNotIn('id', [887, 663, 841, 836, 843, 447])->where('role_id', '=', 13)->where('status', '=', 1)->with('title')
          ->orderBy('team_member', 'asc')->get();
  
        // $partner = Teammember::where('role_id', '=', 13)->where('status', '=', 1)->with('title')
        //   ->orderBy('team_member', 'asc')->get();
  
        $timesheetrequest = DB::table('timesheetrequests')->where('createdby', auth()->user()->teammember_id)->orderBy('id', 'DESC')->first();
  
        if ($getauthh  == null) {
          return view('backEnd.timesheet.firstindex', compact('timesheetData', 'getauth', 'client', 'partner'));
        } else {
          return view('backEnd.timesheet.index', compact(
            'timesheetData',
            'getauth',
            'client',
            'partner',
            'timesheetrequest',
            'dropdownYears',
            'dropdownMonths',
            'month',
            'year',
          ));
        }
      }
    }
    //*
    // Start Hare 
    $leavemonth = Carbon::parse($request->leavingdate)->format('F');
    $attendances = DB::table('attendances')
        ->where('employee_name', $id)
        ->where('month', $leavemonth)
        ->first();

    // dd($attendances);
    dd($request->leavingdate);  output of     dd($request->leavingdate); is "2024-10-08"  and output of this    dd($attendances); is {#2843 ▼
+"id": 53   
+"employee_name": "864"
+"employee_status": null
+"dateofjoining": "2018-04-02"
+"twentysix": null
+"twentyseven": null
+"twentyeight": null
+"twentynine": null
+"thirty": null
+"thirtyone": null
+"one": "P"
+"two": "T"
+"three": "P"
+"four": "P"
+"five": "P"
+"six": "P"
+"seven": null
+"eight": null
+"nine": null
+"ten": null
+"eleven": null
+"twelve": null
+"thirteen": null
+"fourteen": null
+"fifteen": null
+"sixteen": null
+"seventeen": null
+"eighteen": null
+"ninghteen": null
+"twenty": null
+"twentyone": null
+"twentytwo": null
+"twentythree": null
+"twentyfour": null
+"twentyfive": null
+"total_no_of_days": null
+"no_of_days_present": "5"
+"casual_leave": null
+"sick_leave": null
+"comp_off": null
+"birthday_religious": null
+"exam_leave": 0
+"absent": 0
+"lwp": null
+"weekend": null
+"totaldaystobepaid": null
+"comment": null
+"month": "October"
+"year": 2024
+"holidays": null
+"travel": 1
+"offholidays": null
+"sundaycount": null
+"fulldate": "2024-10-07"
+"beforejoiningcount": 0
+"created_at": "2024-10-07 13:19:26"
+"updated_at": "2024-10-07 13:19:26"
}  mai chahta hu ki  2024-10-08" eight column ke baad wla column yaani nine column se thirtyone column me value chala jaye leaving
    //*
    
    // Start Hare 
          // Get the max date from the collection
          $maxdate = $timesheetsave->max('date');

          // Format max date (optional)
          $formattedMaxDate = \Carbon\Carbon::parse($maxdate)->format('Y-m-d');
          dd($maxdate);
    //*

    public function client_list1()
    {
        // $client = Client::latest()->get();
        // return view('backEnd.client.1clientlist', compact('client'));
        // $teammemberDatas = DB::table('assignmentmappings')
        //     ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
        //     ->leftjoin('teammembers', 'teammembers.id', 'assignmentteammappings.teammember_id')
        //     ->leftjoin('titles', 'titles.id', 'teammembers.title_id')
        //     ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
        //     // ->where('assignmentmappings.assignmentgenerate_id', $id)
        //     ->where('assignmentmappings.assignmentgenerate_id', 'GOO100433')
        //     ->select('teammembers.*', 'roles.rolename', 'assignmentteammappings.type', 'titles.title', 'assignmentteammappings.id As assignmentteammappingsId', 'assignmentteammappings.status as assignmentteammappingsStatus', 'assignmentmappings.assignmentgenerate_id as assignmentgenerateid')
        //     ->get();

        // $teammemberDatas = DB::table('assignmentmappings')
        //     ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
        //     ->leftjoin('teammembers', 'teammembers.id', 'assignmentteammappings.teammember_id')
        //     ->leftjoin('titles', 'titles.id', 'teammembers.title_id')
        //     ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
        //     // ->where('assignmentmappings.assignmentgenerate_id', $id)
        //     // ->where('assignmentmappings.assignmentgenerate_id', 'GOO100433')
        //     ->select('assignmentmappings.id', 'teammembers.team_member', 'titles.title', 'assignmentmappings.assignmentgenerate_id')
        //     ->get();
        // dd($teammemberDatas);

        // $teammemberDatas = DB::table('assignmentteammappings')
        //     ->leftjoin('assignmentmappings', 'assignmentmappings.id', 'assignmentteammappings.assignmentmapping_id')
        //     ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        //     ->leftjoin('teammembers', 'teammembers.id', 'assignmentteammappings.teammember_id')
        //     ->leftjoin('titles', 'titles.id', 'teammembers.title_id')
        //     ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
        //     ->where('assignmentbudgetings.status', 1)
        //     // ->where('assignmentmappings.assignmentgenerate_id', 'GOO100433')
        //     ->select('assignmentmappings.id', 'teammembers.id as teamid', 'teammembers.team_member', 'titles.title', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentname')
        //     ->get();
        // dd($teammemberDatas);

        // $teammemberDatas2 = DB::table('assignmentteammappings')
        //     ->leftjoin('assignmentmappings', 'assignmentmappings.id', 'assignmentteammappings.assignmentmapping_id')
        //     ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        //     ->leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
        //     ->leftjoin('titles', 'titles.id', 'teammembers.title_id')
        //     ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
        //     ->where('assignmentbudgetings.status', 1)
        //     // ->where('assignmentmappings.assignmentgenerate_id', 'GOO100433')
        //     ->select('assignmentmappings.id', 'teammembers.id as teamid', 'teammembers.team_member', 'titles.title', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentname')
        //     ->get();

        // $teammemberDatas2 = DB::table('assignmentmappings')
        //     ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        //     ->leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.otherpartner')
        //     ->leftjoin('titles', 'titles.id', 'teammembers.title_id')
        //     ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
        //     ->where('assignmentbudgetings.status', 1)
        //     // ->where('assignmentmappings.assignmentgenerate_id', 'GOO100433')
        //     ->select('assignmentmappings.id', 'teammembers.id as teamid', 'teammembers.team_member', 'titles.title', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentname')
        //     ->get();

        // $teammemberDatas2 = DB::table('assignmentmappings')
        //     ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        //     ->leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
        //     ->leftjoin('titles', 'titles.id', 'teammembers.title_id')
        //     ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
        //     ->where('assignmentbudgetings.status', 1)
        //     // ->where('assignmentmappings.assignmentgenerate_id', 'GOO100433')
        //     ->select('assignmentmappings.id', 'teammembers.id as teamid', 'teammembers.team_member', 'titles.title', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentname')
        //     ->get();

        // dd($teammemberDatas2);

        $teammemberDatas2 = DB::table('assignmentmappings')
            ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
            ->leftjoin('teammembers', function ($join) {
                $join->on('teammembers.id', 'assignmentmappings.otherpartner')
                    ->orOn('teammembers.id', 'assignmentmappings.leadpartner');
            })
            ->leftjoin('titles', 'titles.id', 'teammembers.title_id')
            ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
            ->where('assignmentbudgetings.status', 1)
            ->select(
                'assignmentmappings.id',
                'teammembers.id as teamid',
                'teammembers.team_member',
                'titles.title',
                'assignmentmappings.assignmentgenerate_id',
                'assignmentbudgetings.assignmentname'
            )
            ->get();

        dd($teammemberDatas2);


        // return view('backEnd.viewassignment', compact('partner', 'udinDatas', 'contactDatas', 'teammemberDatas', 'assignmentcheckDatas', 'assignmentbudgetingDatas'));
        return view('backEnd.client.1clientlist', compact('teammemberDatas'));
    }
    // Start Hare 
    if ($request->leavingdate != null) {
        $timesheetsave = DB::table('timesheetusers')
            ->where('createdby', $id)
            ->where('status', 0)
            ->orderBy('date', 'ASC')
            ->get();

        // Chunk the $timesheetsave data for one week
        $weeksData = $timesheetsave->chunk(6);
        foreach ($weeksData as $weekData) {
            foreach ($weekData as $timesheet) {
                $startdate = Carbon::parse($timesheet->date);
                $nextSaturday = $startdate->copy()->next(Carbon::SATURDAY);

                $startdateformat = $startdate->format('Y-m-d');
                $nextSaturdayformat = $nextSaturday->format('Y-m-d');

                $week = date('d-m-Y', strtotime($startdateformat)) . ' to ' . date('d-m-Y', strtotime($nextSaturdayformat));

                DB::table('timesheetusers')
                    ->where('timesheetid', $timesheet->timesheetid)
                    ->update([
                        'status' => 1,
                        'updated_at' => now(),
                    ]);

                DB::table('timesheets')
                    ->where('id', $timesheet->timesheetid)
                    ->update([
                        'status' => 1,
                        'updated_at' => now(),
                    ]);
            }

            // Insert data into the timesheetreport table for the current week
            $startdate = Carbon::parse($weekData->first()->date);
            $nextSaturday = $startdate->copy()->next(Carbon::SATURDAY);

            $startdateformat = $startdate->format('Y-m-d');
            $nextSaturdayformat = $nextSaturday->format('Y-m-d');

            $week = date('d-m-Y', strtotime($startdateformat)) . ' to ' . date('d-m-Y', strtotime($nextSaturdayformat));

            $co = DB::table('timesheetusers')
                ->where('createdby', $id)
                ->whereBetween('date', [$startdateformat, $nextSaturdayformat])
                ->select('partner', DB::raw('SUM(hour) as total_hours'), DB::raw('COUNT(DISTINCT timesheetid) as row_count'))
                ->groupBy('partner')
                ->get();
            // dd($co);

            foreach ($co as $codata) {
                DB::table('timesheetreport')->insert([
                    'teamid'       =>     444,
                    'week'       =>     $week,
                    'totaldays'       =>     $codata->row_count,
                    'totaltime' =>  $codata->total_hours,
                    'partnerid'  => $codata->partner,
                    'startdate'  => $startdateformat,
                    'enddate'  => $nextSaturdayformat,
                    'created_at'                =>      date('y-m-d H:i:s'),
                ]);
            }
        }
    }
    // Start Hare 
    if ($request->leavingdate != null) {
        $timesheetsave = DB::table('timesheetusers')
            ->where('createdby', $id)
            ->where('status', 0)
            ->orderBy('date', 'ASC')
            ->get();

        // Chunk the $timesheetsave collection into arrays containing data for one week
        $weeksData = $timesheetsave->chunk(6); // Assuming each week has 6 data points
        foreach ($weeksData as $weekData) {

            // Reset total counts for each week
            $totalDays = 0;
            $totalHours = 0;

            foreach ($weekData as $timesheet) {
                $startdate = Carbon::parse($timesheet->date);
                $nextSaturday = $startdate->copy()->next(Carbon::SATURDAY);

                $startdateformat = $startdate->format('Y-m-d');
                $nextSaturdayformat = $nextSaturday->format('Y-m-d');

                $week = date('d-m-Y', strtotime($startdateformat)) . ' to ' . date('d-m-Y', strtotime($nextSaturdayformat));

                $totalDays++;
                $totalHours += $timesheet->hour;

                // Update status for timesheetusers and timesheets for the current week
                DB::table('timesheetusers')
                    ->where('timesheetid', $timesheet->timesheetid)
                    ->update([
                        'status' => 1,
                        'updated_at' => now(),
                    ]);

                DB::table('timesheets')
                    ->where('id', $timesheet->timesheetid)
                    ->update([
                        'status' => 1,
                        'updated_at' => now(),
                    ]);
            }

            // Insert data into the timesheetreport table for the current week
            $startdate = Carbon::parse($weekData->first()->date);
            $nextSaturday = $startdate->copy()->next(Carbon::SATURDAY);

            $startdateformat = $startdate->format('Y-m-d');
            $nextSaturdayformat = $nextSaturday->format('Y-m-d');

            $week = date('d-m-Y', strtotime($startdateformat)) . ' to ' . date('d-m-Y', strtotime($nextSaturdayformat));

            $co = DB::table('timesheetusers')
                ->where('createdby', $id)
                ->whereBetween('date', [$startdateformat, $nextSaturdayformat])
                ->select('partner', DB::raw('SUM(hour) as total_hours'), DB::raw('COUNT(DISTINCT timesheetid) as row_count'))
                ->groupBy('partner')
                ->get();
            // dd($co);

            foreach ($co as $codata) {
                DB::table('timesheetreport')->insert([
                    'teamid'       =>     444,
                    'week'       =>     $week,
                    'totaldays'       =>     $codata->row_count,
                    'totaltime' =>  $codata->total_hours,
                    'partnerid'  => $codata->partner,
                    'startdate'  => $startdateformat,
                    'enddate'  => $nextSaturdayformat,
                    'created_at'                =>      date('y-m-d H:i:s'),
                ]);
            }
        }
    }
    //*

    public function confirmationauthotp(Request $request)
    {

        if ($request->ajax()) {
            if (isset($request->id)) {
                $authotp = DB::table('debtors')->where('id.id', $request->id)->first();
                // dd($authotp->mobile_no);
                $otpap = sprintf("%06d", mt_rand(1, 999999));

                $data = array(
                    'taskname' =>  $request->taskname,
                    'duedate' =>  $request->duedate,
                    'description' =>  $request->description,
                    'otpap' =>  $otpap,

                );

                Mail::send('emails.confirmationotp', $data, function ($msg) use ($data, $teammember) {
                    $msg->to($teammember);
                    $msg->subject('VSA Balance Confirmation OTP');
                });
                return response()->json($authotp);
            }
        }
    }


    public function otpapstore(Request $request)
    {
        $request->validate([
            'otp' => 'required'
        ]);

        try {
            $data = $request->except(['_token']);

            $otp = $request->otp;

            $otpm = DB::table('staffappointmentletters')->where('teammember_id', auth()->user()->teammember_id)->first();
            if ($otp == $otpm->otp) {

                DB::table('staffappointmentletters')->where('teammember_id', auth()->user()->teammember_id)->update([
                    'status' => '1',
                    'otpdate' => date('Y-m-d H:i:s')
                ]);
                $teammember = DB::table('teammembers')->where('id', auth()->user()->teammember_id)->first();


                $output = array('msg' => 'otp match successfully and verified');
                return back()->with('success', $output);
            } else {
                $output = array('msg' => 'otp did not match! Please enter valid otp');
                return back()->with('success', $output);
            }
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }


    // Start Hare 

    //         Route::get('sendRequestReminder', [TimesheetrequestController::class, 'sendRequestReminder']);
    //       Route::get('/timesheetrequest/reminder/list',  [TimesheetrequestController::class, 'timesheetrequest_list']);
    //     ConfirmationController routes
    // timesheetrequest_list
    public function timesheetrequest_list(Request $request)
    {

        $timesheetRequest = DB::table('timesheetrequests')
            ->where('id', $request->id)
            ->latest()
            ->first();

        $timesheetrequestreminderlist =  DB::table('timesheetrequestreminderlist')
            ->where('timesheetrequestid', $request->id)->get();

        return response()->json([
            'timesheetRequest' => $timesheetRequest,
            'timesheetrequestreminderlist' => $timesheetrequestreminderlist,
        ]);
    }
    public function sendRequestReminder(Request $request)
    {
        //	dd('hi');
        $timesheetRequest = DB::table('timesheetrequests')
            ->where('createdby', auth()->user()->teammember_id)
            // ->where('status', 0)
            ->orderBy('id', 'desc')
            ->first();
        //	dd($timesheetRequest);


        // dd($timesheetRequest);
        // Debugging: Print out the generated SQL query
        $query = DB::table('timesheetrequests')
            ->where('createdby', auth()->user()->teammember_id)
            //->where('status', 1)
            ->latest()
            ->toSql();
        //  dd($query);

        // Check if $timesheetRequest is not null
        if (date('Y-m-d') < $timesheetRequest->fivedaysdate) {

            if ($timesheetRequest->remindercount < 6) {

                if ($timesheetRequest->reminderdatecount != date('Y-m-d')) {
                    //   dd('hi');
                    if ($timesheetRequest->status == 0) {
                        //   dd('hi');
                        // If the timesheet request exists, get the partner column value
                        $partner = $timesheetRequest->partner;
                        //dd($partner);
                        $name = Teammember::where('id', auth()->user()->teammember_id)->pluck('team_member')->first();
                        $teammembermail = Teammember::where('id', $timesheetRequest->partner)->pluck('emailid')->first();
                        $client_name = Client::where('id', $timesheetRequest->client_id)->pluck('client_name')->first();
                        if ($timesheetRequest->status == 0) {
                            $data = array(
                                'teammember' => $name ?? '',
                                'email' => $teammembermail ?? '',
                                'id' => $timesheetRequest->id ?? '',
                                'client_id' => $client_name ?? '',
                                'reason'     =>     $timesheetRequest->reason ?? '',
                            );
                            // dd($data);

                            // Mail::send('emails.timesheetrequestreminder', $data, function ($msg) use ($data) {
                            //   $msg->to($data['email']);
                            //  $msg->cc('Vinitayadav@capitall.io');

                            //  // $msg->cc('hr@kgsomani.com');
                            //   $msg->subject('Timesheet Submission Reminder Request | '. $data['teammember']);
                            // });

                            $url = URL::to('/timesheetrequestlist') ?? '';
                            $title = "timesheetrequestreminder";
                            $template = $this->getTemplateData($title);
                            // dd($template);  
                            $to = ($data['email']);
                            $cc = ($template['cc']);
                            $this->sendTicketEmail($to, $cc, $title, $data, $url);
                        }
                        DB::table('timesheetrequests')->where('id', $timesheetRequest->id)->update([
                            'remindercount'  => $timesheetRequest->remindercount + 1,
                            'reminderdatecount'                =>       date('Y-m-d'),
                        ]);

                        DB::table('timesheetrequestreminderlist')->insert([
                            'timesheetrequestid'  => $timesheetRequest->id,
                            'remindercount'  => $timesheetRequest->remindercount + 1,
                            'reminderdatecount'                =>       date('Y-m-d'),
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);

                        // Send mail to the partner
                        // Your code to send the mail goes here
                        $output = array('msg' => 'Reminder Mail send Successfully');
                        return back()->with('success', $output);
                    } elseif ($timesheetRequest->status == '1' && $timesheetRequest->validate == null) {

                        //dd('final');
                        # code...
                        $partner = 157;
                        //dd($partner);
                        $name = Teammember::where('id', auth()->user()->teammember_id)->pluck('team_member')->first();
                        $teammembermail = Teammember::where('id', 157)->pluck('emailid')->first();
                        $client_name = Client::where('id', $timesheetRequest->client_id)->pluck('client_name')->first();

                        $data = array(
                            'teammember' => $name ?? '',
                            'email' => $teammembermail ?? '',
                            'id' => $timesheetRequest->id ?? '',
                            'client_id' => $client_name ?? '',
                            'reason'     =>     $timesheetRequest->reason ?? '',
                        );
                        // dd($data);

                        Mail::send('emails.timesheetrequestreminder', $data, function ($msg) use ($data) {
                            $msg->to($data['email']);
                            $msg->cc('Vinitayadav@capitall.io');

                            // $msg->cc('hr@kgsomani.com');
                            $msg->subject('Timesheet Submission Request | ' . $data['teammember']);
                        });
                        DB::table('timesheetrequests')->where('id', $timesheetRequest->id)->update([
                            'remindercount'  => $timesheetRequest->remindercount + 1,
                            'reminderdatecount'                =>       date('Y-m-d'),
                        ]);

                        DB::table('timesheetrequestreminderlist')->insert([
                            'timesheetrequestid'  => $timesheetRequest->id,
                            'remindercount'  => $timesheetRequest->remindercount + 1,
                            'reminderdatecount'                =>       date('Y-m-d'),
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
                        // Send mail to the Final partner
                        // Your code to send the mail goes here

                        $output = array('msg' => 'Final Reminder Mail send Successfully');
                        return back()->with('success', $output);
                    } else {
                        $output = array('msg' => 'No Data');
                        return back()->with('success', $output);
                    }
                } else {
                    $output = array('msg' => 'Already Mail send Successfully Today');
                    return back()->with('success', $output);
                }
            }
        }
    }


    //*
    // Start Hare 

    // public function mail(Request $request)
    // {
    //     try {
    //         $data = $request->except(['_token']);

    //         $debtor = DB::table('debtors')
    //             ->where('assignmentgenerate_id', $request->clientid)
    //             ->where('type', $request->type)
    //             ->where('mailstatus', 0)
    //             ->get();

    //         foreach ($debtor as $debtors) {
    //             if ($request->teammember_id) {
    //                 // cc mail
    //                 $teammembermail = Teammember::whereIn('id', $request->teammember_id)->pluck('emailid')->toArray();
    //             }

    //             $des = $request->description;
    //             $healthy = ["[name]", "[amount]", "[year]", "[date]", "[address]"];
    //             $yummy   = ["$debtors->name", "$debtors->amount", "$debtors->year", "$debtors->date", "$debtors->address"];
    //             $description = str_replace($healthy, $yummy, $des);

    //             $data = array(
    //                 'subject' => $request->subject,
    //                 'name' =>  $debtors->name,
    //                 'email' =>  $debtors->email,
    //                 'year' =>  $debtors->year,
    //                 'date' =>  $debtors->date,
    //                 'amount' =>  $debtors->amount,
    //                 'clientid' => $debtors->assignmentgenerate_id,
    //                 'debtorid' => $debtors->id,
    //                 'description' => $description,
    //                 'teammembermail' => $teammembermail ?? '',
    //                 'yes' => 1,
    //                 'no' => 0
    //             );

    //             Mail::send('emails.debtorform', $data, function ($msg) use ($data, $request) {
    //                 $msg->to($data['email']);
    //                 $msg->subject($data['subject']);

    //                 if ($request->teammember_id) {
    //                     $msg->cc($data['teammembermail']);
    //                 }
    //             });

    //             // If mail sent successfully, update mailstatus to 1
    //             DB::table('debtors')
    //                 ->where('assignmentgenerate_id', $debtors->assignmentgenerate_id)
    //                 ->where('id', $debtors->id)
    //                 ->update([
    //                     'mailstatus' => 1,
    //                     'updated_at' => now()
    //                 ]);
    //         }

    //         $output = array('msg' => 'Mail Sent Successfully');
    //         return back()->with('success', $output);
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
    //         report($e);

    //         // If mail sending fails, update mailstatus to 0
    //         foreach ($debtor as $debtors) {
    //             DB::table('debtors')
    //                 ->where('assignmentgenerate_id', $debtors->assignmentgenerate_id)
    //                 ->where('id', $debtors->id)
    //                 ->update([
    //                     'mailstatus' => 0,
    //                     'updated_at' => now()
    //                 ]);
    //         }

    //         $output = array('msg' => $e->getMessage());
    //         return back()->withErrors($output)->withInput();
    //     }
    // }

    // public function mail(Request $request)
    // {
    //     try {
    //         $data = $request->except(['_token']);

    //         $debtor = DB::table('debtors')
    //             ->where('assignmentgenerate_id', $request->clientid)
    //             ->where('type', $request->type)
    //             ->where('mailstatus', 0)
    //             ->get();

    //         foreach ($debtor as $debtors) {
    //             if ($request->teammember_id) {
    //                 // cc mail
    //                 $teammembermail = Teammember::whereIn('id', $request->teammember_id)->pluck('emailid')->toArray();
    //             }

    //             $des = $request->description;
    //             $healthy = ["[name]", "[amount]", "[year]", "[date]", "[address]"];
    //             $yummy   = ["$debtors->name", "$debtors->amount", "$debtors->year", "$debtors->date", "$debtors->address"];
    //             $description = str_replace($healthy, $yummy, $des);

    //             $data = array(
    //                 'subject' => $request->subject,
    //                 'name' =>  $debtors->name,
    //                 'email' =>  $debtors->email,
    //                 'year' =>  $debtors->year,
    //                 'date' =>  $debtors->date,
    //                 'amount' =>  $debtors->amount,
    //                 'clientid' => $debtors->assignmentgenerate_id,
    //                 'debtorid' => $debtors->id,
    //                 'description' => $description,
    //                 'teammembermail' => $teammembermail ?? '',
    //                 'yes' => 1,
    //                 'no' => 0
    //             );

    //             Mail::send('emails.debtorform', $data, function ($msg) use ($data, $request) {
    //                 $msg->to($data['email']);
    //                 $msg->subject($data['subject']);

    //                 if ($request->teammember_id) {
    //                     $msg->cc($data['teammembermail']);
    //                 }
    //             });

    //             // If mail sent successfully, update mailstatus to 1
    //             DB::table('debtors')
    //                 ->where('assignmentgenerate_id', $debtors->assignmentgenerate_id)
    //                 ->where('id', $debtors->id)
    //                 ->update([
    //                     'mailstatus' => 1,
    //                     'updated_at' => now()
    //                 ]);
    //         }

    //         $output = array('msg' => 'Mail Sent Successfully');
    //         return back()->with('success', $output);
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
    //         report($e);

    //         // If mail sending fails, update mailstatus to 2
    //         DB::table('debtors')
    //             ->where('assignmentgenerate_id', $debtors->assignmentgenerate_id)
    //             ->where('id', $debtors->id)
    //             ->update([
    //                 'mailstatus' => 2,
    //                 'updated_at' => now()
    //             ]);

    //         $output = array('msg' => $e->getMessage());
    //         return back()->withErrors($output)->withInput();
    //     }
    // }


    // public function pendingmail($id)
    // {
    //     // dd($id);
    //     try {
    //         $usermail = DB::table('debtors')->where('id', $id)->first();

    //         // Get mail for Debitor
    //         if ($usermail->type == 1) {
    //             // dd('debitor');
    //             $maildata = DB::table('templates')->where('type', $usermail->type)->first();

    //             $des = $maildata->description;
    //             $healthy = ["[name]", "[amount]", "[year]", "[date]", "[address]"];
    //             $yummy   = ["$usermail->name", "$usermail->amount", "$usermail->year", "$usermail->date", "$usermail->address"];
    //             $description = str_replace($healthy, $yummy, $des);


    //             $data = array(
    //                 'name' =>  $usermail->name,
    //                 'email' =>  $usermail->email,
    //                 'year' =>  $usermail->year,
    //                 'date' =>  $usermail->date,
    //                 'amount' =>  $usermail->amount,
    //                 'clientid' => $usermail->assignmentgenerate_id,
    //                 'debtorid' => $usermail->id,
    //                 'description' => $description,
    //                 'yes' => 1,
    //                 'no' => 0
    //             );
    //             Mail::send('emails.debtorform', $data, function ($msg) use ($data) {
    //                 $msg->to($data['email']);
    //                 $msg->subject('Regarding Pending Confirmation');
    //             });
    //         }
    //         // Get mail for creater
    //         elseif ($usermail->type == 2) {
    //             $maildata = DB::table('templates')->where('type', $usermail->type)->first();

    //             $des = $maildata->description;
    //             $healthy = ["[name]", "[amount]", "[year]", "[date]", "[address]"];
    //             $yummy   = ["$usermail->name", "$usermail->amount", "$usermail->year", "$usermail->date", "$usermail->address"];
    //             $description = str_replace($healthy, $yummy, $des);


    //             $data = array(
    //                 'name' =>  $usermail->name,
    //                 'email' =>  $usermail->email,
    //                 'year' =>  $usermail->year,
    //                 'date' =>  $usermail->date,
    //                 'amount' =>  $usermail->amount,
    //                 'clientid' => $usermail->assignmentgenerate_id,
    //                 'debtorid' => $usermail->id,
    //                 'description' => $description,
    //                 'yes' => 1,
    //                 'no' => 0
    //             );
    //             Mail::send('emails.debtorform', $data, function ($msg) use ($data) {
    //                 $msg->to($data['email']);
    //                 $msg->subject('Regarding Pending Confirmation');
    //             });
    //         }
    //         // Get mail for bank
    //         else {
    //             // dd('bank');
    //             $maildata = DB::table('templates')->where('type', $usermail->type)->first();
    //             // dd($maildata);
    //             $des = $maildata->description;
    //             $healthy = ["[name]", "[amount]", "[year]", "[date]", "[address]"];
    //             $yummy   = ["$usermail->name", "$usermail->amount", "$usermail->year", "$usermail->date", "$usermail->address"];
    //             $description = str_replace($healthy, $yummy, $des);


    //             $data = array(
    //                 'name' =>  $usermail->name,
    //                 'email' =>  $usermail->email,
    //                 'year' =>  $usermail->year,
    //                 'date' =>  $usermail->date,
    //                 'amount' =>  $usermail->amount,
    //                 'clientid' => $usermail->assignmentgenerate_id,
    //                 'debtorid' => $usermail->id,
    //                 'description' => $description,
    //                 'yes' => 1,
    //                 'no' => 0
    //             );
    //             Mail::send('emails.debtorform', $data, function ($msg) use ($data) {
    //                 $msg->to($data['email']);
    //                 $msg->subject('Regarding Pending Confirmation');
    //             });
    //         }
    //         dd('hi4');
    //         $output = array('msg' => 'Mail Send Successfully');
    //         return back()->with('success', $output);
    //     } catch (Exception $e) {
    //         DB::rollBack();
    //         Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
    //         report($e);
    //         $output = array('msg' => $e->getMessage());
    //         return back()->withErrors($output)->withInput();
    //     }
    // }

    public function mail(Request $request)
    {
        // dd($request);
        //    if($request->description){
        //     $print =DB::table('templates')->where('description', 'LIKE', '%' . '$name' . '%' )->first();
        //     dd('hi');
        //    }
        //    dd($request);
        // $request->validate([
        //     'file' => 'required'
        // ]);

        try {
            $data = $request->except(['_token']);

            $debtor = DB::table('debtors')->where('assignmentgenerate_id', $request->clientid)->where('type', $request->type)->where('mailstatus', 0)->get();
            //  dd($debtor);

            if ($debtor[0]->mailstatus == 0) {
                $updateit = DB::table('debtors')
                    ->where('assignmentgenerate_id', $request->clientid)->where('type', $request->type)
                    ->update([
                        'mailstatus'         => 2,
                        'updated_at'         =>   date("Y-m-d H:i:s")
                    ]);
            }
            foreach ($debtor as $debtors) {
                if ($request->teammember_id) {
                    // cc mail
                    $teammembermail = Teammember::wherein('id', $request->teammember_id)->pluck('emailid')->toArray();
                }
                // $description = str_replace('$name', $debtors->name, $request->description); 
                //  $description = str_replace('44247', $debtors->amount, $request->description);
                $des = $request->description;
                $healthy = ["[name]", "[amount]", "[year]", "[date]", "[address]"];
                $yummy   = ["$debtors->name", "$debtors->amount", "$debtors->year", "$debtors->date", "$debtors->address"];
                $description = str_replace($healthy, $yummy, $des);

                $data = array(
                    'subject' => $request->subject,
                    //       'fromemail' =>  $request->fromemail,
                    'name' =>  $debtors->name,
                    'email' =>  $debtors->email,
                    'year' =>  $debtors->year,
                    'date' =>  $debtors->date,
                    'amount' =>  $debtors->amount,
                    'clientid' => $debtors->assignmentgenerate_id,
                    'debtorid' => $debtors->id,
                    'description' => $description,
                    'teammembermail' => $teammembermail ?? '',
                    'yes' => 1,
                    'no' => 0
                );


                Mail::send('emails.debtorform', $data, function ($msg) use ($data, $request) {
                    $msg->to($data['email']);
                    //  $msg->from('arihant@kgsomani.com', 'Kgskonnect');
                    // $msg->cc($teammembermail);
                    $msg->subject($data['subject']);

                    if ($request->teammember_id) {
                        $msg->cc($data['teammembermail']);
                    }
                });

                DB::table('debtors')
                    ->where('assignmentgenerate_id', $debtors->assignmentgenerate_id)->where('id', $debtors->id)->update([
                        'mailstatus'         => 1,
                        'updated_at'         =>   date("Y-m-d H:i:s")
                    ]);
            }
            $output = array('msg' => 'Mail Send Successfully');
            return back()->with('success', $output);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }


    public function pendingmail($id)
    {
        // dd($id);
        try {
            $usermail = DB::table('debtors')->where('id', $id)->select('email')->first();
            // dd($usermail->email);
            $data = array(
                'email' => $usermail->email ?? '',
            );
            Mail::send('emails.testingmail', $data, function ($msg) use ($data) {
                $msg->to($data['email']);
                $msg->subject('Subject goes to hare');
            });
            $output = array('msg' => 'Mail Send Successfully');
            return back()->with('success', $output);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }
}

