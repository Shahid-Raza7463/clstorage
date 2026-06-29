@extends('app')

@section('title', 'IAC Engagement')
@section('page-title', 'IAC Engagement')
@section('breadcrumb', 'IAC Engagement')
@section('breadcrumb-button')
    <div class="dropdown d-flex align-items-center">
        <button
            class="btn btn-white btn-sm d-print-none shadow-sm border d-inline-flex align-items-center gap-1 px-3 py-1 fw-medium dropdown-toggle"
            type="button" data-bs-toggle="dropdown" data-bs-strategy="fixed" aria-expanded="false"
            style="background: white !important; color: #334155; border-color: #e2e8f0 !important;">
            <i class="ri-download-2-line" style="font-size: 16px;"></i>
            <span class="d-none d-md-inline">Export Report</span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow border-0"
            style="border-radius: 12px; padding: 0.5rem; min-width: 160px;">
            <li>
                <a class="dropdown-item py-2 px-3 modern-dropdown-item" href="javascript:void(0);" onclick="printPage()">
                    <i class="ri-file-pdf-line me-2"></i> PDF
                </a>
            </li>
            <li>
                <a class="dropdown-item py-2 px-3 modern-dropdown-item" href="javascript:void(0);"
                    onclick="exportAllAsExcel('excel')">
                    <i class="ri-file-excel-line me-2"></i> Excel
                </a>
            </li>
        </ul>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

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

        .status-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .status-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            border-color: #cbd5e1;
        }

        .status-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.25rem;
        }

        .status-indicator {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .status-label {
            font-weight: 700;
            color: #1e293b;
            font-size: 1.1rem;
        }

        .status-count {
            font-size: 1.5rem;
            font-weight: 800;
            color: #1e293b;
            line-height: 1;
        }

        .status-progress-row {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .status-progress-bar-bg {
            height: 8px;
            background: #f1f5f9;
            border-radius: 4px;
            overflow: hidden;
            flex: 1;
        }

        .status-progress-bar-fill {
            height: 100%;
            border-radius: 4px;
            transition: width 0.8s ease;
        }

        .status-percentage {
            font-size: 0.875rem;
            font-weight: 600;
            color: #64748b;
            min-width: 50px;
            text-align: right;
        }

        .status-footer {
            margin-top: 0.5rem;
        }

        .view-details-link {
            color: #64748b;
            font-size: 0.95rem;
            font-weight: 400;
        }

        .modern-summary-wrapper {
            background: #ffffff;
            border: 1px solid #f1f5f9;
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        }

        .modern-detail-card {
            background: #ffffff;
            border: 1px solid #f1f5f9;
            border-radius: 12px;
            padding: 1.25rem;
            margin-bottom: 1rem;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
            position: relative;
            cursor: pointer;
        }

        .modern-detail-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
            border-color: #e2e8f0;
        }

        .modern-detail-card:hover .detail-title {
            color: #2563eb;
            text-decoration: underline;
        }

        .modern-detail-card .detail-title {
            font-weight: 700;
            color: #2563eb;
            font-size: 1.05rem;
            margin-bottom: 0.85rem;
            display: block;
            line-height: 1.4;
        }

        .modern-detail-card .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
        }

        .modern-detail-card .detail-label {
            color: #64748b;
            font-weight: 500;
        }

        .modern-detail-card .detail-value {
            color: #334155;
            font-weight: 600;
            text-align: end;
            margin-inline-start: 0.5rem;
        }

        .back-btn {
            background: none;
            border: none;
            color: #64748b;
            padding: 0;
            font-size: 0.875rem;
            margin-bottom: 1rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
        }

        .back-btn:hover {
            color: #1e293b;
        }

        .fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateX(10px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
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

    <style>
        @media print {
            @page {
                size: landscape;
                margin: 1cm;
            }

            body,
            html {
                height: auto !important;
                overflow: visible !important;
                background: #fff !important;
                width: 100% !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            /* Hide unnecessary elements */
            header,
            .app-menu,
            .footer,
            .d-print-none,
            .no-print {
                display: none !important;
            }

            /* Full width layout */
            #layout-wrapper,
            .main-content,
            .page-content,
            .container-fluid {
                width: 100% !important;
                padding: 0 !important;
                margin: 0 !important;
                overflow: visible !important;
            }

            /* KPI Cards — fix karo full width */
            .row {
                display: flex !important;
                flex-wrap: wrap !important;
                width: 100% !important;
            }

            .col-12,
            .col-md-3,
            .col-lg-3,
            .col-md-4,
            .col-lg-4,
            .col-md-6,
            .col-lg-6,
            .col-lg-5,
            .col-lg-7 {
                width: 100% !important;
                max-width: 100% !important;
                flex: 0 0 100% !important;
                page-break-inside: avoid !important;
            }

            /* Cards */
            .card,
            .dashboard-table-container {
                break-inside: avoid !important;
                page-break-inside: avoid !important;
                border: 1px solid #e2e8f0 !important;
                box-shadow: none !important;
                margin-bottom: 16px !important;
                width: 100% !important;
                overflow: visible !important;
            }

            /* KPI count cards — poore aayenge */
            .atrdashboard-modern .card {
                display: block !important;
                visibility: visible !important;
            }

            /* Tables fix — last column nahi kategi */
            .task-table-scroll {
                max-height: none !important;
                overflow: visible !important;
            }

            table {
                width: 100% !important;
                table-layout: fixed !important;
                border-collapse: collapse !important;
                page-break-inside: avoid !important;
            }

            table th,
            table td {
                font-size: 9px !important;
                padding: 6px 8px !important;
                word-break: break-word !important;
                white-space: normal !important;
                overflow: visible !important;
            }

            thead {
                display: table-header-group !important;
            }

            tr {
                page-break-inside: avoid !important;
            }

            /* Charts hide karo print mein (optional) */
            /* #taskDistributionChart,
            #tasksByMonthChart {
                display: none !important;
            } */

            /* Offcanvas/Modal hide */
            .offcanvas,
            .modal {
                display: none !important;
            }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('admin/assets/css/dashboard-option.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/task-tracker.css') }}">
@endsection

@section('content')
    <div class="d-print-none">@include('iacdashboard.iac-dashboard-filters', ['filters' => $filters])</div>
    @include('iacdashboard.iacdashboardcount', ['counts' => $counts])

    <div class="atrdashboard-modern mt-3">
        <div class="row">
            <div class="col-12 col-lg-5 mb-4">
                <div class="card h-100" id="taskDistributionCard">
                    <div class="card-header d-flex justify-content-between align-items-center"
                        style="background: white; border-radius: 15px 15px 0 0; padding: 1rem 1.25rem;">
                        <div>
                            <b class="text-capitalize" style="color: #475569; font-weight: 600; font-size: 0.875rem;">Task
                                Distribution by Status</b>
                        </div>
                        <div class="d-print-none" style="display: flex; gap: 6px; align-items: center;">
                            <button class="icon-btn"
                                onclick="openChartSummaryView(['open', 'recommended for closure', 'completed'], 'Task Distribution Details')"
                                title="View Full Details" style="background: transparent; border: none;">
                                <i class="ri-external-link-line" style="font-size: 1.1rem; color: #64748b;"></i>
                            </button>
                            <div class="dropdown">
                                <button class="icon-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false"
                                    title="More Options" style="background: transparent; border: none;">
                                    <i class="ri-menu-2-line" style="font-size: 1.1rem; color: #64748b;"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end shadow border-0"
                                    style="border-radius: 12px; padding: 0.5rem;">
                                    <a class="dropdown-item py-2 px-3 modern-dropdown-item" href="javascript:void(0);"
                                        onclick="exportAllAsExcel('csv')">
                                        <i class="ri-file-list-2-line me-2"></i> Download CSV
                                    </a>
                                    <a class="dropdown-item py-2 px-3 modern-dropdown-item" href="javascript:void(0);"
                                        onclick="downloadCardAsPng('taskDistributionCard', 'task_distribution.png')">
                                        <i class="ri-image-line me-2"></i> Download PNG
                                    </a>
                                    <a class="dropdown-item py-2 px-3 modern-dropdown-item" href="javascript:void(0);"
                                        onclick="downloadCardAsSvg('taskDistributionCard', 'task_distribution.svg')">
                                        <i class="ri-code-box-line me-2"></i> Download SVG
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div id="taskDistributionChart" style="min-height: 320px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-7 mb-4">
                <div class="card h-100" id="tasksByMonthCard">
                    <div class="card-header d-flex justify-content-between align-items-center"
                        style="background: white; border-radius: 15px 15px 0 0; padding: 1rem 1.25rem;">
                        <div>
                            <b class="text-capitalize" style="color: #475569; font-weight: 600; font-size: 0.875rem;">Tasks
                                by Month</b>
                        </div>
                        <div class="d-print-none" style="display: flex; gap: 6px; align-items: center;">
                            <button class="icon-btn" onclick="openTasksByMonthSummaryView()" title="View Full Details"
                                style="background: transparent; border: none;">
                                <i class="ri-external-link-line" style="font-size: 1.1rem; color: #64748b;"></i>
                            </button>
                            <div class="dropdown">
                                <button class="icon-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false"
                                    title="More Options" style="background: transparent; border: none;">
                                    <i class="ri-menu-2-line" style="font-size: 1.1rem; color: #64748b;"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end shadow border-0"
                                    style="border-radius: 12px; padding: 0.5rem;">
                                    <a class="dropdown-item py-2 px-3 modern-dropdown-item" href="javascript:void(0);"
                                        onclick="exportAllAsExcel('csv')">
                                        <i class="ri-file-list-2-line me-2"></i> Download CSV
                                    </a>
                                    <a class="dropdown-item py-2 px-3 modern-dropdown-item" href="javascript:void(0);"
                                        onclick="downloadCardAsPng('tasksByMonthCard', 'tasks_by_month.png')">
                                        <i class="ri-image-line me-2"></i> Download PNG
                                    </a>
                                    <a class="dropdown-item py-2 px-3 modern-dropdown-item" href="javascript:void(0);"
                                        onclick="downloadCardAsSvg('tasksByMonthCard', 'tasks_by_month.svg')">
                                        <i class="ri-code-box-line me-2"></i> Download SVG
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div id="tasksByMonthChart" style="min-height: 320px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Overdue Tasks Table -->
    <div class="dashboard-table-container">
        <div class="dashboard-table-header">
            <div class="dashboard-table-title">Overdue Tasks ({{ collect($overdueTasks ?? [])->count() }})</div><a
                href="{{ route('admin.task-tracker.index', ['type' => 'iac']) }}" class="view-all-link">View all <i
                    class="ri-arrow-right-up-line"></i></a>
        </div>
        <div class="table-responsive task-table-scroll">
            <table class="modern-dashboard-table" id="overdueTasksTable">
                <thead>
                    <tr>
                        <th>Task / Meeting</th>
                        <th>Assignee</th>
                        <th>Closure Date</th>
                        <th>Days Overdue</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($overdueTasks ?? [] as $task)
                        <tr data-meeting="{{ $task->meeting_title ?? '-' }}" data-status="Overdue"
                            data-status-key="{{ strtolower((string) ($task->status ?? '')) }}"
                            data-heading="{{ $task->description ?? '-' }}"
                            data-owner="{{ $task->assignee_name ?? 'Unassigned' }}"
                            data-created-by="{{ $task->creator_name ?? 'Unassigned' }}"
                            data-reviewer="{{ $task->reviewer_name ?? 'Unassigned' }}"
                            data-meeting-date="{{ !empty($task->meeting_date) ? \Carbon\Carbon::parse($task->meeting_date)->format('d F Y') : '-' }}"
                            data-due="{{ !empty($task->closure_date) ? \Carbon\Carbon::parse($task->closure_date)->format('d F Y') : '-' }}"
                            data-updates='@json($taskUpdatesByTaskId[$task->id] ?? [])'>
                            <td class="fw-bold">
                                <span class="clickabletext" onclick="openTaskFromTableRow(this.closest('tr'))">
                                    {{ $task->meeting_title ?? '-' }}
                                </span>
                            </td>
                            <td>{{ $task->assignee_name ?? 'Unassigned' }}</td>
                            <td>{{ !empty($task->closure_date) ? \Carbon\Carbon::parse($task->closure_date)->format('d F Y') : '-' }}
                            </td>
                            <td><span class="text-danger-bold">{{ (int) ($task->days_overdue ?? 0) }} days</span></td>
                            <td>
                                <div class="status-badge status-overdue">
                                    <div class="status-dot"></div>Overdue
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">No overdue tasks found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Open Tasks Table -->
    <div class="dashboard-table-container">
        <div class="dashboard-table-header">
            <div class="dashboard-table-title">Open Tasks ({{ collect($openTasks ?? [])->count() }})</div><a
                href="{{ route('admin.task-tracker.index', ['type' => 'iac']) }}" class="view-all-link">View all <i
                    class="ri-arrow-right-up-line"></i></a>
        </div>
        <div class="table-responsive task-table-scroll">
            <table class="modern-dashboard-table" id="openTasksTable">
                <thead>
                    <tr>
                        <th>Meeting</th>
                        <th>Description</th>
                        <th>Assignee</th>
                        <th>Closure Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($openTasks ?? [] as $task)
                        <tr data-meeting="{{ $task->meeting_title ?? '-' }}" data-status="Open"
                            data-status-key="{{ strtolower((string) ($task->status ?? '')) }}"
                            data-heading="{{ $task->description ?? '-' }}"
                            data-owner="{{ $task->assignee_name ?? 'Unassigned' }}"
                            data-created-by="{{ $task->creator_name ?? 'Unassigned' }}"
                            data-reviewer="{{ $task->reviewer_name ?? 'Unassigned' }}"
                            data-meeting-date="{{ !empty($task->meeting_date) ? \Carbon\Carbon::parse($task->meeting_date)->format('d F Y') : '-' }}"
                            data-due="{{ !empty($task->closure_date) ? \Carbon\Carbon::parse($task->closure_date)->format('d F Y') : '-' }}"
                            data-updates='@json($taskUpdatesByTaskId[$task->id] ?? [])'>
                            <td class="fw-bold">
                                <span class="clickabletext" onclick="openTaskFromTableRow(this.closest('tr'))">
                                    {{ $task->meeting_title ?? '-' }}
                                </span>
                            </td>
                            <td>
                                <div class="text-description-truncate">
                                    {{ \Illuminate\Support\Str::of(strip_tags((string) ($task->description ?? '-')))->squish() }}
                                </div>
                            </td>
                            <td>{{ $task->assignee_name ?? 'Unassigned' }}</td>
                            <td>{{ !empty($task->closure_date) ? \Carbon\Carbon::parse($task->closure_date)->format('d F Y') : '-' }}
                            </td>
                            <td>
                                <div class="status-badge status-open">
                                    <div class="status-dot"></div>Open
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">No open tasks found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Hidden tables for CSV export --}}
    <table class="d-none" id="taskDistributionExportTable">
        <thead>
            <tr>
                <th>Status</th>
                <th>Count</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($taskDistribution['labels'] ?? [] as $index => $label)
                <tr>
                    <td>{{ $label }}</td>
                    <td>{{ $taskDistribution['series'][$index] ?? 0 }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="d-none" id="tasksByMonthExportTable">
        <thead>
            <tr>
                <th>Month</th>
                <th>IAC</th>
                <th>ACB</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasksByMonth['categories'] ?? [] as $index => $month)
                <tr>
                    <td>{{ $month }}</td>
                    <td>{{ $tasksByMonth['iacSeries'][$index] ?? 0 }}</td>
                    <td>{{ $tasksByMonth['acbSeries'][$index] ?? 0 }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Sidebar & Modal HTML (Complete) -->
    <div class="offcanvas offcanvas-end modern-side-panel" tabindex="-1" id="iacDetailCanvas">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="iacDetailCanvasLabel"></h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <div id="iacSummaryView" class="fade-in"></div>
            <div id="iacDetailsView" class="fade-in" style="display: none;">
                <button class="back-btn" id="iacDetailsBackBtn" onclick="hideIacDetails()">
                    <i class="ri-arrow-left-line"></i> Back to Summary
                </button>
                <div id="iacDetailsProgress" class="mb-3"></div>
                <h6 class="mb-3 text-muted fw-bold small" style="letter-spacing: 0.05em;">Detailed List</h6>
                <div id="iacDetailContent"></div>
                <div id="iacDetailCanvasSubtitle" class="mt-2 text-muted small fw-semibold"></div>
            </div>
        </div>
    </div>
    <!-- Sidebar & Modal HTML (Complete) -->
    <div class="modal fade task-detail-modal" id="taskDetailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable tt-show-modal">
            <div class="modal-content overflow-hidden border-0" style="border-radius:16px;">
                {{-- ===== HEADER ===== --}}
                <div class="modal-header border-bottom align-items-center bg-white px-4 py-3"
                    style="display: flex; justify-content: space-between; gap: 1rem;">
                    <div class="d-flex align-items-center gap-2 flex-wrap" style="flex: 1;">
                        {{-- <span class="badge bg-light text-dark fw-bold border flex-shrink-0" style="font-size:12px; letter-spacing:.02em; white-space: nowrap;" id="modalTaskId">
            IAC Task
        </span> --}}
                        <span class="tt-show-status-badge flex-shrink-0" id="modalStatusBadgeNew"
                            style="background:#f8fafc; color:#475569; border:1.5px solid #cbd5e1; white-space: nowrap;">
                            <i class="ri-information-line me-1" id="modalStatusIconNew"></i><span
                                id="modalStatusTextNew">Open</span>
                        </span>
                        {{-- <span class="text-muted flex-shrink-0" style="font-size:12px; white-space: nowrap;" id="modalTaskMeta">
            IAC Task
        </span> --}}
                    </div>
                    <button type="button" class="btn-close shadow-none flex-shrink-0" data-bs-dismiss="modal"
                        aria-label="Close" style="margin: 0;"></button>
                </div>

                {{-- ===== BODY ===== --}}
                <div class="modal-body bg-light overflow-auto p-0" style="max-height: calc(100vh - 130px);">
                    {{-- Task title + meta --}}
                    <div class="border-bottom bg-white px-4 pb-3 pt-3">
                        <h5 class="fw-bold text-dark lh-sm mb-2" style="font-size:16px;" id="modalMeetingName"></h5>

                        {{-- Meta grid --}}
                        <div class="tt-show-meta-grid mb-0">
                            <div class="tt-show-meta-cell">
                                <div class="tt-show-meta-label"><i class="ri-user-settings-line me-1"></i>Created By</div>
                                <div class="tt-show-meta-value d-flex align-items-center gap-2" id="modalCreatedBy">--
                                </div>
                            </div>
                            <div class="tt-show-meta-cell">
                                <div class="tt-show-meta-label"><i class="ri-user-line me-1"></i>Assignee</div>
                                <div class="tt-show-meta-value d-flex align-items-center gap-2" id="modalAssignee">--
                                </div>
                            </div>
                            <div class="tt-show-meta-cell">
                                <div class="tt-show-meta-label"><i class="ri-user-star-line me-1"></i>Reviewer</div>
                                <div class="tt-show-meta-value d-flex align-items-center gap-2" id="modalReviewer">--
                                </div>
                            </div>
                            <div class="tt-show-meta-cell">
                                <div class="tt-show-meta-label"><i class="ri-calendar-event-line me-1"></i>IAC Date</div>
                                <div class="tt-show-meta-value" id="modalMeetingDate">--</div>
                            </div>
                            <div class="tt-show-meta-cell">
                                <div class="tt-show-meta-label"><i class="ri-calendar-check-line me-1"></i>Closure Date
                                </div>
                                <div class="tt-show-meta-value" id="modalClosureDate">--</div>
                            </div>
                        </div>
                    </div>

                    {{-- Workflow stepper --}}
                    <div class="border-bottom bg-white px-4 py-2">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="tt-show-section-label mb-0">Workflow Progress</div>
                            <span class="text-muted" style="font-size:10px;" id="modalWorkflowProgressText">Step -- /
                                --</span>
                        </div>
                        <div class="tt-show-stepper-shell">
                            <div class="tt-show-stepper" style="--step-count: 3;" id="modalWorkflowStepperNew">
                                <!-- JS injected steps -->
                            </div>
                        </div>
                    </div>

                    {{-- Description --}}
                    <div class="border-bottom bg-white px-4 py-3">
                        <div class="tt-show-section-label mb-2">Task Description</div>
                        <div class="tt-show-description" id="modalDescription"></div>
                    </div>

                    {{-- Responses --}}
                    <div class="bg-white px-4 py-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="tt-show-section-label mb-0" id="modalUpdatesLabel">Updates & Responses</div>
                        </div>
                        <div class="mt-3" id="modalResponsesContainer">
                            <!-- JS injected responses -->
                        </div>
                    </div>
                </div>
            </div>
        </div>


    @endsection

    @section('javascripts')
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script>
            const iacTaskDistribution = @json($taskDistribution ?? ['labels' => [], 'series' => [], 'tasksByLabel' => []]);
            const iacTasksByMonth = @json($tasksByMonth ?? ['categories' => [], 'iacSeries' => [], 'acbSeries' => []]);
            const iacKpiSidebar = @json($kpiSidebarTasks ?? []);
            const iacStatusMeta = {
                open: {
                    label: 'Open',
                    color: '#EF9F27'
                },
                'recommended for closure': {
                    label: 'Recommended for Closure',
                    color: '#7F77DD'
                },
                completed: {
                    label: 'Completed',
                    color: '#639922'
                },
                overdue: {
                    label: 'Overdue',
                    color: '#E24B4A'
                },
            };
            let currentSidebarTasks = [];
            let currentSummaryKeys = ['open', 'recommended for closure', 'completed', 'overdue'];
            let currentSummaryMode = 'status';
            let currentCanvasLabel = 'Task Status Details';

            document.addEventListener('DOMContentLoaded', function() {
                const distributionSeries = Array.isArray(iacTaskDistribution.series) ? iacTaskDistribution.series : [];
                const hasDistributionData = distributionSeries.some((value) => Number(value) > 0);

                new ApexCharts(document.querySelector("#taskDistributionChart"), {
                    series: hasDistributionData ? distributionSeries : [],
                    chart: {
                        type: 'donut',
                        height: 340,
                        events: {
                            dataPointSelection: (e, c, cfg) => openIacSidebar(cfg.w.config.labels[cfg
                                .dataPointIndex])
                        }
                    },
                    labels: hasDistributionData ? (iacTaskDistribution.labels || []) : [],
                    noData: {
                        text: 'No Data Available',
                        align: 'center',
                        verticalAlign: 'middle',
                        style: {
                            color: '#64748b',
                            fontSize: '14px',
                            fontFamily: 'inherit'
                        }
                    },
                    // Order: Open, Recommended for Closure, Completed
                    colors: ['#EF9F27', '#7F77DD', '#639922'],
                    plotOptions: {
                        pie: {
                            donut: {
                                size: '65%'
                            }
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    legend: {
                        position: 'bottom',
                        labels: {
                            useSeriesColors: true
                        }
                    },
                    tooltip: {
                        theme: 'dark',
                        fillSeriesColor: true
                    }
                }).render();

                const iacSeries = Array.isArray(iacTasksByMonth.iacSeries) ? iacTasksByMonth.iacSeries : [];
                const acbSeries = Array.isArray(iacTasksByMonth.acbSeries) ? iacTasksByMonth.acbSeries : [];
                const categories = Array.isArray(iacTasksByMonth.categories) ? iacTasksByMonth.categories : [];
                const hasMonthData = [...iacSeries, ...acbSeries].some((value) => Number(value) > 0);

                new ApexCharts(document.querySelector("#tasksByMonthChart"), {
                    series: hasMonthData ? [{
                        name: 'IAC',
                        data: iacSeries
                    }, {
                        name: 'ACB',
                        data: acbSeries
                    }] : [],
                    chart: {
                        type: 'bar',
                        height: 340,
                        toolbar: {
                            show: false
                        },
                        events: {
                            dataPointSelection: (e, c, cfg) => openIacSidebarByMonth(cfg.w.config.xaxis
                                .categories[cfg
                                    .dataPointIndex], cfg.seriesIndex)
                        }
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: '85%',
                            borderRadius: 0,
                            borderRadiusApplication: 'end'
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        show: true,
                        width: 3,
                        colors: ['transparent']
                    },
                    yaxis: {
                        min: 0,
                        labels: {
                            formatter: (v) => v.toFixed(0)
                        }
                    },
                    fill: {
                        opacity: 1
                    },
                    colors: ['#3B82F6', '#10B981'],
                    grid: {
                        borderColor: '#cbd5e1',
                        strokeDashArray: 4,
                        yaxis: {
                            lines: {
                                show: true
                            }
                        },
                        xaxis: {
                            lines: {
                                show: true
                            }
                        }
                    },
                    legend: {
                        position: 'bottom',
                        inverseOrder: true,
                        markers: {
                            radius: 2,
                            width: 14,
                            height: 14
                        }
                    },
                    tooltip: {
                        shared: true,
                        intersect: false,
                        theme: 'light',
                        custom: function({
                            series,
                            dataPointIndex,
                            w
                        }) {
                            var cat = w.globals.labels[dataPointIndex];
                            var iacVal = series[0][dataPointIndex];
                            var acbVal = series[1][dataPointIndex];
                            return '<div class="p-2 shadow-sm border-0 rounded-3 bg-white" style="font-size:12px;">' +
                                '<div class="fw-bold mb-1">' + cat + '</div>' +
                                '<div style="color:#10B981;">ACB : ' + acbVal + '</div>' +
                                '<div style="color:#3B82F6;">IAC : ' + iacVal + '</div>' +
                                '</div>';
                        }
                    },
                    noData: {
                        text: 'No Data Available',
                        align: 'center',
                        verticalAlign: 'middle',
                        style: {
                            color: '#64748b',
                            fontSize: '14px',
                            fontFamily: 'inherit'
                        }
                    },
                    xaxis: {
                        categories: hasMonthData ? categories : [],
                        axisBorder: {
                            show: false
                        },
                        axisTicks: {
                            show: true
                        },
                        crosshairs: {
                            show: true,
                            width: 'category',
                            fill: {
                                type: 'solid',
                                color: '#e2e8f0',
                                opacity: 1
                            }
                        }
                    }
                }).render();

                const fileInput = document.getElementById('iac-file-input');
                fileInput.addEventListener('change', function() {
                    const preview = document.getElementById('iac-file-preview');
                    preview.innerHTML = '';
                    Array.from(this.files).forEach((file) => {
                        const pill = document.createElement('div');
                        pill.className = 'file-attachment-pill';
                        pill.innerHTML =
                            `<i class="ri-file-text-line text-primary"></i><span>${file.name}</span><i class="ri-close-line file-remove-icon" onclick="removeSelectedFile()"></i>`;
                        preview.appendChild(pill);
                    });
                });
            });

            function removeSelectedFile() {
                document.getElementById('iac-file-preview').innerHTML = '';
                document.getElementById('iac-file-input').value = '';
            }

            function submitIacResponse() {
                alert('Response submitted!');
                removeSelectedFile();
                document.querySelector('.response-textarea').value = '';
            }

            function handleTrackerClick(status) {
                const key = String(status ?? '').toLowerCase().trim();
                if (key === 'total action items') {
                    openIacSummaryView();
                    return;
                }

                const tasks = (iacKpiSidebar && iacKpiSidebar[key]) || [];
                showIacDetails(iacStatusMeta[key]?.label || 'Tasks', tasks, key);
            }

            function openIacSidebar(label) {
                const tasks = (iacTaskDistribution.tasksByLabel && iacTaskDistribution.tasksByLabel[label]) || [];
                showIacDetails(label, tasks, String(label || '').toLowerCase());
            }

            function openIacSidebarByMonth(monthLabel, seriesIndex) {
                const typeLabel = seriesIndex === 0 ? 'IAC' : 'ACB';
                const monthBucket = (iacTasksByMonth.tasksByBucket && iacTasksByMonth.tasksByBucket[monthLabel]) || {};
                const tasks = monthBucket[typeLabel] || [];
                showIacDetails(monthLabel + ' - ' + typeLabel + ' Tasks', tasks, '');
            }

            function openTasksByMonthDetail(monthLabel) {
                const bucket = (iacTasksByMonth.tasksByBucket && iacTasksByMonth.tasksByBucket[monthLabel]) || {};
                const allTasks = [...(bucket['IAC'] || []), ...(bucket['ACB'] || [])];
                showIacDetails(monthLabel + ' - IAC and ACB Tasks', allTasks, '');
            }

            function renderTasksByMonthSummaryCards() {
                let total = 0;
                if (iacTasksByMonth && iacTasksByMonth.tasksByBucket) {
                    Object.values(iacTasksByMonth.tasksByBucket).forEach(bucket => {
                        total += (bucket['IAC'] || []).length;
                        total += (bucket['ACB'] || []).length;
                    });
                }

                const cards = (iacTasksByMonth.categories || []).map(monthLabel => {
                    const bucket = (iacTasksByMonth.tasksByBucket && iacTasksByMonth.tasksByBucket[monthLabel]) || {};
                    const allTasks = [...(bucket['IAC'] || []), ...(bucket['ACB'] || [])];
                    const count = allTasks.length;
                    const percentage = total > 0 ? ((count * 100) / total).toFixed(1) : '0.0';
                    return `
                    <div class="status-card" onclick="openTasksByMonthDetail('${escapeHtml(monthLabel)}')">
                        <div class="status-card-header">
                            <div class="status-indicator">
                                <div class="status-dot" style="background-color: #3B82F6;"></div>
                                <span class="status-label">${escapeHtml(monthLabel)} - IAC and ACB Tasks</span>
                            </div>
                            <span class="status-count">${count}</span>
                        </div>
                        <div class="status-progress-row">
                            <div class="status-progress-bar-bg">
                                <div class="status-progress-bar-fill" style="width: ${percentage}%; background-color: #3B82F6;"></div>
                            </div>
                            <span class="status-percentage">${percentage}%</span>
                        </div>
                        <div class="status-footer">
                            <span class="view-details-link">Click to view details</span>
                        </div>
                    </div>
                `;
                });
                return cards.join('');
            }

            function openTasksByMonthSummaryView() {
                currentSummaryMode = 'month';
                currentCanvasLabel = 'Tasks by Month Details';
                const summaryView = document.getElementById('iacSummaryView');
                const detailsView = document.getElementById('iacDetailsView');
                document.getElementById('iacDetailCanvasLabel').innerText = currentCanvasLabel;
                summaryView.innerHTML = renderTasksByMonthSummaryCards();
                summaryView.style.display = 'block';
                detailsView.style.display = 'none';

                const target = document.getElementById('iacDetailCanvas');
                const offcanvas = bootstrap.Offcanvas.getInstance(target) || new bootstrap.Offcanvas(target);
                offcanvas.show();
            }

            function openChartSummaryView(keys, label) {
                currentSummaryMode = 'status';
                currentSummaryKeys = keys;
                currentCanvasLabel = label || 'Task Status Details';
                const summaryView = document.getElementById('iacSummaryView');
                const detailsView = document.getElementById('iacDetailsView');
                document.getElementById('iacDetailCanvasLabel').innerText = currentCanvasLabel;
                summaryView.innerHTML = renderIacSummaryCards(currentSummaryKeys);
                summaryView.style.display = 'block';
                detailsView.style.display = 'none';

                const target = document.getElementById('iacDetailCanvas');
                const offcanvas = bootstrap.Offcanvas.getInstance(target) || new bootstrap.Offcanvas(target);
                offcanvas.show();
            }

            function renderIacSummaryCards(keys = ['open', 'recommended for closure', 'completed', 'overdue']) {
                let total = 0;
                if (keys.length === 4) {
                    total = Number((iacKpiSidebar?.['total action items'] || []).length || 0);
                } else {
                    keys.forEach(key => {
                        total += Number((iacKpiSidebar?.[key] || []).length || 0);
                    });
                }
                const cards = keys.map((key) => {
                    const meta = iacStatusMeta[key];
                    const count = Number((iacKpiSidebar?.[key] || []).length || 0);
                    const percentage = total > 0 ? ((count * 100) / total).toFixed(1) : '0.0';
                    return `
                    <div class="status-card" onclick="showIacDetails('${escapeHtml(meta.label)}', iacKpiSidebar['${key}'] || [], '${key}')">
                        <div class="status-card-header">
                            <div class="status-indicator">
                                <div class="status-dot" style="background-color: ${meta.color};"></div>
                                <span class="status-label">${escapeHtml(meta.label)}</span>
                            </div>
                            <span class="status-count">${count}</span>
                        </div>
                        <div class="status-progress-row">
                            <div class="status-progress-bar-bg">
                                <div class="status-progress-bar-fill" style="width: ${percentage}%; background-color: ${meta.color};"></div>
                            </div>
                            <span class="status-percentage">${percentage}%</span>
                        </div>
                        <div class="status-footer">
                            <span class="view-details-link">Click to view details</span>
                        </div>
                    </div>
                `;
                });

                return cards.join('');
            }

            function renderIacProgressCard(title, key, count) {
                const meta = iacStatusMeta[key] || {
                    color: '#94a3b8'
                };
                const total = Number((iacKpiSidebar?.['total action items'] || []).length || 0);
                const percentage = total > 0 ? ((Number(count || 0) * 100) / total).toFixed(1) : '0.0';

                return `
                <div class="modern-summary-wrapper">
                    <div class="status-card-header">
                        <div class="status-indicator">
                            <div class="status-dot" style="background-color: ${meta.color};"></div>
                            <span class="status-label">${escapeHtml(title)}</span>
                        </div>
                        <span class="status-count">${Number(count || 0)}</span>
                    </div>
                    <div class="status-progress-row">
                        <div class="status-progress-bar-bg">
                            <div class="status-progress-bar-fill" style="width: ${percentage}%; background-color: ${meta.color};"></div>
                        </div>
                        <span class="status-percentage">${percentage}%</span>
                    </div>
                </div>
            `;
            }

            function renderIacDetailCards(tasks) {
                if (!tasks || tasks.length === 0) {
                    return `
                    <div class="d-flex align-items-center justify-content-center" style="height: 150px;">
                        <div class="text-center text-muted">
                            <i class="ri-information-line fs-1 opacity-50 mb-2"></i>
                            <p class="m-0 fw-medium">No tasks found.</p>
                        </div>
                    </div>
                `;
                }

                return tasks.map((task, index) => `
                <div class="modern-detail-card" onclick="openTaskDetailModalFromSidebar(${index})">
                    <span class="detail-title">${escapeHtml(task.meeting || 'Untitled Meeting')}</span>
                    <div class="detail-row">
                        <span class="detail-label">Type:</span>
                        <span class="detail-value">${escapeHtml(task.source || '-')}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Assignee:</span>
                        <span class="detail-value">${escapeHtml(task.owner || 'Unassigned')}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Status:</span>
                        <span class="detail-value">${escapeHtml(task.status || '-')}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Closure Date:</span>
                        <span class="detail-value">${escapeHtml(task.due || '-')}</span>
                    </div>
                </div>
            `).join('');
            }

            function openIacSummaryView() {
                currentSummaryMode = 'status';
                currentSummaryKeys = ['open', 'recommended for closure', 'completed', 'overdue'];
                currentCanvasLabel = 'Task Status Details';
                const summaryView = document.getElementById('iacSummaryView');
                const detailsView = document.getElementById('iacDetailsView');
                document.getElementById('iacDetailCanvasLabel').innerText = currentCanvasLabel;
                summaryView.innerHTML = renderIacSummaryCards(currentSummaryKeys);
                summaryView.style.display = 'block';
                detailsView.style.display = 'none';

                const target = document.getElementById('iacDetailCanvas');
                const offcanvas = bootstrap.Offcanvas.getInstance(target) || new bootstrap.Offcanvas(target);
                offcanvas.show();
            }

            function hideIacDetails() {
                const summaryView = document.getElementById('iacSummaryView');
                const detailsView = document.getElementById('iacDetailsView');
                document.getElementById('iacDetailCanvasLabel').innerText = currentCanvasLabel;
                if (currentSummaryMode === 'month') {
                    summaryView.innerHTML = renderTasksByMonthSummaryCards();
                } else {
                    summaryView.innerHTML = renderIacSummaryCards(currentSummaryKeys);
                }
                summaryView.style.display = 'block';
                detailsView.style.display = 'none';
            }

            function showIacDetails(title, tasks, statusKey) {
                const normalizedTitle = String(title || 'Tasks');
                const panelTitle = /tasks$/i.test(normalizedTitle) ? normalizedTitle : (normalizedTitle + ' Tasks');
                const summaryView = document.getElementById('iacSummaryView');
                const detailsView = document.getElementById('iacDetailsView');
                currentSidebarTasks = Array.isArray(tasks) ? tasks : [];

                document.getElementById('iacDetailCanvasLabel').innerText = panelTitle;
                document.getElementById('iacDetailsProgress').innerHTML = renderIacProgressCard(panelTitle,
                    String(statusKey || '').toLowerCase().trim(), currentSidebarTasks.length);
                document.getElementById('iacDetailContent').innerHTML = renderIacDetailCards(currentSidebarTasks);
                document.getElementById('iacDetailCanvasSubtitle').innerText = currentSidebarTasks.length +
                    (currentSidebarTasks.length === 1 ? ' task found' : ' tasks found');

                summaryView.style.display = 'none';
                detailsView.style.display = 'block';
                const target = document.getElementById('iacDetailCanvas');
                const offcanvas = bootstrap.Offcanvas.getInstance(target) || new bootstrap.Offcanvas(target);
                offcanvas.show();
            }

            function openTaskDetailModalFromSidebar(index) {
                const task = currentSidebarTasks[index];
                if (!task) return;
                openTaskDetailModal(task);
            }

            function openTaskFromTableRow(row) {
                if (!row) return;
                openTaskDetailModal({
                    meeting: row.getAttribute('data-meeting') || '-',
                    status: row.getAttribute('data-status') || 'Open',
                    statusKey: row.getAttribute('data-status-key') || 'open',
                    heading: row.getAttribute('data-heading') || '-',
                    owner: row.getAttribute('data-owner') || 'Unassigned',
                    createdBy: row.getAttribute('data-created-by') || 'Unassigned',
                    reviewer: row.getAttribute('data-reviewer') || 'Unassigned',
                    meetingDate: row.getAttribute('data-meeting-date') || '-',
                    due: row.getAttribute('data-due') || '-',
                    updates: JSON.parse(row.getAttribute('data-updates') || '[]')
                });
            }

            function escapeHtml(value) {
                return String(value ?? '')
                    .replaceAll('&', '&amp;')
                    .replaceAll('<', '&lt;')
                    .replaceAll('>', '&gt;')
                    .replaceAll('"', '&quot;')
                    .replaceAll("'", '&#039;');
            }

            function toPlainText(value) {
                return String(value ?? '')
                    .replace(/<[^>]*>/g, ' ')
                    .replace(/\s+/g, ' ')
                    .trim();
            }

            function setWorkflowStep(statusKey) {
                const normalized = String(statusKey || '').toLowerCase().trim();
                const iacWorkflowSteps = [{
                        step: 1,
                        label: 'Open',
                        key: 'open'
                    },
                    {
                        step: 2,
                        label: 'Recommended for Closure',
                        key: 'recommended for closure'
                    },
                    {
                        step: 3,
                        label: 'Completed',
                        key: 'completed'
                    }
                ];

                let currentStepObj = iacWorkflowSteps.find(s => s.key === normalized);
                if (!currentStepObj) {
                    if (normalized === 'overdue') {
                        currentStepObj = iacWorkflowSteps[0];
                    } else {
                        currentStepObj = iacWorkflowSteps[0];
                    }
                }
                const currentStep = currentStepObj.step;
                const tone = getUpdateStatusTone(normalized);

                const progressText = document.getElementById('modalWorkflowProgressText');
                if (progressText) {
                    progressText.innerText = `Step ${currentStep} / ${iacWorkflowSteps.length}`;
                }

                const stepperContainer = document.getElementById('modalWorkflowStepperNew');
                if (stepperContainer) {
                    stepperContainer.style.setProperty('--step-count', iacWorkflowSteps.length);
                    stepperContainer.innerHTML = iacWorkflowSteps.map(step => {
                        const isActive = currentStep >= step.step;
                        const isCurrent = currentStep === step.step;
                        const stepState = isCurrent ? 'is-active' : (isActive ? 'is-done' : 'is-pending');

                        const borderColor = isCurrent ? tone.color : '#dbe5f2';
                        const bg = isCurrent ? tone.bg : '#fff';
                        const color = isCurrent ? tone.color : (isActive ? '#2563eb' : '#94a3b8');
                        const boxShadow = isCurrent ? `0 0 0 3px ${tone.color}20` : 'none';

                        let iconHtml = step.step;
                        if (isActive && isCurrent) iconHtml = '<i class="ri-record-circle-line"></i>';
                        else if (isActive) iconHtml = '<i class="ri-check-line"></i>';

                        return `
                        <div class="tt-show-step ${stepState}">
                            <span class="tt-show-step-circle"
                                style="border-color: ${borderColor}; background: ${bg}; color: ${color}; box-shadow: ${boxShadow};">
                                ${iconHtml}
                            </span>
                            <span class="tt-show-step-label">${step.label}</span>
                            <span class="tt-show-step-sub">${isCurrent ? 'Current' : (isActive ? 'Done' : 'Pending')}</span>
                        </div>
                    `;
                    }).join('');
                }
            }

            function getUpdateStatusLabel(statusKey) {
                const map = {
                    open: 'Open',
                    'under review': 'Under Review',
                    'awaiting final approval': 'Awaiting Final Approval',
                    'recommended for closure': 'Recommended for Closure',
                    completed: 'Completed',
                    overdue: 'Overdue'
                };
                return map[statusKey] || (statusKey ? statusKey.replaceAll('_', ' ').replace(/\b\w/g, (c) => c.toUpperCase()) :
                    '');
            }

            function getUpdateStatusTone(statusKey) {
                return {
                    open: {
                        bg: '#fff7ed',
                        color: '#b45309',
                        border: '#fdba74',
                        icon: 'ri-time-line',
                        label: 'Open'
                    },
                    'under review': {
                        bg: '#eff6ff',
                        color: '#1d4ed8',
                        border: '#93c5fd',
                        icon: 'ri-search-eye-line',
                        label: 'Under Review'
                    },
                    'awaiting final approval': {
                        bg: '#f5f3ff',
                        color: '#7c3aed',
                        border: '#c4b5fd',
                        icon: 'ri-shield-check-line',
                        label: 'Awaiting Final Approval'
                    },
                    'recommended for closure': {
                        bg: '#fff7ed',
                        color: '#ea580c',
                        border: '#fdba74',
                        icon: 'ri-thumb-up-line',
                        label: 'Recommended for Closure'
                    },
                    completed: {
                        bg: '#ecfdf5',
                        color: '#059669',
                        border: '#6ee7b7',
                        icon: 'ri-checkbox-circle-line',
                        label: 'Completed'
                    },
                    overdue: {
                        bg: '#fff1f2',
                        color: '#e11d48',
                        border: '#fca5a5',
                        icon: 'ri-alert-line',
                        label: 'Overdue'
                    }
                } [statusKey] || {
                    bg: '#f8fafc',
                    color: '#475569',
                    border: '#cbd5e1',
                    icon: 'ri-information-line',
                    label: statusKey
                };
            }

            function renderUpdates(updates, fallbackStatusKey) {
                const safeUpdates = Array.isArray(updates) ? updates : [];
                const labelEl = document.getElementById('modalUpdatesLabel');
                const container = document.getElementById('modalResponsesContainer');

                labelEl.innerText = `Updates & Responses (${safeUpdates.length})`;

                if (!safeUpdates.length) {
                    container.innerHTML =
                        '<div class="text-muted py-3 text-center opacity-50" style="font-size:12px;">No responses yet.</div>';
                    return;
                }

                container.innerHTML = safeUpdates.map((update) => {
                    const data = update?.data || {};
                    const type = String(data?.type || 'note').toLowerCase();
                    const title = data?.title || (type === 'response' ? 'Response submitted' : (type === 'rejection' ?
                        'Rejected' : 'Task note'));
                    const statusKey = String(data?.status_to || fallbackStatusKey || '').toLowerCase().trim();
                    const statusLabel = getUpdateStatusLabel(statusKey);
                    const tone = getUpdateStatusTone(statusKey);
                    const message = update?.message ? String(update.message) : 'No remarks provided.';

                    return `
                      <div class="card mb-3 border-0 shadow-sm rounded-4">
                          <div class="card-body">
                      
                              <div class="d-flex justify-content-between align-items-start">
                                  <div>
                                      <h6 class="fw-semibold mb-1">${escapeHtml(title)}</h6>
                                      <small class="text-muted">
                                          ${escapeHtml(update?.creator || 'User')} | 
                                          ${escapeHtml(update?.created_at || '--')}
                                      </small>
                                  </div>
                      
                                  ${statusKey ? `<span class="badge rounded-pill px-3 py-2" style="background:${tone.bg}; color:${tone.color};"> ${escapeHtml(statusLabel)} </span>` : ''}
                              </div>
                      
                              <p class="mt-2 mb-0 text-dark">
                                  ${escapeHtml(message)}
                              </p>
                      
                          </div>
                      </div>
                      `;
                }).join('');
            }

            function openTaskDetailModal(task) {
                const meeting = task?.meeting || '-';
                const status = task?.status || 'Open';
                const statusKey = task?.statusKey || status;
                const heading = task?.heading || '-';
                const owner = task?.owner || 'Unassigned';
                const createdBy = task?.createdBy || 'Unassigned';
                const reviewer = task?.reviewer || 'Unassigned';
                const meetingDate = task?.meetingDate || '-';
                const due = task?.due || '-';
                const updates = task?.updates || [];

                document.getElementById('modalMeetingName').innerText = meeting;
                document.getElementById('modalDescription').innerHTML = heading;

                document.getElementById('modalAssignee').innerHTML =
                    `<img class="rounded-circle flex-shrink-0 border" style="width:22px;height:22px;object-fit:cover;" src="${window.location.origin}/admin/assets/images/users/avatar-1.jpg" onerror="this.src='https://ui-avatars.com/api/?name=' + encodeURIComponent('${owner}') + '&color=7F9CF5&background=EBF4FF'" alt=""> ${escapeHtml(owner)}`;
                document.getElementById('modalCreatedBy').innerHTML =
                    `<img class="rounded-circle flex-shrink-0 border" style="width:22px;height:22px;object-fit:cover;" src="${window.location.origin}/admin/assets/images/users/avatar-1.jpg" onerror="this.src='https://ui-avatars.com/api/?name=' + encodeURIComponent('${createdBy}') + '&color=7F9CF5&background=EBF4FF'" alt=""> ${escapeHtml(createdBy)}`;

                if (reviewer && reviewer !== 'Unassigned') {
                    document.getElementById('modalReviewer').innerHTML =
                        `<img class="rounded-circle flex-shrink-0 border" style="width:22px;height:22px;object-fit:cover;" src="${window.location.origin}/admin/assets/images/users/avatar-1.jpg" onerror="this.src='https://ui-avatars.com/api/?name=' + encodeURIComponent('${reviewer}') + '&color=7F9CF5&background=EBF4FF'" alt=""> ${escapeHtml(reviewer)}`;
                } else {
                    document.getElementById('modalReviewer').innerHTML =
                        `<span class="fst-italic text-muted">Not assigned</span>`;
                }

                document.getElementById('modalMeetingDate').innerText = meetingDate;
                document.getElementById('modalClosureDate').innerText = due;

                const normalizedStatusKey = String(statusKey || '').toLowerCase().trim();
                const tone = getUpdateStatusTone(normalizedStatusKey);

                const badgeNew = document.getElementById('modalStatusBadgeNew');
                if (badgeNew) {
                    badgeNew.style.background = tone.bg;
                    badgeNew.style.color = tone.color;
                    badgeNew.style.border = '1.5px solid ' + tone.border;
                }

                const iconNew = document.getElementById('modalStatusIconNew');
                if (iconNew) {
                    iconNew.className = tone.icon + ' me-1';
                }

                const textNew = document.getElementById('modalStatusTextNew');
                if (textNew) {
                    textNew.innerText = tone.label;
                }

                setWorkflowStep(normalizedStatusKey);
                renderUpdates(updates, statusKey);
                new bootstrap.Modal(document.getElementById('taskDetailModal')).show();
            }

            // Auto-inject PDF + Excel into panel dropdowns
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.dropdown-menu').forEach(function(menu) {
                    const csvLink = Array.from(menu.querySelectorAll('a.dropdown-item'))
                        .find(function(a) {
                            return a.textContent.trim().includes('Download CSV');
                        });
                    if (!csvLink) return;
                    const m = (csvLink.getAttribute('onclick') || '')
                        .match(/downloadTableAsCSV\(['"]([^'"]+)['"]\s*,\s*['"]([^'"]+)['"]\)/);
                    if (!m) return;
                    const tid = m[1],
                        fb = m[2].replace('.csv', '');
                    const mkItem = function(icon, label, fn) {
                        const a = document.createElement('a');
                        a.className = 'dropdown-item py-2 px-3 modern-dropdown-item';
                        a.href = 'javascript:void(0);';
                        a.innerHTML = '<i class="' + icon + ' me-2"></i> ' + label;
                        a.addEventListener('click', fn);
                        return a;
                    };
                    menu.appendChild(mkItem('ri-file-pdf-line', 'Download PDF', function() {
                        downloadTableAsPdf(tid, fb + '.pdf');
                    }));
                    menu.appendChild(mkItem('ri-file-excel-line', 'Download Excel', function() {
                        downloadTableAsExcel(tid, fb + '.xlsx');
                    }));
                });
            });


            function exportAllAsExcel(format = 'csv') {
                const data = @json($getexcelDownload);

                if (!data || !data.length) {
                    alert('No data to export');
                    return;
                }

                const formatted = data.map(task => ({
                    Meeting: task.meeting_title ?? '-',
                    Type: task.type ?? '-',
                    Assignee: task.assignee?.name ?? 'Unassigned',
                    Reviewer: task.reviewer?.name ?? 'Unassigned',
                    'Closure Date': task.closure_date ?
                        new Date(task.closure_date).toLocaleDateString('en-GB', {
                            day: '2-digit',
                            month: 'short',
                            year: 'numeric'
                        }) :
                        '-',
                    Status: task.status ?? '-'
                }));

                if (format === 'excel') {
                    const ws = XLSX.utils.json_to_sheet(formatted);
                    const wb = XLSX.utils.book_new();
                    XLSX.utils.book_append_sheet(wb, ws, 'All Tasks');
                    XLSX.writeFile(wb, 'iac_engagement_report.xlsx');
                } else { // CSV
                    let csv = 'Meeting,Type,Assignee,Reviewer,Closure Date,Status\n';

                    formatted.forEach(row => {
                        csv += Object.values(row).map(val => `"${String(val).replace(/"/g, '""')}"`).join(',') + '\n';
                    });

                    const blob = new Blob([csv], {
                        type: 'text/csv;charset=utf-8;'
                    });
                    const url = URL.createObjectURL(blob);
                    const link = document.createElement('a');
                    link.href = url;
                    link.download = 'iac_engagement_report.csv';
                    link.click();
                    URL.revokeObjectURL(url);
                }
            }

            function printPage() {
                window.print();
            }



            function downloadTableAsCSV(tableId, filename) {
                const table = document.getElementById(tableId);
                if (!table) return;
                let csv = '';
                table.querySelectorAll('thead th').forEach((th, i, arr) => {
                    csv += '"' + th.textContent.trim().replace(/"/g, '""') + '"';
                    csv += i < arr.length - 1 ? ',' : '\n';
                });
                table.querySelectorAll('tbody tr').forEach(row => {
                    row.querySelectorAll('td').forEach((td, i, arr) => {
                        csv += '"' + td.textContent.trim().replace(/"/g, '""') + '"';
                        csv += i < arr.length - 1 ? ',' : '\n';
                    });
                });
                const blob = new Blob([csv], {
                    type: 'text/csv'
                });
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = filename;
                a.click();
                URL.revokeObjectURL(url);
            }

            async function capturePanelCanvas(panelId) {
                const panel = document.getElementById(panelId);
                if (!panel || typeof html2canvas === 'undefined') return null;
                panel.querySelectorAll('.dropdown-menu').forEach(m => m.classList.remove('show'));
                return await html2canvas(panel, {
                    backgroundColor: '#ffffff',
                    scale: 2,
                    useCORS: true,
                    logging: false,
                });
            }

            async function downloadCardAsPng(panelId, filename) {
                try {
                    const canvas = await capturePanelCanvas(panelId);
                    if (!canvas) return;
                    canvas.toBlob(blob => {
                        if (blob) {
                            const url = URL.createObjectURL(blob);
                            const a = document.createElement('a');
                            a.href = url;
                            a.download = filename;
                            a.click();
                            URL.revokeObjectURL(url);
                        }
                    }, 'image/png');
                } catch (e) {
                    console.error(e);
                }
            }

            async function downloadCardAsSvg(panelId, filename) {
                try {
                    const canvas = await capturePanelCanvas(panelId);
                    if (!canvas) return;
                    const png = canvas.toDataURL('image/png');
                    const svg = `<svg xmlns="http://www.w3.org/2000/svg" width="${canvas.width}" height="${canvas.height}" viewBox="0 0 ${canvas.width} ${canvas.height}">
            <image href="${png}" width="${canvas.width}" height="${canvas.height}" />
        </svg>`;
                    const blob = new Blob([svg], {
                        type: 'image/svg+xml;charset=utf-8'
                    });
                    const url = URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = filename;
                    a.click();
                    URL.revokeObjectURL(url);
                } catch (e) {
                    console.error(e);
                }
            }


            function downloadTableAsExcel(tableId, filename) {
                const table = document.getElementById(tableId);
                if (!table || typeof XLSX === 'undefined') {
                    console.error('XLSX library not loaded or table not found:', tableId);
                    return;
                }
                const wb = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(wb, XLSX.utils.table_to_sheet(table), 'Data');
                XLSX.writeFile(wb, filename);
            }

            function downloadTableAsPdf(tableId, filename) {
                const table = document.getElementById(tableId);
                if (!table) {
                    console.error('Table not found:', tableId);
                    return;
                }

                const headers = Array.from(table.querySelectorAll('thead th')).map(th => ({
                    text: th.textContent.trim(),
                    bold: true,
                    fillColor: '#2c3e50',
                    color: '#ffffff',
                    fontSize: 8
                }));

                const rows = Array.from(table.querySelectorAll('tbody tr')).map(tr =>
                    Array.from(tr.querySelectorAll('td')).map(td => ({
                        text: td.textContent.trim(),
                        fontSize: 8
                    }))
                );

                if (!headers.length) return;

                // pdfMake CDN load karo agar nahi hai
                if (typeof pdfMake === 'undefined') {
                    const script1 = document.createElement('script');
                    script1.src = 'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js';
                    const script2 = document.createElement('script');
                    script2.src = 'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js';
                    script2.onload = function() {
                        generatePdf(headers, rows, filename);
                    };
                    document.head.appendChild(script1);
                    document.head.appendChild(script2);
                    return;
                }

                generatePdf(headers, rows, filename);
            }

            function generatePdf(headers, rows, filename) {
                pdfMake.createPdf({
                    pageOrientation: 'landscape',
                    content: [{
                        table: {
                            headerRows: 1,
                            widths: headers.map(() => '*'),
                            body: [headers, ...rows]
                        },
                        layout: 'lightHorizontalLines'
                    }],
                    defaultStyle: {
                        fontSize: 8
                    }
                }).download(filename);
            }
        </script>
    @endsection
