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
{{-- * regarding  --}}
{{--  Start Hare --}}
<script></script>
{{--  Start Hare --}}
<script></script>
{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare --}}
<script></script>
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
