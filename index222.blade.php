    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @extends('backEnd.layouts.layout') @section('backEnd_content')
        <!--Content Header (Page header)-->
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                /* font-family: 'Poppins', sans-serif; */
                background-color: #f5f7fa;
                color: #333;
                padding: 20px;
            }

            .dashboard-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 25px;
            }

            .dashboard-header h1 {
                font-size: 28px;
                font-weight: 600;
                color: #2c3e50;
            }

            .user-profile {
                display: flex;
                align-items: center;
                gap: 15px;
            }

            .user-profile img {
                width: 45px;
                height: 45px;
                border-radius: 50%;
                object-fit: cover;
                border: 2px solid #5ab5ee;
            }

            .user-info h3 {
                font-size: 16px;
                font-weight: 500;
                margin-bottom: 3px;
            }

            .user-info p {
                font-size: 13px;
                color: #7f8c8d;
            }

            .dashboard-card-content {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 25px;
            }

            .dashboard-card-fullcontent {
                display: grid;
                grid-template-columns: 1fr;
                gap: 25px;
                margin-top: 25px
            }

            .card {
                background: white;
                border-radius: 12px;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
                padding: 25px;
                margin-bottom: 25px;
                transition: transform 0.3s ease;
            }

            .card:hover {
                transform: translateY(-5px);
            }

            .card-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 20px;
                padding-bottom: 15px;
                border-bottom: 1px solid #eee;
            }

            .card-header h2 {
                font-size: 20px;
                font-weight: 800;
                color: #2c3e50;
                margin-left: -16px;
            }

            .priority-tag {
                padding: 5px 12px;
                border-radius: 20px;
                font-size: 12px;
                font-weight: 600;
            }

            .high-priority {
                background-color: #ffebee;
                color: #e53935;
            }

            .on-track {
                background-color: #e8f5e9;
                color: #43a047;
            }

            .delayed {
                background-color: #fff8e1;
                color: #ff8f00;
            }

            .assignment-card {
                padding: 20px;
                margin-bottom: 20px;
                border-radius: 10px;
                background: #f8f9fa;
            }

            .assignment-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 15px;
            }

            .assignment-title h3 {
                font-size: 18px;
                font-weight: 600;
                margin-bottom: 5px;
            }

            .assignment-title p {
                font-size: 14px;
                color: #7f8c8d;
            }

            .assignment-status {
                display: flex;
                flex-direction: column;
                align-items: flex-end;
            }

            .progress-container {
                margin-top: 15px;
            }

            .progress-info {
                display: flex;
                justify-content: space-between;
                margin-bottom: 8px;
            }

            .progress-bar {
                height: 10px;
                background: #e0e0e0;
                border-radius: 5px;
                overflow: hidden;
            }

            .progress-fill {
                height: 100%;
                border-radius: 5px;
            }

            .progress-85 {
                width: 85%;
                background: linear-gradient(to right, #4facfe, #00f2fe);
            }

            .progress-45 {
                width: 45%;
                background: linear-gradient(to right, #ff9a9e, #fad0c4);
            }

            .progress-84 {
                width: 84%;
                background: linear-gradient(to right, #4facfe, #00f2fe);
            }

            .progress-60 {
                width: 60%;
                background: linear-gradient(to right, #a1c4fd, #c2e9fb);
            }

            .progress-100 {
                width: 100%;
                background: linear-gradient(to right, #0fd850, #0fd850);
            }

            .progress-37 {
                width: 37%;
                background: linear-gradient(to right, #ff9a9e, #fad0c4);
            }

            .progress-80 {
                width: 80%;
                background: linear-gradient(to right, #a1c4fd, #c2e9fb);
            }


            .progress-document-84 {
                width: 84%;
                background: linear-gradient(to right, #0a0a0b, #650997);
            }


            .progress-document-45 {
                width: 45%;
                background: linear-gradient(to right, #0a0a0b, #650997);
            }

            .progress-document-100 {
                width: 100%;
                background: linear-gradient(to right, #0a0a0b, #650997);
            }


            .document-progress {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 20px;
            }

            .document-card {
                background: #f8f9fa;
                padding: 15px;
                border-radius: 10px;
            }

            .document-card h3 {
                font-size: 18px;
                font-weight: 600;
                margin-bottom: 10px;
            }

            .document-info {
                display: flex;
                justify-content: space-between;
                margin-bottom: 8px;
                font-size: 14px;
            }

            .progress-value {
                font-weight: 600;
            }

            .ecqr-card {
                padding: 20px;
                margin-bottom: 20px;
                border-radius: 10px;
                background: #f8f9fa;
            }

            .ecqr-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 15px;
            }


            .ecqr-title h3 {
                font-size: 18px;
                font-weight: 600;
                margin-bottom: 5px;
            }

            .ecqr-title p {
                font-size: 14px;
                color: #7f8c8d;
            }

            .ecqr-status {
                display: flex;
                flex-direction: column;
                align-items: flex-end;
            }

            .dashboard-bottom {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 25px;
                margin-top: 15px;
            }

            .support-ticket .card-header {
                background-color: #5ab5ee59;
            }

            .notification .card-header {
                background-color: #ff000029;
            }

            .list-group-item {
                padding: 15px 0;
                border-bottom: 1px solid #eee;
            }

            .list-group-item:last-child {
                border-bottom: none;
            }

            .list-group-item a {
                text-decoration: none;
                color: #333;
                display: block;
            }

            .ticket-id {
                font-size: 13px;
                color: #7f8c8d;
            }

            .ticket-subject {
                font-weight: 600;
                margin: 5px 0;
                color: #2c3e50;
            }

            .ticket-meta {
                display: flex;
                justify-content: space-between;
                font-size: 12px;
                color: #7f8c8d;
            }

            .badge {
                padding: 3px 10px;
                border-radius: 12px;
                font-size: 12px;
                font-weight: 500;
            }

            .badge-open {
                background: #e3f2fd;
                color: #1976d2;
            }

            .badge-working {
                background: #fff8e1;
                color: #ff8f00;
            }

            .badge-close {
                background: #e8f5e9;
                color: #43a047;
            }

            .notification-item {
                padding: 15px 0;
                border-bottom: 1px solid #eee;
            }

            .notification-item:last-child {
                border-bottom: none;
            }

            .notification-title {
                font-weight: 600;
                margin-bottom: 5px;
                color: #2c3e50;
            }

            .notification-creator {
                font-size: 13px;
                color: #1976d2;
            }

            .notification-time {
                font-size: 12px;
                color: #7f8c8d;
            }

            .dropdown-footer {
                text-align: center;
                padding: 15px 0 5px;
            }

            .dropdown-footer a {
                color: #5ab5ee;
                text-decoration: none;
                font-weight: 500;
            }

            .view-all {
                text-align: center;
                margin-top: 10px;
            }

            .view-all a {
                color: #5ab5ee;
                text-decoration: none;
                font-weight: 500;
            }

            .no-data {
                text-align: center;
                padding: 40px 0;
                color: #95a5a6;
            }

            .icon-wrapper {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 40px;
                height: 40px;
                background: rgba(90, 181, 238, 0.2);
                border-radius: 50%;
                margin-right: 10px;
            }

            .icon-wrapper i {
                font-size: 20px;
                color: #5ab5ee;
            }

            @media (max-width: 992px) {

                .dashboard-card-content,
                .dashboard-bottom {
                    grid-template-columns: 1fr;
                }
            }
        </style>
        <div class="content-header row align-items-center m-0">
            {{-- <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
            <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav> --}}
            <div class="col-sm-8 header-title p-0">
                <div class="media">
                    <div class="header-icon text-success mr-3"><i class="typcn typcn-home-outline mr-2"></i></div>
                    <div class="media-body">
                        <h1 class="font-weight-bold">Dashboard</h1>
                        <small>From now on you will start your activities.</small>
                    </div>
                </div>
            </div>
        </div>
        <!--/.Content Header (Page header)-->
        @if (Auth::user()->role_id == 13 || Auth::user()->role_id == 14)
            <div class="body-content">
                <div class="row">
                    <div class="col-md-6 col-lg-3">
                        <!--Active users indicator-->
                        <div class="p-2 bg-info text-white rounded mb-3 p-3 shadow-sm text-center">
                            <a href="{{ url('assignmentmapping') }}">
                                <div style="color:white;"
                                    class="opacity-50 header-pretitle fs-11 font-weight-bold text-uppercase">Team Assignment
                                </div>
                                <div style="color:white;" class="fs-32 text-monospace">{{ $assignmentcount }}</div>
                                <small style="color:white;">Latest Assignment</small>
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
                                <small style="color:white;">active Assignment</small>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <!--Active users indicator-->
                        <div class="p-2 bg-success text-white rounded mb-3 p-3 shadow-sm text-center">
                            <a href="{{ url('tender') }}">
                                <div style="color:white;"
                                    class="opacity-50 header-pretitle fs-11 font-weight-bold text-uppercase">Tender</div>
                                <div style="color:white;" class="fs-32 text-monospace">{{ $tender ?? '' }}</div>
                                <small style="color:white;">latest tender</small>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <!--Active users indicator-->
                        <div class="p-2 text-white rounded mb-3 p-3 shadow-sm text-center"
                            style="background-color: darkcyan;">
                            <a href="{{ url('notification') }}">
                                <div style="color:white;"
                                    class="opacity-50 header-pretitle fs-11 font-weight-bold text-uppercase">Notification
                                </div>
                                <div style="color:white;" class="fs-32 text-monospace">{{ $notification }}</div>
                                <small style="color:white;">Latest Notification</small>
                            </a>
                        </div>
                    </div>

                </div>


            </div>
        @endif
        @if (Auth::user()->role_id == 15)
            <div class="body-content">
                <div class="row">
                    <div class="col-md-6 col-lg-3">
                        <!--Active users indicator-->
                        <div class="p-2 bg-info text-white rounded mb-3 p-3 shadow-sm text-center">
                            <div class="opacity-50 header-pretitle fs-11 font-weight-bold text-uppercase">Team Assignment
                            </div>
                            <div class="fs-32 text-monospace">{{ $assignmentcount }}</div>
                            <small>Latest Assignment</small>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <!--Active users indicator-->
                        <div class="p-2 bg-primary text-white rounded mb-3 p-3 shadow-sm text-center">
                            <div class="opacity-50 header-pretitle fs-11 font-weight-bold text-uppercase">Open Assignment
                            </div>
                            <div class="fs-32 text-monospace">{{ $assignmentcount }}</div>
                            <small>active Assignment</small>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <!--Active users indicator-->
                        <div class="p-2 bg-success text-white rounded mb-3 p-3 shadow-sm text-center">
                            <div class="opacity-50 header-pretitle fs-11 font-weight-bold text-uppercase">Close Assignment
                            </div>
                            <div class="fs-32 text-monospace">0</div>
                            <small>close Assignment</small>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <!--Active users indicator-->
                        <div class="p-2 text-white rounded mb-3 p-3 shadow-sm text-center"
                            style="background-color: darkcyan;">
                            <div class="opacity-50 header-pretitle fs-11 font-weight-bold text-uppercase">Notification</div>
                            <div class="fs-32 text-monospace">{{ $notification }}</div>
                            <small>Latest Notification</small>
                        </div>
                    </div>

                </div>


            </div>
        @endif
        @if (Auth::user()->role_id == 12)
            <div class="body-content">
                <div class="row">
                    <div class="col-md-6 col-lg-3">
                        <!--Active users indicator-->
                        <div class="p-2 bg-info text-white rounded mb-3 p-3 shadow-sm text-center">
                            <a href="{{ url('assignmentmapping') }}">
                                <div style="color:white;"
                                    class="opacity-50 header-pretitle fs-11 font-weight-bold text-uppercase">Assignment
                                </div>
                                <div style="color:white;" class="fs-32 text-monospace">{{ $assignmentcount }}</div>
                                <small style="color:white;">Latest Assignment</small>
                                <a></a>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <!--Active users indicator-->
                        <div class="p-2 bg-primary text-white rounded mb-3 p-3 shadow-sm text-center">
                            <a href="{{ url('client') }}">
                                <div style="color:white;"
                                    class="opacity-50 header-pretitle fs-11 font-weight-bold text-uppercase">Client</div>
                                <div style="color:white;" class="fs-32 text-monospace">{{ $client }}</div>
                                <small style="color:white;">active clients</small>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <!--Active users indicator-->
                        <div class="p-2 bg-success text-white rounded mb-3 p-3 shadow-sm text-center">
                            <a href="{{ url('teammember') }}">
                                <div style="color:white;"
                                    class="opacity-50 header-pretitle fs-11 font-weight-bold text-uppercase">Team Member
                                </div>
                                <div style="color:white;" class="fs-32 text-monospace">{{ $teammember }}</div>
                                <small style="color:white;">active Member</small>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <!--Active users indicator-->
                        <div class="p-2 text-white rounded mb-3 p-3 shadow-sm text-center"
                            style="background-color: darkcyan;">
                            <a href="{{ url('notification') }}">
                                <div style="color:white;"
                                    class="opacity-50 header-pretitle fs-11 font-weight-bold text-uppercase">Notification
                                </div>
                                <div style="color:white;" class="fs-32 text-monospace">{{ $notification }}</div>
                                <small style="color:white;">Latest Notification</small>
                            </a>
                        </div>
                    </div>

                </div>


            </div>
        @endif
        @if (Auth::user()->role_id == 11)
            {{-- <div class="body-content">
            <div class="row">
                <div class="col-md-6 col-lg-3">
                    <!--Active users indicator-->
                    <div class="p-2 bg-info text-white rounded mb-3 p-3 shadow-sm text-center">
                        <a href="{{ url('assignmentmapping') }}">
                            <div style="color:white;"
                                class="opacity-50 header-pretitle fs-11 font-weight-bold text-uppercase">Assignment</div>
                            <div style="color:white;" class="fs-32 text-monospace">{{ $assignmentcount }}</div>
                            <small style="color:white;">Latest Assignment</small>
                            <a></a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <!--Active users indicator-->
                    <div class="p-2 bg-primary text-white rounded mb-3 p-3 shadow-sm text-center">
                        <a href="{{ url('client') }}">
                            <div style="color:white;"
                                class="opacity-50 header-pretitle fs-11 font-weight-bold text-uppercase">Client</div>
                            <div style="color:white;" class="fs-32 text-monospace">{{ $client }}</div>
                            <small style="color:white;">active clients</small>
                        </a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <!--Active users indicator-->
                    <div class="p-2 bg-success text-white rounded mb-3 p-3 shadow-sm text-center">
                        <a href="{{ url('teammember') }}">
                            <div style="color:white;"
                                class="opacity-50 header-pretitle fs-11 font-weight-bold text-uppercase">Team Member</div>
                            <div style="color:white;" class="fs-32 text-monospace">{{ $teammember }}</div>
                            <small style="color:white;">active Member</small>
                        </a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <!--Active users indicator-->
                    <div class="p-2 text-white rounded mb-3 p-3 shadow-sm text-center"
                        style="background-color: darkcyan;">
                        <a href="{{ url('notification') }}">
                            <div style="color:white;"
                                class="opacity-50 header-pretitle fs-11 font-weight-bold text-uppercase">Notification</div>
                            <div style="color:white;" class="fs-32 text-monospace">{{ $notification }}</div>
                            <small style="color:white;">Latest Notification</small>
                        </a>
                    </div>
                </div>
            </div>
        </div> --}}
            <div class="body-content">
                <div class="row">
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="p-3 shadow-sm border border-danger rounded text-dark"
                            style=" background-color: rgb(249, 231, 231)">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="font-weight-bold small" style="margin-bottom: 10px;">Bills
                                        Pending</div>
                                    <div class="h4 font-weight-bold">{{ $billspending }}</div>
                                    <div class="text-muted small">Bills pending processing</div>
                                    <div class="text-danger small mt-2">
                                        <i class="fas fa-arrow-down"></i> 12% vs last month
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="p-3 shadow-sm border border-success rounded text-dark"
                            style=" background-color: rgb(240, 253, 244);">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="font-weight-bold small" style="margin-bottom: 10px;">Bills
                                        Pending For Collection</div>
                                    <div class="h4 font-weight-bold">{{ $billspendingforcollection }}</div>
                                    <div class="text-muted small">Payments pending processing</div>
                                    <div class="text-success small mt-2">
                                        <i class="fas fa-arrow-up"></i> 12% vs last month
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="p-3 shadow-sm border border-warning rounded text-dark"
                            style="background-color: rgb(254, 252, 232);">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="font-weight-bold small" style="margin-bottom: 10px;">Assignments Completed
                                    </div>
                                    <div class="h4 font-weight-bold">{{ $assignmentcompleted }}</div>
                                    <div class="text-muted small">This month</div>
                                    <div class="text-danger small mt-2">
                                        <i class="fas fa-arrow-down"></i> 12% vs last month
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="p-3 shadow-sm border border-primary rounded text-dark"
                            style=" background-color: rgb(235, 231, 248)">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="font-weight-bold small" style="margin-bottom: 10px;">Delayed Assignments
                                    </div>
                                    <div class="h4 font-weight-bold">{{ $delayedAssignments }}</div>
                                    <div class="text-muted small">Requiring attention</div>
                                    <div class="text-danger small mt-2">
                                        <i class="fas fa-arrow-down"></i> 12% vs last month
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="p-3 shadow-sm border border-primary rounded text-dark"
                            style=" background-color: rgb(235, 231, 248)">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="font-weight-bold small" style="margin-bottom: 10px;">Exceptional Expenses
                                    </div>
                                    <div class="h4 font-weight-bold">{{ $exceptionalExpenses }}</div>
                                    <div class="text-muted small">Current month</div>
                                    <div class="text-danger small mt-2">
                                        <i class="fas fa-arrow-down"></i> 12% vs last month
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="p-3 shadow-sm border border-warning rounded text-dark"
                            style="background-color: rgb(254, 252, 232);">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="font-weight-bold small" style="margin-bottom: 10px;">Loss Making
                                        Assignments
                                    </div>
                                    <div class="h4 font-weight-bold">{{ 'NA' }}</div>
                                    <div class="text-muted small">Need review</div>
                                    <div class="small mt-2">&nbsp;</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="p-3 shadow-sm border border-success rounded text-dark"
                            style=" background-color: rgb(240, 253, 244);">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="font-weight-bold small" style="margin-bottom: 10px;">New Tenders Submitted
                                    </div>
                                    <div class="h4 font-weight-bold">{{ $tendersSubmittedCount }}</div>
                                    <div class="text-muted small">This month</div>
                                    <div class="small mt-2">&nbsp;</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="p-3 shadow-sm border border-danger rounded text-dark"
                            style=" background-color: rgb(249, 231, 231)">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="font-weight-bold small" style="margin-bottom: 10px;">Audit Acceptance
                                        Pending
                                    </div>
                                    <div class="h4 font-weight-bold">{{ $totalNotFilled }}</div>
                                    <div class="text-muted small">Awaiting client approval</div>
                                    <div class="small mt-2">&nbsp;</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="p-3 shadow-sm border border-danger rounded text-dark"
                            style=" background-color: rgb(249, 231, 231)">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="font-weight-bold small" style="margin-bottom: 10px;">ECQR Audits Due
                                    </div>
                                    <div class="h4 font-weight-bold">{{ $auditsDue }}</div>
                                    <div class="text-muted small">Pending completion</div>
                                    <div class="small mt-2">&nbsp;</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        {{-- <div class="body-content">
            <div class="row">
                <div class="col-md-12 col-lg-6">
                    <div class="card p-3 mb-4" style="height: 310px; border: 1px solid #e5e7eb;">
                        <h5 class="fw-bold mb-3">Assignment Status Overview</h5>

                        <div class="mb-3 p-3 rounded" style="background-color: #f8f9fa;">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="mb-1 fw-semibold">Tax Audit - ABC Corp</h6>
                                    <small class="text-muted">ABC Corporation</small>
                                    <div class="mt-2">Progress</div>
                                    <div class="progress mt-1" style="height: 8px;">
                                        <div class="progress-bar bg-dark" role="progressbar" style="width: 85%;"></div>
                                    </div>
                                    <small class="text-muted">Due: 2025-06-15</small>
                                </div>
                                <div class="text-end">
                                    <span class="badge rounded-pill bg-primary mb-1">ON TRACK</span><br>
                                    <span class="badge rounded-pill bg-danger">HIGH PRIORITY</span>
                                </div>
                            </div>
                        </div>

                        <div class="p-3 rounded" style="background-color: #fef2f2;">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="mb-1 fw-semibold">GST Compliance - XYZ Ltd</h6>
                                    <small class="text-muted">XYZ Limited</small>
                                    <div class="mt-2">Progress</div>
                                    <div class="progress mt-1" style="height: 8px;">
                                        <div class="progress-bar bg-dark" role="progressbar" style="width: 45%;"></div>
                                    </div>
                                    <small class="text-muted">Due: 2025-06-10</small>
                                </div>
                                <div class="text-end">
                                    <span class="badge rounded-pill bg-danger mb-1">DELAYED</span><br>
                                    <span class="badge rounded-pill bg-danger">HIGH PRIORITY</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-lg-6">
                    <div class="card p-3 mb-4" style="height: 310px; border: 1px solid #e5e7eb;">
                        <h5 class="fw-bold mb-3">Document Completion Progress</h5>

                        <div class="mb-2">
                            <div class="d-flex justify-content-between small fw-semibold">
                                <span>Tax Audit - ABC Corp</span><span>42/50 docs</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-dark" role="progressbar" style="width: 84%;"></div>
                            </div>
                        </div>

                        <div class="mb-2">
                            <div class="d-flex justify-content-between small fw-semibold">
                                <span>GST Compliance - XYZ Ltd</span><span>18/30 docs</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-dark" role="progressbar" style="width: 60%;"></div>
                            </div>
                        </div>

                        <div class="mb-2">
                            <div class="d-flex justify-content-between small fw-semibold">
                                <span>Financial Review - DEF Co</span><span>25/25 docs</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-dark" role="progressbar" style="width: 100%;"></div>
                            </div>
                        </div>

                        <div class="mb-2">
                            <div class="d-flex justify-content-between small fw-semibold">
                                <span>Statutory Audit - GHI Inc</span><span>15/40 docs</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-dark" role="progressbar" style="width: 37%;"></div>
                            </div>
                        </div>

                        <div class="mb-2">
                            <div class="d-flex justify-content-between small fw-semibold">
                                <span>Compliance Review - JKL Co</span><span>28/35 docs</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-dark" role="progressbar" style="width: 80%;"></div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-12 col-lg-6">
                    <div class="card mb-4" style="height: 310px;">
                        <div class="card-header" style="    background-color: #5ab5ee59;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="fs-17 font-weight-600 mb-0"><i style="font-size: 20px;padding:10px;"
                                            class="typcn typcn-ticket"></i>Support Ticket</h6>
                                </div>

                            </div>
                        </div>
                        <div class="list-group list-group-flush">
                            <ul class="list-unstyled">
                                @if (count($assetticket) > 0)
                                    @foreach ($assetticket as $assetticketData)
                                        <li class="list-group-item list-group-item-action">
                                            <a href="{{ url('/ticket/' . $assetticketData->id) }}">
                                                <span
                                                    class="text-muted text-sm">#{{ $assetticketData->generateticket_id }}
                                                    - -
                                                    {{ $assetticketData->subject }}</span>
                                                <h5><a href="{{ url('/ticket/' . $assetticketData->id) }}"
                                                        class="d-block fs-15 font-weight-600 text-sm mb-0"><span
                                                            style="color:#007bff;font-size: small;">created by</span>
                                                        {{ $assetticketData->team_member }} <span
                                                            class="badge badge-info">
                                                            @if ($assetticketData->status == 0)
                                                                <span>open</span>
                                                            @elseif($assetticketData->status == 1)
                                                                <span>working</span>
                                                            @elseif($assetticketData->status == 2)
                                                                <span>close</span>
                                                            @else
                                                                <span>reject</span>
                                                            @endif
                                                        </span></a></h5>
                                                <small class="text-muted"><i class="far fa-clock mr-1"></i>
                                                    {{ date('H:i A', strtotime($assetticketData->created_at)) }},
                                                    {{ date('F jS', strtotime($assetticketData->created_at)) }}</small>
                                            </a>
                                        </li>
                                    @endforeach
                                    <div class="dropdown-footer" style="margin-top: -10px;"><a
                                            href="{{ url('ticketsupport') }}">View All Ticket</a></div>
                                @else
                                    <li class="list-group-item list-group-item-action">
                                        <br><br><br>
                                        <h5 style="text-align: center"><span>No Data</span></h5>
                                        <br><br><br> <br>
                                    </li>
                                @endif
                            </ul>
                        </div>

                    </div>

                </div>

                <div class="col-md-12 col-lg-6">
                    <div class="card mb-4" style="height: 310px;">
                        <div class="card-header" style="background-color:#ff000029;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="fs-17 font-weight-600 mb-0"> <i style="font-size: 20px;padding:10px;"
                                            class="typcn typcn-bell"></i>Notification</h6>
                                </div>

                            </div>
                        </div>
                        <div class="notification-list">
                            @if (count($notificationDatas) > 0)
                                @foreach ($notificationDatas as $notificationData)
                                    <div class="card-body" style="height: 86px;">
                                        <div class="media new">

                                            <div class="media-body">
                                                <h6> {{ $notificationData->title }} <a
                                                        class="d-block fs-15 font-weight-600 text-sm mb-0"><span
                                                            style="color:#007bff;font-size: small;">created by <b
                                                                style="color: black;">{{ $notificationData->team_member }}</b></span>
                                                    </a></h6>
                                                <span> <small class="text-muted"><i class="far fa-clock mr-1"></i>
                                                        {{ date('H:i A', strtotime($notificationData->created_at)) }},
                                                        {{ date('F jS', strtotime($notificationData->created_at)) }}</small></span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="dropdown-footer" style="    margin-top: 22px"><a
                                        href="{{ url('notification') }}">View All Notifications</a></div>
                            @else
                                <li class="list-group-item list-group-item-action">
                                    <br><br><br>
                                    <h5 style="text-align: center"><span>No Data</span></h5>
                                    <br><br><br> <br>
                                </li>
                            @endif
                        </div>

                        <br>
                    </div>

                </div>
            </div>
        </div> --}}

        {{-- <div class="body-content">
            <div class="row">
                <style>
                    .badge {
                        font-size: 12px;
                        padding: 4px 10px;
                    }
                </style>
                <!-- Assignment Status Overview -->
                <div class="col-md-12 col-lg-6">
                    <div class="card p-4 shadow-sm mb-4">
                        <h5 class="fw-bold mb-3">Assignment Status Overview</h5>

                        <!-- Assignment 1 -->
                        <div class="p-3 mb-3 rounded" style="background-color: #f8f9fa;">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <div class="fw-semibold">Tax Audit - ABC Corp</div>
                                    <div class="text-muted small mb-2">ABC Corporation</div>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar bg-dark" style="width: 85%;"></div>
                                    </div>
                                    <small class="text-muted">Due: 2025-06-15</small>
                                </div>
                                <div class="text-end">
                                    <span class="badge rounded-pill bg-primary mb-1">ON TRACK</span><br>
                                    <span class="badge rounded-pill bg-danger">HIGH PRIORITY</span>
                                </div>
                            </div>
                        </div>

                        <!-- Assignment 2 -->
                        <div class="p-3 rounded" style="background-color: #fff5f5;">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <div class="fw-semibold">GST Compliance - XYZ Ltd</div>
                                    <div class="text-muted small mb-2">XYZ Limited</div>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar bg-dark" style="width: 45%;"></div>
                                    </div>
                                    <small class="text-muted">Due: 2025-06-10</small>
                                </div>
                                <div class="text-end">
                                    <span class="badge rounded-pill bg-danger mb-1">DELAYED</span><br>
                                    <span class="badge rounded-pill bg-danger">HIGH PRIORITY</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Document Completion Progress -->
                <div class="col-md-12 col-lg-6">
                    <div class="card p-4 shadow-sm mb-4">
                        <h5 class="fw-bold mb-3">Document Completion Progress</h5>

                        <!-- Item -->
                        <div class="mb-3">
                            <div class="d-flex justify-content-between small fw-semibold">
                                <span>Tax Audit - ABC Corp</span><span>42/50 docs</span>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-dark" style="width: 84%;"></div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between small fw-semibold">
                                <span>GST Compliance - XYZ Ltd</span><span>18/30 docs</span>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-dark" style="width: 60%;"></div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between small fw-semibold">
                                <span>Financial Review - DEF Co</span><span>25/25 docs</span>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-dark" style="width: 100%;"></div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between small fw-semibold">
                                <span>Statutory Audit - GHI Inc</span><span>15/40 docs</span>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-dark" style="width: 37%;"></div>
                            </div>
                        </div>

                        <div class="mb-1">
                            <div class="d-flex justify-content-between small fw-semibold">
                                <span>Compliance Review - JKL Co</span><span>28/35 docs</span>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-dark" style="width: 80%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

        {{-- <div class="body-content">
            <div class="row">
                <div class="col-md-12 col-lg-6">
                    <div class="card mb-4" style="height: 310px;">
                        <div class="card-header" style="background-color: #5ab5ee59;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="fs-17 font-weight-600 mb-0"><i style="font-size: 20px;padding:10px;"
                                            class="typcn typcn-ticket"></i>Assignment Status Overview</h6>
                                </div>
                            </div>
                        </div>
                        <div class="list-group list-group-flush">
                            <ul class="list-unstyled">
                                <li class="list-group-item list-group-item-action">
                                    <span class="badge badge-success">ON TRACK</span> <span
                                        class="badge badge-danger">HIGH
                                        PRIORITY</span>
                                    <h5>Tax Audit - ABC Corp</h5>
                                    <p>ABC Corporation</p>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: 85%;"
                                            aria-valuenow="85" aria-valuemin="0" aria-valuemax="100">85%</div>
                                    </div>
                                    <small class="text-muted">Due: 2025-06-15</small>
                                </li>
                                <li class="list-group-item list-group-item-action">
                                    <span class="badge badge-danger">DELAYED</span> <span class="badge badge-danger">HIGH
                                        PRIORITY</span>
                                    <h5>GST Compliance - XYZ Ltd</h5>
                                    <p>XYZ Limited</p>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: 45%;"
                                            aria-valuenow="45" aria-valuemin="0" aria-valuemax="100">45%</div>
                                    </div>
                                    <small class="text-muted">Due: 2025-06-10</small>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6">
                    <div class="card mb-4" style="height: 310px;">
                        <div class="card-header" style="background-color: #ff000029;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="fs-17 font-weight-600 mb-0"><i style="font-size: 20px;padding:10px;"
                                            class="typcn typcn-bell"></i>Document Completion Progress</h6>
                                </div>
                            </div>
                        </div>
                        <div class="list-group list-group-flush">
                            <ul class="list-unstyled">
                                <li class="list-group-item list-group-item-action">
                                    <h5>Tax Audit - ABC Corp</h5>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: 84%;"
                                            aria-valuenow="84" aria-valuemin="0" aria-valuemax="100">42/50 docs</div>
                                    </div>
                                    <small class="text-muted">84%</small>
                                </li>
                                <li class="list-group-item list-group-item-action">
                                    <h5>GST Compliance - XYZ Ltd</h5>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: 60%;"
                                            aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">18/30 docs</div>
                                    </div>
                                    <small class="text-muted">60%</small>
                                </li>
                                <li class="list-group-item list-group-item-action">
                                    <h5>Financial Review - DEF Co</h5>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: 100%;"
                                            aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">25/25 docs</div>
                                    </div>
                                    <small class="text-muted">100%</small>
                                </li>
                                <li class="list-group-item list-group-item-action">
                                    <h5>Statutory Audit - GHI Inc</h5>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: 37%;"
                                            aria-valuenow="37" aria-valuemin="0" aria-valuemax="100">15/40 docs</div>
                                    </div>
                                    <small class="text-muted">37%</small>
                                </li>
                                <li class="list-group-item list-group-item-action">
                                    <h5>Compliance Review - JKL Co</h5>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: 80%;"
                                            aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">28/35 docs</div>
                                    </div>
                                    <small class="text-muted">80%</small>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

        <div class="dashboard-card-content">
            <div class="card">
                <div class="card-header">
                    <h2>Assignment Status Overview</h2>
                </div>

                <div class="assignment-card">
                    <div class="assignment-header">
                        <div class="assignment-title">
                            <h3>Tax Audit - ABC Corp</h3>
                            <p>ABC Corporation</p>
                        </div>
                        <div class="assignment-status">
                            <span class="priority-tag on-track">ON TRACK</span>
                            <span class="priority-tag high-priority">HIGH PRIORITY</span>
                        </div>
                    </div>
                    <div class="progress-container">
                        <div class="progress-info">
                            <span>Progress</span>
                            <span>85%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill progress-85"></div>
                        </div>
                        <div class="text-muted small" style="margin-top: 8px; font-size: 12px;">Due: 2025-06-15</div>
                    </div>
                </div>

                <div class="assignment-card">
                    <div class="assignment-header">
                        <div class="assignment-title">
                            <h3>GST Compliance - XYZ Ltd</h3>
                            <p>XYZ Limited</p>
                        </div>
                        <div class="assignment-status">
                            <span class="priority-tag delayed">DELAYED</span>
                            <span class="priority-tag high-priority">HIGH PRIORITY</span>
                        </div>
                    </div>
                    <div class="progress-container">
                        <div class="progress-info">
                            <span>Progress</span>
                            <span>45%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill progress-45"></div>
                        </div>
                        <div class="text-muted small" style="margin-top: 8px; font-size: 12px;">Due: 2025-06-15</div>
                    </div>
                </div>
                <div class="assignment-card">
                    <div class="assignment-header">
                        <div class="assignment-title">
                            <h3>GST Compliance - XYZ Ltd</h3>
                            <p>XYZ Limited</p>
                        </div>
                        <div class="assignment-status">
                            <span class="priority-tag delayed">DELAYED</span>
                            <span class="priority-tag high-priority">HIGH PRIORITY</span>
                        </div>
                    </div>
                    <div class="progress-container">
                        <div class="progress-info">
                            <span>Progress</span>
                            <span>45%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill progress-60"></div>
                        </div>
                        <div class="text-muted small" style="margin-top: 8px; font-size: 12px;">Due: 2025-06-15</div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h2>Document Completion Progress</h2>
                </div>

                <div class="document-card">
                    <h3 class="document-title">Tax Audit - ABC Corp</h3>
                    <div class="document-info">
                        <span>42/50 docs</span>
                        <span class="progress-value">84%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill progress-document-84"></div>
                    </div>
                </div>

                <div class="document-card">
                    <h3 class="document-title">GST Compliance - XYZ Ltd</h3>
                    <div class="document-info">
                        <span>18/30 docs</span>
                        <span class="progress-value">100%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill progress-document-100"></div>
                    </div>
                </div>

                <div class="document-card">
                    <h3 class="document-title">Financial Review - DEF Co</h3>
                    <div class="document-info">
                        <span>25/25 docs</span>
                        <span class="progress-value">84%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill progress-document-84"></div>
                    </div>
                </div>

                <div class="document-card">
                    <h3 class="document-title">Statutory Audit - GHI Inc</h3>
                    <div class="document-info">
                        <span>15/40 docs</span>
                        <span class="progress-value">45%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill progress-document-45"></div>
                    </div>
                </div>

                <div class="document-card">
                    <h3 class="document-title">Compliance Review - JKL Co</h3>
                    <div class="document-info">
                        <span>28/35 docs</span>
                        <span class="progress-value">100%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill progress-document-100"></div>
                    </div>
                </div>

                <div class="document-card">
                    <h3 class="document-title">Compliance Review - JKL Co</h3>
                    <div class="document-info">
                        <span>28/35 docs</span>
                        <span class="progress-value">100%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill progress-document-100"></div>
                    </div>
                </div>
                {{-- <div class="document-progress">
                    <div class="document-card">
                        <h4 class="document-title">Tax Audit - ABC Corp</h4>
                        <div class="document-info">
                            <span>42/50 docs</span>
                            <span class="progress-value">84%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill progress-84"></div>
                        </div>
                    </div>

                    <div class="document-card">
                        <h4 class="document-title">GST Compliance - XYZ Ltd</h4>
                        <div class="document-info">
                            <span>18/30 docs</span>
                            <span class="progress-value">60%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill progress-60"></div>
                        </div>
                    </div>

                    <div class="document-card">
                        <h4 class="document-title">Financial Review - DEF Co</h4>
                        <div class="document-info">
                            <span>25/25 docs</span>
                            <span class="progress-value">100%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill progress-100"></div>
                        </div>
                    </div>

                    <div class="document-card">
                        <h4 class="document-title">Statutory Audit - GHI Inc</h4>
                        <div class="document-info">
                            <span>15/40 docs</span>
                            <span class="progress-value">37%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill progress-37"></div>
                        </div>
                    </div>

                    <div class="document-card">
                        <h4 class="document-title">Compliance Review - JKL Co</h4>
                        <div class="document-info">
                            <span>28/35 docs</span>
                            <span class="progress-value">80%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill progress-80"></div>
                        </div>
                    </div>
                </div> --}}
            </div>

            <div class="card">
                <div class="card-header">
                    <h2>Monthly Expense Analysis</h2>
                </div>

                <div class="document-card">
                    <h3 class="document-title">Tax Audit - ABC Corp</h3>
                    <div class="document-info">
                        <span>42/50 docs</span>
                        <span class="progress-value">84%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill progress-document-84"></div>
                    </div>
                </div>

                <div class="document-card">
                    <h3 class="document-title">GST Compliance - XYZ Ltd</h3>
                    <div class="document-info">
                        <span>18/30 docs</span>
                        <span class="progress-value">100%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill progress-document-100"></div>
                    </div>
                </div>

                <div class="document-card">
                    <h3 class="document-title">Financial Review - DEF Co</h3>
                    <div class="document-info">
                        <span>25/25 docs</span>
                        <span class="progress-value">84%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill progress-document-84"></div>
                    </div>
                </div>

                <div class="document-card">
                    <h3 class="document-title">Statutory Audit - GHI Inc</h3>
                    <div class="document-info">
                        <span>15/40 docs</span>
                        <span class="progress-value">45%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill progress-document-45"></div>
                    </div>
                </div>

                <div class="document-card">
                    <h3 class="document-title">Compliance Review - JKL Co</h3>
                    <div class="document-info">
                        <span>28/35 docs</span>
                        <span class="progress-value">100%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill progress-document-100"></div>
                    </div>
                </div>

                <div class="document-card">
                    <h3 class="document-title">Compliance Review - JKL Co</h3>
                    <div class="document-info">
                        <span>28/35 docs</span>
                        <span class="progress-value">100%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill progress-document-100"></div>
                    </div>
                </div>

            </div>

            <div class="card">
                <div class="card-header">
                    <h2>ECQR Audits & Quality Reviews</h2>
                </div>

                <div class="ecqr-card">
                    <div class="ecqr-header" style=" margin: 0;">
                        <div class="ecqr-title">
                            <h3>ECQR Audit</h3>
                            <p style=" margin: 0;">ABC Corporation</p>
                            <p style=" margin: 0;">Assigned to: CA Sharma</p>
                        </div>
                        <div class="ecqr-status">
                            <span class="priority-tag on-track">PENDING</span>
                            <span class="text-muted small" style="margin-top: 8px; font-size: 12px;">Due:
                                2025-06-05</span>
                        </div>
                    </div>
                </div>
                <div class="ecqr-card">
                    <div class="ecqr-header" style=" margin: 0;">
                        <div class="ecqr-title">
                            <h3>Quality Review</h3>
                            <p style=" margin: 0;">ABC Corporation</p>
                            <p style=" margin: 0;">Assigned to: CA Sharma</p>
                        </div>
                        <div class="ecqr-status">
                            <span class="priority-tag on-track">PENDING</span>
                            <span class="text-muted small" style="margin-top: 8px; font-size: 12px;">Due:
                                2025-06-05</span>
                        </div>
                    </div>
                </div>
                <div class="ecqr-card">
                    <div class="ecqr-header" style=" margin: 0;">
                        <div class="ecqr-title">
                            <h3>ECQR Audit</h3>
                            <p style=" margin: 0;">ABC Corporation</p>
                            <p style=" margin: 0;">Assigned to: CA Sharma</p>
                        </div>
                        <div class="ecqr-status">
                            <span class="priority-tag on-track">PENDING</span>
                            <span class="text-muted small" style="margin-top: 8px; font-size: 12px;">Due:
                                2025-06-05</span>
                        </div>
                    </div>
                </div>
                <div class="ecqr-card">
                    <div class="ecqr-header" style=" margin: 0;">
                        <div class="ecqr-title">
                            <h3>Quality Review</h3>
                            <p style=" margin: 0;">ABC Corporation</p>
                            <p style=" margin: 0;">Assigned to: CA Sharma</p>
                        </div>
                        <div class="ecqr-status">
                            <span class="priority-tag on-track">PENDING</span>
                            <span class="text-muted small" style="margin-top: 8px; font-size: 12px;">Due:
                                2025-06-05</span>
                        </div>
                    </div>
                </div>
                <div class="ecqr-card">
                    <div class="ecqr-header" style=" margin: 0;">
                        <div class="ecqr-title">
                            <h3>ECQR Audit</h3>
                            <p style=" margin: 0;">ABC Corporation</p>
                            <p style=" margin: 0;">Assigned to: CA Sharma</p>
                        </div>
                        <div class="ecqr-status">
                            <span class="priority-tag on-track">PENDING</span>
                            <span class="text-muted small" style="margin-top: 8px; font-size: 12px;">Due:
                                2025-06-05</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h2>Cash Flow Analysis</h2>
                </div>

                <div class="document-card">
                    <h3 class="document-title">Tax Audit - ABC Corp</h3>
                    <div class="document-info">
                        <span>42/50 docs</span>
                        <span class="progress-value">84%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill progress-document-84"></div>
                    </div>
                </div>

                <div class="document-card">
                    <h3 class="document-title">GST Compliance - XYZ Ltd</h3>
                    <div class="document-info">
                        <span>18/30 docs</span>
                        <span class="progress-value">100%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill progress-document-100"></div>
                    </div>
                </div>

                <div class="document-card">
                    <h3 class="document-title">Financial Review - DEF Co</h3>
                    <div class="document-info">
                        <span>25/25 docs</span>
                        <span class="progress-value">84%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill progress-document-84"></div>
                    </div>
                </div>

                <div class="document-card">
                    <h3 class="document-title">Statutory Audit - GHI Inc</h3>
                    <div class="document-info">
                        <span>15/40 docs</span>
                        <span class="progress-value">45%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill progress-document-45"></div>
                    </div>
                </div>

                <div class="document-card">
                    <h3 class="document-title">Compliance Review - JKL Co</h3>
                    <div class="document-info">
                        <span>28/35 docs</span>
                        <span class="progress-value">100%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill progress-document-100"></div>
                    </div>
                </div>

                <div class="document-card">
                    <h3 class="document-title">Compliance Review - JKL Co</h3>
                    <div class="document-info">
                        <span>28/35 docs</span>
                        <span class="progress-value">100%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill progress-document-100"></div>
                    </div>
                </div>

            </div>

            <div class="card">
                <div class="card-header">
                    <h2>Partner-wise P&L Statement</h2>
                </div>

                <div class="table-responsive">
                    <table class="table  table-hover">
                        <thead>
                            <tr>
                                <th style="padding: 17px;">Partner</th>
                                <th style="padding: 17px;">Revenue</th>
                                <th style="padding: 17px;">Expenses</th>
                                <th style="padding: 17px;">Profit</th>
                                <th style="padding: 17px;" class="textfixed">Margin %</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="textfixed" style="padding: 17px;">Partner A</td>
                                <td style="padding: 17px;">₹1,250,000</td>
                                <td style="padding: 17px;">₹980,000</td>
                                <td style="padding: 17px;" class="text-success">₹270,000</td>
                                <td style="padding: 17px;" class="text-success">21.6%</td>
                            </tr>
                            <tr>
                                <td class="textfixed" style="padding: 17px;">Partner A</td>
                                <td style="padding: 17px;">₹1,250,000</td>
                                <td style="padding: 17px;">₹980,000</td>
                                <td style="padding: 17px;" class="text-success">₹270,000</td>
                                <td style="padding: 17px;" class="text-success">21.6%</td>
                            </tr>
                            <tr>
                                <td class="textfixed" style="padding: 17px;">Partner A</td>
                                <td style="padding: 17px;">₹1,250,000</td>
                                <td style="padding: 17px;">₹980,000</td>
                                <td style="padding: 17px;" class="text-success">₹270,000</td>
                                <td style="padding: 17px;" class="text-success">21.6%</td>
                            </tr>
                            <tr>
                                <td class="textfixed" style="padding: 17px;">Partner A</td>
                                <td style="padding: 17px;">₹1,250,000</td>
                                <td style="padding: 17px;">₹980,000</td>
                                <td style="padding: 17px;" class="text-success">₹270,000</td>
                                <td style="padding: 17px;" class="text-success">21.6%</td>
                            </tr>
                            <tr>
                                <td class="textfixed" style="padding: 17px;">Partner A</td>
                                <td style="padding: 17px;">₹1,250,000</td>
                                <td style="padding: 17px;">₹980,000</td>
                                <td style="padding: 17px;" class="text-success">₹270,000</td>
                                <td style="padding: 17px;" class="text-success">21.6%</td>
                            </tr>
                            <tr>
                                <td class="textfixed" style="padding: 17px;">Partner A</td>
                                <td style="padding: 17px;">₹1,250,000</td>
                                <td style="padding: 17px;">₹980,000</td>
                                <td style="padding: 17px;" class="text-success">₹270,000</td>
                                <td style="padding: 17px;" class="text-success">21.6%</td>
                            </tr>
                            <tr>
                                <td class="textfixed" style="padding: 17px;">Partner A</td>
                                <td style="padding: 17px;">₹1,250,000</td>
                                <td style="padding: 17px;">₹980,000</td>
                                <td style="padding: 17px;" class="text-success">₹270,000</td>
                                <td style="padding: 17px;" class="text-success">21.6%</td>
                            </tr>
                            <tr>
                                <td class="textfixed" style="padding: 17px;">Partner A</td>
                                <td style="padding: 17px;">₹1,250,000</td>
                                <td style="padding: 17px;">₹980,000</td>
                                <td style="padding: 17px;" class="text-success">₹270,000</td>
                                <td style="padding: 17px;" class="text-success">21.6%</td>
                            </tr>
                            <tr>
                                <td class="textfixed" style="padding: 17px;">Partner A</td>
                                <td style="padding: 17px;">₹1,250,000</td>
                                <td style="padding: 17px;">₹980,000</td>
                                <td style="padding: 17px;" class="text-success">₹270,000</td>
                                <td style="padding: 17px;" class="text-success">21.6%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h2>Assignment-wise P&L Analysis</h2>
                </div>

                <div class="table-responsive">
                    <table class="table  table-hover">
                        <thead>
                            <tr>
                                <th style="padding: 17px;">Assignment</th>
                                <th style="padding: 17px;">Client</th>
                                <th style="padding: 17px;">Revenue</th>
                                <th style="padding: 17px;">Costs</th>
                                <th style="padding: 17px;">Profit</th>
                                <th style="padding: 17px;" class="textfixed">Margin %</th>
                                <th style="padding: 17px;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="padding: 17px;">Tax Audit - ABC Corp</td>
                                <td style="padding: 17px;">ABC Corporation</td>
                                <td style="padding: 17px;">₹350,000</td>
                                <td style="padding: 17px;">₹280,000</td>
                                <td style="padding: 17px;" class="text-success">₹270,000</td>
                                <td style="padding: 17px;" class="text-success">21.6%</td>
                                <td style="padding: 17px;"><span class="priority-tag on-track">PROFITABLE</span></td>
                            </tr>
                            <tr>
                                <td style="padding: 17px;">Tax Audit - ABC Corp</td>
                                <td style="padding: 17px;">ABC Corporation</td>
                                <td style="padding: 17px;">₹350,000</td>
                                <td style="padding: 17px;">₹280,000</td>
                                <td style="padding: 17px;" class="text-success">₹270,000</td>
                                <td style="padding: 17px;" class="text-success">21.6%</td>
                                <td style="padding: 17px;"><span class="priority-tag on-track">PROFITABLE</span></td>
                            </tr>
                            <tr>
                                <td style="padding: 17px;">Tax Audit - ABC Corp</td>
                                <td style="padding: 17px;">ABC Corporation</td>
                                <td style="padding: 17px;">₹350,000</td>
                                <td style="padding: 17px;">₹280,000</td>
                                <td style="padding: 17px;" class="text-success">₹270,000</td>
                                <td style="padding: 17px;" class="text-success">21.6%</td>
                                <td style="padding: 17px;"><span class="priority-tag on-track">PROFITABLE</span></td>
                            </tr>
                            <tr>
                                <td style="padding: 17px;">Tax Audit - ABC Corp</td>
                                <td style="padding: 17px;">ABC Corporation</td>
                                <td style="padding: 17px;">₹350,000</td>
                                <td style="padding: 17px;">₹280,000</td>
                                <td style="padding: 17px;" class="text-success">₹270,000</td>
                                <td style="padding: 17px;" class="text-success">21.6%</td>
                                <td style="padding: 17px;"><span class="priority-tag on-track">PROFITABLE</span></td>
                            </tr>
                            <tr>
                                <td style="padding: 17px;">Tax Audit - ABC Corp</td>
                                <td style="padding: 17px;">ABC Corporation</td>
                                <td style="padding: 17px;">₹350,000</td>
                                <td style="padding: 17px;">₹280,000</td>
                                <td style="padding: 17px;" class="text-success">₹270,000</td>
                                <td style="padding: 17px;" class="text-success">21.6%</td>
                                <td style="padding: 17px;"><span class="priority-tag on-track">PROFITABLE</span></td>
                            </tr>
                            <tr>
                                <td style="padding: 17px;">Tax Audit - ABC Corp</td>
                                <td style="padding: 17px;">ABC Corporation</td>
                                <td style="padding: 17px;">₹350,000</td>
                                <td style="padding: 17px;">₹280,000</td>
                                <td style="padding: 17px;" class="text-success">₹270,000</td>
                                <td style="padding: 17px;" class="text-success">21.6%</td>
                                <td style="padding: 17px;"><span class="priority-tag on-track">PROFITABLE</span></td>
                            </tr>
                            <tr>
                                <td style="padding: 17px;">Tax Audit - ABC Corp</td>
                                <td style="padding: 17px;">ABC Corporation</td>
                                <td style="padding: 17px;">₹350,000</td>
                                <td style="padding: 17px;">₹280,000</td>
                                <td style="padding: 17px;" class="text-success">₹270,000</td>
                                <td style="padding: 17px;" class="text-success">21.6%</td>
                                <td style="padding: 17px;"><span class="priority-tag on-track">PROFITABLE</span></td>
                            </tr>
                            <tr>
                                <td style="padding: 17px;">Tax Audit - ABC Corp</td>
                                <td style="padding: 17px;">ABC Corporation</td>
                                <td style="padding: 17px;">₹350,000</td>
                                <td style="padding: 17px;">₹280,000</td>
                                <td style="padding: 17px;" class="text-success">₹270,000</td>
                                <td style="padding: 17px;" class="text-success">21.6%</td>
                                <td style="padding: 17px;"><span class="priority-tag on-track">PROFITABLE</span></td>
                            </tr>
                            <tr>
                                <td style="padding: 17px;">Tax Audit - ABC Corp</td>
                                <td style="padding: 17px;">ABC Corporation</td>
                                <td style="padding: 17px;">₹350,000</td>
                                <td style="padding: 17px;">₹280,000</td>
                                <td style="padding: 17px;" class="text-success">₹270,000</td>
                                <td style="padding: 17px;" class="text-success">21.6%</td>
                                <td style="padding: 17px;"><span class="priority-tag on-track">PROFITABLE</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>


            <div class="card">
                <div class="card-header">
                    <h2>Documentation Status Overview</h2>
                </div>

                <div class="assignment-card">
                    <div class="assignment-header">
                        <div class="assignment-title">
                            <h3>Tax Documentation</h3>
                        </div>
                        <div class="assignment-status">
                            <span class="priority-tag on-track">ON TRACK</span>
                        </div>
                    </div>
                    <div class="progress-container">
                        <div class="progress-info">
                            <span>Completed: 128</span>
                            <span>Pending Review: 15</span>
                            <span>Approved: 113</span>
                        </div>
                        <div class="progress-info">
                            <span>Progress</span>
                            <span>45%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill progress-document-84"></div>
                        </div>
                        <div class="text-muted small" style="margin-top: 8px; font-size: 12px;">128/150 documents
                            completed</div>
                    </div>
                </div>
                <div class="assignment-card">
                    <div class="assignment-header">
                        <div class="assignment-title">
                            <h3>Tax Documentation</h3>
                        </div>
                        <div class="assignment-status">
                            <span class="priority-tag on-track">ON TRACK</span>
                        </div>
                    </div>
                    <div class="progress-container">
                        <div class="progress-info">
                            <span>Completed: 128</span>
                            <span>Pending Review: 15</span>
                            <span>Approved: 113</span>
                        </div>
                        <div class="progress-info">
                            <span>Progress</span>
                            <span>45%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill progress-document-84"></div>
                        </div>
                        <div class="text-muted small" style="margin-top: 8px; font-size: 12px;">128/150 documents
                            completed</div>
                    </div>
                </div>
                <div class="assignment-card">
                    <div class="assignment-header">
                        <div class="assignment-title">
                            <h3>Tax Documentation</h3>
                        </div>
                        <div class="assignment-status">
                            <span class="priority-tag on-track">ON TRACK</span>
                        </div>
                    </div>
                    <div class="progress-container">
                        <div class="progress-info">
                            <span>Completed: 128</span>
                            <span>Pending Review: 15</span>
                            <span>Approved: 113</span>
                        </div>
                        <div class="progress-info">
                            <span>Progress</span>
                            <span>45%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill progress-document-84"></div>
                        </div>
                        <div class="text-muted small" style="margin-top: 8px; font-size: 12px;">128/150 documents
                            completed</div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h2>Budget vs Actual Cash Flow</h2>
                </div>

                <div class="document-card">
                    <h3 class="document-title">Tax Audit - ABC Corp</h3>
                    <div class="document-info">
                        <span>42/50 docs</span>
                        <span class="progress-value">84%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill progress-document-84"></div>
                    </div>
                </div>

                <div class="document-card">
                    <h3 class="document-title">GST Compliance - XYZ Ltd</h3>
                    <div class="document-info">
                        <span>18/30 docs</span>
                        <span class="progress-value">100%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill progress-document-100"></div>
                    </div>
                </div>

                <div class="document-card">
                    <h3 class="document-title">Financial Review - DEF Co</h3>
                    <div class="document-info">
                        <span>25/25 docs</span>
                        <span class="progress-value">84%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill progress-document-84"></div>
                    </div>
                </div>

                <div class="document-card">
                    <h3 class="document-title">Statutory Audit - GHI Inc</h3>
                    <div class="document-info">
                        <span>15/40 docs</span>
                        <span class="progress-value">45%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill progress-document-45"></div>
                    </div>
                </div>

                <div class="document-card">
                    <h3 class="document-title">Compliance Review - JKL Co</h3>
                    <div class="document-info">
                        <span>28/35 docs</span>
                        <span class="progress-value">100%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill progress-document-100"></div>
                    </div>
                </div>

                <div class="document-card">
                    <h3 class="document-title">Compliance Review - JKL Co</h3>
                    <div class="document-info">
                        <span>28/35 docs</span>
                        <span class="progress-value">100%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill progress-document-100"></div>
                    </div>
                </div>

            </div>
            <div class="card">
                <div class="card-header">
                    <h2>Budget vs Actual P&L</h2>
                </div>

                <div class="document-card">
                    <h3 class="document-title">Tax Audit - ABC Corp</h3>
                    <div class="document-info">
                        <span>42/50 docs</span>
                        <span class="progress-value">84%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill progress-document-84"></div>
                    </div>
                </div>

                <div class="document-card">
                    <h3 class="document-title">GST Compliance - XYZ Ltd</h3>
                    <div class="document-info">
                        <span>18/30 docs</span>
                        <span class="progress-value">100%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill progress-document-100"></div>
                    </div>
                </div>

                <div class="document-card">
                    <h3 class="document-title">Financial Review - DEF Co</h3>
                    <div class="document-info">
                        <span>25/25 docs</span>
                        <span class="progress-value">84%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill progress-document-84"></div>
                    </div>
                </div>

                <div class="document-card">
                    <h3 class="document-title">Statutory Audit - GHI Inc</h3>
                    <div class="document-info">
                        <span>15/40 docs</span>
                        <span class="progress-value">45%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill progress-document-45"></div>
                    </div>
                </div>

                <div class="document-card">
                    <h3 class="document-title">Compliance Review - JKL Co</h3>
                    <div class="document-info">
                        <span>28/35 docs</span>
                        <span class="progress-value">100%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill progress-document-100"></div>
                    </div>
                </div>

                <div class="document-card">
                    <h3 class="document-title">Compliance Review - JKL Co</h3>
                    <div class="document-info">
                        <span>28/35 docs</span>
                        <span class="progress-value">100%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill progress-document-100"></div>
                    </div>
                </div>

            </div>
            <div class="card">
                <div class="card-header">
                    <h2>Lap Days Analysis (Assignment to Invoice)</h2>
                </div>

                <div class="document-card">
                    <h3 class="document-title">Tax Audit - ABC Corp</h3>
                    <div class="document-info">
                        <span>42/50 docs</span>
                        <span class="progress-value">84%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill progress-document-84"></div>
                    </div>
                </div>

                <div class="document-card">
                    <h3 class="document-title">GST Compliance - XYZ Ltd</h3>
                    <div class="document-info">
                        <span>18/30 docs</span>
                        <span class="progress-value">100%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill progress-document-100"></div>
                    </div>
                </div>

                <div class="document-card">
                    <h3 class="document-title">Financial Review - DEF Co</h3>
                    <div class="document-info">
                        <span>25/25 docs</span>
                        <span class="progress-value">84%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill progress-document-84"></div>
                    </div>
                </div>

                <div class="document-card">
                    <h3 class="document-title">Statutory Audit - GHI Inc</h3>
                    <div class="document-info">
                        <span>15/40 docs</span>
                        <span class="progress-value">45%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill progress-document-45"></div>
                    </div>
                </div>

                <div class="document-card">
                    <h3 class="document-title">Compliance Review - JKL Co</h3>
                    <div class="document-info">
                        <span>28/35 docs</span>
                        <span class="progress-value">100%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill progress-document-100"></div>
                    </div>
                </div>

                <div class="document-card">
                    <h3 class="document-title">Compliance Review - JKL Co</h3>
                    <div class="document-info">
                        <span>28/35 docs</span>
                        <span class="progress-value">100%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill progress-document-100"></div>
                    </div>
                </div>

            </div>
            <div class="card">
                <div class="card-header">
                    <h2>Invoice Due vs Assignment Billing vs Cash Recovery</h2>
                </div>

                <div class="document-card">
                    <h3 class="document-title">Tax Audit - ABC Corp</h3>
                    <div class="document-info">
                        <span>42/50 docs</span>
                        <span class="progress-value">84%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill progress-document-84"></div>
                    </div>
                </div>

                <div class="document-card">
                    <h3 class="document-title">GST Compliance - XYZ Ltd</h3>
                    <div class="document-info">
                        <span>18/30 docs</span>
                        <span class="progress-value">100%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill progress-document-100"></div>
                    </div>
                </div>

                <div class="document-card">
                    <h3 class="document-title">Financial Review - DEF Co</h3>
                    <div class="document-info">
                        <span>25/25 docs</span>
                        <span class="progress-value">84%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill progress-document-84"></div>
                    </div>
                </div>

                <div class="document-card">
                    <h3 class="document-title">Statutory Audit - GHI Inc</h3>
                    <div class="document-info">
                        <span>15/40 docs</span>
                        <span class="progress-value">45%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill progress-document-45"></div>
                    </div>
                </div>

                <div class="document-card">
                    <h3 class="document-title">Compliance Review - JKL Co</h3>
                    <div class="document-info">
                        <span>28/35 docs</span>
                        <span class="progress-value">100%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill progress-document-100"></div>
                    </div>
                </div>

                <div class="document-card">
                    <h3 class="document-title">Compliance Review - JKL Co</h3>
                    <div class="document-info">
                        <span>28/35 docs</span>
                        <span class="progress-value">100%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill progress-document-100"></div>
                    </div>
                </div>

            </div>
        </div>

        <div class="dashboard-card-fullcontent">
            <div class="card">
                <div class="card-header">
                    <h2>Staff Allocation vs Actual Timesheet Analysis</h2>
                </div>

                <div class="document-card">
                    <h3 class="document-title">Tax Audit - ABC Corp</h3>
                    <div class="document-info">
                        <span>42/50 docs</span>
                        <span class="progress-value">84%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill progress-document-84"></div>
                    </div>
                </div>

                <div class="document-card">
                    <h3 class="document-title">GST Compliance - XYZ Ltd</h3>
                    <div class="document-info">
                        <span>18/30 docs</span>
                        <span class="progress-value">100%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill progress-document-100"></div>
                    </div>
                </div>

                <div class="document-card">
                    <h3 class="document-title">Financial Review - DEF Co</h3>
                    <div class="document-info">
                        <span>25/25 docs</span>
                        <span class="progress-value">84%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill progress-document-84"></div>
                    </div>
                </div>

                <div class="document-card">
                    <h3 class="document-title">Statutory Audit - GHI Inc</h3>
                    <div class="document-info">
                        <span>15/40 docs</span>
                        <span class="progress-value">45%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill progress-document-45"></div>
                    </div>
                </div>

                <div class="document-card">
                    <h3 class="document-title">Compliance Review - JKL Co</h3>
                    <div class="document-info">
                        <span>28/35 docs</span>
                        <span class="progress-value">100%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill progress-document-100"></div>
                    </div>
                </div>

                <div class="document-card">
                    <h3 class="document-title">Compliance Review - JKL Co</h3>
                    <div class="document-info">
                        <span>28/35 docs</span>
                        <span class="progress-value">100%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill progress-document-100"></div>
                    </div>
                </div>

            </div>

            <div class="card">
                <div class="card-header">
                    <h2>Unresolved Tickets - HR, IT & Admin</h2>
                </div>

                <div class="table-responsive">
                    <table class="table  table-hover">
                        <thead>
                            <tr>
                                <th class="textfixed" style="padding: 17px;">Ticket ID</th>
                                <th style="padding: 17px;">Department</th>
                                <th style="padding: 17px;">Subject</th>
                                <th style="padding: 17px;">Priority</th>
                                <th class="textfixed" style="padding: 17px;">Assigned To</th>
                                <th class="textfixed" style="padding: 17px;">Days Open</th>
                                <th style="padding: 17px;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="textfixed" style="padding: 17px;">HR-001</td>
                                <td style="padding: 17px;"><span class="priority-tag on-track">HR</span></td>
                                <td class="textfixed" style="padding: 17px;"> Employee Onboarding Issue</td>
                                <td style="padding: 17px;"><span class="priority-tag on-track">High</span></td>
                                <td class="textfixed" style="padding: 17px;">Priya Sharma</td>
                                <td style="padding: 17px;" class="text-success">5 days</td>
                                <td style="padding: 17px;"><span class="priority-tag on-track">In Progress</span></td>
                            </tr>
                            <tr>
                                <td class="textfixed" style="padding: 17px;">HR-001</td>
                                <td style="padding: 17px;"><span class="priority-tag on-track">HR</span></td>
                                <td class="textfixed" style="padding: 17px;"> Employee Onboarding Issue</td>
                                <td style="padding: 17px;"><span class="priority-tag on-track">High</span></td>
                                <td class="textfixed" style="padding: 17px;">Priya Sharma</td>
                                <td style="padding: 17px;" class="text-success">5 days</td>
                                <td style="padding: 17px;"><span class="priority-tag on-track">In Progress</span></td>
                            </tr>
                            <tr>
                                <td class="textfixed" style="padding: 17px;">HR-001</td>
                                <td style="padding: 17px;"><span class="priority-tag on-track">HR</span></td>
                                <td class="textfixed" style="padding: 17px;"> Employee Onboarding Issue</td>
                                <td style="padding: 17px;"><span class="priority-tag on-track">High</span></td>
                                <td class="textfixed" style="padding: 17px;">Priya Sharma</td>
                                <td style="padding: 17px;" class="text-success">5 days</td>
                                <td style="padding: 17px;"><span class="priority-tag on-track">In Progress</span></td>
                            </tr>
                            <tr>
                                <td class="textfixed" style="padding: 17px;">HR-001</td>
                                <td style="padding: 17px;"><span class="priority-tag on-track">HR</span></td>
                                <td class="textfixed" style="padding: 17px;"> Employee Onboarding Issue</td>
                                <td style="padding: 17px;"><span class="priority-tag on-track">High</span></td>
                                <td class="textfixed" style="padding: 17px;">Priya Sharma</td>
                                <td style="padding: 17px;" class="text-success">5 days</td>
                                <td style="padding: 17px;"><span class="priority-tag on-track">In Progress</span></td>
                            </tr>
                            <tr>
                                <td class="textfixed" style="padding: 17px;">HR-001</td>
                                <td style="padding: 17px;"><span class="priority-tag on-track">HR</span></td>
                                <td class="textfixed" style="padding: 17px;"> Employee Onboarding Issue</td>
                                <td style="padding: 17px;"><span class="priority-tag on-track">High</span></td>
                                <td class="textfixed" style="padding: 17px;">Priya Sharma</td>
                                <td style="padding: 17px;" class="text-success">5 days</td>
                                <td style="padding: 17px;"><span class="priority-tag on-track">In Progress</span></td>
                            </tr>
                            <tr>
                                <td class="textfixed" style="padding: 17px;">HR-001</td>
                                <td style="padding: 17px;"><span class="priority-tag on-track">HR</span></td>
                                <td class="textfixed" style="padding: 17px;"> Employee Onboarding Issue</td>
                                <td style="padding: 17px;"><span class="priority-tag on-track">High</span></td>
                                <td class="textfixed" style="padding: 17px;">Priya Sharma</td>
                                <td style="padding: 17px;" class="text-success">5 days</td>
                                <td style="padding: 17px;"><span class="priority-tag on-track">In Progress</span></td>
                            </tr>
                            <tr>
                                <td class="textfixed" style="padding: 17px;">HR-001</td>
                                <td style="padding: 17px;"><span class="priority-tag on-track">HR</span></td>
                                <td class="textfixed" style="padding: 17px;"> Employee Onboarding Issue</td>
                                <td style="padding: 17px;"><span class="priority-tag on-track">High</span></td>
                                <td class="textfixed" style="padding: 17px;">Priya Sharma</td>
                                <td style="padding: 17px;" class="text-success">5 days</td>
                                <td style="padding: 17px;"><span class="priority-tag on-track">In Progress</span></td>
                            </tr>
                            <tr>
                                <td class="textfixed" style="padding: 17px;">HR-001</td>
                                <td style="padding: 17px;"><span class="priority-tag on-track">HR</span></td>
                                <td class="textfixed" style="padding: 17px;"> Employee Onboarding Issue</td>
                                <td style="padding: 17px;"><span class="priority-tag on-track">High</span></td>
                                <td class="textfixed" style="padding: 17px;">Priya Sharma</td>
                                <td style="padding: 17px;" class="text-success">5 days</td>
                                <td style="padding: 17px;"><span class="priority-tag on-track">In Progress</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h2><i class="fa-solid fa-triangle-exclamation text-danger"></i> High Priority Tasks Pending</h2>
                </div>

                <div class="document-progress">

                    <div class="document-card" style="background-color: #f916161f;">
                        <div class="ecqr-header" style=" margin: 0;">
                            <div class="ecqr-title">
                                <h3>Tax Compliance - ABC Corp</h3>
                                <p style=" margin: 0; color: #eb1010">Due: Tomorrow</p>
                                <p style=" margin: 0;">Documents incomplete</p>
                            </div>
                        </div>
                    </div>

                    <div class="document-card" style="background-color: #f96d1624">
                        <div class="ecqr-header" style=" margin: 0;">
                            <div class="ecqr-title">
                                <h3>Tax Compliance - ABC Corp</h3>
                                <p style=" margin: 0; color: #f97316">Due: 3 days</p>
                                <p style=" margin: 0;">Documents incomplete</p>
                            </div>
                        </div>
                    </div>
                    <div class="document-card" style="background-color: #f9cb1629;">
                        <div class="ecqr-header" style=" margin: 0;">
                            <div class="ecqr-title">
                                <h3>Tax Compliance - ABC Corp</h3>
                                <p style=" margin: 0; color: #f9c016">Due: 5 days</p>
                                <p style=" margin: 0;">Documents incomplete</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <script>
            var msg = '{{ Session::get('alert') }}';
            var exist = '{{ Session::has('alert') }}';
            if (exist) {
                alert(msg);
            }
        </script>

        <script>
            document.querySelectorAll('.card').forEach(card => {
                card.addEventListener('mouseenter', () => {
                    card.style.boxShadow = '0 8px 25px rgba(0, 0, 0, 0.1)';
                });

                card.addEventListener('mouseleave', () => {
                    card.style.boxShadow = '0 5px 15px rgba(0, 0, 0, 0.05)';
                });
            });
        </script>
    @endsection
