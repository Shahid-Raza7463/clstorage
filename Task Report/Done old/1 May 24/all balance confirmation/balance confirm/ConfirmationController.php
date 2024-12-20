<?php

namespace App\Http\Controllers;

use App\Models\Debtor;
use App\Models\Teammember;
use App\Models\Client;
use App\Models\Template;
use App\Models\Assignmentbudgeting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use DB;

class ConfirmationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function indexview($assignmentgenerate_id)
    {
        $teammember = Teammember::where('role_id', '=', 15)->orwhere('role_id', '=', 14)->orwhere('role_id', '=', 13)->with('title', 'role')->get();
        $clientList =  Assignmentbudgeting::where('assignmentgenerate_id', $assignmentgenerate_id)->first();

        $clientdebit =  Debtor::with('debtorconfirm')->where('assignmentgenerate_id', $assignmentgenerate_id)->where('type', 1)->get();
        //dd($clientdebit);
        $clientcredit  =  Debtor::with('debtorconfirm')->where('assignmentgenerate_id', $assignmentgenerate_id)->where('type', 2)->get();
        $clientbank =  Debtor::with('debtorconfirm')->where('assignmentgenerate_id', $assignmentgenerate_id)->where('type', 3)->get();
        $debtortemplate =  Template::where('type', '1')->first();

        return view('backEnd.confirmation.index', compact('debtortemplate', 'clientList', 'clientdebit', 'teammember', 'clientcredit', 'clientbank', 'assignmentgenerate_id'));
    }
    public function view($id)
    {
        $debtorconfirmation = DB::table('debtorconfirmations')->where('debtor_id', $id)->get();
        return view('backEnd.confirmation.view', compact('debtorconfirmation'));
    }
    public function template(Request $request)
    {
        if ($request->ajax()) {
            if (isset($request->template_id)) {
                $client = DB::table('templates')->where('type', $request->template_id)->first();

                return response()->json($client);
            }
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backEnd.template.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function mail(Request $request)
    {
        try {
            // dd('send');
            $data = $request->except(['_token']);

            $debtor = DB::table('debtors')->where('assignmentgenerate_id', $request->clientid)->where('type', $request->type)->where('mailstatus', 0)->get();
            //  dd($debtor);
            foreach ($debtor as $debtors) {
                if ($request->teammember_id) {
                    // cc mail
                    $teammembermail = Teammember::wherein('id', $request->teammember_id)->pluck('emailid')->toArray();
                }
                $des = $request->description;
                $healthy = ["[name]", "[amount]", "[year]", "[date]", "[address]"];
                $yummy   = ["$debtors->name", "$debtors->amount", "$debtors->year", "$debtors->date", "$debtors->address"];
                $description = str_replace($healthy, $yummy, $des);

                $data = array(
                    'subject' => $request->subject,
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
                    $msg->subject($data['subject']);

                    if ($request->teammember_id) {
                        $msg->cc($data['teammembermail']);
                    }
                });

                DB::table('debtors')
                    ->where('assignmentgenerate_id', $debtors->assignmentgenerate_id)->where('id', $debtors->id)->update([
                        'mailstatus'         => 1,
                        'status'         => 3,
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
            // dd('hi4');
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

    public function confirmationAccept(Request $request)
    {
        $clientid = $request->clientid;
        $debtorid = $request->debtorid;
        $yes = $request->yes;
        $no = $request->no;

        return view('backEnd.confirmationaccept', compact('clientid', 'debtorid', 'yes', 'no'));
    }


    public function saveMaildraft(Request $request)
    {
        $request->validate([
            'type' => "required",
            'description' => "required"
        ]);
        try {
            $savedraft = DB::table('templates')
                ->where('type', $request->type)
                ->update(['description' => $request->description]);

            $output = array('msg' => 'Mail save as a draft');
            return back()->with('success', $output);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }




    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function show(Template $template)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $template = Template::where('id', $id)->first();
        return view('backEnd.template.edit', compact('id', 'template'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => "required|string",
            'description' => "required",
        ]);
        try {
            $data = $request->except(['_token']);
            Template::find($id)->update($data);
            $output = array('msg' => 'Updated Successfully');
            return redirect('template')->with('success', $output);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function destroy(Template $template)
    {
        //
    }
}
