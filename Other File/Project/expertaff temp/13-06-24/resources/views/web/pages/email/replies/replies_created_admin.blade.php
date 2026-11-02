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

        .content {
            margin-top: 30px;
        }

        .text_color {
            color: blue;
        }
    </style>
</head>

<body>
    <div class="header" style="display: flex; justify-content: center;">
        <h4>Expertaff</h4>
    </div>
    <div class="main">
        <div class="content">
            <p>Subject: New Review Submission</p>
            <p>Dear Admin,</p>
            <p>We hope this email finds you well. A new review has been submitted on Expertaff and requires your
                attention. As an administrator, your expertise and evaluation are essential in ensuring the platform's
                quality.</p>
        </div>
        <div>
            <p>Review Details:</p>
            <ul class="text_color">
                <li>User Name:{{ $userName }}</li>
                <li>User Email:{{ $userEmail }}</li>
                <li>Review Text:{{ $reviewText }}</li>
            </ul>
        </div>
    </div>
    <div class="footer" style="display: flex; justify-content: center;">
        <p style="color:#b0adc5;"> © 2023 Expertaff. All rights reserved.</p>
    </div>
</body>

</html>
