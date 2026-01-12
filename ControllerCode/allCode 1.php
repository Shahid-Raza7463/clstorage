<?php
use Illuminate\Support\Facades\Log;
// April excell
// Work item May
// june ka excell 
// july  Daily Work item july from client send folder 
// August   Work item aug
// september  Work item aug

class ZipController extends Controller
{
      // -----------------------------30-12-2024------------------------------------------
  public function store(Request $request) {
//*
// Start Hare
//! End hare 
                    // $todaydate = Carbon::now('Asia/Kolkata');
                    $todaydate = Carbon::createFromFormat('d-m-Y H:i:s', '25-01-2026 15:30:00', 'Asia/Kolkata');
//*
// Start Hare
 public function kratemplatelistedit(Request $request)
    {
        try {

            $request->validate([
                'templatename' => 'required|string|unique:krasdata,template_name,' . $request->templateid . ',id',
            ]);

            DB::table('krasdata')->where('id', $request->templateid)
                ->update([
                    'template_name' => $request->templatename,
                    'updated_at' => now()
                ]);
            return back()->with('statusss', ['msg' => 'KRAs template name updated successfully!']);
        } catch (\Exception $e) {
            Log::emergency("File:" . $e->getFile() . " Line:" . $e->getLine() . " Message:" . $e->getMessage());
            report($e);
            return back()->withErrors(['msg' => 'Error: ' . $e->getMessage()])->withInput();
        }
    }
//! End hare 
//*
  // Bills Pending For Collection
      // $billspendingforcollection = DB::table('assignmentmappings')
      //   ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
      //   ->leftJoin('invoices', 'invoices.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
      //   ->leftJoin('outstandings', 'outstandings.BILL_NO', '=', 'invoices.invoice_id')
      //   // ensures invoice is created
      //   ->whereNotNull('invoices.id')
      //   ->where('assignmentbudgetings.status', 0)
      //   ->sum('outstandings.AMT');
      // // ->get();

      // dd($billspendingforcollection);

      // Bills Pending For Collection

      // $inrbillspending = DB::table('assignmentmappings')
      //   ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
      //   ->leftJoin('invoices', 'invoices.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
      //   ->leftJoin('outstandings', 'outstandings.BILL_NO', '=', 'invoices.invoice_id')
      //   // ensures invoice is created
      //   ->whereNotNull('invoices.id')
      //   ->where('assignmentbudgetings.status', 0)
      //   ->where('invoices.currency', 3)
      //   ->sum('outstandings.AMT');

      // $usdbillspending = DB::table('assignmentmappings')
      //   ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
      //   ->leftJoin('invoices', 'invoices.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
      //   ->leftJoin('outstandings', 'outstandings.BILL_NO', '=', 'invoices.invoice_id')
      //   // ensures invoice is created
      //   ->whereNotNull('invoices.id')
      //   ->where('assignmentbudgetings.status', 0)
      //   ->where('invoices.currency', 1)
      //   ->sum('outstandings.AMT');
      // // ->get();

      // dd($inrbillspending, $usdbillspending);

      // $date = now()->format('Y-m-d');

      // $rate = 0;
      // $response = Http::get("https://api.frankfurter.app/{$date}", [
      //   'from' => 'USD',
      //   'to' => 'INR'
      // ]);

      // if ($response->successful()) {
      //   $rate = $response->json()['rates']['INR'] ?? 0;
      // }
      // // dd($response, $rate,  $usdBills, $response->json());

      // // convert usd to inr
      // $usdbillspendingfinal = $usdbillspending * $rate;
      // $billspendingforcollection = round($inrbillspending + $usdbillspendingfinal, 2);


      // $billSums = DB::table('assignmentmappings')
      //   ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
      //   ->leftJoin('invoices', 'invoices.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
      //   ->leftJoin('outstandings', 'outstandings.BILL_NO', '=', 'invoices.invoice_id')
      //   ->whereNotNull('invoices.id')
      //   ->where('assignmentbudgetings.status', 0)
      //   ->whereIn('invoices.currency', [1, 3])
      //   ->select(
      //     'invoices.currency',
      //     'outstandings.created_at',
      //     DB::raw('SUM(outstandings.AMT) as total_amount')
      //   )
      //   ->groupBy('invoices.currency', 'outstandings.created_at')
      //   ->pluck('total_amount', 'currency', 'created_at');

      // $date = now()->format('Y-m-d');

      // dd($billSums);
      // // defaults set 0 if missing
      // $inrBillSpending = $billSums[3] ?? 0;
      // $usdBillSpending = $billSums[1] ?? 0;

      // $rate = 0;
      // $response = Http::get("https://api.frankfurter.app/{$date}", [
      //   'from' => 'USD',
      //   'to' => 'INR'
      // ]);

      // if ($response->successful()) {
      //   $rate = $response->json()['rates']['INR'] ?? 0;
      // }

      // $usdBillSpendingInInr = $usdBillSpending * $rate;
      // $billSpendingForCollection = round($inrBillSpending + $usdBillSpendingInInr, 2);

      // dd($billSums);

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

          $totalUsdamount += $bill->total_amount * $rate;
        }
      }

      $billSpendingForCollection = round($totalamountInr + $totalUsdamount, 2);
      // Bills Pending For Collection end hare 
//*
if ($attendanceDatas->isEmpty()) {
  dd($query->toSql(), $query->getBindings()); // Debugging ke liye
}

// Start Hare
//! End hare 

//* regarding holidays update / regarding holidays 
// Start Hare


$holidays = [
  [
    'holidayname' => 'Pongal/Makara Sankaranti',
    'startdate' => '2026-01-14',
    'enddate' => '2026-01-14',
    'number_of_dates' => 1,
  ],
  [
    'holidayname' => 'Republic Day',
    'startdate' => '2026-01-26',
    'enddate' => '2026-01-26',
    'number_of_dates' => 1,
  ],
  [
    'holidayname' => 'Holi',
    'startdate' => '2026-03-04',
    'enddate' => '2026-03-04',
    'number_of_dates' => 1,
  ],
  [
    'holidayname' => 'Ambedkar Jayanthi',
    'startdate' => '2026-04-14',
    'enddate' => '2026-04-14',
    'number_of_dates' => 1,
  ],
  [
    'holidayname' => 'Raksha Bandhan',
    'startdate' => '2026-08-28',
    'enddate' => '2026-08-28',
    'number_of_dates' => 1,
  ],
  [
    'holidayname' => 'Independence Day',
    'startdate' => '2026-08-15',
    'enddate' => '2026-08-15',
    'number_of_dates' => 1,
  ],
  [
    'holidayname' => 'Janmashtami',
    'startdate' => '2026-09-04',
    'enddate' => '2026-09-04',
    'number_of_dates' => 1,
  ],
  [
    'holidayname' => 'Ganesh (Vinayaka) Chaturthi',
    'startdate' => '2026-09-14',
    'enddate' => '2026-09-14',
    'number_of_dates' => 1,
  ],
  [
    'holidayname' => 'Gandhi Jayanthi',
    'startdate' => '2026-10-02',
    'enddate' => '2026-10-02',
    'number_of_dates' => 1,
  ],
  [
    'holidayname' => 'Mahanavami/Saraswathi Pooja',
    'startdate' => '2026-10-19',
    'enddate' => '2026-10-19',
    'number_of_dates' => 1,
  ],
  [
    'holidayname' => 'Dussehra Vijaya Dasami',
    'startdate' => '2026-10-20',
    'enddate' => '2026-10-20',
    'number_of_dates' => 1,
  ],
  [
    'holidayname' => 'Deepawali',
    'startdate' => '2026-11-08',
    'enddate' => '2026-11-08',
    'number_of_dates' => 1,
  ],
  [
    'holidayname' => 'Deepawali',
    'startdate' => '2026-11-09',
    'enddate' => '2026-11-09',
    'number_of_dates' => 1,
  ],
  [
    'holidayname' => 'Christmas Day',
    'startdate' => '2026-12-25',
    'enddate' => '2026-12-25',
    'number_of_dates' => 1,
  ],
];


foreach ($holidays as $holiday) {
  DB::table('holidays')->insert([
    'holidayname' => $holiday['holidayname'],
    'startdate' => $holiday['startdate'],
    'enddate' => $holiday['enddate'],
    'number_of_dates' => $holiday['number_of_dates'],
    'restricted' => 'on',
    'description' => null,
    'year' => 2026,
    'notify' => null,
    'status' => 1,
    'createdby' => null,
    'updatedby' => null,
    'created_at' => now(),
    'updated_at' => now(),
  ]);
}


INSERT INTO `holidays`
(`holidayname`, `startdate`, `enddate`, `number_of_dates`, `restricted`, `description`, `year`, `notify`, `status`, `createdby`, `updatedby`, `created_at`, `updated_at`)
VALUES
('Pongal/Makara Sankaranti', '2026-01-14', '2026-01-14', 1, 'on', NULL, 2026, NULL, 1, NULL, NULL, NOW(), NOW()),
('Republic Day', '2026-01-26', '2026-01-26', 1, 'on', NULL, 2026, NULL, 1, NULL, NULL, NOW(), NOW()),
('Holi', '2026-03-04', '2026-03-04', 1, 'on', NULL, 2026, NULL, 1, NULL, NULL, NOW(), NOW()),
('Ambedkar Jayanthi', '2026-04-14', '2026-04-14', 1, 'on', NULL, 2026, NULL, 1, NULL, NULL, NOW(), NOW()),
('Raksha Bandhan', '2026-08-28', '2026-08-28', 1, 'on', NULL, 2026, NULL, 1, NULL, NULL, NOW(), NOW()),
('Independence Day', '2026-08-15', '2026-08-15', 1, 'on', NULL, 2026, NULL, 1, NULL, NULL, NOW(), NOW()),
('Janmashtami', '2026-09-04', '2026-09-04', 1, 'on', NULL, 2026, NULL, 1, NULL, NULL, NOW(), NOW()),
('Ganesh (Vinayaka) Chaturthi', '2026-09-14', '2026-09-14', 1, 'on', NULL, 2026, NULL, 1, NULL, NULL, NOW(), NOW()),
('Gandhi Jayanthi', '2026-10-02', '2026-10-02', 1, 'on', NULL, 2026, NULL, 1, NULL, NULL, NOW(), NOW()),
('Mahanavami/Saraswathi Pooja', '2026-10-19', '2026-10-19', 1, 'on', NULL, 2026, NULL, 1, NULL, NULL, NOW(), NOW()),
('Dussehra Vijaya Dasami', '2026-10-20', '2026-10-20', 1, 'on', NULL, 2026, NULL, 1, NULL, NULL, NOW(), NOW()),
('Deepawali', '2026-11-08', '2026-11-08', 1, 'on', NULL, 2026, NULL, 1, NULL, NULL, NOW(), NOW()),
('Deepawali', '2026-11-09', '2026-11-09', 1, 'on', NULL, 2026, NULL, 1, NULL, NULL, NOW(), NOW()),
('Christmas Day', '2026-12-25', '2026-12-25', 1, 'on', NULL, 2026, NULL, 1, NULL, NULL, NOW(), NOW());


// Start Hare


$holidays = [
  [
    'holidayname' => 'Pongal/Makara Sankaranti',
    'startdate' => '2025-01-14',
    'enddate' => '2025-01-14',
    'number_of_dates' => 1,
  ],
  [
    'holidayname' => 'Republic Day',
    'startdate' => '2025-01-26',
    'enddate' => '2025-01-26',
    'number_of_dates' => 1,
  ],
  [
    'holidayname' => 'Holi',
    'startdate' => '2025-03-14',
    'enddate' => '2025-03-14',
    'number_of_dates' => 1,
  ],
  [
    'holidayname' => 'Ambedkar Jayanthi',
    'startdate' => '2025-04-14',
    'enddate' => '2025-04-14',
    'number_of_dates' => 1,
  ],
  [
    'holidayname' => 'Raksha Bandhan',
    'startdate' => '2025-08-09',
    'enddate' => '2025-08-09',
    'number_of_dates' => 1,
  ],
  [
    'holidayname' => 'Independence Day',
    'startdate' => '2025-08-15',
    'enddate' => '2025-08-15',
    'number_of_dates' => 1,
  ],
  [
    'holidayname' => 'Janmashtami',
    'startdate' => '2025-08-16',
    'enddate' => '2025-08-16',
    'number_of_dates' => 1,
  ],
  [
    'holidayname' => 'Ganesh (Vinayaka) Chaturthi',
    'startdate' => '2025-08-27',
    'enddate' => '2025-08-27',
    'number_of_dates' => 1,
  ],
  [
    'holidayname' => 'Mahanavami/Saraswathi Pooja',
    'startdate' => '2025-10-01',
    'enddate' => '2025-10-01',
    'number_of_dates' => 1,
  ],
  [
    'holidayname' => 'Gandhi Jayanthi / Dussera Vijayadashami',
    'startdate' => '2025-10-02',
    'enddate' => '2025-10-02',
    'number_of_dates' => 1,
  ],
  [
    'holidayname' => 'Deepawali',
    'startdate' => '2025-10-20',
    'enddate' => '2025-10-20',
    'number_of_dates' => 1,
  ],
  [
    'holidayname' => 'Deepawali',
    'startdate' => '2025-10-21',
    'enddate' => '2025-10-21',
    'number_of_dates' => 1,
  ],
  [
    'holidayname' => 'Gurunanak Jayanti',
    'startdate' => '2025-11-05',
    'enddate' => '2025-11-05',
    'number_of_dates' => 1,
  ],
  [
    'holidayname' => 'Christmas Day',
    'startdate' => '2025-12-25',
    'enddate' => '2025-12-25',
    'number_of_dates' => 1,
  ],
];



foreach ($holidays as $holiday) {
  DB::table('holidays')->insert([
    'holidayname' => $holiday['holidayname'],
    'startdate' => $holiday['startdate'],
    'enddate' => $holiday['enddate'],
    'number_of_dates' => $holiday['number_of_dates'],
    'restricted' => 'on',
    'description' => null,
    'year' => 2025,
    'notify' => null,
    'status' => 1,
    'createdby' => null,
    'updatedby' => null,
    'created_at' => now(),
    'updated_at' => now(),
  ]);
}

dd('done');
// Start Hare
DB::table('holidays')->insert([
  [
      'id' => 1,
      'holidayname' => 'Pongal/Makara Sankaranti',
      'startdate' => '2024-01-14',
      'enddate' => '2024-01-14',
      'restricted' => 0,
      'description' => 'Festival celebrated in January.',
      'number_of_dates' => 1,
      'year' => 2024,
      'notify' => 1,
      'status' => 1,
      'createdby' => 1, // Replace with your user ID
      'updatedby' => 1, // Replace with your user ID
      'created_at' => now(),
      'updated_at' => now(),
  ],
  [
      'id' => 2,
      'holidayname' => 'Republic Day',
      'startdate' => '2024-01-26',
      'enddate' => '2024-01-26',
      'restricted' => 0,
      'description' => 'National holiday celebrated in January.',
      'number_of_dates' => 1,
      'year' => 2024,
      'notify' => 1,
      'status' => 1,
      'createdby' => 1,
      'updatedby' => 1,
      'created_at' => now(),
      'updated_at' => now(),
  ],
  [
      'id' => 3,
      'holidayname' => 'Holi',
      'startdate' => '2024-03-14',
      'enddate' => '2024-03-14',
      'restricted' => 0,
      'description' => 'Festival of colors celebrated in March.',
      'number_of_dates' => 1,
      'year' => 2024,
      'notify' => 1,
      'status' => 1,
      'createdby' => 1,
      'updatedby' => 1,
      'created_at' => now(),
      'updated_at' => now(),
  ],
  [
      'id' => 4,
      'holidayname' => 'Ambedkar Jayanthi',
      'startdate' => '2024-04-14',
      'enddate' => '2024-04-14',
      'restricted' => 0,
      'description' => 'Birthday of Dr. B.R. Ambedkar celebrated in April.',
      'number_of_dates' => 1,
      'year' => 2024,
      'notify' => 1,
      'status' => 1,
      'createdby' => 1,
      'updatedby' => 1,
      'created_at' => now(),
      'updated_at' => now(),
  ],
  // Continue adding similar entries for other holidays
]);

//! End hare 
//*
//*

if ($iftwotimesheetinday == "P") {
  $updatewording = "P";
  $totalcountupdate = $attendances->$totalcountColumn; // No increment needed, use as is
} elseif ($iftwotimesheetinday == 'T') {
  $totalcountupdatetravel = $attendances->travel + 1; // Increment travel count
  DB::table('attendances')
      ->where('id', $attendances->id)
      ->update([
          'travel' => $totalcountupdatetravel,
      ]);
  $updatewording = "P";
  $totalcountupdate = $attendances->$totalcountColumn; // No increment needed, use as is
}


if ($iftwotimesheetinday == "P") {
  $updatewording = "P";
  $totalcountupdate = $attendances->$totalcountColumn; // No change needed
} elseif ($iftwotimesheetinday == 'T') {
  $totalcountupdatetravel = max(0, $attendances->travel - 1); // Subtract 1 but ensure it doesn't go below 0
  DB::table('attendances')
      ->where('id', $attendances->id)
      ->update([
          'travel' => $totalcountupdatetravel,
      ]);
  $updatewording = "P";
  $totalcountupdate = $attendances->$totalcountColumn; // No change needed
}



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

// Start Hare
//! End hare 

//*
// Start Hare
 // public function totaltraveldays(Request $request, $teamid)
  // {

  //   // total working days start using financial year
  //   $currentDate = Carbon::now();
  //   $currentMonth = $currentDate->format('F');
  //   if ($currentDate->month >= 4) {
  //     // Current year financial year
  //     $startDate = Carbon::create($currentDate->year, 4, 1);
  //     $endDate = Carbon::create($currentDate->year + 1, 3, 31);
  //   } else {
  //     // Previous year financial year
  //     $startDate = Carbon::create($currentDate->year - 1, 4, 1);
  //     $endDate = Carbon::create($currentDate->year, 3, 31);
  //   }

  //   $query = DB::table('timesheetusers')
  //     ->leftJoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
  //     ->leftJoin('clients', 'clients.id', 'timesheetusers.client_id')
  //     ->leftJoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
  //     ->leftJoin('teammembers as patnerid', 'patnerid.id', 'timesheetusers.partner')
  //     ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'patnerid.id')
  //     ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'timesheetusers.assignmentgenerate_id')
  //     ->select(
  //       'timesheetusers.*',
  //       'assignments.assignment_name',
  //       'clients.client_name',
  //       'clients.client_code',
  //       'teammembers.team_member',
  //       'teammembers.staffcode',
  //       'patnerid.team_member as patnername',
  //       'patnerid.staffcode as patnerstaffcode',
  //       'assignmentbudgetings.assignmentname',
  //       'teamrolehistory.newstaff_code',
  //       'assignmentbudgetings.created_at as assignmentcreateddate'
  //     )
  //     ->where('timesheetusers.createdby', $teamid)
  //     ->whereIn('timesheetusers.status', [1, 2, 3])
  //     ->whereBetween('timesheetusers.date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
  //     // Get only travel data
  //     ->whereIn('timesheetusers.assignmentgenerate_id', ['OFF100003'])
  //     ->orderBy('timesheetusers.date', 'DESC');

  //   // Apply role-specific filters if necessary
  //   if (auth()->user()->role_id == 13) {
  //     // Add any specific conditions or modifications for role_id 13 if needed.
  //   }

  //   $timesheetData = $query->get();
  //   return view('backEnd.timesheet.totaltraveldays', compact('timesheetData'));
  // }

  // public function totaltraveldays(Request $request, $teamid)
  // {
  //   // Define the financial year start and end dates
  //   $currentDate = Carbon::now();
  //   $startDate = ($currentDate->month >= 4)
  //     ? Carbon::create($currentDate->year, 4, 1)
  //     : Carbon::create($currentDate->year - 1, 4, 1);
  //   $endDate = ($currentDate->month >= 4)
  //     ? Carbon::create($currentDate->year + 1, 3, 31)
  //     : Carbon::create($currentDate->year, 3, 31);

  //   // Fetch necessary data
  //   $timesheetData = DB::table('timesheetusers')
  //     ->leftJoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
  //     ->leftJoin('clients', 'clients.id', 'timesheetusers.client_id')
  //     ->leftJoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
  //     ->leftJoin('teammembers as partner', 'partner.id', 'timesheetusers.partner')
  //     ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', 'partner.id')
  //     ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'timesheetusers.assignmentgenerate_id')
  //     ->select(
  //       'timesheetusers.*',
  //       'assignments.assignment_name',
  //       'clients.client_name',
  //       'clients.client_code',
  //       'teammembers.team_member',
  //       'teammembers.staffcode',
  //       'partner.team_member as partner_name',
  //       'partner.staffcode as partner_staffcode',
  //       'assignmentbudgetings.assignmentname',
  //       'teamrolehistory.newstaff_code',
  //       'assignmentbudgetings.created_at as assignment_created_date'
  //     )
  //     ->where('timesheetusers.createdby', $teamid)
  //     ->whereIn('timesheetusers.status', [1, 2, 3])
  //     ->whereBetween('timesheetusers.date', [$startDate->toDateString(), $endDate->toDateString()])
  //     ->where('timesheetusers.assignmentgenerate_id', 'OFF100003')
  //     ->orderBy('timesheetusers.date', 'DESC')
  //     ->get()

  //     ->map(function ($timesheet) {
  //       $promotionCheck = DB::table('teamrolehistory')
  //         ->where('teammember_id', $timesheet->createdby)
  //         ->first();

  //       $assignmentDate = $timesheet->assignment_created_date
  //         ? Carbon::parse($timesheet->assignment_created_date)
  //         : null;

  //       $promotionDate = $promotionCheck
  //         ? Carbon::parse($promotionCheck->created_at)
  //         : null;

  //       // Add computed fields to the object
  //       $timesheet->display_staffcode = ($promotionCheck && $assignmentDate && $assignmentDate->greaterThan($promotionDate))
  //         ? $promotionCheck->newstaff_code
  //         : $timesheet->staffcode;

  //       $timesheet->display_partner_code = ($promotionCheck && $assignmentDate && $assignmentDate->greaterThan($promotionDate))
  //         ? $timesheet->newstaff_code
  //         : $timesheet->partner_staffcode;

  //       $timesheet->formatted_date = Carbon::parse($timesheet->date)->format('d-m-Y');
  //       $timesheet->day_of_week = Carbon::parse($timesheet->date)->format('l');

  //       return $timesheet;
  //     });

  //   return view('backEnd.timesheet.totaltraveldays', compact('timesheetData'));
  // }

  // public function totaltraveldays(Request $request, $teamid)
  // {
  //   $currentDate = Carbon::now();
  //   $startDate = ($currentDate->month >= 4)
  //     ? Carbon::create($currentDate->year, 4, 1)
  //     : Carbon::create($currentDate->year - 1, 4, 1);
  //   $endDate = $startDate->copy()->addYear()->subDay();

  //   $timesheetData = DB::table('timesheetusers')
  //     ->leftJoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
  //     ->leftJoin('clients', 'clients.id', 'timesheetusers.client_id')
  //     ->leftJoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
  //     ->leftJoin('teammembers as patnerid', 'patnerid.id', 'timesheetusers.partner')
  //     ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'patnerid.id')
  //     ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'timesheetusers.assignmentgenerate_id')
  //     ->select(
  //       'timesheetusers.*',
  //       'assignments.assignment_name',
  //       'clients.client_name',
  //       'clients.client_code',
  //       'teammembers.team_member',
  //       'teammembers.staffcode',
  //       'patnerid.team_member as patnername',
  //       'patnerid.staffcode as patnerstaffcode',
  //       'assignmentbudgetings.assignmentname',
  //       'teamrolehistory.newstaff_code',
  //       'assignmentbudgetings.created_at as assignmentcreateddate'
  //     )
  //     ->where('timesheetusers.createdby', $teamid)
  //     ->whereIn('timesheetusers.status', [1, 2, 3])
  //     ->whereBetween('timesheetusers.date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
  //     ->whereIn('timesheetusers.assignmentgenerate_id', ['OFF100003'])
  //     ->orderBy('timesheetusers.date', 'DESC')
  //     ->get();

  //   // Precompute counts
  //   $timesheetCounts = DB::table('timesheetusers')
  //     ->select('timesheetid', DB::raw('COUNT(*) as count'))
  //     ->groupBy('timesheetid')
  //     ->pluck('count', 'timesheetid');

  //   return view('backEnd.timesheet.totaltraveldays', compact('timesheetData', 'timesheetCounts'));
  // }


  // public function totaltraveldays(Request $request, $teamid)
  // {
  //   $currentDate = Carbon::now();
  //   $startDate = ($currentDate->month >= 4)
  //     ? Carbon::create($currentDate->year, 4, 1)
  //     : Carbon::create($currentDate->year - 1, 4, 1);
  //   $endDate = $startDate->copy()->addYear()->subDay();

  //   // Fetch timesheet data
  //   $timesheetData = DB::table('timesheetusers')
  //     ->leftJoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
  //     ->leftJoin('clients', 'clients.id', 'timesheetusers.client_id')
  //     ->leftJoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
  //     ->leftJoin('teammembers as patnerid', 'patnerid.id', 'timesheetusers.partner')
  //     ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'patnerid.id')
  //     ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'timesheetusers.assignmentgenerate_id')
  //     ->select(
  //       'timesheetusers.*',
  //       'assignments.assignment_name',
  //       'clients.client_name',
  //       'clients.client_code',
  //       'teammembers.team_member',
  //       'teammembers.staffcode',
  //       'patnerid.team_member as patnername',
  //       'patnerid.staffcode as patnerstaffcode',
  //       'assignmentbudgetings.assignmentname',
  //       'teamrolehistory.newstaff_code',
  //       'assignmentbudgetings.created_at as assignmentcreateddate'
  //     )
  //     ->where('timesheetusers.createdby', $teamid)
  //     ->whereIn('timesheetusers.status', [1, 2, 3])
  //     ->whereBetween('timesheetusers.date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
  //     ->whereIn('timesheetusers.assignmentgenerate_id', ['OFF100003'])
  //     ->orderBy('timesheetusers.date', 'DESC')
  //     ->get();

  //   // Precompute counts
  //   $timesheetCounts = DB::table('timesheetusers')
  //     ->select('timesheetid', DB::raw('COUNT(*) as count'))
  //     ->groupBy('timesheetid')
  //     ->pluck('count', 'timesheetid');

  //   return view('backEnd.timesheet.totaltraveldays', compact('timesheetData', 'timesheetCounts'));
  // }

  public function totaltraveldays(Request $request, $teamid)
  {
    $currentDate = Carbon::now();
    $startDate = ($currentDate->month >= 4)
      ? Carbon::create($currentDate->year, 4, 1)
      : Carbon::create($currentDate->year - 1, 4, 1);
    $endDate = $startDate->copy()->addYear()->subDay();

    // Fetch timesheet data
    $timesheetData = DB::table('timesheetusers')
      ->leftJoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
      ->leftJoin('clients', 'clients.id', 'timesheetusers.client_id')
      ->leftJoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
      ->leftJoin('teammembers as patnerid', 'patnerid.id', 'timesheetusers.partner')
      ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'patnerid.id')
      ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'timesheetusers.assignmentgenerate_id')
      ->select(
        'timesheetusers.*',
        'assignments.assignment_name',
        'clients.client_name',
        'clients.client_code',
        'teammembers.team_member',
        'teammembers.staffcode',
        'patnerid.team_member as patnername',
        'patnerid.staffcode as patnerstaffcode',
        'assignmentbudgetings.assignmentname',
        'teamrolehistory.newstaff_code',
        'assignmentbudgetings.created_at as assignmentcreateddate'
      )
      ->where('timesheetusers.createdby', $teamid)
      ->whereIn('timesheetusers.status', [1, 2, 3])
      ->whereBetween('timesheetusers.date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
      ->whereIn('timesheetusers.assignmentgenerate_id', ['OFF100003'])
      ->orderBy('timesheetusers.date', 'DESC')
      ->get();

    // Precompute counts
    $timesheetCounts = DB::table('timesheetusers')
      ->select('timesheetid', DB::raw('COUNT(*) as count'))
      ->groupBy('timesheetid')
      ->pluck('count', 'timesheetid');

    dd($timesheetCounts);

    // Fetch promotion data for checks (mock logic, replace as per your DB structure)
    $permotioncheck = DB::table('teamrolehistory')
      ->where('teammember_id', $teamid)
      ->latest('promotion_date') // Assuming 'promotion_date' exists
      ->first();

    // Determine promotion date (mock logic, replace with your condition)
    $permotiondate = $permotioncheck ? Carbon::parse($permotioncheck->promotion_date) : null;

    return view('backEnd.timesheet.totaltraveldays', compact('timesheetData', 'timesheetCounts', 'permotioncheck', 'permotiondate'));
  }
//! End hare 
//*
//*
        $rejoiningusersonanotherpost = DB::table('teamrolehistory')
            ->pluck('teammember_id');

        $rejoiningusersonsamepost = DB::table('rejoiningsamepost')
            ->pluck('teammember_id');

$teammembers = $rejoiningusersonanotherpost->merge($rejoiningusersonsamepost)->toArray();
// Start Hare
//! End hare 

//* regarding timesheet total count on dashboard
$startDate = Carbon::create('01-04-2024');
$endDate = Carbon::create('21-12-2024');

$home = DB::table('timesheetusers')
  // ->where('createdby', 847)
  ->where('createdby', $teamid)
  ->whereIn('status', [1, 2, 3])
  // hide offholidays and travel timesheet
  ->whereNotIn('assignmentgenerate_id', ['OFF100004', 'OFF100003'])
  // hide  casual leave and exam leave timesheet
  ->whereNotIn('client_id', [134])
  ->whereBetween('timesheetusers.date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
  ->select('date') // Select only the date column
  ->distinct() // Apply distinct on the selected columns
  ->get();

dd($home);
// Start Hare
//! End hare 
//*
try {
              
  Log::info("Email sent successfully to: " . $data['emailid']);
} catch (\Exception $e) {
  Log::error("Failed to send email to: " . $data['emailid'] . ". Error: " . $e->getMessage());
}

//*
// Start Hare
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
    // $query = DB::table('attendances')
    //     ->leftJoin('teammembers', 'teammembers.id', 'attendances.employee_name')
    //     ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
    //     ->leftJoin('roles', 'roles.id', 'teammembers.role_id')
    //     // ->whereNotNull('attendances.id')
    //     ->select(
    //         'attendances.*',
    //         'teammembers.team_member',
    //         'teammembers.staffcode',
    //         'teamrolehistory.newstaff_code',
    //         'teammembers.employment_status',
    //         'roles.rolename',
    //         'teammembers.joining_date'
    //     );

    // Build attendance query filtered by month
    $query = DB::table('attendances')
        ->join('teammembers', 'teammembers.id', '=', 'attendances.employee_name')
        ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
        ->leftJoin('rejoiningsamepost', 'rejoiningsamepost.teammember_id', '=', 'teammembers.id')
        ->leftJoin('roles', 'roles.id', '=', 'teammembers.role_id')
        ->select([
            'attendances.*',
            'teammembers.team_member',
            'teammembers.staffcode',
            'teammembers.employment_status',
            'roles.rolename',
            'teamrolehistory.newstaff_code',
            'teammembers.staffcode',
            // Combine rejoining dates
            // DB::raw('COALESCE(teamrolehistory.newstaff_code, teammembers.staffcode) AS final_staff_code'),
            // Combine rejoining dates
            DB::raw('COALESCE(teamrolehistory.rejoiningdate, rejoiningsamepost.rejoiningdate,teamrolehistory.promotion_date) AS final_rejoining_date'),
            // 'teamrolehistory.promotion_date',
            'teammembers.joining_date'
        ]);

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
    // dd($attendanceDatas);

    if (auth()->user()->role_id == 11 || auth()->user()->role_id == 13) {
        return view('backEnd.attendance.adminattendance', compact('attendanceDatas', 'teammembers'));
    } else {
        return view('backEnd.attendance.teamattendance', compact('attendanceDatas', 'teammembers'));
    }
}

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
    // $query = DB::table('attendances')
    //     ->leftJoin('teammembers', 'teammembers.id', 'attendances.employee_name')
    //     ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
    //     ->leftJoin('roles', 'roles.id', 'teammembers.role_id')
    //     // ->whereNotNull('attendances.id')
    //     ->select(
    //         'attendances.*',
    //         'teammembers.team_member',
    //         'teammembers.staffcode',
    //         'teamrolehistory.newstaff_code',
    //         'teammembers.employment_status',
    //         'roles.rolename',
    //         'teammembers.joining_date'
    //     );

    // Build attendance query filtered by month
    $query = DB::table('attendances')
        ->join('teammembers', 'teammembers.id', '=', 'attendances.employee_name')
        ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
        ->leftJoin('rejoiningsamepost', 'rejoiningsamepost.teammember_id', '=', 'teammembers.id')
        ->leftJoin('roles', 'roles.id', '=', 'teammembers.role_id')
        ->select([
            'attendances.*',
            'teammembers.team_member',
            'teammembers.staffcode',
            'teammembers.employment_status',
            'roles.rolename',
            // Combine rejoining dates
            DB::raw('COALESCE(teamrolehistory.newstaff_code, teammembers.staffcode) AS final_staff_code'),
            // Combine rejoining dates
            DB::raw('COALESCE(teamrolehistory.rejoiningdate, rejoiningsamepost.rejoiningdate,teamrolehistory.promotion_date) AS final_rejoining_date'),
            // 'teamrolehistory.promotion_date',
            'teammembers.joining_date'
        ]);

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
    // dd($attendanceDatas);

    if (auth()->user()->role_id == 11 || auth()->user()->role_id == 13) {
        return view('backEnd.attendance.adminattendance', compact('attendanceDatas', 'teammembers'));
    } else {
        return view('backEnd.attendance.teamattendance', compact('attendanceDatas', 'teammembers'));
    }
}

//! End hare 

//* regarding notification 
// Start Hare
@php
    // $request->validate([
    //     'attachment' => 'nullable|mimes:png,pdf,jpeg,jpg|max:4120',
    // ], [
    //     'attachment.max' => 'The file may not be greater than 5 MB.',
    // ]);
    $request->validate(
        [
            'attachment' => 'nullable|mimes:png,pdf,jpeg,jpg,xls,xlsx|max:5120',
        ],
        [
            'attachment.max' => 'The file may not be greater than 5 MB.',
            'attachment.mimes' => 'The file must be a type of: png, pdf, jpeg, jpg, xls, xlsx.',
        ],
    );
@endphp
// Start Hare
//! End hare 
//*
//* regarding duplicate data remove 
// Start Hare
// Start Hare
$notificationDatas = DB::table('notifications')
->leftJoin('notificationreadorunread', function ($join) use ($userId) {
    $join->on('notificationreadorunread.notifications_id', '=', 'notifications.id')
        ->where('notificationreadorunread.readedby', $userId);
})
->select(
    'notifications.*',
    'notificationreadorunread.status as readstatus'
)
->whereIn('notifications.id', function ($subquery) {
    // Subquery to get the latest ID for each duplicate value
    $subquery->from('notifications')
        ->selectRaw('MAX(id) as id')
        ->groupBy('duplicate');
})
->latest('notifications.created_at') // Sort by the latest created_at
->paginate(20);

dd($notificationDatas);
//! End hare 

//* regarding skip function / regarding take function
// Start Hare
$notificationDatas =  DB::table('notifications')
->join('teammembers', 'teammembers.id', 'notifications.created_by')
->Where('targettype', '3')
->orWhere('targettype', '2')
->orWhere('targettype', '1')
->select(
  'notifications.*',
  'teammembers.profilepic',
  'teammembers.team_member'
)->orderBy('created_at', 'desc')
->skip(3)
->take(3)
->get();
// Start Hare
//! End hare 
//*
//*
// Start Hare
public function changetimesheetaccess($teamid, $status)
{
    try {
        if ($status == 0) {
            DB::table('teammembers')->where('id', $teamid)->update([
                'timesheet_access'         =>  1,
            ]);
            $output = array('msg' => 'User can fill timesheet now');
        } else {
            DB::table('teammembers')->where('id', $teamid)->update([
                'timesheet_access'         =>  0,
            ]);
            $output = array('msg' => 'User cannot fill timesheet now');
        }
        return back()->with('success', $output);
    } catch (Exception $e) {
        DB::rollBack();
        Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
        report($e);
        $output = array('msg' => $e->getMessage());
        return back()->withErrors($output)->withInput();
    }
}


public function changetimesheetaccess($teamid, $status)
{
    try {

        $newStatus = $status == 0 ? 1 : 0;
        $message = $newStatus == 1
            ? 'User can fill timesheet now'
            : 'User cannot fill timesheet now';

        DB::table('teammembers')->where('id', $teamid)->update([
            'timesheet_access' => $newStatus,
        ]);

        return back()->with('success', ['msg' => $message]);
    } catch (Exception $e) {
        DB::rollBack();
        Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
        report($e);
        $output = array('msg' => $e->getMessage());
        return back()->withErrors($output)->withInput();
    }
}
// Start Hare
public function  timesheetreject($id)
  {
    try {
      $timesheetdata = DB::table('timesheetusers')->where('id', $id)->first();
      DB::table('timesheets')->where('id', $timesheetdata->timesheetid)->update([
        'status'   => 2,
      ]);
      DB::table('timesheetusers')->where('id', $id)->update([
        'status'   => 2,
        'rejectedby'   =>   auth()->user()->teammember_id,

      ]);
      //total hour update 
      if (!is_numeric($timesheetdata->assignmentgenerate_id)) {
        $assignment = Assignmentmapping::where('assignmentgenerate_id', $timesheetdata->assignmentgenerate_id)
          ->select('assignment_id')
          ->first();

        $teammemberrole =  DB::table('teammembers')
          ->where('id', $timesheetdata->createdby)
          ->select('team_member', 'role_id')
          ->first();

        $assignment_id = $assignment->assignment_id;
        $assignmentgenerateId = $timesheetdata->assignmentgenerate_id;

        // update total hour 
        if (auth()->user()->role_id == 11 || auth()->user()->role_id == 13) {
          if ($teammemberrole->role_id == 14 || $teammemberrole->role_id == 15) {
            $gettotalteamhour = DB::table('assignmentmappings')
              ->leftJoin(
                'assignmentteammappings',
                'assignmentteammappings.assignmentmapping_id',
                'assignmentmappings.id',
              )
              ->where(
                'assignmentmappings.assignmentgenerate_id',
                $timesheetdata->assignmentgenerate_id
              )
              ->where('assignmentteammappings.teammember_id', $timesheetdata->createdby)
              ->select('assignmentteammappings.*')
              ->first();


            if ($gettotalteamhour) {
              if ($gettotalteamhour->teamhour == null) {
                $gettotalteamhour->teamhour = 0;
              }

              $finalresult =  $gettotalteamhour->teamhour - $timesheetdata->hour;
              $totalteamhourupdate = DB::table('assignmentteammappings')
                ->where('id', $gettotalteamhour->id)
                ->update(['teamhour' =>  $finalresult]);
            }
          }

          if ($teammemberrole->role_id == 13) {
            $assignmentdata = DB::table('assignmentmappings')
              ->where('assignmentgenerate_id', $assignmentgenerateId)
              ->first();

            if ($assignmentdata->leadpartner == $timesheetdata->createdby) {
              if ($assignmentdata->leadpartnerhour == null) {
                $assignmentdata->leadpartnerhour = 0;
              }

              $finalresultleadpatner =  $assignmentdata->leadpartnerhour - $timesheetdata->hour;
              $totalteamhourupdate = DB::table('assignmentmappings')
                ->where('id', $assignmentdata->id)
                ->update(['leadpartnerhour' => $finalresultleadpatner]);
            }

            if ($assignmentdata->otherpartner == $timesheetdata->createdby) {
              if ($assignmentdata->otherpartnerhour == null) {
                $assignmentdata->otherpartnerhour = 0;
              }
              $finalresultotherpatner =  $assignmentdata->otherpartnerhour - $timesheetdata->hour;
              $totalteamhourupdate = DB::table('assignmentmappings')
                ->where('id', $assignmentdata->id)
                ->update(['otherpartnerhour' => $finalresultotherpatner]);
            }
          }
        }
      }
      //total hour update end hare 
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
      return back()->with('statuss', $output);
    } catch (Exception $e) {
      DB::rollBack();
      Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
      report($e);
      $output = array('msg' => $e->getMessage());
      return back()->withErrors($output)->withInput();
    }
  }

//! End hare 

//* for testing 
// Start Hare
 // $tables = [
    //   // timesheets
    //   'timesheetreport',
    //   'timesheetrequests',
    //   'timesheets',
    //   'timesheetusers',

    //   // applyleaves
    //   'applyleaves',
    //   'leaveapprove',
    //   'leaverequest',

    //   // assignments
    //   // 'assignmentbudgetings',
    //   // 'assignmentmappings',
    //   // 'assignmentteammappings',
    //   // 'assignments',

    //   // attendances
    //   'attendances',

    //   // 'Users',
    //   // 'teammembers',
    //   // 'Clients',
    //   // 'teamrolehistory',
    //   // 'rejoiningsamepost',
    // ];
    // // Loop through each table and drop it
    // foreach ($tables as $table) {
    //   if (Schema::hasTable($table)) {
    //     Schema::drop($table);
    //     echo "'{$table}'.<br>";
    //   } else {
    //     echo "'{$table}'.<br>";
    //   }
    // }
    // return response('Tables deleted successfully!', 200);

    // 22222222222222222222222222222222222222


    // B::table('timesheetreport')
    //   ->delete();
    // DB::table('timesheetrequests')
    //   ->delete();
    // DB::table('timesheets')
    //   ->delete();
    // DB::table('timesheetusers')
    //   ->delete();


    // DB::table('applyleaves')
    //   ->delete();
    // DB::table('leaveapprove')
    //   ->delete();
    // DB::table('leaverequest')
    //   ->delete();


    // DB::table('attendances')
    //   ->delete();

    // dd('hi');




    // $nextweektimesheet1 = DB::table('timesheetusers')
    //   ->where('createdby', 844)
    //   ->whereBetween('date', ['2024-11-07', '2024-11-11'])
    //   // ->get();
    //   ->update(['status' => 2]);


    // $nextweektimesheet2 = DB::table('timesheets')
    //   ->where('created_by', 844)
    //   ->whereBetween('date', ['2024-11-07', '2024-11-11'])
    //   // ->get();
    //   ->update(['status' => 3]);

    // more than one week delete 
    // $result = ['2024-11-18'];
    // foreach ($result as $date) {
    //   $nextweektimesheet3 = DB::table('timesheetreport')
    //     ->where('teamid', 844)
    //     ->where('startdate', $date)
    //     // ->get();
    //     ->delete();
    // }

    // dd('hi');
// Start Hare
//! End hare 
//*regarding database export
// Start Hare

// Start Hare after click url ye automatic download hona start hota hai download folder me 
public function index()
{
  $tableNames = ['teammembers', 'users'];
  // Initialize the SQL dump string
  $sqlDump = '';

  // Loop through each table
  foreach ($tableNames as $tableName) {

    // Get the table structure as SQL (CREATE TABLE statement)
    $createTableSQL = DB::select("SHOW CREATE TABLE `$tableName`");

    // Append the CREATE TABLE statement to the dump
    $sqlDump .= $createTableSQL[0]->{'Create Table'} . ";\n\n";

    // Get the data from the table (insert statements)
    $tableData = DB::table($tableName)->get();

    // Generate INSERT INTO statements for each row of the table
    foreach ($tableData as $row) {
      $columns = implode('`, `', array_keys((array) $row));  // Column names
      $values = implode(', ', array_map(function ($value) {
        return "'" . addslashes($value) . "'";  // Escape special characters in data
      }, (array) $row));  // Row values

      $sqlDump .= "INSERT INTO `$tableName` (`$columns`) VALUES ($values);\n";
    }

    $sqlDump .= "\n\n";  // Separate tables with a newline
  }

  // Create a single file for the SQL dump
  $fileName = 'vsalive.sql';  // Static file name
  $filePath = storage_path($fileName);

  // Save the SQL dump to the file
  file_put_contents($filePath, $sqlDump);

  // Return the SQL file for download
  return response()->download($filePath)->deleteFileAfterSend(true);
}
// Start Hare all database with data 

public function index()
{
  // $databaseName = 'vsalive'; // Your database name
  // $connectionName = config('database.default'); // Get the default connection name

  // // Get the list of tables from the `information_schema.tables` table
  // $tableNames = DB::connection($connectionName)
  //   ->select("SELECT table_name FROM information_schema.tables WHERE table_schema = ?", [$databaseName])->take(1)->get();
  // dd($tableNames);
  $tableNames = ['debtors'];
  // Initialize the SQL dump string
  $sqlDump = '';

  // Loop through each table
  foreach ($tableNames as $tableName) {

    // Get the table structure as SQL (CREATE TABLE statement)
    $createTableSQL = DB::select("SHOW CREATE TABLE `$tableName`");

    // Append the CREATE TABLE statement to the dump
    $sqlDump .= $createTableSQL[0]->{'Create Table'} . ";\n\n";

    // Get the data from the table (insert statements)
    $tableData = DB::table($tableName)->get();

    // Generate INSERT INTO statements for each row of the table
    foreach ($tableData as $row) {
      $columns = implode('`, `', array_keys((array) $row));  // Column names
      $values = implode(', ', array_map(function ($value) {
        return "'" . addslashes($value) . "'";
      }, (array) $row));  // Row values with escaping for special chars

      $sqlDump .= "INSERT INTO `$tableName` (`$columns`) VALUES ($values);\n";
    }

    $sqlDump .= "\n\n";  // Separate tables with a newline
  }

  // Create a temporary file for the SQL dump
  $fileName = "$tableName.sql";
  $filePath = storage_path($fileName);

  // Save the SQL dump to the file
  file_put_contents($filePath, $sqlDump);
  dd('hi');
  // Return the SQL file for download
  return response()->download($filePath)->deleteFileAfterSend(true);
}

// Start Hare aal database without data 
public function index()
  {

    $databaseName = 'vsalive'; // Your database name
    $connectionName = config('database.default'); // Get the default connection name

    // Get the list of tables from the `information_schema.tables` table
    $tableNames = DB::connection($connectionName)
      ->select("SELECT table_name FROM information_schema.tables WHERE table_schema = ?", [$databaseName]);


    // foreach ($tableNames as $tableName) {
    foreach ($tableNames as $key => $tableName) {

      // Get the table structure as SQL
      $createTableSQL = DB::select("SHOW CREATE TABLE `$tableName->table_name`");

      $sqlDump = $createTableSQL[0]->{'Create Table'} . ";\n\n";

      // Create a temporary file for the SQL dump
      $fileName = "$tableName->table_name.sql";
      $filePath = storage_path($fileName);


      // Save the SQL dump to the file
      file_put_contents($filePath, $sqlDump);
    }

    dd('hi');
    // Return the SQL file for download
    return response()->download($filePath)->deleteFileAfterSend(true);
  }
// Start Hare
public function index()
{
    // Define the database name
    $databaseName = 'vsalive'; // Your database name
    $connectionName = config('database.default'); // Get the default connection name

    // Get the list of tables from the `information_schema.tables` table
    $tableNames = DB::connection($connectionName)
        ->select("SELECT table_name FROM information_schema.tables WHERE table_schema = ?", [$databaseName]);

    // Create a zip file to store the SQL files
    $zip = new \ZipArchive();
    $zipFileName = 'tables_backup.zip';
    $zipFilePath = storage_path('app/' . $zipFileName);
    $zip->open($zipFilePath, \ZipArchive::CREATE);

    // Loop through each table and generate its SQL dump
    foreach ($tableNames as $table) {
        $tableName = $table->table_name;

        // Get the table structure as SQL using SHOW CREATE TABLE
        $createTableSQL = DB::connection($connectionName)->select("SHOW CREATE TABLE `$tableName`");

        // Prepare the SQL dump (structure of the table)
        $sqlDump = $createTableSQL[0]->{'Create Table'} . ";\n\n";

        // Create a temporary file for the SQL dump
        $fileName = "$tableName.sql";
        $filePath = storage_path('app/' . $fileName);

        // Save the SQL dump to the file
        file_put_contents($filePath, $sqlDump);

        // Add the SQL dump file to the zip archive
        $zip->addFile($filePath, $fileName);

        // Optionally delete the temporary file after adding it to the zip
        unlink($filePath);
    }

    // Close the zip archive
    $zip->close();

    // Return the zip file for download
    return response()->download($zipFilePath)->deleteFileAfterSend(true);
}

// Start Hare
public function index()
  {
    // Define the table name
    // $tableName = 'attendances';
    $tableNames = ['attendances', 'timesheets', 'users'];

    foreach ($tableNames as $tableName) {
      // Get the table structure as SQL
      $createTableSQL = DB::select("SHOW CREATE TABLE `$tableName`");

      $sqlDump = $createTableSQL[0]->{'Create Table'} . ";\n\n";

      // Create a temporary file for the SQL dump
      $fileName = "$tableName.sql";
      $filePath = storage_path($fileName);


      // Save the SQL dump to the file
      file_put_contents($filePath, $sqlDump);
    }

    dd('hi');
    // Return the SQL file for download
    return response()->download($filePath)->deleteFileAfterSend(true);
  }
// Start Hare
public function index()
{
  // Define the table name
  $tableName = 'attendances';
  // Get the table structure as SQL
  $createTableSQL = DB::select("SHOW CREATE TABLE `$tableName`");

  $sqlDump = $createTableSQL[0]->{'Create Table'} . ";\n\n";

  // Create a temporary file for the SQL dump
  $fileName = "$tableName.sql";
  $filePath = storage_path($fileName);


  // Save the SQL dump to the file
  file_put_contents($filePath, $sqlDump);
  // Return the SQL file for download
  return response()->download($filePath)->deleteFileAfterSend(true);
}
//! End hare 
//*regarding assignment create
// Start Hare
   // public function store(Request $request)
    // {
    //     $request->validate([
    //         'client_id' => "required",
    //         'assignment_id' => "required",
    //         'teammember_id.*' => "required",
    //         'assignmentname' => "required",
    //         'type.*' => "required"
    //     ]);

    //     $client_id = $request->input('client_id');
    //     $assignment_id = $request->input('assignment_id');
    //     $assignmentname = $request->input('assignmentname');

    //     if ($client_id && $assignment_id && $assignmentname) {

    //         $data = $request->except(['_token', 'periodstart', 'periodend', 'roleassignment', 'esthours', 'stdcost', 'estcost', 'fees', 'leadpartner', 'otherpartner', 'teammember_id', 'type']);
    //         $data['created_by'] = auth()->user()->id;

    //         $clientcode = DB::table('clients')->where('id', $client_id)->value('client_name');
    //         $assignmentgenerateid = strtoupper(substr($clientcode, 0, 3));

    //         // Generate unique assignment number
    //         $assignmentnumbers = DB::table('assignmentbudgetings')->max('assignmentnumber');

    //         $assignmentnumbers = $assignmentnumbers ? $assignmentnumbers + 1 : 100001;

    //         $assignmentgenerate = $assignmentgenerateid . $assignmentnumbers;


    //         if (DB::table('assignmentmappings')->where('assignmentgenerate_id', $assignmentgenerate)->exists()) {
    //             return back()->with('success', ['msg' => 'You have already created assignment.']);
    //         }

    //         // Insert into assignmentbudgetings
    //         DB::table('assignmentbudgetings')->insert([
    //             'client_id' => $client_id,
    //             'assignment_id' => $assignment_id,
    //             'assignmentname' => $assignmentname,
    //             'duedate' => $data['duedate'],
    //             'created_by' => $data['created_by'],
    //             'assignmentgenerate_id' => $assignmentgenerate,
    //             'assignmentnumber' => $assignmentnumbers,
    //             'created_at' => now(),
    //             'updated_at' => now()
    //         ]);

    //         // Insert into assignmentmappings
    //         $id = DB::table('assignmentmappings')->insertGetId([
    //             'assignmentgenerate_id' => $assignmentgenerate,
    //             'periodstart' => $request->periodstart,
    //             'periodend' => $request->periodend,
    //             'year' => Carbon::parse($request->periodend)->year,
    //             'roleassignment' => $request->roleassignment,
    //             'assignment_id' => $assignment_id,
    //             'esthours' => $request->esthours,
    //             'independenceform' => 2,
    //             'leadpartner' => $request->leadpartner,
    //             'otherpartner' => $request->otherpartner,
    //             'stdcost' => $request->stdcost,
    //             'estcost' => $request->estcost,
    //             'filecreationdate' => now()->format('Y-m-d'),
    //             'modifieddate' => now()->format('Y-m-d'),
    //             'auditcompletiondate' => now()->format('Y-m-d'),
    //             'documentationdate' => now()->format('Y-m-d'),
    //             'created_at' => now(),
    //             'updated_at' => now()
    //         ]);

    //         $assignment_name = Assignment::where('id', $request->assignment_id)->select('assignment_name')->pluck('assignment_name')->first();

    //         $assignmentbudgetingDatas = DB::table('assignmentmappings')
    //             ->where('assignmentgenerate_id', $assignmentgenerate)
    //             ->select(
    //                 'assignmentmappings.*',
    //             )
    //             ->first();

    //         // Insert into assignmentteammappings
    //         if ($request->teammember_id != '0') {
    //             foreach ($request->teammember_id as $key => $teammember_id) {
    //                 DB::table('assignmentteammappings')->insert([
    //                     'assignmentmapping_id' => $id,
    //                     'type' => $request->type[$key],
    //                     'teammember_id' => $teammember_id,
    //                     'created_at' => now(),
    //                     'updated_at' => now()
    //                 ]);
    //             }

    //             $clientname = DB::table('clients')->where('id', $client_id)->first(['client_name', 'client_code']);
    //             $teamemailpartner = DB::table('teammembers')->where('id', $request->leadpartner)->first(['emailid', 'team_member', 'staffcode']);
    //             $teamemailotherpartner = DB::table('teammembers')->where('id', $request->otherpartner)->first(['emailid', 'team_member', 'staffcode']);

    //             $teamleader = DB::table('assignmentteammappings')
    //                 ->where('assignmentmapping_id', $id)
    //                 ->where('assignmentteammappings.type', 0)
    //                 ->join('teammembers', 'teammembers.id', '=', 'assignmentteammappings.teammember_id')
    //                 ->select('teammembers.team_member', 'teammembers.staffcode')
    //                 ->get();

    //             $teamemails = DB::table('teammembers')->whereIn('id', $request->teammember_id)->pluck('emailid');

    //             // Mail for employees
    //             foreach ($teamemails as $emailid) {
    //                 $this->sendAssignmentEmail([
    //                     'assignmentid' => $assignmentgenerate,
    //                     'clientname' => $clientname->client_name,
    //                     'clientcode' => $clientname->client_code,
    //                     'assignmentname' => $assignmentname,
    //                     'assignment_name' => Assignment::where('id', $assignment_id)->value('assignment_name'),
    //                     'emailid' => $emailid,
    //                     'otherpatner' => $teamemailotherpartner,
    //                     'assignmentpartner' => $teamemailpartner,
    //                     'teamleader' => $teamleader,
    //                     'periodend' => $assignmentbudgetingDatas->periodend,
    //                     'assignmentgenerate' => $assignmentgenerate,
    //                 ]);
    //             }

    //             // Mail for leadpartner
    //             if ($request->leadpartner) {
    //                 $this->sendAssignmentEmail([
    //                     'assignmentid' => $assignmentgenerate,
    //                     'clientname' => $clientname->client_name,
    //                     'clientcode' => $clientname->client_code,
    //                     'assignmentname' => $assignmentname,
    //                     'assignment_name' => Assignment::where('id', $assignment_id)->value('assignment_name'),
    //                     'emailid' => $teamemailpartner->emailid,
    //                     'otherpatner' => $teamemailotherpartner,
    //                     'assignmentpartner' => $teamemailpartner,
    //                     'teamleader' => $teamleader,
    //                     'periodend' => $assignmentbudgetingDatas->periodend,
    //                     'assignmentgenerate' => $assignmentgenerate,
    //                 ]);
    //             }

    //             // Mail for otherpartner
    //             if ($request->otherpartner) {
    //                 $this->sendAssignmentEmail([
    //                     'assignmentid' => $assignmentgenerate,
    //                     'clientname' => $clientname->client_name,
    //                     'clientcode' => $clientname->client_code,
    //                     'assignmentname' => $assignmentname,
    //                     'assignment_name' => Assignment::where('id', $assignment_id)->value('assignment_name'),
    //                     'emailid' => $teamemailotherpartner->emailid,
    //                     'otherpatner' => $teamemailotherpartner,
    //                     'assignmentpartner' => $teamemailpartner,
    //                     'teamleader' => $teamleader,
    //                     'periodend' => $assignmentbudgetingDatas->periodend,
    //                     'assignmentgenerate' => $assignmentgenerate,
    //                 ]);
    //             }
    //         }
    //         // Log activity
    //         $actionName = class_basename($request->route()->getActionName());
    //         $pagename = substr($actionName, 0, strpos($actionName, "Controller"));
    //         $id = auth()->user()->teammember_id;

    //         DB::table('activitylogs')->insert([
    //             'user_id' => $id,
    //             'ip_address' => $request->ip(),
    //             'activitytitle' => $pagename,
    //             'description' => 'New Assignment Mapping Added ( ' . Assignment::where('id', $assignment_id)->value('assignment_name') . ' )',
    //             'created_at' => now(),
    //             'updated_at' => now()
    //         ]);

    //         $output = [
    //             'msg' => "Created Successfully <strong>Client Name:</strong> {$clientname->client_name} <strong>Assignment:</strong> {$assignment_name} <strong>Assignment Name:</strong> {$assignmentname} <strong>Assignment Id:</strong> {$assignmentgenerate}"
    //         ];
    //         return redirect('assignmentbudgeting')->with('success', $output);
    //     }
    // }


    public function store(Request $request)
    {

        $request->validate([
            'client_id' => "required",
            'assignment_id' => "required",
            'teammember_id.*' => "required",
            'assignmentname' => "required",
            'type.*' => "required"
        ]);
        // Assignment budgeting start 
        $client_id = $request->input('client_id', null);
        $assignment_id = $request->input('assignment_id', null);
        $assignmentname = $request->input('assignmentname', null);

        if ($client_id != null && $assignment_id != null  && $assignmentname != null) {

            $data = $request->except(['_token', 'periodstart', 'periodend', 'roleassignment', 'esthours', 'stdcost', 'estcost', 'fees', 'leadpartner', 'otherpartner', 'teammember_id', 'type']);
            $data['created_by'] = auth()->user()->id;
            $clientcode = DB::table('clients')->where('id', $request->client_id)->first();
            $assignmentgenerateid = strtoupper(substr($clientcode->client_name, 0, 3));


            $assign = Assignmentbudgeting::latest()->get();

            if ($assign->isEmpty()) {
                $assignmentnumbers = '100001';
            } else {
                $assignmentgenerateall = DB::table('assignmentmappings')->pluck('assignmentgenerate_id')->toArray();

                function extractDigits($string)
                {
                    preg_match_all('/\d+/', $string, $matches);
                    return implode('', $matches[0]);
                }
                $assignmentNumbersDigits = array_map(function ($assignmentgenerate_id) {
                    return extractDigits($assignmentgenerate_id);
                }, $assignmentgenerateall);

                $minAssignmentNumber = 100001;
                $maxAssignmentNumber = 100529;

                $allPossibleAssignmentNumbers = range($minAssignmentNumber, $maxAssignmentNumber);
                $missingAssignmentNumbers = array_diff($allPossibleAssignmentNumbers, $assignmentNumbersDigits);
                unset($missingAssignmentNumbers[260]);


                // if (!empty($missingAssignmentNumbers)) {
                if (!empty($missingAssignmentNumbers)) {
                    $keys = array_keys($missingAssignmentNumbers);
                    $assignmentnumbers = $missingAssignmentNumbers[$keys[0]];
                } else {
                    // $assignmentnumb = Assignmentbudgeting::latest()->first()->assignmentnumber;
                    // dd($assignmentnumb);

                    $assignmentnumb = Assignmentbudgeting::max('assignmentnumber');

                    if ($assignmentnumb ==  null) {
                        $assignmentnumbers = '100001';
                    } else {
                        $assignmentnumbers = $assignmentnumb + 1;

                        $previouschck = DB::table('assignmentbudgetings')
                            ->where('assignmentnumber', $assignmentnumbers)
                            ->first();

                        if ($previouschck != null) {
                            $output = array('msg' => 'You already created assignment.');
                            return back()->with('success', $output);
                        }
                    }
                }
            }
            // dd($assignmentnumbers);
            $assignmentgenerate = $assignmentgenerateid . $assignmentnumbers;

            if (!empty($missingAssignmentNumbers)) {
                $previouschck = DB::table('assignmentmappings')
                    ->where('assignmentgenerate_id', $assignmentgenerate)
                    ->first();

                if ($previouschck != null) {
                    $output = array('msg' => 'You have already created assignment.');
                    return back()->with('success', $output);
                }
            }

            // Storage::disk('s3')->makeDirectory($assignmentgenerate);
            $data['assignmentgenerate_id'] = $assignmentgenerate;
            $data['assignmentnumber'] = $assignmentnumbers;



            DB::table('assignmentbudgetings')->insert([
                'client_id' => $data['client_id'],
                'assignment_id' => $data['assignment_id'],
                'assignmentname' => $data['assignmentname'],
                'duedate' => $data['duedate'],
                'created_by' => $data['created_by'],
                'assignmentgenerate_id' => $data['assignmentgenerate_id'],
                'assignmentnumber' => $data['assignmentnumber'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
        // Assignment budgeting end


        $assignment_name = Assignment::where('id', $request->assignment_id)->select('assignment_name')->pluck('assignment_name')->first();

        $request->except(['_token']);

        $id = DB::table('assignmentmappings')->insertGetId([
            'assignmentgenerate_id'         =>     $assignmentgenerate,
            'periodstart'         =>     $request->periodstart,
            'periodend'         =>     $request->periodend,
            'year'         =>     Carbon::parse($request->periodend)->year,
            'roleassignment'                =>      $request->roleassignment,
            'assignment_id'         =>     $request->assignment_id,
            'esthours'            =>       $request->esthours,
            'leadpartner'            =>       $request->leadpartner,
            'otherpartner'            =>       $request->otherpartner,
            'stdcost'            =>       $request->stdcost,
            'estcost'            =>       $request->estcost,
            'filecreationdate'                =>       date('y-m-d'),
            'modifieddate'              =>    date('y-m-d'),
            'auditcompletiondate'                =>       date('y-m-d'),
            'documentationdate'              =>    date('y-m-d'),
            'created_at'                =>       date('y-m-d'),
            'updated_at'              =>    date('y-m-d'),
        ]);

        // if ($request->teammember_id != '0') {
        //     if ($request->teammember_id != null) {
        //         $count = count($request->teammember_id);
        //         // dd($count); die;
        //         for ($i = 0; $i < $count; $i++) {
        //             DB::table('assignmentteammappings')->insert([
        //                 'assignmentmapping_id'       =>     $id,
        //                 'type'       =>     $request->type[$i],
        //                 'teammember_id'       =>     $request->teammember_id[$i],
        //                 'created_at'                =>       date('y-m-d'),
        //                 'updated_at'              =>    date('y-m-d'),
        //             ]);
        //         }
        //     }



        //     $clientname = Client::where('id', $request->client_id)->select('client_name', 'client_code')->first();
        //     $teamemailpartner = DB::table('teammembers')->where('id', $request->leadpartner)->select('emailid', 'team_member', 'staffcode')->first();
        //     $teamemailotherpartner = DB::table('teammembers')->where('id', $request->otherpartner)->select('emailid', 'team_member', 'staffcode')->first();

        //     if ($request->teammember_id != null) {
        //         $teamleader =    DB::table('assignmentteammappings')
        //             ->where('assignmentmapping_id', $id)
        //             ->leftjoin('teammembers', 'teammembers.id', 'assignmentteammappings.teammember_id')
        //             ->select('teammembers.team_member', 'teammembers.staffcode')
        //             ->get();


        //         $teamemail = DB::table('teammembers')->wherein('id', $request->teammember_id)->select('emailid')->get();
        //         // Mail for employee
        //         foreach ($teamemail as $teammember) {
        //             $data = array(
        //                 'assignmentid' =>  $assignmentgenerate,
        //                 'clientname' =>  $clientname->client_name,
        //                 'clientcode' =>  $clientname->client_code,
        //                 'assignmentname' =>  $request->assignmentname,
        //                 'assignment_name' =>  $assignment_name,
        //                 'emailid' =>  $teammember->emailid,
        //                 'otherpatner' =>  $teamemailotherpartner,
        //                 'assignmentpartner' =>  $teamemailpartner,
        //                 'teamleader' =>  $teamleader,

        //             );

        //             $this->sendAssignmentEmail($data);
        //         }
        //     }

        //     // Mail for leadpartner
        //     if ($request->leadpartner !=  null) {
        //         $data = array(
        //             'assignmentid' =>  $assignmentgenerate,
        //             'clientname' =>  $clientname->client_name,
        //             'clientcode' =>  $clientname->client_code,
        //             'assignmentname' =>  $request->assignmentname,
        //             'assignment_name' =>  $assignment_name,
        //             'emailid' =>  $teamemailpartner->emailid,
        //             'otherpatner' =>  $teamemailotherpartner,
        //             'assignmentpartner' =>  $teamemailpartner,
        //             'teamleader' =>  $teamleader,

        //         );

        //         $this->sendAssignmentEmail($data);
        //     }

        //     // Mail for otherpartner
        //     if ($request->otherpartner !=  null) {
        //         $data = array(
        //             'assignmentid' =>  $assignmentgenerate,
        //             'clientname' =>  $clientname->client_name,
        //             'clientcode' =>  $clientname->client_code,
        //             'assignmentname' =>  $request->assignmentname,
        //             'assignment_name' =>  $assignment_name,
        //             'emailid' =>  $teamemailotherpartner->emailid,
        //             'otherpatner' =>  $teamemailotherpartner,
        //             'assignmentpartner' =>  $teamemailpartner,
        //             'teamleader' =>  $teamleader,

        //         );

        //         $this->sendAssignmentEmail($data);
        //     }
        // }

        if (!empty($request->teammember_id) && $request->teammember_id != '0') {
            $teammemberIds = $request->teammember_id;
            if (is_array($teammemberIds) && count($teammemberIds) > 0) {
                foreach ($teammemberIds as $index => $teammemberId) {
                    DB::table('assignmentteammappings')->insert([
                        'assignmentmapping_id' => $id,
                        'type'                 => $request->type[$index],
                        'teammember_id'        => $teammemberId,
                        'created_at'           => date('Y-m-d'),
                        'updated_at'           => date('Y-m-d'),
                    ]);
                }
            }

            $clientname = Client::where('id', $request->client_id)
                ->select('client_name', 'client_code')
                ->first();

            $teamemailpartner = DB::table('teammembers')
                ->where('id', $request->leadpartner)
                ->select('emailid', 'team_member', 'staffcode')
                ->first();

            $teamemailotherpartner = DB::table('teammembers')
                ->where('id', $request->otherpartner)
                ->select('emailid', 'team_member', 'staffcode')
                ->first();

            $teamleader = DB::table('assignmentteammappings')
                ->where('assignmentmapping_id', $id)
                ->leftJoin('teammembers', 'teammembers.id', '=', 'assignmentteammappings.teammember_id')
                ->select('teammembers.team_member', 'teammembers.staffcode')
                ->get();

            if (!empty($teammemberIds)) {
                $teamemails = DB::table('teammembers')
                    ->whereIn('id', $teammemberIds)
                    ->pluck('emailid');

                // Mail for employee
                foreach ($teamemails as $teammemberEmail) {
                    $data = [
                        'assignmentid'      => $assignmentgenerate,
                        'clientname'        => $clientname->client_name,
                        'clientcode'        => $clientname->client_code,
                        'assignmentname'    => $request->assignmentname,
                        'assignment_name'   => $assignment_name,
                        'emailid'           => $teammemberEmail,
                        'otherpatner'       => $teamemailotherpartner,
                        'assignmentpartner' => $teamemailpartner,
                        'teamleader'        => $teamleader,
                    ];

                    $this->sendAssignmentEmail($data);
                }
            }

            // Mail for leadpartner
            if (!empty($request->leadpartner)) {
                $data = [
                    'assignmentid'      => $assignmentgenerate,
                    'clientname'        => $clientname->client_name,
                    'clientcode'        => $clientname->client_code,
                    'assignmentname'    => $request->assignmentname,
                    'assignment_name'   => $assignment_name,
                    'emailid'           => $teamemailpartner->emailid,
                    'otherpatner'       => $teamemailotherpartner,
                    'assignmentpartner' => $teamemailpartner,
                    'teamleader'        => $teamleader,
                ];

                $this->sendAssignmentEmail($data);
            }

            // Mail for otherpartner
            if (!empty($request->otherpartner)) {
                $data = [
                    'assignmentid'      => $assignmentgenerate,
                    'clientname'        => $clientname->client_name,
                    'clientcode'        => $clientname->client_code,
                    'assignmentname'    => $request->assignmentname,
                    'assignment_name'   => $assignment_name,
                    'emailid'           => $teamemailotherpartner->emailid,
                    'otherpatner'       => $teamemailotherpartner,
                    'assignmentpartner' => $teamemailpartner,
                    'teamleader'        => $teamleader,
                ];

                $this->sendAssignmentEmail($data);
            }
        } else {
            $clientname = Client::where('id', $request->client_id)
                ->select('client_name', 'client_code')
                ->first();

            $teamemailpartner = DB::table('teammembers')
                ->where('id', $request->leadpartner)
                ->select('emailid', 'team_member', 'staffcode')
                ->first();

            $teamemailotherpartner = DB::table('teammembers')
                ->where('id', $request->otherpartner)
                ->select('emailid', 'team_member', 'staffcode')
                ->first();


            // Mail for leadpartner
            if (!empty($request->leadpartner)) {
                $data = [
                    'assignmentid'      => $assignmentgenerate,
                    'clientname'        => $clientname->client_name,
                    'clientcode'        => $clientname->client_code,
                    'assignmentname'    => $request->assignmentname,
                    'assignment_name'   => $assignment_name,
                    'emailid'           => $teamemailpartner->emailid,
                    'otherpatner'       => $teamemailotherpartner,
                    'assignmentpartner' => $teamemailpartner,
                ];

                $this->sendAssignmentEmail($data);
            }

            // Mail for otherpartner
            if (!empty($request->otherpartner)) {
                $data = [
                    'assignmentid'      => $assignmentgenerate,
                    'clientname'        => $clientname->client_name,
                    'clientcode'        => $clientname->client_code,
                    'assignmentname'    => $request->assignmentname,
                    'assignment_name'   => $assignment_name,
                    'emailid'           => $teamemailotherpartner->emailid,
                    'otherpatner'       => $teamemailotherpartner,
                    'assignmentpartner' => $teamemailpartner,
                ];

                $this->sendAssignmentEmail($data);
            }
        }


        // please match hare in old code me null aa raha hai kiya 
        $actionName = class_basename($request->route()->getActionname());
        $pagename = substr($actionName, 0, strpos($actionName, "Controller"));
        $id = auth()->user()->teammember_id;
        DB::table('activitylogs')->insert([
            'user_id' => $id,
            'ip_address' => $request->ip(),
            'activitytitle' => $pagename,
            'description' => 'New Assignment Mapping Added' . ' ' . '( ' . $assignment_name . ' )',
            'created_at' => date('y-m-d'),
            'updated_at' => date('y-m-d')
        ]);
        // Assignment assignmentmappings end
        $output = array('msg' => "Created Successfully <strong>Client Name:</strong> $clientname->client_name <strong>Assignment:</strong> $assignment_name <strong>Assignment Name:</strong> $request->assignmentname <strong>Assignment Id:</strong> $assignmentgenerate ");
        return redirect('assignmentbudgeting')->with('success', $output);
    }
//! End hare 
//*

// Start Hare
  // i have faced some problem hare so i have done new code when current week running and monday not update for current week then submit button not came
                    // $timesheetcount = DB::table('timesheets')
                    //     ->where('status', '0')
                    //     ->where('created_by', auth()->user()->teammember_id)
                    //     ->where('date', '<', $getmondaydate->date)
                    //     ->count();

                    // $timesheetcount = DB::table('timesheets')
                    //     ->where('status', '0')
                    //     ->where('created_by', auth()->user()->teammember_id)
                    //     ->where('date', '<', $currentdate)
                    //     ->count();

                    // $timesheetsaved = DB::table('timesheets')
                    //     ->where('status', '0')
                    //     ->where('created_by', auth()->user()->teammember_id)
                    //     ->orderBy('date', 'asc')
                    //     ->first();

                    // $startdateofdata = Carbon\Carbon::createFromFormat('Y-m-d', $timesheetsaved->date ?? '');
                    // $enddateofdata = $startdateofdata->copy()->next(Carbon\Carbon::SATURDAY);

                    // // $timesheetcount = DB::table('timesheets')
                    // //     ->where('status', '0')
                    // //     ->where('created_by', auth()->user()->teammember_id)
                    // //     ->whereBetween('date', [$startdateofdata->format('Y-m-d'), $enddateofdata])
                    // //     ->count();
                    // dd($timesheetcount);

                    // 33333333333

                    $timesheetsaved = DB::table('timesheets')
                        ->where('status', '0')
                        ->where('created_by', auth()->user()->teammember_id)
                        ->orderBy('date', 'asc')
                        ->first();

                    $timesheetcount = 0;

                    if ($timesheetsaved) {
                        $startdateofdata = Carbon\Carbon::parse($timesheetsaved->date);
                        $enddateofdata = $startdateofdata->next(Carbon\Carbon::SATURDAY);

                        $timesheetcount = DB::table('timesheets')
                            ->where('status', '0')
                            ->where('created_by', auth()->user()->teammember_id)
                            ->whereBetween('date', [$startdateofdata->toDateString(), $enddateofdata->toDateString()])
                            ->count();
                    }
// Start Hare
$timesheetcount = DB::table('timesheets')
    ->where('status', '0')
    ->where('created_by', auth()->user()->teammember_id)
    ->orderBy('date', 'asc')
    ->first();

if ($timesheetcount) {
    $startdate1 = Carbon\Carbon::createFromFormat('Y-m-d', $timesheetcount->date);
    $startdate11 = $startdate1->copy()->next(Carbon\Carbon::SUNDAY);

    $alldata = DB::table('timesheets')
        ->where('status', '0')
        ->where('created_by', auth()->user()->teammember_id)
        ->whereBetween('date', [$startdate1->toDateString(), $startdate11->toDateString()]) // Convert to string format
        ->orderBy('date', 'asc')
        ->first();

    dd($startdate11->toDateString()); // Debug the formatted string
} else {
    dd('No timesheet data found!');
}

//! End hare 
//* accending order 
->orderBy('attendances.year', 'desc')   // Order by year descending
->orderByRaw("FIELD(attendances.month, 'December', 'November', 'October', 'September', 'August', 'July', 'June', 'May', 'April', 'March', 'February', 'January')"); // Order months in descending order

$query->orderBy('attendances.year', 'desc')
->orderBy(DB::raw('MONTH(STR_TO_DATE(CONCAT(attendances.month, " 1, 2000"), "%M %d, %Y"))'), 'desc');

// Start Hare
//! End hare 
//* regarding excell / excell / all updated code in excell code folder also 
// Start Hare
//*regarding limit 
// Start Hare

class LargeCSVImport implements ToModel, WithChunkReading, WithHeadingRow
{
    private $rowCount = 0; // Initialize row count

    public function model(array $row)
    {
        // Stop import after 10 rows
        if ($this->rowCount >= 10) {
            return null;
        }

        $this->rowCount++; // Increment row count

        return new AllModelTest([
            'servicename' => $row['client_nameaaa'],
            'brif' => $row['client_codeaaa'],
        ]);
    }

    public function chunkSize(): int
    {
        return 10; // Read in chunks of 10 rows
    }
}

// Start Hare

 //*

 <?php

 namespace App\Imports;
 
 use App\Models\AllModelTest;
 use Maatwebsite\Excel\Concerns\WithHeadingRow;
 use Maatwebsite\Excel\Concerns\OnEachRow;
 use Maatwebsite\Excel\Row;
 
 class LargeCSVImport implements OnEachRow, WithHeadingRow
 {
     private $rowCount = 0;
 
     public function onRow(Row $row)
     {
         if ($this->rowCount >= 10) {
             return; // Stop processing after 10 rows
         }
 
         $rowData = $row->toArray();
         dd($rowData);
         // Insert row data into the database
         AllModelTest::create([
             'servicename' => $rowData['client_name'],
             'brif' => $rowData['client_code'],
         ]);
 
         $this->rowCount++; // Increment row count
     }
 }
 
     // Start Hare 
     //*
     <?php
 
 namespace App\Imports;
 
 use Illuminate\Support\Collection;
 use Maatwebsite\Excel\Concerns\WithHeadingRow;
 use Maatwebsite\Excel\Concerns\ToCollection;
 
 class LargeCSVImport implements ToCollection, WithHeadingRow
 {
     public function collection(Collection $rows)
     {
         // No need to process here since handling in controller
     }
 }
 
     //*
     <?php
 
 namespace App\Imports;
 
 use App\Models\AllModelTest;
 use Maatwebsite\Excel\Concerns\ToModel;
 use Maatwebsite\Excel\Concerns\WithChunkReading;
 use Maatwebsite\Excel\Concerns\WithHeadingRow;
 use Maatwebsite\Excel\Concerns\ToCollection;
 
 
 
 class LargeCSVImport implements ToCollection, WithHeadingRow
 {
 
 
 
     public function collection(Collection $rows)
     {
         // No need to process here since handling in controller
     }
 }
 
 <?php
 
 namespace App\Imports;
 
 use App\Models\AllModelTest;
 use Maatwebsite\Excel\Concerns\WithHeadingRow;
 use Maatwebsite\Excel\Concerns\ToModel;
 use Maatwebsite\Excel\Concerns\WithChunkReading;
 
 class LargeCSVImport implements ToModel, WithChunkReading, WithHeadingRow
 {
 
         // public function model(array $row)
     // {
     //     // dd($row);
     //     return new AllModelTest([
     //         'servicename' => $row['name'],
     //         'brif' => $row['show_or_hide'],
     //     ]);
     // }
     public function model(array $row)
     {
         dd($row);
         return new AllModelTest([
             'servicename' => $row['client_nameaaa'],
             'brif' => $row['client_codeaaa'],
         ]);
     }
 
     public function chunkSize(): int
     {
         // return 1000;
         return 10;
     }
 }
 
     // Start Hare 
     //*



//! End hare 
//! End hare 
//*
// Start Hare
$attendanceData = DB::table('attendances')
->where('employee_name', auth()->user()->teammember_id)
->whereBetween('fulldate', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')]);
dd($attendanceData);

public function totalworkingdays(Request $request, $teamid)
{

  // $attendanceDates = DB::table('attendances')
  //   ->where('employee_name', $teamid)
  //   ->select(DB::raw('MIN(created_at) as startDate, MAX(created_at) as endDate'))
  //   ->first();

  // // dd($attendanceDates);
  // // $attendancesstartDate = Carbon::parse($attendanceDates->startDate)->format('Y-m-d H:i:s');
  // $attendancesstartDate = Carbon::parse($attendanceDates->startDate)->subSecond(30)->format('Y-m-d H:i:s');
  // // $attendancesendDate = Carbon::parse($attendanceDates->endDate)->addMinutes(2)->format('Y-m-d H:i:s');

  // // find last date of this date $attendanceDates->endDate
  // $attendancesendDate = Carbon::parse($attendanceDates->endDate)->endOfMonth()->setTime(23, 59, 0)->format('Y-m-d H:i:s');



  // total working days start using financial year
  $currentDate = Carbon::now();
  $currentMonth = $currentDate->format('F');
  if ($currentDate->month >= 4) {
    // Current year financial year
    $startDate = Carbon::create($currentDate->year, 4, 1);
    $endDate = Carbon::create($currentDate->year + 1, 3, 31);
  } else {
    // Previous year financial year
    $startDate = Carbon::create($currentDate->year - 1, 4, 1);
    $endDate = Carbon::create($currentDate->year, 3, 31);
  }

  // Calendar Year: January to December of the current year
  $currentDate = Carbon::now();
  $currentMonth = $currentDate->format('F');
  $startDate = Carbon::create($currentDate->year, 1, 1);
  $endDate = Carbon::create($currentDate->year, 12, 31);

  // $startDate = Carbon::create('01-04-2024');
  // $endDate = Carbon::create('30-09-2024');

  // $home = DB::table('timesheetusers')
  //   ->where('createdby', 844)
  //   ->whereIn('status', [1, 2, 3])
  //   ->whereNotIn('assignmentgenerate_id', ['OFF100004', 'OFF100003'])
  //   ->whereNotIn('client_id', [134])
  //   ->whereBetween('timesheetusers.date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
  //   ->select('date') // Select only the date column
  //   ->distinct() // Apply distinct on the selected columns
  //   ->get();

  // dd($home);

  // dd($attendancesstartDate);
  $query = DB::table('timesheetusers')
    ->leftJoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
    ->leftJoin('clients', 'clients.id', 'timesheetusers.client_id')
    ->leftJoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
    ->leftJoin('teammembers as patnerid', 'patnerid.id', 'timesheetusers.partner')
    ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'patnerid.id')
    ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'timesheetusers.assignmentgenerate_id')
    ->select(
      'timesheetusers.*',
      'assignments.assignment_name',
      'clients.client_name',
      'clients.client_code',
      'teammembers.team_member',
      'teammembers.staffcode',
      'patnerid.team_member as patnername',
      'patnerid.staffcode as patnerstaffcode',
      'assignmentbudgetings.assignmentname',
      'teamrolehistory.newstaff_code',
      'assignmentbudgetings.created_at as assignmentcreateddate'
    )
    ->where('timesheetusers.createdby', $teamid)
    ->whereIn('timesheetusers.status', [1, 2, 3])
    // ->whereBetween('timesheetusers.updated_at', [$attendancesstartDate, $attendancesendDate])
    ->whereBetween('timesheetusers.date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
    // hide offholidays and travel timesheet
    // ->whereNotIn('timesheetusers.assignmentgenerate_id', ['OFF100004'])
    ->whereNotIn('timesheetusers.assignmentgenerate_id', ['OFF100004', 'OFF100003'])
    // ->whereNotNull('timesheetusers.assignmentgenerate_id')
    // hide  casual leave and exam leave timesheet
    ->whereNotIn('timesheetusers.client_id', [134])
    ->orderBy('timesheetusers.date', 'DESC');

  // Apply role-specific filters if necessary
  if (auth()->user()->role_id == 13) {
    // Add any specific conditions or modifications for role_id 13 if needed.
  }

  $timesheetData = $query->get();
  // dd($timesheetData);
  return view('backEnd.timesheet.totalworkingdays', compact('timesheetData'));
}
//! End hare 
//* regarding request 
// Start Hare

$data = $request->all();

// Create a copy of the request data to adjust values without modifying the original request
$modifiedData = $data;

// Check if assignment_id contains "OFF100004" and set respective fields to null in $modifiedData
if (in_array('OFF100004', $data['assignment_id'])) {
  // Get the index of 'OFF100004'
  $key = array_search('OFF100004', $data['assignment_id']);

  // Set the respective data to null for this index in the copied array
  $modifiedData['client_id'][$key] = null;      // Set client_id to null
  $modifiedData['assignment_id'][$key] = null;  // Set assignment_id to null
  $modifiedData['partner'][$key] = null;        // Set partner to null
  $modifiedData['workitem'][$key] = null;       // Set workitem to null
  $modifiedData['location'][$key] = null;       // Set location to null
  $modifiedData['hour'][$key] = null;           // Set hour to null
}

dd($request->date);



  // dd($request);
      // if (count($request->assignment_id) >= 2 && in_array('OFF100004', $request->assignment_id)) {
      //   $data = $request->all();
      //   // Check if assignment_id contains "OFF100004" and modify $request directly
      //   if (in_array('OFF100004', $request->assignment_id)) {
      //     // Get the index of 'OFF100004'
      //     $key = array_search('OFF100004', $request->assignment_id);

      //     // Modify the original $request data directly
      //     $request->merge([
      //       'client_id' => array_replace($request->client_id, [$key => null]),
      //       'assignment_id' => array_replace($request->assignment_id, [$key => null]),
      //       'partner' => array_replace($request->partner, [$key => null]),
      //       'workitem' => array_replace($request->workitem, [$key => null]),
      //       'location' => array_replace($request->location, [$key => null]),
      //       'hour' => array_replace($request->hour, [$key => null])
      //     ]);
      //   }
      // }

      if (count($request->assignment_id) >= 2 && in_array('OFF100004', $request->assignment_id)) {
        $data = $request->all();

        // Check if assignment_id contains "OFF100004" and modify $request directly
        if (in_array('OFF100004', $request->assignment_id)) {
          // Get the index of 'OFF100004'
          $key = array_search('OFF100004', $request->assignment_id);

          // Modify the original $request data directly
          $request->merge([
            'client_id' => array_replace($request->client_id, [$key => null]),
            'assignment_id' => array_replace($request->assignment_id, [$key => null]),
            'partner' => array_replace($request->partner, [$key => null]),
            'workitem' => array_replace($request->workitem, [$key => null]),
            'location' => array_replace($request->location, [$key => null]),
            'hour' => array_replace($request->hour, [$key => null])
          ]);
        }

        // Filter out null values for each field
        $request->merge([
          'client_id' => array_filter($request->client_id),
          'assignment_id' => array_filter($request->assignment_id),
          'partner' => array_filter($request->partner),
          'workitem' => array_filter($request->workitem),
          'location' => array_filter($request->location),
          'hour' => array_filter($request->hour)
        ]);
      }



$request = $request->all();


// dd($data);
// Check if assignment_id contains "OFF100004"
if (in_array('OFF100004', $request['assignment_id'])) {
  // Get the index of 'OFF100004'
  $key = array_search('OFF100004', $request['assignment_id']);

  // Set the respective data to null for this index
  $request['client_id'][$key] = null;      // Set client_id to null
  $request['assignment_id'][$key] = null;  // Set assignment_id to null
  $request['partner'][$key] = null;        // Set partner to null
  $request['workitem'][$key] = null;       // Set workitem to null
  $request['location'][$key] = null;       // Set location to null
  $request['hour'][$key] = null;           // Set hour to null
}

dd($request->date);

$a = DB::table('timesheetusers')->insert([
  'date'     =>     $request->date,
  'client_id'     =>     $request->client_id[$i],
  'assignmentgenerate_id'     =>     $request->assignment_id[$i],
  'workitem'     =>     $request->workitem[$i],
  'location'     =>     $request->location[$i],
  //   'billable_status'     =>     $request->billable_status[$i],
  'date'     =>     date('Y-m-d', strtotime($request->date)),
  'hour'     =>     $request->hour[$i],
  'totalhour' =>      $request->totalhour,
  'partner'     =>     $request->partner[$i],
  'created_at'          =>     date('Y-m-d H:i:s'),
  'updated_at'              =>    date('Y-m-d H:i:s'),
]);



if (count($request->assignment_id) >= 2 && in_array('OFF100004', $request->assignment_id)) {
  $data = $request->all();
  // Check if assignment_id contains "OFF100004" and modify $request directly
  if (in_array('OFF100004', $request->assignment_id)) {
    // Get the index of 'OFF100004'
    $key = array_search('OFF100004', $request->assignment_id);

    // Modify the original $request data directly
    $request->merge([
      'client_id' => array_replace($request->client_id, [$key => null]),
      'assignment_id' => array_replace($request->assignment_id, [$key => null]),
      'partner' => array_replace($request->partner, [$key => null]),
      'workitem' => array_replace($request->workitem, [$key => null]),
      'location' => array_replace($request->location, [$key => null]),
      'hour' => array_replace($request->hour, [$key => null])
    ]);
  }
}

dd($request);
// Start Hare
//! End hare 
//* regarding storage folder / regarding upload image / regarding upload file 
// Start Hare

// Start Hare regarding assignment
  // +request: Symfony\Component\HttpFoundation\InputBag {#52
    //   #parameters: array:2 [
    //     "cid" => "191"
    //     "datepickers" => "07-03-2025"
    //   ]
    // }
    $datepickers = "07-04-2025";
    $cid = 191;

    $selectedDate = \DateTime::createFromFormat('d-m-Y', $datepickers);
    $hishahid = DB::table('assignmentbudgetings')
      ->select(
        'assignmentbudgetings.assignmentgenerate_id',
        'assignments.assignment_name',
        'assignmentbudgetings.assignmentname'
      )
      ->where('assignmentbudgetings.client_id',  $cid)
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

    dd($hishahid);
// all file using from hare  storage\app\public\image\task\bank1.xlsx 

// Start Hare
public function importLargeCSV()
{
    try {
        Excel::import(new LargeCSVImport, storage_path('app\public\image\task\bank1.xlsx'));
        return "Data imported successfully!";
    } catch (Exception $e) {
        return "Error: " . $e->getMessage();
    }
}
// Start Hare
//! End hare 
//* regarding attendance / attendance delete
// Start Hare optimize version 
$monthsWithDays = [
  'August' => 31,
  'September' => 30,
  'October' => 31,
  'December' => 31,
];

$updatedRecordsCount = 0;

foreach ($monthsWithDays as $month => $days) {
  $updatedRecordsCount += DB::table('attendances')
    ->where('month', $month)
    ->whereNull('total_no_of_days')
    ->update(['total_no_of_days' => $days]);
}

dd($updatedRecordsCount);
// Start Hare
$recordsWithDays1 = DB::table('attendances')
->where('month', 'October')
->whereNull('total_no_of_days')
->get();

$recordsWithDays2 = DB::table('attendances')
->where('month', 'September')
->whereNull('total_no_of_days')
->get();

$recordsWithDays3 = DB::table('attendances')
->where('month', 'August')
->whereNull('total_no_of_days')
->get();

$recordsWithDays4 = DB::table('attendances')
->where('month', 'December')
->whereNull('total_no_of_days')
->get();

dd($recordsWithDays4);
// Start Hare
 // $nextweektimesheet1 = DB::table('attendances')
    //   ->where('createdby', 844)
    //   ->whereBetween('date', ['2024-11-07', '2024-11-11'])
    //   // ->get();
    //   ->update(['status' => 2]);

    // $attendances = DB::table('attendances')
    //   ->where('month', 'October')
    //   ->where('year', 2024)
    //   ->get();


    // $recordsToDelete = DB::table('attendances')
    //   ->whereIn('month', ['April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'])
    //   ->whereNull('total_no_of_days');

    // $allattendanceDatas = $recordsToDelete->get();


    // dd($allattendanceDatas);

    $recordsWithDays = DB::table('attendances')
      ->whereIn('month', ['April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'])
      ->whereNull('total_no_of_days')
      ->select('month', 'total_no_of_days')
      ->distinct('month')
      ->get();

    dd($recordsWithDays);

    // mujhe total_no_of_days kis month me hai use pta karna hai 
    // $attendances = DB::table('attendances')
    //   ->where('month', 'October')
    //   ->where('year', 2024)
    //   ->get();
// Start Hare
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
$attendence1 = DB::table('attendances')
    ->where('employee_name', $id)
    ->where('year', $exitYear)
    ->whereIn('month', $monthsAfterExitMonth)
    ->get();
// ->delete();

dd($attendence1);
// Start Hare
$attendencedelete1 = DB::table('attendances')
->where('employee_name', $id)
->whereDate('created_at', '>', $request->leavingdate)
->get();

$attendencedelete = DB::table('attendances')
->where('employee_name', $id)
->where(function ($query) use ($exitYear, $exitMonth) {
    $query->where('year', '<', $exitYear)
        ->orWhere(function ($query) use ($exitYear, $exitMonth) {
            $query->where('year', $exitYear)
                ->where('month', '<', $exitMonth);
        });
})
->get();

dd($attendencedelete1);

//! End hare 
public function adminattendancereport(Request $request)
{


    $teamnid = $request->input('teammemberId');
    $startdate = $request->input('startdate');
    $enddate = $request->input('enddate');
    // Convert start date to a date object for accurate comparison
    $startdate = \Carbon\Carbon::parse($startdate);
    $enddate = \Carbon\Carbon::parse($enddate);

    // All teammember 
    $teammembers = DB::table('teammembers')
        ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
        ->whereIn('teammembers.role_id', [14, 15, 13, 11])
        ->select('teammembers.team_member', 'teamrolehistory.newstaff_code', 'teammembers.id', 'teammembers.staffcode')
        ->orderBy('team_member', 'ASC')
        ->get();


    $singleusersearched = DB::table('teammembers')
        ->where('id', $teamnid)
        ->select('team_member', 'staffcode', 'id', 'leavingdate', 'joining_date')
        ->first();
    // dd($singleusersearched);
    // Check if leavingdate exists and is after the startdate
    if ($singleusersearched && $singleusersearched->leavingdate != null) {
        $leavingdate = \Carbon\Carbon::parse($singleusersearched->leavingdate);
        if ($startdate->gt($leavingdate)) {
            // $output = array('msg' => 'You cannot select this user as their leaving date is before the start date.');
            $output = ['msg' => 'You cannot select this user as their leaving date (' . $leavingdate->format('d-m-Y') . ') is before the start date.'];
            // return back()->with('statuss', $output);
            $request->flash();
            return redirect()->to('attendance')->with('statuss', $output);
        }
    }

    if ($singleusersearched && $singleusersearched->joining_date != null) {
        $joiningdate = \Carbon\Carbon::parse($singleusersearched->joining_date);
        if ($joiningdate->gt($enddate)) {
            // $output = array('msg' => 'You cannot select this user as their Joining date is After the end date.');
            $output = ['msg' => 'You cannot select this user as their Joining date (' . $joiningdate->format('d-m-Y') . ') is After the end date.'];
            // return back()->with('statuss', $output);
            $request->flash();
            return redirect()->to('attendance')->with('statuss', $output);
        }
    }

    $query  = DB::table('attendances')
        ->leftjoin('teammembers', 'teammembers.id', 'attendances.employee_name')
        ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
        ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
        ->select('attendances.*', 'teammembers.team_member', 'teammembers.staffcode', 'teamrolehistory.newstaff_code', 'teammembers.employment_status', 'roles.rolename', 'teammembers.joining_date');

    if ($teamnid) {
        $query->where('attendances.employee_name', $teamnid);
    }

    //akshay code
    if ($startdate && $enddate) {
        // Convert the start and end dates to full month names
        $startMonth = Carbon::parse($startdate)->format('F'); // e.g., "January"
        $endMonth = Carbon::parse($enddate)->format('F');     // e.g., "December"

        // Map months to numbers for correct comparison
        $months = [
            'January' => 1,
            'February' => 2,
            'March' => 3,
            'April' => 4,
            'May' => 5,
            'June' => 6,
            'July' => 7,
            'August' => 8,
            'September' => 9,
            'October' => 10,
            'November' => 11,
            'December' => 12,
        ];

        $startMonthNumber = $months[$startMonth];
        $endMonthNumber = $months[$endMonth];

        // Filter by month names by converting the stored string month to its respective number
        $query->whereBetween(DB::raw("FIELD(attendances.month, 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December')"), [$startMonthNumber, $endMonthNumber]);
    }

    //and akshay code 

    // if ($startdate) {
    //     $query->where('applyleaves.leavetype', $startdate);
    // }

    $attendanceDatas = $query->get();
    $request->flash();

    // dd($attendanceDatas);
    return view('backEnd.attendance.adminattendance', compact('attendanceDatas', 'teammembers'));
} 

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
//*

// Start Hare 
$checksavetimesheet = DB::table('timesheetusers')
    ->where('createdby', $id)
    ->where('date', '>', $request->leavingdate)
    ->where('status', 0)
    ->get();

if ($checksavetimesheet->isNotEmpty()) {
    $output = array('msg' => 'Please delete save timesheet after leaving date');
    return back()->with('statuss', $output);
}

// Start Hare 
//* attendance table update after leaving date insert 

// Start Hare 
 // $leavemonth = Carbon::parse($request->leavingdate)->format('F');
                    // $attendances = DB::table('attendances')
                    //     ->where('employee_name', $id)
                    //     ->where('month', $leavemonth)
                    //     ->first();

                    // dd($attendances);
                    // dd($request->leavingdate);


                    // 222222222222222222222222222222222222
                    // $leavemonth = Carbon::parse($request->leavingdate)->format('F');

                    // $attendances = DB::table('attendances')
                    //     ->where('employee_name', $id)
                    //     ->where('month', $leavemonth)
                    //     ->first();

                    // if ($attendances) {
                    //     // Parse the leaving date
                    //     $leavingDate = Carbon::parse($request->leavingdate);


                    //     // Get the day of the month (8 for "2024-10-08")
                    //     $dayOfLeaving = $leavingDate->day;



                    //     // Map of columns from 9th day to 31st day
                    //     $daysToColumns = [
                    //         9 => 'nine',
                    //         10 => 'ten',
                    //         11 => 'eleven',
                    //         12 => 'twelve',
                    //         13 => 'thirteen',
                    //         14 => 'fourteen',
                    //         15 => 'fifteen',
                    //         16 => 'sixteen',
                    //         17 => 'seventeen',
                    //         18 => 'eighteen',
                    //         19 => 'ninghteen',
                    //         20 => 'twenty',
                    //         21 => 'twentyone',
                    //         22 => 'twentytwo',
                    //         23 => 'twentythree',
                    //         24 => 'twentyfour',
                    //         25 => 'twentyfive',
                    //         26 => 'twentysix',
                    //         27 => 'twentyseven',
                    //         28 => 'twentyeight',
                    //         29 => 'twentynine',
                    //         30 => 'thirty',
                    //         31 => 'thirtyone'
                    //     ];




                    //     // Create an array for updating columns
                    //     $updateData = [];

                    //     // Loop through days starting from the day after leaving (9th onwards)
                    //     foreach ($daysToColumns as $day => $column) {
                    //         if ($day >= $dayOfLeaving) {
                    //             $updateData[$column] = 'X'; // Set the leave value (L for leave)
                    //         }
                    //     }



                    //     // Update the attendance record
                    //     DB::table('attendances')
                    //         ->where('id', $attendances->id)
                    //         ->update($updateData);

                    //     dd('Attendance updated successfully!');
                    // } else {
                    //     dd('Attendance record not found for the given month and employee.');
                    // }

                    // 222222222222222222222222222222222222
                    // $leavemonth = Carbon::parse($request->leavingdate)->format('F');

                    // $attendances = DB::table('attendances')
                    //     ->where('employee_name', $id)
                    //     ->where('month', $leavemonth)
                    //     ->first();

                    // if ($attendances) {
                    //     // Parse the leaving date
                    //     $leavingDate = Carbon::parse($request->leavingdate);

                    //     // Get the day of the month (e.g., 2 for "2024-10-02")
                    //     $dayOfLeaving = $leavingDate->day;

                    //     // Map of columns from 9th day to 31st day
                    //     $daysToColumns = [
                    //         1 => 'one',
                    //         2 => 'two',
                    //         3 => 'three',
                    //         4 => 'four',
                    //         5 => 'five',
                    //         6 => 'six',
                    //         7 => 'seven',
                    //         8 => 'eight',
                    //         9 => 'nine',
                    //         10 => 'ten',
                    //         11 => 'eleven',
                    //         12 => 'twelve',
                    //         13 => 'thirteen',
                    //         14 => 'fourteen',
                    //         15 => 'fifteen',
                    //         16 => 'sixteen',
                    //         17 => 'seventeen',
                    //         18 => 'eighteen',
                    //         19 => 'ninghteen',
                    //         20 => 'twenty',
                    //         21 => 'twentyone',
                    //         22 => 'twentytwo',
                    //         23 => 'twentythree',
                    //         24 => 'twentyfour',
                    //         25 => 'twentyfive',
                    //         26 => 'twentysix',
                    //         27 => 'twentyseven',
                    //         28 => 'twentyeight',
                    //         29 => 'twentynine',
                    //         30 => 'thirty',
                    //         31 => 'thirtyone'
                    //     ];

                    //     // Create an array for updating columns
                    //     $updateData = [];

                    //     // Loop through days starting from the day after the leaving date
                    //     foreach ($daysToColumns as $day => $column) {
                    //         if ($day > $dayOfLeaving) { // Start updating from the day after leaving
                    //             $updateData[$column] = 'X'; // Set the leave value (X for leave)
                    //         }
                    //     }

                    //     // Update the attendance record
                    //     DB::table('attendances')
                    //         ->where('id', $attendances->id)
                    //         ->update($updateData);

                    //     dd('Attendance updated successfully!');
                    // } else {
                    //     dd('Attendance record not found for the given month and employee.');
                    // }

                    // 222222222222222222222222222222222222
                    $leavemonth = Carbon::parse($request->leavingdate)->format('F');
                    $year = Carbon::parse($request->leavingdate)->year;

                    // Fetch the attendance record
                    $attendances = DB::table('attendances')
                        ->where('employee_name', $id)
                        ->where('month', $leavemonth)
                        ->first();

                    if ($attendances) {
                        // Parse the leaving date
                        $leavingDate = Carbon::parse($request->leavingdate);

                        // Get the day of the month (e.g., 2 for "2024-10-02")
                        $dayOfLeaving = $leavingDate->day;

                        // Get the total number of days in the month
                        $daysInMonth = $leavingDate->daysInMonth;

                        // Map of columns from the 1st day to the 31st day
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

                        // Create an array for updating columns
                        $updateData = [];

                        // Loop through days starting from the day after the leaving date
                        foreach ($daysToColumns as $day => $column) {
                            if ($day > $dayOfLeaving && $day <= $daysInMonth) { // Update only up to the last day of the month
                                $updateData[$column] = 'X'; // Set the leave value (X for leave)
                            }
                        }

                        // Update the attendance record
                        DB::table('attendances')
                            ->where('id', $attendances->id)
                            ->update($updateData);

                        dd('Attendance updated successfully!');
                    } else {
                        dd('Attendance record not found for the given month and employee.');
                    }

                    // 222222222222222222222222222222222222

                    $exitmonth = Carbon::parse($request->leavingdate)->format('F');
                    $exityear = Carbon::parse($request->leavingdate)->year;

                    // Fetch the attendance record
                    $exitmonthattendances = DB::table('attendances')
                        ->where('employee_name', $id)
                        ->where('month', $exitmonth)
                        ->first();

                    if ($exitmonthattendances) {
                        $exitDate = Carbon::parse($request->leavingdate);
                        // Get the day of the month like 2 for "2024-10-02"
                        $dayOfExit = $exitDate->day;
                        // Get the total number of days in the month
                        $totalDaysInExitMonth = $exitDate->daysInMonth;

                        // Map of columns from the 1st day to the 31st day
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

                        // Create an array for updating columns
                        $updateData = [];
                        // Loop through days starting from the day after the leaving date
                        foreach ($daysToColumns as $day => $column) {
                            // $day => $column  hare if day 1 then column value one
                            // Update only up to the last day of the month
                            if ($day > $dayOfExit && $day <= $totalDaysInExitMonth) {
                                $updateData[$column] = 'XT';
                            }
                        }
                        // checked Updated column hare 
                        // dd($updateData);

                        // Update the attendance record
                        DB::table('attendances')
                            ->where('id', $exitmonthattendances->id)
                            ->update($updateData);


                        dd('Attendance updated successfully!');
                    } else {
                        dd('Attendance record not found for the given month and employee.');
                    }

                    // 222222222222222222222222222222222222
                    // update cross sign after exit date of users 
                    // Delete timesheet records after the exit date
                    // DB::table('timesheetusers')
                    //     ->where('createdby', $id)
                    //     ->where('date', '>', $request->leavingdate)
                    //     ->where('status', 0)
                    //     ->delete();

                    $exitDate = Carbon::parse($request->leavingdate);
                    $exitMonth = $exitDate->format('F');
                    $exitYear = $exitDate->year;
                    $dayOfExit = $exitDate->day;
                    $totalDaysInExitMonth = $exitDate->daysInMonth;

                    // Check if the attendance record exists for the exit month
                    $exitmonthattendances = DB::table('attendances')
                        ->where('employee_name', $id)
                        ->where('month', $exitMonth)
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
                        }
                    }

                    // Update the attendance record
                    if (!empty($updateData)) {
                        DB::table('attendances')
                            ->where('id', $exitmonthattendances->id)
                            ->update($updateData);
                    }
                    dd('hi');
                    // update cross sign after exit date of users end hare 
                    // 222222222222222222222222222222222222
// Start Hare 
//*

// Start Hare 
        // Parse the leaving date
        $leavingDate = Carbon::parse($request->leavingdate);


        // Get the day of the month (8 for "2024-10-08")
        $dayOfLeaving = $leavingDate->day;
// Start Hare 
//* regarding command list / command schedule list/ command scheduling list / command test 
// Start Hare 
// 1.Temporarily Change the Schedule
$schedule->command('command:Leavetypesupdate')
    ->dailyAt('23:59') // Run every day at 11:59 PM for testing
    ->withoutOverlapping();

// 2.After testing, revert this back to:
$schedule->command('command:Leavetypesupdate')
    ->yearlyOn(12, 31, '23:59')
    ->withoutOverlapping();

 // 3. Add this line end of your command 
    $this->info("Leavetypes updated from $previousYear to $currentYear"); // Debug message
    // When you run the command, it will output:
    // Leavetypes updated from 2024 to 2025


 // 4. run below command point number 2

 # Check Scheduled Commands run or not 
//  1.php artisan schedule:run

# Manually Run the Scheduler
//  2.php artisan command:Leavetypesupdate

//? end hare

// Start Hare 
#Email Notification for Failures or Output
$schedule->command('attendance:calculate')
         ->lastDayOfMonth('18:00')
         ->withoutOverlapping()
         ->emailOutputTo('your-email@example.com');


// Start Hare 
protected function schedule(Schedule $schedule)
{
    // Schedule the 'attendance:calculate' command to run on the 26th of every month
    $schedule->command('attendance:calculate')
        ->monthlyOn(26, '00:00'); // Runs at midnight on the 26th of every month
}

// Start Hare 
// Here is the detailed explanation of each scheduling method along with its application for your attendance:calculate command.

// Frequency Scheduling Methods all
// second related command not support in laravel minute related suport ok 
$schedule->command('attendance:calculate')

    // Custom cron expression
    ->cron('* * * * *'); // Run the task on a custom cron schedule

$schedule->command('attendance:calculate')

    // Run every second
    ->everySecond();

$schedule->command('attendance:calculate')

    // Run every two seconds
    ->everyTwoSeconds();

$schedule->command('attendance:calculate')

    // Run every five seconds
    ->everyFiveSeconds();

$schedule->command('attendance:calculate')

    // Run every ten seconds
    ->everyTenSeconds();

$schedule->command('attendance:calculate')

    // Run every fifteen seconds
    ->everyFifteenSeconds();

$schedule->command('attendance:calculate')

    // Run every twenty seconds
    ->everyTwentySeconds();

$schedule->command('attendance:calculate')

    // Run every thirty seconds
    ->everyThirtySeconds();

$schedule->command('attendance:calculate')

    // Run every minute
    ->everyMinute();

$schedule->command('attendance:calculate')

    // Run every two minutes
    ->everyTwoMinutes();

$schedule->command('attendance:calculate')

    // Run every three minutes
    ->everyThreeMinutes();

$schedule->command('attendance:calculate')

    // Run every four minutes
    ->everyFourMinutes();

$schedule->command('attendance:calculate')

    // Run every five minutes
    ->everyFiveMinutes();

$schedule->command('attendance:calculate')

    // Run every ten minutes
    ->everyTenMinutes();

$schedule->command('attendance:calculate')

    // Run every fifteen minutes
    ->everyFifteenMinutes();

$schedule->command('attendance:calculate')

    // Run every thirty minutes
    ->everyThirtyMinutes();

$schedule->command('attendance:calculate')

    // Run every hour
    ->hourly();

$schedule->command('attendance:calculate')

    // Run every hour at 17 minutes past the hour
    ->hourlyAt(17);

$schedule->command('attendance:calculate')

    // Run every odd hour (1, 3, 5, etc.)
    ->everyOddHour();

$schedule->command('attendance:calculate')

    // Run every two hours
    ->everyTwoHours();

$schedule->command('attendance:calculate')

    // Run every three hours
    ->everyThreeHours();

$schedule->command('attendance:calculate')

    // Run every four hours
    ->everyFourHours();

$schedule->command('attendance:calculate')

    // Run every six hours
    ->everySixHours();

$schedule->command('attendance:calculate')

    // Run daily at midnight
    ->daily();

$schedule->command('attendance:calculate')

    // Run daily at 13:00 (1 PM)
    ->dailyAt('13:00');

$schedule->command('attendance:calculate')

    // Run twice daily at 1:00 AM and 1:00 PM
    ->twiceDaily(1, 13);

$schedule->command('attendance:calculate')

    // Run twice daily at 1:15 AM and 1:15 PM
    ->twiceDailyAt(1, 13, 15);

$schedule->command('attendance:calculate')

    // Run weekly on Sunday at 00:00
    ->weekly();

$schedule->command('attendance:calculate')

    // Run every Monday at 8:00 AM
    ->weeklyOn(1, '8:00');

$schedule->command('attendance:calculate')

    // Run monthly on the first day of every month at midnight
    ->monthly();

$schedule->command('attendance:calculate')

    // Run on the 4th day of the month at 15:00 (3:00 PM)
    ->monthlyOn(4, '15:00');

$schedule->command('attendance:calculate')

    // Run monthly on the 1st and 16th at 13:00 (1:00 PM)
    ->twiceMonthly(1, 16, '13:00');

$schedule->command('attendance:calculate')

    // Run on the last day of the month at 15:00 (3:00 PM)
    ->lastDayOfMonth('15:00');

$schedule->command('attendance:calculate')

    // Run on the first day of every quarter at midnight
    ->quarterly();

$schedule->command('attendance:calculate')

    // Run quarterly on the 4th day at 14:00 (2:00 PM)
    ->quarterlyOn(4, '14:00');

$schedule->command('attendance:calculate')

    // Run yearly on the first day of the year at midnight
    ->yearly();

$schedule->command('attendance:calculate')

    // Run yearly on June 1st at 17:00 (5:00 PM)
    ->yearlyOn(6, 1, '17:00');

$schedule->command('attendance:calculate')

    // Set the timezone for the task
    ->timezone('America/New_York');

    $schedule->command('attendance:calculate')

    // Run only on weekdays (Monday to Friday)
    ->weekdays();

$schedule->command('attendance:calculate')

    // Run only on weekends (Saturday and Sunday)
    ->weekends();

$schedule->command('attendance:calculate')

    // Run only on Sunday
    ->sundays();

$schedule->command('attendance:calculate')

    // Run only on Monday
    ->mondays();

$schedule->command('attendance:calculate')

    // Run only on Tuesday
    ->tuesdays();

$schedule->command('attendance:calculate')

    // Run only on Wednesday
    ->wednesdays();

$schedule->command('attendance:calculate')

    // Run only on Thursday
    ->thursdays();

$schedule->command('attendance:calculate')

    // Run only on Friday
    ->fridays();

$schedule->command('attendance:calculate')

    // Run only on Saturday
    ->saturdays();

$schedule->command('attendance:calculate')

    // Run on specific days (e.g., Sunday and Wednesday)
    ->days([0, 3]);

$schedule->command('attendance:calculate')

    // Run between 9:00 AM and 5:00 PM
    ->between('09:00', '17:00');

$schedule->command('attendance:calculate')

    // Do not run between 2:00 AM and 6:00 AM
    ->unlessBetween('02:00', '06:00');

$schedule->command('attendance:calculate')

$schedule->command('command:Leavetypesupdate')
->yearlyOn(12, 31, '23:59')->withoutOverlapping();

    // Run the task only when a certain condition is met
    ->when(function () {
        return true; // Replace with your condition
    });

$schedule->command('attendance:calculate')

    // Run the task only in specific environments (e.g., local, production)
    ->environments(['local', 'production']);



$schedule->command('attendance:calculate')

    // Custom cron expression
    ->cron('* * * * *'); // Run the task on a custom cron schedule

$schedule->command('attendance:calculate')

    // Run every minute
    ->everyMinute();

$schedule->command('attendance:calculate')

    // Run every 2 minutes
    ->everyTwoMinutes();

$schedule->command('attendance:calculate')

    // Run every 5 minutes
    ->everyFiveMinutes();

$schedule->command('attendance:calculate')

    // Run every 10 minutes
    ->everyTenMinutes();

$schedule->command('attendance:calculate')

    // Run every 15 minutes
    ->everyFifteenMinutes();

$schedule->command('attendance:calculate')

    // Run every 30 minutes
    ->everyThirtyMinutes();

$schedule->command('attendance:calculate')

    // Run every hour
    ->hourly();

$schedule->command('attendance:calculate')

    // Run every two hours
    ->everyTwoHours();

$schedule->command('attendance:calculate')

    // Run daily at midnight
    ->daily();

$schedule->command('attendance:calculate')

    // Run daily at a specific time
    ->dailyAt('13:00'); // Example: Runs at 1:00 PM

$schedule->command('attendance:calculate')

    // Run every weekday (Mon-Fri)
    ->weekdays();

$schedule->command('attendance:calculate')

    // Run every Monday
    ->mondays();

$schedule->command('attendance:calculate')

    // Run every Tuesday
    ->tuesdays();

$schedule->command('attendance:calculate')

    // Run every Wednesday
    ->wednesdays();

$schedule->command('attendance:calculate')

    // Run every Thursday
    ->thursdays();

$schedule->command('attendance:calculate')

    // Run every Friday
    ->fridays();

$schedule->command('attendance:calculate')

    // Run every Saturday
    ->saturdays();

$schedule->command('attendance:calculate')

    // Run every Sunday
    ->sundays();

$schedule->command('attendance:calculate')

    // Run on the first day of every month
    ->monthly();

$schedule->command('attendance:calculate')

    // Run on a specific day and time of the month
    ->monthlyOn(1, '15:00'); // Example: Runs on the 1st day of the month at 3:00 PM

$schedule->command('attendance:calculate')

    // Run quarterly (every 3 months)
    ->quarterly();

$schedule->command('attendance:calculate')

    // Run yearly
    ->yearly();

$schedule->command('attendance:calculate')

    // Run hourly but at a specific minute mark
    ->hourlyAt(30); // Runs at 30 minutes past the hour

$schedule->command('attendance:calculate')

    // Run on specific days of the week
    ->days([0, 3]); // Example: Runs on Sunday (0) and Wednesday (3)

$schedule->command('attendance:calculate')

    // Run on the last day of the month
    ->lastDayOfMonth();

$schedule->command('attendance:calculate')

    // Run on the last Friday of the month
    ->lastFridayOfMonth();

$schedule->command('attendance:calculate')

    // Run at 2 PM on the last day of the year
    ->lastDayOfYear()->at('14:00');

// Additional advanced options:

$schedule->command('attendance:calculate')

    // Run every second
    ->everySecond();

$schedule->command('attendance:calculate')

    // Run every two seconds
    ->everyTwoSeconds();

$schedule->command('attendance:calculate')

    // Run every five seconds
    ->everyFiveSeconds();

// Start Hare 
$schedule->command('attendance:calculate')->daily()->withoutOverlapping();

// How withoutOverlapping Works
// When you add withoutOverlapping() to a scheduled task, Laravel prevents the same task from starting again if a previous instance of the task is still running. This is useful when:

// The task takes a long time to complete.
// You don’t want multiple instances of the same task running concurrently, which could lead to performance issues or data conflicts.

// Start Hare 
// App\Console\Kernel.php
protected function schedule(Schedule $schedule)
{
  
    // Schedule the 'attendance:calculate' command to run daily
    $schedule->command('attendance:calculate')
        ->daily()
        ->when(function () {
            return now()->isLastOfMonth(); // Only run on the last day of the month
        });
}
public function handle()
{
    // Ensure the command only runs on the last day of the month
    if (!now()->isLastOfMonth()) {
        $this->info('This command can only run on the last day of the month.');
        return;
    }

    // Rest of your command logic goes here

    $currentDate = now()->subDay(); // Get the previous day from the current date
    $currentMonth = $currentDate->format('F');
    $currentYear = $currentDate->format('Y');

    // Define the start and end of the current month (for the attendance range)
    $attendanceStartDate = Carbon::create($currentYear, $currentDate->format('m'), 1);
    $attendanceEndDate = Carbon::create($currentYear, $currentDate->format('m'))->endOfMonth();
    
    // Calculate total days in the current month
    $totalDays = $attendanceStartDate->diffInDays($attendanceEndDate) + 1;

    // Your attendance processing logic goes here

    return "Attendance updated";
}
// Start Hare 
//* regarding partner and manager 
// Start Hare 

public function totalworkingdays(Request $request, $teamid)
{
  $query = DB::table('timesheetusers')
    ->leftJoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
    ->leftJoin('clients', 'clients.id', 'timesheetusers.client_id')
    ->leftJoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
    ->leftJoin('teammembers as patnerid', 'patnerid.id', 'timesheetusers.partner')
    ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'patnerid.id')
    ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'timesheetusers.assignmentgenerate_id')
    ->select(
      'timesheetusers.*',
      'assignments.assignment_name',
      'clients.client_name',
      'clients.client_code',
      'teammembers.team_member',
      'teammembers.staffcode',
      'patnerid.team_member as patnername',
      'patnerid.staffcode as patnerstaffcode',
      'assignmentbudgetings.assignmentname',
      'teamrolehistory.newstaff_code',
      'assignmentbudgetings.created_at as assignmentcreateddate'
    )
    ->where('timesheetusers.createdby', $teamid)
    ->whereIn('timesheetusers.status', [1, 2, 3])
    ->orderBy('timesheetusers.date', 'DESC');

  // Apply role-specific filters if necessary
  if (auth()->user()->role_id == 13) {
    // Add any specific conditions or modifications for role_id 13 if needed.
  }
  $timesheetData = $query->get();
  return view('backEnd.timesheet.totalworkingdays', compact('timesheetData'));
}
// Start Hare 
//* regarding mysql query /Find emails with duplicate entries/ phpmyadmin / regarding phpmyadmin
// Start Hare
// Start Hare
// Start Hare

// Start Hare
// SELECT id,`team_member` FROM teammembers WHERE leavingdate BETWEEN '2024-04-01' AND '2024-10-31';

// Start Hare
// SELECT id
// FROM teammembers
// WHERE leavingdate BETWEEN '2024-04-01' AND '2024-10-31';

// Start Hare
// -- Step 1: Find emails with duplicate entries

// SELECT email
// FROM users
// GROUP BY email
// HAVING COUNT(*) > 1;

// SELECT DISTINCT email, teammember_id
// FROM users
// WHERE email IN (
//     SELECT email
//     FROM users
//     GROUP BY email
//     HAVING COUNT(*) > 1
// ); 


        // $teammembers = DB::table('teammembers')
        //     ->where('status', 1)
        //     // ->whereIn('id', [770, 772, 806, 943, 835, 940, 938, 916, 947, 805, 944])
        //     // ->whereIn('id', [832])
        //     // ->whereIn('id', [777])
        //     // ->pluck('id')
        //     ->select('team_member')
        //     ->get();

        // dd($teammembers);

   
// end Hare
//* regarding login 
// Start Hare 
  // Fetch the user's status
  $hasUserStatus = DB::table('users')
  ->where('teammember_id', auth()->user()->teammember_id)
  ->where('status', 1)
  ->exists();

if (!$hasUserStatus) {
  Auth::logout();
  return redirect()->route('login')->with('message', 'You have been logged out due to your account inactive.');
}
// Fetch the user's status
$checkuserstatus = DB::table('users')
  ->where('teammember_id', auth()->user()->teammember_id)
  ->first();

if ($checkuserstatus && $checkuserstatus->status == 0) {
  Auth::logout();
  return redirect()->route('login')->with('message', 'You have been logged out due to your account inactive.');
}
// Start Hare 
$checkuserstatus = DB::table('users')
->where('teammember_id', auth()->user()->teammember_id)
->where('status', 1)
->latest()
->first();

dd($checkuserstatus);


// if (!$checkuserstatus) {
//   Auth::logout();
//   return redirect()->route('login')->with('message', 'You have been logged out due to your account inactive.');
// }
// Start Hare 
$checkuserstatus = DB::table('users')
->where('teammember_id', auth()->user()->teammember_id)
->where('status', 1)
->first();

dd($checkuserstatus);
$hasPendingRequests = $checkuserstatus->contains('status', 1);
// Start Hare 

// if (!$hasPendingRequests) {
//   Auth::logout();
//   return redirect()->route('login')->with('message', 'You have been logged out due to your account inactive.');
// }
// Start Hare 
//* regarding attendance 
// Start Hare 
public function index()
{
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
          $totalcountColumn = $totalCountmapping[$checkwording];
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
}
// Start Hare 
public function index()
{
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

  // dd($attendances);
    if ($attendances != null) {
      if (property_exists($attendances, $column)) {

        $checkwording =
          ->where('id', $attendances->id)
          ->value($column);

        $updatewording = 'R';

        if ($checkwording == 'P') {

          $examleavecount = $attendances->no_of_days_present;
          $examleavecountupdate = $examleavecount -= 1;
          $totalcountColumn = "no_of_days_present";
        } elseif ($checkwording == 'CL') {

          $examleavecount = $attendances->casual_leave;
          $examleavecountupdate = $examleavecount -= 1;
          $totalcountColumn = "casual_leave";
        } elseif ($checkwording == 'EL') {

          $examleavecount = $attendances->exam_leave;
          $examleavecountupdate = $examleavecount -= 1;
          $totalcountColumn = "exam_leave";
        } elseif ($checkwording == 'T') {

          $examleavecount = $attendances->travel;
          $examleavecountupdate = $examleavecount -= 1;
          $totalcountColumn = "travel";
        } elseif ($checkwording == 'OH') {

          $examleavecount = $attendances->offholidays;
          $examleavecountupdate = $examleavecount -= 1;
          $totalcountColumn = "offholidays";
        } elseif ($checkwording == 'W') {

          $examleavecount = $attendances->sundaycount;
          $examleavecountupdate = $examleavecount -= 1;
          $totalcountColumn = "sundaycount";
        } elseif ($checkwording == 'H') {

          $examleavecount = $attendances->holidays;
          $examleavecountupdate = $examleavecount -= 1;
          $totalcountColumn = "holidays";
        }
        dd($examleavecountupdate);

        $checkwording = DB::table('attendances')
          ->where('id', $attendances->id)
          ->update([
            $column => $updatewording,
            $totalcountColumn => $examleavecountupdate,
          ]);
      }
    }
    // Attendance code end hare 
}
// Start Hare  this code in 3 way  
if ($attendances && property_exists($attendances, $column)) {
  $checkwording = DB::table('attendances')
      ->where('id', $attendances->id)
      ->value($column);

  if ($checkwording == 'R') {
      $client = $request->client_id;
      $assignmentid = $request->assignment_id;

      // Determine update wording based on client and assignment conditions

    //   regarding match it is syntex of match 
    //   $result = match ($condition) {
    //     condition1 => value1,
    //     condition2 => value2,
    //     default => defaultValue,
    // };
    
      $updatewording = match (true) {
        // Travel
        $client == 32 => 'T',
        // Off holidays
        $client == 33 && str_replace(['1st ', '2nd ', '3rd ', '4th ', '5th '], '', $request->workitem) == 'Saturday' => 'OH',
        // Other holidays from calendar
        $client == 33 => 'H',
        // Casual leave
        $client == 134 && $assignmentid == 215 => 'CL',
        // Exam leave
        $client == 134 && $assignmentid == 214 => 'EL',
          // Default presence
        default => 'P',
      };

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

// Start Hare 2
if ($prevcheck == null) {

  // DB::table('attendances')
  //     ->where('employee_name', auth()->user()->teammember_id)
  //     ->where('month', $month1)
  //     ->update([$dayWord => $updateddata]);

  // Update the total count and attendance record if applicable
  if (isset($totalCountMapping[$updateddata])) {
      $totalcountColumn = $totalCountMapping[$updateddata];
      $totalcountupdate = $attendances->$totalcountColumn + 1;
      // DB::table('attendances')
      //     ->where('id', $attendances->id)
      //     ->update([
      //         $dayWord => $updateddata,
      //         $totalcountColumn => $totalcountupdate,
      //     ]);
      DB::table('attendances')
          ->where('employee_name', auth()->user()->teammember_id)
          ->where('month', $month1)
          ->update([
              $dayWord => $updateddata,
              $totalcountColumn => $totalcountupdate,
          ]);
  }
}

if ($prevcheck == null && isset($totalCountMapping[$updateddata])) {
  $totalcountColumn = $totalCountMapping[$updateddata];
  $sundaycountget = DB::table('attendances')
      ->where('employee_name', auth()->user()->teammember_id)
      ->where('month', $month1)
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
// Start Hare 2

// Helper function to get update wording
function getUpdateWording($client, $assignmentid, $workitem) {
  if ($client == 32) {
      return 'T'; // Travel
  } elseif ($client == 33) {
      $workitem = str_replace(['1st ', '2nd ', '3rd ', '4th ', '5th '], '', $workitem);
      return $workitem == 'Saturday' ? 'OH' : 'H'; // Off holidays or holidays
  } elseif ($client == 134 && $assignmentid == 215) {
      return 'CL'; // Casual leave
  } elseif ($client == 134 && $assignmentid == 214) {
      return 'EL'; // Exam leave
  }
  return 'P'; // Default presence
}

// Helper function to get the total count column based on update wording
function getTotalCountColumn($updatewording) {
  $totalCountMapping = [
      'P' => 'no_of_days_present',
      'CL' => 'casual_leave',
      'EL' => 'exam_leave',
      'T' => 'travel',
      'OH' => 'offholidays',
      'W' => 'sundaycount',
      'H' => 'holidays'
  ];
  return $totalCountMapping[$updatewording] ?? null;
}

// Main code
if ($attendances && property_exists($attendances, $column)) {
  $checkwording = DB::table('attendances')
      ->where('id', $attendances->id)
      ->value($column);

  if ($checkwording == 'R') {
      $client = $request->client_id;
      $assignmentid = $request->assignment_id;
      $workitem = $request->workitem;

      // Get update wording using a helper function
      $updatewording = getUpdateWording($client, $assignmentid, $workitem);

      // Get total count column using a helper function
      $totalcountColumn = getTotalCountColumn($updatewording);

      if ($totalcountColumn) {
          $totalcountupdate = $attendances->$totalcountColumn + 1;

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

// Start Hare 3

$updatewording = 'P'; // Default presence
switch ($client) {
    case 32:
        $updatewording = 'T'; // Travel
        break;
    case 33:
        $workitem = str_replace(['1st ', '2nd ', '3rd ', '4th ', '5th '], '', $request->workitem);
        $updatewording = $workitem == 'Saturday' ? 'OH' : 'H'; // Off holidays or holidays
        break;
    case 134:
        if ($assignmentid == 215) {
            $updatewording = 'CL'; // Casual leave
        } elseif ($assignmentid == 214) {
            $updatewording = 'EL'; // Exam leave
        }
        break;
}

// Start Hare 
$clientAssignmentMap = [
  32 => 'T', // Travel
  33 => $workitem == 'Saturday' ? 'OH' : 'H',
  134 => [
      215 => 'CL', // Casual leave
      214 => 'EL', // Exam leave
  ],
];

$updatewording = $clientAssignmentMap[$client] ?? 'P'; // Default to 'P'
if (is_array($updatewording)) {
  $updatewording = $updatewording[$assignmentid] ?? 'P';
}

// Start Hare 

if ($attendances != null) {
  if (property_exists($attendances, $column)) {

    $checkwording = DB::table('attendances')
      ->where('id', $attendances->id)
      ->value($column);

    if ($checkwording == 'R') {
      $client = $request->client_id;
      $assignmentid = $request->assignment_id;

      if ($client == 32) {
        // Travel
        $updatewording = 'T';
      } elseif ($client == 33) {
        // Assume this is "1th Saturday or 2ndh Saturday or 3rd Saturday or 4th Saturday"
        $workitem = $request->workitem;
        $workitem = str_replace(['1st ', '2nd ', '3rd ', '4th ', '5th '], '', $workitem);
        // Now $workitem should be "Saturday"
        if ($workitem == 'Saturday') {
          // Off holidays only select Saturdays
          $updatewording = 'OH';
        } else {
          // holidays from calaneder
          $updatewording = 'H';
        }
      } elseif ($client == 134 && $assignmentid == 215) {
        // casual leave
        $updatewording = 'CL';
      } elseif ($client == 134 && $assignmentid == 214) {
        // casual leave
        $updatewording = 'EL';
      } else {
        // Default case
        $updatewording = 'P';
      }


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

      if (isset($totalCountmapping[$updatewording])) {
        $totalcountColumn = $totalCountmapping[$updatewording];
        $totalcountupdate = $attendances->$totalcountColumn + 1;
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
}
// Start Hare 
// Start Hare 
// Start Hare 
//* api 
// Start Hare 
public function index()
{
$data['posts']=Post::all();
return response()->json([
  'status'=>true,
  'message'=>'All posts data.',
  'data'=>$data
],200);
}
// Start Hare 
public function generateTwoFactorCode()
{
    $this->timestamps = false;
    $this->two_factor_code = rand(100000, 999999);
    $this->two_factor_expires_at = now()->addMinutes(5);
    $this->save();
}
// Start Hare 
//* regarding filter
// Start Hare 
$teammemberDatas = DB::table('assignmentmappings')
->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
->leftjoin('teammembers', 'teammembers.id', 'assignmentteammappings.teammember_id')
->leftjoin('titles', 'titles.id', 'teammembers.title_id')
->leftjoin('roles', 'roles.id', 'teammembers.role_id')
->where('assignmentmappings.assignmentgenerate_id', $id)
// filter null value hare 
->whereNotNull('assignmentteammappings.id')
->select('teammembers.*', 'roles.rolename', 'assignmentteammappings.type', 'titles.title', 'assignmentteammappings.id As assignmentteammappingsId', 'assignmentteammappings.status as assignmentteammappingsStatus', 'assignmentmappings.assignmentgenerate_id as assignmentgenerateid', 'assignmentteammappings.teamhour', 'assignmentmappings.leadpartner', 'assignmentteammappings.viewerteam')
->orderBy('assignmentteammappingsId', 'desc')
->get();
// Start Hare 
$teammemberDatas = DB::table('assignmentmappings')
    ->leftJoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
    ->leftJoin('teammembers', 'teammembers.id', '=', 'assignmentteammappings.teammember_id')
    ->leftJoin('titles', 'titles.id', '=', 'teammembers.title_id')
    ->leftJoin('roles', 'roles.id', '=', 'teammembers.role_id')
    ->where('assignmentmappings.assignmentgenerate_id', $id)
    ->select(
        'teammembers.*',
        'roles.rolename',
        'assignmentteammappings.type',
        'titles.title',
        'assignmentteammappings.id As assignmentteammappingsId',
        'assignmentteammappings.status as assignmentteammappingsStatus',
        'assignmentmappings.assignmentgenerate_id as assignmentgenerateid',
        'assignmentteammappings.teamhour',
        'assignmentmappings.leadpartner',
        'assignmentteammappings.viewerteam'
    )
    ->orderBy('assignmentteammappingsId', 'desc')
    ->get()
    ->filter(function ($item) {
        return $item->assignmentteammappingsId !== null;
    });


// Start Hare 
//* regarding title 
// Start Hare 

// Start Hare 
//*
// Start Hare 
$partner = Teammember::where('role_id', '=', 13)
->where('status', '=', 1)
->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
->with('title')
->orderBy('team_member', 'asc')
->get();
$pormotionandrejoiningdata = Teammember::leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
->leftJoin('rejoiningsamepost', 'rejoiningsamepost.teammember_id', '=', 'teammembers.id')
->where('teammembers.id', auth()->user()->teammember_id)
->select(
  'teammembers.team_member',
  'teammembers.staffcode',
  'teammembers.joining_date',
  'teamrolehistory.newstaff_code',
  'teamrolehistory.rejoiningdate',
  'rejoiningsamepost.rejoiningdate as samepostrejoiningdate'
)
->first();
// Start Hare 
//* regarding permotions 
// Start Hare 
elseif ($permotioncheck && auth()->user()->role_id == 13) {
  // $timesheetrequestsDatas = DB::table('timesheetrequests')
  //     ->leftjoin('clients', 'clients.id', 'timesheetrequests.client_id')
  //     ->leftjoin('assignments', 'assignments.id', 'timesheetrequests.assignment_id')
  //     ->leftjoin('teammembers', 'teammembers.id', 'timesheetrequests.partner')
  //     ->leftjoin('teammembers as createdby', 'createdby.id', 'timesheetrequests.createdby')
  //     ->where('timesheetrequests.status', 0)
  //     ->whereDate('timesheetrequests.created_at', '<', $permotioncheck->created_at)
  //     ->where(function ($query) {
  //         $query->where('timesheetrequests.partner', auth()->user()->teammember_id)
  //             ->orWhere('timesheetrequests.createdby', auth()->user()->teammember_id);
  //     })
  //     ->select(
  //         'timesheetrequests.*',
  //         'clients.client_name',
  //         'assignments.assignment_name',
  //         'teammembers.team_member',
  //         'teammembers.staffcode',
  //         'createdby.team_member as createdbyauth',
  //         'createdby.staffcode as staffcodeid',
  //     )->get();

  // $timesheetrequestspermotion = DB::table('timesheetrequests')
  //     ->leftjoin('clients', 'clients.id', 'timesheetrequests.client_id')
  //     ->leftjoin('assignments', 'assignments.id', 'timesheetrequests.assignment_id')
  //     ->leftjoin('teammembers', 'teammembers.id', 'timesheetrequests.partner')
  //     ->leftjoin('teammembers as createdby', 'createdby.id', 'timesheetrequests.createdby')
  //     ->leftJoin('teamrolehistory as createdby_history', 'createdby_history.teammember_id', '=', 'createdby.id')
  //     ->where('timesheetrequests.status', 0)
  //     ->whereDate('timesheetrequests.created_at', '>', $permotioncheck->created_at)
  //     ->where(function ($query) {
  //         $query->where('timesheetrequests.partner', auth()->user()->teammember_id)
  //             ->orWhere('timesheetrequests.createdby', auth()->user()->teammember_id);
  //     })
  //     ->select(
  //         'timesheetrequests.*',
  //         'clients.client_name',
  //         'assignments.assignment_name',
  //         'teammembers.team_member',
  //         'teammembers.staffcode',
  //         'createdby.team_member as createdbyauth',
  //         'createdby_history.newstaff_code',
  //     )
  //     ->get();
  // dd($timesheetrequestsDatas);

  // Define the common parts of the query
   // Define the common parts of the query
   $commonQuery = DB::table('timesheetrequests')
   ->leftJoin('clients', 'clients.id', '=', 'timesheetrequests.client_id')
   ->leftJoin('assignments', 'assignments.id', '=', 'timesheetrequests.assignment_id')
   ->leftJoin('teammembers', 'teammembers.id', '=', 'timesheetrequests.partner')
   ->leftJoin('teammembers as createdby', 'createdby.id', '=', 'timesheetrequests.createdby')
   ->where('timesheetrequests.status', 0)
   ->where(function ($query) {
       $query->where('timesheetrequests.partner', auth()->user()->teammember_id)
             ->orWhere('timesheetrequests.createdby', auth()->user()->teammember_id);
   })
   ->select(
       'timesheetrequests.*',
       'clients.client_name',
       'assignments.assignment_name',
       'teammembers.team_member',
       'teammembers.staffcode',
       'createdby.team_member as createdbyauth'
   );

// Get the timesheet requests before and after the promotion date
$timesheetrequestsDatas = (clone $commonQuery)
   ->whereDate('timesheetrequests.created_at', '<', $permotioncheck->created_at)
   ->addSelect('createdby.staffcode as staffcodeid')
   ->get();

$timesheetrequestspermotion = (clone $commonQuery)
   ->leftJoin('teamrolehistory as createdby_history', 'createdby_history.teammember_id', '=', 'createdby.id')
   ->whereDate('timesheetrequests.created_at', '>', $permotioncheck->created_at)
   ->addSelect('createdby_history.newstaff_code')
   ->get();

return view('backEnd.timesheetrequest.index', [
   'timesheetrequestsDatas' => $timesheetrequestsDatas,
   'timesheetrequestspermotion' => $timesheetrequestspermotion,
]);
}
// Start Hare 
//*
// Start Hare 
if ($permotioncheck && auth()->user()->role_id == 13) {
  $baseQuery = DB::table('timesheetrequests')
      ->leftJoin('clients', 'clients.id', '=', 'timesheetrequests.client_id')
      ->leftJoin('assignments', 'assignments.id', '=', 'timesheetrequests.assignment_id')
      ->leftJoin('teammembers', 'teammembers.id', '=', 'timesheetrequests.partner')
      ->leftJoin('teammembers as createdby', 'createdby.id', '=', 'timesheetrequests.createdby')
      ->where('timesheetrequests.status', 0)
      ->where(function ($query) {
          $query->where('timesheetrequests.partner', auth()->user()->teammember_id)
              ->orWhere('timesheetrequests.createdby', auth()->user()->teammember_id);
      })
      ->select(
          'timesheetrequests.*',
          'clients.client_name',
          'assignments.assignment_name',
          'teammembers.team_member',
          'teammembers.staffcode',
          'createdby.team_member as createdbyauth'
      );

  $timesheetrequestsDatas = (clone $baseQuery)->get();

  $timesheetrequestspermotion = (clone $baseQuery)
      ->leftJoin('teamrolehistory as createdby_history', 'createdby_history.teammember_id', '=', 'createdby.id')
      ->whereDate('timesheetrequests.created_at', '>', $permotioncheck->created_at)
      ->addSelect('createdby_history.newstaff_code')
      ->get();

  dd($timesheetrequestspermotion);
}

// Start Hare 
//* regarding echo
// Start Hare 
 // $timesheetrequestspermotion = DB::table('timesheetrequests')
            //     ->leftJoin('clients', 'clients.id', '=', 'timesheetrequests.client_id')
            //     ->leftJoin('assignments', 'assignments.id', '=', 'timesheetrequests.assignment_id')
            //     ->leftJoin('teammembers as partners', 'partners.id', '=', 'timesheetrequests.partner')
            //     ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'partners.id')
            //     ->leftJoin('teammembers as createdby', 'createdby.id', '=', 'timesheetrequests.createdby')
            //     ->where('timesheetrequests.status', 0)
            //     ->whereDate('timesheetrequests.created_at', '>', '2024-07-17')
            // ->whereDate('timesheetrequests.created_at', '>', $permotioncheck->created_at)
            //     ->where(function ($query) {
            //         $query->where('timesheetrequests.partner', auth()->user()->teammember_id)
            //             ->orWhere('timesheetrequests.createdby', auth()->user()->teammember_id);
            //     })
            //     ->select(
            //         'timesheetrequests.id as timesheet_request_id',
            //         'timesheetrequests.*',
            //         'clients.client_name',
            //         'assignments.assignment_name',
            //         'partners.id as partner_id',
            //         'partners.team_member',
            //         'partners.staffcode',
            //         'teamrolehistory.newstaff_code',
            //         'createdby.team_member as createdbyauth',
            //         'createdby.staffcode as staffcodeid'
            //     )
            //     ->get();

            // foreach ($timesheetrequestspermotion as $request) {
            //     echo 'Timesheet Request ID: ' . $request->timesheet_request_id . '<br>';
            //     echo 'New Staff Code: ' . $request->newstaff_code . '<br>';
            //     echo 'Partner ID: ' . $request->partner_id . '<br>';
            //     echo 'Created By Auth: ' . $request->createdbyauth . '<br>';
            //     echo '<br>';
            // }
 
             
            // dd($timesheetrequestspermotion);
            
// Start Hare 
//* resize image / regarding image
// Start Hare 
// Start Hare 
if ($request->hasFile('profilepic')) {
  $avatar = $request->file('profilepic');
  $filename = time() . rand(1, 100) . '.' . $avatar->getClientOriginalExtension();
  // public\backEnd\image\confirmationfile
  $destinationPath = public_path('backEnd/image/teammember/profilepic');
  // Save the image directly without resizing
  $avatar->move($destinationPath, $filename);
  $data['profilepic'] = $filename;
}
// Start Hare 
$assign = Teammember::where('role_id', 14)->latest()->get();
if ($request->hasFile('profilepic')) {
  $avatar = $request->file('profilepic');
  $filename = time() . rand(1, 100) . '.' . $avatar->getClientOriginalExtension();
  Image::make($avatar)->resize(800, 600)->save('backEnd/image/teammember/profilepic/' . $filename);
  $data['profilepic'] = $filename;
}

if ($request->hasFile('addressupload')) {
  $file = $request->file('addressupload');
  $destinationPath = 'backEnd/image/teammember/addressupload';
  $name = time() . $file->getClientOriginalName();
  $s = $file->move($destinationPath, $name);
  //  dd($s); die;
  $data['addressupload'] = $name;
}
// Start Hare 
//* regarding null value handle 
// Start Hare 
$latesttimesheetsubmitted = DB::table('timesheetreport')
    ->where('teamid', auth()->user()->teammember_id)
    ->latest()
    ->first();

$latesttimesheetsubmittedformate = null;
if ($latesttimesheetsubmitted && $latesttimesheetsubmitted->enddate) {
    try {
        $latesttimesheetsubmittedformate = Carbon::createFromFormat('Y-m-d', $latesttimesheetsubmitted->enddate);
    } catch (\Exception $e) {
        // Log the error if the date format is invalid
        Log::error('Invalid date format for enddate: ' . $latesttimesheetsubmitted->enddate);
    }
}

if ($latesttimesheetsubmittedformate && $latesttimesheetsubmittedformate->greaterThan($from)) {
    // Your logic here for when the latest timesheet submission date is greater than the 'from' date
}

$latesttimesheetsubmitted = DB::table('timesheetreport')
->where('teamid', auth()->user()->teammember_id)
->latest()
->first();

// $latesttimesheetsubmittedformate = Carbon::createFromFormat('Y-m-d', $latesttimesheetsubmitted->enddate);

$latesttimesheetsubmittedformate = null;
if ($latesttimesheetsubmitted) {
$latesttimesheetsubmittedformate = $latesttimesheetsubmitted->enddate
  ? Carbon::createFromFormat('Y-m-d', $latesttimesheetsubmitted->enddate)
  : null;
}

// Check if the from date is in the past
if ($latesttimesheetsubmittedformate && $latesttimesheetsubmittedformate->greaterThan($from)) {



$permotioncheck = null;
$datadate = $client_id->created_at
    ? Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $client_id->created_at)
    : null;
$permotiondate = null;

$latesttimesheetsubmitted = DB::table('timesheetreport')
->where('teamid', auth()->user()->teammember_id)
->latest()
->first();

$latesttimesheetsubmittedformate = null;
if ($latesttimesheetsubmitted) {
$latesttimesheetsubmittedformate = Carbon::createFromFormat('Y-m-d', $latesttimesheetsubmitted->enddate);
}

// Check if the from date is in the past
if ($latesttimesheetsubmittedformate && $latesttimesheetsubmittedformate->greaterThan($from)) {
// Check if the from date is in the past
if ($softwarermaked->greaterThan($from)) {
  $output = ['msg' => 'You cannot apply leave before 11-09-2023'];
  return back()->with('statuss', $output);
}

$rejectedtimesheet = DB::table('timesheetusers')
  ->where('createdby', auth()->user()->teammember_id)
  ->where('status', 2)
  ->first();


$rejectedtimesheetformate = null;
if ($rejectedtimesheet) {
  $rejectedtimesheetformate = Carbon::createFromFormat('Y-m-d', $rejectedtimesheet->date);
}

if ($rejectedtimesheetformate && $rejectedtimesheetformate->isSameDay($from)) {

  $output = array('msg' => 'Create Successfully');
  return back()->with('success', $output);
} else {
  $output = ['msg' => 'You cannot apply leave before Submitted timesheet date'];
  return back()->with('statuss', $output);
}
}
// Start Hare 
if (is_null($nextweektimesheet) && is_null($rejoiningchecktimesheet) && is_null($rejoiningDate)) {
  $output = array('msg' => "Fill the Week timesheet After this week: $formattedNextSaturday1");
  dd($output, 2);
  return back()->with('statuss', $output);
}
// Start Hare 
//* regarding middleware 
// Start Hare 
public function __construct()
{
    $this->middleware('auth')->except(['confirmationAccept', 'confirmationauthotp', 'confirmationConfirmhide', 'otpapstore', 'otpapstore_hide', 'indexview', 'confirmationConfirm', 'otpskipconfirmation', 'otpskipconfirmationhide']);
}
// Start Hare 
//* regarding validation / regarding file / regarding validate / regarding image
// Start Hare 
$request->validate([
  'reason' => 'required',
  'file' => 'required|mimes:png,pdf,jpeg,jpg|max:5120',
  'file' => 'nullable|mimes:png,pdf,jpeg,jpg|max:5120',
]);

$request->validate([
  'reason' => 'required',
  'file' => 'nullable|mimes:png,pdf,jpeg,jpg|max:5120',
], [
  'file.max' => 'The file may not be greater than 5 MB.',
]);
// Start Hare 
//*regarding date formate 
// Start Hare 

$recordsToDelete = DB::table('leaveapprove')
->where('teammemberid', 806)
->whereBetween('created_at', ['2024-08-01 00:00:00', '2024-12-05 23:59:59'])
->get();

dd($recordsToDelete);
// Start Hare 

// 12-jul-2024
date('d-M-Y', strtotime($udinData->udindate))
'date' => date('d/m/Y', $unixTimestamp),
'created_at' => $firstDate->format('Y-m-d') . ' ' . now()->format('H:i:s'),
'updated_at' => $firstDate->format('Y-m-d') . ' ' . now()->format('H:i:s'),
// 12-jul-2024


// Start Hare 
//* regarding skip condition 
// Start Hare 

$skipaftertrue = false;
$from = Carbon::createFromFormat('Y-m-d', $request->from);
$to = Carbon::createFromFormat('Y-m-d', $request->to ?? '');
// software created date 
$softwarermaked = Carbon::createFromFormat('Y-m-d', '2023-09-11');
  // Check if the from date is in the past
  if ($latesttimesheetsubmittedformate->greaterThan($from)) {

    // Check if the from date is in the past
    if ($softwarermaked->greaterThan($from)) {
      $output = ['msg' => 'You cannot apply leave before 11-09-2023'];
      return back()->with('statuss', $output);
    }

    $rejectedtimesheet = DB::table('timesheetusers')
      ->where('createdby', auth()->user()->teammember_id)
      ->where('status', 2)
      ->first();


    $rejectedtimesheetformate = null;
    if ($rejectedtimesheet) {
      $rejectedtimesheetformate = Carbon::createFromFormat('Y-m-d', $rejectedtimesheet->date);
    }

    if ($rejectedtimesheetformate && $rejectedtimesheetformate->isSameDay($from)) {
      $skipaftertrue = true;
    } else {
      $output = ['msg' => 'You cannot apply leave before Submitted timesheet date'];
      return back()->with('statuss', $output);
    }
  }
// Start Hare 
//* regarding greater than and less than/ regarding greter than
// Start Hare 
$latestrequest = DB::table('timesheetrequests')
->where('createdby', auth()->user()->teammember_id)
->select('created_at')
->first();

$latestrequesthour = Carbon::parse($latestrequest->created_at);
$currentDateTime = Carbon::now();
// Check if the difference is more than 24 hours
if ($latestrequesthour->diffInHours($currentDateTime) > 24) {
$id = DB::table('timesheetrequests')->insertGetId([
  'partner'     => $request->partner,
  'reason'      => $request->reason,
  'status'      => 0,
  'createdby'   => auth()->user()->teammember_id,
  'created_at'  => now(),
  'updated_at'  => now(),
]);
}
// Start Hare 
if ($from->equalTo($to) && $from->dayOfWeek === Carbon::SUNDAY) {
  $output = ['msg' => 'You cannot apply leave for Sunday'];
  return back()->with('statuss', $output);
}
// Start Hare 
$currentdate = date('Y-m-d');
@if ($currentdate < $timesheetrequest->validate){
  $ssssss='shahid';
}
// Start Hare 
//* regarding log 
// Start Hare 
Log::info('Request Data:', $request->all());
// Start Hare 

// Start Hare 
//*regarding zip file / regarding zip file download /regarding zip download
// Start Hare 
public function zipfile(Request $request, $assignmentfolder_id)
{
    if (auth()->user()->role_id == 11) {
        $generateid = DB::table('assignmentfolders')->where('id', $assignmentfolder_id)->first();
        $fileName = DB::table('assignmentfolderfiles')->where('assignmentfolder_id', $assignmentfolder_id)->get();

        $zipFileName = $generateid->assignmentfoldersname . '.zip';

        $zip = new ZipArchive;

        $zip->open($zipFileName, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        foreach ($fileName as $file) {
            // $filePath = Storage::disk('s3')->url($generateid->assignmentgenerateid . '/' . $file->filesname);
            $filePath = storage_path('app/public/image/task/' . $file->filesname);

            $stream = fopen($filePath, 'r');

            if ($stream) {
                $zip->addFile($stream, $file->filesname);
                fclose($stream);
            } else {
                return '<h1>File Not Found</h1>';
            }
        }

        $zip->close();

        $headers = [
            'Content-Type' => 'application/zip',
            'Content-Disposition' => 'attachment; filename="' . $zipFileName . '"',
        ];

        // Delete the local zip file after sending
        return response()->stream(
            function () use ($zipFileName) {
                readfile($zipFileName);
                unlink($zipFileName);
            },
            200,
            $headers
        );
    } else {

        $generateid = DB::table('assignmentfolders')->where('id', $assignmentfolder_id)->first();
        $fileName = DB::table('assignmentfolderfiles')->where('assignmentfolder_id', $assignmentfolder_id)->get();
        //dd($fileName);

        $zipFileName = $generateid->assignmentfoldersname . '.zip';
        $zip = new ZipArchive;

        if ($zip->open($zipFileName, ZipArchive::CREATE) === TRUE) {
            foreach ($fileName as $file) {
                // Replace storage_path with S3 access method
                // $filePath = Storage::disk('s3')->get($generateid->assignmentgenerateid . '/' . $file->filesname);
                $filePath = storage_path('app/public/image/task/' . $file->filesname);

                if ($filePath) {
                    $zip->addFromString($file->filesname, $filePath);
                } else {
                    return '<h1>File Not Found</h1>';
                }
            }

            $zip->close();
        }

        return response()->download($zipFileName)->deleteFileAfterSend(true);
    }
}

// Start Hare 
public function store(Request $request)
{
    //dd($request);
    $request->validate([
        'particular' => 'required',
        'file' => 'required',
    ]);

    try {
        $data = $request->except(['_token']);
        $files = [];
        if ($request->hasFile('file')) {
            foreach ($request->file('file') as $file) {
                $realname = $file->getClientOriginalName();
                $name = time() . $realname;
                $path = $file->storeAs('public\image\task', $name);
                $files[] = [
                    'name' => $name,
                    'realname' => $realname,
                    'size' => round($file->getSize() / 1024, 2),

                ];
            }
        }
        foreach ($files as $filess) {
            // dd($files); die;
            $s = DB::table('assignmentfolderfiles')->insert([
                'particular' => $request->particular,
                'assignmentgenerateid' => $request->assignmentgenerateid,
                'assignmentfolder_id' =>  $request->assignmentfolder_id,
                'createdby' =>  auth()->user()->teammember_id,
                'filesname' =>  $filess['name'],
                'realname' =>  $filess['realname'],
                'filesize' => $filess['size'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
        //dd($data);
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
// Start Hare 
// resources\views\backEnd\assignmentfolderfile\index.blade.php
{{-- local --}}
{{-- public\storage\image\task\  yaha file ko copy karke rakhe --}}
<td>
    <a target="_blank"
        href="{{ asset('storage/image/task/' . $assignmentfolderData->filesname) }}">
        {{ $assignmentfolderData->realname ?? '' }}
    </a>
</td>
{{-- <td>
    <a target="_blank"
        href="{{ asset('public\image\task' . $assignmentfolderData->filesname) }}">
        {{ $assignmentfolderData->realname ?? '' }}
    </a>
</td> --}}
{{-- <td><a target="blank"
        href="{{ Storage::disk('s3')->temporaryUrl($foldername->assignmentgenerateid . '/' . $assignmentfolderData->filesname, now()->addMinutes(30)) }}">
        {{ $assignmentfolderData->realname ?? '' }}</a></td> --}}
// Start Hare 
//* return responce
// Start Hare 
                // return response()->json([
                //     'success' => true,
                //     'status' => $status,
                //     'clientid' => $clientid,
                //     'debtorid' => $debtorid,
                //     'debtorconfirm' => $debtorconfirm
                // ]);
// Start Hare 
//* regarding crons / regarding cron / regarding mail using cron / regarding job 
// Start Hare 
// app\Console\command
// 1.Create command 

// app\Console\Kernel.php
// 2.register command in kernal file 

// app\Http\Controllers\HomeController.php
// 3.create function like 
public function timesheetnotfillstaffreminder()
{

  $exitCode = Artisan::call('command:timesheetnotfillstaffreminder')->daily();

  return  redirect('/');
}

// routes\web.php
// 4. create route like 
Route::get('/balanceconfirmationreminder', [HomeController::class, 'balanceconfirmationreminder']);
// end hare 

// Start Hare 
// Start Hare 
//* regarding array / insert data in array 
// Start Hare 
if (!empty($missingDates)) {

  $missingDatesString = implode(', ', array_map(function ($date) {
    return Carbon::parse($date)->format('d-m-Y');
  }, $missingDates));
  $missingDatesString = implode(', ', $missingDates);
  dd($missingDatesString);
  $output = array('msg' => "Timesheet rejected Missing dates: $missingDatesString");
  return back()->with('success', $output);
}
// Start Hare 
$result = [930, 797, 779, 777, 917, 910];
$data = [];
foreach ($result as $userId) {
  $sumhour = DB::table('timesheetusers')
    ->where('assignmentgenerate_id', 'WAV100526')
    ->where('createdby', $userId)
    ->sum('totalhour');

  $data[] = $sumhour;
}
dd($data);
//* regarding array
// Start Hare 
// Remove empty values in array
$mailarray = array_filter([$data['email'], $data['secondaryemail'] ?? '']);
if (!empty($mailarray)) {
    foreach ($mailarray as $email) {
        $msg->to($email);
    }
}
// Start Hare 

// array_filter()
$filtered = array_filter($array, function($value) {
    return $value > 5;
});

// collect()
$collection = collect($array);

// pluck()
$names = collect($users)->pluck('name');

// map()
$doubled = collect([1, 2, 3])->map(function ($item, $key) {
    return $item * 2;
});

// reduce()
$total = collect([1, 2, 3])->reduce(function ($carry, $item) {
    return $carry + $item;
}, 0);

// where()
$filtered = collect($users)->where('active', true);

// first()
$first = collect($users)->first();

// last()
$last = collect($users)->last();


// Start Hare 
// array_filter()
$filtered = array_filter($array, function($value) {
    return $value > 5;
});

// collect()
$collection = collect($array);

// pluck()
$names = collect($users)->pluck('name');

// map()
$doubled = collect([1, 2, 3])->map(function ($item, $key) {
    return $item * 2;
});

// reduce()
$total = collect([1, 2, 3])->reduce(function ($carry, $item) {
    return $carry + $item;
}, 0);

// where()
$filtered = collect($users)->where('active', true);

// first()
$first = collect($users)->first();

// last()
$last = collect($users)->last();

// sortBy()
$sorted = collect($users)->sortBy('name');

// keys()
$keys = collect(['name' => 'John', 'age' => 30])->keys();

// values()
$values = collect(['name' => 'John', 'age' => 30])->values();

// flatten()
$flattened = collect(['name' => 'John', 'languages' => ['PHP', 'JavaScript']])->flatten();

// merge()
$merged = collect(['name' => 'John'])->merge(['age' => 30]);

// unique()
$unique = collect([1, 2, 2, 3, 3, 4])->unique();

// reverse()
$reversed = collect([1, 2, 3])->reverse();

// shuffle()
$shuffled = collect([1, 2, 3, 4, 5])->shuffle();

// chunk()
$chunked = collect([1, 2, 3, 4, 5])->chunk(2);



// Start Hare 
//* regarding mail failed
// Start Hare 
// Start Hare 
try {
  Mail::send('emails.assignmentdebtorform', $data, function ($msg) use ($data, $request) {
      $msg->to($data['email']);
      $msg->subject($data['subject']);

      if ($request->teammember_id) {
          $msg->cc($data['teammembermail']);
      }

      // Add CC for additional emails from the input field
      // Add CC for additional emails from the input field
      if ($request->ccmail) {
          $assignEmails = explode(',', $request->ccmail);
          foreach ($assignEmails as $email) {
              $msg->cc(trim($email));
          }
      }
  });

  DB::table('debtors')
      ->where('assignmentgenerate_id', $debtors->assignmentgenerate_id)
      ->where('id', $debtors->id)
      ->update([
          'mailstatus' => 1,
          'status' => 3,
          'updated_at' => now()
      ]);
} catch (Exception $e) {
  // Log the error or handle it as needed
  // For example, you can log the exception to laravel.log
  // or you can notify the administrator about the failure
  \Log::error('Mail sending failed: ' . $e->getMessage());

  // Update mailstatus to 0 in the database
  DB::table('debtors')
      ->where('assignmentgenerate_id', $debtors->assignmentgenerate_id)
      ->where('id', $debtors->id)
      ->update([
          'mailstatus' => 0,
          'updated_at' => now()
      ]);
}
// Start Hare 
//* regarding file upload / regarding img upload / regarding image upload / regarding storage_path / regarding public_path
// Start Hare 
// <td>
// @if ($notificationData && $notificationData->realname)
//     <a href="{{ url('backEnd/image/test/' . $notificationData->attachment) }}"
//         target="blank">
//         {{ $notificationData->realname ?? 'NA' }}
//     </a>
// @else
//     {{ 'NA' }}
// @endif
// </td>

$attachmentPath = '';
$name = '';
if ($request->hasFile('attachment')) {
    $file = $request->file('attachment');
    $realname = $file->getClientOriginalName();
    $name = time() . $realname;
    $attachmentPath = storage_path('app/public/image/' . $name);
    $file->storeAs('public/image', $name);
}
// Start Hare 
$attachmentPath = '';
$name = '';
if ($request->hasFile('attachment')) {
    $file = $request->file('attachment');
    $realname = $file->getClientOriginalName();
    $name = time() . $realname;
    $attachmentPath = public_path('backEnd/image/test/' . $name);
    $file->move('backEnd/image/test', $name);
}
// Start Hare 
    $fileName = '';
    if ($request->hasFile('file')) {
        $file = $request->file('file');
                    // public\backEnd\image\confirmationfile
        $destinationPath = 'backEnd/image/confirmationfile';
        $fileName = $file->getClientOriginalName();
        $file->move($destinationPath, $fileName);
    }

    DB::table('debtorconfirmations')->insert([
        'debtor_id' => $request->debitid,
        'assignmentgenerate_id' => $request->assignmentgenerate_id,
        'remark' => null,
        'amount' => null,
        'file' => $fileName,
        'name' => $debtorconfirm->name,
        'created_at' => date('Y-m-d'),
        'updated_at' => date('Y-m-d'),
    ]);
// Start Hare 
if ($request->hasFile('report')) {
  $file = $request->file('report');
  $destinationPath = 'backEnd/image/report';
  $name = $file->getClientOriginalName();
  $s = $file->move($destinationPath, $name);
  $data['salaryincomefile'] = $name;
  $data['report'] = $name;
}
// Start Hare 
// app\Http\Controllers\AssignmentfolderfileController.php
public function store(Request $request)
{
    // dd(auth()->user()->teammember_id);
    $request->validate([
        'particular' => 'required',
        'file' => 'required',
    ]);

    try {
        $data = $request->except(['_token']);
        $files = [];

        if ($request->hasFile('file')) {
            foreach ($request->file('file') as $file) {
                $name = $file->getClientOriginalName();
                $path = $file->storeAs('public\image\task', $name);
                $files[] = $name;
            }
        }
        foreach ($files as $filess) {
            $s = DB::table('assignmentfolderfiles')->insert([
                'particular' => $request->particular,
                'assignmentgenerateid' => $request->assignmentgenerateid,
                'assignmentfolder_id' => $request->assignmentfolder_id,
                'createdby' => auth()->user()->teammember_id,
                'filesname' => $filess,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
        $output = array('msg' => 'Submit Successfully');
        return back()->with('success', ['message' => $output, 'success' => true]);
    } catch (Exception $e) {
        // dd($e);
        DB::rollBack();
        Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
        report($e);
        $output = array('msg' => $e->getMessage());
        return back()->withErrors($output)->withInput();
    }
}

public function store(Request $request)
{
    // storage\app\public\image\task\Screenshot_2.png
    // dd(auth()->user()->teammember_id);
    $request->validate([
        'particular' => 'required',
        'file' => 'required',
    ]);

    try {
        $data = $request->except(['_token']);
        $files = [];

        if ($request->hasFile('file')) {
            foreach ($request->file('file') as $file) {
                $name = $file->getClientOriginalName();
                $path = $file->storeAs('public\image\task', time() . $name);
                $files[] = $name;
            }
        }
        foreach ($files as $filess) {
            // dd($auth()->user()->teammember_id);
            // dd($files); die;
            $s = DB::table('assignmentfolderfiles')->insert([
                'particular' => $request->particular,
                'assignmentgenerateid' => $request->assignmentgenerateid,
                'assignmentfolder_id' => $request->assignmentfolder_id,
                'createdby' => auth()->user()->teammember_id,
                'filesname' => $filess,
                'filenameunique' => time() . $filess,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
        $output = array('msg' => 'Submit Successfully');
        return back()->with('success', ['message' => $output, 'success' => true]);
    } catch (Exception $e) {
        // dd($e);
        DB::rollBack();
        Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
        report($e);
        $output = array('msg' => $e->getMessage());
        return back()->withErrors($output)->withInput();
    }
}

// Start Hare 
//* regarding compare
// Start Hare 

                    // $assignmentnumb = Assignmentbudgeting::whereBetween('assignmentnumber', [100001, 100526])
                    //     ->max('assignmentnumber');
                    // dd($assignmentnumb);

                    // $assignmentnumb = Assignmentbudgeting::whereBetween('assignmentnumber', [100001, 100526])
                    //     ->latest('assignmentnumber')
                    //     ->value('assignmentnumber');

                    // Find the minimum and maximum assignment numbers within the table
                    $minAssignmentNumber = Assignmentbudgeting::min('assignmentnumber');
                    $maxAssignmentNumber = Assignmentbudgeting::max('assignmentnumber');

                    // Retrieve the highest assignment number within the dynamically determined range
                    $assignmentnumb = Assignmentbudgeting::whereBetween('assignmentnumber', [$minAssignmentNumber, $maxAssignmentNumber])
                        ->orderByDesc('assignmentnumber')
                        ->pluck('assignmentnumber')
                        ->first();

                    dd($assignmentnumb);

                    // Retrieve the highest assignment number within the range
                    $assignmentnumb = Assignmentbudgeting::selectRaw('MAX(assignmentnumber) as max_assignmentnumber')
                        ->whereBetween('assignmentnumber', [100001, 100526])
                        ->value('max_assignmentnumber');

                    dd($assignmentnumb);

                    // Retrieve the highest assignment number within the range
                    $assignmentnumb = DB::table('assignmentbudgetings')
                        ->whereBetween('assignmentnumber', [100001, 100526])
                        ->max('assignmentnumber');

                    dd($assignmentnumb);

                    // Retrieve the highest assignment number within the range
                    $assignmentnumb = Assignmentbudgeting::whereBetween('assignmentnumber', [100001, 100526])
                        ->orderByDesc('assignmentnumber')
                        ->pluck('assignmentnumber')
                        ->first();

                    dd($assignmentnumb);

                    // Retrieve the highest assignment number within the range
                    $assignmentnumb = Assignmentbudgeting::whereBetween('assignmentnumber', [100001, 100526])
                        ->latest('assignmentnumber')
                        ->value('assignmentnumber');

                    dd($assignmentnumb);

                    // Retrieve the highest assignment number within the range
                    $highestAssignmentNumber = Assignmentbudgeting::whereBetween('assignmentnumber', [101, 256])
                        ->max('assignmentnumber');

                    dd($highestAssignmentNumber);
// Start Hare 
//*
// Start Hare 
$affectedRows = DB::table('timesheetreport')
    ->where('teamid', auth()->user()->teammember_id)
    ->where('startdate', $previousMondayFormatted)
    ->orderBy('id') // Assuming there's an 'id' column in your table for sorting
    ->limit(1) // Only update the first row
    ->update(['dayscount' => 1]);
// Start Hare 
//*
// Start Hare 
public function adminsearchtimesheet1(Request $request)
{
  if ($request->ajax()) {
    echo "<option value='0'>Select Assignment</option>";
    foreach (DB::table('assignmentbudgetings')
      ->where('assignmentbudgetings.client_id', $request->cid)
      ->leftJoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
      ->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
      ->orderBy('assignment_name')->get() as $sub) {
      echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentname . ' )' . '( ' . $sub->assignmentgenerate_id . ' )' . "</option>";
    }
  }
}
// Start Hare 
//* regarding partner
// Start Hare 
$leadpartner = DB::table('assignmentmappings')
->join('teammembers as team', 'team.id', 'assignmentmappings.leadpartner')
->where('assignmentmappings.assignmentgenerate_id', $id)
->select('team.id', 'team.team_member', 'assignmentmappings.leadpartnerhour')
->get();


$otherpartner = DB::table('assignmentmappings')
->join('teammembers as team', 'team.id', 'assignmentmappings.otherpartner')
->where('assignmentmappings.assignmentgenerate_id', $id)
->select('team.id', 'team.team_member', 'assignmentmappings.otherpartnerhour')
->get();

$partner = $leadpartner->merge($otherpartner);
dd($partner);
// regarding ?? 
// <td>{{ $partnerData->leadpartnerhour ?? ($partnerData->otherpartnerhour ?? 0) }}
// Start Hare 
//*
// Start Hare 

$distinctteammember = $teammemberDatas->unique('team_member')->sortBy('team_member');
$distinctassignmentid = $teammemberDatas
    ->unique('assignmentgenerate_id')
    ->sortBy('assignmentgenerate_id');
$distinctAssignmentNames = $teammemberDatas
    ->unique('assignmentname')
    ->sortBy('assignmentname');
// Start Hare 
//* regarding collect
// Start Hare 
$teammemberDatas = collect($teammemberDatas);
// Start Hare 
//* regarding Authentication
// Start Hare 
use Illuminate\Support\Facades\Auth;
 
// Retrieve the currently authenticated user...
$user = Auth::user();
 
// Retrieve the currently authenticated user's ID...
$id = Auth::id();
$user = $request->user();
if (Auth::check()) {
  // The user is logged in...
}
Route::get('/flights', function () {
  // Only authenticated users may access this route...
})->middleware('auth');
protected function redirectTo(Request $request): string
{
    return route('login');
}
Route::get('/flights', function () {
  // Only authenticated users may access this route...
})->middleware('auth:admin');

class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     */
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
 
            return redirect()->intended('dashboard');
        }
 
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
}
if (Auth::attempt(['email' => $email, 'password' => $password, 'active' => 1])) {
  // Authentication was successful...
}
if (Auth::attempt(['email' => $email, 'password' => $password], $remember)) {
  // The user is being remembered...
}
if (Auth::viaRemember()) {
  // ...
}
// Start Hare 
//*regarding request 
// Start Hare
$input = $request->all();
$input = $request->collect();
$request->collect('users')->each(function (string $user) {
  // ...
});
$request->merge(['totalhour' => 0]);
$request->mergeIfMissing(['votes' => 0]);
dd($request); 
$name = $request->input('location.1');
$name = $request->input('products.0.name');
 
$names = $request->input('products.*.name');
$input = $request->input();
$name = $request->query('name');
$name = $request->query('name', 'Helen');
$name = $request->input('user.name');
$name = $request->string('name')->trim();
$archived = $request->boolean('archived');
$birthday = $request->date('birthday');
$elapsed = $request->date('elapsed', '!H:i', 'Europe/Madrid');
$name = $request->name;
$input = $request->only(['username', 'password']);
 
$input = $request->only('username', 'password');
 
$input = $request->except(['credit_card']);
 
$input = $request->except('credit_card');
if ($request->has('name')) {
  // ...
}
if ($request->has(['name', 'email'])) {
  // ...
}
if ($request->hasAny(['name', 'email'])) {
  // ...
}
$request->whenHas('name', function (string $input) {
  // ...
});
$request->whenHas('name', function (string $input) {
  // The "name" value is present...
}, function () {
  // The "name" value is not present...
});
if ($request->filled('name')) {
  // ...
}
if ($request->anyFilled(['name', 'email'])) {
  // ...
}
$request->whenFilled('name', function (string $input) {
  // ...
});
$request->whenFilled('name', function (string $input) {
  // The "name" value is filled...
}, function () {
  // The "name" value is not filled...
});

if ($request->missing('name')) {
  // ...
}

$request->whenMissing('name', function (array $input) {
  // The "name" value is missing...
}, function () {
  // The "name" value is present...
});
// Start Hare 

//* regarding saturday 
// Start Hare 
public function holidaysselect(Request $request)
{
  if ($request->ajax()) {

    $selectedDate = date('Y-m-d', strtotime($request->datepickers));
    // Get the day of the week (0 for Sunday, 6 for Saturday)
    $dayOfWeek = date('w', strtotime($selectedDate));
    if ($dayOfWeek == 6) {
      // Get the day of the month
      $dayOfMonth = date('j', strtotime($selectedDate));
      // Calculate which Saturday of the month it is
      $saturdayNumber = ceil($dayOfMonth / 7);
      if ($saturdayNumber == 1.0) {
        $saturday = '1st Saturday';
      } elseif ($saturdayNumber == 2.0) {
        $saturday = '2nd Saturday';
      } elseif ($saturdayNumber == 3.0) {
        $saturday = '3rd Saturday';
      } elseif ($saturdayNumber == 4.0) {
        $saturday = '4th Saturday';
      } elseif ($saturdayNumber == 5.0) {
        $saturday = '5th Saturday';
      }
    }

    $holidayname = DB::table('holidays')->where('startdate', $selectedDate)->select('holidayname')->first();
    $selectassignment = DB::table('assignmentbudgetings')->where('client_id', $request->cid)
      ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
      ->orderBy('assignment_name')->first();
    $selectpartner = DB::table('assignmentmappings')
      ->leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
      ->where('assignmentmappings.assignmentgenerate_id', $selectassignment->assignmentgenerate_id)
      ->select('teammembers.team_member', 'teammembers.id')
      ->first();

    return response()->json([
      'holidayName' => $holidayname->holidayname ?? 'null',
      'saturday' => $saturday ?? 'null',
      'assignmentid' => $selectassignment->id,
      'assignmentgenerate_id' => $selectassignment->assignmentgenerate_id,
      'assignmentname' => $selectassignment->assignmentname,
      'assignment_name' => $selectassignment->assignment_name,
      'team_member' => $selectpartner->team_member,
      'team_memberid' => $selectpartner->id,
    ]);
  }
}
// Start Hare 
//* regarding abort() / regarding abort function 
// Start Hare 
// 1. Abort with a 404 HTTP Response:
abort(404);

// 2. Abort with a Custom HTTP Response Code and Message:
abort(403, 'Unauthorized access');

// 3. Abort with a Custom HTTP Response Code and Message using a HTTP Response Object:
abort(response('Unauthorized access', 403));

// 4. Abort with a Custom HTTP Response Code and Message using a JSON Response:
abort(response()->json(['error' => 'Unauthorized access'], 403));

// 5. Abort with a Custom HTTP Response Code and Message using a View:
abort(response()->view('errors.403', [], 403));

// 6. Abort with a Custom HTTP Response Code and Message using a Blade View:
abort(view('errors.403'), 403);

// 7. Abort with a 403 HTTP Response and Redirect to a Route:
abort(redirect()->route('login'));

// 8. Abort with a 500 HTTP Response and Log an Error Message:
abort(500, 'An internal server error occurred')->log('Error message');

// Start Hare 
//* regarding request
// Start Hare 
$request = request();
 
$value = request('key', $default);
// Start Hare 
//* regarding log 
// Start Hare 
info('Some helpful information!');
info('User login attempt failed.', ['id' => $user->id]);
logger('Debug message');
logger('User has logged in.', ['id' => $user->id]);
logger()->error('You are not allowed here.');
// Start Hare 
//* regarding env file / regarding env 
// Start Hare 
$env = env('APP_ENV');
$env = env('APP_URL');
$env = env('MAIL_FROM_ADDRESS');
dd($env);
// Start Hare 
//* regarding blank value  
// Start Hare 
blank('');
blank('   ');
blank(null);
blank(collect());
 
// true
 
blank(0);
blank(true);
blank(false);
 
// false
// Start Hare 
//* regarding route 
// Start Hare 
    // #routes: array:7 [▼
    //   "GET" => array:798 [ …798]
    //   "HEAD" => array:798 [ …798]
    //   "DELETE" => array:98 [ …98]
    //   "POST" => array:357 [ …357]
    //   "PUT" => array:96 [ …96]
    //   "PATCH" => array:96 [ …96]
    //   "OPTIONS" => array:1 [ …1]
    // ]
// Start Hare 
//* Regarding mising data / Regarding missing data 
// Start Hare 
    // Get all existing assignment numbers

    $existingAssignmentNumbers = DB::table('assignmentbudgetings')->pluck('assignmentnumber')->toArray();
    // Define the range of possible assignment numbers
    $minAssignmentNumber = 100001;
    $maxAssignmentNumber = 100512;

    // Generate an array of all possible assignment numbers within the range
    $allPossibleAssignmentNumbers = range($minAssignmentNumber, $maxAssignmentNumber);
    // Find the missing assignment numbers
    $missingAssignmentNumbers = array_diff($allPossibleAssignmentNumbers, $existingAssignmentNumbers);

    // Now $missingAssignmentNumbers contains all the missing assignment numbers
    dd($missingAssignmentNumbers);

//     array:6 [▼
//   8 => 100009
//   10 => 100011
//   11 => 100012
//   12 => 100013
//   90 => 100091
//   323 => 100324
// ]
// Start Hare 
//! ABC100120  remove alphabetic word and get 100120 
$existingAssignmentNumbers = DB::table('assignmentbudgetings')->pluck('assignmentgenerate_id')->toArray();
// $existingAssignmentNumbers = DB::table('assignmentmappings')->pluck('assignmentgenerate_id')->toArray();
// Define a function to extract digits from a string
function extractDigits($string)
{
  preg_match_all('/\d+/', $string, $matches);
  return implode('', $matches[0]);
}

// Extract digits from each assignment number and store them in a new array
$assignmentNumbersDigits = array_map(function ($assignmentNumber) {
  return extractDigits($assignmentNumber);
}, $existingAssignmentNumbers);
//!

$minAssignmentNumber = 100001;
$maxAssignmentNumber = 100512;

// Generate an array of all possible assignment numbers within the range
$allPossibleAssignmentNumbers = range($minAssignmentNumber, $maxAssignmentNumber);
// Find the missing assignment numbers
$missingAssignmentNumbers = array_diff($allPossibleAssignmentNumbers, $assignmentNumbersDigits);
dd($missingAssignmentNumbers);
// Start Hare 

//* regarding value function
// Start Hare 
$gettotalteamhour = DB::table('assignmentmappings')
->leftJoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
->where('assignmentmappings.assignmentgenerate_id', $request->assignment_id[$i])
->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
->value('teamhour');

$gettotalteamhour = DB::table('assignmentmappings')
->leftJoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
->where('assignmentmappings.assignmentgenerate_id', $request->assignment_id[$i])
->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
->first()->teamhour;

// Start Hare 

//* regarding forcefully submit
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

          // $week = date('d-m-Y', strtotime($startdateformat)) . ' to ' . date('d-m-Y', strtotime($nextSaturdayformat));
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
if ($request->leavingdate != null) {
  $timesheetsave = DB::table('timesheetusers')
      ->where('createdby', $id)
      ->where('status', 0)
      ->orderBy('date', 'ASC')
      ->get();

  $currentWeek = [];
  foreach ($timesheetsave as $timesheet) {
      $startdate = Carbon::parse($timesheet->date);
      $nextSaturday = $startdate->copy()->next(Carbon::SATURDAY);

      $currentWeek[] = $timesheet;

      // If the current date reaches Saturday or the end of data, process the current week
      if ($startdate->isSaturday() || $timesheet === $timesheetsave->last()) {
          $weekStart = $currentWeek[0]->date;
          $weekEnd = $currentWeek[count($currentWeek) - 1]->date;

          // Update statuses for timesheetusers and timesheets for the current week
          foreach ($currentWeek as $weekTimesheet) {
              DB::table('timesheetusers')
                  ->where('timesheetid', $weekTimesheet->timesheetid)
                  ->update([
                      'status' => 1,
                      'updated_at' => now(),
                  ]);

              DB::table('timesheets')
                  ->where('id', $weekTimesheet->timesheetid)
                  ->update([
                      'status' => 1,
                      'updated_at' => now(),
                  ]);
          }

          // Insert data into the timesheetreport table for the current week
          $co = DB::table('timesheetusers')
              ->where('createdby', $id)
              ->whereBetween('date', [$weekStart, $weekEnd])
              ->select('partner', DB::raw('SUM(hour) as total_hours'), DB::raw('COUNT(DISTINCT timesheetid) as row_count'))
              ->groupBy('partner')
              ->get();

          $week = date('d-m-Y', strtotime($weekStart)) . ' to ' . date('d-m-Y', strtotime($weekEnd));

          foreach ($co as $codata) {
              DB::table('timesheetreport')->insert([
                  'teamid' => 444,
                  'week' => $week,
                  'totaldays' => $codata->row_count,
                  'totaltime' => $codata->total_hours,
                  'partnerid' => $codata->partner,
                  'startdate' => $weekStart,
                  'enddate' => $weekEnd,
                  'created_at' => now(),
              ]);
          }

          // Reset the current week array for the next week
          $currentWeek = [];
      }
  }
}

// temrary
if ($request->leavingdate != null) {
  $timesheetsave = DB::table('timesheetusers')
      ->where('createdby', $id)
      ->where('status', 0)
      ->orderBy('date', 'ASC')
      ->get();

  // Chunk the $timesheetsave collection into arrays containing data for one week
  $weeksData = $timesheetsave->chunk(6); // Assuming each week has 6 data points

  foreach ($weeksData as $weekData) {
      foreach ($weekData as $timesheet) {
          $startdate = Carbon::parse($timesheet->date);
          $nextSaturday = $startdate->copy()->next(Carbon::SATURDAY);

          $startdateformat = $startdate->format('Y-m-d');
          $nextSaturdayformat = $nextSaturday->format('Y-m-d');

          $week = date('d-m-Y', strtotime($startdateformat)) . ' to ' . date('d-m-Y', strtotime($nextSaturdayformat));

          // Reset total counts for each week
          $totalDays = 0;
          $totalHours = 0;

          // Calculate total days and hours for the current week
          foreach ($weekData as $weekTimesheet) {
              $totalDays++;
              $totalHours += $weekTimesheet->hour;
          }

          // Insert data into the timesheetreport table for the current week
          DB::table('timesheetreport')->insert([
              'teamid'       =>     222,
              'week'       =>     $week,
              'totaldays'       =>     $totalDays,
              'totaltime' =>  $totalHours,
              'partnerid'  => $timesheet->partner,
              'startdate'  => $startdateformat,
              'enddate'  => $nextSaturdayformat,
              'created_at'                =>      now(),
          ]);

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
      DB::table('timesheetreport')->insert([
          'teamid'       =>     222,
          'created_at'                =>      now(),
      ]);
  }
}

if ($request->leavingdate != null) {
  $leavingdate = Carbon::parse($request->leavingdate);
  $previousSunday = $leavingdate->copy()->previous(Carbon::MONDAY);
  $nextSunday = $leavingdate->copy()->next(Carbon::SUNDAY);
  $nextSturday = $leavingdate->copy()->next(Carbon::SATURDAY);

  $previousSundayformate = $previousSunday->format('Y-m-d');
  $nextSundayformate = $nextSunday->format('Y-m-d');
  $nextSturdayformate = $nextSturday->format('Y-m-d');

  $timesheetsave = DB::table('timesheetusers')
      ->where('createdby', $id)
      ->where('status', 0)
      ->whereBetween('date', [$previousSundayformate, $nextSundayformate])
      ->orderBy('date', 'ASC')
      ->get();

  $retrievedDates = [];
  foreach ($timesheetsave as $entry) {
      $date = new DateTime($entry->date);
      $retrievedDates[] = $date->format('Y-m-d');
  }

  $expectedDates = [];   // will contain ALL the dates occurs b/w first day to upcoming sunday
  while ($previousSunday->format('Y-m-d') < $nextSunday->format('Y-m-d')) {  //excluding sunday
      $expectedDates[] = $previousSunday->format('Y-m-d');
      // Increase 1 date 
      $previousSunday->modify("+1 day");
  }

  $missingDates = array_diff($expectedDates, $retrievedDates);
  if (!empty($missingDates)) {
      foreach ($timesheetsave as $getsixdata) {
          $week =  date('d-m-Y', strtotime($previousSundayformate))  . ' to ' . date('d-m-Y', strtotime($nextSturdayformate));

          $co = DB::table('timesheetusers')
              ->where('createdby', $id)
              ->whereBetween('date', [$previousSundayformate, $nextSturdayformate])
              ->select('partner', DB::raw('SUM(hour) as total_hours'), DB::raw('COUNT(DISTINCT timesheetid) as row_count'))
              ->groupBy('partner')
              ->get();

          foreach ($co as $codata) {
              DB::table('timesheetreport')->insert([
                  'teamid'       =>     $id,
                  'week'       =>     $week,
                  'totaldays'       =>     $codata->row_count,
                  'totaltime' =>  $codata->total_hours,
                  'partnerid'  => $codata->partner,
                  'startdate'  => $previousSundayformate,
                  'enddate'  => $nextSturdayformate,
                  'created_at'                =>      date('y-m-d H:i:s'),
              ]);
          }
          DB::table('timesheetusers')->where('timesheetid', $getsixdata->id)->update([
              'status'         =>     1,
              'updated_at'              =>    date('y-m-d'),
          ]);
          DB::table('timesheets')->where('id', $getsixdata->id)->update([
              'status'         =>     1,
              'updated_at'              =>    date('y-m-d'),
          ]);
      }
  }
  dd($retrievedDates);
}

   // 22222222222222222222222222222222222222222

        // // Start Hare 
        // $nextweektimesheet1 = DB::table('timesheetusers')
        //     ->where('createdby', 847)
        //     ->whereBetween('date', ['2024-02-26', '2024-03-16'])
        //     // ->get();
        //     ->update(['status' => 0]);


        // $nextweektimesheet2 = DB::table('timesheets')
        //     ->where('created_by', 847)
        //     ->whereBetween('date', ['2024-02-26', '2024-03-16'])
        //     // ->get();
        //     ->update(['status' => 0]);

        // $nextweektimesheet = DB::table('timesheetreport')
        //     ->where('teamid', 847)
        //     ->whereDate('created_at', '2024-04-09')
        //     // ->get();
        //     ->delete();

        // dd($nextweektimesheet1);

// Start Hare 
//* regarding increament and decreament
// Start Hare 
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
// Start Hare 
//* regarding off function / regarding excell download / regarding double download  
// Start Hare 
// Start Hare 
  // Function to handle employee change
  function handleEmployeeChange() {
    var endperiod1 = $('#endperiod1').val();
    var startperiod1 = $('#startperiod1').val();
    var employee1 = $('#employee1').val();
    var leave1 = $('#leave1').val();
    var status1 = $('#status1').val();
    var end1 = $('#end1').val();
    var start1 = $('#start1').val();
    $('#clickExcell').hide();

    $.ajax({
        type: 'GET',
        url: '/filtering-applyleve',
        data: {
            end: end1,
            start: start1,
            startperiod: startperiod1,
            endperiod: endperiod1,
            status: status1,
            employee: employee1,
            leave: leave1
        },
        success: function(data) {
            renderTableRows(data);
            $('.paging_simple_numbers').remove();
            $('.dataTables_info').remove();
            // Remove previus attachment on download button 
            $('#clickExcell').off('click');
            if (data.length > 0) {
                $('#clickExcell').on('click', function() {
                    exportToExcel(data);
                });
            }
            $('#clickExcell').show();
        }
    });
}

//* regarding convert / regarding int value 
// Start Hare 
$statusdata = intval($request->input('status'));
      $sql = $query->toSql(); // Convert the query to SQL
      dd($sql); // Dump and die to see the generated SQL
// Start Hare 
//* regarding select box error 
// Start Hare 
dd($request);
$requestData = $request->all();

// Check if "Please Select One" is submitted for teammember_id or type
if (in_array('Please Select One', $requestData['teammember_id']) || in_array('Please Select One', $requestData['type'])) {
    dd($request);
    return redirect()->back()->withErrors('Please select valid options for team member and type.');
}

// <div class="row row-sm">
// <div class="col-6">
//     <div class="form-group">
//         <label class="font-weight-600">Name *</label>
//         <select required class="language form-control" id="key" name="teammember_id[]">

//             <option value="">Please Select One</option>
//             @foreach ($teammember as $teammemberData)
//                 <option value="{{ $teammemberData->id }}" @if (!empty($store->financial) && $store->financial == $teammemberData->id) selected @endif>
//                     {{ $teammemberData->team_member }} ( {{ $teammemberData->role->rolename }} ) (
//                     {{ $teammemberData->staffcode }} )</option>
//             @endforeach
//         </select>
//     </div>
// </div>
// <div class="col-5">
//     <div class="form-group">
//         <label class="font-weight-600">Type *</label>
//         <select required class="form-control key" id="key" name="type[]">

//             <option value="">Please Select One</option>
//             <option value="0">Team Leader</option>
//             <option value="2">Staff</option>
//         </select>
//     </div>
// </div>

// <div class="col-1">
//     <div class="form-group" style="margin-top: 36px;">
//         <a href="javascript:void(0);" class="add_buttonn" title="Add field"><img
//                 src="{{ url('backEnd/image/add-icon.png') }}" /></a>
//     </div>
// </div>
// </div>

// Start Hare 
//* regarding is()
// Start Hare 
// 1. Check if a Variable Matches a Value:
$value = 'example';
if ($value->is('example')) {
    // Do something if $value is 'example'
}

// 2. Check if a Route Matches a Name:
if (Route::currentRouteName()->is('home')) {
    // Do something if current route is named 'home'
}

// 3. Check if a Route Matches a Pattern:
if (Request::is('admin/*')) {
    // Do something if current URL matches 'admin/*' pattern
}

// 4. Check if a Request Matches a Method:
if (Request::isMethod('post')) {
    // Do something if current request method is POST
}

// 5. Check if a Collection Matches a Condition:
$collection = collect([1, 2, 3, 4, 5]);
if ($collection->isNotEmpty() && $collection->is(function ($item) {
    return $item > 3;
})) {
    // Do something if collection is not empty and all items are greater than 3
}

// 6. Check if a String Matches a Pattern:
$string = 'Hello, World!';
if (Str::of($string)->is('*World*')) {
    // Do something if $string contains 'World'
}

// Start Hare 
//* regarding Carbon / egarding days / regarding date 2 / regarding CarbonPeriod / regarding CarbonPeriod / regarding CarbonPeriod / regarding sutarday 
// Start Hare 
// Start Hare 
$id = DB::table('timesheets')->insertGetId([
  'created_by' => auth()->user()->teammember_id,
  'month'     =>   $firstDate->format('F'),
  'date'       => $firstDate->format('Y-m-d'),
  'status'       => 3,
  'created_at' => $firstDate->format('Y-m-d') . ' ' . now()->format('H:i:s'),
  'updated_at' => $firstDate->format('Y-m-d') . ' ' . now()->format('H:i:s'),
]);

DB::table('timesheetusers')->insert([
  'timesheetid'     =>     $id,
  'date'     =>  $firstDate->format('Y-m-d'),
  'status'       => 3,
  'createdby' => auth()->user()->teammember_id,
  'created_at' => $firstDate->format('Y-m-d') . ' ' . now()->format('H:i:s'),
  'updated_at' => $firstDate->format('Y-m-d') . ' ' . now()->format('H:i:s'),
]);
// 2021-12-26
        // Check if leavingdate exists and is after the startdate
        if ($singleusersearched->leavingdate != null) {
          $leavingdate = \Carbon\Carbon::parse($singleusersearched->leavingdate);

          if ($leavingdate->gt($startdate)) {
              dd($leavingdate);
              $output = array('msg' => 'You cannot select this user as their leaving date is after the start date.');
              return back()->with('success', $output);
          }
          dd('hi');
      }
// Start Hare 
<?php

use Carbon\Carbon;
use Illuminate\Http\Request;


$date1->equalTo($date2);
$date1->notEqualTo($date2);
$date1->greaterThan($date2);
$date1->greaterThanOrEqualTo($date2);
$date1->lessThan($date2);
$date1->lessThanOrEqualTo($date2);
$date->between($start, $end);
$date->isToday();
$date->isTomorrow();
$date->isYesterday();
$date->isFuture();
$date->isPast();
$date->isWeekend();
$date->isWeekday();
$date->isSameDay($from)

if ($latesttimesheetsubmittedformate && ($latesttimesheetsubmittedformate->greaterThan($from) || $latesttimesheetsubmittedformate->equalTo($from))) {}
// <td>{{ date('d-m-Y', strtotime($udinData->created)) }},
// {{ date('H:i A', strtotime($udinData->created)) }}</td>
// <td>{{ $udinData->udindate ? date('d-m-Y', strtotime($udinData->udindate)) : 'NA' }}</td>
    $from = Carbon::createFromFormat('Y-m-d', $request->from);
    $to = Carbon::createFromFormat('Y-m-d', $request->to ?? '');

    // Check if dates are equal and the day is Sunday
    if ($from->equalTo($to) && $from->dayOfWeek === Carbon::SUNDAY) {
        $output = ['msg' => 'You cannot apply leave for Sunday'];
        return back()->with('statuss', $output);
    }

    // Check if the start date is in the future
    if ($from->isFuture()) {
        $output = ['msg' => 'The start date cannot be in the future'];
        return back()->with('statuss', $output);
    }

    // Check if the end date is in the past
    if ($to->isPast()) {
        $output = ['msg' => 'The end date cannot be in the past'];
        return back()->with('statuss', $output);
    }

    // Check if the date range includes a weekend
    if ($from->between($from->copy()->next(Carbon::SATURDAY), $from->copy()->next(Carbon::SUNDAY))) {
        $output = ['msg' => 'The leave period includes a weekend'];
        return back()->with('statuss', $output);
    }

    // Check if dates are not equal
    if ($from->notEqualTo($to)) {
        $output = ['msg' => 'The start and end dates are not the same'];
        return back()->with('statuss', $output);
    }

    // Additional date comparisons

    // Check if the start date is greater than the end date
    if ($from->greaterThan($to)) {
        $output = ['msg' => 'The start date cannot be greater than the end date'];
        return back()->with('statuss', $output);
    }

    // Check if the start date is less than the end date
    if ($from->lessThan($to)) {
        $output = ['msg' => 'The start date is less than the end date'];
        return back()->with('statuss', $output);
    }

    // Check if the start date is greater than or equal to the end date
    if ($from->greaterThanOrEqualTo($to)) {
        $output = ['msg' => 'The start date is greater than or equal to the end date'];
        return back()->with('statuss', $output);
    }

    // Check if the start date is less than or equal to the end date
    if ($from->lessThanOrEqualTo($to)) {
        $output = ['msg' => 'The start date is less than or equal to the end date'];
        return back()->with('statuss', $output);
    }

    // Check if the start date is today
    if ($from->isToday()) {
        $output = ['msg' => 'The start date is today'];
        return back()->with('statuss', $output);
    }

    // Check if the start date is tomorrow
    if ($from->isTomorrow()) {
        $output = ['msg' => 'The start date is tomorrow'];
        return back()->with('statuss', $output);
    }

    // Check if the start date is yesterday
    if ($from->isYesterday()) {
        $output = ['msg' => 'The start date is yesterday'];
        return back()->with('statuss', $output);
    }

    // Check if the start date is in the future
    if ($from->isFuture()) {
        $output = ['msg' => 'The start date is in the future'];
        return back()->with('statuss', $output);
    }

    // Check if the start date is in the past
    if ($from->isPast()) {
        $output = ['msg' => 'The start date is in the past'];
        return back()->with('statuss', $output);
    }

    // Check if the start date is a weekend
    if ($from->isWeekend()) {
        $output = ['msg' => 'The start date is a weekend'];
        return back()->with('statuss', $output);
    }

    // Check if the start date is a weekday
    if ($from->isWeekday()) {
        $output = ['msg' => 'The start date is a weekday'];
        return back()->with('statuss', $output);
    }

    if ($autosubmitdate->isSameDay($todaydate)) {
      dd('hi date');
  }

    // Default message if no conditions are met
    $output = ['msg' => 'Dates are valid'];
    return back()->with('statuss', $output);


// Start Hare 

$selectedDate1 = \DateTime::createFromFormat('d-m-Y', $request->timesheetdate);

if ($selectedDate1->format('l') == 'Saturday') {
    $dayOfMonth = $selectedDate1->format('j');
    $saturdayNumber = ceil($dayOfMonth / 7);

    // Define the client IDs for each Saturday number
    $clientIdsBySaturday = [
        1 => [29, 32, 34],
        2 => [29, 32, 33, 34],
        3 => [29, 32, 34],
        4 => [29, 32, 33, 34],
        5 => [29, 32, 34]
    ];

    // Default to the second role's client IDs
    $clientIds = $clientIdsBySaturday[$saturdayNumber] ?? [];

    // If the user role is 13 and it's the 2nd or 4th Saturday, include extra clients
    if (auth()->user()->role_id != 13) {
        $clientIds = [29, 32, 33, 34];
    }

    $clients = DB::table('clients')
        ->whereIn('id', $clientIds)
        ->select('clients.client_name', 'clients.id', 'clients.client_code')
        ->orderBy('client_name', 'ASC')
        ->distinct()
        ->get();

    $client = $clientss->merge($clients);
// Start Hare 
  $selectedDate1 = \DateTime::createFromFormat('d-m-Y', $request->timesheetdate);
          $dayOfWeek = $selectedDate1->format('w');
          if ($selectedDate1->format('l') == 'Saturday') {

            $dayOfMonth = $selectedDate1->format('j');
            // Calculate which Saturday of the month it is
            $saturdayNumber = ceil($dayOfMonth / 7);
            if ($saturdayNumber == 1.0) {
              $clients = DB::table('clients')
                ->whereIn('id', [29, 32, 34])
                ->select('clients.client_name', 'clients.id', 'clients.client_code')
                ->orderBy('client_name', 'ASC')
                ->distinct()->get();
            } elseif ($saturdayNumber == 2.0) {
              $clients = DB::table('clients')
                ->whereIn('id', [29, 32, 33, 34])
                ->select('clients.client_name', 'clients.id', 'clients.client_code')
                ->orderBy('client_name', 'ASC')
                ->distinct()->get();
            } elseif ($saturdayNumber == 3.0) {
              $clients = DB::table('clients')
                ->whereIn('id', [29, 32, 34])
                ->select('clients.client_name', 'clients.id', 'clients.client_code')
                ->orderBy('client_name', 'ASC')
                ->distinct()->get();
            } elseif ($saturdayNumber == 4.0) {
              $clients = DB::table('clients')
                ->whereIn('id', [29, 32, 33, 34])
                ->select('clients.client_name', 'clients.id', 'clients.client_code')
                ->orderBy('client_name', 'ASC')
                ->distinct()->get();
            } elseif ($saturdayNumber == 5.0) {
              $clients = DB::table('clients')
                ->whereIn('id', [29, 32, 34])
                ->select('clients.client_name', 'clients.id', 'clients.client_code')
                ->orderBy('client_name', 'ASC')
                ->distinct()->get();
            }
          } else {
            $clients = DB::table('clients')
              ->whereIn('id', [29, 32, 34])
              ->select('clients.client_name', 'clients.id', 'clients.client_code')
              ->orderBy('client_name', 'ASC')
              ->distinct()->get();
          }

// Start Hare 
          $dayOfWeek = $selectedDate1->format('w');
          if ($selectedDate1->format('l') == 'Saturday') {

            $dayOfMonth = $selectedDate1->format('j');
            // Calculate which Saturday of the month it is
            $saturdayNumber = ceil($dayOfMonth / 7);
            if ($saturdayNumber == 1.0) {
              $clientIds = [29, 32, 34];
            } elseif ($saturdayNumber == 2.0) {
              $clientIds = [29, 32, 33, 34];
            } elseif ($saturdayNumber == 3.0) {
              $clientIds = [29, 32, 34];
            } elseif ($saturdayNumber == 4.0) {
              $clientIds = [29, 32, 33, 34];
            } elseif ($saturdayNumber == 5.0) {
              $clientIds = [29, 32, 34];
            }
          } else {
            $clientIds = [29, 32, 34];
          }

          $clients = DB::table('clients')
            ->whereIn('id', $clientIds)
            ->select('clients.client_name', 'clients.id', 'clients.client_code')
            ->orderBy('client_name', 'ASC')
            ->distinct()
            ->get();

          $client = $clientss->merge($clients);
// Start Hare 
// Start Hare 
$selectedDate = \DateTime::createFromFormat('d-m-Y', '25-06-2024');

$clientIds = ($selectedDate->format('l') == 'Friday') ? [29, 32, 33, 34] : [29, 32, 34];
$clients = DB::table('clients')
    ->whereIn('id', $clientIds)
    ->select('clients.client_name', 'clients.id', 'clients.client_code')
    ->orderBy('client_name', 'ASC')
    ->distinct()
    ->get();

dd($clients); // Dump the clients data for debugging

// Start Hare 
$selectedDate = \DateTime::createFromFormat('d-m-Y', '25-06-2024');

if ($selectedDate->format('l') == 'Friday') {
  $clients = DB::table('clients')
    ->whereIn('id', [29, 32, 33, 34])
    ->select('clients.client_name', 'clients.id', 'clients.client_code')
    ->orderBy('client_name', 'ASC')
    ->distinct()->get();
} else {
  $clients = DB::table('clients')
    ->whereIn('id', [29, 32, 34])
    ->select('clients.client_name', 'clients.id', 'clients.client_code')
    ->orderBy('client_name', 'ASC')
    ->distinct()->get();
}
dd($clients);
// dd($selectedDate->format('l'));
// Tuesday
// Start Hare regarding same date / regarding equal date  
$from = Carbon::createFromFormat('Y-m-d', $request->from);
$to = Carbon::createFromFormat('Y-m-d', $request->to ?? '');

if ($from->equalTo($to) && $from->dayOfWeek === Carbon::SUNDAY) {
  $output = ['msg' => 'You cannot apply leave for Sunday'];
  return back()->with('statuss', $output);
}

// 1. Create a Carbon Instance with Current Date and Time:
$now = Carbon::now();
$now = new \DateTime();

$currentdate = Carbon::now()->startOfDay();
$currentDate = Carbon::now()->format('d-m-Y');

// 2. Create a Carbon Instance with Specific Date and Time:
$date = Carbon::create(2022, 4, 15, 13, 30, 0);

// 3. Format a Carbon Instance:
$formattedDate = $date->format('Y-m-d H:i:s');

// 4. Add Days to a Carbon Instance:
$futureDate = $date->addDays(7);

// 5. Subtract Days from a Carbon Instance:
$pastDate = $date->subDays(7);

// 6. Get Difference in Days between Two Carbon Instances:
$difference = $date1->diffInDays($date2);

// 7. Check if a Date is Before Another Date:
if ($date1->lt($date2)) {
    // $date1 is before $date2
}

// 8. Check if a Date is After Another Date:
if ($date1->gt($date2)) {
    // $date1 is after $date2
}

// 9. Get Day of the Week of a Date:
$dayOfWeek = $date->dayOfWeek;

// 10. Get Month of a Date:
$month = $date->month;

// 11. Check if a Date is Today:
if ($date->isToday()) {
    // $date is today
}

// 12. Check if a Date is in the Future:
if ($date->isFuture()) {
    // $date is in the future
}


// check time / regarding time 
 if (now()->format('H:i') === '18:00') {
}
// regarding CarbonPeriod
// 1. Create a Period for a Range of Dates:
  $period = CarbonPeriod::create('2022-01-01', '2022-01-10');

  // 2. Create a Period with Interval:
  $period = CarbonPeriod::create('2022-01-01', '1 day', '2022-01-10');
  
  // 3. Iterate Over a Period:
  foreach ($period as $date) {
      echo $date->format('Y-m-d') . "\n";
  }
  
  // 4. Check if a Date is Within the Period:
  $date = Carbon::parse('2022-01-05');
  if ($period->contains($date)) {
      echo "Date is within the period\n";
  }
  
  // 5. Filter Period by Closure:
  $filteredPeriod = $period->filter(function ($date) {
      return $date->dayOfWeek !== Carbon::SUNDAY;
  });
  
  // 6. Get Number of Days in the Period:
  $numberOfDays = $period->count();
  
  // 7. Get Start and End Dates of the Period:
  $startDate = $period->getStartDate();
  $endDate = $period->getEndDate();
  
  // 8. Get All Dates in the Period as an Array:
  $datesArray = $period->toArray();
  
  // 9. Get Period as JSON:
  $periodJson = json_encode($period);
  

  // regarding DateTime
  // 1. Get Current Date and Time:
$currentDateTime = new DateTime();

// 2. Create a DateTime Object from a Specific Date:
$specificDate = new DateTime('2022-04-15');

// 3. Create a DateTime Object from a Specific Date and Time:
$specificDateTime = new DateTime('2022-04-15 13:30:00');

// 4. Format a DateTime Object:
$formattedDateTime = $specificDateTime->format('Y-m-d H:i:s');

// 5. Add Days to a DateTime Object:
$specificDateTime->modify('+7 days');

// 6. Subtract Days from a DateTime Object:
$specificDateTime->modify('-7 days');

// 7. Get Difference in Days Between Two DateTime Objects:
$difference = $specificDateTime1->diff($specificDateTime2)->days;

// 8. Check if a DateTime is Before Another DateTime:
if ($specificDateTime1 < $specificDateTime2) {
    // $specificDateTime1 is before $specificDateTime2
}

// 9. Check if a DateTime is After Another DateTime:
if ($specificDateTime1 > $specificDateTime2) {
    // $specificDateTime1 is after $specificDateTime2
}

// 10. Get Timestamp of a DateTime Object:
$timestamp = $specificDateTime->getTimestamp();


$from = Carbon::createFromFormat('Y-m-d', $request->from);
$to = Carbon::createFromFormat('Y-m-d', $request->to ?? '');

// Check if dates are equal and the day is Sunday
if ($from->equalTo($to) && $from->dayOfWeek === Carbon::SUNDAY) {
  $output = ['msg' => 'You cannot apply leave for Sunday'];
  return back()->with('statuss', $output);
}

// Check if the start date is in the future
if ($from->isFuture()) {
  $output = ['msg' => 'The start date cannot be in the future'];
  return back()->with('statuss', $output);
}

// Check if the end date is in the past
if ($to->isPast()) {
  $output = ['msg' => 'The end date cannot be in the past'];
  return back()->with('statuss', $output);
}

// Check if the date range includes a weekend
if ($from->between($from->copy()->next(Carbon::SATURDAY), $from->copy()->next(Carbon::SUNDAY))) {
  $output = ['msg' => 'The leave period includes a weekend'];
  return back()->with('statuss', $output);
}

// Check if dates are not equal
if ($from->notEqualTo($to)) {
  $output = ['msg' => 'The start and end dates are not the same'];
  return back()->with('statuss', $output);
}


// Start Hare 
//* regarding distinct / regarding get
// Start Hare 
$teammembersjoin = DB::table('attendances')
->leftjoin('teammembers', 'teammembers.id', 'attendances.employee_name')
->where('teammembers.status', 1)
->select('attendances.employee_name', 'teammembers.team_member', 'teammembers.staffcode', 'teammembers.status')
->distinct('attendances.employee_name')
->get()
->toArray();

dd($teammembersjoin);
// Start Hare 
$teammembersjoin = DB::table('attendances')
->leftjoin('teammembers', 'teammembers.id', 'attendances.employee_name')
->select('attendances.employee_name', 'teammembers.team_member')
->distinct('attendances.employee_name')
->get()
->toArray();

dd($teammembersjoin);

     
$teammembers = DB::table('attendances')
->select('employee_name')
->distinct()
->get();

dd($teammembers);

$teammembers = DB::table('attendances')
->select('employee_name')
->distinct()
->get()
->toArray();

dd($teammembers);

$duplicateEmails = DB::table('users')
->select('email', DB::raw('COUNT(*) as count'))
->groupBy('email')
->having('count', '>', 1)
->pluck('email');

// $duplicateUsers = DB::table('users')
//   ->whereIn('email', $duplicateEmails)
//   ->distinct('email')
//   ->get();

// $duplicateUsers = DB::table('users')
//   ->whereIn('email', $duplicateEmails)
//   ->select('email', 'teammember_id')
//   ->distinct()
//   ->get();

dd($duplicateEmails);
// Start Hare 
$teammembers = DB::table('attendances')
->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'attendances.employee_name')
->leftJoin('teammembers', 'teammembers.id', '=', 'attendances.employee_name')
->whereIn('teammembers.role_id', [14, 15, 13, 11])
->select('teammembers.team_member', 'teamrolehistory.newstaff_code', 'teammembers.id', 'teammembers.staffcode')
->distinct()
->orderBy('teammembers.team_member', 'ASC')
->get();
// Start Hare 
// 1. Select Distinct Values of a Column:
DB::table('table_name')->distinct()->get('column_name');

// 2. Select Distinct Values of Multiple Columns:
DB::table('table_name')->distinct()->get(['column1', 'column2']);

// 3. Select Distinct Values Using Relationship:
DB::table('posts')->join('users', 'posts.user_id', '=', 'users.id')->distinct()->get('users.name');

// 4. Select Distinct Values with Conditions:
DB::table('table_name')->where('column_name', 'value')->distinct()->get('column_name');

// 5. Select Distinct Values Using Subquery:
DB::table('posts')->whereIn('user_id', function ($query) {
    $query->from('users')->select('id')->distinct();
})->get();

// Start Hare 
//* regarding orderby
// Start Hare 
// 1. Order By Single Column Ascending:
DB::table('table_name')->orderBy('column_name')->get();

// 2. Order By Single Column Descending:
DB::table('table_name')->orderBy('column_name', 'desc')->get();

// 3. Order By Multiple Columns:
DB::table('table_name')->orderBy('column1', 'asc')->orderBy('column2', 'desc')->get();

// 4. Order By Raw Expression:
DB::table('table_name')->orderByRaw('FIELD(column_name, "value1", "value2", "value3")')->get();

// 5. Order By Relationship Column:
DB::table('posts')->join('users', 'posts.user_id', '=', 'users.id')->orderBy('users.name')->get();

// 6. Order By Null Values:
DB::table('table_name')->orderBy('column_name')->orderBy('column_name2', 'desc')->nullsFirst()->get();

// 7. Order By Using Subquery:
DB::table('posts')->orderBySub(function ($query) {
    $query->select('created_at')->from('comments')->whereColumn('comments.post_id', 'posts.id')->orderBy('created_at', 'desc')->limit(1);
})->get();

// Start Hare 
//* regarding select query  
// Start Hare 
// 1. Select All Columns:
DB::table('table_name')->select('*')->get();

// 2. Select Specific Columns:
DB::table('table_name')->select('column1', 'column2')->get();

// 3. Select With Aliases:
DB::table('table_name')->select('column1 as alias1', 'column2 as alias2')->get();

// 4. Select With Aggregate Functions:
DB::table('table_name')->select(DB::raw('COUNT(*) as count'))->get();

// 5. Select With Joins:
DB::table('table1')->select('table1.column1', 'table2.column2')->join('table2', 'table1.id', '=', 'table2.table1_id')->get();

// 6. Select Distinct Values:
DB::table('table_name')->select('column1')->distinct()->get();

// 7. Select With Conditions:
DB::table('table_name')->select('column1')->where('column2', '=', 'value')->get();

// 8. Select With Order By:
DB::table('table_name')->select('column1')->orderBy('column2', 'asc')->get();

// 9. Select With Limit and Offset:
DB::table('table_name')->select('column1')->offset(5)->limit(10)->get();

// 10. Select With Raw SQL:
DB::table('table_name')->select(DB::raw('COUNT(*) as count'))->get();

// Start Hare 
//* regarding redirect / regarding message /success message / regarding output / regarding return / regarding url
// Start Hare 

// 1. Redirect to a Route by Name:
return redirect()->route('route.name');

// 2. Redirect with Flash Data:
return redirect()->route('route.name')->with('key', 'value');

// 3. Redirect with Flash Data Using Arrays:
return redirect()->route('route.name')->with(['key1' => 'value1', 'key2' => 'value2']);

// 4. Redirect with Flash Data Using Chained Methods:
return redirect()->route('route.name')->with('key', 'value')->with('anotherKey', 'anotherValue');

// 5. Redirect with Validation Errors:
return redirect()->back()->withErrors($validator);

// 6. Redirect with Custom Status Code:
return redirect()->route('route.name')->status(404);

// 7. Redirect to External URL:
return redirect()->away('http://example.com');

// 8. Redirect to Named Route with Parameters:
return redirect()->route('route.name', ['param1' => 'value1', 'param2' => 'value2']);

use Illuminate\Support\Facades\Redirect;
return Redirect::route('users.show', ['user' => 1], 302)->withHeaders(['X-Framework' => 'Laravel']);

// Start Hare 
//* regarding insert query and upadte query
// Start Hare 

// ---------------------------------------------------------------------------------------------------------------------------
// |                            Query                                 |                           Description                            |
// ---------------------------------------------------------------------------------------------------------------------------
// |  1. insert(array $values)                                      | Inserts a record into the table with the given values.          |
// |  2. insertGetId(array $values)                                 | Inserts a record into the table and returns its ID.             |
// |  3. insertOrIgnore(array $values)                              | Inserts a record into the table, ignoring duplicates.           |
// |  4. insertUsing(array $columns, \Closure $query)               | Inserts records into the table using a subquery.                |
// |  5. insertGetIdOrIgnore(array $values)                         | Inserts a record into the table and returns its ID, ignoring duplicates.|
// |  6. update(array $values)                                      | Updates records in the table with the given values.             |
// |  7. updateOrInsert(array $attributes, array $values = [])      | Updates or inserts a record into the table based on the given attributes.|
// |  8. updateOrInsert(array $attributes, array $values = [], array $search = [])| Updates or inserts a record into the table based on the given attributes and search criteria.|
// ---------------------------------------------------------------------------------------------------------------------------

// 1. insert(array $values)
DB::table('users')->insert([
    ['name' => 'John', 'email' => 'john@example.com'],
    ['name' => 'Jane', 'email' => 'jane@example.com']
]);

// 2. insertGetId(array $values)
$id = DB::table('users')->insertGetId([
    'name' => 'John',
    'email' => 'john@example.com'
]);

// 3. insertOrIgnore(array $values)
DB::table('users')->insertOrIgnore([
    'name' => 'John',
    'email' => 'john@example.com'
]);

// 4. insertUsing(array $columns, \Closure $query)
DB::table('users')->insertUsing(['name', 'email'], function ($query) {
    $query->select('full_name', 'email')->from('other_users');
});

// 5. insertGetIdOrIgnore(array $values)
$id = DB::table('users')->insertGetIdOrIgnore([
    'name' => 'John',
    'email' => 'john@example.com'
]);

// 6. update(array $values)
DB::table('users')
    ->where('id', 1)
    ->update(['name' => 'Updated Name']);

// 7. updateOrInsert(array $attributes, array $values = [])
DB::table('users')
    ->updateOrInsert(['email' => 'john@example.com'], ['name' => 'John']);

// 8. updateOrInsert(array $attributes, array $values = [], array $search = [])
DB::table('users')
    ->updateOrInsert(['email' => 'john@example.com'], ['name' => 'John'], ['name' => 'Jane']);

// Start Hare 
//* regarding mail 
// Start Hare 
// Start Hare 
// Start Hare 
$mailarray = [$data['email'], $data['secondaryemail']];
foreach ($mailarray as $email) {
    Mail::send('emails.assignmentdebtorform', $data, function ($msg) use ($data, $request, $email) {
        $msg->to($email);
        $msg->subject($data['subject']);
        if ($request->teammember_id) {
            $msg->cc($data['teammembermail']);
        }
        // Add CC for additional emails from the input field
        if ($request->ccmail) {
            $assignEmails = explode(',', $request->ccmail);
            foreach ($assignEmails as $email) {
                $msg->cc(trim($email));
            }
        }
    });
}
// Start Hare 
Mail::send('emails.assignmentdebtorform', $data, function ($msg) use ($data, $request) {
  $mailarray = array_filter([$data['email'], $data['secondaryemail'] ?? '']);
  if (!empty($mailarray)) {
      foreach ($mailarray as $email) {
          $msg->to($email);
      }
  }
  $msg->subject($data['subject']);
  if ($request->teammember_id) {
      $msg->cc($data['teammembermail']);
  }

  // Add CC for additional emails from the input field
  if ($request->ccmail) {
      $assignEmails = explode(',', $request->ccmail);
      foreach ($assignEmails as $email) {
          $msg->cc(trim($email));
      }
  }
});
// Start Hare 
// Start Hare 
Mail::send('emails.timesheetrequestform', $data, function ($msg) use ($data) {
  $msg->to($data['email']);
  $msg->cc('itsupport_delhi@vsa.co.in');
  $msg->subject('Timesheet Submission Request');
});
// Start Hare 
// if ($timesheetRequest->status == 0) {
//   $data = array(
//       'teammember' => $name ?? '',
//       'email' => $teammembermail ?? '',
//       'id' => $timesheetRequest->id ?? '',
//       'client_id' => $client_name ?? '',
//       'reason'     =>     $timesheetRequest->reason ?? '',
//   );
//   $url = URL::to('/timesheetrequestlist') ?? '';
//   $title = "timesheetrequestreminder";
//   $template = $this->getTemplateData($title);
//   // dd($template);  
//   $to = ($data['email']);
//   $cc = ($template['cc']);
//   $this->sendTicketEmail($to, $cc, $title, $data, $url);
// }
//* regarding sql
// Start Hare 
$query = DB::table('timesheetrequests')
->where('createdby', auth()->user()->teammember_id)
//->where('status', 1)
->latest()
->toSql();
//* regarding array access / regarding access
// Start Hare 
dd($assignments[0]->assignmentgenerate_id);
dd($assignments[0]->client_id);
dd($assignments[0]->assignment_id);
dd($assignments[0]->created_at);
dd($request->id);
// Start Hare 
$startdate = $weekData->first()->date;
$startdate = $weekData->last()->date;

$startdate = Carbon::parse($weekData->first()->date);
$startdate = Carbon::parse($weekData->last()->date);
$dataToProcess = $weekData->slice(1, -1);
// example
foreach ($weekData as $timesheet) {
  $startdate = Carbon::parse($timesheet->date);
  $nextSaturday = $startdate->copy()->next(Carbon::SATURDAY);
}
$startdate = Carbon::parse($weekData->first()->date);
// Start Hare 

//*regarding implode function 

 // $data = array(
                //     'assignmentid' =>  $assignmentgenerate,
                //     'clientname' =>  $clientname->client_name,
                //     'clientcode' =>  $clientname->client_code,
                //     'assignmentname' =>  $request->assignmentname,
                //     'assignment_name' =>  $assignment_name,
                //     'emailid' =>  $teammember->emailid,
                //     'otherpatner' =>  $teamemailotherpartner,
                //     'assignmentpartner' =>  $teamemailpartner,
                //     'teamleader' => $teamleader->map(function ($leader) {
                //         return $leader->team_member . ' (' . $leader->staffcode . ')';
                //     })->implode(', '),
                // );
                // dd($data);
//* regarding week days name / days name / regarding months name 
// Monday
// Tuesday
// Wednesday
// Thursday
// Friday
// Saturday
// Sunday

// January
// February
// March	
// April
// May	
// June
// July	
// August
// September	
// October
// November	
// December

    // Sunday=1
    // Monday=2
    // Tuesday=3
    // Wednesday=4
    // Thursday=5
    // Friday=6
    // Saturday=7
    // Sunday=8

//* regarding count function 
if (!empty($missingDates)) {
  $count1 = count($missingDates);
  $missingDatesexist =  DB::table('timesheetusers')
      // ->where('status', '0')
      ->whereIn('date', $missingDates)
      ->where('createdby', 847)
      ->orderBy('date', 'ASC')
      ->get();
  $count2 = $missingDatesexist->count();
  dd($count1, $count2);
}
//* regarding model
$createdby = Timesheetuser::distinct()->pluck('createdby')->toArray();

//* regarding command / regarding command

// make comand using comand 
// 1.php artisan make:command SubmittedExamleaveTimesheet

// show command list 
// 3.php artisan schedule:list

// show command list 
// 2.php artisan list

// test command in terminal 
// 4.php artisan command:submittedexamleaveTimesheet

//1. go to command file 
//2. go to kernel file and register command 
//3. go to web.php file and create route 
//4. go to  controller and define function 

class SubmittedExamleaveTimesheet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:submittedexamleaveTimesheet';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description =  'Insert Successfully';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        dd('HI');
        // return 0;
    }
}


public function submittedexamleaveTimesheet()
{

  $exitCode = Artisan::call('command:submittedexamleaveTimesheet')->daily();

  return  redirect('/');
}





//*regarding ajax
//* regarding ajax / table heading replace 
// start hare 
  // start hare 
  // start hare 
  // start hare 
  // start hare 
  //? start hare 

  <script>
  $(function() {
      $('#client').on('change', function() {
          var cid = $(this).val();
          //   alert(cid);
          $.ajax({
              type: "get",
              url: "{{ url('timesheetreject/edit') }}",
              data: "cid=" + cid,
              success: function(res) {
                  $('#assignment').html(res);
              },
              error: function() {},
          });
      });
      $('#assignment').on('change', function() {
          var assignment = $(this).val();
          // alert(category_id);
          $.ajax({
              type: "get",
              // url: "{{ url('timesheet/create') }}",
              url: "{{ url('timesheetreject/edit') }}",
              data: "assignment=" + assignment,
              success: function(res) {
                  $('#partner').html(res);
              },
              error: function() {},
          });
      });
  });
</script>

  Route::get('/timesheetreject/edit/{id?}', [TimesheetController::class, 'timesheetEdit']);
  public function timesheetEdit(Request $request, $id = null)
  {
    $timesheetedit = DB::table('timesheetusers')
      ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
      ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
      ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
      ->where('timesheetusers.timesheetid', $id)
      ->select('timesheetusers.*', 'clients.client_name', 'assignments.assignment_name', 'teammembers.team_member')
      ->get();

    // client of particular partner
    $partner = Teammember::where('role_id', '=', 13)->where('status', '=', 1)->with('title')->get();
    $teammember = Teammember::where('role_id', '!=', 11)->with('title', 'role')->get();
    if (auth()->user()->role_id == 11) {
      $client = Client::where('status', 1)->select('id', 'client_name')->orderBy('client_name', 'ASC')->get();
    } elseif (auth()->user()->role_id == 13) {
      $clientss = DB::table('assignmentmappings')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
        ->orwhere('assignmentmappings.otherpartner', auth()->user()->teammember_id)
        ->select('clients.client_name', 'clients.id')
        ->orderBy('client_name', 'ASC')
        ->distinct()->get();


      $clients = DB::table('clients')
        ->whereIn('id', [29, 32, 33, 34])
        ->select('clients.client_name', 'clients.id')
        ->orderBy('client_name', 'ASC')
        ->distinct()->get();

      $client = $clientss->merge($clients);
    } else {
      $client = DB::table('assignmentteammappings')
        ->leftjoin('assignmentmappings', 'assignmentmappings.id', 'assignmentteammappings.assignmentmapping_id')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->orwhere('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
        ->select('clients.client_name', 'clients.id')
        ->orderBy('client_name', 'ASC')
        ->distinct()->get();
    }
    $assignment = Assignment::select('id', 'assignment_name')->get();
    //   dd($assignment);
    // shahid assi
    if ($request->ajax()) {

      // dd(auth()->user()->id);
      if (isset($request->cid)) {
        if (auth()->user()->role_id == 13) {
          echo "<option>Select Assignment</option>";
          foreach (DB::table('assignmentbudgetings')->where('client_id', $request->cid)
            ->where('created_by', auth()->user()->id)
            ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
            ->orderBy('assignment_name')->get() as $sub) {
            echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentgenerate_id . ' )' . "</option>";
          }
        } else {
          echo "<option>Select Assignment</option>";
          foreach (DB::table('assignmentbudgetings')
            ->join('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
            ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
            ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
            ->where('assignmentbudgetings.client_id', $request->cid)
            ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
            ->orderBy('assignment_name')->get() as $sub) {
            echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentgenerate_id . ' )' . "</option>";
          }
        }
      }
      if (isset($request->assignment)) {

        if (auth()->user()->role_id == 11) {
          echo "<option value=''>Select Partner</option>";
          foreach (DB::table('assignmentmappings')

            ->leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
            ->leftjoin('teammembers as team', 'team.id', 'assignmentmappings.otherpartner')
            ->where('assignmentmappings.assignmentgenerate_id', $request->assignment)
            ->select('team.team_member as team_member', 'team.id', 'teammembers.id', 'teammembers.team_member')
            ->get() as $subs) {
            echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
          }
        } elseif (auth()->user()->role_id == 13) {
          echo "<option value=''>Select Partner</option>";
          foreach (DB::table('teammembers')
            ->where('id', auth()->user()->teammember_id)
            ->select('teammembers.id', 'teammembers.team_member')
            ->get() as $subs) {
            echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
          }
        } else {
          //die;
          echo "<option value=''>Select Partner</option>";
          foreach (DB::table('assignmentmappings')

            ->leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
            ->leftjoin('teammembers as team', 'team.id', 'assignmentmappings.otherpartner')
            ->where('assignmentmappings.assignmentgenerate_id', $request->assignment)
            ->select('team.team_member as team_member', 'team.id', 'teammembers.id', 'teammembers.team_member')
            ->get() as $subs) {
            echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
          }
        }
      }
    } else {
      return view('backEnd.timesheet.correction', compact('client', 'teammember', 'assignment', 'partner', 'timesheetedit'));
    }
  }
  // start hare 
// app\Http\Controllers\TimesheetController.php    function create(Request $request)
// in same function me ajax call karna hai to 
  $partner = Teammember::where('role_id', '=', 13)->where('status', '=', 1)->with('title')->get();
  if ($request->ajax()) {
    if (isset($request->timesheetdate)) {
      echo "<option>Select client</option>";

      $selectedDate = \DateTime::createFromFormat('d-m-Y', $request->timesheetdate);
      $clientss = DB::table('assignmentteammappings')
        ->leftjoin('assignmentmappings', 'assignmentmappings.id', 'assignmentteammappings.assignmentmapping_id')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->orwhere('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
        ->whereNotIn('assignmentbudgetings.assignmentname', ['Unallocated', 'Official Travel', 'Off/Holiday', 'Seminar/Conference/Post Qualification Course'])
        ->whereNotIn('teammembers.team_member', ['NA'])
        ->where(function ($query) use ($selectedDate) {
          $query->whereNull('otpverifydate')
            ->orWhere('otpverifydate', '>=', $selectedDate->modify('-1 day'));
        })
        ->select('clients.client_name', 'clients.id', 'clients.client_code')
        ->orderBy('client_name', 'ASC')
        // ->distinct()->get();
        ->get();

      // done default $clients in ajax if need then $clientss add in ajax target $request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34
      $clients = DB::table('clients')
        ->whereIn('id', [29, 32, 33, 34])
        ->select('clients.client_name', 'clients.id', 'clients.client_code')
        ->orderBy('client_name', 'ASC')
        ->distinct()->get();

      $client = $clientss->merge($clients);

      foreach ($client as $clients) {
        echo "<option value='" . $clients->id . "'>" . $clients->client_name . '( ' . $clients->client_code . ' )' . "</option>";
      }
    }

    if (isset($request->cid)) {
      if (auth()->user()->role_id == 13) {
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
          foreach (DB::table('assignmentbudgetings')->where('client_id', $id)
            ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
            ->orderBy('assignment_name')->get() as $sub) {
            echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentname . '/' . $sub->assignmentgenerate_id . ' )' . "</option>";
          }
        } else {
          // dd('hi 3');

          $selectedDate = \DateTime::createFromFormat('d-m-Y', $request->datepickers);

          foreach (DB::table('assignmentbudgetings')
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
            ->orderBy('assignment_name')->get() as $sub) {
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
          foreach (DB::table('assignmentbudgetings')->where('client_id', $id)
            ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
            ->orderBy('assignment_name')->get() as $sub) {
            echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentname . '/' . $sub->assignmentgenerate_id . ' )' . "</option>";
          }
        } else {



          //  i have add this code after kartic bindal problem 
          $selectedDate = \DateTime::createFromFormat('d-m-Y', $request->datepickers);

          foreach (DB::table('assignmentbudgetings')
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
            ->orderBy('assignment_name')->get() as $sub) {
            echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentname . '/' . $sub->assignmentgenerate_id . ' )' . "</option>";
          }
        }
      }
    }

    if (isset($request->assignment)) {
      // dd($request->assignment);
      if (auth()->user()->role_id == 11) {
        echo "<option value=''>Select Partner</option>";
        foreach (DB::table('assignmentmappings')

          ->leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
          ->leftjoin('teammembers as team', 'team.id', 'assignmentmappings.otherpartner')
          ->where('assignmentmappings.assignmentgenerate_id', $request->assignment)
          ->select('team.team_member as team_member', 'team.id', 'teammembers.id', 'teammembers.team_member')
          ->get() as $subs) {
          echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
        }
      } elseif (auth()->user()->role_id == 13) {
        echo "<option value=''>Select Partner</option>";
        foreach (DB::table('teammembers')
          ->where('id', auth()->user()->teammember_id)
          ->select('teammembers.id', 'teammembers.team_member')
          ->get() as $subs) {
          echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
        }
      } else {
        //die;
        echo "<option value=''>Select Partner</option>";
        foreach (DB::table('assignmentmappings')

          ->leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
          ->leftjoin('teammembers as team', 'team.id', 'assignmentmappings.otherpartner')
          ->where('assignmentmappings.assignmentgenerate_id', $request->assignment)
          ->select('team.team_member as team_member', 'team.id', 'teammembers.id', 'teammembers.team_member')
          ->get() as $subs) {
          echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
        }
      }
    }
  } else {
    return view('backEnd.timesheet.create', compact('partner'));
  }
  // start hare 
  if ($request->ajax()) {
    $validatedData = $request->validate([
        'field' => 'required',
    ]);

    // Additional validation logic for AJAX requests
}
  // start hare 
  if ($request->ajax()) {
    return response()->json(['message' => 'This is an AJAX response']);
}



//* regarding old data / regarding flash 
$request->flash();
   // Clear flash data
session()->forget('_old_input');
      // Clear flash data
      session()->forget('_flash');
$request->flashOnly(['username', 'email']);
return redirect('form')->withInput();
 
return redirect()->route('user.create')->withInput();
 
return redirect('form')->withInput(
    $request->except('password')
);
$username = $request->old('username');
// <input type="text" name="username" value="{{ old('username') }}">
$value = $request->cookie('name');
$request->flashExcept('password');
$request->flash()->forget(['year', 'start_date', 'end_date']);
$request->session()->forget('_old_input');

$value = old('value');
 
$value = old('value', 'default');

{{ old('name', $user->name) }}
 
// Is equivalent to...
 
{{ old('name', $user) }}
return optional($user->address)->street;
 
{!! old('name', optional($user)->name) !!}
return optional(User::find($id), function (User $user) {
  return $user->name;
});
}

//! regarding old data / regarding flash 
$file = $request->file('photo');
 
$file = $request->photo;

if ($request->hasFile('photo')) {
  // ...
}

if ($request->file('photo')->isValid()) {
  // ...
}

$path = $request->photo->path();
 
$extension = $request->photo->extension();
$path = $request->photo->store('images');
 
$path = $request->photo->store('images', 's3');
$path = $request->photo->storeAs('images', 'filename.jpg');
 
$path = $request->photo->storeAs('images', 'filename.jpg', 's3');
//* unique validation 

$request->validate([
  // 'client_id' => "required",
  'client_id' => 'required|unique:assignmentbudgetings,client_id',
  'assignment_id' => "required",
  'teammember_id.*' => "required",
  'assignmentname' => "required",
  'type.*' => "required"
]);

//* regarding date All condition 
// Start hare
// Start hare

$recordsToDelete = DB::table('leaveapprove')
->where('teammemberid', 806)
->whereBetween('created_at', ['2024-08-01 00:00:00', '2024-12-05 23:59:59'])
->get();

dd($recordsToDelete);
// Start hare financial year 
'created_at' => $firstDate->format('Y-m-d') . ' ' . now()->format('H:i:s'),
'updated_at' => $firstDate->format('Y-m-d') . ' ' . now()->format('H:i:s'),
 // total working days start using financial year
 $currentDate = Carbon::now();
 $previewsunday1 = $previewsunday->subWeeks(1)->endOfWeek();
 $currentMonth = $currentDate->format('F');
 if ($currentDate->month >= 4) {
   // Current year financial year
   $startDate = Carbon::create($currentDate->year, 4, 1);
   $endDate = Carbon::create($currentDate->year + 1, 3, 31);
 } else {
   // Previous year financial year
   $startDate = Carbon::create($currentDate->year - 1, 4, 1);
   $endDate = Carbon::create($currentDate->year, 3, 31);
 }

 $totalworkingdays = DB::table('attendances')
   ->where('employee_name', auth()->user()->teammember_id)
   ->whereBetween('fulldate', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
   ->sum('no_of_days_present');

 // total working days end hare 
// Start hare financial year 
 // Get the current date
 
 $currentDate = now();
 $currentDate1 = Carbon::parse('2028-09-01 13:30:00');
 dd($currentDate1->day);
 $currentMonth = $currentDate->addMonth()->format('F');
 $currentDate = Carbon::now();
 $currentDate = Carbon::parse('2028-09-15 13:30:00');
 // Determine the current financial year based on whether the current date is before or after April 1st
 if ($currentDate->month >= 4) {
   // If the current date is in April or later, start from April 1st of the current year
   $startDate = Carbon::createFromDate($currentDate->year, 4, 1);
   $endDate = Carbon::createFromDate($currentDate->year + 1, 3, 31);
 } else {
   // If the current date is before April, start from April 1st of the previous year
   $startDate = Carbon::createFromDate($currentDate->year - 1, 4, 1);
   $endDate = Carbon::createFromDate($currentDate->year, 3, 31);
 }

 // Convert the start and end dates to the format 'Y-m-d' for comparison
 $startDateFormatted = $startDate->format('Y-m-d');
 $endDateFormatted = $endDate->format('Y-m-d');

 $attendancesrecord = DB::table('attendances')
   ->where('employee_name', auth()->user()->teammember_id)
   ->whereBetween('fulldate', [$startDateFormatted, $endDateFormatted])
   ->get();

 $totalworkingdays = $attendancesrecord->sum('no_of_days_present');
// Start hare
 // $attendances = DB::table('attendances')
      //   ->where('employee_name', auth()->user()->teammember_id)
      //   ->get();
      // $noOfDaysPresent = $attendances->pluck('no_of_days_present');
      // dd($noOfDaysPresent);

      // $currentDate = now();
      // $currentMonth = $currentDate->format('F');
      // $year = $currentDate->format('Y');

      // $attendancesrecord = DB::table('attendances')
      //   ->where('employee_name', auth()->user()->teammember_id)
      //   ->get();

      // $totalworkingdays = $attendancesrecord->sum('no_of_days_present');

      // $currentDate = now();
      // $currentMonth = $currentDate->format('F');
      // $year = $currentDate->format('Y');

      // $attendancesrecord = DB::table('attendances')
      //   ->where('employee_name', auth()->user()->teammember_id)
      //   ->whereBetween('fulldate', ['2024-04-01', '2025-03-01'])
      //   ->get();

      // $totalworkingdays = $attendancesrecord->sum('no_of_days_present');
      // dd($totalworkingdays);
// Start hare
foreach ($debtorsdatas as $debtorsdata) {

  // date compare with time 
  // $nextfivedays = Carbon::createFromFormat('Y-m-d H:i:s', $debtorsdata->updated_at)->addDays(5);
  $nextfivedays = Carbon::createFromFormat('Y-m-d H:i:s', $debtorsdata->updated_at);
  $currentdate = Carbon::now()->startOfDay();
  if ($nextfivedays == $currentdate) {
      dd('hi');
  }
  dd($nextfivedays);
  // date compare without time 
  $nextfivedays = Carbon::createFromFormat('Y-m-d H:i:s', $debtorsdata->updated_at);
  $currentdate = Carbon::now()->startOfDay();

  if ($nextfivedays->isSameDay($currentdate)) {
      dd('hi');
  }
}

// start hare
$todaydate = '2024-03-09';
$date = Carbon::createFromFormat('Y-m-d', $todaydate);
dd($date);

// start hare
if ($usertimesheetfirstdate && !empty($usertimesheetfirstdate->date)) {
  // if error is Not enough data available to satisfy format
}

// start hare
$autosubmitdate = Carbon::createFromFormat('Y-m-d', $usertimesheetfirstdate->date ?? '')->addDays(9);
// $autosubmitdate = Carbon::createFromFormat('Y-m-d', '2024-02-26' ?? '')->addDays(11);
$todaydate = Carbon::now('Asia/Kolkata');

if ($autosubmitdate->isSameDay($todaydate)) {
    dd('hi date');
}

// start hare
$date = Carbon::createFromFormat('Y-m-d', $usertimesheetfirstdate->date);
$autosubmitdate = $date->copy()->next(Carbon::SUNDAY)->addDays(3);
$todaydate = Carbon::now('Asia/Kolkata');

if ($autosubmitdate->isSameDay($todaydate)) {
    dd('hi date');
}

// start hare
$autosubmitdate = Carbon::createFromFormat('Y-m-d', $usertimesheetfirstdate->date ?? '')->addDays(9);
// $autosubmitdate = Carbon::createFromFormat('Y-m-d', '2024-02-26' ?? '')->addDays(11);
$todaydate = Carbon::now('Asia/Kolkata');
if ($autosubmitdate->isSameDay($todaydate)) {
    dd('hi date');
}
// Start hare
public function store(Request $request)
{
  // app\Http\Controllers\TimesheetController.php

      // Permission for Closed assignment
      $assignmentcloseddata = DB::table('assignmentbudgetings')->where('assignmentgenerate_id', $request->assignment_id[0])->first();
      $requestDate = \DateTime::createFromFormat('d-m-Y', $request->date);

      if ($assignmentcloseddata && $assignmentcloseddata->otpverifydate) {
        $assignmentcloseddate = \DateTime::createFromFormat('Y-m-d H:i:s', $assignmentcloseddata->otpverifydate)->setTime(23, 59, 59);
        if ($assignmentcloseddata->status == 0 && $assignmentcloseddate <= $requestDate) {
          $output = ['msg' => "This Assignment has closed : " . $request->assignment_id[0] . " You can not fill timesheet to Assignment name : " . $assignmentcloseddata->assignmentname . " Assignment id: " . $request->assignment_id[0]];
          return redirect('timesheet/mylist')->with('statuss', $output);
        }
      }

      // dd('hi 3', $count);
      for ($i = 0; $i < $count; $i++) {

        $assignment =  DB::table('assignmentmappings')->where('assignmentgenerate_id', $request->assignment_id[$i])->first();

        // Permission for Closed assignment
        $assignmentcloseddata2 = DB::table('assignmentbudgetings')->where('assignmentgenerate_id', $request->assignment_id[$i])->first();
        $requestDate = \DateTime::createFromFormat('d-m-Y', $request->date);
 
        if ($assignmentcloseddata2 && $assignmentcloseddata2->otpverifydate) {
          $assignmentcloseddate2 = \DateTime::createFromFormat('Y-m-d H:i:s', $assignmentcloseddata2->otpverifydate)->setTime(23, 59, 59);
          if ($assignmentcloseddata->status == 0 && $assignmentcloseddate2 <= $requestDate) {
            $output = ['msg' => "This Assignment has closed : " . $request->assignment_id[$i] . " You can not fill timesheet to: Assignment name " . $assignmentcloseddata->assignmentname . " Assignment id: " . $request->assignment_id[$i]];
            return redirect('timesheet/mylist')->with('statuss', $output);
          }
        }
      }
    } 
}

// Start hare  this is date testing / regarding testing
$selectedDate = \DateTime::createFromFormat('d-m-Y', '05-03-2024');
dd($selectedDate);


// Start hare  compare two difrent date formate like otpverifydate= 2024-02-20 12:38:56   $request->datepickers = 2024-02-20
$requestDate = \DateTime::createFromFormat('d-m-Y', $request->datepickers);

$var = DB::table('assignmentbudgetings')
  ->where('client_id', $request->cid)
  ->where(function ($query) use ($requestDate) {
    $query->whereNull('otpverifydate')
          // // ->orWhere('otpverifydate', '<=', $requestDate->modify('+1 day'));
          // ->orWhere('otpverifydate', '>=', $requestDate->modify('-1 day'));
      ->orWhere('otpverifydate', '>', $requestDate);
  })
  ->leftJoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
  ->orderBy('assignment_name')
  ->get();

dd($var);

// Start hare  increase 1 date and decrease 1 date from date 
$requestDate = \DateTime::createFromFormat('d-m-Y', $request->datepickers);

$var = DB::table('assignmentbudgetings')
  ->where('client_id', $request->cid)
  ->where(function ($query) use ($requestDate) {
    $query->whereNull('otpverifydate')
      // ->orWhere('otpverifydate', '<=', $requestDate->modify('+1 day'));
      ->orWhere('otpverifydate', '>=', $requestDate->modify('-1 day'));
  })
  ->leftJoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
  ->orderBy('assignment_name')
  ->get();


// Start hare
$period = CarbonPeriod::create($team->from, $team->to);
dd($period);
$datess = [];
foreach ($period as $date) {
  $datess[] = $date->format('Y-m-d');

  DB::table('timesheets')->where('date', $date->format('Y-m-d'))
    ->where('created_by', $team->createdby)->delete();
  DB::table('timesheetusers')->where('createdby', $team->createdby)
    ->where('date', $date->format('Y-m-d'))->delete();
}

// Start hare
$defaulttimesheetshowdate = DB::table('timesheetusers')
->where('timesheetusers.createdby', $teamid)
->whereIn('timesheetusers.status', [1, 2, 3])
->orderBy('date', 'DESC')
->first();
if ($defaulttimesheetshowdate) {
$to = $defaulttimesheetshowdate->date;
$fromformate = Carbon::createFromFormat('Y-m-d', $to);
// Subtract 6 days
$from = $fromformate->subDays(6)->toDateString();
}


//* regarding dd 

// start hare
// start hare
// start hare
dd([
  'exitDate' => $exitDate,
  'exitMonth' => $exitMonth,
  'exitYear' => $exitYear,
  'dayOfExit' => $dayOfExit,
  'totalDaysInExitMonth' => $totalDaysInExitMonth,
]);
      dd(
        'currentDate:',
        $currentDate,
        'currentMonth:',
        $currentMonth,
        'startDate:',
        $startDate,
        'endDate:',
        $endDate,
      );
// start hare
dd([
  'lasttimesheetsubmiteddata' => $lasttimesheetsubmiteddata,
  'timesheetmaxDateRecord' => $timesheetmaxDateRecord,
  'leavedataforcalander1' => $leavedataforcalander1,
  'differenceInDays' => $differenceInDays,
  'newteammember' => $newteammember,
  'rejoiningdate' => $rejoiningdate,
  'totalleaveCount' => $totalleaveCount,
  'leavebreakdateassign' => $leavebreakdateassign,
]);
// start hare
    dd('Duplicate deleted successfully', $deleteIds);
// start hare

dd('hi2', $request);
dd($checkopenorclosed->status, $assignmentcloseddate, $requestDate);

$updatedcamedate = $camefromexam->copy()->format('Y-m-d');
dd('hi2', $updatedcamedate);
dd($value);
dd($value1, $value2, $value3, ...);

dd([
  'data' => $pormotionandrejoiningdata,
  'joining_date' => $joining_date,
  'rejoining_date' => $rejoining_date
]);
// knowlege base modification  
//* regarding console
console.log("lasttimesheetsubmiteddata:", lasttimesheetsubmiteddata);
console.log("timesheetmaxDateRecord:", timesheetmaxDateRecord);
console.log("leavedataforcalander1:", leavedataforcalander1);
console.log("differenceInDays:", differenceInDays);
console.log("newteammember:", newteammember);
console.log("rejoiningdate:", rejoiningdate);
console.log("totalleaveCount:", totalleaveCount);
console.log("leavebreakdateassign:", leavebreakdateassign);

console.log("lasttimesheetsubmiteddata:", lasttimesheetsubmiteddata);
console.log("timesheetmaxDateRecord:", timesheetmaxDateRecord);
console.log("dateSelectionresult:", dateSelectionresult);
console.log("newteammember:", newteammember);
console.log("rejoiningdate:", rejoiningdate);
console.log("datanotexistaftermonday:", datanotexistaftermonday);
//* regarding otp
public function assignmentotpstore(Request $request)
{
  dd($request);
  $request->validate([
    'otp' => 'required'
  ]);

  try {
    $data = $request->except(['_token']);

    $otp = DB::table('assignmentbudgetings')
      ->where('otp', $request->otp)
      ->where('assignmentgenerate_id', $request->assignmentgenerateid)->first();
    if ($otp) {

      DB::table('assignmentbudgetings')
        ->where('assignmentgenerate_id', $request->assignmentgenerateid)->update([
          'status' => '0',
          'closedby'  => auth()->user()->teammember_id,
          'otpverifydate' => date('Y-m-d H:i:s')
        ]);
      $output = array('msg' => 'assignment closed successfully');
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
//*  regarding function / function call 

// Start hare
// Start hare
function sendAssignmentEmail($from, $to)
{
  // dd('hi');

  if (auth()->user()->role_id == 15) {
    // Check if the from or to date falls on Saturday or Sunday
    $restrictedDays = [Carbon::SATURDAY, Carbon::SUNDAY];

    if (in_array($from->dayOfWeek, $restrictedDays)) {
      return back()->with('statuss', ['msg' => 'You cannot select the from date on a weekend (Saturday or Sunday)']);
    }

    if (in_array($to->dayOfWeek, $restrictedDays)) {
      return back()->with('statuss', ['msg' => 'You cannot select the to date on a weekend (Saturday or Sunday)']);
    }
  } else {
    // Check if either the start or end date falls on a Sunday
    if ($from->dayOfWeek === Carbon::SUNDAY) {
      return back()->with('statuss', ['msg' => 'You cannot select from date on Sunday']);
    }

    if ($to->dayOfWeek === Carbon::SUNDAY) {
      return back()->with('statuss', ['msg' => 'You cannot select to date on Sunday']);
    }
  }

  // Check if the start date is a holiday
  $isHolidayFrom = DB::table('holidays')
    ->whereDate('startdate', '=', $from)
    ->orWhereDate('enddate', '=', $from)
    ->exists();

  if ($isHolidayFrom) {
    return back()->with('statuss', ['msg' => 'You cannot select the from date on a holiday']);
  }

  // Check if the end date is a holiday
  $isHolidayTo = DB::table('holidays')
    ->whereDate('startdate', '=', $to)
    ->orWhereDate('enddate', '=', $to)
    ->exists();

  if ($isHolidayTo) {
    return back()->with('statuss', ['msg' => 'You cannot select the to date on a holiday']);
  }
}
public function update($request){

  $to=$request->to;
  $from=$request->from;
  $result = $this->sendAssignmentEmail($from, $to);
  // dd($result);
  
  // If the function returns a redirect response, return it
  if ($result instanceof RedirectResponse) {
    return $result; // Redirects the user back with the error message.
  }

//   Key Points:
// Call sendAssignmentEmail with $this:

// Use $this->sendAssignmentEmail($from, $to) to call the function.
// Check for Redirect Response:

// Since sendAssignmentEmail can return a RedirectResponse (via return back()), check if the result is an instance of RedirectResponse and return it if so.
// Convert Input Dates:

// Convert request inputs to Carbon instances for compatibility with dayOfWeek and other date functions.
// Proceed After Validation:

// Only proceed with the update logic if sendAssignmentEmail does not return a response.
// Let me know if you have additional questions!

// other code can be also hare 



// Explanation in Detail:

// Purpose of the Code:

// The code is part of a larger function where you are calling another method (applyleaverestrected) that performs some validations or actions related to leave restrictions.
// This method (applyleaverestrected) is expected to return one of the following:
// A RedirectResponse if the validation or action fails (to redirect the user with an error message or status).
// null or another type of result if the validation passes, allowing the process to continue.



}



// Start hare
public function store(Request $request)
{

    // dd($id);
    if ($request->teammember_id != '0') {
        $count = count($request->teammember_id);
        // dd($request->assignment_id);
        $clientname = Client::where('id', $request->client_id)->select('client_name')->first();

        $assignmentpartner = Teammember::where('id', $request->leadpartner)->select('team_member')->first();

        // $teamleader =    DB::table('assignmentmappings')
        //     ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
        //     ->leftjoin('teammembers', 'teammembers.id', 'assignmentteammappings.teammember_id')
        //     ->where('assignmentmappings.assignmentgenerate_id', $assignmentgenerate)
        //     ->where('assignmentteammappings.type', '0')
        //     ->select('teammembers.team_member')
        //     ->get();

        $teamemail = DB::table('teammembers')->wherein('id', $request->teammember_id)->select('emailid')->get();
        // dd($teamemail);

        foreach ($teamemail as $teammember) {
            $data = array(
                'assignmentid' =>  $assignmentgenerate,
                'clientname' =>  $clientname->client_name,
                'assignmentname' =>  $request->assignmentname,
                'assignment_name' =>  $assignment_name,
                'emailid' =>  $teammember->emailid,
                'assignmentpartner' =>  $assignmentpartner->team_member,
                // 'teamleader' =>  $teamleader,

            );

            // Mail::send('emails.assignmentassign', $data, function ($msg) use ($data) {
            //     $msg->to($data['emailid']);
            //     $msg->subject('VSA New Assignment Assigned || ' . $data['assignmentname'] . ' / ' . $data['assignmentid']);
            // });
            $this->sendAssignmentEmail($data);
        }

        $teamemailpartner = DB::table('teammembers')->where('id', $request->leadpartner)->select('emailid')->first();
        // dd($teamemailpartner);
        if ($request->leadpartner !=  null) {
            $data = array(
                'assignmentid' =>  $assignmentgenerate,
                'clientname' =>  $clientname->client_name,
                'assignmentname' =>  $request->assignmentname,
                'assignment_name' =>  $assignment_name,
                'emailid' =>  $teamemailpartner->emailid,
                'assignmentpartner' =>  $assignmentpartner->team_member,
                // 'teamleader' =>  $teamleader,

            );

            // Mail::send('emails.assignmentassign', $data, function ($msg) use ($data) {
            //     $msg->to($data['emailid']);
            //     $msg->subject('VSA New Assignment Assigned || ' . $data['assignmentname'] . ' / ' . $data['assignmentid']);
            // });
            $this->sendAssignmentEmail($data);
        }
        $teamemailotherpartner = DB::table('teammembers')->where('id', $request->otherpartner)->select('emailid')->first();
        if ($request->otherpartner !=  null) {
            $data = array(
                'assignmentid' =>  $assignmentgenerate,
                'clientname' =>  $clientname->client_name,
                'assignmentname' =>  $request->assignmentname,
                'assignment_name' =>  $assignment_name,
                'emailid' =>  $teamemailotherpartner->emailid,
                'assignmentpartner' =>  $assignmentpartner->team_member,
                // 'teamleader' =>  $teamleader,

            );

            // Mail::send('emails.assignmentassign', $data, function ($msg) use ($data) {
            //     $msg->to($data['emailid']);
            //     $msg->subject('VSA New Assignment Assigned || ' . $data['assignmentname'] . ' / ' . $data['assignmentid']);
            // });
            $this->sendAssignmentEmail($data);
        }
    }

}

public function sendAssignmentEmail($data)
{
    Mail::send('emails.assignmentassign', $data, function ($msg) use ($data) {
        $msg->to($data['emailid']);
        $msg->subject('VSA New Assignment Assigned || ' . $data['assignmentname'] . ' / ' . $data['assignmentid']);
    });
}

// Start hare
public function pendingmail($id)
{
    try {
        $debtor = Debtor::findOrFail($id);

        $mailData = Template::where('type', $debtor->type)->firstOrFail();
        $description = $this->replacePlaceholders($mailData->description, $debtor);

        $data = [
            'name' => $debtor->name,
            'email' => $debtor->email,
            'year' => $debtor->year,
            'date' => $debtor->date,
            'amount' => $debtor->amount,
            'clientid' => $debtor->assignmentgenerate_id,
            'debtorid' => $debtor->id,
            'description' => $description,
            'yes' => 1,
            'no' => 0
        ];

        $this->sendEmail($data);

        return back()->with('success', 'Mail sent successfully');
    } catch (\Exception $e) {
        Log::error("Error sending email: " . $e->getMessage());
        return back()->withErrors(['msg' => 'Failed to send email'])->withInput();
    }
}

private function replacePlaceholders($description, $debtor)
{
    $placeholders = ["[name]", "[amount]", "[year]", "[date]", "[address]"];
    $values = [$debtor->name, $debtor->amount, $debtor->year, $debtor->date, $debtor->address];

    return str_replace($placeholders, $values, $description);
}

private function sendEmail($data)
{
    Mail::send('emails.debtorform', $data, function ($message) use ($data) {
        $message->to($data['email'])->subject('Regarding Pending Confirmation');
    });
}
// Start hare
public function pendingmail($id)
{
    // dd($id);
    try {
        $usermail = DB::table('debtors')->where('id', $id)->first();

        // Get mail for Debitor
        if ($usermail->type == 1) {
            // dd('debitor');
            $this->sendEmail($usermail);
        }
        // Get mail for crediter
        elseif ($usermail->type == 2) {
            // dd('crediter');
            $this->sendEmail($usermail);
        }
        // Get mail for bank
        else {
            // dd('bank');
            $this->sendEmail($usermail);
        }
        dd('hi4');
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

public function sendEmail($usermail)
{
    $maildata = DB::table('templates')->where('type', $usermail->type)->first();

    $des = $maildata->description;
    $healthy = ["[name]", "[amount]", "[year]", "[date]", "[address]"];
    $yummy   = ["$usermail->name", "$usermail->amount", "$usermail->year", "$usermail->date", "$usermail->address"];
    $description = str_replace($healthy, $yummy, $des);


    $data = array(
        'name' =>  $usermail->name,
        'email' =>  $usermail->email,
        'year' =>  $usermail->year,
        'date' =>  $usermail->date,
        'amount' =>  $usermail->amount,
        'clientid' => $usermail->assignmentgenerate_id,
        'debtorid' => $usermail->id,
        'description' => $description,
        'yes' => 1,
        'no' => 0
    );
    Mail::send('emails.debtorform', $data, function ($msg) use ($data) {
        $msg->to($data['email']);
        $msg->subject('Regarding Pending Confirmation');
    });
}
// Start hare



//* regarding url / regarding route /  regarding path

// strat 
$urlheader = $request->headers->get('referer');
$url = parse_url($urlheader);
$path = $url['path'];
$query = $url['query'] ?? null;


// if ($path == '/filtering-applyleve') {
//   return redirect('applyleave')->with('success', $output);
// } else {
//   return back()->with('success', $output);
// }

if ($path == '/openleave/0' && $query) {
  return back()->with('success', $output);
} else {
  return redirect('applyleave')->with('success', $output);
}
// strat 
public function filterDataAdmin(Request $request)
{
  $urlheader = $request->headers->get('referer');
  $url = parse_url($urlheader);
  $path = $url['path'];
  // dd($url);
  // this is for patner submitted timesheet 
  if (auth()->user()->role_id == 13 && $path == '/timesheet/partnersubmitted') {
    // dd($url);
  }
  // this is for team submitted timesheet on patner
  elseif (auth()->user()->role_id == 13 && $path == '/timesheet/teamlist') {
      // dd($url);
  }
  // this is for submitted timesheet on staff and manager 
  elseif (auth()->user()->role_id == 14 || auth()->user()->role_id == 15) {
    
  }
  // this is for team submitted timesheet on Admin
  else {
    
  }
}
// Start hare
use Illuminate\Support\Facades\URL;
echo URL::current();
// Start hare

        $currentPath = parse_url(url()->current(), PHP_URL_PATH);
        $previousPath = parse_url(url()->previous(), PHP_URL_PATH);
        // during upload teamwise  krasExceluploadteamwise
        // "/kras/excelupload/teamwise"
        // "/kras"



        // during final update teamwise  finaldraftsubmit
        // "/kras/finaldraftsubmit/606/11"
        // "/kras"

        // during delete  teamwise  deleteteamwiseKra
        //  "/kras/delete/606/11"
        // "/kras"

        // dd($currentPath, $previousPath);


        if (Str::startsWith($currentPath, '/kras/excelupload/teamwise')) {
            $notificationfile = 'krasteamnotification';
        } elseif (Str::startsWith($currentPath, '/kras/finaldraftsubmit')) {
            $notificationfile = 'krasteamnotification1';
        } elseif (Str::startsWith($currentPath, '/kras/delete')) {
            $notificationfile = 'krasteamnotification2';
        } else {
            $notificationfile = 'krasdefault';
        }
// Start hare
$currentPath = parse_url(url()->current(), PHP_URL_PATH);   // /kras/excelupload/teamwise
$previousPath = parse_url(url()->previous(), PHP_URL_PATH); // /kras

dd($currentPath, $previousPath);
// Start hare
$previous = url()->previous();
$fulluri = parse_url($previous, PHP_URL_PATH);
$uri = substr($fulluri, 0, strrpos($fulluri, '/'));
// Start hare
// Store the current URL in the session
session(['previous_url' => url()->current()]);
// Later, when you need to retrieve the previous URL path
$previousUrl = session('previous_url', '/');
$uri = parse_url($previousUrl, PHP_URL_PATH);
dd($uri);
// Start hare
$uri = request()->headers->get('referer');
$path = parse_url($uri, PHP_URL_PATH);
dd($path);

$previous = url()->previous();
$fulluri = parse_url($previous, PHP_URL_PATH);
$uri = substr($fulluri, 0, strrpos($fulluri, '/'));

if ($uri == '/assignmentlist') {
  $output = array('msg' => 'staff is already in team');
  return back()->with('success', $output);
} else {
  $output = array('msg' => 'staff is already in team');
  return back()->with('success', $output);
}

// Start hare
$previous = url()->previous();
$fulluri = parse_url($previous, PHP_URL_PATH);
$uri = substr($fulluri, 0, strrpos($fulluri, '/'));
dd($uri);
// Start hare
$current = url()->current();
$full = url()->full();
$previous = url()->previous();
$uri = $request->path();
// "mytimesheetlist/844"
$url = $request->url();
// Start hare
// "http://127.0.0.1:8000/mytimesheetlist/844"

$urlWithQueryString = $request->fullUrl();
    $request->fullUrlWithQuery(['type' => 'phone']);
    $request->fullUrlWithoutQuery(['type']);
$request->fullUrlWithoutQuery(['/mytimesheetlist/844']);

// "http://127.0.0.1:8000/mytimesheetlist/844"
$host = $request->getHost();
// "127.0.0.1"
$schemeAndHttpHost = $request->getSchemeAndHttpHost();
// "http://127.0.0.1:8000"
$method = $request->method();
 
if ($request->isMethod('post')) {
    // ...
}
if ($request->is('admin/*')) {
  // ...
}
if ($request->routeIs('admin.*')) {
  // ...
}
// create new url 
$url = url('user/profile');
// "http://127.0.0.1:8000/user/profile"
$url = url('user/profile', [1]);
    // "http://127.0.0.1:8000/user/profile/1"
$url = secure_url('user/profile');
$url = secure_url('user/profile', [1]);
$url = secure_asset('img/photo.jpg');
$url = asset('img/photo.jpg');

dd($previous);

$url = $request->url();
dd($url);

$referer = $request->headers->get('referer');
$parsedReferer = parse_url($referer);
$path = $parsedReferer['path'];

dd($path);
$name = $request->input('name', 'Sally');
$name = $request->input('products.0.name');
 
$names = $request->input('products.*.name');
$host = $request->getHost();
// "127.0.0.1"
$schemeAndHttpHost = $request->getSchemeAndHttpHost();
// "http://127.0.0.1:8000"

$ipAddress = $request->ip();
$ipAddresses = $request->ips();
$contentTypes = $request->getAcceptableContentTypes();
$input = $request->collect();
// $request->host();
// $request->httpHost();
// $request->schemeAndHttpHost();
dd($input);
  // "http://127.0.0.1:8000/timesheet/teamlist"
  //   /timesheet/teamlist

//* find err0r / regarding error 
// error is trailing data 
          // try {
          //   $camefromexam = Carbon::createFromFormat('Y-m-d', $team->date);
          //   dd($camefromexam);
          // } catch (\Exception $e) {
          //   dd('Error parsing date: ' . $e->getMessage());
          // }

          // try {
          //   $camefromexam = Carbon::createFromFormat('Y-m-d H:i:s', $team->date);
          //   dd($camefromexam);
          // } catch (\Exception $e) {
          //   dd('Error parsing date: ' . $e->getMessage());
          // }

          

//* regarding email / regarding otp /
// app\Http\Controllers\AssignmentController.php
public function assignmentotp(Request $request)
{

  // die;
  if ($request->ajax()) {
    if (isset($request->id)) {
      // $assignment = DB::table('assignmentmappings')
      //   ->where('assignmentgenerate_id', $request->id)
      //   ->first();

      $assignment = DB::table('assignmentmappings')
        ->where('assignmentmappings.assignmentgenerate_id', $request->id)
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->select('assignmentmappings.*', 'assignmentbudgetings.assignmentname', 'clients.client_name')
        ->first();

      $assignmentteammember = DB::table('assignmentteammappings')
        ->leftjoin('teammembers', 'teammembers.id', 'assignmentteammappings.teammember_id')
        ->where('assignmentmapping_id', $assignment->id)
        ->select('teammembers.team_member')
        ->get();

      // dd($assignmentteammember);


      $teammembers = DB::table('teammembers')
        ->where('id', auth()->user()->teammember_id)
        ->first();

      $otp = sprintf("%06d", mt_rand(1, 999999));

      DB::table('assignmentbudgetings')
        ->where('assignmentgenerate_id', $assignment->assignmentgenerate_id)->update([
          'otp'  => $otp,
        ]);
      $data = array(
        'asassignmentsignmentid' => $assignment->assignmentgenerate_id,
        'assignmentname' => $assignment->assignmentname,
        'client_name' => $assignment->client_name,
        'email' => $teammembers->emailid,
        'otp' => $otp,
        'name' => $teammembers->team_member,
        'assignmentteammember' => $assignmentteammember,
      );

      // dd($data);

      Mail::send('emails.assignmentclosed', $data, function ($msg) use ($data, $assignment) {
        $msg->to($data['email']);
        $msg->subject('Assignment Closed by OTP' . ' || ' . $assignment->assignmentgenerate_id);
      });

      return response()->json($assignment);
    }
  }
}


//* regarding store image/ regarding image store 
        // this code download any folder from public folder 
        public function zipfile(Request $request, $assignmentfolder_id) {
          // dd($assignmentfolder_id);

          // $userId = auth()->user()->id;
          $articlefiles = DB:: table('assignmentfolderfiles') -> where('assignmentfolder_id', $assignmentfolder_id) -> get();

          $zipFileName = 'mannat.zip';
          $zip = new ZipArchive;

          if ($zip -> open($zipFileName, ZipArchive:: CREATE) === TRUE) {
              foreach($articlefiles as $file) {
                  $filePath = public_path('backEnd/image/articlefiles/'.$file -> filesname);
                  if (File:: exists($filePath)) {
                      $zip -> addFile($filePath, $file -> filesname);
                  }
              }
              $zip -> close();
          }

          return response() -> download($zipFileName) -> deleteFileAfterSend(true);
      }

      // this code download any folder from storage folder 
      public function zipfile(Request $request, $assignmentfolder_id) {
          // dd($assignmentfolder_id);

          // $userId = auth()->user()->id;
          $fileName = DB:: table('assignmentfolderfiles') -> where('assignmentfolder_id', $assignmentfolder_id) -> get();

          $zipFileName = 'mannat.zip';
          $zip = new ZipArchive;

          if ($zip -> open($zipFileName, ZipArchive:: CREATE) === TRUE) {
              foreach($fileName as $file) {
                  // file path
                  $filePath = storage_path('image/task/'.$file -> filesname);
                  if (File:: exists($filePath)) {
                      $zip -> addFile($filePath, $file -> filesname);
                  }
              }
              $zip -> close();
          }
          // public\backEnd\image\articlefiles
          //  storage\image\task
          return response() -> download($zipFileName) -> deleteFileAfterSend(true);
      }

//*
$latesttimesheetreport = DB::table('timesheetreport')
    ->where('teamid', auth()->user()->teammember_id)
    ->max('enddate');
    // ->max('date');

dd($latesttimesheetreport);

$latesttimesheetreport = DB::table('timesheetreport')
->where('teamid', auth()->user()->teammember_id)
->orderBy('enddate', 'desc') // Order by 'enddate' in descending order
->first(); // Retrieve the first row

dd($latesttimesheetreport);

$nextweektimesheet = DB::table('timesheetusers')
->where('createdby', auth()->user()->teammember_id)
->whereIn('status', [0, 1])
->where('date', $formattedNextSaturday)
->first();

dd($nextweektimesheet);

//* regarding join 
// Start hare

// ------------------------------------------------------------------------------------------------------------------------------------
// |                            Query                                 |                           Description                            |
// ------------------------------------------------------------------------------------------------------------------------------------
// |  1. join('table', 'first', '=', 'second')                       | Inner join with the specified table on the given conditions.     |
// |  2. joinWhere('table', 'first', '=', 'second')                  | Inner join with the specified table and where conditions.        |
// |  3. joinSub($query, 'alias', 'first', '=', 'second')            | Inner join with a subquery and where conditions.                 |
// |  4. leftJoin('table', 'first', '=', 'second')                   | Left join with the specified table on the given conditions.      |
// |  5. leftJoinWhere('table', 'first', '=', 'second')              | Left join with the specified table and where conditions.         |
// |  6. leftJoinSub($query, 'alias', 'first', '=', 'second')        | Left join with a subquery and where conditions.                  |
// |  7. rightJoin('table', 'first', '=', 'second')                  | Right join with the specified table on the given conditions.     |
// |  8. rightJoinWhere('table', 'first', '=', 'second')             | Right join with the specified table and where conditions.        |
// |  9. rightJoinSub($query, 'alias', 'first', '=', 'second')       | Right join with a subquery and where conditions.                 |
// | 10. crossJoin('table')                                          | Cross join with the specified table.                             |
// | 11. joinWhereRaw('sql', bindings)                               | Inner join with raw WHERE clause.                                |
// | 12. leftJoinWhereRaw('sql', bindings)                           | Left join with raw WHERE clause.                                 |
// | 13. rightJoinWhereRaw('sql', bindings)                          | Right join with raw WHERE clause.                                |
// | 14. joinSub($query, 'alias', 'first', '=', 'second', 'type')   | Join with a subquery and specified type (inner, left, right).    |
// | 15. joinSub($query, 'alias', 'first', '=', 'second', 'type')   | Left join with a subquery and specified type (inner, left, right).|
// | 16. joinSub($query, 'alias', 'first', '=', 'second', 'type')   | Right join with a subquery and specified type (inner, left, right).|
// ------------------------------------------------------------------------------------------------------------------------------------

// start hare 
// join: Inner join with the specified table on the given conditions.
$query = DB::table('users')
    ->join('posts', 'users.id', '=', 'posts.user_id')
    ->select('users.*', 'posts.title', 'posts.content')
    ->get();

// Start Hare 
// joinWhere: Inner join with the specified table and where conditions.
$query = DB::table('orders')
    ->joinWhere('customers', 'orders.customer_id', '=', 'customers.id')
    ->where('orders.status', '=', 'pending')
    ->get();

// Start Hare 
// joinSub: Inner join with a subquery and where conditions.
$subquery = DB::table('posts')
    ->select('user_id', DB::raw('count(*) as post_count'))
    ->groupBy('user_id');

$query = DB::table('users')
    ->joinSub($subquery, 'post_count', 'users.id', '=', 'post_count.user_id')
    ->get();

// Start Hare 
// leftJoin: Left join with the specified table on the given conditions.

$query = DB::table('users')
    ->leftJoin('posts', 'users.id', '=', 'posts.user_id')
    ->select('users.*', 'posts.title', 'posts.content')
    ->get();

// Start Hare 
// leftJoinWhere: Left join with the specified table and where conditions.

$query = DB::table('orders')
    ->leftJoinWhere('customers', 'orders.customer_id', '=', 'customers.id')
    ->where('orders.status', '=', 'pending')
    ->get();

// Start Hare 
// leftJoinSub: Left join with a subquery and where conditions.

$subquery = DB::table('posts')
    ->select('user_id', DB::raw('count(*) as post_count'))
    ->groupBy('user_id');

$query = DB::table('users')
    ->leftJoinSub($subquery, 'post_count', 'users.id', '=', 'post_count.user_id')
    ->get();

// Start Hare 
// rightJoin: Right join with the specified table on the given conditions. (Similar to leftJoin, but reversed)

$query = DB::table('posts')
    ->rightJoin('users', 'posts.user_id', '=', 'users.id')
    ->select('users.*', 'posts.title', 'posts.content')
    ->get();

// Start Hare 
// rightJoinWhere: Right join with the specified table and where conditions. (Similar to leftJoinWhere, but reversed)

$query = DB::table('orders')
    ->rightJoinWhere('customers', 'orders.customer_id', '=', 'customers.id')
    ->where('orders.status', '=', 'pending')
    ->get();

// Start Hare 
// rightJoinSub: Right join with a subquery and where conditions. (Similar to leftJoinSub, but reversed)

$subquery = DB::table('posts')
    ->select('user_id', DB::raw('count(*) as post_count'))
    ->groupBy('user_id');

$query = DB::table('users')
    ->rightJoinSub($subquery, 'post_count', 'users.id', '=', 'post_count.user_id')
    ->get();

// Start Hare
// crossJoin: Cross join with the specified table.

$query = DB::table('users')
    ->crossJoin('roles')
    ->get();

// Start Hare 
// joinWhereRaw: Inner join with raw WHERE clause.

$query = DB::table('users')
    ->joinWhereRaw('posts', 'posts.user_id = users.id AND posts.published = ?', ['yes'])
    ->get();

// Start Hare 
// leftJoinWhereRaw: Left join with raw WHERE clause.
$query = DB::table('users')
    ->leftJoinWhereRaw('posts', 'posts.user_id = users.id AND posts.published = ?', ['yes'])
    ->get();

// Start Hare 
// rightJoinWhereRaw: Right join with raw WHERE clause.
$query = DB::table('posts')
    ->rightJoinWhereRaw('users', 'posts.user_id = users.id AND users.active = ?', ['yes'])
    ->get();

// Start Hare 
// joinSub: Join with a subquery and specified type (inner, left, right).
$subquery = DB::table('posts')
    ->select('user_id', DB::raw('count(*) as post_count'))
    ->groupBy('user_id');

$query = DB::table('users')
    ->joinSub($subquery, 'post_count', 'users.id', '=', 'post_count.user_id')
    ->get();

// Start Hare 
// leftJoinSub: Left join with a subquery and specified type (inner, left, right).
$subquery = DB::table('posts')
    ->select('user_id', DB::raw('count(*) as post_count'))
    ->groupBy('user_id');

$query = DB::table('users')
    ->leftJoinSub($subquery, 'post_count', 'users.id', '=', 'post_count.user_id')
    ->get();

// Start Hare 
// rightJoinSub: Right join with a subquery and specified type (inner, left, right).
$subquery = DB::table('posts')
    ->select('user_id', DB::raw('count(*) as post_count'))
    ->groupBy('user_id');

$query = DB::table('users')
    ->rightJoinSub($subquery, 'post_count', 'users.id', '=', 'post_count.user_id')
    ->get();

// Start Hare 




//* regarding where clouse / 

// ------------------------------------------------------------------------------------------------------------------------------------
// |                            Query                                 |                           Description                            |
// ------------------------------------------------------------------------------------------------------------------------------------
// |  1. where('column', '=', 'value')                               | Adds a basic WHERE clause to the query.                         |
// |  2. orWhere('column', '=', 'value')                             | Adds an OR condition to the WHERE clause.                       |
// |  3. whereBetween('column', [value1, value2])                    | Adds a WHERE BETWEEN clause to the query.                       |
// |  4. whereNotBetween('column', [value1, value2])                 | Adds a WHERE NOT BETWEEN clause to the query.                   |
// |  5. whereIn('column', [value1, value2, ...])                    | Adds a WHERE IN clause to the query.                            |
// |  6. whereNotIn('column', [value1, value2, ...])                 | Adds a WHERE NOT IN clause to the query.                        |
// |  7. whereNull('column')                                        | Adds a WHERE NULL clause to the query.                          |
// |  8. whereNotNull('column')                                     | Adds a WHERE NOT NULL clause to the query.                      |
// |  9. whereColumn('column1', '=', 'column2')                     | Adds a comparison of two columns to the WHERE clause.           |
// |  10. whereDate('column', '=', 'date')                           | Adds a WHERE clause comparing a column's value to a date.       |
// |  11. whereDay('column', '=', 'day')                             | Adds a WHERE clause comparing a column's day part to a value.   |
// |  12. whereMonth('column', '=', 'month')                         | Adds a WHERE clause comparing a column's month part to a value. |
// |  13. whereYear('column', '=', 'year')                           | Adds a WHERE clause comparing a column's year part to a value.  |
// |  14. whereTime('column', '=', 'time')                           | Adds a WHERE clause comparing a column's time part to a value.  |
// |  15. whereJsonContains('column', 'value')                       | Adds a WHERE JSON_CONTAINS clause to the query.                 |
// |  16. whereJsonDoesntContain('column', 'value')                  | Adds a WHERE JSON_CONTAINS clause with negation to the query.   |
// |  17. whereJsonLength('column', 'operator', 'value')             | Adds a WHERE JSON_LENGTH clause to the query.                   |
// |  18. whereRaw('SQL statement')                                  | Adds a raw WHERE clause to the query.                           |
// ------------------------------------------------------------------------------------------------------------------------------------
        $teammemberall = Teammember::where('role_id', '=', 15)->orwhere('role_id', '=', 14)->where('status', '=', 1)->with('title', 'role')->get();
        $teammemberall = Teammember::whereIn('role_id', [15, 14])
            ->where('status', 1)
            ->with('title', 'role')
            ->get();
->distinct('partner')
->distinct()
  // start hare 
  ->where(function ($query) {
    $query->where('age', '>', 25)
          ->orWhere('city', 'New York');
})
->whereDate('timesheetrequests.created_at', '>', $permotioncheck->created_at)
  ->whereBetween('date', [$date, '2024-03-22'])
  ->whereBetween('date', [$nextweektimesheets->startdate, $nextweektimesheets->enddate])
   ->whereBetween('date', ['2024-03-11', '2024-03-16'])
  ->whereNotIn('createdby', [234, 453])
  ->whereJsonContains('timesheetreport.partnerid', auth()->user()->teammember_id)
     ->whereBetween('startdate', ['2023-12-11', '2024-03-25'])
  ->whereBetween('created_at', ['2023-09-01 16:45:30', '2023-12-31 16:45:30'])
  ->whereIn('timesheetusers.status', [1, 2, 3])
  ->whereNotNull('clients.client_name')
  ->whereNull('partnerid')
  // start hare 
$clientss = DB::table('assignmentmappings')
->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
->where(function ($query) {
  $query->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
    ->orWhere('assignmentmappings.otherpartner', auth()->user()->teammember_id);
})
->where('assignmentbudgetings.status', 1)
->select('clients.client_name', 'clients.id', 'clients.client_code')
->orderBy('client_name', 'ASC')
->distinct()
->distinct()->get();
  // start hare 
  ->whereBetween('date', ['2024-03-11', '2024-03-16'])


  // start hare 
foreach (DB::table('assignmentbudgetings')
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
->orderBy('assignment_name')->get() as $sub) {
echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentname . '/' . $sub->assignmentgenerate_id . ' )' . "</option>";
}
  // start hare 
$clientss = DB::table('assignmentteammappings')
->leftjoin('assignmentmappings', 'assignmentmappings.id', 'assignmentteammappings.assignmentmapping_id')
->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
->orwhere('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
// i have add this line becouse manager contain it but staff not contain it so basically after add this code no contain staff and manager 
->whereNotIn('assignmentbudgetings.assignmentname', ['Unallocated', 'Official Travel', 'Off/Holiday', 'Seminar/Conference/Post Qualification Course'])

->select('clients.client_name', 'clients.id', 'clients.client_code', 'assignmentbudgetings.*')
->orderBy('client_name', 'ASC')
->distinct()->get();
dd($clientss);
  // start hare 

$data = DB::table('assignmentbudgetings')
->where('assignmentbudgetings.client_id', 123)
->leftJoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
->where(function ($query) {
  $query->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
    ->orWhere('assignmentmappings.otherpartner', auth()->user()->teammember_id);
})
->where('assignmentbudgetings.status', 1)
// ->orderBy('assignment_name')->get();
->select('assignmentbudgetings.*')
->get();

dd($data);


foreach (DB::table('assignmentbudgetings')
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
->orderBy('assignment_name')->get() as $sub) {
echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentname . '/' . $sub->assignmentgenerate_id . ' )' . "</option>";
}

  // start hare 
//* regarding job / job implementation 

// function in controller 
public function zipfolderdownload(Request $request, $assignmentgenerateid)
{
    ZipFolderDownloadJob::dispatch($assignmentgenerateid);

    // return redirect('teammember')->with('status', $output);
    // $output = array('msg' => 'Download has been initiated please wait some time ');
    // return back()->with('success', $output);
}

// job file 
<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use ZipArchive;

class ZipFolderDownloadJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $assignmentgenerateid;

    public function __construct($assignmentgenerateid)
    {
        $this->assignmentgenerateid = $assignmentgenerateid;
    }

    public function handle()
    {

        $assignmentgenerateid = $this->assignmentgenerateid;


        $assignmentfoldername = DB::table('assignmentfolders')
            ->leftJoin('assignmentfolderfiles', 'assignmentfolderfiles.assignmentfolder_id', 'assignmentfolders.id')
            ->where('assignmentfolders.assignmentgenerateid', $assignmentgenerateid)
            ->select('assignmentfolders.*', 'assignmentfolderfiles.filesname')
            ->get();

        // Set Downloaded folder name 
        $parentZipFileName = $assignmentgenerateid . '.zip';
        $parentZip = new ZipArchive;

        // Open parent zip
        if ($parentZip->open($parentZipFileName, ZipArchive::CREATE) === TRUE) {
            foreach ($assignmentfoldername as $foldername) {
                $folderZipFileName = $foldername->assignmentfoldersname . '.zip';
                $zip = new ZipArchive;

                // Open Child zip
                if ($zip->open($folderZipFileName, ZipArchive::CREATE) === TRUE) {
                    if ($foldername->filesname != null) {
                        // Replace server path here 
                        $filePath = storage_path('app/public/image/task/' . $foldername->filesname);
                    }

                    if (file_exists($filePath)) {
                        // Add file in folder 
                        $zip->addFile($filePath, $foldername->filesname);
                    }

                    $zip->close();
                    $parentZip->addFile($folderZipFileName, $foldername->assignmentfoldersname . '/' . $foldername->filesname);
                }
            }

            $parentZip->close();
        }

        // Dispatch another job to delete the temporary files after download
        DeleteTemporaryFilesJob::dispatch($parentZipFileName);
        // return response()->download($parentZipFileName)->deleteFileAfterSend(true);
    }
}
// after download delete then use or otherwise not 
<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\File;

class DeleteTemporaryFilesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    public function handle()
    {
        // Delete the temporary files
        File::delete($this->filePath);
    }
}



//* regarding fetch data using take() 

$timesheetData = DB::table('timesheetusers')
->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
->where('timesheetusers.createdby', $teamid)
->whereIn('timesheetusers.status', [1, 2, 3])
->select('timesheetusers.*', 'teammembers.team_member')
// ->orderBy('date', 'DESC')->get();
->orderBy('date', 'DESC')
->take(7)
->get();
    // Default show 7 days data 
    $defaulttimesheetshowdate = DB::table('timesheetusers')
      ->where('timesheetusers.createdby', $teamid)
      ->whereIn('timesheetusers.status', [1, 2, 3])
      ->orderBy('date', 'DESC')
      ->first();
    if ($defaulttimesheetshowdate) {
      $to = $defaulttimesheetshowdate->date;
      $fromformate = Carbon::createFromFormat('Y-m-d', $to);
      // Subtract 6 days
      $from = $fromformate->subDays(6)->toDateString();
    }

    $timesheetData = DB::table('timesheetusers')
    ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
    ->where('timesheetusers.createdby', $teamid)
    ->where('timesheetusers.date', '<=', $to)
    ->where('timesheetusers.date', '>=', $from)
    ->whereIn('timesheetusers.status', [1, 2, 3])
    ->select('timesheetusers.*', 'teammembers.team_member')->orderBy('date', 'DESC')->get();
    // Default show 7 days data end hare 
//* number / decimal value / regarding decimal

round($file->getSize() / 1024, 2)
$totalFileSizeMB = round($totalFileSizeKB / 1024, 2);
//* zip download 
public function zipfolderdownload(Request $request, $assignmentgenerateid)
    {
        // Get All folder data and folder name 
        $assignmentfoldername = DB::table('assignmentfolders')
            ->leftJoin('assignmentfolderfiles', 'assignmentfolderfiles.assignmentfolder_id', 'assignmentfolders.id')
            ->where('assignmentfolders.assignmentgenerateid', $assignmentgenerateid)
            ->select('assignmentfolders.*', 'assignmentfolderfiles.filesname')
            ->get();

        // Set Downloaded folder name 
        $parentZipFileName = $assignmentgenerateid . '.zip';
        $parentZip = new ZipArchive;

        // Open parent zip
        if ($parentZip->open($parentZipFileName, ZipArchive::CREATE) === TRUE) {
            foreach ($assignmentfoldername as $foldername) {
                $folderZipFileName = $foldername->assignmentfoldersname . '.zip';
                $zip = new ZipArchive;

                // Open Child zip
                if ($zip->open($folderZipFileName, ZipArchive::CREATE) === TRUE) {
                    // Replace server path hare 
                    // $filePath = storage_path('app/public/image/task/' . $foldername->filesname);
                    if ($foldername->filesname != null) {
                        $filePath = storage_path('app/public/image/task/' . $foldername->filesname);
                    }
                    // else {
                    //     $filePath = storage_path('app/public/image/task/' . "Screenshoasast_7.png");
                    // }

                    if (file_exists($filePath)) {
                        // Add file in folder 
                        $zip->addFile($filePath, $foldername->filesname);
                    }
                    // else {
                    //     return '<h1>File Not Found</h1>';
                    // }

                    $zip->close();
                    $parentZip->addFile($folderZipFileName, $foldername->assignmentfoldersname . '/' . $foldername->filesname);
                }
            }

            $parentZip->close();
        }
        // dd($parentZipFileName);
        // Download the parent zip file
        return response()->download($parentZipFileName)->deleteFileAfterSend(true);
    }
//* regarding file store / store file size / regarding database / regarding table 
public function store(Request $request)
{
    $request->validate([
        'particular' => 'required',
        'file' => 'required',
    ]);

    try {
        $data = $request->except(['_token']);
        $files = [];

        if ($request->hasFile('file')) {
            foreach ($request->file('file') as $file) {
                $name = $file->getClientOriginalName();
                // store data here storage\app\public\image\task
                $path = $file->storeAs('public\image\task', $name);
                $files[] = [
                    'name' => $name,
                    // Get the file size in bytes
                    'size' => $file->getSize(),
                    // Get the file size in kb aur blade per kb mb and gb me convert kar le 
                    // 'size' => round($file->getSize() / 1024, 2),
                ];
            }
        }
        // dd($files);

        foreach ($files as $file) {
            $s = DB::table('assignmentfolderfiles')->insert([
                'particular' => $request->particular,
                'assignmentgenerateid' => $request->assignmentgenerateid,
                'assignmentfolder_id' => $request->assignmentfolder_id,
                'createdby' => auth()->user()->teammember_id,
                'filesname' => $file['name'],
                'filesize' => $file['size'], // Save the file size to the database
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        $output = array('msg' => 'Submit Successfully');
        return back()->with('success', ['message' => $output, 'success' => true]);
    } catch (Exception $e) {
        DB::rollBack();
        Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
        report($e);
        $output = array('msg' => $e->getMessage());
        return back()->withErrors($output)->withInput();
    }
}

$permissiontimesheet = DB::table('timesheetreport')->first();

if ($permissiontimesheet) {
    // Access properties of $permissiontimesheet here
    // Example: $permissiontimesheet->columnName
} else {
    // Handle case where no record was found
}
//* zip download on assignment folder all 
 // public function zipfolderdownload(Request $request, $assignmentgenerateid)
    // {
    //     $assignmentfoldername = DB::table('assignmentfolders')
    //         ->leftJoin('assignmentfolderfiles', 'assignmentfolderfiles.assignmentfolder_id', 'assignmentfolders.id')
    //         ->where('assignmentfolders.assignmentgenerateid', $assignmentgenerateid)
    //         ->select('assignmentfolders.*', 'assignmentfolderfiles.filesname')
    //         ->get();

    //     $zipFileNames = [];

    //     foreach ($assignmentfoldername as $foldername) {
    //         $zipFileName = $foldername->assignmentfoldersname . '.zip';
    //         $zipFileNames[] = $zipFileName;

    //         $zip = new ZipArchive;
    //         if ($zip->open($zipFileName, ZipArchive::CREATE) === TRUE) {
    //             // Replace storage_path with the appropriate file path
    //             $filePath = storage_path('app/public/image/task/' . $foldername->filesname);

    //             if (file_exists($filePath)) {
    //                 $zip->addFile($filePath, $foldername->filesname);
    //             } else {
    //                 return '<h1>File Not Found</h1>';
    //             }

    //             $zip->close();
    //         }
    //     }
    //     // dd($zipFileNames);
    //     // Download all zip files
    //     foreach ($zipFileNames as $zipFileName) {
    //         return response()->download($zipFileName)->deleteFileAfterSend(true);
    //     }
    // }

    public function zipfolderdownload(Request $request, $assignmentgenerateid)
    {
        $assignmentfoldername = DB::table('assignmentfolders')
            ->leftJoin('assignmentfolderfiles', 'assignmentfolderfiles.assignmentfolder_id', 'assignmentfolders.id')
            ->where('assignmentfolders.assignmentgenerateid', $assignmentgenerateid)
            ->select('assignmentfolders.*', 'assignmentfolderfiles.filesname')
            ->get();

        $parentZipFileName = 'report_name.zip';
        $parentZip = new ZipArchive;

        if ($parentZip->open($parentZipFileName, ZipArchive::CREATE) === TRUE) {
            foreach ($assignmentfoldername as $foldername) {
                $folderZipFileName = $foldername->assignmentfoldersname . '.zip';
                $zip = new ZipArchive;

                if ($zip->open($folderZipFileName, ZipArchive::CREATE) === TRUE) {
                    // Replace storage_path with the appropriate file path
                    $filePath = storage_path('app/public/image/task/' . $foldername->filesname);

                    if (file_exists($filePath)) {
                        $zip->addFile($filePath, $foldername->filesname);
                    } else {
                        return '<h1>File Not Found</h1>';
                    }

                    $zip->close();
                    $parentZip->addFile($folderZipFileName, $foldername->assignmentfoldersname . '/' . $foldername->filesname);
                    // No need to delete individual folder zip here
                }
            }

            $parentZip->close();
        }

        // Download the parent zip file
        return response()->download($parentZipFileName)->deleteFileAfterSend(true);
    }
//* count data 
$totalFiles = count($zipFileNames);
//* check array data / testing foreeach / regarding foreach
//start hare

$holidayCount = 0;
foreach ($getholidaydates as $holiday) {
    $holidayCount += intval($holiday->number_of_dates);
}
dd($holidayCount);
//start hare
$zipfoldername1 = [];
foreach ($assignmentfoldername as $foldername) {
    $zipfoldername = $foldername->assignmentfoldersname . '.zip';
    // Add each zip folder name to the array
    $zipfoldername1[] = $zipfoldername;
}
dd($zipfoldername1);

// output
array:2 [▼
  0 => "Shahid f.zip"
  1 => "rahul.zip"
]


//* online excell editing
https://www.microsoft365.com/launch/excel?auth=1
//* regarding next week / regarding preious week / regarding week
 // -----------------------------Shahid coding start------------------------------------------
            // Get latest submited timesheet end date from timesheetreport table
            $latesttimesheetreport =  DB::table('timesheetreport')
                ->where('teamid', auth()->user()->teammember_id)
                ->orderBy('id', 'desc')
                ->first();
            // dd($latesttimesheetreport);

            $timesheetreportenddate = Carbon::parse($latesttimesheetreport->enddate);
            // find next sturday 
            $nextSaturday = $timesheetreportenddate->copy()->next(Carbon::SATURDAY);
            $previousMonday = $requestedDate->copy()->previous(Carbon::MONDAY);
            $formattedNextSaturday = $nextSaturday->format('Y-m-d');
            $formattedNextSaturday1 = $timesheetreportenddate->format('d-m-Y');

            // find next week timesheet filled or not 
            $nextweektimesheet = DB::table('timesheetusers')
                ->where('createdby', auth()->user()->teammember_id)
                ->where('status', '0')
                ->where('date', $formattedNextSaturday)
                ->first();
            // dd($nextweektimesheet);

            // if not filled next week timesheet then 
            if ($nextweektimesheet == null) {
                $output = array('msg' => "Fill the Week timesheet After this week : $formattedNextSaturday1");
                return back()->with('statuss', $output);
            }
            // -----------------------------Shahid coding end------------------------------------------
           
//* function only for testing / testing function / regarding testing

    //! for testing only 
    public function timesheetsubmission(Request $request)
    {
        try {
            // Get latest timesheet end date from timesheetreport table
            $latesttimesheetreport =  DB::table('timesheetreport')
                ->where('teamid', auth()->user()->teammember_id)
                ->orderBy('id', 'desc')
                ->first();
            // dd($latesttimesheetreport);

            $timesheetreportenddate = Carbon::parse($latesttimesheetreport->enddate);
            $nextSaturday = $timesheetreportenddate->copy()->next(Carbon::SATURDAY);
            // dd($nextSaturday);
            $formattedNextSaturday = $nextSaturday->format('Y-m-d');
            $formattedNextSaturday1 = $nextSaturday->format('d-m-Y');


            $nextweektimesheet = DB::table('timesheetusers')
                ->where('createdby', auth()->user()->teammember_id)
                ->where('status', '0')
                ->where('date', $formattedNextSaturday)
                ->first();
            // dd($nextweektimesheet);

            if ($nextweektimesheet == null) {
                $output = array('msg' => "Fill the timesheet After this week : $formattedNextSaturday1");
                return back()->with('success', $output);
            }
            // dd($latesttimesheetreport);
            // -------------------------Shahid coding end hare -----------------------------
            else {

                $output = array('msg' => 'Timesheet Submit Successfully');
                return back()->with('success', $output);
            }

            // Check previous week timesheet 

        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }


//* regarding year / year wise filter

$approvedleavesvalue = DB::table('applyleaves')
->where('createdby', auth()->user()->teammember_id)
->where('status', 1)
->whereYear('from', 2024)
->get();

dd($approvedleavesvalue);
$currentDate = now();
$month = $currentDate->format('F');
$year = $currentDate->format('Y');
$timesheetData = DB::table('timesheetusers')
->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
->where('timesheetusers.createdby', auth()->user()->teammember_id)
->where('timesheetusers.status', 0)
//   ->where('timesheets.month', $month)
->whereRaw('YEAR(timesheetusers.date) = ?', [$year])
->select('timesheetusers.*', 'teammembers.team_member')->orderBy('id', 'DESC')->get();
//  dd($timesheetData);
//* redirection in javascript
if (!shouldContinue) {
  // Redirect to a specific URL when the user clicks Cancel
  window.location.href = "{{ url('/teammember') }}";
  return;
  }
//* filtering functionality / regarding filter / filter functionality

// start hare 

// end hare good for all condition 

  // Apply leave filter
  public function filterDataAdmin(Request $request)
  {
    $teamname = $request->input('employee');
    $leavetype = $request->input('leave');
    $startdate = $request->input('start');
    $enddate = $request->input('end');
    $statusdata = $request->input('status');
    $startperioddata = $request->input('startperiod');
    $endperioddata = $request->input('endperiod');

    $query = DB::table('applyleaves')
      ->leftJoin('leavetypes', 'leavetypes.id', '=', 'applyleaves.leavetype')
      ->leftJoin('teammembers', 'teammembers.id', '=', 'applyleaves.createdby')
      ->leftJoin('teammembers as approvername', 'approvername.id', '=', 'applyleaves.approver')
      ->leftJoin('roles', 'roles.id', '=', 'teammembers.role_id')
      ->select('applyleaves.*', 'teammembers.team_member', 'roles.rolename', 'leavetypes.name', 'approvername.team_member as approvernames');

    if (auth()->user()->role_id == 13) {
      $query->where('applyleaves.approver', auth()->user()->teammember_id);
    }

    // For admin
    if ($teamname) {
      $query->where('applyleaves.createdby', $teamname);
    }

    if ($leavetype) {
      $query->where('applyleaves.leavetype', $leavetype);
    }

    if ($statusdata !== null) {
      $query->where('applyleaves.status', $statusdata);
    }

    if ($startdate && $enddate) {
      $query->whereBetween('applyleaves.created_at', [$startdate, $enddate]);
    }

    if ($startperioddata && $endperioddata) {
      $query->whereBetween('applyleaves.from', [$startperioddata, $endperioddata]);
    }

    $filteredData = $query->get();

    return response()->json($filteredData);
  }


// convert when clouse to good code 
  // Apply leave filter
  public function filterDataAdmin(Request $request)
  {
    $teamname = $request->input('employee');
    $leavetype = $request->input('leave');
    $startdate = $request->input('start');
    $enddate = $request->input('end');
    $statusdata = $request->input('status');
    $startperioddata = $request->input('startperiod');
    $endperioddata = $request->input('endperiod');

    $query = DB::table('applyleaves')
      ->leftJoin('leavetypes', 'leavetypes.id', '=', 'applyleaves.leavetype')
      ->leftJoin('teammembers', 'teammembers.id', '=', 'applyleaves.createdby')
      ->leftJoin('teammembers as approvername', 'approvername.id', '=', 'applyleaves.approver')
      ->leftJoin('roles', 'roles.id', '=', 'teammembers.role_id')
      ->select('applyleaves.*', 'teammembers.team_member', 'roles.rolename', 'leavetypes.name', 'approvername.team_member as approvernames');

    if (auth()->user()->role_id == 13) {
      $query->where('applyleaves.approver', auth()->user()->teammember_id);
    }

    // For admin
    if ($teamname) {
      $query->where('applyleaves.createdby', $teamname);
    }

    if ($leavetype) {
      $query->where('applyleaves.leavetype', $leavetype);
    }

    if ($statusdata !== null) {
      $query->where('applyleaves.status', $statusdata);
    }

    if ($startdate && $enddate) {
      $query->whereBetween('applyleaves.created_at', [$startdate, $enddate]);
    }

    if ($startperioddata && $endperioddata) {
      $query->whereBetween('applyleaves.from', [$startperioddata, $endperioddata]);
    }

    $filteredData = $query->get();

    return response()->json($filteredData);
  }


public function searchingtimesheet(Request $request)
{
  // Get all input from form
  $startDate = $request->input('startdate', null);
  $endDate = $request->input('enddate', null);
  $teamId = $request->input('teamid', null);
  $teammemberId = $request->input('teammemberId', null);
  $year = $request->input('year', null);

  $teammembers = DB::table('teammembers')
    ->where('status', 1)
    ->whereIn('role_id', [14, 15, 13, 11])
    ->select('team_member', 'id', 'staffcode')
    ->orderBy('team_member', 'ASC')
    ->get();

  // For patner
  if (auth()->user()->role_id == 13) {
    $query = DB::table('timesheetusers')
      ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
      ->whereIn('timesheetusers.status', [1, 2, 3])
      ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
      ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
      ->leftjoin('teammembers as patnerid', 'patnerid.id', 'timesheetusers.partner')
      ->select('timesheetusers.*', 'assignments.assignment_name', 'clients.client_name', 'teammembers.team_member', 'patnerid.team_member as patnername')
      ->orderBy('date', 'DESC');

    if ($startDate && $endDate && $teamId) {
      $query->where(function ($q) use ($startDate, $endDate, $teamId) {
        $q->where('timesheetusers.createdby', $teamId)
          ->where('timesheetusers.date', '>=', $startDate)
          ->where('timesheetusers.date', '<=', $endDate);
      });
    }

    $timesheetData = $query->get();
    // dd($timesheetData);
    $request->flash();
    return view('backEnd.timesheet.timesheetdownload', compact('timesheetData'));
  }
  // For staff and manager
  else {

    $query = DB::table('timesheetusers')
      ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
      ->whereIn('timesheetusers.status', [1, 2, 3])
      ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
      ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
      ->leftjoin('teammembers as patnerid', 'patnerid.id', 'timesheetusers.partner')
      ->select('timesheetusers.*', 'assignments.assignment_name', 'clients.client_name', 'teammembers.team_member', 'patnerid.team_member as patnername')
      ->orderBy('date', 'DESC');

    if ($startDate && $endDate && $teamId) {
      $query->where(function ($q) use ($startDate, $endDate, $teamId) {
        $q->where('timesheetusers.createdby', $teamId)
          ->where('timesheetusers.date', '>=', $startDate)
          ->where('timesheetusers.date', '<=', $endDate);
      });
    }
    $timesheetData = $query->get();

    $request->flash();
    return view('backEnd.timesheet.timesheetdownload', compact('timesheetData'));
  }
}


// timesheet filtering function blade code yes
public function searchingtimesheet(Request $request)
{
  // Get all input from form
  $startDate = $request->input('startdate', null);
  $endDate = $request->input('enddate', null);
  $teamId = $request->input('teamid', null);
  $year = $request->input('year', null);

  // this is for patner
  if (auth()->user()->role_id == 13) {

    if (($startDate != null && $endDate != null) || $request->year != null) {
      $timesheetData = DB::table('timesheetusers')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        // When startDate and endDate exist then run 'when' clouse
        ->when($startDate && $endDate, function ($query) use ($startDate, $endDate, $teamId) {
          return $query->where('timesheetusers.createdby', $teamId)
            ->where('timesheetusers.date', '>=', $startDate)
            ->where('timesheetusers.date', '<=', $endDate);
        })
        // When year exist then run 'when' clouse
        ->when($year, function ($query) use ($year, $teamId) {
          // convert startyear (2023) in full date like 01-01-2023
          $startYear = Carbon::createFromFormat('Y', $year)->startOfYear();
          // convert endYear (2023) in full date like 31-12-2023
          $endYear = Carbon::createFromFormat('Y', $year)->endOfYear();
          return $query->where('timesheetusers.createdby', $teamId)
            ->where('timesheetusers.date', '>=', $startYear)
            ->where('timesheetusers.date', '<=', $endYear);
        })
        ->whereIn('timesheetusers.status', [1, 2, 3])
        ->select('timesheetusers.*', 'teammembers.team_member')
        ->orderBy('date', 'DESC')
        ->get();
      return view('backEnd.timesheet.timesheetdownload', compact('timesheetData'));
    }
  }
  // this is for staff and manager
  else {
    if (($startDate != null && $endDate != null) || $request->year != null) {
      $timesheetData = DB::table('timesheetusers')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        // When startDate and endDate exist then run 'when' clouse
        ->when($startDate && $endDate, function ($query) use ($startDate, $endDate, $teamId) {
          return $query->where('timesheetusers.createdby', $teamId)
            ->where('timesheetusers.date', '>=', $startDate)
            ->where('timesheetusers.date', '<=', $endDate);
        })
        // When year exist then run 'when' clouse
        ->when($year, function ($query) use ($year, $teamId) {
          // convert startyear (2023) in full date like 01-01-2023
          $startYear = Carbon::createFromFormat('Y', $year)->startOfYear();
          // convert endYear (2023) in full date like 31-12-2023
          $endYear = Carbon::createFromFormat('Y', $year)->endOfYear();
          return $query->where('timesheetusers.createdby', $teamId)
            ->where('timesheetusers.date', '>=', $startYear)
            ->where('timesheetusers.date', '<=', $endYear);
        })
        ->whereIn('timesheetusers.status', [1, 2, 3])
        ->select('timesheetusers.*', 'teammembers.team_member')
        ->orderBy('date', 'DESC')
        ->get();
      return view('backEnd.timesheet.timesheetdownload', compact('timesheetData'));
    }
  }
  return '<h3>Please Choose Searching Data</h3>';
}

public function searchingtimesheet(Request $request)
{
  // dd($request, 'hi1');
  // Get all input from form
  $startDate = $request->input('startdate', null);
  $endDate = $request->input('enddate', null);
  $teamId = $request->input('teamid', null);
  $teammemberId = $request->input('teammemberId', null);
  $year = $request->input('year', null);

  $teammembers = DB::table('teammembers')
    ->where('status', 1)
    ->whereIn('role_id', [14, 15, 13, 11])
    ->select('team_member', 'id', 'staffcode')
    ->orderBy('team_member', 'ASC')
    ->get();

  // For patner
  if (auth()->user()->role_id == 13) {
    if (($startDate != null && $endDate != null) || $request->year != null) {
      $timesheetData = DB::table('timesheetusers')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        // When startDate and endDate exist then run 'when' clouse
        ->when($startDate && $endDate, function ($query) use ($startDate, $endDate, $teamId) {
          // dd('1 one');
          return $query->where('timesheetusers.createdby', $teamId)
            ->where('timesheetusers.date', '>=', $startDate)
            ->where('timesheetusers.date', '<=', $endDate);
        })
        ->whereIn('timesheetusers.status', [1, 2, 3])
        ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
        ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
        ->leftjoin('teammembers as patnerid', 'patnerid.id', 'timesheetusers.partner')
        ->select('timesheetusers.*', 'assignments.assignment_name', 'clients.client_name', 'teammembers.team_member', 'patnerid.team_member as patnername')
        ->orderBy('date', 'DESC')
        ->get();
      // dd($timesheetData);
      $request->flash();
      return view('backEnd.timesheet.timesheetdownload', compact('timesheetData'));
    }
  }
  // For staff and manager
  else {
    if (($startDate != null && $endDate != null) || $request->year != null) {
      $timesheetData = DB::table('timesheetusers')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        // When startDate and endDate exist then run 'when' clouse
        ->when($startDate && $endDate, function ($query) use ($startDate, $endDate, $teamId) {
          return $query->where('timesheetusers.createdby', $teamId)
            ->where('timesheetusers.date', '>=', $startDate)
            ->where('timesheetusers.date', '<=', $endDate);
        })
        ->whereIn('timesheetusers.status', [1, 2, 3])
        ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
        ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
        ->leftjoin('teammembers as patnerid', 'patnerid.id', 'timesheetusers.partner')
        ->select('timesheetusers.*', 'assignments.assignment_name', 'clients.client_name', 'teammembers.team_member', 'patnerid.team_member as patnername')
        ->orderBy('date', 'DESC')
        ->get();

      $request->flash();
      return view('backEnd.timesheet.timesheetdownload', compact('timesheetData'));
    }
  }
}

public function adminsearchtimesheet(Request $request)
{
  // Get all input from form
  $startDate = $request->input('startdate', null);
  $endDate = $request->input('enddate', null);
  $teamId = $request->input('teamid', null);
  $teammemberId = $request->input('teammemberId', null);
  $year = $request->input('year', null);
  $clientId = $request->input('clientId', null);
  $assignmentId = $request->input('assignmentId', null);

  $teammembers = DB::table('teammembers')
    ->where('status', 1)
    ->whereIn('role_id', [14, 15, 13, 11])
    ->select('team_member', 'id', 'staffcode')
    ->orderBy('team_member', 'ASC')
    ->get();

  $clientsname = DB::table('clients')
    ->whereIn('status', [0, 1])
    ->select('id', 'client_name', 'client_code')
    ->orderBy('client_name', 'ASC')
    ->get();

  $assignmentsname = DB::table('assignments')
    ->where('status', 1)
    ->select('id', 'assignment_name')
    ->orderBy('assignment_name', 'ASC')
    ->get();

  if (auth()->user()->role_id == 11) {
    $timesheetData = DB::table('timesheetusers')
      ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
      // When startDate and endDate exist then run 'when' clause
      ->when($startDate && $endDate && $teammemberId && $year, function ($query) use ($startDate, $endDate, $teammemberId) {
        // dd('teammemberId');
        return $query->where('timesheetusers.createdby', $teammemberId)
          ->where('timesheetusers.date', '>=', $startDate)
          ->where('timesheetusers.date', '<=', $endDate);
      })
      ->when($startDate && $endDate && $clientId && $year, function ($query) use ($startDate, $endDate, $clientId) {
        // dd($clientId);
        return $query->where('timesheetusers.client_id', $clientId)
          ->where('timesheetusers.date', '>=', $startDate)
          ->where('timesheetusers.date', '<=', $endDate);
      })
      ->when($startDate && $endDate && $assignmentId && $year, function ($query) use ($startDate, $endDate, $assignmentId) {
        // dd('assignmentId');
        return $query->where('timesheetusers.assignment_id', $assignmentId)
          ->where('timesheetusers.date', '>=', $startDate)
          ->where('timesheetusers.date', '<=', $endDate);
      })
      ->when($startDate && $endDate && $year && $teammemberId == null && $clientId == null && $assignmentId == null, function ($query) use ($startDate, $endDate, $year) {
        // dd('year');
        return $query->where('timesheetusers.date', '>=', $startDate)
          ->where('timesheetusers.date', '<=', $endDate);
      })
      ->whereIn('timesheetusers.status', [1, 2, 3])
      ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
      ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
      ->leftjoin('teammembers as patnerid', 'patnerid.id', 'timesheetusers.partner')
      ->select('timesheetusers.*', 'assignments.assignment_name', 'clients.client_name', 'teammembers.team_member', 'teammembers.staffcode', 'patnerid.team_member as patnername')
      ->orderBy('date', 'DESC')
      ->get();

    $request->flash();
    return view('backEnd.timesheet.timesheetdownload', compact('timesheetData', 'teammembers', 'clientsname', 'assignmentsname'));
  }
  // for patner team timesheet 
  else {
    $timesheetData = DB::table('timesheetusers')
      ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
      // When startDate and endDate exist then run 'when' clause
      ->when($startDate && $endDate && $teammemberId && $year, function ($query) use ($startDate, $endDate, $teammemberId) {
        return $query->where('timesheetusers.createdby', $teammemberId)
          ->where('timesheetusers.partner', auth()->user()->teammember_id)
          ->where('timesheetusers.date', '>=', $startDate)
          ->where('timesheetusers.date', '<=', $endDate);
      })
      ->when($startDate && $endDate && $clientId && $year, function ($query) use ($startDate, $endDate, $clientId) {
        // dd($clientId);
        return $query->where('timesheetusers.client_id', $clientId)
          ->where('timesheetusers.partner', auth()->user()->teammember_id)
          ->where('timesheetusers.date', '>=', $startDate)
          ->where('timesheetusers.date', '<=', $endDate);
      })
      ->when($startDate && $endDate && $assignmentId && $year, function ($query) use ($startDate, $endDate, $assignmentId) {
        // dd('assignmentId');
        return $query->where('timesheetusers.assignment_id', $assignmentId)
          ->where('timesheetusers.partner', auth()->user()->teammember_id)
          ->where('timesheetusers.date', '>=', $startDate)
          ->where('timesheetusers.date', '<=', $endDate);
      })
      ->when($startDate && $endDate && $year && $teammemberId == null && $clientId == null && $assignmentId == null, function ($query) use ($startDate, $endDate, $year) {
        return $query->where('timesheetusers.date', '>=', $startDate)
          ->where('timesheetusers.date', '<=', $endDate)
          ->where('timesheetusers.partner', auth()->user()->teammember_id);
      })
      ->whereIn('timesheetusers.status', [1, 2, 3])
      ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
      ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
      ->leftjoin('teammembers as patnerid', 'patnerid.id', 'timesheetusers.partner')
      ->select('timesheetusers.*', 'assignments.assignment_name', 'clients.client_name', 'teammembers.team_member', 'teammembers.staffcode', 'patnerid.team_member as patnername')
      ->orderBy('date', 'DESC')
      ->get();
    // dd($timesheetData);
    $request->flash();
    return view('backEnd.timesheet.timesheetdownload', compact('timesheetData', 'teammembers', 'clientsname', 'assignmentsname'));
  }
}
// end hare

public function filterDataAdmin(Request $request)
{
  $urlheader = $request->headers->get('referer');
  $url = parse_url($urlheader);
  $path = $url['path'];
  // dd($url);
  // this is for patner submitted timesheet 
  if (auth()->user()->role_id == 13 && $path == '/timesheet/partnersubmitted') {
    // dd('patner');
    $teamname = $request->input('teamname');
    $start = $request->input('start');
    $end = $request->input('end');
    $totalhours = $request->input('totalhours');
    $partnerId = $request->input('partnersearch');


    $query = DB::table('timesheetreport')
      ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
      ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
      ->where('timesheetreport.teamid', auth()->user()->teammember_id)
      ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername')
      ->latest();

    // teamname with othser field to  filter
    if ($teamname) {
      $query->where('timesheetreport.teamid', $teamname);
    }

    if ($teamname && $totalhours) {
      $query->where(function ($q) use ($teamname, $totalhours) {
        $q->where('timesheetreport.teamid', $teamname)
          ->where('timesheetreport.totaltime', $totalhours);
      });
    }
    if ($teamname && $partnerId) {
      $query->where(function ($q) use ($teamname, $partnerId) {
        $q->where('timesheetreport.teamid', $teamname)
          ->where('timesheetreport.partnerid', $partnerId);
      });
    }

    // patner or othse one data
    if ($partnerId) {
      $query->where('timesheetreport.partnerid', $partnerId);
    }

    if ($partnerId && $totalhours) {
      $query->where(function ($q) use ($partnerId, $totalhours) {
        $q->where('timesheetreport.partnerid', $partnerId)
          ->where('timesheetreport.totaltime', $totalhours);
      });
    }

    // total hour wise  wise or othser data
    if ($totalhours) {
      $query->where('timesheetreport.totaltime', $totalhours);
    }
    //! end date 
    if ($start && $end) {
      $query->where(function ($query) use ($start, $end) {
        $query->whereBetween('timesheetreport.startdate', [$start, $end])
          ->orWhereBetween('timesheetreport.enddate', [$start, $end])
          ->orWhere(function ($query) use ($start, $end) {
            $query->where('timesheetreport.startdate', '<=', $start)
              ->where('timesheetreport.enddate', '>=', $end);
          });
      });
    }
  }
  // this is for team submitted timesheet on patner
  elseif (auth()->user()->role_id == 13 && $path == '/timesheet/teamlist') {
    // dd($request);
    // dd('team');
    $teamname = $request->input('teamname');
    $start = $request->input('start');
    $end = $request->input('end');
    $totalhours = $request->input('totalhours');
    $partnerId = $request->input('partnersearch');


    $query = DB::table('timesheetreport')
      ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
      ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
      ->where('timesheetreport.partnerid', auth()->user()->teammember_id)
      ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername')
      ->orderBy('timesheetreport.startdate', 'desc');

    // teamname with othser field to  filter
    if ($teamname) {
      $query->where('timesheetreport.teamid', $teamname);
    }

    if ($teamname && $totalhours) {
      $query->where(function ($q) use ($teamname, $totalhours) {
        $q->where('timesheetreport.teamid', $teamname)
          ->where('timesheetreport.totaltime', $totalhours);
      });
    }
    if ($teamname && $partnerId) {
      $query->where(function ($q) use ($teamname, $partnerId) {
        $q->where('timesheetreport.teamid', $teamname)
          ->where('timesheetreport.partnerid', $partnerId);
      });
    }

    // patner or othse one data
    if ($partnerId) {
      $query->where('timesheetreport.partnerid', $partnerId);
    }

    if ($partnerId && $totalhours) {
      $query->where(function ($q) use ($partnerId, $totalhours) {
        $q->where('timesheetreport.partnerid', $partnerId)
          ->where('timesheetreport.totaltime', $totalhours);
      });
    }

    // total hour wise  wise or othser data
    if ($totalhours) {
      $query->where('timesheetreport.totaltime', $totalhours);
    }
    //! end date 
    if ($start && $end) {
      $query->where(function ($query) use ($start, $end) {
        $query->whereBetween('timesheetreport.startdate', [$start, $end])
          ->orWhereBetween('timesheetreport.enddate', [$start, $end])
          ->orWhere(function ($query) use ($start, $end) {
            $query->where('timesheetreport.startdate', '<=', $start)
              ->where('timesheetreport.enddate', '>=', $end);
          });
      });
    }
  }
  // this is for submitted timesheet on staff and manager 
  elseif (auth()->user()->role_id == 14 || auth()->user()->role_id == 15) {
    // dd($request);
    $teamname = $request->input('teamname');
    $start = $request->input('start');
    $end = $request->input('end');
    $totalhours = $request->input('totalhours');
    $partnerId = $request->input('partnersearch');


    $query = DB::table('timesheetreport')
      ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
      ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
      ->where('timesheetreport.teamid', auth()->user()->teammember_id)
      ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername')
      ->latest();

    // teamname with othser field to  filter
    if ($teamname) {
      $query->where('timesheetreport.teamid', $teamname);
    }

    if ($teamname && $totalhours) {
      $query->where(function ($q) use ($teamname, $totalhours) {
        $q->where('timesheetreport.teamid', $teamname)
          ->where('timesheetreport.totaltime', $totalhours);
      });
    }
    if ($teamname && $partnerId) {
      $query->where(function ($q) use ($teamname, $partnerId) {
        $q->where('timesheetreport.teamid', $teamname)
          ->where('timesheetreport.partnerid', $partnerId);
      });
    }

    // patner or othse one data
    if ($partnerId) {
      $query->where('timesheetreport.partnerid', $partnerId);
    }

    if ($partnerId && $totalhours) {
      $query->where(function ($q) use ($partnerId, $totalhours) {
        $q->where('timesheetreport.partnerid', $partnerId)
          ->where('timesheetreport.totaltime', $totalhours);
      });
    }

    // total hour wise  wise or othser data
    if ($totalhours) {
      $query->where('timesheetreport.totaltime', $totalhours);
    }
    //! end date 
    if ($start && $end) {
      $query->where(function ($query) use ($start, $end) {
        $query->whereBetween('timesheetreport.startdate', [$start, $end])
          ->orWhereBetween('timesheetreport.enddate', [$start, $end])
          ->orWhere(function ($query) use ($start, $end) {
            $query->where('timesheetreport.startdate', '<=', $start)
              ->where('timesheetreport.enddate', '>=', $end);
          });
      });
    }
  }
  // this is for team submitted timesheet on Admin
  else {
    // dd(auth()->user()->role_id);
    $teamname = $request->input('teamname');
    $start = $request->input('start');
    $end = $request->input('end');
    $totalhours = $request->input('totalhours');
    $partnerId = $request->input('partnersearch');


    $query = DB::table('timesheetreport')
      ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
      ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
      ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername')
      ->orderBy('timesheetreport.startdate', 'desc');

    // teamname with othser field to  filter
    if ($teamname) {
      $query->where('timesheetreport.teamid', $teamname);
    }

    if ($teamname && $totalhours) {
      $query->where(function ($q) use ($teamname, $totalhours) {
        $q->where('timesheetreport.teamid', $teamname)
          ->where('timesheetreport.totaltime', $totalhours);
      });
    }
    if ($teamname && $partnerId) {
      $query->where(function ($q) use ($teamname, $partnerId) {
        $q->where('timesheetreport.teamid', $teamname)
          ->where('timesheetreport.partnerid', $partnerId);
      });
    }

    // patner or othse one data
    if ($partnerId) {
      $query->where('timesheetreport.partnerid', $partnerId);
    }

    if ($partnerId && $totalhours) {
      $query->where(function ($q) use ($partnerId, $totalhours) {
        $q->where('timesheetreport.partnerid', $partnerId)
          ->where('timesheetreport.totaltime', $totalhours);
      });
    }

    // total hour wise  wise or othser data
    if ($totalhours) {
      $query->where('timesheetreport.totaltime', $totalhours);
    }
    //! end date 
    if ($start && $end) {
      $query->where(function ($query) use ($start, $end) {
        $query->whereBetween('timesheetreport.startdate', [$start, $end])
          ->orWhereBetween('timesheetreport.enddate', [$start, $end])
          ->orWhere(function ($query) use ($start, $end) {
            $query->where('timesheetreport.startdate', '<=', $start)
              ->where('timesheetreport.enddate', '>=', $end);
          });
      });
    }
  }

  $filteredDataaa = $query->get();

  // maping double date ************
  $groupedData = $filteredDataaa->groupBy(function ($item) {
    return $item->team_member . '|' . $item->week;
  })->map(function ($group) {
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
    ];
  });

  $filteredData = collect($groupedData->values());
  return response()->json($filteredData);
}
// end hare
public function filterDataAdmin(Request $request)
{
  $teamname = $request->input('employee');
  $leavetype = $request->input('leave');
  $startdate = $request->input('start');
  $enddate = $request->input('end');
  $statusdata = $request->input('status');
  $startperioddata = $request->input('startperiod');
  $endperioddata = $request->input('endperiod');

  $query = DB::table('applyleaves')
    ->leftJoin('leavetypes', 'leavetypes.id', '=', 'applyleaves.leavetype')
    ->leftJoin('teammembers', 'teammembers.id', '=', 'applyleaves.createdby')
    ->leftJoin('teammembers as approvername', 'approvername.id', '=', 'applyleaves.approver')
    ->leftJoin('roles', 'roles.id', '=', 'teammembers.role_id')
    ->select('applyleaves.*', 'teammembers.team_member', 'roles.rolename', 'leavetypes.name', 'approvername.team_member as approvernames');

  if (auth()->user()->role_id == 13) {
    $query->where('applyleaves.approver', auth()->user()->teammember_id);

    if ($teamname) {
      $query->where('applyleaves.createdby', $teamname);
    }

    if ($leavetype) {
      $query->where('applyleaves.leavetype', $leavetype);
    }

    if ($statusdata !== null) {
      $query->where('applyleaves.status', $statusdata);
    }

    if (!$teamname && !$leavetype && $statusdata === null) {
      $query->whereBetween('applyleaves.created_at', [$startdate, $enddate]);
    }

    if ($teamname && $leavetype) {
      $query->where('applyleaves.createdby', $teamname)
        ->where('applyleaves.leavetype', $leavetype);
    }

    if ($teamname && $statusdata !== null) {
      $query->where('applyleaves.createdby', $teamname)
        ->where('applyleaves.status', $statusdata);
    }

    if ($statusdata !== null && $leavetype !== null) {
      $query->where('applyleaves.status', $statusdata)
        ->where('applyleaves.leavetype', $leavetype);
    }

    if ($teamname && $leavetype && $statusdata && $startperioddata && $endperioddata) {
      $query->where('applyleaves.createdby', $teamname)
        ->where('applyleaves.leavetype', $leavetype)
        ->where('applyleaves.status', $statusdata)
        ->whereBetween('applyleaves.from', [$startperioddata, $endperioddata]);
    }

    if ($teamname && $leavetype && $statusdata && $startdate && $enddate) {
      $query->where('applyleaves.createdby', $teamname)
        ->where('applyleaves.leavetype', $leavetype)
        ->where('applyleaves.status', $statusdata)
        ->whereBetween('applyleaves.created_at', [$startdate, $enddate]);
    }
  } else {
    if ($teamname) {
      $query->where('applyleaves.createdby', $teamname);
    }

    if ($teamname && $leavetype) {
      $query->where('applyleaves.createdby', $teamname)
        ->where('applyleaves.leavetype', $leavetype);
    }

    if ($teamname && $leavetype && $statusdata) {
      $query->where('applyleaves.createdby', $teamname)
        ->where('applyleaves.leavetype', $leavetype)
        ->where('applyleaves.status',  $statusdata);
    }

    if ($teamname && $leavetype && $statusdata && $startperioddata && $endperioddata) {
      $query->where('applyleaves.createdby', $teamname)
        ->where('applyleaves.leavetype', $leavetype)
        ->where('applyleaves.status',  $statusdata)
        ->whereBetween('applyleaves.from', [$startperioddata, $endperioddata]);
    }

    if ($teamname && $leavetype && $statusdata && $startdate && $enddate) {
      $query->where('applyleaves.createdby', $teamname)
        ->where('applyleaves.leavetype', $leavetype)
        ->where('applyleaves.status',  $statusdata)
        ->whereBetween('applyleaves.created_at', [$startdate, $enddate]);
    }
  }

  $filteredData = $query->get();

  return response()->json($filteredData);
}
// end hare
  public function filterDataAdmin(Request $request)
  {
    $teamname = $request->input('employee');
    $leavetype = $request->input('leave');
    $startdate = $request->input('start');
    $enddate = $request->input('end');
    $statusdata = $request->input('status');
    $startperioddata = $request->input('startperiod');
    $endperioddata = $request->input('endperiod');

    $query = DB::table('applyleaves')
      ->leftJoin('leavetypes', 'leavetypes.id', '=', 'applyleaves.leavetype')
      ->leftJoin('teammembers', 'teammembers.id', '=', 'applyleaves.createdby')
      ->leftJoin('teammembers as approvername', 'approvername.id', '=', 'applyleaves.approver')
      ->leftJoin('roles', 'roles.id', '=', 'teammembers.role_id')
      ->select('applyleaves.*', 'teammembers.team_member', 'roles.rolename', 'leavetypes.name', 'approvername.team_member as approvernames');

    if (auth()->user()->role_id == 13) {
      $query->where('applyleaves.approver', auth()->user()->teammember_id);

      if ($teamname) {
        $query->where('applyleaves.createdby', $teamname);
      }

      if ($leavetype) {
        $query->where('applyleaves.leavetype', $leavetype);
      }

      if ($statusdata !== null) {
        $query->where('applyleaves.status', $statusdata);
      }

      if (!$teamname && !$leavetype && $statusdata === null) {
        $query->whereBetween('applyleaves.created_at', [$startdate, $enddate]);
      }

      if ($teamname && $leavetype) {
        $query->where('applyleaves.createdby', $teamname)
          ->where('applyleaves.leavetype', $leavetype);
      }

      if ($teamname && $statusdata !== null) {
        $query->where('applyleaves.createdby', $teamname)
          ->where('applyleaves.status', $statusdata);
      }

      if ($statusdata !== null && $leavetype !== null) {
        $query->where('applyleaves.status', $statusdata)
          ->where('applyleaves.leavetype', $leavetype);
      }

      if ($teamname && $leavetype && $statusdata && $startperioddata && $endperioddata) {
        $query->where('applyleaves.createdby', $teamname)
          ->where('applyleaves.leavetype', $leavetype)
          ->where('applyleaves.status', $statusdata)
          ->whereBetween('applyleaves.from', [$startperioddata, $endperioddata]);
      }

      if ($teamname && $leavetype && $statusdata && $startdate && $enddate) {
        $query->where('applyleaves.createdby', $teamname)
          ->where('applyleaves.leavetype', $leavetype)
          ->where('applyleaves.status', $statusdata)
          ->whereBetween('applyleaves.created_at', [$startdate, $enddate]);
      }
    } else {

      if ($teamname) {
        $query->where('applyleaves.createdby', $teamname);
      }
      // dd($request);

      if ($teamname && $leavetype) {
        $query->where('applyleaves.createdby', $teamname)
          ->where('applyleaves.leavetype', $leavetype);
      }

      if ($teamname && $leavetype && $statusdata !== null) {
        $query->where('applyleaves.createdby', $teamname)
          ->where('applyleaves.leavetype', $leavetype)
          ->where('applyleaves.status',  $statusdata);
      }

      if ($teamname && $leavetype && $statusdata && $startperioddata && $endperioddata) {
        $query->where('applyleaves.createdby', $teamname)
          ->where('applyleaves.leavetype', $leavetype)
          ->where('applyleaves.status',  $statusdata)
          ->whereBetween('applyleaves.from', [$startperioddata, $endperioddata]);
      }

      if ($teamname && $leavetype && $statusdata && $startdate && $enddate) {
        $query->where('applyleaves.createdby', $teamname)
          ->where('applyleaves.leavetype', $leavetype)
          ->where('applyleaves.status',  $statusdata)
          ->whereBetween('applyleaves.created_at', [$startdate, $enddate]);
      }

      if ($statusdata !== null) {
        $query->where('applyleaves.status', $statusdata);
      }

      if ($teamname && $statusdata !== null) {
        $query->where('applyleaves.createdby', $teamname)
          ->where('applyleaves.status', $statusdata);
      }

      if ($leavetype) {
        $query->where('applyleaves.leavetype', $leavetype);
      }

      // According startdate
      if ($startdate && $enddate) {
        $query->whereBetween('applyleaves.created_at', [$startdate, $enddate]);
      }

      if ($teamname && $startdate && $enddate) {
        $query->where('applyleaves.createdby', $teamname)
          ->whereBetween('applyleaves.created_at', [$startdate, $enddate]);
      }


      // According startperioddata

      if ($startperioddata && $endperioddata) {
        $query->whereBetween('applyleaves.from', [$startperioddata, $endperioddata]);
      }

      if ($teamname && $startperioddata && $endperioddata) {
        $query->where('applyleaves.createdby', $teamname)
          ->whereBetween('applyleaves.from', [$startperioddata, $endperioddata]);
      }

      if ($leavetype && $startperioddata && $endperioddata) {
        $query->where('applyleaves.leavetype', $leavetype)
          ->whereBetween('applyleaves.from', [$startperioddata, $endperioddata]);
      }

      if ($statusdata !== null && $startperioddata && $endperioddata) {
        $query->where('applyleaves.status', $statusdata)
          ->whereBetween('applyleaves.from', [$startperioddata, $endperioddata]);
      }



      // end 
    }

    $filteredData = $query->get();

    return response()->json($filteredData);
  }

// end hare

  // i have worked
    // public function adminattendancereport(Request $request)
    // {

    //     $teamnid = $request->input('teammemberId');
    //     $startdate = $request->input('startdate');
    //     $enddate = $request->input('enddate');
    //     // All teammember 
    //     $teammembers = DB::table('teammembers')
    //         ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
    //         ->whereIn('teammembers.role_id', [14, 15, 13, 11])
    //         ->select('teammembers.team_member', 'teamrolehistory.newstaff_code', 'teammembers.id', 'teammembers.staffcode')
    //         ->orderBy('team_member', 'ASC')
    //         ->get();
    //     // only attendance user 
    //     // $teammembers = DB::table('attendances')
    //     //     ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'attendances.employee_name')
    //     //     ->leftJoin('teammembers', 'teammembers.id', '=', 'attendances.employee_name')
    //     //     ->whereIn('teammembers.role_id', [14, 15, 13, 11])
    //     //     ->select('teammembers.team_member', 'teamrolehistory.newstaff_code', 'teammembers.id', 'teammembers.staffcode')
    //     //     ->distinct()
    //     //     ->orderBy('teammembers.team_member', 'ASC')
    //     //     ->get();

    //     $query  = DB::table('attendances')
    //         ->leftjoin('teammembers', 'teammembers.id', 'attendances.employee_name')
    //         ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
    //         ->select('attendances.*', 'teammembers.team_member', 'teammembers.employment_status', 'roles.rolename', 'teammembers.joining_date');

    //     if ($teamnid) {
    //         $query->where('attendances.employee_name', $teamnid);
    //     }

    //     if ($startdate && $enddate) {
    //         $query->whereBetween('attendances.fulldate', [$startdate, $enddate]);
    //     }

    //     // if ($startdate) {
    //     //     $query->where('applyleaves.leavetype', $startdate);
    //     // }

    //     $attendanceDatas = $query->get();
    //     $request->flash();

    //     return view('backEnd.attendance.adminattendance', compact('attendanceDatas', 'teammembers'));
    // }

    // Akshay have worked
    // public function adminattendancereport(Request $request)
    // {
    //     $teamnid = $request->input('teammemberId');
    //     $startdate = $request->input('startdate');
    //     $enddate = $request->input('enddate');
    //     // All teammember 
    //     $teammembers = DB::table('teammembers')
    //         ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
    //         ->whereIn('teammembers.role_id', [14, 15, 13, 11])
    //         ->select('teammembers.team_member', 'teamrolehistory.newstaff_code', 'teammembers.id', 'teammembers.staffcode')
    //         ->orderBy('team_member', 'ASC')
    //         ->get();

    //     // only attendance user 
    //     // $teammembers = DB::table('attendances')
    //     //     ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'attendances.employee_name')
    //     //     ->leftJoin('teammembers', 'teammembers.id', '=', 'attendances.employee_name')
    //     //     ->whereIn('teammembers.role_id', [14, 15, 13, 11])
    //     //     ->select('teammembers.team_member', 'teamrolehistory.newstaff_code', 'teammembers.id', 'teammembers.staffcode')
    //     //     ->distinct()
    //     //     ->orderBy('teammembers.team_member', 'ASC')
    //     //     ->get();

    //     // $query  = DB::table('attendances')
    //     //     ->leftjoin('teammembers', 'teammembers.id', 'attendances.employee_name')
    //     //     ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
    //     //     ->select('attendances.*', 'teammembers.team_member', 'teammembers.staffcode', 'teammembers.employment_status', 'roles.rolename', 'teammembers.joining_date');

    //     $query  = DB::table('attendances')
    //         ->leftjoin('teammembers', 'teammembers.id', 'attendances.employee_name')
    //         ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
    //         ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
    //         ->select('attendances.*', 'teammembers.team_member', 'teammembers.staffcode', 'teamrolehistory.newstaff_code', 'teammembers.employment_status', 'roles.rolename', 'teammembers.joining_date');

    //     if ($teamnid) {
    //         $query->where('attendances.employee_name', $teamnid);
    //     }

    //     //akshay code
    //     if ($startdate && $enddate) {
    //         // Convert the start and end dates to full month names
    //         $startMonth = Carbon::parse($startdate)->format('F'); // e.g., "January"
    //         $endMonth = Carbon::parse($enddate)->format('F');     // e.g., "December"

    //         // Map months to numbers for correct comparison
    //         $months = [
    //             'January' => 1,
    //             'February' => 2,
    //             'March' => 3,
    //             'April' => 4,
    //             'May' => 5,
    //             'June' => 6,
    //             'July' => 7,
    //             'August' => 8,
    //             'September' => 9,
    //             'October' => 10,
    //             'November' => 11,
    //             'December' => 12,
    //         ];

    //         $startMonthNumber = $months[$startMonth];
    //         $endMonthNumber = $months[$endMonth];

    //         // Filter by month names by converting the stored string month to its respective number
    //         $query->whereBetween(DB::raw("FIELD(attendances.month, 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December')"), [$startMonthNumber, $endMonthNumber]);
    //     }

    //     //and akshay code 

    //     // if ($startdate) {
    //     //     $query->where('applyleaves.leavetype', $startdate);
    //     // }

    //     $attendanceDatas = $query->get();
    //     $request->flash();

    //     // dd($attendanceDatas);
    //     return view('backEnd.attendance.adminattendance', compact('attendanceDatas', 'teammembers'));
    // }


    // public function adminattendancereport(Request $request)
    // {

    //     // dd($request);
    //     $teamnid = $request->input('teammemberId');
    //     $startdate = $request->input('startdate');
    //     $enddate = $request->input('enddate');
    //     // Convert start date to a date object for accurate comparison
    //     $startdate = \Carbon\Carbon::parse($startdate);
    //     $enddate = \Carbon\Carbon::parse($enddate);

    //     // All teammember 
    //     $teammembers = DB::table('teammembers')
    //         ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
    //         ->whereIn('teammembers.role_id', [14, 15, 13, 11])
    //         ->select('teammembers.team_member', 'teamrolehistory.newstaff_code', 'teammembers.id', 'teammembers.staffcode')
    //         ->orderBy('team_member', 'ASC')
    //         ->get();


    //     $singleusersearched = DB::table('teammembers')
    //         ->where('id', $teamnid)
    //         ->select('team_member', 'staffcode', 'id', 'leavingdate', 'joining_date')
    //         ->first();
    //     // dd($singleusersearched);
    //     // Check if leavingdate exists and is after the startdate
    //     if ($singleusersearched && $singleusersearched->leavingdate != null) {
    //         $leavingdate = \Carbon\Carbon::parse($singleusersearched->leavingdate);
    //         if ($startdate->gt($leavingdate)) {
    //             // $output = array('msg' => 'You cannot select this user as their leaving date is before the start date.');
    //             $output = ['msg' => 'You cannot select this user as their leaving date (' . $leavingdate->format('d-m-Y') . ') is before the start date.'];
    //             // return back()->with('statuss', $output);
    //             $request->flash();
    //             return redirect()->to('attendance')->with('statuss', $output);
    //         }
    //     }

    //     if ($singleusersearched && $singleusersearched->joining_date != null) {
    //         $joiningdate = \Carbon\Carbon::parse($singleusersearched->joining_date);
    //         if ($joiningdate->gt($enddate)) {
    //             // $output = array('msg' => 'You cannot select this user as their Joining date is After the end date.');
    //             $output = ['msg' => 'You cannot select this user as their Joining date (' . $joiningdate->format('d-m-Y') . ') is After the end date.'];
    //             // return back()->with('statuss', $output);
    //             $request->flash();
    //             return redirect()->to('attendance')->with('statuss', $output);
    //         }
    //     }

    //     // only attendance user 
    //     // $teammembers = DB::table('attendances')
    //     //     ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'attendances.employee_name')
    //     //     ->leftJoin('teammembers', 'teammembers.id', '=', 'attendances.employee_name')
    //     //     ->whereIn('teammembers.role_id', [14, 15, 13, 11])
    //     //     ->select('teammembers.team_member', 'teamrolehistory.newstaff_code', 'teammembers.id', 'teammembers.staffcode')
    //     //     ->distinct()
    //     //     ->orderBy('teammembers.team_member', 'ASC')
    //     //     ->get();

    //     // $query  = DB::table('attendances')
    //     //     ->leftjoin('teammembers', 'teammembers.id', 'attendances.employee_name')
    //     //     ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
    //     //     ->select('attendances.*', 'teammembers.team_member', 'teammembers.staffcode', 'teammembers.employment_status', 'roles.rolename', 'teammembers.joining_date');

    //     $query  = DB::table('attendances')
    //         ->leftjoin('teammembers', 'teammembers.id', 'attendances.employee_name')
    //         ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
    //         ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
    //         ->select('attendances.*', 'teammembers.team_member', 'teammembers.staffcode', 'teamrolehistory.newstaff_code', 'teammembers.employment_status', 'roles.rolename', 'teammembers.joining_date');

    //     if ($teamnid) {
    //         $query->where('attendances.employee_name', $teamnid);
    //     }

    //     //akshay code
    //     if ($startdate && $enddate) {
    //         // Convert the start and end dates to full month names
    //         $startMonth = Carbon::parse($startdate)->format('F'); // e.g., "January"
    //         $endMonth = Carbon::parse($enddate)->format('F');     // e.g., "December"

    //         // Map months to numbers for correct comparison
    //         $months = [
    //             'January' => 1,
    //             'February' => 2,
    //             'March' => 3,
    //             'April' => 4,
    //             'May' => 5,
    //             'June' => 6,
    //             'July' => 7,
    //             'August' => 8,
    //             'September' => 9,
    //             'October' => 10,
    //             'November' => 11,
    //             'December' => 12,
    //         ];

    //         $startMonthNumber = $months[$startMonth];
    //         $endMonthNumber = $months[$endMonth];

    //         // Filter by month names by converting the stored string month to its respective number
    //         $query->whereBetween(DB::raw("FIELD(attendances.month, 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December')"), [$startMonthNumber, $endMonthNumber]);
    //     }

    //     //and akshay code 

    //     // if ($startdate) {
    //     //     $query->where('applyleaves.leavetype', $startdate);
    //     // }

    //     $attendanceDatas = $query->get();
    //     $request->flash();

    //     // dd($attendanceDatas);
    //     return view('backEnd.attendance.adminattendance', compact('attendanceDatas', 'teammembers'));
    // }




    // public function adminattendancereport(Request $request)
    // {
    //     $teamnid = $request->input('teammemberId');
    //     $startdate = \Carbon\Carbon::parse($request->input('startdate'));
    //     $enddate = \Carbon\Carbon::parse($request->input('enddate'));

    //     // All team members with the specified roles
    //     $teammembers = DB::table('teammembers')
    //         ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
    //         ->whereIn('teammembers.role_id', [14, 15, 13, 11])
    //         ->select('teammembers.team_member', 'teamrolehistory.newstaff_code', 'teammembers.id', 'teammembers.staffcode')
    //         ->orderBy('team_member', 'ASC')
    //         ->get();

    //     // Fetch the selected team member
    //     $singleusersearched = DB::table('teammembers')
    //         ->where('id', $teamnid)
    //         ->select('team_member', 'staffcode', 'id', 'leavingdate', 'joining_date')
    //         ->first();

    //     // Validate leaving date
    //     if ($singleusersearched && $singleusersearched->leavingdate) {
    //         $leavingdate = \Carbon\Carbon::parse($singleusersearched->leavingdate);
    //         if ($startdate->gt($leavingdate)) {
    //             $output = ['msg' => 'You cannot select this user as their leaving date (' . $leavingdate->format('d-m-Y') . ') is before the start date.'];
    //             $request->flash();
    //             return redirect()->to('attendance')->with('statuss', $output);
    //         }
    //     }

    //     // Validate joining date
    //     if ($singleusersearched && $singleusersearched->joining_date) {
    //         $joiningdate = \Carbon\Carbon::parse($singleusersearched->joining_date);
    //         if ($joiningdate->gt($enddate)) {
    //             $output = ['msg' => 'You cannot select this user as their joining date (' . $joiningdate->format('d-m-Y') . ') is after the end date.'];
    //             $request->flash();
    //             return redirect()->to('attendance')->with('statuss', $output);
    //         }
    //     }

    //     // Build the attendance query
    //     $query = DB::table('attendances')
    //         ->leftJoin('teammembers', 'teammembers.id', 'attendances.employee_name')
    //         ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
    //         ->leftJoin('roles', 'roles.id', 'teammembers.role_id')
    //         ->select('attendances.*', 'teammembers.team_member', 'teammembers.staffcode', 'teamrolehistory.newstaff_code', 'teammembers.employment_status', 'roles.rolename', 'teammembers.joining_date');

    //     if ($teamnid) {
    //         $query->where('attendances.employee_name', $teamnid);
    //     }

    //     // Optimize date filtering
    //     if ($startdate && $enddate) {
    //         $query->whereBetween('attendances.fulldate', [$startdate, $enddate]);
    //     }

    //     $attendanceDatas = $query->get();
    //     $request->flash();

    //     return view('backEnd.attendance.adminattendance', compact('attendanceDatas', 'teammembers'));
    // }

    public function adminattendancereport(Request $request)
    {
        $teamnid = $request->input('teammemberId');
        $startdate = Carbon::parse($request->input('startdate'));
        $enddate = Carbon::parse($request->input('enddate'));

        // Convert start and end dates to their respective month numbers like Month number (1-12)
        $startMonth = $startdate->format('n');
        $endMonth = $enddate->format('n');

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

        // Filter where the attendance month falls between the start and end month
        if ($startMonth && $endMonth) {
            $query->whereBetween(DB::raw('MONTH(STR_TO_DATE(CONCAT(attendances.month, " 1, 2000"), "%M %d, %Y"))'), [$startMonth, $endMonth]);
        }

        $attendanceDatas = $query->get();
        $request->flash();

        return view('backEnd.attendance.adminattendance', compact('attendanceDatas', 'teammembers'));
    }

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

        // // Filter where the attendance month falls between the start and end month
        // if ($startMonth && $endMonth) {
        //     $query->whereBetween(DB::raw('MONTH(STR_TO_DATE(CONCAT(attendances.month, " 1, 2000"), "%M %d, %Y"))'), [$startMonth, $endMonth]);
        // }

        // Filter attendance records by month and year
        if ($startMonth && $endMonth && $startYear && $endYear) {
            $query->whereBetween(DB::raw('MONTH(STR_TO_DATE(CONCAT(attendances.month, " 1, 2000"), "%M %d, %Y"))'), [$startMonth, $endMonth])
                ->whereBetween('attendances.year', [$startYear, $endYear]);
        }

        $attendanceDatas = $query->get();
        $request->flash();

        return view('backEnd.attendance.adminattendance', compact('attendanceDatas', 'teammembers'));
    }

//! filtering functionality / regarding filter / filter functionality end hare 

//* filter functionality on date / filter created_at column 

<div class="col-3">
<div class="form-group">
    <label class="font-weight-600">Start Date and Time</label>
    <input type="datetime-local" class="form-control" id="start1" name="start">
</div>
</div>

<div class="col-3">
<div class="form-group">
    <label class="font-weight-600">End Date</label>
    <input type="datetime-local" class="form-control" id="end1" name="end">
</div>
</div>


$startdate = $request->input('start');
$startdate1 = date('Y-m-d H:i:s', strtotime($startdate));
$endtdate = $request->input('end');
$endtdate1 = date('Y-m-d H:i:s', strtotime($endtdate));

//! filter functionality on date / filter created_at column 

//* array to object convert
public function timesheet_teamlist()
  {
    if (auth()->user()->role_id == 13) {
      // get all partner
      $partner = Teammember::where('role_id', '=', 13)->where('status', '=', 1)->with('title')
        ->orderBy('team_member', 'asc')->get();

      $get_date = DB::table('timesheetreport')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
        ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
        ->where('timesheetreport.partnerid', auth()->user()->teammember_id)
        ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername')
        ->latest()->get();
    } else {
      $partner = Teammember::where('role_id', '=', 13)->where('status', '=', 1)->with('title')
        ->orderBy('team_member', 'asc')->get();
      $get_datess = DB::table('timesheetreport')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
        ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
        ->where('timesheetreport.teamid', auth()->user()->teammember_id)
        ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername')
        ->latest()->get();
    }

    // dd($get_datess);


    $groupedData = $get_datess->groupBy('week')->map(function ($group) {
      $firstItem = $group->first();
//* array to object convert
      return [
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
      ];
    });

    $get_date = collect($groupedData->values());



    $groupedData = $get_datess->groupBy('week')->map(function ($group) {
      $firstItem = $group->first();
//* array to object convert
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
      ];
    });

    $get_date = collect($groupedData->values());


    // dd($get_date);

    return view('backEnd.timesheet.myteamindex', compact('get_date', 'partner'));
  }
//* previus days find 
$getsixdata->date
// 2023-11-13
if (date('l', strtotime(date('d-m-Y', strtotime($getsixdata->date)))) == 'Monday') {

  $previousMonday = $requestedDate->copy()->previous(Carbon::MONDAY);
  // date: 2023-11-06 00:00:00.0 Asia/Kolkata (+05:30)
  // dd($previousMonday);
  // Find the nearest next Saturday to the requested date
  $nextSaturday = $requestedDate->copy()->next(Carbon::SATURDAY);
  // date: 2023-11-18 00:00:00.0 Asia/Kolkata (+05:30)
  dd($nextSaturday);
//* date as a string
if (!empty($missingDates)) {
  $missingDatesString = implode(', ', $missingDates);
  // "2023-11-13, 2023-11-14" like 
  // "2024-03-11, 2024-03-12, 2024-03-13"
  dd($missingDatesString);

  $output = array('msg' => "Timesheet Submit Failed Missing dates: $missingDatesString");
  return back()->with('success', $output);
}
//* add one date in date /add on date 
$currentDate = clone $firstDate;
// date: 2023-11-13 00:00:00.0 Asia/Kolkata (+05:30)

while ($currentDate->format('Y-m-d') < $upcomingSundayDate->format('Y-m-d')) {  //excluding sunday
    $expectedDates[] = $currentDate->format('Y-m-d');

    // 0 => "2023-11-13"
    $currentDate->modify("+1 day");
    // date: 2023-11-14 00:00:00.0 Asia/Kolkata (+05:30)
    dd($currentDate);
}

//* get last date of timesheet

$get_six_Data = DB::table('timesheets')
->where('status', '0')
->where('created_by', auth()->user()->teammember_id)
->whereBetween('date', [$firstDate->format('Y-m-d'), $upcomingSunday])
->orderBy('date', 'ASC')
->get();

$lastdate = $get_six_Data->max('date');
//* all data for users

dd(auth()->user());
//*

//------------------- Shahid's code start---------------------
//*

// applyleave controller update function 
if ($request->status == 1) {
  $team = DB::table('leaverequest')
    ->leftjoin('applyleaves', 'applyleaves.id', 'leaverequest.applyleaveid')
    ->leftjoin('leavetypes', 'leavetypes.id', 'applyleaves.leavetype')
    ->leftjoin('teammembers', 'teammembers.id', 'applyleaves.createdby')
    ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
    ->where('leaverequest.id', $id)
    ->select('applyleaves.*', 'teammembers.emailid', 'teammembers.team_member', 'roles.rolename', 'leavetypes.name', 'leavetypes.holiday', 'leaverequest.id as examrequestId', 'leaverequest.date')
    ->first();


if ($team->name == 'Exam Leave') {

  $from = Carbon::createFromFormat('Y-m-d', $team->from);
  //2023-12-16 16:12:40.0 Asia/Kolkata (+05:30)
  $to = Carbon::createFromFormat('Y-m-d', $team->to ?? '');
  // 2023-12-24 16:12:00.0 Asia/Kolkata (+05:30)
  $camefromexam = Carbon::createFromFormat('Y-m-d', $team->date);
  // dd($camefromexam);
  // $nowrequestdays = $to->diffInDays($camefromexam) + 1;
  // remove days from database 
  $removedays = $to->diffInDays($camefromexam) + 1;
  // dd($removedays);
  // my total leave now after coming
  $nowtotalleave = $from->diffInDays($camefromexam);
  // 5 days
  // dd($nowtotalleave);
  // for serching from data base 
  $finddatafromleaverequest = $to->diffInDays($from) + 1;
  // dd($finddatafromleaverequest);
  // 9
  // dd($finddatafromleaverequest);

  // dd($requestdays);
  // $holidaycount = DB::table('holidays')->where('startdate', '>=', $team->from)
  //   ->where('enddate', '<=', $team->to)
  //   ->count();
  // //0
  // $totalrqstday = $nowrequestdays - $holidaycount;
  // 9
  // dd($holidaycount);
  // dd($totalrqstday);

  DB::table('leaveapprove')
    ->where('teammemberid', $team->createdby)
    ->where('totaldays', $finddatafromleaverequest)
    ->latest()
    ->update([
      'totaldays' => $nowtotalleave,
      'updated_at' => now(),
    ]);
  // dd($finddatafromleaverequest);

  // dd($team->from);
  // "2023-12-16"
  // dd($team->date);
  // "2023-12-20"
  // dd($team->to);
  // "2023-12-24"
  //! working one delete ek baar me
  // // $period = CarbonPeriod::create($team->date, $team->to);
  // $period = CarbonPeriod::create('2023-12-21', $team->to);
  // // dd($period);
  // $datess = [];
  // foreach ($period as $date) {
  //   $datess[] = $date->format('Y-m-d');
  //   // dd($datess);
  //   $deletedIds = DB::table('timesheets')
  //     ->where('created_by', $team->createdby)
  //     ->where('date', $datess)
  //     ->pluck('id');
  //   // dd($deletedIds);

  //   DB::table('timesheets')
  //     ->where('created_by', $team->createdby)
  //     ->where('date', $datess)
  //     ->delete();

  //   $a = DB::table('timesheetusers')
  //     ->whereIn('timesheetid', $deletedIds)
  //     ->delete();
  // }
  // dd($datess);
  // dd($deletedIds);

  $period = CarbonPeriod::create($team->date, $team->to);

  $datess = [];
  foreach ($period as $date) {
    $datess[] = $date->format('Y-m-d');

    $deletedIds = DB::table('timesheets')
      ->where('created_by', $team->createdby)
      ->whereIn('date', $datess)
      ->pluck('id');

    DB::table('timesheets')
      ->where('created_by', $team->createdby)
      ->whereIn('date', $datess)
      ->delete();

    $a = DB::table('timesheetusers')
      ->whereIn('timesheetid', $deletedIds)
      ->delete();
  }

  // dd($datess);


  // $getholidays = DB::table('holidays')->where('startdate', '>=', $team->from)
  //   ->where('enddate', '<=', $team->to)->select('startdate')->get();

  // if (count($getholidays) != 0) {
  //   foreach ($getholidays as $date) {
  //     $hdatess[] = date('Y-m-d', strtotime($date->startdate));
  //   }
  // } else {
  //   $hdatess[] = 0;
  // }

  // dd($hdatess);
  $el_leave = $datess;
  // 0 => "2023-09-16"
  // 1 => "2023-09-17"
  // 2 => "2023-09-18"
  // $exam_leave_total = count(array_diff($datess, $hdatess));
  // 62


  // $lstatus = "EL/A";
  // $lstatus = "Null";
  // $lstatus = "";
  $lstatus = null;

  foreach ($el_leave as $cl_leave) {
    // date get one by one 

    $cl_leave_day = date('d', strtotime($cl_leave));
    // "16"



    $cl_leave_month = date('F', strtotime($cl_leave));

    // September
    // dd($cl_leave_month);
    // dd($cl_leave_day);
    // 16
    if ($cl_leave_day >= 26 && $cl_leave_day <= 31) {
      $cl_leave_month = date('F', strtotime($cl_leave . ' +1 month'));
    }
    // dd('hi1', $team->createdby);
    // 802
    $attendances = DB::table('attendances')->where('employee_name', $team->createdby)
      ->where('month', $cl_leave_month)->first();
    // September
    // dd($attendances);
    //  dd($value->created_by);

    // dd('hi2', $attendances);
    // dd($cl_leave_day);
    // 16
    $column = '';
    switch ($cl_leave_day) {
      case '26':
        $column = 'twentysix';
        break;
      case '27':
        $column = 'twentyseven';
        break;
      case '28':
        $column = 'twentyeight';
        break;
      case '29':
        $column = 'twentynine';
        break;
      case '30':
        $column = 'thirty';
        break;
      case '31':
        $column = 'thirtyone';
        break;
      case '01':
        $column = 'one';
        break;
      case '02':
        $column = 'two';
        break;
      case '03':
        $column = 'three';
        break;
      case '04':
        $column = 'four';
        break;
      case '05':
        $column = 'five';
        break;
      case '06':
        $column = 'six';
        break;
      case '07':
        $column = 'seven';
        break;
      case '08':
        $column = 'eight';
        break;
      case '09':
        $column = 'nine';
        break;
      case '10':
        $column = 'ten';
        break;
      case '11':
        $column = 'eleven';
        break;
      case '12':
        $column = 'twelve';
        break;
      case '13':
        $column = 'thirteen';
        break;
      case '14':
        $column = 'fourteen';
        break;
      case '15':
        $column = 'fifteen';
        break;
      case '16':
        $column = 'sixteen';
        break;
      case '17':
        $column = 'seventeen';
        break;
      case '18':
        $column = 'eighteen';
        break;
      case '19':
        $column = 'ninghteen';
        break;
      case '20':
        $column = 'twenty';
        break;
      case '21':
        $column = 'twentyone';
        break;
      case '22':
        $column = 'twentytwo';
        break;
      case '23':
        $column = 'twentythree';
        break;
      case '24':
        $column = 'twentyfour';
        break;
      case '25':
        $column = 'twentyfive';
        break;
    }
    // dd('pa', $column);
    // sixteen
    // dd('pa', $lstatus);
    // EL/A
    if (!empty($column)) {
      // store EL/A sexteen to 25 tak 
      DB::table('attendances')
        ->where('employee_name', $team->createdby)
        ->where('month', $cl_leave_month)
        ->whereRaw("NOT ({$column} REGEXP '^-?[0-9]+$')")
        ->whereRaw("{$column} != 'LWP'")
        ->update([
          $column => $lstatus,
        ]);
    }
    // if (!empty($column)) {
    //   // store EL/A sexteen to 25 tak 
    //   DB::table('attendances')
    //     ->where('employee_name', $team->createdby)
    //     ->where('month', $cl_leave_month)
    //     ->whereRaw("NOT ({$column} REGEXP '^-?[0-9]+$')")
    //     ->whereRaw("{$column} != 'LWP'")
    //     ->delete();
    // }
  }
  // dd('hq');
}
}
dd('end hare ', $team->name);
//* insert null value in database 

$lstatus = null;
//* delete data between two dates from database 
app\Http\Controllers\ApplyleaveController.php

$to = Carbon::createFromFormat('Y-m-d', $team->to ?? '');
// 2023-12-24 16:12:00.0 Asia/Kolkata (+05:30)
$from = Carbon::createFromFormat('Y-m-d', $team->from);
//2023-12-16 16:12:40.0 Asia/Kolkata (+05:30)
$camefromexam = Carbon::createFromFormat('Y-m-d', $team->date);
// dd($from);
$nowrequestdays = $from->diffInDays($camefromexam) + 1;
// 5 days

$finddatafromleaverequest = $to->diffInDays($from) + 1;


$period = CarbonPeriod::create($team->date, $team->to);

$datess = [];
foreach ($period as $date) {
  $datess[] = $date->format('Y-m-d');

  $deletedIds = DB::table('timesheets')
    ->where('created_by', $team->createdby)
    ->whereIn('date', $datess)
    ->pluck('id');

  DB::table('timesheets')
    ->where('created_by', $team->createdby)
    ->whereIn('date', $datess)
    ->delete();

  $a = DB::table('timesheetusers')
    ->whereIn('timesheetid', $deletedIds)
    ->delete();
}

dd($datess);
//* error get patch ya any route related use it / regarding route 

Route::any('/examleaverequestapprove/{id}', [ApplyleaveController::class, 'examleaverequest'])->name('examleaveapprove');
// with id and without id 
Route::get('/timesheetreject/edit/{id?}', [TimesheetController::class, 'timesheetEdit']);


//* holidays count
// app\Http\Controllers\ApplyleaveController.php in update function 

$holidaycount = DB::table('holidays')->where('startdate', '>=', $team->from)
->where('enddate', '<=', $team->to)
->count();
dd($holidaycount);
//* regarding redirect / regarding message /success message / regarding output / regarding return / regarding url
if ($checkrole->role_id != $request->designationtype) {

  $role = '';
  if ($checkrole->role_id == 11) {
      $role = "super admin";
  } elseif ($checkrole->role_id == 12) {
      $role = "admin";
  } elseif ($checkrole->role_id == 13) {
      $role = "partner";
  } elseif ($checkrole->role_id == 14) {
      $role = "manager";
  } elseif ($checkrole->role_id == 15) {
      $role = "staff";
  }
  $output = array('msg' => 'You have already on this post ' . $role . '.');
  return redirect('teammember')->with('success', $output);
}

$output = array('msg' => "Created Successfully <strong>Client Name:</strong> $clientname->client_name <strong>Assignment:</strong> $assignment_name <strong>Assignment Name:</strong> $request->assignmentname <strong>Assignment Id:</strong> $assignmentgenerate ");
return redirect('assignmentbudgeting')->with('success', $output);

// @if (session()->has('success'))
// <div class="alert alert-success">
//     @if (is_array(session()->get('success')))
//         @foreach (session()->get('success') as $message)
//             <p>{!! $message !!}</p>
//         @endforeach
//     @else
//         <p>{{ session()->get('success') }}</p>
//     @endif
// </div>
// @endif
if ($from->equalTo($to)) {
  // Check if the selected date is Sunday
  if ($from->dayOfWeek === Carbon::SUNDAY) {
    return back()->with('statuss', ['msg' => 'You cannot apply leave for Sunday']);
  }

  // Check if the selected date is a holiday
  $holidayCheck = DB::table('holidays')
    ->whereDate('startdate', '=', $from)
    ->orWhereDate('enddate', '=', $from)
    ->exists(); // Use exists() to avoid fetching unnecessary data

  if ($holidayCheck) {
    return back()->with('statuss', ['msg' => 'You cannot apply leave on a holiday']);
  }
}
$output = ['msg' => 'You cannot apply leave before the rejoining date: ' . $leavingdate->format('d-m-Y')];
$output = ['msg' => 'You cannot select this user as their leaving date (' . $leavingdate->format('d-m-Y') . ') is before the start date.'];
// return back()->with('statuss', $output);
$request->flash();
return back()->with('statuss', $output);
$output = array('msg' => 'You are already on this post "' . $role . '".');
$output = ['msg' => "You can not fill timesheet to: Assignment name " . $assignmentcloseddata->assignmentname . " Assignment id: " . $request->assignment_id[$i]];
$output = ['msg' => "You can not fill timesheet to: " . $request->assignment_id[$i]];
$output = array('msg' => "Timesheet Submit Successfully till " . Carbon::createFromFormat('Y-m-d', $previousMondayFormatted)->format('d-m-Y') . " to " . Carbon::createFromFormat('Y-m-d', $nextSaturdayFormatted)->format('d-m-Y'));
$output = array('msg' => "Timesheet Submit Successfully till $previousMondayFormatted to $nextSaturdayFormatted ");
$output = array('msg' => "Fill the timesheet Previous Week: $formattedPreviousSaturday");
$output = array('msg' => 'Please Approve Latest Timesheet Request');
$output = array('msg' => 'You Have already filled timesheet for the Day (' . date('d-m-Y', strtotime($leaveDate)) . ')');
return redirect('timesheetrequest/view/' . $id)->with('statuss', $output);

// for rejected message 
$output = array('msg' => 'Rejected Successfully');
return back()->with('statuss', $output);

// for success message 
$output = array('msg' => 'You have already submitted a request');
return back()->with('success', $output);

// return back()->with('statuss', $output);
return redirect()->to('rejectedlist')->with('statuss', $output);
// return redirect('teammember')->with('status', $output);
$output = array('msg' => 'Download has been initiated please wait some time ');
return back()->with('success', $output);

//* Ternary operator vs Null coalescing operator in PHP
// Ternary Operator

// Ternary operator is the conditional operator which helps to cut the number of lines in the coding while performing comparisons and conditionals. It is an alternative method of using if else and nested if else statements. The order of execution is from left to right. It is absolutely the best case time saving option. It does produces an e-notice while encountering a void value with its conditionals. 

// Syntax:

// (Condition) ? (Statement1) : (Statement2);
// Example
// PHP program to check number is even
// or odd using ternary operator
 
// Assign number to variable
$num = 21;
 
// Check condition and display result
print ($num % 2 == 0) ? "Even Number" : "Odd Number";


// Null coalescing operator

// The Null coalescing operator is used to check whether the given variable is null or not and returns the non-null value from the pair of customized values. Null Coalescing operator is mainly used to avoid the object function to return a NULL value rather returning a default optimized value. It is used to avoid exception and compiler error as it does not produce E-Notice at the time of execution. The order of execution is from right to left. While execution, the right side operand which is not null would be the return value, if null the left operand would be the return value. It facilitates better readability of the source code. 

// Syntax:

// (Condition) ? (Statement1) ? (Statement2);

// PHP program to use Null 
// Coalescing Operator
 
// Assign value to variable
$num = 10;
 
// Use Null Coalescing Operator 
// and display result
print ($num) ?? "NULL";
Output:
10

//*
    //BAN100157Nitin Singhal
    //* inactive and active / rejected / submitted  / mail send / send mail
    public function  assignmentreject($id, $status,$teamid)
    {
        // dd($teamid);
      try {

       if($status==1){
        DB::table('assignmentteammappings')->where('id', $id)->update([
            'status'   => 1,
          ]);
       }
        else{
            DB::table('assignmentteammappings')->where('id', $id)->update([
                'status'   => 0,
              ]); 

              // timesheet rejected mail
        $data = DB::table('teammembers')
        ->where('teammembers.id', $teamid)
        ->first();
      //   dd($data);
      $emailData = [
        'emailid' => $data->emailid,
        'teammember_name' => $data->team_member,
      ];

      Mail::send('emails.assignmentrejected', $emailData, function ($msg) use ($emailData) {
        $msg->to([$emailData['emailid']]);
        $msg->subject('Assignment rejected');
      });
      // timesheet rejected mail end hare

        }
        
  
  
        $output = array('msg' => 'Rejected Successfully');
        return back()->with('statuss', $output);
      } catch (Exception $e) {
        DB::rollBack();
        Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
        report($e);
        $output = array('msg' => $e->getMessage());
        return back()->withErrors($output)->withInput();
      }
    }
    // find date beetween two dates/ all dates find  

    if ($Newteammeber == null) {
        // Get previuse sunday from joining date
        $joining_timestamp = strtotime($joining_date);
        $day_of_week = date('w', $joining_timestamp);
        $days_to_subtract = $day_of_week;
        $previous_sunday_timestamp = strtotime("-$days_to_subtract days", $joining_timestamp);

        $previous_sunday_date = date('d-m-Y', $previous_sunday_timestamp);
        // Get all dates beetween two dates 
        $startDate = Carbon::parse($previous_sunday_date);
        $endDate = Carbon::parse($joining_date);
        $period = CarbonPeriod::create($startDate, $endDate);
        // store all date in $result vairable
        $result = [];
        foreach ($period as $key => $date) {
          if ($key !== 0 && $key !== count($period) - 1) {
            $result[] = $date->toDateString();
          }
        }
        // return $result;
        // dd('yes', $result);
        foreach ($result as $date) {
          $a = DB::table('timesheetusers')->insert([
            'date'        => date('Y-m-d', strtotime($date)),
            'createdby'   => auth()->user()->teammember_id,
            'created_at'  => date('Y-m-d H:i:s'),
            'updated_at'  => date('Y-m-d H:i:s'),
          ]);
        }
      }
    //* regarding Ascending / regarding Descending / regarding order /regarding ordering / regarding desc / regarding asc

//     Difference:

// asc → sabse pehla (oldest) record milega

// desc → sabse last (latest) record milega
    $getauthh =  DB::table('timesheetusers')
    ->where('createdby', auth()->user()->teammember_id)
    ->orderBy('id', 'asc')->paginate(10);
    ->orderby('id', 'desc')->first();
    //* compare date in controller 

    $requestDate = Carbon::parse($request->date);
    $joiningDate = Carbon::parse($joining_date);

    if ($requestDate >= $joiningDate) {
    }
    //* how to  get all date beteen two dates in laravel/ two dates get beetweeen
    elseif ($Newteammeber->id != null) {
        $Newteammeberjoining_date = DB::table('teammembers')
          ->where('id', auth()->user()->teammember_id)
          ->select('joining_date')
          ->first();

        $joining_date = date('d-m-Y', strtotime($Newteammeberjoining_date->joining_date));
        $joining_timestamp = strtotime($joining_date);

        // Calculate the day of the week for the joining date (0 for Sunday, 1 for Monday, and so on)
        $day_of_week = date('w', $joining_timestamp);

        // Calculate the number of days to subtract to reach the previous Sunday
        $days_to_subtract = $day_of_week;

        // Calculate the timestamp of the previous Sunday
        $previous_sunday_timestamp = strtotime("-$days_to_subtract days", $joining_timestamp);

        // Format the previous Sunday date in the desired format
        $previous_sunday_date = date('d-m-Y', $previous_sunday_timestamp);

        $startDate = Carbon::parse($previous_sunday_date);
        $endDate = Carbon::parse($joining_date);

        // Create a date period
        $period = CarbonPeriod::create($startDate, $endDate);

        $result = [];

        // Iterate over the period and store each date in the result array
        foreach ($period as $key => $date) {
          // Skip the first and last iterations
          if ($key !== 0 && $key !== count($period) - 1) {
            $result[] = $date->toDateString();
          }
        }

        // Return the result array
        return $result;
      }

    // 11111111111111111
      use Carbon\Carbon;
      use Carbon\CarbonPeriod;
      
      $startDate = Carbon::parse('2023-01-01');
      $endDate = Carbon::parse('2023-01-10');
      
      // Create a date period
      $period = CarbonPeriod::create($startDate, $endDate);
      
      // Iterate over the period and get each date
      foreach ($period as $date) {
          echo $date->toDateString() . "\n";
      }
      
    //* insert months in database 
          // insert data in timesheet from request and get id only
          $id = DB::table('timesheets')->insertGetId(
            [
              'created_by' => auth()->user()->teammember_id,
              'month'     =>    date('F', strtotime($request->date)),
              'date'     =>    date('Y-m-d', strtotime($request->date)),
              'created_at'          =>     date('Y-m-d H:i:s'),
            ]
          );

    //*  week days in numbric/ regarding months / weeks days / regarding date and time  /regarding date / regarding time

//* in blade file 
$joining_date = $pormotionandrejoiningdata->joining_date ?
Carbon::parse($pormotionandrejoiningdata->joining_date)->format('d-m-Y') : null;

 //     <small class="text-muted">
//         {{ \Carbon\Carbon::parse($birthday->dateofbirth)->format('d M') }}
//          {{-- 14 jan output --}}
//      </small>
    
    // dd(date('w', strtotime($request->date))); // 4

        $period = CarbonPeriod::create($team->from, $team->to);
        
        //  dd(date('Y-m-d', strtotime($request->date))); "2023-11-30"

        // $currentDate = Carbon::now()->format('d-m-Y');// "30-11-2023"

        // $currentday = date('Y-m-d', strtotime($request->date));// "2023-11-30"

        //   dd(date('F', strtotime($request->date)));// "November"

             // dd(date('Y-m-d H:i:s')); // "2023-11-30 15:26:18"

        // 'month'     =>    date('F', strtotime($request->date)),//November

        date('F d,Y', strtotime($holidayDatas->startdate)); //January 14,2023
// Get hour
          dd(date('H', strtotime($latestrequest->created_at))); //11

          dd($latestrequesthour->diffInHours($currentDateTime));

          DB::table('leaverequest')->insert([
            'applyleaveid' => $request->applyleaveid,
            'createdby' => $request->createdby,
            'approver' => $request->approver,
            'status' => $request->status,
            'reason' => $request->reason,
            'date' => date('Y-m-d', strtotime($request->date)),
            'created_at'          =>     date('Y-m-d H:i:s'),
            'updated_at'              =>    date('Y-m-d H:i:s'),
          ]);

          // count days 
    // Convert the requested date to a Carbon instance
          $to = Carbon::createFromFormat('Y-m-d', $team->to ?? '');
            // date: 2023-11-16 15:42:44.0 Asia/Kolkata (+05:30)
            // dd($to);
                // Convert the requested date to a Carbon instance
            $from = Carbon::createFromFormat('Y-m-d', $team->from);

            // date: 2023-09-16 15:43:42.0 Asia/Kolkata (+05:30)
            // dd($from);
            $requestdays = $to->diffInDays($from) + 1;
            // 62 days
          // count days  end

          // current date 
          'otpverifydate' => date('Y-m-d H:i:s')
          $assignmentcloseddate = \DateTime::createFromFormat('Y-m-d H:i:s', $assignmentcloseddata->otpverifydate)->setTime(23, 59, 59);

       // current date 
          $assignmentcloseddata = DB::table('assignmentbudgetings')->where('assignmentgenerate_id', $request->assignment_id[$i])->first();
          $requestDate = \DateTime::createFromFormat('d-m-Y', $request->date);
          $assignmentcloseddate = \DateTime::createFromFormat('Y-m-d H:i:s', $assignmentcloseddata->otpverifydate)->setTime(23, 59, 59);

          if ($assignmentcloseddata->status == 0 && $assignmentcloseddate <= $requestDate) {
            $output = ['msg' => 'Hi shahid.'];
            return redirect('timesheet/mylist')->with('success', $output);
          }



       // now() function 
    //    12
    $year = now()->year; 
    $previewsunday1 = $year->subWeeks(1)->endOfWeek();    
        dd(now()->month); 
        // 2023
        dd(date('Y-m-d')); 
        // 2023-12-01
        dd(now()->year); 
        // 1 
        dd(now()->day); 
        // 17
        dd(now()->hour); 
        // 13;
        dd(now()->minute); 
        // Formats the date and time as a string (e.g., '2023-12-01 15:30:00').
        $formattedDateTime = now()->format('Y-m-d H:i:s'); 
        // Formats the date and time as a string (e.g., '2023-12-01 15:30:00').
        $formattedDateTime = now()->format('Y-m-d H:i:s'); 
        // Current year (e.g., 2023)
        $year = now()->year; 
        $previewsunday1 = $year->subWeeks(1)->endOfWeek();    
        // Current month (e.g., 12)
        $month = now()->month;   
        // Current day of the month (e.g., 1)
        $day = now()->day;       
        // Current hour (e.g., 15)
        $hour = now()->hour;     
        // Current minute (e.g., 30)
        $minute = now()->minute; 
        // Add 7 days to the current date
        $futureDate = now()->addDays(7);   
        // Subtract 2 hours from the current date and time
         $pastDate = now()->subHours(2);    
         // Check if the current date and time is in the future
         $isFuture = now()->isFuture();     
         // Check if the current date and time is in the past
         $isPast = now()->isPast();         
         // Convert the current date and time to a different timezone
         $userTimeZone = now()->setTimezone('America/New_York'); 
         $dropdownYears = DB::table('timesheets')
         ->where('created_by', auth()->user()->teammember_id)
         ->select(DB::raw('YEAR(date) as year'))
         ->distinct()->orderBy('year', 'DESC')->pluck('year');
 
       // dd($dropdownYears);
       // 0 => 2024
       // 1 => 2023
 
       $dropdownMonths = DB::table('timesheets')
         ->where('created_by', auth()->user()->teammember_id)
         ->distinct()
         ->pluck('month');
 
       // dd($dropdownMonths);
       // 0 => "October"
       // 1 => "December"
       // 2 => "November"
       // 3 => "January"
       // 4 => "February"
 
       $currentDate = now();
       'created_at' => date('Y-m-d H:i:s'),
       // 2024-01-16 00:46:21.610590
 
       $month = $currentDate->format('F');
       // "January"
       $year = $currentDate->format('Y');
       // "2024"
       $lastdate = Carbon::createFromFormat('Y-m-d', $usertimesheetfirstdate->date ?? '')->addDays(6);
       dd($lastdate);

       $currentDate = clone $firstDate;
      //  find day previous week 
       $previousMonday = $requestedDate->copy()->previous(Carbon::MONDAY);

      //  find next day 
       $nextSaturday = $requestedDate->copy()->next(Carbon::SATURDAY);
       dd($nextSaturday, 'hi88');

       
      //  today date
       $todaydate = Carbon::now('Asia/Kolkata');
       dd($todaydate);

      //  find weeek
       $week =  date('d-m-Y', strtotime($previousMondayFormatted))  . ' to ' . date('d-m-Y', strtotime($nextSaturdayFormatted));

       $upcomingSunday = (new DateTime($firstDate->format('Y-m-d')))->modify("+$daysToAdd days")->format('Y-m-d');

      //* date() function 
      // Formats the current date and time as a string
      $currentDateTime = date('Y-m-d H:i:s'); 
      // Formats a specific date
      $formattedDate = date('Y-m-d', strtotime('2023-12-01')); 
      // Convert a string to a Unix timestamp
      $timestamp = strtotime('2023-12-01'); 
      // Format the Unix timestamp
      $formattedDate = date('Y-m-d', $timestamp); 
      // December 29th
     date('F jS', strtotime($notificationData->created_at))
     $output = array('msg' => 'You Have already filled timesheet for the Day (' . date('d-m-Y', strtotime($leaveDate)) . ')');
      
      // Current year
       $year = date('Y');     
       // Current month
       $month = date('m');    
       // Current day of the month
       $day = date('d');      
       // Current hour (24-hour format)
       $hour = date('H');     
       // Current minute
       $minute = date('i');   
       // Current second
       $second = date('s');   
       // Current day of the week (full text, e.g., "Monday")
       $dayOfWeek = date('l');
       // Custom date and time format (e.g., "December 1, 2023, 3:30 pm")
       $customFormat = date('F j, Y, g:i a'); 
      //  10:55 am
      $msg = 'You can submit new timesheet request after 24 hour from ' . date('h:i:s A', strtotime($latestrequest->created_at));
       $customFormat = date('g:i a', strtotime($timesheetrequestsData->created_at)); 

       date('d-m-Y', strtotime($timesheetrequestsData->created_at))
      //  12-10-2023
      // get only date
      $cl_leave_day = date('d', strtotime($cl_leave));
      // 12
       date('h-m-s', strtotime($timesheetrequestsData->created_at)) 
      //  11:12:53
      // 10 days only in table then
      // December 20,2023 - December 20,2023
      <td>{{ date('F d,Y', strtotime($applyleaveDatas->from)) ?? '' }} -
      {{ date('F d,Y', strtotime($applyleaveDatas->to)) ?? '' }}</td>
      
// 18-12-23 then / basically add date in date
      $lastdate = Carbon::createFromFormat('Y-m-d', $usertimesheetfirstdate->date ?? '')->addDays(6);
// it will give result 24-12-23

             // Convert the retrieved date to a DateTime object
             $firstDate = new DateTime($usertimesheetfirstdate->date);
             // date: 2023-11-18 00:00:00.0 Asia/Kolkata (+05:30)

             // Find the day of the week for the first date (0 = Sunday, 1 = Monday, ..., 6 = Saturday)
             $dayOfWeek = $firstDate->format('w');



    // Sunday=1
    // Monday=2
    // Tuesday=3
    // Wednesday=4
    // Thursday=5
    // Friday=6
    // Saturday=7
    // Sunday=8

    if(
        (now()->isSunday() && now()->hour >= 18) ||
            now()->isMonday() ||
            now()->isTuesday() ||
            now()->isWednesday() ||
            now()->isThursday() ||
            now()->isFriday() ||
            (now()->isSaturday() && now()->hour <= 18)){

            }


     //* format() function 
     // Formats the current date and time as a string
     $formattedDateTime = now()->format('Y-m-d H:i:s'); 
     // Formats a specific date
     $formattedDate = Carbon\Carbon::parse('2023-12-01')->format('Y-m-d'); 
     $user = User::find(1);
     // Formats a date property of a model
     $formattedBirthdate = $user->birthdate->format('F j, Y'); 
     {{-- Blade View --}}
     {{ $user->created_at->format('M d, Y') }}
     $formattedDate = $user->created_at->format('d/m/Y');
     // "2 days ago"
     $relativeTime = now()->subDays(2)->diffForHumans(); 
     // Custom date and time format
     $customFormat = now()->format('F j, Y \a\t g:i A'); 
     // Spanish locale
     $formattedDate = now()->locale('es')->isoFormat('dddd, MMMM D, YYYY'); 
//* find last week / in_array
if ($savetimesheet) {
  $savetimesheetdate = Carbon::parse($savetimesheet->date);
  $previousSaturday = $savetimesheetdate->copy()->previous(Carbon::SATURDAY);
  dd($previousSaturday);
} else {
  // Handle the case where $savetimesheet is null or no records match the conditions
}
//* find last week / in_array
    // find previus sunday 
    $previewsunday = now()->subWeeks(1)->endOfWeek();
    $previewsundayformate = $previewsunday->format('d-m-Y');

    // find previus saturday
    $previewsaturday = now()->subWeeks(1)->endOfWeek();
    // Subtract one day from sunday
    $previewsaturdaydate = $previewsaturday->subDay();
    $previewsaturdaydateformate = $previewsaturdaydate->format('d-m-Y');

    foreach ($teammembers as $teammembermail) {
        // both date store in an array 
        $validDates = [$previewsundayformate, $previewsaturdaydateformate];
        if (!in_array($teammembermail->last_submission_date, $validDates)) {
            $data = array(
                'subject' => "Reminder || Timesheet not filled Last Week",
                'name' =>   $teammembermail->team_member,
                'email' =>   $teammembermail->emailid,
            );
            Mail::send('emails.timesheetnotfilledstafflastweekremidner', $data, function ($msg) use ($data) {
                $msg->to($data['email']);
                $msg->subject($data['subject']);
            });
        }
    }






     //* auth() function 

     if (auth()->check()) {
        // User is authenticated
    } else {
        // User is not authenticated
    }
    // Returns the currently authenticated user or null if not authenticated
    $user = auth()->user(); 
    if (auth()->user()->isAdmin()) {
        // User is an admin
    }
    
    if (auth()->user()->can('edit_posts')) {
        // User has permission to edit posts
    }
    // Manually Authenticate a User:
    $user = User::find(1);
    // Manually log in a user
     auth()->login($user); 
    //  Log Out the Currently Authenticated User:
    // Log out the currently authenticated user
     auth()->logout(); 

     if (auth()->guest()) {
        // User is a guest (not authenticated)
    }
    // Check if a User is Authenticated via a Guard:
    if (auth('admin')->check()) {
        // User is authenticated using the 'admin' guard
    }
    // Returns the ID of the currently authenticated user or null if not authenticated
    $userId = auth()->id(); 

    if (auth()->guard('admin')->check()) {
        // User is authenticated using the 'admin' guard
    }
    // Check if a User is Remembered:
    if (auth()->viaRemember()) {
        // User is authenticated via "remember me" cookie
    }
    // Returns the user's authentication identifier
    $identifier = auth()->id(); 
    // Returns the authentication provider instance
    $provider = auth()->getProvider(); 
    // Returns the "remember me" token
    $rememberToken = auth()->user()->getRememberToken(); 
    // Log in a user by ID
    auth()->loginUsingId(1); 
    // Log the user out of all other devices
    auth()->user()->logoutOtherDevices('password'); 
    // Returns the name of the default guard
    $guardName = auth()->getDefaultDriver(); 
    // Returns the currently authenticated user or null if not authenticated
    $user = user(); 
    if (user()) {
        // User is authenticated
    } else {
        // User is not authenticated
    }
    // Get the user's ID
    $userId = user()->id;      
     // Get the user's name
    $userName = user()->name;  
    // Get the user's email
     $userEmail = user()->email; 
     if (user()->isAdmin()) {
        // User is an admin
    }
    
    if (user()->can('edit_posts')) {
        // User has permission to edit posts
    }
    $user = User::find(1);
    // Manually set the authenticated user
     user($user); 
     // Log out the currently authenticated user
     user()->logout(); 
     // Returns the user's authentication identifier
     $identifier = user()->getAuthIdentifier(); 
     // Returns the user's authentication provider name
     $provider = user()->getAuthIdentifierName(); 
     if (user()->guard('admin')->check()) {
        // User is authenticated using the 'admin' guard
    }
    
//* compare houre / hour compare 
    $latestrequest = DB::table('timesheetrequests')
        ->where('createdby', auth()->user()->teammember_id)
        ->select('created_at')
        ->first();

      $latestrequesthour = Carbon::parse($latestrequest->created_at);
      $currentDateTime = Carbon::now();
      // Check if the difference is more than 24 hours
      if ($latestrequesthour->diffInHours($currentDateTime) > 24) {
        $id = DB::table('timesheetrequests')->insertGetId([
          'partner'     => $request->partner,
          'reason'      => $request->reason,
          'status'      => 0,
          'createdby'   => auth()->user()->teammember_id,
          'created_at'  => now(),
          'updated_at'  => now(),
        ]);
      }
    



   //*  dd with mesaage/ check dd output 
    // dd('hi', $previoussavechck);

    //* ager ek table ke id ko dusre table ke kisi id se compare karna ho to / id pass /pass data in another table 


    $excludedIds = DB::table('timesheetusers')->select('createdby')->distinct()->get()->pluck('createdby')->toArray();
    $teammemberOnlySave = DB::table('teammembers')
        ->leftJoin('timesheets', 'timesheets.created_by', 'teammembers.id')
        ->where('teammembers.status', 1)
        ->whereIn('timesheets.created_by', $excludedIds)
        ->select('teammembers.team_member', 'teammembers.emailid', 'teammembers.id')
        ->groupBy('teammembers.team_member', 'teammembers.emailid', 'teammembers.id')
        ->havingRaw('COUNT(DISTINCT timesheets.id) = COUNT(CASE WHEN timesheets.status = 0 THEN 1 ELSE NULL END)')
        ->get();


    dd($teammemberOnlySave);
    //* today time insert in database /time/ current time in database 'created_at' => now(),
    public function timesheeteditstore(Request $request)
    {
      try {
        DB::table('timesheetusers')->where('id', $request->timesheetusersid)->update([
          'status'   =>   1,
          'client_id'   =>  $request->client_id,
          'assignment_id'   =>  $request->assignment_id,
          'partner'   =>  $request->partner,
          'workitem'   =>   $request->workitem,
          'createdby'   =>   $request->createdby,
          'location'   =>   $request->location,
          'hour'   =>   $request->hour,
        ]);
  
        if ($request->status == 2) {
          DB::table('timesheetupdatelogs')->insert([
            'timesheetusers_id'   =>  $request->timesheetusersid,
            'status'   =>   1,
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

    //* filter on mail days wise

    if ('Friday' == date('l', time()) || 'Saturday' == date('l', time())) {
    }
    //* last week reminder /mail / notification on mail

    // public function handle()
    // {
    //     $teammember =  DB::table('teammembers')
    //         ->leftjoin('timesheetusers', 'timesheetusers.createdby', 'teammembers.id')
    //         ->where('timesheetusers.created_at', '<', now()->subWeek())
    //         ->select('teammembers.emailid', 'teammembers.team_member', 'teammembers.id')
    //         ->distinct('timesheetusers.createdby')
    //         ->get();
    //     dd($teammember);
    //     $data = array(
    //         'subject' => "Timesheet Not filled Last Week",
    //         'teammember' =>   $teammember,
    //     );
    //     Mail::send('emails.timesheetnotfilledlastweekreminder', $data, function ($msg) use ($data) {
    //         $msg->to('itsupport_delhi@vsa.co.in');
    //         $msg->cc('Admin_delhi@vsa.co.in');
    //         $msg->subject($data['subject']);
    //     });
    // }

    // public function handle()
    // {
    //     $teammember = DB::table('teammembers')
    //         ->leftJoin('timesheetusers', 'timesheetusers.createdby', 'teammembers.id')
    //         ->where('timesheetusers.date', '<', now()->subWeeks(1))
    //         ->select('teammembers.emailid', 'teammembers.team_member', 'teammembers.id')
    //         ->distinct('timesheetusers.createdby')
    //         ->get();

    //     // Get the last submission date for each user only sunday and suterday
    //     foreach ($teammember as $user) {
    //         $lastSubmissionDate = DB::table('timesheetusers')
    //             // get all date of this user
    //             ->where('createdby', $user->id)
    //             ->where('date', '<', now()->subWeeks(1))
    //             ->where(function ($query) {
    //                 $query->whereRaw('DAYOFWEEK(date) = 1') // Sunday
    //                     ->orWhereRaw('DAYOFWEEK(date) = 7'); // Saturday
    //             })
    //             // ->distinct('date')
    //             ->max('date');

    //         // Format the date as 'd-m-y'
    //         // $lastSubmissionDate = Carbon::parse($lastSubmissionDate)->format('d-m-y');
    //         $lastSubmissionDate = $lastSubmissionDate ? Carbon::parse($lastSubmissionDate)->format('d-m-Y') : '';

    //         $user->last_submission_date = $lastSubmissionDate;
    //     }

    //     // dd($teammember);

    //     $data = array(
    //         'subject' => "Timesheet Not filled Last Week",
    //         'teammember' => $teammember,
    //     );

    //     Mail::send('emails.timesheetnotfilledlastweekreminder', $data, function ($msg) use ($data) {
    //         $msg->to('itsupport_delhi@vsa.co.in');
    //         $msg->cc('Admin_delhi@vsa.co.in');
    //         $msg->subject($data['subject']);
    //     });
    // }

//! god code 
    // public function handle()
    // {
    //     $teammember = DB::table('teammembers')
    //         ->leftJoin('timesheetusers', 'timesheetusers.createdby', 'teammembers.id')
    //         ->where('timesheetusers.date', '<', now()->subWeeks(1))
    //         ->select('teammembers.emailid', 'teammembers.team_member', 'teammembers.id')
    //         ->distinct('timesheetusers.createdby')
    //         ->get();

    //     // Get the last submission date for each user only sunday and suterday
    //     foreach ($teammember as $user) {
    //         // $lastSubmissionDate = DB::table('timesheetusers')
    //         //     // get all date of this user
    //         //     ->where('createdby', $user->id)
    //         //     ->where('date', '<', now()->subWeeks(1))
    //         //     ->where('status', '!=', 0)
    //         //     ->where(function ($query) {
    //         //         $query->whereRaw('DAYOFWEEK(date) = 1') // Sunday
    //         //             ->orWhereRaw('DAYOFWEEK(date) = 7'); // Saturday
    //         //     })
    //         //     // ->distinct('date')
    //         //     ->max('date');
        
    //         // Format the date as 'd-m-y'
    //         // $lastSubmissionDate = Carbon::parse($lastSubmissionDate)->format('d-m-y');
    //         $lastSubmissionDate = $lastSubmissionDate ? Carbon::parse($lastSubmissionDate)->format('d-m-Y') : '';

    //         $user->last_submission_date = $lastSubmissionDate;
    //     }
    //     // dd($teammember);
    //     // Create an array for the Excel export (excluding 'id')
    //     $excelData = $teammember->filter(function ($user) {
    //         return !empty($user->last_submission_date);
    //     })->map(function ($user) {
    //         return [
    //             'team_member' => $user->team_member,
    //             'emailid' => $user->emailid,
    //             'last_submission_date' => $user->last_submission_date,
    //         ];
    //     })->toArray();

    //     $export = new TimesheetLastWeekExport(collect($excelData));
    //     $excelFileName = 'Timesheet_last_week.xlsx';
    //     Excel::store($export, $excelFileName);

    //     // Modify the data for the email (excluding 'id')
    //     $emailData = array(
    //         'subject' => "Timesheet Not filled Last Week",
    //         'teammember' => $teammember->map(function ($user) {
    //             return (object) [
    //                 'team_member' => $user->team_member,
    //                 'emailid' => $user->emailid,
    //                 'last_submission_date' => $user->last_submission_date,
    //             ];
    //         }),
    //     );

    //     // dd($teammember);

    //     // Attach the Excel file to the email
    //     Mail::send('emails.timesheetnotfilledlastweekreminder', $emailData, function ($msg) use ($emailData, $excelFileName) {
    //         $msg->to('itsupport_delhi@vsa.co.in');
    //         $msg->cc('Admin_delhi@vsa.co.in');
    //         // Attach the Excel file to the email
    //         $msg->attach(storage_path('app/' . $excelFileName), [
    //             'as' => $excelFileName,
    //             'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    //         ]);
    //         $msg->subject($emailData['subject']);
    //     });
    // }
    public function handle()
    {
        $teammember = DB::table('teammembers')
            ->leftJoin('timesheetusers', 'timesheetusers.createdby', 'teammembers.id')
            // ->where('timesheetusers.date', '<', now()->subWeeks(1))
             ->where('timesheetusers.date', '<=', now()->subWeeks(1)->endOfWeek()) 
            ->select('teammembers.emailid', 'teammembers.team_member', 'teammembers.id')
            ->distinct('timesheetusers.createdby')
            ->get();

        // Get the last submission date for each user only sunday and suterday
        foreach ($teammember as $user) {
            $lastSubmissionDate = DB::table('timesheetusers')
                // get all date of this user
                ->where('createdby', $user->id)
                ->where('date', '<=', now()->subWeeks(1)->endOfWeek())
                // ->where('date', '<', now()->subWeeks(1))
                ->where('status', '!=', 0)
                ->where(function ($query) {
                    $query->whereRaw('DAYOFWEEK(date) = 1') // Sunday
                        ->orWhereRaw('DAYOFWEEK(date) = 7'); // Saturday
                })
                // ->distinct('date')
                ->max('date');
        
            // Format the date as 'd-m-y'
            // $lastSubmissionDate = Carbon::parse($lastSubmissionDate)->format('d-m-y');
            $lastSubmissionDate = $lastSubmissionDate ? Carbon::parse($lastSubmissionDate)->format('d-m-Y') : '';

            $user->last_submission_date = $lastSubmissionDate;
        }
        // dd($teammember);
        // Create an array for the Excel export (excluding 'id')
        $excelData = $teammember->filter(function ($user) {
            return !empty($user->last_submission_date);
        })->map(function ($user) {
            return [
                'team_member' => $user->team_member,
                'emailid' => $user->emailid,
                'last_submission_date' => $user->last_submission_date,
            ];
        })->toArray();

        $export = new TimesheetLastWeekExport(collect($excelData));
        $excelFileName = 'Timesheet_last_week.xlsx';
        Excel::store($export, $excelFileName);

        // Modify the data for the email (excluding 'id')
        $emailData = array(
            'subject' => "Timesheet Not filled Last Week",
            'teammember' => $teammember->map(function ($user) {
                return (object) [
                    'team_member' => $user->team_member,
                    'emailid' => $user->emailid,
                    'last_submission_date' => $user->last_submission_date,
                ];
            }),
        );

        // dd($teammember);

        // Attach the Excel file to the email
        Mail::send('emails.timesheetnotfilledlastweekreminder', $emailData, function ($msg) use ($emailData, $excelFileName) {
            $msg->to('itsupport_delhi@vsa.co.in');
            $msg->cc('Admin_delhi@vsa.co.in');
            // Attach the Excel file to the email
            $msg->attach(storage_path('app/' . $excelFileName), [
                'as' => $excelFileName,
                'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]);
            $msg->subject($emailData['subject']);
        });
    }
    // 222222222222222222
    // public function handle()
    // {
    //     $teammember = DB::table('teammembers')
    //         ->leftJoin('timesheetusers', 'timesheetusers.createdby', 'teammembers.id')
    //         ->where('timesheetusers.date', '<', now()->subWeeks(1))
    //         ->select('teammembers.emailid', 'teammembers.team_member', 'teammembers.id')
    //         ->distinct('timesheetusers.createdby')
    //         ->get();

    //     // Get the last submission date for each user only sunday and suterday
    //     foreach ($teammember as $user) {
    //         $teammember = DB::table('teammembers')
    //         ->leftJoin('timesheetusers', function ($join) {
    //             $join->on('timesheetusers.createdby', '=', 'teammembers.id')
    //                 ->where('timesheetusers.date', '<', now()->subWeeks(1))
    //                 ->where('timesheetusers.status', '!=', 0)
    //                 ->where(function ($query) {
    //                     $query->whereRaw('DAYOFWEEK(timesheetusers.date) = 1') // Sunday
    //                         ->orWhereRaw('DAYOFWEEK(timesheetusers.date) = 7'); // Saturday
    //                 });
    //         })
    //         ->select('teammembers.emailid', 'teammembers.team_member', 'teammembers.id')
    //         ->distinct('timesheetusers.createdby')
    //         ->get();
        
    //     // Get the last submission date for each user
    //     foreach ($teammember as $user) {
    //         $lastSubmissionDate = $user->max('date');
            
    //         // Format the date as 'd-m-y'
    //         $lastSubmissionDate = $lastSubmissionDate ? Carbon::parse($lastSubmissionDate)->format('d-m-Y') : '';
        
    //         $user->last_submission_date = $lastSubmissionDate;
    //     }
        
    //     // Rest of your code...
        
    //     }
    //     // dd($teammember);
    //     // Create an array for the Excel export (excluding 'id')
    //     $excelData = $teammember->filter(function ($user) {
    //         return !empty($user->last_submission_date);
    //     })->map(function ($user) {
    //         return [
    //             'team_member' => $user->team_member,
    //             'emailid' => $user->emailid,
    //             'last_submission_date' => $user->last_submission_date,
    //         ];
    //     })->toArray();

    //     $export = new TimesheetLastWeekExport(collect($excelData));
    //     $excelFileName = 'Timesheet_last_week.xlsx';
    //     Excel::store($export, $excelFileName);

    //     // Modify the data for the email (excluding 'id')
    //     $emailData = array(
    //         'subject' => "Timesheet Not filled Last Week",
    //         'teammember' => $teammember->map(function ($user) {
    //             return (object) [
    //                 'team_member' => $user->team_member,
    //                 'emailid' => $user->emailid,
    //                 'last_submission_date' => $user->last_submission_date,
    //             ];
    //         }),
    //     );

    //     // dd($teammember);

    //     // Attach the Excel file to the email
    //     Mail::send('emails.timesheetnotfilledlastweekreminder', $emailData, function ($msg) use ($emailData, $excelFileName) {
    //         $msg->to('itsupport_delhi@vsa.co.in');
    //         $msg->cc('Admin_delhi@vsa.co.in');
    //         // Attach the Excel file to the email
    //         $msg->attach(storage_path('app/' . $excelFileName), [
    //             'as' => $excelFileName,
    //             'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    //         ]);
    //         $msg->subject($emailData['subject']);
    //     });
    // }
    
    // public function handle()
    // {
    //     $teammembers = DB::table('teammembers')
    //         ->leftJoin('timesheetusers', function ($join) {
    //             $join->on('timesheetusers.createdby', '=', 'teammembers.id')
    //                 ->where('timesheetusers.date', '>=', now()->subWeeks(1)->startOfWeek()) // Adjusted start date
    //                 ->where('timesheetusers.date', '<=', now()->subWeeks(1)->endOfWeek())   // Adjusted end date
    //                 ->where('timesheetusers.status', '!=', 0)
    //                 ->where(function ($query) {
    //                     $query->whereRaw('DAYOFWEEK(timesheetusers.date) = 1') // Sunday
    //                         ->orWhereRaw('DAYOFWEEK(timesheetusers.date) = 7'); // Saturday
    //                 });
    //         })
    //         ->select('teammembers.emailid', 'teammembers.team_member', 'teammembers.id', DB::raw('MAX(timesheetusers.date) as last_submission_date'))
    //         ->groupBy('teammembers.emailid', 'teammembers.team_member', 'teammembers.id')
    //         ->get();
    
    //     // Format the date as 'd-m-y'
    //     $teammembers->transform(function ($user) {
    //         $user->last_submission_date = $user->last_submission_date ? Carbon::parse($user->last_submission_date)->format('d-m-Y') : '';
    //         return $user;
    //     });
    
    //     // Create an array for the Excel export (excluding 'id')
    //     $excelData = $teammembers->filter(function ($user) {
    //         return !empty($user->last_submission_date);
    //     })->map(function ($user) {
    //         return [
    //             'team_member' => $user->team_member,
    //             'emailid' => $user->emailid,
    //             'last_submission_date' => $user->last_submission_date,
    //         ];
    //     })->toArray();
    
    //     // Create and store the Excel file
    //     $export = new TimesheetLastWeekExport(collect($excelData));
    //     $excelFileName = 'Timesheet_last_week.xlsx';
    //     Excel::store($export, $excelFileName);
    
    //     // Modify the data for the email (excluding 'id')
    //     $emailData = [
    //         'subject' => "Timesheet Not Filled Last Week",
    //         'teammembers' => $teammembers->map(function ($user) {
    //             return (object) [
    //                 'team_member' => $user->team_member,
    //                 'emailid' => $user->emailid,
    //                 'last_submission_date' => $user->last_submission_date,
    //             ];
    //         }),
    //     ];
    
    //     // Attach the Excel file to the email
    //     Mail::send('emails.timesheetnotfilledlastweekreminder', $emailData, function ($msg) use ($emailData, $excelFileName) {
    //         $msg->to('itsupport_delhi@vsa.co.in');
    //         $msg->cc('Admin_delhi@vsa.co.in');
    //         // Attach the Excel file to the email
    //         $msg->attach(storage_path('app/' . $excelFileName), [
    //             'as' => $excelFileName,
    //             'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    //         ]);
    //         $msg->subject($emailData['subject']);
    //     });
    // }
    

}
    //* success message from controller

    try {
        DB::table('timesheetusers')->where('id', $request->timesheetusersid)->update([
          'status'   =>   1,
          'client_id'   =>  $request->client_id,
          'assignment_id'   =>  $request->assignment_id,
          'partner'   =>  $request->partner,
          'workitem'   =>   $request->workitem,
          'createdby'   =>   $request->createdby,
          'location'   =>   $request->location,
          'hour'   =>   $request->hour,
        ]);
  
        if ($request->status == 2) {
          DB::table('timesheetupdatelogs')->insert([
            'timesheetusers_id'   =>  $request->timesheetusersid,
            'status'   =>   1,
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
    //* auth user

      dd(auth()->user()->teammember_id);
    //* store data in database / s3 problem /path store 
    public function store(Request $request)
    {
        // dd(auth()->user()->teammember_id);
        $request->validate([
            'particular' => 'required',
            'file' => 'required',
        ]);

        try {
            $data = $request->except(['_token']);
            $files = [];

            if ($request->hasFile('file')) {
                foreach ($request->file('file') as $file) {
                    $name = $file->getClientOriginalName();
                    $path = $file->storeAs('public\image\task', $name);
                    $files[] = $name;
                }
            }
            foreach ($files as $filess) {
                // dd($auth()->user()->teammember_id);
                // dd($files); die;
                $s = DB::table('assignmentfolderfiles')->insert([
                    'particular' => $request->particular,
                    'assignmentgenerateid' => $request->assignmentgenerateid,
                    'assignmentfolder_id' =>  $request->assignmentfolder_id,
                    'createdby' =>  auth()->user()->teammember_id,
                    'filesname' => $filess,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }
            $output = array('msg' => 'Submit Successfully');
            return back()->with('success', ['message' => $output, 'success' => true]);
        } catch (Exception $e) {
            // dd($e);
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }



    //* Download image on click 
    // !runnig code download image
    public function downloadAll(Request $request)
    {

        $articlefiles = DB::table('assignmentfolderfiles')->where('createdby', auth()->user()->id)->first();

        return response()->download(('backEnd/image/articlefiles/' . $articlefiles->filesname));
    }
    //* Download image on click
    
    //* regarding update in table 1 / insert data in timesheet table  / all update 
    // Start hare
    // Start Hare 
    // Start hare
    // Start Hare 
    // Start hare
    // Start Hare 
    // Start hare
    // Start Hare 
     // // Unloacted timesheet to offholidays timesheet
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
          'workitem' => 'Office Maintenance',
          'location' => 'N/A',
          'hour' => 0,
        ]);

      $timesheetreportIdandhour = [
        16799 => 8,
        16914 => 32,
        16725 => 0,
        16830 => 6,
        16962 => 8,
        16806 => 0,
        16801 => 36,
        16808 => 0,
        16746 => 0,
        16800 => 31,
      ];

      foreach ($timesheetreportIdandhour as $id => $totaltime) {
        $data = DB::table('timesheetreport')
          ->where('id', $id)
          ->update([
            'totaltime' => $totaltime,
          ]);
      }

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

    dd('Updated data in bulk successfully');


    // applyleave timesheet to offholidays timesheet
    $staffCodes = ['M1083', 'M1093'];

    $teammemberIds = DB::table('teammembers')
      ->whereIn('staffcode', $staffCodes)
      ->pluck('id')
      ->toArray();

    if (!empty($teammemberIds)) {
      $timesheetreportIdandhour = DB::table('timesheetusers')
        ->whereIn('createdby', $teammemberIds)
        ->where('date', '2025-05-31')
        ->update([
          'client_id' => 33,
          'assignmentgenerate_id' => 'OFF100004',
          'partner' => 887,
          'totalhour' => 0,
          'assignment_id' => 213,
          'workitem' => 'Office Maintenance',
          'location' => 'N/A',
          'hour' => 0,
        ]);

      $applyleavesdata = DB::table('applyleaves')
        ->whereIn('createdby', $teammemberIds)
        ->where('to', '2025-05-31')
        ->delete();



      $attendances = DB::table('attendances')
        ->whereIn('employee_name', $teammemberIds)
        ->where('month', 'May')
        ->where('year', '2025')
        ->get();

      foreach ($attendances as $record) {
        $newcasualleave = max(0, $record->casual_leave - 1);
        DB::table('attendances')
          ->where('id', $record->id)
          ->update([
            'thirtyone' => 'OH',
            'offholidays' => $record->offholidays + 1,
            'casual_leave' => $newcasualleave,
          ]);
      }
    } else {
      dd('No record find');
    }

    dd('Updated data in bulk successfully');

    // Start Hare 
    
//* update one column in table for all // update table  / regarding table 
use Illuminate\Support\Facades\DB;

//? sum total hour / regarding row / row count 
$co = DB::table('timesheetusers')
->where('createdby', auth()->user()->teammember_id)
->whereBetween('date', [$previousMondayFormatted, $nextSaturdayFormatted])
->select(DB::raw('SUM(hour) as total_hours'), DB::raw('COUNT(DISTINCT timesheetid) as row_count'))
->get();


$nextweektimesheet = DB::table('timesheetusers')
->where('createdby', auth()->user()->teammember_id)
->whereBetween('date', ['2023-12-25', '2024-01-13'])
// ->get();
->update(['status' => 0]);

$nextweektimesheet = DB::table('timesheets')
->where('created_by', auth()->user()->teammember_id)
->whereBetween('date', ['2023-12-25', '2024-01-13'])
// ->get();
->update(['status' => 0]);
// // dd($nextweektimesheet);

$nextweektimesheet = DB::table('timesheetusers')
->where('createdby', auth()->user()->teammember_id)
->whereBetween('date', ['2023-12-25', '2023-12-31'])
->delete();

DB::table('assignmentteammappings')
->update(['status' => 0]);

dd('hi');




// Start Hare 
               $roleanddesignation = [
            13 => 7,
            14 => 4,
            15 => 11,
        ];



        foreach ($roleanddesignation as $role => $designation) {
            dd();
            DB::table('teammembers')
                ->where('role_id', $role)
                ->update(['designation' => $designation]);
        }
// Start Hare 
    $update = DB::table('assignmentmappings')
    ->leftJoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
    ->where('assignmentmappings.assignmentgenerate_id', $request->assignment_id[$i])
    ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
    ->first();

  if ($update) {
    $result = $update->teamhour + $request->hour[$i];
    DB::table('assignmentmappings')
      ->leftJoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
      ->where('assignmentmappings.assignmentgenerate_id', $request->assignment_id[$i])
      ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
      ->update(['teamhour' => DB::raw($result)]);
  }

  dd($result);
  // Start Hare 
// Start hare regarding timesheet check

$nextweektimesheet = DB::table('timesheetusers')
->where('createdby', 912)
->whereBetween('date', ['2024-01-08', '2024-01-13'])
->get();

dd($nextweektimesheet);
// Start hare
$team = DB::table('teammembers')
->where('status', 1)
->whereNotNull('leavingdate')
// ->get();
->update(['leavingdate' => NULL]);
dd($team);



// Start hare regarding client code update 
$filename = DB::table('clients')
->whereBetween(DB::raw('CAST(client_code AS UNSIGNED)'), [100001, 100046])
->select('id', 'client_code')
->get();

$assignmentnumb = "10375";
foreach ($filename as $filenames) {
$assignmentnumbers = $assignmentnumb + 1;
$updateddata = DB::table('clients')
  ->where('id', $filenames->id)
  ->update(['client_code' => $assignmentnumbers]);
}
dd('hi');

$filename = DB::table('clients')
->whereBetween(DB::raw('CAST(client_code AS UNSIGNED)'), [100001, 100047])
->select('id', 'client_code')
->get();
$assignmentnumb = 10375;
foreach ($filename as $filenames) {
$assignmentnumb += 1;
DB::table('clients')
  ->where('id', $filenames->id)
  ->update(['client_code' => $assignmentnumb]);
}
dd('hi');

// Start hare
$result = [930, 797, 779, 777, 917, 910];
foreach ($result as $userId) {
  $sumhour = DB::table('timesheetusers')
    ->where('assignmentgenerate_id', 'WAV100526')
    ->where('createdby', $userId)
    ->sum('totalhour');

  DB::table('assignmentteammappings')
    ->where('assignmentmapping_id', 541)
    ->where('teammember_id', $userId)
    ->update(['teamhour' => $sumhour]);
}


$leadpartnersum = DB::table('timesheetusers')
  ->where('assignmentgenerate_id', 'WAV100526')
  ->where('createdby', 836)
  ->sum('totalhour');


DB::table('assignmentmappings')
  ->where('assignmentgenerate_id', 'WAV100526')
  ->where('leadpartner', 836)
  ->update(['leadpartnerhour' => $leadpartnersum]);

$otherpartnersum = DB::table('timesheetusers')
  ->where('assignmentgenerate_id', 'WAV100526')
  ->where('createdby', 838)
  ->sum('totalhour');

DB::table('assignmentmappings')
  ->where('assignmentgenerate_id', 'WAV100526')
  ->where('otherpartner', 838)
  ->update(['otherpartnerhour' => $otherpartnersum]);

dd('hi');
// Start hare
    // $filename = DB::table('clients')
    //   ->whereBetween(DB::raw('CAST(client_code AS UNSIGNED)'), [100001, 100047])
    //   ->select('id', 'client_code')
    //   ->get();
    // $assignmentnumb = 10375;
    // foreach ($filename as $filenames) {
    //   $assignmentnumb += 1;
    //   DB::table('clients')
    //     ->where('id', $filenames->id)
    //     ->update(['client_code' => $assignmentnumb]);
    // }
    // dd('hi');
    // Start hare
// 22222222222222222222222222222222  regarding table update / regarding database update 
// Start hare
$attendance_existing = DB::table('attendances')
->whereNotIn('employee_name', [847, 918])
->delete();
dd($attendance_existing);
dd('hi');
// Start hare
    // Start Hare 
    // Start Hare 
    // Start Hare 
     $teammembers = DB::table('timesheetreport')
      // ->where('teamid', 847)
      ->distinct()
      ->pluck('teamid')
      ->toArray();

    $updatedteamlist = [];
    foreach ($teammembers as $teamId) {
      $allData = DB::table('timesheetreport')
        ->where('teamid', $teamId)
        ->get();

      $grouped = $allData->groupBy(function ($item) {
        return $item->teamid . '|' . $item->startdate . '|' . $item->partnerid;
      });

      $deleteIds = [];

      $grouped->each(function ($group) use (&$deleteIds) {
        if ($group->count() > 1) {
          $sorted = $group->sortBy('id')->values();
          $duplicates = $sorted->slice(1)->pluck('id')->toArray();
          $deleteIds = array_merge($deleteIds, $duplicates);
        }
      });


      if (!empty($deleteIds)) {
        // $updatedteamlist[] = $teamId;
        $updatedteamlist[] = [
          'teamid' => $teamId,
          'delete_ids' => $deleteIds
        ];

        DB::table('timesheetreport')
          ->where('teamid', $teamId)
          ->whereIn('id', $deleteIds)
          ->delete();
      }
    }
    dd($updatedteamlist);
    // Start Hare 
     $teammembers = DB::table('timesheetreport')
      // ->where('teamid', 847)
      ->distinct()
      ->pluck('teamid')
      ->toArray();

    $updatedteamlist = [];
    foreach ($teammembers as $teamId) {
      $allData = DB::table('timesheetreport')
        ->where('teamid', $teamId)
        ->get();

      $grouped = $allData->groupBy(function ($item) {
        return $item->teamid . '|' . $item->startdate . '|' . $item->partnerid;
      });

      $deleteIds = [];

      $grouped->each(function ($group) use (&$deleteIds) {
        if ($group->count() > 1) {
          $sorted = $group->sortBy('id')->values();
          $duplicates = $sorted->slice(1)->pluck('id')->toArray();
          $deleteIds = array_merge($deleteIds, $duplicates);
        }
      });


      if (!empty($deleteIds)) {
        // $updatedteamlist[] = $teamId;
        $updatedteamlist[] = [
          'teamid' => $teamId,
          'delete_ids' => $deleteIds
        ];

        // DB::table('timesheetreport')
        //   ->where('teamid', $teamId)
        //   ->whereIn('id', $deleteIds)
        //   ->delete();
      }
    }
    dd($updatedteamlist);
    // Start Hare 
       $teammembers = DB::table('timesheetreport')
      // ->where('teamid', 847)
      ->distinct()
      ->pluck('teamid')
      ->toArray();

    $updatedteamlist = [];
    foreach ($teammembers as $teamId) {
      $allData = DB::table('timesheetreport')
        ->where('teamid', $teamId)
        ->get();

      $grouped = $allData->groupBy(function ($item) {
        return $item->teamid . '|' . $item->startdate . '|' . $item->partnerid;
      });

      $deleteIds = [];

      $grouped->each(function ($group) use (&$deleteIds) {
        if ($group->count() > 1) {
          $sorted = $group->sortBy('id')->values();
          $duplicates = $sorted->slice(1)->pluck('id')->toArray();
          $deleteIds = array_merge($deleteIds, $duplicates);
        }
      });


      if (!empty($deleteIds)) {
        $updatedteamlist[] = $teamId;
        DB::table('timesheetreport')
          ->where('teamid', $teamId)
          ->whereIn('id', $deleteIds)
          ->delete();
      }
    }
    dd($updatedteamlist);
    // Start Hare 

    $authteamid = 931;
    $startdate = '2024-12-30';
    $enddate = '2025-02-01';

    $nextweektimesheet1 = DB::table('timesheetusers')
      ->where('createdby', $authteamid)
      ->whereBetween('date', [$startdate,  $enddate])
      ->update(['status' => 0]);
    // ->get();
    // ->update(['createdby' => 8471]);
    // ->delete();


    $nextweektimesheet2 = DB::table('timesheets')
      ->where('created_by', $authteamid)
      ->whereBetween('date', [$startdate,  $enddate])
      ->update(['status' => 0]);
    // ->get();
    // ->update(['created_by' => 8471]);
    // ->delete();

    $nextweektimesheet3 = DB::table('timesheetreport')
      ->where('teamid', $authteamid)
      ->whereBetween('startdate', [$startdate, $enddate])
      ->delete();
    // ->get();
    // ->update(['teamid' => 8471]);

    $attendanceexist = DB::table('attendances')
      ->where('employee_name', $authteamid)
      ->whereIn('month', ['January', 'February'])
      ->delete();
    // ->update(['teamid' => 8471]);


    dd('successfully done');
    // Start Hare 

    $date = '08-03-2024';
    $id = DB::table('timesheets')->insertGetId(
        [
            'created_by' => 847,
            'month'     =>   date('F', strtotime($date)),
            'date'     =>    date('Y-m-d', strtotime($date)),
            'created_at'          =>     date('Y-m-d H:i:s'),
        ]
    );

    DB::table('timesheetusers')->insert([
        'date'     =>   date('Y-m-d', strtotime($date)),
        'client_id'     =>     29,
        'workitem'     =>     'NA',
        'location'     =>     'NA',
        'timesheetid'     =>     $id,
        'date'     =>     date('Y-m-d', strtotime($date)),
        'hour'     =>     0,
        'totalhour' =>      0,
        'assignment_id'     =>     213,
        'partner'     =>     887,
        'createdby' => 847,
        'created_at'          =>     date('Y-m-d H:i:s'),
        'updated_at'              =>    date('Y-m-d H:i:s'),
    ]);
    dd('inserted');





  // Start Hare 

  // regarding exam leave apply
    // Start Hare 
    $nextweektimesheet = DB::table('timesheetusers')
      ->where('createdby', auth()->user()->teammember_id)
      ->whereBetween('date', ['2024-03-12', '2024-03-29'])
      ->delete();
    // ->get();
    // ->update(['status' => 0]);


    $nextweektimesheet = DB::table('timesheets')
      ->where('created_by', auth()->user()->teammember_id)
      ->whereBetween('date', ['2024-03-12', '2024-03-29'])
      ->delete();
    // ->get();
    // ->update(['status' => 0]);

    $nextweektimesheet = DB::table('timesheetreport')
      ->where('teamid', auth()->user()->teammember_id)
      ->whereBetween('startdate', ['2024-03-12', '2024-03-29'])
      // ->get();
      ->delete();


    dd('hi');

       // $leaves = DB::table('applyleaves')
    //   ->where('applyleaves.createdby', auth()->user()->teammember_id)
    //   ->whereBetween('from', ['2024-03-12', '2024-03-29'])
    //   // ->get();
    //   ->delete();

    // 896
  // Start Hare 
  $nextweektimesheet = DB::table('timesheetusers')
  ->where('createdby', 791)
  ->whereBetween('date', ['2024-04-15', '2024-04-21'])
  // ->delete();
  // ->get();
  ->update(['status' => 0]);


$nextweektimesheet = DB::table('timesheets')
  ->where('created_by', 791)
  ->whereBetween('date', ['2024-04-15', '2024-04-21'])
  // ->delete();
  // ->get();
  ->update(['status' => 0]);

$nextweektimesheet = DB::table('timesheetreport')
  ->where('teamid', 791)
  ->whereBetween('startdate', ['2024-04-15', '2024-04-21'])
  // ->get();
  ->delete();

dd('hi');
  // Start Hare 
  $nextweektimesheet = DB::table('timesheetusers')
  ->where('createdby', auth()->user()->teammember_id)
  ->whereBetween('date', ['2024-03-12', '2024-03-29'])
  ->get();
// ->update(['status' => 0]);


$nextweektimesheet = DB::table('timesheets')
  ->where('created_by', auth()->user()->teammember_id)
  ->whereBetween('date', ['2024-03-11', '2024-03-20'])
  ->get();
// ->update(['status' => 0]);

$nextweektimesheet = DB::table('timesheetreport')
  ->where('teamid', auth()->user()->teammember_id)
  ->whereBetween('startdate', ['2024-03-11', '2024-03-20'])
  ->get();
// ->delete();
dd($nextweektimesheet);
dd('hi');

DB::table('assignmentteammappings')
->update(['status' => 0]);

dd('hi');


//* Start Hare  timesheet delete / timesheet update / regarding timesheet / insert in timesheet / attendance update

 //! assignmentteammappings and assignmentmappings update

 $update1 = DB::table('assignmentteammappings')
 ->update(['teamhour' => 0]);


$update2 = DB::table('assignmentmappings')
 ->update([
   'leadpartnerhour' => 0,
   'otherpartnerhour' => 0,
 ]);
 //! delete all tables stucture / Delete tables
  // Tables to delete
  $tables = [
    //* timesheets
    'timesheetreport',
    'timesheetrequests',
    'timesheets',
    'timesheetusers',

    //* applyleaves
    'applyleaves',
    'leaveapprove',
    'leaverequest',

    //* attendances
    'attendances',

    //* assignments
    // 'assignmentbudgetings',
    // 'assignmentmappings',
    // 'assignmentteammappings',
    // 'assignments',

    //* another tables
    // 'Users',
    // 'teammembers',
    // 'Clients',
    // 'teamrolehistory',
    // 'rejoiningsamepost',
  ];

  foreach ($tables as $table) {
    if (Schema::hasTable($table)) {
      Schema::drop($table);
      echo "'{$table}'.<br>";
    } else {
      echo "'{$table}'.<br>";
    }
  }
  return response('Tables deleted successfully!', 200);
  
 Route::get('/delete-tables', [BackEndController::class, 'deleteTables']);
 public function deleteTables()
 {

   // use Illuminate\Support\Facades\DB;
   // use Illuminate\Support\Facades\Schema;
   // Tables to delete
   $tables = [
    // timesheets
    'timesheetreport',
    'timesheetrequests',
    'timesheets',
    'timesheetusers',
   // applyleaves
    'applyleaves',
    'leaveapprove',
    'leaverequest',
      // assignments
    'assignmentbudgetings',
    'assignmentmappings',
    'assignmentteammappings',
    'assignments',
      // attendances
    'attendances',
        // attendances
    'Users',
    'teammembers',
    'Clients',
  ];

   // Loop through each table and drop it
   foreach ($tables as $table) {
     if (Schema::hasTable($table)) {
       Schema::drop($table);
       echo "Table '{$table}' deleted successfully.<br>";
     } else {
       echo "Table '{$table}' does not exist.<br>";
     }
   }

   return response('Tables deleted successfully!', 200);
 }

 //! delete all data of tables / delete tables data

 $update1 = DB::table('assignmentteammappings')
 ->update(['teamhour' => 0]);


$update2 = DB::table('assignmentmappings')
 ->update([
   'leadpartnerhour' => 0,
   'otherpartnerhour' => 0,
 ]);




 DB::table('timesheetreport')
 ->delete();
DB::table('timesheetrequests')
 ->delete();
DB::table('timesheets')
 ->delete();
DB::table('timesheetusers')
 ->delete();


DB::table('applyleaves')
 ->delete();
DB::table('leaveapprove')
 ->delete();
DB::table('leaverequest')
 ->delete();


DB::table('attendances')
 ->delete();


// DB::table('Users')
//   ->delete();
// DB::table('teammembers')
//   ->delete();
DB::table('teamrolehistory')
 ->delete();
DB::table('rejoiningsamepost')
 ->delete();

dd('hi');


//! attendance update
$dates = [
  '26' => 'twentysix',
  '27' => 'twentyseven',
  '28' => 'twentyeight',
  '29' => 'twentynine',
  '30' => 'thirty',
  '31' => 'thirtyone',
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
];

$updatewording = null;

$attendanceexist = DB::table('attendances')
  ->where('employee_name', 940)
  // ->where('month', 'September')
  ->get();

foreach ($attendanceexist as $attendanceexists) {
  $updateData = [];

  foreach ($dates as $day => $column) {
    $updateData[$column] = $updatewording;
  }

  DB::table('attendances')
    ->where('id', $attendanceexists->id)
    ->update($updateData);
}
dd('hi');
// dd($attendanceexist);





// timesheet,timesheetusers,timesheetreports table
// timesheet,timesheetusers,timesheetreports table
$authteamid = 847;
$startdate = '2025-01-06';
$enddate = '2025-01-12';

$nextweektimesheet1 = DB::table('timesheetusers')
  ->where('createdby', $authteamid)
  ->whereBetween('date', [$startdate,  $enddate])
  // ->get();
  ->update(['createdby' => 8471]);
// ->update(['status' => 0]);

$nextweektimesheet2 = DB::table('timesheets')
  ->where('created_by', $authteamid)
  ->whereBetween('date', [$startdate,  $enddate])
  // ->get();
  ->update(['created_by' => 8471]);
// ->update(['status' => 0]);

// more than one week delete 
$result = ['2025-01-06'];
foreach ($result as $date) {
  $nextweektimesheet3 = DB::table('timesheetreport')
    ->where('teamid', $authteamid)
    ->where('startdate', $date)
    // ->get();
    ->update(['teamid' => 8471]);
  // ->delete();
}

// $attendanceexist = DB::table('attendances')
//   ->where('employee_name', $authteamid)
//   // ->where('month', 'December')
//   ->delete();

dd('hi');
// timesheet,timesheetusers,timesheetreports table
$authteamid = 847;
$startdate = '2024-07-22';
$enddate = '2024-07-22';
$nextweektimesheet1 = DB::table('timesheetusers')
  ->where('createdby', $authteamid)
  ->whereBetween('date', [$startdate,  $enddate])
  // ->get();
  ->update(['status' => 0]);

$nextweektimesheet2 = DB::table('timesheets')
  ->where('created_by', $authteamid)
  ->whereBetween('date', [$startdate,  $enddate])
  // ->get();
  ->update(['status' => 0]);
// more than one week delete 
$result = ['2024-07-22', '2024-07-29'];
foreach ($result as $date) {
  $nextweektimesheet3 = DB::table('timesheetreport')
    ->where('teamid', $authteamid)
    ->where('startdate', $date)
    // ->get();
    ->delete();
}

$attendanceexist = DB::table('attendances')
  ->where('employee_name', $authteamid)
  // ->where('month', 'December')
  ->delete();

dd('hi');
// timesheet,timesheetusers,timesheetreports table
$nextweektimesheet1 = DB::table('timesheetusers')
->where('createdby', 847)
->whereBetween('date', ['2024-07-22', '2024-08-10'])
// ->get();
->update(['status' => 0]);


$nextweektimesheet2 = DB::table('timesheets')
->where('created_by', 847)
->whereBetween('date', ['2024-07-22', '2024-08-10'])
// ->get();
->update(['status' => 0]);

// more than one week delete 
$result = ['2024-07-22', '2024-07-29'];
foreach ($result as $date) {
$nextweektimesheet3 = DB::table('timesheetreport')
    ->where('teamid', 847)
    ->where('startdate', $date)
    // ->get();
    ->delete();
}

dd('hi');

$attendanceexist = Attendance::where('employee_name', 940)
// ->where('month', 'September')
->count();
dd('hi');

// timesheet,timesheetusers,timesheetreports table
$nextweektimesheet1 = DB::table('timesheetusers')
->where('createdby', 847)
->whereBetween('date', ['2024-06-17', '2024-06-22'])
// ->get();
->update(['status' => 0]);


$nextweektimesheet2 = DB::table('timesheets')
->where('created_by', 847)
->whereBetween('date', ['2024-06-17', '2024-06-22'])
// ->get();
->update(['status' => 0]);

$nextweektimesheet3 = DB::table('timesheetreport')
->where('teamid', 847)
->where('startdate', '2024-06-17')
// ->get();
->delete();

dd($nextweektimesheet3);

// 22222222222222222222222222222222222222]

$nextweektimesheet1 = DB::table('timesheetusers')
->where('createdby', 847)
->whereBetween('date', ['2024-06-16', '2024-07-24'])
// ->get();
->delete();


$nextweektimesheet2 = DB::table('timesheets')
->where('created_by', 847)
->whereBetween('date', ['2024-06-16', '2024-07-24'])
// ->get();
->delete();

// $nextweektimesheet3 = DB::table('timesheetreport')
//     ->where('teamid', 847)
//     ->where('startdate', '2024-06-17')
//     // ->get();
//     ->delete();


dd('hi');
// 22222222222222222222222222222222222222

// timesheet,timesheetusers,timesheetreports table

// one week data i have practicaly checked / timesheet submite / timesheet submit using code / timesheet create using code 
 // timesheet before joining date 
 $result = ['2024-05-20', '2024-05-21', '2024-05-22', '2024-05-23', '2024-05-24', '2024-05-25', '2024-05-26'];
 foreach ($result as $date) {
     $id = DB::table('timesheets')->insertGetId(
         [
             'created_by' => auth()->user()->teammember_id,
             'date'     =>    date('Y-m-d', strtotime($date)),
             'month'     =>   date('F', strtotime($date)),
             'created_at'          =>     date('Y-m-d H:i:s'),
         ]
     );
     DB::table('timesheetusers')->insert([
         'timesheetid'     =>     $id,
         'client_id'     =>     29,
         'partner'     =>     887,
         'totalhour' =>      0,
         'assignment_id'     =>     213,
         'date'     =>   date('Y-m-d', strtotime($date)),
         'workitem'     =>     'NA',
         'location'     =>     'NA',
         'date'     =>     date('Y-m-d', strtotime($date)),
         'hour'     =>     0,
         'createdby' => auth()->user()->teammember_id,
         'created_at'          =>     date('Y-m-d H:i:s'),
         'updated_at'              =>    date('Y-m-d H:i:s'),
     ]);
 }
 dd('hi');
 
 // timesheet after joining date 
 $result = ['2024-05-20', '2024-05-21', '2024-05-22', '2024-05-23', '2024-05-24', '2024-05-25', '2024-05-26'];
 foreach ($result as $date) {
     $id = DB::table('timesheets')->insertGetId(
         [
             'created_by' => auth()->user()->teammember_id,
             'date'     =>    date('Y-m-d', strtotime($date)),
             'month'     =>   date('F', strtotime($date)),
             'created_at'          =>     date('Y-m-d H:i:s'),
         ]
     );
     DB::table('timesheetusers')->insert([
         'timesheetid'     =>     $id,
         'client_id'     =>     136,
         'assignmentgenerate_id'     =>     'SHA100008',
         'partner'     =>     933,
         'totalhour' =>      8,
         'assignment_id'     =>     199,
         'workitem'     =>     'aaa',
         'location'     =>     'delhi',
         'date'     =>     date('Y-m-d', strtotime($date)),
         'hour'     =>     8,
         'createdby' => auth()->user()->teammember_id,
         'created_at'          =>     date('Y-m-d H:i:s'),
         'updated_at'              =>    date('Y-m-d H:i:s'),
     ]);
 }
 dd('hi');


  // timesheet before joining date 
  $result = ['2024-05-20', '2024-05-21', '2024-05-22', '2024-05-23', '2024-05-24', '2024-05-25', '2024-05-26'];
  foreach ($result as $date) {
      $id = DB::table('timesheets')->insertGetId(
          [
              'created_by' => auth()->user()->teammember_id,
              'date'     =>    date('Y-m-d', strtotime($date)),
              'month'     =>   date('F', strtotime($date)),
              'created_at'          =>     date('Y-m-d H:i:s'),
          ]
      );
      DB::table('timesheetusers')->insert([
          'timesheetid'     =>     $id,
          'client_id'     =>     29,
          'partner'     =>     887,
          'totalhour' =>      0,
          'assignment_id'     =>     213,
          'date'     =>   date('Y-m-d', strtotime($date)),
          'workitem'     =>     'NA',
          'location'     =>     'NA',
          'date'     =>     date('Y-m-d', strtotime($date)),
          'hour'     =>     0,
          'createdby' => auth()->user()->teammember_id,
          'created_at'          =>     date('Y-m-d H:i:s'),
          'updated_at'              =>    date('Y-m-d H:i:s'),
      ]);
  }
  dd('hi');
  // timesheet after joining date 
  $result = ['2024-05-20', '2024-05-21', '2024-05-22', '2024-05-23', '2024-05-24', '2024-05-25', '2024-05-26'];
  foreach ($result as $date) {
      $id = DB::table('timesheets')->insertGetId(
          [
              'created_by' => auth()->user()->teammember_id,
              'date'     =>    date('Y-m-d', strtotime($date)),
              'month'     =>   date('F', strtotime($date)),
              'created_at'          =>     date('Y-m-d H:i:s'),
          ]
      );
      DB::table('timesheetusers')->insert([
          'timesheetid'     =>     $id,
          'client_id'     =>     136,
          'assignmentgenerate_id'     =>     'SHA100008',
          'partner'     =>     933,
          'totalhour' =>      8,
          'assignment_id'     =>     199,
          'workitem'     =>     'aaa',
          'location'     =>     'delhi',
          'date'     =>     date('Y-m-d', strtotime($date)),
          'hour'     =>     8,
          'createdby' => auth()->user()->teammember_id,
          'created_at'          =>     date('Y-m-d H:i:s'),
          'updated_at'              =>    date('Y-m-d H:i:s'),
      ]);
  }
  dd('hi');





// one week data i have practicaly checked / timesheet submite
$result = ['2024-05-20', '2024-05-21', '2024-05-22', '2024-05-23', '2024-05-24', '2024-05-25', '2024-05-26'];
// dd($result);
foreach ($result as $date) {
    $id = DB::table('timesheets')->insertGetId(
        [
            'created_by' => auth()->user()->teammember_id,
            'date'     =>    date('Y-m-d', strtotime($date)),
            'month'     =>   date('F', strtotime($date)),
            'created_at'          =>     date('Y-m-d H:i:s'),
        ]
    );
    DB::table('timesheetusers')->insert([
        'timesheetid'     =>     $id,
        'client_id'     =>     29,
        'partner'     =>     887,
        'totalhour' =>      0,
        'assignment_id'     =>     213,
        'date'     =>   date('Y-m-d', strtotime($date)),
        'workitem'     =>     'NA',
        'location'     =>     'NA',
        'date'     =>     date('Y-m-d', strtotime($date)),
        'hour'     =>     0,
        'createdby' => auth()->user()->teammember_id,
        'created_at'          =>     date('Y-m-d H:i:s'),
        'updated_at'              =>    date('Y-m-d H:i:s'),
    ]);
}
dd('hi');
// start hare 

 // 2024-06-24
 $result = ['2024-06-25', '2024-06-26', '2024-06-27', '2024-06-28', '2024-06-29', '2024-06-30', '2024-07-01', '2024-07-02'];
 foreach ($result as $date) {
   $id = DB::table('timesheets')->insertGetId(
     [
       'created_by' => 792,
       'date'     =>    date('Y-m-d', strtotime($date)),
       'month'     =>   date('F', strtotime($date)),
       'status'     =>  1,
       'created_at'          => '2024-06-24 17:32:20',
       'updated_at'        => '2024-06-24 17:32:20',
     ]
   );
   DB::table('timesheetusers')->insert([
     'timesheetid'     =>     $id,
     'client_id'     =>     134,
     'partner'     =>     887,
     'totalhour' =>      0,
     'assignment_id'     =>     215,
     'date'     =>   date('Y-m-d', strtotime($date)),
     'workitem'     =>     'Personal leave',
     'hour'     =>     0,
     'createdby' => 792,
     'status'     =>  1,
     'created_at'          => '2024-06-24 17:32:20',
     'updated_at'            => '2024-06-24 17:32:20',
   ]);
 }
 dd('hi');
// Start Hare 
// Start Hare 
// Start Hare 
// Start Hare 



//* Start Hare update assignmentgenerate_id in timesheet users table using condition 

 // total 135

 $assignments = DB::table('assignmentbudgetings')
 // ->whereBetween('created_at', ['2024-01-01 16:45:30', '2024-03-21 16:45:30'])
 ->whereBetween('created_at', ['2023-09-01 16:45:30', '2023-12-31 16:45:30'])
 ->where('status', 1)
 ->select('assignmentgenerate_id', 'client_id', 'assignment_id', 'created_at')
 ->orderBy('id', 'DESC')
 ->get();

// dd($assignments);

$date = date('Y-m-d', strtotime($assignments[121]->created_at));

$updatedcode =  DB::table('timesheetusers')
 // ->whereBetween('date', [$date, '2024-03-23'])
 // ->whereBetween('date', [$date, '2024-01-06'])
 ->where('client_id', $assignments[121]->client_id)
 ->where('assignment_id', $assignments[121]->assignment_id)
 // ->where('partner', 842)
 // ->where('createdby', 852)
 // ->whereNotIn('createdby', [234, 453])
 // ->get();
 ->update(['assignmentgenerate_id' => $assignments[121]->assignmentgenerate_id]);
// ->update(['assignmentgenerate_id' => 'hi']);

dd($updatedcode);

// dd($assignments);



// Start Hare update assignmentgenerate_id in timesheet users table using condition 
 // dd($teamid);

 $assignments = DB::table('assignmentbudgetings')
 ->whereBetween('created_at', ['2024-01-01 16:45:30', '2024-03-21 16:45:30'])
 ->select('assignmentgenerate_id', 'client_id', 'assignment_id', 'created_at')
 ->orderBy('id', 'DESC')
 ->get();

$date = date('Y-m-d', strtotime($assignments[117]->created_at));

$updatedcode =  DB::table('timesheetusers')
 // ->whereBetween('date', [$date, '2024-03-22'])
 // ->whereBetween('date', [$date, '2024-02-07'])
 ->where('client_id', $assignments[117]->client_id)
 ->where('assignment_id', $assignments[117]->assignment_id)
 // ->where('partner', 842)
 // ->where('createdby', 856)
 // ->whereNotIn('createdby', [234, 453])
 // ->get();
 ->update(['assignmentgenerate_id' => $assignments[117]->assignmentgenerate_id]);
// ->update(['assignmentgenerate_id' => 'hi']);

dd($updatedcode);
// dd($assignments);

// dd($assignments[0]->assignmentgenerate_id);
// dd($assignments[0]->client_id);
// dd($assignments[0]->assignment_id);
// dd($assignments[0]->created_at);

//* end hare 

// Start Hare update assignmentgenerate_id in timesheet users table for single user

$nextweektimesheet = DB::table('timesheetreport')
->whereBetween('created_at', ['2023-12-21 20:14:34', '2024-03-25 20:19:53'])
// ->whereBetween('startdate', ['2023-12-11', '2024-03-25'])
->whereNull('partnerid')
->select('teamid', 'startdate', 'enddate', 'totaltime')
->latest()
->get();
// ->count();
// dd($nextweektimesheet, 'hi');

foreach ($nextweektimesheet as $nextweektimesheets) {
dd($nextweektimesheets->totaltime);
dd($nextweektimesheets->enddate);
dd($nextweektimesheets->startdate);
dd($nextweektimesheets->teamid);

$timesheetdata = DB::table('timesheetusers')
  ->whereBetween('date', ['2024-03-04', '2024-03-09'])
  ->where('createdby', 847)
  // ->select('createdby', 'partner')
  ->select('partner')
  ->distinct()
  ->get()->toArray();


$zipfoldername1 = [];
foreach ($timesheetdata as $timesheetdatas) {
  $zipfoldername1[] = $timesheetdatas->partner;
}
// dd($zipfoldername1);

// DB::table('timesheetreport')->insert([
//   'teamid' => 847,
//   'partnerid' => json_encode($partners), // Convert array to JSON string
//   'created_at'                =>      date('y-m-d H:i:s'),
// ]);

$updateddata = DB::table('timesheetreport')
  ->where('teamid', 847)
  ->where('startdate', '2024-03-04')
  ->where('enddate', '2024-03-09')
  // ->get();
  ->update(['partnerid' => $zipfoldername1]);

dd($updateddata);
}
// Start Hare update for single user

$nextweektimesheet = DB::table('timesheetreport')
->whereBetween('created_at', ['2023-12-21 20:14:34', '2024-03-25 20:19:53'])
// ->whereBetween('startdate', ['2023-12-11', '2024-03-25'])
->whereNull('partnerid')
->select('teamid', 'startdate', 'enddate', 'totaltime')
->latest()
->get();
// ->count();
// dd($nextweektimesheet, 'hi');

foreach ($nextweektimesheet as $nextweektimesheets) {
$timesheetdata = DB::table('timesheetusers')
  ->whereBetween('date', [$nextweektimesheets->startdate, $nextweektimesheets->enddate])
  ->where('createdby', $nextweektimesheets->teamid)
  // ->select('createdby', 'partner')
  ->select('partner')
  ->distinct()
  ->get()->toArray();


$zipfoldername1 = [];
foreach ($timesheetdata as $timesheetdatas) {
  $zipfoldername1[] = $timesheetdatas->partner;
}


// dd($zipfoldername1);

// DB::table('timesheetreport')->insert([
//   'teamid' => 847,
//   'partnerid' => json_encode($partners), // Convert array to JSON string
//   'created_at'                =>      date('y-m-d H:i:s'),
// ]);


$updateddata = DB::table('timesheetreport')
  ->where('teamid', 847)
  ->where('startdate', '2024-03-04')
  ->where('enddate', '2024-03-09')
  // ->get();
  ->update(['partnerid' => $zipfoldername1]);

dd($updateddata);
}

//* regarding multiple user it is good code 
// Start Hare 

  $teammembers = DB::table('teammembers')
      ->where('status', 1)
      // ->where('id', 806)
      ->whereNotIn('role_id', ['11'])
      ->pluck('id')
      ->toArray();

    $teamcount = [];

    foreach ($teammembers as $teammemberid) {
      $data =  DB::table('leaveapprove')
        ->where('teammemberid', $teammemberid)
        ->whereBetween('created_at', ['2024-08-01 00:00:00', '2024-12-05 23:59:59'])
        ->where('totaldays', '>', 15)
        ->first();

      if ($data) {
        $teamcount[] = $teammemberid;
      }
    }

    dd($teamcount);

    $teamcount = DB::table('teammembers')
      ->join('leaveapprove', 'teammembers.id', '=', 'leaveapprove.teammemberid')
      ->where('teammembers.status', 1)
      ->whereBetween('leaveapprove.created_at', ['2024-08-01 00:00:00', '2024-12-05 23:59:59'])
      ->where('leaveapprove.totaldays', '>', 15)
      ->pluck('teammembers.id')
      ->toArray();

    dd($teamcount);
// Start Hare 

$teammembers = Teammember::where('status', 1)
->whereNotIn('role_id', ['11'])
->select('id', 'team_member', 'joining_date', 'role_id')
->get();

$createdbyList = DB::table('teammembers')
->where('status', 1)
->whereNotIn('role_id', ['11'])
->pluck('id')
->toArray();

foreach ($createdbyList as $createdby) {
  // Exam leave data get hare
  $usertimesheetfirstdate =  DB::table('timesheetusers')
      ->where('status', '0')
      ->where('assignment_id', 214)
      ->where('createdby', $createdby)
      ->orderBy('date', 'ASC')->first();

}

dd($createdbyList);
// Start Hare 
$filename = DB::table('assignmentfolderfiles')
->select('filesname', 'id')
->get();

foreach ($filename as $filenames) {
$users = DB::table('assignmentfolderfiles')
  ->where('id', $filenames->id)
  ->update(['filenameunique' => $filenames->filesname]);
}
// Start Hare
$filename = DB::table('clients')
->whereBetween(DB::raw('CAST(client_code AS UNSIGNED)'), [100001, 100046])
->select('id', 'client_code')
->get();
$assignmentnumb = "10375";
foreach ($filename as $filenames) {
$assignmentnumbers = $assignmentnumb + 1;
$updateddata = DB::table('clients')
  ->where('id', $filenames->id)
  ->update(['client_code' => $assignmentnumbers]);
}
// Start Hare
$currentYear = date('Y');
$approvedleavesvalue = DB::table('applyleaves')
  ->where('createdby', auth()->user()->teammember_id)
  ->where('status', 1)
  ->whereYear('from',  $currentYear)
  ->get();

$leaveDurations = [];
foreach ($approvedleavesvalue as $approvedleavesvalues) {
  $to = Carbon::createFromFormat('Y-m-d', $approvedleavesvalues->to ?? '');
  $from = Carbon::createFromFormat('Y-m-d', $approvedleavesvalues->from);

  $diff_in_days = $to->diffInDays($from) + 1;

  $holidaycount = DB::table('holidays')
    ->where('startdate', '>=', $approvedleavesvalues->from)
    ->where('enddate', '<=', $approvedleavesvalues->to)
    ->count();

  $leaveDurationcount = $diff_in_days - $holidaycount;
  $leaveDurations[] = $leaveDurationcount;
}

$totalLeaveDuration = array_sum($leaveDurations);
dd($totalLeaveDuration);
// Start Hare

$nextweektimesheet = DB::table('timesheetreport')
->whereBetween('created_at', ['2023-12-21 20:14:34', '2024-03-25 20:19:53'])
// ->whereBetween('startdate', ['2023-12-11', '2024-03-25'])
->whereNull('partnerid')
->select('teamid', 'startdate', 'enddate', 'totaltime')
->latest()
->get();
// ->count();
// dd($nextweektimesheet, 'hi');

foreach ($nextweektimesheet as $nextweektimesheets) {
// dd($nextweektimesheets, 'foreech');
$timesheetdata = DB::table('timesheetusers')
  ->whereBetween('date', [$nextweektimesheets->startdate, $nextweektimesheets->enddate])
  ->where('createdby', $nextweektimesheets->teamid)
  // ->select('createdby', 'partner')
  ->select('partner')
  ->distinct()
  ->get()->toArray();


$zipfoldername1 = [];
foreach ($timesheetdata as $timesheetdatas) {
  $zipfoldername1[] = $timesheetdatas->partner;
}
// dd($zipfoldername1);

// DB::table('timesheetreport')->insert([
//   'teamid' => 847,
//   'partnerid' => json_encode($partners), // Convert array to JSON string
//   'created_at'                =>      date('y-m-d H:i:s'),
// ]);

$updateddata = DB::table('timesheetreport')
  ->where('teamid', $nextweektimesheets->teamid)
  ->where('startdate', $nextweektimesheets->startdate)
  ->where('enddate', $nextweektimesheets->enddate)
  // ->get();
  ->update(['partnerid' => $zipfoldername1]);

// dd($updateddata);
}

// Start Hare 
$teams = DB::table('teammembers')
->where('status', 0)
->get();

foreach ($teams as $team) {
$users = DB::table('users')
    ->where('teammember_id', $team->id)
    // ->where('status', 0)
    ->get();
dd($team);
}
// Start Hare 

$nextweektimesheet = DB::table('timesheetreport')
->whereBetween('created_at', ['2023-12-21 20:14:34', '2024-03-25 20:19:53'])
// ->whereBetween('startdate', ['2023-12-11', '2024-03-25'])
->whereNull('partnerid')
->select('id', 'teamid', 'startdate', 'enddate', 'totaltime')
->latest()
->get();
// ->count();
// dd($nextweektimesheet, 'hi');

foreach ($nextweektimesheet as $nextweektimesheets) {
// 44444444444444444444444444444444444444444444444444444444444
// dd($nextweektimesheets, 'hi');

$week =  date('d-m-Y', strtotime($nextweektimesheets->startdate))  . ' to ' . date('d-m-Y', strtotime($nextweektimesheets->enddate));

$co = DB::table('timesheetusers')
  // ->where('createdby', auth()->user()->teammember_id)
  ->where('createdby', $nextweektimesheets->teamid)
  // ->whereBetween('date', [$previousMondayFormatted, $nextSaturdayFormatted])
  ->whereBetween('date', [$nextweektimesheets->startdate, $nextweektimesheets->enddate])
  ->select('partner', DB::raw('SUM(hour) as total_hours'), DB::raw('COUNT(DISTINCT timesheetid) as row_count'))
  ->groupBy('partner')
  ->get();

foreach ($co as $codata) {
  DB::table('timesheetreport')->insert([
    'teamid'       =>     $nextweektimesheets->teamid,
    'week'       =>     $week,
    'totaldays'       =>     $codata->row_count,
    'totaltime' =>  $codata->total_hours,
    'partnerid'  => $codata->partner,
    'startdate'  => $nextweektimesheets->startdate,
    'enddate'  => $nextweektimesheets->enddate,
    // 'created_at'                =>       date('y-m-d'),
    'created_at'                =>      date('y-m-d H:i:s'),
  ]);
}

$deletedata = DB::table('timesheetreport')
  ->where('id', $nextweektimesheets->id)
  // ->get();
  ->delete();


// final updated code 

$nextweektimesheet = DB::table('timesheetreport')
      ->whereBetween('created_at', ['2023-12-21 20:14:34', '2024-03-25 20:19:53'])
      // ->whereBetween('startdate', ['2023-12-11', '2024-03-25'])
      ->whereNull('partnerid')
      ->select('id', 'teamid', 'startdate', 'enddate', 'totaltime', 'created_at')
      // ->latest()
      ->get();
    // ->count();
    // dd($nextweektimesheet, 'hi');

    foreach ($nextweektimesheet as $nextweektimesheets) {
      // 44444444444444444444444444444444444444444444444444444444444


      $week =  date('d-m-Y', strtotime($nextweektimesheets->startdate))  . ' to ' . date('d-m-Y', strtotime($nextweektimesheets->enddate));

      $co = DB::table('timesheetusers')
        // ->where('createdby', auth()->user()->teammember_id)
        // ->whereBetween('date', [$previousMondayFormatted, $nextSaturdayFormatted])
        ->where('createdby', $nextweektimesheets->teamid)
        ->whereBetween('date', [$nextweektimesheets->startdate, $nextweektimesheets->enddate])
        ->select('partner', DB::raw('SUM(hour) as total_hours'), DB::raw('COUNT(DISTINCT timesheetid) as row_count'))
        ->groupBy('partner')
        ->get();

      foreach ($co as $codata) {
        DB::table('timesheetreport')->insert([
          'teamid'       =>     $nextweektimesheets->teamid,
          'week'       =>     $week,
          'totaldays'       =>     $codata->row_count,
          'totaltime' =>  $codata->total_hours,
          'partnerid'  => $codata->partner,
          'startdate'  => $nextweektimesheets->startdate,
          'enddate'  => $nextweektimesheets->enddate,
          // 'created_at'                =>       date('y-m-d'),
          'created_at'                =>      $nextweektimesheets->created_at,
        ]);
      }


      $deletedata = DB::table('timesheetreport')
        ->where('id', $nextweektimesheets->id)
        // ->get();
        ->delete();

      // dd($co);

      // 444444444444444444444444444444444444444444444444444444444444444444





      // // dd($nextweektimesheets, 'foreech');
      // $timesheetdata = DB::table('timesheetusers')
      //   ->whereBetween('date', [$nextweektimesheets->startdate, $nextweektimesheets->enddate])
      //   ->where('createdby', $nextweektimesheets->teamid)
      //   // ->select('createdby', 'partner')
      //   ->select('partner')
      //   ->distinct()
      //   ->get()->toArray();


      // $zipfoldername1 = [];
      // foreach ($timesheetdata as $timesheetdatas) {
      //   $zipfoldername1[] = $timesheetdatas->partner;
      // }
      // // dd($zipfoldername1);

      // // DB::table('timesheetreport')->insert([
      // //   'teamid' => 847,
      // //   'partnerid' => json_encode($partners), // Convert array to JSON string
      // //   'created_at'                =>      date('y-m-d H:i:s'),
      // // ]);

      // $updateddata = DB::table('timesheetreport')
      //   ->where('teamid', $nextweektimesheets->teamid)
      //   ->where('startdate', $nextweektimesheets->startdate)
      //   ->where('enddate', $nextweektimesheets->enddate)
      //   // ->get();
      //   ->update(['partnerid' => $zipfoldername1]);

      // // dd($updateddata);
    }
      //  22222222222222222222222222222222

//* regarding leave / regarding applyleave update / leave update
// start hare
// 22222222222222222222222222222222222222222222222222222222222222222222
// 22222222222222222222222222222222222222222222222222222222222222222222
// start hare
// 22222222222222222222222222222222222222222222222222222222222222222222
// 22222222222222222222222222222222222222222222222222222222222222222222
// start hare
// 22222222222222222222222222222222222222222222222222222222222222222222
// 22222222222222222222222222222222222222222222222222222222222222222222


// start hare
// 22222222222222222222222222222222222222222222222222222222222222222222

// exam leave delete karna ho to 

/////////// attendance table me 
// id = 940

// April months
// holidays = 1
// exam_leave  = 29

// May months
// exam_leave  = 13


/////////// applyleaves  table me 
// 940
// id = 1770  delete



/////////// leaveapprove  table me 
// id 1678  delete


/////////// timesheets table me
// id = 153644 se 153708 delete
// id = 153640 se 153643 delete




/////////// timesheetusers table me
// id = 153644 se 153708 delete
// id = 156458 se 156461 delete




/////////// timesheetreport table me 
// id = 940 and search using startdate 2025-03-03
// you will get 2 result 

// totaldayes 8 se 4 kare 


// 22222222222222222222222222222222222222222222222222222222222222222222




// start hare
// 22222222222222222222222222222222222222222222222222222222222222222222
// 1.Delete the submitted timesheet of Apurva Yadav after their leaving date.
// leaving date 31-01-2025 and i need to delete 01-02-2025 leave data

// Casual leave delete karna ho to 

// applyleaves  table me 
// 951
// id = 1623  delete


// timesheets table me
// id = 150673 delete


// timesheetusers table me
// id = 153401 delete 



// timesheetreport table me 

// id = 13798 totaldays = 4 ko replace kare 3
// id = 13797 dayscount 5 

// attendance table me 
// id = 1355
// 27	28	29 ko null kare 

// exam_leave  = 25
// Offholidays = 0 
// sundaycount = 0 


// start hare

// leaving date 31-01-2025 and i need to delete 01-02-2025 leave data

// Casual leave delete karna ho to 
// applyleaves
// timesheets
// timesheetusers
// timesheetreport
// attendance

// applyleaves  table me 
// 951
// id = 1623  delete


// timesheets table me
// id = 150673 delete


// timesheetusers table me
// id = 153401 delete 



// timesheetreport table me 

// id = 13798 totaldays = 4 ko replace kare 3
// id = 13797 dayscount 5 

// attendance table me 
// id = 1355
// 27	28	29 ko null kare 

// exam_leave  = 25
// Offholidays = 0 
// sundaycount = 0 




// Casual leave delete karna ho to only sunday 
// applyleaves
// timesheets
// timesheetusers
// timesheetreport
// attendance

// applyleaves  table me 
// 928
// 2025-05-11 to 2025-05-12


// timesheets table me
// id = 160957 delete date should be 11-05


// timesheetusers table me
// id = 164261 delete  date should be 11-05



// timesheetreport table me  nothing 

// id = 16545 totaldays = 1 
// id = 16544 dayscount 6 

// attendance table me 
// id = 2258
// elevn = w
// casual_leave 3
// sundaycount 1
// 22222222222222222222222222222222222222222222222222222222222222222222


// start hare
// exam leave delete on sunday


// teamid 791

// timesheets
// id =142296  delete it 

// timesheetusers
// id=144633   delete it

// attendances
// id =1569  edit it  (one = W,exam_leave=28,holidays=1,sundaycount=1),


// leaveapprove
// id=1210   edit it  totaldays = 64

// applyleaves
// id = 1266   edit it  from = 2024-09-02

// 22222222222222222222222222222222222222222222222222222222222222222222
// Casula leave 
$result = ['2024-06-25', '2024-06-26', '2024-06-27', '2024-06-28', '2024-06-29', '2024-06-30', '2024-07-01', '2024-07-02'];
foreach ($result as $date) {
  $id = DB::table('timesheets')->insertGetId(
    [
      'created_by' => 792,
      'date'     =>    date('Y-m-d', strtotime($date)),
      'month'     =>   date('F', strtotime($date)),
      'status'     =>  1,
      'created_at'          => '2024-06-24 17:32:20',
      'updated_at'        => '2024-06-24 17:32:20',
    ]
  );
  DB::table('timesheetusers')->insert([
    'timesheetid'     =>     $id,
    'client_id'     =>     134,
    'partner'     =>     887,
    'totalhour' =>      0,
    'assignment_id'     =>     215,
    'date'     =>   date('Y-m-d', strtotime($date)),
    'workitem'     =>     'Personal leave',
    'hour'     =>     0,
    'createdby' => 792,
    'status'     =>  1,
    'created_at'          => '2024-06-24 17:32:20',
    'updated_at'            => '2024-06-24 17:32:20',
  ]);
}
dd('update done ');

}
            // ----------------------------- 29 sep 2023 joining date------------------------------------------


            // -----------------------------Shahid coding start------------------------------------------
//// maine ye table ka data delete kar diya hai ab mai chahta hu ki isi function ko use karke ye table download kar saku in sql formate me 