<!doctype html>
<html lang="en">

<head>
    <!--  meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        .required::after {
            content: "*";
            color: red;
            margin-left: 5px;
        }

        body {
            background-image: url('{{ asset('backEnd/image/unnamed.jpg') }}');
            /* Corrected URL and added missing closing parenthesis */
            background-size: cover;
            background-repeat: no-repeat;
        }
    </style>
    <style>
        #alert-container {
            position: fixed;
            border-radius: 12px;
            top: 46px;
            right: 179px;
            width: 15%;
            padding: 10px;
            background-color: #28a745;
            /* Set your desired background color for the alert */
            color: white;
            /* Set your desired text color for the alert */
            display: none;
        }
    </style>
</head>

<body>
    <div id="alert-container"></div>
    <div class="content-wrapper">
        <div class="main-content pt-5">
            <div style="float: right; margin-right:80px;" class=" align-items-center">
                <button class="btn btn-info" onclick="printDiv('printableArea', 'offer_letter.pdf')"><i
                        class="fa fa-print"></i>&nbsp;Print</button>
                <button class="btn btn-secondary" style="color:white;"
                    onclick="downloadPdf('printableArea', 'offer_letter.pdf')">Download PDF</button>

                @if ($offerletterData->confirmation_status == 2)
                    <button class="btn btn-success" data-toggle="modal"
                        data-target="#confirmModal">Acknowledged</button>
                    <button class="btn btn-danger" data-toggle="modal" data-target="#rejectModalFinal">Not
                        Acknowledged</button>
                @endif
            </div>
            <!--/.Content Header (Page header)-->
            <div id="printableArea">
                {{-- <section class="vh-100 gradient-custom"> --}}
                <div class="container py-5 h-100">
                    <div class="row justify-content-center align-items-center h-100">
                        <div class="col-12 col-lg-12 col-xl-12">
                            <div class="card shadow-2-strong card-registration">
                                <div class="card-body p-md-5">

                                    <div class="row" style="margin-top:-37px;">
                                        <div class="col-sm-12">
                                            <address>
                                                @if ($offerletterData->company_name == 'CAPITALL INDIA PRIVATE LIMITED')
                                                    <img style="height:60px;"
                                                        src="{{ url('backEnd/image/capitall.png') }}">
                                                @elseif($offerletterData->company_name == 'KGS FINTECH PRIVATE LIMITED')
                                                    <h2><strong style="color:rgb(0,31,95)">KGS FINTECH PRIVATE
                                                            LIMITED</strong></h2>
                                                @elseif($offerletterData->company_name == 'K G SOMANI & CO. LLP')
                                                    <h2><strong style="color:rgb(0,31,95)">K G SOMANI & CO. LLP</strong>
                                                    </h2>
                                                    <strong style="margin-left: 66px;color:rgb(0,31,95)">CHARTERED
                                                        ACCOUNTANTS</strong><br>
                                                @elseif($offerletterData->company_name == 'K G Somani & Co')
                                                    <img style="height:60px;"
                                                        src="{{ url('backEnd/image/kgsomani.png') }}">
                                                @elseif($offerletterData->company_name == 'KG SOMANI MANAGEMENT CONSL PVT LTD')
                                                    <h2><strong style="color:rgb(0,31,95)">KG SOMANI MANAGEMENT CONSL
                                                            PVT LTD</strong></h2>
                                                @elseif($offerletterData->company_name == 'SK LOONKER & ASSOCIATE')
                                                    <h2><strong style="color:rgb(0,31,95)">SK LOONKER &
                                                            ASSOCIATE</strong></h2>
                                                @elseif($offerletterData->company_name == 'KG Somani Insolvency Professionals Pvt Lt')
                                                    <h2><strong style="color:rgb(0,31,95)">KG Somani Insolvency
                                                            Professionals Pvt Lt</strong></h2>
                                                @elseif($offerletterData->company_name == 'Womennovator')
                                                    <img style="height:60px;"
                                                        src="{{ url('backEnd/image/womennovator.png') }}">
                                                @elseif($offerletterData->company_name == 'K G SOMANI & CO LLP - MAHARASHTR')
                                                    <img style="height:60px;"
                                                        src="{{ url('backEnd/image/kgsomani.png') }}">
                                                @elseif($offerletterData->company_name == 'K G S Advisors LLP')
                                                    <img style="height:60px;"
                                                        src="{{ url('backEnd/image/kgsomani.png') }}">
                                                @endif

                                            </address>
                                        </div>

                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-12">
                                            <p class="m-0"><b>Date :
                                                    {{ date('F d,Y', strtotime($offerletterData->offer_date)) ?? '' }}</b>
                                            </p>
                                            <p class="m-0"><b>Name : {{ $offerletterData->name ?? '' }}</b></p>
                                            <p class="m-0"><b>Permanent Address :
                                                    {{ $offerletterData->permanentaddress ?? '' }}</b></p>
                                            <p class="m-0"><b>Communication Address :
                                                    {{ $offerletterData->communicationaddress ?? '' }}</b></p>
                                        </div>
                                    </div>

                                    <div class="text-center font-wieght-bold">
                                        <p class=""
                                            style="font-wieght:bold; text-decoration:underline; font-size:20px">
                                            <b>Subject: Offer Letter</b>
                                        </p>
                                    </div>
                                    <div class="">
                                        <p><b>Dear {{ $offerletterData->name ?? '' }},</b></p>
                                    </div>
                                    <p>Congratulations! We are pleased to confirm that you have been selected to work
                                        for <b> {{ $offerletterData->company_name ?? '' }}</b>. It’s a pleasure to
                                        extend to you the offer of Internship for
                                        the position of
                                        <b>{{ $offerletterData->designation ?? '' }}({{ $offerletterData->department ?? '' }})</b>.
                                        We are delighted to make you the following offer:-
                                    </p>
                                    <table class="table display table-bordered table-striped table-hover center mx-auto"
                                        style="width: 50%">
                                        <tbody>
                                            <tr>
                                                <td><b>Intern Name</b></td>
                                                <td>{{ $offerletterData->salutation ?? '' }}.{{ $offerletterData->name ?? '' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><b>Designation</b></td>
                                                <td>{{ $offerletterData->designation ?? '' }}</td>
                                            </tr>
                                            <tr>
                                                <td><b>Department</b></td>
                                                <td>{{ $offerletterData->department ?? '' }}</td>
                                            </tr>
                                            <tr>
                                                <td><b>Start Date</b></td>
                                                <td>{{ date('F d,Y', strtotime($offerletterData->date_of_joining)) ?? '' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><b>End Date</b></td>
                                                <td>{{ date('F d,Y', strtotime($formattedDate)) ?? '' }}</td>
                                            </tr>
                                            <tr>
                                                <td><b>Stipend</b></td>
                                                <td>{{ $offerletterData->total_ctc ?? '' }}</td>
                                            </tr>
                                            <tr>
                                                <td><b>Duration of internship</b></td>
                                                <td>{{ $offerletterData->duration_internship ?? '' }} Months</td>
                                            </tr>
                                            <tr>
                                                <td><b>Leaves Allowed</b></td>
                                                <td>Nil</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <p class="text-justify">In case you voluntarily wish to leave the organization, you
                                        would need to serve a notice period of
                                        <b>{{ $offerletterData->notice_period ?? '' }}</b> days.
                                    </p>
                                    <p class="text-justify"><b>{!! $offerletterData->addiitonal_comment ?? '' !!}</b></p>
                                    <p class="text-justify">You will be required, during and after the term of this
                                        Internship, not to reveal any confidential information or secret to any person,
                                        firm, corporation, or entity. You will be required to work full-time with the
                                        Company and during this Internship, will not engage in any other business
                                        activity, regardless of whether that activity is pursued for profit, gain or any
                                        other monetary advantage. In case of breach of this condition the Company can
                                        take action against the same, which may be or legal in nature.</p>
                                    <p class="text-justify">If, at any time in future, it comes to the knowledge of the
                                        management that any of the information furnished in your application for
                                        Internship is incorrect or any relevant information has been withheld then your
                                        Internship based on this letter is liable to be terminated without notice or any
                                        compensation in lieu thereof.</p>
                                    <p>We look forward to working with you.</p>

                                    <p class="ml-2">Sincerely</p>
                                    <img class="logo" src="{{ url('backEnd/priyanka.jpg') }}"
                                        style="margin-left:-17px;" alt="">
                                    <p><b> Priyanka Sharma<br>
                                            Manager - Human Resource<br>
                                            {{ $offerletterData->company_name ?? '' }}</b>
                                    </p>
                                    <p><b>I have read, understood, and agree with the foregoing. I accept Internship on
                                            the above terms and conditions.</b></p>

                                    <div style="display:inline-block; text-align: center; pedding-bottom:20px;">
                                        <hr style=" border:1px solid black" class="">
                                        <p>Intern Signature</p>
                                    </div>
                                    <div style="display:inline-block; margin-left: 10px; text-align: center;">
                                        <hr style=" border:1px solid black" class="">
                                        <p class="ml-4 mr-4">Date</p>
                                    </div>
                                    <div style="display:inline-block; margin-left: 10px; text-align: center;">
                                        <hr style=" border:1px solid black" class="">
                                        <p class="ml-4 mr-4">Place</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
    <!-- Bootstrap Modal -->
    <div class="modal" id="rejectModalFinal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Reject Offer Letter Request</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <form id="rejectForm" action="{{ url('offerletter/statuss', $offerletterData->id) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        <!-- Input fields for the rejection reason -->
                        <div class="form-group">
                            <label for="reason">Reason <span style="color:red;">*</span></label>
                            <textarea class="form-control" name="reject_reason" id="reason" required></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirm Modal (You can customize this if needed) -->
    <div class="modal" id="confirmModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirmation Offer Letter</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="{{ url('offerletter/statuss', $offerletterData->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <!-- Your confirmation message or form can go here -->
                        <p>Are you sure you want to proceed?</p><br>
                        <div class="form-group">
                            <label for="reason">Offer Letter Upload <span style="color:red;">*</span></label>
                            <input class="form-control" type="file" name="attachment" required>
                        </div>
                        <div class="form-group">
                            <label for="reason">Comment <span style="color:red;">*</span></label>
                            <textarea class="form-control" name="comment" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <!--Page Active Scripts(used by this page)-->
    <script src="{{ url('backEnd/dist/js/pages/forms-basic.active.js') }}"></script>
    <!--Page Scripts(used by all page)-->
    <script src="{{ url('backEnd/dist/js/sidebar.js') }}"></script>
    <script>
        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

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
    <script>
        var msg = '{{ session('alert') }}';
        var exist = '{{ session()->has('alert') }}';

        if (exist) {
            showAlert(msg);
        }

        function showAlert(message) {
            var alertContainer = document.getElementById('alert-container');
            alertContainer.textContent = message;

            // Determine the background color based on the message content
            var backgroundColor = message.includes('Rejected') ? '#dc3545' : (message.includes('Confirmed') ? '#28a745' :
                '#000000');

            alertContainer.style.backgroundColor = backgroundColor;
            alertContainer.style.color = 'white'; // Set your desired text color for the alert
            alertContainer.style.display = 'block';

            // Hide the alert after 2 seconds
            setTimeout(function() {
                alertContainer.style.display = 'none';
            }, 5000); // Adjust the time as needed
        }
    </script>


</body>

</html>
