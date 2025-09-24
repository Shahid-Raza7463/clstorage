<?php
// changes on 09-09-2025
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Assignmentmapping;
use App\Models\Teammember;
use App\Models\Tender;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class DashboardReport extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function upcomingassignments()
    {

        // Convert to assignments
        $query = DB::table('assignmentplannings')
            ->leftJoin('clients', 'clients.id', '=', 'assignmentplannings.client_id')
            ->leftJoin('assignments', 'assignments.id', '=', 'assignmentplannings.assignment_id')
            ->where('assignmentplannings.status', 0)
            ->whereDate('assignmentplannings.assignmentstartdate', '>=', Carbon::today())
            ->select('assignmentplannings.*', 'clients.client_name', 'assignments.assignment_name');

        $user = auth()->user();

        if ($user->role_id == 13) {
            $query->where(function ($q) use ($user) {
                $q->where('assignmentplannings.engagementpartner', $user->teammember_id)
                    ->orWhere('assignmentplannings.otherpartner', $user->teammember_id);
            });
        } elseif ($user->role_id == 14) {
            $query->where(function ($q) use ($user) {
                $q->where('assignmentplannings.createdby', $user->teammember_id)
                    ->orWhereRaw('FIND_IN_SET(?, assignmentplannings.manager)', [$user->teammember_id]);
            });
        }

        // Always get the results as a collection
        $AssignmentplanningData = $query->get();

        // Map over the collection
        $AssignmentplanningData = $AssignmentplanningData->map(function ($item) {

            // Get eqcr partner
            $item->eqcr_partner_name = Teammember::select('team_member')
                ->where('id', $item->eqcrpart)
                ->first()?->team_member ?? '';

            // Get eqcr managers
            $eqcrpartnerteams = explode(',', $item->eqcrpartnerteams);

            $item->eqcr_partner_teams = DB::table('teammembers')
                ->whereIn('id', $eqcrpartnerteams)
                ->pluck('team_member')
                ->implode(', ');

            $engagementPartner = Teammember::select('team_member')
                ->where('id', $item->engagementpartner)
                ->first();
            $item->engagement_partner_name = $engagementPartner ? $engagementPartner->team_member : '';

            $otherPartner = Teammember::select('team_member')
                ->where('id', $item->otherpartner)
                ->first();
            $item->other_partner_name = $otherPartner ? $otherPartner->team_member : '';

            $managerIds = $item->manager ? explode(',', $item->manager) : [];
            $item->manager_names = DB::table('teammembers')
                ->whereIn('id', $managerIds)
                ->pluck('team_member')
                ->implode(', ');

            $teamMemberIds = $item->teammember ? explode(',', $item->teammember) : [];
            $item->team_member_names = DB::table('teammembers')
                ->whereIn('id', $teamMemberIds)
                ->pluck('team_member')
                ->implode(', ');

            $allMemberIds = array_merge($managerIds, $teamMemberIds, $eqcrpartnerteams);

            $item->leaving_members = DB::table('teammembers')
                ->whereIn('id', $allMemberIds)
                ->whereNotNull('leavingdate')
                ->whereBetween('leavingdate', [$item->assignmentstartdate, $item->assignmentenddate])
                ->select('teammembers.id', 'teammembers.team_member', 'teammembers.leavingdate')
                ->get();

            $item->leaves = DB::table('applyleaves')
                ->leftJoin('teammembers', 'teammembers.id', '=', 'applyleaves.createdby')
                ->whereIn('applyleaves.status', [0, 1])
                ->whereIn('applyleaves.createdby', $allMemberIds)
                ->where(function ($query) use ($item) {
                    $query->whereBetween('from', [$item->assignmentstartdate, $item->assignmentenddate])
                        ->orWhereBetween('to', [$item->assignmentstartdate, $item->assignmentenddate])
                        ->orWhere(function ($query) use ($item) {
                            $query->where('from', '<=', $item->assignmentstartdate)
                                ->where('to', '>=', $item->assignmentenddate);
                        });
                })
                ->select('applyleaves.*', 'teammembers.team_member')
                ->get();

            return $item;
        });
        // Convert to assignments end hare


        // Converted assignments
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
                $q->whereRaw('COALESCE(actualstartdate, tentativestartdate) > ?', [Carbon::today()->toDateString()]);
            })
            ->get();


        $assignments = $assignments->map(function ($assignment) {
            $totalHours = $assignment->timsheetusers
                ->where('createdBy.role_id', 14)
                ->sum('hour');

            $assignment->total_hours = $totalHours;
            return $assignment;
        });

        // Converted assignments

        return view('backEnd.dashboardreport.upcomingassignments', compact('AssignmentplanningData', 'assignments'));
    }

    public function billspendingforcollection()
    {
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

    public function billspending()
    {
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
                $q->where('status', 0);
            })
            ->whereDoesntHave('invoices')
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

    public function assignmentscompleted()
    {
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
                $q->whereMonth('otpverifydate', Carbon::now()->month)
                    ->whereYear('otpverifydate', Carbon::now()->year);
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

    public function delayedassignments()
    {
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
                $q->whereRaw('COALESCE(DATE(assignmentbudgetings.actualenddate), DATE(assignmentbudgetings.tentativeenddate)) < ?', [Carbon::today()->toDateString()]);
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

    public function nfraassignments()
    {
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
            ->where('eqcrapplicability', 1)
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

    public function timesheetcreated()
    {
        $assignments = Assignmentmapping::with([
            'assignmentBudgeting.client:id,client_name',
            'assignmentBudgeting.assignment:id,assignment_name',
            'leadPartner:id,team_member',
            'otherPartner:id,team_member',
            'reviewerPartner:id,team_member',
            'assignmentTeamMappings.teamMember:id,team_member',
            'timsheetusers.createdBy:id,role_id'
        ])
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('timesheetusers')
                    ->join('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'timesheetusers.assignmentgenerate_id')
                    ->whereRaw('timesheetusers.assignmentgenerate_id = assignmentmappings.assignmentgenerate_id')
                    ->whereRaw("DATE(timesheetusers.created_at) > DATE(COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate))");
            })
            ->distinct()
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


    public function tendersubmitted()
    {
        $id = 4;
        $tenderDatas = DB::table('tenders')
            ->leftJoin('teammembers', 'teammembers.id', '=', 'tenders.teammember_id')
            ->where('tenders.status', $id)
            ->where('tenders.tendersubmitstatus', 1)
            ->whereMonth('tenders.tendersubmitdate', Carbon::now()->month)
            ->whereYear('tenders.tendersubmitdate', Carbon::now()->year)
            ->select(
                'tenders.id',
                'tenders.status',
                'tenders.contactperson',
                'tenders.tenderofferedby',
                'tenders.tenderpublishdate',
                'tenders.tenderdate',
                'tenders.services',
                'teammembers.team_member'
            )
            ->get();
        return view('backEnd.tender.index', compact('tenderDatas', 'id'));
    }

    public function İndependencepending()
    {
        $clientspecificindependencedeclaration =  DB::table('assignmentmappings')
            ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
            ->leftjoin('teammembers', 'teammembers.id', 'assignmentteammappings.teammember_id')
            // ->where('assignmentmappings.assignmentgenerate_id', $id)
            ->select('teammembers.id', 'teammembers.team_member', 'assignmentmappings.assignmentgenerate_id', 'assignmentteammappings.created_at')->get();

        return view('backEnd.clientspecificindependencedeclaration.index', compact('clientspecificindependencedeclaration'));
    }

    public function paymentsnotrecievedwithindays()
    {
        $teammember = Teammember::where('role_id', '!=', 11)
            ->where('role_id', '!=', 12)
            ->with('title', 'role')
            ->get();

        $outstandingDatas = DB::table('assignmentmappings')
            ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
            ->leftJoin('invoices', 'invoices.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
            ->leftJoin('outstandings', 'outstandings.BILL_NO', '=', 'invoices.invoice_id')
            ->leftJoin('payments', 'payments.invoiceid', '=', 'invoices.invoice_id')
            ->leftJoin('teammembers', 'teammembers.id', '=', 'outstandings.Partner')
            ->whereNotNull('invoices.id')
            ->where('assignmentbudgetings.status', 0)
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
                'outstandings.*',
                'invoices.currency',
                DB::raw("DATE_FORMAT(outstandings.created_at, '%Y-%m-%d') as bill_date"),
                //  DB::raw('SUM(outstandings.AMT) as total_amount')
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

    public function exceptionalexpenses()
    {
        $outstationData = DB::table('outstationconveyances')
            ->leftjoin('assignments', 'assignments.id', 'outstationconveyances.assignment_id')
            ->leftjoin('clients', 'clients.id', 'outstationconveyances.client_id')
            ->where('outstationconveyances.createdby', '!=', 336)
            ->where('outstationconveyances.conveyance', 'Local Conveyance')
            ->where('outstationconveyances.status', 6)
            ->whereMonth('outstationconveyances.approveddate', Carbon::now()->month)
            ->whereYear('outstationconveyances.approveddate', Carbon::now()->year)
            ->select('outstationconveyances.*', 'clients.client_name', 'assignments.assignment_name  as assignmentsname')
            ->get();

        $outstationDatas = DB::table('outstationconveyances')
            ->leftjoin('assignments', 'assignments.id', 'outstationconveyances.assignment_id')
            ->leftjoin('clients', 'clients.id', 'outstationconveyances.client_id')
            ->where('outstationconveyances.conveyance', 'Outstation Conveyance')
            ->where('outstationconveyances.createdby', '!=', 336)
            ->where('outstationconveyances.status', 6)
            ->whereMonth('outstationconveyances.approveddate', Carbon::now()->month)
            ->whereYear('outstationconveyances.approveddate', Carbon::now()->year)
            ->select('outstationconveyances.*', 'clients.client_name', 'assignments.assignment_name  as assignmentsname')->get();

        $sharedData = DB::table('outstationconveyancesemployee')
            ->join('outstationconveyances', 'outstationconveyances.id', '=', 'outstationconveyancesemployee.outstationconveyances_id')
            ->leftJoin('assignments', 'assignments.id', '=', 'outstationconveyances.assignment_id')
            ->leftJoin('clients', 'clients.id', '=', 'outstationconveyances.client_id')
            ->select('outstationconveyances.*', 'clients.client_name', 'assignments.assignment_name as assignmentsname')
            ->whereNotNull('outstationconveyancesemployee.teammember_id')
            ->distinct()
            ->get();


        return view('backEnd.outstationconveyance.index', compact('outstationData', 'outstationDatas', 'sharedData'));
    }

    public function lossassignments()
    {
        // financial year
        $currentDate4 = Carbon::now();
        if ($currentDate4->month >= 4) {
            // Current year financial year
            $financialStartDate = Carbon::create($currentDate4->year, 4, 1);
            $financialEndDate = Carbon::create($currentDate4->year + 1, 3, 31);
        } else {
            // Previous year financial year
            $financialStartDate = Carbon::create($currentDate4->year - 1, 4, 1);
            $financialEndDate = Carbon::create($currentDate4->year, 3, 31);
        }

        // Assignment-wise P&L Analysis
        $assignmentprofitandlosses = DB::table('assignmentmappings')
            ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
            ->leftJoin('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
            ->whereBetween('assignmentmappings.created_at', [$financialStartDate, $financialEndDate])
            ->orderByDesc('assignmentbudgetings.id')
            ->select(
                'assignmentmappings.*',
                // 'assignmentbudgetings.assignmentname',
                'assignmentbudgetings.status',
                DB::raw('COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate) as finalassignmentenddate'),
                'assignmentmappings.engagementfee',
                'clients.client_name'
            )
            ->get();

        $assignmentCosts = DB::table('timesheetusers')
            ->leftJoin('teammembers', 'teammembers.id', '=', 'timesheetusers.createdby')
            ->select('timesheetusers.assignmentgenerate_id', DB::raw('SUM(timesheetusers.totalhour * teammembers.cost_hour) as total_cost'))
            ->groupBy('timesheetusers.assignmentgenerate_id')
            ->pluck('total_cost', 'assignmentgenerate_id');

        // Filter on loss making assignments 
        $lossAssignments = $assignmentprofitandlosses->filter(function ($assignment) use ($assignmentCosts) {
            $assignment->total_cost = $assignmentCosts[$assignment->assignmentgenerate_id] ?? 0;
            $revenue = $assignment->engagementfee ?? 0;
            $cost = $assignment->total_cost ?? 0;
            $profit = $revenue - $cost;

            $assignment->profit = $profit;
            return $profit < 0;
        });

        $assignments = Assignmentmapping::with([
            'assignmentBudgeting.client:id,client_name',
            'assignmentBudgeting.assignment:id,assignment_name',
            'leadPartner:id,team_member',
            'otherPartner:id,team_member',
            'reviewerPartner:id,team_member',
            'assignmentTeamMappings.teamMember:id,team_member',
            'timsheetusers.createdBy:id,role_id'
        ])
            ->whereIn('assignmentmappings.assignmentgenerate_id', $lossAssignments->pluck('assignmentgenerate_id'))
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

        // dd($usdAmountconvert);

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

    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
