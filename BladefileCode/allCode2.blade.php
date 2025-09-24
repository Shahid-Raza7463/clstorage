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
