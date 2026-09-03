<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />

    <title>Reset Password</title>
</head>

<body style="font-family: Arial, sans-serif">
    <h2>Reset Your Password</h2>

    <p>You requested to reset your password.</p>

    <p>Click the button below to create a new password:</p>

    <p>
        <a
            href="{{ $resetUrl }}"
            style="
                display: inline-block;
                padding: 12px 24px;
                background-color: #2563eb;
                color: white;
                text-decoration: none;
                border-radius: 6px;
                font-weight: bold;
            "
        >
            Reset Password
        </a>
    </p>

    <p>This link will expire in 60 minutes.</p>

    <p>If you did not request a password reset, you can safely ignore this email.</p>
</body>
</html>
