<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Expertaff</title>
    <style>
        /* Add CSS styles here to style the email template */
        body {
            font-family: Arial, sans-serif;
            background-color: #edf2f7;
            padding: 20px;
        }

        .main {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 4px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        p {

            font-size: 15px;

        }

        .button-container {
            margin-top: 30px;
            display: flex;
            justify-content: center;
        }

        .button {
            display: inline-block;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            padding: 08px 08px;
            border-radius: 4px;
        }


        .content {
            margin-top: 30px;
        }

        .text_color {
            color: blue;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="header" style="display: flex; justify-content: center;">
        <h4>Expertaff</h4>
    </div>
    <div class="main">
        <div class="content">
            <p>Hello {{ $userName }},</p>
            <p>Your Review has been successfully added.We welcome you to Expertaff</p>
        </div>
        <div>
            <p>Review Details:</p>
            <ul class="text_color">
                <li>User Name:{{ $userName }}</li>
                <li>User Email:{{ $userEmail }}</li>
                <li>Review Text:{{ $reviewText }}</li>
            </ul>
        </div>
        <div>
            <p>Please Confirm that this review has been given by you
            </p>
        </div>
        <div class="button-container">
            <a href="{{ url('/') }}/verifyreview/{{ $token }}" class="button"
                style="margin-right: 2rem;">Yes</a>
            <a href="{{ url('/') }}/rejectreview/{{ $token }}" class="button">No</a>
        </div>
    </div>
    <div class="footer" style="display: flex; justify-content: center;">
        <p style="color:#b0adc5;"> © 2023 Expertaff. All rights reserved.</p>
    </div>
</body>

</html>
