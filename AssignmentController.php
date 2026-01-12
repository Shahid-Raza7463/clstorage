<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assignment;
use App\Models\Assignmentmapping;
use App\Models\Teammember;
use App\Models\Client;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AssignmentsExport;
use App\Exports\DocumentassigmentExport;
use DB;
use DateTime;
use Illuminate\Support\Facades\Mail;
use Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Cache;


class AssignmentController extends Controller
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
    public function checklist_upload(Request $request)
    {
        // $request->validate([

        // ]);

        try {
            $data = $request->except(['_token']);
            DB::table('auditquestions')->insert([
                'assignmentgenerate_id'       =>     $request->assignmentgenerate_id,
                'steplist_id'       =>     $request->steplist,
                'subclassfied_id'       =>     $request->subclassfied,
                'financialstatemantclassfication_id' =>  $request->financialid,
                'auditprocedure'  => $request->checklist,
                'createdby'  => auth()->user()->teammember_id,
                'created_at'                =>     date('Y-m-d H:i:s'),
                'updated_at'              =>    date('Y-m-d H:i:s'),
            ]);
            $output = array('msg' => 'Question Add Successfully');
            return back()->with('success', $output);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }
    public function assignmentprofitloss()
    {
        $invoiceData =  DB::table('invoices')
            ->leftjoin('clients', 'clients.id', 'invoices.client_id')
            ->leftjoin('teammembers', 'teammembers.id', 'invoices.partner')
            ->join('assignments', 'assignments.id', 'invoices.assignment_id')
            //	->where('invoices.assignment_id',44)
            ->select('invoices.*', 'clients.client_name', 'teammembers.team_member', 'assignments.assignment_name')->orderBy('id', 'desc')->paginate('100');
        //dd($invoiceData);
        return view('backEnd.assignment.assignmentfinalreport', compact('invoiceData'));
    }
    public function assignment_profitloss($id)
    {
        // dd($id);
        if (!in_array(Auth::user()->role_id, [11]) && !in_array(Auth::user()->teammember_id, [156, 160])) {
            abort(403, 'You have no permission to access this page');
        }

        $financialYears = [
            '24-25' => ['start' => '2024-04-01', 'end' => '2025-03-31'],
            '23-24' => ['start' => '2023-04-01', 'end' => '2024-03-31'],
            '22-23' => ['start' => '2022-04-01', 'end' => '2023-03-31'],
        ];

        if (!isset($financialYears[$id])) {
            abort(404, 'Invalid financial year');
        }

        $fyStartDate = $financialYears[$id]['start'];
        $fyEndDate = $financialYears[$id]['end'];

        // Fetch invoice data
        $invoiceData = $this->getInvoiceData($fyStartDate, $fyEndDate);

        // Fetch partners and assignments
        $partner = DB::table('invoices')
            ->leftJoin('teammembers', 'teammembers.id', '=', 'invoices.partner')
            ->select('teammembers.id', 'teammembers.team_member')
            ->where('invoices.financialyear', $id)
            ->distinct('teammembers.id')
            ->get();

        $assignments = DB::table('invoices')
            ->join('assignments', 'assignments.id', '=', 'invoices.assignment_id')
            ->select('assignments.id', 'assignments.assignment_name')
            ->where('invoices.financialyear', $id)
            ->distinct('assignments.id')
            ->get();

        return view('backEnd.assignment.assignmentfinalreport', compact('invoiceData', 'partner', 'id', 'assignments'));
    }

    public function filter_profitloss($id, Request $request)
    {
        if (!in_array(Auth::user()->role_id, [11]) && !in_array(Auth::user()->teammember_id, [156, 160])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $financialYears = [
            '24-25' => ['start' => '2024-04-01', 'end' => '2025-03-31'],
            '23-24' => ['start' => '2023-04-01', 'end' => '2024-03-31'],
            '22-23' => ['start' => '2022-04-01', 'end' => '2023-03-31'],
        ];

        if (!isset($financialYears[$id])) {
            return response()->json(['error' => 'Invalid financial year'], 404);
        }
        $financialYears = [
            '24-25' => ['start' => '2024-04-01', 'end' => '2025-03-31'],
            '23-24' => ['start' => '2023-04-01', 'end' => '2024-03-31'],
            '22-23' => ['start' => '2022-04-01', 'end' => '2023-03-31'],
        ];

        $fyStartDate = $financialYears[$id]['start'];
        $fyEndDate = $financialYears[$id]['end'];

        // Get filter parameters
        $partner = $request->input('partner');
        $assignment = $request->input('assignment');
        $status = $request->input('status');

        // Fetch filtered invoice data
        $invoiceData = $this->getInvoiceData($fyStartDate, $fyEndDate, [
            'partner' => $partner,
            'assignment' => $assignment,
            'status' => $status
        ]);

        return response()->json([
            'data' => $invoiceData
        ]);
    }

    private function getInvoiceData($fyStartDate, $fyEndDate, $filters = [])
    {
        // dd($filters);
        $query = DB::table('assignmentbudgetings')
            ->select(
                'assignmentbudgetings.assignmentgenerate_id',
                'clients.client_name',
                'teammembers.team_member',
                'assignments.assignment_name',
                'assignmentbudgetings.status',
                DB::raw("GROUP_CONCAT(DISTINCT CASE WHEN managers.role_id = 14 THEN managers.team_member END) as managers"),
                DB::raw("GROUP_CONCAT(DISTINCT CASE WHEN managers.role_id = 15 THEN managers.team_member END) as staff")
            )

            ->join('invoices', 'invoices.assignmentgenerate_id', '=', 'assignmentbudgetings.assignmentgenerate_id')
            ->join('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', '=', 'assignmentbudgetings.assignmentgenerate_id')
            ->leftJoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
            ->leftJoin('teammembers as managers', 'managers.id', '=', 'assignmentteammappings.teammember_id')
            ->leftJoin('teammembers', 'teammembers.id', '=', 'invoices.partner')
            ->leftJoin('assignments', 'assignments.id', '=', 'invoices.assignment_id')
            ->leftJoin('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
            ->whereBetween('assignmentbudgetings.periodstartdate', [$fyStartDate, $fyEndDate])
            ->whereBetween('assignmentbudgetings.periodenddate', [$fyStartDate, $fyEndDate])
            ->groupBy(
                'assignmentbudgetings.assignmentgenerate_id',
                'clients.client_name',
                'teammembers.team_member',
                'assignments.assignment_name',
                'assignmentbudgetings.status'
            );

        // Apply filters
        if (!empty($filters['partner'])) {
            $query->WhereIn('invoices.partner', $filters['partner']);
        }
        if (!empty($filters['assignment'])) {
            $query->WhereIn('invoices.assignment_id', $filters['assignment']);
        }
        if (isset($filters['status']) && $filters['status'] !== '') {
            $query->WhereIn('assignmentbudgetings.status', $filters['status']);
        }

        $invoiceData = $query->get();
        // dd($invoiceData);
        // Fetch all invoice totals in bulk
        $invoiceTotals = DB::table('invoices')
            ->select('assignmentgenerate_id', DB::raw('SUM(total) as total'))
            ->whereIn('assignmentgenerate_id', $invoiceData->pluck('assignmentgenerate_id'))
            ->whereNotIn('status', [1, 5, 6])
            ->groupBy('assignmentgenerate_id')
            ->pluck('total', 'assignmentgenerate_id');

        // Fetch all timesheet data in bulk
        $timesheetData = DB::table('timesheetusers')
            ->select('assignmentgenerate_id', 'createdby', DB::raw('SUM(totalhour) as total_hour'))
            ->whereIn('assignmentgenerate_id', $invoiceData->pluck('assignmentgenerate_id'))
            ->groupBy('assignmentgenerate_id', 'createdby')
            ->get();

        // Fetch all team member costs in bulk
        $teamMemberCosts = DB::table('teammembers')
            ->select('id', 'cost_hour')
            ->whereIn('id', $timesheetData->pluck('createdby')->unique())
            ->pluck('cost_hour', 'id');

        // Precompute costs and totals for each invoice
        return $invoiceData->map(function ($invoice) use ($invoiceTotals, $timesheetData, $teamMemberCosts) {
            $invoice->total = $invoiceTotals[$invoice->assignmentgenerate_id] ?? 0;

            $sum = 0;
            foreach ($timesheetData->where('assignmentgenerate_id', $invoice->assignmentgenerate_id) as $costingData) {
                $avgcost = $teamMemberCosts[$costingData->createdby] ?? 0;
                $sum += $costingData->total_hour * $avgcost;
            }

            $invoice->cost = $sum;
            $invoice->profit_loss = $invoice->total - $sum;

            return $invoice;
        });
    }
    public function partnerpandl(Request $request)
    {
        //dd($id);
        $invoiceData =  DB::table('assignmentbudgetings')
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
            ->where('invoices.partner', $request->partners)
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
            ->where('invoices.financialyear', $request->fy)
            ->distinct('assignments.assignment_name')->get();
        $id = $request->fy;
        return view('backEnd.assignment.assignmentfinalreport', compact('invoiceData', 'partner', 'id', 'assignments'));
    }
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
    public function assignmentpartnerlist()
    {
        $assignmentmappingData =  DB::table('assignmentmappings')
            ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
            ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
            ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
            ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
            ->select(
                'assignmentmappings.*',
                'assignmentbudgetings.duedate',
                'assignmentbudgetings.assignmentname',
                'assignments.assignment_name',
                'clients.client_name'
            )->distinct()->get();
        return view('backEnd.assignmentmapping.yearwiseS', compact('assignmentmappingData'));
    }

    public function index()
    {
        $assignmentDatas = Assignment::latest()->get();
        return view('backEnd.assignment.index', compact('assignmentDatas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'assignment_name' => "required"
        ]);

        try {
            $data = $request->except(['_token']);
            $data['assignment_name'] = ucfirst($request->input('assignment_name')); // Capitalize first letter of assignment_name

            $data = Assignment::Create($data);
            $output = array('msg' => 'Assignment Added Successfully');
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
     * @param  \App\Models\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function show(Assignment $assignment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function edit(Assignment $assignment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Assignment $assignment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Assignment::destroy($id);
            $output = array('msg' => 'Deleted Successfully');
            return back()->with('statuss', $output);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }
    public function assignmentotp(Request $request)
    {
        if ($request->ajax() && isset($request->id)) {
            $assignment = DB::table('assignmentmappings')
                ->where('assignmentmappings.assignmentgenerate_id', $request->id)
                ->join('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
                ->join('clients', 'clients.id', 'assignmentbudgetings.client_id')
                ->select('assignmentmappings.*', 'assignmentbudgetings.assignmentname', 'clients.client_name', 'clients.client_code')
                ->first();

            $assignmentteammember = DB::table('assignmentteammappings')
                ->join('teammembers', 'teammembers.id', 'assignmentteammappings.teammember_id')
                ->where('assignmentmapping_id', $assignment->id)
                ->select('teammembers.team_member', 'assignmentteammappings.type')
                ->get();

            $teammembers = DB::table('teammembers')
                ->where('id', auth()->user()->teammember_id)
                ->first();

            $otp = sprintf("%06d", mt_rand(1, 999999));

            DB::table('assignmentbudgetings')
                ->where('assignmentgenerate_id', $assignment->assignmentgenerate_id)
                ->update(['otp' => $otp]);

            $data = array(
                'asassignmentsignmentid' => $assignment->assignmentgenerate_id,
                'assignmentname' => $assignment->assignmentname,
                'client_name' => $assignment->client_name,
                'client_code' => $assignment->client_code,
                'email' => $teammembers->emailid,
                'otp' => $otp,
                'name' => $teammembers->team_member,
                'assignmentteammember' => $assignmentteammember,
            );

            Mail::send('emails.assignmentclosed', $data, function ($msg) use ($data, $assignment) {
                $msg->to($data['email']);
                $msg->subject('Assignment Closed by OTP' . ' || ' . $assignment->assignmentgenerate_id);
            });

            return response()->json($assignment);
        }
    }
    public function assignmentotpstore(Request $request)
    {
        $request->validate([
            'otp' => 'required'
        ]);

        try {
            $data = $request->except(['_token']);

            $otp = DB::table('assignmentbudgetings')
                ->where('otp', $request->otp)
                ->where('assignmentgenerate_id', $request->assignmentgenerateid)->first();


            //    dd($otp);
            if ($otp) {

                DB::table('assignmentbudgetings')
                    ->where('assignmentgenerate_id', $request->assignmentgenerateid)->update([
                        'status' => '0',
                        'closedby'  => auth()->user()->teammember_id,
                        'otpverifydate' => date('Y-m-d H:i:s')
                    ]);


                $invoice = DB::table('invoices')
                    ->where('assignmentgenerate_id', $request->assignmentgenerateid)
                    ->orderByDesc('id')
                    ->first();

                $invoiceexception = DB::table('invoices')
                    ->where('assignmentgenerate_id', $request->assignmentgenerateid)
                    ->where('invoicecategory', 3)
                    ->orderByDesc('id')
                    ->first();

                $assignment = DB::table('assignmentmappings')
                    ->where('assignmentmappings.assignmentgenerate_id', $request->assignmentgenerateid)
                    ->join('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
                    ->join('clients', 'clients.id', 'assignmentbudgetings.client_id')
                    ->select(
                        'assignmentmappings.*',
                        'assignmentbudgetings.assignmentname',
                        'clients.client_name',
                        'clients.client_code',
                        'assignmentbudgetings.actualenddate',
                        'assignmentbudgetings.tentativeenddate',
                        'assignmentbudgetings.assignmentplanningid',
                        'assignmentbudgetings.otpverifydate'
                    )
                    ->first();

                // dd($assignment);

                $assignmentplanning = DB::table('assignmentplannings')->where('id', $assignment->assignmentplanningid)->first();
                //   dd($assignment);
                $periodend = $assignment->actualenddate ?? $assignment->tentativeenddate;

                $otpVerifyDate = new DateTime($assignment->otpverifydate);
                $periodEnd = new DateTime($periodend);

                $interval = $otpVerifyDate->diff($periodEnd);
                $flagdelay = $interval->days; // This will give you the number of days

                // Optional: Check if it's negative or positive
                if ($otpVerifyDate < $periodEnd) {
                    $flagdelay = -$flagdelay;
                }

                $payment = DB::table('payments')->where('invoiceid', $invoice->invoice_id)
                    ->orderByDesc('id')
                    ->first();

                if ($payment && $invoice) {
                    $paymentDate = new DateTime($payment->paymentdate);
                    $invoiceCreated = new DateTime($invoice->created_at);

                    $intervals = $paymentDate->diff($invoiceCreated);
                    $Reportpaymentdelay = $intervals->format('%r%a'); // %r = sign, %a = total days
                } else {
                    $Reportpaymentdelay = null; // or set to '0', or handle it as per your business logic
                }

                if ($invoiceexception) {
                    $ReportExceptions = $invoiceexception->invoice_id;
                } else {
                    $ReportExceptions = null; // or '0', or handle accordingly
                }

                $planningcost = $assignment->engagementfee;
                //   dd($assignmentplanning);
                $convertedcost = $assignment->engagementfee;
                $data = array(
                    'asassignmentsignmentid' => $assignment->assignmentgenerate_id,
                    'assignmentname' => $assignment->assignmentname,
                    'client_name' => $assignment->client_name,
                    'flagdelay' => $flagdelay,
                    'planningcost' => $planningcost,
                    'convertedcost' => $convertedcost,

                    'ReportExceptions' => $ReportExceptions,
                    'Reportpaymentdelay' => $Reportpaymentdelay,
                );

                Mail::send('emails.assignmentclosedreport', $data, function ($msg) use ($data, $assignment) {

                    $subject = 'Assignment Close Report - ' .
                        $data['client_name'] . ' | ' .
                        $data['assignmentname'] . ' | ID: ' .
                        $data['asassignmentsignmentid'];
                    $msg->subject($subject);
                    $msg->to('pooja@capitall.io');
                });



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
    public function archieve($id)
    {
        try {
            DB::table('assignmentbudgetings')
                ->where('assignmentgenerate_id', $id)->update([
                    'status' => '2',
                    'updated_at'              =>    date('Y-m-d H:i:s'),
                ]);
            $output = array('msg' => 'assignment archived successfully');
            return back()->with('success', $output);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }
    public function checkFinalReport(Request $request)
    {
        $assignmentId = $request->assignmentgenerate_id;

        $invoice =  DB::table('invoices')->where('assignmentgenerate_id', $assignmentId)
            ->whereNotNull('finalreportdate')
            ->where('finalreportdate', '!=', '')
            ->first();
        // dd($invoice);

        return response()->json([
            'has_final_report' => !is_null($invoice)
        ]);
    }
    public function documentationstatus()
    {
        // $client = AssignmentMapping::getClientNames();
        // $partners = DB::table('assignmentmappings')
        // ->join('teammembers', 'teammembers.id', '=', 'assignmentmappings.leadpartner')
        // ->select('teammembers.id', 'teammembers.team_member')
        //->distinct()
        //->get();
        $client = Client::where('status', 1)->get();
        $partners = Teammember::where('role_id', 14)->where('status', 1)->get();
        return view('backEnd.assignment.documentationstatus', compact('client', 'partners'));
    }

    public function documentationfilter(Request $request)
    {
        // Get filter parameters
        $fromDate = $request->input('fromdate');
        $toDate = $request->input('todate');
        $status = $request->input('status');
        $searchValue = trim($request->input('search.value', ''));

        // Build the base query with necessary joins
        $query = DB::table('assignmentmappings')
            ->join('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
            ->join('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
            ->join('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
            ->join('assignments', 'assignments.id', '=', 'assignmentmappings.assignment_id')
            ->leftJoin('teammembers as leadpartner', 'leadpartner.id', '=', 'assignmentmappings.leadpartner')
            ->leftJoin('teammembers as otherpartner', 'otherpartner.id', '=', 'assignmentmappings.otherpartner')
            ->select(
                'assignmentmappings.*',
                'assignmentbudgetings.duedate',
                'assignmentbudgetings.draftreportdate',
                'assignmentbudgetings.status as assignmentbudgetingsstatus',
                'assignmentbudgetings.finalreportdate',
                'assignmentbudgetings.moneyreceiveddate',
                'assignmentbudgetings.assignmentname',
                'assignments.assignment_name',
                'clients.client_name',
                'assignmentbudgetings.periodstartdate as periodstart',
                'assignmentbudgetings.periodenddate as periodend',
                'leadpartner.team_member as leadpartner_name',
                'otherpartner.team_member as otherpartner_name'
            )
            ->distinct('assignmentmappings.assignmentgenerate_id');

        //  Apply filters
        if ($request->filled('clientId')) {
            $query->whereIn('assignmentbudgetings.client_id', $request->clientId);
        }

        if ($request->filled('partnerId')) {
            $partnerIds = $request->partnerId;
            $query->where(function ($q) use ($partnerIds) {
                $q->whereIn('assignmentmappings.leadpartner', $partnerIds);
                //   ->orWhereIn('assignmentmappings.otherpartner', $partnerIds)
                //   ->orWhereIn('assignmentmappings.eqcrpartner', $partnerIds);
            });
        }
        // Vendor status filter (but your query doesn’t join vendorlist yet)
        if (isset($status) && ($status === "0" || !empty($status))) {
            $query->whereIn('assignmentbudgetings.status', $status);
        }

        // Date range filters
        if ($fromDate) {
            $query->whereDate('assignmentbudgetings.created_at', '>=', $fromDate);
        }
        if ($toDate) {
            $query->whereDate('assignmentbudgetings.created_at', '<=', $toDate);
        }

        // Get total records before applying search filter
        $totalRecords = $query->count();

        // Apply search filter
        if (!empty($searchValue)) {
            $searchValueLower = '%' . strtolower($searchValue) . '%';
            $query->where(function ($q) use ($searchValueLower) {
                $q->whereRaw('LOWER(assignments.assignment_name) LIKE ?', [$searchValueLower])
                    ->orWhereRaw('LOWER(assignmentbudgetings.assignmentname) LIKE ?', [$searchValueLower])
                    ->orWhereRaw('LOWER(clients.client_name) LIKE ?', [$searchValueLower])
                    ->orWhereRaw('LOWER(leadpartner.team_member) LIKE ?', [$searchValueLower])
                    ->orWhereRaw('LOWER(otherpartner.team_member) LIKE ?', [$searchValueLower])
                    ->orWhereRaw('LOWER(assignmentmappings.assignmentgenerate_id) LIKE ?', [$searchValueLower])
                    ->orWhereRaw('IF(assignmentbudgetings.status = 1, "OPEN", "CLOSED") LIKE ?', [$searchValueLower]);
            });
        }

        // Get filtered records count after applying search filter
        $filteredRecords = $query->count();

        // Apply sorting
        if ($request->has('order')) {
            $order = $request->input('order')[0];
            $columnIndex = $order['column'];
            $direction = $order['dir'];
            $columns = $request->input('columns');
            $columnName = $columns[$columnIndex]['data'];

            // Map DataTable columns to database columns for sorting
            $sortableColumns = [
                'assignmentgenerate_id' => 'assignmentmappings.assignmentgenerate_id',
                'assignment_name' => 'assignments.assignment_name',
                'assignmentname' => 'assignmentbudgetings.assignmentname',
                'client_name' => 'clients.client_name',
                'invoicedate' => 'invoices.invoicedate',
                'periodstart' => 'assignmentbudgetings.periodstartdate',
                'periodend' => 'assignmentbudgetings.periodenddate',
                'leadpartner_name' => 'leadpartner.team_member',
                'otherpartner_name' => 'otherpartner.team_member',
                'assignmentbudgetingsstatus' => 'assignmentbudgetings.status',
            ];

            // Only sort if the column is directly mappable to a database column
            if (isset($sortableColumns[$columnName])) {
                $query->orderBy($sortableColumns[$columnName], $direction);
            }
        }

        if ($request->export_type === 'excel') {
            $assignmentmappingData = $query->get();
        } else {
            // Pagination for DataTables
            $start = $request->input('start', 0);
            $length = $request->input('length', 10);
            $query->skip($start)->take($length);
            $assignmentmappingData = $query->get();
        }

        // Process each record
        foreach ($assignmentmappingData as $mapping) {
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
                $specialAssignment = DB::table('assignments')
                    ->where('assignment_name', $eqcrTypeName)
                    ->first();
                if ($specialAssignment) {
                    $eqcrAssignmentId = $specialAssignment->id;
                }
            }
            $mapping->eqcr_type_name = $eqcrTypeName;

            // Regular Checklist Calculations
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

            $closedQuestions = ($statusCounts['CLOSE'] ?? 0) + ($statusCounts['NOT-APPLICABLE'] ?? 0);
            $mapping->documentation_percentage = $totalQuestions > 0
                ? round(($closedQuestions / $totalQuestions) * 100, 2)
                : 0;

            $mapping->status_counts = [
                'NOT-APPLICABLE' => $statusCounts['NOT-APPLICABLE'] ?? 0,
                'SUBMITTED' => $statusCounts['SUBMITTED'] ?? 0,
                'OPEN' => $statusCounts['OPEN'] ?? 0,
                'CLOSE' => $closedQuestions,
                'REVIEW-TL' => $statusCounts['REVIEW-TL'] ?? 0,
                'TOTAL' => $totalQuestions
            ];

            // Reviewer Checklist Calculations
            $mapping->reviewer_status_counts = [
                'SUBMITTED' => 0,
                'OPEN' => 0,
                'CLOSE' => 0,
                'REVIEW-TL' => 0,
                'TOTAL' => 0
            ];
            $mapping->reviewer_documentation_percentage = 0;

            if (!empty($eqcrTypeName) && $eqcrAssignmentId) {
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
                    ->select(
                        'statuses.name as status_name',
                        DB::raw('COUNT(*) as count')
                    )
                    ->groupBy('statuses.name')
                    ->pluck('count', 'status_name');

                $reviewerClosedQuestions = $reviewerStatusCounts['CLOSE'] ?? 0;
                $mapping->reviewer_documentation_percentage = $reviewerTotalQuestions > 0
                    ? round(($reviewerClosedQuestions / $reviewerTotalQuestions) * 100, 2)
                    : 0;

                $mapping->reviewer_status_counts = [
                    'SUBMITTED' => $reviewerStatusCounts['SUBMITTED'] ?? 0,
                    'OPEN' => $reviewerStatusCounts['OPEN'] ?? 0,
                    'CLOSE' => $reviewerClosedQuestions,
                    'REVIEW-TL' => $reviewerStatusCounts['REVIEW-TL'] ?? 0,
                    'TOTAL' => $reviewerTotalQuestions
                ];
            }

            // Fetch additional fields
            $mapping->invoicedate = DB::table('invoices')
                ->where('assignmentgenerate_id', $assignmentId)
                ->orderBy('id', 'DESC')
                ->value('invoicedate');

            $mapping->sub_team_members = DB::table('assignmentmappings')
                ->leftJoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
                ->leftJoin('teammembers', 'teammembers.id', 'assignmentteammappings.teammember_id')
                ->leftJoin('roles', 'roles.id', 'teammembers.role_id')
                ->where('assignmentteammappings.type', 0)
                ->where('assignmentmappings.id', $mapping->id)
                ->select(DB::raw("GROUP_CONCAT(CONCAT(teammembers.team_member, ' (', roles.rolename, ')')) as sub_team_members"))
                ->groupBy('assignmentmappings.id')
                ->value('sub_team_members') ?? '';

            // Set reviewer_status
            if ($mapping->reviewer_status_counts['TOTAL'] > 0) {
                $mapping->reviewer_status = ($mapping->reviewer_status_counts['CLOSE'] == $mapping->reviewer_status_counts['TOTAL']) ? 'CLOSED' : 'OPEN';
            } else {
                $mapping->reviewer_status = 'N/A';
            }
        }
        // If Excel requested → return file
        if ($request->export_type === 'excel') {
            // dd('testing shahid', $request->export_type);
            $visibleColumns = $request->visible_columns ?? [];
            return Excel::download(new DocumentassigmentExport($assignmentmappingData, $visibleColumns), 'documentationstatus.xlsx');
        }
        // Return DataTable-compatible JSON response
        return response()->json([
            'draw' => $request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $assignmentmappingData
        ]);
    }



    qwqwqw
    // 222222222222222222222222222222222222222222222

    public function documentationfilter1(Request $request)
    {
        // Get filter parameters
        $fromDate = $request->input('fromdate');
        $toDate = $request->input('todate');
        $status = $request->input('status');
        $searchValue = trim($request->input('search.value', ''));

        // If Excel export requested, use optimized approach
        if ($request->export_type === 'excel') {
            return $this->exportExcelData($request);
        }

        // Build the base query
        $query = DB::table('assignmentmappings')
            ->join('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
            ->join('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
            ->join('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
            ->join('assignments', 'assignments.id', '=', 'assignmentmappings.assignment_id')
            ->leftJoin('teammembers as leadpartner', 'leadpartner.id', '=', 'assignmentmappings.leadpartner')
            ->leftJoin('teammembers as otherpartner', 'otherpartner.id', '=', 'assignmentmappings.otherpartner')
            ->select(
                'assignmentmappings.*',
                'assignmentbudgetings.duedate',
                'assignmentbudgetings.draftreportdate',
                'assignmentbudgetings.status as assignmentbudgetingsstatus',
                'assignmentbudgetings.finalreportdate',
                'assignmentbudgetings.moneyreceiveddate',
                'assignmentbudgetings.assignmentname',
                'assignments.assignment_name',
                'clients.client_name',
                'assignmentbudgetings.periodstartdate as periodstart',
                'assignmentbudgetings.periodenddate as periodend',
                'leadpartner.team_member as leadpartner_name',
                'otherpartner.team_member as otherpartner_name'
            )
            ->distinct('assignmentmappings.assignmentgenerate_id');

        // Apply filters
        if ($request->filled('clientId')) {
            $query->whereIn('assignmentbudgetings.client_id', $request->clientId);
        }

        if ($request->filled('partnerId')) {
            $partnerIds = $request->partnerId;
            $query->where(function ($q) use ($partnerIds) {
                $q->whereIn('assignmentmappings.leadpartner', $partnerIds);
            });
        }

        if (isset($status) && ($status === "0" || !empty($status))) {
            $query->whereIn('assignmentbudgetings.status', $status);
        }

        if ($fromDate) {
            $query->whereDate('assignmentbudgetings.created_at', '>=', $fromDate);
        }
        if ($toDate) {
            $query->whereDate('assignmentbudgetings.created_at', '<=', $toDate);
        }

        // Get total records
        $totalRecords = $query->count();

        // Apply search filter
        if (!empty($searchValue)) {
            $searchValueLower = '%' . strtolower($searchValue) . '%';
            $query->where(function ($q) use ($searchValueLower) {
                $q->whereRaw('LOWER(assignments.assignment_name) LIKE ?', [$searchValueLower])
                    ->orWhereRaw('LOWER(assignmentbudgetings.assignmentname) LIKE ?', [$searchValueLower])
                    ->orWhereRaw('LOWER(clients.client_name) LIKE ?', [$searchValueLower])
                    ->orWhereRaw('LOWER(leadpartner.team_member) LIKE ?', [$searchValueLower])
                    ->orWhereRaw('LOWER(otherpartner.team_member) LIKE ?', [$searchValueLower])
                    ->orWhereRaw('LOWER(assignmentmappings.assignmentgenerate_id) LIKE ?', [$searchValueLower])
                    ->orWhereRaw('IF(assignmentbudgetings.status = 1, "OPEN", "CLOSED") LIKE ?', [$searchValueLower]);
            });
        }

        $filteredRecords = $query->count();

        // Apply sorting
        if ($request->has('order')) {
            $order = $request->input('order')[0];
            $columnIndex = $order['column'];
            $direction = $order['dir'];
            $columns = $request->input('columns');
            $columnName = $columns[$columnIndex]['data'];

            $sortableColumns = [
                'assignmentgenerate_id' => 'assignmentmappings.assignmentgenerate_id',
                'assignment_name' => 'assignments.assignment_name',
                'assignmentname' => 'assignmentbudgetings.assignmentname',
                'client_name' => 'clients.client_name',
                'invoicedate' => 'invoices.invoicedate',
                'periodstart' => 'assignmentbudgetings.periodstartdate',
                'periodend' => 'assignmentbudgetings.periodenddate',
                'leadpartner_name' => 'leadpartner.team_member',
                'otherpartner_name' => 'otherpartner.team_member',
                'assignmentbudgetingsstatus' => 'assignmentbudgetings.status',
            ];

            if (isset($sortableColumns[$columnName])) {
                $query->orderBy($sortableColumns[$columnName], $direction);
            }
        }

        // Pagination for DataTables
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $query->skip($start)->take($length);
        $assignmentmappingData = $query->get();

        // Get all assignment IDs for batch processing
        $assignmentIds = $assignmentmappingData->pluck('assignmentgenerate_id')->unique();
        $mappingIds = $assignmentmappingData->pluck('id')->unique();

        // Batch fetch EQCR data
        $eqcrData = $this->getBatchEQCRData($assignmentIds);

        // Batch fetch checklist data
        $checklistData = $this->getBatchChecklistData($assignmentIds);

        // Batch fetch reviewer checklist data
        $reviewerChecklistData = $this->getBatchReviewerChecklistData($assignmentIds);

        // Batch fetch invoices
        $invoicesData = DB::table('invoices')
            ->whereIn('assignmentgenerate_id', $assignmentIds)
            ->select('assignmentgenerate_id', DB::raw('MAX(invoicedate) as latest_invoicedate'))
            ->groupBy('assignmentgenerate_id')
            ->pluck('latest_invoicedate', 'assignmentgenerate_id');

        // Batch fetch sub team members
        $subTeamMembersData = DB::table('assignmentteammappings')
            ->join('assignmentmappings', 'assignmentmappings.id', '=', 'assignmentteammappings.assignmentmapping_id')
            ->join('teammembers', 'teammembers.id', '=', 'assignmentteammappings.teammember_id')
            ->join('roles', 'roles.id', '=', 'teammembers.role_id')
            ->where('assignmentteammappings.type', 0)
            ->whereIn('assignmentteammappings.assignmentmapping_id', $mappingIds)
            ->select(
                'assignmentteammappings.assignmentmapping_id',
                DB::raw("GROUP_CONCAT(CONCAT(teammembers.team_member, ' (', roles.rolename, ')')) as sub_team_members")
            )
            ->groupBy('assignmentteammappings.assignmentmapping_id')
            ->pluck('sub_team_members', 'assignmentmapping_id');

        // Process each record with pre-fetched data
        foreach ($assignmentmappingData as $mapping) {
            $assignmentId = $mapping->assignmentgenerate_id;
            $mappingId = $mapping->id;

            // Set EQCR data
            $mapping->eqcr_type_name = $eqcrData[$assignmentId]['type_name'] ?? '';

            // Set regular checklist data
            if (isset($checklistData[$assignmentId])) {
                $checklist = $checklistData[$assignmentId];
                $mapping->documentation_percentage = $checklist['documentation_percentage'];
                $mapping->status_counts = $checklist['status_counts'];
            } else {
                $mapping->documentation_percentage = 0;
                $mapping->status_counts = [
                    'NOT-APPLICABLE' => 0,
                    'SUBMITTED' => 0,
                    'OPEN' => 0,
                    'CLOSE' => 0,
                    'REVIEW-TL' => 0,
                    'TOTAL' => 0
                ];
            }

            // Set reviewer checklist data
            if (isset($reviewerChecklistData[$assignmentId])) {
                $reviewer = $reviewerChecklistData[$assignmentId];
                $mapping->reviewer_documentation_percentage = $reviewer['documentation_percentage'];
                $mapping->reviewer_status_counts = $reviewer['status_counts'];
                $mapping->reviewer_status = $reviewer['total'] > 0
                    ? ($reviewer['status_counts']['CLOSE'] == $reviewer['total'] ? 'CLOSED' : 'OPEN')
                    : 'N/A';
            } else {
                $mapping->reviewer_documentation_percentage = 0;
                $mapping->reviewer_status_counts = [
                    'SUBMITTED' => 0,
                    'OPEN' => 0,
                    'CLOSE' => 0,
                    'REVIEW-TL' => 0,
                    'TOTAL' => 0
                ];
                $mapping->reviewer_status = 'N/A';
            }

            // Set other batch data
            $mapping->invoicedate = $invoicesData[$assignmentId] ?? null;
            $mapping->sub_team_members = $subTeamMembersData[$mappingId] ?? '';
        }

        return response()->json([
            'draw' => $request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $assignmentmappingData
        ]);
    }

    private function exportExcelData(Request $request)
    {
        // For Excel export, use a simplified query without heavy calculations
        $query = DB::table('assignmentmappings')
            ->join('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
            ->join('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
            ->join('assignments', 'assignments.id', '=', 'assignmentmappings.assignment_id')
            ->leftJoin('teammembers as leadpartner', 'leadpartner.id', '=', 'assignmentmappings.leadpartner')
            ->leftJoin('teammembers as otherpartner', 'otherpartner.id', '=', 'assignmentmappings.otherpartner')
            // ->select(
            //     'assignmentmappings.assignmentgenerate_id',
            //     'assignmentmappings.id as mapping_id',
            //     'assignmentbudgetings.assignmentname',
            //     'assignments.assignment_name',
            //     'clients.client_name',
            //     'assignmentbudgetings.periodstartdate',
            //     'assignmentbudgetings.periodenddate',
            //     'leadpartner.team_member as leadpartner_name',
            //     'otherpartner.team_member as otherpartner_name',
            //     DB::raw('CASE WHEN assignmentbudgetings.status = 1 THEN "OPEN" ELSE "CLOSED" END as assignment_status'),
            //     'assignmentmappings.eqcrapplicability'
            // )
            ->select(
                'assignmentmappings.assignmentgenerate_id',
                'assignmentmappings.id as mapping_id',
                'assignmentbudgetings.assignmentname',
                'assignments.assignment_name',
                'clients.client_name',
                'assignmentbudgetings.periodstartdate',
                'assignmentbudgetings.periodenddate',
                'leadpartner.team_member as leadpartner_name',
                'otherpartner.team_member as otherpartner_name',
                DB::raw('CASE WHEN assignmentbudgetings.status = 1 THEN "OPEN" ELSE "CLOSED" END as assignment_status'),
                'assignmentmappings.eqcrapplicability'
            )
            ->distinct('assignmentmappings.assignmentgenerate_id');

        // Apply filters (same as before)
        if ($request->filled('clientId')) {
            $query->whereIn('assignmentbudgetings.client_id', $request->clientId);
        }
        if ($request->filled('partnerId')) {
            $query->whereIn('assignmentmappings.leadpartner', $request->partnerId);
        }
        if ($request->filled('status')) {
            $query->whereIn('assignmentbudgetings.status', $request->status);
        }
        if ($request->filled('fromdate')) {
            $query->whereDate('assignmentbudgetings.created_at', '>=', $request->fromdate);
        }
        if ($request->filled('todate')) {
            $query->whereDate('assignmentbudgetings.created_at', '<=', $request->todate);
        }

        // Get data WITHOUT heavy calculations
        $data = $query->get();

        // Export with minimal processing
        $visibleColumns = $request->visible_columns ?? [];
        return Excel::download(new DocumentassigmentExport($data, $visibleColumns), 'documentationstatus.xlsx');
    }

    private function getBatchEQCRData($assignmentIds)
    {
        $mappings = DB::table('assignmentmappings')
            ->whereIn('assignmentgenerate_id', $assignmentIds)
            ->select('assignmentgenerate_id', 'assignment_id', 'eqcrapplicability')
            ->get();

        $eqcrTypes = [
            1 => 'NFRA',
            2 => 'Quality Review',
            3 => 'Peer Review',
            4 => 'Others',
            5 => 'PCAOB'
        ];

        $result = [];
        foreach ($mappings as $mapping) {
            $result[$mapping->assignmentgenerate_id] = [
                'type_name' => $eqcrTypes[$mapping->eqcrapplicability] ?? '',
                'assignment_id' => $mapping->assignment_id
            ];
        }

        return $result;
    }

    private function getBatchChecklistData($assignmentIds)
    {
        // Optimized batch query for checklist data
        $result = [];

        foreach ($assignmentIds as $assignmentId) {
            // Use raw SQL for better performance
            $data = DB::select("
            SELECT 
                COUNT(CASE WHEN s.name = 'CLOSE' THEN 1 END) as closed_count,
                COUNT(CASE WHEN s.name = 'NOT-APPLICABLE' THEN 1 END) as na_count,
                COUNT(CASE WHEN s.name = 'SUBMITTED' THEN 1 END) as submitted_count,
                COUNT(CASE WHEN s.name = 'REVIEW-TL' THEN 1 END) as review_tl_count,
                COUNT(CASE WHEN s.name = 'OPEN' THEN 1 END) as open_count,
                COUNT(*) as total_count
            FROM checklistanswers ca
            JOIN statuses s ON ca.status = s.id
            WHERE ca.assignment_id = ?
        ", [$assignmentId]);

            if (!empty($data)) {
                $row = $data[0];
                $closedQuestions = $row->closed_count + $row->na_count;
                $percentage = $row->total_count > 0 ? round(($closedQuestions / $row->total_count) * 100, 2) : 0;

                $result[$assignmentId] = [
                    'documentation_percentage' => $percentage,
                    'status_counts' => [
                        'NOT-APPLICABLE' => $row->na_count,
                        'SUBMITTED' => $row->submitted_count,
                        'OPEN' => $row->open_count,
                        'CLOSE' => $row->closed_count,
                        'REVIEW-TL' => $row->review_tl_count,
                        'TOTAL' => $row->total_count
                    ]
                ];
            }
        }

        return $result;
    }

    private function getBatchReviewerChecklistData($assignmentIds)
    {
        // Similar optimized batch query for reviewer checklist
        $result = [];

        foreach ($assignmentIds as $assignmentId) {
            $data = DB::select("
            SELECT 
                COUNT(CASE WHEN s.name = 'CLOSE' THEN 1 END) as closed_count,
                COUNT(CASE WHEN s.name = 'SUBMITTED' THEN 1 END) as submitted_count,
                COUNT(CASE WHEN s.name = 'REVIEW-TL' THEN 1 END) as review_tl_count,
                COUNT(CASE WHEN s.name = 'OPEN' THEN 1 END) as open_count,
                COUNT(*) as total_count
            FROM checklistanswers ca
            JOIN statuses s ON ca.status = s.id
            WHERE ca.assignment_id = ?
            AND ca.is_reviewer = 1
        ", [$assignmentId]);

            if (!empty($data)) {
                $row = $data[0];
                $percentage = $row->total_count > 0 ? round(($row->closed_count / $row->total_count) * 100, 2) : 0;

                $result[$assignmentId] = [
                    'documentation_percentage' => $percentage,
                    'status_counts' => [
                        'SUBMITTED' => $row->submitted_count,
                        'OPEN' => $row->open_count,
                        'CLOSE' => $row->closed_count,
                        'REVIEW-TL' => $row->review_tl_count,
                        'TOTAL' => $row->total_count
                    ],
                    'total' => $row->total_count
                ];
            }
        }

        return $result;
    }
    // 222222222222222222222222222222222222222222222

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

            if ($request->has('export_type')) {
                $assignments = $query->get();

                if ($request->export_type === 'copy') {
                    return response()->json(['data' => $assignments]);
                }

                if ($request->export_type === 'excel') {
                    $visibleColumns = $request->get('visible_columns', []);

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
    public function getassignment(Request $request)
    {
        if ($request->ajax() && $request->filled('cid')) {
            $assignments = DB::table('assignmentbudgetings')
                ->WhereIn('assignmentbudgetings.client_id', $request->cid)
                ->leftJoin('assignments', 'assignments.id', '=', 'assignmentbudgetings.assignment_id')
                ->orderBy('assignments.assignment_name')
                ->select(
                    'assignmentbudgetings.assignmentgenerate_id',
                    'assignmentbudgetings.assignmentname',
                    'assignments.assignment_name'
                )
                ->get();

            return response()->json($assignments);
        }

        return response()->json([]);
    }
    public function reportupdate(Request $request)
    {

        DB::beginTransaction();

        try {
            $data = $request->except(['_token']);
            $data['createdby'] = auth()->user()->teammember_id;

            // Helper to handle file upload
            $uploadFile = function ($fieldName) use ($request) {
                if ($request->hasFile($fieldName)) {
                    $file = $request->file($fieldName);
                    $name = time() . '_' . $file->getClientOriginalName(); // optional timestamp to avoid name conflicts

                    // Upload to S3
                    $path = $file->storeAs('invoice', $name, 's3');

                    return $name; // return the filename if you want to save in DB
                }
                return null;
            };

            $draftReportFile = $uploadFile('draftreport');
            $finalReportFile = $uploadFile('finalreport');

            // Build update array dynamically to avoid overwriting with null
            $updateData = [
                'draftreportdatenew' => $request->draftreportdatenew,
                'finaldraftreportdate' => $request->draftreportdatenew,
                'finalreportdatenew' => $request->finalreportdatenew,
                'finalreportdate' => $request->finalreportdatenew,
                'reportupdateby'  => auth()->user()->teammember_id,
            ];

            if ($draftReportFile) {
                $updateData['draftreport'] = $draftReportFile;
            }

            if ($finalReportFile) {
                $updateData['finalreport'] = $finalReportFile;
            }

            DB::table('assignmentbudgetings')
                ->where('assignmentgenerate_id', $request->assignmentgenerate_id)
                ->update($updateData);

            DB::commit();

            return back()->with('success', ['msg' => 'Report updated successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error("Report Update Error: File: {$e->getFile()} | Line: {$e->getLine()} | Message: {$e->getMessage()}");
            report($e);

            return back()->withErrors(['msg' => $e->getMessage()])->withInput();
        }
    }
}
