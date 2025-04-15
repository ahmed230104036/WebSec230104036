<!DOCTYPE html>
<html lang="en">
<body>
    <p>Dear {{$name}},</p>
    <p>You have requested to reset your password. Click the link below to reset it:</p>
    <p><a href="{{$resetLink}}" target='_blank'>Reset Password</a></p>
    <p>This link will expire in 60 minutes.</p>
    <p>If you did not request this password reset, please ignore this email.</p>
</body>
</html> 