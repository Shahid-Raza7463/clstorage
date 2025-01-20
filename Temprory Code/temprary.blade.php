<!DOCTYPE html>
<html lang="en">

{{-- regarding calander --}}



     {{-- 10-01-2025 --}}
     <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Declare endDate outside of the conditions
            var endDate = null;

            //  if (typeof timesheetmaxDateRecord !== 'undefined' && timesheetmaxDateRecord) {
            //      console.log("Latest timesheet data:", timesheetmaxDateRecord);
            //      endDate = new Date(timesheetmaxDateRecord);

            //      if (isNaN(endDate)) {
            //          console.error("Invalid date format for timesheetmaxDateRecord:", timesheetmaxDateRecord);
            //          endDate = null; // Reset endDate to null if invalid
            //      }
            //  }


            //  If timesheet saved data,leave data exist in saved and last timesheet submitted end data exist also
            if (timesheetmaxDateRecord && leavedataforcalander1) {
                if (differenceInDays > 1) {
                    if (typeof timesheetmaxDateRecord !== 'undefined' && timesheetmaxDateRecord) {
                        console.log("Latest timesheet data:", timesheetmaxDateRecord);
                        endDate = new Date(timesheetmaxDateRecord);

                        if (isNaN(endDate)) {
                            console.error("Invalid date format for timesheetmaxDateRecord:",
                                timesheetmaxDateRecord);
                            endDate = null; // Reset endDate to null if invalid
                        }
                    }
                } else {
                    if (typeof leavedataforcalander1 !== 'undefined' && leavedataforcalander1) {
                        console.log("Latest timesheet data:", leavedataforcalander1);
                        endDate = new Date(leavedataforcalander1);

                        if (isNaN(endDate)) {
                            console.error("Invalid date format for leavedataforcalander:", leavedataforcalander1);
                            endDate = null; // Reset endDate to null if invalid
                        }
                    }
                }

                if (!endDate && typeof lasttimesheetsubmiteddata !== 'undefined' && lasttimesheetsubmiteddata) {
                    console.log("Latest submitted data:", lasttimesheetsubmiteddata.enddate);
                    endDate = new Date(lasttimesheetsubmiteddata.enddate);

                    // Check if the incremented date is a Sunday
                    if (endDate.getDay() === 6) {
                        console.log("Incremented date is Sunday, adding another day.");
                        endDate.setDate(endDate.getDate() + 1); // Increment by one more day
                    }

                    if (isNaN(endDate)) {
                        console.error("Invalid date format for lasttimesheetsubmiteddata.enddate:",
                            lasttimesheetsubmiteddata.enddate);
                        endDate = null; // Reset endDate to null if invalid
                    }
                }
            }
            //  If timesheet saved data,leave data not exist in saved and last timesheet submitted  end data only exist
            else if (lasttimesheetsubmiteddata && !timesheetmaxDateRecord && !leavedataforcalander1 && !
                rejoiningdate) {
                if (typeof lasttimesheetsubmiteddata !== 'undefined' && lasttimesheetsubmiteddata) {
                    console.log("Latest submitted data:", lasttimesheetsubmiteddata.enddate);
                    endDate = new Date(lasttimesheetsubmiteddata.enddate);

                    // Check if the incremented date is a Sunday
                    if (endDate.getDay() === 6) {
                        console.log("Incremented date is Sunday, adding another day.");
                        endDate.setDate(endDate.getDate() + 1); // Increment by one more day
                    }

                    if (isNaN(endDate)) {
                        console.error("Invalid date format for lasttimesheetsubmiteddata.enddate:",
                            lasttimesheetsubmiteddata.enddate);
                        endDate = null; // Reset endDate to null if invalid
                    }
                }
            }
            //  If timesheet saved data,leave data not exist in saved and last timesheet submitted  end data only exist
            else if (lasttimesheetsubmiteddata && timesheetmaxDateRecord && !leavedataforcalander1) {
                if (typeof timesheetmaxDateRecord !== 'undefined' && timesheetmaxDateRecord) {
                    console.log("Latest timesheet data:", timesheetmaxDateRecord);
                    endDate = new Date(timesheetmaxDateRecord);

                    if (isNaN(endDate)) {
                        console.error("Invalid date format for timesheetmaxDateRecord:",
                            timesheetmaxDateRecord);
                        endDate = null; // Reset endDate to null if invalid
                    }
                }
            }
            // New joining user
            //  else if (newteammember && !lasttimesheetsubmiteddata && !timesheetmaxDateRecord && !
            //      leavedataforcalander1) {
            else if (newteammember) {
                if (typeof newteammember !== 'undefined' && newteammember) {
                    console.log("Latest timesheet data:", newteammember);

                    if (timesheetmaxDateRecord) {
                        endDate = new Date(timesheetmaxDateRecord);
                    } else {
                        endDate = new Date(newteammember);
                        endDate.setDate(endDate.getDate() - 1);
                    }

                    if (isNaN(endDate)) {
                        console.error("Invalid date format for timesheetmaxDateRecord:",
                            timesheetmaxDateRecord);
                        endDate = null; // Reset endDate to null if invalid
                    }
                }
            }

            //rejoining process
            else if (rejoiningdate) {
                if (typeof rejoiningdate !== 'undefined' && rejoiningdate) {
                    console.log("Latest rejoiningdate data:", rejoiningdate);

                    if (rejoiningdate) {
                        endDate = new Date(rejoiningdate);
                        endDate.setDate(endDate.getDate() - 1);
                    }

                    if (isNaN(endDate)) {
                        console.error("Invalid date format for timesheetmaxDateRecord:",
                            timesheetmaxDateRecord);
                        endDate = null; // Reset endDate to null if invalid
                    }
                }
            }
            //  If timesheet saved data not exist and leave data exist in saved and last timesheet submitted end data exist also
            else {
                if (leavedataforcalander1 && lasttimesheetsubmiteddata) {
                    if (differenceInDays == 2 || differenceInDays == 1) {
                        if (typeof leavedataforcalander1 !== 'undefined' && leavedataforcalander1) {
                            console.log("Latest timesheet data:", leavedataforcalander1);
                            endDate = new Date(leavedataforcalander1);

                            if (isNaN(endDate)) {
                                console.error("Invalid date format for leavedataforcalander:",
                                    leavedataforcalander1);
                                endDate = null; // Reset endDate to null if invalid
                            }
                        }
                    } else {
                        if (typeof lasttimesheetsubmiteddata !== 'undefined' && lasttimesheetsubmiteddata) {
                            console.log("Latest submitted data:", lasttimesheetsubmiteddata.enddate);
                            endDate = new Date(lasttimesheetsubmiteddata.enddate);

                            // Check if the incremented date is a Sunday
                            if (endDate.getDay() === 6) {
                                console.log("Incremented date is Sunday, adding another day.");
                                endDate.setDate(endDate.getDate() + 1); // Increment by one more day
                            }

                            if (isNaN(endDate)) {
                                console.error("Invalid date format for lasttimesheetsubmiteddata.enddate:",
                                    lasttimesheetsubmiteddata.enddate);
                                endDate = null; // Reset endDate to null if invalid
                            }
                        }
                    }
                }

            }

            //  if (leavedataforcalander1 && lasttimesheetsubmiteddata) {
            //      if (differenceInDays == 2 || differenceInDays == 1) {
            //          if (typeof leavedataforcalander1 !== 'undefined' && leavedataforcalander1) {
            //              console.log("Latest timesheet data:", leavedataforcalander1);
            //              endDate = new Date(leavedataforcalander1);

            //              if (isNaN(endDate)) {
            //                  console.error("Invalid date format for leavedataforcalander:", leavedataforcalander1);
            //                  endDate = null; // Reset endDate to null if invalid
            //              }
            //          }
            //      } else {
            //          if (typeof lasttimesheetsubmiteddata !== 'undefined' && lasttimesheetsubmiteddata) {
            //              console.log("Latest submitted data:", lasttimesheetsubmiteddata.enddate);
            //              endDate = new Date(lasttimesheetsubmiteddata.enddate);

            //              // Check if the incremented date is a Sunday
            //              if (endDate.getDay() === 6) {
            //                  console.log("Incremented date is Sunday, adding another day.");
            //                  endDate.setDate(endDate.getDate() + 1); // Increment by one more day
            //              }

            //              if (isNaN(endDate)) {
            //                  console.error("Invalid date format for lasttimesheetsubmiteddata.enddate:",
            //                      lasttimesheetsubmiteddata.enddate);
            //                  endDate = null; // Reset endDate to null if invalid
            //              }
            //          }
            //      }
            //  }



            if (endDate) {

                var today = new Date();
                today.setHours(0, 0, 0, 0); // Normalize today's date to remove time part
                endDate.setHours(0, 0, 0, 0); // Normalize endDate to remove time part

                //  if (endDate.getTime() !== today.getTime()) {
                endDate.setDate(endDate.getDate() + 1); // Increment endDate by one day
                //  }

                // Increment the date by 1
                //  endDate.setDate(endDate.getDate() + 1);

                //  // Check if the incremented date is a Sunday
                //  if (endDate.getDay() === 0) {
                //      console.log("Incremented date is Sunday, adding another day.");
                //      endDate.setDate(endDate.getDate() + 1); // Increment by one more day
                //  }

                var formattedDate = ('0' + endDate.getDate()).slice(-2) + '-' +
                    ('0' + (endDate.getMonth() + 1)).slice(-2) + '-' +
                    endDate.getFullYear();

                // Set the calculated date in the datepicker input field
                document.getElementById('datepickers').value = formattedDate;

                // Initialize the datepicker with the calculated maxDate
                $("#datepickers").datepicker({
                    maxDate: endDate, // Use the parsed and adjusted Date object
                    minDate: endDate, // Set the same date for minDate if needed
                    dateFormat: 'dd-mm-yy'
                });

                console.log("Adjusted date set in datepicker:", endDate);
            } else {
                console.log("No valid timesheet or submitted date data found to set datepicker.");
            }
        });
    </script>


<script>
    // Pass the PHP data to JavaScript
    var lasttimesheetsubmiteddata = @json($lasttimesheetsubmiteddata);
    var timesheetmaxDateRecord = @json($timesheetmaxDateRecord);
    var leavedataforcalander1 = @json($leavedataforcalander1);
    var differenceInDays = @json($differenceInDays);
    var newteammember = @json($newteammember);
    var rejoiningdate = @json($rejoiningdate);
</script>


public function create(Request $request)
{

  $permotioncheck = DB::table('teamrolehistory')
    ->where('teammember_id', auth()->user()->teammember_id)->first();
  $partner = Teammember::where('role_id', '=', 13)->where('status', '=', 1)->with('title')->get();
  $teammember = Teammember::where('role_id', '!=', 11)->with('title', 'role')->get();
  if (auth()->user()->role_id == 11) {
    $client = Client::where('status', 1)->select('id', 'client_name', 'client_code')->orderBy('client_name', 'ASC')->get();
    $timesheetrejectData = DB::table('timesheetusers')
      ->where('createdby', auth()->user()->teammember_id)
      ->where('status', 2)
      ->first();
  } elseif ($permotioncheck && auth()->user()->role_id == 13) {
    $timesheetrejectData = DB::table('timesheetusers')
      ->where('createdby', auth()->user()->teammember_id)
      ->where('status', 2)
      ->first();

    $clientssbefore = DB::table('assignmentteammappings')
      ->leftjoin('assignmentmappings', 'assignmentmappings.id', 'assignmentteammappings.assignmentmapping_id')
      ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
      ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
      ->orwhere('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
      // i have add this line becouse manager contain it but staff not contain it so basically after add this code no contain staff and manager 
      ->whereNotIn('assignmentbudgetings.assignmentname', ['Unallocated', 'Official Travel', 'Off/Holiday', 'Seminar/Conference/Post Qualification Course'])
      ->where('assignmentbudgetings.status', 1)
      ->select('clients.client_name', 'clients.id', 'clients.client_code')
      ->orderBy('client_name', 'ASC')
      ->distinct()->get();

    $clientssafter = DB::table('assignmentmappings')
      ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
      ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
      ->where(function ($query) {
        $query->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
          ->orWhere('assignmentmappings.otherpartner', auth()->user()->teammember_id);
      })
      ->where('assignmentbudgetings.status', 1)
      ->select('clients.client_name', 'clients.id', 'clients.client_code')
      ->orderBy('client_name', 'ASC')
      ->distinct()->get();

    // // done default $clients in ajax if need then $clientss add in ajax target $request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34
    // $clients = DB::table('clients')
    //   ->whereIn('id', [29, 32, 33, 34])
    //   ->select('clients.client_name', 'clients.id', 'clients.client_code')
    //   ->orderBy('client_name', 'ASC')
    //   ->distinct()->get();
    // $client = $clientss->merge($clients);

    $selectedDate1 = new \DateTime();
    $formattedDate = $selectedDate1->format('Y-m-d');
    $holidaydatecheck = DB::table('holidays')->where('startdate', $formattedDate)->select('holidayname')->first();

    if ($holidaydatecheck) {
      $clientIds = [29, 32, 33, 34];
    } else {
      // if not holidays then go hare
      $dayOfWeek = $selectedDate1->format('w');
      if ($selectedDate1->format('l') == 'Saturday') {
        $dayOfMonth = $selectedDate1->format('j');
        // Calculate which Saturday of the month it is
        $saturdayNumber = ceil($dayOfMonth / 7);
        // offholiday client name will be show on 2nd and 4rth sturday
        if ($saturdayNumber == 2.0 || $saturdayNumber == 4.0) {
          $clientIds = [29, 32, 33, 34];
        } else {
          $clientIds = [29, 32, 34];
        }
      } else {
        $clientIds = [29, 32, 34];
      }
    }

    $clients = DB::table('clients')
      ->whereIn('id', $clientIds)
      ->select('clients.client_name', 'clients.id', 'clients.client_code')
      ->orderBy('client_name', 'ASC')
      ->distinct()
      ->get();

    $client = $clientssafter->merge($clientssbefore)->merge($clients);
  } elseif (auth()->user()->role_id == 13) {
    $timesheetrejectData = DB::table('timesheetusers')
      ->where('createdby', auth()->user()->teammember_id)
      ->where('status', 2)
      ->first();

    $clientss = DB::table('assignmentmappings')
      ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
      ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
      ->where(function ($query) {
        $query->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
          ->orWhere('assignmentmappings.otherpartner', auth()->user()->teammember_id);
      })
      ->where('assignmentbudgetings.status', 1)
      ->select('clients.client_name', 'clients.id', 'clients.client_code')
      ->orderBy('client_name', 'ASC')
      ->distinct()->get();

    // // done default $clients in ajax if need then $clientss add in ajax target $request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34
    // $clients = DB::table('clients')
    //   ->whereIn('id', [29, 32, 33, 34])
    //   ->select('clients.client_name', 'clients.id', 'clients.client_code')
    //   ->orderBy('client_name', 'ASC')
    //   ->distinct()->get();
    // $client = $clientss->merge($clients);

    $selectedDate1 = new \DateTime();
    $formattedDate = $selectedDate1->format('Y-m-d');
    $holidaydatecheck = DB::table('holidays')->where('startdate', $formattedDate)->select('holidayname')->first();

    if ($holidaydatecheck) {
      $clientIds = [29, 32, 33, 34];
    } else {
      // if not holidays then go hare
      $dayOfWeek = $selectedDate1->format('w');
      if ($selectedDate1->format('l') == 'Saturday') {
        $dayOfMonth = $selectedDate1->format('j');
        // Calculate which Saturday of the month it is
        $saturdayNumber = ceil($dayOfMonth / 7);
        // offholiday client name will be show on 2nd and 4rth sturday
        if ($saturdayNumber == 2.0 || $saturdayNumber == 4.0) {
          $clientIds = [29, 32, 33, 34];
        } else {
          $clientIds = [29, 32, 34];
        }
      } else {
        $clientIds = [29, 32, 34];
      }
    }


    $clients = DB::table('clients')
      ->whereIn('id', $clientIds)
      ->select('clients.client_name', 'clients.id', 'clients.client_code')
      ->orderBy('client_name', 'ASC')
      ->distinct()
      ->get();

    $client = $clientss->merge($clients);
  } else {
    $timesheetrejectData = DB::table('timesheetusers')
      ->where('createdby', auth()->user()->teammember_id)
      ->where('status', 2)
      ->first();

    $clientss = DB::table('assignmentteammappings')
      ->leftjoin('assignmentmappings', 'assignmentmappings.id', 'assignmentteammappings.assignmentmapping_id')
      ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
      ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
      ->orwhere('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
      // i have add this line becouse manager contain it but staff not contain it so basically after add this code no contain staff and manager 
      ->whereNotIn('assignmentbudgetings.assignmentname', ['Unallocated', 'Official Travel', 'Off/Holiday', 'Seminar/Conference/Post Qualification Course'])
      ->where('assignmentbudgetings.status', 1)
      ->select('clients.client_name', 'clients.id', 'clients.client_code')
      ->orderBy('client_name', 'ASC')
      ->distinct()->get();

    // done default $clients in ajax if need then $clientss add in ajax target $request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34
    // $clients = DB::table('clients')
    //   ->whereIn('id', [29, 32, 33, 34])
    //   ->select('clients.client_name', 'clients.id', 'clients.client_code')
    //   ->orderBy('client_name', 'ASC')
    //   ->distinct()->get();

    // $client = $clientss->merge($clients);

    $selectedDate1 = new \DateTime();
    $formattedDate = $selectedDate1->format('Y-m-d');
    $holidaydatecheck = DB::table('holidays')->where('startdate', $formattedDate)->select('holidayname')->first();

    if ($holidaydatecheck) {
      $clientIds = [29, 32, 33, 34];
    } else {
      // if not holidays then go hare
      $dayOfWeek = $selectedDate1->format('w');
      if ($selectedDate1->format('l') == 'Saturday') {
        $dayOfMonth = $selectedDate1->format('j');
        // Calculate which Saturday of the month it is
        $saturdayNumber = ceil($dayOfMonth / 7);
        // offholiday client name will be show on 2nd and 4rth sturday
        if (auth()->user()->role_id == 14) {
          if ($saturdayNumber == 2.0 || $saturdayNumber == 4.0) {
            $clientIds = [29, 32, 33, 34];
          } else {
            $clientIds = [29, 32, 34];
          }
        } else {
          if ($saturdayNumber == 1.0 || $saturdayNumber == 2.0 || $saturdayNumber == 3.0 || $saturdayNumber == 4.0 || $saturdayNumber == 5.0) {
            $clientIds = [29, 32, 33, 34];
          }
        }
      } else {
        $clientIds = [29, 32, 34];
      }
    }
    $clients = DB::table('clients')
      ->whereIn('id', $clientIds)
      ->select('clients.client_name', 'clients.id', 'clients.client_code')
      ->orderBy('client_name', 'ASC')
      ->distinct()
      ->get();

    $client = $clientss->merge($clients);
  }
  $assignment = Assignment::select('id', 'assignment_name')->get();
  if ($request->ajax()) {
    // dd($request);
    if (isset($request->timesheetdate)) {
      if ($permotioncheck && auth()->user()->role_id == 13) {
        echo "<option>Select Client</option>";

        $selectedDate = \DateTime::createFromFormat('d-m-Y', $request->timesheetdate);
        $selectedDate1 = \DateTime::createFromFormat('d-m-Y', $request->timesheetdate);


        $clientssbefore = DB::table('assignmentteammappings')
          ->leftjoin('assignmentmappings', 'assignmentmappings.id', 'assignmentteammappings.assignmentmapping_id')
          ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
          ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
          ->orwhere('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
          ->whereNotIn('assignmentbudgetings.assignmentname', ['Unallocated', 'Official Travel', 'Off/Holiday', 'Seminar/Conference/Post Qualification Course'])
          ->where(function ($query) use ($selectedDate) {
            $query->whereNull('otpverifydate')
              ->orWhere('otpverifydate', '>=', $selectedDate->modify('-1 day'));
          })
          ->select('clients.client_name', 'clients.id', 'clients.client_code')
          ->orderBy('client_name', 'ASC')
          ->distinct()->get();

        $clientssafter = DB::table('assignmentmappings')
          ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
          ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
          ->where(function ($query) {
            $query->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
              ->orWhere('assignmentmappings.otherpartner', auth()->user()->teammember_id);
          })
          ->where(function ($query) use ($selectedDate) {
            $query->whereNull('otpverifydate')
              ->orWhere('otpverifydate', '>=', $selectedDate->modify('-1 day'));
          })
          // ->whereNotNull('clients.client_name')
          ->select('clients.client_name', 'clients.id', 'clients.client_code')
          ->orderBy('client_name', 'ASC')
          ->distinct()->get();

        // // done default $clients in ajax if need then $clientss add in ajax target $request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34
        // $clients = DB::table('clients')
        //   ->whereIn('id', [29, 32, 33, 34])
        //   ->select('clients.client_name', 'clients.id', 'clients.client_code')
        //   ->orderBy('client_name', 'ASC')
        //   ->distinct()->get();

        // if you selected sturday date then offholydays client will be show otherwise not

        $formattedDate = $selectedDate1->format('Y-m-d');
        $holidaydatecheck = DB::table('holidays')->where('startdate', $formattedDate)->select('holidayname')->first();

        if ($holidaydatecheck) {
          $clientIds = [29, 32, 33, 34];
        } else {
          // if not holidays then go hare
          $dayOfWeek = $selectedDate1->format('w');
          if ($selectedDate1->format('l') == 'Saturday') {
            $dayOfMonth = $selectedDate1->format('j');
            // Calculate which Saturday of the month it is
            $saturdayNumber = ceil($dayOfMonth / 7);
            // offholiday client name will be show on 2nd and 4rth sturday
            if ($saturdayNumber == 2.0 || $saturdayNumber == 4.0) {
              $clientIds = [29, 32, 33, 34];
            } else {
              $clientIds = [29, 32, 34];
            }
          } else {
            $clientIds = [29, 32, 34];
          }
        }
        $clients = DB::table('clients')
          ->whereIn('id', $clientIds)
          ->select('clients.client_name', 'clients.id', 'clients.client_code')
          ->orderBy('client_name', 'ASC')
          ->distinct()
          ->get();

        // $client = $clientss->merge($clients);
        $client = $clientssafter->merge($clientssbefore)->merge($clients);
        foreach ($client as $clients) {
          echo "<option value='" . $clients->id . "'>" . $clients->client_name . '( ' . $clients->client_code . ' )' . "</option>";
        }
      } elseif (auth()->user()->role_id == 13) {
        echo "<option>Select Client</option>";

        $selectedDate = \DateTime::createFromFormat('d-m-Y', $request->timesheetdate);
        $selectedDate1 = \DateTime::createFromFormat('d-m-Y', $request->timesheetdate);

        $clientss = DB::table('assignmentmappings')
          ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
          ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
          ->where(function ($query) {
            $query->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
              ->orWhere('assignmentmappings.otherpartner', auth()->user()->teammember_id);
          })
          ->where(function ($query) use ($selectedDate) {
            $query->whereNull('otpverifydate')
              ->orWhere('otpverifydate', '>=', $selectedDate->modify('-1 day'));
          })
          // ->whereNotNull('clients.client_name')
          ->select('clients.client_name', 'clients.id', 'clients.client_code')
          ->orderBy('client_name', 'ASC')
          ->distinct()->get();

        // // done default $clients in ajax if need then $clientss add in ajax target $request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34
        // $clients = DB::table('clients')
        //   ->whereIn('id', [29, 32, 33, 34])
        //   ->select('clients.client_name', 'clients.id', 'clients.client_code')
        //   ->orderBy('client_name', 'ASC')
        //   ->distinct()->get();

        // if you selected sturday date then offholydays client will be show otherwise not

        $formattedDate = $selectedDate1->format('Y-m-d');
        $holidaydatecheck = DB::table('holidays')->where('startdate', $formattedDate)->select('holidayname')->first();

        if ($holidaydatecheck) {
          $clientIds = [29, 32, 33, 34];
        } else {
          // if not holidays then go hare
          $dayOfWeek = $selectedDate1->format('w');
          if ($selectedDate1->format('l') == 'Saturday') {
            $dayOfMonth = $selectedDate1->format('j');
            // Calculate which Saturday of the month it is
            $saturdayNumber = ceil($dayOfMonth / 7);
            // offholiday client name will be show on 2nd and 4rth sturday
            if ($saturdayNumber == 2.0 || $saturdayNumber == 4.0) {
              $clientIds = [29, 32, 33, 34];
            } else {
              $clientIds = [29, 32, 34];
            }
          } else {
            $clientIds = [29, 32, 34];
          }
        }
        $clients = DB::table('clients')
          ->whereIn('id', $clientIds)
          ->select('clients.client_name', 'clients.id', 'clients.client_code')
          ->orderBy('client_name', 'ASC')
          ->distinct()
          ->get();

        $client = $clientss->merge($clients);

        // foreach ($client as $clients) {
        //   if ($clients->client_name !== 'Official Travel') {
        //     echo "<option value='" . $clients->id . "'>" . $clients->client_name . ' ( ' . $clients->client_code . ' )' . "</option>";
        //   }
        // }

        foreach ($client as $clients) {
          echo "<option value='" . $clients->id . "'>" . $clients->client_name . '( ' . $clients->client_code . ' )' . "</option>";
        }
      } else {

        echo "<option>Select Client</option>";

        $selectedDate = \DateTime::createFromFormat('d-m-Y', $request->timesheetdate);
        $selectedDate1 = \DateTime::createFromFormat('d-m-Y', $request->timesheetdate);
        $clientss = DB::table('assignmentteammappings')
          ->leftjoin('assignmentmappings', 'assignmentmappings.id', 'assignmentteammappings.assignmentmapping_id')
          ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
          ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
          ->orwhere('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
          ->whereNotIn('assignmentbudgetings.assignmentname', ['Unallocated', 'Official Travel', 'Off/Holiday', 'Seminar/Conference/Post Qualification Course'])
          ->where(function ($query) use ($selectedDate) {
            $query->whereNull('otpverifydate')
              ->orWhere('otpverifydate', '>=', $selectedDate->modify('-1 day'));
          })
          ->select('clients.client_name', 'clients.id', 'clients.client_code')
          ->orderBy('client_name', 'ASC')
          ->distinct()->get();
        // ->get();

        // done default $clients in ajax if need then $clientss add in ajax target $request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34
        // $clients = DB::table('clients')
        //   ->whereIn('id', [29, 32, 33, 34])
        //   ->select('clients.client_name', 'clients.id', 'clients.client_code')
        //   ->orderBy('client_name', 'ASC')
        //   ->distinct()->get();

        // $client = $clientss->merge($clients);



        $formattedDate = $selectedDate1->format('Y-m-d');
        $holidaydatecheck = DB::table('holidays')->where('startdate', $formattedDate)->select('holidayname')->first();

        if ($holidaydatecheck) {
          $clientIds = [29, 32, 33, 34];
        } else {
          // if not holidays then go hare
          $dayOfWeek = $selectedDate1->format('w');
          if ($selectedDate1->format('l') == 'Saturday') {
            $dayOfMonth = $selectedDate1->format('j');
            // Calculate which Saturday of the month it is
            $saturdayNumber = ceil($dayOfMonth / 7);
            // offholiday client name will be show on 2nd and 4rth sturday
            if (auth()->user()->role_id == 14) {
              if ($saturdayNumber == 2.0 || $saturdayNumber == 4.0) {
                $clientIds = [29, 32, 33, 34];
              } else {
                $clientIds = [29, 32, 34];
              }
            } else {
              if ($saturdayNumber == 1.0 || $saturdayNumber == 2.0 || $saturdayNumber == 3.0 || $saturdayNumber == 4.0 || $saturdayNumber == 5.0) {
                $clientIds = [29, 32, 33, 34];
              }
            }
          } else {
            $clientIds = [29, 32, 34];
          }
        }
        $clients = DB::table('clients')
          ->whereIn('id', $clientIds)
          ->select('clients.client_name', 'clients.id', 'clients.client_code')
          ->orderBy('client_name', 'ASC')
          ->distinct()
          ->get();

        $client = $clientss->merge($clients);

        foreach ($client as $clients) {
          echo "<option value='" . $clients->id . "'>" . $clients->client_name . '( ' . $clients->client_code . ' )' . "</option>";
        }
      }
    }

    if (isset($request->cid)) {
      if ($permotioncheck && auth()->user()->role_id == 13) {
        echo "<option>Select Assignment</option>";

        if ($request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34) {
          $clients = DB::table('clients')
            ->where('id', $request->cid)
            ->select('clients.client_name', 'clients.id', 'clients.client_code')
            ->orderBy('client_name', 'ASC')
            ->distinct()->get();

          $id = $clients[0]->id;
          $assignments = DB::table('assignmentbudgetings')->where('client_id', $id)
            ->leftJoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
            ->select('assignmentbudgetings.assignmentgenerate_id', 'assignments.assignment_name', 'assignments.assignmentname')
            ->orderBy('assignment_name');
        } else {
          $selectedDate = \DateTime::createFromFormat('d-m-Y', $request->datepickers);

          $assignments = DB::table('assignmentbudgetings')
            ->where('assignmentbudgetings.client_id', $request->cid)
            ->leftJoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
            ->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
            ->where(function ($query) {
              $query->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
                ->orWhere('assignmentmappings.otherpartner', auth()->user()->teammember_id);
            })
            ->where(function ($query) use ($selectedDate) {
              $query->whereNull('otpverifydate')
                ->orWhere('otpverifydate', '>=', $selectedDate->modify('-1 day'));
            })
            ->select('assignmentbudgetings.assignmentgenerate_id', 'assignments.assignment_name', 'assignmentbudgetings.assignmentname');

          $additionalAssignments = DB::table('assignmentbudgetings')
            ->join('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
            ->leftJoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
            ->leftJoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
            ->where('assignmentbudgetings.client_id', $request->cid)
            ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
            ->where(function ($query) {
              $query->whereNull('assignmentteammappings.status')
                ->orWhere('assignmentteammappings.status', '=', 1);
            })
            ->where(function ($query) use ($selectedDate) {
              $query->whereNull('otpverifydate')
                ->orWhere('otpverifydate', '>=', $selectedDate->modify('-1 day'));
            })
            ->select('assignmentbudgetings.assignmentgenerate_id', 'assignments.assignment_name', 'assignmentbudgetings.assignmentname');

          $assignments = $assignments->union($additionalAssignments)->orderBy('assignment_name')->get();
          // dd($assignments);
        }

        foreach ($assignments as $sub) {
          echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentname . '/' . $sub->assignmentgenerate_id . ' )' . "</option>";
        }
      }

      // 22222222
      elseif (auth()->user()->role_id == 13) {

        echo "<option>Select Assignment</option>";
        if ($request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34) {
          $clients = DB::table('clients')
            // ->whereIn('id', [29, 32, 33, 34])
            ->where('id', $request->cid)
            ->select('clients.client_name', 'clients.id', 'clients.client_code')
            ->orderBy('client_name', 'ASC')
            ->distinct()->get();
          // dd($clients);
          $id = $clients[0]->id;
          foreach (
            DB::table('assignmentbudgetings')->where('client_id', $id)
              ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
              ->orderBy('assignment_name')->get() as $sub
          ) {
            echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentname . '/' . $sub->assignmentgenerate_id . ' )' . "</option>";
          }
        } else {
          // dd('hi 3');

          $selectedDate = \DateTime::createFromFormat('d-m-Y', $request->datepickers);

          foreach (
            DB::table('assignmentbudgetings')
              ->where('assignmentbudgetings.client_id', $request->cid)
              ->leftJoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
              ->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
              ->where(function ($query) {
                $query->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
                  ->orWhere('assignmentmappings.otherpartner', auth()->user()->teammember_id);
              })
              ->where(function ($query) use ($selectedDate) {
                $query->whereNull('otpverifydate')
                  ->orWhere('otpverifydate', '>=', $selectedDate->modify('-1 day'));
              })
              ->orderBy('assignment_name')->get() as $sub
          ) {
            echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentname . '/' . $sub->assignmentgenerate_id . ' )' . "</option>";
          }
        }
      } else {

        echo "<option>Select Assignment</option>";

        if ($request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34) {
          $clients = DB::table('clients')
            // ->whereIn('id', [29, 32, 33, 34])
            ->where('id', $request->cid)
            ->select('clients.client_name', 'clients.id', 'clients.client_code')
            ->orderBy('client_name', 'ASC')
            ->distinct()->get();
          // dd($clients);
          $id = $clients[0]->id;
          foreach (
            DB::table('assignmentbudgetings')->where('client_id', $id)
              ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
              ->orderBy('assignment_name')->get() as $sub
          ) {
            echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentname . '/' . $sub->assignmentgenerate_id . ' )' . "</option>";
          }
        } else {
          //  i have add this code after kartic bindal problem 
          $selectedDate = \DateTime::createFromFormat('d-m-Y', $request->datepickers);

          foreach (
            DB::table('assignmentbudgetings')
              ->join('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
              ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
              ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
              ->where('assignmentbudgetings.client_id', $request->cid)
              ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
              //  ->where('assignmentteammappings.status', '!=', 0)
              // ->whereNull('assignmentteammappings.status')
              ->where(function ($query) {
                $query->whereNull('assignmentteammappings.status')
                  ->orWhere('assignmentteammappings.status', '=', 1);
              })
              ->where(function ($query) use ($selectedDate) {
                $query->whereNull('otpverifydate')
                  //   ->orWhere('otpverifydate', '>=', $selectedDate);
                  // // ->orWhere('otpverifydate', '>=', $selectedDate);
                  ->orWhere('otpverifydate', '>=', $selectedDate->modify('-1 day'));
              })
              ->orderBy('assignment_name')->get() as $sub
          ) {
            echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentname . '/' . $sub->assignmentgenerate_id . ' )' . "</option>";
          }
        }
      }
    }

    if (isset($request->assignment)) {
      // dd($request->assignment);
      if (auth()->user()->role_id == 11) {
        echo "<option value=''>Select Partner</option>";
        foreach (
          DB::table('assignmentmappings')

            ->leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
            ->leftjoin('teammembers as team', 'team.id', 'assignmentmappings.otherpartner')
            ->where('assignmentmappings.assignmentgenerate_id', $request->assignment)
            ->select('team.team_member as team_member', 'team.id', 'teammembers.id', 'teammembers.team_member')
            ->get() as $subs
        ) {
          echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
        }
      } elseif ($permotioncheck && auth()->user()->role_id == 13) {
        echo "<option value=''>Select Partner</option>";
        // dd($request->assignment);
        $partnerbefore = DB::table('assignmentmappings')
          ->leftJoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
          ->leftJoin('teammembers as team', 'team.id', 'assignmentmappings.otherpartner')
          ->where('assignmentmappings.assignmentgenerate_id', $request->assignment)
          ->select('teammembers.id', 'teammembers.team_member');

        // $partnerafter = DB::table('assignmentmappings')
        //   ->leftJoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
        //   ->where('assignmentmappings.assignmentgenerate_id', $request->assignment)
        //   ->select('teammembers.id', 'teammembers.team_member');

        $partnerafter = DB::table('assignmentmappings')
          ->leftJoin('teammembers as leadpartner', 'leadpartner.id', '=', 'assignmentmappings.leadpartner')
          ->leftJoin('teammembers as otherpartner', 'otherpartner.id', '=', 'assignmentmappings.otherpartner')
          ->where('assignmentmappings.assignmentgenerate_id', $request->assignment)
          ->where(function ($query) {
            $query->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
              ->orWhere('assignmentmappings.otherpartner', auth()->user()->teammember_id);
          })
          ->select(DB::raw("
        CASE
            WHEN assignmentmappings.leadpartner = " . auth()->user()->teammember_id . " THEN leadpartner.id
            WHEN assignmentmappings.otherpartner = " . auth()->user()->teammember_id . " THEN otherpartner.id
        END as id,
        CASE
            WHEN assignmentmappings.leadpartner = " . auth()->user()->teammember_id . " THEN leadpartner.team_member
            WHEN assignmentmappings.otherpartner = " . auth()->user()->teammember_id . " THEN otherpartner.team_member
        END as team_member
    "));

        $partnerresult = $partnerafter->union($partnerbefore)->get();
        foreach ($partnerresult as $subs) {
          echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
        }
      } elseif (auth()->user()->role_id == 13) {
        echo "<option value=''>Select Partner</option>";
        foreach (
          DB::table('teammembers')
            ->where('id', auth()->user()->teammember_id)
            ->select('teammembers.id', 'teammembers.team_member')
            ->get() as $subs
        ) {
          echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
        }
      } else {

        echo "<option value=''>Select Partner</option>";
        foreach (
          DB::table('assignmentmappings')

            ->leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
            ->leftjoin('teammembers as team', 'team.id', 'assignmentmappings.otherpartner')
            ->where('assignmentmappings.assignmentgenerate_id', $request->assignment)
            ->select('team.team_member as team_member', 'team.id', 'teammembers.id', 'teammembers.team_member')
            ->get() as $subs
        ) {
          echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
        }
      }
    }
  } else {

    $lasttimesheetsubmiteddata = DB::table('timesheetreport')
      ->where('teamid', auth()->user()->teammember_id)
      ->latest()
      ->first();


    // $timesheetmaxDateRecord = DB::table('timesheetusers')
    //   ->where('status', '0')
    //   ->where('createdby', auth()->user()->teammember_id)
    //   ->orderBy('date', 'desc')
    //   ->first();

    $timesheetmaxDateRecord = DB::table('timesheetusers')
      ->where('status', '0')
      ->where('createdby', auth()->user()->teammember_id)
      ->whereNotIn('client_id', ['134'])
      ->orderBy('date', 'desc')
      ->first();



    $leavedataforcalander = DB::table('timesheetusers')
      ->where('status', '0')
      ->where('createdby', auth()->user()->teammember_id)
      ->whereIn('client_id', ['134'])
      ->orderBy('date', 'asc')
      ->first();



    $leavedataforcalander1 = DB::table('timesheetusers')
      ->where('status', '0')
      ->where('createdby', auth()->user()->teammember_id)
      ->whereIn('client_id', ['134'])
      ->orderBy('date', 'desc')
      ->first();


    // dd($leavedataforcalander);


    // if ($timesheetmaxDateRecord && $leavedataforcalander) {
    //   // Parse dates using Carbon
    //   $date1 = Carbon::parse($timesheetmaxDateRecord->date);
    //   $date2 = Carbon::parse($leavedataforcalander->date);

    //   // Calculate the difference in days
    //   $differenceInDays = $date1->diffInDays($date2);

    //   // dd($differenceInDays); // This will show the difference in days
    // } else {
    //   // Parse dates using Carbon
    //   $date1 = Carbon::parse($lasttimesheetsubmiteddata->enddate);
    //   $date2 = Carbon::parse($leavedataforcalander->date);

    //   // Calculate the difference in days
    //   $differenceInDays = $date1->diffInDays($date2);

    //   // dd($differenceInDays); // This will show the difference in days
    // }

    // Rejoining proceesss

    if ($lasttimesheetsubmiteddata && !$timesheetmaxDateRecord) {
      $rejoiningDataall = DB::table('teammembers')
        ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
        ->leftJoin('rejoiningsamepost', 'rejoiningsamepost.teammember_id', '=', 'teammembers.id')
        ->where('teammembers.id', auth()->user()->teammember_id)
        ->select(
          'teamrolehistory.rejoiningdate',
          'rejoiningsamepost.rejoiningdate as samepostrejoiningdate'
        )
        ->first();

      if ($rejoiningDataall) {
        $rejoiningDatestore = $rejoiningDataall->samepostrejoiningdate ?? $rejoiningDataall->rejoiningdate;

        if ($rejoiningDatestore) {
          $rejoiningDateCarbon = Carbon::parse($rejoiningDatestore);

          if ($lasttimesheetsubmiteddata) {
            $lastSubmissionCarbon = Carbon::parse($lasttimesheetsubmiteddata->enddate);

            if ($rejoiningDateCarbon->greaterThan($lastSubmissionCarbon)) {
              $rejoiningdate = $rejoiningDatestore;
            } else {
              $rejoiningdate = null;
            }
          } else {
            $rejoiningdate = null;
          }
        } else {
          $rejoiningdate = null;
        }
      } else {
        $rejoiningdate = null;
      }
    }

    // dd('hi');
    //  If timesheet saved data,leave data exist in saved and last timesheet submitted end data exist also
    if ($timesheetmaxDateRecord && $leavedataforcalander) {
      // Parse dates using Carbon
      $date1 = Carbon::parse($timesheetmaxDateRecord->date);
      $date2 = Carbon::parse($leavedataforcalander->date);

      // Calculate the difference in days
      $differenceInDays = $date1->diffInDays($date2);

      // dd($differenceInDays); // This will show the difference in days
    }
    //  If timesheet saved data,leave data not exist in saved and last timesheet submitted  end data only exist
    elseif ($lasttimesheetsubmiteddata && !$timesheetmaxDateRecord && !$leavedataforcalander && !$rejoiningdate) {
      // dd('hi 3');
      $lasttimesheetsubmiteddata = DB::table('timesheetreport')
        ->where('teamid', auth()->user()->teammember_id)
        ->latest()
        ->first();

      $differenceInDays = 1;
    }
    //  If timesheet saved data exist and leave data not exist in saved and last timesheet submitted  end data exist
    elseif ($lasttimesheetsubmiteddata && $timesheetmaxDateRecord && !$leavedataforcalander) {

      // Parse dates using Carbon
      $date1 = Carbon::parse($timesheetmaxDateRecord->date);
      // Calculate the difference in days
      $differenceInDays = 0;
    }
    //  new joining 
    // elseif (!$lasttimesheetsubmiteddata && !$timesheetmaxDateRecord && !$leavedataforcalander) {
    elseif (!$lasttimesheetsubmiteddata) {

      $newteammember = DB::table('teammembers')
        ->where('id', auth()->user()->teammember_id)
        ->first();
      // // Parse dates using Carbon
      // $date1 = Carbon::parse($timesheetmaxDateRecord->date);
      // // Calculate the difference in days
      $differenceInDays = 0;

      // dd($timesheetmaxDateRecord, 111);
    }
    // rejoining process
    elseif ($rejoiningdate) {
      // dd('hi 2');

      $rejoiningdate = $rejoiningDatestore;
      $differenceInDays = 0;

      // dd($timesheetmaxDateRecord, 111);
    }
    //  If timesheet saved data not exist and leave data exist in saved and last timesheet submitted end data exist also
    else {
      // Parse dates using Carbon
      $date1 = Carbon::parse($lasttimesheetsubmiteddata->enddate);
      $date2 = Carbon::parse($leavedataforcalander->date);

      // Calculate the difference in days
      $differenceInDays = $date1->diffInDays($date2);

      // dd($differenceInDays); // This will show the difference in days
    }

    // dd('hi 1');

    if ($timesheetmaxDateRecord) {
      $timesheetmaxDateRecord = $timesheetmaxDateRecord->date;
    } else {
      $timesheetmaxDateRecord = null; // Handle the case where no record is found
    }

    if ($leavedataforcalander1) {
      $leavedataforcalander1 = $leavedataforcalander1->date;
    } else {
      $leavedataforcalander1 = null; // Handle the case where no record is found
    }

    // if ($newteammember) {
    if (isset($newteammember)) {
      $newteammember = $newteammember->joining_date;
    } else {
      $newteammember = null; // Handle the case where no record is found
    }

    // if ($newteammember) {
    if (isset($rejoiningdate)) {
      $rejoiningdate = $rejoiningdate;
    } else {
      $rejoiningdate = null; // Handle the case where no record is found
    }


    return view('backEnd.timesheet.create', compact('client', 'teammember', 'assignment', 'partner', 'timesheetrejectData', 'lasttimesheetsubmiteddata', 'timesheetmaxDateRecord', 'leavedataforcalander1', 'differenceInDays', 'newteammember', 'rejoiningdate'));
    // return view('backEnd.timesheet.create', compact('client', 'teammember', 'assignment', 'partner', 'timesheetrejectData', 'lasttimesheetsubmiteddata', 'timesheetmaxDateRecord'));
  }
}
{{-- regarding calander end--}}

<table id="examplee" class="display nowrap">
    <thead>
        <tr>
            <th style="display: none;">id</th>
            <th>Employee Name</th>
            <th>Staff Code</th>
            <th>Role</th>
            <th>Joinig Date</th>
            <th>Month</th>
            <th>Year</th>
            <th><span class="d-none">0</span>01</th>
            <th><span class="d-none">0</span>02</th>
            <th><span class="d-none">0</span>03</th>
            <th><span class="d-none">0</span>04</th>
            <th><span class="d-none">0</span>05</th>
            <th><span class="d-none">0</span>06</th>
            <th><span class="d-none">0</span>07</th>
            <th><span class="d-none">0</span>08</th>
            <th><span class="d-none">0</span>09</th>
            <th><span class="d-none">0</span>10</th>
            <th><span class="d-none">0</span>11</th>
            <th><span class="d-none">0</span>12</th>
            <th><span class="d-none">0</span>13</th>
            <th><span class="d-none">0</span>14</th>
            <th><span class="d-none">0</span>15</th>
            <th><span class="d-none">0</span>16</th>
            <th><span class="d-none">0</span>17</th>
            <th><span class="d-none">0</span>18</th>
            <th><span class="d-none">0</span>19</th>
            <th><span class="d-none">0</span>20</th>
            <th><span class="d-none">0</span>21</th>
            <th><span class="d-none">0</span>22</th>
            <th><span class="d-none">0</span>23</th>
            <th><span class="d-none">0</span>24</th>
            <th><span class="d-none">0</span>25</th>
            <th><span class="d-none">0</span>26</th>
            <th><span class="d-none">0</span>27</th>
            <th><span class="d-none">0</span>28</th>
            <th><span class="d-none">0</span>29</th>
            <th><span class="d-none">0</span>30</th>
            <th><span class="d-none">0</span>31</th>
            <th>Total Number of days</th>
            <th>Total Working days</th>
            <th>Total Casual Leave</th>
            <th>Total Exam Leave</th>
            <th>Total Travel</th>
            <th>Total Offholidays</th>
            <th>Total Weekend</th>
            <th>Total Holidays</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($attendanceDatas as $attendanceData)
            <tr>
                @php
                    $permotioncheck = DB::table('teamrolehistory')
                        ->where('teammember_id', $attendanceData->employee_name)
                        ->first();

                    $datadate = $attendanceData->fulldate
                        ? Carbon\Carbon::createFromFormat('Y-m-d', $attendanceData->fulldate)
                        : null;

                    $permotiondate = null;
                    if ($permotioncheck) {
                        $permotiondate = Carbon\Carbon::createFromFormat(
                            'Y-m-d H:i:s',
                            $permotioncheck->created_at,
                        );
                    }

                @endphp
                <td style="display: none;">{{ $attendanceData->id }}</td>
                <td>{{ $attendanceData->team_member }}</td>
                {{-- <td class="text-center">
                    {{ $attendanceData->newstaff_code ?? ($attendanceData->staffcode ?? '') }}</td> --}}
                {{-- <td class="text-center">{{ $attendanceData->final_staff_code }}</td> --}}
                @if ($permotiondate && $datadate && $datadate->greaterThan($permotiondate))
                    <td>{{ $permotioncheck->newstaff_code }}</td>
                @else
                    <td>{{ $attendanceData->staffcode }}</td>
                @endif
                <td>{{ $attendanceData->rolename }}</td>
                {{-- <td> {{ $attendanceData->joining_date ? date('d-m-Y', strtotime($attendanceData->joining_date)) : 'NA' }}
                </td> --}}
                <td> {{ $attendanceData->final_rejoining_date ? date('d-m-Y', strtotime($attendanceData->final_rejoining_date)) : date('d-m-Y', strtotime($attendanceData->joining_date)) }}
                </td>
                <td> {{ $attendanceData->month }}</td>
                <td> {{ $attendanceData->year }}</td>
                <td> {{ $attendanceData->one ?? '…....' }}</td>
                <td> {{ $attendanceData->two ?? '…....' }}</td>
                <td> {{ $attendanceData->three ?? '…....' }}</td>
                <td> {{ $attendanceData->four ?? '…....' }}</td>
                <td> {{ $attendanceData->five ?? '…....' }}</td>
                <td> {{ $attendanceData->six ?? '…....' }}</td>
                <td> {{ $attendanceData->seven ?? '…....' }}</td>
                <td> {{ $attendanceData->eight ?? '…....' }}</td>
                <td> {{ $attendanceData->nine ?? '…....' }}</td>
                <td> {{ $attendanceData->ten ?? '…....' }}</td>
                <td> {{ $attendanceData->eleven ?? '…....' }}</td>
                <td> {{ $attendanceData->twelve ?? '…....' }}</td>
                <td> {{ $attendanceData->thirteen ?? '…....' }}</td>
                <td> {{ $attendanceData->fourteen ?? '…....' }}</td>
                <td> {{ $attendanceData->fifteen ?? '…....' }}</td>
                <td> {{ $attendanceData->sixteen ?? '…....' }}</td>
                <td> {{ $attendanceData->seventeen ?? '…....' }}</td>
                <td> {{ $attendanceData->eighteen ?? '…....' }}</td>
                <td> {{ $attendanceData->ninghteen ?? '…....' }}</td>
                <td> {{ $attendanceData->twenty ?? '…....' }}</td>
                <td> {{ $attendanceData->twentyone ?? '…....' }}</td>
                <td> {{ $attendanceData->twentytwo ?? '…....' }}</td>
                <td> {{ $attendanceData->twentythree ?? '…....' }}</td>
                <td> {{ $attendanceData->twentyfour ?? '…....' }}</td>
                <td> {{ $attendanceData->twentyfive ?? '…....' }}</td>
                <td> {{ $attendanceData->twentysix ?? '…....' }}</td>
                <td> {{ $attendanceData->twentyseven ?? '…....' }}</td>
                <td> {{ $attendanceData->twentyeight ?? '…....' }}</td>
                <td> {{ $attendanceData->twentynine ?? '…....' }}</td>
                <td> {{ $attendanceData->thirty ?? '…....' }}</td>
                <td> {{ $attendanceData->thirtyone ?? '…....' }}</td>

                <td class="text-center"> {{ $attendanceData->total_no_of_days ?? '0' }}</td>
                <td class="text-center"> {{ $attendanceData->no_of_days_present ?? '0' }}</td>
                <td class="text-center"> {{ $attendanceData->casual_leave ?? '0' }}</td>
                <td class="text-center"> {{ $attendanceData->exam_leave ?? '0' }}</td>
                <td class="text-center"> {{ $attendanceData->travel ?? '0' }}</td>
                <td class="text-center"> {{ $attendanceData->offholidays ?? '0' }}</td>
                <td class="text-center"> {{ $attendanceData->sundaycount ?? '0' }}</td>
                <td class="text-center"> {{ $attendanceData->holidays ?? '0' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>



<script>
    $(document).ready(function() {
        $('#examplee').DataTable({
            "pageLength": 100,
            dom: 'Bfrtip',
            "order": [
                // [0, "desc"]
            ],
            columnDefs: [{
                targets: [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20,
                    21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38,
                    39, 40, 41, 42, 43
                ],
                orderable: false
            }],
            buttons: [{
                    extend: 'excelHtml5',
                    filename: 'Team Attendance',
                    exportOptions: {
                        columns: ':visible',
                        format: {
                            body: function(data, row, column) {
                                // Remove hidden leading zeros from the export
                                return data.replace(/^0+/, '');
                            }
                        }
                    }
                },
                'colvis'
            ]
        });
    });
</script>



<table id="examplee" class="display nowrap">
    <thead>
        <tr>
            <div class="refresh-btn-container"
                style="position: relative; left: 305px; top: 34px; z-index: 1;">
                <a href="{{ url('/applyleave') }}" class="btn btn-success">Refresh</a>
            </div>
        </tr>
        <tr>
            <th style="display: none;">id</th>
            <th>Employee</th>
            <th class="textfixed">Staff Code</th>
            <th class="textfixed">Date of Request</th>
            <th>Status</th>
            <th class="textfixed">Leave Type</th>
            <th>Leave Period</th>
            <th>Days</th>
            <th>Approver</th>
            <th class="textfixed">Approver Code</th>
            <th>Reason for Leave</th>
            @if ($hasPendingRequests)
                <th>Approved</th>
                <th>Reject</th>
            @endif
        </tr>
    </thead>
    <tbody>

        @foreach ($teamapplyleaveDatas as $applyleaveDatas)
            <tr>
                <td style="display: none;">{{ $applyleaveDatas->id }}</td>
                <td class="textfixed"> <a
                        href="{{ route('applyleave.show', $applyleaveDatas->id) }}">
                        {{ $applyleaveDatas->team_member ?? '' }}</a>
                </td>
                {{-- <td>{{ $applyleaveDatas->staffcode }}</td> --}}
                <td>{{ $applyleaveDatas->newstaff_code ?? ($applyleaveDatas->staffcode ?? '') }}</td>
                {{-- <td class="textfixed">
                    {{ date('d-m-Y', strtotime($applyleaveDatas->created_at)) ?? '' }}</td> --}}

                <td class="textfixed">
                    <span style="display: none;">
                        {{ date('Y-m-d', strtotime($applyleaveDatas->created_at)) }}
                    </span>
                    {{ date('d-m-Y', strtotime($applyleaveDatas->created_at)) }}
                </td>
                <td class="columnSize">
                    @if ($applyleaveDatas->status == 0)
                        <span class="badge badge-pill badge-warning"><span
                                style="display: none;">A</span>Created</span>
                    @elseif($applyleaveDatas->status == 1)
                        <span class="badge badge-success"><span
                                style="display: none;">B</span>Approved</span>
                    @elseif($applyleaveDatas->status == 2)
                        <span class="badge badge-danger">Rejected</span>
                    @endif
                </td>

                <td class="textfixed">

                    {{ $applyleaveDatas->name ?? '' }}
                    @if ($applyleaveDatas->type == '0')
                        <b>Type :</b> <span>Birthday</span><br>
                        <span><b>Birthday Date :
                            </b>{{ date(
                                'F d,Y',
                                strtotime(
                                    App\Models\Teammember::select('dateofbirth')->where('id', $applyleaveDatas->createdby)->first()->dateofbirth,
                                ),
                            ) ?? '' }}</span>
                    @elseif($applyleaveDatas->type == '1')
                        <span>Religious Festival</span>
                    @endif
                </td>
                <td class="textfixed">{{ date('d-m-Y', strtotime($applyleaveDatas->from)) ?? '' }} -
                    {{ date('d-m-Y', strtotime($applyleaveDatas->to)) ?? '' }}</td>
                @php
                    $to = Carbon\Carbon::createFromFormat('Y-m-d', $applyleaveDatas->to ?? '');
                    $from = Carbon\Carbon::createFromFormat('Y-m-d', $applyleaveDatas->from);
                    $diff_in_days = $to->diffInDays($from) + 1;
                    $holidaycount = DB::table('holidays')
                        ->where('startdate', '>=', $applyleaveDatas->from)
                        ->where('enddate', '<=', $applyleaveDatas->to)
                        ->count();
                @endphp
                <td>{{ $diff_in_days - $holidaycount ?? '' }}</td>

                @php
                    $approvelpartner = DB::table('teammembers')
                        ->leftJoin(
                            'teamrolehistory',
                            'teamrolehistory.teammember_id',
                            '=',
                            'teammembers.id',
                        )
                        ->where('teammembers.id', $applyleaveDatas->approver)
                        ->select(
                            'teammembers.team_member',
                            'teammembers.staffcode',
                            'teamrolehistory.newstaff_code',
                            'teamrolehistory.created_at',
                        )
                        ->first();

                    $datadate = Carbon\Carbon::createFromFormat(
                        'Y-m-d H:i:s',
                        $applyleaveDatas->created_at,
                    );

                    $permotiondate = null;
                    if ($approvelpartner->created_at) {
                        $permotiondate = Carbon\Carbon::createFromFormat(
                            'Y-m-d H:i:s',
                            $approvelpartner->created_at,
                        );
                    }
                @endphp


                <td class="textfixed">
                    {{ $approvelpartner->team_member ?? '' }}
                </td>
                <td>
                    @if ($permotiondate && $datadate->greaterThan($permotiondate))
                        {{ $approvelpartner->newstaff_code }}
                    @else
                        {{ $approvelpartner->staffcode }}
                    @endif
                </td>
                {{-- <td class="textfixed">
                    {{ $applyleaveDatas->reasonleave ?? '' }}
                </td> --}}
                {{-- <td class="textfixed">
                    @if (strlen($applyleaveDatas->reasonleave) > 25)
                        <span class="reasonleave-truncated" data-toggle="tooltip"
                            title="{{ $applyleaveDatas->reasonleave }}">
                            {{ substr($applyleaveDatas->reasonleave, 0, 25) }}...
                        </span>
                    @else
                        {{ $applyleaveDatas->reasonleave ?? '' }}
                    @endif
                </td> --}}
                {{-- examplee --}}
                <td class="textfixed">
                    @if (strlen($applyleaveDatas->reasonleave) > 25)
                        <span id="reasonleave-{{ $applyleaveDatas->id }}"
                            class="reasonleave-truncated"
                            title="{{ $applyleaveDatas->reasonleave }}">
                            {{ substr($applyleaveDatas->reasonleave, 0, 25) }}.....
                            <span style="color: #37A000; cursor: pointer;" data-toggle="tooltip"
                                title="Show full text"
                                onclick="showFullText('{{ $applyleaveDatas->reasonleave }}')">View
                                Detail</span>
                        </span>
                    @else
                        {{ $applyleaveDatas->reasonleave ?? '' }}
                    @endif
                </td>
                <td style="align-content: center;">
                    @if ($applyleaveDatas->status == 0)
                        <form method="post"
                            action="{{ route('applyleave.update', $applyleaveDatas->id) }}"
                            enctype="multipart/form-data" style="text-align: center;margin: 0px;">
                            @method('PATCH')
                            @csrf
                            <input type="text" hidden id="example-date-input" name="status"
                                value="1" class="form-control" placeholder="Enter Location">
                            <button type="submit" class="btn btn-success"
                                style="border-radius: 7px; font-size: 10px; padding: 5px;"
                                onclick="return confirm('Are you sure you want to approve this ?');">
                                Approve</button>
                        </form>
                    @endif
                </td>
                <td style="align-content: center;">
                    @if ($applyleaveDatas->status == 0)
                        <button data-toggle="modal" data-target="#exampleModal12{{ $loop->index }}"
                            class="btn btn-danger"
                            style="border-radius: 7px; font-size: 10px; padding: 5px;">
                            Reject</button>
                    @endif
                </td>

                {{-- model box --}}
                @if ($applyleaveDatas->status == 0)
                    <div class="modal fade" id="exampleModal12{{ $loop->index }}" tabindex="-1"
                        role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header" style="background:#37A000">
                                    <h5 style="color: white" class="modal-title font-weight-600"
                                        id="exampleModalLabel1">Reason For
                                        Rejection</h5>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form method="post"
                                    action="{{ url('applyleave/update', $applyleaveDatas->id) }}"
                                    enctype="multipart/form-data" id="formdata">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row row-sm">
                                            <div class="col-12">
                                                <label for="">Reason : <span
                                                        class="text-danger">*</span> </label>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <textarea rows="6" name="remark" class="form-control" placeholder="" id="reasoninput-{{ $loop->index }}"></textarea>
                                                    <input hidden type="text"
                                                        id="example-date-input" name="status"
                                                        value="2" class="form-control"
                                                        placeholder="Enter Reason">
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-danger"
                                            data-dismiss="modal">Close</button>
                                        <button type="submit" style="float: right"
                                            class="btn btn-success saveform"
                                            id="saveform-{{ $loop->index }}">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <script>
                        $(document).ready(function() {
                            $('#exampleModal12{{ $loop->index }}').on('hidden.bs.modal', function() {
                                $(this).find('form')[0].reset();
                            });
                        });
                    </script>
                @endif
            </tr>


            <script>
                $(function() {
                    $('[data-toggle="tooltip"]').tooltip({
                        html: true,
                        placement: 'top',
                        container: 'body'
                    });
                });
            </script>
            <style>
                .reasonleave-truncated {
                    overflow: hidden;
                    text-overflow: ellipsis;
                    white-space: nowrap;
                }

                .textfixed {
                    overflow: hidden;
                    text-overflow: ellipsis;
                    white-space: nowrap;
                }
            </style>
        @endforeach
    </tbody>
</table>


@php
    
public function timesheetrequestStore(Request $request)
{


  try {
    $request->validate([
      'reason' => 'required',
      'file' => 'nullable|mimes:png,pdf,jpeg,jpg|max:5120',
    ], [
      'file.max' => 'The file may not be greater than 5 MB.',
    ]);

    $data = $request->except(['_token', 'file']);
    $latestrequest = DB::table('timesheetrequests')
      ->where('createdby', auth()->user()->teammember_id)
      ->latest()
      ->select('created_at', 'status')
      ->first();
    // dd($latestrequest);
    if ($latestrequest != null && $latestrequest->status != 2) {

      $latestrequesthour = Carbon::parse($latestrequest->created_at);
      // dd($latestrequest->created_at);
      $currentDateTime = Carbon::now();
      // Check if the difference is more than 24 hours
      if ($latestrequesthour->diffInHours($currentDateTime) < 24) {


        $fileName = '';
        if ($request->hasFile('file')) {
          $file = $request->file('file');
          // public\backEnd\image\confirmationfile
          $destinationPath = 'backEnd/image/confirmationfile';
          $fileName = $file->getClientOriginalName();
          $file->move($destinationPath, $fileName);
        }

        $id = DB::table('timesheetrequests')->insertGetId([
          'partner'     =>     $request->partner,
          'reason'     =>     $request->reason,
          'attachment'     =>     $fileName,
          'status'     =>     0,
          'createdby' => auth()->user()->teammember_id,
          'created_at'          =>     date('Y-m-d H:i:s'),
          'updated_at'              =>    date('Y-m-d H:i:s'),
        ]);

        // timesheet request mail to admin
        $teammembermail = Teammember::where('id', $request->partner)->pluck('emailid')->first();
        $name = Teammember::where('id', auth()->user()->teammember_id)
          ->select('team_member', 'staffcode')
          ->first();

        $data = array(
          'teammember' => $name ?? '',
          'reason' => $request->reason ?? '',
          'created_at' => date('d-m-Y H:i:s'),
          'email' => $teammembermail ?? '',
          'id' => $id ?? '',
        );
        Mail::send('emails.timesheetrequestform', $data, function ($msg) use ($data) {
          $msg->to($data['email']);
          //     $msg->cc('itsupport_delhi@vsa.co.in');
          $msg->subject('Timesheet Submission Request');
        });
        dd('hi', 4);
        // timesheet request mail to admin
        return response()->json(['success' => true, 'msg' => 'Request Successfully']);
      } else {
        dd('hi', 3);
        $msg = 'You can submit new timesheet request after 24 hour from ' . date('h:i:s A', strtotime($latestrequest->created_at));
        return response()->json(['success' => false, 'msg' => $msg]);
      }
    } else {
      dd('hi', 2);

      $fileName = '';
      if ($request->hasFile('file')) {
        $file = $request->file('file');
        // public\backEnd\image\confirmationfile
        $destinationPath = 'backEnd/image/confirmationfile';
        $fileName = $file->getClientOriginalName();
        $file->move($destinationPath, $fileName);
      }

      $id = DB::table('timesheetrequests')->insertGetId([
        'partner'     =>     $request->partner,
        'reason'     =>     $request->reason,
        'attachment'     =>     $fileName,
        'status'     =>     0,
        'createdby' => auth()->user()->teammember_id,
        'created_at'          =>     date('Y-m-d H:i:s'),
        'updated_at'              =>    date('Y-m-d H:i:s'),
      ]);

      // timesheet request mail to admin
      $teammembermail = Teammember::where('id', $request->partner)->pluck('emailid')->first();
      $name = Teammember::where('id', auth()->user()->teammember_id)->pluck('team_member')->first();

      $data = array(
        'teammember' => $name ?? '',
        'email' => $teammembermail ?? '',
        'id' => $id ?? '',
      );
      Mail::send('emails.timesheetrequestform', $data, function ($msg) use ($data) {
        $msg->to($data['email']);
        //   $msg->cc('itsupport_delhi@vsa.co.in');
        $msg->subject('Timesheet Submission Request');
      });
      // timesheet request mail to admin
      return response()->json(['success' => true, 'msg' => 'Request Successfully Done']);
    }
  } catch (Exception $e) {
    DB::rollBack();
    Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
    report($e);
    return response()->json(['success' => false, 'msg' => $e->getMessage()]);
  }
}
@endphp
{{--  --}}
<div class="modal-body">
    <div class="details-form-field form-group row">
        @if ($assignmentbudgetingDatas->status == 1)
            <div class="col-6">
            @else
                <div class="col-12">
        @endif
        <div class="form-group">
            <label class="font-weight-600">Name</label>
            <select class="language form-control"
                id="exampleFormControlSelect1" name="teammember_id">
                <option value="">Please Select One</option>
                @foreach ($teammemberall as $teammemberData)
                    <option value="{{ $teammemberData->id }}">
                        {{ $teammemberData->team_member }}
                        ({{ $teammemberData->staffcode }})
                    </option>
                @endforeach
            </select>
            <input type="text" hidden name="assignmentmapping_id"
                value="{{ $assignmentbudgetingDatas->id }}"
                class=" form-control" placeholder="Enter Client Name">
        </div>
    </div>
    @if ($assignmentbudgetingDatas->status == 1)
        <div class="col-5">
            <div class="form-group">
                <label class="font-weight-600">Type</label>
                <select class="form-control key" id="key"
                    name="type">
                    <option value="">Please Select One</option>
                    <option value="0">Team Leader</option>
                    <option value="2">Staff</option>
                </select>
            </div>
        </div>
    @else
        <input type="text" hidden name="type" value="2"
            class=" form-control" placeholder="Enter Client Name">
    @endif
</div>
{{--  --}}
mai yaha aap ko site ke baare me bta raha hu fir iske aacording content dena ok basically This project is a related tracking url yaha user koi bhi link ko test kar sakta hai ki is url me kitna redirection url hai aur us redirection url ko result section me display karta hai aur fir ek url genrate karta hai so that us url se us result koi koi bhi dekh sakta hai jab vo url share karega kisi ke saath 
{{--  --}}
      // when submit timesheet before joining date
                                $assignmentid == 213 && $getsixdata->workitem == 'NA' => null,

                                $totalCountMapping = [
                                    'P' => 'no_of_days_present',
                                    'CL' => 'casual_leave',
                                    'EL' => 'exam_leave',
                                    'T' => 'travel',
                                    'OH' => 'offholidays',
                                    'W' => 'sundaycount',
                                    'H' => 'holidays',
                                    null => 'lwp'
                                ];
{{--  --}}
<div class="col-md-6 col-lg-3">
    <div class="p-2 text-white rounded mb-3 p-3 shadow-sm text-center" style="background: #00548bfa;green">
        <a href="{{ url('totalworkingdays', auth()->user()->teammember_id) }}">
            <div style="color:white;"
                class="opacity-50 header-pretitle fs-11 font-weight-bold text-uppercase">Total Working Days
            </div>
            <div style="color:white;" class="fs-32 text-monospace">{{ $totalworkingdays ?? '0' }}
            </div>
            <small style="color:white;">Days (April to {{ $currentMonth }})</small>
        </a>
    </div>
</div>
{{--  --}}
// total working days start using financial year
      $currentDate = Carbon::now();
      $currentMonth = $currentDate->format('F');
      if ($currentDate->month >= 4) {
        // Current year financial year
        $startDate = Carbon::create($currentDate->year, 4, 1);
        $endDate = Carbon::create($currentDate->year + 1, 3, 31);
      } else {
        // Previous year financial year
        $startDate = Carbon::create($currentDate->year - 1, 4, 1);
        $endDate = Carbon::create($currentDate->year, 3, 31);
      }

      $totalworkingdays = DB::table('attendances')
        ->where('employee_name', auth()->user()->teammember_id)
        ->whereBetween('fulldate', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
        ->sum('no_of_days_present');
      // total working days end hare 
{{--  --}}
'totalworkingdays', 'currentMonth'
{{--  --}}
// // only agust months
// $nextweektimesheet1 = DB::table('timesheetusers')
//     ->where('createdby', 847)
//     ->whereBetween('date', ['2024-08-26', '2024-08-31'])
//     // ->get();
//     ->update(['status' => 0]);
// // ->delete();


// $nextweektimesheet2 = DB::table('timesheets')
//     ->where('created_by', 847)
//     ->whereBetween('date', ['2024-08-26', '2024-08-31'])
//     // ->get();
//     ->update(['status' => 0]);
// // ->delete();
// // more than one week delete 
// // $result = ['2024-07-29', '2024-08-05', '2024-08-12', '2024-08-19', '2024-08-26'];
// $result = ['2024-08-26'];
// foreach ($result as $date) {
//     $nextweektimesheet3 = DB::table('timesheetreport')
//         ->where('teamid', 847)
//         ->where('startdate', $date)
//         // ->get();
//         ->delete();
// }
// dd('hi');


// $nextweektimesheet1 = DB::table('timesheetusers')
//     ->where('createdby', 847)
//     ->whereBetween('date', ['2024-08-19', '2024-08-31'])
//     // ->get();
//     ->update(['status' => 0]);


// $nextweektimesheet2 = DB::table('timesheets')
//     ->where('created_by', 847)
//     ->whereBetween('date', ['2024-08-19', '2024-08-31'])
//     // ->get();
//     ->update(['status' => 0]);
// // more than one week delete 
// // $result = ['2024-07-29', '2024-08-05', '2024-08-12', '2024-08-19', '2024-08-26'];
// // $result = ['2024-07-01', '2024-07-08', '2024-07-15', '2024-07-22', '2024-07-29', '2024-08-05', '2024-08-12', '2024-08-19', '2024-08-26'];
// $result = ['2024-08-19', '2024-08-26'];
// foreach ($result as $date) {
//     $nextweektimesheet3 = DB::table('timesheetreport')
//         ->where('teamid', 847)
//         ->where('startdate', $date)
//         // ->get();
//         ->delete();
// }
// dd('hi');

// 22222222222222
{{--  --}}
$iftwotimesheetinday = DB::table('attendances')
->where('id', $attendances->id)
->value($column);

if ($iftwotimesheetinday == "P") {
$updatewording = "P";
$totalcountupdate = $attendances->$totalcountColumn + 0;
} elseif ($iftwotimesheetinday == 'T') {
$updatewording = "P";
$totalcountupdate = $attendances->$totalcountColumn + 0;
}
{{--  --}}
if ($prevcheck == null) {

    // DB::table('attendances')
    //     ->where('employee_name', auth()->user()->teammember_id)
    //     ->where('month', $month1)
    //     ->update([$dayWord => $updateddata]);

    // Update the total count and attendance record if applicable
    if (isset($totalCountMapping[$updateddata])) {
        $totalcountColumn = $totalCountMapping[$updateddata];
        $totalcountupdate = $attendances->$totalcountColumn + 1;
        // DB::table('attendances')
        //     ->where('id', $attendances->id)
        //     ->update([
        //         $dayWord => $updateddata,
        //         $totalcountColumn => $totalcountupdate,
        //     ]);
        DB::table('attendances')
            ->where('employee_name', auth()->user()->teammember_id)
            ->where('month', $month1)
            ->update([
                $dayWord => $updateddata,
                $totalcountColumn => $totalcountupdate,
            ]);
    }
}

if ($prevcheck == null && isset($totalCountMapping[$updateddata])) {
    $totalcountColumn = $totalCountMapping[$updateddata];
    $sundaycountget = DB::table('attendances')
        ->where('employee_name', auth()->user()->teammember_id)
        ->where('month', $month1)
        ->first();

    if ($sundaycountget) {
        $totalcountupdate = $sundaycountget->$totalcountColumn + 1;
        DB::table('attendances')
            ->where('id', $sundaycountget->id)
            ->update([
                $dayWord => $updateddata,
                $totalcountColumn => $totalcountupdate,
            ]);
        // $updateddata = $getholidaysss ? 'H' : 'W';
    }
}
{{--  --}}
    public function timesheetsubmission(Request $request)
    {
        try {

            // only agust months
            // $nextweektimesheet1 = DB::table('timesheetusers')
            //     ->where('createdby', 847)
            //     ->whereBetween('date', ['2024-07-29', '2024-08-31'])
            //     // ->get();
            //     ->update(['status' => 0]);


            // $nextweektimesheet2 = DB::table('timesheets')
            //     ->where('created_by', 847)
            //     ->whereBetween('date', ['2024-07-29', '2024-08-31'])
            //     // ->get();
            //     ->update(['status' => 0]);
            // // more than one week delete 
            // // $result = ['2024-07-29', '2024-08-05', '2024-08-12', '2024-08-19', '2024-08-26'];
            // $result = ['2024-07-29', '2024-08-05', '2024-08-12', '2024-08-19', '2024-08-26'];
            // foreach ($result as $date) {
            //     $nextweektimesheet3 = DB::table('timesheetreport')
            //         ->where('teamid', 847)
            //         ->where('startdate', $date)
            //         // ->get();
            //         ->delete();
            // }
            // dd('hi');


            // $nextweektimesheet1 = DB::table('timesheetusers')
            //     ->where('createdby', 847)
            //     ->whereBetween('date', ['2024-07-01', '2024-08-31'])
            //     // ->get();
            //     ->update(['status' => 0]);


            // $nextweektimesheet2 = DB::table('timesheets')
            //     ->where('created_by', 847)
            //     ->whereBetween('date', ['2024-07-01', '2024-08-31'])
            //     // ->get();
            //     ->update(['status' => 0]);
            // // more than one week delete 
            // // $result = ['2024-07-29', '2024-08-05', '2024-08-12', '2024-08-19', '2024-08-26'];
            // $result = ['2024-07-01', '2024-07-08', '2024-07-15', '2024-07-22', '2024-07-29', '2024-08-05', '2024-08-12', '2024-08-19', '2024-08-26'];
            // foreach ($result as $date) {
            //     $nextweektimesheet3 = DB::table('timesheetreport')
            //         ->where('teamid', 847)
            //         ->where('startdate', $date)
            //         // ->get();
            //         ->delete();
            // }
            // dd('hi');

            // 22222222222222






            $checksavetimesheet = DB::table('timesheetusers')
                ->where('createdby', auth()->user()->teammember_id)
                ->where('status', 0)
                ->first();

            if ($checksavetimesheet == null) {
                $output = array('msg' => "You have not saved any timesheets. Please save your timesheet.");
                return back()->with('statuss', $output);
            }

            $latesttimesheetreport =  DB::table('timesheetreport')
                ->where('teamid', auth()->user()->teammember_id)
                ->orderBy('id', 'desc')
                ->first();

            // $latesttimesheetreport is not null 
            if ($latesttimesheetreport !== null) {
                // dd('hi 1');
                $timesheetreportenddate = Carbon::parse($latesttimesheetreport->enddate);

                // find next sturday 
                $nextSaturday = $timesheetreportenddate->copy()->next(Carbon::SATURDAY);
                $formattedNextSaturday = $nextSaturday->format('Y-m-d');
                $formattedNextSaturday1 = $timesheetreportenddate->format('d-m-Y');

                // find next week timesheet filled or not 
                $nextweektimesheet = DB::table('timesheetusers')
                    ->where('createdby', auth()->user()->teammember_id)
                    ->whereIn('status', [0, 1])
                    ->where('date', $formattedNextSaturday)
                    ->first();

                // Fetch the rejoining data
                $rejoiningcheck = DB::table('teammembers')
                    ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
                    ->leftJoin('rejoiningsamepost', 'rejoiningsamepost.teammember_id', '=', 'teammembers.id')
                    ->where('teammembers.id', auth()->user()->teammember_id)
                    ->select(
                        'teammembers.team_member',
                        'teammembers.staffcode',
                        'teammembers.joining_date',
                        'teamrolehistory.newstaff_code',
                        'teamrolehistory.rejoiningdate',
                        'rejoiningsamepost.rejoiningdate as samepostrejoiningdate'
                    )
                    ->first();


                // Initialize the variable
                $rejoiningchecktimesheet = null;

                // Check if any rejoining date is set
                $rejoiningDate = $rejoiningcheck->rejoiningdate ?? $rejoiningcheck->samepostrejoiningdate;

                // Check if the rejoining date is set
                if ($rejoiningDate) {
                    $rejoining = Carbon::parse($rejoiningDate);
                    $nextweek = Carbon::parse($formattedNextSaturday);

                    // Check if the rejoining date is before next week's Saturday
                    if ($rejoining < $nextweek) {
                        $rejoiningchecktimesheet = DB::table('timesheetusers')
                            ->where('createdby', auth()->user()->teammember_id)
                            ->whereIn('status', [0, 1])
                            ->where('date', $formattedNextSaturday)
                            ->first();
                    }
                }

                // Determine the next week's timesheet status


                if ($nextweektimesheet == null && $rejoiningchecktimesheet == null && $rejoiningDate == null) {
                    $output = array('msg' => "Fill the Week timesheet After this week: $formattedNextSaturday1");
                    return back()->with('statuss', $output);
                } else {
                    $usertimesheetfirstdate =  DB::table('timesheets')
                        ->where('status', '0')
                        ->where('created_by', auth()->user()->teammember_id)->orderBy('date', 'ASC')->first();

                    $lastdate = Carbon::createFromFormat('Y-m-d', $usertimesheetfirstdate->date ?? '')->addDays(6);

                    if ($usertimesheetfirstdate) {

                        $firstDate = new DateTime($usertimesheetfirstdate->date);
                        $dayOfWeek = $firstDate->format('w');
                        $daysToAdd = 0;

                        if ($dayOfWeek !== '0') {
                            $daysToAdd = 7 - $dayOfWeek;
                        } else {
                            $output = array('msg' => 'Submit the timesheet from Monday to Sunday.');
                            return back()->with('success', $output);
                        }

                        if ($dayOfWeek > 0) {
                            $daysToSubtract = $dayOfWeek - 1;
                        } else {
                            $daysToSubtract = $dayOfWeek;
                        }

                        $upcomingSunday = (new DateTime($firstDate->format('Y-m-d')))->modify("+$daysToAdd days")->format('Y-m-d');

                        $presentWeekMonday = (new DateTime($firstDate->format('Y-m-d')))->modify("-$daysToSubtract days")->format('Y-m-d');
                    }

                    $get_six_Data = DB::table('timesheetusers')
                        ->where('status', '0')
                        ->where('createdby', auth()->user()->teammember_id)
                        ->whereBetween('date', [$firstDate->format('Y-m-d'), $upcomingSunday])
                        ->orderBy('date', 'ASC')
                        ->get();



                    $lastdate = $get_six_Data->max('date');



                    //copy dates in retrievedDates array in datetime format
                    $retrievedDates = [];

                    foreach ($get_six_Data as $entry) {
                        $date = new DateTime($entry->date);
                        $retrievedDates[] = $date->format('Y-m-d');
                    }

                    $expectedDates = [];   // will contain ALL the dates occurs b/w first day to upcoming sunday
                    $firstDate = new DateTime($presentWeekMonday);
                    $upcomingSundayDate = new DateTime($upcomingSunday);

                    // Clone $firstDate so that it is not modified
                    $currentDate = clone $firstDate;

                    while ($currentDate->format('Y-m-d') < $upcomingSundayDate->format('Y-m-d')) {  //excluding sunday
                        $expectedDates[] = $currentDate->format('Y-m-d');


                        $currentDate->modify("+1 day");
                    }

                    $missingDates = array_diff($expectedDates, $retrievedDates);

                    if (!empty($missingDates)) {
                        $missingDatesString = implode(', ', $missingDates);
                        $output = array('msg' => "Timesheet Submit Failed Missing dates: $missingDatesString");
                        return back()->with('success', $output);
                    } else {
                        foreach ($get_six_Data as $getsixdata) {

                            // Convert the requested date to a Carbon instance
                            $requestedDate = Carbon::createFromFormat('Y-m-d', $getsixdata->date);

                            if (date('l', strtotime(date('d-m-Y', strtotime($getsixdata->date)))) == 'Monday') {
                                $previousMonday = $requestedDate->copy()->previous(Carbon::MONDAY);

                                // Find the nearest next Saturday to the requested date
                                $nextSaturday = $requestedDate->copy()->next(Carbon::SATURDAY);

                                // Format the dates in 'Y-m-d' format
                                $previousMondayFormatted = $getsixdata->date;
                                $nextSaturdayFormatted = $nextSaturday->format('Y-m-d');
                                $nextSaturdayFormatted = $lastdate;


                                $week =  date('d-m-Y', strtotime($previousMondayFormatted))  . ' to ' . date('d-m-Y', strtotime($nextSaturdayFormatted));
                                $co = DB::table('timesheetusers')
                                    ->where('createdby', auth()->user()->teammember_id)
                                    ->whereBetween('date', [$previousMondayFormatted, $nextSaturdayFormatted])
                                    ->select('partner', DB::raw('SUM(hour) as total_hours'), DB::raw('COUNT(DISTINCT timesheetid) as row_count'))
                                    ->groupBy('partner')
                                    ->get();

                                foreach ($co as $codata) {
                                    // DB::table('timesheetreport')->insert([
                                    //     'teamid'       =>     auth()->user()->teammember_id,
                                    //     'week'       =>     $week,
                                    //     'totaldays'       =>     $codata->row_count,
                                    //     'totaltime' =>  $codata->total_hours,
                                    //     'partnerid'  => $codata->partner,
                                    //     'startdate'  => $previousMondayFormatted,
                                    //     'enddate'  => $nextSaturdayFormatted,
                                    //     // 'created_at'                =>       date('y-m-d'),
                                    //     'created_at'                =>      date('y-m-d H:i:s'),
                                    // ]);
                                }

                                $totaldays = DB::table('timesheetusers')
                                    ->where('createdby', auth()->user()->teammember_id)
                                    ->whereBetween('date', [$previousMondayFormatted, $nextSaturdayFormatted])
                                    ->select('date')
                                    ->groupBy('date')
                                    ->get();

                                $totaldaysCount = $totaldays->count();
                                $latesttimesheetreport = DB::table('timesheetreport')
                                    ->where('teamid', auth()->user()->teammember_id)
                                    ->where('startdate', $previousMondayFormatted)
                                    ->first();

                                if ($latesttimesheetreport) {
                                    // DB::table('timesheetreport')
                                    //     ->where('id', $latesttimesheetreport->id)
                                    //     ->update(['dayscount' => $totaldaysCount]);
                                }
                            }

                            // DB::table('timesheetusers')->where('timesheetid', $getsixdata->timesheetid)->update([
                            //     'status'         =>     1,
                            //     'updated_at'              =>    date('y-m-d'),
                            // ]);
                            // DB::table('timesheets')->where('id', $getsixdata->timesheetid)->update([
                            //     'status'         =>     1,
                            //     'updated_at'              =>    date('y-m-d'),
                            // ]);

                            // Attendance code start hare 
                            $hdatess = Carbon::parse($getsixdata->date)->format('Y-m-d');
                            $day = Carbon::parse($hdatess)->format('d');
                            $month = Carbon::parse($hdatess)->format('F');
                            $yeardata = Carbon::parse($hdatess)->format('Y');

                            $dates = [
                                '26' => 'twentysix',
                                '27' => 'twentyseven',
                                '28' => 'twentyeight',
                                '29' => 'twentynine',
                                '30' => 'thirty',
                                '31' => 'thirtyone',
                                '01' => 'one',
                                '02' => 'two',
                                '03' => 'three',
                                '04' => 'four',
                                '05' => 'five',
                                '06' => 'six',
                                '07' => 'seven',
                                '08' => 'eight',
                                '09' => 'nine',
                                '10' => 'ten',
                                '11' => 'eleven',
                                '12' => 'twelve',
                                '13' => 'thirteen',
                                '14' => 'fourteen',
                                '15' => 'fifteen',
                                '16' => 'sixteen',
                                '17' => 'seventeen',
                                '18' => 'eighteen',
                                '19' => 'ninghteen',
                                '20' => 'twenty',
                                '21' => 'twentyone',
                                '22' => 'twentytwo',
                                '23' => 'twentythree',
                                '24' => 'twentyfour',
                                '25' => 'twentyfive',
                            ];

                            $column = $dates[$day];
                            // check attendenace record exist or not 
                            $attendances = DB::table('attendances')
                                ->where('employee_name', auth()->user()->teammember_id)
                                ->where('month', $month)
                                ->first();

                            if ($attendances == null) {
                                $teammember = DB::table('teammembers')->where('id', auth()->user()->teammember_id)->first();
                                DB::table('attendances')->insert([
                                    'employee_name' => $teammember->id,
                                    'month' => $month,
                                    'year' => $yeardata,
                                    'dateofjoining' => $teammember->joining_date,
                                    'fulldate' => date('Y-m-d'),
                                    'created_at' => date('Y-m-d H:i:s'),
                                    'updated_at' => date('Y-m-d H:i:s'),
                                ]);
                            }

                            $attendances = DB::table('attendances')
                                ->where('employee_name', auth()->user()->teammember_id)
                                ->where('month', $month)
                                ->first();

                            if ($attendances != null && property_exists($attendances, $column)) {

                                $client = $getsixdata->client_id;
                                $assignmentid = $getsixdata->assignment_id;

                                $updatewording = match (true) {
                                    // Travel
                                    $client == 32 => 'T',
                                    // Off holidays
                                    $client == 33 && str_replace(['1st ', '2nd ', '3rd ', '4th ', '5th '], '', $request->workitem) == 'Saturday' => 'OH',
                                    // Other holidays from calendar
                                    $client == 33 => 'H',
                                    // Casual leave
                                    $client == 134 && $assignmentid == 215 => 'CL',
                                    // Exam leave
                                    $client == 134 && $assignmentid == 214 => 'EL',
                                        // Default presence
                                    default => 'P',
                                };
                            }

                            $totalCountMapping = [
                                'P' => 'no_of_days_present',
                                'CL' => 'casual_leave',
                                'EL' => 'exam_leave',
                                'T' => 'travel',
                                'OH' => 'offholidays',
                                'W' => 'sundaycount',
                                'H' => 'holidays'
                            ];

                            // Update the total count and attendance record if applicable
                            if (isset($totalCountMapping[$updatewording])) {
                                $totalcountColumn = $totalCountMapping[$updatewording];
                                $totalcountupdate = $attendances->$totalcountColumn + 1;

                                // DB::table('attendances')
                                //     ->where('id', $attendances->id)
                                //     ->update([
                                //         $column => $updatewording,
                                //         $totalcountColumn => $totalcountupdate,
                                //     ]);
                            }
                            // Attendance code end hare  
                        }


                        // update sunday data in attendance
                        $lastdateFormate = Carbon::createFromFormat('Y-m-d', $lastdate);
                        $prevSunday = $lastdateFormate->copy()->previous(Carbon::SUNDAY);
                        $day1 = Carbon::parse($prevSunday)->format('d');
                        $month1 = $prevSunday->format('F');

                        $numberWords = [
                            '1' => 'one',
                            '2' => 'two',
                            '3' => 'three',
                            '4' => 'four',
                            '5' => 'five',
                            '6' => 'six',
                            '7' => 'seven',
                            '8' => 'eight',
                            '9' => 'nine',
                            '10' => 'ten',
                            '11' => 'eleven',
                            '12' => 'twelve',
                            '13' => 'thirteen',
                            '14' => 'fourteen',
                            '15' => 'fifteen',
                            '16' => 'sixteen',
                            '17' => 'seventeen',
                            '18' => 'eighteen',
                            '19' => 'nineteen',
                            '20' => 'twenty',
                            '21' => 'twentyone',
                            '22' => 'twentytwo',
                            '23' => 'twentythree',
                            '24' => 'twentyfour',
                            '25' => 'twentyfive',
                            '26' => 'twentysix',
                            '27' => 'twentyseven',
                            '28' => 'twentyeight',
                            '29' => 'twentynine',
                            '30' => 'thirty',
                            '31' => 'thirtyone'
                        ];

                        $dayWord = $numberWords[(int)$day1];

                        if (!in_array($prevSunday, $retrievedDates)) {
                            $getdateformated = $prevSunday->format('Y-m-d');
                            $getholidaysss = DB::table('holidays')
                                ->where('startdate', '=', $getdateformated)
                                ->orWhere('enddate', '=', $getdateformated)
                                ->first();

                            if ($getholidaysss != null) {
                                $updateddata = 'H';
                            } else {
                                $updateddata = 'W';
                            }

                            $totalCountMapping = [
                                'P' => 'no_of_days_present',
                                'CL' => 'casual_leave',
                                'EL' => 'exam_leave',
                                'T' => 'travel',
                                'OH' => 'offholidays',
                                'W' => 'sundaycount',
                                'H' => 'holidays'
                            ];

                            $prevcheck = DB::table('attendances')
                                ->where('employee_name', auth()->user()->teammember_id)
                                ->where('month', $month1)
                                ->whereNotNull($dayWord)
                                ->first();

                            if ($prevcheck == null) {

                                // DB::table('attendances')
                                //     ->where('employee_name', auth()->user()->teammember_id)
                                //     ->where('month', $month1)
                                //     ->update([$dayWord => $updateddata]);

                                // Update the total count and attendance record if applicable
                                if (isset($totalCountMapping[$updateddata])) {
                                    $totalcountColumn = $totalCountMapping[$updateddata];
                                    $sundaycountget = DB::table('attendances')
                                        ->where('employee_name', auth()->user()->teammember_id)
                                        ->where('month', $month1)
                                        ->first();
                                    $totalcountupdate = $sundaycountget->$totalcountColumn + 1;

                                    dd($totalcountupdate);
                                    // DB::table('attendances')
                                    //     ->where('id', $attendances->id)
                                    //     ->update([
                                    //         $dayWord => $updateddata,
                                    //         $totalcountColumn => $totalcountupdate,
                                    //     ]);


                                    DB::table('attendances')
                                        ->where('employee_name', auth()->user()->teammember_id)
                                        ->where('month', $month1)
                                        ->update([
                                            $dayWord => $updateddata,
                                            $totalcountColumn => $totalcountupdate,
                                        ]);
                                }
                            }
                        }
                        // update sunday data in attendance end hare
                    }
                    $output = array('msg' => "Timesheet Submit Successfully till " . Carbon::createFromFormat('Y-m-d', $previousMondayFormatted)->format('d-m-Y') . " to " . Carbon::createFromFormat('Y-m-d', $nextSaturdayFormatted)->format('d-m-Y'));
                    return back()->with('success', $output);
                }
            } else {
                $usertimesheetfirstdate =  DB::table('timesheets')
                    ->where('status', '0')
                    ->where('created_by', auth()->user()->teammember_id)->orderBy('date', 'ASC')->first();
                $lastdate = Carbon::createFromFormat('Y-m-d', $usertimesheetfirstdate->date ?? '')->addDays(6);

                if ($usertimesheetfirstdate) {
                    $firstDate = new DateTime($usertimesheetfirstdate->date);
                    $dayOfWeek = $firstDate->format('w');
                    $daysToAdd = 0;

                    if ($dayOfWeek !== '0') {
                        $daysToAdd = 7 - $dayOfWeek;
                    } else {
                        $output = array('msg' => 'Submit the timesheet from Monday to Sunday.');
                        return back()->with('success', $output);
                    }

                    if ($dayOfWeek > 0) {
                        $daysToSubtract = $dayOfWeek - 1;
                    } else {
                        $daysToSubtract = $dayOfWeek;
                    }

                    $upcomingSunday = (new DateTime($firstDate->format('Y-m-d')))->modify("+$daysToAdd days")->format('Y-m-d');

                    $presentWeekMonday = (new DateTime($firstDate->format('Y-m-d')))->modify("-$daysToSubtract days")->format('Y-m-d');
                }


                // $get_six_Data = DB::table('timesheets')
                //     ->where('status', '0')
                //     ->where('created_by', auth()->user()->teammember_id)
                //     ->whereBetween('date', [$firstDate->format('Y-m-d'), $upcomingSunday])
                //     ->orderBy('date', 'ASC')
                //     ->get();


                $get_six_Data = DB::table('timesheetusers')
                    ->where('status', '0')
                    ->where('createdby', auth()->user()->teammember_id)
                    ->whereBetween('date', [$firstDate->format('Y-m-d'), $upcomingSunday])
                    ->orderBy('date', 'ASC')
                    ->get();


                $lastdate = $get_six_Data->max('date');

                $retrievedDates = [];   //copy dates in retrievedDates array in datetime format

                foreach ($get_six_Data as $entry) {
                    $date = new DateTime($entry->date);
                    $retrievedDates[] = $date->format('Y-m-d');
                }

                $expectedDates = [];   // will contain ALL the dates occurs b/w first day to upcoming sunday
                $firstDate = new DateTime($presentWeekMonday);
                $upcomingSundayDate = new DateTime($upcomingSunday);
                // Clone $firstDate so that it is not modified
                $currentDate = clone $firstDate;

                while ($currentDate->format('Y-m-d') < $upcomingSundayDate->format('Y-m-d')) {  //excluding sunday
                    $expectedDates[] = $currentDate->format('Y-m-d');
                    $currentDate->modify("+1 day");
                }

                $missingDates = array_diff($expectedDates, $retrievedDates);

                if (!empty($missingDates)) {
                    $missingDatesString = implode(', ', $missingDates);
                    $output = array('msg' => "Timesheet Submit Failed Missing dates: $missingDatesString");
                    return back()->with('success', $output);
                } else {
                    foreach ($get_six_Data as $getsixdata) {
                        // Convert the requested date to a Carbon instance
                        $requestedDate = Carbon::createFromFormat('Y-m-d', $getsixdata->date);

                        if (date('l', strtotime(date('d-m-Y', strtotime($getsixdata->date)))) == 'Monday') {
                            $previousMonday = $requestedDate->copy()->previous(Carbon::MONDAY);
                            // Find the nearest next Saturday to the requested date
                            $nextSaturday = $requestedDate->copy()->next(Carbon::SATURDAY);
                            // Format the dates in 'Y-m-d' format
                            $previousMondayFormatted = $getsixdata->date;
                            $nextSaturdayFormatted = $nextSaturday->format('Y-m-d');
                            $nextSaturdayFormatted = $lastdate;

                            $week =  date('d-m-Y', strtotime($previousMondayFormatted))  . ' to ' . date('d-m-Y', strtotime($nextSaturdayFormatted));
                            $co = DB::table('timesheetusers')
                                ->where('createdby', auth()->user()->teammember_id)
                                ->whereBetween('date', [$previousMondayFormatted, $nextSaturdayFormatted])
                                ->select('partner', DB::raw('SUM(hour) as total_hours'), DB::raw('COUNT(DISTINCT timesheetid) as row_count'))
                                ->groupBy('partner')
                                ->get();

                            foreach ($co as $codata) {
                                DB::table('timesheetreport')->insert([
                                    'teamid'       =>     auth()->user()->teammember_id,
                                    'week'       =>     $week,
                                    'totaldays'       =>     $codata->row_count,
                                    'totaltime' =>  $codata->total_hours,
                                    'partnerid'  => $codata->partner,
                                    'startdate'  => $previousMondayFormatted,
                                    'enddate'  => $nextSaturdayFormatted,
                                    // 'created_at'                =>       date('y-m-d'),
                                    'created_at'                =>      date('y-m-d H:i:s'),
                                ]);
                            }

                            $totaldays = DB::table('timesheetusers')
                                ->where('createdby', auth()->user()->teammember_id)
                                ->whereBetween('date', [$previousMondayFormatted, $nextSaturdayFormatted])
                                ->select('date')
                                ->groupBy('date')
                                ->get();

                            $totaldaysCount = $totaldays->count();
                            $latesttimesheetreport = DB::table('timesheetreport')
                                ->where('teamid', auth()->user()->teammember_id)
                                ->where('startdate', $previousMondayFormatted)
                                ->first();

                            if ($latesttimesheetreport) {
                                DB::table('timesheetreport')
                                    ->where('id', $latesttimesheetreport->id)
                                    ->update(['dayscount' => $totaldaysCount]);
                            }
                        }

                        // DB::table('timesheetusers')->where('timesheetid', $getsixdata->id)->update([
                        //     'status'         =>     1,
                        //     'updated_at'              =>    date('y-m-d'),
                        // ]);
                        // DB::table('timesheets')->where('id', $getsixdata->id)->update([
                        //     'status'         =>     1,
                        //     'updated_at'              =>    date('y-m-d'),
                        // ]);

                        DB::table('timesheetusers')->where('timesheetid', $getsixdata->timesheetid)->update([
                            'status'         =>     1,
                            'updated_at'              =>    date('y-m-d'),
                        ]);
                        DB::table('timesheets')->where('id', $getsixdata->timesheetid)->update([
                            'status'         =>     1,
                            'updated_at'              =>    date('y-m-d'),
                        ]);

                        // Attendance code start hare 
                        $hdatess = Carbon::parse($getsixdata->date)->format('Y-m-d');
                        $day = Carbon::parse($hdatess)->format('d');
                        $month = Carbon::parse($hdatess)->format('F');
                        $yeardata = Carbon::parse($hdatess)->format('Y');

                        $dates = [
                            '26' => 'twentysix',
                            '27' => 'twentyseven',
                            '28' => 'twentyeight',
                            '29' => 'twentynine',
                            '30' => 'thirty',
                            '31' => 'thirtyone',
                            '01' => 'one',
                            '02' => 'two',
                            '03' => 'three',
                            '04' => 'four',
                            '05' => 'five',
                            '06' => 'six',
                            '07' => 'seven',
                            '08' => 'eight',
                            '09' => 'nine',
                            '10' => 'ten',
                            '11' => 'eleven',
                            '12' => 'twelve',
                            '13' => 'thirteen',
                            '14' => 'fourteen',
                            '15' => 'fifteen',
                            '16' => 'sixteen',
                            '17' => 'seventeen',
                            '18' => 'eighteen',
                            '19' => 'ninghteen',
                            '20' => 'twenty',
                            '21' => 'twentyone',
                            '22' => 'twentytwo',
                            '23' => 'twentythree',
                            '24' => 'twentyfour',
                            '25' => 'twentyfive',
                        ];

                        $column = $dates[$day];
                        // check attendenace record exist or not 
                        $attendances = DB::table('attendances')
                            ->where('employee_name', auth()->user()->teammember_id)
                            ->where('month', $month)
                            ->first();

                        if ($attendances == null) {
                            $teammember = DB::table('teammembers')->where('id', auth()->user()->teammember_id)->first();
                            DB::table('attendances')->insert([
                                'employee_name' => $teammember->id,
                                'month' => $month,
                                'year' => $yeardata,
                                'dateofjoining' => $teammember->joining_date,
                                'fulldate' => date('Y-m-d'),
                                'created_at' => date('Y-m-d H:i:s'),
                                'updated_at' => date('Y-m-d H:i:s'),
                            ]);
                        }

                        $attendances = DB::table('attendances')
                            ->where('employee_name', auth()->user()->teammember_id)
                            ->where('month', $month)
                            ->first();

                        if ($attendances != null && property_exists($attendances, $column)) {

                            $client = $getsixdata->client_id;
                            $assignmentid = $getsixdata->assignment_id;

                            $updatewording = match (true) {
                                // Travel
                                $client == 32 => 'T',
                                // Off holidays
                                $client == 33 && str_replace(['1st ', '2nd ', '3rd ', '4th ', '5th '], '', $request->workitem) == 'Saturday' => 'OH',
                                // Other holidays from calendar
                                $client == 33 => 'H',
                                // Casual leave
                                $client == 134 && $assignmentid == 215 => 'CL',
                                // Exam leave
                                $client == 134 && $assignmentid == 214 => 'EL',
                                    // Default presence
                                default => 'P',
                            };
                        }

                        $totalCountMapping = [
                            'P' => 'no_of_days_present',
                            'CL' => 'casual_leave',
                            'EL' => 'exam_leave',
                            'T' => 'travel',
                            'OH' => 'offholidays',
                            'W' => 'sundaycount',
                            'H' => 'holidays'
                        ];

                        // Update the total count and attendance record if applicable
                        if (isset($totalCountMapping[$updatewording])) {
                            $totalcountColumn = $totalCountMapping[$updatewording];
                            $totalcountupdate = $attendances->$totalcountColumn + 1;

                            DB::table('attendances')
                                ->where('id', $attendances->id)
                                ->update([
                                    $column => $updatewording,
                                    $totalcountColumn => $totalcountupdate,
                                ]);
                        }
                        // Attendance code end hare  
                    }

                    // update sunday data in attendance
                    $lastdateFormate = Carbon::createFromFormat('Y-m-d', $lastdate);
                    $prevSunday = $lastdateFormate->copy()->previous(Carbon::SUNDAY);
                    $day1 = Carbon::parse($prevSunday)->format('d');
                    $month1 = $prevSunday->format('F');

                    $numberWords = [
                        '1' => 'one',
                        '2' => 'two',
                        '3' => 'three',
                        '4' => 'four',
                        '5' => 'five',
                        '6' => 'six',
                        '7' => 'seven',
                        '8' => 'eight',
                        '9' => 'nine',
                        '10' => 'ten',
                        '11' => 'eleven',
                        '12' => 'twelve',
                        '13' => 'thirteen',
                        '14' => 'fourteen',
                        '15' => 'fifteen',
                        '16' => 'sixteen',
                        '17' => 'seventeen',
                        '18' => 'eighteen',
                        '19' => 'nineteen',
                        '20' => 'twenty',
                        '21' => 'twentyone',
                        '22' => 'twentytwo',
                        '23' => 'twentythree',
                        '24' => 'twentyfour',
                        '25' => 'twentyfive',
                        '26' => 'twentysix',
                        '27' => 'twentyseven',
                        '28' => 'twentyeight',
                        '29' => 'twentynine',
                        '30' => 'thirty',
                        '31' => 'thirtyone'
                    ];

                    $dayWord = $numberWords[(int)$day1];
                    if (!in_array($prevSunday, $retrievedDates)) {
                        $getdateformated = $prevSunday->format('Y-m-d');
                        $getholidaysss = DB::table('holidays')
                            ->where('startdate', '=', $getdateformated)
                            ->orWhere('enddate', '=', $getdateformated)
                            ->first();

                        if ($getholidaysss != null) {
                            $updateddata = 'H';
                        } else {
                            $updateddata = 'W';
                        }

                        $totalCountMapping = [
                            'P' => 'no_of_days_present',
                            'CL' => 'casual_leave',
                            'EL' => 'exam_leave',
                            'T' => 'travel',
                            'OH' => 'offholidays',
                            'W' => 'sundaycount',
                            'H' => 'holidays'
                        ];

                        $prevcheck = DB::table('attendances')
                            ->where('employee_name', auth()->user()->teammember_id)
                            ->where('month', $month1)
                            ->whereNotNull($dayWord)
                            ->first();

                        if ($prevcheck == null) {

                            // DB::table('attendances')
                            //     ->where('employee_name', auth()->user()->teammember_id)
                            //     ->where('month', $month1)
                            //     ->update([$dayWord => $updateddata]);

                            // Update the total count and attendance record if applicable
                            if (isset($totalCountMapping[$updateddata])) {
                                $totalcountColumn = $totalCountMapping[$updateddata];
                                $totalcountupdate = $attendances->$totalcountColumn + 1;
                                // DB::table('attendances')
                                //     ->where('id', $attendances->id)
                                //     ->update([
                                //         $dayWord => $updateddata,
                                //         $totalcountColumn => $totalcountupdate,
                                //     ]);
                                DB::table('attendances')
                                    ->where('employee_name', auth()->user()->teammember_id)
                                    ->where('month', $month1)
                                    ->update([
                                        $dayWord => $updateddata,
                                        $totalcountColumn => $totalcountupdate,
                                    ]);
                            }
                        }
                    }
                    // update sunday data in attendance end hare
                }

                $output = array('msg' => "Timesheet Submit Successfully till " . Carbon::createFromFormat('Y-m-d', $previousMondayFormatted)->format('d-m-Y') . " to " . Carbon::createFromFormat('Y-m-d', $nextSaturdayFormatted)->format('d-m-Y'));
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
{{--  --}}
{{--  --}}
{{-- Route::get('/portfolio-details', function () {
    return view('web.pages.portfolio-details');
});
Route::get('/index-page', function () {
    return view('web.pages.index');
});
Route::get('/service-details', function () {
    return view('web.pages.service-details');
});
Route::get('/starter-page', function () {
    return view('web.pages.starter-page');
}); --}}
{{--  --}}
   <!-- Custom CSS -->
   <link href="{{ asset('web/css/index.css') }}" rel="stylesheet">
   <script src="{{ asset('web/js/index.js') }}"></script>
   <img src="{{ asset($blog->preview_image) }}"class="img-fluid " alt="..."></a>
   <!--responsive css -->
   <link href="{{ asset('web/css/responsive.css') }}" rel="stylesheet">
{{--  --}}

public function timesheetsubmission(Request $request)
{
    try {


        // $nextweektimesheet1 = DB::table('timesheetusers')
        //     ->where('createdby', 847)
        //     ->whereBetween('date', ['2024-07-22', '2024-08-10'])
        //     // ->get();
        //     ->update(['status' => 0]);


        // $nextweektimesheet2 = DB::table('timesheets')
        //     ->where('created_by', 847)
        //     ->whereBetween('date', ['2024-07-22', '2024-08-10'])
        //     // ->get();
        //     ->update(['status' => 0]);
        // // more than one week delete 
        // $result = ['2024-07-22', '2024-07-29'];
        // foreach ($result as $date) {
        //     $nextweektimesheet3 = DB::table('timesheetreport')
        //         ->where('teamid', 847)
        //         ->where('startdate', $date)
        //         // ->get();
        //         ->delete();
        // }
        // dd('hi');

        // 22222222222222






        $checksavetimesheet = DB::table('timesheetusers')
            ->where('createdby', auth()->user()->teammember_id)
            ->where('status', 0)
            ->first();

        if ($checksavetimesheet == null) {
            $output = array('msg' => "You have not saved any timesheets. Please save your timesheet.");
            return back()->with('statuss', $output);
        }

        $latesttimesheetreport =  DB::table('timesheetreport')
            ->where('teamid', auth()->user()->teammember_id)
            ->orderBy('id', 'desc')
            ->first();

        // $latesttimesheetreport is not null 
        if ($latesttimesheetreport !== null) {
            // dd('hi 1');
            $timesheetreportenddate = Carbon::parse($latesttimesheetreport->enddate);

            // find next sturday 
            $nextSaturday = $timesheetreportenddate->copy()->next(Carbon::SATURDAY);
            $formattedNextSaturday = $nextSaturday->format('Y-m-d');
            $formattedNextSaturday1 = $timesheetreportenddate->format('d-m-Y');

            // find next week timesheet filled or not 
            $nextweektimesheet = DB::table('timesheetusers')
                ->where('createdby', auth()->user()->teammember_id)
                ->whereIn('status', [0, 1])
                ->where('date', $formattedNextSaturday)
                ->first();

            // Fetch the rejoining data
            $rejoiningcheck = DB::table('teammembers')
                ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
                ->leftJoin('rejoiningsamepost', 'rejoiningsamepost.teammember_id', '=', 'teammembers.id')
                ->where('teammembers.id', auth()->user()->teammember_id)
                ->select(
                    'teammembers.team_member',
                    'teammembers.staffcode',
                    'teammembers.joining_date',
                    'teamrolehistory.newstaff_code',
                    'teamrolehistory.rejoiningdate',
                    'rejoiningsamepost.rejoiningdate as samepostrejoiningdate'
                )
                ->first();


            // Initialize the variable
            $rejoiningchecktimesheet = null;

            // Check if any rejoining date is set
            $rejoiningDate = $rejoiningcheck->rejoiningdate ?? $rejoiningcheck->samepostrejoiningdate;

            // Check if the rejoining date is set
            if ($rejoiningDate) {
                $rejoining = Carbon::parse($rejoiningDate);
                $nextweek = Carbon::parse($formattedNextSaturday);

                // Check if the rejoining date is before next week's Saturday
                if ($rejoining < $nextweek) {
                    $rejoiningchecktimesheet = DB::table('timesheetusers')
                        ->where('createdby', auth()->user()->teammember_id)
                        ->whereIn('status', [0, 1])
                        ->where('date', $formattedNextSaturday)
                        ->first();
                }
            }

            // Determine the next week's timesheet status


            if ($nextweektimesheet == null && $rejoiningchecktimesheet == null && $rejoiningDate == null) {
                $output = array('msg' => "Fill the Week timesheet After this week: $formattedNextSaturday1");
                return back()->with('statuss', $output);
            } else {
                $usertimesheetfirstdate =  DB::table('timesheets')
                    ->where('status', '0')
                    ->where('created_by', auth()->user()->teammember_id)->orderBy('date', 'ASC')->first();

                $lastdate = Carbon::createFromFormat('Y-m-d', $usertimesheetfirstdate->date ?? '')->addDays(6);

                if ($usertimesheetfirstdate) {

                    $firstDate = new DateTime($usertimesheetfirstdate->date);
                    $dayOfWeek = $firstDate->format('w');
                    $daysToAdd = 0;

                    if ($dayOfWeek !== '0') {
                        $daysToAdd = 7 - $dayOfWeek;
                    } else {
                        $output = array('msg' => 'Submit the timesheet from Monday to Sunday.');
                        return back()->with('success', $output);
                    }

                    if ($dayOfWeek > 0) {
                        $daysToSubtract = $dayOfWeek - 1;
                    } else {
                        $daysToSubtract = $dayOfWeek;
                    }

                    $upcomingSunday = (new DateTime($firstDate->format('Y-m-d')))->modify("+$daysToAdd days")->format('Y-m-d');

                    $presentWeekMonday = (new DateTime($firstDate->format('Y-m-d')))->modify("-$daysToSubtract days")->format('Y-m-d');
                }

                $get_six_Data = DB::table('timesheetusers')
                    ->where('status', '0')
                    ->where('createdby', auth()->user()->teammember_id)
                    ->whereBetween('date', [$firstDate->format('Y-m-d'), $upcomingSunday])
                    ->orderBy('date', 'ASC')
                    ->get();



                $lastdate = $get_six_Data->max('date');



                //copy dates in retrievedDates array in datetime format
                $retrievedDates = [];

                foreach ($get_six_Data as $entry) {
                    $date = new DateTime($entry->date);
                    $retrievedDates[] = $date->format('Y-m-d');
                }

                $expectedDates = [];   // will contain ALL the dates occurs b/w first day to upcoming sunday
                $firstDate = new DateTime($presentWeekMonday);
                $upcomingSundayDate = new DateTime($upcomingSunday);

                // Clone $firstDate so that it is not modified
                $currentDate = clone $firstDate;

                while ($currentDate->format('Y-m-d') < $upcomingSundayDate->format('Y-m-d')) {  //excluding sunday
                    $expectedDates[] = $currentDate->format('Y-m-d');


                    $currentDate->modify("+1 day");
                }

                $missingDates = array_diff($expectedDates, $retrievedDates);

                if (!empty($missingDates)) {
                    $missingDatesString = implode(', ', $missingDates);
                    $output = array('msg' => "Timesheet Submit Failed Missing dates: $missingDatesString");
                    return back()->with('success', $output);
                } else {
                    foreach ($get_six_Data as $getsixdata) {

                        // Convert the requested date to a Carbon instance
                        $requestedDate = Carbon::createFromFormat('Y-m-d', $getsixdata->date);

                        if (date('l', strtotime(date('d-m-Y', strtotime($getsixdata->date)))) == 'Monday') {
                            $previousMonday = $requestedDate->copy()->previous(Carbon::MONDAY);

                            // Find the nearest next Saturday to the requested date
                            $nextSaturday = $requestedDate->copy()->next(Carbon::SATURDAY);

                            // Format the dates in 'Y-m-d' format
                            $previousMondayFormatted = $getsixdata->date;
                            $nextSaturdayFormatted = $nextSaturday->format('Y-m-d');
                            $nextSaturdayFormatted = $lastdate;


                            $week =  date('d-m-Y', strtotime($previousMondayFormatted))  . ' to ' . date('d-m-Y', strtotime($nextSaturdayFormatted));
                            $co = DB::table('timesheetusers')
                                ->where('createdby', auth()->user()->teammember_id)
                                ->whereBetween('date', [$previousMondayFormatted, $nextSaturdayFormatted])
                                ->select('partner', DB::raw('SUM(hour) as total_hours'), DB::raw('COUNT(DISTINCT timesheetid) as row_count'))
                                ->groupBy('partner')
                                ->get();

                            foreach ($co as $codata) {
                                DB::table('timesheetreport')->insert([
                                    'teamid'       =>     auth()->user()->teammember_id,
                                    'week'       =>     $week,
                                    'totaldays'       =>     $codata->row_count,
                                    'totaltime' =>  $codata->total_hours,
                                    'partnerid'  => $codata->partner,
                                    'startdate'  => $previousMondayFormatted,
                                    'enddate'  => $nextSaturdayFormatted,
                                    // 'created_at'                =>       date('y-m-d'),
                                    'created_at'                =>      date('y-m-d H:i:s'),
                                ]);
                            }

                            $totaldays = DB::table('timesheetusers')
                                ->where('createdby', auth()->user()->teammember_id)
                                ->whereBetween('date', [$previousMondayFormatted, $nextSaturdayFormatted])
                                ->select('date')
                                ->groupBy('date')
                                ->get();

                            $totaldaysCount = $totaldays->count();
                            $latesttimesheetreport = DB::table('timesheetreport')
                                ->where('teamid', auth()->user()->teammember_id)
                                ->where('startdate', $previousMondayFormatted)
                                ->first();

                            if ($latesttimesheetreport) {
                                DB::table('timesheetreport')
                                    ->where('id', $latesttimesheetreport->id)
                                    ->update(['dayscount' => $totaldaysCount]);
                            }
                        }

                        DB::table('timesheetusers')->where('timesheetid', $getsixdata->timesheetid)->update([
                            'status'         =>     1,
                            'updated_at'              =>    date('y-m-d'),
                        ]);
                        DB::table('timesheets')->where('id', $getsixdata->timesheetid)->update([
                            'status'         =>     1,
                            'updated_at'              =>    date('y-m-d'),
                        ]);

                        // Attendance code start hare 
                        $hdatess = Carbon::parse($getsixdata->date)->format('Y-m-d');
                        $day = Carbon::parse($hdatess)->format('d');
                        $month = Carbon::parse($hdatess)->format('F');
                        $yeardata = Carbon::parse($hdatess)->format('Y');

                        $dates = [
                            '26' => 'twentysix',
                            '27' => 'twentyseven',
                            '28' => 'twentyeight',
                            '29' => 'twentynine',
                            '30' => 'thirty',
                            '31' => 'thirtyone',
                            '01' => 'one',
                            '02' => 'two',
                            '03' => 'three',
                            '04' => 'four',
                            '05' => 'five',
                            '06' => 'six',
                            '07' => 'seven',
                            '08' => 'eight',
                            '09' => 'nine',
                            '10' => 'ten',
                            '11' => 'eleven',
                            '12' => 'twelve',
                            '13' => 'thirteen',
                            '14' => 'fourteen',
                            '15' => 'fifteen',
                            '16' => 'sixteen',
                            '17' => 'seventeen',
                            '18' => 'eighteen',
                            '19' => 'ninghteen',
                            '20' => 'twenty',
                            '21' => 'twentyone',
                            '22' => 'twentytwo',
                            '23' => 'twentythree',
                            '24' => 'twentyfour',
                            '25' => 'twentyfive',
                        ];

                        $column = $dates[$day];
                        // check attendenace record exist or not 
                        $attendances = DB::table('attendances')
                            ->where('employee_name', auth()->user()->teammember_id)
                            ->where('month', $month)
                            ->first();

                        if ($attendances == null) {
                            $teammember = DB::table('teammembers')->where('id', auth()->user()->teammember_id)->first();
                            DB::table('attendances')->insert([
                                'employee_name' => $teammember->id,
                                'month' => $month,
                                'year' => $yeardata,
                                'dateofjoining' => $teammember->joining_date,
                                'fulldate' => date('Y-m-d'),
                                'created_at' => date('Y-m-d H:i:s'),
                                'updated_at' => date('Y-m-d H:i:s'),
                            ]);
                        }

                        $attendances = DB::table('attendances')
                            ->where('employee_name', auth()->user()->teammember_id)
                            ->where('month', $month)
                            ->first();

                        if ($attendances != null && property_exists($attendances, $column)) {

                            $client = $getsixdata->client_id;
                            $assignmentid = $getsixdata->assignment_id;

                            $updatewording = match (true) {
                                // Travel
                                $client == 32 => 'T',
                                // Off holidays
                                $client == 33 && str_replace(['1st ', '2nd ', '3rd ', '4th ', '5th '], '', $request->workitem) == 'Saturday' => 'OH',
                                // Other holidays from calendar
                                $client == 33 => 'H',
                                // Casual leave
                                $client == 134 && $assignmentid == 215 => 'CL',
                                // Exam leave
                                $client == 134 && $assignmentid == 214 => 'EL',
                                    // Default presence
                                default => 'P',
                            };
                        }

                        $totalCountMapping = [
                            'P' => 'no_of_days_present',
                            'CL' => 'casual_leave',
                            'EL' => 'exam_leave',
                            'T' => 'travel',
                            'OH' => 'offholidays',
                            'W' => 'sundaycount',
                            'H' => 'holidays'
                        ];

                        // Update the total count and attendance record if applicable
                        if (isset($totalCountMapping[$updatewording])) {
                            $totalcountColumn = $totalCountMapping[$updatewording];
                            $totalcountupdate = $attendances->$totalcountColumn + 1;

                            DB::table('attendances')
                                ->where('id', $attendances->id)
                                ->update([
                                    $column => $updatewording,
                                    $totalcountColumn => $totalcountupdate,
                                ]);
                        }
                        // Attendance code end hare  
                    }


                    // update sunday data in attendance
                    $lastdateFormate = Carbon::createFromFormat('Y-m-d', $lastdate);
                    $prevSunday = $lastdateFormate->copy()->previous(Carbon::SUNDAY);
                    $day1 = Carbon::parse($prevSunday)->format('d');
                    $month1 = $prevSunday->format('F');

                    $numberWords = [
                        '1' => 'one',
                        '2' => 'two',
                        '3' => 'three',
                        '4' => 'four',
                        '5' => 'five',
                        '6' => 'six',
                        '7' => 'seven',
                        '8' => 'eight',
                        '9' => 'nine',
                        '10' => 'ten',
                        '11' => 'eleven',
                        '12' => 'twelve',
                        '13' => 'thirteen',
                        '14' => 'fourteen',
                        '15' => 'fifteen',
                        '16' => 'sixteen',
                        '17' => 'seventeen',
                        '18' => 'eighteen',
                        '19' => 'nineteen',
                        '20' => 'twenty',
                        '21' => 'twentyone',
                        '22' => 'twentytwo',
                        '23' => 'twentythree',
                        '24' => 'twentyfour',
                        '25' => 'twentyfive',
                        '26' => 'twentysix',
                        '27' => 'twentyseven',
                        '28' => 'twentyeight',
                        '29' => 'twentynine',
                        '30' => 'thirty',
                        '31' => 'thirtyone'
                    ];

                    $dayWord = $numberWords[(int)$day1];
                    if (!in_array($prevSunday, $retrievedDates)) {
                        $getdateformated = $prevSunday->format('Y-m-d');
                        $getholidaysss = DB::table('holidays')
                            ->where('startdate', '=', $getdateformated)
                            ->orWhere('enddate', '=', $getdateformated)
                            ->first();

                        if ($getholidaysss != null) {
                            $updateddata = 'H';
                        } else {
                            $updateddata = 'W';
                        }
                        $prevcheck = DB::table('attendances')
                            ->where('employee_name', auth()->user()->teammember_id)
                            ->where('month', $month1)
                            ->whereNotNull($dayWord)
                            ->first();

                        if ($prevcheck == null) {
                            DB::table('attendances')
                                ->where('employee_name', auth()->user()->teammember_id)
                                ->where('month', $month1)
                                ->update([$dayWord => $updateddata]);
                        }
                    }
                    // update sunday data in attendance end hare
                }
                $output = array('msg' => "Timesheet Submit Successfully till " . Carbon::createFromFormat('Y-m-d', $previousMondayFormatted)->format('d-m-Y') . " to " . Carbon::createFromFormat('Y-m-d', $nextSaturdayFormatted)->format('d-m-Y'));
                return back()->with('success', $output);
            }
        } else {
            dd('hi 2');
            $usertimesheetfirstdate =  DB::table('timesheets')
                ->where('status', '0')
                ->where('created_by', auth()->user()->teammember_id)->orderBy('date', 'ASC')->first();
            $lastdate = Carbon::createFromFormat('Y-m-d', $usertimesheetfirstdate->date ?? '')->addDays(6);

            if ($usertimesheetfirstdate) {
                $firstDate = new DateTime($usertimesheetfirstdate->date);
                $dayOfWeek = $firstDate->format('w');
                $daysToAdd = 0;

                if ($dayOfWeek !== '0') {
                    $daysToAdd = 7 - $dayOfWeek;
                } else {
                    $output = array('msg' => 'Submit the timesheet from Monday to Sunday.');
                    return back()->with('success', $output);
                }

                if ($dayOfWeek > 0) {
                    $daysToSubtract = $dayOfWeek - 1;
                } else {
                    $daysToSubtract = $dayOfWeek;
                }

                $upcomingSunday = (new DateTime($firstDate->format('Y-m-d')))->modify("+$daysToAdd days")->format('Y-m-d');

                $presentWeekMonday = (new DateTime($firstDate->format('Y-m-d')))->modify("-$daysToSubtract days")->format('Y-m-d');
            }


            // $get_six_Data = DB::table('timesheets')
            //     ->where('status', '0')
            //     ->where('created_by', auth()->user()->teammember_id)
            //     ->whereBetween('date', [$firstDate->format('Y-m-d'), $upcomingSunday])
            //     ->orderBy('date', 'ASC')
            //     ->get();


            $get_six_Data = DB::table('timesheetusers')
                ->where('status', '0')
                ->where('createdby', auth()->user()->teammember_id)
                ->whereBetween('date', [$firstDate->format('Y-m-d'), $upcomingSunday])
                ->orderBy('date', 'ASC')
                ->get();


            $lastdate = $get_six_Data->max('date');

            $retrievedDates = [];   //copy dates in retrievedDates array in datetime format

            foreach ($get_six_Data as $entry) {
                $date = new DateTime($entry->date);
                $retrievedDates[] = $date->format('Y-m-d');
            }

            $expectedDates = [];   // will contain ALL the dates occurs b/w first day to upcoming sunday
            $firstDate = new DateTime($presentWeekMonday);
            $upcomingSundayDate = new DateTime($upcomingSunday);
            // Clone $firstDate so that it is not modified
            $currentDate = clone $firstDate;

            while ($currentDate->format('Y-m-d') < $upcomingSundayDate->format('Y-m-d')) {  //excluding sunday
                $expectedDates[] = $currentDate->format('Y-m-d');
                $currentDate->modify("+1 day");
            }

            $missingDates = array_diff($expectedDates, $retrievedDates);

            if (!empty($missingDates)) {
                $missingDatesString = implode(', ', $missingDates);
                $output = array('msg' => "Timesheet Submit Failed Missing dates: $missingDatesString");
                return back()->with('success', $output);
            } else {
                foreach ($get_six_Data as $getsixdata) {
                    // Convert the requested date to a Carbon instance
                    $requestedDate = Carbon::createFromFormat('Y-m-d', $getsixdata->date);

                    if (date('l', strtotime(date('d-m-Y', strtotime($getsixdata->date)))) == 'Monday') {
                        $previousMonday = $requestedDate->copy()->previous(Carbon::MONDAY);
                        // Find the nearest next Saturday to the requested date
                        $nextSaturday = $requestedDate->copy()->next(Carbon::SATURDAY);
                        // Format the dates in 'Y-m-d' format
                        $previousMondayFormatted = $getsixdata->date;
                        $nextSaturdayFormatted = $nextSaturday->format('Y-m-d');
                        $nextSaturdayFormatted = $lastdate;

                        $week =  date('d-m-Y', strtotime($previousMondayFormatted))  . ' to ' . date('d-m-Y', strtotime($nextSaturdayFormatted));
                        $co = DB::table('timesheetusers')
                            ->where('createdby', auth()->user()->teammember_id)
                            ->whereBetween('date', [$previousMondayFormatted, $nextSaturdayFormatted])
                            ->select('partner', DB::raw('SUM(hour) as total_hours'), DB::raw('COUNT(DISTINCT timesheetid) as row_count'))
                            ->groupBy('partner')
                            ->get();

                        foreach ($co as $codata) {
                            DB::table('timesheetreport')->insert([
                                'teamid'       =>     auth()->user()->teammember_id,
                                'week'       =>     $week,
                                'totaldays'       =>     $codata->row_count,
                                'totaltime' =>  $codata->total_hours,
                                'partnerid'  => $codata->partner,
                                'startdate'  => $previousMondayFormatted,
                                'enddate'  => $nextSaturdayFormatted,
                                // 'created_at'                =>       date('y-m-d'),
                                'created_at'                =>      date('y-m-d H:i:s'),
                            ]);
                        }

                        $totaldays = DB::table('timesheetusers')
                            ->where('createdby', auth()->user()->teammember_id)
                            ->whereBetween('date', [$previousMondayFormatted, $nextSaturdayFormatted])
                            ->select('date')
                            ->groupBy('date')
                            ->get();

                        $totaldaysCount = $totaldays->count();
                        $latesttimesheetreport = DB::table('timesheetreport')
                            ->where('teamid', auth()->user()->teammember_id)
                            ->where('startdate', $previousMondayFormatted)
                            ->first();

                        if ($latesttimesheetreport) {
                            DB::table('timesheetreport')
                                ->where('id', $latesttimesheetreport->id)
                                ->update(['dayscount' => $totaldaysCount]);
                        }
                    }

                    // DB::table('timesheetusers')->where('timesheetid', $getsixdata->id)->update([
                    //     'status'         =>     1,
                    //     'updated_at'              =>    date('y-m-d'),
                    // ]);
                    // DB::table('timesheets')->where('id', $getsixdata->id)->update([
                    //     'status'         =>     1,
                    //     'updated_at'              =>    date('y-m-d'),
                    // ]);

                    DB::table('timesheetusers')->where('timesheetid', $getsixdata->timesheetid)->update([
                        'status'         =>     1,
                        'updated_at'              =>    date('y-m-d'),
                    ]);
                    DB::table('timesheets')->where('id', $getsixdata->timesheetid)->update([
                        'status'         =>     1,
                        'updated_at'              =>    date('y-m-d'),
                    ]);

                    // Attendance code start hare 
                    $hdatess = Carbon::parse($getsixdata->date)->format('Y-m-d');
                    $day = Carbon::parse($hdatess)->format('d');
                    $month = Carbon::parse($hdatess)->format('F');
                    $yeardata = Carbon::parse($hdatess)->format('Y');
                    $currentDate = now();
                    $currentMonth = $currentDate->format('F');

                    $dates = [
                        '26' => 'twentysix',
                        '27' => 'twentyseven',
                        '28' => 'twentyeight',
                        '29' => 'twentynine',
                        '30' => 'thirty',
                        '31' => 'thirtyone',
                        '01' => 'one',
                        '02' => 'two',
                        '03' => 'three',
                        '04' => 'four',
                        '05' => 'five',
                        '06' => 'six',
                        '07' => 'seven',
                        '08' => 'eight',
                        '09' => 'nine',
                        '10' => 'ten',
                        '11' => 'eleven',
                        '12' => 'twelve',
                        '13' => 'thirteen',
                        '14' => 'fourteen',
                        '15' => 'fifteen',
                        '16' => 'sixteen',
                        '17' => 'seventeen',
                        '18' => 'eighteen',
                        '19' => 'ninghteen',
                        '20' => 'twenty',
                        '21' => 'twentyone',
                        '22' => 'twentytwo',
                        '23' => 'twentythree',
                        '24' => 'twentyfour',
                        '25' => 'twentyfive',
                    ];

                    // if ($month != $currentMonth && $day > 25) {
                    //     $dateTime = Carbon::createFromFormat('Y-m-d', $hdatess)->addMonth();
                    //     $month = $dateTime->format('F');
                    // } elseif ($month != $currentMonth && $day < 25) {
                    //     $dateTime = Carbon::createFromFormat('Y-m-d', $hdatess);
                    //     $month = $dateTime->format('F');
                    // } elseif ($month == $currentMonth && $day > 25) {
                    //     $dateTime = Carbon::createFromFormat('Y-m-d', $hdatess)->addMonth();
                    //     $month = $dateTime->format('F');
                    // }

                    $column = $dates[$day];
                    // check attendenace record exist or not 
                    $attendances = DB::table('attendances')
                        ->where('employee_name', auth()->user()->teammember_id)
                        ->where('month', $month)
                        ->first();

                    if ($attendances == null) {
                        $teammember = DB::table('teammembers')->where('id', auth()->user()->teammember_id)->first();
                        DB::table('attendances')->insert([
                            'employee_name' => $teammember->id,
                            'month' => $month,
                            'year' => $yeardata,
                            'dateofjoining' => $teammember->joining_date,
                            'fulldate' => date('Y-m-d'),
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s'),
                        ]);
                    }

                    if ($attendances != null && property_exists($attendances, $column)) {
                        $client = $getsixdata->client_id;
                        $assignmentid = $getsixdata->assignment_id;

                        if ($client == 32) {
                            // Travel
                            $updatewording = 'T';
                        } elseif ($client == 33) {
                            // Assume this is "1th Saturday or 2ndh Saturday or 3rd Saturday or 4th Saturday"
                            $workitem = $getsixdata->workitem;
                            $workitem = str_replace(['1st ', '2nd ', '3rd ', '4th ', '5th '], '', $workitem);
                            // Now $workitem should be "Saturday"
                            if ($workitem == 'Saturday') {
                                // Off holidays only select Saturdays
                                $updatewording = 'OH';
                            } else {
                                // holidays from calaneder
                                $updatewording = 'H';
                            }
                        } elseif ($client == 134) {
                            // casual leave
                            $updatewording = 'CL';
                        } else {
                            // Default case
                            $updatewording = 'P';
                        }
                    } else {

                        $client = $getsixdata->client_id;
                        $assignmentid = $getsixdata->client_id;

                        if ($client == 32) {
                            // Travel
                            $updatewording = 'T';
                        } elseif ($client == 33) {
                            // Assume this is "1th Saturday or 2ndh Saturday or 3rd Saturday or 4th Saturday"
                            $workitem = $getsixdata->workitem;
                            $workitem = str_replace(['1st ', '2nd ', '3rd ', '4th ', '5th '], '', $workitem);
                            // Now $workitem should be "Saturday"
                            if ($workitem == 'Saturday') {
                                // Off holidays only select Saturdays
                                $updatewording = 'OH';
                            } else {
                                // holidays from calaneder
                                $updatewording = 'H';
                            }
                        } elseif ($client == 134) {
                            // casual leave
                            $updatewording = 'CL';
                        } else {
                            // Default case
                            $updatewording = 'P';
                        }
                    }

                    DB::table('attendances')
                        ->where('employee_name', auth()->user()->teammember_id)
                        ->where('month', $month)
                        ->update([$column => $updatewording]);
                    // Attendance code end hare 
                }

                // update sunday data in attendance
                $lastdateFormate = Carbon::createFromFormat('Y-m-d', $lastdate);
                $prevSunday = $lastdateFormate->copy()->previous(Carbon::SUNDAY);
                $day1 = Carbon::parse($prevSunday)->format('d');
                $month1 = $prevSunday->format('F');

                $numberWords = [
                    '1' => 'one',
                    '2' => 'two',
                    '3' => 'three',
                    '4' => 'four',
                    '5' => 'five',
                    '6' => 'six',
                    '7' => 'seven',
                    '8' => 'eight',
                    '9' => 'nine',
                    '10' => 'ten',
                    '11' => 'eleven',
                    '12' => 'twelve',
                    '13' => 'thirteen',
                    '14' => 'fourteen',
                    '15' => 'fifteen',
                    '16' => 'sixteen',
                    '17' => 'seventeen',
                    '18' => 'eighteen',
                    '19' => 'nineteen',
                    '20' => 'twenty',
                    '21' => 'twentyone',
                    '22' => 'twentytwo',
                    '23' => 'twentythree',
                    '24' => 'twentyfour',
                    '25' => 'twentyfive',
                    '26' => 'twentysix',
                    '27' => 'twentyseven',
                    '28' => 'twentyeight',
                    '29' => 'twentynine',
                    '30' => 'thirty',
                    '31' => 'thirtyone'
                ];

                $dayWord = $numberWords[(int)$day1];
                if (!in_array($prevSunday, $retrievedDates)) {
                    $getdateformated = $prevSunday->format('Y-m-d');
                    $getholidaysss = DB::table('holidays')
                        ->where('startdate', '=', $getdateformated)
                        ->orWhere('enddate', '=', $getdateformated)
                        ->first();

                    if ($getholidaysss != null) {
                        $updateddata = 'H';
                    } else {
                        $updateddata = 'W';
                    }
                    $prevcheck = DB::table('attendances')
                        ->where('employee_name', auth()->user()->teammember_id)
                        ->where('month', $month1)
                        ->whereNotNull($dayWord)
                        ->first();

                    if ($prevcheck == null) {
                        DB::table('attendances')
                            ->where('employee_name', auth()->user()->teammember_id)
                            ->where('month', $month1)
                            ->update([$dayWord => $updateddata]);
                    }
                }
                // update sunday data in attendance end hare
            }

            $output = array('msg' => "Timesheet Submit Successfully till " . Carbon::createFromFormat('Y-m-d', $previousMondayFormatted)->format('d-m-Y') . " to " . Carbon::createFromFormat('Y-m-d', $nextSaturdayFormatted)->format('d-m-Y'));
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
{{--  --}}
{{--  --}}
{{--  --}}

if (isset($totalCountMapping[$updatewording])) {
    $totalcountColumn = $totalCountMapping[$updatewording];
    $totalcountupdate = isset($attendances->$totalcountColumn) ? $attendances->$totalcountColumn + 1 : 1;

    DB::table('attendances')
        ->where('id', $attendances->id)
        ->update([
            $column => $updatewording,
            $totalcountColumn => $totalcountupdate,
        ]);
}
 $updatewording = match (true) {
                                        // Travel
                                        $client == 32 => 'T',
                                        // Off holidays
                                        $client == 33 && str_replace(['1st ', '2nd ', '3rd ', '4th ', '5th '], '', $request->workitem) == 'Saturday' => 'OH',
                                        // Other holidays from calendar
                                        $client == 33 => 'H',
                                        // Casual leave
                                        $client == 134 && $assignmentid == 215 => 'CL',
                                        // Exam leave
                                        $client == 134 && $assignmentid == 214 => 'EL',
                                            // Default presence
                                        default => 'P',
                                    };

  if (is_numeric($request->assignment_id)) {
        $getassignmentgenerateId = DB::table('timesheetusers')->where('id', $request->timesheetusersid)->first();
        $assignmentgenerateId = $getassignmentgenerateId->assignmentgenerate_id;
        $request->assignment_id = $assignmentgenerateId;
        dd($assignmentgenerateId, 1);
      }
      dd($request->assignment_id, 2);

      // if (!is_numeric($request->assignment_id)) {

      dd($request->assignment_id);

{{--  --}}
{{-- PAo005pJo9fuFkl2TWFEI2PdAbpr72WSimuFBpUzylGhVggL5FNY4RfZb6j0
resources\views\errors\419.blade.php
resources\views\auth\login.blade.php
vendor\laravel\ui\auth-backend\AuthenticatesUsers.php
app\Http\Controllers\Auth\LoginController.php
resources\views\auth\twoFactor.blade.php
app\Http\Controllers\Auth\TwoFactorController.php
Route::resource('verify', TwoFactorController::class)->only(['index', 'store']); --}}
{{-- attendance   --}}
{{--  --}}
@php
    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'client_id' => 'required',
        'assignment_id' => 'required',
        'partner' => 'required',
        'workitem' => 'required',
        'billable_status' => 'required',
        'hour' => 'required',
        'createdby' => 'required',
    ]);

    if ($validator->fails()) {
        $response['msg'] = $validator->errors();
        $response['status'] = 0;

        return $response;
    }
    try {
        $data = $request->except(['_token']);

        $leaves = DB::table('applyleaves')
            ->where('applyleaves.createdby', $request->createdby)
            ->where('status', '!=', 2)
            ->select('applyleaves.from', 'applyleaves.to')
            ->get();

        $leavess = [];
        foreach ($leaves as $leave) {
            $days = Carbon::parse($leave->from)->range(Carbon::parse($leave->to))->toArray();
            $leavess = array_merge($leavess, $days);
        }

        $currentday = Carbon::parse($request->date)->format('Y-m-d');

        if (in_array($currentday, $leavess)) {
            $output = array('msg' => 'You Have Leave for the Day (' . date('d-m-Y', strtotime($currentday)) . ')');
            return response()->json($output, 400);
        }

        $mytime = Carbon::now();
        $currentdate = $mytime->toDateString();
		//dd($currentday);

        if ($currentday > $currentdate) {
		
			 $output = array('msg' => 'You Can Not Fill Timesheet For Future Date (' . date('d-m-Y', strtotime($currentday)) . ')');
            
			return response()->json($output, 400);
        }

        $timesheet = DB::table('timesheets')->insertGetId([
            'created_by' => $request->createdby,
            'month' => Carbon::parse($request->date)->format('F'),
            'date' => Carbon::parse($request->date)->format('Y-m-d'),
            'created_at' => now(),
        ]);

        $count = count($request->assignment_id);

        for ($i = 0; $i < $count; $i++) {
            $assignment = DB::table('assignmentmappings')->where('assignmentgenerate_id', $request->assignment_id[$i])->first();

            DB::table('timesheetusers')->insert([
                'date' => $request->date,
                'client_id' => $request->client_id[$i],
                'workitem' => $request->workitem[$i],
                'billable_status' => $request->billable_status[$i],
                'timesheetid' => $timesheet,
                'date' => Carbon::parse($request->date)->format('d-m-Y'),
                'hour' => $request->hour[$i],
                'totalhour' => $request->totalhour,
                'assignment_id' => $assignment->assignment_id,
                'partner' => $request->partner[$i],
                'createdby' => $request->createdby,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Check if total hours exceed 24
        if ($request->totalhour > 24) {
            $output = array('msg' => 'Total hours cannot exceed 24 hours.');
            return response()->json($output, 400);
        }

        $hdatess = Carbon::parse($request->date)->format('Y-m-d');
        $day = Carbon::parse($hdatess)->format('d');
        $month = Carbon::parse($hdatess)->format('F');
        $currentDate = now();
        $currentMonth = $currentDate->format('F');

        $dates = [
            '26' => 'twentysix',
            '27' => 'twentyseven',
            '28' => 'twentyeight',
            '29' => 'twentynine',
            '30' => 'thirty',
            '31' => 'thirtyone',
            '01' => 'one',
            '02' => 'two',
            '03' => 'three',
            '04' => 'four',
            '05' => 'five',
            '06' => 'six',
            '07' => 'seven',
            '08' => 'eight',
            '09' => 'nine',
            '10' => 'ten',
            '11' => 'eleven',
            '12' => 'twelve',
            '13' => 'thirteen',
            '14' => 'fourteen',
            '15' => 'fifteen',
            '16' => 'sixteen',
            '17' => 'seventeen',
            '18' => 'eighteen',
            '19' => 'ninghteen',
            '20' => 'twenty',
            '21' => 'twentyone',
            '22' => 'twentytwo',
            '23' => 'twentythree',
            '24' => 'twentyfour',
            '25' => 'twentyfive',
        ];

        if ($month != $currentMonth && $day > 25) {
            $dateTime = Carbon::createFromFormat('Y-m-d', $hdatess)->addMonth();
            $month = $dateTime->format('F');
        } elseif ($month != $currentMonth && $day < 25) {
            $dateTime = Carbon::createFromFormat('Y-m-d', $hdatess);
            $month = $dateTime->format('F');
        } elseif ($month == $currentMonth && $day > 25) {
            $dateTime = Carbon::createFromFormat('Y-m-d', $hdatess)->addMonth();
            $month = $dateTime->format('F');
        }

        $column = $dates[$day];

        $attendances = DB::table('attendances')
            ->where('employee_name', $request->createdby)
            ->where('month', $month)
            ->first();

        if ($attendances == null) {
            $teammember = DB::table('teammembers')->where('id', $request->createdby)->first();

            DB::table('attendances')->insert([
                'employee_name' => $request->createdby,
                'month' => $month,
                'dateofjoining' => $teammember->joining_date,
            ]);
        }

        if ($attendances != null && property_exists($attendances, $column)) {
            $updatedtotalhour = $request->totalhour + $attendances->$column;
        } else {
            $updatedtotalhour = $request->totalhour;
        }

        DB::table('attendances')
            ->where('employee_name', $request->createdby)
            ->where('month', $month)
            ->update([$column => $updatedtotalhour]);

        $output = array('msg' => 'Create Successfully');
        return response()->json($output, 200);
    } catch (\Exception $e) {
        DB::rollBack();
        Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
        report($e);
        $output = array('msg' => $e->getMessage());
        return response()->json($output, 500);
    }
}
@endphp

<table id="examplee" class="display nowrap">
    <thead>
        <tr>
            <th style="display: none;">id</th>
            <th>Employee Name1</th>
            <th>Role</th>
            <th>Employee Status</th>
            <th>Date Of Joining</th>
            <th>Month</th>
            <th>26</th>
            <th>27 </th>
            <th>28</th>
            <th>29</th>
            <th>30</th>
            <th>31</th>
            <th>01</th>
            <th>02</th>
            <th>03</th>
            <th>04</th>
            <th>05</th>
            <th>06</th>
            <th>07</th>
            <th>08</th>
            <th>09</th>
            <th>10</th>
            <th>11</th>
            <th>12</th>
            <th>13</th>
            <th>14</th>
            <th>15</th>
            <th>16</th>
            <th>17</th>
            <th>18</th>
            <th>19</th>
            <th>20</th>
            <th>21</th>
            <th>22</th>
            <th>23</th>
            <th>24</th>
            <th>25</th>
            <th>Total Number of days
            </th>
            <th>No of days Present
            </th>
            <th>Casual Leave (CL)
            </th>
            <th>Sick Leave (SL)
            </th>
            <th>Comp Off (CO)
            </th>
            <th>Birthday/religious Holiday
            </th>
            <th>LWP (Leave Without Pay)
            </th>
            <th>Exam Leave</th>
            <th>Absent</th>
            <th>Total Days to be paid
            </th>
            <th>Comment (If any)
            </th>
        </tr>
    </thead>

    <tbody>
        @foreach ($attendanceDatas as $attendanceData)
            <tr data-toggle="modal" data-target="#updateModal{{ $attendanceData->id }}">
                <td style="display: none;">{{ $attendanceData->id }}</td>
                <td>{{ $attendanceData->team_member }}</td>
                <td>{{ $attendanceData->rolename }}</td>
                <td>{{ $attendanceData->employment_status }}</td>
                <td>
                    @if ($attendanceData->joining_date != null)
                        {{ date('F d, Y', strtotime($attendanceData->joining_date ?? '')) }}
                    @endif
                </td>
                <td> {{ $attendanceData->month }}</td>
                <td> {{ $attendanceData->twentysix ?? '0' }}</td>
                <td> {{ $attendanceData->twentyseven ?? '0' }}</td>
                <td> {{ $attendanceData->twentyeight ?? '0' }}</td>
                <td> {{ $attendanceData->twentynine ?? '0' }}</td>
                <td> {{ $attendanceData->thirty ?? '0' }}</td>
                <td> {{ $attendanceData->thirtyone ?? '0' }}</td>
                <td> {{ $attendanceData->one ?? '0' }}</td>
                <td> {{ $attendanceData->two ?? '0' }}</td>
                <td> {{ $attendanceData->three ?? '0' }}</td>
                <td> {{ $attendanceData->four ?? '0' }}</td>
                <td> {{ $attendanceData->five ?? '0' }}</td>
                <td> {{ $attendanceData->six ?? '0' }}</td>
                <td> {{ $attendanceData->seven ?? '0' }}</td>
                <td> {{ $attendanceData->eight ?? '0' }}</td>
                <td> {{ $attendanceData->nine ?? '0' }}</td>
                <td> {{ $attendanceData->ten ?? '0' }}</td>
                <td> {{ $attendanceData->eleven ?? '0' }}</td>
                <td> {{ $attendanceData->twelve ?? '0' }}</td>
                <td> {{ $attendanceData->thirteen ?? '0' }}</td>
                <td> {{ $attendanceData->fourteen ?? '0' }}</td>
                <td> {{ $attendanceData->fifteen ?? '0' }}</td>
                <td> {{ $attendanceData->sixteen ?? '0' }}</td>
                <td> {{ $attendanceData->seventeen ?? '0' }}</td>
                <td> {{ $attendanceData->eighteen ?? '0' }}</td>
                <td> {{ $attendanceData->ninghteen ?? '0' }}</td>
                <td> {{ $attendanceData->twenty ?? '0' }}</td>
                <td> {{ $attendanceData->twentyone ?? '0' }}</td>
                <td> {{ $attendanceData->twentytwo ?? '0' }}</td>
                <td> {{ $attendanceData->twentythree ?? '0' }}</td>
                <td> {{ $attendanceData->twentyfour ?? '0' }}</td>
                <td> {{ $attendanceData->twentyfive ?? '0' }}</td>
                <td> {{ $attendanceData->total_no_of_days }}</td>
                <td> {{ $attendanceData->no_of_days_present }}</td>
                <td> {{ $attendanceData->casual_leave }}</td>
                <td> {{ $attendanceData->sick_leave }}</td>
                <td> {{ $attendanceData->comp_off }}</td>
                <td> {{ $attendanceData->birthday_religious }}</td>
                <td> {{ $attendanceData->lwp }}</td>
                <td> {{ $attendanceData->exam_leave ?? '' }}</td>
                <td> {{ $attendanceData->absent ?? '' }}</td>
                <td> {{ $attendanceData->totaldaystobepaid }}</td>
                <td> {{ $attendanceData->comment }}</td>
            </tr>
            <!-- Update Modal -->
            <div class="modal fade" id="updateModal{{ $attendanceData->id }}" tabindex="-1"
                role="dialog" aria-labelledby="updateModal{{ $attendanceData->id }}Label"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"
                                id="updateModal{{ $attendanceData->id }}Label">Update
                                Attendance Data</h5>
                            <button type="button" class="close" data-dismiss="modal"
                                aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('updateAttendance') }}" method="POST">
                            @csrf
                            <div class="modal-body">

                                <input type="hidden" name="attendance_id"
                                    value="{{ $attendanceData->id }}">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="team_member">Employee Name :</label>
                                            <input type="text" name="team_member"
                                                id="team_member" class="form-control"
                                                value="{{ $attendanceData->team_member }}"
                                                disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="total_no_of_days">Total Number of
                                                days:</label>
                                            <input type="number" name="total_no_of_days"
                                                id="total_no_of_days" class="form-control"
                                                value="{{ $attendanceData->total_no_of_days }}">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="no_of_days_present">No of days
                                                Present:</label>
                                            <input type="number" name="no_of_days_present"
                                                id="no_of_days_present" class="form-control"
                                                value="{{ $attendanceData->no_of_days_present }}">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="casual_leave">Casual Leave
                                                (CL)
                                                :</label>
                                            <input type="number" name="casual_leave"
                                                id="casual_leave" class="form-control"
                                                value="{{ $attendanceData->casual_leave }}">
                                        </div>
                                    </div>


                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="sick_leave">Sick Leave (SL):</label>
                                            <input type="number" name="sick_leave"
                                                id="sick_leave" class="form-control"
                                                value="{{ $attendanceData->sick_leave }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="comp_off">Comp Off (CO):</label>
                                            <input type="number" name="comp_off"
                                                id="comp_off" class="form-control"
                                                value="{{ $attendanceData->comp_off }}">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="birthday_religious">Birthday/Religious
                                                Holiday:</label>
                                            <input type="number" name="birthday_religious"
                                                id="birthday_religious" class="form-control"
                                                value="{{ $attendanceData->birthday_religious }}">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lwp">LWP (Leave Without
                                                Pay):</label>
                                            <input type="number" name="lwp"
                                                id="lwp" class="form-control"
                                                value="{{ $attendanceData->lwp }}">
                                        </div>
                                    </div>


                                </div>


                                <div class="row">

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="absent">Absent:</label>
                                            <input type="number" name="absent"
                                                id="absent" class="form-control"
                                                value="{{ $attendanceData->absent }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="totaldaystobepaid">Total Days to be
                                                paid:</label>
                                            <input type="number" name="totaldaystobepaid"
                                                id="totaldaystobepaid" class="form-control"
                                                value="{{ $attendanceData->totaldaystobepaid }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="comment">Comment (If any):</label>
                                            <textarea name="comment" id="comment" class="form-control">{{ $attendanceData->comment }}</textarea>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">




                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="one">One:</label>
                                            <input type="text" name="one"
                                                id="one" class="form-control"
                                                value="{{ $attendanceData->one ?? '' }}">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="two">Two:</label>
                                            <input type="text" name="two"
                                                id="two" class="form-control"
                                                value="{{ $attendanceData->two ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="three">Three:</label>
                                            <input type="text" name="three"
                                                id="three" class="form-control"
                                                value="{{ $attendanceData->three ?? '' }}">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="four">Four:</label>
                                            <input type="text" name="four"
                                                id="four" class="form-control"
                                                value="{{ $attendanceData->four ?? '' }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">


                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="five">Five:</label>
                                            <input type="text" name="five"
                                                id="five" class="form-control"
                                                value="{{ $attendanceData->five ?? '' }}">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="six">Six:</label>
                                            <input type="text" name="six"
                                                id="six" class="form-control"
                                                value="{{ $attendanceData->six ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="seven">Seven:</label>
                                            <input type="text" name="seven"
                                                id="seven" class="form-control"
                                                value="{{ $attendanceData->seven ?? '' }}">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="eight">Eight:</label>
                                            <input type="text" name="eight"
                                                id="eight" class="form-control"
                                                value="{{ $attendanceData->eight ?? '' }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">


                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="nine">Nine:</label>
                                            <input type="text" name="nine"
                                                id="nine" class="form-control"
                                                value="{{ $attendanceData->nine ?? '' }}">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="ten">Ten:</label>
                                            <input type="text" name="ten"
                                                id="ten" class="form-control"
                                                value="{{ $attendanceData->ten ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="eleven">Eleven:</label>
                                            <input type="text" name="eleven"
                                                id="eleven" class="form-control"
                                                value="{{ $attendanceData->eleven ?? '' }}">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="twelve">Twelve:</label>
                                            <input type="text" name="twelve"
                                                id="twelve" class="form-control"
                                                value="{{ $attendanceData->twelve ?? '' }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">


                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="thirteen">Thirteen:</label>
                                            <input type="text" name="thirteen"
                                                id="thirteen" class="form-control"
                                                value="{{ $attendanceData->thirteen ?? '' }}">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="fourteen">Fourteen:</label>
                                            <input type="text" name="fourteen"
                                                id="fourteen" class="form-control"
                                                value="{{ $attendanceData->fourteen ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="fifteen">Fifteen:</label>
                                            <input type="text" name="fifteen"
                                                id="fifteen" class="form-control"
                                                value="{{ $attendanceData->fifteen ?? '' }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="sixteen">Sixteen:</label>
                                            <input type="text" name="sixteen"
                                                id="sixteen" class="form-control"
                                                value="{{ $attendanceData->sixteen ?? '' }}">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="seventeen">Seventeen:</label>
                                            <input type="text" name="seventeen"
                                                id="seventeen" class="form-control"
                                                value="{{ $attendanceData->seventeen ?? '' }}">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="eighteen">Eighteen:</label>
                                            <input type="text" name="eighteen"
                                                id="eighteen" class="form-control"
                                                value="{{ $attendanceData->eighteen ?? '' }}">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="nineteen">Nineteen:</label>
                                            <input type="text" name="ninghteen"
                                                id="ninghteen" class="form-control"
                                                value="{{ $attendanceData->ninghteen ?? '' }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="twenty">Twenty:</label>
                                            <input type="text" name="twenty"
                                                id="twenty" class="form-control"
                                                value="{{ $attendanceData->twenty ?? '' }}">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="twentyone">Twenty-One:</label>
                                            <input type="text" name="twentyone"
                                                id="twentyone" class="form-control"
                                                value="{{ $attendanceData->twentyone ?? '' }}">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="twentytwo">Twenty-Two:</label>
                                            <input type="text" name="twentytwo"
                                                id="twentytwo" class="form-control"
                                                value="{{ $attendanceData->twentytwo ?? '' }}">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="twentythree">Twenty-Three:</label>
                                            <input type="text" name="twentythree"
                                                id="twentythree" class="form-control"
                                                value="{{ $attendanceData->twentythree ?? '' }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="twentyfour">Twenty-Four:</label>
                                            <input type="text" name="twentyfour"
                                                id="twentyfour" class="form-control"
                                                value="{{ $attendanceData->twentyfour ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="twentyfive">Twenty-Five:</label>
                                            <input type="text" name="twentyfive"
                                                id="twentyfive" class="form-control"
                                                value="{{ $attendanceData->twentyfive ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="twentysix">Twenty-Six:</label>
                                            <input type="text" name="twentysix"
                                                id="twentysix" class="form-control"
                                                value="{{ $attendanceData->twentysix ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="twentyseven">Twenty-Seven:</label>
                                            <input type="text" name="twentyseven"
                                                id="twentyseven" class="form-control"
                                                value="{{ $attendanceData->twentyseven ?? '' }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="twentyeight">Twenty-Eight:</label>
                                            <input type="text" name="twentyeight"
                                                id="twentyeight" class="form-control"
                                                value="{{ $attendanceData->twentyeight ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="twentynine">Twenty-Nine:</label>
                                            <input type="text" name="twentynine"
                                                id="twentynine" class="form-control"
                                                value="{{ $attendanceData->twentynine ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="thirty">Thirty:</label>
                                            <input type="text" name="thirty"
                                                id="thirty" class="form-control"
                                                value="{{ $attendanceData->thirty ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="thirtyone">Thirty-One:</label>
                                            <input type="text" name="thirtyone"
                                                id="thirtyone" class="form-control"
                                                value="{{ $attendanceData->thirtyone ?? '' }}">
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save
                                    Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End of Update Modal -->
        @endforeach
    </tbody>
</table>

{{--  --}}

<td class="textfixed">
    @if (strlen($applyleaveDatas->reasonleave) > 25)
        <span id="reasonleave-{{ $applyleaveDatas->id }}"
            class="reasonleave-truncated">
            {{ substr($applyleaveDatas->reasonleave, 0, 25) }}.....
            <span style="color: #37A000; cursor: pointer;"
                data-toggle="tooltip" title="Show full text"
                onclick="showFullText('{{ $applyleaveDatas->reasonleave }}')">View
                Detail</span>
        </span>
    @else
        {{ $applyleaveDatas->reasonleave ?? '' }}
    @endif
</td>



  {{-- Model box for tooltip --}}
  <div class="modal fade" id="fullTextModal" tabindex="-1" role="dialog" aria-labelledby="fullTextModalLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="fullTextModalLabel">Full Detail
                  </h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <p id="fullTextContent"></p>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
          </div>
      </div>
  </div>
  <script>
      function showFullText(fullText) {
          // Set the full text content in the modal
          document.getElementById('fullTextContent').textContent = fullText;
          // Show the modal
          $('#fullTextModal').modal('show');
      }
      // Initialize tooltips
      $(function() {
          $('[data-toggle="tooltip"]').tooltip();
      });
  </script>

  <style>
      .reasonleave-truncated {
          display: inline;
      }

      .textfixed {
          overflow: hidden;
          text-overflow: ellipsis;
          white-space: nowrap;
      }
  </style>


{{--  --}}
bugs 

http://127.0.0.1:8000/assignmentlist/OFF100004

{{--  --}}
{{--  --}}
{{--  --}}


@if (strlen($timesheetrequestsData->reason) > 25)

title="{{ $timesheetrequestsData->reason }}">


if (column === 9) {
    var fullText = $(node).find('span').attr('title') || $(node)
        .text().trim();
    return fullText;
}

style="color: #37A000; cursor: pointer;


  {{-- Model box for tooltip --}}
  <div class="modal fade" id="fullTextModal" tabindex="-1" role="dialog" aria-labelledby="fullTextModalLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="fullTextModalLabel">Full Detail
                  </h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <p id="fullTextContent"></p>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
          </div>
      </div>
  </div>
  <script>
      function showFullText(fullText) {
          // Set the full text content in the modal
          document.getElementById('fullTextContent').textContent = fullText;
          // Show the modal
          $('#fullTextModal').modal('show');
      }
      // Initialize tooltips
      $(function() {
          $('[data-toggle="tooltip"]').tooltip();
      });
  </script>

  <style>
      .reasonleave-truncated {
          display: inline;
      }

      .textfixed {
          overflow: hidden;
          text-overflow: ellipsis;
          white-space: nowrap;
      }
  </style>



{{-- final double  --}}



<td class="textfixed">
    @if (strlen($timesheetrequestsData->reason) > 25)
        <span id="reasonleave-{{ $timesheetrequestsData->id }}"
            class="reasonleave-truncated" title="{{ $timesheetrequestsData->reason }}">
            {{ substr($timesheetrequestsData->reason, 0, 25) }}.....
            <span style="color: #37A000; cursor: pointer;" data-toggle="tooltip"
                title="Show full text"
                onclick="showFullText('{{ $timesheetrequestsData->reason }}')">View
                Detail</span>
        </span>
    @else
        {{ $timesheetrequestsData->reason ?? '' }}
    @endif
</td>


<td class="textfixed">
    @if (strlen($timesheetrequestsData->remark) > 25)
        <span id="reasonleave-{{ $timesheetrequestsData->id }}"
            class="reasonleave-truncated" title="{{ $timesheetrequestsData->remark }}">
            {{ substr($timesheetrequestsData->remark, 0, 25) }}.....
            <span style="color: #37A000; cursor: pointer;" data-toggle="tooltip"
                title="Show full text"
                onclick="showFullText('{{ $timesheetrequestsData->remark }}')">View
                Detail</span>
        </span>
    @else
        {{ $timesheetrequestsData->remark ?? 'NA' }}
    @endif
</td>

<script>
    $(document).ready(function() {
        $('#examplee').DataTable({
            dom: 'Bfrtip',
            "order": [
                [0, "desc"]
            ],

            columnDefs: [{
                targets: [0, 1, 3, 4, 5, 6, 7, 8, 9, 10],
                orderable: false
            }],

            buttons: [{
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: [0, ':visible']
                    }
                },
                {
                    extend: 'excelHtml5',
                    filename: 'Timesheet Request List',
                    exportOptions: {
                        columns: ':visible',
                        format: {
                            body: function(data, row, column, node) {
                                // Extract full text for column 7 and 9
                                if (column === 0 || column === 3) {
                                    var cleanedText = $(data).text().trim();
                                    return cleanedText;
                                }
                                if (column === 7 || column === 9) {
                                    var fullText = $(node).find('span').attr('title') || $(node)
                                        .text().trim();
                                    return fullText;
                                }
                                return data;
                            }
                        }
                    }
                },
                {
                    extend: 'pdfHtml5',
                    filename: 'Timesheet Request List',
                    exportOptions: {
                        columns: [0, 1, 2, 5]
                    }
                },
                'colvis'
            ]
        });
    });
</script>

{{--    --}}
{{--    --}}
{{--    --}}
{{--    --}}

<td class="textfixed">
    @if (strlen($timesheetrequestsData->reason) > 25)
        <span id="reasonleave-{{ $timesheetrequestsData->id }}"
            class="reasonleave-truncated" title="{{ $timesheetrequestsData->reason }}">
            {{ substr($timesheetrequestsData->reason, 0, 25) }}.....
            <span style="color: #37A000; cursor: pointer;" data-toggle="tooltip"
                title="Show full text"
                onclick="showFullText('{{ $timesheetrequestsData->reason }}')">View
                Detail</span>
        </span>
    @else
        {{ $timesheetrequestsData->reason ?? '' }}
    @endif
</td>


<td class="textfixed">
    @if (strlen($timesheetrequestsData->remark) > 25)
        <span id="remarkleave-{{ $timesheetrequestsData->id }}"
            class="reasonleave-truncated" title="{{ $timesheetrequestsData->remark }}">
            {{ substr($timesheetrequestsData->remark, 0, 25) }}.....
            <span style="color: #37A000; cursor: pointer;" data-toggle="tooltip"
                title="Show full text"
                onclick="showFullText('{{ $timesheetrequestsData->remark }}')">View
                Detail</span>
        </span>
    @else
        {{ $timesheetrequestsData->remark ?? 'NA' }}
    @endif
</td>


<script>
    $(document).ready(function() {
        $('#examplee').DataTable({
            dom: 'Bfrtip',
            "order": [
                [0, "desc"]
            ],
            columnDefs: [{
                targets: [0, 1, 3, 4, 5, 6, 7, 8, 9, 10],
                orderable: false
            }],
            buttons: [{
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: [0, ':visible']
                    }
                },
                {
                    extend: 'excelHtml5',
                    filename: 'Timesheet Request List',
                    exportOptions: {
                        columns: ':visible',
                        format: {
                            body: function(data, row, column, node) {
                                // Extract full text for column 7 and 9
                                if (column === 7 || column === 9) {
                                    var fullText = $(node).find('span').attr('title') || $(node)
                                        .text().trim();
                                    return fullText;
                                }
                                return data;
                            }
                        }
                    }
                },
                {
                    extend: 'pdfHtml5',
                    filename: 'Timesheet Request List',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                'colvis'
            ]
        });
    });
</script>
{{--  --}}

@if (strlen($timesheetrequestsData->reason) > 25)

title="{{ $timesheetrequestsData->reason }}">


if (column === 9) {
    var fullText = $(node).find('span').attr('title') || $(node)
        .text().trim();
    return fullText;
}
{{-- WWWWWWWWWWW --}}
{{-- WWWWWWWWWWW --}}

<td class="textfixed">
    @if (strlen($timesheetrequestsData->reason) > 25)
        <span id="reasonleave-{{ $timesheetrequestsData->id }}"
            class="reasonleave-truncated"
            title="{{ $timesheetrequestsData->reason }}">
            {{ substr($timesheetrequestsData->reason, 0, 25) }}...
            <span style="color: #37A000; cursor: pointer;" data-toggle="tooltip"
                title="Show full text"
                onclick="showFullText('{{ $timesheetrequestsData->reason }}')">View
                Detail</span>
        </span>
    @else
        {{ $timesheetrequestsData->reason ?? '' }}
    @endif
</td>


<script>
    $(document).ready(function() {
        $('#examplee').DataTable({
            dom: 'Bfrtip',
            "pageLength": 100,
            "order": [
                [5, "desc"]
            ],
            columnDefs: [{
                targets: [1, 2, 3, 4, 6, 7, 8, 9, 10],
                orderable: false
            }],
            buttons: [

                {
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: [0, ':visible']
                    }
                },
                {
                    extend: 'excelHtml5',
                    filename: 'Leave Revert List',
                    exportOptions: {
                        columns: ':visible',
                        format: {
                            body: function(data, row, column, node) {

                                // it should be column number 2
                                if (column === 4) {
                                    // If the data is a date, extract the date without HTML tags
                                    var cleanedText = $(data).text().trim();
                                    var dateParts = cleanedText.split(
                                        '-');
                                    // Assuming the date format is yyyy-mm-dd
                                    if (dateParts.length === 3) {
                                        return dateParts[2] + '-' + dateParts[1] + '-' +
                                            dateParts[0];
                                    }
                                }
                                if (column === 0 || column === 2) {
                                    var cleanedText = $(data).text().trim();
                                    return cleanedText;
                                }
                                if (column === 9 || column === 7) {
                                    var fullText = $(node).find('span').attr('title') || $(node)
                                        .text().trim();
                                    return fullText;
                                }
                                
                                return data;
                            }
                        }
                    },
                },
                {
                    extend: 'pdfHtml5',
                    filename: 'Leave Revert List',
                    exportOptions: {
                        columns: [0, 1, 2, 5]
                    }
                },
                'colvis'
            ]
        });
    });
</script>
{{-- WWWWWWWWWWW --}}

<script>
    $(document).ready(function() {
        $('#examplee').DataTable({
            dom: 'Bfrtip',
            "pageLength": 100,
            "order": [
                [5, "desc"]
            ],
            columnDefs: [{
                targets: [1, 2, 3, 4, 6, 7, 8, 9, 10],
                orderable: false
            }],
            buttons: [{
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: [0, ':visible']
                    }
                },
                {
                    extend: 'excelHtml5',
                    filename: 'Leave Revert List',
                    exportOptions: {
                        columns: ':visible',
                        format: {
                            body: function(data, row, column, node) {
                                // Extract full text from the title attribute
                                var fullText = $(node).find('span').attr('title') || $(node)
                                    .text().trim();

                                // Handle specific columns if needed
                                if (column === 4) { // Example for specific column if needed
                                    var dateParts = fullText.split('-');
                                    if (dateParts.length === 3) {
                                        return dateParts[2] + '-' + dateParts[1] + '-' +
                                            dateParts[0];
                                    }
                                }

                                return fullText;
                            }
                        }
                    }
                },
                {
                    extend: 'pdfHtml5',
                    filename: 'Leave Revert List',
                    exportOptions: {
                        columns: [0, 1, 2, 5]
                    }
                },
                'colvis'
            ]
        });
    });
</script>


<td class="textfixed">
    @if (strlen($timesheetrequestsData->reason) > 25)
        <span id="reasonleave-{{ $timesheetrequestsData->id }}"
            class="reasonleave-truncated"
            title="{{ $timesheetrequestsData->reason }}">
            {{ substr($timesheetrequestsData->reason, 0, 25) }}...
            <span style="color: #37A000; cursor: pointer;" data-toggle="tooltip"
                title="{{ $timesheetrequestsData->reason }}"
                onclick="showFullText('{{ $timesheetrequestsData->reason }}')">View
                Detail</span>
        </span>
    @else
        {{ $timesheetrequestsData->reason ?? '' }}
    @endif
</td>
{{-- WWWWWWWWWWW --}}



<td class="textfixed">
    @if (strlen($timesheetrequestsData->remark) > 25)
        <span id="reasonleave-{{ $timesheetrequestsData->id }}"
            class="reasonleave-truncated">
            {{ substr($timesheetrequestsData->remark, 0, 25) }}.....
            <span style="color: #37A000; cursor: pointer;"
                data-toggle="tooltip" title="Show full text"
                onclick="showFullText('{{ $timesheetrequestsData->remark }}')">View
                Detail</span>
        </span>
    @else
        {{ $timesheetrequestsData->remark ?? 'NA' }}
    @endif
</td>

<td class="textfixed">
    @if (strlen($timesheetrequestsData->reason) > 25)
        <span id="reasonleave-{{ $timesheetrequestsData->id }}"
            class="reasonleave-truncated">
            {{ substr($timesheetrequestsData->reason, 0, 25) }}.....
            <span style="color: #37A000; cursor: pointer;" data-toggle="tooltip"
                title="Show full text"
                onclick="showFullText('{{ $timesheetrequestsData->reason }}')">View
                Detail</span>
        </span>
    @else
        {{ $timesheetrequestsData->reason ?? '' }}
    @endif
</td>

<td class="textfixed">
    @if (strlen($applyleaveDatas->reasonleave) > 25)
        <span id="reasonleave-{{ $applyleaveDatas->id }}"
            class="reasonleave-truncated">
            {{ substr($applyleaveDatas->reasonleave, 0, 25) }}.....
            <span style="color: #37A000; cursor: pointer;"
                data-toggle="tooltip" title="Show full text"
                onclick="showFullText('{{ $applyleaveDatas->reasonleave }}')">View
                Detail</span>
        </span>
    @else
        {{ $applyleaveDatas->reasonleave ?? '' }}
    @endif
</td>

  {{-- Model box for tooltip --}}
  <div class="modal fade" id="fullTextModal" tabindex="-1" role="dialog" aria-labelledby="fullTextModalLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="fullTextModalLabel">Full Detail
                  </h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <p id="fullTextContent"></p>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
          </div>
      </div>
  </div>
  <script>
      function showFullText(fullText) {
          // Set the full text content in the modal
          document.getElementById('fullTextContent').textContent = fullText;
          // Show the modal
          $('#fullTextModal').modal('show');
      }
      // Initialize tooltips
      $(function() {
          $('[data-toggle="tooltip"]').tooltip();
      });
  </script>

  <style>
      .reasonleave-truncated {
          display: inline;
      }

      .textfixed {
          overflow: hidden;
          text-overflow: ellipsis;
          white-space: nowrap;
      }
  </style>




{{-- WWWWWWWWWWW --}}



<td class="textfixed">
    @if (strlen($applyleaveDatas->reasonleave) > 25)
        <span id="reasonleave-{{ $applyleaveDatas->id }}"
            class="reasonleave-truncated">
            {{ substr($applyleaveDatas->reasonleave, 0, 25) }}.....
            <span style="color: #37A000; cursor: pointer;"
                data-toggle="tooltip" title="Show full text"
                onclick="showFullText('{{ $applyleaveDatas->reasonleave }}')">View
                Detail</span>
        </span>
    @else
        {{ $applyleaveDatas->reasonleave ?? '' }}
    @endif
</td>


<div class="modal fade" id="fullTextModal" tabindex="-1" role="dialog"
aria-labelledby="fullTextModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="fullTextModalLabel">Full Detail
            </h5>
            <button type="button" class="close" data-dismiss="modal"
                aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <p id="fullTextContent"></p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary"
                data-dismiss="modal">Close</button>
        </div>
    </div>
</div>
</div>

<script>
function showFullText(fullText) {
    // Set the full text content in the modal
    document.getElementById('fullTextContent').textContent = fullText;
    // Show the modal
    $('#fullTextModal').modal('show');
}
// Initialize tooltips
$(function() {
    $('[data-toggle="tooltip"]').tooltip();
});
</script>

<style>
.reasonleave-truncated {
    display: inline;
}

.textfixed {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
</style>



{{-- WWWWWWWWWWW --}}

<td class="textfixed">
    @if (strlen($timesheetrequestsData->reason) > 25)
        <span class="reasonleave-truncated" data-toggle="tooltip"
            title="{{ $timesheetrequestsData->reason }}">
            {{ substr($timesheetrequestsData->reason, 0, 25) }}...
        </span>
    @else
        {{ $timesheetrequestsData->reason ?? '' }}
    @endif
</td>
{{-- WWWWWWWWWWW --}}
     <form method="get" action="{{ url('totaltimeshow/filter') }}" enctype="multipart/form-data"
                            class="form-inline">
                            @csrf
                            @php
                                $teamselect = DB::table('assignmentteammappings')
                                    ->leftjoin(
                                        'assignmentmappings',
                                        'assignmentmappings.id',
                                        'assignmentteammappings.assignmentmapping_id',
                                    )
                                    ->leftjoin(
                                        'assignmentbudgetings',
                                        'assignmentbudgetings.assignmentgenerate_id',
                                        'assignmentmappings.assignmentgenerate_id',
                                    )
                                    ->leftjoin('teammembers', 'teammembers.id', 'assignmentteammappings.teammember_id')
                                    ->leftjoin('titles', 'titles.id', 'teammembers.title_id')
                                    ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
                                    // ->where('assignmentbudgetings.status', 1)
                                    ->whereNotIn('teammembers.team_member', ['NA', 'null', 'test staff'])
                                    ->select(
                                        'assignmentmappings.id',
                                        'teammembers.id as teamid',
                                        'teammembers.team_member',
                                        'teammembers.role_id',
                                        'teammembers.staffcode',
                                        'titles.title',
                                        'assignmentmappings.assignmentgenerate_id',
                                        'assignmentbudgetings.assignmentname',
                                        'assignmentteammappings.teamhour',
                                    )
                                    // ->take(10)
                                    ->get();

                                // dd($teammemberDatas);

                                $partnerselect = DB::table('assignmentmappings')
                                    ->leftjoin(
                                        'assignmentbudgetings',
                                        'assignmentbudgetings.assignmentgenerate_id',
                                        'assignmentmappings.assignmentgenerate_id',
                                    )
                                    ->leftjoin('teammembers', function ($join) {
                                        $join
                                            ->on('teammembers.id', 'assignmentmappings.otherpartner')
                                            ->orOn('teammembers.id', 'assignmentmappings.leadpartner');
                                    })
                                    ->leftjoin('titles', 'titles.id', 'teammembers.title_id')
                                    ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
                                    // ->where('assignmentbudgetings.status', 1)
                                    ->whereNotIn('teammembers.team_member', ['NA', 'test staff'])
                                    ->select(
                                        'assignmentmappings.id',
                                        'teammembers.id as teamid',
                                        'teammembers.team_member',
                                        'teammembers.staffcode',
                                        'teammembers.role_id',
                                        'titles.title',
                                        'assignmentmappings.assignmentgenerate_id',
                                        'assignmentbudgetings.assignmentname',
                                        'assignmentmappings.otherpartner',
                                        'assignmentmappings.leadpartner',
                                        'assignmentmappings.leadpartnerhour',
                                        'assignmentmappings.otherpartnerhour',
                                    )
                                    // ->take(10)
                                    ->get();
                                $allselect = $teamselect->merge($partnerselect);

                                $distinctteammember = $allselect->unique('staffcode')->sortBy('team_member');
                                $distinctassignmentid = $allselect
                                    ->unique('assignmentgenerate_id')
                                    ->sortBy('assignmentgenerate_id');

                            @endphp
                            <div class="row">
                                {{-- <div class="col-md-6 mb-3">


                                    <div class="form-group">
                                        <strong><label for="employee">Teammember</label></strong>
                                        <select class="language form-control" id="employee" name="employee">
                                            <option value="">Please Select One</option>
                                            @foreach ($distinctteammember as $teammemberData)
                                                @php
                                                    $permotioncheck = DB::table('teamrolehistory')
                                                        ->where('teammember_id', $teammemberData->teamid)
                                                        ->first();
                                                @endphp
                                                <option
                                                    value="{{ $teammemberData->teamid }}/{{ $teammemberData->role_id }}"{{ old('employee') == $teammemberData->teamid . '/' . $teammemberData->role_id ? 'selected' : '' }}>
                                                    {{ $teammemberData->team_member }}
                                                    ({{ $permotioncheck->newstaff_code ?? ($teammemberData->staffcode ?? '') }})
                                                </option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div> --}}
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <strong><label for="employee">Teammember</label></strong>
                                        <select class="language form-control" id="employee" name="employee">
                                            <option value="">Please Select One</option>
                                            @foreach ($distinctteammember as $teammemberData)
                                                @php
                                                    $permotioncheck = DB::table('teamrolehistory')
                                                        ->where('teammember_id', $teammemberData->teamid)
                                                        ->first();
                                                    $displayCode =
                                                        $permotioncheck->newstaff_code ?? $teammemberData->staffcode;
                                                @endphp
                                                <option value="{{ $teammemberData->teamid }}/{{ $teammemberData->role_id }}"
                                                    {{ old('employee') == $teammemberData->teamid . '/' . $teammemberData->role_id ? 'selected' : '' }}>
                                                    {{ $teammemberData->team_member }} ({{ $displayCode }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <strong><label for="assignmentgenerateid">Assignment Id</label></strong>
                                        <select class="language form-control" id="assignmentgenerateid"
                                            name="assignmentgenerateid">
                                            <option value="">Please Select One</option>
                                            @foreach ($distinctassignmentid as $teammemberData)
                                                <option
                                                    value="{{ $teammemberData->assignmentgenerate_id }}"{{ old('assignmentgenerateid') == $teammemberData->assignmentgenerate_id ? 'selected' : '' }}>
                                                    {{ $teammemberData->assignmentgenerate_id }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2 mb-3">
                                    <div class="form-group">
                                        <strong><label for="search">&nbsp;</label></strong>
                                        <button type="submit" class="btn btn-success btn-block">Search</button>
                                    </div>
                                </div>
                            </div>
                        </form>
{{-- WWWWWWWWWWW --}}
<script>
    $(document).ready(function() {
        $('#examplee').DataTable({
            dom: 'Bfrtip',
            "pageLength": 100,
            "order": [
                [5, "desc"]
            ],
            columnDefs: [{
                targets: [1, 2, 3, 4, 6, 7, 8, 9, 10],
                orderable: false
            }],
            buttons: [

                {
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: [0, ':visible']
                    }
                },
                {
                    extend: 'excelHtml5',
                    filename: 'Leave Revert List',
                    exportOptions: {
                        columns: ':visible',
                        format: {
                            body: function(data, row, column, node) {
                                // it should be column number 2
                                if (column === 4) {
                                    // If the data is a date, extract the date without HTML tags
                                    var cleanedText = $(data).text().trim();
                                    var dateParts = cleanedText.split(
                                        '-');
                                    // Assuming the date format is yyyy-mm-dd
                                    if (dateParts.length === 3) {
                                        return dateParts[2] + '-' + dateParts[1] + '-' +
                                            dateParts[0];
                                    }
                                }
                                if (column === 0 || column === 2) {
                                    var cleanedText = $(data).text().trim();
                                    return cleanedText;
                                }
                                return data;
                            }
                        }
                    },
                },
                {
                    extend: 'pdfHtml5',
                    filename: 'Leave Revert List',
                    exportOptions: {
                        columns: [0, 1, 2, 5]
                    }
                },
                'colvis'
            ]
        });
    });
</script>
{{-- WWWWWWWWWWW --}}
 <td>         
     <span style="display: none;">
         {{ date('Y-m-d', strtotime($timesheetrequestsData->created_at)) }}
     </span>
     {{ date('d-m-Y', strtotime($timesheetrequestsData->created_at)) }}
 </td>

  <td>
      <span style="display: none;">
          {{ date('Y-m-d', strtotime($timesheetDatas->date)) }}
      </span>
      {{ date('d-m-Y', strtotime($timesheetDatas->date)) }}
  </td>
{{-- WWWWWWWWWWW --}}
date('d-m-Y',
date('d-M-Y',
class="textfixed"

<th>Assigned Partner</th>
<th>Assignedpartner Code</th>
<th>Other Partner</th>
<th>Otherpartner Code</th>

columnDefs: [{
    @if (Auth::user()->role_id == 11)
        targets: [1, 2, 3],
    @else
        targets: [1, 2],
    @endif
    orderable: false
}],

<script>
    $(document).ready(function() {
        $('#examplee').DataTable({
            dom: 'Bfrtip',
            "order": [
                [0, "desc"]
            ],

            columnDefs: [{
                targets: [0, 1, 3, 4, 5, 6, 7, 8, 9, 10],
                orderable: false
            }],

            buttons: [{
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: [0, ':visible']
                    }
                },
                {
                    extend: 'excelHtml5',
                    filename: 'Timesheet Request List',
                    // exportOptions: {
                    //     columns: ':visible'
                    // }
                    exportOptions: {
                        columns: ':visible',
                        format: {
                            body: function(data, row, column, node) {
                                if (column === 0) {
                                    var cleanedText = $(data).text().trim();
                                    return cleanedText;
                                }
                                if (column === 1) {
                                    var dateParts = data.split('-');
                                    var monthNumbers = {
                                        'Jan': '01',
                                        'Feb': '02',
                                        'Mar': '03',
                                        'Apr': '04',
                                        'May': '05',
                                        'Jun': '06',
                                        'Jul': '07',
                                        'Aug': '08',
                                        'Sep': '09',
                                        'Oct': '10',
                                        'Nov': '11',
                                        'Dec': '12'
                                    };
                                    var day = dateParts[0];
                                    var month = monthNumbers[dateParts[1]];
                                    var year = dateParts[2];
                                    return day + '-' + month + '-' + year;
                                }
                                if (column === 3) {
                                    var cleanedText = $(data).text().trim();
                                    return cleanedText;
                                }
                                return data; // Return other data unchanged
                            }
                        }
                    }
                },
                {
                    extend: 'pdfHtml5',
                    filename: 'Timesheet Request List',
                    exportOptions: {
                        columns: [0, 1, 2, 5]
                    }
                },
                'colvis'
            ]
        });
    });
</script>
{{-- WWWWWWWWWWW --}}
$partnerpormotiondateformate = $partnerpormotioncheck
? Carbon\Carbon::createFromFormat(
    'Y-m-d H:i:s',
    $partnerpormotioncheck->created_at,
)
: null;

resources\views\backEnd\timesheet\rejectedlist.blade.php
{{-- WWWWWWWWWWW --}}
resources\views\backEnd\timesheet\weeklylist.blade.php

@php
      $permotioncheck = null;
   $datadate = $timesheetDatas->assignmentcreated
       ? Carbon\Carbon::createFromFormat(
           'Y-m-d H:i:s',
           $timesheetDatas->assignmentcreated,
       )
       : null;
   $permotiondate = null;

@endphp
<td>
    {{ $client_id->assignment_name ?? '' }} (
    {{ $timesheetDatas->assignmentgenerate_id ?? '' }})
    @if ($timesheetDatas->assignmentname != null)
        ({{ $timesheetDatas->assignmentname ?? '' }})
    @endif
    @if (count((array) $client_id->assignment_name) > 1)
        ,
    @endif
</td>

<td>
    {{ $client_id->team_member ?? '' }}
    @if ($permotioncheck && $datadate && $datadate->greaterThan($permotiondate))
        ({{ $permotioncheck->newstaff_code }})
    @else
        ({{ $client_id->staffcode ?? '' }})
    @endif
    @if (count((array) $client_id->team_member) > 1)
        ,
    @endif
</td>
{{-- regarding code WWWWWWWWWWW --}}






                                                <td>
                                                    {{ $leadpartner->team_member ?? '' }}
                                                </td>
                                                <td>
                                                    @if ($leadpartner && $leadpartner->team_member)
                                                        {{ $leadpartner->newstaff_code ?? ($leadpartner->staffcode ?? '') }}
                                                    @endif
                                                </td>

                                                <td>
                                                    {{ $otherPartner->team_member ?? '' }}
                                                </td>
                                                <td>
                                                    @if ($otherPartner && $otherPartner->team_member)
                                                        {{ $otherPartner->newstaff_code ?? ($otherPartner->staffcode ?? '') }}
                                                    @endif
                                                </td>
{{-- WWWWWWWWWWW --}}
@php

                                     <td>
                                            @foreach ($client_id as $item)
                                                {{ $item->team_member ?? '' }}
                                                @if ($permotioncheck && $datadate->greaterThan($permotiondate))
                                                    ({{ $item->newstaff_code }})
                                                @else
                                                    ({{ $item->staffcode ?? '' }})
                                                @endif
                                                @if ($item->team_member != null)
                                                    ,
                                                @endif
                                            @endforeach
                                        </td>

                                        @if ($permotioncheck && $datadate->greaterThan($permotiondate))
                                        <td>{{ $permotioncheck->newstaff_code }}</td>
                                    @else
                                        <td>{{ $timesheetDatas->staffcode }}</td>
                                    @endif

                                    $assignmentcheck = DB::table('assignmentbudgetings')
                                            ->where('assignmentgenerate_id', $timesheetDatas->assignmentgenerate_id)
                                            ->first();

                                        $permotioncheck = DB::table('teamrolehistory')
                                            ->where('teammember_id', $timesheetDatas->createdby)
                                            ->first();

                                        //shshid client
                                        // $datadate = Carbon\Carbon::createFromFormat('Y-m-d', $timesheetDatas->date);
                                        $datadate = Carbon\Carbon::createFromFormat(
                                            'Y-m-d H:i:s',
                                            $assignmentcheck->created_at,
                                        );

                                        $permotiondate = null;
                                        if ($permotioncheck) {
                                            $permotiondate = Carbon\Carbon::createFromFormat(
                                                'Y-m-d H:i:s',
                                                $permotioncheck->created_at,
                                            );
                                        }






 dd('hi');
      $client_id = DB::table('timesheetusers')
                                                ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
                                                ->leftjoin(
                                                    'assignmentbudgetings',
                                                    'assignmentbudgetings.assignment_id',
                                                    'timesheetusers.assignment_id',
                                                )
                                                ->leftjoin(
                                                    'assignments',
                                                    'assignments.id',
                                                    'timesheetusers.assignment_id',
                                                )
                                                ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.partner')
                                                ->where('timesheetusers.id', $timesheetDatas->id)
                                                ->select(
                                                    'clients.client_name',
                                                    'clients.client_code',
                                                    'timesheetusers.hour',
                                                    'timesheetusers.location',
                                                    'timesheetusers.status',
                                                    'assignments.assignment_name',
                                                    'billable_status',
                                                    'workitem',
                                                    'teammembers.team_member',
                                                    'teammembers.staffcode',
                                                    'assignmentbudgetings.assignmentname',
                                                    'assignmentbudgetings.assignmentgenerate_id',
                                                    'assignmentbudgetings.created_at',
                                                )
                                                ->first();

                                            $permotioncheck = DB::table('teamrolehistory')
                                                ->where('teammember_id', auth()->user()->teammember_id)
                                                ->first();
                                            //shshid client
                                            $datadate = $client_id->created_at Carbon\Carbon::createFromFormat(
                                                'Y-m-d H:i:s',
                                                $client_id->created_at,
                                            );

                                            $permotiondate = null;
                                            if ($permotioncheck) {
                                                $permotiondate = Carbon\Carbon::createFromFormat(
                                                    'Y-m-d H:i:s',
                                                    $permotioncheck->created_at,
                                                );
                                            }

                                            $total = DB::table('timesheetusers')

                                                ->where('timesheetusers.timesheetid', $timesheetDatas->timesheetid)
                                                ->sum('hour');
                                            //	dd($total);
                                            $dates = date('l', strtotime($timesheetDatas->date));

@endphp
{{-- WWWWWWWWWWW --}}
{{-- WWWWWWWWWWW --}}

{{-- ssssssss --}}
 {{-- <td>{{ App\Models\Teammember::select('team_member')->where('id', $applyleaveDatas->approver)->first()->team_member ?? '' }}
                                                  ({{ App\Models\Teammember::select('team_member', 'staffcode')->where('id', $applyleaveDatas->approver)->first()->staffcode ?? '' }})
                                              </td> --}}
                                              @php
                                                  $approvelpartner = DB::table('teammembers')
                                                      ->leftJoin(
                                                          'teamrolehistory',
                                                          'teamrolehistory.teammember_id',
                                                          '=',
                                                          'teammembers.id',
                                                      )
                                                      ->where('teammembers.id', $applyleaveDatas->approver)
                                                      ->select(
                                                          'teammembers.team_member',
                                                          'teammembers.staffcode',
                                                          'teamrolehistory.newstaff_code',
                                                          'teamrolehistory.created_at',
                                                      )
                                                      ->first();

                                                  $datadate = Carbon\Carbon::createFromFormat(
                                                      'Y-m-d H:i:s',
                                                      $applyleaveDatas->created_at,
                                                  );

                                                  $permotiondate = null;
                                                  if ($approvelpartner) {
                                                      $permotiondate = Carbon\Carbon::createFromFormat(
                                                          'Y-m-d H:i:s',
                                                          $approvelpartner->created_at,
                                                      );
                                                  }
                                              @endphp


                                              <td>
                                                  {{ $approvelpartner->team_member ?? '' }}
                                                  @if ($approvelpartner && $datadate->greaterThan($permotiondate))
                                                      ({{ $approvelpartner->newstaff_code }})
                                                  @else
                                                      ( {{ $approvelpartner->staffcode }})
                                                  @endif
                                              </td>
{{-- ssssssss --}}


<td> {{ $timesheetDatas->patnername ?? '' }} (
    {{ $timesheetDatas->newstaff_code ?? ($timesheetDatas->patnerstaffcode ?? '') }})
</td>



@php
    public function assignmentHourShow()
  {

    
    ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'patnerid.id')
    , 'teamrolehistory.newstaff_code'


    
    $Newteammeberjoining_date = DB::table('teammembers')
        ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
        ->where('teammembers.id', auth()->user()->teammember_id)
        ->select('teammembers.team_member', 'teammembers.staffcode', 'teammembers.joining_date', 'teamrolehistory.newstaff_code', 'teamrolehistory.rejoiningdate')
        ->first();


    // First query with teamrolehistory join
    $teammemberDatass = DB::table('assignmentteammappings')
      ->leftjoin('assignmentmappings', 'assignmentmappings.id', 'assignmentteammappings.assignmentmapping_id')
      ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
      ->leftjoin('teammembers', 'teammembers.id', 'assignmentteammappings.teammember_id')
      ->leftJoin('teamrolehistory', function ($join) {
        $join->on('teamrolehistory.teammember_id', '=', 'teammembers.id')
          ->on('teamrolehistory.created_at', '<', 'assignmentbudgetings.created_at');
      })

      ->leftjoin('titles', 'titles.id', 'teammembers.title_id')
      ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
      ->whereNotIn('teammembers.team_member', ['NA', 'null', 'test staff'])
      ->select(
        'assignmentmappings.id',
        'teamrolehistory.newstaff_code',
        'teammembers.id as teamid',
        'teammembers.team_member',
        'teammembers.role_id',
        'teammembers.staffcode',
        'titles.title',
        'assignmentmappings.assignmentgenerate_id',
        'assignmentbudgetings.assignmentname',
        'assignmentbudgetings.created_at',
        'assignmentteammappings.teamhour'
      )
      ->get();

    // Second query with teamrolehistory join
    $patnerdata = DB::table('assignmentmappings')
      ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
      ->leftjoin('teammembers', function ($join) {
        $join->on('teammembers.id', 'assignmentmappings.otherpartner')
          ->orOn('teammembers.id', 'assignmentmappings.leadpartner');
      })
      ->leftJoin('teamrolehistory', function ($join) {
        $join->on('teamrolehistory.teammember_id', '=', 'teammembers.id')
          ->on('teamrolehistory.created_at', '<', 'assignmentbudgetings.created_at');
      })
      ->leftjoin('titles', 'titles.id', 'teammembers.title_id')
      ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
      ->whereNotIn('teammembers.team_member', ['NA', 'test staff'])
      ->select(
        'assignmentmappings.id',
        'teammembers.id as teamid',
        'teammembers.team_member',
        'teammembers.staffcode',
        'teammembers.role_id',
        'titles.title',
        'assignmentmappings.assignmentgenerate_id',
        'assignmentbudgetings.assignmentname',
        'assignmentbudgetings.created_at',
        'assignmentmappings.otherpartner',
        'assignmentmappings.leadpartner',
        'assignmentmappings.leadpartnerhour',
        'assignmentmappings.otherpartnerhour',
        'teamrolehistory.newstaff_code'
      )
      ->get();


    $teammemberDatas = $teammemberDatass->merge($patnerdata);
    return view('backEnd.timesheet.assignmentlistwithhour', compact('teammemberDatas'));
  }
@endphp






<body>
    {{-- *   --}}
    {{-- *   --}}
    {{-- *   --}}
    <table id="examplee" class="table display table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th style="width: 94.6562px;">Team Name</th>
                <th>Staff Code</th>
                <th>Period Date ( Monday To Saturday )</th>
                <th>Submitted Date</th>
                <th>Total Timesheet Filled Day</th>
                <th>Total Hour</th>
                {{-- <th>Partner</th> --}}
            </tr>
        </thead>
        <tbody>
            @foreach ($get_date as $jobDatas)
                <tr>
                    @php
                        $permotioncheck = DB::table('teamrolehistory')
                            ->where('teammember_id', $jobDatas->teamid)
                            ->first();

                        $datadate = Carbon\Carbon::createFromFormat(
                            'Y-m-d H:i:s',
                            $jobDatas->created_at,
                        );

                        $permotiondate = null;
                        if ($permotioncheck) {
                            $permotiondate = Carbon\Carbon::createFromFormat(
                                'Y-m-d H:i:s',
                                $permotioncheck->created_at,
                            );
                        }

                    @endphp
                    <td><a
                            href="{{ url(
                                '/weeklylist?' .
                                    'id=' .
                                    $jobDatas->id .
                                    '&&' .
                                    'teamid=' .
                                    $jobDatas->teamid .
                                    '&&' .
                                    'partnerid=' .
                                    $jobDatas->partnerid .
                                    '&&' .
                                    'startdate=' .
                                    $jobDatas->startdate .
                                    '&&' .
                                    'enddate=' .
                                    $jobDatas->enddate,
                            ) }}">{{ $jobDatas->team_member }}</a>
                    </td>
                    {{-- <td> {{ $jobDatas->staffcode }}</td> --}}
                    @if ($permotioncheck && $datadate->greaterThan($permotiondate))
                        <td>{{ $permotioncheck->newstaff_code }}</td>
                    @else
                        <td>{{ $jobDatas->staffcode }}</td>
                    @endif
                    <td><span
                            style="display: none;">{{ $jobDatas->created_at }}</span>{{ $jobDatas->week }}
                    </td>
                    <td> <span
                            style="display: none;">{{ $jobDatas->created_at }}</span>{{ date('d-m-Y', strtotime($jobDatas->created_at)) }}
                        {{ date('h:i A', strtotime($jobDatas->created_at)) }}</td>
                    {{-- <td>{{ $jobDatas->totaldays }}</td> --}}
                    @if (Auth::user()->role_id == 11)
                        @if (isset($jobDatas->dayscount) && $jobDatas->dayscount != 0)
                            <td>{{ $jobDatas->dayscount }}</td>
                        @else
                            <td>{{ $jobDatas->totaldays }}</td>
                        @endif
                    @else
                        <td>{{ $jobDatas->totaldays }}</td>
                    @endif
                    <td>{{ $jobDatas->totaltime }}</td>
                    {{-- <td>{{ $jobDatas->partnername }}</td> --}}
            @endforeach
        </tbody>
    </table>
    {{-- *   --}}
    @foreach ($get_date as $jobDatas)
    @if (!in_array($jobDatas->staffcode, $displayedValues))
        <option value="{{ $jobDatas->teamid }}">
            {{ $jobDatas->team_member }}(
            {{ $jobDatas->newstaff_code ?? ($jobDatas->staffcode ?? '') }})
        </option>
        @php
            $displayedValues[] = $jobDatas->staffcode;
        @endphp
    @endif
@endforeach
@php
    $teammemberDatas = Teammember::with(['title', 'role'])
->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
->where('teammembers.role_id', '!=', 11)
->where('teammembers.status', 1)
->select('teammembers.*', 'teamrolehistory.newstaff_code')
->get();
@endphp
->leftJoin('teamrolehistory', function ($join) {
    $join->on('teamrolehistory.teammember_id', '=', 'teammembers.id')
      ->on('teamrolehistory.created_at', '<', 'timesheetreport.created_at');
  })

    http://127.0.0.1:8000/examleaverequestlist
    @php

    $leadpartner = DB::table('teammembers')
        ->leftJoin(
            'teamrolehistory',
            'teamrolehistory.teammember_id',
            '=',
            'teammembers.id',
        )
        ->where('teammembers.id', $assignmentmappingDatas->leadpartner)
        ->select(
            'teammembers.team_member',
            'teammembers.staffcode',
            'teamrolehistory.newstaff_code',
        )
        ->first();

    $otherPartner = DB::table('teammembers')
        ->leftJoin(
            'teamrolehistory',
            'teamrolehistory.teammember_id',
            '=',
            'teammembers.id',
        )
        ->where('teammembers.id', $assignmentmappingDatas->otherpartner)
        ->select(
            'teammembers.team_member',
            'teammembers.staffcode',
            'teamrolehistory.newstaff_code',
        )
        ->first();

@endphp

<td>
    {{ $leadpartner->team_member ?? '' }}
    @if ($leadpartner && $leadpartner->team_member)
        (
        {{ $leadpartner->newstaff_code ?? ($leadpartner->staffcode ?? '') }})
    @endif
</td>
<td>
    {{ $otherPartner->team_member ?? '' }}
    @if ($otherPartner && $otherPartner->team_member)
        (
        {{ $otherPartner->newstaff_code ?? ($otherPartner->staffcode ?? '') }})
    @endif
</td>

<td>
    {{ $teammemberData->newstaff_code ?? ($teammemberData->staffcode ?? '') }}
</td>
    {{-- *   --}}

    @php
    $permotioncheck = DB::table('teamrolehistory')
        ->where('teammember_id', $applyleaveDatas->createdby)
        ->first();

    $datadate = Carbon\Carbon::createFromFormat(
        'Y-m-d H:i:s',
        $applyleaveDatas->created_at,
    );

    $permotiondate = null;
    if ($permotioncheck) {
        $permotiondate = Carbon\Carbon::createFromFormat(
            'Y-m-d H:i:s',
            $permotioncheck->created_at,
        );
    }


    $permotioncheck = DB::table('teamrolehistory')
                                            ->where('teammember_id', $timesheetDatas->createdby)
                                            ->first();

                                        $datadate = Carbon\Carbon::createFromFormat('Y-m-d', $timesheetDatas->date);

                                        $permotiondate = null;
                                        if ($permotioncheck) {
                                            $permotiondate = Carbon\Carbon::createFromFormat(
                                                'Y-m-d H:i:s',
                                                $permotioncheck->created_at,
                                            );
                                        }
@endphp
@php

                                        $permotioncheck = DB::table('teamrolehistory')
                                            ->where('teammember_id', $timesheetDatas->createdby)
                                            ->first();

                                        $datadate = Carbon\Carbon::createFromFormat('Y-m-d', $timesheetDatas->date);
                                        dd($datadate);

                                        $permotiondate = null;
                                        if ($permotioncheck) {
                                            $permotiondate = Carbon\Carbon::createFromFormat(
                                                'Y-m-d H:i:s',
                                                $permotioncheck->created_at,
                                            );
                                        }

                                    @endphp

@if ($permotioncheck && $datadate->greaterThan($permotiondate))
    <td>{{ $permotioncheck->newstaff_code }}</td>
@else
    <td>{{ $applyleaveDatas->staffcode }}</td>
@endif

    {{-- * regarding staff code / regarding promotion   --}}
    @php

    $permotioncheck = DB::table('teamrolehistory')
        ->where('teammember_id', $timesheetDatas->createdby)
        ->first();

    $timesheetdate = Carbon\Carbon::createFromFormat(
        'Y-m-d',
        $timesheetDatas->date,
    );
    $assignmentcreateddate = Carbon\Carbon::createFromFormat(
        'Y-m-d H:i:s',
        $timesheetDatas->assignmentcreated,
    );

    $permotiondate = null;
    if ($permotioncheck) {
        $permotiondate = Carbon\Carbon::createFromFormat(
            'Y-m-d H:i:s',
            $permotioncheck->created_at,
        );
    }

@endphp
    {{-- *   --}}
    {{-- *   --}}
    {{-- *   --}}
    {{-- *   --}}
    {{-- *   --}}
    {{-- *   --}}
    {{-- *   --}}
    {{-- *   --}}
    {{-- *   --}}
    {{-- *   --}}
    {{-- *   --}}
    {{-- *   --}}
    {{-- *   --}}
    {{-- *   --}}
    {{-- *   --}}
    {{-- *   --}}
    http://127.0.0.1:8000/mytimesheetlist/868
    {{-- *   --}}


@if ($permotioncheck && $datadate->greaterThan($permotiondate))
    <td>{{ $permotioncheck->newstaff_code }}</td>
@else
    <td>{{ $applyleaveDatas->staffcode }}</td>
@endif

@php
$permotioncheck = DB::table('teamrolehistory')
    ->where('teammember_id', auth()->user()->teammember_id)
    ->first();

$datadate = Carbon\Carbon::createFromFormat(
    'Y-m-d H:i:s',
    $timesheetrequestsData->created_at,
);
$permotiondate = Carbon\Carbon::createFromFormat(
    'Y-m-d H:i:s',
    $permotioncheck->created_at,
);
@endphp
    {{-- *   --}}
    http://127.0.0.1:8000/assignmentmapping
    $timesheetrequestsDatas = $timesheetrequestsDatas1->merge($timesheetrequestspermotion);
    <td>{{ $applyleaveDatas->newstaff_code ?? $applyleaveDatas->staffcode }}
    </td>
    <td>
        {{ $teammemberData->newstaff_code ?? ($teammemberData->staffcode ?? '') }}
    </td>

    @php
    $permotioncheck = DB::table('teamrolehistory')
        ->where('teammember_id', $partnerData->id)
        ->first();
        <td>
    {{ $permotioncheck->newstaff_code ?? ($partnerData->staffcode ?? '') }}
</td>

@endphp
    {{-- *   --}}

    @php
                    $teammemberDatas = Teammember::with(['title', 'role'])
                ->leftJoin('teamrolehistory as createdby_history', 'createdby_history.teammember_id', '=', 'teammembers.id')
                ->where('teammembers.role_id', '!=', 11)
                ->where('teammembers.status', 1)
                ->select('teammembers.*', 'createdby_history.newstaff_code')
                ->get();

                $teammemberDatas = Teammember::with(['title', 'role'])
                ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
                ->where('teammembers.role_id', '!=', 11)
                ->where('teammembers.status', 1)
                ->select('teammembers.*', 'teamrolehistory.newstaff_code')
                ->get();


                $permotioncheck = DB::table('teamrolehistory')
            ->where('teammember_id', auth()->user()->teammember_id)->first();

        if (auth()->user()->role_id == 11 || auth()->user()->role_id == 18) {
            $timesheetrequestsDatas = DB::table('timesheetrequests')
                ->leftjoin('clients', 'clients.id', 'timesheetrequests.client_id')
                ->leftjoin('assignments', 'assignments.id', 'timesheetrequests.assignment_id')
                ->leftjoin('teammembers', 'teammembers.id', 'timesheetrequests.partner')
                ->leftjoin('teammembers as createdby', 'createdby.id', 'timesheetrequests.createdby')
                ->where('timesheetrequests.status', 0)
                ->select(
                    'timesheetrequests.*',
                    'clients.client_name',
                    'assignments.assignment_name',
                    'teammembers.team_member',
                    'teammembers.staffcode',
                    'createdby.team_member as createdbyauth',
                    'createdby.staffcode as staffcodeid',
                )->get();
            // dd($timesheetrequestsDatas);
        } elseif ($permotioncheck && auth()->user()->role_id == 13) {
            // Define the common parts of the query
            $commonQuery = DB::table('timesheetrequests')
                ->leftJoin('clients', 'clients.id', '=', 'timesheetrequests.client_id')
                ->leftJoin('assignments', 'assignments.id', '=', 'timesheetrequests.assignment_id')
                ->leftJoin('teammembers', 'teammembers.id', '=', 'timesheetrequests.partner')
                ->leftJoin('teammembers as createdby', 'createdby.id', '=', 'timesheetrequests.createdby')
                ->where('timesheetrequests.status', 0)
                ->where(function ($query) {
                    $query->where('timesheetrequests.partner', auth()->user()->teammember_id)
                        ->orWhere('timesheetrequests.createdby', auth()->user()->teammember_id);
                })
                ->select(
                    'timesheetrequests.*',
                    'clients.client_name',
                    'assignments.assignment_name',
                    'teammembers.team_member',
                    'teammembers.staffcode',
                    'createdby.team_member as createdbyauth'
                );

            // Get the timesheet requests before and after the promotion date
            $timesheetrequestsDatas1 = (clone $commonQuery)
                ->whereDate('timesheetrequests.created_at', '<', $permotioncheck->created_at)
                ->addSelect('createdby.staffcode as staffcodeid')
                ->get();

            $timesheetrequestspermotion = (clone $commonQuery)
                ->leftJoin('teamrolehistory as createdby_history', 'createdby_history.teammember_id', '=', 'createdby.id')
                ->whereDate('timesheetrequests.created_at', '>', $permotioncheck->created_at)
                ->addSelect('createdby_history.newstaff_code')
                ->get();

            $timesheetrequestsDatas = $timesheetrequestsDatas1->merge($timesheetrequestspermotion);
        } else {
            $timesheetrequestsDatas = DB::table('timesheetrequests')
                ->leftjoin('clients', 'clients.id', 'timesheetrequests.client_id')
                ->leftjoin('assignments', 'assignments.id', 'timesheetrequests.assignment_id')
                ->leftjoin('teammembers', 'teammembers.id', 'timesheetrequests.partner')
                ->leftjoin('teammembers as createdby', 'createdby.id', 'timesheetrequests.createdby')
                ->where('timesheetrequests.status', 0)
                ->where(function ($query) {
                    $query->where('timesheetrequests.partner', auth()->user()->teammember_id)
                        ->orWhere('timesheetrequests.createdby', auth()->user()->teammember_id);
                })
                ->select(
                    'timesheetrequests.*',
                    'clients.client_name',
                    'assignments.assignment_name',
                    'teammembers.team_member',
                    'teammembers.staffcode',
                    'createdby.team_member as createdbyauth',
                    'createdby.staffcode as staffcodeid',
                )->get();
        }
    @endphp
    {{-- *   --}}
    @if (Request::is('teammember/*/edit'))
    <div class="card">
        <div class="card-header" style="background: #37A000;margin-top: -17px;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 style="color: white" class="fs-17 font-weight-600 mb-0">Promotion Details</h6>
                </div>
            </div>
        </div>

        <div class="row row-sm mt-3" style="margin: 14px;">
            <div class="col-6">
                <div class="form-group">
                    <label class="font-weight-600">Promotion Date</label>
                    <input type="date" name="promotion_date" value="" class="form-control"
                        placeholder="Enter Promotion Date">
                    {{-- {{ $teammember->joining_date ?? '' }} --}}
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="font-weight-600">Designation</label>
                    <select class="form-control" name="designationtype">
                        <option disabled style="display:block">Please Select One</option>
                        @foreach ($teamrole as $teamroleData)
                            <option value="{{ $teamroleData->id }}"
                                {{ $teammember->role->id == $teamroleData->id ?? '' ? 'selected="selected"' : '' }}>
                                {{ $teamroleData->rolename }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
@endif
    public function timesheetEdit1(Request $request)
    timesheeteditonchange(Request $request)
    {
      if ($request->ajax()) {
        // dd(auth()->user()->id);
        if (isset($request->cid)) {
          if (auth()->user()->role_id == 13) {
            echo "<option>Select Assignment</option>";
            foreach (DB::table('assignmentbudgetings')->where('client_id', $request->cid)
              ->where('created_by', auth()->user()->id)
              ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
              ->orderBy('assignment_name')->get() as $sub) {
              echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentgenerate_id . ' )' . "</option>";
            }
          } else {
            echo "<option>Select Assignment</option>";
            foreach (DB::table('assignmentbudgetings')
              ->join('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
              ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
              ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
              ->where('assignmentbudgetings.client_id', $request->cid)
              ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
              ->orderBy('assignment_name')->get() as $sub) {
              echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentgenerate_id . ' )' . "</option>";
            }
          }
        }
        if (isset($request->assignment)) {
  
          if (auth()->user()->role_id == 11) {
            echo "<option value=''>Select Partner</option>";
            foreach (DB::table('assignmentmappings')
  
              ->leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
              ->leftjoin('teammembers as team', 'team.id', 'assignmentmappings.otherpartner')
              ->where('assignmentmappings.assignmentgenerate_id', $request->assignment)
              ->select('team.team_member as team_member', 'team.id', 'teammembers.id', 'teammembers.team_member')
              ->get() as $subs) {
              echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
            }
          } elseif (auth()->user()->role_id == 13) {
            echo "<option value=''>Select Partner</option>";
            foreach (DB::table('teammembers')
              ->where('id', auth()->user()->teammember_id)
              ->select('teammembers.id', 'teammembers.team_member')
              ->get() as $subs) {
              echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
            }
          } else {
            //die;
            echo "<option value=''>Select Partner</option>";
            foreach (DB::table('assignmentmappings')
  
              ->leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
              ->leftjoin('teammembers as team', 'team.id', 'assignmentmappings.otherpartner')
              ->where('assignmentmappings.assignmentgenerate_id', $request->assignment)
              ->select('team.team_member as team_member', 'team.id', 'teammembers.id', 'teammembers.team_member')
              ->get() as $subs) {
              echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
            }
          }
        }
      }
    }
    {{-- *   --}}
    else {
        // echo "<option>Select Assignment</option>";
        foreach (DB::table('assignmentbudgetings')
          ->join('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
          ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
          ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
          ->where('assignmentbudgetings.client_id', $request->cid)
          ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
          ->orderBy('assignment_name')->get() as $sub) {
          echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentgenerate_id . ' )' . "</option>";
        }
      }
    {{-- *   --}}






    documentatiosn me teammeber list ka code upload karna hai 
    controller me code bhi change kiya tha 
    {{-- *   --}}
    create(Request $request)

    timesheetEdit(Request $request, $id)
    {{-- *   --}}
    <table class="table display table-bordered table-striped table-hover ">
        <thead>
            <tr>
                <th>Name</th>
                <th>Staff Code</th>
                <th>Role</th>
                <th>Mobile No</th>
                <th>Total Hour</th>
                <th>Patner</th>
                @if (auth()->user()->role_id == 13 || auth()->user()->role_id == 11)
                    <th>Status</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @php
                $hasData = false;
            @endphp
            @foreach ($teammemberDatas as $teammemberData)
                @if ($teammemberData->viewerteam == 0)
                    @php
                        $hasData = true;
                    @endphp
                    <tr>
                        {{-- @php
                            dd($teammemberData);
                            $totalhour = DB::table('timesheetusers')
                                ->leftJoin(
                                    'teammembers',
                                    'teammembers.id',
                                    'timesheetusers.createdby',
                                )
                                ->where(
                                    'timesheetusers.assignmentgenerate_id',
                                    $teammemberData->assignmentgenerateid,
                                )
                                ->where('timesheetusers.createdby', $teammemberData->id)
                                ->select(DB::raw('SUM(totalhour) as total_hours'))
                                ->first();

                            $patnername = DB::table('assignmentmappings')
                                ->leftJoin(
                                    'teammembers',
                                    'teammembers.id',
                                    'assignmentmappings.leadpartner',
                                )
                                ->where(
                                    'assignmentgenerate_id',
                                    $teammemberData->assignmentgenerateid,
                                )
                                ->select('teammembers.team_member')
                                ->first();
                        @endphp --}}
                        <td>{{ $teammemberData->title }}
                            {{ $teammemberData->team_member }}

                        </td>
                        <td>{{ $teammemberData->staffcode }}
                        </td>
                        <td>
                            @if ($teammemberData->type == 0)
                                <span>Team Leader</span>
                            @else
                                <span>Staff</span>
                            @endif
                        </td>
                        <td><a
                                href="tel:={{ $teammemberData->mobile_no }}">{{ $teammemberData->mobile_no }}</a>
                        </td>
                        {{-- <td>{{ $totalhour->total_hours ?? 0 }}</td> --}}
                        {{-- <td>{{ $patnername->team_member }}</td> --}}
                        <td>{{ $teammemberData->teamhour ?? 0 }}</td>
                        </td>
                        <td>{{ App\Models\Teammember::select('team_member')->where('id', $teammemberData->leadpartner)->first()->team_member ?? '' }}
                        </td>
                        @if (auth()->user()->role_id == 13 || auth()->user()->role_id == 11)
                            <td>
                                @if ($teammemberData->assignmentteammappingsStatus == 0)
                                    <a href="{{ url('/assignment/reject/' . $teammemberData->assignmentteammappingsId . '/1/' . $teammemberData->id) }}"
                                        onclick="return confirm('Are you sure you want to Active this teammember?');">
                                        <button class="btn btn-danger" data-toggle="modal"
                                            style="height: 16px; width: auto; border-radius: 7px; display: flex; align-items: center; justify-content: center;font-size: 11px;"
                                            data-target="#requestModal">Inactive</button>
                                    </a>
                                @else
                                    <a href="{{ url('/assignment/reject/' . $teammemberData->assignmentteammappingsId . '/0/' . $teammemberData->id) }}"
                                        onclick="return confirm('Are you sure you want to Inactive this teammember?');">
                                        <button class="btn btn-primary" data-toggle="modal"
                                            style="height: 16px; width: auto; border-radius: 7px; display: flex; align-items: center; justify-content: center;font-size: 11px;"
                                            data-target="#requestModal">Active</button>
                                    </a>
                                @endif
                            </td>
                        @endif
                    </tr>
                @endif
            @endforeach
            @if (!$hasData)
                <tr>
                    <td colspan="7" style="text-align: center;">Data not available</td>
                </tr>
            @endif
        </tbody>
    </table>
    {{-- *   --}}
    <div class="card-body">
        <div class="card-head">
            <b>Assignment Viewer:</b>
            {{-- @if (auth()->user()->role_id != 15)
                <b><a data-toggle="modal" data-target="#exampleModal14"
                        class="btn btn-info-soft btn-sm">
                        <i class="fa fa-plus"></i>
                    </a>
                </b>
            @endif --}}
        </div>

        <hr>
        <div class="table-responsive example">
            <table class="table display table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Staff Code</th>
                        <th>Role</th>
                        <th>Mobile No</th>
                        <th>Patner</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $hasData = false;
                    @endphp
                    @foreach ($teammemberDatas as $teammemberData)
                        @if ($teammemberData->viewerteam == 1)
                            @php
                                $hasData = true;
                            @endphp
                            <tr>
                                <td>{{ $teammemberData->title }}
                                    {{ $teammemberData->team_member }}</td>
                                <td>{{ $teammemberData->staffcode }}</td>
                                <td>
                                    @if ($teammemberData->type == 0)
                                        <span>Team Leader</span>
                                    @else
                                        <span>Staff</span>
                                    @endif
                                </td>
                                <td>
                                    <a
                                        href="tel:={{ $teammemberData->mobile_no }}">{{ $teammemberData->mobile_no }}</a>
                                </td>
                                <td>{{ App\Models\Teammember::select('team_member')->where('id', $teammemberData->leadpartner)->first()->team_member ?? '' }}
                                </td>

                            </tr>
                        @endif
                    @endforeach
                    @if (!$hasData)
                        <tr>
                            <td colspan="7" style="text-align: center;">Data not available</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    {{-- *   --}}
   @php
        // Create $from and $to Carbon instances from the request
    $from = Carbon::createFromFormat('Y-m-d', $request->from);
    $to = Carbon::createFromFormat('Y-m-d', $request->to ?? '');

    // Create $softwarermaked Carbon instance
    $softwarermaked = Carbon::createFromFormat('Y-m-d', '2023-09-11');

    // Get the latest timesheet submitted
    $latesttimesheetsubmitted = DB::table('timesheetreport')
      ->where('teamid', auth()->user()->teammember_id)
      ->latest()
      ->first();

    // Check if the latest timesheet submitted is not null
    $latesttimesheetsubmittedformate = null;
    if ($latesttimesheetsubmitted) {
      $latesttimesheetsubmittedformate = Carbon::createFromFormat('Y-m-d', $latesttimesheetsubmitted->enddate);
    }

    // Get the rejected timesheet
    $rejectedtimesheet = DB::table('timesheetusers')
      ->where('createdby', auth()->user()->teammember_id)
      ->where('status', 2)
      ->first();

    // Check if the rejected timesheet is not null
    $rejectedtimesheetformate = null;
    if ($rejectedtimesheet) {
      $rejectedtimesheetformate = Carbon::createFromFormat('Y-m-d', $rejectedtimesheet->date);
    }

    // Debug the $from date
    // dd($from);

    // Check if the rejected timesheet date equals the $from date
    if ($rejectedtimesheetformate && $rejectedtimesheetformate->isSameDay($from)) {
      dd('passed');
      $output = ['msg' => 'You cannot apply leave for Sunday'];
      return back()->with('statuss', $output);
    }

    // If dates are not equal
    dd('passed not');
   @endphp
    {{-- *   --}}

(134, NULL, 'Leave', NULL, NULL, '10091', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '2023-09-20 06:25:19', NULL),

    {{-- *   --}}
    {{-- *   --}}
    {{-- *   --}}
    app\Http\Controllers\ApplyleaveController.php
    index fun 

    
    {{-- *   --}}

    http://127.0.0.1:8000/timesheet


    <th class="textfixed">Client Code</th>
@php
    dd($assignmentmappingDatas);
@endphp
<th>Staff Code</th>

<th>Client Code</th>

<td> {{ $timesheetDatas->staffcode ?? '' }} </td>
    {{-- *   --}}
    $dayOfWeek = date('w', strtotime($selectedDate));
    dd($dayOfWeek);
    if ($selectedDate->format('l') == 'Friday') {


      // $selectedDate = date('Y-m-d', strtotime($request->datepickers));
      // // Get the day of the week (0 for Sunday, 6 for Saturday)
      // $dayOfWeek = date('w', strtotime($selectedDate));
      // if ($dayOfWeek == 6) {
      //   // Get the day of the month
      //   $dayOfMonth = date('j', strtotime($selectedDate));
      //   // Calculate which Saturday of the month it is
      //   $saturdayNumber = ceil($dayOfMonth / 7);
      //   if ($saturdayNumber == 1.0) {
      //     $saturday = '1st Saturday';
      //   } elseif ($saturdayNumber == 2.0) {
      //     $saturday = '2nd Saturday';
      //   } elseif ($saturdayNumber == 3.0) {
      //     $saturday = '3rd Saturday';
      //   } elseif ($saturdayNumber == 4.0) {
      //     $saturday = '4th Saturday';
      //   } elseif ($saturdayNumber == 5.0) {
      //     $saturday = '5th Saturday';
      //   }
      // }

      $dayOfMonth = date('j', strtotime($selectedDate));
      // Calculate which Saturday of the month it is
      dd($dayOfMonth);
      $fridayNumber = ceil($dayOfMonth / 7);


      $clients = DB::table('clients')
        ->whereIn('id', [29, 32, 33, 34])
        ->select('clients.client_name', 'clients.id', 'clients.client_code')
        ->orderBy('client_name', 'ASC')
        ->distinct()->get();
    } else {
      $clients = DB::table('clients')
        ->whereIn('id', [29, 32, 34])
        ->select('clients.client_name', 'clients.id', 'clients.client_code')
        ->orderBy('client_name', 'ASC')
        ->distinct()->get();
    }

    $client = $clientss->merge($clients);
    {{-- *   --}}
    @php
        $selectedDate1 = \DateTime::createFromFormat('d-m-Y', $request->timesheetdate);

if ($selectedDate1->format('l') == 'Saturday') {
    $dayOfMonth = $selectedDate1->format('j');
    $saturdayNumber = ceil($dayOfMonth / 7);

    // Define the client IDs for each Saturday number
    $clientIdsBySaturday = [
        1 => [29, 32, 34],
        2 => [29, 32, 33, 34],
        3 => [29, 32, 34],
        4 => [29, 32, 33, 34],
        5 => [29, 32, 34]
    ];

    // Default to the second role's client IDs
    $clientIds = $clientIdsBySaturday[$saturdayNumber] ?? [];

    // If the user role is 13 and it's the 2nd or 4th Saturday, include extra clients
    if (auth()->user()->role_id != 13) {
        $clientIds = [29, 32, 33, 34];
    }

    $clients = DB::table('clients')
        ->whereIn('id', $clientIds)
        ->select('clients.client_name', 'clients.id', 'clients.client_code')
        ->orderBy('client_name', 'ASC')
        ->distinct()
        ->get();

    $client = $clientss->merge($clients);
}

    @endphp
    {{-- *   --}}
    @php
          // $selectedDate1 = \DateTime::createFromFormat('d-m-Y', $request->timesheetdate);
          $dayOfWeek = $selectedDate1->format('w');
          if ($selectedDate1->format('l') == 'Saturday') {

            $dayOfMonth = $selectedDate1->format('j');

            // Calculate which Saturday of the month it is
            $saturdayNumber = ceil($dayOfMonth / 7);
            // dd($saturdayNumber);
            if (auth()->user()->role_id == 13) {
              if ($saturdayNumber == 1.0) {
                $clients = DB::table('clients')
                  ->whereIn('id', [29, 32, 34])
                  ->select('clients.client_name', 'clients.id', 'clients.client_code')
                  ->orderBy('client_name', 'ASC')
                  ->distinct()->get();
              } elseif ($saturdayNumber == 2.0) {
                $clients = DB::table('clients')
                  ->whereIn('id', [29, 32, 33, 34])
                  ->select('clients.client_name', 'clients.id', 'clients.client_code')
                  ->orderBy('client_name', 'ASC')
                  ->distinct()->get();
              } elseif ($saturdayNumber == 3.0) {
                $clients = DB::table('clients')
                  ->whereIn('id', [29, 32, 34])
                  ->select('clients.client_name', 'clients.id', 'clients.client_code')
                  ->orderBy('client_name', 'ASC')
                  ->distinct()->get();
              } elseif ($saturdayNumber == 4.0) {
                $clients = DB::table('clients')
                  ->whereIn('id', [29, 32, 33, 34])
                  ->select('clients.client_name', 'clients.id', 'clients.client_code')
                  ->orderBy('client_name', 'ASC')
                  ->distinct()->get();
              } elseif ($saturdayNumber == 5.0) {
                $clients = DB::table('clients')
                  ->whereIn('id', [29, 32, 34])
                  ->select('clients.client_name', 'clients.id', 'clients.client_code')
                  ->orderBy('client_name', 'ASC')
                  ->distinct()->get();
              }
            } else {
              if ($saturdayNumber == 1.0) {
                $clients = DB::table('clients')
                ->whereIn('id', [29, 32, 33, 34])
                ->select('clients.client_name', 'clients.id', 'clients.client_code')
                ->orderBy('client_name', 'ASC')
                ->distinct()->get();
              } elseif ($saturdayNumber == 2.0) {
                $clients = DB::table('clients')
                  ->whereIn('id', [29, 32, 33, 34])
                  ->select('clients.client_name', 'clients.id', 'clients.client_code')
                  ->orderBy('client_name', 'ASC')
                  ->distinct()->get();
              } elseif ($saturdayNumber == 3.0) {
                $clients = DB::table('clients')
                ->whereIn('id', [29, 32, 33, 34])
                ->select('clients.client_name', 'clients.id', 'clients.client_code')
                ->orderBy('client_name', 'ASC')
                ->distinct()->get();
              } elseif ($saturdayNumber == 4.0) {
                $clients = DB::table('clients')
                  ->whereIn('id', [29, 32, 33, 34])
                  ->select('clients.client_name', 'clients.id', 'clients.client_code')
                  ->orderBy('client_name', 'ASC')
                  ->distinct()->get();
              } elseif ($saturdayNumber == 5.0) {
                $clients = DB::table('clients')
                ->whereIn('id', [29, 32, 33, 34])
                ->select('clients.client_name', 'clients.id', 'clients.client_code')
                ->orderBy('client_name', 'ASC')
                ->distinct()->get();
              }
            }
          } else {
            $clients = DB::table('clients')
              ->whereIn('id', [29, 32, 34])
              ->select('clients.client_name', 'clients.id', 'clients.client_code')
              ->orderBy('client_name', 'ASC')
              ->distinct()->get();
          }

          $client = $clientss->merge($clients);
    @endphp
    {{-- *   --}}
    public function entriesupdated(Request $request)
    {{-- *   --}}
    {{-- *   --}}
    {{-- *   --}}
    {{-- *   --}}
    {{-- *   --}}
    {{-- *   --}}
    {{-- *   --}}
    {{-- *   --}}
    {{-- *   --}}
    {{-- * regarding permotion   --}}
    public function open_timesheet($id)
    {

        $permotioncheck = DB::table('teamrolehistory')
            ->where('teammember_id', auth()->user()->teammember_id)->first();

        if (auth()->user()->role_id == 11 || auth()->user()->role_id == 18) {
            $timesheetrequestsDatas = DB::table('timesheetrequests')
                ->leftjoin('clients', 'clients.id', 'timesheetrequests.client_id')
                ->leftjoin('assignments', 'assignments.id', 'timesheetrequests.assignment_id')
                ->leftjoin('teammembers', 'teammembers.id', 'timesheetrequests.partner')
                ->leftjoin('teammembers as createdby', 'createdby.id', 'timesheetrequests.createdby')
                ->where('timesheetrequests.status', 0)
                ->select(
                    'timesheetrequests.*',
                    'clients.client_name',
                    'assignments.assignment_name',
                    'teammembers.team_member',
                    'teammembers.staffcode',
                    'createdby.team_member as createdbyauth',
                    'createdby.staffcode as staffcodeid',
                )->get();
            // dd($timesheetrequestsDatas);
            return view('backEnd.timesheetrequest.index', compact('timesheetrequestsDatas'));
        } elseif ($permotioncheck && auth()->user()->role_id == 13) {
            // $commonQuery = DB::table('timesheetrequests')
            //     ->leftJoin('clients', 'clients.id', '=', 'timesheetrequests.client_id')
            //     ->leftJoin('assignments', 'assignments.id', '=', 'timesheetrequests.assignment_id')
            //     ->leftJoin('teammembers', 'teammembers.id', '=', 'timesheetrequests.partner')
            //     ->leftJoin('teammembers as createdby', 'createdby.id', '=', 'timesheetrequests.createdby')
            //     ->where('timesheetrequests.status', 0)
            //     ->where(function ($query) {
            //         $query->where('timesheetrequests.partner', auth()->user()->teammember_id)
            //             ->orWhere('timesheetrequests.createdby', auth()->user()->teammember_id);
            //     })
            //     ->select(
            //         'timesheetrequests.*',
            //         'clients.client_name',
            //         'assignments.assignment_name',
            //         'teammembers.team_member',
            //         'teammembers.staffcode',
            //         'createdby.team_member as createdbyauth'
            //     );

            // // Get the timesheet requests before the promotion date
            // $timesheetrequestsDatas = (clone $commonQuery)
            //     ->whereDate('timesheetrequests.created_at', '<', $permotioncheck->created_at)
            //     ->addSelect('createdby.staffcode as staffcodeid')
            //     ->get();

            // // Get the timesheet requests after the promotion date
            // $timesheetrequestspermotion = (clone $commonQuery)
            //     ->leftJoin('teamrolehistory as createdby_history', 'createdby_history.teammember_id', '=', 'createdby.id')
            //     ->whereDate('timesheetrequests.created_at', '>', $permotioncheck->created_at)
            //     ->addSelect('createdby_history.newstaff_code')
            //     ->get();

            // return view('backEnd.timesheetrequest.index', compact('timesheetrequestsDatas', 'timesheetrequestspermotion'));

            // Define the common parts of the query
            $commonQuery = DB::table('timesheetrequests')
                ->leftJoin('clients', 'clients.id', '=', 'timesheetrequests.client_id')
                ->leftJoin('assignments', 'assignments.id', '=', 'timesheetrequests.assignment_id')
                ->leftJoin('teammembers', 'teammembers.id', '=', 'timesheetrequests.partner')
                ->leftJoin('teammembers as createdby', 'createdby.id', '=', 'timesheetrequests.createdby')
                ->where('timesheetrequests.status', 0)
                ->where(function ($query) {
                    $query->where('timesheetrequests.partner', auth()->user()->teammember_id)
                        ->orWhere('timesheetrequests.createdby', auth()->user()->teammember_id);
                })
                ->select(
                    'timesheetrequests.*',
                    'clients.client_name',
                    'assignments.assignment_name',
                    'teammembers.team_member',
                    'teammembers.staffcode',
                    'createdby.team_member as createdbyauth'
                );

            // Get the timesheet requests before and after the promotion date
            $timesheetrequestsDatas1 = (clone $commonQuery)
                ->whereDate('timesheetrequests.created_at', '<', $permotioncheck->created_at)
                ->addSelect('createdby.staffcode as staffcodeid')
                ->get();

            $timesheetrequestspermotion = (clone $commonQuery)
                ->leftJoin('teamrolehistory as createdby_history', 'createdby_history.teammember_id', '=', 'createdby.id')
                ->whereDate('timesheetrequests.created_at', '>', $permotioncheck->created_at)
                ->addSelect('createdby_history.newstaff_code')
                ->get();

            $timesheetrequestsDatas = $timesheetrequestsDatas1->merge($timesheetrequestspermotion);

            // dd($timesheetrequestsDatas);
            return view('backEnd.timesheetrequest.index', compact('timesheetrequestsDatas'));

            // return view('backEnd.timesheetrequest.index', [
            //     'timesheetrequestsDatas' => $timesheetrequestsDatas,
            //     'timesheetrequestspermotion' => $timesheetrequestspermotion,
            // ]);
        } else {
            $timesheetrequestsDatas = DB::table('timesheetrequests')
                ->leftjoin('clients', 'clients.id', 'timesheetrequests.client_id')
                ->leftjoin('assignments', 'assignments.id', 'timesheetrequests.assignment_id')
                ->leftjoin('teammembers', 'teammembers.id', 'timesheetrequests.partner')
                ->leftjoin('teammembers as createdby', 'createdby.id', 'timesheetrequests.createdby')
                ->where('timesheetrequests.status', 0)
                ->where(function ($query) {
                    $query->where('timesheetrequests.partner', auth()->user()->teammember_id)
                        ->orWhere('timesheetrequests.createdby', auth()->user()->teammember_id);
                })
                ->select(
                    'timesheetrequests.*',
                    'clients.client_name',
                    'assignments.assignment_name',
                    'teammembers.team_member',
                    'teammembers.staffcode',
                    'createdby.team_member as createdbyauth',
                    'createdby.staffcode as staffcodeid',
                )->get();
            return view('backEnd.timesheetrequest.index', compact('timesheetrequestsDatas'));
        }
    }
    <div class="table-responsive">
        {{-- @if ($timesheetrequestspermotion->isEmpty())
            <table id="examplee" class="display nowrap">
                <thead>
                    <tr>
                        <th style="display: none;">id</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Created By</th>
                        <th>Staff Code</th>
                        <th>Approver</th>
                        <th>Reason</th>
                        <th>Attachment</th>
                        <th>Reason for Reject</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($timesheetrequestsDatas as $timesheetrequestsData)
                        <tr>
                            <td style="display: none;">{{ $timesheetrequestsData->id }}</td>
                            <td>
                                @if ($timesheetrequestsData->status == 0)
                                    <span class="badge badge-pill badge-warning">Created</span>
                                @elseif($timesheetrequestsData->status == 1)
                                    <span class="badge badge-pill badge-success">Approved</span>
                                @else
                                    <span class="badge badge-pill badge-danger">Rejected</span>
                                @endif
                            </td>
                            <td>{{ date('d-m-Y', strtotime($timesheetrequestsData->created_at)) }}</td>
                            <td>{{ date('h:m:s', strtotime($timesheetrequestsData->created_at)) }}</td>
                            <td><a href="{{ url('timesheetrequest/view', $timesheetrequestsData->id) }}">
                                    {{ $timesheetrequestsData->createdbyauth }}</a></td>
                            <td>{{ $timesheetrequestsData->staffcodeid }}</td>
                            <td>{{ $timesheetrequestsData->team_member }}
                                ({{ $timesheetrequestsData->staffcode }})
                            </td>
                            <td style="width: 900px; word-wrap: break-word; white-space: normal;">
                                {{ $timesheetrequestsData->reason }}</td>
                            <td>
                                @if ($timesheetrequestsData && $timesheetrequestsData->attachment)
                                    <a
                                        href="{{ url('backEnd/image/confirmationfile/' . $timesheetrequestsData->attachment) }}">
                                        {{ $timesheetrequestsData->attachment ?? 'NA' }}
                                    </a>
                                @else
                                    {{ 'NA' }}
                                @endif
                            </td>
                            <td>{{ $timesheetrequestsData->remark ?? 'NA' }}</td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif --}}
        {{-- @if ($timesheetrequestspermotion->isNotEmpty()) --}}
        <table id="examplee" class="display nowrap">
            <thead>
                <tr>
                    <th style="display: none;">id</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Created By</th>
                    <th>Staff Code</th>
                    <th>Approver</th>
                    <th>Reason</th>
                    <th>Attachment</th>
                    <th>Reason for Reject</th>
                </tr>
            </thead>
            <tbody>
                {{-- @foreach ([$timesheetrequestspermotion, $timesheetrequestsDatas] as $collection) --}}
                @foreach ([$timesheetrequestspermotion ?? collect(), $timesheetrequestsDatas] as $collection)
                    @foreach ($collection as $timesheetrequestsData)
                        <tr>
                            <td style="display: none;">{{ $timesheetrequestsData->id }}</td>
                            <td>
                                @if ($timesheetrequestsData->status == 0)
                                    <span class="badge badge-pill badge-warning">Created</span>
                                @elseif($timesheetrequestsData->status == 1)
                                    <span class="badge badge-pill badge-success">Approved</span>
                                @else
                                    <span class="badge badge-pill badge-danger">Rejected</span>
                                @endif
                            </td>
                            <td>{{ date('d-m-Y', strtotime($timesheetrequestsData->created_at)) }}</td>
                            <td>{{ date('h:m:s', strtotime($timesheetrequestsData->created_at)) }}</td>
                            <td><a href="{{ url('timesheetrequest/view', $timesheetrequestsData->id) }}">
                                    {{ $timesheetrequestsData->createdbyauth }}</a></td>
                            <td>{{ $timesheetrequestsData->newstaff_code ?? $timesheetrequestsData->staffcodeid }}
                            </td>
                            <td>{{ $timesheetrequestsData->team_member }}
                                ({{ $timesheetrequestsData->staffcode }})
                            </td>
                            <td style="width: 900px; word-wrap: break-word; white-space: normal;">
                                {{ $timesheetrequestsData->reason }}</td>
                            <td>
                                @if ($timesheetrequestsData && $timesheetrequestsData->attachment)
                                    <a
                                        href="{{ url('backEnd/image/confirmationfile/' . $timesheetrequestsData->attachment) }}">
                                        {{ $timesheetrequestsData->attachment ?? 'NA' }}
                                    </a>
                                @else
                                    {{ 'NA' }}
                                @endif
                            </td>
                            <td>{{ $timesheetrequestsData->remark ?? 'NA' }}</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
        {{-- @endif --}}
    </div>
    {{-- *   --}}
    {{-- *   --}}"http://127.0.0.1:8000/assignmentzip/951"
    {{-- *   --}}public\storage\image\task\debtors1.xlsx
    <td><a target="blank"
        href="{{ Storage::disk('s3')->temporaryUrl($foldername->assignmentgenerateid.'/'.$assignmentfolderData->filesname, now()->addMinutes(30)) }}">
        {{$assignmentfolderData->realname ??''}}</a></td>
    {{-- *   --}}
    17-5 se 20-5 tak 
    {{-- *   --}}

    {{-- *   --}}
    @php
          // zip download 
    public function zipfile(Request $request, $assignmentfolder_id)
    {
        if (auth()->user()->role_id == 11) {
            $generateid = DB::table('assignmentfolders')->where('id', $assignmentfolder_id)->first();
            $fileName = DB::table('assignmentfolderfiles')->where('assignmentfolder_id', $assignmentfolder_id)->get();

            $zipFileName = $generateid->assignmentfoldersname . '.zip';

            $zip = new ZipArchive;

            $zip->open($zipFileName, ZipArchive::CREATE | ZipArchive::OVERWRITE);

            foreach ($fileName as $file) {
                // $filePath = Storage::disk('s3')->url($generateid->assignmentgenerateid . '/' . $file->filesname);
                // // $filePath = public_path('storage\app\public\image/task/' . $file->filenameunique);
                // // $filePath = public_path('storage/app/public/image/task/' . $file->filenameunique);
                // $filePath = Storage::disk('public')->path('image/task/' . $file->filenameunique);
                $filePath = storage_path('app/public/image/task/' . $file->filenameunique);
                // dd($filePath);
                $stream = fopen($filePath, 'r');
                if ($stream) {
                    $zip->addFile($stream, $file->filenameunique);
                    fclose($stream);
                } else {
                    return '<h1>File Not Found</h1>';
                }
            }

            $zip->close();

            $headers = [
                'Content-Type' => 'application/zip',
                'Content-Disposition' => 'attachment; filename="' . $zipFileName . '"',
            ];

            // Delete the local zip file after sending
            return response()->stream(
                function () use ($zipFileName) {
                    readfile($zipFileName);
                    unlink($zipFileName);
                },
                200,
                $headers
            );
        } else {

            $generateid = DB::table('assignmentfolders')->where('id', $assignmentfolder_id)->first();
            $fileName = DB::table('assignmentfolderfiles')->where('assignmentfolder_id', $assignmentfolder_id)->get();
            //dd($fileName);

            $zipFileName = $generateid->assignmentfoldersname . '.zip';
            $zip = new ZipArchive;

            if ($zip->open($zipFileName, ZipArchive::CREATE) === TRUE) {
                foreach ($fileName as $file) {
                    // Replace storage_path with S3 access method
                    $filePath = Storage::disk('s3')->get($generateid->assignmentgenerateid . '/' . $file->filesname);

                    if ($filePath) {
                        $zip->addFromString($file->filesname, $filePath);
                    } else {
                        return '<h1>File Not Found</h1>';
                    }
                }

                $zip->close();
            }

            return response()->download($zipFileName)->deleteFileAfterSend(true);
        }
    }

    // public function zipfile(Request $request, $assignmentfolder_id)
    // {

    //     if (auth()->user()->role_id == 11) {
    //         $generateid = DB::table('assignmentfolders')->where('id', $assignmentfolder_id)->first();
    //         $fileName = DB::table('assignmentfolderfiles')->where('assignmentfolder_id', $assignmentfolder_id)->get();

    //         $zipFileName = $generateid->assignmentfoldersname . '.zip';

    //         $zip = new ZipArchive;

    //         $zip->open($zipFileName, ZipArchive::CREATE | ZipArchive::OVERWRITE);

    //         foreach ($fileName as $file) {
    //             // $filePath = Storage::disk('s3')->url($generateid->assignmentgenerateid . '/' . $file->filesname);
    //             // $filePath = public_path('backEnd/image/articlefiles/' . $file->filesname);
    //             $filePath = $file->public_path('public/image/task/' . $file->filesname);
    //             $stream = fopen($filePath, 'r');

    //             if ($stream) {
    //                 $zip->addFile($stream, $file->filesname);
    //                 fclose($stream);
    //             } else {
    //                 return '<h1>File Not Found</h1>';
    //             }
    //         }

    //         $zip->close();

    //         $headers = [
    //             'Content-Type' => 'application/zip',
    //             'Content-Disposition' => 'attachment; filename="' . $zipFileName . '"',
    //         ];

    //         // Delete the local zip file after sending
    //         return response()->stream(
    //             function () use ($zipFileName) {
    //                 readfile($zipFileName);
    //                 unlink($zipFileName);
    //             },
    //             200,
    //             $headers
    //         );
    //     } else {

    //         $generateid = DB::table('assignmentfolders')->where('id', $assignmentfolder_id)->first();
    //         $fileName = DB::table('assignmentfolderfiles')->where('assignmentfolder_id', $assignmentfolder_id)->get();
    //         //dd($fileName);

    //         $zipFileName = $generateid->assignmentfoldersname . '.zip';
    //         $zip = new ZipArchive;

    //         if ($zip->open($zipFileName, ZipArchive::CREATE) === TRUE) {
    //             foreach ($fileName as $file) {
    //                 // Replace storage_path with S3 access method
    //                 // $filePath = Storage::disk('s3')->get($generateid->assignmentgenerateid . '/' . $file->filesname);
    //                 $filePath = $file->public_path('public/image/task/' . $file->filesname);
    //                 if ($filePath) {
    //                     $zip->addFromString($file->filesname, $filePath);
    //                 } else {
    //                     return '<h1>File Not Found</h1>';
    //                 }
    //             }

    //             $zip->close();
    //         }

    //         return response()->download($zipFileName)->deleteFileAfterSend(true);
    //     }
    // }
    @endphp
    {{-- *   --}}

    this is my table <table id="examplee" class="display nowrap">
        <thead>
        <tr>
        <th style="display: none;">id</th>
        @if ($clientList->balanceconfirmationstatus == 1)
        <th><input type="checkbox" id="masterCheckbox" class="check-all"></th>
        @endif
        <th>Unique No.</th>
        <th>Name</th>
        <th class="text-right">
        Amount
        </th>
    <th>Show/Hide</th>
    <th>Year</th>
    <th>Date</th>
    <th>Address</th>
    <th>Primary Email</th>
    <th>Secondary Email</th>
    <th>Entity Name</th>
    <th>Email Status</th>
    <th>Confirmation Status</th>
    <th>Created By</th>
    <th>Remark</th>
    <th>Amount</th>
    <th>Attachment</th>
    <th>Edit</th>
    <th>Delete</th>
</tr>
</thead>
<tbody>
@foreach ($clientdebit as $clientdebitdata)
    <tr>
        <td style="display: none;">{{ $clientdebitdata->id }}</td>

        @if ($clientList->balanceconfirmationstatus == 1)
            <td>
                @if ($clientdebitdata->status == 2)
                    <input style="font-size:4px;" type="checkbox" name="approve[]"
                        value="{{ $clientdebitdata->id }}">
                @else
                @endif
            </td>
        @endif
        <td>{{ $clientdebitdata->unique }}</td>
        <td>{{ ucfirst($clientdebitdata->name) }}</td>
        <td class="text-right">
            {{ $clientdebitdata->amount }}
        </td>
       
        @if ($clientdebitdata->amounthidestatus == 1)
            <td>Show</td>
        @else
            <td>Hide</td>
        @endif
        <td>{{ $clientdebitdata->year }}</td>
        @if ($clientdebitdata->date != null)
            {{-- <td>{{ date('F d,Y', strtotime($clientdebitdata->date)) }}</td> --}}
            <td>{{ \Carbon\Carbon::createFromFormat('d/m/Y', $clientdebitdata->date)->format('F d, Y') }}
            </td>
        @else
            <td></td>
        @endif
        <td>{{ $clientdebitdata->address }}</td>
        <td><a
                href="mail:={{ $clientdebitdata->email }}">{{ $clientdebitdata->email }}</a>
        </td>
        <td><a
                href="mail:={{ $clientdebitdata->secondaryemail }}">{{ $clientdebitdata->secondaryemail }}</a>
        </td>
        <td>{{ $clientdebitdata->entityname }}</td>
        <td>
            @if ($clientdebitdata->mailstatus == 1)
                <span>Sent</span>
            @elseif($clientdebitdata->mailstatus == 2)
                <span>Failed</span>
            @else
                <span>Not Sent</span>
            @endif
        </td>
        <td>
            @if ($clientdebitdata->status == 0)
                <span class="badge badge-pill badge-danger">Not Confirmed</span>
            @elseif($clientdebitdata->status == 2)
                <span class="badge badge-pill badge-Warning">Draft</span>
            @elseif($clientdebitdata->status == 3)
                <span class="badge badge-pill badge-info">Pending</span>
            @else
                <span class="badge badge-pill badge-success">Confirmed</span>
            @endif
            @if ($clientList->balanceconfirmationstatus == 1)
                @if ($clientdebitdata->status == 3)
                    <a class="editCompanyyyy hide-on-closed" data-toggle="modal"
                        data-id="{{ $clientdebitdata->id }}"
                        data-target="#exampleModal1121{{ $loop->index }}"
                        title="Send Reminder">
                        <span class="typcn typcn-bell"
                            style="font-size: large;color: green;"></span>
                    </a>
                @endif
            @endif
            {{-- asa request reminder modal --}}
            <div class="modal fade" id="exampleModal1121{{ $loop->index }}"
                tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="background: #218838;">
                            <h5 style="color:white;"
                                class="modal-title font-weight-600"
                                id="exampleModalLabel4">Send
                                Reminder
                                list</h5>
                            <div>
                                <ul>
                                    @foreach ($errors->all() as $e)
                                        <li style="color:red;">{{ $e }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <button type="button" class="close"
                                data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table id="reminderTable"
                                    class="table display table-bordered table-striped table-hover">
                                    <thead>
                                        <tr style="background-color: #b6acae;">
                                            <th>Reminder Count</th>
                                            <th>Last Reminder Date</th>
                                        </tr>
                                    </thead>
                                    <tbody id="timesheetTableBody">
                                        {{-- resources\views\backEnd\assignmentconfirmation\30index.blade.php --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="{{ url('assignmentpending/mail', $clientdebitdata->id) }}"
                                class="btn btn-success sendReminderBtn"
                                onclick="return confirm('Are you sure you want to send notification?');">
                                Send
                                Notification</a>
                        </div>

                    </div>
                </div>
            </div>
        </td>
        <td>{{ $clientdebitdata->debtorcreatedby->team_member ?? '' }}</td>
        <td>{{ $clientdebitdata->debtorconfirm->remark ?? '' }}</td>
        <td>{{ $clientdebitdata->debtorconfirm->amount ?? '' }}</td>
        <td> <a target="blank"
                href="{{ optional($clientdebitdata->debtorconfirm)->file
                    ? url('/backEnd/image/confirmationfile/' . $clientdebitdata->debtorconfirm->file)
                    : '' }}">
                {{ optional($clientdebitdata->debtorconfirm)->file ?? '' }}
            </a></td>
        <td>
            @if ($clientList->balanceconfirmationstatus == 1)
                @if ($clientdebitdata->mailstatus == 0)
                    <a href="{{ url('/entriesedit/' . $clientdebitdata->id) }}"
                        class="btn btn-info-soft btn-sm hide-on-closed"><i
                            class="far fa-edit"></i></a>
                @endif
            @endif
        </td>
        <td>
            @if ($clientList->balanceconfirmationstatus == 1)
               
                @if ($clientdebitdata->mailstatus == 0)
                    <a href="{{ url('/entries/destroy/' . $clientdebitdata->id) }}"
                        onclick="return confirm('Are you sure you want to delete this confirmation task?\nName: {{ $clientdebitdata->name }}\nEmail: {{ $clientdebitdata->email }}');"
                        class="btn btn-danger-soft btn-sm hide-on-closed">
                        <i class="far fa-trash-alt"></i>
                    </a>
                @endif
            @endif
        </td>
    </tr>
@endforeach
</tbody>
</table>   mai chahta hu ki ager is table ko right side scroll karu to  ye column freeze ho jaye   <th style="display: none;">id</th>
    @if ($clientList->balanceconfirmationstatus == 1)
        <th><input type="checkbox" id="masterCheckbox" class="check-all"></th>
    @endif
    <th>Unique No.</th>
    <th>Name</th>
    <th class="text-right">
        Amount
    </th>

    {{-- *   --}}
    @php
            public function confirmationotpsend(Request $request)
    {
        // dd($request);
        $assignment = DB::table('assignmentmappings')
            ->where('assignmentmappings.assignmentgenerate_id', $request->assignmentid)
            ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
            ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
            ->select('assignmentmappings.*', 'assignmentbudgetings.balanceconfirmationstatus', 'assignmentbudgetings.status', 'assignmentbudgetings.assignmentname', 'clients.client_name', 'clients.client_code')
            ->first();

        $teammembers = DB::table('teammembers')
            ->where('id', $assignment->leadpartner)
            ->select('team_member', 'emailid',)
            ->first();

        // dd($assignment->balanceconfirmationstatus);
        // // closed balance confirm
        if ($request->status == 0) {

            if ($assignment->status == 0) {
                $otpsuccessmessage = 'Your assignment is closed, so you cannot close the balance confirmation';
                return response()->json([
                    'otpsuccessmessage' => $otpsuccessmessage,
                    'status' => 1,
                ]);
            }

            if ($assignment->balanceconfirmationstatus == 0) {
                $otpsuccessmessage = 'Your balance confirmation is already close.';
                return response()->json([
                    'otpsuccessmessage' => $otpsuccessmessage,
                    'status' => 1,
                ]);
            }

            $otp = sprintf("%06d", mt_rand(1, 999999));
            DB::table('assignmentbudgetings')
                ->where('assignmentgenerate_id', $request->assignmentid)->update([
                    'balanceconfirmationotp'  => $otp,
                ]);

            $data = array(
                'asassignmentsignmentid' => $assignment->assignmentgenerate_id,
                'assignmentname' => $assignment->assignmentname,
                'client_name' => $assignment->client_name,
                'client_code' => $assignment->client_code,
                'email' => $teammembers->emailid,
                'otp' => $otp,
                'name' => $teammembers->team_member,
                'status' => $request->status,
            );

            Mail::send('emails.balanceconfrmclosed', $data, function ($msg) use ($data, $assignment) {
                $msg->to($data['email']);
                $msg->subject('Balance Confirmation Closed by OTP' . ' || ' . $assignment->assignmentgenerate_id);
            });

            $otpsuccessmessage = 'We have sent otp on mail to close the balance confirmation';
            return response()->json([
                'otpsuccessmessage' => $otpsuccessmessage,
                'status' => $request->status,
            ]);
        }
        // open balance confirm
        else {

            if ($assignment->status == 0) {
                $otpsuccessmessage = 'Your assignment is closed, so you cannot open the balance confirmation';
                return response()->json([
                    'otpsuccessmessage' => $otpsuccessmessage,
                    'status' => 0,
                ]);
            }
            if ($assignment->balanceconfirmationstatus == 1) {
                $otpsuccessmessage = 'Your balance confirmation is already open.';
                return response()->json([
                    'otpsuccessmessage' => $otpsuccessmessage,
                    'status' => 0,
                ]);
            }
            $otp = sprintf("%06d", mt_rand(1, 999999));
            DB::table('assignmentbudgetings')
                ->where('assignmentgenerate_id', $request->assignmentid)->update([
                    'balanceconfirmationotp'  => $otp,
                ]);

            $data = array(
                'asassignmentsignmentid' => $assignment->assignmentgenerate_id,
                'assignmentname' => $assignment->assignmentname,
                'client_name' => $assignment->client_name,
                'client_code' => $assignment->client_code,
                'email' => $teammembers->emailid,
                'otp' => $otp,
                'name' => $teammembers->team_member,
                'status' => $request->status,
            );

            Mail::send('emails.balanceconfrmclosed', $data, function ($msg) use ($data, $assignment) {
                $msg->to($data['email']);
                $msg->subject('Balance Confirmation Opend by OTP' . ' || ' . $assignment->assignmentgenerate_id);
            });

            $otpsuccessmessage = 'We have sent otp on mail to open the balance confirmation';
            return response()->json([
                'otpsuccessmessage' => $otpsuccessmessage,
                'status' => $request->status,
            ]);
        }
    }
    @endphp
    {{-- *   --}}
    $hasPendingRequests = $myteamtimesheetrequestsDatas->contains('status', 0);
    {{-- *   --}}
    $('body').on('click', '#refreshbtn', function(event) {
        location.reload();

    });
    $('body').on('click', '#refreshbtn1', function(event) {
        location.reload();

    });

    //   document.getElementById('refreshbtn').addEventListener('click', function() {
    //       alert('hi');
    //       location.reload();
    //   });

    // Add event listener to the close button to refresh the page
    document.getElementById('refreshbtn').addEventListener('click', function() {
        alert('hi');
        location.reload();
    });
    {{-- *   --}}
    resources\views\backEnd\assignmentconfirmation\editentries.blade.php
    {{-- *   --}}
    {{-- *   --}}
    +request: Symfony\Component\HttpFoundation\InputBag {#45 ▼
        #parameters: array:4 [▼
          "_method" => "PATCH"
          "_token" => "j6JSM8izhEB2DxTOy9obz5TtOcdbr8cRsP2i1Y5R"
          "status" => "1"
          "leavetype" => "11"
        ]
      }

      "5"
    {{-- *   --}}

    +attributes: Symfony\Component\HttpFoundation\ParameterBag {#46
        #parameters: []
      }
      +request: Symfony\Component\HttpFoundation\InputBag {#52
        #parameters: array:4 [
          "type" => "2"
          "status" => "1"
          "assignmentgenerate_id" => "ABD100411"
          "debitid" => "67"
        ]
      }

      #parameters: array:4 [
        "type" => "2"
        "status" => "1"
        "assignmentgenerate_id" => "ABD100411"
        "debitid" => "67"
      ]
    }

    <div>
        <span style="color:white;" class="fs-17 font-weight-600 mb-0">Confirmation:</span>
        <input type="checkbox" id="toggle-status-{{ $clientList->id }}"
            {{ $clientList->balanceconfirmationstatus ? 'checked' : '' }} data-toggle="toggle"
            data-style="ios" data-id="{{ $clientList->id }}" data-on="Open" data-off="Close"
            data-onstyle="info" data-offstyle="danger" onchange="updateConfirmationStatus(this)">
    </div>


    <script>
        function updateConfirmationStatus(checkbox) {
            var assignmentId = "{{ $clientList->assignmentgenerate_id }}";
            var status = checkbox.checked ? 1 : 0;
  
            if (status === 0) {
                // Show modal if closing
                $('#confirmationModal').modal('show');
  
                $.ajax({
                    url: "{{ url('/confirmationotpsend') }}",
                    type: 'GET',
                    data: {
                        assignmentid: assignmentId,
                        status: status
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.status == 0) {
                            $("#otpmessage").text(response.otpsuccessmessage);
                        } else {
                            $("#errormessage").text(response.otpsuccessmessage);
                            $("#verifyBtn").addClass('disable');
                            $("#yesid").hide();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            } else {
                $('#confirmationModal3').modal('show');
                $.ajax({
                    url: "{{ url('/confirmationotpsend') }}",
                    type: 'GET',
                    data: {
                        assignmentid: assignmentId,
                        status: status
                    },
                    success: function(response) {
                        if (response.status == 1) {
                            $("#otpmessage1").text(response.otpsuccessmessage);
                        } else {
                            $("#errormessage1").text(response.otpsuccessmessage);
                            $("#verifyBtn1").addClass('disable');
                            $("#noid").hide();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
        }
    </script>
    {{-- *   --}}
    confirmationauthotpfun
    {{-- *   --}}
    #parameters: array:9 [▼
    "_token" => "FsMadyIdqebgp5oxA1RUjSXB34k8X9l4pfsAXUNo"
    "assignmentgenerate_id" => "ABD100411"
    "status" => "0"
    "otp1" => "2"
    "otp2" => "3"
    "otp3" => "4"
    "otp4" => "5"
    "otp5" => "5"
    "otp6" => "3"
  ]
}
    {{-- *   --}}
    {{-- *   --}}\

    @php
         public function otpapstore(Request $request)
    {
        dd($request);
        try {
            if ($request->status == 1) {
                $otp1 = $request->otp1;
                $otp2 = $request->otp2;
                $otp3 = $request->otp3;
                $otp4 = $request->otp4;
                $otp5 = $request->otp5;
                $otp6 = $request->otp6;

                // Concatenate the OTPs into a single variable
                $otp = $otp1 . $otp2 . $otp3 . $otp4 . $otp5 . $otp6;

                //   $otp = $request->otp;
                $users = DB::table('debtors')->where('id', $request->debitid)->first();

                if ($request->status == $users->status || $users->status == 0) {
                    return back()->withErrors(['error' => 'You have allready Submitted'])->withInput();
                }

                if ($otp == $users->otp) {
                    DB::table('debtors')
                        ->where('assignmentgenerate_id', $request->assignmentgenerate_id)->where('id', $request->debitid)->update([
                            'status'         => $request->status,
                            'otpverifydate' => date('Y-m-d H:i:s'),
                            'updated_at'         =>   date("Y-m-d")
                        ]);

                    return view('backEnd.teamconfirm');
                } else {

                    return redirect()->back()->with('success_message', 'OTP did not match!.');
                }
            } 
            else {
                $otp1 = $request->otp11;
                $otp2 = $request->otp12;
                $otp3 = $request->otp13;
                $otp4 = $request->otp14;
                $otp5 = $request->otp15;
                $otp6 = $request->otp16;


                // Concatenate the OTPs into a single variable
                $otp = $otp1 . $otp2 . $otp3 . $otp4 . $otp5 . $otp6;

                //$otp = $request->otp1;
                $users = DB::table('debtors')->where('id', $request->debitid1)->first();

                if ($request->status1 == $users->status || $users->status == 1) {
                    return back()->withErrors(['error' => 'You have allready Submitted'])->withInput();
                }

                if ($otp == $users->otp) {

                    $debtorconfirm = DB::table('debtorconfirmations')
                        ->where('assignmentgenerate_id', $request->assignmentgenerate_id1)->where('debtor_id', $request->debitid1)->first();

                    $clientid = $request->assignmentgenerate_id1;
                    $debtorid = $request->debitid1;
                    $status = $request->status1;

                    return view('backEnd.assignmentteamreject', compact('status', 'clientid', 'debtorid', 'debtorconfirm'));
                } else {

                    return redirect()->back()->with('success_message', 'OTP did not match!.');
                }
            }
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }
    @endphp
    {{-- *   --}}

    +request: Symfony\Component\HttpFoundation\InputBag {#45 ▼
        #parameters: array:11 [▼
          "_token" => "FsMadyIdqebgp5oxA1RUjSXB34k8X9l4pfsAXUNo"
          "debitid" => null
          "assignmentgenerate_id" => null
          "type" => null
          "status" => null
          "otp1" => "2"
          "otp2" => "2"
          "otp3" => "2"
          "otp4" => "2"
          "otp5" => "2"
          "otp6" => "2"
        ]
      }

      +request: Symfony\Component\HttpFoundation\InputBag {#45 ▼
        #parameters: array:11 [▼
          "_token" => "FsMadyIdqebgp5oxA1RUjSXB34k8X9l4pfsAXUNo"
          "debitid" => "70"
          "assignmentgenerate_id" => "ABD100411"
          "type" => "3"
          "status" => "1"
          "otp1" => "2"
          "otp2" => "2"
          "otp3" => "2"
          "otp4" => "2"
          "otp5" => "2"
          "otp6" => "2"
        ]
      }



    {{-- *   --}}
    @php
        
        public function assignmentotp(Request $request)
  {

    if ($request->ajax()) {
      if (isset($request->id)) {
        // $assignment = DB::table('assignmentmappings')
        //   ->where('assignmentgenerate_id', $request->id)
        //   ->first();

        $assignment = DB::table('assignmentmappings')
          ->where('assignmentmappings.assignmentgenerate_id', $request->id)
          ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
          ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
          ->select('assignmentmappings.*', 'assignmentbudgetings.assignmentname', 'clients.client_name', 'clients.client_code')
          ->first();

        // dd($assignment);

        $assignmentteammember = DB::table('assignmentteammappings')
          ->leftjoin('teammembers', 'teammembers.id', 'assignmentteammappings.teammember_id')
          ->where('assignmentmapping_id', $assignment->id)
          ->select('teammembers.team_member', 'assignmentteammappings.type', 'teammembers.staffcode')
          ->get();

        $teammembers = DB::table('teammembers')
          ->where('id', auth()->user()->teammember_id)
          ->first();

        $otp = sprintf("%06d", mt_rand(1, 999999));

        DB::table('assignmentbudgetings')
          ->where('assignmentgenerate_id', $assignment->assignmentgenerate_id)->update([
            'otp'  => $otp,
          ]);

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

        // dd($data);

        Mail::send('emails.assignmentclosed', $data, function ($msg) use ($data, $assignment) {
          $msg->to($data['email']);
          $msg->subject('Assignment Closed by OTP' . ' || ' . $assignment->assignmentgenerate_id);
        });

        return response()->json($assignment);
      }
    }
  }
    @endphp
    {{-- *   --}}
    <script>
        $(function() {
            $('body').on('click', '#editCompanys', function(event) {
                //        debugger;
                var id = $(this).data('id');
                debugger;
                $.ajax({
                    type: "GET",
    
                    url: "{{ url('assignmentotp') }}",
                    data: "id=" + id,
                    success: function(response) {
                        // alert(res);
                        debugger;
                        $("#assignmentgenerateid").val(response.assignmentgenerate_id);
    
    
                        if (response !== null) {
                            // Show the message that the OTP has been sent to the email
                            $('#otp-message').html('OTP send to your email please check');
                        }
                    },
                    error: function() {
    
                    },
                });
            });
        });
    </script>
    {{-- *   --}}

          <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog"
                          aria-labelledby="exampleModalLabel4" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                              <div class="modal-content " style="border-radius: 3rem;">
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                      style="position: absolute; top: 10px; right: 10px; background-color: rgba(0,0,0,0.1); border-radius: 50%; border: none; padding: 5px;">
                                      <span aria-hidden="true">&times;</span>
                                  </button>

                                  <form id="detailsForm" method="post" action="" enctype="multipart/form-data">
                                      @csrf


                                      <div
                                          style="width: 100%; border-radius: 10px; height: 100%; padding: 16px; background: white; box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.25);  flex-direction: column; justify-content: flex-start; align-items: center; gap: 24px; display: inline-flex ">
                                          <div
                                              style="flex-direction: column; justify-content: flex-start; align-items: center; gap: 16px; display: flex">
                                              <div
                                                  style="flex-direction: column; justify-content: flex-start; align-items: center; gap: 8px; display: flex">
                                                  {{-- <div style="width: 62px; height: 62px; position: relative">
                                                      <div
                                                          style="width: 62px; height: 62px; left: 62px; top: 62px; position: absolute; transform: rotate(-180deg); transform-origin: 0 0; opacity: 0">
                                                      </div>
                                                      <div
                                                          style="width: 46.03px; height: 51.64px; left: 7.98px; top: 5.19px; position: absolute; ">
                                                          <img src="{{ asset('image/security-safe.svg') }}"
                                                              alt="security-safe">
                                                      </div>
                                                  </div> --}}
                                                  <div
                                                      style="color: #292D32; font-size: 24px; font-family: Inter; font-weight: 500; word-wrap: break-word">
                                                      Verification Required</div>

                                              </div>
                                              <div class="details-form-field  row">

                                                  <div class="col-sm-12">

                                                      <input type="hidden" id="debitid" name="debitid"
                                                          class="form-control">
                                                      <input type="hidden" id="assignmentgenerate_id"
                                                          name="assignmentgenerate_id" class="form-control">
                                                      <input type="hidden" id="type" name="type"
                                                          class="form-control">
                                                      <input type="hidden" id="status" name="status"
                                                          class="form-control">
                                                  </div>
                                              </div>

                                              <div
                                                  style="width: 332px; text-align: center; color: rgba(41, 45, 50, 0.65); font-size: 18px; font-family: Inter; font-weight: 400; word-wrap: break-word">
                                                  Please enter the 6-digit OTP sent to your registered
                                                  email address.
                                              </div>
                                          </div>



                                          @if ($errors->any())
                                              <div>
                                                  <ul>
                                                      @foreach ($errors->all() as $e)
                                                          <li style="color:red;">{{ $e }}
                                                          </li>
                                                      @endforeach
                                                  </ul>
                                              </div>
                                          @else
                                          @endif

                                          <div name="otp"
                                              style="flex-direction: column; justify-content: flex-start; align-items: center; gap: 16px; display: flex">
                                              <div
                                                  class="container height-100 d-flex justify-content-center align-items-center">
                                                  <div class="position-relative">
                                                      <div class="col-sm-12">
                                                          <p class="text-success" id="otpmessage">
                                                          </p>
                                                      </div>
                                                      <div class="col-sm-12">
                                                          <p class="text-success" id="otpmessage2">
                                                          </p>
                                                      </div>
                                                      <div id="otp"
                                                          class="inputs d-flex flex-row justify-content-center mt-2">
                                                          <input name="otp1"
                                                              class="m-2 text-center form-control rounded" type="text"
                                                              id="first" maxlength="1" />
                                                          <input name="otp2"
                                                              class="m-2 text-center form-control rounded" type="text"
                                                              id="second" maxlength="1" />
                                                          <input name="otp3"
                                                              class="m-2 text-center form-control rounded" type="text"
                                                              id="third" maxlength="1" />
                                                          <input name="otp4"
                                                              class="m-2 text-center form-control rounded" type="text"
                                                              id="fourth" maxlength="1" />
                                                          <input name="otp5"
                                                              class="m-2 text-center form-control rounded" type="text"
                                                              id="fifth" maxlength="1" />
                                                          <input name="otp6"
                                                              class="m-2 text-center form-control rounded" type="text"
                                                              id="sixth" maxlength="1" />
                                                      </div>

                                                  </div>
                                              </div>
                                              <div style="width: 332px; text-align: center" class="resends"><span
                                                      style="color: rgba(41, 45, 50, 0.85); font-size: 16px; font-family: Inter; font-weight: 300; word-wrap: break-word">Didn’t
                                                      receive the OTP?</span><span
                                                      style="color: rgba(41, 45, 50, 0.85); font-size: 16px; font-family: Inter; font-weight: 500; word-wrap: break-word">
                                                      {{-- <a id="yesid" data-id="{{ $debtorid }}" data-status="1"
                                                          data-resend="true" class="font-weight-500"
                                                          style="color:#37a000;"> Resend</a> --}}
                                                  </span>
                                              </div>
                                          </div>


                                          <div
                                              style="width: 100%; height: 100%;    background: #4071F4; box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.25); border-radius: 4px; justify-content: center; align-items: center; display: inline-flex">
                                              <button style="background: #37A000;" type="submit" class="btn btn-block"
                                                  id="verifyBtn" onclick="return confirm('Are you sure ?');">
                                                  <div
                                                      style="color: white; font-size: 20px; font-family: Inter; font-weight: 500; word-wrap: break-word">
                                                      Verify</div>
                                              </button>
                                          </div>

                                      </div>


                                  </form>
                              </div>
                          </div>
                      </div>
    {{-- *   --}}
    {{-- *   --}}
    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog"
    aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Enter OTP</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="confirmationForm">
                    <div
                        style="width: 100%; border-radius: 10px; height: 100%; padding: 16px; background: white; box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.25);  flex-direction: column; justify-content: flex-start; align-items: center; gap: 24px; display: inline-flex ">
                        <div
                            style="flex-direction: column; justify-content: flex-start; align-items: center; gap: 16px; display: flex">
                            <div
                                style="flex-direction: column; justify-content: flex-start; align-items: center; gap: 8px; display: flex">
                                <div style="width: 62px; height: 62px; position: relative">
                                    <div
                                        style="width: 62px; height: 62px; left: 62px; top: 62px; position: absolute; transform: rotate(-180deg); transform-origin: 0 0; opacity: 0">
                                    </div>
                                    <div
                                        style="width: 46.03px; height: 51.64px; left: 7.98px; top: 5.19px; position: absolute; ">
                                        <img src="{{ asset('image/security-safe.svg') }}"
                                            alt="security-safe">
                                    </div>
                                </div>
                                <div
                                    style="color: #292D32; font-size: 24px; font-family: Inter; font-weight: 500; word-wrap: break-word">
                                    Verification Required</div>

                            </div>
                            <div class="details-form-field  row">

                                <div class="col-sm-12">

                                    <input type="hidden" id="debitid" name="debitid"
                                        class="form-control">
                                    <input type="hidden" id="assignmentgenerate_id"
                                        name="assignmentgenerate_id" class="form-control">
                                    <input type="hidden" id="type" name="type"
                                        class="form-control">
                                    <input type="hidden" id="status" name="status"
                                        class="form-control">
                                </div>
                            </div>

                            <div
                                style="width: 332px; text-align: center; color: rgba(41, 45, 50, 0.65); font-size: 18px; font-family: Inter; font-weight: 400; word-wrap: break-word">
                                Please enter the 6-digit OTP sent to your registered
                                email address.
                            </div>
                        </div>



                        @if ($errors->any())
                            <div>
                                <ul>
                                    @foreach ($errors->all() as $e)
                                        <li style="color:red;">{{ $e }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                        @endif

                        <div name="otp"
                            style="flex-direction: column; justify-content: flex-start; align-items: center; gap: 16px; display: flex">
                            <div
                                class="container height-100 d-flex justify-content-center align-items-center">
                                <div class="position-relative">
                                    <div class="col-sm-12">
                                        <p class="text-success" id="otpmessage">
                                        </p>
                                    </div>
                                    <div class="col-sm-12">
                                        <p class="text-success" id="otpmessage2">
                                        </p>
                                    </div>
                                    <div id="otp"
                                        class="inputs d-flex flex-row justify-content-center mt-2">
                                        <input name="otp1"
                                            class="m-2 text-center form-control rounded"
                                            type="text" id="first" maxlength="1" />
                                        <input name="otp2"
                                            class="m-2 text-center form-control rounded"
                                            type="text" id="second" maxlength="1" />
                                        <input name="otp3"
                                            class="m-2 text-center form-control rounded"
                                            type="text" id="third" maxlength="1" />
                                        <input name="otp4"
                                            class="m-2 text-center form-control rounded"
                                            type="text" id="fourth" maxlength="1" />
                                        <input name="otp5"
                                            class="m-2 text-center form-control rounded"
                                            type="text" id="fifth" maxlength="1" />
                                        <input name="otp6"
                                            class="m-2 text-center form-control rounded"
                                            type="text" id="sixth" maxlength="1" />
                                    </div>

                                </div>
                            </div>
                            <div style="width: 332px; text-align: center" class="resends"><span
                                    style="color: rgba(41, 45, 50, 0.85); font-size: 16px; font-family: Inter; font-weight: 300; word-wrap: break-word">Didn’t
                                    receive the OTP?</span><span
                                    style="color: rgba(41, 45, 50, 0.85); font-size: 16px; font-family: Inter; font-weight: 500; word-wrap: break-word">
                                    {{-- <a id="yesid" data-id="{{ $debtorid }}" data-status="1"
                              data-resend="true" class="font-weight-500"
                              style="color:#37a000;"> Resend</a> --}}
                                </span>
                            </div>
                        </div>


                        <div
                            style="width: 100%; height: 100%;    background: #4071F4; box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.25); border-radius: 4px; justify-content: center; align-items: center; display: inline-flex">
                            <button style="background: #37A000;" type="submit"
                                class="btn btn-block" id="verifyBtn"
                                onclick="return confirm('Are you sure ?');">
                                <div
                                    style="color: white; font-size: 20px; font-family: Inter; font-weight: 500; word-wrap: break-word">
                                    Verify</div>
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
    {{-- *   --}}
    <table id="reminderTable"
    class="table display table-bordered table-striped table-hover">
    <thead>
        <tr style="background-color: #b6acae;">
            <th>No Of Days</th>
            <th>Max Reminder</th>
            <th>Reminder Count</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="timesheetTableBody">
        @if ($autoreminder)
            <tr>
                <td>{{ $autoreminder->noofdays ?? '' }}</td>
                <td>{{ $autoreminder->max_rem ?? '' }}</td>
                <td>{{ $autoreminder->remindcount ?? '' }}</td>
                <td style="text-align: center">
                    <a href="{{ url('/autoreminder/destroy/' . $autoreminder->id) }}"
                        onclick="return confirm('Are you sure you want to delete this auto reminder?');"
                        class="btn btn-dark btn-sm">
                        <i class="far fa-trash-alt"></i>
                    </a>
                </td>
            </tr>
        @else
            <tr>
                <td colspan="4" style="text-align: center">No auto reminder
                    data available</td>
            </tr>
        @endif
    </tbody>
</table>
    {{-- *   --}}
    open
    +request: Symfony\Component\HttpFoundation\InputBag {#52 ▼
        #parameters: array:2 [▼
          "assignmentid" => "ABD100411"
          "status" => "0"
        ]

        closed
        +request: Symfony\Component\HttpFoundation\InputBag {#52 ▼
            #parameters: array:2 [▼
              "assignmentid" => "ABD100411"
              "status" => "1"
            ]
          }
    {{-- *   --}}
      {{-- <div>
                          <span style="color:white;" class="fs-17 font-weight-600 mb-0">
                              Confirmation:</span>
                          @if ($clientList->balanceconfirmationstatus == 1)
                              <a style="color:white;" class="fs-17 font-weight-600 mb-0"
                                  onclick="return confirm('Are you sure ?');"
                                  href="{{ url('/confirmationstatus?' . 'assignmentid=' . $clientList->assignmentgenerate_id . '&&' . 'status=' . 0) }}"><span
                                      class="badge badge-primary">OPEN</span></a>
                          @else
                              <a style="color:white;" class="fs-17 font-weight-600 mb-0"
                                  onclick="return confirm('Are you sure ?');"
                                  href="{{ url('/confirmationstatus?' . 'assignmentid=' . $clientList->assignmentgenerate_id . '&&' . 'status=' . 1) }}">
                                  <span class="badge badge-danger">CLOSED</span></a>
                          @endif
                      </div> --}}

                      <div>
                        <span style="color:white;" class="fs-17 font-weight-600 mb-0">
                            Confirmation:</span>
                        {{-- <input id="toggle" type="checkbox" checked data-toggle="toggle" data-style="ios" data-on="Open"
                            data-off="Close" data-onstyle="info" data-offstyle="danger"> --}}
                        <input type="checkbox" id="toggle-status-{{ $clientList->id }}"
                            {{ $clientList->balanceconfirmationstatus ? 'checked' : '' }} data-toggle="toggle"
                            data-style="ios" data-id="{{ $clientList->id }}" data-on="Open" data-off="Close"
                            data-onstyle="info" data-offstyle="danger">
                    </div>

    {{-- *   --}}
    {{-- *   --}}
     {{-- <form method="POST" action="{{ url('assignmentconfirmation/confirm') }}" enctype="multipart/form-data"> --}}
                    {{-- <form method="POST"
                        action="{{ url('assignmentconfirmation?' . 'clientid=' . $clientid . '&&' . 'debtorid=' . $debtorid . '&&' . 'status=' . $status) }}"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="">
                            <div style="text-align: left;"><span class="text-align-left"
                                    style="color: rgba(41, 45, 50, 0.85); font-size: 14px; font-family: Inter; font-weight: 500; word-wrap: break-word">Enter
                                    Amount </span><span
                                    style="color: #DC3545; font-size: 14px; font-family: Inter; font-weight: 500; word-wrap: break-word">*</span>
                            </div>
                            <input type="number" required name="amount"
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="Eg. ₹ 90,000"><br>
                            <div
                                style=" text-align: left; color: rgba(41, 45, 50, 0.85); font-size: 14px; font-family: Inter; font-weight: 500; word-wrap: break-word">
                                Remarks</div>
                            <input type="hidden" name="clientid"
                                class="form-control @error('email') is-invalid @enderror" value="{{ $clientid }}">
                            <input type="hidden" name="debtorid"
                                class="form-control @error('email') is-invalid @enderror" value="{{ $debtorid }}">
                            <input type="hidden" name="status"
                                class="form-control @error('email') is-invalid @enderror" value="{{ $status }}">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <div class="invalid-feedback text-left">Enter your valid email</div>
                        </div>
                        <div class="form-group">
                            <textarea name="remark" rows="3" class="form-control" placeholder="Add your remarks here"></textarea>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <div class="invalid-feedback text-left">Enter your valid email</div>
                        </div>
                        <div class="form-group">
                            <div
                                style="text-align: left; color: rgba(41, 45, 50, 0.85); font-size: 14px; font-family: Inter; font-weight: 500; word-wrap: break-word">
                                Upload File</div>

                            <div>
                                <input type="file" name="file" id="file-1" class="custom-input-file">
                                <label for="file-1">
                                    <i class="fa fa-upload"></i>
                                    <span>Choose a file…</span>
                                </label>
                            </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        @if ($debtorconfirm == null)
                            <button type="submit" class="btn btn-success btn-block"
                                onclick="return confirm('Are you sure ?');">Submit</button>
                        @endif
                    </form> --}}
    {{-- *   --}}
    confirmationauthotp
    #parameters: array:6 [▼
    "_token" => "24rYyMrC22Yap5NDwHnfgMciE5HWCdLXZF4wFbxt"
    "amount" => "33"
    "clientid" => "ABD100411"
    "debtorid" => "48"
    "status" => "0"
    "remark" => "33"
  ]


  #parameters: array:6 [▼
  "_token" => "24rYyMrC22Yap5NDwHnfgMciE5HWCdLXZF4wFbxt"
  "amount" => "333"
  "clientid" => "ABD100411"
  "debtorid" => "48"
  "status" => "0"
  "remark" => "dddd"
]
    {{-- *   --}}
    <div class="modal" id="rejectModalFinal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Reject Offer Letter Request</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <form id="rejectForm" action="" method="POST" enctype="multipart/form-data">
                        {{-- <form id="rejectForm" action="{{ url('offerletter/statuss', $offerletterData->id) }}"
                        method="POST" enctype="multipart/form-data"> --}}
                        @csrf
                        <div class="form-group">
                            <label for="reason">Reason <span style="color:red;">*</span></label>
                            <textarea class="form-control" name="reject_reason" id="reason" required></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- *   --}}
    <div class="content-wrapper" id="contentdiv">
        <div class="main-content pt-1">
            <div style="float: right; margin-right:80px;margin-top: 4px;" class=" align-items-center">
                @php
                    $otpsettingstatus = 0;
                @endphp
                @if ($otpsettingstatus == 0)
                    {{-- <a href="{{ url('/otpskipconfirmation?' . 'type=' . $debtors->type . '&&' . 'status=' . 1 . '&&' . 'assignmentgenerate_id=' . $debtors->assignmentgenerate_id . '&&' . 'debitid=' . $debtors->id) }}"
                class="btn btn-success">
                Accept
            </a> --}}
                    <a href="#" class="btn btn-success" id="acceptButton">
                        Accept
                    </a>

                    <a href="{{ url('/otpskipconfirmation?' . 'type1=' . $debtors->type . '&&' . 'status1=' . 0 . '&&' . 'assignmentgenerate_id1=' . $debtors->assignmentgenerate_id . '&&' . 'debitid1=' . $debtors->id) }}"
                        class="btn btn-danger">
                        Refuse
                    </a>
                @else
                    <button class="btn btn-success" id="yesid" data-id="{{ $debtorid }}" data-status="1"
                        data-toggle="modal" data-target="#exampleModal1">Accept</button>

                    <button class="btn btn-danger" id="noid" data-id="{{ $debtorid }}" data-status="0"
                        data-toggle="modal" data-target="#exampleModal12">Refuse</button>
                @endif
            </div>

            <div id="printableArea">
                <div class="container py-5 h-100">
                    <div class="row justify-content-center align-items-center h-100">
                        <div class="col-12 col-lg-12 col-xl-12">
                            <div class="card shadow-2-strong card-registration">
                                <div class="card-body p-md-5">
                                    <div class="row">
                                        <div class="col-12  d-flex align-items-center justify-content-center">
                                            <span>
                                                <h2>Balance confirmation</h2>
                                            </span>
                                        </div>
                                        <div class="col-12  d-flex align-items-center justify-content-center">
                                            @if ($errors->any())
                                                <div>
                                                    @foreach ($errors->all() as $e)
                                                        <p style="color:red;">{{ $e }}
                                                        </p>
                                                    @endforeach
                                                </div>
                                            @else
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            {!! $description ?? '' !!}

                                            <p><br /> <span
                                                    style="text-decoration: underline;"><strong>Confirmation</strong></span><br />
                                                <br />
                                                @if ($debtors->amounthidestatus == 1)
                                                    We confirm that in our books of account, the outstanding balance as
                                                    on {{ date('F d,Y', strtotime($debtors->date)) }} is
                                                    <span style="color: #ff6600;">Rs {{ $debtors->amount ?? '' }}</span>
                                                @else
                                                    We request you to provide the
                                                    @if ($debtors->type == 1)
                                                        <span>Debtor</span>
                                                    @elseif($debtors->type == 2)
                                                        <span>Creditor</span>
                                                    @else
                                                        <span>Bank</span>
                                                    @endif
                                                    Balance Confirmation as on
                                                    {{ date('F d,Y', strtotime($debtors->date)) }} at the earliest.
                                                @endif
                                                <br />
                                                To Accept or Refuse, please click Accept and Refuse button
                                            </p>

                                        </div>
                                    </div>
                                    <div class="row">



                                        <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalLabel4" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content " style="border-radius: 3rem;">
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close"
                                                        style="position: absolute; top: 10px; right: 10px; background-color: rgba(0,0,0,0.1); border-radius: 50%; border: none; padding: 5px;">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>

                                                    <form id="detailsForm" method="post"
                                                        action="{{ url('assignmentconfirmationotp') }}"
                                                        enctype="multipart/form-data">
                                                        @csrf


                                                        <div
                                                            style="width: 100%; border-radius: 10px; height: 100%; padding: 16px; background: white; box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.25);  flex-direction: column; justify-content: flex-start; align-items: center; gap: 24px; display: inline-flex ">
                                                            <div
                                                                style="flex-direction: column; justify-content: flex-start; align-items: center; gap: 16px; display: flex">
                                                                <div
                                                                    style="flex-direction: column; justify-content: flex-start; align-items: center; gap: 8px; display: flex">
                                                                    <div
                                                                        style="width: 62px; height: 62px; position: relative">
                                                                        <div
                                                                            style="width: 62px; height: 62px; left: 62px; top: 62px; position: absolute; transform: rotate(-180deg); transform-origin: 0 0; opacity: 0">
                                                                        </div>
                                                                        <div
                                                                            style="width: 46.03px; height: 51.64px; left: 7.98px; top: 5.19px; position: absolute; ">
                                                                            <img src="{{ asset('image/security-safe.svg') }}"
                                                                                alt="security-safe">
                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                        style="color: #292D32; font-size: 24px; font-family: Inter; font-weight: 500; word-wrap: break-word">
                                                                        Verification Required</div>

                                                                </div>

                                                                <div class="details-form-field  row">

                                                                    <div class="col-sm-12">

                                                                        <input type="hidden" id="debitid"
                                                                            name="debitid" class="form-control">
                                                                        <input type="hidden" id="assignmentgenerate_id"
                                                                            name="assignmentgenerate_id"
                                                                            class="form-control">
                                                                        <input type="hidden" id="type"
                                                                            name="type" class="form-control">
                                                                        <input type="hidden" id="status"
                                                                            name="status" class="form-control">
                                                                    </div>
                                                                </div>

                                                                <div
                                                                    style="width: 332px; text-align: center; color: rgba(41, 45, 50, 0.65); font-size: 18px; font-family: Inter; font-weight: 400; word-wrap: break-word">
                                                                    Please enter the 6-digit OTP sent to your registered
                                                                    email address.
                                                                </div>
                                                            </div>



                                                            @if ($errors->any())
                                                                <div>
                                                                    <ul>
                                                                        @foreach ($errors->all() as $e)
                                                                            <li style="color:red;">{{ $e }}
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                </div>
                                                            @else
                                                            @endif

                                                            <div name="otp"
                                                                style="flex-direction: column; justify-content: flex-start; align-items: center; gap: 16px; display: flex">
                                                                <div
                                                                    class="container height-100 d-flex justify-content-center align-items-center">
                                                                    <div class="position-relative">
                                                                        <div class="col-sm-12">
                                                                            <p class="text-success" id="otpmessage">
                                                                            </p>
                                                                        </div>
                                                                        <div class="col-sm-12">
                                                                            <p class="text-success" id="otpmessage2">
                                                                            </p>
                                                                        </div>
                                                                        <div id="otp"
                                                                            class="inputs d-flex flex-row justify-content-center mt-2">
                                                                            <input name="otp1"
                                                                                class="m-2 text-center form-control rounded"
                                                                                type="text" id="first"
                                                                                maxlength="1" />
                                                                            <input name="otp2"
                                                                                class="m-2 text-center form-control rounded"
                                                                                type="text" id="second"
                                                                                maxlength="1" />
                                                                            <input name="otp3"
                                                                                class="m-2 text-center form-control rounded"
                                                                                type="text" id="third"
                                                                                maxlength="1" />
                                                                            <input name="otp4"
                                                                                class="m-2 text-center form-control rounded"
                                                                                type="text" id="fourth"
                                                                                maxlength="1" />
                                                                            <input name="otp5"
                                                                                class="m-2 text-center form-control rounded"
                                                                                type="text" id="fifth"
                                                                                maxlength="1" />
                                                                            <input name="otp6"
                                                                                class="m-2 text-center form-control rounded"
                                                                                type="text" id="sixth"
                                                                                maxlength="1" />
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                                <div style="width: 332px; text-align: center"
                                                                    class="resends"><span
                                                                        style="color: rgba(41, 45, 50, 0.85); font-size: 16px; font-family: Inter; font-weight: 300; word-wrap: break-word">Didn’t
                                                                        receive the OTP?</span><span
                                                                        style="color: rgba(41, 45, 50, 0.85); font-size: 16px; font-family: Inter; font-weight: 500; word-wrap: break-word">
                                                                        <a id="yesid"
                                                                            data-id="{{ $debtorid }}"
                                                                            data-status="1" data-resend="true"
                                                                            class="font-weight-500"
                                                                            style="color:#37a000;"> Resend</a>
                                                                    </span>
                                                                </div>
                                                            </div>


                                                            <div
                                                                style="width: 100%; height: 100%;    background: #4071F4; box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.25); border-radius: 4px; justify-content: center; align-items: center; display: inline-flex">
                                                                <button style="background: #37A000;" type="submit"
                                                                    class="btn btn-block" id="verifyBtn"
                                                                    onclick="return confirm('Are you sure ?');">
                                                                    <div
                                                                        style="color: white; font-size: 20px; font-family: Inter; font-weight: 500; word-wrap: break-word">
                                                                        Verify</div>
                                                                </button>
                                                            </div>

                                                        </div>


                                                    </form>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="modal fade" id="exampleModal12" tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalLabel4" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close"
                                                        style="position: absolute; top: 10px; right: 10px; background-color: rgba(0,0,0,0.1); border-radius: 50%; border: none; padding: 5px;">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    <form id="detailsForm" method="post"
                                                        action="{{ url('assignmentconfirmationotp') }}"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        <div
                                                            style="width: 100%; border-radius: 10px; height: 100%; padding: 16px; background: white; box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.25);  flex-direction: column; justify-content: flex-start; align-items: center; gap: 24px; display: inline-flex ">
                                                            <div
                                                                style="flex-direction: column; justify-content: flex-start; align-items: center; gap: 16px; display: flex">
                                                                <div
                                                                    style="flex-direction: column; justify-content: flex-start; align-items: center; gap: 8px; display: flex">
                                                                    <div
                                                                        style="width: 62px; height: 62px; position: relative">
                                                                        <div
                                                                            style="width: 62px; height: 62px; left: 62px; top: 62px; position: absolute; transform: rotate(-180deg); transform-origin: 0 0; opacity: 0">
                                                                        </div>
                                                                        <div
                                                                            style="width: 46.03px; height: 51.64px; left: 7.98px; top: 5.19px; position: absolute; ">
                                                                            <img src="{{ asset('image/security-safe.svg') }}"
                                                                                alt="security-safe">
                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                        style="color: #292D32; font-size: 24px; font-family: Inter; font-weight: 500; word-wrap: break-word">
                                                                        Verification Required</div>
                                                                    @if ($errors->any())
                                                                        <div>
                                                                            <ul>
                                                                                @foreach ($errors->all() as $e)
                                                                                    <li style="color:red;">
                                                                                        {{ $e }}</li>
                                                                                @endforeach
                                                                            </ul>
                                                                        </div>
                                                                    @else
                                                                    @endif
                                                                </div>
                                                                <div
                                                                    style="width: 332px; text-align: center; color: rgba(41, 45, 50, 0.65); font-size: 18px; font-family: Inter; font-weight: 400; word-wrap: break-word">
                                                                    Please enter the 6-digit OTP sent to your registered
                                                                    email address.
                                                                </div>



                                                                <div class="details-form-field form-group row">
                                                                    <div class="col-sm-12" style="margin-left: 5rem">
                                                                        <p class="text-success" id="otpmessage1"></p>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        <p class="text-success" id="otpmessage3"></p>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        <div name="otp"
                                                                            style="flex-direction: column; justify-content: flex-start; align-items: center; gap: 16px; display: flex">
                                                                            <div
                                                                                class="container height-100 d-flex justify-content-center align-items-center">
                                                                                <div class="position-relative">
                                                                                    <div id="otp"
                                                                                        class="inputs d-flex flex-row justify-content-center mt-2">
                                                                                        <input name="otp11"
                                                                                            class="m-2 text-center form-control rounded"
                                                                                            type="text"
                                                                                            id="first"
                                                                                            maxlength="1" />
                                                                                        <input name="otp12"
                                                                                            class="m-2 text-center form-control rounded"
                                                                                            type="text"
                                                                                            id="second"
                                                                                            maxlength="1" />
                                                                                        <input name="otp13"
                                                                                            class="m-2 text-center form-control rounded"
                                                                                            type="text"
                                                                                            id="third"
                                                                                            maxlength="1" />
                                                                                        <input name="otp14"
                                                                                            class="m-2 text-center form-control rounded"
                                                                                            type="text"
                                                                                            id="fourth"
                                                                                            maxlength="1" />
                                                                                        <input name="otp15"
                                                                                            class="m-2 text-center form-control rounded"
                                                                                            type="text"
                                                                                            id="fifth"
                                                                                            maxlength="1" />
                                                                                        <input name="otp16"
                                                                                            class="m-2 text-center form-control rounded"
                                                                                            type="text"
                                                                                            id="sixth"
                                                                                            maxlength="1" />
                                                                                    </div>

                                                                                </div>
                                                                            </div>
                                                                            <div style="width: 332px; text-align: center"
                                                                                class="resends">
                                                                                <span
                                                                                    style="color: rgba(41, 45, 50, 0.85); font-size: 16px; font-family: Inter; font-weight: 300; word-wrap: break-word">Didn’t
                                                                                    receive the OTP?</span><span
                                                                                    style="color: rgba(41, 45, 50, 0.85); font-size: 16px; font-family: Inter; font-weight: 500; text-decoration: underline; word-wrap: break-word">
                                                                                    <a id="noid"
                                                                                        data-id="{{ $debtorid }}"
                                                                                        data-status="0"
                                                                                        data-resend="true"
                                                                                        class="font-weight-500"
                                                                                        style="color:#37a000;">
                                                                                        Resend</a></span>
                                                                            </div>
                                                                        </div>
                                                                        <input type="hidden" id="debitid1"
                                                                            name="debitid1" class="form-control">
                                                                        <input type="hidden"
                                                                            id="assignmentgenerate_id1"
                                                                            name="assignmentgenerate_id1"
                                                                            class="form-control">
                                                                        <input type="hidden" id="type1"
                                                                            name="type1" class="form-control">
                                                                        <input type="hidden" id="status1"
                                                                            name="status1" class="form-control">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div
                                                                style="width: 100%; height: 100%;  background: #4071F4; box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.25); border-radius: 4px; justify-content: center; align-items: center; display: inline-flex">
                                                                <button style="background: #37a000;" type="submit"
                                                                    class="btn btn-block" id="verifyBtn">
                                                                    <div
                                                                        style="color: white; font-size: 20px; font-family: Inter; font-weight: 500; word-wrap: break-word">
                                                                        Verify</div>
                                                                </button>
                                                            </div>


                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- *   --}}
    <div class="content-wrapper">
        <div class="main-content pt-1">
            <div style="float: right; margin-right:80px; margin-top: 4px;" class=" align-items-center">
                @php
                    $otpsettingstatus = 0;
                @endphp
                @if ($otpsettingstatus == 0)
                    {{-- <a href="{{ url('/otpskipconfirmation?' . 'type=' . $debtors->type . '&&' . 'status=' . 1 . '&&' . 'assignmentgenerate_id=' . $debtors->assignmentgenerate_id . '&&' . 'debitid=' . $debtors->id) }}"
                    class="btn btn-success">
                    Accept
                </a> --}}
                    <a href="#" class="btn btn-success" id="acceptButton">
                        Accept
                    </a>

                    <a href="{{ url('/otpskipconfirmation?' . 'type1=' . $debtors->type . '&&' . 'status1=' . 0 . '&&' . 'assignmentgenerate_id1=' . $debtors->assignmentgenerate_id . '&&' . 'debitid1=' . $debtors->id) }}"
                        class="btn btn-danger">
                        Refuse
                    </a>
                @else
                    <button class="btn btn-success" id="yesid" data-id="{{ $debtorid }}" data-status="1"
                        data-toggle="modal" data-target="#exampleModal1">Accept</button>

                    <button class="btn btn-danger" id="noid" data-id="{{ $debtorid }}" data-status="0"
                        data-toggle="modal" data-target="#exampleModal12">Refuse</button>
                @endif
            </div>
            {{-- 
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script>
                $(document).ready(function() {
                    $('#acceptButton').click(function(e) {
                        e.preventDefault();
                        var type = "<?php echo $debtors->type; ?>";
                        var status = 1;
                        var assignmentgenerate_id = "<?php echo $debtors->assignmentgenerate_id; ?>";
                        var debitid = "<?php echo $debtors->id; ?>";

                        // Construct URL with data
                        var url = "/otpskipconfirmation?type=" + type + "&status=" + status +
                            "&assignmentgenerate_id=" + assignmentgenerate_id + "&debitid=" + debitid;

                        // Send Ajax request
                        $.ajax({
                            url: url,
                            type: 'GET',
                            success: function(response) {
                                console.log(response);
                            },
                            error: function(xhr, status, error) {
                                // Handle error
                                console.error(xhr.responseText);
                            }
                        });
                    });
                });
            </script> --}}



            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script>
                $(document).ready(function() {
                    $('#acceptButton').click(function(e) {
                        e.preventDefault();
                        var type = "{{ $debtors->type }}";
                        var status = 1;
                        var assignmentgenerate_id = "{{ $debtors->assignmentgenerate_id }}";
                        var debitid = "{{ $debtors->id }}";

                        // Construct URL with data
                        var url = "/otpskipconfirmation?type=" + type + "&status=" + status +
                            "&assignmentgenerate_id=" + assignmentgenerate_id + "&debitid=" + debitid;

                        // Send Ajax request
                        $.ajax({
                            url: url,
                            type: 'GET',
                            success: function(response) {
                                if (response.success) {
                                    $('#solo').hide();
                                } else {
                                    alert(response.error);
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr.responseText);
                            }
                        });
                    });
                });
            </script>


            <div id="printableArea">
                <div class="container py-5 h-100">
                    <div class="row justify-content-center align-items-center h-100">
                        <div class="col-12 col-lg-12 col-xl-12" id="solo">
                            <div class="card shadow-2-strong card-registration">
                                <div class="card-body p-md-5">
                                    <div class="row">
                                        <div class="col-12  d-flex align-items-center justify-content-center">
                                            <span>
                                                <h2>Balance confirmation</h2>
                                            </span>
                                        </div>
                                        <div class="col-12  d-flex align-items-center justify-content-center">
                                            @if ($errors->any())
                                                <div>
                                                    @foreach ($errors->all() as $e)
                                                        <p style="color:red;">{{ $e }}
                                                        </p>
                                                    @endforeach
                                                </div>
                                            @else
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            {!! $description ?? '' !!}
                                            {{-- @php
                                                dd($debtors);
                                            @endphp --}}
                                            <p><br /> <span
                                                    style="text-decoration: underline;"><strong>Confirmation</strong></span><br />
                                                <br />
                                                @if ($debtors->amounthidestatus == 1)
                                                    We confirm that in our books of account, the outstanding balance as
                                                    on {{ date('F d,Y', strtotime($debtors->date)) }} is
                                                    <span style="color: #ff6600;">Rs {{ $debtors->amount ?? '' }}</span>
                                                @else
                                                    We request you to provide the
                                                    @if ($debtors->type == 1)
                                                        <span>Debtor</span>
                                                    @elseif($debtors->type == 2)
                                                        <span>Creditor</span>
                                                    @else
                                                        <span>Bank</span>
                                                    @endif
                                                    Balance Confirmation as on
                                                    {{ date('F d,Y', strtotime($debtors->date)) }} at the earliest.
                                                @endif
                                                <br />
                                                To Accept or Refuse, please click Accept and Refuse button
                                            </p>
                                            <p>&nbsp;</p>
                                            <br>
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 d-flex align-items-center justify-content-center">
                                            @php
                                                $otpsettingstatus = 0;
                                            @endphp

                                            @if ($otpsettingstatus == 0)
                                                <a href="{{ url('/otpskipconfirmation?' . 'type=' . $debtors->type . '&&' . 'status=' . 1 . '&&' . 'assignmentgenerate_id=' . $debtors->assignmentgenerate_id . '&&' . 'debitid=' . $debtors->id) }}"
                                                    style="padding: 8px 16px; background: #28A745; box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.25); border-radius: 4px; color: white; font-size: 20px; font-family: Inter; font-weight: 500; text-decoration: none; margin-right: 10px;">
                                                    Accept
                                                </a>

                                                <a href="{{ url('/otpskipconfirmation?' . 'type1=' . $debtors->type . '&&' . 'status1=' . 0 . '&&' . 'assignmentgenerate_id1=' . $debtors->assignmentgenerate_id . '&&' . 'debitid1=' . $debtors->id) }}"
                                                    style="padding: 8px 16px; background: #DC3545; box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.25); border-radius: 4px; color: white; font-size: 20px; font-family: Inter; font-weight: 500; text-decoration: none;">
                                                    Refuse
                                                </a>
                                            @else
                                                <div style="padding-left: 16px; padding-right: 16px; padding-top: 8px; padding-bottom: 8px; background: #28A745; box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.25); border-radius: 4px; justify-content: center; align-items: center; display: inline-flex"
                                                    id="yesid" data-id="{{ $debtorid }}" data-status="1"
                                                    data-toggle="modal" data-target="#exampleModal1">
                                                    <div
                                                        style="color: white; font-size: 20px; font-family: Inter; font-weight: 500; word-wrap: break-word">
                                                        Accept</div>
                                                </div>&nbsp;&nbsp;&nbsp;
                                                <div style="padding-left: 16px; padding-right: 16px; padding-top: 8px; padding-bottom: 8px; background: #DC3545; box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.25); border-radius: 4px; justify-content: center; align-items: center; display: inline-flex"
                                                    id="noid" data-id="{{ $debtorid }}" data-status="0"
                                                    data-toggle="modal" data-target="#exampleModal12">
                                                    <div
                                                        style="color: white; font-size: 20px; font-family: Inter; font-weight: 500; word-wrap: break-word">
                                                        Refuse</div>
                                                </div>
                                            @endif
                                        </div>

                                        {{-- model box --}}
                                        <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalLabel4" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content " style="border-radius: 3rem;">
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close"
                                                        style="position: absolute; top: 10px; right: 10px; background-color: rgba(0,0,0,0.1); border-radius: 50%; border: none; padding: 5px;">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>

                                                    <form id="detailsForm" method="post"
                                                        action="{{ url('assignmentconfirmationotp') }}"
                                                        enctype="multipart/form-data">
                                                        @csrf


                                                        <div
                                                            style="width: 100%; border-radius: 10px; height: 100%; padding: 16px; background: white; box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.25);  flex-direction: column; justify-content: flex-start; align-items: center; gap: 24px; display: inline-flex ">
                                                            <div
                                                                style="flex-direction: column; justify-content: flex-start; align-items: center; gap: 16px; display: flex">
                                                                <div
                                                                    style="flex-direction: column; justify-content: flex-start; align-items: center; gap: 8px; display: flex">
                                                                    <div
                                                                        style="width: 62px; height: 62px; position: relative">
                                                                        <div
                                                                            style="width: 62px; height: 62px; left: 62px; top: 62px; position: absolute; transform: rotate(-180deg); transform-origin: 0 0; opacity: 0">
                                                                        </div>
                                                                        <div
                                                                            style="width: 46.03px; height: 51.64px; left: 7.98px; top: 5.19px; position: absolute; ">
                                                                            <img src="{{ asset('image/security-safe.svg') }}"
                                                                                alt="security-safe">
                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                        style="color: #292D32; font-size: 24px; font-family: Inter; font-weight: 500; word-wrap: break-word">
                                                                        Verification Required</div>

                                                                </div>

                                                                <div class="details-form-field  row">

                                                                    <div class="col-sm-12">

                                                                        <input type="hidden" id="debitid"
                                                                            name="debitid" class="form-control">
                                                                        <input type="hidden"
                                                                            id="assignmentgenerate_id"
                                                                            name="assignmentgenerate_id"
                                                                            class="form-control">
                                                                        <input type="hidden" id="type"
                                                                            name="type" class="form-control">
                                                                        <input type="hidden" id="status"
                                                                            name="status" class="form-control">
                                                                    </div>
                                                                </div>

                                                                <div
                                                                    style="width: 332px; text-align: center; color: rgba(41, 45, 50, 0.65); font-size: 18px; font-family: Inter; font-weight: 400; word-wrap: break-word">
                                                                    Please enter the 6-digit OTP sent to your registered
                                                                    email address.
                                                                </div>
                                                            </div>



                                                            @if ($errors->any())
                                                                <div>
                                                                    <ul>
                                                                        @foreach ($errors->all() as $e)
                                                                            <li style="color:red;">{{ $e }}
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                </div>
                                                            @else
                                                            @endif

                                                            <div name="otp"
                                                                style="flex-direction: column; justify-content: flex-start; align-items: center; gap: 16px; display: flex">
                                                                <div
                                                                    class="container height-100 d-flex justify-content-center align-items-center">
                                                                    <div class="position-relative">
                                                                        <div class="col-sm-12">
                                                                            <p class="text-success" id="otpmessage">
                                                                            </p>
                                                                        </div>
                                                                        <div class="col-sm-12">
                                                                            <p class="text-success" id="otpmessage2">
                                                                            </p>
                                                                        </div>
                                                                        <div id="otp"
                                                                            class="inputs d-flex flex-row justify-content-center mt-2">
                                                                            <input name="otp1"
                                                                                class="m-2 text-center form-control rounded"
                                                                                type="text" id="first"
                                                                                maxlength="1" />
                                                                            <input name="otp2"
                                                                                class="m-2 text-center form-control rounded"
                                                                                type="text" id="second"
                                                                                maxlength="1" />
                                                                            <input name="otp3"
                                                                                class="m-2 text-center form-control rounded"
                                                                                type="text" id="third"
                                                                                maxlength="1" />
                                                                            <input name="otp4"
                                                                                class="m-2 text-center form-control rounded"
                                                                                type="text" id="fourth"
                                                                                maxlength="1" />
                                                                            <input name="otp5"
                                                                                class="m-2 text-center form-control rounded"
                                                                                type="text" id="fifth"
                                                                                maxlength="1" />
                                                                            <input name="otp6"
                                                                                class="m-2 text-center form-control rounded"
                                                                                type="text" id="sixth"
                                                                                maxlength="1" />
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                                <div style="width: 332px; text-align: center"
                                                                    class="resends"><span
                                                                        style="color: rgba(41, 45, 50, 0.85); font-size: 16px; font-family: Inter; font-weight: 300; word-wrap: break-word">Didn’t
                                                                        receive the OTP?</span><span
                                                                        style="color: rgba(41, 45, 50, 0.85); font-size: 16px; font-family: Inter; font-weight: 500; word-wrap: break-word">
                                                                        <a id="yesid"
                                                                            data-id="{{ $debtorid }}"
                                                                            data-status="1" data-resend="true"
                                                                            class="font-weight-500"
                                                                            style="color:#37a000;"> Resend</a>
                                                                    </span>
                                                                </div>
                                                            </div>


                                                            <div
                                                                style="width: 100%; height: 100%;    background: #4071F4; box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.25); border-radius: 4px; justify-content: center; align-items: center; display: inline-flex">
                                                                <button style="background: #37A000;" type="submit"
                                                                    class="btn btn-block" id="verifyBtn"
                                                                    onclick="return confirm('Are you sure ?');">
                                                                    <div
                                                                        style="color: white; font-size: 20px; font-family: Inter; font-weight: 500; word-wrap: break-word">
                                                                        Verify</div>
                                                                </button>
                                                            </div>

                                                        </div>


                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- model box --}}
                                        <div class="modal fade" id="exampleModal12" tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalLabel4" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close"
                                                        style="position: absolute; top: 10px; right: 10px; background-color: rgba(0,0,0,0.1); border-radius: 50%; border: none; padding: 5px;">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    <form id="detailsForm" method="post"
                                                        action="{{ url('assignmentconfirmationotp') }}"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        <div
                                                            style="width: 100%; border-radius: 10px; height: 100%; padding: 16px; background: white; box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.25);  flex-direction: column; justify-content: flex-start; align-items: center; gap: 24px; display: inline-flex ">
                                                            <div
                                                                style="flex-direction: column; justify-content: flex-start; align-items: center; gap: 16px; display: flex">
                                                                <div
                                                                    style="flex-direction: column; justify-content: flex-start; align-items: center; gap: 8px; display: flex">
                                                                    <div
                                                                        style="width: 62px; height: 62px; position: relative">
                                                                        <div
                                                                            style="width: 62px; height: 62px; left: 62px; top: 62px; position: absolute; transform: rotate(-180deg); transform-origin: 0 0; opacity: 0">
                                                                        </div>
                                                                        <div
                                                                            style="width: 46.03px; height: 51.64px; left: 7.98px; top: 5.19px; position: absolute; ">
                                                                            <img src="{{ asset('image/security-safe.svg') }}"
                                                                                alt="security-safe">
                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                        style="color: #292D32; font-size: 24px; font-family: Inter; font-weight: 500; word-wrap: break-word">
                                                                        Verification Required</div>
                                                                    @if ($errors->any())
                                                                        <div>
                                                                            <ul>
                                                                                @foreach ($errors->all() as $e)
                                                                                    <li style="color:red;">
                                                                                        {{ $e }}</li>
                                                                                @endforeach
                                                                            </ul>
                                                                        </div>
                                                                    @else
                                                                    @endif
                                                                </div>
                                                                <div
                                                                    style="width: 332px; text-align: center; color: rgba(41, 45, 50, 0.65); font-size: 18px; font-family: Inter; font-weight: 400; word-wrap: break-word">
                                                                    Please enter the 6-digit OTP sent to your registered
                                                                    email address.
                                                                </div>
                                                                {{-- </div> --}}


                                                                <div class="details-form-field form-group row">
                                                                    <div class="col-sm-12" style="margin-left: 5rem">
                                                                        <p class="text-success" id="otpmessage1"></p>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        <p class="text-success" id="otpmessage3"></p>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        <div name="otp"
                                                                            style="flex-direction: column; justify-content: flex-start; align-items: center; gap: 16px; display: flex">
                                                                            <div
                                                                                class="container height-100 d-flex justify-content-center align-items-center">
                                                                                <div class="position-relative">
                                                                                    <div id="otp"
                                                                                        class="inputs d-flex flex-row justify-content-center mt-2">
                                                                                        <input name="otp11"
                                                                                            class="m-2 text-center form-control rounded"
                                                                                            type="text"
                                                                                            id="first"
                                                                                            maxlength="1" />
                                                                                        <input name="otp12"
                                                                                            class="m-2 text-center form-control rounded"
                                                                                            type="text"
                                                                                            id="second"
                                                                                            maxlength="1" />
                                                                                        <input name="otp13"
                                                                                            class="m-2 text-center form-control rounded"
                                                                                            type="text"
                                                                                            id="third"
                                                                                            maxlength="1" />
                                                                                        <input name="otp14"
                                                                                            class="m-2 text-center form-control rounded"
                                                                                            type="text"
                                                                                            id="fourth"
                                                                                            maxlength="1" />
                                                                                        <input name="otp15"
                                                                                            class="m-2 text-center form-control rounded"
                                                                                            type="text"
                                                                                            id="fifth"
                                                                                            maxlength="1" />
                                                                                        <input name="otp16"
                                                                                            class="m-2 text-center form-control rounded"
                                                                                            type="text"
                                                                                            id="sixth"
                                                                                            maxlength="1" />
                                                                                    </div>

                                                                                </div>
                                                                            </div>
                                                                            <div style="width: 332px; text-align: center"
                                                                                class="resends">
                                                                                <span
                                                                                    style="color: rgba(41, 45, 50, 0.85); font-size: 16px; font-family: Inter; font-weight: 300; word-wrap: break-word">Didn’t
                                                                                    receive the OTP?</span><span
                                                                                    style="color: rgba(41, 45, 50, 0.85); font-size: 16px; font-family: Inter; font-weight: 500; text-decoration: underline; word-wrap: break-word">
                                                                                    <a id="noid"
                                                                                        data-id="{{ $debtorid }}"
                                                                                        data-status="0"
                                                                                        data-resend="true"
                                                                                        class="font-weight-500"
                                                                                        style="color:#37a000;">
                                                                                        Resend</a></span>
                                                                            </div>
                                                                        </div>
                                                                        <input type="hidden" id="debitid1"
                                                                            name="debitid1" class="form-control">
                                                                        <input type="hidden"
                                                                            id="assignmentgenerate_id1"
                                                                            name="assignmentgenerate_id1"
                                                                            class="form-control">
                                                                        <input type="hidden" id="type1"
                                                                            name="type1" class="form-control">
                                                                        <input type="hidden" id="status1"
                                                                            name="status1" class="form-control">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div
                                                                style="width: 100%; height: 100%;  background: #4071F4; box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.25); border-radius: 4px; justify-content: center; align-items: center; display: inline-flex">
                                                                <button style="background: #37a000;" type="submit"
                                                                    class="btn btn-block" id="verifyBtn">
                                                                    <div
                                                                        style="color: white; font-size: 20px; font-family: Inter; font-weight: 500; word-wrap: break-word">
                                                                        Verify</div>
                                                                </button>
                                                            </div>

                                                            {{-- </div> --}}
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    {{-- *   --}}
   {{-- @include('backEnd.layouts.includes.stylesheet') --}}

   <div class="d-flex align-items-center justify-content-center text-center h-100vh"
   style="background-image:url('backEnd/image/unnamed.jpg');">
   <div class="form-wrapper m-auto">
       <div class="form-container my-4">
           <div class="register-logo text-center mb-4">

           </div>
           <div class="panel">
               <div class="panel-header text-center mb-3">
                   <img src="{{ url('backEnd/image/green-check.png') }}" style="height:100px;" alt="">
                   <h2><b>Your response has been submitted. Thank you</b></h2>
               </div>
               {{-- <div class="panel-header text-center mb-3">
               <img src="{{ url('backEnd/image/bg2_KN0GJ7D.jpg') }}" style="height:100px;" alt="">
               <h2><b>Your response has been recorded. Thank you</b></h2>
           </div> --}}
           </div>
       </div>
   </div>
</div>













    @php
           public function pendingmail($id)
    {
        try {
            $usermail = DB::table('debtors')->where('id', $id)->first();
            $checkmail = DB::table('balanceconfirmationreminder')
                ->where('debtorsid', $id)
                ->latest()
                ->first();

            if ($checkmail === null || $checkmail->reminderdatecount != date('Y-m-d')) {
                $this->sendEmail($usermail);
                $output = ['msg' => 'A mail reminder has been sent.'];
                return back()->with('statusss', $output);
            } else {
                $output = ['msg' => 'Only one reminder can be sent Today'];
                return back()->with('statusss', $output);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = ['msg' => $e->getMessage()];
            return back()->withErrors($output)->withInput();
        }
    }

    public function sendEmail($usermail)
    {
        $maildatas = DB::table('templates')->where('assignmentgenerate_id', $usermail->assignmentgenerate_id)
            ->where('type', $usermail->type)->first();
        if ($maildatas ==  null) {
            $maildata =  DB::table('templates')->where('type', $usermail->type)->first();
        } else {
            $maildata = DB::table('templates')->where('assignmentgenerate_id', $usermail->assignmentgenerate_id)
                ->where('type', $usermail->type)->first();
        }
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
            'amounthidestatus' => $usermail->amounthidestatus,
            'type' => $usermail->type,
            'description' => $description,
            'yes' => 1,
            'no' => 0
        );
        Mail::send('emails.assignmentdebtorform', $data, function ($msg) use ($data) {
            $msg->to($data['email']);
            $msg->subject('Regarding Pending Confirmation');
        });

        DB::table('balanceconfirmationreminder')->insert([
            'debtorsid'     =>    $usermail->id,
            'remindercount'     =>     1,
            'reminderdatecount'     =>    date('Y-m-d'),
            'created_at'          =>     date('Y-m-d H:i:s'),
            'updated_at'              =>    date('Y-m-d H:i:s'),
        ]);
    }
    @endphp
    {{-- *   --}}

    <table id="examplee" class="display nowrap">
        <thead>
            <tr>
                <th style="display: none;">id</th>
                @if ($clientList->balanceconfirmationstatus == 1)
                    <th><input type="checkbox" id="masterCheckbox" class="check-all"></th>
                @endif
                <th>Unique No.</th>
                <th>Name</th>
                <th class="text-right">
                    Amount
                </th>
                @if ($clientList->balanceconfirmationstatus == 1)
                    <th class="text-right"> <input type="checkbox"
                            class="debtor-status-toggle-master" id="toggle-all-statuses"
                            data-toggle="toggle" data-style="ios" data-on=" Show"
                            data-off=" Hide"></th>
                @else
                    <th>Show/Hide</th>
                @endif
                <th>Year</th>
                <th>Date</th>
                <th>Address</th>
                <th>Primary Email</th>
                <th>Secondary Email</th>
                <th>Entity Name</th>
                <th>Email Status</th>
                <th>Confirmation Status</th>
                <th>Created By</th>
                <th>Remark</th>
                <th>Amount</th>
                <th>Attachment</th>
                <th>Action</th>
                <th>Edit</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clientdebit as $clientdebitdata)
                <tr>
                    <td style="display: none;">{{ $clientdebitdata->id }}</td>

                    @if ($clientList->balanceconfirmationstatus == 1)
                        <td>
                            @if ($clientdebitdata->status == 2)
                                <input style="font-size:4px;" type="checkbox" name="approve[]"
                                    value="{{ $clientdebitdata->id }}">
                            @else
                            @endif
                        </td>
                    @endif
                    <td>{{ $clientdebitdata->unique }}</td>
                    <td>{{ ucfirst($clientdebitdata->name) }}</td>
                    <td class="text-right">
                        {{ $clientdebitdata->amount }}
                    </td>
                    <td class="text-right">
                        @if ($clientdebitdata->status != 2)
                            @if ($clientdebitdata->amounthidestatus == 1)
                                <span> Show </span>
                            @else
                                <span> Hide </span>
                            @endif
                        @endif
                        @if ($clientList->balanceconfirmationstatus == 1)
                            @if ($clientdebitdata->status == 2)
                                <input type="checkbox" class="debtor-status-toggle"
                                    id="toggle-status-{{ $clientdebitdata->id }}"
                                    {{ $clientdebitdata->amounthidestatus ? 'checked' : '' }}
                                    data-toggle="toggle" data-style="ios"
                                    data-id="{{ $clientdebitdata->id }}" data-on=" Show"
                                    data-off=" Hide">
                            @endif
                        @endif
                    </td>
                    <td>{{ $clientdebitdata->year }}</td>
                    @if ($clientdebitdata->date != null)
                        <td>{{ date('F d,Y', strtotime($clientdebitdata->date)) }}</td>
                    @else
                        <td></td>
                    @endif
                    <td>{{ $clientdebitdata->address }}</td>
                    <td><a
                            href="mail:={{ $clientdebitdata->email }}">{{ $clientdebitdata->email }}</a>
                    </td>
                    <td><a
                            href="mail:={{ $clientdebitdata->secondaryemail }}">{{ $clientdebitdata->secondaryemail }}</a>
                    </td>
                    <td>{{ $clientdebitdata->entityname }}</td>
                    <td>
                        @if ($clientdebitdata->mailstatus == 1)
                            <span>Sent</span>
                        @elseif($clientdebitdata->mailstatus == 2)
                            <span>Failed</span>
                        @else
                            <span>Not Sent</span>
                        @endif
                    </td>
                    <td>
                        @if ($clientdebitdata->status == 0)
                            <span class="badge badge-pill badge-danger">Not Confirmed</span>
                        @elseif($clientdebitdata->status == 2)
                            <span class="badge badge-pill badge-Warning">Draft</span>
                        @elseif($clientdebitdata->status == 3)
                            <span class="badge badge-pill badge-info">Pending</span>
                        @else
                            <span class="badge badge-pill badge-success">Confirmed</span>
                        @endif
                        @if ($clientList->balanceconfirmationstatus == 1)
                            @if ($clientdebitdata->status == 3)
                                <a class="editCompanyyyy" data-toggle="modal"
                                    data-id="{{ $clientdebitdata->id }}"
                                    data-target="#exampleModal1121{{ $loop->index }}"
                                    title="Send Reminder">
                                    <span class="typcn typcn-bell"
                                        style="font-size: large;color: green;"></span>
                                </a>
                            @endif
                        @endif
                        {{-- asa request reminder modal --}}
                        <div class="modal fade" id="exampleModal1121{{ $loop->index }}"
                            tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
                            aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header" style="background: #218838;">
                                        <h5 style="color:white;"
                                            class="modal-title font-weight-600"
                                            id="exampleModalLabel4">Send
                                            Reminder
                                            list</h5>
                                        <div>
                                            <ul>
                                                @foreach ($errors->all() as $e)
                                                    <li style="color:red;">{{ $e }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <button type="button" class="close"
                                            data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="table-responsive">
                                            <table id="reminderTable"
                                                class="table display table-bordered table-striped table-hover">
                                                <thead>
                                                    <tr style="background-color: #b6acae;">
                                                        <th>Reminder Count</th>
                                                        <th>Last Reminder Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="timesheetTableBody">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <a href="{{ url('assignmentpending/mail', $clientdebitdata->id) }}"
                                            class="btn btn-success sendReminderBtn"
                                            onclick="return confirm('Are you sure you want to send notification?');">
                                            Send
                                            Notification</a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </td>
                    <td>{{ $clientdebitdata->debtorcreatedby->team_member ?? '' }}</td>
                    <td>{{ $clientdebitdata->debtorconfirm->remark ?? '' }}</td>
                    <td>{{ $clientdebitdata->debtorconfirm->amount ?? '' }}</td>
                    <td> <a target="blank"
                            href="{{ optional($clientdebitdata->debtorconfirm)->file
                                ? url('/backEnd/image/confirmationfile/' . $clientdebitdata->debtorconfirm->file)
                                : '' }}">
                            {{ optional($clientdebitdata->debtorconfirm)->file ?? '' }}
                        </a></td>

                    <td>
                        @if ($clientList->balanceconfirmationstatus == 1)
                            @if ($clientdebitdata->mailstatus == 0)
                                <a href="{{ url('/entries/destroy/' . $clientdebitdata->id) }}"
                                    onclick="return confirm('Are you sure you want to delete this item?');"
                                    class="btn btn-danger-soft btn-sm"><i
                                        class="far fa-trash-alt"></i></a>
                            @endif
                        @endif
                    </td>
                    <td>
                        @if ($clientList->balanceconfirmationstatus == 1)
                            @if ($clientdebitdata->mailstatus == 0)
                                <a href="{{ url('/entriesedit/' . $clientdebitdata->id) }}"
                                    class="btn btn-info-soft btn-sm"><i
                                        class="far fa-edit"></i></a>
                            @endif
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>


    {{-- *   --}}
    +request: Symfony\Component\HttpFoundation\InputBag {#45 ▼
        #parameters: array:10 [▼
          "_token" => "LttUmmwipzjJ6ZNHhGJxJw8kCV9Iy1xSvG0WiUaA"
          "client_name" => "abcde"
          "c_address" => "fff"
          "legalstatus" => "4"
          "panno" => "cswpr9192q"
          "tanno" => "23322"
          "gstno" => "fdehdj23hss3"
          "status" => "1"
          "classification" => "1"
          "otherclassification" => null
        ]
      }
    {{-- *   --}}
    DB::table('users')->where('teammember_id', $teamid)->update([
        'status'         =>  1,
    ]);
    {{-- *   --}}
    {{-- *   --}}

    +request: Symfony\Component\HttpFoundation\InputBag {#45 ▼
        #parameters: array:11 [▼
          "_token" => "LiFY1nGhGAmUnggDtapqOQqtbQFyd0ABHVe23Xyk"
          "otp11" => "5"
          "otp12" => "8"
          "otp13" => "5"
          "otp14" => "9"
          "otp15" => "8"
          "otp16" => "1"
          "debitid1" => "39"
          "assignmentgenerate_id1" => "ABD100411"
          "type1" => "1"
          "status1" => "0"
        ]
      }
    {{-- *   --}}
    <form id="detailsForm" method="post"
    action="{{ url('assignmentconfirmationotp') }}"
    enctype="multipart/form-data">
    @csrf
    <div
        style="width: 100%; height: 100%;    background: #4071F4; box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.25); border-radius: 4px; justify-content: center; align-items: center; display: inline-flex">
        <button style="background: #37A000;" type="submit"
            class="btn btn-block" id="verifyBtn"
            onclick="return confirm('Are you sure ?');">
            <div
                style="color: white; font-size: 20px; font-family: Inter; font-weight: 500; word-wrap: break-word">
                Verify</div>
        </button>
    </div>

</div>
</form>
    {{-- *   --}}
    +request: Symfony\Component\HttpFoundation\InputBag {#45 ▼
        #parameters: array:11 [▼
          "_token" => "LiFY1nGhGAmUnggDtapqOQqtbQFyd0ABHVe23Xyk"

          "debitid" => "39"
          "assignmentgenerate_id" => "ABD100411"
          "type" => "1"
          "status" => "1"

       



          "otp1" => "6"
          "otp2" => "7"
          "otp3" => "7"
          "otp4" => "6"
          "otp5" => "0"
          "otp6" => "5"
        ]
    {{-- *   --}}
    @php
            public function mail(Request $request)
    {
        $request->validate([
            'description' => "required",
        ]);

        try {

            $data = $request->except(['_token']);

            $confirmationIds = $request->input('confirmationid', []);

            // Filter out all null values from the array
            $nonNullConfirmationIds = array_filter($confirmationIds, function ($value) {
                return !is_null($value);
            });

            // Check if the filtered array is empty
            if (empty($nonNullConfirmationIds)) {
                $output = array('msg' => 'Select at least one check box to proceed.');
                return back()->with('statuss', $output);
            }
            //die;
            $debtor = DB::table('debtors')
                ->where('assignmentgenerate_id', $request->assignmentgenerate_id)->where('type', $request->type)
                ->where('mailstatus', 0)
                ->whereIn('id', explode(", ", $request->confirmationid[0]))->get();

            //     dd($debtor);
            //    die;
            if ($debtor->isEmpty()) {
                $output = array('msg' => 'Prior to proceeding, it is necessary to first upload the Excel data');
                return back()->with('statuss', $output);
            }



            $draftcheck = DB::table('templates')->where('id', $request->templateid)->first()->draftstatus;
            // dd($draftcheck == 0);
            if ($draftcheck == 0) {
                $output = array('msg' => 'Mail draft is pending please save your draft');
                return back()->with('statuss', $output);
            }

            foreach ($debtor as $debtors) {
                // dd($debtors);
                if ($request->teammember_id) {
                    // cc mail
                    $teammembermail = Teammember::wherein('id', $request->teammember_id)->pluck('emailid')->toArray();
                }
                $des = $request->description;
                dd($des);
                $healthy = ["[name]", "[amount]", "[year]", "[date]", "[address]", "[entityname]"];
                $yummy   = ["$debtors->name", "$debtors->amount", "$debtors->year", "$debtors->date", "$debtors->address", "$debtors->entityname"];
                $description = str_replace($healthy, $yummy, $des);

                $data = array(
                    'subject' => $request->subject,
                    'name' =>  $debtors->name,
                    'email' =>  $debtors->email,
                    'year' =>  $debtors->year,
                    'date' =>  $debtors->date,
                    'amount' =>  $debtors->amount,
                    'entityname' =>  $debtors->entityname,
                    'clientid' => $debtors->assignmentgenerate_id,
                    'debtorid' => $debtors->id,
                    'amounthidestatus' => $debtors->amounthidestatus,
                    'type' => $debtors->type,
                    'description' => $description,
                    'teammembermail' => $teammembermail ?? '',
                    'yes' => 1,
                    'no' => 0
                );


                try {
                    Mail::send('emails.assignmentdebtorform', $data, function ($msg) use ($data, $request) {
                        $msg->to($data['email']);
                        $msg->subject($data['subject']);

                        if ($request->teammember_id) {
                            $msg->cc($data['teammembermail']);
                        }

                        // Add CC for additional emails from the input field
                        // Add CC for additional emails from the input field
                        if ($request->ccmail) {
                            $assignEmails = explode(',', $request->ccmail);
                            foreach ($assignEmails as $email) {
                                $msg->cc(trim($email));
                            }
                        }
                    });

                    DB::table('debtors')
                        ->where('assignmentgenerate_id', $debtors->assignmentgenerate_id)
                        ->where('id', $debtors->id)
                        ->update([
                            'mailstatus' => 1,
                            'status' => 3,
                            'updated_at' => now()
                        ]);
                } catch (Exception $e) {
                    // Log the error or handle it as needed
                    // For example, you can log the exception to laravel.log
                    // or you can notify the administrator about the failure
                    \Log::error('Mail sending failed: ' . $e->getMessage());

                    // Update mailstatus to 0 in the database
                    DB::table('debtors')
                        ->where('assignmentgenerate_id', $debtors->assignmentgenerate_id)
                        ->where('id', $debtors->id)
                        ->update([
                            'mailstatus' => 0,
                            'updated_at' => now()
                        ]);
                }
            }
            $output = array('msg' => 'Email Sent Successfully');
            return back()->with('statusss', $output);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }


    public function confirmationAccept(Request $request)
    {
        $clientid = $request->clientid;
        $debtorid = $request->debtorid;
        $yes = $request->yes;
        $no = $request->no;
        $templatetype = $request->type;
        $template = DB::table('templates')->where('type', $templatetype)->first();
        // dd($template);

        $confirmation = DB::table('debtors')->where('id', $debtorid)->first();
        if ($confirmation->amounthidestatus == 1) {
            return view('backEnd.assignmentconfirmationaccept', compact('clientid', 'debtorid', 'yes', 'no', 'template'));
        } else {
            //  die;
            return view('backEnd.assignmentconfirmationamounthide', compact('clientid', 'debtorid', 'yes', 'no', 'template'));
        }
    }
    @endphp
    {{-- *   --}}
    <div class="d-flex align-items-center justify-content-center text-center h-100vh"
    style="background-image:url('backEnd/image/unnamed.jpg');">
    <div class="form-wrapper m-auto">
        <div class="form-container my-4">
            <div class="register-logo text-center mb-4">
            </div>
            <div class="panel">
                @if ($errors->any())
                    {{-- <div class="alert alert-danger"> --}}
                    @foreach ($errors->all() as $error)
                        <p class="text-danger">{{ $error }}</p>
                    @endforeach
                    {{-- </div> --}}
                @endif
                @if (session('success_message'))
                    <p class="text-danger">{{ session('success_message') }}</p>
                @endif

                {{-- new code --}}
                <div
                    style="width: 100%; height: 100%; flex-direction: column; justify-content: flex-start; align-items: center; gap: 8px; display: inline-flex">
                    <div
                        style="width: 62px; height: 62px; justify-content: center; align-items: center; display: inline-flex">
                        <div style="width: 62px; height: 62px; position: relative">
                            <div
                                style="width: 51.67px; height: 51.67px; left: 5.17px; top: 5.17px; position: absolute; ">
                                <img src="{{ asset('image/tick-circle.svg') }}" alt="Tick Circle">
                            </div>
                            <div
                                style="width: 62px; height: 62px; left: 62px; top: 62px; position: absolute; transform: rotate(-180deg); transform-origin: 0 0; opacity: 0">
                            </div>
                        </div>
                    </div>
                    <div
                        style="color: #292D32; font-size: 24px; font-family: Inter; font-weight: 500; word-wrap: break-word">
                        Approval Required</div>
                </div>
                <div
                    style="text-align: center; color: rgba(41, 45, 50, 0.65); font-size: 18px; font-family: Inter; font-weight: 400; word-wrap: break-word">
                    This action requires approval before it can be completed.</div><br>
                <div style="width: 100%; height: 100%; border: 1px rgba(41, 45, 50, 0.25) solid"></div><br>
                <div style="display: flex">

                    <div style="width: 100%; height: 100%; padding-left: 16px; padding-right: 16px; padding-top: 8px; padding-bottom: 8px; background: #28A745; box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.25); border-radius: 4px; justify-content: center; align-items: center; display: inline-flex"
                        id="yesid" data-id="{{ $debtorid }}" data-status="1" data-toggle="modal"
                        data-target="#exampleModal1">
                        <div
                            style="color: white; font-size: 20px; font-family: Inter; font-weight: 500; word-wrap: break-word">
                            Accept</div>
                    </div>&nbsp;&nbsp;&nbsp;
                    <div style="width: 100%; height: 100%;  padding-left: 16px; padding-right: 16px; padding-top: 8px; padding-bottom: 8px; background: #DC3545; box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.25); border-radius: 4px; justify-content: center; align-items: center; display: inline-flex"
                        id="noid" data-id="{{ $debtorid }}" data-status="0" data-toggle="modal"
                        data-target="#exampleModal12">
                        <div
                            style="color: white; font-size: 20px; font-family: Inter; font-weight: 500; word-wrap: break-word">
                            Refuse</div>
                    </div>
                </div>



                {{-- model box --}}
                <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel4" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content " style="border-radius: 3rem;">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                style="position: absolute; top: 10px; right: 10px; background-color: rgba(0,0,0,0.1); border-radius: 50%; border: none; padding: 5px;">
                                <span aria-hidden="true">&times;</span>
                            </button>

                            <form id="detailsForm" method="post" action="{{ url('assignmentconfirmationotp') }}"
                                enctype="multipart/form-data">
                                @csrf


                                <div
                                    style="width: 100%; border-radius: 10px; height: 100%; padding: 16px; background: white; box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.25);  flex-direction: column; justify-content: flex-start; align-items: center; gap: 24px; display: inline-flex ">
                                    <div
                                        style="flex-direction: column; justify-content: flex-start; align-items: center; gap: 16px; display: flex">
                                        <div
                                            style="flex-direction: column; justify-content: flex-start; align-items: center; gap: 8px; display: flex">
                                            <div style="width: 62px; height: 62px; position: relative">
                                                <div
                                                    style="width: 62px; height: 62px; left: 62px; top: 62px; position: absolute; transform: rotate(-180deg); transform-origin: 0 0; opacity: 0">
                                                </div>
                                                <div
                                                    style="width: 46.03px; height: 51.64px; left: 7.98px; top: 5.19px; position: absolute; ">
                                                    <img src="{{ asset('image/security-safe.svg') }}"
                                                        alt="security-safe">
                                                </div>
                                            </div>
                                            <div
                                                style="color: #292D32; font-size: 24px; font-family: Inter; font-weight: 500; word-wrap: break-word">
                                                Verification Required</div>

                                        </div>

                                        <div class="details-form-field  row">

                                            <div class="col-sm-12">

                                                <input type="hidden" id="debitid" name="debitid"
                                                    class="form-control">
                                                <input type="hidden" id="assignmentgenerate_id"
                                                    name="assignmentgenerate_id" class="form-control">
                                                <input type="hidden" id="type" name="type"
                                                    class="form-control">
                                                <input type="hidden" id="status" name="status"
                                                    class="form-control">
                                            </div>
                                        </div>

                                        <div
                                            style="width: 332px; text-align: center; color: rgba(41, 45, 50, 0.65); font-size: 18px; font-family: Inter; font-weight: 400; word-wrap: break-word">
                                            Please enter the 6-digit OTP sent to your registered email address.
                                        </div>
                                    </div>



                                    @if ($errors->any())
                                        <div>
                                            <ul>
                                                @foreach ($errors->all() as $e)
                                                    <li style="color:red;">{{ $e }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @else
                                    @endif

                                    <div name="otp"
                                        style="flex-direction: column; justify-content: flex-start; align-items: center; gap: 16px; display: flex">
                                        <div
                                            class="container height-100 d-flex justify-content-center align-items-center">
                                            <div class="position-relative">
                                                <div class="col-sm-12">
                                                    <p class="text-success" id="otpmessage"></p>
                                                </div>
                                                <div class="col-sm-12">
                                                    <p class="text-success" id="otpmessage2"></p>
                                                </div>
                                                <div id="otp"
                                                    class="inputs d-flex flex-row justify-content-center mt-2">
                                                    <input name="otp1"
                                                        class="m-2 text-center form-control rounded"
                                                        type="text" id="first" maxlength="1" />
                                                    <input name="otp2"
                                                        class="m-2 text-center form-control rounded"
                                                        type="text" id="second" maxlength="1" />
                                                    <input name="otp3"
                                                        class="m-2 text-center form-control rounded"
                                                        type="text" id="third" maxlength="1" />
                                                    <input name="otp4"
                                                        class="m-2 text-center form-control rounded"
                                                        type="text" id="fourth" maxlength="1" />
                                                    <input name="otp5"
                                                        class="m-2 text-center form-control rounded"
                                                        type="text" id="fifth" maxlength="1" />
                                                    <input name="otp6"
                                                        class="m-2 text-center form-control rounded"
                                                        type="text" id="sixth" maxlength="1" />
                                                </div>

                                            </div>
                                        </div>
                                        <div style="width: 332px; text-align: center" class="resends"><span
                                                style="color: rgba(41, 45, 50, 0.85); font-size: 16px; font-family: Inter; font-weight: 300; word-wrap: break-word">Didn’t
                                                receive the OTP?</span><span
                                                style="color: rgba(41, 45, 50, 0.85); font-size: 16px; font-family: Inter; font-weight: 500; word-wrap: break-word">
                                                <a id="yesid" data-id="{{ $debtorid }}" data-status="1"
                                                    data-resend="true" class="font-weight-500"
                                                    style="color:#37a000;"> Resend</a>
                                            </span>
                                        </div>
                                    </div>


                                    <div
                                        style="width: 100%; height: 100%;    background: #4071F4; box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.25); border-radius: 4px; justify-content: center; align-items: center; display: inline-flex">
                                        <button style="background: #37A000;" type="submit" class="btn btn-block"
                                            id="verifyBtn" onclick="return confirm('Are you sure ?');">
                                            <div
                                                style="color: white; font-size: 20px; font-family: Inter; font-weight: 500; word-wrap: break-word">
                                                Verify</div>
                                        </button>
                                    </div>

                                </div>


                            </form>
                        </div>
                    </div>
                </div>

                {{-- model box --}}
                <div class="modal fade" id="exampleModal12" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel4" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                style="position: absolute; top: 10px; right: 10px; background-color: rgba(0,0,0,0.1); border-radius: 50%; border: none; padding: 5px;">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <form id="detailsForm" method="post"
                                action="{{ url('assignmentconfirmationotp') }}" enctype="multipart/form-data">
                                @csrf
                                <div
                                    style="width: 100%; border-radius: 10px; height: 100%; padding: 16px; background: white; box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.25);  flex-direction: column; justify-content: flex-start; align-items: center; gap: 24px; display: inline-flex ">
                                    <div
                                        style="flex-direction: column; justify-content: flex-start; align-items: center; gap: 16px; display: flex">
                                        <div
                                            style="flex-direction: column; justify-content: flex-start; align-items: center; gap: 8px; display: flex">
                                            <div style="width: 62px; height: 62px; position: relative">
                                                <div
                                                    style="width: 62px; height: 62px; left: 62px; top: 62px; position: absolute; transform: rotate(-180deg); transform-origin: 0 0; opacity: 0">
                                                </div>
                                                <div
                                                    style="width: 46.03px; height: 51.64px; left: 7.98px; top: 5.19px; position: absolute; ">
                                                    <img src="{{ asset('image/security-safe.svg') }}"
                                                        alt="security-safe">
                                                </div>
                                            </div>
                                            <div
                                                style="color: #292D32; font-size: 24px; font-family: Inter; font-weight: 500; word-wrap: break-word">
                                                Verification Required</div>
                                            @if ($errors->any())
                                                <div>
                                                    <ul>
                                                        @foreach ($errors->all() as $e)
                                                            <li style="color:red;">{{ $e }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @else
                                            @endif
                                        </div>
                                        <div
                                            style="width: 332px; text-align: center; color: rgba(41, 45, 50, 0.65); font-size: 18px; font-family: Inter; font-weight: 400; word-wrap: break-word">
                                            Please enter the 6-digit OTP sent to your registered email address.
                                        </div>
                                        {{-- </div> --}}


                                        <div class="details-form-field form-group row">
                                            <div class="col-sm-12">
                                                <p class="text-success" id="otpmessage1"></p>
                                            </div>
                                            <div class="col-sm-12">
                                                <p class="text-success" id="otpmessage3"></p>
                                            </div>
                                            <div class="col-sm-12">
                                                <div name="otp"
                                                    style="flex-direction: column; justify-content: flex-start; align-items: center; gap: 16px; display: flex">
                                                    <div
                                                        class="container height-100 d-flex justify-content-center align-items-center">
                                                        <div class="position-relative">
                                                            <div id="otp"
                                                                class="inputs d-flex flex-row justify-content-center mt-2">
                                                                <input name="otp11"
                                                                    class="m-2 text-center form-control rounded"
                                                                    type="text" id="first"
                                                                    maxlength="1" />
                                                                <input name="otp12"
                                                                    class="m-2 text-center form-control rounded"
                                                                    type="text" id="second"
                                                                    maxlength="1" />
                                                                <input name="otp13"
                                                                    class="m-2 text-center form-control rounded"
                                                                    type="text" id="third"
                                                                    maxlength="1" />
                                                                <input name="otp14"
                                                                    class="m-2 text-center form-control rounded"
                                                                    type="text" id="fourth"
                                                                    maxlength="1" />
                                                                <input name="otp15"
                                                                    class="m-2 text-center form-control rounded"
                                                                    type="text" id="fifth"
                                                                    maxlength="1" />
                                                                <input name="otp16"
                                                                    class="m-2 text-center form-control rounded"
                                                                    type="text" id="sixth"
                                                                    maxlength="1" />
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div style="width: 332px; text-align: center" class="resends">
                                                        <span
                                                            style="color: rgba(41, 45, 50, 0.85); font-size: 16px; font-family: Inter; font-weight: 300; word-wrap: break-word">Didn’t
                                                            receive the OTP?</span><span
                                                            style="color: rgba(41, 45, 50, 0.85); font-size: 16px; font-family: Inter; font-weight: 500; text-decoration: underline; word-wrap: break-word">
                                                            <a id="noid" data-id="{{ $debtorid }}"
                                                                data-status="0" data-resend="true"
                                                                class="font-weight-500" style="color:#37a000;">
                                                                Resend</a></span>
                                                    </div>
                                                </div>
                                                <input type="hidden" id="debitid1" name="debitid1"
                                                    class="form-control">
                                                <input type="hidden" id="assignmentgenerate_id1"
                                                    name="assignmentgenerate_id1" class="form-control">
                                                <input type="hidden" id="type1" name="type1"
                                                    class="form-control">
                                                <input type="hidden" id="status1" name="status1"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        style="width: 100%; height: 100%;  background: #4071F4; box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.25); border-radius: 4px; justify-content: center; align-items: center; display: inline-flex">
                                        <button style="background: #37a000;" type="submit" class="btn btn-block"
                                            id="verifyBtn">
                                            <div
                                                style="color: white; font-size: 20px; font-family: Inter; font-weight: 500; word-wrap: break-word">
                                                Verify</div>
                                        </button>
                                    </div>

                                    {{-- </div> --}}
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    {{-- *   --}}
    <div class="d-flex align-items-center justify-content-center text-center h-100vh"
    style="background-image:url('backEnd/image/unnamed.jpg');">
    <div class="form-wrapper m-auto">
        <div class="form-container my-4">
            <div class="register-logo text-center mb-4">
            </div>
            {{-- paste hare  --}}
        </div>
    </div>
</div>
    {{-- *   --}}


    <div class="panel">
        @if ($errors->any())
            {{-- <div class="alert alert-danger"> --}}
            @foreach ($errors->all() as $error)
                <p class="text-danger">{{ $error }}</p>
            @endforeach
            {{-- </div> --}}
        @endif
        @if (session('success_message'))
            <p class="text-danger">{{ session('success_message') }}</p>
        @endif
        {{-- @php
            dd($template->description);
        @endphp --}}
        {{-- new code --}}
        <div
            style="width: 100%; height: 100%; flex-direction: column; justify-content: flex-start; align-items: center; gap: 8px; display: inline-flex">
            <div
                style="width: 62px; height: 62px; justify-content: center; align-items: center; display: inline-flex">
                <div style="width: 62px; height: 62px; position: relative">
                    <div
                        style="width: 51.67px; height: 51.67px; left: 5.17px; top: 5.17px; position: absolute; ">
                        <img src="{{ asset('image/tick-circle.svg') }}" alt="Tick Circle">
                    </div>
                    <div
                        style="width: 62px; height: 62px; left: 62px; top: 62px; position: absolute; transform: rotate(-180deg); transform-origin: 0 0; opacity: 0">
                    </div>
                </div>
            </div>
            <div
                style="color: #292D32; font-size: 24px; font-family: Inter; font-weight: 500; word-wrap: break-word">
                Approval Required</div>
        </div>
        <div
            style="text-align: center; color: rgba(41, 45, 50, 0.65); font-size: 18px; font-family: Inter; font-weight: 400; word-wrap: break-word">
            This action requires approval before it can be completed.</div><br>
        <div style="width: 100%; height: 100%; border: 1px rgba(41, 45, 50, 0.25) solid"></div><br>
        <div>
            {!! $template->description ?? '' !!}
        </div>



        <div style="display: flex">

            <div style="width: 100%; height: 100%; padding-left: 16px; padding-right: 16px; padding-top: 8px; padding-bottom: 8px; background: #28A745; box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.25); border-radius: 4px; justify-content: center; align-items: center; display: inline-flex"
                id="yesid" data-id="{{ $debtorid }}" data-status="1" data-toggle="modal"
                data-target="#exampleModal1">
                <div
                    style="color: white; font-size: 20px; font-family: Inter; font-weight: 500; word-wrap: break-word">
                    Accept</div>
            </div>&nbsp;&nbsp;&nbsp;
            <div style="width: 100%; height: 100%;  padding-left: 16px; padding-right: 16px; padding-top: 8px; padding-bottom: 8px; background: #DC3545; box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.25); border-radius: 4px; justify-content: center; align-items: center; display: inline-flex"
                id="noid" data-id="{{ $debtorid }}" data-status="0" data-toggle="modal"
                data-target="#exampleModal12">
                <div
                    style="color: white; font-size: 20px; font-family: Inter; font-weight: 500; word-wrap: break-word">
                    Refuse</div>
            </div>
        </div>



        {{-- model box --}}
        <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel4" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content " style="border-radius: 3rem;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="position: absolute; top: 10px; right: 10px; background-color: rgba(0,0,0,0.1); border-radius: 50%; border: none; padding: 5px;">
                        <span aria-hidden="true">&times;</span>
                    </button>

                    <form id="detailsForm" method="post" action="{{ url('assignmentconfirmationotp') }}"
                        enctype="multipart/form-data">
                        @csrf


                        <div
                            style="width: 100%; border-radius: 10px; height: 100%; padding: 16px; background: white; box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.25);  flex-direction: column; justify-content: flex-start; align-items: center; gap: 24px; display: inline-flex ">
                            <div
                                style="flex-direction: column; justify-content: flex-start; align-items: center; gap: 16px; display: flex">
                                <div
                                    style="flex-direction: column; justify-content: flex-start; align-items: center; gap: 8px; display: flex">
                                    <div style="width: 62px; height: 62px; position: relative">
                                        <div
                                            style="width: 62px; height: 62px; left: 62px; top: 62px; position: absolute; transform: rotate(-180deg); transform-origin: 0 0; opacity: 0">
                                        </div>
                                        <div
                                            style="width: 46.03px; height: 51.64px; left: 7.98px; top: 5.19px; position: absolute; ">
                                            <img src="{{ asset('image/security-safe.svg') }}"
                                                alt="security-safe">
                                        </div>
                                    </div>
                                    <div
                                        style="color: #292D32; font-size: 24px; font-family: Inter; font-weight: 500; word-wrap: break-word">
                                        Verification Required</div>

                                </div>

                                <div class="details-form-field  row">

                                    <div class="col-sm-12">

                                        <input type="hidden" id="debitid" name="debitid"
                                            class="form-control">
                                        <input type="hidden" id="assignmentgenerate_id"
                                            name="assignmentgenerate_id" class="form-control">
                                        <input type="hidden" id="type" name="type"
                                            class="form-control">
                                        <input type="hidden" id="status" name="status"
                                            class="form-control">
                                    </div>
                                </div>

                                <div
                                    style="width: 332px; text-align: center; color: rgba(41, 45, 50, 0.65); font-size: 18px; font-family: Inter; font-weight: 400; word-wrap: break-word">
                                    Please enter the 6-digit OTP sent to your registered email address.
                                </div>
                            </div>



                            @if ($errors->any())
                                <div>
                                    <ul>
                                        @foreach ($errors->all() as $e)
                                            <li style="color:red;">{{ $e }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @else
                            @endif

                            <div name="otp"
                                style="flex-direction: column; justify-content: flex-start; align-items: center; gap: 16px; display: flex">
                                <div
                                    class="container height-100 d-flex justify-content-center align-items-center">
                                    <div class="position-relative">
                                        <div class="col-sm-12">
                                            <p class="text-success" id="otpmessage"></p>
                                        </div>
                                        <div class="col-sm-12">
                                            <p class="text-success" id="otpmessage2"></p>
                                        </div>
                                        <div id="otp"
                                            class="inputs d-flex flex-row justify-content-center mt-2">
                                            <input name="otp1"
                                                class="m-2 text-center form-control rounded"
                                                type="text" id="first" maxlength="1" />
                                            <input name="otp2"
                                                class="m-2 text-center form-control rounded"
                                                type="text" id="second" maxlength="1" />
                                            <input name="otp3"
                                                class="m-2 text-center form-control rounded"
                                                type="text" id="third" maxlength="1" />
                                            <input name="otp4"
                                                class="m-2 text-center form-control rounded"
                                                type="text" id="fourth" maxlength="1" />
                                            <input name="otp5"
                                                class="m-2 text-center form-control rounded"
                                                type="text" id="fifth" maxlength="1" />
                                            <input name="otp6"
                                                class="m-2 text-center form-control rounded"
                                                type="text" id="sixth" maxlength="1" />
                                        </div>

                                    </div>
                                </div>
                                <div style="width: 332px; text-align: center" class="resends"><span
                                        style="color: rgba(41, 45, 50, 0.85); font-size: 16px; font-family: Inter; font-weight: 300; word-wrap: break-word">Didn’t
                                        receive the OTP?</span><span
                                        style="color: rgba(41, 45, 50, 0.85); font-size: 16px; font-family: Inter; font-weight: 500; word-wrap: break-word">
                                        <a id="yesid" data-id="{{ $debtorid }}" data-status="1"
                                            data-resend="true" class="font-weight-500"
                                            style="color:#37a000;"> Resend</a>
                                    </span>
                                </div>
                            </div>


                            <div
                                style="width: 100%; height: 100%;    background: #4071F4; box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.25); border-radius: 4px; justify-content: center; align-items: center; display: inline-flex">
                                <button style="background: #37A000;" type="submit" class="btn btn-block"
                                    id="verifyBtn" onclick="return confirm('Are you sure ?');">
                                    <div
                                        style="color: white; font-size: 20px; font-family: Inter; font-weight: 500; word-wrap: break-word">
                                        Verify</div>
                                </button>
                            </div>

                        </div>


                    </form>
                </div>
            </div>
        </div>

        {{-- model box --}}
        <div class="modal fade" id="exampleModal12" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel4" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="position: absolute; top: 10px; right: 10px; background-color: rgba(0,0,0,0.1); border-radius: 50%; border: none; padding: 5px;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <form id="detailsForm" method="post" action="{{ url('assignmentconfirmationotp') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div
                            style="width: 100%; border-radius: 10px; height: 100%; padding: 16px; background: white; box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.25);  flex-direction: column; justify-content: flex-start; align-items: center; gap: 24px; display: inline-flex ">
                            <div
                                style="flex-direction: column; justify-content: flex-start; align-items: center; gap: 16px; display: flex">
                                <div
                                    style="flex-direction: column; justify-content: flex-start; align-items: center; gap: 8px; display: flex">
                                    <div style="width: 62px; height: 62px; position: relative">
                                        <div
                                            style="width: 62px; height: 62px; left: 62px; top: 62px; position: absolute; transform: rotate(-180deg); transform-origin: 0 0; opacity: 0">
                                        </div>
                                        <div
                                            style="width: 46.03px; height: 51.64px; left: 7.98px; top: 5.19px; position: absolute; ">
                                            <img src="{{ asset('image/security-safe.svg') }}"
                                                alt="security-safe">
                                        </div>
                                    </div>
                                    <div
                                        style="color: #292D32; font-size: 24px; font-family: Inter; font-weight: 500; word-wrap: break-word">
                                        Verification Required</div>
                                    @if ($errors->any())
                                        <div>
                                            <ul>
                                                @foreach ($errors->all() as $e)
                                                    <li style="color:red;">{{ $e }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @else
                                    @endif
                                </div>
                                <div
                                    style="width: 332px; text-align: center; color: rgba(41, 45, 50, 0.65); font-size: 18px; font-family: Inter; font-weight: 400; word-wrap: break-word">
                                    Please enter the 6-digit OTP sent to your registered email address.
                                </div>
                                {{-- </div> --}}


                                <div class="details-form-field form-group row">
                                    <div class="col-sm-12">
                                        <p class="text-success" id="otpmessage1"></p>
                                    </div>
                                    <div class="col-sm-12">
                                        <p class="text-success" id="otpmessage3"></p>
                                    </div>
                                    <div class="col-sm-12">
                                        <div name="otp"
                                            style="flex-direction: column; justify-content: flex-start; align-items: center; gap: 16px; display: flex">
                                            <div
                                                class="container height-100 d-flex justify-content-center align-items-center">
                                                <div class="position-relative">
                                                    <div id="otp"
                                                        class="inputs d-flex flex-row justify-content-center mt-2">
                                                        <input name="otp11"
                                                            class="m-2 text-center form-control rounded"
                                                            type="text" id="first"
                                                            maxlength="1" />
                                                        <input name="otp12"
                                                            class="m-2 text-center form-control rounded"
                                                            type="text" id="second"
                                                            maxlength="1" />
                                                        <input name="otp13"
                                                            class="m-2 text-center form-control rounded"
                                                            type="text" id="third"
                                                            maxlength="1" />
                                                        <input name="otp14"
                                                            class="m-2 text-center form-control rounded"
                                                            type="text" id="fourth"
                                                            maxlength="1" />
                                                        <input name="otp15"
                                                            class="m-2 text-center form-control rounded"
                                                            type="text" id="fifth"
                                                            maxlength="1" />
                                                        <input name="otp16"
                                                            class="m-2 text-center form-control rounded"
                                                            type="text" id="sixth"
                                                            maxlength="1" />
                                                    </div>

                                                </div>
                                            </div>
                                            <div style="width: 332px; text-align: center" class="resends">
                                                <span
                                                    style="color: rgba(41, 45, 50, 0.85); font-size: 16px; font-family: Inter; font-weight: 300; word-wrap: break-word">Didn’t
                                                    receive the OTP?</span><span
                                                    style="color: rgba(41, 45, 50, 0.85); font-size: 16px; font-family: Inter; font-weight: 500; text-decoration: underline; word-wrap: break-word">
                                                    <a id="noid" data-id="{{ $debtorid }}"
                                                        data-status="0" data-resend="true"
                                                        class="font-weight-500" style="color:#37a000;">
                                                        Resend</a></span>
                                            </div>
                                        </div>
                                        <input type="hidden" id="debitid1" name="debitid1"
                                            class="form-control">
                                        <input type="hidden" id="assignmentgenerate_id1"
                                            name="assignmentgenerate_id1" class="form-control">
                                        <input type="hidden" id="type1" name="type1"
                                            class="form-control">
                                        <input type="hidden" id="status1" name="status1"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div
                                style="width: 100%; height: 100%;  background: #4071F4; box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.25); border-radius: 4px; justify-content: center; align-items: center; display: inline-flex">
                                <button style="background: #37a000;" type="submit" class="btn btn-block"
                                    id="verifyBtn">
                                    <div
                                        style="color: white; font-size: 20px; font-family: Inter; font-weight: 500; word-wrap: break-word">
                                        Verify</div>
                                </button>
                            </div>

                            {{-- </div> --}}
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- *   --}}
    <div class="row row-sm">
        <div class="col-3">
            <div class="form-group">
                <label class="font-weight-600">Show/Hide</label>
                <input type="text" name="showorhide"
                    value="{{ $entrieseditdata->amounthidestatus ?? '' }}" class=" form-control"
                    placeholder="Enter Show/Hide">
            </div>
        </div>
        <div class="col-3">
            <div class="form-group">
                <label class="font-weight-600">Primary email</label>
                <input type="email" name="email" value="{{ $entrieseditdata->email ?? '' }}"
                    class=" form-control" placeholder="Enter email">
            </div>
        </div>
        <div class="col-3">
            <div class="form-group">
                <label class="font-weight-600">Secondary email</label>
                <input type="email" name="secondaryemail"
                    value="{{ $entrieseditdata->email ?? '' }}" class=" form-control"
                    placeholder="Enter email">
            </div>
        </div>
    </div>
    +"id": 38
    +"mailstatus": 0
    +"assignmentgenerate_id": "ABD100411"
    +"type": 1
    +"status": 2
    +"amounthidestatus": 1
    +"created_by": 878
    +"unique": null
    +"name": "kgs"
    +"amount": "999"
    +"year": "2024-25"
    +"date": "01/01/2024"
    +"address": "Delhi"
    +"email": "sukhbahadur@kgsomani.com"
    +"entityname": null
    +"secondaryemail": null
    +"showorhide": null
    +"otp": null
    +"otpverifydate": null
    +"created_at": "2024-05-10 17:31:34"
    +"updated_at": "2024-05-13 10:56:42"
    <td>
        @if (Auth::user()->role_id == 13)
            @if ($assignmentbudgetingDatas->status != 0)
                <a id="editCompanys" data-id="{{ $assignmentbudgetingDatas->assignmentgenerate_id }}" data-toggle="modal"
                    data-target="#exampleModal134">
                    @if ($assignmentbudgetingDatas->status == 1)
                        <span class="badge badge-primary">OPEN</span>
                    @else
                        <span class="badge badge-danger">CLOSED</span>
                    @endif
                </a>
            @else
                @if ($assignmentbudgetingDatas->status == 1)
                    <span class="badge badge-primary">OPEN</span>
                @else
                    <span class="badge badge-danger">CLOSED</span>
                @endif
            @endif
        @else
            @if ($assignmentbudgetingDatas->status == 1)
                <span class="badge badge-primary">OPEN</span>
            @else
                <span class="badge badge-danger">CLOSED</span>
            @endif

        @endif
    </td>
    {{-- *   --}}
    "id" => 28
    "mailstatus" => 0
    "assignmentgenerate_id" => "ABD100411"
    "type" => 1
    "status" => 2
    "amounthidestatus" => 1
    "created_by" => 878
    "unique" => "1234567890"
    "name" => "sukh"
    "amount" => "323"
    "year" => "2024-25"
    "date" => "12/12/2024"
    "address" => "Delhi"
    "email" => "sukhbahadur1993@gmail.com"
    "entityname" => null
    "secondaryemail" => null
    "showorhide" => null
    "otp" => null
    "otpverifydate" => null
    "created_at" => "2024-05-10 16:31:45"
    "updated_at" => "2024-05-10 16:31:45"
    ]
    {{-- *   --}}

    {#3466 ▼
        +"id": 17
        +"mailstatus": 0
        +"assignmentgenerate_id": "ABD100411"
        +"type": 1
        +"status": 2
        +"amounthidestatus": 1
        +"created_by": 878
        +"unique": null
        +"name": "kgs"
        +"amount": "999"
        +"year": "2024-25"
        +"date": "01/01/2024"
        +"address": "Delhi"
        +"email": "sukhbahadur@kgsomani.com"
        +"otp": null
        +"otpverifydate": null
        +"created_at": "2024-05-10 11:45:19"
        +"updated_at": "2024-05-10 11:45:19"
      }

      #parameters: array:7 [▼
      "_token" => "X4U0JXFEtfkIvnEQwubbCLpOJN3sxkyhxjF7WIXy"
      "name" => "kgs"
      "amount" => "9998889"
      "year" => "2024-25"
      "date" => "01/01/2024"
      "address" => "Delhi"
      "email" => "sukhbahadur@kgsomani.com"
    ]


    background-color: #00ff6a;

    Unique Nosssssss.	Name	Amount		Year	Date	Address	Email	Email Status	Confirmation Status	Created By	Remark	Amount	Attachment	Edit
    Kgs	999		2024-25	January 01,2024	Delhi	sukhbahadur@kgsomani.com	Not Sent	Draft	Administrator
1234567890	Sukh	323		2024-25	December 12,2024	Delhi	sukhbahadur1993@gmail.com	Not Sent	Draft	Administrator

    {{-- *   --}}
    {{-- *   --}}
    {{-- *   --}}
    {{-- *   --}}
    {{-- *Balance confirmation   --}}
    app\Http\Controllers\AssignmentconfirmationController.php
    dd($value['year']);
    if ($skippedBecauseEmpty || $skippedBecauseInvalidEmail || $skippedBecauseDuplicate) {
        $message .= 'Invalid year';
    }
    
    {{-- *   --}}

    #parameters: array:16 [▼
    "_token" => "AZVnl9Vg2AwfXu65ZlagFC6peedKXpjrDC9ImXn6"
    "client_id" => "191"
    "assignment_id" => "212"
    "assignmentname" => "shahid222"
    "duedate" => "2024-05-08"
    "periodstart" => "2024-05-10"
    "periodend" => "2024-05-18"
    "roleassignment" => "1"
    "esthours" => "11"
    "stdcost" => "22"
    "estcost" => "22"
    "fees" => "222"
    "leadpartner" => "844"
    "otherpartner" => "838"
    "teammember_id" => array:1 [▼
      0 => "847"
    ]
    "type" => array:1 [▼
      0 => "0"
    ]
    {{-- *   --}}
    columnDefs: [{
    @if (Auth::user()->role_id == 11)
        targets: [1, 2, 3],
@else
targets: [1, 2],
    @endif
    orderable: false
    }],
    {{-- *   --}}

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#examplee').DataTable({
                "order": [
                    //   [2, "desc"]
                ],
                //   searching: false,
                columnDefs: [{
                    targets: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                    orderable: false
                }],
                buttons: []
            });
        });
    </script>
    {{-- *   --}}
    filename: 'Timesheet Save',



    columnDefs: [{
    targets: [1, 2, 3],
    orderable: false
    }],

    <script>
        $(document).ready(function() {
            $('#examplee').DataTable({
                dom: 'Bfrtip',
                "order": [
                    [0, "desc"]
                ],

                columnDefs: [{
                    targets: [1, 2, 3],
                    orderable: false
                }],

                buttons: [{
                        extend: 'copyHtml5',
                        exportOptions: {
                            columns: [0, ':visible']
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        filename: 'Notification',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        filename: 'Notification',
                        exportOptions: {
                            columns: [1, 2, 3]
                        }
                    },
                    'colvis'
                ]
            });
        });
    </script>
    {{-- *   --}}
    public function ok(Request $request)
    {
    $teammember = DB::table('teammembers')
    ->leftJoin('timesheetusers', 'timesheetusers.createdby', 'teammembers.id')
    ->where('teammembers.status', 1)
    ->where('timesheetusers.date', '<=', now()->subWeeks(1)->endOfWeek())
        ->select('teammembers.emailid',
    'teammembers.team_member', 'teammembers.id')
    ->distinct('timesheetusers.createdby')
    ->get();

    // Get the last submission date for each user only sunday and suterday
    foreach ($teammember as $user) {
    $lastSubmissionDate = DB::table('timesheetusers')
    // get all date of this user
    ->where('createdby', $user->id)
    ->where('date', '<=', now()->subWeeks(1)->endOfWeek())
          ->where('status',
    '!=', 0)
          ->where(function ($query) {
            $query->whereRaw('DAYOFWEEK(date) = 1') // Sunday
    ->orWhereRaw('DAYOFWEEK(date) = 7'); // Saturday
    })
    // ->distinct('date')
    ->max('date');

    // Format the date as 'd-m-y'
    // $lastSubmissionDate = Carbon::parse($lastSubmissionDate)->format('d-m-y');
    $lastSubmissionDate = $lastSubmissionDate ? Carbon::parse($lastSubmissionDate)->format('d-m-Y') : '';

    $user->last_submission_date = $lastSubmissionDate;
    }
    // dd($teammember);
    // Create an array for the Excel export (excluding 'id')
    $excelData = $teammember->filter(function ($user) {
    return !empty($user->last_submission_date);
    })->map(function ($user) {
    return [
    'team_member' => $user->team_member,
    'emailid' => $user->emailid,
    'last_submission_date' => $user->last_submission_date,
    ];
    })->toArray();

    $export = new TimesheetLastWeekExport(collect($excelData));
    $excelFileName = 'Timesheet_last_week.xlsx';
    Excel::store($export, $excelFileName);

    // Modify the data for the email (excluding 'id')
    $emailData = array(
    'subject' => "Timesheet Not filled Last Week",
    'teammember' => $teammember->map(function ($user) {
    return (object) [
    'team_member' => $user->team_member,
    'emailid' => $user->emailid,
    'last_submission_date' => $user->last_submission_date,
    ];
    }),
    );

    // dd($teammember);

    // Attach the Excel file to the email
    Mail::send('emails.timesheetnotfilledlastweekreminder', $emailData, function ($msg) use ($emailData, $excelFileName)
    {
    $msg->to('itsupport_delhi@vsa.co.in');
    $msg->cc('Admin_delhi@vsa.co.in');
    // Attach the Excel file to the email
    $msg->attach(storage_path('app/' . $excelFileName), [
    'as' => $excelFileName,
    'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    ]);
    $msg->subject($emailData['subject']);
    });

    $output = array('msg' => 'Downloaded Successfully');
    return back()->with('success', $output);
    }
    {{-- *   --}}
    use App\Exports\TimesheetLastWeekExport;
    use Illuminate\Console\Command;
    use DB;
    use Carbon\Carbon;
    use Illuminate\Support\Facades\Mail;
    use Maatwebsite\Excel\Facades\Excel;
    {{-- *   --}}
    // Start Hare
    $nextweektimesheet1 = DB::table('timesheetusers')
    ->where('createdby', 893)
    ->whereBetween('date', ['2024-03-25', '2024-03-30'])
    // ->get();
    ->update(['status' => 0]);


    $nextweektimesheet2 = DB::table('timesheets')
    ->where('created_by', 893)
    ->whereBetween('date', ['2024-03-25', '2024-03-30'])
    // ->get();
    ->update(['status' => 0]);

    $nextweektimesheet = DB::table('timesheetreport')
    ->where('teamid', 893)
    ->whereDate('startdate', '2024-03-25')
    // ->get();
    ->delete();

    dd($nextweektimesheet1);
    {{-- *   --}}
    // $co = DB::table('timesheetusers')
    // ->where('createdby', auth()->user()->teammember_id)
    // ->whereBetween('date', [$previousMondayFormatted, $nextSaturdayFormatted])
    // ->select('partner', 'date', DB::raw('SUM(hour) as total_hours'))
    // ->groupBy('partner', 'date')
    // ->get();

    // // Now, let's count the distinct dates
    // $distinct_dates = $co->pluck('date')->unique()->count();

    // dd($co, $distinct_dates);

    // $co = DB::table('timesheetusers')
    // ->where('createdby', auth()->user()->teammember_id)
    // ->whereBetween('date', [$previousMondayFormatted, $nextSaturdayFormatted])
    // ->select('partner', DB::raw('SUM(hour) as total_hours'), DB::raw('COUNT(DISTINCT date) as row_count'))
    // ->groupBy('partner')
    // ->get();

    // // Now count the distinct dates
    // $row_count = $co->sum('row_count');

    // dd($co, $row_count);




    $co = DB::table('timesheetusers')
    ->where('createdby', auth()->user()->teammember_id)
    ->whereBetween('date', [$previousMondayFormatted, $nextSaturdayFormatted])
    ->select('date')
    ->groupBy('date')
    ->get();

    // Now, let's count the distinct dates
    $distinct_dates = $co->count();
    dd($distinct_dates);
    {{-- *   --}}
    @php
        if ($request->ajax()) {
            if (isset($request->timesheetdate)) {
                if (auth()->user()->role_id == 13) {
                    echo '<option>Select Client</option>';

                    $selectedDate = \DateTime::createFromFormat('d-m-Y', $request->timesheetdate);

                    $clientss = DB::table('assignmentmappings')
                        ->leftjoin(
                            'assignmentbudgetings',
                            'assignmentbudgetings.assignmentgenerate_id',
                            'assignmentmappings.assignmentgenerate_id',
                        )
                        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
                        ->where(function ($query) {
                            $query
                                ->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
                                ->orWhere('assignmentmappings.otherpartner', auth()->user()->teammember_id);
                        })
                        ->where(function ($query) use ($selectedDate) {
                            $query
                                ->whereNull('otpverifydate')
                                ->orWhere('otpverifydate', '>=', $selectedDate->modify('-1 day'));
                        })
                        // ->whereNotNull('clients.client_name')
                        ->select('clients.client_name', 'clients.id', 'clients.client_code')
                        ->orderBy('client_name', 'ASC')
                        ->distinct()
                        ->get();

                    // done default $clients in ajax if need then $clientss add in ajax target $request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34
                    $clients = DB::table('clients')
                        ->whereIn('id', [29, 32, 33, 34])
                        ->select('clients.client_name', 'clients.id', 'clients.client_code')
                        ->orderBy('client_name', 'ASC')
                        ->distinct()
                        ->get();

                    $client = $clientss->merge($clients);

                    foreach ($client as $clients) {
                        echo "<option value='" .
                            $clients->id .
                            "'>" .
                            $clients->client_name .
                            '( ' .
                            $clients->client_code .
                            ' )' .
                            '</option>';
                    }
                } else {
                    echo '<option>Select Client</option>';

                    $selectedDate = \DateTime::createFromFormat('d-m-Y', $request->timesheetdate);
                    $clientss = DB::table('assignmentteammappings')
                        ->leftjoin(
                            'assignmentmappings',
                            'assignmentmappings.id',
                            'assignmentteammappings.assignmentmapping_id',
                        )
                        ->leftjoin(
                            'assignmentbudgetings',
                            'assignmentbudgetings.assignmentgenerate_id',
                            'assignmentmappings.assignmentgenerate_id',
                        )
                        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
                        ->orwhere('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
                        ->whereNotIn('assignmentbudgetings.assignmentname', [
                            'Unallocated',
                            'Official Travel',
                            'Off/Holiday',
                            'Seminar/Conference/Post Qualification Course',
                        ])
                        ->where(function ($query) use ($selectedDate) {
                            $query
                                ->whereNull('otpverifydate')
                                ->orWhere('otpverifydate', '>=', $selectedDate->modify('-1 day'));
                        })
                        ->select('clients.client_name', 'clients.id', 'clients.client_code')
                        ->orderBy('client_name', 'ASC')
                        ->distinct()
                        ->get();
                    // ->get();

                    // done default $clients in ajax if need then $clientss add in ajax target $request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34
                    $clients = DB::table('clients')
                        ->whereIn('id', [29, 32, 33, 34])
                        ->select('clients.client_name', 'clients.id', 'clients.client_code')
                        ->orderBy('client_name', 'ASC')
                        ->distinct()
                        ->get();

                    $client = $clientss->merge($clients);

                    foreach ($client as $clients) {
                        echo "<option value='" .
                            $clients->id .
                            "'>" .
                            $clients->client_name .
                            '( ' .
                            $clients->client_code .
                            ' )' .
                            '</option>';
                    }
                }
            }

            if (isset($request->cid)) {
                if (auth()->user()->role_id == 13) {
                    echo '<option>Select Assignment</option>';

                    if ($request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34) {
                        $clients = DB::table('clients')
                            // ->whereIn('id', [29, 32, 33, 34])
                            ->where('id', $request->cid)
                            ->select('clients.client_name', 'clients.id', 'clients.client_code')
                            ->orderBy('client_name', 'ASC')
                            ->distinct()
                            ->get();
                        // dd($clients);
                        $id = $clients[0]->id;
                        foreach (
                            DB::table('assignmentbudgetings')
                                ->where('client_id', $id)
                                ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
                                ->orderBy('assignment_name')
                                ->get()
                            as $sub
                        ) {
                            echo "<option value='" .
                                $sub->assignmentgenerate_id .
                                "'>" .
                                $sub->assignment_name .
                                '( ' .
                                $sub->assignmentname .
                                '/' .
                                $sub->assignmentgenerate_id .
                                ' )' .
                                '</option>';
                        }
                    } else {
                        // dd('hi 3');

                        $selectedDate = \DateTime::createFromFormat('d-m-Y', $request->datepickers);

                        foreach (
                            DB::table('assignmentbudgetings')
                                ->where('assignmentbudgetings.client_id', $request->cid)
                                ->leftJoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
                                ->leftJoin(
                                    'assignmentmappings',
                                    'assignmentmappings.assignmentgenerate_id',
                                    'assignmentbudgetings.assignmentgenerate_id',
                                )
                                ->where(function ($query) {
                                    $query
                                        ->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
                                        ->orWhere('assignmentmappings.otherpartner', auth()->user()->teammember_id);
                                })
                                ->where(function ($query) use ($selectedDate) {
                                    $query
                                        ->whereNull('otpverifydate')
                                        ->orWhere('otpverifydate', '>=', $selectedDate->modify('-1 day'));
                                })
                                ->orderBy('assignment_name')
                                ->get()
                            as $sub
                        ) {
                            echo "<option value='" .
                                $sub->assignmentgenerate_id .
                                "'>" .
                                $sub->assignment_name .
                                '( ' .
                                $sub->assignmentname .
                                '/' .
                                $sub->assignmentgenerate_id .
                                ' )' .
                                '</option>';
                        }
                    }
                } else {
                    echo '<option>Select Assignment</option>';

                    if ($request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34) {
                        $clients = DB::table('clients')
                            // ->whereIn('id', [29, 32, 33, 34])
                            ->where('id', $request->cid)
                            ->select('clients.client_name', 'clients.id', 'clients.client_code')
                            ->orderBy('client_name', 'ASC')
                            ->distinct()
                            ->get();
                        // dd($clients);
                        $id = $clients[0]->id;
                        foreach (
                            DB::table('assignmentbudgetings')
                                ->where('client_id', $id)
                                ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
                                ->orderBy('assignment_name')
                                ->get()
                            as $sub
                        ) {
                            echo "<option value='" .
                                $sub->assignmentgenerate_id .
                                "'>" .
                                $sub->assignment_name .
                                '( ' .
                                $sub->assignmentname .
                                '/' .
                                $sub->assignmentgenerate_id .
                                ' )' .
                                '</option>';
                        }
                    } else {
                        //  i have add this code after kartic bindal problem
                        $selectedDate = \DateTime::createFromFormat('d-m-Y', $request->datepickers);

                        foreach (
                            DB::table('assignmentbudgetings')
                                ->join(
                                    'assignmentmappings',
                                    'assignmentmappings.assignmentgenerate_id',
                                    'assignmentbudgetings.assignmentgenerate_id',
                                )
                                ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
                                ->leftjoin(
                                    'assignmentteammappings',
                                    'assignmentteammappings.assignmentmapping_id',
                                    'assignmentmappings.id',
                                )
                                ->where('assignmentbudgetings.client_id', $request->cid)
                                ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
                                //  ->where('assignmentteammappings.status', '!=', 0)
                                // ->whereNull('assignmentteammappings.status')
                                ->where(function ($query) {
                                    $query
                                        ->whereNull('assignmentteammappings.status')
                                        ->orWhere('assignmentteammappings.status', '=', 1);
                                })
                                ->where(function ($query) use ($selectedDate) {
                                    $query
                                        ->whereNull('otpverifydate')
                                        //   ->orWhere('otpverifydate', '>=', $selectedDate);
                                        // // ->orWhere('otpverifydate', '>=', $selectedDate);
                                        ->orWhere('otpverifydate', '>=', $selectedDate->modify('-1 day'));
                                })
                                ->orderBy('assignment_name')
                                ->get()
                            as $sub
                        ) {
                            echo "<option value='" .
                                $sub->assignmentgenerate_id .
                                "'>" .
                                $sub->assignment_name .
                                '( ' .
                                $sub->assignmentname .
                                '/' .
                                $sub->assignmentgenerate_id .
                                ' )' .
                                '</option>';
                        }
                    }
                }
            }

            if (isset($request->assignment)) {
                // dd($request->assignment);
                if (auth()->user()->role_id == 11) {
                    echo "<option value=''>Select Partner</option>";
                    foreach (
                        DB::table('assignmentmappings')

                            ->leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
                            ->leftjoin('teammembers as team', 'team.id', 'assignmentmappings.otherpartner')
                            ->where('assignmentmappings.assignmentgenerate_id', $request->assignment)
                            ->select(
                                'team.team_member as team_member',
                                'team.id',
                                'teammembers.id',
                                'teammembers.team_member',
                            )
                            ->get()
                        as $subs
                    ) {
                        echo "<option value='" . $subs->id . "'>" . $subs->team_member . '</option>';
                    }
                } elseif (auth()->user()->role_id == 13) {
                    echo "<option value=''>Select Partner</option>";
                    foreach (
                        DB::table('teammembers')
                            ->where('id', auth()->user()->teammember_id)
                            ->select('teammembers.id', 'teammembers.team_member')
                            ->get()
                        as $subs
                    ) {
                        echo "<option value='" . $subs->id . "'>" . $subs->team_member . '</option>';
                    }
                } else {
                    //die;
                    echo "<option value=''>Select Partner</option>";
                    foreach (
                        DB::table('assignmentmappings')

                            ->leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
                            ->leftjoin('teammembers as team', 'team.id', 'assignmentmappings.otherpartner')
                            ->where('assignmentmappings.assignmentgenerate_id', $request->assignment)
                            ->select(
                                'team.team_member as team_member',
                                'team.id',
                                'teammembers.id',
                                'teammembers.team_member',
                            )
                            ->get()
                        as $subs
                    ) {
                        echo "<option value='" . $subs->id . "'>" . $subs->team_member . '</option>';
                    }
                }
            }
        } else {
            return view('backEnd.timesheet.create', compact('client', 'teammember', 'assignment', 'partner'));
        }
    @endphp
    {{-- *   --}}
    <select class="language form-control" id="assignmentId" name="assignmentId">
        <option value="">Please Select One</option>
        @php
            $displayedValues = [];
        @endphp
        {{-- @foreach ($assignmentsname as $assignmentname)
            @if (!in_array($assignmentname->assignment_name, $displayedValues))
                <option value="{{ $assignmentname->id }}"
                    {{ old('assignmentId') == $assignmentname->id ? 'selected' : '' }}>
                    {{ $assignmentname->assignment_name }}
                </option>
                @php
                    $displayedValues[] = $assignmentname->assignment_name;
                @endphp
            @endif
        @endforeach --}}

        @foreach ($assignmentsname as $assignmentname)
            @if (!in_array($assignmentname->assignmentname, $displayedValues))
                <option value="{{ $assignmentname->assignmentgenerate_id }}"
                    {{ old('assignmentId') == $assignmentname->assignmentgenerate_id ? 'selected' : '' }}>
                    {{ $assignmentname->assignmentname }}
                </option>
                @php
                    $displayedValues[] = $assignmentname->assignmentname;
                @endphp
            @endif
        @endforeach
    </select>
    {{-- *   --}}
    {{-- *   --}}
    // if ($role_id == 13) {
    // $query = DB::table('assignmentmappings')
    // ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id',
    'assignmentmappings.assignmentgenerate_id')
    // ->leftjoin('teammembers', function ($join) {
    // $join->on('teammembers.id', 'assignmentmappings.otherpartner')
    // ->orOn('teammembers.id', 'assignmentmappings.leadpartner');
    // })
    // ->leftjoin('titles', 'titles.id', 'teammembers.title_id')
    // ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
    // // ->where('assignmentbudgetings.status', 1)
    // ->whereNotIn('teammembers.team_member', ['NA', 'test staff'])
    // ->select(
    // 'assignmentmappings.id',
    // 'teammembers.id as teamid',
    // 'teammembers.team_member',
    // 'teammembers.staffcode',
    // 'teammembers.role_id',
    // 'titles.title',
    // 'assignmentmappings.assignmentgenerate_id',
    // 'assignmentbudgetings.assignmentname',
    // 'assignmentmappings.otherpartner',
    // 'assignmentmappings.leadpartner',
    // 'assignmentmappings.leadpartnerhour',
    // 'assignmentmappings.otherpartnerhour',
    // );


    // if ($teamname) {
    // $query->where('assignmentmappings.leadpartner', $teamname)
    // // $query->where('assignmentmappings.otherpartner', $teamname)
    // ->where('teammembers.id', $teamname);
    // // ->orWhere('assignmentmappings.otherpartner', $teamname);
    // }

    // $teammemberDatas = $query->get();
    // return view('backEnd.timesheet.assignmentlistwithhour', compact('teammemberDatas'));
    // }
    // if ($role_id == 13) {
    // $query = DB::table('assignmentmappings')
    // ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id',
    'assignmentmappings.assignmentgenerate_id')
    // ->leftjoin('teammembers', function ($join) {
    // $join->on('teammembers.id', 'assignmentmappings.otherpartner')
    // ->orOn('teammembers.id', 'assignmentmappings.leadpartner');
    // })
    // ->leftjoin('titles', 'titles.id', 'teammembers.title_id')
    // ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
    // // ->where('assignmentbudgetings.status', 1)
    // ->whereNotIn('teammembers.team_member', ['NA', 'test staff'])
    // ->select(
    // 'assignmentmappings.id',
    // 'teammembers.id as teamid',
    // 'teammembers.team_member',
    // 'teammembers.staffcode',
    // 'teammembers.role_id',
    // 'titles.title',
    // 'assignmentmappings.assignmentgenerate_id',
    // 'assignmentbudgetings.assignmentname',
    // 'assignmentmappings.otherpartner',
    // 'assignmentmappings.leadpartner',
    // 'assignmentmappings.leadpartnerhour',
    // 'assignmentmappings.otherpartnerhour',
    // );


    // if ($teamname) {
    // // $query->where('assignmentmappings.leadpartner', $teamname)
    // $query->where('assignmentmappings.otherpartner', $teamname)
    // ->where('teammembers.id', $teamname);
    // // ->orWhere('assignmentmappings.otherpartner', $teamname);
    // }

    // $teammemberDatas = $query->get();
    // return view('backEnd.timesheet.assignmentlistwithhour', compact('teammemberDatas'));
    // }
    // if ($role_id == 13) {
    // $query = DB::table('assignmentmappings')
    // ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=',
    'assignmentmappings.assignmentgenerate_id')
    // ->leftJoin('teammembers', function ($join) {
    // $join->on('teammembers.id', '=', 'assignmentmappings.otherpartner')
    // ->orOn('teammembers.id', '=', 'assignmentmappings.leadpartner');
    // })
    // ->leftJoin('titles', 'titles.id', '=', 'teammembers.title_id')
    // ->leftJoin('roles', 'roles.id', '=', 'teammembers.role_id')
    // ->whereNotIn('teammembers.team_member', ['NA', 'test staff'])
    // ->select(
    // 'assignmentmappings.id',
    // 'teammembers.id as teamid',
    // 'teammembers.team_member',
    // 'teammembers.staffcode',
    // 'teammembers.role_id',
    // 'titles.title',
    // 'assignmentmappings.assignmentgenerate_id',
    // 'assignmentbudgetings.assignmentname',
    // 'assignmentmappings.otherpartner',
    // 'assignmentmappings.leadpartner',
    // 'assignmentmappings.leadpartnerhour',
    // 'assignmentmappings.otherpartnerhour'
    // );

    // if ($teamname) {
    // $query->where(function ($query) use ($teamname) {
    // $query->where('assignmentmappings.leadpartner', $teamname)
    // ->orWhere('assignmentmappings.otherpartner', $teamname)
    // ->where('teammembers.id', $teamname);
    // });
    // }

    // $teammemberDatas = $query->get()->filter(function ($item) use ($teamname) {
    // return $item->teamid === $teamname;
    // });

    // dd($teammemberDatas);

    // return view('backEnd.timesheet.assignmentlistwithhour', compact('teammemberDatas'));
    // }
    {{-- *   --}}


    @foreach ($patnerdata as $teammemberData)
        <tr>
            {{-- @php
                                        $totalhour = DB::table('timesheetusers')
                                            ->leftJoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
                                            ->where(
                                                'timesheetusers.assignmentgenerate_id',
                                                $teammemberData->assignmentgenerate_id,
                                            )
                                            ->where('timesheetusers.createdby', $teammemberData->teamid)
                                            ->select(DB::raw('SUM(totalhour) as total_hours'))
                                            ->first();

                                        if ($teammemberData->teamid == $teammemberData->otherpartner) {
                                            $update = DB::table('assignmentmappings')
                                                ->where('assignmentgenerate_id', $teammemberData->assignmentgenerate_id)
                                                ->where('otherpartner', $teammemberData->teamid)
                                                ->update(['otherpartnerhour' => $totalhour->total_hours ?? 0]);
                                        }
                                        if ($teammemberData->teamid == $teammemberData->leadpartner) {
                                            $update = DB::table('assignmentmappings')
                                                ->where('assignmentgenerate_id', $teammemberData->assignmentgenerate_id)
                                                ->where('leadpartner', $teammemberData->teamid)
                                                ->update(['leadpartnerhour' => $totalhour->total_hours ?? 0]);
                                        }
                                    @endphp --}}

            <td>{{ $teammemberData->title }} {{ $teammemberData->team_member }}
                ({{ $teammemberData->staffcode }})
            </td>
            <td>{{ $teammemberData->assignmentgenerate_id }}</td>
            <td>{{ $teammemberData->assignmentname }}</td>
            @if ($teammemberData->teamid == $teammemberData->leadpartner)
                <td>{{ $teammemberData->leadpartnerhour ?? 0 }}</td>
            @endif
            @if ($teammemberData->teamid == $teammemberData->otherpartner)
                <td>{{ $teammemberData->otherpartnerhour ?? 0 }}</td>
            @endif
        </tr>
    @endforeach

    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Other Partner </label>
            <select class="language form-control" name="otherpartner"
                @if (Request::is('client/*/edit')) > <option disabled
            style="display:block">Please Select One</option>

            @foreach ($partner as $teammemberData)
            <option value="{{ $teammemberData->id }}"
            @if ($client->leadpartner == $teammemberData->id) selected @endif>
                {{ $teammemberData->team_member }}</option>
                @endforeach
@else
<option></option>
                <option value="">Please Select One</option>
                @foreach ($partner as $teammemberData)
                    <option value="{{ $teammemberData->id }}">
                        {{ $teammemberData->team_member }} ( {{ $teammemberData->staffcode }} )</option>

                @endforeach
                @endif
            </select>
        </div>
    </div>


    return view('backEnd.assignmentmapping.create', compact('client', 'teammember', 'partner', 'assignment',
    'clientss'));
    $partner = Teammember::where('role_id', '=', 13)->where('status', '=', 1)->with('title')
    ->orderBy('team_member', 'asc')->get();
    @if (auth()->user()->role_id != 15)
        <div class="card-head" style="width:950px;">
            <br>
            <b style="float:right;margin-top: -21px;">New Member <a data-toggle="modal" data-target="#exampleModal1"
                    class="btn btn-info-soft btn-sm"><i class="fa fa-plus"></i></a></b>
        </div>
    @endif
    {{-- *   --}}

    <table class="table display table-bordered table-striped table-hover basic">
        <thead>

            <tr>
                <th style="display: none;">id</th>

                <th>Employee Name</th>
                <th>Date</th>
                <th>Day</th>
                <th>Client Name</th>
                <th>Assignment Name</th>

                <th>Work Item</th>
                <th>Location</th>
                <th>Partner</th>

                <th> Hour</th>
                <th>Status</th>

                @if (Auth::user()->role_id == 11 || Auth::user()->teammember_id != $timesheetData[0]->createdby)
                    {{-- +"createdby": 844 --}}
                    <th>Action</th>
                @endif
            </tr>
        </thead>
        <tbody>

            @foreach ($timesheetData as $timesheetDatas)
                <tr>
                    @php
                        $timeid = DB::table('timesheetusers')
                            ->where('timesheetusers.timesheetid', $timesheetDatas->timesheetid)
                            ->first();

                        $client_id = DB::table('timesheetusers')
                            ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
                            ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
                            ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.partner')
                            ->where('timesheetusers.timesheetid', $timesheetDatas->timesheetid)
                            ->select(
                                'clients.client_name',
                                'timesheetusers.hour',
                                'timesheetusers.location',
                                'timesheetusers.*',
                                'assignments.assignment_name',
                                'billable_status',
                                'workitem',
                                'teammembers.team_member',
                                'timesheetusers.timesheetid',
                            )
                            ->get();
                        // dd($client_id);

                        $total = DB::table('timesheetusers')

                            ->where('timesheetusers.timesheetid', $timesheetDatas->timesheetid)
                            ->sum('hour');

                        $dates = date('l', strtotime($timesheetDatas->date));
                    @endphp
                    <td style="display: none;">{{ $timesheetDatas->id }}</td>

                    <td>
                        {{ $timesheetDatas->team_member ?? '' }} </td>
                    <td>{{ date('d-m-Y', strtotime($timesheetDatas->date)) }}
                    </td>
                    <td>
                        @if ($timesheetDatas->date != null)
                            {{ $dates ?? '' }}
                        @endif
                    </td>

                    <span style="font-size: 13px;">


                        <td>

                            @foreach ($client_id as $item)
                                {{ $item->client_name ?? '' }} @if ($item->client_name != 0)
                                    ,
                                @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach ($client_id as $item)
                                {{ $item->assignment_name ?? '' }}@if ($item->assignment_name != null)
                                    ,
                                @endif
                            @endforeach
                        </td>

                        <td>
                            @foreach ($client_id as $item)
                                {{ $item->workitem ?? '' }}@if ($item->workitem != null)
                                    ,
                                @endif
                            @endforeach
                        </td>

                        <td>
                            @foreach ($client_id as $item)
                                {{ $item->location ?? '' }}@if ($item->location != null)
                                    ,
                                @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach ($client_id as $item)
                                {{ $item->team_member ?? '' }} @if ($item->team_member != null)
                                    ,
                                @endif
                            @endforeach
                        </td>







                        <td>{{ $timesheetDatas->hour ?? '' }}</td>
                        <td>
                            @foreach ($client_id as $item)
                                @if ($item->status == 0)
                                    <span class="badge badge-pill badge-warning">saved</span>
@elseif ($item->status == 1 || $item->status == 3)
<span class="badge badge-pill badge-danger">submit</span>
@else
<span class="badge badge-pill badge-secondary">Rejected</span>
                                @endif
                            @endforeach
                        </td>
                        {{-- @php
                            dd($client_id);
                        @endphp --}}
                        @if (Auth::user()->role_id == 11 || Auth::user()->teammember_id != $client_id[0]->createdby)
                            <td>
                                @foreach ($client_id as $item)
                                    @if ($item->status == 2)
                                        <a href="  {{ url('/timesheet/reject/' . $item->id) }}"
                                            onclick="return confirm('Are you sure you want to Reject this timesheet?');">
                                            <button class="btn btn-danger" data-toggle="modal"
                                                style="height: 16px; width: auto; border-radius: 7px; display: flex; align-items: center; justify-content: center;font-size: 11px;"
                                                data-target="#requestModal" disabled>Reject</button>
                                        </a>
@else
<a href="  {{ url('/timesheet/reject/' . $item->id) }}"
                                            onclick="return confirm('Are you sure you want to Reject this timesheet?');">
                                            <button class="btn btn-danger" data-toggle="modal"
                                                style="height: 16px; width: auto; border-radius: 7px; display: flex; align-items: center; justify-content: center;font-size: 11px;"
                                                data-target="#requestModal">Reject</button>
                                        </a>
                                    @endif
                                @endforeach
                            </td>
                        @endif

                </tr>
            @endforeach
        </tbody>
    </table>



















    <table class="table display table-bordered table-striped table-hover basic">
        <thead>

            <tr>
                <th style="display: none;">id</th>

                <th>Employee Name</th>
                <th>Date</th>
                <th>Day</th>
                <th>Client Name</th>
                <th>Assignment Name</th>

                <th>Work Item</th>
                <th>Location</th>
                <th>Partner</th>
                {{-- <th>Hour</th> --}}
                <th> Hour</th>
                <th>Status</th>

                @if (Auth::user()->role_id == 11 || Auth::user()->teammember_id != $timesheetData[0]->createdby)
                    <th>Action</th>
                @endif
            </tr>
        </thead>
        <tbody>

            @foreach ($timesheetData as $timesheetDatas)
                <tr>
                    @php
                        $timeid = DB::table('timesheetusers')
                            ->where('timesheetusers.timesheetid', $timesheetDatas->timesheetid)
                            ->first();

                        $client_id = DB::table('timesheetusers')
                            ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
                            ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
                            ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.partner')
                            ->where('timesheetusers.timesheetid', $timesheetDatas->timesheetid)
                            ->select(
                                'clients.client_name',
                                'timesheetusers.hour',
                                'timesheetusers.location',
                                'timesheetusers.*',
                                'assignments.assignment_name',
                                'billable_status',
                                'workitem',
                                'teammembers.team_member',
                                'timesheetusers.timesheetid',
                            )
                            ->get();
                        // dd($client_id);

                        $total = DB::table('timesheetusers')

                            ->where('timesheetusers.timesheetid', $timesheetDatas->timesheetid)
                            ->sum('hour');

                        $dates = date('l', strtotime($timesheetDatas->date));
                    @endphp
                    <td style="display: none;">{{ $timesheetDatas->id }}</td>

                    <td>
                        {{ $timesheetDatas->team_member ?? '' }} </td>
                    <td>{{ date('d-m-Y', strtotime($timesheetDatas->date)) }}
                    </td>
                    <td>
                        @if ($timesheetDatas->date != null)
                            {{ $dates ?? '' }}
                        @endif
                    </td>

                    <span style="font-size: 13px;">


                        <td>

                            @foreach ($client_id as $item)
                                {{ $item->client_name ?? '' }} @if ($item->client_name != 0)
                                    ,
                                @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach ($client_id as $item)
                                {{ $item->assignment_name ?? '' }}@if ($item->assignment_name != null)
                                    ,
                                @endif
                            @endforeach
                        </td>

                        <td>
                            @foreach ($client_id as $item)
                                {{ $item->workitem ?? '' }}@if ($item->workitem != null)
                                    ,
                                @endif
                            @endforeach
                        </td>

                        <td>
                            @foreach ($client_id as $item)
                                {{ $item->location ?? '' }}@if ($item->location != null)
                                    ,
                                @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach ($client_id as $item)
                                {{ $item->team_member ?? '' }} @if ($item->team_member != null)
                                    ,
                                @endif
                            @endforeach
                        </td>
                        {{-- <td>
               @foreach ($client_id as $item)
                   {{ $item->hour ??''}}  @if ($item->hour != null),@endif
                   @endforeach
               </td> --}}






                        <td>{{ $timesheetDatas->hour ?? '' }}</td>
                        <td>
                            @foreach ($client_id as $item)
                                @if ($item->status == 0)
                                    <span class="badge badge-pill badge-warning">saved</span>
@elseif ($item->status == 1 || $item->status == 3)
<span class="badge badge-pill badge-danger">submit</span>
@else
<span class="badge badge-pill badge-secondary">Rejected</span>
                                @endif
                            @endforeach
                        </td>

                        @if (Auth::user()->role_id == 11 || Auth::user()->teammember_id != $client_id[0]->createdby)
                            <td>
                                @foreach ($client_id as $item)
                                    @if ($item->status == 2)
                                        <a href="  {{ url('/timesheet/reject/' . $item->id) }}"
                                            onclick="return confirm('Are you sure you want to Reject this timesheet?');">
                                            <button class="btn btn-danger" data-toggle="modal"
                                                style="height: 16px; width: auto; border-radius: 7px; display: flex; align-items: center; justify-content: center;font-size: 11px;"
                                                data-target="#requestModal" disabled>Reject</button>
                                        </a>
@else
<a href="  {{ url('/timesheet/reject/' . $item->id) }}"
                                            onclick="return confirm('Are you sure you want to Reject this timesheet?');">
                                            <button class="btn btn-danger" data-toggle="modal"
                                                style="height: 16px; width: auto; border-radius: 7px; display: flex; align-items: center; justify-content: center;font-size: 11px;"
                                                data-target="#requestModal">Reject</button>
                                        </a>
                                    @endif
                                @endforeach
                            </td>
                        @endif

                </tr>
            @endforeach
        </tbody>
    </table>


    <table class="table display table-bordered table-striped table-hover basic">
        <thead>
            <tr>
                <th style="display: none;">id</th>
                <th>Employee Name</th>
                <th>Date</th>
                <th>Day</th>
                <th>Client Name</th>
                <th>Assignment Name</th>
                <th>Work Item</th>
                <th>Location</th>
                <th>Partner</th>
                <th>Hour</th>
                <th>Status</th>
                {{-- @if (Auth::user()->role_id == 11 || Auth::user()->teammember_id != $timesheetData[0]->createdby)
                    <th>Action</th>
                @endif --}}
            </tr>
        </thead>
        <tbody>
            {{-- @php
                dd($timesheetData);
            @endphp --}}
            @foreach ($timesheetData as $timesheetDatas)
                <tr>
                    <td style="display: none;">{{ $timesheetDatas->id }}</td>
                    <td> {{ $timesheetDatas->team_member ?? '' }} </td>

                    {{-- <td>{{ date('d-m-Y', strtotime($timesheetDatas->date)) }}
                    </td> --}}
                    <td> <span style="display: none;">
                            {{ date('Y-m-d', strtotime($timesheetDatas->date)) }}</span>{{ date('d-m-Y', strtotime($timesheetDatas->date)) }}
                    </td>
                    <td>
                        @if ($timesheetDatas->date != null)
                            {{ date('l', strtotime($timesheetDatas->date)) }}
                        @endif
                    </td>
                    <td>{{ $timesheetDatas->client_name ?? '' }} </td>
                    <td>
                        {{ $timesheetDatas->assignment_name ?? '' }}
                        @if ($timesheetDatas->assignmentname != null)
                            ({{ $timesheetDatas->assignmentname ?? '' }})
                        @endif
                    </td>
                    {{-- <td> {{ $assignmentnamebyuser->assignmentname ?? '' }}</td> --}}
                    <td> {{ $timesheetDatas->workitem ?? '' }}</td>
                    <td>{{ $timesheetDatas->location ?? '' }} </td>
                    <td> {{ $timesheetDatas->patnername ?? '' }} </td>
                    <td>{{ $timesheetDatas->hour ?? '' }}</td>
                    <td>
                        @if ($timesheetDatas->status == 0)
                            <span class="badge badge-pill badge-warning">Saved</span>
@elseif ($timesheetDatas->status == 1 || $timesheetDatas->status == 3)
<span class="badge badge-pill badge-danger">Submit</span>
@else
<span class="badge badge-pill badge-secondary">Rejected</span>
                        @endif
                    </td>
                    {{-- @if (Auth::user()->role_id == 11 || Auth::user()->teammember_id != $client_id[0]->createdby)
                        <td>
                            @foreach ($client_id as $item)
                                @if ($item->status == 2)
                                    <a href="  {{ url('/timesheet/reject/' . $item->id) }}"
                                        onclick="return confirm('Are you sure you want to Reject this timesheet?');">
                                        <button class="btn btn-danger" data-toggle="modal"
                                            style="height: 16px; width: auto; border-radius: 7px; display: flex; align-items: center; justify-content: center;font-size: 11px;"
                                            data-target="#requestModal" disabled>Reject</button>
                                    </a>
                                @else
                                    <a href="  {{ url('/timesheet/reject/' . $item->id) }}"
                                        onclick="return confirm('Are you sure you want to Reject this timesheet?');">
                                        <button class="btn btn-danger" data-toggle="modal"
                                            style="height: 16px; width: auto; border-radius: 7px; display: flex; align-items: center; justify-content: center;font-size: 11px;"
                                            data-target="#requestModal">Reject</button>
                                    </a>
                                @endif
                            @endforeach
                        </td>
                    @endif --}}
                </tr>
            @endforeach
        </tbody>
    </table>





    @php
        $userId = auth()->user()->teammember_id;
        $checkread = DB::table('notificationreadorunread')
            ->where('notifications_id', $notificationData->id)
            ->where('readedby', $userId)
            ->first();

    @endphp

    <a href="{{ url('notification/' . $notificationData->id) }}"
        style="color: {{ isset($checkread) && $checkread->status == 1 ? 'black' : 'red' }}">
        <h6>{{ $notificationData->title }}</h6>
    </a>
    <a href="{{ url('notification/' . $notificationData->id) }}">
        <h6>{{ $notificationData->title }}</h6>
        {{-- style="color: {{ $notificationData->readstatus == 1 ? 'Black' : 'red' }}" --}}
    </a>
    {{--  Start Hare --}}
    // Fetching the current team hour
    $gettotalteamhour = DB::table('assignmentmappings')
    ->leftJoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
    ->where('assignmentmappings.assignmentgenerate_id', $request->assignment_id[$i])
    ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
    ->value('teamhour');

    // Calculating the new total team hour
    $finalresult = $gettotalteamhour + $request->hour[$i];

    // Updating the team hour
    $totalteamhourupdate = DB::table('assignmentmappings')
    ->leftJoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
    ->where('assignmentmappings.assignmentgenerate_id', $request->assignment_id[$i])
    ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
    ->update(['teamhour' => $finalresult]);

    dd($gettotalteamhour);
    {{--  Start Hare --}}
    {{-- *   --}}
    @foreach ($teammemberDatas as $teammemberData)
        <tr>
            {{-- @php
            $totalhour = DB::table('timesheetusers')
                ->leftJoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
                ->where(
                    'timesheetusers.assignmentgenerate_id',
                    $teammemberData->assignmentgenerate_id,
                )
                ->where('timesheetusers.createdby', $teammemberData->teamid)
                ->select(DB::raw('SUM(totalhour) as total_hours'))
                ->first();

            $update = DB::table('assignmentmappings')
                ->leftJoin(
                    'assignmentteammappings',
                    'assignmentteammappings.assignmentmapping_id',
                    'assignmentmappings.id',
                )
                ->where('assignmentteammappings.teammember_id', $teammemberData->teamid)
                ->update(['teamhour' => $totalhour->total_hours ?? 0]);
        @endphp --}}

            {{-- @php
            $totalHour = DB::table('timesheetusers')
                ->leftJoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
                ->where(
                    'timesheetusers.assignmentgenerate_id',
                    $teammemberData->assignmentgenerate_id,
                )
                ->where('timesheetusers.createdby', $teammemberData->teamid)
                ->select(DB::raw('SUM(totalhour) as total_hours'))
                ->first();

            $update = DB::table('assignmentmappings')
                ->leftJoin(
                    'assignmentteammappings',
                    'assignmentteammappings.assignmentmapping_id',
                    'assignmentmappings.id',
                )
                ->where(
                    'assignmentmappings.assignmentgenerate_id',
                    $teammemberData->assignmentgenerate_id,
                )
                ->where('assignmentteammappings.teammember_id', $teammemberData->teamid)
                // ->get();
                ->update(['teamhour' => $totalHour->total_hours]);
            // dd($update);
        @endphp --}}


            <td>{{ $teammemberData->title }} {{ $teammemberData->team_member }}</td>
            <td>{{ $teammemberData->assignmentgenerate_id }}</td>
            <td>{{ $teammemberData->assignmentname }}</td>
            <td>{{ $teammemberData->teamhour ?? 0 }}</td>
            {{-- <td>{{ $totalhour->total_hours ?? 0 }}</td> --}}
        </tr>
    @endforeach
    {{--  Start Hare --}}
    {{-- *   --}}
    <nav aria-label="breadcrumb" class="col-sm-5 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            @php
                // Get current Date
                $currentdate = date('Y-m-d');
                if ($getauth == null) {
                    $getdate = date('Y-m-d');
                } else {
                    $getdate = $getauth->date;
                }

                $to = Carbon\Carbon::createFromFormat('Y-m-d', $getdate ?? '');
                $from = Carbon\Carbon::createFromFormat('Y-m-d', $currentdate);
                // Diffrence between latest save timesheet and todays date in count / timesheet gap date count
                $diff_in_days = $to->diffInDays($from);
                $getmondaydate = DB::table('timesheetday')->first();

                $timesheetcount = DB::table('timesheets')
                    ->where('status', '0')
                    ->where('created_by', auth()->user()->teammember_id)
                    ->where('date', '<', $getmondaydate->date)
                    ->count();
                //! no uses
                $too = Carbon\Carbon::createFromFormat('Y-m-d', $getmondaydate->date ?? '');
                $froms = Carbon\Carbon::createFromFormat('Y-m-d', $currentdate);
                $diff_in_daysformonday = $too->diffInDays($froms);
                //! no uses
            @endphp
            @if ($diff_in_days > 14)
                @if ($timesheetrequest == null)
                    <li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal21">Add Timesheet
                            Request</a> </li>
@else
@if ($currentdate < $timesheetrequest->validate)
                        <li class="breadcrumb-item"><a class="btn btn-primary-soft btn-sm"
                                href="{{ url('timesheet/create') }}">Add Timesheet</a>
                        </li>
                        @if (now()->isSunday() ||
                                now()->isMonday() ||
                                now()->isTuesday() ||
                                now()->isWednesday() ||
                                now()->isThursday() ||
                                now()->isFriday() ||
                                now()->isSaturday())
                            @if ($timesheetcount >= 6)
                                <li class="breadcrumb-item"><a class="btn btn-primary-soft btn-sm"
                                        onclick="return confirm('Are you sure you want to submit this timesheet for last week?');"
                                        href="{{ url('timesheetsubmission') }}">Submit Timesheet for Week</a>
                                </li>
                            @endif
                        @endif
@elseif ($currentdate > $timesheetrequest->validate && $timesheetrequest->validate != null)
<li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal21">Add Timesheet
                                Request</a> </li>
@else
@if ($timesheetrequest->status == 0)
                            <li class="breadcrumb-item"><a>Requested Done</a>
                            </li>
@else
<li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal21">Add
                                    Timesheet Request</a> </li>
                        @endif
                    @endif
                @endif
@elseif(15 < 16)
<li class="breadcrumb-item"><a class="btn btn-info-soft btn-sm"
                        href="{{ url('timesheet/create') }}">Add
                        Timesheet @if ($timesheetcount < 7)
                            for last week
                        @endif
                    </a>
                </li>

                @if (now()->isSunday() ||
                        now()->isMonday() ||
                        now()->isTuesday() ||
                        now()->isWednesday() ||
                        now()->isThursday() ||
                        now()->isFriday() ||
                        now()->isSaturday())
                    @if ($timesheetcount >= 6)
                        <li class="breadcrumb-item"><a class="btn btn-primary-soft btn-sm"
                                onclick="return confirm('Are you sure you want to submit this timesheet for last week?');"
                                href="{{ url('timesheetsubmission') }}">Submit Timesheet for Week</a>
                        </li>
                    @endif
                @endif

                {{-- @if ($timesheetcount >= 7)
                    @if (now()->isSunday() || now()->isMonday() || now()->isTuesday() || now()->isWednesday() || now()->isThursday() || now()->isFriday() || now()->isSaturday())
                        <li class="breadcrumb-item"><a class="btn btn-primary-soft btn-sm"
                                onclick="return confirm('Are you sure you want to submit this timesheet for last week?');"
                                href="{{ url('timesheetsubmission') }}">Submit Timesheet for Week</a>
                        </li>
                    @endif
                @else
                    @if ((now()->isSunday() && now()->hour >= 18) || now()->isMonday() || now()->isTuesday() || now()->isWednesday() || now()->isThursday() || now()->isFriday() || (now()->isSaturday() && now()->hour <= 18))
                        <li class="breadcrumb-item"><a class="btn btn-primary-soft btn-sm"
                                onclick="return confirm('Are you sure you want to submit this timesheet for last week?');"
                                href="{{ url('timesheetsubmission') }}">Submit Timesheet for Week</a>
                        </li>
                    @endif
                @endif --}}
            @endif
        </ol>
    </nav>
    {{--  Start Hare --}}
    {{-- *   --}}
    {{-- @if ($timesheetcount >= 7)
                        @if (now()->isSunday() || now()->isMonday() || now()->isTuesday() || now()->isWednesday() || now()->isThursday() || now()->isFriday() || now()->isSaturday())
                            <li class="breadcrumb-item"><a class="btn btn-primary-soft btn-sm"
                                    onclick="return confirm('Are you sure you want to submit this timesheet for last week?');"
                                    href="{{ url('timesheetsubmission') }}">Submit Timesheet for Week</a>
                            </li>
                        @endif
                    @else
                        @if ((now()->isSunday() && now()->hour >= 18) || now()->isMonday() || now()->isTuesday() || now()->isWednesday() || now()->isThursday() || now()->isFriday() || (now()->isSaturday() && now()->hour <= 18))
                            <li class="breadcrumb-item"><a class="btn btn-primary-soft btn-sm"
                                    onclick="return confirm('Are you sure you want to submit this timesheet for last week?');"
                                    href="{{ url('timesheetsubmission') }}">Submit Timesheet for Week</a>
                            </li>
                        @endif
                    @endif --}}
    {{--  Start Hare --}}
    {{-- *   --}}
    {{-- ! old code Start Hare --}}
    <nav aria-label="breadcrumb" class="col-sm-5 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            @php
                // Get current Date
                $currentdate = date('Y-m-d');
                if ($getauth == null) {
                    $getdate = date('Y-m-d');
                } else {
                    $getdate = $getauth->date;
                }

                $to = Carbon\Carbon::createFromFormat('Y-m-d', $getdate ?? '');
                $from = Carbon\Carbon::createFromFormat('Y-m-d', $currentdate);
                // Diffrence between latest save timesheet and todays date in count / timesheet gap date count
                $diff_in_days = $to->diffInDays($from);
                $getmondaydate = DB::table('timesheetday')->first();

                $timesheetcount = DB::table('timesheets')
                    ->where('status', '0')
                    ->where('created_by', auth()->user()->teammember_id)
                    ->where('date', '<', $getmondaydate->date)
                    ->count();
                //! no uses
                $too = Carbon\Carbon::createFromFormat('Y-m-d', $getmondaydate->date ?? '');
                $froms = Carbon\Carbon::createFromFormat('Y-m-d', $currentdate);
                $diff_in_daysformonday = $too->diffInDays($froms);
                //! no uses
            @endphp
            @if ($diff_in_days > 14)
                @if ($timesheetrequest == null)
                    <li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal21">Add Timesheet
                            Request</a> </li>
@else
@if ($currentdate < $timesheetrequest->validate)
                        <li class="breadcrumb-item"><a class="btn btn-primary-soft btn-sm"
                                href="{{ url('timesheet/create') }}">Add Timesheet</a>
                        </li>
                        @if (now()->isSunday() ||
                                now()->isMonday() ||
                                now()->isTuesday() ||
                                now()->isWednesday() ||
                                now()->isThursday() ||
                                now()->isFriday() ||
                                now()->isSaturday())
                            @if ($timesheetcount >= 6)
                                <li class="breadcrumb-item"><a class="btn btn-primary-soft btn-sm"
                                        onclick="return confirm('Are you sure you want to submit this timesheet for last week?');"
                                        href="{{ url('timesheetsubmission') }}">Submit Timesheet for Week</a>
                                </li>
                            @endif
                        @endif
@elseif ($currentdate > $timesheetrequest->validate && $timesheetrequest->validate != null)
<li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal21">Add
                                Timesheet
                                Request</a> </li>
@else
@if ($timesheetrequest->status == 0)
                            <li class="breadcrumb-item"><a>Requested Done</a>
                            </li>
@else
<li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal21">Add
                                    Timesheet Request</a> </li>
                        @endif
                    @endif
                @endif
@elseif(15 < 16)
<li class="breadcrumb-item"><a class="btn btn-info-soft btn-sm"
                        href="{{ url('timesheet/create') }}">Add
                        Timesheet @if ($timesheetcount < 7)
                            for last week
                        @endif
                    </a>
                </li>

                @if (now()->isSunday() ||
                        now()->isMonday() ||
                        now()->isTuesday() ||
                        now()->isWednesday() ||
                        now()->isThursday() ||
                        now()->isFriday() ||
                        now()->isSaturday())
                    @if ($timesheetcount >= 6)
                        <li class="breadcrumb-item"><a class="btn btn-primary-soft btn-sm"
                                onclick="return confirm('Are you sure you want to submit this timesheet for last week?');"
                                href="{{ url('timesheetsubmission') }}">Submit Timesheet for Week</a>
                        </li>
                    @endif
                @endif

                {{-- @if ($timesheetcount >= 7)
                    @if (now()->isSunday() || now()->isMonday() || now()->isTuesday() || now()->isWednesday() || now()->isThursday() || now()->isFriday() || now()->isSaturday())
                        <li class="breadcrumb-item"><a class="btn btn-primary-soft btn-sm"
                                onclick="return confirm('Are you sure you want to submit this timesheet for last week?');"
                                href="{{ url('timesheetsubmission') }}">Submit Timesheet for Week</a>
                        </li>
                    @endif
                @else
                    @if ((now()->isSunday() && now()->hour >= 18) || now()->isMonday() || now()->isTuesday() || now()->isWednesday() || now()->isThursday() || now()->isFriday() || (now()->isSaturday() && now()->hour <= 18))
                        <li class="breadcrumb-item"><a class="btn btn-primary-soft btn-sm"
                                onclick="return confirm('Are you sure you want to submit this timesheet for last week?');"
                                href="{{ url('timesheetsubmission') }}">Submit Timesheet for Week</a>
                        </li>
                    @endif
                @endif --}}
            @endif
        </ol>
    </nav>
    {{--  Start Hare --}}
    @if (now()->isSunday() ||
            now()->isMonday() ||
            now()->isTuesday() ||
            now()->isWednesday() ||
            now()->isThursday() ||
            now()->isFriday() ||
            now()->isSaturday())
        {{-- @if ($timesheetcount >= 6) --}}
        @if ($timesheetcountss >= 6)
            <li class="breadcrumb-item"><a class="btn btn-primary-soft btn-sm"
                    onclick="return confirm('Are you sure you want to submit this timesheet for last week?');"
                    href="{{ url('timesheetsubmission') }}">Submit Timesheet for Week</a>
            </li>
        @endif
        {{-- @endif --}}
    @endif
    {{-- *   --}}
    {{-- !  Start Hare --}}
    <nav aria-label="breadcrumb" class="col-sm-5 order-sm-last mb-3 mb-sm-0 p-0">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            @php
                $currentDate = date('Y-m-d');
                $getDate = $getauth == null ? date('Y-m-d') : $getauth->date;

                $to = Carbon\Carbon::createFromFormat('Y-m-d', $getDate ?? '');
                $from = Carbon\Carbon::createFromFormat('Y-m-d', $currentDate);
                $diffInDays = $to->diffInDays($from);

                $getMondayDate = DB::table('timesheetday')->first();

                $timesheetCount = DB::table('timesheets')
                    ->where('status', '0')
                    ->where('created_by', auth()->user()->teammember_id)
                    ->where('date', '<', $getMondayDate->date)
                    ->count();

                $too = Carbon\Carbon::createFromFormat('Y-m-d', $getMondayDate->date ?? '');
                $froms = Carbon\Carbon::createFromFormat('Y-m-d', $currentDate);
                $diffInDaysForMonday = $too->diffInDays($froms);
            @endphp

            @if ($diffInDays > 14)
                @if ($timesheetRequest == null)
                    <li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal21">Add Timesheet
                            Request</a></li>
@else
@if ($currentDate < $timesheetRequest->validate)
                        <li class="breadcrumb-item"><a class="btn btn-primary-soft btn-sm"
                                href="{{ url('timesheet/create') }}">Add Timesheet</a></li>
                        @if ($timesheetCount >= 6)
                            <li class="breadcrumb-item"><a class="btn btn-primary-soft btn-sm"
                                    onclick="return confirm('Are you sure you want to submit this timesheet for last week?');"
                                    href="{{ url('timesheetsubmission') }}">Submit Timesheet for Week</a></li>
                        @endif
@elseif ($currentDate > $timesheetRequest->validate && $timesheetRequest->validate != null)
<li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal21">Add
                                Timesheet
                                Request</a></li>
@else
@if ($timesheetRequest->status == 0)
                            <li class="breadcrumb-item"><a>Requested Done</a></li>
@else
<li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal21">Add
                                    Timesheet
                                    Request</a></li>
                        @endif
                    @endif
                @endif
@elseif ($diffInDays > 15 && $diffInDays < 16)
<li class="breadcrumb-item"><a class="btn btn-info-soft btn-sm"
                        href="{{ url('timesheet/create') }}">Add
                        Timesheet @if ($timesheetCount < 7)
                            for last weekqqq
                        @endif
                    </a>
                </li>
                @if ($timesheetCount >= 6)
                    <li class="breadcrumb-item"><a class="btn btn-primary-soft btn-sm"
                            onclick="return confirm('Are you sure you want to submit this timesheet for last week?');"
                            href="{{ url('timesheetsubmission') }}">Submit Timesheet for Week</a></li>
                @endif
            @endif
        </ol>
    </nav>
    {{-- *   --}}
    <nav aria-label="breadcrumb" class="col-sm-5 order-sm-last mb-3 mb-sm-0 p-0 ">
        {{-- <form method="post" class="row" action="{{ url('timesheet/search') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group col-md-4">
                <label for="year">Year:</label>
                <select class="form-control" id="year" name="year">
                    @foreach ($dropdownYears as $dropdownYear)
                        <option value="{{ $dropdownYear }}" {{ $year == $dropdownYear ? 'selected' : '' }}>
                            {{ $dropdownYear }}
                        </option>
                    @endforeach
                </select>

            </div>
            <div class="form-group col-md-4">
                <label for="month">Month:</label>
                <select class="form-control" id="month" name="month">
                    @foreach ($dropdownMonths as $dropdownMonth)
                        <option value="{{ $dropdownMonth }}" {{ $month == $dropdownMonth ? 'selected' : '' }}>
                            {{ $dropdownMonth }}
                        </option>
                    @endforeach
                </select>
                
                
            </div>
            <div class="form-group col-md-4" style="margin: auto;">
                <button type="submit" class="btn btn-primary form-controll">Submit</button>
            </div>
        </form> --}}

        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            @php
                //  dd($getauth->date);
                $currentdate = date('Y-m-d');
                if ($getauth == null) {
                    $getdate = date('Y-m-d');
                } else {
                    $getdate = $getauth->date;
                }

                $to = Carbon\Carbon::createFromFormat('Y-m-d', $getdate ?? '');

                $from = Carbon\Carbon::createFromFormat('Y-m-d', $currentdate);
                $diff_in_days = $to->diffInDays($from);
                //dd($diff_in_days);

                $getmondaydate = DB::table('timesheetday')->first();

                //   $usertimesheetfirstdate =  DB::table('timesheets')
                //                                ->where('status','0')
                //                                ->where('created_by',auth()->user()->teammember_id)->orderBy('date', 'ASC')->first();
                //                         // dd($usertimesheetfirstdate->date);
                //                            $lastdate = Carbon\Carbon::createFromFormat('Y-m-d',$usertimesheetfirstdate->date ??'')->addDays(6);
                //dd(date('Y-m-d', strtotime($lastdate)));

                // $timesheetcount = DB::table('timesheets')
                //     ->where('status', '0')

                //     ->where('created_by', auth()->user()->teammember_id)
                //     ->where('date', '<', $getmondaydate->date)
                //     ->count();

                $timesheetcountss = DB::table('timesheets')
                    ->where('status', '0')
                    ->where('created_by', auth()->user()->teammember_id)
                    ->count();

                // dd($timesheetcountss);
                //from monday check count

                //    dd($getmondaydate); die;
                $too = Carbon\Carbon::createFromFormat('Y-m-d', $getmondaydate->date ?? '');

                $froms = Carbon\Carbon::createFromFormat('Y-m-d', $currentdate);
                $diff_in_daysformonday = $too->diffInDays($froms);

                //dd($diff_in_daysformonday);

            @endphp
            @if ($diff_in_days > 14)
                @php
                    dd('hi1');
                @endphp
                @if ($timesheetrequest == null)
                    <li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal21">Add Timesheet
                            Request</a> </li>
@else
@if ($currentdate < $timesheetrequest->validate)
                        <li class="breadcrumb-item"><a class="btn btn-primary-soft btn-sm"
                                href="{{ url('timesheet/create') }}">Add Timesheet</a>
                        </li>
                        @if (
                            (now()->isSunday() && now()->hour >= 18) ||
                                now()->isMonday() ||
                                now()->isTuesday() ||
                                now()->isWednesday() ||
                                now()->isThursday() ||
                                now()->isFriday() ||
                                (now()->isSaturday() && now()->hour <= 18))
                            @if ($timesheetcount >= 6)
                                <li class="breadcrumb-item"><a class="btn btn-primary-soft btn-sm"
                                        onclick="return confirm('Are you sure you want to submit this timesheet for last week?');"
                                        href="{{ url('timesheetsubmission') }}">Submit Timesheet for Week</a>
                                </li>
                            @endif
                        @endif
@elseif ($currentdate > $timesheetrequest->validate && $timesheetrequest->validate != null)
<li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal21">Add
                                Timesheet
                                Request</a> </li>
@else
@if ($timesheetrequest->status == 0)
                            <li class="breadcrumb-item"><a>Requested Done</a>
                            </li>
@else
<li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal21">Add
                                    Timesheet Request</a> </li>
                        @endif
                    @endif
                @endif
@elseif(15 < 16)
<li class="breadcrumb-item"><a class="btn btn-info-soft btn-sm"
                        href="{{ url('timesheet/create') }}">Add
                        Timesheet @if ($timesheetcount < 7)
                            for last weekqqq
                        @endif
                    </a>
                </li>

                @if (now()->isSunday() ||
                        now()->isMonday() ||
                        now()->isTuesday() ||
                        now()->isWednesday() ||
                        now()->isThursday() ||
                        now()->isFriday() ||
                        now()->isSaturday())
                    {{-- @if ($timesheetcount >= 6) --}}
                    @if ($timesheetcountss >= 6)
                        <li class="breadcrumb-item"><a class="btn btn-primary-soft btn-sm"
                                onclick="return confirm('Are you sure you want to submit this timesheet for last week?');"
                                href="{{ url('timesheetsubmission') }}">Submit Timesheet for Week</a>
                        </li>
                    @endif
                    {{-- @endif --}}
                @endif
            @endif
        </ol>
    </nav>
    {{-- *   --}}
    {{-- ! old code   Start Hare --}}
    <nav aria-label="breadcrumb" class="col-sm-5 order-sm-last mb-3 mb-sm-0 p-0 ">
        {{-- <form method="post" class="row" action="{{ url('timesheet/search') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group col-md-4">
                <label for="year">Year:</label>
                <select class="form-control" id="year" name="year">
                    @foreach ($dropdownYears as $dropdownYear)
                        <option value="{{ $dropdownYear }}" {{ $year == $dropdownYear ? 'selected' : '' }}>
                            {{ $dropdownYear }}
                        </option>
                    @endforeach
                </select>

            </div>
            <div class="form-group col-md-4">
                <label for="month">Month:</label>
                <select class="form-control" id="month" name="month">
                    @foreach ($dropdownMonths as $dropdownMonth)
                        <option value="{{ $dropdownMonth }}" {{ $month == $dropdownMonth ? 'selected' : '' }}>
                            {{ $dropdownMonth }}
                        </option>
                    @endforeach
                </select>
                
                
            </div>
            <div class="form-group col-md-4" style="margin: auto;">
                <button type="submit" class="btn btn-primary form-controll">Submit</button>
            </div>
        </form> --}}

        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            @php
                //  dd($getauth->date);
                $currentdate = date('Y-m-d');
                if ($getauth == null) {
                    $getdate = date('Y-m-d');
                } else {
                    $getdate = $getauth->date;
                }

                $to = Carbon\Carbon::createFromFormat('Y-m-d', $getdate ?? '');

                $from = Carbon\Carbon::createFromFormat('Y-m-d', $currentdate);
                $diff_in_days = $to->diffInDays($from);
                //dd($diff_in_days);

                $getmondaydate = DB::table('timesheetday')->first();

                //   $usertimesheetfirstdate =  DB::table('timesheets')
                //                                ->where('status','0')
                //                                ->where('created_by',auth()->user()->teammember_id)->orderBy('date', 'ASC')->first();
                //                         // dd($usertimesheetfirstdate->date);
                //                            $lastdate = Carbon\Carbon::createFromFormat('Y-m-d',$usertimesheetfirstdate->date ??'')->addDays(6);
                //dd(date('Y-m-d', strtotime($lastdate)));

                $timesheetcount = DB::table('timesheets')
                    ->where('status', '0')

                    ->where('created_by', auth()->user()->teammember_id)
                    ->where('date', '<', $getmondaydate->date)
                    ->count();

                //  dd($timesheetcount);
                //from monday check count

                //    dd($getmondaydate); die;
                $too = Carbon\Carbon::createFromFormat('Y-m-d', $getmondaydate->date ?? '');

                $froms = Carbon\Carbon::createFromFormat('Y-m-d', $currentdate);
                $diff_in_daysformonday = $too->diffInDays($froms);

                //dd($diff_in_daysformonday);

            @endphp
            @if ($diff_in_days > 14)
                @if ($timesheetrequest == null)
                    <li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal21">Add Timesheet
                            Request</a> </li>
@else
@if ($currentdate < $timesheetrequest->validate)
                        <li class="breadcrumb-item"><a class="btn btn-primary-soft btn-sm"
                                href="{{ url('timesheet/create') }}">Add Timesheet</a>
                        </li>
                        @if (
                            (now()->isSunday() && now()->hour >= 18) ||
                                now()->isMonday() ||
                                now()->isTuesday() ||
                                now()->isWednesday() ||
                                now()->isThursday() ||
                                now()->isFriday() ||
                                (now()->isSaturday() && now()->hour <= 18))
                            @if ($timesheetcount >= 6)
                                <li class="breadcrumb-item"><a class="btn btn-primary-soft btn-sm"
                                        onclick="return confirm('Are you sure you want to submit this timesheet for last week?');"
                                        href="{{ url('timesheetsubmission') }}">Submit Timesheet for Week</a>
                                </li>
                            @endif
                        @endif
@elseif ($currentdate > $timesheetrequest->validate && $timesheetrequest->validate != null)
<li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal21">Add
                                Timesheet
                                Request</a> </li>
@else
@if ($timesheetrequest->status == 0)
                            <li class="breadcrumb-item"><a>Requested Done</a>
                            </li>
@else
<li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal21">Add
                                    Timesheet Request</a> </li>
                        @endif
                    @endif
                @endif
@elseif(15 < 16)
<li class="breadcrumb-item"><a class="btn btn-info-soft btn-sm"
                        href="{{ url('timesheet/create') }}">Add
                        Timesheet @if ($timesheetcount < 7)
                            for last weekqqq
                        @endif
                    </a>
                </li>

                @if (
                    (now()->isSunday() && now()->hour >= 18) ||
                        now()->isMonday() ||
                        now()->isTuesday() ||
                        now()->isWednesday() ||
                        now()->isThursday() ||
                        now()->isFriday() ||
                        (now()->isSaturday() && now()->hour <= 18))
                    @if ($timesheetcount >= 6)
                        <li class="breadcrumb-item"><a class="btn btn-primary-soft btn-sm"
                                onclick="return confirm('Are you sure you want to submit this timesheet for last week?');"
                                href="{{ url('timesheetsubmission') }}">Submit Timesheet for Week</a>
                        </li>
                    @endif
                @endif
            @endif
        </ol>
    </nav>
    {{-- *   --}}
    <nav aria-label="breadcrumb" class="col-sm-5 order-sm-last mb-3 mb-sm-0 p-0 ">
        {{-- <form method="post" class="row" action="{{ url('timesheet/search') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group col-md-4">
                <label for="year">Year:</label>
                <select class="form-control" id="year" name="year">
                    @foreach ($dropdownYears as $dropdownYear)
                        <option value="{{ $dropdownYear }}" {{ $year == $dropdownYear ? 'selected' : '' }}>
                            {{ $dropdownYear }}
                        </option>
                    @endforeach
                </select>

            </div>
            <div class="form-group col-md-4">
                <label for="month">Month:</label>
                <select class="form-control" id="month" name="month">
                    @foreach ($dropdownMonths as $dropdownMonth)
                        <option value="{{ $dropdownMonth }}" {{ $month == $dropdownMonth ? 'selected' : '' }}>
                            {{ $dropdownMonth }}
                        </option>
                    @endforeach
                </select>
                
                
            </div>
            <div class="form-group col-md-4" style="margin: auto;">
                <button type="submit" class="btn btn-primary form-controll">Submit</button>
            </div>
        </form> --}}

        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            @php
                //  dd($getauth->date);
                $currentdate = date('Y-m-d');
                if ($getauth == null) {
                    $getdate = date('Y-m-d');
                } else {
                    $getdate = $getauth->date;
                }

                $to = Carbon\Carbon::createFromFormat('Y-m-d', $getdate ?? '');

                $from = Carbon\Carbon::createFromFormat('Y-m-d', $currentdate);
                $diff_in_days = $to->diffInDays($from);
                //dd($diff_in_days);

                $getmondaydate = DB::table('timesheetday')->first();

                //   $usertimesheetfirstdate =  DB::table('timesheets')
                //                                ->where('status','0')
                //                                ->where('created_by',auth()->user()->teammember_id)->orderBy('date', 'ASC')->first();
                //                         // dd($usertimesheetfirstdate->date);
                //                            $lastdate = Carbon\Carbon::createFromFormat('Y-m-d',$usertimesheetfirstdate->date ??'')->addDays(6);
                //dd(date('Y-m-d', strtotime($lastdate)));

                $timesheetcount = DB::table('timesheets')
                    ->where('status', '0')

                    ->where('created_by', auth()->user()->teammember_id)
                    ->where('date', '<', $getmondaydate->date)
                    ->count();

                //  dd($timesheetcount);
                //from monday check count

                //    dd($getmondaydate); die;
                $too = Carbon\Carbon::createFromFormat('Y-m-d', $getmondaydate->date ?? '');

                $froms = Carbon\Carbon::createFromFormat('Y-m-d', $currentdate);
                $diff_in_daysformonday = $too->diffInDays($froms);

                //dd($diff_in_daysformonday);

            @endphp
            @if ($diff_in_days > 14)
                @if ($timesheetrequest == null)
                    <li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal21">Add Timesheet
                            Request</a> </li>
@else
@if ($currentdate < $timesheetrequest->validate)
                        <li class="breadcrumb-item"><a class="btn btn-primary-soft btn-sm"
                                href="{{ url('timesheet/create') }}">Add Timesheet</a>
                        </li>
                        @if (
                            (now()->isSunday() && now()->hour >= 18) ||
                                now()->isMonday() ||
                                now()->isTuesday() ||
                                now()->isWednesday() ||
                                now()->isThursday() ||
                                now()->isFriday() ||
                                (now()->isSaturday() && now()->hour <= 18))
                            @if ($timesheetcount >= 6)
                                <li class="breadcrumb-item"><a class="btn btn-primary-soft btn-sm"
                                        onclick="return confirm('Are you sure you want to submit this timesheet for last week?');"
                                        href="{{ url('timesheetsubmission') }}">Submit Timesheet for Week</a>
                                </li>
                            @endif
                        @endif
@elseif ($currentdate > $timesheetrequest->validate && $timesheetrequest->validate != null)
<li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal21">Add
                                Timesheet
                                Request</a> </li>
@else
@if ($timesheetrequest->status == 0)
                            <li class="breadcrumb-item"><a>Requested Done</a>
                            </li>
@else
<li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal21">Add
                                    Timesheet Request</a> </li>
                        @endif
                    @endif
                @endif
@elseif(15 < 16)
<li class="breadcrumb-item"><a class="btn btn-info-soft btn-sm"
                        href="{{ url('timesheet/create') }}">Add
                        Timesheet @if ($timesheetcount < 7)
                            for last week
                        @endif
                    </a>
                </li>

                @if (
                    (now()->isSunday() && now()->hour >= 18) ||
                        now()->isMonday() ||
                        now()->isTuesday() ||
                        now()->isWednesday() ||
                        now()->isThursday() ||
                        now()->isFriday() ||
                        (now()->isSaturday() && now()->hour <= 18))
                    @if ($timesheetcount >= 6)
                        <li class="breadcrumb-item"><a class="btn btn-primary-soft btn-sm"
                                onclick="return confirm('Are you sure you want to submit this timesheet for last week?');"
                                href="{{ url('timesheetsubmission') }}">Submit Timesheet for Week</a>
                        </li>
                    @endif
                @endif
            @endif
        </ol>
    </nav>
    {{--  Start Hare --}}
    fir se alert box ke cancel button per aa raha hai
    {{-- *   --}}

    Illuminate\Support\Collection {#2785 ▼
        #items: array:18 [▼
          0 => {#2784 ▼
            +"id": 119659
            +"timesheetid": 118628
            +"client_id": 190
            +"assignmentgenerate_id": null
            +"partner": 840
            +"totalhour": "8"
            +"assignment_id": 220
            +"project_id": null
            +"date": "2024-02-26"
            +"job_id": null
            +"workitem": "Cheked details of Salary"
            +"location": "GSTN Office"
            +"billable_status": null
            +"description": null
            +"status": 0
            +"hour": "8"
            +"createdby": 847
            +"rejectedby": null
            +"updatedby": null
            +"created_at": "2024-03-08 14:47:07"
            +"updated_at": "2024-03-08 00:00:00"
          }
          1 => {#2782 ▼
            +"id": 119660
            +"timesheetid": 118629
            +"client_id": 190
            +"assignmentgenerate_id": null
            +"partner": 840
            +"totalhour": "8"
            +"assignment_id": 220
            +"project_id": null
            +"date": "2024-02-27"
            +"job_id": null
            +"workitem": "Cheked details of salary"
            +"location": "FICSI Office"
            +"billable_status": null
            +"description": null
            +"status": 0
            +"hour": "8"
            +"createdby": 847
            +"rejectedby": null
            +"updatedby": null
            +"created_at": "2024-03-08 14:49:55"
            +"updated_at": "2024-03-08 00:00:00"
          }
          2 => {#2781 ▼
            +"id": 119682
            +"timesheetid": 118649
            +"client_id": 190
            +"assignmentgenerate_id": null
            +"partner": 840
            +"totalhour": "8"
            +"assignment_id": 220
            +"project_id": null
            +"date": "2024-02-28"
            +"job_id": null
            +"workitem": "cheked details of Statutory Dues"
            +"location": "FICSI Office"
            +"billable_status": null
            +"description": null
            +"status": 0
            +"hour": "8"
            +"createdby": 847
            +"rejectedby": null
            +"updatedby": null
            +"created_at": "2024-03-08 18:06:44"
            +"updated_at": "2024-03-08 00:00:00"
          }
          3 => {#2779 ▼
            +"id": 119683
            +"timesheetid": 118650
            +"client_id": 190
            +"assignmentgenerate_id": null
            +"partner": 840
            +"totalhour": "8"
            +"assignment_id": 220
            +"project_id": null
            +"date": "2024-02-29"
            +"job_id": null
            +"workitem": "Cheked Details of Revenue Recognition"
            +"location": "FICSI Office"
            +"billable_status": null
            +"description": null
            +"status": 0
            +"hour": "8"
            +"createdby": 847
            +"rejectedby": null
            +"updatedby": null
            +"created_at": "2024-03-08 18:07:28"
            +"updated_at": "2024-03-08 00:00:00"
          }
          4 => {#2778 ▼
            +"id": 119684
            +"timesheetid": 118651
            +"client_id": 190
            +"assignmentgenerate_id": null
            +"partner": 840
            +"totalhour": "8"
            +"assignment_id": 220
            +"project_id": null
            +"date": "2024-03-01"
            +"job_id": null
            +"workitem": "Cheked details of Revenue"
            +"location": "FICSI Office"
            +"billable_status": null
            +"description": null
            +"status": 0
            +"hour": "8"
            +"createdby": 847
            +"rejectedby": null
            +"updatedby": null
            +"created_at": "2024-03-08 18:08:04"
            +"updated_at": "2024-03-08 00:00:00"
          }
          5 => {#2777 ▼
            +"id": 119685
            +"timesheetid": 118652
            +"client_id": 190
            +"assignmentgenerate_id": null
            +"partner": 840
            +"totalhour": "8"
            +"assignment_id": 220
            +"project_id": null
            +"date": "2024-03-02"
            +"job_id": null
            +"workitem": "Cheked details of Revenue"
            +"location": "FICSI Office"
            +"billable_status": null
            +"description": null
            +"status": 0
            +"hour": "8"
            +"createdby": 847
            +"rejectedby": null
            +"updatedby": null
            +"created_at": "2024-03-08 18:08:38"
            +"updated_at": "2024-03-08 00:00:00"
          }
          6 => {#2776 ▼
            +"id": 120189
            +"timesheetid": 119146
            +"client_id": 190
            +"assignmentgenerate_id": "FOO100471"
            +"partner": 840
            +"totalhour": "8"
            +"assignment_id": 220
            +"project_id": null
            +"date": "2024-03-04"
            +"job_id": null
            +"workitem": "Cheked details of Revenue and travelling for Kolkatta"
            +"location": "Working from home"
            +"billable_status": null
            +"description": null
            +"status": 0
            +"hour": "8"
            +"createdby": 847
            +"rejectedby": null
            +"updatedby": null
            +"created_at": "2024-03-14 13:02:13"
            +"updated_at": "2024-03-14 00:00:00"
          }
          7 => {#2775 ▼
            +"id": 120190
            +"timesheetid": 119147
            +"client_id": 48
            +"assignmentgenerate_id": "RCC100269"
            +"partner": 844
            +"totalhour": "8"
            +"assignment_id": 213
            +"project_id": null
            +"date": "2024-03-05"
            +"job_id": null
            +"workitem": "Cheked details of Land"
            +"location": "RCCPL Kolkatta"
            +"billable_status": null
            +"description": null
            +"status": 0
            +"hour": "8"
            +"createdby": 847
            +"rejectedby": null
            +"updatedby": null
            +"created_at": "2024-03-14 13:02:45"
            +"updated_at": "2024-03-14 00:00:00"
          }
          8 => {#2774 ▼
            +"id": 120194
            +"timesheetid": 119149
            +"client_id": 48
            +"assignmentgenerate_id": "RCC100269"
            +"partner": 844
            +"totalhour": "8"
            +"assignment_id": 213
            +"project_id": null
            +"date": "2024-03-06"
            +"job_id": null
            +"workitem": "Cheked detilas of Land"
            +"location": "RCCPL Kolkatta"
            +"billable_status": null
            +"description": null
            +"status": 0
            +"hour": "8"
            +"createdby": 847
            +"rejectedby": null
            +"updatedby": null
            +"created_at": "2024-03-14 13:03:18"
            +"updated_at": "2024-03-14 00:00:00"
          }
          9 => {#2773 ▼
            +"id": 120198
            +"timesheetid": 119152
            +"client_id": 48
            +"assignmentgenerate_id": "RCC100269"
            +"partner": 844
            +"totalhour": "8"
            +"assignment_id": 213
            +"project_id": null
            +"date": "2024-03-07"
            +"job_id": null
            +"workitem": "Cheked Details od Land"
            +"location": "RCCPL Kolkatta"
            +"billable_status": null
            +"description": null
            +"status": 0
            +"hour": "8"
            +"createdby": 847
            +"rejectedby": null
            +"updatedby": null
            +"created_at": "2024-03-14 13:04:38"
            +"updated_at": "2024-03-14 00:00:00"
          }
          10 => {#2772 ▼
            +"id": 120202
            +"timesheetid": 119155
            +"client_id": 48
            +"assignmentgenerate_id": "RCC100269"
            +"partner": 844
            +"totalhour": "8"
            +"assignment_id": 213
            +"project_id": null
            +"date": "2024-03-08"
            +"job_id": null
            +"workitem": "Cheked Detials of land"
            +"location": "RCCPL Kolkatta"
            +"billable_status": null
            +"description": null
            +"status": 0
            +"hour": "8"
            +"createdby": 847
            +"rejectedby": null
            +"updatedby": null
            +"created_at": "2024-03-14 13:05:16"
            +"updated_at": "2024-03-14 00:00:00"
          }
          11 => {#2771 ▼
            +"id": 120203
            +"timesheetid": 119156
            +"client_id": 33
            +"assignmentgenerate_id": "OFF100004"
            +"partner": 887
            +"totalhour": "0"
            +"assignment_id": 213
            +"project_id": null
            +"date": "2024-03-09"
            +"job_id": null
            +"workitem": "NA"
            +"location": "NA"
            +"billable_status": null
            +"description": null
            +"status": 0
            +"hour": "0"
            +"createdby": 847
            +"rejectedby": null
            +"updatedby": null
            +"created_at": "2024-03-14 13:05:58"
            +"updated_at": "2024-03-14 00:00:00"
          }
          12 => {#2770 ▼
            +"id": 120525
            +"timesheetid": 119473
            +"client_id": 48
            +"assignmentgenerate_id": "RCC100269"
            +"partner": 844
            +"totalhour": "8"
            +"assignment_id": 213
            +"project_id": null
            +"date": "2024-03-11"
            +"job_id": null
            +"workitem": "Cheked details of Land"
            +"location": "RCCPL Kolkatta"
            +"billable_status": null
            +"description": null
            +"status": 0
            +"hour": "8"
            +"createdby": 847
            +"rejectedby": null
            +"updatedby": null
            +"created_at": "2024-03-19 11:00:47"
            +"updated_at": "2024-03-19 00:00:00"
          }
          13 => {#2769 ▼
            +"id": 120526
            +"timesheetid": 119474
            +"client_id": 48
            +"assignmentgenerate_id": "RCC100269"
            +"partner": 844
            +"totalhour": "8"
            +"assignment_id": 213
            +"project_id": null
            +"date": "2024-03-12"
            +"job_id": null
            +"workitem": "Cheked details of Land"
            +"location": "RCCPL Kolkatta"
            +"billable_status": null
            +"description": null
            +"status": 0
            +"hour": "8"
            +"createdby": 847
            +"rejectedby": null
            +"updatedby": null
            +"created_at": "2024-03-19 11:01:20"
            +"updated_at": "2024-03-19 00:00:00"
          }
          14 => {#2768 ▼
            +"id": 120527
            +"timesheetid": 119475
            +"client_id": 48
            +"assignmentgenerate_id": "RCC100269"
            +"partner": 844
            +"totalhour": "8"
            +"assignment_id": 213
            +"project_id": null
            +"date": "2024-03-13"
            +"job_id": null
            +"workitem": "Cheked details of Land"
            +"location": "RCCPL Kolkatta"
            +"billable_status": null
            +"description": null
            +"status": 0
            +"hour": "8"
            +"createdby": 847
            +"rejectedby": null
            +"updatedby": null
            +"created_at": "2024-03-19 11:02:04"
            +"updated_at": "2024-03-19 00:00:00"
          }
          15 => {#2767 ▼
            +"id": 120528
            +"timesheetid": 119476
            +"client_id": 48
            +"assignmentgenerate_id": "RCC100269"
            +"partner": 844
            +"totalhour": "8"
            +"assignment_id": 213
            +"project_id": null
            +"date": "2024-03-14"
            +"job_id": null
            +"workitem": "cheked details of Land"
            +"location": "RCCPL Kolkatta"
            +"billable_status": null
            +"description": null
            +"status": 0
            +"hour": "8"
            +"createdby": 847
            +"rejectedby": null
            +"updatedby": null
            +"created_at": "2024-03-19 11:02:47"
            +"updated_at": "2024-03-19 00:00:00"
          }
          16 => {#2796 ▼
            +"id": 120529
            +"timesheetid": 119477
            +"client_id": 48
            +"assignmentgenerate_id": "RCC100269"
            +"partner": 844
            +"totalhour": "8"
            +"assignment_id": 213
            +"project_id": null
            +"date": "2024-03-15"
            +"job_id": null
            +"workitem": "Cheked details of Land"
            +"location": "RCCPL Kolkatta"
            +"billable_status": null
            +"description": null
            +"status": 0
            +"hour": "8"
            +"createdby": 847
            +"rejectedby": null
            +"updatedby": null
            +"created_at": "2024-03-19 11:03:39"
            +"updated_at": "2024-03-19 00:00:00"
          }
          17 => {#2797 ▼
            +"id": 120530
            +"timesheetid": 119478
            +"client_id": 48
            +"assignmentgenerate_id": "RCC100269"
            +"partner": 844
            +"totalhour": "8"
            +"assignment_id": 213
            +"project_id": null
            +"date": "2024-03-16"
            +"job_id": null
            +"workitem": "Cheked details of Land"
            +"location": "Working from home"
            +"billable_status": null
            +"description": null
            +"status": 0
            +"hour": "8"
            +"createdby": 847
            +"rejectedby": null
            +"updatedby": null
            +"created_at": "2024-03-19 11:04:34"
            +"updated_at": "2024-03-19 00:00:00"
          }
        ]
        #escapeWhenCastingToString: false
      }

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Employee</th>
                <th>Leave Type</th>
                <th>Status</th>
                <th>Start Request Date</th>
                {{-- <th>End Request Date</th>
                <th>Start Leave Period</th>
                <th>End Leave Period</th> --}}
            </tr>
        </thead>
        <tbody>
            <tr style=" background-color: white;">
                <td>
                    <div class="form-group">
                        <select class="language form-control" id="employee1" name="employee">
                            <option value="">Please Select One</option>
                            @php
                                $displayedValues = [];
                            @endphp
                            @foreach ($teamapplyleaveDatas as $applyleaveDatas)
@if (!in_array($applyleaveDatas->emailid, $displayedValues))
<option value="{{ $applyleaveDatas->createdby }}">
                                        {{ $applyleaveDatas->team_member }}
                                        ({{ $applyleaveDatas->emailid }})
</option>
                                    @php
                                        $displayedValues[] = $applyleaveDatas->emailid;
                                    @endphp
@endif
@endforeach
                        </select>
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <select class="language form-control" id="leave1" name="leave">
                            <option value="">Please Select One</option>
                            @php
                                $displayedValues = [];
                            @endphp
                            @foreach ($teamapplyleaveDatas as $applyleaveDatas)
@if (!in_array($applyleaveDatas->name, $displayedValues))
<option value="{{ $applyleaveDatas->leavetype }}">
                                        {{ $applyleaveDatas->name }}
                                    </option>
                                    @php
                                        $displayedValues[] = $applyleaveDatas->name;
                                    @endphp
@endif
@endforeach
                        </select>
                    </div>
                </td>
                <td>
                    <div class="form-group ">
                        <select class="language form-control" id="status1" name="status">
                            <option value="">Please Select One</option>
                            @php
                                $displayedValues = [];
                            @endphp
                            @foreach ($teamapplyleaveDatas as $applyleaveDatas)
@if (!in_array($applyleaveDatas->status, $displayedValues))
<option value="{{ $applyleaveDatas->status }}">
                                        @if ($applyleaveDatas->status == 0)
Created
@elseif($applyleaveDatas->status == 1)
Approved
@else
Rejected
@endif
                                    </option>
                                    @php
                                        $displayedValues[] = $applyleaveDatas->status;
                                    @endphp
@endif
@endforeach
                        </select>
                        <button id="clickExcell" style="display: none; float:right;position: relative; top: -42px;"
                            class="btn btn-success">Download</button>
                    </div>
                </td>




                <td>
                    <div class="form-group">
                        <input type="date" class="form-control startclass" id="start1" name="start">
                    </div>
                </td>
            </tr>
        </tbody>
    </table>









    <div class="row row-sm">
        <div class="col-6">
            <div class="form-group">
                <label class="font-weight-600">Name *</label>
                <select required class="language form-control" id="key" name="teammember_id[]">

                    <option value="">Please Select One</option>
                    @foreach ($teammember as $teammemberData)
<option value="{{ $teammemberData->id }}" @if (!empty($store->financial) && $store->financial == $teammemberData->id) selected @endif>
                            {{ $teammemberData->team_member }} ( {{ $teammemberData->role->rolename }} ) (
                            {{ $teammemberData->staffcode }} )</option>
@endforeach
                </select>
            </div>
        </div>
        <div class="col-5">
            <div class="form-group">
                <label class="font-weight-600">Type *</label>
                <select required class="form-control key" id="key" name="type[]">

                    <option value="">Please Select One</option>
                    <option value="0">Team Leader</option>
                    <option value="2">Staff</option>
                </select>
            </div>
        </div>

        <div class="col-1">
            <div class="form-group" style="margin-top: 36px;">
                <a href="javascript:void(0);" class="add_buttonn" title="Add field"><img
                        src="{{ url('backEnd/image/add-icon.png') }}" /></a>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            var maxField = 60; //Input fields increment limitation
            var addButton = $('.add_buttonn'); //Add button selector
            var wrapper = $('.field_wrapper'); //Input field wrapper
            var fieldHTML =
                '<div class="row row-sm "><div class="col-6"><div class="form-group"><label class="font-weight-600">Name</label><select required class="language form-control" name="teammember_id[]" id="key"><option value="">Please Select One</option>@foreach ($teammember as $teammemberData)<option value="{{ $teammemberData->id }}" @if (!empty($store->financial) && $store->financial == $teammemberData->id) selected @endif>  {{ $teammemberData->team_member }} ( {{ $teammemberData->role->rolename }} ) ( {{ $teammemberData->staffcode }} )</option>@endforeach</select></div></div><div class="col-5"><div class="form-group"><label class="font-weight-600">Type</label><select required class="form-control key" name="type[]" id="key"><option value="">Please Select One</option><option value="0">Team Leader</option><option value="2">Staff</option></select></div></div><a style="margin-top: 36px;" href="javascript:void(0);" class="remove_button"><img src="{{ url('backEnd/image/remove-icon.png') }}" /></a></div></div>'; //New input field html 
            var x = 1; //Initial field counter is 1

            // Initialize Select2 for existing select boxes
            $('.language').select2();

            // Once add button is clicked
            $(addButton).click(function() {
                // Check maximum number of input fields
                if (x < maxField) {
                    x++; // Increment field counter
                    $(wrapper).append(fieldHTML); // Add field html
                    // Initialize Select2 for the newly added select box
                    $(wrapper).find('.language').select2();
                }
            });

            // Once remove button is clicked
            $(wrapper).on('click', '.remove_button', function(e) {
                e.preventDefault();
                $(this).parent('div').remove(); // Remove field html
                x--; // Decrement field counter
            });
        });
    </script>
    {{--  Start Hare --}}
    {{-- *   --}}


    <div style="display: flex">
        <div class="panel-header text-center" style=" margin-right: 22px;">
            <a style="color: white" class="btn btn-success" id="editCompany" data-id="{{ $debtorid }}"
                data-status="1" data-toggle="modal" data-target="#exampleModal1">
                Accept </a>
        </div>

        <div class="panel-header text-center">
            <a style="color: white" class="btn btn-danger" id="editCompany2" data-id="{{ $debtorid }}"
                data-status="0" data-toggle="modal" data-target="#exampleModal12">
                Refuse
            </a>
        </div>
    </div>

    <script>
        $(function() {
            // Function to handle click on "Accept" button
            $('body').on('click', '#editCompany', function(event) {
                if (!confirm('Are you sure?')) {
                    event.preventDefault();
                    return;
                }
                var id = $(this).data('id');
                var status = $(this).data('status');
                var acceptButton = $(this); // Reference to the clicked "Accept" button
                $.ajax({
                    type: "GET",
                    url: "{{ url('confirmationauthotp') }}",
                    data: {
                        id: id,
                        status: status
                    },
                    success: function(response) {
                        $("#otpmessage").text(response.otpsuccessmessage);
                        $("#otpmessage2").text(response.otpsuccessmessage2);
                        $("#debitid").val(response.debitid);
                        $("#assignmentgenerate_id").val(response.assignmentgenerate_id);
                        $("#type").val(response.type);
                        $("#status").val(response.status);

                        var otpMessage2 = $("#otpmessage2").text().trim();
                        if (otpMessage2) {
                            $('#detailsForm input[name="otp"]').prop('disabled', true);
                            $('#detailsForm button[type="submit"]').prop('disabled', true);
                        } else {
                            $('#detailsForm input[name="otp"]').prop('disabled', false);
                            $('#detailsForm button[type="submit"]').prop('disabled', false);
                        }
                        // Remove data-toggle attribute to prevent modal from opening again
                        acceptButton.removeAttr('data-toggle');
                        // Open the modal manually
                        $('#exampleModal1').modal('show');
                    },
                    error: function(error) {
                        console.error('Error fetching data:', error);
                    },
                });
            });

            // Function to handle click on "Refuse" button
            $('body').on('click', '#editCompany2', function(event) {
                if (!confirm('Are you sure?')) {
                    event.preventDefault();
                    return;
                }
                var id = $(this).data('id');
                var status = $(this).data('status');
                var refuseButton = $(this); // Reference to the clicked "Refuse" button
                $.ajax({
                    type: "GET",
                    url: "{{ url('confirmationauthotp') }}",
                    data: {
                        id: id,
                        status: status
                    },
                    success: function(response) {
                        $("#otpmessage1").text(response.otpsuccessmessage1);
                        $("#otpmessage3").text(response.otpsuccessmessage3);
                        $("#debitid1").val(response.debitid1);
                        $("#assignmentgenerate_id1").val(response.assignmentgenerate_id1);
                        $("#type1").val(response.type1);
                        $("#status1").val(response.status1);

                        var otpMessage2 = $("#otpmessage3").text().trim();
                        if (otpMessage2) {
                            $('#detailsForm input[name="otp1"]').prop('disabled', true);
                            $('#detailsForm input[name="otp1"]').val('');
                            $('#detailsForm button[type="submit"]').prop('disabled', true);
                        } else {
                            $('#detailsForm input[name="otp1"]').prop('disabled', false);
                            $('#detailsForm button[type="submit"]').prop('disabled', false);
                        }
                        // Remove data-toggle attribute to prevent modal from opening again
                        refuseButton.removeAttr('data-toggle');
                        // Open the modal manually
                        $('#exampleModal12').modal('show');
                    },
                    error: function(error) {
                        console.error('Error fetching data:', error);
                    },
                });
            });

            // Prevent modal from opening or hiding when clicking cancel button
            $('body').on('click', '[data-dismiss="modal"]', function(event) {
                event.stopPropagation();
            });
        });
    </script>
    {{--  Start Hare --}}

    <script>
        $(function() {
            $('body').on('click', '#editCompany', function(event) {
                if (!confirm('Are you sure?')) {
                    event.preventDefault();
                    return;
                }
                var id = $(this).data('id');
                var status = $(this).data('status');
                $.ajax({
                    type: "GET",
                    url: "{{ url('confirmationauthotp') }}",
                    // data: "id=" + id,
                    data: {
                        id: id,
                        status: status
                    },
                    success: function(response) {
                        $("#otpmessage").text(response.otpsuccessmessage);
                        $("#otpmessage2").text(response.otpsuccessmessage2);
                        $("#debitid").val(response.debitid);
                        $("#assignmentgenerate_id").val(response.assignmentgenerate_id);
                        $("#type").val(response.type);
                        $("#status").val(response.status);

                        var otpMessage2 = $("#otpmessage2").text().trim();
                        if (otpMessage2) {
                            $('#detailsForm input[name="otp"]').prop('disabled', true);
                            $('#detailsForm button[type="submit"]').prop('disabled', true);
                        } else {
                            $('#detailsForm input[name="otp"]').prop('disabled', false);
                            $('#detailsForm button[type="submit"]').prop('disabled', false);
                        }

                    },
                    error: function(error) {
                        console.error('Error fetching data:', error);
                    },
                });
                // Set data-toggle attribute to "modal" before opening modal
                $(this).attr('data-toggle', 'modal');
            });

            $('body').on('click', '#editCompany2', function(event) {
                if (!confirm('Are you sure?')) {
                    event.preventDefault();
                    return;
                }
                var id = $(this).data('id');
                var status = $(this).data('status');
                $.ajax({
                    type: "GET",
                    url: "{{ url('confirmationauthotp') }}",
                    // data: "id=" + id,
                    data: {
                        id: id,
                        status: status
                    },
                    success: function(response) {
                        console.log(response);
                        $("#otpmessage1").text(response.otpsuccessmessage1);
                        $("#otpmessage3").text(response.otpsuccessmessage3);
                        $("#debitid1").val(response.debitid1);
                        $("#assignmentgenerate_id1").val(response.assignmentgenerate_id1);
                        $("#type1").val(response.type1);
                        $("#status1").val(response.status1);

                        var otpMessage2 = $("#otpmessage3").text().trim();
                        if (otpMessage2) {
                            $('#detailsForm input[name="otp1"]').prop('disabled', true);
                            $('#detailsForm input[name="otp1"]').val('');
                            $('#detailsForm button[type="submit"]').prop('disabled', true);
                        } else {
                            $('#detailsForm input[name="otp1"]').prop('disabled', false);
                            $('#detailsForm button[type="submit"]').prop('disabled', false);
                        }
                    },
                    error: function(error) {
                        console.error('Error fetching data:', error);
                    },
                });
                // Set data-toggle attribute to "modal" before opening modal
                $(this).attr('data-toggle', 'modal');
            });

            // Prevent modal from opening or hiding when clicking cancel button
            $('body').on('click', '[data-dismiss="modal"]', function(event) {
                event.stopPropagation();
            });
        });
    </script>






    {{-- *   --}}
    [12:52 PM] sukhbahadur
    <a style="color: white" class="btn btn-success" id="editCompany" data-id="{{ $debtorid }}" data-toggle="modal"
        data-target="#exampleModal1" onclick="return confirm('Are you sure ?');">
        Accept </a>



    <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="detailsForm" method="post" action="{{ url('otpap/store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header" style="background: #37A000">
                        <h5 style="color:white;" class="modal-title font-weight-600" id="exampleModalLabel4">Enter
                            Verification OTP</h5>
                        <div>
                            <ul>
                                @foreach ($errors->all() as $e)
<li style="color:red;">{{ $e }}</li>
@endforeach
                            </ul>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="details-form-field form-group row">
                            <div class="col-sm-12">
                                <input type="text" name="otp" class="form-control" placeholder="Enter OTP">
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
        $(function() {
            $('body').on('click', '#editCompany', function(event) {
                //        debugger;
                var id = $(this).data('id');
                debugger;
                $.ajax({
                    type: "GET",

                    url: "{{ url('confirmationauthotp') }}",
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



    {{--  Start Hare --}}

    <td>
        @if (Auth::user()->teammember_id == 157)
@if ($timesheetrequestsData->status == 0)
<span class="badge badge-pill badge-warning">Created</span>
@elseif($timesheetrequestsData->status == 1 && $timesheetrequestsData->validate == null)
<span class="badge badge-pill badge-warning">Approved by partner</span>
@elseif($timesheetrequestsData->status == 1 && $timesheetrequestsData->validate != null)
<span class="badge badge-pill badge-success">Approved</span>
@elseif($timesheetrequestsData->status == 2)
<span class="badge badge-pill badge-danger">Rejected</span>
@else
<span class="badge badge-pill badge-primary">Hold</span>
@endif
@else
@if ($timesheetrequestsData->status == 0)
<span class="badge badge-pill badge-warning">Created</span>
@elseif($timesheetrequestsData->status == 1 && $timesheetrequestsData->validate == null)
<span class="badge badge-pill badge-warning">Pending for final
                    approval</span>
@elseif($timesheetrequestsData->status == 1 && $timesheetrequestsData->validate != null)
<span class="badge badge-pill badge-success">Approved</span>
@elseif($timesheetrequestsData->status == 2)
<span class="badge badge-pill badge-danger">Rejected</span>
@else
<span class="badge badge-pill badge-primary">Hold</span>
@endif
@endif

        @if (Auth::user()->teammember_id == $timesheetrequestsData->createdby)
@if ($timesheetrequestsData->status < 2 && $timesheetrequestsData->validate == null)
<a id="editCompanyyyy" data-toggle="modal" data-id="{{ $timesheetrequestsData->id }}"
                    data-target="#exampleModal112" title="Send Reminder">
                    <span class="typcn typcn-bell" style="font-size: large;color: green;"></span>
                </a>
@endif
@endif
    </td>


    <a id="editCompanyyyy" data-toggle="modal" data-id="{{ $timesheetrequestsData->id }}"
        data-target="#exampleModal112" title="Send Reminder">
        <span class="typcn typcn-bell" style="font-size: large;color: green;"></span>
    </a>


    {{-- request reminder modal --}}
    <div class="modal fade" id="exampleModal112" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header" style="background: #218838;">
                    <h5 style="color:white;" class="modal-title font-weight-600" id="exampleModalLabel4">Request
                        Reminder
                        list</h5>
                    <div>
                        <ul>
                            @foreach ($errors->all() as $e)
<li style="color:red;">{{ $e }}</li>
@endforeach
                        </ul>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="reminderTable" class="table display table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Reminder Count</th>
                                    <th>Last Reminder Date</th>
                                </tr>
                            </thead>
                            <tbody id="timesheetTableBody">

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-success sendReminderBtn"> Send Reminder</a>
                </div>

            </div>
        </div>
    </div>

    {{-- *   --}}
    {{--  Start Hare --}}
    {!! $description ?? '' !!}

    <p><br /> <br /> <br /> <span style="text-decoration: underline;"><strong>Confirmation</strong></span><br /> <br />
        We
        confirm that the in our books of account, the outstanding balance as on 30.09.2022 is
        <span style="color: #ff6600;">Rs {{ $amount ?? '' }}</span> <br />
    </p>
    <h1 style="text-align: center;"><strong><a
                href="{{ url('/debtorconfirm?' . 'clientid=' . $clientid . '&&' . 'debtorid=' . $debtorid . '&&' . 'status=' . $yes) }}"><span
                    style="color: #000000; background-color: #99cc00;">Accept&nbsp;</span> &nbsp; &nbsp; <span
                    style="background-color: #ff6600; color: #000000;">&nbsp;&nbsp;</span></a><span
                style="color: #000000; background-color: #ff6600;"><a
                    style="color: #000000; background-color: #ff6600;"
                    href="{{ url('/debtorconfirm?' . 'clientid=' . $clientid . '&&' . 'debtorid=' . $debtorid . '&&' . 'status=' . $no) }}">Refuse
                </a>&nbsp;</span></strong></h1>
    <p>&nbsp;</p>
    <br>
    <hr>
    <p style="text-align: center;">Powered By <span style="color: green">CapITall</span></p>
    <p><em>NOTICE: Information, including attachments if any, contained through this email is confidential and intended
            for
            a specific individual and purpose, and is protected by law. If you are not the intended recipient any use,
            distribution, transmission, copying or disclosure of this information in any way or in any manner is
            strictly
            prohibited. You should delete this message and inform the sender. </em></p>
    <p>&nbsp;</p>

    <p>We received your request to reset your password shahid.<br>
        {{-- To continue, please click <a href="{{ url('confirmationAccept') }}">here</a></p> --}}
        {{-- To continue, please click <a
        href="{{ url('/confirmationAccept?' . 'clientid=' . $clientid . '&&' . 'debtorid=' . $debtorid . '&&' . 'status=' . $yes) }}">here</a> --}}
        To continue, please click <a
            href="{{ url('/confirmationAccept?' . 'clientid=' . $clientid . '&&' . 'debtorid=' . $debtorid . '&&' . 'yes=' . $yes . '&&' . 'no=' . $no) }}">here</a>
    </p>
    {{-- {{ url('authreset/newpassword/' . $url) }} --}}

    {{-- *   --}}
    {{--  Start Hare --}}
    <p>We received your request to reset your password shahid.<br>
        {{-- To continue, please click <a href="{{ url('confirmationAccept') }}">here</a></p> --}}
        {{-- To continue, please click <a
            href="{{ url('/confirmationAccept?' . 'clientid=' . $clientid . '&&' . 'debtorid=' . $debtorid . '&&' . 'status=' . $yes) }}">here</a> --}}
        To continue, please click <a
            href="{{ url('/confirmationAccept?' . 'clientid=' . $clientid . '&&' . 'debtorid=' . $debtorid . '&&' . 'yes=' . $yes . '&&' . 'no=' . $no) }}">here</a>
    </p>
    {{-- {{ url('authreset/newpassword/' . $url) }} --}}
    @php

                                        $timeid = DB::table('timesheetusers')
                                            ->where('timesheetusers.timesheetid', $timesheetDatas->timesheetid)
                                            ->first();

                                        $client_id = DB::table('timesheetusers')
                                            ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
                                            ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
                                            ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.partner')
                                            ->leftJoin(
                                                'teamrolehistory',
                                                'teamrolehistory.teammember_id',
                                                '=',
                                                'teammembers.id',
                                            )
                                            ->where('timesheetusers.timesheetid', $timesheetDatas->timesheetid)
                                            ->select(
                                                'clients.client_name',
                                                'clients.client_code',
                                                'timesheetusers.hour',
                                                'timesheetusers.location',
                                                'timesheetusers.*',
                                                'assignments.assignment_name',
                                                'billable_status',
                                                'workitem',
                                                'teammembers.team_member',
                                                'teammembers.staffcode',
                                                'timesheetusers.timesheetid',
                                                'teamrolehistory.newstaff_code',
                                            )
                                            ->get();
                                        // dd($client_id);
                                        $total = DB::table('timesheetusers')

                                            ->where('timesheetusers.timesheetid', $timesheetDatas->timesheetid)
                                            ->sum('hour');

                                        $dates = date('l', strtotime($timesheetDatas->date));

                                        $permotioncheck = DB::table('teamrolehistory')
                                            ->where('teammember_id', $timesheetDatas->createdby)
                                            ->first();

                                        $datadate = Carbon\Carbon::createFromFormat('Y-m-d', $timesheetDatas->date);

                                        $permotiondate = null;
                                        if ($permotioncheck) {
                                            $permotiondate = Carbon\Carbon::createFromFormat(
                                                'Y-m-d H:i:s',
                                                $permotioncheck->created_at,
                                            );
                                        }

                                    @endphp
    {{-- {{ url('authreset/newpassword/' . $url) }} --}}
</body>

</html>

#Promotion Process
1.The client wants to display the staff code according to the promotion date, so I have done on the partner panel
2.The client wants to display the staff code according to the promotion date, so I am displaying the staff code on the admin panel


<div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        @if (session('message'))
                            <div class="alert alert-success">
                                {{ session('message') }}
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table id="examplee" class="table display table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th style="display: none;">id</th>
                                        <th>Employee</th>
                                        <th class="textfixed">Staff Code</th>
                                        <th>Status</th>
                                        <th>Leave Type</th>
                                        <th class="textfixed">Date of Request</th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>Approver</th>
                                        <th class="textfixed">Approver Code</th>
                                        <th>Reason</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($timesheetrequestsDatas as $timesheetrequestsData)
                                        <tr>
                                            @php
                                                $permotioncheck = DB::table('teamrolehistory')
                                                    ->where('teammember_id', auth()->user()->teammember_id)
                                                    ->first();

                                                $datadate = $timesheetrequestsData->created_at
                                                    ? Carbon\Carbon::createFromFormat(
                                                        'Y-m-d H:i:s',
                                                        $timesheetrequestsData->created_at,
                                                    )
                                                    : null;

                                                $permotiondate = null;
                                                if ($permotioncheck) {
                                                    $permotiondate = Carbon\Carbon::createFromFormat(
                                                        'Y-m-d H:i:s',
                                                        $permotioncheck->created_at,
                                                    );
                                                }
                                            @endphp
                                            <td style="display: none;">{{ $timesheetrequestsData->id }}</td>
                                            {{-- <td>{{ $timesheetrequestsData->createdbyauth }}</td> --}}
                                            @if (auth()->user()->role_id == 11)
                                                <td class="textfixed">
                                                    {{-- <a href="{{ route('applyleave.show', $applyleaveDatas->id) }}"> --}}
                                                    <a href="{{ url('examleaverequest', $timesheetrequestsData->id) }}">
                                                        {{ $timesheetrequestsData->createdbyauth ?? '' }}</a>
                                                </td>
                                            @else
                                                <td class="textfixed">{{ $timesheetrequestsData->createdbyauth }}</td>
                                            @endif
                                            {{-- <td>{{ $timesheetrequestsData->teamstaffcode }}</td> --}}
                                            @if ($permotiondate && $datadate && $datadate->greaterThan($permotiondate))
                                                <td>{{ $timesheetrequestsData->newstaff_code }}</td>
                                            @else
                                                <td>{{ $timesheetrequestsData->teamstaffcode }}</td>
                                            @endif
                                            <td>
                                                @if ($timesheetrequestsData->status == 0)
                                                    <span class="badge badge-pill badge-warning">Created</span>
                                                @elseif($timesheetrequestsData->status == 1)
                                                    <span class="badge badge-pill badge-success">Approved</span>
                                                @else
                                                    <span class="badge badge-pill badge-danger">Rejected</span>
                                                @endif
                                            </td>
                                            <td class="textfixed">{{ $timesheetrequestsData->name }}</td>

                                            <td class="textfixed">
                                                <span style="display: none;">
                                                    {{ date('Y-m-d', strtotime($timesheetrequestsData->created_at)) }}
                                                </span>
                                                {{ date('d-m-Y', strtotime($timesheetrequestsData->created_at)) }}
                                            </td>
                                            <td class="textfixed">
                                                {{ date('d-m-Y', strtotime($timesheetrequestsData->from_date)) }}</td>
                                            {{-- <td>{{ date('d-M-Y', strtotime($timesheetrequestsData->to_date)) }}</td> --}}
                                            <td class="textfixed">
                                                {{ $timesheetrequestsData->to_date ? date('d-m-Y', strtotime($timesheetrequestsData->to_date)) : 'NA' }}
                                            </td>

                                            <td class="textfixed">{{ $timesheetrequestsData->team_member }}

                                            </td>
                                            <td>
                                                {{ $timesheetrequestsData->staffcode }}
                                            </td>

                                            <td class="textfixed">{{ $timesheetrequestsData->reason }}</td>
                                            {{-- <td>{{ $timesheetrequestsData->remark }}</td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <br>
                    <div class="tab-pane fade" id="pills-user" role="tabpanel" aria-labelledby="pills-user-tab">

                        <div class="table-responsive">
                            <table id="exampleee" class="table display table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th style="display: none;">id</th>
                                        <th>Employee</th>
                                        <th>Staff Code</th>
                                        <th>Status</th>
                                        <th>Leave Type</th>
                                        <th>Date of Request</th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>Approver</th>
                                        <th>Approver Code</th>
                                        <th>Reason</th>
                                        @if ($hasPendingRequests)
                                            <th>Approved</th>
                                            <th>Reject</th>
                                        @endif
                                    </tr>
                                </thead>s
                                <tbody>
                                    @foreach ($myteamtimesheetrequestsDatas as $timesheetrequestsDatass)
                                        <tr>
                                            <td style="display: none;">{{ $timesheetrequestsDatass->id }}</td>

                                            @if (auth()->user()->role_id == 13)
                                                <td>

                                                    <a href="{{ url('examleaverequest', $timesheetrequestsDatass->id) }}">
                                                        {{ $timesheetrequestsDatass->createdbyauth ?? '' }}</a>
                                                </td>
                                            @else
                                                <td>{{ $timesheetrequestsDatass->createdbyauth }}</td>
                                            @endif
                                            <td>{{ $timesheetrequestsDatass->teamstaffcode }} </td>
                                            <td>
                                                @if ($timesheetrequestsDatass->status == 0)
                                                    <span class="badge badge-pill badge-warning">Created</span>
                                                @elseif($timesheetrequestsDatass->status == 1)
                                                    <span class="badge badge-pill badge-success">Approved</span>
                                                @else
                                                    <span class="badge badge-pill badge-danger">Rejected</span>
                                                @endif
                                            </td>
                                            <td>{{ $timesheetrequestsDatass->name }}</td>

                                            <td>{{ date('d-m-Y', strtotime($timesheetrequestsDatass->created_at)) }}</td>

                                            <td>{{ date('d-m-Y', strtotime($timesheetrequestsDatass->from_date)) }}</td>
                                            <td>{{ date('d-m-Y', strtotime($timesheetrequestsDatass->to_date)) }}</td>

                                            <td>{{ $timesheetrequestsDatass->team_member }}
                                            </td>
                                            <td>
                                                {{ $timesheetrequestsDatass->staffcode }}
                                            </td>
                                            <td>{{ $timesheetrequestsDatass->reason }}</td>
                                            {{-- <td>{{ $timesheetrequestsData->remark }}</td> --}}
                                            <td>
                                                @if ($timesheetrequestsDatass->status == 0)
                                                    <form method="post"
                                                        action="{{ route('examleaveapprove', $timesheetrequestsDatass->id) }}"
                                                        enctype="multipart/form-data" style="text-align: center;">
                                                        @method('PATCH')
                                                        @csrf
                                                        <button type="submit" class="btn btn-success"
                                                            style="border-radius: 7px; font-size: 10px; padding: 5px;">
                                                            Approve</button>
                                                        <input type="text" hidden id="example-date-input" name="status"
                                                            value="1" class="form-control">

                                                        <input type="hidden" name="leavetype"
                                                            value="{{ $timesheetrequestsDatass->leavetype }}"
                                                            class="form-control" placeholder="">
                                                    </form>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($timesheetrequestsDatass->status == 0)
                                                    <form method="post"
                                                        action="{{ route('examleaveapprove', $timesheetrequestsDatass->id) }}"
                                                        enctype="multipart/form-data" style="text-align: center;">
                                                        @method('PATCH')
                                                        @csrf
                                                        <button style="border-radius: 7px; font-size: 10px; padding: 5px;"
                                                            type="submit" class="btn btn-danger">
                                                            Reject</button>
                                                        <input hidden type="text" id="example-date-input"
                                                            name="status" value="2" class="form-control"
                                                            placeholder="Enter Location">
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>