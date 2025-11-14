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
                                @endphp
                                <tr data-invoices='@json($filteredInvoices)'>
                                    <td style="display: none;">{{ $row->id }}</td>
                                    <td>{{ $row->assignmentgenerate_id }}</td>
                                    <td>{{ optional($row->assignmentBudgeting->client)->client_name ?? 'N/A' }}</td>
                                    <td class="textfixed">{{ optional($row->assignmentBudgeting)->assignmentname ?? 'N/A' }}
                                    </td>
                                    <td>{{ optional($row->leadPartner)->team_member ?? 'N/A' }}</td>
                                    <td>{{ optional($row->assignmentBudgeting)->percentclosedate ?? 'N/A' }}</td>
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
                                    <td>

                                        <span
                                            class="badge toggle-invoices"style="background-color: #d0f29ec4; height: 21px; width: 59px; cursor: pointer;">
                                            {{ $filteredInvoices->count() }}
                                        </span>
                                    </td>
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

{{-- <script>
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
                    text: 'Export Excel',
                    exportOptions: {
                        columns: ':visible',
                        modifier: {
                            page: 'all'
                        } // include all pages
                    },
                    customizeData: function(data) {
                        var tableApi = $('#examplee').DataTable();
                        var allRows = tableApi.rows({
                            page: 'all'
                        }).nodes(); // DOM nodes for all pages
                        var allData = tableApi.rows({
                            page: 'all'
                        }).data(); // Data for all pages
                        let newBody = [];

                        allData.each(function(rowData, index) {
                            // read HTML cell texts
                            var rowCells = $(allRows[index]).find('td').map(function() {
                                return $(this).text().trim();
                            }).get();

                            newBody.push(rowCells);

                            // get invoices JSON directly from data-invoices attribute
                            var invoices = $(allRows[index]).data('invoices');
                            if (invoices && invoices.length > 0) {
                                invoices.forEach(function(inv) {
                                    newBody.push([
                                        '', '', '', '', '', '', '', '',
                                        inv.invoice_id ?? 'N/A',
                                        inv.created_at ? new Date(inv
                                            .created_at).toISOString()
                                        .split('T')[0] : 'N/A',
                                        inv.amount ?? 0,
                                        inv.pocketexpenseamount ?? 0,
                                        ((inv.total ?? 0) - (inv
                                            .amount ?? 0)),
                                        inv.total ?? 0,
                                        inv.paymentstatus ??
                                        'Not Received'
                                    ]);
                                });
                            }
                        });

                        data.body = newBody;
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
</script> --}}

<script>
    $(document).ready(function() {
        var table = $('#examplee').DataTable({
            dom: 'Bfrtip',
            "order": [
                [0, "desc"]
            ],
            buttons: [{
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: [0, ':visible']
                    }
                },
                // {
                //     extend: 'excelHtml5',
                //     text: 'Export Excel',
                //     exportOptions: {
                //         columns: ':visible',
                //         modifier: {
                //             page: 'all'
                //         } // include all pages
                //     },
                //     customizeData: function(data) {
                //         var tableApi = $('#examplee').DataTable();
                //         var allRows = tableApi.rows({
                //             page: 'all'
                //         }).nodes();
                //         var allData = tableApi.rows({
                //             page: 'all'
                //         }).data();
                //         let newBody = [];

                //         allData.each(function(rowData, index) {
                //             var rowCells = $(allRows[index]).find('td').map(function() {
                //                 return $(this).text().trim();
                //             }).get();

                //             newBody.push(rowCells);

                //             var invoices = $(allRows[index]).data('invoices');
                //             if (invoices && invoices.length > 0) {
                //                 // Insert heading before invoice details for clarity
                //                 newBody.push([
                //                     '', '', '', '', '', '', '', '',
                //                     'Invoice Number', 'Date of Invoice',
                //                     'Basic Invoice Amount',
                //                     'OPE', 'GST', 'Total Invoice Amount',
                //                     'Payment Status'
                //                 ]);

                //                 invoices.forEach(function(inv) {
                //                     newBody.push([
                //                         '', '', '', '', '', '', '', '',
                //                         inv.invoice_id ?? 'N/A',
                //                         inv.created_at ? new Date(inv
                //                             .created_at).toISOString()
                //                         .split('T')[0] : 'N/A',
                //                         inv.amount ?? 0,
                //                         inv.pocketexpenseamount ?? 0,
                //                         ((inv.total ?? 0) - (inv
                //                             .amount ?? 0)),
                //                         inv.total ?? 0,
                //                         inv.paymentstatus ??
                //                         'Not Received'
                //                     ]);
                //                 });
                //             }
                //         });

                //         data.body = newBody;
                //     }
                // },

                {
                    extend: 'excelHtml5',
                    title: 'Assignments Completed',
                    exportOptions: {
                        columns: ':visible',
                        format: {
                            body: function(data, row, column, node) {
                                // Remove HTML tags if any
                                data = data.replace(/<[^>]*>?/gm, '');
                                return data;
                            }
                        }
                    },
                    customize: function(xlsx) {
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];

                        // Clean duplicate Total Invoices dates
                        $('row c[r^="I"]', sheet).each(function() {
                            var cell = $(this);
                            var text = cell.text();
                            if (text === '2025-10-29' || text === 'N/A' || text
                                .trim() === '') {
                                // Keep only the first instance of repeating Total Invoices
                                var prev = cell.parent().prev().find('c[r^="I"]')
                                    .text();
                                if (prev === text) {
                                    cell.text('');
                                }
                            }
                        });
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
                row.child.hide();
                tr.removeClass('shown');
            } else {
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
                    let paymentstatusBadge = inv.paymentstatus == null ?
                        '<b style="color:red;">Not Received</b>' :
                        '<b style="color:#28A745;">' + (inv.paymentstatus ?? 'N/A') + '</b>';

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
            e.stopPropagation();
            var tr = $(this).closest('tr').prev();
            var row = table.row(tr);
            row.child.hide();
            tr.removeClass('shown');
        });
    });
</script>


{{-- 
<script>
$(document).ready(function () {
    var table = $('#examplee').DataTable({
        dom: 'Bfrtip',
        order: [[0, 'desc']],
        buttons: [
            {
                extend: 'copyHtml5',
                text: 'Copy',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'excelHtml5',
                text: 'Export Excel',
                exportOptions: {
                    columns: ':visible'
                },
                customizeData: function (data) {
                    // Replace table data with parent + child invoices
                    var tableData = $('#examplee').DataTable().rows().data();
                    let newBody = [];

                    data.body.forEach((row, index) => {
                        // Push main (parent) row
                        newBody.push(row);

                        // Get the corresponding DOM row
                        var tr = $('#examplee tbody tr').eq(index);
                        var invoices = tr.data('invoices'); // expects invoice array stored as data attribute

                        // Append child (invoice) rows
                        if (invoices && invoices.length > 0) {
                            invoices.forEach(function (inv) {
                                newBody.push([
                                    '', '', '', '', '', '', '', '', // empty columns for alignment
                                    inv.invoice_id ?? 'N/A',
                                    inv.created_at
                                        ? new Date(inv.created_at).toISOString().split('T')[0]
                                        : 'N/A',
                                    inv.amount ?? 0,
                                    inv.pocketexpenseamount ?? 0,
                                    ((inv.total ?? 0) - (inv.amount ?? 0)),
                                    inv.total ?? 0,
                                    inv.paymentstatus ?? 'Not Received'
                                ]);
                            });
                        }
                    });

                    // Replace original body with expanded rows
                    data.body = newBody;
                },
                customize: function (xlsx) {
                    // Optional: add title on top of Excel
                    var sheet = xlsx.xl.worksheets['sheet1.xml'];
                    $('sheetData', sheet).prepend(
                        '<row><c t="inlineStr"><is><t>K.G. Somani - Assignment & Invoice Report</t></is></c></row>'
                    );
                }
            },
            {
                extend: 'colvis',
                text: 'Column Visibility'
            }
        ]
    });
});
</script> --}}

{{-- 
<script>
    $(document).ready(function() {
        var table = $('#examplee').DataTable({
            dom: 'Bfrtip',
            order: [
                [0, 'desc']
            ],
            buttons: [{
                    extend: 'copyHtml5',
                    text: 'Copy',
                    exportOptions: {
                        columns: ':visible',
                        modifier: {
                            page: 'all'
                        } // ✅ Include all pages in copy
                    }
                },
                {
                    extend: 'excelHtml5',
                    text: 'Export Excel',
                    exportOptions: {
                        columns: ':visible',
                        modifier: {
                            page: 'all'
                        } // ✅ Include all pages in export
                    },
                    customizeData: function(data) {
                        var tableData = $('#examplee').DataTable().rows({
                            page: 'all'
                        }).data(); // ✅ Get all pages’ rows
                        let newBody = [];

                        data.body.forEach((row, index) => {
                            // Add parent row
                            newBody.push(row);

                            var tr = $('#examplee tbody tr').eq(index);
                            var invoices = tr.data('invoices');

                            // Add child rows if any
                            if (invoices && invoices.length > 0) {
                                invoices.forEach(function(inv) {
                                    newBody.push([
                                        '', '', '', '', '', '', '', '',
                                        inv.invoice_id ?? 'N/A',
                                        inv.created_at ?
                                        new Date(inv.created_at)
                                        .toISOString().split('T')[0] :
                                        'N/A',
                                        inv.amount ?? 0,
                                        inv.pocketexpenseamount ?? 0,
                                        ((inv.total ?? 0) - (inv
                                            .amount ?? 0)),
                                        inv.total ?? 0,
                                        inv.paymentstatus ??
                                        'Not Received'
                                    ]);
                                });
                            }
                        });

                        data.body = newBody;
                    },
                    customize: function(xlsx) {
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];
                        $('sheetData', sheet).prepend(
                            '<row><c t="inlineStr"><is><t>K.G. Somani - Assignment & Invoice Report</t></is></c></row>'
                        );
                    }
                },
                {
                    extend: 'colvis',
                    text: 'Column Visibility'
                }
            ]
        });
    });
</script> --}}
