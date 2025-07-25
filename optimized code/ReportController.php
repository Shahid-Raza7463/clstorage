<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class ReportController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function assignment_report()
  {
    $permotioncheck = DB::table('teamrolehistory')
      ->where('teammember_id', auth()->user()->teammember_id)->first();

    if (auth()->user()->role_id == 11) {
      $assignmentmappingData =  DB::table('assignmentmappings')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
        ->where('assignmentbudgetings.status', '1')
        //------------------- Shahid's code start---------------------
        ->whereNotIn('assignmentbudgetings.assignmentname', ['Unallocated', 'Official Travel', 'Off/Holiday', 'Seminar/Conference/Post Qualification Course'])
        ->select(
          'assignmentmappings.*',
          'assignmentbudgetings.duedate',
          'assignmentbudgetings.assignmentname',
          'assignmentbudgetings.status',
          'assignments.assignment_name',
          'clients.client_name',
          'clients.client_code'
        )
        ->get();
      $assignmentmappingcloseData =  DB::table('assignmentmappings')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
        ->where('assignmentbudgetings.status', '0')
        //------------------- Shahid's code start---------------------
        ->whereNotIn('assignmentbudgetings.assignmentname', ['Unallocated', 'Official Travel', 'Off/Holiday', 'Seminar/Conference/Post Qualification Course'])
        ->select(
          'assignmentmappings.*',
          'assignmentbudgetings.duedate',
          'assignmentbudgetings.assignmentname',
          'assignmentbudgetings.status',
          'assignments.assignment_name',
          'clients.client_name',
          'clients.client_code'
        )
        ->get();
      return view('backEnd.report.assignmentreport', compact('assignmentmappingData', 'assignmentmappingcloseData'));
    }
    // if (auth()->user()->role_id == 11) {

    //   $assignmentmappingData = DB::table('assignmentmappings')
    //     ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
    //     ->leftJoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
    //     ->leftJoin('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
    //     ->leftJoin('assignments', 'assignments.id', '=', 'assignmentmappings.assignment_id')

    //     ->leftJoin('teammembers as lead', 'lead.id', '=', 'assignmentmappings.leadpartner')
    //     ->leftJoin('teamrolehistory as leadrole', 'leadrole.teammember_id', '=', 'lead.id')

    //     ->leftJoin('teammembers as other', 'other.id', '=', 'assignmentmappings.otherpartner')
    //     ->leftJoin('teamrolehistory as otherrole', 'otherrole.teammember_id', '=', 'other.id')

    //     ->where('assignmentbudgetings.status', '1')
    //     ->whereNotIn('assignmentbudgetings.assignmentname', [
    //       'Unallocated',
    //       'Official Travel',
    //       'Off/Holiday',
    //       'Seminar/Conference/Post Qualification Course'
    //     ])
    //     ->select(
    //       'assignmentmappings.*',
    //       'assignmentbudgetings.duedate',
    //       'assignmentbudgetings.assignmentname',
    //       'assignmentbudgetings.status',
    //       'assignments.assignment_name',
    //       'clients.client_name',
    //       'clients.client_code',
    //       'lead.team_member as lead_team_member',
    //       'lead.staffcode as lead_staffcode',
    //       'leadrole.newstaff_code as lead_newstaff_code',
    //       'other.team_member as other_team_member',
    //       'other.staffcode as other_staffcode',
    //       'otherrole.newstaff_code as other_newstaff_code',
    //       'assignmentteammappings.teamhour',
    //     )
    //     ->distinct()
    //     ->get();

    //   $teamMembersByType = DB::table('assignmentteammappings')
    //     ->join('teammembers', 'teammembers.id', '=', 'assignmentteammappings.teammember_id')
    //     ->select('assignmentteammappings.assignmentmapping_id', 'assignmentteammappings.type', 'teammembers.team_member')
    //     ->get()
    //     ->groupBy(['assignmentmapping_id', 'type']);


    //   $assignmentmappingcloseData = DB::table('assignmentmappings')
    //     ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
    //     ->leftJoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
    //     ->leftJoin('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
    //     ->leftJoin('assignments', 'assignments.id', '=', 'assignmentmappings.assignment_id')

    //     ->leftJoin('teammembers as lead', 'lead.id', '=', 'assignmentmappings.leadpartner')
    //     ->leftJoin('teamrolehistory as leadrole', 'leadrole.teammember_id', '=', 'lead.id')

    //     ->leftJoin('teammembers as other', 'other.id', '=', 'assignmentmappings.otherpartner')
    //     ->leftJoin('teamrolehistory as otherrole', 'otherrole.teammember_id', '=', 'other.id')

    //     ->where('assignmentbudgetings.status', '0')
    //     ->whereNotIn('assignmentbudgetings.assignmentname', ['Unallocated', 'Official Travel', 'Off/Holiday', 'Seminar/Conference/Post Qualification Course'])
    //     ->select(
    //       'assignmentmappings.*',
    //       'assignmentbudgetings.duedate',
    //       'assignmentbudgetings.assignmentname',
    //       'assignmentbudgetings.status',
    //       'assignments.assignment_name',
    //       'clients.client_name',
    //       'clients.client_code',
    //       'lead.team_member as lead_team_member',
    //       'lead.staffcode as lead_staffcode',
    //       'leadrole.newstaff_code as lead_newstaff_code',
    //       'other.team_member as other_team_member',
    //       'other.staffcode as other_staffcode',
    //       'otherrole.newstaff_code as other_newstaff_code',
    //     )
    //     ->distinct()
    //     ->get();

    //   $subteamMembers = DB::table('assignmentteammappings')
    //     ->join('teammembers', 'teammembers.id', '=', 'assignmentteammappings.teammember_id')
    //     ->whereIn('assignmentteammappings.assignmentmapping_id', $assignmentmappingcloseData->pluck('id'))
    //     ->select('assignmentteammappings.assignmentmapping_id', 'assignmentteammappings.type', 'teammembers.team_member')
    //     ->get()
    //     ->groupBy(['assignmentmapping_id', 'type']);

    //   $teamHours = DB::table('assignmentteammappings')
    //     ->whereIn('assignmentmapping_id', $assignmentmappingcloseData->pluck('id'))
    //     ->select('assignmentmapping_id', DB::raw('SUM(teamhour) as teamhour'))
    //     ->groupBy('assignmentmapping_id')
    //     ->pluck('teamhour', 'assignmentmapping_id');



    //   return view('backEnd.report.assignmentreport', compact('assignmentmappingData', 'assignmentmappingcloseData', 'teamMembersByType', 'subteamMembers', 'teamHours'));
    // } 
    if (auth()->user()->role_id == 11) {

      // Active assignments
      $assignmentmappingData = DB::table('assignmentmappings')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->leftJoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
        ->leftJoin('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
        ->leftJoin('assignments', 'assignments.id', '=', 'assignmentmappings.assignment_id')

        ->leftJoin('teammembers as lead', 'lead.id', '=', 'assignmentmappings.leadpartner')
        ->leftJoin('teamrolehistory as leadrole', 'leadrole.teammember_id', '=', 'lead.id')

        ->leftJoin('teammembers as other', 'other.id', '=', 'assignmentmappings.otherpartner')
        ->leftJoin('teamrolehistory as otherrole', 'otherrole.teammember_id', '=', 'other.id')

        ->where('assignmentbudgetings.status', '1')
        ->whereNotIn('assignmentbudgetings.assignmentname', [
          'Unallocated',
          'Official Travel',
          'Off/Holiday',
          'Seminar/Conference/Post Qualification Course'
        ])
        ->select(
          'assignmentmappings.*',
          'assignmentbudgetings.duedate',
          'assignmentbudgetings.assignmentname',
          'assignmentbudgetings.status',
          'assignments.assignment_name',
          'clients.client_name',
          'clients.client_code',
          'lead.team_member as lead_team_member',
          'lead.staffcode as lead_staffcode',
          'leadrole.newstaff_code as lead_newstaff_code',
          'other.team_member as other_team_member',
          'other.staffcode as other_staffcode',
          'otherrole.newstaff_code as other_newstaff_code'
        )
        ->distinct()
        ->get();

      // Subteam member mapping (for active assignments)
      $teamMembersByType = DB::table('assignmentteammappings')
        ->join('teammembers', 'teammembers.id', '=', 'assignmentteammappings.teammember_id')
        ->select('assignmentteammappings.assignmentmapping_id', 'assignmentteammappings.type', 'teammembers.team_member')
        ->get()
        ->groupBy(['assignmentmapping_id', 'type']);

      // Closed assignments
      $assignmentmappingcloseData = DB::table('assignmentmappings')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->leftJoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
        ->leftJoin('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
        ->leftJoin('assignments', 'assignments.id', '=', 'assignmentmappings.assignment_id')

        ->leftJoin('teammembers as lead', 'lead.id', '=', 'assignmentmappings.leadpartner')
        ->leftJoin('teamrolehistory as leadrole', 'leadrole.teammember_id', '=', 'lead.id')

        ->leftJoin('teammembers as other', 'other.id', '=', 'assignmentmappings.otherpartner')
        ->leftJoin('teamrolehistory as otherrole', 'otherrole.teammember_id', '=', 'other.id')

        ->where('assignmentbudgetings.status', '0')
        ->whereNotIn('assignmentbudgetings.assignmentname', [
          'Unallocated',
          'Official Travel',
          'Off/Holiday',
          'Seminar/Conference/Post Qualification Course'
        ])
        ->select(
          'assignmentmappings.*',
          'assignmentbudgetings.duedate',
          'assignmentbudgetings.assignmentname',
          'assignmentbudgetings.status',
          'assignments.assignment_name',
          'clients.client_name',
          'clients.client_code',
          'lead.team_member as lead_team_member',
          'lead.staffcode as lead_staffcode',
          'leadrole.newstaff_code as lead_newstaff_code',
          'other.team_member as other_team_member',
          'other.staffcode as other_staffcode',
          'otherrole.newstaff_code as other_newstaff_code'
        )
        ->distinct()
        ->get();

      // Subteam mapping for closed assignments
      $subteamMembers = DB::table('assignmentteammappings')
        ->join('teammembers', 'teammembers.id', '=', 'assignmentteammappings.teammember_id')
        ->whereIn('assignmentteammappings.assignmentmapping_id', $assignmentmappingcloseData->pluck('id'))
        ->select('assignmentteammappings.assignmentmapping_id', 'assignmentteammappings.type', 'teammembers.team_member')
        ->get()
        ->groupBy(['assignmentmapping_id', 'type']);

      // Team hours for closed assignments
      $teamHours = DB::table('assignmentteammappings')
        ->whereIn('assignmentmapping_id', $assignmentmappingcloseData->pluck('id'))
        ->select('assignmentmapping_id', DB::raw('SUM(teamhour) as teamhour'))
        ->groupBy('assignmentmapping_id')
        ->pluck('teamhour', 'assignmentmapping_id');

      return view('backEnd.report.assignmentreport', compact('assignmentmappingData', 'assignmentmappingcloseData', 'teamMembersByType', 'subteamMembers', 'teamHours'));
    } elseif ($permotioncheck && auth()->user()->role_id == 13) {
      $assignmentmappingDatabefore =  DB::table('assignmentmappings')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
        ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
        ->where('assignmentbudgetings.status', '1')
        ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
        //------------------- Shahid's code start---------------------
        ->whereNotIn('assignmentbudgetings.assignmentname', ['Unallocated', 'Official Travel', 'Off/Holiday', 'Seminar/Conference/Post Qualification Course'])
        ->select(
          'assignmentmappings.*',
          'assignmentbudgetings.duedate',
          'assignmentbudgetings.assignmentname',
          'assignmentbudgetings.status',
          'assignments.assignment_name',
          'clients.client_name',
          'clients.client_code',
          'assignmentteammappings.teamhour',
        )->get();



      $assignmentmappingOpenleadpartner =  DB::table('assignmentmappings')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
        ->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
        ->where('assignmentbudgetings.status', '1')
        //------------------- Shahid's code start---------------------
        ->whereNotIn('assignmentbudgetings.assignmentname', ['Unallocated', 'Official Travel', 'Off/Holiday', 'Seminar/Conference/Post Qualification Course'])
        ->select(
          'assignmentmappings.*',
          'assignmentbudgetings.duedate',
          'assignmentbudgetings.assignmentname',
          'assignmentbudgetings.status',
          'assignments.assignment_name',
          'clients.client_name',
          'clients.client_code',
          'assignmentmappings.leadpartner',
        )
        ->get();

      $assignmentmappingOpenotherpartner =  DB::table('assignmentmappings')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
        ->where('assignmentmappings.otherpartner', auth()->user()->teammember_id)
        ->where('assignmentbudgetings.status', '1')
        //------------------- Shahid's code start---------------------
        ->whereNotIn('assignmentbudgetings.assignmentname', ['Unallocated', 'Official Travel', 'Off/Holiday', 'Seminar/Conference/Post Qualification Course'])
        ->select(
          'assignmentmappings.*',
          'assignmentbudgetings.duedate',
          'assignmentbudgetings.assignmentname',
          'assignmentbudgetings.status',
          'assignments.assignment_name',
          'clients.client_name',
          'clients.client_code',
          'assignmentmappings.otherpartner',

        )
        ->get();
      $assignmentmappingData = $assignmentmappingOpenotherpartner->merge($assignmentmappingOpenleadpartner)->merge($assignmentmappingDatabefore);

      $assignmentmappingcloseDatabefore =  DB::table('assignmentmappings')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
        ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
        ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
        ->where('assignmentbudgetings.status', '0')
        //------------------- Shahid's code start---------------------
        ->whereNotIn('assignmentbudgetings.assignmentname', ['Unallocated', 'Official Travel', 'Off/Holiday', 'Seminar/Conference/Post Qualification Course'])
        ->select(
          'assignmentmappings.*',
          'assignmentbudgetings.duedate',
          'assignmentbudgetings.assignmentname',
          'assignmentbudgetings.status',
          'assignments.assignment_name',
          'clients.client_name',
          'clients.client_code',
          'assignmentteammappings.teamhour',
        )->get();

      // dd($assignmentmappingData);
      $assignmentmappingClosedleadpartner =  DB::table('assignmentmappings')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
        ->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
        ->where('assignmentbudgetings.status', '0')
        //------------------- Shahid's code start---------------------
        ->whereNotIn('assignmentbudgetings.assignmentname', ['Unallocated', 'Official Travel', 'Off/Holiday', 'Seminar/Conference/Post Qualification Course'])
        ->select(
          'assignmentmappings.*',
          'assignmentbudgetings.duedate',
          'assignmentbudgetings.assignmentname',
          'assignmentbudgetings.status',
          'assignments.assignment_name',
          'clients.client_name',
          'clients.client_code',
          'assignmentmappings.leadpartner',
        )->get();

      $assignmentmappingClosedotherpartner =  DB::table('assignmentmappings')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
        ->where('assignmentmappings.otherpartner', auth()->user()->teammember_id)
        ->where('assignmentbudgetings.status', '0')
        //------------------- Shahid's code start---------------------
        ->whereNotIn('assignmentbudgetings.assignmentname', ['Unallocated', 'Official Travel', 'Off/Holiday', 'Seminar/Conference/Post Qualification Course'])
        ->select(
          'assignmentmappings.*',
          'assignmentbudgetings.duedate',
          'assignmentbudgetings.assignmentname',
          'assignmentbudgetings.status',
          'assignments.assignment_name',
          'clients.client_name',
          'clients.client_code',
          'assignmentmappings.otherpartner',
        )->get();

      $assignmentmappingcloseData = $assignmentmappingClosedotherpartner->merge($assignmentmappingClosedleadpartner)->merge($assignmentmappingcloseDatabefore);

      // dd($assignmentmappingData);
      return view('backEnd.report.assignmentreport', compact('assignmentmappingData', 'assignmentmappingcloseData'));
    }
    // elseif (auth()->user()->role_id == 13) {

    //   $assignmentmappingData = DB::table('assignmentmappings')
    //     ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
    //     ->leftJoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
    //     ->leftJoin('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
    //     ->leftJoin('assignments', 'assignments.id', '=', 'assignmentmappings.assignment_id')
    //     ->where('assignmentbudgetings.status', '1')
    //     ->whereNotIn('assignmentbudgetings.assignmentname', ['Unallocated', 'Official Travel', 'Off/Holiday', 'Seminar/Conference/Post Qualification Course'])
    //     ->where(function ($query) {
    //       $userId = auth()->user()->teammember_id;
    //       $query->where('assignmentmappings.leadpartner', $userId)
    //         ->orWhere('assignmentmappings.otherpartner', $userId)
    //         ->orWhere('assignmentteammappings.teammember_id', $userId);
    //     })
    //     ->select(
    //       'assignmentmappings.*',
    //       'assignmentbudgetings.duedate',
    //       'assignmentbudgetings.assignmentname',
    //       'assignmentbudgetings.status',
    //       'assignments.assignment_name',
    //       'clients.client_name',
    //       'clients.client_code',
    //       'assignmentmappings.leadpartner',
    //       'assignmentmappings.otherpartner'
    //     )
    //     ->distinct()
    //     ->get();

    //   // $assignmentmappingClosedleadpartner =  DB::table('assignmentmappings')
    //   //   ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
    //   //   ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
    //   //   ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
    //   //   ->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
    //   //   ->where('assignmentbudgetings.status', '0')
    //   //   //------------------- Shahid's code start---------------------
    //   //   ->whereNotIn('assignmentbudgetings.assignmentname', ['Unallocated', 'Official Travel', 'Off/Holiday', 'Seminar/Conference/Post Qualification Course'])
    //   //   ->select(
    //   //     'assignmentmappings.*',
    //   //     'assignmentbudgetings.duedate',
    //   //     'assignmentbudgetings.assignmentname',
    //   //     'assignmentbudgetings.status',
    //   //     'assignments.assignment_name',
    //   //     'clients.client_name',
    //   //     'clients.client_code',
    //   //     'assignmentmappings.leadpartner',
    //   //   )->get();

    //   // $assignmentmappingClosedotherpartner =  DB::table('assignmentmappings')
    //   //   ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
    //   //   ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
    //   //   ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
    //   //   ->where('assignmentmappings.otherpartner', auth()->user()->teammember_id)
    //   //   ->where('assignmentbudgetings.status', '0')
    //   //   //------------------- Shahid's code start---------------------
    //   //   ->whereNotIn('assignmentbudgetings.assignmentname', ['Unallocated', 'Official Travel', 'Off/Holiday', 'Seminar/Conference/Post Qualification Course'])
    //   //   ->select(
    //   //     'assignmentmappings.*',
    //   //     'assignmentbudgetings.duedate',
    //   //     'assignmentbudgetings.assignmentname',
    //   //     'assignmentbudgetings.status',
    //   //     'assignments.assignment_name',
    //   //     'clients.client_name',
    //   //     'clients.client_code',
    //   //     'assignmentmappings.otherpartner',
    //   //   )->get();

    //   // $assignmentmappingcloseData = $assignmentmappingClosedotherpartner->merge($assignmentmappingClosedleadpartner);

    //   $assignmentmappingcloseData = DB::table('assignmentmappings')
    //     ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
    //     ->leftJoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
    //     ->leftJoin('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
    //     ->leftJoin('assignments', 'assignments.id', '=', 'assignmentmappings.assignment_id')
    //     ->where('assignmentbudgetings.status', '0')
    //     ->whereNotIn('assignmentbudgetings.assignmentname', ['Unallocated', 'Official Travel', 'Off/Holiday', 'Seminar/Conference/Post Qualification Course'])
    //     ->where(function ($query) {
    //       $userId = auth()->user()->teammember_id;
    //       $query->where('assignmentmappings.leadpartner', $userId)
    //         ->orWhere('assignmentmappings.otherpartner', $userId)
    //         ->orWhere('assignmentteammappings.teammember_id', $userId);
    //     })
    //     ->select(
    //       'assignmentmappings.*',
    //       'assignmentbudgetings.duedate',
    //       'assignmentbudgetings.assignmentname',
    //       'assignmentbudgetings.status',
    //       'assignments.assignment_name',
    //       'clients.client_name',
    //       'clients.client_code',
    //       'assignmentmappings.leadpartner',
    //       'assignmentmappings.otherpartner'
    //     )
    //     ->distinct()
    //     ->get();

    //   // dd($assignmentmappingcloseData);

    //   return view('backEnd.report.assignmentreport', compact('assignmentmappingData', 'assignmentmappingcloseData'));
    // }
    elseif (auth()->user()->role_id == 13) {

      $assignmentmappingData = DB::table('assignmentmappings')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->leftJoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
        ->leftJoin('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
        ->leftJoin('assignments', 'assignments.id', '=', 'assignmentmappings.assignment_id')

        ->leftJoin('teammembers as lead', 'lead.id', '=', 'assignmentmappings.leadpartner')
        ->leftJoin('teamrolehistory as leadrole', 'leadrole.teammember_id', '=', 'lead.id')

        ->leftJoin('teammembers as other', 'other.id', '=', 'assignmentmappings.otherpartner')
        ->leftJoin('teamrolehistory as otherrole', 'otherrole.teammember_id', '=', 'other.id')

        ->where('assignmentbudgetings.status', '1')
        ->whereNotIn('assignmentbudgetings.assignmentname', [
          'Unallocated',
          'Official Travel',
          'Off/Holiday',
          'Seminar/Conference/Post Qualification Course'
        ])
        ->where(function ($query) {
          $userId = auth()->user()->teammember_id;
          $query->where('assignmentmappings.leadpartner', $userId)
            ->orWhere('assignmentmappings.otherpartner', $userId)
            ->orWhere('assignmentteammappings.teammember_id', $userId);
        })
        ->select(
          'assignmentmappings.*',
          'assignmentbudgetings.duedate',
          'assignmentbudgetings.assignmentname',
          'assignmentbudgetings.status',
          'assignments.assignment_name',
          'clients.client_name',
          'clients.client_code',
          'lead.team_member as lead_team_member',
          'lead.staffcode as lead_staffcode',
          'leadrole.newstaff_code as lead_newstaff_code',
          'other.team_member as other_team_member',
          'other.staffcode as other_staffcode',
          'otherrole.newstaff_code as other_newstaff_code'
        )
        ->distinct()
        ->get();

      $teamMembersByType = DB::table('assignmentteammappings')
        ->join('teammembers', 'teammembers.id', '=', 'assignmentteammappings.teammember_id')
        ->select('assignmentteammappings.assignmentmapping_id', 'assignmentteammappings.type', 'teammembers.team_member')
        ->get()
        ->groupBy(['assignmentmapping_id', 'type']);



      $assignmentmappingcloseData = DB::table('assignmentmappings')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->leftJoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
        ->leftJoin('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
        ->leftJoin('assignments', 'assignments.id', '=', 'assignmentmappings.assignment_id')

        ->leftJoin('teammembers as lead', 'lead.id', '=', 'assignmentmappings.leadpartner')
        ->leftJoin('teamrolehistory as leadrole', 'leadrole.teammember_id', '=', 'lead.id')

        ->leftJoin('teammembers as other', 'other.id', '=', 'assignmentmappings.otherpartner')
        ->leftJoin('teamrolehistory as otherrole', 'otherrole.teammember_id', '=', 'other.id')
        ->where('assignmentbudgetings.status', '0')
        ->whereNotIn('assignmentbudgetings.assignmentname', ['Unallocated', 'Official Travel', 'Off/Holiday', 'Seminar/Conference/Post Qualification Course'])
        ->where(function ($query) {
          $userId = auth()->user()->teammember_id;
          $query->where('assignmentmappings.leadpartner', $userId)
            ->orWhere('assignmentmappings.otherpartner', $userId)
            ->orWhere('assignmentteammappings.teammember_id', $userId);
        })
        ->select(
          'assignmentmappings.*',
          'assignmentbudgetings.duedate',
          'assignmentbudgetings.assignmentname',
          'assignmentbudgetings.status',
          'assignments.assignment_name',
          'clients.client_name',
          'clients.client_code',
          'lead.team_member as lead_team_member',
          'lead.staffcode as lead_staffcode',
          'leadrole.newstaff_code as lead_newstaff_code',
          'other.team_member as other_team_member',
          'other.staffcode as other_staffcode',
          'otherrole.newstaff_code as other_newstaff_code'
        )
        ->distinct()
        ->get();

      $subteamMembers = DB::table('assignmentteammappings')
        ->join('teammembers', 'teammembers.id', '=', 'assignmentteammappings.teammember_id')
        ->whereIn('assignmentteammappings.assignmentmapping_id', $assignmentmappingcloseData->pluck('id'))
        ->select('assignmentteammappings.assignmentmapping_id', 'assignmentteammappings.type', 'teammembers.team_member')
        ->get()
        ->groupBy(['assignmentmapping_id', 'type']);

      $teamHours = DB::table('assignmentteammappings')
        ->whereIn('assignmentmapping_id', $assignmentmappingcloseData->pluck('id'))
        ->select('assignmentmapping_id', DB::raw('SUM(teamhour) as teamhour'))
        ->groupBy('assignmentmapping_id')
        ->pluck('teamhour', 'assignmentmapping_id');


      return view('backEnd.report.assignmentreport', compact('assignmentmappingData', 'assignmentmappingcloseData', 'teamMembersByType', 'subteamMembers', 'teamHours'));
    }
    // else {
    //   $assignmentmappingData =  DB::table('assignmentmappings')
    //     ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
    //     ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
    //     ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
    //     ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
    //     ->where('assignmentbudgetings.status', '1')
    //     ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
    //     ->where('assignmentteammappings.status', 1)
    //     ->whereNotIn('assignmentbudgetings.assignmentname', ['Unallocated', 'Official Travel', 'Off/Holiday', 'Seminar/Conference/Post Qualification Course'])
    //     ->select(
    //       'assignmentmappings.*',
    //       'assignmentbudgetings.duedate',
    //       'assignmentbudgetings.assignmentname',
    //       'assignmentbudgetings.status',
    //       'assignments.assignment_name',
    //       'clients.client_name',
    //       'clients.client_code',
    //       'assignmentteammappings.teamhour',
    //     )->get();


    //   $assignmentmappingcloseData =  DB::table('assignmentmappings')
    //     ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
    //     ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
    //     ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
    //     ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
    //     ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
    //     ->where('assignmentbudgetings.status', '0')
    //     ->where('assignmentteammappings.status', 1)
    //     ->whereNotIn('assignmentbudgetings.assignmentname', ['Unallocated', 'Official Travel', 'Off/Holiday', 'Seminar/Conference/Post Qualification Course'])
    //     ->select(
    //       'assignmentmappings.*',
    //       'assignmentbudgetings.duedate',
    //       'assignmentbudgetings.assignmentname',
    //       'assignmentbudgetings.status',
    //       'assignments.assignment_name',
    //       'clients.client_name',
    //       'clients.client_code',
    //       'assignmentteammappings.teamhour',
    //     )->get();

    //   return view('backEnd.report.assignmentreport', compact('assignmentmappingData', 'assignmentmappingcloseData'));

    // }
    else {

      $assignmentmappingData = DB::table('assignmentmappings')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->leftJoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
        ->leftJoin('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
        ->leftJoin('assignments', 'assignments.id', '=', 'assignmentmappings.assignment_id')

        ->leftJoin('teammembers as lead', 'lead.id', '=', 'assignmentmappings.leadpartner')
        ->leftJoin('teamrolehistory as leadrole', 'leadrole.teammember_id', '=', 'lead.id')

        ->leftJoin('teammembers as other', 'other.id', '=', 'assignmentmappings.otherpartner')
        ->leftJoin('teamrolehistory as otherrole', 'otherrole.teammember_id', '=', 'other.id')

        ->where('assignmentbudgetings.status', '1')
        ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
        ->where('assignmentteammappings.status', 1)
        ->whereNotIn('assignmentbudgetings.assignmentname', [
          'Unallocated',
          'Official Travel',
          'Off/Holiday',
          'Seminar/Conference/Post Qualification Course'
        ])
        ->select(
          'assignmentmappings.*',
          'assignmentbudgetings.duedate',
          'assignmentbudgetings.assignmentname',
          'assignmentbudgetings.status',
          'assignments.assignment_name',
          'clients.client_name',
          'clients.client_code',
          'lead.team_member as lead_team_member',
          'lead.staffcode as lead_staffcode',
          'leadrole.newstaff_code as lead_newstaff_code',
          'other.team_member as other_team_member',
          'other.staffcode as other_staffcode',
          'otherrole.newstaff_code as other_newstaff_code',
          'assignmentteammappings.teamhour',
        )
        ->distinct()
        ->get();

      $teamMembersByType = DB::table('assignmentteammappings')
        ->join('teammembers', 'teammembers.id', '=', 'assignmentteammappings.teammember_id')
        ->select('assignmentteammappings.assignmentmapping_id', 'assignmentteammappings.type', 'teammembers.team_member')
        ->get()
        ->groupBy(['assignmentmapping_id', 'type']);


      $assignmentmappingcloseData = DB::table('assignmentmappings')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->leftJoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
        ->leftJoin('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
        ->leftJoin('assignments', 'assignments.id', '=', 'assignmentmappings.assignment_id')

        ->leftJoin('teammembers as lead', 'lead.id', '=', 'assignmentmappings.leadpartner')
        ->leftJoin('teamrolehistory as leadrole', 'leadrole.teammember_id', '=', 'lead.id')

        ->leftJoin('teammembers as other', 'other.id', '=', 'assignmentmappings.otherpartner')
        ->leftJoin('teamrolehistory as otherrole', 'otherrole.teammember_id', '=', 'other.id')

        ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
        ->where('assignmentbudgetings.status', '0')
        ->where('assignmentteammappings.status', 1)
        ->whereNotIn('assignmentbudgetings.assignmentname', ['Unallocated', 'Official Travel', 'Off/Holiday', 'Seminar/Conference/Post Qualification Course'])
        ->select(
          'assignmentmappings.*',
          'assignmentbudgetings.duedate',
          'assignmentbudgetings.assignmentname',
          'assignmentbudgetings.status',
          'assignments.assignment_name',
          'clients.client_name',
          'clients.client_code',
          'lead.team_member as lead_team_member',
          'lead.staffcode as lead_staffcode',
          'leadrole.newstaff_code as lead_newstaff_code',
          'other.team_member as other_team_member',
          'other.staffcode as other_staffcode',
          'otherrole.newstaff_code as other_newstaff_code',
          'assignmentteammappings.teamhour',
        )
        ->distinct()
        ->get();

      $subteamMembers = DB::table('assignmentteammappings')
        ->join('teammembers', 'teammembers.id', '=', 'assignmentteammappings.teammember_id')
        ->whereIn('assignmentteammappings.assignmentmapping_id', $assignmentmappingcloseData->pluck('id'))
        ->select('assignmentteammappings.assignmentmapping_id', 'assignmentteammappings.type', 'teammembers.team_member')
        ->get()
        ->groupBy(['assignmentmapping_id', 'type']);

      $teamHours = DB::table('assignmentteammappings')
        ->whereIn('assignmentmapping_id', $assignmentmappingcloseData->pluck('id'))
        ->select('assignmentmapping_id', DB::raw('SUM(teamhour) as teamhour'))
        ->groupBy('assignmentmapping_id')
        ->pluck('teamhour', 'assignmentmapping_id');

      return view('backEnd.report.assignmentreport', compact('assignmentmappingData', 'assignmentmappingcloseData', 'teamMembersByType', 'subteamMembers', 'teamHours'));
    }
  }
}
