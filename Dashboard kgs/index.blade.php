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
                /* font-family: Arial, sans-serif; */
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


            .completed {
                background-color: #c4ffc8;
                color: #0b680f;
            }

            .on-track1 {
                background-color: #3ea9dc42;
                color: #4b43a0;
            }

            .delayed1 {
                background-color: #e3938554;
                color: #ff2f00;
            }

            .completed1 {
                background-color: #caf4cd;
                color: #0b680f;
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
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="p-3 shadow-sm border border-success rounded text-dark"
                            style=" background-color: rgb(240, 253, 244);">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="font-weight-bold small" style="margin-bottom: 10px;">Upcoming Assignments
                                    </div>
                                    <div class="h4 font-weight-bold">{{ $upcomingAssignments }}</div>
                                    <div class="text-muted small">Total assignments count</div>
                                    <div class="small mt-2">&nbsp;</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="p-3 shadow-sm border border-warning rounded text-dark"
                            style="background-color: rgb(254, 252, 232);">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="font-weight-bold small" style="margin-bottom: 10px;">Payments Not Recieved
                                    </div>
                                    <div class="h4 font-weight-bold">{{ $billspending15Days }}</div>
                                    <div class="text-muted small">Within 15 Days</div>
                                    <div class="small mt-2">&nbsp;</div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="p-3 shadow-sm border border-primary rounded text-dark"
                            style=" background-color: rgb(235, 231, 248)">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="font-weight-bold small" style="margin-bottom: 10px;">Timesheet Filled
                                    </div>
                                    <div class="h4 font-weight-bold">{{ 'NA' }}</div>
                                    <div class="text-muted small" style="font-size: 9px;">Timesheet Filled On Closed
                                        Assignment</div>
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
                    @foreach ($assignmentOverviews as $assignmentOverview)
                        <div class="assignment-card">
                            <div class="assignment-header">
                                <div class="assignment-title">
                                    <h3> {{ $assignmentOverview->client_name ?? '' }}</h3>
                                    <p>{{ $assignmentOverview->assignmentname ?? '' }}</p>
                                </div>
                                <div class="assignment-status">
                                    @php
                                        $endDate = $assignmentOverview->finalassignmentenddate;
                                    @endphp
                                    @if ($assignmentOverview->status == 0)
                                        <span class="priority-tag completed1">COMPLETED</span>
                                    @elseif ($endDate && \Carbon\Carbon::parse($endDate)->isFuture())
                                        <span class="priority-tag on-track1">ON TRACK</span>
                                    @else
                                        <span class="priority-tag delayed1">DELAYED</span>
                                    @endif
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
                            </div>
                            <div class="text-muted small" style="margin-top: 8px; font-size: 12px;">Due:
                                {{ $assignmentOverview->finalassignmentenddate }}
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="card">
                    <div class="card-header">
                        <h2>Document Completion Progress</h2>
                    </div>

                    @foreach ($documentCompletions as $documentCompletion)
                        <div class="document-card">
                            <h3 class="document-title">{{ $documentCompletion->assignmentname ?? '' }} -
                                {{ $documentCompletion->client_name ?? '' }}</h3>
                            <div class="document-info">
                                {{-- <span>42/50 docs</span> --}}
                                <span class="progress-value">84%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill progress-document-84"></div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- completed --}}
                <div class="card">
                    <div class="card-header">
                        <h2>Monthly Expense Analysis</h2>
                    </div>
                    <canvas id="expenseChart" width="auto" height="250"></canvas>
                </div>

                <script>
                    const expenseCtx = document.getElementById('expenseChart').getContext('2d');
                    const normalExpensesData = [140000, 110000, 130000, 120000, 120000, 140000];
                    const exceptionalExpensesData = [55000, 60000, 40000, 70000, 75000, 50000];
                    // Labels for X-axis (mahine ke naam).
                    const expenseMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];

                    const expenseChart = new Chart(expenseCtx, {
                        type: 'bar',
                        data: {
                            labels: expenseMonths,
                            datasets: [{
                                    label: 'Normal Expenses',
                                    data: normalExpensesData,
                                    backgroundColor: 'rgb(59, 130, 246)',
                                    borderColor: 'rgb(59, 130, 246)',
                                    borderWidth: 1 // border width
                                },
                                {
                                    label: 'Exceptional Expenses',
                                    data: exceptionalExpensesData,
                                    backgroundColor: 'rgb(239, 68, 68)',
                                    borderColor: 'rgb(239, 68, 68)',
                                    borderWidth: 1 // border width
                                }
                            ]
                        },
                        options: {
                            scales: {
                                // y axis start value from 0
                                y: {
                                    max: 140000,
                                    beginAtZero: true,
                                    // min: 0,
                                    ticks: {
                                        stepSize: 35000
                                    }
                                }
                            },

                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    // Default tooltip disabled
                                    enabled: false,
                                    // custom tooltip using external function.
                                    external: function(context) {
                                        // Tooltip Element
                                        let tooltipEl = document.getElementById('chartjs-tooltip');

                                        // Create element on first render
                                        if (!tooltipEl) {
                                            tooltipEl = document.createElement('div');
                                            tooltipEl.id = 'chartjs-tooltip';
                                            tooltipEl.innerHTML = '<div></div>';
                                            document.body.appendChild(tooltipEl);
                                        }

                                        const tooltipModel = context.tooltip;

                                        // Hide if no tooltip
                                        if (tooltipModel.opacity === 0) {
                                            tooltipEl.style.opacity = 0;
                                            return;
                                        }

                                        // Set Text
                                        if (tooltipModel.body) {
                                            const index = tooltipModel.dataPoints[0].dataIndex;
                                            const month = expenseMonths[index];
                                            const normalExpenses = normalExpensesData[index];
                                            const exceptionalExpenses = exceptionalExpensesData[index];

                                            const innerHtml = `
                        <div style="background: white; border: 1px solid #ccc; padding: 8px; border-radius: 4px;">
                            <div style="color: black; font-weight: bold; margin-bottom: 4px;">${month}</div>
                            <div style="color: blue;">Normal Expenses: ${normalExpenses}</div>
                            <div style="color: red;">Exceptional Expenses: ${exceptionalExpenses}</div>
                        </div>
                  `;

                                            tooltipEl.innerHTML = innerHtml;
                                        }
                                        // exact position of Tooltip set  near by mouse .
                                        const position = context.chart.canvas.getBoundingClientRect();
                                        tooltipEl.style.opacity = 1;
                                        tooltipEl.style.position = 'absolute';
                                        tooltipEl.style.left = position.left + window.pageXOffset + tooltipModel.caretX +
                                            'px';
                                        tooltipEl.style.top = position.top + window.pageYOffset + tooltipModel.caretY +
                                            'px';
                                        tooltipEl.style.pointerEvents = 'none';
                                        tooltipEl.style.zIndex = 999;
                                    }
                                }
                            },
                            interaction: {
                                mode: 'index',
                                intersect: false
                            }
                        }
                    });
                </script>


                <div class="card">
                    <div class="card-header">
                        <h2>ECQR Audits & Quality Reviews</h2>
                    </div>

                    @foreach ($ecqrAudits as $ecqrAudit)
                        <div class="ecqr-card">
                            <div class="ecqr-header" style=" margin: 0;">
                                <div class="ecqr-title">
                                    <h3>{{ $ecqrAudit->assignmentname ?? '' }}</h3>
                                    <p style=" margin: 0;">{{ $ecqrAudit->client_name ?? '' }}</p>
                                    <p style=" margin: 0;">Assigned to: {{ $ecqrAudit->team_member ?? '' }}</p>
                                </div>
                                <div class="ecqr-status">

                                    @php
                                        $endDate = $ecqrAudit->finalassignmentenddate;
                                    @endphp
                                    @if ($ecqrAudit->status == 0)
                                        <span class="priority-tag completed">COMPLETED</span>
                                    @elseif ($endDate && \Carbon\Carbon::parse($endDate)->isFuture())
                                        <span class="priority-tag on-track">IN PROGRESS</span>
                                    @else
                                        <span class="priority-tag delayed">DELAYED</span>
                                    @endif
                                    <span class="text-muted small" style="margin-top: 8px; font-size: 12px;">Due:
                                        {{ $ecqrAudit->finalassignmentenddate }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    {{-- <div class="ecqr-card">
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
                    </div> --}}
                </div>

                {{-- completed --}}
                <div class="card">
                    <div class="card-header">
                        <h2>Cash Flow Analysis</h2>
                    </div>
                    <canvas id="cashFlowChart" width="auto" height="250"></canvas>
                </div>

                <script>
                    const cashFlowCtx = document.getElementById('cashFlowChart').getContext('2d');
                    const cashInflowData = [400000, 350000, 350000, 400000, 500000, 700000];
                    const cashOutflowData = [100000, 80000, 90000, 120000, 130000, 150000];
                    const netCashflowData = [-400000, -350000, -300000, -250000, -200000, -200000];
                    // Labels for X-axis (mahine ke naam).
                    const cashFlowMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];

                    const cashFlowChart = new Chart(cashFlowCtx, {
                        type: 'line',
                        data: {
                            labels: cashFlowMonths,
                            datasets: [{
                                    label: 'Cash Inflow',
                                    data: cashInflowData,
                                    borderColor: 'rgba(75, 192, 75, 1)',
                                    backgroundColor: 'rgba(75, 192, 75, 0.2)',
                                    borderWidth: 2,
                                    fill: false
                                },
                                {
                                    label: 'Cash Outflow',
                                    data: cashOutflowData,
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                    borderWidth: 2,
                                    fill: false
                                },
                                {
                                    label: 'Net cash flow',
                                    data: netCashflowData,
                                    borderColor: 'rgba(255, 99, 132, 1)',
                                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                    borderWidth: 2,
                                    fill: false
                                }
                            ]
                        },
                        options: {
                            scales: {
                                y: {
                                    max: 700000,
                                    beginAtZero: true,
                                    // min: 0,
                                    ticks: {
                                        stepSize: 350000
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    enabled: false, // disable the default tooltip
                                    external: function(context) {
                                        // Tooltip Element
                                        let tooltipEl = document.getElementById('chartjs-tooltip');

                                        // Create element on first render
                                        if (!tooltipEl) {
                                            tooltipEl = document.createElement('div');
                                            tooltipEl.id = 'chartjs-tooltip';
                                            tooltipEl.innerHTML = '<div></div>';
                                            document.body.appendChild(tooltipEl);
                                        }

                                        const tooltipModel = context.tooltip;

                                        // Hide if no tooltip
                                        if (tooltipModel.opacity === 0) {
                                            tooltipEl.style.opacity = 0;
                                            return;
                                        }

                                        // Set Text
                                        if (tooltipModel.body) {
                                            const index = tooltipModel.dataPoints[0].dataIndex;
                                            const month = cashFlowMonths[index];
                                            const cashInflowDataValue = cashInflowData[index];
                                            const cashOutflowDataValue = cashOutflowData[index];
                                            const netCashflowDataValue = netCashflowData[index];

                                            const innerHtml = `
                               <div style="background: white; border: 1px solid #ccc; padding: 8px; border-radius: 4px;">
                                   <div style="color: black; font-weight: bold; margin-bottom: 4px;">${month}</div>
                                   <div style="color: green;">Cash Inflow: ${cashInflowDataValue}</div>
                                   <div style="color: red;">Cash Outflow: ${cashOutflowDataValue}</div>
                                   <div style="color: blue;">Net cash flow: ${netCashflowDataValue}</div>
                               </div>
                           `;

                                            tooltipEl.innerHTML = innerHtml;
                                        }

                                        const position = context.chart.canvas.getBoundingClientRect();
                                        tooltipEl.style.opacity = 1;
                                        tooltipEl.style.position = 'absolute';
                                        tooltipEl.style.left = position.left + window.pageXOffset + tooltipModel.caretX +
                                            'px';
                                        tooltipEl.style.top = position.top + window.pageYOffset + tooltipModel.caretY +
                                            'px';
                                        tooltipEl.style.pointerEvents = 'none';
                                        tooltipEl.style.zIndex = 999;
                                    }
                                }
                            },
                            interaction: {
                                mode: 'index',
                                intersect: false
                            }
                        }
                    });
                </script>

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
                                @foreach ($assignmentprofitandlosses as $assignmentprofitandloss)
                                    <tr>
                                        <td class="textfixed" style="padding: 17px;">
                                            {{ $assignmentprofitandloss->assignmentname ?? '' }}
                                        </td>
                                        <td class="textfixed" style="padding: 17px;">
                                            {{ $assignmentprofitandloss->client_name ?? '' }}</td>
                                        <td style="padding: 17px;">₹{{ $assignmentprofitandloss->engagementfee ?? '' }}
                                        </td>
                                        <td style="padding: 17px;">₹280,000</td>
                                        <td style="padding: 17px;" class="text-success">₹270,000</td>
                                        <td style="padding: 17px;" class="text-success">21.6%</td>
                                        <td style="padding: 17px;"><span class="priority-tag on-track">PROFITABLE</span>
                                        </td>
                                    </tr>
                                @endforeach

                                {{-- <tr>
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
                                </tr> --}}
                            </tbody>
                        </table>
                    </div>
                </div>


                {{-- <div class="card">
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
                </div> --}}

                {{-- completed --}}
                <div class="card">
                    <div class="card-header">
                        <h2>Budget vs Actual Cash Flow</h2>
                    </div>
                    <canvas id="budgetcashflow" width="auto" height="250"></canvas>
                </div>

                <script>
                    const budgetcashflowctx = document.getElementById('budgetcashflow').getContext('2d');
                    const budgetcashflowmonths = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
                    const budgetInflowData = [400000, 450000, 400000, 500000, 600000, 700000];
                    const actualInflowData = [350000, 400000, 350000, 450000, 500000, 600000];
                    const budgetOutflowData = [-400000, -350000, -300000, -250000, -200000, -200000];
                    const actualOutflowData = [-350000, -300000, -250000, -200000, -150000, -150000];

                    const budgetcashflowChart = new Chart(budgetcashflowctx, {
                        type: 'line',
                        data: {
                            labels: budgetcashflowmonths,
                            datasets: [{
                                    label: 'Budget Inflow',
                                    data: budgetInflowData,
                                    borderColor: 'rgba(153, 102, 255, 1)',
                                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                                    borderWidth: 2,
                                    borderDash: [5, 5],
                                    fill: false
                                },
                                {
                                    label: 'Actual Inflow',
                                    data: actualInflowData,
                                    borderColor: 'rgba(75, 192, 75, 1)',
                                    backgroundColor: 'rgba(75, 192, 75, 0.2)',
                                    borderWidth: 2,
                                    fill: false
                                },
                                {
                                    label: 'Budget Outflow',
                                    data: budgetOutflowData,
                                    borderColor: 'rgba(255, 159, 64, 1)',
                                    backgroundColor: 'rgba(255, 159, 64, 0.2)',
                                    borderWidth: 2,
                                    borderDash: [5, 5],
                                    fill: false
                                },
                                {
                                    label: 'Actual Outflow',
                                    data: actualOutflowData,
                                    borderColor: 'rgba(255, 99, 132, 1)',
                                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                    borderWidth: 2,
                                    fill: false
                                }
                            ]
                        },
                        options: {
                            scales: {
                                y: {
                                    max: 700000,
                                    beginAtZero: true,
                                    // min: 0,
                                    ticks: {
                                        stepSize: 350000
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    enabled: false, // disable the default tooltip
                                    external: function(context) {
                                        // Tooltip Element
                                        let tooltipEl = document.getElementById('chartjs-tooltip');

                                        // Create element on first render
                                        if (!tooltipEl) {
                                            tooltipEl = document.createElement('div');
                                            tooltipEl.id = 'chartjs-tooltip';
                                            tooltipEl.innerHTML = '<div></div>';
                                            document.body.appendChild(tooltipEl);
                                        }

                                        const tooltipModel = context.tooltip;

                                        // Hide if no tooltip
                                        if (tooltipModel.opacity === 0) {
                                            tooltipEl.style.opacity = 0;
                                            return;
                                        }

                                        // Set Text
                                        if (tooltipModel.body) {
                                            const index = tooltipModel.dataPoints[0].dataIndex;
                                            const month = budgetcashflowmonths[index];
                                            const budgetInflowDataValue = budgetInflowData[index];
                                            const caactualInflowDataValue = actualInflowData[index];
                                            const budgetOutflowDataValue = budgetOutflowData[index];
                                            const actualOutflowDataValue = actualOutflowData[index];

                                            const innerHtml = `
                               <div style="background: white; border: 1px solid #ccc; padding: 8px; border-radius: 4px;">
                                   <div style="color: black; font-weight: bold; margin-bottom: 4px;">${month}</div>
                                   <div style="color: blue;">Budget Inflow: ${budgetInflowDataValue}</div>
                                   <div style="color: green;">Actual Inflow: ${caactualInflowDataValue}</div>
                                   <div style="color: orange;">Budget Outflow: ${actualOutflowDataValue}</div>
                                   <div style="color: red;">Actual Outflow: ${actualOutflowDataValue}</div>
                               </div>
                           `;

                                            tooltipEl.innerHTML = innerHtml;
                                        }

                                        const position = context.chart.canvas.getBoundingClientRect();
                                        tooltipEl.style.opacity = 1;
                                        tooltipEl.style.position = 'absolute';
                                        tooltipEl.style.left = position.left + window.pageXOffset + tooltipModel.caretX +
                                            'px';
                                        tooltipEl.style.top = position.top + window.pageYOffset + tooltipModel.caretY +
                                            'px';
                                        tooltipEl.style.pointerEvents = 'none';
                                        tooltipEl.style.zIndex = 999;
                                    }
                                }
                            },
                            interaction: {
                                mode: 'index',
                                intersect: false
                            }
                        }
                    });
                </script>


                <div class="card">
                    <div class="card-header">
                        <h2>Budget vs Actual P&L</h2>
                    </div>
                    <canvas id="budgetvsActual" width="auto" height="250"></canvas>
                </div>

                <script>
                    const budgetvsActualctx = document.getElementById('budgetvsActual').getContext('2d');

                    const budgetRevenue = [2500000, 2700000, 2800000, 2900000, 2900000, 3000000];
                    const actualRevenue = [2250000, 2500000, 2600000, 2700000, 2800000, 2900000];
                    const budgetExpenses = [2000000, 2100000, 2200000, 2300000, 2250000, 2300000];
                    const actualExpenses = [1800000, 1900000, 2000000, 2100000, 2000000, 2000000];

                    const budgetvsActualMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];

                    const budgetvsActualChart = new Chart(budgetvsActualctx, {
                        type: 'bar',
                        data: {
                            labels: budgetvsActualMonths,
                            datasets: [{
                                    label: 'Budget Revenue',
                                    data: budgetRevenue,
                                    backgroundColor: 'rgba(139, 92, 246)',
                                    borderColor: 'rgba(139, 92, 246)',
                                    borderWidth: 1
                                },
                                {
                                    label: 'Actual Revenue',
                                    data: actualRevenue,
                                    backgroundColor: 'rgba(16, 185, 129)',
                                    borderColor: 'rgba(16, 185, 129)',
                                    borderWidth: 1
                                },
                                {
                                    label: 'Budget Expenses',
                                    data: budgetExpenses,
                                    backgroundColor: 'rgba(245, 158, 11)',
                                    borderColor: 'rgba(245, 158, 11)',
                                    borderWidth: 1
                                },
                                {
                                    label: 'Actual Expenses',
                                    data: actualExpenses,
                                    backgroundColor: 'rgba(239, 68, 68)',
                                    borderColor: 'rgba(239, 68, 68)',
                                    borderWidth: 1
                                }
                            ]
                        },
                        options: {
                            scales: {
                                y: {
                                    max: 3000000,
                                    beginAtZero: true,
                                    // min: 0,
                                    ticks: {
                                        stepSize: 750000
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    display: false
                                    // position: 'bottom',
                                    // labels: {
                                    //     font: {
                                    //         size: 14,
                                    //         weight: 'bold',
                                    //     },
                                    //     color: 'black',
                                    //     padding: 20,
                                    //     boxWidth: 20,
                                    //     boxHeight: 10
                                    // }
                                },
                                tooltip: {
                                    enabled: false, // disable the default tooltip
                                    external: function(context) {
                                        // Tooltip Element
                                        let tooltipEl = document.getElementById('chartjs-tooltip');

                                        // Create element on first render
                                        if (!tooltipEl) {
                                            tooltipEl = document.createElement('div');
                                            tooltipEl.id = 'chartjs-tooltip';
                                            tooltipEl.innerHTML = '<div></div>';
                                            document.body.appendChild(tooltipEl);
                                        }

                                        const tooltipModel = context.tooltip;

                                        // Hide if no tooltip
                                        if (tooltipModel.opacity === 0) {
                                            tooltipEl.style.opacity = 0;
                                            return;
                                        }

                                        // Set Text
                                        if (tooltipModel.body) {
                                            const index = tooltipModel.dataPoints[0].dataIndex;
                                            const month = budgetvsActualMonths[index];
                                            const budgetRevenueValue = budgetRevenue[index];
                                            const actualRevenueValue = actualRevenue[index];
                                            const budgetExpensesValue = budgetExpenses[index];
                                            const actualExpensesValue = actualExpenses[index];

                                            const innerHtml = `
                                       <div style="background: white; border: 1px solid #ccc; padding: 8px; border-radius: 4px;">
                                           <div style="color: black; font-weight: bold; margin-bottom: 4px;">${month}</div>
                                           <div style="color: blue;">Budget Revenue: ${budgetRevenueValue}</div>
                                           <div style="color: green;">Actual Revenue: ${actualRevenueValue}</div>
                                           <div style="color: orange;">Budget Expenses: ${budgetExpensesValue}</div>
                                           <div style="color: red;">Actual Expenses: ${actualExpensesValue}</div>
                                       </div>
                                   `;

                                            tooltipEl.innerHTML = innerHtml;
                                        }

                                        const position = context.chart.canvas.getBoundingClientRect();
                                        tooltipEl.style.opacity = 1;
                                        tooltipEl.style.position = 'absolute';
                                        tooltipEl.style.left = position.left + window.pageXOffset + tooltipModel.caretX +
                                            'px';
                                        tooltipEl.style.top = position.top + window.pageYOffset + tooltipModel.caretY +
                                            'px';
                                        tooltipEl.style.pointerEvents = 'none';
                                        tooltipEl.style.zIndex = 999;
                                    }
                                }
                            },
                            interaction: {
                                mode: 'index',
                                intersect: false
                            }
                        }
                    });
                </script>

                <div class="card">
                    <div class="card-header">
                        <h2>Lap Days Analysis (Assignment to Invoice)</h2>
                    </div>
                    <canvas id="lapDaysChart" width="auto" height="250"></canvas>
                </div>

                <script>
                    const lapDaysChartctx = document.getElementById('lapDaysChart').getContext('2d');
                    const lapDaysMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
                    const avgLapDaysData = [12, 8, 16, 12, 6, 10];
                    const targetLapDaysData = [8, 8, 8, 8, 6, 8];

                    const lapDaysChart = new Chart(lapDaysChartctx, {
                        type: 'bar',
                        data: {
                            labels: lapDaysMonths,
                            datasets: [{
                                    label: 'avgLapDays',
                                    data: avgLapDaysData,
                                    backgroundColor: 'rgba(239, 68, 68)',
                                    borderColor: 'rgba(239, 68, 68)',
                                    borderWidth: 1
                                },
                                {
                                    label: 'targetLapDays',
                                    data: targetLapDaysData,
                                    backgroundColor: 'rgba(16, 185, 129)',
                                    borderColor: 'rgba(16, 185, 129)',
                                    borderWidth: 1
                                }
                            ]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    max: 18,
                                    ticks: {
                                        stepSize: 2
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    enabled: false, // disable the default tooltip
                                    external: function(context) {
                                        // Tooltip Element
                                        let tooltipEl = document.getElementById('chartjs-tooltip');

                                        // Create element on first render
                                        if (!tooltipEl) {
                                            tooltipEl = document.createElement('div');
                                            tooltipEl.id = 'chartjs-tooltip';
                                            tooltipEl.innerHTML = '<div></div>';
                                            document.body.appendChild(tooltipEl);
                                        }

                                        const tooltipModel = context.tooltip;

                                        // Hide if no tooltip
                                        if (tooltipModel.opacity === 0) {
                                            tooltipEl.style.opacity = 0;
                                            return;
                                        }

                                        // Set Text
                                        if (tooltipModel.body) {
                                            const index = tooltipModel.dataPoints[0].dataIndex;
                                            const month = lapDaysMonths[index];
                                            const avgLapDaysDataValue = avgLapDaysData[index];
                                            const targetLapDaysDataValue = targetLapDaysData[index];

                                            const innerHtml = `
                                       <div style="background: white; border: 1px solid #ccc; padding: 8px; border-radius: 4px;">
                                           <div style="color: black; font-weight: bold; margin-bottom: 4px;">${month}</div>
                                           <div style="color: red;">Average Lap Days: ${avgLapDaysDataValue}</div>
                                           <div style="color: green;">Target Lap Days: ${targetLapDaysDataValue}</div>
                                       </div>
                                   `;

                                            tooltipEl.innerHTML = innerHtml;
                                        }

                                        const position = context.chart.canvas.getBoundingClientRect();
                                        tooltipEl.style.opacity = 1;
                                        tooltipEl.style.position = 'absolute';
                                        tooltipEl.style.left = position.left + window.pageXOffset + tooltipModel.caretX +
                                            'px';
                                        tooltipEl.style.top = position.top + window.pageYOffset + tooltipModel.caretY +
                                            'px';
                                        tooltipEl.style.pointerEvents = 'none';
                                        tooltipEl.style.zIndex = 999;
                                    }
                                }
                            },
                            interaction: {
                                mode: 'index',
                                intersect: false
                            }
                        }
                    });
                </script>

                <div class="card">
                    <div class="card-header">
                        <h2>Invoice Due vs Assignment Billing vs Cash Recovery</h2>
                    </div>
                    <canvas id="cashRecovery" width="auto" height="250"></canvas>
                </div>

                <script>
                    const cashRecoveryCtx = document.getElementById('cashRecovery').getContext('2d');

                    const assignmentBilling = [400000, 350000, 350000, 400000, 500000, 700000];
                    const invoicesDue = [100000, 80000, 90000, 120000, 130000, 150000];
                    const cashRecovery = [90000, 60000, 80000, 100000, 110000, 130000];
                    const recoveryRate = [1000, 2000, 3000, 3000, 2000, 1000];
                    // Labels for X-axis (mahine ke naam).
                    const cashRecoveryCtxMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];

                    const cashRecoveryChart = new Chart(cashRecoveryCtx, {
                        type: 'line',
                        data: {
                            labels: cashRecoveryCtxMonths,
                            datasets: [{
                                    label: 'Assignment Billing',
                                    data: assignmentBilling,
                                    borderColor: 'rgba(75, 192, 75, 1)',
                                    backgroundColor: 'rgba(75, 192, 75, 0.2)',
                                    borderWidth: 2,
                                    fill: false
                                },
                                {
                                    label: 'Invoices Due',
                                    data: invoicesDue,
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                    borderWidth: 2,
                                    fill: false
                                },
                                {
                                    label: 'Cash Recovery',
                                    data: cashRecovery,
                                    borderColor: 'rgba(255, 99, 132, 1)',
                                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                    borderWidth: 2,
                                    fill: false
                                },
                                {
                                    label: 'Recovery Rate',
                                    data: recoveryRate,
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                    borderWidth: 2,
                                    fill: false
                                },
                            ]
                        },
                        options: {
                            scales: {
                                y: {
                                    max: 700000,
                                    beginAtZero: true,
                                    // min: 0,
                                    ticks: {
                                        stepSize: 350000
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    enabled: false, // disable the default tooltip
                                    external: function(context) {
                                        // Tooltip Element
                                        let tooltipEl = document.getElementById('chartjs-tooltip');

                                        // Create element on first render
                                        if (!tooltipEl) {
                                            tooltipEl = document.createElement('div');
                                            tooltipEl.id = 'chartjs-tooltip';
                                            tooltipEl.innerHTML = '<div></div>';
                                            document.body.appendChild(tooltipEl);
                                        }

                                        const tooltipModel = context.tooltip;

                                        // Hide if no tooltip
                                        if (tooltipModel.opacity === 0) {
                                            tooltipEl.style.opacity = 0;
                                            return;
                                        }

                                        // Set Text
                                        if (tooltipModel.body) {
                                            const index = tooltipModel.dataPoints[0].dataIndex;
                                            const month = cashRecoveryCtxMonths[index];
                                            const assignmentBillingValue = assignmentBilling[index];
                                            const invoicesDueValue = invoicesDue[index];
                                            const cashRecoveryValue = cashRecovery[index];
                                            const recoveryRateValue = recoveryRate[index];

                                            const innerHtml = `
                                       <div style="background: white; border: 1px solid #ccc; padding: 8px; border-radius: 4px;">
                                           <div style="color: black; font-weight: bold; margin-bottom: 4px;">${month}</div>
                                           <div style="color: blue;">Assignment Billing: ${assignmentBillingValue}</div>
                                           <div style="color: green;">Invoices Due: ${invoicesDueValue}</div>
                                           <div style="color: orange;">Cash Recovery: ${cashRecoveryValue}</div>
                                           <div style="color: red;">Recovery Rate: ${recoveryRateValue}</div>
                                       </div>
                                   `;

                                            tooltipEl.innerHTML = innerHtml;
                                        }

                                        const position = context.chart.canvas.getBoundingClientRect();
                                        tooltipEl.style.opacity = 1;
                                        tooltipEl.style.position = 'absolute';
                                        tooltipEl.style.left = position.left + window.pageXOffset + tooltipModel.caretX +
                                            'px';
                                        tooltipEl.style.top = position.top + window.pageYOffset + tooltipModel.caretY +
                                            'px';
                                        tooltipEl.style.pointerEvents = 'none';
                                        tooltipEl.style.zIndex = 999;
                                    }
                                }

                            },
                            interaction: {
                                mode: 'index',
                                intersect: false
                            }
                        }
                    });
                </script>
            </div>

            <div class="dashboard-card-fullcontent">


                <div class="card">
                    <div class="card-header">
                        <h2>Staff Allocation vs Actual Timesheet Analysis</h2>
                    </div>
                    <canvas id="expenseChart2" width="auto" height="80"></canvas>
                </div>

                <script>
                    const staffAllocationCtx = document.getElementById('expenseChart2').getContext('2d');
                    const allocatedHours = [140000, 110000, 130000, 120000, 120000, 140000];
                    const actualHours = [55000, 60000, 40000, 70000, 75000, 50000];
                    const discrepancy = [55000, 60000, -10000, 70000, 75000, 50000];
                    // Labels for X-axis (mahine ke naam).
                    const staffAllocationMonths = ['Shahid Raza', 'Rahul Kumar', 'Pankaj KUmar', 'Sunny Kumar', 'Azma flaah',
                        'Rahul Rai'
                    ];

                    const expenseChart2 = new Chart(staffAllocationCtx, {
                        type: 'bar',
                        data: {
                            labels: staffAllocationMonths,
                            datasets: [{
                                    label: 'Allocated Hours',
                                    data: allocatedHours,
                                    backgroundColor: 'rgb(59, 130, 246)',
                                    borderColor: 'rgb(59, 130, 246)',
                                    borderWidth: 1 // border width
                                },
                                {
                                    label: 'Actual Hours',
                                    data: actualHours,
                                    backgroundColor: 'rgb(16, 185, 129)',
                                    borderColor: 'rgb(16, 185, 129)',
                                    borderWidth: 1 // border width
                                },
                                {
                                    label: 'Discrepancy',
                                    data: discrepancy,
                                    backgroundColor: 'rgb(239, 68, 68)',
                                    borderColor: 'rgb(239, 68, 68)',
                                    borderWidth: 1 // border width
                                }
                            ]
                        },
                        options: {
                            scales: {
                                // y axis start value from 0
                                y: {
                                    max: 140000,
                                    beginAtZero: true,
                                    // min: 0,
                                    ticks: {
                                        stepSize: 35000
                                    }
                                }
                            },

                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    // Default tooltip disabled
                                    enabled: false,
                                    // custom tooltip using external function.
                                    external: function(context) {
                                        // Tooltip Element
                                        let tooltipEl = document.getElementById('chartjs-tooltip');

                                        // Create element on first render
                                        if (!tooltipEl) {
                                            tooltipEl = document.createElement('div');
                                            tooltipEl.id = 'chartjs-tooltip';
                                            tooltipEl.innerHTML = '<div></div>';
                                            document.body.appendChild(tooltipEl);
                                        }

                                        const tooltipModel = context.tooltip;

                                        // Hide if no tooltip
                                        if (tooltipModel.opacity === 0) {
                                            tooltipEl.style.opacity = 0;
                                            return;
                                        }

                                        // Set Text
                                        if (tooltipModel.body) {
                                            const index = tooltipModel.dataPoints[0].dataIndex;
                                            const month = staffAllocationMonths[index];
                                            const allocatedHoursValue = allocatedHours[index];
                                            const actualHoursValue = actualHours[index];
                                            const discrepancyValue = discrepancy[index];

                                            const innerHtml = `
                        <div style="background: white; border: 1px solid #ccc; padding: 8px; border-radius: 4px;">
                            <div style="color: black; font-weight: bold; margin-bottom: 4px;">${month}</div>
                            <div style="color: blue;">Allocated Hours: ${allocatedHoursValue}</div>
                            <div style="color: green;">Actual Hours: ${actualHoursValue}</div>
                            <div style="color: red;">Discrepancy: ${discrepancyValue}</div>
                        </div>
                  `;

                                            tooltipEl.innerHTML = innerHtml;
                                        }
                                        // exact position of Tooltip set  near by mouse .
                                        const position = context.chart.canvas.getBoundingClientRect();
                                        tooltipEl.style.opacity = 1;
                                        tooltipEl.style.position = 'absolute';
                                        tooltipEl.style.left = position.left + window.pageXOffset + tooltipModel.caretX +
                                            'px';
                                        tooltipEl.style.top = position.top + window.pageYOffset + tooltipModel.caretY +
                                            'px';
                                        tooltipEl.style.pointerEvents = 'none';
                                        tooltipEl.style.zIndex = 999;
                                    }
                                }
                            },
                            interaction: {
                                mode: 'index',
                                intersect: false
                            }
                        }
                    });
                </script>

                <div class="card">
                    <div class="card-header">
                        <h2>Unresolved Tickets - HR, IT & Admin</h2>
                    </div>

                    <div class="table-responsive">
                        {{-- <table class="table  table-hover">
                            <thead>
                                <tr>
                                    <th class="textfixed" style="padding: 17px;">Ticket ID</th>
                                    <th style="padding: 17px;">Department</th>
                                    <th class="textfixed" style="padding: 17px;">Created By</th>
                                    <th style="padding: 17px;">Subject</th>
                                    <th class="textfixed" style="padding: 17px;">Assigned To</th>
                                    <th class="textfixed" style="padding: 17px;">Days Open</th>
                                    <th style="padding: 17px;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ticketDatas as $ticketData)
                                    <tr>
                                        <td class="textfixed" style="padding: 17px;">{{ $ticketData->generateticket_id }}
                                        </td>
                                        <td style="padding: 17px;">
                                            @if ($ticketData->type == 0)
                                                <span class="priority-tag on-track">IT</span>
                                            @elseif ($ticketData->type == 1)
                                                <span class="priority-tag on-track">Finance</span>
                                            @else
                                                <span class="priority-tag delayed"></span>
                                            @endif
                                        </td>
                                        <td class="textfixed" style="padding: 17px;">
                                            {{ $ticketData->createdBy->team_member ?? '' }}</td>
                                        <td class="textfixed" style="padding: 17px;">{{ $ticketData->subject }}</td>
                                        <td class="textfixed" style="padding: 17px;">
                                            {{ $ticketData->partner->team_member ?? '' }}</td>
                                        <td style="padding: 17px;" class="text-success textfixed">
                                            {{ $ticketData->created_at }}
                                        </td>
                                        <td style="padding: 17px;">
                                            @if ($ticketData->status == 0)
                                                <span class="priority-tag on-track textfixed">Open</span>
                                            @elseif($ticketData->status == 1)
                                                <span class="priority-tag on-track textfixed">working</span>
                                            @elseif($ticketData->status == 2)
                                                <span class="priority-tag on-track textfixed">close</span>
                                            @elseif($ticketData->status == 3)
                                                <span class="priority-tag on-track textfixed">Reject</span>
                                            @elseif($ticketData->status == 4)
                                                <span class="priority-tag on-track textfixed">Overdue</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                @foreach ($hrTickets as $hrTicket)
                                    <tr>
                                        <td class="textfixed" style="padding: 17px;">{{ 'N/A' }}
                                        </td>
                                        <td style="padding: 17px;">
                                            @if ($hrTicket->task_type == 4)
                                                <span class="priority-tag on-track">HR</span>
                                            @elseif ($hrTicket->task_type == 1)
                                                <span class="priority-tag on-track">Finance</span>
                                            @else
                                                <span class="priority-tag delayed"></span>
                                            @endif
                                        </td>
                                        <td class="textfixed" style="padding: 17px;">
                                            {{ $hrTicket->createdbyname ?? '' }}</td>

                                        <td class="textfixed" style="padding: 17px;">{{ $hrTicket->taskname ?? '' }}</td>

                                        <td class="textfixed" style="padding: 17px;">
                                            {{ $hrTicket->partnername }}</td>
                                        <td style="padding: 17px;" class="text-success textfixed">
                                            {{ $hrTicket->created_at }}
                                        </td>
                                        <td style="padding: 17px;">
                                            @if ($hrTicket->status == 0)
                                                <span class="priority-tag on-track textfixed">Open</span>
                                            @elseif($hrTicket->status == 1)
                                                <span class="priority-tag on-track textfixed">close</span>
                                            @elseif($hrTicket->status == 2)
                                                <span class="priority-tag on-track textfixed">Request to close</span>
                                            @elseif($hrTicket->status == 3)
                                                <span class="priority-tag on-track textfixed">Overdue</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table> --}}
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="textfixed" style="padding: 17px;">Ticket ID</th>
                                    <th style="padding: 17px;">Department</th>
                                    <th class="textfixed" style="padding: 17px;">Created By</th>
                                    <th style="padding: 17px;">Subject</th>
                                    <th class="textfixed" style="padding: 17px;">Assigned To</th>
                                    <th class="textfixed" style="padding: 17px;">Days Open</th>
                                    <th style="padding: 17px;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allTickets as $ticket)
                                    <tr>
                                        <td class="textfixed" style="padding: 17px;">{{ $ticket['ticket_id'] }}</td>
                                        <td style="padding: 17px;">
                                            <span class="priority-tag on-track">{{ $ticket['department'] }}</span>
                                        </td>
                                        <td class="textfixed" style="padding: 17px;">{{ $ticket['created_by'] }}</td>
                                        <td class="textfixed" style="padding: 17px;">{{ $ticket['subject'] }}</td>
                                        <td class="textfixed" style="padding: 17px;">{{ $ticket['assigned_to'] }}</td>
                                        <td class="text-success textfixed" style="padding: 17px;">
                                            @php
                                                $dueDate = Carbon\Carbon::parse($ticket['created_at']);
                                                $today = Carbon\Carbon::today();
                                                $diffInDays = abs($today->diffInDays($dueDate, false));
                                            @endphp
                                            {{ $diffInDays }}
                                        </td>
                                        <td style="padding: 17px;">
                                            @php
                                                $status = $ticket['status'];
                                            @endphp

                                            @if ($ticket['source'] === 'ticket')
                                                @if ($status == 0)
                                                    <span class="priority-tag on-track textfixed">Open</span>
                                                @elseif($status == 1)
                                                    <span class="priority-tag on-track textfixed">working</span>
                                                @elseif($status == 2)
                                                    <span class="priority-tag on-track textfixed">close</span>
                                                @elseif($status == 3)
                                                    <span class="priority-tag on-track textfixed">Reject</span>
                                                @elseif($status == 4)
                                                    <span class="priority-tag on-track textfixed">Overdue</span>
                                                @endif
                                            @elseif ($ticket['source'] === 'hr')
                                                @if ($status == 0)
                                                    <span class="priority-tag on-track textfixed">Open</span>
                                                @elseif($status == 1)
                                                    <span class="priority-tag on-track textfixed">close</span>
                                                @elseif($status == 2)
                                                    <span class="priority-tag on-track textfixed">Request to close</span>
                                                @elseif($status == 3)
                                                    <span class="priority-tag on-track textfixed">Overdue</span>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h2><i class="fa-solid fa-triangle-exclamation text-danger"></i> High Priority Tasks Pending</h2>
                    </div>

                    <div class="document-progress">
                        @foreach ($highpriorityAssignments as $highpriorityAssignment)
                            @php
                                $dueDate = Carbon\Carbon::parse($highpriorityAssignment->finalassignmentenddate);
                                $today = Carbon\Carbon::today();
                                $diffInDays = $today->diffInDays($dueDate, false);

                                if ($diffInDays < 0) {
                                    $dueText = 'Due: Delayed';
                                    $color = '#8b0000';
                                    $bgColor = '#ff00001f';
                                } elseif ($diffInDays === 0) {
                                    $dueText = 'Due: Today';
                                    $color = '#eb1010';
                                    $bgColor = '#f916161f';
                                } elseif ($diffInDays === 1) {
                                    $dueText = 'Due: Tomorrow';
                                    $color = '#eb1010';
                                    $bgColor = '#f916161f';
                                } elseif ($diffInDays > 1 && $diffInDays <= 5) {
                                    $dueText = "Due: {$diffInDays} days";
                                    $color = '#f97316';
                                    $bgColor = '#f96d1624';
                                } else {
                                    $dueText = "Due: {$diffInDays} days";
                                    $color = '#f9c016';
                                    $bgColor = '#f9cb1629';
                                }
                            @endphp

                            <div class="document-card" style="background-color: {{ $bgColor }};">
                                <div class="ecqr-header" style="margin: 0;">
                                    <div class="ecqr-title">
                                        <h3>{{ $highpriorityAssignment->assignmentname }} -
                                            {{ $highpriorityAssignment->client_name }}</h3>
                                        <p style="margin: 0; color: {{ $color }}">{{ $dueText }}</p>
                                        <p style="margin: 0;">Date: {{ $highpriorityAssignment->finalassignmentenddate }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
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
