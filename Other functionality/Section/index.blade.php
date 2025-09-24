@if (Auth::user()->role_id == 13 || Auth::user()->role_id == 14)
    <div class="body-content">
        <div class="row">

            <div class="col-md-6 col-lg-3">
                <!--Active users indicator-->
                <div class="p-2 bg-primary text-white rounded mb-3 p-3 shadow-sm text-center">
                    <a href="{{ url('assignmentmapping') }}">
                        <div style="color:white;"
                            class="opacity-50 header-pretitle fs-11 font-weight-bold text-uppercase">Open Assignment
                        </div>
                        <div style="color:white;" class="fs-32 text-monospace">{{ $assignmentcount }}</div>
                        <small style="color:white;"> Assignment</small>
                    </a>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <!--Active users indicator-->
                <div class="p-2 bg-primary text-white rounded mb-3 p-3 shadow-sm text-center">
                    <a href="{{ url('assignmentmapping') }}">
                        <div style="color:white;"
                            class="opacity-50 header-pretitle fs-11 font-weight-bold text-uppercase">Open Assignment
                        </div>
                        <div style="color:white;" class="fs-32 text-monospace">{{ $assignmentcount }}</div>
                        <small style="color:white;"> Assignment</small>
                    </a>
                </div>
            </div>
            {{-- <div class="col-md-6 col-lg-3">
    <!--Active users indicator-->
    <div class="p-2 bg-success text-white rounded mb-3 p-3 shadow-sm text-center">
        <a href="{{url('tender')}}" >
        <div style="color:white;" class="opacity-50 header-pretitle fs-11 font-weight-bold text-uppercase">Tender</div>
        <div style="color:white;" class="fs-32 text-monospace">{{ $tender ??''}}</div>
        <small style="color:white;" >latest tender</small>
        </a>
    </div>
</div> --}}
            {{--   <div class="col-md-6 col-lg-3">
    <!--Active users indicator-->
    <div class="p-2 text-white rounded mb-3 p-3 shadow-sm text-center" style="background-color: darkcyan;">
           <a href="{{url('notification')}}" >
        <div style="color:white;" class="opacity-50 header-pretitle fs-11 font-weight-bold text-uppercase">Notification</div>
        <div style="color:white;" class="fs-32 text-monospace">{{ $notification }}</div>
        <small style="color:white;">Latest Notification</small>
        </a>
    </div>
</div> --}}

        </div>


    </div>
@endif
