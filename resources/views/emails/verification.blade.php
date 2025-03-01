<!DOCTYPE html>
<html>
<head>
    <title>Xác thực email</title>
</head>
<body>
    <h2>Xin chào {{ $user->name }}</h2>
    <p>Vui lòng click vào link bên dưới để xác thực email của bạn:</p>
    <a href="{{ url('/api/verify-email/' . $user->verification_token) }}">
        Xác thực email
    </a>
</body>
</html>
