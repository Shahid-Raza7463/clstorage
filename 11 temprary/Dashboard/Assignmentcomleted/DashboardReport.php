<?php

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

    public function upcomingassignments(Request $request)
    {

        $filtersdata = $this->filtersRequest($request);

        $yearly = $filtersdata['yearly'];
        $monthsdigit = $filtersdata['monthsdigit'];
        $partnerId = $filtersdata['partnerId'];
        $startDateFormatted = $filtersdata['startDateFormatted'];
        $endDateFormatted = $filtersdata['endDateFormatted'];
        $months = $filtersdata['months'];


        // Upcoming Assignments
        $query = DB::table('assignmentplannings')
            ->leftJoin('clients', 'clients.id', '=', 'assignmentplannings.client_id')
            ->leftJoin('assignments', 'assignments.id', '=', 'assignmentplannings.assignment_id')
            ->where('assignmentplannings.status', 0)
            ->when(!empty($yearly), function ($query) use ($startDateFormatted, $endDateFormatted) {
                $query->whereBetween('assignmentplannings.assignmentstartdate', [$startDateFormatted, $endDateFormatted]);
            })
            ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
                $query->whereMonth('assignmentplannings.assignmentstartdate',  $monthsdigit);
            })
            ->when(!empty($partnerId), function ($query) use ($partnerId) {
                $query->where('assignmentplannings.engagementpartner', $partnerId);
            })
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
                $q->whereBetween(DB::raw('COALESCE(actualstartdate, tentativestartdate)'), [
                    Carbon::today()->startOfDay(),
                    Carbon::today()->addDays(30)->endOfDay()
                ]);
            })
            ->when(!empty($yearly), function ($query) use ($startDateFormatted, $endDateFormatted) {
                $query->whereHas('assignmentBudgeting', function ($q) use ($startDateFormatted, $endDateFormatted) {
                    $q->whereBetween(DB::raw('COALESCE(DATE(actualstartdate), DATE(tentativestartdate))'), [$startDateFormatted, $endDateFormatted]);
                });
            })
            ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
                $query->whereHas('assignmentBudgeting', function ($q) use ($monthsdigit) {
                    $q->whereMonth(DB::raw('COALESCE(DATE(actualstartdate), DATE(tentativestartdate))'), $monthsdigit);
                });
            })
            ->when(!empty($partnerId), function ($query) use ($partnerId) {
                $query->where('leadpartner', $partnerId);
            })
            ->get();


        // $assignments = $assignments->map(function ($assignment) {
        //     $totalHours = $assignment->timsheetusers
        //         ->where('createdBy.role_id', 14)
        //         ->sum('hour');

        //     $assignment->total_hours = $totalHours;
        //     return $assignment;
        // });


        $assignments = $assignments->map(function ($assignment) {
            $totalHours = $assignment->timsheetusers
                ->where('createdBy.role_id', 14)
                ->sum(function ($timesheet) {
                    return $this->convertHourToDecimal($timesheet->hour);
                });

            $assignment->total_hours = $totalHours;
            return $assignment;
        });

        // Converted assignments

        return view('backEnd.dashboardreport.upcomingassignments', compact('AssignmentplanningData', 'assignments'));
    }

    public function billspendingforcollection(Request $request)
    {
        $filtersdata = $this->filtersRequest($request);

        $yearly = $filtersdata['yearly'];
        $monthsdigit = $filtersdata['monthsdigit'];
        $partnerId = $filtersdata['partnerId'];
        $startDateFormatted = $filtersdata['startDateFormatted'];
        $endDateFormatted = $filtersdata['endDateFormatted'];
        $months = $filtersdata['months'];

        $teammember = Teammember::where('role_id', '!=', 11)
            ->where('role_id', '!=', 12)
            ->with('title', 'role')
            ->get();

        // filter Collection's Outstanding
        $outstandingDatas = DB::table('assignmentmappings')
            ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
            ->leftJoin('assignments', 'assignments.id', '=', 'assignmentmappings.assignment_id')
            ->leftJoin('invoices', 'invoices.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
            ->leftJoin('outstandings', 'outstandings.BILL_NO', '=', 'invoices.invoice_id')
            ->leftJoin('teammembers', 'teammembers.id', '=', 'outstandings.Partner')
            ->whereNotNull('invoices.id')
            ->whereNotNull('outstandings.BILL_NO')
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
                'assignmentmappings.assignmentgenerate_id',
                'assignments.assignment_name',
                'assignmentbudgetings.assignmentname',
                'invoices.invoice_id',
                'invoices.amount',
                'invoices.total',
                'invoices.paymentstatus',
                'invoices.currency',
                'invoices.pocketexpenseamount',
                DB::raw("DATE_FORMAT(outstandings.created_at, '%Y-%m-%d') as bill_date"),
                'teammembers.team_member',
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
        return view('backEnd.dashboardreport.collectionpending', compact('outstandingDatas', 'total', 'teammember'));
    }

    public function billspending(Request $request)
    {
        $filtersdata = $this->filtersRequest($request);

        $yearly = $filtersdata['yearly'];
        $monthsdigit = $filtersdata['monthsdigit'];
        $partnerId = $filtersdata['partnerId'];
        $startDateFormatted = $filtersdata['startDateFormatted'];
        $endDateFormatted = $filtersdata['endDateFormatted'];
        $months = $filtersdata['months'];

        // filter Bills Pending for Generation
        // $assignments = Assignmentmapping::with([
        //     'assignmentBudgeting.client:id,client_name',
        //     'assignmentBudgeting.assignment:id,assignment_name',
        //     'leadPartner:id,team_member',
        //     'otherPartner:id,team_member',
        //     'reviewerPartner:id,team_member',
        //     'assignmentTeamMappings.teamMember:id,team_member',
        //     'timsheetusers.createdBy:id,role_id'
        // ])
        //     ->whereHas('assignmentBudgeting', function ($q) {
        //         $q->where('status', 0);
        //     })
        //     ->when(!empty($yearly), function ($query) use ($startDateFormatted, $endDateFormatted) {
        //         $query->whereHas('assignmentBudgeting', function ($q) use ($startDateFormatted, $endDateFormatted) {
        //             $q->whereBetween(DB::raw('COALESCE(DATE(actualenddate), DATE(tentativeenddate))'), [$startDateFormatted, $endDateFormatted]);
        //         });
        //     })
        //     ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
        //         $query->whereHas('assignmentBudgeting', function ($q) use ($monthsdigit) {
        //             $q->whereMonth(DB::raw('COALESCE(DATE(actualenddate), DATE(tentativeenddate))'), $monthsdigit);
        //         });
        //     })
        //     ->when(!empty($partnerId), function ($query) use ($partnerId) {
        //         $query->where('leadpartner', $partnerId);
        //     })
        //     ->whereDoesntHave('invoices')
        //     ->get();

        $assignments = DB::table('assignmentmappings')
            ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
            ->leftJoin('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
            ->leftJoin('assignments', 'assignments.id', '=', 'assignmentmappings.assignment_id')
            ->leftJoin('invoices', 'invoices.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
            ->whereNull('invoices.assignmentgenerate_id')
            ->where('assignmentbudgetings.status', 0)
            ->when(!empty($yearly), function ($query) use ($startDateFormatted, $endDateFormatted) {
                $query->whereBetween(DB::raw('COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate)'), [$startDateFormatted, $endDateFormatted]);
            })
            ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
                $query->whereMonth(DB::raw('COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate)'), $monthsdigit);
            })
            ->when(!empty($partnerId), function ($query) use ($partnerId) {
                $query->where('assignmentmappings.leadpartner', $partnerId);
            })
            ->select(
                'assignmentmappings.*',
                'assignments.assignment_name',
                'clients.client_name',
                'assignmentbudgetings.assignmentname',
                'assignmentbudgetings.finaldraftreportdate',
                'assignmentbudgetings.percentclosedate',
                'assignmentbudgetings.tentativestartdate',
                'assignmentbudgetings.tentativeenddate'
            )
            ->get()
            ->map(function ($row) {
                // first timesheet created date
                $firstTimesheetDate = DB::table('timesheets')
                    ->join('timesheetusers', 'timesheetusers.timesheetid', '=', 'timesheets.id')
                    ->where('timesheetusers.assignmentgenerate_id', $row->assignmentgenerate_id)
                    ->min('timesheets.date');


                $first  = $firstTimesheetDate ? Carbon::parse($firstTimesheetDate) : null;
                $start  = $row->tentativestartdate ? Carbon::parse($row->tentativestartdate) : null;
                $end    = $row->tentativeenddate ? Carbon::parse($row->tentativeenddate) : null;

                // Difference between TentativeStartdate and TentativeEnddate
                $timesheetEndDate = null;
                if ($start && $end && $first) {
                    $diffDays = $start->diffInDays($end, false);
                    // i have added total diff days on first timesheet created date
                    if ($diffDays > 0) {
                        $timesheetEndDate = $first->copy()->addDays($diffDays);
                    }
                }

                //  possible closed dates
                $dates = collect([
                    // remove nulls
                    $row->finaldraftreportdate ? Carbon::parse($row->finaldraftreportdate) : null,
                    $row->percentclosedate ? Carbon::parse($row->percentclosedate) : null,
                    $timesheetEndDate,
                ])->filter();

                // dd($dates);

                $row->assignmentcloseddate = $dates->isNotEmpty() ? $dates->sort()->first()->toDateString() : null;

                return $row;
            });



        // $assignments = $assignments->map(function ($assignment) {
        //     $totalHours = $assignment->timsheetusers
        //         ->where('createdBy.role_id', 14)
        //         ->sum(function ($timesheet) {
        //             return $this->convertHourToDecimal($timesheet->hour);
        //         });

        //     $assignment->total_hours = $totalHours;
        //     return $assignment;
        // });

        return view('backEnd.dashboardreport.billspendingamount', compact('assignments'));
    }

    public function assignmentscompleted(Request $request)
    {
        $yearly = $request->query('yearly');
        $monthsdigit = $request->query('monthsdigit');
        $partnerId = $request->query('partnerId');

        $startDateFormatted = null;
        $endDateFormatted = null;

        if (!empty($yearly)) {
            [$startYear, $endYear] = explode('-', $yearly);
            $startDate = Carbon::create($startYear, 4, 1);
            $endDate = Carbon::create($endYear, 3, 31);
            $startDateFormatted = $startDate->format('Y-m-d');
            $endDateFormatted = $endDate->format('Y-m-d');
        } else {
            // Default financial year when no filters are applied
            if (empty($monthsdigit) && empty($partnerId)) {
                $currentDate = Carbon::now();
                if ($currentDate->month >= 4) {
                    // Current year financial year
                    $startDate = Carbon::create($currentDate->year, 4, 1);
                    $endDate = Carbon::create($currentDate->year + 1, 3, 31);
                } else {
                    // Previous year financial year
                    $startDate = Carbon::create($currentDate->year - 1, 4, 1);
                    $endDate = Carbon::create($currentDate->year, 3, 31);
                }
                $startDateFormatted = $startDate->format('Y-m-d');
                $endDateFormatted = $endDate->format('Y-m-d');
            }
        }

        // Assignments Completed
        $assignmentsdata = Assignmentmapping::with([
            'assignmentBudgeting.client:id,client_name',
            'assignmentBudgeting.assignment:id,assignment_name',
            'leadPartner:id,team_member',
            'invoices' // get invoice data in relation section 
        ])
            ->whereHas('assignmentBudgeting', function ($q) {
                $q->where('status', 0)
                    ->whereNotNull('percentclosedate');  // Documentation 100% done
            })
            ->whereHas('invoices') // invoice must exist
            // default before filter applied
            ->when(empty($yearly) && empty($monthsdigit) && empty($partnerId) && isset($startDateFormatted) && isset($endDateFormatted), function ($query) use ($startDateFormatted, $endDateFormatted) {
                $query->whereHas('assignmentBudgeting', function ($q) use ($startDateFormatted, $endDateFormatted) {
                    $q->whereBetween('otpverifydate', [$startDateFormatted, $endDateFormatted]);
                });
            })
            // after filter applied
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
            ->select('assignmentmappings.*')
            ->distinct('assignmentmappings.assignmentgenerate_id')
            ->get();

        $assignmentgenerateid = $assignmentsdata->pluck('assignmentgenerate_id')->unique()->toArray();

        // Assignments Not Completed
        $assignmentnotcompleted = Assignmentmapping::with([
            'assignmentBudgeting.client:id,client_name',
            'assignmentBudgeting.assignment:id,assignment_name',
            'leadPartner:id,team_member',
            'invoices'
        ])
            ->whereNotIn('assignmentgenerate_id', $assignmentgenerateid)
            // default before filter
            ->when(empty($yearly) && empty($monthsdigit) && empty($partnerId) && isset($startDateFormatted) && isset($endDateFormatted), function ($query) use ($startDateFormatted, $endDateFormatted) {
                $query->whereBetween('created_at', [$startDateFormatted, $endDateFormatted]);
            })
            // after filter
            ->when(!empty($yearly), function ($query) use ($startDateFormatted, $endDateFormatted) {
                $query->whereBetween('created_at', [$startDateFormatted, $endDateFormatted]);
            })
            ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
                $query->whereMonth('created_at', $monthsdigit);
            })
            ->when(!empty($partnerId), function ($query) use ($partnerId) {
                $query->where('leadpartner', $partnerId);
            })
            ->select('assignmentmappings.*')
            ->distinct('assignmentmappings.assignmentgenerate_id')
            ->get();

        $assignments = $assignmentsdata->merge($assignmentnotcompleted);

        // return $assignmentsdata;
        return view('backEnd.dashboardreport.assignmentscompleted', compact('assignments'));
    }


    public function delayedassignments(Request $request)
    {
        $filtersdata = $this->filtersRequest($request);

        $yearly = $filtersdata['yearly'];
        $monthsdigit = $filtersdata['monthsdigit'];
        $partnerId = $filtersdata['partnerId'];
        $startDateFormatted = $filtersdata['startDateFormatted'];
        $endDateFormatted = $filtersdata['endDateFormatted'];
        $months = $filtersdata['months'];

        // filter How many Delayed Assignments
        $assignments = DB::table('assignmentmappings')
            ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
            ->leftJoin('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
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
            ->select(
                'assignmentmappings.*',
                'assignmentbudgetings.assignmentname',
                'assignmentbudgetings.tentativestartdate',
                'assignmentbudgetings.tentativeenddate',
                'assignmentbudgetings.draftreportdate',
                'assignmentbudgetings.percentclosedate',
                'clients.client_name',
                DB::raw('(SELECT SUM(totalhour) FROM timesheetusers WHERE timesheetusers.assignmentgenerate_id = assignmentmappings.assignmentgenerate_id) as workedhour')
            )
            ->get();

        //     $assignments = $assignments->map(function ($assignment) {
        //         $totalHours = $assignment->timsheetusers
        //             ->where('createdBy.role_id', 14)
        //             ->sum(function ($timesheet) {
        //                 return $this->convertHourToDecimal($timesheet->hour);
        //             });

        //         $assignment->total_hours = $totalHours;
        //         return $assignment;
        //     });

        return view('backEnd.dashboardreport.delayedassignments', compact('assignments'));
    }

    public function nfraassignments(Request $request)
    {
        $filtersdata = $this->filtersRequest($request);

        $yearly = $filtersdata['yearly'];
        $monthsdigit = $filtersdata['monthsdigit'];
        $partnerId = $filtersdata['partnerId'];
        $startDateFormatted = $filtersdata['startDateFormatted'];
        $endDateFormatted = $filtersdata['endDateFormatted'];
        $months = $filtersdata['months'];

        // NFRA Audits Ongoing
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
            ->when(!empty($yearly), function ($query) use ($startDateFormatted, $endDateFormatted) {
                $query->whereHas('assignmentBudgeting', function ($q) use ($startDateFormatted, $endDateFormatted) {
                    $q->whereBetween(DB::raw('COALESCE(DATE(actualstartdate), DATE(tentativestartdate))'), [$startDateFormatted, $endDateFormatted]);
                });
            })
            ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
                $query->whereHas('assignmentBudgeting', function ($q) use ($monthsdigit) {
                    $q->whereMonth(DB::raw('COALESCE(DATE(actualstartdate), DATE(tentativestartdate))'), $monthsdigit);
                });
            })
            ->when(!empty($partnerId), function ($query) use ($partnerId) {
                $query->where('leadpartner', $partnerId);
            })
            ->get();



        $assignments = $assignments->map(function ($assignment) {
            $totalHours = $assignment->timsheetusers
                ->where('createdBy.role_id', 14)
                ->sum(function ($timesheet) {
                    return $this->convertHourToDecimal($timesheet->hour);
                });

            $assignment->total_hours = $totalHours;
            return $assignment;
        });

        return view('backEnd.dashboardreport.nfraassignmentslist', compact('assignments'));
    }

    public function timesheetcreated(Request $request)
    {
        $filtersdata = $this->filtersRequest($request);

        $yearly = $filtersdata['yearly'];
        $monthsdigit = $filtersdata['monthsdigit'];
        $partnerId = $filtersdata['partnerId'];
        $startDateFormatted = $filtersdata['startDateFormatted'];
        $endDateFormatted = $filtersdata['endDateFormatted'];
        $months = $filtersdata['months'];

        // filter Timesheet Filled On Closed Assignment
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
            ->distinct()
            ->get();


        $assignments = $assignments->map(function ($assignment) {
            $totalHours = $assignment->timsheetusers
                ->where('createdBy.role_id', 14)
                ->sum(function ($timesheet) {
                    return $this->convertHourToDecimal($timesheet->hour);
                });

            $assignment->total_hours = $totalHours;
            return $assignment;
        });

        return view('backEnd.dashboardreport.billspendingassignment', compact('assignments'));
    }


    public function tendersubmitted(Request $request)
    {
        $filtersdata = $this->filtersRequest($request);

        $yearly = $filtersdata['yearly'];
        $monthsdigit = $filtersdata['monthsdigit'];
        $partnerId = $filtersdata['partnerId'];
        $startDateFormatted = $filtersdata['startDateFormatted'];
        $endDateFormatted = $filtersdata['endDateFormatted'];
        $months = $filtersdata['months'];

        // filter New Tenders Submitted this months

        $id = 4;
        $tenderDatas = DB::table('tenders')
            ->leftJoin('teammembers', 'teammembers.id', '=', 'tenders.teammember_id')
            ->where('tenders.status', $id)
            ->where('tenders.tendersubmitstatus', 1)
            // Default condition when no parameters
            ->when(empty($yearly) && empty($monthsdigit) && empty($partnerId), function ($query) {
                $query->whereMonth('tenders.tendersubmitdate', Carbon::now()->month)
                    ->whereYear('tenders.tendersubmitdate', Carbon::now()->year);
            })
            //condition when parametr will be pass
            ->when(!empty($yearly), function ($query) use ($startDateFormatted, $endDateFormatted) {
                $query->whereBetween('tenders.tendersubmitdate', [$startDateFormatted, $endDateFormatted]);
            })
            ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
                $query->whereMonth('tenders.tendersubmitdate', $monthsdigit);
            })
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

    public function İndependencepending(Request $request)
    {

        $filtersdata = $this->filtersRequest($request);

        $yearly = $filtersdata['yearly'];
        $monthsdigit = $filtersdata['monthsdigit'];
        $partnerId = $filtersdata['partnerId'];
        $startDateFormatted = $filtersdata['startDateFormatted'];
        $endDateFormatted = $filtersdata['endDateFormatted'];
        $months = $filtersdata['months'];

        // Independence Acceptance Pending
        $clientspecificindependencedeclaration =  DB::table('assignmentmappings')
            ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
            ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
            ->leftjoin('teammembers', 'teammembers.id', 'assignmentteammappings.teammember_id')
            ->leftjoin('teammembers as partner', 'partner.id', 'assignmentmappings.leadpartner')
            ->leftJoin('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
            ->leftJoin('assignments', 'assignments.id', '=', 'assignmentmappings.assignment_id')
            // ->where('assignmentmappings.assignmentgenerate_id', $id)
            ->when(!empty($yearly), function ($query) use ($startDateFormatted, $endDateFormatted) {
                $query->whereBetween(DB::raw('COALESCE(assignmentbudgetings.actualstartdate, assignmentbudgetings.tentativestartdate)'), [$startDateFormatted, $endDateFormatted]);
            })
            ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
                $query->whereMonth(DB::raw('COALESCE(assignmentbudgetings.actualstartdate, assignmentbudgetings.tentativestartdate)'), $monthsdigit);
            })
            ->when(!empty($partnerId), function ($query) use ($partnerId) {
                $query->where('assignmentmappings.leadpartner', $partnerId);
            })
            ->select('assignmentmappings.*', 'assignmentbudgetings.assignmentname', 'clients.client_name', 'assignments.assignment_name', 'teammembers.id', 'teammembers.team_member', 'partner.team_member as partnername')
            ->get();

        return view('backEnd.dashboardreport.independencepending', compact('clientspecificindependencedeclaration'));
    }

    public function paymentsnotrecievedwithindays(Request $request)
    {

        $filtersdata = $this->filtersRequest($request);

        $yearly = $filtersdata['yearly'];
        $monthsdigit = $filtersdata['monthsdigit'];
        $partnerId = $filtersdata['partnerId'];
        $startDateFormatted = $filtersdata['startDateFormatted'];
        $endDateFormatted = $filtersdata['endDateFormatted'];
        $months = $filtersdata['months'];

        $teammember = Teammember::where('role_id', '!=', 11)
            ->where('role_id', '!=', 12)
            ->with('title', 'role')
            ->get();

        // $outstandingDatas = DB::table('assignmentmappings')
        //     ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        //     ->leftJoin('invoices', 'invoices.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        //     ->leftJoin('outstandings', 'outstandings.BILL_NO', '=', 'invoices.invoice_id')
        //     ->leftJoin('payments', 'payments.invoiceid', '=', 'invoices.invoice_id')
        //     ->leftJoin('teammembers', 'teammembers.id', '=', 'outstandings.Partner')
        //     ->whereNotNull('invoices.id')
        //     ->where('assignmentbudgetings.status', 0)
        //     ->where('invoices.status', 2)
        //     ->whereNull('payments.invoiceid')
        //     ->where(function ($q) {
        //         $q->whereIn('invoices.currency', [1, 3])
        //             ->orWhereNull('invoices.currency');
        //     })
        //     ->whereBetween('invoices.created_at', [
        //         Carbon::today()->subDays(15)->startOfDay(),
        //         Carbon::today()->endOfDay()
        //     ])
        //     ->select(
        //         'outstandings.*',
        //         'invoices.currency',
        //         DB::raw("DATE_FORMAT(outstandings.created_at, '%Y-%m-%d') as bill_date"),
        //         //  DB::raw('SUM(outstandings.AMT) as total_amount')
        //         'teammembers.team_member'
        //     )
        //     ->get();

        // filter How many amounts pending for collection within 15 days or Payments Not Recieved
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
            ->when(!empty($yearly), function ($query) use ($startDateFormatted, $endDateFormatted) {
                $query->whereBetween(DB::raw('COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate)'), [$startDateFormatted, $endDateFormatted]);
            })
            ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
                $query->whereMonth(DB::raw('COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate)'), $monthsdigit);
            })
            ->when(!empty($partnerId), function ($query) use ($partnerId) {
                $query->where('invoices.partner', $partnerId);
            })
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

    public function exceptionalexpenses(Request $request)
    {
        $filtersdata = $this->filtersRequest($request);

        $yearly = $filtersdata['yearly'];
        $monthsdigit = $filtersdata['monthsdigit'];
        $partnerId = $filtersdata['partnerId'];
        $startDateFormatted = $filtersdata['startDateFormatted'];
        $endDateFormatted = $filtersdata['endDateFormatted'];
        $months = $filtersdata['months'];

        // filter total amount of convence, how many amount approved for convence in this months or Exceptional Expenses 
        $outstationData = DB::table('outstationconveyances')
            ->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', '=', 'outstationconveyances.assignmentgenerate_id')
            ->leftjoin('assignments', 'assignments.id', 'outstationconveyances.assignment_id')
            ->leftjoin('clients', 'clients.id', 'outstationconveyances.client_id')
            ->where('outstationconveyances.createdby', '!=', 336)
            ->where('outstationconveyances.conveyance', 'Local Conveyance')
            ->where('outstationconveyances.status', 6)
            ->when(empty($yearly) && empty($monthsdigit) && empty($partnerId), function ($query) {
                $query->whereMonth('outstationconveyances.paiddate', Carbon::now()->month)
                    ->whereYear('outstationconveyances.paiddate', Carbon::now()->year);
            })
            ->when(!empty($yearly), function ($query) use ($startDateFormatted, $endDateFormatted) {
                $query->whereBetween('outstationconveyances.paiddate', [$startDateFormatted, $endDateFormatted]);
            })
            ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
                $query->whereMonth('outstationconveyances.paiddate', $monthsdigit);
            })
            ->when(!empty($partnerId), function ($query) use ($partnerId) {
                $query->where('assignmentmappings.leadpartner', $partnerId);
            })
            ->select('outstationconveyances.*', 'clients.client_name', 'assignments.assignment_name  as assignmentsname')
            ->get();


        $outstationDatas = DB::table('outstationconveyances')
            ->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', '=', 'outstationconveyances.assignmentgenerate_id')
            ->leftjoin('assignments', 'assignments.id', 'outstationconveyances.assignment_id')
            ->leftjoin('clients', 'clients.id', 'outstationconveyances.client_id')
            ->where('outstationconveyances.conveyance', 'Outstation Conveyance')
            ->where('outstationconveyances.createdby', '!=', 336)
            ->where('outstationconveyances.status', 6)
            ->when(empty($yearly) && empty($monthsdigit) && empty($partnerId), function ($query) {
                $query->whereMonth('outstationconveyances.paiddate', Carbon::now()->month)
                    ->whereYear('outstationconveyances.paiddate', Carbon::now()->year);
            })
            ->when(!empty($yearly), function ($query) use ($startDateFormatted, $endDateFormatted) {
                $query->whereBetween('outstationconveyances.paiddate', [$startDateFormatted, $endDateFormatted]);
            })
            ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
                $query->whereMonth('outstationconveyances.paiddate', $monthsdigit);
            })
            ->when(!empty($partnerId), function ($query) use ($partnerId) {
                $query->where('assignmentmappings.leadpartner', $partnerId);
            })
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

    public function lossassignments(Request $request)
    {
        $yearly = $request->query('yearly');
        $monthsdigit = $request->query('monthsdigit');
        $partnerId = $request->query('partnerId');

        $startDateFormatted = null;
        $endDateFormatted = null;

        if (!empty($yearly)) {
            [$startYear, $endYear] = explode('-', $yearly);
            // $startDate = Carbon::createFromFormat('Y-m-d', $startYear . '-04-01');
            // $endDate   = Carbon::createFromFormat('Y-m-d', $endYear . '-03-31');
            $startDate = Carbon::create($startYear, 4, 1);
            $endDate = Carbon::create($endYear, 3, 31);
            $startDateFormatted = $startDate->format('Y-m-d');
            $endDateFormatted = $endDate->format('Y-m-d');
        } else {
            // Default financial year when no filters are applied
            if (empty($monthsdigit) && empty($partnerId)) {
                $currentDate = Carbon::now();
                if ($currentDate->month >= 4) {
                    // Current year financial year
                    $startDate = Carbon::create($currentDate->year, 4, 1);
                    $endDate = Carbon::create($currentDate->year + 1, 3, 31);
                } else {
                    // Previous year financial year
                    $startDate = Carbon::create($currentDate->year - 1, 4, 1);
                    $endDate = Carbon::create($currentDate->year, 3, 31);
                }
                $startDateFormatted = $startDate->format('Y-m-d');
                $endDateFormatted = $endDate->format('Y-m-d');
            }
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

        // filter Assignment-wise P&L Analysis and Loss Making Assignments
        $assignmentprofitandlosses = DB::table('assignmentmappings')
            ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
            ->leftJoin('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
            // default before filter applied
            ->when(empty($yearly) && empty($monthsdigit) && empty($partnerId) && isset($startDateFormatted) && isset($endDateFormatted), function ($query) use ($startDateFormatted, $endDateFormatted) {
                $query->whereBetween('assignmentmappings.created_at', [$startDateFormatted, $endDateFormatted]);
            })
            // after filter applied
            ->when(!empty($yearly), function ($query) use ($startDateFormatted, $endDateFormatted) {
                $query->whereBetween('assignmentmappings.created_at', [$startDateFormatted, $endDateFormatted]);
            })
            ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
                $query->whereMonth('assignmentmappings.created_at', $monthsdigit);
            })
            ->when(!empty($partnerId), function ($query) use ($partnerId) {
                $query->where('assignmentmappings.leadpartner', $partnerId);
            })
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

        $conveyanceonlybillno = DB::table('outstationconveyances')
            ->where('bill', 'No')
            ->select(
                'assignmentgenerate_id',
                DB::raw('SUM(finalamount) as finalamounts')
            )
            ->groupBy('assignmentgenerate_id')
            ->pluck('finalamounts', 'assignmentgenerate_id');

        // Filter on loss making assignments 
        $lossAssignments = $assignmentprofitandlosses->filter(function ($assignment) use ($assignmentCosts, $conveyanceonlybillno) {
            $assignmentworkedcost = $assignmentCosts[$assignment->assignmentgenerate_id] ?? 0;
            $assignmentconvencecost = $conveyanceonlybillno[$assignment->assignmentgenerate_id] ?? 0;
            $assignment->total_cost = $assignmentworkedcost + $assignmentconvencecost;
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
                ->sum(function ($timesheet) {
                    return $this->convertHourToDecimal($timesheet->hour);
                });

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

    public function filtersRequest($request)
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

        return [
            'yearly' => $yearly,
            'monthsdigit' => $monthsdigit,
            'partnerId' => $partnerId,
            'startDateFormatted' => $startDateFormatted,
            'endDateFormatted' => $endDateFormatted,
            'months' => $months,
        ];
    }


    private function convertHourToDecimal($hour)
    {
        if (is_numeric($hour)) {
            return (float) $hour;
        }
        if (preg_match('/^(\d{1,2}):(\d{1,2})$/', $hour, $matches)) {
            $h = intval($matches[1]);
            $m = intval($matches[2]);
            return $h + ($m / 60);
        }
        return 0;
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
