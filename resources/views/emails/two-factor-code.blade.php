<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">

    <title>Verification Code</title>
</head>

<body style="
    margin:0;
    padding:0;
    background:#f5f7fb;
    font-family:Arial, Helvetica, sans-serif;
">

    <div
        style="
    max-width:600px;
    margin:40px auto;
    background:#ffffff;
    border-radius:12px;
    padding:40px;
">

        <h2 style="margin-top:0;">
            Two-Factor Authentication
        </h2>

        <p>
            Hello {{ $user->name }},
        </p>

        <p>
            We received a login attempt for your account.
            Please use the verification code below:
        </p>

        <div style="
        text-align:center;
        margin:30px 0;
    ">
            <span
                style="
            display:inline-block;
            padding:15px 25px;
            background:#f1f3f5;
            border-radius:8px;
            font-size:32px;
            font-weight:bold;
            letter-spacing:8px;
        ">
                {{ $code }}
            </span>
        </div>

        <p>
            This code will expire at
            <strong>{{ $expiresAt->format('H:i') }}</strong>.
        </p>

        <p>
            If you did not attempt to log in, you can safely ignore this email.
        </p>

        <hr>

        <p style="color:#6c757d;font-size:14px;">
            {{ config('app.name') }}
        </p>

    </div>

</body>

</html>
