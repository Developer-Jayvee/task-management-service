<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f4f4f5;
            color: #333333;
        }

        .email-container {
            max-width: 600px;
            margin: 40px auto;
            padding: 40px 30px;
            background-color: #ffffff;
            border-radius: 10px;
            text-align: center;
            box-sizing: border-box;
        }

        .email-title {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #18181b;
        }

        .email-description {
            font-size: 16px;
            line-height: 1.6;
            color: #52525b;
            margin-bottom: 30px;
        }

        .reset-button {
            display: inline-block;
            padding: 16px 40px;
            background-color: #2563eb;
            color: #ffffff !important;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            border-radius: 6px;
            margin-bottom: 25px;
        }

        .reset-button:hover {
            background-color: #1d4ed8;
        }

        .security-notice {
            font-size: 13px;
            line-height: 1.6;
            color: #71717a;
            margin-top: 20px;
        }

        .email-footer {
            margin-top: 30px;
            font-size: 12px;
            color: #a1a1aa;
        }
    </style>
</head>
<body>
    <div class="email-container">

        <h1 class="email-title">Reset Password</h1>

        <p class="email-description">
            We received a request to reset your password.
            Click the button below to create a new password for your account.
        </p>

        <a href="{{ $resetLink }}" class="reset-button">
            Reset Password
        </a>

        <p class="security-notice">
            If you did not request a password reset, you can safely ignore
            this email. Your password will remain unchanged.
        </p>

        <div class="email-footer">
            &copy; {{ date('Y') }} Your Application. All rights reserved.
        </div>

    </div>
</body>
</html>