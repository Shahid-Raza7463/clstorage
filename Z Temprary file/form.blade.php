<div class="row row-sm">
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Name <span class="tx-danger">*</span></label>
            <input type="text" name="team_member" value="{{ $teammember->team_member ?? '' }}" class="form-control"
                placeholder="Enter Team Member">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            {{-- <label class="font-weight-600">Mobile No <span class="tx-danger">*</span></label> --}}
            <input type="text" name="mobile_no" value="{{ $teammember->mobile_no ?? '' }}" class="form-control"
                placeholder="Enter Mobile No">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Emergency Mobile No <span class="tx-danger">*</span></label>
            <input type="text" name="emergencycontactnumber" value="{{ $teammember->emergencycontactnumber ?? '' }}"
                class="form-control" placeholder="Enter Emergency Mobile No">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Entity<span class="tx-danger">*</span></label>
            <select class="form-control" id="entitySelect" name="entity">
                <option disabled {{ !isset($teammember) || is_null($teammember->entity) ? 'selected' : '' }}
                    value="">Please Select An Entity</option>
                <option value="K G Somani & Co LLP"
                    {{ ($teammember ?? null) && $teammember->entity == 'K G Somani & Co LLP' ? 'selected' : '' }}>K G
                    Somani & Co LLP</option>
                <option value="Capitall India Pvt. Ltd."
                    {{ ($teammember ?? null) && $teammember->entity == 'Capitall India Pvt. Ltd.' ? 'selected' : '' }}>
                    CapiTall India Pvt. Ltd.</option>
                <option value="KGS Advisors LLP"
                    {{ ($teammember ?? null) && $teammember->entity == 'KGS Advisors LLP' ? 'selected' : '' }}>KGS
                    Advisors LLP</option>
                <option value="Womennovator"
                    {{ ($teammember ?? null) && $teammember->entity == 'Womennovator' ? 'selected' : '' }}>Womennovator
                </option>
                <option value="GVRIKSH"
                    {{ ($teammember ?? null) && $teammember->entity == 'GVRIKSH' ? 'selected' : '' }}>GVRIKSH
                </option>
                <option value="K G Somani Management Consl Pvt Ltd"
                    {{ ($teammember ?? null) && $teammember->entity == 'K G Somani Management Consl Pvt Ltd' ? 'selected' : '' }}>
                    K G Somani Management Consl Pvt Ltd</option>
                <option value="K G Somani - Current Account"
                    {{ ($teammember ?? null) && $teammember->entity == 'K G Somani - Current Account' ? 'selected' : '' }}>
                    K G Somani - Current Account</option>
            </select>
        </div>
    </div>
</div>
<div class="row row-sm">
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Email Id <span class="tx-danger">*</span></label>
            <input type="email" name="emailid" value="{{ $teammember->emailid ?? '' }}" class="form-control"
                placeholder="Enter Email">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Personal Email Id <span class="tx-danger">*</span></label>
            <input type="email" name="personalemail" value="{{ $teammember->personalemail ?? '' }}"
                class="form-control" placeholder="Enter Email">
        </div>
    </div>

    <div class="col-2">
        <div class="form-group">
            <label class="font-weight-600">Gender</label>
            <select name="gender" id="exampleFormControlSelect1" class="form-control">
                <!--placeholder-->
                @if (Request::is('teammember/*/edit')) >
                    @if ($teammember->gender == 'Male')
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    @elseif($teammember->gender == 'Female')
                        <option value="Female">Female</option>
                        <option value="Male">Male</option>
                    @else
                        <option value="">Please select one</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    @endif
                @else
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                @endif
            </select>
        </div>
    </div>
    <div class="col-2">
        <div class="form-group">
            <label class="font-weight-600">Profilepic</label>
            <input type="file" name="profilepic" value="{{ $teammember->profilepic ?? '' }}" class="form-control"
                placeholder="Enter Profile Pic">
        </div>
    </div>
    @if (Request::is('teammember/*/edit') && ($teammember->profilepic ?? null))
        <div class="col-2">
            {{-- <div class="form-group">
                <br>
                <a style="margin-top: 10px;" href="{{ $teammember->getFileUrl($teammember->profilepic) }}"
                    target="blank" data-toggle="tooltip" title="{{ $teammember->profilepic ?? '' }}"
                    class="btn btn-success-soft ml-2"><i class="fas fa-file"></i> View</a>
            </div> --}}
            <div class="col-2">
                <div class="form-group">
                    <img alt="Responsive image" style="width:40%" id="profile-img-tag"
                        src="{{ $teammember->profilepic ?? '' }}">
                </div>
            </div>
        </div>
    @endif
</div>
<div class="row row-sm">
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Department</label>
            <input type="text" name="department" value="{{ $teammember->department ?? '' }}" class="form-control"
                placeholder="Enter Department">
        </div>
    </div>
    <!--
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Father Name</label>
            <input type="text" name="fathername" value="{{ $teammember->fathername ?? '' }}" class="form-control"
                placeholder="Enter Father Name">
        </div>
    </div>-->
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Date of Birth</label>
            <input type="date" id="example-date-input" name="dateofbirth"
                value="{{ $teammember->dateofbirth ?? '' }}" class="form-control" placeholder="Enter dateofbirth">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600"><b>Assign Role <span class="tx-danger">*</span></b></label>
            <select class="form-control" id="exampleFormControlSelect1" name="role_id"
                @if (Request::is('teammember/*/edit')) > <option disabled
            style="display:block">Please Select One</option>

            @foreach ($teamrole as $teamroleData)
            <option value="{{ $teamroleData->id }}"
                {{ $teammember->role->id == $teamroleData->id ?? '' ? 'selected="selected"' : '' }}>
                {{ $teamroleData->rolename }}</option>
            @endforeach


            @else
            <option></option>
            <option value="">Please Select One</option>
            @foreach ($teamrole as $teamroleData)
            <option value="{{ $teamroleData->id }}">
                {{ $teamroleData->rolename }}</option>

            @endforeach @endif
                </select>
        </div>
    </div>
</div>
<div class="row row-sm">
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Aadhar Number</label>
            <input type="text" name="adharcardnumber" value="{{ $teammember->adharcardnumber ?? '' }}"
                class="form-control" placeholder="Enter Aadhar Number">
        </div>
    </div>


    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Address Proof</label>
            <input type="text" name="address_proof" value="{{ $teammember->address_proof ?? '' }}"
                class="form-control" placeholder="Enter Address Proof">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Address Upload</label>
            <input type="file" name="addressupload" value="{{ $teammember->addressupload ?? '' }}"
                class="form-control" placeholder="Enter address_upload">
        </div>
    </div>
    @if (Request::is('teammember/*/edit') && ($teammember->addressupload ?? null))
        <div class="col-3">
            <div class="form-group">
                <br>
                <a style="margin-top: 10px;" href="{{ $teammember->getFileUrl($teammember->addressupload) }}"
                    target="blank" data-toggle="tooltip" title="{{ $teammember->addressupload ?? '' }}"
                    class="btn btn-success-soft ml-2"><i class="fas fa-file"></i> View</a>
            </div>
        </div>
    @endif
</div>
<div class="row row-sm">
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Aadhar Upload</label>
            <input type="file" name="aadharupload" value="{{ $teammember->aadharupload ?? '' }}"
                class="form-control" placeholder="Enter panupload">
        </div>
    </div>
    @if (Request::is('teammember/*/edit') && ($teammember->aadharupload ?? null))
        <div class="col-3">
            <div class="form-group">
                <br>
                <a style="margin-top: 10px;" href="{{ $teammember->getFileUrl($teammember->aadharupload) }}"
                    target="blank" data-toggle="tooltip" title="{{ $teammember->aadharupload ?? '' }}"
                    class="btn btn-success-soft ml-2"><i class="fas fa-file"></i> View</a>
            </div>
        </div>
    @endif
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Pan Card No <span class="tx-danger">*</span></label>
            <input type="text" name="pancardno" value="{{ $teammember->pancardno ?? '' }}" class="form-control"
                placeholder="Enter Pan Card No.">
        </div>
    </div>

    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Pan Upload</label>
            <input type="file" name="panupload" value="{{ $teammember->panupload ?? '' }}" class="form-control"
                placeholder="Enter panupload">
        </div>
    </div>
    @if (Request::is('teammember/*/edit') && ($teammember->panupload ?? null))
        <div class="col-3">
            <div class="form-group">
                <br>
                <a style="margin-top: 10px;" href="{{ $teammember->getFileUrl($teammember->panupload) }}"
                    target="blank" data-toggle="tooltip" title="{{ $teammember->panupload ?? '' }}"
                    class="btn btn-success-soft ml-2"><i class="fas fa-file"></i> View</a>
            </div>
        </div>
    @endif
</div>
<div class="row row-sm">
    <div class="col-2">
        <div class="form-group">
            <label class="font-weight-600">Appointment Letter *</label>
            <input type="file" name="appointment_letter" value="{{ $teammember->appointment_letter ?? '' }}"
                class="form-control" placeholder="Enter address_upload">
        </div>
    </div>
    @if (Request::is('teammember/*/edit') && ($teammember->appointment_letter ?? null))
        <div class="col-1">
            <div class="form-group">
                <br>
                <a style="margin-top: 10px;" href="{{ $teammember->getFileUrl($teammember->appointment_letter) }}"
                    target="blank" data-toggle="tooltip" title="{{ $teammember->appointment_letter ?? '' }}"
                    class="btn btn-success-soft ml-2"><i class="fas fa-file"></i> View</a>
            </div>
        </div>
    @endif
    <div class="col-2">
        <div class="form-group">
            <label class="font-weight-600">NDA *</label>
            <input type="file" name="nda" value="{{ $teammember->nda ?? '' }}" class="form-control"
                placeholder="Enter NDA">
        </div>
    </div>
    @if (Request::is('teammember/*/edit') && ($teammember->nda ?? null))
        <div class="col-1">
            <div class="form-group">
                <br>
                <a style="margin-top: 10px;" href="{{ $teammember->getFileUrl($teammember->nda) }}" target="blank"
                    data-toggle="tooltip" title="{{ $teammember->nda ?? '' }}" class="btn btn-success-soft ml-2"><i
                        class="fas fa-file"></i> View</a>
            </div>
        </div>
    @endif
    <div class="col-2">
        <div class="form-group">
            <label class="font-weight-600">Team lead</label>
            <input type="text" name="teamlead" value="{{ $teammember->teamlead ?? '' }}" class="form-control"
                placeholder="Enter Team lead">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Qualification</label>
            <input type="text" name="qualification" value="{{ $teammember->qualification ?? '' }}"
                class="form-control" placeholder="Enter Qualification">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Designation</label>
            <input type="text" name="designation" value="{{ $teammember->designation ?? '' }}"
                class="form-control" placeholder="Enter Designation">
        </div>
    </div>
</div>
<div class="row row-sm">
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Permanent Address</label>
            <input type="text" name="permanentaddress" value="{{ $teammember->permanentaddress ?? '' }}"
                class="form-control" placeholder="Enter Permanent Address">
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Communication Address</label>
            <input type="text" name="communicationaddress" value="{{ $teammember->communicationaddress ?? '' }}"
                class="form-control" placeholder="Enter Communication Address">
        </div>
    </div>
</div>
<div class="row row-sm">
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Mother Name</label>
            <input type="text" name="mothername" value="{{ $teammember->mothername ?? '' }}"
                class="form-control" placeholder="Enter Mother Name">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Mother Number </label>
            <input type="text" name="mothernumber" value="{{ $teammember->mothernumber ?? '' }}"
                class="form-control" placeholder="Enter Mother Number">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Father Name</label>
            <input type="text" name="fathername" value="{{ $teammember->fathername ?? '' }}"
                class="form-control" placeholder="Enter Father Name">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Father Number </label>
            <input type="text" name="fathernumber" value="{{ $teammember->fathernumber ?? '' }}"
                class="form-control" placeholder="Enter Father Number">
        </div>
    </div>
</div>


<div class="row row-sm">
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Name As Per Bank Account</label>
            <input type="text" name="nameasperbank" value="{{ $teammember->nameasperbank ?? '' }}"
                class="form-control" placeholder="Enter Name As Per Bank Account">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Bank Name</label>
            <input type="text" name="nameofbank" value="{{ $teammember->nameofbank ?? '' }}"
                class="form-control" placeholder="Enter Permanent Address">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Bank Account Number</label>
            <input type="text" name="bankaccountnumber" value="{{ $teammember->bankaccountnumber ?? '' }}"
                class="form-control" placeholder="Enter Permanent Address">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">IFSC Code</label>
            <input type="text" name="ifsccode" value="{{ $teammember->ifsccode ?? '' }}" class="form-control"
                placeholder="Enter Permanent Address">
        </div>
    </div>
</div>
<div class="row row-sm">
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Joining Date</label>
            <input type="date" id="example-date-input" name="joining_date"
                value="{{ $teammember->joining_date ?? '' }}" class="form-control" placeholder="Enter joining_date">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Leaving Date</label>
            <input type="date" id="example-date-input" name="leavingdate"
                value="{{ $teammember->leavingdate ?? '' }}" class="form-control" placeholder="Enter Leaving Date">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Date of Resign</label>
            <input type="date" id="example-date-input" name="dateofresign"
                value="{{ $teammember->dateofresign ?? '' }}" class="form-control" placeholder="Enter dateofresign">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Status</label>
            <select name="status" id="exampleFormControlSelect1" class="form-control">
                <!--placeholder-->
                @if (Request::is('teammember/*/edit')) >
                    @if ($teammember->status == '0')
                        <option value="0">InActive</option>
                        <option value="1">Active</option>
                    @else
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    @endif
                @else
                    <option value="0">InActive</option>
                    <option value="1">Active</option>
                @endif
            </select>
        </div>
    </div>
</div>
<div class="row row-sm">


    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Location <span class="tx-danger">*</span></label>
            <input type="text" name="location" value="{{ $teammember->location ?? '' }}" class="form-control"
                placeholder="Enter Location">
        </div>
    </div>

    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600"><b>Mentor <span class="tx-danger">*</span></b></label>
            <select class="form-control" id="exampleFormControlSelect1" name="mentor_id"
                @if (Request::is('teammember/*/edit')) > <option 
            style="display:block" value="0">Please Select One</option>

            @foreach ($mentor as $teamroleData)
            <option value="{{ $teamroleData->id }}"
                {{ $teammember->mentor_id == $teamroleData->id ?? '' ? 'selected="selected"' : '' }}>
                {{ $teamroleData->team_member }} ( {{ $teamroleData->rolename }} )  </option>
            @endforeach


            @else
           
            <option value="0"></option>
				<option value="0">Please Select One</option>
            @foreach ($mentor as $teamroleData)
            <option value="{{ $teamroleData->id }}">
                {{ $teamroleData->team_member }} ( {{ $teamroleData->rolename }} ) </option>

            @endforeach @endif
                </select>
        </div>
    </div>
    @if (Auth::user()->role_id == 18)
        <div class="col-3">
            <div class="form-group">
                <label class="font-weight-600">Gross Salary <span class="tx-danger">*</span></label>
                <input type="text" name="monthly_gross_salary"
                    value="{{ $teammember->monthly_gross_salary ?? '' }}" class="form-control"
                    placeholder="Enter Gross Salary">
            </div>
        </div>
    @endif
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Timesheet Applicable<span class="tx-danger">*</span></label>
            <select class="form-control" id="entitySelect" name="timesheet_applicable">
                <option disabled
                    {{ !isset($teammember) || is_null($teammember->timesheet_applicable) ? 'selected' : '' }}
                    value="">Please Select Timesheet Applicable</option>
                <option value="Yes"
                    {{ isset($teammember) && $teammember->timesheet_applicable === 'Yes' ? 'selected' : '' }}>Yes
                </option>
                <option value="No"
                    {{ isset($teammember) && $teammember->timesheet_applicable === 'No' ? 'selected' : '' }}>No
                </option>
            </select>
        </div>

    </div>
    @if (in_array(Auth::user()->role_id, [11, 18]))
        <div class="col-3">
            <div class="form-group">
                <label class="font-weight-600">PF Status<span class="tx-danger">*</span></label>
                <select class="form-control" id="pfApplicableSelect" name="pf_applicable">
                    <option disabled {{ !isset($teammember) || is_null($teammember->pf_applicable) ? 'selected' : '' }}
                        value="">Please Select</option>
                    <option value="Yes"
                        {{ isset($teammember) && $teammember->pf_applicable === 'Yes' ? 'selected' : '' }}>Yes
                    </option>
                    <option value="No"
                        {{ isset($teammember) && $teammember->pf_applicable === 'No' ? 'selected' : '' }}>No</option>
                    <option value="N/A"
                        {{ isset($teammember) && $teammember->pf_applicable === 'N/A' ? 'selected' : '' }}>N/A
                    </option>
                </select>
            </div>
        </div>
    @endif
</div>
<div class="row row-sm">


    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Passport <span class="tx-danger">*</span></label>
            <input type="file" name="passport" class="form-control" placeholder="Enter Team Member">
        </div>
    </div>
    @if (Request::is('teammember/*/edit') && ($teammember->passport ?? null))
        <div class="col-1">
            <div class="form-group">
                <br>
                <a style="margin-top: 10px;" href="{{ $teammember->getFileUrl($teammember->passport) }}"
                    target="blank" data-toggle="tooltip" title="{{ $teammember->passport ?? '' }}"
                    class="btn btn-success-soft ml-2"><i class="fas fa-file"></i> View</a>
            </div>
        </div>
    @endif
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Voter id <span class="tx-danger">*</span></label>
            <input type="file" name="voterid" class="form-control" placeholder="Enter Mobile No">
        </div>
    </div>
    @if (Request::is('teammember/*/edit') && ($teammember->voterid ?? null))
        <div class="col-1">
            <div class="form-group">
                <br>
                <a style="margin-top: 10px;" href="{{ $teammember->getFileUrl($teammember->voterid) }}"
                    target="blank" data-toggle="tooltip" title="{{ $teammember->voterid ?? '' }}"
                    class="btn btn-success-soft ml-2"><i class="fas fa-file"></i> View</a>
            </div>
        </div>
    @endif
    <div class="col-2">
        <div class="form-group">
            <label class="font-weight-600">Driving license <span class="tx-danger">*</span></label>
            <input type="file" name="drivinglicense" class="form-control"
                placeholder="Enter Emergency Mobile No">
        </div>
    </div>
    @if (Request::is('teammember/*/edit') && ($teammember->drivinglicense ?? null))
        <div class="col-1">
            <div class="form-group">
                <br>
                <a style="margin-top: 10px;" href="{{ $teammember->getFileUrl($teammember->drivinglicense) }}"
                    target="blank" data-toggle="tooltip" title="{{ $teammember->drivinglicense ?? '' }}"
                    class="btn btn-success-soft ml-2"><i class="fas fa-file"></i> View</a>
            </div>
        </div>
    @endif
</div>
<div class="form-group">
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    <a class="btn btn-secondary" href="{{ url('teammember') }}">
        Back</a>

</div>
