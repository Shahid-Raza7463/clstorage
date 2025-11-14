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
<script></script>
{{--  Start Hare --}}
<script></script>
{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare --}}
<script></script>
{{--  Start Hare --}}
<script></script>
{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare --}}
<script></script>
{{--  Start Hare --}}
<script></script>
{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare --}}
<script></script>
{{--  Start Hare --}}
<script></script>
{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare --}}
<script></script>
{{--  Start Hare --}}
<script></script>
{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare --}}
<script></script>
{{--  Start Hare --}}
<script></script>
{{-- ! End hare --}}
{{-- * regarding date validtio    --}}
{{--  Start Hare --}}

<script>
    // working 
    // $('input[name="joining_date"], input[name="leavingdate"]').on('blur', function() {
    //     var rejoiningDate = "{{ $rejoineduser->rejoiningdate ?? '' }}";
    //     var rejoinedExitDate =
    //         "{{ $rejoineduser->rejoiniedexitdate ?? ($teammember->leavingdate ?? '') }}";

    //     var joinDate = $('input[name="joining_date"]').val();
    //     var leaveDate = $('input[name="leavingdate"]').val();

    //     // Validate only when both inputs have full valid date format (YYYY-MM-DD)
    //     if (/^\d{4}-\d{2}-\d{2}$/.test(joinDate) && /^\d{4}-\d{2}-\d{2}$/.test(leaveDate)) {
    //         var join = new Date(joinDate);
    //         var leave = new Date(leaveDate);

    //         if (isNaN(join.getTime()) || isNaN(leave.getTime())) {
    //             return; // skip invalid
    //         }

    //         if (leave <= join) {
    //             alert("Please select Leaving Date greater than Joining/Rejoining Date");

    //             // Reset to original values after alert
    //             $('input[name="joining_date"]').val(rejoiningDate);
    //             $('input[name="leavingdate"]').val(rejoinedExitDate);
    //         }
    //     } else {
    //         // No validation if the user hasn’t completed the full date yet
    //         return;
    //     }
    // });

    // working 
    // $('input[name="joining_date"], input[name="leavingdate"]').on('blur', function() {
    //     var rejoiningDate = "{{ $rejoineduser->rejoiningdate ?? '' }}";
    //     var rejoinedExitDate =
    //         "{{ $rejoineduser->rejoiniedexitdate ?? $teammember->leavingdate }}";

    //     var joinDate = $('input[name="joining_date"]').val();
    //     var leaveDate = $('input[name="leavingdate"]').val();

    //     console.log("rejoiningDate:", rejoiningDate);
    //     console.log("rejoinedExitDate:", rejoinedExitDate);
    //     console.log("joinDate:", joinDate);
    //     console.log("leaveDate:", leaveDate);

    //     // Only validate if both have values
    //     if (joinDate && leaveDate) {
    //         var join = new Date(joinDate);
    //         var leave = new Date(leaveDate);

    //         if (leave <= join) {
    //             alert("Please select Leaving Date greater than Joining/Rejoining Date");
    //             $('input[name="joining_date"]').val(rejoiningDate);
    //             $('input[name="leavingdate"]').val(rejoinedExitDate);
    //         }
    //     }
    // });

    // var dateValidationTimeout;
    // $('input[name="joining_date"], input[name="leavingdate"]').on('input', function() {
    //     clearTimeout(dateValidationTimeout);

    //     dateValidationTimeout = setTimeout(function() {
    //         var rejoiningDate = "{{ $rejoineduser->rejoiningdate ?? '' }}";
    //         var rejoinedExitDate =
    //             "{{ $rejoineduser->rejoiniedexitdate ?? $teammember->leavingdate }}";

    //         var joinDate = $('input[name="joining_date"]').val();
    //         var leaveDate = $('input[name="leavingdate"]').val();

    //         if (joinDate && leaveDate && joinDate.length === 10 && leaveDate.length ===
    //             10) {
    //             var join = new Date(joinDate);
    //             var leave = new Date(leaveDate);

    //             if (leave <= join) {
    //                 alert("Please select Leaving Date greater than Joining/Rejoining Date");
    //                 $('input[name="joining_date"]').val(rejoiningDate);
    //                 $('input[name="leavingdate"]').val(rejoinedExitDate);
    //             }
    //         }
    //     }, 2000); // 1 second delay after typing stops
    // });

    $('input[name="joining_date"], input[name="leavingdate"]').on('blur', function() {
        var rejoiningDate = "{{ $rejoineduser->rejoiningdate ?? '' }}";
        var rejoinedExitDate = "{{ $rejoineduser->rejoiniedexitdate ?? $teammember->leavingdate }}";

        var joinDate = $('input[name="joining_date"]').val();
        var leaveDate = $('input[name="leavingdate"]').val();

        console.log("rejoiningDate:", rejoiningDate);
        console.log("rejoinedExitDate:", rejoinedExitDate);
        console.log("joinDate:", joinDate);
        console.log("leaveDate:", leaveDate);

        // Only validate if both have values
        if (joinDate && leaveDate) {
            var join = new Date(joinDate);
            var leave = new Date(leaveDate);

            if (leave <= join) {
                alert("Please select Leaving Date greater than Joining/Rejoining Date");
                $('input[name="joining_date"]').val(rejoiningDate);
                $('input[name="leavingdate"]').val(rejoinedExitDate);
            }
        }
    });


    $('form').on('submit', function(e) {
        var rejoiningDate = "{{ $rejoineduser->rejoiningdate ?? '' }}";
        var rejoinedExitDate = "{{ $rejoineduser->rejoiniedexitdate ?? $teammember->leavingdate }}";

        var joinDate = $('input[name="joining_date"]').val();
        var leaveDate = $('input[name="leavingdate"]').val();

        if (joinDate && leaveDate) {
            var join = new Date(joinDate);
            var leave = new Date(leaveDate);

            if (leave <= join) {
                alert("Please select Leaving Date greater than Joining/Rejoining Date");
                $('input[name="joining_date"]').val(rejoiningDate);
                $('input[name="leavingdate"]').val(rejoinedExitDate);
                e.preventDefault(); // Form submit rok de
                return false;
            }
        }
    });

    var dateValidationTimeout;

    $('input[name="joining_date"], input[name="leavingdate"]').on('input', function() {
        clearTimeout(dateValidationTimeout);

        dateValidationTimeout = setTimeout(function() {
            var rejoiningDate = "{{ $rejoineduser->rejoiningdate ?? '' }}";
            var rejoinedExitDate =
                "{{ $rejoineduser->rejoiniedexitdate ?? $teammember->leavingdate }}";

            var joinDate = $('input[name="joining_date"]').val();
            var leaveDate = $('input[name="leavingdate"]').val();

            // Only validate if both dates are complete (YYYY-MM-DD format)
            if (joinDate && leaveDate && joinDate.length === 10 && leaveDate.length === 10) {
                var join = new Date(joinDate);
                var leave = new Date(leaveDate);

                if (leave <= join) {
                    alert("Please select Leaving Date greater than Joining/Rejoining Date");
                    $('input[name="joining_date"]').val(rejoiningDate);
                    $('input[name="leavingdate"]').val(rejoinedExitDate);
                }
            }
        }, 1000); // 1 second delay after typing stops
    });

    function validateDates() {
        var rejoiningDate = "{{ $rejoineduser->rejoiningdate ?? '' }}";
        var rejoinedExitDate = "{{ $rejoineduser->rejoiniedexitdate ?? $teammember->leavingdate }}";

        var joinDate = $('input[name="joining_date"]').val();
        var leaveDate = $('input[name="leavingdate"]').val();

        // Basic format validation
        var dateRegex = /^\d{4}-\d{2}-\d{2}$/;

        if (joinDate && leaveDate && dateRegex.test(joinDate) && dateRegex.test(leaveDate)) {
            var join = new Date(joinDate);
            var leave = new Date(leaveDate);

            if (leave <= join) {
                alert("Please select Leaving Date greater than Joining/Rejoining Date");
                $('input[name="joining_date"]').val(rejoiningDate);
                $('input[name="leavingdate"]').val(rejoinedExitDate);
                return false;
            }
        }
        return true;
    }

    // Blur event for manual typing
    $('input[name="joining_date"], input[name="leavingdate"]').on('blur', validateDates);

    // Change event for date picker
    $('input[name="joining_date"], input[name="leavingdate"]').on('change', validateDates);

    // Form submission validation
    $('form').on('submit', function(e) {
        if (!validateDates()) {
            e.preventDefault();
        }
    });


    $('input[name="joining_date"], input[name="leavingdate"]').on('blur', function() {
        var rejoiningDate = "{{ $rejoineduser->rejoiningdate ?? '' }}";
        var rejoinedExitDate = "{{ $rejoineduser->rejoiniedexitdate ?? ($teammember->leavingdate ?? '') }}";

        var joinDate = $('input[name="joining_date"]').val();
        var leaveDate = $('input[name="leavingdate"]').val();

        // ✅ Validate only when both inputs have full valid date format (YYYY-MM-DD)
        if (/^\d{4}-\d{2}-\d{2}$/.test(joinDate) && /^\d{4}-\d{2}-\d{2}$/.test(leaveDate)) {
            var join = new Date(joinDate);
            var leave = new Date(leaveDate);

            if (isNaN(join.getTime()) || isNaN(leave.getTime())) {
                return; // skip invalid
            }

            if (leave <= join) {
                alert("Please select Leaving Date greater than Joining/Rejoining Date");

                // Reset to original values after alert
                $('input[name="joining_date"]').val(rejoiningDate);
                $('input[name="leavingdate"]').val(rejoinedExitDate);
            }
        } else {
            // 👇 No validation if the user hasn’t completed the full date yet
            return;
        }
    });


    $(document).on('input change', 'input[name="joining_date"], input[name="leavingdate"]', function() {
        var $joinInput = $('input[name="joining_date"]');
        var $leaveInput = $('input[name="leavingdate"]');

        // Original values (for reset on invalid)
        var originalJoining = "{{ $latest?->date ?? ($teammember->final_joiningdate ?? '') }}";
        var originalLeaving = "{{ $latest?->exit_date ?? ($teammember->leavingdate ?? '') }}";

        var joinVal = $joinInput.val().trim();
        var leaveVal = $leaveInput.val().trim();

        // Skip if both are empty
        if (!joinVal || !leaveVal) return;

        // Parse dates (supports manual typing in YYYY-MM-DD)
        var joinDate = parseDate(joinVal);
        var leaveDate = parseDate(leaveVal);

        // If parsing failed
        if (!joinDate || !leaveDate) {
            // Optional: highlight invalid
            // $joinInput.toggleClass('is-invalid', !joinDate);
            // $leaveInput.toggleClass('is-invalid', !leaveDate);
            return;
        }

        // Compare: Leaving > Joining
        if (leaveDate > joinDate) {
            // Valid → remove any error style
            $joinInput.removeClass('is-invalid');
            $leaveInput.removeClass('is-invalid');
        } else {
            // Invalid
            alert("Please select Leaving Date greater than Joining/Rejoining Date");

            // Reset to original safe values
            $joinInput.val(originalJoining).removeClass('is-invalid');
            $leaveInput.val(originalLeaving).removeClass('is-invalid');
        }
    });

    // Helper: Parse YYYY-MM-DD string to Date object
    function parseDate(dateStr) {
        if (!dateStr) return null;
        var parts = dateStr.split('-');
        if (parts.length !== 3) return null;
        var year = parseInt(parts[0], 10);
        var month = parseInt(parts[1], 10) - 1; // JS months are 0-indexed
        var day = parseInt(parts[2], 10);
        if (isNaN(year) || isNaN(month) || isNaN(day)) return null;
        var date = new Date(year, month, day);
        // Check if date is valid (e.g., not Feb 30)
        if (date.getFullYear() !== year || date.getMonth() !== month || date.getDate() !== day) {
            return null;
        }
        return date;
    }
</script>
{{--  Start Hare --}}

<script>
    $(document).ready(function() {
        $('#enableDesignation').on('change', function() {
            $('#designationSelect').prop('disabled', !this.checked);
        });

        // check session for which tab should be active
        @if (session('activeTab') == 'rejoining')
            $('#pills-user-tab').tab('show');
        @endif

        $('.alert-success, .alert-danger').delay(5000).fadeOut(400);
    });
</script>
{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare --}}

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>

<script>
    $(document).ready(function() {
        var table = $('#examplee').DataTable({
            "pageLength": 100,
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
                // {
                //     extend: 'excelHtml5',
                //     action: function(e, dt, button, config) {
                //         // Prepare data array
                //         var data = [];

                //         // Header 15,  columns 8 assignment + 7 invoice
                //         var headers = [
                //             'Assignment Code', 'Client Name', 'Assignment Name',
                //             'Partner Name', 'Document Completed Date',
                //             '% of Document Completed', 'Status',
                //             'Assignment Closed Date', 'Assignment Created Date',
                //             'Invoice Number', 'Date of Invoice',
                //             'Basic Invoice Amount', 'OPE', 'GST',
                //             'Total Invoice Amount', 'Payment Status'
                //         ];
                //         data.push(headers);

                //         // every <tr> in the original table
                //         $('#examplee tbody tr').each(function() {
                //             var $tr = $(this);
                //             var invoices = $tr.data('invoices') || [];

                //             // Main assignment row 8 columns
                //             var mainRow = [];

                //             // we use :eq() because the first <td> id is hidden
                //             mainRow.push($tr.find('td:eq(1)').text()
                //                 .trim()); // Assignment Code
                //             mainRow.push($tr.find('td:eq(2)').text()
                //                 .trim()); // Client Name
                //             mainRow.push($tr.find('td:eq(3)').text()
                //                 .trim()); // Assignment Name
                //             mainRow.push($tr.find('td:eq(4)').text()
                //                 .trim()); // Partner Name
                //             mainRow.push($tr.find('td:eq(5)').text()
                //                 .trim()); // Document Completed Date
                //             mainRow.push($tr.find('td:eq(6)').text()
                //                 .trim()); // % of Document Completed
                //             mainRow.push($tr.find('td:eq(7)').text().trim()); // Status
                //             mainRow.push($tr.find('td:eq(8)').text()
                //                 .trim()); // Assignment Closed Date
                //             mainRow.push($tr.find('td:eq(9)').text()
                //                 .trim()); // Assignment Created Date

                //             // remaining 7 invoice columns with empty strings
                //             for (var i = 0; i < 7; i++) mainRow.push('');
                //             data.push(mainRow);

                //             // //Invoice row if any
                //             invoices.forEach(function(inv) {
                //                 var invRow = [];

                //                 // 8 empty cells for the assignment part
                //                 for (var j = 0; j < 9; j++) invRow.push('');

                //                 // Invoice fields
                //                 invRow.push(inv.invoice_id ?? 'N/A');
                //                 invRow.push(
                //                     inv.created_at ?
                //                     new Date(inv.created_at).toISOString()
                //                     .split('T')[0] :
                //                     'N/A'
                //                 );
                //                 invRow.push(inv.amount ?? 0);
                //                 invRow.push(inv.pocketexpenseamount ?? 0);
                //                 invRow.push((inv.total ?? 0) - (inv.amount ??
                //                     0)); // GST
                //                 invRow.push(inv.total ?? 0);
                //                 invRow.push(
                //                     inv.paymentstatus == null ?
                //                     'Not Received' :
                //                     (inv.paymentstatus ?? 'N/A')
                //                 );

                //                 data.push(invRow);
                //             });
                //         });

                //         //Export with SheetJS (XLSX)
                //         var ws = XLSX.utils.aoa_to_sheet(data);
                //         var wb = XLSX.utils.book_new();
                //         XLSX.utils.book_append_sheet(wb, ws, 'Assignments');
                //         wb = applyExcelStyling(wb);
                //         XLSX.writeFile(wb, 'assignments_completed.xlsx');
                //     }


                // },
                {
                    extend: 'excelHtml5',
                    action: function(e, dt, button, config) {
                        // Prepare data array
                        var data = [];
                        // Header 16,  columns 9 assignment + 7 invoice
                        var headers = [
                            'Assignment Code', 'Client Name', 'Assignment Name',
                            'Partner Name', 'Document Completed Date',
                            '% of Document Completed', 'Status',
                            'Assignment Closed Date', 'Assignment Created Date',
                            'Invoice Number', 'Date of Invoice',
                            'Basic Invoice Amount', 'OPE', 'GST',
                            'Total Invoice Amount', 'Payment Status'
                        ];
                        data.push(headers);

                        // Use DataTables to get only parent rows
                        table.rows({
                            page: 'current'
                        }).every(function(rowIdx, tableLoop, rowLoop) {
                            var tr = this.node();
                            var $tr = $(tr);

                            if ($tr.hasClass('child') || $tr.prev().hasClass('shown')) {
                                return; // Skip child rows
                            }

                            var invoices = $tr.data('invoices') || [];

                            // Main assignment row 9 columns
                            var mainRow = [];
                            // we use :eq() because the first <td> id is hidden
                            mainRow.push($tr.find('td:eq(1)').text()
                                .trim()); // Assignment Code
                            mainRow.push($tr.find('td:eq(2)').text()
                                .trim()); // Client Name
                            mainRow.push($tr.find('td:eq(3)').text()
                                .trim()); // Assignment Name
                            mainRow.push($tr.find('td:eq(4)').text()
                                .trim()); // Partner Name
                            mainRow.push($tr.find('td:eq(5)').text()
                                .trim()); // Document Completed Date
                            mainRow.push($tr.find('td:eq(6)').text()
                                .trim()); // % of Document Completed
                            mainRow.push($tr.find('td:eq(7)').text().trim()); // Status
                            mainRow.push($tr.find('td:eq(8)').text()
                                .trim()); // Assignment Closed Date
                            mainRow.push($tr.find('td:eq(9)').text()
                                .trim()); // Assignment Created Date

                            // remaining 7 invoice columns with empty strings
                            for (var i = 0; i < 7; i++) mainRow.push('');
                            data.push(mainRow);

                            // Invoice row if any
                            invoices.forEach(function(inv) {
                                var invRow = [];

                                // 9 empty cells for the assignment part
                                for (var j = 0; j < 9; j++) invRow.push(
                                    '');

                                // Invoice fields 
                                invRow.push(inv.invoice_id ?? 'N/A');
                                invRow.push(
                                    inv.created_at ?
                                    new Date(inv.created_at).toISOString()
                                    .split('T')[0] :
                                    'N/A'
                                );
                                invRow.push(inv.amount ?? 0);
                                invRow.push(inv.pocketexpenseamount ?? 0);
                                invRow.push((inv.total ?? 0) - (inv.amount ??
                                    0)); // GST
                                invRow.push(inv.total ?? 0);
                                invRow.push(
                                    inv.paymentstatus == null ?
                                    'Not Received' :
                                    (inv.paymentstatus ?? 'N/A')
                                );
                                data.push(invRow);
                            });
                        });

                        //Export with SheetJS (XLSX)
                        var ws = XLSX.utils.aoa_to_sheet(data);
                        var wb = XLSX.utils.book_new();
                        XLSX.utils.book_append_sheet(wb, ws, 'Assignments');
                        wb = applyExcelStyling(wb);
                        XLSX.writeFile(wb, 'assignments_completed.xlsx');
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

        function applyExcelStyling(workbook) {
            var ws = workbook.Sheets["Assignments"];

            ws['!cols'] = [{
                    wch: 18
                }, // Assignment Code
                {
                    wch: 22
                }, // Client Name
                {
                    wch: 30
                }, // Assignment Name
                {
                    wch: 22
                }, // Partner Name
                {
                    wch: 22
                }, // Document Completed Date
                {
                    wch: 22
                }, //% of Document Completed
                {
                    wch: 15
                }, // Status
                {
                    wch: 22
                }, // Assignment Closed Date
                {
                    wch: 22
                }, // Assignment Created Date
                {
                    wch: 18
                }, // Invoice Number
                {
                    wch: 18
                }, // Date of Invoice
                {
                    wch: 18
                }, // Basic Amount
                {
                    wch: 12
                }, // OPE
                {
                    wch: 12
                }, // GST
                {
                    wch: 18
                }, // Total Amount
                {
                    wch: 18
                } // Payment Status
            ];

            return workbook;
        }

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
{{--  Start Hare --}}

<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>

<script>
    $(document).ready(function() {
        var table = $('#examplee').DataTable({
            "pageLength": 100,
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
                    text: 'Excel with Invoices',
                    action: function(e, dt, button, config) {
                        // Prepare data array
                        var data = [];

                        // Header 15,  columns 8 assignment + 7 invoice
                        var headers = [
                            'Assignment Code', 'Client Name', 'Assignment Name',
                            'Partner Name', 'Document Completed Date', 'Status',
                            'Assignment Closed Date', 'Assignment Created Date',
                            'Invoice Number', 'Date of Invoice',
                            'Basic Invoice Amount', 'OPE', 'GST',
                            'Total Invoice Amount', 'Payment Status'
                        ];
                        data.push(headers);

                        // every <tr> in the original table
                        $('#examplee tbody tr').each(function() {
                            var $tr = $(this);
                            var invoices = $tr.data('invoices') || [];

                            // Main assignment row 8 columns
                            var mainRow = [];

                            // we use :eq() because the first <td> id is hidden
                            mainRow.push($tr.find('td:eq(1)').text()
                                .trim()); // Assignment Code
                            mainRow.push($tr.find('td:eq(2)').text()
                                .trim()); // Client Name
                            mainRow.push($tr.find('td:eq(3)').text()
                                .trim()); // Assignment Name
                            mainRow.push($tr.find('td:eq(4)').text()
                                .trim()); // Partner Name
                            mainRow.push($tr.find('td:eq(5)').text()
                                .trim()); // Document Completed Date
                            mainRow.push($tr.find('td:eq(6)').text().trim()); // Status
                            mainRow.push($tr.find('td:eq(7)').text()
                                .trim()); // Assignment Closed Date
                            mainRow.push($tr.find('td:eq(8)').text()
                                .trim()); // Assignment Created Date

                            // remaining 7 invoice columns with empty strings
                            for (var i = 0; i < 7; i++) mainRow.push('');
                            data.push(mainRow);

                            //Invoice row if any
                            invoices.forEach(function(inv) {
                                var invRow = [];

                                // 8 empty cells for the assignment part
                                for (var j = 0; j < 8; j++) invRow.push('');

                                // Invoice fields
                                invRow.push(inv.invoice_id ?? 'N/A');
                                invRow.push(
                                    inv.created_at ?
                                    new Date(inv.created_at).toISOString()
                                    .split('T')[0] :
                                    'N/A'
                                );
                                invRow.push(inv.amount ?? 0);
                                invRow.push(inv.pocketexpenseamount ?? 0);
                                invRow.push((inv.total ?? 0) - (inv.amount ??
                                    0)); // GST
                                invRow.push(inv.total ?? 0);
                                invRow.push(
                                    inv.paymentstatus == null ?
                                    'Not Received' :
                                    (inv.paymentstatus ?? 'N/A')
                                );

                                data.push(invRow);
                            });
                        });

                        //Export with SheetJS (XLSX)
                        var ws = XLSX.utils.aoa_to_sheet(data);
                        var wb = XLSX.utils.book_new();
                        XLSX.utils.book_append_sheet(wb, ws, 'Assignments');
                        XLSX.writeFile(wb, 'assignments_completed.xlsx');
                    }
                },

                // {
                //     extend: 'excelHtml5',
                //     text: 'Excel with Invoices (All)',
                //     action: function(e, dt, button, config) {
                //         var data = [];

                //         // Header
                //         var headers = [
                //             'Assignment Code', 'Client Name', 'Assignment Name',
                //             'Partner Name', 'Document Completed Date', 'Status',
                //             'Assignment Closed Date', 'Assignment Created Date',
                //             'Invoice Number', 'Date of Invoice',
                //             'Basic Invoice Amount', 'OPE', 'GST',
                //             'Total Invoice Amount', 'Payment Status'
                //         ];
                //         data.push(headers);

                //         // Get ALL rows from DataTable (ignores pagination, search, etc.)
                //         dt.rows({
                //             page: 'all'
                //         }).every(function() {
                //             var tr = this.node(); // <tr> element
                //             var $tr = $(tr);
                //             var invoices = $tr.data('invoices') || [];

                //             // --- Main Assignment Row ---
                //             var mainRow = [
                //                 $tr.find('td:eq(1)').text()
                //                 .trim(), // Assignment Code
                //                 $tr.find('td:eq(2)').text().trim(), // Client Name
                //                 $tr.find('td:eq(3)').text()
                //                 .trim(), // Assignment Name
                //                 $tr.find('td:eq(4)').text().trim(), // Partner Name
                //                 $tr.find('td:eq(5)').text()
                //                 .trim(), // Document Completed Date
                //                 $tr.find('td:eq(6)').text().trim(), // Status
                //                 $tr.find('td:eq(7)').text()
                //                 .trim(), // Assignment Closed Date
                //                 $tr.find('td:eq(8)').text()
                //                 .trim() // Assignment Created Date
                //             ];
                //             // Add 7 empty cells for invoice columns
                //             for (var i = 0; i < 7; i++) mainRow.push('');
                //             data.push(mainRow);

                //             // --- Invoice Rows ---
                //             invoices.forEach(function(inv) {
                //                 var invRow = ['', '', '', '', '', '', '',
                //                     ''
                //                 ]; // 8 empty for assignment

                //                 invRow.push(inv.invoice_id ?? 'N/A');
                //                 invRow.push(
                //                     inv.created_at ?
                //                     new Date(inv.created_at).toISOString()
                //                     .split('T')[0] :
                //                     'N/A'
                //                 );
                //                 invRow.push(inv.amount ?? 0);
                //                 invRow.push(inv.pocketexpenseamount ?? 0);
                //                 invRow.push((inv.total ?? 0) - (inv.amount ??
                //                     0)); // GST
                //                 invRow.push(inv.total ?? 0);
                //                 invRow.push(
                //                     inv.paymentstatus == null ?
                //                     'Not Received' :
                //                     (inv.paymentstatus ?? 'N/A')
                //                 );

                //                 data.push(invRow);
                //             });
                //         });

                //         // Export
                //         var ws = XLSX.utils.aoa_to_sheet(data);
                //         var wb = XLSX.utils.book_new();
                //         XLSX.utils.book_append_sheet(wb, ws, "Assignments");
                //         XLSX.writeFile(wb, 'all_assignments_with_invoices.xlsx');
                //     }
                // },
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
{{--  regarding filter --}}
<script></script>

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
        var table = $('#DataTable').DataTable({
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

        $('#DataTable thead tr').clone(true).addClass('filters').appendTo('#DataTable thead');
        // $('#DataTable thead .filters th').each(function() {
        //     var title = $(this).text();
        //     var data_name = $(this).data('name');
        //     var data_filter = $(this).data('filter');
        //     if (title == 'SR.' || title == 'Options' || data_name == '#' || data_filter ==
        //         'false') {
        //         $(this).html('');
        //     } else {
        //         $(this).html(
        //             '<input type="text" class="form-control" placeholder="' +
        //             title +
        //             '" />');
        //     }

        // });

        // $('#DataTable thead .filters input').on('blur keyup change', function() {
        //     var columnIndex = $(this).parent().index();
        //     table.column(columnIndex).search($(this).val()).draw();
        // });
    });
</script>
{{-- ! End hare --}}
{{-- * regarding costome button / button style   --}}
{{--  Start Hare --}}
<script></script>
{{--  Start Hare --}}

<script>
    $(document).ready(function() {
        $("table[id^='example']").each(function() {
            let tableId = $(this).attr('id');
            let tableNumber = tableId.replace('example', '');
            let filename = 'KRAs Report' + tableNumber;
            //   console.log(filename);

            $('#' + tableId).DataTable({
                "pageLength": 50,
                dom: '<"d-flex justify-content-end mb-2"B>rtip',
                //   dom: 'Brtip',
                //   dom: 'rtip',
                //   columnDefs: [{
                //       targets: [1, 2, 3, 4, 5],
                //       orderable: false
                //   }],

                buttons: [{
                        extend: 'excelHtml5',
                        text: 'Download KRA',
                        filename: filename,
                        className: 'btn btn-success btn-sm',
                        exportOptions: {
                            columns: ':visible'
                        },
                        customize: function(xlsx) {
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];
                            //   remove extra spaces
                            $('c', sheet).each(function() {
                                var originalText = $(this).find('is t').text();
                                var cleanedText = originalText.replace(/\s+/g,
                                    ' ').trim();
                                $(this).find('is t').text(cleanedText);
                            });
                        }
                    },
                    //   {
                    //       extend: 'colvis',
                    //       text: 'Column Visibility',
                    //       columns: ':not(:nth-child(2)):not(:nth-child(6))'
                    //   }
                ]
            });
        });

    });
</script>
{{-- <script>
      $(document).ready(function() {
          $("table[id^='example']").each(function() {
              let tableId = $(this).attr('id');
              let tableNumber = tableId.replace('example', '');
              let filename = 'KRAs Report' + tableNumber;
              //   console.log(filename);

              $('#' + tableId).DataTable({
                  "pageLength": 50,
                  dom: 'Brtip',
                  //   dom: 'rtip',
                  //   columnDefs: [{
                  //       targets: [1, 2, 3, 4, 5],
                  //       orderable: false
                  //   }],

                  buttons: [{
                          extend: 'excelHtml5',
                          text: 'Download KRA',
                          filename: filename,
                          exportOptions: {
                              columns: ':visible'
                          },
                          customize: function(xlsx) {
                              var sheet = xlsx.xl.worksheets['sheet1.xml'];
                              //   remove extra spaces
                              $('c', sheet).each(function() {
                                  var originalText = $(this).find('is t').text();
                                  var cleanedText = originalText.replace(/\s+/g,
                                      ' ').trim();
                                  $(this).find('is t').text(cleanedText);
                              });
                          }
                      },
                      //   {
                      //       extend: 'colvis',
                      //       text: 'Column Visibility',
                      //       columns: ':not(:nth-child(2)):not(:nth-child(6))'
                      //   }
                  ]
              });
          });

      });
  </script> --}}

{{-- <script>
      $(document).ready(function() {
          $("table[id^='example']").each(function() {
              let tableId = $(this).attr('id');
              let tableNumber = tableId.replace('example', '');
              let filename = 'KRAs Report' + tableNumber;

              $('#' + tableId).DataTable({
                  "pageLength": 50,
                  dom: '<"d-flex justify-content-between align-items-center mb-2"Bf>rtip',
                  // B = Buttons, f = Search box, dom को flex से align किया गया

                  buttons: [{
                      extend: 'excelHtml5',
                      text: 'Download KRA',
                      className: 'btn btn-success btn-sm', // Bootstrap style (optional)
                      filename: filename,
                      exportOptions: {
                          columns: ':visible'
                      },
                      customize: function(xlsx) {
                          var sheet = xlsx.xl.worksheets['sheet1.xml'];
                          // remove extra spaces
                          $('c', sheet).each(function() {
                              var originalText = $(this).find('is t').text();
                              var cleanedText = originalText.replace(/\s+/g,
                                  ' ').trim();
                              $(this).find('is t').text(cleanedText);
                          });
                      }
                  }]
              });
          });
      });
  </script> --}}

<script>
    $(document).ready(function() {
        $("table[id^='example']").each(function() {
            let tableId = $(this).attr('id');
            let tableNumber = tableId.replace('example', '');
            let filename = 'KRAs Report' + tableNumber;

            $('#' + tableId).DataTable({
                "pageLength": 50,
                dom: '<"d-flex justify-content-end mb-2"B>rtip',
                // सिर्फ Button (B) रखा है, और उसे right side align किया है

                buttons: [{
                    extend: 'excelHtml5',
                    text: 'Download KRA',
                    className: 'btn btn-success btn-sm', // Bootstrap style (optional)
                    filename: filename,
                    exportOptions: {
                        columns: ':visible'
                    },
                    customize: function(xlsx) {
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];
                        // remove extra spaces
                        $('c', sheet).each(function() {
                            var originalText = $(this).find('is t').text();
                            var cleanedText = originalText.replace(/\s+/g,
                                ' ').trim();
                            $(this).find('is t').text(cleanedText);
                        });
                    }
                }]
            });
        });
    });
</script>
{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare --}}


<script>
    $(document).ready(function() {
        $('.templatevalidation').on('submit', function(e) {
            e.preventDefault();

            const $form = $(this);
            const $errorSpan = $form.find('#template-error');
            const $inputfocus = $form.find(
                'input[name^="templatename"]'); // templatename / templatename1

            $.ajax({
                type: "POST",
                url: "{{ route('validatetemplatenameoncreate') }}",
                data: $form.serialize(),
                success: function(response) {
                    if (response.exists) {
                        $errorSpan.text("Template name should be unique.");
                        $inputfocus.focus();
                    } else {
                        $errorSpan.text("");
                        // Normal form submit
                        $form.off('submit').submit();
                    }
                },
                error: function() {
                    alert("Validation request failed!");
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('.templatevalidation').on('submit', function(e) {
            e.preventDefault();

            const $form = $(this);
            const $inputfocus = $form.find(
                'input[name^="templatename"]');

            if ($inputfocus.length > 0) {
                const $errorSpan = $form.find('.template-error');

                $.ajax({
                    type: "POST",
                    url: "{{ route('validatetemplatenameoncreate') }}",
                    data: $form.serialize(),
                    success: function(response) {
                        if (response.exists) {
                            $errorSpan.text("Template name should be unique.");
                            $inputfocus.focus();
                        } else {
                            $errorSpan.text("");
                            // normal submit
                            $form.off('submit').submit();
                        }
                    },
                    error: function() {
                        alert("Validation request failed!");
                    }
                });
            } else {
                // normal submit
                $form.off('submit').submit();
            }
        });
    });
</script>

{{-- 
  <script>
      $(document).ready(function() {
          const $form = $('#detailsForm500');
          const $errorSpan = $('#template-error');

          $form.on('submit', function(e) {
              e.preventDefault();

              $.ajax({
                  type: "POST",
                  url: "{{ route('validatetemplatenameoncreate') }}",
                  data: $form.serialize(),
                  success: function(response) {
                      const $errorSpan = $('#template-error');
                      const $inputfocus = $('input[name="templatename1"]');
                      if (response.exists) {
                          $errorSpan.text("Template name should be unique.");
                          $inputfocus.focus();
                      } else {
                          $errorSpan.text("");
                          // normal form submit
                          // if (confirm(
                          //         'Are you sure you want to update this template name?')) {
                          $form.off('submit').submit();
                          // }
                      }
                  },
                  error: function() {
                      alert("Validation request failed!");
                  }
              });
          });
      });
  </script> --}}


{{-- <script>
      $(document).ready(function() {
          const $form = $('#detailsForm');
          const $errorSpan = $('#template-error1');

          $form.on('submit', function(e) {
              e.preventDefault();

              $.ajax({
                  type: "POST",
                  url: "{{ route('validatetemplatenameoncreate') }}",
                  data: $form.serialize(),
                  success: function(response) {
                      const $errorSpan = $('#template-error1');
                      const $inputfocus = $('input[name="templatename"]');
                      if (response.exists) {
                          $errorSpan.text("Template name should be unique.");
                          $inputfocus.focus();
                      } else {
                          $errorSpan.text("");
                          // normal form submit
                          // if (confirm(
                          //         'Are you sure you want to update this template name?')) {
                          $form.off('submit').submit();
                          // }
                      }
                  },
                  error: function() {
                      alert("Validation request failed!");
                  }
              });
          });
      });
  </script> --}}

<script>
    $(document).ready(function() {
        // Common class sabhi forms ko de do, e.g. class="ajax-template-form"
        $('.ajax-template-form').on('submit', function(e) {
            e.preventDefault();

            const $form = $(this);
            const $errorSpan = $form.find('#template-error'); // form ke andar ka error span
            const $inputfocus = $form.find(
                'input[name^="templatename"]'); // templatename / templatename1 dono cover karega

            $.ajax({
                type: "POST",
                url: "{{ route('validatetemplatenameoncreate') }}",
                data: $form.serialize(),
                success: function(response) {
                    if (response.exists) {
                        $errorSpan.text("Template name should be unique.");
                        $inputfocus.focus();
                    } else {
                        $errorSpan.text("");
                        // Normal form submit
                        $form.off('submit').submit();
                    }
                },
                error: function() {
                    alert("Validation request failed!");
                }
            });
        });
    });
</script>
{{--  Start Hare --}}
<form id="modalColumnForm" method="post" action="{{ url('kratemplatelist/edit') }}">
    @csrf
    <div class="modal-header" style="background: #37A000">
        <h5 style="color:white;" class="modal-title font-weight-600" id="modalLabel1">
            KRAs Template Name Edit
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>

    <div class="modal-body">
        <div class="form-group">
            <label><b>Template Name: *</b></label>
            <input type="text" required name="templatename" class="form-control"
                placeholder="Enter new template name">
            <span id="template-error" class="text-danger"></span>
            <input type="hidden" class="form-control" name="templateid" id="templateid">
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-success"
            onclick="return confirm('Are you sure you want to update this template name?');">Update</button>
    </div>
</form>
<script>
    $(document).ready(function() {
        $('.alert-success, .alert-danger, .statusss').delay(4000).fadeOut(400);
    });

    $(document).on('click', '.modificationColumn', function() {
        let id = $(this).data('id');
        let templatename = $(this).data('template');
        $('#modalColumnId input[name="templateid"]').val(id);
        $('#modalColumnId input[name="templatename"]').val(templatename);
        $('#template-error').html("");
    });

    // $('#modalColumnForm').on('hidden.bs.modal', function() {
    //     $('#template-error').html("");
    // });
</script>

<script>
    $(document).ready(function() {
        const $form = $('#modalColumnForm');
        const $templateInput = $form.find('input[name="templatename"]');
        const $errorSpan = $('#template-error');

        $form.on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                type: "POST",
                url: "{{ route('validatetemplatename') }}",
                data: $form.serialize(),
                success: function(response) {
                    if (response.exists) {
                        $errorSpan.text("Template name should be unique.");
                    } else {
                        $errorSpan.text("");
                        // normal form submit
                        // if (confirm(
                        //         'Are you sure you want to update this template name?')) {
                        $form.off('submit').submit();
                        // }
                    }
                },
                error: function() {
                    alert("Validation request failed!");
                }
            });
        });
    });
</script>

<script>
    public

    function validatetemplatename(Request $request) {
        $exists = DB::table('krasdata') -
            >
            where('template_name', $request - > templatename) -
            >
            where('id', '!=', $request - > templateid) -
            >
            exists();

        return response() - > json(['exists' => $exists]);
    }
</script>
{{-- ! End hare --}}
{{-- * regarding scrolling chart / regarding chart   --}}
{{--  Start Hare --}}

hare changes point is
1.
<div style="overflow-x: auto; white-space: nowrap;">
    <canvas id="lapDaysChart" height="300"></canvas>
</div>

2. before this line const lapDaysChart = new Chart(lapDaysChartctx, {

// Set chart width dynamically
const chartWidth = lapDaysMonths.length * 120; // 120px per month
document.getElementById('lapDaysChart').width = chartWidth;
const lapDaysChart = new Chart(lapDaysChartctx, {

3. before this line y: {

options: {
responsive: false, // scrolling enable
maintainAspectRatio: false,
scales: {
y: {

<div class="card">
    <div class="card-header">
        <h2>Lap Days Analysis (Assignment to Invoice)</h2>
    </div>

    <!-- Chart container with scroll -->
    <div style="overflow-x: auto; white-space: nowrap;">
        <canvas id="lapDaysChart" height="300"></canvas>
    </div>
</div>
<script>
    const lapDaysChartctx = document.getElementById('lapDaysChart').getContext('2d');

    var assignmentsWithInvoicerawdata = @json($assignmentsWithInvoices);
    const lapDaysChartmonths = [
        'April', 'May', 'June', 'July', 'August', 'September',
        'October', 'November', 'December', 'January', 'February', 'March'
    ];

    // assignmentsWithInvoicerawdata, missing months == 0
    const assignmentsMonthsfill = {};
    assignmentsWithInvoicerawdata.forEach(item => {
        assignmentsMonthsfill[item.month] = parseFloat(item.averageDifferenceDays);
    });


    // Create data for all months, if month not on that case assigned 0 
    const avgLapDaysData = lapDaysChartmonths.map(month => assignmentsMonthsfill[month] || 0);
    // const targetDays = assignmentsWithInvoicerawdata.map(item => item.targetDays);
    const targetLapDaysData = [7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7];


    // const avgLapDaysData = [12, 8, 16, 12, 6, 10];
    // const targetLapDaysData = [8, 8, 8, 8, 6, 8];
    // const lapDaysMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
    const lapDaysMonths = ['Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan', 'Feb', 'Mar'];
    // Set chart width dynamically
    const chartWidth = lapDaysMonths.length * 120; // 120px per month
    document.getElementById('lapDaysChart').width = chartWidth;
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
            responsive: false, // scrolling enable
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 300,
                    ticks: {
                        stepSize: 25
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
                            const month = lapDaysMonths[index];
                            const avgLapDaysDataValue = avgLapDaysData[index];
                            const targetLapDaysDataValue = targetLapDaysData[index];

                            const innerHtml = `
                                       <div style="background: white; border: 1px solid #ccc; padding: 8px; border-radius: 4px;">
                                           <div style="color: black; font-weight: bold; margin-bottom: 4px;">${month}</div>
                                           <div style="color: red;">Average Lap Days: ${avgLapDaysDataValue} days</div>
                                           <div style="color: green;">Target Lap Days: ${targetLapDaysDataValue} days</div>
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
<div class="card">
    <div class="card-header">
        <h2>Lap Days Analysis (Assignment to Invoice)</h2>
    </div>

    <!-- Chart container with scroll -->
    <div style="overflow-x: auto; white-space: nowrap;">
        <canvas id="lapDaysChart" height="300"></canvas>
    </div>
</div>

<script>
    var assignmentsWithInvoicerawdata = @json($assignmentsWithInvoices);

    const lapDaysChartmonths = [
        'April', 'May', 'June', 'July', 'August', 'September',
        'October', 'November', 'December', 'January', 'February', 'March'
    ];

    const lapDaysMonths = ['Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan', 'Feb', 'Mar'];

    // Fill missing months with 0
    const assignmentsMonthsfill = {};
    assignmentsWithInvoicerawdata.forEach(item => {
        assignmentsMonthsfill[item.month] = parseFloat(item.averageDifferenceDays);
    });

    const avgLapDaysData = lapDaysChartmonths.map(month => assignmentsMonthsfill[month] || 0);
    const targetLapDaysData = Array(12).fill(7); // 7 for all months

    // Set chart width dynamically
    const chartWidth = lapDaysMonths.length * 120; // 120px per month
    document.getElementById('lapDaysChart').width = chartWidth;

    const ctx = document.getElementById('lapDaysChart').getContext('2d');

    const lapDaysChart = new Chart(ctx, {
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
            responsive: false, // scrolling enable
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 300,
                    ticks: {
                        stepSize: 25
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
                            const month = lapDaysMonths[index];
                            const avgLapDaysDataValue = avgLapDaysData[index];
                            const targetLapDaysDataValue = targetLapDaysData[index];

                            const innerHtml = `
                               <div style="background: white; border: 1px solid #ccc; padding: 8px; border-radius: 4px;">
                                   <div style="color: black; font-weight: bold; margin-bottom: 4px;">${month}</div>
                                   <div style="color: red;">Average Lap Days: ${avgLapDaysDataValue} days</div>
                                   <div style="color: green;">Target Lap Days: ${targetLapDaysDataValue} days</div>
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
<script></script>
{{--  Start Hare --}}
<script></script>
{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare --}}
<script>
    $(document).ready(function() {
        function updateEngagementFee() {
            let currency = $('#Currency').val();
            let amount = parseFloat($('#amount').val()) || 0;

            if (currency && amount > 0) {
                $.ajax({
                    url: '{{ route('exchange.rate') }}',
                    method: 'GET',
                    data: {
                        currency: currency,
                        amount: amount
                    },
                    success: function(response) {
                        if (response.engagement_fee !== undefined) {
                            $('#engagementfee').val(response.engagement_fee);
                            if (response.exchange_rate !== undefined) {
                                $('#exchangerate').val(response.exchange_rate);
                            } else {
                                $('#exchangerate').val('NA');
                            }
                        } else {
                            $('#engagementfee').val('Error');
                            $('#exchangerate').val('NA');
                            console.error('API error:', response.error);
                        }
                    },
                    error: function(jqXHR) {
                        $('#engagementfee').val('NA');
                        $('#exchangerate').val('NA');
                        console.error('AJAX error:', jqXHR.responseJSON?.error || jqXHR.statusText);
                    }
                });
            } else {
                $('#engagementfee').val('');
                $('#exchangerate').val('');
            }
        }

        $('#Currency').on('change', updateEngagementFee);
        $('#amount').on('input', updateEngagementFee);
    });
</script>
{{--  Start Hare --}}
<script>
    cashInflowData.forEach((inflow, index) => {
        const outflow = cashOutflowData[index];
        const net = inflow - outflow;
        console.log(`Month ${index + 1}: Inflow = ${inflow}, Outflow = ${outflow}, Net = ${net}`);
    });
</script>
{{--  Start Hare --}}
{{-- for preview of an Excel fil  --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
{{-- <script>
          //   Global Variables:
          let excelData = [];
          let currentPage = 1;
          const rowsPerPage = 10;

          //   Excel Serial Date Conversion Function hare date formating
          function excelSerialToDate(serial) {
              const utc_days = Math.floor(serial - 25569);
              const utc_value = utc_days * 86400;
              return new Date(utc_value * 1000);
          }

          //   File Selection Handler
          function handleFileSelect(event) {
              const file = event.target.files[0];
              const reader = new FileReader();

              reader.onload = function(e) {
                  const data = new Uint8Array(e.target.result);
                  const workbook = XLSX.read(data, {
                      type: 'array'
                  });
                  const sheetName = workbook.SheetNames[0];
                  const sheet = workbook.Sheets[sheetName];
                  excelData = XLSX.utils.sheet_to_json(sheet, {
                      header: 1,
                      raw: false,
                      dateNF: 'yyyy-mm-dd'
                  });

                  // Filter and remove empty rows
                  excelData = excelData.filter(row => {
                      return row.some(cell => cell !== null && cell !== undefined && cell.toString().trim() !==
                          '');
                  });

                  displayHeaderRow(excelData[0]);
                  displayData(currentPage);
              };
              reader.readAsArrayBuffer(file);
          }

          //   Header Capitalize Function
          function capitalizeFirstLetter(string) {
              return string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
          }

          //   Display Header Row in Table
          function displayHeaderRow(headerRow) {
              const tableHeader = document.getElementById('table-header');
              tableHeader.innerHTML = '';
              const tr = document.createElement('tr');
              headerRow.forEach(header => {
                  const th = document.createElement('th');
                  // Capitalize the first letter of each header
                  th.textContent = capitalizeFirstLetter(header);
                  tr.appendChild(th);
              });
              tableHeader.appendChild(tr);
          }

          //   Display Paginated Data
          function displayData(page) {
              const startIndex = (page - 1) * rowsPerPage;
              const endIndex = startIndex + rowsPerPage;
              const totalPages = Math.ceil((excelData.length - 1) / rowsPerPage);

              const tableBody = document.getElementById('table-body');
              tableBody.innerHTML = '';

              for (let i = startIndex + 1; i < endIndex + 1 && i < excelData.length; i++) {
                  const row = excelData[i];
                  const tr = document.createElement('tr');
                  for (let j = 0; j < excelData[0].length; j++) {
                      const td = document.createElement('td');
                      if (j < row.length) {
                          let cellValue = row[j];
                          //  for date column  
                          //   if (j === 3 && !isNaN(cellValue)) {
                          //       const date = excelSerialToDate(cellValue);
                          //       cellValue = date.toLocaleDateString();
                          //   }
                          td.textContent = cellValue;
                      } else {
                          td.textContent = ""; // For blank cells
                      }
                      tr.appendChild(td);
                  }
                  tableBody.appendChild(tr);
              }

              displayPagination(totalPages);
          }

          //   Pagination Display Function
          function displayPagination(totalPages) {
              const pagination = document.getElementById('pagination');
              pagination.innerHTML = '';

              for (let i = 1; i <= totalPages; i++) {
                  const li = document.createElement('li');
                  li.className = 'page-item';
                  const a = document.createElement('a');
                  a.className = 'page-link';
                  a.href = '#';
                  a.textContent = i;

                  a.addEventListener('click', (e) => {
                      e.preventDefault();
                      currentPage = i;
                      displayData(currentPage);
                  });
                  li.appendChild(a);
                  pagination.appendChild(li);
              }
          }

          document.getElementById('input-excel').addEventListener('change', handleFileSelect);
      </script>

      <script>
          //   Global Variables:
          let excelData = [];
          let currentPage = 1;
          const rowsPerPage = 10;

          //   Excel Serial Date Conversion Function hare date formating
          function excelSerialToDate(serial) {
              const utc_days = Math.floor(serial - 25569);
              const utc_value = utc_days * 86400;
              return new Date(utc_value * 1000);
          }

          //   File Selection Handler
          function handleFileSelect(event) {
              const file = event.target.files[0];
              const reader = new FileReader();

              reader.onload = function(e) {
                  const data = new Uint8Array(e.target.result);
                  const workbook = XLSX.read(data, {
                      type: 'array'
                  });
                  const sheetName = workbook.SheetNames[0];
                  const sheet = workbook.Sheets[sheetName];
                  excelData = XLSX.utils.sheet_to_json(sheet, {
                      header: 1,
                      raw: false,
                      dateNF: 'yyyy-mm-dd'
                  });

                  // Filter and remove empty rows
                  excelData = excelData.filter(row => {
                      return row.some(cell => cell !== null && cell !== undefined && cell.toString().trim() !==
                          '');
                  });

                  displayHeaderRow(excelData[0]);
                  displayData(currentPage);
              };
              reader.readAsArrayBuffer(file);
          }

          //   Header Capitalize Function
          function capitalizeFirstLetter(string) {
              return string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
          }

          //   Display Header Row in Table
          function displayHeaderRow(headerRow) {
              const tableHeader = document.getElementById('table-header1');
              tableHeader.innerHTML = '';
              const tr = document.createElement('tr');
              headerRow.forEach(header => {
                  const th = document.createElement('th');
                  // Capitalize the first letter of each header
                  th.textContent = capitalizeFirstLetter(header);
                  tr.appendChild(th);
              });
              tableHeader.appendChild(tr);
          }

          //   Display Paginated Data
          function displayData(page) {
              const startIndex = (page - 1) * rowsPerPage;
              const endIndex = startIndex + rowsPerPage;
              const totalPages = Math.ceil((excelData.length - 1) / rowsPerPage);

              const tableBody = document.getElementById('table-body1');
              tableBody.innerHTML = '';

              for (let i = startIndex + 1; i < endIndex + 1 && i < excelData.length; i++) {
                  const row = excelData[i];
                  const tr = document.createElement('tr');
                  for (let j = 0; j < excelData[0].length; j++) {
                      const td = document.createElement('td');
                      if (j < row.length) {
                          let cellValue = row[j];
                          //  for date column  
                          //   if (j === 3 && !isNaN(cellValue)) {
                          //       const date = excelSerialToDate(cellValue);
                          //       cellValue = date.toLocaleDateString();
                          //   }
                          td.textContent = cellValue;
                      } else {
                          td.textContent = ""; // For blank cells
                      }
                      tr.appendChild(td);
                  }
                  tableBody.appendChild(tr);
              }

              displayPagination(totalPages);
          }

          //   Pagination Display Function
          function displayPagination(totalPages) {
              const pagination = document.getElementById('pagination1');
              pagination.innerHTML = '';

              for (let i = 1; i <= totalPages; i++) {
                  const li = document.createElement('li');
                  li.className = 'page-item';
                  const a = document.createElement('a');
                  a.className = 'page-link';
                  a.href = '#';
                  a.textContent = i;

                  a.addEventListener('click', (e) => {
                      e.preventDefault();
                      currentPage = i;
                      displayData(currentPage);
                  });
                  li.appendChild(a);
                  pagination.appendChild(li);
              }
          }

          document.getElementById('input-excel1').addEventListener('change', handleFileSelect);
      </script> --}}

<script>
    function initializeExcelUpload(inputId, tableHeaderId, tableBodyId, paginationId) {
        const input = document.getElementById(inputId);
        let excelData = [];
        let currentPage = 1;
        const rowsPerPage = 10;

        input.addEventListener('change', function(event) {
            const file = event.target.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                const data = new Uint8Array(e.target.result);
                const workbook = XLSX.read(data, {
                    type: 'array'
                });
                const sheetName = workbook.SheetNames[0];
                const sheet = workbook.Sheets[sheetName];
                excelData = XLSX.utils.sheet_to_json(sheet, {
                    header: 1,
                    raw: false
                });

                // Remove empty rows
                excelData = excelData.filter(row => row.some(cell => cell !== null && cell !== undefined &&
                    cell.toString().trim() !== ''));

                displayHeaderRow(excelData[0]);
                displayData(currentPage);
            };
            reader.readAsArrayBuffer(file);
        });

        function capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
        }

        function displayHeaderRow(headerRow) {
            const tableHeader = document.getElementById(tableHeaderId);
            tableHeader.innerHTML = '';
            const tr = document.createElement('tr');
            headerRow.forEach(header => {
                const th = document.createElement('th');
                th.textContent = capitalizeFirstLetter(header);
                tr.appendChild(th);
            });
            tableHeader.appendChild(tr);
        }

        function displayData(page) {
            const startIndex = (page - 1) * rowsPerPage;
            const endIndex = startIndex + rowsPerPage;
            const totalPages = Math.ceil((excelData.length - 1) / rowsPerPage);

            const tableBody = document.getElementById(tableBodyId);
            tableBody.innerHTML = '';

            for (let i = startIndex + 1; i < endIndex + 1 && i < excelData.length; i++) {
                const row = excelData[i];
                const tr = document.createElement('tr');
                for (let j = 0; j < excelData[0].length; j++) {
                    const td = document.createElement('td');
                    td.textContent = row[j] || "";
                    tr.appendChild(td);
                }
                tableBody.appendChild(tr);
            }

            displayPagination(totalPages);
        }

        function displayPagination(totalPages) {
            const pagination = document.getElementById(paginationId);
            pagination.innerHTML = '';
            for (let i = 1; i <= totalPages; i++) {
                const li = document.createElement('li');
                li.className = 'page-item';
                const a = document.createElement('a');
                a.className = 'page-link';
                a.href = '#';
                a.textContent = i;
                a.addEventListener('click', (e) => {
                    e.preventDefault();
                    currentPage = i;
                    displayData(currentPage);
                });
                li.appendChild(a);
                pagination.appendChild(li);
            }
        }
    }
    initializeExcelUpload('input-excel', 'table-header', 'table-body', 'pagination');
    initializeExcelUpload('input-excel1', 'table-header1', 'table-body1', 'pagination1');
</script>
{{-- ! End hare --}}
{{-- * regarding datatable   --}}
{{--  Start Hare --}}

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
{{-- date sorting  --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script>
    $(document).ready(function() {
        $('#examplee').DataTable({
            "pageLength": 10,
            dom: 'Bfrtip',
            "order": [
                [0, "desc"]
            ],

            columnDefs: [{
                    targets: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                    orderable: false
                },
                {
                    targets: 0, // Date column
                    type: 'date', // assign date column 
                    render: function(data, type, row) {
                        // date value when sorting/filtering
                        if (type === 'sort' || type === 'type') {
                            return data ? moment(data, 'DD-MM-YYYY').format(
                                'YYYY-MM-DD') : '';
                        }
                        return data;
                    }
                }
            ],

            buttons: [{
                extend: 'excelHtml5',
                filename: 'My Application',
                text: 'Export to Excel',
                className: 'btn-excel',
                exportOptions: {
                    columns: ':visible',
                },
                customize: function(xlsx) {
                    var sheet = xlsx.xl.worksheets['sheet1.xml'];
                    $('c', sheet).each(function() {
                        var originalText = $(this).find('is t').text();
                        var cleanedText = originalText.replace(/\s+/g, ' ').trim();
                        $(this).find('is t').text(cleanedText);
                    });
                }
            }, ]
        });
    });
</script>


<script>
    $(document).ready(function() {
        const hasPendingRequests = @json($hasPendingRequests);
        const nonOrderableColumns = hasPendingRequests ? [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11] : [1, 2, 3, 4, 5,
            6, 7, 8, 9
        ];
        console.log('jjjjjjjjjjjjjj');
        console.log(hasPendingRequests);

        $('#exampleee').DataTable({
            "pageLength": 10,
            // remove button 
            // dom: 'Bfrtip',

            // remove search box
            // dom: 'frtip',
            dom: 'rtip',
            "order": [
                [0, "desc"]
            ],

            columnDefs: [{
                    targets: nonOrderableColumns,
                    orderable: false
                },
                {
                    targets: 0, // Date column
                    type: 'date', // assign date column 
                    render: function(data, type, row) {
                        // date value when sorting/filtering
                        if (type === 'sort' || type === 'type') {
                            return data ? moment(data, 'DD-MM-YYYY').format(
                                'YYYY-MM-DD') : '';
                        }
                        return data;
                    }
                }
            ],

            // buttons: [{
            //     extend: 'excelHtml5',
            //     filename: 'Team Application',
            //     text: 'Export to Excel',
            //     className: 'btn-excel',
            //     exportOptions: {
            //         columns: ':visible',
            //     },
            //     customize: function(xlsx) {
            //         var sheet = xlsx.xl.worksheets['sheet1.xml'];
            //         $('c', sheet).each(function() {
            //             var originalText = $(this).find('is t').text();
            //             var cleanedText = originalText.replace(/\s+/g, ' ').trim();
            //             $(this).find('is t').text(cleanedText);
            //         });
            //     }
            // }, ]
        });
    });
</script>
{{--  Start Hare --}}
{{-- ! End hare --}}
{{-- * regarding jquery /  --}}
{{--  Start Hare --}}
{{--  Start Hare --}}
{{--  Start Hare --}}
<script>
    const test1 = $("#datepickers1").val();
    const test2 = $("#datepickers1").val().split('-');
    const test3 = $("#datepickers1").val().split('-').reverse();
    const test4 = $("#datepickers1").val().split('-').reverse().join('-');

    // output is 
    // test1 10-04-2025
    // create:1111 test2 (3) ['10', '04', '2025']0: "10"1: "04"2: "2025"length: 3[[Prototype]]: Array(0)
    // create:1112 test3 (3) ['2025', '04', '10']
    // create:1113 test4 2025-04-10
</script>
{{--  Start Hare --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        // Download button click event
        $('#downloadzip').click(function() {
            // Disable the button to prevent multiple clicks
            $(this).prop('disabled', true);

            // You can also hide the button if needed
            // $(this).hide();
        });
    });
</script>
{{--  Start Hare --}}
{{-- ! End hare --}}



{{-- ########################################################################### --}}
{{-- 06-05-2025 --}}




</html>
