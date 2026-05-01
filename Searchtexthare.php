<?php

namespace App\Http\Controllers;

use App\Rules\ExcelColumnHeading;
use App\Models\Debtor;
use App\Models\Teammember;

class KrasController extends Controller
{

    public function payrollGenerate(Request $request)
    {

        $currentMonth = Carbon::create(null, $request->requestedMonth)->format('F');
        $currentYear = $request->requestedYear;
        //    $previousYear = '2023';
        // Create a Carbon date object for the current month
        $currentMonthDate = Carbon::createFromDate($currentYear, $request->requestedMonth);

        // Subtract one month from the current month date to get prev month date
        $prevMonthDate = $currentMonthDate->copy()->subMonth()->subDays(0);
        //dd($prevMonthDate);
        // Get the month number for the previous month
        //	$prevMonth = '02';
        $prevMonth = $prevMonthDate->format('m');
        //  $prevMonth = '11';
        //dd($prevMonth);
        // Get the month number for the current month
        $currentMonthInDigit = $currentMonthDate->format('m');

        // Get the total number of days in the previous month
        //  $totalDays = $prevMonthDate->subDays(4)->daysInMonth;
        $totalDays = $prevMonthDate->daysInMonth;
        //dd($totalDays);

        $periodEnd   = Carbon::create($request->requestedYear, $request->requestedMonth, 25);

        // ===== Salary Structure =====
        $salaryStructure = DB::table('salary_structures')
            ->where('effective_from', '<=', $periodEnd->toDateString())
            ->orderBy('effective_from', 'desc')
            ->first();


        //for dummy accounts only, for employees there is different code
        $getholidaydates = DB::table('holidays')
            ->whereBetween('startdate', ["$currentYear-$prevMonth-26", "$currentYear-$currentMonthInDigit-25"])
            ->whereBetween('enddate', ["$currentYear-$prevMonth-26", "$currentYear-$currentMonthInDigit-25"])
            ->get();
        //     dd($getholidaydates);
        $holidayCount = 0;
        foreach ($getholidaydates as $holiday) {
            $holidayCount += intval($holiday->number_of_dates);
        }


        $teammembers = Attendance::join('teammembers', 'teammembers.id', 'attendances.employee_name')
            //  ->leftjoin('staffappointmentletters', 'staffappointmentletters.teammember_id', 'attendances.employee_name')
            /*   ->where(function ($query) {
                $query->whereNotNull('staffappointmentletters.otp')
                    ->orWhereIn('teammembers.id', ['558', '418', '645', '549', '318', '660', '647', '685']);   //manual attendance - support staff
            })*/
            ->where(function ($query) {
                $query->whereNotIn('teammembers.role_id', [15, 19, 13])
                    ->orWhereIn('teammembers.id', ['558', '418', '645', '549', '318', '660', '647', '685']);   //manual attendance - support staff
            })
            ->where(function ($query) {
                $query->whereNull('timesheet_applicable')
                    ->orWhere('timesheet_applicable', 'Yes');
            })
            ->where('teammembers.monthly_gross_salary', '!=', 0)
            ->whereNotNull('teammembers.joining_date')
            ->where('teammembers.status', '=', 1)
            ->whereNotIn('teammembers.id', ['336', '169', '256', '341', '161', '170', '310', '641', '640', '649', '637', '447']) //from 310 Secretarial KGS, Bharat, Gaurav Amoli, Ashish Sharma, Sachin Shukla, 
            ->where('attendances.month', $currentMonth)
            ->whereYear('attendances.created_at', $currentYear)
            ->distinct()
            //->pluck('teammembers.id')
            ->get();

        //  dd($teammembers);


        $teammemberfullpay = Teammember::whereIn('timesheet_applicable', ['Yes', 'No'])
            ->where('teammembers.monthly_gross_salary', '!=', 0)
            ->where('teammembers.role_id', 13)
            ->whereNotNull('teammembers.monthly_gross_salary')
            ->whereNotIn('teammembers.id', [17, 22, 550])
            ->get();

        foreach ($teammemberfullpay as $team) {


            $holidayTeam = Attendance::where('employee_name', $team->id)->where('month', $currentMonth)
                ->where('year', $currentYear)->first();
            //dd($holidayTeam->weekend);
            if ($holidayTeam) {
                $weekend = $holidayTeam->weekend;
            } else {
                $weekend = 0;
            }

            if ($team->timesheet_applicable !== null) {
                if ($team->monthly_gross_salary !== null) {
                    $amount = $team->monthly_gross_salary;
                } else {
                    $amount = 0;
                }
            }

            if ($team->pf_applicable == 'Yes') {
                $basic = $amount * ($salaryStructure->basic_percent / 100);

                $hra = $basic * ($salaryStructure->hra_percent / 100);

                $lta = $basic * ($salaryStructure->lta_percent / 100);

                $telephonic = $amount * ($salaryStructure->telephonic_percent / 100);

                $conveyance = $amount * ($salaryStructure->conveyance_percent / 100);

                $medical = $amount * ($salaryStructure->medical_percent / 100);

                $education = $salaryStructure->education_fixed;

                $special = $amount - $basic - $hra - $lta - $telephonic - $conveyance - $medical - $education;
                $totalallowance = $basic + $lta + $telephonic + $conveyance + $medical + $education + $special;

                $basicspecialallowance = $basic + $totalallowance;

                if ($basicspecialallowance < 15000) {
                    $pfAmount = $basicspecialallowance * 0.12;

                    //   dd($pfAmount);
                    $pfAmountEmployer = $pfAmount;
                } else {
                    $pfAmount = 15000 * 0.12;
                    //      dd($pfAmount);
                    $pfAmountEmployer = $pfAmount;
                }
                $totalAmount = $amount - $pfAmount;
                $totalAmountpaid = number_format($totalAmount, 2, '.', '');
                $pfAmount = number_format($pfAmount, 2, '.', '');
                $pfAmountEmployer = number_format($pfAmountEmployer, 2, '.', '');
            } else {
                $totalAmountpaid = number_format($amount, 2, '.', '');
                $pfAmount = 0;
                $pfAmountEmployer = 0;
            }


            $payrollData = [
                'month' => $currentMonth,
                'year' => $currentYear,
                'teammember_id' => $team->id,
                'no_of_day_present' => $totalDays,
                'sl' => 0,
                'cl' => 0,
                'co' => 0,
                'birthday' => 0,
                'totaldays' => $totalDays,
                'day_to_be_paid' => $totalDays,
                'amount' => $amount,
                'employee_contribution' => $pfAmount,
                'employer_contribution' => $pfAmountEmployer,
                'advance' => 0,
                'tds' => 0,
                'Arrear' => 0,
                'bonus' => 0,
                'total_amount_to_paid' => $totalAmountpaid,
                'lwp' => 0,
                'holiday' => $holidayCount,
                'monthly_gross_salary' => $team->monthly_gross_salary,
            ];



            $existedPayroll = Employeepayroll::where([
                'month' => $currentMonth,
                'year' => $currentYear,
                'teammember_id' => $team->id,
            ])->first();

            if ($existedPayroll) {
                if ($existedPayroll->payroleaffect == 1) {
                    continue;
                }

                if ($existedPayroll->level_one == '0') {
                    $existedPayroll->update($payrollData);
                }
            } else {
                Employeepayroll::create($payrollData);
            }
        }
        // dd($teammembers);

        foreach ($teammembers as $team) {
            //dd($team);

            $holidayTeam = Attendance::where('employee_name', $team->id)->where('month', $currentMonth)
                ->where('year', $currentYear)->first();


            $increment = DB::table('incrementletters')
                ->where('teammember_id', $team->employee_name)
                ->where('final_status', 1)
                ->latest()
                ->take(1)
                ->first();

            //dd($currentYear-$prevMonth-26);

            if ($increment != null) {
                $effectiveDate = \Carbon\Carbon::parse($increment->effective_date);
                $effectiveDates = $increment->effective_date;
                if ($effectiveDate->greaterThan("$currentYear-$prevMonth-26") && $effectiveDate->lessThanOrEqualTo("$currentYear-$currentMonthInDigit-25")) {
                    //  dd('hii');
                    // If effective date is on the 26th, use the current month's last date as the last date for calculations
                    if ($effectiveDate->isSameDay("$currentYear-$currentMonthInDigit-26")) {

                        $lastDate = Carbon::create($currentYear, $currentMonthInDigit, Carbon::getLastDayOfMonth($currentMonthInDigit));
                    } else {
                        $lastDate = Carbon::create($currentYear, $currentMonthInDigit, 25);
                    }
                    $effectiveDate = Carbon::parse($increment->effective_date);
                    $lastDate = Carbon::create($currentYear, $currentMonthInDigit, 25);
                    $revisedDays = $lastDate->diffInDays($effectiveDate);
                    $nonRevisedDays = $totalDays - $revisedDays;

                    $salary = $team->monthly_gross_salary;


                    $this->incrementPayrollGenerate(
                        $team,
                        $effectiveDate,
                        $currentYear,
                        $prevMonth,
                        $currentMonthInDigit,
                        $currentMonth,
                        $totalDays,
                        $effectiveDates,
                        $increment,
                        $previousmonth_date,
                        $currentMonth_date
                    );
                } else {
                    $salary =  $team->monthly_gross_salary;

                    $getholidaydates = DB::table('holidays')
                        ->whereBetween('startdate', ["$currentYear-$prevMonth-26", "$currentYear-$currentMonthInDigit-25"])
                        ->whereBetween('enddate', ["$currentYear-$prevMonth-26", "$currentYear-$currentMonthInDigit-25"])
                        ->where('startdate', '>', $team->joining_date)
                        ->get();


                    $holidayCount = 0;

                    foreach ($getholidaydates as $holiday) {
                        $holidayCount += intval($holiday->number_of_dates);
                    }

                    $co = $team->comp_off ?? 0;
                    $cl = $team->casual_leave ?? 0;
                    $sl = $team->sick_leave ?? 0;
                    $birthday = $team->birthday_religious ?? 0;
                    $dayspresent = $team->no_of_days_present ?? 0;
                    $totalCount = 0;
                    $lwpCount = $team->lwp ?? 0; // leave without pay
                    $absentCount = $team->absent ?? 0;


                    if ($dayspresent == 0) {
                        $holidayCount = 0;
                    }

                    $presentDaysWithHoliday = $dayspresent +  $holidayTeam->weekend;
                    $totalCount = $presentDaysWithHoliday + $cl + $sl + $co + $birthday;

                    if ($salary !== null) {
                        $amount = ($salary / $totalDays) * $totalCount;
                    } else {
                        $amount = 0;
                    }

                    if ($team->pf_applicable == 'Yes') {
                        $basic = $amount * ($salaryStructure->basic_percent / 100);

                        $hra = $basic * ($salaryStructure->hra_percent / 100);

                        $lta = $basic * ($salaryStructure->lta_percent / 100);

                        $telephonic = $amount * ($salaryStructure->telephonic_percent / 100);

                        $conveyance = $amount * ($salaryStructure->conveyance_percent / 100);

                        $medical = $amount * ($salaryStructure->medical_percent / 100);

                        $education = $salaryStructure->education_fixed;

                        $special = $amount - $basic - $hra - $lta - $telephonic - $conveyance - $medical - $education;
                        $totalallowance = $basic + $lta + $telephonic + $conveyance + $medical + $education + $special;

                        $basicspecialallowance = $basic + $totalallowance;

                        if ($basicspecialallowance < 15000) {
                            $pfAmount = $basicspecialallowance * 0.12;

                            //   dd($pfAmount);
                            $pfAmountEmployer = $pfAmount;
                        } else {
                            $pfAmount = 15000 * 0.12;
                            //      dd($pfAmount);
                            $pfAmountEmployer = $pfAmount;
                        }

                        $totalAmount = $amount - $pfAmount;
                        $totalAmountpaid = number_format($totalAmount, 2, '.', '');
                        $pfAmount = number_format($pfAmount, 2, '.', '');
                        $pfAmountEmployer = number_format($pfAmountEmployer, 2, '.', '');
                    } else {
                        $totalAmountpaid = number_format($amount, 2, '.', '');
                        $pfAmount = 0;
                        $pfAmountEmployer = 0;
                    }

                    $payrollData = [
                        'month' => $team->month,
                        'year' => $currentYear,
                        'teammember_id' => $team->employee_name,
                        'no_of_day_present' => $presentDaysWithHoliday,
                        'sl' => $sl,
                        'cl' => $cl,
                        'co' => $co,
                        'birthday' => $birthday,
                        'totaldays' => $totalDays,
                        'day_to_be_paid' => $totalCount,
                        'amount' => $amount,
                        'employee_contribution' => $pfAmount,
                        'employer_contribution' => $pfAmountEmployer,
                        'advance' => 0,
                        'tds' => 0,
                        'Arrear' => 0,
                        'bonus' => 0,
                        'total_amount_to_paid' => $totalAmountpaid,
                        'lwp' => $lwpCount,
                        'holiday' => $holidayTeam->weekend,
                        'absent' => $absentCount,
                        'monthly_gross_salary' => $team->monthly_gross_salary,
                    ];



                    if ($dayspresent > 0) {
                        $existedPayroll = Employeepayroll::where([
                            'month' => $currentMonth,
                            'year' => $currentYear,
                            'teammember_id' => $team->employee_name,
                        ])->first();

                        if ($existedPayroll) {
                            if ($existedPayroll->payroleaffect == 1) {
                                continue;
                            }

                            if ($existedPayroll->level_one == '0') {
                                $existedPayroll->update($payrollData);
                            }
                        } else {
                            Employeepayroll::create($payrollData);
                        }
                    }
                }
            } else {
                $salary =  $team->monthly_gross_salary;

                $getholidaydates = DB::table('holidays')
                    ->whereBetween('startdate', ["$currentYear-$prevMonth-26", "$currentYear-$currentMonthInDigit-25"])
                    ->whereBetween('enddate', ["$currentYear-$prevMonth-26", "$currentYear-$currentMonthInDigit-25"])
                    ->where('startdate', '>', $team->joining_date)
                    ->get();

                $holidayCount = 0;

                foreach ($getholidaydates as $holiday) {
                    $holidayCount += intval($holiday->number_of_dates);
                }

                $co = $team->comp_off ?? 0;
                $cl = $team->casual_leave ?? 0;
                $sl = $team->sick_leave ?? 0;
                $birthday = $team->birthday_religious ?? 0;
                $dayspresent = $team->no_of_days_present ?? 0;
                $totalCount = 0;
                $lwpCount = $team->lwp ?? 0; // leave without pay
                $absentCount = $team->absent ?? 0;


                if ($dayspresent == 0) {
                    $holidayCount = 0;
                }
                if ($holidayTeam) {
                    $weekend = $holidayTeam->weekend;
                } else {
                    $weekend = 0;
                }

                $presentDaysWithHoliday = $dayspresent +  $weekend;
                $totalCount = $presentDaysWithHoliday + $cl + $sl + $co + $birthday;

                if ($salary !== null) {
                    $amount = ($salary / $totalDays) * $totalCount;
                } else {
                    $amount = 0;
                }

                if ($team->pf_applicable == 'Yes') {
                    $basic = $amount * ($salaryStructure->basic_percent / 100);

                    $hra = $basic * ($salaryStructure->hra_percent / 100);

                    $lta = $basic * ($salaryStructure->lta_percent / 100);

                    $telephonic = $amount * ($salaryStructure->telephonic_percent / 100);

                    $conveyance = $amount * ($salaryStructure->conveyance_percent / 100);

                    $medical = $amount * ($salaryStructure->medical_percent / 100);

                    $education = $salaryStructure->education_fixed;

                    $special = $amount - $basic - $hra - $lta - $telephonic - $conveyance - $medical - $education;
                    $totalallowance = $basic + $lta + $telephonic + $conveyance + $medical + $education + $special;

                    $basicspecialallowance = $basic + $totalallowance;

                    if ($basicspecialallowance < 15000) {
                        $pfAmount = $basicspecialallowance * 0.12;

                        //   dd($pfAmount);
                        $pfAmountEmployer = $pfAmount;
                    } else {
                        $pfAmount = 15000 * 0.12;
                        //      dd($pfAmount);
                        $pfAmountEmployer = $pfAmount;
                    }

                    $totalAmount = $amount - $pfAmount;
                    $totalAmountpaid = number_format($totalAmount, 2, '.', '');
                    $pfAmount = number_format($pfAmount, 2, '.', '');
                    $pfAmountEmployer = number_format($pfAmountEmployer, 2, '.', '');
                } else {
                    $totalAmountpaid = number_format($amount, 2, '.', '');
                    $pfAmount = 0;
                    $pfAmountEmployer = 0;
                }

                $payrollData = [
                    'month' => $team->month,
                    'year' => $currentYear,
                    'teammember_id' => $team->employee_name,
                    'no_of_day_present' => $presentDaysWithHoliday,
                    'sl' => $sl,
                    'cl' => $cl,
                    'co' => $co,
                    'birthday' => $birthday,
                    'totaldays' => $totalDays,
                    'day_to_be_paid' => $totalCount,
                    'amount' => $amount,
                    'employee_contribution' => $pfAmount,
                    'employer_contribution' => $pfAmountEmployer,
                    'advance' => 0,
                    'tds' => 0,
                    'Arrear' => 0,
                    'bonus' => 0,
                    'total_amount_to_paid' => $totalAmountpaid,
                    'lwp' => $lwpCount,
                    'holiday' => $weekend,
                    'absent' => $absentCount,
                    'monthly_gross_salary' => $team->monthly_gross_salary,
                ];



                if ($dayspresent > 0) {
                    $existedPayroll = Employeepayroll::where([
                        'month' => $currentMonth,
                        'year' => $currentYear,
                        'teammember_id' => $team->employee_name,
                    ])->first();

                    if ($existedPayroll) {
                        if ($existedPayroll->payroleaffect == 1) {
                            continue;
                        }

                        if ($existedPayroll->level_one == '0') {
                            $existedPayroll->update($payrollData);
                        }
                    } else {
                        Employeepayroll::create($payrollData);
                    }
                }
            }
        }

        $currentYear = $request->requestedYear;
        $currentMonth = $request->requestedMonth;
        $date = Carbon::create($currentYear, $currentMonth, 1)->format('Y-m');

        // $date = Carbon::create($currentYear, $currentMonth, 1)->format('Y-m');
        //dd($date);
        $currentDateTime = Carbon::now('America/New_York');
        // Format the current time as a string
        $currentTime = $currentDateTime->format('Y-m-d H:i:s');
        //dd($currentTime);
        $actionName = class_basename($request->route()->getActionname());
        $pagename = substr($actionName, 0, strpos($actionName, "Controller"));
        $id = auth()->user()->teammember_id;
        DB::table('activitylogs')->insert([
            'user_id' => $id,
            'ip_address' => $request->ip(),
            'activitytitle' => $pagename,
            'month_year' => $date,
            //   'year' => $currentYear,
            'generate_date_time' => $currentTime,
            'description' => 'Employee Payroll Generated',
            'created_at' => date('y-m-d'),
            'updated_at' => date('y-m-d')
        ]);


        return redirect()->back()->with('success', 'Payroll data generated successfully.');
    }


    function incrementPayrollGenerate($team, $effectiveDate, $currentYear, $prevMonth, $currentMonthInDigit, $currentMonth, $totalDays, $effectiveDates, $increment,  $previousmonth_date, $currentMonth_date, $salaryStructure)
    {




        //    $previousmonth_date = Carbon::now()->subMonth()->format('Y-m') .'-'.'26';
        //    $currentMonth_date = date('Y').'-'.date('m') .'-'.'25';

        //      dd($previousmonth_date);


        if ($previousmonth_date   < date('Y-m-d', strtotime($increment->effective_date))) {
            $startDate = Carbon::createFromFormat('Y-m-d', $previousmonth_date);
            $endDate = Carbon::createFromFormat('Y-m-d', $increment->effective_date);

            //Calculate the difference in days
            $totaldaysbeforeincrement = $startDate->diffInDays($endDate);
            //dd($totaldaysbeforeincrement);
        } else {
            $totaldaysbeforeincrement = 0;
        }
        if ($currentMonth_date   > date('Y-m-d', strtotime($increment->effective_date))) {
            $endDate = Carbon::createFromFormat('Y-m-d', $currentMonth_date);
            $startDate = Carbon::createFromFormat('Y-m-d', $increment->effective_date);
            $totaldaysafterincrement = $startDate->diffInDays($endDate) + 1;
        } else {
            $totaldaysafterincrement = 0;
        }

        //  dd($totaldaysafterincrement);



        $totalmonthly_gross_salary = $team->salary_before_increment  * $totaldaysbeforeincrement / $totalDays
            + $team->monthly_gross_salary * $totaldaysafterincrement / $totalDays;

        $salary = $totalmonthly_gross_salary;



        $getholidaydates = DB::table('holidays')
            ->whereBetween('startdate', ["$currentYear-$prevMonth-26", "$currentYear-$currentMonthInDigit-25"])
            ->whereBetween('enddate', ["$currentYear-$prevMonth-26", "$currentYear-$currentMonthInDigit-25"])
            ->where('startdate', '>', $team->joining_date)
            ->get();

        $holidayCount = 0;

        foreach ($getholidaydates as $holiday) {
            $holidayCount += intval($holiday->number_of_dates);
        }

        $co = $team->comp_off ?? 0;

        $cl = $team->casual_leave ?? 0;
        $sl = $team->sick_leave ?? 0;
        $birthday = $team->birthday_religious ?? 0;
        $dayspresent = $team->no_of_days_present ?? 0;
        $totalCount = 0;
        $lwpCount = $team->lwp ?? 0; // leave without pay
        $absentCount = $team->absent ?? 0;


        if ($dayspresent == 0) {
            $holidayCount = 0;
        }

        $presentDaysWithHoliday = $dayspresent + $holidayTeam->weekend;
        $totalCount = $presentDaysWithHoliday + $cl + $sl + $co + $birthday;


        if ($salary !== null) {
            $amount = ($salary / $totalDays) * $totalCount;
        } else {
            $amount = 0;
        }


        if ($team->pf_applicable == 'Yes') {
            $basic = $amount * ($salaryStructure->basic_percent / 100);

            $hra = $basic * ($salaryStructure->hra_percent / 100);

            $lta = $basic * ($salaryStructure->lta_percent / 100);

            $telephonic = $amount * ($salaryStructure->telephonic_percent / 100);

            $conveyance = $amount * ($salaryStructure->conveyance_percent / 100);

            $medical = $amount * ($salaryStructure->medical_percent / 100);

            $education = $salaryStructure->education_fixed;

            $special = $amount - $basic - $hra - $lta - $telephonic - $conveyance - $medical - $education;
            $totalallowance = $basic + $lta + $telephonic + $conveyance + $medical + $education + $special;

            $basicspecialallowance = $basic + $totalallowance;

            if ($basicspecialallowance < 15000) {
                $pfAmount = $basicspecialallowance * 0.12;

                //   dd($pfAmount);
                $pfAmountEmployer = $pfAmount;
            } else {
                $pfAmount = 15000 * 0.12;
                //      dd($pfAmount);
                $pfAmountEmployer = $pfAmount;
            }

            $totalAmount = $amount - $pfAmount;
            $totalAmountpaid = number_format($totalAmount, 2, '.', '');
            $pfAmount = number_format($pfAmount, 2, '.', '');
            $pfAmountEmployer = number_format($pfAmountEmployer, 2, '.', '');
        } else {
            $totalAmountpaid = number_format($amount, 2, '.', '');
            $pfAmount = 0;
            $pfAmountEmployer = 0;
        }

        //dd($absentCountAfterIncrement);
        //        $currentDate = Carbon::now();
        //        $lastDayOfPreviousMonth = $currentDate->subMonth()->endOfMonth();
        // if ($lastDayOfPreviousMonth->day == 30 ) {
        //    $absentCountBeforeIncrement = $absentCountBeforeIncrement -1;
        // } else {
        //    $absentCountBeforeIncrement = $absentCountBeforeIncrement;
        // }

        //dd($absentCountBeforeIncrement);
        $payrollData = [
            'month' => $team->month,
            'year' => $currentYear,
            'teammember_id' => $team->employee_name,
            'no_of_day_present' => $presentDaysWithHoliday,
            'sl' => $sl,
            'cl' => $cl,
            'co' => $co,
            'birthday' => $birthday,
            'totaldays' => $totalDays,
            'day_to_be_paid' => $totalCount,
            'amount' => $amount,
            'employee_contribution' => $pfAmount,
            'employer_contribution' => $pfAmountEmployer,
            'advance' => 0,
            'tds' => 0,
            'Arrear' => 0,
            'bonus' => 0,
            'total_amount_to_paid' => $totalAmountpaid,
            'lwp' => $lwpCount,
            'holiday' => $holidayTeam->weekend,
            'absent' => $absentCount,
            'monthly_gross_salary' => $salary,
        ];



        if ($dayspresent > 0) {
            $existedPayroll = Employeepayroll::where([
                'month' => $currentMonth,
                'year' => $currentYear,
                'teammember_id' => $team->employee_name,
            ])->first();

            if ($existedPayroll) {
                if ($existedPayroll->payroleaffect == 1) {
                    return;
                }

                if ($existedPayroll->level_one == '0') {
                    $existedPayroll->update($payrollData);
                }
            } else {
                Employeepayroll::create($payrollData);
            }
        }
    }
}
