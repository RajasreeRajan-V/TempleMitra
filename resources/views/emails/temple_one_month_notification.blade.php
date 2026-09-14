<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>TempleMitra Notification</title>
</head>

<body style="margin:0; padding:0; background:#f5f2ee; font-family:Arial, sans-serif;">

<div style="max-width:600px; margin:30px auto; background:#ffffff; border-radius:10px; overflow:hidden;">

    <div style="background:#6d1835; color:#ffffff; padding:25px; text-align:center;">
        <h1 style="margin:0;">
            {{ config('app.name', 'TempleMitra') }}
        </h1>
    </div>

    <div style="padding:30px;">

        @if($isAdmin)

            <h2>Temple Registration Notification</h2>

            <p>
                This is to notify you that the following temple has
                completed one month since registration.
            </p>

        @else

            <h2>One Month Registration Reminder</h2>

            <p>
                Dear {{ $temple->temple_name }},
            </p>

            <p>
                Your temple has successfully completed one month
                since its registration with
                {{ config('app.name', 'TempleMitra') }}.
            </p>

        @endif

        <div style="background:#f8f5f1; padding:20px; border-radius:8px; margin:20px 0;">

            <p>
                <strong>Temple Name:</strong>
                {{ $temple->temple_name }}
            </p>

            <p>
                <strong>District:</strong>
                {{ $temple->district }}
            </p>

            <p>
                <strong>Registration Date:</strong>
                {{ $temple->created_at->format('d M Y') }}
            </p>

            @if($temple->registration_number)
                <p>
                    <strong>Registration Number:</strong>
                    {{ $temple->registration_number }}
                </p>
            @endif

        </div>

        @if($isAdmin)

            <p>
                Please review the temple registration details from
                the admin dashboard.
            </p>

        @else

            <p>
                Thank you for being part of
                {{ config('app.name', 'TempleMitra') }}.
            </p>

        @endif

        <p>
            Regards,<br>
            <strong>{{ config('app.name', 'TempleMitra') }}</strong>
        </p>

    </div>

</div>

</body>
</html>