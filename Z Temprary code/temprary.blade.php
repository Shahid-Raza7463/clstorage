<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>


    <style>
        .atrdashboard-modern .card {
            border-radius: 12px !important;
            border: 1px solid #e2e8f0 !important;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05) !important;
            background: #ffffff !important;
            margin-bottom: 20px;
        }

        .atrdashboard-modern .card-header {
            background: #ffffff !important;
            border-bottom: 1px solid #f1f5f9 !important;
            padding: 1.25rem !important;
            border-radius: 12px 12px 0 0 !important;
        }

        .atrdashboard-modern .card-header b {
            font-size: 15px;
            font-weight: 700;
            color: #1e293b;
        }

        .text-muted-small {
            font-size: 11px;
            color: #94a3b8;
        }

        .modern-side-panel {
            width: 500px !important;
            border-left: 1px solid #eef2f7 !important;
            box-shadow: -10px 0 30px rgba(0, 0, 0, 0.05) !important;
        }

        .modern-side-panel .offcanvas-header {
            padding: 1.5rem;
            border-bottom: 1px solid #f1f5f9;
        }

        .modern-side-panel .offcanvas-title {
            font-weight: 700;
            color: #1e293b;
            font-size: 1.15rem;
            margin-bottom: 4px;
        }

        .modern-side-panel .offcanvas-subtitle {
            font-size: 0.85rem;
            color: #64748b;
        }

        .modern-side-panel .btn-close {
            background-color: #f8fafc;
            padding: 0.5rem;
            border-radius: 50%;
            opacity: 0.8;
            border: 1px solid #e2e8f0;
        }

        .task-list-card {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid #f1f5f9;
            transition: background 0.2s;
            cursor: pointer;
            position: relative;
        }

        .task-list-card:hover {
            background-color: #f8fafc;
        }

        .task-list-card:hover .task-heading {
            color: #2563eb;
            text-decoration: underline;
        }

        .clickabletext {
            color: #2563eb;
            text-decoration: underline;
            cursor: pointer;
        }

        .task-meta {
            font-size: 0.75rem;
            color: #64748b;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .task-source {
            font-weight: 700;
            color: #2563eb;
        }

        .task-heading {
            font-size: 0.9rem;
            font-weight: 600;
            color: #1e293b;
            line-height: 1.5;
            margin-bottom: 0.75rem;
            display: block;
        }

        .task-footer {
            font-size: 0.8rem;
            color: #64748b;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 0.75rem;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            gap: 4px;
            margin-inline-start: auto;
            margin-top: -2px;
        }

        .status-overdue {
            background: #fff1f2;
            color: #e11d48;
            border: 1px solid #ffe4e6;
        }

        .status-open {
            background: #fffbeb;
            color: #d97706;
            border: 1px solid #fef3c7;
        }

        .status-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
        }

        .task-detail-modal .modal-content {
            border-radius: 16px;
            border: none;
            overflow: hidden;
        }

        .task-detail-modal .modal-header {
            padding: 2rem;
            background: #fff;
            border-bottom: 1px solid #f1f5f9;
            display: block;
        }

        .modal-label-small {
            font-size: 12px;
            color: #94a3b8;
            font-weight: 500;
        }

        .modal-main-title {
            font-size: 24px;
            font-weight: 700;
            color: #1e293b;
            margin-top: 4px;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
            padding: 1.5rem 2rem;
            background: #fcfdfe;
            border-bottom: 1px solid #f1f5f9;
        }

        .grid-item-label {
            font-size: 11px;
            text-transform: uppercase;
            color: #94a3b8;
            font-weight: 700;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .grid-item-value {
            font-size: 14px;
            font-weight: 600;
            color: #1e293b;
        }

        .grid-item-subtext {
            font-size: 12px;
            color: #64748b;
            font-weight: 400;
        }

        .workflow-section {
            padding: 2rem;
            border-bottom: 1px solid #f1f5f9;
        }

        .stepper {
            display: flex;
            justify-content: space-between;
            position: relative;
            padding: 0 1rem;
        }

        .stepper::before {
            content: "";
            position: absolute;
            top: 15px;
            left: 2rem;
            right: 2rem;
            height: 2px;
            background: #f1f5f9;
            z-index: 1;
        }

        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            z-index: 2;
            width: 80px;
            text-align: center;
        }

        .step-circle {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #fff;
            border: 2px solid #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: #94a3b8;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .step.active .step-circle {
            background: #2563eb;
            border-color: #2563eb;
            color: #fff;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }

        .step-label {
            font-size: 10px;
            font-weight: 600;
            color: #64748b;
            line-height: 1.3;
        }

        .step.active .step-label {
            color: #1e293b;
            font-weight: 700;
        }

        .step.completed-step .step-circle {
            background: #16a34a;
            border-color: #16a34a;
            color: #fff;
            box-shadow: 0 0 0 4px rgba(22, 163, 74, 0.12);
        }

        .step.completed-step .step-label {
            color: #166534;
            font-weight: 700;
        }

        .task-content-section {
            padding: 2rem;
            border-bottom: 1px solid #f1f5f9;
        }

        .content-label {
            font-size: 11px;
            text-transform: uppercase;
            color: #94a3b8;
            font-weight: 700;
            letter-spacing: 0.5px;
            margin-bottom: 0.75rem;
        }

        .content-text {
            font-size: 15px;
            color: #334155;
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        .responses-section {
            padding: 2rem;
            background: #fcfdfe;
        }

        .empty-responses {
            padding: 3rem;
            text-align: center;
            color: #94a3b8;
            font-size: 14px;
            background: #fff;
            border: 1px dashed #e2e8f0;
            border-radius: 12px;
            margin-bottom: 1.5rem;
        }

        .response-input-box {
            background: #fff;
            border: 2px solid #2563eb;
            border-radius: 12px;
            overflow: hidden;
        }

        .response-textarea {
            width: 100%;
            border: none;
            padding: 1.25rem;
            font-size: 14px;
            resize: none;
            outline: none;
        }

        .response-actions {
            padding: 0.75rem 1.25rem;
            background: #f8fafc;
            border-top: 1px solid #f1f5f9;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .submit-btn {
            background: #8e99f3;
            color: #fff;
            border: none;
            padding: 8px 20px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .file-attachment-pill {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 6px 10px;
            font-size: 12px;
            color: #334155;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .file-remove-icon {
            color: #ef4444;
            cursor: pointer;
            font-size: 14px;
        }

        .dashboard-table-container {
            background: #fff;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            overflow: hidden;
            margin-bottom: 24px;
        }

        .dashboard-table-header {
            padding: 1.25rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #f1f5f9;
        }

        .dashboard-table-title {
            font-size: 16px;
            font-weight: 700;
            color: #1e293b;
        }

        .view-all-link {
            font-size: 13px;
            color: #2563eb;
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .modern-dashboard-table {
            width: 100%;
            min-width: 1100px;
            border-collapse: collapse;
        }

        .modern-dashboard-table th {
            background: #fcfdfe;
            padding: 12px 24px;
            text-align: left;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            color: #64748b;
            letter-spacing: 0.05em;
            border-bottom: 1px solid #f1f5f9;
        }

        .modern-dashboard-table td {
            padding: 16px 24px;
            font-size: 14px;
            color: #334155;
            border-bottom: 1px solid #f8fafc;
            vertical-align: middle;
        }

        .modern-dashboard-table tr:hover td {
            background-color: #fbfcfe;
        }

        .task-table-scroll {
            max-height: 400px;
            overflow-y: auto;
            overflow-x: auto;
        }

        .task-table-scroll .modern-dashboard-table td:first-child,
        .task-table-scroll .modern-dashboard-table th:first-child {
            white-space: nowrap;
            min-width: 220px;
        }

        .task-table-scroll .text-description-truncate {
            white-space: nowrap;
            min-width: 320px;
            display: inline-block;
        }

        .text-danger-bold {
            color: #ef4444;
            font-weight: 700;
        }

        .text-description-truncate {
            max-width: 400px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    </style>


<div class="col-12 col-md-6 col-print-12 mb-4 {{ isWidgetVisible($dashboardOptions, 'dlrStatus', 'class') }}"
    id="dlrStatus">
    <div class="card" style="border-radius: 15px;">

        <div class="card-header" id="actionable_h3" style="background: white; border-radius: 15px 15px 0 0;">
            <b class="text-capitalize">DRL Status</b>
        </div>
        <div style="position: absolute; top: 10px; right: 10px; z-index: 10; display: flex;">

            <a id="actionable_download3" href="javascript:void(0);"
                onclick="downloadTableAsCSV('actionableList3', 'actionable_report3.csv')">
                <i class="bi bi-download" style="font-size: 1rem;color: #333;" title="Download"></i>
            </a>

            <button class="icon-btn" data-bs-toggle="offcanvas" data-bs-target="#actionableRight"
                aria-controls="offcanvasRight" style="color: #333;" title="Open Details Panel">

                <a href="javascript:void(0);" data-bs-toggle="offcanvas" data-bs-target="#DRLStatuspannel"
                    aria-controls="DRLStatuspannel" class="text-reset">
                    <img src="{{ url('admin/assets/images/export.svg') }}" alt=""
                        style="margin-top:-5px; width:15px;">
                </a>

            </button>

            <!-- Button for grid-8 (default visible) -->

            <button class="icon-btn" id="grid8Btnn3" onclick="toggleCard3('grid81')"
                title="Show Observation Status Pie Chart">
                <i class="ri-pie-chart-2-line" style="font-size: 18px;"></i>
            </button>
            <!-- Button for grid-9 (hidden by default) -->
            <button class="icon-btn" id="grid9Btnn3" onclick="toggleCard3('grid91')" title="Show Table View"
                style="display: none;">
                <i class="icon-grid-8" style="font-size: 15px;"></i>
            </button>

        </div>
        <div class="card-body" id="actionablestatusPieChart3"></div>
        <!-- Test Content (hidden by default) -->
        <div class="card-body" id="testCard3" style="display: none;">
            <div style="overflow-x: auto; overflow-y: auto; height: 400px;">
                <table class="table-responsive table-striped table-condensed reportTable table-bordered table"
                    id="actionableList3">
                    <thead>
                        <tr>
                            <th>Engagement</th>
                            <th>Requirement Title</th>
                            <th>Status</th>
                            <th>Assignee</th>
                            <th>Due Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($drlstatusdata as $drlstatus)
                            @php
                                $status = strtolower(trim($drlstatus->status ?? ''));
                                $style = $openClosed[$status] ?? 'background-color:#E5E7EB; color:#374151;';
                            @endphp
                            <tr>
                                <td style="width: 200px;"><a
                                        href="#">{{ \Illuminate\Support\Str::limit($drlstatus->engagement_name, 35, '...') ?? 'N/A' }}</a>
                                </td>
                                <td>{{ $drlstatus->audit_requirement ?? 'N/A' }}</td>
                                <td> <span class="badge-pill" style="{{ $style }}">
                                        {{ ucfirst($drlstatus->status) }}
                                    </span></td>
                                <td>{{ $drlstatus->assignee_name ?? 'N/A' }}</td>
                                <td>{{ $drlstatus->due_date ?? 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 fw-semibold text-muted">No data
                                    Available</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-end shadow" tabindex="-1" id="ObservationbyStatuspanel"
    style="width: 800px; border-left: none;">
    <div class="offcanvas-header border-bottom py-3 px-4 bg-light">
        <h5 class="offcanvas-title fw-bold" style="color: #1e293b; font-size: 1.1rem;">Observation By Status
            Details
        </h5>
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body" style="padding: 20px;">
        <table class="reportTable w-100">
            <thead>
                <tr>
                    <th>Engagement Name</th>
                    <th>Observation Title</th>
                    <th>Status</th>
                    <th>Risk Grading</th>
                    <th>Owner</th>
                    <th>Due Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($observationbyStatuslist as $observationdata)
                    @php
                        $status = strtolower(trim($observationdata->status ?? ''));
                        $risk = strtolower(trim($observationdata->risk_grading ?? ''));

                        $statusStyle = $statusStyles[$status] ?? 'background-color:#E5E7EB; color:#374151;';
                        $riskStyle = $riskStyles[$risk] ?? 'background-color:#E5E7EB; color:#374151;';
                    @endphp
                    <tr>
                        <td style="font-size: 12px; padding: 12px 10px !important;">
                            <a href="#">
                                {{ \Illuminate\Support\Str::limit($observationdata->engagement_name, 35, '...') ?? 'N/A' }}
                            </a>
                        </td>

                        <td style="font-size: 12px; padding: 12px 10px !important;">
                            {{ $observationdata->name ?? 'N/A' }}
                        </td>

                        <td style="font-size: 12px; padding: 12px 10px !important;">
                            <span class="badge"
                                style="{{ $statusStyle }} padding: 6px 12px; font-weight: 500; font-size: 11px;">
                                {{ ucfirst($observationdata->status) }}
                            </span>
                        </td>

                        <td style="font-size: 12px; padding: 12px 10px !important;">
                            <span class="badge"
                                style="{{ $riskStyle }} padding: 6px 12px; font-weight: 500; font-size: 11px;">
                                {{ ucfirst($observationdata->risk_grading) }}
                            </span>
                        </td>

                        <td style="font-size: 12px; padding: 12px 10px !important;">
                            {{ $observationdata->owner_name ?? 'N/A' }}
                        </td>

                        <td style="font-size: 12px; padding: 12px 10px !important;">
                            {{ $observationdata->due_date ?? 'N/A' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 fw-semibold text-muted">
                            No data Available
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>



{{-- regarding npci --}}

<style>
    .sub-obs-card {
        background: #ffffff;
        border: 1px solid rgba(0, 0, 0, 0.05);
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
    }

    .sub-obs-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .sub-obs-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 700;
        color: #1e293b;
        font-size: 15px;
    }

    .status-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
    }

    .status-dot-open {
        background-color: #3b82f6;
    }

    .status-dot-closed {
        background-color: #64748b;
    }

    .sub-obs-count {
        font-size: 24px;
        font-weight: 800;
        color: #1e293b;
    }

    .sub-obs-progress-container {
        margin-bottom: 15px;
    }

    .sub-obs-progress-bar {
        height: 8px;
        background-color: #f1f5f9;
        border-radius: 10px;
        position: relative;
        margin-bottom: 8px;
        overflow: hidden;
    }

    .sub-obs-progress-fill {
        height: 100%;
        border-radius: 10px;
    }

    .fill-open {
        background-color: #3b82f6;
        width: 62.5%;
    }

    .fill-closed {
        background-color: #64748b;
        width: 37.5%;
    }

    .sub-obs-percentage {
        text-align: right;
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
    }

    .recent-sub-obs-label {
        font-size: 13px;
        font-weight: 600;
        color: #94a3b8;
        margin-bottom: 10px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .recent-sub-obs-list {
        list-style: disc;
        padding-left: 20px;
        margin: 0;
    }

    .recent-sub-obs-list li {
        font-size: 13px;
        color: #475569;
        margin-bottom: 6px;
    }
</style>


<div class="offcanvas offcanvas-end shadow" tabindex="-1" id="EngagementStageTracker"
    style="width: 400px; border-left: none;">
    <div class="offcanvas-header border-bottom py-3 px-4 bg-light">
        <h5 class="offcanvas-title fw-bold" style="color: #1e293b; font-size: 1.1rem;">Sub-observation Status Details
        </h5>
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body" style="padding: 20px; background-color: #f8fafc;">
        <!-- Open Observations Card -->
        <div class="sub-obs-card">
            <div class="sub-obs-header">
                <div class="sub-obs-title">
                    <div class="status-dot status-dot-open"></div>
                    <span>Open</span>
                </div>
                <div class="sub-obs-count">75</div>
            </div>
            <div class="sub-obs-progress-container">
                <div class="sub-obs-progress-bar">
                    <div class="sub-obs-progress-fill fill-open"></div>
                </div>
                <div class="sub-obs-percentage">62.5%</div>
            </div>
            <div>
                <div class="recent-sub-obs-label">Recent sub-observations</div>
                <ul class="recent-sub-obs-list">
                    <li>Sub-observation A - Open</li>
                    <li>Sub-observation B - Open</li>
                    <li>Sub-observation C - Open</li>
                </ul>
            </div>
        </div>

        <!-- Closed Observations Card -->
        <div class="sub-obs-card">
            <div class="sub-obs-header">
                <div class="sub-obs-title">
                    <div class="status-dot status-dot-closed"></div>
                    <span>Closed</span>
                </div>
                <div class="sub-obs-count">45</div>
            </div>
            <div class="sub-obs-progress-container">
                <div class="sub-obs-progress-bar">
                    <div class="sub-obs-progress-fill fill-closed"></div>
                </div>
                <div class="sub-obs-percentage">37.5%</div>
            </div>
            <div>
                <div class="recent-sub-obs-label">Recent sub-observations</div>
                <ul class="recent-sub-obs-list">
                    <li>Sub-observation A - Closed</li>
                    <li>Sub-observation B - Closed</li>
                    <li>Sub-observation C - Closed</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-end shadow" tabindex="-1" id="subObsStatusOffcanvas"
    style="width: 400px; border-left: none;">
    <div class="offcanvas-header border-bottom py-3 px-4 bg-light">
        <h5 class="offcanvas-title fw-bold" style="color: #1e293b; font-size: 1.1rem;">Sub-observation Status Details
        </h5>
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="offcanvas"
            aria-label="Close"></button>
    </div>
    @php
        $subObsStatusGrouped = $subobservationbyStatus->groupBy(function ($item) {
            return strtolower($item->status);
        });

        // counts
        $openCount = $subObsStatusGrouped->get('open', collect())->count();
        $closedCount = $subObsStatusGrouped->get('close', collect())->count();

        $total = $openCount + $closedCount;

        // percentage
        $openPercent = $total ? round(($openCount / $total) * 100, 1) : 0;
        $closedPercent = $total ? round(($closedCount / $total) * 100, 1) : 0;
    @endphp
    <div class="offcanvas-body" style="padding: 20px; background-color: #f8fafc;">
        <!-- Open Observations Card -->
        <div class="sub-obs-card">
            <div class="sub-obs-header">
                <div class="sub-obs-title">
                    <div class="status-dot status-dot-open"></div>
                    <span>Open</span>
                </div>
                <div class="sub-obs-count">{{ $openCount }}</div>
            </div>

            <div class="sub-obs-progress-container">
                <div class="sub-obs-progress-bar">
                    <div class="sub-obs-progress-fill fill-open" style="width: {{ $openPercent }}%"></div>
                </div>
                <div class="sub-obs-percentage">{{ $openPercent }}%</div>
            </div>

            <div>
                <div class="recent-sub-obs-label">Recent sub-observations</div>
                <ul class="recent-sub-obs-list">
                    @foreach ($subObsStatusGrouped->get('open', collect())->take(3) as $item)
                        <li>{{ $item->name }} - Open</li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Closed Observations Card -->
        <div class="sub-obs-card">
            <div class="sub-obs-header">
                <div class="sub-obs-title">
                    <div class="status-dot status-dot-closed"></div>
                    <span>Closed</span>
                </div>
                <div class="sub-obs-count">{{ $closedCount }}</div>
            </div>

            <div class="sub-obs-progress-container">
                <div class="sub-obs-progress-bar">
                    <div class="sub-obs-progress-fill fill-closed" style="width: {{ $closedPercent }}%"></div>
                </div>
                <div class="sub-obs-percentage">{{ $closedPercent }}%</div>
            </div>

            <div>
                <div class="recent-sub-obs-label">Recent sub-observations</div>
                <ul class="recent-sub-obs-list">
                    @foreach ($subObsStatusGrouped->get('close', collect())->take(3) as $item)
                        <li>{{ $item->name }} - Closed</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-end shadow" tabindex="-1" id="subObsStatusOffcanvas"
    style="width: 400px; border-left: none;">
    <div class="offcanvas-header border-bottom py-3 px-4 bg-light">
        <h5 class="offcanvas-title fw-bold" style="color: #1e293b; font-size: 1.1rem;">Sub-observation Status Details
        </h5>
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="offcanvas"
            aria-label="Close"></button>
    </div>
    <div class="offcanvas-body" style="padding: 20px; background-color: #f8fafc;">
        <!-- Open Observations Card -->
        <div class="sub-obs-card">
            <div class="sub-obs-header">
                <div class="sub-obs-title">
                    <div class="status-dot status-dot-open"></div>
                    <span>Open</span>
                </div>
                <div class="sub-obs-count">75</div>
            </div>
            <div class="sub-obs-progress-container">
                <div class="sub-obs-progress-bar">
                    <div class="sub-obs-progress-fill fill-open"></div>
                </div>
                <div class="sub-obs-percentage">62.5%</div>
            </div>
            <div>
                <div class="recent-sub-obs-label">Recent sub-observations</div>
                <ul class="recent-sub-obs-list">
                    <li>Sub-observation A - Open</li>
                    <li>Sub-observation B - Open</li>
                    <li>Sub-observation C - Open</li>
                </ul>
            </div>
        </div>

        <!-- Closed Observations Card -->
        <div class="sub-obs-card">
            <div class="sub-obs-header">
                <div class="sub-obs-title">
                    <div class="status-dot status-dot-closed"></div>
                    <span>Closed</span>
                </div>
                <div class="sub-obs-count">45</div>
            </div>
            <div class="sub-obs-progress-container">
                <div class="sub-obs-progress-bar">
                    <div class="sub-obs-progress-fill fill-closed"></div>
                </div>
                <div class="sub-obs-percentage">37.5%</div>
            </div>
            <div>
                <div class="recent-sub-obs-label">Recent sub-observations</div>
                <ul class="recent-sub-obs-list">
                    <li>Sub-observation A - Closed</li>
                    <li>Sub-observation B - Closed</li>
                    <li>Sub-observation C - Closed</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-end shadow" tabindex="-1" id="subObsStatusOffcanvas"
    style="width: 400px; border-left: none;">
    <div class="offcanvas-header border-bottom py-3 px-4 bg-light">
        <h5 class="offcanvas-title fw-bold" style="color: #1e293b; font-size: 1.1rem;">Sub-observation Status Details
        </h5>
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="offcanvas"
            aria-label="Close"></button>
    </div>
    <div class="offcanvas-body" style="padding: 20px; background-color: #f8fafc;">
        <!-- Open Observations Card -->
        <div class="sub-obs-card">
            <div class="sub-obs-header">
                <div class="sub-obs-title">
                    <div class="status-dot status-dot-open"></div>
                    <span>Open</span>
                </div>
                <div class="sub-obs-count">75</div>
            </div>
            <div class="sub-obs-progress-container">
                <div class="sub-obs-progress-bar">
                    <div class="sub-obs-progress-fill fill-open"></div>
                </div>
                <div class="sub-obs-percentage">62.5%</div>
            </div>
            <div>
                <div class="recent-sub-obs-label">Recent sub-observations</div>
                <ul class="recent-sub-obs-list">
                    <li>Sub-observation A - Open</li>
                    <li>Sub-observation B - Open</li>
                    <li>Sub-observation C - Open</li>
                </ul>
            </div>
        </div>

        <!-- Closed Observations Card -->
        <div class="sub-obs-card">
            <div class="sub-obs-header">
                <div class="sub-obs-title">
                    <div class="status-dot status-dot-closed"></div>
                    <span>Closed</span>
                </div>
                <div class="sub-obs-count">45</div>
            </div>
            <div class="sub-obs-progress-container">
                <div class="sub-obs-progress-bar">
                    <div class="sub-obs-progress-fill fill-closed"></div>
                </div>
                <div class="sub-obs-percentage">37.5%</div>
            </div>
            <div>
                <div class="recent-sub-obs-label">Recent sub-observations</div>
                <ul class="recent-sub-obs-list">
                    <li>Sub-observation A - Closed</li>
                    <li>Sub-observation B - Closed</li>
                    <li>Sub-observation C - Closed</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-end shadow" tabindex="-1" id="subObsStatusOffcanvas"
    style="width: 400px; border-left: none;">
    <div class="offcanvas-header border-bottom py-3 px-4 bg-light">
        <h5 class="offcanvas-title fw-bold" style="color: #1e293b; font-size: 1.1rem;">Sub-observation Status Details
        </h5>
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="offcanvas"
            aria-label="Close"></button>
    </div>
    @php
        $subObsStatusGrouped = $subobservationbyStatus->groupBy(function ($item) {
            return strtolower($item->status);
        });

        // counts
        $openCount = $subObsStatusGrouped->get('open', collect())->count();
        $closedCount = $subObsStatusGrouped->get('close', collect())->count();

        $total = $openCount + $closedCount;

        // percentage
        $openPercent = $total ? round(($openCount / $total) * 100, 1) : 0;
        $closedPercent = $total ? round(($closedCount / $total) * 100, 1) : 0;
    @endphp
    <div class="offcanvas-body" style="padding: 20px; background-color: #f8fafc;">
        <!-- Open Observations Card -->
        <div class="sub-obs-card">
            <div class="sub-obs-header">
                <div class="sub-obs-title">
                    <div class="status-dot status-dot-open"></div>
                    <span>Open</span>
                </div>
                <div class="sub-obs-count">{{ $openCount }}</div>
            </div>

            <div class="sub-obs-progress-container">
                <div class="sub-obs-progress-bar">
                    <div class="sub-obs-progress-fill fill-open" style="width: {{ $openPercent }}%"></div>
                </div>
                <div class="sub-obs-percentage">{{ $openPercent }}%</div>
            </div>

            <div>
                <div class="recent-sub-obs-label">Recent sub-observations</div>
                <ul class="recent-sub-obs-list">
                    @foreach ($subObsStatusGrouped->get('open', collect())->take(3) as $item)
                        <li>{{ $item->name }} - Open</li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Closed Observations Card -->
        <div class="sub-obs-card">
            <div class="sub-obs-header">
                <div class="sub-obs-title">
                    <div class="status-dot status-dot-closed"></div>
                    <span>Closed</span>
                </div>
                <div class="sub-obs-count">{{ $closedCount }}</div>
            </div>

            <div class="sub-obs-progress-container">
                <div class="sub-obs-progress-bar">
                    <div class="sub-obs-progress-fill fill-closed" style="width: {{ $closedPercent }}%"></div>
                </div>
                <div class="sub-obs-percentage">{{ $closedPercent }}%</div>
            </div>

            <div>
                <div class="recent-sub-obs-label">Recent sub-observations</div>
                <ul class="recent-sub-obs-list">
                    @foreach ($subObsStatusGrouped->get('close', collect())->take(3) as $item)
                        <li>{{ $item->name }} - Closed</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
{{-- regarding npci --}}




@empty
<tr style="background-color: #f8fafc; height: 200px;">
    <td colspan="7" class="text-center py-4 text-muted">No data available</td>
</tr>
@endforelse

->whereIn('status', ['open', 'closed', 'final observation']);

<div class="offcanvas offcanvas-end shadow" tabindex="-1" id="riskLevelOffcanvas"
    style="width: 800px; border-left: none;">
    <div class="offcanvas-header border-bottom py-3 px-4 bg-light">
        <h5 class="offcanvas-title fw-bold" style="color: #1e293b; font-size: 1.1rem;">Risk Level Details</h5>
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="offcanvas"
            aria-label="Close"></button>
    </div>
    <div class="offcanvas-body" style="padding: 20px;">
        <table class="reportTable w-100">
            <thead>
                <tr>
                    <th>Engagement</th>
                    <th>Observation Title</th>
                    <th>Risk Grading</th>
                    <th>Due Date</th>
                    <th>Owner</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($byRiskLevel as $data)
                    @php
                        $status = strtolower(trim($data->status ?? ''));
                        $risk = strtolower(trim($data->risk_grading ?? ''));

                        $statusStyle = $statusStyles[$status] ?? 'background-color:#e5e7eb; color:#374151;';
                        $riskStyle = $riskStyles[$risk] ?? 'background-color:#e5e7eb; color:#374151;';
                    @endphp

                    <tr>
                        <td>
                            <a href="#" style="font-size: 14px;">
                                {{ \Illuminate\Support\Str::limit($data->engagement_name, 35, '...') ?? 'N/A' }}
                            </a>
                        </td>

                        <td>
                            <a href="#" style="font-size: 14px;">
                                {{ $data->name ?? 'N/A' }}
                            </a>
                        </td>

                        <td>
                            <span class="badge" style="{{ $riskStyle }}">
                                {{ ucfirst($data->risk_grading) }}
                            </span>
                        </td>

                        <td style="font-size: 13px; white-space: nowrap;">
                            {{ $data->due_date ?? 'N/A' }}
                        </td>

                        <td style="font-size: 13px;">
                            {{ $data->owner_name ?? 'N/A' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@foreach ($subobservationbyStatus as $subobservation)
    @php
        $status = strtolower(trim($subobservation->status ?? ''));

        $statusStyle = $openClosed[$status] ?? 'background-color:#e5e7eb; color:#374151;';

    @endphp
    <tr>
        <td><a href="#"
                style="font-size: 12px; font-weight: 500;">{{ \Illuminate\Support\Str::limit($subobservation->observations_name, 35, '...') ?? 'N/A' }}</a>
        </td>

        <td><a href="#" style="font-size: 12px; font-weight: 500;">{{ $subobservation->name ?? 'N/A' }}</a>
        </td>

        <td style="font-size: 12px; padding: 12px 10px !important;">
            {{ $subobservation->owner_name ?? 'N/A' }}</td>
        <td>
            <span class="badge" style="{{ $statusStyle }} padding: 6px 12px; font-weight: 500; font-size: 11px;">
                {{ ucfirst($subobservation->status) }}
            </span>
        </td>

        <td style="font-size: 12px; color: #64748b; padding: 12px 10px !important;">
            {{ $subobservation->due_date ?? 'N/A' }}</td>

        <td class="text-center" style="padding: 12px 10px !important;">
            @php
                $dueDate = Carbon\Carbon::parse($subobservation->due_date);
                $today = Carbon\Carbon::today();
                $diffInDays = $today->diffInDays($dueDate);
                if ($today->greaterThan($dueDate)) {
                    $diffInDays += 1; // Add 1 to include the start day when due date is past
                }
            @endphp

            <div
                style="background-color: #fee2e2; color: #ef4444; width: 36px; height: 36px; border-radius: 50%; display: inline-flex; flex-direction: column; align-items: center; justify-content: center; font-size: 10px; font-weight: 600; line-height: 1.1;">
                <span> {{ $diffInDays }}</span>
                <span style="font-size: 8px;">days</span>
            </div>
        </td>
    </tr>
@endforeach

@foreach ($overdueObservations as $overdueObservation)
    @php
        $status = strtolower(trim($overdueObservation->status ?? ''));
        $risk = strtolower(trim($overdueObservation->risk_grading ?? ''));

        $statusStyle = $statusStyles[$status] ?? 'background-color:#e5e7eb; color:#374151;';
        $riskStyle = $riskStyles[$risk] ?? 'background-color:#e5e7eb; color:#374151;';
    @endphp
    <tr>
        <td><a href="#"
                style="font-size: 12px; font-weight: 500;">{{ \Illuminate\Support\Str::limit($overdueObservation->engagement_name, 35, '...') ?? 'N/A' }}</a>
        </td>

        <td><a href="#" style="font-size: 12px; font-weight: 500;">{{ $overdueObservation->name ?? 'N/A' }}</a>
        </td>



        <td>
            <span class="badge" style="{{ $statusStyle }} padding: 6px 12px; font-weight: 500; font-size: 11px;">
                {{ ucfirst($overdueObservation->status) }}
            </span>
        </td>

        <td>
            <span class="badge" style="{{ $riskStyle }} padding: 6px 12px; font-weight: 500; font-size: 11px;">
                {{ ucfirst($overdueObservation->risk_grading) }}
            </span>
        </td>
        <td style="font-size: 12px; padding: 12px 10px !important;">
            {{ $overdueObservation->owner_name ?? 'N/A' }}</td>
        <td style="font-size: 12px; color: #64748b; padding: 12px 10px !important;">
            {{ $overdueObservation->due_date ?? 'N/A' }}</td>

        <td class="text-center" style="padding: 12px 10px !important;">
            @php
                $dueDate = Carbon\Carbon::parse($overdueObservation->due_date);
                $today = Carbon\Carbon::today();
                $diffInDays = $today->diffInDays($dueDate);
                if ($today->greaterThan($dueDate)) {
                    $diffInDays += 1; // Add 1 to include the start day when due date is past
                }
            @endphp

            <div
                style="background-color: #fee2e2; color: #ef4444; width: 36px; height: 36px; border-radius: 50%; display: inline-flex; flex-direction: column; align-items: center; justify-content: center; font-size: 10px; font-weight: 600; line-height: 1.1;">
                <span> {{ $diffInDays }}</span>
                <span style="font-size: 8px;">days</span>
            </div>
        </td>
    </tr>
@endforeach

@php
    $yearNow = (int) date('Y');
    $monthNow = (int) date('m');
    $startYear = $monthNow < 4 ? $yearNow - 1 : $yearNow;
    $currentRoute = Route::currentRouteName();
@endphp

<style>
    .audit-filter-card {
        border-radius: 8px;
        border: 1px solid #e2e8f0 !important;
        box-shadow: none;
        margin-bottom: 20px;
    }

    .audit-filter-card .card-header {
        background-color: #fff;
        border-bottom: 1px solid #e2e8f0;
        padding: 10px 15px;
    }

    .audit-filter-card .vikalp-input {
        background-color: #ffffff !important;
        border: 1px solid #d1d5db !important;
        color: #64748b !important;
        font-size: 13px;
        border-radius: 4px !important;
        height: 38px;
        padding: 0 12px;
        transition: all 0.2s ease;
        text-align: left;
    }

    .audit-filter-card .vikalp-input:hover {
        border-color: #9ca3af !important;
    }

    .btn-apply-filter {
        background-color: #4285f4;
        border: none;
        font-weight: 500;
        font-size: 13px;
        height: 38px;
        padding: 0 15px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        gap: 6px;
        color: #fff;
    }

    .btn-apply-filter:hover {
        background-color: #3b71ca;
    }

    .btn-reset-filter {
        background-color: #6b7280;
        border: none;
        font-weight: 500;
        font-size: 13px;
        height: 38px;
        padding: 0 15px;
        border-radius: 6px;
        color: #fff;
    }

    .btn-reset-filter:hover {
        background-color: #4b5563;
    }

    #auditAccordionArrow {
        transition: transform 0.3s ease;
        color: #64748b;
        cursor: pointer;
        padding: 5px;
    }

    .audit-filter-item {
        flex: 1;
        min-width: 140px;
    }
</style>

<div class="card audit-filter-card" id="cardFilter" data-url="{{ route($currentRoute) }}">
    <div class="card-header">
        <h6 class="mb-0 fw-bold" style="font-size: 14px; color: #334155;">Filters</h6>
    </div>
    <div class="card-body p-3">
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <!-- Row 1 Filters -->
            <div class="audit-filter-item">
                <div class="vikalp-x" data-multiple="true" data-placeholder="-- Financial Year --">
                    <select name="financial_year" class="chartFilter dt-filter-item d-none" multiple></select>
                    <button class="btn dropdown-toggle vikalp-input w-100" type="button" data-bs-toggle="dropdown"
                        data-bs-auto-close="outside" aria-expanded="false">
                        -- Financial Year --
                    </button>
                    <ul class="dropdown-menu w-100 shadow border-0" style="max-height: 250px; overflow-y: auto;">
                        <li class="p-2 sticky-top bg-white border-bottom"><input type="text"
                                class="form-control form-control-sm vikalp-search" placeholder="Search..."></li>
                        @for ($i = 0; $i < 5; $i++)
                            @php
                                $year = $startYear - $i;
                                $financialYear = $year . '-' . ($year + 1);
                            @endphp
                            <li class="vikalp-option"><input type="checkbox" class="vikalp-checkbox"
                                    id=""><a class="dropdown-item" href="#"
                                    data-value="{{ $financialYear }}">{{ $financialYear }}</a></li>
                        @endfor
                    </ul>
                </div>
            </div>

            <<<<<<< HEAD <div class="audit-filter-item">
                <div class="vikalp-x" data-multiple="true" data-placeholder="-- Quarter --">
                    <select name="quarter1" class="chartFilter dt-filter-item d-none" multiple></select>
                    <button class="btn dropdown-toggle vikalp-input w-100" type="button" data-bs-toggle="dropdown"
                        data-bs-auto-close="outside" aria-expanded="false">
                        -- Quarter --
                    </button>
                    <ul class="dropdown-menu w-100 shadow border-0" style="max-height: 250px; overflow-y: auto;">
                        <li class="p-2 sticky-top bg-white border-bottom"><input type="text"
                                class="form-control form-control-sm vikalp-search" placeholder="Search..."></li>
                        <li class="vikalp-option"><input type="checkbox" class="vikalp-checkbox"><a
                                class="dropdown-item" href="#" data-value="Q1">Q1</a></li>
                        <li class="vikalp-option"><input type="checkbox" class="vikalp-checkbox"><a
                                class="dropdown-item" href="#" data-value="Q2">Q2</a></li>
                        <li class="vikalp-option"><input type="checkbox" class="vikalp-checkbox"><a
                                class="dropdown-item" href="#" data-value="Q3">Q3</a></li>
                        <li class="vikalp-option"><input type="checkbox" class="vikalp-checkbox"><a
                                class="dropdown-item" href="#" data-value="Q4">Q4</a></li>
                    </ul>
                </div>
        </div>

        <div class="audit-filter-item">
            <div class="vikalp-x" data-multiple="true" data-placeholder="-- Audit Plan --">
                <select name="risk_rating11" class="chartFilter dt-filter-item d-none" multiple></select>
                <button class="btn dropdown-toggle vikalp-input w-100" type="button" data-bs-toggle="dropdown"
                    data-bs-auto-close="outside" aria-expanded="false">
                    -- Audit Plan --
                </button>
                <ul class="dropdown-menu w-100 shadow border-0" style="max-height: 250px; overflow-y: auto;">
                    <li class="p-2 sticky-top bg-white border-bottom"><input type="text"
                            class="form-control form-control-sm vikalp-search" placeholder="Search..."></li>
                </ul>
            </div>
            =======
            <div class="filter-card mb-3">
                <div class="vikalp-x" data-multiple="true" data-placeholder="-- Risk Rating --">
                    <select name="risk_rating11" class="chartFilter dt-filter-item" multiple></select>
                    <button class="btn btn-light dropdown-toggle vikalp-input" type="button"
                        data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                        -- Audit Plan --
                    </button>
                    <ul class="dropdown-menu w-100">
                        <li class="p-2">
                            <input type="text" class="form-control vikalp-search" placeholder="Search...">
                        </li>
                    </ul>
                    >>>>>>> 4bffe2a0 (ATR dashboard 4 section complted")
                </div>

                <div class="audit-filter-item">
                    <div class="vikalp-x" data-multiple="true" data-placeholder="-- Engagement --">
                        <select name="engagementName" id="engagementName" class="chartFilter dt-filter-item d-none"
                            multiple></select>
                        <button class="btn dropdown-toggle vikalp-input w-100" type="button"
                            data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                            -- Engagement --
                        </button>
                        <ul class="dropdown-menu w-100 shadow border-0" style="max-height: 250px; overflow-y: auto;">
                            <li class="p-2 sticky-top bg-white border-bottom"><input type="text"
                                    class="form-control form-control-sm vikalp-search" placeholder="Search..."></li>
                            @foreach ($filters['teamname'] as $teamname)
                                <li class="vikalp-option"><input type="checkbox" class="vikalp-checkbox"
                                        id=""><a class="dropdown-item" href="#"
                                        data-value="{{ $engagementlist->name }}">{{ Str::ucfirst($engagementlist->name ?? '') }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="audit-filter-item">
                    <div class="vikalp-x" data-multiple="true" data-placeholder="-- Engagement Status --">
                        <select name="engagementStatus" data-filter="observation_status"
                            class="chartFilter dt-filter-item d-none" multiple></select>
                        <button class="btn dropdown-toggle vikalp-input w-100" type="button"
                            data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                            -- Engagement Status --
                        </button>
                        <ul class="dropdown-menu w-100 shadow border-0" style="max-height: 250px; overflow-y: auto;">
                            <li class="p-2 sticky-top bg-white border-bottom"><input type="text"
                                    class="form-control form-control-sm vikalp-search" placeholder="Search..."></li>
                            <li class="vikalp-option"><input type="checkbox" class="vikalp-checkbox"><a
                                    class="dropdown-item" href="#" data-value="planned">Planned</a></li>
                            <li class="vikalp-option"><input type="checkbox" class="vikalp-checkbox"><a
                                    class="dropdown-item" href="#" data-value="in progress">In Progress</a>
                            </li>
                            <li class="vikalp-option"><input type="checkbox" class="vikalp-checkbox"><a
                                    class="dropdown-item" href="#" data-value="draft report">Draft Report</a>
                            </li>
                            <li class="vikalp-option"><input type="checkbox" class="vikalp-checkbox"><a
                                    class="dropdown-item" href="#" data-value="completed">Completed</a></li>
                        </ul>
                    </div>
                </div>

                <button type="button" class="btn btn-apply-filter" id="applyFilterBtn">
                    <i class="ri-filter-3-line"></i> Apply
                </button>
                <button type="button" class="btn btn-reset-filter" id="resetFilters">
                    Reset
                </button>

                <div class="ms-1">
                    <i class="ri-arrow-down-s-line fs-5" id="auditAccordionArrow" data-bs-toggle="collapse"
                        data-bs-target="#auditMoreFilters"></i>
                </div>
            </div>

            <div class="collapse" id="auditMoreFilters">
                <div class="d-flex align-items-center gap-2 flex-wrap mt-3 pt-3 border-top">
                    <div class="audit-filter-item">
                        <div class="vikalp-x" data-multiple="true" data-placeholder="-- Observation Status --">
                            <select name="observationStatus" data-filter="observation_status"
                                class="chartFilter dt-filter-item d-none" multiple></select>
                            <button class="btn dropdown-toggle vikalp-input w-100" type="button"
                                data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                -- Observation Status --
                            </button>
                            <ul class="dropdown-menu w-100 shadow border-0"
                                style="max-height: 250px; overflow-y: auto;">
                                <li class="p-2 sticky-top bg-white border-bottom"><input type="text"
                                        class="form-control form-control-sm vikalp-search" placeholder="Search...">
                                </li>
                                <li class="vikalp-option"><input type="checkbox" class="vikalp-checkbox"><a
                                        class="dropdown-item" href="#" data-value="query">Query</a></li>
                                <li class="vikalp-option"><input type="checkbox" class="vikalp-checkbox"><a
                                        class="dropdown-item" href="#" data-value="draft observation">Draft
                                        observation</a></li>
                                <li class="vikalp-option"><input type="checkbox" class="vikalp-checkbox"><a
                                        class="dropdown-item" href="#" data-value="final observation">Final
                                        observation</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="audit-filter-item">
                        <div class="vikalp-x" data-multiple="true" data-placeholder="-- DRL Status --">
                            <select name="drlStatus" data-filter="observation_status"
                                class="chartFilter dt-filter-item d-none" multiple></select>
                            <button class="btn dropdown-toggle vikalp-input w-100" type="button"
                                data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                -- DRL Status --
                            </button>
                            <ul class="dropdown-menu w-100 shadow border-0"
                                style="max-height: 250px; overflow-y: auto;">
                                <li class="p-2 sticky-top bg-white border-bottom"><input type="text"
                                        class="form-control form-control-sm vikalp-search" placeholder="Search...">
                                </li>
                                <li class="vikalp-option"><input type="checkbox" class="vikalp-checkbox"><a
                                        class="dropdown-item" href="#" data-value="open">Open</a></li>
                                <li class="vikalp-option"><input type="checkbox" class="vikalp-checkbox"><a
                                        class="dropdown-item" href="#" data-value="close">Close</a></li>
                            </ul>
                        </div>
                    </div>
                    <div style="flex: 2;"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('applyFilterBtn').addEventListener('click', function() {
            let params = new URLSearchParams();
            document.querySelectorAll('.vikalp-x').forEach(function(wrapper) {
                let select = wrapper.querySelector('select');
                let name = select.name;
                wrapper.querySelectorAll('.vikalp-checkbox:checked').forEach(function(cb) {
                    let anchor = cb.nextElementSibling;
                    if (anchor && anchor.tagName === 'A') {
                        let value = anchor.getAttribute('data-value');
                        if (value) {
                            params.append(name + '[]', value);
                        }
                    }
                });
            });
            window.location.href = window.location.pathname + '?' + params.toString();
        });

        document.getElementById('resetFilters').addEventListener('click', function() {
            window.location.href = window.location.pathname;
        });

        document.addEventListener("DOMContentLoaded", function() {
            const urlParams = new URLSearchParams(window.location.search);
            document.querySelectorAll('.vikalp-x').forEach(function(wrapper) {
                let select = wrapper.querySelector('select');
                let name = select.name;
                let values = urlParams.getAll(name + '[]');
                if (values.length > 0) {
                    let selectedText = [];
                    wrapper.querySelectorAll('.vikalp-option').forEach(function(option) {
                        let cb = option.querySelector('.vikalp-checkbox');
                        let anchor = option.querySelector('a');
                        let value = anchor.getAttribute('data-value');
                        let text = anchor.textContent.trim();
                        if (values.includes(value)) {
                            cb.checked = true;
                            selectedText.push(text);
                        }
                    });
                    let btn = wrapper.querySelector('.vikalp-input');
                    if (selectedText.length > 0) {
                        btn.textContent = selectedText.join(', ');
                    }
                }
            });

            $('#auditMoreFilters').on('show.bs.collapse', function() {
                $('#auditAccordionArrow').css('transform', 'rotate(180deg)');
            }).on('hide.bs.collapse', function() {
                $('#auditAccordionArrow').css('transform', 'rotate(0deg)');
            });
        });
    </script>


    $subObsStatusGrouped = $subobservationbyStatus->groupBy(function ($item) {
    return strtolower($item->status);
    });

    // counts
    $openCount = $subObsSatusGrouped->get('open', collect())->count();
    $closedCount = $subObsStatusGrouped->get('close', collect())->count();

    $total = $openCount + $closedCount;

    // percentage
    $openPercent = $total ? round(($openCount / $total) * 100, 1) : 0;
    $closedPercent = $total ? round(($closedCount / $total) * 100, 1) : 0;



    <div class="sub-obs-card">
        <div class="sub-obs-header">
            <div class="sub-obs-title">
                <div class="status-dot status-dot-open"></div>
                <span>Open</span>
            </div>
            <div class="sub-obs-count">{{ $openCount }}</div>
        </div>

        <div class="sub-obs-progress-container">
            <div class="sub-obs-progress-bar">
                <div class="sub-obs-progress-fill fill-open" style="width: {{ $openPercent }}%"></div>
            </div>
            <div class="sub-obs-percentage">{{ $openPercent }}%</div>
        </div>

        <div>
            <div class="recent-sub-obs-label">Recent sub-observations</div>
            <ul class="recent-sub-obs-list">
                @foreach ($subObsStatusGrouped->get('open', collect())->take(3) as $item)
                    <li>{{ $item->name }} - Open</li>
                @endforeach
            </ul>
        </div>
    </div>



    222222222222222222222222222222222222222222222222

    @php
        $yearNow = (int) date('Y');
        $monthNow = (int) date('m');
        $startYear = $monthNow < 4 ? $yearNow - 1 : $yearNow;
    @endphp
    <div class="card-filter-panel" id="cardFilter" data-url="{{ route('admin.atrdashboard') }}">
        <div class="filter-header">
            <h6 class="mb-0">Filters</h6>
            <button class="btn-close" id="closeFilter"></button>
        </div>
        <div class="filter-body" id="auditFiltersBody">

            <div class="filter-card mb-3">
                <div class="vikalp-x" data-multiple="true" data-placeholder="-- Financial Year --">
                    <select name="financial_year" class="chartFilter dt-filter-item" multiple></select>
                    <button class="btn btn-light dropdown-toggle vikalp-input" type="button"
                        data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                        -- Financial Year --
                    </button>
                    <ul class="dropdown-menu w-100">
                        <li class="p-2">
                            <input type="text" class="form-control vikalp-search" placeholder="Search...">
                        </li>
                        {{-- <li class="vikalp-option"><input type="checkbox" class="vikalp-checkbox" id=""><a
                            class="dropdown-item" href="#" data-value="">All</a>
                    </li> --}}
                        @for ($i = 0; $i < 5; $i++)
                            <li class="vikalp-option"><input type="checkbox" class="vikalp-checkbox" id="">
                                @php
                                    $year = $startYear - $i;
                                    $financialYear = $year . '-' . ($year + 1);
                                @endphp
                                <a class="dropdown-item" href="#"
                                    data-value="{{ $financialYear }}">{{ $financialYear }}</a>

                            </li>
                        @endfor
                    </ul>
                </div>


                <div class="filter-card mb-3">
                    <div class="vikalp-x" data-multiple="true" data-placeholder="-- Department --">
                        <select name="engagementName" id="engagementName" class="chartFilter dt-filter-item"
                            multiple></select>
                        <button class="btn btn-light dropdown-toggle vikalp-input" type="button"
                            data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                            -- Select Engagement --
                        </button>
                        <ul class="dropdown-menu w-100">
                            <li class="p-2">
                                <input type="text" class="form-control vikalp-search" placeholder="Search...">
                            </li>
                            @foreach ($filters['engagement'] as $engagementlist)
                                <li class="vikalp-option"><input type="checkbox" class="vikalp-checkbox"
                                        id=""><a class="dropdown-item" href="#"
                                        data-value="{{ $engagementlist->name }}">{{ Str::ucfirst($engagementlist->name ?? '') }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="filter-card mb-3">
                        <div class="vikalp-x" data-multiple="true" data-placeholder="-- Observation Status --">
                            <select name="riskGrading" data-filter="observation_status"
                                class="chartFilter dt-filter-item" multiple></select>
                            <button class="btn btn-light dropdown-toggle vikalp-input" type="button"
                                data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                -- Risk Grading --
                            </button>
                            <ul class="dropdown-menu w-100">
                                <li class="p-2">
                                    <input type="text" class="form-control vikalp-search" placeholder="Search...">
                                </li>
                                <li class="vikalp-option">
                                    <input type="checkbox" class="vikalp-checkbox">
                                    <a class="dropdown-item" href="#" data-value="planned">Planned</a>
                                </li>

                                <li class="vikalp-option">
                                    <input type="checkbox" class="vikalp-checkbox">
                                    <a class="dropdown-item" href="#" data-value="in progress">In Progress</a>
                                </li>

                                <li class="vikalp-option">
                                    <input type="checkbox" class="vikalp-checkbox">
                                    <a class="dropdown-item" href="#" data-value="draft report">Draft
                                        Report</a>
                                </li>

                                <li class="vikalp-option">
                                    <input type="checkbox" class="vikalp-checkbox">
                                    <a class="dropdown-item" href="#" data-value="completed">Completed</a>
                                </li>

                            </ul>
                        </div>
                    </div>


                    <div class="filter-card mb-3">
                        <div class="vikalp-x" data-multiple="true" data-placeholder="-- Observation Status --">
                            <select name="status" data-filter="observation_status"
                                class="chartFilter dt-filter-item" multiple></select>
                            <button class="btn btn-light dropdown-toggle vikalp-input" type="button"
                                data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                -- Status --
                            </button>
                            <ul class="dropdown-menu w-100">
                                <li class="p-2">
                                    <input type="text" class="form-control vikalp-search" placeholder="Search...">
                                </li>
                                <li class="vikalp-option">
                                    <input type="checkbox" class="vikalp-checkbox">
                                    <a class="dropdown-item" href="#" data-value="open">Open</a>
                                </li>

                                <li class="vikalp-option">
                                    <input type="checkbox" class="vikalp-checkbox">
                                    <a class="dropdown-item" href="#" data-value="close">Close</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="filter-card mb-3">
                        <button class="btn btn-primary btn-sm" id="applyFilterBtn">
                            <i class="ri-filter-3-line me-1"></i> Apply
                        </button>
                        <button class="btn btn-dark btn-sm" id="resetFilters">
                            Reset
                        </button>

                        <div class="ms-1">
                            <i class="ri-arrow-down-s-line fs-5" id="atrdAccordionArrow" data-bs-toggle="collapse"
                                data-bs-target="#atrdMoreFilters"></i>
                        </div>
                    </div>

                    <div class="collapse" id="atrdMoreFilters">
                        <div class="d-flex align-items-center gap-2 flex-wrap mt-3 pt-3 border-top">
                            <div class="atrd-filter-item">
                                <div class="vikalp-x" data-multiple="true"
                                    data-placeholder="-- Observation Status --">
                                    <select name="observation_status" id="observation_status"
                                        class="chartFilter dt-filter-item d-none" multiple></select>
                                    <button class="btn dropdown-toggle vikalp-input w-100" type="button"
                                        data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                        -- Observation Status --
                                    </button>
                                    <ul class="dropdown-menu w-100 shadow border-0"
                                        style="max-height: 250px; overflow-y: auto;">
                                        <li class="p-2 sticky-top bg-white border-bottom"><input type="text"
                                                class="form-control form-control-sm vikalp-search"
                                                placeholder="Search..."></li>
                                        @foreach ($filters['dropdowns']['observation_status'] ?? [] as $dropdown)
                                            <li class="vikalp-option"><input type="checkbox" class="vikalp-checkbox"
                                                    id=""><a class="dropdown-item" href="#"
                                                    data-value="{{ $dropdown->option_value }}">{{ Str::ucfirst($dropdown->option_text ?? '') }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div style="flex: 3;"></div>
                        </div>
                    </div>
                </div>
            </div>


            <script>
                document.getElementById('applyFilterBtn').addEventListener('click', function() {

                    let params = new URLSearchParams();

                    document.querySelectorAll('.vikalp-x').forEach(function(wrapper) {

                        let select = wrapper.querySelector('select');
                        let name = select.name;

                        wrapper.querySelectorAll('.vikalp-checkbox:checked').forEach(function(cb) {

                            let value = cb.nextElementSibling.getAttribute('data-value');

                            if (value) {
                                params.append(name + '[]', value);
                            }
                        });
                    });

                    let url = "{{ route('admin.atrdashboard') }}" + '?' + params.toString();

                    window.location.href = url;
                });
            </script>

            <script>
                document.addEventListener("DOMContentLoaded", function() {

                    const urlParams = new URLSearchParams(window.location.search);

                    document.querySelectorAll('.vikalp-x').forEach(function(wrapper) {

                        let select = wrapper.querySelector('select');
                        let name = select.name;

                        // get all values (array support)
                        let values = urlParams.getAll(name + '[]');

                        if (values.length > 0) {

                            let selectedText = [];

                            wrapper.querySelectorAll('.vikalp-option').forEach(function(option) {

                                let cb = option.querySelector('.vikalp-checkbox');
                                let anchor = option.querySelector('a');

                                let value = anchor.getAttribute('data-value');
                                let text = anchor.textContent.trim();

                                if (values.includes(value)) {
                                    cb.checked = true;
                                    selectedText.push(text);
                                }
                            });

                            // button text update
                            let btn = wrapper.querySelector('.vikalp-input');

                            if (selectedText.length > 0) {
                                btn.textContent = selectedText.join(', ');
                            }
                        }
                    });

                });
            </script>

            <script>
                document.getElementById('resetFilters').addEventListener('click', function() {
                    window.location.href = "{{ route('admin.atrdashboard') }}";
                });
            </script>



            {{-- @foreach ($overdueObservations as $overdueObservation)
                                    @php
                                        $status = strtolower(trim($overdueObservation->status ?? ''));
                                        $risk = strtolower(trim($overdueObservation->risk_grading ?? ''));

                                        $statusStyle = $statusStyles[$status];
                                        $riskStyle = $riskStyles[$risk];
                                    @endphp
                                    <tr>
                                        <td style="width: 200px;"><a
                                                href="#">{{ \Illuminate\Support\Str::limit($overdueObservation->engagement_name, 35, '...') ?? 'N/A' }}</a>
                                        </td>
                                        <td>{{ $overdueObservation->name ?? 'N/A' }}</td>
                                        <td>
                                            <span class="badge-pill" style="{{ $statusStyle }}">
                                                {{ ucfirst($overdueObservation->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge-pill" style="{{ $riskStyle }}">
                                                {{ ucfirst($overdueObservation->risk_grading) }}
                                            </span>
                                        </td>
                                        <td>{{ $overdueObservation->owner_name ?? 'N/A' }}</td>
                                        <td>{{ $overdueObservation->due_date ?? 'N/A' }}</td>
                                        <td class="text-danger textfixed" style="padding: 17px;">
                                            @php
                                                $dueDate = Carbon\Carbon::parse($overdueObservation->due_date);
                                                $today = Carbon\Carbon::today();
                                                $diffInDays = $today->diffInDays($dueDate);
                                                if ($today->greaterThan($dueDate)) {
                                                    $diffInDays += 1; // Add 1 to include the start day when due date is past
                                                }
                                            @endphp
                                            {{ $diffInDays }} Days
                                        </td>

                                    </tr>
                                @endforeach --}}

            <div class="card-filter-panel" id="cardFilter" data-url="{{ route('admin.auditengagement') }}">
                <div class="filter-header">
                    <h6 class="mb-0">Filters</h6>
                    <button class="btn-close" id="closeFilter"></button>
                </div>
                <div class="filter-body" id="auditFiltersBody">

                    <div class="filter-card mb-3">
                        <select name="financial_year" class="form-select select2 chartFilter dt-filter-item">
                            <option value="">-- Financial Year --</option>
                            @foreach ($filters['dropdowns']['financial_year'] ?? [] as $dropdown)
                                <option value="{{ $dropdown->option_value }}">
                                    {{ Str::ucfirst($dropdown->option_text ?? '') }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-card mb-3">
                        <select name="quarter" class="form-select select2 chartFilter dt-filter-item">
                            <option value="">-- Quarter --</option>
                            @foreach ($filters['dropdowns']['quarter'] ?? [] as $dropdown)
                                <option value="{{ $dropdown->option_value }}">
                                    {{ Str::ucfirst($dropdown->option_text ?? '') }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-card mb-3">
                        <select name="risk_rating" class="form-select select2 chartFilter dt-filter-item">
                            <option value="">-- Audit Plan--</option>
                            @foreach ($filters['dropdowns']['risk_rating'] ?? [] as $dropdown)
                                <option value="{{ $dropdown->option_value }}">
                                    {{ Str::ucfirst($dropdown->option_text ?? '') }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-card mb-3">
                        <select name="department" id="department"
                            class="form-select select2 chartFilter dt-filter-item">
                            <option value="">-- Select Engagement --</option>
                            @foreach ($filters['departments'] ?? [] as $dropdown)
                                <option value="{{ $dropdown->id }}">{{ Str::ucfirst($dropdown->name ?? '') }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-card mb-3">
                        <select name="observation_status" data-filter="observation_status"
                            class="form-select select2 chartFilter dt-filter-item">
                            <option value="">-- Engagement Status --</option>
                            @foreach ($issueStatus ?? [] as $statusItem)
                                <option value="{{ $statusItem->id ?? '' }}">
                                    {{ Str::ucfirst($statusItem->name ?? '') }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-card mb-3">
                        <select name="observation_status" data-filter="observation_status"
                            class="form-select select2 chartFilter dt-filter-item">
                            <option value="">-- Observation Status --</option>
                            @foreach ($issueStatus ?? [] as $statusItem)
                                <option value="{{ $statusItem->id ?? '' }}">
                                    {{ Str::ucfirst($statusItem->name ?? '') }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-card mb-3">
                        <select name="observation_status" data-filter="observation_status"
                            class="form-select select2 chartFilter dt-filter-item">
                            <option value="">-- DRL Status --</option>
                            @foreach ($issueStatus ?? [] as $statusItem)
                                <option value="{{ $statusItem->id ?? '' }}">
                                    {{ Str::ucfirst($statusItem->name ?? '') }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-card mb-3">
                        <button class="btn btn-primary btn-sm" id="applyFilterBtn">
                            <i class="ri-filter-3-line me-1"></i> Apply
                        </button>
                        <button class="btn btn-dark btn-sm" id="reset-filters" onclick="location.reload()">
                            Reset
                        </button>
                    </div>

                </div>
            </div>


            <div class="card-filter-panel" id="cardFilter" data-url="{{ route('admin.auditengagement') }}">
                <div class="filter-header">
                    <h6 class="mb-0">Filters</h6>
                    <button class="btn-close" id="closeFilter"></button>
                </div>
                <div class="filter-body" id="auditFiltersBody">

                    <div class="filter-card mb-3">
                        <select name="financial_year" class="form-select select2 chartFilter dt-filter-item">
                            <option value="">-- Financial Year --</option>
                            @foreach ($filters['dropdowns']['financial_year'] ?? [] as $dropdown)
                                <option value="{{ $dropdown->option_value }}">
                                    {{ Str::ucfirst($dropdown->option_text ?? '') }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-card mb-3">
                        <select name="quarter" class="form-select select2 chartFilter dt-filter-item">
                            <option value="">-- Quarter --</option>
                            @foreach ($filters['dropdowns']['quarter'] ?? [] as $dropdown)
                                <option value="{{ $dropdown->option_value }}">
                                    {{ Str::ucfirst($dropdown->option_text ?? '') }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-card mb-3">
                        <select name="risk_rating" class="form-select select2 chartFilter dt-filter-item">
                            <option value="">-- Risk Rating --</option>
                            @foreach ($filters['dropdowns']['risk_rating'] ?? [] as $dropdown)
                                <option value="{{ $dropdown->option_value }}">
                                    {{ Str::ucfirst($dropdown->option_text ?? '') }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-card mb-3">
                        <select name="department" id="department"
                            class="form-select select2 chartFilter dt-filter-item">
                            <option value="">-- Department --</option>
                            @foreach ($filters['departments'] ?? [] as $dropdown)
                                <option value="{{ $dropdown->id }}">{{ Str::ucfirst($dropdown->name ?? '') }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-card mb-3">
                        <select name="observation_status" data-filter="observation_status"
                            class="form-select select2 chartFilter dt-filter-item">
                            <option value="">-- Observation Status --</option>
                            @foreach ($issueStatus ?? [] as $statusItem)
                                <option value="{{ $statusItem->id ?? '' }}">
                                    {{ Str::ucfirst($statusItem->name ?? '') }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-card mb-3">
                        <button class="btn btn-primary btn-sm" id="applyFilterBtn">
                            <i class="ri-filter-3-line me-1"></i> Apply
                        </button>
                        <button class="btn btn-dark btn-sm" id="reset-filters" onclick="location.reload()">
                            Reset
                        </button>
                    </div>

                </div>
            </div>

            <script>
                document.getElementById('applyFilterBtn').addEventListener('click', function() {

                    let params = new URLSearchParams();

                    // sab filters pick karo
                    document.querySelectorAll('.dt-filter-item').forEach(function(el) {
                        if (el.value) {
                            params.append(el.name, el.value);
                        }
                    });

                    // redirect to atrdashboard
                    let url = "{{ route('admin.auditengagement') }}" + '?' + params.toString();

                    window.location.href = url;
                });
            </script>


            @foreach ($actionableList as $actionable)
                <tr>
                    <td style="width: 200px;"><a
                            href="#">{{ \Illuminate\Support\Str::limit($actionable->name, 35, '...') ?? 'N/A' }}</a>
                    </td>
                    <td>{{ $actionable->status ?? 'N/A' }}</td>
                    <td>{{ $actionable->audit_start_date ?? 'N/A' }}</td>
                    <td>{{ $actionable->audit_end_date ?? 'N/A' }}</td>
                </tr>
            @endforeach


            <div class="d-flex flex-column" style="background-color: pink; width: stretch;">
                @foreach ($attachmentdatas as $attachmentdata)
                    @php
                        $url = $attachmentdata;
                        $extension = getFileExtension($url);
                        $previewUrl = generatePreviewUrl($url);
                        $downloadUrl = generateDownloadUrl($url);
                    @endphp
                    <div class="d-flex align-items-center justify-content-between mb-1 w-100">
                        <small class="text-dark fw-bold">
                            File Name: &nbsp;{{ basename($attachmentdata ?? '') }}
                        </small>
                        <div class="d-flex align-items-center">
                            <a class="fs-20 text-info me-1" href="{{ $previewUrl }}" target="_blank">
                                <i class="las la-eye"></i>
                            </a>

                            <a class="fs-20 text-dark me-3" href="{{ $downloadUrl }}" download target="_blank">
                                <i class="las la-download"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
                <small class="text-muted">
                    Uploaded On:
                    {{ \Carbon\Carbon::parse($attachment->created_at)->timezone('Asia/Kolkata')->format('d-F-Y, g:i A') }}
                </small>
                <small class="text-muted">
                    Uploaded By:{{ $uploader?->name ?? 'N/A' }}
                </small>
                <small class="fw-bold">
                    Version: {{ $attachment->version_label ?? 'N/A' }}
                </small>
            </div>
            <div class="modal-body" data-simplebar style="max-height: 300px">
                @if ($fileVersions == null || $fileVersions->isEmpty())
                    <p class="mt-5 text-center"><b>No Version History Found!</b></p>
                @else
                    @php
                        $versionCounters = [
                            'Draft' => 0,
                            'Final' => 0,
                        ];

                        $sortedVersions = $fileVersions->sortBy('created_at');

                        $renamedVersions = $sortedVersions->map(function ($item) use (&$versionCounters) {
                            $type = $item->version;
                            $versionCounters[$type]++;
                            $item->version_label = $type . ' ' . $versionCounters[$type];
                            return $item;
                        });
                    @endphp


                    @foreach ($renamedVersions as $attachment)
                        @php
                            $attachmentdatas = json_decode($attachment->attachment_json, true);
                            $uploader = \App\Models\User::find($attachment->uploaded_by);
                        @endphp

                        <div class="card mb-1 border-0 shadow shadow-lg">
                            <div class="p-1">

                                <div class="d-flex align-items-center justify-content-between">

                                    <div class="flex-grow-1 d-flex align-items-center">

                                        <div class="d-flex flex-column">

                                            @foreach ($attachmentdatas as $attachmentdata)
                                                @php
                                                    $url = $attachmentdata;
                                                    $extension = getFileExtension($url);
                                                    $previewUrl = generatePreviewUrl($url);
                                                    $downloadUrl = generateDownloadUrl($url);
                                                @endphp

                                                <small class="text-dark fw-bold">
                                                    File Name: &nbsp;{{ basename($attachmentdata ?? '') }}
                                                </small>

                                                <div class="d-flex align-items-center mb-1">

                                                    <a class="fs-20 text-info me-1" href="{{ $previewUrl }}"
                                                        target="_blank">
                                                        <i class="las la-eye"></i>
                                                    </a>

                                                    <a class="fs-20 text-dark me-3" href="{{ $downloadUrl }}"
                                                        download target="_blank">
                                                        <i class="las la-download"></i>
                                                    </a>

                                                </div>
                                            @endforeach


                                            <small class="text-muted">
                                                Uploaded On:
                                                {{ \Carbon\Carbon::parse($attachment->created_at)->timezone('Asia/Kolkata')->format('d-F-Y, g:i A') }}
                                            </small>

                                            <small class="text-muted">
                                                Uploaded By: {{ $uploader?->name ?? 'N/A' }}
                                            </small>

                                            <small class="fw-bold">
                                                Version: {{ $attachment->version_label ?? 'N/A' }}
                                            </small>

                                        </div>

                                    </div>

                                </div>

                            </div>
                        </div>
                    @endforeach

                @endif
            </div>

            <body>
                <div class="modal-body" data-simplebar style="max-height: 300px">
                    @if ($fileVersions == null || $fileVersions->isEmpty())
                        <p class="mt-5 text-center"><b>No Version History Found!</b></p>
                    @else
                        @php
                            $versionCounters = [
                                'Draft' => 0,
                                'Final' => 0,
                            ];

                            // Sort fileVersions by created_at ASCENDING
                            $sortedVersions = $fileVersions->sortBy('created_at');

                            $renamedVersions = $sortedVersions->map(function ($item) use (&$versionCounters) {
                                $type = $item->version;
                                $versionCounters[$type]++;
                                $item->version_label = $type . ' ' . $versionCounters[$type];
                                return $item;
                            });
                        @endphp

                        @foreach ($renamedVersions as $attachment)
                            @php
                                $attachmentdatas = json_decode($attachment->attachment_json, true);
                                $uploader = \App\Models\User::find($attachment->uploaded_by);
                            @endphp
                            @foreach ($attachmentdatas as $attachmentdata)
                                @php
                                    $url = $attachmentdata;
                                    $extension = getFileExtension($url);
                                    $previewUrl = generatePreviewUrl($url);
                                    $downloadUrl = generateDownloadUrl($url);
                                @endphp

                                <div class="card mb-1 border-0 shadow shadow-lg">
                                    <div class="p-1">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="flex-grow-1 d-flex align-items-center">
                                                <div class="d-flex flex-column">
                                                    <small class="text-dark fw-bold">
                                                        File Name: &nbsp;{{ basename($attachmentdata ?? '') }}
                                                    </small>

                                                    <small class="text-muted">
                                                        Uploaded On:
                                                        {{ \Carbon\Carbon::parse($attachment->created_at)->timezone('Asia/Kolkata')->format('d-F-Y, g:i A') ?? '' }}
                                                    </small>
                                                    <small class="text-muted">
                                                        Uploaded By: {{ $uploader?->name ?? 'N/A' }}
                                                    </small>
                                                    <small class="fw-bold">
                                                        Version: {{ $attachment->version_label ?? 'N/A' }}
                                                    </small>
                                                </div>
                                            </div>

                                            <div class="d-flex align-items-center">
                                                <a class="fs-20 text-info me-1" href="{{ $previewUrl }}"
                                                    target="_blank">
                                                    <i class="las la-eye"></i>
                                                </a>
                                                <a class="fs-20 text-dark" href="{{ $downloadUrl }}" download
                                                    target="_blank">
                                                    <i class="las la-download"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                    @endif
                </div>
                <div class="modal-body">
                    <div class="col mb-3">
                        @php
                            $attachments = json_decode($report->attachment_json, true);
                            $classes = ['primary', 'secondary', 'danger', 'info', 'success', 'dark'];
                        @endphp

                        @if (!empty($attachments))
                            @foreach ($attachments as $attachment)
                                @php
                                    $randomClass = $classes[array_rand($classes)];
                                    $extension = getFileExtension($attachment);
                                    $previewUrl = generatePreviewUrl($attachment);
                                    $downloadUrl = generateDownloadUrl($attachment);
                                @endphp

                                <div class="card mb-1 border-0 shadow-none">
                                    <div class="p-1 d-flex justify-content-between align-items-center">

                                        <div class="d-flex align-items-center">
                                            <span
                                                class="avatar-sm bg-{{ $randomClass }} text-white rounded d-flex align-center justify-center me-2">
                                                {{ '.' . $extension }}
                                            </span>

                                            <div>
                                                <small class="text-muted">
                                                    File: {{ basename($attachment) }}
                                                </small><br>

                                                <small class="text-muted">
                                                    Uploaded:
                                                    {{ $report->created_at->timezone('Asia/Kolkata')->format('d-M-Y, g:i A') }}
                                                </small>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center">

                                            <span class="fs-20 text-{{ $randomClass }} actionHandler me-2"
                                                data-url="{{ route('admin.file.viewframe') }}"
                                                data-file-url="{{ $previewUrl }}" data-handler="openFilePreview">
                                                <i class="las la-eye"></i>
                                            </span>

                                            <a href="{{ $downloadUrl }}" class="fs-20 text-{{ $randomClass }}"
                                                download target="_blank">
                                                <i class="las la-download"></i>
                                            </a>

                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-center text-muted"><b>No Attachment Found</b></p>
                        @endif
                    </div>
                </div>
                {{-- * regarding  --}}

                ->select(
                'teammembers.id',
                'teammembers.joining_date',
                'teammembers.team_member',
                'roles.rolename',

                DB::raw('GROUP_CONCAT(DISTINCT clients.client_name) as client_Namess'),
                DB::raw('GROUP_CONCAT(DISTINCT checkins.assignment_id) as assignmentid'),
                DB::raw('GROUP_CONCAT(DISTINCT assignments.assignment_name) as assignmentname'),
                DB::raw('GROUP_CONCAT(DISTINCT teampartner.team_member) as teampartner'),
                // DB::raw('COUNT(*) as Total_Checkin'),
                DB::raw('COUNT(DISTINCT STR_TO_DATE(checkins.date, "%d-%m-%Y")) as Total_Checkin'),
                DB::raw('SUM(CASE WHEN checkins.checkin_from = "Office" THEN 1 ELSE 0 END) as Office'),
                DB::raw('SUM(CASE WHEN checkins.checkin_from = "Work From Home" THEN 1 ELSE 0 END) as WFM'),
                DB::raw('SUM(CASE WHEN checkins.checkin_from = "Client Place" THEN 1 ELSE 0 END) as Client_Place'),
                DB::raw('SUM(CASE WHEN checkins.checkin_from = "Business Development" THEN 1 ELSE 0 END) as
                Business_Development'),
                DB::raw('SUM(CASE WHEN checkins.time < "10:30:00" THEN 1 ELSE 0 END) as On_Time_Before_10_30'),
                    DB::raw('SUM(CASE WHEN checkins.time>= "10:30:00" AND checkins.time < "12:00:00" THEN 1 ELSE 0 END)
                    as chgg'), DB::raw('SUM(CASE WHEN checkins.time> "12:01:00" THEN 1 ELSE 0 END) as After_12_PM'),
                    // DB::raw('SUM(CASE WHEN checkins.typeval IS NULL THEN 1 ELSE 0 END) as Unallocated'),
                    DB::raw("SUM(CASE WHEN checkins.typeval = 'Unallocated' THEN 1 ELSE 0 END) as Unallocated"),

                    DB::raw('GROUP_CONCAT(DISTINCT CONCAT(STR_TO_DATE(checkins.date, "%d-%m-%Y"), " ",
                    TIME_FORMAT(checkins.time, "%H:%i:%s"))) as checkin_datetime'),


                    @foreach ($cards as $card)
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 mb-3">
                            <div class="card h-100">
                                <div class="card-body text-end position-relative">

                                    <div class="card-icon d-flex align-items-center justify-content-center"
                                        style="width:50px;height:50px;border-radius:50%;
                                                   background-image: {{ $card['gradient'] }};">
                                        <i class="{{ $card['icon'] }} text-white"></i>
                                    </div>

                                    <a href="{{ url('checkinreportlist' . $parameters) }}"
                                        class="text-decoration-none">
                                        <p class="text-uppercase text-muted fw-bold mt-3 small">
                                            {{ $card['title'] }}
                                        </p>
                                        <h3 class="fw-bold">
                                            {{ $card['value'] }}
                                        </h3>
                                    </a>

                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6" style="height: 165px;">
                        <div class="card card-stats statistic-box mb-4">
                            <div class="card-header card-header-icon position-relative border-0 text-right px-3 py-0">
                                <div class="card-icon d-flex align-items-center justify-content-center mt-0 mr-0"
                                    style="background-image: linear-gradient(to right, #34b4e5, rgba(255, 0, 0, 1));">
                                    <i class="fas fa-building"></i>
                                </div>
                                <a href="{{ url('checkinreportlist' . $parameters) }}">
                                    <p class="card-category text-uppercase fs-10 font-weight-bold text-muted mt-4">
                                        Office
                                    </p>
                                    <h3 class="card-title fs-18 font-weight-bold">
                                        {{ $checkinreportlisttoday->Office }}</h3>
                                </a>
                            </div>

                        </div>
                    </div>

                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6" style="height: 165px;">
                        <div class="card card-stats statistic-box mb-4">
                            <div class="card-header card-header-icon position-relative border-0 text-right px-3 py-0">
                                <div class="card-icon d-flex align-items-center justify-content-center mt-0 mr-0"
                                    style="background-image: linear-gradient(to right, #34b4e5, rgb(0 86 255));">
                                    <i class="fas fa-home"></i>
                                </div>

                                <a href="{{ url('checkinreportlist' . $parameters) }}">
                                    <p class="card-category text-uppercase fs-10 font-weight-bold text-muted mt-4">
                                        Work From
                                        Home</p>
                                    <h3 class="card-title fs-18 font-weight-bold">
                                        {{ $checkinreportlisttoday->WFM }}</h3>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6" style="height: 165px;">
                        <div class="card card-stats statistic-box mb-4">
                            <div class="card-header card-header-icon position-relative border-0 text-right px-3 py-0">
                                <div class="card-icon d-flex align-items-center justify-content-center mt-0 mr-0"
                                    style="background-image: linear-gradient(to right, #34e537, rgb(0 86 255));">
                                    <i class="fas fa-laptop-house"></i>
                                </div>
                                <a href="{{ url('checkinreportlist' . $parameters) }}">
                                    <p class="card-category text-uppercase fs-10 font-weight-bold text-muted mt-3">
                                        Client
                                        Place</p>
                                    <h3 class="card-title fs-18 font-weight-bold">
                                        {{ $checkinreportlisttoday->Client_Place }}</h3>
                                </a>
                            </div>
                        </div>
                    </div>


                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6" style="height: 165px;">
                        <div class="card card-stats statistic-box mb-4">
                            <div class="card-header card-header-icon position-relative border-0 text-right px-3 py-0">
                                <div class="card-icon d-flex align-items-center justify-content-center mt-0 mr-0"
                                    style="background-image: linear-gradient(to right, #e53834, rgb(51 20 61));">
                                    <i class="fas fa-handshake"></i>
                                </div>
                                <a href="{{ url('checkinreportlist' . $parameters) }}">
                                    <p class="card-category text-uppercase font-weight-bold text-muted"
                                        style="font-size: 6px;">
                                        Business
                                        Development</p>
                                    <h3 class="card-title fs-18 font-weight-bold">
                                        {{ $checkinreportlisttoday->Business_Development }}</h3>
                                </a>
                            </div>

                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6" style="height: 165px;">
                        <div class="card card-stats statistic-box mb-4">
                            <div class="card-header card-header-icon position-relative border-0 text-right px-3 py-0">
                                <div class="card-icon d-flex align-items-center justify-content-center mt-0 mr-0"
                                    style="background-image: linear-gradient(to right, #4b34e5, rgb(191 0 255));">
                                    <i class="fas fa-bed"></i>
                                </div>
                                <a href="{{ url('checkinreportlist' . $parameters) }}">
                                    <p class="card-category text-uppercase fs-10 font-weight-bold text-muted mt-3">
                                        Leave</p>
                                    <h3 class="card-title fs-18 font-weight-bold">
                                        {{ $checkinreportlisttoday->Leave_Days }}</h3>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6" style="height: 165px;">
                        <div class="card card-stats statistic-box mb-4">
                            <div class="card-header card-header-icon position-relative border-0 text-right px-3 py-0">
                                <div class="card-icon d-flex align-items-center justify-content-center mt-0 mr-0"
                                    style="background-image: linear-gradient(to right, #4b34e5, rgb(51 20 61));">
                                    <i class="fas fa-user-clock"></i>
                                </div>

                                <a href="{{ url('checkinreportlist' . $parameters) }}">
                                    <p class="card-category text-uppercase fs-10 font-weight-bold text-muted mt-3">
                                        Unallocated</p>
                                    <h3 class="card-title fs-18 font-weight-bold">
                                        {{ 0 }}
                                    </h3>
                                </a>
                            </div>
                        </div>
                    </div>


                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6" style="height: 165px; margin-bottom: 18px;">
                        <div class="card card-stats statistic-box mb-4">
                            <div class="card-header card-header-icon position-relative border-0 text-right px-3 py-0">
                                <div class="card-icon d-flex align-items-center justify-content-center mt-0 mr-0"
                                    style="background-image: linear-gradient(to right, #34e537, rgb(0 86 255));">
                                    <i class="fas fa-home"></i>
                                </div>
                                <a href="{{ url('checkinreportlist' . $parameters) }}">
                                    <p class="card-category text-uppercase fs-10 font-weight-bold text-muted">
                                        Before 10:30</p>
                                    <h3 class="card-title fs-18 font-weight-bold">
                                        {{ $checkinreportlisttoday->On_Time_Before_10_30 }}</h3>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6" style="height: 165px; margin-bottom: 18px;">
                        <div class="card card-stats statistic-box mb-4">
                            <div class="card-header card-header-icon position-relative border-0 text-right px-3 py-0">
                                <div class="card-icon d-flex align-items-center justify-content-center mt-0 mr-0"
                                    style="background-image: linear-gradient(to right, #34b4e5, rgb(0 86 255));">
                                    <i class="fas fa-home"></i>
                                </div>
                                <a href="{{ url('checkinreportlist' . $parameters) }}">
                                    <p class="card-category text-uppercase font-weight-bold text-muted mt-3"
                                        style="font-size: 8px;">
                                        10:30AM To 12:00PM</p>
                                    <h3 class="card-title fs-18 font-weight-bold">
                                        {{ $checkinreportlisttoday->chgg }}</h3>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6" style="height: 165px; margin-bottom: 18px;">
                        <div class="card card-stats statistic-box mb-4">
                            <div class="card-header card-header-icon position-relative border-0 text-right px-3 py-0">
                                <div class="card-icon d-flex align-items-center justify-content-center mt-0 mr-0"
                                    style="background-image: linear-gradient(to right, #34b4e5, rgba(255, 0, 0, 1));">
                                    <i class="fas fa-home"></i>
                                </div>
                                <a href="{{ url('checkinreportlist' . $parameters) }}">
                                    <p class="card-category text-uppercase fs-10 font-weight-bold text-muted mt-3">
                                        After 12:00 PM</p>
                                    <h3 class="card-title fs-18 font-weight-bold">
                                        {{ $checkinreportlisttoday->After_12_PM }}
                                    </h3>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                        <div class="card card-stats statistic-box mb-4">
                            <div class="card-header card-header-icon position-relative border-0 text-right px-3 py-0">
                                <div class="card-icon d-flex align-items-center justify-content-center mt-0 mr-0"
                                    style="background-image: linear-gradient(to right, #34e537, rgb(0 86 255));">
                                    <i class="fas fa-handshake"></i>
                                </div>
                                @php
                                    $currentDate = date('d-m-Y');
                                    $type = 'Business Development';
                                @endphp
                                <a href="{{ url('checkinreport/' . $currentDate . '/' . $type) }}">
                                    <p class="card-category text-uppercase fs-10 font-weight-bold text-muted">
                                        Business
                                        Development</p>
                                    <h3 class="card-title fs-18 font-weight-bold">
                                        {{ $checkinreportlisttoday->Business_Development }}</h3>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                        <div class="card card-stats statistic-box mb-4">
                            <div class="card-header card-header-icon position-relative border-0 text-right px-3 py-0">
                                <div class="card-icon d-flex align-items-center justify-content-center mt-0 mr-0"
                                    style="background-image: linear-gradient(to right, #34b4e5, rgb(0 86 255));">
                                    <i class="fas fa-bed"></i>
                                </div>
                                @php
                                    $currentDate = date('Y-m-d');
                                @endphp
                                <a href="{{ url('leave/' . $currentDate) }}">
                                    <p class="card-category text-uppercase fs-10 font-weight-bold text-muted mt-3">
                                        Leave</p>
                                    <h3 class="card-title fs-18 font-weight-bold">
                                        {{ $checkinreportlisttoday->Leave_Days }}</h3>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                        <div class="card card-stats statistic-box mb-4">
                            <div class="card-header card-header-icon position-relative border-0 text-right px-3 py-0">
                                <div class="card-icon d-flex align-items-center justify-content-center mt-0 mr-0"
                                    style="background-image: linear-gradient(to right, #34b4e5, rgba(255, 0, 0, 1));">
                                    <i class="fas fa-user-clock"></i>
                                </div>
                                @php
                                    $currentDate = date('d-m-Y');
                                    $type = 'Unallocated';
                                @endphp
                                <a href="{{ url('unallocated/' . $currentDate . '/' . $type) }}">
                                    <p class="card-category text-uppercase fs-10 font-weight-bold text-muted mt-3">
                                        Unallocated</p>
                                    <h3 class="card-title fs-18 font-weight-bold">
                                        {{ $checkinreportlisttoday->Office }}
                                    </h3>
                                </a>
                            </div>
                        </div>
                    </div>
                    {{--  Start Hare --}}
                    {{-- * regarding  --}}
                    {{--  Start Hare --}}
                    {{-- * regarding  --}}
                    {{--  Start Hare --}}
                    {{-- * regarding  --}}
                    {{--  Start Hare --}}
                    {{-- * regarding  --}}
                    {{--  Start Hare --}}
                    {{-- * regarding  --}}
                    {{--  Start Hare --}}
                    {{-- * regarding  --}}
                    {{--  Start Hare --}}
                    {{-- * regarding  --}}
                    {{--  Start Hare --}}
                    {{-- * regarding  --}}
                    {{--  Start Hare --}}
                    {{-- * regarding  --}}
                    {{--  Start Hare --}}
                    {{-- * regarding  --}}
                    {{--  Start Hare --}}
                    {{-- * regarding  --}}
                    {{--  Start Hare --}}
                    {{-- * regarding  --}}
                    {{--  Start Hare --}}
                    {{-- * regarding  --}}
                    {{--  Start Hare --}}
                    {{-- * regarding  --}}
                    {{--  Start Hare --}}
                    public function dashbordreport()
                    {

                    $newRequest = new Request([
                    'role_id' => auth()->user()->role_id,
                    'teammember_id' => auth()->user()->teammember_id
                    ]);

                    $checkInController = app(\App\Http\Controllers\Api\CheckInController::class);
                    $response = $checkInController->checkInList($newRequest);
                    $data = $response->getData()->result;
                    $checkInCount = count($data);

                    dd('jis');
                    session()->forget('_old_input');
                    if (auth()->user()->role_id == 11 || auth()->user()->role_id == 12 || auth()->user()->teammember_id
                    == 156)
                    {
                    // financial year
                    $currentDate4 = Carbon::now();
                    // $currentDate4 = Carbon::parse('2024-07-01');
                    // $currentDate4 = Carbon::parse('2024-07-01 13:30:00');
                    $currentMonth4 = $currentDate4->format('F');
                    if ($currentDate4->month >= 4) {
                    // Current year financial year
                    $financialStartDate = Carbon::create($currentDate4->year, 4, 1);
                    $financialEndDate = Carbon::create($currentDate4->year + 1, 3, 31);
                    } else {
                    // Previous year financial year
                    $financialStartDate = Carbon::create($currentDate4->year - 1, 4, 1);
                    $financialEndDate = Carbon::create($currentDate4->year, 3, 31);
                    }

                    $financialStartYear = now()->month >= 4 ? now()->year : now()->year - 1;
                    $financialEndYear = $financialStartYear + 1;

                    $monthNames = [
                    1 => 'January',
                    2 => 'February',
                    3 => 'March',
                    4 => 'April',
                    5 => 'May',
                    6 => 'June',
                    7 => 'July',
                    8 => 'August',
                    9 => 'September',
                    10 => 'October',
                    11 => 'November',
                    12 => 'December'
                    ];


                    // Bills Pending for Generation
                    $billspending = DB::table('assignmentmappings')
                    ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id',
                    'assignmentmappings.assignmentgenerate_id')
                    ->leftJoin('invoices', 'invoices.assignmentgenerate_id', '=',
                    'assignmentmappings.assignmentgenerate_id')
                    // Invoice not raised
                    ->whereNull('invoices.assignmentgenerate_id')
                    // Assignment closed
                    ->where('assignmentbudgetings.status', 0)
                    ->sum('assignmentmappings.engagementfee');


                    // Collection's Outstanding
                    $outstandingBills = DB::table('assignmentmappings')
                    ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=',
                    'assignmentmappings.assignmentgenerate_id')
                    ->leftJoin('invoices', 'invoices.assignmentgenerate_id', '=',
                    'assignmentmappings.assignmentgenerate_id')
                    ->leftJoin('outstandings', 'outstandings.BILL_NO', '=', 'invoices.invoice_id')
                    ->whereNotNull('invoices.id')
                    ->where('assignmentbudgetings.status', 0)
                    // ->whereIn('invoices.currency', [1, 3])
                    ->where(function ($q) {
                    $q->whereIn('invoices.currency', [1, 3])
                    ->orWhereNull('invoices.currency');
                    })
                    ->select(
                    'invoices.currency',
                    // 'assignmentmappings.assignmentgenerate_id',
                    DB::raw("DATE_FORMAT(outstandings.created_at, '%Y-%m-%d') as bill_date"),
                    DB::raw('SUM(outstandings.AMT) as total_amount')
                    )
                    ->groupBy('invoices.currency', 'bill_date')
                    ->get();


                    $billspendingforcollection = $this->convertusdtoinr($outstandingBills);

                    // Assignments Completed
                    $assignmentcompleted = DB::table('assignmentbudgetings')
                    // Invoice is created
                    ->join('invoices', 'invoices.assignmentgenerate_id', '=',
                    'assignmentbudgetings.assignmentgenerate_id')
                    ->where('assignmentbudgetings.status', 0)
                    ->whereNotNull('assignmentbudgetings.percentclosedate') // Documentation 100% done
                    ->whereBetween('assignmentbudgetings.otpverifydate', [$financialStartDate, $financialEndDate])
                    ->distinct('assignmentbudgetings.assignmentgenerate_id')
                    ->count('assignmentbudgetings.assignmentgenerate_id');


                    $assignmentcreatedthisyear = DB::table('assignmentmappings')
                    ->whereBetween('created_at', [$financialStartDate, $financialEndDate])
                    ->count();





                    // How many Delayed Assignments
                    $delayedAssignments = DB::table('assignmentmappings')
                    ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=',
                    'assignmentmappings.assignmentgenerate_id')
                    ->where(function ($q) {
                    $q->where(function ($sub) {
                    $sub->where('assignmentbudgetings.status', 1)
                    // Delayed if Documentation < 100% OR Draft Report Date> Tentative End Date
                        ->where(function ($inner) {
                        $inner->whereNull('assignmentbudgetings.percentclosedate')
                        ->orWhereRaw('assignmentbudgetings.finaldraftreportdate >
                        assignmentbudgetings.tentativeenddate');
                        });
                        })
                        // if worked hour > esthour
                        ->orWhereRaw('(
                        SELECT COALESCE(SUM(totalhour), 0)
                        FROM timesheetusers
                        WHERE assignmentgenerate_id = assignmentmappings.assignmentgenerate_id
                        ) > assignmentmappings.esthours');
                        })
                        ->count();


                        // NFRA Audits Ongoing
                        $auditsDue = DB::table('assignmentmappings')
                        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id',
                        'assignmentmappings.assignmentgenerate_id')
                        ->where('assignmentbudgetings.status', 1)
                        ->where('assignmentmappings.eqcrapplicability', 1)
                        ->count();


                        // total amount of convence, how many amount approved for convence in this months or Other
                        Expenses
                        $exceptionalExpensesdata = DB::table('outstationconveyances')
                        ->where('status', 6)
                        ->sum('finalamount');

                        $vendorlist = DB::table('vendorlist')
                        // approved data
                        ->where('status', 1)
                        ->sum('amount');

                        $exceptionalExpenses = ($exceptionalExpensesdata ?? 0) + ($vendorlist ?? 0);

                        // dd($exceptionalExpenses);




                        // Independence Acceptance Pending
                        $teamPending = DB::table('assignmentmappings')
                        ->leftJoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', '=',
                        'assignmentmappings.id')
                        ->leftJoin('teammembers', 'teammembers.id', '=', 'assignmentteammappings.teammember_id')
                        ->leftJoin('annual_independence_declarations', function ($join) {
                        $join->on('annual_independence_declarations.assignmentgenerateid', '=',
                        'assignmentmappings.assignmentgenerate_id')
                        ->on('annual_independence_declarations.createdby', '=', 'teammembers.id');
                        // ->where('annual_independence_declarations.type', 2);
                        })
                        ->leftJoin('independences', function ($join) {
                        $join->on('independences.assignmentgenerate_id', '=',
                        'assignmentmappings.assignmentgenerate_id')
                        ->on('independences.createdby', '=', 'teammembers.id');
                        })
                        ->whereNull(DB::raw('COALESCE(annual_independence_declarations.id, independences.id)')) //
                        Members
                        without
                        declarations
                        ->groupBy('assignmentmappings.assignmentgenerate_id')
                        ->select(DB::raw('COUNT(*) as total_not_filled'))
                        ->get()
                        ->sum('total_not_filled');

                        $otherPartnerPending = DB::table('assignmentmappings')
                        ->leftJoin('annual_independence_declarations', function ($join) {
                        $join->on('annual_independence_declarations.assignmentgenerateid', '=',
                        'assignmentmappings.assignmentgenerate_id')
                        ->on('annual_independence_declarations.createdby', '=', 'assignmentmappings.otherpartner');
                        })
                        ->leftJoin('independences', function ($join) {
                        $join->on('independences.assignmentgenerate_id', '=',
                        'assignmentmappings.assignmentgenerate_id')
                        ->on('independences.createdby', '=', 'assignmentmappings.otherpartner');
                        })
                        ->whereNotNull('assignmentmappings.otherpartner')
                        ->whereNull(DB::raw('COALESCE(annual_independence_declarations.id, independences.id)'))
                        ->count();

                        $eqcrPartnerPending = DB::table('assignmentmappings')
                        ->leftJoin('annual_independence_declarations', function ($join) {
                        $join->on('annual_independence_declarations.assignmentgenerateid', '=',
                        'assignmentmappings.assignmentgenerate_id')
                        ->on('annual_independence_declarations.createdby', '=', 'assignmentmappings.eqcrpartner');
                        })
                        ->leftJoin('independences', function ($join) {
                        $join->on('independences.assignmentgenerate_id', '=',
                        'assignmentmappings.assignmentgenerate_id')
                        ->on('independences.createdby', '=', 'assignmentmappings.eqcrpartner');
                        })
                        ->whereNotNull('assignmentmappings.eqcrpartner')
                        ->whereNull(DB::raw('COALESCE(annual_independence_declarations.id, independences.id)'))
                        ->count();

                        $totalNotFilled = $teamPending + $otherPartnerPending + $eqcrPartnerPending;


                        // Assignment Status Overview
                        $assignmentOverviews = DB::table('assignmentmappings')
                        ->whereBetween('assignmentmappings.created_at', [$financialStartDate, $financialEndDate])
                        ->select(
                        'assignmentmappings.*',
                        'assignmentbudgetings.assignmentname',
                        'assignmentbudgetings.status',
                        DB::raw('COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate) as
                        finalassignmentenddate'),
                        'clients.client_name',
                        DB::raw('(SELECT SUM(totalhour) FROM timesheetusers WHERE timesheetusers.assignmentgenerate_id =
                        assignmentmappings.assignmentgenerate_id) as workedHours')
                        )
                        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=',
                        'assignmentmappings.assignmentgenerate_id')
                        ->leftJoin('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
                        ->orderByDesc('assignmentbudgetings.id')
                        // ->limit(3)
                        ->get()
                        ->map(function ($assignmentOverview) {
                        $totalHours = (float) ($assignmentOverview->esthours ?? 0);
                        $workedHours = (float) ($assignmentOverview->workedHours ?? 0);
                        $completionPercentage = $totalHours > 0 ? round(($workedHours / $totalHours) * 100, 2) : 0;
                        $assignmentOverview->completionPercentage = $completionPercentage;
                        return $assignmentOverview;
                        });



                        // Document Completion Progress
                        $documentCompletions = DB::table('assignmentmappings')
                        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=',
                        'assignmentmappings.assignmentgenerate_id')
                        ->leftJoin('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
                        // ->where('assignmentbudgetings.status', 1)
                        ->whereBetween('assignmentmappings.created_at', [$financialStartDate, $financialEndDate])
                        ->orderByDesc('assignmentbudgetings.id')
                        ->select(
                        'assignmentmappings.*',
                        'assignmentbudgetings.assignmentname',
                        'clients.client_name'
                        )
                        // ->limit(6)
                        ->get();

                        foreach ($documentCompletions as $mapping) {
                        $assignmentId = $mapping->assignmentgenerate_id;
                        $progressData = $this->calculateDocumentationProgress($assignmentId);

                        $mapping->eqcr_type_name = $progressData['eqcr_type_name'];
                        $mapping->documentation_percentage = $progressData['documentation_percentage'];
                        }
                        // Document Completion Progress end hare


                        // NFRA Audits, Quality Reviews & Peer Review
                        $ecqrAudits = DB::table('assignmentmappings')
                        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id',
                        'assignmentmappings.assignmentgenerate_id')
                        ->leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.eqcrpartner')
                        ->leftJoin('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
                        // ->where('assignmentbudgetings.status', 1)
                        ->whereBetween('assignmentmappings.created_at', [$financialStartDate, $financialEndDate])
                        ->whereIn('assignmentmappings.eqcrapplicability', [1, 2, 3])
                        ->select(
                        'assignmentmappings.*',
                        'teammembers.team_member',
                        'assignmentbudgetings.assignmentname',
                        'assignmentbudgetings.status',
                        DB::raw('COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate) as
                        finalassignmentenddate'),
                        'clients.client_name'
                        )
                        // ->limit(3)
                        ->get();

                        foreach ($ecqrAudits as $audit) {
                        $progressData = $this->calculateDocumentationProgressReviewer($audit);
                        $audit->eqcr_type_name = $progressData['eqcr_type_name'];
                        $audit->reviewer_documentation_percentage = $progressData['reviewer_documentation_percentage'];
                        }



                        // High Priority Tasks Pending
                        // $highpriorityAssignments = DB::table('assignmentmappings')
                        // ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id',
                        'assignmentmappings.assignmentgenerate_id')
                        // ->leftJoin('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
                        // ->select(
                        // 'assignmentmappings.*',
                        // 'assignmentbudgetings.assignmentname',
                        // DB::raw('COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate)
                        as
                        finalassignmentenddate'),
                        // 'clients.client_name'
                        // )
                        // ->limit(6)
                        // ->get();


                        // Fetch IT and Finance Tickets or Unresolved Tickets - HR, IT & Admin
                        $ticketDatas = Assetticket::with(['financerequest', 'createdBy', 'partner'])
                        ->whereIn('type', [0, 1])
                        ->whereBetween('created_at', [$financialStartDate, $financialEndDate])
                        ->orderByDesc('id')
                        // ->limit(4)
                        ->get()
                        ->map(function ($item) {
                        return [
                        'ticket_id' => $item->generateticket_id,
                        'department' => $item->type == 0 ? 'IT' : 'Finance',
                        'created_by' => $item->createdBy->team_member ?? '',
                        'subject' => $item->subject,
                        'assigned_to' => $item->partner->team_member ?? '',
                        'created_at' => $item->created_at,
                        'status' => $item->status,
                        'source' => 'ticket',
                        ];
                        });

                        // Fetch HR Tasks
                        $hrTickets = DB::table('tasks')
                        ->select(
                        'tasks.*',
                        'patnerid.team_member as partnername',
                        'createdby.team_member as createdbyname',
                        'hrfunctions.hrfunction'
                        )
                        ->where('tasks.task_type', 4)
                        ->whereBetween('tasks.created_at', [$financialStartDate, $financialEndDate])
                        ->leftJoin('teammembers as patnerid', 'patnerid.id', '=', 'tasks.partner_id')
                        ->leftJoin('teammembers as createdby', 'createdby.id', '=', 'tasks.createdby')
                        ->leftJoin('hrfunctions', 'hrfunctions.id', '=', 'tasks.hrfunction')
                        ->orderByDesc('tasks.id')
                        // ->limit(4)
                        ->get()
                        ->map(function ($item) {
                        return [
                        'ticket_id' => $item->generateticket_id ?? 'NA',
                        'department' => 'HR',
                        'created_by' => $item->createdbyname ?? '',
                        'subject' => $item->taskname ?? '',
                        'assigned_to' => $item->partnername ?? '',
                        'created_at' => $item->created_at,
                        'status' => $item->status,
                        'source' => 'hr',
                        ];
                        });

                        $allTickets = $ticketDatas->merge($hrTickets);

                        // Assignment-wise P&L Analysis and Break even of loss Making Assignments
                        $assignmentprofitandlosses = DB::table('assignmentmappings')
                        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=',
                        'assignmentmappings.assignmentgenerate_id')
                        ->leftJoin('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
                        ->whereBetween('assignmentmappings.created_at', [$financialStartDate, $financialEndDate])
                        ->orderByDesc('assignmentbudgetings.id')
                        ->select(
                        'assignmentmappings.*',
                        'assignmentbudgetings.assignmentname',
                        'assignmentbudgetings.status',
                        DB::raw('COALESCE(assignmentbudgetings.actualenddate, assignmentbudgetings.tentativeenddate) as
                        finalassignmentenddate'),
                        'clients.client_name'
                        )
                        // ->limit(6)
                        ->get();

                        $assignmentCosts = DB::table('timesheetusers')
                        ->leftJoin('teammembers', 'teammembers.id', '=', 'timesheetusers.createdby')
                        // ->where('timesheetusers.assignmentgenerate_id', 254418551033)
                        // ->whereBetween(DB::raw("STR_TO_DATE(timesheetusers.date, '%d-%m-%Y')"), [
                        // $financialStartDate->format('Y-m-d'),
                        // $financialEndDate->format('Y-m-d')
                        // ])
                        ->select('timesheetusers.assignmentgenerate_id', DB::raw('SUM(timesheetusers.totalhour *
                        teammembers.cost_hour)
                        as total_cost'))
                        ->groupBy('timesheetusers.assignmentgenerate_id')
                        ->pluck('total_cost', 'assignmentgenerate_id');

                        $conveyanceonlybillno = DB::table('outstationconveyances')
                        ->where('bill', 'No')
                        ->select(
                        'assignmentgenerate_id',
                        DB::raw('SUM(finalamount) as finalamounts')
                        )
                        ->groupBy('assignmentgenerate_id')
                        ->pluck('finalamounts', 'assignmentgenerate_id');


                        $lossMakingCount = 0;
                        foreach ($assignmentprofitandlosses as $assignment) {
                        $assignmentworkedcost = $assignmentCosts[$assignment->assignmentgenerate_id] ?? 0;
                        $assignmentconvencecost = $conveyanceonlybillno[$assignment->assignmentgenerate_id] ?? 0;
                        $assignment->total_cost = $assignmentworkedcost + $assignmentconvencecost;
                        // Break even of loss Making Assignments
                        $revenue = $assignment->engagementfee ?? 0;
                        $cost = $assignment->total_cost ?? 0;
                        $profit = $revenue - $cost;

                        if ($profit < 0) { $lossMakingCount++; } } // Upcoming Assignments
                            $upcomingFromPlannings=DB::table('assignmentplannings') ->where('status', 0)
                            ->whereDate('assignmentstartdate',
                            '<=', Carbon::today()->addDays(30)->endOfDay())
        ->count();

      $upcomingFromBudgetings = DB::table('assignmentbudgetings')
                            ->whereBetween(DB::raw('COALESCE(actualstartdate, tentativestartdate)'), [
                            Carbon::today()->startOfDay(),
                            Carbon::today()->addDays(30)->endOfDay()
                            ])
                            ->count();

                            $totalUpcomingAssignments = $upcomingFromPlannings + $upcomingFromBudgetings;


                            // How many amounts pending for collection within 15 days or Payments Not Recieved
                            $billspending15Daysdata = DB::table('assignmentmappings')
                            ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=',
                            'assignmentmappings.assignmentgenerate_id')
                            ->leftJoin('invoices', 'invoices.assignmentgenerate_id', '=',
                            'assignmentmappings.assignmentgenerate_id')
                            ->leftJoin('outstandings', 'outstandings.BILL_NO', '=', 'invoices.invoice_id')
                            ->whereNotNull('invoices.id')
                            ->where('assignmentbudgetings.status', 0)
                            ->where(function ($q) {
                            $q->whereIn('invoices.currency', [1, 3])
                            ->orWhereNull('invoices.currency');
                            })
                            ->whereBetween('invoices.created_at', [
                            Carbon::today()->subDays(15)->startOfDay(),
                            Carbon::today()->endOfDay()
                            // Carbon::yesterday()->endOfDay()
                            ])
                            ->select(
                            'invoices.currency',
                            // 'assignmentmappings.assignmentgenerate_id',
                            DB::raw("DATE_FORMAT(outstandings.created_at, '%Y-%m-%d') as bill_date"),
                            DB::raw('SUM(outstandings.AMT) as total_amount')
                            )
                            ->groupBy('invoices.currency', 'bill_date')
                            ->get();

                            $billspending15Days = $this->convertusdtoinr($billspending15Daysdata);

                            // Timesheet Filled On Closed Assignment
                            $timesheetOnClosedAssignment = DB::table('assignmentmappings')
                            ->join('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=',
                            'assignmentmappings.assignmentgenerate_id')
                            ->join('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
                            ->whereExists(function ($query) {
                            $query->select(DB::raw(1))
                            ->from('timesheetusers')
                            ->whereRaw('timesheetusers.assignmentgenerate_id =
                            assignmentmappings.assignmentgenerate_id')
                            ->whereRaw("DATE(timesheetusers.created_at) >
                            DATE(COALESCE(assignmentbudgetings.actualenddate,
                            assignmentbudgetings.tentativeenddate))");
                            })
                            ->select('assignmentmappings.assignmentgenerate_id')
                            ->distinct()
                            ->count();


                            // Partner-wise P&L Statement
                            $assignmentGenerateIds = DB::table('assignmentbudgetings')
                            ->whereBetween('periodstartdate', [$financialStartDate, $financialEndDate])
                            ->whereBetween('periodenddate', [$financialStartDate, $financialEndDate])
                            ->pluck('assignmentgenerate_id');

                            $invoicesdata = DB::table('invoices')
                            ->select(
                            'invoices.assignmentgenerate_id',
                            'invoices.currency',
                            'teammembers.team_member',
                            DB::raw("DATE_FORMAT(invoices.created_at, '%Y-%m-%d') as bill_date"),
                            DB::raw('SUM(invoices.total) as total_amount')
                            )
                            ->join('teammembers', 'teammembers.id', '=', 'invoices.partner')
                            ->whereIn('invoices.assignmentgenerate_id', $assignmentGenerateIds)
                            ->groupBy('invoices.assignmentgenerate_id', 'teammembers.team_member', 'invoices.currency',
                            'bill_date')
                            ->get();

                            $invoicesdata = $this->convertusdtoinr1($invoicesdata);

                            $invoices = $invoicesdata
                            ->groupBy('assignmentgenerate_id')
                            ->map(function ($items, $assignmentId) {
                            return (object)[
                            'assignmentgenerate_id' => $assignmentId,
                            'team_member' => $items->first()->team_member,
                            'total' => $items->sum('total_amount'),
                            ];
                            })
                            ->values();


                            $timesheetData = DB::table('timesheetusers')
                            ->select('assignmentgenerate_id', 'createdby', DB::raw('SUM(totalhour) as total_hour'))
                            ->whereIn('assignmentgenerate_id', $assignmentGenerateIds)
                            ->groupBy('assignmentgenerate_id', 'createdby')
                            ->get();

                            $teamMemberCosts = DB::table('teammembers')
                            ->whereIn('id', $timesheetData->pluck('createdby')->unique())
                            ->pluck('cost_hour', 'id');

                            $groupedCosts = $timesheetData->groupBy('assignmentgenerate_id')->map(function ($rows) use
                            ($teamMemberCosts) {
                            return $rows->sum(function ($row) use ($teamMemberCosts) {
                            return $row->total_hour * ($teamMemberCosts[$row->createdby] ?? 0);
                            });
                            });

                            $finalData = $invoices->map(function ($row) use ($groupedCosts, $conveyanceonlybillno) {
                            $workedcost = $groupedCosts[$row->assignmentgenerate_id] ?? 0;
                            $convencecostdata = $conveyanceonlybillno[$row->assignmentgenerate_id] ?? 0;
                            $row->cost = $workedcost + $convencecostdata;
                            $row->profit_loss = $row->total - $row->cost;
                            return $row;
                            });

                            $partnerWiseProfit = $finalData
                            ->groupBy('team_member')
                            ->map(function ($items, $teamMember) {
                            return (object)[
                            'team_member' => $teamMember,
                            'total' => $items->sum(fn($item) => (float) $item->total),
                            'cost' => $items->sum('cost'),
                            'profit_loss' => $items->sum('profit_loss'),
                            ];
                            })
                            // Reset index if needed
                            ->values();
                            // Partner-wise P&L Statement end hare


                            // Staff Allocation vs Actual Timesheet Analysis
                            $teamAllocatedHours = DB::table('timesheetusers')
                            ->join('teammembers', 'teammembers.id', '=', 'timesheetusers.createdby')
                            // ->whereIn('teammembers.id', [14, 23, 187, 305, 659, 815])
                            // ->whereNotIn('teammembers.role_id', [13])
                            ->whereBetween('timesheetusers.created_at', [
                            $financialStartDate,
                            $financialEndDate
                            ])
                            ->select(
                            'teammembers.id as teammember_id',
                            'teammembers.team_member',
                            'teammembers.role_id',
                            DB::raw('SUM(timesheetusers.totalhour) as actualhours')
                            )
                            ->groupBy('teammembers.id', 'teammembers.team_member', 'teammembers.role_id')
                            // ->limit(6)
                            ->get();


                            foreach ($teamAllocatedHours as $teamAllocatedHour) {
                            if ($teamAllocatedHour->role_id == 13) {
                            $allocatedHours1 = DB::table('assignmentmappings')
                            ->where('assignmentmappings.eqcrpartner', $teamAllocatedHour->teammember_id)
                            ->whereBetween('assignmentmappings.created_at', [
                            $financialStartDate,
                            $financialEndDate
                            ])
                            ->sum('assignmentmappings.eqcresthour');

                            $allocatedHours2 = DB::table('assignmentmappings')
                            ->where('assignmentmappings.leadpartner', $teamAllocatedHour->teammember_id)
                            ->whereBetween('assignmentmappings.created_at', [
                            $financialStartDate,
                            $financialEndDate
                            ])
                            ->sum('assignmentmappings.partneresthour');

                            $allocatedHours3 = DB::table('assignmentmappings')
                            ->where('assignmentmappings.otherpartner', $teamAllocatedHour->teammember_id)
                            ->whereBetween('assignmentmappings.created_at', [
                            $financialStartDate,
                            $financialEndDate
                            ])
                            ->sum('assignmentmappings.otherpartneresthour');

                            $allocatedHours = $allocatedHours1 + $allocatedHours2 + $allocatedHours3;
                            } else {
                            $allocatedHours = DB::table('assignmentteammappings')
                            ->where('assignmentteammappings.teammember_id', $teamAllocatedHour->teammember_id)
                            ->whereBetween('assignmentteammappings.created_at', [
                            $financialStartDate,
                            $financialEndDate
                            ])
                            ->sum('assignmentteammappings.teamesthour');
                            }

                            if (is_null($allocatedHours)) {
                            $allocatedHours = 0;
                            }
                            $teamAllocatedHour->teamallocatedhours = $allocatedHours;
                            $teamAllocatedHour->discrepancy = $teamAllocatedHour->actualhours - (float) $allocatedHours;
                            }

                            // Monthly Expense Analysis
                            // financial year
                            $teamsSalaries = DB::table('employeepayrolls')
                            ->select(
                            'month',
                            'year',
                            DB::raw('SUM(total_amount_to_paid) as total_amount')
                            )
                            ->where(function ($query) use ($financialEndYear, $financialStartYear) {
                            // Jan to Mar from next year
                            $query->where(function ($q) use ($financialEndYear) {
                            $q->where('year', $financialEndYear)
                            ->whereIn('month', ['January', 'February', 'March']);
                            })
                            // Apr to Jun from current year
                            ->orWhere(function ($q) use ($financialStartYear) {
                            $q->where('year', $financialStartYear)
                            ->whereIn('month', ['April', 'May', 'June', 'July', 'August', 'September', 'October',
                            'November',
                            'December']);
                            });
                            })
                            ->where('send_to_bank', 1)
                            ->groupBy('year', 'month')
                            ->orderByRaw("FIELD(month, 'April', 'May', 'June', 'July', 'August', 'September', 'October',
                            'November',
                            'December', 'January', 'February', 'March')")
                            ->get();

                            $teamexceptionalExpenses = DB::table('outstationconveyances')
                            ->selectRaw('MONTH(paiddate) as month, YEAR(paiddate) as year, SUM(finalamount) as
                            total_amount')
                            ->where('status', 6)
                            ->whereBetween('paiddate', [
                            $financialStartDate->format('Y-m-d'),
                            $financialEndDate->format('Y-m-d')
                            ])
                            ->groupByRaw('MONTH(paiddate), YEAR(paiddate)')
                            // ->orderByRaw('FIELD(MONTH(paiddate), 4,5,6,7,8,9,10,11,12,1,2,3)')
                            ->orderByRaw('FIELD(month, 4, 5, 6, 7, 8, 9, 10, 11, 12, 1, 2, 3)')
                            ->get()
                            ->map(function ($item) use ($monthNames) {
                            $item->month = $monthNames[$item->month] ?? $item->month;
                            return $item;
                            });


                            // Cash Flow Analysis
                            $cashFlowRecieved = DB::table('payments')
                            ->selectRaw('MONTH(paymentdate) as month, YEAR(paymentdate) as year, SUM(amountreceived) as
                            amountreceived')
                            ->whereBetween('paymentdate', [
                            $financialStartDate->format('Y-m-d'),
                            $financialEndDate->format('Y-m-d')
                            ])
                            ->groupByRaw('MONTH(paymentdate), YEAR(paymentdate)')
                            // ->orderByRaw('FIELD(MONTH(paymentdate), 4,5,6,7,8,9,10,11,12,1,2,3)')
                            ->orderByRaw('FIELD(month, 4, 5, 6, 7, 8, 9, 10, 11, 12, 1, 2, 3)')
                            ->get()
                            ->map(function ($item) use ($monthNames) {
                            $item->month = $monthNames[$item->month] ?? $item->month;
                            return $item;
                            });

                            $cashFlowSpendvender = DB::table('vendorlist')
                            ->selectRaw('MONTH(approvedate) as month, YEAR(approvedate) as year, SUM(amount) as
                            total_amounts')
                            ->where('status', 4)
                            ->whereBetween('approvedate', [
                            $financialStartDate->format('Y-m-d'),
                            $financialEndDate->format('Y-m-d')
                            ])
                            ->groupByRaw('MONTH(approvedate), YEAR(approvedate)')
                            // ->orderByRaw('FIELD(MONTH(approvedate), 4,5,6,7,8,9,10,11,12,1,2,3)')
                            ->orderByRaw('FIELD(month, 4, 5, 6, 7, 8, 9, 10, 11, 12, 1, 2, 3)')
                            ->get()
                            ->map(function ($item) use ($monthNames) {
                            $item->month = $monthNames[$item->month] ?? $item->month;
                            return $item;
                            });

                            $cashFlowSpendemployee = DB::table('employeepayrolls')
                            ->select('month', 'year', DB::raw('SUM(total_amount_to_paid) as total_amounts'))
                            ->where(function ($query) use ($financialEndYear, $financialStartYear) {
                            $query->where(function ($q) use ($financialEndYear) {
                            $q->where('year', $financialEndYear)
                            ->whereIn('month', ['January', 'February', 'March']);
                            })->orWhere(function ($q) use ($financialStartYear) {
                            $q->where('year', $financialStartYear)
                            ->whereIn('month', ['April', 'May', 'June', 'July', 'August', 'September', 'October',
                            'November',
                            'December']);
                            });
                            })
                            ->where('send_to_bank', 1)
                            ->groupBy('year', 'month')
                            ->orderByRaw("FIELD(month, 'April', 'May', 'June', 'July', 'August', 'September', 'October',
                            'November',
                            'December', 'January', 'February', 'March')")
                            ->get();

                            $mergedSpenddata = $cashFlowSpendvender->merge($cashFlowSpendemployee);

                            $cashFlowtotalspendData = $mergedSpenddata->groupBy(function ($item) {
                            return $item->month . '-' . $item->year;
                            })->map(function ($group) {
                            return (object) [
                            'month' => $group->first()->month,
                            'year' => $group->first()->year,
                            'total_amounts' => $group->sum('total_amounts'),
                            ];
                            })->sortBy(function ($item) {
                            $order = ['April', 'May', 'June', 'July', 'August', 'September', 'October', 'November',
                            'December',
                            'January', 'February', 'March'];
                            return array_search($item->month, $order);
                            })->values();

                            // Cash Flow Analysis end hare

                            // Budget vs Actual Cash Flow

                            // 1.budget table se budgetinflow
                            // 2.cash recieved in paymnets table
                            // 2.budget table se budgetoutflow
                            // 4.cash spend on employee and vender, like employeepayrolls and vendorlist tables

                            $budgetactualcash = DB::table('budget')
                            ->select('month', 'year', DB::raw('SUM(budgetinflow) as budgetinflow'),
                            DB::raw('SUM(budgetoutflow)
                            as
                            budgetoutflow'))
                            ->where(function ($query) use ($financialEndYear, $financialStartYear) {
                            $query->where(function ($q) use ($financialEndYear) {
                            $q->where('year', $financialEndYear)
                            ->whereIn('month', ['January', 'February', 'March']);
                            })->orWhere(function ($q) use ($financialStartYear) {
                            $q->where('year', $financialStartYear)
                            ->whereIn('month', ['April', 'May', 'June', 'July', 'August', 'September', 'October',
                            'November',
                            'December']);
                            });
                            })
                            ->groupBy('year', 'month')
                            ->orderByRaw("FIELD(month, 'April', 'May', 'June', 'July', 'August', 'September', 'October',
                            'November',
                            'December', 'January', 'February', 'March')")
                            ->get();


                            // Budget vs Actual Cash Flow end hare

                            // Invoice Due vs Assignment Billing vs Cash Recovery
                            $assignmentBillingdata = DB::table('invoices')
                            ->selectRaw("MONTH(created_at) as month, YEAR(created_at) as year, invoices.currency,
                            DATE_FORMAT(invoices.created_at, '%Y-%m-%d') as bill_date, SUM(total) as total_amount")
                            ->whereBetween('created_at', [
                            $financialStartDate,
                            $financialEndDate
                            ])
                            ->groupByRaw("MONTH(created_at), YEAR(created_at), invoices.currency,
                            DATE_FORMAT(invoices.created_at,
                            '%Y-%m-%d')")
                            // ->orderByRaw('FIELD(MONTH(created_at), 4,5,6,7,8,9,10,11,12,1,2,3)')
                            ->orderByRaw('FIELD(month, 4, 5, 6, 7, 8, 9, 10, 11, 12, 1, 2, 3)')
                            ->get()
                            ->map(function ($item) use ($monthNames) {
                            $item->month = $monthNames[$item->month] ?? $item->month;
                            return $item;
                            });

                            $assignmentBillingdata = $this->convertusdtoinr1($assignmentBillingdata);

                            $assignmentBilling = $assignmentBillingdata
                            ->groupBy('month')
                            ->map(function ($items, $month) {
                            return (object)[
                            'month' => $month,
                            'year' => $items->first()->year,
                            'total_amount' => $items->sum('total_amount'),
                            ];
                            })
                            ->values();

                            $assignmentOutstanding = DB::table('outstandings')
                            ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, SUM(AMT) as
                            outstanding_amount')
                            ->whereBetween('created_at', [
                            $financialStartDate,
                            $financialEndDate
                            ])
                            ->groupByRaw('MONTH(created_at), YEAR(created_at)')
                            // ->orderByRaw('FIELD(MONTH(created_at), 4,5,6,7,8,9,10,11,12,1,2,3)')
                            ->orderByRaw('FIELD(month, 4, 5, 6, 7, 8, 9, 10, 11, 12, 1, 2, 3)')
                            ->get()
                            ->map(function ($item) use ($monthNames) {
                            $item->month = $monthNames[$item->month] ?? $item->month;
                            return $item;
                            });

                            $cashRecovery = DB::table('payments')
                            ->selectRaw('MONTH(paymentdate) as month, YEAR(paymentdate) as year, SUM(amountreceived) as
                            amountreceived')
                            ->whereBetween('paymentdate', [
                            $financialStartDate->format('Y-m-d'),
                            $financialEndDate->format('Y-m-d')
                            ])
                            ->groupByRaw('MONTH(paymentdate), YEAR(paymentdate)')
                            // ->orderByRaw('FIELD(MONTH(paymentdate), 4,5,6,7,8,9,10,11,12,1,2,3)')
                            ->orderByRaw('FIELD(month, 4, 5, 6, 7, 8, 9, 10, 11, 12, 1, 2, 3)')
                            ->get()
                            ->map(function ($item) use ($monthNames) {
                            $item->month = $monthNames[$item->month] ?? $item->month;
                            return $item;
                            });

                            // Lap Days Analysis (Assignment to Invoice)
                            $assignmentsWithInvoices = DB::table('assignmentmappings')
                            ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=',
                            'assignmentmappings.assignmentgenerate_id')
                            // get only those assignments for which an invoice has been created
                            ->join('invoices', 'invoices.assignmentgenerate_id', '=',
                            'assignmentmappings.assignmentgenerate_id')
                            ->selectRaw('MONTH(assignmentbudgetings.otpverifydate) as month,
                            YEAR(assignmentbudgetings.otpverifydate) as
                            year, assignmentbudgetings.otpverifydate, invoices.created_at as invoice_created_at,
                            invoices.id as
                            invoice_id')
                            ->whereBetween('assignmentbudgetings.otpverifydate', [
                            $financialStartDate->format('Y-m-d'),
                            $financialEndDate->format('Y-m-d')
                            ])
                            // ->orderByRaw('FIELD(MONTH(assignmentbudgetings.otpverifydate),
                            1,2,3,4,5,6,7,8,9,10,11,12)')
                            ->orderByRaw('FIELD(month, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12)')
                            ->get()
                            ->map(function ($item) use ($monthNames) {
                            $assignmentclosedDate = Carbon::parse($item->otpverifydate);
                            $invoicecreatedDate = Carbon::parse($item->invoice_created_at);
                            $item->differenceDays = $assignmentclosedDate->diffInDays($invoicecreatedDate);
                            $item->targetDays = 7;
                            $item->month = $monthNames[$item->month] ?? $item->month;
                            return $item;
                            })
                            ->groupBy(fn($item) => $item->month . '-' . $item->year)
                            ->map(function ($group) {
                            $first = $group->first();
                            return (object) [
                            'month' => $first->month,
                            'year' => $first->year,
                            'otpverifydate' => $first->otpverifydate,
                            'invoice_id' => $first->invoice_id,
                            'invoice_created_at' => $first->invoice_created_at,
                            'targetDays' => $first->targetDays,
                            'differenceDays' => $group->sum('differenceDays'),
                            'countitem' => $group->count(),
                            // Average Difference Days = (sum of all differenceDays) / number of records
                            'averageDifferenceDays' => round($group->avg('differenceDays'), 1),
                            ];
                            })
                            ->sortBy(fn($item) => array_search($item->month, array_values($monthNames)))
                            ->values();

                            // Budget vs Actual P&L
                            // $budgetRevenueandbudgetExpences = DB::table('assignmentmappings')
                            // ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, SUM(engagementfee) as
                            engagementfee,
                            SUM(teamestcost) as total_teamestcost')
                            // ->whereBetween('created_at', [
                            // $financialStartDate,
                            // $financialEndDate
                            // ])
                            // ->groupByRaw('MONTH(created_at), YEAR(created_at)')
                            // // ->orderByRaw('FIELD(MONTH(created_at), 4,5,6,7,8,9,10,11,12,1,2,3)')
                            // ->orderByRaw('FIELD(month, 4, 5, 6, 7, 8, 9, 10, 11, 12, 1, 2, 3)')
                            // ->get()
                            // ->map(function ($item) use ($monthNames) {
                            // $item->month = $monthNames[$item->month] ?? $item->month;
                            // return $item;
                            // });


                            // $budgetActualRevenuedata = DB::table('invoices')
                            // ->selectRaw("MONTH(created_at) as month, YEAR(created_at) as year, invoices.currency,
                            DATE_FORMAT(invoices.created_at, '%Y-%m-%d') as bill_date, SUM(total) as total_amount")
                            // ->whereBetween('created_at', [
                            // $financialStartDate,
                            // $financialEndDate
                            // ])
                            // ->groupByRaw("MONTH(created_at), YEAR(created_at), invoices.currency,
                            DATE_FORMAT(invoices.created_at,
                            '%Y-%m-%d')")
                            // // ->orderByRaw('FIELD(MONTH(created_at), 4,5,6,7,8,9,10,11,12,1,2,3)')
                            // ->orderByRaw('FIELD(month, 4, 5, 6, 7, 8, 9, 10, 11, 12, 1, 2, 3)')
                            // ->get()
                            // ->map(function ($item) use ($monthNames) {
                            // $item->month = $monthNames[$item->month] ?? $item->month;
                            // return $item;
                            // });

                            // $budgetActualRevenuedata = $this->convertusdtoinr1($budgetActualRevenuedata);

                            // $budgetActualRevenue = $budgetActualRevenuedata
                            // ->groupBy('month')
                            // ->map(function ($items, $month) {
                            // return (object)[
                            // 'month' => $month,
                            // 'year' => $items->first()->year,
                            // 'total_amount' => $items->sum('total_amount'),
                            // ];
                            // })
                            // ->values();

                            // $budgetActualExpences = DB::table('timesheets')
                            // ->leftJoin('timesheetusers', 'timesheetusers.timesheetid', '=', 'timesheets.id')
                            // ->leftJoin('teammembers', 'teammembers.id', '=', 'timesheetusers.createdby')
                            // // ->whereIn('timesheets.created_by', [815, 818])
                            // ->selectRaw('MONTH(timesheets.date) as month, YEAR(timesheets.date) as year,
                            SUM(timesheetusers.totalhour
                            * teammembers.cost_hour) as total_cost')
                            // ->whereBetween('timesheets.date', [
                            // $financialStartDate->format('Y-m-d'),
                            // $financialEndDate->format('Y-m-d')
                            // ])
                            // ->groupByRaw('MONTH(timesheets.date), YEAR(timesheets.date)')
                            // ->get()
                            // ->map(function ($item) use ($monthNames) {
                            // $item->month = $monthNames[$item->month] ?? $item->month;
                            // return $item;
                            // });

                            // // Budget vs Actual P&L end hare

                            // Work From Home
                            // $workFromHome = DB::table('checkins')
                            // ->where('checkin_from', 'Work From Home')
                            // ->whereMonth('created_at', Carbon::now()->month)
                            // ->whereYear('created_at', Carbon::now()->year)
                            // ->count();


                            // filter data
                            $startYearforfilter = 2022;
                            $currentDatetoday = Carbon::now();
                            $currentYearforfilter = $currentDatetoday->year;
                            $currentMonthforfilter = $currentDatetoday->month;
                            $currentFinancialYear = $currentMonthforfilter >= 4 ? $currentYearforfilter :
                            $currentYearforfilter
                            - 1;

                            $financialYears = [];
                            for ($year = $startYearforfilter; $year <= $currentFinancialYear; $year++) {
                                $financialYears[]=[ 'value'=>
                                $year . '-' . ($year + 1),
                                ];
                                }

                                $financialYears = array_reverse($financialYears);

                                $partnerlist = Teammember::where('status', 1)
                                ->where('role_id', 13)
                                ->with('title')
                                ->orderBy('team_member', 'asc')
                                ->get();

                                session()->forget('_old_input');

                                // return view('backEnd.kgsdashboardreport', compact('assignmentcreatedthisyear',
                                'partnerlist',
                                'budgetactualcash', 'financialYears', 'workFromHome', 'budgetRevenueandbudgetExpences',
                                'budgetActualRevenue', 'budgetActualExpences', 'assignmentsWithInvoices',
                                'assignmentBilling',
                                'assignmentOutstanding', 'cashRecovery', 'cashFlowtotalspendData', 'cashFlowRecieved',
                                'teamexceptionalExpenses', 'teamsSalaries', 'teamAllocatedHours',
                                'timesheetOnClosedAssignment',
                                'totalNotFilled', 'partnerWiseProfit', 'lossMakingCount', 'billspending15Days',
                                'totalUpcomingAssignments', 'assignmentprofitandlosses', 'allTickets', 'hrTickets',
                                'ticketDatas',
                                'highpriorityAssignments', 'ecqrAudits', 'documentCompletions', 'assignmentOverviews',
                                'exceptionalExpenses', 'auditsDue', 'delayedAssignments', 'assignmentcompleted',
                                'billspendingforcollection', 'billspending'));
                                return view('backEnd.kgsdashboardreport', compact('assignmentcreatedthisyear',
                                'partnerlist',
                                'budgetactualcash', 'financialYears', 'assignmentsWithInvoices', 'assignmentBilling',
                                'assignmentOutstanding', 'cashRecovery', 'cashFlowtotalspendData', 'cashFlowRecieved',
                                'teamexceptionalExpenses', 'teamsSalaries', 'teamAllocatedHours',
                                'timesheetOnClosedAssignment',
                                'totalNotFilled', 'partnerWiseProfit', 'lossMakingCount', 'billspending15Days',
                                'totalUpcomingAssignments', 'assignmentprofitandlosses', 'allTickets', 'hrTickets',
                                'ticketDatas',
                                'ecqrAudits', 'documentCompletions', 'assignmentOverviews', 'exceptionalExpenses',
                                'auditsDue',
                                'delayedAssignments', 'assignmentcompleted', 'billspendingforcollection',
                                'billspending'));
                                } elseif (auth()->user()->role_id == 13) {

                                $monthsdigit = null;
                                $partnerId = auth()->user()->teammember_id;

                                // [$startYear, $endYear] = explode('-', $yearly);
                                $startYear = now()->month >= 4 ? now()->year : now()->year - 1;
                                $endYear = $startYear + 1;

                                $monthNames = [
                                1 => 'January',
                                2 => 'February',
                                3 => 'March',
                                4 => 'April',
                                5 => 'May',
                                6 => 'June',
                                7 => 'July',
                                8 => 'August',
                                9 => 'September',
                                10 => 'October',
                                11 => 'November',
                                12 => 'December',
                                ];

                                // financial year
                                $currentDate = Carbon::now();
                                // $currentDate = Carbon::parse('2024-07-01');
                                // $currentDate = Carbon::parse('2024-07-01 13:30:00');
                                $currentMonth4 = $currentDate->format('F');
                                if ($currentDate->month >= 4) {
                                // Current year financial year
                                $startDateFormatted = Carbon::create($currentDate->year, 4, 1);
                                $endDateFormatted = Carbon::create($currentDate->year + 1, 3, 31);
                                } else {
                                // Previous year financial year
                                $startDateFormatted = Carbon::create($currentDate->year - 1, 4, 1);
                                $endDateFormatted = Carbon::create($currentDate->year, 3, 31);
                                }

                                // ddd KPI Bills Pending for Generation assignmentOverviews
                                $billspending = DB::table('assignmentmappings')
                                ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id',
                                'assignmentmappings.assignmentgenerate_id')
                                ->leftJoin('invoices', 'invoices.assignmentgenerate_id', '=',
                                'assignmentmappings.assignmentgenerate_id')
                                ->whereNull('invoices.assignmentgenerate_id')
                                ->when(!empty($partnerId), function ($query) use ($partnerId) {
                                $query->where('assignmentmappings.leadpartner', $partnerId);
                                // $query->where('assignmentmappings.leadpartner', $partnerId)
                                // ->orWhere('assignmentmappings.otherpartner', $partnerId);
                                })
                                ->where('assignmentbudgetings.status', 0)
                                ->sum('assignmentmappings.engagementfee');


                                // ddd KPI Collection's Outstanding
                                $outstandingBills = DB::table('assignmentmappings')
                                ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=',
                                'assignmentmappings.assignmentgenerate_id')
                                ->leftJoin('invoices', 'invoices.assignmentgenerate_id', '=',
                                'assignmentmappings.assignmentgenerate_id')
                                ->leftJoin('outstandings', 'outstandings.BILL_NO', '=', 'invoices.invoice_id')
                                ->when(!empty($partnerId), function ($query) use ($partnerId) {
                                $query->where('invoices.partner', $partnerId);
                                })
                                ->whereNotNull('invoices.id')
                                ->where('assignmentbudgetings.status', 0)
                                // ->whereIn('invoices.currency', [1, 3])
                                ->where(function ($q) {
                                $q->whereIn('invoices.currency', [1, 3])
                                ->orWhereNull('invoices.currency');
                                })
                                ->select(
                                'invoices.currency',
                                // 'assignmentmappings.assignmentgenerate_id',
                                DB::raw("DATE_FORMAT(outstandings.created_at, '%Y-%m-%d') as bill_date"),
                                DB::raw('SUM(outstandings.AMT) as total_amount')
                                )
                                ->groupBy('invoices.currency', 'bill_date')
                                ->get();


                                $billspendingforcollection = $this->convertusdtoinr($outstandingBills);

                                // ddd KPI How many amounts pending for collection within 15 days or Payments Not
                                Recieved
                                $billspending15Daysdata = DB::table('assignmentmappings')
                                ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=',
                                'assignmentmappings.assignmentgenerate_id')
                                ->leftJoin('invoices', 'invoices.assignmentgenerate_id', '=',
                                'assignmentmappings.assignmentgenerate_id')
                                ->leftJoin('outstandings', 'outstandings.BILL_NO', '=', 'invoices.invoice_id')
                                ->when(!empty($partnerId), function ($query) use ($partnerId) {
                                $query->where('invoices.partner', $partnerId);
                                })
                                ->whereNotNull('invoices.id')
                                ->where('assignmentbudgetings.status', 0)
                                // ->whereIn('invoices.currency', [1, 3])
                                ->where(function ($q) {
                                $q->whereIn('invoices.currency', [1, 3])
                                ->orWhereNull('invoices.currency');
                                })
                                ->whereBetween('invoices.created_at', [
                                Carbon::today()->subDays(15)->startOfDay(),
                                Carbon::today()->endOfDay()
                                // Carbon::yesterday()->endOfDay()
                                ])
                                ->select(
                                'invoices.currency',
                                // 'assignmentmappings.assignmentgenerate_id',
                                DB::raw("DATE_FORMAT(outstandings.created_at, '%Y-%m-%d') as bill_date"),
                                DB::raw('SUM(outstandings.AMT) as total_amount')
                                )
                                ->groupBy('invoices.currency', 'bill_date')
                                ->get();


                                $billspending15Days = $this->convertusdtoinr($billspending15Daysdata);

                                // ddd Assignments Completed
                                $query = DB::table('assignmentbudgetings')
                                ->join('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', '=',
                                'assignmentbudgetings.assignmentgenerate_id')
                                // Invoice is created
                                ->join('invoices', 'invoices.assignmentgenerate_id', '=',
                                'assignmentbudgetings.assignmentgenerate_id')
                                ->where('assignmentbudgetings.status', 0)
                                ->whereNotNull('assignmentbudgetings.percentclosedate'); // Documentation 100% done
                                $query->whereBetween('assignmentbudgetings.otpverifydate', [$startDateFormatted,
                                $endDateFormatted]);
                                if (!empty($partnerId)) {
                                $query->where('assignmentmappings.leadpartner', $partnerId);
                                }
                                $assignmentcompleted = $query->distinct('assignmentbudgetings.assignmentgenerate_id')
                                ->count('assignmentbudgetings.assignmentgenerate_id');


                                $assignmentcreatedthisyear = DB::table('assignmentmappings')
                                ->whereBetween('created_at', [$startDateFormatted, $endDateFormatted])
                                ->when(!empty($partnerId), function ($query) use ($partnerId) {
                                $query->where('leadpartner', $partnerId);
                                })
                                ->count();


                                // ddd KPI How many Delayed Assignments
                                $delayedAssignments = DB::table('assignmentmappings')
                                ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=',
                                'assignmentmappings.assignmentgenerate_id')
                                ->where(function ($q) {
                                $q->where(function ($sub) {
                                $sub->where('assignmentbudgetings.status', 1)
                                // Delayed if Documentation < 100% OR Draft Report Date> Tentative End Date
                                    ->where(function ($inner) {
                                    $inner->whereNull('assignmentbudgetings.percentclosedate')
                                    ->orWhereRaw('assignmentbudgetings.finaldraftreportdate >
                                    assignmentbudgetings.tentativeenddate');
                                    });
                                    })
                                    // if worked hour > esthour
                                    ->orWhereRaw('(
                                    SELECT COALESCE(SUM(totalhour), 0)
                                    FROM timesheetusers
                                    WHERE assignmentgenerate_id = assignmentmappings.assignmentgenerate_id
                                    ) > assignmentmappings.esthours');
                                    })
                                    ->when(!empty($partnerId), function ($query) use ($partnerId) {
                                    $query->where('assignmentmappings.leadpartner', $partnerId);
                                    })
                                    ->count();


                                    // ddd total amount of convence, how many amount approved for convence in this
                                    months or
                                    Other
                                    Expenses
                                    $exceptionalQuery = DB::table('outstationconveyances')
                                    ->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', '=',
                                    'outstationconveyances.assignmentgenerate_id')
                                    ->where('outstationconveyances.status', 6);
                                    if (!empty($partnerId)) {
                                    $exceptionalQuery->where('assignmentmappings.leadpartner', $partnerId);
                                    }

                                    $exceptionalExpensesData = $exceptionalQuery->sum('finalamount');


                                    $vendorlist = DB::table('vendorlist')
                                    ->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', '=',
                                    'vendorlist.assignmentgenerate_id')
                                    // approved data
                                    ->where('vendorlist.status', 1)
                                    ->when(!empty($partnerId), function ($query) use ($partnerId) {
                                    $query->where('assignmentmappings.leadpartner', $partnerId);
                                    })
                                    ->sum('vendorlist.amount');

                                    $exceptionalExpenses = $exceptionalExpensesData + $vendorlist;



                                    // ddd Independence Acceptance Pending
                                    $teamPending = DB::table('assignmentmappings')
                                    ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id',
                                    '=',
                                    'assignmentmappings.assignmentgenerate_id')
                                    ->leftJoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id',
                                    '=',
                                    'assignmentmappings.id')
                                    ->leftJoin('teammembers', 'teammembers.id', '=',
                                    'assignmentteammappings.teammember_id')
                                    ->leftJoin('annual_independence_declarations', function ($join) {
                                    $join->on('annual_independence_declarations.assignmentgenerateid', '=',
                                    'assignmentmappings.assignmentgenerate_id')
                                    ->on('annual_independence_declarations.createdby', '=', 'teammembers.id');
                                    // ->where('annual_independence_declarations.type', 2);
                                    })
                                    ->leftJoin('independences', function ($join) {
                                    $join->on('independences.assignmentgenerate_id', '=',
                                    'assignmentmappings.assignmentgenerate_id')
                                    ->on('independences.createdby', '=', 'teammembers.id');
                                    })
                                    ->when(!empty($partnerId), function ($query) use ($partnerId) {
                                    $query->where('assignmentmappings.leadpartner', $partnerId);
                                    })
                                    ->whereNull(DB::raw('COALESCE(annual_independence_declarations.id,
                                    independences.id)')) //
                                    Members
                                    without declarations
                                    ->groupBy('assignmentmappings.assignmentgenerate_id')
                                    ->select(DB::raw('COUNT(*) as total_not_filled'))
                                    ->get()
                                    ->sum('total_not_filled');


                                    $otherPartnerPending = DB::table('assignmentmappings')
                                    ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id',
                                    '=',
                                    'assignmentmappings.assignmentgenerate_id')
                                    ->leftJoin('teammembers', 'teammembers.id', '=', 'assignmentmappings.otherpartner')
                                    ->leftJoin('annual_independence_declarations', function ($join) {
                                    $join->on('annual_independence_declarations.assignmentgenerateid', '=',
                                    'assignmentmappings.assignmentgenerate_id')
                                    ->on('annual_independence_declarations.createdby', '=',
                                    'assignmentmappings.otherpartner');
                                    })
                                    ->leftJoin('independences', function ($join) {
                                    $join->on('independences.assignmentgenerate_id', '=',
                                    'assignmentmappings.assignmentgenerate_id')
                                    ->on('independences.createdby', '=', 'assignmentmappings.otherpartner');
                                    })
                                    ->when(!empty($partnerId), function ($query) use ($partnerId) {
                                    $query->where('assignmentmappings.leadpartner', $partnerId);
                                    })
                                    ->whereNotNull('assignmentmappings.otherpartner')
                                    ->whereNull(DB::raw('COALESCE(annual_independence_declarations.id,
                                    independences.id)'))
                                    ->count();

                                    $eqcrPartnerPending = DB::table('assignmentmappings')
                                    ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id',
                                    '=',
                                    'assignmentmappings.assignmentgenerate_id')
                                    ->leftJoin('teammembers', 'teammembers.id', '=', 'assignmentmappings.eqcrpartner')
                                    ->leftJoin('annual_independence_declarations', function ($join) {
                                    $join->on('annual_independence_declarations.assignmentgenerateid', '=',
                                    'assignmentmappings.assignmentgenerate_id')
                                    ->on('annual_independence_declarations.createdby', '=',
                                    'assignmentmappings.eqcrpartner');
                                    })
                                    ->leftJoin('independences', function ($join) {
                                    $join->on('independences.assignmentgenerate_id', '=',
                                    'assignmentmappings.assignmentgenerate_id')
                                    ->on('independences.createdby', '=', 'assignmentmappings.eqcrpartner');
                                    })
                                    ->when(!empty($partnerId), function ($query) use ($partnerId) {
                                    $query->where('assignmentmappings.leadpartner', $partnerId);
                                    })
                                    ->whereNotNull('assignmentmappings.eqcrpartner')
                                    ->whereNull(DB::raw('COALESCE(annual_independence_declarations.id,
                                    independences.id)'))
                                    ->count();


                                    $totalNotFilled = $teamPending + $otherPartnerPending + $eqcrPartnerPending;



                                    // ddd NFRA Audits Ongoing totalNotFilled
                                    $auditsDueQuery = DB::table('assignmentmappings')
                                    ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id',
                                    'assignmentmappings.assignmentgenerate_id')
                                    ->where('assignmentbudgetings.status', 1)
                                    ->where('assignmentmappings.eqcrapplicability', 1);
                                    if (!empty($partnerId)) {
                                    $auditsDueQuery->where('assignmentmappings.leadpartner', $partnerId);
                                    }

                                    $auditsDue = $auditsDueQuery->count();


                                    // ddd Upcoming Assignments
                                    $upcomingQuery = DB::table('assignmentplannings')
                                    ->where('status', 0)
                                    ->whereDate('assignmentstartdate',
                                    '<=', Carbon::today()->addDays(30)->endOfDay());
      if (!empty($partnerId)) {
        $upcomingQuery->where('assignmentplannings.engagementpartner',
                                    $partnerId);
                                    }
                                    $upcomingFromPlannings = $upcomingQuery->count();


                                    $upcomingFromBudgetingsQuery = DB::table('assignmentbudgetings')
                                    ->join('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', '=',
                                    'assignmentbudgetings.assignmentgenerate_id')
                                    ->whereBetween(DB::raw('COALESCE(assignmentbudgetings.actualstartdate,
                                    assignmentbudgetings.tentativestartdate)'), [
                                    Carbon::today()->startOfDay(),
                                    Carbon::today()->addDays(30)->endOfDay()
                                    ]);
                                    if (!empty($partnerId)) {
                                    $upcomingFromBudgetingsQuery->where('assignmentmappings.leadpartner', $partnerId);
                                    }

                                    $upcomingFromBudgetings = $upcomingFromBudgetingsQuery->count();
                                    $totalUpcomingAssignments = $upcomingFromPlannings + $upcomingFromBudgetings;



                                    // filter KPI Timesheet Filled On Closed Assignment
                                    $timesheetOnClosedAssignment = DB::table('assignmentmappings')
                                    ->join('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=',
                                    'assignmentmappings.assignmentgenerate_id')
                                    ->join('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
                                    ->whereExists(function ($query) {
                                    $query->select(DB::raw(1))
                                    ->from('timesheetusers')
                                    ->whereRaw('timesheetusers.assignmentgenerate_id =
                                    assignmentmappings.assignmentgenerate_id')
                                    ->whereRaw("DATE(timesheetusers.created_at) >
                                    DATE(COALESCE(assignmentbudgetings.actualenddate,
                                    assignmentbudgetings.tentativeenddate))");
                                    })
                                    ->whereBetween(DB::raw('COALESCE(assignmentbudgetings.actualenddate,
                                    assignmentbudgetings.tentativeenddate)'), [$startDateFormatted, $endDateFormatted])
                                    // ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
                                    // $query->whereMonth(DB::raw('COALESCE(assignmentbudgetings.actualenddate,
                                    assignmentbudgetings.tentativeenddate)'), $monthsdigit);
                                    // })
                                    ->when(!empty($partnerId), function ($query) use ($partnerId) {
                                    $query->where('assignmentmappings.leadpartner', $partnerId);
                                    })
                                    ->select('assignmentmappings.assignmentgenerate_id')
                                    ->distinct()
                                    ->count();

                                    // filter KPI Work From Home
                                    // $workFromHomeQuery = DB::table('checkins')
                                    // ->where('checkin_from', 'Work From Home')
                                    // ->whereBetween('created_at', [$startDateFormatted, $endDateFormatted]);
                                    // if (!empty($monthsdigit)) {
                                    // $workFromHomeQuery->whereMonth('created_at', $monthsdigit);
                                    // }
                                    // // if (!empty($partnerId)) {hide this is hidden from UI
                                    // // $workFromHomeQuery->where('assignmentmappings.leadpartner', $partnerId);
                                    // // }
                                    // $workFromHome = $workFromHomeQuery->count();

                                    // KPI filter end from hare

                                    // dddd, Assignment Status Overview
                                    $assignmentOverviews = DB::table('assignmentmappings')
                                    ->whereBetween('assignmentmappings.created_at', [$startDateFormatted,
                                    $endDateFormatted])
                                    ->when(!empty($partnerId), function ($query) use ($partnerId) {
                                    $query->where('assignmentmappings.leadpartner', $partnerId);
                                    })
                                    ->select(
                                    'assignmentmappings.*',
                                    'assignmentbudgetings.assignmentname',
                                    'assignmentbudgetings.status',
                                    DB::raw('COALESCE(assignmentbudgetings.actualenddate,
                                    assignmentbudgetings.tentativeenddate)
                                    as
                                    finalassignmentenddate'),
                                    'clients.client_name',
                                    DB::raw('(SELECT SUM(totalhour) FROM timesheetusers WHERE
                                    timesheetusers.assignmentgenerate_id =
                                    assignmentmappings.assignmentgenerate_id) as workedHours')
                                    )
                                    ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id',
                                    '=',
                                    'assignmentmappings.assignmentgenerate_id')
                                    ->leftJoin('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
                                    ->orderByDesc('assignmentbudgetings.id')
                                    ->get()
                                    ->map(function ($assignmentOverview) {
                                    $totalHours = (float) ($assignmentOverview->esthours ?? 0);
                                    $workedHours = (float) ($assignmentOverview->workedHours ?? 0);
                                    $completionPercentage = $totalHours > 0 ? round(($workedHours / $totalHours) * 100,
                                    2) : 0;
                                    $assignmentOverview->completionPercentage = $completionPercentage;
                                    return $assignmentOverview;
                                    });


                                    // dddd, Document Completion Progress
                                    $documentCompletions = DB::table('assignmentmappings')
                                    ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id',
                                    '=',
                                    'assignmentmappings.assignmentgenerate_id')
                                    ->leftJoin('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
                                    // ->where('assignmentbudgetings.status', 1)
                                    ->whereBetween('assignmentmappings.created_at', [$startDateFormatted,
                                    $endDateFormatted])
                                    ->when(!empty($partnerId), function ($query) use ($partnerId) {
                                    $query->where('assignmentmappings.leadpartner', $partnerId);
                                    })
                                    ->orderByDesc('assignmentbudgetings.id')
                                    ->select(
                                    'assignmentmappings.*',
                                    'assignmentbudgetings.assignmentname',
                                    'clients.client_name'
                                    )
                                    ->get();

                                    foreach ($documentCompletions as $mapping) {
                                    $assignmentId = $mapping->assignmentgenerate_id;
                                    $progressData = $this->calculateDocumentationProgress($assignmentId);

                                    $mapping->eqcr_type_name = $progressData['eqcr_type_name'];
                                    $mapping->documentation_percentage = $progressData['documentation_percentage'];
                                    }
                                    // Document Completion Progress end hare


                                    // dddd NFRA Audits, Quality Reviews & Peer Review
                                    $ecqrAudits = DB::table('assignmentmappings')
                                    ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id',
                                    'assignmentmappings.assignmentgenerate_id')
                                    ->leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.eqcrpartner')
                                    ->leftJoin('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
                                    // ->where('assignmentbudgetings.status', 1)
                                    ->whereBetween('assignmentmappings.created_at', [$startDateFormatted,
                                    $endDateFormatted])
                                    ->when(!empty($partnerId), function ($query) use ($partnerId) {
                                    $query->where('assignmentmappings.leadpartner', $partnerId);
                                    })
                                    ->whereIn('assignmentmappings.eqcrapplicability', [1, 2, 3])
                                    ->select(
                                    'assignmentmappings.*',
                                    'teammembers.team_member',
                                    'assignmentbudgetings.assignmentname',
                                    'assignmentbudgetings.status',
                                    DB::raw('COALESCE(assignmentbudgetings.actualenddate,
                                    assignmentbudgetings.tentativeenddate)
                                    as
                                    finalassignmentenddate'),
                                    'clients.client_name'
                                    )
                                    // ->limit(3)
                                    ->get();

                                    foreach ($ecqrAudits as $audit) {
                                    $progressData = $this->calculateDocumentationProgressReviewer($audit);
                                    $audit->eqcr_type_name = $progressData['eqcr_type_name'];
                                    $audit->reviewer_documentation_percentage =
                                    $progressData['reviewer_documentation_percentage'];
                                    }

                                    // dd($ecqrAudits);

                                    // ddd // dddd, Assignment-wise P&L Analysis and Break even of loss Making
                                    Assignments
                                    $assignmentprofitandlosses = DB::table('assignmentmappings')
                                    ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id',
                                    '=',
                                    'assignmentmappings.assignmentgenerate_id')
                                    ->leftJoin('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
                                    ->whereBetween('assignmentmappings.created_at', [$startDateFormatted,
                                    $endDateFormatted])
                                    ->when(!empty($partnerId), function ($query) use ($partnerId) {
                                    $query->where('assignmentmappings.leadpartner', $partnerId);
                                    })
                                    ->orderByDesc('assignmentbudgetings.id')
                                    ->select(
                                    'assignmentmappings.*',
                                    'assignmentbudgetings.assignmentname',
                                    'assignmentbudgetings.status',
                                    DB::raw('COALESCE(assignmentbudgetings.actualenddate,
                                    assignmentbudgetings.tentativeenddate)
                                    as
                                    finalassignmentenddate'),
                                    'clients.client_name'
                                    )
                                    // ->limit(6)
                                    ->get();

                                    $assignmentCosts = DB::table('timesheetusers')
                                    ->leftJoin('teammembers', 'teammembers.id', '=', 'timesheetusers.createdby')
                                    // ->where('timesheetusers.assignmentgenerate_id', 254418551033)
                                    // ->whereBetween(DB::raw("STR_TO_DATE(timesheetusers.date, '%d-%m-%Y')"), [
                                    // $financialStartDate->format('Y-m-d'),
                                    // $financialEndDate->format('Y-m-d')
                                    // ])
                                    ->select('timesheetusers.assignmentgenerate_id',
                                    DB::raw('SUM(timesheetusers.totalhour *
                                    teammembers.cost_hour) as total_cost'))
                                    ->groupBy('timesheetusers.assignmentgenerate_id')
                                    ->pluck('total_cost', 'assignmentgenerate_id');

                                    $conveyanceonlybillno = DB::table('outstationconveyances')
                                    ->where('bill', 'No')
                                    ->select(
                                    'assignmentgenerate_id',
                                    DB::raw('SUM(finalamount) as finalamounts')
                                    )
                                    ->groupBy('assignmentgenerate_id')
                                    ->pluck('finalamounts', 'assignmentgenerate_id');


                                    $lossMakingCount = 0;
                                    foreach ($assignmentprofitandlosses as $assignment) {
                                    $assignmentworkedcost = $assignmentCosts[$assignment->assignmentgenerate_id] ?? 0;
                                    $assignmentconvencecost = $conveyanceonlybillno[$assignment->assignmentgenerate_id]
                                    ?? 0;
                                    $assignment->total_cost = $assignmentworkedcost + $assignmentconvencecost;
                                    // Break even of loss Making Assignments
                                    $revenue = $assignment->engagementfee ?? 0;
                                    $cost = $assignment->total_cost ?? 0;
                                    $profit = $revenue - $cost;

                                    if ($profit < 0) { $lossMakingCount++; } } // dddd teamsSalaries , Partner-wise P&L
                                        Statement $assignmentGenerateIds=DB::table('assignmentmappings') ->
                                        leftJoin('assignmentbudgetings',
                                        'assignmentbudgetings.assignmentgenerate_id', '=',
                                        'assignmentmappings.assignmentgenerate_id')
                                        ->whereBetween('assignmentbudgetings.periodstartdate', [$startDateFormatted,
                                        $endDateFormatted])
                                        ->whereBetween('assignmentbudgetings.periodenddate', [$startDateFormatted,
                                        $endDateFormatted])
                                        ->when(!empty($partnerId), function ($query) use ($partnerId) {
                                        $query->where('assignmentmappings.leadpartner', $partnerId);
                                        })
                                        ->pluck('assignmentmappings.assignmentgenerate_id');


                                        $invoicesdata = DB::table('invoices')
                                        ->select(
                                        'invoices.assignmentgenerate_id',
                                        'invoices.currency',
                                        'teammembers.team_member',
                                        DB::raw("DATE_FORMAT(invoices.created_at, '%Y-%m-%d') as bill_date"),
                                        DB::raw('SUM(invoices.total) as total_amount')
                                        )
                                        ->join('teammembers', 'teammembers.id', '=', 'invoices.partner')
                                        ->whereIn('invoices.assignmentgenerate_id', $assignmentGenerateIds)
                                        ->groupBy('invoices.assignmentgenerate_id', 'teammembers.team_member',
                                        'invoices.currency',
                                        'bill_date')
                                        ->get();

                                        $invoicesdata = $this->convertusdtoinr1($invoicesdata);

                                        $invoices = $invoicesdata
                                        ->groupBy('assignmentgenerate_id')
                                        ->map(function ($items, $assignmentId) {
                                        return (object)[
                                        'assignmentgenerate_id' => $assignmentId,
                                        'team_member' => $items->first()->team_member,
                                        'total' => $items->sum('total_amount'),
                                        ];
                                        })
                                        ->values();

                                        $timesheetData = DB::table('timesheetusers')
                                        ->select('assignmentgenerate_id', 'createdby', DB::raw('SUM(totalhour) as
                                        total_hour'))
                                        ->whereIn('assignmentgenerate_id', $assignmentGenerateIds)
                                        ->groupBy('assignmentgenerate_id', 'createdby')
                                        ->get();

                                        $teamMemberCosts = DB::table('teammembers')
                                        ->whereIn('id', $timesheetData->pluck('createdby')->unique())
                                        ->pluck('cost_hour', 'id');

                                        $groupedCosts = $timesheetData->groupBy('assignmentgenerate_id')->map(function
                                        ($rows)
                                        use
                                        ($teamMemberCosts) {
                                        return $rows->sum(function ($row) use ($teamMemberCosts) {
                                        return $row->total_hour * ($teamMemberCosts[$row->createdby] ?? 0);
                                        });
                                        });

                                        $finalData = $invoices->map(function ($row) use ($groupedCosts,
                                        $conveyanceonlybillno) {
                                        $workedcost = $groupedCosts[$row->assignmentgenerate_id] ?? 0;
                                        $convencecostdata = $conveyanceonlybillno[$row->assignmentgenerate_id] ?? 0;
                                        $row->cost = $workedcost + $convencecostdata;
                                        $row->profit_loss = $row->total - $row->cost;
                                        return $row;
                                        });

                                        $partnerWiseProfit = $finalData
                                        ->groupBy('team_member')
                                        ->map(function ($items, $teamMember) {
                                        return (object)[
                                        'team_member' => $teamMember,
                                        'total' => $items->sum(fn($item) => (float) $item->total),
                                        'cost' => $items->sum('cost'),
                                        'profit_loss' => $items->sum('profit_loss'),
                                        ];
                                        })
                                        // Reset index if needed
                                        ->values();

                                        // Partner-wise P&L Statement end hare

                                        // dddd Monthly Expense Analysis
                                        $teamsSalaries = DB::table('employeepayrolls')
                                        ->select(
                                        'month',
                                        'year',
                                        DB::raw('SUM(total_amount_to_paid) as total_amount')
                                        )
                                        ->where(function ($query) use ($endYear, $startYear) {
                                        // Jan to Mar from next year
                                        $query->where(function ($q) use ($endYear) {
                                        $q->where('year', $endYear);
                                        // ->whereIn('month', ['January', 'February', 'March']);
                                        })
                                        // Apr to Jun from current year
                                        ->orWhere(function ($q) use ($startYear) {
                                        $q->where('year', $startYear);
                                        // ->whereIn('month', ['April', 'May', 'June', 'July', 'August', 'September',
                                        'October',
                                        'November', 'December']);
                                        });
                                        })
                                        ->where('send_to_bank', 1)
                                        ->when(!empty($partnerId), function ($query) use ($partnerId) {
                                        $query->where('createdby', $partnerId);
                                        })
                                        ->groupBy('year', 'month')
                                        ->orderByRaw("FIELD(month, 'April', 'May', 'June', 'July', 'August',
                                        'September',
                                        'October',
                                        'November', 'December', 'January', 'February', 'March')")
                                        ->get();



                                        $teamexceptionalExpenses = DB::table('outstationconveyances')
                                        ->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id',
                                        '=',
                                        'outstationconveyances.assignmentgenerate_id')
                                        ->selectRaw('MONTH(outstationconveyances.paiddate) as month,
                                        YEAR(outstationconveyances.paiddate) as year,
                                        SUM(outstationconveyances.finalamount) as
                                        total_amount')
                                        ->where('outstationconveyances.status', 6)
                                        ->whereBetween('outstationconveyances.paiddate', [
                                        $startDateFormatted,
                                        $endDateFormatted
                                        ])
                                        ->when(!empty($partnerId), function ($query) use ($partnerId) {
                                        $query->where('assignmentmappings.leadpartner', $partnerId);
                                        })
                                        ->groupByRaw('MONTH(outstationconveyances.paiddate),
                                        YEAR(outstationconveyances.paiddate)')
                                        // ->orderByRaw('FIELD(MONTH(outstationconveyances.paiddate),
                                        4,5,6,7,8,9,10,11,12,1,2,3)')
                                        ->orderByRaw('FIELD(month, 4, 5, 6, 7, 8, 9, 10, 11, 12, 1, 2, 3)')
                                        ->get()
                                        ->map(function ($item) use ($monthNames) {
                                        $item->month = $monthNames[$item->month] ?? $item->month;
                                        return $item;
                                        });

                                        // dddd Cash Flow Analysis
                                        $cashFlowRecieved = DB::table('payments')
                                        ->leftJoin('invoices', 'invoices.invoice_id', '=', 'payments.invoiceid')
                                        ->selectRaw('MONTH(paymentdate) as month, YEAR(paymentdate) as year,
                                        SUM(amountreceived)
                                        as
                                        amountreceived')
                                        ->whereBetween('paymentdate', [
                                        $startDateFormatted,
                                        $endDateFormatted
                                        ])
                                        ->when(!empty($partnerId), function ($query) use ($partnerId) {
                                        $query->where('invoices.partner', $partnerId);
                                        })
                                        ->groupByRaw('MONTH(paymentdate), YEAR(paymentdate)')
                                        // ->orderByRaw('FIELD(MONTH(paymentdate), 4,5,6,7,8,9,10,11,12,1,2,3)')
                                        ->orderByRaw('FIELD(month, 4, 5, 6, 7, 8, 9, 10, 11, 12, 1, 2, 3)')
                                        ->get()
                                        ->map(function ($item) use ($monthNames) {
                                        $item->month = $monthNames[$item->month] ?? $item->month;
                                        return $item;
                                        });

                                        $cashFlowSpendvender = DB::table('vendorlist')
                                        ->selectRaw('MONTH(approvedate) as month, YEAR(approvedate) as year, SUM(amount)
                                        as
                                        total_amounts')
                                        ->where('status', 4)
                                        ->whereBetween('approvedate', [
                                        $startDateFormatted,
                                        $endDateFormatted
                                        ])
                                        ->when(!empty($partnerId), function ($query) use ($partnerId) {
                                        $query->where('approver', $partnerId);
                                        })
                                        ->groupByRaw('MONTH(approvedate), YEAR(approvedate)')
                                        // ->orderByRaw('FIELD(MONTH(approvedate), 4,5,6,7,8,9,10,11,12,1,2,3)')
                                        ->orderByRaw('FIELD(month, 4, 5, 6, 7, 8, 9, 10, 11, 12, 1, 2, 3)')
                                        ->get()
                                        ->map(function ($item) use ($monthNames) {
                                        $item->month = $monthNames[$item->month] ?? $item->month;
                                        return $item;
                                        });

                                        $cashFlowSpendemployee = DB::table('employeepayrolls')
                                        ->select('month', 'year', DB::raw('SUM(total_amount_to_paid) as total_amounts'))
                                        ->where(function ($query) use ($endYear, $startYear) {
                                        // Jan to Mar from next year
                                        $query->where(function ($q) use ($endYear) {
                                        $q->where('year', $endYear);
                                        // ->whereIn('month', ['January', 'February', 'March']);
                                        })
                                        // Apr to Jun from current year
                                        ->orWhere(function ($q) use ($startYear) {
                                        $q->where('year', $startYear);
                                        // ->whereIn('month', ['April', 'May', 'June', 'July', 'August', 'September',
                                        'October',
                                        'November', 'December']);
                                        });
                                        })
                                        ->where('send_to_bank', 1)
                                        ->when(!empty($partnerId), function ($query) use ($partnerId) {
                                        $query->where('createdby', $partnerId);
                                        })
                                        ->groupBy('year', 'month')
                                        ->orderByRaw("FIELD(month, 'April', 'May', 'June', 'July', 'August',
                                        'September',
                                        'October',
                                        'November', 'December', 'January', 'February', 'March')")
                                        ->get();

                                        $mergedSpenddata = $cashFlowSpendvender->merge($cashFlowSpendemployee);

                                        $cashFlowtotalspendData = $mergedSpenddata->groupBy(function ($item) {
                                        return $item->month . '-' . $item->year;
                                        })->map(function ($group) {
                                        return (object) [
                                        'month' => $group->first()->month,
                                        'year' => $group->first()->year,
                                        'total_amounts' => $group->sum('total_amounts'),
                                        ];
                                        })->sortBy(function ($item) {
                                        $order = ['April', 'May', 'June', 'July', 'August', 'September', 'October',
                                        'November',
                                        'December', 'January', 'February', 'March'];
                                        return array_search($item->month, $order);
                                        })->values();

                                        // filter Chart, Budget vs Actual Cash Flow

                                        // 1.budget table se budgetinflow
                                        // 2.cash recieved in paymnets table
                                        // 2.budget table se budgetoutflow
                                        // 4.cash spend on employee and vender employeepayrolls and vendorlist tables

                                        $budgetactualcash = DB::table('budget')
                                        ->select('month', 'year', DB::raw('SUM(budgetinflow) as budgetinflow'),
                                        DB::raw('SUM(budgetoutflow) as budgetoutflow'))
                                        ->where(function ($query) use ($endYear, $startYear) {
                                        // Jan to Mar from next year
                                        $query->where(function ($q) use ($endYear) {
                                        $q->where('year', $endYear);
                                        // ->whereIn('month', ['January', 'February', 'March']);
                                        })
                                        // Apr to Jun from current year
                                        ->orWhere(function ($q) use ($startYear) {
                                        $q->where('year', $startYear);
                                        // ->whereIn('month', ['April', 'May', 'June', 'July', 'August', 'September',
                                        'October',
                                        'November', 'December']);
                                        });
                                        })
                                        // ->when(!empty($months), function ($query) use ($months) {
                                        // $query->where('month', $months);
                                        // })
                                        // ->when(!empty($partnerId), function ($query) use ($partnerId) {hide from UI
                                        // $query->where('assignmentmappings.leadpartner', $partnerId);
                                        // })
                                        ->groupBy('year', 'month')
                                        ->orderByRaw("FIELD(month, 'April', 'May', 'June', 'July', 'August',
                                        'September',
                                        'October',
                                        'November', 'December', 'January', 'February', 'March')")
                                        ->get();

                                        // Budget vs Actual Cash Flow end hare


                                        // filter Chart, Budget vs Actual P&L
                                        // $budgetRevenueandbudgetExpences = DB::table('assignmentmappings')
                                        // ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year,
                                        SUM(engagementfee)
                                        as
                                        engagementfee, SUM(teamestcost) as total_teamestcost')
                                        // ->whereBetween('created_at', [$startDateFormatted, $endDateFormatted])
                                        // ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
                                        // $query->whereMonth('created_at', $monthsdigit);
                                        // })
                                        // ->when(!empty($partnerId), function ($query) use ($partnerId) {
                                        // $query->where('leadpartner', $partnerId);
                                        // })
                                        // ->groupByRaw('MONTH(created_at), YEAR(created_at)')
                                        // // ->orderByRaw('FIELD(MONTH(created_at), 4,5,6,7,8,9,10,11,12,1,2,3)')
                                        // ->orderByRaw('FIELD(month, 4, 5, 6, 7, 8, 9, 10, 11, 12, 1, 2, 3)')
                                        // ->get()
                                        // ->map(function ($item) use ($monthNames) {
                                        // $item->month = $monthNames[$item->month] ?? $item->month;
                                        // return $item;
                                        // });


                                        // $budgetActualRevenuedata = DB::table('invoices')
                                        // ->selectRaw("MONTH(created_at) as month, YEAR(created_at) as year,
                                        invoices.currency,
                                        DATE_FORMAT(invoices.created_at, '%Y-%m-%d') as bill_date, SUM(total) as
                                        total_amount")
                                        // ->whereBetween('created_at', [$startDateFormatted, $endDateFormatted])
                                        // ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
                                        // $query->whereMonth('created_at', $monthsdigit);
                                        // })
                                        // ->when(!empty($partnerId), function ($query) use ($partnerId) {
                                        // $query->where('partner', $partnerId);
                                        // })
                                        // ->groupByRaw("MONTH(created_at), YEAR(created_at), invoices.currency,
                                        DATE_FORMAT(invoices.created_at, '%Y-%m-%d')")
                                        // // ->orderByRaw('FIELD(MONTH(created_at), 4,5,6,7,8,9,10,11,12,1,2,3)')
                                        // ->orderByRaw('FIELD(month, 4, 5, 6, 7, 8, 9, 10, 11, 12, 1, 2, 3)')
                                        // ->get()
                                        // ->map(function ($item) use ($monthNames) {
                                        // $item->month = $monthNames[$item->month] ?? $item->month;
                                        // return $item;
                                        // });

                                        // $budgetActualRevenuedata = $this->convertusdtoinr1($budgetActualRevenuedata);

                                        // $budgetActualRevenue = $budgetActualRevenuedata
                                        // ->groupBy('month')
                                        // ->map(function ($items, $month) {
                                        // return (object)[
                                        // 'month' => $month,
                                        // 'year' => $items->first()->year,
                                        // 'total_amount' => $items->sum('total_amount'),
                                        // ];
                                        // })
                                        // ->values();

                                        // $budgetActualExpences = DB::table('timesheets')
                                        // ->leftJoin('timesheetusers', 'timesheetusers.timesheetid', '=',
                                        'timesheets.id')
                                        // ->leftJoin('teammembers', 'teammembers.id', '=', 'timesheetusers.createdby')
                                        // // ->whereIn('timesheets.created_by', [815, 818])
                                        // ->selectRaw('MONTH(timesheets.date) as month, YEAR(timesheets.date) as year,
                                        SUM(timesheetusers.totalhour * teammembers.cost_hour) as total_cost')
                                        // ->whereBetween('timesheets.date', [$startDateFormatted, $endDateFormatted])
                                        // ->when(!empty($monthsdigit), function ($query) use ($monthsdigit) {
                                        // $query->whereMonth('timesheets.date', $monthsdigit);
                                        // })
                                        // ->when(!empty($partnerId), function ($query) use ($partnerId) {
                                        // $query->where('timesheetusers.partner', $partnerId);
                                        // })
                                        // ->groupByRaw('MONTH(timesheets.date), YEAR(timesheets.date)')
                                        // ->get()
                                        // ->map(function ($item) use ($monthNames) {
                                        // $item->month = $monthNames[$item->month] ?? $item->month;
                                        // return $item;
                                        // });

                                        /// Budget vs Actual P&L end hare


                                        // dddd Lap Days Analysis (Assignment to Invoice)
                                        $assignmentsWithInvoices = DB::table('assignmentmappings')
                                        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id',
                                        '=',
                                        'assignmentmappings.assignmentgenerate_id')
                                        // get only those assignments for which an invoice has been created
                                        ->join('invoices', 'invoices.assignmentgenerate_id', '=',
                                        'assignmentmappings.assignmentgenerate_id')
                                        ->selectRaw('MONTH(assignmentbudgetings.otpverifydate) as month,
                                        YEAR(assignmentbudgetings.otpverifydate) as year,
                                        assignmentbudgetings.otpverifydate,
                                        invoices.created_at as invoice_created_at, invoices.id as invoice_id')
                                        ->whereBetween('assignmentbudgetings.otpverifydate', [$startDateFormatted,
                                        $endDateFormatted])
                                        ->when(!empty($partnerId), function ($query) use ($partnerId) {
                                        $query->where('assignmentmappings.leadpartner', $partnerId);
                                        })
                                        // ->orderByRaw('FIELD(MONTH(assignmentbudgetings.otpverifydate),
                                        1,2,3,4,5,6,7,8,9,10,11,12)')
                                        ->orderByRaw('FIELD(month, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12)')
                                        ->get()
                                        ->map(function ($item) use ($monthNames) {
                                        $assignmentclosedDate = Carbon::parse($item->otpverifydate);
                                        $invoicecreatedDate = Carbon::parse($item->invoice_created_at);
                                        $item->differenceDays = $assignmentclosedDate->diffInDays($invoicecreatedDate);
                                        $item->targetDays = 7;
                                        $item->month = $monthNames[$item->month] ?? $item->month;
                                        return $item;
                                        })
                                        ->groupBy(fn($item) => $item->month . '-' . $item->year)
                                        ->map(function ($group) {
                                        $first = $group->first();
                                        return (object) [
                                        'month' => $first->month,
                                        'year' => $first->year,
                                        'otpverifydate' => $first->otpverifydate,
                                        'invoice_id' => $first->invoice_id,
                                        'invoice_created_at' => $first->invoice_created_at,
                                        'targetDays' => $first->targetDays,
                                        'differenceDays' => $group->sum('differenceDays'),
                                        'countitem' => $group->count(),
                                        // Average Difference Days = (sum of all differenceDays) / number of records
                                        'averageDifferenceDays' => round($group->avg('differenceDays'), 1),
                                        ];
                                        })
                                        ->sortBy(fn($item) => array_search($item->month, array_values($monthNames)))
                                        ->values();


                                        // dddd Invoice Due vs Assignment Billing vs Cash Recovery

                                        $assignmentBillingdata = DB::table('invoices')
                                        ->selectRaw("MONTH(created_at) as month, YEAR(created_at) as year,
                                        invoices.currency,
                                        DATE_FORMAT(invoices.created_at, '%Y-%m-%d') as bill_date, SUM(total) as
                                        total_amount")
                                        ->whereBetween('created_at', [$startDateFormatted, $endDateFormatted])
                                        ->when(!empty($partnerId), function ($query) use ($partnerId) {
                                        $query->where('partner', $partnerId);
                                        })
                                        ->groupByRaw("MONTH(created_at), YEAR(created_at), invoices.currency,
                                        DATE_FORMAT(invoices.created_at, '%Y-%m-%d')")
                                        // ->orderByRaw('FIELD(MONTH(created_at), 4,5,6,7,8,9,10,11,12,1,2,3)')
                                        ->orderByRaw('FIELD(month, 4, 5, 6, 7, 8, 9, 10, 11, 12, 1, 2, 3)')
                                        ->get()
                                        ->map(function ($item) use ($monthNames) {
                                        $item->month = $monthNames[$item->month] ?? $item->month;
                                        return $item;
                                        });

                                        $assignmentBillingdata = $this->convertusdtoinr1($assignmentBillingdata);

                                        $assignmentBilling = $assignmentBillingdata
                                        ->groupBy('month')
                                        ->map(function ($items, $month) {
                                        return (object)[
                                        'month' => $month,
                                        'year' => $items->first()->year,
                                        'total_amount' => $items->sum('total_amount'),
                                        ];
                                        })
                                        ->values();

                                        $assignmentOutstanding = DB::table('outstandings')
                                        ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, SUM(AMT) as
                                        outstanding_amount')
                                        ->whereBetween('created_at', [$startDateFormatted, $endDateFormatted])
                                        ->when(!empty($partnerId), function ($query) use ($partnerId) {
                                        $query->where('Partner', $partnerId);
                                        })
                                        ->groupByRaw('MONTH(created_at), YEAR(created_at)')
                                        // ->orderByRaw('FIELD(MONTH(created_at), 4,5,6,7,8,9,10,11,12,1,2,3)')
                                        ->orderByRaw('FIELD(month, 4, 5, 6, 7, 8, 9, 10, 11, 12, 1, 2, 3)')
                                        ->get()
                                        ->map(function ($item) use ($monthNames) {
                                        $item->month = $monthNames[$item->month] ?? $item->month;
                                        return $item;
                                        });

                                        $cashRecovery = DB::table('payments')
                                        ->leftJoin('invoices', 'invoices.invoice_id', '=', 'payments.invoiceid')
                                        ->selectRaw('MONTH(paymentdate) as month, YEAR(paymentdate) as year,
                                        SUM(amountreceived)
                                        as
                                        amountreceived')
                                        ->whereBetween('paymentdate', [$startDateFormatted, $endDateFormatted])
                                        ->when(!empty($partnerId), function ($query) use ($partnerId) {
                                        $query->where('invoices.partner', $partnerId);
                                        })
                                        ->groupByRaw('MONTH(paymentdate), YEAR(paymentdate)')
                                        // ->orderByRaw('FIELD(MONTH(paymentdate), 4,5,6,7,8,9,10,11,12,1,2,3)')
                                        ->orderByRaw('FIELD(month, 4, 5, 6, 7, 8, 9, 10, 11, 12, 1, 2, 3)')
                                        ->get()
                                        ->map(function ($item) use ($monthNames) {
                                        $item->month = $monthNames[$item->month] ?? $item->month;
                                        return $item;
                                        });

                                        // dddd Staff Allocation vs Actual Timesheet Analysis
                                        $teamAllocatedHours = DB::table('timesheetusers')
                                        ->join('teammembers', 'teammembers.id', '=', 'timesheetusers.createdby')
                                        // ->whereIn('teammembers.id', [14, 23, 187, 305, 659, 815])
                                        // ->whereNotIn('teammembers.role_id', [13])
                                        ->whereBetween('timesheetusers.created_at', [$startDateFormatted,
                                        $endDateFormatted])
                                        ->when(!empty($partnerId), function ($query) use ($partnerId) {
                                        $query->where('timesheetusers.partner', $partnerId);
                                        })
                                        ->select(
                                        'teammembers.id as teammember_id',
                                        'teammembers.team_member',
                                        'teammembers.role_id',
                                        DB::raw('SUM(timesheetusers.totalhour) as actualhours')
                                        )
                                        ->groupBy('teammembers.id', 'teammembers.team_member', 'teammembers.role_id')
                                        // ->limit(6)
                                        ->get();



                                        foreach ($teamAllocatedHours as $teamAllocatedHour) {
                                        if ($teamAllocatedHour->role_id == 13) {
                                        $allocatedHours1 = DB::table('assignmentmappings')
                                        ->where('assignmentmappings.eqcrpartner', $teamAllocatedHour->teammember_id)
                                        ->whereBetween('assignmentmappings.created_at', [$startDateFormatted,
                                        $endDateFormatted])
                                        // ->when(!empty($partnerId), function ($query) use ($partnerId) {
                                        // $query->where('assignmentmappings.leadpartner', $partnerId);
                                        // })
                                        ->sum('assignmentmappings.eqcresthour');

                                        $allocatedHours2 = DB::table('assignmentmappings')
                                        ->where('assignmentmappings.leadpartner', $teamAllocatedHour->teammember_id)
                                        ->whereBetween('assignmentmappings.created_at', [$startDateFormatted,
                                        $endDateFormatted])
                                        // ->when(!empty($partnerId), function ($query) use ($partnerId) {
                                        // $query->where('assignmentmappings.leadpartner', $partnerId);
                                        // })
                                        ->sum('assignmentmappings.partneresthour');

                                        $allocatedHours3 = DB::table('assignmentmappings')
                                        ->where('assignmentmappings.otherpartner', $teamAllocatedHour->teammember_id)
                                        ->whereBetween('assignmentmappings.created_at', [$startDateFormatted,
                                        $endDateFormatted])
                                        // ->when(!empty($partnerId), function ($query) use ($partnerId) {
                                        // $query->where('assignmentmappings.leadpartner', $partnerId);
                                        // })
                                        ->sum('assignmentmappings.otherpartneresthour');

                                        $allocatedHours = $allocatedHours1 + $allocatedHours2 + $allocatedHours3;
                                        } else {
                                        $allocatedHours = DB::table('assignmentmappings')
                                        ->leftJoin('assignmentteammappings',
                                        'assignmentteammappings.assignmentmapping_id',
                                        'assignmentmappings.id')
                                        ->where('assignmentteammappings.teammember_id',
                                        $teamAllocatedHour->teammember_id)
                                        ->whereBetween('assignmentteammappings.created_at', [$startDateFormatted,
                                        $endDateFormatted])
                                        ->when(!empty($partnerId), function ($query) use ($partnerId) {
                                        $query->where('assignmentmappings.leadpartner', $partnerId);
                                        })
                                        ->sum('assignmentteammappings.teamesthour');
                                        }

                                        if (is_null($allocatedHours)) {
                                        $allocatedHours = 0;
                                        }
                                        $teamAllocatedHour->teamallocatedhours = $allocatedHours;
                                        $teamAllocatedHour->discrepancy = $teamAllocatedHour->actualhours - (float)
                                        $allocatedHours;
                                        }


                                        // dddd Fetch IT and Finance Tickets or Unresolved Tickets - HR, IT & Admin
                                        $ticketDatas = Assetticket::with(['financerequest', 'createdBy', 'partner'])
                                        ->whereIn('type', [0, 1])
                                        ->whereBetween('created_at', [$startDateFormatted, $endDateFormatted])
                                        ->when(!empty($partnerId), function ($query) use ($partnerId) {
                                        $query->where('partner_id', $partnerId);
                                        })
                                        ->orderByDesc('id')
                                        // ->limit(4)
                                        ->get()
                                        ->map(function ($item) {
                                        return [
                                        'ticket_id' => $item->generateticket_id,
                                        'department' => $item->type == 0 ? 'IT' : 'Finance',
                                        'created_by' => $item->createdBy->team_member ?? '',
                                        'subject' => $item->subject,
                                        'assigned_to' => $item->partner->team_member ?? '',
                                        'created_at' => $item->created_at,
                                        'status' => $item->status,
                                        'source' => 'ticket',
                                        ];
                                        });


                                        // Fetch HR Tasks
                                        $hrTickets = DB::table('tasks')
                                        ->select(
                                        'tasks.*',
                                        'patnerid.team_member as partnername',
                                        'createdby.team_member as createdbyname',
                                        'hrfunctions.hrfunction'
                                        )
                                        ->where('tasks.task_type', 4)
                                        ->whereBetween('tasks.created_at', [$startDateFormatted, $endDateFormatted])
                                        ->when(!empty($partnerId), function ($query) use ($partnerId) {
                                        $query->where('tasks.partner_id', $partnerId);
                                        })
                                        ->leftJoin('teammembers as patnerid', 'patnerid.id', '=', 'tasks.partner_id')
                                        ->leftJoin('teammembers as createdby', 'createdby.id', '=', 'tasks.createdby')
                                        ->leftJoin('hrfunctions', 'hrfunctions.id', '=', 'tasks.hrfunction')
                                        ->orderByDesc('tasks.id')
                                        // ->limit(4)
                                        ->get()
                                        ->map(function ($item) {
                                        return [
                                        'ticket_id' => $item->generateticket_id ?? 'NA',
                                        'department' => 'HR',
                                        'created_by' => $item->createdbyname ?? '',
                                        'subject' => $item->taskname ?? '',
                                        'assigned_to' => $item->partnername ?? '',
                                        'created_at' => $item->created_at,
                                        'status' => $item->status,
                                        'source' => 'hr',
                                        ];
                                        });

                                        $allTickets = $ticketDatas->merge($hrTickets);

                                        // High Priority Tasks Pending
                                        // $highpriorityAssignments = DB::table('assignmentmappings')
                                        // ->leftJoin('assignmentbudgetings',
                                        'assignmentbudgetings.assignmentgenerate_id',
                                        'assignmentmappings.assignmentgenerate_id')
                                        // ->leftJoin('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
                                        // ->select(
                                        // 'assignmentmappings.*',
                                        // 'assignmentbudgetings.assignmentname',
                                        // DB::raw('COALESCE(assignmentbudgetings.actualenddate,
                                        assignmentbudgetings.tentativeenddate)
                                        as finalassignmentenddate'),
                                        // 'clients.client_name'
                                        // )
                                        // ->limit(6)
                                        // ->get();

                                        // filter data
                                        $startYearforfilter = 2022;
                                        $currentDatetoday = Carbon::now();
                                        $currentYearforfilter = $currentDatetoday->year;
                                        $currentMonthforfilter = $currentDatetoday->month;
                                        $currentFinancialYear = $currentMonthforfilter >= 4 ? $currentYearforfilter :
                                        $currentYearforfilter - 1;

                                        $financialYears = [];
                                        for ($year = $startYearforfilter; $year <= $currentFinancialYear; $year++) {
                                            $financialYears[]=[ 'value'=> $year . '-' . ($year + 1),
                                            ];
                                            }

                                            $financialYears = array_reverse($financialYears);

                                            $partnerlist = Teammember::where('status', 1)
                                            ->where('role_id', 13)
                                            ->with('title')
                                            ->orderBy('team_member', 'asc')
                                            ->get();

                                            // Api call hare for total check in
                                            $newRequest = new Request([
                                            'role_id' => auth()->user()->role_id,
                                            'teammember_id' => auth()->user()->teammember_id
                                            ]);

                                            $checkInController =
                                            app(\App\Http\Controllers\Api\CheckInController::class);
                                            $response = $checkInController->checkInList($newRequest);
                                            $data = $response->getData()->result;
                                            $checkInCount = count($data);


                                            return view('backEnd.kgsdashboardreport', compact('checkInCount',
                                            'assignmentcreatedthisyear', 'monthsdigit', 'partnerId', 'partnerlist',
                                            'budgetactualcash',
                                            'financialYears', 'assignmentsWithInvoices', 'assignmentBilling',
                                            'assignmentOutstanding',
                                            'cashRecovery', 'cashFlowtotalspendData', 'cashFlowRecieved',
                                            'teamexceptionalExpenses',
                                            'teamsSalaries', 'teamAllocatedHours', 'timesheetOnClosedAssignment',
                                            'totalNotFilled',
                                            'partnerWiseProfit', 'lossMakingCount', 'billspending15Days',
                                            'totalUpcomingAssignments',
                                            'assignmentprofitandlosses', 'allTickets', 'hrTickets', 'ticketDatas',
                                            'ecqrAudits',
                                            'documentCompletions', 'assignmentOverviews', 'exceptionalExpenses',
                                            'auditsDue',
                                            'delayedAssignments', 'assignmentcompleted', 'billspendingforcollection',
                                            'billspending'));
                                            } else {
                                            abort(403, 'You do not have permission.');
                                            }
                                            }
                                            {{-- * regarding  --}}
                                            <script>
                                                //  222222222222222
                                                //  let selectedDate = new Date(dateValue);
                                                let selectedDate = new Date(dateValue + "T00:00:00");
                                                selectedDate.setHours(0, 0, 0, 0);

                                                console.log("selectedDate:", selectedDate.getTime());
                                                console.log("taaaoday:", today.getTime());

                                                if (selectedDate.getTime() > today.getTime()) {
                                                    alert(`${dates[dateField]} cannot be in the future`);
                                                    $("[name='" + dateField + "']").focus();
                                                    event.preventDefault();
                                                    return false;
                                                }
                                                //  2222222222222
                                            </script>

                                            <div class="form-group">
                                                <label class="font-weight-600">Title</label>
                                                <select class="form-control" id="exampleFormControlSelect1"
                                                    name="title_id">
                                                    <option value="" disabled
                                                        {{ !isset($userInfo) ? 'selected' : '' }}>
                                                        Please Select One
                                                    </option>
                                                    @foreach ($title as $titleData)
                                                        <option value="{{ $titleData->id }}"
                                                            {{ isset($userInfo) && $userInfo->title_id == $titleData->id ? 'selected' : '' }}>
                                                            {{ $titleData->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>


                                            <div class="form-group">
                                                <label class="font-weight-600">Title</label>
                                                <select class="form-control" id="exampleFormControlSelect1"
                                                    name="title_id"
                                                    @if (Request::is('userprofile/*')) > <option disabled
                                        style="display:block">Please Select One</option>
                        
                                        @foreach ($title as $titleData)
                                        <option value="{{ $titleData->id }}"
                                            {{ $userInfo->title_id == $titleData->id ?? '' ? 'selected="selected"' : '' }}>
                                            {{ $titleData->title }}</option>
                                        @endforeach @endif
                                                    </select>
                                            </div>


                                            <div class="form-group">
                                                <label class="font-weight-600">Title</label>
                                                <select class="form-control" id="exampleFormControlSelect1"
                                                    name="title_id">
                                                    @if (Request::is('userprofile/*'))
                                                        <option disabled style="display:block">Please Select One
                                                        </option>

                                                        @foreach ($title as $titleData)
                                                            <option value="{{ $titleData->id }}"
                                                                {{ $userInfo->title_id == $titleData->id ?? '' ? 'selected="selected"' : '' }}>
                                                                {{ $titleData->title }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            {{--  Start Hare --}}
                                            resources\views\backEnd\timesheet\create.blade.php

                                            var cid = $('#' + clientId).val();
                                            // var datepickers = $('#datepickers1').val();
                                            var clientNumber = parseInt(clientId.replace('client', ''));

                                            var clientNumbersetting = clientNumber >= 10 ?
                                            Math.floor(clientNumber / 10) :
                                            clientNumber;

                                            var datepickers = $('#day' + clientNumbersetting).val();

                                            // console.log("clientId:", clientId);
                                            // console.log("cid:", cid);
                                            // console.log("datepickers:", datepickers);
                                            // console.log("clientNumber:", clientNumber);
                                            // console.log("fielddatevalue:", fielddatevalue);




                                            var cid = $('#' + clientId).val();
                                            var datepickers = $('#datepickers1').val();
                                            var clientNumber = parseInt(clientId.replace('client', ''));

                                            if (clientNumber >= 10) {
                                            clientNumbertemp = clientNumber / 10;
                                            var fielddatevalue = $('#day' + clientNumbertemp).val();
                                            } else {
                                            var fielddatevalue = $('#day' + clientNumber).val();
                                            }

                                            console.log("clientId:", clientId);
                                            console.log("cid:", cid);
                                            console.log("datepickers:", datepickers);
                                            console.log("clientNumber:", clientNumber);
                                            console.log("fielddatevalue:", fielddatevalue);
                                            {{-- * regarding  --}}

                                            @php
                                                $isSpecialUser =
                                                    in_array(Auth::user()->role_id, [11, 12]) ||
                                                    Auth::user()->teammember_id == 156;

                                                $yearCol = $isSpecialUser
                                                    ? (Request::is('filterdashboardreport')
                                                        ? 3
                                                        : 4)
                                                    : (Request::is('filterdashboardreport')
                                                        ? 4
                                                        : 5);

                                                $monthCol = $isSpecialUser ? 3 : 4;
                                            @endphp
                                            <div class="filtercontainer">
                                                <form id="filterform" method="POST"
                                                    action="{{ url('/filterdashboardreport') }}"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-{{ $yearCol }}">
                                                            <div class="form-group">
                                                                <strong><label for="yearly">Select
                                                                        Yearly</label></strong>
                                                                <select required class="language form-control"
                                                                    id="yearly" name="yearly">
                                                                    <option value="">Select Year</option>
                                                                    @foreach ($financialYears as $fy)
                                                                        <option value="{{ $fy['value'] }}"
                                                                            {{ old('yearly') == $fy['value'] ? 'selected' : '' }}>
                                                                            {{ $fy['value'] }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-{{ $monthCol }}">

                                                            @if (Auth::user()->role_id == 11 || Auth::user()->role_id == 12 || Auth::user()->teammember_id == 156)
                                                                <div class="col-3">
                                                                    <div class="form-group">
                                                                        <strong><label for="partner">Select
                                                                                Partner</label></strong>
                                                                        <select class="language form-control"
                                                                            id="partner" name="partner">
                                                                            <option value="">Select Partner
                                                                            </option>
                                                                            @foreach ($partnerlist as $partners)
                                                                                <option value="{{ $partners->id }}"
                                                                                    {{ old('partner') == $partners->id ? 'selected' : '' }}>
                                                                                    {{ $partners->team_member }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if (Auth::user()->role_id == 11 || Auth::user()->role_id == 12 || Auth::user()->teammember_id == 156)
                                                                <div
                                                                    class="col-{{ Request::is('filterdashboardreport') ? '3' : '4' }}">
                                                                @else
                                                                    <div
                                                                        class="col-{{ Request::is('filterdashboardreport') ? '4' : '5' }}">
                                                            @endif


                                                            @if (Auth::user()->role_id == 11 || Auth::user()->role_id == 12 || Auth::user()->teammember_id == 156)
                                                                <div class="col-3">
                                                                @else
                                                                    <div class="col-4">
                                                            @endif
                                                            {{--  Start Hare --}}
                                                            <td>
                                                                {{ $teammemberData->newstaff_code ?? ($teammemberData->staffcode ?? '') }}
                                                            </td>
                                                            @php
                                                                // new code start from hare for rejoined user
                                                                $latestTeamRoleHistory = DB::table(
                                                                    'teamrolehistory as trh',
                                                                )
                                                                    ->select('trh.teammember_id', 'trh.rejoiningdate')
                                                                    ->whereRaw(
                                                                        'trh.id = (SELECT MAX(id) FROM teamrolehistory WHERE teammember_id = trh.teammember_id)',
                                                                    );

                                                                $latestRejoiningSamePost = DB::table(
                                                                    'rejoiningsamepost as rsp',
                                                                )
                                                                    ->select(
                                                                        'rsp.teammember_id',
                                                                        'rsp.rejoiningdate as samepostrejoiningdate',
                                                                    )
                                                                    ->whereRaw(
                                                                        'rsp.id = (SELECT MAX(id) FROM rejoiningsamepost WHERE teammember_id = rsp.teammember_id)',
                                                                    );

                                                                $rejoiningDataall = DB::table('teammembers as tm')
                                                                    ->leftJoinSub(
                                                                        $latestTeamRoleHistory,
                                                                        'latest_trh',
                                                                        function ($join) {
                                                                            $join->on(
                                                                                'latest_trh.teammember_id',
                                                                                '=',
                                                                                'tm.id',
                                                                            );
                                                                        },
                                                                    )
                                                                    ->leftJoinSub(
                                                                        $latestRejoiningSamePost,
                                                                        'latest_rsp',
                                                                        function ($join) {
                                                                            $join->on(
                                                                                'latest_rsp.teammember_id',
                                                                                '=',
                                                                                'tm.id',
                                                                            );
                                                                        },
                                                                    )
                                                                    ->where('tm.id', auth()->user()->teammember_id)
                                                                    ->select(
                                                                        'latest_trh.rejoiningdate',
                                                                        'latest_rsp.samepostrejoiningdate',
                                                                    )
                                                                    ->first();

                                                                $rejoiningDatestore = null;
                                                                $rejoineduserchecked = null;

                                                                if (
                                                                    !empty($rejoiningDataall) &&
                                                                    (!empty($rejoiningDataall->rejoiningdate) ||
                                                                        !empty(
                                                                            $rejoiningDataall->samepostrejoiningdate
                                                                        ))
                                                                ) {
                                                                    die();
                                                                    $date1 = $rejoiningDataall->rejoiningdate;
                                                                    $date2 = $rejoiningDataall->samepostrejoiningdate;

                                                                    if ($date1 && $date2) {
                                                                        $rejoiningDatestore = max($date1, $date2);
                                                                    } else {
                                                                        $rejoiningDatestore = $date1 ?? $date2;
                                                                    }

                                                                    if (!empty($rejoiningDatestore)) {
                                                                        $rejoineduserchecked = DB::table(
                                                                            'timesheetusers',
                                                                        )
                                                                            ->where(
                                                                                'createdby',
                                                                                auth()->user()->teammember_id,
                                                                            )
                                                                            ->where('date', '>', $rejoiningDatestore)
                                                                            ->whereIn('status', [1])
                                                                            ->orderBy('date', 'asc')
                                                                            ->first();
                                                                    }
                                                                }
                                                            @endphp

                                                            {{-- @if ($rejoiningDataall && is_null($rejoineduserchecked)) --}}
                                                            @if (
                                                                (!empty($rejoiningDataall->rejoiningdate) || !empty($rejoiningDataall->samepostrejoiningdate)) &&
                                                                    empty($rejoineduserchecked))
                                                                <li class="breadcrumb-item"><a
                                                                        class="btn btn-primary-soft btn-sm"
                                                                        href="{{ url('timesheet/create') }}">Add
                                                                        Timesheet</a>
                                                                </li>
                                                                {{-- * regarding  --}}
                                                                {{--  Start Hare --}}
                                                                <table id="examplee"
                                                                    class="table display table-bordered table-striped table-hover">
                                                                    <thead>
                                                                        <tr>
                                                                            <th style="display: none;">id</th>
                                                                            <th class="textfixed">Assignment Code</th>
                                                                            <th class="textfixed">Client Name</th>
                                                                            <th class="textfixed">Assignment Name</th>
                                                                            <th class="textfixed">Partner Name</th>
                                                                            <th class="textfixed">Document Completed
                                                                                Date</th>
                                                                            <th class="textfixed">Status</th>
                                                                            <th class="textfixed">Assignment Closed
                                                                                Date</th>
                                                                            <th class="textfixed">Assignment Created
                                                                                Date</th>
                                                                            <th class="textfixed">Total Invoices</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($assignments as $row)
                                                                            @php
                                                                                $filteredInvoices = $row->invoices->where(
                                                                                    'status',
                                                                                    2,
                                                                                );
                                                                            @endphp
                                                                            <tr
                                                                                data-invoices='@json($filteredInvoices)'>
                                                                                <td style="display: none;">
                                                                                    {{ $row->id }}
                                                                                </td>
                                                                                <td>{{ $row->assignmentgenerate_id }}
                                                                                </td>
                                                                                <td>{{ optional($row->assignmentBudgeting->client)->client_name ?? 'N/A' }}
                                                                                </td>
                                                                                <td class="textfixed">
                                                                                    {{ optional($row->assignmentBudgeting)->assignmentname ?? 'N/A' }}
                                                                                </td>
                                                                                <td>{{ optional($row->leadPartner)->team_member ?? 'N/A' }}
                                                                                </td>
                                                                                <td>{{ optional($row->assignmentBudgeting)->percentclosedate ?? 'N/A' }}
                                                                                </td>
                                                                                <td class="textfixed">
                                                                                    @if ($row->assignmentBudgeting && $row->assignmentBudgeting->percentclosedate && $row->invoices->isNotEmpty())
                                                                                        <b
                                                                                            style="color:green;">Completed</b>
                                                                                    @else
                                                                                        <b style="color:red;">Not
                                                                                            Completed</b>
                                                                                    @endif
                                                                                </td>
                                                                                <td>
                                                                                    {{ $row->assignmentBudgeting && $row->assignmentBudgeting->otpverifydate
                                                                                        ? date('Y-m-d', strtotime($row->assignmentBudgeting->otpverifydate))
                                                                                        : 'N/A' }}
                                                                                </td>
                                                                                <td>{{ date('Y-m-d', strtotime($row->created_at)) }}
                                                                                </td>
                                                                                <td>
                                                                                    <span
                                                                                        class="badge toggle-invoices"style="background-color: #d0f29ec4; height: 21px; width: 59px; cursor: pointer;">
                                                                                        {{ $filteredInvoices->count() }}
                                                                                    </span>
                                                                                </td>
                                                                            </tr>
                                                                            @if ($filteredInvoices->count() > 1)
                                                                                @foreach ($filteredInvoices as $invoice)
                                                                                    <tr>
                                                                                        <td colspan="9"></td>
                                                                                        <td>{{ $invoice->invoice_no }}
                                                                                        </td>
                                                                                        <td>{{ $invoice->invoice_date }}
                                                                                        </td>
                                                                                        <td>{{ $invoice->professional_fee }}
                                                                                        </td>
                                                                                        <td>{{ $invoice->gst }}</td>
                                                                                        <td>{{ $invoice->tds }}</td>
                                                                                        <td>{{ $invoice->total_amount }}
                                                                                        </td>
                                                                                        <td>{{ $invoice->status }}
                                                                                        </td>
                                                                                    </tr>
                                                                                @endforeach
                                                                            @endif
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                                {{-- * regarding  --}}
                                                                <table id="examplee"
                                                                    class="table display table-bordered table-striped table-hover">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Teammember</th>
                                                                            <th>Teammember Code</th>
                                                                            <th>Assignment Id</th>
                                                                            <th>Assignment</th>
                                                                            <th>Total Hour</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($teammemberDatas as $teammemberData)
                                                                            @php
                                                                                $permotioncheck = $roleHistories->get(
                                                                                    $teammemberData->teamid,
                                                                                );
                                                                                $assignmentcheck = $assignmentBudgetings->get(
                                                                                    $teammemberData->assignmentgenerate_id,
                                                                                );

                                                                                $datadate = $assignmentcheck
                                                                                    ? Carbon\Carbon::createFromFormat(
                                                                                        'Y-m-d H:i:s',
                                                                                        $assignmentcheck->created_at,
                                                                                    )
                                                                                    : null;
                                                                                $permotiondate = $permotioncheck
                                                                                    ? Carbon\Carbon::createFromFormat(
                                                                                        'Y-m-d H:i:s',
                                                                                        $permotioncheck->created_at,
                                                                                    )
                                                                                    : null;

                                                                                $displayCode =
                                                                                    $permotioncheck &&
                                                                                    $datadate &&
                                                                                    $datadate->greaterThanOrEqualTo(
                                                                                        $permotiondate,
                                                                                    )
                                                                                        ? $permotioncheck->newstaff_code
                                                                                        : $teammemberData->staffcode;

                                                                                $totalHours =
                                                                                    property_exists(
                                                                                        $teammemberData,
                                                                                        'leadpartner',
                                                                                    ) &&
                                                                                    $teammemberData->teamid ==
                                                                                        $teammemberData->leadpartner
                                                                                        ? $teammemberData->leadpartnerhour ??
                                                                                            0
                                                                                        : (property_exists(
                                                                                            $teammemberData,
                                                                                            'otherpartner',
                                                                                        ) &&
                                                                                        $teammemberData->teamid ==
                                                                                            $teammemberData->otherpartner
                                                                                            ? $teammemberData->otherpartnerhour ??
                                                                                                0
                                                                                            : $teammemberData->teamhour ??
                                                                                                0);
                                                                            @endphp
                                                                            <tr>
                                                                                <td>{{ $teammemberData->title }}
                                                                                    {{ $teammemberData->team_member }}
                                                                                </td>
                                                                                <td>{{ $displayCode }}</td>
                                                                                <td>{{ $teammemberData->assignmentgenerate_id }}
                                                                                </td>
                                                                                <td>{{ $teammemberData->assignmentname }}
                                                                                </td>
                                                                                <td>{{ $totalHours }}</td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                                {{-- * regarding  --}}
                                                                {{--  Start Hare --}}
                                                                <table id="examplee" class="display nowrap">
                                                                    <thead>
                                                                        <tr>
                                                                            <th style="display: none;">id</th>
                                                                            <th>Assignment Code</th>
                                                                            <th>Client Name</th>
                                                                            <th>Assignment Name</th>
                                                                            <th>Partner Name</th>
                                                                            <th>Approver Name</th>
                                                                            <th>Claims Amount</th>
                                                                            <th>Conveyance Amount</th>
                                                                            <th>Amount</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($outstationData as $outstationData)
                                                                            <tr>
                                                                                <td style="display: none;">
                                                                                    {{ $outstationData->id }}
                                                                                </td>
                                                                                <td>{{ $outstationData->assignmentgenerate_id ?? 'N/A' }}
                                                                                </td>
                                                                                <td>{{ $outstationData->client_name ?? 'N/A' }}
                                                                                </td>
                                                                                <td>{{ $outstationData->assignmentsname ?? 'N/A' }}
                                                                                </td>
                                                                                <td>{{ App\Models\Teammember::select('team_member')->where('id', $outstationData->leadpartner)->first()->team_member ?? '' }}
                                                                                </td>
                                                                                <td>{{ 'N/A' }}</td>
                                                                                <td>{{ $outstationData->Total_Value ?? 'N/A' }}
                                                                                </td>
                                                                                <td>{{ $outstationData->Approved_Conveyance ?? 'N/A' }}
                                                                                </td>
                                                                                <td>{{ $outstationData->finalamount ?? 'N/A' }}
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                                {{-- * regarding  --}}
                                                                @if (empty($partnerId))
                                                                    <div class="col-md-6 col-lg-3 mb-3">
                                                                        <a href="{{ url('tender/submittedlist') }}">
                                                                            <div class="p-3 shadow-sm border border-success rounded text-dark"
                                                                                style=" background-color: rgb(240, 253, 244);">
                                                                                <div
                                                                                    class="d-flex justify-content-between align-items-start">
                                                                                    <div>
                                                                                        <div class="font-weight-bold small"
                                                                                            style="margin-bottom: 10px;">
                                                                                            New
                                                                                            Tenders
                                                                                            Submitted
                                                                                        </div>
                                                                                        <div
                                                                                            class="h4 font-weight-bold">
                                                                                            {{ $tendersSubmittedCount }}
                                                                                        </div>
                                                                                        <div class="text-muted small">
                                                                                            This
                                                                                            month</div>
                                                                                        <div class="small mt-2">&nbsp;
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </div>
                                                                @endif

                                                                <table id="partnerprofit" class="table table-hover">
                                                                    <thead>
                                                                        <tr>
                                                                            <th style="padding: 17px;">Partner</th>
                                                                            <th style="padding: 17px;">Revenue</th>
                                                                            <th style="padding: 17px;">Expenses</th>
                                                                            <th style="padding: 17px;">Profit</th>
                                                                            <th style="padding: 17px;"
                                                                                class="textfixed">
                                                                                Margin %</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @forelse ($partnerWiseProfit as $data)
                                                                            <tr>
                                                                                <td style="padding: 17px;">
                                                                                    {{ $data->team_member }}
                                                                                </td>
                                                                                <td style="padding: 17px;">
                                                                                    ₹{{ number_format($data->total, 2) }}
                                                                                </td>
                                                                                <td style="padding: 17px;">
                                                                                    ₹{{ number_format($data->cost, 2) }}
                                                                                </td>
                                                                                <td style="padding: 17px;"
                                                                                    class="{{ $data->profit_loss < 0 ? 'text-danger' : 'text-success' }}">
                                                                                    ₹{{ number_format($data->profit_loss, 2) }}
                                                                                </td>
                                                                                @php
                                                                                    $partnerrevenue = $data->total ?? 0;
                                                                                    $partnerprofit =
                                                                                        $data->profit_loss ?? 0;
                                                                                    $partnermargin =
                                                                                        $partnerrevenue != 0
                                                                                            ? ($partnerprofit /
                                                                                                    $partnerrevenue) *
                                                                                                100
                                                                                            : 0;
                                                                                @endphp
                                                                                <td style="padding: 17px;"
                                                                                    class="{{ $partnermargin < 0 ? 'text-danger' : 'text-success' }}">
                                                                                    {{ number_format($partnermargin, 1) }}%
                                                                                </td>
                                                                            </tr>
                                                                        @empty
                                                                            <tr>
                                                                                <td colspan="8"
                                                                                    class="text-center text-muted">
                                                                                    No
                                                                                    data available.</td>
                                                                            </tr>
                                                                        @endforelse
                                                                    </tbody>
                                                                </table>

                                                                <div class="card">
                                                                    <div class="card-header">
                                                                        <h2>NFRA Audits, Quality Reviews & Peer Review
                                                                        </h2>
                                                                    </div>
                                                                    <div class="scrollbarcontrol">
                                                                        @forelse ($ecqrAudits as $ecqrAudit)
                                                                            <div class="ecqr-card">
                                                                                <div class="ecqr-header"
                                                                                    style=" margin: 0;">
                                                                                    <div class="ecqr-title">
                                                                                        <h3>{{ $ecqrAudit->assignmentname ?? '' }}
                                                                                        </h3>
                                                                                        <p style=" margin: 0;">
                                                                                            {{ $ecqrAudit->client_name ?? '' }}
                                                                                        </p>
                                                                                        <p style=" margin: 0;">
                                                                                            Assigned to:
                                                                                            {{ $ecqrAudit->team_member ?? '' }}
                                                                                        </p>
                                                                                    </div>
                                                                                    <div class="ecqr-status">

                                                                                        @php
                                                                                            $endDate =
                                                                                                $ecqrAudit->finalassignmentenddate;
                                                                                        @endphp
                                                                                        @if ($ecqrAudit->status == 0)
                                                                                            <span
                                                                                                class="priority-tag completed">COMPLETED</span>
                                                                                            @elseif
                                                                                            ($endDate && \Carbon\Carbon::parse($endDate)->isFuture())
                                                                                            <span
                                                                                                class="priority-tag on-track">IN
                                                                                                PROGRESS</span>
                                                                                        @else
                                                                                            <span
                                                                                                class="priority-tag delayed">DELAYED</span>
                                                                                        @endif
                                                                                        <span class="text-muted small"
                                                                                            style="margin-top: 8px; font-size: 12px;">Due:
                                                                                            {{ $ecqrAudit->finalassignmentenddate }}</span>
                                                                                    </div>

                                                                                </div>
                                                                                <div class="document-info mt-1">
                                                                                    <span>Reviewer Progress</span>
                                                                                    <span
                                                                                        class="progress-value">{{ $ecqrAudit->reviewer_documentation_percentage }}%</span>
                                                                                </div>
                                                                                <div class="progress-bar mt-1">
                                                                                    <div class="progress-fill"
                                                                                        style="width: {{ $ecqrAudit->reviewer_documentation_percentage }}%; background: linear-gradient(to right, #0a0a0b, #650997);">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @empty
                                                                            <div
                                                                                class="ecqr-card text-center text-muted p-4">
                                                                                NFRA Audits, Quality Reviews & Peer
                                                                                Review Not
                                                                                found.
                                                                            </div>
                                                                        @endforelse
                                                                    </div>
                                                                </div>

                                                                <div class="card">
                                                                    <div class="card-header">
                                                                        <h2>Budget vs Actual P&L</h2>
                                                                    </div>
                                                                    <canvas id="budgetvsActual" width="auto"
                                                                        height="250"></canvas>
                                                                </div>

                                                                <script>
                                                                    const budgetvsActualctx = document.getElementById('budgetvsActual').getContext('2d');

                                                                    var budgetRevenueandbudgetExpences = @json($budgetRevenueandbudgetExpences);
                                                                    var budgetActualRevenue = @json($budgetActualRevenue);
                                                                    var budgetActualExpences = @json($budgetActualExpences);

                                                                    const budgetvsActualmonths = [
                                                                        'April', 'May', 'June', 'July', 'August', 'September',
                                                                        'October', 'November', 'December', 'January', 'February', 'March'
                                                                    ];

                                                                    // budgetRevenueandbudgetExpences, missing months == 0
                                                                    const budgetRevenueMonthsfill = {};
                                                                    budgetRevenueandbudgetExpences.forEach(item => {
                                                                        budgetRevenueMonthsfill[item.month] = parseFloat(item.engagementfee);
                                                                    });

                                                                    // budgetRevenueandbudgetExpences, missing months == 0
                                                                    const budgetExpensesMonthsfill = {};
                                                                    budgetRevenueandbudgetExpences.forEach(item => {
                                                                        budgetExpensesMonthsfill[item.month] = parseFloat(item.total_teamestcost);
                                                                    });

                                                                    // budgetActualRevenue, missing months == 0
                                                                    const budgetActualRevenueMonthsfill = {};
                                                                    budgetActualRevenue.forEach(item => {
                                                                        // budgetActualRevenueMonthsfill[item.month] = parseFloat(item.invoices_amount);
                                                                        budgetActualRevenueMonthsfill[item.month] = parseFloat(item.total_amount);
                                                                    });

                                                                    // budgetActualExpences, missing months == 0
                                                                    const budgetActualExpencesMonthsfill = {};
                                                                    budgetActualExpences.forEach(item => {
                                                                        budgetActualExpencesMonthsfill[item.month] = parseFloat(item.total_cost);
                                                                    });

                                                                    // Create data for all months, if month not on that case assigned 0 
                                                                    const budgetRevenue = budgetvsActualmonths.map(month => budgetRevenueMonthsfill[month] || 0);
                                                                    const actualRevenue = budgetvsActualmonths.map(month => budgetActualRevenueMonthsfill[month] || 0);
                                                                    const budgetExpenses = budgetvsActualmonths.map(month => budgetExpensesMonthsfill[month] || 0);
                                                                    const actualExpenses = budgetvsActualmonths.map(month => budgetActualExpencesMonthsfill[month] || 0);

                                                                    // console.log('budgetRevenue1', budgetRevenue1);
                                                                    // console.log('actualRevenue1', actualRevenue1);
                                                                    // console.log('budgetExpenses1', budgetExpenses1);
                                                                    // console.log('actualExpenses1', actualExpenses1);

                                                                    // const budgetRevenue = [2500000, 2700000, 2800000, 2900000, 2900000, 3000000];
                                                                    // const actualRevenue = [2250000, 2500000, 2600000, 2700000, 2800000, 2900000];
                                                                    // const budgetExpenses = [2000000, 2100000, 2200000, 2300000, 2250000, 2300000];
                                                                    // const actualExpenses = [1800000, 1900000, 2000000, 2100000, 2000000, 2000000];

                                                                    const budgetvsActualMonths = ['Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan', 'Feb', 'Mar'];


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
                                                                                    // display: false
                                                                                    position: 'bottom',
                                                                                    labels: {
                                                                                        font: {
                                                                                            size: 14,
                                                                                            weight: 'bold',
                                                                                        },
                                                                                        color: 'black',
                                                                                        padding: 20,
                                                                                        boxWidth: 20,
                                                                                        boxHeight: 10
                                                                                    }
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
                                           <div style="color: blue;">Budget Revenue: ₹${budgetRevenueValue}</div>
                                           <div style="color: green;">Actual Revenue: ₹${actualRevenueValue}</div>
                                           <div style="color: orange;">Budget Expenses: ₹${budgetExpensesValue}</div>
                                           <div style="color: red;">Actual Expenses: ₹${actualExpensesValue}</div>
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
                                                                {{--  Start Hare --}}
                                                                return view('backEnd.dashboardreport.index',
                                                                compact('invoiceData'));
                                                                <div class="col-md-6 col-lg-3">
                                                                    <div class="p-2 text-white rounded mb-3 p-3 shadow-sm text-center"
                                                                        style="background: #00548bfa;green">
                                                                        <a
                                                                            href="{{ url('totalworkingdays', auth()->user()->teammember_id) }}">
                                                                            <div style="color:white;"
                                                                                class="opacity-50 header-pretitle fs-11 font-weight-bold text-uppercase">
                                                                                Total
                                                                                Working Days
                                                                            </div>
                                                                            <div style="color:white;"
                                                                                class="fs-32 text-monospace">
                                                                                {{ $totalworkingdays ?? '0' }}
                                                                            </div>
                                                                            <small style="color:white;">Days ( January
                                                                                to
                                                                                {{ $currentMonth }} )</small>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                {{-- * regarding  --}}
                                                                {{--  Start Hare --}}
                                                                <script>
                                                                    // Months ka array
                                                                    const lapDaysMonths = ["Jan", "Feb", "Mar", "Apr", "May", "Jun"];

                                                                    // Chart width set kare before creating chart
                                                                    const chartWidth = lapDaysMonths.length * 120; // 120px per month
                                                                    document.getElementById('lapDaysChart').width = chartWidth;

                                                                    // Ab Chart.js banaye
                                                                    new Chart(document.getElementById("lapDaysChart"), {
                                                                        type: 'bar',
                                                                        data: {
                                                                            labels: lapDaysMonths,
                                                                            datasets: [{
                                                                                label: 'Lap Days',
                                                                                data: [12, 19, 3, 5, 2, 3],
                                                                                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                                                                            }]
                                                                        },
                                                                        options: {
                                                                            responsive: false, // Scroll kaam kare isliye responsive ko off rakha
                                                                            maintainAspectRatio: false
                                                                        }
                                                                    });

                                                                    <
                                                                    script >



                                                                        // Chart width set kare before creating chart
                                                                        const chartWidth = lapDaysMonths.length * 120; // 120px per month
                                                                    document.getElementById('lapDaysChart').width = chartWidth;







                                                                    <
                                                                    div class = "h4 font-weight-bold" >
                                                                    {{ number_format($billspendingforcollection) }}
                                                                        <
                                                                        span class = "h6 text-muted" > INR < /span> < /
                                                                    div >



                                                                        <
                                                                        div class = "sidebar-body" >
                                                                        <
                                                                        nav class = "sidebar-nav" >
                                                                        <
                                                                        ul class = "metismenu" >
                                                                        <
                                                                        li class = "nav-label" > Main Menu < /li> <
                                                                    li >
                                                                        <
                                                                        a class = "material-ripple"
                                                                    href = "{{ url('home') }}" >
                                                                        <
                                                                        i class = "typcn typcn-home-outline mr-2" > < /i>
                                                                    Dashboard
                                                                        <
                                                                        /a> < /
                                                                    li > <
                                                                        /ul> < /
                                                                    nav > <
                                                                        /div> <
                                                                    script >
                                                                        var teamsSalaries = @json($teamsSalaries);
                                                                    var teamexceptionalExpenses = @json($teamexceptionalExpenses);
                                                                    const teamsSalariesdata = teamsSalaries.map(item => parseInt(item.total_amount));
                                                                    const teamexceptionalExpensesdata = teamexceptionalExpenses.map(item => item.total_amount);

                                                                    console.log('teamsSalaries', teamsSalaries);
                                                                    console.log('teamexceptionalExpenses', teamexceptionalExpenses);
                                                                    console.log('teamsSalariesdata', teamsSalariesdata);
                                                                    console.log('teamexceptionalExpensesdata', teamexceptionalExpensesdata);


                                                                    var teamsSalaries = @json($teamsSalaries);
                                                                    var teamexceptionalExpenses = @json($teamexceptionalExpenses);

                                                                    // Create array of all months for consistent x-axis
                                                                    const allMonths = ['January', 'February', 'March', 'April', 'May', 'June'];

                                                                    // Process salaries data - fill missing months with 0
                                                                    const salariesByMonth = {};
                                                                    teamsSalaries.forEach(item => {
                                                                        salariesByMonth[item.month] = parseFloat(item.total_amount);
                                                                    });

                                                                    // Process expenses data - fill missing months with 0
                                                                    const expensesByMonth = {};
                                                                    teamexceptionalExpenses.forEach(item => {
                                                                        expensesByMonth[item.month] = parseFloat(item.total_amount);
                                                                    });

                                                                    // Create complete datasets for all months
                                                                    const completeSalariesData = allMonths.map(month => salariesByMonth[month] || 0);
                                                                    const completeExpensesData = allMonths.map(month => expensesByMonth[month] || 0);





                                                                    console.log('teamsSalaries', teamsSalaries);
                                                                    console.log('teamexceptionalExpenses', teamexceptionalExpenses);
                                                                    console.log('allMonths', allMonths);
                                                                    console.log('salariesByMonth', salariesByMonth);
                                                                    console.log('expensesByMonth', expensesByMonth);
                                                                    console.log('Complete Salaries Data:', completeSalariesData);
                                                                    console.log('Complete Expenses Data:', completeExpensesData);
                                                                </script>
                                                                <style>
                                                                    #chart-message div {
                                                                        margin: 4px 0;
                                                                    }
                                                                </style>

                                                                <script>
                                                                    const staffAllocationCtx = document.getElementById('expenseChart2').getContext('2d');
                                                                    var teamAllocatedHours = @json($teamAllocatedHours);

                                                                    // Extract data
                                                                    const allocatedHours = teamAllocatedHours.map(item => parseInt(item.teamallocatedhours));
                                                                    const actualHours = teamAllocatedHours.map(item => item.actualhours);
                                                                    const discrepancy = teamAllocatedHours.map(item => item.discrepancy);
                                                                    const teamMembers = teamAllocatedHours.map(item => item.team_member);

                                                                    // ✅ Plugin to show message
                                                                    const customMessagePlugin = {
                                                                        id: 'customMessagePlugin',
                                                                        afterDraw(chart) {
                                                                            let messageEl = document.getElementById('chart-message');

                                                                            if (!messageEl) {
                                                                                messageEl = document.createElement('div');
                                                                                messageEl.id = 'chart-message';
                                                                                messageEl.style.marginTop = '20px';
                                                                                messageEl.style.fontSize = '16px';
                                                                                messageEl.style.fontWeight = 'bold';
                                                                                messageEl.style.color = '#111';
                                                                                messageEl.innerHTML = `
                    <div>Over-Allocated: <span style="color:red;">3</span></div>
                    <div>Under-Utilized: <span style="color:orange;">3</span></div>
                    <div>Total Discrepancy: <span style="color:#444;">4</span></div>
                    <div>Avg Efficiency: <span style="color:green;">101%</span></div>
                `;
                                                                                chart.canvas.parentNode.appendChild(messageEl);
                                                                            }
                                                                        }
                                                                    };

                                                                    // ✅ Create Chart
                                                                    const expenseChart2 = new Chart(staffAllocationCtx, {
                                                                        type: 'bar',
                                                                        data: {
                                                                            labels: teamMembers,
                                                                            datasets: [{
                                                                                    label: 'Allocated Hours',
                                                                                    data: allocatedHours,
                                                                                    backgroundColor: 'rgb(59, 130, 246)',
                                                                                    borderColor: 'rgb(59, 130, 246)',
                                                                                    borderWidth: 1
                                                                                },
                                                                                {
                                                                                    label: 'Actual Hours',
                                                                                    data: actualHours,
                                                                                    backgroundColor: 'rgb(16, 185, 129)',
                                                                                    borderColor: 'rgb(16, 185, 129)',
                                                                                    borderWidth: 1
                                                                                },
                                                                                {
                                                                                    label: 'Discrepancy',
                                                                                    data: discrepancy,
                                                                                    backgroundColor: 'rgb(239, 68, 68)',
                                                                                    borderColor: 'rgb(239, 68, 68)',
                                                                                    borderWidth: 1
                                                                                }
                                                                            ]
                                                                        },
                                                                        options: {
                                                                            scales: {
                                                                                y: {
                                                                                    max: 165,
                                                                                    beginAtZero: true,
                                                                                    ticks: {
                                                                                        stepSize: 55
                                                                                    }
                                                                                }
                                                                            },
                                                                            plugins: {
                                                                                legend: {
                                                                                    position: 'bottom',
                                                                                    labels: {
                                                                                        font: {
                                                                                            size: 14,
                                                                                            weight: 'bold',
                                                                                        },
                                                                                        color: 'black',
                                                                                        padding: 20,
                                                                                        boxWidth: 20,
                                                                                        boxHeight: 10
                                                                                    }
                                                                                },
                                                                                tooltip: {
                                                                                    enabled: false,
                                                                                    external: function(context) {
                                                                                        let tooltipEl = document.getElementById('chartjs-tooltip');

                                                                                        if (!tooltipEl) {
                                                                                            tooltipEl = document.createElement('div');
                                                                                            tooltipEl.id = 'chartjs-tooltip';
                                                                                            tooltipEl.innerHTML = '<div></div>';
                                                                                            document.body.appendChild(tooltipEl);
                                                                                        }

                                                                                        const tooltipModel = context.tooltip;

                                                                                        if (tooltipModel.opacity === 0) {
                                                                                            tooltipEl.style.opacity = 0;
                                                                                            return;
                                                                                        }

                                                                                        if (tooltipModel.body) {
                                                                                            const index = tooltipModel.dataPoints[0].dataIndex;
                                                                                            const month = teamMembers[index];
                                                                                            const allocatedHoursValue = allocatedHours[index];
                                                                                            const actualHoursValue = actualHours[index];
                                                                                            const discrepancyValue = discrepancy[index];

                                                                                            const innerHtml = `
                                <div style="background: white; border: 1px solid #ccc; padding: 8px; border-radius: 4px;">
                                    <div style="color: black; font-weight: bold; margin-bottom: 4px;">${month}</div>
                                    <div style="color: blue;">Allocated Hours: ${allocatedHoursValue} hrs</div>
                                    <div style="color: green;">Actual Hours: ${actualHoursValue} hrs</div>
                                    <div style="color: red;">Discrepancy: ${discrepancyValue} hrs</div>
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
                                                                        },
                                                                        plugins: [customMessagePlugin]
                                                                    }); <
                                                                    />

                                                                    @foreach ($assignmentOverviews as $assignmentOverview)
                                                                        <
                                                                        div class = "assignment-card" >
                                                                        <
                                                                        div class = "assignment-header" >
                                                                        <
                                                                        div class = "assignment-title" >
                                                                        <
                                                                        h3 > {{ $assignmentOverview->client_name ?? '' }} < /h3> <
                                                                        p > {{ $assignmentOverview->assignmentname ?? '' }} < /p> < /
                                                                        div > <
                                                                            div class = "assignment-status" >
                                                                            @php
                                                                                $endDate = $assignmentOverview->finalassignmentenddate;
                                                                            @endphp
                                                                        @if ($assignmentOverview->status == 0)
                                                                            <
                                                                            span class = "priority-tag completed1" > COMPLETED < /span>
                                                                        @elseif ($endDate && \Carbon\Carbon::parse($endDate)->isFuture()) <
                                                                            span class = "priority-tag on-track1" > ON TRACK < /span>
                                                                        @else
                                                                            <
                                                                            span class = "priority-tag delayed1" > DELAYED < /span>
                                                                        @endif <
                                                                        /div> < /
                                                                        div > <
                                                                            div class = "progress-container" >
                                                                            <
                                                                            div class = "progress-info" >
                                                                            <
                                                                            span > Progress < /span> <
                                                                        span > 85 % < /span> < /
                                                                        div > <
                                                                            div class = "progress-bar" >
                                                                            <
                                                                            div class = "progress-fill progress-85" > < /div> < /
                                                                        div > <
                                                                            /div> <
                                                                        div class = "text-muted small"
                                                                        style = "margin-top: 8px; font-size: 12px;" > Due:
                                                                            {{ $assignmentOverview->finalassignmentenddate }} <
                                                                            /div> < /
                                                                        div >
                                                                    @endforeach


                                                                    <
                                                                    div class = "card" >
                                                                    <
                                                                    div class = "card-header" >
                                                                    <
                                                                    h2 > Cash Flow Analysis < /h2> < /
                                                                    div > <
                                                                        canvas id = "cashFlowChart"
                                                                    width = "auto"
                                                                    height = "250" > < /canvas> < /
                                                                    div >

                                                                        <
                                                                        script >
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
                                                                {{-- Monthly Expense Analysis completed --}}
                                                                <div class="card">
                                                                    <div class="card-header">
                                                                        <h2>Monthly Expense Analysis</h2>
                                                                    </div>
                                                                    <canvas id="expenseChart" width="auto"
                                                                        height="250"></canvas>
                                                                </div>

                                                                <script>
                                                                    const ctx = document.getElementById('expenseChart').getContext('2d');
                                                                    const revenueData = [140000, 110000, 130000, 120000, 120000, 140000];
                                                                    const expenseData = [55000, 60000, 40000, 70000, 75000, 50000];
                                                                    // Labels for X-axis (mahine ke naam).
                                                                    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];

                                                                    const expenseChart = new Chart(ctx, {
                                                                        type: 'bar',
                                                                        data: {
                                                                            labels: months,
                                                                            datasets: [{
                                                                                    label: 'Revenue',
                                                                                    data: revenueData,
                                                                                    backgroundColor: 'rgb(59, 130, 246)',
                                                                                    borderColor: 'rgb(59, 130, 246)',
                                                                                    borderWidth: 1 // border width
                                                                                },
                                                                                {
                                                                                    label: 'Expenses',
                                                                                    data: expenseData,
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
                                                                                            const month = months[index];
                                                                                            const revenue = revenueData[index];
                                                                                            const expense = expenseData[index];

                                                                                            const innerHtml = `
                        <div style="background: white; border: 1px solid #ccc; padding: 8px; border-radius: 4px;">
                            <div style="color: black; font-weight: bold; margin-bottom: 4px;">${month}</div>
                            <div style="color: blue;">Revenue: ${revenue}</div>
                            <div style="color: red;">Expense: ${expense}</div>
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
                                                                        <h2>Cash Flow Analysis</h2>
                                                                    </div>
                                                                    <canvas id="cashFlowChart" width="auto"
                                                                        height="250"></canvas>
                                                                </div>

                                                                <script>
                                                                    const ctx = document.getElementById('cashFlowChart').getContext('2d');
                                                                    const cashInflowData = [400000, 350000, 350000, 400000, 500000, 700000];
                                                                    const cashOutflowData = [100000, 80000, 90000, 120000, 130000, 150000];
                                                                    const netCashflowData = [-400000, -350000, -300000, -250000, -200000, -200000];
                                                                    // Labels for X-axis (mahine ke naam).
                                                                    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];

                                                                    const cashFlowChart = new Chart(ctx, {
                                                                        type: 'line',
                                                                        data: {
                                                                            labels: months,
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
                                                                                            const month = months[index];
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

                                                                {{-- <div class="card">
              <div class="card-header">
                    <h2><i class="fa-solid fa-triangle-exclamation"></i> High Priority Tasks Pending</h2>
                </div>

                <div class="document-progress">

                    
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
                </div>
            </div> --}}

                                                                <div class="dashboard-content">
                                                                    <!-- Assignment Status Overview -->
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
                                                                                    <span
                                                                                        class="priority-tag on-track">ON
                                                                                        TRACK</span>
                                                                                    <span
                                                                                        class="priority-tag high-priority">HIGH
                                                                                        PRIORITY</span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="progress-container">
                                                                                <div class="progress-info">
                                                                                    <span>Progress</span>
                                                                                    <span>85%</span>
                                                                                </div>
                                                                                <div class="progress-bar">
                                                                                    <div
                                                                                        class="progress-fill progress-85">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="assignment-card">
                                                                            <div class="assignment-header">
                                                                                <div class="assignment-title">
                                                                                    <h3>GST Compliance - XYZ Ltd</h3>
                                                                                    <p>XYZ Limited</p>
                                                                                </div>
                                                                                <div class="assignment-status">
                                                                                    <span
                                                                                        class="priority-tag delayed">DELAYED</span>
                                                                                    <span
                                                                                        class="priority-tag high-priority">HIGH
                                                                                        PRIORITY</span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="progress-container">
                                                                                <div class="progress-info">
                                                                                    <span>Progress</span>
                                                                                    <span>45%</span>
                                                                                </div>
                                                                                <div class="progress-bar">
                                                                                    <div
                                                                                        class="progress-fill progress-45">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Document Completion Progress -->
                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                            <h2>Document Completion Progress</h2>
                                                                        </div>

                                                                        <div class="document-progress">
                                                                            <div class="document-card">
                                                                                <h4 class="document-title">Tax Audit -
                                                                                    ABC Corp
                                                                                </h4>
                                                                                <div class="document-info">
                                                                                    <span>42/50 docs</span>
                                                                                    <span
                                                                                        class="progress-value">84%</span>
                                                                                </div>
                                                                                <div class="progress-bar">
                                                                                    <div
                                                                                        class="progress-fill progress-84">
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="document-card">
                                                                                <h4 class="document-title">GST
                                                                                    Compliance - XYZ
                                                                                    Ltd
                                                                                </h4>
                                                                                <div class="document-info">
                                                                                    <span>18/30 docs</span>
                                                                                    <span
                                                                                        class="progress-value">60%</span>
                                                                                </div>
                                                                                <div class="progress-bar">
                                                                                    <div
                                                                                        class="progress-fill progress-60">
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="document-card">
                                                                                <h4 class="document-title">Financial
                                                                                    Review -
                                                                                    DEF Co
                                                                                </h4>
                                                                                <div class="document-info">
                                                                                    <span>25/25 docs</span>
                                                                                    <span
                                                                                        class="progress-value">100%</span>
                                                                                </div>
                                                                                <div class="progress-bar">
                                                                                    <div
                                                                                        class="progress-fill progress-100">
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="document-card">
                                                                                <h4 class="document-title">Statutory
                                                                                    Audit -
                                                                                    GHI Inc
                                                                                </h4>
                                                                                <div class="document-info">
                                                                                    <span>15/40 docs</span>
                                                                                    <span
                                                                                        class="progress-value">37%</span>
                                                                                </div>
                                                                                <div class="progress-bar">
                                                                                    <div
                                                                                        class="progress-fill progress-37">
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="document-card">
                                                                                <h4 class="document-title">Compliance
                                                                                    Review -
                                                                                    JKL Co
                                                                                </h4>
                                                                                <div class="document-info">
                                                                                    <span>28/35 docs</span>
                                                                                    <span
                                                                                        class="progress-value">80%</span>
                                                                                </div>
                                                                                <div class="progress-bar">
                                                                                    <div
                                                                                        class="progress-fill progress-80">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <link rel="stylesheet"
                                                                    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
                                                                <link
                                                                    href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
                                                                    rel="stylesheet">
                                                                <style>
                                                                    * {
                                                                        margin: 0;
                                                                        padding: 0;
                                                                        box-sizing: border-box;
                                                                    }

                                                                    body {
                                                                        font-family: 'Poppins', sans-serif;
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

                                                                    .dashboard-content {
                                                                        display: grid;
                                                                        grid-template-columns: 1fr 1fr;
                                                                        gap: 25px;
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
                                                                        font-weight: 600;
                                                                        color: #2c3e50;
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

                                                                    .document-title h4 {
                                                                        font-size: 16px;
                                                                        font-weight: 500;
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

                                                                        .dashboard-content,
                                                                        .dashboard-bottom {
                                                                            grid-template-columns: 1fr;
                                                                        }
                                                                    }
                                                                </style>

                                                                @foreach ($tabs as $tabId => $roleKey)
                                                                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                                                        id="{{ $tabId }}" role="tabpanel"
                                                                        aria-labelledby="{{ $tabId }}-tab">

                                                                        <div class="d-flex justify-content-between align-items-center flex-wrap py-3 px-4 mb-2"
                                                                            style="background-color: #dee0e961; height: 81px; width: 100%;">
                                                                            <div
                                                                                class="d-flex align-items-center flex-wrap">
                                                                                <i class="fas fa-users me-2"
                                                                                    style="color: #6c757d; font-size: 20px;"></i>
                                                                                <h5 class="mb-0 me-2"
                                                                                    style="margin-left: 8px;">
                                                                                    Team
                                                                                    KRA List</h5>
                                                                                <span
                                                                                    class="badge bg-white text-dark ms-3"
                                                                                    style="margin-left: 17px;">
                                                                                    {{ count($designationData[$roleKey]['teammemberall']) }}
                                                                                    members
                                                                                </span>
                                                                                <div style="margin-left: 10px">
                                                                                    <a data-toggle="modal"
                                                                                        data-target=".notificationmodeltarget"
                                                                                        data-id="{{ $designationData[$roleKey]['designationId'] }}"
                                                                                        class="btn btn-sm btn-update text-black notificationmodelclass">
                                                                                        <i class="fas fa-bell"
                                                                                            style="margin-right: 4px;"></i>
                                                                                        Notification
                                                                                    </a>
                                                                                </div>
                                                                                <div style="margin-left: 10px">
                                                                                    <a href="{{ url('kratemplatelist/' . $designationData[$roleKey]['designationId']) }}"
                                                                                        class="btn btn-sm btn-update text-black">
                                                                                        <i class="typcn typcn-document-text"
                                                                                            style="margin-right: 4px;"></i>
                                                                                        KRAs Templates
                                                                                    </a>
                                                                                </div>
                                                                            </div>

                                                                            <div class="btn-group mt-2 mt-md-0">
                                                                                <a href="javascript:void(0);"
                                                                                    data-toggle="modal"
                                                                                    data-target=".exampleModal1500-modal-lg"
                                                                                    data-id="{{ $designationData[$roleKey]['designationId'] }}"
                                                                                    data-kraexist1="{{ $designationData[$roleKey]['krasid'] }}"
                                                                                    data-templates="{{ json_encode($designationData[$roleKey]['kratemplates']) }}"
                                                                                    class="btn btn-sm btn-update text-black uploadkrasModel500 upload-button d-none">
                                                                                    <i class="fas fa-upload me-1"></i>
                                                                                    Upload
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="table-responsive">
                                                                            <table
                                                                                id="example{{ $loop->iteration }}"
                                                                                class="table display table-bordered table-striped table-hover">
                                                                                <thead>
                                                                                    <tr>
                                                                                        @if ($designationData[$roleKey]['hasKras'])
                                                                                            <th
                                                                                                style="vertical-align: middle; text-align: center; width: 40px;">
                                                                                                <div
                                                                                                    class="form-check m-0 d-flex justify-content-center align-items-center">
                                                                                                    <input
                                                                                                        class="form-check-input select-all-checkbox"
                                                                                                        type="checkbox"
                                                                                                        data-table-id="example{{ $loop->iteration }}"
                                                                                                        style="border: 1px solid #6c757d; width: 18px; height: 18px;">
                                                                                                </div>
                                                                                            </th>
                                                                                        @endif
                                                                                        <th class="textfixed">Employee
                                                                                            Name
                                                                                        </th>
                                                                                        <th class="textfixed">KRAs
                                                                                            Status</th>
                                                                                        <th class="textfixed">
                                                                                            Reporting Manager
                                                                                        </th>
                                                                                        <th class="textfixed">Created
                                                                                            Date</th>
                                                                                        <th class="textfixed">Updated
                                                                                            Date</th>
                                                                                        @if ($teammembers && in_array($teammembers->designation, [13, 14]))
                                                                                            <th>Action</th>
                                                                                        @endif
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    @foreach ($designationData[$roleKey]['teammemberall'] as $index => $row)
                                                                                        <tr>
                                                                                            @if ($designationData[$roleKey]['hasKras'])
                                                                                                <td
                                                                                                    style="font-size:3px">
                                                                                                    @if ($row->kra_status != 1)
                                                                                                        <div
                                                                                                            class="form-check">
                                                                                                            <input
                                                                                                                class="form-check-input"
                                                                                                                type="checkbox"
                                                                                                                name="selected_items[]"
                                                                                                                value="{{ $row->id }}"
                                                                                                                style="border: 1px solid #6c757d;">
                                                                                                        </div>
                                                                                                    @endif
                                                                                                </td>
                                                                                            @endif
                                                                                            {{-- <td>{{ $index + 1 }}</td> --}}
                                                                                            <td>
                                                                                                <div class="fw-bold">
                                                                                                    {{ $row->team_member }}
                                                                                                </div>
                                                                                                <div
                                                                                                    class="text-muted small">
                                                                                                    {{ $row->designation_name }}
                                                                                                </div>
                                                                                            </td>
                                                                                            <td>
                                                                                                @if ($row->kra_status == 1)
                                                                                                    <span
                                                                                                        class="badge"
                                                                                                        style="background-color: rgba(24, 255, 91, 0.33); color: #000;">
                                                                                                        KRA
                                                                                                    </span>
                                                                                                @else
                                                                                                    <span
                                                                                                        class="badge"
                                                                                                        style="background-color: rgb(246 154 154 / 33%);color: #000;">No
                                                                                                        KRA</span>
                                                                                                @endif
                                                                                            </td>
                                                                                            <td>
                                                                                                {{ $row->reportingmanager ?? 'N/A' }}
                                                                                            </td>
                                                                                            <td>
                                                                                                {{ $row->kra_created ? date('d-m-Y', strtotime($row->kra_created)) : 'N/A' }}
                                                                                            </td>
                                                                                            <td>
                                                                                                {{ $row->kra_updated ? date('d-m-Y', strtotime($row->kra_updated)) : 'N/A' }}
                                                                                            </td>
                                                                                            @if ($teammembers && in_array($teammembers->designation, [13, 14]))
                                                                                                <td class="textfixed">
                                                                                                    @if ($row->kra_status == 1)
                                                                                                        <a href="{{ route('kras.show', ['id' => $row->id, 'designation' => $row->designation]) }}"
                                                                                                            class="btn btn-sm btn-view text-black">
                                                                                                            <i class="far fa-eye"
                                                                                                                style="margin-right: 4px;"></i>
                                                                                                            View
                                                                                                        </a>

                                                                                                        {{-- <a href="{{ route('kras.delete', ['id' => $row->id, 'designation' => $row->designation]) }}"
                                                                      class="btn btn-sm btn-update text-black">
                                                                      <i class="far fa-edit" style="margin-right: 4px;"></i>
                                                                      Update
                                                                  </a> --}}

                                                                                                        <a href="{{ route('kras.delete', ['id' => $row->id, 'designation' => $row->designation]) }}"
                                                                                                            onclick="return confirm('Are you sure you want to delete this item?');"
                                                                                                            class="btn btn-sm btn-delete text-danger">
                                                                                                            <i class="far fa-trash-alt"
                                                                                                                style="margin-right: 4px;"></i>
                                                                                                            Delete
                                                                                                        </a>
                                                                                                        @if ($row->is_kradraft == 1)
                                                                                                            <a href="{{ route('kras.finaldraftsubmit', ['teamId' => $row->id, 'designationId' => $row->designation]) }}"
                                                                                                                onclick="return confirm('Are you sure you want to finalize and submit the KRAs ?');"
                                                                                                                class="btn btn-sm btn-update text-black">
                                                                                                                <i class="fas fa-check-circle"
                                                                                                                    style="margin-right: 4px;"></i>
                                                                                                                Finalize
                                                                                                                Draft
                                                                                                            </a>
                                                                                                        @endif
                                                                                                    @else
                                                                                                        <a data-toggle="modal"
                                                                                                            data-target=".exampleModal1556-modal-lg"
                                                                                                            data-id="{{ $row->id }}"
                                                                                                            data-column="{{ $row->designation }}"
                                                                                                            data-templates="{{ json_encode($designationData[$roleKey]['kratemplates']) }}"
                                                                                                            class="btn btn-sm btn-update text-black uploadkrasModel">
                                                                                                            <i class="fas fa-upload"
                                                                                                                style="margin-right: 4px;"></i>
                                                                                                            Upload
                                                                                                        </a>
                                                                                                    @endif
                                                                                                </td>
                                                                                            @endif
                                                                                        </tr>
                                                                                    @endforeach
                                                                                </tbody>
                                                                                {{-- @endif --}}
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                                @foreach ($timesheetData as $timesheetDatas)
                                                                    <tr>
                                                                        @php
                                                                            $timeid = DB::table('timesheetusers')
                                                                                ->where(
                                                                                    'timesheetusers.id',
                                                                                    $timesheetDatas->id,
                                                                                )
                                                                                ->first();

                                                                            $client_id = DB::table('timesheetusers')
                                                                                ->leftjoin(
                                                                                    'clients',
                                                                                    'clients.id',
                                                                                    'timesheetusers.client_id',
                                                                                )
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
                                                                                ->leftjoin(
                                                                                    'teammembers',
                                                                                    'teammembers.id',
                                                                                    'timesheetusers.partner',
                                                                                )
                                                                                ->where(
                                                                                    'timesheetusers.id',
                                                                                    $timesheetDatas->id,
                                                                                )
                                                                                ->select(
                                                                                    'clients.client_name',
                                                                                    'clients.client_code',
                                                                                    'timesheetusers.hour',
                                                                                    'timesheetusers.id',
                                                                                    'timesheetusers.location',
                                                                                    'timesheetusers.status',
                                                                                    'assignments.assignment_name',
                                                                                    'billable_status',
                                                                                    'workitem',
                                                                                    'teammembers.team_member',
                                                                                    'teammembers.staffcode',
                                                                                    'assignmentbudgetings.assignmentname',
                                                                                )
                                                                                ->first();

                                                                            // dd($client_id);
                                                                            $total = DB::table('timesheetusers')

                                                                                ->where(
                                                                                    'timesheetusers.timesheetid',
                                                                                    $timesheetDatas->timesheetid,
                                                                                )
                                                                                ->sum('hour');

                                                                            $dates = date(
                                                                                'l',
                                                                                strtotime($timesheetDatas->date),
                                                                            );

                                                                            $assignmentcheck = DB::table(
                                                                                'assignmentbudgetings',
                                                                            )
                                                                                ->where(
                                                                                    'assignmentgenerate_id',
                                                                                    $timesheetDatas->assignmentgenerate_id,
                                                                                )
                                                                                ->first();

                                                                            $teamMembers = DB::table('teamrolehistory')
                                                                                ->whereIn('teammember_id', [
                                                                                    $timesheetDatas->createdby,
                                                                                    $timesheetDatas->partner,
                                                                                ])
                                                                                ->get()
                                                                                ->keyBy('teammember_id');

                                                                            $datadate = $assignmentcheck
                                                                                ? Carbon\Carbon::createFromFormat(
                                                                                    'Y-m-d H:i:s',
                                                                                    $assignmentcheck->created_at,
                                                                                )
                                                                                : null;

                                                                            // dd($teamMembers);

                                                                            $permotioncheck =
                                                                                $teamMembers[
                                                                                    $timesheetDatas->createdby
                                                                                ] ?? null;
                                                                            $approverdata =
                                                                                $teamMembers[
                                                                                    $timesheetDatas->partner
                                                                                ] ?? null;

                                                                            $permotiondate = $permotioncheck
                                                                                ? Carbon\Carbon::createFromFormat(
                                                                                    'Y-m-d H:i:s',
                                                                                    $permotioncheck->created_at,
                                                                                )
                                                                                : null;
                                                                            $approverdate = $approverdata
                                                                                ? Carbon\Carbon::createFromFormat(
                                                                                    'Y-m-d H:i:s',
                                                                                    $approverdata->created_at,
                                                                                )
                                                                                : null;

                                                                            $targetAssignments = [29, 34, 32, 33, 134];
                                                                            if (
                                                                                in_array(
                                                                                    $timesheetDatas->client_id,
                                                                                    $targetAssignments,
                                                                                )
                                                                            ) {
                                                                                $rejoindpromotioncheck = DB::table(
                                                                                    'teamrolehistory',
                                                                                )
                                                                                    ->where(
                                                                                        'teammember_id',
                                                                                        $timesheetDatas->createdby,
                                                                                    )
                                                                                    ->first();

                                                                                $timesheetDate = $timesheetDatas->date
                                                                                    ? Carbon\Carbon::createFromFormat(
                                                                                        'Y-m-d',
                                                                                        $timesheetDatas->date,
                                                                                    )->startOfDay()
                                                                                    : null;

                                                                                $rejoindpromotioncheckdate = null;
                                                                                if ($rejoindpromotioncheck) {
                                                                                    $rejoindpromotioncheckdate = Carbon\Carbon::createFromFormat(
                                                                                        'Y-m-d H:i:s',
                                                                                        $rejoindpromotioncheck->created_at,
                                                                                    )->startOfDay();
                                                                                }
                                                                            }

                                                                            if (
                                                                                in_array(
                                                                                    $timesheetDatas->client_id,
                                                                                    $targetAssignments,
                                                                                )
                                                                            ) {
                                                                                $rejoindpromotioncheckpartner = DB::table(
                                                                                    'teamrolehistory',
                                                                                )
                                                                                    ->where(
                                                                                        'teammember_id',
                                                                                        $timesheetDatas->partner,
                                                                                    )
                                                                                    ->first();

                                                                                $timesheetDatepartner = $timesheetDatas->date
                                                                                    ? Carbon\Carbon::createFromFormat(
                                                                                        'Y-m-d',
                                                                                        $timesheetDatas->date,
                                                                                    )->startOfDay()
                                                                                    : null;

                                                                                $rejoindpromotioncheckdatepartner = null;
                                                                                if ($rejoindpromotioncheckpartner) {
                                                                                    $rejoindpromotioncheckdatepartner = Carbon\Carbon::createFromFormat(
                                                                                        'Y-m-d H:i:s',
                                                                                        $rejoindpromotioncheckpartner->created_at,
                                                                                    )->startOfDay();
                                                                                }
                                                                            }
                                                                        @endphp
                                                                        <td style="display: none;">
                                                                            {{ $timesheetDatas->id }}
                                                                        </td>

                                                                        <td class="textfixed">
                                                                            {{ $timesheetDatas->team_member ?? '' }}
                                                                        </td>
                                                                        {{-- <td>
                                        @if ($permotioncheck && $datadate && $datadate->greaterThan($permotiondate))
                                            {{ $permotioncheck->newstaff_code }}
                                        @else
                                            {{ $timesheetDatas->staffcode }}
                                        @endif
                                    </td> --}}
                                                                        @if (in_array($timesheetDatas->client_id, $targetAssignments))
                                                                            @if ($rejoindpromotioncheck && $timesheetDate && $timesheetDate->greaterThanOrEqualTo($rejoindpromotioncheckdate))
                                                                                <td>{{ $rejoindpromotioncheck->newstaff_code }}
                                                                                </td>
                                                                            @else
                                                                                <td>{{ $timesheetDatas->staffcode }}
                                                                                </td>
                                                                            @endif
                                                                        @else
                                                                            <td>
                                                                                @if ($permotioncheck && $datadate && $datadate->greaterThan($permotiondate))
                                                                                    {{ $permotioncheck->newstaff_code }}
                                                                                @else
                                                                                    {{ $timesheetDatas->staffcode }}
                                                                                @endif
                                                                            </td>
                                                                        @endif
                                                                        <td class="textfixed">
                                                                            <span style="display: none;">
                                                                                {{ date('Y-m-d', strtotime($timesheetDatas->date)) }}
                                                                            </span>
                                                                            {{ date('d-m-Y', strtotime($timesheetDatas->date)) }}
                                                                        </td>

                                                                        <td class="textfixed">
                                                                            @if ($timesheetDatas->date != null)
                                                                                {{ $dates ?? '' }}
                                                                            @endif
                                                                        </td>
                                                                        <td class="textfixed">
                                                                            {{ $client_id->client_name ?? '' }}
                                                                            @if (count((array) $client_id->client_name) > 1)
                                                                                ,
                                                                            @endif
                                                                        </td>
                                                                        <td class="textfixed">
                                                                            {{ $client_id->client_code ?? '' }}
                                                                            @if (count((array) $client_id->client_code) > 1)
                                                                                ,
                                                                            @endif
                                                                        </td>
                                                                        <td class="textfixed">
                                                                            {{ $client_id->assignment_name ?? '' }}
                                                                            @if ($timesheetDatas->assignmentname != null)
                                                                                ({{ $timesheetDatas->assignmentname ?? '' }})
                                                                            @endif
                                                                            @if (count((array) $client_id->assignment_name) > 1)
                                                                                ,
                                                                            @endif
                                                                        </td>

                                                                        <td class="textfixed">
                                                                            {{ $timesheetDatas->assignmentgenerate_id ?? '' }}
                                                                        </td>

                                                                        <td class="textfixed">
                                                                            {{ $client_id->workitem ?? '' }}
                                                                            @if (count((array) $client_id->workitem) > 1)
                                                                                ,
                                                                            @endif
                                                                        </td>

                                                                        <td class="textfixed">
                                                                            {{ $client_id->location ?? '' }}
                                                                            @if (count((array) $client_id->location) > 1)
                                                                                ,
                                                                            @endif
                                                                        </td>
                                                                        <td class="textfixed">
                                                                            {{ $client_id->team_member ?? '' }}
                                                                            @if (count((array) $client_id->team_member) > 1)
                                                                                ,
                                                                            @endif
                                                                        </td>
                                                                        {{-- <td class="textfixed">
                                        @if ($approverdata && $datadate && $datadate->greaterThan($approverdate))
                                            {{ $approverdata->newstaff_code }}
                                        @else
                                            {{ $client_id->staffcode ?? '' }}
                                        @endif
                                        @if (count((array) $client_id->team_member) > 1)
                                            ,
                                        @endif
                                    </td> --}}
                                                                        <td class="textfixed">
                                                                            @if (in_array($timesheetDatas->client_id, $targetAssignments))
                                                                                @if (
                                                                                    $rejoindpromotioncheckpartner &&
                                                                                        $timesheetDatepartner &&
                                                                                        $timesheetDatepartner->greaterThanOrEqualTo($rejoindpromotioncheckdatepartner))
                                                                                    {{ $rejoindpromotioncheckpartner->newstaff_code }}
                                                                                @else
                                                                                    {{ $client_id->staffcode ?? '' }}
                                                                                @endif
                                                                                @if (count((array) $client_id->team_member) > 1)
                                                                                    ,
                                                                                @endif
                                                                            @else
                                                                                @if ($approverdata && $datadate && $datadate->greaterThan($approverdate))
                                                                                    {{ $approverdata->newstaff_code }}
                                                                                @else
                                                                                    {{ $client_id->staffcode ?? '' }}
                                                                                @endif
                                                                                @if (count((array) $client_id->team_member) > 1)
                                                                                    ,
                                                                                @endif
                                                                            @endif
                                                                        </td>
                                                                        <td>{{ $total }}</td>
                                                                        <td class="textfixed">

                                                                            @if ($client_id->status == 0)
                                                                                <span
                                                                                    class="badge badge-pill badge-warning">saved</span>
                                                                            @elseif ($client_id->status == 1)
                                                                                <span
                                                                                    class="badge badge-pill badge-danger">submit</span>
                                                                            @elseif ($client_id->status == 3)
                                                                                <span
                                                                                    class="badge badge-pill badge-info">Submitted</span>
                                                                            @else
                                                                                <span
                                                                                    class="badge badge-pill badge-secondary">Rejected</span>
                                                                            @endif

                                                                        </td>

                                                                        @if (Auth::user()->role_id == 13 || Auth::user()->role_id == 14 || Auth::user()->role_id == 15)
                                                                            <td>
                                                                                @if ($client_id->status == 2)
                                                                                    <a href="{{ url('/timesheetreject/edit/' . $client_id->id) }}"
                                                                                        class="btn btn-info-soft btn-sm"><i
                                                                                            class="far fa-edit"></i></a>
                                                                                @endif

                                                                            </td>
                                                                        @endif
                                                                    </tr>

                                                                    <div class="modal fade" id="exampleModal12"
                                                                        tabindex="-1" role="dialog"
                                                                        aria-labelledby="exampleModalLabel4"
                                                                        aria-hidden="true">
                                                                        <div class="modal-dialog" role="document">
                                                                            <div class="modal-content">
                                                                                <form id="detailsForm"
                                                                                    method="post"
                                                                                    action="{{ url('/timesheet/submit') }}"
                                                                                    enctype="multipart/form-data"
                                                                                    style="margin-bottom: 0px;">
                                                                                    @csrf
                                                                                    <div class="modal-header"
                                                                                        style="background:#37A000;color:white; m-5">
                                                                                        <h5 class="modal-title font-weight-600"
                                                                                            id="exampleModalLabel4">
                                                                                            Update
                                                                                            Timesheet</h5>
                                                                                        <div>
                                                                                            <ul>
                                                                                                @foreach ($errors->all() as $e)
                                                                                                    <li
                                                                                                        style="color:red;">
                                                                                                        {{ $e }}
                                                                                                    </li>
                                                                                                @endforeach
                                                                                            </ul>
                                                                                        </div>
                                                                                        <button style="color: white"
                                                                                            type="button"
                                                                                            class="close"
                                                                                            data-dismiss="modal"
                                                                                            aria-label="Close">
                                                                                            <span
                                                                                                aria-hidden="true">&times;</span>
                                                                                        </button>
                                                                                    </div>
                                                                                    <div class="modal-body">

                                                                                        <div class="row row-sm">
                                                                                            {{-- <label for="name" class="col-sm-3 col-form-label font-weight-600">Name :</label> --}}
                                                                                            <div class="col-sm-12">
                                                                                                <input type="text"
                                                                                                    readonly
                                                                                                    id="teamname"
                                                                                                    class="form-control"
                                                                                                    placeholder="Enter Name">
                                                                                                <input hidden
                                                                                                    class="form-control"
                                                                                                    id="timesheetid"
                                                                                                    name="timesheetid"
                                                                                                    type="text">
                                                                                            </div>
                                                                                        </div>

                                                                                        <br>
                                                                                        @php

                                                                                            $clientlist = DB::table(
                                                                                                'clients',
                                                                                            )
                                                                                                ->select(
                                                                                                    'clients.client_name',
                                                                                                    'clients.id',
                                                                                                )
                                                                                                ->get();
                                                                                            $partner = DB::table(
                                                                                                'teammembers',
                                                                                            )
                                                                                                ->select(
                                                                                                    'teammembers.team_member',
                                                                                                    'teammembers.id',
                                                                                                )
                                                                                                ->get();
                                                                                            // dd($partner);
                                                                                            $assignmentlist = DB::table(
                                                                                                'assignments',
                                                                                            )
                                                                                                ->select(
                                                                                                    'assignments.assignment_name',
                                                                                                    'assignments.id',
                                                                                                )
                                                                                                ->get();
                                                                                        @endphp
                                                                                        <br>

                                                                                        <div class="row row-sm">
                                                                                            {{-- <label for="name" class="col-sm-3 col-form-label font-weight-600">Name :</label> --}}
                                                                                            <div class="col-sm-6">
                                                                                                <label
                                                                                                    for="">Select
                                                                                                    Client</label>
                                                                                                <select
                                                                                                    class="form-control"
                                                                                                    name="client_id"
                                                                                                    id="client_id">
                                                                                                    <option
                                                                                                        value="">
                                                                                                        Select
                                                                                                        Client</option>
                                                                                                    @foreach ($clientlist as $city)
                                                                                                        <option
                                                                                                            value="{{ $city->id }}">
                                                                                                            {{ $city->client_name }}
                                                                                                        </option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>
                                                                                            {{-- <label for="name" class="col-sm-3 col-form-label font-weight-600">Name :</label> --}}
                                                                                            <div class="col-sm-6">
                                                                                                <label
                                                                                                    for="">Select
                                                                                                    Assignment</label>
                                                                                                <select
                                                                                                    class="form-control"
                                                                                                    name="assignment_id"
                                                                                                    id="assignment_id">
                                                                                                    <option
                                                                                                        value="">
                                                                                                        Select
                                                                                                        Assignment
                                                                                                    </option>
                                                                                                    @foreach ($assignmentlist as $assignmentlistData)
                                                                                                        <option
                                                                                                            value="{{ $assignmentlistData->id }}">
                                                                                                            {{ $assignmentlistData->assignment_name }}
                                                                                                        </option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>

                                                                                        <br>

                                                                                        <div class="row row-sm">
                                                                                            {{-- <label for="name" class="col-sm-3 col-form-label font-weight-600">Name :</label> --}}
                                                                                            <div class="col-sm-6">
                                                                                                <label
                                                                                                    for="">Select
                                                                                                    Partner</label>
                                                                                                <select
                                                                                                    class="form-control"
                                                                                                    name="partner"
                                                                                                    id="partner">
                                                                                                    <option
                                                                                                        value="">
                                                                                                        Select
                                                                                                        Partner</option>
                                                                                                    @foreach ($partner as $partnerData)
                                                                                                        <option
                                                                                                            value="{{ $partnerData->id }}">
                                                                                                            {{ $partnerData->team_member }}
                                                                                                        </option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>
                                                                                            <div class="col-sm-6">
                                                                                                <label
                                                                                                    for="">Employee
                                                                                                    Name</label>
                                                                                                <input required
                                                                                                    type="text"
                                                                                                    name="workitem"
                                                                                                    id="workitem"
                                                                                                    class="form-control"
                                                                                                    placeholder="Enter Employee Name">
                                                                                            </div>
                                                                                        </div>
                                                                                        <br>
                                                                                        <div class="row row-sm">
                                                                                            <div class="col-sm-6">
                                                                                                <label
                                                                                                    for="">Location</label>
                                                                                                <input required
                                                                                                    type="text"
                                                                                                    name="location"
                                                                                                    id="location"
                                                                                                    class="form-control"
                                                                                                    placeholder="Enter Location">
                                                                                            </div>
                                                                                            <div class="col-sm-6">
                                                                                                <label
                                                                                                    for="">Work
                                                                                                    Item</label>
                                                                                                <input required
                                                                                                    type="text"
                                                                                                    name="totalhour"
                                                                                                    id="totalhour"
                                                                                                    class="form-control"
                                                                                                    placeholder="Enter Name">
                                                                                            </div>
                                                                                        </div>
                                                                                        <br>
                                                                                        <div class="row row-sm">
                                                                                            <div class="col-sm-6">
                                                                                                <label
                                                                                                    for="">Total
                                                                                                    Hour</label>
                                                                                                <input required
                                                                                                    type="text"
                                                                                                    name="location"
                                                                                                    id="location"
                                                                                                    class="form-control"
                                                                                                    placeholder="Enter Location">
                                                                                            </div>
                                                                                        </div>
                                                                                        <br>

                                                                                        <div class="modal-footer">
                                                                                            <button type="button"
                                                                                                class="btn btn-danger"
                                                                                                data-dismiss="modal">Close</button>
                                                                                            <button type="submit"
                                                                                                class="btn btn-success">Submit</button>
                                                                                        </div>
                                                                                </form>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach

                                                                @foreach ($timesheetData as $timesheetDatas)
                                                                    <tr>
                                                                        <td style="display: none;">
                                                                            {{ $timesheetDatas->id }}
                                                                        </td>
                                                                        <td> {{ $timesheetDatas->team_member ?? '' }}
                                                                        </td>
                                                                        {{-- <td>{{ $timesheetDatas->teamnewstaffcode ?? ($timesheetDatas->staffcode ?? '') }}
                                          </td> --}}
                                                                        <td>{{ $timesheetDatas->final_staffcode }}
                                                                        </td>
                                                                        <td class="textfixed"> <span
                                                                                style="display: none;">
                                                                                {{ date('Y-m-d', strtotime($timesheetDatas->date)) }}</span>{{ date('d-m-Y', strtotime($timesheetDatas->date)) }}
                                                                        </td>
                                                                        <td class="textfixed">
                                                                            @if ($timesheetDatas->date != null)
                                                                                {{ date('l', strtotime($timesheetDatas->date)) }}
                                                                            @endif
                                                                        </td>
                                                                        <td class="textfixed">
                                                                            {{ $timesheetDatas->client_name ?? '' }}
                                                                        </td>
                                                                        <td>{{ $timesheetDatas->client_code ?? '' }}
                                                                        </td>
                                                                        <td class="textfixed">
                                                                            {{ $timesheetDatas->assignment_name ?? '' }}
                                                                            @if ($timesheetDatas->assignmentname != null)
                                                                                ({{ $timesheetDatas->assignmentname ?? '' }})
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            {{ $timesheetDatas->assignmentgenerate_id ?? '' }}
                                                                        </td>
                                                                        <td class="textfixed">
                                                                            {{ $timesheetDatas->workitem ?? '' }}
                                                                        </td>
                                                                        <td class="textfixed">
                                                                            {{ $timesheetDatas->location ?? '' }}
                                                                        </td>
                                                                        <td class="textfixed">
                                                                            {{ $timesheetDatas->patnername ?? '' }}
                                                                        </td>
                                                                        <td>{{ $timesheetDatas->ptnrstaffcode ?? ($timesheetDatas->patnerstaffcodee ?? '') }}
                                                                        </td>
                                                                        <td>{{ $timesheetDatas->hour ?? '' }}</td>
                                                                    </tr>
                                                                @endforeach

                                                                @foreach ($timesheetData as $timesheetDatas)
                                                                    <tr>
                                                                        @php
                                                                            $targetAssignments = [29, 34, 32, 33, 134];
                                                                            if (
                                                                                in_array(
                                                                                    $timesheetDatas->client_id,
                                                                                    $targetAssignments,
                                                                                )
                                                                            ) {
                                                                                $permotioncheck = DB::table(
                                                                                    'teamrolehistory',
                                                                                )
                                                                                    ->where(
                                                                                        'teammember_id',
                                                                                        $timesheetDatas->createdby,
                                                                                    )
                                                                                    ->first();

                                                                                $datadate = $timesheetDatas->date
                                                                                    ? Carbon\Carbon::createFromFormat(
                                                                                        'Y-m-d',
                                                                                        $timesheetDatas->date,
                                                                                    )->startOfDay()
                                                                                    : null;

                                                                                $permotiondate = null;
                                                                                if ($permotioncheck) {
                                                                                    $permotiondate = Carbon\Carbon::createFromFormat(
                                                                                        'Y-m-d H:i:s',
                                                                                        $permotioncheck->created_at,
                                                                                    )->startOfDay();
                                                                                }

                                                                                //   dd($permotiondate);
                                                                            }
                                                                        @endphp
                                                                        <td style="display: none;">
                                                                            {{ $timesheetDatas->id }}
                                                                        </td>
                                                                        <td> {{ $timesheetDatas->team_member ?? '' }}
                                                                        </td>
                                                                        @if (in_array($timesheetDatas->client_id, $targetAssignments))
                                                                            @if ($permotioncheck && $datadate && $datadate->greaterThanOrEqualTo($permotiondate))
                                                                                <td>{{ $permotioncheck->newstaff_code }}
                                                                                </td>
                                                                            @else
                                                                                <td>{{ $timesheetDatas->staffcode }}
                                                                                </td>
                                                                            @endif
                                                                        @else
                                                                            <td>{{ $timesheetDatas->teamnewstaffcode ?? ($timesheetDatas->staffcode ?? '') }}
                                                                            </td>
                                                                        @endif
                                                                        <td class="textfixed"> <span
                                                                                style="display: none;">
                                                                                {{ date('Y-m-d', strtotime($timesheetDatas->date)) }}</span>{{ date('d-m-Y', strtotime($timesheetDatas->date)) }}
                                                                        </td>
                                                                        <td class="textfixed">
                                                                            @if ($timesheetDatas->date != null)
                                                                                {{ date('l', strtotime($timesheetDatas->date)) }}
                                                                            @endif
                                                                        </td>
                                                                        <td class="textfixed">
                                                                            {{ $timesheetDatas->client_name ?? '' }}
                                                                        </td>
                                                                        <td>{{ $timesheetDatas->client_code ?? '' }}
                                                                        </td>
                                                                        <td class="textfixed">
                                                                            {{ $timesheetDatas->assignment_name ?? '' }}
                                                                            @if ($timesheetDatas->assignmentname != null)
                                                                                ({{ $timesheetDatas->assignmentname ?? '' }})
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            {{ $timesheetDatas->assignmentgenerate_id ?? '' }}
                                                                        </td>
                                                                        <td class="textfixed">
                                                                            {{ $timesheetDatas->workitem ?? '' }}
                                                                        </td>
                                                                        <td class="textfixed">
                                                                            {{ $timesheetDatas->location ?? '' }}
                                                                        </td>
                                                                        <td class="textfixed">
                                                                            {{ $timesheetDatas->patnername ?? '' }}
                                                                        </td>
                                                                        <td>{{ $timesheetDatas->ptnrstaffcode ?? ($timesheetDatas->patnerstaffcodee ?? '') }}
                                                                        </td>
                                                                        <td>{{ $timesheetDatas->hour ?? '' }}</td>
                                                                    </tr>
                                                                @endforeach



                                                                @foreach ($timesheetData as $timesheetDatas)
                                                                    <tr>
                                                                        @php
                                                                            $targetAssignments = [29, 34, 32, 33, 134];
                                                                            if (
                                                                                in_array(
                                                                                    $timesheetDatas->client_id,
                                                                                    $targetAssignments,
                                                                                )
                                                                            ) {
                                                                                $permotioncheck = DB::table(
                                                                                    'teamrolehistory',
                                                                                )
                                                                                    ->where(
                                                                                        'teammember_id',
                                                                                        $timesheetDatas->createdby,
                                                                                    )
                                                                                    ->first();

                                                                                $datadate = $timesheetDatas->date
                                                                                    ? Carbon\Carbon::createFromFormat(
                                                                                        'Y-m-d',
                                                                                        $timesheetDatas->date,
                                                                                    )->startOfDay()
                                                                                    : null;

                                                                                $permotiondate = null;
                                                                                if ($permotioncheck) {
                                                                                    $permotiondate = Carbon\Carbon::createFromFormat(
                                                                                        'Y-m-d H:i:s',
                                                                                        $permotioncheck->created_at,
                                                                                    )->startOfDay();
                                                                                }

                                                                                dd($permotiondate);
                                                                            }
                                                                        @endphp
                                                                        <td style="display: none;">
                                                                            {{ $timesheetDatas->id }}
                                                                        </td>
                                                                        <td> {{ $timesheetDatas->team_member ?? '' }}
                                                                        </td>
                                                                        @if (in_array($timesheetDatas->client_id, $targetAssignments))
                                                                            @if ($permotioncheck && $datadate && $datadate->greaterThanOrEqualTo($permotiondate))
                                                                                <td>{{ $permotioncheck->newstaff_code }}
                                                                                </td>
                                                                            @else
                                                                                <td>{{ $timesheetDatas->staffcode }}
                                                                                </td>
                                                                            @endif
                                                                        @else
                                                                            <td>{{ $timesheetDatas->teamnewstaffcode ?? ($timesheetDatas->staffcode ?? '') }}
                                                                            </td>
                                                                        @endif
                                                                        <td class="textfixed"> <span
                                                                                style="display: none;">
                                                                                {{ date('Y-m-d', strtotime($timesheetDatas->date)) }}</span>{{ date('d-m-Y', strtotime($timesheetDatas->date)) }}
                                                                        </td>
                                                                        <td class="textfixed">
                                                                            @if ($timesheetDatas->date != null)
                                                                                {{ date('l', strtotime($timesheetDatas->date)) }}
                                                                            @endif
                                                                        </td>
                                                                        <td class="textfixed">
                                                                            {{ $timesheetDatas->client_name ?? '' }}
                                                                        </td>
                                                                        <td>{{ $timesheetDatas->client_code ?? '' }}
                                                                        </td>
                                                                        <td class="textfixed">
                                                                            {{ $timesheetDatas->assignment_name ?? '' }}
                                                                            @if ($timesheetDatas->assignmentname != null)
                                                                                ({{ $timesheetDatas->assignmentname ?? '' }})
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            {{ $timesheetDatas->assignmentgenerate_id ?? '' }}
                                                                        </td>
                                                                        <td class="textfixed">
                                                                            {{ $timesheetDatas->workitem ?? '' }}
                                                                        </td>
                                                                        <td class="textfixed">
                                                                            {{ $timesheetDatas->location ?? '' }}
                                                                        </td>
                                                                        <td class="textfixed">
                                                                            {{ $timesheetDatas->patnername ?? '' }}
                                                                        </td>
                                                                        <td>{{ $timesheetDatas->ptnrstaffcode ?? ($timesheetDatas->patnerstaffcodee ?? '') }}
                                                                        </td>
                                                                        <td>{{ $timesheetDatas->hour ?? '' }}</td>
                                                                    </tr>
                                                                @endforeach










                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="selected_items[]"
                                                                        style="border: 1px #00000080 solid;">
                                                                </div>



                                                                <div class="tab-content" id="pills-tabContent">
                                                                    @foreach ($tabs as $tabId => $roleKey)
                                                                        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                                                            id="{{ $tabId }}"
                                                                            role="tabpanel"
                                                                            aria-labelledby="{{ $tabId }}-tab">

                                                                            <!-- Added header section to match the image -->
                                                                            @if (count($designationData[$roleKey]['teammemberall']) > 0)
                                                                                <div
                                                                                    class="d-flex justify-content-between align-items-center mb-3">
                                                                                    <h5 class="mb-0">Team KRA List
                                                                                    </h5>
                                                                                    <span
                                                                                        class="badge bg-secondary">{{ count($designationData[$roleKey]['teammemberall']) }}
                                                                                        members</span>
                                                                                </div>
                                                                            @endif

            </body>

</html>
