<?php

namespace App\Http\Controllers;

use App\Rules\ExcelColumnHeading;
use App\Models\Debtor;
use App\Models\Teammember;

class KrasController extends Controller
{

        public function handle()
        {
                // if (now()->format('H:i') === '18:01') {
                // if ('Wednesday' == date('l', time()) || 'Saturday' == date('l', time())) {
                // Get distinct createdby values
                $createdby = DB::table('timesheetusers')->distinct()->pluck('createdby')->toArray();

                $latestHistory = DB::table('teamrolehistory as teamrolehistorydata')
                        ->select('teamrolehistorydata.teammember_id', 'teamrolehistorydata.newstaff_code')
                        ->whereRaw('teamrolehistorydata.id = (SELECT MAX(teamrolehistorylatest.id) FROM teamrolehistory as teamrolehistorylatest WHERE teamrolehistorylatest.teammember_id = teamrolehistorydata.teammember_id)');

                // Team members who have saved timesheets but not submitted
                $teammemberOnlySave = DB::table('teammembers')
                        ->leftJoin('timesheets', 'timesheets.created_by', 'teammembers.id')
                        ->leftJoinSub($latestHistory, 'latestrecord', function ($join) {
                                $join->on('latestrecord.teammember_id', '=', 'teammembers.id');
                        })
                        ->where('teammembers.status', 1)
                        ->whereIn('timesheets.created_by', $createdby)
                        ->select('teammembers.team_member', 'teammembers.emailid', 'teammembers.id', 'teammembers.staffcode', 'latestrecord.newstaff_code')
                        ->groupBy('teammembers.team_member', 'teammembers.emailid', 'teammembers.id', 'teammembers.staffcode', 'latestrecord.newstaff_code')
                        // The total number of distinct timesheet records (COUNT(DISTINCT timesheets.id)) is equal to the number of timesheets that have status = 0
                        ->havingRaw('COUNT(DISTINCT timesheets.id) = COUNT(CASE WHEN timesheets.status = 0 THEN 1 ELSE NULL END)')
                        ->get();

                // Team members who have never filled a timesheet
                $teammemberNeverFilled = DB::table('teammembers')
                        ->leftJoin('timesheetusers', 'timesheetusers.createdby', 'teammembers.id')
                        ->leftJoinSub($latestHistory, 'latestrecord', function ($join) {
                                $join->on('latestrecord.teammember_id', '=', 'teammembers.id');
                        })
                        ->whereNull('timesheetusers.createdby')
                        ->where('teammembers.status', 1)
                        ->whereIn('teammembers.role_id', [14, 15, 13, 11])
                        ->select('teammembers.team_member', 'teammembers.emailid', 'teammembers.id', 'teammembers.staffcode', 'latestrecord.newstaff_code')
                        ->get();

                // Team members rejoining on different or same posts
                $rejoiningUsers = DB::table('teamrolehistory')
                        ->leftJoin('teammembers', 'teammembers.id', '=', 'teamrolehistory.teammember_id')
                        ->leftJoinSub($latestHistory, 'latestrecord', function ($join) {
                                $join->on('latestrecord.teammember_id', '=', 'teammembers.id');
                        })
                        ->select('teamrolehistory.id', 'teamrolehistory.teammember_id', 'teammembers.team_member', 'teammembers.emailid', 'teammembers.staffcode', 'latestrecord.newstaff_code')
                        ->distinct()
                        ->get()
                        ->merge(
                                DB::table('rejoiningsamepost')
                                        ->leftJoin('teammembers', 'teammembers.id', '=', 'rejoiningsamepost.teammember_id')
                                        ->leftJoinSub($latestHistory, 'latestrecord', function ($join) {
                                                $join->on('latestrecord.teammember_id', '=', 'teammembers.id');
                                        })
                                        ->select('rejoiningsamepost.id', 'rejoiningsamepost.teammember_id', 'teammembers.team_member', 'teammembers.emailid', 'teammembers.staffcode', 'latestrecord.newstaff_code')
                                        ->distinct()
                                        ->get()
                        );

                $rejoiningUserIds = $rejoiningUsers->pluck('teammember_id')->unique()->toArray();
                $lastWeekEnd = now()->subWeeks(1)->endOfWeek();

                $lastSubmissionDates = DB::table('timesheetusers')
                        ->select('createdby', DB::raw('MAX(date) as last_submission_date'))
                        ->whereIn('createdby', $rejoiningUserIds)
                        ->where('date', '<=', $lastWeekEnd)
                        ->where('status', '!=', 0)
                        ->where(function ($query) {
                                $query->whereRaw('DAYOFWEEK(date) = 1') // Sunday
                                        ->orWhereRaw('DAYOFWEEK(date) = 7'); // Saturday
                        })
                        ->groupBy('createdby')
                        ->pluck('last_submission_date', 'createdby');

                // Check rejoining users
                $latestTeamRoleHistory = DB::table('teamrolehistory as trh')
                        ->select('trh.teammember_id', 'trh.rejoiningdate', 'trh.promotion_date')
                        ->whereRaw('trh.id = (SELECT MAX(id) FROM teamrolehistory WHERE teammember_id = trh.teammember_id)');

                $latestRejoiningSamePost = DB::table('rejoiningsamepost as rsp')
                        ->select('rsp.teammember_id', 'rsp.rejoiningdate as samepostrejoiningdate')
                        ->whereRaw('rsp.id = (SELECT MAX(id) FROM rejoiningsamepost WHERE teammember_id = rsp.teammember_id)');

                $rejoiningData = DB::table('teammembers as tm')
                        ->leftJoinSub($latestTeamRoleHistory, 'latest_trh', function ($join) {
                                $join->on('latest_trh.teammember_id', '=', 'tm.id');
                        })
                        ->leftJoinSub($latestRejoiningSamePost, 'latest_rsp', function ($join) {
                                $join->on('latest_rsp.teammember_id', '=', 'tm.id');
                        })
                        ->whereIn('tm.id', $rejoiningUserIds)
                        ->select(
                                'tm.id',
                                'latest_trh.rejoiningdate',
                                'latest_trh.promotion_date',
                                'latest_rsp.samepostrejoiningdate'
                        )
                        ->get()
                        ->keyBy('id');

                foreach ($rejoiningUsers as $user) {
                        $lastSubmissionDate = $lastSubmissionDates->get($user->teammember_id);

                        $user->last_submission_date = $lastSubmissionDate ? Carbon::parse($lastSubmissionDate)->format('d-m-Y') : '';
                        $user->staffcode = $user->newstaff_code ?: ($user->staffcode ?? '');

                        // check promotion user
                        $rejoiningUserData = $rejoiningData->get($user->teammember_id);

                        if (!$rejoiningUserData) {
                                continue;
                        }

                        $rejoiningDate = $rejoiningUserData->samepostrejoiningdate ?? $rejoiningUserData->rejoiningdate;

                        if ($rejoiningUserData->rejoiningdate == null && $rejoiningUserData->samepostrejoiningdate == null) {
                                $rejoiningDate = $rejoiningUserData->promotion_date;
                        }

                        if (!$rejoiningDate) {
                                continue;
                        }

                        $rejoiningDateCarbon = Carbon::parse($rejoiningDate);

                        if (!$lastSubmissionDate || !Carbon::parse($lastSubmissionDate)->lessThan($rejoiningDateCarbon)) {
                                $user->last_submission_date = ''; // Skip user
                        }
                }

                // Prepare Excel data
                $excelData = $rejoiningUsers->filter(function ($user) {
                        return !empty($user->last_submission_date);
                })->map(function ($user) {
                        return [
                                'team_member' => $user->team_member,
                                'staffcode' => $user->staffcode,
                                'emailid' => $user->emailid,
                        ];
                })->merge($teammemberOnlySave->map(function ($user) {
                        return [
                                'team_member' => $user->team_member,
                                'staffcode' => $user->newstaff_code ?: ($user->staffcode ?? ''),
                                'emailid' => $user->emailid,
                        ];
                }))->merge($teammemberNeverFilled->map(function ($user) {
                        return [
                                'team_member' => $user->team_member,
                                'staffcode' => $user->newstaff_code ?: ($user->staffcode ?? ''),
                                'emailid' => $user->emailid,
                        ];
                }))
                        ->unique('emailid')
                        ->values()
                        ->toArray();

                // Store Excel file
                $export = new TeammemberExport(collect($excelData));
                $excelFileName = 'Timesheet_Not_Submitted.xlsx';
                Excel::store($export, $excelFileName);

                $emailData = array(
                        'subject' => "Timesheet not filled till date",
                        'teammemberOnlySave' => $teammemberOnlySave->map(function ($user) {
                                return (object) [
                                        'team_member' => $user->team_member,
                                        'emailid' => $user->emailid,
                                ];
                        }),
                );


                Mail::send('emails.timesheetnotfilledremidner', $emailData, function ($msg) use ($emailData, $excelFileName) {
                        // $msg->to('itsupport_delhi@vsa.co.in');
                        $msg->to('Deveshwar@capitall.io');
                        // Attach the Excel file to the email
                        $msg->attach(storage_path('app/' . $excelFileName), [
                                'as' => $excelFileName,
                                'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                        ]);
                        $msg->subject($emailData['subject']);
                });
                // }
                // }
        }
}
