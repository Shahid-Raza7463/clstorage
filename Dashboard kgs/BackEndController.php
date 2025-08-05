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
          $dbRes = DB::table('staffappointmentletters')->where('teammember_id', auth()->user()->teammember_id)->where('final_status', 1)
            ->update([
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


  public function index()
  {

    // How many amounts pending for invoice genrated
    $billspending = DB::table('assignmentmappings')
      ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
      ->leftJoin('invoices', 'invoices.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
      ->whereNull('invoices.assignmentgenerate_id')
      ->where('assignmentbudgetings.status', 0)
      ->sum('assignmentmappings.engagementfee');

    // How many amounts pending for collection
    $billspendingforcollection = DB::table('assignmentmappings')
      ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
      ->leftJoin('invoices', 'invoices.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
      ->leftJoin('payments', 'payments.invoiceid', '=', 'invoices.invoice_id')
      // ensures invoice is created
      ->whereNotNull('invoices.id')
      // Payment not yet received
      ->whereNull('payments.invoiceid')
      ->where('assignmentbudgetings.status', 0)
      ->sum('invoices.total');

    // How many assignments completed in this months
    $assignmentcompleted = DB::table('assignmentmappings')
      ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
      ->where('assignmentbudgetings.status', 0)
      ->whereMonth('assignmentbudgetings.otpverifydate', Carbon::now()->month)
      ->whereYear('assignmentbudgetings.otpverifydate', Carbon::now()->year)
      ->count();

    // How many delayed Assignments
    $delayedAssignments = DB::table('assignmentmappings')
      ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
      ->where('assignmentbudgetings.status', 1)
      ->whereRaw('COALESCE(DATE(assignmentbudgetings.actualenddate), DATE(assignmentbudgetings.tentativeenddate)) < ?', [Carbon::today()->toDateString()])
      ->count();

    // How many tender submitted this months
    $tendersSubmittedCount = DB::table('tenders')
      ->where('tendersubmitstatus', 1)
      ->whereMonth('date', Carbon::now()->month)
      ->whereYear('date', Carbon::now()->year)
      ->count();

    // How many NAFRA are running
    $auditsDue = DB::table('assignmentmappings')
      ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
      ->where('assignmentbudgetings.status', 1)
      ->where('assignmentmappings.eqcrapplicability', 1)
      ->count();

    // total amount of convence, how many amount approved for convence in this months 
    $exceptionalExpenses = DB::table('outstationconveyances')
      ->where('outstationconveyances.status', 1)
      ->whereMonth('outstationconveyances.approveddate', Carbon::now()->month)
      ->whereYear('outstationconveyances.approveddate', Carbon::now()->year)
      ->sum('outstationconveyances.finalamount');

    // how many users not accepted independance mail till now
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

    // Assignment Status Overview
    $assignmentOverviews = DB::table('assignmentmappings')
      ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
      ->leftJoin('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
      // ->where('assignmentbudgetings.status', 1)
      ->orderByDesc('assignmentbudgetings.id')
      ->select(
        'assignmentmappings.*',
        'assignmentbudgetings.assignmentname',
        'assignmentbudgetings.status',
        DB::raw('COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate) as finalassignmentenddate'),
        'clients.client_name'
      )
      // ->limit(3)
      ->get();

    // dd($assignmentOverviews);

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


    // ECQR Audits & Quality Reviews
    $ecqrAudits = DB::table('assignmentmappings')
      ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
      ->leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.eqcrpartner')
      ->leftJoin('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
      // ->where('assignmentbudgetings.status', 1)
      ->where('assignmentmappings.eqcrapplicability', 1)
      ->select(
        'assignmentmappings.*',
        'teammembers.team_member',
        'assignmentbudgetings.assignmentname',
        'assignmentbudgetings.status',
        DB::raw('COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate) as finalassignmentenddate'),
        'clients.client_name'
      )
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


    // Unresolved Tickets - HR, IT & Admin
    // $ticketDatas = Assetticket::with(['financerequest', 'createdBy', 'partner'])
    //   ->whereIn('type', [0, 1])
    //   ->limit(4)
    //   ->get();


    // $hrTickets = DB::table('tasks')
    //   ->select(
    //     'tasks.*',
    //     'patnerid.team_member as partnername',
    //     'createdby.team_member as createdbyname',
    //     'hrfunctions.hrfunction'
    //   )
    //   ->where('tasks.task_type', 4)
    //   ->leftJoin('teammembers as patnerid', 'patnerid.id', '=', 'tasks.partner_id')
    //   ->leftJoin('teammembers as createdby', 'createdby.id', '=', 'tasks.createdby')
    //   ->leftJoin('hrfunctions', 'hrfunctions.id', '=', 'tasks.hrfunction')
    //   ->limit(4)
    //   ->get();

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

    // Assignment-wise P&L Analysis
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
      // ->limit(3)engagementfee
      ->get();

    // Upcoming Assignment
    $assignmentgenerateId = DB::table('assignmentmappings')->pluck('assignmentgenerate_id');
    $upcomingAssignments = DB::table('assignmentbudgetings')
      ->whereNotIn('assignmentgenerate_id', $assignmentgenerateId)
      ->count();

    // How many amounts pending for collection within 15 days
    $billspending15Days = DB::table('assignmentmappings')
      ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
      ->leftJoin('invoices', 'invoices.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
      ->leftJoin('payments', 'payments.invoiceid', '=', 'invoices.invoice_id')
      ->whereNotNull('invoices.id') // Invoice is created
      ->whereNull('payments.invoiceid') // Payment not yet received
      ->whereDate('invoices.created_at', '>=', Carbon::today()->subDays(15)) // Only within last 15 days
      ->sum('invoices.total');
    // ->select(
    //   'assignmentmappings.*',
    // )
    // ->get();

    // Timesheet Filled On Closed Assignment
    $timesheetOnClosedAssignment = DB::table('assignmentmappings')
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
      ->get();

    // dd($billspending15Days);





    if (auth()->user()->role_id == 11 || auth()->user()->role_id == 12) {

      return view('backEnd.index', compact('billspending15Days', 'upcomingAssignments', 'assignmentprofitandlosses', 'allTickets', 'hrTickets', 'ticketDatas', 'highpriorityAssignments', 'ecqrAudits', 'documentCompletions', 'assignmentOverviews', 'totalNotFilled', 'exceptionalExpenses', 'auditsDue', 'tendersSubmittedCount', 'delayedAssignments', 'assignmentcompleted', 'billspendingforcollection', 'billspending'));
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
