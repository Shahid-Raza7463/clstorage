<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Mail;

class AssignmentconfirmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function teamConfirm(Request $request)
    {
        //  dd($request);
        if ($request->status == 1) {
            $assignmentDatas = DB::table('assignmentteammappings')
                ->where('teammember_id', $request->teammemberid)->where('assignmentmapping_id', $request->assignmentmappingid)->update([
                    'status'         => $request->status,
                    'updated_at'         =>   date("Y-m-d")
                ]);

            return view('backEnd.teamconfirm');
        } else {
            $assignmentDatas = DB::table('assignmentteammappings')
                ->where('teammember_id', $request->teammemberid)->where('assignmentmapping_id', $request->assignmentmappingid)->update([
                    'status'         => $request->status,
                    'updated_at'         =>   date("Y-m-d")
                ]);

            return view('backEnd.teamreject');
        }
    }

    public function debtorconfirm(Request $request)
    {
        // Goes to confirmation page 
        if ($request->status == 1) {
            $usermail = DB::table('debtors')->where('id', $request->debtorid)->first();

            if ($request->status == $usermail->status || $usermail->status == 0) {
                return back()->withErrors(['error' => 'You have allready Submitted'])->withInput();
            }

            $assignmentDatas = DB::table('debtors')
                ->where('assignmentgenerate_id', $request->clientid)->where('id', $request->debtorid)->update([
                    'status'         => $request->status,
                    'updated_at'         =>   date("Y-m-d")
                ]);

            return view('backEnd.teamconfirm');
        } else {
            $usermail = DB::table('debtors')->where('id', $request->debtorid)->first();
            if ($request->status == $usermail->status || $usermail->status == 1) {
                return back()->withErrors(['error' => 'You have allready Submitted'])->withInput();
            }
            // dd('hi2');
            // $assignmentDatas = DB::table('debtors')
            //     ->where('assignmentgenerate_id', $request->clientid)->where('id', $request->debtorid)->update([
            //         'status'         => $request->status,
            //         'updated_at'         =>   date("Y-m-d")
            //     ]);
            // $status = DB::table('debtors')
            //     ->where('assignmentgenerate_id', $request->clientid)->where('id', $request->debtorid)->pluck('type')->first();
            // dd($status);
            $debtorconfirm = DB::table('debtorconfirmations')
                ->where('assignmentgenerate_id', $request->clientid)->where('debtor_id', $request->debtorid)->first();
            $clientid = $request->clientid;
            $debtorid = $request->debtorid;
            $status = $request->status;
            return view('backEnd.teamreject', compact('status', 'clientid', 'debtorid', 'debtorconfirm'));
        }
    }

    public function confirmationConfirm(Request $request)
    {
        // dd($request);
        $request->validate([
            'amount' => "required",
            // 'remark' => "required|string"
        ]);

        try {
            $debtorconfirm = DB::table('debtors')
                ->where('assignmentgenerate_id', $request->clientid)->where('id', $request->debtorid)->first();
            if ($request->hasFile('file')) {

                $file = $request->file('file');
                $destinationPath = 'backEnd/image/confirmationfile';
                $name = $file->getClientOriginalName();
                $s = $file->move($destinationPath, $name);
                $data['file'] = $name;
            }
            DB::table('debtorconfirmations')->insert([
                'debtor_id'         => $request->debtorid,
                'assignmentgenerate_id' => $request->clientid,
                'remark'         => $request->remark,
                'amount'         => $request->amount,
                'file'         =>  $data['file'] ?? '',
                'name'         =>  $debtorconfirm->name,
                'created_at'         =>   date("Y-m-d"),
                'updated_at'         =>   date("Y-m-d")
            ]);

            $assignmentDatas = DB::table('debtors')
                ->where('assignmentgenerate_id', $request->clientid)->where('id', $request->debtorid)->update([
                    'status'         => $request->status,
                    'updated_at'         =>   date("Y-m-d")
                ]);
            // $output = array('msg' => 'Submit Successfully');
            // return back()->with('success', $output);
            return view('backEnd.teamconfirm');
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }
}
