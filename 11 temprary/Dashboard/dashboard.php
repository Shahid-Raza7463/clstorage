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

  // final index function 

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


      // How many amounts pending for invoice genrated or  Bills Pending
      $billspending = DB::table('assignmentmappings')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftJoin('invoices', 'invoices.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->whereNull('invoices.assignmentgenerate_id')
        ->where('assignmentbudgetings.status', 0)
        ->sum('assignmentmappings.engagementfee');

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

      // How many delayed Assignments
      $delayedAssignments = DB::table('assignmentmappings')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        // ->where('assignmentbudgetings.status', 1)
        ->whereRaw('COALESCE(DATE(assignmentbudgetings.actualenddate), DATE(assignmentbudgetings.tentativeenddate)) < ?', [Carbon::today()->toDateString()])
        ->count();

      // How many tender submitted this months
      $tendersSubmittedCount = DB::table('tenders')
        ->where('tendersubmitstatus', 1)
        ->whereMonth('tendersubmitdate', Carbon::now()->month)
        ->whereYear('tendersubmitdate', Carbon::now()->year)
        ->count();

      // How many NAFRA are running
      $auditsDue = DB::table('assignmentmappings')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->where('assignmentbudgetings.status', 1)
        ->where('assignmentmappings.eqcrapplicability', 1)
        ->count();

      // total amount of convence, how many amount approved for convence in this months or Exceptional Expenses 
      $exceptionalExpenses = DB::table('outstationconveyances')
        ->where('status', 6)
        ->whereMonth('approveddate', Carbon::now()->month)
        ->whereYear('approveddate', Carbon::now()->year)
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

      // dd($assignmentprofitandlosses);

      $lossMakingCount = 0;
      foreach ($assignmentprofitandlosses as $assignment) {
        $assignment->total_cost = $assignmentCosts[$assignment->assignmentgenerate_id] ?? 0;

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

      $invoices = DB::table('invoices')
        ->select(
          'invoices.assignmentgenerate_id',
          'teammembers.team_member',
          DB::raw('SUM(invoices.total) as total')
        )
        ->join('teammembers', 'teammembers.id', '=', 'invoices.partner')
        ->whereIn('invoices.assignmentgenerate_id', $assignmentGenerateIds)
        ->groupBy('invoices.assignmentgenerate_id', 'teammembers.team_member')
        ->get();

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

      $finalData = $invoices->map(function ($row) use ($groupedCosts) {
        $row->cost = $groupedCosts[$row->assignmentgenerate_id] ?? 0;
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
        ->selectRaw('MONTH(approveddate) as month, YEAR(approveddate) as year, SUM(finalamount) as total_amount')
        ->where('status', 6)
        ->whereBetween('approveddate', [
          $financialStartDate->format('Y-m-d'),
          $financialEndDate->format('Y-m-d')
        ])
        ->groupByRaw('MONTH(approveddate), YEAR(approveddate)')
        ->orderByRaw('FIELD(MONTH(approveddate),  4,5,6,7,8,9,10,11,12,1,2,3)')
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
      // 4.cash spend on employee and vender employeepayrolls and vendorlist tables 

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
      session()->forget('_old_input');

      return view('backEnd.kgsdashboardreport', compact('budgetactualcash', 'financialYears', 'workFromHome', 'budgetRevenueandbudgetExpences', 'budgetActualRevenue', 'budgetActualExpences', 'assignmentsWithInvoices', 'assignmentBilling', 'assignmentOutstanding', 'cashRecovery', 'cashFlowtotalspendData', 'cashFlowRecieved', 'teamexceptionalExpenses', 'teamsSalaries', 'teamAllocatedHours', 'timesheetOnClosedAssignment', 'totalNotFilled', 'partnerWiseProfit', 'lossMakingCount', 'billspending15Days', 'totalUpcomingAssignments', 'assignmentprofitandlosses', 'allTickets', 'hrTickets', 'ticketDatas', 'highpriorityAssignments', 'ecqrAudits', 'documentCompletions', 'assignmentOverviews',  'exceptionalExpenses', 'auditsDue', 'tendersSubmittedCount', 'delayedAssignments', 'assignmentcompleted', 'billspendingforcollection', 'billspending'));
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
}
