<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <h1>Reset Your Password</h1>
    <p>You have requested to reset your password. Click the link below to reset it:</p>
    <a href="{{ route('getTokenOfPass',$token) }}">Reset Password</a>
    <p>If you did not request this, please ignore this email.</p>
</body>
</html>
