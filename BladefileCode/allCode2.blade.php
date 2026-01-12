<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>


{{-- * regarding  --}}
{{--  Start Hare --}}
{{--  Start Hare --}}
{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare --}}
{{--  Start Hare --}}
{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare --}}
{{--  Start Hare --}}
{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare --}}
{{--  Start Hare --}}
{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare --}}
{{--  Start Hare --}}
{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare --}}
{{--  Start Hare --}}
{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare --}}
{{--  Start Hare --}}
{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare --}}
{{--  Start Hare --}}
{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare --}}
{{--  Start Hare --}}
{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare --}}
{{--  Start Hare --}}
{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare --}}
{{--  Start Hare --}}
{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare --}}
{{--  Start Hare --}}
{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare --}}
{{--  Start Hare --}}
{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare --}}
{{--  Start Hare --}}
{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare --}}
{{--  Start Hare --}}

                        @if (request()->has('year'))
                            <a href="{{ url('totalworkingdays', auth()->user()->teammember_id) }}"
                                style=" margin-left: 10px; margin-top: 1px;">
                                <img src="{{ url('backEnd/image/reload.png') }}" style="width: 30px; height: 30px;"
                                    alt="Reload">
                            </a>
                        @endif

                        @if (Request::query('year'))
    <a href="{{ url('totalworkingdays', auth()->user()->teammember_id) }}"
        style="margin-left:10px; margin-top:1px;">
        <img src="{{ url('backEnd/image/reload.png') }}"
            style="width:30px; height:30px;"
            alt="Reload">
    </a>
@endif


{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare --}}
<button type="submit" class="btn btn-success" id="partnerSubmitBtn">
    Submit
</button>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const partnerForm = document.getElementById('exampleModal120111');
        const submitBtn = document.getElementById('partnerSubmitBtn');

        if (partnerForm) {
            partnerForm.addEventListener('submit', function() {
                submitBtn.disabled = true;
                submitBtn.innerText = 'Please wait...';
            });
        }
    });
</script>

{{--  Start Hare --}}
{{-- <li class="breadcrumb-item">
                        @if ($timesheetrejectData && $timesheetrejectData->status == 2)
                            <a href="javascript:void(0)" class="btn btn-info-soft btn-sm" id="add-timesheet-rejected">
                                Add Timesheet
                                @if ($timesheetcount > 7)
                                    for last week
                                @endif
                            </a>
                        @else
                            <a class="btn btn-info-soft btn-sm" href="{{ url('timesheet/create') }}">
                                Add Timesheet
                                @if ($timesheetcount > 7)
                                    for last week
                                @endif
                            </a>
                        @endif
                    </li> --}}

<li class="breadcrumb-item">
    @php
        $isRejected = !empty($timesheetrejectData) && $timesheetrejectData->status == 2;
        $label = 'Add Timesheet' . ($timesheetcount > 7 ? ' for last week' : '');
    @endphp

    <a class="btn btn-info-soft btn-sm" href="{{ $isRejected ? 'javascript:void(0)' : url('timesheet/create') }}"
        @if ($isRejected) id="add-timesheet-rejected" @endif>
        {{ $label }}
    </a>
</li>
{{-- ! End hare --}}
{{-- * regarding sweetalert / regarding alert --}}
{{--  Start Hare --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('add-timesheet-rejected').addEventListener('click', function() {
        Swal.fire({
            title: "Pending Rejected Timesheet",
            text: "Please submit your rejected timesheet first. Are you sure you want to proceed?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, Proceed",
            cancelButtonText: 'Cancel',
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            // reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '{{ url('rejectedlist') }}';
            }
        });
    });

    Swal.fire({
        title: 'Inform Partner?',
        text: "Do You want to inform partner about the ticket?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Yes, submit it!',
        cancelButtonColor: '#f39c12', // Use the color for 'Cancel' button
        cancelButtonText: 'Cancel',
        showDenyButton: true,
        denyButtonColor: '#d33', // Use the color for 'No, submit it!' button
        denyButtonText: 'No, submit it!',
        allowOutsideClick: false,
        buttons: ['cancel', 'deny', 'confirm'] // Specify the order of buttons
    })
</script>
{{--  Start Hare --}}
@if ($timesheetrejectData && $timesheetrejectData->status == 2)
    <li class="breadcrumb-item">
        <a href="{{ url('rejectedlist') }}" class="btn btn-info-soft btn-sm"
            onclick="return confirm('Please submit your rejected timesheet first. Are you sure you want to proceed?');">
            Add Timesheet
        </a>
    </li>
@else
    <li class="breadcrumb-item">
        <a class="btn btn-info-soft btn-sm" href="{{ url('timesheet/create') }}">
            Add Timesheet
        </a>
    </li>
@endif
{{--  Start Hare --}}
@if (!empty($timesheetrejectData) && $timesheetrejectData->status == 2)
    <li class="breadcrumb-item">
        <a href="javascript:void(0);" class="btn btn-info-soft btn-sm" onclick="redirectToRejectedList()">
            Add Timesheet
        </a>
    </li>
@else
    <li class="breadcrumb-item">
        <a class="btn btn-info-soft btn-sm" href="{{ url('timesheet/create') }}">
            Add Timesheet
        </a>
    </li>
@endif

<script>
    function redirectToRejectedList() {
        if (confirm('Please submit your rejected timesheet first. Are you sure you want to proceed?')) {
            window.location.href = "{{ url('rejectedlist') }}";
        }
        // Cancel → nothing happens
    }
</script>

{{--  Start Hare --}}
@if ($timesheetrejectData && $timesheetrejectData->status == 2)
    <li class="breadcrumb-item">
        <a href="javascript:void(0)" class="btn btn-info-soft btn-sm" id="add-timesheet-rejected">
            Add Timesheet
        </a>
    </li>
@else
    <li class="breadcrumb-item">
        <a class="btn btn-info-soft btn-sm" href="{{ url('timesheet/create') }}">
            Add Timesheet
        </a>
    </li>
@endif

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('add-timesheet-rejected').addEventListener('click', function() {
        Swal.fire({
            title: 'Pending Rejected Timesheet',
            text: 'Please submit your rejected timesheet first. Are you sure you want to proceed?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Proceed',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '{{ url('rejectedlist') }}';
            }
        });
    });
</script>

{{--  Start Hare --}}
{{-- * regarding sweetalert / regarding alert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire("SweetAlert2 is working!");
    //    Start Hare
    Swal.fire({
        title: "The Internet?",
        text: "That thing is still around?",
        icon: "question"
    });
    //    Start Hare
    Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "Something went wrong!",
        footer: '<a href="#">Why do I have this issue?</a>'
    });
    //    Start Hare
    Try me!
        Swal.fire({
            imageUrl: "https://placeholder.pics/svg/300x1500",
            imageHeight: 1500,
            imageAlt: "A tall image"
        });
    //    Start Hare
    Swal.fire({
        title: "Drag me!",
        icon: "success",
        draggable: true
    });
    //    Start Hare
    Swal.fire({
        title: "<strong>HTML <u>example</u></strong>",
        icon: "info",
        html: `
    You can use <b>bold text</b>,
    <a href="#" autofocus>links</a>,
    and other HTML tags
  `,
        showCloseButton: true,
        showCancelButton: true,
        focusConfirm: false,
        confirmButtonText: `
    <i class="fa fa-thumbs-up"></i> Great!
  `,
        confirmButtonAriaLabel: "Thumbs up, great!",
        cancelButtonText: `
    <i class="fa fa-thumbs-down"></i>
  `,
        cancelButtonAriaLabel: "Thumbs down"
    });
    //    Start Hare
    Swal.fire({
        title: "Do you want to save the changes?",
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: "Save",
        denyButtonText: `Don't save`
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire("Saved!", "", "success");
        } else if (result.isDenied) {
            Swal.fire("Changes are not saved", "", "info");
        }
    });

    //    Start Hare
    Swal.fire({
        position: "top-end",
        icon: "success",
        title: "Your work has been saved",
        showConfirmButton: false,
        timer: 1500
    });

    //    Start Hare
    Swal.fire({
        title: "Custom animation with Animate.css",
        showClass: {
            popup: `
      animate__animated
      animate__fadeInUp
      animate__faster
    `
        },
        hideClass: {
            popup: `
      animate__animated
      animate__fadeOutDown
      animate__faster
    `
        }
    });
    //    Start Hare
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: "Deleted!",
                text: "Your file has been deleted.",
                icon: "success"
            });
        }
    });
    //    Start Hare
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success",
            cancelButton: "btn btn-danger"
        },
        buttonsStyling: false
    });
    swalWithBootstrapButtons.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel!",
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            swalWithBootstrapButtons.fire({
                title: "Deleted!",
                text: "Your file has been deleted.",
                icon: "success"
            });
        } else if (
            /* Read more about handling dismissals below */
            result.dismiss === Swal.DismissReason.cancel
        ) {
            swalWithBootstrapButtons.fire({
                title: "Cancelled",
                text: "Your imaginary file is safe :)",
                icon: "error"
            });
        }
    });
    //    Start Hare
    Swal.fire({
        title: "Sweet!",
        text: "Modal with a custom image.",
        imageUrl: "https://unsplash.it/400/200",
        imageWidth: 400,
        imageHeight: 200,
        imageAlt: "Custom image"
    });
    //    Start Hare
    Swal.fire({
        title: "Custom width, padding, color, background.",
        width: 600,
        padding: "3em",
        color: "#716add",
        background: "#fff url(/images/trees.png)",
        backdrop: `
    rgba(0,0,123,0.4)
    url("/images/nyan-cat.gif")
    left top
    no-repeat
  `
    });
    //    Start Hare
    et timerInterval;
    Swal.fire({
        title: "Auto close alert!",
        html: "I will close in <b></b> milliseconds.",
        timer: 2000,
        timerProgressBar: true,
        didOpen: () => {
            Swal.showLoading();
            const timer = Swal.getPopup().querySelector("b");
            timerInterval = setInterval(() => {
                timer.textContent = `${Swal.getTimerLeft()}`;
            }, 100);
        },
        willClose: () => {
            clearInterval(timerInterval);
        }
    }).then((result) => {
        if (result.dismiss === Swal.DismissReason.timer) {
            console.log("I was closed by the timer");
        }
    });
    //    Start Hare
    Swal.fire({
        title: "هل تريد الاستمرار؟",
        icon: "question",
        iconHtml: "؟",
        confirmButtonText: "نعم",
        cancelButtonText: "لا",
        showCancelButton: true,
        showCloseButton: true
    });
    //    Start Hare

    Swal.fire({
        title: "Submit your Github username",
        input: "text",
        inputAttributes: {
            autocapitalize: "off"
        },
        showCancelButton: true,
        confirmButtonText: "Look up",
        showLoaderOnConfirm: true,
        preConfirm: async (login) => {
            try {
                const githubUrl = `
        https://api.github.com/users/${login}
      `;
                const response = await fetch(githubUrl);
                if (!response.ok) {
                    return Swal.showValidationMessage(`
          ${JSON.stringify(await response.json())}
        `);
                }
                return response.json();
            } catch (error) {
                Swal.showValidationMessage(`
        Request failed: ${error}
      `);
            }
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: `${result.value.login}'s avatar`,
                imageUrl: result.value.avatar_url
            });
        }
    });
    //    Start Hare
    //    Start Hare
    //    Start Hare
</script>
{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare --}}

<style>
    /* Filter section */
    .filter-maincontainer {
        display: grid;
        grid-template-columns: 1fr;
        gap: 25px;
        margin-top: 25px;
        margin-left: 23px;
        margin-right: 23px;
    }

    .filtercontainer {
        background: white;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
        border: 1px solid #e0e0e0;
    }

    .filtercontainer:hover {
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }

    /* Custom Button Styles */
    .btn-custom {
        padding: 12px 28px;
        font-size: 15px;
        font-weight: 600;
        border-radius: 8px;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
        margin-right: 15px;
        min-width: 160px;
        text-align: center;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .btn-dashboard {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
    }

    .btn-dashboard:hover {
        background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .btn-report {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
        border: none;
    }

    .btn-report:hover {
        background: linear-gradient(135deg, #e686f7 0%, #f14a62 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(245, 87, 108, 0.4);
        color: white;
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .btn-custom {
            display: block;
            width: 100%;
            margin-right: 0;
            margin-bottom: 12px;
        }

        .filtercontainer {
            padding: 20px;
        }
    }
</style>

<div class="filter-maincontainer">
    <div class="filtercontainer">
        <a href="" class="btn-custom btn-dashboard" role="button">
            Dashboard
        </a>
        <a href="" class="btn-custom btn-report" role="button">
            Dashboard Report
        </a>
    </div>
</div>
{{--  Start Hare --}}

@php
    $timesheetData = $query->get();
    $firstRow = $timesheetData->first();

    return view('backEnd.timesheet.weeklylist', compact('timesheetData', 'firstRow'));

@endphp

@if (Auth::user()->role_id == 11 || ($firstRow && Auth::user()->teammember_id != $firstRow->createdby))
    <th>Action</th>
@endif



@if (Auth::user()->role_id == 11 ||
        (isset($timesheetData[0]) && Auth::user()->teammember_id != $timesheetData[0]->createdby))
    <th>Action</th>
@endif

@if (Auth::user()->role_id == 11 ||
        ($timesheetData->count() > 0 && Auth::user()->teammember_id != $timesheetData[0]->createdby))
    <th>Action</th>
@endif


{{-- ! End hare --}}
{{-- * regarding cache in blade file /   --}}
{{--  Start Hare --}}
all cache store this location
storage\framework\views
storage\framework\views\2d8ab15d1e529421574a5bed535ae1dd83623bfb.php

{{--  Start Hare --}}

{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare --}}
<td>
    {{ $row->totalinvoiceamt ? number_format($row->totalinvoiceamt, 0, '.', ',') : 'N/A' }}
</td>
{{--  Start Hare --}}
<table id="examplee" class="table display table-bordered table-striped table-hover">
    <thead>
        <tr>
            <th style="display: none;">id</th>
            <th class="textfixed">Assignment Code</th>
            <th class="textfixed">Client Name</th>
            <th class="textfixed">Assignment Name</th>
            <th class="textfixed">Partner Name</th>
            <th class="textfixed">Document Completed Date</th>
            <th class="textfixed">Status</th>
            <th class="textfixed">Assignment Closed Date</th>
            <th class="textfixed">Assignment Created Date</th>
            <th class="textfixed">Total Invoices</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($assignments as $row)
            @php
                $filteredInvoices = $row->invoices->where('status', 2);
                $hasInvoices = $filteredInvoices->count() >= 1;
                $statusColor =
                    $row->assignmentBudgeting &&
                    $row->assignmentBudgeting->percentclosedate &&
                    $row->invoices->isNotEmpty()
                        ? 'success'
                        : 'danger';
                $statusText =
                    $row->assignmentBudgeting &&
                    $row->assignmentBudgeting->percentclosedate &&
                    $row->invoices->isNotEmpty()
                        ? 'Completed'
                        : 'Not Completed';
            @endphp

            <!-- Main Assignment Row -->
            <tr class="assignment-row {{ $hasInvoices ? 'has-invoices' : '' }}">
                <td style="display: none;">{{ $row->id }}</td>
                <td class="fw-semibold text-primary">{{ $row->assignmentgenerate_id }}</td>
                <td>{{ optional($row->assignmentBudgeting->client)->client_name ?? 'N/A' }}</td>
                <td class="textfixed">{{ optional($row->assignmentBudgeting)->assignmentname ?? 'N/A' }}
                </td>
                <td>{{ optional($row->leadPartner)->team_member ?? 'N/A' }}</td>
                <td class="text-nowrap">
                    {{ optional($row->assignmentBudgeting)->percentclosedate ?? 'N/A' }}</td>
                <td class="textfixed">
                    <span class="badge bg-{{ $statusColor }}">{{ $statusText }}</span>
                </td>
                <td class="text-nowrap">
                    {{ $row->assignmentBudgeting && $row->assignmentBudgeting->otpverifydate
                        ? date('Y-m-d', strtotime($row->assignmentBudgeting->otpverifydate))
                        : 'N/A' }}
                </td>
                <td class="text-nowrap">{{ date('Y-m-d', strtotime($row->created_at)) }}</td>
                <td>
                    <span class="badge {{ $hasInvoices ? 'bg-success' : 'bg-secondary' }} px-2 py-1">
                        {{ $filteredInvoices->count() }}
                    </span>
                </td>
            </tr>

            <!-- Invoice Details Row -->
            @if ($hasInvoices)
                <tr class="invoice-details-row">
                    <td colspan="10" class="p-0 border-0">
                        <div class="invoice-container m-3 p-3 bg-light rounded border">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0 text-dark fw-bold">
                                    <i class="fas fa-file-invoice me-2"></i>
                                    Invoice Details
                                    <small class="text-muted ms-2">({{ $filteredInvoices->count() }}
                                        invoices)</small>
                                </h6>
                                <span class="badge bg-info">Total Amount:
                                    ₹{{ number_format($filteredInvoices->sum('total') ?? 0, 2) }}</span>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-sm table-hover mb-0">
                                    <thead class="table-dark">
                                        <tr>
                                            <th width="15%">Invoice Number</th>
                                            <th width="12%">Date of Invoice</th>
                                            <th width="15%">Basic Amount</th>
                                            <th width="12%">OPE</th>
                                            <th width="12%">GST</th>
                                            <th width="15%">Total Amount</th>
                                            <th width="19%">Payment Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($filteredInvoices as $invoice)
                                            @php
                                                $gstAmount = ($invoice->total ?? 0) - ($invoice->amount ?? 0);
                                                $paymentStatus = $invoice->paymentstatus;
                                                $statusBadge = $paymentStatus
                                                    ? '<span class="badge bg-success">' . e($paymentStatus) . '</span>'
                                                    : '<span class="badge bg-danger">Not Received</span>';
                                            @endphp
                                            <tr>
                                                <td class="fw-semibold text-primary">
                                                    {{ $invoice->invoice_id ?? 'N/A' }}</td>
                                                <td class="text-nowrap">
                                                    {{ $invoice->created_at ? date('M d, Y', strtotime($invoice->created_at)) : 'N/A' }}
                                                </td>
                                                <td class="text-success fw-semibold">
                                                    ₹{{ number_format($invoice->amount ?? 0, 2) }}</td>
                                                <td>₹{{ number_format($invoice->pocketexpenseamount ?? 0, 2) }}
                                                </td>
                                                <td class="text-info">
                                                    ₹{{ number_format($gstAmount, 2) }}</td>
                                                <td class="fw-bold text-dark">
                                                    ₹{{ number_format($invoice->total ?? 0, 2) }}</td>
                                                <td>{!! $statusBadge !!}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    @if ($filteredInvoices->count() > 1)
                                        <tfoot class="table-active">
                                            <tr>
                                                <td colspan="2" class="fw-bold text-end">Totals:</td>
                                                <td class="fw-bold">
                                                    ₹{{ number_format($filteredInvoices->sum('amount') ?? 0, 2) }}
                                                </td>
                                                <td class="fw-bold">
                                                    ₹{{ number_format($filteredInvoices->sum('pocketexpenseamount') ?? 0, 2) }}
                                                </td>
                                                <td class="fw-bold">
                                                    ₹{{ number_format($filteredInvoices->sum('total') - $filteredInvoices->sum('amount'), 2) }}
                                                </td>
                                                <td class="fw-bold">
                                                    ₹{{ number_format($filteredInvoices->sum('total') ?? 0, 2) }}
                                                </td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    @endif
                                </table>
                            </div>
                        </div>
                    </td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>
{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare --}}
<select class="language form-control" id="categoryy" name="teammember">
    <option value="">Please Select One</option>
    @php
        $latestStaffCodes = DB::table('teamrolehistory')
            ->select('teammember_id', 'newstaff_code')
            ->whereIn('id', function ($query) {
                $query->selectRaw('MAX(id)')->from('teamrolehistory')->groupBy('teammember_id');
            })
            ->pluck('newstaff_code', 'teammember_id');
    @endphp
    @foreach ($teammember as $teammemberData)
        @php
            $teamstaffcode = $latestStaffCodes[$teammemberData->id] ?? $teammemberData->staffcode;
        @endphp
        <option value="{{ $teammemberData->id }}">
            {{ $teammemberData->team_member }} ({{ $teamstaffcode ?? 'N/A' }})
        </option>
    @endforeach
</select>
@php
    // Get all latest newstaff_codes grouped by teammember_id
    $teamRoleHistory = DB::table('teamrolehistory')
        ->orderBy('created_at', 'desc')
        ->get()
        ->groupBy('teammember_id')
        ->map(function ($records) {
            return $records->first()->newstaff_code;
        });
@endphp

@foreach ($teammember as $member)
    @php
        // Pick latest newstaff_code if available, else fallback to staffcode
        $staffCode = $teamRoleHistory[$member->id] ?? $member->staffcode;
    @endphp
    <option value="{{ $member->id }}">
        {{ $member->team_member }} ({{ $staffCode ?? 'N/A' }})
    </option>
@endforeach

{{--  Start Hare --}}
<td>{{ ($row->totalusercost ?? 0) + ($row->totalconveyancesamt ?? 0) }}</td>
<td>{{ number_format(($row->totalusercost ?? 0) + ($row->totalconveyancesamt ?? 0), 2) }}
</td>
{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare --}}
{{--  Start Hare --}}
<link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css') }}" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">

@extends('backEnd.layouts.layout') @section('backEnd_content')
    <div class="content-header row align-items-center m-0">
        <div class="col-sm-6 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
                <div class="media-body">
                    <h1 class="font-weight-bold">Home</h1>
                    <small>Assignment List</small>
                </div>
            </div>
        </div>
    </div>
    <div class="body-content">
        <div class="card mb-4">
            <div class="card-body">
                <br>
                <div class="table-responsive">
                    <table id="examplee" class="table display table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th style="display: none;">id</th>
                                <th class="textfixed">Assignment Code</th>
                                <th class="textfixed">Client Name</th>
                                <th class="textfixed">Assignment Name</th>
                                <th class="textfixed">Partner Name</th>
                                <th class="textfixed">Document Completed Date</th>
                                <th class="textfixed">Total Invoices</th>
                                <th class="textfixed">Status</th>
                                <th class="textfixed">Assignment Closed Date</th>
                                <th class="textfixed">Assignment Created Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($assignments as $row)
                                @php
                                    $filteredInvoices = $row->invoices->where('status', 2);
                                @endphp
                                <tr data-invoices='@json($filteredInvoices)'>
                                    <td style="display: none;">{{ $row->id }}</td>
                                    <td>{{ $row->assignmentgenerate_id }}</td>
                                    <td>{{ optional($row->assignmentBudgeting->client)->client_name ?? 'N/A' }}</td>
                                    <td class="textfixed">
                                        {{ optional($row->assignmentBudgeting)->assignmentname ?? 'N/A' }}
                                    </td>
                                    <td>{{ optional($row->leadPartner)->team_member ?? 'N/A' }}</td>
                                    <td>{{ optional($row->assignmentBudgeting)->percentclosedate ?? 'N/A' }}</td>
                                    <td>
                                        <span
                                            class="badge toggle-invoices"style=" background-color: e5e7eb; height: 21px; width: 59px; cursor: pointer;">
                                            {{ $filteredInvoices->count() }}
                                        </span>
                                    </td>
                                    <td class="textfixed">
                                        @if ($row->assignmentBudgeting && $row->assignmentBudgeting->percentclosedate && $row->invoices->isNotEmpty())
                                            <b style="color:green;">Completed</b>
                                        @else
                                            <b style="color:red;">Not Completed</b>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $row->assignmentBudgeting && $row->assignmentBudgeting->otpverifydate
                                            ? date('Y-m-d', strtotime($row->assignmentBudgeting->otpverifydate))
                                            : 'N/A' }}
                                    </td>
                                    <td>{{ date('Y-m-d', strtotime($row->created_at)) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
<script>
    $(document).ready(function() {
        var table = $('#examplee').DataTable({
            dom: 'Bfrtip',
            "order": [
                [0, "desc"]
            ],

            buttons: [

                {
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: [0, ':visible']
                    }
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: [0, 1, 2, 5]
                    }
                },
                'colvis'
            ]
        });

        // click on invoice number count 
        $('#examplee tbody').on('click', '.toggle-invoices', function() {
            var tr = $(this).closest('tr');
            var row = table.row(tr);

            if (row.child.isShown()) {
                // expand row hide
                row.child.hide();
                tr.removeClass('shown');
            } else {
                // expand row show
                var invoices = tr.data('invoices');
                var html = '<div class="p-3" style="background-color: white">' +
                    '<h6 style="display: flex; justify-content: space-between; align-items: center;">' +
                    '<b>Invoice Details</b>' +
                    '<i class="fa fa-times close-icon" style="cursor: pointer;"></i>' +
                    '</h6>' +
                    '<table class="table table-sm table-bordered">' +
                    '<thead><tr>' +
                    '<th>Invoice Number</th><th>Date of Invoice</th><th>Basic Invoice Amount</th><th>OPE</th><th>GST</th><th>Total Invoice Amount</th><th>Payment Status</th>' +
                    '</tr></thead><tbody>';

                invoices.forEach(function(inv) {
                    let paymentstatusBadge = '';

                    if (inv.paymentstatus == null) {
                        paymentstatusBadge = '<b style="color:red;">Not Received</b>';
                    } else {
                        paymentstatusBadge = '<b style="color:#28A745;">' + (inv
                            .paymentstatus ??
                            'N/A') + '</b>';

                    }

                    html += '<tr>' +
                        '<td>' + (inv.invoice_id ?? 'N/A') + '</td>' +
                        '<td>' + (inv.created_at ? new Date(inv.created_at).toISOString().split(
                            "T")[0] : 'N/A') + '</td>' +
                        '<td>' + (inv.amount ?? 0) + '</td>' +
                        '<td>' + (inv.pocketexpenseamount ?? 0) + '</td>' +
                        '<td>' + ((inv.total ?? 0) - (inv.amount ?? 0)) + '</td>' +
                        '<td>' + (inv.total ?? 0) + '</td>' +
                        '<td>' + paymentstatusBadge + '</td>' +
                        '</tr>';
                });

                html += '</tbody></table></div>';

                row.child(html).show();
                tr.addClass('shown');
            }
        });

        $('#examplee tbody').on('click', '.close-icon', function(e) {
            // prevent toggle-invoices click
            e.stopPropagation();

            // find the parent row from the child row div
            var tr = $(this).closest('tr')
                .prev();
            var row = table.row(tr);
            row.child.hide();
            tr.removeClass('shown');
        });
    });
</script>

{{-- ! End hare --}}
{{-- * regarding badge   --}}
{{--  Start Hare --}}
{{--  Start Hare --}}

<td>
    <span class="badge toggle-invoices"style=" background-color: e5e7eb; height: 21px; width: 59px; cursor: pointer;">
        {{ $filteredInvoices->count() }}
    </span>
</td>
<span class="badge toggle-invoices"
    style="background-color: #e5e7eb; height: 21px; width: 59px; cursor: pointer; display: inline-block; text-align: center; line-height: 21px;">
    {{ $filteredInvoices->count() }}
</span>


{{-- <span>
                                            <i class="fa fa-chevron-right"></i>
                                            <i class="fa fa-chevron-down"></i>
                                        </span> --}}

{{-- ! End hare --}}
{{-- * regarding Eloquent relationships / regarding Eloquent model / regarding relationship  --}}

{{--  Start Hare --}}
{{--  Start Hare --}}
{{--  Start Hare --}}
@php
    $filteredInvoices = $row->invoices->where('status', 2);
@endphp

<td>{{ $filteredInvoices->pluck('invoice_id')->implode(', ') ?: 'N/A' }}</td>
<td>{{ $filteredInvoices->pluck('created_at')->map(fn($d) => \Carbon\Carbon::parse($d)->format('Y-m-d'))->implode(', ') ?: 'N/A' }}
</td>
<td>{{ $filteredInvoices->pluck('total')->implode(', ') ?: 'N/A' }}</td>
<td>{{ $filteredInvoices->pluck('pocketexpenseamount')->implode(', ') ?: 'N/A' }}</td>
{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare --}}
{{--  Start Hare --}}

<button class="btn btn-info" onclick="printDiv('printableArea', 'offer_letter.pdf')"><i
        class="fa fa-print"></i>&nbsp;Print</button>


<script>
    function printDiv(divName) {

        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        console.log("divName:", divName);
        console.log("printContents:", printContents);
        console.log("originalContents:", originalContents);


        window.print();

        document.body.innerHTML = originalContents;
    }
</script>


<script src="https://rawgit.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>

<script>
    function downloadPdf(divName, pdfName) {
        var element = document.getElementById(divName);

        html2pdf(element, {
            margin: 10,
            filename: pdfName,
            image: {
                type: 'jpeg',
                quality: 0.98
            },
            html2canvas: {
                scale: 2
            },
            jsPDF: {
                unit: 'mm',
                format: 'a4',
                orientation: 'portrait'
            }
        }).then(function() {
            console.log("PDF downloaded successfully");
        });
    }
</script>

<button class="btn btn-secondary" style="color:white;"
    onclick="downloadPdf('printableArea', 'offer_letter.pdf')">Download PDF</button>
{{-- ! End hare --}}
{{-- * regarding url with parameter  --}}
{{--  Start Hare --}}
<div>

    ✅ All possible ways to build a URL like this in Laravel Blade
    1. Using url() and string concatenation (your existing example)
    <a
        href="{{ url('billspendingforcollection?' . 'partnerId=' . $partnerId . '&&' . 'yearly=' . $yearly . '&&' . 'monthsdigit=' . $monthsdigit) }}">


        Notes:

        Simple and straightforward.

        Works, but error-prone if variables are null or empty.

        Use when you're quickly prototyping or working with static variables.

        2. Using url() with http_build_query() (recommended)
        @php
            $queryParams = [];

            if (!empty($partnerId)) {
                $queryParams['partnerId'] = $partnerId;
            }
            if (!empty($yearly)) {
                $queryParams['yearly'] = $yearly;
            }
            if (!empty($monthsdigit)) {
                $queryParams['monthsdigit'] = $monthsdigit;
            }

            $url =
                url('billspendingforcollection') . (!empty($queryParams) ? '?' . http_build_query($queryParams) : '');
        @endphp

        <a href="{{ $url }}">


            Notes:

            Cleaner, more flexible.

            Automatically handles empty or missing parameters.

            Safer than manual concatenation.

            Recommended for maintainability.

            3. Using route() with named routes and array_filter()

            Define your route in web.php:

            Route::get('/billspendingforcollection', [DashboardReport::class,
            'billspendingforcollection'])->name('billspendingforcollection');


            In your Blade template:

            @php
                $queryParams = array_filter([
                    'partnerId' => $partnerId,
                    'yearly' => $yearly,
                    'monthsdigit' => $monthsdigit,
                ]);
            @endphp

            <a href="{{ route('billspendingforcollection', $queryParams) }}">


                Notes:

                Best when you have named routes.

                array_filter() removes empty or null values.

                Cleaner and more Laravel-like.

                Use this approach for larger apps with route caching and better structure.

                4. Using request()->fullUrlWithQuery()

                If you're adding or modifying query parameters on the current URL:

                <a
                    href="{{ request()->fullUrlWithQuery([
                        'partnerId' => $partnerId,
                        'yearly' => $yearly,
                        'monthsdigit' => $monthsdigit,
                    ]) }}">


                    Notes:

                    Extends the current URL.

                    Good if you're on a page that already has query parameters and want to add or override them.

                    5. Using route() with query() in Laravel 9+

                    Laravel provides helper methods like this:

                    <a
                        href="{{ route('billspendingforcollection')->withQuery(['partnerId' => $partnerId, 'yearly' => $yearly, 'monthsdigit' => $monthsdigit]) }}">


                        (Note: This is a pseudo-code; Laravel doesn't support this out-of-the-box but it's achievable
                        with custom macros or extending URL generation.)

                        6. Using Blade components

                        You can wrap URL logic inside a Blade component:

                        <x-link-button :href="route(
                            'billspendingforcollection',
                            array_filter([
                                'partnerId' => $partnerId,
                                'yearly' => $yearly,
                                'monthsdigit' => $monthsdigit,
                            ]),
                        )">
                            Click here
                        </x-link-button>


                        Notes:

                        Use this when you want reusable buttons or links across your app.

                        Improves readability and reusability.

                        7. Using Laravel Collective's Form helpers (if installed)
                        {!! link_to_route('billspendingforcollection', 'View Bills', [
                            'partnerId' => $partnerId,
                            'yearly' => $yearly,
                            'monthsdigit' => $monthsdigit,
                        ]) !!}


                        Notes:

                        Requires Laravel Collective package.

                        Simplifies link generation.

                        8. Using JavaScript if needed

                        If URL generation is complex and based on user interactions:

                        <a href="#"
                            onclick="window.location='{{ url('billspendingforcollection') }}?partnerId={{ $partnerId }}&yearly={{ $yearly }}&monthsdigit={{ $monthsdigit }}'">
                            View Bills
                        </a>


                        Notes:

                        Avoid unless necessary.

                        Useful for dynamically updating URL based on form inputs or buttons.

                        ✅ Summary Table
                        Method Laravel-friendly? Handles empty params? Best for
                        url() + concat ✔ ❌ Quick prototypes
                        url() + http_build_query() ✔✔ ✔ Most flexible for queries
                        route() + array_filter() ✔✔ ✔ Best structured, named routes
                        request()->fullUrlWithQuery() ✔✔ ✔ Extend current URL
                        Blade components ✔✔ ✔ Reusable links/buttons
                        Laravel Collective ✔ ✔ If package installed
                        JS onclick ❌ ❌ Interactive or dynamic changes
                        ✅ Conclusion

                        You can create URLs in multiple ways depending on the use case:

                        Use url() with http_build_query() for simple query building.

                        Prefer named routes with route() and array_filter() for structured and maintainable code.

                        Use request()->fullUrlWithQuery() when working with existing URLs.

                        Consider components or packages for reusable or advanced solutions.

                        Pick the approach based on your project size, team practices, and readability!
</div>
{{--  Start Hare --}}
{{-- ! End hare --}}
{{-- * regarding continue / regarding skip    --}}
{{--  Start Hare --}}
{{--  Start Hare --}}
@foreach ($clientspecificindependencedeclaration as $independenceData)
    @php
        $independences = DB::table('annual_independence_declarations')
            ->where('assignmentgenerateid', $independenceData->assignmentgenerate_id)
            ->where('createdby', $independenceData->id)
            ->first();

        $independencescount = DB::table('annual_independence_declarations')
            ->where('assignmentgenerateid', $independenceData->assignmentgenerate_id)
            ->where('createdby', $independenceData->id)
            ->first();

    @endphp

    @if (Request::is('İndependence/pending') && $independences != null)
        @continue
    @endif

    <tr>
        <td style="display: none;">{{ $independenceData->id }}</td>
    </tr>
@endforeach

{{--  Start Hare --}}
@if (Request::is('İndependence/pending') && $independences != null)
    @continue
@endif
{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare --}}
{{--  Start Hare --}}
<td class="text-success textfixed" style="padding: 17px;">
    @php
        $dueDate = Carbon\Carbon::parse($ticket['created_at']);
        $today = Carbon\Carbon::today();
        $diffInDays = $today->diffInDays($dueDate); // Absolute difference without direction
        if ($today->greaterThan($dueDate)) {
            $diffInDays += 1; // Add 1 to include the start day when due date is past
        }
    @endphp
    {{ $ticket['created_at'] }} / {{ $diffInDays }}
</td>
{{-- ! End hare --}}
{{-- * regarding chart / regarding graph  --}}
{{--  Start Hare --}}
{{--  Start Hare --}}
<!-- Monthly Expense Analysis -->
<div class="card">
    <div class="card-header">
        <h2>Monthly Expense Analysis</h2>
    </div>
    <canvas id="expenseChart" width="auto" height="250"></canvas>
</div>

<script>
    const expenseCtx = document.getElementById('expenseChart').getContext('2d');
    const expenseChart = new Chart(expenseCtx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                    label: 'Revenue',
                    data: [140000, 110000, 130000, 120000, 120000, 140000],
                    backgroundColor: 'rgb(59, 130, 246)',
                    borderColor: 'rgb(59, 130, 246)',
                    borderWidth: 1
                },
                {
                    label: 'Expenses',
                    data: [55000, 60000, 40000, 70000, 75000, 50000],
                    backgroundColor: 'rgb(239, 68, 68)',
                    borderColor: 'rgb(239, 68, 68)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            scales: {
                y: {
                    max: 140000,
                    beginAtZero: true,
                    ticks: {
                        stepSize: 35000
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
</script>

<!-- Cash Flow Analysis -->
<div class="card">
    <div class="card-header">
        <h2>Cash Flow Analysis</h2>
    </div>
    <canvas id="cashFlowChart" width="auto" height="250"></canvas>
</div>

<script>
    const cashFlowCtx = document.getElementById('cashFlowChart').getContext('2d');
    const cashFlowChart = new Chart(cashFlowCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                    label: 'Inflow',
                    data: [400000, 350000, 350000, 400000, 500000, 700000],
                    borderColor: 'rgba(75, 192, 75, 1)',
                    backgroundColor: 'rgba(75, 192, 75, 0.2)',
                    borderWidth: 2,
                    fill: false
                },
                {
                    label: 'Net Cash',
                    data: [100000, 80000, 90000, 120000, 130000, 150000],
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderWidth: 2,
                    fill: false
                },
                {
                    label: 'Outflow',
                    data: [-400000, -350000, -300000, -250000, -200000, -200000],
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
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '$' + value;
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top'
                }
            }
        }
    });
</script>
{{--  Start Hare --}}
<div class="card">
    <div class="card-header">
        <h2>Cash Flow Analysis</h2>
    </div>
    <canvas id="cashFlowChart" width="auto" height="250"></canvas>
</div>

<script>
    const ctx = document.getElementById('cashFlowChart').getContext('2d');
    const cashFlowChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                    label: 'Inflow',
                    data: [400000, 350000, 350000, 400000, 500000, 700000],
                    borderColor: 'rgba(75, 192, 75, 1)',
                    backgroundColor: 'rgba(75, 192, 75, 0.2)',
                    borderWidth: 2,
                    fill: false
                },
                {
                    label: 'Net Cash',
                    data: [100000, 80000, 90000, 120000, 130000, 150000],
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderWidth: 2,
                    fill: false
                },
                {
                    label: 'Outflow',
                    data: [-400000, -350000, -300000, -250000, -200000, -200000],
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
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '$' + value;
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top'
                }
            }
        }
    });
</script>
{{--  Start Hare --}}

<div class="card">
    <div class="card-header">
        <h2>Monthly Expense Analysis</h2>
    </div>
    <canvas id="expenseChart" width="auto" height="250"></canvas>
</div>

<script>
    const ctx = document.getElementById('expenseChart').getContext('2d');
    const revenueData = [140000, 110000, 130000, 120000, 120000, 140000];
    const expenseData = [55000, 60000, 40000, 70000, 75000, 50000];
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
                    borderWidth: 1
                },
                {
                    label: 'Expenses',
                    data: expenseData,
                    backgroundColor: 'rgb(239, 68, 68)',
                    borderColor: 'rgb(239, 68, 68)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    max: 150000,
                    ticks: {
                        callback: function(value) {
                            return value;
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            // Show nothing on individual bar hover
                            return null;
                        },
                        afterBody: function(context) {
                            const index = context[0].dataIndex;
                            const month = months[index];
                            const revenue = revenueData[index];
                            const expense = expenseData[index];

                            return [
                                `${month}`,
                                `Revenue: ${revenue}`,
                                `Expense: ${expense}`
                            ];
                        },
                        title: function() {
                            return ''; // Prevent duplicate title
                        }
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
<div class="card">
    <div class="card-header">
        <h2>Monthly Expense Analysis</h2>
    </div>
    <canvas id="expenseChart" width="auto" height="250"></canvas>
</div>

<script>
    const ctx = document.getElementById('expenseChart').getContext('2d');
    const revenueData = [140000, 110000, 130000, 120000, 120000, 140000];
    const expenseData = [55000, 60000, 40000, 70000, 75000, 50000];
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];

    const expenseChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
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

            // plugins: {
            //     legend: {
            //         // position: 'top'
            //         // position: 'bottom'
            //         display: false
            //     },
            //     tooltip: {
            //         callbacks: {
            //             label: function(context) {
            //                 // Show nothing on individual bar hover
            //                 return null;
            //             },
            //             afterBody: function(context) {
            //                 // Gets the index of the hovered item.
            //                 const index = context[0].dataIndex;
            //                 // Retrieves corresponding month, revenue, and expense values using that index
            //                 const month = months[index];
            //                 const revenue = revenueData[index];
            //                 const expense = expenseData[index];
            //                 // Returns a custom array of strings that will be shown in the tooltip:
            //                 return [
            //                     `${month}`,
            //                     `Revenue: ${revenue}`,
            //                     `Expense: ${expense}`
            //                 ];
            //             },
            //             title: function() {
            //                 return ''; //Returning '' means it shows no title, preventing repetition of the month name (since it's already in afterBody).
            //             }
            //         }
            //     }
            // },
            // // Controls how users interact with tooltips.
            // interaction: {
            //     mode: 'index',
            //     intersect: false
            // }

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
{{--  Start Hare costomise chart  --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Chart.js Custom Tooltip</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        #chart-container {
            width: 60%;
            margin: 50px auto;
        }

        .chartjs-tooltip {
            background: white;
            border: 1px solid #ccc;
            padding: 8px 12px;
            border-radius: 6px;
            position: absolute;
            pointer-events: none;
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: black;
            white-space: nowrap;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .tooltip-revenue {
            color: blue;
        }

        .tooltip-expense {
            color: red;
        }
    </style>
</head>

<body>
    <div id="chart-container">
        <canvas id="myChart"></canvas>
        <div id="tooltip" class="chartjs-tooltip" style="opacity: 0;"></div>
    </div>

    <script>
        const labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May'];

        const data = {
            labels: labels,
            datasets: [{
                    label: 'Revenue',
                    data: [100000, 115000, 110000, 120000, 130000],
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                },
                {
                    label: 'Expense',
                    data: [60000, 65000, 68000, 70000, 72000],
                    backgroundColor: 'rgba(255, 99, 132, 0.6)',
                }
            ]
        };

        const config = {
            type: 'bar',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        enabled: false, // disable default tooltip
                        external: function(context) {
                            const tooltipModel = context.tooltip;
                            const tooltipEl = document.getElementById('tooltip');

                            // Hide if no tooltip
                            if (tooltipModel.opacity === 0) {
                                tooltipEl.style.opacity = 0;
                                return;
                            }

                            // Set content
                            const dataIndex = tooltipModel.dataPoints[0].dataIndex;
                            const revenue = context.chart.data.datasets[0].data[dataIndex];
                            const expense = context.chart.data.datasets[1].data[dataIndex];
                            const label = context.chart.data.labels[dataIndex];

                            tooltipEl.innerHTML = `
                <div><strong>${label}</strong></div>
                <div class="tooltip-revenue">Revenue: ${revenue}</div>
                <div class="tooltip-expense">Expense: ${expense}</div>
              `;

                            // Position tooltip
                            const {
                                offsetLeft: chartLeft,
                                offsetTop: chartTop
                            } = context.chart.canvas;
                            tooltipEl.style.opacity = 1;
                            tooltipEl.style.left = chartLeft + tooltipModel.caretX + 'px';
                            tooltipEl.style.top = chartTop + tooltipModel.caretY + 'px';
                        }
                    }
                }
            }
        };

        new Chart(document.getElementById('myChart'), config);
    </script>
</body>

</html>

{{--  Start Hare --}}
{{--  Start Hare --}}
<div class="card">
    <div class="card-header">
        <h2>Monthly Expense Analysis</h2>
    </div>
    <canvas id="expenseChart" width="auto" height="250"></canvas>
</div>

<script>
    const ctx = document.getElementById('expenseChart').getContext('2d');
    const expenseChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                    label: 'Revenue',
                    data: [140000, 110000, 130000, 120000, 120000, 140000],
                    backgroundColor: 'rgb(59, 130, 246)',
                    borderColor: 'rgb(59, 130, 246)',
                    borderWidth: 1 // border width
                },
                {
                    label: 'Expenses',
                    data: [55000, 60000, 40000, 70000, 75000, 50000],
                    backgroundColor: 'rgb(239, 68, 68)',
                    borderColor: 'rgb(239, 68, 68)',
                    borderWidth: 1 // border width
                }
            ]
        },
        options: {
            // scales: {
            //     y: {
            //         beginAtZero: true, // y axis start value from 0
            //         max: 150000, // set y axis max value
            //         // show y axis amount 
            //         ticks: {
            //             callback: function(value) {
            //                 // return '$' + value;
            //                 return value;
            //             }
            //         }
            //     }
            // },
            scales: {
                y: {
                    max: 140000,
                    beginAtZero: true, // y axis start value from 0
                    // min: 0,
                    ticks: {
                        stepSize: 35000
                    }
                }
            },
            plugins: {
                legend: {
                    // position: 'top'
                    // position: 'bottom'
                    display: false
                }
            }
        }
    });
</script>
{{--  Start Hare --}}
<style>
    #cashFlowChart {
        width: 100%;
        height: 300px;
    }

    #cashFlowChart1 {
        width: 100%;
        height: 300px;
    }

    #plChart {
        width: 100%;
        height: 300px;
    }

    #lapDaysChart {
        width: 100%;
        height: 300px;
    }

    #revenueChart {
        width: 100%;
        height: 300px;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div class="card">
    <div class="card-header">
        <h2>Monthly Expense Analysis</h2>
    </div>
    <canvas id="expenseChart" width="auto" height="250"></canvas>
</div>

<script>
    const ctx = document.getElementById('expenseChart').getContext('2d');
    const expenseChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                    label: 'Revenue',
                    data: [140000, 110000, 130000, 120000, 120000, 140000],
                    backgroundColor: 'rgb(59, 130, 246)',
                    borderColor: 'rgb(59, 130, 246)',
                    borderWidth: 1 // border width
                },
                {
                    label: 'Expenses',
                    data: [55000, 60000, 40000, 70000, 75000, 50000],
                    backgroundColor: 'rgb(239, 68, 68)',
                    borderColor: 'rgb(239, 68, 68)',
                    borderWidth: 1 // border width
                }
            ]
        },
        options: {
            // scales: {
            //     y: {
            //         beginAtZero: true, // y axis start value from 0
            //         max: 150000, // set y axis max value
            //         // show y axis amount 
            //         ticks: {
            //             callback: function(value) {
            //                 // return '$' + value;
            //                 return value;
            //             }
            //         }
            //     }
            // },
            scales: {
                y: {
                    max: 140000,
                    beginAtZero: true, // y axis start value from 0
                    // min: 0,
                    ticks: {
                        stepSize: 35000
                    }
                }
            },
            plugins: {
                legend: {
                    // position: 'top'
                    // position: 'bottom'
                    display: false
                }
            }
        }
    });
</script>
{{-- ! End hare --}}

{{-- * regarding fresh page /page create   --}}
{{--  Start Hare --}}
@extends('backEnd.layouts.layout') @section('backEnd_content')
    <div class="content-header row align-items-center m-0">
        <div class="col-sm-8 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="typcn typcn-user-add-outline"></i></div>
                <div class="media-body">
                    <a href="#">
                        <h1 class="font-weight-bold" style="color:black;">Teams KRA Dashboard</h1>
                    </a>
                    <small>View Key Responsibility Areas</small>
                </div>
            </div>
        </div>
    </div>

    <div class="body-content">
        <div class="card mb-4">
            <div class="card-header" style="background: #37A000;margin-bottom: 29px;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 style="color:white;" class="fs-17 font-weight-600 mb-0">
                            Key Responsibility Areas</h6>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="examplee" class="table display table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="textfixed">Employee Name</th>
                                <th class="textfixed">KRAs Status</th>
                                <th class="textfixed">Reporting Manager</th>
                                <th class="textfixed">Created Date</th>
                                <th class="textfixed">Updated Date</th>
                                {{-- @if ($teammembers && in_array($teammembers->designation, [13, 14])) --}}
                                <th>Action</th>
                                {{-- @endif --}}
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection


<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
<style>
    .dataTables_length {
        width: 300px;
        position: absolute;
    }
</style>
<script>
    $(document).ready(function() {
        $('#examplee').DataTable({
            "pageLength": 10,
            dom: 'lfrtip',
            columnDefs: [{
                targets: [1, 2],
                orderable: false
            }],
            buttons: [{
                    extend: 'excelHtml5',
                    filename: 'NA',
                    exportOptions: {
                        columns: ':visible'
                    },
                    customize: function(xlsx) {
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];
                        //   remove extra spaces
                        $('c', sheet).each(function() {
                            var originalText = $(this).find('is t').text();
                            var cleanedText = originalText.replace(/\s+/g, ' ').trim();
                            $(this).find('is t').text(cleanedText);
                        });
                    }
                },
                'colvis'
            ]
        });
    });
</script>

{{--  Start Hare --}}
@extends('backEnd.layouts.layout') @section('backEnd_content')
    <div class="content-header row align-items-center m-0">
        <div class="col-sm-8 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="typcn typcn-user-add-outline"></i></div>
                <div class="media-body">
                    <a href="#">
                        <h1 class="font-weight-bold" style="color:black;">Teams KRA Dashboard</h1>
                    </a>
                    <small>View Key Responsibility Areas</small>
                </div>
            </div>
        </div>
    </div>

    <div class="body-content">
        <div class="card mb-4">
            <div class="card-header" style="background: #37A000;margin-top: -16px;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 style="color:white;" class="fs-17 font-weight-600 mb-0">
                            Key Responsibility Areas</h6>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="examplee" class="table display table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="textfixed">Employee Name</th>
                                <th class="textfixed">KRAs Status</th>
                                <th class="textfixed">Reporting Manager</th>
                                <th class="textfixed">Created Date</th>
                                <th class="textfixed">Updated Date</th>
                                {{-- @if ($teammembers && in_array($teammembers->designation, [13, 14])) --}}
                                <th>Action</th>
                                {{-- @endif --}}
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection


<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
<style>
    .dt-buttons {
        margin-bottom: -34px;
    }
</style>
<script>
    $(document).ready(function() {
        $('#examplee').DataTable({
            dom: 'lBfrtip',
            columnDefs: [{
                targets: [1, 2],
                orderable: false
            }],
            buttons: [{
                    extend: 'excelHtml5',
                    filename: 'NA',
                    exportOptions: {
                        columns: ':visible'
                    },
                    customize: function(xlsx) {
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];
                        //   remove extra spaces
                        $('c', sheet).each(function() {
                            var originalText = $(this).find('is t').text();
                            var cleanedText = originalText.replace(/\s+/g, ' ').trim();
                            $(this).find('is t').text(cleanedText);
                        });
                    }
                },
                'colvis'
            ]
        });
    });
</script>

{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare --}}
{{--  Start Hare --}}
{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare --}}
{{--  Start Hare --}}
{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare --}}
{{--  Start Hare --}}
{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare --}}
{{--  Start Hare --}}
{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare --}}
@foreach ($designationData[$roleKey]['teammemberall'] as $index => $row)
    <tr>
        <td>{{ $index + 1 }}</td>
        <td>
            <div class="fw-bold">{{ $row->team_member }}</div>
            <div class="text-muted small">Article Trainee</div>
        </td>
        <td>
            {{-- @if ($row->kra_status === 'KRA') --}}
            <span class="badge bg-success">KRA</span>
            {{-- @else --}}
            <span class="badge bg-secondary">No KRA</span>
            {{-- @endif --}}
        </td>
        @if ($teammembers && in_array($teammembers->designation, [13, 1400, 1500]))
            <td>
                {{-- @if ($row->kra_status === 'KRA') --}}
                <a href="" class="btn btn-sm btn-outline-primary">View</a>
                <a href="" class="btn btn-sm btn-outline-warning">Update</a>
                <a href="" onclick="return confirm('Are you sure?')"
                    class="btn btn-sm btn-outline-danger">Delete</a>
                {{-- @else
              <a href="{{ route('kras.create', $row->id) }}"
                  class="btn btn-sm btn-outline-success">Upload</a>
          @endif --}}
            </td>
        @endif
    </tr>
@endforeach
{{--  Start Hare --}}
<script>
    $(document).ready(function() {
        function generateFields(date1Str, date2Str, existingDates = []) {
            let date1Parts = date1Str.split("-");
            let date2Parts = date2Str.split("-");

            let formattedDate1 = new Date(`${date1Parts[2]}-${date1Parts[1]}-${date1Parts[0]}`);
            let formattedDate2 = new Date(`${date2Parts[2]}-${date2Parts[1]}-${date2Parts[0]}`);

            let timeDifference = formattedDate2 - formattedDate1;
            let differenceDays = timeDifference / (1000 * 60 * 60 * 24);

            let fieldContainer = $("#fieldContainer");
            fieldContainer.empty();

            for (let i = 0; i <= differenceDays; i++) {
                let currentDate = new Date(formattedDate1);
                currentDate.setDate(currentDate.getDate() + i);

                let formattedDate = ('0' + currentDate.getDate()).slice(-2) + '-' +
                    ('0' + (currentDate.getMonth() + 1)).slice(-2) + '-' +
                    currentDate.getFullYear();

                if (existingDates.includes(formattedDate)) {
                    continue;
                }

                let extraClass = currentDate.getDay() === 0 ? 'd-none' : '';

                let fieldHtml = `
                <div class="field_wrapper p-3 mb-4 ${extraClass} extraSundayClass" data-index="${i+1}" style="border: 1px solid #ddd; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-radius: 8px;">
                    <div class="row row-sm mb-2">
                        <div class="col-2">
                            <input type="text" id="day${i+1}" name="day${i+1}" class="form-control" value="${formattedDate}" readonly>
                        </div>
                        <div class="col-2">
                            <input type="text" class="time form-control" id="totalhours${i+1}" name="totalhour${i+1}" value="{{ $timesheet->hour ?? '0' }}" autocomplete="off" readonly>
                        </div>
                    </div>
                    <div class="row row-sm showdiv${i+1}" id="additionalFields${i+1}">
                        <div class="col-2">
                            <div class="form-group">
                                <label class="font-weight-600">Client Name <span class="text-danger">*</span></label>
                                <select class="language form-control refresh" name="client_id${i+1}[]" id="client${i+1}">
                                    <option value="">Select Client</option>
                                    @foreach ($client as $clientData)
                                        <option value="{{ $clientData->id }}">{{ $clientData->client_name }} ({{ $clientData->client_code }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label class="font-weight-600">Assignment Name <span class="text-danger">*</span></label>
                                <select class="form-control key refreshoption assignmentvalue${i+1}" name="assignment_id${i+1}[]" id="assignment${i+1}"></select>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label class="font-weight-600">Partner <span class="text-danger">*</span></label>
                                <select class="language form-control refreshoption partnervalue${i+1}" id="partner${i+1}" name="partner${i+1}[]"></select>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label class="font-weight-600">Work Item <span class="text-danger">*</span></label>
                                <textarea name="workitem${i+1}[]" class="form-control key workItem${i+1} refresh workitemnvalue${i+1}" style="height: 40px;"></textarea>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label class="font-weight-600">Location <span class="text-danger">*</span></label>
                                <input type="text" name="location${i+1}[]" class="form-control key location${i+1} refresh locationvalue${i+1}">
                            </div>
                        </div>
                        <div class="col-1">
                            <div class="form-group">
                                <label class="font-weight-600">Hour <span class="text-danger">*</span></label>
                                <input type="number" class="form-control hour${i+1} refresh" id="hour${i+1}" name="hour${i+1}[]" oninput="calculateTotal(this)" value="0" step="1">
                            </div>
                        </div>
                        <div class="col-1">
                            <div class="form-group" style="margin-top: 36px;">
                                <a href="javascript:void(0);" class="add_button" id="plusbuttion${i+1}" data-index="${i+1}" title="Add field">
                                    <img src="{{ url('backEnd/image/add-icon.png') }}" />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>`;
                fieldContainer.append(fieldHtml);
            }
        }

        function fetchAndRender() {
            let date1Str = $("#datepickers1").val();
            let date2Str = $("#datepickers2").val();

            if (!date1Str || !date2Str) return;

            $.ajax({
                url: "{{ url('filterleavedata') }}",
                type: "GET",
                data: {
                    start_date: date1Str,
                    end_date: date2Str
                },
                success: function(existingDates) {
                    generateFields(date1Str, date2Str, existingDates);
                },
                error: function() {
                    alert("Something went wrong while fetching leave data.");
                }
            });
        }

        fetchAndRender();

    });
</script>


<script>
    $(document).ready(function() {
        let storedFields = {};
        $('#datepickers2').on('change', function() {
            const startDate = new Date($("#datepickers1").val().split('-').reverse().join('-'));
            const endDate = new Date($(this).val().split('-').reverse().join('-'));


            //  if (endDate.getDay() === 0) {
            //      $('.extraSundayClass').removeClass('d-none');
            //  }
            //  else {
            //      $('.extraSundayClass').addClass('d-none');
            //  }
            // Calculate all dates in the range
            const allDates = [];
            for (let d = new Date(startDate); d <= endDate; d.setDate(d.getDate() + 1)) {
                allDates.push(new Date(d));
            }

            // Process existing fields
            $('.field_wrapper').each(function() {
                const fieldDate = new Date($(this).find('input[name^="day"]').val().split('-')
                    .reverse().join('-'));

                if (fieldDate > endDate) {
                    // Store field if it's beyond the new end date
                    const dateKey = $(this).find('input[name^="day"]').val();
                    storedFields[dateKey] = $(this).detach();
                }
            });

            // Add back fields that are now within range
            allDates.forEach(date => {
                const dateStr = formatDate(date);
                if (storedFields[dateStr]) {
                    $('#fieldContainer').append(storedFields[dateStr]);
                    // After append delete from storedFields
                    delete storedFields[dateStr];
                }
            });
        });

        // Helper function to format date as dd-mm-yyyy
        function formatDate(date) {
            // hare padStart(2, '0') means like return 5 then it will be 05 
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            return `${day}-${month}-${date.getFullYear()}`;
        }
    });
</script>
{{--  Start Hare --}}
{{-- ! End hare --}}
{{-- * regarding reverse  --}}
{{--  Start Hare --}}
@foreach (array_reverse($datadecode) as $row)
    <tr>
        <td>{{ $row['client_delivery'] ?? 'NA' }}</td>
        <td>{{ $row['training_development'] ?? 'NA' }}</td>
        <td>{{ $row['value_firm'] ?? 'NA' }}</td>
        <td>{{ $row['value_society'] ?? 'NA' }}</td>
        <td>{{ $row['self_reflection'] ?? 'NA' }}</td>
        <td>{{ $row['team_building'] ?? 'NA' }}</td>
        <td>{{ $row['client_relationship'] ?? 'NA' }}</td>
    </tr>
@endforeach
{{--  Start Hare --}}
{{-- ! End hare --}}
{{-- * regarding  --}}
<div class="form-group m-0 d-none">
    @php
        $reloadUrls = [
            13 => [
                'teamlist' => '/timesheet/teamlist',
                'partnersubmitted' => '/timesheet/partnersubmitted',
            ],
            11 => '/timesheet/allteamsubmitted',
            14 => '/timesheet/teamlist',
            15 => '/timesheet/teamlist',
        ];

        $currentRoute = request()->segment(2);
        $roleId = Auth::user()->role_id;
        $url = $reloadUrls[$roleId][$currentRoute] ?? ($reloadUrls[$roleId] ?? null);
    @endphp

    @if ($url)
        <a href="{{ url($url) }}">
            <img src="{{ url('backEnd/image/reload.png') }}" style="width: 30px; height: 30px; margin-top: 12px;"
                alt="Reload">
        </a>
    @endif
</div>
{{--  Start Hare --}}
{{--  Start Hare --}}
{{-- ! End hare --}}
{{-- * regarding icon / regarding sorting icon / regarding table icon   --}}
{{--  Start Hare --}}
resources\views\backEnd\independence\independencereport.blade.php

{{-- <link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet"> --}}
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">

<link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css') }}" rel="stylesheet">


<table id="examplee" class="table display table-bordered table-striped table-hover">
    {{--  Start Hare --}}
    {{-- ! End hare --}}
    {{-- * regarding  --}}
    {{--  Start Hare --}}
    <select class="language form-control" id="employee1" name="employee">
        <option value="">Please Select One</option>
        @foreach ($teamapplyleaveDatasfilter->unique('emailid') as $applyleaveDatas)
            <option value="{{ $applyleaveDatas->createdby }}"
                {{ old('employee') == $applyleaveDatas->createdby ? 'selected' : '' }}>
                {{ $applyleaveDatas->team_member }}
                ({{ $applyleaveDatas->newstaff_code ?? ($applyleaveDatas->staffcode ?? '') }})
            </option>
        @endforeach
    </select>
    {{--  Start Hare --}}
    {{-- ! End hare --}}
    {{-- * regarding debug  --}}
    {{--  Start Hare --}}
    {{--  Start Hare --}}
    @foreach ($get_date as $jobDatas)
        @php
            dd($jobDatas);
        @endphp
    @endforeach
    {{-- ! End hare --}}
    {{-- * regarding select box  --}}
    @if (
        $teammemberData->leavingdate == null ||
            ($teammemberData->leavingdate != null && $rejoiningUser->first()?->userexitdate == null))

        {{--  Start Hare --}}
        <select name="status" id="exampleFormControlSelect1" class="form-control">
            @if (Request::is('teammember/*/edit'))
                <option value="0" {{ $teammember->status == '0' ? 'selected' : '' }}
                    {{ $teammember->status == '0' && $teammember->leavingdate != null ? 'disabled' : '' }}>
                    Inactive</option>
                <option value="1" {{ $teammember->status == '1' ? 'selected' : '' }}
                    {{ $teammember->status == '0' && $teammember->leavingdate != null ? 'disabled' : '' }}>
                    Active</option>
            @else
                <option value="0">Inactive</option>
                <option value="1">Active</option>
            @endif
        </select>
        {{--  Start Hare --}}
        {{-- ! End hare --}}
        {{-- * regarding ancor tag   --}}
        {{--  Start Hare --}}

        <td>
            @if ($teammemberData->status == 0)
                @if ($teammemberData->leavingdate == null)
                    <a href="{{ url('/changeteamStatus/' . $teammemberData->status . '/1/' . $teammemberData->id) }}"
                        onclick="return confirm('Are you sure you want to Active this teammember?');">
                        <button class="btn btn-danger" data-toggle="modal"
                            style="height: 16px; width: auto; border-radius: 7px; display: flex; align-items: center; justify-content: center;font-size: 11px;"
                            data-target="#requestModal">Inactive</button>
                    </a>
                @else
                    <a style="pointer-events: none; opacity: 0.6;">
                        <button class="btn btn-danger" data-toggle="modal"
                            style="height: 16px; width: auto; border-radius: 7px; display: flex; align-items: center; justify-content: center;font-size: 11px;"
                            data-target="#requestModal">Inactive</button>
                    </a>
                @endif
            @else
                <a href="{{ url('/changeteamStatus/' . $teammemberData->status . '/0/' . $teammemberData->id) }}"
                    onclick="return confirm('Are you sure you want to Inactive this teammember?');">
                    <button class="btn btn-primary" data-toggle="modal"
                        style="height: 16px; width: auto; border-radius: 7px; display: flex; align-items: center; justify-content: center;font-size: 11px;"
                        data-target="#requestModal">Active</button>
                </a>
            @endif
        </td>

        <td>
            @if ($teammemberData->status == 0)
                <a href="{{ $teammemberData->leavingdate == null ? url('/changeteamStatus/' . $teammemberData->status . '/1/' . $teammemberData->id) : '#' }}"
                    {{ $teammemberData->leavingdate != null ? 'style=pointer-events:none;opacity:0.6;' : '' }}
                    onclick="{{ $teammemberData->leavingdate == null ? "return confirm('Are you sure you want to activate this team member?');" : 'return false;' }}">
                    <button class="btn btn-danger"
                        style="height: 16px; width: auto; border-radius: 7px; display: flex; align-items: center; justify-content: center; font-size: 11px;">
                        Inactive
                    </button>
                </a>
            @else
                <a href="{{ url('/changeteamStatus/' . $teammemberData->status . '/0/' . $teammemberData->id) }}"
                    onclick="return confirm('Are you sure you want to Inactive this teammember?');">
                    <button class="btn btn-primary" data-toggle="modal"
                        style="height: 16px; width: auto; border-radius: 7px; display: flex; align-items: center; justify-content: center;font-size: 11px;"
                        data-target="#requestModal">Active</button>
                </a>
            @endif
        </td>
        {{--  Start Hare --}}
        <td>
            @php
                $isInactive = $teammemberData->status == 0;
                $canActivate = $isInactive && is_null($teammemberData->leavingdate);
                $btnClass = $isInactive ? 'btn-danger' : 'btn-primary';
                $btnText = $isInactive ? 'Inactive' : 'Active';
                $toggleStatus = $isInactive ? 1 : 0;
                $disabled = !$canActivate ? 'pointer-events: none; opacity: 0.6;' : '';
            @endphp

            <a href="{{ $canActivate ? url('/changeteamStatus/' . $teammemberData->status . '/' . $toggleStatus . '/' . $teammemberData->id) : '#' }}"
                onclick="{{ $canActivate ? "return confirm('Are you sure you want to " . ($isInactive ? 'Active' : 'Inactive') . " this teammember?');" : 'return false;' }}"
                style="{{ $disabled }}">
                <button class="btn {{ $btnClass }}" data-toggle="modal"
                    style="height: 16px; width: auto; border-radius: 7px; display: flex; align-items: center; justify-content: center; font-size: 11px;"
                    data-target="#requestModal">
                    {{ $btnText }}
                </button>
            </a>
        </td>
        {{--  Start Hare --}}
        {{-- ! End hare --}}
        {{-- * regarding form submit / on submit / onsubmit / regarding validation  --}}
        {{--  Start Hare  --}}
        {{--  Start Hare  --}}
        <script>
            $(document).ready(function() {
                // Condition on form submit
                $('form').submit(function(event) {
                    var mobile_no = $("[name='mobile_no']").val();
                    var emergencycontactnumber = $("[name='emergencycontactnumber']").val();
                    var mothernumber = $("[name='mothernumber']").val();
                    var fathernumber = $("[name='fathernumber']").val();

                    var profilepic = $("[name='profilepic']").val().trim();
                    // file extensions
                    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

                    var bankaccountnumber = $("[name='bankaccountnumber']").val();

                    var adharcardnumber = $("[name='adharcardnumber']").val();

                    var pancardno = $("[name='pancardno']").val().trim();
                    // PAN Card Pattern AAAAA9999A will be like it
                    var panPattern = /^[A-Z]{5}[0-9]{4}[A-Z]{1}$/;

                    var personalemail = $("[name='personalemail']").val().trim();
                    var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

                    var dateofbirth = $("[name='dateofbirth']").val();
                    var joining_date = $("[name='joining_date']").val();
                    var leavingdate = $("[name='leavingdate']").val();
                    // Get today's date
                    var today = new Date();
                    today.setHours(0, 0, 0, 0);

                    var dob = new Date(dateofbirth);
                    var joiningdate = new Date(joining_date);
                    var leavingdateformate = new Date(leavingdate);

                    // Check digit
                    if (!/^\d+$/.test(mobile_no)) {
                        alert('Enter mobile number using only digits');
                        // $("[name='mobile_no']").val('');
                        $("[name='mobile_no']").focus();
                        // Prevent form submission
                        event.preventDefault();
                        return false;
                    }
                    if (!/^\d+$/.test(emergencycontactnumber)) {
                        alert('Enter emergencycontactnumber using only digits');
                        // $("[name='emergencycontactnumber']").val('');
                        $("[name='emergencycontactnumber']").focus();
                        // Prevent form submission
                        event.preventDefault();
                        return false;
                    }

                    if (!/^\d+$/.test(adharcardnumber)) {
                        alert('Enter aadhar number using only digits');
                        // $("[name='adharcardnumber']").val('');
                        $("[name='adharcardnumber']").focus();
                        // Prevent form submission
                        event.preventDefault();
                        return false;
                    }

                    if (!/^\d+$/.test(mothernumber)) {
                        alert('Enter mobile number using only digits');
                        // $("[name='mobile_no']").val('');
                        $("[name='mothernumber']").focus();
                        // Prevent form submission
                        event.preventDefault();
                        return false;
                    }

                    if (!/^\d+$/.test(fathernumber)) {
                        alert('Enter mobile number using only digits');
                        // $("[name='mobile_no']").val('');
                        $("[name='fathernumber']").focus();
                        // Prevent form submission
                        event.preventDefault();
                        return false;
                    }
                    if (!/^\d+$/.test(bankaccountnumber)) {
                        alert('Enter bank account number using only digits');
                        // $("[name='mobile_no']").val('');
                        $("[name='bankaccountnumber']").focus();
                        // Prevent form submission
                        event.preventDefault();
                        return false;
                    }

                    // // Check if email is valid
                    if (!emailPattern.test(personalemail)) {
                        alert("Enter a valid email address!");
                        // $("[name='personalemail']").val('');
                        $("[name='personalemail']").focus();
                        event.preventDefault();
                        return false;
                    }

                    // date of birth is in the future
                    if (dob > today) {
                        alert("Date of Birth cannot be in the future");
                        // $("[name='dateofbirth']").val('');
                        $("[name='dateofbirth']").focus();
                        event.preventDefault();
                        return false;
                    }

                    // date of joining is in the future
                    if (joiningdate > today) {
                        alert("Date of Birth cannot be in the future");
                        // $("[name='dateofbirth']").val('');
                        $("[name='dateofbirth']").focus();
                        event.preventDefault();
                        return false;
                    }
                    // date of leavingdateformate is in the future
                    if (leavingdateformate > today) {
                        alert("Date of leavingdate cannot be in the future");
                        // $("[name='dateofbirth']").val('');
                        $("[name='leavingdate']").focus();
                        event.preventDefault();
                        return false;
                    }

                    if (!panPattern.test(pancardno)) {
                        alert("Enter a valid PAN Card number like AAAAA9999A");
                        // $("[name='pancardno']").val('');
                        $("[name='pancardno']").focus();
                        event.preventDefault();
                        return false;
                    }

                    if (profilepic && !allowedExtensions.test(profilepic)) {
                        // 'filess.*' => 'mimes:png,jpg,jpeg,csv,xlx,xls,pdf,zip,rar',
                        alert("Profile picture must be in JPG, JPEG, or PNG format");
                        $("[name='profilepic']").focus();
                        event.preventDefault();
                        return false;
                    }
                });
            });
        </script>
        {{-- ! End hare --}}


        {{-- * regarding  --}}
        {{--  Start Hare --}}
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            @if (isset($myapplyleaveDatas) && count($myapplyleaveDatas) > 0)
                <li class="nav-item">
                    <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home"
                        role="tab" aria-controls="pills-home" aria-selected="true">My Application</a>
                </li>
            @endif

            @if (Auth::user()->role_id == 13)
                <li class="nav-item">
                    <a class="nav-link {{ !isset($myapplyleaveDatas) || count($myapplyleaveDatas) == 0 ? 'active' : '' }}"
                        id="pills-user-tab" data-toggle="pill" href="#pills-user" role="tab"
                        aria-controls="pills-user" aria-selected="false">Team Application</a>
                </li>
            @endif
        </ul>

        {{--  Start Hare --}}
        {{-- ! End hare --}}
        {{-- * regarding console   --}}
        {{--  Start Hare --}}
        {{--  Start Hare --}}
        //* regarding console
        console.log("lasttimesheetsubmiteddata:", lasttimesheetsubmiteddata);
        console.log("timesheetmaxDateRecord:", timesheetmaxDateRecord);
        console.log("leavedataforcalander1:", leavedataforcalander1);
        console.log("differenceInDays:", differenceInDays);
        console.log("newteammember:", newteammember);
        console.log("rejoiningdate:", rejoiningdate);
        console.log("totalleaveCount:", totalleaveCount);
        console.log("leavebreakdateassign:", leavebreakdateassign);
        {{-- ! End hare --}}
        {{-- * regarding csrf  --}}
        {{--  Start Hare --}}
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        {{--  Start Hare --}}
        {{-- ! End hare --}}
        {{-- * regarding summernote --}}
        {{--  Start Hare --}}

        <div class="row">
            <div class="col-12 d-flex flex-column  mb-2">
                <label for="">Description:</label>
                <textarea class="form-control summernote" name="description">{{ $data->descreption }}</textarea>
            </div>
        </div>

        <div class="row">
            <div class="col-12 d-flex flex-column  mb-2">
                <label for="">listdescreption:</label>
                <textarea class="form-control summernote" name="description1">{{ $data->listdescreption }}</textarea>
            </div>
        </div>

        <script>
            $('#summernote').summernote({
                placeholder: 'Enter Description ',
                tabsize: 2,
                height: 200
            });
        </script>
        {{-- <script>
                $('.summernote').summernote({
                    placeholder: 'Enter Description ',
                    tabsize: 2,
                    height: 200
                });
            </script> --}}

        <!-- Include Summernote JS -->
        <script>
            $(document).ready(function() {
                $('.summernote').summernote({
                    height: 200, // Set height
                    toolbar: [
                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        ['font', ['strikethrough', 'superscript', 'subscript']],
                        ['fontsize', ['fontsize']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture', 'video']],
                        ['view', ['fullscreen', 'codeview', 'help']]
                    ]
                });
            });
        </script>
        {{--  Start Hare --}}

        {{-- ! End hare --}}
        {{-- * regarding file and folder download --}}
        {{--  Start Hare --}}


        <li><strong>Download11</strong>:
            <a href="{{ asset('img/logo.png') }}" class="btn btn-success">Download</a>
        </li>
        <li>
            <strong>Download22:</strong>
            <a href="{{ asset('img/logo.png') }}" class="btn btn-success" download="logo.png">Download</a>
        </li>
        <li>
            <strong>Download33:</strong>
            <a href="{{ asset('img\creater.xlsx') }}" class="btn btn-success">Download</a>
        </li>
        <li>
            <strong>Download44:</strong>
            <a href="{{ asset('img/' . 'creater.xlsx') }}" class="btn btn-success">Download2</a>
        </li>
        <li>
            <strong>Download55:</strong>
            <a href="{{ url('img/' . 'creater.xlsx') }}" class="btn btn-success">Download2</a>
        </li>

        {{-- Route::get('img/{name}', [ContactUsWebController::class, 'download']);

public function download(Request $request, $name)
{
    $path = public_path('assets/img/' . $name);
    if (!file_exists($path)) {
        abort(404, 'File not found.');
    }
    return response()->download($path);
} --}}

        {{--  Start Hare --}}
        {{-- 
2222222222222222222222222222
resources\views\backEnd\assignmentconfirmation\index.blade.php

                              <div class="col-sm-9">
                                  <a href="{{ url('backEnd/balanceconfirmation.xlsx') }}"
                                      class="btn btn-success btn">Download<i class="fas fa-file-excel"
                                          style="margin-left: 3px;font-size: 20px;"></i></a>

                              </div>
							  
							  
222222222222222222222222222222222222222222222222222
resources\views\backEnd\article\index.blade.php

                                    <td>
                                        <a target="blank" href="{{ asset('backEnd/image/article/' . $articleData->file) }}">
                                            {{ $articleData->subject }}
                                        </a>
                                    </td>
									
									
22222222222222222222222222222222222222222222222
resources\views\backEnd\teammember\form.blade.php

                    <a href="{{ url('backEnd/image/teammember/aadharupload/', $teammember->aadharupload) }}"
                        target="blank" data-toggle="tooltip" title="{{ $teammember->aadharupload ?? '' }}"
                        class="btn btn-success-soft ml-2"><i class="fas fa-file"></i> View</a> --}}
        {{--  Start Hare --}}
        {{-- ! End hare --}}
        {{-- * regarding year  --}}
        {{--  Start Hare --}}
        <div class="btn-group mb-2 mr-1">

            @php
                $selectedYear = Request::query('year');
                if ($selectedYear == null) {
                    $selectedYear = $currentYear;
                } else {
                    $selectedYear = Request::query('year');
                }
            @endphp
            <button type="button" class="btn btn-info-soft btn-sm dropdown-toggle" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">

                {{-- @if (Request::query('year') == '2024')
            2024
        @elseif (Request::query('year') == '2023')
            2023
        @elseif (Request::query('year') == '2025')
            2025
        @else
            Choose Year
        @endif --}}

                @if (in_array($selectedYear, $years))
                    {{ $selectedYear }}
                @else
                    Choose Year
                @endif
            </button>
            {{-- <div class="dropdown-menu">
        <a style="color: #37A000" class="dropdown-item"
            href="{{ url('/holidays?' . 'year=' . '2025') }}">2025</a>
        <a style="color: #37A000" class="dropdown-item"
            href="{{ url('/holidays?' . 'year=' . '2024') }}">2024</a>

        <a style="color: #37A000" class="dropdown-item"
            href="{{ url('/holidays?' . 'year=' . '2023') }}">2023</a>
    </div> --}}
            <div class="dropdown-menu">
                @foreach ($years as $year)
                    <a style="color: #37A000" class="dropdown-item"
                        href="{{ url('/holidays?year=' . $year) }}">{{ $year }}</a>
                @endforeach
            </div>
        </div>
        {{--  Start Hare --}}
        @php
            $currentDate = Carbon::now();

            $tillyearend = $currentDate->year;
            $oldyearstart = 2023;
            $years = range($tillyearend, $oldyearstart);

            $holidayDatas = DB::table('holidays')
                ->where('status', 1)
                ->where('year', $request->year)
                ->select('holidays.*')
                ->orderBy('startdate', 'asc')
                ->get();
        @endphp
        <li class="breadcrumb-item">
            <div class="btn-group mb-2 mr-1">

                @php
                    $selectedYear = Request::query('year');
                @endphp
                <button type="button" class="btn btn-info-soft btn-sm dropdown-toggle" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    {{-- @if (Request::query('year') == '2024')
                2024
            @elseif (Request::query('year') == '2023')
                2023
            @elseif (Request::query('year') == '2025')
                2025
            @else
                Choose Year
            @endif --}}

                    @if (in_array($selectedYear, $years))
                        {{ $selectedYear }}
                    @else
                        Choose Year
                    @endif
                </button>
                {{-- <div class="dropdown-menu">
            <a style="color: #37A000" class="dropdown-item"
                href="{{ url('/holidays?' . 'year=' . '2025') }}">2025</a>
            <a style="color: #37A000" class="dropdown-item"
                href="{{ url('/holidays?' . 'year=' . '2024') }}">2024</a>

            <a style="color: #37A000" class="dropdown-item"
                href="{{ url('/holidays?' . 'year=' . '2023') }}">2023</a>
        </div> --}}
                <div class="dropdown-menu">
                    @foreach ($years as $year)
                        <a style="color: #37A000" class="dropdown-item"
                            href="{{ url('/holidays?year=' . $year) }}">{{ $year }}</a>
                    @endforeach
                </div>
            </div>
        </li>
        {{--  Start Hare --}}
        {{-- ! End hare --}}
        {{-- * regarding  --}}
        {{--  Start Hare --}}
        <tbody>
            @php $hasData = false; @endphp
            @foreach ($timesheetData as $timesheetDatas)
                @php
                    $timesheetanotherdata = $timesheetCounts[$timesheetDatas->timesheetid] ?? 0;
                    $datadate = isset($timesheetDatas->date) ? Carbon\Carbon::parse($timesheetDatas->date) : null;
                @endphp
                @if ($timesheetanotherdata <= 1)
                    @php $hasData = true; @endphp
                    <tr>
                        <td style="display: none;">{{ $timesheetDatas->id }}</td>
                        @if (Auth::user()->role_id == 11 ||
                                Request::is('adminsearchtimesheet') ||
                                (Auth::user()->role_id == 13 && Request::is('admintimesheetlist')))
                            <td>{{ $timesheetDatas->team_member ?? '' }}</td>
                            <td>
                                @if ($permotioncheck && $datadate && $datadate->greaterThan($permotiondate))
                                    {{ $permotioncheck->newstaff_code }}
                                @else
                                    {{ $timesheetDatas->staffcode }}
                                @endif
                            </td>
                        @endif
                        <td>{{ date('d-m-Y', strtotime($timesheetDatas->date)) }}</td>
                        <td>{{ date('l', strtotime($timesheetDatas->date)) }}</td>
                        <td>{{ $timesheetDatas->client_name ?? '' }}</td>
                        <td>{{ $timesheetDatas->client_code ?? '' }}</td>
                        <td>
                            {{ $timesheetDatas->assignment_name ?? '' }}
                            @if ($timesheetDatas->assignmentname)
                                ({{ $timesheetDatas->assignmentname ?? '' }})
                            @endif
                        </td>
                        <td>{{ $timesheetDatas->assignmentgenerate_id ?? '' }}</td>
                        <td>{{ $timesheetDatas->workitem ?? '' }}</td>
                        <td>{{ $timesheetDatas->location ?? '' }}</td>
                        <td>{{ $timesheetDatas->patnername ?? '' }}</td>
                        <td>
                            @if ($permotioncheck && $datadate && $datadate->greaterThan($permotiondate))
                                {{ $timesheetDatas->newstaff_code }}
                            @else
                                {{ $timesheetDatas->patnerstaffcode }}
                            @endif
                        </td>
                        <td>{{ $timesheetDatas->hour ?? '' }}</td>
                    </tr>
                @endif
            @endforeach
            @if (!$hasData)
                <tr>
                    <td colspan="7" style="text-align: center;">Data not available</td>
                </tr>
            @endif
        </tbody>
        {{--  Start Hare --}}
        {{-- ! End hare --}}
        {{-- * regarding total travel count  --}}
        {{--  Start Hare --}}
        @php
            // public function totaltraveldays(Request $request, $teamid)
            //   {
            // Define the financial year start and end dates
            $currentDate = Carbon::now();
            $startDate =
                $currentDate->month >= 4
                    ? Carbon::create($currentDate->year, 4, 1)
                    : Carbon::create($currentDate->year - 1, 4, 1);
            $endDate =
                $currentDate->month >= 4
                    ? Carbon::create($currentDate->year + 1, 3, 31)
                    : Carbon::create($currentDate->year, 3, 31);

            // Fetch necessary data
            $timesheetData = DB::table('timesheetusers')
                ->leftJoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
                ->leftJoin('clients', 'clients.id', 'timesheetusers.client_id')
                ->leftJoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
                ->leftJoin('teammembers as partner', 'partner.id', 'timesheetusers.partner')
                ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', 'partner.id')
                ->leftJoin(
                    'assignmentbudgetings',
                    'assignmentbudgetings.assignmentgenerate_id',
                    'timesheetusers.assignmentgenerate_id',
                )
                ->select(
                    'timesheetusers.*',
                    'assignments.assignment_name',
                    'clients.client_name',
                    'clients.client_code',
                    'teammembers.team_member',
                    'teammembers.staffcode',
                    'partner.team_member as partner_name',
                    'partner.staffcode as partner_staffcode',
                    'assignmentbudgetings.assignmentname',
                    'teamrolehistory.newstaff_code',
                    'assignmentbudgetings.created_at as assignment_created_date',
                )
                ->where('timesheetusers.createdby', $teamid)
                ->whereIn('timesheetusers.status', [1, 2, 3])
                ->whereBetween('timesheetusers.date', [$startDate->toDateString(), $endDate->toDateString()])
                ->where('timesheetusers.assignmentgenerate_id', 'OFF100003')
                ->orderBy('timesheetusers.date', 'DESC')
                ->get()

                ->map(function ($timesheet) {
                    $promotionCheck = DB::table('teamrolehistory')
                        ->where('teammember_id', $timesheet->createdby)
                        ->first();

                    $assignmentDate = $timesheet->assignment_created_date
                        ? Carbon::parse($timesheet->assignment_created_date)
                        : null;

                    $promotionDate = $promotionCheck ? Carbon::parse($promotionCheck->created_at) : null;

                    // Add computed fields to the object
                    $timesheet->display_staffcode =
                        $promotionCheck && $assignmentDate && $assignmentDate->greaterThan($promotionDate)
                            ? $promotionCheck->newstaff_code
                            : $timesheet->staffcode;

                    $timesheet->display_partner_code =
                        $promotionCheck && $assignmentDate && $assignmentDate->greaterThan($promotionDate)
                            ? $timesheet->newstaff_code
                            : $timesheet->partner_staffcode;

                    $timesheet->formatted_date = Carbon::parse($timesheet->date)->format('d-m-Y');
                    $timesheet->day_of_week = Carbon::parse($timesheet->date)->format('l');

                    return $timesheet;
                });

            return view('backEnd.timesheet.totaltraveldays', compact('timesheetData'));
            //   }
        @endphp

        <div class="card-body">
            @component('backEnd.components.alert')
            @endcomponent
            <div class="table-responsive">
                <table id="examplee" class="table display table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th style="display: none;">ID</th>
                            @if (Auth::user()->role_id == 11 ||
                                    Request::is('adminsearchtimesheet') ||
                                    (Auth::user()->role_id == 13 && Request::is('admintimesheetlist')))
                                <th>Employee Name</th>
                                <th>Employee Code</th>
                            @endif
                            <th>Date</th>
                            <th>Day</th>
                            <th>Client Name</th>
                            <th>Client Code</th>
                            <th>Assignment Name</th>
                            <th>Assignment ID</th>
                            <th>Work Item</th>
                            <th>Location</th>
                            <th>Partner</th>
                            <th>Partner Code</th>
                            <th>Hour</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($timesheetData as $timesheet)
                            <tr>
                                <td style="display: none;">{{ $timesheet->id }}</td>
                                @if (Auth::user()->role_id == 11 ||
                                        Request::is('adminsearchtimesheet') ||
                                        (Auth::user()->role_id == 13 && Request::is('admintimesheetlist')))
                                    <td>{{ $timesheet->team_member ?? '' }}</td>
                                    <td>{{ $timesheet->display_staffcode ?? '' }}</td>
                                @endif
                                <td>{{ $timesheet->formatted_date }}</td>
                                <td>{{ $timesheet->day_of_week }}</td>
                                <td>{{ $timesheet->client_name ?? '' }}</td>
                                <td>{{ $timesheet->client_code ?? '' }}</td>
                                <td>
                                    {{ $timesheet->assignment_name ?? '' }}
                                    @if ($timesheet->assignmentname)
                                        ({{ $timesheet->assignmentname }})
                                    @endif
                                </td>
                                <td>{{ $timesheet->assignmentgenerate_id ?? '' }}</td>
                                <td>{{ $timesheet->workitem ?? '' }}</td>
                                <td>{{ $timesheet->location ?? '' }}</td>
                                <td>{{ $timesheet->partner_name ?? '' }}</td>
                                <td>{{ $timesheet->display_partner_code ?? '' }}</td>
                                <td>{{ $timesheet->hour ?? '' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="13" class="text-center">Data not available</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        {{--  Start Hare --}}
        {{-- ! End hare --}}
        {{-- * regarding  --}}
        {{--  Start Hare --}}

        <pre>
    
</pre>
        {{--  Start Hare --}}

        @php
            // $request->validate([
            //     'attachment' => 'nullable|mimes:png,pdf,jpeg,jpg|max:4120',
            // ], [
            //     'attachment.max' => 'The file may not be greater than 5 MB.',
            // ]);
            $request->validate(
                [
                    'attachment' => 'nullable|mimes:png,pdf,jpeg,jpg,xls,xlsx|max:5120',
                ],
                [
                    'attachment.max' => 'The file may not be greater than 5 MB.',
                    'attachment.mimes' => 'The file must be a type of: png, pdf, jpeg, jpg, xls, xlsx.',
                ],
            );
        @endphp
        {{-- ! End hare --}}
        {{-- * regarding requared attribute --}}
        {{--  Start Hare --}}
        <div class="col-6">
            <div class="form-group">
                <label class="font-weight-600">Target *</label>

                <select required class="form-control basic-multiple" multiple="multiple"
                    id="exampleFormControlSelect111" name="targettype[]">
                    <option value="" disabled> Please Select One</option>
                    <option value="1">Individual</option>
                    <option value="2">All Member</option>
                    <option value="3">Partner</option>
                    <option value="4">Manager</option>
                    <option value="5">Staff</option>
                    <option value="6">IT Department</option>
                    <option value="7">Accountant</option>
                </select>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                $('#exampleFormControlSelect111').on('change', function() {
                    if (this.value == '1') {
                        $("#designation").show();
                        document.getElementById("designationinput").required = true;
                    } else {
                        $("#designation").hide();
                        document.getElementById("designationinput").required = false;
                    }
                });
            });
        </script>
        {{--  Start Hare --}}
        {{-- ! End hare --}}
        {{-- * regarding summernote  --}}
        {{--  Start Hare --}}
        {{--  Start Hare --}}
        <div class="row row-sm">
            <div class="col-12">
                <div class="form-group">
                    <label class="font-weight-600">Announcement Content *</label>
                    <textarea rows="4" name="mail_content" class="centered form-control" id="summernote"
                        placeholder="Enter Description" id="editors" style="height:500px;"></textarea>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                // Add required validation
                $('form').on('submit', function(e) {
                    // Check if Summernote content is empty
                    var summernoteContent = $('#summernote').summernote('isEmpty');
                    if (summernoteContent) {
                        alert('Announcement Content is required.');
                        e.preventDefault(); // Prevent form submission
                        return false;
                    }
                });
            });
        </script>
        {{-- ! End hare --}}



        {{-- ########################################################################### --}}
        {{-- 17-12-2024 --}}




</html>
