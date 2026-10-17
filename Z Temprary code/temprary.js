
// 222222222222222222222222222222222222222222222222222222222222
"_token" => "7LVhXcbERLT7bdTo2z6uVD7nwx3Rm8ZvJAFXKE11"
"subject" => "i want to contact"
"type" => "1"
"clientid" => "BET100051"
"description
http://127.0.0.1:8000/debtorconfirm?clientid=BET100051&&debtorid=13&&status=1
#parameters: array: 2[▼
"_token" => "Llihh0MMHwx1MiDTiUVTgeLpm4iLmjFhKXgEftho"
"email" => "sunnygupta@vsa.co.in"
  ]
#parameters: array: 3[▼
"clientid" => "BET100051"
"debtorid" => "13"
"status" => "1"
  ]

Route:: get('/authreset/newpassword/{id}', [App\Http\Controllers\Auth\LoginController:: class, 'newPassword']);
// 222222222222222222222222222222222222222222222222222222222222
{
    {
        -- @php
        DB:: table('debtors')
            -> where('assignmentgenerate_id', $clientid)
            -> where('id', $debtorid)
            -> update([
                'mailstatus' => 5,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        @endphp--}
}
3150
bhasker
    // 222222222222222222222222222222222222222222222222222222222222

    -> whereJsonContains('timesheetreport.partnerid', auth() -> user() -> teammember_id)

$nextweektimesheet = DB:: table('timesheetreport')
    -> whereBetween('created_at', ['2023-12-21 20:14:34', '2024-03-25 20:19:53'])
    // ->whereBetween('startdate', ['2023-12-11', '2024-03-25'])
    -> whereNull('partnerid')
    -> select('teamid', 'startdate', 'enddate', 'totaltime')
    -> latest()
    -> get();
// ->count();
// dd($nextweektimesheet, 'hi');

foreach($nextweektimesheet as $nextweektimesheets) {
    dd($nextweektimesheets -> totaltime);
    dd($nextweektimesheets -> enddate);
    dd($nextweektimesheets -> startdate);
    dd($nextweektimesheets -> teamid);

    $timesheetdata = DB:: table('timesheetusers')
        -> whereBetween('date', ['2024-03-04', '2024-03-09'])
        -> where('createdby', 847)
        // ->select('createdby', 'partner')
        -> select('partner')
        -> distinct()
        -> get() -> toArray();


    $zipfoldername1 = [];
    foreach($timesheetdata as $timesheetdatas) {
        $zipfoldername1[] = $timesheetdatas -> partner;
    }
    // dd($zipfoldername1);

    // DB::table('timesheetreport')->insert([
    //   'teamid' => 847,
    //   'partnerid' => json_encode($partners), // Convert array to JSON string
    //   'created_at'                =>      date('y-m-d H:i:s'),
    // ]);

    $updateddata = DB:: table('timesheetreport')
        -> where('teamid', 847)
        -> where('startdate', '2024-03-04')
        -> where('enddate', '2024-03-09')
        // ->get();
        -> update(['partnerid' => $zipfoldername1]);

    dd($updateddata);
}
// 222222222222222222222222222222222222222222222222222222222222

// 333333333333333333333333333333333333333333333

$nextweektimesheet = DB:: table('timesheetreport')
    -> whereBetween('created_at', ['2023-12-21 20:14:34', '2024-03-25 20:19:53'])
    // ->whereBetween('startdate', ['2023-12-11', '2024-03-25'])
    -> whereNull('partnerid')
    -> select('teamid', 'startdate', 'enddate', 'totaltime')
    -> latest()
    -> get();
// ->count();
// dd($nextweektimesheet, 'hi');

dd($nextweektimesheet);

$timesheetdata = DB:: table('timesheetusers')
    -> whereBetween('date', ['2024-03-04', '2024-03-09'])
    -> where('createdby', 847)
    // ->select('createdby', 'partner')
    -> select('partner')
    -> distinct()
    -> get() -> toArray();


$zipfoldername1 = [];
foreach($timesheetdata as $timesheetdatas) {
    $zipfoldername1[] = $timesheetdatas -> partner;
}
// dd($zipfoldername1);

// DB::table('timesheetreport')->insert([
//   'teamid' => 847,
//   'partnerid' => json_encode($partners), // Convert array to JSON string
//   'created_at'                =>      date('y-m-d H:i:s'),
// ]);

$updateddata = DB:: table('timesheetreport')
    -> where('teamid', 847)
    -> where('startdate', '2024-03-04')
    -> where('enddate', '2024-03-09')
    // ->get();
    -> update(['partnerid' => $zipfoldername1]);

dd($updateddata);


// dd($timesheetdata);

// ->whereBetween('date', ['2024-03-11', '2024-03-16'])
// ->where('createdby', 847)
// ->get();
// ->update(['status' => 0]);


// 222222222222222222222222222222222222
// 222222222222222222222222222222222222222222222222222222222222

// in patner column
[844]
[844, 840]


$timesheetreport = DB:: table('timesheetreport') -> latest() -> first();
$partnerIds = json_decode($timesheetreport -> partnerid, true);

// dd($partnerIds); // Verify the partnerIds array

// Initialize an empty array to store the results
$data = [];

// Iterate over each partnerId and query the database
// foreach ($partnerIds as $partnerId) {
$result = DB:: table('timesheetreport')
    -> whereJsonContains('partnerid', 844)
    -> get() -> toArray();

dd($result);
// 222222222222222222222222222222222222222222222222222222222222
{
    {
        -- < p > Client Name: { { $clientname ?? '' } }</p >
<p>Assignment Name : {{ $assignment_name }} {{ $assignmentname ?? '' }}</p>
<p>Assignment Partner : {{ $assignmentpartner ?? '' }}</p>
<p>Team Leader :
    @foreach ($teamleader as $teamleaderDatas)
        {{ $teamleaderDatas->team_member ?? '' }}
    @endforeach
</p> --}
}
// 222222222222222222222222222222222222222222222222222222222222
#parameters: array: 4[▼
"_token" => "HEZkVwczSVcOC1HXl99wcwmAAbz1XObNb1hsqWKe"
"teammember_id" => "796"
"assignmentmapping_id" => "504"
"type" => "0"
  ]

array: 8[▼
"assignmentid" => "QUE100467"
"clientname" => "Queen Mary's School"
"assignmentname" => "openassignment"
"emailid" => "vandanas@vsa.co.in"
"assignment_name" => "Internal Audit"
"assignmentpartner" => "Sunny Gupta"
"otherpartner" => "Bhaskar Kumar"
"teamleader" => Illuminate\Support\Collection {#3080 ▼
    #items: array: 2[▼
    0 => {#3129 ▼
        +"team_member": "Bhaskar Kumar"
    }
    1 => {#3127 ▼
        +"team_member": "Ravina"
    }
      ]
    #escapeWhenCastingToString: false
}
  ]

// 222222222222222222222222222222222222222222222222222222222222

<div class="row row-sm">
<div class="col-2">
    <div class="form-group">
        <label class="font-weight-600">Client Name *</label>
        <select required class="language form-control refresh" name="client_id[]" id="client">
            @if (Request::is('timesheet/*/edit'))
                <option disabled style="display:block">Select Client</option>
                @foreach ($client as $clientData)
                    <option value="{{ $clientData->id }}"
                        {{ $timesheet->client_id == $clientData->id ?? '' ? 'selected="selected"' : '' }}>
                        {{ $clientData->client_name }}
                    </option>
                @endforeach
            @else
                <option value="">Select Client</option>
                @foreach ($client as $clientData)
                    <option value="{{ $clientData->id }}">
                        {{ $clientData->client_name }} ({{ $clientData->client_code }})</option>
                @endforeach
            @endif
        </select>
    </div>
</div>
<div class="col-2">
    <div class="form-group">
        <label class="font-weight-600">Assignment Name *</label>
        <select class="form-control key refreshoption" name="assignment_id[]" id="assignment">
            @if (!empty($timesheet->assignment_id))
                <option value="{{ $timesheet->assignment_id }}">
                    {{ App / Models / Assignment::where('id', $timesheet->assignment_id)->first()->assignment_name ?? '' }}
                </option>
            @endif
        </select>
    </div>
</div>
<div class="col-2">
    <div class="form-group">
        <label class="font-weight-600">Partner *</label>
        <select required class="language form-control refreshoption" id="partner" name="partner[]">
        </select>
    </div>
</div>
<div class="col-2">
    <div class="form-group">
        <label class="font-weight-600" style="width:100px;">Work Item *</label>
        <textarea required required type="text" name="workitem[]" id="key" value="{{ $timesheet->workitem ?? '' }}"
            class="form-control key refresh" rows="2"></textarea>
    </div>
</div>
<div class="col-2">
    <div class="form-group">
        <label class="font-weight-600" style="width:100px;">Location *</label>
        <input required type="text" name="location[]" id="key" value="{{ $timesheet->location ?? '' }}"
            class="form-control key refresh">
    </div>
</div>

<div class="col-1">
    <div class="form-group">
        <label class="font-weight-600">Hour *</label>
        <input required type="number" class="form-control refresh" id="hour1" name="hour[]" min="0"
            oninput="calculateTotal(this)" onkeypress="return event.charCode >= 48 && event.charCode <= 57"
            value="0" step="1">

        <span style="font-size: 10px;margin-left: 10px;"></span>
    </div>
</div>
</div >
    // 222222222222222222222222222222222222222222222222222222222222
    id="client' + x +'"
id = "partner2' + x +'"

// 222222222222222222222222222222222222222222222222222222222222

//   --------------------- 29 sep 2023 joining date---------------