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
                background-color: #f5f7fa;
                color: #333;
                padding: 20px;
                font-family: Arial, sans-serif;
            }

            .card {
                background: white;
                border-radius: 12px;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
                padding: 25px;
                margin-bottom: 25px;
            }

            .card-header h2 {
                font-size: 20px;
                font-weight: 800;
                color: #2c3e50;
            }

            #expenseChart {
                width: 100%;
                height: 300px;
            }
        </style>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <div class="card">
            <div class="card-header">
                <h2>Monthly Expense Analysis</h2>
            </div>
            <canvas id="expenseChart"></canvas>
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
                            backgroundColor: 'rgba(75, 192, 192, 0.6)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Expenses',
                            data: [55000, 60000, 40000, 70000, 75000, 50000],
                            backgroundColor: 'rgba(255, 99, 132, 0.6)',
                            borderColor: 'rgba(255, 99, 132, 1)',
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
    @endsection
