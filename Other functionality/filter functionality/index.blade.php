{{-- * get data from data base in blade file  --}}
<div class="col-2">
    <div class="form-group">
        <label class="font-weight-600">Client Name</label>
        <select class="language form-control" id="category7" name="teamname">
            <option value="">Please Select One</option>

            @foreach ($timesheetData as $timesheetDatas)
                @php
                    $client_id = DB::table('timesheetusers')
                        ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
                        ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
                        ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.partner')
                        ->where('timesheetusers.timesheetid', $timesheetDatas->timesheetid)
                        ->select('clients.client_name', 'timesheetusers.hour', 'timesheetusers.location', 'timesheetusers.status', 'assignments.assignment_name', 'billable_status', 'workitem', 'teammembers.team_member')
                        ->get();
                @endphp
                @foreach ($client_id as $item)
                    <option value="{{ $item->client_name }}">
                        {{ $item->client_name }}
                    </option>
                @endforeach
            @endforeach
        </select>
    </div>
</div>
