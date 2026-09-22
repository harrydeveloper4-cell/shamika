<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e2e8f0; border-radius: 8px; }
        .header { background: #0284c7; color: white; padding: 15px; text-align: center; border-radius: 6px 6px 0 0; }
        .content { padding: 20px; }
        .footer { font-size: 12px; color: #718096; text-align: center; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Welcome to {{ config('app.name') }}</h2>
        </div>
        <div class="content">
            <p>Hi {{ $user->name }},</p>

            {{__
            @if($role === 'vendor')
                <p>Your <strong>Vendor</strong> account has been successfully created!</p>
                <p>Please note that your account is currently under review. Once the administrator approves your profile, your account will become active and you will get full access.</p>
            @else
                <p>Your <strong>Renter</strong> account has been created successfully!</p>
                <p>You can now browse properties and start making bookings right away.</p>
            @endif
            --}}
            <p>Your <strong>{{ ucfirst($role) }}</strong> account has been created successfully!</p>
            <p>You can now browse properties and @if($role === 'vendor') publish your properties @else start making bookings right away. @endif</p>

            <p>Thank you for joining us!</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </div>
</body>
</html>