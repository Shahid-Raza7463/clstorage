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

class KrasController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */

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

class KrasController extends Controller
{

2222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222
app\Http\Controllers\BackEndController.php

  public function appointmentletter()
  {
    $teammember = DB::table('staffappointmentletters')
      ->leftjoin('teammembers', 'teammembers.id', 'staffappointmentletters.teammember_id')
      ->where('teammember_id', auth()->user()->teammember_id)
      ->select('staffappointmentletters.*', 'teammembers.team_member', 'teammembers.permanentaddress', 'teammembers.communicationaddress', 'teammembers.pancardno', 'teammembers.fathername', 'teammembers.joining_date')->first();

    // dd($teammember);
    return view('backEnd.appointmentletter', compact('teammember'));
  }
  
  
    <a style="color: white" id="editCompany" data-id="{{ $authid }}"
                                        data-toggle="modal" class="btn btn-success"
                                        data-target="#exampleModal1">Acknowledge</a>
										
										
										
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script>
            $(function() {
                $('body').on('click', '#editCompany', function(event) {
                    //        debugger;
                    var id = $(this).data('id');
                    debugger;
                    $.ajax({
                        type: "GET",

                        url: "{{ url('authotp') }}",
                        data: "id=" + id,
                        success: function(response) {
                            // alert(res);
                            debugger;
                            $("#id").val(response.id);


                        },
                        error: function() {

                        },
                    });
                });
            });
        </script>
		
		
		
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
          $dbRes = DB::table('staffappointmentletters')->where('teammember_id', auth()->user()->teammember_id)->update([
            'otp' => $otpap,
          ]);
        }

        return response()->json($dbRes);
      }
    }
  }
  
  
  http://127.0.0.1:8000/staffappointmentletter



app\Http\Controllers\StaffappointmentletterController.php


public function index()
  {
    // Store the authenticated user
    $user = auth()->user();

    // Array of allowed teammember IDs
    $allowedTeamMemberIds = [160, 812, 156, 155, 447, 556, 708, 336];

    if (in_array($user->teammember_id, $allowedTeamMemberIds)) {
      $staffappointmentData = DB::table('staffappointmentletters')
        ->leftjoin('teammembers', 'teammembers.id', 'staffappointmentletters.teammember_id')
        ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
        ->leftjoin('companydetails', 'companydetails.id', 'staffappointmentletters.organization')
        ->select(
          'staffappointmentletters.*',
          'teammembers.team_member',
          'teammembers.emailid',
          'roles.rolename',
          'companydetails.company_name'
        )->get();


      $activitylogDatas = DB::table('activitylogs')
        ->leftJoin('teammembers', 'teammembers.id', '=', 'activitylogs.user_id')
        ->leftJoin('roles', 'roles.id', '=', 'teammembers.role_id')
        ->whereIn('activitylogs.activitytitle', ['Appointment Letter Create', 'Appointment Letter Updated', 'E-Verify Appointment Letter'])
        ->select('activitylogs.*', 'teammembers.team_member', 'roles.rolename')
        ->latest()
        ->get();

      return view('backEnd.staffappointmentletter.index', compact('staffappointmentData', 'activitylogDatas'));
    }

    abort(403, ' you have no permission to access this page ');
  }
  
  

  
  
resources\views\backEnd\staffappointmentletter\index.blade.php


                                    <td>
                                        @if (auth()->user()->teammember_id == 156)
                                            @if ($staffappointmentDatas->otp == null)
                                                @if ($staffappointmentDatas->e_verify == 0)
                                                    @if ($staffappointmentDatas->reject_reason)
                                                        <span class="badge badge-danger">Rejected</span>
                                                    @else
                                                        <a href="{{ url('staffappointmentletter/mailverify', $staffappointmentDatas->id) }}"
                                                            class="btn btn-success">Approve</a>
                                                        <a href="#" data-toggle="modal" data-target="#rejectModal"
                                                            data-id="{{ $staffappointmentDatas->id }}"
                                                            class="btn btn-danger">Reject</a>
                                                    @endif
                                                @else
                                                    <span class="badge badge-primary">Sent</span>
                                                @endif
                                            @else
                                                <span class="badge badge-success">Acknowledged</span>
                                            @endif
                                        @else
                                            @if ($staffappointmentDatas->otp == null)
                                                @if ($staffappointmentDatas->e_verify == 0)
                                                    @if ($staffappointmentDatas->reject_reason)
                                                        <span class="badge badge-danger">Rejected</span>
                                                    @else
                                                        <span class="badge badge-warning">Pending for aprroval</span>
                                                    @endif
                                                @else
                                                    <span class="badge badge-primary">Sent</span>
                                                @endif
                                            @else
                                                <span class="badge badge-success">Acknowledged</span>
                                            @endif
                                        @endif
                                    </td>


app\Http\Controllers\StaffappointmentletterController.php

 public function mailVerify(Request $request)
  {
    //if ($request->ajax()) {
    // dd($request);
    $staffappointment = DB::table('staffappointmentletters')
      ->leftjoin('teammembers', 'teammembers.id', 'staffappointmentletters.teammember_id')
      ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
      ->leftjoin('companydetails', 'companydetails.id', 'staffappointmentletters.organization')
      ->where('staffappointmentletters.id', $request->id)
      ->select('staffappointmentletters.*', 'teammembers.team_member', 'teammembers.emailid', 'roles.rolename', 'companydetails.company_name')->first();

    // dd($staffappointmentData);
    $data = array(
      'teammember' => $staffappointment->emailid ?? '',
      'name'        => $staffappointment->team_member ?? '',
      'id' => $staffappointment->teammember_id ?? ''
    );


    Mail::send('emails.StaffappointmentletterMail', $data, function ($msg) use ($data) {
      $msg->to($data['teammember']);
      $msg->cc(['hr@kgsomani.com']);
      $msg->subject('E-Verify | Appointment Letter');
    });

    DB::table('staffappointmentletters')->where('id', $request->id)->update(['e_verify' => 1]);


    DB::table('teammembers')->where('id', $staffappointment->teammember_id)->update([
      'monthly_gross_salary' => $staffappointment->salary
    ]);


    $user = DB::table('users')->where('teammember_id', $staffappointment->teammember_id)->first();
    //dd( $user);
    if ($user == Null) {


      $memberid = Teammember::where('id', $staffappointment->teammember_id)->first();
      //dd( $memberid);
      $pass = Str::random(10) . '@2025';



      $pass = Str::random(10) . '@2025';

      DB::table('users')->insert([
        'password'         =>     Hash::make($pass),
        'email' => $memberid->emailid,
        'teammember_id'     => $memberid->id,
        'role_id' => $memberid->role_id,
        'status' => 1,
      ]);

      DB::table('teammembers')->where('id', $memberid->id)->update([
        'status'         =>     '1',
        'updated_at' => date('y-m-d')
      ]);

      $teammember = Teammember::where('id', $staffappointment->teammember_id)->first();
      $data = array(
        'email' => $teammember->emailid ?? '',
        'name' => $teammember->team_member ?? '',
        'password' => $pass ?? '',
      );
      // dd($request->teammember_id);
      Mail::send('emails.teamlogin', $data, function ($msg) use ($data) {
        $msg->to($data['email']);
        $msg->subject('CAPITALL LOGIN CREDENTIALS');
        // $msg->cc($data['teammembermail']);
      });
    }

    $output = array('msg' => 'Mail Send Successfully');
    return Redirect::back()->with('success', $output);



    // }

  }
  
  
  app\Http\Controllers\BackEndController.php
  
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
          $msg->to(['priyankasharma@kgsomani.com']);
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


}
}
