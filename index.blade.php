@extends('backEnd.layouts.layout') @section('backEnd_content')
    <!--Content Header (Page header)-->
    <div class="content-header m-0">
        <div class="rounded p-4">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-3 mb-lg-0">
                    <h1 class="font-weight-bold mb-2" style="font-size: 24px; color: #111827;">
                        Welcome back, {{ Auth::user()->teammember->team_member ?? 'User' }}
                    </h1>
                    <p class="mb-0 text-muted" style="font-size: 15px;">
                        Here's what's happening with your organization today.
                    </p>
                </div>
                <div class="col-lg-6 text-lg-right">
                    @if (Auth::user()->role_id == 11 ||
                            Auth::user()->role_id == 13 ||
                            Auth::user()->role_id == 14 ||
                            Auth::user()->role_id == 18)
                        <nav aria-label="breadcrumb" class="mb-3">
                            <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 mb-0 p-0"
                                style="background-color: #c3c9d400;">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </nav>

                        <div class="d-flex flex-column flex-sm-row justify-content-lg-end">
                            @if (Auth::user()->role_id == 11 || Auth::user()->role_id == 13 || Auth::user()->role_id == 14)
                                <a href="{{ url('client/create') }}"
                                    class="btn btn-outline-primary font-weight-600 mb-2 mb-sm-0 mr-sm-2">
                                    + Add Client
                                </a>
                            @endif
                            @if (Auth::user()->role_id == 11 || Auth::user()->role_id == 18)
                                <a href="{{ url('teammember/create') }}"
                                    class="btn btn-outline-success font-weight-600 mb-2 mb-sm-0 mr-sm-2">
                                    + Add Team Member
                                </a>
                            @endif
                            @if (Auth::user()->role_id == 11 || Auth::user()->role_id == 13 || Auth::user()->role_id == 14)
                                <a href="{{ url('assignmentmapping/create') }}"
                                    class="btn btn-outline-info font-weight-600">
                                    + Create Assignment
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!--/.Content Header (Page header)-->
    <style>
        .dashboard-section-card {
            height: 310px;
            border: 1px solid #e6eaf0;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 6px 18px rgba(31, 41, 55, .06);
        }

        .dashboard-section-card .card-header {
            background: #ffffff;
            border-bottom: 1px solid #edf0f5;
            padding: 13px 16px;
        }

        .dashboard-section-title {
            display: flex;
            align-items: center;
            min-width: 0;
        }

        .dashboard-section-title h6 {
            color: #202938;
            line-height: 1.2;
        }

        .dashboard-section-icon {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            font-size: 17px;
            flex: 0 0 34px;
        }

        .dashboard-section-list {
            height: 235px;
            overflow-y: auto;
            background: #ffffff;
        }

        .dashboard-section-list.has-footer {
            height: 200px;
        }

        .dashboard-list-item {
            padding: 12px 16px;
            border-bottom: 1px solid #f0f2f5;
            transition: background-color .2s ease;
        }

        .dashboard-list-item:hover {
            background-color: #f8fafc;
        }

        .dashboard-list-item h6 {
            font-size: 14px;
            line-height: 1.35;
            color: #1f2937;
        }

        .dashboard-list-accent {
            border-left: 4px solid #3b82f6;
        }

        .dashboard-empty-state {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #8a94a6;
            text-align: center;
            padding: 20px;
        }

        .dashboard-empty-state i {
            display: block;
            font-size: 28px;
            margin-bottom: 8px;
            color: #c0c7d2;
        }

        .dashboard-footer-link {
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-top: 1px solid #edf0f5;
            background: #fbfcfe;
            font-size: 13px;
            font-weight: 600;
        }

        .dashboard-pill {
            border-radius: 20px;
            padding: 4px 12px;
            font-size: 12px;
            font-weight: 600;
        }

        .dashboard-mini-label {
            color: #64748b;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0;
        }

        .dashboard-person-item {
            display: flex;
            align-items: flex-start;
            padding: 10px 0;
            border-bottom: 1px solid #f0f2f5;
        }

        .dashboard-person-item:last-child {
            border-bottom: 0;
        }

        .dashboard-person-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            flex: 0 0 32px;
            font-size: 14px;
        }

        .kpi-card {
            border-radius: 7px;
            transition: transform 0.2s ease;
        }

        .kpi-card:hover {
            transform: translateY(-3px);
        }

        .assignment-card {
            background: linear-gradient(135deg, #EEF5FC 0%, #E0ECF9 50%, #D1E3F5 100%);
        }

        .clients-card {
            background: linear-gradient(135deg, #F4F0FC 0%, #EDE4F9 50%, #E3D7F5 100%);
        }

        .team-card {
            background: linear-gradient(135deg, #F0F9F4 0%, #E4F6EA 50%, #D6F0E0 100%);
        }

        .notification-card {
            background: linear-gradient(135deg, #FFF8F0 0%, #FFF0E0 50%, #FFE8D1 100%);
        }
    </style>
    @if (Auth::user()->role_id == 13 || Auth::user()->role_id == 14)
        <div class="body-content">
            <div class="row">
                <div class="col-md-6 col-lg-3">
                    <!--Active users indicator-->
                    <div class="p-3 kpi-card assignment-card text-center">
                        <a href="{{ url('assignmentmapping') }}" style="text-decoration: none;">
                            <div class="header-pretitle fs-11 font-weight-bold text-uppercase" style="color: #495057;">Team
                                Assignment
                            </div>
                            <div class="fs-32 text-monospace font-weight-bold" style="color: #1E3A8A;">
                                {{ $assignmentcount }}</div>
                            <small style="color: #6c757d;">Latest Assignment</small>
                        </a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <!--Active users indicator-->
                    <div class="p-3 kpi-card clients-card text-center">
                        <a href="{{ url('assignmentmapping') }}" style="text-decoration: none;">
                            <div class="header-pretitle fs-11 font-weight-bold text-uppercase" style="color: #6B21A8;">Open
                                Assignment
                            </div>
                            <div class="fs-32 text-monospace font-weight-bold" style="color: #6B21A8;">
                                {{ $assignmentcount }}</div>
                            <small style="color: #6c757d;">active Assignment</small>
                        </a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <!--Active users indicator-->
                    <div class="p-3 kpi-card team-card text-center">
                        <a href="{{ url('tender') }}" style="text-decoration: none;">
                            <div class="header-pretitle fs-11 font-weight-bold text-uppercase" style="color: #166534;">
                                Tender</div>
                            <div class="fs-32 text-monospace font-weight-bold" style="color: #166534;">{{ $tender ?? '' }}
                            </div>
                            <small style="color: #6c757d;">latest tender</small>
                        </a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <!--Active users indicator-->
                    <div class="p-3 kpi-card notification-card text-center">
                        <a href="{{ url('notification') }}" style="text-decoration: none;">
                            <div class="header-pretitle fs-11 font-weight-bold text-uppercase" style="color: #C2410C;">
                                Notification</div>
                            <div class="fs-32 text-monospace font-weight-bold" style="color: #C2410C;">{{ $notification }}
                            </div>
                            <small style="color: #6c757d;">Latest Notification</small>
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
                    <div class="p-3 kpi-card assignment-card text-center">
                        <div class="header-pretitle fs-11 font-weight-bold text-uppercase" style="color: #495057;">Team
                            Assignment</div>
                        <div class="fs-32 text-monospace font-weight-bold" style="color: #1E3A8A;">{{ $assignmentcount }}
                        </div>
                        <small style="color: #6c757d;">Latest Assignment</small>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <!--Active users indicator-->
                    <div class="p-3 kpi-card clients-card text-center">
                        <div class="header-pretitle fs-11 font-weight-bold text-uppercase" style="color: #6B21A8;">Open
                            Assignment</div>
                        <div class="fs-32 text-monospace font-weight-bold" style="color: #6B21A8;">{{ $assignmentcount }}
                        </div>
                        <small style="color: #6c757d;">active Assignment</small>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <!--Active users indicator-->
                    <div class="p-3 kpi-card team-card text-center">
                        <div class="header-pretitle fs-11 font-weight-bold text-uppercase" style="color: #166534;">Close
                            Assignment</div>
                        <div class="fs-32 text-monospace font-weight-bold" style="color: #166534;">0</div>
                        <small style="color: #6c757d;">close Assignment</small>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <!--Active users indicator-->
                    <div class="p-3 kpi-card notification-card text-center">
                        <div class="header-pretitle fs-11 font-weight-bold text-uppercase" style="color: #C2410C;">
                            Notification</div>
                        <div class="fs-32 text-monospace font-weight-bold" style="color: #C2410C;">{{ $notification }}
                        </div>
                        <small style="color: #6c757d;">Latest Notification</small>
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
                    <div class="p-3 kpi-card assignment-card text-center">
                        <a href="{{ url('assignmentmapping') }}" style="text-decoration: none;">
                            <div class="header-pretitle fs-11 font-weight-bold text-uppercase" style="color: #495057;">
                                Assignment</div>
                            <div class="fs-32 text-monospace font-weight-bold" style="color: #1E3A8A;">
                                {{ $assignmentcount }}</div>
                            <small style="color: #6c757d;">Latest Assignment</small>
                            <a></a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <!--Active users indicator-->
                    <div class="p-3 kpi-card clients-card text-center">
                        <a href="{{ url('client') }}" style="text-decoration: none;">
                            <div class="header-pretitle fs-11 font-weight-bold text-uppercase" style="color: #6B21A8;">
                                Client</div>
                            <div class="fs-32 text-monospace font-weight-bold" style="color: #6B21A8;">
                                {{ $client }}</div>
                            <small style="color: #6c757d;">active clients</small>
                        </a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <!--Active users indicator-->
                    <div class="p-3 kpi-card team-card text-center">
                        <a href="{{ url('teammember') }}" style="text-decoration: none;">
                            <div class="header-pretitle fs-11 font-weight-bold text-uppercase" style="color: #166534;">
                                Team Member</div>
                            <div class="fs-32 text-monospace font-weight-bold" style="color: #166534;">
                                {{ $teammember }}</div>
                            <small style="color: #6c757d;">active Member</small>
                        </a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <!--Active users indicator-->
                    <div class="p-3 kpi-card notification-card text-center">
                        <a href="{{ url('notification') }}" style="text-decoration: none;">
                            <div class="header-pretitle fs-11 font-weight-bold text-uppercase" style="color: #C2410C;">
                                Notification</div>
                            <div class="fs-32 text-monospace font-weight-bold" style="color: #C2410C;">
                                {{ $notification }}</div>
                            <small style="color: #6c757d;">Latest Notification</small>
                        </a>
                    </div>
                </div>

            </div>


        </div>
    @endif

    @if (Auth::user()->role_id == 11)
        <div class="body-content">
            <div class="row">

                <!-- Assignments -->
                <div class="col-md-6 col-lg-3">
                    <div class="p-3 kpi-card assignment-card text-center">
                        <a href="{{ url('assignmentmapping') }}" style="text-decoration: none;">
                            <div class="header-pretitle fs-11 font-weight-bold text-uppercase" style="color: #495057;">
                                Assignment
                            </div>
                            <div class="fs-32 text-monospace font-weight-bold" style="color: #1E3A8A;">
                                {{ $assignmentcount }}
                            </div>
                            <small style="color: #6c757d;">
                                Latest Assignment
                            </small>
                        </a>
                    </div>
                </div>

                <!-- Clients -->
                <div class="col-md-6 col-lg-3">
                    <div class="p-3 kpi-card clients-card text-center">
                        <a href="{{ url('client') }}" style="text-decoration: none;">
                            <div class="header-pretitle fs-11 font-weight-bold text-uppercase" style="color: #6B21A8;">
                                Client
                            </div>
                            <div class="fs-32 text-monospace font-weight-bold" style="color: #6B21A8;">
                                {{ $client }}
                            </div>
                            <small style="color: #6c757d;">
                                active clients
                            </small>
                        </a>
                    </div>
                </div>

                <!-- Team Members -->
                <div class="col-md-6 col-lg-3">
                    <div class="p-3 kpi-card team-card text-center">
                        <a href="{{ url('teammember') }}" style="text-decoration: none;">
                            <div class="header-pretitle fs-11 font-weight-bold text-uppercase" style="color: #166534;">
                                Team Member
                            </div>
                            <div class="fs-32 text-monospace font-weight-bold" style="color: #166534;">
                                {{ $teammember }}
                            </div>
                            <small style="color: #6c757d;">
                                active Member
                            </small>
                        </a>
                    </div>
                </div>

                <!-- Notifications -->
                <div class="col-md-6 col-lg-3">
                    <div class="p-3 kpi-card notification-card text-center">
                        <a href="{{ url('notification') }}" style="text-decoration: none;">
                            <div class="header-pretitle fs-11 font-weight-bold text-uppercase" style="color: #C2410C;">
                                Notification
                            </div>
                            <div class="fs-32 text-monospace font-weight-bold" style="color: #C2410C;">
                                {{ $notification }}
                            </div>
                            <small style="color: #6c757d;">
                                Latest Notification
                            </small>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    @endif


    <div class="body-content" style="margin-top: -19px;">
        <div class="row">
            @if ($pageid == 1)
                <div class="col-md-12 col-lg-4">
                    <div class="card mb-4 dashboard-section-card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="dashboard-section-title">
                                    <span class="dashboard-section-icon"
                                        style="background-color: #e0f2fe; color: #0284c7;">
                                        <i class="typcn typcn-ticket"></i>
                                    </span>
                                    <h6 class="fs-17 font-weight-600 mb-0">Support Ticket</h6>
                                </div>
                                <a href="{{ url('ticketsupport') }}"
                                    class="btn btn-sm btn-outline-primary dashboard-pill">
                                    View All
                                </a>
                            </div>
                        </div>
                        <div class="dashboard-section-list">
                            @if (count($assetticket) > 0)
                                @foreach ($assetticket as $assetticketData)
                                    <div class="dashboard-list-item dashboard-list-accent"
                                        style="border-left-color: #0284c7;">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <a href="{{ url('/ticket/' . $assetticketData->id) }}" class="text-dark"
                                                style="text-decoration: none;">
                                                <h6 class="font-weight-600 mb-1">{{ $assetticketData->subject }}</h6>
                                                <span
                                                    class="text-muted text-sm">#{{ $assetticketData->generateticket_id }}</span>
                                                <p class="mb-1 mt-1 text-muted" style="font-size: 13px;">
                                                    created by <strong>{{ $assetticketData->team_member }}</strong>
                                                    <span class="badge badge-info ml-1">
                                                        @if ($assetticketData->status == 0)
                                                            <span>open</span>
                                                        @elseif($assetticketData->status == 1)
                                                            <span>working</span>
                                                        @elseif($assetticketData->status == 2)
                                                            <span>close</span>
                                                        @else
                                                            <span>reject</span>
                                                        @endif
                                                    </span>
                                                </p>
                                                <small class="text-muted"><i class="far fa-clock mr-1"></i>
                                                    {{ date('H:i A', strtotime($assetticketData->created_at)) }},
                                                    {{ date('F jS', strtotime($assetticketData->created_at)) }}</small>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="dashboard-empty-state">
                                    <div>
                                        <i class="typcn typcn-ticket"></i>
                                        <h6 class="mb-0">No Data</h6>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif



            <div class="col-md-12 col-lg-4">
                <div class="card mb-4 dashboard-section-card">

                    <!-- Header -->
                    <div class="card-header d-flex justify-content-between align-items-center">

                        <div class="dashboard-section-title">
                            <span class="dashboard-section-icon" style="background-color: #eff6ff; color: #2563eb;">
                                <i class="typcn typcn-bell"></i>
                            </span>
                            <h6 class="fs-17 font-weight-600 mb-0">Notifications</h6>

                            @if (count($notificationDatas) > 0)
                                <span class="badge badge-danger ml-2" style="font-size: 13px; font-weight: 600;">
                                    {{ count($notificationDatas) }}
                                </span>
                            @endif
                        </div>

                        <a href="{{ url('notification') }}" class="btn btn-sm btn-outline-primary dashboard-pill">
                            View All
                        </a>
                    </div>

                    <!-- Notification List -->
                    <div class="dashboard-section-list">
                        @if (count($notificationDatas) > 0)
                            @foreach ($notificationDatas as $notificationData)
                                <div class="dashboard-list-item dashboard-list-accent"
                                    style="border-left-color: #2563eb;">

                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <!-- Main Notification Title with Anchor -->
                                            <h6 class="mb-1">
                                                <a href="{{ url('notification') }}" class="text-dark font-weight-600"
                                                    style="text-decoration: none;">
                                                    {{ $notificationData->title }}
                                                </a>
                                            </h6>

                                            <!-- Created by line -->
                                            <small class="text-muted d-block mb-1">
                                                created by <strong>{{ $notificationData->team_member }}</strong>
                                            </small>

                                            <!-- Time -->
                                            <small class="text-muted">
                                                {{ date('H:i A', strtotime($notificationData->created_at)) }},
                                                {{ date('F jS', strtotime($notificationData->created_at)) }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="dashboard-empty-state">
                                <div>
                                    <i class="typcn typcn-bell"></i>
                                    <h6 class="mb-0">No Notifications</h6>
                                </div>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
            <!----Mentor---->


            @if (auth()->user()->role_id == 11 or auth()->user()->role_id == 12)
            @else
                @if ($mentor != null)
                    <div class="col-md-12 col-lg-4">
                        <div class="card mb-4" style="height: 310px;">
                            <div class="card-header" style="    background-color: #5ab5ee59;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>


                                        <h6 class="fs-17 font-weight-600 mb-0"><i style="font-size: 20px;padding:10px;"
                                                class="typcn typcn-user-outline mr-2"></i> Your Mentor</h6>

                                    </div>

                                </div>
                            </div>
                            <div class="list-group list-group-flush">
                                <ul class="list-unstyled">

                                    @if ($mentor != null)
                                        @if ($mentor->mentor_id == auth()->user()->teammember_id)
                                        @elseif($mentor != null)
                                            <li class="list-group-item list-group-item-action">
                                                <label for="">Name : </label>
                                                <span class="text-muted text-sm">{{ $mentor->team_member }}
                                                </span>
                                                <br>
                                                <label for="">Designation : </label>
                                                <span class="text-muted text-sm">{{ $mentor->designation ?? '' }}
                                                </span>
                                                <br>
                                                <label for="">Email : </label>
                                                <span class="text-muted text-sm">{{ $mentor->emailid ?? '' }}
                                                </span>


                                            </li>
                                        @else
                                            <li class="list-group-item list-group-item-action">
                                                <br><br><br>
                                                <h5 style="text-align: center"><span>No Data</span></h5>
                                                <br><br><br> <br>
                                            </li>
                                        @endif
                                    @endif

                                </ul>
                            </div>

                        </div>

                    </div>

                @endif
            @endif


            <!---mentor end --->

            <!----Mentee---->


            @if (auth()->user()->role_id == 11 or auth()->user()->role_id == 12)
            @else
                @if ($mentees != null)
                    <div class="col-md-12 col-lg-4">
                        <div class="card mb-4" style="height: 310px;">
                            <div class="card-header" style="    background-color: #5ab5ee59;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>


                                        <h6 class="fs-17 font-weight-600 mb-0"><i style="font-size: 20px;padding:10px;"
                                                class="typcn typcn-user-outline mr-2"></i> Your Mentees</h6>

                                    </div>

                                </div>
                            </div>
                            <div class="list-group list-group-flush">
                                <ul class="list-unstyled">

                                    @if ($mentees != null)
                                        @foreach ($mentees as $mentee)
                                            <li class="list-group-item list-group-item-action">
                                                <label for="">Name : </label>
                                                <span class="text-muted text-sm">{{ $mentee->team_member }}
                                                </span>
                                                <br>
                                                <label for="">Designation : </label>
                                                <span class="text-muted text-sm">{{ $mentee->designation ?? '' }}
                                                </span>
                                                <br>
                                                <label for="">Email : </label>
                                                <span class="text-muted text-sm">{{ $mentee->emailid ?? '' }}
                                                </span>


                                            </li>
                                        @endforeach
                                    @endif

                                </ul>
                            </div>

                        </div>

                    </div>

                @endif
            @endif


            <!---mentee end --->
            <div class="col-md-12 col-lg-4">
                <div class="card mb-4 dashboard-section-card">

                    <!-- Card Header -->
                    <div class="card-header d-flex justify-content-between align-items-center">

                        <div class="dashboard-section-title">
                            <span class="dashboard-section-icon" style="background-color: #eef2ff; color: #4f46e5;">
                                <i class="typcn typcn-folder"></i>
                            </span>
                            <h6 class="fs-17 font-weight-600 mb-0">Assignments</h6>
                        </div>

                        <a href="{{ url('assignmentmapping') }}" class="btn btn-sm btn-outline-primary dashboard-pill">
                            View All
                        </a>
                    </div>

                    <!-- Table Content -->
                    <div class="dashboard-section-list">
                        <table class="table table-hover mb-0">
                            <thead style="background-color: #f8fafc; position: sticky; top: 0; z-index: 1;">
                                <tr>
                                    <th class="pl-4"
                                        style="font-size: 13px; font-weight: 600; color: #64748b; border-top: none;">Client
                                    </th>
                                    <th class="pl-3"
                                        style="font-size: 13px; font-weight: 600; color: #64748b; border-top: none;">Type
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($assignment) > 0)
                                    @foreach ($assignment as $assignmentData)
                                        <tr>
                                            <td class="pl-4 py-3">
                                                <a href="{{ url('/viewassignment/' . $assignmentData->assignmentgenerate_id) }}"
                                                    class="text-dark font-weight-600" style="text-decoration: none;">
                                                    {{ $assignmentData->client_name ?? 'N/A' }}
                                                </a>
                                            </td>
                                            <td class="pl-3 py-3">
                                                <span class="badge badge-light text-dark">
                                                    {{ $assignmentData->assignment_name ?? 'Other' }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="2" class="text-center py-5 text-muted">
                                            <div class="py-3">
                                                <i class="typcn typcn-folder"
                                                    style="font-size: 28px; color: #c0c7d2;"></i>
                                                <h6 class="mb-0 mt-2">No Data Available</h6>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>



            <div class="col-md-12 col-lg-4">
                <div class="card mb-4 dashboard-section-card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="dashboard-section-title">
                                <span class="dashboard-section-icon" style="background-color: #fff7ed; color: #ea580c;">
                                    <i class="fas fa-birthday-cake"></i>
                                </span>
                                <h6 class="fs-17 font-weight-600 mb-0">Birthday</h6>
                            </div>
                        </div>
                    </div>
                    <div class="dashboard-section-list">
                        <div class="card-body">
                            <h6 class="dashboard-mini-label mb-2">Today</h6>
                            <div class="scroll-container">
                                @if ($todayBirthdays->count() > 0)
                                    @foreach ($todayBirthdays as $birthday)
                                        <div class="dashboard-person-item">
                                            <span class="dashboard-person-avatar"
                                                style="background-color: #fff7ed; color: #ea580c;">
                                                <i class="fas fa-birthday-cake"></i>
                                            </span>
                                            <div>
                                                <h6 class="font-weight-600 mb-1">Happy Birthday,
                                                    {{ $birthday->team_member }}</h6>
                                                <span>
                                                    <small class="text-muted">
                                                        <i class="fas fa-birthday-cake mr-1"></i>
                                                        {{ \Carbon\Carbon::parse($birthday->dateofbirth)->format('d M') }}
                                                    </small>
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-muted mb-2">
                                        <h6 class="mb-0">No birthdays today.</h6>
                                    </div>
                                @endif
                            </div>

                            <hr>

                            <h6 class="dashboard-mini-label mb-2">Upcoming</h6>
                            <div class="scroll-container">

                                @if ($upcomingBirthdays != null)
                                    @foreach ($upcomingBirthdays as $birthday)
                                        <div class="dashboard-person-item">
                                            <span class="dashboard-person-avatar"
                                                style="background-color: #eef2ff; color: #4f46e5;">
                                                <i class="fas fa-user"></i>
                                            </span>
                                            <div>
                                                <h6 class="font-weight-600 mb-1">{{ $birthday->team_member }}</h6>
                                                <span>
                                                    <small class="text-muted">
                                                        <i class="fas fa-birthday-cake mr-1"></i>
                                                        {{ \Carbon\Carbon::parse($birthday->dateofbirth)->format('d M') }}
                                                    </small>
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-muted">
                                        <h6 class="mb-0">No upcoming birthdays.</h6>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    {{-- <div class="dropdown-footer" style="margin-top: 22px">
                        <a href="{{ url('birthday') }}">View All Birthdays</a>
                    </div> --}}
                </div>
            </div>


            <!---work anniversary card--->
            <!---work anniversaries--->
            <div class="col-md-12 col-lg-4">
                <div class="card mb-4 dashboard-section-card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="dashboard-section-title">
                                <span class="dashboard-section-icon" style="background-color: #fef2f2; color: #dc2626;">
                                    <i class="fas fa-calendar-alt"></i>
                                </span>
                                <h6 class="fs-17 font-weight-600 mb-0">Work Anniversary</h6>
                            </div>
                        </div>
                    </div>
                    <div class="dashboard-section-list">
                        <div class="card-body">
                            <div class="scroll-container">
                                @if ($workAnniversaries->isEmpty())
                                    <div class="dashboard-empty-state">
                                        <div>
                                            <i class="fas fa-calendar-alt"></i>
                                            <h6 class="mb-0">No Work Anniversary</h6>
                                        </div>
                                    </div>
                                @else
                                    @foreach ($workAnniversaries as $anniversary)
                                        <div class="dashboard-person-item">
                                            <span class="dashboard-person-avatar"
                                                style="background-color: #fef2f2; color: #dc2626;">
                                                <i class="fas fa-calendar-alt"></i>
                                            </span>
                                            <div>
                                                <h6 class="font-weight-600 mb-1">Congratulations,
                                                    {{ $anniversary->team_member }}</h6>
                                                <span>
                                                    <small class="text-muted">
                                                        <i class="fas fa-calendar-alt mr-1"></i>
                                                        {{ \Carbon\Carbon::parse($anniversary->joining_date)->diffInYears() }}
                                                        Years
                                                    </small>
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-4">
                <div class="card mb-4 dashboard-section-card">

                    <!-- Header -->
                    <div class="card-header d-flex justify-content-between align-items-center">

                        <div class="dashboard-section-title">
                            <span class="dashboard-section-icon" style="background-color: #ecfdf5; color: #059669;">
                                <i class="fas fa-calendar-check"></i>
                            </span>
                            <h6 class="fs-17 font-weight-600 mb-0">Upcoming Holidays</h6>
                        </div>

                        <a href="{{ url('holidays') }}?year={{ date('Y') }}"
                            class="btn btn-sm btn-outline-primary dashboard-pill">
                            View All
                        </a>
                    </div>

                    <!-- Holidays List -->
                    <div class="dashboard-section-list">
                        @if (count($upcomingHolidays) > 0)
                            @foreach ($upcomingHolidays as $holiday)
                                <div class="dashboard-list-item dashboard-list-accent"
                                    style="border-left-color: #059669;">

                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <!-- Holiday Name -->
                                            <h6 class="mb-1 font-weight-600">
                                                {{ $holiday->holidayname }}
                                            </h6>

                                            <!-- Date -->
                                            <small class="text-muted">
                                                <i class="fas fa-calendar-check mr-1"></i>
                                                {{ $holiday->startdate }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="dashboard-empty-state">
                                <div>
                                    <i class="fas fa-calendar-check"></i>
                                    <h6 class="mb-0">No Upcoming Holidays</h6>
                                </div>
                            </div>
                        @endif
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
@endsection
