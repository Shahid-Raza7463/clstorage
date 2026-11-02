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
            <p>Your account has been successfully created.We welcome you to Expertaff</p>
        </div>
        <div>
            <p>Your User Name:<span class="text_color"> {{ $userName }}</span></p>
            <p>Your User Email:<span class="text_color"> {{ $userEmail }}</span></p>
        </div>
        <div>
            <p>It's our privilege to have you as our User. We are pretty much sure that you will love the fact that how
                simple it is to get started with the services. We are dedicated to making your working life simpler.
            </p>
        </div>
    </div>
    <div class="footer" style="display: flex; justify-content: center;">
        <p style="color:#b0adc5;"> © 2023 Expertaff. All rights reserved.</p>
    </div>
</body>

</html>
