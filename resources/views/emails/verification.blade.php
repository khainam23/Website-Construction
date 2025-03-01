<!DOCTYPE html>
<html>
<head>
    <title>Email Verification</title>
</head>
<body>
    <h2>Hello {{ $user->name }},</h2>
    <p>Please click the button below to verify your email address:</p>
    
    <a href="{{ url('api/verify-email/' . $user->verification_token) }}" 
       style="background-color: #4CAF50; color: white; padding: 14px 20px; text-decoration: none; border-radius: 4px;">
        Verify Email Address
    </a>

    <p>If you did not create an account, no further action is required.</p>

    <p>Regards,<br>Your Application Team</p>
</body>
</html>
