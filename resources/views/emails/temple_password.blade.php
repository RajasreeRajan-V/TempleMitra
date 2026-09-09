<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Temple Registration - Login Credentials</title>
</head>

<body style="
    margin: 0;
    padding: 0;
    background-color: #f5f5f5;
    font-family: Arial, Helvetica, sans-serif;
">

    <div style="
        max-width: 600px;
        margin: 40px auto;
        background: #ffffff;
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    ">

        <h2 style="color: #6b1f2b; margin-top: 0;">
            Temple Registration Successful
        </h2>

        <p>
            Dear <strong>{{ $temple->temple_name }}</strong>,
        </p>

        <p>
            Your temple registration has been successfully completed.
            Your login credentials are given below.
        </p>

        <!-- Login Credentials -->
        <div style="
            background: #f8f8f8;
            border: 1px solid #e5e5e5;
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
        ">

            <p style="margin: 0 0 12px;">
                <strong>Email:</strong>
                {{ $temple->email }}
            </p>

            <p style="margin: 0;">
                <strong>Password:</strong>
                {{ $plainPassword }}
            </p>

        </div>

        <!-- Login Button -->
        <p style="margin: 20px 0 8px;">
            <strong>Login to your account:</strong>
        </p>

        <p>
            <a href="{{ route('login') }}"
               style="
                   display: inline-block;
                   padding: 12px 22px;
                   background-color: #6b1f2b;
                   color: #ffffff;
                   text-decoration: none;
                   border-radius: 6px;
                   font-weight: bold;
               ">
                Login to Your Account
            </a>
        </p>

        <p>
            Please keep these login credentials secure.
        </p>

        <p>
            Regards,<br>
            <strong>Administration</strong>
        </p>

    </div>

</body>
</html>