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
            <p>Hello {{ $user_name }},</p>
            <p>Your account has been successfully created.Please verify your Details</p>
            <div class="network-container" style="display: flex;">
                <div>
                    <p>Affiliate Network Name:{{ $network_name }}</p>
                    @if ($network_type == 1)
                        <p>Your Network Type: Affiliate Network</p>
                    @elseif ($network_type == 2)
                        <p>Your Network Type: Affiliate Program</p>
                    @else
                        <p>Your Network Type: Advertising</p>
                    @endif
                    <p>Referral Commission:{{ $referral_commission }}</p>
                    <p>Affiliate Tracking Software:{{ $affiliate_tracking_software }}</p>
                </div>
                <div style="margin-left: 5rem;">
                    <p>Network URL:{{ $network_url }}</p>
                    <p>Offers Count:{{ $offer_count }}</p>
                    <p>Min Payout:{{ $min_payout }}</p>
                </div>
            </div>
        </div>
        <div class="button-container">
            <a href="{{ url('/') }}/afternetworkverify" class="button">Yes, I Confirm</a>
        </div>
        <div class="helpText">
            <a href="#">
                <span>For Update:Please Contact on shahidraza7463@gmail.com</span>
            </a>
        </div>
    </div>
    <div class="footer" style="display: flex; justify-content: center;">
        <p style="color:#b0adc5;"> © 2023 Expertaff. All rights reserved.</p>
    </div>
</body>

</html>
