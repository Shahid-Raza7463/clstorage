<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Models\Tender;
use App\Models\Training;
use App\Models\Asset;
use App\Models\Page;
use App\Models\Assetticket;
use App\Models\Title;
use App\Models\Teammember;
use App\Models\Assignment;
use App\Models\Assignmentteammapping;
use App\Models\Assignmentmapping;
use App\Models\Notification;
use App\Models\Client;
use App\Models\Permission;
use DB;
use Carbon\Carbon;
use App\Models\Holiday;
use Illuminate\Support\Facades\Http;

class BackEndController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function create()
  {
    $pages = DB::table('pages')->where('id', '!=', '3')->where('id', '!=', '9')->get();
    return view('backEnd.training.create', compact('pages'));
  }

  public function authotp(Request $request)
  {
    if ($request->ajax()) {
      // dd($request->id);
      if (isset($request->id)) {
        $authotp = DB::table('teammembers')
          ->select('teammembers.mobile_no')->where('id', auth()->user()->teammember_id)->first();
        //	dd($authotp->mobile_no);
        $curl = curl_init();
        $authnumber = $authotp->mobile_no;
        $cdate = urlencode(date('F d,Y', strtotime(date('Y-m-d'))));
        $otpap = sprintf("%06d", mt_rand(1, 999999));

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://bhashsms.com/api/sendmsg.php?user=KGSomani&pass=123456&sender=CPTLIT&phone=" . $authnumber . "&text=" . $otpap . "%20is%20the%20Onetime%20password%20(OTP)%20for%20authentication%20of%20transaction%20at%20KGS%20" . $cdate . "%20CPTLIT&priority=ndnd&stype=normal", // your preferred url
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30000,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          //    CURLOPT_POSTFIELDS => json_encode($data2),
          CURLOPT_HTTPHEADER => array(
            // Set here requred headers
            "accept: /",
            "accept-language: en-US,en;q=0.8",
            "content-type: application/json",
          ),

        ));  //  dd($se);
        $response = curl_exec($curl);
        $urlPath = $request->path();

        if ($urlPath === 'incrementauthotp') {
          // If the URL matches '/incrementauthotp', update the 'incrementletters' table
          $dbRes = DB::table('incrementletters')->where('id', $request->id)->where('final_status', 1)->update([
            'otp' => $otpap,
          ]);
        } elseif ($urlPath === 'authotp') {
          // If the URL matches '/authotp', update the 'staffappointmentletters' table
          $dbRes = DB::table('staffappointmentletters')->where('teammember_id', auth()->user()->teammember_id)->update([
            'otp' => $otpap,
          ]);
        }

        return response()->json($dbRes);
      }
    }
  }


  public function clauseotp(Request $request)
  {
    //  dd($request->id); die;
    if ($request->ajax()) {
      if (isset($request->id)) {
        //   dd($request->id);
        $authotp = DB::table('teammembers')
          ->select('teammembers.mobile_no')->where('teammembers.id', $request->id)->first();
        //	dd($authotp->mobile_no);
        $curl = curl_init();
        $authnumber = $authotp->mobile_no;
        $cdate = urlencode(date('F d,Y', strtotime(date('Y-m-d'))));
        $otpap = sprintf("%06d", mt_rand(1, 999999));

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://bhashsms.com/api/sendmsg.php?user=KGSomani&pass=123456&sender=CPTLIT&phone=" . $authnumber . "&text=" . $otpap . "%20is%20the%20Onetime%20password%20(OTP)%20for%20authentication%20of%20transaction%20at%20KGS%20" . $cdate . "%20CPTLIT&priority=ndnd&stype=normal", // your preferred url
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30000,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          //    CURLOPT_POSTFIELDS => json_encode($data2),
          CURLOPT_HTTPHEADER => array(
            // Set here requred headers
            "accept: */*",
            "accept-language: en-US,en;q=0.8",
            "content-type: application/json",
          ),

        ));  //  dd($se);
        $response = curl_exec($curl);

        $user = DB::table('clauserestrictings')->where('createdby', auth()->user()->teammember_id)->first();
        if ($user ==  null) {

          DB::table('clauserestrictings')->insert([
            'createdby'     =>     auth()->user()->teammember_id,
            'otp' => $otpap,
            'created_at'          =>     date('y-m-d'),
            'updated_at'              =>    date('y-m-d'),
          ]);
        } else {
          DB::table('clauserestrictings')->where('createdby', auth()->user()->teammember_id)->update([
            'otp' => $otpap,
            'updated_at' => date('y-m-d'),
          ]);
        }

        return response()->json($outstationconveyances);
      }
    }
  }
  public function incrementletter()
  {
    $teammember = DB::table('incrementletters')
      ->leftjoin('teammembers', 'teammembers.id', 'incrementletters.teammember_id')
      ->where('incrementletters.teammember_id', auth()->user()->teammember_id)
      ->where('incrementletters.final_status', 1)
      ->select(
        'incrementletters.*',
        'teammembers.team_member',
        'teammembers.department',
        'teammembers.permanentaddress',
        'teammembers.communicationaddress'
      )
      ->orderBy('id', 'desc')->first();
    $id = $teammember->id;
    return view('backEnd.incrementletter', compact('teammember', 'id'));
  }
  public function incrementOtpVerify(Request $request)
  {
    // dd($request);
    $request->validate([
      'otp' => 'required'
    ]);

    try {
      $data = $request->except(['_token']);

      $otp = $request->otp;

      $otpm =  DB::table('incrementletters')->where('teammember_id', auth()->user()->teammember_id)
        ->where('id', $request->incrementid)->latest()->first();
      if ($otp == $otpm->otp) {
        // dd($otpm);
        DB::table('incrementletters')->where('teammember_id', auth()->user()->teammember_id)
          ->where('id', $request->incrementid)->update([
            'status' => '1',
            'otpdate' => date('Y-m-d H:i:s')
          ]);
        $teammember = DB::table('teammembers')->where('id', auth()->user()->teammember_id)->first();

        $data = array(
          'teammember' => $teammember->team_member ?? '',
          //    'id' => $id ??''   
        );

        $a = Mail::send('emails.notificationincrementletterMail', $data, function ($msg) use ($data) {
          // $msg->to(['priyankasharma@kgsomani.com']);
          $msg->to(['priyankasharma@kgsomani.com']);
          //  $msg->cc(['priyankasharma@kgsomani.com']);
          $msg->subject('Increment Letter Verified || ' . $data['teammember']);
        });
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
  public function clauserestricting_store(Request $request)
  {
    $request->validate([
      'otp' => 'required'
    ]);

    try {
      $data = $request->except(['_token']);

      $otp = $request->otp;

      $otpm = DB::table('clauserestrictings')->where('createdby', auth()->user()->teammember_id)->first();
      if ($otp == $otpm->otp) {

        DB::table('clauserestrictings')->where('createdby', auth()->user()->teammember_id)->update([
          'status' => '1',
          'designation' => $request->designation,

          'otpdate' => date('Y-m-d H:i:s')
        ]);
        $teammember = DB::table('teammembers')->where('id', auth()->user()->teammember_id)->first();

        $data = array(
          'teammember' => $teammember->team_member ?? '',
          //    'id' => $id ??''   
        );

        //  $a=Mail::send('emails.notificationappointmentletterMail', $data, function ($msg) use($data){
        //   $msg->to(['priyankasharma@kgsomani.com']);
        // //  $msg->cc(['priyankasharma@kgsomani.com']);
        //  $msg->subject('Appointment Letter Verified || '.$data['teammember'] );
        // });
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

        $data = array(
          'teammember' => $teammember->team_member ?? '',
          //    'id' => $id ??''   
        );

        $a = Mail::send('emails.notificationappointmentletterMail', $data, function ($msg) use ($data) {
          // $msg->to(['priyankasharma@kgsomani.com']);
          $msg->to(['Tech@capitall.io']);
          //  $msg->cc(['priyankasharma@kgsomani.com']);
          $msg->subject('Appointment Letter Verified || ' . $data['teammember']);
        });
        $output = array('msg' => 'otp match successfully and verified');
        return redirect('/appointmentletters')->with('success', $output);

        // return back()->with('success', $output);

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

  // live
  // public function otpapstore(Request $request)
  // {
  //   $request->validate([
  //     'otp' => 'required'
  //   ]);

  //   try {
  //     $data = $request->except(['_token']);

  //     $otp = $request->otp;

  //     $otpm = DB::table('staffappointmentletters')->where('teammember_id', auth()->user()->teammember_id)->first();
  //     if ($otp == $otpm->otp) {

  //       DB::table('staffappointmentletters')->where('teammember_id', auth()->user()->teammember_id)->update([
  //         'status' => '1',
  //         'otpdate' => date('Y-m-d H:i:s')
  //       ]);
  //       $teammember = DB::table('teammembers')->where('id', auth()->user()->teammember_id)->first();

  //       $data = array(
  //         'teammember' => $teammember->team_member ?? '',
  //         //    'id' => $id ??''   
  //       );

  //       $a = Mail::send('emails.notificationappointmentletterMail', $data, function ($msg) use ($data) {
  //         $msg->to(['priyankasharma@kgsomani.com']);
  //         //  $msg->cc(['priyankasharma@kgsomani.com']);
  //         $msg->subject('Appointment Letter Verified || ' . $data['teammember']);
  //       });
  //       $output = array('msg' => 'otp match successfully and verified');
  //       return redirect('/appointmentletters')->with('success', $output);

  //       // return back()->with('success', $output);

  //     } else {
  //       $output = array('msg' => 'otp did not match! Please enter valid otp');
  //       return back()->with('success', $output);
  //     }
  //   } catch (Exception $e) {
  //     DB::rollBack();
  //     Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
  //     report($e);
  //     $output = array('msg' => $e->getMessage());
  //     return back()->withErrors($output)->withInput();
  //   }
  // }

  public function appointmentletter()
  {
    $teammember = DB::table('staffappointmentletters')
      ->leftjoin('teammembers', 'teammembers.id', 'staffappointmentletters.teammember_id')
      ->where('teammember_id', auth()->user()->teammember_id)
      ->select('staffappointmentletters.*', 'teammembers.team_member', 'teammembers.permanentaddress', 'teammembers.communicationaddress', 'teammembers.pancardno', 'teammembers.fathername', 'teammembers.joining_date')->first();

    // dd($teammember);
    return view('backEnd.appointmentletter', compact('teammember'));
  }
  public function trainingreminderMail()
  {

    $trainingid = Training::pluck('teammember_id')->toArray();

    $accountant = Teammember::whereNotIn('id', $trainingid)->where('id', '!=', '6')->where('id', '!=', '156')->pluck('emailid')->toArray();
    // dd($accountant);
    foreach ($accountant as $accountantmail) {
      $teammember = $accountantmail;
      $data = array();

      Mail::send('emails.trainingreminder', $data, function ($msg) use ($data, $teammember) {
        $msg->to($teammember);
        $msg->subject('kgs Training Reminder');
      });

      // die;
    }
    $output = array('msg' => 'Reminder Mail Send Successfully');
    return redirect('traininglist')->with('success', $output);
  }
  public function trainingMail(Request $request)
  {
    $module = Page::wherein('id', $request->module)->get();
    // dd($module);
    $teammember = DB::table('teammembers')->where('id', $request->id)->pluck('emailid')->first();
    $data = array(
      'module' =>  $module,
    );

    Mail::send('emails.trainingmail', $data, function ($msg) use ($data, $teammember) {
      $msg->to($teammember);
      $msg->subject('kgs Training Reminder');
    });
    $output = array('msg' => 'Reminder Mail Send Successfully');
    return redirect('traininglist')->with('success', $output);
  }
  public function training(Request $request)
  {
    // dd($request);
    try {
      $trainingid =  DB::table('trainings')->insertGetId([
        'teammember_id'         => auth()->user()->teammember_id,
        'created_at'          =>     date('y-m-d'),
        'updated_at'              =>    date('y-m-d'),
      ]);

      foreach ($request->page_id as $page_id) {
        //   dd($page_id);
        DB::table('traininglists')->insert([
          'training_id'     =>     $trainingid,
          'page_id'     =>     $page_id,
          'understood'     =>     1,
          'created_at'          =>     date('y-m-d'),
          'updated_at'              =>    date('y-m-d'),
        ]);
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
  public function traininglist()
  {
    if (auth()->user()->role_id == 17 || auth()->user()->role_id == 11) {
      $trainingDatas = DB::table('trainings')
        ->leftjoin('teammembers', 'teammembers.id', 'trainings.teammember_id')
        ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
        ->select('trainings.*', 'teammembers.team_member', 'roles.rolename')->where('teammember_id', '!=', '6')->get();
      return view('backEnd.training.index', compact('trainingDatas'));
    } else {
      $trainingDatas = DB::table('trainings')
        ->leftjoin('teammembers', 'teammembers.id', 'trainings.teammember_id')
        ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
        ->select('trainings.*', 'teammembers.team_member', 'roles.rolename')->where('teammember_id', auth()->user()->teammember_id)->get();
      return view('backEnd.training.index', compact('trainingDatas'));
    }
  }
  public function traininglistshow($id = '')
  {
    $pages = DB::table('pages')->where('id', '!=', '3')->where('id', '!=', '9')->get();
    $trainingDatas = DB::table('traininglists')->where('training_id', $id)->get();
    $training = DB::table('trainings')->where('id', $id)->first();
    return view('backEnd.training.edit', compact('trainingDatas', 'pages', 'training'));
  }



  public function index()
  {

    if (auth()->user()->role_id == 11) {

      // financial year
      $currentDate4 = Carbon::now();
      // $currentDate4 = Carbon::parse('2024-07-01');
      // $currentDate4 = Carbon::parse('2024-07-01 13:30:00');
      $currentMonth4 = $currentDate4->format('F');
      if ($currentDate4->month >= 4) {
        // Current year financial year
        $financialStartDate = Carbon::create($currentDate4->year, 4, 1);
        $financialEndDate = Carbon::create($currentDate4->year + 1, 3, 31);
      } else {
        // Previous year financial year
        $financialStartDate = Carbon::create($currentDate4->year - 1, 4, 1);
        $financialEndDate = Carbon::create($currentDate4->year, 3, 31);
      }

      $financialStartYear = now()->month >= 4 ? now()->year : now()->year - 1;
      $financialEndYear = $financialStartYear + 1;

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
        12 => 'December'
      ];


      // Bills Pending for Generation
      $billspending = DB::table('assignmentmappings')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftJoin('invoices', 'invoices.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->whereNull('invoices.assignmentgenerate_id')
        ->where('assignmentbudgetings.status', 0)
        ->sum('assignmentmappings.engagementfee');


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

      // How many assignments completed in this months
      $assignmentcompleted = DB::table('assignmentmappings')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        // ->where('assignmentbudgetings.status', 0)
        ->whereMonth('assignmentbudgetings.otpverifydate', Carbon::now()->month)
        ->whereYear('assignmentbudgetings.otpverifydate', Carbon::now()->year)
        ->count();

      // How many Delayed Assignments
      // $delayedAssignments = DB::table('assignmentmappings')
      //   ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
      //   ->whereRaw('COALESCE(DATE(assignmentbudgetings.actualenddate), DATE(assignmentbudgetings.tentativeenddate)) < ?', [Carbon::today()->toDateString()])
      //   ->count();

      // $delayedAssignments = DB::table('assignmentmappings')
      //   ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
      //   ->where('assignmentbudgetings.status', 1)
      //   ->whereRaw('COALESCE(DATE(assignmentbudgetings.actualenddate), DATE(assignmentbudgetings.tentativeenddate)) < ?', [Carbon::today()->toDateString()])
      //   ->count();

      $delayedAssignments = DB::table('assignmentmappings')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->where(function ($q) {
          $q->where(function ($sub) {
            $sub->where('assignmentbudgetings.status', 1)
              // Delayed if Documentation < 100% OR Draft Report Date > Tentative End Date
              ->where(function ($inner) {
                $inner->whereNull('assignmentbudgetings.percentclosedate')
                  ->orWhereRaw('assignmentbudgetings.draftreportdate > assignmentbudgetings.tentativeenddate');
              });
          })
            // if worked hour > esthour
            ->orWhereRaw('(
            SELECT COALESCE(SUM(totalhour), 0)
            FROM timesheetusers
            WHERE assignmentgenerate_id = assignmentmappings.assignmentgenerate_id
        ) > assignmentmappings.esthours');
        })
        ->count();

      // How many tender submitted this months
      // $tendersSubmittedCount = DB::table('tenders')
      //   ->where('tendersubmitstatus', 1)
      //   ->whereMonth('date', Carbon::now()->month)
      //   ->whereYear('date', Carbon::now()->year)
      //   ->count();

      $tendersSubmittedCount = DB::table('tenders')
        ->where('tendersubmitstatus', 1)
        ->whereMonth('tendersubmitdate', Carbon::now()->month)
        ->whereYear('tendersubmitdate', Carbon::now()->year)
        ->count();

      // NFRA Audits Ongoing
      $auditsDue = DB::table('assignmentmappings')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->where('assignmentbudgetings.status', 1)
        ->where('assignmentmappings.eqcrapplicability', 1)
        ->count();

      // total amount of convence, how many amount approved for convence in this months or Exceptional Expenses 
      // $exceptionalExpenses = DB::table('outstationconveyances')
      //   ->where('status', 6)
      //   ->whereMonth('approveddate', Carbon::now()->month)
      //   ->whereYear('approveddate', Carbon::now()->year)
      //   ->sum('finalamount');

      $exceptionalExpenses = DB::table('outstationconveyances')
        ->where('status', 6)
        ->whereMonth('paiddate', Carbon::now()->month)
        ->whereYear('paiddate', Carbon::now()->year)
        ->sum('finalamount');




      // how many users not accepted independance mail till now
      $totalNotFilled = DB::table('assignmentmappings')
        ->select(DB::raw('COUNT(*) as total_not_filled'))
        ->leftJoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
        ->leftJoin('teammembers', 'teammembers.id', '=', 'assignmentteammappings.teammember_id')
        ->leftJoin('annual_independence_declarations', function ($join) {
          $join->on('annual_independence_declarations.assignmentgenerateid', '=', 'assignmentmappings.assignmentgenerate_id')
            ->on('annual_independence_declarations.createdby', '=', 'teammembers.id')
            ->where('annual_independence_declarations.type', 2);
        })
        ->whereNull('annual_independence_declarations.id') // Members without declarations
        ->groupBy('assignmentmappings.assignmentgenerate_id')
        ->get()
        ->sum('total_not_filled');

      // $clientindependenceNotFilled = DB::table('assignmentmappings')
      //   ->select(DB::raw('COUNT(*) as total_not_filled'))
      //   ->leftJoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
      //   ->leftJoin('teammembers', 'teammembers.id', '=', 'assignmentteammappings.teammember_id')
      //   ->leftJoin('annual_independence_declarations', function ($join) {
      //     $join->on('annual_independence_declarations.assignmentgenerateid', '=', 'assignmentmappings.assignmentgenerate_id')
      //       ->on('annual_independence_declarations.createdby', '=', 'teammembers.id')
      //       ->where('annual_independence_declarations.type', 2);
      //   })
      //   ->whereNull('annual_independence_declarations.id') // Members without declarations
      //   ->groupBy('assignmentmappings.assignmentgenerate_id')
      //   ->get()
      //   ->sum('total_not_filled');

      // $independencenotfilled = DB::table('assignmentmappings')
      //   ->select(DB::raw('COUNT(*) as total_not_filled'))
      //   ->leftJoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
      //   ->leftJoin('teammembers', 'teammembers.id', '=', 'assignmentteammappings.teammember_id')
      //   ->leftJoin('independences', function ($join) {
      //     $join->on('independences.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
      //       ->on('independences.createdby', '=', 'teammembers.id');
      //   })
      //   ->whereNull('independences.id') // Members without declarations
      //   ->groupBy('assignmentmappings.assignmentgenerate_id')
      //   ->get()
      //   ->sum('total_not_filled');

      // $totalNotFilled = $clientindependenceNotFilled + $independencenotfilled;


      // Assignment Status Overview
      $assignmentOverviews = DB::table('assignmentmappings')
        ->whereBetween('assignmentmappings.created_at', [$financialStartDate, $financialEndDate])
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
        // ->limit(3)
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
        ->whereBetween('assignmentmappings.created_at', [$financialStartDate, $financialEndDate])
        ->orderByDesc('assignmentbudgetings.id')
        ->select(
          'assignmentmappings.*',
          'assignmentbudgetings.assignmentname',
          'clients.client_name'
        )
        // ->limit(6)
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


      // NFRA Audits, Quality Reviews & Peer Review
      $ecqrAudits = DB::table('assignmentmappings')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.eqcrpartner')
        ->leftJoin('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
        // ->where('assignmentbudgetings.status', 1)
        ->whereBetween('assignmentmappings.created_at', [$financialStartDate, $financialEndDate])
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
        });

      $allTickets = $ticketDatas->merge($hrTickets);

      // Assignment-wise P&L Analysis and Loss Making Assignments
      $assignmentprofitandlosses = DB::table('assignmentmappings')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->leftJoin('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
        ->whereBetween('assignmentmappings.created_at', [$financialStartDate, $financialEndDate])
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

      $conveyanceonlybillno = DB::table('outstationconveyances')
        ->where('bill', 'No')
        ->select(
          'assignmentgenerate_id',
          DB::raw('SUM(finalamount) as finalamounts')
        )
        ->groupBy('assignmentgenerate_id')
        ->pluck('finalamounts', 'assignmentgenerate_id');


      $lossMakingCount = 0;
      foreach ($assignmentprofitandlosses as $assignment) {
        $assignmentworkedcost = $assignmentCosts[$assignment->assignmentgenerate_id] ?? 0;
        $assignmentconvencecost = $conveyanceonlybillno[$assignment->assignmentgenerate_id] ?? 0;
        $assignment->total_cost = $assignmentworkedcost + $assignmentconvencecost;
        // Loss Making Assignments
        $revenue = $assignment->engagementfee ?? 0;
        $cost = $assignment->total_cost ?? 0;
        $profit = $revenue - $cost;

        if ($profit < 0) {
          $lossMakingCount++;
        }
      }

      // Upcoming Assignments
      $upcomingFromPlannings = DB::table('assignmentplannings')
        ->where('status', 0)
        ->whereDate('assignmentstartdate', '>=', Carbon::today())
        ->count();

      $upcomingFromPlannings = DB::table('assignmentplannings')
        ->where('status', 0)
        ->whereBetween('assignmentstartdate', [
          Carbon::today()->startOfDay(),
          Carbon::today()->addDays(30)->endOfDay()
        ])
        ->count();

      $upcomingFromBudgetings = DB::table('assignmentbudgetings')
        ->whereRaw('COALESCE(actualstartdate, tentativestartdate) > ?', [Carbon::today()->toDateString()])
        ->count();

      $totalUpcomingAssignments = $upcomingFromPlannings + $upcomingFromBudgetings;


      // How many amounts pending for collection within 15 days or Payments Not Recieved
      // $billspending15Daysdata = DB::table('assignmentmappings')
      //   ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
      //   ->leftJoin('invoices', 'invoices.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
      //   ->leftJoin('payments', 'payments.invoiceid', '=', 'invoices.invoice_id')
      //   ->where('assignmentbudgetings.status', 0)
      //   // ->where('invoices.invoicescategory', 2)
      //   ->whereNotNull('invoices.id') // Invoice is created
      //   ->where('invoices.status', 2)
      //   ->whereNull('payments.invoiceid')  // Payment not yet received
      //   // Only within last 15 days
      //   ->whereBetween('invoices.created_at', [
      //     Carbon::today()->subDays(15)->startOfDay(),
      //     Carbon::today()->endOfDay()
      //   ])
      //   ->select(
      //     'invoices.currency',
      //     DB::raw("DATE_FORMAT(invoices.created_at, '%Y-%m-%d') as bill_date"),
      //     DB::raw('SUM(invoices.total) as total_amount')
      //   )
      //   ->groupBy('invoices.currency', 'bill_date')
      //   ->get();

      // $billspending15Daysdata = DB::table('assignmentmappings')
      //   ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
      //   ->leftJoin('invoices', 'invoices.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
      //   ->leftJoin('outstandings', 'outstandings.BILL_NO', '=', 'invoices.invoice_id')
      //   ->leftJoin('payments', 'payments.invoiceid', '=', 'invoices.invoice_id')
      //   ->where('assignmentbudgetings.status', 0)
      //   ->whereNotNull('invoices.id')
      //   ->where('invoices.status', 2)
      //   ->whereNull('payments.invoiceid')
      //   ->where(function ($q) {
      //     $q->whereIn('invoices.currency', [1, 3])
      //       ->orWhereNull('invoices.currency');
      //   })
      //   ->whereBetween('invoices.created_at', [
      //     Carbon::today()->subDays(15)->startOfDay(),
      //     Carbon::today()->endOfDay()
      //   ])
      //   ->select(
      //     'invoices.currency',
      //     DB::raw("DATE_FORMAT(invoices.created_at, '%Y-%m-%d') as bill_date"),
      //     DB::raw('SUM(invoices.total) as total_amount')
      //   )
      //   ->groupBy('invoices.currency', 'bill_date')
      //   ->get();

      // filter KPI How many amounts pending for collection within 15 days or Payments Not Recieved
      $billspending15Daysdata = DB::table('assignmentmappings')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->leftJoin('invoices', 'invoices.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->leftJoin('outstandings', 'outstandings.BILL_NO', '=', 'invoices.invoice_id')
        ->leftJoin('payments', 'payments.invoiceid', '=', 'invoices.invoice_id')
        ->where('assignmentbudgetings.status', 0)
        ->whereNotNull('invoices.id')
        ->where('invoices.status', 2)
        ->whereNull('payments.invoiceid')
        ->where(function ($q) {
          $q->whereIn('invoices.currency', [1, 3])
            ->orWhereNull('invoices.currency');
        })
        ->whereBetween('invoices.created_at', [
          Carbon::today()->subDays(15)->startOfDay(),
          Carbon::today()->endOfDay()
        ])
        ->select(
          'invoices.currency',
          DB::raw("DATE_FORMAT(outstandings.created_at, '%Y-%m-%d') as bill_date"),
          DB::raw('SUM(outstandings.AMT) as total_amount')
        )
        ->groupBy('invoices.currency', 'bill_date')
        ->get();


      $billspending15Days = $this->convertusdtoinr($billspending15Daysdata);

      // Timesheet Filled On Closed Assignment
      $timesheetOnClosedAssignment = DB::table('assignmentmappings')
        ->join('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->join('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
        ->whereExists(function ($query) {
          $query->select(DB::raw(1))
            ->from('timesheetusers')
            ->whereRaw('timesheetusers.assignmentgenerate_id = assignmentmappings.assignmentgenerate_id')
            ->whereRaw("DATE(timesheetusers.created_at) > DATE(COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate))");
        })
        ->select('assignmentmappings.assignmentgenerate_id')
        ->distinct()
        ->count();


      // Partner-wise P&L Statement
      $assignmentGenerateIds = DB::table('assignmentbudgetings')
        ->whereBetween('periodstartdate', [$financialStartDate, $financialEndDate])
        ->whereBetween('periodenddate', [$financialStartDate, $financialEndDate])
        ->pluck('assignmentgenerate_id');

      // $invoices = DB::table('invoices')
      //   ->select(
      //     'invoices.assignmentgenerate_id',
      //     'teammembers.team_member',
      //     DB::raw('SUM(invoices.total) as total')
      //   )
      //   ->join('teammembers', 'teammembers.id', '=', 'invoices.partner')
      //   ->whereIn('invoices.assignmentgenerate_id', $assignmentGenerateIds)
      //   ->groupBy('invoices.assignmentgenerate_id', 'teammembers.team_member')
      //   ->get();

      $invoicesdata = DB::table('invoices')
        ->select(
          'invoices.assignmentgenerate_id',
          'invoices.currency',
          'teammembers.team_member',
          DB::raw("DATE_FORMAT(invoices.created_at, '%Y-%m-%d') as bill_date"),
          DB::raw('SUM(invoices.total) as total_amount')
        )
        ->join('teammembers', 'teammembers.id', '=', 'invoices.partner')
        ->whereIn('invoices.assignmentgenerate_id', $assignmentGenerateIds)
        ->groupBy('invoices.assignmentgenerate_id', 'teammembers.team_member', 'invoices.currency', 'bill_date')
        ->get();

      $invoicesdata = $this->convertusdtoinr1($invoicesdata);

      $invoices = $invoicesdata
        ->groupBy('assignmentgenerate_id')
        ->map(function ($items, $assignmentId) {
          return (object)[
            'assignmentgenerate_id' => $assignmentId,
            'team_member' => $items->first()->team_member,
            'total' => $items->sum('total_amount'),
          ];
        })
        ->values();


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

      // $finalData = $invoices->map(function ($row) use ($groupedCosts) {
      //   $row->cost = $groupedCosts[$row->assignmentgenerate_id] ?? 0;
      //   $row->profit_loss = $row->total - $row->cost;
      //   return $row;
      // });

      $finalData = $invoices->map(function ($row) use ($groupedCosts, $conveyanceonlybillno) {
        $workedcost = $groupedCosts[$row->assignmentgenerate_id] ?? 0;
        $convencecostdata = $conveyanceonlybillno[$row->assignmentgenerate_id] ?? 0;
        $row->cost = $workedcost + $convencecostdata;
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
      $teamAllocatedHours = DB::table('timesheetusers')
        ->join('teammembers', 'teammembers.id', '=', 'timesheetusers.createdby')
        // ->whereIn('teammembers.id', [14, 23, 187, 305, 659, 815])
        // ->whereNotIn('teammembers.role_id', [13])
        ->whereBetween('timesheetusers.created_at', [
          $financialStartDate,
          $financialEndDate
        ])
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
            ->whereBetween('assignmentmappings.created_at', [
              $financialStartDate,
              $financialEndDate
            ])
            ->sum('assignmentmappings.eqcresthour');

          $allocatedHours2 = DB::table('assignmentmappings')
            ->where('assignmentmappings.leadpartner', $teamAllocatedHour->teammember_id)
            ->whereBetween('assignmentmappings.created_at', [
              $financialStartDate,
              $financialEndDate
            ])
            ->sum('assignmentmappings.partneresthour');

          $allocatedHours3 = DB::table('assignmentmappings')
            ->where('assignmentmappings.otherpartner', $teamAllocatedHour->teammember_id)
            ->whereBetween('assignmentmappings.created_at', [
              $financialStartDate,
              $financialEndDate
            ])
            ->sum('assignmentmappings.otherpartneresthour');

          $allocatedHours = $allocatedHours1 + $allocatedHours2 + $allocatedHours3;
        } else {
          $allocatedHours = DB::table('assignmentteammappings')
            ->where('assignmentteammappings.teammember_id', $teamAllocatedHour->teammember_id)
            ->whereBetween('assignmentteammappings.created_at', [
              $financialStartDate,
              $financialEndDate
            ])
            ->sum('assignmentteammappings.teamesthour');
        }

        if (is_null($allocatedHours)) {
          $allocatedHours = 0;
        }
        $teamAllocatedHour->teamallocatedhours = $allocatedHours;
        $teamAllocatedHour->discrepancy = $teamAllocatedHour->actualhours - (float) $allocatedHours;
      }

      // Monthly Expense Analysis
      // financial year
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
                ->whereIn('month', ['April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']);
            });
        })
        ->where('send_to_bank', 1)
        ->groupBy('year', 'month')
        ->orderByRaw("FIELD(month, 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December', 'January', 'February', 'March')")
        ->get();

      $teamexceptionalExpenses = DB::table('outstationconveyances')
        ->selectRaw('MONTH(paiddate) as month, YEAR(paiddate) as year, SUM(finalamount) as total_amount')
        ->where('status', 6)
        ->whereBetween('paiddate', [
          $financialStartDate->format('Y-m-d'),
          $financialEndDate->format('Y-m-d')
        ])
        ->groupByRaw('MONTH(paiddate), YEAR(paiddate)')
        ->orderByRaw('FIELD(MONTH(paiddate),  4,5,6,7,8,9,10,11,12,1,2,3)')
        ->get()
        ->map(function ($item) use ($monthNames) {
          $item->month = $monthNames[$item->month] ?? $item->month;
          return $item;
        });

      // Cash Flow Analysis
      $cashFlowRecieved = DB::table('payments')
        ->selectRaw('MONTH(paymentdate) as month, YEAR(paymentdate) as year, SUM(amountreceived) as amountreceived')
        ->whereBetween('paymentdate', [
          $financialStartDate->format('Y-m-d'),
          $financialEndDate->format('Y-m-d')
        ])
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

      // Cash Flow Analysis end hare

      // Budget vs Actual Cash Flow

      // 1.budget table se budgetinflow
      // 2.cash recieved in paymnets table 
      // 2.budget table se budgetoutflow
      // 4.cash spend on employee and vender, like  employeepayrolls and vendorlist tables 

      $budgetactualcash = DB::table('budget')
        ->select('month', 'year', DB::raw('SUM(budgetinflow) as budgetinflow'), DB::raw('SUM(budgetoutflow) as budgetoutflow'))
        ->where(function ($query) use ($financialEndYear, $financialStartYear) {
          $query->where(function ($q) use ($financialEndYear) {
            $q->where('year', $financialEndYear)
              ->whereIn('month', ['January', 'February', 'March']);
          })->orWhere(function ($q) use ($financialStartYear) {
            $q->where('year', $financialStartYear)
              ->whereIn('month', ['April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']);
          });
        })
        ->groupBy('year', 'month')
        ->orderByRaw("FIELD(month, 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December', 'January', 'February', 'March')")
        ->get();


      //  Budget vs Actual Cash Flow end hare 


      // Invoice Due vs Assignment Billing vs Cash Recovery
      // $assignmentBilling = DB::table('invoices')
      //   ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, SUM(total) as invoices_amount')
      //   ->whereBetween('created_at', [
      //     $financialStartDate,
      //     $financialEndDate
      //   ])
      //   ->groupByRaw('MONTH(created_at), YEAR(created_at)')
      //   ->orderByRaw('FIELD(MONTH(created_at),  4,5,6,7,8,9,10,11,12,1,2,3)')
      //   ->get()
      //   ->map(function ($item) use ($monthNames) {
      //     $item->month = $monthNames[$item->month] ?? $item->month;
      //     return $item;
      //   });

      $assignmentBillingdata = DB::table('invoices')
        ->selectRaw("MONTH(created_at) as month, YEAR(created_at) as year, invoices.currency, DATE_FORMAT(invoices.created_at, '%Y-%m-%d') as bill_date, SUM(total) as total_amount")
        ->whereBetween('created_at', [
          $financialStartDate,
          $financialEndDate
        ])
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
        ->whereBetween('created_at', [
          $financialStartDate,
          $financialEndDate
        ])
        ->groupByRaw('MONTH(created_at), YEAR(created_at)')
        ->orderByRaw('FIELD(MONTH(created_at),  4,5,6,7,8,9,10,11,12,1,2,3)')
        ->get()
        ->map(function ($item) use ($monthNames) {
          $item->month = $monthNames[$item->month] ?? $item->month;
          return $item;
        });

      $cashRecovery = DB::table('payments')
        ->selectRaw('MONTH(paymentdate) as month, YEAR(paymentdate) as year, SUM(amountreceived) as amountreceived')
        ->whereBetween('paymentdate', [
          $financialStartDate->format('Y-m-d'),
          $financialEndDate->format('Y-m-d')
        ])
        ->groupByRaw('MONTH(paymentdate), YEAR(paymentdate)')
        ->orderByRaw('FIELD(MONTH(paymentdate), 4,5,6,7,8,9,10,11,12,1,2,3)')
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

      // Work From Home 
      $workFromHome = DB::table('checkins')
        ->where('checkin_from', 'Work From Home')
        ->whereMonth('created_at', Carbon::now()->month)
        ->whereYear('created_at', Carbon::now()->year)
        ->count();


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

      $financialYears = array_reverse($financialYears);

      $partnerlist = Teammember::where('status', 1)
        ->where('role_id', 13)
        ->with('title')
        ->orderBy('team_member', 'asc')
        ->get();

      session()->forget('_old_input');

      return view('backEnd.kgsdashboardreport', compact('partnerlist', 'budgetactualcash', 'financialYears', 'workFromHome', 'budgetRevenueandbudgetExpences', 'budgetActualRevenue', 'budgetActualExpences', 'assignmentsWithInvoices', 'assignmentBilling', 'assignmentOutstanding', 'cashRecovery', 'cashFlowtotalspendData', 'cashFlowRecieved', 'teamexceptionalExpenses', 'teamsSalaries', 'teamAllocatedHours', 'timesheetOnClosedAssignment', 'totalNotFilled', 'partnerWiseProfit', 'lossMakingCount', 'billspending15Days', 'totalUpcomingAssignments', 'assignmentprofitandlosses', 'allTickets', 'hrTickets', 'ticketDatas', 'highpriorityAssignments', 'ecqrAudits', 'documentCompletions', 'assignmentOverviews',  'exceptionalExpenses', 'auditsDue', 'tendersSubmittedCount', 'delayedAssignments', 'assignmentcompleted', 'billspendingforcollection', 'billspending'));
    }

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
      $mentor = DB::table('teammembers')->where('id', $mentor_id)->where('status', '!=', 0)->first();
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

    // if (auth()->user()->role_id == 11 || auth()->user()->role_id == 12) {
    if (auth()->user()->role_id == 12) {
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
        ->Where('targettype', '3')->orWhere('targettype', '2')->orderBy('notifications.id', 'desc')->paginate(2);
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
        ->Where('targettype', '3')->orWhere('targettype', '2')->orderBy('notifications.id', 'desc')->paginate(2);
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

      /*if($status && $status->e_verify==0 && in_array(auth()->user()->role_id, [16, 17]))
		   {
			//  dd('hi');
      return view('backEnd.noappointmentletter');
     
 
	   }
		  elseif($status && $status->e_verify ==1  && $status->otp ==null && in_array(auth()->user()->role_id, [ 16, 17, 18]))
		   { 
			    return view('backEnd.appointmentletter',compact('teammember'));
		  }
         
         else{
         */

      $authidd = Assignmentteammapping::where('teammember_id', auth()->user()->teammember_id)->select('assignmentmapping_id')->pluck('assignmentmapping_id')->first();
      $authid = auth()->user()->teammember_id;
      $notificationDatas =   DB::table('notifications')
        //  ->leftjoin('users','users.id','notifications.created_by')
        ->leftjoin('teammembers', 'teammembers.id', 'notifications.created_by')
        ->where('notifications.targettype', '1')
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
      //  }
    }
  }

  public function filterdashboardreport(Request $request)
  {

    $yearly = $request->input('yearly');
    $monthsdigit = $request->input('months');
    $partnerId = $request->input('partner');
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

      // //ff How many amounts pending for invoice genrated
      // $billspendingQuery = DB::table('assignmentmappings')
      //   ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
      //   ->leftJoin('invoices', 'invoices.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
      //   ->whereBetween(DB::raw('COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate)'), [$startDateFormatted, $endDateFormatted])
      //   ->where(function ($query) use ($startDateFormatted, $endDateFormatted) {
      //     $query->whereNull('invoices.created_at')
      //       ->orWhereNotBetween('invoices.created_at', [$startDateFormatted, $endDateFormatted]);
      //   })
      //   ->where('assignmentbudgetings.status', 0);

      // if (!empty($monthsdigit)) {
      //   $billspendingQuery->whereMonth(DB::raw('COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate)'), $monthsdigit);
      // }

      // $billspending = $billspendingQuery->sum('assignmentmappings.engagementfee');



      // $billspendingforcollectionQuery = DB::table('assignmentmappings')
      //   ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
      //   ->leftJoin('invoices', 'invoices.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
      //   ->leftJoin('outstandings', 'outstandings.BILL_NO', '=', 'invoices.invoice_id')
      //   ->where('assignmentbudgetings.status', 0)
      //   // ensures invoice is created
      //   ->whereNotNull('invoices.id')
      //   ->whereBetween(DB::raw('COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate)'), [$startDateFormatted, $endDateFormatted])
      //   ->whereBetween('invoices.created_at', [$startDateFormatted, $endDateFormatted]);

      // if (!empty($monthsdigit)) {
      //   $billspendingforcollectionQuery->whereMonth('invoices.created_at', $monthsdigit);
      // }
      // $billspendingforcollection = $billspendingforcollectionQuery->sum('outstandings.AMT');


      // //ff How many amounts pending for collection within 15 days or Payments Not Recieved
      // $billspending15Days = DB::table('assignmentmappings')
      //   ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
      //   ->leftJoin('invoices', 'invoices.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
      //   ->leftJoin('payments', 'payments.invoiceid', '=', 'invoices.invoice_id')
      //   ->where('assignmentbudgetings.status', 0)
      //   ->whereNotNull('invoices.id') // Invoice is created
      //   ->whereNull('payments.invoiceid') // Payment not yet received
      //   ->whereBetween('invoices.created_at', [$startDateFormatted, $endDateFormatted])
      //   ->when(!empty($monthsdigit), function ($query) use ($monthsdigit, $startYear, $endYear) {
      //     $yearForMonth = $monthsdigit >= 4 ? $startYear : $endYear;
      //     $monthEnd = Carbon::create($yearForMonth, $monthsdigit, 1)->endOfMonth();
      //     // $monthStart = $monthEnd->copy()->subDays(28);
      //     $monthStart = $monthEnd->copy()->subDays(15);
      //     return $query->whereYear('invoices.created_at', $yearForMonth)
      //       ->whereMonth('invoices.created_at', $monthsdigit)
      //       ->whereBetween('invoices.created_at', [$monthStart, $monthEnd]);
      //   })
      //   ->when(empty($monthsdigit), function ($query) use ($endDateFormatted) {
      //     return $query->whereDate('invoices.created_at', '>=', Carbon::parse($endDateFormatted)->subDays(15));
      //   })
      //   ->sum('invoices.total');


      // filter KPI Bills Pending for Generation
      $billspending = DB::table('assignmentmappings')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftJoin('invoices', 'invoices.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->whereNull('invoices.assignmentgenerate_id')
        ->whereBetween(DB::raw('COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate)'), [$startDateFormatted, $endDateFormatted])
        ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
          $query->whereMonth(DB::raw('COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate)'), $monthsdigit);
        })
        ->when(!empty($partnerId), function ($query) use ($partnerId) {
          $query->where('assignmentmappings.leadpartner', $partnerId);
        })
        ->where('assignmentbudgetings.status', 0)
        ->sum('assignmentmappings.engagementfee');

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

      // filter KPI How many amounts pending for collection within 15 days or Payments Not Recieved
      $billspending15Daysdata = DB::table('assignmentmappings')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->leftJoin('invoices', 'invoices.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->leftJoin('outstandings', 'outstandings.BILL_NO', '=', 'invoices.invoice_id')
        ->leftJoin('payments', 'payments.invoiceid', '=', 'invoices.invoice_id')
        ->where('assignmentbudgetings.status', 0)
        ->whereBetween(DB::raw('COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate)'), [$startDateFormatted, $endDateFormatted])
        ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
          $query->whereMonth(DB::raw('COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate)'), $monthsdigit);
        })
        ->when(!empty($partnerId), function ($query) use ($partnerId) {
          $query->where('invoices.partner', $partnerId);
        })
        ->whereNotNull('invoices.id')
        ->where('invoices.status', 2)
        ->whereNull('payments.invoiceid')
        ->where(function ($q) {
          $q->whereIn('invoices.currency', [1, 3])
            ->orWhereNull('invoices.currency');
        })
        ->whereBetween('invoices.created_at', [
          Carbon::today()->subDays(15)->startOfDay(),
          Carbon::today()->endOfDay()
        ])
        ->select(
          'invoices.currency',
          DB::raw("DATE_FORMAT(outstandings.created_at, '%Y-%m-%d') as bill_date"),
          DB::raw('SUM(outstandings.AMT) as total_amount')
        )
        ->groupBy('invoices.currency', 'bill_date')
        ->get();

      $billspending15Days = $this->convertusdtoinr($billspending15Daysdata);

      // filter KPI How many Assignments Completed in this months
      $query = DB::table('assignmentmappings')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id');
      $query->whereBetween('assignmentbudgetings.otpverifydate', [$startDateFormatted, $endDateFormatted]);
      if (!empty($monthsdigit)) {
        $query->whereMonth('assignmentbudgetings.otpverifydate', $monthsdigit);
      }
      if (!empty($partnerId)) {
        $query->where('assignmentmappings.leadpartner', $partnerId);
      }

      $assignmentcompleted = $query->count();

      // filter KPI How many Delayed Assignments
      $delayedAssignments = DB::table('assignmentmappings')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->where(function ($q) {
          $q->where(function ($sub) {
            $sub->where('assignmentbudgetings.status', 1)
              // Delayed if Documentation < 100% OR Draft Report Date > Tentative End Date
              ->where(function ($inner) {
                $inner->whereNull('assignmentbudgetings.percentclosedate')
                  ->orWhereRaw('assignmentbudgetings.draftreportdate > assignmentbudgetings.tentativeenddate');
              });
          })
            // if worked hour > esthour
            ->orWhereRaw('(
            SELECT COALESCE(SUM(totalhour), 0)
            FROM timesheetusers
            WHERE assignmentgenerate_id = assignmentmappings.assignmentgenerate_id
        ) > assignmentmappings.esthours');
        })
        ->when(!empty($startDateFormatted) && !empty($endDateFormatted), function ($query) use ($startDateFormatted, $endDateFormatted) {
          $query->whereBetween(
            DB::raw('COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate)'),
            [$startDateFormatted, $endDateFormatted]
          );
        })
        ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
          $query->whereMonth(
            DB::raw('COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate)'),
            $monthsdigit
          );
        })
        ->when(!empty($partnerId), function ($query) use ($partnerId) {
          $query->where('assignmentmappings.leadpartner', $partnerId);
        })
        ->count();

      // dd($monthsdigit, $partnerId, $delayedAssignments);



      // filter KPI total amount of convence, how many amount approved for convence in this months or Exceptional Expenses 
      // $exceptionalQuery = DB::table('outstationconveyances')
      //   ->where('status', 6)
      //   ->whereBetween('approveddate', [$startDateFormatted, $endDateFormatted]);
      // if (!empty($monthsdigit)) {
      //   $exceptionalQuery->whereMonth('approveddate', $monthsdigit);
      // }
      // $exceptionalExpenses = $exceptionalQuery->sum('finalamount');

      $exceptionalQuery = DB::table('outstationconveyances')
        ->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', '=', 'outstationconveyances.assignmentgenerate_id')
        ->where('outstationconveyances.status', 6)
        ->whereBetween('outstationconveyances.paiddate', [$startDateFormatted, $endDateFormatted]);
      if (!empty($monthsdigit)) {
        $exceptionalQuery->whereMonth('outstationconveyances.paiddate', $monthsdigit);
      }
      if (!empty($partnerId)) {
        $exceptionalQuery->where('assignmentmappings.leadpartner', $partnerId);
      }

      $exceptionalExpenses = $exceptionalQuery->sum('finalamount');


      // filter KPI New Tenders Submitted this months
      // $tendersQuery = DB::table('tenders')
      //   ->where('tendersubmitstatus', 1)
      //   ->whereBetween('date', [$startDateFormatted, $endDateFormatted]);
      // if (!empty($monthsdigit)) {
      //   $tendersQuery->whereMonth('date', $monthsdigit);
      // }
      // $tendersSubmittedCount = $tendersQuery->count();

      $tendersQuery = DB::table('tenders')
        ->where('tendersubmitstatus', 1)
        ->whereBetween('tendersubmitdate', [$startDateFormatted, $endDateFormatted]);
      if (!empty($monthsdigit)) {
        $tendersQuery->whereMonth('tendersubmitdate', $monthsdigit);
      }
      // if (!empty($partnerId)) {hide this box
      //   $tendersQuery->where('assignmentmappings.leadpartner', $partnerId);
      // }
      $tendersSubmittedCount = $tendersQuery->count();


      // filter KPI how many users not accepted Audit Acceptance Pending mail till now
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
        ->when(!empty($partnerId), function ($query) use ($partnerId) {
          $query->where('assignmentmappings.leadpartner', $partnerId);
        })
        ->groupBy('assignmentmappings.assignmentgenerate_id')
        ->get()
        ->sum('total_not_filled');

      // $clientindependenceNotFilled = DB::table('assignmentmappings')
      //   ->select(DB::raw('COUNT(*) as total_not_filled'))
      //   ->leftJoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
      //   ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
      //   ->leftJoin('teammembers', 'teammembers.id', '=', 'assignmentteammappings.teammember_id')
      //   ->leftJoin('annual_independence_declarations', function ($join) {
      //     $join->on('annual_independence_declarations.assignmentgenerateid', '=', 'assignmentmappings.assignmentgenerate_id')
      //       ->on('annual_independence_declarations.createdby', '=', 'teammembers.id')
      //       ->where('annual_independence_declarations.type', 2);
      //   })
      //   ->whereNull('annual_independence_declarations.id') // Members without declarations
      //   ->whereBetween(DB::raw('COALESCE(assignmentbudgetings.actualstartdate, assignmentbudgetings.tentativestartdate)'), [$startDateFormatted, $endDateFormatted])
      //   ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
      //     $query->whereMonth(DB::raw('COALESCE(assignmentbudgetings.actualstartdate, assignmentbudgetings.tentativestartdate)'), $monthsdigit);
      //   })
      //   ->when(!empty($partnerId), function ($query) use ($partnerId) {
      //     $query->where('assignmentmappings.leadpartner', $partnerId);
      //   })
      //   ->groupBy('assignmentmappings.assignmentgenerate_id')
      //   ->get()
      //   ->sum('total_not_filled');


      // $independencenotfilled = DB::table('assignmentmappings')
      //   ->select(DB::raw('COUNT(*) as total_not_filled'))
      //   ->leftJoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
      //   ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
      //   ->leftJoin('teammembers', 'teammembers.id', '=', 'assignmentteammappings.teammember_id')
      //   ->leftJoin('independences', function ($join) {
      //     $join->on('independences.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
      //       ->on('independences.createdby', '=', 'teammembers.id');
      //   })
      //   ->whereNull('independences.id') // Members without declarations
      //   ->whereBetween(DB::raw('COALESCE(assignmentbudgetings.actualstartdate, assignmentbudgetings.tentativestartdate)'), [$startDateFormatted, $endDateFormatted])
      //   ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
      //     $query->whereMonth(DB::raw('COALESCE(assignmentbudgetings.actualstartdate, assignmentbudgetings.tentativestartdate)'), $monthsdigit);
      //   })
      //   ->when(!empty($partnerId), function ($query) use ($partnerId) {
      //     $query->where('assignmentmappings.leadpartner', $partnerId);
      //   })
      //   ->groupBy('assignmentmappings.assignmentgenerate_id')
      //   ->get()
      //   ->sum('total_not_filled');

      // $totalNotFilled = $clientindependenceNotFilled + $independencenotfilled;


      // NFRA Audits Ongoing
      $auditsDueQuery = DB::table('assignmentmappings')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->where('assignmentbudgetings.status', 1)
        ->where('assignmentmappings.eqcrapplicability', 1)
        ->whereBetween(DB::raw('COALESCE(assignmentbudgetings.actualstartdate, assignmentbudgetings.tentativestartdate)'), [$startDateFormatted, $endDateFormatted]);
      if (!empty($monthsdigit)) {
        $auditsDueQuery->whereMonth(DB::raw('COALESCE(assignmentbudgetings.actualstartdate, assignmentbudgetings.tentativestartdate)'), $monthsdigit);
      }
      if (!empty($partnerId)) {
        $auditsDueQuery->where('assignmentmappings.leadpartner', $partnerId);
      }
      $auditsDue = $auditsDueQuery->count();

      // filter KPI Upcoming Assignments
      $upcomingQuery = DB::table('assignmentplannings')
        ->where('status', 0)
        ->whereDate('assignmentstartdate', '>=', Carbon::today())
        ->whereBetween('assignmentstartdate', [$startDateFormatted, $endDateFormatted]);
      if (!empty($monthsdigit)) {
        $upcomingQuery->whereMonth('assignmentstartdate', $monthsdigit);
      }
      if (!empty($partnerId)) {
        $upcomingQuery->where('assignmentplannings.engagementpartner', $partnerId);
      }
      $upcomingFromPlannings = $upcomingQuery->count();


      $upcomingFromBudgetingsQuery = DB::table('assignmentmappings')
        ->join('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->whereRaw('COALESCE(assignmentbudgetings.actualstartdate, assignmentbudgetings.tentativestartdate) > ?', [Carbon::today()->toDateString()])
        ->whereBetween(DB::raw('COALESCE(assignmentbudgetings.actualstartdate, assignmentbudgetings.tentativestartdate)'), [$startDateFormatted, $endDateFormatted]);
      if (!empty($monthsdigit)) {
        $upcomingFromBudgetingsQuery->whereMonth(DB::raw('COALESCE(assignmentbudgetings.actualstartdate, assignmentbudgetings.tentativestartdate)'), $monthsdigit);
      }
      if (!empty($partnerId)) {
        $upcomingFromBudgetingsQuery->where('assignmentmappings.leadpartner', $partnerId);
      }
      $upcomingFromBudgetings = $upcomingFromBudgetingsQuery->count();
      $totalUpcomingAssignments = $upcomingFromPlannings + $upcomingFromBudgetings;

      // filter KPI Timesheet Filled On Closed Assignment
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
        ->when(!empty($partnerId), function ($query) use ($partnerId) {
          $query->where('assignmentmappings.leadpartner', $partnerId);
        })
        ->select('assignmentmappings.assignmentgenerate_id')
        ->distinct()
        ->count();

      // filter KPI Work From Home 
      $workFromHomeQuery = DB::table('checkins')
        ->where('checkin_from', 'Work From Home')
        ->whereBetween('created_at', [$startDateFormatted, $endDateFormatted]);
      if (!empty($monthsdigit)) {
        $workFromHomeQuery->whereMonth('created_at', $monthsdigit);
      }
      // if (!empty($partnerId)) {hide this is hidden from UI
      //   $workFromHomeQuery->where('assignmentmappings.leadpartner', $partnerId);
      // }
      $workFromHome = $workFromHomeQuery->count();

      // KPI filter end from hare 

      // filter Chart, Assignment Status Overview
      $assignmentOverviews = DB::table('assignmentmappings')
        ->whereBetween('assignmentmappings.created_at', [$startDateFormatted, $endDateFormatted])
        ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
          $query->whereMonth('assignmentmappings.created_at', $monthsdigit);
        })
        ->when(!empty($partnerId), function ($query) use ($partnerId) {
          $query->where('assignmentmappings.leadpartner', $partnerId);
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


      // filter Chart, Document Completion Progress
      $documentCompletions = DB::table('assignmentmappings')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->leftJoin('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
        // ->where('assignmentbudgetings.status', 1)
        ->whereBetween('assignmentmappings.created_at', [$startDateFormatted, $endDateFormatted])
        ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
          $query->whereMonth('assignmentmappings.created_at', $monthsdigit);
        })
        ->when(!empty($partnerId), function ($query) use ($partnerId) {
          $query->where('assignmentmappings.leadpartner', $partnerId);
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

      // filter Chart, NFRA Audits, Quality Reviews & Peer Review
      $ecqrAudits = DB::table('assignmentmappings')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.eqcrpartner')
        ->leftJoin('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
        // ->where('assignmentbudgetings.status', 1)
        ->whereBetween('assignmentmappings.created_at', [$startDateFormatted, $endDateFormatted])
        ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
          $query->whereMonth('assignmentmappings.created_at', $monthsdigit);
        })
        ->when(!empty($partnerId), function ($query) use ($partnerId) {
          $query->where('assignmentmappings.leadpartner', $partnerId);
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

      // dd($ecqrAudits);

      // filter Chart, Assignment-wise P&L Analysis and Loss Making Assignments
      $assignmentprofitandlosses = DB::table('assignmentmappings')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->leftJoin('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
        ->whereBetween('assignmentmappings.created_at', [$startDateFormatted, $endDateFormatted])
        ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
          $query->whereMonth('assignmentmappings.created_at', $monthsdigit);
        })
        ->when(!empty($partnerId), function ($query) use ($partnerId) {
          $query->where('assignmentmappings.leadpartner', $partnerId);
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

      $conveyanceonlybillno = DB::table('outstationconveyances')
        ->where('bill', 'No')
        ->select(
          'assignmentgenerate_id',
          DB::raw('SUM(finalamount) as finalamounts')
        )
        ->groupBy('assignmentgenerate_id')
        ->pluck('finalamounts', 'assignmentgenerate_id');


      $lossMakingCount = 0;
      foreach ($assignmentprofitandlosses as $assignment) {
        $assignmentworkedcost = $assignmentCosts[$assignment->assignmentgenerate_id] ?? 0;
        $assignmentconvencecost = $conveyanceonlybillno[$assignment->assignmentgenerate_id] ?? 0;
        $assignment->total_cost = $assignmentworkedcost + $assignmentconvencecost;
        // Loss Making Assignments
        $revenue = $assignment->engagementfee ?? 0;
        $cost = $assignment->total_cost ?? 0;
        $profit = $revenue - $cost;

        if ($profit < 0) {
          $lossMakingCount++;
        }
      }

      // filter Chart, Partner-wise P&L Statement
      $assignmentGenerateIds = DB::table('assignmentmappings')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->whereBetween('assignmentbudgetings.periodstartdate', [$startDateFormatted, $endDateFormatted])
        ->whereBetween('assignmentbudgetings.periodenddate', [$startDateFormatted, $endDateFormatted])
        ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
          $query->whereMonth('assignmentbudgetings.periodstartdate', $monthsdigit)
            ->whereMonth('assignmentbudgetings.periodenddate', $monthsdigit);
        })
        ->when(!empty($partnerId), function ($query) use ($partnerId) {
          $query->where('assignmentmappings.leadpartner', $partnerId);
        })
        ->pluck('assignmentmappings.assignmentgenerate_id');


      // $invoices = DB::table('invoices')
      //   ->select(
      //     'invoices.assignmentgenerate_id',
      //     'teammembers.team_member',
      //     DB::raw('SUM(invoices.total) as total')
      //   )
      //   ->join('teammembers', 'teammembers.id', '=', 'invoices.partner')
      //   ->whereIn('invoices.assignmentgenerate_id', $assignmentGenerateIds)
      //   ->groupBy('invoices.assignmentgenerate_id', 'teammembers.team_member')
      //   ->get();

      $invoicesdata = DB::table('invoices')
        ->select(
          'invoices.assignmentgenerate_id',
          'invoices.currency',
          'teammembers.team_member',
          DB::raw("DATE_FORMAT(invoices.created_at, '%Y-%m-%d') as bill_date"),
          DB::raw('SUM(invoices.total) as total_amount')
        )
        ->join('teammembers', 'teammembers.id', '=', 'invoices.partner')
        ->whereIn('invoices.assignmentgenerate_id', $assignmentGenerateIds)
        ->groupBy('invoices.assignmentgenerate_id', 'teammembers.team_member', 'invoices.currency', 'bill_date')
        ->get();

      $invoicesdata = $this->convertusdtoinr1($invoicesdata);

      $invoices = $invoicesdata
        ->groupBy('assignmentgenerate_id')
        ->map(function ($items, $assignmentId) {
          return (object)[
            'assignmentgenerate_id' => $assignmentId,
            'team_member' => $items->first()->team_member,
            'total' => $items->sum('total_amount'),
          ];
        })
        ->values();

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

      // $finalData = $invoices->map(function ($row) use ($groupedCosts) {
      //   $row->cost = $groupedCosts[$row->assignmentgenerate_id] ?? 0;
      //   $row->profit_loss = $row->total - $row->cost;
      //   return $row;
      // });

      $finalData = $invoices->map(function ($row) use ($groupedCosts, $conveyanceonlybillno) {
        $workedcost = $groupedCosts[$row->assignmentgenerate_id] ?? 0;
        $convencecostdata = $conveyanceonlybillno[$row->assignmentgenerate_id] ?? 0;
        $row->cost = $workedcost + $convencecostdata;
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

      // filter Chart, Monthly Expense Analysis 
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
        ->when(!empty($partnerId), function ($query) use ($partnerId) {
          $query->where('createdby', $partnerId);
        })
        ->groupBy('year', 'month')
        ->orderByRaw("FIELD(month, 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December', 'January', 'February', 'March')")
        ->get();


      // $teamexceptionalExpenses = DB::table('outstationconveyances')
      //   ->selectRaw('MONTH(approveddate) as month, YEAR(approveddate) as year, SUM(finalamount) as total_amount')
      //   ->where('status', 6)
      //   ->whereBetween('approveddate', [
      //     $startDateFormatted,
      //     $endDateFormatted
      //   ])
      //   ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
      //     $query->whereMonth('approveddate', $monthsdigit);
      //   })
      //   // ->when(!empty($partnerId), function ($query) use ($partnerId) {
      //   //   $query->where('assignmentmappings.leadpartner', $partnerId);
      //   // })
      //   ->groupByRaw('MONTH(approveddate), YEAR(approveddate)')
      //   ->orderByRaw('FIELD(MONTH(approveddate),  4,5,6,7,8,9,10,11,12,1,2,3)')
      //   ->get()
      //   ->map(function ($item) use ($monthNames) {
      //     $item->month = $monthNames[$item->month] ?? $item->month;
      //     return $item;
      //   });


      $teamexceptionalExpenses = DB::table('outstationconveyances')
        ->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', '=', 'outstationconveyances.assignmentgenerate_id')
        ->selectRaw('MONTH(outstationconveyances.paiddate) as month, YEAR(outstationconveyances.paiddate) as year, SUM(outstationconveyances.finalamount) as total_amount')
        ->where('outstationconveyances.status', 6)
        ->whereBetween('outstationconveyances.paiddate', [
          $startDateFormatted,
          $endDateFormatted
        ])
        ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
          $query->whereMonth('outstationconveyances.paiddate', $monthsdigit);
        })
        ->when(!empty($partnerId), function ($query) use ($partnerId) {
          $query->where('assignmentmappings.leadpartner', $partnerId);
        })
        ->groupByRaw('MONTH(outstationconveyances.paiddate), YEAR(outstationconveyances.paiddate)')
        ->orderByRaw('FIELD(MONTH(outstationconveyances.paiddate), 4,5,6,7,8,9,10,11,12,1,2,3)')
        ->get()
        ->map(function ($item) use ($monthNames) {
          $item->month = $monthNames[$item->month] ?? $item->month;
          return $item;
        });

      // filter Chart,cc Cash Flow Analysis
      $cashFlowRecieved = DB::table('payments')
        ->leftJoin('invoices', 'invoices.invoice_id', '=', 'payments.invoiceid')
        ->selectRaw('MONTH(paymentdate) as month, YEAR(paymentdate) as year, SUM(amountreceived) as amountreceived')
        ->whereBetween('paymentdate', [
          $startDateFormatted,
          $endDateFormatted
        ])
        ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
          $query->whereMonth('paymentdate', $monthsdigit);
        })
        ->when(!empty($partnerId), function ($query) use ($partnerId) {
          $query->where('invoices.partner', $partnerId);
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
        ->when(!empty($partnerId), function ($query) use ($partnerId) {
          $query->where('approver', $partnerId);
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
        ->when(!empty($partnerId), function ($query) use ($partnerId) {
          $query->where('createdby', $partnerId);
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

      // filter Chart, Budget vs Actual Cash Flow

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
        // ->when(!empty($partnerId), function ($query) use ($partnerId) {hide from UI
        //   $query->where('assignmentmappings.leadpartner', $partnerId);
        // })
        ->groupBy('year', 'month')
        ->orderByRaw("FIELD(month, 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December', 'January', 'February', 'March')")
        ->get();

      //  Budget vs Actual Cash Flow end hare 


      // filter Chart, Budget vs Actual P&L
      $budgetRevenueandbudgetExpences = DB::table('assignmentmappings')
        ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, SUM(engagementfee) as engagementfee, SUM(teamestcost) as total_teamestcost')
        ->whereBetween('created_at', [$startDateFormatted, $endDateFormatted])
        ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
          $query->whereMonth('created_at', $monthsdigit);
        })
        ->when(!empty($partnerId), function ($query) use ($partnerId) {
          $query->where('leadpartner', $partnerId);
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
        ->when(!empty($partnerId), function ($query) use ($partnerId) {
          $query->where('partner', $partnerId);
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
        ->when(!empty($partnerId), function ($query) use ($partnerId) {
          $query->where('timesheetusers.partner', $partnerId);
        })
        ->groupByRaw('MONTH(timesheets.date), YEAR(timesheets.date)')
        ->get()
        ->map(function ($item) use ($monthNames) {
          $item->month = $monthNames[$item->month] ?? $item->month;
          return $item;
        });

      // Budget vs Actual P&L end hare 


      // filter Chart, Lap Days Analysis (Assignment to Invoice)
      $assignmentsWithInvoices = DB::table('assignmentmappings')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        // get only those assignments for which an invoice has been created
        ->join('invoices', 'invoices.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->selectRaw('MONTH(assignmentbudgetings.otpverifydate) as month, YEAR(assignmentbudgetings.otpverifydate) as year, assignmentbudgetings.otpverifydate, invoices.created_at as invoice_created_at, invoices.id as invoice_id')
        ->whereBetween('assignmentbudgetings.otpverifydate', [$startDateFormatted, $endDateFormatted])
        ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
          $query->whereMonth('assignmentbudgetings.otpverifydate', $monthsdigit);
        })
        ->when(!empty($partnerId), function ($query) use ($partnerId) {
          $query->where('assignmentmappings.leadpartner', $partnerId);
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


      // filter Chart, Invoice Due vs Assignment Billing vs Cash Recovery
      $assignmentBillingdata = DB::table('invoices')
        ->selectRaw("MONTH(created_at) as month, YEAR(created_at) as year, invoices.currency, DATE_FORMAT(invoices.created_at, '%Y-%m-%d') as bill_date, SUM(total) as total_amount")
        ->whereBetween('created_at', [$startDateFormatted, $endDateFormatted])
        ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
          $query->whereMonth('created_at', $monthsdigit);
        })
        ->when(!empty($partnerId), function ($query) use ($partnerId) {
          $query->where('partner', $partnerId);
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
        ->when(!empty($partnerId), function ($query) use ($partnerId) {
          $query->where('Partner', $partnerId);
        })
        ->groupByRaw('MONTH(created_at), YEAR(created_at)')
        ->orderByRaw('FIELD(MONTH(created_at),  4,5,6,7,8,9,10,11,12,1,2,3)')
        ->get()
        ->map(function ($item) use ($monthNames) {
          $item->month = $monthNames[$item->month] ?? $item->month;
          return $item;
        });

      $cashRecovery = DB::table('payments')
        ->leftJoin('invoices', 'invoices.invoice_id', '=', 'payments.invoiceid')
        ->selectRaw('MONTH(paymentdate) as month, YEAR(paymentdate) as year, SUM(amountreceived) as amountreceived')
        ->whereBetween('paymentdate', [$startDateFormatted, $endDateFormatted])
        ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
          $query->whereMonth('paymentdate', $monthsdigit);
        })
        ->when(!empty($partnerId), function ($query) use ($partnerId) {
          $query->where('invoices.partner', $partnerId);
        })
        ->groupByRaw('MONTH(paymentdate), YEAR(paymentdate)')
        ->orderByRaw('FIELD(MONTH(paymentdate), 4,5,6,7,8,9,10,11,12,1,2,3)')
        ->get()
        ->map(function ($item) use ($monthNames) {
          $item->month = $monthNames[$item->month] ?? $item->month;
          return $item;
        });

      // filter Chart,  Staff Allocation vs Actual Timesheet Analysis
      $teamAllocatedHours = DB::table('timesheetusers')
        ->join('teammembers', 'teammembers.id', '=', 'timesheetusers.createdby')
        // ->whereIn('teammembers.id', [14, 23, 187, 305, 659, 815])
        // ->whereNotIn('teammembers.role_id', [13])
        ->whereBetween('timesheetusers.created_at', [$startDateFormatted, $endDateFormatted])
        ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
          $query->whereMonth('timesheetusers.created_at', $monthsdigit);
        })
        ->when(!empty($partnerId), function ($query) use ($partnerId) {
          $query->where('timesheetusers.partner', $partnerId);
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
            // ->when(!empty($partnerId), function ($query) use ($partnerId) {
            //   $query->where('assignmentmappings.leadpartner', $partnerId);
            // })
            ->sum('assignmentmappings.eqcresthour');

          $allocatedHours2 = DB::table('assignmentmappings')
            ->where('assignmentmappings.leadpartner', $teamAllocatedHour->teammember_id)
            ->whereBetween('assignmentmappings.created_at', [$startDateFormatted, $endDateFormatted])
            ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
              $query->whereMonth('assignmentmappings.created_at', $monthsdigit);
            })
            // ->when(!empty($partnerId), function ($query) use ($partnerId) {
            //   $query->where('assignmentmappings.leadpartner', $partnerId);
            // })
            ->sum('assignmentmappings.partneresthour');

          $allocatedHours3 = DB::table('assignmentmappings')
            ->where('assignmentmappings.otherpartner', $teamAllocatedHour->teammember_id)
            ->whereBetween('assignmentmappings.created_at', [$startDateFormatted, $endDateFormatted])
            ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
              $query->whereMonth('assignmentmappings.created_at', $monthsdigit);
            })
            // ->when(!empty($partnerId), function ($query) use ($partnerId) {
            //   $query->where('assignmentmappings.leadpartner', $partnerId);
            // })
            ->sum('assignmentmappings.otherpartneresthour');

          $allocatedHours = $allocatedHours1 + $allocatedHours2 + $allocatedHours3;
        } else {
          $allocatedHours = DB::table('assignmentmappings')
            ->leftJoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
            ->where('assignmentteammappings.teammember_id', $teamAllocatedHour->teammember_id)
            ->whereBetween('assignmentteammappings.created_at', [$startDateFormatted, $endDateFormatted])
            ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
              $query->whereMonth('assignmentteammappings.created_at', $monthsdigit);
            })
            ->when(!empty($partnerId), function ($query) use ($partnerId) {
              $query->where('assignmentmappings.leadpartner', $partnerId);
            })
            ->sum('assignmentteammappings.teamesthour');
        }

        if (is_null($allocatedHours)) {
          $allocatedHours = 0;
        }
        $teamAllocatedHour->teamallocatedhours = $allocatedHours;
        $teamAllocatedHour->discrepancy = $teamAllocatedHour->actualhours - (float) $allocatedHours;
      }


      // filter Chart, Fetch IT and Finance Tickets or Unresolved Tickets - HR, IT & Admin
      $ticketDatas = Assetticket::with(['financerequest', 'createdBy', 'partner'])
        ->whereIn('type', [0, 1])
        ->whereBetween('created_at', [$startDateFormatted, $endDateFormatted])
        ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
          $query->whereMonth('created_at', $monthsdigit);
        })
        ->when(!empty($partnerId), function ($query) use ($partnerId) {
          $query->where('partner_id', $partnerId);
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
        ->when(!empty($partnerId), function ($query) use ($partnerId) {
          $query->where('tasks.partner_id', $partnerId);
        })
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

      $financialYears = array_reverse($financialYears);

      $partnerlist = Teammember::where('status', 1)
        ->where('role_id', 13)
        ->with('title')
        ->orderBy('team_member', 'asc')
        ->get();

      $request->flash();

      // filter data end hare 
      return view('backEnd.kgsdashboardreport', compact('monthsdigit', 'yearly', 'partnerId', 'partnerlist', 'budgetactualcash', 'financialYears', 'workFromHome', 'budgetRevenueandbudgetExpences', 'budgetActualRevenue', 'budgetActualExpences', 'assignmentsWithInvoices', 'assignmentBilling', 'assignmentOutstanding', 'cashRecovery', 'cashFlowtotalspendData', 'cashFlowRecieved', 'teamexceptionalExpenses', 'teamsSalaries', 'teamAllocatedHours', 'timesheetOnClosedAssignment', 'totalNotFilled', 'partnerWiseProfit', 'lossMakingCount', 'billspending15Days', 'totalUpcomingAssignments', 'assignmentprofitandlosses', 'allTickets', 'hrTickets', 'ticketDatas', 'highpriorityAssignments', 'ecqrAudits', 'documentCompletions', 'assignmentOverviews',  'exceptionalExpenses', 'auditsDue', 'tendersSubmittedCount', 'delayedAssignments', 'assignmentcompleted', 'billspendingforcollection', 'billspending'));
    }
  }




  public  function convertusdtoinr($usdAmountconvert)
  {

    $totalamountInr = 0;
    $totalUsdamount = 0;
    foreach ($usdAmountconvert as $bill) {

      if ($bill->currency == 3 || is_null($bill->currency)) {
        // INR amount added
        $totalamountInr += $bill->total_amount;
      } elseif ($bill->currency == 1) {
        // Get USD rate for that bill date
        $response = Http::get("https://api.frankfurter.app/{$bill->bill_date}", [
          'from' => 'USD',
          'to' => 'INR'
        ]);

        $rate = $response->successful()
          ? ($response->json()['rates']['INR'] ?? 0)
          : 0;
        $totalUsdamount += $bill->total_amount * $rate;
        // dd($bill, $rate, $totalUsdamount);
      }
    }

    return round($totalamountInr + $totalUsdamount, 2);
  }

  public function convertusdtoinr1($usdAmountconvert)
  {
    return $usdAmountconvert->map(function ($bill) {
      if ($bill->currency == 3 || is_null($bill->currency)) {
        $bill->total_amount = round($bill->total_amount, 2);
      } elseif ($bill->currency == 1) {
        // USD to INR 
        $response = Http::get("https://api.frankfurter.app/{$bill->bill_date}", [
          'from' => 'USD',
          'to' => 'INR'
        ]);

        $rate = $response->successful()
          ? ($response->json()['rates']['INR'] ?? 0)
          : 0;

        $bill->total_amount = round($bill->total_amount * $rate, 2);
      }
      return $bill;
    });
  }

  public function profileImage($id)
  {
    $userInfo = Teammember::where('id', $id)->first();
    return view('backEnd.profileimage', compact('userInfo'));
  }
  public function ticketIndex($id)
  {
    $ticket =  DB::table('assets')
      ->leftjoin('financerequests', 'financerequests.id', 'assets.financerequest_id')->where('assets.id', $id)->select(
        'assets.id',
        'financerequests.modal_name',
        'financerequests.sno',
        'financerequests.kgs',
        'financerequests.description'
      )->first();

    return view('backEnd.generateticket', compact('id', 'ticket'));
  }
  public function userProfile($id)
  {
    $userid = auth()->user()->id;
    $teammemberid = User::where('id', $userid)->pluck('teammember_id')->first();
    // dd($userid);
    $asset = Asset::where('teammember_id', $teammemberid)->first();
    $title = Title::latest()->get();
    $userInfo = Teammember::where('id', $teammemberid)->first();
    $assetticket = Assetticket::where('created_by', $userid)->get();
    $teamprofile = DB::table('teamprofiles')->where('teammember_id', auth()->user()->teammember_id)->first();
    return view('backEnd.userprofile', compact('userInfo', 'title', 'asset', 'assetticket', 'teamprofile'));
  }
  public function update(Request $request)
  {
    //  dd(date('Y-m-d', strtotime($request->dateofbirth)));
    //   $request->validate([
    //     'team_member' => "required",
    //   'mobile_no' => "required|numeric",

    // 'team_member' => "required"
    //  ]);
    try {
      $data = $request->except(['_token']);

      if ($request->hasFile('aadharupload')) {
        $file = $request->file('aadharupload');
        $name = time() . $file->getClientOriginalName();
        $path = $file->storeAs('candidateonboarding', $name, 's3');
        $data['aadharupload'] = $name;
      }
      if ($request->hasFile('nda')) {
        $file = $request->file('nda');
        $destinationPath = 'backEnd/image/teammember/nda';
        $name = time() . $file->getClientOriginalName();
        $s = $file->move($destinationPath, $name);
        //  dd($s); die;
        $data['nda'] = $name;
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
        $file = $request->file('profilepic');
        $name = time() . $file->getClientOriginalName();
        $path = $file->storeAs('candidateonboarding', $name, 's3');
        $data['profilepic'] = $name;
      }
      if ($request->hasFile('panupload')) {
        $file = $request->file('panupload');
        $name = time() . $file->getClientOriginalName();
        $path = $file->storeAs('candidateonboarding', $name, 's3');
        $data['panupload'] = $name;
      }
      if ($request->hasFile('addressupload')) {
        $file = $request->file('addressupload');
        $destinationPath = 'backEnd/image/teammember/addressupload';
        $name = $file->getClientOriginalName();
        $s = $file->move($destinationPath, $name);
        //  dd($s); die;
        $data['addressupload'] = $name;
      }
      $ids = auth()->user()->teammember_id;
      //   dd($ids);
      //       $teammemberid = User::where('id',$ids)->pluck('teammember_id')->first();
      //    //   dd($teammemberid);
      $data['dateofbirth'] = date('Y-m-d', strtotime($request->dateofbirth));
      Teammember::find($ids)->update($data);
      $output = array('msg' => 'Updated Successfully');
      return back()->with('success', $output);
    } catch (Exception $e) {
      DB::rollBack();
      Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
      report($e);
      $output = array('msg' => $e->getMessage());
      return back()->withErrors($output)->withInput();
    }
  }
  public function activityLog()
  {
    $cutoffDate = Carbon::now()->subMonths(3);
    // Delete records older than the cutoff date
    DB::table('activitylogs')->where('created_at', '<', $cutoffDate)->delete();

    $employeename = Teammember::where('role_id', '!=', 11)->where('status', 1)
      ->with('title', 'role')->get();

    $currentDate = date('Y-m-d');

    $activitylogDatas = DB::table('activitylogs')
      ->leftJoin('teammembers', 'teammembers.id', '=', 'activitylogs.user_id')
      ->leftJoin('roles', 'roles.id', '=', 'teammembers.role_id')
      //      ->leftJoin('activitytitles', 'activitytitles.id', '=', 'activitylogs.activity_title_id') // Assuming the relationship is named 'activityTitle'
      ->whereDate('activitylogs.created_at', $currentDate)
      ->select('activitylogs.*', 'teammembers.team_member', 'roles.rolename') // Include 'activitytitles.activitytitle'
      ->latest()
      ->get();
    //dd($activitylogDatas);
    // Extract the activity title names into an array
    $modulename = DB::table('activitylogs')->distinct()
      ->pluck('activitytitle')
      ->toArray();
    //dd($modulename);
    return view('backEnd.activitylog.useractivity', compact('employeename', 'activitylogDatas', 'modulename'));
  }

  public function Activityfiltersection(Request $request)
  {
    $modulename = $request->modulename;
    $employeeId = (int) $request->employeeid;
    $Date = $request->date;
    $DateRange = $request->dateRange;

    if ($request->ajax()) {
      $query = DB::table('activitylogs')
        ->leftJoin('teammembers', 'teammembers.id', '=', 'activitylogs.user_id')
        ->when($modulename, function ($query) use ($modulename) {
          return $query->where('activitylogs.activitytitle', $modulename);
        })
        ->when($employeeId, function ($query) use ($employeeId) {
          return $query->where('activitylogs.user_id', $employeeId);
        })
        ->when($Date, function ($query) use ($Date) {
          return $query->whereDate('activitylogs.created_at', $Date);
        })
        ->when($DateRange, function ($query) use ($DateRange) {
          $now = now();
          switch ($DateRange) {
            case 'weekly':
              $endOfWeek = $now->endOfWeek();
              $weekly = date('Y-m-d', strtotime($endOfWeek));
              $startOfWeek = $now->startOfWeek();
              return $query->whereBetween('activitylogs.created_at', [$startOfWeek, $weekly]);
            case 'monthly':
              $endOfMonth = $now->endOfMonth();
              $month = date('Y-m-d', strtotime($endOfMonth));
              $startOfMonth = $now->startOfMonth();
              return $query->whereBetween('activitylogs.created_at', [$startOfMonth, $month]);
            case 'quarterly':
              $endOfQuarter = $now->endOfQuarter();
              $quarter = date('Y-m-d', strtotime($endOfQuarter));
              $startOfQuarter = $now->startOfQuarter();
              return $query->whereBetween('activitylogs.created_at', [$startOfQuarter, $quarter]);
            case 'yearly':
              $endOfYear = $now->endOfYear();
              $year = date('Y-m-d', strtotime($endOfYear));
              $startOfYear = $now->startOfYear();
              return $query->whereBetween('activitylogs.created_at', [$startOfYear, $year]);
            default:
              return $query; // No date range selected, do nothing
          }
        });

      $query->orderBy('activitylogs.id', 'DESC');
      $userActivityData = $query->select(
        'teammembers.team_member',
        'activitylogs.activitytitle',
        'activitylogs.description',
        'activitylogs.ip_address',
        'activitylogs.created_at'
      )->get();

      return response()->json([
        'data' => $userActivityData,
      ]);
    }
  }
  public function userLog()
  {
    $cutoffDate = Carbon::now()->subMonths(3);
    // Delete records older than the cutoff date
    DB::table('userloginactiviteies')->where('created_at', '<', $cutoffDate)->delete();

    $userlogDatas = DB::table('userloginactiviteies')
      ->leftjoin('teammembers', 'teammembers.id', 'userloginactiviteies.teammember_id')
      ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
      ->select('userloginactiviteies.*', 'teammembers.team_member', 'roles.rolename')->latest()->get();

    return view('backEnd.userloginlog.index', compact('userlogDatas'));
  }
}
