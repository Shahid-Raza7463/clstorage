<link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css') }}" rel="stylesheet">

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
                    {{-- <table id="examplee" class="display nowrap"> --}}
                    <table id="examplee" class="table display table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th style="display: none;">id</th>
                                <th class="textfixed">Assignment Code</th>
                                <th class="textfixed">Client Name</th>
                                <th class="textfixed">Assignment Name</th>
                                <th class="textfixed">Partner Name</th>
                                <th class="textfixed">Document Completed Date</th>
                                <th class="textfixed">Invoice Number</th>
                                <th class="textfixed">Date of Invoice</th>
                                <th class="textfixed">Basic Invoice Amount</th>
                                <th class="textfixed">OPE</th>
                                <th class="textfixed">GST</th>
                                <th class="textfixed">Total Invoice Amount</th>
                                <th class="textfixed">Payment Status</th>
                                <th class="textfixed">Status</th>
                                <th class="textfixed">Assignment Closed Date</th>
                                <th class="textfixed">Assignment Created Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($assignments as $row)
                                <tr>
                                    <td style="display: none;">{{ $row->id }}</td>
                                    <td>{{ $row->assignmentgenerate_id }}</td>
                                    <td>{{ optional($row->assignmentBudgeting->client)->client_name ?? 'N/A' }}</td>
                                    {{-- <td>{{ optional($row->assignmentBudgeting->assignment)->assignment_name ?? 'N/A' }}</td> --}}
                                    <td class="textfixed">{{ optional($row->assignmentBudgeting)->assignmentname ?? 'N/A' }}
                                    </td>
                                    <td>{{ optional($row->leadPartner)->team_member ?? 'N/A' }}</td>
                                    <td>{{ optional($row->assignmentBudgeting)->percentclosedate ?? 'N/A' }}</td>
                                    @php
                                        $filteredInvoices = $row->invoices->where('status', 2);
                                    @endphp
                                    <td class="textfixed">
                                        {{ $filteredInvoices->pluck('invoice_id')->implode(', ') ?: 'N/A' }}</td>
                                    <td class="textfixed">
                                        {{ $filteredInvoices->pluck('created_at')->map(fn($d) => \Carbon\Carbon::parse($d)->format('Y-m-d'))->implode(', ') ?: 'N/A' }}
                                    </td>
                                    <td class="textfixed">{{ $filteredInvoices->pluck('amount')->implode(', ') ?: 'N/A' }}
                                    </td>
                                    <td>{{ $filteredInvoices->pluck('pocketexpenseamount')->implode(', ') ?: 'N/A' }}</td>
                                    <td>
                                        {{ $filteredInvoices->map(fn($invoice) => ($invoice->total ?? 0) - ($invoice->amount ?? 0))->implode(', ') ?: 'N/A' }}
                                    </td>
                                    <td>{{ $filteredInvoices->pluck('total')->implode(', ') ?: 'N/A' }}</td>
                                    <td class="textfixed">
                                        @if ($filteredInvoices->isEmpty())
                                            <b style="color:red;">N/A</b>
                                        @else
                                            @foreach ($filteredInvoices as $invoice)
                                                @if ($invoice->paymentstatus == null)
                                                    <b style="color:red;">Not Received</b>
                                                @else
                                                    <b style="color:#28A745;">{{ $invoice->paymentstatus }}</b>
                                                @endif
                                                @if (!$loop->last)
                                                    ,
                                                @endif
                                            @endforeach
                                        @endif
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
            buttons: [{
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

        $('#examplee thead tr').clone(true).addClass('filters').appendTo('#examplee thead');
        $('#examplee thead .filters th').each(function() {
            var title = $(this).text();
            var data_name = $(this).data('name');
            var data_filter = $(this).data('filter');

            if (title == 'SR.' || title == 'Options' || data_name == '#' || data_filter == 'false') {
                $(this).html('');
            } else {
                $(this).html('<input type="text" class="form-control" placeholder="' + title + '" />');
            }
        });

        $('#examplee thead .filters input').on('blur keyup change', function() {
            var columnIndex = $(this).parent().index();
            table.column(columnIndex).search($(this).val()).draw();
        });
    });
</script>
