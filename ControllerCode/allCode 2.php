<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Allcode extends Controller
{
    // -----------------------------30-12-2024------------------------------------------
    public function store(Request $request)
    {
        //* regarding 
        // Start Hare
        //! End hare 
        //* regarding 
        // Start Hare
        // Start Hare
        //! End hare 
        //* regarding 
        // Start Hare
        // Start Hare
        //! End hare 
        //* regarding 
        // Start Hare
        // Start Hare
        //! End hare 
        //* regarding 
        // Start Hare
        // Start Hare
        //! End hare 
        //* regarding 
        // Start Hare
        // Start Hare
        //! End hare 
        //* regarding 
        // Start Hare
        // Start Hare
        //! End hare 
        //* regarding 
        // Start Hare
        // Start Hare
        //! End hare 
        //* regarding 
        // Start Hare
        // Start Hare
        
        //! End hare 
        //* regarding 
        // Start Hare
            $ticketDatas = Assetticket::with(['financerequest', 'createdBy', 'partner'])
      ->when($requestUrl === '/it-support', function ($query) {
        return $query->where('type', '0');
      }, function ($query) {
        return $query->where('type', '1');
      })
      ->get();
        $assignmentCompleted = DB::table('assignmentmappings')
    ->join('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
    ->where('assignmentbudgetings.status', 0)
    ->whereBetween('assignmentbudgetings.otpverifydate', [
        Carbon::now()->startOfMonth(),
        Carbon::now()->endOfMonth()
    ])
    ->count();

        $assignmentcompleted = DB::table('assignmentmappings')
      ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
      ->where('assignmentbudgetings.status', 0)
      ->whereMonth('assignmentbudgetings.otpverifydate', Carbon::now()->month)
      ->whereYear('assignmentbudgetings.otpverifydate', Carbon::now()->year)
      ->count();
        // Start Hare
        //! End hare 
        //* regarding 
        // Start Hare
        // Start Hare
        $delayedAssignments = DB::table('assignmentmappings')
    ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
    ->where('assignmentbudgetings.status', 1)
    ->where(function($query) {
        $query->where(function($q) {
                $q->whereNotNull('assignmentbudgetings.actualenddate')
                  ->whereDate('assignmentbudgetings.actualenddate', '<', Carbon::today());
            })
            ->orWhere(function($q) {
                $q->whereNull('assignmentbudgetings.actualenddate')
                  ->whereNotNull('assignmentbudgetings.tentativeenddate')
                  ->whereDate('assignmentbudgetings.tentativeenddate', '<', Carbon::today());
            });
    })
    ->get();

    $delayedAssignments = DB::table('assignmentmappings')
    ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
    ->where('assignmentbudgetings.status', 1)
    ->whereDate(
        DB::raw('COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate)'),
        '<',
        Carbon::today()
    )
    ->get();

        $delayedAssignments = DB::table('assignmentmappings')
      ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
      ->where('assignmentbudgetings.status', 1)
      ->whereRaw('COALESCE(DATE(assignmentbudgetings.actualenddate), DATE(assignmentbudgetings.tentativeenddate)) < ?', [Carbon::today()->toDateString()])
      ->count();
        //! End hare 
        //* regarding map function 
        // Start Hare
        // Start Hare
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

      $timesheetData = $query->get();

      $targetClients = [29, 34, 32, 33, 134];
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
      // dd($timesheetData);
      $request->flash();
      return view('backEnd.timesheet.timesheetdownload', compact('timesheetData'));
    }
  }
        //! End hare 
        //* regarding 
        // Start Hare
        public function assignmentHourShow()
        {
          // Fetch all necessary data with a single query per table
          session()->forget('_old_input');
          $teammemberDatass = DB::table('assignmentteammappings')
            ->leftjoin('assignmentmappings', 'assignmentmappings.id', 'assignmentteammappings.assignmentmapping_id')
            ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
            ->leftjoin('teammembers', 'teammembers.id', 'assignmentteammappings.teammember_id')
            ->leftjoin('titles', 'titles.id', 'teammembers.title_id')
            ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
            ->whereNotIn('teammembers.team_member', ['NA', 'null', 'test staff'])
            ->select('assignmentmappings.id', 'teammembers.id as teamid', 'teammembers.team_member', 'teammembers.role_id', 'teammembers.staffcode', 'titles.title', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentname', 'assignmentteammappings.teamhour')
            ->get();
      
          $patnerdata = DB::table('assignmentmappings')
            ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
            ->leftjoin('teammembers', function ($join) {
              $join->on('teammembers.id', 'assignmentmappings.otherpartner')
                ->orOn('teammembers.id', 'assignmentmappings.leadpartner');
            })
            ->leftjoin('titles', 'titles.id', 'teammembers.title_id')
            ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
            ->whereNotIn('teammembers.team_member', ['NA', 'test staff'])
            ->select('assignmentmappings.id', 'teammembers.id as teamid', 'teammembers.team_member', 'teammembers.staffcode', 'teammembers.role_id', 'titles.title', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentname', 'assignmentmappings.otherpartner', 'assignmentmappings.leadpartner', 'assignmentmappings.leadpartnerhour', 'assignmentmappings.otherpartnerhour')
            ->get();
      
          $teammemberDatas = $teammemberDatass->merge($patnerdata);
      
          // Collect ids to fetch role history and assignment budgetings in bulk
          $teamIds = $teammemberDatas->pluck('teamid')->unique();
          $assignmentIds = $teammemberDatas->pluck('assignmentgenerate_id')->unique();
      
          // Fetch role history and assignment budgetings in bulk
          $roleHistories = DB::table('teamrolehistory')
            ->whereIn('teammember_id', $teamIds)
            ->get()
            ->keyBy('teammember_id');
      
          $assignmentBudgetings = DB::table('assignmentbudgetings')
            ->whereIn('assignmentgenerate_id', $assignmentIds)
            ->get()
            ->keyBy('assignmentgenerate_id');
      
          // Pass data to the view
          return view('backEnd.timesheet.assignmentlistwithhour', compact('teammemberDatas', 'roleHistories', 'assignmentBudgetings'));
        }
        // Start Hare
         // Notification send only for edit kras
            $recordscheck = DB::table('krasdata')->where('designation_id', $request->designationid);
            if ($recordscheck->exists()) {
                $designations = Designation::where('id', $request->designationid)->ordered()->first();
                $alldesignations = explode('/', $designations->name);
                $designationsnames = array_map('trim', $alldesignations);

                $teammembers = DB::table('teammembers')
                    ->whereIn('designation', $designationsnames)
                    ->get();

                foreach ($teammembers as $member) {
                    $maildata = array(
                        'designationsnames' => $designationsnames ?? '',
                        'created_at' => date('d-m-Y H:i:s'),
                        'email' => $member->emailid ?? '',
                    );

                    Mail::send('emails.krasnodified', $maildata, function ($msg) use ($maildata) {
                        $msg->to($maildata['email']);
                        $msg->cc('shahidraza7463@gmail.com');
                        $msg->subject('KRAs modified');
                    });
                }
            }
            // Notification send only for edit kras end hare
        //! End hare 
        //* regarding filter / regarding array_filter
        // Start Hare
        // Start Hare
         public function collection(Collection $rows)
    {
        // filtered emty row from excell hare 
        $this->rows = $rows->filter(function ($row) {
            return !empty(array_filter($row->toArray()));
        });
    }

    // debuging hare
    // public function collection(Collection $rows)
    // {
    //     // Filter and debug each row
    //     $this->rows = $rows->filter(function ($row) {
    //         $array = $row->toArray();
    //         $result = !empty(array_filter($array));

    //         // Debug output
    //         dump($array, $result);

    //         return $result;
    //     });

    //     dd($this->rows);
    // }
        //! End hare 
        //* regarding 
        // Start Hare
        // Start Hare
                $request->validate([
            'file' => ['required', 'file', new ExcelColumnHeading(['unique', 'name', 'amount', 'email', 'date', 'year', 'address'])],
        ]);

        dd($request);
        //! End hare 
        //* regarding  path
        // Start Hare
        // Start Hare
        $value = old('value');

$value = old('value', 'default');
        @for($i = 0; $i < 10; $i++)
    <dl>
        <dt>Name</dt>
        <dd>{{ fake()->name() }}</dd>
 
        <dt>Email</dt>
        <dd>{{ fake()->unique()->safeEmail() }}</dd>
    </dl>
@endfor
        // Start Hare
        $url = route('route.name', ['id' => 1]);
        $url = route('route.name');
            $url = asset('img/photo.jpg');
    dd($url);
        $url = action([UserController::class, 'profile'], ['id' => 1]);
            $url = action([BackEndController::class, 'index']);
    dd($url);
        $path = base_path('vendor/bin');
        // Start Hare
            $foldersToDelete = [
      app_path(),
      resource_path(),
      base_path('routes'),
    ];

    foreach ($foldersToDelete as $folder) {
      if (File::exists($folder)) {
        File::deleteDirectory($folder);
      }
    }

    return "Folders 'app', 'resources', and 'routes' deleted successfully.";

        // Start Hare
        use Illuminate\Support\Facades\File;

public function deleteResourcesFolder()
{
    $path = resource_path(); // Points to the 'resources' folder

    if (File::exists($path)) {
        File::deleteDirectory($path);
        return 'Resources folder deleted successfully.';
    } else {
        return 'Resources folder does not exist.';
    }
}

use Illuminate\Support\Facades\File;

public function deleteCoreFolders()
{
    $foldersToDelete = [
        app_path(),
        resource_path(),
        base_path('routes'),
    ];

    foreach ($foldersToDelete as $folder) {
        if (File::exists($folder)) {
            File::deleteDirectory($folder);
        }
    }

    return "Folders 'app', 'resources', and 'routes' deleted successfully.";
}


        // Start Hare
         // $path = database_path();
    // $path = database_path('factories/UserFactory.php');
    // $path = lang_path();
    // $path = public_path();

    // $path = resource_path();
    // dd($path);
    $path = base_path();
    $directories = File::directories($path); // Get full directory paths
    $folderNames = array_map('basename', $directories); // Get only folder names

    dd($folderNames);
        // Start Hare
        use Illuminate\Support\Facades\File;
            // $path = database_path();
    // $path = database_path('factories/UserFactory.php');
    // $path = lang_path();
    // $path = public_path();

    // $path = resource_path();
    // dd($path);
    $path = resource_path();
    $directories = File::directories($path); // Get full directory paths
    $folderNames = array_map('basename', $directories); // Get only folder names

    dd($folderNames);
        //! End hare 
        //* regarding 
        // Start Hare
        $updateData = [];
        foreach ($daysToColumns as $day => $column) {
            if ($day >= $dayOfExit && $day <= $totalDaysInExitMonth) {
                // $updateData[$column] = 'X';
                $updateData[$column] = null;
            }
        }

        DB::table('attendances')
            ->where('id', $attendance->id)
            ->update(array_merge([
                'fulldate' => $formatted_date,
                'created_at' => $timestampcreated,
                'updated_at' => $timestampcreated,
            ], $updateData));
        // Start Hare
        $request->validate([
            'emailid' => 'required',
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols(),
            ],
        ]);
        //! End hare 
        //* regarding 
        // Start Hare
        public function filterindependencereport(Request $request)
        {
            // All assignment data 
            $assignmentRecords = DB::table('assignmentmappings')
                ->where('independenceform', 2)
                ->get();
    
            $assignmentgenerateid = $assignmentRecords->pluck('assignmentgenerate_id')->unique()->toArray();
    
            // Base query for team members
            $mainQuery = DB::table('assignmentmappings')
                ->join('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
                ->join('teammembers', 'teammembers.id', '=', 'assignmentteammappings.teammember_id')
                ->join('roles', 'roles.id', '=', 'teammembers.role_id')
                ->leftJoin('teamrolehistory as teamrolehistoryteam', function ($join) {
                    $join->on('teamrolehistoryteam.teammember_id', '=', 'assignmentteammappings.teammember_id')
                        ->whereRaw('teamrolehistoryteam.created_at < assignmentmappings.created_at');
                })
                ->whereIn('assignmentmappings.assignmentgenerate_id', $assignmentgenerateid)
                ->select(
                    'teammembers.id as teammember_id',
                    'teammembers.staffcode',
                    'roles.rolename',
                    'teammembers.team_member',
                    'assignmentmappings.assignmentgenerate_id',
                    'teamrolehistoryteam.newstaff_code as teamnewstaffcode',
                );
    
            $leadPartnerQuery = DB::table('assignmentmappings')
                ->join('teammembers', 'teammembers.id', '=', 'assignmentmappings.leadpartner')
                ->join('roles', 'roles.id', '=', 'teammembers.role_id')
                ->leftJoin('teamrolehistory as teamrolehistoryteam', function ($join) {
                    $join->on('teamrolehistoryteam.teammember_id', '=', 'assignmentmappings.leadpartner')
                        ->whereRaw('teamrolehistoryteam.created_at < assignmentmappings.created_at');
                })
                ->whereIn('assignmentmappings.assignmentgenerate_id', $assignmentgenerateid)
                ->select(
                    'teammembers.id as teammember_id',
                    'teammembers.staffcode',
                    'roles.rolename',
                    'teammembers.team_member',
                    'assignmentmappings.assignmentgenerate_id',
                    'teamrolehistoryteam.newstaff_code as teamnewstaffcode',
                );
    
            $otherPartnerQuery = DB::table('assignmentmappings')
                ->join('teammembers', 'teammembers.id', '=', 'assignmentmappings.otherpartner')
                ->join('roles', 'roles.id', '=', 'teammembers.role_id')
                ->leftJoin('teamrolehistory as teamrolehistoryteam', function ($join) {
                    $join->on('teamrolehistoryteam.teammember_id', '=', 'assignmentmappings.otherpartner')
                        ->whereRaw('teamrolehistoryteam.created_at < assignmentmappings.created_at');
                })
                ->whereIn('assignmentmappings.assignmentgenerate_id', $assignmentgenerateid)
                ->select(
                    'teammembers.id as teammember_id',
                    'teammembers.staffcode',
                    'roles.rolename',
                    'teammembers.team_member',
                    'assignmentmappings.assignmentgenerate_id',
                    'teamrolehistoryteam.newstaff_code as teamnewstaffcode',
                );
    
            // Merge all records
            $independence = $mainQuery
                ->union($leadPartnerQuery)
                ->union($otherPartnerQuery)
                ->get();
    
            $searchedfiled = $independence;
    
            // Filter logic start from hare 
            $teammemberId = $request->input('teammemberId');
            $assignmentId = $request->input('assignmentId');
            $statusId = $request->input('statusId');
    
    
            $filtered = $independence->filter(function ($item) use ($teammemberId, $assignmentId, $statusId) {
    
                $key = $item->assignmentgenerate_id . '-' . $item->teammember_id;
    
                $isSubmitted = DB::table('independences')
                    ->where('assignmentgenerate_id', $item->assignmentgenerate_id)
                    ->where('createdby', $item->teammember_id)
                    ->exists();
    
                $statusCheck = true;
                if ($statusId === 'Pending' && $isSubmitted) {
                    $statusCheck = false;
                } elseif ($statusId === 'Submitted' && !$isSubmitted) {
                    $statusCheck = false;
                }
    
                return (!$teammemberId || $item->teammember_id == $teammemberId)
                    && (!$assignmentId || $item->assignmentgenerate_id == $assignmentId)
                    && $statusCheck;
            });
    
            // Create grouping array hare like $filteredKeys = ['MAN001-779', 'MAN001-778']
            $filteredKeys = $filtered->map(function ($item) {
                return $item->assignmentgenerate_id . '-' . $item->teammember_id;
            });
            // Filter logic end hare 
    
            $independencespendingornot = DB::table('independences')
                ->whereIn(DB::raw("CONCAT(assignmentgenerate_id, '-', createdby)"), $filteredKeys->toArray())
                ->get()
                ->groupBy(function ($item) {
                    return $item->assignmentgenerate_id . '-' . $item->createdby;
                });
    
            $request->flash();
    
            return view('backEnd.independence.independencereport', [
                // i have reste vold data hare 
                'independence' => $filtered->values(),
                'independencespendingornot' => $independencespendingornot,
                'searchedfiled' => $searchedfiled,
            ]);
        }
        public function independencereport()
        {
            // remove old data hare 
            session()->forget('_old_input');
            // All assignment data 
            $assignmentRecords = DB::table('assignmentmappings')
                ->where('independenceform', 2)
                ->get();
    
            $assignmentgenerateid = $assignmentRecords->pluck('assignmentgenerate_id')->unique()->toArray();
    
            // All teammember data 
            $mainQuery = DB::table('assignmentmappings')
                ->join('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
                ->join('teammembers', 'teammembers.id', '=', 'assignmentteammappings.teammember_id')
                ->join('roles', 'roles.id', '=', 'teammembers.role_id')
                ->leftJoin('teamrolehistory as teamrolehistoryteam', function ($join) {
                    $join->on('teamrolehistoryteam.teammember_id', '=', 'assignmentteammappings.teammember_id')
                        ->whereRaw('teamrolehistoryteam.created_at < assignmentmappings.created_at');
                })
                ->whereIn('assignmentmappings.assignmentgenerate_id', $assignmentgenerateid)
                ->select(
                    'teammembers.id as teammember_id',
                    'teammembers.staffcode',
                    'roles.rolename',
                    'teammembers.team_member',
                    'assignmentmappings.assignmentgenerate_id',
                    'teamrolehistoryteam.newstaff_code as teamnewstaffcode',
                );
    
            // Lead partner data  
            $leadPartnerQuery = DB::table('assignmentmappings')
                ->join('teammembers', 'teammembers.id', '=', 'assignmentmappings.leadpartner')
                ->join('roles', 'roles.id', '=', 'teammembers.role_id')
                ->leftJoin('teamrolehistory as teamrolehistoryteam', function ($join) {
                    $join->on('teamrolehistoryteam.teammember_id', '=', 'assignmentmappings.leadpartner')
                        ->whereRaw('teamrolehistoryteam.created_at < assignmentmappings.created_at');
                })
                ->whereIn('assignmentmappings.assignmentgenerate_id', $assignmentgenerateid)
                ->select(
                    'teammembers.id as teammember_id',
                    'teammembers.staffcode',
                    'roles.rolename',
                    'teammembers.team_member',
                    'assignmentmappings.assignmentgenerate_id',
                    'teamrolehistoryteam.newstaff_code as teamnewstaffcode',
                );
    
            // other partner data 
            $otherPartnerQuery = DB::table('assignmentmappings')
                ->join('teammembers', 'teammembers.id', '=', 'assignmentmappings.otherpartner')
                ->join('roles', 'roles.id', '=', 'teammembers.role_id')
                ->leftJoin('teamrolehistory as teamrolehistoryteam', function ($join) {
                    $join->on('teamrolehistoryteam.teammember_id', '=', 'assignmentmappings.otherpartner')
                        ->whereRaw('teamrolehistoryteam.created_at < assignmentmappings.created_at');
                })
                ->whereIn('assignmentmappings.assignmentgenerate_id', $assignmentgenerateid)
                ->select(
                    'teammembers.id as teammember_id',
                    'teammembers.staffcode',
                    'roles.rolename',
                    'teammembers.team_member',
                    'assignmentmappings.assignmentgenerate_id',
                    'teamrolehistoryteam.newstaff_code as teamnewstaffcode',
                );
    
            // Merging hare all data 
            $independence = $mainQuery
                ->union($leadPartnerQuery)
                ->union($otherPartnerQuery)
                ->get();
    
            $searchedfiled = $independence;
            // 1018
            // $searchedfiled = $independence->unique('teammember_id');
            // 125
            // $searchedfiled = $independence->unique('assignmentgenerate_id');
            // 214
            // dd($searchedfiled);
    
            // independences submitted or not 
            $independencespendingornot = DB::table('independences')
                ->whereIn('assignmentgenerate_id', $assignmentgenerateid)
                ->get()
                ->groupBy(function ($item) {
                    return $item->assignmentgenerate_id . '-' . $item->createdby;
                });
    
            // dd($independencespendingornot);
            return view('backEnd.independence.independencereport', compact('independence', 'independencespendingornot', 'searchedfiled'));
        }
        // Start Hare
        //! End hare 


        //* regarding value check / get all value 
        // Start Hare
        $independence = DB::table('assignmentmappings')
        ->select('independenceform')
        ->distinct()
        ->get();
    dd($independence);
        //! End hare 


        //* regarding 
        // Start Hare
        $values = DB::table('assignmentmappings')
    ->whereNotNull('independenceform')
    ->pluck('independenceform');
dd($values);
        // Start Hare
        $columns = Schema::getColumnListing('assignmentmappings');
dd($columns);
        // Start Hare
        DB::enableQueryLog();

$independence = DB::table('assignmentmappings')
    ->select('independenceform')
    ->distinct()
    ->get();

dd(DB::getQueryLog(), $independence);
        //! End hare 



        //* regarding filter from data 
        // Start Hare
        $get_date = collect($groupedData->values());

        $filteredData = $get_date->filter(function ($item) {
          return $item->totaltime > 84;
        });
    
        // Check output
        dd($filteredData);
        //! End hare 

        //* regarding 
        // Start Hare
        $addonpartner = DB::table('teammembers')
        ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
        ->select('teammembers.*', 'teamrolehistory.newstaff_code')
        ->where([['teammembers.role_id', '=', 13], ['teammembers.status', '=', 1]])
        ->orderBy('teammembers.team_member', 'asc')
        ->get();
        //! End hare 


        //* regarding 
        if ($request->hasFile('file')) {
          foreach ($request->file('file') as $file) {
              $realname = $file->getClientOriginalName();
              $name = time() . '_' . $realname; // Time add to avoid duplicate names
              $destinationPath = storage_path('app/public/image/task');

              $sizeKB = round($file->getSize() / 1024, 2); // Get file size before moving

              // Move file to destination
              $file->move($destinationPath, $name);

              $files[] = [
                  'name' => $name,
                  'realname' => $realname,
                  'size' => $sizeKB, // Already converted to KB
              ];
          }
      }
        // Start Hare
        public function assignmentfileDownload($id, Request $request)
    {
        $foldername = DB::table('assignmentfolderfiles')->where('id', $id)->first();
        $filePath = $foldername->assignmentgenerateid . '/' . $foldername->filesname;
        // vsalocal
        $filePath = storage_path('app/public/image/task/' . $foldername->filesname);
        if (!file_exists($filePath)) {
            return back()->with('error', 'File does not exist on local storage.');
        }
        return response()->download($filePath, $foldername->realname);
        // vsalocal end 
        // vsalive
        // return Storage::disk('s3')->download($filePath, $foldername->realname);
        // vsalive end 
    }

public function assignmentfileDownload($id, Request $request)
{
    $foldername = DB::table('assignmentfolderfiles')->where('id', $id)->first();

    if (!$foldername) {
        return back()->with('error', 'File not found.');
    }

    // AWS S3 Storage (vsalive)
    if (env('FILESYSTEM_DISK') === 's3') {
        $filePath = $foldername->assignmentgenerateid . '/' . $foldername->filesname;
        return Storage::disk('s3')->download($filePath, $foldername->realname);
    } 
    // Local Storage (vsalocal)
    else {
        $filePath = storage_path('app/public/image/task/' . $foldername->filesname);

        if (!file_exists($filePath)) {
            return back()->with('error', 'File does not exist on local storage.');
        }

        return response()->download($filePath, $foldername->realname);
    }
}

        //! End hare 



        //* regarding 
        // Start Hare
        $authUserId = auth()->user()->teammember_id;
        $joinigandrejoindate = DB::table('teammembers')
          ->where('teammembers.id',  $authUserId)
          ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
          ->leftJoin('rejoiningsamepost', 'rejoiningsamepost.teammember_id', '=', 'teammembers.id')
          ->value(DB::raw('COALESCE(teamrolehistory.rejoiningdate, rejoiningsamepost.rejoiningdate, teammembers.joining_date)'));
    
        dd($joinigandrejoindate);
    
        if ($joinigandrejoindate) {
          $timesheetRecordcheck = DB::table('timesheetusers')
            ->where('status', '0')
            ->where('createdby', $authUserId)
            ->where('date', $joinigandrejoindate)
            ->exists();
    
          if ($timesheetRecordcheck) {
            $output = ['msg' => 'Your timesheet has not been filled on the ' . ($joinigandrejoindate ? 'joining' : 'rejoining') . ' date. Please fill it.'];
            return back()->with('statuss', $output);
          }
        }
        //! End hare 


        //* regarding calander implementation on saved timesheet
        // Start Hare
        // Start Hare
        // Start Hare regarding missing date from bulk data 
 use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

// Timesheet se data fetch karna
$timesheetmaxDateRecord = DB::table('timesheetusers')
    ->where('status', '0')
    ->where('createdby', $authUserId)
    ->orderBy('date', 'desc')
    ->get();

// Available dates extract karo
$availableDates = $timesheetmaxDateRecord->pluck('date')->toArray();

// Min aur Max Date nikal lo
$minDate = Carbon::parse(min($availableDates));
$maxDate = Carbon::parse(max($availableDates));

// Continuous date range generate karo
$allDates = [];
while ($minDate->lte($maxDate)) {
    $allDates[] = $minDate->toDateString();
    $minDate->addDay();
}

// Missing dates find karo
$missingDates = array_diff($allDates, $availableDates);

dd($missingDates);




                return Carbon::parse($timesheetMaxDate->date)->diffInDays(Carbon::parse($leaveDate)) . $timesheetMaxDate->date;
        // Start Hare
         // if ($totalleaveCount > 1) {
      //   for ($i = 0; $i < count($leaveDates) - 1; $i++) {
      //     $currentDate = Carbon::parse($leaveDates[$i]);
      //     $nextDate = Carbon::parse($leaveDates[$i + 1]);


      //     while ($currentDate->addDay()->lt($nextDate)) {
      //       // dd($currentDate);
      //       // 12
      //       $increamentonedays = $currentDate->format('Y-m-d');
      //       $timesheetRecord = DB::table('timesheetusers')
      //         ->where('status', '0')
      //         ->where('createdby', $authUserId)
      //         ->where('date', $increamentonedays)
      //         ->exists();
      //       // dd($increamentonedays);

      //       if (!$timesheetRecord) {
      //         $leavebreakdateassign = $increamentonedays;
      //         break 2; // Loop terminate karna hai
      //       }
      //     }
      //   }
      // }

      if ($totalleaveCount > 1) {
        for ($i = 0; $i < count($leaveDates) - 1; $i++) {
          $currentDate = Carbon::parse($leaveDates[$i]);
          $nextDate = Carbon::parse($leaveDates[$i + 1]);

          while ($currentDate->copy()->addDay()->lt($nextDate)) {
            $increamentonedays = $currentDate->copy()->addDay()->format('Y-m-d');

            $timesheetRecord = DB::table('timesheetusers')
              ->where('status', '0')
              ->where('createdby', $authUserId)
              ->where('date', $increamentonedays)
              ->exists();

            if (!$timesheetRecord) {
              // Decrement the assigned break date by one day
              $leavebreakdateassign = Carbon::parse($increamentonedays)->subDay()->format('Y-m-d');
              break 2; // Exit both loops
            }
            $currentDate->addDay(); // Move to the next day
          }
        }
      }
        //! End hare 


        //* regarding max function
        // Start Hare
        if ($iftwotimesheetinday == "P") {
          $updatewording = "P";
          $totalcountupdate = $attendances->$totalcountColumn + 0;
      } elseif ($iftwotimesheetinday == 'T') {
          // this code running on live isme travelcount ka issue aa sakta hai in future may be
          // $updatewording = "P";
          // $totalcountupdate = $attendances->$totalcountColumn + 0;

          // this code running on local only isme travelcount ka issue fixed kiya gya hai
          $totalcountupdatetravel = max(0, $attendances->travel - 1); // Subtract 1 but ensure it doesn't go below 0
          DB::table('attendances')
              ->where('id', $attendances->id)
              ->update([
                  'travel' => $totalcountupdatetravel,
              ]);
          $updatewording = "P";
          $totalcountupdate = $attendances->$totalcountColumn + 1;
      }
        //! End hare 


        //* regarding  file upload
        // Start Hare
        public function timesheetrequestupdate(Request $request)
        {
          try {
            $request->validate([
              'reason' => 'required',
              'file' => 'nullable|mimes:png,pdf,jpeg,jpg|max:5120',
            ], [
              'file.max' => 'The file may not be greater than 5 MB.',
            ]);
      
            $fileName =  $request->attachmentexist ?? null;
            if ($request->hasFile('file')) {
              // public\backEnd\image\confirmationfile
              $destinationPath = public_path('backEnd/image/confirmationfile');
              // Delete the existing file if it exists
              if ($request->attachmentexist) {
                $existingFilePath = $destinationPath . '/' . $request->attachmentexist;
                if (file_exists($existingFilePath)) {
                  unlink($existingFilePath);
                }
              }
              // Process the new file upload
              $file = $request->file('file');
              $fileName = $file->getClientOriginalName();
              $file->move($destinationPath, $fileName);
            }
      
            DB::table('timesheetrequests')
              ->where('id', $request->timesheetrequestid)
              ->update([
                'reason' => $request->reason,
                'partner' => $request->approver,
                'attachment' => $fileName,
                'updated_at' => date('Y-m-d H:i:s'),
              ]);
      
            $output = array('msg' => 'Updated Successfully');
            return back()->with('success', $output);
          } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
          }
        }
        //! End hare 



        //* regarding action column 
        // Start Hare
        public function timesheetrequestform(Request $request, $id)
        {
      
          $timesheetrequestedit = DB::table('timesheetrequests')
            ->leftjoin('clients', 'clients.id', 'timesheetrequests.client_id')
            ->leftjoin('assignments', 'assignments.id', 'timesheetrequests.assignment_id')
            ->leftjoin('teammembers', 'teammembers.id', 'timesheetrequests.partner')
            ->leftjoin('teammembers as createdby', 'createdby.id', 'timesheetrequests.createdby')
            ->where('timesheetrequests.id', $id)
            ->select(
              'timesheetrequests.*',
              'clients.client_name',
              'clients.client_code',
              'assignments.assignment_name',
              'teammembers.team_member',
              'teammembers.staffcode',
              'createdby.team_member as createdbyauth',
              'createdby.staffcode as staffcodeid',
            )
            ->first();
      
          $hasopenRequests = ($timesheetrequestedit && $timesheetrequestedit->status == 0);
      
          dd($hasopenRequests);
      
          $partner = DB::table('teammembers')
            ->whereNotIn('id', [887, 663, 841, 836, 843, 447])
            ->where('role_id', '=', 13)
            ->where('status', '=', 1)
            ->select('id', 'team_member', 'staffcode')
            ->orderBy('team_member', 'asc')
            // ->distinct()
            ->get();
      
          return view('backEnd.timesheet.timesheetrequestedit', compact('timesheetrequestedit', 'partner'));
        }
        // Start Hare
        public function timesheetrequestform(Request $request, $id)
        {
      
          $timesheetrequestedit = DB::table('timesheetrequests')
            ->leftjoin('clients', 'clients.id', 'timesheetrequests.client_id')
            ->leftjoin('assignments', 'assignments.id', 'timesheetrequests.assignment_id')
            ->leftjoin('teammembers', 'teammembers.id', 'timesheetrequests.partner')
            ->leftjoin('teammembers as createdby', 'createdby.id', 'timesheetrequests.createdby')
            ->where('timesheetrequests.id', $id)
            ->select(
              'timesheetrequests.*',
              'clients.client_name',
              'clients.client_code',
              'assignments.assignment_name',
              'teammembers.team_member',
              'teammembers.staffcode',
              'createdby.team_member as createdbyauth',
              'createdby.staffcode as staffcodeid',
            )
            ->get();

            $hasopenRequests = $timesheetrequestedit->contains('status', 0);
      
            dd($hasopenRequests);
      
          $partner = DB::table('teammembers')
            ->whereNotIn('id', [887, 663, 841, 836, 843, 447])
            ->where('role_id', '=', 13)
            ->where('status', '=', 1)
            ->select('id', 'team_member', 'staffcode')
            ->orderBy('team_member', 'asc')
            // ->distinct()
            ->get();
      
      
          return view('backEnd.timesheet.timesheetrequestedit', compact('timesheetrequestedit', 'partner'));
        }
        //! End hare 


        //* regarding file and  folder download
        // Start Hare
    //     <li>
    //     <strong>Download55:</strong>
    //     <a href="{{ url('img/' . 'creater.xlsx') }}" class="btn btn-success">Download2</a>
    // </li>
        Route::get('img/{name}', [ContactUsWebController::class, 'download']);

public function download(Request $request, $name)
{
    $path = public_path('assets/img/' . $name);
    if (!file_exists($path)) {
        abort(404, 'File not found.');
    }
    return response()->download($path);
}
        // Start Hare
        //! End hare 


        //* regarding date
        // Start Hare
        $to = Carbon::createFromFormat('Y-m-d', $request->to ?? '');
        $from = Carbon::createFromFormat('Y-m-d', $request->from);
        // Calculate the total number of days (inclusive of both start and end dates)
        $totaldayscount = $to->diffInDays($from) + 1;
        if ($totaldayscount > 10) {
            return back()->with('statuss', ['msg' => 'You cannot apply casual leave for more than 10 days']);
        }
        dd('hi');
        // Start Hare
        //! End hare 


        //* regarding 
        // Start Hare
        Route::get('/download-balance-confirmation', function () {
            $filePath = public_path('backEnd/balanceconfirmation.xlsx');
            $fileName = 'balanceconfirmation.xlsx';
            return response()->download($filePath, $fileName);
        })->name('download.balanceconfirmation');

        //         <div class="col-sm-9">
        //     <a href="{{ route('download.balanceconfirmation') }}" class="btn btn-success">
        //         Download <i class="fas fa-file-excel" style="margin-left: 3px; font-size: 20px;"></i>
        //     </a>
        // </div>

        // Start Hare

        // public function getFiles($file)
        // {

        //     $path = storage_path('/app/kgsomani/' . $file);
        //     return response()->download($path);
        // }
        // Start Hare
        //     Route::get('/download-image', function () {
        //         $filePath = public_path('img/logo.png');
        //         $fileName = 'logo.png';
        //         return response()->download($filePath, $fileName);
        //     })->name('download.image');

        //     <li>
        //     <strong>Download:</strong>
        //     <a href="{{ route('download.image') }}" class="btn btn-success">Download</a>
        // </li>

        // dd(public_path('img/logo.png'));



        // return response()->streamDownload(function () {
        //     echo file_get_contents(public_path('img/logo.png'));
        // }, 'logo.png');


        // Steps to Use the chmod Command
        // 1.	Access Your Server
        // o	If you're using a local development environment (e.g., XAMPP, WAMP):
        // 	Open your terminal or command prompt.
        // 	Navigate to your project directory.
        // o	If you're on a remote server (e.g., hosting provider like InfinityFree or cPanel):
        // 	Use an SSH client like PuTTY or connect to your server via the terminal.
        // 	Navigate to your project directory.
        // 2.	Navigate to Your Laravel Project Use the cd command to move to your project directory. For example:
        // bash
        // CopyEdit
        // cd /var/www/html/your_project_name
        // 3.	Run the Command Execute the following command to set directory permissions:
        // bash
        // CopyEdit
        // chmod 755 public/backEnd
        // o	If you need to apply this to a specific file, use:
        // bash
        // CopyEdit
        // chmod 644 public/backEnd/balanceconfirmation.xlsx
        // 4.	Verify Permissions To confirm the permissions have been applied, run:
        // bash
        // CopyEdit
        // ls -l public/backEnd
        // You should see something like:
        // kotlin
        // CopyEdit
        // -rw-r--r-- 1 www-data www-data 12345 Jan 15 15:00 balanceconfirmation.xlsx
        // ________________________________________
        // If You're Using a File Manager
        // If your hosting provider doesn't allow terminal access:
        // 1.	Open the File Manager in cPanel or your hosting dashboard.
        // 2.	Navigate to the public/backEnd/ folder or the balanceconfirmation.xlsx file.
        // 3.	Right-click the folder/file and choose Permissions or Change Permissions.
        // 4.	Set the permissions to:
        // o	Folder: 755 (Read, Write, and Execute for the Owner, Read and Execute for others).
        // o	File: 644 (Read and Write for the Owner, Read for others).
        // ________________________________________
        // After doing this, the file should be accessible for download. Let me know if you encounter any issues!


        // Start Hare
        if ($request->totalhour) {
            // Check if the format is exactly two digits (e.g., "00")
            if (!preg_match('/^\d{1,2}$/', $request->totalhour)) {
                $output = array('msg' => 'The total hours must be in the format 00.');
                dd($output);
                return back()->with('success', $output);
            }
        }
        dd('hi');
        //! End hare 

        //* regarding year
        // Start Hare
        // Start Hare

        $currentDate = Carbon::now();
        $currentYear = $currentDate->year;
        $previousYear = $currentDate->copy()->subYear(1)->year;  // Use copy to avoid modifying $currentDate

        $updatedRows = DB::table('leavetypes')
            ->where('year', $previousYear)
            ->update([
                'year' =>  $currentYear,
                'startdate' =>  "$previousYear-04-01",
                'enddate' => "$currentYear-03-31"
            ]);

        dd($previousYear, $currentYear);  // Dumps the previous and current year

        // Start Hare
        $currentYear = date('Y');  // Get the current year using PHP's date function
        $previousYear = $currentYear - 1;  // Manually calculate the previous year

        $updatedRows = DB::table('leavetypes')
            ->where('year', $previousYear)
            ->update([
                'year' => $currentYear,
                'startdate' => "$previousYear-04-01",
                'enddate' => "$currentYear-03-31"
            ]);

        dd($previousYear, $currentYear);  // Dumps the previous and current year


        //! End hare 
    }

    // -----------------------------30-12-2024------------------------------------------
}
