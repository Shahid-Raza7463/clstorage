    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @extends('backEnd.layouts.layout') @section('backEnd_content')
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

            @media (max-width: 992px) {

                .dashboard-card-content,
                .dashboard-bottom {
                    grid-template-columns: 1fr;
                }
            }
        </style>
        <div class="content-header row align-items-center m-0">
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

        @if (Auth::user()->role_id == 11)
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
                </div>
                {{-- . --}}
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
        @endif

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
