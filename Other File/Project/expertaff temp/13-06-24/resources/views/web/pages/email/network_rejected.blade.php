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

        .container {
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

        h2 {
            color: #555555;
            margin-top: 0;
        }

        .content {
            margin-top: 30px;
        }

        .button-container {
            margin-top: 30px;
            display: flex;
            justify-content: center;
        }

        .helpText {
            display: flex;
            justify-content: center;
            margin-top: 2rem;
        }

        .button {
            display: inline-block;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            padding: 08px 08px;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <div class="header" style="display: flex; justify-content: center;">
        <h4>Expertaff</h4>
    </div>
    <div class="container">
        <div class="content">
            <p>Subject: Account Rejection</p>
            <p>Dear {{ $userName }},</p>
            <p> We regret to inform you that your account has been rejected. We appreciate your interest, but after
                careful
                consideration, we have determined that your account does not meet our requirements at this time.</p>
            <p> We understand that this decision may be disappointing for you. If you believe there has been a mistake
                or if you
                have any questions, please feel free to contact our support team. We'll be happy to assist you.</p>
            <p>Thank you for your understanding.</p>
            <p> Best regards,</p>
        </div>
    </div>
    <div class="footer" style="display: flex; justify-content: center;">
        <p style="color:#b0adc5;"> © 2023 Expertaff. All rights reserved.</p>
    </div>
</body>

</html>
