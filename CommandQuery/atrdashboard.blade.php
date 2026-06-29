@extends('app')
@php
    $atrRoleNames = authUser()?->getRoleNames()->map(fn($role) => strtolower((string) $role)) ?? collect();
    $atrActiveRoleSlug = strtolower(
        trim(
            (string) optional(
                authUser()?->organizations()->where('organizations.id', organizationId())->first()?->pivot,
            )->role_slug,
        ),
    );
    $isAuditee =
        strtolower(
            trim(
                (string) optional(
                    authUser()?->organizations()->where('organizations.id', organizationId())->first()?->pivot,
                )->role_slug,
            ),
        ) === 'auditee';
    $canOpenGroupDepartment =
        isSuperAdmin() ||
        $atrRoleNames->contains('audit owner') ||
        $atrRoleNames->contains('auditor') ||
        in_array($atrActiveRoleSlug, ['audit owner', 'auditor'], true);
@endphp
@section('breadcrumb-button')
    @unless ($isAuditee)
        <div class="dropdown d-flex align-items-center">
            <button
                class="btn btn-white btn-sm d-print-none d-inline-flex align-items-center fw-medium dropdown-toggle gap-1 border px-3 py-1 shadow-sm"
                type="button" data-bs-toggle="dropdown" data-bs-strategy="fixed" aria-expanded="false"
                style="background: white !important; color: #334155; border-color: #e2e8f0 !important;">
                <i class="ri-download-2-line" style="font-size: 16px;"></i>
                <span class="d-none d-md-inline">Export Report</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end border-0 shadow"
                style="border-radius: 12px; padding: 0.5rem; min-width: 160px;">
                <li>
                    <a class="dropdown-item modern-dropdown-item px-3 py-2" href="javascript:void(0);" onclick="printPage()">
                        <i class="ri-file-pdf-line me-2"></i> PDF
                    </a>
                </li>
                <li>
                    <a class="dropdown-item modern-dropdown-item px-3 py-2" href="javascript:void(0);"
                        onclick="exportAllAsExcel()">
                        <i class="ri-file-excel-line me-2"></i> Excel
                    </a>
                </li>
                <li>
                    <a class="dropdown-item modern-dropdown-item px-3 py-2" href="javascript:void(0);" id="atrExportDocxBtn">
                        <i class="ri-file-word-2-line me-2 text-primary"></i> Word (.docx)
                    </a>
                </li>
            </ul>
        </div>
    @endunless
@endsection
@section('title', 'ATR Dashboard')
@section('page-title', 'ATR Dashboard')
@section('breadcrumb', 'ATR Dashboard')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    @if ($isAuditee)
        <style>.icon-btn[data-bs-toggle="dropdown"] { display: none !important; }</style>
    @endif
    <style>
        #ExcelTable th {
            /* background: #444; */
            padding: 5px;
        }

        .select2-selection--multiple:before {
            content: "";
            position: absolute;
            right: 7px;
            top: 42%;
            border-top: 5px solid #ced4da;
            border-left: 4px solid transparent;
            border-right: 4px solid transparent;
        }

        #DataTable th {
            min-width: 100px;
        }

        .swal2-confirm.btn-sm {
            padding: 5px 10px;
            /* Reduce padding */
            font-size: 10px;
            width: 60px;
        }

        .swal2-cancel.btn-sm {
            padding: 5px 10px;
            /* Reduce padding */
            font-size: 10px;

        }

        .custom-dropdown-item {
            margin: 30px;

        }

        .filter-avatar {
            min-width: 120px !important;
            padding: 0px 5px;
            flex-grow: 1;
        }

        .counter-avatar {
            flex-grow: 1 !important;
        }

        .filters select {
            padding: 12px !important;
            font-size: 10px !important;
            border: 1px solid #ccc;
            border-radius: 7px;
            outline: none !important;

        }

        .apexcharts-legend-text {
            font-size: 8px !Important;
        }

        .reportTable th {
            font-size: 10px;
        }

        .reportTable td {
            font-size: 10px;
            padding: 5px;
        }

        .reportTable tr:nth-child(even),
        .reportTable tr:nth-child(even) a {
            /* background: #4b38b3; */
            /* color: white; */
        }

        .l1 {

            border: 1px solid #ccc;
            /* border-left: 5px solid #e76f51 !important; */
        }

        .l2 {

            border: 1px solid #ccc;
            /* border-left: 5px solid #f4a261 !important; */
        }

        .l3 {
            border: 1px solid #ccc;
            /* border-left: 5px solid #2a9d8f !important; */
        }

        .observation-count {
            border: 1px solid #ccc;
        }

        .icon-btn {
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 31px;
            height: 31px;
            border-radius: 8px;
            transition: all 0.2s ease;
            color: #64748b;
        }

        .icon-btn:hover {
            background-color: #f1f5f9;
            color: #2563eb;
        }

        .icon-btn.show {
            background-color: #eff6ff !important;
            color: #2563eb !important;
        }

        .icon-btn i {
            display: flex;
            gap: 6px;
            align-items: center;
            color: #1e293b;
        }

        .icon-btn i.ri-layout-grid-line {
            transform: translateY(0.5px);
        }

        .gd-toolbar {
            display: flex;
            gap: 6px;
            align-items: center;
            color: #1e293b;
        }

        @media print {
            @page {
                size: portrait;
                margin: 1cm;
            }

            body,
            html {
                height: auto !important;
                overflow: visible !important;
                background: #fff !important;
                visibility: visible !important;
                margin: 0 !important;
                padding: 0 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                width: 100% !important;
            }

            #layout-wrapper,
            .main-content,
            .page-content {
                display: block !important;
                visibility: visible !important;
                height: auto !important;
                min-height: auto !important;
                overflow: visible !important;
                margin: 0 !important;
                padding: 0 !important;
                position: static !important;
                width: 100% !important;
            }

            .container-fluid,
            .row,
            .col-12,
            .col-md-6,
            .col-lg-6,
            .col-md-4,
            .col-lg-4,
            .col-md-3,
            .col-lg-3,
            .col-print-12 {
                width: 100% !important;
                max-width: 100% !important;
                flex: 0 0 100% !important;
                display: block !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            .card,
            .card-body,
            .gd-panel-toggle-view {
                display: block !important;
                visibility: visible !important;
                height: auto !important;
                overflow: visible !important;
                break-inside: auto !important;
                page-break-inside: auto !important;
                border: 1px solid #e2e8f0 !important;
                box-shadow: none !important;
                margin-bottom: 20px !important;
                width: 100% !important;
            }

            .card-body[data-scrollable],
            .card-body[style],
            .card-body>div[style],
            .gd-panel-toggle-view>div[style],
            .border.rounded-3,
            .border.rounded-3>div {
                height: auto !important;
                max-height: none !important;
                overflow: visible !important;
                white-space: normal !important;
            }

            thead {
                display: table-header-group !important;
                position: static !important;
            }

            tr,
            th,
            td {
                break-inside: avoid !important;
                page-break-inside: avoid !important;
                position: static !important;
            }

            table {
                width: 100% !important;
                table-layout: auto !important;
                page-break-inside: auto !important;
            }

            .atrdashboard-modern table th,
            .atrdashboard-modern table td {
                visibility: visible !important;
                opacity: 1 !important;
                white-space: normal !important;
                word-wrap: break-word;
                word-break: break-word;
            }

            canvas,
            .apexcharts-canvas,
            .apexcharts-svg {
                max-width: 100% !important;
                width: 100% !important;
                height: auto !important;
            }

            header,
            .app-menu,
            .footer,
            .d-print-none,
            .no-print,
            .gd-toolbar {
                display: none !important;
            }
        }

        /* Apply a consistent height to the Select2 container */
        .select2-container--default .select2-selection--multiple {
            min-height: 38px;
            /* Or set to match the original select element height */
            max-height: 38px;
            /* Maintain consistent shape */
            line-height: 36px;
            /* Center-align the text vertically */
            padding: 4px;
            /* Adjust padding to fit within the height */
            overflow: hidden;
            /* Hide overflow to prevent expansion */
        }

        /* Adjust the placeholder styling */
        .select2-container--default .select2-selection--multiple .select2-selection__placeholder {
            font-size: 14px;
            /* Match font-size of other inputs */
            color: #6c757d;
            /* Placeholder color */
        }

        /* Ensure the container width matches its parent for responsive layouts */
        .select2-container {
            width: 100% !important;
        }


        #expandablefilter {

            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 20px;
            width: 30px;
        }

        /* First column (sticky) */
        #DataTable th:first-child,
        #DataTable td:first-child {
            position: sticky;
            left: 0;
            z-index: 10;
            background-color: #fff;
            border: 1px solid #00000012;
            /* Match header background */
        }

        /* Second column (sticky) */
        #DataTable th:nth-child(2),
        #DataTable td:nth-child(2) {
            position: sticky;
            left: 40px;
            /* Adjust this based on the width of the first column */
            z-index: 10;
            background-color: #fff;
            border: 1px solid #00000012;
            /* Match header background */
        }


        /* ----  Colors  ---- */
        .color_badge {
            border-radius: 20px;
            border: none !important;
        }

        .color_success {
            background: #edf6ed;
            color: #4aa54afc;
        }

        .color_danger {
            background: #fce5e5;
            color: #e50000;
        }

        .color_warning {
            background: #fcf7eb;
            color: #dfab35;
        }

        .progress-count {
            position: absolute;
            top: 50%;
            right: 10px;
            /* Adjusts distance from the right edge */
            transform: translateY(-50%);
            color: black !important;
            font-weight: bold;
        }



        /* Offcanvas Width Increases */
        .offcanvas-end {
            width: 950px !important;
            /* Increased for better visibility */
            max-width: 90vw !important;
        }

        #subObsStatusOffcanvas {
            width: 950px !important;
        }
    </style>

    <style>
        .icon-btn {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 18px;
            color: #333;
            transition: color 0.3s ease;
        }

        .icon-btn:hover {
            color: #007bff;
            /* Highlight color on hover */
        }

        .icon-btn:focus {
            outline: none;
        }

        /* --- Modern ATR Scoped Layout --- */
        .atrdashboard-modern .card {
            border-radius: 12px !important;
            border: 1px solid rgba(0, 0, 0, 0.06) !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03) !important;
            background: #ffffff !important;
        }

        .atrdashboard-modern .card-header {
            background: #ffffff !important;
            border-bottom: 1px solid rgba(0, 0, 0, 0.04) !important;
            padding: 16px 20px 10px 20px !important;
            border-radius: 12px 12px 0 0 !important;
        }

        .atrdashboard-modern .card-header b {
            font-size: 16px;
            font-weight: 700;
            color: #1f3252;
            letter-spacing: 0.2px;
        }

        .atrdashboard-modern small {
            color: #64748b !important;
            font-size: 13px !important;
        }

        /* Modernized Minimalist Tables matching image */
        .atrdashboard-modern .reportTable {
            border: none !important;
        }

        .atrdashboard-modern .reportTable th {
            background: #f8fafc !important;
            border: none !important;
            border-bottom: 2px solid #e2e8f0 !important;
            color: #475569 !important;
            font-weight: 700 !important;
            text-transform: uppercase;
            font-size: 13px !important;
            letter-spacing: 0.5px;
            padding: 12px 10px !important;
        }

        .atrdashboard-modern .reportTable td {
            border: none !important;
            border-bottom: 1px solid #f1f5f9 !important;
            vertical-align: middle;
            color: #334155;
            padding: 12px 10px !important;
        }

        .atrdashboard-modern .reportTable tr:last-child td {
            border-bottom: none !important;
        }

        .atrdashboard-modern .reportTable a {
            color: #2563eb;
            font-weight: 500;
            text-decoration: none;
        }

        .atrdashboard-modern .reportTable a:hover {
            text-decoration: underline;
        }

        .atrdashboard-modern .badge {
            border-radius: 20px;
            padding: 5px 10px;
            font-weight: 600;
            font-size: 12px;
        }

        /* Badge color mappings */
        .badge-high {
            background-color: #FCEBEB;
            color: #E24B4A;
        }

        .badge-medium {
            background-color: #FAEEDA;
            color: #EF9F27;
        }

        .badge-low {
            background-color: #EAF3DE;
            color: #639922;
        }

        .badge-open {
            background-color: #F1EFE8;
            color: #888780;
        }

        .badge-closed {
            background-color: #EAF3DE;
            color: #639922;
        }

        /* Sub-observation sidebar styles */
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
            background-color: #888780;
        }

        .status-dot-closed {
            background-color: #639922;
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
            background-color: #888780;
            width: 62.5%;
        }

        .fill-closed {
            background-color: #639922;
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

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        e .dashboard-overdue-panel {
            width: min(900px, 72vw) !important;
        }

        .dashboard-overdue-panel .offcanvas-body {
            padding: 1.25rem 1.5rem 1.75rem;
        }

        .dashboard-detail-table-wrap {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
            background: #fff;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .dashboard-detail-table {
            width: 100%;
            border-collapse: collapse;
        }

        .dashboard-detail-table th {
            background: #f8fafc;
            color: #64748b;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.5px;
            padding: 12px 16px;
            border-bottom: 1px solid #e2e8f0;
            white-space: nowrap;
            text-transform: uppercase;
        }

        .dashboard-detail-table td {
            padding: 14px 16px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
            color: #334155;
            font-size: 13px;
        }

        .dashboard-detail-table tbody tr:hover td {
            background-color: #fbfcfe;
        }

        .dashboard-detail-table tbody tr:last-child td {
            border-bottom: none;
        }

        .dashboard-detail-table td a {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            color: #2563eb;
            text-decoration: none;
            font-weight: 500;
        }

        .dashboard-detail-table td a:hover {
            text-decoration: underline;
        }

        .dashboard-status-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            padding: 4px 10px;
            font-size: 11px;
            font-weight: 600;
            line-height: 1.2;
            white-space: nowrap;
            min-width: 60px;
            text-align: center;
        }

        .dashboard-status-badge--danger {
            background: #fee2e2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        .dashboard-status-badge--warning {
            background: #fef3c7;
            color: #d97706;
            border: 1px solid #fde68a;
        }

        .dashboard-status-badge--success {
            background: #dcfce7;
            color: #16a34a;
            border: 1px solid #bbf7d0;
        }

        .dashboard-status-badge--secondary {
            background: #eff6ff;
            color: #2563eb;
            border: 1px solid #bfdbfe;
        }

        .dashboard-status-badge--muted {
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #e2e8f0;
        }

        /* Specific badge styling for tables */
        .dashboard-detail-table .badge {
            border-radius: 6px;
            padding: 5px 10px;
            font-weight: 600;
            font-size: 11px;
            min-width: 65px;
            display: inline-block;
        }

        .dashboard-ageing-pill {
            min-width: 34px;
            height: 28px;
            padding: 0 8px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
        }

        .dashboard-ageing-pill--danger {
            background: #fee2e2;
            color: #dc2626;
        }

        .dashboard-ageing-pill--warning {
            background: #fef3c7;
            color: #d97706;
        }

        .selected-tag {
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 2px 8px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            color: #334155;
            font-weight: 500;
            margin: 2px;
        }

        .selected-tag .remove-tag {
            cursor: pointer;
            color: #94a3b8;
            font-size: 14px;
            display: flex;
            align-items: center;
        }

        .selected-tag .remove-tag:hover {
            color: #ef4444;
        }

        .custom-select-display {
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            padding: 8px 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            background: white;
            position: relative;
            z-index: 1;
            min-height: 42px;
            flex-wrap: wrap;
            gap: 4px;
        }

        /* Dashboard Metric Pills */
        .dashboard-metric-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            font-size: 13px;
            font-weight: 600;
            border: none;
            background: #f1f5f9;
            color: #64748b;
            cursor: default;
            transition: transform 0.15s ease;
        }

        .dashboard-metric-pill.is-clickable {
            cursor: pointer;
        }

        .dashboard-metric-pill.is-clickable:hover {
            transform: scale(1.1);
        }

        .dashboard-metric-pill--danger {
            background-color: #FCEBEB;
            color: #E24B4A;
        }

        .dashboard-metric-pill--warning {
            background-color: #FAEEDA;
            color: #EF9F27;
        }

        .dashboard-metric-pill--success {
            background-color: #EAF3DE;
            color: #639922;
        }

        .dashboard-metric-pill--secondary {
            background-color: #f1f5f9;
            color: #334155;
        }

        .dashboard-matrix-table {
            width: 100%;
            border-collapse: collapse;
        }

        .dashboard-matrix-table th {
            font-size: 11px;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            padding: 12px 16px;
            border-bottom: 1px solid #f1f5f9;
            letter-spacing: 0.5px;
            position: sticky;
            top: 0;
            background: #ffffff;
            z-index: 10;
        }

        .dashboard-matrix-table td {
            padding: 12px 16px;
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
            font-size: 13px;
            vertical-align: middle;
        }

        .dashboard-matrix-table tr:last-child td {
            border-bottom: none;
        }

        .dashboard-matrix-link {
            color: #2563eb;
            text-decoration: none;
            font-weight: 500;
        }

        .dashboard-matrix-link:hover {
            color: #2563eb;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('admin/assets/css/dashboard-option.css') }}">
@endsection

@section('content')
    @php
        $statusStyles = [
            'final observation' => 'background-color:#EAF3DE; color:#639922;',
            'draft observation' => 'background-color:#EEEDFE; color:#7F77DD;',
            'query' => 'background-color:#E1F5EE; color:#1D9E75;',
            'dropped' => 'background-color:#FCEBEB; color:#E24B4A;',
            'open' => 'background-color:#FFF4E5; color:#B45309; border: 1px solid #FDE68A;',
            'closed' => 'background-color:#EAF3DE; color:#639922;',
        ];

        $riskStyles = [
            'high' => 'background-color:#FCEBEB; color:#E24B4A; border: 1px solid #FECACA;',
            'medium' => 'background-color:#FFFBEB; color:#D97706; border: 1px solid #FEF3C7;',
            'low' => 'background-color:#EAF3DE; color:#639922; border: 1px solid #BBF7D0;',
        ];

        $openClosed = [
            'open' => 'background-color:#FFF4E5; color:#B45309; font-size: 8px;',
            'closed' => 'background-color:#EAF3DE; color:#639922; font-size: 8px;',
        ];
    @endphp
    @php
        $colors = [
            'observations' => 'observation-count',
            'l1' => 'l1',
            'l2' => 'l2',
            'l3' => 'l3',
        ];
        $currentRoute = Route::currentRouteName();
    @endphp

    @php
        $dashboardOption = getDashboardOptions('atr_dashboard');
        $dashboardOptions = $dashboardOption->data ?? [];
    @endphp

    @php
        $overdueObservationGroups = collect($overdueObservations)
            ->groupBy(function ($item) {
                return (string) ($item->engagement_uuid ?:
                'engagement-' . ($item->engagement_id ?? md5((string) ($item->engagement_name ?? 'unknown'))));
            })
            ->map(function ($items, $groupKey) {
                $first = $items->first();

                $detailItems = $items
                    ->sortBy(function ($item) {
                        return $item->response_due_date ?? ($item->due_date ?? '9999-12-31');
                    })
                    ->map(function ($item) {
                        $targetDate = $item->response_due_date ?? $item->due_date;
                        $ageingDays = 0;

                        if (!empty($targetDate)) {
                            $ageingDays =
                                \Carbon\Carbon::parse($targetDate)
                                    ->startOfDay()
                                    ->diffInDays(now()->startOfDay()) + 1;
                        }

                        $riskBucket = strtolower(trim((string) ($item->risk_grading ?? '')));
                        if (in_array($riskBucket, ['critical', 'high', 'l1'], true)) {
                            $riskBucket = 'high';
                        } elseif ($riskBucket === 'medium') {
                            $riskBucket = 'medium';
                        } elseif ($riskBucket === 'low') {
                            $riskBucket = 'low';
                        } else {
                            $riskBucket = 'other';
                        }

                        return [
                            'uuid' => $item->uuid,
                            'title' => $item->name ?? 'N/A',
                            'description' =>
                                trim(strip_tags(html_entity_decode((string) ($item->description ?? '')))) ?: 'N/A',
                            'target_date' => $targetDate ?? 'N/A',
                            'status' => $item->status ?? 'N/A',
                            'owner' => $item->owner_name ?? 'N/A',
                            'ageing_days' => $ageingDays,
                            'risk_bucket' => $riskBucket,
                        ];
                    })
                    ->values();

                return [
                    'group_key' => (string) $groupKey,
                    'engagement_name' => $first->engagement_name ?? 'N/A',
                    'engagement_uuid' => $first->engagement_uuid,
                    'high_count' => $detailItems->where('risk_bucket', 'high')->count(),
                    'medium_count' => $detailItems->where('risk_bucket', 'medium')->count(),
                    'low_count' => $detailItems->where('risk_bucket', 'low')->count(),
                    'total_count' => $detailItems->count(),
                    'details' => $detailItems,
                ];
            })
            ->sortBy('engagement_name', SORT_NATURAL | SORT_FLAG_CASE)
            ->values();
    @endphp


    <div class="d-print-none">

        @include('dashboard-components.atr-dashboard-filters')
    </div>

    @include('atrdashboardcount')

    <div class="atrdashboard-modern" id="atr-dynamic-modules">
        <!-- Removed redundant 4 KPI cards -->
        <div class="row mt-3">
            <div class="col-12 mb-1">
                <div class="card border-0 shadow-sm" style="border-radius: 12px; border: 1px solid #f1f5f9 !important;">

                    <!-- Main Header -->
                    <div class="card-header d-flex justify-content-between align-items-center border-0 bg-white"
                        style="padding: 20px 24px; border-bottom: 1px solid #f8fafc !important;">
                        <h5 class="mb-0" style="color: #334155; font-weight: 600; font-size: 16px;">Total Observation
                            Count</h5>

                    </div>

                    <div class="card-body row px-4 pb-2 pt-2">
                        <!-- By Risk Level -->
                        <div class="col-md-6 mb-md-0 d-flex mb-1">
                            <section class="card w-100 h-100 border shadow-none"
                                style="border-radius: 10px; border-color: #f1f5f9 !important; background: #ffffff;"
                                id="riskLevelPanel">
                                <div class="card-header d-flex justify-content-between align-items-center border-0 bg-white"
                                    style="padding: 16px 20px;">
                                    <span style="color: #475569; font-weight: 600; font-size: 14px;">By Risk Level</span>
                                    <div class="gd-toolbar">
                                        <!-- Toggle View -->
                                        <button type="button" onclick="toggleRiskLevelView(this)" class="icon-btn"
                                            title="Toggle View">
                                            <i class="ri-layout-grid-line"></i>
                                        </button>

                                        <!-- View Details -->
                                        <button type="button" class="icon-btn" data-bs-toggle="offcanvas"
                                            data-bs-target="#riskLevelOffcanvas" aria-controls="riskLevelOffcanvas"
                                            title="View Details">
                                            <i class="ri-external-link-line"></i>
                                        </button>

                                        <!-- More Options -->
                                        <div class="dropdown">
                                            <button type="button" class="icon-btn" data-bs-toggle="dropdown"
                                                aria-expanded="false" title="More Options">
                                                <i class="ri-menu-2-line"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end border-0 shadow"
                                                style="border-radius: 12px; padding: 0.5rem;">
                                                <a class="dropdown-item modern-dropdown-item px-3 py-2"
                                                    href="javascript:void(0);"
                                                    onclick="downloadTableAsCSV('riskLevelExportTable', 'observations_by_risk_level.csv')">
                                                    <i class="ri-file-list-2-line me-2"></i> Download CSV
                                                </a>
                                                <a class="dropdown-item modern-dropdown-item chart-export-option px-3 py-2"
                                                    href="javascript:void(0);"
                                                    onclick="exportApexChart('observationByRiskRatingPieChart', 'png')">
                                                    <i class="ri-image-line me-2"></i> Download PNG
                                                </a>
                                                <a class="dropdown-item modern-dropdown-item chart-export-option px-3 py-2"
                                                    href="javascript:void(0);"
                                                    onclick="exportApexChart('observationByRiskRatingPieChart', 'svg')">
                                                    <i class="ri-code-box-line me-2"></i> Download SVG
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="riskLevelChartView" class="gd-panel-toggle-view is-active">
                                    <div class="card-body d-flex justify-content-center align-items-center"
                                        style="min-height: 280px;" id="observationByRiskRatingPieChart">
                                    </div>
                                </div>
                                <div id="riskLevelTableView" class="gd-panel-toggle-view">
                                    <div class="card-body p-0" style="height: 350px; overflow: auto !important;">
                                        @if (count($byRiskLevel) > 0)
                                            <table class="reportTable w-100" id="riskLevelExportTable"
                                                style="min-width: 700px;">
                                                <thead>
                                                    <tr>
                                                        <th
                                                            style="font-size: 11px !important; color: #64748b !important; text-transform: uppercase !important; white-space: normal !important; min-width: 120px; max-width: 160px;">
                                                            Engagement Name</th>
                                                        <th
                                                            style="font-size: 11px !important; color: #64748b !important; text-transform: uppercase !important; white-space: normal !important; min-width: 120px; max-width: 160px;">
                                                            Observation Title</th>
                                                        <th
                                                            style="font-size: 11px !important; color: #64748b !important; text-transform: uppercase !important; white-space: nowrap !important;">
                                                            Risk Grading</th>
                                                        <th
                                                            style="font-size: 11px !important; color: #64748b !important; text-transform: uppercase !important; white-space: nowrap !important;">
                                                            Target Date</th>
                                                        <th
                                                            style="font-size: 11px !important; color: #64748b !important; text-transform: uppercase !important; white-space: nowrap !important;">
                                                            Owner</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($byRiskLevel as $data)
                                                        @php
                                                            $status = strtolower(trim($data->status ?? ''));
                                                            $risk = strtolower(trim($data->risk_grading ?? ''));
                                                            if (in_array($risk, ['critical', 'l1'])) {
                                                                $risk = 'high';
                                                            }

                                                            $statusStyle =
                                                                $statusStyles[$status] ??
                                                                'background-color:#e5e7eb; color:#374151;';
                                                            $riskStyle =
                                                                $riskStyles[$risk] ??
                                                                'background-color:#e5e7eb; color:#374151;';
                                                        @endphp

                                                        <tr>
                                                            <td
                                                                style="min-width: 120px; max-width: 160px; white-space: normal; word-break: break-word;">
                                                                <a href="{{ !empty($data->engagement_uuid) ? route('admin.engagements.show', $data->engagement_uuid) : 'javascript:void(0);' }}"
                                                                    style="font-size: 14px;">
                                                                    {{ \Illuminate\Support\Str::limit($data->engagement_name, 35, '...') ?? 'N/A' }}
                                                                </a>
                                                            </td>

                                                            <td
                                                                style="min-width: 120px; max-width: 160px; white-space: normal; word-break: break-word;">
                                                                <a href="javascript:void(0);" class="actionHandler"
                                                                    data-url="{{ route('admin.atrobservation.show', $data->uuid) }}"
                                                                    style="font-size: 14px;">
                                                                    {{ $data->name ?? 'N/A' }}
                                                                </a>
                                                            </td>

                                                            <td>
                                                                <span class="badge" style="{{ $riskStyle }}">
                                                                    {{ ucfirst($risk) }}
                                                                </span>
                                                            </td>

                                                            <td style="font-size: 13px; white-space: nowrap;">
                                                                {{ $data->response_due_date ?? 'N/A' }}
                                                            </td>

                                                            <td style="font-size: 13px;">
                                                                {{ $data->owner_name ?? 'N/A' }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @else
                                            <div class="d-flex align-items-center justify-content-center h-100">
                                                <div class="text-muted text-center">
                                                    <i class="ri-pie-chart-2-line fs-1 mb-2 opacity-50"></i>
                                                    <p class="fw-medium m-0">No Data Available</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </section>
                        </div>

                        <!-- By Status -->
                        <div class="col-md-6 d-flex">
                            <section class="card w-100 h-100 border shadow-none"
                                style="border-radius: 10px; border-color: #f1f5f9 !important; background: #ffffff;"
                                id="obsStatusPanel">
                                <div class="card-header d-flex justify-content-between align-items-center border-0 bg-white"
                                    style="padding: 16px 20px;">
                                    <span style="color: #475569; font-weight: 600; font-size: 14px;">By Status</span>
                                    <div class="gd-toolbar">
                                        <button type="button" onclick="toggleObsStatusView(this)" class="icon-btn"
                                            title="Toggle View">
                                            <i class="ri-layout-grid-line"></i>
                                        </button>
                                        <button type="button" class="icon-btn" data-bs-toggle="offcanvas"
                                            data-bs-target="#obsStatusOffcanvas" aria-controls="obsStatusOffcanvas"
                                            title="View Details">
                                            <i class="ri-external-link-line"></i>
                                        </button>
                                        <div class="dropdown">
                                            <button type="button" class="icon-btn" data-bs-toggle="dropdown"
                                                aria-expanded="false" title="More Options">
                                                <i class="ri-menu-2-line"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end border-0 shadow"
                                                style="border-radius: 12px; padding: 0.5rem;">
                                                <a class="dropdown-item modern-dropdown-item px-3 py-2"
                                                    href="javascript:void(0);"
                                                    onclick="downloadTableAsCSV('obsStatusExportTable', 'observations_by_status.csv')">
                                                    <i class="ri-file-list-2-line me-2"></i> Download CSV
                                                </a>
                                                <a class="dropdown-item modern-dropdown-item px-3 py-2"
                                                    href="javascript:void(0);"
                                                    onclick="exportApexChart('observationstatusPieChart', 'png')">
                                                    <i class="ri-image-line me-2"></i> Download PNG
                                                </a>
                                                <a class="dropdown-item modern-dropdown-item px-3 py-2"
                                                    href="javascript:void(0);"
                                                    onclick="exportApexChart('observationstatusPieChart', 'svg')">
                                                    <i class="ri-code-box-line me-2"></i> Download SVG
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="obsStatusChartView" class="gd-panel-toggle-view is-active">
                                    <div class="card-body d-flex justify-content-center align-items-center"
                                        style="min-height: 280px;" id="observationstatusPieChart">
                                    </div>
                                </div>
                                <div id="obsStatusTableView" class="gd-panel-toggle-view">
                                    <div class="card-body p-0" style="height: 350px; overflow: auto !important;">
                                        @if (count($byStatus) > 0)
                                            <table class="reportTable w-100" id="obsStatusExportTable"
                                                style="min-width: 700px;">
                                                <thead>
                                                    <tr>
                                                        <th
                                                            style="font-size: 11px !important; color: #64748b !important; text-transform: uppercase !important; white-space: normal !important; min-width: 120px; max-width: 160px;">
                                                            Engagement Name</th>
                                                        <th
                                                            style="font-size: 11px !important; color: #64748b !important; text-transform: uppercase !important; white-space: normal !important; min-width: 120px; max-width: 160px;">
                                                            Observation Title</th>
                                                        <th
                                                            style="font-size: 11px !important; color: #64748b !important; text-transform: uppercase !important; white-space: nowrap !important;">
                                                            Risk Grading</th>
                                                        <th
                                                            style="font-size: 11px !important; color: #64748b !important; text-transform: uppercase !important; white-space: nowrap !important;">
                                                            Status</th>
                                                        <th
                                                            style="font-size: 11px !important; color: #64748b !important; text-transform: uppercase !important; white-space: nowrap !important;">
                                                            Target Date</th>
                                                        <th
                                                            style="font-size: 11px !important; color: #64748b !important; text-transform: uppercase !important; white-space: nowrap !important;">
                                                            Owner</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($byStatus as $data)
                                                        @php
                                                            $status = strtolower(trim($data->status ?? ''));
                                                            $risk = strtolower(trim($data->risk_grading ?? ''));
                                                            if (in_array($risk, ['critical', 'l1'])) {
                                                                $risk = 'high';
                                                            }

                                                            $statusStyle =
                                                                $statusStyles[$status] ??
                                                                'background-color:#e5e7eb; color:#374151;';
                                                            $riskStyle =
                                                                $riskStyles[$risk] ??
                                                                'background-color:#e5e7eb; color:#374151;';
                                                        @endphp

                                                        <tr>
                                                            <td
                                                                style="min-width: 120px; max-width: 160px; white-space: normal; word-break: break-word;">
                                                                <a href="{{ !empty($data->engagement_uuid) ? route('admin.engagements.show', $data->engagement_uuid) : 'javascript:void(0);' }}"
                                                                    style="font-size: 14px;">
                                                                    {{ \Illuminate\Support\Str::limit($data->engagement_name, 35, '...') ?? 'N/A' }}
                                                                </a>
                                                            </td>

                                                            <td
                                                                style="min-width: 120px; max-width: 160px; white-space: normal; word-break: break-word;">
                                                                <a href="javascript:void(0);" class="actionHandler"
                                                                    data-url="{{ route('admin.atrobservation.show', $data->uuid) }}"
                                                                    style="font-size: 14px;">
                                                                    {{ $data->name ?? 'N/A' }}
                                                                </a>
                                                            </td>

                                                            <td>
                                                                <span class="badge" style="{{ $riskStyle }}">
                                                                    {{ ucfirst($risk ?: 'N/A') }}
                                                                </span>
                                                            </td>

                                                            <td>
                                                                <span class="badge" style="{{ $statusStyle }}">
                                                                    {{ ucfirst($data->status) }}
                                                                </span>
                                                            </td>

                                                            <td style="font-size: 13px; white-space: nowrap;">
                                                                {{ $data->response_due_date ?? 'N/A' }}
                                                            </td>

                                                            <td style="font-size: 13px;">
                                                                {{ $data->owner_name ?? 'N/A' }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @else
                                            <div class="d-flex align-items-center justify-content-center h-100">
                                                <div class="text-muted text-center">
                                                    <i class="ri-pie-chart-2-line fs-1 mb-2 opacity-50"></i>
                                                    <p class="fw-medium m-0">No Data Available</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Module 2: Sub-observation & Overdue Observations -->
        <div class="row mb-1">
            <!-- Left Card -->
            <div class="col-md-6 mb-md-0 d-flex mb-1">
                <section class="card w-100 h-100 border shadow-sm"
                    style="border-radius: 12px; border-color: #f1f5f9 !important; background: #ffffff;"
                    id="subObsStatusPanel">
                    <div class="card-header d-flex justify-content-between align-items-center border-0 bg-white"
                        style="padding: 20px 24px;">
                        <span style="color: #334155; font-weight: 600; font-size: 15px;">Sub-observation by Status</span>
                        <div class="gd-toolbar">
                            <button type="button" onclick="toggleSubObsStatusView(this)" class="icon-btn"
                                title="Toggle View">
                                <i class="ri-layout-grid-line"></i>
                            </button>
                            <button type="button" class="icon-btn" data-bs-toggle="offcanvas"
                                data-bs-target="#subObsStatusOffcanvas" aria-controls="subObsStatusOffcanvas"
                                title="View Details">
                                <i class="ri-external-link-line"></i>
                            </button>
                            <div class="dropdown">
                                <button type="button" class="icon-btn" data-bs-toggle="dropdown" aria-expanded="false"
                                    title="More Options">
                                    <i class="ri-menu-2-line"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end border-0 shadow"
                                    style="border-radius: 12px; padding: 0.5rem;">
                                    <a class="dropdown-item modern-dropdown-item px-3 py-2" href="javascript:void(0);"
                                        onclick="downloadTableAsCSV('subObsStatusExportTable', 'sub_observations_by_status.csv')">
                                        <i class="ri-file-list-2-line me-2"></i> Download CSV
                                    </a>
                                    <a class="dropdown-item modern-dropdown-item px-3 py-2" href="javascript:void(0);"
                                        onclick="exportApexChart('atractionablestatusPieChart', 'png')">
                                        <i class="ri-image-line me-2"></i> Download PNG
                                    </a>
                                    <a class="dropdown-item modern-dropdown-item px-3 py-2" href="javascript:void(0);"
                                        onclick="exportApexChart('atractionablestatusPieChart', 'svg')">
                                        <i class="ri-code-box-line me-2"></i> Download SVG
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="subObsStatusChartView" class="gd-panel-toggle-view is-active">
                        <div class="card-body d-flex justify-content-center align-items-center" style="min-height: 320px;"
                            id="atractionablestatusPieChart">
                        </div>
                    </div>
                    <div id="subObsStatusTableView" class="gd-panel-toggle-view">
                        <div class="card-body p-0" style="height: 350px; overflow: auto !important;">
                            @if (count($subobservationbyStatus ?? []) > 0)
                                <table class="reportTable w-100" id="subObsStatusExportTable" style="min-width: 800px;">
                                    <thead>
                                        <tr>
                                            <th
                                                style="font-size: 11px !important; color: #64748b !important; text-transform: uppercase !important; white-space: normal !important; min-width: 120px; max-width: 160px;">
                                                Observation Name</th>
                                            <th
                                                style="font-size: 11px !important; color: #64748b !important; text-transform: uppercase !important; white-space: normal !important; min-width: 120px; max-width: 160px;">
                                                Sub-Observation Name</th>
                                            <th
                                                style="font-size: 11px !important; color: #64748b !important; text-transform: uppercase !important; white-space: nowrap !important;">
                                                Owner</th>
                                            <th
                                                style="font-size: 11px !important; color: #64748b !important; text-transform: uppercase !important; white-space: nowrap !important;">
                                                Status</th>
                                            <th
                                                style="font-size: 11px !important; color: #64748b !important; text-transform: uppercase !important; white-space: nowrap !important;">
                                                Target Date</th>
                                            <th style="font-size: 11px !important; color: #64748b !important; text-transform: uppercase !important; white-space: nowrap !important;"
                                                class="text-center">Ageing (days)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($subobservationbyStatus as $subobservation)
                                            @php
                                                $status = strtolower(trim($subobservation->status ?? ''));

                                                $statusStyle =
                                                    $openClosed[$status] ?? 'background-color:#e5e7eb; color:#374151;';

                                            @endphp
                                            <tr>
                                                <td
                                                    style="min-width: 120px; max-width: 160px; white-space: normal; word-break: break-word;">
                                                    <a href="javascript:void(0);" class="actionHandler"
                                                        data-url="{{ route('admin.atrobservation.show', $subobservation->observation_uuid) }}"
                                                        style="font-size: 12px; font-weight: 500;">{{ \Illuminate\Support\Str::limit($subobservation->observations_name, 35, '...') ?? 'N/A' }}</a>
                                                </td>

                                                <td
                                                    style="min-width: 120px; max-width: 160px; white-space: normal; word-break: break-word;">
                                                    <a href="javascript:void(0);" class="actionHandler"
                                                        data-url="{{ route('admin.atrsubobservationshow', $subobservation->uuid) }}"
                                                        style="font-size: 12px; font-weight: 500;">{{ $subobservation->name ?? 'N/A' }}</a>
                                                </td>

                                                <td style="font-size: 12px; padding: 12px 10px !important;">
                                                    {{ $subobservation->owner_name ?? 'N/A' }}</td>
                                                <td>
                                                    <span class="badge"
                                                        style="{{ $statusStyle }} padding: 6px 12px; font-weight: 500; font-size: 11px;">
                                                        {{ ucfirst($subobservation->status) }}
                                                    </span>
                                                </td>

                                                <td
                                                    style="font-size: 12px; color: #64748b; padding: 12px 10px !important;">
                                                    {{ $subobservation->response_due_date ?? 'N/A' }}</td>

                                                <td class="text-center" style="padding: 12px 10px !important;">
                                                    @php
                                                        $dueDate = Carbon\Carbon::parse(
                                                            $subobservation->response_due_date ??
                                                                $subobservation->due_date,
                                                        );
                                                        $today = Carbon\Carbon::today();
                                                        $diffInDays = $today->diffInDays($dueDate);
                                                        if ($today->greaterThan($dueDate)) {
                                                            $diffInDays += 1;
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
                                    </tbody>
                                </table>
                            @else
                                <div class="d-flex align-items-center justify-content-center h-100">
                                    <div class="text-muted text-center">
                                        <i class="ri-pie-chart-2-line fs-1 mb-2 opacity-50"></i>
                                        <p class="fw-medium m-0">No Data Available</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </section>
            </div>

            <!-- Right Card working -->
            <div class="col-md-6 d-flex">
                <div class="card w-100 h-100 border shadow-sm dashboard-matrix-card"
                    style="border-radius: 12px; border-color: #f1f5f9 !important; background: #ffffff;">
                    <div class="card-header d-flex justify-content-between align-items-center border-0 bg-white"
                        style="padding: 20px 24px; border-bottom: 0 !important;">
                        <span style="color: #334155; font-weight: 600; font-size: 15px;">Overdue Observations</span>
                        <div class="gd-toolbar">
                            <div class="dropdown">
                                <button type="button" class="icon-btn" data-bs-toggle="dropdown" aria-expanded="false"
                                    title="More Options">
                                    <i class="ri-menu-2-line"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end border-0 shadow"
                                    style="border-radius: 12px; padding: 0.5rem;">
                                    <a class="dropdown-item modern-dropdown-item px-3 py-2" href="javascript:void(0);"
                                        onclick="downloadTableAsCSV('overdueObservationsTable', 'overdue_observations.csv')">
                                        <i class="ri-file-list-2-line me-2"></i> Download CSV
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0" style="overflow-y: auto !important; height: 350px;">
                        @if ($overdueObservationGroups->count() > 0)
                            <table class="dashboard-matrix-table" id="overdueObservationsTable">
                                <thead>
                                    <tr>
                                        <th>Engagement Name</th>
                                        <th class="text-center">High</th>
                                        <th class="text-center">Medium</th>
                                        <th class="text-center">Low</th>
                                        <th class="text-center">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($overdueObservationGroups as $group)
                                        <tr>
                                            <td>
                                                <a href="javascript:void(0);" class="dashboard-matrix-link"
                                                    onclick="openOverdueObservationPanel('{{ $group['group_key'] }}', 'all')">
                                                    {{ \Illuminate\Support\Str::limit($group['engagement_name'], 35, '...') }}
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <button type="button"
                                                    class="dashboard-metric-pill dashboard-metric-pill--danger {{ $group['high_count'] > 0 ? 'is-clickable' : '' }}"
                                                    onclick="openOverdueObservationPanel('{{ $group['group_key'] }}', 'all')"
                                                    {{ $group['high_count'] > 0 ? "onclick=\"openOverdueObservationPanel('{$group['group_key']}', 'high')\"" : 'disabled' }}>
                                                    {{ $group['high_count'] }}
                                                </button>
                                            </td>
                                            <td class="text-center">
                                                <button type="button"
                                                    class="dashboard-metric-pill dashboard-metric-pill--warning {{ $group['medium_count'] > 0 ? 'is-clickable' : '' }}"
                                                    onclick="openOverdueObservationPanel('{{ $group['group_key'] }}', 'all')"
                                                    {{ $group['medium_count'] > 0 ? "onclick=\"openOverdueObservationPanel('{$group['group_key']}', 'medium')\"" : 'disabled' }}>
                                                    {{ $group['medium_count'] }}
                                                </button>
                                            </td>
                                            <td class="text-center">
                                                <button type="button"
                                                    class="dashboard-metric-pill dashboard-metric-pill--success {{ $group['low_count'] > 0 ? 'is-clickable' : '' }}"
                                                    onclick="openOverdueObservationPanel('{{ $group['group_key'] }}', 'all')"
                                                    {{ $group['low_count'] > 0 ? "onclick=\"openOverdueObservationPanel('{$group['group_key']}', 'low')\"" : 'disabled' }}>
                                                    {{ $group['low_count'] }}
                                                </button>
                                            </td>
                                            <td class="text-center">
                                                <button type="button"
                                                    class="dashboard-metric-pill dashboard-metric-pill--secondary {{ $group['total_count'] > 0 ? 'is-clickable' : '' }}"
                                                    onclick="openOverdueObservationPanel('{{ $group['group_key'] }}', 'all')"
                                                    {{ $group['total_count'] > 0 ? "onclick=\"openOverdueObservationPanel('{$group['group_key']}', 'all')\"" : 'disabled' }}>
                                                    {{ $group['total_count'] }}
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="d-flex align-items-center justify-content-center h-100">
                                <div class="text-muted text-center">
                                    <i class="ri-pie-chart-2-line fs-1 mb-2 opacity-50"></i>
                                    <p class="fw-medium m-0">No Data Available</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Module 3: Engagement-wise & Department-wise Risk Count -->
        <div class="row mb-3">
            <!-- Left Card: Engagement-wise -->
            <div class="col-md-6 mb-md-0 d-flex mb-3">
                <div class="card w-100 h-100 border shadow-sm"
                    style="border-radius: 12px; border-color: #f1f5f9 !important; background: #ffffff;">
                    <div class="card-header d-flex justify-content-between align-items-center border-0 bg-white"
                        style="padding: 20px 24px;">
                        <span style="color: #334155; font-weight: 600; font-size: 15px;">Engagement-wise Risk Count</span>
                        <div class="d-flex text-muted gd-toolbar">
                            <div class="dropdown">
                                <button type="button" class="icon-btn" data-bs-toggle="dropdown" aria-expanded="false"
                                    title="More Options">
                                    <i class="ri-menu-2-line"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end border-0 shadow"
                                    style="border-radius: 12px; padding: 0.5rem;">
                                    <a class="dropdown-item modern-dropdown-item px-3 py-2" href="javascript:void(0);"
                                        onclick="downloadTableAsCSV('engagementRiskTable', 'engagement_wise_risk_count.csv')">
                                        <i class="ri-file-list-2-line me-2"></i> Download CSV
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-4 pb-4 pt-0">
                        @php
                            $totalObservations =
                                ($riskCounts['high'] ?? 0) + ($riskCounts['medium'] ?? 0) + ($riskCounts['low'] ?? 0);

                            $engagements = $overdueObservations->pluck('engagement_name')->unique();
                            $engagementCoun = $engagements->count();
                        @endphp
                        <!-- Custom Select -->
                        <div class="custom-select-wrapper"
                            style="position: relative; margin-top: 8px; margin-bottom: 16px;">
                            <label
                                style="position: absolute; top: -8px; left: 12px; background: white; padding: 0 4px; font-size: 11px; color: #64748b; z-index: 2;">Engagement</label>
                            <div onclick="this.nextElementSibling.classList.toggle('d-none')"
                                class="custom-select-display">
                                <div class="selected-tags-container"
                                    style="display: flex; flex-wrap: wrap; gap: 4px; flex: 1;">
                                    <span style="font-size: 13px; color: #334155;">{{ $engagementCoun }} Engagements
                                        Selected</span>
                                </div>
                                <i class="ri-arrow-down-s-line" style="color: #94a3b8; font-size: 16px;"></i>
                            </div>
                            <!-- Dropdown Menu -->
                            <div class="custom-dropdown-menu d-none"
                                style="position: absolute; top: 100%; left: 0; right: 0; background: white; border: 1px solid #e2e8f0; border-radius: 8px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05); margin-top: 4px; z-index: 10; padding: 8px 0; max-height: 250px; overflow-y: auto;">
                                <label
                                    style="display: flex; align-items: center; gap: 12px; padding: 10px 16px; cursor: pointer;">
                                    <input type="checkbox" id="engagement-all" checked
                                        style="width: 16px; height: 16px; accent-color: #3b82f6; cursor: pointer;">
                                    <span style="font-size: 13px; font-weight: 600; color: #334155;">All</span>
                                </label>
                                {{-- <hr style="margin: 4px 0;"> --}}
                                @foreach ($engagements as $engagement)
                                    <label
                                        style="display: flex; align-items: center; gap: 12px; padding: 10px 16px; cursor: pointer; margin-bottom: 0; font-weight: normal;"
                                        onmouseover="this.style.background='#f8fafc'"
                                        onmouseout="this.style.background='white'">
                                        <input type="checkbox" class="engagement-filter"
                                            value="{{ strtolower(trim($engagement)) }}" data-name="{{ $engagement }}"
                                            checked
                                            style="width: 16px; height: 16px; accent-color: #3b82f6; cursor: pointer;">
                                        <span style="font-size: 13px; color: #334155;"> {{ $engagement }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div style="font-size: 11px; color: #64748b; margin-bottom: 16px;">
                            Showing <span id="showingCount">{{ $totalObservations }}</span> of {{ $totalObservations }}
                            observations
                        </div>

                        <!-- Tabs -->
                        <div
                            style="width: 100%; overflow-x: auto; border-bottom: 1px solid #f1f5f9; margin-bottom: 16px; -webkit-overflow-scrolling: touch;">
                            <div class="d-flex align-items-center"
                                style="gap: 24px; white-space: nowrap; padding-right: 24px; padding-bottom: 4px;">
                                <div onclick="handleRiskTab(this, 'All')" data-risk="all"
                                    style="padding-bottom: 12px; border-bottom: 2px solid #ef4444; color: #ef4444; font-size: 13px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 6px; flex-shrink: 0;">

                                    All
                                    <span class="count-all"
                                        style="background: #fee2e2; color: #ef4444; font-size: 10px; padding: 1px 6px; border-radius: 12px; font-weight: 600;">
                                        {{ $totalObservations }}
                                    </span>
                                </div>
                                <div onclick="handleRiskTab(this, 'High')" data-risk="high"
                                    style="padding-bottom: 12px; border-bottom: 2px solid transparent; color: #64748b; font-size: 13px; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 6px; flex-shrink: 0;">
                                    High <span class="count-high"
                                        style="background: #f1f5f9; color: #64748b; font-size: 10px; padding: 1px 6px; border-radius: 12px; font-weight: 600;">{{ $riskCounts['high'] ?? 0 }}</span>
                                </div>
                                <div onclick="handleRiskTab(this, 'Medium')" data-risk="medium"
                                    style="padding-bottom: 12px; border-bottom: 2px solid transparent; color: #64748b; font-size: 13px; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 6px; flex-shrink: 0;">
                                    Medium <span class="count-medium"
                                        style="background: #f1f5f9; color: #64748b; font-size: 10px; padding: 1px 6px; border-radius: 12px; font-weight: 600;">{{ $riskCounts['medium'] ?? 0 }}</span>
                                </div>
                                <div onclick="handleRiskTab(this, 'Low')" data-risk="low"
                                    style="padding-bottom: 12px; border-bottom: 2px solid transparent; color: #64748b; font-size: 13px; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 6px; flex-shrink: 0;">
                                    Low <span class="count-low"
                                        style="background: #f1f5f9; color: #64748b; font-size: 10px; padding: 1px 6px; border-radius: 12px; font-weight: 600;">{{ $riskCounts['low'] ?? 0 }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Table -->
                        <!-- Table Container -->
                        <div id="engagementTableContainer">
                            <div class="rounded-3 border"
                                style="border: 1px solid #cbd5e1 !important; border-radius: 8px; overflow: hidden !important;">
                                <div style="height: 350px; overflow-y: auto; overflow-x: auto;">
                                    <table class="w-100 mb-0 table" style="min-width: 800px; table-layout: auto;"
                                        id="engagementRiskTable">
                                        <thead style="background-color: #f8fafc; position: sticky; top: 0; z-index: 1;">
                                            <tr>
                                                <th class="d-none"
                                                    style="width: 55px; min-width: 55px; white-space: nowrap; font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; padding: 12px; border-bottom: 2px solid #e2e8f0;">
                                                    SN</th>
                                                <th
                                                    style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; padding: 12px; border-bottom: 2px solid #e2e8f0; white-space: normal !important; min-width: 120px; max-width: 160px;">
                                                    Engagement Name</th>
                                                <th
                                                    style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; padding: 12px; border-bottom: 2px solid #e2e8f0; white-space: normal !important; min-width: 120px; max-width: 160px;">
                                                    Observation</th>
                                                <th
                                                    style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; padding: 12px; border-bottom: 2px solid #e2e8f0;">
                                                    Risk Grading</th>
                                                <th
                                                    style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; padding: 12px; border-bottom: 2px solid #e2e8f0;">
                                                    Status</th>
                                                <th
                                                    style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; padding: 12px; border-bottom: 2px solid #e2e8f0;">
                                                    Assignee</th>
                                                <th
                                                    style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; padding: 12px; border-bottom: 2px solid #e2e8f0;">
                                                    Target Date</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($byRiskLevel as $key => $overdueObservation)
                                                @php
                                                    $status = strtolower(trim($overdueObservation->status ?? ''));
                                                    $risk = strtolower(trim($overdueObservation->risk_grading ?? ''));
                                                    if (in_array($risk, ['critical', 'l1'])) {
                                                        $risk = 'high';
                                                    }

                                                    $statusStyle =
                                                        $statusStyles[$status] ??
                                                        'background-color:#e5e7eb; color:#374151;';
                                                    $riskStyle =
                                                        $riskStyles[$risk] ??
                                                        'background-color:#e5e7eb; color:#374151;';
                                                @endphp
                                                <tr data-risk="{{ in_array(strtolower(trim($overdueObservation->risk_grading ?? '')), ['critical', 'l1']) ? 'high' : strtolower(trim($overdueObservation->risk_grading ?? '')) }}"
                                                    data-engagement="{{ strtolower(trim($overdueObservation->engagement_name)) }}">
                                                    <td class="d-none"
                                                        style="width: 55px; min-width: 55px; white-space: nowrap; font-size: 12px; color: #64748b; padding: 12px; border-bottom: 1px solid #f8fafc;">
                                                        {{ $key + 1 }}</td>

                                                    <td
                                                        style="padding: 12px; min-width: 120px; max-width: 160px; white-space: normal; word-break: break-word; border-bottom: 1px solid #f8fafc;">
                                                        <a href="{{ !empty($overdueObservation->engagement_uuid) ? route('admin.engagements.show', $overdueObservation->engagement_uuid) : 'javascript:void(0);' }}"
                                                            style="font-size: 13px; font-weight: 500; color: #2563eb; text-decoration: none;">{{ \Illuminate\Support\Str::limit($overdueObservation->engagement_name, 35, '...') ?? 'N/A' }}</a>
                                                    </td>

                                                    <td
                                                        style="padding: 12px; min-width: 120px; max-width: 160px; white-space: normal; word-break: break-word; border-bottom: 1px solid #f8fafc;">
                                                        <a href="javascript:void(0);" class="actionHandler"
                                                            data-url="{{ route('admin.atrobservation.show', $overdueObservation->uuid) }}"
                                                            style="font-size: 13px; font-weight: 500; color: #2563eb; text-decoration: none;">{{ $overdueObservation->name ?? 'N/A' }}</a>
                                                    </td>

                                                    <td style="padding: 12px; border-bottom: 1px solid #f8fafc;"><span
                                                            style="{{ $riskStyle }} font-size: 10px; padding: 3px 8px; border-radius: 4px; font-weight: 500;">
                                                            {{ ucfirst($risk ?: 'N/A') }}</span>
                                                    </td>

                                                    <td style="padding: 12px; border-bottom: 1px solid #f8fafc;"><span
                                                            style="{{ $statusStyle }} font-size: 10px; padding: 3px 8px; border-radius: 4px; font-weight: 500;">
                                                            {{ ucfirst($overdueObservation->status) }}</span>
                                                    </td>

                                                    <td
                                                        style="font-size: 12px; color: #475569; padding: 12px; border-bottom: 1px solid #f8fafc;">
                                                        {{ $overdueObservation->owner_name ?? 'N/A' }}</td>


                                                    <td
                                                        style="font-size: 12px; color: #64748b; padding: 12px; border-bottom: 1px solid #f8fafc;">
                                                        {{ $overdueObservation->response_due_date ?? 'N/A' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- No Data Placeholder -->
                        <div id="engagementNoDataPlaceholder" class="d-none">
                            <div class="d-flex align-items-center justify-content-center" style="height: 350px;">
                                <div class="text-muted text-center">
                                    <i class="ri-pie-chart-2-line fs-1 mb-2 opacity-50"></i>
                                    <p class="fw-medium m-0">No Data Available</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Right Card: Department-wise -->
            <div class="col-md-6 d-flex">
                <div class="card w-100 h-100 border shadow-sm"
                    style="border-radius: 12px; border-color: #f1f5f9 !important; background: #ffffff;">
                    <div class="card-header d-flex justify-content-between align-items-center border-0 bg-white"
                        style="padding: 20px 24px;">
                        <span style="color: #334155; font-weight: 600; font-size: 15px;">Department-wise Risk Count</span>
                        <div class="d-flex text-muted gd-toolbar">
                            <div class="dropdown">
                                <button type="button" class="icon-btn" data-bs-toggle="dropdown" aria-expanded="false"
                                    title="More Options">
                                    <i class="ri-menu-2-line"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end border-0 shadow"
                                    style="border-radius: 12px; padding: 0.5rem;">
                                    <a class="dropdown-item modern-dropdown-item px-3 py-2" href="javascript:void(0);"
                                        onclick="downloadTableAsCSV('departmentRiskTable', 'department_wise_risk_count.csv')">
                                        <i class="ri-file-list-2-line me-2"></i> Download CSV
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-4 pb-4 pt-0">
                        @php
                            $totalObservationsdepartment =
                                ($departmentCounts['high'] ?? 0) +
                                ($departmentCounts['medium'] ?? 0) +
                                ($departmentCounts['low'] ?? 0);

                            $departmentname = $departmentwiseobservation->pluck('department_name')->unique();
                            // dd($departmentname);
                            $departmentnamecount = $departmentname->count();
                        @endphp
                        <!-- Custom Select -->
                        <div class="custom-select-wrapper"
                            style="position: relative; margin-top: 8px; margin-bottom: 16px;">
                            <label
                                style="position: absolute; top: -8px; left: 12px; background: white; padding: 0 4px; font-size: 11px; color: #64748b; z-index: 2;">Department</label>
                            <div onclick="this.nextElementSibling.classList.toggle('d-none')"
                                class="custom-select-display">
                                <div class="selected-tags-container"
                                    style="display: flex; flex-wrap: wrap; gap: 4px; flex: 1;">
                                    <span style="font-size: 13px; color: #334155;">{{ $departmentnamecount }} Departments
                                        Selected</span>
                                </div>
                                <i class="ri-arrow-down-s-line" style="color: #94a3b8; font-size: 16px;"></i>
                            </div>
                            <!-- Dropdown Menu (Hidden by default) -->
                            <div class="custom-dropdown-menu d-none"
                                style="position: absolute; top: 100%; left: 0; right: 0; background: white; border: 1px solid #e2e8f0; border-radius: 8px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05); margin-top: 4px; z-index: 10; padding: 8px 0; max-height: 250px; overflow-y: auto;">
                                <label
                                    style="display: flex; align-items: center; gap: 12px; padding: 10px 16px; cursor: pointer;">
                                    <input type="checkbox" id="department-all" checked
                                        style="width: 16px; height: 16px; accent-color: #3b82f6; cursor: pointer;">
                                    <span style="font-size: 13px; font-weight: 600; color: #334155;">All</span>
                                </label>
                                @foreach ($departmentname as $departmentnames)
                                    <label
                                        style="display: flex; align-items: center; gap: 12px; padding: 10px 16px; cursor: pointer; margin-bottom: 0; font-weight: normal;"
                                        onmouseover="this.style.background='#f8fafc'"
                                        onmouseout="this.style.background='white'">
                                        <input type="checkbox" class="department-filter"
                                            value="{{ strtolower(trim($departmentnames)) }}"
                                            data-name="{{ $departmentnames }}" checked
                                            style="width: 16px; height: 16px; accent-color: #3b82f6; cursor: pointer;">
                                        <span style="font-size: 13px; color: #334155;"> {{ $departmentnames }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div style="font-size: 11px; color: #64748b; margin-bottom: 16px;">Showing <span
                                id="deptShowingCount">0</span> of {{ $totalObservationsdepartment ?? 0 }} observations
                        </div>


                        <!-- Tabs -->
                        <div
                            style="width: 100%; overflow-x: auto; border-bottom: 1px solid #f1f5f9; margin-bottom: 16px; -webkit-overflow-scrolling: touch;">
                            <div class="d-flex align-items-center"
                                style="gap: 24px; white-space: nowrap; padding-right: 24px; padding-bottom: 4px;">
                                <div onclick="handleDeptRiskTab(this, 'All')" data-risk="all"
                                    style="padding-bottom: 12px; border-bottom: 2px solid #ef4444; color: #ef4444; font-size: 13px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 6px; flex-shrink: 0;">

                                    All
                                    <span class="dept-count-all"
                                        style="background: #fee2e2; color: #ef4444; font-size: 10px; padding: 1px 6px; border-radius: 12px; font-weight: 600;">
                                        {{ $totalObservationsdepartment }}
                                    </span>
                                </div>
                                <div onclick="handleDeptRiskTab(this, 'High')" data-risk="high"
                                    style="padding-bottom: 12px; border-bottom: 2px solid transparent; color: #64748b; font-size: 13px; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 6px; flex-shrink: 0;">
                                    High <span class="dept-count-high"
                                        style="background: #f1f5f9; color: #64748b; font-size: 10px; padding: 1px 6px; border-radius: 12px; font-weight: 600;">{{ $departmentCounts['high'] ?? 0 }}</span>
                                </div>
                                <div onclick="handleDeptRiskTab(this, 'Medium')" data-risk="medium"
                                    style="padding-bottom: 12px; border-bottom: 2px solid transparent; color: #64748b; font-size: 13px; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 6px; flex-shrink: 0;">
                                    Medium <span class="dept-count-medium"
                                        style="background: #f1f5f9; color: #64748b; font-size: 10px; padding: 1px 6px; border-radius: 12px; font-weight: 600;">{{ $departmentCounts['medium'] ?? 0 }}</span>
                                </div>
                                <div onclick="handleDeptRiskTab(this, 'Low')" data-risk="low"
                                    style="padding-bottom: 12px; border-bottom: 2px solid transparent; color: #64748b; font-size: 13px; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 6px; flex-shrink: 0;">
                                    Low <span class="dept-count-low"
                                        style="background: #f1f5f9; color: #64748b; font-size: 10px; padding: 1px 6px; border-radius: 12px; font-weight: 600;">{{ $departmentCounts['low'] ?? 0 }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Table Container -->
                        <div id="departmentTableContainer">
                            <div class="rounded-3 border"
                                style="border: 1px solid #cbd5e1 !important; border-radius: 8px; overflow: hidden !important;">
                                <div style="height: 350px; overflow-y: auto; overflow-x: auto;">
                                    <table class="w-100 mb-0 table" style="min-width: 900px; table-layout: auto;"
                                        id="departmentRiskTable">
                                        <thead style="background-color: #f8fafc; position: sticky; top: 0; z-index: 1;">
                                            <tr>
                                                <th class="d-none"
                                                    style="width: 55px; min-width: 55px; white-space: nowrap; font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; padding: 12px; border-bottom: 2px solid #e2e8f0;">
                                                    SN</th>
                                                <th
                                                    style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; padding: 12px; border-bottom: 2px solid #e2e8f0; white-space: normal !important; min-width: 120px; max-width: 160px;">
                                                    DEPARTMENT</th>

                                                <th
                                                    style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; padding: 12px; border-bottom: 2px solid #e2e8f0; white-space: normal !important; min-width: 120px; max-width: 160px;">
                                                    OBSERVATION</th>
                                                <th
                                                    style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; padding: 12px; border-bottom: 2px solid #e2e8f0;">
                                                    RISK GRADING</th>
                                                <th
                                                    style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; padding: 12px; border-bottom: 2px solid #e2e8f0;">
                                                    STATUS</th>
                                                <th
                                                    style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; padding: 12px; border-bottom: 2px solid #e2e8f0;">
                                                    ASSIGNEE</th>
                                                <th
                                                    style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; padding: 12px; border-bottom: 2px solid #e2e8f0;">
                                                    TARGET DATE</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($departmentwiseobservation as $departmentwiseobservations)
                                                @php
                                                    $status = strtolower(
                                                        trim($departmentwiseobservations->status ?? ''),
                                                    );
                                                    $risk = strtolower(
                                                        trim($departmentwiseobservations->risk_grading ?? ''),
                                                    );
                                                    if (in_array($risk, ['critical', 'l1'])) {
                                                        $risk = 'high';
                                                    }

                                                    $statusStyle =
                                                        $statusStyles[$status] ??
                                                        'background-color:#e5e7eb; color:#374151;';
                                                    $riskStyle =
                                                        $riskStyles[$risk] ??
                                                        'background-color:#e5e7eb; color:#374151;';
                                                @endphp
                                                <tr data-risk="{{ in_array(strtolower(trim($departmentwiseobservations->risk_grading ?? '')), ['critical', 'l1']) ? 'high' : strtolower(trim($departmentwiseobservations->risk_grading ?? '')) }}"
                                                    data-department="{{ strtolower(trim($departmentwiseobservations->department_name)) }}">
                                                    <td class="d-none"
                                                        style="width: 55px; min-width: 55px; font-size: 12px; color: #64748b; padding: 12px; border-bottom: 1px solid #f8fafc;">
                                                        1</td>

                                                    <td
                                                        style="padding: 12px; min-width: 120px; max-width: 160px; white-space: normal; word-break: break-word; border-bottom: 1px solid #f8fafc;">
                                                        <a href="{{ $canOpenGroupDepartment ? route('group.department.index') : 'javascript:void(0);' }}"
                                                            @unless ($canOpenGroupDepartment)
                                                            onclick="focusDepartmentRisk('{{ addslashes(strtolower(trim($departmentwiseobservations->department_name ?? ''))) }}')"
                                                            @endunless
                                                            style="font-size: 13px; font-weight: 500; color: #2563eb; text-decoration: none;">{{ \Illuminate\Support\Str::limit($departmentwiseobservations->department_name, 35, '...') ?? 'N/A' }}</a>
                                                    </td>

                                                    <td
                                                        style="padding: 12px; min-width: 120px; max-width: 160px; white-space: normal; word-break: break-word; border-bottom: 1px solid #f8fafc;">
                                                        <a href="javascript:void(0);" class="actionHandler"
                                                            data-url="{{ route('admin.atrobservation.show', $departmentwiseobservations->uuid) }}"
                                                            style="font-size: 13px; font-weight: 500; color: #2563eb; text-decoration: none;">{{ $departmentwiseobservations->name ?? 'N/A' }}</a>
                                                    </td>

                                                    <td style="padding: 12px; border-bottom: 1px solid #f8fafc;"><span
                                                            style="{{ $riskStyle }} font-size: 10px; padding: 3px 8px; border-radius: 4px; font-weight: 500;">
                                                            {{ ucfirst($risk ?: 'N/A') }}</span>
                                                    </td>

                                                    <td style="padding: 12px; border-bottom: 1px solid #f8fafc;"><span
                                                            style="{{ $statusStyle }} font-size: 10px; padding: 3px 8px; border-radius: 4px; font-weight: 500;">
                                                            {{ ucfirst($departmentwiseobservations->status) }}</span>
                                                    </td>

                                                    <td
                                                        style="font-size: 12px; color: #475569; padding: 12px; border-bottom: 1px solid #f8fafc;">
                                                        {{ $departmentwiseobservations->owner_name ?? 'N/A' }}</td>


                                                    <td
                                                        style="font-size: 12px; color: #64748b; padding: 12px; border-bottom: 1px solid #f8fafc;">
                                                        {{ $departmentwiseobservations->response_due_date ?? 'N/A' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- No Data Placeholder -->
                        <div id="departmentNoDataPlaceholder" class="d-none">
                            <div class="d-flex align-items-center justify-content-center" style="height: 350px;">
                                <div class="text-muted text-center">
                                    <i class="ri-pie-chart-2-line fs-1 mb-2 opacity-50"></i>
                                    <p class="fw-medium m-0">No Data Available</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascripts')

    <script src="{{ asset('vikalp-x.js') }}"></script>
    <script src="{{ asset('admin/engines/attachment-module.js') }}"></script>
    <script src="{{ asset('admin/engines/chart-color-generators.js') }}"></script>
    <script src="{{ asset('admin/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/engines/report-filter-2.0.js') }}"></script>
    <script src="{{ asset('admin/assets/js/engines/printer.js') }}"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    {{-- @php
        $issueStatus = $issueStatus->pluck('color', 'name')->toArray();
    @endphp --}}

    <!-- Chart Scripts for Module 1 -->
    @include('charts.observation-status-pie-chart', [
        'data' => $charts['observationstatusPieChart'],
        'colors' => [
            'Open' => '#B45309',
            'Closed' => '#639922',
        ],
    ])

    <!-- Chart Scripts for Module 2 -->
    @include('charts.dashboardchart.actionable-status-pie-chart4', [
        'data' => $charts['atractionablestatusPieChart'],
    ])

    <!-- Chart Scripts for Risk Level -->
    @include('charts.atr-risk-donut-chart', [
        'data' => $charts['observationByRiskRatingPieChart'],
    ])



    <script>
        function escapeHtml(value) {
            return String(value ?? '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        const engagementShowTemplate = @json(route('admin.engagements.show', '__UUID__'));
        const atrObservationShowTemplate = @json(route('admin.atrobservation.show', '__UUID__'));
        const atrSubObservationShowTemplate = @json(route('admin.atrsubobservationshow', '__UUID__'));
        const overdueObservationGroups = @json($overdueObservationGroups);

        function buildEngagementLink(name, uuid, style) {
            const label = escapeHtml(name || 'N/A');

            if (!uuid) {
                return `<span style="${style}">${label}</span>`;
            }

            return `<a href="${engagementShowTemplate.replace('__UUID__', uuid)}" style="${style}">${label}</a>`;
        }

        function buildAtrObservationLink(name, uuid, style) {
            const label = escapeHtml(name || 'N/A');

            if (!uuid) {
                return `<span style="${style}">${label}</span>`;
            }

            return `<a href="javascript:void(0);" class="actionHandler" data-url="${atrObservationShowTemplate.replace('__UUID__', uuid)}" style="${style}">${label}</a>`;
        }

        function buildAtrSubObservationLink(name, uuid, style) {
            const label = escapeHtml(name || 'N/A');

            if (!uuid) {
                return `<span style="${style}">${label}</span>`;
            }

            return `<a href="javascript:void(0);" class="actionHandler" data-url="${atrSubObservationShowTemplate.replace('__UUID__', uuid)}" style="${style}">${label}</a>`;
        }

        function getOverdueObservationHeading(engagementName, riskKey) {
            const labels = {
                high: 'High Risk Observations',
                medium: 'Medium Risk Observations',
                low: 'Low Risk Observations',
                all: 'All Observations',
            };

            return `${engagementName || 'Engagement'} - ${labels[riskKey] || labels.all}`;
        }

        function getOverdueObservationRows(group, riskKey) {
            const rows = Array.isArray(group?.details) ? group.details : [];
            if (riskKey === 'all') {
                return rows;
            }

            return rows.filter((item) => item.risk_bucket === riskKey);
        }

        function getOverdueStatusBadge(status) {
            const normalized = (status || '').toLowerCase().trim();
            const map = {
                open: 'dashboard-status-badge dashboard-status-badge--secondary',
                query: 'dashboard-status-badge dashboard-status-badge--warning',
                'draft observation': 'dashboard-status-badge dashboard-status-badge--warning',
                'final observation': 'dashboard-status-badge dashboard-status-badge--danger',
                closed: 'dashboard-status-badge dashboard-status-badge--success',
                dropped: 'dashboard-status-badge dashboard-status-badge--muted',
            };

            return map[normalized] || 'dashboard-status-badge dashboard-status-badge--muted';
        }

        function getOverdueAgeingBadge(ageingDays) {
            const value = Number(ageingDays || 0);
            if (value <= 0) {
                return 'dashboard-ageing-pill dashboard-ageing-pill--warning';
            }

            if (value <= 12) {
                return 'dashboard-ageing-pill dashboard-ageing-pill--warning';
            }

            return 'dashboard-ageing-pill dashboard-ageing-pill--danger';
        }

        function renderOverdueObservationPanel(rows) {
            if (!rows.length) {
                return `<div class="text-center text-muted py-5"><i class="ri-information-line fs-1 d-block mb-2"></i><div class="fw-medium">No overdue observations found.</div></div>`;
            }

            const body = rows.map((item) => `
                <tr>
                    <td>${buildAtrObservationLink(item.title, item.uuid, 'font-size: 14px; font-weight: 500;')}</td>
                    <td style="max-width: 260px; white-space: normal; word-break: break-word;">${escapeHtml(item.description || 'N/A')}</td>
                    <td style="white-space: nowrap;">${escapeHtml(item.target_date || 'N/A')}</td>
                    <td><span class="${getOverdueStatusBadge(item.status)}">${escapeHtml(item.status || 'N/A')}</span></td>
                    <td>${escapeHtml(item.owner || 'N/A')}</td>
                    <td class="text-center"><span class="${getOverdueAgeingBadge(item.ageing_days)}">${escapeHtml(item.ageing_days || 0)}</span></td>
                </tr>
            `).join('');

            return `
                <div class="dashboard-detail-table-wrap">
                    <table class="dashboard-detail-table">
                        <thead>
                            <tr>
                                <th>Observation Title</th>
                                <th>Description</th>
                                <th>Target Date</th>
                                <th>Status</th>
                                <th>Owner</th>
                                <th>Ageing (days)</th>
                            </tr>
                        </thead>
                        <tbody>${body}</tbody>
                    </table>
                </div>
            `;
        }

        function openOverdueObservationPanel(groupKey, riskKey = 'all') {
            const group = overdueObservationGroups.find((item) => item.group_key === groupKey);
            if (!group) {
                return;
            }

            const rows = getOverdueObservationRows(group, riskKey);
            document.getElementById('overdueOffcanvasLabel').textContent =
                getOverdueObservationHeading(group.engagement_name, riskKey);
            document.getElementById('overdueOffcanvasContent').innerHTML =
                renderOverdueObservationPanel(rows);

            const offcanvas = new bootstrap.Offcanvas(document.getElementById('overdueOffcanvas'));
            offcanvas.show();
        }

        function focusDepartmentRisk(departmentName) {
            const normalizedDepartment = (departmentName || '').toLowerCase().trim();
            if (!normalizedDepartment) {
                return;
            }

            const allCheckbox = document.getElementById('department-all');
            const departmentCheckboxes = Array.from(document.querySelectorAll('.department-filter'));
            let matched = false;

            departmentCheckboxes.forEach((checkbox) => {
                const isMatch = (checkbox.value || '').toLowerCase().trim() === normalizedDepartment;
                checkbox.checked = isMatch;
                matched = matched || isMatch;
            });

            if (!matched) {
                return;
            }

            if (allCheckbox) {
                allCheckbox.checked = false;
            }

            applyDeptFilters(true);
            // Trigger update tags
            const menu = document.querySelector('#department-all')?.closest('.custom-dropdown-menu');
            if (menu) updateSelectBoxTags(menu);
        }
    </script>

    <script>
        window.riskLevelFullData = @json($byRiskLevel);

        const riskStyles = {
            high: 'background-color:#f87171; color:#fff;',
            medium: 'background-color:#fbbf24; color:#000;',
            low: 'background-color:#22c55e; color:#fff;',
        };

        function normalizeRiskValue(value) {
            const risk = (value || '').toLowerCase().trim();
            return (risk === 'critical' || risk === 'l1') ? 'high' : risk;
        }

        function handleRiskClick(riskType) {
            let data = window.riskLevelFullData;
            let filtered = data.filter(item => {
                return item.risk_grading &&
                    normalizeRiskValue(item.risk_grading) === normalizeRiskValue(riskType);
            });

            let tbody = document.getElementById('riskFilterTableBody');
            let tableContainer = document.getElementById('riskFilterTableContainer');
            let noDataPlaceholder = document.getElementById('riskFilterNoDataPlaceholder');
            let title = document.getElementById('riskFilterTitle');

            tbody.innerHTML = '';
            title.innerText = riskType + " Risk Details";

            if (filtered.length === 0) {
                tableContainer.classList.add('d-none');
                noDataPlaceholder.classList.remove('d-none');
            } else {
                tableContainer.classList.remove('d-none');
                noDataPlaceholder.classList.add('d-none');
                let rows = '';
                filtered.forEach(item => {
                    let risk = normalizeRiskValue(item.risk_grading);
                    let riskStyle = riskStyles[risk] || 'background-color:#e5e7eb; color:#374151;';
                    const riskLabel = risk ? risk.charAt(0).toUpperCase() + risk.slice(1) : 'N/A';
                    rows += `
                        <tr>
                            <td>${buildEngagementLink(item.engagement_name, item.engagement_uuid, 'font-size: 14px; font-weight: 500;')}</td>
                            <td style="max-width: 300px; word-wrap: break-word; white-space: normal;">${buildAtrObservationLink(item.name, item.uuid, 'font-size: 14px; font-weight: 500;')}</td>
                            <td><span class="badge" style="${riskStyle} padding:6px 12px; font-size:11px;">${riskLabel}</span></td>
                            <td style="font-size: 13px; white-space: nowrap;">${item.response_due_date ?? 'N/A'}</td>
                            <td style="font-size: 13px;">${item.owner_name ?? 'N/A'}</td>
                        </tr>`;
                });
                tbody.innerHTML = rows;
            }
            let offcanvas = new bootstrap.Offcanvas(document.getElementById('riskLevelFilterOffcanvas'));
            offcanvas.show();
        }
    </script>
    {{-- shahid 11 --}}

    <script>
        window.subObsStatusFullData = @json($subobservationbyStatus);
        const subObsStatusStyles = {
            open: 'background-color:#2563eb; color:#fff;',
            closed: 'background-color:#64748b; color:#fff;',
        };

        function handleSubObsStatusClick(statusType) {
            let data = window.subObsStatusFullData;
            let filtered = data.filter(item => {
                return item.status && item.status.toLowerCase() === statusType.toLowerCase();
            });

            let tbody = document.getElementById('subObsStatusFilterTableBody');
            let tableContainer = document.getElementById('subObsStatusFilterTableContainer');
            let noDataPlaceholder = document.getElementById('subObsStatusFilterNoDataPlaceholder');
            let title = document.getElementById('subObsStatusFilterTitle');

            tbody.innerHTML = '';
            title.innerText = statusType + " Sub-Observation Details";

            if (filtered.length === 0) {
                tableContainer.classList.add('d-none');
                noDataPlaceholder.classList.remove('d-none');
            } else {
                tableContainer.classList.remove('d-none');
                noDataPlaceholder.classList.add('d-none');
                let rows = '';
                filtered.forEach(item => {
                    let status = (item.status || '').toLowerCase().trim();
                    let statusStyle = subObsStatusStyles[status] || 'background-color:#e5e7eb; color:#374151;';
                    let formattedStatus = item.status ? item.status.charAt(0).toUpperCase() + item.status.slice(1) :
                        'N/A';

                    let ageingHtml = 'N/A';
                    const targetDateVal = item.response_due_date || item.due_date;
                    if (targetDateVal) {
                        let dueDate = new Date(targetDateVal);
                        let today = new Date();
                        let diffTime = today - dueDate;
                        let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                        if (diffDays < 0) diffDays = Math.abs(diffDays);
                        ageingHtml =
                            `<div style="background-color: #fee2e2; color: #ef4444; width: 36px; height: 36px; border-radius: 50%; display: inline-flex; flex-direction: column; align-items: center; justify-content: center; font-size: 10px; font-weight: 600; line-height: 1.1;"><span>${diffDays}</span><span style="font-size: 8px;">days</span></div>`;
                    }

                    rows += `<tr>
                        <td style="max-width: 250px; word-wrap: break-word; white-space: normal;">${buildAtrObservationLink(item.observations_name, item.observation_uuid, 'font-size: 14px; font-weight: 500;')}</td>
                        <td style="max-width: 250px; word-wrap: break-word; white-space: normal;">${buildAtrSubObservationLink(item.name, item.uuid, 'font-size: 14px; font-weight: 500;')}</td>
                        <td style="font-size: 13px;">${item.owner_name ?? 'N/A'}</td>
                        <td><span class="badge" style="${statusStyle} padding:6px 12px; font-size:11px;">${formattedStatus}</span></td>
                        <td style="font-size: 13px;">${item.response_due_date ?? item.due_date ?? 'N/A'}</td>
                        <td class="text-center">${ageingHtml}</td>
                    </tr>`;
                });
                tbody.innerHTML = rows;
            }
            let offcanvas = new bootstrap.Offcanvas(document.getElementById('subObsStatusFilterOffcanvas'));
            offcanvas.show();
        }
    </script>
    <script>
        // ==============================
        // FULL DATA (FROM BLADE)
        // ==============================
        window.atrObservationFullData = @json($overdueObservations);
        window.obsStatusFullData = @json($byStatus);

        // ==============================
        // STATUS STYLES (GLOBAL)
        // ==============================
        const statusStyles = {
            open: 'background-color:#f59e0b; color:#fff;',
            closed: 'background-color:#22c55e; color:#fff;',
            query: 'background-color:#2563eb; color:#fff;',
            dropped: 'background-color:#ef4444; color:#fff;',
            'final observation': 'background-color:#f87171; color:#fff;',
            'draft observation': 'background-color:#64748b; color:#fff;',
        };

        // ==============================
        // HANDLE CHART CLICK
        // ==============================
        function renderAtrObservationStatusDetails(filtered, titleText) {
            let tbody = document.getElementById('obsStatusFilterTableBody');
            let tableContainer = document.getElementById('obsStatusFilterTableContainer');
            let noDataPlaceholder = document.getElementById('obsStatusFilterNoDataPlaceholder');
            let title = document.getElementById('obsStatusFilterTitle');

            // Remove ageing column if it was added by renderOverdueKpiPanel
            const thead = tableContainer?.querySelector('thead tr');
            if (thead) {
                thead.querySelectorAll('.th-ageing').forEach(el => el.remove());
            }

            tbody.innerHTML = '';
            title.innerText = titleText;

            if (filtered.length === 0) {
                tableContainer.classList.add('d-none');
                noDataPlaceholder.classList.remove('d-none');
            } else {
                tableContainer.classList.remove('d-none');
                noDataPlaceholder.classList.add('d-none');
                let rows = '';
                filtered.forEach(item => {
                    let status = (item.status || '').toLowerCase().trim();
                    let statusStyle = statusStyles[status] || 'background-color:#e5e7eb; color:#374151;';
                    let formattedStatus = item.status ? item.status.charAt(0).toUpperCase() + item.status.slice(1) :
                        'N/A';
                    let risk = normalizeRiskValue(item.risk_grading);
                    let riskStyle = riskStyles[risk] || 'background-color:#e5e7eb; color:#374151;';
                    let riskLabel = risk ? risk.charAt(0).toUpperCase() + risk.slice(1) : 'N/A';
                    rows += `<tr>
                        <td>${buildEngagementLink(item.engagement_name, item.engagement_uuid, 'font-size: 14px; font-weight: 500;')}</td>
                        <td style="max-width: 300px; word-wrap: break-word; white-space: normal;">${buildAtrObservationLink(item.name, item.uuid, 'font-size: 14px; font-weight: 500;')}</td>
                        <td><span class="badge" style="${riskStyle} padding:6px 12px; font-size:11px;">${riskLabel}</span></td>
                        <td><span class="badge" style="${statusStyle} padding:6px 12px; font-size:11px;">${formattedStatus}</span></td>
                        <td style="font-size: 13px; white-space: nowrap;">${item.response_due_date ?? item.due_date ?? 'N/A'}</td>
                        <td style="font-size: 13px;">${item.owner_name ?? 'N/A'}</td>
                    </tr>`;
                });
                tbody.innerHTML = rows;
            }
            let offcanvas = new bootstrap.Offcanvas(document.getElementById('obsStatusFilterOffcanvas'));
            offcanvas.show();
        }

        function handleStatusClick(statusType) {
            let data = window.obsStatusFullData;
            let filtered = data.filter(item => {
                return item.status && item.status.toLowerCase() === statusType.toLowerCase();
            });

            renderAtrObservationStatusDetails(filtered, statusType + " Status Details");
        }

        function renderOverdueKpiPanel(filtered, title) {
            const tbody = document.getElementById('obsStatusFilterTableBody');
            const tableContainer = document.getElementById('obsStatusFilterTableContainer');
            const noDataPlaceholder = document.getElementById('obsStatusFilterNoDataPlaceholder');
            const titleEl = document.getElementById('obsStatusFilterTitle');

            titleEl.innerText = title || 'Overdue Observation Details';
            tbody.innerHTML = '';

            if (!filtered.length) {
                tableContainer.classList.add('d-none');
                noDataPlaceholder.classList.remove('d-none');
            } else {
                tableContainer.classList.remove('d-none');
                noDataPlaceholder.classList.add('d-none');

                // Ensure the header has the Ageing column
                const thead = tableContainer.querySelector('thead tr');
                if (thead && !thead.querySelector('.th-ageing')) {
                    const th = document.createElement('th');
                    th.className = 'th-ageing text-center';
                    th.textContent = 'Ageing (days)';
                    thead.appendChild(th);
                }

                const today = new Date();
                today.setHours(0, 0, 0, 0);

                let rows = '';
                filtered.forEach(item => {
                    const status = (item.status || '').toLowerCase().trim();
                    const statusStyle = statusStyles[status] || 'background-color:#e5e7eb; color:#374151;';
                    const formattedStatus = item.status ?
                        item.status.charAt(0).toUpperCase() + item.status.slice(1) :
                        'N/A';
                    const risk = normalizeRiskValue(item.risk_grading);
                    const riskStyle = riskStyles[risk] || 'background-color:#e5e7eb; color:#374151;';
                    const riskLabel = risk ? risk.charAt(0).toUpperCase() + risk.slice(1) : 'N/A';

                    let ageingHtml = 'N/A';
                    if (item.response_due_date) {
                        const targetDate = new Date(item.response_due_date);
                        targetDate.setHours(0, 0, 0, 0);
                        const diffMs = today - targetDate;
                        const diffDays = Math.ceil(diffMs / (1000 * 60 * 60 * 24));
                        const days = diffDays > 0 ? diffDays : 0;
                        const pillClass = days > 12 ?
                            'dashboard-ageing-pill dashboard-ageing-pill--danger' :
                            'dashboard-ageing-pill dashboard-ageing-pill--warning';
                        ageingHtml = `<span class="${pillClass}">${days} days</span>`;
                    }

                    rows += `<tr>
                        <td>${buildEngagementLink(item.engagement_name, item.engagement_uuid, 'font-size: 14px; font-weight: 500;')}</td>
                        <td style="max-width: 300px; word-wrap: break-word; white-space: normal;">${buildAtrObservationLink(item.name, item.uuid, 'font-size: 14px; font-weight: 500;')}</td>
                        <td><span class="badge" style="${riskStyle} padding:6px 12px; font-size:11px;">${riskLabel}</span></td>
                        <td><span class="badge" style="${statusStyle} padding:6px 12px; font-size:11px;">${formattedStatus}</span></td>
                        <td style="font-size: 13px; white-space: nowrap;">${item.response_due_date ?? 'N/A'}</td>
                        <td style="font-size: 13px;">${item.owner_name ?? 'N/A'}</td>
                        <td class="text-center">${ageingHtml}</td>
                    </tr>`;
                });
                tbody.innerHTML = rows;
            }

            new bootstrap.Offcanvas(document.getElementById('obsStatusFilterOffcanvas')).show();
        }

        function openAtrObservationKpi(type) {
            const normalizedType = (type || '').toLowerCase();

            if (normalizedType === 'open' || normalizedType === 'closed') {
                handleStatusClick(normalizedType);
                return;
            }

            let filtered = window.atrObservationFullData || [];
            let title = 'Observation Details';

            if (normalizedType === 'overdue') {
                const today = new Date();
                today.setHours(0, 0, 0, 0);

                filtered = filtered.filter((item) => {
                    if ((item.status || '').toLowerCase() !== 'open') {
                        return false;
                    }

                    const rawDate = item.response_due_date || item.due_date;
                    if (!rawDate) {
                        return false;
                    }

                    const targetDate = new Date(rawDate);
                    if (Number.isNaN(targetDate.getTime())) {
                        return false;
                    }

                    targetDate.setHours(0, 0, 0, 0);
                    return targetDate < today;
                });
                title = 'Overdue Observation Details';
                renderOverdueKpiPanel(filtered, title);
                return;
            } else {
                title = 'Count of Observation Details';
            }

            renderAtrObservationStatusDetails(filtered, title);
        }
    </script>

    <script>
        function removeFilterTag(type, value) {
            let selector = type === 'department' ? '.department-filter' : '.engagement-filter';
            let checkboxes = document.querySelectorAll(selector);
            checkboxes.forEach(cb => {
                if (cb.value === value) {
                    cb.checked = false;
                    cb.dispatchEvent(new Event('change', {
                        bubbles: true
                    }));
                }
            });
        }

        function updateSelectBoxTags(menu) {
            let typeLabel = menu.querySelector('.department-filter') ? 'department' : 'engagement';
            let selector = typeLabel === 'department' ? '.department-filter' : '.engagement-filter';
            let checkedInputs = Array.from(menu.querySelectorAll(selector + ':checked'));
            let displayContainer = menu.previousElementSibling.querySelector('.selected-tags-container');
            if (!displayContainer) return;

            let pluralLabel = typeLabel === 'department' ? 'Departments' : 'Engagements';
            let isExpanded = displayContainer.dataset.expanded === 'true';

            if (checkedInputs.length === 0) {
                displayContainer.innerHTML =
                    `<span style="font-size: 13px; color: #334155;">No ${pluralLabel} Selected</span>`;
            } else {
                let maxTags = isExpanded ? Infinity : 3;
                let tagsHtml = '';
                for (let i = 0; i < checkedInputs.length; i++) {
                    if (i < maxTags) {
                        let cb = checkedInputs[i];
                        let name = cb.dataset.name || cb.nextElementSibling.innerText.trim();
                        tagsHtml +=
                            `<span class="selected-tag">${name} <i class="ri-close-line remove-tag" onclick="event.stopPropagation(); removeFilterTag('${typeLabel}', '${cb.value}')"></i></span>`;
                    } else {
                        let remaining = checkedInputs.length - maxTags;
                        tagsHtml +=
                            `<span class="selected-tag" style="background: #f1f5f9; border-color: #cbd5e1; cursor: pointer; color: #334155; font-weight: 600;" onclick="event.stopPropagation(); this.closest('.selected-tags-container').dataset.expanded='true'; updateSelectBoxTags(this.closest('.custom-select-wrapper').querySelector('.custom-dropdown-menu'));">+${remaining} More</span>`;
                        break;
                    }
                }

                if (isExpanded && checkedInputs.length > 3) {
                    tagsHtml +=
                        `<span class="selected-tag" style="background: #f1f5f9; border-color: #cbd5e1; cursor: pointer; color: #334155; font-weight: 600; padding: 2px 6px;" onclick="event.stopPropagation(); this.closest('.selected-tags-container').dataset.expanded='false'; updateSelectBoxTags(this.closest('.custom-select-wrapper').querySelector('.custom-dropdown-menu'));" title="Show Less"><i class="ri-arrow-up-s-line" style="font-size: 15px; margin: 0;"></i></span>`;
                }

                displayContainer.innerHTML = tagsHtml;
            }
        }

        document.addEventListener('click', function(e) {
            if (!e.target.closest('.custom-select-wrapper')) {
                document.querySelectorAll('.custom-dropdown-menu').forEach(menu => {
                    menu.classList.add('d-none');
                    let displayContainer = menu.previousElementSibling.querySelector(
                        '.selected-tags-container');
                    if (displayContainer && displayContainer.dataset.expanded === 'true') {
                        displayContainer.dataset.expanded = 'false';
                        updateSelectBoxTags(menu);
                    }
                });
            }
        });

        document.addEventListener('change', function(e) {
            if (e.target && e.target.type === 'checkbox' && e.target.closest('.custom-dropdown-menu')) {
                let menu = e.target.closest('.custom-dropdown-menu');
                updateSelectBoxTags(menu);
            }
        });

        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.custom-dropdown-menu').forEach(menu => {
                updateSelectBoxTags(menu);
            });
        });
    </script>

    {{-- filter on Engagement-wise --}}
    <script>
        function handleRiskTab(element, riskLevel) {

            let parent = element.parentElement;
            let tabs = parent.children;

            for (let i = 0; i < tabs.length; i++) {
                let tab = tabs[i];
                tab.style.borderBottom = '2px solid transparent';
                tab.style.color = '#64748b';
                tab.style.fontWeight = '500';

                let badge = tab.querySelector('span');
                badge.style.background = '#f1f5f9';
                badge.style.color = '#64748b';
            }

            // Active tab UI
            element.style.borderBottom = '2px solid #ef4444';
            element.style.color = '#ef4444';
            element.style.fontWeight = '600';

            let activeBadge = element.querySelector('span');
            activeBadge.style.background = '#fee2e2';
            activeBadge.style.color = '#ef4444';

            // Set active risk
            document.querySelectorAll('[data-risk]').forEach(tab => {
                tab.classList.remove('active-risk');
            });
            element.classList.add('active-risk');

            applyFilters(false);
        }

        function applyFilters(updateCount = false) {

            let selectedRisk = document.querySelector('.active-risk')?.dataset.risk || 'all';

            let checkedEngagements = Array.from(document.querySelectorAll('.engagement-filter:checked'))
                .map(cb => cb.value);

            let rows = document.querySelectorAll('#engagementRiskTable tbody tr');

            let count = 1;

            // Count object
            let counts = {
                all: 0,
                high: 0,
                medium: 0,
                low: 0
            };

            rows.forEach(row => {

                let rowRisk = (row.getAttribute('data-risk') || '').toLowerCase().trim();
                let rowEngagement = (row.getAttribute('data-engagement') || '').toLowerCase().trim();

                let engagementMatch = checkedEngagements.includes(rowEngagement);
                let riskMatch = (selectedRisk === 'all') || (rowRisk === selectedRisk);

                if (riskMatch && engagementMatch) {
                    row.style.display = '';
                    row.firstElementChild.innerText = count++;
                } else {
                    row.style.display = 'none';
                }


                if (updateCount && engagementMatch) {
                    counts.all++;

                    if (counts[rowRisk] !== undefined) {
                        counts[rowRisk]++;
                    }
                }

            });


            if (updateCount) {

                document.getElementById('showingCount').innerText = counts.all;

                document.querySelector('.count-all').innerText = counts.all;
                document.querySelector('.count-high').innerText = counts.high;
                document.querySelector('.count-medium').innerText = counts.medium;
                document.querySelector('.count-low').innerText = counts.low;
            }

            // No Data Handling
            let visibleRows = 0;

            rows.forEach(row => {
                if (row.id !== 'noEngagementDataRow' && row.style.display !== 'none') {
                    visibleRows++;
                }
            });

            let tableContainer = document.getElementById('engagementTableContainer');
            let noDataPlaceholder = document.getElementById('engagementNoDataPlaceholder');

            if (visibleRows === 0) {
                tableContainer.classList.add('d-none');
                noDataPlaceholder.classList.remove('d-none');
            } else {
                tableContainer.classList.remove('d-none');
                noDataPlaceholder.classList.add('d-none');
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            handleRiskTab(document.querySelector('[data-risk="all"]'), 'All');

            document.querySelectorAll('.engagement-filter').forEach(cb => {
                cb.addEventListener('change', function() {
                    applyFilters(true);
                });
            });

        });

        // all select check box
        document.addEventListener("DOMContentLoaded", function() {

            const allCheckbox = document.getElementById('engagement-all');
            const engagementCheckboxes = document.querySelectorAll('.engagement-filter');

            // All â†’ Select / Deselect all
            allCheckbox.addEventListener('change', function() {

                engagementCheckboxes.forEach(cb => {
                    cb.checked = allCheckbox.checked;
                });

                // Trigger filter + count update
                applyFilters(true);
            });

            // Individual checkbox change
            engagementCheckboxes.forEach(cb => {
                cb.addEventListener('change', function() {

                    let total = engagementCheckboxes.length;
                    let checked = document.querySelectorAll('.engagement-filter:checked').length;

                    // If all selected â†’ check ALL
                    if (checked === total) {
                        allCheckbox.checked = true;
                    } else {
                        allCheckbox.checked = false;
                    }
                });
            });

        });
    </script>

    {{-- filter on department-wise --}}
    <script>
        function handleDeptRiskTab(element, riskLevel) {
            let parent = element.parentElement;
            let tabs = parent.children;

            // Reset UI
            for (let i = 0; i < tabs.length; i++) {
                let tab = tabs[i];
                tab.style.borderBottom = '2px solid transparent';
                tab.style.color = '#64748b';
                tab.style.fontWeight = '500';

                let badge = tab.querySelector('span');
                if (badge) {
                    badge.style.background = '#f1f5f9';
                    badge.style.color = '#64748b';
                }
            }

            // Active tab UI
            element.style.borderBottom = '2px solid #ef4444';
            element.style.color = '#ef4444';
            element.style.fontWeight = '600';

            let badge = element.querySelector('span');
            if (badge) {
                badge.style.background = '#fee2e2';
                badge.style.color = '#ef4444';
            }

            // Active class set
            parent.querySelectorAll('[data-risk]').forEach(tab => {
                tab.classList.remove('active-dept-risk');
            });

            element.classList.add('active-dept-risk');

            // Only filter (no count update)
            applyDeptFilters(false);
        }

        function applyDeptFilters(updateCount = false) {

            let selectedRisk = document.querySelector('.active-dept-risk')?.dataset.risk || 'all';

            let checkedDepartments = Array.from(document.querySelectorAll('.department-filter:checked'))
                .map(cb => cb.value);

            let rows = document.querySelectorAll('#departmentRiskTable tbody tr');

            let count = 1;

            // Count object
            let counts = {
                all: 0,
                high: 0,
                medium: 0,
                low: 0
            };

            rows.forEach(row => {

                let rowRisk = (row.dataset.risk || '').toLowerCase().trim();
                let rowDept = (row.dataset.department || '').toLowerCase().trim();

                let deptMatch = checkedDepartments.includes(rowDept);
                let riskMatch = (selectedRisk === 'all') || (rowRisk === selectedRisk);

                if (riskMatch && deptMatch) {
                    row.style.display = '';
                    row.children[0].innerText = count++;
                } else {
                    row.style.display = 'none';
                }

                if (updateCount && deptMatch) {
                    counts.all++;

                    if (counts[rowRisk] !== undefined) {
                        counts[rowRisk]++;
                    }
                }

            });

            if (updateCount) {

                // Showing count
                document.getElementById('deptShowingCount').innerText = counts.all;

                // Tabs count update
                document.querySelector('.dept-count-all').innerText = counts.all;
                document.querySelector('.dept-count-high').innerText = counts.high;
                document.querySelector('.dept-count-medium').innerText = counts.medium;
                document.querySelector('.dept-count-low').innerText = counts.low;
            }

            // No Data Handling
            let visibleRows = 0;

            rows.forEach(row => {
                if (row.id !== 'noDeptDataRow' && row.style.display !== 'none') {
                    visibleRows++;
                }
            });

            let tableContainer = document.getElementById('departmentTableContainer');
            let noDataPlaceholder = document.getElementById('departmentNoDataPlaceholder');

            if (visibleRows === 0) {
                tableContainer.classList.add('d-none');
                noDataPlaceholder.classList.remove('d-none');
            } else {
                tableContainer.classList.remove('d-none');
                noDataPlaceholder.classList.add('d-none');
            }
        }

        // On Page Load
        document.addEventListener("DOMContentLoaded", function() {
            let deptCard = document.querySelector('#departmentRiskTable')
                ?.closest('.card-body');

            let defaultTab = deptCard?.querySelector('[data-risk="all"]');

            // Default load
            if (defaultTab) {
                handleDeptRiskTab(defaultTab, 'All');
                applyDeptFilters(true); // initialize showing count and tab badges on first render
            }

            //  Checkbox change â†’ filter + count update
            document.querySelectorAll('.department-filter').forEach(cb => {
                cb.addEventListener('change', function() {
                    applyDeptFilters(true);
                });
            });

        });

        // Department ALL checkbox logic
        document.addEventListener("DOMContentLoaded", function() {

            const deptAllCheckbox = document.getElementById('department-all');
            const deptCheckboxes = document.querySelectorAll('.department-filter');
            deptAllCheckbox.addEventListener('change', function() {

                deptCheckboxes.forEach(cb => {
                    cb.checked = deptAllCheckbox.checked;
                });

                // Trigger filter + count update
                applyDeptFilters(true);
            });

            // Individual checkbox change
            deptCheckboxes.forEach(cb => {
                cb.addEventListener('change', function() {

                    let total = deptCheckboxes.length;
                    let checked = document.querySelectorAll('.department-filter:checked').length;

                    // Auto toggle ALL checkbox
                    if (checked === total) {
                        deptAllCheckbox.checked = true;
                    } else {
                        deptAllCheckbox.checked = false;
                    }
                });
            });

        });
    </script>



    <!-- Group Dashboard Style CSS & JS -->
    <style>
        .gd-toolbar {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #1e293b;
        }

        .gd-toolbar a {
            color: #1e293b;
            transition: color 0.2s;
            font-size: 16px;
            text-decoration: none;
        }

        .gd-toolbar a:hover {
            color: #0f172a;
        }

        .gd-toolbar .dropdown-menu {
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            border-radius: 8px;
            padding: 8px 0;
        }

        .gd-toolbar .dropdown-item {
            padding: 8px 16px;
            font-size: 14px;
            color: #475569;
        }

        .gd-toolbar .dropdown-item:hover {
            background-color: #f8fafc;
            color: #0f172a;
        }

        .atrdashboard-modern a[href]:not(.btn):not(.dropdown-item):hover {
            text-decoration: underline !important;
        }

        .offcanvas .reportTable a[href] {
            color: #2563eb;
            font-weight: 500;
            text-decoration: none;
        }

        .offcanvas a[href]:not(.btn):not(.dropdown-item):not(.btn-close):hover {
            text-decoration: underline !important;
        }

        .gd-panel-toggle-view {
            display: none;
        }

        .gd-panel-toggle-view.is-active {
            display: block;
        }

        .gd-table th {
            font-size: 13px;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            background-color: #f8fafc;
            padding: 12px 16px;
            border-bottom: 2px solid #e2e8f0;
        }

        .gd-table td {
            font-size: 14px;
            color: #334155;
            padding: 12px 16px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }
    </style>


    <!-- Offcanvases -->
    <div class="offcanvas offcanvas-end shadow-lg border-0" tabindex="-1" id="riskLevelOffcanvas"
        style="width: min(900px, 90vw);">
        <div class="offcanvas-header border-bottom bg-white px-4 py-3">
            <h5 class="offcanvas-title fw-bold" style="color: #1e293b; font-size: 1.15rem;">Risk Level Details</h5>
            <button type="button" class="btn-close shadow-none" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <div class="offcanvas-body" style="padding: 1.5rem;">
            <div class="dashboard-detail-table-wrap">
                <table class="dashboard-detail-table w-100">
                    <thead>
                        <tr>
                            <th>Engagement Name</th>
                            <th>Observation Title</th>
                            <th>Risk Grading</th>
                            <th>Target Date</th>
                            <th>Owner</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($byRiskLevel as $data)
                            @php
                                $status = strtolower(trim($data->status ?? ''));
                                $risk = strtolower(trim($data->risk_grading ?? ''));
                                if (in_array($risk, ['critical', 'l1'])) {
                                    $risk = 'high';
                                }

                                $statusStyle = $statusStyles[$status] ?? 'background-color:#e5e7eb; color:#374151;';
                                $riskStyle = $riskStyles[$risk] ?? 'background-color:#e5e7eb; color:#374151;';
                            @endphp

                            <tr>
                                <td>
                                    <a href="{{ !empty($data->engagement_uuid) ? route('admin.engagements.show', $data->engagement_uuid) : 'javascript:void(0);' }}"
                                        style="font-size: 14px;">
                                        {{ \Illuminate\Support\Str::limit($data->engagement_name, 35, '...') ?? 'N/A' }}
                                    </a>
                                </td>

                                <td style="max-width: 300px; word-wrap: break-word; white-space: normal;">
                                    <a href="javascript:void(0);" class="actionHandler"
                                        data-url="{{ route('admin.atrobservation.show', $data->uuid) }}"
                                        style="font-size: 14px;">
                                        {{ $data->name ?? 'N/A' }}
                                    </a>
                                </td>

                                <td>
                                    <span class="badge" style="{{ $riskStyle }}">
                                        {{ ucfirst($risk) }}
                                    </span>
                                </td>

                                <td style="font-size: 13px; white-space: nowrap;">
                                    {{ $data->response_due_date ?? 'N/A' }}
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
    </div>

    <div class="offcanvas offcanvas-end shadow-lg border-0" tabindex="-1" id="riskLevelFilterOffcanvas"
        style="width: min(900px, 90vw);">

        <div class="offcanvas-header border-bottom bg-white px-4 py-3">
            <h5 class="offcanvas-title fw-bold" id="riskFilterTitle" style="color: #1e293b; font-size: 1.15rem;">
                Risk Level Details
            </h5>
            <button type="button" class="btn-close shadow-none" data-bs-dismiss="offcanvas"></button>
        </div>

        <div class="offcanvas-body" style="padding: 1.5rem;">
            <div id="riskFilterTableContainer">
                <div class="dashboard-detail-table-wrap">
                    <table class="dashboard-detail-table w-100">
                        <thead>
                            <tr>
                                <th>Engagement Name</th>
                                <th>Observation Title</th>
                                <th>Risk Grading</th>
                                <th>Target Date</th>
                                <th>Owner</th>
                            </tr>
                        </thead>
                        <tbody id="riskFilterTableBody">
                            <!-- Dynamic data yaha ayega -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="riskFilterNoDataPlaceholder" class="d-none mt-5">
                <div class="text-muted text-center">
                    <i class="ri-pie-chart-2-line fs-1 mb-2 opacity-50"></i>
                    <p class="fw-medium m-0">No Data Available</p>
                </div>
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-end shadow-lg border-0" tabindex="-1" id="obsStatusFilterOffcanvas"
        style="width: min(900px, 90vw);">

        <div class="offcanvas-header border-bottom bg-white px-4 py-3">
            <h5 class="offcanvas-title fw-bold" id="obsStatusFilterTitle" style="color: #1e293b; font-size: 1.15rem;">
                Status Details
            </h5>
            <button type="button" class="btn-close shadow-none" data-bs-dismiss="offcanvas"></button>
        </div>

        <div class="offcanvas-body" style="padding: 1.5rem;">
            <div id="obsStatusFilterTableContainer">
                <div class="dashboard-detail-table-wrap">
                    <table class="dashboard-detail-table w-100">
                        <thead>
                            <tr>
                                <th>Engagement Name</th>
                                <th>Observation Title</th>
                                <th>Risk Grading</th>
                                <th>Status</th>
                                <th>Target Date</th>
                                <th>Owner</th>
                            </tr>
                        </thead>
                        <tbody id="obsStatusFilterTableBody">
                            <!-- Dynamic data -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="obsStatusFilterNoDataPlaceholder" class="d-none mt-5">
                <div class="text-muted text-center">
                    <i class="ri-pie-chart-2-line fs-1 mb-2 opacity-50"></i>
                    <p class="fw-medium m-0">No Data Available</p>
                </div>
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-end shadow-lg border-0" tabindex="-1" id="obsStatusOffcanvas"
        style="width: min(900px, 90vw);">
        <div class="offcanvas-header border-bottom bg-white px-4 py-3">
            <h5 class="offcanvas-title fw-bold" style="color: #1e293b; font-size: 1.15rem;">Status Details</h5>
            <button type="button" class="btn-close shadow-none" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <div class="offcanvas-body" style="padding: 1.5rem;">
            @if (count($byStatus) > 0)
                <div class="dashboard-detail-table-wrap">
                    <table class="dashboard-detail-table w-100">
                        <thead>
                            <tr>
                                <th>Engagement Name</th>
                                <th>Observation Title</th>
                                <th>Risk Grading</th>
                                <th>Status</th>
                                <th>Target Date</th>
                                <th>Owner</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($byStatus as $data)
                                @php
                                    $status = strtolower(trim($data->status ?? ''));
                                    $risk = strtolower(trim($data->risk_grading ?? ''));
                                    if (in_array($risk, ['critical', 'l1'])) {
                                        $risk = 'high';
                                    }

                                    $statusStyle = $statusStyles[$status] ?? 'background-color:#e5e7eb; color:#374151;';
                                    $riskStyle = $riskStyles[$risk] ?? 'background-color:#e5e7eb; color:#374151;';
                                @endphp

                                <tr>
                                    <td>
                                        <a href="{{ !empty($data->engagement_uuid) ? route('admin.engagements.show', $data->engagement_uuid) : 'javascript:void(0);' }}"
                                            style="font-size: 14px;">
                                            {{ \Illuminate\Support\Str::limit($data->engagement_name, 35, '...') ?? 'N/A' }}
                                        </a>
                                    </td>

                                    <td>
                                        <a href="javascript:void(0);" class="actionHandler"
                                            data-url="{{ route('admin.atrobservation.show', $data->uuid) }}"
                                            style="font-size: 14px;">
                                            {{ $data->name ?? 'N/A' }}
                                        </a>
                                    </td>

                                    <td>
                                        <span class="badge" style="{{ $riskStyle }}">
                                            {{ ucfirst($risk ?: 'N/A') }}
                                        </span>
                                    </td>

                                    <td>
                                        <span class="badge" style="{{ $statusStyle }}">
                                            {{ ucfirst($data->status) }}
                                        </span>
                                    </td>

                                    <td style="font-size: 13px; white-space: nowrap;">
                                        {{ $data->response_due_date ?? 'N/A' }}
                                    </td>

                                    <td style="font-size: 13px;">
                                        {{ $data->owner_name ?? 'N/A' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="mt-5">
                    <div class="text-muted text-center">
                        <i class="ri-pie-chart-2-line fs-1 mb-2 opacity-50"></i>
                        <p class="fw-medium m-0">No Data Available</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="offcanvas offcanvas-end shadow-lg border-0" tabindex="-1" id="subObsStatusOffcanvas"
        style="width: min(900px, 90vw);">
        <div class="offcanvas-header border-bottom bg-white px-4 py-3">
            <h5 class="offcanvas-title fw-bold" style="color: #1e293b; font-size: 1.15rem;">Sub-observation Status Details
            </h5>
            <button type="button" class="btn-close shadow-none" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <div class="offcanvas-body" style="padding: 1.5rem;">
            @if (count($subobservationbyStatus) > 0)
                <div class="dashboard-detail-table-wrap" style="overflow-x: auto;">
                    <table class="dashboard-detail-table w-100">
                        <thead>
                            <tr>
                                <th>Engagement Name</th>
                                <th>Observation Name</th>
                                <th>Sub-Observation Name</th>
                                <th>Owner</th>
                                <th>Status</th>
                                <th>Target Date</th>
                                <th class="text-center">Ageing
                                    <br><span style="text-transform: none !important;">(days)</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subobservationbyStatus as $subobservation)
                                @php
                                    $status = strtolower(trim($subobservation->status ?? ''));
                                    $statusStyle = $openClosed[$status] ?? 'background-color:#e5e7eb; color:#374151;';
                                @endphp
                                <tr>
                                    <td><a href="{{ !empty($subobservation->engagement_uuid) ? route('admin.engagements.show', $subobservation->engagement_uuid) : 'javascript:void(0);' }}"
                                            style="font-size: 12px; font-weight: 500;">{{ \Illuminate\Support\Str::limit($subobservation->engagement_name, 35, '...') ?? 'N/A' }}</a>
                                    </td>
                                    <td><a href="javascript:void(0);" class="actionHandler"
                                            data-url="{{ route('admin.atrobservation.show', $subobservation->observation_uuid) }}"
                                            style="font-size: 12px; font-weight: 500;">{{ \Illuminate\Support\Str::limit($subobservation->observations_name, 35, '...') ?? 'N/A' }}</a>
                                    </td>

                                    <td><a href="javascript:void(0);" class="actionHandler"
                                            data-url="{{ route('admin.atrsubobservationshow', $subobservation->uuid) }}"
                                            style="font-size: 12px; font-weight: 500;">{{ $subobservation->name ?? 'N/A' }}</a>
                                    </td>

                                    <td style="font-size: 12px; padding: 12px 10px !important;">
                                        {{ $subobservation->owner_name ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge" style="{{ $statusStyle }}">
                                            {{ ucfirst($subobservation->status) }}
                                        </span>
                                    </td>

                                    <td style="font-size: 12px; color: #64748b; padding: 12px 10px !important;">
                                        {{ $subobservation->response_due_date ?? 'N/A' }}</td>

                                    <td class="text-center" style="padding: 12px 10px !important;">
                                        @php
                                            $dueDate = Carbon\Carbon::parse(
                                                $subobservation->response_due_date ?? $subobservation->due_date,
                                            );
                                            $today = Carbon\Carbon::today();
                                            $diffInDays = $today->diffInDays($dueDate);
                                            if ($today->greaterThan($dueDate)) {
                                                $diffInDays += 1;
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
                        </tbody>
                    </table>
                </div>
            @else
                <div class="mt-5">
                    <div class="text-muted text-center">
                        <i class="ri-pie-chart-2-line fs-1 mb-2 opacity-50"></i>
                        <p class="fw-medium m-0">No Data Available</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="offcanvas offcanvas-end shadow-lg border-0" tabindex="-1" id="subObsStatusFilterOffcanvas"
        style="width: min(900px, 90vw);">

        <div class="offcanvas-header border-bottom bg-white px-4 py-3">
            <h5 class="offcanvas-title fw-bold" id="subObsStatusFilterTitle" style="color: #1e293b; font-size: 1.15rem;">
                Sub-Observation Status Details
            </h5>
            <button type="button" class="btn-close shadow-none" data-bs-dismiss="offcanvas"></button>
        </div>

        <div class="offcanvas-body" style="padding: 1.5rem;">
            <div id="subObsStatusFilterTableContainer">
                <div class="dashboard-detail-table-wrap">
                    <table class="dashboard-detail-table w-100">
                        <thead>
                            <tr>
                                <th>Observation Name</th>
                                <th>Sub-Observation Name</th>
                                <th>Owner</th>
                                <th>Status</th>
                                <th>Target Date</th>
                                <th class="text-center">Ageing</th>
                            </tr>
                        </thead>
                        <tbody id="subObsStatusFilterTableBody">
                            <!-- Dynamic data -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="subObsStatusFilterNoDataPlaceholder" class="d-none mt-5">
                <div class="text-muted text-center">
                    <i class="ri-pie-chart-2-line fs-1 mb-2 opacity-50"></i>
                    <p class="fw-medium m-0">No Data Available</p>
                </div>
            </div>
        </div>
    </div>
    <div class="offcanvas offcanvas-end shadow" tabindex="-1" id="overdueOffcanvas" style="border-left: none;">
        <div class="offcanvas-header border-bottom bg-light px-4 py-3">
            <h5 class="offcanvas-title fw-bold" id="overdueOffcanvasLabel" style="color: #1e293b; font-size: 1.1rem;">
                Overdue Observations</h5>
            <button type="button" class="btn-close shadow-none" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <div class="offcanvas-body" style="padding: 20px;">
            <div id="overdueOffcanvasContent"></div>
        </div>
    </div>

    <!-- html2canvas for PNG downloads -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <script>
        // Toggle Views
        function togglePanelView(chartId, tableId, trigger) {
            const chartView = document.getElementById(chartId);
            const tableView = document.getElementById(tableId);
            const icon = trigger.querySelector('i');

            if (chartView.classList.contains('is-active')) {
                chartView.classList.remove('is-active');
                tableView.classList.add('is-active');
                icon.className = 'ri-pie-chart-2-line';
            } else {
                tableView.classList.remove('is-active');
                chartView.classList.add('is-active');
                icon.className = 'ri-layout-grid-line';
            }
        }

        function toggleRiskLevelView(btn) {
            togglePanelView('riskLevelChartView', 'riskLevelTableView', btn);
        }

        function toggleObsStatusView(btn) {
            togglePanelView('obsStatusChartView', 'obsStatusTableView', btn);
        }

        function toggleSubObsStatusView(btn) {
            togglePanelView('subObsStatusChartView', 'subObsStatusTableView', btn);
        }

        // CSV Downloads
        function downloadRiskLevelCsv() {
            downloadTableAsCSV('riskLevelExportTable', 'observations_by_risk_level.csv');
        }

        function downloadObsStatusCsv() {
            downloadTableAsCSV('obsStatusExportTable', 'observations_by_status.csv');
        }

        function downloadSubObsStatusCsv() {
            downloadTableAsCSV('subObsStatusExportTable', 'sub_observations_by_status.csv');
        }

        function downloadOverdueCsv() {
            downloadTableAsCSV('overdueObservationsTable', 'overdue_observations.csv');
        }

        function downloadEngagementRiskCsv() {
            downloadTableAsCSV('engagementRiskTable', 'engagement_wise_risk_count.csv');
        }

        function downloadDepartmentRiskCsv() {
            downloadTableAsCSV('departmentRiskTable', 'department_wise_risk_count.csv');
        }

        // Export Functions
        function downloadPanelAsPng(panelId, filename) {
            const element = document.getElementById(panelId);
            if (!element) return;

            // Temporarily hide the toolbar for the screenshot
            const toolbar = element.querySelector('.gd-toolbar');
            if (toolbar) toolbar.style.visibility = 'hidden';

            html2canvas(element, {
                scale: 2,
                backgroundColor: '#ffffff'
            }).then(canvas => {
                const link = document.createElement('a');
                link.download = filename;
                link.href = canvas.toDataURL('image/png');
                link.click();

                // Restore toolbar
                if (toolbar) toolbar.style.visibility = 'visible';
            });
        }

        function downloadPanelAsSvg(panelId, filename) {
            const element = document.getElementById(panelId);
            if (!element) return;

            // For ApexCharts, trigger their native export if available
            const chartArea = element.querySelector('.apexcharts-canvas');
            if (chartArea) {
                const chartId = chartArea.getAttribute('id');
                // Use a generic ApexCharts method if we can hook into it,
                // but since we're injecting HTML, we'll use a simplified approach
                // or fallback to PNG for now if native SVG export is complex directly from JS
                downloadPanelAsPng(panelId, filename.replace('.svg', '.png'));
                alert('SVG export is delegated to ApexCharts native menu if enabled, falling back to High-Res PNG.');
            } else {
                downloadPanelAsPng(panelId, filename.replace('.svg', '.png'));
            }
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#company_id').on('change', function() {

                let selectedCompanies = $(this).val();
                let locationUrl = $(this).data('url'); // URL for locations

                const location = document.getElementById('location_id');
                if (selectedCompanies.length === 0) {
                    updateVikalpOptions(location, []);
                    return;
                }
                $.ajax({
                    url: locationUrl,
                    type: 'GET',
                    data: {
                        company_ids: selectedCompanies
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.status === '200') {

                            updateVikalpOptions(location, response.data);
                        } else {
                            alert("Failed to load locations.");
                        }
                    },
                    error: function() {
                        alert("An error occurred while loading locations.");
                    }
                });


            });

        });
    </script>

    <script>
        function downloadTableAsCSV(tableId, filename) {
            const table = document.getElementById(tableId);
            let csvContent = "";

            // Get table headers
            const headers = table.querySelectorAll("thead th");
            const headerArray = Array.from(headers).map(header => header.textContent.trim());
            csvContent += headerArray.join(",") + "\n";

            // Get table rows
            const rows = table.querySelectorAll("tbody tr");
            rows.forEach(row => {
                const cells = row.querySelectorAll("td");
                const cellArray = Array.from(cells).map(cell => {
                    const text = cell.textContent.trim();
                    // Escape commas
                    return `"${text.replace(/"/g, '""')}"`;
                });
                csvContent += cellArray.join(",") + "\n";
            });

            // Create a Blob and trigger download
            const blob = new Blob([csvContent], {
                type: "text/csv"
            });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement("a");
            a.setAttribute("href", url);
            a.setAttribute("download", filename);
            a.click();
            window.URL.revokeObjectURL(url);
        }

        // â”€â”€ Export utilities â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
        function downloadTableAsExcel(tableId, filename) {
            const table = document.getElementById(tableId);
            if (!table) return;
            const wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, XLSX.utils.table_to_sheet(table), 'Data');
            XLSX.writeFile(wb, filename);
        }

        function downloadTableAsPdf(tableId, filename) {
            const table = document.getElementById(tableId);
            if (!table || typeof pdfMake === 'undefined') return;
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
            @php
                $npciLogoPath = public_path('logo/ncpilogoright.png');
                $npciLogoBase64 = file_exists($npciLogoPath) ? 'data:image/png;base64,' . base64_encode(file_get_contents($npciLogoPath)) : '';
            @endphp
            const logoData = '{!! $npciLogoBase64 !!}';
            const pdfContent = [];
            if (logoData) {
                pdfContent.push({
                    image: logoData,
                    width: 100,
                    alignment: 'right',
                    margin: [0, 0, 0, 10]
                });
            }
            pdfContent.push({
                table: {
                    headerRows: 1,
                    widths: headers.map(() => '*'),
                    body: [headers, ...rows]
                },
                layout: 'lightHorizontalLines'
            });

            pdfMake.createPdf({
                pageOrientation: 'landscape',
                content: pdfContent,
                defaultStyle: {
                    fontSize: 8
                }
            }).download(filename);
        }

        function exportAllAsExcel() {
            const wb = XLSX.utils.book_new();

            const kpiRows = [
                ['KPI', 'Value'],
                ['Count of Observation', document.getElementById('countOfObservation')?.innerText?.trim() ?? ''],
                ['Open', document.getElementById('openCount')?.innerText?.trim() ?? ''],
                ['Closed', document.getElementById('closedCount')?.innerText?.trim() ?? ''],
                ['High Risk', document.getElementById('highRisk')?.innerText?.trim() ?? ''],
                ['Overdue', document.getElementById('overdueCount')?.innerText?.trim() ?? ''],
            ];
            XLSX.utils.book_append_sheet(wb, XLSX.utils.aoa_to_sheet(kpiRows), 'KPI Summary');

            [{
                    id: 'riskLevelExportTable',
                    name: 'By Risk Level'
                },
                {
                    id: 'obsStatusExportTable',
                    name: 'By Status'
                },
                {
                    id: 'subObsStatusExportTable',
                    name: 'Sub-Obs Status'
                },
                {
                    id: 'overdueObservationsTable',
                    name: 'Overdue'
                },
                {
                    id: 'engagementRiskTable',
                    name: 'Engagement Risk'
                },
                {
                    id: 'departmentRiskTable',
                    name: 'Department Risk'
                },
            ].forEach(function(t) {
                const el = document.getElementById(t.id);
                if (el) XLSX.utils.book_append_sheet(wb, XLSX.utils.table_to_sheet(el), t.name);
            });
            XLSX.writeFile(wb, 'atr_dashboard.xlsx');
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
    </script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="{{ asset('admin/engines/dashboard-option.js') }}"></script>

    <script>
        (function() {
            const EXPORT_URL = "{{ route('admin.atrdashboard.export') }}";
            const CSRF = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

            const CHART_LABELS = {
                observationByRiskRatingPieChart: 'Observations by Risk Level',
                observationstatusPieChart: 'Observations by Status',
                atractionablestatusPieChart: 'Actionable Status',
            };

            document.getElementById('atrExportDocxBtn')?.addEventListener('click', async function() {
                const btn = this;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Generating…';
                btn.style.pointerEvents = 'none';

                try {
                    const charts = {};
                    for (const [id, label] of Object.entries(CHART_LABELS)) {
                        const instance = (window.chartInstances || {})[id];
                        if (instance) {
                            const result = await instance.dataURI({
                                scale: 2
                            });
                            charts[id] = {
                                dataURI: result.imgURI,
                                label
                            };
                        }
                    }

                    const response = await fetch(EXPORT_URL, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': CSRF
                        },
                        body: JSON.stringify({
                            charts
                        }),
                    });

                    if (!response.ok) throw new Error('Export failed');

                    const blob = await response.blob();
                    const url = URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = 'ATR_Dashboard_Report.docx';
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                    URL.revokeObjectURL(url);
                } catch (e) {
                    alert('Could not generate Word report. Please try again.');
                } finally {
                    btn.innerHTML = '<i class="ri-file-word-2-line me-2 text-primary"></i> Word (.docx)';
                    btn.style.pointerEvents = '';
                }
            });
        })();
    </script>
@endsection
